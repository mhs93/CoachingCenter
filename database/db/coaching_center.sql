-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2022 at 07:33 PM
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
  `transaction_id` int(10) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active / 0 = Deactivate',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_no`, `account_holder`, `bank_id`, `branch_name`, `transaction_id`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AC-11111', 'Habib', 1, 'Uttara', NULL, NULL, 1, 1, NULL, '2022-09-11 12:12:08', '2022-09-11 12:12:08', NULL),
(2, 'AB-22222', 'Suhag', 2, 'Uttara', NULL, '<p><strong>No</strong></p>', 1, 1, NULL, '2022-09-11 12:40:43', '2022-09-11 12:40:43', NULL);

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

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `student_id`, `batch_id`, `date`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 16, '2022-09-10', 1, 3, NULL, '2022-09-10 01:24:53', '2022-09-10 01:26:05', NULL),
(2, 7, 17, '2022-09-11', 0, 1, NULL, '2022-09-10 23:51:54', '2022-09-11 03:01:08', NULL);

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

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sonali', 1, NULL, NULL, '2022-09-07 01:11:38', '2022-09-07 01:11:38', NULL),
(2, 'rupali', 1, NULL, NULL, '2022-09-10 04:35:08', '2022-09-10 04:35:08', NULL),
(3, 'Janataa', 1, NULL, NULL, '2022-09-10 04:42:09', '2022-09-10 04:42:24', NULL);

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
(1, 'Dr. Albin Brown', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:17', '2022-09-10 05:52:17'),
(2, 'Telly Thompson I', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:15', '2022-09-10 05:52:15'),
(3, 'Amos Stracke Jr.', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:14', '2022-09-10 05:52:14'),
(4, 'Dr. Chester Larson', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:27', '2022-09-10 05:52:27'),
(5, 'Miss Vernice Stracke Jr.', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:19', '2022-09-10 05:52:19'),
(6, 'Demarco Gibson', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:42:44', '2022-09-10 05:42:44'),
(7, 'Brook Beer', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:10', '2022-09-10 05:52:10'),
(8, 'Dr. Reese Ledner II', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:22', '2022-09-10 05:52:22'),
(9, 'Dr. Quentin Fisher I', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:42:47', '2022-09-10 05:42:47'),
(10, 'Prof. Khalil Abshire', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:09', '2022-09-10 05:52:09'),
(11, 'Dr. Annabel D\'Amore Sr.', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:12', '2022-09-10 05:52:12'),
(12, 'Loma Hills', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:07', '2022-09-10 05:52:07'),
(13, 'Kyleigh Cormier', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:25', '2022-09-10 05:52:25'),
(14, 'Lavada Weimann', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:52:06', '2022-09-10 05:52:06'),
(15, 'Johnathon O\'Kon MD', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:42:39', '2022-09-10 05:42:39'),
(16, 'Batch 11', 1, NULL, NULL, '2022-09-10 00:53:31', '2022-09-10 05:54:29', '2022-09-10 05:54:29'),
(17, 'BATCH2', 1, NULL, NULL, '2022-09-10 05:52:39', '2022-09-10 05:52:39', NULL),
(18, 'BATCH3', 1, NULL, NULL, '2022-09-10 05:52:56', '2022-09-10 05:52:56', NULL),
(19, 'BATCH4', 1, NULL, NULL, '2022-09-10 05:53:37', '2022-09-10 05:53:37', NULL),
(20, 'BATCH1sdfsdf', 1, NULL, NULL, '2022-09-10 05:54:04', '2022-09-10 06:25:38', NULL),
(21, 'BATCH1sdfsdf', 1, NULL, NULL, '2022-09-10 06:25:37', '2022-09-10 06:25:37', NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_06_19_095043_create_subjects_table', 1),
(6, '2022_06_19_095044_create_batches_table', 1),
(7, '2022_06_19_095045_create_students_table', 1),
(8, '2022_06_25_103915_create_teachers_table', 1),
(9, '2022_06_25_184539_create_announcements_table', 1),
(10, '2022_06_27_093126_create_payments_table', 1),
(11, '2022_06_28_102957_create_resources_table', 1),
(12, '2022_08_03_072832_create_attendances_table', 1),
(13, '2022_08_25_051013_create_paymentcategories_table', 1),
(14, '2022_08_27_064858_create_accounts_table', 1),
(15, '2022_08_27_070300_create_banks_table', 1),
(16, '2022_09_01_191553_create_transactions_table', 1),
(17, '2022_09_03_102409_create_class_rooms_table', 1);

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

--
-- Dumping data for table `paymentcategories`
--

INSERT INTO `paymentcategories` (`id`, `cat_name`, `amount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'subject fee', '6000', NULL, NULL, '2022-09-09 23:08:38', '2022-09-09 23:08:38', NULL);

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reg_no`, `amount`, `paid_amount`, `due_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '347', '50000', '3000', '2000', NULL, NULL, '2022-09-09 23:09:04', '2022-09-09 23:09:04', NULL);

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

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `reg_no`, `email`, `batch_id`, `gender`, `current_address`, `permanent_address`, `contact_number`, `parent_contact`, `profile`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mariko Justice', '488', 'fafipaq@mailinator.com', 8, 2, 'Quibusdam officia Na', 'Sequi voluptas obcae', '467', '968', 'user_image.jpg', 1, 1, NULL, '2022-09-07 02:53:15', '2022-09-10 04:41:00', '2022-09-10 04:41:00'),
(2, 'Nantu', '290', 'nantu@gmail.com', 7, 1, 'Eum dolor ut dicta a', 'Sint iste et et dui', '395', '783', '1662786146.jpg', 1, 1, NULL, '2022-09-09 23:02:26', '2022-09-09 23:02:26', NULL),
(3, 'Christopher Larsennnn', '577', 'pikepuja@mailinator.com', 14, 2, 'Iusto dolore corrupt', 'Adipisicing et verit', '396', '202', '1662808065.jpg', 1, 3, 3, '2022-09-10 01:17:15', '2022-09-10 05:21:52', '2022-09-10 05:21:52'),
(4, 'Odette Yatessss', '366', 'sehymevyke@mailinator.com', 11, 2, 'Voluptas qui adipisi', 'Voluptatem id veniam', '540', '314', '1662808900.jpg', 1, 3, 3, '2022-09-10 04:40:48', '2022-09-10 05:21:40', NULL),
(5, 'Isaiah Carpenter', '248', 'dapafimy@mailinator.com', 3, 1, 'Exercitation et poss', 'Sunt possimus quo e', '84', '817', '1662809181.jpg', 1, 3, NULL, '2022-09-10 05:26:21', '2022-09-10 05:26:21', NULL),
(6, 'Lance Fitzgerald', '177', 'xypyfipu@mailinator.com', 6, 2, 'Nisi quibusdam cumqu', 'Tempora eum providen', '954', '863', '1662809195.jpg', 1, 3, NULL, '2022-09-10 05:26:35', '2022-09-10 05:26:35', NULL),
(7, 'Quail Mejia', '184', 'vytus@mailinator.com', 17, 1, 'Sunt ipsum voluptate', 'Fuga Consectetur qu', '290', '787', 'user_image.jpg', 1, 1, NULL, '2022-09-10 23:51:34', '2022-09-10 23:51:34', NULL);

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
(1, 'Miss Aiyana Kuhn', '762887', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-07 01:11:20', NULL),
(2, 'Brielle Gulgowski', '901451', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:46:43', '2022-09-10 05:46:43'),
(3, 'Mr. Raphael Fadel Sr.', '232887', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:50:17', '2022-09-10 05:50:17'),
(4, 'Curtis Rutherford', '330186', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:50:14', '2022-09-10 05:50:14'),
(5, 'Mike Gibson', '263009', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-07 01:11:20', NULL),
(6, 'Algo', 'AL101', 1, NULL, 3, '2022-09-07 01:11:20', '2022-09-10 05:46:31', NULL),
(7, 'Arnulfo Shanahan DDS', '115918', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:44:15', '2022-09-10 05:44:15'),
(8, 'Lennie Crooks DDS', '338404', 1, NULL, NULL, '2022-09-07 01:11:20', '2022-09-10 05:44:11', '2022-09-10 05:44:11'),
(9, 'KDL-43W800F', 'hd', 1, 3, NULL, '2022-09-10 05:49:51', '2022-09-10 05:49:51', NULL),
(10, 'sadasd', 'sdfsdf', 1, 3, NULL, '2022-09-10 05:50:07', '2022-09-10 05:50:21', '2022-09-10 05:50:21'),
(11, 'Data Structure', 'DS505', 1, 3, NULL, '2022-09-10 05:51:14', '2022-09-10 05:51:14', NULL),
(12, 'DataStructure', 'DS55', 1, 3, NULL, '2022-09-10 05:51:33', '2022-09-10 05:51:38', NULL);

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

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `subject_id`, `name`, `email`, `gender`, `current_address`, `permanent_address`, `contact_number`, `profile`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Orli Terrell', 'kacyro@mailinator.com', 1, 'Nobis cupiditate cil', 'Eaque dolor reiciend', '477', '1662809216.jpg', 1, 3, NULL, '2022-09-10 05:26:56', '2022-09-10 05:27:02', '2022-09-10 05:27:02'),
(2, 4, 'Aurora Hicksss', 'relozubojo@mailinator.com', 2, 'Est nulla vel sit r', 'Est nulla vel sit r', '990', '1662809234.jpg', 1, 3, 3, '2022-09-10 05:27:14', '2022-09-10 05:27:57', '2022-09-10 05:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` tinyint(10) NOT NULL COMMENT '1= Debit / 2= Credit',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = withdrow, 2 = deposit, 3 = recived payment, 4 = given payment, 5 = Initial Balance',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 = Cheque, 2 = Balance Transfer',
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `account_id`, `transaction_type`, `amount`, `purpose`, `payment_type`, `cheque_number`, `transfer_details`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2022-09-11', 1, 2, '1000', '5', NULL, NULL, NULL, 'null', NULL, NULL, '2022-09-11 12:12:08', '2022-09-11 12:12:08', NULL),
(2, '2022-09-12', 1, 1, '600', '1', '1', '493', '<p>No</p>', 'No', 1, NULL, '2022-09-11 12:22:43', '2022-09-11 12:48:36', NULL),
(3, '2022-09-11', 2, 2, '1000', '5', NULL, NULL, NULL, 'No', NULL, NULL, '2022-09-11 12:40:43', '2022-09-11 12:40:43', NULL),
(4, '2022-09-12', 1, 1, '600', '4', '1', 'qweqwe', '<p><strong>NNN</strong></p>', 'No', 1, NULL, '2022-09-11 12:41:23', '2022-09-11 12:50:10', NULL);

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
(1, NULL, NULL, 'Mr. Admin', 'admin@admin.com', '2022-09-07 01:11:20', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 'L4VwGA6QkWIyc0PRF5MzGiOZHrL49eS0iAPPg6KNGzgLtN8XvdWe281aZnov', '2022-09-07 01:11:20', '2022-09-07 01:11:20', NULL),
(2, 1, NULL, ' ', 'fafipaq@mailinator.com', NULL, '$2y$10$P8ZM51jn0EGV/R/idnhWx.DMVOdFHGgtp44Ft7qykisSE.Q8T480u', 2, NULL, '2022-09-07 02:53:15', '2022-09-10 04:41:00', '2022-09-10 04:41:00'),
(3, 2, NULL, ' ', 'nantu@gmail.com', NULL, '$2y$10$CFgCWw.Jqk2oU2ajtRJq.e2uKdiUKgmcvnEq5WzwRL051PiSw7xNa', 2, NULL, '2022-09-09 23:02:27', '2022-09-09 23:02:27', NULL),
(4, 3, NULL, 'Christopher Larsennnn', 'pikepuja@mailinator.com', NULL, '$2y$10$.dAWtuEYddKhKXqV0ZiG4ug4rSfD0vZiUyLNwikONhLUF/GjJYcq2', 2, NULL, '2022-09-10 01:17:16', '2022-09-10 05:21:52', '2022-09-10 05:21:52'),
(5, 4, NULL, 'Odette Yatessss', 'sehymevyke@mailinator.com', NULL, '$2y$10$8A7aby1FrKhBrEWNWHv36uLTib44nuIaLJt8qG/YLl.vrc09udcKK', 2, NULL, '2022-09-10 04:40:48', '2022-09-10 05:21:40', NULL),
(6, 5, NULL, ' ', 'dapafimy@mailinator.com', NULL, '$2y$10$z6m03YBbgUy6XBIeCOhDw.vmtZ2ymnZLoFo5rDXppq9dfC8iBE04K', 2, NULL, '2022-09-10 05:26:21', '2022-09-10 05:26:21', NULL),
(7, 6, NULL, ' ', 'xypyfipu@mailinator.com', NULL, '$2y$10$6hy064BIEU/4eIPdTsKfuOlRJMrRQpr01K/NWxmNGnED99o63Ha7m', 2, NULL, '2022-09-10 05:26:35', '2022-09-10 05:26:35', NULL),
(8, NULL, 1, ' ', 'kacyro@mailinator.com', NULL, '$2y$10$BF.qAC3kahtkps1qh34KOuvOtt86hkGuNx6qBORhBRE6YH7k9Y/bS', 1, NULL, '2022-09-10 05:26:56', '2022-09-10 05:27:02', '2022-09-10 05:27:02'),
(9, NULL, 2, 'Aurora Hicksss', 'relozubojo@mailinator.com', NULL, '$2y$10$TY3UK/2asKvR6KJxkaq/x.4LNoKIsV6l0ZS5Y4o..cWmz4opa.7XG', 1, NULL, '2022-09-10 05:27:14', '2022-09-10 05:27:57', '2022-09-10 05:27:57'),
(10, 7, NULL, ' ', 'vytus@mailinator.com', NULL, '$2y$10$M2t6Pufg8iavPmwW9y3fqeMZDjL6csUorva9fSPcB3e3QeUVZVxVO', 2, NULL, '2022-09-10 23:51:34', '2022-09-10 23:51:34', NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `paymentcategories`
--
ALTER TABLE `paymentcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
