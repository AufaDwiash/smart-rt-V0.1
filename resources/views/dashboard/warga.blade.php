@extends('layouts.app')

@section('title', 'Portal Warga')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header for Resident -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md text-xs font-semibold px-3 py-1 rounded-full text-blue-50 mb-3">
                <i class="fas fa-home"></i> Warga RT 03 / RW 02
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Halo, {{ Auth::user()->nama_lengkap }}!
            </h1>
            <p class="text-blue-100 text-sm mt-1 max-w-xl">
                Ajukan surat keterangan resmi, kirimkan aspirasi atau aduan lingkungan, dan ikuti agenda kegiatan RT secara digital dari genggaman Anda.
            </p>
            <div class="flex flex-wrap gap-3 mt-5">
                <a href="{{ route('surat.create') }}" class="bg-white text-blue-700 hover:bg-blue-50 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-md inline-flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> Ajukan Surat Pengantar
                </a>
                <a href="{{ route('aduan.create') }}" class="bg-blue-500/30 hover:bg-blue-500/50 text-white border border-white/30 font-bold px-4 py-2.5 rounded-xl text-xs transition inline-flex items-center gap-2">
                    <i class="fas fa-bullhorn"></i> Kirim Aduan Warga
                </a>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl">
            <i class="fas fa-file-shield"></i>
        </div>
    </div>

    <!-- 3 Summary Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-file-lines"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Surat Diajukan</span>
                <h3 class="text-2xl font-extrabold text-gray-900">{{ $totalSuratSaya }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Surat Disetujui</span>
                <h3 class="text-2xl font-extrabold text-emerald-600">{{ $suratSiapUnduh }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-comment-dots"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase">Aduan Terkirim</span>
                <h3 class="text-2xl font-extrabold text-gray-900">{{ $totalAduanSaya }}</h3>
            </div>
        </div>
    </div>

    <!-- 2 Column Layout: My Letters & My Complaints -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Surat Saya (2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Permohonan Surat Saya -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-file-signature text-blue-600"></i> Riwayat Pengajuan Surat Saya
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Pantau status proses pengajuan dan unduh surat resmi</p>
                    </div>
                    <a href="{{ route('surat.create') }}" class="text-xs font-bold text-blue-600 hover:underline">
                        + Buat Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                            <tr>
                                <th class="py-3 px-4 rounded-l-xl">Jenis Surat</th>
                                <th class="py-3 px-4">Tanggal Pengajuan</th>
                                <th class="py-3 px-4">Nomor Surat</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($suratSaya as $st)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3.5 px-4 font-semibold text-gray-900">
                                    {{ $st->suratTemplate->nama_surat }}
                                    <span class="block text-xs font-normal text-gray-400">Keperluan: {{ Str::limit($st->keperluan, 30) }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">
                                    {{ $st->tanggal_pengajuan ? $st->tanggal_pengajuan->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-xs font-mono text-gray-600">
                                    {{ $st->nomor_surat ?? '(menunggu RT)' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-block text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $st->status_badge }}">
                                        {{ ucfirst($st->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('surat.show', $st->id) }}" class="text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-700 px-2.5 py-1.5 rounded-lg transition" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(in_array($st->status, ['disetujui', 'selesai']))
                                        <a href="{{ route('surat.cetak', $st->id) }}" target="_blank" class="text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white px-2.5 py-1.5 rounded-lg transition" title="Unduh PDF Resmi">
                                            <i class="fas fa-download mr-1"></i> PDF
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fas fa-file-pen text-3xl block mb-2 text-gray-300"></i>
                                    Anda belum pernah mengajukan surat pengantar.<br>
                                    <a href="{{ route('surat.create') }}" class="text-blue-600 font-bold underline mt-1 inline-block">Klik di sini untuk mengajukan surat</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Aduan Warga Saya -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-bullhorn text-rose-600"></i> Aduan & Aspirasi Saya
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Status respon dan tindak lanjut pengurus RT atas aduan Anda</p>
                    </div>
                    <a href="{{ route('aduan.create') }}" class="text-xs font-bold text-blue-600 hover:underline">
                        + Buat Aduan
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($aduanSaya as $ad)
                    <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/50">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-gray-200 text-gray-700 mb-1">
                                    {{ $ad->kategori }}
                                </span>
                                <h4 class="text-sm font-bold text-gray-900">{{ $ad->judul }}</h4>
                                <p class="text-xs text-gray-600 mt-1">{{ $ad->isi_aduan }}</p>

                                @if($ad->tanggapan_rt)
                                <div class="mt-3 p-3 rounded-xl bg-blue-50 border border-blue-100 text-xs text-blue-900">
                                    <strong><i class="fas fa-reply mr-1"></i> Tanggapan Pengurus RT:</strong>
                                    <p class="mt-0.5">{{ $ad->tanggapan_rt }}</p>
                                </div>
                                @endif
                            </div>
                            <span class="inline-block text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $ad->status_badge }} shrink-0">
                                {{ ucfirst($ad->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="py-6 text-center text-gray-400 text-xs">
                        Belum ada aduan atau aspirasi yang Anda kirimkan.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Pengumuman & Agenda (1 Col) -->
        <div class="space-y-8">
            <!-- Pengumuman RT -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-newspaper text-blue-600"></i> Pengumuman RT
                    </h3>
                    <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($pengumumanTerbaru as $pengumuman)
                    <div class="p-3.5 rounded-2xl bg-blue-50/40 border border-blue-100">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700 block mb-1">
                            {{ $pengumuman->kategori }} &bull; {{ $pengumuman->tanggal_publish ? $pengumuman->tanggal_publish->diffForHumans() : '' }}
                        </span>
                        <h5 class="text-xs font-bold text-gray-900">{{ $pengumuman->judul }}</h5>
                        <p class="text-[11px] text-gray-600 mt-1 line-clamp-2">{{ $pengumuman->isi }}</p>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </div>

            <!-- Agenda Mendatang -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-calendar-days text-purple-600"></i> Kegiatan Warga
                    </h3>
                    <a href="{{ route('kegiatan.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($kegiatanTerbaru as $kg)
                    <div class="p-3.5 rounded-2xl bg-purple-50/40 border border-purple-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex flex-col items-center justify-center shrink-0">
                            <span class="text-[9px] uppercase font-bold">{{ $kg->tanggal_kegiatan->format('M') }}</span>
                            <span class="text-sm font-extrabold leading-none">{{ $kg->tanggal_kegiatan->format('d') }}</span>
                        </div>
                        <div class="overflow-hidden">
                            <h5 class="text-xs font-bold text-gray-900 truncate">{{ $kg->nama_kegiatan }}</h5>
                            <p class="text-[11px] text-gray-500 mt-0.5"><i class="fas fa-clock text-[9px] mr-1"></i> {{ $kg->waktu_mulai }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">Tidak ada agenda kegiatan terdekat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
