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
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.migrations: ~105 rows (approximately)
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
	(52, '2024_10_11_154037_add_foreign_keys_to_users_table', 0),
	(53, '2024_10_16_115218_create_failed_jobs_table', 0),
	(54, '2024_10_16_115218_create_password_reset_tokens_table', 0),
	(55, '2024_10_16_115218_create_personal_access_tokens_table', 0),
	(56, '2024_10_16_115218_create_process_approval_flow_steps_table', 0),
	(57, '2024_10_16_115218_create_process_approval_flows_table', 0),
	(58, '2024_10_16_115218_create_process_approval_statuses_table', 0),
	(59, '2024_10_16_115218_create_process_approvals_table', 0),
	(60, '2024_10_16_115218_create_profiles_table', 0),
	(61, '2024_10_16_115218_create_proposals_table', 0),
	(62, '2024_10_16_115218_create_proposals_copy_table', 0),
	(63, '2024_10_16_115218_create_proposals_copy_2_table', 0),
	(64, '2024_10_16_115218_create_roles_table', 0),
	(65, '2024_10_16_115218_create_users_table', 0),
	(66, '2024_10_16_115221_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(67, '2024_10_16_115221_add_foreign_keys_to_process_approvals_table', 0),
	(68, '2024_10_16_115221_add_foreign_keys_to_profiles_table', 0),
	(69, '2024_10_16_115221_add_foreign_keys_to_proposals_table', 0),
	(70, '2024_10_16_115221_add_foreign_keys_to_proposals_copy_table', 0),
	(71, '2024_10_16_115221_add_foreign_keys_to_proposals_copy_2_table', 0),
	(72, '2024_10_16_115221_add_foreign_keys_to_users_table', 0),
	(73, '2024_10_17_141654_add_api_token_to_users_table', 3),
	(74, '2024_10_17_151248_create_failed_jobs_table', 0),
	(75, '2024_10_17_151248_create_password_reset_tokens_table', 0),
	(76, '2024_10_17_151248_create_personal_access_tokens_table', 0),
	(77, '2024_10_17_151248_create_process_approval_flow_steps_table', 0),
	(78, '2024_10_17_151248_create_process_approval_flows_table', 0),
	(79, '2024_10_17_151248_create_process_approval_statuses_table', 0),
	(80, '2024_10_17_151248_create_process_approvals_table', 0),
	(81, '2024_10_17_151248_create_profiles_table', 0),
	(82, '2024_10_17_151248_create_proposals_table', 0),
	(83, '2024_10_17_151248_create_proposals_copy_table', 0),
	(84, '2024_10_17_151248_create_proposals_copy_2_table', 0),
	(85, '2024_10_17_151248_create_roles_table', 0),
	(86, '2024_10_17_151248_create_users_table', 0),
	(87, '2024_10_17_151251_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(88, '2024_10_17_151251_add_foreign_keys_to_process_approvals_table', 0),
	(89, '2024_10_17_151251_add_foreign_keys_to_profiles_table', 0),
	(90, '2024_10_17_151251_add_foreign_keys_to_proposals_table', 0),
	(91, '2024_10_17_151251_add_foreign_keys_to_proposals_copy_table', 0),
	(92, '2024_10_17_151251_add_foreign_keys_to_proposals_copy_2_table', 0),
	(93, '2024_10_17_151251_add_foreign_keys_to_users_table', 0),
	(94, '2024_10_17_170031_create_failed_jobs_table', 0),
	(95, '2024_10_17_170031_create_password_reset_tokens_table', 0),
	(96, '2024_10_17_170031_create_personal_access_tokens_table', 0),
	(97, '2024_10_17_170031_create_process_approval_flow_steps_table', 0),
	(98, '2024_10_17_170031_create_process_approval_flows_table', 0),
	(99, '2024_10_17_170031_create_process_approval_statuses_table', 0),
	(100, '2024_10_17_170031_create_process_approvals_table', 0),
	(101, '2024_10_17_170031_create_profiles_table', 0),
	(102, '2024_10_17_170031_create_proposals_table', 0),
	(103, '2024_10_17_170031_create_proposals_copy_table', 0),
	(104, '2024_10_17_170031_create_proposals_copy_2_table', 0),
	(105, '2024_10_17_170031_create_roles_table', 0),
	(106, '2024_10_17_170031_create_users_table', 0),
	(107, '2024_10_17_170034_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(108, '2024_10_17_170034_add_foreign_keys_to_process_approvals_table', 0),
	(109, '2024_10_17_170034_add_foreign_keys_to_profiles_table', 0),
	(110, '2024_10_17_170034_add_foreign_keys_to_proposals_table', 0),
	(111, '2024_10_17_170034_add_foreign_keys_to_proposals_copy_table', 0),
	(112, '2024_10_17_170034_add_foreign_keys_to_proposals_copy_2_table', 0),
	(113, '2024_10_17_170034_add_foreign_keys_to_users_table', 0),
	(114, '2024_10_23_120955_create_failed_jobs_table', 0),
	(115, '2024_10_23_120955_create_password_reset_tokens_table', 0),
	(116, '2024_10_23_120955_create_personal_access_tokens_table', 0),
	(117, '2024_10_23_120955_create_process_approval_flow_steps_table', 0),
	(118, '2024_10_23_120955_create_process_approval_flows_table', 0),
	(119, '2024_10_23_120955_create_process_approval_statuses_table', 0),
	(120, '2024_10_23_120955_create_process_approvals_table', 0),
	(121, '2024_10_23_120955_create_profiles_table', 0),
	(122, '2024_10_23_120955_create_proposals_table', 0),
	(123, '2024_10_23_120955_create_proposals_copy_table', 0),
	(124, '2024_10_23_120955_create_proposals_copy_2_table', 0),
	(125, '2024_10_23_120955_create_roles_table', 0),
	(126, '2024_10_23_120955_create_users_table', 0),
	(127, '2024_10_23_120958_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(128, '2024_10_23_120958_add_foreign_keys_to_process_approvals_table', 0),
	(129, '2024_10_23_120958_add_foreign_keys_to_profiles_table', 0),
	(130, '2024_10_23_120958_add_foreign_keys_to_proposals_table', 0),
	(131, '2024_10_23_120958_add_foreign_keys_to_proposals_copy_table', 0),
	(132, '2024_10_23_120958_add_foreign_keys_to_proposals_copy_2_table', 0),
	(133, '2024_10_23_120958_add_foreign_keys_to_users_table', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.profiles: ~12 rows (approximately)
INSERT INTO `profiles` (`id`, `user_id`, `name`, `address`, `phone`, `dob`, `gender`, `occupation`, `about`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 1, 'supervisor', 'A', '0855-5555-55555', '2024-04-04', 'male', 'A', 'A', NULL, '2024-09-25 00:45:53', '2024-09-27 02:26:50'),
	(4, 4, 'Ester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-27 01:02:36', '2024-09-27 01:02:36'),
	(5, 3, 'user2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 03:06:35', '2024-10-08 03:06:35'),
	(6, 6, 'dh_it', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 07:45:52', '2024-10-08 07:45:52'),
	(7, 7, 'adminit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 08:06:31', '2024-10-08 08:06:31'),
	(8, 8, 'Angga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-11 04:25:16', '2024-10-11 04:25:16'),
	(9, 9, 'Andika', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-11 04:26:36', '2024-10-11 04:26:36'),
	(10, 10, 'Eri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-11 04:28:24', '2024-10-11 04:28:24'),
	(13, 13, 'dh_ppic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-17 09:58:31', '2024-10-17 09:58:31'),
	(14, 14, 'divh_ppic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-17 09:59:56', '2024-10-17 09:59:56'),
	(15, 2, 'dh_it', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-22 05:06:32', '2024-10-22 05:06:32'),
	(17, 17, 'Testing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-22 07:01:15', '2024-10-22 07:01:15');

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
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_it` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_asset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_dh` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_divh` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_cr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `proposals_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fams.proposals: ~7 rows (approximately)
INSERT INTO `proposals` (`id`, `no_transaksi`, `user_id`, `user_request`, `user_status`, `departement`, `ext_phone`, `status_barang`, `facility`, `user_note`, `it_analys`, `file`, `file_it`, `no_asset`, `status_dh`, `status_divh`, `status_cr`, `token`, `created_at`, `updated_at`) VALUES
	(155, 'CR202410220002', 4, 'Istir Fiirini', 'Stiff', 'IT', 'kiti cibi piki hirif', 'Pengembalian', 'Infrastruktur -> Monitor', 'Ceritanya balikin barang karna spek nya kurang', NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, '2024-10-22 04:34:45', '2024-10-22 04:34:45'),
	(156, 'CR202410220003', 4, 'FIORINA', 'fiorina', 'MAINTENANCE', '12365789654', 'Pembelian', 'Infrastruktur -> Keyboard / Mouse', 'Ceritanya Request Mouse', NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, '2024-10-22 04:36:43', '2024-10-22 04:36:43'),
	(160, 'CR202410220007', 17, 'Gunawan', 'Head Production', 'ENGINEERING', '088294552272', 'Pembelian', 'Infrastruktur -> Monitor', 'Misal Mesin PC buat OEE', NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, '2024-10-22 07:03:56', '2024-10-22 07:03:56'),
	(169, 'CR202410230001', 17, 'Testing', 'Staff', 'MAINTENANCE', '088294552272', 'Pembelian', 'Infrastruktur -> Monitor', 'Misal butuh beli Monitor', NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, 'MxcsOD0bUeV1nHs1hVagJDVqudO2UOwbbkzo5aPv3XZKJ73N3rIPo39xIByD', '2024-10-23 01:55:03', '2024-10-23 01:55:03'),
	(170, 'CR202410230002', 6, 'Ricky Johannes', 'Staff', 'IT', '081399966715', 'Pembelian', 'Infrastruktur -> Printer / Scanner', 'Tinta Printer Reload', 'Oke sudah diisi ya.', '1729650652.xlsx', '1729650929.jpg', NULL, 'approved', 'approved', 'CR Closed', 'I1koSE1ews0SkywAtKpxdazZebfZOtL2G2OJSRIzlN8I1rKBl0AyiD19tDPB', '2024-10-23 02:30:52', '2024-10-23 02:35:47'),
	(171, 'CR202410230003', 6, 'Ester Fiorina', 'Staff', 'IT', '051454845884', 'Pengembalian', 'Infrastruktur -> Monitor', 'Staff', NULL, NULL, NULL, NULL, 'rejected', 'approved', 'ON PROGRESS', 'n46IN7Lh5upyRe1IwTabfKbm2x95rjjIuiJC1BROQKMQSupu07C6ejm0hKmq', '2024-10-23 02:43:00', '2024-10-23 03:01:08'),
	(172, 'CR202410230004', 6, 'Abcdfg', 'Abcdfg', 'IT', '698488', 'Pengembalian', 'Infrastruktur -> Keyboard / Mouse', 'Abcdfg', NULL, NULL, NULL, NULL, 'approved', 'pending', NULL, 'LLCfMx8lScJUS7cSrvHHIOnN343Y1VpNvsC12f0DFI9UjDdWK3fBwDzk0hy5', '2024-10-23 03:38:08', '2024-10-23 03:38:46');

-- Dumping structure for table fams.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.roles: ~5 rows (approximately)
INSERT INTO `roles` (`id`, `name`) VALUES
	(1, 'divh'),
	(3, 'user'),
	(4, 'dh'),
	(5, 'it');

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
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.users: ~12 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `departement`, `role_id`, `remember_token`, `created_at`, `updated_at`, `api_token`) VALUES
	(1, 'divh_it', 'manifestdpm@gmail.com', '2024-09-25 00:45:53', '$2y$12$wZ7Wxof6Al9VSzFiNLHoyOaCIDZPriy5MUA90PsR4e3SEwYAG.Jzu', 'IT', 1, 'mbZDzSbF2UffVTyAwcL1ZN5J490SeRq3Qyjc1JF1NoIZq6pUMvbBxrElyZwd', '2024-09-25 00:45:53', '2024-10-17 07:47:16', 'p5GourJPX2wkbnbWAjH3t2shzNgQHj7XU7x2ZuWEZYtI4dbmpbfw2lPXDB4R'),
	(2, 'dh_it', 'it.outsource@dp.dharmap.com', '2024-10-22 05:06:32', '$2y$12$Xjm9BbqXMg/CUxpsQRopq.VjT236ivy8KrsSpMMQm/VXs3xkGvTLW', 'IT', 4, NULL, '2024-10-22 05:06:32', '2024-10-22 05:07:41', '4Ot3FHBR0OZjpSnbOk0moL2oiq2S11TRhvfEcpWfmQSHAGSdbNlHhDifedY4'),
	(3, 'it', 'userit@gmail.com', '2024-10-08 03:06:36', '$2y$12$VpkLh9coHrJLol.Ovk6GDuuZmVLp6FlUxdqs9wOSuKoF2uVCoxkSO', 'IT', 5, NULL, '2024-10-08 03:06:35', '2024-10-22 04:38:15', '79xqQO5oHViFu1YxgpbBSZbYY0jlWHRK1B32jyl9t8WSG0tAZEC5g62vRL6v'),
	(4, 'ester', 'fiorinapanjaitan09@gmail.com', '2024-09-27 01:02:36', '$2y$12$JiEPEnUPB/bZgBTfFhVM7uU41iCmX63cD4Va9oPvKV9vkzng7RetK', 'MAINTENANCE', 1, NULL, '2024-09-27 01:02:36', '2024-10-23 01:52:45', 'KVfGfIPjGjqMrmGtAit7b6cVweBjRpKnJqNpcqf9b6OlpQQ9ex7DO2eBOdb9'),
	(6, 'sh_it', 'rickyjop0@gmail.com', '2024-10-08 07:45:52', '$2y$12$zB480GqVUS5n2nvQBBRrxu1qGvjyf5dlBR6leX8wa6OjPbVicJ48i', 'IT', 3, 'qTy86jXtkQx7A1lawx7o77l4bSK2FfrzWTGL2i1pX9kwqwkS4eCpBfAkGXxy', '2024-10-08 07:45:52', '2024-10-17 07:29:48', 'EZij1sRaIB0VUJ67XBxa0VDxjZTKLCkvL6bumecI88hwyRXsrg3itiETulpK'),
	(7, 'adminppic', 'rickyjohannespanjaitan0@gmail.com', '2024-10-08 08:06:31', '$2y$12$WBWzkIUW5rDY60XCHskq6uQgdUiOrtnFKQh/bHYKdLIziaRNiYH1u', 'PPIC', 3, NULL, '2024-10-08 08:06:31', '2024-10-08 08:06:31', NULL),
	(8, 'angga', 'angga.maulana@dp.dharmap.com', '2024-10-11 04:25:16', '$2y$12$Y1hvxvN//9L/E32dSHiUOODkS3jyx978BPrVDbHpLVf6Riljkw0Ba', 'IT', 3, 'SZfTr4Rap1W2Ve5B5aGIPu7Ni0cTfXwm0msdpJW2H7zjP79N9qPtOVjRkmoS', '2024-10-11 04:25:16', '2024-10-23 03:12:16', NULL),
	(9, 'andika', 'andika.prastawa@dp.dharmap.com', '2024-10-11 04:26:36', '$2y$12$ZuKv8Lti2iOtbiWvHeb4HeHU0g3GR4O/UQ5zHLexgmDcXepNhO5WK', 'IT', 4, NULL, '2024-10-11 04:26:36', '2024-10-23 03:11:50', NULL),
	(10, 'eriardiyanto', 'eri.ardiyanto@dp.dharmap.com', '2024-10-11 04:28:24', '$2y$12$owI52JQMYQnuvhFQRp6LcuWNkyKJrbNpDkcQsnmQXNxHD29KHWg2u', 'IT', 1, NULL, '2024-10-11 04:28:24', '2024-10-23 03:11:27', NULL),
	(13, 'dh_ppic', 'listback123@gmail.com', '2024-10-17 09:58:31', '$2y$12$oofNMJMUofrD9L2b5p9P0en2OQVJhUWXSpvd8Cvc2c0zJ1RZw5Upm', 'MAINTENANCE', 4, NULL, '2024-10-17 09:58:31', '2024-10-23 01:53:03', 'CLGDf8tHvRPArCU8o4Py62DEICdcLRk6SMZAKeQxS49nj3dFhF6F29o6xxQW'),
	(14, 'divh_ppic', 'rsitamvan@gmail.com', '2024-10-17 09:59:56', '$2y$12$7o1XtLCKjwk2zVayjvmpReMFsggKzwVc4FqFA81QYCglY/YJqJ3xG', 'PPIC', 1, NULL, '2024-10-17 09:59:56', '2024-10-22 04:22:06', '0EOMlEO6rqqVv7bxO6QYU292q68y4n79EsasSb0TMtahsKNV5kT4tEWvRTs6'),
	(17, 'testing', 'testing@yahoo.com', '2024-10-22 07:01:15', '$2y$12$0cVNqb9rA.Jn865oLPDZle9BHnJ0r6qSuXRyUOwCpUTuSl9iUmS0e', 'MAINTENANCE', 3, NULL, '2024-10-22 07:01:15', '2024-10-23 01:46:28', '7Gypca3AKf6RN4mWge5gcE6g2ecUBqp25BpmKomigHz4UaH776ZRcjUNEXRU');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
