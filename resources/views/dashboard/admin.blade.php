@extends('layouts.app')

@section('title', 'Dashboard Pengurus RT')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md text-xs font-semibold px-3 py-1 rounded-full text-blue-50 mb-3">
                <i class="fas fa-calendar-day"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Selamat Datang, {{ Auth::user()->nama_lengkap }}!
            </h1>
            <p class="text-blue-100 text-sm mt-1 max-w-xl">
                Panel kendali administrasi lingkungan RT 03 / RW 02. Pantau permohonan surat warga, laporan aduan, dan pembukuan kas secara real-time.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl">
            <i class="fas fa-microchip"></i>
        </div>
    </div>

    <!-- 4 Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Warga Card -->
        <a href="{{ route('warga.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover-lift block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kependudukan</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-gray-900">{{ $totalWarga }}</h3>
                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                    <span class="font-semibold text-blue-600">{{ $totalKK }} KK</span> terdaftar di RT 03
                </p>
            </div>
        </a>

        <!-- Surat Card -->
        <a href="{{ route('surat.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover-lift block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengajuan Surat</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fas fa-file-signature"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-amber-600">{{ $suratPending }}</h3>
                    <span class="text-xs font-bold text-gray-500">Perlu Diproses</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Total <span class="font-semibold text-green-600">{{ $suratSelesai }} surat</span> telah disetujui
                </p>
            </div>
        </a>

        <!-- Aduan Card -->
        <a href="{{ route('aduan.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover-lift block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Aspirasi & Aduan</span>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fas fa-bullhorn"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-rose-600">{{ $aduanPending }}</h3>
                    <span class="text-xs font-bold text-gray-500">Aduan Baru</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    <span class="font-semibold text-green-600">{{ $aduanSelesai }} aduan</span> telah diselesaikan
                </p>
            </div>
        </a>

        <!-- Kas RT Card -->
        <a href="{{ route('keuangan.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover-lift block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Kas RT</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-extrabold text-emerald-600 truncate">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-gray-500 mt-1 flex items-center justify-between">
                    <span class="text-emerald-700">Masuk: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                </p>
            </div>
        </a>
    </div>

    <!-- Quick Action Shortcut Buttons -->
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('warga.create') }}" class="bg-white border border-gray-200 hover:border-blue-500 hover:bg-blue-50/50 text-gray-800 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-user-plus text-blue-600"></i> Tambah Warga
        </a>
        <a href="{{ route('keuangan.create') }}" class="bg-white border border-gray-200 hover:border-emerald-500 hover:bg-emerald-50/50 text-gray-800 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-money-bill-transfer text-emerald-600"></i> Catat Kas RT
        </a>
        <a href="{{ route('kegiatan.create') }}" class="bg-white border border-gray-200 hover:border-purple-500 hover:bg-purple-50/50 text-gray-800 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-calendar-plus text-purple-600"></i> Tambah Kegiatan
        </a>
        <a href="{{ route('pengumuman.create') }}" class="bg-white border border-gray-200 hover:border-amber-500 hover:bg-amber-50/50 text-gray-800 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-bullhorn text-amber-600"></i> Buat Pengumuman
        </a>
    </div>

    <!-- 2 Columns Data Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Surat & Aduan (2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Permohonan Surat Masuk -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-file-invoice text-blue-600"></i> Permohonan Surat Terbaru
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Daftar warga yang mengajukan surat pengantar</p>
                    </div>
                    <a href="{{ route('surat.index') }}" class="text-xs font-bold text-blue-600 hover:underline">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px] ml-1"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                            <tr>
                                <th class="py-3 px-4 rounded-l-xl">Warga Pemohon</th>
                                <th class="py-3 px-4">Jenis Surat</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($suratTerbaru as $surat)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3.5 px-4 font-semibold text-gray-900">
                                    {{ $surat->user->nama_lengkap }}
                                    <span class="block text-xs font-normal text-gray-400">NIK: {{ $surat->user->nik }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-gray-700 font-medium">
                                    {{ $surat->suratTemplate->nama_surat }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">
                                    {{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-block text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $surat->status_badge }}">
                                        {{ ucfirst($surat->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('surat.show', $surat->id) }}" class="inline-flex items-center gap-1 text-xs font-bold bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                        Periksa <i class="fas fa-chevron-right text-[9px]"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fas fa-folder-open text-3xl block mb-2 text-gray-300"></i>
                                    Belum ada permohonan surat masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Aduan Warga Terbaru -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-bullhorn text-rose-600"></i> Aduan & Masukan Lingkungan
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Laporan terkini terkait kenyamanan dan ketertiban RT</p>
                    </div>
                    <a href="{{ route('aduan.index') }}" class="text-xs font-bold text-blue-600 hover:underline">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px] ml-1"></i>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($aduanTerbaru as $aduan)
                    <div class="p-4 rounded-2xl border border-gray-100 hover:border-blue-200 transition bg-gray-50/40">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-gray-200 text-gray-700 mb-1">
                                    {{ $aduan->kategori }}
                                </span>
                                <h4 class="text-sm font-bold text-gray-900">{{ $aduan->judul }}</h4>
                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $aduan->isi_aduan }}</p>
                                <div class="text-[11px] text-gray-400 mt-2 flex items-center gap-3">
                                    <span><i class="fas fa-user text-gray-300 mr-1"></i> {{ $aduan->user->nama_lengkap }}</span>
                                    <span><i class="fas fa-clock text-gray-300 mr-1"></i> {{ $aduan->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="inline-block text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $aduan->status_badge }} mb-2">
                                    {{ ucfirst($aduan->status) }}
                                </span>
                                <div>
                                    <a href="{{ route('aduan.show', $aduan->id) }}" class="text-xs font-bold text-blue-600 hover:underline">
                                        Tanggapi →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-gray-400 text-xs">
                        <i class="fas fa-comments text-3xl block mb-2 text-gray-300"></i>
                        Belum ada aduan warga yang masuk.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Kegiatan & Kas Preview (1 Col) -->
        <div class="space-y-8">
            <!-- Agenda Mendatang -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-purple-600"></i> Agenda Kegiatan RT
                    </h3>
                    <a href="{{ route('kegiatan.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($kegiatanMendatang as $kg)
                    <div class="p-3.5 rounded-2xl bg-purple-50/40 border border-purple-100">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-purple-600 text-white flex flex-col items-center justify-center shrink-0">
                                <span class="text-[10px] uppercase font-bold leading-tight">{{ $kg->tanggal_kegiatan->format('M') }}</span>
                                <span class="text-base font-extrabold leading-none">{{ $kg->tanggal_kegiatan->format('d') }}</span>
                            </div>
                            <div class="overflow-hidden">
                                <h5 class="text-xs font-bold text-gray-900 truncate">{{ $kg->nama_kegiatan }}</h5>
                                <p class="text-[11px] text-gray-500 mt-0.5"><i class="fas fa-clock text-[9px] mr-1"></i> {{ $kg->waktu_mulai }}</p>
                                <p class="text-[11px] text-gray-500 truncate"><i class="fas fa-location-dot text-[9px] mr-1"></i> {{ $kg->lokasi }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">Tidak ada agenda kegiatan terdekat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Mutasi Kas Terbaru -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-receipt text-emerald-600"></i> Mutasi Kas Terbaru
                    </h3>
                    <a href="{{ route('keuangan.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Semua</a>
                </div>

                <div class="divide-y divide-gray-100 text-xs">
                    @forelse($transaksiTerbaru as $tx)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-gray-900 block truncate max-w-[170px]">{{ $tx->kategori }}</span>
                            <span class="text-gray-400 text-[11px]">{{ $tx->tanggal_transaksi->format('d M Y') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold block {{ $tx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                            </span>
                            <span class="text-[10px] uppercase font-semibold text-gray-400">{{ $tx->jenis }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada catatan mutasi kas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
