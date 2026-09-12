@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Summary Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-6">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-3xl font-extrabold shadow-md shrink-0">
            {{ substr($user->nama_lengkap, 0, 2) }}
        </div>
        <div class="flex-1 text-center md:text-left">
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->nama_lengkap }}</h2>
                <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full
                    @if($user->isAdmin()) bg-purple-100 text-purple-700
                    @elseif($user->isSekretaris()) bg-indigo-100 text-indigo-700
                    @elseif($user->isBendahara()) bg-emerald-100 text-emerald-700
                    @else bg-blue-100 text-blue-700 @endif">
                    {{ $user->role_label }}
                </span>
                <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">
                    <i class="fas fa-circle-check text-[10px] mr-1"></i> Akun Aktif
                </span>
            </div>
            <div class="mt-2 text-sm text-gray-500 flex flex-wrap justify-center md:justify-start gap-4">
                <span><i class="fas fa-id-card text-gray-400 mr-1"></i> NIK: <strong>{{ $user->nik }}</strong></span>
                <span><i class="fas fa-people-roof text-gray-400 mr-1"></i> No. KK: <strong>{{ $user->no_kk ?? '-' }}</strong></span>
                <span><i class="fas fa-location-dot text-gray-400 mr-1"></i> RT {{ $user->rt }}/RW {{ $user->rw }}</span>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="border-b border-gray-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-gray-900">Perbarui Informasi Kontak & Data Diri</h3>
            <p class="text-xs text-gray-500 mt-1">Data NIK dan No. KK hanya dapat diubah oleh administrator / pengurus RT demi keamanan kependudukan.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $user->pekerjaan) }}"
                        placeholder="Contoh: Karyawan Swasta, Wiraswasta"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Agama</label>
                    <input type="text" name="agama" value="{{ old('agama', $user->agama) }}"
                        placeholder="Contoh: Islam, Kristen, dll."
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status dalam Keluarga</label>
                    <input type="text" value="{{ $user->status_keluarga ?? 'Anggota Lain' }}" disabled
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Domisili</label>
                <textarea name="alamat" rows="2" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <!-- Change Password Section -->
            <div class="border-t border-gray-100 pt-6 mt-6">
                <h4 class="text-sm font-bold text-gray-900 mb-1">Ganti Password (Opsional)</h4>
                <p class="text-xs text-gray-500 mb-4">Kosongkan bagian ini jika Anda tidak ingin mengubah password akun.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Password Lama</label>
                        <input type="password" name="current_password" placeholder="Password saat ini"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Password Baru</label>
                        <input type="password" name="new_password" placeholder="Minimal 6 karakter"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Ulangi Password Baru</label>
                        <input type="password" name="new_password_confirmation" placeholder="Konfirmasi password baru"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-md flex items-center gap-2 text-sm">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
