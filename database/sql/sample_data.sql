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


-- Dumping data for table aipt.users: ~2 rows (approximately)
INSERT INTO `taxyaar_backend`.`users` (`id`, `name`,`user_type`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin User', 'admin', 'admin@admin.com', '2025-06-14 17:39:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'yaQRzRT1BQ', '2025-06-14 17:39:14', '2025-06-14 17:39:14'),
	(2, 'Manager User', 'user','manager@admin.com', '2025-06-14 17:39:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'zuUppGB7Bl', '2025-06-14 17:39:14', '2025-06-14 17:39:14');


CREATE TABLE IF NOT EXISTS `topic_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `topic_categories_name_unique` (`name`),
  UNIQUE KEY `topic_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table taxyaar_help_center.topic_categories: ~4 rows (approximately)
INSERT INTO `taxyaar_help_center`.`topic_categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Tax Made Easy', 'tax-made-easy', 'Visit for updates on budget 2024', 'active', '2025-10-06 07:54:24', '2025-10-07 16:04:59'),
	(2, 'How to Guides?', 'how-to-guides', '[Detailed explanation on how to enter data on myITreturn]', 'active', '2025-10-07 15:50:47', '2025-10-07 16:05:22'),
	(3, 'Knowledge Base', 'knowledge-base', '[Our Knowledge Base on Income-tax filing]', 'active', '2025-10-07 15:52:01', '2025-10-07 16:05:40'),
	(4, 'FAQs', 'faqs', '[Common Questions and Answers]', 'active', '2025-10-07 16:05:55', '2025-10-07 16:05:55');
/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
