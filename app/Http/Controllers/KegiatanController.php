<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    /**
     * Tampilkan daftar kegiatan RT.
     */
    public function index(Request $request)
    {
        $query = Kegiatan::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $kegiatanList = $query->orderBy('tanggal_kegiatan', 'asc')->paginate(9)->withQueryString();

        return view('kegiatan.index', compact('kegiatanList'));
    }

    /**
     * Tampilkan form pembuatan kegiatan baru.
     */
    public function create()
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }
        return view('kegiatan.create');
    }

    /**
     * Simpan kegiatan baru ke database.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:kerja_bakti,ronda,rapat,sosial,olahraga,keagamaan,lainnya'],
            'tanggal_kegiatan' => ['required', 'date'],
            'waktu_mulai' => ['required', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:mendatang,berlangsung,selesai,dibatalkan'],
            'deskripsi' => ['required', 'string'],
        ]);

        $validated['created_by'] = Auth::id();

        Kegiatan::create($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Agenda kegiatan berhasil dipublikasikan ke kalender RT.');
    }

    /**
     * Tampilkan form edit kegiatan.
     */
    public function edit(string $id)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update kegiatan.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $kegiatan = Kegiatan::findOrFail($id);

        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:kerja_bakti,ronda,rapat,sosial,olahraga,keagamaan,lainnya'],
            'tanggal_kegiatan' => ['required', 'date'],
            'waktu_mulai' => ['required', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:mendatang,berlangsung,selesai,dibatalkan'],
            'deskripsi' => ['required', 'string'],
        ]);

        $kegiatan->update($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Data agenda kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus kegiatan.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Agenda kegiatan berhasil dihapus.');
    }
}
