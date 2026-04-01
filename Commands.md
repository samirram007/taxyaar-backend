#### to update database or create a migration to database
as we have two database so we will do two things to transfer smooth transition </br>
1. create database taxyaar_help_center  // ** run this in database first
2. php artisan migrate --database=mysql

to run seeder
1. php artisan db:seed --class=DatabaseSeeder



### for users data to run manually
1. set sql_safe_updates = 0;

2.

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `userable_id` bigint(20) unsigned DEFAULT NULL,
  `userable_type` varchar(191) NOT NULL DEFAULT 'employee',
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `provider` varchar(191) DEFAULT NULL,
  `provider_id` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `provider_token` text DEFAULT NULL,
  `provider_refresh_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_provider_provider_id_unique` (`provider`,`provider_id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_provider_id_unique` (`provider_id`),
  KEY `users_userable_id_userable_type_index` (`userable_id`,`userable_type`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `username`, `user_type`, `email`, `email_verified_at`, `password`, `remember_token`, `userable_id`, `userable_type`, `status`, `provider`, `provider_id`, `avatar`, `provider_token`, `provider_refresh_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@admin.com', 'admin', 'admin@admin.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'yaQRzRT1BQ', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, '2025-06-14 12:09:14', '2025-06-14 12:09:14'),

(2, 'Manager User', 'manager@admin.com', 'user', 'manager@admin.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'zuUppGB7Bl', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, '2025-06-14 12:09:14', '2025-06-14 12:09:14'),

(3, 'Support Admin', 'support@admin.com', 'admin', 'support@admin.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok123A', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),

(4, 'Tech Admin', 'tech@admin.com', 'admin', 'tech@admin.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok123B', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),

(5, 'Normal User One', 'user1@test.com', 'user', 'user1@test.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok123C', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),

(6, 'Normal User Two', 'user2@test.com', 'user', 'user2@test.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok123D', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),

(7, 'Operations Admin', 'ops@admin.com', 'admin', 'ops@admin.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok123E', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),

(8, 'End User Three', 'user3@test.com', 'user', 'user3@test.com', '2025-06-14 12:09:14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok123F', NULL, 'employee', 'active', NULL, NULL, NULL, NULL, NULL, NOW(), NOW());

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;