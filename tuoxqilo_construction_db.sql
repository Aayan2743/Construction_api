-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2026 at 11:16 AM
-- Server version: 11.4.10-MariaDB-cll-lve
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuoxqilo_construction_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_allocations`
--

CREATE TABLE `account_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_allocations`
--

INSERT INTO `account_allocations` (`id`, `user_id`, `role`, `project_id`, `amount`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'manager', 4, 50000.00, 'admin', '2026-04-29 11:14:17', '2026-05-02 10:27:38'),
(5, 5, 'admin', 10, 85000.00, 'Updated via UI', '2026-05-02 10:28:01', '2026-05-04 09:38:00'),
(6, 22, 'manager', 8, 400000.00, 'Allocated via UI', '2026-05-05 09:49:59', '2026-05-05 09:49:59');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `is_present` tinyint(1) NOT NULL DEFAULT 1,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `labour_id`, `date`, `is_present`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-04-25', 1, 9, '2026-04-25 06:13:47', '2026-04-25 06:13:47'),
(3, 6, '2026-04-25', 1, 9, '2026-04-25 06:49:51', '2026-04-25 06:49:51'),
(4, 8, '2026-04-25', 1, 9, '2026-04-25 09:09:42', '2026-04-25 09:09:42'),
(5, 7, '2026-04-25', 1, 9, '2026-04-25 09:09:43', '2026-04-25 09:09:43'),
(6, 8, '2026-04-27', 1, 9, '2026-04-27 04:35:52', '2026-04-27 04:35:52'),
(7, 7, '2026-04-27', 1, 9, '2026-04-27 04:35:53', '2026-04-27 04:35:53'),
(8, 6, '2026-04-27', 1, 9, '2026-04-27 10:19:58', '2026-04-27 10:19:58'),
(10, 8, '2026-04-29', 1, 9, '2026-04-29 06:31:55', '2026-04-29 06:31:55'),
(11, 9, '2026-04-29', 1, 9, '2026-04-29 06:31:55', '2026-04-29 06:31:55'),
(12, 7, '2026-04-29', 1, 9, '2026-04-29 06:31:59', '2026-04-29 06:31:59'),
(13, 6, '2026-04-29', 1, 9, '2026-04-29 10:01:54', '2026-04-29 10:01:54'),
(14, 3, '2026-04-29', 1, 9, '2026-04-29 10:02:00', '2026-04-29 10:02:00'),
(15, 9, '2026-05-02', 1, 9, '2026-05-02 05:47:50', '2026-05-02 05:47:50'),
(16, 8, '2026-05-02', 1, 9, '2026-05-02 05:47:51', '2026-05-02 05:47:51'),
(17, 7, '2026-05-02', 1, 9, '2026-05-02 05:48:05', '2026-05-02 05:48:05'),
(18, 6, '2026-05-02', 1, 9, '2026-05-02 08:14:14', '2026-05-02 08:14:14'),
(19, 3, '2026-05-02', 1, 9, '2026-05-02 08:17:12', '2026-05-02 08:17:12'),
(20, 9, '2026-05-04', 1, 9, '2026-05-04 04:27:01', '2026-05-04 04:27:01'),
(21, 8, '2026-05-04', 1, 9, '2026-05-04 04:27:04', '2026-05-04 04:27:04'),
(22, 7, '2026-05-04', 1, 9, '2026-05-04 04:27:05', '2026-05-04 04:27:05'),
(23, 6, '2026-05-04', 1, 9, '2026-05-04 04:27:10', '2026-05-04 04:27:10'),
(24, 3, '2026-05-04', 1, 9, '2026-05-04 04:27:11', '2026-05-04 04:27:11'),
(25, 10, '2026-05-04', 1, 9, '2026-05-04 07:35:55', '2026-05-04 07:35:55'),
(26, 10, '2026-05-05', 1, 9, '2026-05-05 09:37:51', '2026-05-05 09:37:51'),
(27, 9, '2026-05-05', 1, 9, '2026-05-05 09:40:16', '2026-05-05 09:40:16'),
(28, 10, '2026-05-14', 1, 9, '2026-05-14 04:29:05', '2026-05-14 04:29:05'),
(29, 9, '2026-05-14', 1, 9, '2026-05-14 04:29:06', '2026-05-14 04:29:06'),
(30, 8, '2026-05-14', 1, 9, '2026-05-14 04:29:07', '2026-05-14 04:29:07'),
(31, 7, '2026-05-14', 1, 9, '2026-05-14 04:29:08', '2026-05-14 04:29:08');

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
-- Table structure for table `equipment_entries`
--

CREATE TABLE `equipment_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipment_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `work_done` text DEFAULT NULL,
  `date` date NOT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment_entries`
--

INSERT INTO `equipment_entries` (`id`, `equipment_id`, `vendor_id`, `start_time`, `end_time`, `total_hours`, `work_done`, `date`, `added_by`, `created_at`, `updated_at`) VALUES
(12, 15, 11, '09:00:00', '11:00:00', 2.00, 'Abc wall', '2026-05-14', 9, '2026-05-14 04:49:02', '2026-05-14 04:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_entry_histories`
--

