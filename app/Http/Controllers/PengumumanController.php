<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    /**
     * Tampilkan daftar pengumuman warga.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Pengumuman::with('creator');

        if ($user->isWarga()) {
            $query->where('is_published', true);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        $pengumumanList = $query->latest('tanggal_publish')->paginate(8)->withQueryString();

        return view('pengumuman.index', compact('pengumumanList'));
    }

    /**
     * Tampilkan form pembuatan pengumuman baru.
     */
    public function create()
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }
        return view('pengumuman.create');
    }

    /**
     * Simpan pengumuman baru ke database.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:50'],
            'isi' => ['required', 'string'],
            'is_published' => ['required', 'boolean'],
            'tanggal_publish' => ['required', 'date'],
        ]);

        $validated['created_by'] = Auth::id();

        Pengumuman::create($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman resmi RT berhasil dipublikasikan.');
    }

    /**
     * Tampilkan form edit pengumuman.
     */
    public function edit(string $id)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $pengumuman = Pengumuman::findOrFail($id);
        return view('pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update pengumuman.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $pengumuman = Pengumuman::findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:50'],
            'isi' => ['required', 'string'],
            'is_published' => ['required', 'boolean'],
            'tanggal_publish' => ['required', 'date'],
        ]);

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Hapus pengumuman.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->isPengurus()) {
            abort(403);
        }

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
