@extends('layouts.app')

@section('title', 'Detail Data Warga')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Action Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('warga.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-white border border-gray-200 px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Warga
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('warga.edit', $warga->id) }}" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-pen-to-square"></i> Edit Data
            </a>
        </div>
    </div>

    <!-- Main Citizen Info Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 pb-6 border-b border-gray-100">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-3xl font-extrabold shadow-md shrink-0">
                {{ substr($warga->nama_lengkap, 0, 2) }}
            </div>
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $warga->nama_lengkap }}</h2>
                    <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full
                        @if($warga->isAdmin()) bg-purple-100 text-purple-700
                        @elseif($warga->isSekretaris()) bg-indigo-100 text-indigo-700
                        @elseif($warga->isBendahara()) bg-emerald-100 text-emerald-700
                        @else bg-blue-100 text-blue-700 @endif">
                        {{ $warga->role_label }}
                    </span>
                    <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full
                        @if($warga->status_warga === 'tetap') bg-emerald-100 text-emerald-800
                        @elseif($warga->status_warga === 'kontrak') bg-amber-100 text-amber-800
                        @else bg-gray-100 text-gray-800 @endif">
                        Warga {{ ucfirst($warga->status_warga) }}
                    </span>
                    <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full
                        {{ $warga->status_akun === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        Akun {{ ucfirst($warga->status_akun) }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-location-dot text-gray-400 mr-1"></i> {{ $warga->alamat }} (RT {{ $warga->rt }}/RW {{ $warga->rw }})
                </p>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-6 text-sm">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">NIK</span>
                <span class="font-mono font-bold text-gray-800 text-base mt-0.5 block">{{ $warga->nik }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Nomor Kartu Keluarga (KK)</span>
                <span class="font-mono font-bold text-gray-800 text-base mt-0.5 block">{{ $warga->no_kk ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Posisi dalam Keluarga</span>
                <span class="font-bold text-gray-800 mt-0.5 block">{{ $warga->status_keluarga ?? 'Anggota Lain' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Jenis Kelamin</span>
                <span class="font-bold text-gray-800 mt-0.5 block">{{ $warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Tempat, Tanggal Lahir</span>
                <span class="font-bold text-gray-800 mt-0.5 block">
                    {{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('d M Y') : '-' }}
                </span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Agama</span>
                <span class="font-bold text-gray-800 mt-0.5 block">{{ $warga->agama ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Pekerjaan</span>
                <span class="font-bold text-gray-800 mt-0.5 block">{{ $warga->pekerjaan ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Nomor WhatsApp / HP</span>
                <span class="font-bold text-gray-800 mt-0.5 block">{{ $warga->no_hp ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Alamat Email</span>
                <span class="font-bold text-gray-800 mt-0.5 block">{{ $warga->email ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Anggota Keluarga 1 KK -->
    @if($warga->no_kk)
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-people-roof text-blue-600"></i> Anggota Keluarga Satu KK (No. KK: {{ $warga->no_kk }})
        </h3>

        @if($anggotaKeluarga->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($anggotaKeluarga as $fam)
            <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h5 class="font-bold text-gray-900 text-sm">{{ $fam->nama_lengkap }}</h5>
                    <span class="text-xs text-gray-400 block font-mono">NIK: {{ $fam->nik }}</span>
                    <span class="inline-block mt-1 text-[11px] font-semibold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                        {{ $fam->status_keluarga ?? 'Anggota' }}
                    </span>
                </div>
                <a href="{{ route('warga.show', $fam->id) }}" class="text-xs bg-white text-blue-600 border border-blue-200 px-2.5 py-1.5 rounded-lg font-bold hover:bg-blue-50 transition">
                    Lihat
                </a>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-xs text-gray-400">Tidak ada anggota keluarga lain yang terdaftar dalam nomor KK ini.</p>
        @endif
    </div>
    @endif

    <!-- Riwayat Surat & Aduan Warga Ini -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Riwayat Surat -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-file-invoice text-blue-600"></i> Riwayat Pengajuan Surat Warga Ini
            </h4>
            <div class="space-y-3 text-xs">
                @forelse($riwayatSurat as $st)
                <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="font-bold text-gray-900 block">{{ $st->suratTemplate->nama_surat }}</span>
                        <span class="text-gray-400 text-[11px]">{{ $st->tanggal_pengajuan ? $st->tanggal_pengajuan->format('d M Y') : '-' }}</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $st->status_badge }}">
                        {{ ucfirst($st->status) }}
                    </span>
                </div>
                @empty
                <p class="text-xs text-gray-400 py-3">Warga ini belum pernah mengajukan surat.</p>
                @endforelse
            </div>
        </div>

        <!-- Riwayat Aduan -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-bullhorn text-rose-600"></i> Riwayat Aduan Warga Ini
            </h4>
            <div class="space-y-3 text-xs">
                @forelse($riwayatAduan as $ad)
                <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                    <div class="overflow-hidden">
                        <span class="font-bold text-gray-900 block truncate">{{ $ad->judul }}</span>
                        <span class="text-gray-400 text-[11px]">{{ $ad->created_at->format('d M Y') }}</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $ad->status_badge }} shrink-0">
                        {{ ucfirst($ad->status) }}
                    </span>
                </div>
                @empty
                <p class="text-xs text-gray-400 py-3">Warga ini belum pernah mengirim aduan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
