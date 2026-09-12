<?php

use App\Http\Controllers\AduanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Smart-RT 03
|--------------------------------------------------------------------------
*/

// Halaman Publik
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Autentikasi Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Autentikasi Pengguna Terdaftar (Auth)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Internal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan Profil Pengguna
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Modul Pengajuan Surat
    Route::get('/surat', [PengajuanSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/buat', [PengajuanSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [PengajuanSuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/{id}', [PengajuanSuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{id}/cetak', [PengajuanSuratController::class, 'cetakPdf'])->name('surat.cetak');
    Route::patch('/surat/{id}/status', [PengajuanSuratController::class, 'updateStatus'])
        ->middleware('role:pengurus')
        ->name('surat.status');

    // Modul Aduan Warga
    Route::get('/aduan', [AduanController::class, 'index'])->name('aduan.index');
    Route::get('/aduan/buat', [AduanController::class, 'create'])->name('aduan.create');
    Route::post('/aduan', [AduanController::class, 'store'])->name('aduan.store');
    Route::get('/aduan/{id}', [AduanController::class, 'show'])->name('aduan.show');
    Route::put('/aduan/{id}', [AduanController::class, 'update'])->name('aduan.update');
    Route::delete('/aduan/{id}', [AduanController::class, 'destroy'])->name('aduan.destroy');

    // Modul Kegiatan Lingkungan
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');

    // Modul Pengumuman RT
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');

    // Modul Khusus Pengurus RT (Admin, RT, Sekretaris, Bendahara)
    Route::middleware('role:pengurus')->group(function () {
        // CRUD Data Warga
        Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
        Route::get('/warga/tambah', [WargaController::class, 'create'])->name('warga.create');
        Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
        Route::get('/warga/{id}', [WargaController::class, 'show'])->name('warga.show');
        Route::get('/warga/{id}/edit', [WargaController::class, 'edit'])->name('warga.edit');
        Route::put('/warga/{id}', [WargaController::class, 'update'])->name('warga.update');
        Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');

        // CRUD Kegiatan RT
        Route::get('/kegiatan/tambah', [KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/kegiatan/{id}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
        Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

        // CRUD Pengumuman RT
        Route::get('/pengumuman/tambah', [PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

        // Modul Keuangan Kas RT
        Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
        Route::get('/keuangan/tambah', [KeuanganController::class, 'create'])->name('keuangan.create');
        Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
        Route::get('/keuangan/cetak-laporan', [KeuanganController::class, 'cetakLaporan'])->name('keuangan.cetak');
        Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
    });
});
