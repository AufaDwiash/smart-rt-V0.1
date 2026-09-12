<?php

namespace Tests\Feature;

use App\Models\Aduan;
use App\Models\Kegiatan;
use App\Models\PengajuanSurat;
use App\Models\Pengumuman;
use App\Models\SuratTemplate;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartRtTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_returns_ok_with_dynamic_data(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Smart RT');
        $response->assertSee('Warga Terdaftar');
    }

    public function test_login_page_renders_properly(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk ke Sistem');
    }

    public function test_admin_can_login_and_access_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@smartrt.local',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $dash = $this->get('/dashboard');
        $dash->assertStatus(200);
        $dash->assertSee('Dashboard Pengurus RT');
        $dash->assertSee('Saldo Kas RT');
    }

    public function test_warga_can_login_and_access_warga_portal(): void
    {
        $response = $this->post('/login', [
            'login' => 'warga@smartrt.local',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $dash = $this->get('/dashboard');
        $dash->assertStatus(200);
        $dash->assertSee('Portal Warga');
        $dash->assertSee('Riwayat Pengajuan Surat Saya');
    }

    public function test_warga_cannot_access_warga_management_module(): void
    {
        $warga = User::where('role', 'warga')->first();
        $response = $this->actingAs($warga)->get('/warga');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_warga_management(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/warga');
        $response->assertStatus(200);
        $response->assertSee('Daftar Data Kependudukan RT 03');
    }

    public function test_warga_can_submit_letter_request(): void
    {
        $warga = User::where('role', 'warga')->first();
        $template = SuratTemplate::first();

        $response = $this->actingAs($warga)->post('/surat', [
            'surat_template_id' => $template->id,
            'keperluan' => 'Untuk keperluan verifikasi data beasiswa pendidikan anak',
        ]);

        $response->assertRedirect('/surat');
        $this->assertDatabaseHas('pengajuan_surat', [
            'user_id' => $warga->id,
            'surat_template_id' => $template->id,
            'status' => 'pending',
        ]);
    }

    public function test_approved_letter_generates_pdf_successfully(): void
    {
        $admin = User::where('role', 'admin')->first();
        $surat = PengajuanSurat::where('status', 'disetujui')->first();

        if ($surat) {
            $response = $this->actingAs($admin)->get('/surat/' . $surat->id . '/cetak');
            $response->assertStatus(200);
            $this->assertEquals('application/pdf', $response->headers->get('content-type'));
        }
    }

    public function test_kas_calculation_is_dynamic(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pemasukanAwal = TransaksiKeuangan::getTotalPemasukan();
        $saldoAwal = TransaksiKeuangan::getSaldo();

        // Tambah transaksi baru Rp 100.000
        $this->actingAs($admin)->post('/keuangan', [
            'jenis' => 'pemasukan',
            'kategori' => 'Donasi Uji Coba',
            'nominal' => 100000,
            'tanggal_transaksi' => date('Y-m-d'),
            'keterangan' => 'Uji coba integritas saldo kas',
        ]);

        $this->assertEquals($pemasukanAwal + 100000, TransaksiKeuangan::getTotalPemasukan());
        $this->assertEquals($saldoAwal + 100000, TransaksiKeuangan::getSaldo());
    }

    public function test_financial_report_pdf_generation(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/keuangan/cetak-laporan');
        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }
}
