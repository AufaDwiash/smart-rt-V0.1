<?php

namespace Database\Seeders;

use App\Models\Aduan;
use App\Models\KartuKeluarga;
use App\Models\Kegiatan;
use App\Models\Notifikasi;
use App\Models\PengajuanSurat;
use App\Models\Pengumuman;
use App\Models\SuratTemplate;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Data Kartu Keluarga
        $kk1 = KartuKeluarga::create([
            'no_kk' => '3509010101010001',
            'kepala_keluarga_nama' => 'H. Ahmad Supriyanto, S.T.',
            'alamat' => 'Jl. Melati No. 01 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'kode_pos' => '68121',
        ]);

        $kk2 = KartuKeluarga::create([
            'no_kk' => '3509010101010002',
            'kepala_keluarga_nama' => 'Bambang Wicaksono, S.Kom.',
            'alamat' => 'Jl. Melati No. 05 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'kode_pos' => '68121',
        ]);

        $kk3 = KartuKeluarga::create([
            'no_kk' => '3509010101010003',
            'kepala_keluarga_nama' => 'Hj. Siti Rahmawati, S.E.',
            'alamat' => 'Jl. Melati No. 08 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'kode_pos' => '68121',
        ]);

        $kk4 = KartuKeluarga::create([
            'no_kk' => '3509010101010004',
            'kepala_keluarga_nama' => 'Budi Darmawan',
            'alamat' => 'Jl. Mawar No. 12 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'kode_pos' => '68121',
        ]);

        $kk5 = KartuKeluarga::create([
            'no_kk' => '3509010101010005',
            'kepala_keluarga_nama' => 'Hendra Wijaya',
            'alamat' => 'Jl. Kenanga No. 04 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'kode_pos' => '68121',
        ]);

        // 2. Data Pengguna (Pengurus & Warga)
        $admin = User::create([
            'nik' => '3509010101010001',
            'no_kk' => '3509010101010001',
            'nama_lengkap' => 'H. Ahmad Supriyanto, S.T.',
            'email' => 'admin@smartrt.local',
            'no_hp' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jember',
            'tanggal_lahir' => '1980-05-12',
            'agama' => 'Islam',
            'pekerjaan' => 'PNS / Wiraswasta',
            'alamat' => 'Jl. Melati No. 01 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Kepala Keluarga',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        $sekretaris = User::create([
            'nik' => '3509010101010002',
            'no_kk' => '3509010101010002',
            'nama_lengkap' => 'Bambang Wicaksono, S.Kom.',
            'email' => 'sekretaris@smartrt.local',
            'no_hp' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => 'sekretaris',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1988-11-20',
            'agama' => 'Islam',
            'pekerjaan' => 'Software Engineer',
            'alamat' => 'Jl. Melati No. 05 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Kepala Keluarga',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        $bendahara = User::create([
            'nik' => '3509010101010003',
            'no_kk' => '3509010101010003',
            'nama_lengkap' => 'Hj. Siti Rahmawati, S.E.',
            'email' => 'bendahara@smartrt.local',
            'no_hp' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'bendahara',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '1985-03-15',
            'agama' => 'Islam',
            'pekerjaan' => 'Akuntan / Wirausaha',
            'alamat' => 'Jl. Melati No. 08 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Kepala Keluarga',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        $warga1 = User::create([
            'nik' => '3509010101010004',
            'no_kk' => '3509010101010004',
            'nama_lengkap' => 'Budi Darmawan',
            'email' => 'warga@smartrt.local',
            'no_hp' => '081234567893',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jember',
            'tanggal_lahir' => '1992-07-04',
            'agama' => 'Islam',
            'pekerjaan' => 'Karyawan Swasta',
            'alamat' => 'Jl. Mawar No. 12 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Kepala Keluarga',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        $warga2 = User::create([
            'nik' => '3509010101010005',
            'no_kk' => '3509010101010004',
            'nama_lengkap' => 'Dewi Lestari',
            'email' => 'dewi@smartrt.local',
            'no_hp' => '081234567894',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '1994-09-18',
            'agama' => 'Islam',
            'pekerjaan' => 'Guru',
            'alamat' => 'Jl. Mawar No. 12 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Istri',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        $warga3 = User::create([
            'nik' => '3509010101010006',
            'no_kk' => '3509010101010004',
            'nama_lengkap' => 'Dimas Prasetyo',
            'email' => 'dimas@smartrt.local',
            'no_hp' => '081234567895',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jember',
            'tanggal_lahir' => '2016-01-25',
            'agama' => 'Islam',
            'pekerjaan' => 'Pelajar',
            'alamat' => 'Jl. Mawar No. 12 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Anak',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        $warga4 = User::create([
            'nik' => '3509010101010007',
            'no_kk' => '3509010101010005',
            'nama_lengkap' => 'Hendra Wijaya',
            'email' => 'hendra@smartrt.local',
            'no_hp' => '081234567896',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '1990-12-08',
            'agama' => 'Kristen',
            'pekerjaan' => 'Wirausaha Kuliner',
            'alamat' => 'Jl. Kenanga No. 04 RT 03/RW 02',
            'rt' => '03',
            'rw' => '02',
            'status_keluarga' => 'Kepala Keluarga',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        // 3. Data Master Template Surat
        $tplDomisili = SuratTemplate::create([
            'nama_surat' => 'Surat Keterangan Domisili',
            'kode_surat' => 'SK-DOM',
            'deskripsi' => 'Surat keterangan domisili tinggal bagi warga di lingkungan RT 03 / RW 02.',
            'persyaratan' => 'Fotokopi KTP dan Kartu Keluarga (KK)',
            'template_surat' => 'Menerangkan bahwa yang bersangkutan benar-benar bertempat tinggal dan berdomisili di lingkungan RT 03 / RW 02.',
            'is_active' => true,
        ]);

        $tplSkck = SuratTemplate::create([
            'nama_surat' => 'Surat Pengantar SKCK',
            'kode_surat' => 'SP-SKCK',
            'deskripsi' => 'Surat pengantar untuk pengurusan Surat Keterangan Catatan Kepolisian ke Polsek/Polres.',
            'persyaratan' => 'Fotokopi KTP, KK, dan Pasfoto 4x6 latar merah (3 lembar)',
            'template_surat' => 'Menerangkan bahwa nama tersebut berkelakuan baik dan tidak sedang tersangkut perkara kriminal untuk keperluan pembuatan SKCK.',
            'is_active' => true,
        ]);

        $tplSku = SuratTemplate::create([
            'nama_surat' => 'Surat Keterangan Usaha (SKU)',
            'kode_surat' => 'SKU',
            'deskripsi' => 'Surat keterangan bukti keberadaan usaha warga di lingkungan RT.',
            'persyaratan' => 'Fotokopi KTP, KK, dan foto tempat/aktivitas usaha',
            'template_surat' => 'Menerangkan bahwa nama tersebut di atas benar-benar memiliki kegiatan usaha yang bertempat di wilayah lingkungan RT 03.',
            'is_active' => true,
        ]);

        $tplSktm = SuratTemplate::create([
            'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'kode_surat' => 'SKTM',
            'deskripsi' => 'Surat keterangan bagi warga yang membutuhkan bantuan sosial atau beasiswa pendidikan.',
            'persyaratan' => 'Fotokopi KTP, KK, dan bukti rekening listrik/air',
            'template_surat' => 'Menerangkan bahwa yang bersangkutan benar dari keluarga prasejahtera yang berdomisili di lingkungan RT 03.',
            'is_active' => true,
        ]);

        $tplKtp = SuratTemplate::create([
            'nama_surat' => 'Surat Pengantar KTP / Kartu Keluarga',
            'kode_surat' => 'SP-KTP',
            'deskripsi' => 'Surat pengantar untuk penerbitan atau perubahan KTP dan Kartu Keluarga ke Kelurahan.',
            'persyaratan' => 'KTP lama / fotokopi KK lama / surat nikah bagi keluarga baru',
            'template_surat' => 'Menerangkan bahwa pemohon adalah warga RT 03 / RW 02 yang mengajukan permohonan penerbitan/perubahan KTP atau KK.',
            'is_active' => true,
        ]);

        // 4. Data Pengumuman Publik & Warga
        Pengumuman::create([
            'judul' => 'Kerja Bakti Kebersihan Lingkungan Menjelang Musim Hujan',
            'isi' => 'Diberitahukan kepada seluruh bapak/ibu warga RT 03 / RW 02, dimohon kehadirannya dalam giat Kerja Bakti massal membersihkan selokan, saluran air, dan pemangkasan dahan pohon yang akan dilaksanakan pada hari Minggu pagi pukul 07.00 WIB. Titik kumpul di depan Pos Ronda.',
            'kategori' => 'Kebersihan',
            'tanggal_publish' => now()->subDays(2),
            'is_published' => true,
            'created_by' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Jadwal Ronda Malam & Siskamling Triwulan Terbaru',
            'isi' => 'Telah terbit pembagian jadwal piket ronda malam untuk periode ini. Mohon partisipasi aktif setiap kepala keluarga/perwakilan regu guna menjaga ketenteraman dan ketertiban lingkungan kita bersama.',
            'kategori' => 'Keamanan',
            'tanggal_publish' => now()->subDays(5),
            'is_published' => true,
            'created_by' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Sosialisasi Program Pelayanan Digital Smart-RT',
            'isi' => 'Untuk mempermudah layanan administrasi pengantar surat dan penyampaian aduan, kini warga RT 03 dapat mengakses portal resmi Smart-RT secara online kapan saja tanpa perlu antre.',
            'kategori' => 'Layanan',
            'tanggal_publish' => now()->subDays(1),
            'is_published' => true,
            'created_by' => $sekretaris->id,
        ]);

        // 5. Data Agenda Kegiatan Lingkungan
        Kegiatan::create([
            'nama_kegiatan' => 'Kerja Bakti Akbar Lingkungan RT 03',
            'deskripsi' => 'Gotong royong membersihkan saluran air dan perapihan taman lingkungan menyambut musim penghujan.',
            'kategori' => 'kerja_bakti',
            'tanggal_kegiatan' => now()->addDays(3)->toDateString(),
            'waktu_mulai' => '07:00 WIB - Selesai',
            'lokasi' => 'Sepanjang Jalan Melati & Lapangan RT 03',
            'penanggung_jawab' => 'Pak Budi Darmawan & Sie Kebersihan',
            'status' => 'mendatang',
            'created_by' => $admin->id,
        ]);

        Kegiatan::create([
            'nama_kegiatan' => 'Senam Sehat Bersama Warga',
            'deskripsi' => 'Kegiatan senam aerobik mingguan untuk menjaga kebugaran warga dan mempererat silaturahmi.',
            'kategori' => 'olahraga',
            'tanggal_kegiatan' => now()->addDays(7)->toDateString(),
            'waktu_mulai' => '06:00 - 07:30 WIB',
            'lokasi' => 'Lapangan Olahraga Blok Barat RT 03',
            'penanggung_jawab' => 'Ibu-ibu PKK RT 03',
            'status' => 'mendatang',
            'created_by' => $admin->id,
        ]);

        Kegiatan::create([
            'nama_kegiatan' => 'Pertemuan Rutin & Musyawarah Warga Bulanan',
            'deskripsi' => 'Agenda pembahasan evaluasi keamanan ronda, laporan kas RT bulanan, dan rencana perbaikan gapura.',
            'kategori' => 'rapat',
            'tanggal_kegiatan' => now()->addDays(12)->toDateString(),
            'waktu_mulai' => '19:30 WIB (Ba’da Isya)',
            'lokasi' => 'Balai Pertemuan / Rumah Ketua RT 03',
            'penanggung_jawab' => 'Sekretaris RT & Ketua RT',
            'status' => 'mendatang',
            'created_by' => $admin->id,
        ]);

        // 6. Data Transaksi Buku Kas Keuangan RT (Data Nyata Berhitung Dinamis)
        TransaksiKeuangan::create([
            'kode_transaksi' => 'TRX-2026-001',
            'jenis' => 'pemasukan',
            'kategori' => 'Saldo Awal',
            'nominal' => 5000000.00,
            'tanggal_transaksi' => now()->subMonths(1)->startOfMonth()->toDateString(),
            'keterangan' => 'Saldo awal kas RT 03 peralihan periode sebelumnya',
            'user_id' => $bendahara->id,
        ]);

        TransaksiKeuangan::create([
            'kode_transaksi' => 'TRX-2026-002',
            'jenis' => 'pemasukan',
            'kategori' => 'Iuran Warga',
            'nominal' => 2400000.00,
            'tanggal_transaksi' => now()->subDays(20)->toDateString(),
            'keterangan' => 'Penerimaan iuran bulanan warga RT 03 bulan lalu',
            'user_id' => $bendahara->id,
        ]);

        TransaksiKeuangan::create([
            'kode_transaksi' => 'TRX-2026-003',
            'jenis' => 'pengeluaran',
            'kategori' => 'Operasional',
            'nominal' => 450000.00,
            'tanggal_transaksi' => now()->subDays(15)->toDateString(),
            'keterangan' => 'Pembelian perlengkapan pos ronda, baterai senter, dan konsumsi ronda malam',
            'user_id' => $bendahara->id,
        ]);

        TransaksiKeuangan::create([
            'kode_transaksi' => 'TRX-2026-004',
            'jenis' => 'pengeluaran',
            'kategori' => 'Kebersihan',
            'nominal' => 350000.00,
            'tanggal_transaksi' => now()->subDays(10)->toDateString(),
            'keterangan' => 'Pembelian kantong sampah besar, sapu lidi, dan pembersih selokan',
            'user_id' => $bendahara->id,
        ]);

        TransaksiKeuangan::create([
            'kode_transaksi' => 'TRX-2026-005',
            'jenis' => 'pemasukan',
            'kategori' => 'Donasi Warga',
            'nominal' => 1000000.00,
            'tanggal_transaksi' => now()->subDays(6)->toDateString(),
            'keterangan' => 'Donasi sukarela perbaikan lampu jalan dari donatur warga',
            'user_id' => $bendahara->id,
        ]);

        TransaksiKeuangan::create([
            'kode_transaksi' => 'TRX-2026-006',
            'jenis' => 'pengeluaran',
            'kategori' => 'Penerangan & Fasilitas',
            'nominal' => 800000.00,
            'tanggal_transaksi' => now()->subDays(3)->toDateString(),
            'keterangan' => 'Penggantian 4 unit lampu LED penerangan jalan umum gang RT 03',
            'user_id' => $bendahara->id,
        ]);

        // 7. Data Aduan Warga
        Aduan::create([
            'user_id' => $warga1->id,
            'judul' => 'Lampu PJU di Tikungan Gang Mawar Mati',
            'isi_aduan' => 'Selamat malam Pak RT, mohon izin menginfokan bahwa lampu penerangan jalan di ujung tikungan gang Mawar sudah mati sejak 2 malam lalu sehingga jalanan gelap saat dilewati warga.',
            'kategori' => 'fasilitas',
            'status' => 'selesai',
            'tanggapan_rt' => 'Terima kasih laporannya Pak Budi. Lampu LED baru sudah dipasang kemarin sore oleh tim teknis RT.',
        ]);

        Aduan::create([
            'user_id' => $warga4->id,
            'judul' => 'Tumpukan Sampah Liar di Sebelah Tanah Kosong',
            'isi_aduan' => 'Ada oknum pembuang sampah liar di tanah kosong batas RT. Mohon dipasang plang larangan buang sampah agar tidak menimbulkan bau tidak sedap.',
            'kategori' => 'kebersihan',
            'status' => 'diproses',
            'tanggapan_rt' => 'Laporan diterima. Kerja bakti Minggu ini akan membersihkan area tersebut dan kami siapkan banner larangan buang sampah.',
        ]);

        // 8. Data Pengajuan Surat Warga
        PengajuanSurat::create([
            'user_id' => $warga1->id,
            'surat_template_id' => $tplDomisili->id,
            'nomor_surat' => '470/012/RT.03/IX/2026',
            'keperluan' => 'Kelengkapan berkas mutasi dan administrasi pendaftaran kerja kantor cabang baru.',
            'status' => 'disetujui',
            'catatan_rt' => 'Surat telah diverifikasi dan disetujui. Silakan unduh PDF resmi dari sistem.',
            'tanggal_pengajuan' => now()->subDays(4),
            'tanggal_selesai' => now()->subDays(3),
        ]);

        PengajuanSurat::create([
            'user_id' => $warga4->id,
            'surat_template_id' => $tplSkck->id,
            'nomor_surat' => null,
            'keperluan' => 'Persyaratan pengurusan berkas SKCK melamar pekerjaan di BUMN.',
            'status' => 'pending',
            'catatan_rt' => null,
            'tanggal_pengajuan' => now()->subHours(5),
            'tanggal_selesai' => null,
        ]);

        // 9. Data Notifikasi Awal
        Notifikasi::create([
            'user_id' => $warga1->id,
            'judul' => 'Pengajuan Surat Selesai',
            'pesan' => 'Surat Keterangan Domisili Anda (Nomor: 470/012/RT.03/IX/2026) telah disetujui dan siap diunduh.',
            'link' => '/surat',
            'is_read' => false,
        ]);
    }
}
