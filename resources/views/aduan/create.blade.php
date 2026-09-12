@extends('layouts.app')

@section('title', 'Sampaikan Aduan Warga')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Formulir Aspirasi & Aduan Lingkungan</h3>
                <p class="text-xs text-gray-500 mt-0.5">Pelapor: <strong>{{ Auth::user()->nama_lengkap }}</strong> (RT {{ Auth::user()->rt }}/RW {{ Auth::user()->rw }})</p>
            </div>
            <a href="{{ route('aduan.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Aduan -->
            <div>
                <label for="judul" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Judul Masalah / Laporan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                    placeholder="Contoh: Lampu Penerangan Jalan Depan Gang C Mati"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                @error('judul')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Kategori Masalah <span class="text-red-500">*</span>
                </label>
                <select id="kategori" name="kategori" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Pilih Kategori Masalah --</option>
                    <option value="fasilitas" {{ old('kategori') == 'fasilitas' ? 'selected' : '' }}>Kerusakan Fasilitas Umum (Jalan, Lampu, Selokan)</option>
                    <option value="kebersihan" {{ old('kategori') == 'kebersihan' ? 'selected' : '' }}>Kebersihan & Pengangkutan Sampah</option>
                    <option value="keamanan" {{ old('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan Lingkungan & Siskamling</option>
                    <option value="kebisingan" {{ old('kategori') == 'kebisingan' ? 'selected' : '' }}>Kebisingan / Gangguan Ketenteraman</option>
                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Aspirasi / Usulan Lainnya</option>
                </select>
                @error('kategori')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Laporan -->
            <div>
                <label for="isi_aduan" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Uraian Detail Aduan & Lokasi Kejadian <span class="text-red-500">*</span>
                </label>
                <textarea id="isi_aduan" name="isi_aduan" rows="4" required
                    placeholder="Jelaskan kronologi, lokasi spesifik, dan dampak permasalahan tersebut bagi warga..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('isi_aduan') }}</textarea>
                @error('isi_aduan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Foto -->
            <div>
                <label for="foto_aduan" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Foto Bukti Kejadian / Objek (Opsional)
                </label>
                <input type="file" id="foto_aduan" name="foto_aduan" accept="image/*"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, JPEG, PNG (Ukuran maksimal: 3MB). Foto akan membantu pengurus RT melakukan survei penanganan.</span>
                @error('foto_aduan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('aduan.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> Kirim Laporan Aduan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
