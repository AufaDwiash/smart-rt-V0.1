<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\PengajuanSurat;
use App\Models\SuratTemplate;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    /**
     * Tampilkan daftar pengajuan surat (Filter berdasarkan role pengguna).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PengajuanSurat::with(['user', 'suratTemplate']);

        if ($user->isWarga()) {
            $query->where('user_id', $user->id);
        } else {
            // Filter pencarian nama pemohon atau nomor surat
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_surat', 'like', "%{$search}%")
                      ->orWhere('keperluan', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('nama_lengkap', 'like', "%{$search}%")
                             ->orWhere('nik', 'like', "%{$search}%");
                      });
                });
            }
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter jenis template surat
        if ($request->filled('surat_template_id')) {
            $query->where('surat_template_id', $request->input('surat_template_id'));
        }

        $suratList = $query->latest('tanggal_pengajuan')->paginate(10)->withQueryString();
        $templates = SuratTemplate::where('is_active', true)->get();

        // Summary counts
        $countPending = $user->isWarga()
            ? PengajuanSurat::where('user_id', $user->id)->where('status', 'pending')->count()
            : PengajuanSurat::where('status', 'pending')->count();

        $countDiproses = $user->isWarga()
            ? PengajuanSurat::where('user_id', $user->id)->where('status', 'diproses')->count()
            : PengajuanSurat::where('status', 'diproses')->count();

        $countSelesai = $user->isWarga()
            ? PengajuanSurat::where('user_id', $user->id)->whereIn('status', ['disetujui', 'selesai'])->count()
            : PengajuanSurat::whereIn('status', ['disetujui', 'selesai'])->count();

        return view('surat.index', compact(
            'suratList',
            'templates',
            'countPending',
            'countDiproses',
            'countSelesai'
        ));
    }

    /**
     * Tampilkan form pembuatan pengajuan surat baru.
     */
    public function create()
    {
        $templates = SuratTemplate::where('is_active', true)->get();
        return view('surat.create', compact('templates'));
    }

    /**
     * Simpan pengajuan surat ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_template_id' => ['required', 'exists:surat_templates,id'],
            'keperluan' => ['required', 'string', 'min:5'],
            'file_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'surat_template_id.required' => 'Pilih jenis surat yang ingin diajukan.',
            'keperluan.required' => 'Keperluan permohonan surat wajib diisi.',
            'keperluan.min' => 'Jelaskan keperluan Anda secara lebih detail (minimal 5 karakter).',
            'file_pendukung.max' => 'Ukuran berkas maksimal 2MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $filePath = $request->file('file_pendukung')->store('surat_pendukung', 'public');
        }

        $pengajuan = PengajuanSurat::create([
            'user_id' => Auth::id(),
            'surat_template_id' => $validated['surat_template_id'],
            'keperluan' => $validated['keperluan'],
            'file_pendukung' => $filePath,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        // Beri notifikasi ke Admin / RT
        $admins = User::whereIn('role', ['admin', 'rt', 'sekretaris'])->get();
        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'judul' => 'Pengajuan Surat Baru',
                'pesan' => Auth::user()->nama_lengkap . ' mengajukan ' . $pengajuan->suratTemplate->nama_surat . '.',
                'link' => route('surat.show', $pengajuan->id, false),
                'is_read' => false,
            ]);
        }

        return redirect()->route('surat.index')->with('success', 'Permohonan surat berhasil dikirimkan. Pengurus RT akan segera memverifikasinya.');
    }

    /**
     * Tampilkan detail pengajuan surat dan panel verifikasi.
     */
    public function show(string $id)
    {
        $surat = PengajuanSurat::with(['user', 'suratTemplate'])->findOrFail($id);

        // Otorisasi: Warga hanya bisa melihat miliknya
        if (Auth::user()->isWarga() && $surat->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan melihat pengajuan surat milik warga lain.');
        }

        return view('surat.show', compact('surat'));
    }

    /**
     * Update status verifikasi pengajuan surat oleh Pengurus RT.
     */
    public function updateStatus(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->isPengurus()) {
            abort(403, 'Hanya pengurus RT yang dapat memverifikasi surat.');
        }

        $surat = PengajuanSurat::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,diproses,disetujui,ditolak,selesai'],
            'nomor_surat' => ['nullable', 'string', 'max:100'],
            'catatan_rt' => ['nullable', 'string'],
        ]);

        // Generate nomor surat otomatis jika disetujui/selesai dan belum ada
        if (in_array($validated['status'], ['disetujui', 'selesai']) && empty($validated['nomor_surat'])) {
            $romawi = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
            $bulan = $romawi[(int) date('m')] ?? 'IX';
            $nomorAuto = sprintf("470/%03d/RT.03/%s/%s", $surat->id, $bulan, date('Y'));
            $validated['nomor_surat'] = $nomorAuto;
        }

        if (in_array($validated['status'], ['disetujui', 'selesai'])) {
            $validated['tanggal_selesai'] = now();
        }

        $surat->update($validated);

        // Kirim notifikasi ke pemohon
        Notifikasi::create([
            'user_id' => $surat->user_id,
            'judul' => 'Status Surat Diperbarui',
            'pesan' => 'Permohonan ' . $surat->suratTemplate->nama_surat . ' Anda kini berstatus: ' . strtoupper($validated['status']) . '.',
            'link' => route('surat.show', $surat->id, false),
            'is_read' => false,
        ]);

        return back()->with('success', 'Status permohonan surat berhasil diperbarui menjadi ' . ucfirst($validated['status']) . '.');
    }

    /**
     * Unduh atau cetak surat resmi format PDF.
     */
    public function cetakPdf(string $id)
    {
        $surat = PengajuanSurat::with(['user', 'suratTemplate'])->findOrFail($id);

        // Pastikan hanya warga pemilik atau pengurus yang dapat mencetak
        if (Auth::user()->isWarga() && $surat->user_id !== Auth::id()) {
            abort(403);
        }

        // Cari ketua RT untuk penandatangan
        $ketuaRT = User::whereIn('role', ['admin', 'rt'])->first() ?? Auth::user();

        $pdf = Pdf::loadView('surat.cetak_pdf', compact('surat', 'ketuaRT'))
            ->setPaper('a4', 'portrait');

        $filename = 'Surat_' . str_replace(' ', '_', $surat->suratTemplate->nama_surat) . '_' . ($surat->nomor_surat ? str_replace('/', '-', $surat->nomor_surat) : $surat->id) . '.pdf';

        return $pdf->stream($filename);
    }
}
