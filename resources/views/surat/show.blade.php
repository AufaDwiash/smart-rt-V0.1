@extends('layouts.app')

@section('title', 'Detail Permohonan Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Navigation Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('surat.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-white border border-gray-200 px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Surat
        </a>
        @if(in_array($surat->status, ['disetujui', 'selesai']))
        <a href="{{ route('surat.cetak', $surat->id) }}" target="_blank" class="text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-md">
            <i class="fas fa-file-pdf"></i> Cetak / Unduh Dokumen PDF
        </a>
        @endif
    </div>

    <!-- Letter Detail Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs font-mono font-bold text-blue-600 uppercase tracking-wider block">
                    {{ $surat->suratTemplate->kode_surat }} &bull; Pengajuan #{{ $surat->id }}
                </span>
                <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $surat->suratTemplate->nama_surat }}</h2>
                <p class="text-xs text-gray-400 mt-0.5">Diajukan pada: {{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->isoFormat('dddd, D MMMM Y - HH:mm WIB') : '-' }}</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-block text-xs font-bold px-3 py-1.5 rounded-full border {{ $surat->status_badge }}">
                    Status: {{ ucfirst($surat->status) }}
                </span>
                @if($surat->nomor_surat)
                <div class="text-xs font-mono font-bold text-gray-700 mt-2">
                    No: {{ $surat->nomor_surat }}
                </div>
                @endif
            </div>
        </div>

        <!-- Data Pemohon -->
        <div>
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Identitas Pemohon</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-xs bg-gray-50/70 p-4 rounded-2xl border border-gray-100">
                <div>
                    <span class="text-gray-400 block">Nama Lengkap</span>
                    <strong class="text-gray-800 text-sm">{{ $surat->user->nama_lengkap }}</strong>
                </div>
                <div>
                    <span class="text-gray-400 block">NIK</span>
                    <strong class="text-gray-800 text-sm font-mono">{{ $surat->user->nik }}</strong>
                </div>
                <div>
                    <span class="text-gray-400 block">Nomor KK</span>
                    <strong class="text-gray-800 text-sm font-mono">{{ $surat->user->no_kk ?? '-' }}</strong>
                </div>
                <div>
                    <span class="text-gray-400 block">Jenis Kelamin</span>
                    <strong class="text-gray-800">{{ $surat->user->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</strong>
                </div>
                <div>
                    <span class="text-gray-400 block">Tempat, Tanggal Lahir</span>
                    <strong class="text-gray-800">
                        {{ $surat->user->tempat_lahir ?? '-' }}, {{ $surat->user->tanggal_lahir ? $surat->user->tanggal_lahir->format('d M Y') : '-' }}
                    </strong>
                </div>
                <div>
                    <span class="text-gray-400 block">Pekerjaan</span>
                    <strong class="text-gray-800">{{ $surat->user->pekerjaan ?? '-' }}</strong>
                </div>
                <div class="sm:col-span-2 md:col-span-3">
                    <span class="text-gray-400 block">Alamat Domisili</span>
                    <strong class="text-gray-800">{{ $surat->user->alamat }} (RT {{ $surat->user->rt }}/RW {{ $surat->user->rw }})</strong>
                </div>
            </div>
        </div>

        <!-- Keperluan -->
        <div>
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Keperluan Permohonan</h4>
            <div class="p-4 rounded-2xl bg-white border border-gray-200 text-sm text-gray-800 leading-relaxed font-medium">
                {{ $surat->keperluan }}
            </div>
        </div>

        <!-- Berkas Pendukung -->
        @if($surat->file_pendukung)
        <div>
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Berkas Pendukung</h4>
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50 border border-gray-100 text-xs">
                <i class="fas fa-file-arrow-down text-blue-600 text-lg"></i>
                <span class="text-gray-700 font-medium">Dokumen lampiran pemohon terunggah</span>
                <a href="{{ asset('storage/' . $surat->file_pendukung) }}" target="_blank" class="ml-auto bg-white border border-gray-200 text-blue-600 font-bold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                    Lihat Berkas
                </a>
            </div>
        </div>
        @endif

        <!-- Catatan RT -->
        @if($surat->catatan_rt)
        <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 text-xs text-blue-900">
            <strong class="block text-blue-950 mb-1"><i class="fas fa-comment-dots mr-1"></i> Catatan dari Pengurus RT:</strong>
            <p>{{ $surat->catatan_rt }}</p>
        </div>
        @endif
    </div>

    <!-- Verification Panel for Pengurus -->
    @if(Auth::user()->isPengurus())
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="border-b border-gray-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-stamp text-blue-600"></i> Panel Verifikasi Surat (Pengurus RT)
            </h3>
            <p class="text-xs text-gray-500 mt-0.5">Tinjau kelayakan berkas, tetapkan nomor surat, dan perbarui status permohonan.</p>
        </div>

        <form action="{{ route('surat.status', $surat->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Status Permohonan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="pending" {{ $surat->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="diproses" {{ $surat->status === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="disetujui" {{ $surat->status === 'disetujui' ? 'selected' : '' }}>Disetujui (Terbitkan Surat)</option>
                        <option value="selesai" {{ $surat->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $surat->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Surat Resmi</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                        placeholder="Contoh: 470/015/RT.03/IX/2026 (Kosongkan untuk otomatis)"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm font-mono focus:ring-2 focus:ring-blue-500 outline-none">
                    <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong untuk penomoran sistem otomatis saat disetujui.</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Catatan / Keterangan untuk Pemohon</label>
                <textarea name="catatan_rt" rows="2" placeholder="Tuliskan catatan arahan, persyaratan tambahan, atau alasan jika ditolak..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('catatan_rt', $surat->catatan_rt) }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-check-double"></i> Simpan Hasil Verifikasi
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
