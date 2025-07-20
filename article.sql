-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2025 at 07:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `article`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `category_id`, `title`, `slug`, `body`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'Dangerous', 'dangerous', 'Dengerous, very dengerous.', 'published', NULL, '2025-07-18 07:55:34', '2025-07-18 07:56:17'),
(2, 2, 2, 'Good', 'good', 'fffffffffffffffffffffffffffffff', 'published', '2025-07-20 11:13:17', '2025-07-18 08:08:16', '2025-07-20 11:13:17'),
(3, 2, 2, 'helo', 'helo', 'eeeeeeee', 'published', '2025-07-20 11:13:22', '2025-07-18 08:15:36', '2025-07-20 11:13:22'),
(4, 3, 2, 'Victory', 'victory', 'vvvvvvvvvvvvvvvvv', 'published', NULL, '2025-07-18 09:36:40', '2025-07-18 09:36:40'),
(5, 5, 4, 'Australia', 'australia', 'Beautiful Country', 'published', NULL, '2025-07-20 10:43:19', '2025-07-20 10:44:26'),
(6, 1, 2, 'Sample Article in Games', 'sample-article-in-games', 'This is a sample article about Games.', 'published', NULL, '2025-07-20 11:37:33', '2025-07-20 11:37:33'),
(7, 1, 3, 'Sample Article in Politics', 'sample-article-in-politics', 'This is a sample article about Politics.', 'published', NULL, '2025-07-20 11:37:33', '2025-07-20 11:37:33'),
(8, 1, 4, 'Sample Article in International', 'sample-article-in-international', 'This is a sample article about International.', 'published', NULL, '2025-07-20 11:37:34', '2025-07-20 11:37:34'),
(9, 1, 5, 'Sample Article in Tech', 'sample-article-in-tech', 'This is a sample article about Tech.', 'published', NULL, '2025-07-20 11:37:34', '2025-07-20 11:37:34'),
(10, 1, 6, 'Sample Article in Health', 'sample-article-in-health', 'This is a sample article about Health.', 'published', NULL, '2025-07-20 11:37:34', '2025-07-20 11:37:34'),
(11, 1, 7, 'Sample Article in Business', 'sample-article-in-business', 'This is a sample article about Business.', 'published', NULL, '2025-07-20 11:37:34', '2025-07-20 11:37:34');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(2, 'Games', 'games', '2025-07-18 07:39:37', '2025-07-18 07:40:00'),
(3, 'Politics', 'politics', '2025-07-18 07:40:15', '2025-07-18 07:40:15'),
(4, 'International', 'international', '2025-07-20 10:36:21', '2025-07-20 10:36:21'),
(5, 'Tech', 'tech', '2025-07-20 11:37:31', '2025-07-20 11:37:31'),
(6, 'Health', 'health', '2025-07-20 11:37:31', '2025-07-20 11:37:31'),
(7, 'Business', 'business', '2025-07-20 11:37:32', '2025-07-20 11:37:32');

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
(4, '2025_07_18_035418_create_personal_access_tokens_table', 1),
(5, '2025_07_18_043627_create_categories_table', 1),
(6, '2025_07_18_043655_create_articles_table', 1);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth-token', '6eed229dc0bca0a3ebdc7a757f57e7ce4558d5830946023dc48e24f75e77db00', '[\"*\"]', NULL, NULL, '2025-07-18 00:23:16', '2025-07-18 00:23:16'),
(3, 'App\\Models\\User', 2, 'auth-token', 'a41746d0cf4693120423511bb705e0194c756a4accdb8cdec2d74fa070ae85b1', '[\"*\"]', NULL, NULL, '2025-07-18 06:13:40', '2025-07-18 06:13:40'),
(6, 'App\\Models\\User', 3, 'auth-token', '45119d99a8e61ef707d4a29a17b1469ac61fa474b7382b72d509584a318b6209', '[\"*\"]', NULL, NULL, '2025-07-18 06:40:50', '2025-07-18 06:40:50'),
(10, 'App\\Models\\User', 4, 'auth-token', 'e4a4a125d66e697617690988f33e46faac88b86977a5f2b31b4af2d99424aea3', '[\"*\"]', NULL, NULL, '2025-07-18 07:40:42', '2025-07-18 07:40:42'),
(12, 'App\\Models\\User', 2, 'auth-token', 'e058787495383683cca50e7142a09a9c3c74b2eeccc98f4e27b3a0481b24db4e', '[\"*\"]', NULL, NULL, '2025-07-18 07:53:46', '2025-07-18 07:53:46'),
(15, 'App\\Models\\User', 2, 'auth-token', 'a6a0b116d0ded9fac1be8247ba921379a461881b0ad7a08cfac0c158cb2d6b38', '[\"*\"]', NULL, NULL, '2025-07-20 09:33:29', '2025-07-20 09:33:29'),
(17, 'App\\Models\\User', 5, 'auth-token', 'ddcbdacd195b9b44f8154b3697643f766c5c613c0f4159534df270db33b8aa37', '[\"*\"]', NULL, NULL, '2025-07-20 10:35:11', '2025-07-20 10:35:11'),
(18, 'App\\Models\\User', 5, 'auth-token', '0682147179c4278023ab51534191bda28d2357cccf59e8c02b8249a9f5e68654', '[\"*\"]', '2025-07-20 10:44:31', NULL, '2025-07-20 10:35:29', '2025-07-20 10:44:31'),
(19, 'App\\Models\\User', 6, 'auth-token', '846592f1b27e65b89326b965901d9fbaa842e29fdcbec7f1936cf617a43a309c', '[\"*\"]', NULL, NULL, '2025-07-20 11:11:30', '2025-07-20 11:11:30');

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
('0weQqmVoIghzGT32pfgb46WjQz8X36InoHQ6wenh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWW8wUjJLbjZIUkhWUklmZ2lKTlY4Q1hqeGVBNDBPREw5d0FlZ2ltWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wdWJsaWMtYXJ0aWNsZXMiO319', 1753029870),
('HgZYxvl0ym84olodQYltGVMx5DyfJzoSStxmRNW8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMmVvMzRaRWdNNkIyVkpZMU1uZmNkWXo5b3d1VXZCck0xME5ZNGQyaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1753031607),
('SVPcwnD9hoUyqdOWvJCLtpn3SQXPx3JeTH8az6rz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2N4ZVhnbHNucUNMOWNrdjhsZ2N6ZWZramt5WTY2OEc4REd1cld4WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1752853072),
('VwvDz7zZmckGeTQDPveLG4JU81xk7ejz4vZhldYb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXNzQmoxejY0cWVITUFFVHNhS2MzMnRoMlVNOGZDdTFmR0cwN1h6NCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teS1hcnRpY2xlcyI7fX0=', 1752852930);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abdullah', 'asm@gmail.com', NULL, '$2y$12$HGYxrQnxrNhCCqchJp61zuVyQ6wjxWAiyUDBoz46RH8G3Sje5ewCm', NULL, '2025-07-18 00:23:15', '2025-07-18 00:23:15'),
(2, 'Hasib', 'hasib@gmail.com', NULL, '$2y$12$NUlRG/OwT7e7Tzaw6xycluGr1x6GVtUTukX/3RfkhRagpRvMTErxC', NULL, '2025-07-18 06:13:38', '2025-07-18 06:13:38'),
(3, 'amir', 'amir@gmail.com', NULL, '$2y$12$YQ/3bTMbinWamXEYPapl9OiQgob7/9ZAFvoV2X5mNKeEdm/AGuHiK', NULL, '2025-07-18 06:40:49', '2025-07-18 06:40:49'),
(4, 'Tanim', 'tanim@gmail.com', NULL, '$2y$12$JMRAMr5MFegplf8BIVbYWOrvEEV9K6xTkRYYAULgaq.bU0eFzoboG', NULL, '2025-07-18 07:40:42', '2025-07-18 07:40:42'),
(5, 'Kabir', 'kabir@gmail.com', NULL, '$2y$12$S77NwWyB0rB6chkoTFrlWuWj7aNFTH8U4D6CnfjTcxRWvQzOjzGCi', NULL, '2025-07-20 10:35:10', '2025-07-20 10:35:10'),
(6, 'Labib', 'labib@gmail.com', NULL, '$2y$12$UhNBMxLp/jQ4YMSOmMqFO.JIthX0IIKYSbjprNxPOu.nnufCfrJCy', NULL, '2025-07-20 11:11:29', '2025-07-20 11:11:29'),
(9, 'User', 'demo@gmail.com', NULL, '$2y$12$NjaexCIx7wM6uLGSLoF3xudqyDhEVTBZikij4VrrHT5sCwZU9g6lC', NULL, '2025-07-20 11:37:30', '2025-07-20 11:37:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_user_id_foreign` (`user_id`),
  ADD KEY `articles_category_id_foreign` (`category_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
