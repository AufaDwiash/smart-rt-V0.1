@extends('layouts.app')

@section('title', 'Tambah Warga Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Formulir Pendaftaran Warga Baru</h3>
                <p class="text-xs text-gray-500 mt-0.5">Input data identitas kependudukan warga RT 03.</p>
            </div>
            <a href="{{ route('warga.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('warga.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Bagian 1: Kependudukan -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">1. Data Kependudukan (KTP & KK)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">NIK (16 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" placeholder="Contoh: 3509010101010001"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Kartu Keluarga (KK)</label>
                        <input type="text" name="no_kk" value="{{ old('no_kk') }}" maxlength="16" placeholder="Contoh: 3509010101010001"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Sesuai KTP <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama Lengkap"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota Kelahiran"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Agama</label>
                        <input type="text" name="agama" value="{{ old('agama') }}" placeholder="Contoh: Islam, Kristen, dll."
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Karyawan, Guru, Wirausaha"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Domisili & Keluarga -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">2. Domisili & Hubungan Keluarga</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status dalam Keluarga</label>
                        <select name="status_keluarga" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="Kepala Keluarga" {{ old('status_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Istri" {{ old('status_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('status_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Anggota Lain" {{ old('status_keluarga', 'Anggota Lain') == 'Anggota Lain' ? 'selected' : '' }}>Anggota Lain</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status Warga di RT <span class="text-red-500">*</span></label>
                        <select name="status_warga" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="tetap" {{ old('status_warga') == 'tetap' ? 'selected' : '' }}>Warga Tetap</option>
                            <option value="kontrak" {{ old('status_warga') == 'kontrak' ? 'selected' : '' }}>Warga Kontrak / Sewa</option>
                            <option value="pindah" {{ old('status_warga') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Lengkap di Lingkungan RT <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="2" required placeholder="Nama jalan, nomor rumah, blok..."
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">RT</label>
                        <input type="text" name="rt" value="{{ old('rt', '03') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">RW</label>
                        <input type="text" name="rw" value="{{ old('rw', '02') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Akun & Hak Akses -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">3. Akun Pengguna & Hak Akses Sistem</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email (Opsional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="warga@email.com"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08123456789"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Peran Akses (Role) <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="warga" {{ old('role') == 'warga' ? 'selected' : '' }}>Warga Biasa</option>
                            <option value="sekretaris" {{ old('role') == 'sekretaris' ? 'selected' : '' }}>Sekretaris RT</option>
                            <option value="bendahara" {{ old('role') == 'bendahara' ? 'selected' : '' }}>Bendahara RT</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Ketua RT / Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Password Awal Akun <span class="text-red-500">*</span></label>
                        <input type="text" name="password" value="{{ old('password', 'password123') }}" required minlength="6"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <span class="text-[11px] text-gray-400 mt-1 block">Default: password123 (dapat diganti oleh warga nantinya)</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('warga.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data Warga
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
