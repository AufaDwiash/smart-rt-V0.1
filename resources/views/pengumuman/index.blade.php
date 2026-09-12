@extends('layouts.app')

@section('title', 'Warta & Pengumuman RT')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Warta & Pengumuman Resmi RT 03</h3>
            <p class="text-xs text-gray-500 mt-0.5">Papan informasi digital untuk warta lingkungan, edaran, dan pengumuman ketua RT.</p>
        </div>
        @if(Auth::user()->isPengurus())
        <a href="{{ route('pengumuman.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-md inline-flex items-center gap-2 self-start sm:self-auto">
            <i class="fas fa-bullhorn"></i> Buat Pengumuman Baru
        </a>
        @endif
    </div>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('pengumuman.index') }}" class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul warta atau pengumuman..."
                class="w-full px-4 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
        </div>

        <div>
            <select name="kategori" class="py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                <option value="">-- Semua Kategori --</option>
                <option value="Umum" {{ request('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                <option value="Kebersihan" {{ request('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                <option value="Keamanan" {{ request('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                <option value="Layanan" {{ request('kategori') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                <option value="Iuran" {{ request('kategori') == 'Iuran' ? 'selected' : '' }}>Iuran</option>
            </select>
        </div>

        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-xl text-xs transition">
            Cari
        </button>
        @if(request()->hasAny(['search', 'kategori']))
        <a href="{{ route('pengumuman.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-3 rounded-xl text-xs transition">
            Reset
        </a>
        @endif
    </form>

    <!-- Announcements Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($pengumumanList as $p)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover-lift">
            <div class="space-y-3">
                <div class="flex items-center justify-between gap-2">
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded bg-blue-50 text-blue-700">
                        {{ $p->kategori }}
                    </span>
                    <div class="flex items-center gap-2">
                        @if(Auth::user()->isPengurus() && !$p->is_published)
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-gray-100 text-gray-500">Draft</span>
                        @endif
                        <span class="text-xs text-gray-400">
                            {{ $p->tanggal_publish ? $p->tanggal_publish->isoFormat('D MMMM Y') : '' }}
                        </span>
                    </div>
                </div>

                <h4 class="text-lg font-bold text-gray-900 leading-snug">{{ $p->judul }}</h4>
                <div class="p-4 rounded-2xl bg-gray-50/70 border border-gray-100 text-xs text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $p->isi }}
                </div>

                <div class="text-[11px] text-gray-400 flex items-center gap-1.5 pt-1">
                    <i class="fas fa-user-pen"></i> Diterbitkan oleh: <strong>{{ $p->creator->nama_lengkap ?? 'Pengurus RT' }}</strong>
                </div>
            </div>

            @if(Auth::user()->isPengurus())
            <div class="flex items-center justify-end gap-2 pt-4 mt-4 border-t border-gray-100">
                <a href="{{ route('pengumuman.edit', $p->id) }}" class="text-xs font-bold text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                    <i class="fas fa-pen mr-1"></i> Edit
                </a>
                <form action="{{ route('pengumuman.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-bold text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-400 text-xs bg-white rounded-3xl border border-gray-100">
            <i class="fas fa-newspaper text-4xl block mb-2 text-gray-300"></i>
            Tidak ada pengumuman yang sesuai kriteria pencarian.
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $pengumumanList->links() }}
    </div>
</div>
@endsection
