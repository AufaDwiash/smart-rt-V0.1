@extends('layouts.app')

@section('title', 'Edit Pengumuman RT')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Perbarui Pengumuman</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $pengumuman->judul }}</p>
            </div>
            <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori Warta <span class="text-red-500">*</span></label>
                    <input type="text" name="kategori" value="{{ old('kategori', $pengumuman->kategori) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal Publikasi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_publish" value="{{ old('tanggal_publish', optional($pengumuman->tanggal_publish)->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Isi Lengkap Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="isi" rows="5" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Publikasi <span class="text-red-500">*</span></label>
                <select name="is_published" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="1" {{ old('is_published', $pengumuman->is_published ? '1' : '0') == '1' ? 'selected' : '' }}>Publikasikan</option>
                    <option value="0" {{ old('is_published', $pengumuman->is_published ? '1' : '0') == '0' ? 'selected' : '' }}>Simpan sebagai Draf</option>
                </select>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('pengumuman.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
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
