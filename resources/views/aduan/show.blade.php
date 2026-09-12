@extends('layouts.app')

@section('title', 'Detail Aduan Warga')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('aduan.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-white border border-gray-200 px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Aduan
        </a>
    </div>

    <!-- Aduan Detail Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded bg-blue-50 text-blue-700">
                        {{ $aduan->kategori }}
                    </span>
                    <span class="text-xs text-gray-400">
                        Dilaporkan {{ $aduan->created_at->diffForHumans() }} ({{ $aduan->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB)
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $aduan->judul }}</h2>
                <p class="text-xs text-gray-500 mt-1">
                    Pelapor: <strong>{{ $aduan->user->nama_lengkap }}</strong> &bull; NIK: {{ $aduan->user->nik }} &bull; Alamat: {{ $aduan->user->alamat }}
                </p>
            </div>
            <div class="shrink-0">
                <span class="inline-block text-xs font-bold px-3 py-1.5 rounded-full border {{ $aduan->status_badge }}">
                    Status: {{ ucfirst($aduan->status) }}
                </span>
            </div>
        </div>

        <!-- Uraian Masalah -->
        <div>
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Uraian Laporan</h4>
            <div class="p-5 rounded-2xl bg-gray-50/60 border border-gray-100 text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                {{ $aduan->isi_aduan }}
            </div>
        </div>

        <!-- Foto Bukti -->
        @if($aduan->foto_aduan)
        <div>
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Foto Lampiran Objek / Lokasi</h4>
            <div class="rounded-2xl overflow-hidden border border-gray-200 max-w-lg shadow-sm">
                <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" alt="Foto Aduan" class="w-full h-auto object-cover">
            </div>
        </div>
        @endif

        <!-- Tanggapan RT yang Sudah Ada -->
        @if($aduan->tanggapan_rt)
        <div class="p-5 rounded-2xl bg-blue-50/70 border border-blue-100 text-blue-950 space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-bold text-blue-800 uppercase tracking-wider">
                <i class="fas fa-reply"></i> Tanggapan & Tindak Lanjut Pengurus RT:
            </div>
            <p class="text-sm leading-relaxed">{{ $aduan->tanggapan_rt }}</p>
            <span class="text-[11px] text-blue-500 block pt-1">Diperbarui pada: {{ $aduan->updated_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
        </div>
        @endif
    </div>

    <!-- Panel Tindak Lanjut Pengurus RT -->
    @if(Auth::user()->isPengurus())
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="border-b border-gray-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-hand-holding-hand text-blue-600"></i> Tanggapi & Tindak Lanjut Aduan (Pengurus RT)
            </h3>
            <p class="text-xs text-gray-500 mt-0.5">Berikan informasi langkah penanganan kepada pelapor dan warga lingkungan.</p>
        </div>

        <form action="{{ route('aduan.update', $aduan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Status Penanganan <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="pending" {{ $aduan->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Penjadwalan)</option>
                    <option value="diproses" {{ $aduan->status === 'diproses' ? 'selected' : '' }}>Sedang Ditangani (Dalam Proses Tindakan)</option>
                    <option value="selesai" {{ $aduan->status === 'selesai' ? 'selected' : '' }}>Selesai (Masalah Telah Tuntas)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggapan / Solusi Penanganan RT <span class="text-red-500">*</span></label>
                <textarea name="tanggapan_rt" rows="4" required placeholder="Tuliskan tindakan yang diambil RT, jadwal pengecekan/kerja bakti, atau klarifikasi..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('tanggapan_rt', $aduan->tanggapan_rt) }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> Kirim Tanggapan RT
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
