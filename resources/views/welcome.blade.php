<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart RT - Solusi Administrasi Digital Terpadu RT 03 / RW 02</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        .stat-card .stat-item {
            transition: all 0.2s;
        }
        .stat-card .stat-item:hover {
            transform: scale(1.02);
        }
        .feature-icon {
            transition: all 0.3s ease;
        }
        .group:hover .feature-icon {
            transform: scale(1.1);
            color: #3b82f6;
        }
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-up {
            animation: fadeSlideUp 0.5s ease forwards;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-200">
        <div class="container-custom">
            <div>
                <a href="{{ route('landing') }}" class="logo flex items-center gap-2">
                    <i class="fas fa-microchip text-blue-600"></i>
                    <span>Smart RT <span class="text-xs text-gray-500 font-normal ml-1">RT 03 / RW 02</span></span>
                </a>
            </div>
            <div class="nav-action">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                        <i class="fas fa-house-chimney"></i> Buka Dashboard ({{ Auth::user()->nama_lengkap }})
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="nav-login text-sm text-red-600 hover:text-red-700 font-semibold ml-2">
                            <i class="fas fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-login">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary">
                        <i class="fas fa-user-plus mr-1"></i> Daftar Warga
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-custom hero-grid">
            <!-- Left -->
            <div>
                <span class="badge">
                    <i class="fas fa-bolt text-yellow-500 mr-1"></i> Sistem Administrasi RT Digital Resmi
                </span>
                <h1 class="hero-title">
                    Pengajuan Surat & Aduan Warga Menjadi Lebih Cepat
                </h1>
                <p class="hero-description">
                    Smart-RT memfasilitasi warga mengurus permohonan surat pengantar, menyampaikan aspirasi & aduan lingkungan, memantau transparansi kas, serta melihat agenda kegiatan RT 03 secara real-time.
                </p>
                <div class="hero-button-group">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">
                            <i class="fas fa-gauge mr-1"></i> Masuk ke Dashboard
                        </a>
                        <a href="{{ route('surat.create') }}" class="btn-secondary">
                            <i class="fas fa-pen-nib mr-1"></i> Ajukan Surat Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            <i class="fas fa-right-to-bracket mr-1"></i> Masuk Sistem
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary">
                            <i class="fas fa-user-plus mr-1"></i> Pendaftaran Warga
                        </a>
                    @endauth
                </div>
            </div>
            <!-- Right Stats Card -->
            <div>
                <div class="stat-card">
                    <div class="stat-grid">
                        <div class="stat-item blue">
                            <h3>{{ $totalWarga ?? 120 }}+</h3>
                            <p>Warga Terdaftar</p>
                        </div>
                        <div class="stat-item green">
                            <h3>{{ $totalSurat ?? 35 }}</h3>
                            <p>Surat Diproses</p>
                        </div>
                        <div class="stat-item yellow">
                            <h3>{{ $totalAduan ?? 12 }}</h3>
                            <p>Aduan Masuk</p>
                        </div>
                        <div class="stat-item purple">
                            <h3>24/7</h3>
                            <p>Layanan Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FITUR UNGGULAN ========== -->
    <section class="py-16 md:py-20 container-custom">
        <div class="text-center mb-12">
            <span class="inline-block bg-blue-100 text-blue-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-3">
                <i class="fas fa-star text-yellow-500 mr-1"></i> Layanan Digital Smart RT
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Fitur Unggulan untuk Warga</h2>
            <p class="text-gray-500 max-w-2xl mx-auto mt-3">Kemudahan layanan administrasi RT dalam genggaman, transparan, cepat, dan terpercaya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-md p-6 hover-lift transition-all border border-gray-100 group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-4 feature-icon text-blue-600">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pengajuan Surat Online</h3>
                    <p class="text-gray-500 text-sm">Surat domisili, pengantar SKCK, keterangan usaha — ajukan langsung dari rumah dan unduh PDF resmi.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-50">
                    <a href="{{ route('surat.index') }}" class="text-blue-600 text-sm font-semibold inline-flex items-center gap-1 hover:gap-2 transition-all">
                        Buka Layanan Surat <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-md p-6 hover-lift border border-gray-100 group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center mb-4 feature-icon text-green-600">
                        <i class="fas fa-bullhorn text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Aduan & Aspirasi</h3>
                    <p class="text-gray-500 text-sm">Laporkan kendala fasilitas, kebersihan, atau keamanan lingkungan dan pantau tindak lanjut pengurus.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-50">
                    <a href="{{ route('aduan.index') }}" class="text-green-600 text-sm font-semibold inline-flex items-center gap-1 hover:gap-2 transition-all">
                        Laporkan Masalah <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-md p-6 hover-lift border border-gray-100 group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center mb-4 feature-icon text-yellow-600">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Agenda & Jadwal RT</h3>
                    <p class="text-gray-500 text-sm">Jadwal ronda malam, kerja bakti, pertemuan warga, dan kegiatan sosial terorganisir rapi.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-50">
                    <a href="{{ route('kegiatan.index') }}" class="text-yellow-600 text-sm font-semibold inline-flex items-center gap-1 hover:gap-2 transition-all">
                        Lihat Agenda RT <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="bg-white rounded-2xl shadow-md p-6 hover-lift border border-gray-100 group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-4 feature-icon text-purple-600">
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kas & Keuangan</h3>
                    <p class="text-gray-500 text-sm">Transparansi pengelolaan saldo kas RT, pencatatan pemasukan, dan laporan pengeluaran lingkungan.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-50">
                    <a href="{{ route('dashboard') }}" class="text-purple-600 text-sm font-semibold inline-flex items-center gap-1 hover:gap-2 transition-all">
                        Akses Dashboard <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== BAGAIMANA CARA KERJA ========== -->
    <section class="py-16 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="container-custom">
            <div class="text-center mb-12">
                <span class="inline-block bg-white text-blue-700 text-sm font-semibold px-4 py-1.5 rounded-full shadow-sm">
                    <i class="fas fa-rocket mr-1"></i> Alur Praktis
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-3">Cara Kerja Smart RT</h2>
                <p class="text-gray-500 max-w-xl mx-auto mt-2">Hanya 3 langkah mudah, semua permohonan surat dan laporan diproses secara sistematis.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 text-center shadow-md hover-lift transition-all">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-700 text-2xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-800">Daftar / Login</h3>
                    <p class="text-gray-500 text-sm mt-2">Masuk menggunakan NIK atau alamat email yang telah terdaftar di lingkungan RT 03.</p>
                    <i class="fas fa-user-check text-blue-400 mt-4 text-2xl"></i>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-md hover-lift transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-700 text-2xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-800">Pilih Layanan</h3>
                    <p class="text-gray-500 text-sm mt-2">Pilih jenis surat pengantar yang dibutuhkan atau ketikkan aduan Anda beserta detailnya.</p>
                    <i class="fas fa-pen-alt text-green-400 mt-4 text-2xl"></i>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-md hover-lift transition-all">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-700 text-2xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-800">Verifikasi & Selesai</h3>
                    <p class="text-gray-500 text-sm mt-2">Pengurus RT menyetujui, menerbitkan nomor surat, dan dokumen resmi siap diunduh dalam format PDF.</p>
                    <i class="fas fa-download text-purple-400 mt-4 text-2xl"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== PENGUMUMAN & AKTIVITAS DINAMIS ========== -->
    <section class="py-16 bg-gray-50">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div>
                    <span class="bg-red-100 text-red-700 text-sm font-semibold px-3 py-1 rounded-full">
                        <i class="fas fa-newspaper mr-1"></i> Informasi Resmi
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mt-2">Warta & Pengumuman RT Terbaru</h2>
                </div>
                <a href="{{ route('pengumuman.index') }}" class="text-blue-600 font-semibold mt-2 md:mt-0 inline-flex items-center gap-1 hover:gap-2 transition-all text-sm">
                    Lihat Semua Warta <i class="fas fa-chevron-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($pengumumanTerbaru as $p)
                <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition flex gap-4 items-start border border-gray-100">
                    <div class="bg-blue-100 p-3.5 rounded-2xl text-blue-600 text-xl shrink-0">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 px-2 py-0.5 rounded">
                                {{ $p->kategori }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $p->tanggal_publish ? $p->tanggal_publish->isoFormat('D MMMM Y') : '' }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-800 text-base">{{ $p->judul }}</h3>
                        <p class="text-gray-600 text-sm mt-1.5 leading-relaxed">{{ Str::limit($p->isi, 160) }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-2 bg-white rounded-2xl p-8 text-center text-gray-400 text-sm">
                    Belum ada pengumuman yang dipublikasikan.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ========== CTA SECTION ========== -->
    <section class="py-16 bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-800 text-white">
        <div class="container-custom text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-3">Siap Nikmati Kemudahan Administrasi RT?</h2>
            <p class="text-blue-100 max-w-xl mx-auto mb-6 text-sm md:text-base">
                Bergabunglah bersama warga RT 03 / RW 02 lainnya dan rasakan pelayanan administrasi yang transparan, modern, dan tanpa hambatan.
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-700 hover:bg-gray-100 px-6 py-3 rounded-full font-bold shadow-lg transition inline-flex items-center gap-2 text-sm">
                        <i class="fas fa-gauge"></i> Ke Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-700 hover:bg-gray-100 px-6 py-3 rounded-full font-bold shadow-lg transition inline-flex items-center gap-2 text-sm">
                        <i class="fas fa-user-plus"></i> Daftar Akun Warga
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white hover:bg-white/10 px-6 py-3 rounded-full font-bold transition inline-flex items-center gap-2 text-sm">
                        <i class="fas fa-right-to-bracket"></i> Masuk Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white text-xl font-bold mb-3 flex items-center gap-2">
                        <i class="fas fa-microchip text-blue-500"></i> Smart RT
                    </h3>
                    <p class="text-xs leading-relaxed text-gray-400">
                        Platform administrasi kependudukan dan layanan publik digital resmi lingkungan RT 03 / RW 02.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3 text-sm">Layanan Utama</h4>
                    <ul class="text-xs space-y-2">
                        <li><a href="{{ route('surat.index') }}" class="hover:text-white transition">Pengajuan Surat Online</a></li>
                        <li><a href="{{ route('aduan.index') }}" class="hover:text-white transition">Aspirasi & Aduan Warga</a></li>
                        <li><a href="{{ route('kegiatan.index') }}" class="hover:text-white transition">Agenda & Ronda Malam</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="hover:text-white transition">Pengumuman RT</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3 text-sm">Akun & Akses</h4>
                    <ul class="text-xs space-y-2">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login Pengurus / Warga</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Pendaftaran Warga Baru</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Portal Dashboard</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3 text-sm">Sekretariat</h4>
                    <p class="text-xs"><i class="fas fa-map-marker-alt text-blue-400 mr-2"></i> Kantor Sekretariat RT 03 / RW 02</p>
                    <p class="text-xs mt-1"><i class="fas fa-envelope text-blue-400 mr-2"></i> sekretariat@smartrt.local</p>
                    <p class="text-xs mt-1"><i class="fas fa-phone text-blue-400 mr-2"></i> (0331) 543210</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Smart RT Digital - Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>