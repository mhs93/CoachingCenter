-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 22, 2022 at 09:32 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coaching_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_holder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1 = Present / 0 = Absent',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Batch name',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Prof. King Kuphal', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(2, 'Jaron Kertzmann III', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(3, 'Ava Borer Sr.', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(4, 'Dr. Reagan Ziemann', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(5, 'Jada Ruecker MD', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(6, 'Renee Strosin', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(7, 'Mrs. Winona Murazik', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(8, 'Prof. Myah McLaughlin', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(9, 'Hans Kessler', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(10, 'Tianna Harvey', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(11, 'Dr. Tavares Hyatt IV', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(12, 'Adrain Runolfsdottir', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(13, 'Carmine Ullrich', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(14, 'Tristian Moen', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(15, 'Dane Hermiston', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_rooms`
--

CREATE TABLE `class_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `class_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'class video link',
  `access_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'access key for watch class video',
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'class duration',
  `start_time` timestamp NULL DEFAULT NULL COMMENT 'class start date and time',
  `end_time` timestamp NULL DEFAULT NULL COMMENT 'class end time',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(229, '2014_10_12_000000_create_users_table', 1),
(230, '2014_10_12_100000_create_password_resets_table', 1),
(231, '2019_08_19_000000_create_failed_jobs_table', 1),
(232, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(233, '2022_06_19_095043_create_subjects_table', 1),
(234, '2022_06_19_095044_create_batches_table', 1),
(235, '2022_06_19_095045_create_students_table', 1),
(236, '2022_06_25_103915_create_teachers_table', 1),
(237, '2022_06_25_184539_create_announcements_table', 1),
(238, '2022_06_27_093126_create_payments_table', 1),
(239, '2022_06_28_102957_create_resources_table', 1),
(240, '2022_08_03_072832_create_attendances_table', 1),
(241, '2022_08_25_051013_create_paymentcategories_table', 1),
(242, '2022_08_27_064858_create_accounts_table', 1),
(243, '2022_08_27_070300_create_banks_table', 1),
(244, '2022_09_01_191553_create_transactions_table', 1),
(245, '2022_09_03_102409_create_class_rooms_table', 1),
(246, '2022_09_04_065525_create_modules_table', 1),
(247, '2022_09_04_065526_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Student Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(2, 'Batches Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(3, 'Subject Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(4, 'Announcement Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(5, 'ClassRooms Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(6, 'Attendance Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(7, 'Payment Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(8, 'Resources Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(9, 'Teacher Manage', '2022-09-22 03:31:42', '2022-09-22 03:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymentcategories`
--

CREATE TABLE `paymentcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module_id`, `title`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Student List', 'student_list', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(2, 1, 'Register Student', 'register_student', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(3, 1, 'Student Profile', 'student_profile', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(4, 1, 'Student Edit', 'student_edit', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(5, 1, 'Student Delete', 'student_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(6, 2, 'Batches Manage', 'batches_manage', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(7, 2, 'Batches Create', 'batches_create', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(8, 2, 'Batches Edit', 'batches_edit', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(9, 2, 'Batches Delete', 'batches_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(10, 3, 'Subject Manage', 'subject_manage', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(11, 3, 'Subject Create', 'subject_create', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(12, 3, 'Subject Show', 'subject_show', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(13, 3, 'Subject Edit', 'subject_edit', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(14, 3, 'Subject Delete', 'subject_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(15, 4, 'Announcement Manage', 'announcement_manage', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(16, 4, 'Announcement Show', 'announcement_show', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(17, 4, 'Announcement Create', 'announcement_create', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(18, 4, 'Announcement Edit', 'announcement_edit', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(19, 4, 'Announcement Delete', 'announcement_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(20, 5, 'ClassRooms Manage', 'classRooms_manage', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(21, 5, 'ClassRooms Create', 'classRooms_create', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(22, 5, 'ClassRooms Show', 'classRooms_show', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(23, 5, 'ClassRooms Edit', 'classRooms_edit', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(24, 5, 'ClassRooms Delete', 'classRooms_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(25, 6, 'Attendance Manage', 'attendance_manage', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(26, 6, 'Make Attendance', 'make_attendance', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(27, 6, 'Attendance Report', 'attendance_report', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(28, 7, 'Payment Manage', 'payment_manage', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(29, 8, 'Resources List', 'resources_list', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(30, 8, 'Upload Resource', 'upload_resource', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(31, 8, 'Upload Delete', 'upload_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(32, 9, 'Teacher List', 'teacher_list', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(33, 9, 'Teacher Register', 'teacher_register', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(34, 9, 'Teacher Profile', 'teacher_profile', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(35, 9, 'Teacher Edit', 'teacher_edit', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(36, 9, 'Teacher Delete', 'teacher_delete', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2022-09-22 03:31:42', '2022-09-22 03:31:42'),
(2, 'Teacher', 'web', '2022-09-22 03:31:43', '2022-09-22 03:31:43'),
(3, 'Student', 'web', '2022-09-22 03:31:43', '2022-09-22 03:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(1, 2),
(3, 2),
(6, 2),
(10, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(34, 2),
(1, 3),
(3, 3),
(4, 3),
(6, 3),
(10, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(32, 3),
(34, 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'This is student registration number (uniq)',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `current_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Subject name',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Subject code',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lelia Bayer', '322668', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(2, 'Ruby Kassulke', '951408', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(3, 'Travon Robel', '796727', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(4, 'Maggie Cummerata Jr.', '706751', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(5, 'Electa Watsica', '584282', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(6, 'Cristobal White', '945188', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(7, 'Margaretta Kulas', '824583', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL),
(8, 'Miss Anastasia McCullough DVM', '633768', 1, NULL, NULL, '2022-09-22 03:31:42', '2022-09-22 03:31:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `current_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` tinyint(4) NOT NULL COMMENT '1= Debit / 2= Credit',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = withdrow, 2 = deposit, 3 = recived payment, 4 = given payment, 5 = Initial Balance',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 = Cheque, 2 = Balance Transfer',
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL COMMENT '0=admin 1=teacher 2=student',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `teacher_id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'Admin', 'admin@test.com', '2022-09-22 03:31:43', '$2y$10$pQx/OCmwAEIsx1PVuhOCOeQj4ijmQfpBZZ4yrteOJlc68IPJJxRbG', 0, NULL, '2022-09-22 03:31:43', '2022-09-22 03:31:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_rooms`
--
ALTER TABLE `class_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_rooms_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_name_unique` (`name`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `paymentcategories`
--
ALTER TABLE `paymentcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_code_unique` (`code`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `class_rooms`
--
ALTER TABLE `class_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `paymentcategories`
--
ALTER TABLE `paymentcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`);

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`);

--
-- Constraints for table `class_rooms`
--
ALTER TABLE `class_rooms`
  ADD CONSTRAINT `class_rooms_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
