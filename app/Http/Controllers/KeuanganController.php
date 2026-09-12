<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeuangan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    /**
     * Tampilkan buku kas RT dengan saldo dinamis dan filter.
     */
    public function index(Request $request)
    {
        $query = TransaksiKeuangan::with('user');

        // Filter jenis (pemasukan / pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', 'like', '%' . $request->input('kategori') . '%');
        }

        // Filter rentang tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->input('tanggal_mulai'));
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->input('tanggal_selesai'));
        }

        $transaksiList = $query->orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Rekapitulasi Kas Real-time
        $saldoKas = TransaksiKeuangan::getSaldo();
        $totalPemasukan = TransaksiKeuangan::getTotalPemasukan();
        $totalPengeluaran = TransaksiKeuangan::getTotalPengeluaran();
        $totalTransaksi = TransaksiKeuangan::count();

        return view('keuangan.index', compact(
            'transaksiList',
            'saldoKas',
            'totalPemasukan',
            'totalPengeluaran',
            'totalTransaksi'
        ));
    }

    /**
     * Tampilkan form input transaksi kas baru.
     */
    public function create()
    {
        return view('keuangan.create');
    }

    /**
     * Simpan transaksi keuangan ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:pemasukan,pengeluaran'],
            'kategori' => ['required', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:1000'],
            'tanggal_transaksi' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
            'bukti_transaksi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'jenis.required' => 'Pilih jenis transaksi (pemasukan atau pengeluaran).',
            'kategori.required' => 'Kategori transaksi wajib diisi.',
            'nominal.required' => 'Nominal transaksi wajib diisi.',
            'nominal.min' => 'Nominal minimal Rp 1.000.',
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib dipilih.',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_transaksi')) {
            $buktiPath = $request->file('bukti_transaksi')->store('bukti_kas', 'public');
        }

        // Buat kode transaksi unik otomatis
        $kodeTransaksi = 'TRX-' . date('Ym') . '-' . sprintf('%04d', TransaksiKeuangan::count() + 1);

        TransaksiKeuangan::create([
            'kode_transaksi' => $kodeTransaksi,
            'jenis' => $validated['jenis'],
            'kategori' => $validated['kategori'],
            'nominal' => $validated['nominal'],
            'tanggal_transaksi' => $validated['tanggal_transaksi'],
            'keterangan' => $validated['keterangan'] ?? null,
            'bukti_transaksi' => $buktiPath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi kas (' . strtoupper($validated['jenis']) . ' Rp ' . number_format($validated['nominal'], 0, ',', '.') . ') berhasil dicatat.');
    }

    /**
     * Hapus transaksi kas.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isBendahara()) {
            abort(403, 'Hanya Admin RT atau Bendahara yang dapat menghapus transaksi kas.');
        }

        $transaksi = TransaksiKeuangan::findOrFail($id);
        $kode = $transaksi->kode_transaksi;
        $transaksi->delete();

        return redirect()->route('keuangan.index')->with('success', 'Catatan transaksi ' . $kode . ' berhasil dihapus.');
    }

    /**
     * Cetak atau unduh laporan kas RT berformat PDF.
     */
    public function cetakLaporan(Request $request)
    {
        $query = TransaksiKeuangan::with('user');

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->input('tanggal_mulai'));
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->input('tanggal_selesai'));
        }

        $transaksi = $query->orderBy('tanggal_transaksi', 'asc')->get();

        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('nominal');
        $saldoPeriode = $totalPemasukan - $totalPengeluaran;

        $bendahara = User::where('role', 'bendahara')->first() ?? Auth::user();
        $ketuaRT = User::whereIn('role', ['admin', 'rt'])->first() ?? Auth::user();

        $pdf = Pdf::loadView('keuangan.cetak_laporan', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoPeriode',
            'bendahara',
            'ketuaRT'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Kas_RT03_' . date('Y-m-d') . '.pdf');
    }
}
