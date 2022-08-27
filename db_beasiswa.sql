-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2022 at 12:35 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_beasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_04_04_154550_create_tbl_jurusan', 1),
(6, '2022_04_04_154642_create_tbl_prodi', 1),
(7, '2022_04_05_234156_create_tbl_kriteria', 1),
(9, '2022_04_06_082933_create_tbl_akademik', 1),
(10, '2022_04_13_160611_create_tbl_semester', 1),
(11, '2022_05_23_123858_create_tbl_siswa', 1),
(12, '2022_05_24_161345_create_tbl_data_beasiswa', 1),
(13, '2022_04_06_032140_create_tbl_beasiswa', 2),
(14, '2022_05_30_050820_create_tbl_subkriteria', 3),
(15, '2014_10_12_000000_create_users_table', 4),
(17, '2022_08_17_110245_create_tbl_ir', 5),
(30, '2022_08_26_035916_create_tbl_perbandingan_kriteria', 6),
(31, '2022_08_26_062234_create_tbl_v_kriteria', 6),
(32, '2022_08_26_114857_create_tbl_perbandingan_alternatif', 6),
(33, '2022_08_26_122258_create_tbl_pv_alternatif', 6),
(34, '2022_08_26_141656_create_tbl_rangkin', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akademik`
--

CREATE TABLE `tbl_akademik` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jalur_seleksi_penerimaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beasiswa`
--

CREATE TABLE `tbl_beasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_beasiswa`
--

INSERT INTO `tbl_beasiswa` (`id`, `title`, `desc`, `created_at`, `updated_at`) VALUES
(9, 'Beasiswa Berprestasi', 'beasiswa untuk berprestasi sa', '2022-08-27 03:01:58', '2022-08-27 03:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_beasiswa`
--

CREATE TABLE `tbl_data_beasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `id_beasiswa` bigint(20) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_data_beasiswa`
--

INSERT INTO `tbl_data_beasiswa` (`id`, `id_siswa`, `id_beasiswa`, `data`, `created_at`, `updated_at`) VALUES
(22, 1, 4, '{\"kepemilikan_kps\":\"50\",\"prestasi_siswa\":\"1\",\"nilai_rapor\":\"80\",\"penghasilan_orang_tua\":\"1500000\",\"tanggungan_orang_tua\":\"5\",\"organisasi\":\"3\"}', '2022-08-16 08:35:19', '2022-08-16 08:35:19'),
(23, 10, 4, '{\"kepemilikan_kps\":\"100\",\"prestasi_siswa\":\"2\",\"nilai_rapor\":\"95\",\"penghasilan_orang_tua\":\"1200000\",\"tanggungan_orang_tua\":\"8\",\"organisasi\":\"5\"}', '2022-08-16 08:35:44', '2022-08-16 08:35:44'),
(24, 11, 4, '{\"kepemilikan_kps\":\"100\",\"prestasi_siswa\":\"5\",\"nilai_rapor\":\"98\",\"penghasilan_orang_tua\":\"800000\",\"tanggungan_orang_tua\":\"2\",\"organisasi\":\"5\"}', '2022-08-16 08:36:25', '2022-08-16 08:36:25'),
(25, 12, 4, '{\"kepemilikan_kps\":\"100\",\"prestasi_siswa\":\"2\",\"nilai_rapor\":\"95\",\"penghasilan_orang_tua\":\"1200000\",\"tanggungan_orang_tua\":\"8\",\"organisasi\":\"6\"}', '2022-08-16 08:37:12', '2022-08-16 08:37:12'),
(26, 1, 7, '{\"a001\":\"4\",\"a002\":\"8\",\"a003\":\"2\"}', '2022-08-17 04:28:23', '2022-08-17 04:28:23'),
(27, 10, 7, '{\"a001\":\"7\",\"a002\":\"4\",\"a003\":\"5\"}', '2022-08-17 04:28:40', '2022-08-17 04:28:40'),
(28, 11, 7, '{\"a001\":\"2\",\"a002\":\"5\",\"a003\":\"7\"}', '2022-08-22 06:12:46', '2022-08-22 06:12:46'),
(31, 14, 9, '{\"tanggung_jawab\":\"1\",\"jujur\":\"1\",\"disiplin\":\"2\"}', '2022-08-27 03:05:35', '2022-08-27 03:05:35'),
(35, 15, 9, '{\"tanggung_jawab\":\"1\",\"jujur\":\"4\",\"disiplin\":\"3\"}', '2022-08-27 03:21:35', '2022-08-27 03:26:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ir`
--

CREATE TABLE `tbl_ir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `nilai` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_ir`
--

INSERT INTO `tbl_ir` (`id`, `jumlah`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, '2022-08-17 11:08:25', '2022-08-16 17:00:00'),
(2, 2, 0.00, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(3, 3, 0.58, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(4, 4, 0.90, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(5, 5, 1.12, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(6, 6, 1.24, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(7, 7, 1.32, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(8, 8, 1.41, '2022-08-17 11:08:25', '2022-08-17 11:08:25'),
(9, 9, 1.45, '2022-08-17 11:09:20', '2022-08-17 11:09:20'),
(10, 10, 1.49, '2022-08-17 11:09:20', '2022-08-17 11:09:20'),
(11, 11, 1.51, '2022-08-17 11:09:50', '2022-08-17 11:09:50'),
(12, 12, 1.48, '2022-08-17 11:09:50', '2022-08-17 11:09:50'),
(13, 13, 1.56, '2022-08-17 11:10:20', '2022-08-17 11:10:20'),
(14, 14, 1.57, '2022-08-17 11:10:20', '2022-08-17 11:10:20'),
(15, 15, 1.59, '2022-08-17 11:11:15', '2022-08-17 11:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan`
--

CREATE TABLE `tbl_jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`id`, `jurusan`, `kode_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'IPA', '01', '2022-05-25 04:50:32', '2022-05-25 04:50:32'),
(2, 'IPS', '02', '2022-05-25 04:50:35', '2022-05-25 04:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kriteria`
--

CREATE TABLE `tbl_kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_beasiswa` bigint(20) NOT NULL,
  `nama_kriteria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` float NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_kriteria`
--

INSERT INTO `tbl_kriteria` (`id`, `id_beasiswa`, `nama_kriteria`, `type`, `bobot`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nilai Rapor', 'Benefit', 80, 1, '2022-05-25 05:05:51', '2022-05-25 05:05:51'),
(2, 1, 'Penghasilan Orangtua', 'Cost', 10, 1, '2022-05-25 05:06:04', '2022-05-26 02:27:11'),
(4, 2, 'Nilai Rapor', 'Benefit', 40, 1, '2022-05-26 03:38:00', '2022-05-31 22:49:13'),
(5, 2, 'Pengahasilan orang tua', 'Cost', 20, 1, '2022-05-26 03:38:23', '2022-05-26 10:11:42'),
(6, 3, 'nilai rapor', 'Benefit', 30, 1, '2022-05-29 06:08:33', '2022-05-29 06:08:33'),
(7, 3, 'pengahasilan orangtua', 'Cost', 40, 1, '2022-05-29 06:08:54', '2022-05-29 06:08:54'),
(8, 3, 'jumlah tanggungan', 'Benefit', 30, 1, '2022-05-29 06:09:25', '2022-05-29 06:09:44'),
(9, 2, 'Memiliki KSP', 'Benefit', 40, 1, '2022-05-31 22:49:24', '2022-05-31 22:49:24'),
(10, 4, 'Kepemilikan kps', 'Benefit', 30, 1, '2022-06-01 00:55:44', '2022-08-10 09:58:35'),
(11, 4, 'Prestasi Siswa', 'Benefit', 20, 1, '2022-06-01 00:55:59', '2022-06-01 00:55:59'),
(12, 4, 'Nilai Rapor', 'Benefit', 25, 1, '2022-06-01 00:56:10', '2022-06-01 00:56:10'),
(13, 4, 'Penghasilan Orang Tua', 'Cost', 15, 1, '2022-06-01 00:56:29', '2022-06-01 00:56:29'),
(14, 4, 'Tanggungan Orang Tua', 'Benefit', 5, 1, '2022-06-01 00:56:41', '2022-06-01 00:56:41'),
(15, 4, 'organisasi', 'Benefit', 5, 1, '2022-06-01 00:56:54', '2022-06-01 00:56:54'),
(16, 5, 'Nilai Rapor', 'Benefit', 20, 1, '2022-07-17 20:20:10', '2022-07-17 20:20:10'),
(17, 5, 'Nilai Rapor', 'Cost', 50, 1, '2022-07-17 20:27:15', '2022-07-17 20:27:15'),
(18, 5, 'Nilai', 'Cost', 70, 1, '2022-07-17 20:27:28', '2022-07-17 20:27:28'),
(20, 7, 'A001', 'Benefit', 5, 1, '2022-08-16 22:02:12', '2022-08-16 22:02:12'),
(21, 7, 'A002', 'Benefit', 10, 1, '2022-08-16 22:02:20', '2022-08-22 00:24:40'),
(22, 7, 'A003', 'Benefit', 8, 1, '2022-08-16 22:02:27', '2022-08-22 00:17:12'),
(24, 8, 'Tanggung jawab', 'Benefit', 2, 1, '2022-08-26 18:54:44', '2022-08-26 18:54:44'),
(25, 8, 'Jujur', 'Benefit', 4, 1, '2022-08-26 18:54:51', '2022-08-26 18:54:51'),
(26, 8, 'Disiplin', 'Benefit', 5, 1, '2022-08-26 18:54:59', '2022-08-26 23:51:35'),
(27, 9, 'Tanggung jawab', 'Benefit', 2, 1, '2022-08-27 03:03:28', '2022-08-27 03:03:28'),
(28, 9, 'Jujur', 'Benefit', 5, 1, '2022-08-27 03:03:35', '2022-08-27 03:27:15'),
(29, 9, 'Disiplin', 'Benefit', 5, 1, '2022-08-27 03:03:42', '2022-08-27 03:03:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perbandingan_alternatif`
--

CREATE TABLE `tbl_perbandingan_alternatif` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif1` int(11) NOT NULL,
  `alternatif2` int(11) NOT NULL,
  `pembanding` int(11) NOT NULL,
  `nilai` double(8,6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_perbandingan_alternatif`
--

INSERT INTO `tbl_perbandingan_alternatif` (`id`, `alternatif1`, `alternatif2`, `pembanding`, `nilai`, `created_at`, `updated_at`) VALUES
(43, 1, 10, 24, 2.000000, '2022-08-26 19:54:20', '2022-08-26 23:49:15'),
(44, 1, 11, 24, 3.000000, '2022-08-26 19:54:20', '2022-08-26 23:49:15'),
(45, 10, 11, 24, 5.000000, '2022-08-26 19:54:20', '2022-08-26 23:49:15'),
(46, 1, 10, 25, 4.000000, '2022-08-26 19:54:44', '2022-08-26 23:49:49'),
(47, 1, 11, 25, 4.000000, '2022-08-26 19:54:44', '2022-08-26 23:49:49'),
(48, 10, 11, 25, 2.000000, '2022-08-26 19:54:44', '2022-08-26 23:49:49'),
(49, 1, 10, 26, 4.000000, '2022-08-26 21:15:59', '2022-08-26 23:50:40'),
(50, 1, 11, 26, 3.000000, '2022-08-26 21:15:59', '2022-08-26 23:50:40'),
(51, 10, 11, 26, 2.000000, '2022-08-26 21:15:59', '2022-08-26 23:50:40'),
(52, 14, 15, 27, 3.000000, '2022-08-27 03:27:38', '2022-08-27 03:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perbandingan_kriteria`
--

CREATE TABLE `tbl_perbandingan_kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kriteria1` int(11) NOT NULL,
  `kriteria2` int(11) NOT NULL,
  `nilai` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_perbandingan_kriteria`
--

INSERT INTO `tbl_perbandingan_kriteria` (`id`, `kriteria1`, `kriteria2`, `nilai`, `created_at`, `updated_at`) VALUES
(16, 24, 25, 1.00, '2022-08-26 19:53:59', '2022-08-26 23:59:01'),
(17, 24, 26, 2.00, '2022-08-26 19:53:59', '2022-08-26 23:59:01'),
(18, 25, 26, 3.00, '2022-08-26 19:53:59', '2022-08-26 23:59:01'),
(19, 27, 28, 1.00, '2022-08-27 03:27:33', '2022-08-27 03:29:48'),
(20, 27, 29, 2.00, '2022-08-27 03:27:33', '2022-08-27 03:29:48'),
(21, 28, 29, 3.00, '2022-08-27 03:27:33', '2022-08-27 03:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prodi`
--

CREATE TABLE `tbl_prodi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_jurusan` bigint(20) NOT NULL,
  `prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pv_alternatif`
--

CREATE TABLE `tbl_pv_alternatif` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` double(8,6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pv_alternatif`
--

INSERT INTO `tbl_pv_alternatif` (`id`, `id_alternatif`, `id_kriteria`, `nilai`, `created_at`, `updated_at`) VALUES
(37, 1, 24, 0.309150, '2022-08-26 19:54:20', '2022-08-26 23:49:15'),
(38, 10, 24, 0.581264, '2022-08-26 19:54:20', '2022-08-26 23:49:15'),
(39, 11, 24, 0.109586, '2022-08-26 19:54:20', '2022-08-26 23:49:15'),
(40, 1, 25, 0.110297, '2022-08-26 19:54:44', '2022-08-26 23:49:49'),
(41, 10, 25, 0.543753, '2022-08-26 19:54:44', '2022-08-26 23:49:49'),
(42, 11, 25, 0.345950, '2022-08-26 19:54:44', '2022-08-26 23:49:49'),
(43, 1, 26, 0.122619, '2022-08-26 21:15:59', '2022-08-26 23:50:40'),
(44, 10, 26, 0.557143, '2022-08-26 21:15:59', '2022-08-26 23:50:40'),
(45, 11, 26, 0.320238, '2022-08-26 21:15:59', '2022-08-26 23:50:40'),
(46, 14, 27, 0.750000, '2022-08-27 03:27:38', '2022-08-27 03:29:38'),
(47, 15, 27, 0.250000, '2022-08-27 03:27:38', '2022-08-27 03:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pv_kriteria`
--

CREATE TABLE `tbl_pv_kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` double(8,6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pv_kriteria`
--

INSERT INTO `tbl_pv_kriteria` (`id`, `id_kriteria`, `nilai`, `created_at`, `updated_at`) VALUES
(22, 24, 0.681563, '2022-08-26 19:53:59', '2022-08-26 19:53:59'),
(23, 25, 0.236447, '2022-08-26 19:53:59', '2022-08-26 19:53:59'),
(24, 26, 0.081990, '2022-08-26 19:53:59', '2022-08-26 19:53:59'),
(25, 24, 0.619963, '2022-08-26 19:56:58', '2022-08-26 19:56:58'),
(26, 25, 0.323938, '2022-08-26 19:56:58', '2022-08-26 19:56:58'),
(27, 26, 0.056099, '2022-08-26 19:56:58', '2022-08-26 19:56:58'),
(28, 24, 0.619963, '2022-08-26 19:57:22', '2022-08-26 19:57:22'),
(29, 25, 0.323938, '2022-08-26 19:57:22', '2022-08-26 19:57:22'),
(30, 26, 0.056099, '2022-08-26 19:57:22', '2022-08-26 19:57:22'),
(31, 24, 0.387302, '2022-08-26 21:14:30', '2022-08-26 21:14:30'),
(32, 25, 0.442857, '2022-08-26 21:14:30', '2022-08-26 21:14:30'),
(33, 26, 0.169841, '2022-08-26 21:14:30', '2022-08-26 21:14:30'),
(34, 24, 0.681563, '2022-08-26 21:15:00', '2022-08-26 21:15:00'),
(35, 25, 0.236447, '2022-08-26 21:15:00', '2022-08-26 21:15:00'),
(36, 26, 0.081990, '2022-08-26 21:15:00', '2022-08-26 21:15:00'),
(37, 24, 0.681563, '2022-08-26 21:37:01', '2022-08-26 21:37:01'),
(38, 25, 0.236447, '2022-08-26 21:37:01', '2022-08-26 21:37:01'),
(39, 26, 0.081990, '2022-08-26 21:37:01', '2022-08-26 21:37:01'),
(40, 24, 0.681563, '2022-08-26 21:46:33', '2022-08-26 21:46:33'),
(41, 25, 0.236447, '2022-08-26 21:46:33', '2022-08-26 21:46:33'),
(42, 26, 0.081990, '2022-08-26 21:46:33', '2022-08-26 21:46:33'),
(43, 24, 0.681563, '2022-08-26 21:47:32', '2022-08-26 21:47:32'),
(44, 25, 0.236447, '2022-08-26 21:47:32', '2022-08-26 21:47:32'),
(45, 26, 0.081990, '2022-08-26 21:47:32', '2022-08-26 21:47:32'),
(46, 24, 0.681563, '2022-08-26 22:48:39', '2022-08-26 22:48:39'),
(47, 25, 0.236447, '2022-08-26 22:48:39', '2022-08-26 22:48:39'),
(48, 26, 0.081990, '2022-08-26 22:48:39', '2022-08-26 22:48:39'),
(49, 24, 0.695238, '2022-08-26 22:54:15', '2022-08-26 22:54:15'),
(50, 25, 0.176190, '2022-08-26 22:54:15', '2022-08-26 22:54:15'),
(51, 26, 0.128571, '2022-08-26 22:54:15', '2022-08-26 22:54:15'),
(52, 24, 0.695238, '2022-08-26 22:54:21', '2022-08-26 22:54:21'),
(53, 25, 0.176190, '2022-08-26 22:54:21', '2022-08-26 22:54:21'),
(54, 26, 0.128571, '2022-08-26 22:54:21', '2022-08-26 22:54:21'),
(55, 24, 0.681563, '2022-08-26 23:38:09', '2022-08-26 23:38:09'),
(56, 25, 0.236447, '2022-08-26 23:38:09', '2022-08-26 23:38:09'),
(57, 26, 0.081990, '2022-08-26 23:38:09', '2022-08-26 23:38:09'),
(58, 24, 0.681563, '2022-08-26 23:40:20', '2022-08-26 23:40:20'),
(59, 25, 0.236447, '2022-08-26 23:40:20', '2022-08-26 23:40:20'),
(60, 26, 0.081990, '2022-08-26 23:40:20', '2022-08-26 23:40:20'),
(61, 24, 0.681563, '2022-08-26 23:48:44', '2022-08-26 23:48:44'),
(62, 25, 0.236447, '2022-08-26 23:48:44', '2022-08-26 23:48:44'),
(63, 26, 0.081990, '2022-08-26 23:48:44', '2022-08-26 23:48:44'),
(64, 24, 0.320657, '2022-08-26 23:56:15', '2022-08-26 23:56:15'),
(65, 25, 0.355627, '2022-08-26 23:56:15', '2022-08-26 23:56:15'),
(66, 26, 0.323716, '2022-08-26 23:56:15', '2022-08-26 23:56:15'),
(67, 24, 0.210724, '2022-08-26 23:56:21', '2022-08-26 23:56:21'),
(68, 25, 0.479243, '2022-08-26 23:56:21', '2022-08-26 23:56:21'),
(69, 26, 0.310033, '2022-08-26 23:56:21', '2022-08-26 23:56:21'),
(70, 24, 0.259402, '2022-08-26 23:56:27', '2022-08-26 23:56:27'),
(71, 25, 0.503846, '2022-08-26 23:56:27', '2022-08-26 23:56:27'),
(72, 26, 0.236752, '2022-08-26 23:56:27', '2022-08-26 23:56:27'),
(73, 24, 0.258497, '2022-08-26 23:56:37', '2022-08-26 23:56:37'),
(74, 25, 0.513399, '2022-08-26 23:56:37', '2022-08-26 23:56:37'),
(75, 26, 0.228105, '2022-08-26 23:56:37', '2022-08-26 23:56:37'),
(76, 24, 0.355556, '2022-08-26 23:58:25', '2022-08-26 23:58:25'),
(77, 25, 0.522222, '2022-08-26 23:58:25', '2022-08-26 23:58:25'),
(78, 26, 0.122222, '2022-08-26 23:58:25', '2022-08-26 23:58:25'),
(79, 24, 0.382492, '2022-08-26 23:58:30', '2022-08-26 23:58:30'),
(80, 25, 0.185522, '2022-08-26 23:58:30', '2022-08-26 23:58:30'),
(81, 26, 0.431987, '2022-08-26 23:58:30', '2022-08-26 23:58:30'),
(82, 24, 0.400000, '2022-08-26 23:58:35', '2022-08-26 23:58:35'),
(83, 25, 0.233333, '2022-08-26 23:58:35', '2022-08-26 23:58:35'),
(84, 26, 0.366667, '2022-08-26 23:58:35', '2022-08-26 23:58:35'),
(85, 24, 0.387302, '2022-08-26 23:59:01', '2022-08-26 23:59:01'),
(86, 25, 0.442857, '2022-08-26 23:59:01', '2022-08-26 23:59:01'),
(87, 26, 0.169841, '2022-08-26 23:59:01', '2022-08-26 23:59:01'),
(88, 27, 0.387302, '2022-08-27 03:27:33', '2022-08-27 03:27:33'),
(89, 28, 0.442857, '2022-08-27 03:27:33', '2022-08-27 03:27:33'),
(90, 29, 0.169841, '2022-08-27 03:27:33', '2022-08-27 03:27:33'),
(91, 27, 0.387302, '2022-08-27 03:29:48', '2022-08-27 03:29:48'),
(92, 28, 0.442857, '2022-08-27 03:29:48', '2022-08-27 03:29:48'),
(93, 29, 0.169841, '2022-08-27 03:29:48', '2022-08-27 03:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rangking`
--

CREATE TABLE `tbl_rangking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_beasiswa` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` double(8,6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_rangking`
--

INSERT INTO `tbl_rangking` (`id`, `id_beasiswa`, `id_alternatif`, `nilai`, `created_at`, `updated_at`) VALUES
(14, 8, 1, 0.246838, '2022-08-26 19:54:47', '2022-08-26 23:50:42'),
(15, 8, 10, 0.570417, '2022-08-26 19:54:47', '2022-08-26 23:50:42'),
(16, 8, 11, 0.182745, '2022-08-26 19:54:47', '2022-08-26 23:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_semester`
--

CREATE TABLE `tbl_semester` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_mahasiswa` bigint(20) NOT NULL,
  `semester` int(11) NOT NULL,
  `ipk` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ayah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ibu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_masuk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jurusan` bigint(20) NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_asal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_sekarang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_tmpt_tinggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber_biaya_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id`, `nama`, `nama_ayah`, `nama_ibu`, `tahun_masuk`, `phone`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `id_jurusan`, `nim`, `alamat_asal`, `alamat_sekarang`, `email`, `status_tmpt_tinggal`, `sumber_biaya_sekolah`, `nomor_kk`, `image`, `created_at`, `updated_at`) VALUES
(14, 'Fara saitul', 'Budi said', 'putri sakinah', '2022', '082382127489', 'Padang', '2022-08-13', 'Wanita', 'Islam', 2, '2230350101', 'Jalan kenangan', 'Jalan kenangan', 'arisa@gmail.com', 'Bersama Orang tua', 'Orang Tua', '12321321313213213', 'images/2LiCVkdmyQsCIKv6dExQASriH0N0ZGLg4iQAGfdh.jpg', '2022-08-27 03:00:32', '2022-08-27 03:00:47'),
(15, 'Rizki Aditya', 'Budi said', 'putri sakinah', '2022', '082382127489', 'Padang Panjang', '2022-08-04', 'Pria', 'Islam', 1, '2230350102', 'Jalan kenangan', 'Jalan kenangan', 'andre@gmail.com', 'Bersama Orang tua', 'Orang Tua', '23131321321313', 'images/pl2z5FaozBUiX7jueCzBnQi18ztQQdnLGLZY9s57.jpg', '2022-08-27 03:02:47', '2022-08-27 03:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subkriteria`
--

CREATE TABLE `tbl_subkriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kriteria` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_subkriteria`
--

INSERT INTO `tbl_subkriteria` (`id`, `id_kriteria`, `title`, `value`, `created_at`, `updated_at`) VALUES
(13, '9', 'Punya', '100', '2022-05-31 22:49:41', '2022-05-31 22:49:41'),
(14, '9', 'Tidak Punya', '50', '2022-05-31 22:49:53', '2022-05-31 22:49:53'),
(15, '9', 'antara ada dan tiada', '50', '2022-06-01 00:08:41', '2022-06-01 00:08:41'),
(20, '10', 'Punya', '100', '2022-06-01 00:59:46', '2022-06-01 00:59:46'),
(21, '10', 'Tida Punya', '50', '2022-06-01 00:59:56', '2022-06-01 00:59:56'),
(22, '20', 'A01 - 01', '4', '2022-08-17 04:24:33', '2022-08-17 04:24:33'),
(23, '20', 'A01-02', '2', '2022-08-17 04:24:45', '2022-08-17 04:24:45'),
(24, '20', 'A01 - 03', '1', '2022-08-17 04:25:31', '2022-08-17 04:25:31'),
(25, '21', 'A02 - 01', '5', '2022-08-17 04:26:05', '2022-08-17 04:26:05'),
(26, '21', 'A02 - 02', '4', '2022-08-17 04:26:17', '2022-08-17 04:26:17'),
(27, '21', 'A02 - 03', '2', '2022-08-17 04:26:27', '2022-08-17 04:26:27'),
(28, '22', 'A03 - 01', '2', '2022-08-17 04:26:55', '2022-08-17 04:26:55'),
(29, '22', 'A03 - 02', '3', '2022-08-17 04:27:07', '2022-08-17 04:27:07'),
(30, '22', 'A03 - 03', '4', '2022-08-17 04:27:31', '2022-08-17 04:27:31'),
(31, '27', 'Sangat bagus', '2', '2022-08-27 03:05:14', '2022-08-27 03:05:14'),
(32, '27', 'Biasa Aja', '1', '2022-08-27 03:05:24', '2022-08-27 03:05:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'admon@gmail.com', '$2y$10$D/Jo4fwpZ5Ngdfdb6LSga..fCHA.pWVdOzmqt1Lf7EX0KnYkpN2vm', '2022-07-29 03:54:35', '2022-07-29 03:54:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tbl_akademik`
--
ALTER TABLE `tbl_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_beasiswa`
--
ALTER TABLE `tbl_beasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_data_beasiswa`
--
ALTER TABLE `tbl_data_beasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ir`
--
ALTER TABLE `tbl_ir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_perbandingan_alternatif`
--
ALTER TABLE `tbl_perbandingan_alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_perbandingan_kriteria`
--
ALTER TABLE `tbl_perbandingan_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_prodi`
--
ALTER TABLE `tbl_prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pv_alternatif`
--
ALTER TABLE `tbl_pv_alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pv_kriteria`
--
ALTER TABLE `tbl_pv_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rangking`
--
ALTER TABLE `tbl_rangking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_siswa_nim_unique` (`nim`);

--
-- Indexes for table `tbl_subkriteria`
--
ALTER TABLE `tbl_subkriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_akademik`
--
ALTER TABLE `tbl_akademik`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_beasiswa`
--
ALTER TABLE `tbl_beasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_data_beasiswa`
--
ALTER TABLE `tbl_data_beasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_ir`
--
ALTER TABLE `tbl_ir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_perbandingan_alternatif`
--
ALTER TABLE `tbl_perbandingan_alternatif`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tbl_perbandingan_kriteria`
--
ALTER TABLE `tbl_perbandingan_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_prodi`
--
ALTER TABLE `tbl_prodi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pv_alternatif`
--
ALTER TABLE `tbl_pv_alternatif`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_pv_kriteria`
--
ALTER TABLE `tbl_pv_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `tbl_rangking`
--
ALTER TABLE `tbl_rangking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_subkriteria`
--
ALTER TABLE `tbl_subkriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
