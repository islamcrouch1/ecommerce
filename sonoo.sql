-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2022 at 01:55 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sonoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_stocks`
--

CREATE TABLE `affiliate_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affiliate_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `available_balance` double(8,2) NOT NULL,
  `outstanding_balance` double(8,2) NOT NULL,
  `pending_withdrawal_requests` double(8,2) NOT NULL,
  `completed_withdrawal_requests` double(8,2) NOT NULL,
  `bonus` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `user_id`, `available_balance`, `outstanding_balance`, `pending_withdrawal_requests`, `completed_withdrawal_requests`, `bonus`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(2, 4, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-11-07 15:28:07', '2022-11-07 15:28:07'),
(3, 5, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-11-09 00:50:16', '2022-11-09 00:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `bonuses`
--

CREATE TABLE `bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(2, 4, '2022-11-07 15:28:07', '2022-11-07 15:28:07'),
(3, 5, '2022-11-09 00:50:16', '2022-11-09 00:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `product_price` double NOT NULL,
  `product_type` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `size_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `profit` double(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `name`, `phone`, `whatsapp`, `place_type`, `email`, `address`, `gender`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2', 'اسلام محمد علي شعبان', '+201121184148', '0102916234', 'School', '+201121184148@unitedtoys-eg.com', 'ييسسيييسسيييسي', 'male', '2022-11-07 15:13:57', '2022-11-07 15:14:25', NULL),
(2, '3', 'qweqwewqewq', '+203232132121', '3123123213', 'other', '+203232132121@unitedtoys-eg.com', 'asdadsadsad', 'male', '2022-11-07 15:18:32', '2022-11-07 15:18:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_ar`, `name_en`, `code`, `currency`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'مصر', 'Egypt', '+20', 'EGP', 'rR24VxxvUqZZYfg2PabsWAno3fXoov04dRGvupwZ.png', '2022-11-07 15:13:51', '2022-11-07 15:13:51', NULL);

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `user_type`, `log_type`, `description_ar`, `description_en`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'users', 'تم اضافة عميل - اسلام محمد علي شعبان #1', 'add new client - اسلام محمد علي شعبان #1', '2022-11-07 15:13:57', '2022-11-07 15:13:57'),
(2, 1, 'admin', 'users', 'تم تعديل بيانات عميل - اسلام محمد علي شعبان #1', 'edit client data - اسلام محمد علي شعبان #1', '2022-11-07 15:14:25', '2022-11-07 15:14:25'),
(3, 1, 'admin', 'users', 'تم تعديل بيانات عميل - اسلام محمد علي شعبان #1', 'edit client data - اسلام محمد علي شعبان #1', '2022-11-07 15:15:10', '2022-11-07 15:15:10'),
(4, 1, 'admin', 'users', 'تم اضافة عميل - qweqwewqewq #2', 'add new client - qweqwewqewq #2', '2022-11-07 15:18:32', '2022-11-07 15:18:32'),
(5, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-08 23:27:14', '2022-11-08 23:27:14'),
(6, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - العمل بعت على الصفحة عايز يعرف اسعار مشروع', 'query added from user - اسلام محمد علي شعبان - العمل بعت على الصفحة عايز يعرف اسعار مشروع', '2022-11-08 23:45:33', '2022-11-08 23:45:33'),
(7, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', 'query added from user - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', '2022-11-08 23:46:06', '2022-11-08 23:46:06'),
(8, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', 'query added from user - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', '2022-11-08 23:47:46', '2022-11-08 23:47:46'),
(9, 1, 'admin', 'users', 'تم حذف استفسار لعميل - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', 'query added from user - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', '2022-11-09 00:15:40', '2022-11-09 00:15:40'),
(10, 1, 'admin', 'users', 'تم تعديل استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين1121211222121', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين1121211222121', '2022-11-09 00:21:09', '2022-11-09 00:21:09'),
(11, 1, 'admin', 'users', 'تم تعديل استفسار لعميل - اسلام محمد علي شعبان - العمل بعت على الصفحة عايز يعرف اسعار مشروعtttttttttttttttttttttttttttttttttttttttttt', 'query added from user - اسلام محمد علي شعبان - العمل بعت على الصفحة عايز يعرف اسعار مشروعtttttttttttttttttttttttttttttttttttttttttt', '2022-11-09 00:21:25', '2022-11-09 00:21:25'),
(12, 1, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - asdasdasdsadsad', 'note added for client - اسلام محمد علي شعبان - asdasdasdsadsad', '2022-11-09 00:22:29', '2022-11-09 00:22:29'),
(13, 1, 'admin', 'users', 'تم تعديل ملاحظة لعميل - اسلام محمد علي شعبان - السلام عليكم', 'note updated for user - اسلام محمد علي شعبان - السلام عليكم', '2022-11-09 00:33:10', '2022-11-09 00:33:10'),
(14, 1, 'admin', 'users', 'تم حذف الملاحظة لعميل - اسلام محمد علي شعبان - السلام عليكم', 'note added from user - اسلام محمد علي شعبان - السلام عليكم', '2022-11-09 00:33:20', '2022-11-09 00:33:20'),
(15, 4, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - لا يوجد مالحظات', 'note added for client - اسلام محمد علي شعبان - لا يوجد مالحظات', '2022-11-09 00:33:34', '2022-11-09 00:33:34'),
(16, 4, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - ;lk;l;k;lk;lkk;', 'note added for client - اسلام محمد علي شعبان - ;lk;l;k;lk;lkk;', '2022-11-09 00:36:12', '2022-11-09 00:36:12'),
(17, 4, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - صببصب', 'note added for client - اسلام محمد علي شعبان - صببصب', '2022-11-09 00:37:32', '2022-11-09 00:37:32'),
(18, 4, 'admin', 'users', 'تم تعديل ملاحظة لعميل - اسلام محمد علي شعبان - لا يوجد مالحظاتؤؤؤ', 'note updated for user - اسلام محمد علي شعبان - لا يوجد مالحظاتؤؤؤ', '2022-11-09 00:38:01', '2022-11-09 00:38:01'),
(19, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - fffffffffffffffffffffff', 'query added from user - اسلام محمد علي شعبان - fffffffffffffffffffffff', '2022-11-09 00:55:27', '2022-11-09 00:55:27'),
(20, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - العميل اتصل عايز حد يكلمة يشرحله مشروع منطقة الاعابل', 'query added from user - اسلام محمد علي شعبان - العميل اتصل عايز حد يكلمة يشرحله مشروع منطقة الاعابل', '2022-11-09 00:55:46', '2022-11-09 00:55:46'),
(21, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:57:13', '2022-11-09 00:57:13'),
(22, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:57:28', '2022-11-09 00:57:28'),
(23, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:58:03', '2022-11-09 00:58:03'),
(24, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:58:23', '2022-11-09 00:58:23'),
(25, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:58:40', '2022-11-09 00:58:40'),
(26, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:59:47', '2022-11-09 00:59:47'),
(27, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - العمل بعت على الصفحة عايز يعرف اسعار مشروع', 'query added from user - اسلام محمد علي شعبان - العمل بعت على الصفحة عايز يعرف اسعار مشروع', '2022-11-09 01:00:16', '2022-11-09 01:00:16'),
(28, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', 'query added from user - اسلام محمد علي شعبان - اتصال بيسال على عرض الاسعار', '2022-11-09 01:00:48', '2022-11-09 01:00:48'),
(29, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', 'query added from user - اسلام محمد علي شعبان - اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 01:01:56', '2022-11-09 01:01:56'),
(30, 1, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - على الله التساهيل', 'note added for client - اسلام محمد علي شعبان - على الله التساهيل', '2022-11-09 01:06:43', '2022-11-09 01:06:43'),
(31, 1, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - ملاحظة تجريبية', 'note added for client - اسلام محمد علي شعبان - ملاحظة تجريبية', '2022-11-09 01:06:59', '2022-11-09 01:06:59'),
(32, 1, 'admin', 'users', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان - بسم الله الرحمن الرحيم .. ارجو مراجعة الملاحظات لو سمحتم', 'note added for client - اسلام محمد علي شعبان - بسم الله الرحمن الرحيم .. ارجو مراجعة الملاحظات لو سمحتم', '2022-11-09 01:07:14', '2022-11-09 01:07:14'),
(33, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - qweqwewqewq - jbjjjj', 'query added from user - qweqwewqewq - jbjjjj', '2022-11-27 11:10:45', '2022-11-27 11:10:45'),
(34, 1, 'admin', 'users', 'تم اضافة استفسار لعميل - qweqwewqewq - يييييي', 'query added from user - qweqwewqewq - يييييي', '2022-11-27 13:09:43', '2022-11-27 13:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `sender_id`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 1, 'fgdgfg', '2022-11-07 17:45:55', '2022-11-07 17:45:55', NULL),
(2, 4, 1, 'sadasdsad', '2022-11-07 18:00:05', '2022-11-07 18:00:05', NULL),
(3, 4, 1, 'sadasdasdd', '2022-11-07 18:02:28', '2022-11-07 18:02:28', NULL),
(4, 4, 1, 'sssaassss', '2022-11-07 18:04:11', '2022-11-07 18:04:11', NULL),
(5, 4, 1, 'asasssaa', '2022-11-07 18:08:47', '2022-11-07 18:08:47', NULL),
(6, 4, 1, 'rrrrrrrrr', '2022-11-07 18:09:06', '2022-11-07 18:09:06', NULL),
(7, 4, 1, 'asdasdasd', '2022-11-07 18:10:58', '2022-11-07 18:10:58', NULL),
(8, 4, 1, 'sadasasasd', '2022-11-07 18:18:27', '2022-11-07 18:18:27', NULL),
(9, 4, 1, 'aSasasaSASasaaaaaaaaaaaaaaa', '2022-11-07 18:18:46', '2022-11-07 18:18:46', NULL),
(10, 4, 1, 'ASAsaS', '2022-11-07 18:19:30', '2022-11-07 18:19:30', NULL),
(11, 4, 1, 'asasASAss', '2022-11-07 18:28:55', '2022-11-07 18:28:55', NULL),
(12, 4, 1, 'qqqqqqqq', '2022-11-07 18:34:15', '2022-11-07 18:34:15', NULL),
(13, 4, 1, 'uuuuuuuuuuuuuuuuuuuuuuuu', '2022-11-07 22:27:12', '2022-11-07 22:27:12', NULL),
(14, 4, 1, 'jjjjjjjjjj', '2022-11-07 22:27:53', '2022-11-07 22:27:53', NULL),
(15, 4, 1, 'ryyy', '2022-11-07 22:38:44', '2022-11-07 22:38:44', NULL),
(16, 4, 1, 'aSAsaSas', '2022-11-07 22:47:22', '2022-11-07 22:47:22', NULL),
(17, 4, 1, 'asA', '2022-11-07 22:48:58', '2022-11-07 22:48:58', NULL),
(18, 4, 1, 'ZZZZZZZZZZZZZZZZZZ', '2022-11-07 22:51:47', '2022-11-07 22:51:47', NULL),
(19, 4, 1, 'SSSS', '2022-11-07 22:53:00', '2022-11-07 22:53:00', NULL),
(20, 4, 1, 'ASDASDADA', '2022-11-07 23:00:23', '2022-11-07 23:00:23', NULL),
(21, 4, 1, 'WQEQWeee', '2022-11-07 23:01:09', '2022-11-07 23:01:09', NULL);

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
(5, '2022_04_23_210658_laratrust_setup_tables', 1),
(6, '2022_04_26_024246_create_countries_table', 1),
(7, '2022_04_26_024428_create_settings_table', 1),
(8, '2022_04_26_024852_add_softdelete_column_to_countries_table', 1),
(9, '2022_04_26_024907_add_softdelete_column_to_users_table', 1),
(10, '2022_04_26_030123_create_carts_table', 1),
(11, '2022_04_26_030406_create_balances_table', 1),
(12, '2022_04_27_033435_add_softdelete_column_to_roles_table', 1),
(13, '2022_04_27_085702_create_logs_table', 1),
(14, '2022_04_28_190130_create_requests_table', 1),
(15, '2022_04_28_190834_create_notifications_table', 1),
(16, '2022_04_30_054531_create_categories_table', 1),
(17, '2022_04_30_054902_add_softdelete_column_to_categories_table', 1),
(18, '2022_04_30_055034_create_products_table', 1),
(19, '2022_04_30_055540_add_softdelete_column_to_products_table', 1),
(20, '2022_04_30_085902_create_category_product_table', 1),
(21, '2022_04_30_230507_create_sizes_table', 1),
(22, '2022_04_30_230650_create_colors_table', 1),
(23, '2022_04_30_230804_add_softdelete_column_to_sizes_table', 1),
(24, '2022_04_30_230819_add_softdelete_column_to_colors_table', 1),
(25, '2022_04_30_230858_create_stocks_table', 1),
(26, '2022_05_01_000332_create_affiliate_stocks_table', 1),
(27, '2022_05_01_062140_create_product_images_table', 1),
(28, '2022_05_05_055627_create_shipping_rates_table', 1),
(29, '2022_05_05_060055_add_softdelete_column_to_shipping_rates_table', 1),
(30, '2022_05_05_102702_create_slides_table', 1),
(31, '2022_05_05_103026_add_softdelete_column_to_slides_table', 1),
(32, '2022_05_05_202014_create_favorites_table', 1),
(33, '2022_05_06_182613_create_cart_product_table', 1),
(34, '2022_05_08_061358_create_orders_table', 1),
(35, '2022_05_08_061755_create_order_product_table', 1),
(36, '2022_05_08_064816_create_vendor_orders_table', 1),
(37, '2022_05_08_065846_create_product_vendor_order_table', 1),
(38, '2022_05_10_132714_create_order_notes_table', 1),
(39, '2022_05_10_133927_create_notes_table', 1),
(40, '2022_05_10_161539_create_bonuses_table', 1),
(41, '2022_05_12_000112_create_messages_table', 1),
(42, '2022_05_12_000400_add_softdelete_column_to_messages_table', 1),
(43, '2022_05_12_000416_add_softdelete_column_to_notes_table', 1),
(44, '2022_05_12_000440_add_softdelete_column_to_order_notes_table', 1),
(45, '2022_05_12_020840_create_withdrawals_table', 1),
(46, '2022_05_13_233346_create_refunds_table', 1),
(47, '2022_05_22_153344_add_column_to_stocks_table', 1),
(48, '2022_05_24_203659_create_reviews_table', 1),
(49, '2022_05_27_004400_create_order_histories_table', 1),
(50, '2022_05_27_172545_add_column_to_users_table', 1),
(51, '2022_06_05_235130_add_fields_to_users_table', 1),
(52, '2022_06_06_010719_create_store_products_table', 1),
(53, '2022_11_05_211059_create_clients_table', 1),
(54, '2022_11_05_222726_add_softdelete_column_to_clients_table', 1),
(55, '2022_11_06_010142_create_queries_table', 1),
(56, '2022_11_06_010509_add_softdelete_column_to_queries_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `admin_id`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'السلام عليكم', '2022-11-09 00:22:29', '2022-11-09 00:33:20', '2022-11-09 00:33:20'),
(2, 2, 4, 'لا يوجد مالحظاتؤؤؤ', '2022-11-09 00:33:34', '2022-11-09 00:38:01', NULL),
(3, 2, 4, ';lk;l;k;lk;lkk;', '2022-11-09 00:34:47', '2022-11-09 00:34:47', NULL),
(4, 2, 4, ';lk;l;k;lk;lkk;', '2022-11-09 00:35:12', '2022-11-09 00:35:12', NULL),
(5, 2, 4, ';lk;l;k;lk;lkk;', '2022-11-09 00:35:52', '2022-11-09 00:35:52', NULL),
(6, 2, 4, ';lk;l;k;lk;lkk;', '2022-11-09 00:36:12', '2022-11-09 00:36:12', NULL),
(7, 2, 4, 'صببصب', '2022-11-09 00:37:32', '2022-11-09 00:37:32', NULL),
(8, 2, 1, 'على الله التساهيل', '2022-11-09 01:06:43', '2022-11-09 01:06:43', NULL),
(9, 2, 1, 'ملاحظة تجريبية', '2022-11-09 01:06:59', '2022-11-09 01:06:59', NULL),
(10, 2, 1, 'بسم الله الرحمن الرحيم .. ارجو مراجعة الملاحظات لو سمحتم', '2022-11-09 01:07:14', '2022-11-09 01:07:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_id`, `sender_name`, `sender_image`, `title_ar`, `body_ar`, `title_en`, `body_en`, `date`, `url`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'fgdgfg', 'Message from technical support', 'fgdgfg', '2022-11-07 19:45:55', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 17:45:55', '2022-11-07 17:45:55'),
(2, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'sadasdsad', 'Message from technical support', 'sadasdsad', '2022-11-07 20:00:05', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:00:05', '2022-11-07 18:00:05'),
(3, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'sadasdasdd', 'Message from technical support', 'sadasdasdd', '2022-11-07 20:02:28', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:02:28', '2022-11-07 18:02:28'),
(4, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'sssaassss', 'Message from technical support', 'sssaassss', '2022-11-07 20:04:11', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:04:11', '2022-11-07 18:04:11'),
(5, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'asasssaa', 'Message from technical support', 'asasssaa', '2022-11-07 20:08:47', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:08:47', '2022-11-07 18:08:47'),
(6, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'rrrrrrrrr', 'Message from technical support', 'rrrrrrrrr', '2022-11-07 20:09:06', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:09:06', '2022-11-07 18:09:06'),
(7, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'asdasdasd', 'Message from technical support', 'asdasdasd', '2022-11-07 20:10:58', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:10:58', '2022-11-07 18:10:58'),
(8, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'sadasasasd', 'Message from technical support', 'sadasasasd', '2022-11-07 20:18:27', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:18:27', '2022-11-07 18:18:27'),
(9, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'aSasasaSASasaaaaaaaaaaaaaaa', 'Message from technical support', 'aSasasaSASasaaaaaaaaaaaaaaa', '2022-11-07 20:18:46', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:18:46', '2022-11-07 18:18:46'),
(10, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'ASAsaS', 'Message from technical support', 'ASAsaS', '2022-11-07 20:19:30', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:19:30', '2022-11-07 18:19:30'),
(11, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'asasASAss', 'Message from technical support', 'asasASAss', '2022-11-07 20:28:55', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:28:55', '2022-11-07 18:28:55'),
(12, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'qqqqqqqq', 'Message from technical support', 'qqqqqqqq', '2022-11-07 20:34:15', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 18:34:15', '2022-11-07 18:34:15'),
(13, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'uuuuuuuuuuuuuuuuuuuuuuuu', 'Message from technical support', 'uuuuuuuuuuuuuuuuuuuuuuuu', '2022-11-08 00:27:12', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:27:12', '2022-11-07 22:27:12'),
(14, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'jjjjjjjjjj', 'Message from technical support', 'jjjjjjjjjj', '2022-11-08 00:27:53', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:27:53', '2022-11-07 22:27:53'),
(15, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'ryyy', 'Message from technical support', 'ryyy', '2022-11-08 00:38:44', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:38:44', '2022-11-07 22:38:44'),
(16, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'aSAsaSas', 'Message from technical support', 'aSAsaSas', '2022-11-08 00:47:22', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:47:22', '2022-11-07 22:47:22'),
(17, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'asA', 'Message from technical support', 'asA', '2022-11-08 00:48:58', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:48:58', '2022-11-07 22:48:58'),
(18, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'ZZZZZZZZZZZZZZZZZZ', 'Message from technical support', 'ZZZZZZZZZZZZZZZZZZ', '2022-11-08 00:51:47', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:51:47', '2022-11-07 22:51:47'),
(19, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'SSSS', 'Message from technical support', 'SSSS', '2022-11-08 00:53:00', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 22:53:00', '2022-11-07 22:53:00'),
(20, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'ASDASDADA', 'Message from technical support', 'ASDASDADA', '2022-11-08 01:00:23', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 23:00:23', '2022-11-07 23:00:23'),
(21, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'رسالة من - superAdmin', 'WQEQWeee', 'Message from technical support', 'WQEQWeee', '2022-11-08 01:01:09', 'http://localhost:8000/dashboard/users/1', 0, '2022-11-07 23:01:09', '2022-11-07 23:01:09'),
(22, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'اتصال عايز يعرف اسعار الترابلولين', 'Message from technical support', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 01:27:14', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-08 23:27:14', '2022-11-08 23:27:14'),
(23, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'العمل بعت على الصفحة عايز يعرف اسعار مشروع', 'Message from technical support', 'العمل بعت على الصفحة عايز يعرف اسعار مشروع', '2022-11-09 01:45:33', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-08 23:45:33', '2022-11-08 23:45:33'),
(24, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'اتصال بيسال على عرض الاسعار', 'Message from technical support', 'اتصال بيسال على عرض الاسعار', '2022-11-09 01:46:06', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-08 23:46:06', '2022-11-08 23:46:06'),
(25, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'اتصال بيسال على عرض الاسعار', 'Message from technical support', 'اتصال بيسال على عرض الاسعار', '2022-11-09 01:47:46', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-08 23:47:46', '2022-11-08 23:47:46'),
(26, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة ملاحظة من عميل', 'asdasdasdsadsad', 'not has been added to user', 'asdasdasdsadsad', '2022-11-09 02:22:29', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-09 00:22:29', '2022-11-09 00:22:29'),
(27, 1, 4, 'الهام سالم', 'http://localhost:8000/storage/images/users/avatarfemale.png', 'تم اضافة ملاحظة من عميل', 'لا يوجد مالحظات', 'not has been added to user', 'لا يوجد مالحظات', '2022-11-09 02:33:34', 'http://localhost:8000/dashboard/users/2', 1, '2022-11-09 00:33:34', '2022-11-09 00:33:50'),
(28, 1, 4, 'الهام سالم', 'http://localhost:8000/storage/images/users/avatarfemale.png', 'تم اضافة ملاحظة من عميل', ';lk;l;k;lk;lkk;', 'not has been added to user', ';lk;l;k;lk;lkk;', '2022-11-09 02:36:12', 'http://localhost:8000/dashboard/users/2', 1, '2022-11-09 00:36:12', '2022-11-28 15:31:08'),
(29, 1, 4, 'الهام سالم', 'http://localhost:8000/storage/images/users/avatarfemale.png', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان', 'صببصب', 'not has been added to user - اسلام محمد علي شعبان', 'صببصب', '2022-11-09 02:37:32', 'http://localhost:8000/dashboard/users/2', 1, '2022-11-09 00:37:32', '2022-11-09 00:37:39'),
(30, 5, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'اتصال عايز يعرف اسعار الترابلولين', 'Message from technical support', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 02:59:47', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-09 00:59:47', '2022-11-09 00:59:47'),
(31, 5, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'العمل بعت على الصفحة عايز يعرف اسعار مشروع', 'Message from technical support', 'العمل بعت على الصفحة عايز يعرف اسعار مشروع', '2022-11-09 03:00:16', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-09 01:00:16', '2022-11-09 01:00:16'),
(32, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة استفسار من عميل', 'اتصال بيسال على عرض الاسعار', 'Message from technical support', 'اتصال بيسال على عرض الاسعار', '2022-11-09 03:00:48', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-09 01:00:48', '2022-11-09 01:00:48'),
(33, 4, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان', 'ملاحظة تجريبية', 'not has been added to user - اسلام محمد علي شعبان', 'ملاحظة تجريبية', '2022-11-09 03:06:59', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-09 01:06:59', '2022-11-09 01:06:59'),
(34, 5, 1, 'superAdmin', 'http://localhost:8000/storage/images/users/avatarmale.png', 'تم اضافة ملاحظة لعميل - اسلام محمد علي شعبان', 'بسم الله الرحمن الرحيم .. ارجو مراجعة الملاحظات لو سمحتم', 'not has been added to user - اسلام محمد علي شعبان', 'بسم الله الرحمن الرحيم .. ارجو مراجعة الملاحظات لو سمحتم', '2022-11-09 03:07:14', 'http://localhost:8000/dashboard/users/2', 0, '2022-11-09 01:07:14', '2022-11-09 01:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_mark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `total_commission` double(8,2) NOT NULL,
  `total_profit` double(8,2) NOT NULL,
  `shipping` double(8,2) NOT NULL,
  `shipping_rate_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_histories`
--

CREATE TABLE `order_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE `order_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `selling_price` double(8,2) NOT NULL,
  `commission_per_item` double(8,2) NOT NULL,
  `profit_per_item` double(8,2) NOT NULL,
  `vendor_price` double(8,2) NOT NULL,
  `total_selling_price` double(8,2) NOT NULL,
  `total_commission` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'users-create', 'Create Users', 'Create Users', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(2, 'users-read', 'Read Users', 'Read Users', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(3, 'users-update', 'Update Users', 'Update Users', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(4, 'users-delete', 'Delete Users', 'Delete Users', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(5, 'users-trash', 'Trash Users', 'Trash Users', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(6, 'users-restore', 'Restore Users', 'Restore Users', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(7, 'clients-create', 'Create Clients', 'Create Clients', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(8, 'clients-read', 'Read Clients', 'Read Clients', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(9, 'clients-update', 'Update Clients', 'Update Clients', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(10, 'clients-delete', 'Delete Clients', 'Delete Clients', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(11, 'clients-trash', 'Trash Clients', 'Trash Clients', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(12, 'clients-restore', 'Restore Clients', 'Restore Clients', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(13, 'queries-create', 'Create Queries', 'Create Queries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(14, 'queries-read', 'Read Queries', 'Read Queries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(15, 'queries-update', 'Update Queries', 'Update Queries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(16, 'queries-delete', 'Delete Queries', 'Delete Queries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(17, 'queries-trash', 'Trash Queries', 'Trash Queries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(18, 'queries-restore', 'Restore Queries', 'Restore Queries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(19, 'roles-create', 'Create Roles', 'Create Roles', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(20, 'roles-read', 'Read Roles', 'Read Roles', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(21, 'roles-update', 'Update Roles', 'Update Roles', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(22, 'roles-delete', 'Delete Roles', 'Delete Roles', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(23, 'roles-trash', 'Trash Roles', 'Trash Roles', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(24, 'roles-restore', 'Restore Roles', 'Restore Roles', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(25, 'settings-create', 'Create Settings', 'Create Settings', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(26, 'settings-read', 'Read Settings', 'Read Settings', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(27, 'settings-update', 'Update Settings', 'Update Settings', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(28, 'settings-delete', 'Delete Settings', 'Delete Settings', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(29, 'settings-trash', 'Trash Settings', 'Trash Settings', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(30, 'settings-restore', 'Restore Settings', 'Restore Settings', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(31, 'countries-create', 'Create Countries', 'Create Countries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(32, 'countries-read', 'Read Countries', 'Read Countries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(33, 'countries-update', 'Update Countries', 'Update Countries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(34, 'countries-delete', 'Delete Countries', 'Delete Countries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(35, 'countries-trash', 'Trash Countries', 'Trash Countries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(36, 'countries-restore', 'Restore Countries', 'Restore Countries', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(37, 'categories-create', 'Create Categories', 'Create Categories', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(38, 'categories-read', 'Read Categories', 'Read Categories', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(39, 'categories-update', 'Update Categories', 'Update Categories', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(40, 'categories-delete', 'Delete Categories', 'Delete Categories', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(41, 'categories-trash', 'Trash Categories', 'Trash Categories', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(42, 'categories-restore', 'Restore Categories', 'Restore Categories', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(43, 'products-create', 'Create Products', 'Create Products', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(44, 'products-read', 'Read Products', 'Read Products', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(45, 'products-update', 'Update Products', 'Update Products', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(46, 'products-delete', 'Delete Products', 'Delete Products', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(47, 'products-trash', 'Trash Products', 'Trash Products', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(48, 'products-restore', 'Restore Products', 'Restore Products', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(49, 'orders-create', 'Create Orders', 'Create Orders', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(50, 'orders-read', 'Read Orders', 'Read Orders', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(51, 'orders-update', 'Update Orders', 'Update Orders', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(52, 'orders-delete', 'Delete Orders', 'Delete Orders', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(53, 'orders-trash', 'Trash Orders', 'Trash Orders', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(54, 'orders-restore', 'Restore Orders', 'Restore Orders', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(55, 'reports-create', 'Create Reports', 'Create Reports', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(56, 'reports-read', 'Read Reports', 'Read Reports', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(57, 'reports-update', 'Update Reports', 'Update Reports', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(58, 'reports-delete', 'Delete Reports', 'Delete Reports', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(59, 'reports-trash', 'Trash Reports', 'Trash Reports', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(60, 'reports-restore', 'Restore Reports', 'Restore Reports', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(61, 'finances-create', 'Create Finances', 'Create Finances', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(62, 'finances-read', 'Read Finances', 'Read Finances', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(63, 'finances-update', 'Update Finances', 'Update Finances', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(64, 'finances-delete', 'Delete Finances', 'Delete Finances', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(65, 'finances-trash', 'Trash Finances', 'Trash Finances', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(66, 'finances-restore', 'Restore Finances', 'Restore Finances', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(67, 'notifications-create', 'Create Notifications', 'Create Notifications', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(68, 'notifications-read', 'Read Notifications', 'Read Notifications', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(69, 'notifications-update', 'Update Notifications', 'Update Notifications', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(70, 'notifications-delete', 'Delete Notifications', 'Delete Notifications', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(71, 'notifications-trash', 'Trash Notifications', 'Trash Notifications', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(72, 'notifications-restore', 'Restore Notifications', 'Restore Notifications', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(73, 'shipping_rates-create', 'Create Shipping_rates', 'Create Shipping_rates', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(74, 'shipping_rates-read', 'Read Shipping_rates', 'Read Shipping_rates', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(75, 'shipping_rates-update', 'Update Shipping_rates', 'Update Shipping_rates', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(76, 'shipping_rates-delete', 'Delete Shipping_rates', 'Delete Shipping_rates', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(77, 'shipping_rates-trash', 'Trash Shipping_rates', 'Trash Shipping_rates', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(78, 'shipping_rates-restore', 'Restore Shipping_rates', 'Restore Shipping_rates', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(79, 'colors-create', 'Create Colors', 'Create Colors', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(80, 'colors-read', 'Read Colors', 'Read Colors', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(81, 'colors-update', 'Update Colors', 'Update Colors', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(82, 'colors-delete', 'Delete Colors', 'Delete Colors', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(83, 'colors-trash', 'Trash Colors', 'Trash Colors', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(84, 'colors-restore', 'Restore Colors', 'Restore Colors', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(85, 'sizes-create', 'Create Sizes', 'Create Sizes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(86, 'sizes-read', 'Read Sizes', 'Read Sizes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(87, 'sizes-update', 'Update Sizes', 'Update Sizes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(88, 'sizes-delete', 'Delete Sizes', 'Delete Sizes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(89, 'sizes-trash', 'Trash Sizes', 'Trash Sizes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(90, 'sizes-restore', 'Restore Sizes', 'Restore Sizes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(91, 'withdrawals-create', 'Create Withdrawals', 'Create Withdrawals', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(92, 'withdrawals-read', 'Read Withdrawals', 'Read Withdrawals', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(93, 'withdrawals-update', 'Update Withdrawals', 'Update Withdrawals', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(94, 'withdrawals-delete', 'Delete Withdrawals', 'Delete Withdrawals', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(95, 'withdrawals-trash', 'Trash Withdrawals', 'Trash Withdrawals', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(96, 'withdrawals-restore', 'Restore Withdrawals', 'Restore Withdrawals', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(97, 'notes-create', 'Create Notes', 'Create Notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(98, 'notes-read', 'Read Notes', 'Read Notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(99, 'notes-update', 'Update Notes', 'Update Notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(100, 'notes-delete', 'Delete Notes', 'Delete Notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(101, 'notes-trash', 'Trash Notes', 'Trash Notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(102, 'notes-restore', 'Restore Notes', 'Restore Notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(103, 'messages-create', 'Create Messages', 'Create Messages', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(104, 'messages-read', 'Read Messages', 'Read Messages', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(105, 'messages-update', 'Update Messages', 'Update Messages', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(106, 'messages-delete', 'Delete Messages', 'Delete Messages', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(107, 'messages-trash', 'Trash Messages', 'Trash Messages', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(108, 'messages-restore', 'Restore Messages', 'Restore Messages', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(109, 'slides-create', 'Create Slides', 'Create Slides', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(110, 'slides-read', 'Read Slides', 'Read Slides', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(111, 'slides-update', 'Update Slides', 'Update Slides', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(112, 'slides-delete', 'Delete Slides', 'Delete Slides', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(113, 'slides-trash', 'Trash Slides', 'Trash Slides', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(114, 'slides-restore', 'Restore Slides', 'Restore Slides', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(115, 'orders_notes-create', 'Create Orders_notes', 'Create Orders_notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(116, 'orders_notes-read', 'Read Orders_notes', 'Read Orders_notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(117, 'orders_notes-update', 'Update Orders_notes', 'Update Orders_notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(118, 'orders_notes-delete', 'Delete Orders_notes', 'Delete Orders_notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(119, 'orders_notes-trash', 'Trash Orders_notes', 'Trash Orders_notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(120, 'orders_notes-restore', 'Restore Orders_notes', 'Restore Orders_notes', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(121, 'logs-create', 'Create Logs', 'Create Logs', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(122, 'logs-read', 'Read Logs', 'Read Logs', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(123, 'logs-update', 'Update Logs', 'Update Logs', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(124, 'logs-delete', 'Delete Logs', 'Delete Logs', '2022-11-07 15:13:50', '2022-11-07 15:13:50'),
(125, 'logs-trash', 'Trash Logs', 'Trash Logs', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(126, 'logs-restore', 'Restore Logs', 'Restore Logs', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(127, 'bonus-create', 'Create Bonus', 'Create Bonus', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(128, 'bonus-read', 'Read Bonus', 'Read Bonus', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(129, 'bonus-update', 'Update Bonus', 'Update Bonus', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(130, 'bonus-delete', 'Delete Bonus', 'Delete Bonus', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(131, 'bonus-trash', 'Trash Bonus', 'Trash Bonus', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(132, 'bonus-restore', 'Restore Bonus', 'Restore Bonus', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(133, 'stock_management-create', 'Create Stock_management', 'Create Stock_management', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(134, 'stock_management-read', 'Read Stock_management', 'Read Stock_management', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(135, 'stock_management-update', 'Update Stock_management', 'Update Stock_management', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(136, 'stock_management-delete', 'Delete Stock_management', 'Delete Stock_management', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(137, 'stock_management-trash', 'Trash Stock_management', 'Trash Stock_management', '2022-11-07 15:13:51', '2022-11-07 15:13:51'),
(138, 'stock_management-restore', 'Restore Stock_management', 'Restore Stock_management', '2022-11-07 15:13:51', '2022-11-07 15:13:51');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 4),
(1, 5),
(2, 1),
(2, 4),
(2, 5),
(3, 1),
(3, 4),
(3, 5),
(4, 1),
(4, 4),
(4, 5),
(5, 1),
(5, 4),
(5, 5),
(6, 1),
(6, 4),
(6, 5),
(7, 1),
(7, 4),
(7, 5),
(8, 1),
(8, 4),
(8, 5),
(9, 1),
(9, 4),
(9, 5),
(10, 1),
(10, 4),
(10, 5),
(11, 1),
(11, 4),
(11, 5),
(12, 1),
(12, 4),
(12, 5),
(13, 1),
(13, 4),
(13, 5),
(14, 1),
(14, 4),
(14, 5),
(15, 1),
(15, 4),
(15, 5),
(16, 1),
(16, 4),
(16, 5),
(17, 1),
(17, 4),
(17, 5),
(18, 1),
(18, 4),
(18, 5),
(19, 1),
(19, 4),
(20, 1),
(20, 4),
(21, 1),
(21, 4),
(22, 1),
(22, 4),
(23, 1),
(23, 4),
(24, 1),
(24, 4),
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
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(97, 4),
(98, 1),
(98, 4),
(99, 1),
(99, 4),
(100, 1),
(100, 4),
(101, 1),
(101, 4),
(102, 1),
(102, 4),
(103, 1),
(103, 4),
(103, 5),
(104, 1),
(104, 4),
(104, 5),
(105, 1),
(105, 4),
(105, 5),
(106, 1),
(106, 4),
(106, 5),
(107, 1),
(107, 4),
(107, 5),
(108, 1),
(108, 4),
(108, 5),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(121, 4),
(121, 5),
(122, 1),
(122, 4),
(122, 5),
(123, 1),
(123, 4),
(123, 5),
(124, 1),
(124, 4),
(124, 5),
(125, 1),
(125, 4),
(125, 5),
(126, 1),
(126, 4),
(126, 5),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `country_id` int(11) NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_price` double(8,2) NOT NULL DEFAULT 0.00,
  `max_price` double(8,2) NOT NULL DEFAULT 0.00,
  `extra_fee` double(8,2) NOT NULL DEFAULT 0.00,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `total_profit` double(8,2) NOT NULL DEFAULT 0.00,
  `unlimited` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_vendor_order`
--

CREATE TABLE `product_vendor_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` int(11) NOT NULL,
  `vendor_order_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `vendor_price` double NOT NULL,
  `total_vendor_price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `size_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `query_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `user_id`, `admin_id`, `query_type`, `query`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'Email', 'اتصال عايز يعرف اسعار الترابلولين1121211222121', '2022-11-08 23:27:14', '2022-11-09 00:21:09', NULL),
(2, 2, 1, 'Instagram', 'العمل بعت على الصفحة عايز يعرف اسعار مشروعtttttttttttttttttttttttttttttttttttttttttt', '2022-11-08 23:45:33', '2022-11-09 00:21:24', NULL),
(3, 2, 1, 'Email', 'اتصال بيسال على عرض الاسعار', '2022-11-08 23:46:06', '2022-11-08 23:46:06', NULL),
(4, 2, 1, 'Customer service phone', 'اتصال بيسال على عرض الاسعار', '2022-11-08 23:47:46', '2022-11-09 00:15:40', '2022-11-09 00:15:40'),
(5, 2, 1, 'Hotline', 'fffffffffffffffffffffff', '2022-11-09 00:55:27', '2022-11-09 00:55:27', NULL),
(6, 2, 1, 'Email', 'العميل اتصل عايز حد يكلمة يشرحله مشروع منطقة الاعابل', '2022-11-09 00:55:46', '2022-11-09 00:55:46', NULL),
(7, 2, 1, 'Hotline', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:57:13', '2022-11-09 00:57:13', NULL),
(8, 2, 1, 'Customer service phone', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:57:28', '2022-11-09 00:57:28', NULL),
(9, 2, 1, 'Facebook', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:58:03', '2022-11-09 00:58:03', NULL),
(10, 2, 1, 'Facebook', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:58:23', '2022-11-09 00:58:23', NULL),
(11, 2, 1, 'Facebook', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:58:40', '2022-11-09 00:58:40', NULL),
(12, 2, 1, 'Website', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 00:59:47', '2022-11-09 00:59:47', NULL),
(13, 2, 1, 'Instagram', 'العمل بعت على الصفحة عايز يعرف اسعار مشروع', '2022-11-09 01:00:16', '2022-11-09 01:00:16', NULL),
(14, 2, 1, 'Facebook', 'اتصال بيسال على عرض الاسعار', '2022-11-09 01:00:48', '2022-11-09 01:00:48', NULL),
(15, 2, 1, 'Facebook', 'اتصال عايز يعرف اسعار الترابلولين', '2022-11-09 01:01:56', '2022-11-09 01:01:56', NULL),
(16, 3, 1, 'Hotline', 'jbjjjj', '2022-11-27 11:10:45', '2022-11-27 11:10:45', NULL),
(17, 3, 1, 'Hotline', 'يييييي', '2022-11-27 13:09:43', '2022-11-27 13:09:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refuse_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `request_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  `review` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'superadministrator', 'Superadministrator', 'Superadministrator', '2022-11-07 15:13:50', '2022-11-07 15:13:50', NULL),
(2, 'administrator', 'Administrator', 'Administrator', '2022-11-07 15:13:51', '2022-11-07 15:13:51', NULL),
(3, 'user', 'User', 'User', '2022-11-07 15:13:51', '2022-11-07 15:13:51', NULL),
(4, 'قسم المبيعات', NULL, 'قسم المبيعات', '2022-11-07 15:22:09', '2022-11-07 15:22:09', NULL),
(5, 'قسم خدمة العملاء', NULL, 'قسم خدمة العملاء', '2022-11-09 00:49:25', '2022-11-09 00:49:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\Models\\User'),
(3, 2, 'App\\Models\\User'),
(3, 3, 'App\\Models\\User'),
(2, 4, 'App\\Models\\User'),
(4, 4, 'App\\Models\\User'),
(2, 5, 'App\\Models\\User'),
(5, 5, 'App\\Models\\User');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slider_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `limit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_products`
--

CREATE TABLE `store_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` int(11) NOT NULL DEFAULT 0,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_price` double(8,2) NOT NULL,
  `product_price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ar',
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `country_id`, `phone`, `status`, `verification_code`, `phone_verified_at`, `gender`, `profile`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `lang`, `store_name`, `store_description`, `store_profile`, `store_cover`, `store_status`) VALUES
(1, 'superAdmin', 'admin@unitedtoys-eg.com', '1', '+201121184147', 0, NULL, '2021-10-25 20:43:41', 'male', 'avatarmale.png', NULL, '$2y$10$7b74dqCdS/v0HJe18PFF0OVm1sY1djhfvgyGHWVQ/.sKkIhfzWEHa', 'EvPBdp0KnLg14KHSvsy0i12T98BQCHoNjnItVMd1fM7qraVCaSszZ5qyZqEF', '2022-11-07 15:13:51', '2022-11-07 15:13:51', NULL, 'ar', NULL, NULL, NULL, NULL, 0),
(2, 'اسلام محمد علي شعبان', '+201121184148@unitedtoys-eg.com', '1', '+201121184148', 0, NULL, NULL, 'male', 'avatarmale.png', NULL, '$2y$10$z94Tdrl5HiACnaAnZSmlGONvaAjbUOPulstACZJuvV/hbu7K5IbmS', NULL, '2022-11-07 15:13:57', '2022-11-07 15:13:57', NULL, 'ar', NULL, NULL, NULL, NULL, 0),
(3, 'qweqwewqewq', '+203232132121@unitedtoys-eg.com', '1', '+203232132121', 0, NULL, NULL, 'male', 'avatarmale.png', NULL, '$2y$10$uXcbJDXf6jCHj8MjRYfpGurHmuKLmZyZ.ZRvlIyVgvRIn9y4gCRYa', NULL, '2022-11-07 15:18:32', '2022-11-07 15:18:32', NULL, 'ar', NULL, NULL, NULL, NULL, 0),
(4, 'الهام سالم', 'elham@unitedtoys-eg.com', '1', '+20123456789', 0, NULL, '2022-11-07 17:43:46', 'female', 'avatarfemale.png', NULL, '$2y$10$m.zEEelybnM3VdewKuoZueAEq2BDhq6g/LpiyBIoqYspzckDZ5Qrq', 'A9tK4GLiHGdulhY5jwcl1Ka4nwfpwaDt3A1kEuCyN5sSu5TUQVYDg3EZNnaX', '2022-11-07 15:28:07', '2022-11-07 17:43:46', NULL, 'ar', NULL, NULL, NULL, NULL, 0),
(5, 'islam', 'idlsm@isuius.com', '1', '+201234567899', 0, NULL, '2022-11-09 00:50:30', 'male', 'avatarmale.png', NULL, '$2y$10$.EgRZ/8PigwqFzi3vND9cOwUDw4BYkTT.3jXD09ZBR3nMnBhUME/a', 'olcMtNHJD4jA0gvp8iNkKjJZy2soQ8OwU0jRfDFDksMdnWrpaGc5bdGJMMvj', '2022-11-09 00:50:16', '2022-11-09 00:50:30', NULL, 'ar', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_orders`
--

CREATE TABLE `vendor_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate_stocks`
--
ALTER TABLE `affiliate_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonuses`
--
ALTER TABLE `bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_phone_unique` (`phone`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_vendor_order`
--
ALTER TABLE `product_vendor_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_products`
--
ALTER TABLE `store_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_verification_code_unique` (`verification_code`);

--
-- Indexes for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_stocks`
--
ALTER TABLE `affiliate_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bonuses`
--
ALTER TABLE `bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_histories`
--
ALTER TABLE `order_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_notes`
--
ALTER TABLE `order_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_vendor_order`
--
ALTER TABLE `product_vendor_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_products`
--
ALTER TABLE `store_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
