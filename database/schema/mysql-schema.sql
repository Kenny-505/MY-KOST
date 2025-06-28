/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `advance_booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advance_booking` (
  `id_advance` int NOT NULL AUTO_INCREMENT,
  `id_kamar` int NOT NULL,
  `id_user` bigint unsigned NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `status` enum('Active','Cancelled','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_advance`),
  KEY `advance_booking_id_kamar_foreign` (`id_kamar`),
  KEY `advance_booking_id_user_foreign` (`id_user`),
  KEY `idx_advance_booking_dates` (`tanggal_mulai`,`tanggal_selesai`),
  CONSTRAINT `advance_booking_id_kamar_foreign` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`) ON DELETE CASCADE,
  CONSTRAINT `advance_booking_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking` (
  `id_booking` int NOT NULL AUTO_INCREMENT,
  `id_penghuni` int NOT NULL COMMENT 'Primary tenant',
  `id_teman` int DEFAULT NULL COMMENT 'Secondary tenant (nullable)',
  `id_kamar` int NOT NULL,
  `id_paket_kamar` int NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `total_durasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_booking` enum('Aktif','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_booking`),
  KEY `booking_id_penghuni_foreign` (`id_penghuni`),
  KEY `booking_id_teman_foreign` (`id_teman`),
  KEY `booking_id_kamar_foreign` (`id_kamar`),
  KEY `booking_id_paket_kamar_foreign` (`id_paket_kamar`),
  KEY `idx_booking_dates` (`tanggal_mulai`,`tanggal_selesai`),
  CONSTRAINT `booking_id_kamar_foreign` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`) ON DELETE CASCADE,
  CONSTRAINT `booking_id_paket_kamar_foreign` FOREIGN KEY (`id_paket_kamar`) REFERENCES `paket_kamar` (`id_paket_kamar`) ON DELETE CASCADE,
  CONSTRAINT `booking_id_penghuni_foreign` FOREIGN KEY (`id_penghuni`) REFERENCES `penghuni` (`id_penghuni`) ON DELETE CASCADE,
  CONSTRAINT `booking_id_teman_foreign` FOREIGN KEY (`id_teman`) REFERENCES `penghuni` (`id_penghuni`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kamar` (
  `id_kamar` int NOT NULL AUTO_INCREMENT,
  `id_tipe_kamar` int NOT NULL,
  `status` enum('Kosong','Dipesan','Terisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kosong',
  `no_kamar` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_kamar1` longblob,
  `foto_kamar2` longblob,
  `foto_kamar3` longblob,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kamar`),
  UNIQUE KEY `kamar_no_kamar_unique` (`no_kamar`),
  KEY `kamar_id_tipe_kamar_foreign` (`id_tipe_kamar`),
  KEY `idx_kamar_status` (`status`),
  CONSTRAINT `kamar_id_tipe_kamar_foreign` FOREIGN KEY (`id_tipe_kamar`) REFERENCES `tipe_kamar` (`id_tipe_kamar`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paket_kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paket_kamar` (
  `id_paket_kamar` int NOT NULL AUTO_INCREMENT,
  `id_tipe_kamar` int NOT NULL,
  `jenis_paket` enum('Mingguan','Bulanan','Tahunan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas_kamar` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Physical room capacity',
  `jumlah_penghuni` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Number of occupants',
  `harga` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_paket_kamar`),
  KEY `paket_kamar_id_tipe_kamar_foreign` (`id_tipe_kamar`),
  CONSTRAINT `paket_kamar_id_tipe_kamar_foreign` FOREIGN KEY (`id_tipe_kamar`) REFERENCES `tipe_kamar` (`id_tipe_kamar`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `id_booking` int NOT NULL,
  `id_kamar` int NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `status_pembayaran` enum('Belum bayar','Gagal','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum bayar',
  `jumlah_pembayaran` decimal(12,2) NOT NULL,
  `payment_type` enum('Booking','Extension','Additional') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Booking',
  `midtrans_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Midtrans transaction ID',
  `midtrans_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembayaran`),
  KEY `pembayaran_id_user_foreign` (`id_user`),
  KEY `pembayaran_id_booking_foreign` (`id_booking`),
  KEY `pembayaran_id_kamar_foreign` (`id_kamar`),
  KEY `idx_pembayaran_status` (`status_pembayaran`),
  CONSTRAINT `pembayaran_id_booking_foreign` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`) ON DELETE CASCADE,
  CONSTRAINT `pembayaran_id_kamar_foreign` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`) ON DELETE CASCADE,
  CONSTRAINT `pembayaran_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaduan` (
  `id_pengaduan` int NOT NULL AUTO_INCREMENT,
  `id_penghuni` int NOT NULL,
  `id_kamar` int NOT NULL,
  `judul_pengaduan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_pengaduan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu','Diproses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `foto_pengaduan` longblob,
  `tanggal_pengaduan` datetime NOT NULL,
  `response_admin` text COLLATE utf8mb4_unicode_ci,
  `tanggal_response` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengaduan`),
  KEY `pengaduan_id_penghuni_foreign` (`id_penghuni`),
  KEY `pengaduan_id_kamar_foreign` (`id_kamar`),
  KEY `idx_pengaduan_status` (`status`),
  CONSTRAINT `pengaduan_id_kamar_foreign` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`) ON DELETE CASCADE,
  CONSTRAINT `pengaduan_id_penghuni_foreign` FOREIGN KEY (`id_penghuni`) REFERENCES `penghuni` (`id_penghuni`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `penghuni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penghuni` (
  `id_penghuni` int NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `status_penghuni` enum('Aktif','Non-aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penghuni`),
  KEY `penghuni_id_user_foreign` (`id_user`),
  CONSTRAINT `penghuni_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tipe_kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipe_kamar` (
  `id_tipe_kamar` int NOT NULL AUTO_INCREMENT,
  `tipe_kamar` enum('Standar','Elite','Exclusive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fasilitas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipe_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('Admin','User') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

