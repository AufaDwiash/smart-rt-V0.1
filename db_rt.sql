-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2026 at 02:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rt`
--

-- --------------------------------------------------------

--
-- Table structure for table `aduan`
--

CREATE TABLE `aduan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_aduan` text NOT NULL,
  `foto_aduan` varchar(255) DEFAULT NULL,
  `kategori` enum('keamanan','kebersihan','fasilitas','kebisingan','lainnya') NOT NULL DEFAULT 'lainnya',
  `status` enum('pending','diproses','selesai') NOT NULL DEFAULT 'pending',
  `tanggapan_rt` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aduan`
--

INSERT INTO `aduan` (`id`, `user_id`, `judul`, `isi_aduan`, `foto_aduan`, `kategori`, `status`, `tanggapan_rt`, `created_at`, `updated_at`) VALUES
(1, 4, 'Lampu PJU di Tikungan Gang Mawar Mati', 'Selamat malam Pak RT, mohon izin menginfokan bahwa lampu penerangan jalan di ujung tikungan gang Mawar sudah mati sejak 2 malam lalu sehingga jalanan gelap saat dilewati warga.', NULL, 'fasilitas', 'selesai', 'Terima kasih laporannya Pak Budi. Lampu LED baru sudah dipasang kemarin sore oleh tim teknis RT.', '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(2, 7, 'Tumpukan Sampah Liar di Sebelah Tanah Kosong', 'Ada oknum pembuang sampah liar di tanah kosong batas RT. Mohon dipasang plang larangan buang sampah agar tidak menimbulkan bau tidak sedap.', NULL, 'kebersihan', 'diproses', 'Laporan diterima. Kerja bakti Minggu ini akan membersihkan area tersebut dan kami siapkan banner larangan buang sampah.', '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kartu_keluarga`
--

CREATE TABLE `kartu_keluarga` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_kk` varchar(20) NOT NULL,
  `kepala_keluarga_nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(10) NOT NULL DEFAULT '03',
  `rw` varchar(10) NOT NULL DEFAULT '02',
  `kode_pos` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kartu_keluarga`
--

INSERT INTO `kartu_keluarga` (`id`, `no_kk`, `kepala_keluarga_nama`, `alamat`, `rt`, `rw`, `kode_pos`, `created_at`, `updated_at`) VALUES
(1, '3509010101010001', 'H. Ahmad Supriyanto, S.T.', 'Jl. Melati No. 01 RT 03/RW 02', '03', '02', '68121', '2026-11-16 18:25:21', '2026-11-16 18:25:21'),
(2, '3509010101010002', 'Bambang Wicaksono, S.Kom.', 'Jl. Melati No. 05 RT 03/RW 02', '03', '02', '68121', '2026-11-16 18:25:21', '2026-11-16 18:25:21'),
(3, '3509010101010003', 'Hj. Siti Rahmawati, S.E.', 'Jl. Melati No. 08 RT 03/RW 02', '03', '02', '68121', '2026-11-16 18:25:21', '2026-11-16 18:25:21'),
(4, '3509010101010004', 'Budi Darmawan', 'Jl. Mawar No. 12 RT 03/RW 02', '03', '02', '68121', '2026-11-16 18:25:21', '2026-11-16 18:25:21'),
(5, '3509010101010005', 'Hendra Wijaya', 'Jl. Kenanga No. 04 RT 03/RW 02', '03', '02', '68121', '2026-11-16 18:25:21', '2026-11-16 18:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` enum('kerja_bakti','ronda','rapat','sosial','olahraga','keagamaan','lainnya') NOT NULL DEFAULT 'lainnya',
  `tanggal_kegiatan` date NOT NULL,
  `waktu_mulai` varchar(50) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `penanggung_jawab` varchar(255) DEFAULT NULL,
  `status` enum('mendatang','berlangsung','selesai','dibatalkan') NOT NULL DEFAULT 'mendatang',
  `foto` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `nama_kegiatan`, `deskripsi`, `kategori`, `tanggal_kegiatan`, `waktu_mulai`, `lokasi`, `penanggung_jawab`, `status`, `foto`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Kerja Bakti Akbar Lingkungan RT 03', 'Gotong royong membersihkan saluran air dan perapihan taman lingkungan menyambut musim penghujan.', 'kerja_bakti', '2026-11-20', '07:00 WIB - Selesai', 'Sepanjang Jalan Melati & Lapangan RT 03', 'Pak Budi Darmawan & Sie Kebersihan', 'mendatang', NULL, 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(2, 'Senam Sehat Bersama Warga', 'Kegiatan senam aerobik mingguan untuk menjaga kebugaran warga dan mempererat silaturahmi.', 'olahraga', '2026-11-24', '06:00 - 07:30 WIB', 'Lapangan Olahraga Blok Barat RT 03', 'Ibu-ibu PKK RT 03', 'mendatang', NULL, 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(3, 'Pertemuan Rutin & Musyawarah Warga Bulanan', 'Agenda pembahasan evaluasi keamanan ronda, laporan kas RT bulanan, dan rencana perbaikan gapura.', 'rapat', '2026-11-29', '19:30 WIB (Ba’da Isya)', 'Balai Pertemuan / Rumah Ketua RT 03', 'Sekretaris RT & Ketua RT', 'mendatang', NULL, 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_27_173800_create_surat_templates_table', 1),
(5, '2026_05_27_173807_create_pengajuan_surat_table', 1),
(6, '2026_05_27_173825_create_aduan_table', 1),
(7, '2026_05_27_173850_create_pengumuman_table', 1),
(8, '2026_05_28_031507_create_notifikasi_table', 1),
(9, '2026_09_12_000001_create_kartu_keluarga_table', 1),
(10, '2026_09_12_000002_create_kegiatan_table', 1),
(11, '2026_09_12_000003_create_transaksi_keuangan_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `judul`, `pesan`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 4, 'Pengajuan Surat Selesai', 'Surat Keterangan Domisili Anda (Nomor: 470/012/RT.03/IX/2026) telah disetujui dan siap diunduh.', '/surat', 0, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `surat_template_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_surat` varchar(255) DEFAULT NULL,
  `keperluan` text NOT NULL,
  `file_pendukung` varchar(255) DEFAULT NULL,
  `status` enum('pending','diproses','disetujui','ditolak','selesai') NOT NULL DEFAULT 'pending',
  `catatan_rt` text DEFAULT NULL,
  `tanggal_pengajuan` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai` datetime DEFAULT NULL,
  `file_hasil_surat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `user_id`, `surat_template_id`, `nomor_surat`, `keperluan`, `file_pendukung`, `status`, `catatan_rt`, `tanggal_pengajuan`, `tanggal_selesai`, `file_hasil_surat`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '470/012/RT.03/IX/2026', 'Kelengkapan berkas mutasi dan administrasi pendaftaran kerja kantor cabang baru.', NULL, 'disetujui', 'Surat telah diverifikasi dan disetujui. Silakan unduh PDF resmi dari sistem.', '2026-11-13 01:25:23', '2026-11-14 01:25:23', NULL, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(2, 7, 2, NULL, 'Persyaratan pengurusan berkas SKCK melamar pekerjaan di BUMN.', NULL, 'pending', NULL, '2026-11-16 20:25:23', NULL, NULL, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'Umum',
  `gambar` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `tanggal_publish` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `kategori`, `gambar`, `is_published`, `tanggal_publish`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Kerja Bakti Kebersihan Lingkungan Menjelang Musim Hujan', 'Diberitahukan kepada seluruh bapak/ibu warga RT 03 / RW 02, dimohon kehadirannya dalam giat Kerja Bakti massal membersihkan selokan, saluran air, dan pemangkasan dahan pohon yang akan dilaksanakan pada hari Minggu pagi pukul 07.00 WIB. Titik kumpul di depan Pos Ronda.', 'Kebersihan', NULL, 1, '2026-11-15 01:25:23', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(2, 'Jadwal Ronda Malam & Siskamling Triwulan Terbaru', 'Telah terbit pembagian jadwal piket ronda malam untuk periode ini. Mohon partisipasi aktif setiap kepala keluarga/perwakilan regu guna menjaga ketenteraman dan ketertiban lingkungan kita bersama.', 'Keamanan', NULL, 1, '2026-11-12 01:25:23', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(3, 'Sosialisasi Program Pelayanan Digital Smart-RT', 'Untuk mempermudah layanan administrasi pengantar surat dan penyampaian aduan, kini warga RT 03 dapat mengakses portal resmi Smart-RT secara online kapan saja tanpa perlu antre.', 'Layanan', NULL, 1, '2026-11-16 01:25:23', 2, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BHc4ZtmPlZnckojNIfgcVHG9xXpqozrzUIMQBktY', NULL, '127.0.0.1', 'curl/8.22.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTBXczBRbkZ1SFQ5ZmV5VmxUOWRCblc5M0taaXFYZFREakR2V0NzbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794878798),
('E1RxuRjm6fFBUwvojz1aN95DYqWFcZCZLsXTkozv', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1RRcExESlBCSExRUFdpN2toSnZXV3IwRjhhWTZ3NHNHS0FPdVZUMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1794878855),
('Is1rC53gZTp2ouXYz1Yzq81IYQqNC4PhVAjGVPCp', NULL, '127.0.0.1', 'curl/8.22.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnFSVDhmNGprYlIzYUlkREI3aGhjZjFSOGtsbzVhYnQzVGU4WFRrQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1794878791);

-- --------------------------------------------------------

--
-- Table structure for table `surat_templates`
--

CREATE TABLE `surat_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_surat` varchar(255) NOT NULL,
  `kode_surat` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `persyaratan` text DEFAULT NULL,
  `template_surat` longtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_templates`
--

INSERT INTO `surat_templates` (`id`, `nama_surat`, `kode_surat`, `deskripsi`, `persyaratan`, `template_surat`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Surat Keterangan Domisili', 'SK-DOM', 'Surat keterangan domisili tinggal bagi warga di lingkungan RT 03 / RW 02.', 'Fotokopi KTP dan Kartu Keluarga (KK)', 'Menerangkan bahwa yang bersangkutan benar-benar bertempat tinggal dan berdomisili di lingkungan RT 03 / RW 02.', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(2, 'Surat Pengantar SKCK', 'SP-SKCK', 'Surat pengantar untuk pengurusan Surat Keterangan Catatan Kepolisian ke Polsek/Polres.', 'Fotokopi KTP, KK, dan Pasfoto 4x6 latar merah (3 lembar)', 'Menerangkan bahwa nama tersebut berkelakuan baik dan tidak sedang tersangkut perkara kriminal untuk keperluan pembuatan SKCK.', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(3, 'Surat Keterangan Usaha (SKU)', 'SKU', 'Surat keterangan bukti keberadaan usaha warga di lingkungan RT.', 'Fotokopi KTP, KK, dan foto tempat/aktivitas usaha', 'Menerangkan bahwa nama tersebut di atas benar-benar memiliki kegiatan usaha yang bertempat di wilayah lingkungan RT 03.', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(4, 'Surat Keterangan Tidak Mampu (SKTM)', 'SKTM', 'Surat keterangan bagi warga yang membutuhkan bantuan sosial atau beasiswa pendidikan.', 'Fotokopi KTP, KK, dan bukti rekening listrik/air', 'Menerangkan bahwa yang bersangkutan benar dari keluarga prasejahtera yang berdomisili di lingkungan RT 03.', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(5, 'Surat Pengantar KTP / Kartu Keluarga', 'SP-KTP', 'Surat pengantar untuk penerbitan atau perubahan KTP dan Kartu Keluarga ke Kelurahan.', 'KTP lama / fotokopi KK lama / surat nikah bagi keluarga baru', 'Menerangkan bahwa pemohon adalah warga RT 03 / RW 02 yang mengajukan permohonan penerbitan/perubahan KTP atau KK.', 1, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keuangan`
--

CREATE TABLE `transaksi_keuangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(30) NOT NULL,
  `jenis` enum('pemasukan','pengeluaran') NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_transaksi` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_keuangan`
--

INSERT INTO `transaksi_keuangan` (`id`, `kode_transaksi`, `jenis`, `kategori`, `nominal`, `tanggal_transaksi`, `keterangan`, `bukti_transaksi`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'TRX-2026-001', 'pemasukan', 'Saldo Awal', 5000000.00, '2026-10-01', 'Saldo awal kas RT 03 peralihan periode sebelumnya', NULL, 3, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(2, 'TRX-2026-002', 'pemasukan', 'Iuran Warga', 2400000.00, '2026-10-28', 'Penerimaan iuran bulanan warga RT 03 bulan lalu', NULL, 3, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(3, 'TRX-2026-003', 'pengeluaran', 'Operasional', 450000.00, '2026-11-02', 'Pembelian perlengkapan pos ronda, baterai senter, dan konsumsi ronda malam', NULL, 3, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(4, 'TRX-2026-004', 'pengeluaran', 'Kebersihan', 350000.00, '2026-11-07', 'Pembelian kantong sampah besar, sapu lidi, dan pembersih selokan', NULL, 3, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(5, 'TRX-2026-005', 'pemasukan', 'Donasi Warga', 1000000.00, '2026-11-11', 'Donasi sukarela perbaikan lampu jalan dari donatur warga', NULL, 3, '2026-11-16 18:25:23', '2026-11-16 18:25:23'),
(6, 'TRX-2026-006', 'pengeluaran', 'Penerangan & Fasilitas', 800000.00, '2026-11-14', 'Penggantian 4 unit lampu LED penerangan jalan umum gang RT 03', NULL, 3, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_kk` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','rt','sekretaris','bendahara','warga') NOT NULL DEFAULT 'warga',
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `rt` varchar(10) NOT NULL DEFAULT '03',
  `rw` varchar(10) NOT NULL DEFAULT '02',
  `status_keluarga` enum('Kepala Keluarga','Istri','Anak','Anggota Lain') DEFAULT NULL,
  `status_warga` enum('tetap','kontrak','pindah') NOT NULL DEFAULT 'tetap',
  `foto_profil` varchar(255) DEFAULT NULL,
  `status_akun` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nik`, `no_kk`, `nama_lengkap`, `email`, `no_hp`, `password`, `role`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pekerjaan`, `alamat`, `rt`, `rw`, `status_keluarga`, `status_warga`, `foto_profil`, `status_akun`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '3509010101010001', '3509010101010001', 'H. Ahmad Supriyanto, S.T.', 'admin@smartrt.local', '081234567890', '$2y$12$SFxvOX/n/7JQ2hiFNxfsP.enh.0Oc690xX8FfXHgSvO9VJI6pfBY6', 'admin', 'L', 'Jember', '1980-05-12', 'Islam', 'PNS / Wiraswasta', 'Jl. Melati No. 01 RT 03/RW 02', '03', '02', 'Kepala Keluarga', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:21', '2026-11-16 18:25:21'),
(2, '3509010101010002', '3509010101010002', 'Bambang Wicaksono, S.Kom.', 'sekretaris@smartrt.local', '081234567891', '$2y$12$41WsqxxCxdYroNk6e4vkKe7COaLebQbtUENVpmZtfjXTl9NbZwvVu', 'sekretaris', 'L', 'Surabaya', '1988-11-20', 'Islam', 'Software Engineer', 'Jl. Melati No. 05 RT 03/RW 02', '03', '02', 'Kepala Keluarga', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:21', '2026-11-16 18:25:21'),
(3, '3509010101010003', '3509010101010003', 'Hj. Siti Rahmawati, S.E.', 'bendahara@smartrt.local', '081234567892', '$2y$12$l9XltxbG.IquV8CoEmPsoeCPIZnIsQ.Q58wb.D6.V2yP1i7CRIwKS', 'bendahara', 'P', 'Malang', '1985-03-15', 'Islam', 'Akuntan / Wirausaha', 'Jl. Melati No. 08 RT 03/RW 02', '03', '02', 'Kepala Keluarga', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:22', '2026-11-16 18:25:22'),
(4, '3509010101010004', '3509010101010004', 'Budi Darmawan', 'warga@smartrt.local', '081234567893', '$2y$12$t.Ku385EzpuYqq765twfdOJfvMKvvdEDPqQyOjvHdVFGl7NHxLA5O', 'warga', 'L', 'Jember', '1992-07-04', 'Islam', 'Karyawan Swasta', 'Jl. Mawar No. 12 RT 03/RW 02', '03', '02', 'Kepala Keluarga', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:22', '2026-11-16 18:25:22'),
(5, '3509010101010005', '3509010101010004', 'Dewi Lestari', 'dewi@smartrt.local', '081234567894', '$2y$12$JI4wnnBzrSUYck7miHVOkeP7F6e2HUtXzSOAGRMOMJJttay3ogmN.', 'warga', 'P', 'Banyuwangi', '1994-09-18', 'Islam', 'Guru', 'Jl. Mawar No. 12 RT 03/RW 02', '03', '02', 'Istri', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:22', '2026-11-16 18:25:22'),
(6, '3509010101010006', '3509010101010004', 'Dimas Prasetyo', 'dimas@smartrt.local', '081234567895', '$2y$12$rBPLLPCWihCY0twWt8xwkej9udpbalA75VEIfxumoOzBA3JayJaRK', 'warga', 'L', 'Jember', '2016-01-25', 'Islam', 'Pelajar', 'Jl. Mawar No. 12 RT 03/RW 02', '03', '02', 'Anak', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:22', '2026-11-16 18:25:22'),
(7, '3509010101010007', '3509010101010005', 'Hendra Wijaya', 'hendra@smartrt.local', '081234567896', '$2y$12$G6tLa2DNcPBdGoDAuZuQZuGPzmriYCbbWIWqWCDEN7hxWivdK2BsK', 'warga', 'L', 'Semarang', '1990-12-08', 'Kristen', 'Wirausaha Kuliner', 'Jl. Kenanga No. 04 RT 03/RW 02', '03', '02', 'Kepala Keluarga', 'tetap', NULL, 'aktif', NULL, '2026-11-16 18:25:23', '2026-11-16 18:25:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aduan_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kartu_keluarga`
--
ALTER TABLE `kartu_keluarga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kartu_keluarga_no_kk_unique` (`no_kk`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_created_by_foreign` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasi_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_surat_user_id_foreign` (`user_id`),
  ADD KEY `pengajuan_surat_surat_template_id_foreign` (`surat_template_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengumuman_created_by_foreign` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surat_templates`
--
ALTER TABLE `surat_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `surat_templates_kode_surat_unique` (`kode_surat`);

--
-- Indexes for table `transaksi_keuangan`
--
ALTER TABLE `transaksi_keuangan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksi_keuangan_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transaksi_keuangan_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aduan`
--
ALTER TABLE `aduan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kartu_keluarga`
--
ALTER TABLE `kartu_keluarga`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surat_templates`
--
ALTER TABLE `surat_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi_keuangan`
--
ALTER TABLE `transaksi_keuangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aduan`
--
ALTER TABLE `aduan`
  ADD CONSTRAINT `aduan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `pengajuan_surat_surat_template_id_foreign` FOREIGN KEY (`surat_template_id`) REFERENCES `surat_templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_surat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaksi_keuangan`
--
ALTER TABLE `transaksi_keuangan`
  ADD CONSTRAINT `transaksi_keuangan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
