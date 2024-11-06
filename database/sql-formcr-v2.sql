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
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
	(165, '2024_10_25_100432_add_foreign_keys_to_users_table', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.profiles: ~9 rows (approximately)
REPLACE INTO `profiles` (`id`, `user_id`, `name`, `address`, `phone`, `dob`, `gender`, `occupation`, `about`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Divisi Head IT', 'A', '0855-5555-55555', '2024-04-04', 'male', 'A', 'A', NULL, '2024-09-25 00:45:53', '2024-11-04 03:04:09'),
	(4, 4, 'Ester Fiorina Panjaitan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-27 01:02:36', '2024-11-04 03:06:10'),
	(5, 3, 'Sect IT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 03:06:35', '2024-10-08 03:06:35'),
	(6, 6, 'DeptHead IT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 07:45:52', '2024-10-08 07:45:52'),
	(7, 7, 'adminit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 08:06:31', '2024-10-08 08:06:31'),
	(13, 13, 'dh_ppic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-17 09:58:31', '2024-10-17 09:58:31'),
	(14, 14, 'divh_ppic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-17 09:59:56', '2024-10-17 09:59:56'),
	(15, 2, 'DivisiHead IT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-22 05:06:32', '2024-10-22 05:06:32'),
	(18, 18, 'Jaelani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 03:10:48', '2024-11-01 03:10:48'),
	(19, 19, 'Julius', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-06 06:37:06', '2024-11-06 06:37:06');

-- Dumping structure for table fams.proposals
CREATE TABLE IF NOT EXISTS `proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `it_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_request` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_barang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facility` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_asset_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_date` timestamp NULL DEFAULT NULL,
  `it_analys` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_it` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_asset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_dh` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `actiondate_dh` timestamp NULL DEFAULT NULL,
  `status_divh` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `actiondate_divh` timestamp NULL DEFAULT NULL,
  `status_cr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `close_date` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_notified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `proposals_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fams.proposals: ~6 rows (approximately)
REPLACE INTO `proposals` (`id`, `no_transaksi`, `user_id`, `it_user`, `user_request`, `user_status`, `departement`, `ext_phone`, `status_barang`, `kategori`, `facility`, `user_note`, `no_asset_user`, `estimated_date`, `it_analys`, `file`, `file_it`, `no_asset`, `status_dh`, `actiondate_dh`, `status_divh`, `actiondate_divh`, `status_cr`, `close_date`, `token`, `created_at`, `updated_at`, `last_notified_at`) VALUES
	(197, 'CR202411050002', 6, 'Sect IT', 'Section Head IT', 'SectionHead', 'MARKETING', '0848484848', 'Pergantian', 'Infrastruktur', 'Komputer', 'RUsakkk', '21342142141', '2024-11-06 09:39:00', '41241abc', '1730798765.xlsx', '1730799919.png', '41241', 'approved', '2024-11-05 05:04:10', 'approved', '2024-11-06 02:24:54', 'Closed All', '2024-11-05 09:45:19', 'LX2OTxnsK3PBY5GhX4gKQWINPfnPNqsAtrKZtexjKRLosrPXPs8oqB5hcfPq', '2024-11-05 04:56:18', '2024-11-06 02:47:42', NULL),
	(198, 'CR202411050003', 6, 'Sect IT', 'Section Head IT', 'SectionHead', 'MARKETING', '0848484848', 'Pergantian', 'Infrastruktur', 'PC dan Laptop', 'RUsakkk', '21342142141', '2024-11-06 02:10:40', '124124121', '1730858944.xlsx', NULL, '124124', 'pending', '2024-11-05 05:06:51', 'pending', '2024-11-06 02:24:54', 'DELAY', NULL, 'VUf0qp2wnx2DmOaHY5BVfv8zT1g4OLBFnmdmKZ0LT8Hkgiyjr9Yb03IC4dOr', '2024-11-05 05:06:06', '2024-11-06 02:11:58', '2024-11-06 02:11:58'),
	(201, 'CR202411060001', 18, 'Sect IT', 'Jaelani', 'Staff', 'MAINTENANCE', '3123123123', 'Pembelian', 'Infrastruktur', 'Keyboard / Mouse', 'Misal ceritanya butuh beli keyboard', NULL, '2024-11-06 02:42:00', 'Misal sudah di deliver', NULL, '1730860929.jpg', NULL, 'approved', '2024-11-06 02:24:54', 'approved', '2024-11-06 02:39:57', 'Closed With IT', '2024-11-06 02:42:09', 'zVSrwIeomUgVFJNJkBWlUhc0vMdIGlOR7PnN8LM0zbqcAx4kLlpKl4OKUH2p', '2024-11-06 02:21:24', '2024-11-06 02:42:43', NULL),
	(203, 'CR202411060002', 6, NULL, 'Section Head IT', 'SectionHead', 'MARKETING', '0848484848', 'Pembelian,Pergantian', 'Account,Infrastruktur', 'Email,Komputer Gaming', 'Pembuatan akun email baru dan pergantian komputer.', '1421414124', NULL, NULL, '1730862370.jpg', NULL, NULL, 'approved', '2024-11-06 03:06:24', 'rejected', '2024-11-06 06:27:45', 'Close By Rejected', NULL, 'mt3YKGTORXG5f5nagDVZTdG5zS2MmtLzJByDrsIsVpZRKZP5ooeaDK7iCiBQ', '2024-11-06 03:06:10', '2024-11-06 06:27:45', NULL),
	(204, 'CR202411060003', 18, 'Julius', 'Jaelani', 'Staff', 'MAINTENANCE', '3123123123', 'Pembelian', 'Infrastruktur', 'Laptop', 'Butuh laptop misal', NULL, '2024-11-06 07:09:00', 'Misal barang nya sudah ada', NULL, '1730877091.jpg', '0011ABXX', 'approved', '2024-11-06 07:04:43', 'approved', '2024-11-06 07:05:39', 'Closed All', '2024-11-06 07:11:31', 'tma5eMzcP3t1gunJ6NrYHtwZA844IUMYz3HnL3U0vGnjDkAPKb8XrNU4wKV3', '2024-11-06 06:38:59', '2024-11-06 07:21:02', NULL),
	(205, 'CR202411060004', 18, NULL, 'Jaelani', 'Staff', 'MAINTENANCE', '3123123123', 'Pergantian', 'Infrastruktur', 'Monitor', 'Minta ganti monitor udah jelek misalnya', NULL, NULL, NULL, NULL, NULL, NULL, 'rejected', '2024-11-06 08:36:32', 'rejected', NULL, 'Close By Rejected', NULL, 'uZdGQjBPaxOeswl1Tm5a7rJop8enTVykU9bjfas0cPXCx4HG1tNA4529GfUz', '2024-11-06 08:26:47', '2024-11-06 08:36:32', NULL),
	(206, 'CR202411060005', 18, NULL, 'Jaelani', 'Staff', 'MAINTENANCE', '3123123123', 'Peminjaman', 'Infrastruktur', 'Keyboard / Mouse', 'Misal minjem keyboard', NULL, NULL, NULL, NULL, NULL, NULL, 'rejected', '2024-11-06 08:50:26', 'rejected', NULL, 'Close By Rejected', NULL, 'xXnxKrA9JkXxT6V5fu0IatJcINzOzQjNqhEAP2iRO5Yopm3tlrJSPuy5DxGE', '2024-11-06 08:49:29', '2024-11-06 08:50:26', NULL);

-- Dumping structure for table fams.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.roles: ~5 rows (approximately)
REPLACE INTO `roles` (`id`, `name`) VALUES
	(1, 'divh'),
	(3, 'user'),
	(4, 'dh'),
	(5, 'it');

-- Dumping structure for table fams.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fams.users: ~9 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `departement`, `user_status`, `ext_phone`, `role_id`, `remember_token`, `created_at`, `updated_at`, `api_token`) VALUES
	(1, 'Divisi Head IT', 'divh_it', 'manifestdpm@gmail.com', '2024-09-25 00:45:53', '$2y$12$wZ7Wxof6Al9VSzFiNLHoyOaCIDZPriy5MUA90PsR4e3SEwYAG.Jzu', 'MARKETING', 'DivisiHead', '12341241231', 1, 'PcCW8IX3z5dYrQbX2Kgh4ICExekTQLwL9AsvVtgxJnOyO79Jd58LviqKyxW8', '2024-09-25 00:45:53', '2024-11-04 02:40:25', 'p5GourJPX2wkbnbWAjH3t2shzNgQHj7XU7x2ZuWEZYtI4dbmpbfw2lPXDB4R'),
	(2, 'Dept Head IT', 'dh_it', 'it.outsource@dp.dharmap.com', '2024-10-22 05:06:32', '$2y$12$Xjm9BbqXMg/CUxpsQRopq.VjT236ivy8KrsSpMMQm/VXs3xkGvTLW', 'MARKETING', 'DeptHead', '', 4, NULL, '2024-10-22 05:06:32', '2024-10-22 05:07:41', '4Ot3FHBR0OZjpSnbOk0moL2oiq2S11TRhvfEcpWfmQSHAGSdbNlHhDifedY4'),
	(3, 'it', 'it', 'rickyjohannespanjaitan0@gmail.com', '2024-10-08 03:06:36', '$2y$12$VpkLh9coHrJLol.Ovk6GDuuZmVLp6FlUxdqs9wOSuKoF2uVCoxkSO', 'IT', '', '', 5, NULL, '2024-10-08 03:06:35', '2024-10-22 04:38:15', '79xqQO5oHViFu1YxgpbBSZbYY0jlWHRK1B32jyl9t8WSG0tAZEC5g62vRL6v'),
	(4, 'Ester Fiorina Panjaitan', 'ester', 'fiorinapanjaitan09@gmail.com', '2024-09-27 01:02:36', '$2y$12$JiEPEnUPB/bZgBTfFhVM7uU41iCmX63cD4Va9oPvKV9vkzng7RetK', 'MAINTENANCE', 'Division', '0895621159259', 1, NULL, '2024-09-27 01:02:36', '2024-11-04 08:20:05', 'KVfGfIPjGjqMrmGtAit7b6cVweBjRpKnJqNpcqf9b6OlpQQ9ex7DO2eBOdb9'),
	(6, 'Section Head IT', 'sh_it', 'rickyjop0@gmail.com', '2024-10-08 07:45:52', '$2y$12$zB480GqVUS5n2nvQBBRrxu1qGvjyf5dlBR6leX8wa6OjPbVicJ48i', 'MARKETING', 'SectionHead', '0848484848', 3, 'bhQAIxRNm0ce5Ru32KQu7paLRJqODbwfsMrbKmfBWnfhvOp5LvmBK2FwLUi7', '2024-10-08 07:45:52', '2024-10-17 07:29:48', 'EZij1sRaIB0VUJ67XBxa0VDxjZTKLCkvL6bumecI88hwyRXsrg3itiETulpK'),
	(7, 'adminppic', 'adminppic', 'adminppic@gmail.com', '2024-10-08 08:06:31', '$2y$12$WBWzkIUW5rDY60XCHskq6uQgdUiOrtnFKQh/bHYKdLIziaRNiYH1u', 'PPIC', '', '', 3, NULL, '2024-10-08 08:06:31', '2024-10-08 08:06:31', NULL),
	(13, 'dh_ppic', 'dh_ppic', 'listback123@gmail.com', '2024-10-17 09:58:31', '$2y$12$oofNMJMUofrD9L2b5p9P0en2OQVJhUWXSpvd8Cvc2c0zJ1RZw5Upm', 'MAINTENANCE', 'Department Head', '088294552272', 4, NULL, '2024-10-17 09:58:31', '2024-11-04 08:19:32', 'CLGDf8tHvRPArCU8o4Py62DEICdcLRk6SMZAKeQxS49nj3dFhF6F29o6xxQW'),
	(14, 'divh_ppic', 'divh_ppic', 'rsitamvan@gmail.com', '2024-10-17 09:59:56', '$2y$12$7o1XtLCKjwk2zVayjvmpReMFsggKzwVc4FqFA81QYCglY/YJqJ3xG', 'PPIC', '', '', 1, NULL, '2024-10-17 09:59:56', '2024-10-22 04:22:06', '0EOMlEO6rqqVv7bxO6QYU292q68y4n79EsasSb0TMtahsKNV5kT4tEWvRTs6'),
	(18, 'Jaelani', 'jaelani', 'esterfiorinapanjaitan@gmail.com', '2024-11-01 03:10:48', '$2y$12$U3C5S5F8c0t/Rww9qyyAZ.Kb0FhSAp2Vr3SkGnv59tXimatH/U/Yy', 'MAINTENANCE', 'Staff', '3123123123', 3, NULL, '2024-11-01 03:10:48', '2024-11-04 03:06:35', 'in1xDCXP3SsVHHNAYiQAEsBznyIMnRA8TljquQ1wDmmWKSNcPebqawcD6N8l'),
	(19, 'Julius', 'julius', 'esterfiorinapanjaitan@mhs.pelitabangsa.ac.id', '2024-11-06 06:37:06', '$2y$12$7xH8prpz26Us76uBNA9N5uXnmbAEvay/wKXlixYUYOxSztpjpZHQ.', 'IT', 'Staff', '0852945222272', 5, NULL, '2024-11-06 06:37:06', '2024-11-06 07:06:42', 'QI63ziecbLvcbaWG6IPpVcgf1pw9hCeY4LN5HAj8zLYlABs6zJRViuNahHVu');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
