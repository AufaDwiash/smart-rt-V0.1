<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\KartuKeluarga;
use App\Models\Kegiatan;
use App\Models\PengajuanSurat;
use App\Models\Pengumuman;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isPengurus()) {
            $totalWarga = User::where('status_akun', 'aktif')->count();
            $totalKK = KartuKeluarga::count();
            $suratPending = PengajuanSurat::where('status', 'pending')->count();
            $suratSelesai = PengajuanSurat::whereIn('status', ['disetujui', 'selesai'])->count();
            $aduanPending = Aduan::where('status', 'pending')->count();
            $aduanSelesai = Aduan::where('status', 'selesai')->count();

            $saldoKas = TransaksiKeuangan::getSaldo();
            $totalPemasukan = TransaksiKeuangan::getTotalPemasukan();
            $totalPengeluaran = TransaksiKeuangan::getTotalPengeluaran();

            $suratTerbaru = PengajuanSurat::with(['user', 'suratTemplate'])->latest()->take(5)->get();
            $aduanTerbaru = Aduan::with('user')->latest()->take(5)->get();
            $kegiatanMendatang = Kegiatan::where('status', 'mendatang')->orderBy('tanggal_kegiatan')->take(4)->get();
            $transaksiTerbaru = TransaksiKeuangan::latest('tanggal_transaksi')->take(5)->get();

            return view('dashboard.admin', compact(
                'totalWarga',
                'totalKK',
                'suratPending',
                'suratSelesai',
                'aduanPending',
                'aduanSelesai',
                'saldoKas',
                'totalPemasukan',
                'totalPengeluaran',
                'suratTerbaru',
                'aduanTerbaru',
                'kegiatanMendatang',
                'transaksiTerbaru'
            ));
        }

        // Dashboard Warga
        $suratSaya = PengajuanSurat::with('suratTemplate')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $aduanSaya = Aduan::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $pengumumanTerbaru = Pengumuman::where('is_published', true)
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        $kegiatanTerbaru = Kegiatan::where('status', 'mendatang')
            ->orderBy('tanggal_kegiatan')
            ->take(3)
            ->get();

        $totalSuratSaya = PengajuanSurat::where('user_id', $user->id)->count();
        $totalAduanSaya = Aduan::where('user_id', $user->id)->count();
        $suratSiapUnduh = PengajuanSurat::where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'selesai'])
            ->count();

        return view('dashboard.warga', compact(
            'suratSaya',
            'aduanSaya',
            'pengumumanTerbaru',
            'kegiatanTerbaru',
            'totalSuratSaya',
            'totalAduanSaya',
            'suratSiapUnduh'
        ));
    }
}
