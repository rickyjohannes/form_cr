-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for fams
CREATE DATABASE IF NOT EXISTS `fams` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fams`;

-- Dumping structure for table fams.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
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

-- Dumping data for table fams.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table fams.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.migrations: ~52 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(4, '2024_06_12_181620_create_roles_table', 1),
	(5, '2024_06_12_181641_create_users_table', 1),
	(6, '2024_06_16_053308_create_profiles_table', 1),
	(7, '2024_06_16_053352_create_proposals_table', 1),
	(8, '1_create_process_approval_flows_table', 2),
	(9, '2_create_process_approval_flow_steps_table', 2),
	(10, '3_create_process_approvals_table', 2),
	(11, '4_create_process_approval_statuses_table', 2),
	(12, '5_add_tenant_ids_to_approval_tables', 2),
	(13, '2024_10_11_091829_create_failed_jobs_table', 0),
	(14, '2024_10_11_091829_create_password_reset_tokens_table', 0),
	(15, '2024_10_11_091829_create_personal_access_tokens_table', 0),
	(16, '2024_10_11_091829_create_process_approval_flow_steps_table', 0),
	(17, '2024_10_11_091829_create_process_approval_flows_table', 0),
	(18, '2024_10_11_091829_create_process_approval_statuses_table', 0),
	(19, '2024_10_11_091829_create_process_approvals_table', 0),
	(20, '2024_10_11_091829_create_profiles_table', 0),
	(21, '2024_10_11_091829_create_proposals_table', 0),
	(22, '2024_10_11_091829_create_proposals_copy_table', 0),
	(23, '2024_10_11_091829_create_proposals_copy_2_table', 0),
	(24, '2024_10_11_091829_create_roles_table', 0),
	(25, '2024_10_11_091829_create_users_table', 0),
	(26, '2024_10_11_091832_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(27, '2024_10_11_091832_add_foreign_keys_to_process_approvals_table', 0),
	(28, '2024_10_11_091832_add_foreign_keys_to_profiles_table', 0),
	(29, '2024_10_11_091832_add_foreign_keys_to_proposals_table', 0),
	(30, '2024_10_11_091832_add_foreign_keys_to_proposals_copy_table', 0),
	(31, '2024_10_11_091832_add_foreign_keys_to_proposals_copy_2_table', 0),
	(32, '2024_10_11_091832_add_foreign_keys_to_users_table', 0),
	(33, '2024_10_11_154034_create_failed_jobs_table', 0),
	(34, '2024_10_11_154034_create_password_reset_tokens_table', 0),
	(35, '2024_10_11_154034_create_personal_access_tokens_table', 0),
	(36, '2024_10_11_154034_create_process_approval_flow_steps_table', 0),
	(37, '2024_10_11_154034_create_process_approval_flows_table', 0),
	(38, '2024_10_11_154034_create_process_approval_statuses_table', 0),
	(39, '2024_10_11_154034_create_process_approvals_table', 0),
	(40, '2024_10_11_154034_create_profiles_table', 0),
	(41, '2024_10_11_154034_create_proposals_table', 0),
	(42, '2024_10_11_154034_create_proposals_copy_table', 0),
	(43, '2024_10_11_154034_create_proposals_copy_2_table', 0),
	(44, '2024_10_11_154034_create_roles_table', 0),
	(45, '2024_10_11_154034_create_users_table', 0),
	(46, '2024_10_11_154037_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(47, '2024_10_11_154037_add_foreign_keys_to_process_approvals_table', 0),
	(48, '2024_10_11_154037_add_foreign_keys_to_profiles_table', 0),
	(49, '2024_10_11_154037_add_foreign_keys_to_proposals_table', 0),
	(50, '2024_10_11_154037_add_foreign_keys_to_proposals_copy_table', 0),
	(51, '2024_10_11_154037_add_foreign_keys_to_proposals_copy_2_table', 0),
	(52, '2024_10_11_154037_add_foreign_keys_to_users_table', 0);

-- Dumping structure for table fams.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table fams.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table fams.process_approvals
CREATE TABLE IF NOT EXISTS `process_approvals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `approvable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approvable_id` bigint unsigned NOT NULL,
  `process_approval_flow_step_id` bigint unsigned DEFAULT NULL,
  `approval_action` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Approved',
  `approver_name` text COLLATE utf8mb4_unicode_ci,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `tenant_id` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `process_approvals_approvable_type_approvable_id_index` (`approvable_type`,`approvable_id`),
  KEY `process_approvals_process_approval_flow_step_id_foreign` (`process_approval_flow_step_id`),
  KEY `process_approvals_user_id_foreign` (`user_id`),
  KEY `process_approvals_tenant_id_index` (`tenant_id`),
  CONSTRAINT `process_approvals_process_approval_flow_step_id_foreign` FOREIGN KEY (`process_approval_flow_step_id`) REFERENCES `process_approval_flow_steps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `process_approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.process_approvals: ~0 rows (approximately)