CREATE TABLE `equipment_entry_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipment_entry_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` varchar(500) NOT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `labour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `sector` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('machinery','material') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(15, 'jcb', 'machinery', '2026-05-05 05:13:48', '2026-05-05 05:14:00'),
(16, 'cement', 'material', '2026-05-05 09:48:30', '2026-05-05 09:48:30');

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
-- Table structure for table `labours`
--

CREATE TABLE `labours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(15) NOT NULL,
  `daily_wage` decimal(8,2) NOT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labours`
--

INSERT INTO `labours` (`id`, `full_name`, `age`, `gender`, `vendor_id`, `phone`, `daily_wage`, `added_by`, `created_at`, `updated_at`, `profile_pic`) VALUES
(3, 'Abc', 21, 'female', 6, '6300370899', 0.00, 9, '2026-04-25 05:09:56', '2026-04-25 05:09:56', NULL),
(6, 'Maram', 22, 'male', 4, '8106263798', 0.00, 9, '2026-04-25 06:49:47', '2026-04-25 06:49:47', NULL),
(7, 'Kalpana', 21, 'female', 6, '8374257687', 0.00, 9, '2026-04-25 08:58:36', '2026-04-25 08:58:36', NULL),
(8, 'Maram', 21, 'female', 4, '8498914788', 0.00, 9, '2026-04-25 08:59:39', '2026-04-25 08:59:39', NULL),
(9, 'All', 21, 'female', 6, '8790222642', 0.00, 9, '2026-04-27 11:39:43', '2026-04-27 11:39:43', NULL),
(10, 'Avhibssvosl', 22, 'female', 6, '9912667122', 1000.00, 9, '2026-05-04 07:29:40', '2026-05-04 07:29:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `labour_histories`
--

CREATE TABLE `labour_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'update',
  `remarks` varchar(500) NOT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labour_reports`
--

CREATE TABLE `labour_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `mason` int(11) NOT NULL DEFAULT 0,
  `male_skilled` int(11) NOT NULL DEFAULT 0,
  `female_unskilled` int(11) NOT NULL DEFAULT 0,
  `others` int(11) NOT NULL DEFAULT 0,
  `work_done` text DEFAULT NULL,
  `date` date NOT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labour_reports`
--

INSERT INTO `labour_reports` (`id`, `vendor_id`, `mason`, `male_skilled`, `female_unskilled`, `others`, `work_done`, `date`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 0, 0, 0, 'Work done', '2026-04-25', 9, '2026-04-25 06:50:31', '2026-04-25 06:50:31'),
(2, 6, 0, 0, 2, 0, 'Work done', '2026-04-25', 9, '2026-04-25 06:50:31', '2026-04-25 06:50:31'),
(3, 4, 1, 0, 1, 0, 'Work done', '2026-05-02', 9, '2026-05-02 08:24:05', '2026-05-02 08:24:05'),
(4, 6, 0, 0, 3, 0, 'Work done', '2026-05-02', 9, '2026-05-02 08:24:05', '2026-05-02 08:24:05'),
(5, 4, 1, 0, 1, 0, 'Work done', '2026-05-04', 9, '2026-05-04 04:42:01', '2026-05-04 04:42:01'),
(6, 6, 0, 0, 3, 0, 'Work done', '2026-05-04', 9, '2026-05-04 04:42:01', '2026-05-04 04:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `labour_wages`
--

CREATE TABLE `labour_wages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_id` bigint(20) UNSIGNED NOT NULL,
  `daily_wage` decimal(10,2) NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labour_wages`
--

