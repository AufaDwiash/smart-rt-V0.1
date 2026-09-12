<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    /**
     * Tampilkan daftar data warga dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian berdasarkan NIK atau Nama Lengkap
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%");
            });
        }

        // Filter status warga (tetap, kontrak, pindah)
        if ($request->filled('status_warga')) {
            $query->where('status_warga', $request->input('status_warga'));
        }

        // Filter status keluarga
        if ($request->filled('status_keluarga')) {
            $query->where('status_keluarga', $request->input('status_keluarga'));
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $wargaList = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();

        $totalWarga = User::count();
        $totalTetap = User::where('status_warga', 'tetap')->count();
        $totalKontrak = User::where('status_warga', 'kontrak')->count();
        $totalKK = KartuKeluarga::count();

        return view('warga.index', compact(
            'wargaList',
            'totalWarga',
            'totalTetap',
            'totalKontrak',
            'totalKK'
        ));
    }

    /**
     * Tampilkan form penambahan warga baru.
     */
    public function create()
    {
        $kkList = KartuKeluarga::orderBy('no_kk', 'asc')->get();
        return view('warga.create', compact('kkList'));
    }

    /**
     * Simpan data warga baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'no_kk' => ['nullable', 'string', 'size:16'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:admin,rt,sekretaris,bendahara,warga'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'agama' => ['nullable', 'string', 'max:30'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
            'status_keluarga' => ['nullable', 'in:Kepala Keluarga,Istri,Anak,Anggota Lain'],
            'status_warga' => ['required', 'in:tetap,kontrak,pindah'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK sudah digunakan warga lain.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Password wajib dibuat.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Auto create KK jika belum tercatat
        if (!empty($validated['no_kk'])) {
            KartuKeluarga::firstOrCreate(
                ['no_kk' => $validated['no_kk']],
                [
                    'kepala_keluarga_nama' => $validated['nama_lengkap'],
                    'alamat' => $validated['alamat'],
                    'rt' => $validated['rt'] ?? '03',
                    'rw' => $validated['rw'] ?? '02',
                ]
            );
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['status_akun'] = 'aktif';

        User::create($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga ' . $validated['nama_lengkap'] . ' berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail data warga dan anggota keluarga satu KK.
     */
    public function show(string $id)
    {
        $warga = User::findOrFail($id);

        // Anggota keluarga yang memiliki nomor KK sama
        $anggotaKeluarga = collect();
        if ($warga->no_kk) {
            $anggotaKeluarga = User::where('no_kk', $warga->no_kk)
                ->where('id', '!=', $warga->id)
                ->get();
        }

        $riwayatSurat = $warga->pengajuanSurat()->with('suratTemplate')->latest()->take(5)->get();
        $riwayatAduan = $warga->aduan()->latest()->take(5)->get();

        return view('warga.show', compact('warga', 'anggotaKeluarga', 'riwayatSurat', 'riwayatAduan'));
    }

    /**
     * Tampilkan form edit data warga.
     */
    public function edit(string $id)
    {
        $warga = User::findOrFail($id);
        $kkList = KartuKeluarga::orderBy('no_kk', 'asc')->get();
        return view('warga.edit', compact('warga', 'kkList'));
    }

    /**
     * Update data warga di database.
     */
    public function update(Request $request, string $id)
    {
        $warga = User::findOrFail($id);

        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', Rule::unique('users')->ignore($warga->id)],
            'no_kk' => ['nullable', 'string', 'size:16'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($warga->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:admin,rt,sekretaris,bendahara,warga'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'agama' => ['nullable', 'string', 'max:30'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
            'status_keluarga' => ['nullable', 'in:Kepala Keluarga,Istri,Anak,Anggota Lain'],
            'status_warga' => ['required', 'in:tetap,kontrak,pindah'],
            'status_akun' => ['required', 'in:aktif,nonaktif'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Sinkronisasi data KK
        if (!empty($validated['no_kk'])) {
            KartuKeluarga::firstOrCreate(
                ['no_kk' => $validated['no_kk']],
                [
                    'kepala_keluarga_nama' => $validated['nama_lengkap'],
                    'alamat' => $validated['alamat'],
                    'rt' => $validated['rt'] ?? '03',
                    'rw' => $validated['rw'] ?? '02',
                ]
            );
        }

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga ' . $warga->nama_lengkap . ' berhasil diperbarui.');
    }

    /**
     * Hapus data warga.
     */
    public function destroy(string $id)
    {
        $warga = User::findOrFail($id);

        if ($warga->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $warga->nama_lengkap;
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data warga ' . $nama . ' berhasil dihapus.');
    }
}
