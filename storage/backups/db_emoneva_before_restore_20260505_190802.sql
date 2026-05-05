-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_emoneva
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `db_emoneva`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_emoneva` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_emoneva`;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. PNS, 2. PPPK',
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nuptk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt_pns_tahun` date DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mapel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sertifikasi_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sertifikasi_tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sertifikasi_alasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi_word` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi_powerpoin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi_excel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi_pemrogramman` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi_jaringan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi_multimedia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pelatihan_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. Ya, 2.Tidak',
  `pelatihan_kebutuhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. Ya, 2.Tidak',
  `status_verifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_verifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sekolah_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_sekolah_id_foreign` (`sekolah_id`),
  CONSTRAINT `guru_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru`
--

LOCK TABLES `guru` WRITE;
/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru_kebutuhan`
--

DROP TABLE IF EXISTS `guru_kebutuhan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru_kebutuhan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `nama_pelatihan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_kebutuhan_guru_id_foreign` (`guru_id`),
  CONSTRAINT `guru_kebutuhan_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_kebutuhan`
--

LOCK TABLES `guru_kebutuhan` WRITE;
/*!40000 ALTER TABLE `guru_kebutuhan` DISABLE KEYS */;
/*!40000 ALTER TABLE `guru_kebutuhan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru_pelatihan`
--

DROP TABLE IF EXISTS `guru_pelatihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru_pelatihan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `nama_pelatihan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tingkatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. Pemula, 2.Lanjutan 3. Mahir',
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. Lokal, 2.Nasional 3. Internasional',
  `tahun_pelatihan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_pelatihan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_pelatihan_guru_id_foreign` (`guru_id`),
  CONSTRAINT `guru_pelatihan_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_pelatihan`
--

LOCK TABLES `guru_pelatihan` WRITE;
/*!40000 ALTER TABLE `guru_pelatihan` DISABLE KEYS */;
/*!40000 ALTER TABLE `guru_pelatihan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kecamatan`
--

DROP TABLE IF EXISTS `kecamatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kecamatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kecamatan_kota_id_foreign` (`kota_id`),
  CONSTRAINT `kecamatan_kota_id_foreign` FOREIGN KEY (`kota_id`) REFERENCES `kota` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kecamatan`
--

LOCK TABLES `kecamatan` WRITE;
/*!40000 ALTER TABLE `kecamatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kota`
--

DROP TABLE IF EXISTS `kota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kota` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kota`
--

LOCK TABLES `kota` WRITE;
/*!40000 ALTER TABLE `kota` DISABLE KEYS */;
/*!40000 ALTER TABLE `kota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_06_27_072756_create_kota_table',1),(4,'2025_06_27_072833_create_kecamatan_table',1),(5,'2025_06_27_090029_create_periode_table',1),(6,'2025_08_03_075047_create_sekolah_table',1),(7,'2025_08_03_144901_create_sekolah_sosekbud_table',1),(8,'2025_08_03_165119_create_sekolah_bantuan_status_table',1),(9,'2025_08_03_165127_create_sekolah_bantuan_detail_table',1),(10,'2025_08_04_125252_create_sekolah_fasilitastik_table',1),(11,'2025_08_04_125342_create_sekolah_fasilitastik_lab_table',1),(12,'2025_08_07_026113_create_guru_table',1),(13,'2025_08_07_040837_create_guru_pelatihan_table',1),(14,'2025_08_08_041813_create_guru_kebutuhan_table',1),(15,'2025_09_01_000000_create_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periode`
--

DROP TABLE IF EXISTS `periode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periode` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periode`
--

LOCK TABLES `periode` WRITE;
/*!40000 ALTER TABLE `periode` DISABLE KEYS */;
/*!40000 ALTER TABLE `periode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekolah`
--

DROP TABLE IF EXISTS `sekolah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekolah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `npsn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tingkatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepsek_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepsek_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepsek_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sk_ijin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. NEGERI | 2. SWASTA/YAYASAN',
  `status_akreditasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_tanah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jum_siswa_pria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jum_siswa_wanita` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jum_guru` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_verifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan_id` bigint unsigned DEFAULT NULL,
  `kota_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sekolah_npsn_unique` (`npsn`),
  KEY `sekolah_kecamatan_id_foreign` (`kecamatan_id`),
  KEY `sekolah_kota_id_foreign` (`kota_id`),
  CONSTRAINT `sekolah_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sekolah_kota_id_foreign` FOREIGN KEY (`kota_id`) REFERENCES `kota` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekolah`
--

LOCK TABLES `sekolah` WRITE;
/*!40000 ALTER TABLE `sekolah` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekolah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekolah_bantuan_detail`
--

DROP TABLE IF EXISTS `sekolah_bantuan_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekolah_bantuan_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_bantuan_status_id` bigint unsigned NOT NULL,
  `nama_lembaga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_bantuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_bantuan_detail_sekolah_bantuan_status_id_foreign` (`sekolah_bantuan_status_id`),
  CONSTRAINT `sekolah_bantuan_detail_sekolah_bantuan_status_id_foreign` FOREIGN KEY (`sekolah_bantuan_status_id`) REFERENCES `sekolah_bantuan_status` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekolah_bantuan_detail`
--

LOCK TABLES `sekolah_bantuan_detail` WRITE;
/*!40000 ALTER TABLE `sekolah_bantuan_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekolah_bantuan_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekolah_bantuan_status`
--

DROP TABLE IF EXISTS `sekolah_bantuan_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekolah_bantuan_status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_bantuan_status_sekolah_id_foreign` (`sekolah_id`),
  CONSTRAINT `sekolah_bantuan_status_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekolah_bantuan_status`
--

LOCK TABLES `sekolah_bantuan_status` WRITE;
/*!40000 ALTER TABLE `sekolah_bantuan_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekolah_bantuan_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekolah_fasilitastik`
--

DROP TABLE IF EXISTS `sekolah_fasilitastik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekolah_fasilitastik` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_id` bigint unsigned NOT NULL,
  `listrik_status` enum('ada','tidak') COLLATE utf8mb4_unicode_ci DEFAULT 'tidak',
  `listrik_sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listrik_durasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_kom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `labkom_status` enum('ada','tidak') COLLATE utf8mb4_unicode_ci DEFAULT 'tidak',
  `internet_status` enum('ada','tidak') COLLATE utf8mb4_unicode_ci DEFAULT 'tidak',
  `internet_sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internet_bandwith` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topologi_jaringan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internet_kesesuaian` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internet_alasankuota` text COLLATE utf8mb4_unicode_ci,
  `saran_pengembangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_fasilitastik_sekolah_id_index` (`sekolah_id`),
  CONSTRAINT `sekolah_fasilitastik_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekolah_fasilitastik`
--

LOCK TABLES `sekolah_fasilitastik` WRITE;
/*!40000 ALTER TABLE `sekolah_fasilitastik` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekolah_fasilitastik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekolah_fasilitastik_lab`
--

DROP TABLE IF EXISTS `sekolah_fasilitastik_lab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekolah_fasilitastik_lab` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_fasilitastik_id` bigint unsigned NOT NULL,
  `labkom_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `labkom_jumlah_pc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_fasilitastik_lab_sekolah_fasilitastik_id_foreign` (`sekolah_fasilitastik_id`),
  CONSTRAINT `sekolah_fasilitastik_lab_sekolah_fasilitastik_id_foreign` FOREIGN KEY (`sekolah_fasilitastik_id`) REFERENCES `sekolah_fasilitastik` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekolah_fasilitastik_lab`
--

LOCK TABLES `sekolah_fasilitastik_lab` WRITE;
/*!40000 ALTER TABLE `sekolah_fasilitastik_lab` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekolah_fasilitastik_lab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekolah_sosekbud`
--

DROP TABLE IF EXISTS `sekolah_sosekbud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekolah_sosekbud` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_id` bigint unsigned NOT NULL,
  `kondisi_geografis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_sosekbud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akses_transportasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_sosekbud_sekolah_id_foreign` (`sekolah_id`),
  CONSTRAINT `sekolah_sosekbud_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekolah_sosekbud`
--

LOCK TABLES `sekolah_sosekbud` WRITE;
/*!40000 ALTER TABLE `sekolah_sosekbud` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekolah_sosekbud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6pzSVDu7MnyyOqHU8FNhsIGCZuJFiiBSZjmHhyO6',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8115','YTozOntzOjY6Il90b2tlbiI7czo0MDoieUo1Rk1Pd3F1R0sxbWZRWU1LYm82ZFRIWUROeFh6UTNRUjFNZlRtSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1777981582),('yGRX6daeuM6Q9uC8Nik0evkWBHxiD91efeCOxxHS',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoid3FUN1dqaVg4Slg3c1JBUmppUDlHUUxzOGNqN0VYeUhLc3dma0pTZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=',1777982632);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1. Administrator | 2. Verifikator | 3. Operator Sekolah | 4. Kabalai',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_sekolah_id_foreign` (`sekolah_id`),
  CONSTRAINT `users_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (21,'Ibu Kabalai','kabalai@gmail.com','081187651238','4',NULL,'$2y$12$wOtfeggLEO2RtvRsGmv1wej5YPofPgu/yb2A2wpn1GFHDFZm80qj.',NULL,NULL,'2026-05-05 04:50:46','2026-05-05 04:50:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-05 19:08:03