-- Dumping structure for table fams.process_approval_flows
CREATE TABLE IF NOT EXISTS `process_approval_flows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approvable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.process_approval_flows: ~0 rows (approximately)

-- Dumping structure for table fams.process_approval_flow_steps
CREATE TABLE IF NOT EXISTS `process_approval_flow_steps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `process_approval_flow_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `permissions` json DEFAULT NULL,
  `order` int DEFAULT NULL,
  `action` enum('APPROVE','VERIFY','CHECK') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'APPROVE',
  `active` tinyint NOT NULL DEFAULT '1',
  `tenant_id` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `process_approval_flow_steps_process_approval_flow_id_foreign` (`process_approval_flow_id`),
  KEY `process_approval_flow_steps_role_id_index` (`role_id`),
  KEY `process_approval_flow_steps_order_index` (`order`),
  KEY `process_approval_flow_steps_tenant_id_index` (`tenant_id`),
  CONSTRAINT `process_approval_flow_steps_process_approval_flow_id_foreign` FOREIGN KEY (`process_approval_flow_id`) REFERENCES `process_approval_flows` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.process_approval_flow_steps: ~0 rows (approximately)

-- Dumping structure for table fams.process_approval_statuses
CREATE TABLE IF NOT EXISTS `process_approval_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `approvable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approvable_id` bigint unsigned NOT NULL,
  `steps` json DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Created',
  `creator_id` bigint unsigned DEFAULT NULL,
  `tenant_id` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `process_approval_statuses_approvable_type_approvable_id_index` (`approvable_type`,`approvable_id`),
  KEY `process_approval_statuses_tenant_id_index` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.process_approval_statuses: ~0 rows (approximately)

