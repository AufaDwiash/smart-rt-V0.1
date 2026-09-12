<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Warga Baru - Smart-RT 03</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-gray-50 to-indigo-50 min-h-screen flex items-center justify-center p-4 py-12">

    <div class="w-full max-w-2xl">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform">
                    <i class="fas fa-microchip"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-2xl font-extrabold text-gray-900 leading-none">Smart RT</h1>
                    <span class="text-xs text-blue-600 font-semibold uppercase tracking-wider">Lingkungan RT 03 / RW 02</span>
                </div>
            </a>
            <h2 class="text-2xl font-bold text-gray-800 mt-6">Formulir Pendaftaran Warga</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data kependudukan Anda untuk mendaftar akun layanan digital RT.</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 p-8 border border-gray-100">
            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fas fa-circle-exclamation"></i> Terjadi kesalahan pengisian formulir:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- NIK -->
                    <div>
                        <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1">
                            NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required maxlength="16"
                            placeholder="16 digit NIK sesuai KTP"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>

                    <!-- No KK -->
                    <div>
                        <label for="no_kk" class="block text-sm font-semibold text-gray-700 mb-1">
                            Nomor Kartu Keluarga (KK)
                        </label>
                        <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" maxlength="16"
                            placeholder="16 digit Nomor KK"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Lengkap Sesuai KTP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                            Alamat Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>

                    <!-- No HP/WhatsApp -->
                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1">
                            Nomor WhatsApp / HP
                        </label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                            placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Status Keluarga -->
                    <div>
                        <label for="status_keluarga" class="block text-sm font-semibold text-gray-700 mb-1">
                            Status dalam Keluarga
                        </label>
                        <select id="status_keluarga" name="status_keluarga"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                            <option value="Kepala Keluarga" {{ old('status_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Istri" {{ old('status_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('status_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Anggota Lain" {{ old('status_keluarga') == 'Anggota Lain' ? 'selected' : '' }}>Anggota Lain</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Tempat Lahir -->
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-semibold text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            placeholder="Kota Lahir"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>
                </div>

                <!-- Alamat Domisili -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Domisili di Lingkungan RT 03 <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alamat" name="alamat" rows="2" required
                        placeholder="Contoh: Jl. Melati No. 15 Blok C"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                            Password Akun <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required minlength="6"
                            placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                            Ulangi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6"
                            placeholder="Ketik ulang password"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i> Daftarkan Akun Saya
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Link -->
        <div class="text-center mt-6 text-sm text-gray-600">
            Sudah memiliki akun terdaftar?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 ml-1">Masuk Sekarang</a>
        </div>
    </div>
</body>
</html>
