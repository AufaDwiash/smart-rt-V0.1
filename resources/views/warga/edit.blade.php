@extends('layouts.app')

@section('title', 'Edit Data Warga')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Perbarui Data Warga: {{ $warga->nama_lengkap }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">NIK: {{ $warga->nik }}</p>
            </div>
            <a href="{{ route('warga.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('warga.update', $warga->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Kependudukan -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">1. Data Kependudukan (KTP & KK)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">NIK (16 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik', $warga->nik) }}" required maxlength="16"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Kartu Keluarga (KK)</label>
                        <input type="text" name="no_kk" value="{{ old('no_kk', $warga->no_kk) }}" maxlength="16"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Sesuai KTP <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($warga->tanggal_lahir)->format('Y-m-d')) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Agama</label>
                        <input type="text" name="agama" value="{{ old('agama', $warga->agama) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Domisili & Keluarga -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">2. Domisili & Status Keluarga</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status dalam Keluarga</label>
                        <select name="status_keluarga" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="Kepala Keluarga" {{ old('status_keluarga', $warga->status_keluarga) == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Istri" {{ old('status_keluarga', $warga->status_keluarga) == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('status_keluarga', $warga->status_keluarga) == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Anggota Lain" {{ old('status_keluarga', $warga->status_keluarga) == 'Anggota Lain' ? 'selected' : '' }}>Anggota Lain</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status Kependudukan <span class="text-red-500">*</span></label>
                        <select name="status_warga" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="tetap" {{ old('status_warga', $warga->status_warga) == 'tetap' ? 'selected' : '' }}>Warga Tetap</option>
                            <option value="kontrak" {{ old('status_warga', $warga->status_warga) == 'kontrak' ? 'selected' : '' }}>Warga Kontrak</option>
                            <option value="pindah" {{ old('status_warga', $warga->status_warga) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Domisili <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="2" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ old('alamat', $warga->alamat) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">RT</label>
                        <input type="text" name="rt" value="{{ old('rt', $warga->rt) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">RW</label>
                        <input type="text" name="rw" value="{{ old('rw', $warga->rw) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Akun & Hak Akses -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">3. Akun Sistem & Hak Akses</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $warga->email) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $warga->no_hp) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Peran Akses (Role) <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="warga" {{ old('role', $warga->role) == 'warga' ? 'selected' : '' }}>Warga Biasa</option>
                            <option value="sekretaris" {{ old('role', $warga->role) == 'sekretaris' ? 'selected' : '' }}>Sekretaris RT</option>
                            <option value="bendahara" {{ old('role', $warga->role) == 'bendahara' ? 'selected' : '' }}>Bendahara RT</option>
                            <option value="admin" {{ in_array(old('role', $warga->role), ['admin', 'rt']) ? 'selected' : '' }}>Ketua RT / Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status Akun <span class="text-red-500">*</span></label>
                        <select name="status_akun" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="aktif" {{ old('status_akun', $warga->status_akun) == 'aktif' ? 'selected' : '' }}>Aktif (Bisa Login)</option>
                            <option value="nonaktif" {{ old('status_akun', $warga->status_akun) == 'nonaktif' ? 'selected' : '' }}>Nonaktif (Diblokir)</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Reset Password Akun (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('warga.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition">
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
