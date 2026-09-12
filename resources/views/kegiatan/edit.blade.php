@extends('layouts.app')

@section('title', 'Edit Agenda Kegiatan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Perbarui Agenda: {{ $kegiatan->nama_kegiatan }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">Edit detail tanggal, waktu, lokasi, atau status pelaksanaan.</p>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori Kegiatan <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="kerja_bakti" {{ old('kategori', $kegiatan->kategori) == 'kerja_bakti' ? 'selected' : '' }}>Kerja Bakti</option>
                        <option value="ronda" {{ old('kategori', $kegiatan->kategori) == 'ronda' ? 'selected' : '' }}>Ronda Malam (Siskamling)</option>
                        <option value="rapat" {{ old('kategori', $kegiatan->kategori) == 'rapat' ? 'selected' : '' }}>Rapat / Musyawarah Warga</option>
                        <option value="sosial" {{ old('kategori', $kegiatan->kategori) == 'sosial' ? 'selected' : '' }}>Kegiatan Sosial / Posyandu</option>
                        <option value="olahraga" {{ old('kategori', $kegiatan->kategori) == 'olahraga' ? 'selected' : '' }}>Olahraga / Senam Sehat</option>
                        <option value="keagamaan" {{ old('kategori', $kegiatan->kategori) == 'keagamaan' ? 'selected' : '' }}>Pengajian / Keagamaan</option>
                        <option value="lainnya" {{ old('kategori', $kegiatan->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Pelaksanaan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="mendatang" {{ old('status', $kegiatan->status) == 'mendatang' ? 'selected' : '' }}>Akan Datang (Mendatang)</option>
                        <option value="berlangsung" {{ old('status', $kegiatan->status) == 'berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="selesai" {{ old('status', $kegiatan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status', $kegiatan->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', optional($kegiatan->tanggal_kegiatan)->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Waktu / Jam <span class="text-red-500">*</span></label>
                    <input type="text" name="waktu_mulai" value="{{ old('waktu_mulai', $kegiatan->waktu_mulai) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Lokasi Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Penanggung Jawab (PJ)</label>
                    <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $kegiatan->penanggung_jawab) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi & Rincian Agenda <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="3" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('kegiatan.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
