<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart-RT 03</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-gray-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
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
            <h2 class="text-xl font-bold text-gray-800 mt-6">Masuk ke Sistem</h2>
            <p class="text-sm text-gray-500 mt-1">Gunakan NIK atau Email yang terdaftar untuk mengakses layanan.</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 p-8 border border-gray-100">
            @if(session('error'))
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fas fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        <i class="fas fa-id-card text-blue-500 mr-1"></i> NIK atau Alamat Email
                    </label>
                    <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus
                        placeholder="Contoh: 3509010101010001 atau admin@smartrt.local"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition outline-none @error('login') border-red-500 @enderror">
                    @error('login')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-lock text-blue-500 mr-1"></i> Password
                        </label>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            placeholder="Masukkan password Anda"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition outline-none @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="text-gray-600 text-xs">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                    <i class="fas fa-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <!-- Quick Fill Demo Accounts -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 text-center">
                    Coba Akun Demo Cepat (Klik)
                </span>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="fillCredentials('admin@smartrt.local', 'password123')" class="p-2 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium text-left transition border border-purple-200">
                        <i class="fas fa-shield-halved mr-1"></i> Admin / Ketua RT
                    </button>
                    <button type="button" onclick="fillCredentials('sekretaris@smartrt.local', 'password123')" class="p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium text-left transition border border-indigo-200">
                        <i class="fas fa-pen-nib mr-1"></i> Sekretaris RT
                    </button>
                    <button type="button" onclick="fillCredentials('bendahara@smartrt.local', 'password123')" class="p-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium text-left transition border border-emerald-200">
                        <i class="fas fa-wallet mr-1"></i> Bendahara RT
                    </button>
                    <button type="button" onclick="fillCredentials('warga@smartrt.local', 'password123')" class="p-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium text-left transition border border-blue-200">
                        <i class="fas fa-user mr-1"></i> Warga (Budi)
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Link -->
        <div class="text-center mt-6 text-sm text-gray-600">
            Warga baru belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 ml-1">Daftar Akun Warga</a>
            <div class="mt-3">
                <a href="{{ route('landing') }}" class="text-xs text-gray-400 hover:text-gray-600 inline-flex items-center gap-1">
                    <i class="fas fa-arrow-left text-[10px]"></i> Kembali ke Beranda Publik
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function fillCredentials(login, pass) {
            document.getElementById('login').value = login;
            document.getElementById('password').value = pass;
        }
    </script>
</body>
</html>