INSERT INTO `labour_wages` (`id`, `labour_id`, `daily_wage`, `effective_from`, `effective_to`, `created_at`, `updated_at`) VALUES
(1, 10, 1000.00, '2026-05-04', NULL, '2026-05-04 07:29:40', '2026-05-04 07:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `material_consumptions`
--

CREATE TABLE `material_consumptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `consumption_date` date NOT NULL,
  `work` varchar(255) NOT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_entries`
--

CREATE TABLE `material_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `entry_date` date DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_entries`
--

INSERT INTO `material_entries` (`id`, `item_id`, `qty`, `project_id`, `entry_date`, `supplier`, `vendor_id`, `added_by`, `created_at`, `updated_at`) VALUES
(5, 16, 10.00, 4, '2026-05-14', NULL, 10, 9, '2026-05-14 04:49:37', '2026-05-14 04:49:37');

-- --------------------------------------------------------

--
-- Table structure for table `material_entry_histories`
--

CREATE TABLE `material_entry_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_entry_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` varchar(500) NOT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_stock_reports`
--

CREATE TABLE `material_stock_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `report_date` date NOT NULL,
  `opening_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `received_qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `consumed_qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `closing_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2026_01_20_115803_create_personal_access_tokens_table', 1),
(5, '2026_01_20_124318_create_password_resets_table', 1),
(6, '2026_04_17_181602_add_to_status_user_table', 1),
(7, '2026_04_17_182818_create_projects_table', 1),
(8, '2026_04_17_184308_create_vendors_table', 1),
(9, '2026_04_19_141035_create_labours_table', 1),
(10, '2026_04_19_143438_add_profile_pic_to_table', 1),
(11, '2026_04_19_145416_create_attendances_table', 1),
(12, '2026_04_19_151809_create_labour_reports_table', 1),
(13, '2026_04_19_154521_create_items_table', 1),
(14, '2026_04_19_160902_create_equipment_entries_table', 1),
(15, '2026_04_22_121347_create_account_allocations_table', 2),
(16, '2026_04_22_154045_add_remarks_to_table', 2),
(17, '2026_04_22_160222_add_day_wage_labour_to_table', 2),
(18, '2026_04_29_131601_add_budjet_to_table', 2),
(19, '2026_04_29_161500_create_labour_wages_table', 3),
(20, '2026_04_29_163000_create_labour_histories_table', 3),
(21, '2026_04_29_163600_create_equipment_entry_histories_table', 3),
(22, '2026_04_29_164200_create_material_entries_table', 3),
(23, '2026_04_29_164230_create_material_entry_histories_table', 3),
(24, '2026_04_30_120000_create_expenses_table', 3),
(25, '2026_04_30_120500_add_labour_id_to_expenses_table', 3),
(26, '2026_04_30_122200_add_item_id_to_expenses_table', 3),
(27, '2026_04_30_123000_create_project_funds_table', 3),
(28, '2026_04_30_125500_create_material_stock_reports_table', 3),
(29, '2026_04_30_131000_add_entry_date_to_material_entries_table', 3),
(30, '2026_04_30_131500_create_material_consumptions_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `budget` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `manager_id`, `location`, `start_date`, `status`, `budget`, `created_at`, `updated_at`) VALUES
(3, 'abc', 1, 'hyd', '2026-04-22', 0, 0.00, '2026-04-22 08:58:05', '2026-04-22 08:58:05'),
(4, 'xyz', 9, 'h', '2026-04-24', 1, 0.00, '2026-04-24 12:32:20', '2026-04-24 12:32:20'),
(5, 'beta', 9, 'hyd', '2026-04-24', 1, 0.00, '2026-04-24 12:38:42', '2026-04-28 09:10:20'),
(8, 'alpha', 2, 'mumbai', '2026-04-24', 1, 0.00, '2026-04-28 09:11:40', '2026-04-28 09:11:40'),
(10, 'abc', 17, 'hyd', '2026-04-29', 1, 50000.00, '2026-04-29 09:33:40', '2026-04-29 09:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `project_funds`
--

CREATE TABLE `project_funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `total_received` decimal(12,2) NOT NULL DEFAULT 0.00,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('2UvaiWfwCKMF14zPYtRssLwnTCXQ6Q0R7qOHX7d7', NULL, '122.181.211.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSGVFS0pobHM4a3ZLT1g1NEU5ZmxKUkJqU1RVNklkMFhhM2g2WXRGNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777538481),
('516izRFwhGGaWM0JAlb9YMPxSp2ddSbgA4UHp7Nn', NULL, '171.61.158.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRkZ2YmFyb3N3UmxBeW9kcGNEZmpIMHRNOTRoYzgwejMzdWxOd1RmayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777444474),
('6QYz6uQq8schlBVHKGc9rhVb2gxMchItdBqbFdXP', NULL, '103.120.51.94', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoia3lIWlJwejN0RTQyY0R3UXZiVHFIZDJTaGt0S1k4VTk4ZFdhNFVPdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777098620),
('7392QJYWPxTVgwSeGoBDvYcnWtRNRt6bDjnUd2wB', NULL, '152.57.174.94', 'WhatsApp/2.23.20.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoia09adjdXbG5hYmRTaExDYWphdDRFU1BJRHJNUG9tbjV4cHd4Q2JVSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777702985),
('8hKsvbGPUQbNfq37RLGGLG3J5ijK3mzFuknHP9gp', NULL, '122.181.211.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSk1sZVlJZzQ0MWQ5ZDdTQ3lmc3lGQVRZWGhlaHI4UHh4RDZtZWQ4aSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777523848),
('bDBxZgx3jvIj2QmbIBea1hysquOkgKZE8WmOy4CM', NULL, '103.120.51.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOFFYc0x3Y1oyZnprZnpnSDBvVEdteHNPcEYzcWtGb2dhczMwRW1MTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776746211),
('Bi9hl4Bbl3sJ9tK3MQboNZM3JgpNT5AOvh6MD1vf', NULL, '103.120.51.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiR2p0Q1VpdVBtUzgydXdETmRQcXludzJiOFdmZ0dybHNYRnEzcUdVMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777889958),
('BTB8LmrEWI9UbV3hrsMbXCkFau18AN0C2UPhdn22', NULL, '103.120.51.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiV3hRTGJpZXB2R1JJYmRPOFBNaXNjV2VIeEtrS3Ixd25vbkU2VjJmOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777976894),
('DquHoCWi0nYRsGZxLmDPnLdK6vR6Lwdv2LVBWmTo', NULL, '103.120.51.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidm1UVmJJVkR4ajduaktObDB1eVJpc29YWmpRbHdwR0F6WEJybTB2NSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776934975),
('FcnccTSN1s5Wxakzp8XN7DdtyMJfjbKfAWuCGFN2', NULL, '103.120.51.54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidDYyMEI2OU9Tb2xxMThyUDFvN1UwN0NsVURHMlkwdDE1aG8xVHFBWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778672574),
('HoMI2eS0xeTV2coFDi2Ra7pGmM38VJ7LmEcl1cMU', NULL, '122.173.157.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNDBjUXFNbFYxQkZJSDY0blExS3I4R0dmSW9McFlkbTlmSTZ3RUJiTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777718425),
('Hw2yygn6m5Exl2bbhrBeDIPRrX82AFAwvmVqNYKQ', NULL, '152.57.163.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiamtnazNpdnAxTWowV0lxR3hUMTZUOURMYmxiV1FwYjVqQVR4YUxLdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777538600),
('IaDKb2iLVoTx4g4ykZ6KbifFV3HJMgZ2px9NwfND', NULL, '152.57.182.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOW9scFVXOENiWmROZ0RZc2NheHpIbzJTTEdkTklLdmgxalJaU0xndCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778399521),
('JH8CAjy9YgoTDruT3jMsQAFm1E42YNVFuopot0TF', NULL, '103.120.51.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMEliZ3ZXMm5NOXRaVVFMOXlyc1BmS2d3V0RqY2J3dnRHN0FYV2Z4NCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777963411),
('jQuDPTVJlw3FEjHfAUmQuOdGhuSSdN27lq5JTqHk', NULL, '122.173.157.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZklxR2RjV3ZwVkY2YUFzbXhHWjFqbng0MTdjNUU2QllsNXZWTzRPRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777705703),
('JrEV0dIVSsgYqmizJLSrJT3w2TI5MrtnVkwj6ZWD', NULL, '152.57.174.94', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibFAzZlBscEFsY0t5OGtnTm01c1FISXhMcE4zcjhubVhiWXZMQ2E4RiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777703361),
('Kdj6Pghb1cWxG9R0bpEU7vx9nQKD2VwERM3QUEBd', NULL, '122.171.119.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieXdjbUc0WXQ1QkNvQVh6T3hJWlRHRlMzcmJ0MEhpZldvVWc5bHh4ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778043020),
('Kfx73PV5ffqOP80OJDgXEqdnMa8aqs4rmRVp8u7T', NULL, '223.230.109.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiczgxdGZKdms3ZnBsR3djMWd3Rm95T3FqTDIzbzZvVFZNVjZWeGxMNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777374390),
('kkou9Lp5WlSlnYwpfEIPZULeuWTuSdFwhJXHyoSt', NULL, '103.120.51.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiY0s5WDZGeE4xZGgwUVFFUEVIVVAwRUlCdEdCd1psYmlhMjZmdnJlbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777025760),
('m2AJgTzRmC8Wd3gkyrBWODz0QJSMj9IutlFGbjd2', NULL, '152.57.147.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZm05VDVVMjRQMFk0ckh5NFlPRVlER1dUM1FHRTlzQ0hvR3gyRzB5bSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vY29uc3RydWN0aW9uLWFwaS5lYXN5Yml6Y2FydC5jb20vcHVibGljIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776596624),
('Mw9QeUMgwdmRcSWGUO62D32ISkcuzMd6RsgCukFd', NULL, '103.120.51.81', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicGZsVElpMDdMeXR2OG1YbG1hUVpTZTJvbjhYYjVWUk1MQ3ZmY0pzRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777271275),
('O2TGcd9HDoK2rdxOJicMrpqmriLb3pRPmkomOnWf', NULL, '152.59.201.217', 'WhatsApp/2.23.20.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMFlaOXNBQklpSENmMlR5UlV1Q2dHYVh6a1pyN3lwTEgyYUlON2FWaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777718407),
('PKrdCWDUC8VQIKihT8dkrN2Je6QJsk1ugXJ1IyEg', NULL, '122.164.41.207', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSVpxclFRV3FpdnlvTzM3SVFaMHVuUkFIZm12Mk5ZS2tZNWpXTXBwcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777359096),
('qUVDcKaieKqdRsEDa1vPB4XN3xsr6LwDnawArgNm', NULL, '152.57.163.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSnY5SlYxNUdQbUlTNExBSmVGM2hYRzVGRjNaRnBmaWpwTzRtYUJlNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777552129),
('r4E9w7yFzpHNvuxvflfYNgj92zq5DrNsEPV3rS0t', NULL, '152.59.201.217', 'WhatsApp/2.23.20.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTW9XR3NsTEhmc05PR3BGcUxjOFBXcDd2MjNsR2NsMk5hNHBLblAyZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777718426),
('tyGZqoVdxmfNf9hM05LoQ7cgG5H853JfJon5bgmO', NULL, '122.164.41.207', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYVZwRDUwQW45M242bnhMWUZiRnpiNnJhTHJrVElvZHdKdjRPQlpuZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777367768),
('Uj1tCk72VjgCeBSzKueHtekpFJ6ZSud6o4uaZaa3', NULL, '157.35.99.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSGN6T2JKWGRKUGI2NEJRRGhuejRaWFpPbnYxa1FxbW55c0VTT1ljRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777703019),
('UwEeCdsLs5EP1yy6fdX9mZTo6Z4LKAdIFjrMVNU5', NULL, '103.120.51.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQW50bzJpaWpuMmlQOXlOdWlRamRCVzZpVXdxZmJ1NUc4N0dFcFlKYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776841723),
('v953czCobBxzxPsuNvvpkWQjE0W2HoSQMUFicxee', NULL, '103.120.51.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUmprdnRrQXFjdERrNEp1bEdMNkNRaFpCaU1iVHB1NGZ4eTNCekhLQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777454811),
('YF72fzVu5C84hPfDaK8aKF9MUVBXpec1vNQ0lxWy', NULL, '152.57.174.94', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiczg0dW5DZDF0bGVIZTFTRzF4YUh1Um9NRXVjcHpWUlNTeHRqN3czVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777703191),
('YffzJaVhOPmsnqxFF0zAsK0aNqkNuzOWYGtTim1t', NULL, '103.120.51.81', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaUx6NjZ3c2F6c01jV3RJY1JxRGFnZ0hFVExweUdUcm9ncXlVQlVqSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777280394),
('YQOD45PLzvk6ShMf9GbRGguNfP1NGJhsVcAeiZ0p', NULL, '103.120.51.54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZTc1cm1tdFcxQXNpc0lmZWs4WDJIeTdNc2RzVktlTlpzeVd5bXVpaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778732673),
('z8H5QAF6H1KMfcjTdpEoFXgQ8F9GtM1wncPO6O5K', NULL, '152.57.166.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1E2S05nN3ZOTFNYeElZNzQ2T1dVbEtwczlkY1JUYzg2SHpiVGpSZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vY29uc3RydWN0aW9uLWFwaS5lYXN5Yml6Y2FydC5jb20vcHVibGljIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777457571),
('ZjqlZey3MDBkbUyianciuoTIppAIFYyKC0KjdEB7', NULL, '103.120.51.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOExoMnp3WmdrZjg5enpqN0tQUlJNQjFLeXg3ZGpocG5NM0lNc2trUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776926735);

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
  `phone` bigint(20) DEFAULT NULL,
  `role` enum('admin','manager','supervisor','accountent') NOT NULL DEFAULT 'manager',
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$vQ8MUyM37yQ2JYGkVqTBrO1zu8b5AdwsaQwzvEv./XrBGLbGSi3Hq', 9999999999, 'admin', NULL, NULL, '2026-04-19 11:03:20', '2026-04-19 11:03:20', 1),
(2, 'admin', 'admin234@gmail.com', NULL, '$2y$12$2SIQoU/06rCmoXrPcjoAluNvp7M3BqD.YxDUuwaPAY4p.D6Vr7LcO', 8374257687, 'admin', NULL, NULL, '2026-04-22 07:04:40', '2026-04-22 07:04:40', 1),
(3, 'Admin2', 'admin231@gmail.com', NULL, '$2y$12$2oZrO2i2laV9gR8E9N39oOL66N0g70bv3iaQ.zU0XWow4yp1dHvMS', 8179575731, 'admin', NULL, NULL, '2026-04-22 07:22:51', '2026-04-22 07:22:51', 1),
(4, 'admin5', 'admin3@gmail.com', NULL, '$2y$12$B/TxU9uPa3iYRzyccrix2ug5XQsdr/dJYeJswjIw0gqLul8sP0sja', 6300370899, 'admin', NULL, NULL, '2026-04-22 07:31:09', '2026-04-22 07:31:09', 1),
(5, 'admin', 'admin55@gmail.com', NULL, '$2y$12$McARI.GjNBokc7N3yxQsPO/Lpp93O0rlWeFBRn7KgFzRKUNVcjfqK', 8374257687, 'supervisor', NULL, NULL, '2026-04-22 09:39:42', '2026-04-22 09:39:42', 0),
(6, 'kalpana', 'kalpana@gmail.com', NULL, '$2y$12$1kwOvAipgnN1MW4n9E2KNOc5VNnJ82GET3nNMwh216r2UoG2NiR02', 8179575731, 'manager', NULL, NULL, '2026-04-22 09:40:48', '2026-04-22 09:40:48', 1),
(7, 'Mayuri', 'mayurikharwade10@gmail.com', NULL, '$2y$12$2kzFOAHn67B9zRYsXoYSDeMtw9HByhUrsouZlaHKRyRgNU18xCKWG', 8554933260, 'admin', NULL, NULL, '2026-04-22 10:21:38', '2026-04-22 10:21:38', 1),
(8, 'TestAdmin', 'testadmin22@easybiz.com', NULL, '$2y$12$f9yy3mhs4ausFaXyxhvkJen9DjJVGqUSjuSQn6LHGK1InH3QBhwzq', 9876543210, 'admin', NULL, NULL, '2026-04-22 10:23:58', '2026-04-22 10:23:58', 1),
(9, 'manager', 'manager@gmail.com', NULL, '$2y$12$e642/HikVLlEK5Yf3qx59.qnjwAtRcW4YYimyrp/D00zsppSS2k4m', 8374257688, 'manager', NULL, NULL, '2026-04-24 11:35:43', '2026-04-24 11:35:43', 1),
(10, 'shruti', 'shruti@10gmail.com', NULL, '$2y$12$jFWmTN.1fNYQo6qcLG.SB.QjnjcdGJjWxzr.nJlZUIYNNqQAPbZPS', 9356250227, 'admin', NULL, NULL, '2026-04-28 06:32:57', '2026-04-28 06:32:57', 1),
(11, 'damu', 'damu10@gmail.com', NULL, '$2y$12$udgWFy51G3YDHOHFXD0WRuGZQfoNdunaOprQF/F1ap7PZ0/nGAljy', 5678323245, 'admin', NULL, NULL, '2026-04-28 06:39:10', '2026-04-28 06:39:10', 1),
(12, 'sona', 'sona10@gmil.com', NULL, '$2y$12$JNKWnKchcxKA2tT0Eao6puWlJuLmvYoY71747qrr5OYtQ0qSGTjWe', 5493326067, 'admin', NULL, NULL, '2026-04-28 06:43:41', '2026-04-28 06:43:41', 1),
(13, 'seema', 'seema2@gmail.com', NULL, '$2y$12$vInEcU7dJVmGAxOTPzvQCOJwo2K.KOOCwOa1E9G7VY3O4kyRt80UW', 9856240447, 'admin', NULL, NULL, '2026-04-28 06:56:48', '2026-04-28 06:56:48', 1),
(14, 'testuser1', 'testuser1@gmail.com', NULL, '$2y$12$XQAsMuK4Xd4TpQ4Z..rf9e4Bo41JZswDDfLnlbyLbVG2wAfZ4qB3m', 9876543211, 'admin', NULL, NULL, '2026-04-28 07:04:25', '2026-04-28 07:04:25', 1),
(15, 'Vikram Singh', 'vikram.singh@example.com', NULL, '$2y$12$80iPHZwAHBI7Gj9ysXqFg.Wvchzl9GhxaombZaVcntikImOoxnauC', 9123456780, 'admin', NULL, NULL, '2026-04-28 07:45:25', '2026-04-28 07:45:25', 1),
(16, 'ghansham', 'ghanshyam@gmail.com', NULL, '$2y$12$HWVYa4wjKp94UIFsljFcI.ETCTck5XLokepC3OLnWErnmJUOpemrm', 8554933260, 'manager', NULL, NULL, '2026-04-28 09:41:08', '2026-04-28 09:41:08', 1),
(17, 'monalisa', 'monalisa@gmail.com', NULL, '$2y$12$O82lhapguwRycCie5nCekevnrTYIT2RV6Pw0X9sqxnSGOIJjGUoN2', 8554933780, 'supervisor', NULL, NULL, '2026-04-28 09:43:59', '2026-04-28 09:43:59', 1),
(18, 'Mona Sharma', 'mona.sharma@example.com', NULL, '$2y$12$vBbIMR9/fdKS8LqIKfJ36uKutuK.RBzspZLam6F/dDEY0dUoBEe.W', 9988776611, 'manager', NULL, NULL, '2026-04-28 09:48:26', '2026-04-28 09:48:26', 1),
(19, 'wqewretr', 'asdfgj@gmail.com', NULL, '$2y$12$qB9Yzah3T6/jm8gDntgXs.XP3J3.Ska43VKwnSDf9YJdK95WXb5uG', 8554933261, 'manager', NULL, NULL, '2026-04-28 10:48:26', '2026-04-29 09:47:37', 0),
(22, 'abc', 'kalpana2125@gmail.com', NULL, '$2y$12$CeVVTmMui3Sk0CppU5C01.aIMS9ezv18TxKELq87upBZpTGVLmr76', 8790222642, 'manager', NULL, NULL, '2026-04-29 10:52:41', '2026-04-29 10:52:41', 1),
(23, 'madhuri', 'madhuri3@gmail.com', NULL, '$2y$12$MsoFsZ0wtd7fl8eDATXnj.iblXKwpGJ8TsupcreeFAJkPbWprBR0u', 9356723456, 'admin', NULL, NULL, '2026-05-02 09:15:41', '2026-05-02 09:15:41', 1),
(25, 'Admin User', 'newadmin2024@test.com', NULL, '$2y$12$VtBl0rCFPfTwcZrImwX2ien.6GviPOLCuxMlPTxIKsD1hMewIJlzC', 8888888888, 'admin', NULL, NULL, '2026-05-02 11:22:43', '2026-05-02 11:22:43', 1),
(26, 'Anjali Verma', 'anjali.verma01@gmail.com', NULL, '$2y$12$wP32yb2kslTyxgPHbyOWWuNddrw6Yq4qbd.XDmKP21dU2aNp5dLYe', 7855439904, 'admin', NULL, NULL, '2026-05-02 11:37:06', '2026-05-05 04:59:47', 0),
(29, 'xyz', 'xyz2@gmail.com', NULL, '$2y$12$r9GUfkkz0rOkfmvWusBdxe3SmC4ggxmxvfehcO30d6Sz/eKubal1W', 9876453278, 'admin', NULL, NULL, '2026-05-05 05:37:16', '2026-05-05 05:37:16', 1),
(30, 'abc', 'abc1@gmail.com', NULL, '$2y$12$GP9Xq4o63Rg6jjhYQvrh3u3YqM43Fm4Y24QkB5HM2rvrR4kBX9a9O', 8867542399, 'admin', NULL, NULL, '2026-05-05 05:54:36', '2026-05-05 05:54:36', 1),
(31, 'efg', 'efg2@gmail.com', NULL, '$2y$12$3AP9J9BylnQPGiza6FkZteV6gS7DeZCwEYqzBU0knNjhyfoI.jlVG', 9976453323, 'admin', NULL, NULL, '2026-05-05 06:01:31', '2026-05-05 06:01:31', 1),
(32, 'oop', 'oop2@gmail.com', NULL, '$2y$12$0cbvfmqMnobv3yK9gvu3MuKovwEQ3oscDpVaGMxV9pID5y0JJIoPq', 9345667533, 'admin', NULL, NULL, '2026-05-05 06:09:49', '2026-05-05 06:09:49', 1),
(33, 'su nagar', 'su2@gmail.com', NULL, '$2y$12$Wxr16T.AMBLYPPamT7LDfONbqPtKMtdkJKBYYo4k.4P.factfIo3i', 9876543235, 'admin', NULL, NULL, '2026-05-05 06:14:23', '2026-05-05 06:14:23', 1),
(34, 'uri dom', 'uri2@gmail.com', NULL, '$2y$12$/sCC4M52tuVzoihI9t2W0.Hoyn2kTfKG4z5XX3h7UWtRyPuIUxXNW', 7764348965, 'admin', NULL, NULL, '2026-05-06 04:39:46', '2026-05-06 04:39:46', 1),
(35, 'Damini', 'Damini10@gmail.com', NULL, '$2y$12$J/.fMBztegAQZskRWGObdupDaRQZkiDoWiD7DCOj1YjLKjOXP/xT.', 4533267723, 'admin', NULL, NULL, '2026-05-06 04:43:25', '2026-05-06 04:43:25', 1),
(36, 'pillu', 'pillu2@gmail.com', NULL, '$2y$12$cq/cTleBUqN3ymCME3vDhuKRezcTq35RWcbirwblNmLakWB/tnxOS', 7645258956, 'admin', NULL, NULL, '2026-05-06 05:04:31', '2026-05-06 05:04:31', 1),
(37, 'Diya', 'diya2@gmail.com', NULL, '$2y$12$titjRANPc6AgyxTPcEyWkefTR7KIGJ5stIpVlApfu66AH3SxvI9QW', 5587993422, 'admin', NULL, NULL, '2026-05-06 05:17:36', '2026-05-06 05:17:36', 1),
(38, 'naresh', 'naresh2@gmail.com', NULL, '$2y$12$nqY7tYXQVGKawejjqFyn9Ohf.RePDe.La8LnH7N5p8JqDo2d5EYzS', 9856342267, 'admin', NULL, NULL, '2026-05-06 05:21:37', '2026-05-06 05:21:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`type`)),
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `type`, `name`, `contact`, `notes`, `created_at`, `updated_at`) VALUES
(4, '[\"material\"]', 'sonal', '8179575731', NULL, '2026-04-23 09:56:52', '2026-04-28 11:22:45'),
(6, '[\"labour\"]', 'kalpana', '8374257687', NULL, '2026-04-24 12:14:04', '2026-04-24 12:14:04'),
(8, '[\"labour\"]', 'yogita', '7890564345', NULL, '2026-04-28 11:17:53', '2026-04-28 11:17:53'),
(9, '[\"labour\",\"material\",\"machinery\"]', 'hello', '9989318982', NULL, '2026-05-05 05:00:40', '2026-05-05 05:00:40'),
(10, '[\"labour\",\"material\"]', 'testing', '6789045346', NULL, '2026-05-05 05:01:43', '2026-05-05 05:01:43'),
(11, '[\"machinery\"]', 'abc', '6789023459', NULL, '2026-05-05 05:02:28', '2026-05-05 05:02:47'),
(12, '[\"labour\",\"material\"]', 'adflj', '6789023489', NULL, '2026-05-05 05:12:58', '2026-05-05 05:12:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_allocations`
--
ALTER TABLE `account_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_allocations_user_id_foreign` (`user_id`),
  ADD KEY `account_allocations_project_id_foreign` (`project_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_labour_id_date_unique` (`labour_id`,`date`),
  ADD KEY `attendances_added_by_foreign` (`added_by`);

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
-- Indexes for table `equipment_entries`
--
ALTER TABLE `equipment_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_entries_equipment_id_foreign` (`equipment_id`),
  ADD KEY `equipment_entries_vendor_id_foreign` (`vendor_id`),
  ADD KEY `equipment_entries_added_by_foreign` (`added_by`);

--
-- Indexes for table `equipment_entry_histories`
--
ALTER TABLE `equipment_entry_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_entry_histories_user_id_foreign` (`user_id`),
  ADD KEY `equipment_entry_histories_equipment_entry_id_created_at_index` (`equipment_entry_id`,`created_at`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_vendor_id_foreign` (`vendor_id`),
  ADD KEY `expenses_labour_id_foreign` (`labour_id`),
  ADD KEY `expenses_added_by_foreign` (`added_by`),
  ADD KEY `expenses_project_id_vendor_id_labour_id_type_index` (`project_id`,`vendor_id`,`labour_id`,`type`),
  ADD KEY `expenses_item_id_foreign` (`item_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `labours`
--
ALTER TABLE `labours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labours_added_by_foreign` (`added_by`),
  ADD KEY `labours_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `labour_histories`
--
ALTER TABLE `labour_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labour_histories_user_id_foreign` (`user_id`),
  ADD KEY `labour_histories_labour_id_type_created_at_index` (`labour_id`,`type`,`created_at`);

--
-- Indexes for table `labour_reports`
--
ALTER TABLE `labour_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labour_reports_vendor_id_date_unique` (`vendor_id`,`date`),
  ADD KEY `labour_reports_added_by_foreign` (`added_by`);

--
-- Indexes for table `labour_wages`
--
ALTER TABLE `labour_wages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labour_wages_labour_id_effective_from_unique` (`labour_id`,`effective_from`),
  ADD KEY `labour_wages_labour_id_effective_from_effective_to_index` (`labour_id`,`effective_from`,`effective_to`);

--
-- Indexes for table `material_consumptions`
--
ALTER TABLE `material_consumptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_consumptions_vendor_id_foreign` (`vendor_id`),
  ADD KEY `material_consumptions_item_id_foreign` (`item_id`),
  ADD KEY `material_consumptions_added_by_foreign` (`added_by`),
  ADD KEY `mc_pvid` (`project_id`,`vendor_id`,`item_id`,`consumption_date`);

--
-- Indexes for table `material_entries`
--
ALTER TABLE `material_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_entries_item_id_foreign` (`item_id`),
  ADD KEY `material_entries_vendor_id_foreign` (`vendor_id`),
  ADD KEY `material_entries_added_by_foreign` (`added_by`),
  ADD KEY `material_entries_project_id_vendor_id_item_id_index` (`project_id`,`vendor_id`,`item_id`);

--
-- Indexes for table `material_entry_histories`
--
ALTER TABLE `material_entry_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_entry_histories_user_id_foreign` (`user_id`),
  ADD KEY `material_entry_histories_material_entry_id_created_at_index` (`material_entry_id`,`created_at`);

--
-- Indexes for table `material_stock_reports`
--
ALTER TABLE `material_stock_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `msr_unique` (`project_id`,`vendor_id`,`item_id`,`report_date`,`added_by`),
  ADD KEY `material_stock_reports_vendor_id_foreign` (`vendor_id`),
  ADD KEY `material_stock_reports_item_id_foreign` (`item_id`),
  ADD KEY `material_stock_reports_added_by_foreign` (`added_by`),
  ADD KEY `msr_pvid` (`project_id`,`vendor_id`,`item_id`,`report_date`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `project_funds`
--
ALTER TABLE `project_funds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_funds_project_id_added_by_unique` (`project_id`,`added_by`),
  ADD KEY `project_funds_added_by_foreign` (`added_by`),
  ADD KEY `project_funds_project_id_added_by_index` (`project_id`,`added_by`);

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
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_allocations`
--
ALTER TABLE `account_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `equipment_entries`
--
ALTER TABLE `equipment_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `equipment_entry_histories`
--
ALTER TABLE `equipment_entry_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labours`
--
ALTER TABLE `labours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `labour_histories`
--
ALTER TABLE `labour_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labour_reports`
--
ALTER TABLE `labour_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `labour_wages`
--
ALTER TABLE `labour_wages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `material_consumptions`
--
ALTER TABLE `material_consumptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `material_entries`
--
ALTER TABLE `material_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `material_entry_histories`
--
ALTER TABLE `material_entry_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `material_stock_reports`
--
ALTER TABLE `material_stock_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_funds`
--
ALTER TABLE `project_funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_allocations`
--
ALTER TABLE `account_allocations`
  ADD CONSTRAINT `account_allocations_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_allocations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_labour_id_foreign` FOREIGN KEY (`labour_id`) REFERENCES `labours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment_entries`
--
ALTER TABLE `equipment_entries`
  ADD CONSTRAINT `equipment_entries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_entries_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_entries_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment_entry_histories`
--
ALTER TABLE `equipment_entry_histories`
  ADD CONSTRAINT `equipment_entry_histories_equipment_entry_id_foreign` FOREIGN KEY (`equipment_entry_id`) REFERENCES `equipment_entries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_entry_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_labour_id_foreign` FOREIGN KEY (`labour_id`) REFERENCES `labours` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labours`
--
ALTER TABLE `labours`
  ADD CONSTRAINT `labours_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `labours_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labour_histories`
--
ALTER TABLE `labour_histories`
  ADD CONSTRAINT `labour_histories_labour_id_foreign` FOREIGN KEY (`labour_id`) REFERENCES `labours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `labour_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `labour_reports`
--
ALTER TABLE `labour_reports`
  ADD CONSTRAINT `labour_reports_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `labour_reports_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labour_wages`
--
ALTER TABLE `labour_wages`
  ADD CONSTRAINT `labour_wages_labour_id_foreign` FOREIGN KEY (`labour_id`) REFERENCES `labours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_consumptions`
--
ALTER TABLE `material_consumptions`
  ADD CONSTRAINT `material_consumptions_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_consumptions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_consumptions_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_consumptions_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_entries`
--
ALTER TABLE `material_entries`
  ADD CONSTRAINT `material_entries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_entries_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_entries_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_entries_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_entry_histories`
--
ALTER TABLE `material_entry_histories`
  ADD CONSTRAINT `material_entry_histories_material_entry_id_foreign` FOREIGN KEY (`material_entry_id`) REFERENCES `material_entries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_entry_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `material_stock_reports`
--
ALTER TABLE `material_stock_reports`
  ADD CONSTRAINT `material_stock_reports_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_stock_reports_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_stock_reports_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_stock_reports_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_funds`
--
ALTER TABLE `project_funds`
  ADD CONSTRAINT `project_funds_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_funds_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
