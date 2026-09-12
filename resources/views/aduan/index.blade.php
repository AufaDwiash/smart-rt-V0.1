@extends('layouts.app')

@section('title', 'Aspirasi & Aduan Warga')

@section('content')
<div class="space-y-6">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Menunggu Tindak Lanjut</span>
                <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $countPending }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Sedang Ditangani</span>
                <span class="text-2xl font-extrabold text-blue-600 mt-1 block">{{ $countDiproses }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fas fa-screwdriver-wrench"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Tuntas / Selesai</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $countSelesai }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Layanan Aduan & Aspirasi Lingkungan RT 03</h3>
                <p class="text-xs text-gray-500 mt-0.5">Sampaikan kendala fasilitas, ketertiban, dan kebersihan untuk kenyamanan bersama.</p>
            </div>
            <a href="{{ route('aduan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-md inline-flex items-center gap-2 self-start sm:self-auto">
                <i class="fas fa-plus-circle"></i> Tulis Aduan Baru
            </a>
        </div>

        <!-- Warga Tab & Filter -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
            @if(Auth::user()->isWarga())
            <div class="flex gap-2">
                <a href="{{ route('aduan.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->has('tab') ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua Aduan RT
                </a>
                <a href="{{ route('aduan.index', ['tab' => 'saya']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('tab') === 'saya' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Aduan Saya
                </a>
            </div>
            @endif

            <!-- Filters -->
            <form method="GET" action="{{ route('aduan.index') }}" class="flex flex-wrap items-center gap-2 ml-auto">
                @if(request('tab'))
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                @endif
                <select name="status" class="py-1.5 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <select name="kategori" class="py-1.5 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Kategori --</option>
                    <option value="keamanan" {{ request('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                    <option value="kebersihan" {{ request('kategori') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="fasilitas" {{ request('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                    <option value="kebisingan" {{ request('kategori') == 'kebisingan' ? 'selected' : '' }}>Kebisingan</option>
                    <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-1.5 px-3 rounded-xl text-xs transition">
                    Filter
                </button>
            </form>
        </div>

        <!-- Aduan Cards List -->
        <div class="space-y-4">
            @forelse($aduanList as $aduan)
            <div class="p-5 rounded-2xl border border-gray-100 hover:border-blue-200 transition bg-white shadow-sm flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div class="space-y-2 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-blue-50 text-blue-700">
                            {{ $aduan->kategori }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $aduan->created_at->diffForHumans() }} &bull; Oleh: <strong>{{ $aduan->user->nama_lengkap }}</strong>
                        </span>
                    </div>

                    <h4 class="text-base font-bold text-gray-900">{{ $aduan->judul }}</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $aduan->isi_aduan }}</p>

                    @if($aduan->tanggapan_rt)
                    <div class="mt-3 p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 text-xs text-blue-900">
                        <div class="font-bold mb-0.5 flex items-center gap-1.5">
                            <i class="fas fa-reply text-blue-600"></i> Tanggapan Pengurus RT:
                        </div>
                        <p>{{ $aduan->tanggapan_rt }}</p>
                    </div>
                    @endif
                </div>

                <div class="flex md:flex-col items-center md:items-end justify-between md:justify-start gap-3 shrink-0 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100">
                    <span class="inline-block text-xs font-bold px-3 py-1 rounded-full border {{ $aduan->status_badge }}">
                        {{ ucfirst($aduan->status) }}
                    </span>

                    <a href="{{ route('aduan.show', $aduan->id) }}" class="text-xs font-bold bg-blue-50 hover:bg-blue-100 text-blue-600 px-3.5 py-1.5 rounded-lg transition">
                        {{ Auth::user()->isPengurus() ? 'Tanggapi / Detail →' : 'Lihat Detail →' }}
                    </a>
                </div>
            </div>
            @empty
            <div class="py-12 text-center text-gray-400 text-xs">
                <i class="fas fa-comment-slash text-4xl block mb-2 text-gray-300"></i>
                Belum ada laporan aduan yang sesuai filter.
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $aduanList->links() }}
        </div>
    </div>
</div>
@endsection