-- Dumping structure for table fams.profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.profiles: ~10 rows (approximately)
INSERT INTO `profiles` (`id`, `user_id`, `name`, `address`, `phone`, `dob`, `gender`, `occupation`, `about`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 1, 'supervisor', 'A', '0855-5555-55555', '2024-04-04', 'male', 'A', 'A', NULL, '2024-09-25 00:45:53', '2024-09-27 02:26:50'),
	(2, 2, 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-25 00:45:53', '2024-09-25 00:45:53'),
	(3, 3, 'user', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-25 00:45:53', '2024-09-25 00:45:53'),
	(4, 4, 'Ester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-27 01:02:36', '2024-09-27 01:02:36'),
	(5, 5, 'user2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 03:06:35', '2024-10-08 03:06:35'),
	(6, 6, 'dh_it', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 07:45:52', '2024-10-08 07:45:52'),
	(7, 7, 'adminit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 08:06:31', '2024-10-08 08:06:31'),
	(8, 8, 'Angga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-11 04:25:16', '2024-10-11 04:25:16'),
	(9, 9, 'Andika', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-11 04:26:36', '2024-10-11 04:26:36'),
	(10, 10, 'Eri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-11 04:28:24', '2024-10-11 04:28:24');

-- Dumping structure for table fams.proposals
CREATE TABLE IF NOT EXISTS `proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_request` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_barang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facility` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `it_analys` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_dh` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_divh` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `proposals_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fams.proposals: ~8 rows (approximately)
INSERT INTO `proposals` (`id`, `no_transaksi`, `user_id`, `user_request`, `user_status`, `departement`, `ext_phone`, `status_barang`, `facility`, `user_note`, `it_analys`, `status_dh`, `status_divh`, `created_at`, `updated_at`) VALUES
	(51, 'TR-20241008-0001', 5, '1', '1', 'IT', '1', 'Pengembalian', '(Infrastruktur -> Keyboard / Mouse)', '1', NULL, 'rejected', 'rejected', '2024-10-08 04:22:44', '2024-10-09 07:36:49'),
	(52, 'TR-20241008-0002', 5, '2', '2', 'IT', '2', 'Peminjaman', '(Infrastruktur -> Printer / Scanner)', '2', NULL, 'approved', 'rejected', '2024-10-08 04:23:11', '2024-10-09 07:45:07'),
	(56, 'CR-202410080005', 3, 'Ester', 'Staff', 'ACCOUNTING', '4235213513', 'Peminjaman', '(Infrastruktur -> Printer / Scanner)', 'wdawdaw', NULL, 'rejected', 'rejected', '2024-10-08 06:50:58', '2024-10-09 04:22:40'),
	(57, 'CR202410080005', 3, 'Weqw', 'eqweqw', 'ENGINEERING', '5235234', 'Peminjaman', '(Infrastruktur -> Monitor)', '2134124', NULL, 'approved', 'pending', '2024-10-08 06:52:31', '2024-10-09 04:38:12'),
	(59, 'CR202410090002', 3, 'FIORINA', 'STIFF', 'MARKETING', 'KDJFNSDF', 'Pembelian', '(Infrastruktur -> PC / TC)', 'Butuh PC Baru buat di line', NULL, 'pending', 'pending', '2024-10-09 08:19:37', '2024-10-09 08:19:37'),
	(115, 'CR202410110007', 8, '23123', '1321', 'IT', '312313', 'Peminjaman', '(Infrastruktur -> PC / TC)', '32131', NULL, 'approved', 'approved', '2024-10-11 05:49:42', '2024-10-11 06:55:19'),
	(116, 'CR202410110008', 3, 'Ricky', 'Staff', 'IT', '081716171727161', 'Pembelian,Pengembalian', '(Account -> Email),(Infrastruktur -> Printer / Scanner)', 'Jajasjs wnwjwjsjsjshjs', NULL, 'approved', 'approved', '2024-10-11 06:29:47', '2024-10-11 07:08:27'),
	(117, 'CR202410110009', 8, '1', '1', 'IT', '1', 'Pembelian', '(Account -> Email)', '1', NULL, 'approved', 'approved', '2024-10-11 06:56:52', '2024-10-11 07:05:34'),
	(118, 'CR202410110010', 3, '241', '41241234', 'IT', '412412', 'Pembelian', '(Account -> Email)', '41241', NULL, 'approved', 'approved', '2024-10-11 07:00:17', '2024-10-11 07:04:47'),
	(119, 'CR202410110011', 8, 'Angga', 'Ngontrak', 'IT', '331', 'Peminjaman', '(Infrastruktur -> Lan / Telp)', 'Pinjam Wifi Radio,buat kebutuhan test jarak radio untuk pembuatan RT/RW net', NULL, 'approved', 'approved', '2024-10-11 07:36:27', '2024-10-11 07:53:56');

-- Dumping structure for table fams.proposals_copy
CREATE TABLE IF NOT EXISTS `proposals_copy` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectives` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `proposals_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `proposals_copy_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fams.proposals_copy: ~0 rows (approximately)
INSERT INTO `proposals_copy` (`id`, `user_id`, `title`, `description`, `objectives`, `budget`, `status`, `created_at`, `updated_at`) VALUES
	(1, 3, 'A', 'A', 'A', 25000.00, 'rejected', '2024-09-25 00:55:26', '2024-09-25 00:58:12');

-- Dumping structure for table fams.proposals_copy_2
CREATE TABLE IF NOT EXISTS `proposals_copy_2` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_request` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_barang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facility` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `it_analys` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `proposals_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `proposals_copy_2_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fams.proposals_copy_2: ~7 rows (approximately)
INSERT INTO `proposals_copy_2` (`id`, `no_transaksi`, `user_id`, `user_request`, `user_status`, `departement`, `ext_phone`, `status_barang`, `facility`, `user_note`, `it_analys`, `status`, `created_at`, `updated_at`) VALUES
	(51, 'TR-20241008-0001', 5, '1', '1', 'IT', '1', 'Pengembalian', '(Infrastruktur -> Keyboard / Mouse)', '1', NULL, 'approved', '2024-10-08 04:22:44', '2024-10-08 04:31:19'),
	(52, 'TR-20241008-0002', 5, '2', '2', 'IT', '2', 'Peminjaman', '(Infrastruktur -> Printer / Scanner)', '2', NULL, 'pending', '2024-10-08 04:23:11', '2024-10-09 03:36:57'),
	(54, 'TR-20241008-0003', 3, 'Naufal', 'Staff', 'IT', '412412412', 'Peminjaman', '(Infrastruktur -> Printer / Scanner)', 'afafa', NULL, 'pending', '2024-10-08 04:27:58', '2024-10-08 04:28:48'),
	(55, 'TR-20241008-0004', 3, 'Ester', 'Staff', 'MARKETING', '14221414', 'Pembelian', '(Account -> Internet)', 'rfawfaw241412', NULL, 'approved', '2024-10-08 04:28:14', '2024-10-08 04:28:14'),
	(56, 'CR-202410080005', 3, 'Ester', 'Staff', 'ACCOUNTING', '4235213513', 'Peminjaman', '(Infrastruktur -> Printer / Scanner)', 'wdawdaw', NULL, 'pending', '2024-10-08 06:50:58', '2024-10-08 06:50:58'),
	(57, 'CR202410080005', 3, 'Weqw', 'eqweqw', 'ENGINEERING', '5235234', 'Peminjaman', '(Infrastruktur -> Monitor)', '2134124', NULL, 'pending', '2024-10-08 06:52:31', '2024-10-08 06:52:31'),
	(58, 'CR202410090001', 3, 'Ricky', 'Staff', 'IT', '2412421', 'Pembelian', '(Account -> Email)', '4241', NULL, 'rejected', '2024-10-09 02:38:45', '2024-10-09 02:49:51');

-- Dumping structure for table fams.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`) VALUES
	(1, 'supervisor'),
	(2, 'admin'),
	(3, 'user'),
	(4, 'dh_it');

-- Dumping structure for table fams.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint unsigned NOT NULL DEFAULT '3',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.users: ~10 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `departement`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'supervisor', 'manifestdpm@gmail.com', '2024-09-25 00:45:53', '$2y$12$wZ7Wxof6Al9VSzFiNLHoyOaCIDZPriy5MUA90PsR4e3SEwYAG.Jzu', 'IT', 1, NULL, '2024-09-25 00:45:53', '2024-09-25 00:45:53'),
	(2, 'admin', 'admin@gmail.com', '2024-09-25 00:45:53', '$2y$12$wZ7Wxof6Al9VSzFiNLHoyOaCIDZPriy5MUA90PsR4e3SEwYAG.Jzu', '', 2, NULL, '2024-09-25 00:45:53', '2024-09-25 00:45:53'),
	(3, 'user', 'rickyjop0@gmail.com', '2024-09-25 00:45:53', '$2y$12$I/D0piWaMB3laHAjWaqP3uN8d/m9hly5J4T5OO3GclMZNQJ0y4Bya', 'IT', 3, NULL, '2024-09-25 00:45:53', '2024-09-25 01:02:53'),
	(4, 'ester', 'ester@gmail.com', '2024-09-27 01:02:36', '$2y$12$JiEPEnUPB/bZgBTfFhVM7uU41iCmX63cD4Va9oPvKV9vkzng7RetK', '', 2, NULL, '2024-09-27 01:02:36', '2024-09-27 01:02:36'),
	(5, 'user2', 'user2@gmail.com', '2024-10-08 03:06:36', '$2y$12$VpkLh9coHrJLol.Ovk6GDuuZmVLp6FlUxdqs9wOSuKoF2uVCoxkSO', '', 3, NULL, '2024-10-08 03:06:35', '2024-10-08 03:06:36'),
	(6, 'dh_it', 'it.outsource@dp.dharmap.com', '2024-10-08 07:45:52', '$2y$12$zB480GqVUS5n2nvQBBRrxu1qGvjyf5dlBR6leX8wa6OjPbVicJ48i', 'IT', 4, NULL, '2024-10-08 07:45:52', '2024-10-08 07:45:52'),
	(7, 'adminit', 'rickyjohannespanjaitan0@gmail.com', '2024-10-08 08:06:31', '$2y$12$WBWzkIUW5rDY60XCHskq6uQgdUiOrtnFKQh/bHYKdLIziaRNiYH1u', 'IT', 4, NULL, '2024-10-08 08:06:31', '2024-10-08 08:06:31'),
	(8, 'angga', 'angga.maulana@dp.dharmap.com', '2024-10-11 04:25:16', '$2y$12$Y1hvxvN//9L/E32dSHiUOODkS3jyx978BPrVDbHpLVf6Riljkw0Ba', 'IT', 3, 'SZfTr4Rap1W2Ve5B5aGIPu7Ni0cTfXwm0msdpJW2H7zjP79N9qPtOVjRkmoS', '2024-10-11 04:25:16', '2024-10-11 04:25:16'),
	(9, 'andika', 'andika.prastawa@dp.dharmap.com', '2024-10-11 04:26:36', '$2y$12$ZuKv8Lti2iOtbiWvHeb4HeHU0g3GR4O/UQ5zHLexgmDcXepNhO5WK', 'IT', 4, NULL, '2024-10-11 04:26:36', '2024-10-11 04:26:36'),
	(10, 'eriardiyanto', 'eri.ardiyanto@dp.dharmap.com', '2024-10-11 04:28:24', '$2y$12$owI52JQMYQnuvhFQRp6LcuWNkyKJrbNpDkcQsnmQXNxHD29KHWg2u', 'IT', 1, NULL, '2024-10-11 04:28:24', '2024-10-11 04:28:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
