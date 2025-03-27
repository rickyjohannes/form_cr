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
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.migrations: ~142 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
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
	(133, '2024_10_23_120958_add_foreign_keys_to_users_table', 0),
	(134, '2024_10_23_162132_create_failed_jobs_table', 0),
	(135, '2024_10_23_162132_create_password_reset_tokens_table', 0),
	(136, '2024_10_23_162132_create_personal_access_tokens_table', 0),
	(137, '2024_10_23_162132_create_process_approval_flow_steps_table', 0),
	(138, '2024_10_23_162132_create_process_approval_flows_table', 0),
	(139, '2024_10_23_162132_create_process_approval_statuses_table', 0),
	(140, '2024_10_23_162132_create_process_approvals_table', 0),
	(141, '2024_10_23_162132_create_profiles_table', 0),
	(142, '2024_10_23_162132_create_proposals_table', 0),
	(143, '2024_10_23_162132_create_roles_table', 0),
	(144, '2024_10_23_162132_create_users_table', 0),
	(145, '2024_10_23_162135_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(146, '2024_10_23_162135_add_foreign_keys_to_process_approvals_table', 0),
	(147, '2024_10_23_162135_add_foreign_keys_to_profiles_table', 0),
	(148, '2024_10_23_162135_add_foreign_keys_to_proposals_table', 0),
	(149, '2024_10_23_162135_add_foreign_keys_to_users_table', 0),
	(150, '2024_10_25_100429_create_failed_jobs_table', 0),
	(151, '2024_10_25_100429_create_password_reset_tokens_table', 0),
	(152, '2024_10_25_100429_create_personal_access_tokens_table', 0),
	(153, '2024_10_25_100429_create_process_approval_flow_steps_table', 0),
	(154, '2024_10_25_100429_create_process_approval_flows_table', 0),
	(155, '2024_10_25_100429_create_process_approval_statuses_table', 0),
	(156, '2024_10_25_100429_create_process_approvals_table', 0),
	(157, '2024_10_25_100429_create_profiles_table', 0),
	(158, '2024_10_25_100429_create_proposals_table', 0),
	(159, '2024_10_25_100429_create_roles_table', 0),
	(160, '2024_10_25_100429_create_users_table', 0),
	(161, '2024_10_25_100432_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(162, '2024_10_25_100432_add_foreign_keys_to_process_approvals_table', 0),
	(163, '2024_10_25_100432_add_foreign_keys_to_profiles_table', 0),
	(164, '2024_10_25_100432_add_foreign_keys_to_proposals_table', 0),
	(165, '2024_10_25_100432_add_foreign_keys_to_users_table', 0),
	(166, '2024_11_07_111139_create_failed_jobs_table', 0),
	(167, '2024_11_07_111139_create_password_reset_tokens_table', 0),
	(168, '2024_11_07_111139_create_personal_access_tokens_table', 0),
	(169, '2024_11_07_111139_create_process_approval_flow_steps_table', 0),
	(170, '2024_11_07_111139_create_process_approval_flows_table', 0),
	(171, '2024_11_07_111139_create_process_approval_statuses_table', 0),
	(172, '2024_11_07_111139_create_process_approvals_table', 0),
	(173, '2024_11_07_111139_create_profiles_table', 0),
	(174, '2024_11_07_111139_create_proposals_table', 0),
	(175, '2024_11_07_111139_create_roles_table', 0),
	(176, '2024_11_07_111139_create_users_table', 0),
	(177, '2024_11_07_111142_add_foreign_keys_to_process_approval_flow_steps_table', 0),
	(178, '2024_11_07_111142_add_foreign_keys_to_process_approvals_table', 0),
	(179, '2024_11_07_111142_add_foreign_keys_to_profiles_table', 0),
	(180, '2024_11_07_111142_add_foreign_keys_to_proposals_table', 0),
	(181, '2024_11_07_111142_add_foreign_keys_to_users_table', 0);

-- Dumping structure for table fams.monitoring_stock
CREATE TABLE IF NOT EXISTS `monitoring_stock` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesifikasi_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_transaksi` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.monitoring_stock: ~0 rows (approximately)
REPLACE INTO `monitoring_stock` (`id`, `type_barang`, `spesifikasi_barang`, `barcode`, `status_transaksi`, `created_at`, `updated_at`) VALUES
	(1, 'HARDWARE', 'Kabel Charger Laptop', 'WAdaW )AW*0eq2=4204-1o2erasfq24 22341++_+_---- 4124raw', 1, '2024-12-05 04:48:27', '2024-12-05 08:45:09'),
	(2, 'HARDWARE', 'LAPTOP', '4124141241412weaedaw', 1, '2024-12-05 08:48:07', '2024-12-05 08:48:26'),
	(3, 'HARDWARE', 'MOUSE', '4124214124', 0, '2024-12-05 08:54:47', '2024-12-05 08:54:47'),
	(4, 'HARDWARE', 'KABEL HDMI', '412414124qwrawrawer', 1, '2024-12-05 08:55:10', '2024-12-05 08:57:27'),
	(5, 'CONSUMABLE', 'HANDPHONE', '4124qwW*&@*$&Q)@@&$)(@', 1, '2024-12-05 08:57:52', '2024-12-05 08:58:11'),
	(6, 'CONSUMABLE', 'LAPTOP GAMING', 'rq523y8Y&*&*@$*Q@&$)Q@RAswfa', 1, '2024-12-05 09:01:07', '2024-12-05 09:02:15'),
	(7, 'HARDWARE', 'LAPTOP GAMING', 'rq523y8Y&*&*@$*Q@&$)Q@RAswfa241242q1', 0, '2024-12-05 09:01:24', '2024-12-05 09:01:24'),
	(8, 'CONSUMABLE', 'LAPTOP GAMING', 'rq523y8Y&*&*@$*Q@&$)Q@RAswfa2512521q4rezAWeA', 0, '2024-12-05 09:01:52', '2024-12-05 09:01:52');

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.profiles: ~0 rows (approximately)
REPLACE INTO `profiles` (`id`, `user_id`, `name`, `address`, `phone`, `dob`, `gender`, `occupation`, `about`, `photo`, `created_at`, `updated_at`) VALUES
	(23, 100, 'Aji Kusuma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-03 08:12:04', '2024-12-03 08:12:04');

-- Dumping structure for table fams.proposals
CREATE TABLE IF NOT EXISTS `proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `it_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_request` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_barang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facility` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_note` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_asset_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_date` timestamp NULL DEFAULT NULL,
  `estimated_start_date` timestamp NULL DEFAULT NULL,
  `estimated_date` timestamp NULL DEFAULT NULL,
  `action_it_date` timestamp NULL DEFAULT NULL,
  `it_analys` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_it` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_asset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_apr` enum('pending','partially_approved','fully_approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `actiondate_apr` timestamp NULL DEFAULT NULL,
  `status_cr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `close_date` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_notified_at` timestamp NULL DEFAULT NULL,
  `rating_it` tinyint DEFAULT NULL,
  `rating_apk` tinyint DEFAULT NULL,
  `review` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `proposals_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fams.proposals: ~6 rows (approximately)
REPLACE INTO `proposals` (`id`, `no_transaksi`, `user_id`, `it_user`, `user_request`, `user_status`, `departement`, `ext_phone`, `status_barang`, `kategori`, `facility`, `user_note`, `no_asset_user`, `return_date`, `estimated_start_date`, `estimated_date`, `action_it_date`, `it_analys`, `file`, `file_it`, `no_asset`, `status_apr`, `actiondate_apr`, `status_cr`, `close_date`, `token`, `created_at`, `updated_at`, `last_notified_at`, `rating_it`, `rating_apk`, `review`) VALUES
	(10, 'CR202412030001', 97, 'it_ricky', 'Ester', 'Section Head', 'IT', NULL, 'Pembelian', 'Software', 'AutoCad', 'Testing 123', NULL, NULL, NULL, NULL, '2025-01-03 04:45:00', 'Done', '1733198374.xlsx', '1733201378.png', '123213131', 'fully_approved', '2024-12-03 04:00:45', 'Closed', '2024-12-03 04:49:38', 'xxJ3V0GRUxRVubluDnG50ZqUdj1mx6GVB4doP25kwRixfWuZkmRWSXEwfd15', '2024-12-03 03:59:34', '2024-12-03 04:50:46', NULL, 5, 5, 'Oke good.'),
	(11, 'CR202412030002', 97, 'it_ricky', 'Ester', 'Section Head', 'IT', NULL, 'Change Request', 'SAP', 'Autorisasi', 'Penjelasan Bisnis Proses yang sedang berjalan pada saat ini : Akses MMBE tidak bisa\r\n\r\nPenjelasan Bisnis Proses yang diharapkan : Akses MMBE bisa\r\n\r\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya : bisa mengakses tcode MMBE.', NULL, NULL, NULL, '2024-12-13 09:00:00', '2024-12-03 04:56:00', 'Penjelasan Bisnis Proses yang sedang berjalan pada saat ini: Oke done\r\n\r\nPenjelasan Bisnis Proses yang diharapkan: Oke done\r\n\r\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya: Oke done', NULL, '1733201994.png', NULL, 'fully_approved', '2024-12-03 04:55:24', 'Closed With Delay', '2024-12-03 04:59:54', '13vd0nfi3Oi5OabuFJFWTlIVnEzNEzNEuOQ2M0Dh6DLbiJgWvnG81a1fGUDa', '2024-12-03 04:53:38', '2024-12-03 05:08:27', '2024-12-03 04:58:10', 2, 5, 'NG'),
	(12, 'CR202412030003', 97, 'it_ricky', 'Ester', 'Section Head', 'IT', NULL, 'Peminjaman', 'Infrastruktur', 'Wireless AccessPoint', 'Pinjam sebentar', NULL, NULL, '2024-12-03 06:00:00', '2024-12-03 06:26:00', '2024-12-03 06:02:00', '4214124214', '1733207201.jpg', '1733207566.png', '1241241241', 'fully_approved', '2024-12-03 06:29:36', 'Closed With Delay', '2024-12-03 06:32:46', 'L2MzdMRUtNpl8l0FIy5q6bdg9dtJ8X8aTl9hVYnmRWodqR3kCO9zUccbqSFl', '2024-12-03 06:26:41', '2024-12-03 07:58:12', '2024-12-03 06:40:09', 5, 5, 'Thankss...'),
	(13, 'CR202412030004', 97, NULL, 'Ester', 'Section Head', 'IT', NULL, 'Pergantian', 'Infrastruktur', 'PC SET', 'Ganti PC', '412341414', NULL, NULL, NULL, NULL, NULL, '1733207619.jpg', NULL, NULL, 'pending', NULL, NULL, NULL, 'T0ZQvnyv4utWwsHR5976LnB4SVfZ1uXVLAk5qJj0g1c68a1wBvhyxxCCbytI', '2024-12-03 06:33:39', '2024-12-03 06:33:39', NULL, NULL, NULL, NULL),
	(14, 'CR202412030005', 97, 'it_ricky', 'Ester', 'Section Head', 'IT', NULL, 'IT Helpdesk', 'Support Infrastruktur', 'Wifi Docking', 'Jaringan mati', NULL, NULL, NULL, NULL, '2024-12-05 05:00:00', 'Done', NULL, '1733291772.png', NULL, 'fully_approved', '2024-12-04 05:43:50', 'Closed By IT', '2024-12-04 05:56:12', 'be8FzXufdCY7YXAX5BM3jMV7a13QnT4myzEpX6lx3PL5UckK4AhPLOvOexF8', '2024-12-03 06:34:34', '2024-12-04 05:56:15', NULL, NULL, NULL, NULL),
	(15, 'CR202412030006', 97, 'it_ricky', 'Ester', 'Section Head', 'IT', NULL, 'Change Request', 'Non SAP', 'Tracebility Delivery ADM', 'Penjelasan Bisnis Proses yang sedang berjalan pada saat ini : LAMBAT\r\n\r\nPenjelasan Bisnis Proses yang diharapkan : Lebih Cepat\r\n\r\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya : Hemattt', NULL, NULL, NULL, '2025-01-10 06:00:00', '2024-12-31 07:48:00', 'Penjelasan Bisnis Proses yang sedang berjalan pada saat ini: Okey\r\n\r\nPenjelasan Bisnis Proses yang diharapkan: Okey\r\n\r\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya: Okey', '1733207906.xlsx', '1733212126.xlsx', NULL, 'fully_approved', '2024-12-03 07:25:11', 'Closed', '2024-12-03 07:48:46', 'KK3xifbNGmZnB0LAnIReIU1JmeEAAHlRN9M4KgE8WU4spO7LP5XqCO0sWvA4', '2024-12-03 06:38:26', '2024-12-03 08:15:19', NULL, 1, 1, 'Jelekkkk\r\nawdawda\r\n\r\nw,d;aw,.;dawdawdawr[23rmq2r\r\n\r\nrqwrawra'),
	(16, 'CR202412030007', 97, 'Aji Kusuma', 'Ester', 'Section Head', 'IT', NULL, 'Change Request', 'Non SAP', 'Web E-LMR', 'Penjelasan Bisnis Proses yang sedang berjalan pada saat ini : QR Error\r\n\r\nPenjelasan Bisnis Proses yang diharapkan : Qr\r\n\r\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya : Error', NULL, NULL, NULL, '2024-12-26 00:00:00', '2024-12-12 08:12:00', 'Penjelasan Bisnis Proses yang sedang berjalan pada saat ini: Karena memakan waktu.\r\n\r\nPenjelasan Bisnis Proses yang diharapkan: 21424\r\n\r\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya: 412414141d awdaw dawdaw', '1733213304.xlsx', '1733213601.xlsx', NULL, 'fully_approved', '2024-12-03 08:09:28', 'Closed', '2024-12-03 08:13:21', 'xsfJ3M7Rn9vOWS2Wa17JSoXMv1DflS6v61CeXbKMnS9aqmupEuaTd5rWUDKs', '2024-12-03 08:08:24', '2024-12-03 08:14:34', NULL, 5, 5, 'bagus');

-- Dumping structure for table fams.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.roles: ~4 rows (approximately)
REPLACE INTO `roles` (`id`, `name`) VALUES
	(1, 'user'),
	(2, 'dh'),
	(3, 'divh'),
	(4, 'it');

-- Dumping structure for table fams.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `npk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.users: ~5 rows (approximately)
REPLACE INTO `users` (`id`, `npk`, `name`, `username`, `email`, `email_verified_at`, `password`, `departement`, `user_status`, `ext_phone`, `signature_image`, `role_id`, `remember_token`, `created_at`, `updated_at`, `api_token`) VALUES
	(3, '', 'it_ricky', 'it', 'helpdesk@dp.dharmap.com', '2024-10-08 03:06:36', '$2y$12$VpkLh9coHrJLol.Ovk6GDuuZmVLp6FlUxdqs9wOSuKoF2uVCoxkSO', 'IT', 'Staff', '08155515115', NULL, 4, NULL, '2024-10-08 03:06:35', '2024-10-22 04:38:15', '79xqQO5oHViFu1YxgpbBSZbYY0jlWHRK1B32jyl9t8WSG0tAZEC5g62vRL6v'),
	(97, '251515', 'Ester', 'sh_it', 'manifestdpm@gmail.com', '2024-12-03 03:56:48', '$2y$12$JTJbXC.b5JJ0stw5/sm.aO8ZRXRo5I1janrStXVYuXrIsemn6Tv6W', 'IT', 'Section Head', '', NULL, 1, NULL, '2024-12-03 03:56:06', '2024-12-03 03:56:48', 'pnlSRAr3PWftTUusjztwBhgT2jagQZ6DbfZElWrLQnz9b2GUPg3L1jCGFEK9'),
	(98, '5151551', 'Baskoro', 'dh_it', 'rickyjohannespanjaitan0@gmail.com', '2024-12-03 03:58:17', '$2y$12$hKSsoH2Z2PiwRfaLWQYmOuvugxbRsM.lo/3YrPyR3LOUpyePKLdla', 'IT', 'Dept Head', '', NULL, 2, NULL, '2024-12-03 03:56:06', '2024-12-03 03:58:17', 'ScRobXn8Vekh3b7UVBbIjbgKW0rdgkZ5PkkMY9LVavExjam3ckYWMkLWbyeq'),
	(99, '2411241', 'Ricky', 'divh_it', 'it.outsource@dp.dharmap.com', '2024-12-03 03:58:47', '$2y$12$4uo8VXTZsoiYHtUOwuIfgO3/u4.GR3HIKi5bX2JVdbmEzfgP.E/AK', 'IT', 'Divisi Head', '', NULL, 3, NULL, '2024-12-03 03:56:07', '2024-12-03 03:58:47', 'zvroXK16gcXfvXId2WznszgXUTAGgb5M4Nqmy72Gv4tGNiRTVrX8BMWJisWC'),
	(100, '4142141414', 'Aji Kusuma', 'it_aji', 'it_aji@gmail.com', '2024-12-03 08:12:04', '$2y$12$BUpSgIHIsx53UiiZC8QnremfU1XLWuvmCz7mu8e1vkm6T2z2jR9re', 'IT', 'Staff', '4141241', NULL, 4, NULL, '2024-12-03 08:12:04', '2024-12-03 08:12:19', 'jB5EYfVi2UM5fMRiWtpqA5kRR510s3NO5WXtFQ3FwgwBoXm05sg7BcCYAhgA');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
