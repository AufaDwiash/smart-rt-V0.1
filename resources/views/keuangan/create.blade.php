@extends('layouts.app')

@section('title', 'Catat Transaksi Kas RT')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Pencatatan Buku Kas RT</h3>
                <p class="text-xs text-gray-500 mt-0.5">Catat arus kas pemasukan dan pengeluaran lingkungan secara transparan.</p>
            </div>
            <a href="{{ route('keuangan.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Jenis Transaksi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Jenis Transaksi <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-4 rounded-2xl border cursor-pointer transition select-none
                        {{ old('jenis', 'pemasukan') === 'pemasukan' ? 'border-emerald-500 bg-emerald-50/50' : 'border-gray-200 hover:bg-gray-50' }}">
                        <input type="radio" name="jenis" value="pemasukan" {{ old('jenis', 'pemasukan') === 'pemasukan' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-sm font-bold text-emerald-800"><i class="fas fa-arrow-down mr-1"></i> Pemasukan Kas</span>
                            <span class="text-[11px] text-gray-500">Iuran bulanan, donasi, bantuan dana</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 rounded-2xl border cursor-pointer transition select-none
                        {{ old('jenis') === 'pengeluaran' ? 'border-rose-500 bg-rose-50/50' : 'border-gray-200 hover:bg-gray-50' }}">
                        <input type="radio" name="jenis" value="pengeluaran" {{ old('jenis') === 'pengeluaran' ? 'checked' : '' }} class="w-4 h-4 text-rose-600 focus:ring-rose-500">
                        <div>
                            <span class="block text-sm font-bold text-rose-800"><i class="fas fa-arrow-up mr-1"></i> Pengeluaran Kas</span>
                            <span class="text-[11px] text-gray-500">Operasional, kebersihan, perbaikan</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Kategori Transaksi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori Transaksi <span class="text-red-500">*</span></label>
                <input type="text" id="kategoriInput" name="kategori" value="{{ old('kategori') }}" required
                    placeholder="Contoh: Iuran Warga Bulan September, Operasional Pos Ronda, dll."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                
                <!-- Quick Suggestion Tags -->
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <span class="text-[10px] text-gray-400 font-semibold self-center mr-1">Pilihan Cepat:</span>
                    <button type="button" onclick="setKategori('Iuran Bulanan Warga')" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full transition">Iuran Warga</button>
                    <button type="button" onclick="setKategori('Operasional Pos Ronda')" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full transition">Pos Ronda</button>
                    <button type="button" onclick="setKategori('Kebersihan & Sampah')" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full transition">Kebersihan</button>
                    <button type="button" onclick="setKategori('Perbaikan Lampu Jalan')" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full transition">Lampu Jalan</button>
                    <button type="button" onclick="setKategori('Donasi Sukarela Warga')" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full transition">Donasi</button>
                    <button type="button" onclick="setKategori('Konsumsi Kerja Bakti')" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full transition">Kerja Bakti</button>
                </div>
            </div>

            <!-- Nominal & Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Nominal Uang (Rupiah) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-xs font-bold text-gray-400">Rp</span>
                        <input type="number" name="nominal" value="{{ old('nominal') }}" required min="1000" step="500"
                            placeholder="Contoh: 500000"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_transaksi" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Keterangan / Rincian Tambahan</label>
                <textarea name="keterangan" rows="2" placeholder="Catatan detail mengenai transaksi kas ini..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Bukti Transaksi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Foto Nota / Kuitansi Bukti (Opsional)</label>
                <input type="file" name="bukti_transaksi" accept="image/*"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, PNG maksimal 2MB.</span>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('keuangan.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Transaksi Kas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function setKategori(val) {
        document.getElementById('kategoriInput').value = val;
    }
</script>
@endsection
