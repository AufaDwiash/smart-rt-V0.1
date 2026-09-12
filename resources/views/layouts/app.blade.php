<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Smart-RT 03 / RW 02</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-active {
            @apply bg-blue-600 text-white font-semibold shadow-sm;
        }
        .sidebar-inactive {
            @apply text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Mobile Header -->
        <div class="md:hidden bg-white border-b border-gray-200 p-4 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    <i class="fas fa-microchip"></i>
                </div>
                <div>
                    <span class="font-bold text-gray-900 tracking-tight text-lg">Smart RT</span>
                    <span class="text-xs text-blue-600 block font-medium -mt-1">RT 03 / RW 02</span>
                </div>
            </div>
            <button id="toggleMobileSidebar" class="text-gray-500 hover:text-gray-700 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <aside id="sidebarNav" class="hidden md:flex flex-col w-full md:w-64 bg-white border-r border-gray-200 md:min-h-screen shrink-0 z-30 transition-all">
            <!-- Sidebar Brand (Desktop) -->
            <div class="p-6 border-b border-gray-100 hidden md:flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xl shadow-md group-hover:scale-105 transition-transform">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div>
                        <span class="font-extrabold text-xl text-gray-900 tracking-tight block">Smart RT</span>
                        <span class="text-xs text-blue-600 font-semibold uppercase tracking-wider block">Lingkungan RT 03</span>
                    </div>
                </a>
            </div>

            <!-- Profile Summary in Sidebar -->
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-base uppercase shrink-0">
                        {{ substr(Auth::user()->nama_lengkap ?? 'U', 0, 2) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-bold text-sm text-gray-900 truncate">{{ Auth::user()->nama_lengkap ?? 'Pengguna' }}</h4>
                        <span class="inline-flex items-center text-[11px] font-semibold px-2 py-0.5 rounded-full mt-0.5
                            @if(Auth::user()->isAdmin()) bg-purple-100 text-purple-700
                            @elseif(Auth::user()->isSekretaris()) bg-indigo-100 text-indigo-700
                            @elseif(Auth::user()->isBendahara()) bg-emerald-100 text-emerald-700
                            @else bg-blue-100 text-blue-700 @endif">
                            <i class="fas fa-shield-halved mr-1 text-[9px]"></i>
                            {{ Auth::user()->role_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu Utama</div>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-house-chimney w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                @if(Auth::user()->isPengurus())
                <!-- Data Warga (Pengurus) -->
                <a href="{{ route('warga.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('warga.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Data Warga & KK</span>
                </a>
                @endif

                <!-- Pengajuan Surat -->
                <a href="{{ route('surat.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('surat.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-file-signature w-5 text-center"></i>
                    <span>Pengajuan Surat</span>
                </a>

                <!-- Keuangan Kas RT (Pengurus/Bendahara or Read-only preview) -->
                @if(Auth::user()->isPengurus())
                <a href="{{ route('keuangan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('keuangan.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-wallet w-5 text-center"></i>
                    <span>Buku Kas RT</span>
                </a>
                @endif

                <!-- Agenda Kegiatan Lingkungan -->
                <a href="{{ route('kegiatan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('kegiatan.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-calendar-days w-5 text-center"></i>
                    <span>Agenda & Ronda</span>
                </a>

                <!-- Aduan & Aspirasi Warga -->
                <a href="{{ route('aduan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('aduan.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-bullhorn w-5 text-center"></i>
                    <span>Aduan Warga</span>
                </a>

                <!-- Pengumuman Warga -->
                <a href="{{ route('pengumuman.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('pengumuman.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-newspaper w-5 text-center"></i>
                    <span>Pengumuman RT</span>
                </a>

                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 pt-4 mb-2">Akun & Sistem</div>

                <!-- Profil -->
                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('profile') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <i class="fas fa-user-gear w-5 text-center"></i>
                    <span>Profil Akun</span>
                </a>

                <!-- Landing Page Link -->
                <a href="{{ route('landing') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium sidebar-inactive">
                    <i class="fas fa-globe w-5 text-center"></i>
                    <span>Halaman Publik <i class="fas fa-arrow-up-right-from-square text-xs ml-1 opacity-70"></i></span>
                </a>
            </nav>

            <!-- Bottom Logout -->
            <div class="p-4 border-t border-gray-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-2.5 px-4 rounded-xl text-sm transition">
                        <i class="fas fa-arrow-right-from-bracket"></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Desktop Topbar -->
            <header class="bg-white border-b border-gray-200 hidden md:flex items-center justify-between px-8 py-4 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-sm font-bold text-gray-900">{{ Auth::user()->nama_lengkap }}</div>
                        <div class="text-xs text-gray-500">NIK: {{ Auth::user()->nik }}</div>
                    </div>
                    <a href="{{ route('profile') }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition shadow-sm font-semibold">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 p-4 md:p-8">
                <!-- Flash Notification Alert -->
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-up">
                    <i class="fas fa-circle-check text-emerald-500 text-xl"></i>
                    <div class="flex-1 text-sm font-medium">{{ session('success') }}</div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-up">
                    <i class="fas fa-circle-xmark text-red-500 text-xl"></i>
                    <div class="flex-1 text-sm font-medium">{{ session('error') }}</div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-800 px-5 py-4 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-sm mb-1 text-amber-900">
                        <i class="fas fa-triangle-exclamation text-amber-500"></i> Mohon periksa kembali input Anda:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 ml-5 text-amber-800">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-100 px-8 py-4 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} <strong>Smart-RT Digital</strong> — Sistem Pelayanan Administrasi & Informasi Terpadu RT 03 / RW 02.
            </footer>
        </div>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const toggleBtn = document.getElementById('toggleMobileSidebar');
        const sidebar = document.getElementById('sidebarNav');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
