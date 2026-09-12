<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanController extends Controller
{
    /**
     * Tampilkan daftar aduan warga.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Aduan::with('user');

        // Jika warga ingin memfilter hanya aduan miliknya atau melihat semua aduan lingkungan
        if ($user->isWarga() && $request->get('tab') === 'saya') {
            $query->where('user_id', $user->id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $aduanList = $query->latest()->paginate(10)->withQueryString();

        $countPending = Aduan::where('status', 'pending')->count();
        $countDiproses = Aduan::where('status', 'diproses')->count();
        $countSelesai = Aduan::where('status', 'selesai')->count();

        return view('aduan.index', compact(
            'aduanList',
            'countPending',
            'countDiproses',
            'countSelesai'
        ));
    }

    /**
     * Tampilkan form pembuatan aduan baru.
     */
    public function create()
    {
        return view('aduan.create');
    }

    /**
     * Simpan aduan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:keamanan,kebersihan,fasilitas,kebisingan,lainnya'],
            'isi_aduan' => ['required', 'string', 'min:10'],
            'foto_aduan' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:3072'],
        ], [
            'judul.required' => 'Judul aduan wajib diisi.',
            'kategori.required' => 'Pilih kategori aduan.',
            'isi_aduan.required' => 'Uraikan aduan Anda secara detail.',
            'isi_aduan.min' => 'Isi aduan minimal 10 karakter.',
            'foto_aduan.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_aduan')) {
            $fotoPath = $request->file('foto_aduan')->store('aduan_foto', 'public');
        }

        $aduan = Aduan::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'isi_aduan' => $validated['isi_aduan'],
            'foto_aduan' => $fotoPath,
            'status' => 'pending',
        ]);

        // Notifikasi ke Pengurus
        $admins = User::whereIn('role', ['admin', 'rt'])->get();
        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'judul' => 'Aduan Warga Baru',
                'pesan' => Auth::user()->nama_lengkap . ' mengirimkan laporan: "' . $aduan->judul . '".',
                'link' => route('aduan.show', $aduan->id, false),
                'is_read' => false,
            ]);
        }

        return redirect()->route('aduan.index')->with('success', 'Laporan aduan berhasil dikirimkan. Pengurus RT akan menindaklanjutinya.');
    }

    /**
     * Tampilkan detail aduan dan panel tanggapan.
     */
    public function show(string $id)
    {
        $aduan = Aduan::with('user')->findOrFail($id);
        return view('aduan.show', compact('aduan'));
    }

    /**
     * Simpan tanggapan dan update status aduan oleh Pengurus RT.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->isPengurus()) {
            abort(403, 'Hanya pengurus RT yang dapat menanggapi laporan aduan.');
        }

        $aduan = Aduan::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,diproses,selesai'],
            'tanggapan_rt' => ['required', 'string'],
        ], [
            'status.required' => 'Pilih status tindak lanjut.',
            'tanggapan_rt.required' => 'Tuliskan tanggapan atau tindakan penanganan dari RT.',
        ]);

        $aduan->update($validated);

        // Kirim notifikasi ke pelapor
        Notifikasi::create([
            'user_id' => $aduan->user_id,
            'judul' => 'Tanggapan Aduan RT',
            'pesan' => 'Pengurus RT telah menanggapi aduan Anda: "' . $aduan->judul . '". Status: ' . strtoupper($validated['status']) . '.',
            'link' => route('aduan.show', $aduan->id, false),
            'is_read' => false,
        ]);

        return back()->with('success', 'Tanggapan berhasil disimpan dan status aduan diperbarui.');
    }

    /**
     * Hapus laporan aduan.
     */
    public function destroy(string $id)
    {
        $aduan = Aduan::findOrFail($id);
        $user = Auth::user();

        if (!$user->isPengurus() && $aduan->user_id !== $user->id) {
            abort(403);
        }

        $aduan->delete();
        return redirect()->route('aduan.index')->with('success', 'Laporan aduan berhasil dihapus.');
    }
}
