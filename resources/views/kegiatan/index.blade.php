@extends('layouts.app')

@section('title', 'Agenda & Jadwal Kegiatan RT')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Agenda Kegiatan & Jadwal Ronda RT 03</h3>
            <p class="text-xs text-gray-500 mt-0.5">Informasi kerja bakti, pertemuan bulanan, ronda siskamling, dan aktivitas warga.</p>
        </div>
        @if(Auth::user()->isPengurus())
        <a href="{{ route('kegiatan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-md inline-flex items-center gap-2 self-start sm:self-auto">
            <i class="fas fa-plus-circle"></i> Tambah Kegiatan Baru
        </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('kegiatan.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->hasAny(['kategori', 'status']) ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Semua
        </a>
        <a href="{{ route('kegiatan.index', ['kategori' => 'kerja_bakti']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'kerja_bakti' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Kerja Bakti
        </a>
        <a href="{{ route('kegiatan.index', ['kategori' => 'ronda']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'ronda' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Ronda Malam
        </a>
        <a href="{{ route('kegiatan.index', ['kategori' => 'rapat']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'rapat' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Rapat Warga
        </a>
        <a href="{{ route('kegiatan.index', ['kategori' => 'olahraga']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'olahraga' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Olahraga / Senam
        </a>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kegiatanList as $kg)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover-lift">
            <div class="space-y-3">
                <div class="flex items-center justify-between gap-2">
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-blue-50 text-blue-700">
                        {{ str_replace('_', ' ', $kg->kategori) }}
                    </span>
                    <span class="inline-block text-[11px] font-bold px-2 py-0.5 rounded-full border {{ $kg->status_badge }}">
                        {{ ucfirst($kg->status) }}
                    </span>
                </div>

                <div class="flex items-start gap-3 pt-1">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex flex-col items-center justify-center shrink-0 shadow-sm">
                        <span class="text-[10px] font-bold uppercase">{{ $kg->tanggal_kegiatan->format('M') }}</span>
                        <span class="text-lg font-extrabold leading-none">{{ $kg->tanggal_kegiatan->format('d') }}</span>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900 leading-snug">{{ $kg->nama_kegiatan }}</h4>
                        <span class="text-xs text-gray-400 block mt-0.5">{{ $kg->tanggal_kegiatan->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                </div>

                <p class="text-xs text-gray-600 leading-relaxed pt-1">{{ $kg->deskripsi }}</p>

                <div class="pt-2 text-xs text-gray-500 space-y-1 border-t border-gray-50">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock text-gray-400 w-4"></i>
                        <span>{{ $kg->waktu_mulai }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-location-dot text-gray-400 w-4"></i>
                        <span>{{ $kg->lokasi }}</span>
                    </div>
                    @if($kg->penanggung_jawab)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-tie text-gray-400 w-4"></i>
                        <span>PJ: {{ $kg->penanggung_jawab }}</span>
                    </div>
                    @endif
                </div>
            </div>

            @if(Auth::user()->isPengurus())
            <div class="flex items-center justify-end gap-2 pt-4 mt-4 border-t border-gray-100">
                <a href="{{ route('kegiatan.edit', $kg->id) }}" class="text-xs font-bold text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                    <i class="fas fa-pen mr-1"></i> Edit
                </a>
                <form action="{{ route('kegiatan.destroy', $kg->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus agenda kegiatan ini?')">
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
            <i class="fas fa-calendar-xmark text-4xl block mb-2 text-gray-300"></i>
            Tidak ada agenda kegiatan yang terjadwal pada kategori ini.
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $kegiatanList->links() }}
    </div>
</div>
@endsection
