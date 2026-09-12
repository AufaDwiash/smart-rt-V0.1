<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Kegiatan;
use App\Models\PengajuanSurat;
use App\Models\Pengumuman;
use App\Models\SuratTemplate;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $totalWarga = User::where('status_akun', 'aktif')->count();
        $totalSurat = PengajuanSurat::count();
        $totalAduan = Aduan::count();
        $pengumumanTerbaru = Pengumuman::where('is_published', true)->latest('tanggal_publish')->take(4)->get();
        $kegiatanMendatang = Kegiatan::where('status', 'mendatang')->orderBy('tanggal_kegiatan')->take(3)->get();
        $suratTemplates = SuratTemplate::where('is_active', true)->get();

        return view('welcome', compact(
            'totalWarga',
            'totalSurat',
            'totalAduan',
            'pengumumanTerbaru',
            'kegiatanMendatang',
            'suratTemplates'
        ));
    }
}
