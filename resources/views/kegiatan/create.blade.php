@extends('layouts.app')

@section('title', 'Tambah Agenda Kegiatan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Publikasi Agenda Kegiatan Baru</h3>
                <p class="text-xs text-gray-500 mt-0.5">Jadwalkan kerja bakti, pertemuan, atau jadwal ronda malam warga.</p>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('kegiatan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required
                    placeholder="Contoh: Kerja Bakti Massal Kebersihan Saluran Air"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori Kegiatan <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="kerja_bakti" {{ old('kategori') == 'kerja_bakti' ? 'selected' : '' }}>Kerja Bakti</option>
                        <option value="ronda" {{ old('kategori') == 'ronda' ? 'selected' : '' }}>Ronda Malam (Siskamling)</option>
                        <option value="rapat" {{ old('kategori') == 'rapat' ? 'selected' : '' }}>Rapat / Musyawarah Warga</option>
                        <option value="sosial" {{ old('kategori') == 'sosial' ? 'selected' : '' }}>Kegiatan Sosial / Posyandu</option>
                        <option value="olahraga" {{ old('kategori') == 'olahraga' ? 'selected' : '' }}>Olahraga / Senam Sehat</option>
                        <option value="keagamaan" {{ old('kategori') == 'keagamaan' ? 'selected' : '' }}>Pengajian / Keagamaan</option>
                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Pelaksanaan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="mendatang" {{ old('status') == 'mendatang' ? 'selected' : '' }}>Akan Datang (Mendatang)</option>
                        <option value="berlangsung" {{ old('status') == 'berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Waktu / Jam <span class="text-red-500">*</span></label>
                    <input type="text" name="waktu_mulai" value="{{ old('waktu_mulai', '07:00 WIB - Selesai') }}" required
                        placeholder="Contoh: 07:00 WIB - Selesai"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Lokasi Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                        placeholder="Contoh: Balai RT 03 / Pos Ronda"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Penanggung Jawab (PJ)</label>
                    <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}"
                        placeholder="Contoh: Sie Keamanan / Pak Budi"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi & Rincian Agenda <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="3" required placeholder="Tuliskan tujuan kegiatan, imbauan membawa peralatan, atau agenda penting..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('kegiatan.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
