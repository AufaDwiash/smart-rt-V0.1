@extends('layouts.app')

@section('title', 'Ajukan Surat Pengantar')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Permohonan Surat Pengantar Online</h3>
                <p class="text-xs text-gray-500 mt-0.5">Pemohon: <strong>{{ Auth::user()->nama_lengkap }}</strong> (NIK: {{ Auth::user()->nik }})</p>
            </div>
            <a href="{{ route('surat.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <!-- Info Box -->
        <div class="mb-6 bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
            <i class="fas fa-circle-info text-blue-600 text-lg mt-0.5"></i>
            <div class="text-xs text-blue-900 space-y-1">
                <p class="font-bold">Informasi Penting:</p>
                <p>Pastikan data identitas pada profil Anda sudah lengkap dan sesuai KTP/KK asli. Surat pengantar yang telah disetujui dapat langsung dicetak atau diunduh dalam format PDF resmi berstempel RT 03.</p>
            </div>
        </div>

        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Jenis Surat -->
            <div>
                <label for="surat_template_id" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Pilih Jenis Surat Pengantar <span class="text-red-500">*</span>
                </label>
                <select id="surat_template_id" name="surat_template_id" required onchange="updatePersyaratan()"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Pilih Jenis Surat yang Dibutuhkan --</option>
                    @foreach($templates as $tpl)
                    <option value="{{ $tpl->id }}" data-persyaratan="{{ $tpl->persyaratan }}" data-deskripsi="{{ $tpl->deskripsi }}" {{ old('surat_template_id') == $tpl->id ? 'selected' : '' }}>
                        {{ $tpl->nama_surat }} ({{ $tpl->kode_surat }})
                    </option>
                    @endforeach
                </select>
                @error('surat_template_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Box Persyaratan Dinamis -->
            <div id="persyaratanBox" class="hidden p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-900">
                <strong class="block text-amber-950 mb-1"><i class="fas fa-clipboard-check mr-1"></i> Persyaratan Dokumen:</strong>
                <p id="persyaratanText" class="text-xs leading-relaxed"></p>
                <p id="deskripsiText" class="text-gray-500 text-[11px] mt-1.5 italic"></p>
            </div>

            <!-- Keperluan -->
            <div>
                <label for="keperluan" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Keperluan Permohonan Surat <span class="text-red-500">*</span>
                </label>
                <textarea id="keperluan" name="keperluan" rows="3" required
                    placeholder="Contoh: Untuk persyaratan pembuatan SKCK di Polsek dalam rangka melamar pekerjaan..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('keperluan') }}</textarea>
                <span class="text-[11px] text-gray-400 mt-1 block">Tuliskan tujuan dan keperluan penggunaan surat secara spesifik.</span>
                @error('keperluan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Berkas Pendukung -->
            <div>
                <label for="file_pendukung" class="block text-xs font-bold text-gray-700 mb-1.5">
                    Unggah Berkas Pendukung (Opsional)
                </label>
                <input type="file" id="file_pendukung" name="file_pendukung" accept=".jpg,.jpeg,.png,.pdf"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, PNG, atau PDF (Ukuran maksimal: 2MB). Dapat berupa foto KTP, KK, atau bukti pendukung lainnya.</span>
                @error('file_pendukung')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('surat.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> Kirim Permohonan Surat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePersyaratan() {
        const select = document.getElementById('surat_template_id');
        const box = document.getElementById('persyaratanBox');
        const reqText = document.getElementById('persyaratanText');
        const descText = document.getElementById('deskripsiText');
        
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            const req = selected.getAttribute('data-persyaratan');
            const desc = selected.getAttribute('data-deskripsi');
            reqText.textContent = req || 'Tidak ada persyaratan berkas khusus.';
            descText.textContent = desc ? 'Keterangan: ' + desc : '';
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }
    // trigger on load if old value exists
    document.addEventListener('DOMContentLoaded', updatePersyaratan);
</script>
@endsection
