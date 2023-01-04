-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2022 at 03:39 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 for active & 0 for inactive',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('customer','supplier','simple_product','variable_product','tax','shipping','couponcode','discount','sale','income') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `code`, `account_type`, `status`, `parent_id`, `reference_id`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'ASSETS', '01', 'Assets', 1, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'CASH', '0101', 'Assets', 1, 1, NULL, NULL, NULL, NULL, NULL),
(3, 'BANK', '0102', 'Assets', 1, 1, NULL, NULL, NULL, NULL, NULL),
(4, 'PAYPAL', '0103', 'Assets', 1, 1, NULL, NULL, NULL, NULL, NULL),
(5, 'STRIPE', '0104', 'Assets', 1, 1, NULL, NULL, NULL, NULL, NULL),
(6, 'SUPPLIES', '0105', 'Assets', 1, 1, NULL, NULL, NULL, NULL, NULL),
(7, 'ACCOUNT RECIEVEABLE', '0106', 'Assets', 1, 1, NULL, NULL, NULL, NULL, NULL),
(8, 'CUSTOMER', '010601', 'Assets', 1, 7, NULL, NULL, NULL, NULL, NULL),
(9, 'LIABILITY', '02', 'Liability', 1, 0, NULL, NULL, NULL, NULL, NULL),
(10, 'ACCOUNT PAYABLE', '0201', 'Liability', 1, 9, NULL, NULL, NULL, NULL, NULL),
(11, 'VENDOR', '020101', 'Liability', 1, 10, NULL, NULL, NULL, NULL, NULL),
(12, 'EXPENSE', '03', 'Expense', 1, 0, NULL, NULL, NULL, NULL, NULL),
(13, 'COST OF PURCHASE', '0301', 'Expense', 1, 12, NULL, NULL, NULL, NULL, NULL),
(14, 'income', '04', 'income', 1, 14, 14, 'income', NULL, NULL, NULL),
(15, 'GST', '020102', 'Liability', 1, 10, 1, 'tax', NULL, '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(16, 'Item 1 (Black-XL)', '010501', 'Assets', 1, 6, 1, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(17, 'Item 1 (Black-XXL)', '010502', 'Assets', 1, 6, 2, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(18, 'Item 1 (Black-M)', '010503', 'Assets', 1, 6, 3, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(19, 'Item 1 (red-XL)', '010504', 'Assets', 1, 6, 4, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(20, 'Item 1 (red-XXL)', '010505', 'Assets', 1, 6, 5, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(21, 'Item 1 (red-M)', '010506', 'Assets', 1, 6, 6, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(22, 'Item 1 (blue-XL)', '010507', 'Assets', 1, 6, 7, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(23, 'Item 1 (blue-XXL)', '010508', 'Assets', 1, 6, 8, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30'),
(24, 'Item 1 (blue-M)', '010509', 'Assets', 1, 6, 9, 'variable_product', NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '2022-12-17 20:43:29', '2022-12-17 20:43:29'),
(2, 1, NULL, NULL, '2022-12-17 20:43:35', '2022-12-17 20:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_detail`
--

CREATE TABLE `attribute_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_detail`
--

INSERT INTO `attribute_detail` (`id`, `attribute_id`, `language_id`, `name`) VALUES
(1, 1, 1, 'Colors'),
(2, 2, 1, 'Sizes');

-- --------------------------------------------------------

--
-- Stand-in structure for view `avaliable_qty`
-- (See below for the actual view)
--
CREATE TABLE `avaliable_qty` (
`product_id` bigint(20) unsigned
,`product_combination_id` bigint(20) unsigned
,`warehouse_id` bigint(20) unsigned
,`stock_in` decimal(32,0)
,`stock_out` decimal(32,0)
,`remaining` decimal(33,0)
,`product_type` enum('simple','variable','digital')
,`price` double(8,2)
,`discount_price` varchar(8)
);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_navigation_id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `description`, `slider_navigation_id`, `gallary_id`, `language_id`, `ref_id`, `url`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Some Title', 'Some Description', 1, 2, 1, 1, NULL, 'active', NULL, NULL, NULL, NULL, NULL),
(2, 'Some Title', 'Some Description', 1, 2, 1, 1, NULL, 'active', NULL, NULL, NULL, NULL, NULL),
(3, 'Some Title', 'Some Description', 2, 2, 1, 1, NULL, 'active', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bar_code_settings`
--

CREATE TABLE `bar_code_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `continous_feed_or_rolls` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_top_margin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height_of_sticker` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width_of_sticker` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_width` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_height` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stickers_in_one_row` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance_between_two_rows` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance_between_two_columns` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_stickers_per_sheet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billers`
--

CREATE TABLE `billers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `blog_category_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `gallary_id`, `blog_category_slug`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 32, 'blogcat1', 'active', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_detail`
--

CREATE TABLE `blog_category_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_news`
--

CREATE TABLE `blog_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `blog_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_featured` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for not featured & 1 for featured',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_news_detail`
--

CREATE TABLE `blog_news_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_news_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_setting`
--

CREATE TABLE `business_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL,
  `timezone_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `default_profit_percentage` double(8,2) NOT NULL,
  `year_start_month` enum('January','February','March','April','May','June','July','August','September','October','November','December') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'January',
  `accounting_method` enum('FIFO','LIFO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FIFO',
  `transaction_edit_days` int(11) NOT NULL,
  `date_format` enum('mm/dd/yyyy','mm-dd-yyyy','dd-mm-yyyy','dd/mm/yyyy') COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_format` enum('12 hr','24 hr') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `is_order` tinyint(1) NOT NULL DEFAULT 0,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `product_id`, `warehouse_id`, `product_combination_id`, `customer_id`, `qty`, `is_order`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 0, '', '2022-12-17 22:02:23', '2022-12-17 22:02:23'),
(2, 1, 1, 3, 1, 5, 0, '', '2022-12-17 22:13:45', '2022-12-17 22:16:22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `category_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `gallary_id`, `category_icon`, `parent_id`, `category_slug`, `sort_order`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '1', NULL, 'clothes', NULL, 1, NULL, NULL, '2022-12-17 20:27:38', '2022-12-17 20:27:38'),
(2, 1, '1', 1, 'women clothes', NULL, 1, 1, NULL, '2022-12-17 20:34:00', '2022-12-17 20:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `category_detail`
--

CREATE TABLE `category_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_detail`
--

INSERT INTO `category_detail` (`id`, `category_name`, `description`, `category_id`, `language_id`) VALUES
(1, 'clothes', '<p>clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes clothes </p>', 1, 1),
(2, 'women clothes', '<p>women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;women clothes&nbsp;</p>', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compares`
--

CREATE TABLE `compares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `constant_banners`
--

CREATE TABLE `constant_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `constant_banners`
--

INSERT INTO `constant_banners` (`id`, `title`, `url`, `banner_number`, `status`, `language_id`, `gallary_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'banner1', '/shop', '1', 'active', 1, 11, 1, NULL, NULL, NULL),
(2, 'banner1', '/shop', '2', 'active', 1, 11, 1, NULL, NULL, NULL),
(3, 'banner1', '/shop', '3', 'active', 1, 11, 1, NULL, NULL, NULL),
(4, 'banner1', '/shop', '1', 'active', 2, 11, 1, NULL, NULL, NULL),
(5, 'banner1', '/shop', '2', 'active', 2, 11, 1, NULL, NULL, NULL),
(6, 'banner1', '/shop', '3', 'active', 2, 11, 1, NULL, NULL, NULL),
(7, 'banner2', '/shop', '1', 'active', 1, 23, 1, NULL, NULL, NULL),
(8, 'banner2', '/shop', '2', 'active', 1, 22, 1, NULL, NULL, NULL),
(9, 'banner2', '/shop', '3', 'active', 1, 8, 1, NULL, NULL, NULL),
(10, 'banner2', '/shop', '4', 'active', 1, 8, 1, NULL, NULL, NULL),
(11, 'banner2', '/shop', '1', 'active', 2, 23, 1, NULL, NULL, NULL),
(12, 'banner2', '/shop', '2', 'active', 2, 22, 1, NULL, NULL, NULL),
(13, 'banner2', '/shop', '3', 'active', 2, 8, 1, NULL, NULL, NULL),
(14, 'banner2', '/shop', '4', 'active', 2, 8, 1, NULL, NULL, NULL),
(15, 'banner5', '/shop', '1', 'active', 1, 24, 1, NULL, NULL, NULL),
(16, 'banner5', '/shop', '2', 'active', 1, 24, 1, NULL, NULL, NULL),
(17, 'banner5', '/shop', '3', 'active', 1, 24, 1, NULL, NULL, NULL),
(18, 'banner5', '/shop', '4', 'active', 1, 24, 1, NULL, NULL, NULL),
(19, 'banner5', '/shop', '5', 'active', 1, 19, 1, NULL, NULL, NULL),
(20, 'banner5', '/shop', '1', 'active', 2, 24, 1, NULL, NULL, NULL),
(21, 'banner5', '/shop', '2', 'active', 2, 24, 1, NULL, NULL, NULL),
(22, 'banner5', '/shop', '3', 'active', 2, 24, 1, NULL, NULL, NULL),
(23, 'banner5', '/shop', '4', 'active', 2, 24, 1, NULL, NULL, NULL),
(24, 'banner5', '/shop', '5', 'active', 2, 19, 1, NULL, NULL, NULL),
(25, 'banner7', '/shop', '1', 'active', 1, 25, 1, NULL, NULL, NULL),
(26, 'banner7', '/shop', '2', 'active', 1, 27, 1, NULL, NULL, NULL),
(27, 'banner7', '/shop', '3', 'active', 1, 27, 1, NULL, NULL, NULL),
(28, 'banner7', '/shop', '4', 'active', 1, 26, 1, NULL, NULL, NULL),
(29, 'banner7', '/shop', '1', 'active', 2, 25, 1, NULL, NULL, NULL),
(30, 'banner7', '/shop', '2', 'active', 2, 27, 1, NULL, NULL, NULL),
(31, 'banner7', '/shop', '3', 'active', 2, 27, 1, NULL, NULL, NULL),
(32, 'banner7', '/shop', '4', 'active', 2, 26, 1, NULL, NULL, NULL),
(33, 'banner9', '/shop', '1', 'active', 1, 16, 1, NULL, NULL, NULL),
(34, 'banner9', '/shop', '2', 'active', 1, 16, 1, NULL, NULL, NULL),
(35, 'banner9', '/shop', '1', 'active', 2, 16, 1, NULL, NULL, NULL),
(36, 'banner9', '/shop', '2', 'active', 2, 16, 1, NULL, NULL, NULL),
(37, 'banner10', '/shop', '1', 'active', 1, 25, 1, NULL, NULL, NULL),
(38, 'banner10', '/shop', '2', 'active', 1, 27, 1, NULL, NULL, NULL),
(39, 'banner10', '/shop', '3', 'active', 1, 27, 1, NULL, NULL, NULL),
(40, 'banner10', '/shop', '4', 'active', 1, 28, 1, NULL, NULL, NULL),
(41, 'banner10', '/shop', '1', 'active', 2, 25, 1, NULL, NULL, NULL),
(42, 'banner10', '/shop', '2', 'active', 2, 27, 1, NULL, NULL, NULL),
(43, 'banner10', '/shop', '3', 'active', 2, 27, 1, NULL, NULL, NULL),
(44, 'banner10', '/shop', '4', 'active', 2, 28, 1, NULL, NULL, NULL),
(45, 'banner13', '/shop', '1', 'active', 1, 29, 1, NULL, NULL, NULL),
(46, 'banner13', '/shop', '2', 'active', 1, 10, 1, NULL, NULL, NULL),
(47, 'banner13', '/shop', '3', 'active', 1, 10, 1, NULL, NULL, NULL),
(48, 'banner13', '/shop', '4', 'active', 1, 10, 1, NULL, NULL, NULL),
(49, 'banner13', '/shop', '5', 'active', 1, 10, 1, NULL, NULL, NULL),
(50, 'banner13', '/shop', '1', 'active', 2, 29, 1, NULL, NULL, NULL),
(51, 'banner13', '/shop', '2', 'active', 2, 10, 1, NULL, NULL, NULL),
(52, 'banner13', '/shop', '3', 'active', 2, 10, 1, NULL, NULL, NULL),
(53, 'banner13', '/shop', '4', 'active', 2, 10, 1, NULL, NULL, NULL),
(54, 'banner13', '/shop', '5', 'active', 2, 10, 1, NULL, NULL, NULL),
(55, 'banner16', '/shop', '1', 'active', 1, 30, 1, NULL, NULL, NULL),
(56, 'banner16', '/shop', '2', 'active', 1, 30, 1, NULL, NULL, NULL),
(57, 'banner16', '/shop', '3', 'active', 1, 22, 1, NULL, NULL, NULL),
(58, 'banner16', '/shop', '1', 'active', 2, 30, 1, NULL, NULL, NULL),
(59, 'banner16', '/shop', '2', 'active', 2, 30, 1, NULL, NULL, NULL),
(60, 'banner16', '/shop', '3', 'active', 2, 22, 1, NULL, NULL, NULL),
(61, 'banner18', '/shop', '1', 'active', 1, 15, 1, NULL, NULL, NULL),
(62, 'banner18', '/shop', '2', 'active', 1, 27, 1, NULL, NULL, NULL),
(63, 'banner18', '/shop', '3', 'active', 1, 7, 1, NULL, NULL, NULL),
(64, 'banner18', '/shop', '4', 'active', 1, 15, 1, NULL, NULL, NULL),
(65, 'banner18', '/shop', '5', 'active', 1, 27, 1, NULL, NULL, NULL),
(66, 'banner18', '/shop', '6', 'active', 1, 7, 1, NULL, NULL, NULL),
(67, 'banner18', '/shop', '1', 'active', 2, 15, 1, NULL, NULL, NULL),
(68, 'banner18', '/shop', '2', 'active', 2, 27, 1, NULL, NULL, NULL),
(69, 'banner18', '/shop', '3', 'active', 2, 7, 1, NULL, NULL, NULL),
(70, 'banner18', '/shop', '4', 'active', 2, 15, 1, NULL, NULL, NULL),
(71, 'banner18', '/shop', '5', 'active', 2, 27, 1, NULL, NULL, NULL),
(72, 'banner18', '/shop', '6', 'active', 2, 7, 1, NULL, NULL, NULL),
(73, 'rightsliderbanner', '/shop', '1', 'active', 1, 31, 1, NULL, NULL, NULL),
(74, 'rightsliderbanner', '/shop', '2', 'active', 1, 31, 1, NULL, NULL, NULL),
(75, 'rightsliderbanner', '/shop', '1', 'active', 2, 31, 1, NULL, NULL, NULL),
(76, 'rightsliderbanner', '/shop', '2', 'active', 2, 31, 1, NULL, NULL, NULL),
(77, 'leftsliderbanner', '/shop', '1', 'active', 1, 31, 1, NULL, NULL, NULL),
(78, 'leftsliderbanner', '/shop', '2', 'active', 1, 31, 1, NULL, NULL, NULL),
(79, 'leftsliderbanner', '/shop', '1', 'active', 2, 31, 1, NULL, NULL, NULL),
(80, 'leftsliderbanner', '/shop', '2', 'active', 2, 31, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_code_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_format_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `address_format_id`, `country_code`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '1', '93', 'inactive', NULL, NULL, '2022-12-17 21:08:04'),
(2, 'Aland Islands', 'AX', 'ALA', '1', '+358-18', 'inactive', NULL, NULL, '2022-12-17 21:08:05'),
(3, 'Albania', 'AL', 'ALB', '1', '355', 'inactive', NULL, NULL, NULL),
(4, 'Algeria', 'DZ', 'DZA', '1', '213', 'inactive', NULL, NULL, NULL),
(5, 'American Samoa', 'AS', 'ASM', '1', '+1-684', 'inactive', NULL, NULL, NULL),
(6, 'Andorra', 'AD', 'AND', '1', '376', 'inactive', NULL, NULL, NULL),
(7, 'Angola', 'AO', 'AGO', '1', '244', 'inactive', NULL, NULL, NULL),
(8, 'Anguilla', 'AI', 'AIA', '1', '+1-264', 'inactive', NULL, NULL, NULL),
(9, 'Antarctica', 'AQ', 'ATA', '1', '', 'inactive', NULL, NULL, NULL),
(10, 'Antigua And Barbuda', 'AG', 'ATG', '1', '+1-268', 'inactive', NULL, NULL, NULL),
(11, 'Argentina', 'AR', 'ARG', '1', '54', 'inactive', NULL, NULL, NULL),
(12, 'Armenia', 'AM', 'ARM', '1', '374', 'inactive', NULL, NULL, NULL),
(13, 'Aruba', 'AW', 'ABW', '1', '297', 'inactive', NULL, NULL, NULL),
(14, 'Australia', 'AU', 'AUS', '1', '61', 'inactive', NULL, NULL, NULL),
(15, 'Austria', 'AT', 'AUT', '1', '43', 'inactive', NULL, NULL, NULL),
(16, 'Azerbaijan', 'AZ', 'AZE', '1', '994', 'inactive', NULL, NULL, NULL),
(17, 'Bahamas The', 'BS', 'BHS', '1', '+1-242', 'inactive', NULL, NULL, NULL),
(18, 'Bahrain', 'BH', 'BHR', '1', '973', 'inactive', NULL, NULL, NULL),
(19, 'Bangladesh', 'BD', 'BGD', '1', '880', 'inactive', NULL, NULL, NULL),
(20, 'Barbados', 'BB', 'BRB', '1', '+1-246', 'inactive', NULL, NULL, NULL),
(21, 'Belarus', 'BY', 'BLR', '1', '375', 'inactive', NULL, NULL, NULL),
(22, 'Belgium', 'BE', 'BEL', '1', '32', 'inactive', NULL, NULL, NULL),
(23, 'Belize', 'BZ', 'BLZ', '1', '501', 'inactive', NULL, NULL, NULL),
(24, 'Benin', 'BJ', 'BEN', '1', '229', 'inactive', NULL, NULL, NULL),
(25, 'Bermuda', 'BM', 'BMU', '1', '+1-441', 'inactive', NULL, NULL, NULL),
(26, 'Bhutan', 'BT', 'BTN', '1', '975', 'inactive', NULL, NULL, NULL),
(27, 'Bolivia', 'BO', 'BOL', '1', '591', 'inactive', NULL, NULL, NULL),
(28, 'Bosnia and Herzegovina', 'BA', 'BIH', '1', '387', 'inactive', NULL, NULL, NULL),
(29, 'Botswana', 'BW', 'BWA', '1', '267', 'inactive', NULL, NULL, NULL),
(30, 'Bouvet Island', 'BV', 'BVT', '1', '', 'inactive', NULL, NULL, NULL),
(31, 'Brazil', 'BR', 'BRA', '1', '55', 'inactive', NULL, NULL, NULL),
(32, 'British Indian Ocean Territory', 'IO', 'IOT', '1', '246', 'inactive', NULL, NULL, NULL),
(33, 'Brunei', 'BN', 'BRN', '1', '673', 'inactive', NULL, NULL, NULL),
(34, 'Bulgaria', 'BG', 'BGR', '1', '359', 'inactive', NULL, NULL, NULL),
(35, 'Burkina Faso', 'BF', 'BFA', '1', '226', 'inactive', NULL, NULL, NULL),
(36, 'Burundi', 'BI', 'BDI', '1', '257', 'inactive', NULL, NULL, NULL),
(37, 'Cambodia', 'KH', 'KHM', '1', '855', 'inactive', NULL, NULL, NULL),
(38, 'Cameroon', 'CM', 'CMR', '1', '237', 'inactive', NULL, NULL, NULL),
(39, 'Canada', 'CA', 'CAN', '1', '1', 'inactive', NULL, NULL, NULL),
(40, 'Cape Verde', 'CV', 'CPV', '1', '238', 'inactive', NULL, NULL, NULL),
(41, 'Cayman Islands', 'KY', 'CYM', '1', '+1-345', 'inactive', NULL, NULL, NULL),
(42, 'Central African Republic', 'CF', 'CAF', '1', '236', 'inactive', NULL, NULL, NULL),
(43, 'Chad', 'TD', 'TCD', '1', '235', 'inactive', NULL, NULL, NULL),
(44, 'Chile', 'CL', 'CHL', '1', '56', 'inactive', NULL, NULL, NULL),
(45, 'China', 'CN', 'CHN', '1', '86', 'inactive', NULL, NULL, NULL),
(46, 'Christmas Island', 'CX', 'CXR', '1', '61', 'inactive', NULL, NULL, NULL),
(47, 'Cocos (Keeling) Islands', 'CC', 'CCK', '1', '61', 'inactive', NULL, NULL, NULL),
(48, 'Colombia', 'CO', 'COL', '1', '57', 'inactive', NULL, NULL, NULL),
(49, 'Comoros', 'KM', 'COM', '1', '269', 'inactive', NULL, NULL, NULL),
(50, 'Congo', 'CG', 'COG', '1', '242', 'inactive', NULL, NULL, NULL),
(51, 'Congo The Democratic Republic Of The', 'CD', 'COD', '1', '243', 'inactive', NULL, NULL, NULL),
(52, 'Cook Islands', 'CK', 'COK', '1', '682', 'inactive', NULL, NULL, NULL),
(53, 'Costa Rica', 'CR', 'CRI', '1', '506', 'inactive', NULL, NULL, NULL),
(54, 'Cote D\'Ivoire (Ivory Coast)', 'CI', 'CIV', '1', '225', 'inactive', NULL, NULL, NULL),
(55, 'Croatia (Hrvatska)', 'HR', 'HRV', '1', '385', 'inactive', NULL, NULL, NULL),
(56, 'Cuba', 'CU', 'CUB', '1', '53', 'inactive', NULL, NULL, NULL),
(57, 'Cyprus', 'CY', 'CYP', '1', '357', 'inactive', NULL, NULL, NULL),
(58, 'Czech Republic', 'CZ', 'CZE', '1', '420', 'inactive', NULL, NULL, NULL),
(59, 'Denmark', 'DK', 'DNK', '1', '45', 'inactive', NULL, NULL, NULL),
(60, 'Djibouti', 'DJ', 'DJI', '1', '253', 'inactive', NULL, NULL, NULL),
(61, 'Dominica', 'DM', 'DMA', '1', '+1-767', 'inactive', NULL, NULL, NULL),
(62, 'Dominican Republic', 'DO', 'DOM', '1', '+1-809 and 1-829', 'inactive', NULL, NULL, NULL),
(63, 'East Timor', 'TL', 'TLS', '1', '670', 'inactive', NULL, NULL, NULL),
(64, 'Ecuador', 'EC', 'ECU', '1', '593', 'inactive', NULL, NULL, NULL),
(65, 'Egypt', 'EG', 'EGY', '1', '20', 'inactive', NULL, NULL, '2022-12-17 22:17:49'),
(66, 'El Salvador', 'SV', 'SLV', '1', '503', 'inactive', NULL, NULL, NULL),
(67, 'Equatorial Guinea', 'GQ', 'GNQ', '1', '240', 'inactive', NULL, NULL, NULL),
(68, 'Eritrea', 'ER', 'ERI', '1', '291', 'inactive', NULL, NULL, NULL),
(69, 'Estonia', 'EE', 'EST', '1', '372', 'inactive', NULL, NULL, NULL),
(70, 'Ethiopia', 'ET', 'ETH', '1', '251', 'inactive', NULL, NULL, NULL),
(71, 'Falkland Islands', 'FK', 'FLK', '1', '500', 'inactive', NULL, NULL, NULL),
(72, 'Faroe Islands', 'FO', 'FRO', '1', '298', 'inactive', NULL, NULL, NULL),
(73, 'Fiji Islands', 'FJ', 'FJI', '1', '679', 'inactive', NULL, NULL, NULL),
(74, 'Finland', 'FI', 'FIN', '1', '358', 'inactive', NULL, NULL, NULL),
(75, 'France', 'FR', 'FRA', '1', '33', 'inactive', NULL, NULL, NULL),
(76, 'French Guiana', 'GF', 'GUF', '1', '594', 'inactive', NULL, NULL, NULL),
(77, 'French Polynesia', 'PF', 'PYF', '1', '689', 'inactive', NULL, NULL, NULL),
(78, 'French Southern Territories', 'TF', 'ATF', '1', '', 'inactive', NULL, NULL, NULL),
(79, 'Gabon', 'GA', 'GAB', '1', '241', 'inactive', NULL, NULL, NULL),
(80, 'Gambia The', 'GM', 'GMB', '1', '220', 'inactive', NULL, NULL, NULL),
(81, 'Georgia', 'GE', 'GEO', '1', '995', 'inactive', NULL, NULL, NULL),
(82, 'Germany', 'DE', 'DEU', '1', '49', 'inactive', NULL, NULL, NULL),
(83, 'Ghana', 'GH', 'GHA', '1', '233', 'inactive', NULL, NULL, NULL),
(84, 'Gibraltar', 'GI', 'GIB', '1', '350', 'inactive', NULL, NULL, NULL),
(85, 'Greece', 'GR', 'GRC', '1', '30', 'inactive', NULL, NULL, NULL),
(86, 'Greenland', 'GL', 'GRL', '1', '299', 'inactive', NULL, NULL, NULL),
(87, 'Grenada', 'GD', 'GRD', '1', '+1-473', 'inactive', NULL, NULL, NULL),
(88, 'Guadeloupe', 'GP', 'GLP', '1', '590', 'inactive', NULL, NULL, NULL),
(89, 'Guam', 'GU', 'GUM', '1', '+1-671', 'inactive', NULL, NULL, NULL),
(90, 'Guatemala', 'GT', 'GTM', '1', '502', 'inactive', NULL, NULL, NULL),
(91, 'Guernsey and Alderney', 'GG', 'GGY', '1', '+44-1481', 'inactive', NULL, NULL, NULL),
(92, 'Guinea', 'GN', 'GIN', '1', '224', 'inactive', NULL, NULL, NULL),
(93, 'Guinea-Bissau', 'GW', 'GNB', '1', '245', 'inactive', NULL, NULL, NULL),
(94, 'Guyana', 'GY', 'GUY', '1', '592', 'inactive', NULL, NULL, NULL),
(95, 'Haiti', 'HT', 'HTI', '1', '509', 'inactive', NULL, NULL, NULL),
(96, 'Heard and McDonald Islands', 'HM', 'HMD', '1', ' ', 'inactive', NULL, NULL, NULL),
(97, 'Honduras', 'HN', 'HND', '1', '504', 'inactive', NULL, NULL, NULL),
(98, 'Hong Kong S.A.R.', 'HK', 'HKG', '1', '852', 'inactive', NULL, NULL, NULL),
(99, 'Hungary', 'HU', 'HUN', '1', '36', 'inactive', NULL, NULL, NULL),
(100, 'Iceland', 'IS', 'ISL', '1', '354', 'inactive', NULL, NULL, NULL),
(101, 'India', 'IN', 'IND', '1', '91', 'inactive', NULL, NULL, NULL),
(102, 'Indonesia', 'ID', 'IDN', '1', '62', 'inactive', NULL, NULL, NULL),
(103, 'Iran', 'IR', 'IRN', '1', '98', 'inactive', NULL, NULL, NULL),
(104, 'Iraq', 'IQ', 'IRQ', '1', '964', 'inactive', NULL, NULL, NULL),
(105, 'Ireland', 'IE', 'IRL', '1', '353', 'inactive', NULL, NULL, NULL),
(106, 'Israel', 'IL', 'ISR', '1', '972', 'inactive', NULL, NULL, NULL),
(107, 'Italy', 'IT', 'ITA', '1', '39', 'inactive', NULL, NULL, NULL),
(108, 'Jamaica', 'JM', 'JAM', '1', '+1-876', 'inactive', NULL, NULL, NULL),
(109, 'Japan', 'JP', 'JPN', '1', '81', 'inactive', NULL, NULL, NULL),
(110, 'Jersey', 'JE', 'JEY', '1', '+44-1534', 'inactive', NULL, NULL, NULL),
(111, 'Jordan', 'JO', 'JOR', '1', '962', 'inactive', NULL, NULL, NULL),
(112, 'Kazakhstan', 'KZ', 'KAZ', '1', '7', 'inactive', NULL, NULL, NULL),
(113, 'Kenya', 'KE', 'KEN', '1', '254', 'inactive', NULL, NULL, NULL),
(114, 'Kiribati', 'KI', 'KIR', '1', '686', 'inactive', NULL, NULL, NULL),
(115, 'Korea North', 'KP', 'PRK', '1', '850', 'inactive', NULL, NULL, NULL),
(116, 'Korea South', 'KR', 'KOR', '1', '82', 'inactive', NULL, NULL, NULL),
(117, 'Kuwait', 'KW', 'KWT', '1', '965', 'inactive', NULL, NULL, NULL),
(118, 'Kyrgyzstan', 'KG', 'KGZ', '1', '996', 'inactive', NULL, NULL, NULL),
(119, 'Laos', 'LA', 'LAO', '1', '856', 'inactive', NULL, NULL, NULL),
(120, 'Latvia', 'LV', 'LVA', '1', '371', 'inactive', NULL, NULL, NULL),
(121, 'Lebanon', 'LB', 'LBN', '1', '961', 'inactive', NULL, NULL, NULL),
(122, 'Lesotho', 'LS', 'LSO', '1', '266', 'inactive', NULL, NULL, NULL),
(123, 'Liberia', 'LR', 'LBR', '1', '231', 'inactive', NULL, NULL, NULL),
(124, 'Libya', 'LY', 'LBY', '1', '218', 'inactive', NULL, NULL, NULL),
(125, 'Liechtenstein', 'LI', 'LIE', '1', '423', 'inactive', NULL, NULL, NULL),
(126, 'Lithuania', 'LT', 'LTU', '1', '370', 'inactive', NULL, NULL, NULL),
(127, 'Luxembourg', 'LU', 'LUX', '1', '352', 'inactive', NULL, NULL, NULL),
(128, 'Macau S.A.R.', 'MO', 'MAC', '1', '853', 'inactive', NULL, NULL, NULL),
(129, 'Macedonia', 'MK', 'MKD', '1', '389', 'inactive', NULL, NULL, NULL),
(130, 'Madagascar', 'MG', 'MDG', '1', '261', 'inactive', NULL, NULL, NULL),
(131, 'Malawi', 'MW', 'MWI', '1', '265', 'inactive', NULL, NULL, NULL),
(132, 'Malaysia', 'MY', 'MYS', '1', '60', 'inactive', NULL, NULL, NULL),
(133, 'Maldives', 'MV', 'MDV', '1', '960', 'inactive', NULL, NULL, NULL),
(134, 'Mali', 'ML', 'MLI', '1', '223', 'inactive', NULL, NULL, NULL),
(135, 'Malta', 'MT', 'MLT', '1', '356', 'inactive', NULL, NULL, NULL),
(136, 'Man (Isle of)', 'IM', 'IMN', '1', '+44-1624', 'inactive', NULL, NULL, NULL),
(137, 'Marshall Islands', 'MH', 'MHL', '1', '692', 'inactive', NULL, NULL, NULL),
(138, 'Martinique', 'MQ', 'MTQ', '1', '596', 'inactive', NULL, NULL, NULL),
(139, 'Mauritania', 'MR', 'MRT', '1', '222', 'inactive', NULL, NULL, NULL),
(140, 'Mauritius', 'MU', 'MUS', '1', '230', 'inactive', NULL, NULL, NULL),
(141, 'Mayotte', 'YT', 'MYT', '1', '262', 'inactive', NULL, NULL, NULL),
(142, 'Mexico', 'MX', 'MEX', '1', '52', 'inactive', NULL, NULL, NULL),
(143, 'Micronesia', 'FM', 'FSM', '1', '691', 'inactive', NULL, NULL, NULL),
(144, 'Moldova', 'MD', 'MDA', '1', '373', 'inactive', NULL, NULL, NULL),
(145, 'Monaco', 'MC', 'MCO', '1', '377', 'inactive', NULL, NULL, NULL),
(146, 'Mongolia', 'MN', 'MNG', '1', '976', 'inactive', NULL, NULL, NULL),
(147, 'Montenegro', 'ME', 'MNE', '1', '382', 'inactive', NULL, NULL, NULL),
(148, 'Montserrat', 'MS', 'MSR', '1', '+1-664', 'inactive', NULL, NULL, NULL),
(149, 'Morocco', 'MA', 'MAR', '1', '212', 'inactive', NULL, NULL, NULL),
(150, 'Mozambique', 'MZ', 'MOZ', '1', '258', 'inactive', NULL, NULL, NULL),
(151, 'Myanmar', 'MM', 'MMR', '1', '95', 'inactive', NULL, NULL, NULL),
(152, 'Namibia', 'NA', 'NAM', '1', '264', 'inactive', NULL, NULL, NULL),
(153, 'Nauru', 'NR', 'NRU', '1', '674', 'inactive', NULL, NULL, NULL),
(154, 'Nepal', 'NP', 'NPL', '1', '977', 'inactive', NULL, NULL, NULL),
(155, 'Netherlands Antilles', 'AN', 'ANT', '1', '', 'inactive', NULL, NULL, NULL),
(156, 'Netherlands The', 'NL', 'NLD', '1', '31', 'inactive', NULL, NULL, NULL),
(157, 'New Caledonia', 'NC', 'NCL', '1', '687', 'inactive', NULL, NULL, NULL),
(158, 'New Zealand', 'NZ', 'NZL', '1', '64', 'inactive', NULL, NULL, NULL),
(159, 'Nicaragua', 'NI', 'NIC', '1', '505', 'inactive', NULL, NULL, NULL),
(160, 'Niger', 'NE', 'NER', '1', '227', 'inactive', NULL, NULL, NULL),
(161, 'Nigeria', 'NG', 'NGA', '1', '234', 'inactive', NULL, NULL, NULL),
(162, 'Niue', 'NU', 'NIU', '1', '683', 'inactive', NULL, NULL, NULL),
(163, 'Norfolk Island', 'NF', 'NFK', '1', '672', 'inactive', NULL, NULL, NULL),
(164, 'Northern Mariana Islands', 'MP', 'MNP', '1', '+1-670', 'inactive', NULL, NULL, NULL),
(165, 'Norway', 'NO', 'NOR', '1', '47', 'inactive', NULL, NULL, NULL),
(166, 'Oman', 'OM', 'OMN', '1', '968', 'inactive', NULL, NULL, NULL),
(167, 'Pakistan', 'PK', 'PAK', '1', '92', 'inactive', NULL, NULL, NULL),
(168, 'Palau', 'PW', 'PLW', '1', '680', 'inactive', NULL, NULL, NULL),
(169, 'Palestinian Territory Occupied', 'PS', 'PSE', '1', '970', 'inactive', NULL, NULL, NULL),
(170, 'Panama', 'PA', 'PAN', '1', '507', 'inactive', NULL, NULL, NULL),
(171, 'Papua new Guinea', 'PG', 'PNG', '1', '675', 'inactive', NULL, NULL, NULL),
(172, 'Paraguay', 'PY', 'PRY', '1', '595', 'inactive', NULL, NULL, NULL),
(173, 'Peru', 'PE', 'PER', '1', '51', 'inactive', NULL, NULL, NULL),
(174, 'Philippines', 'PH', 'PHL', '1', '63', 'inactive', NULL, NULL, NULL),
(175, 'Pitcairn Island', 'PN', 'PCN', '1', '870', 'inactive', NULL, NULL, NULL),
(176, 'Poland', 'PL', 'POL', '1', '48', 'inactive', NULL, NULL, NULL),
(177, 'Portugal', 'PT', 'PRT', '1', '351', 'inactive', NULL, NULL, NULL),
(178, 'Puerto Rico', 'PR', 'PRI', '1', '+1-787 and 1-939', 'inactive', NULL, NULL, NULL),
(179, 'Qatar', 'QA', 'QAT', '1', '974', 'inactive', NULL, NULL, NULL),
(180, 'Reunion', 'RE', 'REU', '1', '262', 'inactive', NULL, NULL, NULL),
(181, 'Romania', 'RO', 'ROU', '1', '40', 'inactive', NULL, NULL, NULL),
(182, 'Russia', 'RU', 'RUS', '1', '7', 'inactive', NULL, NULL, NULL),
(183, 'Rwanda', 'RW', 'RWA', '1', '250', 'inactive', NULL, NULL, NULL),
(184, 'Saint Helena', 'SH', 'SHN', '1', '290', 'inactive', NULL, NULL, NULL),
(185, 'Saint Kitts And Nevis', 'KN', 'KNA', '1', '+1-869', 'inactive', NULL, NULL, NULL),
(186, 'Saint Lucia', 'LC', 'LCA', '1', '+1-758', 'inactive', NULL, NULL, NULL),
(187, 'Saint Pierre and Miquelon', 'PM', 'SPM', '1', '508', 'inactive', NULL, NULL, NULL),
(188, 'Saint Vincent And The Grenadines', 'VC', 'VCT', '1', '+1-784', 'inactive', NULL, NULL, NULL),
(189, 'Saint-Barthelemy', 'BL', 'BLM', '1', '590', 'inactive', NULL, NULL, NULL),
(190, 'Saint-Martin (French part)', 'MF', 'MAF', '1', '590', 'inactive', NULL, NULL, NULL),
(191, 'Samoa', 'WS', 'WSM', '1', '685', 'inactive', NULL, NULL, NULL),
(192, 'San Marino', 'SM', 'SMR', '1', '378', 'inactive', NULL, NULL, NULL),
(193, 'Sao Tome and Principe', 'ST', 'STP', '1', '239', 'inactive', NULL, NULL, NULL),
(194, 'Saudi Arabia', 'SA', 'SAU', '1', '966', 'inactive', NULL, NULL, NULL),
(195, 'Senegal', 'SN', 'SEN', '1', '221', 'inactive', NULL, NULL, NULL),
(196, 'Serbia', 'RS', 'SRB', '1', '381', 'inactive', NULL, NULL, NULL),
(197, 'Seychelles', 'SC', 'SYC', '1', '248', 'inactive', NULL, NULL, NULL),
(198, 'Sierra Leone', 'SL', 'SLE', '1', '232', 'inactive', NULL, NULL, NULL),
(199, 'Singapore', 'SG', 'SGP', '1', '65', 'inactive', NULL, NULL, NULL),
(200, 'Slovakia', 'SK', 'SVK', '1', '421', 'inactive', NULL, NULL, NULL),
(201, 'Slovenia', 'SI', 'SVN', '1', '386', 'inactive', NULL, NULL, NULL),
(202, 'Solomon Islands', 'SB', 'SLB', '1', '677', 'inactive', NULL, NULL, NULL),
(203, 'Somalia', 'SO', 'SOM', '1', '252', 'inactive', NULL, NULL, NULL),
(204, 'South Africa', 'ZA', 'ZAF', '1', '27', 'inactive', NULL, NULL, NULL),
(205, 'South Georgia', 'GS', 'SGS', '1', '', 'inactive', NULL, NULL, NULL),
(206, 'South Sudan', 'SS', 'SSD', '1', '211', 'inactive', NULL, NULL, NULL),
(207, 'Spain', 'ES', 'ESP', '1', '34', 'inactive', NULL, NULL, NULL),
(208, 'Sri Lanka', 'LK', 'LKA', '1', '94', 'inactive', NULL, NULL, NULL),
(209, 'Sudan', 'SD', 'SDN', '1', '249', 'inactive', NULL, NULL, NULL),
(210, 'Suriname', 'SR', 'SUR', '1', '597', 'inactive', NULL, NULL, NULL),
(211, 'Svalbard And Jan Mayen Islands', 'SJ', 'SJM', '1', '47', 'inactive', NULL, NULL, NULL),
(212, 'Swaziland', 'SZ', 'SWZ', '1', '268', 'inactive', NULL, NULL, NULL),
(213, 'Sweden', 'SE', 'SWE', '1', '46', 'inactive', NULL, NULL, NULL),
(214, 'Switzerland', 'CH', 'CHE', '1', '41', 'inactive', NULL, NULL, NULL),
(215, 'Syria', 'SY', 'SYR', '1', '963', 'inactive', NULL, NULL, NULL),
(216, 'Taiwan', 'TW', 'TWN', '1', '886', 'inactive', NULL, NULL, NULL),
(217, 'Tajikistan', 'TJ', 'TJK', '1', '992', 'inactive', NULL, NULL, NULL),
(218, 'Tanzania', 'TZ', 'TZA', '1', '255', 'inactive', NULL, NULL, NULL),
(219, 'Thailand', 'TH', 'THA', '1', '66', 'inactive', NULL, NULL, NULL),
(220, 'Togo', 'TG', 'TGO', '1', '228', 'inactive', NULL, NULL, NULL),
(221, 'Tokelau', 'TK', 'TKL', '1', '690', 'inactive', NULL, NULL, NULL),
(222, 'Tonga', 'TO', 'TON', '1', '676', 'inactive', NULL, NULL, NULL),
(223, 'Trinidad And Tobago', 'TT', 'TTO', '1', '+1-868', 'inactive', NULL, NULL, NULL),
(224, 'Tunisia', 'TN', 'TUN', '1', '216', 'inactive', NULL, NULL, NULL),
(225, 'Turkey', 'TR', 'TUR', '1', '90', 'inactive', NULL, NULL, NULL),
(226, 'Turkmenistan', 'TM', 'TKM', '1', '993', 'inactive', NULL, NULL, NULL),
(227, 'Turks And Caicos Islands', 'TC', 'TCA', '1', '+1-649', 'inactive', NULL, NULL, NULL),
(228, 'Tuvalu', 'TV', 'TUV', '1', '688', 'inactive', NULL, NULL, NULL),
(229, 'Uganda', 'UG', 'UGA', '1', '256', 'inactive', NULL, NULL, NULL),
(230, 'Ukraine', 'UA', 'UKR', '1', '380', 'inactive', NULL, NULL, NULL),
(231, 'United Arab Emirates', 'AE', 'ARE', '1', '971', 'inactive', NULL, NULL, NULL),
(232, 'United Kingdom', 'GB', 'GBR', '1', '44', 'inactive', NULL, NULL, NULL),
(233, 'United States', 'US', 'USA', '1', '1', 'active', NULL, NULL, '2022-12-17 22:18:18'),
(234, 'United States Minor Outlying Islands', 'UM', 'UMI', '1', '1', 'inactive', NULL, NULL, NULL),
(235, 'Uruguay', 'UY', 'URY', '1', '598', 'inactive', NULL, NULL, NULL),
(236, 'Uzbekistan', 'UZ', 'UZB', '1', '998', 'inactive', NULL, NULL, NULL),
(237, 'Vanuatu', 'VU', 'VUT', '1', '678', 'inactive', NULL, NULL, NULL),
(238, 'Vatican City State (Holy See)', 'VA', 'VAT', '1', '379', 'inactive', NULL, NULL, NULL),
(239, 'Venezuela', 'VE', 'VEN', '1', '58', 'inactive', NULL, NULL, NULL),
(240, 'Vietnam', 'VN', 'VNM', '1', '84', 'inactive', NULL, NULL, NULL),
(241, 'Virgin Islands (British)', 'VG', 'VGB', '1', '+1-284', 'inactive', NULL, NULL, NULL),
(242, 'Virgin Islands (US)', 'VI', 'VIR', '1', '+1-340', 'inactive', NULL, NULL, NULL),
(243, 'Wallis And Futuna Islands', 'WF', 'WLF', '1', '681', 'inactive', NULL, NULL, NULL),
(244, 'Western Sahara', 'EH', 'ESH', '1', '212', 'inactive', NULL, NULL, NULL),
(245, 'Yemen', 'YE', 'YEM', '1', '967', 'inactive', NULL, NULL, NULL),
(246, 'Zambia', 'ZM', 'ZMB', '1', '260', 'inactive', NULL, NULL, NULL),
(247, 'Zimbabwe', 'ZW', 'ZWE', '1', '263', 'inactive', NULL, NULL, NULL),
(248, 'Kosovo', 'XK', 'XKX', '1', '383', 'inactive', NULL, NULL, NULL),
(249, 'Curaçao', 'CW', 'CUW', '1', '599', 'inactive', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `coupon_order`
-- (See below for the actual view)
--
CREATE TABLE `coupon_order` (
`customer_id` bigint(20) unsigned
,`coupon_code` varchar(191)
,`num_of_usage` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_setting`
--

CREATE TABLE `coupon_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('fixed','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `amount` double(8,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `usage_limit_per_user` int(11) DEFAULT NULL,
  `usage_limit_per_coupon` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol_position` enum('left','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `decimal_point` int(11) NOT NULL DEFAULT 2,
  `thousand_point` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decimal_place` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `country_id` int(11) DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate` double(8,4) DEFAULT 0.0000,
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'if 1 then currency is set to as default!',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `title`, `symbol_position`, `decimal_point`, `thousand_point`, `decimal_place`, `status`, `country_id`, `code`, `exchange_rate`, `is_default`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'USD', 'left', 2, NULL, '2', 'active', NULL, '$', 1.0000, 1, NULL, NULL, NULL, NULL, '2022-12-17 22:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `current_theme`
--

CREATE TABLE `current_theme` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `home_setting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`home_setting`)),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `current_theme`
--

INSERT INTO `current_theme` (`id`, `home_setting`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '[{\"id\":\"1\",\"name\":\"Header\",\"template_postfix\":\"header\",\"value\":\"style1\",\"display\":true,\"class\":\"\",\"skip\":true,\"image\":\"/assets/images/prototypes/header-styles/header1.jpg\",\"multiple\":true},{\"id\":\"2\",\"name\":\"Carousal\",\"template_postfix\":\"slider\",\"value\":\"style1\",\"display\":true,\"class\":\"\",\"skip\":true,\"image\":\"/assets/images/prototypes/carousal-styles/carousal1.jpg\",\"multiple\":true},{\"id\":\"5\",\"name\":\"Banner\",\"template_postfix\":\"banner\",\"value\":\"style2\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/banner-styles/banner2.jpg\",\"multiple\":true},{\"id\":\"8\",\"name\":\"Product Tabs\",\"template_postfix\":\"tabs\",\"value\":\"product_tabs\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/tab.jpg\",\"multiple\":false},{\"id\":\"3\",\"name\":\"categories\",\"template_postfix\":\"category\",\"value\":\"style2\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/categories.jpg\",\"multiple\":false},{\"id\":\"4\",\"name\":\"Home Banner 1\",\"template_postfix\":\"banner-1\",\"value\":\"ad_section_1\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/ad_banner_section.jpg\",\"multiple\":false},{\"id\":\"7\",\"name\":\"Latest Product\",\"template_postfix\":\"new-arrival\",\"value\":\"latest_product\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/newest_product.jpg\",\"multiple\":false},{\"id\":\"6\",\"name\":\"Home Banner 2\",\"template_postfix\":\"banner-2\",\"value\":\"ad_section_2\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/sec_ad_section.jpg\",\"multiple\":false},{\"id\":\"14\",\"name\":\"Week Sale\",\"template_postfix\":\"week-sale\",\"value\":\"week-sale\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/weekly-sale.png\",\"multiple\":false},{\"id\":\"9\",\"name\":\"Home Banner 3\",\"template_postfix\":\"banner-3\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/ad_banner_section.jpg\",\"multiple\":false},{\"id\":\"11\",\"name\":\"Blog section\",\"template_postfix\":\"news\",\"value\":\"blog_section\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/blog_section.jpg\",\"multiple\":false},{\"id\":\"13\",\"name\":\"Info\",\"template_postfix\":\"info\",\"value\":\"info\",\"display\":true,\"class\":\"moving-card\",\"skip\":false,\"image\":\"/assets/images/prototypes/info_boxes.jpg\",\"multiple\":false},{\"id\":\"15\",\"name\":\"Footer\",\"template_postfix\":\"footer\",\"value\":\"style1\",\"display\":true,\"class\":\"\",\"skip\":true,\"image\":\"/assets/images/prototypes/footer-styles/footer1.png\",\"multiple\":true}]', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `current_value`
-- (See below for the actual view)
--
CREATE TABLE `current_value` (
`reference_id` bigint(20)
,`total_amount` double(19,2)
,`name` varchar(191)
,`type` enum('customer','supplier','simple_product','variable_product','tax','shipping','couponcode','discount','sale','income')
);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_seen` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 for active & 1 for delete',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forget_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `gallary_id`, `is_seen`, `status`, `password`, `provider`, `provider_id`, `hash`, `forget_hash`, `created_by`, `updated_by`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'default', 'pos customer', 'default-pos-customer@email.com', 1, '1', '0', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-17 19:37:12', '2022-12-17 19:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address_book`
--

CREATE TABLE `customer_address_book` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suburb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lattitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latlong` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_address_book`
--

INSERT INTO `customer_address_book` (`id`, `customer_id`, `gender`, `first_name`, `last_name`, `company`, `street_address`, `suburb`, `phone`, `postcode`, `dob`, `city`, `country_id`, `state_id`, `lattitude`, `longitude`, `latlong`, `is_default`) VALUES
(1, 1, 'Male', NULL, NULL, 'Test Company', 'Test Address', '111', NULL, '63801', '1994-05-08', 'Faisalabad', 195, 130, '102.45', '54.10', NULL, 1),
(2, 1, 'Male', NULL, NULL, 'Test Company 1', 'Test Address 1', '1111', NULL, '63801', '1994-05-09', 'NYC', 195, 131, '102.45', '54.10', NULL, 0),
(3, 1, 'Male', NULL, NULL, 'Test Company 2', 'Test Address 2', '1112', NULL, '63801', '1994-05-12', 'London', 195, 130, '102.45', '54.10', NULL, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_order_amount`
-- (See below for the actual view)
--
CREATE TABLE `customer_order_amount` (
`customer_id` bigint(20) unsigned
,`order_amount` double(19,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `custom_css_js`
--

CREATE TABLE `custom_css_js` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `before_head_tag` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_of_body_tag` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `default_accounts`
--

CREATE TABLE `default_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('customer','vendor','supplies','cash','income','accountpayable') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `default_accounts`
--

INSERT INTO `default_accounts` (`id`, `account_id`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 8, 'customer', NULL, NULL, NULL),
(2, 11, 'vendor', NULL, NULL, NULL),
(3, 6, 'supplies', NULL, NULL, NULL),
(4, 2, 'cash', NULL, NULL, NULL),
(5, 10, 'accountpayable', NULL, NULL, NULL),
(6, 14, 'income', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boys`
--

CREATE TABLE `delivery_boys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `availability_status` tinyint(1) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` bigint(20) UNSIGNED NOT NULL,
  `in_active` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` bigint(20) UNSIGNED NOT NULL,
  `vehicle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_registration_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_details` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driving_license_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_rc_book_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpay_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_settings`
--

CREATE TABLE `demo_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `footer_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slider_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_page_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_template_settings`
--

CREATE TABLE `email_template_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('amazing_deal','forget_password','new_arrival','overall_sale','sale','singup','winter_sale','contact_us','welcome','order') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `expense_report`
-- (See below for the actual view)
--
CREATE TABLE `expense_report` (
`description` text
,`amount` double(8,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallary`
--

CREATE TABLE `gallary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallary`
--

INSERT INTO `gallary` (`id`, `name`, `extension`, `user_id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '202212172337229c0d3a-fe8f-4427-822d-abb7166aec74.png', 'image/png', 1, 1, NULL, NULL, '2022-12-17 20:23:37', '2022-12-17 20:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `gallary_detail`
--

CREATE TABLE `gallary_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gallary_type` enum('large','medium','thumbnail') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallary_detail`
--

INSERT INTO `gallary_detail` (`id`, `gallary_id`, `gallary_type`, `height`, `width`, `path`) VALUES
(1, 1, 'large', 900, 900, '/gallary/large202212172337229c0d3a-fe8f-4427-822d-abb7166aec74.png'),
(2, 1, 'medium', 600, 600, '/gallary/medium202212172337229c0d3a-fe8f-4427-822d-abb7166aec74.png'),
(3, 1, 'thumbnail', 400, 400, '/gallary/thumbnail202212172337229c0d3a-fe8f-4427-822d-abb7166aec74.png');

-- --------------------------------------------------------

--
-- Table structure for table `gallary_tags`
--

CREATE TABLE `gallary_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_banners`
--

CREATE TABLE `home_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_banners`
--

INSERT INTO `home_banners` (`id`, `banner_name`, `language_id`, `content`, `gallary_id`, `created_at`, `updated_at`) VALUES
(1, 'banners_1', 1, '<div class=\"parallax-banner-text\"><h2>Parallax Banner One</h2><h4>Sunday Special</h4><div class=\"hover-link\"><a href=\"/shop\" class=\"btn btn-secondary swipe-to-top\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"View All Range\" data-original-title=\"View All Range\">Shop Now</a></div></div>', 41, NULL, NULL),
(2, 'banners_2', 1, '<div class=\"parallax-banner-text\">        <h2>Parallax Banner Two</h2>            <h4>Farm Fresh</h4>            <div class=\"hover-link\">               <a href=\"/shop\" class=\"btn btn-secondary swipe-to-top\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"View All Range\" data-original-title=\"View All Range\">Shop Now</a>        </div>      </div>', 41, NULL, NULL),
(3, 'banners_3', 1, '<div class=\"parallax-banner-text\">      <h2>Parallax Banner Three</h2>          <h4>Your Favorite</h4>          <div class=\"hover-link\">             <a href=\"/shop\" class=\"btn btn-secondary swipe-to-top\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"View All Range\" data-original-title=\"View All Range\">Shop Now </a>      </div>    </div>', 41, NULL, NULL),
(4, 'banners_1', 2, '<div class=\"parallax-banner-text\">      <h2> مهرجان طعام</h2>         <h4>رمضان خاص</h4>         <div class=\"hover-link\">             <a href=\"/shop\" class=\"btn btn-secondary swipe-to-top\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"View All Range\" data-original-title=\"View All Range\">تسوق الآن</a>      </div>    </div>', 41, NULL, NULL),
(5, 'banners_2', 2, '<div class=\"parallax-banner-text\">      <h2>فواكه وخضروات طازجة</h2>         <h4>الزراعية الطازجة</h4>         <div class=\"hover-link\">             <a href=\"/shop\" class=\"btn btn-secondary swipe-to-top\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"View All Range\" data-original-title=\"View All Range\">عرض كل المدى</a>      </div>    </div>', 41, NULL, NULL),
(6, 'banners_3', 2, '<div class=\"parallax-banner-text\">      <h2>منطقة البقالة</h2>         <h4>المفضلة لديك</h4>         <div class=\"hover-link\">             <a href=\"/shop\" class=\"btn btn-secondary swipe-to-top\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"View All Range\" data-original-title=\"View All Range\">اشتري الآن</a>      </div>    </div>	\r\n            ', 41, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_status` enum('IN','OUT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'purchase id, sale id, order id & stock transfer',
  `stock_type` enum('StockAdjustment','Purchase','Sale','Order','StockTransfer','SaleReturn','PurchaseReturn','ManualSale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `product_combination_id`, `warehouse_id`, `customer_id`, `stock_status`, `qty`, `reference_id`, `stock_type`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, NULL, 'IN', 50, NULL, 'StockAdjustment', 1, NULL, NULL, '2022-12-17 21:18:53', '2022-12-17 21:18:53'),
(2, 1, 1, 1, NULL, 'IN', 50, NULL, 'StockAdjustment', 1, NULL, NULL, '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(3, 1, 2, 2, NULL, 'IN', 50, NULL, 'StockAdjustment', NULL, NULL, NULL, '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(4, 1, 3, 2, NULL, 'IN', 50, NULL, 'StockAdjustment', NULL, NULL, NULL, '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(5, 1, 1, 2, NULL, 'OUT', 10, NULL, 'StockAdjustment', 1, NULL, NULL, '2022-12-17 21:58:56', '2022-12-17 21:58:56'),
(6, 1, 2, 2, NULL, 'OUT', 1, 1, 'StockTransfer', 1, NULL, NULL, '2022-12-17 22:00:16', '2022-12-17 22:00:16'),
(7, 1, 2, 1, NULL, 'IN', 1, 1, 'StockTransfer', 1, NULL, NULL, '2022-12-17 22:00:16', '2022-12-17 22:00:16'),
(8, 1, 3, 2, NULL, 'IN', 100, NULL, 'StockAdjustment', 1, NULL, NULL, '2022-12-17 22:12:27', '2022-12-17 22:12:27'),
(9, 1, 3, 1, NULL, 'IN', 100, NULL, 'StockAdjustment', 1, NULL, NULL, '2022-12-17 22:13:40', '2022-12-17 22:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `directory` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction` enum('ltr','rtl') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'if 1 then langauge is set to as default!',
  `status` enum('active','inactive','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `directory`, `direction`, `is_default`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'English', 'EN', NULL, 'ltr', 1, 'active', NULL, NULL, NULL, NULL, '2022-12-17 22:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `localizations`
--

CREATE TABLE `localizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `current_language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_value` double(8,2) NOT NULL,
  `end_value` double(8,2) NOT NULL,
  `display_text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_detail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_builders`
--

CREATE TABLE `menu_builders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`menu`)),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_builders`
--

INSERT INTO `menu_builders` (`id`, `menu`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '[\r\n                    {\r\n                        \"id\": 1628672836150,\r\n                        \"link\": \"\",\r\n                        \"name\": [\r\n                            \"Home\",\r\n                            \"الصفحة الرئيسية\"\r\n                        ],\r\n                        \"page\": \"/\",\r\n                        \"type\": \"page\",\r\n                        \"exlink\": \"\",\r\n                        \"product\": \"\",\r\n                        \"category\": \"\",\r\n                        \"children\": [],\r\n                        \"contentpage\": \"\",\r\n                        \"language_id\": [\r\n                            1,\r\n                            2\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"id\": 1628672997563,\r\n                        \"link\": \"\",\r\n                        \"name\": [\r\n                            \"Shop\",\r\n                            \"محل\"\r\n                        ],\r\n                        \"page\": \"/shop\",\r\n                        \"type\": \"page\",\r\n                        \"exlink\": \"\",\r\n                        \"product\": \"\",\r\n                        \"category\": \"\",\r\n                        \"children\": [],\r\n                        \"contentpage\": \"\",\r\n                        \"language_id\": [\r\n                            1,\r\n                            2\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"id\": 1628672976637,\r\n                        \"link\": \"\",\r\n                        \"name\": [\r\n                            \"Blog\",\r\n                            \"مقالات\"\r\n                        ],\r\n                        \"page\": \"/blog\",\r\n                        \"type\": \"page\",\r\n                        \"exlink\": \"\",\r\n                        \"product\": \"\",\r\n                        \"category\": \"\",\r\n                        \"children\": [],\r\n                        \"contentpage\": \"\",\r\n                        \"language_id\": [\r\n                            1,\r\n                            2\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"id\": 1628672935413,\r\n                        \"link\": \"\",\r\n                        \"name\": [\r\n                            \"Contact Us\",\r\n                            \"اتصل بنا\"\r\n                        ],\r\n                        \"page\": \"/contact-us\",\r\n                        \"type\": \"page\",\r\n                        \"exlink\": \"\",\r\n                        \"product\": \"\",\r\n                        \"category\": \"\",\r\n                        \"children\": [],\r\n                        \"contentpage\": \"\",\r\n                        \"language_id\": [\r\n                            1,\r\n                            2\r\n                        ]\r\n                    }\r\n                    \r\n            ]', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_details`
--

CREATE TABLE `menu_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_10_000000_create_menus_table', 1),
(2, '2014_10_10_000000_create_pages_table', 1),
(3, '2014_10_10_000000_create_roles_table', 1),
(4, '2014_10_10_000001_create_menu_details_table', 1),
(5, '2014_10_10_000001_create_page_detail_table', 1),
(6, '2014_10_11_000000_create_users_table', 1),
(7, '2014_10_11_000000_create_warehouses_table', 1),
(8, '2014_10_11_000001_create_permission_table', 1),
(9, '2014_10_11_000002_create_permission_role_table', 1),
(10, '2014_10_12_000001_create_countries_table', 1),
(11, '2014_10_12_000002_create_languages_table', 1),
(12, '2014_10_12_000002_create_states_table', 1),
(13, '2014_10_12_100000_create_password_resets_table', 1),
(14, '2014_10_13_000000_create_currency_table', 1),
(15, '2015_10_20_000004_create_email_template_settings_table', 1),
(16, '2015_10_20_000004_create_top_offer_table', 1),
(17, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(18, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(19, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(20, '2016_06_01_000004_create_oauth_clients_table', 1),
(21, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(22, '2019_08_19_000000_create_failed_jobs_table', 1),
(23, '2019_08_19_000000_create_units_table', 1),
(24, '2019_09_19_000000_create_unit_detail_table', 1),
(25, '2019_10_19_000000_create_gallary_table', 1),
(26, '2019_11_19_000000_create_gallary_detail_table', 1),
(27, '2019_11_20_000000_create_brands_table', 1),
(28, '2019_11_21_000000_create_customers_table', 1),
(29, '2019_11_22_000000_create_customer_address_book_table', 1),
(30, '2019_12_00_000000_create_blog_categories_table', 1),
(31, '2019_12_10_000000_create_blog_category_detail_table', 1),
(32, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(33, '2019_12_20_000000_create_blog_news_table', 1),
(34, '2019_13_20_000000_create_blog_news_detail_table', 1),
(35, '2019_15_19_000000_create_categories_table', 1),
(36, '2019_15_19_000000_create_category_detail_table', 1),
(37, '2020_07_18_000000_create_attributes_table', 1),
(38, '2020_07_18_000000_create_slider_navigation_table', 1),
(39, '2020_07_18_000000_create_slider_types_table', 1),
(40, '2020_07_18_000000_create_sliders_table', 1),
(41, '2020_07_18_000000_create_taxes_table', 1),
(42, '2020_07_18_000000_create_variations_table', 1),
(43, '2020_07_18_000001_attribute_detail', 1),
(44, '2020_07_18_000001_variation_detail', 1),
(45, '2020_07_19_000000_create_tax_rates_table', 1),
(46, '2020_10_19_000000_create_products_table', 1),
(47, '2020_12_01_224002_create_settings_table', 1),
(48, '2020_12_03_201818_create_payment_methods_table', 1),
(49, '2020_12_03_234006_create_payment_method_descriptions_table', 1),
(50, '2020_12_03_234022_create_payment_method_settings_table', 1),
(51, '2020_12_07_191922_create_shipping_methods_table', 1),
(52, '2020_12_07_192248_create_shipping_method_descriptions_table', 1),
(53, '2020_12_18_002430_create_compares_table', 1),
(54, '2020_20_19_000000_create_product_detail_table', 1),
(55, '2020_30_19_000000_create_product_attribute_table', 1),
(56, '2020_30_20_000000_create_product_category_table', 1),
(57, '2020_30_20_000000_create_product_variation_table', 1),
(58, '2020_31_19_000000_create_product_combination_table', 1),
(59, '2020_32_19_000000_create_product_combination_dtl_table', 1),
(60, '2020_32_20_000000_create_product_comments_table', 1),
(61, '2020_32_20_000000_create_product_review_table', 1),
(62, '2020_35_18_000000_create_purchaser_table', 1),
(63, '2020_35_18_00000_create_suppliers_table', 1),
(64, '2020_35_19_000000_create_purchase_table', 1),
(65, '2020_35_20_000000_create_purchase_detail_table', 1),
(66, '2020_35_20_000000_create_purchase_return_table', 1),
(67, '2020_35_21_000000_create_purchase_return_details_table', 1),
(68, '2020_36_01_000000_create_sales_table', 1),
(69, '2020_36_02_000000_create_sale_details_table', 1),
(70, '2020_36_03_000000_create_sale_return_table', 1),
(71, '2020_36_04_000000_create_sale_return_details_table', 1),
(72, '2020_40_19_000000_create_orders_table', 1),
(73, '2020_41_19_000000_create_order_detail_table', 1),
(74, '2020_45_19_000000_create_wishlist_table', 1),
(75, '2020_46_19_000000_create_coupon_setting_table', 1),
(76, '2020_50_19_000000_create_inventory_table', 1),
(77, '2020_50_19_000001_create_cart_items_table', 1),
(78, '2020_51_18_000000_create_timezones_table', 1),
(79, '2020_51_19_000000_create_accounts_table', 1),
(80, '2020_51_19_000000_create_business_setting_table', 1),
(81, '2020_51_19_000000_create_current_theme_table', 1),
(82, '2020_51_19_000000_create_transactions_table', 1),
(83, '2021_01_15_000821_create_bar_code_settings_table', 1),
(84, '2021_01_15_000821_create_billers_table', 1),
(85, '2021_01_15_000821_create_quotations_table', 1),
(86, '2021_01_15_000822_create_quotation_detail_table', 1),
(87, '2021_01_15_000822_create_tags_table', 1),
(88, '2021_01_15_000823_create_banners_table', 1),
(89, '2021_01_15_000823_create_gallary_tags_table', 1),
(90, '2021_01_15_000824_add_index_to_billers', 1),
(91, '2021_01_15_000824_add_index_to_blog_news_detail', 1),
(92, '2021_01_15_000824_add_index_to_category_detail', 1),
(93, '2021_01_15_000824_add_index_to_compares', 1),
(94, '2021_01_15_000824_add_index_to_coupon_setting', 1),
(95, '2021_01_15_000824_add_index_to_customers', 1),
(96, '2021_01_15_000824_add_index_to_languages', 1),
(97, '2021_01_15_000824_add_index_to_products', 1),
(98, '2021_01_15_000824_add_index_to_purchase_detail', 1),
(99, '2021_01_15_000824_add_index_to_purchaser', 1),
(100, '2021_01_15_000824_add_index_to_settings', 1),
(101, '2021_01_15_000824_add_index_to_warehouses', 1),
(102, '2021_01_15_000824_add_index_to_wishlist', 1),
(103, '2021_01_15_000824_add_name_index_to_attributes', 1),
(104, '2021_01_15_000824_add_name_index_to_blog_category_detail', 1),
(105, '2021_01_15_000824_add_name_index_to_brands', 1),
(106, '2021_01_15_000824_add_name_index_to_countries', 1),
(107, '2021_01_15_000824_add_name_index_to_payment_method_descriptions', 1),
(108, '2021_01_15_000824_add_name_index_to_roles', 1),
(109, '2021_01_15_000824_add_name_index_to_shipping_method_descriptions', 1),
(110, '2021_01_15_000824_add_name_index_to_states', 1),
(111, '2021_01_15_000824_add_name_index_to_tags', 1),
(112, '2021_01_15_000824_add_name_index_to_unit_detail', 1),
(113, '2021_01_15_000824_add_name_index_to_variation_detail', 1),
(114, '2021_01_15_000824_add_title_index_to_currency', 1),
(115, '2021_01_15_000824_add_title_index_to_taxes', 1),
(116, '2021_01_15_000824_create_stock_transfer_table', 1),
(117, '2021_01_15_000825_create_stock_transfer_detail_table', 1),
(118, '2021_03_03_000001_create_default_accounts_table', 1),
(119, '2021_03_03_000001_create_transaction_detail_table', 1),
(120, '2021_03_17_211132_create_product_gallary_details_table', 1),
(121, '2021_03_17_211132_custom_css_js', 1),
(122, '2021_03_17_211132_newsletter', 1),
(123, '2021_03_17_211132_points', 1),
(124, '2021_04_14_543267_membership', 1),
(125, '2021_07_27_070947_create_constant_banners_table', 1),
(126, '2021_07_29_055141_create_menu_builders_table', 1),
(127, '2021_08_25_065329_create_home_banners_table', 1),
(128, '2021_08_30_133500_create_localizations_table', 1),
(129, '2021_10_13_114940_create_delivery_boys_table', 1),
(130, '2021_10_18_100836_create_order_histories_table', 1),
(131, '2021_10_18_122142_create_order_comments_table', 1),
(132, '2021_10_18_122255_create_order_notes_table', 1),
(133, '2021_10_22_100324_create_user_warehouses_table', 1),
(134, '2021_11_22_130939_create_demo_settings_table', 1),
(135, '2022_01_28_205331_create_sale_quotations_table', 1),
(136, '2022_01_28_205448_create_sale_quotation_details_table', 1),
(137, '2022_08_10_111139_create_cities_table', 1),
(138, '2022_08_12_101825_create_shippment_with_cities_table', 1),
(139, '2022_11_07_104933_create_jobs_table', 1),
(140, '2022_11_14_120922_create_newsletter_contacts_table', 1),
(141, '2023_51_19_000000_create_avaliable_qty_table', 1),
(142, '2023_51_19_000000_create_current_value_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Enable','Disable') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mailchip_api` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mailchip_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_contacts`
--

CREATE TABLE `newsletter_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('893294ead6999f58caab821943df57feb60f692101b566d82ed8bcfe8ff18000ead38788f6ff4417', 1, 1, 'MyApp', '[\"user\"]', 0, '2022-12-21 02:14:39', '2022-12-21 02:14:39', '2023-12-21 04:14:39'),
('dba83acdf4b5d0560d57bf59f1555c5045b8071fa9956cfd99e4320e5f1ac4f17493f16676b175f6', 1, 1, 'MyApp', '[\"user\"]', 0, '2022-12-17 19:47:11', '2022-12-17 19:47:11', '2023-12-17 21:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Personal Access Client', 'oyMe9OSFrJ32gSzfVkiRmmjxHTr45uqinfcZe67h', NULL, 'http://localhost:8000', 1, 0, 0, '2022-12-17 19:37:13', '2022-12-17 19:37:13'),
(2, NULL, 'Personal Access Client', 'Gjje2fZBOGPJ3Xr7iL8HZdoheI5ZluwQsM6OzSsR', NULL, 'http://localhost:8000', 1, 0, 0, '2022-12-17 19:37:13', '2022-12-17 19:37:13'),
(3, NULL, 'Hand-Schmidt', '3Jivo04EWDkVdea54yPGoEh53kOOrTciEZcFKbmF', NULL, 'http://www.vandervort.org/', 0, 1, 0, '2022-12-17 19:37:14', '2022-12-17 19:37:14');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-12-17 19:37:13', '2022-12-17 19:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_boy_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_from` enum('androidapp','iosapp','web','pos','addsale') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'androidapp',
  `billing_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_street_aadress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_suburb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_state` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_street_aadress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_suburb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_country` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_state` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `latlong` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_owner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_expiry` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_value` double(8,2) DEFAULT NULL,
  `order_price` double(8,2) DEFAULT NULL,
  `shipping_cost` double(8,2) DEFAULT NULL,
  `shipping_method` enum('shippingByWeight','localPickup','freeShipping','flateRate') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 for seen & 0 for unseen',
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_amount` double(8,2) DEFAULT NULL,
  `payment_method` enum('cod','paypal','authorize_net','stripe','banktransfer','mollie','instamojo','braintree','hyperpay','razorpay','paytm','paystack','midtrans','wallet','fygaro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_status` enum('Pending','Inprocess','Dispatched','Complete','Return','Cancel','Shipped') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `total_tax` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_comments`
--

CREATE TABLE `order_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_price` double(8,2) DEFAULT NULL,
  `product_tax` double(8,2) DEFAULT NULL,
  `product_discount` double(8,2) DEFAULT NULL,
  `total` double(8,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_histories`
--

CREATE TABLE `order_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_status` enum('Pending','Inprocess','Dispatched','Complete','Return','Cancel','Shipped') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE `order_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'about-us', NULL, NULL, NULL, NULL, NULL),
(2, 'refund-policy', NULL, NULL, NULL, NULL, NULL),
(3, 'privacy-policy', NULL, NULL, NULL, NULL, NULL),
(4, 'terms-and-conditions', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_detail`
--

CREATE TABLE `page_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_detail`
--

INSERT INTO `page_detail` (`id`, `title`, `description`, `language_id`, `page_id`, `created_at`, `updated_at`) VALUES
(1, 'About Us', '<p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>', 1, 1, NULL, NULL),
(2, 'معلومات عنا', '<p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        \r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>', 2, 1, NULL, NULL),
(3, 'Refund Policy', '<p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>', 1, 2, NULL, NULL),
(4, 'سياسة الاسترجاع', '<p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        \r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>', 2, 2, NULL, NULL),
(5, 'Privacy Policy', '<p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>', 1, 3, NULL, NULL),
(6, 'سياسة خاصة', '<p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        \r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>', 2, 3, NULL, NULL),
(7, 'Terms and Conditions', '<p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>\r\n        <p>\r\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n        </p>', 1, 4, NULL, NULL),
(8, 'الأحكام والشروط', '<p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>\r\n        \r\n        <p>\r\n        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.\r\n        </p>\r\n        <p>\r\n        \r\n        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟ \r\n        علي الجانب الآخر نشجب ونستنكر هؤلاء الرجال المفتونون بنشوة اللحظة الهائمون في رغباتهم فلا يدركون ما يعقبها من الألم والأسي المحتم، واللوم كذلك يشمل هؤلاء الذين أخفقوا في واجباتهم نتيجة لضعف إرادتهم فيتساوي مع هؤلاء الذين يتجنبون وينأون عن تحمل الكدح والألم .\r\n                   \r\n        </p>', 2, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active 0 for inactive',
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `environment` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 for active 0 for inactive',
  `type` enum('cod','banktransfer','card','webview') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `payment_method`, `title`, `status`, `default`, `environment`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'paypal', 'paypal', 1, 0, 0, 'card', NULL, 1, '2022-12-17 19:37:39', '2022-12-17 22:20:15'),
(2, 'stripe', 'stripe', 1, 0, 0, 'card', NULL, 1, '2022-12-17 19:37:39', '2022-12-17 22:20:20'),
(3, 'banktransfer', 'banktransfer', 1, 0, 0, 'banktransfer', NULL, 1, '2022-12-17 19:37:39', '2022-12-17 22:20:32'),
(4, 'cod', 'cod', 1, 0, 0, 'cod', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(5, 'braintree', 'braintree', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(6, 'authorize_net', 'authorize_net', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(7, 'mollie', 'mollie', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(8, 'sagepay', 'sagepay', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(9, 'razorpay', 'razorpay', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(10, 'paytm', 'paytm', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(11, 'paystack', 'paystack', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(12, 'wallet', 'wallet', 1, 0, 0, 'cod', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39'),
(13, 'fygaro', 'fygaro', 1, 0, 0, 'webview', NULL, NULL, '2022-12-17 19:37:39', '2022-12-17 19:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_descriptions`
--

CREATE TABLE `payment_method_descriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `sub_name_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_name_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_method_descriptions`
--

INSERT INTO `payment_method_descriptions` (`id`, `payment_method_id`, `name`, `language_id`, `sub_name_1`, `sub_name_2`) VALUES
(1, 1, 'Braintree', 1, 'Braintree', 'Braintree');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_settings`
--

CREATE TABLE `payment_method_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_method_settings`
--

INSERT INTO `payment_method_settings` (`id`, `payment_method_id`, `key`, `value`) VALUES
(37, 1, 'PAYPAL_API_USERNAME', 'sb-cwqvm941213_api1.business.example.com'),
(38, 1, 'PAYPAL_API_PASSWORD', 'VH2KQNCZE3HDXUU7'),
(39, 1, 'PAYPAL_API_SIGNATURE', 'A7lRxa76xmHCL33PX02qN6zIbG7iAi0V.vGofZ9iT8c3NTOhP4zDHldo'),
(40, 2, 'STRIPE_API_KEY', 'sk_test_EdlHXXNPrUkesCURiqVqrneU00kKeCNpor'),
(41, 3, 'BANK_TRANSFER_NAME', '--'),
(42, 3, 'BANK_TRANSFER_DETAIL', '--'),
(43, 3, 'BANK_TRANSFER_ACC_NAME', '--'),
(44, 3, 'BANK_TRANSFER_ACC_NUM', '--'),
(45, 3, 'BANK_TRANSFER_BANK_NAME', '--'),
(46, 3, 'BANK_TRANSFER_IFSC', '--'),
(47, 3, 'BANK_TRANSFER_IBAN', '--'),
(48, 3, 'BANK_TRANSFER_BIC_SWIFT', '--'),
(49, 5, 'MERCHANT_ID', '6hbm963vhchw8vhr'),
(50, 5, 'PUBLIC_KEY', '6c4ymbfrbsxqhbrj'),
(51, 5, 'PRIVATE_KEY', '3d77996a1a73538c2fef93b546bf2ddf'),
(52, 6, 'APP_LOGIN_ID', '7AV6M4k2p6mW'),
(53, 6, 'TRANSACTION_KEY', '56VMgKYpm7695r4C'),
(54, 6, 'KEY', 'Simon'),
(55, 7, 'API_KEY', '--'),
(56, 8, 'YOUR-VENDOR-CODE', '--'),
(57, 9, 'KEY', '--'),
(58, 10, 'kEY_ID', 'rzp_test_YSTH90m9DEc0FQ'),
(59, 10, 'KEY_SECRET', 'IhFlrifl3NnheLh2jtEuirgO'),
(60, 11, 'YOUR_MERCHANT_ID', '--'),
(61, 11, 'YOUR_MERCHANT_KEY', '--'),
(62, 11, 'YOUR_WEBSITE', '--'),
(63, 11, 'YOUR_CHANNEL', '--'),
(64, 11, 'YOUR_INDUSTRY_TYPE', '--'),
(65, 12, 'PAYSTACK_PUBLIC_KEY', 'pk_test_6427b2a59d1619ff48db15945be380fa6616a15d'),
(66, 12, 'PAYSTACK_SECRET_KEY', 'sk_test_f29dcc0597d53da59f33fa17c35a265cd30e1a66'),
(67, 12, 'PAYSTACK_PAYMENT_URL', 'https://paystack.com/pay/uax047t8wu'),
(68, 12, 'MERCHANT_EMAIL', 'ui.themescoder@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `key`, `value`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'dashboard', '0', NULL, NULL),
(2, 'Media Module', 'media', '0', NULL, NULL),
(3, 'Media Settings', 'media-settings', '2', NULL, NULL),
(4, 'Manage Media', 'manage-media', '2', NULL, NULL),
(5, 'Catalog', 'catalog', '0', NULL, NULL),
(6, 'Product Unit', 'product-unit-list', '5', NULL, NULL),
(7, 'Manage Product Unit', 'product-unit-manage', '5', NULL, NULL),
(8, 'Product Attribute', 'product-attribute-list', '5', NULL, NULL),
(9, 'Manage Product Attribute', 'product-attribute-manage', '5', NULL, NULL),
(10, 'Product Variation', 'product-variation-list', '5', NULL, NULL),
(11, 'Manage Product Variation', 'product-variation-manage', '5', NULL, NULL),
(12, 'Product Brand', 'product-brand-list', '5', NULL, NULL),
(13, 'Manage Product Brand', 'product-brand-manage', '5', NULL, NULL),
(14, 'Product Category', 'product-category-list', '5', NULL, NULL),
(15, 'Manage Product Category', 'product-category-manage', '5', NULL, NULL),
(16, 'Product', 'product-list', '5', NULL, NULL),
(17, 'Manage Product', 'product-manage', '5', NULL, NULL),
(18, 'Product Reviews', 'product-reviews', '5', NULL, NULL),
(19, 'Stock', 'stock', '0', NULL, NULL),
(20, 'Stock List', 'stock-list', '19', NULL, NULL),
(21, 'Manage Stock', 'stock-manage', '19', NULL, NULL),
(22, 'Stock Transfer', 'stock-transfer-list', '19', NULL, NULL),
(23, 'Manage Stock Transfer', 'stock-transfer-manage', '19', NULL, NULL),
(24, 'Quotations', 'quotation-list', '0', NULL, NULL),
(25, 'Manage Quotations', 'quotation-manage', '24', NULL, NULL),
(26, 'Purchase', 'purchase-list', '0', NULL, NULL),
(27, 'Manage Purchase', 'purchase-manage', '26', NULL, NULL),
(28, 'Sale/Order', 'sale-order', '0', NULL, NULL),
(29, 'Sale List', 'sale-list', '28', NULL, NULL),
(30, 'Manage Sale', 'sale-manage', '28', NULL, NULL),
(31, 'Order', 'order-list', '28', NULL, NULL),
(32, 'POS', 'pos', '28', NULL, NULL),
(33, 'Returns', 'return', '0', NULL, NULL),
(34, 'Sale Return List', 'sale-return-list', '33', NULL, NULL),
(35, 'Manage Sale Return', 'sale-return-manage', '33', NULL, NULL),
(36, 'Purchase Return List', 'purchase-return-list', '33', NULL, NULL),
(37, 'Manage Purchase Return', 'purchase-return-manage', '33', NULL, NULL),
(38, 'Accounts', 'account', '0', NULL, NULL),
(39, 'Account List', 'account-list', '38', NULL, NULL),
(40, 'Manage Accounts', 'account-manage', '38', NULL, NULL),
(41, 'Ledger Report', 'ledger-report', '38', NULL, NULL),
(42, 'Assets Adjustment', 'assets-adjustment', '38', NULL, NULL),
(43, 'Payments', 'payment', '38', NULL, NULL),
(44, 'Reciepts', 'reciepts', '38', NULL, NULL),
(45, 'Expense', 'expense', '38', NULL, NULL),
(46, 'Blog/News', 'blog-list', '0', NULL, NULL),
(47, 'Blog/News List', 'blog-list', '46', NULL, NULL),
(48, 'Manage Blog/News', 'blog-manage', '46', NULL, NULL),
(49, 'Content Page', 'content-page-manage', '0', NULL, NULL),
(50, 'Content Page', 'content-page-manage', '49', NULL, NULL),
(51, 'People', 'people', '0', NULL, NULL),
(52, 'Roles', 'role-list', '51', NULL, NULL),
(53, 'Manage Roles', 'role-manage', '51', NULL, NULL),
(54, 'Customers', 'customer-list', '51', NULL, NULL),
(55, 'Manage Customers', 'customer-manage', '51', NULL, NULL),
(56, 'Purchaser', 'purchaser-list', '51', NULL, NULL),
(57, 'Manage Purchaser', 'purchaser-manage', '51', NULL, NULL),
(58, 'Users', 'user-list', '51', NULL, NULL),
(59, 'Manage Users', 'user-manage', '51', NULL, NULL),
(60, 'Business Settings', 'business-setting', '0', NULL, NULL),
(61, 'General Settings', 'general-setting', '60', NULL, NULL),
(62, 'Warehouses', 'warehouse-list', '60', NULL, NULL),
(63, 'Warehouse', 'warehouse-manage', '60', NULL, NULL),
(64, 'Language', 'language-list', '60', NULL, NULL),
(65, 'Manage Language', 'language-manage', '60', NULL, NULL),
(66, 'Currency', 'currency-list', '60', NULL, NULL),
(67, 'Manage Currency', 'currency-manage', '60', NULL, NULL),
(68, 'Payement Methods', 'payment-methods-list', '60', NULL, NULL),
(69, 'Manage Payement Methods', 'payment-methods-manage', '60', NULL, NULL),
(70, 'Shipping Methods', 'shipping-methods-list', '60', NULL, NULL),
(71, 'Manage Shipping Methods', 'shipping-methods-manage', '60', NULL, NULL),
(72, 'Tax Settings', 'tax-setting-list', '60', NULL, NULL),
(73, 'Manage Tax Settings', 'tax-setting-manage', '60', NULL, NULL),
(74, 'Tax Rate Settings', 'tax-setting-rate-list', '60', NULL, NULL),
(75, 'Manage Tax Rate Settings', 'tax-setting-rate-manage', '60', NULL, NULL),
(76, 'Coupon Settings', 'coupon-list', '60', NULL, NULL),
(77, 'Manage Coupon Settings', 'coupon-manage', '60', NULL, NULL),
(78, 'Website Settings', 'website-setting', '0', NULL, NULL),
(79, 'Home Page Builder', 'home-page-builder', '78', NULL, NULL),
(80, 'Slider Banner Settings', 'slider-bannder-list', '78', NULL, NULL),
(81, 'Manage Slider Banner Settings', 'slider-bannder-manage', '78', NULL, NULL),
(82, 'Constant Banner Settings', 'constant-bannder-list', '78', NULL, NULL),
(83, 'Manage Constant Banner Settings', 'constant-bannder-manage', '78', NULL, NULL),
(84, 'Parrallex Banner Settings', 'parrallex-bannder-list', '78', NULL, NULL),
(85, 'Manage Parrallex Banner Settings', 'parrallex-bannder-manage', '78', NULL, NULL),
(86, 'Menu Builder', 'menu-builder', '78', NULL, NULL),
(87, 'Mobile App Settings', 'mobile-setting', '0', NULL, NULL),
(88, 'Mobile General Settings', 'mobile-general-setting', '87', NULL, NULL),
(89, 'Mobile Slider Banner', 'mobile-slider-bannder-list', '87', NULL, NULL),
(90, 'Manage Mobile Slider Banner', 'mobile-slider-bannder-manage', '87', NULL, NULL),
(91, 'Delivery Boy', 'delivery-boy-list', '0', NULL, NULL),
(92, 'Delivery Boy List', 'delivery-boy-list', '91', NULL, NULL),
(93, 'Manage Delivery Boy', 'manage-delivery-boy', '91', NULL, NULL),
(94, 'Suplier', 'supplier-list', '51', NULL, NULL),
(95, 'Manage Supplier', 'supplier-manage', '51', NULL, NULL),
(96, 'Sale Quotations', 'quotation-sale-list', '24', NULL, NULL),
(97, 'Manage Sale Quotations', 'quotation-sale-manage', '24', NULL, NULL),
(98, 'Reports', 'manage-reports', '0', NULL, NULL),
(99, 'Reports', 'manage-reports', '98', NULL, NULL),
(100, 'Country Settings', 'country-list', '60', NULL, NULL),
(101, 'Manage Country Settings', 'country-manage', '60', NULL, NULL),
(102, 'State Settings', 'state-list', '60', NULL, NULL),
(103, 'Manage State Settings', 'state-manage', '60', NULL, NULL),
(104, 'City Settings', 'city-list', '60', NULL, NULL),
(105, 'Manage City Settings', 'city-manage', '60', NULL, NULL),
(106, 'Shippment With City Settings', 'shippment-with-city-list', '60', NULL, NULL),
(107, 'Manage Shippment With City Settings', 'shippment-with-city-manage', '60', NULL, NULL),
(108, 'Import Settings', 'import-product', '60', NULL, NULL),
(109, 'NewsletterContact Settings', 'NewsletterContact-list', '60', NULL, NULL),
(110, 'Manage NewsletterContact Settings', 'NewsletterContact-delete', '60', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL),
(2, 2, 1, 1, NULL, NULL, NULL),
(3, 3, 1, 1, NULL, NULL, NULL),
(4, 4, 1, 1, NULL, NULL, NULL),
(5, 5, 1, 1, NULL, NULL, NULL),
(6, 6, 1, 1, NULL, NULL, NULL),
(7, 7, 1, 1, NULL, NULL, NULL),
(8, 8, 1, 1, NULL, NULL, NULL),
(9, 9, 1, 1, NULL, NULL, NULL),
(10, 10, 1, 1, NULL, NULL, NULL),
(11, 11, 1, 1, NULL, NULL, NULL),
(12, 12, 1, 1, NULL, NULL, NULL),
(13, 13, 1, 1, NULL, NULL, NULL),
(14, 14, 1, 1, NULL, NULL, NULL),
(15, 15, 1, 1, NULL, NULL, NULL),
(16, 16, 1, 1, NULL, NULL, NULL),
(17, 17, 1, 1, NULL, NULL, NULL),
(18, 18, 1, 1, NULL, NULL, NULL),
(19, 19, 1, 1, NULL, NULL, NULL),
(20, 20, 1, 1, NULL, NULL, NULL),
(21, 21, 1, 1, NULL, NULL, NULL),
(22, 22, 1, 1, NULL, NULL, NULL),
(23, 23, 1, 1, NULL, NULL, NULL),
(24, 24, 1, 1, NULL, NULL, NULL),
(25, 25, 1, 1, NULL, NULL, NULL),
(26, 26, 1, 1, NULL, NULL, NULL),
(27, 27, 1, 1, NULL, NULL, NULL),
(28, 28, 1, 1, NULL, NULL, NULL),
(29, 29, 1, 1, NULL, NULL, NULL),
(30, 30, 1, 1, NULL, NULL, NULL),
(31, 31, 1, 1, NULL, NULL, NULL),
(32, 32, 1, 1, NULL, NULL, NULL),
(33, 33, 1, 1, NULL, NULL, NULL),
(34, 34, 1, 1, NULL, NULL, NULL),
(35, 35, 1, 1, NULL, NULL, NULL),
(36, 36, 1, 1, NULL, NULL, NULL),
(37, 37, 1, 1, NULL, NULL, NULL),
(38, 38, 1, 1, NULL, NULL, NULL),
(39, 39, 1, 1, NULL, NULL, NULL),
(40, 40, 1, 1, NULL, NULL, NULL),
(41, 41, 1, 1, NULL, NULL, NULL),
(42, 42, 1, 1, NULL, NULL, NULL),
(43, 43, 1, 1, NULL, NULL, NULL),
(44, 44, 1, 1, NULL, NULL, NULL),
(45, 45, 1, 1, NULL, NULL, NULL),
(46, 46, 1, 1, NULL, NULL, NULL),
(47, 47, 1, 1, NULL, NULL, NULL),
(48, 48, 1, 1, NULL, NULL, NULL),
(49, 49, 1, 1, NULL, NULL, NULL),
(50, 50, 1, 1, NULL, NULL, NULL),
(51, 51, 1, 1, NULL, NULL, NULL),
(52, 52, 1, 1, NULL, NULL, NULL),
(53, 53, 1, 1, NULL, NULL, NULL),
(54, 54, 1, 1, NULL, NULL, NULL),
(55, 55, 1, 1, NULL, NULL, NULL),
(56, 56, 1, 1, NULL, NULL, NULL),
(57, 57, 1, 1, NULL, NULL, NULL),
(58, 58, 1, 1, NULL, NULL, NULL),
(59, 59, 1, 1, NULL, NULL, NULL),
(60, 60, 1, 1, NULL, NULL, NULL),
(61, 61, 1, 1, NULL, NULL, NULL),
(62, 62, 1, 1, NULL, NULL, NULL),
(63, 63, 1, 1, NULL, NULL, NULL),
(64, 64, 1, 1, NULL, NULL, NULL),
(65, 65, 1, 1, NULL, NULL, NULL),
(66, 66, 1, 1, NULL, NULL, NULL),
(67, 67, 1, 1, NULL, NULL, NULL),
(68, 68, 1, 1, NULL, NULL, NULL),
(69, 69, 1, 1, NULL, NULL, NULL),
(70, 70, 1, 1, NULL, NULL, NULL),
(71, 71, 1, 1, NULL, NULL, NULL),
(72, 72, 1, 1, NULL, NULL, NULL),
(73, 73, 1, 1, NULL, NULL, NULL),
(74, 74, 1, 1, NULL, NULL, NULL),
(75, 75, 1, 1, NULL, NULL, NULL),
(76, 76, 1, 1, NULL, NULL, NULL),
(77, 77, 1, 1, NULL, NULL, NULL),
(78, 78, 1, 1, NULL, NULL, NULL),
(79, 79, 1, 1, NULL, NULL, NULL),
(80, 80, 1, 1, NULL, NULL, NULL),
(81, 81, 1, 1, NULL, NULL, NULL),
(82, 82, 1, 1, NULL, NULL, NULL),
(83, 83, 1, 1, NULL, NULL, NULL),
(84, 84, 1, 1, NULL, NULL, NULL),
(85, 85, 1, 1, NULL, NULL, NULL),
(86, 86, 1, 1, NULL, NULL, NULL),
(87, 87, 1, 1, NULL, NULL, NULL),
(88, 88, 1, 1, NULL, NULL, NULL),
(89, 89, 1, 1, NULL, NULL, NULL),
(90, 90, 1, 1, NULL, NULL, NULL),
(91, 91, 1, 1, NULL, NULL, NULL),
(92, 92, 1, 1, NULL, NULL, NULL),
(93, 93, 1, 1, NULL, NULL, NULL),
(94, 94, 1, 1, NULL, NULL, NULL),
(95, 95, 1, 1, NULL, NULL, NULL),
(96, 96, 1, 1, NULL, NULL, NULL),
(97, 97, 1, 1, NULL, NULL, NULL),
(98, 98, 1, 1, NULL, NULL, NULL),
(99, 99, 1, 1, NULL, NULL, NULL),
(100, 100, 1, 1, NULL, NULL, NULL),
(101, 101, 1, 1, NULL, NULL, NULL),
(102, 102, 1, 1, NULL, NULL, NULL),
(103, 103, 1, 1, NULL, NULL, NULL),
(104, 104, 1, 1, NULL, NULL, NULL),
(105, 105, 1, 1, NULL, NULL, NULL),
(106, 106, 1, 1, NULL, NULL, NULL),
(107, 107, 1, 1, NULL, NULL, NULL),
(108, 108, 1, 1, NULL, NULL, NULL),
(109, 109, 1, 1, NULL, NULL, NULL),
(110, 110, 1, 1, NULL, NULL, NULL),
(111, 1, 2, 1, NULL, NULL, NULL),
(112, 2, 2, 1, NULL, NULL, NULL),
(113, 3, 2, 1, NULL, NULL, NULL),
(114, 4, 2, 1, NULL, NULL, NULL),
(115, 5, 2, 1, NULL, NULL, NULL),
(116, 6, 2, 1, NULL, NULL, NULL),
(117, 7, 2, 1, NULL, NULL, NULL),
(118, 8, 2, 1, NULL, NULL, NULL),
(119, 9, 2, 1, NULL, NULL, NULL),
(120, 10, 2, 1, NULL, NULL, NULL),
(121, 11, 2, 1, NULL, NULL, NULL),
(122, 12, 2, 1, NULL, NULL, NULL),
(123, 13, 2, 1, NULL, NULL, NULL),
(124, 14, 2, 1, NULL, NULL, NULL),
(125, 15, 2, 1, NULL, NULL, NULL),
(126, 16, 2, 1, NULL, NULL, NULL),
(127, 17, 2, 1, NULL, NULL, NULL),
(128, 18, 2, 1, NULL, NULL, NULL),
(129, 19, 2, 1, NULL, NULL, NULL),
(130, 20, 2, 1, NULL, NULL, NULL),
(131, 21, 2, 1, NULL, NULL, NULL),
(132, 22, 2, 1, NULL, NULL, NULL),
(133, 23, 2, 1, NULL, NULL, NULL),
(134, 24, 2, 1, NULL, NULL, NULL),
(135, 25, 2, 1, NULL, NULL, NULL),
(136, 26, 2, 1, NULL, NULL, NULL),
(137, 27, 2, 1, NULL, NULL, NULL),
(138, 28, 2, 1, NULL, NULL, NULL),
(139, 29, 2, 1, NULL, NULL, NULL),
(140, 30, 2, 1, NULL, NULL, NULL),
(141, 31, 2, 1, NULL, NULL, NULL),
(142, 32, 2, 1, NULL, NULL, NULL),
(143, 33, 2, 1, NULL, NULL, NULL),
(144, 34, 2, 1, NULL, NULL, NULL),
(145, 35, 2, 1, NULL, NULL, NULL),
(146, 36, 2, 1, NULL, NULL, NULL),
(147, 37, 2, 1, NULL, NULL, NULL),
(148, 38, 2, 1, NULL, NULL, NULL),
(149, 39, 2, 1, NULL, NULL, NULL),
(150, 40, 2, 1, NULL, NULL, NULL),
(151, 41, 2, 1, NULL, NULL, NULL),
(152, 42, 2, 1, NULL, NULL, NULL),
(153, 43, 2, 1, NULL, NULL, NULL),
(154, 44, 2, 1, NULL, NULL, NULL),
(155, 45, 2, 1, NULL, NULL, NULL),
(156, 46, 2, 1, NULL, NULL, NULL),
(157, 47, 2, 1, NULL, NULL, NULL),
(158, 48, 2, 1, NULL, NULL, NULL),
(159, 49, 2, 1, NULL, NULL, NULL),
(160, 50, 2, 1, NULL, NULL, NULL),
(161, 51, 2, 1, NULL, NULL, NULL),
(162, 52, 2, 1, NULL, NULL, NULL),
(163, 53, 2, 1, NULL, NULL, NULL),
(164, 54, 2, 1, NULL, NULL, NULL),
(165, 55, 2, 1, NULL, NULL, NULL),
(166, 56, 2, 1, NULL, NULL, NULL),
(167, 57, 2, 1, NULL, NULL, NULL),
(168, 58, 2, 1, NULL, NULL, NULL),
(169, 59, 2, 1, NULL, NULL, NULL),
(170, 78, 2, 1, NULL, NULL, NULL),
(171, 79, 2, 1, NULL, NULL, NULL),
(172, 80, 2, 1, NULL, NULL, NULL),
(173, 81, 2, 1, NULL, NULL, NULL),
(174, 82, 2, 1, NULL, NULL, NULL),
(175, 83, 2, 1, NULL, NULL, NULL),
(176, 84, 2, 1, NULL, NULL, NULL),
(177, 85, 2, 1, NULL, NULL, NULL),
(178, 86, 2, 1, NULL, NULL, NULL),
(179, 87, 2, 1, NULL, NULL, NULL),
(180, 88, 2, 1, NULL, NULL, NULL),
(181, 89, 2, 1, NULL, NULL, NULL),
(182, 90, 2, 1, NULL, NULL, NULL),
(183, 91, 2, 1, NULL, NULL, NULL),
(184, 92, 2, 1, NULL, NULL, NULL),
(185, 93, 2, 1, NULL, NULL, NULL),
(186, 94, 2, 1, NULL, NULL, NULL),
(187, 95, 2, 1, NULL, NULL, NULL),
(188, 96, 2, 1, NULL, NULL, NULL),
(189, 97, 2, 1, NULL, NULL, NULL),
(190, 98, 2, 1, NULL, NULL, NULL),
(191, 99, 2, 1, NULL, NULL, NULL),
(192, 28, 3, 1, NULL, NULL, NULL),
(193, 32, 3, 1, NULL, NULL, NULL),
(194, 24, 4, 1, NULL, NULL, NULL),
(195, 25, 4, 1, NULL, NULL, NULL),
(196, 26, 4, 1, NULL, NULL, NULL),
(197, 27, 4, 1, NULL, NULL, NULL),
(198, 38, 5, 1, NULL, NULL, NULL),
(199, 39, 5, 1, NULL, NULL, NULL),
(200, 40, 5, 1, NULL, NULL, NULL),
(201, 41, 5, 1, NULL, NULL, NULL),
(202, 42, 5, 1, NULL, NULL, NULL),
(203, 43, 5, 1, NULL, NULL, NULL),
(204, 44, 5, 1, NULL, NULL, NULL),
(205, 45, 5, 1, NULL, NULL, NULL),
(206, 2, 6, 1, NULL, NULL, NULL),
(207, 3, 6, 1, NULL, NULL, NULL),
(208, 4, 6, 1, NULL, NULL, NULL),
(209, 5, 6, 1, NULL, NULL, NULL),
(210, 6, 6, 1, NULL, NULL, NULL),
(211, 7, 6, 1, NULL, NULL, NULL),
(212, 8, 6, 1, NULL, NULL, NULL),
(213, 9, 6, 1, NULL, NULL, NULL),
(214, 10, 6, 1, NULL, NULL, NULL),
(215, 11, 6, 1, NULL, NULL, NULL),
(216, 12, 6, 1, NULL, NULL, NULL),
(217, 13, 6, 1, NULL, NULL, NULL),
(218, 14, 6, 1, NULL, NULL, NULL),
(219, 15, 6, 1, NULL, NULL, NULL),
(220, 16, 6, 1, NULL, NULL, NULL),
(221, 17, 6, 1, NULL, NULL, NULL),
(222, 18, 6, 1, NULL, NULL, NULL),
(223, 24, 6, 1, NULL, NULL, NULL),
(224, 25, 6, 1, NULL, NULL, NULL),
(225, 26, 6, 1, NULL, NULL, NULL),
(226, 27, 6, 1, NULL, NULL, NULL),
(227, 28, 6, 1, NULL, NULL, NULL),
(228, 29, 6, 1, NULL, NULL, NULL),
(229, 30, 6, 1, NULL, NULL, NULL),
(230, 31, 6, 1, NULL, NULL, NULL),
(231, 32, 6, 1, NULL, NULL, NULL),
(232, 33, 6, 1, NULL, NULL, NULL),
(233, 34, 6, 1, NULL, NULL, NULL),
(234, 35, 6, 1, NULL, NULL, NULL),
(235, 36, 6, 1, NULL, NULL, NULL),
(236, 37, 6, 1, NULL, NULL, NULL),
(237, 96, 6, 1, NULL, NULL, NULL),
(238, 97, 6, 1, NULL, NULL, NULL),
(239, 2, 7, 1, NULL, NULL, NULL),
(240, 3, 7, 1, NULL, NULL, NULL),
(241, 4, 7, 1, NULL, NULL, NULL),
(242, 5, 7, 1, NULL, NULL, NULL),
(243, 6, 7, 1, NULL, NULL, NULL),
(244, 7, 7, 1, NULL, NULL, NULL),
(245, 8, 7, 1, NULL, NULL, NULL),
(246, 9, 7, 1, NULL, NULL, NULL),
(247, 10, 7, 1, NULL, NULL, NULL),
(248, 11, 7, 1, NULL, NULL, NULL),
(249, 12, 7, 1, NULL, NULL, NULL),
(250, 13, 7, 1, NULL, NULL, NULL),
(251, 14, 7, 1, NULL, NULL, NULL),
(252, 15, 7, 1, NULL, NULL, NULL),
(253, 16, 7, 1, NULL, NULL, NULL),
(254, 17, 7, 1, NULL, NULL, NULL),
(255, 18, 7, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `points` double(8,2) DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('checkin_point','product_share_point','invite_friend_share_point','register_points','per_order_point','redeem') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '0' COMMENT 'o for not redeem 1 for redeem',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_type` enum('simple','variable','digital') COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `discount_price` double(8,2) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `product_weight` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digital_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_view` int(11) DEFAULT NULL,
  `is_featured` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for not featured & 1 for featured',
  `product_min_order` int(11) DEFAULT NULL,
  `product_max_order` int(11) DEFAULT NULL,
  `seo_meta_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_points` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_type`, `product_slug`, `sku`, `video_url`, `gallary_id`, `price`, `discount_price`, `unit_id`, `product_weight`, `digital_file`, `product_status`, `brand_id`, `tax_id`, `product_view`, `is_featured`, `product_min_order`, `product_max_order`, `seo_meta_tag`, `seo_desc`, `is_points`, `user_id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'variable', 'Item1SKU', 'Item1SKU', NULL, 1, 150.00, 100.00, 1, '1000', '', 'active', NULL, NULL, NULL, 1, 1, 5, 'Item 1 Item 1 Item 1 Item 1 Item 1', 'Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1', '1', 1, 1, NULL, NULL, '2022-12-17 21:01:30', '2022-12-17 21:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

CREATE TABLE `product_attribute` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attribute`
--

INSERT INTO `product_attribute` (`id`, `product_id`, `attribute_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_combination`
--

CREATE TABLE `product_combination` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_combination`
--

INSERT INTO `product_combination` (`id`, `product_id`, `sku`, `price`, `gallary_id`) VALUES
(1, 1, 'Item1SKU', 150.00, 1),
(2, 1, 'Item1SKU', 150.00, 1),
(3, 1, 'Item1SKU', 150.00, 1),
(4, 1, 'Item1SKU', 150.00, 1),
(5, 1, 'Item1SKU', 150.00, 1),
(6, 1, 'Item1SKU', 150.00, 1),
(7, 1, 'Item1SKU', 150.00, 1),
(8, 1, 'Item1SKU', 150.00, 1),
(9, 1, 'Item1SKU', 150.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_combination_dtl`
--

CREATE TABLE `product_combination_dtl` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_combination_dtl`
--

INSERT INTO `product_combination_dtl` (`id`, `product_combination_id`, `variation_id`, `product_id`) VALUES
(1, 1, 1, 1),
(2, 1, 4, 1),
(3, 2, 1, 1),
(4, 2, 5, 1),
(5, 3, 1, 1),
(6, 3, 6, 1),
(7, 4, 2, 1),
(8, 4, 4, 1),
(9, 5, 2, 1),
(10, 5, 5, 1),
(11, 6, 2, 1),
(12, 6, 6, 1),
(13, 7, 3, 1),
(14, 7, 4, 1),
(15, 8, 3, 1),
(16, 8, 5, 1),
(17, 9, 3, 1),
(18, 9, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_comments`
--

CREATE TABLE `product_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_detail`
--

CREATE TABLE `product_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_detail`
--

INSERT INTO `product_detail` (`id`, `product_id`, `title`, `desc`, `language_id`) VALUES
(1, 1, 'Item 1', 'Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1 Item 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_gallary_details`
--

CREATE TABLE `product_gallary_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_gallary_details`
--

INSERT INTO `product_gallary_details` (`id`, `product_id`, `gallary_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-12-17 21:01:30', '2022-12-17 21:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_attribute_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`id`, `product_attribute_id`, `variation_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_date` date NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double(8,2) NOT NULL COMMENT 'total amount = item price * quantity!',
  `amount_paid` double(8,2) NOT NULL DEFAULT 0.00,
  `discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `amount_due` double(8,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `purchase_status` enum('complete','return') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'complete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaser`
--

CREATE TABLE `purchaser` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchaser`
--

INSERT INTO `purchaser` (`id`, `first_name`, `last_name`, `address`, `phone`, `mobile`, `country_id`, `state_id`, `city`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Default', 'Purchaser', 'New York, USA', '0123456789', '0123456789', 223, 43, 'New York', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `product_total` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE `purchase_return` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjustment` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gallary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Sent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `type` enum('sale','purchase') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sale',
  `shipping_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `tax_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `grand_total` double(8,2) NOT NULL DEFAULT 0.00,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `uuid`, `biller_id`, `supplier_id`, `customer_id`, `warehouse_id`, `tax_id`, `gallary_id`, `discount_amount`, `status`, `type`, `shipping_cost`, `tax_amount`, `grand_total`, `note`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '1', NULL, 1, NULL, 2, NULL, NULL, 0.00, 'Pending', 'purchase', 0.00, 0.00, 5000.00, NULL, 1, NULL, NULL, '2022-12-17 22:06:04', '2022-12-17 22:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

CREATE TABLE `quotation_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `qty` double(8,2) NOT NULL DEFAULT 0.00,
  `subtotal` double(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_detail`
--

INSERT INTO `quotation_detail` (`id`, `quotation_id`, `product_id`, `product_combination_id`, `price`, `qty`, `subtotal`) VALUES
(1, 1, 1, 1, 100.00, 50.00, 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', NULL, NULL, NULL, NULL, NULL),
(2, 'Admin', NULL, NULL, NULL, NULL, NULL),
(3, 'Biller', NULL, NULL, NULL, NULL, NULL),
(4, 'Purchaser', NULL, NULL, NULL, NULL, NULL),
(5, 'Accountant', NULL, NULL, NULL, NULL, NULL),
(6, 'Store Manager', NULL, NULL, NULL, NULL, NULL),
(7, 'Data Entry', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payable` double(8,2) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_amount` double(8,2) DEFAULT NULL,
  `amount_paid` double(8,2) DEFAULT NULL,
  `due_amount` double(8,2) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` double(8,2) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `total` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_quotations`
--

CREATE TABLE `sale_quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_address_book_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payable` double(8,2) DEFAULT NULL,
  `coupon_setting_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_amount` double(8,2) DEFAULT NULL,
  `amount_paid` double(8,2) DEFAULT NULL,
  `due_amount` double(8,2) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_quotation_details`
--

CREATE TABLE `sale_quotation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `total` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return`
--

CREATE TABLE `sale_return` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjustment` double(8,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details`
--

CREATE TABLE `sale_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('installer_env_settings','client_secret','business_general','pos','email_smtp','email_template','sms','invoice','barcode','website_general','seo','app_login_signup','website_login_signup','app_general','gallary_setting','store_setting','business_notification_setting','app_display_in_setting','app_notification_setting','web_theme_setting','point_setting','membership_setting','email_notify_setting','login_credential','is_purchased_setting','kundol_web_setting','business_firebase_setting','business_google_setting','wallet_setting') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'default_customer', '1', 'pos', NULL, NULL, NULL, NULL),
(2, 'default_biller', '1', 'pos', NULL, NULL, NULL, NULL),
(3, 'default_warehouse', '1', 'pos', NULL, NULL, NULL, NULL),
(4, 'no_of_products', '4', 'pos', NULL, NULL, NULL, NULL),
(5, 'mail_engine', 'test', 'email_smtp', NULL, NULL, NULL, NULL),
(6, 'smtp_host', 'smtp.gmail.com', 'email_smtp', NULL, NULL, NULL, NULL),
(7, 'smtp_port', '587', 'email_smtp', NULL, NULL, NULL, NULL),
(8, 'smtp_encription', '', 'email_smtp', NULL, NULL, NULL, NULL),
(9, 'smtp_username', 'islam.shaaban13@gmail.com', 'email_smtp', NULL, NULL, NULL, NULL),
(10, 'smtp_password', 'Kollomashy@0112', 'email_smtp', NULL, NULL, NULL, NULL),
(11, 'smtp_from_email', 'test', 'email_smtp', NULL, NULL, NULL, NULL),
(12, 'smtp_from_name', 'test', 'email_smtp', NULL, NULL, NULL, NULL),
(13, 'smtp_status', 'active', 'email_smtp', NULL, NULL, NULL, NULL),
(14, 'gateway', 'twilio', 'sms', NULL, NULL, NULL, NULL),
(15, 'twilio_sid', '111545738', 'sms', NULL, NULL, NULL, NULL),
(16, 'twilio_auth_token', '', 'sms', NULL, NULL, NULL, NULL),
(17, 'twilio_number', '12345678', 'sms', NULL, NULL, NULL, NULL),
(18, 'firebase_api_key', '12345678', 'sms', NULL, NULL, NULL, NULL),
(19, 'firebase_secret_key', '12345678', 'sms', NULL, NULL, NULL, NULL),
(20, 'invoice_logo', '/gallary/01-logo.png', 'invoice', NULL, NULL, NULL, NULL),
(21, 'invoice_address', 'New York, USA.', 'invoice', NULL, NULL, NULL, NULL),
(22, 'invoice_email', 'info@your-site.com', 'invoice', NULL, NULL, NULL, NULL),
(23, 'invoice_mobile', '0123456789', 'invoice', NULL, NULL, NULL, NULL),
(24, 'invoice_phone', '0123456789', 'invoice', NULL, NULL, NULL, NULL),
(25, 'invoice_prefix', 'TXN-', 'invoice', NULL, NULL, NULL, NULL),
(26, 'invoice_footer_content', 'your-site.com', 'invoice', NULL, NULL, NULL, NULL),
(27, 'barcode_style', 'abc 4x 45y dummy', 'barcode', NULL, NULL, NULL, NULL),
(28, 'barcode_site_name', '1', 'barcode', NULL, NULL, NULL, NULL),
(29, 'barcode_product_name', '1', 'barcode', NULL, NULL, NULL, NULL),
(30, 'barcode_price', '1', 'barcode', NULL, NULL, NULL, NULL),
(31, 'barcode_currency', '1', 'barcode', NULL, NULL, NULL, NULL),
(32, 'barcode_unit', '1', 'barcode', NULL, NULL, NULL, NULL),
(33, 'barcode_category', '1', 'barcode', NULL, NULL, NULL, NULL),
(34, 'barcode_variant', '1', 'barcode', NULL, NULL, NULL, NULL),
(35, 'barcode_product_image', '1', 'barcode', NULL, NULL, NULL, NULL),
(36, 'barcode_check_promotional_price', '1', 'barcode', NULL, NULL, NULL, NULL),
(37, 'site_name_or_logo', 'logo', 'website_general', NULL, NULL, NULL, NULL),
(38, 'site_name', 'LOGO', 'website_general', NULL, NULL, NULL, NULL),
(39, 'site_logo', '/gallary/01-logo.png', 'website_general', NULL, NULL, NULL, NULL),
(40, 'favicon', '/gallary/01-fav.png', 'website_general', NULL, NULL, NULL, NULL),
(41, 'facebook_url', 'https://facebook.com', 'website_general', NULL, NULL, NULL, NULL),
(42, 'google_url', 'https://google.com', 'website_general', NULL, NULL, NULL, NULL),
(43, 'twitter_url', 'https://twitter.com', 'website_general', NULL, NULL, NULL, NULL),
(44, 'linkedin_url', 'https://linkedin.com', 'website_general', NULL, NULL, NULL, NULL),
(45, 'instagram_url', 'https://instagram.com', 'website_general', NULL, NULL, NULL, NULL),
(46, 'about_store', 'About store text will goes here', 'website_general', NULL, NULL, NULL, NULL),
(47, 'contect_us_description', 'contact us text will goes here', 'website_general', NULL, NULL, NULL, NULL),
(48, 'allow_cookies', '1', 'website_general', NULL, NULL, NULL, NULL),
(49, 'client_secret', 'sk_1234', 'website_general', NULL, NULL, NULL, NULL),
(50, 'client_id', '1234', 'website_general', NULL, NULL, NULL, NULL),
(51, 'instagram_embed', 'Instagram Widget', 'website_general', NULL, NULL, NULL, NULL),
(52, 'seo_title', 'abc xyz', 'seo', NULL, NULL, NULL, NULL),
(53, 'seo_meta_tags', 'ecommers', 'seo', NULL, NULL, NULL, NULL),
(54, 'seo_keywords', 'abc,xyz,ecommerce', 'seo', NULL, NULL, NULL, NULL),
(55, 'seo_description', 'bss', 'seo', NULL, NULL, NULL, NULL),
(56, 'authenticate_with_email_password', '1', 'website_login_signup', NULL, NULL, NULL, NULL),
(57, 'authenticate_with_phone', '1', 'website_login_signup', NULL, NULL, NULL, NULL),
(58, 'authenticate_with_facebook', '1', 'website_login_signup', NULL, NULL, NULL, NULL),
(59, 'authenticate_with_google', '1', 'website_login_signup', NULL, NULL, NULL, NULL),
(60, 'authenticate_with_guest_checkout', '1', 'website_login_signup', NULL, NULL, NULL, NULL),
(61, 'login_signup_form', '1', 'website_login_signup', NULL, NULL, NULL, NULL),
(62, 'facebook_client_id', '', 'login_credential', NULL, NULL, NULL, NULL),
(63, 'facebook_client_secret', '', 'login_credential', NULL, NULL, NULL, NULL),
(64, 'facebook_redirect', 'http://localhost:8000/api/client/customer_login/facebook/callback', 'login_credential', NULL, NULL, NULL, NULL),
(65, 'google_client_id', '', 'login_credential', NULL, NULL, NULL, NULL),
(66, 'google_client_secret', '', 'login_credential', NULL, NULL, NULL, NULL),
(67, 'google_redirect', 'http://localhost:8000/api/client/customer_login/google/callback', 'login_credential', NULL, NULL, NULL, NULL),
(68, 'sociallite_login', '1', 'login_credential', NULL, NULL, NULL, NULL),
(69, 'card_style', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(70, 'header_style', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(71, 'Footer_style', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(72, 'slider_style', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(73, 'about_us_web', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(74, 'blog', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(75, 'banner_style', 'style2', 'web_theme_setting', NULL, NULL, NULL, NULL),
(76, 'cart_page', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(77, 'contact_us', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(78, 'login', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(79, 'product_detail', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(80, 'shop', 'style1', 'web_theme_setting', NULL, NULL, NULL, NULL),
(81, 'color', 'style', 'web_theme_setting', NULL, NULL, NULL, NULL),
(82, 'app_name', 'E-commerce Website', 'app_general', NULL, NULL, NULL, NULL),
(83, 'category_style', '4', 'app_general', NULL, NULL, NULL, NULL),
(84, 'home_style', '4', 'app_general', NULL, NULL, NULL, NULL),
(85, 'card_style', '1', 'app_general', NULL, NULL, NULL, NULL),
(86, 'banner_style', '1', 'app_general', NULL, NULL, NULL, NULL),
(87, 'ios_app_url', 'http://apple.com', 'app_general', NULL, NULL, NULL, NULL),
(88, 'google_login', '0', 'app_general', NULL, NULL, NULL, NULL),
(89, 'facebook_login', '0', 'app_general', NULL, NULL, NULL, NULL),
(90, 'phone_login', '0', 'app_general', NULL, NULL, NULL, NULL),
(91, 'email_login', '0', 'app_general', NULL, NULL, NULL, NULL),
(92, 'inventory', '0', 'app_general', NULL, NULL, NULL, NULL),
(93, 'wishList', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(94, 'edit_profile', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(95, 'shipping_address', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(96, 'my_orders', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(97, 'contact_us', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(98, 'about_us', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(99, 'news', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(100, 'introduction', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(101, 'shareApp', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(102, 'rateapp', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(103, 'setting', 'show', 'app_display_in_setting', NULL, NULL, NULL, NULL),
(104, 'title', 'Ionic Ecommerce', 'app_notification_setting', NULL, NULL, NULL, NULL),
(105, 'detail', 'A bundle of products waiting for you!', 'app_notification_setting', NULL, NULL, NULL, NULL),
(106, 'notification_duration', 'Year', 'app_notification_setting', NULL, NULL, NULL, NULL),
(107, 'authenticate_with_email_password', '1', 'app_login_signup', NULL, NULL, NULL, NULL),
(108, 'authenticate_with_phone', '1', 'app_login_signup', NULL, NULL, NULL, NULL),
(109, 'authenticate_with_facebook', '1', 'app_login_signup', NULL, NULL, NULL, NULL),
(110, 'authenticate_with_google', '1', 'app_login_signup', NULL, NULL, NULL, NULL),
(111, 'authenticate_with_guest_checkout', '1', 'app_login_signup', NULL, NULL, NULL, NULL),
(112, 'login_signup_form', '1', 'app_login_signup', NULL, NULL, NULL, NULL),
(113, 'thumbnail_height', '400', 'gallary_setting', NULL, NULL, NULL, NULL),
(114, 'thumbnail_width', '400', 'gallary_setting', NULL, NULL, NULL, NULL),
(115, 'medium_height', '600', 'gallary_setting', NULL, NULL, NULL, NULL),
(116, 'medium_width', '600', 'gallary_setting', NULL, NULL, NULL, NULL),
(117, 'large_height', '900', 'gallary_setting', NULL, NULL, NULL, NULL),
(118, 'large_width', '900', 'gallary_setting', NULL, NULL, NULL, NULL),
(119, 'physical_store', '1', 'store_setting', NULL, NULL, NULL, NULL),
(120, 'physical_store_inventory', '0', 'store_setting', NULL, NULL, NULL, NULL),
(121, 'physical_store_simple', '0', 'store_setting', NULL, NULL, NULL, NULL),
(122, 'physical_store_advance', '0', 'store_setting', NULL, NULL, NULL, NULL),
(123, 'physical_store_pos', '0', 'store_setting', NULL, NULL, NULL, NULL),
(124, 'physical_store_pos_warehouse', '0', 'store_setting', NULL, NULL, NULL, NULL),
(125, 'physical_store_account_managment', '0', 'store_setting', NULL, NULL, NULL, NULL),
(126, 'physical_store_purchasing', '0', 'store_setting', NULL, NULL, NULL, NULL),
(127, 'digital_store', '0', 'store_setting', NULL, NULL, NULL, NULL),
(128, 'digital_store_account_managment', '0', 'store_setting', NULL, NULL, NULL, NULL),
(129, 'default_notification', 'FCM', 'business_notification_setting', NULL, NULL, NULL, NULL),
(130, 'onesignal_app_id', '6053d948-b8f6-472a-87e4-379fa89f78d8', 'business_notification_setting', NULL, NULL, NULL, NULL),
(131, 'onsignal_sender_id', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(132, 'firebase_api_key', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(133, 'firebase_auth_domain', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(134, 'firebase_database_url', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(135, 'firebase_project_id', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(136, 'firebase_storage_bucket', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(137, 'firebase_sender_id', '50877237723', 'business_notification_setting', NULL, NULL, NULL, NULL),
(138, 'about_us', 'Themes-Coder is a clothing brand offers more than 100+ International brands at 20%-70% discount, all 365 days a year. We offer customers a wide range of brands and categories at absolutely great prices in an ambience that is refreshingly enjoyable. ', 'business_general', NULL, NULL, NULL, NULL),
(139, 'address', 'New York, USA', 'business_general', NULL, NULL, NULL, NULL),
(140, 'business_name', 'The Kundol Shop', 'business_general', NULL, NULL, NULL, NULL),
(141, 'phone_number', '888 - 963 - 600', 'business_general', NULL, NULL, NULL, NULL),
(142, 'email', 'bussiness@email.com', 'business_general', NULL, NULL, NULL, NULL),
(143, 'new_bage_on_product_card_visibility', '30', 'business_general', NULL, NULL, NULL, NULL),
(144, 'minimum_order_total', '150', 'business_general', NULL, NULL, NULL, NULL),
(145, 'free_shipping_order_price', '299', 'business_general', NULL, NULL, NULL, NULL),
(146, 'point_setting', 'disable', 'point_setting', NULL, 1, NULL, '2022-12-17 22:18:53'),
(147, 'checkin_point', '0.01', 'point_setting', NULL, NULL, NULL, NULL),
(148, 'checkin_hour', '24', 'point_setting', NULL, NULL, NULL, NULL),
(149, 'per_point', '0.05', 'point_setting', NULL, NULL, NULL, NULL),
(150, 'product_share_point', '5', 'point_setting', NULL, NULL, NULL, NULL),
(151, 'invite_friend_share_point', '5', 'point_setting', NULL, NULL, NULL, NULL),
(152, 'register_points', '5', 'point_setting', NULL, NULL, NULL, NULL),
(153, 'per_order_price_point', '50', 'point_setting', NULL, NULL, NULL, NULL),
(154, 'redeem_point', '100', 'point_setting', NULL, NULL, NULL, NULL),
(155, 'wallet_setting', 'disable', 'wallet_setting', NULL, 1, NULL, '2022-12-17 22:18:46'),
(156, 'first_level_amount', '100', 'membership_setting', NULL, NULL, NULL, NULL),
(157, 'second_level_amount', '200', 'membership_setting', NULL, NULL, NULL, NULL),
(158, 'third_level_amount', '500', 'membership_setting', NULL, NULL, NULL, NULL),
(159, 'fourth_level_amount', '1000', 'membership_setting', NULL, NULL, NULL, NULL),
(160, 'fifth_level_amount', '5000', 'membership_setting', NULL, NULL, NULL, NULL),
(161, 'notify_email', 'saqi628@gmail.com', 'email_notify_setting', NULL, NULL, NULL, NULL),
(162, 'is_web_purchased', '1', 'is_purchased_setting', NULL, NULL, NULL, NULL),
(163, 'is_app_purchased', '1', 'is_purchased_setting', NULL, NULL, NULL, NULL),
(164, 'is_deliveryboyapp_purchased', '1', 'is_purchased_setting', NULL, NULL, NULL, NULL),
(165, 'external_website_link', 'http://localhost:8000', 'installer_env_settings', NULL, NULL, NULL, NULL),
(166, 'app_name', 'E-commerce Website', 'installer_env_settings', NULL, NULL, NULL, NULL),
(167, 'environment', 'Maintenance', 'installer_env_settings', NULL, NULL, NULL, NULL),
(168, 'api_key', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(169, 'auth_domain', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(170, 'database_url', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(171, 'peoject_id', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(172, 'storage_bucket', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(173, 'messaging_sender_id', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(174, 'app_id', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(175, 'forget_email_template', '', 'email_template', NULL, NULL, NULL, NULL),
(176, 'contact_us_email_template', '', 'email_template', NULL, NULL, NULL, NULL),
(177, 'welcome_email_template', '', 'email_template', NULL, NULL, NULL, NULL),
(178, 'order_email_template', '', 'email_template', NULL, NULL, NULL, NULL),
(179, 'google_map_api_string', '', 'business_google_setting', NULL, NULL, NULL, NULL),
(180, 'home_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(181, 'shop_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(182, 'product_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(183, 'cart_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(184, 'about_us_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(185, 'contact_us_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(186, 'blog_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(187, 'login_page', 'style1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(188, 'language1_home1_text1', 'Get 50% OFF', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(189, 'language1_home1_text2', 'Spring', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(190, 'language1_home1_text3', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(191, 'language1_home1_text4', '202205244452banner_image_1.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(192, 'language1_home1_text5', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(193, 'language1_home1_text6', 'Geostrock', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(194, 'language1_home1_text7', 'Get 37%', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(195, 'language1_home1_text8', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(196, 'language1_home1_text9', '202205244454banner_image_2.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(197, 'language1_home1_text10', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(198, 'language1_home1_text11', 'Exclusive Design', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(199, 'language1_home1_text12', 'Minimal', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(200, 'language1_home1_text13', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(201, 'language1_home1_text14', '202205244457banner_image_3.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(202, 'language1_home1_text15', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(203, 'language1_home1_text16', 'Special offers', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(204, 'language1_home1_text17', 'Decore Furniture', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(205, 'language1_home1_text18', 'language1_home1_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(206, 'language1_home1_text19', 'lorem ispsum dlre sit lorem ispsum dlre sit lorem ispsum dlre sit lorem ispsum dlre sit', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(207, 'language1_home1_text20', '202205244413furniture-bg.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(208, 'language1_home1_text21', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(209, 'language1_home1_text22', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(210, 'language1_home1_text23', 'Collection', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(211, 'language1_home1_text24', 'OFF', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(212, 'language1_home1_text25', 'Chair', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(213, 'language1_home1_text26', 'language1_home1_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(214, 'language1_home1_text27', 'language1_home1_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(215, 'language1_home1_text28', 'language1_home1_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(216, 'language1_home1_text29', 'language1_home1_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(217, 'language1_home1_text30', 'language1_home1_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(218, 'language1_home2_text1', 'language1_home2_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(219, 'language1_home2_text2', 'language1_home2_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(220, 'language1_home2_text3', 'language1_home2_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(221, 'language1_home2_text4', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(222, 'language1_home2_text5', 'language1_home2_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(223, 'language1_home2_text6', 'language1_home2_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(224, 'language1_home2_text7', 'language1_home2_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(225, 'language1_home2_text8', 'language1_home2_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(226, 'language1_home2_text9', 'language1_home2_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(227, 'language1_home2_text10', 'language1_home2_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(228, 'language1_home2_text11', '202109025813banner_368x550.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(229, 'language1_home2_text12', 'language1_home2_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(230, 'language1_home2_text13', 'Newest Collection', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(231, 'language1_home2_text14', 'Black Dress', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(232, 'language1_home2_text15', 'Women', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(233, 'language1_home2_text16', '202205240500fullwidthbanner.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(234, 'language1_home2_text17', 'VIEW ALL COLLECTION', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(235, 'language1_home2_text18', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(236, 'language1_home2_text19', 'language1_home2_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(237, 'language1_home2_text20', 'language1_home2_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(238, 'language1_home2_text21', 'language1_home2_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(239, 'language1_home2_text22', 'language1_home2_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(240, 'language1_home2_text23', 'language1_home2_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(241, 'language1_home2_text24', 'language1_home2_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(242, 'language1_home2_text25', 'language1_home2_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(243, 'language1_home2_text26', 'language1_home2_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(244, 'language1_home2_text27', 'language1_home2_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(245, 'language1_home2_text28', 'language1_home2_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(246, 'language1_home2_text29', 'language1_home2_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(247, 'language1_home2_text30', 'language1_home2_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(248, 'language1_home3_text1', 'Jhon Deo', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(249, 'language1_home3_text2', 'lorem ipsums dolore lorem ipsums dolore lorem ipsums dolore lorem ipsums dolore', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(250, 'language1_home3_text3', '4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(251, 'language1_home3_text4', '202205240651profile1.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(252, 'language1_home3_text5', 'ALexa Vendor', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(253, 'language1_home3_text6', 'lorem ipsum dolr lorem ipsum dolr lorem ipsum dolr lorem ipsum dolr lorem ipsum dolr lorem ipsum dolr', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(254, 'language1_home3_text7', '3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(255, 'language1_home3_text8', '202205240651profile1.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(256, 'language1_home3_text9', 'language1_home3_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(257, 'language1_home3_text10', 'language1_home3_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(258, 'language1_home3_text11', 'language1_home3_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(259, 'language1_home3_text12', 'language1_home3_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(260, 'language1_home3_text13', 'language1_home3_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(261, 'language1_home3_text14', 'language1_home3_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(262, 'language1_home3_text15', 'language1_home3_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(263, 'language1_home3_text16', 'language1_home3_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(264, 'language1_home3_text17', 'language1_home3_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(265, 'language1_home3_text18', 'language1_home3_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(266, 'language1_home3_text19', 'language1_home3_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(267, 'language1_home3_text20', 'language1_home3_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(268, 'language1_home3_text21', 'language1_home3_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(269, 'language1_home3_text22', 'language1_home3_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(270, 'language1_home3_text23', 'language1_home3_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(271, 'language1_home3_text24', 'language1_home3_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(272, 'language1_home3_text25', 'language1_home3_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(273, 'language1_home3_text26', 'language1_home3_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(274, 'language1_home3_text27', 'language1_home3_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(275, 'language1_home3_text28', 'language1_home3_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(276, 'language1_home3_text29', 'language1_home3_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(277, 'language1_home3_text30', 'language1_home3_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(278, 'language1_home4_text1', 'backed', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(279, 'language1_home4_text2', 'Muffines', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(280, 'language1_home4_text3', 'Shop Now', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(281, 'language1_home4_text4', '202205241013banner-01.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(282, 'language1_home4_text5', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(283, 'language1_home4_text6', 'Fresh', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(284, 'language1_home4_text7', 'Orange', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(285, 'language1_home4_text8', 'Shop Now', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(286, 'language1_home4_text9', '202205241015banner-02.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(287, 'language1_home4_text10', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(288, 'language1_home4_text11', 'Decore Furniture', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(289, 'language1_home4_text12', 'Get Fresh Juices From Our Firm', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(290, 'language1_home4_text13', 'Discover Now', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(291, 'language1_home4_text14', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(292, 'language1_home4_text15', '202205241135paralex.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(293, 'language1_home4_text16', 'Egg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(294, 'language1_home4_text17', 'Dairy', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(295, 'language1_home4_text18', 'language1_home4_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(296, 'language1_home4_text19', '202205241025cate-03.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(297, 'language1_home4_text20', 'Detail', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(298, 'language1_home4_text21', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(299, 'language1_home4_text22', 'Fresh', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(300, 'language1_home4_text23', 'Meat', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(301, 'language1_home4_text24', 'language1_home4_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(302, 'language1_home4_text25', '202205241027cate-04.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(303, 'language1_home4_text26', 'Detail', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(304, 'language1_home4_text27', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(305, 'language1_home4_text28', 'Juices', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(306, 'language1_home4_text29', 'Coffee', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(307, 'language1_home4_text30', 'language1_home4_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(308, 'language1_home4_text31', '202205240910cate-05.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(309, 'language1_home4_text32', 'Detail', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(310, 'language1_home4_text33', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(311, 'language1_home4_text34', 'Snack', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(312, 'language1_home4_text35', 'Candy', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(313, 'language1_home4_text36', 'language1_home4_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(314, 'language1_home4_text37', '202205241022cate-02.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(315, 'language1_home4_text38', 'Detail', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(316, 'language1_home4_text39', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(317, 'language1_home4_text40', 'Fruit', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(318, 'language1_home4_text41', 'Vegetables', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(319, 'language1_home4_text42', 'language1_home4_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(320, 'language1_home4_text43', '202205241020cate-01.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(321, 'language1_home4_text44', 'Detail', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(322, 'language1_home4_text45', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(323, 'language1_home4_text46', 'language1_home4_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(324, 'language1_home4_text47', 'language1_home4_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(325, 'language1_home4_text48', 'language1_home4_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(326, 'language1_home4_text49', 'language1_home4_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(327, 'language1_home4_text50', 'language1_home4_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(328, 'language1_home4_text51', 'language1_home4_text51', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(329, 'language1_home4_text52', 'language1_home4_text52', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(330, 'language1_home4_text53', 'language1_home4_text53', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(331, 'language1_home4_text54', 'language1_home4_text54', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(332, 'language1_home4_text55', 'language1_home4_text55', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(333, 'language1_home4_text56', 'language1_home4_text56', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(334, 'language1_home4_text57', 'language1_home4_text57', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(335, 'language1_home4_text58', 'language1_home4_text58', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(336, 'language1_home4_text59', 'language1_home4_text59', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(337, 'language1_home4_text60', 'language1_home4_text60', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(338, 'language1_home5_text1', 'Free Shipping', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(339, 'language1_home5_text2', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(340, 'language1_home5_text3', 'Money Return', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(341, 'language1_home5_text4', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(342, 'language1_home5_text5', 'Support 24/7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(343, 'language1_home5_text6', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(344, 'language1_home5_text7', 'Safe Payment', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(345, 'language1_home5_text8', '202109025909banner_370x230.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(346, 'language1_home5_text9', 'Upto 30% Off', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(347, 'language1_home5_text10', 'Lip Gloss', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(348, 'language1_home5_text11', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(349, 'language1_home5_text12', '202205241136offers-1.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(350, 'language1_home5_text13', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(351, 'language1_home5_text14', 'Upto 30% Off', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(352, 'language1_home5_text15', 'Gel Eye Mask', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(353, 'language1_home5_text16', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(354, 'language1_home5_text17', '202205241138offers-2.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(355, 'language1_home5_text18', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(356, 'language1_home5_text19', 'Upto 50% Off', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(357, 'language1_home5_text20', 'Blackhead', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(358, 'language1_home5_text21', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(359, 'language1_home5_text22', '202205241141offers-3.png', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(360, 'language1_home5_text23', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(361, 'language1_home5_text24', 'language1_home5_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(362, 'language1_home5_text25', 'language1_home5_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(363, 'language1_home5_text26', 'language1_home5_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(364, 'language1_home5_text27', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(365, 'language1_home5_text28', 'language1_home5_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(366, 'language1_home5_text29', 'language1_home5_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(367, 'language1_home5_text30', 'language1_home5_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(368, 'language1_home5_text31', 'language1_home5_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(369, 'language1_home5_text32', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(370, 'language1_home5_text33', 'language1_home5_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(371, 'language1_home5_text34', 'language1_home5_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(372, 'language1_home5_text35', 'language1_home5_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(373, 'language1_home5_text36', 'language1_home5_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(374, 'language1_home5_text37', 'language1_home5_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(375, 'language1_home5_text38', 'language1_home5_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(376, 'language1_home5_text39', 'language1_home5_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(377, 'language1_home5_text40', 'language1_home5_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(378, 'language1_home5_text41', 'language1_home5_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(379, 'language1_home5_text42', 'language1_home5_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(380, 'language1_home5_text43', 'language1_home5_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(381, 'language1_home5_text44', 'language1_home5_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(382, 'language1_home5_text45', 'language1_home5_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(383, 'language1_home5_text46', 'language1_home5_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(384, 'language1_home5_text47', 'language1_home5_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(385, 'language1_home5_text48', 'language1_home5_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(386, 'language1_home5_text49', 'language1_home5_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(387, 'language1_home5_text50', 'language1_home5_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(388, 'language1_home6_text1', 'WILD', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(389, 'language1_home6_text2', 'COLLECTION', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(390, 'language1_home6_text3', 'lorem ipsum slor  lorem ipsum slor  lorem ipsum slor  lorem ipsum slor  lorem ipsum slor', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(391, 'language1_home6_text4', '202205241301bg-paralax.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(392, 'language1_home6_text5', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(393, 'language1_home6_text6', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(394, 'language1_home6_text7', 'language1_home6_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(395, 'language1_home6_text8', 'language1_home6_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(396, 'language1_home6_text9', 'language1_home6_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(397, 'language1_home6_text10', 'language1_home6_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(398, 'language1_home6_text11', 'language1_home6_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(399, 'language1_home6_text12', 'language1_home6_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(400, 'language1_home6_text13', 'language1_home6_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(401, 'language1_home6_text14', 'language1_home6_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(402, 'language1_home6_text15', 'language1_home6_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(403, 'language1_home6_text16', 'language1_home6_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(404, 'language1_home6_text17', 'language1_home6_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(405, 'language1_home6_text18', 'language1_home6_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(406, 'language1_home6_text19', 'language1_home6_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(407, 'language1_home6_text20', 'language1_home6_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(408, 'language1_home7_text1', 'Men Casual', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(409, 'language1_home7_text2', 'upto 30% off', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(410, 'language1_home7_text3', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(411, 'language1_home7_text4', '202205241541cate-banner1.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(412, 'language1_home7_text5', 'Women Dresses', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(413, 'language1_home7_text6', 'upto 30% off', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(414, 'language1_home7_text7', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(415, 'language1_home7_text8', '202205241614element-banner5-center.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(416, 'language1_home7_text9', 'Kid collection', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(417, 'language1_home7_text10', 'upto 30% off', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(418, 'language1_home7_text11', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(419, 'language1_home7_text12', '202205241543cate-banner3.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(420, 'language1_home7_text13', 'Spring', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(421, 'language1_home7_text14', 'Trends', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(422, 'language1_home7_text15', 'SHOP NEW ARRIVAL', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(423, 'language1_home7_text16', '202205241535banner7.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(424, 'language1_home7_text17', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(425, 'language1_home7_text18', 'language1_home7_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(426, 'language1_home7_text19', 'language1_home7_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(427, 'language1_home7_text20', 'language1_home7_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(428, 'language1_home7_text21', 'language1_home7_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(429, 'language1_home7_text22', 'language1_home7_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(430, 'language1_home7_text23', 'language1_home7_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(431, 'language1_home7_text24', 'language1_home7_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(432, 'language1_home7_text25', 'language1_home7_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(433, 'language1_home7_text26', 'language1_home7_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(434, 'language1_home7_text27', 'language1_home7_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(435, 'language1_home7_text28', 'language1_home7_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(436, 'language1_home7_text29', 'language1_home7_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(437, 'language1_home7_text30', 'language1_home7_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(438, 'language1_home8_text1', 'upto 20% of', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(439, 'language1_home8_text2', 'Summers', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(440, 'language1_home8_text3', 'Shop Nows', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(441, 'language1_home8_text4', '202205241457Flower-banner1.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(442, 'language1_home8_text5', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(443, 'language1_home8_text6', 'Wedding Collection', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(444, 'language1_home8_text7', 'Flower', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(445, 'language1_home8_text8', 'Shop Now', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(446, 'language1_home8_text9', '202205241459Flower-banner2.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(447, 'language1_home8_text10', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(448, 'language1_home8_text11', 'Beautiful Range  of', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(449, 'language1_home8_text12', 'Colorfull Birthday Flower', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(450, 'language1_home8_text13', 'View All Range', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(451, 'language1_home8_text14', '202205241501paralax.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(452, 'language1_home8_text15', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(453, 'language1_home8_text16', 'language1_home8_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(454, 'language1_home8_text17', 'language1_home8_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(455, 'language1_home8_text18', 'language1_home8_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(456, 'language1_home8_text19', 'language1_home8_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(457, 'language1_home8_text20', 'language1_home8_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(458, 'language1_home8_text21', 'language1_home8_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(459, 'language1_home8_text22', 'language1_home8_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(460, 'language1_home8_text23', 'language1_home8_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(461, 'language1_home8_text24', 'language1_home8_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(462, 'language1_home8_text25', 'language1_home8_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(463, 'language1_home8_text26', 'language1_home8_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(464, 'language1_home8_text27', 'language1_home8_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(465, 'language1_home8_text28', 'language1_home8_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(466, 'language1_home8_text29', 'language1_home8_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(467, 'language1_home8_text30', 'language1_home8_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(468, 'language1_home9_text1', 'DEAL OF THE DAY', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(469, 'language1_home9_text2', 'LAB GROWN', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(470, 'language1_home9_text3', 'DAIMONDS', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(471, 'language1_home9_text4', 'Discover TheExceptional Quailty And Sparkle Of Our Lab', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(472, 'language1_home9_text5', 'Grown Daimonds', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(473, 'language1_home9_text6', '180.00', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(474, 'language1_home9_text7', '200.00', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(475, 'language1_home9_text8', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(476, 'language1_home9_text9', '202205241811banner2.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(477, 'language1_home9_text10', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(478, 'language1_home9_text11', 'DEAL OF THE DAY', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(479, 'language1_home9_text12', 'DESIGN OWN', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(480, 'language1_home9_text13', 'CUSTOM RINGS', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(481, 'language1_home9_text14', 'Discover The Excutive Beauty Qaulity And Sparkle of Our Lab', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(482, 'language1_home9_text15', 'Custom Rings', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(483, 'language1_home9_text16', '180.00', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(484, 'language1_home9_text17', '200.00', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(485, 'language1_home9_text18', 'SHOP NOW', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(486, 'language1_home9_text19', '202205241816banner3.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(487, 'language1_home9_text20', '/shop', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(488, 'language1_home9_text21', '202205241735look1.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(489, 'language1_home9_text22', '202205241741look2.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(490, 'language1_home9_text23', '202205241744look3.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(491, 'language1_home9_text24', '202205241735look1.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(492, 'language1_home9_text25', '202205241741look2.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(493, 'language1_home9_text26', '202205241744look3.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(494, 'language1_home9_text27', 'language1_home9_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(495, 'language1_home9_text28', 'language1_home9_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(496, 'language1_home9_text29', 'language1_home9_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(497, 'language1_home9_text30', 'language1_home9_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(498, 'language1_home9_text31', 'language1_home9_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(499, 'language1_home9_text32', 'language1_home9_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(500, 'language1_home9_text33', 'language1_home9_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(501, 'language1_home9_text34', 'language1_home9_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(502, 'language1_home9_text35', 'language1_home9_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(503, 'language1_home9_text36', 'language1_home9_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(504, 'language1_home9_text37', 'language1_home9_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(505, 'language1_home9_text38', 'language1_home9_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(506, 'language1_home9_text39', 'language1_home9_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(507, 'language1_home9_text40', 'language1_home9_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(508, 'language1_home9_text41', 'language1_home9_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(509, 'language1_home9_text42', 'language1_home9_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(510, 'language1_home9_text43', 'language1_home9_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(511, 'language1_home9_text44', 'language1_home9_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(512, 'language1_home9_text45', 'language1_home9_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(513, 'language1_home9_text46', 'language1_home9_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(514, 'language1_home9_text47', 'language1_home9_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(515, 'language1_home9_text48', 'language1_home9_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(516, 'language1_home9_text49', 'language1_home9_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(517, 'language1_home9_text50', 'language1_home9_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(518, 'language2_home1_text1', 'language2_home1_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(519, 'language2_home1_text2', 'language2_home1_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(520, 'language2_home1_text3', 'language2_home1_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(521, 'language2_home1_text4', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(522, 'language2_home1_text5', 'language2_home1_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(523, 'language2_home1_text6', 'language2_home1_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(524, 'language2_home1_text7', 'language2_home1_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(525, 'language2_home1_text8', 'language2_home1_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(526, 'language2_home1_text9', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(527, 'language2_home1_text10', 'language2_home1_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(528, 'language2_home1_text11', 'language2_home1_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(529, 'language2_home1_text12', 'language2_home1_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(530, 'language2_home1_text13', 'language2_home1_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(531, 'language2_home1_text14', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(532, 'language2_home1_text15', 'language2_home1_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(533, 'language2_home1_text16', 'language2_home1_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(534, 'language2_home1_text17', 'language2_home1_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(535, 'language2_home1_text18', 'language2_home1_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(536, 'language2_home1_text19', 'language2_home1_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(537, 'language2_home1_text20', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(538, 'language2_home1_text21', 'language2_home1_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(539, 'language2_home1_text22', 'language2_home1_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(540, 'language2_home1_text23', 'language2_home1_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(541, 'language2_home1_text24', 'language2_home1_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(542, 'language2_home1_text25', 'language2_home1_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(543, 'language2_home1_text26', 'language2_home1_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(544, 'language2_home1_text27', 'language2_home1_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(545, 'language2_home1_text28', 'language2_home1_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(546, 'language2_home1_text29', 'language2_home1_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(547, 'language2_home1_text30', 'language2_home1_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(548, 'language2_home2_text1', 'language2_home2_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(549, 'language2_home2_text2', 'language2_home2_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(550, 'language2_home2_text3', 'language2_home2_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(551, 'language2_home2_text4', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(552, 'language2_home2_text5', 'language2_home2_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(553, 'language2_home2_text6', 'language2_home2_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(554, 'language2_home2_text7', 'language2_home2_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(555, 'language2_home2_text8', 'language2_home2_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(556, 'language2_home2_text9', 'language2_home2_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(557, 'language2_home2_text10', 'language2_home2_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(558, 'language2_home2_text11', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(559, 'language2_home2_text12', 'language2_home2_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(560, 'language2_home2_text13', 'language2_home2_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(561, 'language2_home2_text14', 'language2_home2_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(562, 'language2_home2_text15', 'language2_home2_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(563, 'language2_home2_text16', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(564, 'language2_home2_text17', 'language2_home2_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(565, 'language2_home2_text18', 'language2_home2_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(566, 'language2_home2_text19', 'language2_home2_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(567, 'language2_home2_text20', 'language2_home2_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(568, 'language2_home2_text21', 'language2_home2_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(569, 'language2_home2_text22', 'language2_home2_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(570, 'language2_home2_text23', 'language2_home2_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(571, 'language2_home2_text24', 'language2_home2_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(572, 'language2_home2_text25', 'language2_home2_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(573, 'language2_home2_text26', 'language2_home2_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(574, 'language2_home2_text27', 'language2_home2_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(575, 'language2_home2_text28', 'language2_home2_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(576, 'language2_home2_text29', 'language2_home2_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(577, 'language2_home2_text30', 'language2_home2_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(578, 'language2_home3_text1', 'language2_home3_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(579, 'language2_home3_text2', 'language2_home3_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(580, 'language2_home3_text3', 'language2_home3_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(581, 'language2_home3_text4', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(582, 'language2_home3_text5', 'language2_home3_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(583, 'language2_home3_text6', 'language2_home3_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(584, 'language2_home3_text7', 'language2_home3_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(585, 'language2_home3_text8', 'language2_home3_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(586, 'language2_home3_text9', 'language2_home3_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(587, 'language2_home3_text10', 'language2_home3_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(588, 'language2_home3_text11', 'language2_home3_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(589, 'language2_home3_text12', 'language2_home3_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(590, 'language2_home3_text13', 'language2_home3_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(591, 'language2_home3_text14', 'language2_home3_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(592, 'language2_home3_text15', 'language2_home3_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(593, 'language2_home3_text16', 'language2_home3_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(594, 'language2_home3_text17', 'language2_home3_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(595, 'language2_home3_text18', 'language2_home3_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(596, 'language2_home3_text19', 'language2_home3_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(597, 'language2_home3_text20', 'language2_home3_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(598, 'language2_home3_text21', 'language2_home3_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(599, 'language2_home3_text22', 'language2_home3_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(600, 'language2_home3_text23', 'language2_home3_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(601, 'language2_home3_text24', 'language2_home3_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(602, 'language2_home3_text25', 'language2_home3_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(603, 'language2_home3_text26', 'language2_home3_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(604, 'language2_home3_text27', 'language2_home3_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(605, 'language2_home3_text28', 'language2_home3_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(606, 'language2_home3_text29', 'language2_home3_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(607, 'language2_home3_text30', 'language2_home3_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(608, 'language2_home4_text1', 'language2_home4_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(609, 'language2_home4_text2', 'language2_home4_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(610, 'language2_home4_text3', 'language2_home4_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(611, 'language2_home4_text4', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(612, 'language2_home4_text5', 'language2_home4_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(613, 'language2_home4_text6', 'language2_home4_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(614, 'language2_home4_text7', 'language2_home4_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(615, 'language2_home4_text8', 'language2_home4_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(616, 'language2_home4_text9', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(617, 'language2_home4_text10', 'language2_home4_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(618, 'language2_home4_text11', 'language2_home4_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(619, 'language2_home4_text12', 'language2_home4_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(620, 'language2_home4_text13', 'language2_home4_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(621, 'language2_home4_text14', 'language2_home4_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(622, 'language2_home4_text15', '202109025813banner_368x550.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(623, 'language2_home4_text16', 'language2_home4_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(624, 'language2_home4_text17', 'language2_home4_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(625, 'language2_home4_text18', 'language2_home4_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(626, 'language2_home4_text19', 'language2_home4_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(627, 'language2_home4_text20', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(628, 'language2_home4_text21', 'language2_home4_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(629, 'language2_home4_text22', 'language2_home4_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(630, 'language2_home4_text23', 'language2_home4_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(631, 'language2_home4_text24', 'language2_home4_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(632, 'language2_home4_text25', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(633, 'language2_home4_text26', 'language2_home4_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(634, 'language2_home4_text27', 'language2_home4_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(635, 'language2_home4_text28', 'language2_home4_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(636, 'language2_home4_text29', 'language2_home4_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(637, 'language2_home4_text30', 'language2_home4_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(638, 'language2_home4_text31', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(639, 'language2_home4_text32', 'language2_home4_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(640, 'language2_home4_text33', 'language2_home4_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(641, 'language2_home4_text34', 'language2_home4_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(642, 'language2_home4_text35', 'language2_home4_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(643, 'language2_home4_text36', 'language2_home4_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(644, 'language2_home4_text37', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(645, 'language2_home4_text38', 'language2_home4_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(646, 'language2_home4_text39', 'language2_home4_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(647, 'language2_home4_text40', 'language2_home4_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(648, 'language2_home4_text41', 'language2_home4_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(649, 'language2_home4_text42', 'language2_home4_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(650, 'language2_home4_text43', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(651, 'language2_home4_text44', 'language2_home4_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(652, 'language2_home4_text45', 'language2_home4_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(653, 'language2_home4_text46', 'language2_home4_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(654, 'language2_home4_text47', 'language2_home4_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(655, 'language2_home4_text48', 'language2_home4_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(656, 'language2_home4_text49', 'language2_home4_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(657, 'language2_home4_text50', 'language2_home4_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(658, 'language2_home4_text51', 'language2_home4_text51', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(659, 'language2_home4_text52', 'language2_home4_text52', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(660, 'language2_home4_text53', 'language2_home4_text53', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(661, 'language2_home4_text54', 'language2_home4_text54', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(662, 'language2_home4_text55', 'language2_home4_text55', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(663, 'language2_home4_text56', 'language2_home4_text56', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(664, 'language2_home4_text57', 'language2_home4_text57', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(665, 'language2_home4_text58', 'language2_home4_text58', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(666, 'language2_home4_text59', 'language2_home4_text59', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(667, 'language2_home4_text60', 'language2_home4_text60', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(668, 'language2_home5_text1', 'language2_home5_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(669, 'language2_home5_text2', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(670, 'language2_home5_text3', 'language2_home5_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(671, 'language2_home5_text4', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(672, 'language2_home5_text5', 'language2_home5_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(673, 'language2_home5_text6', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(674, 'language2_home5_text7', 'language2_home5_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(675, 'language2_home5_text8', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(676, 'language2_home5_text9', 'language2_home5_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(677, 'language2_home5_text10', 'language2_home5_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(678, 'language2_home5_text11', 'language2_home5_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(679, 'language2_home5_text12', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(680, 'language2_home5_text13', 'language2_home5_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(681, 'language2_home5_text14', 'language2_home5_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(682, 'language2_home5_text15', 'language2_home5_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(683, 'language2_home5_text16', 'language2_home5_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(684, 'language2_home5_text17', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(685, 'language2_home5_text18', 'language2_home5_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(686, 'language2_home5_text19', 'language2_home5_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(687, 'language2_home5_text20', 'language2_home5_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(688, 'language2_home5_text21', 'language2_home5_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(689, 'language2_home5_text22', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(690, 'language2_home5_text23', 'language2_home5_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(691, 'language2_home5_text24', 'language2_home5_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(692, 'language2_home5_text25', 'language2_home5_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(693, 'language2_home5_text26', 'language2_home5_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(694, 'language2_home5_text27', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(695, 'language2_home5_text28', 'language2_home5_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(696, 'language2_home5_text29', 'language2_home5_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(697, 'language2_home5_text30', 'language2_home5_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(698, 'language2_home5_text31', 'language2_home5_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(699, 'language2_home5_text32', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(700, 'language2_home5_text33', 'language2_home5_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(701, 'language2_home5_text34', 'language2_home5_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(702, 'language2_home5_text35', 'language2_home5_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(703, 'language2_home5_text36', 'language2_home5_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(704, 'language2_home5_text37', 'language2_home5_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(705, 'language2_home5_text38', 'language2_home5_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(706, 'language2_home5_text39', 'language2_home5_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(707, 'language2_home5_text40', 'language2_home5_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(708, 'language2_home5_text41', 'language2_home5_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(709, 'language2_home5_text42', 'language2_home5_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(710, 'language2_home5_text43', 'language2_home5_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(711, 'language2_home5_text44', 'language2_home5_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(712, 'language2_home5_text45', 'language2_home5_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(713, 'language2_home5_text46', 'language2_home5_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(714, 'language2_home5_text47', 'language2_home5_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(715, 'language2_home5_text48', 'language2_home5_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(716, 'language2_home5_text49', 'language2_home5_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(717, 'language2_home5_text50', 'language2_home5_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(718, 'language2_home6_text1', 'language2_home6_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(719, 'language2_home6_text2', 'language2_home6_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(720, 'language2_home6_text3', 'language2_home6_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(721, 'language2_home6_text4', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(722, 'language2_home6_text5', 'language2_home6_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(723, 'language2_home6_text6', 'language2_home6_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(724, 'language2_home6_text7', 'language2_home6_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(725, 'language2_home6_text8', 'language2_home6_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(726, 'language2_home6_text9', 'language2_home6_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(727, 'language2_home6_text10', 'language2_home6_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(728, 'language2_home6_text11', 'language2_home6_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(729, 'language2_home6_text12', 'language2_home6_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(730, 'language2_home6_text13', 'language2_home6_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(731, 'language2_home6_text14', 'language2_home6_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(732, 'language2_home6_text15', 'language2_home6_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(733, 'language2_home6_text16', 'language2_home6_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(734, 'language2_home6_text17', 'language2_home6_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(735, 'language2_home6_text18', 'language2_home6_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(736, 'language2_home6_text19', 'language2_home6_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(737, 'language2_home6_text20', 'language2_home6_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(738, 'language2_home7_text1', 'language2_home7_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(739, 'language2_home7_text2', 'language2_home7_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(740, 'language2_home7_text3', 'language2_home7_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(741, 'language2_home7_text4', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(742, 'language2_home7_text5', 'language2_home7_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(743, 'language2_home7_text6', 'language2_home7_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(744, 'language2_home7_text7', 'language2_home7_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(745, 'language2_home7_text8', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(746, 'language2_home7_text9', 'language2_home7_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(747, 'language2_home7_text10', 'language2_home7_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(748, 'language2_home7_text11', 'language2_home7_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(749, 'language2_home7_text12', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(750, 'language2_home7_text13', 'language2_home7_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(751, 'language2_home7_text14', 'language2_home7_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(752, 'language2_home7_text15', 'language2_home7_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(753, 'language2_home7_text16', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(754, 'language2_home7_text17', 'language2_home7_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(755, 'language2_home7_text18', 'language2_home7_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(756, 'language2_home7_text19', 'language2_home7_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(757, 'language2_home7_text20', 'language2_home7_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(758, 'language2_home7_text21', 'language2_home7_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(759, 'language2_home7_text22', 'language2_home7_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(760, 'language2_home7_text23', 'language2_home7_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(761, 'language2_home7_text24', 'language2_home7_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(762, 'language2_home7_text25', 'language2_home7_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(763, 'language2_home7_text26', 'language2_home7_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(764, 'language2_home7_text27', 'language2_home7_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(765, 'language2_home7_text28', 'language2_home7_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(766, 'language2_home7_text29', 'language2_home7_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(767, 'language2_home7_text30', 'language2_home7_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(768, 'language2_home8_text1', 'language2_home8_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(769, 'language2_home8_text2', 'language2_home8_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(770, 'language2_home8_text3', 'language2_home8_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(771, 'language2_home8_text4', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(772, 'language2_home8_text5', 'language2_home8_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(773, 'language2_home8_text6', 'language2_home8_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(774, 'language2_home8_text7', 'language2_home8_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(775, 'language2_home8_text8', 'language2_home8_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(776, 'language2_home8_text9', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(777, 'language2_home8_text10', 'language2_home8_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(778, 'language2_home8_text11', 'language2_home8_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(779, 'language2_home8_text12', 'language2_home8_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(780, 'language2_home8_text13', 'language2_home8_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(781, 'language2_home8_text14', '202109025823banner_370x210.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(782, 'language2_home8_text15', 'language2_home8_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(783, 'language2_home8_text16', 'language2_home8_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(784, 'language2_home8_text17', 'language2_home8_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(785, 'language2_home8_text18', 'language2_home8_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(786, 'language2_home8_text19', 'language2_home8_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(787, 'language2_home8_text20', 'language2_home8_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(788, 'language2_home8_text21', 'language2_home8_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(789, 'language2_home8_text22', 'language2_home8_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(790, 'language2_home8_text23', 'language2_home8_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(791, 'language2_home8_text24', 'language2_home8_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(792, 'language2_home8_text25', 'language2_home8_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(793, 'language2_home8_text26', 'language2_home8_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(794, 'language2_home8_text27', 'language2_home8_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(795, 'language2_home8_text28', 'language2_home8_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(796, 'language2_home8_text29', 'language2_home8_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(797, 'language2_home8_text30', 'language2_home8_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(798, 'language2_home9_text1', 'language2_home9_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(799, 'language2_home9_text2', 'language2_home9_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(800, 'language2_home9_text3', 'language2_home9_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(801, 'language2_home9_text4', 'language2_home9_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(802, 'language2_home9_text5', 'language2_home9_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(803, 'language2_home9_text6', 'language2_home9_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(804, 'language2_home9_text7', 'language2_home9_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(805, 'language2_home9_text8', 'language2_home9_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(806, 'language2_home9_text9', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(807, 'language2_home9_text10', 'language2_home9_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(808, 'language2_home9_text11', 'language2_home9_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(809, 'language2_home9_text12', 'language2_home9_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(810, 'language2_home9_text13', 'language2_home9_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(811, 'language2_home9_text14', 'language2_home9_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(812, 'language2_home9_text15', 'language2_home9_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(813, 'language2_home9_text16', 'language2_home9_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(814, 'language2_home9_text17', 'language2_home9_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(815, 'language2_home9_text18', 'language2_home9_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(816, 'language2_home9_text19', '202109042309banner_271x451.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(817, 'language2_home9_text20', 'language2_home9_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(818, 'language2_home9_text21', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(819, 'language2_home9_text22', '202109042309banner_271x451.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(820, 'language2_home9_text23', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(821, 'language2_home9_text24', '202109042527banner_270x211.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(822, 'language2_home9_text25', '202109025727banner_270x229.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(823, 'language2_home9_text26', '202109025851banner_370x220.jpg', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(824, 'language2_home9_text27', 'language2_home9_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(825, 'language2_home9_text28', 'language2_home9_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(826, 'language2_home9_text29', 'language2_home9_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(827, 'language2_home9_text30', 'language2_home9_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(828, 'language2_home9_text31', 'language2_home9_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(829, 'language2_home9_text32', 'language2_home9_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(830, 'language2_home9_text33', 'language2_home9_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(831, 'language2_home9_text34', 'language2_home9_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(832, 'language2_home9_text35', 'language2_home9_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(833, 'language2_home9_text36', 'language2_home9_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(834, 'language2_home9_text37', 'language2_home9_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(835, 'language2_home9_text38', 'language2_home9_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(836, 'language2_home9_text39', 'language2_home9_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(837, 'language2_home9_text40', 'language2_home9_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(838, 'language2_home9_text41', 'language2_home9_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(839, 'language2_home9_text42', 'language2_home9_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(840, 'language2_home9_text43', 'language2_home9_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(841, 'language2_home9_text44', 'language2_home9_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(842, 'language2_home9_text45', 'language2_home9_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(843, 'language2_home9_text46', 'language2_home9_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(844, 'language2_home9_text47', 'language2_home9_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(845, 'language2_home9_text48', 'language2_home9_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(846, 'language2_home9_text49', 'language2_home9_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(847, 'language2_home9_text50', 'language2_home9_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(848, 'language3_home1_text1', 'language3_home1_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(849, 'language3_home1_text2', 'language3_home1_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(850, 'language3_home1_text3', 'language3_home1_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(851, 'language3_home1_text4', 'language3_home1_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(852, 'language3_home1_text5', 'language3_home1_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(853, 'language3_home1_text6', 'language3_home1_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(854, 'language3_home1_text7', 'language3_home1_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(855, 'language3_home1_text8', 'language3_home1_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(856, 'language3_home1_text9', 'language3_home1_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(857, 'language3_home1_text10', 'language3_home1_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(858, 'language3_home1_text11', 'language3_home1_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(859, 'language3_home1_text12', 'language3_home1_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(860, 'language3_home1_text13', 'language3_home1_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(861, 'language3_home1_text14', 'language3_home1_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(862, 'language3_home1_text15', 'language3_home1_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(863, 'language3_home1_text16', 'language3_home1_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(864, 'language3_home1_text17', 'language3_home1_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(865, 'language3_home1_text18', 'language3_home1_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(866, 'language3_home1_text19', 'language3_home1_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(867, 'language3_home1_text20', 'language3_home1_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(868, 'language3_home1_text21', 'language3_home1_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(869, 'language3_home1_text22', 'language3_home1_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(870, 'language3_home1_text23', 'language3_home1_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(871, 'language3_home1_text24', 'language3_home1_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(872, 'language3_home1_text25', 'language3_home1_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(873, 'language3_home1_text26', 'language3_home1_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(874, 'language3_home1_text27', 'language3_home1_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(875, 'language3_home1_text28', 'language3_home1_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(876, 'language3_home1_text29', 'language3_home1_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(877, 'language3_home1_text30', 'language3_home1_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(878, 'language3_home2_text1', 'language3_home2_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(879, 'language3_home2_text2', 'language3_home2_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(880, 'language3_home2_text3', 'language3_home2_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(881, 'language3_home2_text4', 'language3_home2_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(882, 'language3_home2_text5', 'language3_home2_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(883, 'language3_home2_text6', 'language3_home2_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(884, 'language3_home2_text7', 'language3_home2_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(885, 'language3_home2_text8', 'language3_home2_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(886, 'language3_home2_text9', 'language3_home2_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(887, 'language3_home2_text10', 'language3_home2_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(888, 'language3_home2_text11', 'language3_home2_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(889, 'language3_home2_text12', 'language3_home2_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(890, 'language3_home2_text13', 'language3_home2_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(891, 'language3_home2_text14', 'language3_home2_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(892, 'language3_home2_text15', 'language3_home2_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(893, 'language3_home2_text16', 'language3_home2_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(894, 'language3_home2_text17', 'language3_home2_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(895, 'language3_home2_text18', 'language3_home2_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(896, 'language3_home2_text19', 'language3_home2_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(897, 'language3_home2_text20', 'language3_home2_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(898, 'language3_home2_text21', 'language3_home2_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(899, 'language3_home2_text22', 'language3_home2_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(900, 'language3_home2_text23', 'language3_home2_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(901, 'language3_home2_text24', 'language3_home2_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(902, 'language3_home2_text25', 'language3_home2_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(903, 'language3_home2_text26', 'language3_home2_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(904, 'language3_home2_text27', 'language3_home2_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(905, 'language3_home2_text28', 'language3_home2_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(906, 'language3_home2_text29', 'language3_home2_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(907, 'language3_home2_text30', 'language3_home2_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(908, 'language3_home3_text1', 'language3_home3_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(909, 'language3_home3_text2', 'language3_home3_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(910, 'language3_home3_text3', 'language3_home3_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(911, 'language3_home3_text4', 'language3_home3_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(912, 'language3_home3_text5', 'language3_home3_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(913, 'language3_home3_text6', 'language3_home3_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(914, 'language3_home3_text7', 'language3_home3_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(915, 'language3_home3_text8', 'language3_home3_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(916, 'language3_home3_text9', 'language3_home3_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(917, 'language3_home3_text10', 'language3_home3_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(918, 'language3_home3_text11', 'language3_home3_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(919, 'language3_home3_text12', 'language3_home3_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(920, 'language3_home3_text13', 'language3_home3_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(921, 'language3_home3_text14', 'language3_home3_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(922, 'language3_home3_text15', 'language3_home3_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(923, 'language3_home3_text16', 'language3_home3_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(924, 'language3_home3_text17', 'language3_home3_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(925, 'language3_home3_text18', 'language3_home3_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(926, 'language3_home3_text19', 'language3_home3_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(927, 'language3_home3_text20', 'language3_home3_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(928, 'language3_home3_text21', 'language3_home3_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(929, 'language3_home3_text22', 'language3_home3_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(930, 'language3_home3_text23', 'language3_home3_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(931, 'language3_home3_text24', 'language3_home3_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(932, 'language3_home3_text25', 'language3_home3_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(933, 'language3_home3_text26', 'language3_home3_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(934, 'language3_home3_text27', 'language3_home3_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(935, 'language3_home3_text28', 'language3_home3_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(936, 'language3_home3_text29', 'language3_home3_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(937, 'language3_home3_text30', 'language3_home3_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(938, 'language3_home4_text1', 'language3_home4_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(939, 'language3_home4_text2', 'language3_home4_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(940, 'language3_home4_text3', 'language3_home4_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(941, 'language3_home4_text4', 'language3_home4_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(942, 'language3_home4_text5', 'language3_home4_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(943, 'language3_home4_text6', 'language3_home4_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(944, 'language3_home4_text7', 'language3_home4_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(945, 'language3_home4_text8', 'language3_home4_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(946, 'language3_home4_text9', 'language3_home4_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(947, 'language3_home4_text10', 'language3_home4_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(948, 'language3_home4_text11', 'language3_home4_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(949, 'language3_home4_text12', 'language3_home4_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(950, 'language3_home4_text13', 'language3_home4_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(951, 'language3_home4_text14', 'language3_home4_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(952, 'language3_home4_text15', 'language3_home4_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(953, 'language3_home4_text16', 'language3_home4_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(954, 'language3_home4_text17', 'language3_home4_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(955, 'language3_home4_text18', 'language3_home4_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(956, 'language3_home4_text19', 'language3_home4_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(957, 'language3_home4_text20', 'language3_home4_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(958, 'language3_home4_text21', 'language3_home4_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(959, 'language3_home4_text22', 'language3_home4_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(960, 'language3_home4_text23', 'language3_home4_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(961, 'language3_home4_text24', 'language3_home4_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(962, 'language3_home4_text25', 'language3_home4_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(963, 'language3_home4_text26', 'language3_home4_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(964, 'language3_home4_text27', 'language3_home4_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(965, 'language3_home4_text28', 'language3_home4_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(966, 'language3_home4_text29', 'language3_home4_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(967, 'language3_home4_text30', 'language3_home4_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(968, 'language3_home4_text31', 'language3_home4_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(969, 'language3_home4_text32', 'language3_home4_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(970, 'language3_home4_text33', 'language3_home4_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(971, 'language3_home4_text34', 'language3_home4_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(972, 'language3_home4_text35', 'language3_home4_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(973, 'language3_home4_text36', 'language3_home4_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(974, 'language3_home4_text37', 'language3_home4_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(975, 'language3_home4_text38', 'language3_home4_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(976, 'language3_home4_text39', 'language3_home4_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(977, 'language3_home4_text40', 'language3_home4_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(978, 'language3_home4_text41', 'language3_home4_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(979, 'language3_home4_text42', 'language3_home4_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(980, 'language3_home4_text43', 'language3_home4_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(981, 'language3_home4_text44', 'language3_home4_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(982, 'language3_home4_text45', 'language3_home4_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(983, 'language3_home4_text46', 'language3_home4_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(984, 'language3_home4_text47', 'language3_home4_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(985, 'language3_home4_text48', 'language3_home4_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(986, 'language3_home4_text49', 'language3_home4_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(987, 'language3_home4_text50', 'language3_home4_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(988, 'language3_home4_text51', 'language3_home4_text51', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(989, 'language3_home4_text52', 'language3_home4_text52', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(990, 'language3_home4_text53', 'language3_home4_text53', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(991, 'language3_home4_text54', 'language3_home4_text54', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(992, 'language3_home4_text55', 'language3_home4_text55', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(993, 'language3_home4_text56', 'language3_home4_text56', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(994, 'language3_home4_text57', 'language3_home4_text57', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(995, 'language3_home4_text58', 'language3_home4_text58', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(996, 'language3_home4_text59', 'language3_home4_text59', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(997, 'language3_home4_text60', 'language3_home4_text60', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(998, 'language3_home5_text1', 'language3_home5_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(999, 'language3_home5_text2', 'language3_home5_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1000, 'language3_home5_text3', 'language3_home5_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1001, 'language3_home5_text4', 'language3_home5_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1002, 'language3_home5_text5', 'language3_home5_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1003, 'language3_home5_text6', 'language3_home5_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1004, 'language3_home5_text7', 'language3_home5_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1005, 'language3_home5_text8', 'language3_home5_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1006, 'language3_home5_text9', 'language3_home5_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1007, 'language3_home5_text10', 'language3_home5_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1008, 'language3_home5_text11', 'language3_home5_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1009, 'language3_home5_text12', 'language3_home5_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1010, 'language3_home5_text13', 'language3_home5_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1011, 'language3_home5_text14', 'language3_home5_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1012, 'language3_home5_text15', 'language3_home5_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1013, 'language3_home5_text16', 'language3_home5_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1014, 'language3_home5_text17', 'language3_home5_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1015, 'language3_home5_text18', 'language3_home5_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1016, 'language3_home5_text19', 'language3_home5_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1017, 'language3_home5_text20', 'language3_home5_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1018, 'language3_home5_text21', 'language3_home5_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1019, 'language3_home5_text22', 'language3_home5_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1020, 'language3_home5_text23', 'language3_home5_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1021, 'language3_home5_text24', 'language3_home5_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1022, 'language3_home5_text25', 'language3_home5_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1023, 'language3_home5_text26', 'language3_home5_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1024, 'language3_home5_text27', 'language3_home5_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1025, 'language3_home5_text28', 'language3_home5_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1026, 'language3_home5_text29', 'language3_home5_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1027, 'language3_home5_text30', 'language3_home5_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1028, 'language3_home5_text31', 'language3_home5_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1029, 'language3_home5_text32', 'language3_home5_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1030, 'language3_home5_text33', 'language3_home5_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1031, 'language3_home5_text34', 'language3_home5_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1032, 'language3_home5_text35', 'language3_home5_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1033, 'language3_home5_text36', 'language3_home5_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1034, 'language3_home5_text37', 'language3_home5_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1035, 'language3_home5_text38', 'language3_home5_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1036, 'language3_home5_text39', 'language3_home5_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1037, 'language3_home5_text40', 'language3_home5_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1038, 'language3_home5_text41', 'language3_home5_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1039, 'language3_home5_text42', 'language3_home5_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1040, 'language3_home5_text43', 'language3_home5_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1041, 'language3_home5_text44', 'language3_home5_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1042, 'language3_home5_text45', 'language3_home5_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1043, 'language3_home5_text46', 'language3_home5_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1044, 'language3_home5_text47', 'language3_home5_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1045, 'language3_home5_text48', 'language3_home5_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1046, 'language3_home5_text49', 'language3_home5_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1047, 'language3_home5_text50', 'language3_home5_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1048, 'language3_home6_text1', 'language3_home6_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1049, 'language3_home6_text2', 'language3_home6_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1050, 'language3_home6_text3', 'language3_home6_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1051, 'language3_home6_text4', 'language3_home6_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1052, 'language3_home6_text5', 'language3_home6_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1053, 'language3_home6_text6', 'language3_home6_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1054, 'language3_home6_text7', 'language3_home6_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1055, 'language3_home6_text8', 'language3_home6_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1056, 'language3_home6_text9', 'language3_home6_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1057, 'language3_home6_text10', 'language3_home6_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1058, 'language3_home6_text11', 'language3_home6_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1059, 'language3_home6_text12', 'language3_home6_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1060, 'language3_home6_text13', 'language3_home6_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1061, 'language3_home6_text14', 'language3_home6_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1062, 'language3_home6_text15', 'language3_home6_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1063, 'language3_home6_text16', 'language3_home6_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1064, 'language3_home6_text17', 'language3_home6_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1065, 'language3_home6_text18', 'language3_home6_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1066, 'language3_home6_text19', 'language3_home6_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1067, 'language3_home6_text20', 'language3_home6_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1068, 'language3_home7_text1', 'language3_home7_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1069, 'language3_home7_text2', 'language3_home7_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1070, 'language3_home7_text3', 'language3_home7_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1071, 'language3_home7_text4', 'language3_home7_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1072, 'language3_home7_text5', 'language3_home7_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1073, 'language3_home7_text6', 'language3_home7_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1074, 'language3_home7_text7', 'language3_home7_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1075, 'language3_home7_text8', 'language3_home7_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1076, 'language3_home7_text9', 'language3_home7_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1077, 'language3_home7_text10', 'language3_home7_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1078, 'language3_home7_text11', 'language3_home7_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1079, 'language3_home7_text12', 'language3_home7_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1080, 'language3_home7_text13', 'language3_home7_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1081, 'language3_home7_text14', 'language3_home7_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1082, 'language3_home7_text15', 'language3_home7_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1083, 'language3_home7_text16', 'language3_home7_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1084, 'language3_home7_text17', 'language3_home7_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1085, 'language3_home7_text18', 'language3_home7_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1086, 'language3_home7_text19', 'language3_home7_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1087, 'language3_home7_text20', 'language3_home7_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1088, 'language3_home7_text21', 'language3_home7_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1089, 'language3_home7_text22', 'language3_home7_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1090, 'language3_home7_text23', 'language3_home7_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1091, 'language3_home7_text24', 'language3_home7_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1092, 'language3_home7_text25', 'language3_home7_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1093, 'language3_home7_text26', 'language3_home7_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1094, 'language3_home7_text27', 'language3_home7_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1095, 'language3_home7_text28', 'language3_home7_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1096, 'language3_home7_text29', 'language3_home7_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1097, 'language3_home7_text30', 'language3_home7_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1098, 'language3_home8_text1', 'language3_home8_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1099, 'language3_home8_text2', 'language3_home8_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1100, 'language3_home8_text3', 'language3_home8_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1101, 'language3_home8_text4', 'language3_home8_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1102, 'language3_home8_text5', 'language3_home8_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1103, 'language3_home8_text6', 'language3_home8_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1104, 'language3_home8_text7', 'language3_home8_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1105, 'language3_home8_text8', 'language3_home8_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1106, 'language3_home8_text9', 'language3_home8_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1107, 'language3_home8_text10', 'language3_home8_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1108, 'language3_home8_text11', 'language3_home8_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1109, 'language3_home8_text12', 'language3_home8_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1110, 'language3_home8_text13', 'language3_home8_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1111, 'language3_home8_text14', 'language3_home8_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1112, 'language3_home8_text15', 'language3_home8_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1113, 'language3_home8_text16', 'language3_home8_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1114, 'language3_home8_text17', 'language3_home8_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1115, 'language3_home8_text18', 'language3_home8_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1116, 'language3_home8_text19', 'language3_home8_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1117, 'language3_home8_text20', 'language3_home8_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1118, 'language3_home8_text21', 'language3_home8_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1119, 'language3_home8_text22', 'language3_home8_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1120, 'language3_home8_text23', 'language3_home8_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1121, 'language3_home8_text24', 'language3_home8_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1122, 'language3_home8_text25', 'language3_home8_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1123, 'language3_home8_text26', 'language3_home8_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1124, 'language3_home8_text27', 'language3_home8_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1125, 'language3_home8_text28', 'language3_home8_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1126, 'language3_home8_text29', 'language3_home8_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1127, 'language3_home8_text30', 'language3_home8_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1128, 'language3_home9_text1', 'language3_home9_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1129, 'language3_home9_text2', 'language3_home9_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1130, 'language3_home9_text3', 'language3_home9_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1131, 'language3_home9_text4', 'language3_home9_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1132, 'language3_home9_text5', 'language3_home9_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1133, 'language3_home9_text6', 'language3_home9_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1134, 'language3_home9_text7', 'language3_home9_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1135, 'language3_home9_text8', 'language3_home9_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1136, 'language3_home9_text9', 'language3_home9_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1137, 'language3_home9_text10', 'language3_home9_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1138, 'language3_home9_text11', 'language3_home9_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1139, 'language3_home9_text12', 'language3_home9_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1140, 'language3_home9_text13', 'language3_home9_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1141, 'language3_home9_text14', 'language3_home9_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1142, 'language3_home9_text15', 'language3_home9_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1143, 'language3_home9_text16', 'language3_home9_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1144, 'language3_home9_text17', 'language3_home9_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1145, 'language3_home9_text18', 'language3_home9_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1146, 'language3_home9_text19', 'language3_home9_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1147, 'language3_home9_text20', 'language3_home9_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1148, 'language3_home9_text21', 'language3_home9_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1149, 'language3_home9_text22', 'language3_home9_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1150, 'language3_home9_text23', 'language3_home9_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1151, 'language3_home9_text24', 'language3_home9_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1152, 'language3_home9_text25', 'language3_home9_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1153, 'language3_home9_text26', 'language3_home9_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1154, 'language3_home9_text27', 'language3_home9_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1155, 'language3_home9_text28', 'language3_home9_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1156, 'language3_home9_text29', 'language3_home9_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1157, 'language3_home9_text30', 'language3_home9_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1158, 'language3_home9_text31', 'language3_home9_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1159, 'language3_home9_text32', 'language3_home9_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1160, 'language3_home9_text33', 'language3_home9_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1161, 'language3_home9_text34', 'language3_home9_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1162, 'language3_home9_text35', 'language3_home9_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1163, 'language3_home9_text36', 'language3_home9_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1164, 'language3_home9_text37', 'language3_home9_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1165, 'language3_home9_text38', 'language3_home9_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1166, 'language3_home9_text39', 'language3_home9_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1167, 'language3_home9_text40', 'language3_home9_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1168, 'language3_home9_text41', 'language3_home9_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1169, 'language3_home9_text42', 'language3_home9_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1170, 'language3_home9_text43', 'language3_home9_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1171, 'language3_home9_text44', 'language3_home9_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1172, 'language3_home9_text45', 'language3_home9_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1173, 'language3_home9_text46', 'language3_home9_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1174, 'language3_home9_text47', 'language3_home9_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1175, 'language3_home9_text48', 'language3_home9_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1176, 'language3_home9_text49', 'language3_home9_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1177, 'language3_home9_text50', 'language3_home9_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1178, 'language4_home1_text1', 'language4_home1_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1179, 'language4_home1_text2', 'language4_home1_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1180, 'language4_home1_text3', 'language4_home1_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1181, 'language4_home1_text4', 'language4_home1_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1182, 'language4_home1_text5', 'language4_home1_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1183, 'language4_home1_text6', 'language4_home1_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1184, 'language4_home1_text7', 'language4_home1_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1185, 'language4_home1_text8', 'language4_home1_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1186, 'language4_home1_text9', 'language4_home1_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1187, 'language4_home1_text10', 'language4_home1_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1188, 'language4_home1_text11', 'language4_home1_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1189, 'language4_home1_text12', 'language4_home1_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1190, 'language4_home1_text13', 'language4_home1_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1191, 'language4_home1_text14', 'language4_home1_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1192, 'language4_home1_text15', 'language4_home1_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1193, 'language4_home1_text16', 'language4_home1_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1194, 'language4_home1_text17', 'language4_home1_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1195, 'language4_home1_text18', 'language4_home1_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1196, 'language4_home1_text19', 'language4_home1_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1197, 'language4_home1_text20', 'language4_home1_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1198, 'language4_home1_text21', 'language4_home1_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1199, 'language4_home1_text22', 'language4_home1_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1200, 'language4_home1_text23', 'language4_home1_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1201, 'language4_home1_text24', 'language4_home1_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1202, 'language4_home1_text25', 'language4_home1_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1203, 'language4_home1_text26', 'language4_home1_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1204, 'language4_home1_text27', 'language4_home1_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1205, 'language4_home1_text28', 'language4_home1_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1206, 'language4_home1_text29', 'language4_home1_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1207, 'language4_home1_text30', 'language4_home1_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1208, 'language4_home2_text1', 'language4_home2_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1209, 'language4_home2_text2', 'language4_home2_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1210, 'language4_home2_text3', 'language4_home2_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1211, 'language4_home2_text4', 'language4_home2_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1212, 'language4_home2_text5', 'language4_home2_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1213, 'language4_home2_text6', 'language4_home2_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1214, 'language4_home2_text7', 'language4_home2_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1215, 'language4_home2_text8', 'language4_home2_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1216, 'language4_home2_text9', 'language4_home2_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1217, 'language4_home2_text10', 'language4_home2_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1218, 'language4_home2_text11', 'language4_home2_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1219, 'language4_home2_text12', 'language4_home2_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1220, 'language4_home2_text13', 'language4_home2_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1221, 'language4_home2_text14', 'language4_home2_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1222, 'language4_home2_text15', 'language4_home2_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1223, 'language4_home2_text16', 'language4_home2_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1224, 'language4_home2_text17', 'language4_home2_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1225, 'language4_home2_text18', 'language4_home2_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1226, 'language4_home2_text19', 'language4_home2_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1227, 'language4_home2_text20', 'language4_home2_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1228, 'language4_home2_text21', 'language4_home2_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1229, 'language4_home2_text22', 'language4_home2_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1230, 'language4_home2_text23', 'language4_home2_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1231, 'language4_home2_text24', 'language4_home2_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1232, 'language4_home2_text25', 'language4_home2_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1233, 'language4_home2_text26', 'language4_home2_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1234, 'language4_home2_text27', 'language4_home2_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1235, 'language4_home2_text28', 'language4_home2_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1236, 'language4_home2_text29', 'language4_home2_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1237, 'language4_home2_text30', 'language4_home2_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1238, 'language4_home3_text1', 'language4_home3_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1239, 'language4_home3_text2', 'language4_home3_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1240, 'language4_home3_text3', 'language4_home3_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1241, 'language4_home3_text4', 'language4_home3_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1242, 'language4_home3_text5', 'language4_home3_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1243, 'language4_home3_text6', 'language4_home3_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1244, 'language4_home3_text7', 'language4_home3_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1245, 'language4_home3_text8', 'language4_home3_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1246, 'language4_home3_text9', 'language4_home3_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1247, 'language4_home3_text10', 'language4_home3_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1248, 'language4_home3_text11', 'language4_home3_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1249, 'language4_home3_text12', 'language4_home3_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1250, 'language4_home3_text13', 'language4_home3_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1251, 'language4_home3_text14', 'language4_home3_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1252, 'language4_home3_text15', 'language4_home3_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1253, 'language4_home3_text16', 'language4_home3_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1254, 'language4_home3_text17', 'language4_home3_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1255, 'language4_home3_text18', 'language4_home3_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1256, 'language4_home3_text19', 'language4_home3_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1257, 'language4_home3_text20', 'language4_home3_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1258, 'language4_home3_text21', 'language4_home3_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1259, 'language4_home3_text22', 'language4_home3_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1260, 'language4_home3_text23', 'language4_home3_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1261, 'language4_home3_text24', 'language4_home3_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1262, 'language4_home3_text25', 'language4_home3_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1263, 'language4_home3_text26', 'language4_home3_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1264, 'language4_home3_text27', 'language4_home3_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1265, 'language4_home3_text28', 'language4_home3_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1266, 'language4_home3_text29', 'language4_home3_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1267, 'language4_home3_text30', 'language4_home3_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1268, 'language4_home4_text1', 'language4_home4_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1269, 'language4_home4_text2', 'language4_home4_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1270, 'language4_home4_text3', 'language4_home4_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1271, 'language4_home4_text4', 'language4_home4_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1272, 'language4_home4_text5', 'language4_home4_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1273, 'language4_home4_text6', 'language4_home4_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1274, 'language4_home4_text7', 'language4_home4_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1275, 'language4_home4_text8', 'language4_home4_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1276, 'language4_home4_text9', 'language4_home4_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1277, 'language4_home4_text10', 'language4_home4_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1278, 'language4_home4_text11', 'language4_home4_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1279, 'language4_home4_text12', 'language4_home4_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1280, 'language4_home4_text13', 'language4_home4_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1281, 'language4_home4_text14', 'language4_home4_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1282, 'language4_home4_text15', 'language4_home4_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1283, 'language4_home4_text16', 'language4_home4_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1284, 'language4_home4_text17', 'language4_home4_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1285, 'language4_home4_text18', 'language4_home4_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1286, 'language4_home4_text19', 'language4_home4_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1287, 'language4_home4_text20', 'language4_home4_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1288, 'language4_home4_text21', 'language4_home4_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1289, 'language4_home4_text22', 'language4_home4_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1290, 'language4_home4_text23', 'language4_home4_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1291, 'language4_home4_text24', 'language4_home4_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1292, 'language4_home4_text25', 'language4_home4_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1293, 'language4_home4_text26', 'language4_home4_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1294, 'language4_home4_text27', 'language4_home4_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1295, 'language4_home4_text28', 'language4_home4_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1296, 'language4_home4_text29', 'language4_home4_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1297, 'language4_home4_text30', 'language4_home4_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1298, 'language4_home4_text31', 'language4_home4_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1299, 'language4_home4_text32', 'language4_home4_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1300, 'language4_home4_text33', 'language4_home4_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1301, 'language4_home4_text34', 'language4_home4_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1302, 'language4_home4_text35', 'language4_home4_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1303, 'language4_home4_text36', 'language4_home4_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1304, 'language4_home4_text37', 'language4_home4_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1305, 'language4_home4_text38', 'language4_home4_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1306, 'language4_home4_text39', 'language4_home4_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1307, 'language4_home4_text40', 'language4_home4_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1308, 'language4_home4_text41', 'language4_home4_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1309, 'language4_home4_text42', 'language4_home4_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1310, 'language4_home4_text43', 'language4_home4_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1311, 'language4_home4_text44', 'language4_home4_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1312, 'language4_home4_text45', 'language4_home4_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1313, 'language4_home4_text46', 'language4_home4_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1314, 'language4_home4_text47', 'language4_home4_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1315, 'language4_home4_text48', 'language4_home4_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1316, 'language4_home4_text49', 'language4_home4_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1317, 'language4_home4_text50', 'language4_home4_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1318, 'language4_home4_text51', 'language4_home4_text51', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1319, 'language4_home4_text52', 'language4_home4_text52', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1320, 'language4_home4_text53', 'language4_home4_text53', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1321, 'language4_home4_text54', 'language4_home4_text54', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1322, 'language4_home4_text55', 'language4_home4_text55', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1323, 'language4_home4_text56', 'language4_home4_text56', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1324, 'language4_home4_text57', 'language4_home4_text57', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1325, 'language4_home4_text58', 'language4_home4_text58', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1326, 'language4_home4_text59', 'language4_home4_text59', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1327, 'language4_home4_text60', 'language4_home4_text60', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1328, 'language4_home5_text1', 'language4_home5_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1329, 'language4_home5_text2', 'language4_home5_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1330, 'language4_home5_text3', 'language4_home5_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1331, 'language4_home5_text4', 'language4_home5_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1332, 'language4_home5_text5', 'language4_home5_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1333, 'language4_home5_text6', 'language4_home5_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1334, 'language4_home5_text7', 'language4_home5_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1335, 'language4_home5_text8', 'language4_home5_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1336, 'language4_home5_text9', 'language4_home5_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1337, 'language4_home5_text10', 'language4_home5_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1338, 'language4_home5_text11', 'language4_home5_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1339, 'language4_home5_text12', 'language4_home5_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1340, 'language4_home5_text13', 'language4_home5_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1341, 'language4_home5_text14', 'language4_home5_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1342, 'language4_home5_text15', 'language4_home5_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1343, 'language4_home5_text16', 'language4_home5_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1344, 'language4_home5_text17', 'language4_home5_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1345, 'language4_home5_text18', 'language4_home5_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1346, 'language4_home5_text19', 'language4_home5_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1347, 'language4_home5_text20', 'language4_home5_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1348, 'language4_home5_text21', 'language4_home5_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1349, 'language4_home5_text22', 'language4_home5_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1350, 'language4_home5_text23', 'language4_home5_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1351, 'language4_home5_text24', 'language4_home5_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1352, 'language4_home5_text25', 'language4_home5_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1353, 'language4_home5_text26', 'language4_home5_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1354, 'language4_home5_text27', 'language4_home5_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1355, 'language4_home5_text28', 'language4_home5_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1356, 'language4_home5_text29', 'language4_home5_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1357, 'language4_home5_text30', 'language4_home5_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1358, 'language4_home5_text31', 'language4_home5_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1359, 'language4_home5_text32', 'language4_home5_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1360, 'language4_home5_text33', 'language4_home5_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1361, 'language4_home5_text34', 'language4_home5_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1362, 'language4_home5_text35', 'language4_home5_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1363, 'language4_home5_text36', 'language4_home5_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1364, 'language4_home5_text37', 'language4_home5_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1365, 'language4_home5_text38', 'language4_home5_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1366, 'language4_home5_text39', 'language4_home5_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1367, 'language4_home5_text40', 'language4_home5_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1368, 'language4_home5_text41', 'language4_home5_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1369, 'language4_home5_text42', 'language4_home5_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1370, 'language4_home5_text43', 'language4_home5_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1371, 'language4_home5_text44', 'language4_home5_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1372, 'language4_home5_text45', 'language4_home5_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1373, 'language4_home5_text46', 'language4_home5_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1374, 'language4_home5_text47', 'language4_home5_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1375, 'language4_home5_text48', 'language4_home5_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1376, 'language4_home5_text49', 'language4_home5_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1377, 'language4_home5_text50', 'language4_home5_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1378, 'language4_home6_text1', 'language4_home6_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1379, 'language4_home6_text2', 'language4_home6_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1380, 'language4_home6_text3', 'language4_home6_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1381, 'language4_home6_text4', 'language4_home6_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1382, 'language4_home6_text5', 'language4_home6_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1383, 'language4_home6_text6', 'language4_home6_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1384, 'language4_home6_text7', 'language4_home6_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1385, 'language4_home6_text8', 'language4_home6_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1386, 'language4_home6_text9', 'language4_home6_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1387, 'language4_home6_text10', 'language4_home6_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1388, 'language4_home6_text11', 'language4_home6_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1389, 'language4_home6_text12', 'language4_home6_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1390, 'language4_home6_text13', 'language4_home6_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1391, 'language4_home6_text14', 'language4_home6_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1392, 'language4_home6_text15', 'language4_home6_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1393, 'language4_home6_text16', 'language4_home6_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1394, 'language4_home6_text17', 'language4_home6_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1395, 'language4_home6_text18', 'language4_home6_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1396, 'language4_home6_text19', 'language4_home6_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1397, 'language4_home6_text20', 'language4_home6_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1398, 'language4_home7_text1', 'language4_home7_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1399, 'language4_home7_text2', 'language4_home7_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1400, 'language4_home7_text3', 'language4_home7_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1401, 'language4_home7_text4', 'language4_home7_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1402, 'language4_home7_text5', 'language4_home7_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1403, 'language4_home7_text6', 'language4_home7_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1404, 'language4_home7_text7', 'language4_home7_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1405, 'language4_home7_text8', 'language4_home7_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1406, 'language4_home7_text9', 'language4_home7_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1407, 'language4_home7_text10', 'language4_home7_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1408, 'language4_home7_text11', 'language4_home7_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1409, 'language4_home7_text12', 'language4_home7_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1410, 'language4_home7_text13', 'language4_home7_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1411, 'language4_home7_text14', 'language4_home7_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1412, 'language4_home7_text15', 'language4_home7_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1413, 'language4_home7_text16', 'language4_home7_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1414, 'language4_home7_text17', 'language4_home7_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1415, 'language4_home7_text18', 'language4_home7_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1416, 'language4_home7_text19', 'language4_home7_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1417, 'language4_home7_text20', 'language4_home7_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1418, 'language4_home7_text21', 'language4_home7_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1419, 'language4_home7_text22', 'language4_home7_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1420, 'language4_home7_text23', 'language4_home7_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1421, 'language4_home7_text24', 'language4_home7_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1422, 'language4_home7_text25', 'language4_home7_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1423, 'language4_home7_text26', 'language4_home7_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1424, 'language4_home7_text27', 'language4_home7_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1425, 'language4_home7_text28', 'language4_home7_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1426, 'language4_home7_text29', 'language4_home7_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1427, 'language4_home7_text30', 'language4_home7_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1428, 'language4_home8_text1', 'language4_home8_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1429, 'language4_home8_text2', 'language4_home8_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1430, 'language4_home8_text3', 'language4_home8_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1431, 'language4_home8_text4', 'language4_home8_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1432, 'language4_home8_text5', 'language4_home8_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1433, 'language4_home8_text6', 'language4_home8_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1434, 'language4_home8_text7', 'language4_home8_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1435, 'language4_home8_text8', 'language4_home8_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1436, 'language4_home8_text9', 'language4_home8_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1437, 'language4_home8_text10', 'language4_home8_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1438, 'language4_home8_text11', 'language4_home8_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1439, 'language4_home8_text12', 'language4_home8_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1440, 'language4_home8_text13', 'language4_home8_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1441, 'language4_home8_text14', 'language4_home8_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1442, 'language4_home8_text15', 'language4_home8_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1443, 'language4_home8_text16', 'language4_home8_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1444, 'language4_home8_text17', 'language4_home8_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1445, 'language4_home8_text18', 'language4_home8_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1446, 'language4_home8_text19', 'language4_home8_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1447, 'language4_home8_text20', 'language4_home8_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1448, 'language4_home8_text21', 'language4_home8_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1449, 'language4_home8_text22', 'language4_home8_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1450, 'language4_home8_text23', 'language4_home8_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1451, 'language4_home8_text24', 'language4_home8_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1452, 'language4_home8_text25', 'language4_home8_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1453, 'language4_home8_text26', 'language4_home8_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1454, 'language4_home8_text27', 'language4_home8_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1455, 'language4_home8_text28', 'language4_home8_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1456, 'language4_home8_text29', 'language4_home8_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1457, 'language4_home8_text30', 'language4_home8_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1458, 'language4_home9_text1', 'language4_home9_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1459, 'language4_home9_text2', 'language4_home9_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1460, 'language4_home9_text3', 'language4_home9_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1461, 'language4_home9_text4', 'language4_home9_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1462, 'language4_home9_text5', 'language4_home9_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1463, 'language4_home9_text6', 'language4_home9_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1464, 'language4_home9_text7', 'language4_home9_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1465, 'language4_home9_text8', 'language4_home9_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1466, 'language4_home9_text9', 'language4_home9_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1467, 'language4_home9_text10', 'language4_home9_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1468, 'language4_home9_text11', 'language4_home9_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1469, 'language4_home9_text12', 'language4_home9_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1470, 'language4_home9_text13', 'language4_home9_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1471, 'language4_home9_text14', 'language4_home9_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1472, 'language4_home9_text15', 'language4_home9_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1473, 'language4_home9_text16', 'language4_home9_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1474, 'language4_home9_text17', 'language4_home9_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1475, 'language4_home9_text18', 'language4_home9_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1476, 'language4_home9_text19', 'language4_home9_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1477, 'language4_home9_text20', 'language4_home9_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1478, 'language4_home9_text21', 'language4_home9_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1479, 'language4_home9_text22', 'language4_home9_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1480, 'language4_home9_text23', 'language4_home9_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1481, 'language4_home9_text24', 'language4_home9_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1482, 'language4_home9_text25', 'language4_home9_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1483, 'language4_home9_text26', 'language4_home9_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1484, 'language4_home9_text27', 'language4_home9_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1485, 'language4_home9_text28', 'language4_home9_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1486, 'language4_home9_text29', 'language4_home9_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1487, 'language4_home9_text30', 'language4_home9_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1488, 'language4_home9_text31', 'language4_home9_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1489, 'language4_home9_text32', 'language4_home9_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1490, 'language4_home9_text33', 'language4_home9_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1491, 'language4_home9_text34', 'language4_home9_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1492, 'language4_home9_text35', 'language4_home9_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1493, 'language4_home9_text36', 'language4_home9_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1494, 'language4_home9_text37', 'language4_home9_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1495, 'language4_home9_text38', 'language4_home9_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1496, 'language4_home9_text39', 'language4_home9_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1497, 'language4_home9_text40', 'language4_home9_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1498, 'language4_home9_text41', 'language4_home9_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1499, 'language4_home9_text42', 'language4_home9_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1500, 'language4_home9_text43', 'language4_home9_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1501, 'language4_home9_text44', 'language4_home9_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1502, 'language4_home9_text45', 'language4_home9_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1503, 'language4_home9_text46', 'language4_home9_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1504, 'language4_home9_text47', 'language4_home9_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1505, 'language4_home9_text48', 'language4_home9_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1506, 'language4_home9_text49', 'language4_home9_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1507, 'language4_home9_text50', 'language4_home9_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1508, 'language5_home1_text1', 'language5_home1_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1509, 'language5_home1_text2', 'language5_home1_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1510, 'language5_home1_text3', 'language5_home1_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1511, 'language5_home1_text4', 'language5_home1_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1512, 'language5_home1_text5', 'language5_home1_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1513, 'language5_home1_text6', 'language5_home1_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1514, 'language5_home1_text7', 'language5_home1_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1515, 'language5_home1_text8', 'language5_home1_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1516, 'language5_home1_text9', 'language5_home1_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1517, 'language5_home1_text10', 'language5_home1_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1518, 'language5_home1_text11', 'language5_home1_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1519, 'language5_home1_text12', 'language5_home1_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1520, 'language5_home1_text13', 'language5_home1_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1521, 'language5_home1_text14', 'language5_home1_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1522, 'language5_home1_text15', 'language5_home1_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1523, 'language5_home1_text16', 'language5_home1_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1524, 'language5_home1_text17', 'language5_home1_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1525, 'language5_home1_text18', 'language5_home1_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1526, 'language5_home1_text19', 'language5_home1_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1527, 'language5_home1_text20', 'language5_home1_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1528, 'language5_home1_text21', 'language5_home1_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1529, 'language5_home1_text22', 'language5_home1_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1530, 'language5_home1_text23', 'language5_home1_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1531, 'language5_home1_text24', 'language5_home1_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1532, 'language5_home1_text25', 'language5_home1_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1533, 'language5_home1_text26', 'language5_home1_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1534, 'language5_home1_text27', 'language5_home1_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1535, 'language5_home1_text28', 'language5_home1_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1536, 'language5_home1_text29', 'language5_home1_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1537, 'language5_home1_text30', 'language5_home1_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1538, 'language5_home2_text1', 'language5_home2_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1539, 'language5_home2_text2', 'language5_home2_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1540, 'language5_home2_text3', 'language5_home2_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1541, 'language5_home2_text4', 'language5_home2_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1542, 'language5_home2_text5', 'language5_home2_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1543, 'language5_home2_text6', 'language5_home2_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1544, 'language5_home2_text7', 'language5_home2_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1545, 'language5_home2_text8', 'language5_home2_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1546, 'language5_home2_text9', 'language5_home2_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1547, 'language5_home2_text10', 'language5_home2_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1548, 'language5_home2_text11', 'language5_home2_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1549, 'language5_home2_text12', 'language5_home2_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1550, 'language5_home2_text13', 'language5_home2_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1551, 'language5_home2_text14', 'language5_home2_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1552, 'language5_home2_text15', 'language5_home2_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1553, 'language5_home2_text16', 'language5_home2_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1554, 'language5_home2_text17', 'language5_home2_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1555, 'language5_home2_text18', 'language5_home2_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1556, 'language5_home2_text19', 'language5_home2_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1557, 'language5_home2_text20', 'language5_home2_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1558, 'language5_home2_text21', 'language5_home2_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1559, 'language5_home2_text22', 'language5_home2_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1560, 'language5_home2_text23', 'language5_home2_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1561, 'language5_home2_text24', 'language5_home2_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1562, 'language5_home2_text25', 'language5_home2_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1563, 'language5_home2_text26', 'language5_home2_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1564, 'language5_home2_text27', 'language5_home2_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1565, 'language5_home2_text28', 'language5_home2_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1566, 'language5_home2_text29', 'language5_home2_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1567, 'language5_home2_text30', 'language5_home2_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1568, 'language5_home3_text1', 'language5_home3_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1569, 'language5_home3_text2', 'language5_home3_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1570, 'language5_home3_text3', 'language5_home3_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1571, 'language5_home3_text4', 'language5_home3_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1572, 'language5_home3_text5', 'language5_home3_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1573, 'language5_home3_text6', 'language5_home3_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1574, 'language5_home3_text7', 'language5_home3_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1575, 'language5_home3_text8', 'language5_home3_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1576, 'language5_home3_text9', 'language5_home3_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1577, 'language5_home3_text10', 'language5_home3_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1578, 'language5_home3_text11', 'language5_home3_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1579, 'language5_home3_text12', 'language5_home3_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1580, 'language5_home3_text13', 'language5_home3_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1581, 'language5_home3_text14', 'language5_home3_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1582, 'language5_home3_text15', 'language5_home3_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1583, 'language5_home3_text16', 'language5_home3_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1584, 'language5_home3_text17', 'language5_home3_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1585, 'language5_home3_text18', 'language5_home3_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1586, 'language5_home3_text19', 'language5_home3_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1587, 'language5_home3_text20', 'language5_home3_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1588, 'language5_home3_text21', 'language5_home3_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1589, 'language5_home3_text22', 'language5_home3_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1590, 'language5_home3_text23', 'language5_home3_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1591, 'language5_home3_text24', 'language5_home3_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1592, 'language5_home3_text25', 'language5_home3_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1593, 'language5_home3_text26', 'language5_home3_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1594, 'language5_home3_text27', 'language5_home3_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1595, 'language5_home3_text28', 'language5_home3_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1596, 'language5_home3_text29', 'language5_home3_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1597, 'language5_home3_text30', 'language5_home3_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1598, 'language5_home4_text1', 'language5_home4_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1599, 'language5_home4_text2', 'language5_home4_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1600, 'language5_home4_text3', 'language5_home4_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1601, 'language5_home4_text4', 'language5_home4_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1602, 'language5_home4_text5', 'language5_home4_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1603, 'language5_home4_text6', 'language5_home4_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1604, 'language5_home4_text7', 'language5_home4_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1605, 'language5_home4_text8', 'language5_home4_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1606, 'language5_home4_text9', 'language5_home4_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1607, 'language5_home4_text10', 'language5_home4_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1608, 'language5_home4_text11', 'language5_home4_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1609, 'language5_home4_text12', 'language5_home4_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1610, 'language5_home4_text13', 'language5_home4_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1611, 'language5_home4_text14', 'language5_home4_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1612, 'language5_home4_text15', 'language5_home4_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1613, 'language5_home4_text16', 'language5_home4_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1614, 'language5_home4_text17', 'language5_home4_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1615, 'language5_home4_text18', 'language5_home4_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1616, 'language5_home4_text19', 'language5_home4_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1617, 'language5_home4_text20', 'language5_home4_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1618, 'language5_home4_text21', 'language5_home4_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1619, 'language5_home4_text22', 'language5_home4_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1620, 'language5_home4_text23', 'language5_home4_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1621, 'language5_home4_text24', 'language5_home4_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1622, 'language5_home4_text25', 'language5_home4_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1623, 'language5_home4_text26', 'language5_home4_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1624, 'language5_home4_text27', 'language5_home4_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1625, 'language5_home4_text28', 'language5_home4_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1626, 'language5_home4_text29', 'language5_home4_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1627, 'language5_home4_text30', 'language5_home4_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1628, 'language5_home4_text31', 'language5_home4_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1629, 'language5_home4_text32', 'language5_home4_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1630, 'language5_home4_text33', 'language5_home4_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1631, 'language5_home4_text34', 'language5_home4_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1632, 'language5_home4_text35', 'language5_home4_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1633, 'language5_home4_text36', 'language5_home4_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1634, 'language5_home4_text37', 'language5_home4_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1635, 'language5_home4_text38', 'language5_home4_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1636, 'language5_home4_text39', 'language5_home4_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1637, 'language5_home4_text40', 'language5_home4_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1638, 'language5_home4_text41', 'language5_home4_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1639, 'language5_home4_text42', 'language5_home4_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1640, 'language5_home4_text43', 'language5_home4_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1641, 'language5_home4_text44', 'language5_home4_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1642, 'language5_home4_text45', 'language5_home4_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1643, 'language5_home4_text46', 'language5_home4_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1644, 'language5_home4_text47', 'language5_home4_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1645, 'language5_home4_text48', 'language5_home4_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1646, 'language5_home4_text49', 'language5_home4_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1647, 'language5_home4_text50', 'language5_home4_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1648, 'language5_home4_text51', 'language5_home4_text51', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1649, 'language5_home4_text52', 'language5_home4_text52', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1650, 'language5_home4_text53', 'language5_home4_text53', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1651, 'language5_home4_text54', 'language5_home4_text54', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1652, 'language5_home4_text55', 'language5_home4_text55', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1653, 'language5_home4_text56', 'language5_home4_text56', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1654, 'language5_home4_text57', 'language5_home4_text57', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1655, 'language5_home4_text58', 'language5_home4_text58', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1656, 'language5_home4_text59', 'language5_home4_text59', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1657, 'language5_home4_text60', 'language5_home4_text60', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1658, 'language5_home5_text1', 'language5_home5_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1659, 'language5_home5_text2', 'language5_home5_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1660, 'language5_home5_text3', 'language5_home5_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1661, 'language5_home5_text4', 'language5_home5_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1662, 'language5_home5_text5', 'language5_home5_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1663, 'language5_home5_text6', 'language5_home5_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1664, 'language5_home5_text7', 'language5_home5_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1665, 'language5_home5_text8', 'language5_home5_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1666, 'language5_home5_text9', 'language5_home5_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1667, 'language5_home5_text10', 'language5_home5_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1668, 'language5_home5_text11', 'language5_home5_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1669, 'language5_home5_text12', 'language5_home5_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1670, 'language5_home5_text13', 'language5_home5_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1671, 'language5_home5_text14', 'language5_home5_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1672, 'language5_home5_text15', 'language5_home5_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1673, 'language5_home5_text16', 'language5_home5_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1674, 'language5_home5_text17', 'language5_home5_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1675, 'language5_home5_text18', 'language5_home5_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1676, 'language5_home5_text19', 'language5_home5_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1677, 'language5_home5_text20', 'language5_home5_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1678, 'language5_home5_text21', 'language5_home5_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1679, 'language5_home5_text22', 'language5_home5_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1680, 'language5_home5_text23', 'language5_home5_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1681, 'language5_home5_text24', 'language5_home5_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1682, 'language5_home5_text25', 'language5_home5_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1683, 'language5_home5_text26', 'language5_home5_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1684, 'language5_home5_text27', 'language5_home5_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1685, 'language5_home5_text28', 'language5_home5_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1686, 'language5_home5_text29', 'language5_home5_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1687, 'language5_home5_text30', 'language5_home5_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1688, 'language5_home5_text31', 'language5_home5_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1689, 'language5_home5_text32', 'language5_home5_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1690, 'language5_home5_text33', 'language5_home5_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1691, 'language5_home5_text34', 'language5_home5_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1692, 'language5_home5_text35', 'language5_home5_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1693, 'language5_home5_text36', 'language5_home5_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1694, 'language5_home5_text37', 'language5_home5_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1695, 'language5_home5_text38', 'language5_home5_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1696, 'language5_home5_text39', 'language5_home5_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1697, 'language5_home5_text40', 'language5_home5_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1698, 'language5_home5_text41', 'language5_home5_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1699, 'language5_home5_text42', 'language5_home5_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1700, 'language5_home5_text43', 'language5_home5_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1701, 'language5_home5_text44', 'language5_home5_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1702, 'language5_home5_text45', 'language5_home5_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1703, 'language5_home5_text46', 'language5_home5_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1704, 'language5_home5_text47', 'language5_home5_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1705, 'language5_home5_text48', 'language5_home5_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1706, 'language5_home5_text49', 'language5_home5_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1707, 'language5_home5_text50', 'language5_home5_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1708, 'language5_home6_text1', 'language5_home6_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1709, 'language5_home6_text2', 'language5_home6_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1710, 'language5_home6_text3', 'language5_home6_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1711, 'language5_home6_text4', 'language5_home6_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1712, 'language5_home6_text5', 'language5_home6_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1713, 'language5_home6_text6', 'language5_home6_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1714, 'language5_home6_text7', 'language5_home6_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1715, 'language5_home6_text8', 'language5_home6_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1716, 'language5_home6_text9', 'language5_home6_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1717, 'language5_home6_text10', 'language5_home6_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1718, 'language5_home6_text11', 'language5_home6_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1719, 'language5_home6_text12', 'language5_home6_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1720, 'language5_home6_text13', 'language5_home6_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1721, 'language5_home6_text14', 'language5_home6_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1722, 'language5_home6_text15', 'language5_home6_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1723, 'language5_home6_text16', 'language5_home6_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1724, 'language5_home6_text17', 'language5_home6_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1725, 'language5_home6_text18', 'language5_home6_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1726, 'language5_home6_text19', 'language5_home6_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1727, 'language5_home6_text20', 'language5_home6_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1728, 'language5_home7_text1', 'language5_home7_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1729, 'language5_home7_text2', 'language5_home7_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1730, 'language5_home7_text3', 'language5_home7_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1731, 'language5_home7_text4', 'language5_home7_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1732, 'language5_home7_text5', 'language5_home7_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1733, 'language5_home7_text6', 'language5_home7_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1734, 'language5_home7_text7', 'language5_home7_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1735, 'language5_home7_text8', 'language5_home7_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1736, 'language5_home7_text9', 'language5_home7_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1737, 'language5_home7_text10', 'language5_home7_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1738, 'language5_home7_text11', 'language5_home7_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1739, 'language5_home7_text12', 'language5_home7_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1740, 'language5_home7_text13', 'language5_home7_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1741, 'language5_home7_text14', 'language5_home7_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1742, 'language5_home7_text15', 'language5_home7_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1743, 'language5_home7_text16', 'language5_home7_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1744, 'language5_home7_text17', 'language5_home7_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1745, 'language5_home7_text18', 'language5_home7_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1746, 'language5_home7_text19', 'language5_home7_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1747, 'language5_home7_text20', 'language5_home7_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1748, 'language5_home7_text21', 'language5_home7_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1749, 'language5_home7_text22', 'language5_home7_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1750, 'language5_home7_text23', 'language5_home7_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1751, 'language5_home7_text24', 'language5_home7_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1752, 'language5_home7_text25', 'language5_home7_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1753, 'language5_home7_text26', 'language5_home7_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1754, 'language5_home7_text27', 'language5_home7_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1755, 'language5_home7_text28', 'language5_home7_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1756, 'language5_home7_text29', 'language5_home7_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1757, 'language5_home7_text30', 'language5_home7_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1758, 'language5_home8_text1', 'language5_home8_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1759, 'language5_home8_text2', 'language5_home8_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1760, 'language5_home8_text3', 'language5_home8_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1761, 'language5_home8_text4', 'language5_home8_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1762, 'language5_home8_text5', 'language5_home8_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1763, 'language5_home8_text6', 'language5_home8_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1764, 'language5_home8_text7', 'language5_home8_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1765, 'language5_home8_text8', 'language5_home8_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1766, 'language5_home8_text9', 'language5_home8_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1767, 'language5_home8_text10', 'language5_home8_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1768, 'language5_home8_text11', 'language5_home8_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1769, 'language5_home8_text12', 'language5_home8_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1770, 'language5_home8_text13', 'language5_home8_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1771, 'language5_home8_text14', 'language5_home8_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1772, 'language5_home8_text15', 'language5_home8_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1773, 'language5_home8_text16', 'language5_home8_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1774, 'language5_home8_text17', 'language5_home8_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1775, 'language5_home8_text18', 'language5_home8_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1776, 'language5_home8_text19', 'language5_home8_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1777, 'language5_home8_text20', 'language5_home8_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1778, 'language5_home8_text21', 'language5_home8_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1779, 'language5_home8_text22', 'language5_home8_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1780, 'language5_home8_text23', 'language5_home8_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1781, 'language5_home8_text24', 'language5_home8_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1782, 'language5_home8_text25', 'language5_home8_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1783, 'language5_home8_text26', 'language5_home8_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1784, 'language5_home8_text27', 'language5_home8_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1785, 'language5_home8_text28', 'language5_home8_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1786, 'language5_home8_text29', 'language5_home8_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1787, 'language5_home8_text30', 'language5_home8_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1788, 'language5_home9_text1', 'language5_home9_text1', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1789, 'language5_home9_text2', 'language5_home9_text2', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1790, 'language5_home9_text3', 'language5_home9_text3', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1791, 'language5_home9_text4', 'language5_home9_text4', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1792, 'language5_home9_text5', 'language5_home9_text5', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1793, 'language5_home9_text6', 'language5_home9_text6', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1794, 'language5_home9_text7', 'language5_home9_text7', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1795, 'language5_home9_text8', 'language5_home9_text8', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1796, 'language5_home9_text9', 'language5_home9_text9', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1797, 'language5_home9_text10', 'language5_home9_text10', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1798, 'language5_home9_text11', 'language5_home9_text11', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1799, 'language5_home9_text12', 'language5_home9_text12', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1800, 'language5_home9_text13', 'language5_home9_text13', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1801, 'language5_home9_text14', 'language5_home9_text14', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1802, 'language5_home9_text15', 'language5_home9_text15', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1803, 'language5_home9_text16', 'language5_home9_text16', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1804, 'language5_home9_text17', 'language5_home9_text17', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1805, 'language5_home9_text18', 'language5_home9_text18', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1806, 'language5_home9_text19', 'language5_home9_text19', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1807, 'language5_home9_text20', 'language5_home9_text20', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1808, 'language5_home9_text21', 'language5_home9_text21', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1809, 'language5_home9_text22', 'language5_home9_text22', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1810, 'language5_home9_text23', 'language5_home9_text23', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1811, 'language5_home9_text24', 'language5_home9_text24', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1812, 'language5_home9_text25', 'language5_home9_text25', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1813, 'language5_home9_text26', 'language5_home9_text26', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1814, 'language5_home9_text27', 'language5_home9_text27', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1815, 'language5_home9_text28', 'language5_home9_text28', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1816, 'language5_home9_text29', 'language5_home9_text29', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1817, 'language5_home9_text30', 'language5_home9_text30', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1818, 'language5_home9_text31', 'language5_home9_text31', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1819, 'language5_home9_text32', 'language5_home9_text32', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1820, 'language5_home9_text33', 'language5_home9_text33', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1821, 'language5_home9_text34', 'language5_home9_text34', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1822, 'language5_home9_text35', 'language5_home9_text35', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1823, 'language5_home9_text36', 'language5_home9_text36', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1824, 'language5_home9_text37', 'language5_home9_text37', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1825, 'language5_home9_text38', 'language5_home9_text38', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1826, 'language5_home9_text39', 'language5_home9_text39', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1827, 'language5_home9_text40', 'language5_home9_text40', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1828, 'language5_home9_text41', 'language5_home9_text41', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1829, 'language5_home9_text42', 'language5_home9_text42', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1830, 'language5_home9_text43', 'language5_home9_text43', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1831, 'language5_home9_text44', 'language5_home9_text44', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1832, 'language5_home9_text45', 'language5_home9_text45', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1833, 'language5_home9_text46', 'language5_home9_text46', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1834, 'language5_home9_text47', 'language5_home9_text47', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1835, 'language5_home9_text48', 'language5_home9_text48', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1836, 'language5_home9_text49', 'language5_home9_text49', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1837, 'language5_home9_text50', 'language5_home9_text50', 'kundol_web_setting', NULL, NULL, NULL, NULL),
(1838, 'api_key', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1839, 'auth_domain', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1840, 'database_url', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1841, 'peoject_id', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1842, 'storage_bucket', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1843, 'messaging_sender_id', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1844, 'app_id', '', 'business_firebase_setting', NULL, NULL, NULL, NULL),
(1845, 'google_map_api_string', '', 'business_google_setting', NULL, NULL, NULL, NULL),
(1846, 'same_for_billing', '1', 'business_general', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `methods_type_link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL COMMENT '1 for active 0 for inactive',
  `status` tinyint(1) NOT NULL COMMENT '1 for active 0 for inactive',
  `amount` double(8,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `methods_type_link`, `is_default`, `status`, `amount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'shippingByWeight', 0, 1, 0.00, NULL, NULL, NULL, NULL),
(2, 'localPickup', 0, 1, 0.00, NULL, NULL, NULL, NULL),
(3, 'freeShipping', 0, 1, 0.00, NULL, NULL, NULL, NULL),
(4, 'flateRate', 1, 1, 25.00, NULL, NULL, NULL, NULL),
(5, 'shipmentwithcity', 1, 1, 100.00, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method_descriptions`
--

CREATE TABLE `shipping_method_descriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_method_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_method_descriptions`
--

INSERT INTO `shipping_method_descriptions` (`id`, `name`, `language_id`, `shipping_method_id`) VALUES
(1, 'shippingByWeight', 1, 1),
(2, 'localPickup', 1, 2),
(3, 'freeShipping', 1, 3),
(4, 'flateRate', 1, 4),
(5, 'shipmentwithcity', 1, 5),
(6, 'shippingByWeight', 2, 1),
(7, 'localPickup', 2, 2),
(8, 'freeShipping', 2, 3),
(9, 'flateRate', 2, 4),
(10, 'shipmentwithcity', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `shippment_with_cities`
--

CREATE TABLE `shippment_with_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shippment_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_method_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` enum('position-right','position-left','position-center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `textcontent` enum('textcontent-right','textcontent-left','textcontent-center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` enum('text-white','text-black') COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `slider_type_id` bigint(20) UNSIGNED NOT NULL,
  `slider_navigation_id` bigint(20) UNSIGNED NOT NULL,
  `gallary_id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `description`, `position`, `textcontent`, `text`, `language_id`, `slider_type_id`, `slider_navigation_id`, `gallary_id`, `ref_id`, `url`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Slider 1', 'Slider 1 Text Goes Here', 'position-left', 'textcontent-left', 'text-black', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(2, 'المنزلق 1', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-left', 'text-black', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(3, 'Slider 2', 'Slider 2 Text Goes Here', 'position-left', 'textcontent-right', 'text-black', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(4, 'المنزلق 2', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-right', 'text-black', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(5, 'Slider 3', 'Slider 3 Text Goes Here', 'position-left', 'textcontent-center', 'text-white', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(6, 'المنزلق 3', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-center', 'text-white', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(7, 'Slider 4', 'Slider 4 Text Goes Here', 'position-right', 'textcontent-left', 'text-black', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(8, 'المنزلق 4', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-left', 'text-black', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(9, 'Slider 5', 'Slider 5 Text Goes Here', 'position-right', 'textcontent-right', 'text-black', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(10, 'المنزلق 5', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-right', 'text-black', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(11, 'Slider 6', 'Slider 6 Text Goes Here', 'position-right', 'textcontent-center', 'text-white', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(12, 'المنزلق 6', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-center', 'text-white', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(13, 'Slider 7', 'Slider 7 Text Goes Here', 'position-center', 'textcontent-left', 'text-black', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(14, 'المنزلق 7', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-left', 'text-black', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(15, 'Slider 8', 'Slider 8 Text Goes Here', 'position-center', 'textcontent-right', 'text-black', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(16, 'المنزلق 8', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-right', 'text-black', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(17, 'Slider 9', 'Slider 9 Text Goes Here', 'position-center', 'textcontent-center', 'text-white', 1, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(18, 'المنزلق 9', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-center', 'text-white', 2, 1, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(19, 'Slider 1', 'Slider 1 Text Goes Here', 'position-left', 'textcontent-left', 'text-black', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(20, 'المنزلق 1', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-left', 'text-black', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(21, 'Slider 2', 'Slider 2 Text Goes Here', 'position-left', 'textcontent-right', 'text-black', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(22, 'المنزلق 2', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-right', 'text-black', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(23, 'Slider 3', 'Slider 3 Text Goes Here', 'position-left', 'textcontent-center', 'text-white', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(24, 'المنزلق 3', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-center', 'text-white', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(25, 'Slider 4', 'Slider 4 Text Goes Here', 'position-right', 'textcontent-left', 'text-black', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(26, 'المنزلق 4', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-left', 'text-black', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(27, 'Slider 5', 'Slider 5 Text Goes Here', 'position-right', 'textcontent-right', 'text-black', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(28, 'المنزلق 5', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-right', 'text-black', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(29, 'Slider 6', 'Slider 6 Text Goes Here', 'position-right', 'textcontent-center', 'text-white', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(30, 'المنزلق 6', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-center', 'text-white', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(31, 'Slider 7', 'Slider 7 Text Goes Here', 'position-center', 'textcontent-left', 'text-black', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(32, 'المنزلق 7', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-left', 'text-black', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(33, 'Slider 8', 'Slider 8 Text Goes Here', 'position-center', 'textcontent-right', 'text-black', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(34, 'المنزلق 8', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-right', 'text-black', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(35, 'Slider 9', 'Slider 9 Text Goes Here', 'position-center', 'textcontent-center', 'text-white', 1, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(36, 'المنزلق 9', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-center', 'text-white', 2, 2, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(37, 'Slider 1', 'Slider 1 Text Goes Here', 'position-left', 'textcontent-left', 'text-black', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(38, 'المنزلق 1', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-left', 'text-black', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(39, 'Slider 2', 'Slider 2 Text Goes Here', 'position-left', 'textcontent-right', 'text-black', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(40, 'المنزلق 2', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-right', 'text-black', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(41, 'Slider 3', 'Slider 3 Text Goes Here', 'position-left', 'textcontent-center', 'text-white', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(42, 'المنزلق 3', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-center', 'text-white', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(43, 'Slider 4', 'Slider 4 Text Goes Here', 'position-right', 'textcontent-left', 'text-black', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(44, 'المنزلق 4', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-left', 'text-black', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(45, 'Slider 5', 'Slider 5 Text Goes Here', 'position-right', 'textcontent-right', 'text-black', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(46, 'المنزلق 5', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-right', 'text-black', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(47, 'Slider 6', 'Slider 6 Text Goes Here', 'position-right', 'textcontent-center', 'text-white', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(48, 'المنزلق 6', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-center', 'text-white', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(49, 'Slider 7', 'Slider 7 Text Goes Here', 'position-center', 'textcontent-left', 'text-black', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(50, 'المنزلق 7', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-left', 'text-black', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(51, 'Slider 8', 'Slider 8 Text Goes Here', 'position-center', 'textcontent-right', 'text-black', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(52, 'المنزلق 8', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-right', 'text-black', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(53, 'Slider 9', 'Slider 9 Text Goes Here', 'position-center', 'textcontent-center', 'text-white', 1, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(54, 'المنزلق 9', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-center', 'text-white', 2, 3, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(55, 'Slider 1', 'Slider 1 Text Goes Here', 'position-left', 'textcontent-left', 'text-black', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(56, 'المنزلق 1', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-left', 'text-black', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(57, 'Slider 2', 'Slider 2 Text Goes Here', 'position-left', 'textcontent-right', 'text-black', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(58, 'المنزلق 2', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-right', 'text-black', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(59, 'Slider 3', 'Slider 3 Text Goes Here', 'position-left', 'textcontent-center', 'text-white', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(60, 'المنزلق 3', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-center', 'text-white', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(61, 'Slider 4', 'Slider 4 Text Goes Here', 'position-right', 'textcontent-left', 'text-black', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(62, 'المنزلق 4', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-left', 'text-black', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(63, 'Slider 5', 'Slider 5 Text Goes Here', 'position-right', 'textcontent-right', 'text-black', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(64, 'المنزلق 5', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-right', 'text-black', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(65, 'Slider 6', 'Slider 6 Text Goes Here', 'position-right', 'textcontent-center', 'text-white', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(66, 'المنزلق 6', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-center', 'text-white', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(67, 'Slider 7', 'Slider 7 Text Goes Here', 'position-center', 'textcontent-left', 'text-black', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(68, 'المنزلق 7', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-left', 'text-black', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(69, 'Slider 8', 'Slider 8 Text Goes Here', 'position-center', 'textcontent-right', 'text-black', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(70, 'المنزلق 8', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-right', 'text-black', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(71, 'Slider 9', 'Slider 9 Text Goes Here', 'position-center', 'textcontent-center', 'text-white', 1, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(72, 'المنزلق 9', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-center', 'text-white', 2, 4, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(73, 'Slider 1', 'Slider 1 Text Goes Here', 'position-left', 'textcontent-left', 'text-black', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(74, 'المنزلق 1', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-left', 'text-black', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(75, 'Slider 2', 'Slider 2 Text Goes Here', 'position-left', 'textcontent-right', 'text-black', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(76, 'المنزلق 2', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-right', 'text-black', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(77, 'Slider 3', 'Slider 3 Text Goes Here', 'position-left', 'textcontent-center', 'text-white', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(78, 'المنزلق 3', 'يظهر النص المنزلق هنا', 'position-left', 'textcontent-center', 'text-white', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(79, 'Slider 4', 'Slider 4 Text Goes Here', 'position-right', 'textcontent-left', 'text-black', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(80, 'المنزلق 4', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-left', 'text-black', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(81, 'Slider 5', 'Slider 5 Text Goes Here', 'position-right', 'textcontent-right', 'text-black', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(82, 'المنزلق 5', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-right', 'text-black', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(83, 'Slider 6', 'Slider 6 Text Goes Here', 'position-right', 'textcontent-center', 'text-white', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(84, 'المنزلق 6', 'يظهر النص المنزلق هنا', 'position-right', 'textcontent-center', 'text-white', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(85, 'Slider 7', 'Slider 7 Text Goes Here', 'position-center', 'textcontent-left', 'text-black', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(86, 'المنزلق 7', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-left', 'text-black', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(87, 'Slider 8', 'Slider 8 Text Goes Here', 'position-center', 'textcontent-right', 'text-black', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(88, 'المنزلق 8', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-right', 'text-black', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(89, 'Slider 9', 'Slider 9 Text Goes Here', 'position-center', 'textcontent-center', 'text-white', 1, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL),
(90, 'المنزلق 9', 'يظهر النص المنزلق هنا', 'position-center', 'textcontent-center', 'text-white', 2, 5, 4, 2, 0, 'https://codecanyon.net/user/themes-coder', 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `slider_navigation`
--

CREATE TABLE `slider_navigation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_navigation`
--

INSERT INTO `slider_navigation` (`id`, `name`) VALUES
(1, 'Category'),
(2, 'Product'),
(3, 'Page'),
(4, 'Link');

-- --------------------------------------------------------

--
-- Table structure for table `slider_types`
--

CREATE TABLE `slider_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_types`
--

INSERT INTO `slider_types` (`id`, `name`) VALUES
(1, 'Full Screen Slider (1600x420)'),
(2, 'Full Page Slider (1170x420)'),
(3, 'Right Slider with Thumbs (770x400)'),
(4, 'Right Slider with Navigation (770x400)'),
(5, 'Left Slider with Thumbs (770x400)');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Southern Nations, Nationalities, and Peoples\' Region', 70, 'inactive', NULL, NULL, NULL),
(2, 'Somali Region', 70, 'inactive', NULL, NULL, NULL),
(3, 'Amhara Region', 70, 'inactive', NULL, NULL, NULL),
(4, 'Tigray Region', 70, 'inactive', NULL, NULL, NULL),
(5, 'Oromia Region', 70, 'inactive', NULL, NULL, NULL),
(6, 'Afar Region', 70, 'inactive', NULL, NULL, NULL),
(7, 'Harari Region', 70, 'inactive', NULL, NULL, NULL),
(8, 'Dire Dawa', 70, 'inactive', NULL, NULL, NULL),
(9, 'Benishangul-Gumuz Region', 70, 'inactive', NULL, NULL, NULL),
(10, 'Gambela Region', 70, 'inactive', NULL, NULL, NULL),
(11, 'Addis Ababa', 70, 'inactive', NULL, NULL, NULL),
(12, 'Petnjica Municipality', 147, 'inactive', NULL, NULL, NULL),
(13, 'Bar Municipality', 147, 'inactive', NULL, NULL, NULL),
(14, 'Danilovgrad Municipality', 147, 'inactive', NULL, NULL, NULL),
(15, 'Rožaje Municipality', 147, 'inactive', NULL, NULL, NULL),
(16, 'Plužine Municipality', 147, 'inactive', NULL, NULL, NULL),
(17, 'Nikšić Municipality', 147, 'inactive', NULL, NULL, NULL),
(18, 'Šavnik Municipality', 147, 'inactive', NULL, NULL, NULL),
(19, 'Plav Municipality', 147, 'inactive', NULL, NULL, NULL),
(20, 'Pljevlja Municipality', 147, 'inactive', NULL, NULL, NULL),
(21, 'Berane Municipality', 147, 'inactive', NULL, NULL, NULL),
(22, 'Mojkovac Municipality', 147, 'inactive', NULL, NULL, NULL),
(23, 'Andrijevica Municipality', 147, 'inactive', NULL, NULL, NULL),
(24, 'Gusinje Municipality', 147, 'inactive', NULL, NULL, NULL),
(25, 'Bijelo Polje Municipality', 147, 'inactive', NULL, NULL, NULL),
(26, 'Kotor Municipality', 147, 'inactive', NULL, NULL, NULL),
(27, 'Podgorica Municipality', 147, 'inactive', NULL, NULL, NULL),
(28, 'Old Royal Capital Cetinje', 147, 'inactive', NULL, NULL, NULL),
(29, 'Tivat Municipality', 147, 'inactive', NULL, NULL, NULL),
(30, 'Budva Municipality', 147, 'inactive', NULL, NULL, NULL),
(31, 'Kolašin Municipality', 147, 'inactive', NULL, NULL, NULL),
(32, 'Žabljak Municipality', 147, 'inactive', NULL, NULL, NULL),
(33, 'Ulcinj Municipality', 147, 'inactive', NULL, NULL, NULL),
(34, 'Kunene Region', 152, 'inactive', NULL, NULL, NULL),
(35, 'Kavango West Region', 152, 'inactive', NULL, NULL, NULL),
(36, 'Kavango East Region', 152, 'inactive', NULL, NULL, NULL),
(37, 'Oshana Region', 152, 'inactive', NULL, NULL, NULL),
(38, 'Hardap Region', 152, 'inactive', NULL, NULL, NULL),
(39, 'Omusati Region', 152, 'inactive', NULL, NULL, NULL),
(40, 'Ohangwena Region', 152, 'inactive', NULL, NULL, NULL),
(41, 'Omaheke Region', 152, 'inactive', NULL, NULL, NULL),
(42, 'Oshikoto Region', 152, 'inactive', NULL, NULL, NULL),
(43, 'Erongo Region', 152, 'inactive', NULL, NULL, NULL),
(44, 'Khomas Region', 152, 'inactive', NULL, NULL, NULL),
(45, 'Karas Region', 152, 'inactive', NULL, NULL, NULL),
(46, 'Otjozondjupa Region', 152, 'inactive', NULL, NULL, NULL),
(47, 'Zambezi Region', 152, 'inactive', NULL, NULL, NULL),
(48, 'Ashanti Region', 83, 'inactive', NULL, NULL, NULL),
(49, 'Western Region', 83, 'inactive', NULL, NULL, NULL),
(50, 'Eastern Region', 83, 'inactive', NULL, NULL, NULL),
(51, 'Northern Region', 83, 'inactive', NULL, NULL, NULL),
(52, 'Central Region', 83, 'inactive', NULL, NULL, NULL),
(53, 'Brong-Ahafo Region', 83, 'inactive', NULL, NULL, NULL),
(54, 'Greater Accra Region', 83, 'inactive', NULL, NULL, NULL),
(55, 'Upper East Region', 83, 'inactive', NULL, NULL, NULL),
(56, 'Volta Region', 83, 'inactive', NULL, NULL, NULL),
(57, 'Upper West Region', 83, 'inactive', NULL, NULL, NULL),
(58, 'San Marino', 192, 'inactive', NULL, NULL, NULL),
(59, 'Acquaviva', 192, 'inactive', NULL, NULL, NULL),
(60, 'Chiesanuova', 192, 'inactive', NULL, NULL, NULL),
(61, 'Borgo Maggiore', 192, 'inactive', NULL, NULL, NULL),
(62, 'Faetano', 192, 'inactive', NULL, NULL, NULL),
(63, 'Montegiardino', 192, 'inactive', NULL, NULL, NULL),
(64, 'Domagnano', 192, 'inactive', NULL, NULL, NULL),
(65, 'Serravalle', 192, 'inactive', NULL, NULL, NULL),
(66, 'Fiorentino', 192, 'inactive', NULL, NULL, NULL),
(67, 'Tillabéri Region', 160, 'inactive', NULL, NULL, NULL),
(68, 'Dosso Region', 160, 'inactive', NULL, NULL, NULL),
(69, 'Zinder Region', 160, 'inactive', NULL, NULL, NULL),
(70, 'Maradi Region', 160, 'inactive', NULL, NULL, NULL),
(71, 'Agadez Region', 160, 'inactive', NULL, NULL, NULL),
(72, 'Diffa Region', 160, 'inactive', NULL, NULL, NULL),
(73, 'Tahoua Region', 160, 'inactive', NULL, NULL, NULL),
(74, 'Mqabba', 135, 'inactive', NULL, NULL, NULL),
(75, 'San Ġwann', 135, 'inactive', NULL, NULL, NULL),
(76, 'Żurrieq', 135, 'inactive', NULL, NULL, NULL),
(77, 'Luqa', 135, 'inactive', NULL, NULL, NULL),
(78, 'Marsaxlokk', 135, 'inactive', NULL, NULL, NULL),
(79, 'Qala', 135, 'inactive', NULL, NULL, NULL),
(80, 'Żebbuġ Malta', 135, 'inactive', NULL, NULL, NULL),
(81, 'Xgħajra', 135, 'inactive', NULL, NULL, NULL),
(82, 'Kirkop', 135, 'inactive', NULL, NULL, NULL),
(83, 'Rabat', 135, 'inactive', NULL, NULL, NULL),
(84, 'Floriana', 135, 'inactive', NULL, NULL, NULL),
(85, 'Żebbuġ Gozo', 135, 'inactive', NULL, NULL, NULL),
(86, 'Swieqi', 135, 'inactive', NULL, NULL, NULL),
(87, 'Saint Lawrence', 135, 'inactive', NULL, NULL, NULL),
(88, 'Birżebbuġa', 135, 'inactive', NULL, NULL, NULL),
(89, 'Mdina', 135, 'inactive', NULL, NULL, NULL),
(90, 'Santa Venera', 135, 'inactive', NULL, NULL, NULL),
(91, 'Kerċem', 135, 'inactive', NULL, NULL, NULL),
(92, 'Għarb', 135, 'inactive', NULL, NULL, NULL),
(93, 'Iklin', 135, 'inactive', NULL, NULL, NULL),
(94, 'Santa Luċija', 135, 'inactive', NULL, NULL, NULL),
(95, 'Valletta', 135, 'inactive', NULL, NULL, NULL),
(96, 'Msida', 135, 'inactive', NULL, NULL, NULL),
(97, 'Birkirkara', 135, 'inactive', NULL, NULL, NULL),
(98, 'Siġġiewi', 135, 'inactive', NULL, NULL, NULL),
(99, 'Kalkara', 135, 'inactive', NULL, NULL, NULL),
(100, 'St. Julian\'s', 135, 'inactive', NULL, NULL, NULL),
(101, 'Victoria', 135, 'inactive', NULL, NULL, NULL),
(102, 'Mellieħa', 135, 'inactive', NULL, NULL, NULL),
(103, 'Tarxien', 135, 'inactive', NULL, NULL, NULL),
(104, 'Sliema', 135, 'inactive', NULL, NULL, NULL),
(105, 'Ħamrun', 135, 'inactive', NULL, NULL, NULL),
(106, 'Għasri', 135, 'inactive', NULL, NULL, NULL),
(107, 'Birgu', 135, 'inactive', NULL, NULL, NULL),
(108, 'Balzan', 135, 'inactive', NULL, NULL, NULL),
(109, 'Mġarr', 135, 'inactive', NULL, NULL, NULL),
(110, 'Attard', 135, 'inactive', NULL, NULL, NULL),
(111, 'Qrendi', 135, 'inactive', NULL, NULL, NULL),
(112, 'Naxxar', 135, 'inactive', NULL, NULL, NULL),
(113, 'Gżira', 135, 'inactive', NULL, NULL, NULL),
(114, 'Xagħra', 135, 'inactive', NULL, NULL, NULL),
(115, 'Paola', 135, 'inactive', NULL, NULL, NULL),
(116, 'Sannat', 135, 'inactive', NULL, NULL, NULL),
(117, 'Dingli', 135, 'inactive', NULL, NULL, NULL),
(118, 'Gudja', 135, 'inactive', NULL, NULL, NULL),
(119, 'Qormi', 135, 'inactive', NULL, NULL, NULL),
(120, 'Għargħur', 135, 'inactive', NULL, NULL, NULL),
(121, 'Xewkija', 135, 'inactive', NULL, NULL, NULL),
(122, 'Ta\' Xbiex', 135, 'inactive', NULL, NULL, NULL),
(123, 'Żabbar', 135, 'inactive', NULL, NULL, NULL),
(124, 'Għaxaq', 135, 'inactive', NULL, NULL, NULL),
(125, 'Pembroke', 135, 'inactive', NULL, NULL, NULL),
(126, 'Lija', 135, 'inactive', NULL, NULL, NULL),
(127, 'Pietà', 135, 'inactive', NULL, NULL, NULL),
(128, 'Marsa', 135, 'inactive', NULL, NULL, NULL),
(129, 'Fgura', 135, 'inactive', NULL, NULL, NULL),
(130, 'Għajnsielem', 135, 'inactive', NULL, NULL, NULL),
(131, 'Mtarfa', 135, 'inactive', NULL, NULL, NULL),
(132, 'Munxar', 135, 'inactive', NULL, NULL, NULL),
(133, 'Nadur', 135, 'inactive', NULL, NULL, NULL),
(134, 'Fontana', 135, 'inactive', NULL, NULL, NULL),
(135, 'Żejtun', 135, 'inactive', NULL, NULL, NULL),
(136, 'Senglea', 135, 'inactive', NULL, NULL, NULL),
(137, 'Marsaskala', 135, 'inactive', NULL, NULL, NULL),
(138, 'Cospicua', 135, 'inactive', NULL, NULL, NULL),
(139, 'St. Paul\'s Bay', 135, 'inactive', NULL, NULL, NULL),
(140, 'Mosta', 135, 'inactive', NULL, NULL, NULL),
(141, 'Mangystau Region', 112, 'inactive', NULL, NULL, NULL),
(142, 'Kyzylorda Region', 112, 'inactive', NULL, NULL, NULL),
(143, 'Almaty Region', 112, 'inactive', NULL, NULL, NULL),
(144, 'North Kazakhstan Region', 112, 'inactive', NULL, NULL, NULL),
(145, 'Akmola Region', 112, 'inactive', NULL, NULL, NULL),
(146, 'Pavlodar Region', 112, 'inactive', NULL, NULL, NULL),
(147, 'Jambyl Region', 112, 'inactive', NULL, NULL, NULL),
(148, 'West Kazakhstan Province', 112, 'inactive', NULL, NULL, NULL),
(149, 'Turkestan Region', 112, 'inactive', NULL, NULL, NULL),
(150, 'Karaganda Region', 112, 'inactive', NULL, NULL, NULL),
(151, 'Aktobe Region', 112, 'inactive', NULL, NULL, NULL),
(152, 'Almaty', 112, 'inactive', NULL, NULL, NULL),
(153, 'Atyrau Region', 112, 'inactive', NULL, NULL, NULL),
(154, 'East Kazakhstan Region', 112, 'inactive', NULL, NULL, NULL),
(155, 'Baikonur', 112, 'inactive', NULL, NULL, NULL),
(156, 'Nur-Sultan', 112, 'inactive', NULL, NULL, NULL),
(157, 'Kostanay Region', 112, 'inactive', NULL, NULL, NULL),
(158, 'Kakamega County', 113, 'inactive', NULL, NULL, NULL),
(159, 'Kisii County', 113, 'inactive', NULL, NULL, NULL),
(160, 'Central Province', 113, 'inactive', NULL, NULL, NULL),
(161, 'Busia County', 113, 'inactive', NULL, NULL, NULL),
(162, 'North Eastern Province', 113, 'inactive', NULL, NULL, NULL),
(163, 'Embu County', 113, 'inactive', NULL, NULL, NULL),
(164, 'Laikipia County', 113, 'inactive', NULL, NULL, NULL),
(165, 'Nandi District', 113, 'inactive', NULL, NULL, NULL),
(166, 'Lamu County', 113, 'inactive', NULL, NULL, NULL),
(167, 'Kirinyaga County', 113, 'inactive', NULL, NULL, NULL),
(168, 'Bungoma County', 113, 'inactive', NULL, NULL, NULL),
(169, 'Uasin Gishu District', 113, 'inactive', NULL, NULL, NULL),
(170, 'Isiolo County', 113, 'inactive', NULL, NULL, NULL),
(171, 'Kisumu County', 113, 'inactive', NULL, NULL, NULL),
(172, 'Coast Province', 113, 'inactive', NULL, NULL, NULL),
(173, 'Kwale County', 113, 'inactive', NULL, NULL, NULL),
(174, 'Kilifi County', 113, 'inactive', NULL, NULL, NULL),
(175, 'Narok County', 113, 'inactive', NULL, NULL, NULL),
(176, 'Taita–Taveta County', 113, 'inactive', NULL, NULL, NULL),
(177, 'Western Province', 113, 'inactive', NULL, NULL, NULL),
(178, 'Muranga County', 113, 'inactive', NULL, NULL, NULL),
(179, 'Rift Valley Province', 113, 'inactive', NULL, NULL, NULL),
(180, 'Nyeri County', 113, 'inactive', NULL, NULL, NULL),
(181, 'Baringo County', 113, 'inactive', NULL, NULL, NULL),
(182, 'Wajir County', 113, 'inactive', NULL, NULL, NULL),
(183, 'Trans-Nzoia District', 113, 'inactive', NULL, NULL, NULL),
(184, 'Machakos County', 113, 'inactive', NULL, NULL, NULL),
(185, 'Tharaka Nithi County', 113, 'inactive', NULL, NULL, NULL),
(186, 'Siaya County', 113, 'inactive', NULL, NULL, NULL),
(187, 'Mandera County', 113, 'inactive', NULL, NULL, NULL),
(188, 'Makueni County', 113, 'inactive', NULL, NULL, NULL),
(189, 'Eastern Province', 113, 'inactive', NULL, NULL, NULL),
(190, 'Migori County', 113, 'inactive', NULL, NULL, NULL),
(191, 'Nairobi', 113, 'inactive', NULL, NULL, NULL),
(192, 'Nyandarua County', 113, 'inactive', NULL, NULL, NULL),
(193, 'Kericho County', 113, 'inactive', NULL, NULL, NULL),
(194, 'Marsabit County', 113, 'inactive', NULL, NULL, NULL),
(195, 'Homa Bay County', 113, 'inactive', NULL, NULL, NULL),
(196, 'Garissa County', 113, 'inactive', NULL, NULL, NULL),
(197, 'Kajiado County', 113, 'inactive', NULL, NULL, NULL),
(198, 'Meru County', 113, 'inactive', NULL, NULL, NULL),
(199, 'Kiambu County', 113, 'inactive', NULL, NULL, NULL),
(200, 'Mombasa County', 113, 'inactive', NULL, NULL, NULL),
(201, 'Elgeyo-Marakwet County', 113, 'inactive', NULL, NULL, NULL),
(202, 'Vihiga District', 113, 'inactive', NULL, NULL, NULL),
(203, 'Nakuru District', 113, 'inactive', NULL, NULL, NULL),
(204, 'Nyanza Province', 113, 'inactive', NULL, NULL, NULL),
(205, 'Tana River County', 113, 'inactive', NULL, NULL, NULL),
(206, 'Turkana County', 113, 'inactive', NULL, NULL, NULL),
(207, 'Samburu County', 113, 'inactive', NULL, NULL, NULL),
(208, 'West Pokot County', 113, 'inactive', NULL, NULL, NULL),
(209, 'Nyamira District', 113, 'inactive', NULL, NULL, NULL),
(210, 'Bomet County', 113, 'inactive', NULL, NULL, NULL),
(211, 'Kitui County', 113, 'inactive', NULL, NULL, NULL),
(212, 'Bié Province', 7, 'inactive', NULL, NULL, NULL),
(213, 'Huambo Province', 7, 'inactive', NULL, NULL, NULL),
(214, 'Zaire Province', 7, 'inactive', NULL, NULL, NULL),
(215, 'Cunene Province', 7, 'inactive', NULL, NULL, NULL),
(216, 'Cuanza Sul', 7, 'inactive', NULL, NULL, NULL),
(217, 'Cuanza Norte Province', 7, 'inactive', NULL, NULL, NULL),
(218, 'Benguela Province', 7, 'inactive', NULL, NULL, NULL),
(219, 'Moxico Province', 7, 'inactive', NULL, NULL, NULL),
(220, 'Lunda Sul Province', 7, 'inactive', NULL, NULL, NULL),
(221, 'Bengo Province', 7, 'inactive', NULL, NULL, NULL),
(222, 'Luanda Province', 7, 'inactive', NULL, NULL, NULL),
(223, 'Lunda Norte Province', 7, 'inactive', NULL, NULL, NULL),
(224, 'Uíge Province', 7, 'inactive', NULL, NULL, NULL),
(225, 'Huíla Province', 7, 'inactive', NULL, NULL, NULL),
(226, 'Cuando Cubango Province', 7, 'inactive', NULL, NULL, NULL),
(227, 'Malanje Province', 7, 'inactive', NULL, NULL, NULL),
(228, 'Cabinda Province', 7, 'inactive', NULL, NULL, NULL),
(229, 'Gasa District', 26, 'inactive', NULL, NULL, NULL),
(230, 'Tsirang District', 26, 'inactive', NULL, NULL, NULL),
(231, 'Wangdue Phodrang District', 26, 'inactive', NULL, NULL, NULL),
(232, 'Haa District', 26, 'inactive', NULL, NULL, NULL),
(233, 'Zhemgang District', 26, 'inactive', NULL, NULL, NULL),
(234, 'Lhuntse District', 26, 'inactive', NULL, NULL, NULL),
(235, 'Punakha District', 26, 'inactive', NULL, NULL, NULL),
(236, 'Trashigang District', 26, 'inactive', NULL, NULL, NULL),
(237, 'Paro District', 26, 'inactive', NULL, NULL, NULL),
(238, 'Dagana District', 26, 'inactive', NULL, NULL, NULL),
(239, 'Chukha District', 26, 'inactive', NULL, NULL, NULL),
(240, 'Bumthang District', 26, 'inactive', NULL, NULL, NULL),
(241, 'Thimphu District', 26, 'inactive', NULL, NULL, NULL),
(242, 'Mongar District', 26, 'inactive', NULL, NULL, NULL),
(243, 'Samdrup Jongkhar District', 26, 'inactive', NULL, NULL, NULL),
(244, 'Pemagatshel District', 26, 'inactive', NULL, NULL, NULL),
(245, 'Trongsa District', 26, 'inactive', NULL, NULL, NULL),
(246, 'Samtse District', 26, 'inactive', NULL, NULL, NULL),
(247, 'Sarpang District', 26, 'inactive', NULL, NULL, NULL),
(248, 'Tombouctou Region', 134, 'inactive', NULL, NULL, NULL),
(249, 'Ségou Region', 134, 'inactive', NULL, NULL, NULL),
(250, 'Koulikoro Region', 134, 'inactive', NULL, NULL, NULL),
(251, 'Ménaka Region', 134, 'inactive', NULL, NULL, NULL),
(252, 'Kayes Region', 134, 'inactive', NULL, NULL, NULL),
(253, 'Bamako', 134, 'inactive', NULL, NULL, NULL),
(254, 'Sikasso Region', 134, 'inactive', NULL, NULL, NULL),
(255, 'Mopti Region', 134, 'inactive', NULL, NULL, NULL),
(256, 'Taoudénit Region', 134, 'inactive', NULL, NULL, NULL),
(257, 'Kidal Region', 134, 'inactive', NULL, NULL, NULL),
(258, 'Gao Region', 134, 'inactive', NULL, NULL, NULL),
(259, 'Southern Province', 183, 'inactive', NULL, NULL, NULL),
(260, 'Western Province', 183, 'inactive', NULL, NULL, NULL),
(261, 'Eastern Province', 183, 'inactive', NULL, NULL, NULL),
(262, 'Kigali district', 183, 'inactive', NULL, NULL, NULL),
(263, 'Northern Province', 183, 'inactive', NULL, NULL, NULL),
(264, 'Belize District', 23, 'inactive', NULL, NULL, NULL),
(265, 'Stann Creek District', 23, 'inactive', NULL, NULL, NULL),
(266, 'Corozal District', 23, 'inactive', NULL, NULL, NULL),
(267, 'Toledo District', 23, 'inactive', NULL, NULL, NULL),
(268, 'Orange Walk District', 23, 'inactive', NULL, NULL, NULL),
(269, 'Cayo District', 23, 'inactive', NULL, NULL, NULL),
(270, 'Príncipe Province', 193, 'inactive', NULL, NULL, NULL),
(271, 'São Tomé Province', 193, 'inactive', NULL, NULL, NULL),
(272, 'Havana Province', 56, 'inactive', NULL, NULL, NULL),
(273, 'Santiago de Cuba Province', 56, 'inactive', NULL, NULL, NULL),
(274, 'Sancti Spíritus Province', 56, 'inactive', NULL, NULL, NULL),
(275, 'Granma Province', 56, 'inactive', NULL, NULL, NULL),
(276, 'Mayabeque Province', 56, 'inactive', NULL, NULL, NULL),
(277, 'Pinar del Río Province', 56, 'inactive', NULL, NULL, NULL),
(278, 'Isla de la Juventud', 56, 'inactive', NULL, NULL, NULL),
(279, 'Holguín Province', 56, 'inactive', NULL, NULL, NULL),
(280, 'Villa Clara Province', 56, 'inactive', NULL, NULL, NULL),
(281, 'Las Tunas Province', 56, 'inactive', NULL, NULL, NULL),
(282, 'Ciego de Ávila Province', 56, 'inactive', NULL, NULL, NULL),
(283, 'Artemisa Province', 56, 'inactive', NULL, NULL, NULL),
(284, 'Matanzas Province', 56, 'inactive', NULL, NULL, NULL),
(285, 'Guantánamo Province', 56, 'inactive', NULL, NULL, NULL),
(286, 'Camagüey Province', 56, 'inactive', NULL, NULL, NULL),
(287, 'Cienfuegos Province', 56, 'inactive', NULL, NULL, NULL),
(288, 'Jigawa State', 161, 'inactive', NULL, NULL, NULL),
(289, 'Enugu State', 161, 'inactive', NULL, NULL, NULL),
(290, 'Kebbi State', 161, 'inactive', NULL, NULL, NULL),
(291, 'Benue State', 161, 'inactive', NULL, NULL, NULL),
(292, 'Sokoto State', 161, 'inactive', NULL, NULL, NULL),
(293, 'Federal Capital Territory', 161, 'inactive', NULL, NULL, NULL),
(294, 'Kaduna State', 161, 'inactive', NULL, NULL, NULL),
(295, 'Kwara State', 161, 'inactive', NULL, NULL, NULL),
(296, 'Oyo State', 161, 'inactive', NULL, NULL, NULL),
(297, 'Yobe State', 161, 'inactive', NULL, NULL, NULL),
(298, 'Kogi State', 161, 'inactive', NULL, NULL, NULL),
(299, 'Zamfara State', 161, 'inactive', NULL, NULL, NULL),
(300, 'Kano State', 161, 'inactive', NULL, NULL, NULL),
(301, 'Nasarawa State', 161, 'inactive', NULL, NULL, NULL),
(302, 'Plateau State', 161, 'inactive', NULL, NULL, NULL),
(303, 'Abia State', 161, 'inactive', NULL, NULL, NULL),
(304, 'Akwa Ibom State', 161, 'inactive', NULL, NULL, NULL),
(305, 'Bayelsa State', 161, 'inactive', NULL, NULL, NULL),
(306, 'Lagos', 161, 'inactive', NULL, NULL, NULL),
(307, 'Borno State', 161, 'inactive', NULL, NULL, NULL),
(308, 'Imo State', 161, 'inactive', NULL, NULL, NULL),
(309, 'Ekiti State', 161, 'inactive', NULL, NULL, NULL),
(310, 'Gombe State', 161, 'inactive', NULL, NULL, NULL),
(311, 'Ebonyi State', 161, 'inactive', NULL, NULL, NULL),
(312, 'Bauchi State', 161, 'inactive', NULL, NULL, NULL),
(313, 'Katsina State', 161, 'inactive', NULL, NULL, NULL),
(314, 'Cross River State', 161, 'inactive', NULL, NULL, NULL),
(315, 'Anambra State', 161, 'inactive', NULL, NULL, NULL),
(316, 'Delta State', 161, 'inactive', NULL, NULL, NULL),
(317, 'Niger State', 161, 'inactive', NULL, NULL, NULL),
(318, 'Edo State', 161, 'inactive', NULL, NULL, NULL),
(319, 'Taraba State', 161, 'inactive', NULL, NULL, NULL),
(320, 'Adamawa State', 161, 'inactive', NULL, NULL, NULL),
(321, 'Ondo State', 161, 'inactive', NULL, NULL, NULL),
(322, 'Osun State', 161, 'inactive', NULL, NULL, NULL),
(323, 'Ogun State', 161, 'inactive', NULL, NULL, NULL),
(324, 'Rukungiri District', 229, 'inactive', NULL, NULL, NULL),
(325, 'Kyankwanzi District', 229, 'inactive', NULL, NULL, NULL),
(326, 'Kabarole District', 229, 'inactive', NULL, NULL, NULL),
(327, 'Mpigi District', 229, 'inactive', NULL, NULL, NULL),
(328, 'Apac District', 229, 'inactive', NULL, NULL, NULL),
(329, 'Abim District', 229, 'inactive', NULL, NULL, NULL),
(330, 'Yumbe District', 229, 'inactive', NULL, NULL, NULL),
(331, 'Rukiga District', 229, 'inactive', NULL, NULL, NULL),
(332, 'Northern Region', 229, 'inactive', NULL, NULL, NULL),
(333, 'Serere District', 229, 'inactive', NULL, NULL, NULL),
(334, 'Kamuli District', 229, 'inactive', NULL, NULL, NULL),
(335, 'Amuru District', 229, 'inactive', NULL, NULL, NULL),
(336, 'Kaberamaido District', 229, 'inactive', NULL, NULL, NULL),
(337, 'Namutumba District', 229, 'inactive', NULL, NULL, NULL),
(338, 'Kibuku District', 229, 'inactive', NULL, NULL, NULL),
(339, 'Ibanda District', 229, 'inactive', NULL, NULL, NULL),
(340, 'Iganga District', 229, 'inactive', NULL, NULL, NULL),
(341, 'Dokolo District', 229, 'inactive', NULL, NULL, NULL),
(342, 'Lira District', 229, 'inactive', NULL, NULL, NULL),
(343, 'Bukedea District', 229, 'inactive', NULL, NULL, NULL),
(344, 'Alebtong District', 229, 'inactive', NULL, NULL, NULL),
(345, 'Koboko District', 229, 'inactive', NULL, NULL, NULL),
(346, 'Kiryandongo District', 229, 'inactive', NULL, NULL, NULL),
(347, 'Kiboga District', 229, 'inactive', NULL, NULL, NULL),
(348, 'Kitgum District', 229, 'inactive', NULL, NULL, NULL),
(349, 'Bududa District', 229, 'inactive', NULL, NULL, NULL),
(350, 'Mbale District', 229, 'inactive', NULL, NULL, NULL),
(351, 'Namayingo District', 229, 'inactive', NULL, NULL, NULL),
(352, 'Amuria District', 229, 'inactive', NULL, NULL, NULL),
(353, 'Amudat District', 229, 'inactive', NULL, NULL, NULL),
(354, 'Masindi District', 229, 'inactive', NULL, NULL, NULL),
(355, 'Kiruhura District', 229, 'inactive', NULL, NULL, NULL),
(356, 'Masaka District', 229, 'inactive', NULL, NULL, NULL),
(357, 'Pakwach District', 229, 'inactive', NULL, NULL, NULL),
(358, 'Rubanda District', 229, 'inactive', NULL, NULL, NULL),
(359, 'Tororo District', 229, 'inactive', NULL, NULL, NULL),
(360, 'Kamwenge District', 229, 'inactive', NULL, NULL, NULL),
(361, 'Adjumani District', 229, 'inactive', NULL, NULL, NULL),
(362, 'Wakiso District', 229, 'inactive', NULL, NULL, NULL),
(363, 'Moyo District', 229, 'inactive', NULL, NULL, NULL),
(364, 'Mityana District', 229, 'inactive', NULL, NULL, NULL),
(365, 'Butaleja District', 229, 'inactive', NULL, NULL, NULL),
(366, 'Gomba District', 229, 'inactive', NULL, NULL, NULL),
(367, 'Jinja District', 229, 'inactive', NULL, NULL, NULL),
(368, 'Kayunga District', 229, 'inactive', NULL, NULL, NULL),
(369, 'Kween District', 229, 'inactive', NULL, NULL, NULL),
(370, 'Western Region', 229, 'inactive', NULL, NULL, NULL),
(371, 'Mubende District', 229, 'inactive', NULL, NULL, NULL),
(372, 'Eastern Region', 229, 'inactive', NULL, NULL, NULL),
(373, 'Kanungu District', 229, 'inactive', NULL, NULL, NULL),
(374, 'Omoro District', 229, 'inactive', NULL, NULL, NULL),
(375, 'Bukomansimbi District', 229, 'inactive', NULL, NULL, NULL),
(376, 'Lyantonde District', 229, 'inactive', NULL, NULL, NULL),
(377, 'Buikwe District', 229, 'inactive', NULL, NULL, NULL),
(378, 'Nwoya District', 229, 'inactive', NULL, NULL, NULL),
(379, 'Zombo District', 229, 'inactive', NULL, NULL, NULL),
(380, 'Buyende District', 229, 'inactive', NULL, NULL, NULL),
(381, 'Bunyangabu District', 229, 'inactive', NULL, NULL, NULL),
(382, 'Kampala District', 229, 'inactive', NULL, NULL, NULL),
(383, 'Isingiro District', 229, 'inactive', NULL, NULL, NULL),
(384, 'Butambala District', 229, 'inactive', NULL, NULL, NULL),
(385, 'Bukwo District', 229, 'inactive', NULL, NULL, NULL),
(386, 'Bushenyi District', 229, 'inactive', NULL, NULL, NULL),
(387, 'Bugiri District', 229, 'inactive', NULL, NULL, NULL),
(388, 'Butebo District', 229, 'inactive', NULL, NULL, NULL),
(389, 'Buliisa District', 229, 'inactive', NULL, NULL, NULL),
(390, 'Otuke District', 229, 'inactive', NULL, NULL, NULL),
(391, 'Buhweju District', 229, 'inactive', NULL, NULL, NULL),
(392, 'Agago District', 229, 'inactive', NULL, NULL, NULL),
(393, 'Nakapiripirit District', 229, 'inactive', NULL, NULL, NULL),
(394, 'Kalungu District', 229, 'inactive', NULL, NULL, NULL),
(395, 'Moroto District', 229, 'inactive', NULL, NULL, NULL),
(396, 'Central Region', 229, 'inactive', NULL, NULL, NULL),
(397, 'Oyam District', 229, 'inactive', NULL, NULL, NULL),
(398, 'Kaliro District', 229, 'inactive', NULL, NULL, NULL),
(399, 'Kakumiro District', 229, 'inactive', NULL, NULL, NULL),
(400, 'Namisindwa District', 229, 'inactive', NULL, NULL, NULL),
(401, 'Kole District', 229, 'inactive', NULL, NULL, NULL),
(402, 'Kyenjojo District', 229, 'inactive', NULL, NULL, NULL),
(403, 'Kagadi District', 229, 'inactive', NULL, NULL, NULL),
(404, 'Ntungamo District', 229, 'inactive', NULL, NULL, NULL),
(405, 'Kalangala District', 229, 'inactive', NULL, NULL, NULL),
(406, 'Nakasongola District', 229, 'inactive', NULL, NULL, NULL),
(407, 'Sheema District', 229, 'inactive', NULL, NULL, NULL),
(408, 'Pader District', 229, 'inactive', NULL, NULL, NULL),
(409, 'Kisoro District', 229, 'inactive', NULL, NULL, NULL),
(410, 'Mukono District', 229, 'inactive', NULL, NULL, NULL),
(411, 'Lamwo District', 229, 'inactive', NULL, NULL, NULL),
(412, 'Pallisa District', 229, 'inactive', NULL, NULL, NULL),
(413, 'Gulu District', 229, 'inactive', NULL, NULL, NULL),
(414, 'Buvuma District', 229, 'inactive', NULL, NULL, NULL),
(415, 'Mbarara District', 229, 'inactive', NULL, NULL, NULL),
(416, 'Amolatar District', 229, 'inactive', NULL, NULL, NULL),
(417, 'Lwengo District', 229, 'inactive', NULL, NULL, NULL),
(418, 'Mayuge District', 229, 'inactive', NULL, NULL, NULL),
(419, 'Bundibugyo District', 229, 'inactive', NULL, NULL, NULL),
(420, 'Katakwi District', 229, 'inactive', NULL, NULL, NULL),
(421, 'Maracha District', 229, 'inactive', NULL, NULL, NULL),
(422, 'Ntoroko District', 229, 'inactive', NULL, NULL, NULL),
(423, 'Nakaseke District', 229, 'inactive', NULL, NULL, NULL),
(424, 'Ngora District', 229, 'inactive', NULL, NULL, NULL),
(425, 'Kumi District', 229, 'inactive', NULL, NULL, NULL),
(426, 'Kabale District', 229, 'inactive', NULL, NULL, NULL),
(427, 'Sembabule District', 229, 'inactive', NULL, NULL, NULL),
(428, 'Bulambuli District', 229, 'inactive', NULL, NULL, NULL),
(429, 'Sironko District', 229, 'inactive', NULL, NULL, NULL),
(430, 'Napak District', 229, 'inactive', NULL, NULL, NULL),
(431, 'Busia District', 229, 'inactive', NULL, NULL, NULL),
(432, 'Kapchorwa District', 229, 'inactive', NULL, NULL, NULL),
(433, 'Luwero District', 229, 'inactive', NULL, NULL, NULL),
(434, 'Kaabong District', 229, 'inactive', NULL, NULL, NULL),
(435, 'Mitooma District', 229, 'inactive', NULL, NULL, NULL),
(436, 'Kibaale District', 229, 'inactive', NULL, NULL, NULL),
(437, 'Kyegegwa District', 229, 'inactive', NULL, NULL, NULL),
(438, 'Manafwa District', 229, 'inactive', NULL, NULL, NULL),
(439, 'Rakai District', 229, 'inactive', NULL, NULL, NULL),
(440, 'Kasese District', 229, 'inactive', NULL, NULL, NULL),
(441, 'Budaka District', 229, 'inactive', NULL, NULL, NULL),
(442, 'Rubirizi District', 229, 'inactive', NULL, NULL, NULL),
(443, 'Kotido District', 229, 'inactive', NULL, NULL, NULL),
(444, 'Soroti District', 229, 'inactive', NULL, NULL, NULL),
(445, 'Luuka District', 229, 'inactive', NULL, NULL, NULL),
(446, 'Nebbi District', 229, 'inactive', NULL, NULL, NULL),
(447, 'Arua District', 229, 'inactive', NULL, NULL, NULL),
(448, 'Kyotera District', 229, 'inactive', NULL, NULL, NULL),
(449, 'Schellenberg', 125, 'inactive', NULL, NULL, NULL),
(450, 'Schaan', 125, 'inactive', NULL, NULL, NULL),
(451, 'Eschen', 125, 'inactive', NULL, NULL, NULL),
(452, 'Vaduz', 125, 'inactive', NULL, NULL, NULL),
(453, 'Ruggell', 125, 'inactive', NULL, NULL, NULL),
(454, 'Planken', 125, 'inactive', NULL, NULL, NULL),
(455, 'Mauren', 125, 'inactive', NULL, NULL, NULL),
(456, 'Triesenberg', 125, 'inactive', NULL, NULL, NULL),
(457, 'Gamprin', 125, 'inactive', NULL, NULL, NULL),
(458, 'Balzers', 125, 'inactive', NULL, NULL, NULL),
(459, 'Triesen', 125, 'inactive', NULL, NULL, NULL),
(460, 'Brčko District', 28, 'inactive', NULL, NULL, NULL),
(461, 'Tuzla Canton', 28, 'inactive', NULL, NULL, NULL),
(462, 'Central Bosnia Canton', 28, 'inactive', NULL, NULL, NULL),
(463, 'Herzegovina-Neretva Canton', 28, 'inactive', NULL, NULL, NULL),
(464, 'Posavina Canton', 28, 'inactive', NULL, NULL, NULL),
(465, 'Una-Sana Canton', 28, 'inactive', NULL, NULL, NULL),
(466, 'Sarajevo Canton', 28, 'inactive', NULL, NULL, NULL),
(467, 'Federation of Bosnia and Herzegovina', 28, 'inactive', NULL, NULL, NULL),
(468, 'Zenica-Doboj Canton', 28, 'inactive', NULL, NULL, NULL),
(469, 'West Herzegovina Canton', 28, 'inactive', NULL, NULL, NULL),
(470, 'Republika Srpska', 28, 'inactive', NULL, NULL, NULL),
(471, 'Canton 10', 28, 'inactive', NULL, NULL, NULL),
(472, 'Bosnian Podrinje Canton', 28, 'inactive', NULL, NULL, NULL),
(473, 'Dakar', 195, 'inactive', NULL, NULL, NULL),
(474, 'Kolda', 195, 'inactive', NULL, NULL, NULL),
(475, 'Kaffrine', 195, 'inactive', NULL, NULL, NULL),
(476, 'Matam', 195, 'inactive', NULL, NULL, NULL),
(477, 'Saint-Louis', 195, 'inactive', NULL, NULL, NULL),
(478, 'Ziguinchor', 195, 'inactive', NULL, NULL, NULL),
(479, 'Fatick', 195, 'inactive', NULL, NULL, NULL),
(480, 'Diourbel Region', 195, 'inactive', NULL, NULL, NULL),
(481, 'Kédougou', 195, 'inactive', NULL, NULL, NULL),
(482, 'Sédhiou', 195, 'inactive', NULL, NULL, NULL),
(483, 'Kaolack', 195, 'inactive', NULL, NULL, NULL),
(484, 'Thiès Region', 195, 'inactive', NULL, NULL, NULL),
(485, 'Louga', 195, 'inactive', NULL, NULL, NULL),
(486, 'Tambacounda Region', 195, 'inactive', NULL, NULL, NULL),
(487, 'Encamp', 6, 'inactive', NULL, NULL, NULL),
(488, 'Andorra la Vella', 6, 'inactive', NULL, NULL, NULL),
(489, 'Canillo', 6, 'inactive', NULL, NULL, NULL),
(490, 'Sant Julià de Lòria', 6, 'inactive', NULL, NULL, NULL),
(491, 'Ordino', 6, 'inactive', NULL, NULL, NULL),
(492, 'Escaldes-Engordany', 6, 'inactive', NULL, NULL, NULL),
(493, 'La Massana', 6, 'inactive', NULL, NULL, NULL),
(494, 'Mont Buxton', 197, 'inactive', NULL, NULL, NULL),
(495, 'La Digue', 197, 'inactive', NULL, NULL, NULL),
(496, 'Saint Louis', 197, 'inactive', NULL, NULL, NULL),
(497, 'Baie Lazare', 197, 'inactive', NULL, NULL, NULL),
(498, 'Mont Fleuri', 197, 'inactive', NULL, NULL, NULL),
(499, 'Les Mamelles', 197, 'inactive', NULL, NULL, NULL),
(500, 'Grand\'Anse Mahé', 197, 'inactive', NULL, NULL, NULL),
(501, 'Roche Caiman', 197, 'inactive', NULL, NULL, NULL),
(502, 'Anse Royale', 197, 'inactive', NULL, NULL, NULL),
(503, 'Glacis', 197, 'inactive', NULL, NULL, NULL),
(504, 'Grand\'Anse Praslin', 197, 'inactive', NULL, NULL, NULL),
(505, 'Bel Ombre', 197, 'inactive', NULL, NULL, NULL),
(506, 'Anse-aux-Pins', 197, 'inactive', NULL, NULL, NULL),
(507, 'Port Glaud', 197, 'inactive', NULL, NULL, NULL),
(508, 'Au Cap', 197, 'inactive', NULL, NULL, NULL),
(509, 'Takamaka', 197, 'inactive', NULL, NULL, NULL),
(510, 'Pointe La Rue', 197, 'inactive', NULL, NULL, NULL),
(511, 'Plaisance', 197, 'inactive', NULL, NULL, NULL),
(512, 'Beau Vallon', 197, 'inactive', NULL, NULL, NULL),
(513, 'Anse Boileau', 197, 'inactive', NULL, NULL, NULL),
(514, 'Baie Sainte Anne', 197, 'inactive', NULL, NULL, NULL),
(515, 'Bel Air', 197, 'inactive', NULL, NULL, NULL),
(516, 'La Rivière Anglaise', 197, 'inactive', NULL, NULL, NULL),
(517, 'Cascade', 197, 'inactive', NULL, NULL, NULL),
(518, 'Shaki', 16, 'inactive', NULL, NULL, NULL),
(519, 'Tartar District', 16, 'inactive', NULL, NULL, NULL),
(520, 'Shirvan', 16, 'inactive', NULL, NULL, NULL),
(521, 'Qazakh District', 16, 'inactive', NULL, NULL, NULL),
(522, 'Sadarak District', 16, 'inactive', NULL, NULL, NULL),
(523, 'Yevlakh District', 16, 'inactive', NULL, NULL, NULL),
(524, 'Khojali District', 16, 'inactive', NULL, NULL, NULL),
(525, 'Kalbajar District', 16, 'inactive', NULL, NULL, NULL),
(526, 'Qakh District', 16, 'inactive', NULL, NULL, NULL),
(527, 'Fizuli District', 16, 'inactive', NULL, NULL, NULL),
(528, 'Astara District', 16, 'inactive', NULL, NULL, NULL),
(529, 'Shamakhi District', 16, 'inactive', NULL, NULL, NULL),
(530, 'Neftchala District', 16, 'inactive', NULL, NULL, NULL),
(531, 'Goychay', 16, 'inactive', NULL, NULL, NULL),
(532, 'Bilasuvar District', 16, 'inactive', NULL, NULL, NULL),
(533, 'Tovuz District', 16, 'inactive', NULL, NULL, NULL),
(534, 'Ordubad District', 16, 'inactive', NULL, NULL, NULL),
(535, 'Sharur District', 16, 'inactive', NULL, NULL, NULL),
(536, 'Samukh District', 16, 'inactive', NULL, NULL, NULL),
(537, 'Khizi District', 16, 'inactive', NULL, NULL, NULL),
(538, 'Yevlakh', 16, 'inactive', NULL, NULL, NULL),
(539, 'Ujar District', 16, 'inactive', NULL, NULL, NULL),
(540, 'Absheron District', 16, 'inactive', NULL, NULL, NULL),
(541, 'Lachin District', 16, 'inactive', NULL, NULL, NULL),
(542, 'Qabala District', 16, 'inactive', NULL, NULL, NULL),
(543, 'Agstafa District', 16, 'inactive', NULL, NULL, NULL),
(544, 'Imishli District', 16, 'inactive', NULL, NULL, NULL),
(545, 'Salyan District', 16, 'inactive', NULL, NULL, NULL),
(546, 'Lerik District', 16, 'inactive', NULL, NULL, NULL),
(547, 'Agsu District', 16, 'inactive', NULL, NULL, NULL),
(548, 'Qubadli District', 16, 'inactive', NULL, NULL, NULL),
(549, 'Kurdamir District', 16, 'inactive', NULL, NULL, NULL),
(550, 'Yardymli District', 16, 'inactive', NULL, NULL, NULL),
(551, 'Goranboy District', 16, 'inactive', NULL, NULL, NULL),
(552, 'Baku', 16, 'inactive', NULL, NULL, NULL),
(553, 'Agdash District', 16, 'inactive', NULL, NULL, NULL),
(554, 'Beylagan District', 16, 'inactive', NULL, NULL, NULL),
(555, 'Masally District', 16, 'inactive', NULL, NULL, NULL),
(556, 'Oghuz District', 16, 'inactive', NULL, NULL, NULL),
(557, 'Saatly District', 16, 'inactive', NULL, NULL, NULL),
(558, 'Lankaran District', 16, 'inactive', NULL, NULL, NULL),
(559, 'Agdam District', 16, 'inactive', NULL, NULL, NULL),
(560, 'Balakan District', 16, 'inactive', NULL, NULL, NULL),
(561, 'Dashkasan District', 16, 'inactive', NULL, NULL, NULL),
(562, 'Nakhchivan Autonomous Republic', 16, 'inactive', NULL, NULL, NULL),
(563, 'Quba District', 16, 'inactive', NULL, NULL, NULL),
(564, 'Ismailli District', 16, 'inactive', NULL, NULL, NULL),
(565, 'Sabirabad District', 16, 'inactive', NULL, NULL, NULL),
(566, 'Zaqatala District', 16, 'inactive', NULL, NULL, NULL),
(567, 'Kangarli District', 16, 'inactive', NULL, NULL, NULL),
(568, 'Martuni', 16, 'inactive', NULL, NULL, NULL),
(569, 'Barda District', 16, 'inactive', NULL, NULL, NULL),
(570, 'Jabrayil District', 16, 'inactive', NULL, NULL, NULL),
(571, 'Hajigabul District', 16, 'inactive', NULL, NULL, NULL),
(572, 'Julfa District', 16, 'inactive', NULL, NULL, NULL),
(573, 'Gobustan District', 16, 'inactive', NULL, NULL, NULL),
(574, 'Goygol District', 16, 'inactive', NULL, NULL, NULL),
(575, 'Babek District', 16, 'inactive', NULL, NULL, NULL),
(576, 'Zardab District', 16, 'inactive', NULL, NULL, NULL),
(577, 'Aghjabadi District', 16, 'inactive', NULL, NULL, NULL),
(578, 'Jalilabad District', 16, 'inactive', NULL, NULL, NULL),
(579, 'Shahbuz District', 16, 'inactive', NULL, NULL, NULL),
(580, 'Mingachevir', 16, 'inactive', NULL, NULL, NULL),
(581, 'Zangilan District', 16, 'inactive', NULL, NULL, NULL),
(582, 'Sumqayit', 16, 'inactive', NULL, NULL, NULL),
(583, 'Shamkir District', 16, 'inactive', NULL, NULL, NULL),
(584, 'Siazan District', 16, 'inactive', NULL, NULL, NULL),
(585, 'Ganja', 16, 'inactive', NULL, NULL, NULL),
(586, 'Shaki District', 16, 'inactive', NULL, NULL, NULL),
(587, 'Lankaran', 16, 'inactive', NULL, NULL, NULL),
(588, 'Qusar District', 16, 'inactive', NULL, NULL, NULL),
(589, 'Gədəbəy', 16, 'inactive', NULL, NULL, NULL),
(590, 'Khachmaz District', 16, 'inactive', NULL, NULL, NULL),
(591, 'Shabran District', 16, 'inactive', NULL, NULL, NULL),
(592, 'Shusha District', 16, 'inactive', NULL, NULL, NULL),
(593, 'Skrapar District', 3, 'inactive', NULL, NULL, NULL),
(594, 'Kavajë District', 3, 'inactive', NULL, NULL, NULL),
(595, 'Lezhë District', 3, 'inactive', NULL, NULL, NULL),
(596, 'Librazhd District', 3, 'inactive', NULL, NULL, NULL),
(597, 'Korçë District', 3, 'inactive', NULL, NULL, NULL),
(598, 'Elbasan County', 3, 'inactive', NULL, NULL, NULL),
(599, 'Lushnjë District', 3, 'inactive', NULL, NULL, NULL),
(600, 'Has District', 3, 'inactive', NULL, NULL, NULL),
(601, 'Kukës County', 3, 'inactive', NULL, NULL, NULL),
(602, 'Malësi e Madhe District', 3, 'inactive', NULL, NULL, NULL),
(603, 'Berat County', 3, 'inactive', NULL, NULL, NULL),
(604, 'Gjirokastër County', 3, 'inactive', NULL, NULL, NULL),
(605, 'Dibër District', 3, 'inactive', NULL, NULL, NULL),
(606, 'Pogradec District', 3, 'inactive', NULL, NULL, NULL),
(607, 'Bulqizë District', 3, 'inactive', NULL, NULL, NULL),
(608, 'Devoll District', 3, 'inactive', NULL, NULL, NULL),
(609, 'Lezhë County', 3, 'inactive', NULL, NULL, NULL),
(610, 'Dibër County', 3, 'inactive', NULL, NULL, NULL),
(611, 'Shkodër County', 3, 'inactive', NULL, NULL, NULL),
(612, 'Kuçovë District', 3, 'inactive', NULL, NULL, NULL),
(613, 'Vlorë District', 3, 'inactive', NULL, NULL, NULL),
(614, 'Krujë District', 3, 'inactive', NULL, NULL, NULL),
(615, 'Tirana County', 3, 'inactive', NULL, NULL, NULL),
(616, 'Tepelenë District', 3, 'inactive', NULL, NULL, NULL),
(617, 'Gramsh District', 3, 'inactive', NULL, NULL, NULL),
(618, 'Delvinë District', 3, 'inactive', NULL, NULL, NULL),
(619, 'Peqin District', 3, 'inactive', NULL, NULL, NULL),
(620, 'Pukë District', 3, 'inactive', NULL, NULL, NULL),
(621, 'Gjirokastër District', 3, 'inactive', NULL, NULL, NULL),
(622, 'Kurbin District', 3, 'inactive', NULL, NULL, NULL),
(623, 'Kukës District', 3, 'inactive', NULL, NULL, NULL),
(624, 'Sarandë District', 3, 'inactive', NULL, NULL, NULL),
(625, 'Përmet District', 3, 'inactive', NULL, NULL, NULL),
(626, 'Shkodër District', 3, 'inactive', NULL, NULL, NULL),
(627, 'Fier District', 3, 'inactive', NULL, NULL, NULL),
(628, 'Kolonjë District', 3, 'inactive', NULL, NULL, NULL),
(629, 'Berat District', 3, 'inactive', NULL, NULL, NULL),
(630, 'Korçë County', 3, 'inactive', NULL, NULL, NULL),
(631, 'Fier County', 3, 'inactive', NULL, NULL, NULL),
(632, 'Durrës County', 3, 'inactive', NULL, NULL, NULL),
(633, 'Tirana District', 3, 'inactive', NULL, NULL, NULL),
(634, 'Vlorë County', 3, 'inactive', NULL, NULL, NULL),
(635, 'Mat District', 3, 'inactive', NULL, NULL, NULL),
(636, 'Tropojë District', 3, 'inactive', NULL, NULL, NULL),
(637, 'Mallakastër District', 3, 'inactive', NULL, NULL, NULL),
(638, 'Mirditë District', 3, 'inactive', NULL, NULL, NULL),
(639, 'Durrës District', 3, 'inactive', NULL, NULL, NULL),
(640, 'Sveti Nikole Municipality', 129, 'inactive', NULL, NULL, NULL),
(641, 'Kratovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(642, 'Zajas Municipality', 129, 'inactive', NULL, NULL, NULL),
(643, 'Staro Nagoričane Municipality', 129, 'inactive', NULL, NULL, NULL),
(644, 'Češinovo-Obleševo Municipality', 129, 'inactive', NULL, NULL, NULL),
(645, 'Debarca Municipality', 129, 'inactive', NULL, NULL, NULL),
(646, 'Probištip Municipality', 129, 'inactive', NULL, NULL, NULL),
(647, 'Krivogaštani Municipality', 129, 'inactive', NULL, NULL, NULL),
(648, 'Gevgelija Municipality', 129, 'inactive', NULL, NULL, NULL),
(649, 'Bogdanci Municipality', 129, 'inactive', NULL, NULL, NULL),
(650, 'Vraneštica Municipality', 129, 'inactive', NULL, NULL, NULL),
(651, 'Veles Municipality', 129, 'inactive', NULL, NULL, NULL),
(652, 'Bosilovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(653, 'Mogila Municipality', 129, 'inactive', NULL, NULL, NULL),
(654, 'Tearce Municipality', 129, 'inactive', NULL, NULL, NULL),
(655, 'Demir Kapija Municipality', 129, 'inactive', NULL, NULL, NULL),
(656, 'Aračinovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(657, 'Drugovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(658, 'Vasilevo Municipality', 129, 'inactive', NULL, NULL, NULL),
(659, 'Lipkovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(660, 'Brvenica Municipality', 129, 'inactive', NULL, NULL, NULL),
(661, 'Štip Municipality', 129, 'inactive', NULL, NULL, NULL),
(662, 'Vevčani Municipality', 129, 'inactive', NULL, NULL, NULL),
(663, 'Tetovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(664, 'Negotino Municipality', 129, 'inactive', NULL, NULL, NULL),
(665, 'Konče Municipality', 129, 'inactive', NULL, NULL, NULL),
(666, 'Prilep Municipality', 129, 'inactive', NULL, NULL, NULL),
(667, 'Saraj Municipality', 129, 'inactive', NULL, NULL, NULL),
(668, 'Želino Municipality', 129, 'inactive', NULL, NULL, NULL),
(669, 'Mavrovo and Rostuša Municipality', 129, 'inactive', NULL, NULL, NULL),
(670, 'Plasnica Municipality', 129, 'inactive', NULL, NULL, NULL),
(671, 'Valandovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(672, 'Vinica Municipality', 129, 'inactive', NULL, NULL, NULL),
(673, 'Zrnovci Municipality', 129, 'inactive', NULL, NULL, NULL),
(674, 'Karbinci', 129, 'inactive', NULL, NULL, NULL),
(675, 'Dolneni Municipality', 129, 'inactive', NULL, NULL, NULL),
(676, 'Čaška Municipality', 129, 'inactive', NULL, NULL, NULL),
(677, 'Kriva Palanka Municipality', 129, 'inactive', NULL, NULL, NULL),
(678, 'Jegunovce Municipality', 129, 'inactive', NULL, NULL, NULL),
(679, 'Bitola Municipality', 129, 'inactive', NULL, NULL, NULL),
(680, 'Šuto Orizari Municipality', 129, 'inactive', NULL, NULL, NULL),
(681, 'Karpoš Municipality', 129, 'inactive', NULL, NULL, NULL),
(682, 'Oslomej Municipality', 129, 'inactive', NULL, NULL, NULL),
(683, 'Kumanovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(684, 'Greater Skopje', 129, 'inactive', NULL, NULL, NULL),
(685, 'Pehčevo Municipality', 129, 'inactive', NULL, NULL, NULL),
(686, 'Kisela Voda Municipality', 129, 'inactive', NULL, NULL, NULL),
(687, 'Demir Hisar Municipality', 129, 'inactive', NULL, NULL, NULL),
(688, 'Kičevo Municipality', 129, 'inactive', NULL, NULL, NULL),
(689, 'Vrapčište Municipality', 129, 'inactive', NULL, NULL, NULL),
(690, 'Ilinden Municipality', 129, 'inactive', NULL, NULL, NULL),
(691, 'Rosoman Municipality', 129, 'inactive', NULL, NULL, NULL),
(692, 'Makedonski Brod Municipality', 129, 'inactive', NULL, NULL, NULL),
(693, 'Gostivar Municipality', 129, 'inactive', NULL, NULL, NULL),
(694, 'Butel Municipality', 129, 'inactive', NULL, NULL, NULL),
(695, 'Delčevo Municipality', 129, 'inactive', NULL, NULL, NULL),
(696, 'Novaci Municipality', 129, 'inactive', NULL, NULL, NULL),
(697, 'Dojran Municipality', 129, 'inactive', NULL, NULL, NULL),
(698, 'Petrovec Municipality', 129, 'inactive', NULL, NULL, NULL),
(699, 'Ohrid Municipality', 129, 'inactive', NULL, NULL, NULL),
(700, 'Struga Municipality', 129, 'inactive', NULL, NULL, NULL),
(701, 'Makedonska Kamenica Municipality', 129, 'inactive', NULL, NULL, NULL),
(702, 'Centar Municipality', 129, 'inactive', NULL, NULL, NULL),
(703, 'Aerodrom Municipality', 129, 'inactive', NULL, NULL, NULL),
(704, 'Čair Municipality', 129, 'inactive', NULL, NULL, NULL),
(705, 'Lozovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(706, 'Zelenikovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(707, 'Gazi Baba Municipality', 129, 'inactive', NULL, NULL, NULL),
(708, 'Gradsko Municipality', 129, 'inactive', NULL, NULL, NULL),
(709, 'Radoviš Municipality', 129, 'inactive', NULL, NULL, NULL),
(710, 'Strumica Municipality', 129, 'inactive', NULL, NULL, NULL),
(711, 'Studeničani Municipality', 129, 'inactive', NULL, NULL, NULL),
(712, 'Resen Municipality', 129, 'inactive', NULL, NULL, NULL),
(713, 'Kavadarci Municipality', 129, 'inactive', NULL, NULL, NULL),
(714, 'Kruševo Municipality', 129, 'inactive', NULL, NULL, NULL),
(715, 'Čučer-Sandevo Municipality', 129, 'inactive', NULL, NULL, NULL),
(716, 'Berovo Municipality', 129, 'inactive', NULL, NULL, NULL),
(717, 'Rankovce Municipality', 129, 'inactive', NULL, NULL, NULL),
(718, 'Novo Selo Municipality', 129, 'inactive', NULL, NULL, NULL),
(719, 'Sopište Municipality', 129, 'inactive', NULL, NULL, NULL),
(720, 'Centar Župa Municipality', 129, 'inactive', NULL, NULL, NULL),
(721, 'Bogovinje Municipality', 129, 'inactive', NULL, NULL, NULL),
(722, 'Gjorče Petrov Municipality', 129, 'inactive', NULL, NULL, NULL),
(723, 'Kočani Municipality', 129, 'inactive', NULL, NULL, NULL),
(724, 'Požega-Slavonia County', 55, 'inactive', NULL, NULL, NULL),
(725, 'Split-Dalmatia County', 55, 'inactive', NULL, NULL, NULL),
(726, 'Međimurje County', 55, 'inactive', NULL, NULL, NULL),
(727, 'Zadar County', 55, 'inactive', NULL, NULL, NULL),
(728, 'Dubrovnik-Neretva County', 55, 'inactive', NULL, NULL, NULL),
(729, 'Krapina-Zagorje County', 55, 'inactive', NULL, NULL, NULL),
(730, 'Šibenik-Knin County', 55, 'inactive', NULL, NULL, NULL),
(731, 'Lika-Senj County', 55, 'inactive', NULL, NULL, NULL),
(732, 'Virovitica-Podravina County', 55, 'inactive', NULL, NULL, NULL),
(733, 'Sisak-Moslavina County', 55, 'inactive', NULL, NULL, NULL),
(734, 'Bjelovar-Bilogora County', 55, 'inactive', NULL, NULL, NULL),
(735, 'Primorje-Gorski Kotar County', 55, 'inactive', NULL, NULL, NULL),
(736, 'Zagreb County', 55, 'inactive', NULL, NULL, NULL),
(737, 'Brod-Posavina County', 55, 'inactive', NULL, NULL, NULL),
(738, 'Zagreb', 55, 'inactive', NULL, NULL, NULL),
(739, 'Varaždin County', 55, 'inactive', NULL, NULL, NULL),
(740, 'Osijek-Baranja County', 55, 'inactive', NULL, NULL, NULL),
(741, 'Vukovar-Syrmia County', 55, 'inactive', NULL, NULL, NULL),
(742, 'Koprivnica-Križevci County', 55, 'inactive', NULL, NULL, NULL),
(743, 'Istria County', 55, 'inactive', NULL, NULL, NULL),
(744, 'Kyrenia District', 57, 'inactive', NULL, NULL, NULL),
(745, 'Nicosia District', 57, 'inactive', NULL, NULL, NULL),
(746, 'Paphos District', 57, 'inactive', NULL, NULL, NULL),
(747, 'Larnaca District', 57, 'inactive', NULL, NULL, NULL),
(748, 'Limassol District', 57, 'inactive', NULL, NULL, NULL),
(749, 'Famagusta District', 57, 'inactive', NULL, NULL, NULL),
(750, 'Rangpur Division', 19, 'inactive', NULL, NULL, NULL),
(751, 'Cox\'s Bazar District', 19, 'inactive', NULL, NULL, NULL),
(752, 'Bandarban District', 19, 'inactive', NULL, NULL, NULL),
(753, 'Rajshahi Division', 19, 'inactive', NULL, NULL, NULL),
(754, 'Pabna District', 19, 'inactive', NULL, NULL, NULL),
(755, 'Sherpur District', 19, 'inactive', NULL, NULL, NULL),
(756, 'Bhola District', 19, 'inactive', NULL, NULL, NULL),
(757, 'Jessore District', 19, 'inactive', NULL, NULL, NULL),
(758, 'Mymensingh Division', 19, 'inactive', NULL, NULL, NULL),
(759, 'Rangpur District', 19, 'inactive', NULL, NULL, NULL),
(760, 'Dhaka Division', 19, 'inactive', NULL, NULL, NULL),
(761, 'Chapai Nawabganj District', 19, 'inactive', NULL, NULL, NULL),
(762, 'Faridpur District', 19, 'inactive', NULL, NULL, NULL),
(763, 'Comilla District', 19, 'inactive', NULL, NULL, NULL),
(764, 'Netrokona District', 19, 'inactive', NULL, NULL, NULL),
(765, 'Sylhet Division', 19, 'inactive', NULL, NULL, NULL),
(766, 'Mymensingh District', 19, 'inactive', NULL, NULL, NULL),
(767, 'Sylhet District', 19, 'inactive', NULL, NULL, NULL),
(768, 'Chandpur District', 19, 'inactive', NULL, NULL, NULL),
(769, 'Narail District', 19, 'inactive', NULL, NULL, NULL),
(770, 'Narayanganj District', 19, 'inactive', NULL, NULL, NULL),
(771, 'Dhaka District', 19, 'inactive', NULL, NULL, NULL),
(772, 'Nilphamari District', 19, 'inactive', NULL, NULL, NULL),
(773, 'Rajbari District', 19, 'inactive', NULL, NULL, NULL),
(774, 'Kushtia District', 19, 'inactive', NULL, NULL, NULL),
(775, 'Khulna Division', 19, 'inactive', NULL, NULL, NULL),
(776, 'Meherpur District', 19, 'inactive', NULL, NULL, NULL),
(777, 'Patuakhali District', 19, 'inactive', NULL, NULL, NULL),
(778, 'Jhalokati District', 19, 'inactive', NULL, NULL, NULL),
(779, 'Kishoreganj District', 19, 'inactive', NULL, NULL, NULL),
(780, 'Lalmonirhat District', 19, 'inactive', NULL, NULL, NULL),
(781, 'Sirajganj District', 19, 'inactive', NULL, NULL, NULL),
(782, 'Tangail District', 19, 'inactive', NULL, NULL, NULL),
(783, 'Dinajpur District', 19, 'inactive', NULL, NULL, NULL),
(784, 'Barguna District', 19, 'inactive', NULL, NULL, NULL),
(785, 'Chittagong District', 19, 'inactive', NULL, NULL, NULL),
(786, 'Khagrachari District', 19, 'inactive', NULL, NULL, NULL),
(787, 'Natore District', 19, 'inactive', NULL, NULL, NULL),
(788, 'Chuadanga District', 19, 'inactive', NULL, NULL, NULL),
(789, 'Jhenaidah District', 19, 'inactive', NULL, NULL, NULL),
(790, 'Munshiganj District', 19, 'inactive', NULL, NULL, NULL),
(791, 'Pirojpur District', 19, 'inactive', NULL, NULL, NULL),
(792, 'Gopalganj District', 19, 'inactive', NULL, NULL, NULL),
(793, 'Kurigram District', 19, 'inactive', NULL, NULL, NULL),
(794, 'Moulvibazar District', 19, 'inactive', NULL, NULL, NULL),
(795, 'Gaibandha District', 19, 'inactive', NULL, NULL, NULL),
(796, 'Bagerhat District', 19, 'inactive', NULL, NULL, NULL),
(797, 'Bogra District', 19, 'inactive', NULL, NULL, NULL),
(798, 'Gazipur District', 19, 'inactive', NULL, NULL, NULL),
(799, 'Satkhira District', 19, 'inactive', NULL, NULL, NULL),
(800, 'Panchagarh District', 19, 'inactive', NULL, NULL, NULL),
(801, 'Shariatpur District', 19, 'inactive', NULL, NULL, NULL),
(802, 'Bahadia', 19, 'inactive', NULL, NULL, NULL),
(803, 'Chittagong Division', 19, 'inactive', NULL, NULL, NULL),
(804, 'Thakurgaon District', 19, 'inactive', NULL, NULL, NULL),
(805, 'Habiganj District', 19, 'inactive', NULL, NULL, NULL),
(806, 'Joypurhat District', 19, 'inactive', NULL, NULL, NULL),
(807, 'Barisal Division', 19, 'inactive', NULL, NULL, NULL),
(808, 'Jamalpur District', 19, 'inactive', NULL, NULL, NULL),
(809, 'Rangamati Hill District', 19, 'inactive', NULL, NULL, NULL),
(810, 'Brahmanbaria District', 19, 'inactive', NULL, NULL, NULL),
(811, 'Khulna District', 19, 'inactive', NULL, NULL, NULL),
(812, 'Sunamganj District', 19, 'inactive', NULL, NULL, NULL),
(813, 'Rajshahi District', 19, 'inactive', NULL, NULL, NULL),
(814, 'Naogaon District', 19, 'inactive', NULL, NULL, NULL),
(815, 'Noakhali District', 19, 'inactive', NULL, NULL, NULL),
(816, 'Feni District', 19, 'inactive', NULL, NULL, NULL),
(817, 'Madaripur District', 19, 'inactive', NULL, NULL, NULL),
(818, 'Barisal District', 19, 'inactive', NULL, NULL, NULL),
(819, 'Lakshmipur District', 19, 'inactive', NULL, NULL, NULL),
(820, 'Okayama Prefecture', 109, 'inactive', NULL, NULL, NULL),
(821, 'Chiba Prefecture', 109, 'inactive', NULL, NULL, NULL),
(822, 'Ōita Prefecture', 109, 'inactive', NULL, NULL, NULL),
(823, 'Tokyo', 109, 'inactive', NULL, NULL, NULL),
(824, 'Nara Prefecture', 109, 'inactive', NULL, NULL, NULL),
(825, 'Shizuoka Prefecture', 109, 'inactive', NULL, NULL, NULL),
(826, 'Shimane Prefecture', 109, 'inactive', NULL, NULL, NULL),
(827, 'Aichi Prefecture', 109, 'inactive', NULL, NULL, NULL),
(828, 'Hiroshima Prefecture', 109, 'inactive', NULL, NULL, NULL),
(829, 'Akita Prefecture', 109, 'inactive', NULL, NULL, NULL),
(830, 'Ishikawa Prefecture', 109, 'inactive', NULL, NULL, NULL),
(831, 'Hyōgo Prefecture', 109, 'inactive', NULL, NULL, NULL),
(832, 'Hokkaidō Prefecture', 109, 'inactive', NULL, NULL, NULL),
(833, 'Mie Prefecture', 109, 'inactive', NULL, NULL, NULL),
(834, 'Kyōto Prefecture', 109, 'inactive', NULL, NULL, NULL),
(835, 'Yamaguchi Prefecture', 109, 'inactive', NULL, NULL, NULL),
(836, 'Tokushima Prefecture', 109, 'inactive', NULL, NULL, NULL),
(837, 'Yamagata Prefecture', 109, 'inactive', NULL, NULL, NULL),
(838, 'Toyama Prefecture', 109, 'inactive', NULL, NULL, NULL),
(839, 'Aomori Prefecture', 109, 'inactive', NULL, NULL, NULL),
(840, 'Kagoshima Prefecture', 109, 'inactive', NULL, NULL, NULL),
(841, 'Niigata Prefecture', 109, 'inactive', NULL, NULL, NULL),
(842, 'Kanagawa Prefecture', 109, 'inactive', NULL, NULL, NULL),
(843, 'Nagano Prefecture', 109, 'inactive', NULL, NULL, NULL),
(844, 'Wakayama Prefecture', 109, 'inactive', NULL, NULL, NULL),
(845, 'Shiga Prefecture', 109, 'inactive', NULL, NULL, NULL),
(846, 'Kumamoto Prefecture', 109, 'inactive', NULL, NULL, NULL),
(847, 'Fukushima Prefecture', 109, 'inactive', NULL, NULL, NULL),
(848, 'Fukui Prefecture', 109, 'inactive', NULL, NULL, NULL),
(849, 'Nagasaki Prefecture', 109, 'inactive', NULL, NULL, NULL),
(850, 'Tottori Prefecture', 109, 'inactive', NULL, NULL, NULL),
(851, 'Ibaraki Prefecture', 109, 'inactive', NULL, NULL, NULL);
INSERT INTO `states` (`id`, `name`, `country_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(852, 'Yamanashi Prefecture', 109, 'inactive', NULL, NULL, NULL),
(853, 'Okinawa Prefecture', 109, 'inactive', NULL, NULL, NULL),
(854, 'Tochigi Prefecture', 109, 'inactive', NULL, NULL, NULL),
(855, 'Miyazaki Prefecture', 109, 'inactive', NULL, NULL, NULL),
(856, 'Iwate Prefecture', 109, 'inactive', NULL, NULL, NULL),
(857, 'Miyagi Prefecture', 109, 'inactive', NULL, NULL, NULL),
(858, 'Gifu Prefecture', 109, 'inactive', NULL, NULL, NULL),
(859, 'Ōsaka Prefecture', 109, 'inactive', NULL, NULL, NULL),
(860, 'Saitama Prefecture', 109, 'inactive', NULL, NULL, NULL),
(861, 'Fukuoka Prefecture', 109, 'inactive', NULL, NULL, NULL),
(862, 'Gunma Prefecture', 109, 'inactive', NULL, NULL, NULL),
(863, 'Saga Prefecture', 109, 'inactive', NULL, NULL, NULL),
(864, 'Kagawa Prefecture', 109, 'inactive', NULL, NULL, NULL),
(865, 'Ehime Prefecture', 109, 'inactive', NULL, NULL, NULL),
(866, 'Ontario', 39, 'inactive', NULL, NULL, NULL),
(867, 'Manitoba', 39, 'inactive', NULL, NULL, NULL),
(868, 'New Brunswick', 39, 'inactive', NULL, NULL, NULL),
(869, 'Yukon', 39, 'inactive', NULL, NULL, NULL),
(870, 'Saskatchewan', 39, 'inactive', NULL, NULL, NULL),
(871, 'Prince Edward Island', 39, 'inactive', NULL, NULL, NULL),
(872, 'Alberta', 39, 'inactive', NULL, NULL, NULL),
(873, 'Quebec', 39, 'inactive', NULL, NULL, NULL),
(874, 'Nova Scotia', 39, 'inactive', NULL, NULL, NULL),
(875, 'British Columbia', 39, 'inactive', NULL, NULL, NULL),
(876, 'Nunavut', 39, 'inactive', NULL, NULL, NULL),
(877, 'Newfoundland and Labrador', 39, 'inactive', NULL, NULL, NULL),
(878, 'Northwest Territories', 39, 'inactive', NULL, NULL, NULL),
(879, 'White Nile', 209, 'inactive', NULL, NULL, NULL),
(880, 'Red Sea', 209, 'inactive', NULL, NULL, NULL),
(881, 'Khartoum', 209, 'inactive', NULL, NULL, NULL),
(882, 'Sennar', 209, 'inactive', NULL, NULL, NULL),
(883, 'South Kordofan', 209, 'inactive', NULL, NULL, NULL),
(884, 'Kassala', 209, 'inactive', NULL, NULL, NULL),
(885, 'Al Jazirah', 209, 'inactive', NULL, NULL, NULL),
(886, 'Al Qadarif', 209, 'inactive', NULL, NULL, NULL),
(887, 'Blue Nile', 209, 'inactive', NULL, NULL, NULL),
(888, 'West Darfur', 209, 'inactive', NULL, NULL, NULL),
(889, 'West Kordofan', 209, 'inactive', NULL, NULL, NULL),
(890, 'North Darfur', 209, 'inactive', NULL, NULL, NULL),
(891, 'River Nile', 209, 'inactive', NULL, NULL, NULL),
(892, 'East Darfur', 209, 'inactive', NULL, NULL, NULL),
(893, 'North Kordofan', 209, 'inactive', NULL, NULL, NULL),
(894, 'South Darfur', 209, 'inactive', NULL, NULL, NULL),
(895, 'Northern', 209, 'inactive', NULL, NULL, NULL),
(896, 'Central Darfur', 209, 'inactive', NULL, NULL, NULL),
(897, 'Khelvachauri Municipality', 81, 'inactive', NULL, NULL, NULL),
(898, 'Senaki Municipality', 81, 'inactive', NULL, NULL, NULL),
(899, 'Tbilisi', 81, 'inactive', NULL, NULL, NULL),
(900, 'Adjara', 81, 'inactive', NULL, NULL, NULL),
(901, 'Autonomous Republic of Abkhazia', 81, 'inactive', NULL, NULL, NULL),
(902, 'Mtskheta-Mtianeti', 81, 'inactive', NULL, NULL, NULL),
(903, 'Shida Kartli', 81, 'inactive', NULL, NULL, NULL),
(904, 'Kvemo Kartli', 81, 'inactive', NULL, NULL, NULL),
(905, 'Imereti', 81, 'inactive', NULL, NULL, NULL),
(906, 'Samtskhe-Javakheti', 81, 'inactive', NULL, NULL, NULL),
(907, 'Guria', 81, 'inactive', NULL, NULL, NULL),
(908, 'Samegrelo-Zemo Svaneti', 81, 'inactive', NULL, NULL, NULL),
(909, 'Racha-Lechkhumi and Kvemo Svaneti', 81, 'inactive', NULL, NULL, NULL),
(910, 'Kakheti', 81, 'inactive', NULL, NULL, NULL),
(911, 'Northern Province', 198, 'inactive', NULL, NULL, NULL),
(912, 'Southern Province', 198, 'inactive', NULL, NULL, NULL),
(913, 'Western Area', 198, 'inactive', NULL, NULL, NULL),
(914, 'Eastern Province', 198, 'inactive', NULL, NULL, NULL),
(915, 'Hiran', 203, 'inactive', NULL, NULL, NULL),
(916, 'Mudug', 203, 'inactive', NULL, NULL, NULL),
(917, 'Bakool', 203, 'inactive', NULL, NULL, NULL),
(918, 'Galguduud', 203, 'inactive', NULL, NULL, NULL),
(919, 'Sanaag Region', 203, 'inactive', NULL, NULL, NULL),
(920, 'Nugal', 203, 'inactive', NULL, NULL, NULL),
(921, 'Lower Shebelle', 203, 'inactive', NULL, NULL, NULL),
(922, 'Middle Juba', 203, 'inactive', NULL, NULL, NULL),
(923, 'Middle Shebelle', 203, 'inactive', NULL, NULL, NULL),
(924, 'Lower Juba', 203, 'inactive', NULL, NULL, NULL),
(925, 'Awdal Region', 203, 'inactive', NULL, NULL, NULL),
(926, 'Bay', 203, 'inactive', NULL, NULL, NULL),
(927, 'Banaadir', 203, 'inactive', NULL, NULL, NULL),
(928, 'Gedo', 203, 'inactive', NULL, NULL, NULL),
(929, 'Togdheer Region', 203, 'inactive', NULL, NULL, NULL),
(930, 'Bari', 203, 'inactive', NULL, NULL, NULL),
(931, 'Northern Cape', 204, 'inactive', NULL, NULL, NULL),
(932, 'Free State', 204, 'inactive', NULL, NULL, NULL),
(933, 'Limpopo', 204, 'inactive', NULL, NULL, NULL),
(934, 'North West', 204, 'inactive', NULL, NULL, NULL),
(935, 'KwaZulu-Natal', 204, 'inactive', NULL, NULL, NULL),
(936, 'Gauteng', 204, 'inactive', NULL, NULL, NULL),
(937, 'Mpumalanga', 204, 'inactive', NULL, NULL, NULL),
(938, 'Eastern Cape', 204, 'inactive', NULL, NULL, NULL),
(939, 'Western Cape', 204, 'inactive', NULL, NULL, NULL),
(940, 'Chontales Department', 159, 'inactive', NULL, NULL, NULL),
(941, 'Managua Department', 159, 'inactive', NULL, NULL, NULL),
(942, 'Rivas Department', 159, 'inactive', NULL, NULL, NULL),
(943, 'Granada Department', 159, 'inactive', NULL, NULL, NULL),
(944, 'León Department', 159, 'inactive', NULL, NULL, NULL),
(945, 'Estelí Department', 159, 'inactive', NULL, NULL, NULL),
(946, 'Boaco Department', 159, 'inactive', NULL, NULL, NULL),
(947, 'Matagalpa Department', 159, 'inactive', NULL, NULL, NULL),
(948, 'Madriz Department', 159, 'inactive', NULL, NULL, NULL),
(949, 'Río San Juan Department', 159, 'inactive', NULL, NULL, NULL),
(950, 'Carazo Department', 159, 'inactive', NULL, NULL, NULL),
(951, 'North Caribbean Coast Autonomous Region', 159, 'inactive', NULL, NULL, NULL),
(952, 'South Caribbean Coast Autonomous Region', 159, 'inactive', NULL, NULL, NULL),
(953, 'Masaya Department', 159, 'inactive', NULL, NULL, NULL),
(954, 'Chinandega Department', 159, 'inactive', NULL, NULL, NULL),
(955, 'Jinotega Department', 159, 'inactive', NULL, NULL, NULL),
(956, 'Karak Governorate', 111, 'inactive', NULL, NULL, NULL),
(957, 'Tafilah Governorate', 111, 'inactive', NULL, NULL, NULL),
(958, 'Madaba Governorate', 111, 'inactive', NULL, NULL, NULL),
(959, 'Aqaba Governorate', 111, 'inactive', NULL, NULL, NULL),
(960, 'Irbid Governorate', 111, 'inactive', NULL, NULL, NULL),
(961, 'Balqa Governorate', 111, 'inactive', NULL, NULL, NULL),
(962, 'Mafraq Governorate', 111, 'inactive', NULL, NULL, NULL),
(963, 'Ajloun Governorate', 111, 'inactive', NULL, NULL, NULL),
(964, 'Ma\'an Governorate', 111, 'inactive', NULL, NULL, NULL),
(965, 'Amman Governorate', 111, 'inactive', NULL, NULL, NULL),
(966, 'Jerash Governorate', 111, 'inactive', NULL, NULL, NULL),
(967, 'Zarqa Governorate', 111, 'inactive', NULL, NULL, NULL),
(968, 'Manzini District', 212, 'inactive', NULL, NULL, NULL),
(969, 'Hhohho District', 212, 'inactive', NULL, NULL, NULL),
(970, 'Lubombo District', 212, 'inactive', NULL, NULL, NULL),
(971, 'Shiselweni District', 212, 'inactive', NULL, NULL, NULL),
(972, 'Al Jahra Governorate', 117, 'inactive', NULL, NULL, NULL),
(973, 'Hawalli Governorate', 117, 'inactive', NULL, NULL, NULL),
(974, 'Mubarak Al-Kabeer Governorate', 117, 'inactive', NULL, NULL, NULL),
(975, 'Al Farwaniyah Governorate', 117, 'inactive', NULL, NULL, NULL),
(976, 'Capital Governorate', 117, 'inactive', NULL, NULL, NULL),
(977, 'Al Ahmadi Governorate', 117, 'inactive', NULL, NULL, NULL),
(978, 'Luang Prabang Province', 119, 'inactive', NULL, NULL, NULL),
(979, 'Vientiane Prefecture', 119, 'inactive', NULL, NULL, NULL),
(980, 'Vientiane Province', 119, 'inactive', NULL, NULL, NULL),
(981, 'Salavan Province', 119, 'inactive', NULL, NULL, NULL),
(982, 'Attapeu Province', 119, 'inactive', NULL, NULL, NULL),
(983, 'Xaisomboun Province', 119, 'inactive', NULL, NULL, NULL),
(984, 'Sekong Province', 119, 'inactive', NULL, NULL, NULL),
(985, 'Bolikhamsai Province', 119, 'inactive', NULL, NULL, NULL),
(986, 'Khammouane Province', 119, 'inactive', NULL, NULL, NULL),
(987, 'Phongsaly Province', 119, 'inactive', NULL, NULL, NULL),
(988, 'Oudomxay Province', 119, 'inactive', NULL, NULL, NULL),
(989, 'Houaphanh Province', 119, 'inactive', NULL, NULL, NULL),
(990, 'Savannakhet Province', 119, 'inactive', NULL, NULL, NULL),
(991, 'Bokeo Province', 119, 'inactive', NULL, NULL, NULL),
(992, 'Luang Namtha Province', 119, 'inactive', NULL, NULL, NULL),
(993, 'Sainyabuli Province', 119, 'inactive', NULL, NULL, NULL),
(994, 'Xaisomboun', 119, 'inactive', NULL, NULL, NULL),
(995, 'Xiangkhouang Province', 119, 'inactive', NULL, NULL, NULL),
(996, 'Champasak Province', 119, 'inactive', NULL, NULL, NULL),
(997, 'Talas Region', 118, 'inactive', NULL, NULL, NULL),
(998, 'Batken Region', 118, 'inactive', NULL, NULL, NULL),
(999, 'Naryn Region', 118, 'inactive', NULL, NULL, NULL),
(1000, 'Jalal-Abad Region', 118, 'inactive', NULL, NULL, NULL),
(1001, 'Bishkek', 118, 'inactive', NULL, NULL, NULL),
(1002, 'Issyk-Kul Region', 118, 'inactive', NULL, NULL, NULL),
(1003, 'Osh', 118, 'inactive', NULL, NULL, NULL),
(1004, 'Chuy Region', 118, 'inactive', NULL, NULL, NULL),
(1005, 'Osh Region', 118, 'inactive', NULL, NULL, NULL),
(1006, 'Trøndelag', 165, 'inactive', NULL, NULL, NULL),
(1007, 'Oslo', 165, 'inactive', NULL, NULL, NULL),
(1008, 'Vestfold', 165, 'inactive', NULL, NULL, NULL),
(1009, 'Oppland', 165, 'inactive', NULL, NULL, NULL),
(1010, 'Sør-Trøndelag', 165, 'inactive', NULL, NULL, NULL),
(1011, 'Buskerud', 165, 'inactive', NULL, NULL, NULL),
(1012, 'Nord-Trøndelag', 165, 'inactive', NULL, NULL, NULL),
(1013, 'Svalbard', 165, 'inactive', NULL, NULL, NULL),
(1014, 'Vest-Agder', 165, 'inactive', NULL, NULL, NULL),
(1015, 'Troms', 165, 'inactive', NULL, NULL, NULL),
(1016, 'Finnmark', 165, 'inactive', NULL, NULL, NULL),
(1017, 'Akershus', 165, 'inactive', NULL, NULL, NULL),
(1018, 'Sogn og Fjordane', 165, 'inactive', NULL, NULL, NULL),
(1019, 'Hedmark', 165, 'inactive', NULL, NULL, NULL),
(1020, 'Møre og Romsdal', 165, 'inactive', NULL, NULL, NULL),
(1021, 'Rogaland', 165, 'inactive', NULL, NULL, NULL),
(1022, 'Østfold', 165, 'inactive', NULL, NULL, NULL),
(1023, 'Hordaland', 165, 'inactive', NULL, NULL, NULL),
(1024, 'Telemark', 165, 'inactive', NULL, NULL, NULL),
(1025, 'Nordland', 165, 'inactive', NULL, NULL, NULL),
(1026, 'Jan Mayen', 165, 'inactive', NULL, NULL, NULL),
(1027, 'Hódmezővásárhely', 99, 'inactive', NULL, NULL, NULL),
(1028, 'Érd', 99, 'inactive', NULL, NULL, NULL),
(1029, 'Szeged', 99, 'inactive', NULL, NULL, NULL),
(1030, 'Nagykanizsa', 99, 'inactive', NULL, NULL, NULL),
(1031, 'Csongrád County', 99, 'inactive', NULL, NULL, NULL),
(1032, 'Debrecen', 99, 'inactive', NULL, NULL, NULL),
(1033, 'Székesfehérvár', 99, 'inactive', NULL, NULL, NULL),
(1034, 'Nyíregyháza', 99, 'inactive', NULL, NULL, NULL),
(1035, 'Somogy County', 99, 'inactive', NULL, NULL, NULL),
(1036, 'Békéscsaba', 99, 'inactive', NULL, NULL, NULL),
(1037, 'Eger', 99, 'inactive', NULL, NULL, NULL),
(1038, 'Tolna County', 99, 'inactive', NULL, NULL, NULL),
(1039, 'Vas County', 99, 'inactive', NULL, NULL, NULL),
(1040, 'Heves County', 99, 'inactive', NULL, NULL, NULL),
(1041, 'Győr', 99, 'inactive', NULL, NULL, NULL),
(1042, 'Győr-Moson-Sopron County', 99, 'inactive', NULL, NULL, NULL),
(1043, 'Jász-Nagykun-Szolnok County', 99, 'inactive', NULL, NULL, NULL),
(1044, 'Fejér County', 99, 'inactive', NULL, NULL, NULL),
(1045, 'Szabolcs-Szatmár-Bereg County', 99, 'inactive', NULL, NULL, NULL),
(1046, 'Zala County', 99, 'inactive', NULL, NULL, NULL),
(1047, 'Szolnok', 99, 'inactive', NULL, NULL, NULL),
(1048, 'Bács-Kiskun County', 99, 'inactive', NULL, NULL, NULL),
(1049, 'Dunaújváros', 99, 'inactive', NULL, NULL, NULL),
(1050, 'Zalaegerszeg', 99, 'inactive', NULL, NULL, NULL),
(1051, 'Nógrád County', 99, 'inactive', NULL, NULL, NULL),
(1052, 'Szombathely', 99, 'inactive', NULL, NULL, NULL),
(1053, 'Pécs', 99, 'inactive', NULL, NULL, NULL),
(1054, 'Veszprém County', 99, 'inactive', NULL, NULL, NULL),
(1055, 'Baranya County', 99, 'inactive', NULL, NULL, NULL),
(1056, 'Kecskemét', 99, 'inactive', NULL, NULL, NULL),
(1057, 'Sopron', 99, 'inactive', NULL, NULL, NULL),
(1058, 'Borsod-Abaúj-Zemplén County', 99, 'inactive', NULL, NULL, NULL),
(1059, 'Pest County', 99, 'inactive', NULL, NULL, NULL),
(1060, 'Békés County', 99, 'inactive', NULL, NULL, NULL),
(1061, 'Szekszárd', 99, 'inactive', NULL, NULL, NULL),
(1062, 'Veszprém', 99, 'inactive', NULL, NULL, NULL),
(1063, 'Hajdú-Bihar County', 99, 'inactive', NULL, NULL, NULL),
(1064, 'Budapest', 99, 'inactive', NULL, NULL, NULL),
(1065, 'Miskolc', 99, 'inactive', NULL, NULL, NULL),
(1066, 'Tatabánya', 99, 'inactive', NULL, NULL, NULL),
(1067, 'Kaposvár', 99, 'inactive', NULL, NULL, NULL),
(1068, 'Salgótarján', 99, 'inactive', NULL, NULL, NULL),
(1069, 'County Tipperary', 105, 'inactive', NULL, NULL, NULL),
(1070, 'County Sligo', 105, 'inactive', NULL, NULL, NULL),
(1071, 'County Donegal', 105, 'inactive', NULL, NULL, NULL),
(1072, 'County Dublin', 105, 'inactive', NULL, NULL, NULL),
(1073, 'Leinster', 105, 'inactive', NULL, NULL, NULL),
(1074, 'County Cork', 105, 'inactive', NULL, NULL, NULL),
(1075, 'County Monaghan', 105, 'inactive', NULL, NULL, NULL),
(1076, 'County Longford', 105, 'inactive', NULL, NULL, NULL),
(1077, 'County Kerry', 105, 'inactive', NULL, NULL, NULL),
(1078, 'County Offaly', 105, 'inactive', NULL, NULL, NULL),
(1079, 'County Galway', 105, 'inactive', NULL, NULL, NULL),
(1080, 'Munster', 105, 'inactive', NULL, NULL, NULL),
(1081, 'County Roscommon', 105, 'inactive', NULL, NULL, NULL),
(1082, 'County Kildare', 105, 'inactive', NULL, NULL, NULL),
(1083, 'County Louth', 105, 'inactive', NULL, NULL, NULL),
(1084, 'County Mayo', 105, 'inactive', NULL, NULL, NULL),
(1085, 'County Wicklow', 105, 'inactive', NULL, NULL, NULL),
(1086, 'Ulster', 105, 'inactive', NULL, NULL, NULL),
(1087, 'Connacht', 105, 'inactive', NULL, NULL, NULL),
(1088, 'County Cavan', 105, 'inactive', NULL, NULL, NULL),
(1089, 'County Waterford', 105, 'inactive', NULL, NULL, NULL),
(1090, 'County Kilkenny', 105, 'inactive', NULL, NULL, NULL),
(1091, 'County Clare', 105, 'inactive', NULL, NULL, NULL),
(1092, 'County Meath', 105, 'inactive', NULL, NULL, NULL),
(1093, 'County Wexford', 105, 'inactive', NULL, NULL, NULL),
(1094, 'County Limerick', 105, 'inactive', NULL, NULL, NULL),
(1095, 'County Carlow', 105, 'inactive', NULL, NULL, NULL),
(1096, 'County Laois', 105, 'inactive', NULL, NULL, NULL),
(1097, 'County Westmeath', 105, 'inactive', NULL, NULL, NULL),
(1098, 'Djelfa Province', 4, 'inactive', NULL, NULL, NULL),
(1099, 'El Oued Province', 4, 'inactive', NULL, NULL, NULL),
(1100, 'El Tarf Province', 4, 'inactive', NULL, NULL, NULL),
(1101, 'Oran Province', 4, 'inactive', NULL, NULL, NULL),
(1102, 'Naama Province', 4, 'inactive', NULL, NULL, NULL),
(1103, 'Annaba Province', 4, 'inactive', NULL, NULL, NULL),
(1104, 'Bouïra Province', 4, 'inactive', NULL, NULL, NULL),
(1105, 'Chlef Province', 4, 'inactive', NULL, NULL, NULL),
(1106, 'Tiaret Province', 4, 'inactive', NULL, NULL, NULL),
(1107, 'Tlemcen Province', 4, 'inactive', NULL, NULL, NULL),
(1108, 'Béchar Province', 4, 'inactive', NULL, NULL, NULL),
(1109, 'Médéa Province', 4, 'inactive', NULL, NULL, NULL),
(1110, 'Skikda Province', 4, 'inactive', NULL, NULL, NULL),
(1111, 'Blida Province', 4, 'inactive', NULL, NULL, NULL),
(1112, 'Illizi Province', 4, 'inactive', NULL, NULL, NULL),
(1113, 'Jijel Province', 4, 'inactive', NULL, NULL, NULL),
(1114, 'Biskra', 4, 'inactive', NULL, NULL, NULL),
(1115, 'Tipasa Province', 4, 'inactive', NULL, NULL, NULL),
(1116, 'Bordj Bou Arréridj Province', 4, 'inactive', NULL, NULL, NULL),
(1117, 'Tébessa Province', 4, 'inactive', NULL, NULL, NULL),
(1118, 'Adrar Province', 4, 'inactive', NULL, NULL, NULL),
(1119, 'Aïn Defla Province', 4, 'inactive', NULL, NULL, NULL),
(1120, 'Tindouf Province', 4, 'inactive', NULL, NULL, NULL),
(1121, 'Constantine Province', 4, 'inactive', NULL, NULL, NULL),
(1122, 'Aïn Témouchent Province', 4, 'inactive', NULL, NULL, NULL),
(1123, 'Saïda Province', 4, 'inactive', NULL, NULL, NULL),
(1124, 'Mascara Province', 4, 'inactive', NULL, NULL, NULL),
(1125, 'Boumerdès Province', 4, 'inactive', NULL, NULL, NULL),
(1126, 'Khenchela Province', 4, 'inactive', NULL, NULL, NULL),
(1127, 'Ghardaïa Province', 4, 'inactive', NULL, NULL, NULL),
(1128, 'Béjaïa Province', 4, 'inactive', NULL, NULL, NULL),
(1129, 'El Bayadh Province', 4, 'inactive', NULL, NULL, NULL),
(1130, 'Relizane Province', 4, 'inactive', NULL, NULL, NULL),
(1131, 'Tizi Ouzou Province', 4, 'inactive', NULL, NULL, NULL),
(1132, 'Mila Province', 4, 'inactive', NULL, NULL, NULL),
(1133, 'Tissemsilt Province', 4, 'inactive', NULL, NULL, NULL),
(1134, 'M\'Sila Province', 4, 'inactive', NULL, NULL, NULL),
(1135, 'Tamanghasset Province', 4, 'inactive', NULL, NULL, NULL),
(1136, 'Oum El Bouaghi Province', 4, 'inactive', NULL, NULL, NULL),
(1137, 'Guelma Province', 4, 'inactive', NULL, NULL, NULL),
(1138, 'Laghouat Province', 4, 'inactive', NULL, NULL, NULL),
(1139, 'Ouargla Province', 4, 'inactive', NULL, NULL, NULL),
(1140, 'Mostaganem Province', 4, 'inactive', NULL, NULL, NULL),
(1141, 'Sétif Province', 4, 'inactive', NULL, NULL, NULL),
(1142, 'Batna Province', 4, 'inactive', NULL, NULL, NULL),
(1143, 'Souk Ahras Province', 4, 'inactive', NULL, NULL, NULL),
(1144, 'Algiers Province', 4, 'inactive', NULL, NULL, NULL),
(1145, 'Murcia Province', 207, 'inactive', NULL, NULL, NULL),
(1146, 'Burgos Province', 207, 'inactive', NULL, NULL, NULL),
(1147, 'Salamanca Province', 207, 'inactive', NULL, NULL, NULL),
(1148, 'Araba / Álava', 207, 'inactive', NULL, NULL, NULL),
(1149, 'Madrid Province', 207, 'inactive', NULL, NULL, NULL),
(1150, 'Ciudad Real Province', 207, 'inactive', NULL, NULL, NULL),
(1151, 'Almería Province', 207, 'inactive', NULL, NULL, NULL),
(1152, 'Valencia Province', 207, 'inactive', NULL, NULL, NULL),
(1153, 'Badajoz Province', 207, 'inactive', NULL, NULL, NULL),
(1154, 'Pontevedra Province', 207, 'inactive', NULL, NULL, NULL),
(1155, 'Seville Province', 207, 'inactive', NULL, NULL, NULL),
(1156, 'Alicante Province', 207, 'inactive', NULL, NULL, NULL),
(1157, 'Palencia Province', 207, 'inactive', NULL, NULL, NULL),
(1158, 'Community of Madrid', 207, 'inactive', NULL, NULL, NULL),
(1159, 'Melilla', 207, 'inactive', NULL, NULL, NULL),
(1160, 'Province of Asturias', 207, 'inactive', NULL, NULL, NULL),
(1161, 'Zamora Province', 207, 'inactive', NULL, NULL, NULL),
(1162, 'Zaragoza Province', 207, 'inactive', NULL, NULL, NULL),
(1163, 'Huesca Province', 207, 'inactive', NULL, NULL, NULL),
(1164, 'Tarragona Province', 207, 'inactive', NULL, NULL, NULL),
(1165, 'Toledo Province', 207, 'inactive', NULL, NULL, NULL),
(1166, 'Las Palmas Province', 207, 'inactive', NULL, NULL, NULL),
(1167, 'Galicia', 207, 'inactive', NULL, NULL, NULL),
(1168, 'Albacete Province', 207, 'inactive', NULL, NULL, NULL),
(1169, 'Cuenca Province', 207, 'inactive', NULL, NULL, NULL),
(1170, 'Cantabria', 207, 'inactive', NULL, NULL, NULL),
(1171, 'La Rioja', 207, 'inactive', NULL, NULL, NULL),
(1172, 'Guadalajara Province', 207, 'inactive', NULL, NULL, NULL),
(1173, 'Ourense Province', 207, 'inactive', NULL, NULL, NULL),
(1174, 'Balearic Islands', 207, 'inactive', NULL, NULL, NULL),
(1175, 'Valencian Community', 207, 'inactive', NULL, NULL, NULL),
(1176, 'Region of Murcia', 207, 'inactive', NULL, NULL, NULL),
(1177, 'Aragon', 207, 'inactive', NULL, NULL, NULL),
(1178, 'Girona Province', 207, 'inactive', NULL, NULL, NULL),
(1179, 'A Coruña Province', 207, 'inactive', NULL, NULL, NULL),
(1180, 'Barcelona Province', 207, 'inactive', NULL, NULL, NULL),
(1181, 'Jaén Province', 207, 'inactive', NULL, NULL, NULL),
(1182, 'Teruel Province', 207, 'inactive', NULL, NULL, NULL),
(1183, 'Valladolid Province', 207, 'inactive', NULL, NULL, NULL),
(1184, 'Castile and León', 207, 'inactive', NULL, NULL, NULL),
(1185, 'Canary Islands', 207, 'inactive', NULL, NULL, NULL),
(1186, 'Biscay', 207, 'inactive', NULL, NULL, NULL),
(1187, 'Lugo Province', 207, 'inactive', NULL, NULL, NULL),
(1188, 'Málaga Province', 207, 'inactive', NULL, NULL, NULL),
(1189, 'Province of Ávila', 207, 'inactive', NULL, NULL, NULL),
(1190, 'Extremadura', 207, 'inactive', NULL, NULL, NULL),
(1191, 'Basque Country', 207, 'inactive', NULL, NULL, NULL),
(1192, 'Segovia Province', 207, 'inactive', NULL, NULL, NULL),
(1193, 'Andalusia', 207, 'inactive', NULL, NULL, NULL),
(1194, 'Granada Province', 207, 'inactive', NULL, NULL, NULL),
(1195, 'Lleida Province', 207, 'inactive', NULL, NULL, NULL),
(1196, 'Cáceres Province', 207, 'inactive', NULL, NULL, NULL),
(1197, 'Córdoba Province', 207, 'inactive', NULL, NULL, NULL),
(1198, 'Santa Cruz de Tenerife Province', 207, 'inactive', NULL, NULL, NULL),
(1199, 'Huelva Province', 207, 'inactive', NULL, NULL, NULL),
(1200, 'León Province', 207, 'inactive', NULL, NULL, NULL),
(1201, 'Cádiz Province', 207, 'inactive', NULL, NULL, NULL),
(1202, 'Gipuzkoa', 207, 'inactive', NULL, NULL, NULL),
(1203, 'Catalonia', 207, 'inactive', NULL, NULL, NULL),
(1204, 'Navarre', 207, 'inactive', NULL, NULL, NULL),
(1205, 'Castile-La Mancha', 207, 'inactive', NULL, NULL, NULL),
(1206, 'Ceuta', 207, 'inactive', NULL, NULL, NULL),
(1207, 'Castellón Province', 207, 'inactive', NULL, NULL, NULL),
(1208, 'Soria Province', 207, 'inactive', NULL, NULL, NULL),
(1209, 'Guanacaste Province', 53, 'inactive', NULL, NULL, NULL),
(1210, 'Puntarenas Province', 53, 'inactive', NULL, NULL, NULL),
(1211, 'Provincia de Cartago', 53, 'inactive', NULL, NULL, NULL),
(1212, 'Heredia Province', 53, 'inactive', NULL, NULL, NULL),
(1213, 'Limón Province', 53, 'inactive', NULL, NULL, NULL),
(1214, 'San José Province', 53, 'inactive', NULL, NULL, NULL),
(1215, 'Alajuela Province', 53, 'inactive', NULL, NULL, NULL),
(1216, 'Brunei-Muara District', 33, 'inactive', NULL, NULL, NULL),
(1217, 'Belait District', 33, 'inactive', NULL, NULL, NULL),
(1218, 'Temburong District', 33, 'inactive', NULL, NULL, NULL),
(1219, 'Tutong District', 33, 'inactive', NULL, NULL, NULL),
(1220, 'Saint Philip', 20, 'inactive', NULL, NULL, NULL),
(1221, 'Saint Lucy', 20, 'inactive', NULL, NULL, NULL),
(1222, 'Saint Peter', 20, 'inactive', NULL, NULL, NULL),
(1223, 'Saint Joseph', 20, 'inactive', NULL, NULL, NULL),
(1224, 'Saint James', 20, 'inactive', NULL, NULL, NULL),
(1225, 'Saint Thomas', 20, 'inactive', NULL, NULL, NULL),
(1226, 'Saint George', 20, 'inactive', NULL, NULL, NULL),
(1227, 'Saint John', 20, 'inactive', NULL, NULL, NULL),
(1228, 'Christ Church', 20, 'inactive', NULL, NULL, NULL),
(1229, 'Saint Andrew', 20, 'inactive', NULL, NULL, NULL),
(1230, 'Saint Michael', 20, 'inactive', NULL, NULL, NULL),
(1231, 'Ta\'izz Governorate', 245, 'inactive', NULL, NULL, NULL),
(1232, 'Sana\'a', 245, 'inactive', NULL, NULL, NULL),
(1233, 'Ibb Governorate', 245, 'inactive', NULL, NULL, NULL),
(1234, 'Ma\'rib Governorate', 245, 'inactive', NULL, NULL, NULL),
(1235, 'Al Mahwit Governorate', 245, 'inactive', NULL, NULL, NULL),
(1236, 'Sana\'a Governorate', 245, 'inactive', NULL, NULL, NULL),
(1237, 'Abyan Governorate', 245, 'inactive', NULL, NULL, NULL),
(1238, 'Hadhramaut Governorate', 245, 'inactive', NULL, NULL, NULL),
(1239, 'Socotra Governorate', 245, 'inactive', NULL, NULL, NULL),
(1240, 'Al Bayda\' Governorate', 245, 'inactive', NULL, NULL, NULL),
(1241, 'Al Hudaydah Governorate', 245, 'inactive', NULL, NULL, NULL),
(1242, '\'Adan Governorate', 245, 'inactive', NULL, NULL, NULL),
(1243, 'Al Jawf Governorate', 245, 'inactive', NULL, NULL, NULL),
(1244, 'Hajjah Governorate', 245, 'inactive', NULL, NULL, NULL),
(1245, 'Lahij Governorate', 245, 'inactive', NULL, NULL, NULL),
(1246, 'Dhamar Governorate', 245, 'inactive', NULL, NULL, NULL),
(1247, 'Shabwah Governorate', 245, 'inactive', NULL, NULL, NULL),
(1248, 'Raymah Governorate', 245, 'inactive', NULL, NULL, NULL),
(1249, 'Saada Governorate', 245, 'inactive', NULL, NULL, NULL),
(1250, '\'Amran Governorate', 245, 'inactive', NULL, NULL, NULL),
(1251, 'Al Mahrah Governorate', 245, 'inactive', NULL, NULL, NULL),
(1252, 'Sangha-Mbaéré', 42, 'inactive', NULL, NULL, NULL),
(1253, 'Nana-Grébizi Economic Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1254, 'Ouham Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1255, 'Ombella-M\'Poko Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1256, 'Lobaye Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1257, 'Mambéré-Kadéï', 42, 'inactive', NULL, NULL, NULL),
(1258, 'Haut-Mbomou Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1259, 'Bamingui-Bangoran Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1260, 'Nana-Mambéré Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1261, 'Vakaga Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1262, 'Bangui', 42, 'inactive', NULL, NULL, NULL),
(1263, 'Kémo Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1264, 'Basse-Kotto Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1265, 'Ouaka Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1266, 'Mbomou Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1267, 'Ouham-Pendé Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1268, 'Haute-Kotto Prefecture', 42, 'inactive', NULL, NULL, NULL),
(1269, 'Romblon', 174, 'inactive', NULL, NULL, NULL),
(1270, 'Bukidnon', 174, 'inactive', NULL, NULL, NULL),
(1271, 'Rizal', 174, 'inactive', NULL, NULL, NULL),
(1272, 'Bohol', 174, 'inactive', NULL, NULL, NULL),
(1273, 'Quirino', 174, 'inactive', NULL, NULL, NULL),
(1274, 'Biliran', 174, 'inactive', NULL, NULL, NULL),
(1275, 'Quezon', 174, 'inactive', NULL, NULL, NULL),
(1276, 'Siquijor', 174, 'inactive', NULL, NULL, NULL),
(1277, 'Sarangani', 174, 'inactive', NULL, NULL, NULL),
(1278, 'Bulacan', 174, 'inactive', NULL, NULL, NULL),
(1279, 'Cagayan', 174, 'inactive', NULL, NULL, NULL),
(1280, 'South Cotabato', 174, 'inactive', NULL, NULL, NULL),
(1281, 'Sorsogon', 174, 'inactive', NULL, NULL, NULL),
(1282, 'Sultan Kudarat', 174, 'inactive', NULL, NULL, NULL),
(1283, 'Camarines Norte', 174, 'inactive', NULL, NULL, NULL),
(1284, 'Southern Leyte', 174, 'inactive', NULL, NULL, NULL),
(1285, 'Camiguin', 174, 'inactive', NULL, NULL, NULL),
(1286, 'Surigao del Norte', 174, 'inactive', NULL, NULL, NULL),
(1287, 'Camarines Sur', 174, 'inactive', NULL, NULL, NULL),
(1288, 'Sulu', 174, 'inactive', NULL, NULL, NULL),
(1289, 'Davao Oriental', 174, 'inactive', NULL, NULL, NULL),
(1290, 'Eastern Samar', 174, 'inactive', NULL, NULL, NULL),
(1291, 'Dinagat Islands', 174, 'inactive', NULL, NULL, NULL),
(1292, 'Capiz', 174, 'inactive', NULL, NULL, NULL),
(1293, 'Tawi-Tawi', 174, 'inactive', NULL, NULL, NULL),
(1294, 'Calabarzon', 174, 'inactive', NULL, NULL, NULL),
(1295, 'Tarlac', 174, 'inactive', NULL, NULL, NULL),
(1296, 'Surigao del Sur', 174, 'inactive', NULL, NULL, NULL),
(1297, 'Zambales', 174, 'inactive', NULL, NULL, NULL),
(1298, 'Ilocos Norte', 174, 'inactive', NULL, NULL, NULL),
(1299, 'Mimaropa', 174, 'inactive', NULL, NULL, NULL),
(1300, 'Ifugao', 174, 'inactive', NULL, NULL, NULL),
(1301, 'Catanduanes', 174, 'inactive', NULL, NULL, NULL),
(1302, 'Zamboanga del Norte', 174, 'inactive', NULL, NULL, NULL),
(1303, 'Guimaras', 174, 'inactive', NULL, NULL, NULL),
(1304, 'Bicol Region', 174, 'inactive', NULL, NULL, NULL),
(1305, 'Western Visayas', 174, 'inactive', NULL, NULL, NULL),
(1306, 'Cebu', 174, 'inactive', NULL, NULL, NULL),
(1307, 'Cavite', 174, 'inactive', NULL, NULL, NULL),
(1308, 'Central Visayas', 174, 'inactive', NULL, NULL, NULL),
(1309, 'Davao Occidental', 174, 'inactive', NULL, NULL, NULL),
(1310, 'Soccsksargen', 174, 'inactive', NULL, NULL, NULL),
(1311, 'Compostela Valley', 174, 'inactive', NULL, NULL, NULL),
(1312, 'Kalinga', 174, 'inactive', NULL, NULL, NULL),
(1313, 'Isabela', 174, 'inactive', NULL, NULL, NULL),
(1314, 'Caraga', 174, 'inactive', NULL, NULL, NULL),
(1315, 'Iloilo', 174, 'inactive', NULL, NULL, NULL),
(1316, 'Autonomous Region in Muslim Mindanao', 174, 'inactive', NULL, NULL, NULL),
(1317, 'La Union', 174, 'inactive', NULL, NULL, NULL),
(1318, 'Davao del Sur', 174, 'inactive', NULL, NULL, NULL),
(1319, 'Davao del Norte', 174, 'inactive', NULL, NULL, NULL),
(1320, 'Cotabato', 174, 'inactive', NULL, NULL, NULL),
(1321, 'Ilocos Sur', 174, 'inactive', NULL, NULL, NULL),
(1322, 'Eastern Visayas', 174, 'inactive', NULL, NULL, NULL),
(1323, 'Agusan del Norte', 174, 'inactive', NULL, NULL, NULL),
(1324, 'Abra', 174, 'inactive', NULL, NULL, NULL),
(1325, 'Zamboanga Peninsula', 174, 'inactive', NULL, NULL, NULL),
(1326, 'Agusan del Sur', 174, 'inactive', NULL, NULL, NULL),
(1327, 'Lanao del Norte', 174, 'inactive', NULL, NULL, NULL),
(1328, 'Laguna', 174, 'inactive', NULL, NULL, NULL),
(1329, 'Marinduque', 174, 'inactive', NULL, NULL, NULL),
(1330, 'Maguindanao', 174, 'inactive', NULL, NULL, NULL),
(1331, 'Aklan', 174, 'inactive', NULL, NULL, NULL),
(1332, 'Leyte', 174, 'inactive', NULL, NULL, NULL),
(1333, 'Lanao del Sur', 174, 'inactive', NULL, NULL, NULL),
(1334, 'Apayao', 174, 'inactive', NULL, NULL, NULL),
(1335, 'Cordillera Administrative Region', 174, 'inactive', NULL, NULL, NULL),
(1336, 'Antique', 174, 'inactive', NULL, NULL, NULL),
(1337, 'Albay', 174, 'inactive', NULL, NULL, NULL),
(1338, 'Masbate', 174, 'inactive', NULL, NULL, NULL),
(1339, 'Northern Mindanao', 174, 'inactive', NULL, NULL, NULL),
(1340, 'Davao Region', 174, 'inactive', NULL, NULL, NULL),
(1341, 'Aurora', 174, 'inactive', NULL, NULL, NULL),
(1342, 'Cagayan Valley', 174, 'inactive', NULL, NULL, NULL),
(1343, 'Misamis Occidental', 174, 'inactive', NULL, NULL, NULL),
(1344, 'Bataan', 174, 'inactive', NULL, NULL, NULL),
(1345, 'Central Luzon', 174, 'inactive', NULL, NULL, NULL),
(1346, 'Basilan', 174, 'inactive', NULL, NULL, NULL),
(1347, 'Metro Manila', 174, 'inactive', NULL, NULL, NULL),
(1348, 'Misamis Oriental', 174, 'inactive', NULL, NULL, NULL),
(1349, 'Northern Samar', 174, 'inactive', NULL, NULL, NULL),
(1350, 'Negros Oriental', 174, 'inactive', NULL, NULL, NULL),
(1351, 'Negros Occidental', 174, 'inactive', NULL, NULL, NULL),
(1352, 'Batanes', 174, 'inactive', NULL, NULL, NULL),
(1353, 'Mountain Province', 174, 'inactive', NULL, NULL, NULL),
(1354, 'Oriental Mindoro', 174, 'inactive', NULL, NULL, NULL),
(1355, 'Ilocos Region', 174, 'inactive', NULL, NULL, NULL),
(1356, 'Occidental Mindoro', 174, 'inactive', NULL, NULL, NULL),
(1357, 'Zamboanga del Sur', 174, 'inactive', NULL, NULL, NULL),
(1358, 'Nueva Vizcaya', 174, 'inactive', NULL, NULL, NULL),
(1359, 'Batangas', 174, 'inactive', NULL, NULL, NULL),
(1360, 'Nueva Ecija', 174, 'inactive', NULL, NULL, NULL),
(1361, 'Palawan', 174, 'inactive', NULL, NULL, NULL),
(1362, 'Zamboanga Sibugay', 174, 'inactive', NULL, NULL, NULL),
(1363, 'Benguet', 174, 'inactive', NULL, NULL, NULL),
(1364, 'Pangasinan', 174, 'inactive', NULL, NULL, NULL),
(1365, 'Pampanga', 174, 'inactive', NULL, NULL, NULL),
(1366, 'Northern District', 106, 'inactive', NULL, NULL, NULL),
(1367, 'Central District', 106, 'inactive', NULL, NULL, NULL),
(1368, 'Southern District', 106, 'inactive', NULL, NULL, NULL),
(1369, 'Haifa District', 106, 'inactive', NULL, NULL, NULL),
(1370, 'Jerusalem District', 106, 'inactive', NULL, NULL, NULL),
(1371, 'Tel Aviv District', 106, 'inactive', NULL, NULL, NULL),
(1372, 'Limburg', 22, 'inactive', NULL, NULL, NULL),
(1373, 'Flanders', 22, 'inactive', NULL, NULL, NULL),
(1374, 'Flemish Brabant', 22, 'inactive', NULL, NULL, NULL),
(1375, 'Hainaut', 22, 'inactive', NULL, NULL, NULL),
(1376, 'Brussels-Capital Region', 22, 'inactive', NULL, NULL, NULL),
(1377, 'East Flanders', 22, 'inactive', NULL, NULL, NULL),
(1378, 'Namur', 22, 'inactive', NULL, NULL, NULL),
(1379, 'Luxembourg', 22, 'inactive', NULL, NULL, NULL),
(1380, 'Wallonia', 22, 'inactive', NULL, NULL, NULL),
(1381, 'Antwerp', 22, 'inactive', NULL, NULL, NULL),
(1382, 'Walloon Brabant', 22, 'inactive', NULL, NULL, NULL),
(1383, 'West Flanders', 22, 'inactive', NULL, NULL, NULL),
(1384, 'Liège', 22, 'inactive', NULL, NULL, NULL),
(1385, 'Darién Province', 170, 'inactive', NULL, NULL, NULL),
(1386, 'Colón Province', 170, 'inactive', NULL, NULL, NULL),
(1387, 'Coclé Province', 170, 'inactive', NULL, NULL, NULL),
(1388, 'Guna Yala', 170, 'inactive', NULL, NULL, NULL),
(1389, 'Herrera Province', 170, 'inactive', NULL, NULL, NULL),
(1390, 'Los Santos Province', 170, 'inactive', NULL, NULL, NULL),
(1391, 'Ngöbe-Buglé Comarca', 170, 'inactive', NULL, NULL, NULL),
(1392, 'Veraguas Province', 170, 'inactive', NULL, NULL, NULL),
(1393, 'Bocas del Toro Province', 170, 'inactive', NULL, NULL, NULL),
(1394, 'Panamá Oeste Province', 170, 'inactive', NULL, NULL, NULL),
(1395, 'Panamá Province', 170, 'inactive', NULL, NULL, NULL),
(1396, 'Emberá-Wounaan Comarca', 170, 'inactive', NULL, NULL, NULL),
(1397, 'Chiriquí Province', 170, 'inactive', NULL, NULL, NULL),
(1398, 'Howland Island', 233, 'active', NULL, NULL, '2022-12-17 22:18:18'),
(1399, 'Delaware', 233, 'inactive', NULL, NULL, NULL),
(1400, 'Alaska', 233, 'inactive', NULL, NULL, NULL),
(1401, 'Maryland', 233, 'inactive', NULL, NULL, NULL),
(1402, 'Baker Island', 233, 'inactive', NULL, NULL, NULL),
(1403, 'Kingman Reef', 233, 'inactive', NULL, NULL, NULL),
(1404, 'New Hampshire', 233, 'inactive', NULL, NULL, NULL),
(1405, 'Wake Island', 233, 'inactive', NULL, NULL, NULL),
(1406, 'Kansas', 233, 'inactive', NULL, NULL, NULL),
(1407, 'Texas', 233, 'inactive', NULL, NULL, NULL),
(1408, 'Nebraska', 233, 'inactive', NULL, NULL, NULL),
(1409, 'Vermont', 233, 'inactive', NULL, NULL, NULL),
(1410, 'Jarvis Island', 233, 'inactive', NULL, NULL, NULL),
(1411, 'Hawaii', 233, 'inactive', NULL, NULL, NULL),
(1412, 'Guam', 233, 'inactive', NULL, NULL, NULL),
(1413, 'United States Virgin Islands', 233, 'inactive', NULL, NULL, NULL),
(1414, 'Utah', 233, 'inactive', NULL, NULL, NULL),
(1415, 'Oregon', 233, 'inactive', NULL, NULL, NULL),
(1416, 'California', 233, 'inactive', NULL, NULL, NULL),
(1417, 'New Jersey', 233, 'inactive', NULL, NULL, NULL),
(1418, 'North Dakota', 233, 'inactive', NULL, NULL, NULL),
(1419, 'Kentucky', 233, 'inactive', NULL, NULL, NULL),
(1420, 'Minnesota', 233, 'inactive', NULL, NULL, NULL),
(1421, 'Oklahoma', 233, 'inactive', NULL, NULL, NULL),
(1422, 'Pennsylvania', 233, 'inactive', NULL, NULL, NULL),
(1423, 'New Mexico', 233, 'inactive', NULL, NULL, NULL),
(1424, 'American Samoa', 233, 'inactive', NULL, NULL, NULL),
(1425, 'Illinois', 233, 'inactive', NULL, NULL, NULL),
(1426, 'Michigan', 233, 'inactive', NULL, NULL, NULL),
(1427, 'Virginia', 233, 'inactive', NULL, NULL, NULL),
(1428, 'Johnston Atoll', 233, 'inactive', NULL, NULL, NULL),
(1429, 'West Virginia', 233, 'inactive', NULL, NULL, NULL),
(1430, 'Mississippi', 233, 'inactive', NULL, NULL, NULL),
(1431, 'Northern Mariana Islands', 233, 'inactive', NULL, NULL, NULL),
(1432, 'United States Minor Outlying Islands', 233, 'inactive', NULL, NULL, NULL),
(1433, 'Massachusetts', 233, 'inactive', NULL, NULL, NULL),
(1434, 'Arizona', 233, 'inactive', NULL, NULL, NULL),
(1435, 'Connecticut', 233, 'inactive', NULL, NULL, NULL),
(1436, 'Florida', 233, 'inactive', NULL, NULL, NULL),
(1437, 'District of Columbia', 233, 'inactive', NULL, NULL, NULL),
(1438, 'Midway Atoll', 233, 'inactive', NULL, NULL, NULL),
(1439, 'Navassa Island', 233, 'inactive', NULL, NULL, NULL),
(1440, 'Indiana', 233, 'inactive', NULL, NULL, NULL),
(1441, 'Wisconsin', 233, 'inactive', NULL, NULL, NULL),
(1442, 'Wyoming', 233, 'inactive', NULL, NULL, NULL),
(1443, 'South Carolina', 233, 'inactive', NULL, NULL, NULL),
(1444, 'Arkansas', 233, 'inactive', NULL, NULL, NULL),
(1445, 'South Dakota', 233, 'inactive', NULL, NULL, NULL),
(1446, 'Montana', 233, 'inactive', NULL, NULL, NULL),
(1447, 'North Carolina', 233, 'inactive', NULL, NULL, NULL),
(1448, 'Palmyra Atoll', 233, 'inactive', NULL, NULL, NULL),
(1449, 'Puerto Rico', 233, 'inactive', NULL, NULL, NULL),
(1450, 'Colorado', 233, 'inactive', NULL, NULL, NULL),
(1451, 'Missouri', 233, 'inactive', NULL, NULL, NULL),
(1452, 'New York', 233, 'inactive', NULL, NULL, NULL),
(1453, 'Maine', 233, 'inactive', NULL, NULL, NULL),
(1454, 'Tennessee', 233, 'inactive', NULL, NULL, NULL),
(1455, 'Georgia', 233, 'inactive', NULL, NULL, NULL),
(1456, 'Alabama', 233, 'inactive', NULL, NULL, NULL),
(1457, 'Louisiana', 233, 'inactive', NULL, NULL, NULL),
(1458, 'Nevada', 233, 'inactive', NULL, NULL, NULL),
(1459, 'Iowa', 233, 'inactive', NULL, NULL, NULL),
(1460, 'Idaho', 233, 'inactive', NULL, NULL, NULL),
(1461, 'Rhode Island', 233, 'inactive', NULL, NULL, NULL),
(1462, 'Washington', 233, 'inactive', NULL, NULL, NULL),
(1463, 'Shinyanga Region', 218, 'inactive', NULL, NULL, NULL),
(1464, 'Simiyu Region', 218, 'inactive', NULL, NULL, NULL),
(1465, 'Kagera Region', 218, 'inactive', NULL, NULL, NULL),
(1466, 'Dodoma Region', 218, 'inactive', NULL, NULL, NULL),
(1467, 'Kilimanjaro Region', 218, 'inactive', NULL, NULL, NULL),
(1468, 'Mara Region', 218, 'inactive', NULL, NULL, NULL),
(1469, 'Tabora Region', 218, 'inactive', NULL, NULL, NULL),
(1470, 'Morogoro Region', 218, 'inactive', NULL, NULL, NULL),
(1471, 'Zanzibar Central/South Region', 218, 'inactive', NULL, NULL, NULL),
(1472, 'South Pemba Region', 218, 'inactive', NULL, NULL, NULL),
(1473, 'Zanzibar North Region', 218, 'inactive', NULL, NULL, NULL),
(1474, 'Singida Region', 218, 'inactive', NULL, NULL, NULL),
(1475, 'Zanzibar Urban/West Region', 218, 'inactive', NULL, NULL, NULL),
(1476, 'Mtwara Region', 218, 'inactive', NULL, NULL, NULL),
(1477, 'Rukwa Region', 218, 'inactive', NULL, NULL, NULL),
(1478, 'Kigoma Region', 218, 'inactive', NULL, NULL, NULL),
(1479, 'Mwanza Region', 218, 'inactive', NULL, NULL, NULL),
(1480, 'Njombe Region', 218, 'inactive', NULL, NULL, NULL),
(1481, 'Geita Region', 218, 'inactive', NULL, NULL, NULL),
(1482, 'Katavi Region', 218, 'inactive', NULL, NULL, NULL),
(1483, 'Lindi Region', 218, 'inactive', NULL, NULL, NULL),
(1484, 'Manyara Region', 218, 'inactive', NULL, NULL, NULL),
(1485, 'Pwani Region', 218, 'inactive', NULL, NULL, NULL),
(1486, 'Ruvuma Region', 218, 'inactive', NULL, NULL, NULL),
(1487, 'Tanga Region', 218, 'inactive', NULL, NULL, NULL),
(1488, 'North Pemba Region', 218, 'inactive', NULL, NULL, NULL),
(1489, 'Iringa Region', 218, 'inactive', NULL, NULL, NULL),
(1490, 'Dar es Salaam Region', 218, 'inactive', NULL, NULL, NULL),
(1491, 'Arusha Region', 218, 'inactive', NULL, NULL, NULL),
(1492, 'Eastern Finland Province', 74, 'inactive', NULL, NULL, NULL),
(1493, 'Tavastia Proper', 74, 'inactive', NULL, NULL, NULL),
(1494, 'Central Ostrobothnia', 74, 'inactive', NULL, NULL, NULL),
(1495, 'Southern Savonia', 74, 'inactive', NULL, NULL, NULL),
(1496, 'Kainuu', 74, 'inactive', NULL, NULL, NULL),
(1497, 'South Karelia', 74, 'inactive', NULL, NULL, NULL),
(1498, 'Southern Ostrobothnia', 74, 'inactive', NULL, NULL, NULL),
(1499, 'Oulu Province', 74, 'inactive', NULL, NULL, NULL),
(1500, 'Lapland', 74, 'inactive', NULL, NULL, NULL),
(1501, 'Satakunta', 74, 'inactive', NULL, NULL, NULL),
(1502, 'Päijänne Tavastia', 74, 'inactive', NULL, NULL, NULL),
(1503, 'Northern Savonia', 74, 'inactive', NULL, NULL, NULL),
(1504, 'North Karelia', 74, 'inactive', NULL, NULL, NULL),
(1505, 'Northern Ostrobothnia', 74, 'inactive', NULL, NULL, NULL),
(1506, 'Pirkanmaa', 74, 'inactive', NULL, NULL, NULL),
(1507, 'Finland Proper', 74, 'inactive', NULL, NULL, NULL),
(1508, 'Ostrobothnia', 74, 'inactive', NULL, NULL, NULL),
(1509, 'Åland Islands', 74, 'inactive', NULL, NULL, NULL),
(1510, 'Uusimaa', 74, 'inactive', NULL, NULL, NULL),
(1511, 'Central Finland', 74, 'inactive', NULL, NULL, NULL),
(1512, 'Kymenlaakso', 74, 'inactive', NULL, NULL, NULL),
(1513, 'Canton of Diekirch', 127, 'inactive', NULL, NULL, NULL),
(1514, 'Luxembourg District', 127, 'inactive', NULL, NULL, NULL),
(1515, 'Canton of Echternach', 127, 'inactive', NULL, NULL, NULL),
(1516, 'Canton of Redange', 127, 'inactive', NULL, NULL, NULL),
(1517, 'Canton of Esch-sur-Alzette', 127, 'inactive', NULL, NULL, NULL),
(1518, 'Canton of Capellen', 127, 'inactive', NULL, NULL, NULL),
(1519, 'Canton of Remich', 127, 'inactive', NULL, NULL, NULL),
(1520, 'Grevenmacher District', 127, 'inactive', NULL, NULL, NULL),
(1521, 'Canton of Clervaux', 127, 'inactive', NULL, NULL, NULL),
(1522, 'Canton of Mersch', 127, 'inactive', NULL, NULL, NULL),
(1523, 'Canton of Vianden', 127, 'inactive', NULL, NULL, NULL),
(1524, 'Diekirch District', 127, 'inactive', NULL, NULL, NULL),
(1525, 'Canton of Grevenmacher', 127, 'inactive', NULL, NULL, NULL),
(1526, 'Canton of Wiltz', 127, 'inactive', NULL, NULL, NULL),
(1527, 'Canton of Luxembourg', 127, 'inactive', NULL, NULL, NULL),
(1528, 'Region Zealand', 59, 'inactive', NULL, NULL, NULL),
(1529, 'Region of Southern Denmark', 59, 'inactive', NULL, NULL, NULL),
(1530, 'Capital Region of Denmark', 59, 'inactive', NULL, NULL, NULL),
(1531, 'Central Denmark Region', 59, 'inactive', NULL, NULL, NULL),
(1532, 'North Denmark Region', 59, 'inactive', NULL, NULL, NULL),
(1533, 'Gävleborg County', 213, 'inactive', NULL, NULL, NULL),
(1534, 'Dalarna County', 213, 'inactive', NULL, NULL, NULL),
(1535, 'Värmland County', 213, 'inactive', NULL, NULL, NULL),
(1536, 'Östergötland County', 213, 'inactive', NULL, NULL, NULL),
(1537, 'Blekinge', 213, 'inactive', NULL, NULL, NULL),
(1538, 'Norrbotten County', 213, 'inactive', NULL, NULL, NULL),
(1539, 'Örebro County', 213, 'inactive', NULL, NULL, NULL),
(1540, 'Södermanland County', 213, 'inactive', NULL, NULL, NULL),
(1541, 'Skåne County', 213, 'inactive', NULL, NULL, NULL),
(1542, 'Kronoberg County', 213, 'inactive', NULL, NULL, NULL),
(1543, 'Västerbotten County', 213, 'inactive', NULL, NULL, NULL),
(1544, 'Kalmar County', 213, 'inactive', NULL, NULL, NULL),
(1545, 'Uppsala County', 213, 'inactive', NULL, NULL, NULL),
(1546, 'Gotland County', 213, 'inactive', NULL, NULL, NULL),
(1547, 'Västra Götaland County', 213, 'inactive', NULL, NULL, NULL),
(1548, 'Halland County', 213, 'inactive', NULL, NULL, NULL),
(1549, 'Västmanland County', 213, 'inactive', NULL, NULL, NULL),
(1550, 'Jönköping County', 213, 'inactive', NULL, NULL, NULL),
(1551, 'Stockholm County', 213, 'inactive', NULL, NULL, NULL),
(1552, 'Västernorrland County', 213, 'inactive', NULL, NULL, NULL),
(1553, 'Plungė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1554, 'Šiauliai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1555, 'Jurbarkas District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1556, 'Kaunas County', 126, 'inactive', NULL, NULL, NULL),
(1557, 'Mažeikiai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1558, 'Panevėžys County', 126, 'inactive', NULL, NULL, NULL),
(1559, 'Elektrėnai municipality', 126, 'inactive', NULL, NULL, NULL),
(1560, 'Švenčionys District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1561, 'Akmenė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1562, 'Ignalina District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1563, 'Neringa Municipality', 126, 'inactive', NULL, NULL, NULL),
(1564, 'Visaginas Municipality', 126, 'inactive', NULL, NULL, NULL),
(1565, 'Kaunas District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1566, 'Biržai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1567, 'Jonava District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1568, 'Radviliškis District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1569, 'Telšiai County', 126, 'inactive', NULL, NULL, NULL),
(1570, 'Marijampolė County', 126, 'inactive', NULL, NULL, NULL),
(1571, 'Kretinga District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1572, 'Tauragė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1573, 'Tauragė County', 126, 'inactive', NULL, NULL, NULL),
(1574, 'Alytus County', 126, 'inactive', NULL, NULL, NULL),
(1575, 'Kazlų Rūda municipality', 126, 'inactive', NULL, NULL, NULL),
(1576, 'Šakiai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1577, 'Šalčininkai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1578, 'Prienai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1579, 'Druskininkai municipality', 126, 'inactive', NULL, NULL, NULL),
(1580, 'Kaunas City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1581, 'Joniškis District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1582, 'Molėtai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1583, 'Kaišiadorys District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1584, 'Kėdainiai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1585, 'Kupiškis District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1586, 'Šiauliai County', 126, 'inactive', NULL, NULL, NULL),
(1587, 'Raseiniai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1588, 'Palanga City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1589, 'Panevėžys City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1590, 'Rietavas municipality', 126, 'inactive', NULL, NULL, NULL),
(1591, 'Kalvarija municipality', 126, 'inactive', NULL, NULL, NULL),
(1592, 'Vilnius District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1593, 'Trakai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1594, 'Širvintos District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1595, 'Pakruojis District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1596, 'Ukmergė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1597, 'Klaipeda City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1598, 'Utena District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1599, 'Alytus District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1600, 'Klaipėda County', 126, 'inactive', NULL, NULL, NULL),
(1601, 'Vilnius County', 126, 'inactive', NULL, NULL, NULL),
(1602, 'Varėna District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1603, 'Birštonas Municipality', 126, 'inactive', NULL, NULL, NULL),
(1604, 'Klaipėda District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1605, 'Alytus City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1606, 'Vilnius City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1607, 'Šilutė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1608, 'Telšiai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1609, 'Šiauliai City Municipality', 126, 'inactive', NULL, NULL, NULL),
(1610, 'Marijampolė Municipality', 126, 'inactive', NULL, NULL, NULL),
(1611, 'Lazdijai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1612, 'Pagėgiai municipality', 126, 'inactive', NULL, NULL, NULL),
(1613, 'Šilalė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1614, 'Panevėžys District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1615, 'Rokiškis District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1616, 'Pasvalys District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1617, 'Skuodas District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1618, 'Kelmė District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1619, 'Zarasai District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1620, 'Vilkaviškis District Municipality', 126, 'inactive', NULL, NULL, NULL),
(1621, 'Utena County', 126, 'inactive', NULL, NULL, NULL),
(1622, 'Opole Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1623, 'Silesian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1624, 'Pomeranian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1625, 'Kuyavian-Pomeranian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1626, 'Podkarpackie Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1627, 'Kielce', 176, 'inactive', NULL, NULL, NULL),
(1628, 'Warmian-Masurian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1629, 'Lower Silesian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1630, 'Świętokrzyskie Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1631, 'Lubusz Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1632, 'Podlaskie Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1633, 'West Pomeranian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1634, 'Greater Poland Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1635, 'Lesser Poland Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1636, 'Łódź Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1637, 'Masovian Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1638, 'Lublin Voivodeship', 176, 'inactive', NULL, NULL, NULL),
(1639, 'Aargau', 214, 'inactive', NULL, NULL, NULL),
(1640, 'Canton of Fribourg', 214, 'inactive', NULL, NULL, NULL),
(1641, 'Basel-Landschaft', 214, 'inactive', NULL, NULL, NULL),
(1642, 'Uri', 214, 'inactive', NULL, NULL, NULL),
(1643, 'Ticino', 214, 'inactive', NULL, NULL, NULL),
(1644, 'Canton of St. Gallen', 214, 'inactive', NULL, NULL, NULL),
(1645, 'canton of Bern', 214, 'inactive', NULL, NULL, NULL),
(1646, 'Canton of Zug', 214, 'inactive', NULL, NULL, NULL),
(1647, 'Canton of Geneva', 214, 'inactive', NULL, NULL, NULL),
(1648, 'Canton of Valais', 214, 'inactive', NULL, NULL, NULL),
(1649, 'Appenzell Innerrhoden', 214, 'inactive', NULL, NULL, NULL),
(1650, 'Obwalden', 214, 'inactive', NULL, NULL, NULL),
(1651, 'Canton of Vaud', 214, 'inactive', NULL, NULL, NULL),
(1652, 'Nidwalden', 214, 'inactive', NULL, NULL, NULL),
(1653, 'Schwyz', 214, 'inactive', NULL, NULL, NULL),
(1654, 'Canton of Schaffhausen', 214, 'inactive', NULL, NULL, NULL),
(1655, 'Appenzell Ausserrhoden', 214, 'inactive', NULL, NULL, NULL),
(1656, 'canton of Zürich', 214, 'inactive', NULL, NULL, NULL),
(1657, 'Thurgau', 214, 'inactive', NULL, NULL, NULL),
(1658, 'Canton of Jura', 214, 'inactive', NULL, NULL, NULL),
(1659, 'Canton of Neuchâtel', 214, 'inactive', NULL, NULL, NULL),
(1660, 'Graubünden', 214, 'inactive', NULL, NULL, NULL),
(1661, 'Glarus', 214, 'inactive', NULL, NULL, NULL),
(1662, 'Canton of Solothurn', 214, 'inactive', NULL, NULL, NULL),
(1663, 'Canton of Lucerne', 214, 'inactive', NULL, NULL, NULL),
(1664, 'Tuscany', 107, 'inactive', NULL, NULL, NULL),
(1665, 'Province of Padua', 107, 'inactive', NULL, NULL, NULL),
(1666, 'Province of Parma', 107, 'inactive', NULL, NULL, NULL),
(1667, 'Libero consorzio comunale di Siracusa', 107, 'inactive', NULL, NULL, NULL),
(1668, 'Metropolitan City of Palermo', 107, 'inactive', NULL, NULL, NULL),
(1669, 'Campania', 107, 'inactive', NULL, NULL, NULL),
(1670, 'Marche', 107, 'inactive', NULL, NULL, NULL),
(1671, 'Metropolitan City of Reggio Calabria', 107, 'inactive', NULL, NULL, NULL),
(1672, 'Province of Ancona', 107, 'inactive', NULL, NULL, NULL),
(1673, 'Metropolitan City of Venice', 107, 'inactive', NULL, NULL, NULL),
(1674, 'Province of Latina', 107, 'inactive', NULL, NULL, NULL),
(1675, 'Province of Lecce', 107, 'inactive', NULL, NULL, NULL),
(1676, 'Province of Pavia', 107, 'inactive', NULL, NULL, NULL),
(1677, 'Province of Lecco', 107, 'inactive', NULL, NULL, NULL),
(1678, 'Lazio', 107, 'inactive', NULL, NULL, NULL),
(1679, 'Abruzzo', 107, 'inactive', NULL, NULL, NULL),
(1680, 'Metropolitan City of Florence', 107, 'inactive', NULL, NULL, NULL),
(1681, 'Province of Ascoli Piceno', 107, 'inactive', NULL, NULL, NULL),
(1682, 'Metropolitan City of Cagliari', 107, 'inactive', NULL, NULL, NULL),
(1683, 'Umbria', 107, 'inactive', NULL, NULL, NULL),
(1684, 'Metropolitan City of Bologna', 107, 'inactive', NULL, NULL, NULL),
(1685, 'Province of Pisa', 107, 'inactive', NULL, NULL, NULL),
(1686, 'Province of Barletta-Andria-Trani', 107, 'inactive', NULL, NULL, NULL);
INSERT INTO `states` (`id`, `name`, `country_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1687, 'Province of Pistoia', 107, 'inactive', NULL, NULL, NULL),
(1688, 'Apulia', 107, 'inactive', NULL, NULL, NULL),
(1689, 'Province of Belluno', 107, 'inactive', NULL, NULL, NULL),
(1690, 'Province of Pordenone', 107, 'inactive', NULL, NULL, NULL),
(1691, 'Province of Perugia', 107, 'inactive', NULL, NULL, NULL),
(1692, 'Province of Avellino', 107, 'inactive', NULL, NULL, NULL),
(1693, 'Pesaro and Urbino Province', 107, 'inactive', NULL, NULL, NULL),
(1694, 'Province of Pescara', 107, 'inactive', NULL, NULL, NULL),
(1695, 'Molise', 107, 'inactive', NULL, NULL, NULL),
(1696, 'Province of Piacenza', 107, 'inactive', NULL, NULL, NULL),
(1697, 'Province of Potenza', 107, 'inactive', NULL, NULL, NULL),
(1698, 'Metropolitan City of Milan', 107, 'inactive', NULL, NULL, NULL),
(1699, 'Metropolitan City of Genoa', 107, 'inactive', NULL, NULL, NULL),
(1700, 'Province of Prato', 107, 'inactive', NULL, NULL, NULL),
(1701, 'Benevento Province', 107, 'inactive', NULL, NULL, NULL),
(1702, 'Piedmont', 107, 'inactive', NULL, NULL, NULL),
(1703, 'Calabria', 107, 'inactive', NULL, NULL, NULL),
(1704, 'Province of Bergamo', 107, 'inactive', NULL, NULL, NULL),
(1705, 'Lombardy', 107, 'inactive', NULL, NULL, NULL),
(1706, 'Basilicata', 107, 'inactive', NULL, NULL, NULL),
(1707, 'Province of Ravenna', 107, 'inactive', NULL, NULL, NULL),
(1708, 'Province of Reggio Emilia', 107, 'inactive', NULL, NULL, NULL),
(1709, 'Sicily', 107, 'inactive', NULL, NULL, NULL),
(1710, 'Metropolitan City of Turin', 107, 'inactive', NULL, NULL, NULL),
(1711, 'Metropolitan City of Rome', 107, 'inactive', NULL, NULL, NULL),
(1712, 'Province of Rieti', 107, 'inactive', NULL, NULL, NULL),
(1713, 'Province of Rimini', 107, 'inactive', NULL, NULL, NULL),
(1714, 'Province of Brindisi', 107, 'inactive', NULL, NULL, NULL),
(1715, 'Sardinia', 107, 'inactive', NULL, NULL, NULL),
(1716, 'Aosta Valley', 107, 'inactive', NULL, NULL, NULL),
(1717, 'Province of Brescia', 107, 'inactive', NULL, NULL, NULL),
(1718, 'Libero consorzio comunale di Caltanissetta', 107, 'inactive', NULL, NULL, NULL),
(1719, 'Province of Rovigo', 107, 'inactive', NULL, NULL, NULL),
(1720, 'Province of Salerno', 107, 'inactive', NULL, NULL, NULL),
(1721, 'Province of Campobasso', 107, 'inactive', NULL, NULL, NULL),
(1722, 'Province of Sassari', 107, 'inactive', NULL, NULL, NULL),
(1723, 'Libero consorzio comunale di Enna', 107, 'inactive', NULL, NULL, NULL),
(1724, 'Metropolitan City of Naples', 107, 'inactive', NULL, NULL, NULL),
(1725, 'Trentino-South Tyrol', 107, 'inactive', NULL, NULL, NULL),
(1726, 'Province of Verbano-Cusio-Ossola', 107, 'inactive', NULL, NULL, NULL),
(1727, 'Libero consorzio comunale di Agrigento', 107, 'inactive', NULL, NULL, NULL),
(1728, 'Province of Catanzaro', 107, 'inactive', NULL, NULL, NULL),
(1729, 'Libero consorzio comunale di Ragusa', 107, 'inactive', NULL, NULL, NULL),
(1730, 'Province of Carbonia-Iglesias', 107, 'inactive', NULL, NULL, NULL),
(1731, 'Province of Caserta', 107, 'inactive', NULL, NULL, NULL),
(1732, 'Province of Savona', 107, 'inactive', NULL, NULL, NULL),
(1733, 'Libero consorzio comunale di Trapani', 107, 'inactive', NULL, NULL, NULL),
(1734, 'Province of Siena', 107, 'inactive', NULL, NULL, NULL),
(1735, 'Province of Viterbo', 107, 'inactive', NULL, NULL, NULL),
(1736, 'Province of Verona', 107, 'inactive', NULL, NULL, NULL),
(1737, 'Province of Vibo Valentia', 107, 'inactive', NULL, NULL, NULL),
(1738, 'Province of Vicenza', 107, 'inactive', NULL, NULL, NULL),
(1739, 'Province of Chieti', 107, 'inactive', NULL, NULL, NULL),
(1740, 'Province of Como', 107, 'inactive', NULL, NULL, NULL),
(1741, 'Province of Sondrio', 107, 'inactive', NULL, NULL, NULL),
(1742, 'Province of Cosenza', 107, 'inactive', NULL, NULL, NULL),
(1743, 'Province of Taranto', 107, 'inactive', NULL, NULL, NULL),
(1744, 'Province of Fermo', 107, 'inactive', NULL, NULL, NULL),
(1745, 'Province of Livorno', 107, 'inactive', NULL, NULL, NULL),
(1746, 'Province of Ferrara', 107, 'inactive', NULL, NULL, NULL),
(1747, 'Province of Lodi', 107, 'inactive', NULL, NULL, NULL),
(1748, 'Trentino', 107, 'inactive', NULL, NULL, NULL),
(1749, 'Province of Lucca', 107, 'inactive', NULL, NULL, NULL),
(1750, 'Province of Macerata', 107, 'inactive', NULL, NULL, NULL),
(1751, 'Province of Cremona', 107, 'inactive', NULL, NULL, NULL),
(1752, 'Province of Teramo', 107, 'inactive', NULL, NULL, NULL),
(1753, 'Veneto', 107, 'inactive', NULL, NULL, NULL),
(1754, 'Province of Crotone', 107, 'inactive', NULL, NULL, NULL),
(1755, 'Province of Terni', 107, 'inactive', NULL, NULL, NULL),
(1756, 'Friuli–Venezia Giulia', 107, 'inactive', NULL, NULL, NULL),
(1757, 'Province of Modena', 107, 'inactive', NULL, NULL, NULL),
(1758, 'Province of Mantua', 107, 'inactive', NULL, NULL, NULL),
(1759, 'Province of Massa and Carrara', 107, 'inactive', NULL, NULL, NULL),
(1760, 'Province of Matera', 107, 'inactive', NULL, NULL, NULL),
(1761, 'Province of Medio Campidano', 107, 'inactive', NULL, NULL, NULL),
(1762, 'Province of Treviso', 107, 'inactive', NULL, NULL, NULL),
(1763, 'Province of Trieste', 107, 'inactive', NULL, NULL, NULL),
(1764, 'Province of Udine', 107, 'inactive', NULL, NULL, NULL),
(1765, 'Province of Varese', 107, 'inactive', NULL, NULL, NULL),
(1766, 'Metropolitan City of Catania', 107, 'inactive', NULL, NULL, NULL),
(1767, 'South Tyrol', 107, 'inactive', NULL, NULL, NULL),
(1768, 'Liguria', 107, 'inactive', NULL, NULL, NULL),
(1769, 'Province of Monza and Brianza', 107, 'inactive', NULL, NULL, NULL),
(1770, 'Metropolitan City of Messina', 107, 'inactive', NULL, NULL, NULL),
(1771, 'Province of Foggia', 107, 'inactive', NULL, NULL, NULL),
(1772, 'Metropolitan City of Bari', 107, 'inactive', NULL, NULL, NULL),
(1773, 'Emilia-Romagna', 107, 'inactive', NULL, NULL, NULL),
(1774, 'Province of Novara', 107, 'inactive', NULL, NULL, NULL),
(1775, 'Province of Cuneo', 107, 'inactive', NULL, NULL, NULL),
(1776, 'Province of Frosinone', 107, 'inactive', NULL, NULL, NULL),
(1777, 'Province of Gorizia', 107, 'inactive', NULL, NULL, NULL),
(1778, 'Province of Biella', 107, 'inactive', NULL, NULL, NULL),
(1779, 'Province of Forlì-Cesena', 107, 'inactive', NULL, NULL, NULL),
(1780, 'Province of Asti', 107, 'inactive', NULL, NULL, NULL),
(1781, 'Province of L\'Aquila', 107, 'inactive', NULL, NULL, NULL),
(1782, 'Province of Ogliastra', 107, 'inactive', NULL, NULL, NULL),
(1783, 'Province of Alessandria', 107, 'inactive', NULL, NULL, NULL),
(1784, 'Province of Olbia-Tempio', 107, 'inactive', NULL, NULL, NULL),
(1785, 'Province of Vercelli', 107, 'inactive', NULL, NULL, NULL),
(1786, 'Province of Oristano', 107, 'inactive', NULL, NULL, NULL),
(1787, 'Province of Grosseto', 107, 'inactive', NULL, NULL, NULL),
(1788, 'Province of Imperia', 107, 'inactive', NULL, NULL, NULL),
(1789, 'Province of Isernia', 107, 'inactive', NULL, NULL, NULL),
(1790, 'Province of Nuoro', 107, 'inactive', NULL, NULL, NULL),
(1791, 'Province of La Spezia', 107, 'inactive', NULL, NULL, NULL),
(1792, 'North Sumatra', 102, 'inactive', NULL, NULL, NULL),
(1793, 'Bengkulu', 102, 'inactive', NULL, NULL, NULL),
(1794, 'Central Kalimantan', 102, 'inactive', NULL, NULL, NULL),
(1795, 'South Sulawesi', 102, 'inactive', NULL, NULL, NULL),
(1796, 'Southeast Sulawesi', 102, 'inactive', NULL, NULL, NULL),
(1797, 'Sumatra', 102, 'inactive', NULL, NULL, NULL),
(1798, 'Papua', 102, 'inactive', NULL, NULL, NULL),
(1799, 'West Papua', 102, 'inactive', NULL, NULL, NULL),
(1800, 'Maluku', 102, 'inactive', NULL, NULL, NULL),
(1801, 'North Maluku', 102, 'inactive', NULL, NULL, NULL),
(1802, 'Central Java', 102, 'inactive', NULL, NULL, NULL),
(1803, 'Sulawesi', 102, 'inactive', NULL, NULL, NULL),
(1804, 'East Kalimantan', 102, 'inactive', NULL, NULL, NULL),
(1805, 'Jakarta', 102, 'inactive', NULL, NULL, NULL),
(1806, 'Kalimantan', 102, 'inactive', NULL, NULL, NULL),
(1807, 'Riau Islands', 102, 'inactive', NULL, NULL, NULL),
(1808, 'North Sulawesi', 102, 'inactive', NULL, NULL, NULL),
(1809, 'Riau', 102, 'inactive', NULL, NULL, NULL),
(1810, 'Banten', 102, 'inactive', NULL, NULL, NULL),
(1811, 'Lampung', 102, 'inactive', NULL, NULL, NULL),
(1812, 'Gorontalo', 102, 'inactive', NULL, NULL, NULL),
(1813, 'Central Sulawesi', 102, 'inactive', NULL, NULL, NULL),
(1814, 'West Nusa Tenggara', 102, 'inactive', NULL, NULL, NULL),
(1815, 'Jambi', 102, 'inactive', NULL, NULL, NULL),
(1816, 'South Sumatra', 102, 'inactive', NULL, NULL, NULL),
(1817, 'West Sulawesi', 102, 'inactive', NULL, NULL, NULL),
(1818, 'East Nusa Tenggara', 102, 'inactive', NULL, NULL, NULL),
(1819, 'South Kalimantan', 102, 'inactive', NULL, NULL, NULL),
(1820, 'Bangka Belitung Islands', 102, 'inactive', NULL, NULL, NULL),
(1821, 'Lesser Sunda Islands', 102, 'inactive', NULL, NULL, NULL),
(1822, 'Aceh', 102, 'inactive', NULL, NULL, NULL),
(1823, 'Maluku Islands', 102, 'inactive', NULL, NULL, NULL),
(1824, 'North Kalimantan', 102, 'inactive', NULL, NULL, NULL),
(1825, 'West Java', 102, 'inactive', NULL, NULL, NULL),
(1826, 'Bali', 102, 'inactive', NULL, NULL, NULL),
(1827, 'East Java', 102, 'inactive', NULL, NULL, NULL),
(1828, 'West Sumatra', 102, 'inactive', NULL, NULL, NULL),
(1829, 'Special Region of Yogyakarta', 102, 'inactive', NULL, NULL, NULL),
(1830, 'Phoenix Islands', 114, 'inactive', NULL, NULL, NULL),
(1831, 'Gilbert Islands', 114, 'inactive', NULL, NULL, NULL),
(1832, 'Line Islands', 114, 'inactive', NULL, NULL, NULL),
(1833, 'Primorsky Krai', 182, 'inactive', NULL, NULL, NULL),
(1834, 'Novgorod Oblast', 182, 'inactive', NULL, NULL, NULL),
(1835, 'Jewish Autonomous Oblast', 182, 'inactive', NULL, NULL, NULL),
(1836, 'Nenets Autonomous Okrug', 182, 'inactive', NULL, NULL, NULL),
(1837, 'Rostov Oblast', 182, 'inactive', NULL, NULL, NULL),
(1838, 'Khanty-Mansi Autonomous Okrug', 182, 'inactive', NULL, NULL, NULL),
(1839, 'Magadan Oblast', 182, 'inactive', NULL, NULL, NULL),
(1840, 'Krasnoyarsk Krai', 182, 'inactive', NULL, NULL, NULL),
(1841, 'Republic of Karelia', 182, 'inactive', NULL, NULL, NULL),
(1842, 'Republic of Buryatia', 182, 'inactive', NULL, NULL, NULL),
(1843, 'Murmansk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1844, 'Kaluga Oblast', 182, 'inactive', NULL, NULL, NULL),
(1845, 'Chelyabinsk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1846, 'Omsk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1847, 'Yamalo-Nenets Autonomous Okrug', 182, 'inactive', NULL, NULL, NULL),
(1848, 'Sakha Republic', 182, 'inactive', NULL, NULL, NULL),
(1849, 'Arkhangelsk', 182, 'inactive', NULL, NULL, NULL),
(1850, 'Republic of Dagestan', 182, 'inactive', NULL, NULL, NULL),
(1851, 'Yaroslavl Oblast', 182, 'inactive', NULL, NULL, NULL),
(1852, 'Republic of Adygea', 182, 'inactive', NULL, NULL, NULL),
(1853, 'Republic of North Ossetia-Alania', 182, 'inactive', NULL, NULL, NULL),
(1854, 'Republic of Bashkortostan', 182, 'inactive', NULL, NULL, NULL),
(1855, 'Kursk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1856, 'Ulyanovsk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1857, 'Nizhny Novgorod Oblast', 182, 'inactive', NULL, NULL, NULL),
(1858, 'Amur Oblast', 182, 'inactive', NULL, NULL, NULL),
(1859, 'Chukotka Autonomous Okrug', 182, 'inactive', NULL, NULL, NULL),
(1860, 'Tver Oblast', 182, 'inactive', NULL, NULL, NULL),
(1861, 'Republic of Tatarstan', 182, 'inactive', NULL, NULL, NULL),
(1862, 'Samara Oblast', 182, 'inactive', NULL, NULL, NULL),
(1863, 'Pskov Oblast', 182, 'inactive', NULL, NULL, NULL),
(1864, 'Ivanovo Oblast', 182, 'inactive', NULL, NULL, NULL),
(1865, 'Kamchatka Krai', 182, 'inactive', NULL, NULL, NULL),
(1866, 'Astrakhan Oblast', 182, 'inactive', NULL, NULL, NULL),
(1867, 'Bryansk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1868, 'Stavropol Krai', 182, 'inactive', NULL, NULL, NULL),
(1869, 'Karachay-Cherkess Republic', 182, 'inactive', NULL, NULL, NULL),
(1870, 'Mari El Republic', 182, 'inactive', NULL, NULL, NULL),
(1871, 'Perm Krai', 182, 'inactive', NULL, NULL, NULL),
(1872, 'Tomsk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1873, 'Khabarovsk Krai', 182, 'inactive', NULL, NULL, NULL),
(1874, 'Vologda Oblast', 182, 'inactive', NULL, NULL, NULL),
(1875, 'Sakhalin', 182, 'inactive', NULL, NULL, NULL),
(1876, 'Altai Republic', 182, 'inactive', NULL, NULL, NULL),
(1877, 'Republic of Khakassia', 182, 'inactive', NULL, NULL, NULL),
(1878, 'Tambov Oblast', 182, 'inactive', NULL, NULL, NULL),
(1879, 'Saint Petersburg', 182, 'inactive', NULL, NULL, NULL),
(1880, 'Irkutsk', 182, 'inactive', NULL, NULL, NULL),
(1881, 'Vladimir Oblast', 182, 'inactive', NULL, NULL, NULL),
(1882, 'Moscow Oblast', 182, 'inactive', NULL, NULL, NULL),
(1883, 'Republic of Kalmykia', 182, 'inactive', NULL, NULL, NULL),
(1884, 'Republic of Ingushetia', 182, 'inactive', NULL, NULL, NULL),
(1885, 'Smolensk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1886, 'Orenburg Oblast', 182, 'inactive', NULL, NULL, NULL),
(1887, 'Saratov Oblast', 182, 'inactive', NULL, NULL, NULL),
(1888, 'Novosibirsk', 182, 'inactive', NULL, NULL, NULL),
(1889, 'Lipetsk Oblast', 182, 'inactive', NULL, NULL, NULL),
(1890, 'Kirov Oblast', 182, 'inactive', NULL, NULL, NULL),
(1891, 'Krasnodar Krai', 182, 'inactive', NULL, NULL, NULL),
(1892, 'Kabardino-Balkar Republic', 182, 'inactive', NULL, NULL, NULL),
(1893, 'Chechen Republic', 182, 'inactive', NULL, NULL, NULL),
(1894, 'Sverdlovsk', 182, 'inactive', NULL, NULL, NULL),
(1895, 'Tula Oblast', 182, 'inactive', NULL, NULL, NULL),
(1896, 'Leningrad Oblast', 182, 'inactive', NULL, NULL, NULL),
(1897, 'Kemerovo Oblast', 182, 'inactive', NULL, NULL, NULL),
(1898, 'Republic of Mordovia', 182, 'inactive', NULL, NULL, NULL),
(1899, 'Komi Republic', 182, 'inactive', NULL, NULL, NULL),
(1900, 'Tuva Republic', 182, 'inactive', NULL, NULL, NULL),
(1901, 'Moscow', 182, 'inactive', NULL, NULL, NULL),
(1902, 'Kaliningrad', 182, 'inactive', NULL, NULL, NULL),
(1903, 'Belgorod Oblast', 182, 'inactive', NULL, NULL, NULL),
(1904, 'Zabaykalsky Krai', 182, 'inactive', NULL, NULL, NULL),
(1905, 'Ryazan Oblast', 182, 'inactive', NULL, NULL, NULL),
(1906, 'Voronezh Oblast', 182, 'inactive', NULL, NULL, NULL),
(1907, 'Tyumen Oblast', 182, 'inactive', NULL, NULL, NULL),
(1908, 'Oryol Oblast', 182, 'inactive', NULL, NULL, NULL),
(1909, 'Penza Oblast', 182, 'inactive', NULL, NULL, NULL),
(1910, 'Kostroma Oblast', 182, 'inactive', NULL, NULL, NULL),
(1911, 'Altai Krai', 182, 'inactive', NULL, NULL, NULL),
(1912, 'Sevastopol', 182, 'inactive', NULL, NULL, NULL),
(1913, 'Udmurt Republic', 182, 'inactive', NULL, NULL, NULL),
(1914, 'Chuvash Republic', 182, 'inactive', NULL, NULL, NULL),
(1915, 'Kurgan Oblast', 182, 'inactive', NULL, NULL, NULL),
(1916, 'Lomaiviti', 73, 'inactive', NULL, NULL, NULL),
(1917, 'Ba', 73, 'inactive', NULL, NULL, NULL),
(1918, 'Tailevu', 73, 'inactive', NULL, NULL, NULL),
(1919, 'Nadroga-Navosa', 73, 'inactive', NULL, NULL, NULL),
(1920, 'Rewa', 73, 'inactive', NULL, NULL, NULL),
(1921, 'Northern Division', 73, 'inactive', NULL, NULL, NULL),
(1922, 'Macuata', 73, 'inactive', NULL, NULL, NULL),
(1923, 'Western Division', 73, 'inactive', NULL, NULL, NULL),
(1924, 'Cakaudrove', 73, 'inactive', NULL, NULL, NULL),
(1925, 'Serua', 73, 'inactive', NULL, NULL, NULL),
(1926, 'Ra', 73, 'inactive', NULL, NULL, NULL),
(1927, 'Naitasiri', 73, 'inactive', NULL, NULL, NULL),
(1928, 'Namosi', 73, 'inactive', NULL, NULL, NULL),
(1929, 'Central Division', 73, 'inactive', NULL, NULL, NULL),
(1930, 'Bua', 73, 'inactive', NULL, NULL, NULL),
(1931, 'Rotuma', 73, 'inactive', NULL, NULL, NULL),
(1932, 'Eastern Division', 73, 'inactive', NULL, NULL, NULL),
(1933, 'Lau', 73, 'inactive', NULL, NULL, NULL),
(1934, 'Kadavu', 73, 'inactive', NULL, NULL, NULL),
(1935, 'Labuan', 132, 'inactive', NULL, NULL, NULL),
(1936, 'Sabah', 132, 'inactive', NULL, NULL, NULL),
(1937, 'Sarawak', 132, 'inactive', NULL, NULL, NULL),
(1938, 'Perlis', 132, 'inactive', NULL, NULL, NULL),
(1939, 'Penang', 132, 'inactive', NULL, NULL, NULL),
(1940, 'Pahang', 132, 'inactive', NULL, NULL, NULL),
(1941, 'Melaka', 132, 'inactive', NULL, NULL, NULL),
(1942, 'Terengganu', 132, 'inactive', NULL, NULL, NULL),
(1943, 'Perak', 132, 'inactive', NULL, NULL, NULL),
(1944, 'Selangor', 132, 'inactive', NULL, NULL, NULL),
(1945, 'Putrajaya', 132, 'inactive', NULL, NULL, NULL),
(1946, 'Kelantan', 132, 'inactive', NULL, NULL, NULL),
(1947, 'Kedah', 132, 'inactive', NULL, NULL, NULL),
(1948, 'Negeri Sembilan', 132, 'inactive', NULL, NULL, NULL),
(1949, 'Kuala Lumpur', 132, 'inactive', NULL, NULL, NULL),
(1950, 'Johor', 132, 'inactive', NULL, NULL, NULL),
(1951, 'Mashonaland East Province', 247, 'inactive', NULL, NULL, NULL),
(1952, 'Matabeleland South Province', 247, 'inactive', NULL, NULL, NULL),
(1953, 'Mashonaland West Province', 247, 'inactive', NULL, NULL, NULL),
(1954, 'Matabeleland North Province', 247, 'inactive', NULL, NULL, NULL),
(1955, 'Mashonaland Central Province', 247, 'inactive', NULL, NULL, NULL),
(1956, 'Bulawayo Province', 247, 'inactive', NULL, NULL, NULL),
(1957, 'Midlands Province', 247, 'inactive', NULL, NULL, NULL),
(1958, 'Harare Province', 247, 'inactive', NULL, NULL, NULL),
(1959, 'Manicaland', 247, 'inactive', NULL, NULL, NULL),
(1960, 'Masvingo Province', 247, 'inactive', NULL, NULL, NULL),
(1961, 'Bulgan Province', 146, 'inactive', NULL, NULL, NULL),
(1962, 'Darkhan-Uul Province', 146, 'inactive', NULL, NULL, NULL),
(1963, 'Dornod Province', 146, 'inactive', NULL, NULL, NULL),
(1964, 'Khovd Province', 146, 'inactive', NULL, NULL, NULL),
(1965, 'Övörkhangai Province', 146, 'inactive', NULL, NULL, NULL),
(1966, 'Orkhon Province', 146, 'inactive', NULL, NULL, NULL),
(1967, 'Ömnögovi Province', 146, 'inactive', NULL, NULL, NULL),
(1968, 'Töv Province', 146, 'inactive', NULL, NULL, NULL),
(1969, 'Bayan-Ölgii Province', 146, 'inactive', NULL, NULL, NULL),
(1970, 'Dundgovi Province', 146, 'inactive', NULL, NULL, NULL),
(1971, 'Uvs Province', 146, 'inactive', NULL, NULL, NULL),
(1972, 'Govi-Altai Province', 146, 'inactive', NULL, NULL, NULL),
(1973, 'Arkhangai Province', 146, 'inactive', NULL, NULL, NULL),
(1974, 'Khentii Province', 146, 'inactive', NULL, NULL, NULL),
(1975, 'Khövsgöl Province', 146, 'inactive', NULL, NULL, NULL),
(1976, 'Bayankhongor Province', 146, 'inactive', NULL, NULL, NULL),
(1977, 'Sükhbaatar Province', 146, 'inactive', NULL, NULL, NULL),
(1978, 'Govisümber Province', 146, 'inactive', NULL, NULL, NULL),
(1979, 'Zavkhan Province', 146, 'inactive', NULL, NULL, NULL),
(1980, 'Selenge Province', 146, 'inactive', NULL, NULL, NULL),
(1981, 'Dornogovi Province', 146, 'inactive', NULL, NULL, NULL),
(1982, 'Northern Province', 246, 'inactive', NULL, NULL, NULL),
(1983, 'Western Province', 246, 'inactive', NULL, NULL, NULL),
(1984, 'Copperbelt Province', 246, 'inactive', NULL, NULL, NULL),
(1985, 'Northwestern Province', 246, 'inactive', NULL, NULL, NULL),
(1986, 'Central Province', 246, 'inactive', NULL, NULL, NULL),
(1987, 'Luapula Province', 246, 'inactive', NULL, NULL, NULL),
(1988, 'Lusaka Province', 246, 'inactive', NULL, NULL, NULL),
(1989, 'Muchinga Province', 246, 'inactive', NULL, NULL, NULL),
(1990, 'Southern Province', 246, 'inactive', NULL, NULL, NULL),
(1991, 'Eastern Province', 246, 'inactive', NULL, NULL, NULL),
(1992, 'Capital Governorate', 18, 'inactive', NULL, NULL, NULL),
(1993, 'Southern Governorate', 18, 'inactive', NULL, NULL, NULL),
(1994, 'Northern Governorate', 18, 'inactive', NULL, NULL, NULL),
(1995, 'Muharraq Governorate', 18, 'inactive', NULL, NULL, NULL),
(1996, 'Central Governorate', 18, 'inactive', NULL, NULL, NULL),
(1997, 'Rio de Janeiro', 31, 'inactive', NULL, NULL, NULL),
(1998, 'Minas Gerais', 31, 'inactive', NULL, NULL, NULL),
(1999, 'Amapá', 31, 'inactive', NULL, NULL, NULL),
(2000, 'Goiás', 31, 'inactive', NULL, NULL, NULL),
(2001, 'Rio Grande do Sul', 31, 'inactive', NULL, NULL, NULL),
(2002, 'Bahia', 31, 'inactive', NULL, NULL, NULL),
(2003, 'Sergipe', 31, 'inactive', NULL, NULL, NULL),
(2004, 'Amazonas', 31, 'inactive', NULL, NULL, NULL),
(2005, 'Paraíba', 31, 'inactive', NULL, NULL, NULL),
(2006, 'Pernambuco', 31, 'inactive', NULL, NULL, NULL),
(2007, 'Alagoas', 31, 'inactive', NULL, NULL, NULL),
(2008, 'Piauí', 31, 'inactive', NULL, NULL, NULL),
(2009, 'Pará', 31, 'inactive', NULL, NULL, NULL),
(2010, 'Mato Grosso do Sul', 31, 'inactive', NULL, NULL, NULL),
(2011, 'Mato Grosso', 31, 'inactive', NULL, NULL, NULL),
(2012, 'Acre', 31, 'inactive', NULL, NULL, NULL),
(2013, 'Rondônia', 31, 'inactive', NULL, NULL, NULL),
(2014, 'Santa Catarina', 31, 'inactive', NULL, NULL, NULL),
(2015, 'Maranhão', 31, 'inactive', NULL, NULL, NULL),
(2016, 'Ceará', 31, 'inactive', NULL, NULL, NULL),
(2017, 'Federal District', 31, 'inactive', NULL, NULL, NULL),
(2018, 'Espírito Santo', 31, 'inactive', NULL, NULL, NULL),
(2019, 'Rio Grande do Norte', 31, 'inactive', NULL, NULL, NULL),
(2020, 'Tocantins', 31, 'inactive', NULL, NULL, NULL),
(2021, 'São Paulo', 31, 'inactive', NULL, NULL, NULL),
(2022, 'Paraná', 31, 'inactive', NULL, NULL, NULL),
(2023, 'Aragatsotn Region', 12, 'inactive', NULL, NULL, NULL),
(2024, 'Ararat Province', 12, 'inactive', NULL, NULL, NULL),
(2025, 'Vayots Dzor Region', 12, 'inactive', NULL, NULL, NULL),
(2026, 'Armavir Region', 12, 'inactive', NULL, NULL, NULL),
(2027, 'Syunik Province', 12, 'inactive', NULL, NULL, NULL),
(2028, 'Gegharkunik Province', 12, 'inactive', NULL, NULL, NULL),
(2029, 'Lori Region', 12, 'inactive', NULL, NULL, NULL),
(2030, 'Yerevan', 12, 'inactive', NULL, NULL, NULL),
(2031, 'Shirak Region', 12, 'inactive', NULL, NULL, NULL),
(2032, 'Tavush Region', 12, 'inactive', NULL, NULL, NULL),
(2033, 'Kotayk Region', 12, 'inactive', NULL, NULL, NULL),
(2034, 'Cojedes', 239, 'inactive', NULL, NULL, NULL),
(2035, 'Falcón', 239, 'inactive', NULL, NULL, NULL),
(2036, 'Portuguesa', 239, 'inactive', NULL, NULL, NULL),
(2037, 'Miranda', 239, 'inactive', NULL, NULL, NULL),
(2038, 'Lara', 239, 'inactive', NULL, NULL, NULL),
(2039, 'Bolívar', 239, 'inactive', NULL, NULL, NULL),
(2040, 'Carabobo', 239, 'inactive', NULL, NULL, NULL),
(2041, 'Yaracuy', 239, 'inactive', NULL, NULL, NULL),
(2042, 'Zulia', 239, 'inactive', NULL, NULL, NULL),
(2043, 'Trujillo', 239, 'inactive', NULL, NULL, NULL),
(2044, 'Amazonas', 239, 'inactive', NULL, NULL, NULL),
(2045, 'Guárico', 239, 'inactive', NULL, NULL, NULL),
(2046, 'Federal Dependencies of Venezuela', 239, 'inactive', NULL, NULL, NULL),
(2047, 'Aragua', 239, 'inactive', NULL, NULL, NULL),
(2048, 'Táchira', 239, 'inactive', NULL, NULL, NULL),
(2049, 'Barinas', 239, 'inactive', NULL, NULL, NULL),
(2050, 'Anzoátegui', 239, 'inactive', NULL, NULL, NULL),
(2051, 'Delta Amacuro', 239, 'inactive', NULL, NULL, NULL),
(2052, 'Nueva Esparta', 239, 'inactive', NULL, NULL, NULL),
(2053, 'Mérida', 239, 'inactive', NULL, NULL, NULL),
(2054, 'Monagas', 239, 'inactive', NULL, NULL, NULL),
(2055, 'Vargas', 239, 'inactive', NULL, NULL, NULL),
(2056, 'Sucre', 239, 'inactive', NULL, NULL, NULL),
(2057, 'Carinthia', 15, 'inactive', NULL, NULL, NULL),
(2058, 'Upper Austria', 15, 'inactive', NULL, NULL, NULL),
(2059, 'Styria', 15, 'inactive', NULL, NULL, NULL),
(2060, 'Vienna', 15, 'inactive', NULL, NULL, NULL),
(2061, 'Salzburg', 15, 'inactive', NULL, NULL, NULL),
(2062, 'Burgenland', 15, 'inactive', NULL, NULL, NULL),
(2063, 'Vorarlberg', 15, 'inactive', NULL, NULL, NULL),
(2064, 'Tyrol', 15, 'inactive', NULL, NULL, NULL),
(2065, 'Lower Austria', 15, 'inactive', NULL, NULL, NULL),
(2066, 'Mid-Western Region', 154, 'inactive', NULL, NULL, NULL),
(2067, 'Western Region', 154, 'inactive', NULL, NULL, NULL),
(2068, 'Far-Western Development Region', 154, 'inactive', NULL, NULL, NULL),
(2069, 'Eastern Development Region', 154, 'inactive', NULL, NULL, NULL),
(2070, 'Mechi Zone', 154, 'inactive', NULL, NULL, NULL),
(2071, 'Bheri Zone', 154, 'inactive', NULL, NULL, NULL),
(2072, 'Kosi Zone', 154, 'inactive', NULL, NULL, NULL),
(2073, 'Central Region', 154, 'inactive', NULL, NULL, NULL),
(2074, 'Lumbini Zone', 154, 'inactive', NULL, NULL, NULL),
(2075, 'Narayani Zone', 154, 'inactive', NULL, NULL, NULL),
(2076, 'Janakpur Zone', 154, 'inactive', NULL, NULL, NULL),
(2077, 'Rapti Zone', 154, 'inactive', NULL, NULL, NULL),
(2078, 'Seti Zone', 154, 'inactive', NULL, NULL, NULL),
(2079, 'Karnali Zone', 154, 'inactive', NULL, NULL, NULL),
(2080, 'Dhaulagiri Zone', 154, 'inactive', NULL, NULL, NULL),
(2081, 'Gandaki Zone', 154, 'inactive', NULL, NULL, NULL),
(2082, 'Bagmati Zone', 154, 'inactive', NULL, NULL, NULL),
(2083, 'Mahakali Zone', 154, 'inactive', NULL, NULL, NULL),
(2084, 'Sagarmatha Zone', 154, 'inactive', NULL, NULL, NULL),
(2085, 'Unity', 206, 'inactive', NULL, NULL, NULL),
(2086, 'Upper Nile', 206, 'inactive', NULL, NULL, NULL),
(2087, 'Warrap', 206, 'inactive', NULL, NULL, NULL),
(2088, 'Northern Bahr el Ghazal', 206, 'inactive', NULL, NULL, NULL),
(2089, 'Western Equatoria', 206, 'inactive', NULL, NULL, NULL),
(2090, 'Lakes', 206, 'inactive', NULL, NULL, NULL),
(2091, 'Western Bahr el Ghazal', 206, 'inactive', NULL, NULL, NULL),
(2092, 'Central Equatoria', 206, 'inactive', NULL, NULL, NULL),
(2093, 'Eastern Equatoria', 206, 'inactive', NULL, NULL, NULL),
(2094, 'Jonglei State', 206, 'inactive', NULL, NULL, NULL),
(2095, 'Karditsa Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2096, 'West Greece Region', 85, 'inactive', NULL, NULL, NULL),
(2097, 'Thessaloniki Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2098, 'Arcadia Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2099, 'Imathia Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2100, 'Kastoria Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2101, 'Euboea', 85, 'inactive', NULL, NULL, NULL),
(2102, 'Grevena Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2103, 'Preveza Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2104, 'Lefkada Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2105, 'Argolis Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2106, 'Laconia', 85, 'inactive', NULL, NULL, NULL),
(2107, 'Pella Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2108, 'West Macedonia Region', 85, 'inactive', NULL, NULL, NULL),
(2109, 'Crete Region', 85, 'inactive', NULL, NULL, NULL),
(2110, 'Epirus Region', 85, 'inactive', NULL, NULL, NULL),
(2111, 'Kilkis Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2112, 'Kozani Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2113, 'Ioannina Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2114, 'Phthiotis Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2115, 'Chania Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2116, 'Achaea Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2117, 'East Macedonia and Thrace', 85, 'inactive', NULL, NULL, NULL),
(2118, 'South Aegean', 85, 'inactive', NULL, NULL, NULL),
(2119, 'Peloponnese Region', 85, 'inactive', NULL, NULL, NULL),
(2120, 'East Attica Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2121, 'Serres Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2122, 'Attica Region', 85, 'inactive', NULL, NULL, NULL),
(2123, 'Aetolia-Acarnania Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2124, 'Corfu Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2125, 'Central Macedonia', 85, 'inactive', NULL, NULL, NULL),
(2126, 'Boeotia Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2127, 'Kefalonia Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2128, 'Central Greece Region', 85, 'inactive', NULL, NULL, NULL),
(2129, 'Corinthia Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2130, 'Drama Regional Unit', 85, 'inactive', NULL, NULL, NULL),
(2131, 'Ionian Islands Region', 85, 'inactive', NULL, NULL, NULL),
(2132, 'Larissa Prefecture', 85, 'inactive', NULL, NULL, NULL),
(2133, 'Kayin State', 151, 'inactive', NULL, NULL, NULL),
(2134, 'Mandalay Region', 151, 'inactive', NULL, NULL, NULL),
(2135, 'Yangon Region', 151, 'inactive', NULL, NULL, NULL),
(2136, 'Magway Region', 151, 'inactive', NULL, NULL, NULL),
(2137, 'Chin State', 151, 'inactive', NULL, NULL, NULL),
(2138, 'Rakhine State', 151, 'inactive', NULL, NULL, NULL),
(2139, 'Shan State', 151, 'inactive', NULL, NULL, NULL),
(2140, 'Tanintharyi Region', 151, 'inactive', NULL, NULL, NULL),
(2141, 'Bago', 151, 'inactive', NULL, NULL, NULL),
(2142, 'Ayeyarwady Region', 151, 'inactive', NULL, NULL, NULL),
(2143, 'Kachin State', 151, 'inactive', NULL, NULL, NULL),
(2144, 'Kayah State', 151, 'inactive', NULL, NULL, NULL),
(2145, 'Sagaing Region', 151, 'inactive', NULL, NULL, NULL),
(2146, 'Naypyidaw Union Territory', 151, 'inactive', NULL, NULL, NULL),
(2147, 'Mon State', 151, 'inactive', NULL, NULL, NULL),
(2148, 'Bartın Province', 225, 'inactive', NULL, NULL, NULL),
(2149, 'Kütahya Province', 225, 'inactive', NULL, NULL, NULL),
(2150, 'Sakarya Province', 225, 'inactive', NULL, NULL, NULL),
(2151, 'Edirne Province', 225, 'inactive', NULL, NULL, NULL),
(2152, 'Van Province', 225, 'inactive', NULL, NULL, NULL),
(2153, 'Bingöl Province', 225, 'inactive', NULL, NULL, NULL),
(2154, 'Kilis Province', 225, 'inactive', NULL, NULL, NULL),
(2155, 'Adıyaman Province', 225, 'inactive', NULL, NULL, NULL),
(2156, 'Mersin Province', 225, 'inactive', NULL, NULL, NULL),
(2157, 'Denizli Province', 225, 'inactive', NULL, NULL, NULL),
(2158, 'Malatya Province', 225, 'inactive', NULL, NULL, NULL),
(2159, 'Elazığ Province', 225, 'inactive', NULL, NULL, NULL),
(2160, 'Erzincan Province', 225, 'inactive', NULL, NULL, NULL),
(2161, 'Amasya Province', 225, 'inactive', NULL, NULL, NULL),
(2162, 'Muş Province', 225, 'inactive', NULL, NULL, NULL),
(2163, 'Bursa Province', 225, 'inactive', NULL, NULL, NULL),
(2164, 'Eskişehir Province', 225, 'inactive', NULL, NULL, NULL),
(2165, 'Erzurum Province', 225, 'inactive', NULL, NULL, NULL),
(2166, 'Iğdır Province', 225, 'inactive', NULL, NULL, NULL),
(2167, 'Tekirdağ Province', 225, 'inactive', NULL, NULL, NULL),
(2168, 'Çankırı Province', 225, 'inactive', NULL, NULL, NULL),
(2169, 'Antalya Province', 225, 'inactive', NULL, NULL, NULL),
(2170, 'Istanbul Province', 225, 'inactive', NULL, NULL, NULL),
(2171, 'Konya Province', 225, 'inactive', NULL, NULL, NULL),
(2172, 'Bolu Province', 225, 'inactive', NULL, NULL, NULL),
(2173, 'Çorum Province', 225, 'inactive', NULL, NULL, NULL),
(2174, 'Ordu Province', 225, 'inactive', NULL, NULL, NULL),
(2175, 'Balıkesir Province', 225, 'inactive', NULL, NULL, NULL),
(2176, 'Kırklareli Province', 225, 'inactive', NULL, NULL, NULL),
(2177, 'Bayburt Province', 225, 'inactive', NULL, NULL, NULL),
(2178, 'Kırıkkale Province', 225, 'inactive', NULL, NULL, NULL),
(2179, 'Afyonkarahisar Province', 225, 'inactive', NULL, NULL, NULL),
(2180, 'Kırşehir Province', 225, 'inactive', NULL, NULL, NULL),
(2181, 'Sivas Province', 225, 'inactive', NULL, NULL, NULL),
(2182, 'Muğla Province', 225, 'inactive', NULL, NULL, NULL),
(2183, 'Şanlıurfa Province', 225, 'inactive', NULL, NULL, NULL),
(2184, 'Karaman Province', 225, 'inactive', NULL, NULL, NULL),
(2185, 'Ardahan Province', 225, 'inactive', NULL, NULL, NULL),
(2186, 'Giresun Province', 225, 'inactive', NULL, NULL, NULL),
(2187, 'Aydın Province', 225, 'inactive', NULL, NULL, NULL),
(2188, 'Yozgat Province', 225, 'inactive', NULL, NULL, NULL),
(2189, 'Niğde Province', 225, 'inactive', NULL, NULL, NULL),
(2190, 'Hakkâri Province', 225, 'inactive', NULL, NULL, NULL),
(2191, 'Artvin Province', 225, 'inactive', NULL, NULL, NULL),
(2192, 'Tunceli Province', 225, 'inactive', NULL, NULL, NULL),
(2193, 'Ağrı Province', 225, 'inactive', NULL, NULL, NULL),
(2194, 'Batman Province', 225, 'inactive', NULL, NULL, NULL),
(2195, 'Kocaeli Province', 225, 'inactive', NULL, NULL, NULL),
(2196, 'Nevşehir Province', 225, 'inactive', NULL, NULL, NULL),
(2197, 'Kastamonu Province', 225, 'inactive', NULL, NULL, NULL),
(2198, 'Manisa Province', 225, 'inactive', NULL, NULL, NULL),
(2199, 'Tokat Province', 225, 'inactive', NULL, NULL, NULL),
(2200, 'Kayseri Province', 225, 'inactive', NULL, NULL, NULL),
(2201, 'Uşak Province', 225, 'inactive', NULL, NULL, NULL),
(2202, 'Düzce Province', 225, 'inactive', NULL, NULL, NULL),
(2203, 'Gaziantep Province', 225, 'inactive', NULL, NULL, NULL),
(2204, 'Gümüşhane Province', 225, 'inactive', NULL, NULL, NULL),
(2205, 'İzmir Province', 225, 'inactive', NULL, NULL, NULL),
(2206, 'Trabzon Province', 225, 'inactive', NULL, NULL, NULL),
(2207, 'Siirt Province', 225, 'inactive', NULL, NULL, NULL),
(2208, 'Kars Province', 225, 'inactive', NULL, NULL, NULL),
(2209, 'Burdur Province', 225, 'inactive', NULL, NULL, NULL),
(2210, 'Aksaray Province', 225, 'inactive', NULL, NULL, NULL),
(2211, 'Hatay Province', 225, 'inactive', NULL, NULL, NULL),
(2212, 'Adana Province', 225, 'inactive', NULL, NULL, NULL),
(2213, 'Zonguldak Province', 225, 'inactive', NULL, NULL, NULL),
(2214, 'Osmaniye Province', 225, 'inactive', NULL, NULL, NULL),
(2215, 'Bitlis Province', 225, 'inactive', NULL, NULL, NULL),
(2216, 'Çanakkale Province', 225, 'inactive', NULL, NULL, NULL),
(2217, 'Ankara Province', 225, 'inactive', NULL, NULL, NULL),
(2218, 'Yalova Province', 225, 'inactive', NULL, NULL, NULL),
(2219, 'Rize Province', 225, 'inactive', NULL, NULL, NULL),
(2220, 'Samsun Province', 225, 'inactive', NULL, NULL, NULL),
(2221, 'Bilecik Province', 225, 'inactive', NULL, NULL, NULL),
(2222, 'Isparta Province', 225, 'inactive', NULL, NULL, NULL),
(2223, 'Karabük Province', 225, 'inactive', NULL, NULL, NULL),
(2224, 'Mardin Province', 225, 'inactive', NULL, NULL, NULL),
(2225, 'Şırnak Province', 225, 'inactive', NULL, NULL, NULL),
(2226, 'Diyarbakır Province', 225, 'inactive', NULL, NULL, NULL),
(2227, 'Kahramanmaraş Province', 225, 'inactive', NULL, NULL, NULL),
(2228, 'Lisbon District', 177, 'inactive', NULL, NULL, NULL),
(2229, 'Bragança District', 177, 'inactive', NULL, NULL, NULL),
(2230, 'Beja District', 177, 'inactive', NULL, NULL, NULL),
(2231, 'Madeira', 177, 'inactive', NULL, NULL, NULL),
(2232, 'Portalegre District', 177, 'inactive', NULL, NULL, NULL),
(2233, 'Azores', 177, 'inactive', NULL, NULL, NULL),
(2234, 'Vila Real District', 177, 'inactive', NULL, NULL, NULL),
(2235, 'Aveiro District', 177, 'inactive', NULL, NULL, NULL),
(2236, 'Évora District', 177, 'inactive', NULL, NULL, NULL),
(2237, 'Viseu District', 177, 'inactive', NULL, NULL, NULL),
(2238, 'Santarém District', 177, 'inactive', NULL, NULL, NULL),
(2239, 'Faro District', 177, 'inactive', NULL, NULL, NULL),
(2240, 'Leiria District', 177, 'inactive', NULL, NULL, NULL),
(2241, 'Castelo Branco District', 177, 'inactive', NULL, NULL, NULL),
(2242, 'Setúbal District', 177, 'inactive', NULL, NULL, NULL),
(2243, 'Porto District', 177, 'inactive', NULL, NULL, NULL),
(2244, 'Braga District', 177, 'inactive', NULL, NULL, NULL),
(2245, 'Viana do Castelo District', 177, 'inactive', NULL, NULL, NULL),
(2246, 'Coimbra District', 177, 'inactive', NULL, NULL, NULL),
(2247, 'Zhejiang', 45, 'inactive', NULL, NULL, NULL),
(2248, 'Fujian', 45, 'inactive', NULL, NULL, NULL),
(2249, 'Shanghai', 45, 'inactive', NULL, NULL, NULL),
(2250, 'Jiangsu', 45, 'inactive', NULL, NULL, NULL),
(2251, 'Anhui', 45, 'inactive', NULL, NULL, NULL),
(2252, 'Shandong', 45, 'inactive', NULL, NULL, NULL),
(2253, 'Jilin', 45, 'inactive', NULL, NULL, NULL),
(2254, 'Shanxi', 45, 'inactive', NULL, NULL, NULL),
(2255, 'Taiwan Province, People\'s Republic of China', 45, 'inactive', NULL, NULL, NULL),
(2256, 'Jiangxi', 45, 'inactive', NULL, NULL, NULL),
(2257, 'Beijing', 45, 'inactive', NULL, NULL, NULL),
(2258, 'Hunan', 45, 'inactive', NULL, NULL, NULL),
(2259, 'Henan', 45, 'inactive', NULL, NULL, NULL),
(2260, 'Yunnan', 45, 'inactive', NULL, NULL, NULL),
(2261, 'Guizhou', 45, 'inactive', NULL, NULL, NULL),
(2262, 'Ningxia Hui Autonomous Region', 45, 'inactive', NULL, NULL, NULL),
(2263, 'Xinjiang', 45, 'inactive', NULL, NULL, NULL),
(2264, 'Tibet Autonomous Region', 45, 'inactive', NULL, NULL, NULL),
(2265, 'Heilongjiang', 45, 'inactive', NULL, NULL, NULL),
(2266, 'Macau', 45, 'inactive', NULL, NULL, NULL),
(2267, 'Hong Kong', 45, 'inactive', NULL, NULL, NULL),
(2268, 'Liaoning', 45, 'inactive', NULL, NULL, NULL),
(2269, 'Inner Mongolia', 45, 'inactive', NULL, NULL, NULL),
(2270, 'Qinghai', 45, 'inactive', NULL, NULL, NULL),
(2271, 'Chongqing', 45, 'inactive', NULL, NULL, NULL),
(2272, 'Shaanxi', 45, 'inactive', NULL, NULL, NULL),
(2273, 'Hainan', 45, 'inactive', NULL, NULL, NULL),
(2274, 'Hubei', 45, 'inactive', NULL, NULL, NULL),
(2275, 'Gansu', 45, 'inactive', NULL, NULL, NULL),
(2276, 'Keelung', 45, 'inactive', NULL, NULL, NULL),
(2277, 'Sichuan', 45, 'inactive', NULL, NULL, NULL),
(2278, 'Guangxi Zhuang Autonomous Region', 45, 'inactive', NULL, NULL, NULL),
(2279, 'Guangdong', 45, 'inactive', NULL, NULL, NULL),
(2280, 'Hebei', 45, 'inactive', NULL, NULL, NULL),
(2281, 'South Governorate', 121, 'inactive', NULL, NULL, NULL),
(2282, 'Mount Lebanon Governorate', 121, 'inactive', NULL, NULL, NULL),
(2283, 'Baalbek-Hermel Governorate', 121, 'inactive', NULL, NULL, NULL),
(2284, 'North Governorate', 121, 'inactive', NULL, NULL, NULL),
(2285, 'Akkar Governorate', 121, 'inactive', NULL, NULL, NULL),
(2286, 'Beirut Governorate', 121, 'inactive', NULL, NULL, NULL),
(2287, 'Beqaa Governorate', 121, 'inactive', NULL, NULL, NULL),
(2288, 'Nabatieh Governorate', 121, 'inactive', NULL, NULL, NULL),
(2289, 'Isle of Wight', 232, 'inactive', NULL, NULL, NULL),
(2290, 'St Helens', 232, 'inactive', NULL, NULL, NULL),
(2291, 'London Borough of Brent', 232, 'inactive', NULL, NULL, NULL),
(2292, 'Walsall', 232, 'inactive', NULL, NULL, NULL),
(2293, 'Trafford', 232, 'inactive', NULL, NULL, NULL),
(2294, 'City of Southampton', 232, 'inactive', NULL, NULL, NULL),
(2295, 'Sheffield', 232, 'inactive', NULL, NULL, NULL),
(2296, 'West Sussex', 232, 'inactive', NULL, NULL, NULL),
(2297, 'City of Peterborough', 232, 'inactive', NULL, NULL, NULL),
(2298, 'Caerphilly County Borough', 232, 'inactive', NULL, NULL, NULL),
(2299, 'Vale of Glamorgan', 232, 'inactive', NULL, NULL, NULL),
(2300, 'Shetland Islands', 232, 'inactive', NULL, NULL, NULL),
(2301, 'Rhondda Cynon Taf', 232, 'inactive', NULL, NULL, NULL),
(2302, 'Poole', 232, 'inactive', NULL, NULL, NULL),
(2303, 'Central Bedfordshire', 232, 'inactive', NULL, NULL, NULL),
(2304, 'Down District Council', 232, 'inactive', NULL, NULL, NULL),
(2305, 'City of Portsmouth', 232, 'inactive', NULL, NULL, NULL),
(2306, 'London Borough of Haringey', 232, 'inactive', NULL, NULL, NULL),
(2307, 'London Borough of Bexley', 232, 'inactive', NULL, NULL, NULL),
(2308, 'Rotherham', 232, 'inactive', NULL, NULL, NULL),
(2309, 'Hartlepool', 232, 'inactive', NULL, NULL, NULL),
(2310, 'Telford and Wrekin', 232, 'inactive', NULL, NULL, NULL),
(2311, 'Belfast district', 232, 'inactive', NULL, NULL, NULL),
(2312, 'Cornwall', 232, 'inactive', NULL, NULL, NULL),
(2313, 'London Borough of Sutton', 232, 'inactive', NULL, NULL, NULL),
(2314, 'Omagh District Council', 232, 'inactive', NULL, NULL, NULL),
(2315, 'Banbridge', 232, 'inactive', NULL, NULL, NULL),
(2316, 'Causeway Coast and Glens', 232, 'inactive', NULL, NULL, NULL),
(2317, 'Newtownabbey Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2318, 'City of Leicester', 232, 'inactive', NULL, NULL, NULL),
(2319, 'London Borough of Islington', 232, 'inactive', NULL, NULL, NULL),
(2320, 'Metropolitan Borough of Wigan', 232, 'inactive', NULL, NULL, NULL),
(2321, 'Oxfordshire', 232, 'inactive', NULL, NULL, NULL),
(2322, 'Magherafelt District Council', 232, 'inactive', NULL, NULL, NULL),
(2323, 'Southend-on-Sea', 232, 'inactive', NULL, NULL, NULL),
(2324, 'Armagh, Banbridge and Craigavon', 232, 'inactive', NULL, NULL, NULL),
(2325, 'Perth and Kinross', 232, 'inactive', NULL, NULL, NULL),
(2326, 'London Borough of Waltham Forest', 232, 'inactive', NULL, NULL, NULL),
(2327, 'Rochdale', 232, 'inactive', NULL, NULL, NULL),
(2328, 'Merthyr Tydfil County Borough', 232, 'inactive', NULL, NULL, NULL),
(2329, 'Blackburn with Darwen', 232, 'inactive', NULL, NULL, NULL),
(2330, 'Knowsley', 232, 'inactive', NULL, NULL, NULL),
(2331, 'Armagh City and District Council', 232, 'inactive', NULL, NULL, NULL),
(2332, 'Middlesbrough', 232, 'inactive', NULL, NULL, NULL),
(2333, 'East Renfrewshire', 232, 'inactive', NULL, NULL, NULL),
(2334, 'Cumbria', 232, 'inactive', NULL, NULL, NULL),
(2335, 'Scotland', 232, 'inactive', NULL, NULL, NULL),
(2336, 'England', 232, 'inactive', NULL, NULL, NULL),
(2337, 'Northern Ireland', 232, 'inactive', NULL, NULL, NULL),
(2338, 'Wales', 232, 'inactive', NULL, NULL, NULL),
(2339, 'Bath and North East Somerset', 232, 'inactive', NULL, NULL, NULL),
(2340, 'Liverpool', 232, 'inactive', NULL, NULL, NULL),
(2341, 'Sandwell', 232, 'inactive', NULL, NULL, NULL),
(2342, 'Bournemouth', 232, 'inactive', NULL, NULL, NULL),
(2343, 'Isles of Scilly', 232, 'inactive', NULL, NULL, NULL),
(2344, 'Falkirk', 232, 'inactive', NULL, NULL, NULL),
(2345, 'Dorset', 232, 'inactive', NULL, NULL, NULL),
(2346, 'Scottish Borders', 232, 'inactive', NULL, NULL, NULL),
(2347, 'London Borough of Havering', 232, 'inactive', NULL, NULL, NULL),
(2348, 'Moyle District Council', 232, 'inactive', NULL, NULL, NULL),
(2349, 'London Borough of Camden', 232, 'inactive', NULL, NULL, NULL),
(2350, 'Newry and Mourne District Council', 232, 'inactive', NULL, NULL, NULL),
(2351, 'Neath Port Talbot County Borough', 232, 'inactive', NULL, NULL, NULL),
(2352, 'Conwy County Borough', 232, 'inactive', NULL, NULL, NULL),
(2353, 'Outer Hebrides', 232, 'inactive', NULL, NULL, NULL),
(2354, 'West Lothian', 232, 'inactive', NULL, NULL, NULL),
(2355, 'Lincolnshire', 232, 'inactive', NULL, NULL, NULL),
(2356, 'London Borough of Barking and Dagenham', 232, 'inactive', NULL, NULL, NULL),
(2357, 'City of Westminster', 232, 'inactive', NULL, NULL, NULL),
(2358, 'London Borough of Lewisham', 232, 'inactive', NULL, NULL, NULL),
(2359, 'City of Nottingham', 232, 'inactive', NULL, NULL, NULL),
(2360, 'Moray', 232, 'inactive', NULL, NULL, NULL),
(2361, 'Ballymoney', 232, 'inactive', NULL, NULL, NULL),
(2362, 'South Lanarkshire', 232, 'inactive', NULL, NULL, NULL),
(2363, 'Ballymena Borough', 232, 'inactive', NULL, NULL, NULL),
(2364, 'Doncaster', 232, 'inactive', NULL, NULL, NULL),
(2365, 'Northumberland', 232, 'inactive', NULL, NULL, NULL),
(2366, 'Fermanagh and Omagh', 232, 'inactive', NULL, NULL, NULL),
(2367, 'Tameside', 232, 'inactive', NULL, NULL, NULL),
(2368, 'Royal Borough of Kensington and Chelsea', 232, 'inactive', NULL, NULL, NULL),
(2369, 'Hertfordshire', 232, 'inactive', NULL, NULL, NULL),
(2370, 'East Riding of Yorkshire', 232, 'inactive', NULL, NULL, NULL),
(2371, 'Kirklees', 232, 'inactive', NULL, NULL, NULL),
(2372, 'City of Sunderland', 232, 'inactive', NULL, NULL, NULL),
(2373, 'Gloucestershire', 232, 'inactive', NULL, NULL, NULL),
(2374, 'East Ayrshire', 232, 'inactive', NULL, NULL, NULL),
(2375, 'United Kingdom', 232, 'inactive', NULL, NULL, NULL),
(2376, 'London Borough of Hillingdon', 232, 'inactive', NULL, NULL, NULL),
(2377, 'South Ayrshire', 232, 'inactive', NULL, NULL, NULL),
(2378, 'Ascension Island', 232, 'inactive', NULL, NULL, NULL),
(2379, 'Gwynedd', 232, 'inactive', NULL, NULL, NULL),
(2380, 'London Borough of Hounslow', 232, 'inactive', NULL, NULL, NULL),
(2381, 'Medway', 232, 'inactive', NULL, NULL, NULL),
(2382, 'Limavady Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2383, 'Highland', 232, 'inactive', NULL, NULL, NULL),
(2384, 'North East Lincolnshire', 232, 'inactive', NULL, NULL, NULL),
(2385, 'London Borough of Harrow', 232, 'inactive', NULL, NULL, NULL),
(2386, 'Somerset', 232, 'inactive', NULL, NULL, NULL),
(2387, 'Angus', 232, 'inactive', NULL, NULL, NULL),
(2388, 'Inverclyde', 232, 'inactive', NULL, NULL, NULL),
(2389, 'Darlington', 232, 'inactive', NULL, NULL, NULL),
(2390, 'London Borough of Tower Hamlets', 232, 'inactive', NULL, NULL, NULL),
(2391, 'Wiltshire', 232, 'inactive', NULL, NULL, NULL),
(2392, 'Argyll and Bute', 232, 'inactive', NULL, NULL, NULL),
(2393, 'Strabane District Council', 232, 'inactive', NULL, NULL, NULL),
(2394, 'Stockport', 232, 'inactive', NULL, NULL, NULL),
(2395, 'Brighton and Hove', 232, 'inactive', NULL, NULL, NULL),
(2396, 'London Borough of Lambeth', 232, 'inactive', NULL, NULL, NULL),
(2397, 'London Borough of Redbridge', 232, 'inactive', NULL, NULL, NULL),
(2398, 'Manchester', 232, 'inactive', NULL, NULL, NULL),
(2399, 'Mid Ulster', 232, 'inactive', NULL, NULL, NULL),
(2400, 'South Gloucestershire', 232, 'inactive', NULL, NULL, NULL),
(2401, 'Aberdeenshire', 232, 'inactive', NULL, NULL, NULL),
(2402, 'Monmouthshire', 232, 'inactive', NULL, NULL, NULL),
(2403, 'Derbyshire', 232, 'inactive', NULL, NULL, NULL),
(2404, 'Glasgow', 232, 'inactive', NULL, NULL, NULL),
(2405, 'Buckinghamshire', 232, 'inactive', NULL, NULL, NULL),
(2406, 'County Durham', 232, 'inactive', NULL, NULL, NULL),
(2407, 'Shropshire', 232, 'inactive', NULL, NULL, NULL),
(2408, 'Wirral', 232, 'inactive', NULL, NULL, NULL),
(2409, 'South Tyneside', 232, 'inactive', NULL, NULL, NULL),
(2410, 'Essex', 232, 'inactive', NULL, NULL, NULL),
(2411, 'London Borough of Hackney', 232, 'inactive', NULL, NULL, NULL),
(2412, 'Antrim and Newtownabbey', 232, 'inactive', NULL, NULL, NULL),
(2413, 'City of Bristol', 232, 'inactive', NULL, NULL, NULL),
(2414, 'East Sussex', 232, 'inactive', NULL, NULL, NULL),
(2415, 'Dumfries and Galloway', 232, 'inactive', NULL, NULL, NULL),
(2416, 'Milton Keynes', 232, 'inactive', NULL, NULL, NULL),
(2417, 'Derry City Council', 232, 'inactive', NULL, NULL, NULL),
(2418, 'London Borough of Newham', 232, 'inactive', NULL, NULL, NULL),
(2419, 'Wokingham', 232, 'inactive', NULL, NULL, NULL),
(2420, 'Warrington', 232, 'inactive', NULL, NULL, NULL),
(2421, 'Stockton-on-Tees', 232, 'inactive', NULL, NULL, NULL),
(2422, 'Swindon', 232, 'inactive', NULL, NULL, NULL),
(2423, 'Cambridgeshire', 232, 'inactive', NULL, NULL, NULL),
(2424, 'City of London', 232, 'inactive', NULL, NULL, NULL),
(2425, 'Birmingham', 232, 'inactive', NULL, NULL, NULL),
(2426, 'City of York', 232, 'inactive', NULL, NULL, NULL),
(2427, 'Slough', 232, 'inactive', NULL, NULL, NULL),
(2428, 'Edinburgh', 232, 'inactive', NULL, NULL, NULL),
(2429, 'Mid and East Antrim', 232, 'inactive', NULL, NULL, NULL),
(2430, 'North Somerset', 232, 'inactive', NULL, NULL, NULL),
(2431, 'Gateshead', 232, 'inactive', NULL, NULL, NULL),
(2432, 'London Borough of Southwark', 232, 'inactive', NULL, NULL, NULL),
(2433, 'City and County of Swansea', 232, 'inactive', NULL, NULL, NULL),
(2434, 'London Borough of Wandsworth', 232, 'inactive', NULL, NULL, NULL),
(2435, 'Hampshire', 232, 'inactive', NULL, NULL, NULL),
(2436, 'Wrexham County Borough', 232, 'inactive', NULL, NULL, NULL),
(2437, 'Flintshire', 232, 'inactive', NULL, NULL, NULL),
(2438, 'Coventry', 232, 'inactive', NULL, NULL, NULL),
(2439, 'Carrickfergus Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2440, 'West Dunbartonshire', 232, 'inactive', NULL, NULL, NULL),
(2441, 'Powys', 232, 'inactive', NULL, NULL, NULL),
(2442, 'Cheshire West and Chester', 232, 'inactive', NULL, NULL, NULL),
(2443, 'Renfrewshire', 232, 'inactive', NULL, NULL, NULL),
(2444, 'Cheshire East', 232, 'inactive', NULL, NULL, NULL),
(2445, 'Cookstown District Council', 232, 'inactive', NULL, NULL, NULL),
(2446, 'Derry City and Strabane', 232, 'inactive', NULL, NULL, NULL),
(2447, 'Staffordshire', 232, 'inactive', NULL, NULL, NULL),
(2448, 'London Borough of Hammersmith and Fulham', 232, 'inactive', NULL, NULL, NULL),
(2449, 'Craigavon Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2450, 'Clackmannanshire', 232, 'inactive', NULL, NULL, NULL),
(2451, 'Blackpool', 232, 'inactive', NULL, NULL, NULL),
(2452, 'Bridgend County Borough', 232, 'inactive', NULL, NULL, NULL),
(2453, 'North Lincolnshire', 232, 'inactive', NULL, NULL, NULL),
(2454, 'East Dunbartonshire', 232, 'inactive', NULL, NULL, NULL),
(2455, 'Reading', 232, 'inactive', NULL, NULL, NULL),
(2456, 'Nottinghamshire', 232, 'inactive', NULL, NULL, NULL),
(2457, 'Dudley', 232, 'inactive', NULL, NULL, NULL),
(2458, 'Newcastle upon Tyne', 232, 'inactive', NULL, NULL, NULL),
(2459, 'Bury', 232, 'inactive', NULL, NULL, NULL),
(2460, 'Lisburn and Castlereagh', 232, 'inactive', NULL, NULL, NULL),
(2461, 'Coleraine Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2462, 'East Lothian', 232, 'inactive', NULL, NULL, NULL),
(2463, 'Aberdeen', 232, 'inactive', NULL, NULL, NULL),
(2464, 'Kent', 232, 'inactive', NULL, NULL, NULL),
(2465, 'Wakefield', 232, 'inactive', NULL, NULL, NULL),
(2466, 'Halton', 232, 'inactive', NULL, NULL, NULL),
(2467, 'Suffolk', 232, 'inactive', NULL, NULL, NULL),
(2468, 'Thurrock', 232, 'inactive', NULL, NULL, NULL),
(2469, 'Solihull', 232, 'inactive', NULL, NULL, NULL),
(2470, 'Bracknell Forest', 232, 'inactive', NULL, NULL, NULL),
(2471, 'West Berkshire', 232, 'inactive', NULL, NULL, NULL),
(2472, 'Rutland', 232, 'inactive', NULL, NULL, NULL),
(2473, 'Norfolk', 232, 'inactive', NULL, NULL, NULL),
(2474, 'Orkney Islands', 232, 'inactive', NULL, NULL, NULL),
(2475, 'City of Kingston upon Hull', 232, 'inactive', NULL, NULL, NULL),
(2476, 'London Borough of Enfield', 232, 'inactive', NULL, NULL, NULL),
(2477, 'Oldham', 232, 'inactive', NULL, NULL, NULL),
(2478, 'Torbay', 232, 'inactive', NULL, NULL, NULL),
(2479, 'Fife', 232, 'inactive', NULL, NULL, NULL),
(2480, 'Northamptonshire', 232, 'inactive', NULL, NULL, NULL),
(2481, 'Royal Borough of Kingston upon Thames', 232, 'inactive', NULL, NULL, NULL),
(2482, 'Windsor and Maidenhead', 232, 'inactive', NULL, NULL, NULL),
(2483, 'London Borough of Merton', 232, 'inactive', NULL, NULL, NULL),
(2484, 'Carmarthenshire', 232, 'inactive', NULL, NULL, NULL),
(2485, 'City of Derby', 232, 'inactive', NULL, NULL, NULL),
(2486, 'Pembrokeshire', 232, 'inactive', NULL, NULL, NULL),
(2487, 'North Lanarkshire', 232, 'inactive', NULL, NULL, NULL),
(2488, 'Stirling', 232, 'inactive', NULL, NULL, NULL),
(2489, 'City of Wolverhampton', 232, 'inactive', NULL, NULL, NULL),
(2490, 'London Borough of Bromley', 232, 'inactive', NULL, NULL, NULL),
(2491, 'Devon', 232, 'inactive', NULL, NULL, NULL),
(2492, 'Royal Borough of Greenwich', 232, 'inactive', NULL, NULL, NULL),
(2493, 'Salford', 232, 'inactive', NULL, NULL, NULL),
(2494, 'Lisburn City Council', 232, 'inactive', NULL, NULL, NULL),
(2495, 'Lancashire', 232, 'inactive', NULL, NULL, NULL),
(2496, 'Torfaen', 232, 'inactive', NULL, NULL, NULL),
(2497, 'Denbighshire', 232, 'inactive', NULL, NULL, NULL),
(2498, 'Ards', 232, 'inactive', NULL, NULL, NULL),
(2499, 'Barnsley', 232, 'inactive', NULL, NULL, NULL),
(2500, 'Herefordshire', 232, 'inactive', NULL, NULL, NULL),
(2501, 'London Borough of Richmond upon Thames', 232, 'inactive', NULL, NULL, NULL),
(2502, 'Saint Helena', 232, 'inactive', NULL, NULL, NULL),
(2503, 'Leeds', 232, 'inactive', NULL, NULL, NULL),
(2504, 'Bolton', 232, 'inactive', NULL, NULL, NULL),
(2505, 'Warwickshire', 232, 'inactive', NULL, NULL, NULL),
(2506, 'City of Stoke-on-Trent', 232, 'inactive', NULL, NULL, NULL),
(2507, 'Bedford', 232, 'inactive', NULL, NULL, NULL),
(2508, 'Dungannon and South Tyrone Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2509, 'Ceredigion', 232, 'inactive', NULL, NULL, NULL),
(2510, 'Worcestershire', 232, 'inactive', NULL, NULL, NULL),
(2511, 'Dundee', 232, 'inactive', NULL, NULL, NULL),
(2512, 'London Borough of Croydon', 232, 'inactive', NULL, NULL, NULL),
(2513, 'North Down Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2514, 'City of Plymouth', 232, 'inactive', NULL, NULL, NULL),
(2515, 'Larne Borough Council', 232, 'inactive', NULL, NULL, NULL),
(2516, 'Leicestershire', 232, 'inactive', NULL, NULL, NULL);
INSERT INTO `states` (`id`, `name`, `country_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2517, 'Calderdale', 232, 'inactive', NULL, NULL, NULL),
(2518, 'Sefton', 232, 'inactive', NULL, NULL, NULL),
(2519, 'Midlothian', 232, 'inactive', NULL, NULL, NULL),
(2520, 'London Borough of Barnet', 232, 'inactive', NULL, NULL, NULL),
(2521, 'North Tyneside', 232, 'inactive', NULL, NULL, NULL),
(2522, 'North Yorkshire', 232, 'inactive', NULL, NULL, NULL),
(2523, 'Ards and North Down', 232, 'inactive', NULL, NULL, NULL),
(2524, 'Newport', 232, 'inactive', NULL, NULL, NULL),
(2525, 'Castlereagh', 232, 'inactive', NULL, NULL, NULL),
(2526, 'Surrey', 232, 'inactive', NULL, NULL, NULL),
(2527, 'Redcar and Cleveland', 232, 'inactive', NULL, NULL, NULL),
(2528, 'City and County of Cardiff', 232, 'inactive', NULL, NULL, NULL),
(2529, 'Bradford', 232, 'inactive', NULL, NULL, NULL),
(2530, 'Blaenau Gwent County Borough', 232, 'inactive', NULL, NULL, NULL),
(2531, 'Fermanagh District Council', 232, 'inactive', NULL, NULL, NULL),
(2532, 'London Borough of Ealing', 232, 'inactive', NULL, NULL, NULL),
(2533, 'Antrim', 232, 'inactive', NULL, NULL, NULL),
(2534, 'Newry, Mourne and Down', 232, 'inactive', NULL, NULL, NULL),
(2535, 'North Ayrshire', 232, 'inactive', NULL, NULL, NULL),
(2536, 'Tashkent', 236, 'inactive', NULL, NULL, NULL),
(2537, 'Namangan Region', 236, 'inactive', NULL, NULL, NULL),
(2538, 'Fergana Region', 236, 'inactive', NULL, NULL, NULL),
(2539, 'Xorazm Region', 236, 'inactive', NULL, NULL, NULL),
(2540, 'Andijan Region', 236, 'inactive', NULL, NULL, NULL),
(2541, 'Bukhara Region', 236, 'inactive', NULL, NULL, NULL),
(2542, 'Navoiy Region', 236, 'inactive', NULL, NULL, NULL),
(2543, 'Qashqadaryo Region', 236, 'inactive', NULL, NULL, NULL),
(2544, 'Samarqand Region', 236, 'inactive', NULL, NULL, NULL),
(2545, 'Jizzakh Region', 236, 'inactive', NULL, NULL, NULL),
(2546, 'Surxondaryo Region', 236, 'inactive', NULL, NULL, NULL),
(2547, 'Sirdaryo Region', 236, 'inactive', NULL, NULL, NULL),
(2548, 'Karakalpakstan', 236, 'inactive', NULL, NULL, NULL),
(2549, 'Tashkent Region', 236, 'inactive', NULL, NULL, NULL),
(2550, 'Ariana Governorate', 224, 'inactive', NULL, NULL, NULL),
(2551, 'Bizerte Governorate', 224, 'inactive', NULL, NULL, NULL),
(2552, 'Jendouba Governorate', 224, 'inactive', NULL, NULL, NULL),
(2553, 'Monastir Governorate', 224, 'inactive', NULL, NULL, NULL),
(2554, 'Tunis Governorate', 224, 'inactive', NULL, NULL, NULL),
(2555, 'Manouba Governorate', 224, 'inactive', NULL, NULL, NULL),
(2556, 'Gafsa Governorate', 224, 'inactive', NULL, NULL, NULL),
(2557, 'Sfax Governorate', 224, 'inactive', NULL, NULL, NULL),
(2558, 'Gabès Governorate', 224, 'inactive', NULL, NULL, NULL),
(2559, 'Tataouine Governorate', 224, 'inactive', NULL, NULL, NULL),
(2560, 'Medenine Governorate', 224, 'inactive', NULL, NULL, NULL),
(2561, 'Kef Governorate', 224, 'inactive', NULL, NULL, NULL),
(2562, 'Kebili Governorate', 224, 'inactive', NULL, NULL, NULL),
(2563, 'Siliana Governorate', 224, 'inactive', NULL, NULL, NULL),
(2564, 'Kairouan Governorate', 224, 'inactive', NULL, NULL, NULL),
(2565, 'Zaghouan Governorate', 224, 'inactive', NULL, NULL, NULL),
(2566, 'Ben Arous Governorate', 224, 'inactive', NULL, NULL, NULL),
(2567, 'Sidi Bouzid Governorate', 224, 'inactive', NULL, NULL, NULL),
(2568, 'Mahdia Governorate', 224, 'inactive', NULL, NULL, NULL),
(2569, 'Tozeur Governorate', 224, 'inactive', NULL, NULL, NULL),
(2570, 'Kasserine Governorate', 224, 'inactive', NULL, NULL, NULL),
(2571, 'Sousse Governorate', 224, 'inactive', NULL, NULL, NULL),
(2572, 'Kassrine', 224, 'inactive', NULL, NULL, NULL),
(2573, 'Ratak Chain', 137, 'inactive', NULL, NULL, NULL),
(2574, 'Ralik Chain', 137, 'inactive', NULL, NULL, NULL),
(2575, 'Centrale Region', 220, 'inactive', NULL, NULL, NULL),
(2576, 'Maritime', 220, 'inactive', NULL, NULL, NULL),
(2577, 'Plateaux Region', 220, 'inactive', NULL, NULL, NULL),
(2578, 'Savanes Region', 220, 'inactive', NULL, NULL, NULL),
(2579, 'Kara Region', 220, 'inactive', NULL, NULL, NULL),
(2580, 'Chuuk State', 143, 'inactive', NULL, NULL, NULL),
(2581, 'Pohnpei State', 143, 'inactive', NULL, NULL, NULL),
(2582, 'Yap State', 143, 'inactive', NULL, NULL, NULL),
(2583, 'Kosrae State', 143, 'inactive', NULL, NULL, NULL),
(2584, 'Vaavu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2585, 'Shaviyani Atoll', 133, 'inactive', NULL, NULL, NULL),
(2586, 'Haa Alif Atoll', 133, 'inactive', NULL, NULL, NULL),
(2587, 'Alif Alif Atoll', 133, 'inactive', NULL, NULL, NULL),
(2588, 'North Province', 133, 'inactive', NULL, NULL, NULL),
(2589, 'North Central Province', 133, 'inactive', NULL, NULL, NULL),
(2590, 'Dhaalu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2591, 'Thaa Atoll', 133, 'inactive', NULL, NULL, NULL),
(2592, 'Noonu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2593, 'Upper South Province', 133, 'inactive', NULL, NULL, NULL),
(2594, 'Addu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2595, 'Gnaviyani Atoll', 133, 'inactive', NULL, NULL, NULL),
(2596, 'Kaafu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2597, 'Haa Dhaalu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2598, 'Gaafu Alif Atoll', 133, 'inactive', NULL, NULL, NULL),
(2599, 'Faafu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2600, 'Alif Dhaal Atoll', 133, 'inactive', NULL, NULL, NULL),
(2601, 'Laamu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2602, 'Raa Atoll', 133, 'inactive', NULL, NULL, NULL),
(2603, 'Gaafu Dhaalu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2604, 'Central Province', 133, 'inactive', NULL, NULL, NULL),
(2605, 'South Province', 133, 'inactive', NULL, NULL, NULL),
(2606, 'South Central Province', 133, 'inactive', NULL, NULL, NULL),
(2607, 'Lhaviyani Atoll', 133, 'inactive', NULL, NULL, NULL),
(2608, 'Meemu Atoll', 133, 'inactive', NULL, NULL, NULL),
(2609, 'Malé', 133, 'inactive', NULL, NULL, NULL),
(2610, 'Utrecht', 156, 'inactive', NULL, NULL, NULL),
(2611, 'Gelderland', 156, 'inactive', NULL, NULL, NULL),
(2612, 'North Holland', 156, 'inactive', NULL, NULL, NULL),
(2613, 'Drenthe', 156, 'inactive', NULL, NULL, NULL),
(2614, 'South Holland', 156, 'inactive', NULL, NULL, NULL),
(2615, 'Limburg', 156, 'inactive', NULL, NULL, NULL),
(2616, 'Sint Eustatius', 156, 'inactive', NULL, NULL, NULL),
(2617, 'Groningen', 156, 'inactive', NULL, NULL, NULL),
(2618, 'Overijssel', 156, 'inactive', NULL, NULL, NULL),
(2619, 'Flevoland', 156, 'inactive', NULL, NULL, NULL),
(2620, 'Zeeland', 156, 'inactive', NULL, NULL, NULL),
(2621, 'Saba', 156, 'inactive', NULL, NULL, NULL),
(2622, 'Friesland', 156, 'inactive', NULL, NULL, NULL),
(2623, 'North Brabant', 156, 'inactive', NULL, NULL, NULL),
(2624, 'Bonaire', 156, 'inactive', NULL, NULL, NULL),
(2625, 'Savanes Region', 54, 'inactive', NULL, NULL, NULL),
(2626, 'Agnéby', 54, 'inactive', NULL, NULL, NULL),
(2627, 'Lagunes District', 54, 'inactive', NULL, NULL, NULL),
(2628, 'Sud-Bandama', 54, 'inactive', NULL, NULL, NULL),
(2629, 'Montagnes District', 54, 'inactive', NULL, NULL, NULL),
(2630, 'Moyen-Comoé', 54, 'inactive', NULL, NULL, NULL),
(2631, 'Marahoué Region', 54, 'inactive', NULL, NULL, NULL),
(2632, 'Lacs District', 54, 'inactive', NULL, NULL, NULL),
(2633, 'Fromager', 54, 'inactive', NULL, NULL, NULL),
(2634, 'Abidjan', 54, 'inactive', NULL, NULL, NULL),
(2635, 'Bas-Sassandra Region', 54, 'inactive', NULL, NULL, NULL),
(2636, 'Bafing Region', 54, 'inactive', NULL, NULL, NULL),
(2637, 'Vallée du Bandama District', 54, 'inactive', NULL, NULL, NULL),
(2638, 'Haut-Sassandra', 54, 'inactive', NULL, NULL, NULL),
(2639, 'Lagunes region', 54, 'inactive', NULL, NULL, NULL),
(2640, 'Lacs Region', 54, 'inactive', NULL, NULL, NULL),
(2641, 'Zanzan Region', 54, 'inactive', NULL, NULL, NULL),
(2642, 'Denguélé Region', 54, 'inactive', NULL, NULL, NULL),
(2643, 'Bas-Sassandra District', 54, 'inactive', NULL, NULL, NULL),
(2644, 'Denguélé District', 54, 'inactive', NULL, NULL, NULL),
(2645, 'Dix-Huit Montagnes', 54, 'inactive', NULL, NULL, NULL),
(2646, 'Moyen-Cavally', 54, 'inactive', NULL, NULL, NULL),
(2647, 'Vallée du Bandama Region', 54, 'inactive', NULL, NULL, NULL),
(2648, 'Sassandra-Marahoué District', 54, 'inactive', NULL, NULL, NULL),
(2649, 'Worodougou', 54, 'inactive', NULL, NULL, NULL),
(2650, 'Woroba District', 54, 'inactive', NULL, NULL, NULL),
(2651, 'Gôh-Djiboua District', 54, 'inactive', NULL, NULL, NULL),
(2652, 'Sud-Comoé', 54, 'inactive', NULL, NULL, NULL),
(2653, 'Yamoussoukro', 54, 'inactive', NULL, NULL, NULL),
(2654, 'Comoé District', 54, 'inactive', NULL, NULL, NULL),
(2655, 'N\'zi-Comoé', 54, 'inactive', NULL, NULL, NULL),
(2656, 'Far North', 38, 'inactive', NULL, NULL, NULL),
(2657, 'Northwest', 38, 'inactive', NULL, NULL, NULL),
(2658, 'Southwest', 38, 'inactive', NULL, NULL, NULL),
(2659, 'South', 38, 'inactive', NULL, NULL, NULL),
(2660, 'Centre', 38, 'inactive', NULL, NULL, NULL),
(2661, 'East', 38, 'inactive', NULL, NULL, NULL),
(2662, 'Littoral', 38, 'inactive', NULL, NULL, NULL),
(2663, 'Adamawa', 38, 'inactive', NULL, NULL, NULL),
(2664, 'West', 38, 'inactive', NULL, NULL, NULL),
(2665, 'North', 38, 'inactive', NULL, NULL, NULL),
(2666, 'Banjul', 80, 'inactive', NULL, NULL, NULL),
(2667, 'West Coast Division', 80, 'inactive', NULL, NULL, NULL),
(2668, 'Upper River Division', 80, 'inactive', NULL, NULL, NULL),
(2669, 'Central River Division', 80, 'inactive', NULL, NULL, NULL),
(2670, 'Lower River Division', 80, 'inactive', NULL, NULL, NULL),
(2671, 'North Bank Division', 80, 'inactive', NULL, NULL, NULL),
(2672, 'Beyla Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2673, 'Mandiana Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2674, 'Yomou Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2675, 'Fria Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2676, 'Boké Region', 92, 'inactive', NULL, NULL, NULL),
(2677, 'Labé Region', 92, 'inactive', NULL, NULL, NULL),
(2678, 'Nzérékoré Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2679, 'Dabola Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2680, 'Labé Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2681, 'Dubréka Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2682, 'Faranah Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2683, 'Forécariah Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2684, 'Nzérékoré Region', 92, 'inactive', NULL, NULL, NULL),
(2685, 'Gaoual Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2686, 'Conakry', 92, 'inactive', NULL, NULL, NULL),
(2687, 'Télimélé Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2688, 'Dinguiraye Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2689, 'Mamou Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2690, 'Lélouma Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2691, 'Kissidougou Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2692, 'Koubia Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2693, 'Kindia Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2694, 'Pita Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2695, 'Kouroussa Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2696, 'Tougué Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2697, 'Kankan Region', 92, 'inactive', NULL, NULL, NULL),
(2698, 'Mamou Region', 92, 'inactive', NULL, NULL, NULL),
(2699, 'Boffa Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2700, 'Mali Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2701, 'Kindia Region', 92, 'inactive', NULL, NULL, NULL),
(2702, 'Macenta Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2703, 'Koundara Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2704, 'Kankan Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2705, 'Coyah Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2706, 'Dalaba Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2707, 'Siguiri Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2708, 'Lola Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2709, 'Boké Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2710, 'Kérouané Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2711, 'Guéckédou Prefecture', 92, 'inactive', NULL, NULL, NULL),
(2712, 'Tombali Region', 93, 'inactive', NULL, NULL, NULL),
(2713, 'Cacheu Region', 93, 'inactive', NULL, NULL, NULL),
(2714, 'Biombo Region', 93, 'inactive', NULL, NULL, NULL),
(2715, 'Quinara Region', 93, 'inactive', NULL, NULL, NULL),
(2716, 'Sul Province', 93, 'inactive', NULL, NULL, NULL),
(2717, 'Norte Province', 93, 'inactive', NULL, NULL, NULL),
(2718, 'Oio Region', 93, 'inactive', NULL, NULL, NULL),
(2719, 'Gabú Region', 93, 'inactive', NULL, NULL, NULL),
(2720, 'Bafatá', 93, 'inactive', NULL, NULL, NULL),
(2721, 'Leste Province', 93, 'inactive', NULL, NULL, NULL),
(2722, 'Bolama Region', 93, 'inactive', NULL, NULL, NULL),
(2723, 'Woleu-Ntem Province', 79, 'inactive', NULL, NULL, NULL),
(2724, 'Ogooué-Ivindo Province', 79, 'inactive', NULL, NULL, NULL),
(2725, 'Nyanga Province', 79, 'inactive', NULL, NULL, NULL),
(2726, 'Haut-Ogooué Province', 79, 'inactive', NULL, NULL, NULL),
(2727, 'Estuaire Province', 79, 'inactive', NULL, NULL, NULL),
(2728, 'Ogooué-Maritime Province', 79, 'inactive', NULL, NULL, NULL),
(2729, 'Ogooué-Lolo Province', 79, 'inactive', NULL, NULL, NULL),
(2730, 'Moyen-Ogooué Province', 79, 'inactive', NULL, NULL, NULL),
(2731, 'Ngounié Province', 79, 'inactive', NULL, NULL, NULL),
(2732, 'Tshuapa District', 51, 'inactive', NULL, NULL, NULL),
(2733, 'Tanganyika Province', 51, 'inactive', NULL, NULL, NULL),
(2734, 'Haut-Uele', 51, 'inactive', NULL, NULL, NULL),
(2735, 'Kasaï-Oriental', 51, 'inactive', NULL, NULL, NULL),
(2736, 'Orientale Province', 51, 'inactive', NULL, NULL, NULL),
(2737, 'Kasaï-Occidental', 51, 'inactive', NULL, NULL, NULL),
(2738, 'South Kivu', 51, 'inactive', NULL, NULL, NULL),
(2739, 'Nord-Ubangi District', 51, 'inactive', NULL, NULL, NULL),
(2740, 'Kwango District', 51, 'inactive', NULL, NULL, NULL),
(2741, 'Kinshasa', 51, 'inactive', NULL, NULL, NULL),
(2742, 'Katanga Province', 51, 'inactive', NULL, NULL, NULL),
(2743, 'Sankuru District', 51, 'inactive', NULL, NULL, NULL),
(2744, 'Équateur', 51, 'inactive', NULL, NULL, NULL),
(2745, 'Maniema', 51, 'inactive', NULL, NULL, NULL),
(2746, 'Bas-Congo province', 51, 'inactive', NULL, NULL, NULL),
(2747, 'Lomami Province', 51, 'inactive', NULL, NULL, NULL),
(2748, 'Sud-Ubangi', 51, 'inactive', NULL, NULL, NULL),
(2749, 'North Kivu', 51, 'inactive', NULL, NULL, NULL),
(2750, 'Haut-Katanga Province', 51, 'inactive', NULL, NULL, NULL),
(2751, 'Ituri Interim Administration', 51, 'inactive', NULL, NULL, NULL),
(2752, 'Mongala District', 51, 'inactive', NULL, NULL, NULL),
(2753, 'Bas-Uele', 51, 'inactive', NULL, NULL, NULL),
(2754, 'Bandundu Province', 51, 'inactive', NULL, NULL, NULL),
(2755, 'Mai-Ndombe Province', 51, 'inactive', NULL, NULL, NULL),
(2756, 'Tshopo District', 51, 'inactive', NULL, NULL, NULL),
(2757, 'Kasaï District', 51, 'inactive', NULL, NULL, NULL),
(2758, 'Haut-Lomami District', 51, 'inactive', NULL, NULL, NULL),
(2759, 'Kwilu District', 51, 'inactive', NULL, NULL, NULL),
(2760, 'Cuyuni-Mazaruni', 94, 'inactive', NULL, NULL, NULL),
(2761, 'Potaro-Siparuni', 94, 'inactive', NULL, NULL, NULL),
(2762, 'Mahaica-Berbice', 94, 'inactive', NULL, NULL, NULL),
(2763, 'Upper Demerara-Berbice', 94, 'inactive', NULL, NULL, NULL),
(2764, 'Barima-Waini', 94, 'inactive', NULL, NULL, NULL),
(2765, 'Pomeroon-Supenaam', 94, 'inactive', NULL, NULL, NULL),
(2766, 'East Berbice-Corentyne', 94, 'inactive', NULL, NULL, NULL),
(2767, 'Demerara-Mahaica', 94, 'inactive', NULL, NULL, NULL),
(2768, 'Essequibo Islands-West Demerara', 94, 'inactive', NULL, NULL, NULL),
(2769, 'Upper Takutu-Upper Essequibo', 94, 'inactive', NULL, NULL, NULL),
(2770, 'Presidente Hayes Department', 172, 'inactive', NULL, NULL, NULL),
(2771, 'Canindeyú', 172, 'inactive', NULL, NULL, NULL),
(2772, 'Guairá Department', 172, 'inactive', NULL, NULL, NULL),
(2773, 'Caaguazú', 172, 'inactive', NULL, NULL, NULL),
(2774, 'Paraguarí Department', 172, 'inactive', NULL, NULL, NULL),
(2775, 'Caazapá', 172, 'inactive', NULL, NULL, NULL),
(2776, 'San Pedro Department', 172, 'inactive', NULL, NULL, NULL),
(2777, 'Central Department', 172, 'inactive', NULL, NULL, NULL),
(2778, 'Itapúa', 172, 'inactive', NULL, NULL, NULL),
(2779, 'Concepción Department', 172, 'inactive', NULL, NULL, NULL),
(2780, 'Boquerón Department', 172, 'inactive', NULL, NULL, NULL),
(2781, 'Ñeembucú Department', 172, 'inactive', NULL, NULL, NULL),
(2782, 'Amambay Department', 172, 'inactive', NULL, NULL, NULL),
(2783, 'Cordillera Department', 172, 'inactive', NULL, NULL, NULL),
(2784, 'Alto Paraná Department', 172, 'inactive', NULL, NULL, NULL),
(2785, 'Alto Paraguay Department', 172, 'inactive', NULL, NULL, NULL),
(2786, 'Misiones Department', 172, 'inactive', NULL, NULL, NULL),
(2787, 'Jaffna District', 208, 'inactive', NULL, NULL, NULL),
(2788, 'Kandy District', 208, 'inactive', NULL, NULL, NULL),
(2789, 'Kalutara District', 208, 'inactive', NULL, NULL, NULL),
(2790, 'Badulla District', 208, 'inactive', NULL, NULL, NULL),
(2791, 'Hambantota District', 208, 'inactive', NULL, NULL, NULL),
(2792, 'Galle District', 208, 'inactive', NULL, NULL, NULL),
(2793, 'Kilinochchi District', 208, 'inactive', NULL, NULL, NULL),
(2794, 'Nuwara Eliya District', 208, 'inactive', NULL, NULL, NULL),
(2795, 'Trincomalee District', 208, 'inactive', NULL, NULL, NULL),
(2796, 'Puttalam District', 208, 'inactive', NULL, NULL, NULL),
(2797, 'Kegalle District', 208, 'inactive', NULL, NULL, NULL),
(2798, 'Central Province', 208, 'inactive', NULL, NULL, NULL),
(2799, 'Ampara District', 208, 'inactive', NULL, NULL, NULL),
(2800, 'North Central Province', 208, 'inactive', NULL, NULL, NULL),
(2801, 'Southern Province', 208, 'inactive', NULL, NULL, NULL),
(2802, 'Western Province', 208, 'inactive', NULL, NULL, NULL),
(2803, 'Sabaragamuwa Province', 208, 'inactive', NULL, NULL, NULL),
(2804, 'Gampaha District', 208, 'inactive', NULL, NULL, NULL),
(2805, 'Mannar District', 208, 'inactive', NULL, NULL, NULL),
(2806, 'Matara District', 208, 'inactive', NULL, NULL, NULL),
(2807, 'Ratnapura district', 208, 'inactive', NULL, NULL, NULL),
(2808, 'Eastern Province', 208, 'inactive', NULL, NULL, NULL),
(2809, 'Vavuniya District', 208, 'inactive', NULL, NULL, NULL),
(2810, 'Matale District', 208, 'inactive', NULL, NULL, NULL),
(2811, 'Uva Province', 208, 'inactive', NULL, NULL, NULL),
(2812, 'Polonnaruwa District', 208, 'inactive', NULL, NULL, NULL),
(2813, 'Northern Province', 208, 'inactive', NULL, NULL, NULL),
(2814, 'Mullaitivu District', 208, 'inactive', NULL, NULL, NULL),
(2815, 'Colombo District', 208, 'inactive', NULL, NULL, NULL),
(2816, 'Anuradhapura District', 208, 'inactive', NULL, NULL, NULL),
(2817, 'North Western Province', 208, 'inactive', NULL, NULL, NULL),
(2818, 'Batticaloa District', 208, 'inactive', NULL, NULL, NULL),
(2819, 'Monaragala District', 208, 'inactive', NULL, NULL, NULL),
(2820, 'Mohéli', 49, 'inactive', NULL, NULL, NULL),
(2821, 'Anjouan', 49, 'inactive', NULL, NULL, NULL),
(2822, 'Grande Comore', 49, 'inactive', NULL, NULL, NULL),
(2823, 'Atacama Region', 44, 'inactive', NULL, NULL, NULL),
(2824, 'Santiago Metropolitan Region', 44, 'inactive', NULL, NULL, NULL),
(2825, 'Coquimbo Region', 44, 'inactive', NULL, NULL, NULL),
(2826, 'Araucanía Region', 44, 'inactive', NULL, NULL, NULL),
(2827, 'Bío Bío Region', 44, 'inactive', NULL, NULL, NULL),
(2828, 'Aysén Region', 44, 'inactive', NULL, NULL, NULL),
(2829, 'Arica y Parinacota Region', 44, 'inactive', NULL, NULL, NULL),
(2830, 'Valparaíso', 44, 'inactive', NULL, NULL, NULL),
(2831, 'Ñuble Region', 44, 'inactive', NULL, NULL, NULL),
(2832, 'Antofagasta Region', 44, 'inactive', NULL, NULL, NULL),
(2833, 'Maule Region', 44, 'inactive', NULL, NULL, NULL),
(2834, 'Los Ríos Region', 44, 'inactive', NULL, NULL, NULL),
(2835, 'Los Lagos Region', 44, 'inactive', NULL, NULL, NULL),
(2836, 'Magellan and the Chilean Antarctic Region', 44, 'inactive', NULL, NULL, NULL),
(2837, 'Tarapacá Region', 44, 'inactive', NULL, NULL, NULL),
(2838, 'O\'Higgins', 44, 'inactive', NULL, NULL, NULL),
(2839, 'Commewijne District', 210, 'inactive', NULL, NULL, NULL),
(2840, 'Nickerie District', 210, 'inactive', NULL, NULL, NULL),
(2841, 'Para District', 210, 'inactive', NULL, NULL, NULL),
(2842, 'Coronie District', 210, 'inactive', NULL, NULL, NULL),
(2843, 'Paramaribo District', 210, 'inactive', NULL, NULL, NULL),
(2844, 'Wanica District', 210, 'inactive', NULL, NULL, NULL),
(2845, 'Marowijne District', 210, 'inactive', NULL, NULL, NULL),
(2846, 'Brokopondo District', 210, 'inactive', NULL, NULL, NULL),
(2847, 'Sipaliwini District', 210, 'inactive', NULL, NULL, NULL),
(2848, 'Saramacca District', 210, 'inactive', NULL, NULL, NULL),
(2849, 'Riyadh Region', 194, 'inactive', NULL, NULL, NULL),
(2850, 'Makkah Region', 194, 'inactive', NULL, NULL, NULL),
(2851, 'Al Madinah Region', 194, 'inactive', NULL, NULL, NULL),
(2852, 'Tabuk Region', 194, 'inactive', NULL, NULL, NULL),
(2853, '\'Asir Region', 194, 'inactive', NULL, NULL, NULL),
(2854, 'Northern Borders Region', 194, 'inactive', NULL, NULL, NULL),
(2855, 'Ha\'il Region', 194, 'inactive', NULL, NULL, NULL),
(2856, 'Eastern Province', 194, 'inactive', NULL, NULL, NULL),
(2857, 'Al Jawf Region', 194, 'inactive', NULL, NULL, NULL),
(2858, 'Jizan Region', 194, 'inactive', NULL, NULL, NULL),
(2859, 'Al Bahah Region', 194, 'inactive', NULL, NULL, NULL),
(2860, 'Najran Region', 194, 'inactive', NULL, NULL, NULL),
(2861, 'Al-Qassim Region', 194, 'inactive', NULL, NULL, NULL),
(2862, 'Plateaux Department', 50, 'inactive', NULL, NULL, NULL),
(2863, 'Pointe-Noire', 50, 'inactive', NULL, NULL, NULL),
(2864, 'Cuvette Department', 50, 'inactive', NULL, NULL, NULL),
(2865, 'Likouala Department', 50, 'inactive', NULL, NULL, NULL),
(2866, 'Bouenza Department', 50, 'inactive', NULL, NULL, NULL),
(2867, 'Kouilou Department', 50, 'inactive', NULL, NULL, NULL),
(2868, 'Lékoumou Department', 50, 'inactive', NULL, NULL, NULL),
(2869, 'Cuvette-Ouest Department', 50, 'inactive', NULL, NULL, NULL),
(2870, 'Brazzaville', 50, 'inactive', NULL, NULL, NULL),
(2871, 'Sangha Department', 50, 'inactive', NULL, NULL, NULL),
(2872, 'Niari Department', 50, 'inactive', NULL, NULL, NULL),
(2873, 'Pool Department', 50, 'inactive', NULL, NULL, NULL),
(2874, 'Quindío Department', 48, 'inactive', NULL, NULL, NULL),
(2875, 'Cundinamarca Department', 48, 'inactive', NULL, NULL, NULL),
(2876, 'Chocó Department', 48, 'inactive', NULL, NULL, NULL),
(2877, 'Norte de Santander Department', 48, 'inactive', NULL, NULL, NULL),
(2878, 'Meta', 48, 'inactive', NULL, NULL, NULL),
(2879, 'Risaralda Department', 48, 'inactive', NULL, NULL, NULL),
(2880, 'Atlántico Department', 48, 'inactive', NULL, NULL, NULL),
(2881, 'Arauca Department', 48, 'inactive', NULL, NULL, NULL),
(2882, 'Guainía Department', 48, 'inactive', NULL, NULL, NULL),
(2883, 'Tolima Department', 48, 'inactive', NULL, NULL, NULL),
(2884, 'Cauca Department', 48, 'inactive', NULL, NULL, NULL),
(2885, 'Vaupés Department', 48, 'inactive', NULL, NULL, NULL),
(2886, 'Magdalena Department', 48, 'inactive', NULL, NULL, NULL),
(2887, 'Caldas Department', 48, 'inactive', NULL, NULL, NULL),
(2888, 'Guaviare Department', 48, 'inactive', NULL, NULL, NULL),
(2889, 'La Guajira Department', 48, 'inactive', NULL, NULL, NULL),
(2890, 'Antioquia Department', 48, 'inactive', NULL, NULL, NULL),
(2891, 'Caquetá Department', 48, 'inactive', NULL, NULL, NULL),
(2892, 'Casanare Department', 48, 'inactive', NULL, NULL, NULL),
(2893, 'Bolívar Department', 48, 'inactive', NULL, NULL, NULL),
(2894, 'Vichada Department', 48, 'inactive', NULL, NULL, NULL),
(2895, 'Amazonas Department', 48, 'inactive', NULL, NULL, NULL),
(2896, 'Putumayo Department', 48, 'inactive', NULL, NULL, NULL),
(2897, 'Nariño Department', 48, 'inactive', NULL, NULL, NULL),
(2898, 'Córdoba Department', 48, 'inactive', NULL, NULL, NULL),
(2899, 'Cesar Department', 48, 'inactive', NULL, NULL, NULL),
(2900, 'Archipelago of Saint Andréws, Providence and Saint Catalina', 48, 'inactive', NULL, NULL, NULL),
(2901, 'Santander Department', 48, 'inactive', NULL, NULL, NULL),
(2902, 'Sucre Department', 48, 'inactive', NULL, NULL, NULL),
(2903, 'Boyacá Department', 48, 'inactive', NULL, NULL, NULL),
(2904, 'Valle del Cauca Department', 48, 'inactive', NULL, NULL, NULL),
(2905, 'Galápagos Province', 64, 'inactive', NULL, NULL, NULL),
(2906, 'Sucumbíos Province', 64, 'inactive', NULL, NULL, NULL),
(2907, 'Pastaza Province', 64, 'inactive', NULL, NULL, NULL),
(2908, 'Tungurahua Province', 64, 'inactive', NULL, NULL, NULL),
(2909, 'Zamora-Chinchipe Province', 64, 'inactive', NULL, NULL, NULL),
(2910, 'Los Ríos Province', 64, 'inactive', NULL, NULL, NULL),
(2911, 'Imbabura Province', 64, 'inactive', NULL, NULL, NULL),
(2912, 'Santa Elena Province', 64, 'inactive', NULL, NULL, NULL),
(2913, 'Manabí Province', 64, 'inactive', NULL, NULL, NULL),
(2914, 'Guayas Province', 64, 'inactive', NULL, NULL, NULL),
(2915, 'Carchi Province', 64, 'inactive', NULL, NULL, NULL),
(2916, 'Napo Province', 64, 'inactive', NULL, NULL, NULL),
(2917, 'Cañar Province', 64, 'inactive', NULL, NULL, NULL),
(2918, 'Morona-Santiago Province', 64, 'inactive', NULL, NULL, NULL),
(2919, 'Santo Domingo de los Tsáchilas Province', 64, 'inactive', NULL, NULL, NULL),
(2920, 'Bolívar Province', 64, 'inactive', NULL, NULL, NULL),
(2921, 'Cotopaxi Province', 64, 'inactive', NULL, NULL, NULL),
(2922, 'Esmeraldas', 64, 'inactive', NULL, NULL, NULL),
(2923, 'Azuay Province', 64, 'inactive', NULL, NULL, NULL),
(2924, 'El Oro Province', 64, 'inactive', NULL, NULL, NULL),
(2925, 'Chimborazo Province', 64, 'inactive', NULL, NULL, NULL),
(2926, 'Orellana Province', 64, 'inactive', NULL, NULL, NULL),
(2927, 'Pichincha Province', 64, 'inactive', NULL, NULL, NULL),
(2928, 'Obock Region', 60, 'inactive', NULL, NULL, NULL),
(2929, 'Djibouti', 60, 'inactive', NULL, NULL, NULL),
(2930, 'Dikhil Region', 60, 'inactive', NULL, NULL, NULL),
(2931, 'Tadjourah Region', 60, 'inactive', NULL, NULL, NULL),
(2932, 'Arta Region', 60, 'inactive', NULL, NULL, NULL),
(2933, 'Ali Sabieh Region', 60, 'inactive', NULL, NULL, NULL),
(2934, 'Hama Governorate', 215, 'inactive', NULL, NULL, NULL),
(2935, 'Rif Dimashq Governorate', 215, 'inactive', NULL, NULL, NULL),
(2936, 'As-Suwayda Governorate', 215, 'inactive', NULL, NULL, NULL),
(2937, 'Deir ez-Zor Governorate', 215, 'inactive', NULL, NULL, NULL),
(2938, 'Latakia Governorate', 215, 'inactive', NULL, NULL, NULL),
(2939, 'Damascus Governorate', 215, 'inactive', NULL, NULL, NULL),
(2940, 'Idlib Governorate', 215, 'inactive', NULL, NULL, NULL),
(2941, 'Al-Hasakah Governorate', 215, 'inactive', NULL, NULL, NULL),
(2942, 'Homs Governorate', 215, 'inactive', NULL, NULL, NULL),
(2943, 'Quneitra Governorate', 215, 'inactive', NULL, NULL, NULL),
(2944, 'Al-Raqqah Governorate', 215, 'inactive', NULL, NULL, NULL),
(2945, 'Daraa Governorate', 215, 'inactive', NULL, NULL, NULL),
(2946, 'Aleppo Governorate', 215, 'inactive', NULL, NULL, NULL),
(2947, 'Tartus Governorate', 215, 'inactive', NULL, NULL, NULL),
(2948, 'Fianarantsoa Province', 130, 'inactive', NULL, NULL, NULL),
(2949, 'Toliara Province', 130, 'inactive', NULL, NULL, NULL),
(2950, 'Antsiranana Province', 130, 'inactive', NULL, NULL, NULL),
(2951, 'Antananarivo Province', 130, 'inactive', NULL, NULL, NULL),
(2952, 'Toamasina Province', 130, 'inactive', NULL, NULL, NULL),
(2953, 'Mahajanga Province', 130, 'inactive', NULL, NULL, NULL),
(2954, 'Mogilev Region', 21, 'inactive', NULL, NULL, NULL),
(2955, 'Gomel Region', 21, 'inactive', NULL, NULL, NULL),
(2956, 'Grodno Region', 21, 'inactive', NULL, NULL, NULL),
(2957, 'Minsk Region', 21, 'inactive', NULL, NULL, NULL),
(2958, 'Minsk', 21, 'inactive', NULL, NULL, NULL),
(2959, 'Brest Region', 21, 'inactive', NULL, NULL, NULL),
(2960, 'Vitebsk Region', 21, 'inactive', NULL, NULL, NULL),
(2961, 'Murqub', 124, 'inactive', NULL, NULL, NULL),
(2962, 'Nuqat al Khams', 124, 'inactive', NULL, NULL, NULL),
(2963, 'Zawiya District', 124, 'inactive', NULL, NULL, NULL),
(2964, 'Al Wahat District', 124, 'inactive', NULL, NULL, NULL),
(2965, 'Sabha District', 124, 'inactive', NULL, NULL, NULL),
(2966, 'Derna District', 124, 'inactive', NULL, NULL, NULL),
(2967, 'Murzuq District', 124, 'inactive', NULL, NULL, NULL),
(2968, 'Marj District', 124, 'inactive', NULL, NULL, NULL),
(2969, 'Ghat District', 124, 'inactive', NULL, NULL, NULL),
(2970, 'Jufra', 124, 'inactive', NULL, NULL, NULL),
(2971, 'Tripoli District', 124, 'inactive', NULL, NULL, NULL),
(2972, 'Kufra District', 124, 'inactive', NULL, NULL, NULL),
(2973, 'Wadi al Hayaa District', 124, 'inactive', NULL, NULL, NULL),
(2974, 'Jabal al Gharbi District', 124, 'inactive', NULL, NULL, NULL),
(2975, 'Wadi al Shatii District', 124, 'inactive', NULL, NULL, NULL),
(2976, 'Nalut District', 124, 'inactive', NULL, NULL, NULL),
(2977, 'Sirte District', 124, 'inactive', NULL, NULL, NULL),
(2978, 'Misrata District', 124, 'inactive', NULL, NULL, NULL),
(2979, 'Jafara', 124, 'inactive', NULL, NULL, NULL),
(2980, 'Jabal al Akhdar', 124, 'inactive', NULL, NULL, NULL),
(2981, 'Benghazi', 124, 'inactive', NULL, NULL, NULL),
(2982, 'Ribeira Brava Municipality', 40, 'inactive', NULL, NULL, NULL),
(2983, 'Tarrafal', 40, 'inactive', NULL, NULL, NULL),
(2984, 'Ribeira Grande de Santiago', 40, 'inactive', NULL, NULL, NULL),
(2985, 'Santa Catarina', 40, 'inactive', NULL, NULL, NULL),
(2986, 'São Domingos', 40, 'inactive', NULL, NULL, NULL),
(2987, 'Mosteiros', 40, 'inactive', NULL, NULL, NULL),
(2988, 'Praia', 40, 'inactive', NULL, NULL, NULL),
(2989, 'Porto Novo', 40, 'inactive', NULL, NULL, NULL),
(2990, 'São Miguel', 40, 'inactive', NULL, NULL, NULL),
(2991, 'Maio Municipality', 40, 'inactive', NULL, NULL, NULL),
(2992, 'Sotavento Islands', 40, 'inactive', NULL, NULL, NULL),
(2993, 'São Lourenço dos Órgãos', 40, 'inactive', NULL, NULL, NULL),
(2994, 'Barlavento Islands', 40, 'inactive', NULL, NULL, NULL),
(2995, 'Santa Catarina do Fogo', 40, 'inactive', NULL, NULL, NULL),
(2996, 'Brava', 40, 'inactive', NULL, NULL, NULL),
(2997, 'Paul', 40, 'inactive', NULL, NULL, NULL),
(2998, 'Sal', 40, 'inactive', NULL, NULL, NULL),
(2999, 'Boa Vista', 40, 'inactive', NULL, NULL, NULL),
(3000, 'São Filipe', 40, 'inactive', NULL, NULL, NULL),
(3001, 'São Vicente', 40, 'inactive', NULL, NULL, NULL),
(3002, 'Ribeira Grande', 40, 'inactive', NULL, NULL, NULL),
(3003, 'Tarrafal de São Nicolau', 40, 'inactive', NULL, NULL, NULL),
(3004, 'Santa Cruz', 40, 'inactive', NULL, NULL, NULL),
(3005, 'Schleswig-Holstein', 82, 'inactive', NULL, NULL, NULL),
(3006, 'Baden-Württemberg', 82, 'inactive', NULL, NULL, NULL),
(3007, 'Mecklenburg-Vorpommern', 82, 'inactive', NULL, NULL, NULL),
(3008, 'Lower Saxony', 82, 'inactive', NULL, NULL, NULL),
(3009, 'Bavaria', 82, 'inactive', NULL, NULL, NULL),
(3010, 'Berlin', 82, 'inactive', NULL, NULL, NULL),
(3011, 'Saxony-Anhalt', 82, 'inactive', NULL, NULL, NULL),
(3013, 'Brandenburg', 82, 'inactive', NULL, NULL, NULL),
(3014, 'Bremen', 82, 'inactive', NULL, NULL, NULL),
(3015, 'Thuringia', 82, 'inactive', NULL, NULL, NULL),
(3016, 'Hamburg', 82, 'inactive', NULL, NULL, NULL),
(3017, 'North Rhine-Westphalia', 82, 'inactive', NULL, NULL, NULL),
(3018, 'Hesse', 82, 'inactive', NULL, NULL, NULL),
(3019, 'Rhineland-Palatinate', 82, 'inactive', NULL, NULL, NULL),
(3020, 'Saarland', 82, 'inactive', NULL, NULL, NULL),
(3021, 'Saxony', 82, 'inactive', NULL, NULL, NULL),
(3022, 'Mafeteng District', 122, 'inactive', NULL, NULL, NULL),
(3023, 'Mohale\'s Hoek District', 122, 'inactive', NULL, NULL, NULL),
(3024, 'Mokhotlong District', 122, 'inactive', NULL, NULL, NULL),
(3025, 'Qacha\'s Nek District', 122, 'inactive', NULL, NULL, NULL),
(3026, 'Leribe District', 122, 'inactive', NULL, NULL, NULL),
(3027, 'Quthing District', 122, 'inactive', NULL, NULL, NULL),
(3028, 'Maseru District', 122, 'inactive', NULL, NULL, NULL),
(3029, 'Butha-Buthe District', 122, 'inactive', NULL, NULL, NULL),
(3030, 'Berea District', 122, 'inactive', NULL, NULL, NULL),
(3031, 'Thaba-Tseka District', 122, 'inactive', NULL, NULL, NULL),
(3032, 'Montserrado County', 123, 'inactive', NULL, NULL, NULL),
(3033, 'River Cess County', 123, 'inactive', NULL, NULL, NULL),
(3034, 'Bong County', 123, 'inactive', NULL, NULL, NULL),
(3035, 'Sinoe County', 123, 'inactive', NULL, NULL, NULL),
(3036, 'Grand Cape Mount County', 123, 'inactive', NULL, NULL, NULL),
(3037, 'Lofa County', 123, 'inactive', NULL, NULL, NULL),
(3038, 'River Gee County', 123, 'inactive', NULL, NULL, NULL),
(3039, 'Grand Gedeh County', 123, 'inactive', NULL, NULL, NULL),
(3040, 'Grand Bassa County', 123, 'inactive', NULL, NULL, NULL),
(3041, 'Bomi County', 123, 'inactive', NULL, NULL, NULL),
(3042, 'Maryland County', 123, 'inactive', NULL, NULL, NULL),
(3043, 'Margibi County', 123, 'inactive', NULL, NULL, NULL),
(3044, 'Gbarpolu County', 123, 'inactive', NULL, NULL, NULL),
(3045, 'Grand Kru County', 123, 'inactive', NULL, NULL, NULL),
(3046, 'Nimba', 123, 'inactive', NULL, NULL, NULL),
(3047, 'Ad Dhahirah Governorate', 166, 'inactive', NULL, NULL, NULL),
(3048, 'Al Batinah North Governorate', 166, 'inactive', NULL, NULL, NULL),
(3049, 'Al Batinah South Governorate', 166, 'inactive', NULL, NULL, NULL),
(3050, 'Al Batinah Region', 166, 'inactive', NULL, NULL, NULL),
(3051, 'Ash Sharqiyah Region', 166, 'inactive', NULL, NULL, NULL),
(3052, 'Musandam Governorate', 166, 'inactive', NULL, NULL, NULL),
(3053, 'Ash Sharqiyah North Governorate', 166, 'inactive', NULL, NULL, NULL),
(3054, 'Ash Sharqiyah South Governorate', 166, 'inactive', NULL, NULL, NULL),
(3055, 'Muscat Governorate', 166, 'inactive', NULL, NULL, NULL),
(3056, 'Al Wusta Governorate', 166, 'inactive', NULL, NULL, NULL),
(3057, 'Dhofar Governorate', 166, 'inactive', NULL, NULL, NULL),
(3058, 'Ad Dakhiliyah Governorate', 166, 'inactive', NULL, NULL, NULL),
(3059, 'Al Buraimi Governorate', 166, 'inactive', NULL, NULL, NULL),
(3060, 'Ngamiland', 29, 'inactive', NULL, NULL, NULL),
(3061, 'Ghanzi District', 29, 'inactive', NULL, NULL, NULL),
(3062, 'Kgatleng District', 29, 'inactive', NULL, NULL, NULL),
(3063, 'Southern District', 29, 'inactive', NULL, NULL, NULL),
(3064, 'South-East District', 29, 'inactive', NULL, NULL, NULL),
(3065, 'North-West District', 29, 'inactive', NULL, NULL, NULL),
(3066, 'Kgalagadi District', 29, 'inactive', NULL, NULL, NULL),
(3067, 'Central District', 29, 'inactive', NULL, NULL, NULL),
(3068, 'North-East District', 29, 'inactive', NULL, NULL, NULL),
(3069, 'Kweneng District', 29, 'inactive', NULL, NULL, NULL),
(3070, 'Collines Department', 24, 'inactive', NULL, NULL, NULL),
(3071, 'Kouffo Department', 24, 'inactive', NULL, NULL, NULL),
(3072, 'Donga Department', 24, 'inactive', NULL, NULL, NULL),
(3073, 'Zou Department', 24, 'inactive', NULL, NULL, NULL),
(3074, 'Plateau Department', 24, 'inactive', NULL, NULL, NULL),
(3075, 'Mono Department', 24, 'inactive', NULL, NULL, NULL),
(3076, 'Atakora Department', 24, 'inactive', NULL, NULL, NULL),
(3077, 'Alibori Department', 24, 'inactive', NULL, NULL, NULL),
(3078, 'Borgou Department', 24, 'inactive', NULL, NULL, NULL),
(3079, 'Atlantique Department', 24, 'inactive', NULL, NULL, NULL),
(3080, 'Ouémé Department', 24, 'inactive', NULL, NULL, NULL),
(3081, 'Littoral Department', 24, 'inactive', NULL, NULL, NULL),
(3082, 'Machinga District', 131, 'inactive', NULL, NULL, NULL),
(3083, 'Zomba District', 131, 'inactive', NULL, NULL, NULL),
(3084, 'Mwanza District', 131, 'inactive', NULL, NULL, NULL),
(3085, 'Nsanje District', 131, 'inactive', NULL, NULL, NULL),
(3086, 'Salima District', 131, 'inactive', NULL, NULL, NULL),
(3087, 'Chitipa district', 131, 'inactive', NULL, NULL, NULL),
(3088, 'Ntcheu District', 131, 'inactive', NULL, NULL, NULL),
(3089, 'Rumphi District', 131, 'inactive', NULL, NULL, NULL),
(3090, 'Dowa District', 131, 'inactive', NULL, NULL, NULL),
(3091, 'Karonga District', 131, 'inactive', NULL, NULL, NULL),
(3092, 'Central Region', 131, 'inactive', NULL, NULL, NULL),
(3093, 'Likoma District', 131, 'inactive', NULL, NULL, NULL),
(3094, 'Kasungu District', 131, 'inactive', NULL, NULL, NULL),
(3095, 'Nkhata Bay District', 131, 'inactive', NULL, NULL, NULL),
(3096, 'Balaka District', 131, 'inactive', NULL, NULL, NULL),
(3097, 'Dedza District', 131, 'inactive', NULL, NULL, NULL),
(3098, 'Thyolo District', 131, 'inactive', NULL, NULL, NULL),
(3099, 'Mchinji District', 131, 'inactive', NULL, NULL, NULL),
(3100, 'Nkhotakota District', 131, 'inactive', NULL, NULL, NULL),
(3101, 'Lilongwe District', 131, 'inactive', NULL, NULL, NULL),
(3102, 'Blantyre District', 131, 'inactive', NULL, NULL, NULL),
(3103, 'Mulanje District', 131, 'inactive', NULL, NULL, NULL),
(3104, 'Mzimba District', 131, 'inactive', NULL, NULL, NULL),
(3105, 'Northern Region', 131, 'inactive', NULL, NULL, NULL),
(3106, 'Southern Region', 131, 'inactive', NULL, NULL, NULL),
(3107, 'Chikwawa District', 131, 'inactive', NULL, NULL, NULL),
(3108, 'Phalombe District', 131, 'inactive', NULL, NULL, NULL),
(3109, 'Chiradzulu District', 131, 'inactive', NULL, NULL, NULL),
(3110, 'Mangochi District', 131, 'inactive', NULL, NULL, NULL),
(3111, 'Ntchisi District', 131, 'inactive', NULL, NULL, NULL),
(3112, 'Kénédougou Province', 35, 'inactive', NULL, NULL, NULL),
(3113, 'Namentenga Province', 35, 'inactive', NULL, NULL, NULL),
(3114, 'Sahel Region', 35, 'inactive', NULL, NULL, NULL),
(3115, 'Centre-Ouest Region', 35, 'inactive', NULL, NULL, NULL),
(3116, 'Nahouri Province', 35, 'inactive', NULL, NULL, NULL),
(3117, 'Passoré Province', 35, 'inactive', NULL, NULL, NULL),
(3118, 'Zoundwéogo Province', 35, 'inactive', NULL, NULL, NULL),
(3119, 'Sissili Province', 35, 'inactive', NULL, NULL, NULL),
(3120, 'Banwa Province', 35, 'inactive', NULL, NULL, NULL),
(3121, 'Bougouriba Province', 35, 'inactive', NULL, NULL, NULL),
(3122, 'Gnagna Province', 35, 'inactive', NULL, NULL, NULL),
(3123, 'Mouhoun', 35, 'inactive', NULL, NULL, NULL),
(3124, 'Yagha Province', 35, 'inactive', NULL, NULL, NULL),
(3125, 'Plateau-Central Region', 35, 'inactive', NULL, NULL, NULL),
(3126, 'Sanmatenga Province', 35, 'inactive', NULL, NULL, NULL),
(3127, 'Centre-Nord Region', 35, 'inactive', NULL, NULL, NULL),
(3128, 'Tapoa Province', 35, 'inactive', NULL, NULL, NULL),
(3129, 'Houet Province', 35, 'inactive', NULL, NULL, NULL),
(3130, 'Zondoma Province', 35, 'inactive', NULL, NULL, NULL),
(3131, 'Boulgou', 35, 'inactive', NULL, NULL, NULL),
(3132, 'Komondjari Province', 35, 'inactive', NULL, NULL, NULL),
(3133, 'Koulpélogo Province', 35, 'inactive', NULL, NULL, NULL),
(3134, 'Tuy Province', 35, 'inactive', NULL, NULL, NULL),
(3135, 'Ioba Province', 35, 'inactive', NULL, NULL, NULL),
(3136, 'Centre', 35, 'inactive', NULL, NULL, NULL),
(3137, 'Sourou Province', 35, 'inactive', NULL, NULL, NULL),
(3138, 'Boucle du Mouhoun Region', 35, 'inactive', NULL, NULL, NULL),
(3139, 'Séno Province', 35, 'inactive', NULL, NULL, NULL),
(3140, 'Sud-Ouest Region', 35, 'inactive', NULL, NULL, NULL),
(3141, 'Oubritenga Province', 35, 'inactive', NULL, NULL, NULL),
(3142, 'Nayala Province', 35, 'inactive', NULL, NULL, NULL),
(3143, 'Gourma Province', 35, 'inactive', NULL, NULL, NULL),
(3144, 'Oudalan Province', 35, 'inactive', NULL, NULL, NULL),
(3145, 'Ziro Province', 35, 'inactive', NULL, NULL, NULL),
(3146, 'Kossi Province', 35, 'inactive', NULL, NULL, NULL),
(3147, 'Kourwéogo Province', 35, 'inactive', NULL, NULL, NULL),
(3148, 'Ganzourgou Province', 35, 'inactive', NULL, NULL, NULL),
(3149, 'Centre-Sud Region', 35, 'inactive', NULL, NULL, NULL),
(3150, 'Yatenga Province', 35, 'inactive', NULL, NULL, NULL),
(3151, 'Loroum Province', 35, 'inactive', NULL, NULL, NULL),
(3152, 'Bazèga Province', 35, 'inactive', NULL, NULL, NULL),
(3153, 'Cascades Region', 35, 'inactive', NULL, NULL, NULL),
(3154, 'Sanguié Province', 35, 'inactive', NULL, NULL, NULL),
(3155, 'Bam Province', 35, 'inactive', NULL, NULL, NULL),
(3156, 'Noumbiel Province', 35, 'inactive', NULL, NULL, NULL),
(3157, 'Kompienga Province', 35, 'inactive', NULL, NULL, NULL),
(3158, 'Est Region', 35, 'inactive', NULL, NULL, NULL),
(3159, 'Léraba Province', 35, 'inactive', NULL, NULL, NULL),
(3160, 'Balé Province', 35, 'inactive', NULL, NULL, NULL),
(3161, 'Kouritenga Province', 35, 'inactive', NULL, NULL, NULL),
(3162, 'Centre-Est Region', 35, 'inactive', NULL, NULL, NULL),
(3163, 'Poni Province', 35, 'inactive', NULL, NULL, NULL),
(3164, 'Nord Region, Burkina Faso', 35, 'inactive', NULL, NULL, NULL),
(3165, 'Hauts-Bassins Region', 35, 'inactive', NULL, NULL, NULL),
(3166, 'Soum Province', 35, 'inactive', NULL, NULL, NULL),
(3167, 'Comoé Province', 35, 'inactive', NULL, NULL, NULL),
(3168, 'Kadiogo Province', 35, 'inactive', NULL, NULL, NULL),
(3169, 'Islamabad Capital Territory', 167, 'inactive', NULL, NULL, NULL),
(3170, 'Gilgit-Baltistan', 167, 'inactive', NULL, NULL, NULL),
(3171, 'Khyber Pakhtunkhwa', 167, 'inactive', NULL, NULL, NULL),
(3172, 'Azad Kashmir', 167, 'inactive', NULL, NULL, NULL),
(3173, 'Federally Administered Tribal Areas', 167, 'inactive', NULL, NULL, NULL),
(3174, 'Balochistan', 167, 'inactive', NULL, NULL, NULL),
(3175, 'Sindh', 167, 'inactive', NULL, NULL, NULL),
(3176, 'Punjab', 167, 'inactive', NULL, NULL, NULL),
(3177, 'Al Rayyan Municipality', 179, 'inactive', NULL, NULL, NULL),
(3178, 'Al-Shahaniya', 179, 'inactive', NULL, NULL, NULL),
(3179, 'Al Wakrah', 179, 'inactive', NULL, NULL, NULL),
(3180, 'Madinat ash Shamal', 179, 'inactive', NULL, NULL, NULL),
(3181, 'Doha', 179, 'inactive', NULL, NULL, NULL),
(3182, 'Al Daayen', 179, 'inactive', NULL, NULL, NULL),
(3183, 'Al Khor', 179, 'inactive', NULL, NULL, NULL),
(3184, 'Umm Salal Municipality', 179, 'inactive', NULL, NULL, NULL),
(3185, 'Rumonge Province', 36, 'inactive', NULL, NULL, NULL),
(3186, 'Muyinga Province', 36, 'inactive', NULL, NULL, NULL),
(3187, 'Mwaro Province', 36, 'inactive', NULL, NULL, NULL),
(3188, 'Makamba Province', 36, 'inactive', NULL, NULL, NULL),
(3189, 'Rutana Province', 36, 'inactive', NULL, NULL, NULL),
(3190, 'Cibitoke Province', 36, 'inactive', NULL, NULL, NULL),
(3191, 'Ruyigi Province', 36, 'inactive', NULL, NULL, NULL),
(3192, 'Kayanza Province', 36, 'inactive', NULL, NULL, NULL),
(3193, 'Muramvya Province', 36, 'inactive', NULL, NULL, NULL),
(3194, 'Karuzi Province', 36, 'inactive', NULL, NULL, NULL),
(3195, 'Kirundo Province', 36, 'inactive', NULL, NULL, NULL),
(3196, 'Bubanza Province', 36, 'inactive', NULL, NULL, NULL),
(3197, 'Gitega Province', 36, 'inactive', NULL, NULL, NULL),
(3198, 'Bujumbura Mairie Province', 36, 'inactive', NULL, NULL, NULL),
(3199, 'Ngozi Province', 36, 'inactive', NULL, NULL, NULL),
(3200, 'Bujumbura Rural Province', 36, 'inactive', NULL, NULL, NULL),
(3201, 'Cankuzo Province', 36, 'inactive', NULL, NULL, NULL),
(3202, 'Bururi Province', 36, 'inactive', NULL, NULL, NULL),
(3203, 'Flores Department', 235, 'inactive', NULL, NULL, NULL),
(3204, 'San José Department', 235, 'inactive', NULL, NULL, NULL),
(3205, 'Artigas Department', 235, 'inactive', NULL, NULL, NULL),
(3206, 'Maldonado Department', 235, 'inactive', NULL, NULL, NULL),
(3207, 'Rivera Department', 235, 'inactive', NULL, NULL, NULL),
(3208, 'Colonia Department', 235, 'inactive', NULL, NULL, NULL),
(3209, 'Durazno Department', 235, 'inactive', NULL, NULL, NULL),
(3210, 'Río Negro Department', 235, 'inactive', NULL, NULL, NULL),
(3211, 'Cerro Largo Department', 235, 'inactive', NULL, NULL, NULL),
(3212, 'Paysandú Department', 235, 'inactive', NULL, NULL, NULL),
(3213, 'Canelones Department', 235, 'inactive', NULL, NULL, NULL),
(3214, 'Treinta y Tres Department', 235, 'inactive', NULL, NULL, NULL),
(3215, 'Lavalleja Department', 235, 'inactive', NULL, NULL, NULL),
(3216, 'Rocha Department', 235, 'inactive', NULL, NULL, NULL),
(3217, 'Florida Department', 235, 'inactive', NULL, NULL, NULL),
(3218, 'Montevideo Department', 235, 'inactive', NULL, NULL, NULL),
(3219, 'Soriano Department', 235, 'inactive', NULL, NULL, NULL),
(3220, 'Salto Department', 235, 'inactive', NULL, NULL, NULL),
(3221, 'Tacuarembó Department', 235, 'inactive', NULL, NULL, NULL),
(3222, 'Kafr el-Sheikh Governorate', 65, 'inactive', NULL, NULL, NULL),
(3223, 'Cairo Governorate', 65, 'inactive', NULL, NULL, '2022-12-17 22:17:49'),
(3224, 'Damietta Governorate', 65, 'inactive', NULL, NULL, NULL),
(3225, 'Aswan Governorate', 65, 'inactive', NULL, NULL, NULL),
(3226, 'Sohag Governorate', 65, 'inactive', NULL, NULL, NULL),
(3227, 'North Sinai Governorate', 65, 'inactive', NULL, NULL, NULL),
(3228, 'Monufia Governorate', 65, 'inactive', NULL, NULL, NULL),
(3229, 'Port Said Governorate', 65, 'inactive', NULL, NULL, NULL),
(3230, 'Beni Suef Governorate', 65, 'inactive', NULL, NULL, NULL),
(3231, 'Matrouh Governorate', 65, 'inactive', NULL, NULL, NULL),
(3232, 'Qalyubia Governorate', 65, 'inactive', NULL, NULL, NULL),
(3233, 'Suez Governorate', 65, 'inactive', NULL, NULL, NULL),
(3234, 'Gharbia Governorate', 65, 'inactive', NULL, NULL, NULL),
(3235, 'Alexandria Governorate', 65, 'inactive', NULL, NULL, NULL),
(3236, 'Asyut Governorate', 65, 'inactive', NULL, NULL, NULL),
(3237, 'South Sinai Governorate', 65, 'inactive', NULL, NULL, NULL),
(3238, 'Faiyum Governorate', 65, 'inactive', NULL, NULL, NULL),
(3239, 'Giza Governorate', 65, 'inactive', NULL, NULL, NULL),
(3240, 'Red Sea Governorate', 65, 'inactive', NULL, NULL, NULL),
(3241, 'Beheira Governorate', 65, 'inactive', NULL, NULL, NULL),
(3242, 'Luxor Governorate', 65, 'inactive', NULL, NULL, NULL),
(3243, 'Minya Governorate', 65, 'inactive', NULL, NULL, NULL),
(3244, 'Ismailia Governorate', 65, 'inactive', NULL, NULL, NULL),
(3245, 'Dakahlia Governorate', 65, 'inactive', NULL, NULL, NULL),
(3246, 'New Valley Governorate', 65, 'inactive', NULL, NULL, NULL),
(3247, 'Qena Governorate', 65, 'inactive', NULL, NULL, NULL),
(3248, 'Agaléga', 140, 'inactive', NULL, NULL, NULL),
(3249, 'Rodrigues', 140, 'inactive', NULL, NULL, NULL),
(3250, 'Pamplemousses District', 140, 'inactive', NULL, NULL, NULL),
(3251, 'Cargados Carajos', 140, 'inactive', NULL, NULL, NULL),
(3252, 'Vacoas-Phoenix', 140, 'inactive', NULL, NULL, NULL),
(3253, 'Moka District', 140, 'inactive', NULL, NULL, NULL),
(3254, 'Flacq District', 140, 'inactive', NULL, NULL, NULL),
(3255, 'Curepipe', 140, 'inactive', NULL, NULL, NULL),
(3256, 'Port Louis', 140, 'inactive', NULL, NULL, NULL),
(3257, 'Savanne District', 140, 'inactive', NULL, NULL, NULL),
(3258, 'Quatre Bornes', 140, 'inactive', NULL, NULL, NULL),
(3259, 'Rivière Noire District', 140, 'inactive', NULL, NULL, NULL),
(3260, 'Port Louis District', 140, 'inactive', NULL, NULL, NULL),
(3261, 'Rivière du Rempart District', 140, 'inactive', NULL, NULL, NULL),
(3262, 'Beau Bassin-Rose Hill', 140, 'inactive', NULL, NULL, NULL),
(3263, 'Plaines Wilhems District', 140, 'inactive', NULL, NULL, NULL),
(3264, 'Grand Port District', 140, 'inactive', NULL, NULL, NULL),
(3265, 'Guelmim Province', 149, 'inactive', NULL, NULL, NULL),
(3266, 'Aousserd Province', 149, 'inactive', NULL, NULL, NULL),
(3267, 'Al Hoceïma Province', 149, 'inactive', NULL, NULL, NULL),
(3268, 'Larache Province', 149, 'inactive', NULL, NULL, NULL),
(3269, 'Ouarzazate Province', 149, 'inactive', NULL, NULL, NULL),
(3270, 'Boulemane Province', 149, 'inactive', NULL, NULL, NULL),
(3271, 'Oriental', 149, 'inactive', NULL, NULL, NULL),
(3272, 'Béni-Mellal Province', 149, 'inactive', NULL, NULL, NULL),
(3273, 'Sidi Youssef Ben Ali', 149, 'inactive', NULL, NULL, NULL),
(3274, 'Chichaoua Province', 149, 'inactive', NULL, NULL, NULL),
(3275, 'Boujdour Province', 149, 'inactive', NULL, NULL, NULL),
(3276, 'Khémisset Province', 149, 'inactive', NULL, NULL, NULL),
(3277, 'Tiznit Province', 149, 'inactive', NULL, NULL, NULL),
(3278, 'Béni Mellal-Khénifra', 149, 'inactive', NULL, NULL, NULL),
(3279, 'Sidi Kacem Province', 149, 'inactive', NULL, NULL, NULL),
(3280, 'El Jadida Province', 149, 'inactive', NULL, NULL, NULL),
(3281, 'Nador Province', 149, 'inactive', NULL, NULL, NULL),
(3282, 'Settat Province', 149, 'inactive', NULL, NULL, NULL),
(3283, 'Zagora Province', 149, 'inactive', NULL, NULL, NULL),
(3284, 'Mediouna Province', 149, 'inactive', NULL, NULL, NULL),
(3285, 'Berkane Province', 149, 'inactive', NULL, NULL, NULL),
(3286, 'Tan-Tan Province', 149, 'inactive', NULL, NULL, NULL),
(3287, 'Nouaceur Province', 149, 'inactive', NULL, NULL, NULL),
(3288, 'Marrakesh-Safi', 149, 'inactive', NULL, NULL, NULL),
(3289, 'Sefrou Province', 149, 'inactive', NULL, NULL, NULL),
(3290, 'Drâa-Tafilalet', 149, 'inactive', NULL, NULL, NULL),
(3291, 'El Hajeb Province', 149, 'inactive', NULL, NULL, NULL),
(3292, 'Es Semara Province', 149, 'inactive', NULL, NULL, NULL),
(3293, 'Laâyoune Province', 149, 'inactive', NULL, NULL, NULL),
(3294, 'Inezgane-Aït Melloul Prefecture', 149, 'inactive', NULL, NULL, NULL),
(3295, 'Souss-Massa', 149, 'inactive', NULL, NULL, NULL),
(3296, 'Taza Province', 149, 'inactive', NULL, NULL, NULL),
(3297, 'Assa-Zag Province', 149, 'inactive', NULL, NULL, NULL),
(3298, 'Laâyoune-Sakia El Hamra', 149, 'inactive', NULL, NULL, NULL),
(3299, 'Errachidia Province', 149, 'inactive', NULL, NULL, NULL),
(3300, 'Fahs Anjra Province', 149, 'inactive', NULL, NULL, NULL),
(3301, 'Figuig Province', 149, 'inactive', NULL, NULL, NULL),
(3302, 'Shtouka Ait Baha Province', 149, 'inactive', NULL, NULL, NULL),
(3303, 'Casablanca-Settat', 149, 'inactive', NULL, NULL, NULL),
(3304, 'Ben Slimane Province', 149, 'inactive', NULL, NULL, NULL),
(3305, 'Guelmim-Oued Noun', 149, 'inactive', NULL, NULL, NULL),
(3306, 'Dakhla-Oued Ed-Dahab', 149, 'inactive', NULL, NULL, NULL),
(3307, 'Jerada Province', 149, 'inactive', NULL, NULL, NULL),
(3308, 'Kénitra Province', 149, 'inactive', NULL, NULL, NULL),
(3309, 'Kelaat Sraghna Province', 149, 'inactive', NULL, NULL, NULL),
(3310, 'Chefchaouen Province', 149, 'inactive', NULL, NULL, NULL),
(3311, 'Safi Province', 149, 'inactive', NULL, NULL, NULL),
(3312, 'Tata Province', 149, 'inactive', NULL, NULL, NULL),
(3313, 'Fès-Meknès', 149, 'inactive', NULL, NULL, NULL),
(3314, 'Taroudant Province', 149, 'inactive', NULL, NULL, NULL),
(3315, 'Moulay Yacoub Province', 149, 'inactive', NULL, NULL, NULL),
(3316, 'Essaouira Province', 149, 'inactive', NULL, NULL, NULL),
(3317, 'Khénifra Province', 149, 'inactive', NULL, NULL, NULL),
(3318, 'Tétouan Province', 149, 'inactive', NULL, NULL, NULL),
(3319, 'Oued Ed-Dahab Province', 149, 'inactive', NULL, NULL, NULL),
(3320, 'Al Haouz Province', 149, 'inactive', NULL, NULL, NULL),
(3321, 'Azilal Province', 149, 'inactive', NULL, NULL, NULL),
(3322, 'Taourirt Province', 149, 'inactive', NULL, NULL, NULL),
(3323, 'Taounate Province', 149, 'inactive', NULL, NULL, NULL),
(3324, 'Tanger-Tétouan-Al Hoceïma', 149, 'inactive', NULL, NULL, NULL),
(3325, 'Ifrane Province', 149, 'inactive', NULL, NULL, NULL),
(3326, 'Khouribga Province', 149, 'inactive', NULL, NULL, NULL),
(3327, 'Cabo Delgado Province', 150, 'inactive', NULL, NULL, NULL),
(3328, 'Zambezia Province', 150, 'inactive', NULL, NULL, NULL),
(3329, 'Gaza Province', 150, 'inactive', NULL, NULL, NULL),
(3330, 'Inhambane Province', 150, 'inactive', NULL, NULL, NULL),
(3331, 'Sofala Province', 150, 'inactive', NULL, NULL, NULL),
(3332, 'Maputo Province', 150, 'inactive', NULL, NULL, NULL),
(3333, 'Niassa Province', 150, 'inactive', NULL, NULL, NULL),
(3334, 'Tete Province', 150, 'inactive', NULL, NULL, NULL),
(3335, 'Maputo', 150, 'inactive', NULL, NULL, NULL),
(3336, 'Nampula Province', 150, 'inactive', NULL, NULL, NULL),
(3337, 'Manica Province', 150, 'inactive', NULL, NULL, NULL),
(3338, 'Hodh Ech Chargui Region', 139, 'inactive', NULL, NULL, NULL),
(3339, 'Brakna Region', 139, 'inactive', NULL, NULL, NULL);
INSERT INTO `states` (`id`, `name`, `country_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3340, 'Tiris Zemmour Region', 139, 'inactive', NULL, NULL, NULL),
(3341, 'Gorgol Region', 139, 'inactive', NULL, NULL, NULL),
(3342, 'Inchiri Region', 139, 'inactive', NULL, NULL, NULL),
(3343, 'Nouakchott-Nord Region', 139, 'inactive', NULL, NULL, NULL),
(3344, 'Adrar Region', 139, 'inactive', NULL, NULL, NULL),
(3345, 'Tagant Region', 139, 'inactive', NULL, NULL, NULL),
(3346, 'Dakhlet Nouadhibou', 139, 'inactive', NULL, NULL, NULL),
(3347, 'Nouakchott-Sud Region', 139, 'inactive', NULL, NULL, NULL),
(3348, 'Trarza Region', 139, 'inactive', NULL, NULL, NULL),
(3349, 'Assaba Region', 139, 'inactive', NULL, NULL, NULL),
(3350, 'Guidimaka Region', 139, 'inactive', NULL, NULL, NULL),
(3351, 'Hodh El Gharbi Region', 139, 'inactive', NULL, NULL, NULL),
(3352, 'Nouakchott-Ouest Region', 139, 'inactive', NULL, NULL, NULL),
(3353, 'Western Tobago', 223, 'inactive', NULL, NULL, NULL),
(3354, 'Couva-Tabaquite-Talparo Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3355, 'Eastern Tobago', 223, 'inactive', NULL, NULL, NULL),
(3356, 'Rio Claro-Mayaro Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3357, 'San Juan-Laventille Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3358, 'Tunapuna-Piarco Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3359, 'San Fernando', 223, 'inactive', NULL, NULL, NULL),
(3360, 'Point Fortin', 223, 'inactive', NULL, NULL, NULL),
(3361, 'Sangre Grande Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3362, 'Arima', 223, 'inactive', NULL, NULL, NULL),
(3363, 'Port of Spain', 223, 'inactive', NULL, NULL, NULL),
(3364, 'Siparia Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3365, 'Penal-Debe Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3366, 'Chaguanas', 223, 'inactive', NULL, NULL, NULL),
(3367, 'Diego Martin Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3368, 'Princes Town Regional Corporation', 223, 'inactive', NULL, NULL, NULL),
(3369, 'Mary Region', 226, 'inactive', NULL, NULL, NULL),
(3370, 'Lebap Region', 226, 'inactive', NULL, NULL, NULL),
(3371, 'Ashgabat', 226, 'inactive', NULL, NULL, NULL),
(3372, 'Balkan Region', 226, 'inactive', NULL, NULL, NULL),
(3373, 'Daşoguz Region', 226, 'inactive', NULL, NULL, NULL),
(3374, 'Ahal Region', 226, 'inactive', NULL, NULL, NULL),
(3375, 'Beni Department', 27, 'inactive', NULL, NULL, NULL),
(3376, 'Oruro Department', 27, 'inactive', NULL, NULL, NULL),
(3377, 'Santa Cruz Department', 27, 'inactive', NULL, NULL, NULL),
(3378, 'Tarija Department', 27, 'inactive', NULL, NULL, NULL),
(3379, 'Pando Department', 27, 'inactive', NULL, NULL, NULL),
(3380, 'La Paz Department', 27, 'inactive', NULL, NULL, NULL),
(3381, 'Cochabamba Department', 27, 'inactive', NULL, NULL, NULL),
(3382, 'Chuquisaca Department', 27, 'inactive', NULL, NULL, NULL),
(3383, 'Potosí Department', 27, 'inactive', NULL, NULL, NULL),
(3384, 'Saint George Parish', 188, 'inactive', NULL, NULL, NULL),
(3385, 'Saint Patrick Parish', 188, 'inactive', NULL, NULL, NULL),
(3386, 'Saint Andrew Parish', 188, 'inactive', NULL, NULL, NULL),
(3387, 'Saint David Parish', 188, 'inactive', NULL, NULL, NULL),
(3388, 'Grenadines Parish', 188, 'inactive', NULL, NULL, NULL),
(3389, 'Charlotte Parish', 188, 'inactive', NULL, NULL, NULL),
(3390, 'Sharjah Emirate', 231, 'inactive', NULL, NULL, NULL),
(3391, 'Dubai', 231, 'inactive', NULL, NULL, NULL),
(3392, 'Umm al-Quwain', 231, 'inactive', NULL, NULL, NULL),
(3393, 'Fujairah', 231, 'inactive', NULL, NULL, NULL),
(3394, 'Ras al-Khaimah', 231, 'inactive', NULL, NULL, NULL),
(3395, 'Ajman Emirate', 231, 'inactive', NULL, NULL, NULL),
(3396, 'Abu Dhabi Emirate', 231, 'inactive', NULL, NULL, NULL),
(3397, 'districts of Republican Subordination', 217, 'inactive', NULL, NULL, NULL),
(3398, 'Khatlon Province', 217, 'inactive', NULL, NULL, NULL),
(3399, 'Gorno-Badakhshan Autonomous Province', 217, 'inactive', NULL, NULL, NULL),
(3400, 'Sughd Province', 217, 'inactive', NULL, NULL, NULL),
(3401, 'Tainan County', 216, 'inactive', NULL, NULL, NULL),
(3402, 'Yilan County', 216, 'inactive', NULL, NULL, NULL),
(3403, 'Penghu County', 216, 'inactive', NULL, NULL, NULL),
(3404, 'Changhua County', 216, 'inactive', NULL, NULL, NULL),
(3405, 'Pingtung County', 216, 'inactive', NULL, NULL, NULL),
(3406, 'Taichung', 216, 'inactive', NULL, NULL, NULL),
(3407, 'Nantou County', 216, 'inactive', NULL, NULL, NULL),
(3408, 'Chiayi County', 216, 'inactive', NULL, NULL, NULL),
(3409, 'Kaohsiung County', 216, 'inactive', NULL, NULL, NULL),
(3410, 'Taitung County', 216, 'inactive', NULL, NULL, NULL),
(3411, 'Hualien County', 216, 'inactive', NULL, NULL, NULL),
(3412, 'Kaohsiung', 216, 'inactive', NULL, NULL, NULL),
(3413, 'Miaoli County', 216, 'inactive', NULL, NULL, NULL),
(3414, 'Taichung County', 216, 'inactive', NULL, NULL, NULL),
(3415, 'Kinmen', 216, 'inactive', NULL, NULL, NULL),
(3416, 'Yunlin County', 216, 'inactive', NULL, NULL, NULL),
(3417, 'Hsinchu', 216, 'inactive', NULL, NULL, NULL),
(3418, 'Chiayi City', 216, 'inactive', NULL, NULL, NULL),
(3419, 'Taoyuan City', 216, 'inactive', NULL, NULL, NULL),
(3420, 'Lienchiang County', 216, 'inactive', NULL, NULL, NULL),
(3421, 'Tainan', 216, 'inactive', NULL, NULL, NULL),
(3422, 'Taipei', 216, 'inactive', NULL, NULL, NULL),
(3423, 'Hsinchu County', 216, 'inactive', NULL, NULL, NULL),
(3424, 'Northern Red Sea Region', 68, 'inactive', NULL, NULL, NULL),
(3425, 'Anseba Region', 68, 'inactive', NULL, NULL, NULL),
(3426, 'Maekel Region', 68, 'inactive', NULL, NULL, NULL),
(3427, 'Debub Region', 68, 'inactive', NULL, NULL, NULL),
(3428, 'Gash-Barka Region', 68, 'inactive', NULL, NULL, NULL),
(3429, 'Southern Red Sea Region', 68, 'inactive', NULL, NULL, NULL),
(3430, 'Southern Peninsula Region', 100, 'inactive', NULL, NULL, NULL),
(3431, 'Capital Region', 100, 'inactive', NULL, NULL, NULL),
(3432, 'Westfjords', 100, 'inactive', NULL, NULL, NULL),
(3433, 'Eastern Region', 100, 'inactive', NULL, NULL, NULL),
(3434, 'Southern Region', 100, 'inactive', NULL, NULL, NULL),
(3435, 'Northwestern Region', 100, 'inactive', NULL, NULL, NULL),
(3436, 'Western Region', 100, 'inactive', NULL, NULL, NULL),
(3437, 'Northeastern Region', 100, 'inactive', NULL, NULL, NULL),
(3438, 'Río Muni', 67, 'inactive', NULL, NULL, NULL),
(3439, 'Kié-Ntem Province', 67, 'inactive', NULL, NULL, NULL),
(3440, 'Wele-Nzas Province', 67, 'inactive', NULL, NULL, NULL),
(3441, 'Litoral Province', 67, 'inactive', NULL, NULL, NULL),
(3442, 'Insular Region', 67, 'inactive', NULL, NULL, NULL),
(3443, 'Bioko Sur Province', 67, 'inactive', NULL, NULL, NULL),
(3444, 'Annobón Province', 67, 'inactive', NULL, NULL, NULL),
(3445, 'Centro Sur Province', 67, 'inactive', NULL, NULL, NULL),
(3446, 'Bioko Norte Province', 67, 'inactive', NULL, NULL, NULL),
(3447, 'Chihuahua', 142, 'inactive', NULL, NULL, NULL),
(3448, 'Oaxaca', 142, 'inactive', NULL, NULL, NULL),
(3449, 'Sinaloa', 142, 'inactive', NULL, NULL, NULL),
(3450, 'México', 142, 'inactive', NULL, NULL, NULL),
(3451, 'Chiapas', 142, 'inactive', NULL, NULL, NULL),
(3452, 'Nuevo León', 142, 'inactive', NULL, NULL, NULL),
(3453, 'Durango', 142, 'inactive', NULL, NULL, NULL),
(3454, 'Tabasco', 142, 'inactive', NULL, NULL, NULL),
(3455, 'Querétaro', 142, 'inactive', NULL, NULL, NULL),
(3456, 'Aguascalientes', 142, 'inactive', NULL, NULL, NULL),
(3457, 'Baja California', 142, 'inactive', NULL, NULL, NULL),
(3458, 'Tlaxcala', 142, 'inactive', NULL, NULL, NULL),
(3459, 'Guerrero', 142, 'inactive', NULL, NULL, NULL),
(3460, 'Baja California Sur', 142, 'inactive', NULL, NULL, NULL),
(3461, 'San Luis Potosí', 142, 'inactive', NULL, NULL, NULL),
(3462, 'Zacatecas', 142, 'inactive', NULL, NULL, NULL),
(3463, 'Tamaulipas', 142, 'inactive', NULL, NULL, NULL),
(3464, 'Veracruz', 142, 'inactive', NULL, NULL, NULL),
(3465, 'Morelos', 142, 'inactive', NULL, NULL, NULL),
(3466, 'Yucatán', 142, 'inactive', NULL, NULL, NULL),
(3467, 'Quintana Roo', 142, 'inactive', NULL, NULL, NULL),
(3468, 'Sonora', 142, 'inactive', NULL, NULL, NULL),
(3469, 'Guanajuato', 142, 'inactive', NULL, NULL, NULL),
(3470, 'Hidalgo', 142, 'inactive', NULL, NULL, NULL),
(3471, 'Coahuila', 142, 'inactive', NULL, NULL, NULL),
(3472, 'Colima', 142, 'inactive', NULL, NULL, NULL),
(3473, 'Mexico City', 142, 'inactive', NULL, NULL, NULL),
(3474, 'Michoacán', 142, 'inactive', NULL, NULL, NULL),
(3475, 'Campeche', 142, 'inactive', NULL, NULL, NULL),
(3476, 'Puebla', 142, 'inactive', NULL, NULL, NULL),
(3477, 'Nayarit', 142, 'inactive', NULL, NULL, NULL),
(3478, 'Krabi', 219, 'inactive', NULL, NULL, NULL),
(3479, 'Ranong', 219, 'inactive', NULL, NULL, NULL),
(3480, 'Nong Bua Lam Phu', 219, 'inactive', NULL, NULL, NULL),
(3481, 'Samut Prakan', 219, 'inactive', NULL, NULL, NULL),
(3482, 'Surat Thani', 219, 'inactive', NULL, NULL, NULL),
(3483, 'Lamphun', 219, 'inactive', NULL, NULL, NULL),
(3484, 'Nong Khai', 219, 'inactive', NULL, NULL, NULL),
(3485, 'Khon Kaen', 219, 'inactive', NULL, NULL, NULL),
(3486, 'Chanthaburi', 219, 'inactive', NULL, NULL, NULL),
(3487, 'Saraburi', 219, 'inactive', NULL, NULL, NULL),
(3488, 'Phatthalung', 219, 'inactive', NULL, NULL, NULL),
(3489, 'Uttaradit', 219, 'inactive', NULL, NULL, NULL),
(3490, 'Sing Buri', 219, 'inactive', NULL, NULL, NULL),
(3491, 'Chiang Mai', 219, 'inactive', NULL, NULL, NULL),
(3492, 'Nakhon Sawan', 219, 'inactive', NULL, NULL, NULL),
(3493, 'Yala', 219, 'inactive', NULL, NULL, NULL),
(3494, 'Phra Nakhon Si Ayutthaya', 219, 'inactive', NULL, NULL, NULL),
(3495, 'Nonthaburi', 219, 'inactive', NULL, NULL, NULL),
(3496, 'Trat', 219, 'inactive', NULL, NULL, NULL),
(3497, 'Nakhon Ratchasima', 219, 'inactive', NULL, NULL, NULL),
(3498, 'Chiang Rai', 219, 'inactive', NULL, NULL, NULL),
(3499, 'Ratchaburi', 219, 'inactive', NULL, NULL, NULL),
(3500, 'Pathum Thani', 219, 'inactive', NULL, NULL, NULL),
(3501, 'Sakon Nakhon', 219, 'inactive', NULL, NULL, NULL),
(3502, 'Samut Songkhram', 219, 'inactive', NULL, NULL, NULL),
(3503, 'Nakhon Pathom', 219, 'inactive', NULL, NULL, NULL),
(3504, 'Samut Sakhon', 219, 'inactive', NULL, NULL, NULL),
(3505, 'Mae Hong Son', 219, 'inactive', NULL, NULL, NULL),
(3506, 'Phitsanulok', 219, 'inactive', NULL, NULL, NULL),
(3507, 'Pattaya', 219, 'inactive', NULL, NULL, NULL),
(3508, 'Prachuap Khiri Khan', 219, 'inactive', NULL, NULL, NULL),
(3509, 'Loei', 219, 'inactive', NULL, NULL, NULL),
(3510, 'Roi Et', 219, 'inactive', NULL, NULL, NULL),
(3511, 'Kanchanaburi', 219, 'inactive', NULL, NULL, NULL),
(3512, 'Ubon Ratchathani', 219, 'inactive', NULL, NULL, NULL),
(3513, 'Chon Buri', 219, 'inactive', NULL, NULL, NULL),
(3514, 'Phichit', 219, 'inactive', NULL, NULL, NULL),
(3515, 'Phetchabun', 219, 'inactive', NULL, NULL, NULL),
(3516, 'Kamphaeng Phet', 219, 'inactive', NULL, NULL, NULL),
(3517, 'Maha Sarakham', 219, 'inactive', NULL, NULL, NULL),
(3518, 'Rayong', 219, 'inactive', NULL, NULL, NULL),
(3519, 'Ang Thong', 219, 'inactive', NULL, NULL, NULL),
(3520, 'Nakhon Si Thammarat', 219, 'inactive', NULL, NULL, NULL),
(3521, 'Yasothon', 219, 'inactive', NULL, NULL, NULL),
(3522, 'Chai Nat', 219, 'inactive', NULL, NULL, NULL),
(3523, 'Amnat Charoen', 219, 'inactive', NULL, NULL, NULL),
(3524, 'Suphanburi', 219, 'inactive', NULL, NULL, NULL),
(3525, 'Tak', 219, 'inactive', NULL, NULL, NULL),
(3526, 'Chumphon', 219, 'inactive', NULL, NULL, NULL),
(3527, 'Udon Thani', 219, 'inactive', NULL, NULL, NULL),
(3528, 'Phrae', 219, 'inactive', NULL, NULL, NULL),
(3529, 'Sa Kaeo', 219, 'inactive', NULL, NULL, NULL),
(3530, 'Nan', 219, 'inactive', NULL, NULL, NULL),
(3531, 'Surin', 219, 'inactive', NULL, NULL, NULL),
(3532, 'Phetchaburi', 219, 'inactive', NULL, NULL, NULL),
(3533, 'Bueng Kan', 219, 'inactive', NULL, NULL, NULL),
(3534, 'Buri Ram', 219, 'inactive', NULL, NULL, NULL),
(3535, 'Nakhon Nayok', 219, 'inactive', NULL, NULL, NULL),
(3536, 'Phuket', 219, 'inactive', NULL, NULL, NULL),
(3537, 'Satun', 219, 'inactive', NULL, NULL, NULL),
(3538, 'Phayao', 219, 'inactive', NULL, NULL, NULL),
(3539, 'Songkhla', 219, 'inactive', NULL, NULL, NULL),
(3540, 'Pattani', 219, 'inactive', NULL, NULL, NULL),
(3541, 'Trang', 219, 'inactive', NULL, NULL, NULL),
(3542, 'Prachin Buri', 219, 'inactive', NULL, NULL, NULL),
(3543, 'Lopburi', 219, 'inactive', NULL, NULL, NULL),
(3544, 'Lampang', 219, 'inactive', NULL, NULL, NULL),
(3545, 'Sukhothai', 219, 'inactive', NULL, NULL, NULL),
(3546, 'Mukdahan', 219, 'inactive', NULL, NULL, NULL),
(3547, 'Si Sa Ket', 219, 'inactive', NULL, NULL, NULL),
(3548, 'Nakhon Phanom', 219, 'inactive', NULL, NULL, NULL),
(3549, 'Phang Nga', 219, 'inactive', NULL, NULL, NULL),
(3550, 'Kalasin', 219, 'inactive', NULL, NULL, NULL),
(3551, 'Uthai Thani', 219, 'inactive', NULL, NULL, NULL),
(3552, 'Chachoengsao', 219, 'inactive', NULL, NULL, NULL),
(3553, 'Narathiwat', 219, 'inactive', NULL, NULL, NULL),
(3554, 'Bangkok', 219, 'inactive', NULL, NULL, NULL),
(3555, 'Hiiu County', 69, 'inactive', NULL, NULL, NULL),
(3556, 'Viljandi County', 69, 'inactive', NULL, NULL, NULL),
(3557, 'Tartu County', 69, 'inactive', NULL, NULL, NULL),
(3558, 'Valga County', 69, 'inactive', NULL, NULL, NULL),
(3559, 'Rapla County', 69, 'inactive', NULL, NULL, NULL),
(3560, 'Võru County', 69, 'inactive', NULL, NULL, NULL),
(3561, 'Saare County', 69, 'inactive', NULL, NULL, NULL),
(3562, 'Pärnu County', 69, 'inactive', NULL, NULL, NULL),
(3563, 'Põlva County', 69, 'inactive', NULL, NULL, NULL),
(3564, 'Lääne-Viru County', 69, 'inactive', NULL, NULL, NULL),
(3565, 'Jõgeva County', 69, 'inactive', NULL, NULL, NULL),
(3566, 'Järva County', 69, 'inactive', NULL, NULL, NULL),
(3567, 'Harju County', 69, 'inactive', NULL, NULL, NULL),
(3568, 'Lääne County', 69, 'inactive', NULL, NULL, NULL),
(3569, 'Ida-Viru County', 69, 'inactive', NULL, NULL, NULL),
(3570, 'Moyen-Chari Region', 43, 'inactive', NULL, NULL, NULL),
(3571, 'Mayo-Kebbi Ouest Region', 43, 'inactive', NULL, NULL, NULL),
(3572, 'Sila Region', 43, 'inactive', NULL, NULL, NULL),
(3573, 'Hadjer-Lamis', 43, 'inactive', NULL, NULL, NULL),
(3574, 'Borkou', 43, 'inactive', NULL, NULL, NULL),
(3575, 'Ennedi-Est', 43, 'inactive', NULL, NULL, NULL),
(3576, 'Guéra Region', 43, 'inactive', NULL, NULL, NULL),
(3577, 'Lac Region', 43, 'inactive', NULL, NULL, NULL),
(3578, 'Ennedi Region', 43, 'inactive', NULL, NULL, NULL),
(3579, 'Tandjilé Region', 43, 'inactive', NULL, NULL, NULL),
(3580, 'Mayo-Kebbi Est Region', 43, 'inactive', NULL, NULL, NULL),
(3581, 'Wadi Fira Region', 43, 'inactive', NULL, NULL, NULL),
(3582, 'Ouaddaï Region', 43, 'inactive', NULL, NULL, NULL),
(3583, 'Bahr el Gazel', 43, 'inactive', NULL, NULL, NULL),
(3584, 'Ennedi-Ouest', 43, 'inactive', NULL, NULL, NULL),
(3585, 'Logone Occidental Region', 43, 'inactive', NULL, NULL, NULL),
(3586, 'N\'Djamena', 43, 'inactive', NULL, NULL, NULL),
(3587, 'Tibesti Region', 43, 'inactive', NULL, NULL, NULL),
(3588, 'Kanem Region', 43, 'inactive', NULL, NULL, NULL),
(3589, 'Mandoul Region', 43, 'inactive', NULL, NULL, NULL),
(3590, 'Batha Region', 43, 'inactive', NULL, NULL, NULL),
(3591, 'Logone Oriental Region', 43, 'inactive', NULL, NULL, NULL),
(3592, 'Salamat Region', 43, 'inactive', NULL, NULL, NULL),
(3593, 'Berry Islands', 17, 'inactive', NULL, NULL, NULL),
(3594, 'Nichollstown and Berry Islands', 17, 'inactive', NULL, NULL, NULL),
(3595, 'Green Turtle Cay', 17, 'inactive', NULL, NULL, NULL),
(3596, 'Central Eleuthera', 17, 'inactive', NULL, NULL, NULL),
(3597, 'Governor\'s Harbour', 17, 'inactive', NULL, NULL, NULL),
(3598, 'High Rock', 17, 'inactive', NULL, NULL, NULL),
(3599, 'West Grand Bahama', 17, 'inactive', NULL, NULL, NULL),
(3600, 'Rum Cay District', 17, 'inactive', NULL, NULL, NULL),
(3601, 'Acklins', 17, 'inactive', NULL, NULL, NULL),
(3602, 'North Eleuthera', 17, 'inactive', NULL, NULL, NULL),
(3603, 'Central Abaco', 17, 'inactive', NULL, NULL, NULL),
(3604, 'Marsh Harbour', 17, 'inactive', NULL, NULL, NULL),
(3605, 'Black Point', 17, 'inactive', NULL, NULL, NULL),
(3606, 'Sandy Point', 17, 'inactive', NULL, NULL, NULL),
(3607, 'South Eleuthera', 17, 'inactive', NULL, NULL, NULL),
(3608, 'South Abaco', 17, 'inactive', NULL, NULL, NULL),
(3609, 'Inagua', 17, 'inactive', NULL, NULL, NULL),
(3610, 'Long Island', 17, 'inactive', NULL, NULL, NULL),
(3611, 'Cat Island', 17, 'inactive', NULL, NULL, NULL),
(3612, 'Exuma', 17, 'inactive', NULL, NULL, NULL),
(3613, 'Harbour Island', 17, 'inactive', NULL, NULL, NULL),
(3614, 'East Grand Bahama', 17, 'inactive', NULL, NULL, NULL),
(3615, 'Ragged Island', 17, 'inactive', NULL, NULL, NULL),
(3616, 'North Abaco', 17, 'inactive', NULL, NULL, NULL),
(3617, 'North Andros', 17, 'inactive', NULL, NULL, NULL),
(3618, 'Kemps Bay', 17, 'inactive', NULL, NULL, NULL),
(3619, 'Fresh Creek', 17, 'inactive', NULL, NULL, NULL),
(3620, 'San Salvador and Rum Cay', 17, 'inactive', NULL, NULL, NULL),
(3621, 'Crooked Island', 17, 'inactive', NULL, NULL, NULL),
(3622, 'South Andros', 17, 'inactive', NULL, NULL, NULL),
(3623, 'Rock Sound', 17, 'inactive', NULL, NULL, NULL),
(3624, 'Hope Town', 17, 'inactive', NULL, NULL, NULL),
(3625, 'Mangrove Cay', 17, 'inactive', NULL, NULL, NULL),
(3626, 'Freeport', 17, 'inactive', NULL, NULL, NULL),
(3627, 'San Salvador Island', 17, 'inactive', NULL, NULL, NULL),
(3628, 'Acklins and Crooked Islands', 17, 'inactive', NULL, NULL, NULL),
(3629, 'Bimini', 17, 'inactive', NULL, NULL, NULL),
(3630, 'Spanish Wells', 17, 'inactive', NULL, NULL, NULL),
(3631, 'Central Andros', 17, 'inactive', NULL, NULL, NULL),
(3632, 'Grand Cay', 17, 'inactive', NULL, NULL, NULL),
(3633, 'Mayaguana District', 17, 'inactive', NULL, NULL, NULL),
(3634, 'San Juan Province', 11, 'inactive', NULL, NULL, NULL),
(3635, 'Santiago del Estero Province', 11, 'inactive', NULL, NULL, NULL),
(3636, 'San Luis Province', 11, 'inactive', NULL, NULL, NULL),
(3637, 'Tucumán Province', 11, 'inactive', NULL, NULL, NULL),
(3638, 'Corrientes', 11, 'inactive', NULL, NULL, NULL),
(3639, 'Río Negro Province', 11, 'inactive', NULL, NULL, NULL),
(3640, 'Chaco Province', 11, 'inactive', NULL, NULL, NULL),
(3641, 'Santa Fe Province', 11, 'inactive', NULL, NULL, NULL),
(3642, 'Córdoba Province', 11, 'inactive', NULL, NULL, NULL),
(3643, 'Salta Province', 11, 'inactive', NULL, NULL, NULL),
(3644, 'Misiones Province', 11, 'inactive', NULL, NULL, NULL),
(3645, 'Jujuy Province', 11, 'inactive', NULL, NULL, NULL),
(3646, 'Mendoza', 11, 'inactive', NULL, NULL, NULL),
(3647, 'Catamarca Province', 11, 'inactive', NULL, NULL, NULL),
(3648, 'Neuquén Province', 11, 'inactive', NULL, NULL, NULL),
(3649, 'Santa Cruz Province', 11, 'inactive', NULL, NULL, NULL),
(3650, 'Tierra del Fuego Province', 11, 'inactive', NULL, NULL, NULL),
(3651, 'Chubut Province', 11, 'inactive', NULL, NULL, NULL),
(3652, 'Formosa Province', 11, 'inactive', NULL, NULL, NULL),
(3653, 'La Rioja Province', 11, 'inactive', NULL, NULL, NULL),
(3654, 'Entre Ríos Province', 11, 'inactive', NULL, NULL, NULL),
(3655, 'La Pampa', 11, 'inactive', NULL, NULL, NULL),
(3656, 'Buenos Aires Province', 11, 'inactive', NULL, NULL, NULL),
(3657, 'Quiché Department', 90, 'inactive', NULL, NULL, NULL),
(3658, 'Jalapa Department', 90, 'inactive', NULL, NULL, NULL),
(3659, 'Izabal Department', 90, 'inactive', NULL, NULL, NULL),
(3660, 'Suchitepéquez Department', 90, 'inactive', NULL, NULL, NULL),
(3661, 'Sololá Department', 90, 'inactive', NULL, NULL, NULL),
(3662, 'El Progreso Department', 90, 'inactive', NULL, NULL, NULL),
(3663, 'Totonicapán Department', 90, 'inactive', NULL, NULL, NULL),
(3664, 'Retalhuleu Department', 90, 'inactive', NULL, NULL, NULL),
(3665, 'Santa Rosa Department', 90, 'inactive', NULL, NULL, NULL),
(3666, 'Chiquimula Department', 90, 'inactive', NULL, NULL, NULL),
(3667, 'San Marcos Department', 90, 'inactive', NULL, NULL, NULL),
(3668, 'Quetzaltenango Department', 90, 'inactive', NULL, NULL, NULL),
(3669, 'Petén Department', 90, 'inactive', NULL, NULL, NULL),
(3670, 'Huehuetenango Department', 90, 'inactive', NULL, NULL, NULL),
(3671, 'Alta Verapaz Department', 90, 'inactive', NULL, NULL, NULL),
(3672, 'Guatemala Department', 90, 'inactive', NULL, NULL, NULL),
(3673, 'Jutiapa Department', 90, 'inactive', NULL, NULL, NULL),
(3674, 'Baja Verapaz Department', 90, 'inactive', NULL, NULL, NULL),
(3675, 'Chimaltenango Department', 90, 'inactive', NULL, NULL, NULL),
(3676, 'Sacatepéquez Department', 90, 'inactive', NULL, NULL, NULL),
(3677, 'Escuintla Department', 90, 'inactive', NULL, NULL, NULL),
(3678, 'Madre de Dios', 173, 'inactive', NULL, NULL, NULL),
(3679, 'Huancavelica', 173, 'inactive', NULL, NULL, NULL),
(3680, 'Áncash', 173, 'inactive', NULL, NULL, NULL),
(3681, 'Arequipa', 173, 'inactive', NULL, NULL, NULL),
(3682, 'Puno', 173, 'inactive', NULL, NULL, NULL),
(3683, 'La Libertad', 173, 'inactive', NULL, NULL, NULL),
(3684, 'Ucayali', 173, 'inactive', NULL, NULL, NULL),
(3685, 'Amazonas', 173, 'inactive', NULL, NULL, NULL),
(3686, 'Pasco', 173, 'inactive', NULL, NULL, NULL),
(3687, 'Huanuco', 173, 'inactive', NULL, NULL, NULL),
(3688, 'Cajamarca', 173, 'inactive', NULL, NULL, NULL),
(3689, 'Tumbes', 173, 'inactive', NULL, NULL, NULL),
(3691, 'Cusco', 173, 'inactive', NULL, NULL, NULL),
(3692, 'Ayacucho', 173, 'inactive', NULL, NULL, NULL),
(3693, 'Junín', 173, 'inactive', NULL, NULL, NULL),
(3694, 'San Martín', 173, 'inactive', NULL, NULL, NULL),
(3695, 'Lima', 173, 'inactive', NULL, NULL, NULL),
(3696, 'Tacna', 173, 'inactive', NULL, NULL, NULL),
(3697, 'Piura', 173, 'inactive', NULL, NULL, NULL),
(3698, 'Moquegua', 173, 'inactive', NULL, NULL, NULL),
(3699, 'Apurímac', 173, 'inactive', NULL, NULL, NULL),
(3700, 'Ica', 173, 'inactive', NULL, NULL, NULL),
(3701, 'Callao', 173, 'inactive', NULL, NULL, NULL),
(3702, 'Lambayeque', 173, 'inactive', NULL, NULL, NULL),
(3703, 'Redonda', 10, 'inactive', NULL, NULL, NULL),
(3704, 'Saint Peter Parish', 10, 'inactive', NULL, NULL, NULL),
(3705, 'Saint Paul Parish', 10, 'inactive', NULL, NULL, NULL),
(3706, 'Saint John Parish', 10, 'inactive', NULL, NULL, NULL),
(3707, 'Saint Mary Parish', 10, 'inactive', NULL, NULL, NULL),
(3708, 'Barbuda', 10, 'inactive', NULL, NULL, NULL),
(3709, 'Saint George Parish', 10, 'inactive', NULL, NULL, NULL),
(3710, 'Saint Philip Parish', 10, 'inactive', NULL, NULL, NULL),
(3711, 'South Bačka District', 196, 'inactive', NULL, NULL, NULL),
(3712, 'Pirot District', 196, 'inactive', NULL, NULL, NULL),
(3713, 'South Banat District', 196, 'inactive', NULL, NULL, NULL),
(3714, 'North Bačka District', 196, 'inactive', NULL, NULL, NULL),
(3715, 'Jablanica District', 196, 'inactive', NULL, NULL, NULL),
(3716, 'Central Banat District', 196, 'inactive', NULL, NULL, NULL),
(3717, 'Bor District', 196, 'inactive', NULL, NULL, NULL),
(3718, 'Toplica District', 196, 'inactive', NULL, NULL, NULL),
(3719, 'Mačva District', 196, 'inactive', NULL, NULL, NULL),
(3720, 'Rasina District', 196, 'inactive', NULL, NULL, NULL),
(3721, 'Pčinja District', 196, 'inactive', NULL, NULL, NULL),
(3722, 'Nišava District', 196, 'inactive', NULL, NULL, NULL),
(3723, 'Prizren District', 248, 'inactive', NULL, NULL, NULL),
(3724, 'Kolubara District', 196, 'inactive', NULL, NULL, NULL),
(3725, 'Raška District', 196, 'inactive', NULL, NULL, NULL),
(3726, 'West Bačka District', 196, 'inactive', NULL, NULL, NULL),
(3727, 'Moravica District', 196, 'inactive', NULL, NULL, NULL),
(3728, 'Belgrade', 196, 'inactive', NULL, NULL, NULL),
(3729, 'Zlatibor District', 196, 'inactive', NULL, NULL, NULL),
(3731, 'Zaječar District', 196, 'inactive', NULL, NULL, NULL),
(3732, 'Braničevo District', 196, 'inactive', NULL, NULL, NULL),
(3733, 'Vojvodina', 196, 'inactive', NULL, NULL, NULL),
(3734, 'Šumadija District', 196, 'inactive', NULL, NULL, NULL),
(3736, 'North Banat District', 196, 'inactive', NULL, NULL, NULL),
(3737, 'Pomoravlje District', 196, 'inactive', NULL, NULL, NULL),
(3738, 'Peć District', 248, 'inactive', NULL, NULL, NULL),
(3740, 'Srem District', 196, 'inactive', NULL, NULL, NULL),
(3741, 'Podunavlje District', 196, 'inactive', NULL, NULL, NULL),
(3742, 'Westmoreland Parish', 108, 'inactive', NULL, NULL, NULL),
(3743, 'Saint Elizabeth Parish', 108, 'inactive', NULL, NULL, NULL),
(3744, 'Saint Ann Parish', 108, 'inactive', NULL, NULL, NULL),
(3745, 'Saint James Parish', 108, 'inactive', NULL, NULL, NULL),
(3746, 'Saint Catherine Parish', 108, 'inactive', NULL, NULL, NULL),
(3747, 'Saint Mary Parish', 108, 'inactive', NULL, NULL, NULL),
(3748, 'Kingston Parish', 108, 'inactive', NULL, NULL, NULL),
(3749, 'Hanover Parish', 108, 'inactive', NULL, NULL, NULL),
(3750, 'Saint Thomas Parish', 108, 'inactive', NULL, NULL, NULL),
(3751, 'Saint Andrew', 108, 'inactive', NULL, NULL, NULL),
(3752, 'Portland Parish', 108, 'inactive', NULL, NULL, NULL),
(3753, 'Clarendon Parish', 108, 'inactive', NULL, NULL, NULL),
(3754, 'Manchester Parish', 108, 'inactive', NULL, NULL, NULL),
(3755, 'Trelawny Parish', 108, 'inactive', NULL, NULL, NULL),
(3756, 'Dennery Quarter', 186, 'inactive', NULL, NULL, NULL),
(3757, 'Anse la Raye Quarter', 186, 'inactive', NULL, NULL, NULL),
(3758, 'Castries Quarter', 186, 'inactive', NULL, NULL, NULL),
(3759, 'Laborie Quarter', 186, 'inactive', NULL, NULL, NULL),
(3760, 'Choiseul Quarter', 186, 'inactive', NULL, NULL, NULL),
(3761, 'Canaries', 186, 'inactive', NULL, NULL, NULL),
(3762, 'Micoud Quarter', 186, 'inactive', NULL, NULL, NULL),
(3763, 'Vieux Fort Quarter', 186, 'inactive', NULL, NULL, NULL),
(3764, 'Soufrière Quarter', 186, 'inactive', NULL, NULL, NULL),
(3765, 'Praslin Quarter', 186, 'inactive', NULL, NULL, NULL),
(3766, 'Gros Islet Quarter', 186, 'inactive', NULL, NULL, NULL),
(3767, 'Dauphin Quarter', 186, 'inactive', NULL, NULL, NULL),
(3768, 'Hưng Yên', 240, 'inactive', NULL, NULL, NULL),
(3769, 'Đồng Tháp', 240, 'inactive', NULL, NULL, NULL),
(3770, 'Bà Rịa-Vũng Tàu', 240, 'inactive', NULL, NULL, NULL),
(3771, 'Thanh Hóa', 240, 'inactive', NULL, NULL, NULL),
(3772, 'Kon Tum', 240, 'inactive', NULL, NULL, NULL),
(3773, 'Điện Biên', 240, 'inactive', NULL, NULL, NULL),
(3774, 'Vĩnh Phúc', 240, 'inactive', NULL, NULL, NULL),
(3775, 'Thái Bình', 240, 'inactive', NULL, NULL, NULL),
(3776, 'Quảng Nam', 240, 'inactive', NULL, NULL, NULL),
(3777, 'Hậu Giang', 240, 'inactive', NULL, NULL, NULL),
(3778, 'Cà Mau', 240, 'inactive', NULL, NULL, NULL),
(3779, 'Hà Giang', 240, 'inactive', NULL, NULL, NULL),
(3780, 'Nghệ An', 240, 'inactive', NULL, NULL, NULL),
(3781, 'Tiền Giang', 240, 'inactive', NULL, NULL, NULL),
(3782, 'Cao Bằng', 240, 'inactive', NULL, NULL, NULL),
(3783, 'Haiphong', 240, 'inactive', NULL, NULL, NULL),
(3784, 'Yên Bái', 240, 'inactive', NULL, NULL, NULL),
(3785, 'Bình Dương', 240, 'inactive', NULL, NULL, NULL),
(3786, 'Ninh Bình', 240, 'inactive', NULL, NULL, NULL),
(3787, 'Bình Thuận', 240, 'inactive', NULL, NULL, NULL),
(3788, 'Ninh Thuận', 240, 'inactive', NULL, NULL, NULL),
(3789, 'Nam Định', 240, 'inactive', NULL, NULL, NULL),
(3790, 'Vĩnh Long', 240, 'inactive', NULL, NULL, NULL),
(3791, 'Bắc Ninh', 240, 'inactive', NULL, NULL, NULL),
(3792, 'Lạng Sơn', 240, 'inactive', NULL, NULL, NULL),
(3793, 'Khánh Hòa', 240, 'inactive', NULL, NULL, NULL),
(3794, 'An Giang', 240, 'inactive', NULL, NULL, NULL),
(3795, 'Tuyên Quang', 240, 'inactive', NULL, NULL, NULL),
(3796, 'Bến Tre', 240, 'inactive', NULL, NULL, NULL),
(3797, 'Bình Phước', 240, 'inactive', NULL, NULL, NULL),
(3798, 'Thừa Thiên-Huế', 240, 'inactive', NULL, NULL, NULL),
(3799, 'Hòa Bình', 240, 'inactive', NULL, NULL, NULL),
(3800, 'Kiên Giang', 240, 'inactive', NULL, NULL, NULL),
(3801, 'Phú Thọ', 240, 'inactive', NULL, NULL, NULL),
(3802, 'Hà Nam', 240, 'inactive', NULL, NULL, NULL),
(3803, 'Quảng Trị', 240, 'inactive', NULL, NULL, NULL),
(3804, 'Bạc Liêu', 240, 'inactive', NULL, NULL, NULL),
(3805, 'Trà Vinh', 240, 'inactive', NULL, NULL, NULL),
(3806, 'Da Nang', 240, 'inactive', NULL, NULL, NULL),
(3807, 'Thái Nguyên', 240, 'inactive', NULL, NULL, NULL),
(3808, 'Long An', 240, 'inactive', NULL, NULL, NULL),
(3809, 'Quảng Bình', 240, 'inactive', NULL, NULL, NULL),
(3810, 'Hanoi', 240, 'inactive', NULL, NULL, NULL),
(3811, 'Ho Chi Minh City', 240, 'inactive', NULL, NULL, NULL),
(3812, 'Sơn La', 240, 'inactive', NULL, NULL, NULL),
(3813, 'Gia Lai', 240, 'inactive', NULL, NULL, NULL),
(3814, 'Quảng Ninh', 240, 'inactive', NULL, NULL, NULL),
(3815, 'Bắc Giang', 240, 'inactive', NULL, NULL, NULL),
(3816, 'Hà Tĩnh', 240, 'inactive', NULL, NULL, NULL),
(3817, 'Lào Cai', 240, 'inactive', NULL, NULL, NULL),
(3818, 'Lâm Đồng', 240, 'inactive', NULL, NULL, NULL),
(3819, 'Sóc Trăng', 240, 'inactive', NULL, NULL, NULL),
(3820, 'Hà Tây', 240, 'inactive', NULL, NULL, NULL),
(3821, 'Đồng Nai', 240, 'inactive', NULL, NULL, NULL),
(3822, 'Bắc Kạn', 240, 'inactive', NULL, NULL, NULL),
(3823, 'Đắk Nông', 240, 'inactive', NULL, NULL, NULL),
(3824, 'Phú Yên', 240, 'inactive', NULL, NULL, NULL),
(3825, 'Lai Châu', 240, 'inactive', NULL, NULL, NULL),
(3826, 'Tây Ninh', 240, 'inactive', NULL, NULL, NULL),
(3827, 'Hải Dương', 240, 'inactive', NULL, NULL, NULL),
(3828, 'Quảng Ngãi', 240, 'inactive', NULL, NULL, NULL),
(3829, 'Đắk Lắk', 240, 'inactive', NULL, NULL, NULL),
(3830, 'Bình Định', 240, 'inactive', NULL, NULL, NULL),
(3831, 'Saint Peter Basseterre Parish', 185, 'inactive', NULL, NULL, NULL),
(3832, 'Nevis', 185, 'inactive', NULL, NULL, NULL),
(3833, 'Christ Church Nichola Town Parish', 185, 'inactive', NULL, NULL, NULL),
(3834, 'Saint Paul Capisterre Parish', 185, 'inactive', NULL, NULL, NULL),
(3835, 'Saint James Windward Parish', 185, 'inactive', NULL, NULL, NULL),
(3836, 'Saint Anne Sandy Point Parish', 185, 'inactive', NULL, NULL, NULL),
(3837, 'Saint George Gingerland Parish', 185, 'inactive', NULL, NULL, NULL),
(3838, 'Saint Paul Charlestown Parish', 185, 'inactive', NULL, NULL, NULL),
(3839, 'Saint Thomas Lowland Parish', 185, 'inactive', NULL, NULL, NULL),
(3840, 'Saint John Figtree Parish', 185, 'inactive', NULL, NULL, NULL),
(3841, 'Saint Kitts', 185, 'inactive', NULL, NULL, NULL),
(3842, 'Saint Thomas Middle Island Parish', 185, 'inactive', NULL, NULL, NULL),
(3843, 'Trinity Palmetto Point Parish', 185, 'inactive', NULL, NULL, NULL),
(3844, 'Saint Mary Cayon Parish', 185, 'inactive', NULL, NULL, NULL),
(3845, 'Saint John Capisterre Parish', 185, 'inactive', NULL, NULL, NULL),
(3846, 'Daegu', 116, 'inactive', NULL, NULL, NULL),
(3847, 'Gyeonggi Province', 116, 'inactive', NULL, NULL, NULL),
(3848, 'Incheon', 116, 'inactive', NULL, NULL, NULL),
(3849, 'Seoul', 116, 'inactive', NULL, NULL, NULL),
(3850, 'Daejeon', 116, 'inactive', NULL, NULL, NULL),
(3851, 'North Jeolla Province', 116, 'inactive', NULL, NULL, NULL),
(3852, 'Ulsan', 116, 'inactive', NULL, NULL, NULL),
(3853, 'Jeju', 116, 'inactive', NULL, NULL, NULL),
(3854, 'North Chungcheong Province', 116, 'inactive', NULL, NULL, NULL),
(3855, 'North Gyeongsang Province', 116, 'inactive', NULL, NULL, NULL),
(3856, 'South Jeolla Province', 116, 'inactive', NULL, NULL, NULL),
(3857, 'South Gyeongsang Province', 116, 'inactive', NULL, NULL, NULL),
(3858, 'Gwangju', 116, 'inactive', NULL, NULL, NULL),
(3859, 'South Chungcheong Province', 116, 'inactive', NULL, NULL, NULL),
(3860, 'Busan', 116, 'inactive', NULL, NULL, NULL),
(3861, 'Sejong City', 116, 'inactive', NULL, NULL, NULL),
(3862, 'Gangwon Province', 116, 'inactive', NULL, NULL, NULL),
(3863, 'Saint Patrick Parish', 87, 'inactive', NULL, NULL, NULL),
(3864, 'Saint George Parish', 87, 'inactive', NULL, NULL, NULL),
(3865, 'Saint Andrew Parish', 87, 'inactive', NULL, NULL, NULL),
(3866, 'Saint Mark Parish', 87, 'inactive', NULL, NULL, NULL),
(3867, 'Carriacou and Petite Martinique', 87, 'inactive', NULL, NULL, NULL),
(3868, 'Saint John Parish', 87, 'inactive', NULL, NULL, NULL),
(3869, 'Saint David Parish', 87, 'inactive', NULL, NULL, NULL),
(3870, 'Ghazni', 1, 'inactive', NULL, NULL, NULL),
(3871, 'Badghis', 1, 'inactive', NULL, NULL, NULL),
(3872, 'Bamyan', 1, 'inactive', NULL, NULL, NULL),
(3873, 'Helmand', 1, 'inactive', NULL, NULL, NULL),
(3874, 'Zabul', 1, 'inactive', NULL, NULL, NULL),
(3875, 'Baghlan', 1, 'inactive', NULL, NULL, NULL),
(3876, 'Kunar', 1, 'inactive', NULL, NULL, NULL),
(3877, 'Paktika', 1, 'inactive', NULL, NULL, NULL),
(3878, 'Khost', 1, 'inactive', NULL, NULL, NULL),
(3879, 'Kapisa', 1, 'inactive', NULL, NULL, NULL),
(3880, 'Nuristan', 1, 'inactive', NULL, NULL, NULL),
(3881, 'Panjshir', 1, 'inactive', NULL, NULL, NULL),
(3882, 'Nangarhar', 1, 'inactive', NULL, NULL, NULL),
(3883, 'Samangan', 1, 'inactive', NULL, NULL, NULL),
(3884, 'Balkh', 1, 'inactive', NULL, NULL, NULL),
(3885, 'Sar-e Pol', 1, 'inactive', NULL, NULL, NULL),
(3886, 'Jowzjan', 1, 'inactive', NULL, NULL, NULL),
(3887, 'Herat', 1, 'inactive', NULL, NULL, NULL),
(3888, 'Ghōr', 1, 'inactive', NULL, NULL, NULL),
(3889, 'Faryab', 1, 'inactive', NULL, NULL, NULL),
(3890, 'Kandahar', 1, 'inactive', NULL, NULL, NULL),
(3891, 'Laghman', 1, 'inactive', NULL, NULL, NULL),
(3892, 'Daykundi', 1, 'inactive', NULL, NULL, NULL),
(3893, 'Takhar', 1, 'inactive', NULL, NULL, NULL),
(3894, 'Paktia', 1, 'inactive', NULL, NULL, NULL),
(3895, 'Parwan', 1, 'inactive', NULL, NULL, NULL),
(3896, 'Nimruz', 1, 'inactive', NULL, NULL, NULL),
(3897, 'Logar', 1, 'inactive', NULL, NULL, NULL),
(3898, 'Urozgan', 1, 'inactive', NULL, NULL, NULL),
(3899, 'Farah', 1, 'inactive', NULL, NULL, NULL),
(3900, 'Kunduz Province', 1, 'inactive', NULL, NULL, NULL),
(3901, 'Badakhshan', 1, 'inactive', NULL, NULL, NULL),
(3902, 'Kabul', 1, 'inactive', NULL, NULL, NULL),
(3903, 'Victoria', 14, 'inactive', NULL, NULL, NULL),
(3904, 'South Australia', 14, 'inactive', NULL, NULL, NULL),
(3905, 'Queensland', 14, 'inactive', NULL, NULL, NULL),
(3906, 'Western Australia', 14, 'inactive', NULL, NULL, NULL),
(3907, 'Australian Capital Territory', 14, 'inactive', NULL, NULL, NULL),
(3908, 'Tasmania', 14, 'inactive', NULL, NULL, NULL),
(3909, 'New South Wales', 14, 'inactive', NULL, NULL, NULL),
(3910, 'Northern Territory', 14, 'inactive', NULL, NULL, NULL),
(3911, 'Vavaʻu', 222, 'inactive', NULL, NULL, NULL),
(3912, 'Tongatapu', 222, 'inactive', NULL, NULL, NULL),
(3913, 'Haʻapai', 222, 'inactive', NULL, NULL, NULL),
(3914, 'Niuas', 222, 'inactive', NULL, NULL, NULL),
(3915, 'ʻEua', 222, 'inactive', NULL, NULL, NULL),
(3916, 'Markazi Province', 103, 'inactive', NULL, NULL, NULL),
(3917, 'Khuzestan Province', 103, 'inactive', NULL, NULL, NULL),
(3918, 'Ilam Province', 103, 'inactive', NULL, NULL, NULL),
(3919, 'Kermanshah Province', 103, 'inactive', NULL, NULL, NULL),
(3920, 'Gilan Province', 103, 'inactive', NULL, NULL, NULL),
(3921, 'Chaharmahal and Bakhtiari Province', 103, 'inactive', NULL, NULL, NULL),
(3922, 'Qom Province', 103, 'inactive', NULL, NULL, NULL),
(3923, 'Isfahan Province', 103, 'inactive', NULL, NULL, NULL),
(3924, 'West Azarbaijan Province', 103, 'inactive', NULL, NULL, NULL),
(3925, 'Zanjan Province', 103, 'inactive', NULL, NULL, NULL),
(3926, 'Kohgiluyeh and Boyer-Ahmad Province', 103, 'inactive', NULL, NULL, NULL),
(3927, 'Razavi Khorasan Province', 103, 'inactive', NULL, NULL, NULL),
(3928, 'Lorestan Province', 103, 'inactive', NULL, NULL, NULL),
(3929, 'Alborz Province', 103, 'inactive', NULL, NULL, NULL),
(3930, 'South Khorasan Province', 103, 'inactive', NULL, NULL, NULL),
(3931, 'Sistan and Baluchestan', 103, 'inactive', NULL, NULL, NULL),
(3932, 'Bushehr Province', 103, 'inactive', NULL, NULL, NULL),
(3933, 'Golestan Province', 103, 'inactive', NULL, NULL, NULL),
(3934, 'Ardabil Province', 103, 'inactive', NULL, NULL, NULL),
(3935, 'Kurdistan Province', 103, 'inactive', NULL, NULL, NULL),
(3936, 'Yazd Province', 103, 'inactive', NULL, NULL, NULL),
(3937, 'Hormozgan Province', 103, 'inactive', NULL, NULL, NULL),
(3938, 'Mazandaran Province', 103, 'inactive', NULL, NULL, NULL),
(3939, 'Fars Province', 103, 'inactive', NULL, NULL, NULL),
(3940, 'Semnan Province', 103, 'inactive', NULL, NULL, NULL),
(3941, 'Qazvin Province', 103, 'inactive', NULL, NULL, NULL),
(3942, 'North Khorasan Province', 103, 'inactive', NULL, NULL, NULL),
(3943, 'Kerman Province', 103, 'inactive', NULL, NULL, NULL),
(3944, 'East Azerbaijan Province', 103, 'inactive', NULL, NULL, NULL),
(3945, 'Tehran Province', 103, 'inactive', NULL, NULL, NULL),
(3946, 'Niutao Island Council', 228, 'inactive', NULL, NULL, NULL),
(3947, 'Nanumanga', 228, 'inactive', NULL, NULL, NULL),
(3948, 'Nui', 228, 'inactive', NULL, NULL, NULL),
(3949, 'Nanumea', 228, 'inactive', NULL, NULL, NULL),
(3950, 'Vaitupu', 228, 'inactive', NULL, NULL, NULL),
(3951, 'Funafuti', 228, 'inactive', NULL, NULL, NULL),
(3952, 'Nukufetau', 228, 'inactive', NULL, NULL, NULL),
(3953, 'Nukulaelae', 228, 'inactive', NULL, NULL, NULL),
(3954, 'Dhi Qar Governorate', 104, 'inactive', NULL, NULL, NULL),
(3955, 'Babylon Governorate', 104, 'inactive', NULL, NULL, NULL),
(3956, 'Al-Qādisiyyah Governorate', 104, 'inactive', NULL, NULL, NULL),
(3957, 'Karbala Governorate', 104, 'inactive', NULL, NULL, NULL),
(3958, 'Al Muthanna Governorate', 104, 'inactive', NULL, NULL, NULL),
(3959, 'Baghdad Governorate', 104, 'inactive', NULL, NULL, NULL),
(3960, 'Basra Governorate', 104, 'inactive', NULL, NULL, NULL),
(3961, 'Saladin Governorate', 104, 'inactive', NULL, NULL, NULL),
(3962, 'Najaf Governorate', 104, 'inactive', NULL, NULL, NULL),
(3963, 'Nineveh Governorate', 104, 'inactive', NULL, NULL, NULL),
(3964, 'Al Anbar Governorate', 104, 'inactive', NULL, NULL, NULL),
(3965, 'Diyala Governorate', 104, 'inactive', NULL, NULL, NULL),
(3966, 'Maysan Governorate', 104, 'inactive', NULL, NULL, NULL),
(3967, 'Dohuk Governorate', 104, 'inactive', NULL, NULL, NULL),
(3968, 'Erbil Governorate', 104, 'inactive', NULL, NULL, NULL),
(3969, 'Sulaymaniyah Governorate', 104, 'inactive', NULL, NULL, NULL),
(3970, 'Wasit Governorate', 104, 'inactive', NULL, NULL, NULL),
(3971, 'Kirkuk Governorate', 104, 'inactive', NULL, NULL, NULL),
(3972, 'Svay Rieng Province', 37, 'inactive', NULL, NULL, NULL),
(3973, 'Preah Vihear Province', 37, 'inactive', NULL, NULL, NULL),
(3974, 'Prey Veng Province', 37, 'inactive', NULL, NULL, NULL),
(3975, 'Takéo Province', 37, 'inactive', NULL, NULL, NULL),
(3976, 'Battambang Province', 37, 'inactive', NULL, NULL, NULL),
(3977, 'Pursat Province', 37, 'inactive', NULL, NULL, NULL),
(3978, 'Kep Province', 37, 'inactive', NULL, NULL, NULL),
(3979, 'Kampong Chhnang Province', 37, 'inactive', NULL, NULL, NULL),
(3980, 'Pailin Province', 37, 'inactive', NULL, NULL, NULL),
(3981, 'Kampot Province', 37, 'inactive', NULL, NULL, NULL),
(3982, 'Koh Kong Province', 37, 'inactive', NULL, NULL, NULL),
(3983, 'Kandal Province', 37, 'inactive', NULL, NULL, NULL),
(3984, 'Banteay Meanchey Province', 37, 'inactive', NULL, NULL, NULL),
(3985, 'Mondulkiri Province', 37, 'inactive', NULL, NULL, NULL),
(3986, 'Kratié Province', 37, 'inactive', NULL, NULL, NULL),
(3987, 'Oddar Meanchey Province', 37, 'inactive', NULL, NULL, NULL),
(3988, 'Kampong Speu Province', 37, 'inactive', NULL, NULL, NULL),
(3989, 'Sihanoukville Province', 37, 'inactive', NULL, NULL, NULL),
(3990, 'Ratanakiri Province', 37, 'inactive', NULL, NULL, NULL),
(3991, 'Kampong Cham Province', 37, 'inactive', NULL, NULL, NULL),
(3992, 'Siem Reap Province', 37, 'inactive', NULL, NULL, NULL),
(3993, 'Stung Treng Province', 37, 'inactive', NULL, NULL, NULL),
(3994, 'Phnom Penh', 37, 'inactive', NULL, NULL, NULL),
(3995, 'North Hamgyong Province', 115, 'inactive', NULL, NULL, NULL),
(3996, 'Ryanggang Province', 115, 'inactive', NULL, NULL, NULL),
(3997, 'South Pyongan Province', 115, 'inactive', NULL, NULL, NULL),
(3998, 'Chagang Province', 115, 'inactive', NULL, NULL, NULL),
(3999, 'Kangwon Province', 115, 'inactive', NULL, NULL, NULL),
(4000, 'South Hamgyong Province', 115, 'inactive', NULL, NULL, NULL),
(4001, 'Rason', 115, 'inactive', NULL, NULL, NULL),
(4002, 'North Pyongan Province', 115, 'inactive', NULL, NULL, NULL),
(4003, 'South Hwanghae Province', 115, 'inactive', NULL, NULL, NULL),
(4004, 'North Hwanghae Province', 115, 'inactive', NULL, NULL, NULL),
(4005, 'Pyongyang', 115, 'inactive', NULL, NULL, NULL),
(4006, 'Meghalaya', 101, 'inactive', NULL, NULL, NULL),
(4007, 'Haryana', 101, 'inactive', NULL, NULL, NULL),
(4008, 'Maharashtra', 101, 'inactive', NULL, NULL, NULL),
(4009, 'Goa', 101, 'inactive', NULL, NULL, NULL),
(4010, 'Manipur', 101, 'inactive', NULL, NULL, NULL),
(4011, 'Puducherry', 101, 'inactive', NULL, NULL, NULL),
(4012, 'Telangana', 101, 'inactive', NULL, NULL, NULL),
(4013, 'Odisha', 101, 'inactive', NULL, NULL, NULL),
(4014, 'Rajasthan', 101, 'inactive', NULL, NULL, NULL),
(4015, 'Punjab', 101, 'inactive', NULL, NULL, NULL),
(4016, 'Uttarakhand', 101, 'inactive', NULL, NULL, NULL),
(4017, 'Andhra Pradesh', 101, 'inactive', NULL, NULL, NULL),
(4018, 'Nagaland', 101, 'inactive', NULL, NULL, NULL),
(4019, 'Lakshadweep', 101, 'inactive', NULL, NULL, NULL),
(4020, 'Himachal Pradesh', 101, 'inactive', NULL, NULL, NULL),
(4021, 'Delhi', 101, 'inactive', NULL, NULL, NULL),
(4022, 'Uttar Pradesh', 101, 'inactive', NULL, NULL, NULL),
(4023, 'Andaman and Nicobar Islands', 101, 'inactive', NULL, NULL, NULL),
(4024, 'Arunachal Pradesh', 101, 'inactive', NULL, NULL, NULL),
(4025, 'Jharkhand', 101, 'inactive', NULL, NULL, NULL),
(4026, 'Karnataka', 101, 'inactive', NULL, NULL, NULL),
(4027, 'Assam', 101, 'inactive', NULL, NULL, NULL),
(4028, 'Kerala', 101, 'inactive', NULL, NULL, NULL),
(4029, 'Jammu and Kashmir', 101, 'inactive', NULL, NULL, NULL),
(4030, 'Gujarat', 101, 'inactive', NULL, NULL, NULL),
(4031, 'Chandigarh', 101, 'inactive', NULL, NULL, NULL),
(4032, 'Dadra and Nagar Haveli', 101, 'inactive', NULL, NULL, NULL),
(4033, 'Daman and Diu', 101, 'inactive', NULL, NULL, NULL),
(4034, 'Sikkim', 101, 'inactive', NULL, NULL, NULL),
(4035, 'Tamil Nadu', 101, 'inactive', NULL, NULL, NULL),
(4036, 'Mizoram', 101, 'inactive', NULL, NULL, NULL),
(4037, 'Bihar', 101, 'inactive', NULL, NULL, NULL),
(4038, 'Tripura', 101, 'inactive', NULL, NULL, NULL),
(4039, 'Madhya Pradesh', 101, 'inactive', NULL, NULL, NULL),
(4040, 'Chhattisgarh', 101, 'inactive', NULL, NULL, NULL),
(4041, 'Choluteca Department', 97, 'inactive', NULL, NULL, NULL),
(4042, 'Comayagua Department', 97, 'inactive', NULL, NULL, NULL),
(4043, 'El Paraíso Department', 97, 'inactive', NULL, NULL, NULL),
(4044, 'Intibucá Department', 97, 'inactive', NULL, NULL, NULL),
(4045, 'Bay Islands Department', 97, 'inactive', NULL, NULL, NULL),
(4046, 'Cortés Department', 97, 'inactive', NULL, NULL, NULL),
(4047, 'Atlántida Department', 97, 'inactive', NULL, NULL, NULL),
(4048, 'Gracias a Dios Department', 97, 'inactive', NULL, NULL, NULL),
(4049, 'Copán Department', 97, 'inactive', NULL, NULL, NULL),
(4050, 'Olancho Department', 97, 'inactive', NULL, NULL, NULL),
(4051, 'Colón Department', 97, 'inactive', NULL, NULL, NULL),
(4052, 'Francisco Morazán Department', 97, 'inactive', NULL, NULL, NULL),
(4053, 'Santa Bárbara Department', 97, 'inactive', NULL, NULL, NULL),
(4054, 'Lempira Department', 97, 'inactive', NULL, NULL, NULL),
(4055, 'Valle Department', 97, 'inactive', NULL, NULL, NULL),
(4056, 'Ocotepeque Department', 97, 'inactive', NULL, NULL, NULL),
(4057, 'Yoro Department', 97, 'inactive', NULL, NULL, NULL),
(4058, 'La Paz Department', 97, 'inactive', NULL, NULL, NULL),
(4059, 'Northland Region', 158, 'inactive', NULL, NULL, NULL),
(4060, 'Manawatu-Wanganui Region', 158, 'inactive', NULL, NULL, NULL),
(4061, 'Waikato Region', 158, 'inactive', NULL, NULL, NULL),
(4062, 'Otago Region', 158, 'inactive', NULL, NULL, NULL),
(4063, 'Marlborough Region', 158, 'inactive', NULL, NULL, NULL),
(4064, 'West Coast Region', 158, 'inactive', NULL, NULL, NULL),
(4065, 'Wellington Region', 158, 'inactive', NULL, NULL, NULL),
(4066, 'Canterbury Region', 158, 'inactive', NULL, NULL, NULL),
(4067, 'Chatham Islands', 158, 'inactive', NULL, NULL, NULL),
(4068, 'Gisborne District', 158, 'inactive', NULL, NULL, NULL),
(4069, 'Taranaki Region', 158, 'inactive', NULL, NULL, NULL),
(4070, 'Nelson Region', 158, 'inactive', NULL, NULL, NULL),
(4071, 'Southland Region', 158, 'inactive', NULL, NULL, NULL),
(4072, 'Auckland Region', 158, 'inactive', NULL, NULL, NULL),
(4073, 'Tasman District', 158, 'inactive', NULL, NULL, NULL),
(4074, 'Bay of Plenty Region', 158, 'inactive', NULL, NULL, NULL),
(4075, 'Hawke\'s Bay Region', 158, 'inactive', NULL, NULL, NULL),
(4076, 'Saint John Parish', 61, 'inactive', NULL, NULL, NULL),
(4077, 'Saint Mark Parish', 61, 'inactive', NULL, NULL, NULL),
(4078, 'Saint David Parish', 61, 'inactive', NULL, NULL, NULL),
(4079, 'Saint George Parish', 61, 'inactive', NULL, NULL, NULL),
(4080, 'Saint Patrick Parish', 61, 'inactive', NULL, NULL, NULL),
(4081, 'Saint Peter Parish', 61, 'inactive', NULL, NULL, NULL),
(4082, 'Saint Andrew Parish', 61, 'inactive', NULL, NULL, NULL),
(4083, 'Saint Luke Parish', 61, 'inactive', NULL, NULL, NULL),
(4084, 'Saint Paul Parish', 61, 'inactive', NULL, NULL, NULL),
(4085, 'Saint Joseph Parish', 61, 'inactive', NULL, NULL, NULL),
(4086, 'El Seibo Province', 62, 'inactive', NULL, NULL, NULL),
(4087, 'La Romana Province', 62, 'inactive', NULL, NULL, NULL),
(4088, 'Sánchez Ramírez Province', 62, 'inactive', NULL, NULL, NULL),
(4089, 'Hermanas Mirabal Province', 62, 'inactive', NULL, NULL, NULL),
(4090, 'Barahona Province', 62, 'inactive', NULL, NULL, NULL),
(4091, 'San Cristóbal Province', 62, 'inactive', NULL, NULL, NULL),
(4092, 'Puerto Plata Province', 62, 'inactive', NULL, NULL, NULL),
(4093, 'Santo Domingo Province', 62, 'inactive', NULL, NULL, NULL),
(4094, 'María Trinidad Sánchez Province', 62, 'inactive', NULL, NULL, NULL),
(4095, 'Distrito Nacional', 62, 'inactive', NULL, NULL, NULL),
(4096, 'Peravia Province', 62, 'inactive', NULL, NULL, NULL),
(4097, 'Independencia', 62, 'inactive', NULL, NULL, NULL),
(4098, 'San Juan Province', 62, 'inactive', NULL, NULL, NULL),
(4099, 'Monseñor Nouel Province', 62, 'inactive', NULL, NULL, NULL),
(4100, 'Santiago Rodríguez Province', 62, 'inactive', NULL, NULL, NULL),
(4101, 'Pedernales Province', 62, 'inactive', NULL, NULL, NULL),
(4102, 'Espaillat Province', 62, 'inactive', NULL, NULL, NULL),
(4103, 'Samaná Province', 62, 'inactive', NULL, NULL, NULL),
(4104, 'Valverde Province', 62, 'inactive', NULL, NULL, NULL),
(4105, 'Baoruco Province', 62, 'inactive', NULL, NULL, NULL),
(4106, 'Hato Mayor Province', 62, 'inactive', NULL, NULL, NULL),
(4107, 'Dajabón Province', 62, 'inactive', NULL, NULL, NULL),
(4108, 'Santiago Province', 62, 'inactive', NULL, NULL, NULL),
(4109, 'La Altagracia Province', 62, 'inactive', NULL, NULL, NULL),
(4110, 'San Pedro de Macorís', 62, 'inactive', NULL, NULL, NULL),
(4111, 'Monte Plata Province', 62, 'inactive', NULL, NULL, NULL),
(4112, 'San José de Ocoa Province', 62, 'inactive', NULL, NULL, NULL),
(4113, 'Duarte Province', 62, 'inactive', NULL, NULL, NULL),
(4114, 'Azua Province', 62, 'inactive', NULL, NULL, NULL),
(4115, 'Monte Cristi Province', 62, 'inactive', NULL, NULL, NULL),
(4116, 'La Vega Province', 62, 'inactive', NULL, NULL, NULL),
(4117, 'Nord', 95, 'inactive', NULL, NULL, NULL),
(4118, 'Nippes', 95, 'inactive', NULL, NULL, NULL),
(4119, 'Grand\'Anse', 95, 'inactive', NULL, NULL, NULL),
(4120, 'Ouest', 95, 'inactive', NULL, NULL, NULL),
(4121, 'Nord-Est', 95, 'inactive', NULL, NULL, NULL),
(4122, 'Sud', 95, 'inactive', NULL, NULL, NULL),
(4123, 'Artibonite', 95, 'inactive', NULL, NULL, NULL),
(4124, 'Sud-Est', 95, 'inactive', NULL, NULL, NULL),
(4125, 'Centre', 95, 'inactive', NULL, NULL, NULL),
(4126, 'Nord-Ouest', 95, 'inactive', NULL, NULL, NULL),
(4127, 'San Vicente Department', 66, 'inactive', NULL, NULL, NULL),
(4128, 'Santa Ana Department', 66, 'inactive', NULL, NULL, NULL),
(4129, 'Usulután Department', 66, 'inactive', NULL, NULL, NULL),
(4130, 'Morazán Department', 66, 'inactive', NULL, NULL, NULL),
(4131, 'Chalatenango Department', 66, 'inactive', NULL, NULL, NULL),
(4132, 'Cabañas Department', 66, 'inactive', NULL, NULL, NULL),
(4133, 'San Salvador Department', 66, 'inactive', NULL, NULL, NULL),
(4134, 'La Libertad Department', 66, 'inactive', NULL, NULL, NULL),
(4135, 'San Miguel Department', 66, 'inactive', NULL, NULL, NULL),
(4136, 'La Paz Department', 66, 'inactive', NULL, NULL, NULL),
(4137, 'Cuscatlán Department', 66, 'inactive', NULL, NULL, NULL),
(4138, 'La Unión Department', 66, 'inactive', NULL, NULL, NULL),
(4139, 'Ahuachapán Department', 66, 'inactive', NULL, NULL, NULL),
(4140, 'Sonsonate Department', 66, 'inactive', NULL, NULL, NULL),
(4141, 'Braslovče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4142, 'Lenart Municipality', 201, 'inactive', NULL, NULL, NULL),
(4143, 'Oplotnica', 201, 'inactive', NULL, NULL, NULL),
(4144, 'Velike Lašče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4145, 'Hajdina Municipality', 201, 'inactive', NULL, NULL, NULL),
(4146, 'Podčetrtek Municipality', 201, 'inactive', NULL, NULL, NULL),
(4147, 'Cankova Municipality', 201, 'inactive', NULL, NULL, NULL),
(4148, 'Vitanje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4149, 'Sežana Municipality', 201, 'inactive', NULL, NULL, NULL),
(4150, 'Kidričevo Municipality', 201, 'inactive', NULL, NULL, NULL),
(4151, 'Črenšovci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4152, 'Idrija Municipality', 201, 'inactive', NULL, NULL, NULL),
(4153, 'Trnovska Vas Municipality', 201, 'inactive', NULL, NULL, NULL),
(4154, 'Vodice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4155, 'Ravne na Koroškem Municipality', 201, 'inactive', NULL, NULL, NULL),
(4156, 'Lovrenc na Pohorju Municipality', 201, 'inactive', NULL, NULL, NULL),
(4157, 'Majšperk Municipality', 201, 'inactive', NULL, NULL, NULL),
(4158, 'Loški Potok Municipality', 201, 'inactive', NULL, NULL, NULL),
(4159, 'Domžale Municipality', 201, 'inactive', NULL, NULL, NULL),
(4160, 'Rečica ob Savinji Municipality', 201, 'inactive', NULL, NULL, NULL),
(4161, 'Podlehnik Municipality', 201, 'inactive', NULL, NULL, NULL),
(4162, 'Cerknica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4163, 'Vransko Municipality', 201, 'inactive', NULL, NULL, NULL),
(4164, 'Sveta Ana Municipality', 201, 'inactive', NULL, NULL, NULL),
(4165, 'Brezovica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4166, 'Benedikt Municipality', 201, 'inactive', NULL, NULL, NULL),
(4167, 'Divača Municipality', 201, 'inactive', NULL, NULL, NULL),
(4168, 'Moravče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4169, 'Slovenj Gradec City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4170, 'Škocjan Municipality', 201, 'inactive', NULL, NULL, NULL),
(4171, 'Šentjur Municipality', 201, 'inactive', NULL, NULL, NULL),
(4172, 'Pesnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4173, 'Dol pri Ljubljani Municipality', 201, 'inactive', NULL, NULL, NULL),
(4174, 'Loška Dolina Municipality', 201, 'inactive', NULL, NULL, NULL),
(4175, 'Hoče–Slivnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4176, 'Cerkvenjak Municipality', 201, 'inactive', NULL, NULL, NULL),
(4177, 'Naklo Municipality', 201, 'inactive', NULL, NULL, NULL),
(4178, 'Cerkno Municipality', 201, 'inactive', NULL, NULL, NULL),
(4179, 'Bistrica ob Sotli Municipality', 201, 'inactive', NULL, NULL, NULL),
(4180, 'Kamnik Municipality', 201, 'inactive', NULL, NULL, NULL),
(4181, 'Bovec Municipality', 201, 'inactive', NULL, NULL, NULL),
(4182, 'Zavrč Municipality', 201, 'inactive', NULL, NULL, NULL),
(4183, 'Ajdovščina Municipality', 201, 'inactive', NULL, NULL, NULL),
(4184, 'Pivka Municipality', 201, 'inactive', NULL, NULL, NULL),
(4185, 'Štore Municipality', 201, 'inactive', NULL, NULL, NULL),
(4186, 'Kozje Municipality', 201, 'inactive', NULL, NULL, NULL);
INSERT INTO `states` (`id`, `name`, `country_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4187, 'Municipality of Škofljica', 201, 'inactive', NULL, NULL, NULL),
(4188, 'Prebold Municipality', 201, 'inactive', NULL, NULL, NULL),
(4189, 'Dobrovnik Municipality', 201, 'inactive', NULL, NULL, NULL),
(4190, 'Mozirje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4191, 'City Municipality of Celje', 201, 'inactive', NULL, NULL, NULL),
(4192, 'Žiri Municipality', 201, 'inactive', NULL, NULL, NULL),
(4193, 'Horjul Municipality', 201, 'inactive', NULL, NULL, NULL),
(4194, 'Tabor Municipality', 201, 'inactive', NULL, NULL, NULL),
(4195, 'Radeče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4196, 'Vipava Municipality', 201, 'inactive', NULL, NULL, NULL),
(4197, 'Kungota', 201, 'inactive', NULL, NULL, NULL),
(4198, 'Slovenske Konjice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4199, 'Osilnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4200, 'Borovnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4201, 'Piran Municipality', 201, 'inactive', NULL, NULL, NULL),
(4202, 'Bled Municipality', 201, 'inactive', NULL, NULL, NULL),
(4203, 'Jezersko Municipality', 201, 'inactive', NULL, NULL, NULL),
(4204, 'Rače–Fram Municipality', 201, 'inactive', NULL, NULL, NULL),
(4205, 'Nova Gorica City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4206, 'Razkrižje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4207, 'Ribnica na Pohorju Municipality', 201, 'inactive', NULL, NULL, NULL),
(4208, 'Muta Municipality', 201, 'inactive', NULL, NULL, NULL),
(4209, 'Rogatec Municipality', 201, 'inactive', NULL, NULL, NULL),
(4210, 'Gorišnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4211, 'Kuzma Municipality', 201, 'inactive', NULL, NULL, NULL),
(4212, 'Mislinja Municipality', 201, 'inactive', NULL, NULL, NULL),
(4213, 'Duplek Municipality', 201, 'inactive', NULL, NULL, NULL),
(4214, 'Trebnje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4215, 'Brežice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4216, 'Dobrepolje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4217, 'Grad Municipality', 201, 'inactive', NULL, NULL, NULL),
(4218, 'Moravske Toplice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4219, 'Luče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4220, 'Miren–Kostanjevica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4221, 'Ormož Municipality', 201, 'inactive', NULL, NULL, NULL),
(4222, 'Šalovci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4223, 'Miklavž na Dravskem Polju Municipality', 201, 'inactive', NULL, NULL, NULL),
(4224, 'Makole Municipality', 201, 'inactive', NULL, NULL, NULL),
(4225, 'Lendava Municipality', 201, 'inactive', NULL, NULL, NULL),
(4226, 'Vuzenica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4227, 'Kanal ob Soči Municipality', 201, 'inactive', NULL, NULL, NULL),
(4228, 'Ptuj City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4229, 'Sveti Andraž v Slovenskih Goricah Municipality', 201, 'inactive', NULL, NULL, NULL),
(4230, 'Selnica ob Dravi Municipality', 201, 'inactive', NULL, NULL, NULL),
(4231, 'Radovljica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4232, 'Črna na Koroškem Municipality', 201, 'inactive', NULL, NULL, NULL),
(4233, 'Rogaška Slatina Municipality', 201, 'inactive', NULL, NULL, NULL),
(4234, 'Podvelka Municipality', 201, 'inactive', NULL, NULL, NULL),
(4235, 'Ribnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4236, 'City Municipality of Novo Mesto', 201, 'inactive', NULL, NULL, NULL),
(4237, 'Mirna Peč Municipality', 201, 'inactive', NULL, NULL, NULL),
(4238, 'Križevci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4239, 'Poljčane Municipality', 201, 'inactive', NULL, NULL, NULL),
(4240, 'Brda Municipality', 201, 'inactive', NULL, NULL, NULL),
(4241, 'Šentjernej Municipality', 201, 'inactive', NULL, NULL, NULL),
(4242, 'Maribor City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4243, 'Kobarid Municipality', 201, 'inactive', NULL, NULL, NULL),
(4244, 'Markovci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4245, 'Vojnik Municipality', 201, 'inactive', NULL, NULL, NULL),
(4246, 'Trbovlje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4247, 'Tolmin Municipality', 201, 'inactive', NULL, NULL, NULL),
(4248, 'Šoštanj Municipality', 201, 'inactive', NULL, NULL, NULL),
(4249, 'Žetale Municipality', 201, 'inactive', NULL, NULL, NULL),
(4250, 'Tržič Municipality', 201, 'inactive', NULL, NULL, NULL),
(4251, 'Turnišče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4252, 'Dobrna Municipality', 201, 'inactive', NULL, NULL, NULL),
(4253, 'Renče–Vogrsko Municipality', 201, 'inactive', NULL, NULL, NULL),
(4254, 'Kostanjevica na Krki Municipality', 201, 'inactive', NULL, NULL, NULL),
(4255, 'Sveti Jurij ob Ščavnici Municipality', 201, 'inactive', NULL, NULL, NULL),
(4256, 'Železniki Municipality', 201, 'inactive', NULL, NULL, NULL),
(4257, 'Veržej Municipality', 201, 'inactive', NULL, NULL, NULL),
(4258, 'Žalec Municipality', 201, 'inactive', NULL, NULL, NULL),
(4259, 'Starše Municipality', 201, 'inactive', NULL, NULL, NULL),
(4260, 'Sveta Trojica v Slovenskih Goricah Municipality', 201, 'inactive', NULL, NULL, NULL),
(4261, 'Solčava Municipality', 201, 'inactive', NULL, NULL, NULL),
(4262, 'Vrhnika Municipality', 201, 'inactive', NULL, NULL, NULL),
(4263, 'Središče ob Dravi', 201, 'inactive', NULL, NULL, NULL),
(4264, 'Rogašovci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4265, 'Mežica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4266, 'Juršinci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4267, 'Velika Polana Municipality', 201, 'inactive', NULL, NULL, NULL),
(4268, 'Sevnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4269, 'Zagorje ob Savi Municipality', 201, 'inactive', NULL, NULL, NULL),
(4270, 'Ljubljana City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4271, 'Gornji Petrovci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4272, 'Polzela Municipality', 201, 'inactive', NULL, NULL, NULL),
(4273, 'Sveti Tomaž Municipality', 201, 'inactive', NULL, NULL, NULL),
(4274, 'Prevalje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4275, 'Radlje ob Dravi Municipality', 201, 'inactive', NULL, NULL, NULL),
(4276, 'Žirovnica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4277, 'Sodražica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4278, 'Bloke Municipality', 201, 'inactive', NULL, NULL, NULL),
(4279, 'Šmartno pri Litiji Municipality', 201, 'inactive', NULL, NULL, NULL),
(4280, 'Ruše Municipality', 201, 'inactive', NULL, NULL, NULL),
(4281, 'Dolenjske Toplice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4282, 'Bohinj Municipality', 201, 'inactive', NULL, NULL, NULL),
(4283, 'Komenda Municipality', 201, 'inactive', NULL, NULL, NULL),
(4284, 'Gorje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4285, 'Šmarje pri Jelšah Municipality', 201, 'inactive', NULL, NULL, NULL),
(4286, 'Ig Municipality', 201, 'inactive', NULL, NULL, NULL),
(4287, 'Kranj City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4288, 'Puconci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4289, 'Šmarješke Toplice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4290, 'Dornava Municipality', 201, 'inactive', NULL, NULL, NULL),
(4291, 'Črnomelj Municipality', 201, 'inactive', NULL, NULL, NULL),
(4292, 'Radenci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4293, 'Gorenja Vas–Poljane Municipality', 201, 'inactive', NULL, NULL, NULL),
(4294, 'Ljubno Municipality', 201, 'inactive', NULL, NULL, NULL),
(4295, 'Dobje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4296, 'Šmartno ob Paki Municipality', 201, 'inactive', NULL, NULL, NULL),
(4297, 'Mokronog–Trebelno Municipality', 201, 'inactive', NULL, NULL, NULL),
(4298, 'Mirna Municipality', 201, 'inactive', NULL, NULL, NULL),
(4299, 'Šenčur Municipality', 201, 'inactive', NULL, NULL, NULL),
(4300, 'Videm Municipality', 201, 'inactive', NULL, NULL, NULL),
(4301, 'Beltinci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4302, 'Lukovica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4303, 'Preddvor Municipality', 201, 'inactive', NULL, NULL, NULL),
(4304, 'Destrnik Municipality', 201, 'inactive', NULL, NULL, NULL),
(4305, 'Ivančna Gorica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4306, 'Log–Dragomer Municipality', 201, 'inactive', NULL, NULL, NULL),
(4307, 'Žužemberk Municipality', 201, 'inactive', NULL, NULL, NULL),
(4308, 'Dobrova–Polhov Gradec Municipality', 201, 'inactive', NULL, NULL, NULL),
(4309, 'Municipality of Cirkulane', 201, 'inactive', NULL, NULL, NULL),
(4310, 'Cerklje na Gorenjskem Municipality', 201, 'inactive', NULL, NULL, NULL),
(4311, 'Šentrupert Municipality', 201, 'inactive', NULL, NULL, NULL),
(4312, 'Tišina Municipality', 201, 'inactive', NULL, NULL, NULL),
(4313, 'Murska Sobota City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4314, 'Municipality of Krško', 201, 'inactive', NULL, NULL, NULL),
(4315, 'Komen Municipality', 201, 'inactive', NULL, NULL, NULL),
(4316, 'Škofja Loka Municipality', 201, 'inactive', NULL, NULL, NULL),
(4317, 'Šempeter–Vrtojba Municipality', 201, 'inactive', NULL, NULL, NULL),
(4318, 'Municipality of Apače', 201, 'inactive', NULL, NULL, NULL),
(4319, 'Koper City Municipality', 201, 'inactive', NULL, NULL, NULL),
(4320, 'Odranci Municipality', 201, 'inactive', NULL, NULL, NULL),
(4321, 'Hrpelje–Kozina Municipality', 201, 'inactive', NULL, NULL, NULL),
(4322, 'Izola Municipality', 201, 'inactive', NULL, NULL, NULL),
(4323, 'Metlika Municipality', 201, 'inactive', NULL, NULL, NULL),
(4324, 'Šentilj Municipality', 201, 'inactive', NULL, NULL, NULL),
(4325, 'Kobilje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4326, 'Ankaran Municipality', 201, 'inactive', NULL, NULL, NULL),
(4327, 'Hodoš Municipality', 201, 'inactive', NULL, NULL, NULL),
(4328, 'Sveti Jurij v Slovenskih Goricah Municipality', 201, 'inactive', NULL, NULL, NULL),
(4329, 'Nazarje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4330, 'Postojna Municipality', 201, 'inactive', NULL, NULL, NULL),
(4331, 'Kostel Municipality', 201, 'inactive', NULL, NULL, NULL),
(4332, 'Slovenska Bistrica Municipality', 201, 'inactive', NULL, NULL, NULL),
(4333, 'Straža Municipality', 201, 'inactive', NULL, NULL, NULL),
(4334, 'Trzin Municipality', 201, 'inactive', NULL, NULL, NULL),
(4335, 'Kočevje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4336, 'Grosuplje Municipality', 201, 'inactive', NULL, NULL, NULL),
(4337, 'Jesenice Municipality', 201, 'inactive', NULL, NULL, NULL),
(4338, 'Laško Municipality', 201, 'inactive', NULL, NULL, NULL),
(4339, 'Gornji Grad Municipality', 201, 'inactive', NULL, NULL, NULL),
(4340, 'Kranjska Gora Municipality', 201, 'inactive', NULL, NULL, NULL),
(4341, 'Hrastnik Municipality', 201, 'inactive', NULL, NULL, NULL),
(4342, 'Zreče Municipality', 201, 'inactive', NULL, NULL, NULL),
(4343, 'Gornja Radgona Municipality', 201, 'inactive', NULL, NULL, NULL),
(4344, 'Municipality of Ilirska Bistrica', 201, 'inactive', NULL, NULL, NULL),
(4345, 'Dravograd Municipality', 201, 'inactive', NULL, NULL, NULL),
(4346, 'Semič Municipality', 201, 'inactive', NULL, NULL, NULL),
(4347, 'Litija Municipality', 201, 'inactive', NULL, NULL, NULL),
(4348, 'Mengeš Municipality', 201, 'inactive', NULL, NULL, NULL),
(4349, 'Medvode Municipality', 201, 'inactive', NULL, NULL, NULL),
(4350, 'Logatec Municipality', 201, 'inactive', NULL, NULL, NULL),
(4351, 'Ljutomer Municipality', 201, 'inactive', NULL, NULL, NULL),
(4352, 'Banská Bystrica Region', 200, 'inactive', NULL, NULL, NULL),
(4353, 'Košice Region', 200, 'inactive', NULL, NULL, NULL),
(4354, 'Prešov Region', 200, 'inactive', NULL, NULL, NULL),
(4355, 'Trnava Region', 200, 'inactive', NULL, NULL, NULL),
(4356, 'Bratislava Region', 200, 'inactive', NULL, NULL, NULL),
(4357, 'Nitra Region', 200, 'inactive', NULL, NULL, NULL),
(4358, 'Trenčín Region', 200, 'inactive', NULL, NULL, NULL),
(4359, 'Žilina Region', 200, 'inactive', NULL, NULL, NULL),
(4360, 'Cimișlia District', 144, 'inactive', NULL, NULL, NULL),
(4361, 'Orhei District', 144, 'inactive', NULL, NULL, NULL),
(4362, 'Bender Municipality', 144, 'inactive', NULL, NULL, NULL),
(4363, 'Nisporeni District', 144, 'inactive', NULL, NULL, NULL),
(4364, 'Sîngerei District', 144, 'inactive', NULL, NULL, NULL),
(4365, 'Căușeni District', 144, 'inactive', NULL, NULL, NULL),
(4366, 'Călărași District', 144, 'inactive', NULL, NULL, NULL),
(4367, 'Glodeni District', 144, 'inactive', NULL, NULL, NULL),
(4368, 'Anenii Noi District', 144, 'inactive', NULL, NULL, NULL),
(4369, 'Ialoveni District', 144, 'inactive', NULL, NULL, NULL),
(4370, 'Florești District', 144, 'inactive', NULL, NULL, NULL),
(4371, 'Telenești District', 144, 'inactive', NULL, NULL, NULL),
(4372, 'Taraclia District', 144, 'inactive', NULL, NULL, NULL),
(4373, 'Chișinău Municipality', 144, 'inactive', NULL, NULL, NULL),
(4374, 'Soroca District', 144, 'inactive', NULL, NULL, NULL),
(4375, 'Briceni District', 144, 'inactive', NULL, NULL, NULL),
(4376, 'Rîșcani District', 144, 'inactive', NULL, NULL, NULL),
(4377, 'Strășeni District', 144, 'inactive', NULL, NULL, NULL),
(4378, 'Ștefan Vodă District', 144, 'inactive', NULL, NULL, NULL),
(4379, 'Basarabeasca District', 144, 'inactive', NULL, NULL, NULL),
(4380, 'Cantemir District', 144, 'inactive', NULL, NULL, NULL),
(4381, 'Fălești District', 144, 'inactive', NULL, NULL, NULL),
(4382, 'Hîncești District', 144, 'inactive', NULL, NULL, NULL),
(4383, 'Dubăsari District', 144, 'inactive', NULL, NULL, NULL),
(4384, 'Dondușeni District', 144, 'inactive', NULL, NULL, NULL),
(4385, 'Gagauzia', 144, 'inactive', NULL, NULL, NULL),
(4386, 'Ungheni District', 144, 'inactive', NULL, NULL, NULL),
(4387, 'Edineț District', 144, 'inactive', NULL, NULL, NULL),
(4388, 'Șoldănești District', 144, 'inactive', NULL, NULL, NULL),
(4389, 'Ocnița District', 144, 'inactive', NULL, NULL, NULL),
(4390, 'Criuleni District', 144, 'inactive', NULL, NULL, NULL),
(4391, 'Cahul District', 144, 'inactive', NULL, NULL, NULL),
(4392, 'Drochia District', 144, 'inactive', NULL, NULL, NULL),
(4393, 'Bălți Municipality', 144, 'inactive', NULL, NULL, NULL),
(4394, 'Rezina District', 144, 'inactive', NULL, NULL, NULL),
(4395, 'Transnistria autonomous territorial unit', 144, 'inactive', NULL, NULL, NULL),
(4396, 'Salacgrīva Municipality', 120, 'inactive', NULL, NULL, NULL),
(4397, 'Vecumnieki Municipality', 120, 'inactive', NULL, NULL, NULL),
(4398, 'Naukšēni Municipality', 120, 'inactive', NULL, NULL, NULL),
(4399, 'Ilūkste Municipality', 120, 'inactive', NULL, NULL, NULL),
(4400, 'Gulbene Municipality', 120, 'inactive', NULL, NULL, NULL),
(4401, 'Līvāni Municipality', 120, 'inactive', NULL, NULL, NULL),
(4402, 'Salaspils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4403, 'Ventspils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4404, 'Rundāle Municipality', 120, 'inactive', NULL, NULL, NULL),
(4405, 'Pļaviņas Municipality', 120, 'inactive', NULL, NULL, NULL),
(4406, 'Vārkava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4407, 'Jaunpiebalga Municipality', 120, 'inactive', NULL, NULL, NULL),
(4408, 'Sēja Municipality', 120, 'inactive', NULL, NULL, NULL),
(4409, 'Tukums Municipality', 120, 'inactive', NULL, NULL, NULL),
(4410, 'Cibla Municipality', 120, 'inactive', NULL, NULL, NULL),
(4411, 'Burtnieki Municipality', 120, 'inactive', NULL, NULL, NULL),
(4412, 'Ķegums Municipality', 120, 'inactive', NULL, NULL, NULL),
(4413, 'Krustpils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4414, 'Cesvaine Municipality', 120, 'inactive', NULL, NULL, NULL),
(4415, 'Skrīveri Municipality', 120, 'inactive', NULL, NULL, NULL),
(4416, 'Ogre Municipality', 120, 'inactive', NULL, NULL, NULL),
(4417, 'Olaine Municipality', 120, 'inactive', NULL, NULL, NULL),
(4418, 'Limbaži Municipality', 120, 'inactive', NULL, NULL, NULL),
(4419, 'Lubāna Municipality', 120, 'inactive', NULL, NULL, NULL),
(4420, 'Kandava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4421, 'Ventspils', 120, 'inactive', NULL, NULL, NULL),
(4422, 'Krimulda Municipality', 120, 'inactive', NULL, NULL, NULL),
(4423, 'Rugāji Municipality', 120, 'inactive', NULL, NULL, NULL),
(4424, 'Jelgava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4425, 'Valka Municipality', 120, 'inactive', NULL, NULL, NULL),
(4426, 'Rūjiena Municipality', 120, 'inactive', NULL, NULL, NULL),
(4427, 'Babīte Municipality', 120, 'inactive', NULL, NULL, NULL),
(4428, 'Dundaga Municipality', 120, 'inactive', NULL, NULL, NULL),
(4429, 'Priekule Municipality', 120, 'inactive', NULL, NULL, NULL),
(4430, 'Zilupe Municipality', 120, 'inactive', NULL, NULL, NULL),
(4431, 'Varakļāni Municipality', 120, 'inactive', NULL, NULL, NULL),
(4432, 'Nereta Municipality', 120, 'inactive', NULL, NULL, NULL),
(4433, 'Madona Municipality', 120, 'inactive', NULL, NULL, NULL),
(4434, 'Sala Municipality', 120, 'inactive', NULL, NULL, NULL),
(4435, 'Ķekava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4436, 'Nīca Municipality', 120, 'inactive', NULL, NULL, NULL),
(4437, 'Dobele Municipality', 120, 'inactive', NULL, NULL, NULL),
(4438, 'Jēkabpils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4439, 'Saldus Municipality', 120, 'inactive', NULL, NULL, NULL),
(4440, 'Roja Municipality', 120, 'inactive', NULL, NULL, NULL),
(4441, 'Iecava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4442, 'Ozolnieki Municipality', 120, 'inactive', NULL, NULL, NULL),
(4443, 'Saulkrasti Municipality', 120, 'inactive', NULL, NULL, NULL),
(4444, 'Ērgļi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4445, 'Aglona Municipality', 120, 'inactive', NULL, NULL, NULL),
(4446, 'Jūrmala', 120, 'inactive', NULL, NULL, NULL),
(4447, 'Skrunda Municipality', 120, 'inactive', NULL, NULL, NULL),
(4448, 'Engure Municipality', 120, 'inactive', NULL, NULL, NULL),
(4449, 'Inčukalns Municipality', 120, 'inactive', NULL, NULL, NULL),
(4450, 'Mārupe Municipality', 120, 'inactive', NULL, NULL, NULL),
(4451, 'Mērsrags Municipality', 120, 'inactive', NULL, NULL, NULL),
(4452, 'Koknese Municipality', 120, 'inactive', NULL, NULL, NULL),
(4453, 'Kārsava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4454, 'Carnikava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4455, 'Rēzekne Municipality', 120, 'inactive', NULL, NULL, NULL),
(4456, 'Viesīte Municipality', 120, 'inactive', NULL, NULL, NULL),
(4457, 'Ape Municipality', 120, 'inactive', NULL, NULL, NULL),
(4458, 'Durbe Municipality', 120, 'inactive', NULL, NULL, NULL),
(4459, 'Talsi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4460, 'Liepāja', 120, 'inactive', NULL, NULL, NULL),
(4461, 'Mālpils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4462, 'Smiltene Municipality', 120, 'inactive', NULL, NULL, NULL),
(4463, 'Daugavpils', 120, 'inactive', NULL, NULL, NULL),
(4464, 'Jēkabpils', 120, 'inactive', NULL, NULL, NULL),
(4465, 'Bauska Municipality', 120, 'inactive', NULL, NULL, NULL),
(4466, 'Vecpiebalga Municipality', 120, 'inactive', NULL, NULL, NULL),
(4467, 'Pāvilosta Municipality', 120, 'inactive', NULL, NULL, NULL),
(4468, 'Brocēni Municipality', 120, 'inactive', NULL, NULL, NULL),
(4469, 'Cēsis Municipality', 120, 'inactive', NULL, NULL, NULL),
(4470, 'Grobiņa Municipality', 120, 'inactive', NULL, NULL, NULL),
(4471, 'Beverīna Municipality', 120, 'inactive', NULL, NULL, NULL),
(4472, 'Aizkraukle Municipality', 120, 'inactive', NULL, NULL, NULL),
(4473, 'Valmiera', 120, 'inactive', NULL, NULL, NULL),
(4474, 'Krāslava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4475, 'Jaunjelgava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4476, 'Sigulda Municipality', 120, 'inactive', NULL, NULL, NULL),
(4477, 'Viļaka Municipality', 120, 'inactive', NULL, NULL, NULL),
(4478, 'Stopiņi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4479, 'Rauna Municipality', 120, 'inactive', NULL, NULL, NULL),
(4480, 'Tērvete Municipality', 120, 'inactive', NULL, NULL, NULL),
(4481, 'Auce Municipality', 120, 'inactive', NULL, NULL, NULL),
(4482, 'Baldone Municipality', 120, 'inactive', NULL, NULL, NULL),
(4483, 'Preiļi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4484, 'Aloja Municipality', 120, 'inactive', NULL, NULL, NULL),
(4485, 'Alsunga Municipality', 120, 'inactive', NULL, NULL, NULL),
(4486, 'Viļāni Municipality', 120, 'inactive', NULL, NULL, NULL),
(4487, 'Alūksne Municipality', 120, 'inactive', NULL, NULL, NULL),
(4488, 'Līgatne Municipality', 120, 'inactive', NULL, NULL, NULL),
(4489, 'Jaunpils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4490, 'Kuldīga Municipality', 120, 'inactive', NULL, NULL, NULL),
(4491, 'Riga', 120, 'inactive', NULL, NULL, NULL),
(4492, 'Daugavpils Municipality', 120, 'inactive', NULL, NULL, NULL),
(4493, 'Ropaži Municipality', 120, 'inactive', NULL, NULL, NULL),
(4494, 'Strenči Municipality', 120, 'inactive', NULL, NULL, NULL),
(4495, 'Kocēni Municipality', 120, 'inactive', NULL, NULL, NULL),
(4496, 'Aizpute Municipality', 120, 'inactive', NULL, NULL, NULL),
(4497, 'Amata Municipality', 120, 'inactive', NULL, NULL, NULL),
(4498, 'Baltinava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4499, 'Aknīste Municipality', 120, 'inactive', NULL, NULL, NULL),
(4500, 'Jelgava', 120, 'inactive', NULL, NULL, NULL),
(4501, 'Ludza Municipality', 120, 'inactive', NULL, NULL, NULL),
(4502, 'Riebiņi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4503, 'Rucava Municipality', 120, 'inactive', NULL, NULL, NULL),
(4504, 'Dagda Municipality', 120, 'inactive', NULL, NULL, NULL),
(4505, 'Balvi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4506, 'Priekuļi Municipality', 120, 'inactive', NULL, NULL, NULL),
(4507, 'Pārgauja Municipality', 120, 'inactive', NULL, NULL, NULL),
(4508, 'Vaiņode Municipality', 120, 'inactive', NULL, NULL, NULL),
(4509, 'Rēzekne', 120, 'inactive', NULL, NULL, NULL),
(4510, 'Garkalne Municipality', 120, 'inactive', NULL, NULL, NULL),
(4511, 'Ikšķile Municipality', 120, 'inactive', NULL, NULL, NULL),
(4512, 'Lielvārde Municipality', 120, 'inactive', NULL, NULL, NULL),
(4513, 'Mazsalaca Municipality', 120, 'inactive', NULL, NULL, NULL),
(4514, 'Viqueque Municipality', 63, 'inactive', NULL, NULL, NULL),
(4515, 'Liquiçá Municipality', 63, 'inactive', NULL, NULL, NULL),
(4516, 'Ermera District', 63, 'inactive', NULL, NULL, NULL),
(4517, 'Manatuto District', 63, 'inactive', NULL, NULL, NULL),
(4518, 'Ainaro Municipality', 63, 'inactive', NULL, NULL, NULL),
(4519, 'Manufahi Municipality', 63, 'inactive', NULL, NULL, NULL),
(4520, 'Aileu municipality', 63, 'inactive', NULL, NULL, NULL),
(4521, 'Baucau Municipality', 63, 'inactive', NULL, NULL, NULL),
(4522, 'Cova Lima Municipality', 63, 'inactive', NULL, NULL, NULL),
(4523, 'Lautém Municipality', 63, 'inactive', NULL, NULL, NULL),
(4524, 'Dili municipality', 63, 'inactive', NULL, NULL, NULL),
(4525, 'Bobonaro Municipality', 63, 'inactive', NULL, NULL, NULL),
(4526, 'Peleliu', 168, 'inactive', NULL, NULL, NULL),
(4527, 'Ngardmau', 168, 'inactive', NULL, NULL, NULL),
(4528, 'Airai', 168, 'inactive', NULL, NULL, NULL),
(4529, 'Hatohobei', 168, 'inactive', NULL, NULL, NULL),
(4530, 'Melekeok', 168, 'inactive', NULL, NULL, NULL),
(4531, 'Ngatpang', 168, 'inactive', NULL, NULL, NULL),
(4532, 'Koror', 168, 'inactive', NULL, NULL, NULL),
(4533, 'Ngarchelong', 168, 'inactive', NULL, NULL, NULL),
(4534, 'Ngiwal', 168, 'inactive', NULL, NULL, NULL),
(4535, 'Sonsorol', 168, 'inactive', NULL, NULL, NULL),
(4536, 'Ngchesar', 168, 'inactive', NULL, NULL, NULL),
(4537, 'Ngaraard', 168, 'inactive', NULL, NULL, NULL),
(4538, 'Angaur', 168, 'inactive', NULL, NULL, NULL),
(4539, 'Kayangel', 168, 'inactive', NULL, NULL, NULL),
(4540, 'Aimeliik', 168, 'inactive', NULL, NULL, NULL),
(4541, 'Ngeremlengui', 168, 'inactive', NULL, NULL, NULL),
(4542, 'Břeclav District', 58, 'inactive', NULL, NULL, NULL),
(4543, 'Český Krumlov District', 58, 'inactive', NULL, NULL, NULL),
(4544, 'Plzeň-City District', 58, 'inactive', NULL, NULL, NULL),
(4545, 'Brno-Country District', 58, 'inactive', NULL, NULL, NULL),
(4546, 'Příbram District', 58, 'inactive', NULL, NULL, NULL),
(4547, 'Pardubice District', 58, 'inactive', NULL, NULL, NULL),
(4548, 'Nový Jičín District', 58, 'inactive', NULL, NULL, NULL),
(4549, 'Prague 12', 58, 'inactive', NULL, NULL, NULL),
(4550, 'Náchod District', 58, 'inactive', NULL, NULL, NULL),
(4551, 'Prostějov District', 58, 'inactive', NULL, NULL, NULL),
(4552, 'Zlín Region', 58, 'inactive', NULL, NULL, NULL),
(4553, 'Chomutov District', 58, 'inactive', NULL, NULL, NULL),
(4554, 'Central Bohemian Region', 58, 'inactive', NULL, NULL, NULL),
(4555, 'Prague 13', 58, 'inactive', NULL, NULL, NULL),
(4556, 'České Budějovice District', 58, 'inactive', NULL, NULL, NULL),
(4557, 'Prague 5', 58, 'inactive', NULL, NULL, NULL),
(4558, 'Rakovník District', 58, 'inactive', NULL, NULL, NULL),
(4559, 'Frýdek-Místek District', 58, 'inactive', NULL, NULL, NULL),
(4560, 'Písek District', 58, 'inactive', NULL, NULL, NULL),
(4561, 'Hodonín District', 58, 'inactive', NULL, NULL, NULL),
(4562, 'Prague 1', 58, 'inactive', NULL, NULL, NULL),
(4563, 'Zlín District', 58, 'inactive', NULL, NULL, NULL),
(4564, 'Plzeň-North District', 58, 'inactive', NULL, NULL, NULL),
(4565, 'Tábor District', 58, 'inactive', NULL, NULL, NULL),
(4566, 'Prague 9', 58, 'inactive', NULL, NULL, NULL),
(4567, 'Prague 16', 58, 'inactive', NULL, NULL, NULL),
(4568, 'Brno-City District', 58, 'inactive', NULL, NULL, NULL),
(4569, 'Prague 6', 58, 'inactive', NULL, NULL, NULL),
(4570, 'Prague 11', 58, 'inactive', NULL, NULL, NULL),
(4571, 'Svitavy District', 58, 'inactive', NULL, NULL, NULL),
(4572, 'Vsetín District', 58, 'inactive', NULL, NULL, NULL),
(4573, 'Cheb District', 58, 'inactive', NULL, NULL, NULL),
(4574, 'Olomouc District', 58, 'inactive', NULL, NULL, NULL),
(4575, 'Vysočina Region', 58, 'inactive', NULL, NULL, NULL),
(4576, 'Ústí nad Labem Region', 58, 'inactive', NULL, NULL, NULL),
(4577, 'Horní Počernice', 58, 'inactive', NULL, NULL, NULL),
(4578, 'Prachatice District', 58, 'inactive', NULL, NULL, NULL),
(4579, 'Trutnov District', 58, 'inactive', NULL, NULL, NULL),
(4580, 'Hradec Králové District', 58, 'inactive', NULL, NULL, NULL),
(4581, 'Karlovy Vary Region', 58, 'inactive', NULL, NULL, NULL),
(4582, 'Nymburk District', 58, 'inactive', NULL, NULL, NULL),
(4583, 'Rokycany District', 58, 'inactive', NULL, NULL, NULL),
(4584, 'Ostrava-City District', 58, 'inactive', NULL, NULL, NULL),
(4585, 'Prague 14', 58, 'inactive', NULL, NULL, NULL),
(4586, 'Karviná District', 58, 'inactive', NULL, NULL, NULL),
(4587, 'Prague 4', 58, 'inactive', NULL, NULL, NULL),
(4588, 'Pardubice Region', 58, 'inactive', NULL, NULL, NULL),
(4589, 'Olomouc Region', 58, 'inactive', NULL, NULL, NULL),
(4590, 'Liberec District', 58, 'inactive', NULL, NULL, NULL),
(4591, 'Klatovy District', 58, 'inactive', NULL, NULL, NULL),
(4592, 'Uherské Hradiště District', 58, 'inactive', NULL, NULL, NULL),
(4593, 'Kroměříž District', 58, 'inactive', NULL, NULL, NULL),
(4594, 'Prague 8', 58, 'inactive', NULL, NULL, NULL),
(4595, 'Sokolov District', 58, 'inactive', NULL, NULL, NULL),
(4596, 'Semily District', 58, 'inactive', NULL, NULL, NULL),
(4597, 'Třebíč District', 58, 'inactive', NULL, NULL, NULL),
(4598, 'Prague', 58, 'inactive', NULL, NULL, NULL),
(4599, 'Ústí nad Labem District', 58, 'inactive', NULL, NULL, NULL),
(4600, 'Moravian-Silesian Region', 58, 'inactive', NULL, NULL, NULL),
(4601, 'Liberec Region', 58, 'inactive', NULL, NULL, NULL),
(4602, 'South Moravian Region', 58, 'inactive', NULL, NULL, NULL),
(4603, 'Prague 10', 58, 'inactive', NULL, NULL, NULL),
(4604, 'Karlovy Vary District', 58, 'inactive', NULL, NULL, NULL),
(4605, 'Litoměřice District', 58, 'inactive', NULL, NULL, NULL),
(4606, 'Prague-East District', 58, 'inactive', NULL, NULL, NULL),
(4607, 'Plzeň Region', 58, 'inactive', NULL, NULL, NULL),
(4608, 'Plzeň-South District', 58, 'inactive', NULL, NULL, NULL),
(4609, 'Děčín District', 58, 'inactive', NULL, NULL, NULL),
(4610, 'Prague 7', 58, 'inactive', NULL, NULL, NULL),
(4611, 'Havlíčkův Brod District', 58, 'inactive', NULL, NULL, NULL),
(4612, 'Jablonec nad Nisou District', 58, 'inactive', NULL, NULL, NULL),
(4613, 'Jihlava District', 58, 'inactive', NULL, NULL, NULL),
(4614, 'Hradec Králové Region', 58, 'inactive', NULL, NULL, NULL),
(4615, 'Blansko District', 58, 'inactive', NULL, NULL, NULL),
(4616, 'Prague 2', 58, 'inactive', NULL, NULL, NULL),
(4617, 'Louny District', 58, 'inactive', NULL, NULL, NULL),
(4618, 'Kolín District', 58, 'inactive', NULL, NULL, NULL),
(4619, 'Prague-West District', 58, 'inactive', NULL, NULL, NULL),
(4620, 'Beroun District', 58, 'inactive', NULL, NULL, NULL),
(4621, 'Teplice District', 58, 'inactive', NULL, NULL, NULL),
(4622, 'Vyškov District', 58, 'inactive', NULL, NULL, NULL),
(4623, 'Opava District', 58, 'inactive', NULL, NULL, NULL),
(4624, 'Jindřichův Hradec District', 58, 'inactive', NULL, NULL, NULL),
(4625, 'Jeseník District', 58, 'inactive', NULL, NULL, NULL),
(4626, 'Přerov District', 58, 'inactive', NULL, NULL, NULL),
(4627, 'Benešov District', 58, 'inactive', NULL, NULL, NULL),
(4628, 'Strakonice District', 58, 'inactive', NULL, NULL, NULL),
(4629, 'Most District', 58, 'inactive', NULL, NULL, NULL),
(4630, 'Znojmo District', 58, 'inactive', NULL, NULL, NULL),
(4631, 'Kladno District', 58, 'inactive', NULL, NULL, NULL),
(4632, 'Prague 21', 58, 'inactive', NULL, NULL, NULL),
(4633, 'Česká Lípa District', 58, 'inactive', NULL, NULL, NULL),
(4634, 'Chrudim District', 58, 'inactive', NULL, NULL, NULL),
(4635, 'Prague 3', 58, 'inactive', NULL, NULL, NULL),
(4636, 'Rychnov nad Kněžnou District', 58, 'inactive', NULL, NULL, NULL),
(4637, 'Prague 15', 58, 'inactive', NULL, NULL, NULL),
(4638, 'Mělník District', 58, 'inactive', NULL, NULL, NULL),
(4639, 'South Bohemian Region', 58, 'inactive', NULL, NULL, NULL),
(4640, 'Jičín District', 58, 'inactive', NULL, NULL, NULL),
(4641, 'Domažlice District', 58, 'inactive', NULL, NULL, NULL),
(4642, 'Šumperk District', 58, 'inactive', NULL, NULL, NULL),
(4643, 'Mladá Boleslav District', 58, 'inactive', NULL, NULL, NULL),
(4644, 'Bruntál District', 58, 'inactive', NULL, NULL, NULL),
(4645, 'Pelhřimov District', 58, 'inactive', NULL, NULL, NULL),
(4646, 'Tachov District', 58, 'inactive', NULL, NULL, NULL),
(4647, 'Ústí nad Orlicí District', 58, 'inactive', NULL, NULL, NULL),
(4648, 'Žďár nad Sázavou District', 58, 'inactive', NULL, NULL, NULL),
(4649, 'North East Community Development Council', 199, 'inactive', NULL, NULL, NULL),
(4650, 'South East Community Development Council', 199, 'inactive', NULL, NULL, NULL),
(4651, 'Central Singapore Community Development Council', 199, 'inactive', NULL, NULL, NULL),
(4652, 'South West Community Development Council', 199, 'inactive', NULL, NULL, NULL),
(4653, 'North West Community Development Council', 199, 'inactive', NULL, NULL, NULL),
(4654, 'Ewa District', 153, 'inactive', NULL, NULL, NULL),
(4655, 'Uaboe District', 153, 'inactive', NULL, NULL, NULL),
(4656, 'Aiwo District', 153, 'inactive', NULL, NULL, NULL),
(4657, 'Meneng District', 153, 'inactive', NULL, NULL, NULL),
(4658, 'Anabar District', 153, 'inactive', NULL, NULL, NULL),
(4659, 'Nibok District', 153, 'inactive', NULL, NULL, NULL),
(4660, 'Baiti District', 153, 'inactive', NULL, NULL, NULL),
(4661, 'Ijuw District', 153, 'inactive', NULL, NULL, NULL),
(4662, 'Buada District', 153, 'inactive', NULL, NULL, NULL),
(4663, 'Anibare District', 153, 'inactive', NULL, NULL, NULL),
(4664, 'Yaren District', 153, 'inactive', NULL, NULL, NULL),
(4665, 'Boe District', 153, 'inactive', NULL, NULL, NULL),
(4666, 'Denigomodu District', 153, 'inactive', NULL, NULL, NULL),
(4667, 'Anetan District', 153, 'inactive', NULL, NULL, NULL),
(4668, 'Zhytomyr Oblast', 230, 'inactive', NULL, NULL, NULL),
(4669, 'Vinnytsia Oblast', 230, 'inactive', NULL, NULL, NULL),
(4670, 'Zakarpattia Oblast', 230, 'inactive', NULL, NULL, NULL),
(4671, 'Kyiv Oblast', 230, 'inactive', NULL, NULL, NULL),
(4672, 'Lviv Oblast', 230, 'inactive', NULL, NULL, NULL),
(4673, 'Luhansk Oblast', 230, 'inactive', NULL, NULL, NULL),
(4674, 'Ternopil Oblast', 230, 'inactive', NULL, NULL, NULL),
(4675, 'Dnipropetrovsk Oblast', 230, 'inactive', NULL, NULL, NULL),
(4676, 'Kiev', 230, 'inactive', NULL, NULL, NULL),
(4677, 'Kirovohrad Oblast', 230, 'inactive', NULL, NULL, NULL),
(4678, 'Chernivtsi Oblast', 230, 'inactive', NULL, NULL, NULL),
(4679, 'Mykolaiv Oblast', 230, 'inactive', NULL, NULL, NULL),
(4680, 'Cherkasy Oblast', 230, 'inactive', NULL, NULL, NULL),
(4681, 'Khmelnytsky Oblast', 230, 'inactive', NULL, NULL, NULL),
(4682, 'Ivano-Frankivsk Oblast', 230, 'inactive', NULL, NULL, NULL),
(4683, 'Rivne Oblast', 230, 'inactive', NULL, NULL, NULL),
(4684, 'Kherson Oblast', 230, 'inactive', NULL, NULL, NULL),
(4685, 'Sumy Oblast', 230, 'inactive', NULL, NULL, NULL),
(4686, 'Kharkiv Oblast', 230, 'inactive', NULL, NULL, NULL),
(4687, 'Zaporizhzhya Oblast', 230, 'inactive', NULL, NULL, NULL),
(4688, 'Odessa Oblast', 230, 'inactive', NULL, NULL, NULL),
(4689, 'Autonomous Republic of Crimea', 230, 'inactive', NULL, NULL, NULL),
(4690, 'Volyn Oblast', 230, 'inactive', NULL, NULL, NULL),
(4691, 'Donetsk Oblast', 230, 'inactive', NULL, NULL, NULL),
(4692, 'Chernihiv Oblast', 230, 'inactive', NULL, NULL, NULL),
(4693, 'Gabrovo Province', 34, 'inactive', NULL, NULL, NULL),
(4694, 'Smolyan Province', 34, 'inactive', NULL, NULL, NULL),
(4695, 'Pernik Province', 34, 'inactive', NULL, NULL, NULL),
(4696, 'Montana Province', 34, 'inactive', NULL, NULL, NULL),
(4697, 'Vidin Province', 34, 'inactive', NULL, NULL, NULL),
(4698, 'Razgrad Province', 34, 'inactive', NULL, NULL, NULL),
(4699, 'Blagoevgrad Province', 34, 'inactive', NULL, NULL, NULL),
(4700, 'Sliven Province', 34, 'inactive', NULL, NULL, NULL),
(4701, 'Plovdiv Province', 34, 'inactive', NULL, NULL, NULL),
(4702, 'Kardzhali Province', 34, 'inactive', NULL, NULL, NULL),
(4703, 'Kyustendil Province', 34, 'inactive', NULL, NULL, NULL),
(4704, 'Haskovo Province', 34, 'inactive', NULL, NULL, NULL),
(4705, 'Sofia City Province', 34, 'inactive', NULL, NULL, NULL),
(4706, 'Pleven Province', 34, 'inactive', NULL, NULL, NULL),
(4707, 'Stara Zagora Province', 34, 'inactive', NULL, NULL, NULL),
(4708, 'Silistra Province', 34, 'inactive', NULL, NULL, NULL),
(4709, 'Veliko Tarnovo Province', 34, 'inactive', NULL, NULL, NULL),
(4710, 'Lovech Province', 34, 'inactive', NULL, NULL, NULL),
(4711, 'Vratsa Province', 34, 'inactive', NULL, NULL, NULL),
(4712, 'Pazardzhik Province', 34, 'inactive', NULL, NULL, NULL),
(4713, 'Ruse Province', 34, 'inactive', NULL, NULL, NULL),
(4714, 'Targovishte Province', 34, 'inactive', NULL, NULL, NULL),
(4715, 'Burgas Province', 34, 'inactive', NULL, NULL, NULL),
(4716, 'Yambol Province', 34, 'inactive', NULL, NULL, NULL),
(4717, 'Varna Province', 34, 'inactive', NULL, NULL, NULL),
(4718, 'Dobrich Province', 34, 'inactive', NULL, NULL, NULL),
(4719, 'Sofia Province', 34, 'inactive', NULL, NULL, NULL),
(4720, 'Suceava County', 181, 'inactive', NULL, NULL, NULL),
(4721, 'Hunedoara County', 181, 'inactive', NULL, NULL, NULL),
(4722, 'Arges', 181, 'inactive', NULL, NULL, NULL),
(4723, 'Bihor County', 181, 'inactive', NULL, NULL, NULL),
(4724, 'Alba', 181, 'inactive', NULL, NULL, NULL),
(4725, 'Ilfov County', 181, 'inactive', NULL, NULL, NULL),
(4726, 'Giurgiu County', 181, 'inactive', NULL, NULL, NULL),
(4727, 'Tulcea County', 181, 'inactive', NULL, NULL, NULL),
(4728, 'Teleorman County', 181, 'inactive', NULL, NULL, NULL),
(4729, 'Prahova County', 181, 'inactive', NULL, NULL, NULL),
(4730, 'Bucharest', 181, 'inactive', NULL, NULL, NULL),
(4731, 'Neamț County', 181, 'inactive', NULL, NULL, NULL),
(4732, 'Călărași County', 181, 'inactive', NULL, NULL, NULL),
(4733, 'Bistrița-Năsăud County', 181, 'inactive', NULL, NULL, NULL),
(4734, 'Cluj County', 181, 'inactive', NULL, NULL, NULL),
(4735, 'Iași County', 181, 'inactive', NULL, NULL, NULL),
(4736, 'Braila', 181, 'inactive', NULL, NULL, NULL),
(4737, 'Constanța County', 181, 'inactive', NULL, NULL, NULL),
(4738, 'Olt County', 181, 'inactive', NULL, NULL, NULL),
(4739, 'Arad County', 181, 'inactive', NULL, NULL, NULL),
(4740, 'Botoșani County', 181, 'inactive', NULL, NULL, NULL),
(4741, 'Sălaj County', 181, 'inactive', NULL, NULL, NULL),
(4742, 'Dolj County', 181, 'inactive', NULL, NULL, NULL),
(4743, 'Ialomița County', 181, 'inactive', NULL, NULL, NULL),
(4744, 'Bacău County', 181, 'inactive', NULL, NULL, NULL),
(4745, 'Dâmbovița County', 181, 'inactive', NULL, NULL, NULL),
(4746, 'Satu Mare County', 181, 'inactive', NULL, NULL, NULL),
(4747, 'Galați County', 181, 'inactive', NULL, NULL, NULL),
(4748, 'Timiș County', 181, 'inactive', NULL, NULL, NULL),
(4749, 'Harghita County', 181, 'inactive', NULL, NULL, NULL),
(4750, 'Gorj County', 181, 'inactive', NULL, NULL, NULL),
(4751, 'Mehedinți County', 181, 'inactive', NULL, NULL, NULL),
(4752, 'Vaslui County', 181, 'inactive', NULL, NULL, NULL),
(4753, 'Caraș-Severin County', 181, 'inactive', NULL, NULL, NULL),
(4754, 'Covasna County', 181, 'inactive', NULL, NULL, NULL),
(4755, 'Sibiu County', 181, 'inactive', NULL, NULL, NULL),
(4756, 'Buzău County', 181, 'inactive', NULL, NULL, NULL),
(4757, 'Vâlcea County', 181, 'inactive', NULL, NULL, NULL),
(4758, 'Vrancea County', 181, 'inactive', NULL, NULL, NULL),
(4759, 'Brașov County', 181, 'inactive', NULL, NULL, NULL),
(4760, 'Maramureș County', 181, 'inactive', NULL, NULL, NULL),
(4761, 'Aiga-i-le-Tai', 191, 'inactive', NULL, NULL, NULL),
(4762, 'Satupa\'itea', 191, 'inactive', NULL, NULL, NULL),
(4763, 'A\'ana', 191, 'inactive', NULL, NULL, NULL),
(4764, 'Fa\'asaleleaga', 191, 'inactive', NULL, NULL, NULL),
(4765, 'Atua', 191, 'inactive', NULL, NULL, NULL),
(4766, 'Vaisigano', 191, 'inactive', NULL, NULL, NULL),
(4767, 'Palauli', 191, 'inactive', NULL, NULL, NULL),
(4768, 'Va\'a-o-Fonoti', 191, 'inactive', NULL, NULL, NULL),
(4769, 'Gaga\'emauga', 191, 'inactive', NULL, NULL, NULL),
(4770, 'Tuamasaga', 191, 'inactive', NULL, NULL, NULL),
(4771, 'Gaga\'ifomauga', 191, 'inactive', NULL, NULL, NULL),
(4772, 'Torba', 237, 'inactive', NULL, NULL, NULL),
(4773, 'Penama', 237, 'inactive', NULL, NULL, NULL),
(4774, 'Shefa', 237, 'inactive', NULL, NULL, NULL),
(4775, 'Malampa', 237, 'inactive', NULL, NULL, NULL),
(4776, 'Sanma', 237, 'inactive', NULL, NULL, NULL),
(4777, 'Tafea', 237, 'inactive', NULL, NULL, NULL),
(4778, 'Honiara', 202, 'inactive', NULL, NULL, NULL),
(4779, 'Temotu Province', 202, 'inactive', NULL, NULL, NULL),
(4780, 'Isabel Province', 202, 'inactive', NULL, NULL, NULL),
(4781, 'Choiseul Province', 202, 'inactive', NULL, NULL, NULL),
(4782, 'Makira-Ulawa Province', 202, 'inactive', NULL, NULL, NULL),
(4783, 'Malaita Province', 202, 'inactive', NULL, NULL, NULL),
(4784, 'Central Province', 202, 'inactive', NULL, NULL, NULL),
(4785, 'Guadalcanal Province', 202, 'inactive', NULL, NULL, NULL),
(4786, 'Western Province', 202, 'inactive', NULL, NULL, NULL),
(4787, 'Rennell and Bellona Province', 202, 'inactive', NULL, NULL, NULL),
(4788, 'Burgundy', 75, 'inactive', NULL, NULL, NULL),
(4789, 'Auvergne', 75, 'inactive', NULL, NULL, NULL),
(4790, 'Picardy', 75, 'inactive', NULL, NULL, NULL),
(4791, 'Champagne-Ardenne', 75, 'inactive', NULL, NULL, NULL),
(4792, 'Limousin', 75, 'inactive', NULL, NULL, NULL),
(4793, 'Nord-Pas-de-Calais', 75, 'inactive', NULL, NULL, NULL),
(4794, 'Saint Barthélemy', 75, 'inactive', NULL, NULL, NULL),
(4795, 'Nouvelle-Aquitaine', 75, 'inactive', NULL, NULL, NULL),
(4796, 'Île-de-France', 75, 'inactive', NULL, NULL, NULL),
(4797, 'Mayotte', 75, 'inactive', NULL, NULL, NULL),
(4798, 'Auvergne-Rhône-Alpes', 75, 'inactive', NULL, NULL, NULL),
(4799, 'Occitania', 75, 'inactive', NULL, NULL, NULL),
(4800, 'Alo', 75, 'inactive', NULL, NULL, NULL),
(4801, 'Lorraine', 75, 'inactive', NULL, NULL, NULL),
(4802, 'Pays de la Loire', 75, 'inactive', NULL, NULL, NULL),
(4803, 'Languedoc-Roussillon', 75, 'inactive', NULL, NULL, NULL),
(4804, 'Normandy', 75, 'inactive', NULL, NULL, NULL),
(4805, 'Franche-Comté', 75, 'inactive', NULL, NULL, NULL),
(4806, 'Corsica', 75, 'inactive', NULL, NULL, NULL),
(4807, 'Brittany', 75, 'inactive', NULL, NULL, NULL),
(4808, 'Aquitaine', 75, 'inactive', NULL, NULL, NULL),
(4809, 'Saint Martin', 75, 'inactive', NULL, NULL, NULL),
(4810, 'Wallis and Futuna', 75, 'inactive', NULL, NULL, NULL),
(4811, 'Alsace', 75, 'inactive', NULL, NULL, NULL),
(4812, 'Provence-Alpes-Côte d\'Azur', 75, 'inactive', NULL, NULL, NULL),
(4813, 'Rhône-Alpes', 75, 'inactive', NULL, NULL, NULL),
(4814, 'Lower Normandy', 75, 'inactive', NULL, NULL, NULL),
(4815, 'Poitou-Charentes', 75, 'inactive', NULL, NULL, NULL),
(4816, 'Paris', 75, 'inactive', NULL, NULL, NULL),
(4817, 'Uvea', 75, 'inactive', NULL, NULL, NULL),
(4818, 'Centre-Val de Loire', 75, 'inactive', NULL, NULL, NULL),
(4819, 'Sigave', 75, 'inactive', NULL, NULL, NULL),
(4820, 'Grand Est', 75, 'inactive', NULL, NULL, NULL),
(4821, 'Saint Pierre and Miquelon', 75, 'inactive', NULL, NULL, NULL),
(4822, 'French Guiana', 75, 'inactive', NULL, NULL, NULL),
(4823, 'Réunion', 75, 'inactive', NULL, NULL, NULL),
(4824, 'French Polynesia', 75, 'inactive', NULL, NULL, NULL),
(4825, 'Bourgogne-Franche-Comté', 75, 'inactive', NULL, NULL, NULL),
(4826, 'Upper Normandy', 75, 'inactive', NULL, NULL, NULL),
(4827, 'Martinique', 75, 'inactive', NULL, NULL, NULL),
(4828, 'Hauts-de-France', 75, 'inactive', NULL, NULL, NULL),
(4829, 'Guadeloupe', 75, 'inactive', NULL, NULL, NULL),
(4830, 'West New Britain Province', 171, 'inactive', NULL, NULL, NULL),
(4831, 'Bougainville', 171, 'inactive', NULL, NULL, NULL),
(4832, 'Jiwaka Province', 171, 'inactive', NULL, NULL, NULL),
(4833, 'Hela', 171, 'inactive', NULL, NULL, NULL),
(4834, 'East New Britain', 171, 'inactive', NULL, NULL, NULL),
(4835, 'Morobe Province', 171, 'inactive', NULL, NULL, NULL),
(4836, 'Sandaun Province', 171, 'inactive', NULL, NULL, NULL),
(4837, 'Port Moresby', 171, 'inactive', NULL, NULL, NULL),
(4838, 'Oro Province', 171, 'inactive', NULL, NULL, NULL),
(4839, 'Gulf', 171, 'inactive', NULL, NULL, NULL),
(4840, 'Western Highlands Province', 171, 'inactive', NULL, NULL, NULL),
(4841, 'New Ireland Province', 171, 'inactive', NULL, NULL, NULL),
(4842, 'Manus Province', 171, 'inactive', NULL, NULL, NULL),
(4843, 'Madang Province', 171, 'inactive', NULL, NULL, NULL),
(4844, 'Southern Highlands Province', 171, 'inactive', NULL, NULL, NULL),
(4845, 'Eastern Highlands Province', 171, 'inactive', NULL, NULL, NULL),
(4846, 'Chimbu Province', 171, 'inactive', NULL, NULL, NULL),
(4847, 'Central Province', 171, 'inactive', NULL, NULL, NULL),
(4848, 'Enga Province', 171, 'inactive', NULL, NULL, NULL),
(4849, 'Milne Bay Province', 171, 'inactive', NULL, NULL, NULL),
(4850, 'Western Province', 171, 'inactive', NULL, NULL, NULL),
(4851, 'Ohio', 233, 'inactive', NULL, NULL, NULL),
(4852, 'Ladakh', 101, 'inactive', NULL, NULL, NULL),
(4853, 'West Bengal', 101, 'inactive', NULL, NULL, NULL),
(4854, 'Sinop Province', 225, 'inactive', NULL, NULL, NULL),
(4855, 'Capital District', 239, 'inactive', NULL, NULL, NULL),
(4856, 'Apure', 239, 'inactive', NULL, NULL, NULL),
(4857, 'Jalisco', 142, 'inactive', NULL, NULL, NULL),
(4858, 'Roraima', 31, 'inactive', NULL, NULL, NULL),
(4859, 'Guarda District', 177, 'inactive', NULL, NULL, NULL),
(4860, 'Devonshire Parish', 25, 'inactive', NULL, NULL, NULL),
(4861, 'Hamilton Parish', 25, 'inactive', NULL, NULL, NULL),
(4862, 'Hamilton Municipality', 25, 'inactive', NULL, NULL, NULL),
(4863, 'Paget Parish', 25, 'inactive', NULL, NULL, NULL),
(4864, 'Pembroke Parish', 25, 'inactive', NULL, NULL, NULL),
(4865, 'Saint George\'s Municipality', 25, 'inactive', NULL, NULL, NULL),
(4866, 'Saint George\'s Parish', 25, 'inactive', NULL, NULL, NULL),
(4867, 'Sandys Parish', 25, 'inactive', NULL, NULL, NULL),
(4868, 'Smith\'s Parish,', 25, 'inactive', NULL, NULL, NULL),
(4869, 'Southampton Parish', 25, 'inactive', NULL, NULL, NULL),
(4870, 'Warwick Parish', 25, 'inactive', NULL, NULL, NULL),
(4871, 'Huila Department', 48, 'inactive', NULL, NULL, NULL),
(4874, 'Uroševac District (Ferizaj)', 248, 'inactive', NULL, NULL, NULL),
(4876, 'Đakovica District (Gjakove)', 248, 'inactive', NULL, NULL, NULL),
(4877, 'Gjilan District', 248, 'inactive', NULL, NULL, NULL),
(4878, 'Kosovska Mitrovica District', 248, 'inactive', NULL, NULL, NULL),
(4879, 'Pristina (Priştine)', 248, 'inactive', NULL, NULL, NULL),
(4880, 'Autonomous City Of Buenos Aires', 11, 'inactive', NULL, NULL, NULL),
(4881, 'New Providence', 17, 'inactive', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trasfer_date` date NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_from` bigint(20) UNSIGNED NOT NULL,
  `warehouse_to` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `reference_no`, `trasfer_date`, `notes`, `warehouse_from`, `warehouse_to`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '200', '2021-06-30', NULL, 2, 1, 1, NULL, NULL, '2022-12-17 22:00:16', '2022-12-17 22:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_detail`
--

CREATE TABLE `stock_transfer_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer_detail`
--

INSERT INTO `stock_transfer_detail` (`id`, `stock_transfer_id`, `product_id`, `product_combination_id`, `qty`) VALUES
(1, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `first_name`, `last_name`, `address`, `phone`, `mobile`, `country_id`, `state_id`, `city`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Default', 'Supplier', 'New York, USA', '0123456789', '0123456789', 223, 43, 'New York', NULL, NULL, NULL, '2022-12-17 19:37:12', '2022-12-17 19:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `title`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'GST', 'GST', NULL, NULL, NULL, '2022-12-17 19:37:37', '2022-12-17 19:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tax_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `tax_id`, `state_id`, `country_id`, `tax_rate`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 3223, 65, 14.00, 'online warehouse', 1, NULL, NULL, '2022-12-17 22:21:26', '2022-12-17 22:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offset` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diff_from_gtm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `name`, `offset`, `diff_from_gtm`, `created_at`, `updated_at`) VALUES
(1, 'Africa/Abidjan', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(2, 'Africa/Accra', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(3, 'Africa/Addis_Ababa', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(4, 'Africa/Algiers', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(5, 'Africa/Asmara', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(6, 'Africa/Bamako', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(7, 'Africa/Bangui', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(8, 'Africa/Banjul', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(9, 'Africa/Bissau', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(10, 'Africa/Blantyre', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(11, 'Africa/Brazzaville', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(12, 'Africa/Bujumbura', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(13, 'Africa/Cairo', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(14, 'Africa/Casablanca', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(15, 'Africa/Ceuta', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(16, 'Africa/Conakry', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(17, 'Africa/Dakar', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(18, 'Africa/Dar_es_Salaam', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(19, 'Africa/Djibouti', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(20, 'Africa/Douala', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(21, 'Africa/El_Aaiun', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(22, 'Africa/Freetown', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(23, 'Africa/Gaborone', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(24, 'Africa/Harare', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(25, 'Africa/Johannesburg', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(26, 'Africa/Juba', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(27, 'Africa/Kampala', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(28, 'Africa/Khartoum', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(29, 'Africa/Kigali', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(30, 'Africa/Kinshasa', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(31, 'Africa/Lagos', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(32, 'Africa/Libreville', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(33, 'Africa/Lome', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(34, 'Africa/Luanda', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(35, 'Africa/Lubumbashi', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(36, 'Africa/Lusaka', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(37, 'Africa/Malabo', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(38, 'Africa/Maputo', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(39, 'Africa/Maseru', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(40, 'Africa/Mbabane', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(41, 'Africa/Mogadishu', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(42, 'Africa/Monrovia', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(43, 'Africa/Nairobi', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:37', '2022-12-17 22:37:37'),
(44, 'Africa/Ndjamena', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(45, 'Africa/Niamey', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(46, 'Africa/Nouakchott', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(47, 'Africa/Ouagadougou', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(48, 'Africa/Porto-Novo', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(49, 'Africa/Sao_Tome', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(50, 'Africa/Tripoli', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(51, 'Africa/Tunis', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:37', '2022-12-17 20:37:37'),
(52, 'Africa/Windhoek', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:37', '2022-12-17 21:37:37'),
(53, 'America/Adak', '-10:00', 'UTC/GMT -10:00', '2022-12-17 09:37:37', '2022-12-17 09:37:37'),
(54, 'America/Anchorage', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:37', '2022-12-17 10:37:37'),
(55, 'America/Anguilla', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(56, 'America/Antigua', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(57, 'America/Araguaina', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(58, 'America/Argentina/Buenos_Aires', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(59, 'America/Argentina/Catamarca', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(60, 'America/Argentina/Cordoba', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(61, 'America/Argentina/Jujuy', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(62, 'America/Argentina/La_Rioja', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(63, 'America/Argentina/Mendoza', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(64, 'America/Argentina/Rio_Gallegos', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(65, 'America/Argentina/Salta', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(66, 'America/Argentina/San_Juan', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(67, 'America/Argentina/San_Luis', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(68, 'America/Argentina/Tucuman', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(69, 'America/Argentina/Ushuaia', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(70, 'America/Aruba', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(71, 'America/Asuncion', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(72, 'America/Atikokan', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(73, 'America/Bahia', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(74, 'America/Bahia_Banderas', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(75, 'America/Barbados', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(76, 'America/Belem', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(77, 'America/Belize', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(78, 'America/Blanc-Sablon', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(79, 'America/Boa_Vista', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(80, 'America/Bogota', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(81, 'America/Boise', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(82, 'America/Cambridge_Bay', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(83, 'America/Campo_Grande', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(84, 'America/Cancun', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(85, 'America/Caracas', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(86, 'America/Cayenne', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(87, 'America/Cayman', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(88, 'America/Chicago', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(89, 'America/Chihuahua', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(90, 'America/Costa_Rica', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(91, 'America/Creston', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(92, 'America/Cuiaba', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(93, 'America/Curacao', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(94, 'America/Danmarkshavn', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:37', '2022-12-17 19:37:37'),
(95, 'America/Dawson', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(96, 'America/Dawson_Creek', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(97, 'America/Denver', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(98, 'America/Detroit', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(99, 'America/Dominica', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(100, 'America/Edmonton', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(101, 'America/Eirunepe', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(102, 'America/El_Salvador', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(103, 'America/Fort_Nelson', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(104, 'America/Fortaleza', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(105, 'America/Glace_Bay', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(106, 'America/Goose_Bay', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(107, 'America/Grand_Turk', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(108, 'America/Grenada', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(109, 'America/Guadeloupe', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(110, 'America/Guatemala', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(111, 'America/Guayaquil', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(112, 'America/Guyana', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(113, 'America/Halifax', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(114, 'America/Havana', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(115, 'America/Hermosillo', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(116, 'America/Indiana/Indianapolis', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(117, 'America/Indiana/Knox', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(118, 'America/Indiana/Marengo', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(119, 'America/Indiana/Petersburg', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(120, 'America/Indiana/Tell_City', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(121, 'America/Indiana/Vevay', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(122, 'America/Indiana/Vincennes', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(123, 'America/Indiana/Winamac', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(124, 'America/Inuvik', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(125, 'America/Iqaluit', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(126, 'America/Jamaica', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(127, 'America/Juneau', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:37', '2022-12-17 10:37:37'),
(128, 'America/Kentucky/Louisville', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(129, 'America/Kentucky/Monticello', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(130, 'America/Kralendijk', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(131, 'America/La_Paz', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(132, 'America/Lima', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(133, 'America/Los_Angeles', '-08:00', 'UTC/GMT -08:00', '2022-12-17 11:37:37', '2022-12-17 11:37:37'),
(134, 'America/Lower_Princes', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(135, 'America/Maceio', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(136, 'America/Managua', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(137, 'America/Manaus', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(138, 'America/Marigot', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(139, 'America/Martinique', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(140, 'America/Matamoros', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(141, 'America/Mazatlan', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(142, 'America/Menominee', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(143, 'America/Merida', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(144, 'America/Metlakatla', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:37', '2022-12-17 10:37:37'),
(145, 'America/Mexico_City', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(146, 'America/Miquelon', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(147, 'America/Moncton', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(148, 'America/Monterrey', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(149, 'America/Montevideo', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(150, 'America/Montserrat', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(151, 'America/Nassau', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(152, 'America/New_York', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(153, 'America/Nipigon', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(154, 'America/Nome', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:37', '2022-12-17 10:37:37'),
(155, 'America/Noronha', '-02:00', 'UTC/GMT -02:00', '2022-12-17 17:37:37', '2022-12-17 17:37:37'),
(156, 'America/North_Dakota/Beulah', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(157, 'America/North_Dakota/Center', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(158, 'America/North_Dakota/New_Salem', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(159, 'America/Nuuk', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(160, 'America/Ojinaga', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(161, 'America/Panama', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(162, 'America/Pangnirtung', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(163, 'America/Paramaribo', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(164, 'America/Phoenix', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:37', '2022-12-17 12:37:37'),
(165, 'America/Port-au-Prince', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(166, 'America/Port_of_Spain', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(167, 'America/Porto_Velho', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(168, 'America/Puerto_Rico', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(169, 'America/Punta_Arenas', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(170, 'America/Rainy_River', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(171, 'America/Rankin_Inlet', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(172, 'America/Recife', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(173, 'America/Regina', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(174, 'America/Resolute', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(175, 'America/Rio_Branco', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(176, 'America/Santarem', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(177, 'America/Santiago', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(178, 'America/Santo_Domingo', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(179, 'America/Sao_Paulo', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:37', '2022-12-17 16:37:37'),
(180, 'America/Scoresbysund', '-01:00', 'UTC/GMT -01:00', '2022-12-17 18:37:37', '2022-12-17 18:37:37'),
(181, 'America/Sitka', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:37', '2022-12-17 10:37:37'),
(182, 'America/St_Barthelemy', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(183, 'America/St_Johns', '-03:30', 'UTC/GMT -03:30', '2022-12-17 16:07:37', '2022-12-17 16:07:37'),
(184, 'America/St_Kitts', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(185, 'America/St_Lucia', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(186, 'America/St_Thomas', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(187, 'America/St_Vincent', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(188, 'America/Swift_Current', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(189, 'America/Tegucigalpa', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:37', '2022-12-17 13:37:37'),
(190, 'America/Thule', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(191, 'America/Thunder_Bay', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(192, 'America/Tijuana', '-08:00', 'UTC/GMT -08:00', '2022-12-17 11:37:37', '2022-12-17 11:37:37'),
(193, 'America/Toronto', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:37', '2022-12-17 14:37:37'),
(194, 'America/Tortola', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:37', '2022-12-17 15:37:37'),
(195, 'America/Vancouver', '-08:00', 'UTC/GMT -08:00', '2022-12-17 11:37:37', '2022-12-17 11:37:37'),
(196, 'America/Whitehorse', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:38', '2022-12-17 12:37:38'),
(197, 'America/Winnipeg', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:38', '2022-12-17 13:37:38'),
(198, 'America/Yakutat', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:38', '2022-12-17 10:37:38'),
(199, 'America/Yellowknife', '-07:00', 'UTC/GMT -07:00', '2022-12-17 12:37:38', '2022-12-17 12:37:38'),
(200, 'Antarctica/Casey', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(201, 'Antarctica/Davis', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(202, 'Antarctica/DumontDUrville', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(203, 'Antarctica/Macquarie', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(204, 'Antarctica/Mawson', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(205, 'Antarctica/McMurdo', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:38', '2022-12-18 08:37:38'),
(206, 'Antarctica/Palmer', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:38', '2022-12-17 16:37:38'),
(207, 'Antarctica/Rothera', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:38', '2022-12-17 16:37:38'),
(208, 'Antarctica/Syowa', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(209, 'Antarctica/Troll', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(210, 'Antarctica/Vostok', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(211, 'Arctic/Longyearbyen', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(212, 'Asia/Aden', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(213, 'Asia/Almaty', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(214, 'Asia/Amman', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(215, 'Asia/Anadyr', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:38', '2022-12-18 07:37:38'),
(216, 'Asia/Aqtau', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(217, 'Asia/Aqtobe', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(218, 'Asia/Ashgabat', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(219, 'Asia/Atyrau', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(220, 'Asia/Baghdad', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(221, 'Asia/Bahrain', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(222, 'Asia/Baku', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(223, 'Asia/Bangkok', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(224, 'Asia/Barnaul', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(225, 'Asia/Beirut', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(226, 'Asia/Bishkek', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(227, 'Asia/Brunei', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(228, 'Asia/Chita', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(229, 'Asia/Choibalsan', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(230, 'Asia/Colombo', '+05:30', 'UTC/GMT +05:30', '2022-12-18 01:07:38', '2022-12-18 01:07:38'),
(231, 'Asia/Damascus', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(232, 'Asia/Dhaka', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(233, 'Asia/Dili', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(234, 'Asia/Dubai', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(235, 'Asia/Dushanbe', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(236, 'Asia/Famagusta', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(237, 'Asia/Gaza', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(238, 'Asia/Hebron', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(239, 'Asia/Ho_Chi_Minh', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(240, 'Asia/Hong_Kong', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(241, 'Asia/Hovd', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(242, 'Asia/Irkutsk', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(243, 'Asia/Jakarta', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(244, 'Asia/Jayapura', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(245, 'Asia/Jerusalem', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(246, 'Asia/Kabul', '+04:30', 'UTC/GMT +04:30', '2022-12-18 00:07:38', '2022-12-18 00:07:38'),
(247, 'Asia/Kamchatka', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:38', '2022-12-18 07:37:38'),
(248, 'Asia/Karachi', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(249, 'Asia/Kathmandu', '+05:45', 'UTC/GMT +05:45', '2022-12-18 01:22:38', '2022-12-18 01:22:38'),
(250, 'Asia/Khandyga', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(251, 'Asia/Kolkata', '+05:30', 'UTC/GMT +05:30', '2022-12-18 01:07:38', '2022-12-18 01:07:38'),
(252, 'Asia/Krasnoyarsk', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(253, 'Asia/Kuala_Lumpur', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(254, 'Asia/Kuching', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(255, 'Asia/Kuwait', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(256, 'Asia/Macau', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(257, 'Asia/Magadan', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(258, 'Asia/Makassar', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(259, 'Asia/Manila', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(260, 'Asia/Muscat', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(261, 'Asia/Nicosia', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(262, 'Asia/Novokuznetsk', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(263, 'Asia/Novosibirsk', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(264, 'Asia/Omsk', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(265, 'Asia/Oral', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(266, 'Asia/Phnom_Penh', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(267, 'Asia/Pontianak', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(268, 'Asia/Pyongyang', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(269, 'Asia/Qatar', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(270, 'Asia/Qostanay', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(271, 'Asia/Qyzylorda', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(272, 'Asia/Riyadh', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(273, 'Asia/Sakhalin', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(274, 'Asia/Samarkand', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(275, 'Asia/Seoul', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(276, 'Asia/Shanghai', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(277, 'Asia/Singapore', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(278, 'Asia/Srednekolymsk', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(279, 'Asia/Taipei', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(280, 'Asia/Tashkent', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(281, 'Asia/Tbilisi', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(282, 'Asia/Tehran', '+03:30', 'UTC/GMT +03:30', '2022-12-17 23:07:38', '2022-12-17 23:07:38'),
(283, 'Asia/Thimphu', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(284, 'Asia/Tokyo', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(285, 'Asia/Tomsk', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(286, 'Asia/Ulaanbaatar', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(287, 'Asia/Urumqi', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(288, 'Asia/Ust-Nera', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(289, 'Asia/Vientiane', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(290, 'Asia/Vladivostok', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(291, 'Asia/Yakutsk', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:38', '2022-12-18 04:37:38'),
(292, 'Asia/Yangon', '+06:30', 'UTC/GMT +06:30', '2022-12-18 02:07:38', '2022-12-18 02:07:38'),
(293, 'Asia/Yekaterinburg', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(294, 'Asia/Yerevan', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(295, 'Atlantic/Azores', '-01:00', 'UTC/GMT -01:00', '2022-12-17 18:37:38', '2022-12-17 18:37:38'),
(296, 'Atlantic/Bermuda', '-04:00', 'UTC/GMT -04:00', '2022-12-17 15:37:38', '2022-12-17 15:37:38'),
(297, 'Atlantic/Canary', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(298, 'Atlantic/Cape_Verde', '-01:00', 'UTC/GMT -01:00', '2022-12-17 18:37:38', '2022-12-17 18:37:38'),
(299, 'Atlantic/Faroe', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(300, 'Atlantic/Madeira', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(301, 'Atlantic/Reykjavik', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(302, 'Atlantic/South_Georgia', '-02:00', 'UTC/GMT -02:00', '2022-12-17 17:37:38', '2022-12-17 17:37:38'),
(303, 'Atlantic/St_Helena', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(304, 'Atlantic/Stanley', '-03:00', 'UTC/GMT -03:00', '2022-12-17 16:37:38', '2022-12-17 16:37:38'),
(305, 'Australia/Adelaide', '+10:30', 'UTC/GMT +10:30', '2022-12-18 06:07:38', '2022-12-18 06:07:38'),
(306, 'Australia/Brisbane', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(307, 'Australia/Broken_Hill', '+10:30', 'UTC/GMT +10:30', '2022-12-18 06:07:38', '2022-12-18 06:07:38'),
(308, 'Australia/Darwin', '+09:30', 'UTC/GMT +09:30', '2022-12-18 05:07:38', '2022-12-18 05:07:38'),
(309, 'Australia/Eucla', '+08:45', 'UTC/GMT +08:45', '2022-12-18 04:22:38', '2022-12-18 04:22:38'),
(310, 'Australia/Hobart', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(311, 'Australia/Lindeman', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(312, 'Australia/Lord_Howe', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(313, 'Australia/Melbourne', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(314, 'Australia/Perth', '+08:00', 'UTC/GMT +08:00', '2022-12-18 03:37:38', '2022-12-18 03:37:38'),
(315, 'Australia/Sydney', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(316, 'Europe/Amsterdam', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(317, 'Europe/Andorra', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(318, 'Europe/Astrakhan', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(319, 'Europe/Athens', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(320, 'Europe/Belgrade', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(321, 'Europe/Berlin', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(322, 'Europe/Bratislava', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(323, 'Europe/Brussels', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(324, 'Europe/Bucharest', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(325, 'Europe/Budapest', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(326, 'Europe/Busingen', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(327, 'Europe/Chisinau', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(328, 'Europe/Copenhagen', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(329, 'Europe/Dublin', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(330, 'Europe/Gibraltar', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(331, 'Europe/Guernsey', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(332, 'Europe/Helsinki', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(333, 'Europe/Isle_of_Man', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(334, 'Europe/Istanbul', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(335, 'Europe/Jersey', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(336, 'Europe/Kaliningrad', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(337, 'Europe/Kiev', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(338, 'Europe/Kirov', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(339, 'Europe/Lisbon', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(340, 'Europe/Ljubljana', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(341, 'Europe/London', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:38', '2022-12-17 19:37:38'),
(342, 'Europe/Luxembourg', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(343, 'Europe/Madrid', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(344, 'Europe/Malta', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(345, 'Europe/Mariehamn', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(346, 'Europe/Minsk', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(347, 'Europe/Monaco', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(348, 'Europe/Moscow', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(349, 'Europe/Oslo', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(350, 'Europe/Paris', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(351, 'Europe/Podgorica', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(352, 'Europe/Prague', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(353, 'Europe/Riga', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(354, 'Europe/Rome', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(355, 'Europe/Samara', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(356, 'Europe/San_Marino', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(357, 'Europe/Sarajevo', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(358, 'Europe/Saratov', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(359, 'Europe/Simferopol', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(360, 'Europe/Skopje', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(361, 'Europe/Sofia', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(362, 'Europe/Stockholm', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(363, 'Europe/Tallinn', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(364, 'Europe/Tirane', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(365, 'Europe/Ulyanovsk', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(366, 'Europe/Uzhgorod', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(367, 'Europe/Vaduz', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(368, 'Europe/Vatican', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(369, 'Europe/Vienna', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(370, 'Europe/Vilnius', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(371, 'Europe/Volgograd', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(372, 'Europe/Warsaw', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(373, 'Europe/Zagreb', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(374, 'Europe/Zaporozhye', '+02:00', 'UTC/GMT +02:00', '2022-12-17 21:37:38', '2022-12-17 21:37:38'),
(375, 'Europe/Zurich', '+01:00', 'UTC/GMT +01:00', '2022-12-17 20:37:38', '2022-12-17 20:37:38'),
(376, 'Indian/Antananarivo', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(377, 'Indian/Chagos', '+06:00', 'UTC/GMT +06:00', '2022-12-18 01:37:38', '2022-12-18 01:37:38'),
(378, 'Indian/Christmas', '+07:00', 'UTC/GMT +07:00', '2022-12-18 02:37:38', '2022-12-18 02:37:38'),
(379, 'Indian/Cocos', '+06:30', 'UTC/GMT +06:30', '2022-12-18 02:07:38', '2022-12-18 02:07:38'),
(380, 'Indian/Comoro', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(381, 'Indian/Kerguelen', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(382, 'Indian/Mahe', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(383, 'Indian/Maldives', '+05:00', 'UTC/GMT +05:00', '2022-12-18 00:37:38', '2022-12-18 00:37:38'),
(384, 'Indian/Mauritius', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(385, 'Indian/Mayotte', '+03:00', 'UTC/GMT +03:00', '2022-12-17 22:37:38', '2022-12-17 22:37:38'),
(386, 'Indian/Reunion', '+04:00', 'UTC/GMT +04:00', '2022-12-17 23:37:38', '2022-12-17 23:37:38'),
(387, 'Pacific/Apia', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:38', '2022-12-18 08:37:38'),
(388, 'Pacific/Auckland', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:38', '2022-12-18 08:37:38'),
(389, 'Pacific/Bougainville', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(390, 'Pacific/Chatham', '+13:45', 'UTC/GMT +13:45', '2022-12-18 09:22:38', '2022-12-18 09:22:38'),
(391, 'Pacific/Chuuk', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(392, 'Pacific/Easter', '-05:00', 'UTC/GMT -05:00', '2022-12-17 14:37:38', '2022-12-17 14:37:38'),
(393, 'Pacific/Efate', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(394, 'Pacific/Fakaofo', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:38', '2022-12-18 08:37:38'),
(395, 'Pacific/Fiji', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:38', '2022-12-18 08:37:38'),
(396, 'Pacific/Funafuti', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:38', '2022-12-18 07:37:38'),
(397, 'Pacific/Galapagos', '-06:00', 'UTC/GMT -06:00', '2022-12-17 13:37:38', '2022-12-17 13:37:38'),
(398, 'Pacific/Gambier', '-09:00', 'UTC/GMT -09:00', '2022-12-17 10:37:38', '2022-12-17 10:37:38'),
(399, 'Pacific/Guadalcanal', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:38', '2022-12-18 06:37:38'),
(400, 'Pacific/Guam', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:38', '2022-12-18 05:37:38'),
(401, 'Pacific/Honolulu', '-10:00', 'UTC/GMT -10:00', '2022-12-17 09:37:38', '2022-12-17 09:37:38'),
(402, 'Pacific/Kanton', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:38', '2022-12-18 08:37:38'),
(403, 'Pacific/Kiritimati', '+14:00', 'UTC/GMT +14:00', '2022-12-18 09:37:38', '2022-12-18 09:37:38'),
(404, 'Pacific/Kosrae', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:39', '2022-12-18 06:37:39'),
(405, 'Pacific/Kwajalein', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(406, 'Pacific/Majuro', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(407, 'Pacific/Marquesas', '-09:30', 'UTC/GMT -09:30', '2022-12-17 10:07:39', '2022-12-17 10:07:39'),
(408, 'Pacific/Midway', '-11:00', 'UTC/GMT -11:00', '2022-12-17 08:37:39', '2022-12-17 08:37:39'),
(409, 'Pacific/Nauru', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(410, 'Pacific/Niue', '-11:00', 'UTC/GMT -11:00', '2022-12-17 08:37:39', '2022-12-17 08:37:39'),
(411, 'Pacific/Norfolk', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(412, 'Pacific/Noumea', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:39', '2022-12-18 06:37:39'),
(413, 'Pacific/Pago_Pago', '-11:00', 'UTC/GMT -11:00', '2022-12-17 08:37:39', '2022-12-17 08:37:39'),
(414, 'Pacific/Palau', '+09:00', 'UTC/GMT +09:00', '2022-12-18 04:37:39', '2022-12-18 04:37:39'),
(415, 'Pacific/Pitcairn', '-08:00', 'UTC/GMT -08:00', '2022-12-17 11:37:39', '2022-12-17 11:37:39'),
(416, 'Pacific/Pohnpei', '+11:00', 'UTC/GMT +11:00', '2022-12-18 06:37:39', '2022-12-18 06:37:39'),
(417, 'Pacific/Port_Moresby', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:39', '2022-12-18 05:37:39'),
(418, 'Pacific/Rarotonga', '-10:00', 'UTC/GMT -10:00', '2022-12-17 09:37:39', '2022-12-17 09:37:39'),
(419, 'Pacific/Saipan', '+10:00', 'UTC/GMT +10:00', '2022-12-18 05:37:39', '2022-12-18 05:37:39'),
(420, 'Pacific/Tahiti', '-10:00', 'UTC/GMT -10:00', '2022-12-17 09:37:39', '2022-12-17 09:37:39'),
(421, 'Pacific/Tarawa', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(422, 'Pacific/Tongatapu', '+13:00', 'UTC/GMT +13:00', '2022-12-18 08:37:39', '2022-12-18 08:37:39'),
(423, 'Pacific/Wake', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(424, 'Pacific/Wallis', '+12:00', 'UTC/GMT +12:00', '2022-12-18 07:37:39', '2022-12-18 07:37:39'),
(425, 'UTC', '+00:00', 'UTC/GMT +00:00', '2022-12-17 19:37:39', '2022-12-17 19:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `top_offer`
--

CREATE TABLE `top_offer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `top_offer_text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `top_selling_products`
-- (See below for the actual view)
--
CREATE TABLE `top_selling_products` (
`qty` decimal(32,0)
,`product_id` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` bigint(20) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_number`, `transaction_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-12-17', 'Stock Adjustment', '2022-12-17 21:18:53', '2022-12-17 21:18:53'),
(2, 2, '2022-12-17', 'Stock Adjustment', '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(3, 3, '2022-12-17', 'Stock Adjustment', '2022-12-17 21:58:56', '2022-12-17 21:58:56'),
(14, 4, '2022-12-18', 'mmmmmm', '2022-12-17 22:07:30', '2022-12-17 22:07:30'),
(15, 5, '2022-12-18', 'kkkkk', '2022-12-17 22:09:36', '2022-12-17 22:09:36'),
(16, 6, '2022-12-18', 'kkkkk', '2022-12-17 22:09:36', '2022-12-17 22:09:36'),
(18, 6, '2022-12-18', 'Stock Adjustment', '2022-12-17 22:12:27', '2022-12-17 22:12:27'),
(19, 7, '2022-12-18', 'Stock Adjustment', '2022-12-17 22:13:40', '2022-12-17 22:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `type` enum('sale','purchase','cash','redeem','adjustment') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `dr_amount` double(8,2) DEFAULT NULL,
  `cr_amount` double(8,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_id`, `account_id`, `reference_id`, `user_id`, `type`, `warehouse_id`, `dr_amount`, `cr_amount`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 16, 1, 1, 'adjustment', 2, 5000.00, 0.00, 'StockAdjustment', '2022-12-17 21:18:53', '2022-12-17 21:18:53'),
(2, 2, 16, 1, 1, 'adjustment', 1, 5000.00, 0.00, 'StockAdjustment', '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(3, 2, 17, 2, 1, 'adjustment', 2, 7500.00, 0.00, 'StockAdjustment', '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(4, 2, 18, 3, 1, 'adjustment', 2, 10000.00, 0.00, 'StockAdjustment', '2022-12-17 21:57:48', '2022-12-17 21:57:48'),
(5, 3, 16, 1, 1, 'adjustment', 2, 0.00, 1000.00, 'StockAdjustment', '2022-12-17 21:58:56', '2022-12-17 21:58:56'),
(6, 14, 2, NULL, 0, '', NULL, 200.00, 0.00, 'mmmmmm', '2022-12-17 22:07:30', '2022-12-17 22:07:30'),
(7, 15, 2, NULL, 0, '', NULL, 2000.00, 0.00, 'kkkkk', '2022-12-17 22:09:36', '2022-12-17 22:09:36'),
(8, 16, 3, NULL, 0, '', NULL, 0.00, 2000.00, 'kkkkk', '2022-12-17 22:09:36', '2022-12-17 22:09:36'),
(9, 18, 18, 3, 1, 'adjustment', 2, 15000.00, 0.00, 'StockAdjustment', '2022-12-17 22:12:27', '2022-12-17 22:12:27'),
(10, 19, 18, 3, 1, 'adjustment', 1, 15000.00, 0.00, 'StockAdjustment', '2022-12-17 22:13:40', '2022-12-17 22:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 for active & 0 for inactive',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `is_active`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '2022-12-17 20:46:13', '2022-12-17 20:54:59'),
(2, 1, 1, 1, NULL, '2022-12-17 20:46:19', '2022-12-17 20:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `unit_detail`
--

CREATE TABLE `unit_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_detail`
--

INSERT INTO `unit_detail` (`id`, `unit_id`, `name`, `language_id`) VALUES
(3, 1, '1000 KG', 1),
(4, 2, '4 in 1 case', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `is_seen` tinyint(4) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `avatar`, `email`, `role_id`, `is_seen`, `status`, `email_verified_at`, `password`, `remember_token`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'owner', 'owner', NULL, 'owner@email.com', 1, 1, 'active', NULL, '$2y$10$xyT2uDNaHmNRi0n5lW9MKexadyo9Bt0Z0m67AggBgM/QbkcakvQ9e', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Admin', 'Admin', 'Admin', NULL, 'admin@email.com', 2, 1, 'active', NULL, '$2y$10$SF4ypnJlLqOtyauyRZQ2i.mdesXYZlzW2hpPGSbMV/iqhtcvcMoDC', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Biller 1', 'Biller', '1', NULL, 'biller1@email.com', 3, 1, 'active', NULL, '$2y$10$2aBcZsEsZu82Vujq9ipRguNeERDVyQh.MtT5GUAwi/jS4qNvxXSci', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Biller 2', 'Biller', '2', NULL, 'biller2@email.com', 3, 1, 'active', NULL, '$2y$10$yLyqaHXlQyfsXcV8rFeOweL2osRsE1o3Qgv.VyME1ycJEsx/QpUD6', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Purchaser', 'Purchaser ', 'Purchaser ', NULL, 'purchaser@email.com', 4, 1, 'active', NULL, '$2y$10$YUNZP5eFe/RidI0emF4CoOPDzCZ1vsO5oMHKrMaLXXsxgb5b0Yoty', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Accountant ', 'Accountant ', 'Accountant  ', NULL, 'accountant@email.com', 5, 1, 'active', NULL, '$2y$10$SH3EZM7SWZCMPcksf34A2uBAbmtGbJtcxg7Kk/XYEV8w5VtyGcR6G', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Store Manager ', 'Store', 'Manager', NULL, 'manager@email.com', 6, 1, 'active', NULL, '$2y$10$liJ4KWP2BGmYTHtFx.okou.apFAdtQqZ/UwpDw2p6n5GJrfzXCh7u', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Data Entry', 'Data', 'Entry', NULL, 'dataentry@email.com', 7, 1, 'active', NULL, '$2y$10$eSGTr2yXXD9hsv8VzdqDUeyvE/kxpOmZy6z9NEvQPZ9JU1J1A6vUq', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_warehouses`
--

CREATE TABLE `user_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_warehouses`
--

INSERT INTO `user_warehouses` (`id`, `user_id`, `warehouse_id`, `created_at`, `updated_at`) VALUES
(8, 1, 1, NULL, NULL),
(9, 2, 1, NULL, NULL),
(10, 3, 1, NULL, NULL),
(11, 4, 1, NULL, NULL),
(12, 5, 1, NULL, NULL),
(13, 6, 1, NULL, NULL),
(14, 7, 1, NULL, NULL),
(15, 8, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `attribute_id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, '2022-12-17 20:44:14', '2022-12-17 20:44:14'),
(2, 1, 1, NULL, NULL, '2022-12-17 20:44:40', '2022-12-17 20:44:40'),
(3, 1, 1, NULL, NULL, '2022-12-17 20:44:48', '2022-12-17 20:44:48'),
(4, 2, 1, NULL, NULL, '2022-12-17 20:44:59', '2022-12-17 20:44:59'),
(5, 2, 1, NULL, NULL, '2022-12-17 20:45:08', '2022-12-17 20:45:08'),
(6, 2, 1, NULL, NULL, '2022-12-17 20:45:15', '2022-12-17 20:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `variation_detail`
--

CREATE TABLE `variation_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variation_detail`
--

INSERT INTO `variation_detail` (`id`, `name`, `variation_id`, `language_id`) VALUES
(1, 'Black', 1, 1),
(2, 'red', 2, 1),
(3, 'blue', 3, 1),
(4, 'XL', 4, 1),
(5, 'XXL', 5, 1),
(6, 'M', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'if 1 then it is set as default warehouse for web/app',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `code`, `name`, `address`, `phone`, `email`, `country_id`, `state_id`, `status`, `is_default`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '0101', 'Default Warehouse', 'New York, USA', '0123456789', 'default@email.com', 1, 1822, 'active', 1, NULL, NULL, NULL, NULL, NULL),
(2, '010', 'online warehouse', 'haram street', '01121184148', 'islam.shaaban13@gmail.com', 65, 3223, 'active', 0, 1, NULL, NULL, '2022-12-17 21:06:36', '2022-12-17 21:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `avaliable_qty`
--
DROP TABLE IF EXISTS `avaliable_qty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `avaliable_qty`  AS SELECT `inventory`.`product_id` AS `product_id`, `inventory`.`product_combination_id` AS `product_combination_id`, `inventory`.`warehouse_id` AS `warehouse_id`, (select sum(`s_in`.`qty`) from `inventory` `s_in` where `s_in`.`stock_status` = 'IN' and `inventory`.`warehouse_id` = `s_in`.`warehouse_id` and `inventory`.`product_id` = `s_in`.`product_id` and case when `inventory`.`product_combination_id` is not null or `inventory`.`product_combination_id` <> '' then `inventory`.`product_combination_id` = `s_in`.`product_combination_id` else `inventory`.`product_id` > 0 end group by `s_in`.`warehouse_id`,`s_in`.`product_id`,`s_in`.`product_combination_id`) AS `stock_in`, (select sum(`s_out`.`qty`) from `inventory` `s_out` where `s_out`.`stock_status` = 'OUT' and `inventory`.`warehouse_id` = `s_out`.`warehouse_id` and `inventory`.`product_id` = `s_out`.`product_id` and case when `inventory`.`product_combination_id` is not null or `inventory`.`product_combination_id` <> '' then `inventory`.`product_combination_id` = `s_out`.`product_combination_id` else `inventory`.`product_id` > 0 end group by `s_out`.`warehouse_id`,`s_out`.`product_id`,`s_out`.`product_combination_id`) AS `stock_out`, (select sum(`s_in`.`qty`) from `inventory` `s_in` where `s_in`.`stock_status` = 'IN' and `inventory`.`warehouse_id` = `s_in`.`warehouse_id` and `inventory`.`product_id` = `s_in`.`product_id` and case when `inventory`.`product_combination_id` is not null or `inventory`.`product_combination_id` <> '' then `inventory`.`product_combination_id` = `s_in`.`product_combination_id` else `inventory`.`product_id` > 0 end group by `s_in`.`warehouse_id`,`s_in`.`product_id`,`s_in`.`product_combination_id`) - ifnull((select sum(`s_out`.`qty`) from `inventory` `s_out` where `s_out`.`stock_status` = 'OUT' and `inventory`.`warehouse_id` = `s_out`.`warehouse_id` and `inventory`.`product_id` = `s_out`.`product_id` and case when `inventory`.`product_combination_id` is not null or `inventory`.`product_combination_id` <> '' then `inventory`.`product_combination_id` = `s_out`.`product_combination_id` else `inventory`.`product_id` > 0 end group by `s_out`.`warehouse_id`,`s_out`.`product_id`,`s_out`.`product_combination_id`),0) AS `remaining`, `products`.`product_type` AS `product_type`, if(`products`.`product_type` = 'simple' or `products`.`product_type` = 'digital',`products`.`price`,`p_combination`.`price`) AS `price`, if(`products`.`product_type` = 'simple' or `products`.`product_type` = 'digital',`products`.`discount_price`,'0') AS `discount_price` FROM ((`inventory` left join `products` on(`products`.`id` = `inventory`.`product_id`)) left join `product_combination` `p_combination` on(`p_combination`.`id` = `inventory`.`product_combination_id`)) GROUP BY `inventory`.`warehouse_id`, `inventory`.`product_id`, `inventory`.`product_combination_id` ;

-- --------------------------------------------------------

--
-- Structure for view `coupon_order`
--
DROP TABLE IF EXISTS `coupon_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `coupon_order`  AS SELECT `orders`.`customer_id` AS `customer_id`, `orders`.`coupon_code` AS `coupon_code`, count(`orders`.`coupon_code`) AS `num_of_usage` FROM `orders` GROUP BY `orders`.`customer_id`, `orders`.`coupon_code` ;

-- --------------------------------------------------------

--
-- Structure for view `current_value`
--
DROP TABLE IF EXISTS `current_value`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `current_value`  AS SELECT `transaction_detail`.`reference_id` AS `reference_id`, sum(`transaction_detail`.`dr_amount`) - sum(`transaction_detail`.`cr_amount`) AS `total_amount`, `accounts`.`name` AS `name`, `accounts`.`type` AS `type` FROM (`accounts` left join `transaction_detail` on(`accounts`.`id` = `transaction_detail`.`account_id`)) WHERE `accounts`.`type` in ('simple_product','variable_product') GROUP BY `accounts`.`type`, `accounts`.`reference_id` HAVING sum(`transaction_detail`.`cr_amount`) - sum(`transaction_detail`.`dr_amount`) is not null ;

-- --------------------------------------------------------

--
-- Structure for view `customer_order_amount`
--
DROP TABLE IF EXISTS `customer_order_amount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customer_order_amount`  AS SELECT `orders`.`customer_id` AS `customer_id`, sum(`orders`.`order_price`) AS `order_amount` FROM `orders` GROUP BY `orders`.`customer_id` ;

-- --------------------------------------------------------

--
-- Structure for view `expense_report`
--
DROP TABLE IF EXISTS `expense_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expense_report`  AS SELECT `transaction_detail`.`description` AS `description`, `transaction_detail`.`dr_amount` AS `amount` FROM `transaction_detail` WHERE `transaction_detail`.`account_id` in (select `accounts`.`id` from `accounts` where `accounts`.`account_type` = 'expense') ;

-- --------------------------------------------------------

--
-- Structure for view `top_selling_products`
--
DROP TABLE IF EXISTS `top_selling_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top_selling_products`  AS SELECT sum(`a`.`qty`) AS `qty`, `a`.`product_id` AS `product_id` FROM (select `orders`.`id` AS `order_id`,`order_detail`.`product_id` AS `product_id`,`order_detail`.`qty` AS `qty` from (`orders` left join `order_detail` on(`order_detail`.`order_id` = `orders`.`id`))) AS `a` GROUP BY `a`.`product_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributes_created_by_foreign` (`created_by`),
  ADD KEY `attributes_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `attribute_detail`
--
ALTER TABLE `attribute_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_detail_attribute_id_foreign` (`attribute_id`),
  ADD KEY `attribute_detail_language_id_foreign` (`language_id`),
  ADD KEY `attribute_detail_name_index` (`name`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_slider_navigation_id_foreign` (`slider_navigation_id`),
  ADD KEY `banners_gallary_id_foreign` (`gallary_id`),
  ADD KEY `banners_language_id_foreign` (`language_id`);

--
-- Indexes for table `bar_code_settings`
--
ALTER TABLE `bar_code_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billers`
--
ALTER TABLE `billers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billers_gallary_id_foreign` (`gallary_id`),
  ADD KEY `billers_country_id_foreign` (`country_id`),
  ADD KEY `billers_state_id_foreign` (`state_id`),
  ADD KEY `billers_created_by_foreign` (`created_by`),
  ADD KEY `billers_updated_by_foreign` (`updated_by`),
  ADD KEY `billers_name_index` (`name`),
  ADD KEY `billers_company_name_index` (`company_name`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_categories_gallary_id_foreign` (`gallary_id`),
  ADD KEY `blog_categories_created_by_foreign` (`created_by`),
  ADD KEY `blog_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `blog_category_detail`
--
ALTER TABLE `blog_category_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_category_detail_language_id_foreign` (`language_id`),
  ADD KEY `blog_category_detail_blog_category_id_foreign` (`blog_category_id`),
  ADD KEY `blog_category_detail_name_index` (`name`);

--
-- Indexes for table `blog_news`
--
ALTER TABLE `blog_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_news_gallary_id_foreign` (`gallary_id`),
  ADD KEY `blog_news_created_by_foreign` (`created_by`),
  ADD KEY `blog_news_updated_by_foreign` (`updated_by`),
  ADD KEY `blog_news_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `blog_news_detail`
--
ALTER TABLE `blog_news_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_news_detail_blog_news_id_foreign` (`blog_news_id`),
  ADD KEY `blog_news_detail_language_id_foreign` (`language_id`),
  ADD KEY `blog_news_detail_name_index` (`name`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_gallary_id_foreign` (`gallary_id`),
  ADD KEY `brands_created_by_foreign` (`created_by`),
  ADD KEY `brands_updated_by_foreign` (`updated_by`),
  ADD KEY `brands_name_index` (`name`);

--
-- Indexes for table `business_setting`
--
ALTER TABLE `business_setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_setting_gallary_id_foreign` (`gallary_id`),
  ADD KEY `business_setting_timezone_id_foreign` (`timezone_id`),
  ADD KEY `business_setting_created_by_foreign` (`created_by`),
  ADD KEY `business_setting_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_product_id_index` (`product_id`),
  ADD KEY `cart_items_product_combination_id_index` (`product_combination_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_gallary_id_foreign` (`gallary_id`),
  ADD KEY `categories_created_by_foreign` (`created_by`),
  ADD KEY `categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `category_detail`
--
ALTER TABLE `category_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_detail_category_id_foreign` (`category_id`),
  ADD KEY `category_detail_language_id_foreign` (`language_id`),
  ADD KEY `category_detail_category_name_index` (`category_name`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `compares`
--
ALTER TABLE `compares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compares_product_id_foreign` (`product_id`),
  ADD KEY `compares_customer_id_index` (`customer_id`);

--
-- Indexes for table `constant_banners`
--
ALTER TABLE `constant_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_name_index` (`name`);

--
-- Indexes for table `coupon_setting`
--
ALTER TABLE `coupon_setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_setting_created_by_foreign` (`created_by`),
  ADD KEY `coupon_setting_updated_by_foreign` (`updated_by`),
  ADD KEY `coupon_setting_code_index` (`code`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_created_by_foreign` (`created_by`),
  ADD KEY `currency_updated_by_foreign` (`updated_by`),
  ADD KEY `currency_title_index` (`title`);

--
-- Indexes for table `current_theme`
--
ALTER TABLE `current_theme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `current_theme_created_by_foreign` (`created_by`),
  ADD KEY `current_theme_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD KEY `customers_gallary_id_foreign` (`gallary_id`),
  ADD KEY `customers_first_name_index` (`first_name`),
  ADD KEY `customers_last_name_index` (`last_name`),
  ADD KEY `customers_email_index` (`email`);

--
-- Indexes for table `customer_address_book`
--
ALTER TABLE `customer_address_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_address_book_customer_id_foreign` (`customer_id`),
  ADD KEY `customer_address_book_country_id_foreign` (`country_id`),
  ADD KEY `customer_address_book_state_id_foreign` (`state_id`);

--
-- Indexes for table `custom_css_js`
--
ALTER TABLE `custom_css_js`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_accounts`
--
ALTER TABLE `default_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `default_accounts_account_id_foreign` (`account_id`);

--
-- Indexes for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `delivery_boys_email_unique` (`email`),
  ADD UNIQUE KEY `delivery_boys_phone_number_unique` (`phone_number`),
  ADD KEY `delivery_boys_country_foreign` (`country`),
  ADD KEY `delivery_boys_state_foreign` (`state`);

--
-- Indexes for table `demo_settings`
--
ALTER TABLE `demo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template_settings`
--
ALTER TABLE `email_template_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_template_settings_created_by_foreign` (`created_by`),
  ADD KEY `email_template_settings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallary`
--
ALTER TABLE `gallary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallary_user_id_foreign` (`user_id`),
  ADD KEY `gallary_created_by_foreign` (`created_by`),
  ADD KEY `gallary_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `gallary_detail`
--
ALTER TABLE `gallary_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallary_detail_gallary_id_foreign` (`gallary_id`);

--
-- Indexes for table `gallary_tags`
--
ALTER TABLE `gallary_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallary_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `gallary_tags_gallary_id_foreign` (`gallary_id`);

--
-- Indexes for table `home_banners`
--
ALTER TABLE `home_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_product_id_index` (`product_id`),
  ADD KEY `inventory_product_combination_id_index` (`product_combination_id`),
  ADD KEY `inventory_warehouse_id_index` (`warehouse_id`),
  ADD KEY `inventory_stock_status_index` (`stock_status`),
  ADD KEY `inventory_customer_id_foreign` (`customer_id`),
  ADD KEY `inventory_created_by_foreign` (`created_by`),
  ADD KEY `inventory_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `languages_created_by_foreign` (`created_by`),
  ADD KEY `languages_updated_by_foreign` (`updated_by`),
  ADD KEY `languages_name_index` (`name`),
  ADD KEY `languages_code_index` (`code`);

--
-- Indexes for table `localizations`
--
ALTER TABLE `localizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_builders`
--
ALTER TABLE `menu_builders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_details`
--
ALTER TABLE `menu_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_details_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletter_gallary_id_foreign` (`gallary_id`);

--
-- Indexes for table `newsletter_contacts`
--
ALTER TABLE `newsletter_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `orders_currency_id_foreign` (`currency_id`),
  ADD KEY `orders_billing_country_foreign` (`billing_country`),
  ADD KEY `orders_billing_state_foreign` (`billing_state`),
  ADD KEY `orders_delivery_country_foreign` (`delivery_country`),
  ADD KEY `orders_delivery_state_foreign` (`delivery_state`);

--
-- Indexes for table `order_comments`
--
ALTER TABLE `order_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_comments_order_id_foreign` (`order_id`),
  ADD KEY `order_comments_user_id_foreign` (`user_id`),
  ADD KEY `order_comments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_detail_product_id_foreign` (`product_id`),
  ADD KEY `order_detail_order_id_foreign` (`order_id`),
  ADD KEY `order_detail_product_combination_id_foreign` (`product_combination_id`);

--
-- Indexes for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_histories_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_notes_order_id_foreign` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_detail`
--
ALTER TABLE `page_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_created_by_foreign` (`created_by`),
  ADD KEY `payment_methods_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `payment_method_descriptions`
--
ALTER TABLE `payment_method_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_method_descriptions_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payment_method_descriptions_language_id_foreign` (`language_id`),
  ADD KEY `payment_method_descriptions_name_index` (`name`);

--
-- Indexes for table `payment_method_settings`
--
ALTER TABLE `payment_method_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_method_settings_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_created_by_foreign` (`created_by`),
  ADD KEY `permission_role_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_product_slug_unique` (`product_slug`),
  ADD KEY `products_product_type_product_status_index` (`product_type`,`product_status`),
  ADD KEY `products_gallary_id_foreign` (`gallary_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_tax_id_foreign` (`tax_id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_updated_by_foreign` (`updated_by`),
  ADD KEY `products_product_status_index` (`product_status`),
  ADD KEY `products_product_type_index` (`product_type`);

--
-- Indexes for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attribute_product_id_foreign` (`product_id`),
  ADD KEY `product_attribute_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_product_id_foreign` (`product_id`),
  ADD KEY `product_category_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_combination`
--
ALTER TABLE `product_combination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_combination_product_id_foreign` (`product_id`),
  ADD KEY `product_combination_gallary_id_foreign` (`gallary_id`);

--
-- Indexes for table `product_combination_dtl`
--
ALTER TABLE `product_combination_dtl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_combination_dtl_variation_id_foreign` (`variation_id`),
  ADD KEY `product_combination_dtl_product_combination_id_foreign` (`product_combination_id`),
  ADD KEY `product_combination_dtl_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_comments`
--
ALTER TABLE `product_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_comments_customer_id_foreign` (`customer_id`),
  ADD KEY `product_comments_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_detail_product_id_foreign` (`product_id`),
  ADD KEY `product_detail_language_id_foreign` (`language_id`);

--
-- Indexes for table `product_gallary_details`
--
ALTER TABLE `product_gallary_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_gallary_details_product_id_foreign` (`product_id`),
  ADD KEY `product_gallary_details_gallary_id_foreign` (`gallary_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_review_customer_id_foreign` (`customer_id`),
  ADD KEY `product_review_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variation_product_attribute_id_foreign` (`product_attribute_id`),
  ADD KEY `product_variation_variation_id_foreign` (`variation_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `purchase_created_by_foreign` (`created_by`),
  ADD KEY `purchase_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchaser`
--
ALTER TABLE `purchaser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchaser_country_id_foreign` (`country_id`),
  ADD KEY `purchaser_state_id_foreign` (`state_id`),
  ADD KEY `purchaser_created_by_foreign` (`created_by`),
  ADD KEY `purchaser_updated_by_foreign` (`updated_by`),
  ADD KEY `purchaser_first_name_index` (`first_name`),
  ADD KEY `purchaser_last_name_index` (`last_name`),
  ADD KEY `purchaser_address_index` (`address`),
  ADD KEY `purchaser_phone_index` (`phone`),
  ADD KEY `purchaser_mobile_index` (`mobile`);

--
-- Indexes for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_detail_product_id_index` (`product_id`),
  ADD KEY `purchase_detail_product_combination_id_index` (`product_combination_id`),
  ADD KEY `purchase_detail_purchase_id_index` (`purchase_id`);

--
-- Indexes for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_created_by_foreign` (`created_by`),
  ADD KEY `purchase_return_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_details_purchase_return_id_foreign` (`purchase_return_id`),
  ADD KEY `purchase_return_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_return_details_product_id_foreign` (`product_id`),
  ADD KEY `purchase_return_details_product_combination_id_foreign` (`product_combination_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_biller_id_foreign` (`biller_id`),
  ADD KEY `quotations_supplier_id_foreign` (`supplier_id`),
  ADD KEY `quotations_customer_id_foreign` (`customer_id`),
  ADD KEY `quotations_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `quotations_tax_id_foreign` (`tax_id`),
  ADD KEY `quotations_gallary_id_foreign` (`gallary_id`),
  ADD KEY `quotations_created_by_foreign` (`created_by`),
  ADD KEY `quotations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_detail_quotation_id_foreign` (`quotation_id`),
  ADD KEY `quotation_detail_product_id_foreign` (`product_id`),
  ADD KEY `quotation_detail_product_combination_id_foreign` (`product_combination_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_name_index` (`name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `sales_tax_id_foreign` (`tax_id`),
  ADD KEY `sales_created_by_foreign` (`created_by`),
  ADD KEY `sales_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_details_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_details_product_combination_id_foreign` (`product_combination_id`),
  ADD KEY `sale_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `sale_quotations`
--
ALTER TABLE `sale_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_quotations_customer_id_foreign` (`customer_id`),
  ADD KEY `sale_quotations_customer_address_book_id_foreign` (`customer_address_book_id`),
  ADD KEY `sale_quotations_coupon_setting_id_foreign` (`coupon_setting_id`),
  ADD KEY `sale_quotations_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `sale_quotations_tax_id_foreign` (`tax_id`),
  ADD KEY `sale_quotations_created_by_foreign` (`created_by`),
  ADD KEY `sale_quotations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sale_quotation_details`
--
ALTER TABLE `sale_quotation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_quotation_details_sale_quotation_id_foreign` (`sale_quotation_id`),
  ADD KEY `sale_quotation_details_product_combination_id_foreign` (`product_combination_id`),
  ADD KEY `sale_quotation_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `sale_return`
--
ALTER TABLE `sale_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_created_by_foreign` (`created_by`),
  ADD KEY `sale_return_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_details_sale_return_id_foreign` (`sale_return_id`),
  ADD KEY `sale_return_details_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_return_details_product_id_foreign` (`product_id`),
  ADD KEY `sale_return_details_product_combination_id_foreign` (`product_combination_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_created_by_foreign` (`created_by`),
  ADD KEY `settings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_methods_created_by_foreign` (`created_by`),
  ADD KEY `shipping_methods_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `shipping_method_descriptions`
--
ALTER TABLE `shipping_method_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_method_descriptions_name_index` (`name`);

--
-- Indexes for table `shippment_with_cities`
--
ALTER TABLE `shippment_with_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shippment_with_cities_country_id_foreign` (`country_id`),
  ADD KEY `shippment_with_cities_state_id_foreign` (`state_id`),
  ADD KEY `shippment_with_cities_city_id_foreign` (`city_id`),
  ADD KEY `shippment_with_cities_shipping_method_id_foreign` (`shipping_method_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_language_id_foreign` (`language_id`),
  ADD KEY `sliders_slider_type_id_foreign` (`slider_type_id`),
  ADD KEY `sliders_slider_navigation_id_foreign` (`slider_navigation_id`),
  ADD KEY `sliders_gallary_id_foreign` (`gallary_id`),
  ADD KEY `sliders_created_by_foreign` (`created_by`),
  ADD KEY `sliders_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `slider_navigation`
--
ALTER TABLE `slider_navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_types`
--
ALTER TABLE `slider_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`),
  ADD KEY `states_name_index` (`name`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_warehouse_from_foreign` (`warehouse_from`),
  ADD KEY `stock_transfer_warehouse_to_foreign` (`warehouse_to`),
  ADD KEY `stock_transfer_created_by_foreign` (`created_by`),
  ADD KEY `stock_transfer_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `stock_transfer_detail`
--
ALTER TABLE `stock_transfer_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_detail_stock_transfer_id_foreign` (`stock_transfer_id`),
  ADD KEY `stock_transfer_detail_product_id_foreign` (`product_id`),
  ADD KEY `stock_transfer_detail_product_combination_id_foreign` (`product_combination_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_country_id_foreign` (`country_id`),
  ADD KEY `suppliers_state_id_foreign` (`state_id`),
  ADD KEY `suppliers_created_by_foreign` (`created_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_created_by_foreign` (`created_by`),
  ADD KEY `tags_updated_by_foreign` (`updated_by`),
  ADD KEY `tags_name_index` (`name`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_created_by_foreign` (`created_by`),
  ADD KEY `taxes_updated_by_foreign` (`updated_by`),
  ADD KEY `taxes_title_index` (`title`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tax_rates_tax_id_foreign` (`tax_id`),
  ADD KEY `tax_rates_state_id_foreign` (`state_id`),
  ADD KEY `tax_rates_country_id_foreign` (`country_id`),
  ADD KEY `tax_rates_created_by_foreign` (`created_by`),
  ADD KEY `tax_rates_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_offer`
--
ALTER TABLE `top_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `top_offer_language_id_foreign` (`language_id`),
  ADD KEY `top_offer_created_by_foreign` (`created_by`),
  ADD KEY `top_offer_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_detail_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_detail_account_id_foreign` (`account_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_created_by_foreign` (`created_by`),
  ADD KEY `units_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `unit_detail`
--
ALTER TABLE `unit_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_detail_unit_id_foreign` (`unit_id`),
  ADD KEY `unit_detail_language_id_foreign` (`language_id`),
  ADD KEY `unit_detail_name_index` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_created_by_foreign` (`created_by`),
  ADD KEY `users_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `user_warehouses`
--
ALTER TABLE `user_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_warehouses_user_id_foreign` (`user_id`),
  ADD KEY `user_warehouses_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variations_attribute_id_foreign` (`attribute_id`),
  ADD KEY `variations_created_by_foreign` (`created_by`),
  ADD KEY `variations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `variation_detail`
--
ALTER TABLE `variation_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_detail_variation_id_foreign` (`variation_id`),
  ADD KEY `variation_detail_language_id_foreign` (`language_id`),
  ADD KEY `variation_detail_name_index` (`name`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouses_created_by_foreign` (`created_by`),
  ADD KEY `warehouses_updated_by_foreign` (`updated_by`),
  ADD KEY `warehouses_name_index` (`name`),
  ADD KEY `warehouses_code_index` (`code`),
  ADD KEY `warehouses_address_index` (`address`),
  ADD KEY `warehouses_phone_index` (`phone`),
  ADD KEY `warehouses_email_index` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_product_id_foreign` (`product_id`),
  ADD KEY `wishlist_customer_id_index` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attribute_detail`
--
ALTER TABLE `attribute_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bar_code_settings`
--
ALTER TABLE `bar_code_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_category_detail`
--
ALTER TABLE `blog_category_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_news`
--
ALTER TABLE `blog_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_news_detail`
--
ALTER TABLE `blog_news_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_setting`
--
ALTER TABLE `business_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_detail`
--
ALTER TABLE `category_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compares`
--
ALTER TABLE `compares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `constant_banners`
--
ALTER TABLE `constant_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `coupon_setting`
--
ALTER TABLE `coupon_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `current_theme`
--
ALTER TABLE `current_theme`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_address_book`
--
ALTER TABLE `customer_address_book`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `custom_css_js`
--
ALTER TABLE `custom_css_js`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `default_accounts`
--
ALTER TABLE `default_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_settings`
--
ALTER TABLE `demo_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_template_settings`
--
ALTER TABLE `email_template_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallary`
--
ALTER TABLE `gallary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallary_detail`
--
ALTER TABLE `gallary_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gallary_tags`
--
ALTER TABLE `gallary_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_banners`
--
ALTER TABLE `home_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `localizations`
--
ALTER TABLE `localizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_builders`
--
ALTER TABLE `menu_builders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_details`
--
ALTER TABLE `menu_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletter_contacts`
--
ALTER TABLE `newsletter_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_comments`
--
ALTER TABLE `order_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_histories`
--
ALTER TABLE `order_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_notes`
--
ALTER TABLE `order_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `page_detail`
--
ALTER TABLE `page_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment_method_descriptions`
--
ALTER TABLE `payment_method_descriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_method_settings`
--
ALTER TABLE `payment_method_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_attribute`
--
ALTER TABLE `product_attribute`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_combination`
--
ALTER TABLE `product_combination`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_combination_dtl`
--
ALTER TABLE `product_combination_dtl`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_comments`
--
ALTER TABLE `product_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_gallary_details`
--
ALTER TABLE `product_gallary_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchaser`
--
ALTER TABLE `purchaser`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return`
--
ALTER TABLE `purchase_return`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_quotations`
--
ALTER TABLE `sale_quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_quotation_details`
--
ALTER TABLE `sale_quotation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return`
--
ALTER TABLE `sale_return`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1847;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_method_descriptions`
--
ALTER TABLE `shipping_method_descriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shippment_with_cities`
--
ALTER TABLE `shippment_with_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `slider_navigation`
--
ALTER TABLE `slider_navigation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slider_types`
--
ALTER TABLE `slider_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4882;

--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_transfer_detail`
--
ALTER TABLE `stock_transfer_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT for table `top_offer`
--
ALTER TABLE `top_offer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit_detail`
--
ALTER TABLE `unit_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_warehouses`
--
ALTER TABLE `user_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `variation_detail`
--
ALTER TABLE `variation_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attributes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `attribute_detail`
--
ALTER TABLE `attribute_detail`
  ADD CONSTRAINT `attribute_detail_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attribute_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `banners_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `banners_slider_navigation_id_foreign` FOREIGN KEY (`slider_navigation_id`) REFERENCES `slider_navigation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `billers`
--
ALTER TABLE `billers`
  ADD CONSTRAINT `billers_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `billers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `billers_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `billers_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `billers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blog_categories_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `blog_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `blog_category_detail`
--
ALTER TABLE `blog_category_detail`
  ADD CONSTRAINT `blog_category_detail_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`),
  ADD CONSTRAINT `blog_category_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `blog_news`
--
ALTER TABLE `blog_news`
  ADD CONSTRAINT `blog_news_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`),
  ADD CONSTRAINT `blog_news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blog_news_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `blog_news_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `blog_news_detail`
--
ALTER TABLE `blog_news_detail`
  ADD CONSTRAINT `blog_news_detail_blog_news_id_foreign` FOREIGN KEY (`blog_news_id`) REFERENCES `blog_news` (`id`),
  ADD CONSTRAINT `blog_news_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `brands_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `business_setting`
--
ALTER TABLE `business_setting`
  ADD CONSTRAINT `business_setting_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `business_setting_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `business_setting_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`),
  ADD CONSTRAINT `business_setting_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `categories_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `category_detail`
--
ALTER TABLE `category_detail`
  ADD CONSTRAINT `category_detail_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `category_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `compares`
--
ALTER TABLE `compares`
  ADD CONSTRAINT `compares_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `compares_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `coupon_setting`
--
ALTER TABLE `coupon_setting`
  ADD CONSTRAINT `coupon_setting_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `coupon_setting_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `currency_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `currency_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `current_theme`
--
ALTER TABLE `current_theme`
  ADD CONSTRAINT `current_theme_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `current_theme_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`);

--
-- Constraints for table `customer_address_book`
--
ALTER TABLE `customer_address_book`
  ADD CONSTRAINT `customer_address_book_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `customer_address_book_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_address_book_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `default_accounts`
--
ALTER TABLE `default_accounts`
  ADD CONSTRAINT `default_accounts_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  ADD CONSTRAINT `delivery_boys_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_boys_state_foreign` FOREIGN KEY (`state`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `email_template_settings`
--
ALTER TABLE `email_template_settings`
  ADD CONSTRAINT `email_template_settings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `email_template_settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `gallary`
--
ALTER TABLE `gallary`
  ADD CONSTRAINT `gallary_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `gallary_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `gallary_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `gallary_detail`
--
ALTER TABLE `gallary_detail`
  ADD CONSTRAINT `gallary_detail_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`);

--
-- Constraints for table `gallary_tags`
--
ALTER TABLE `gallary_tags`
  ADD CONSTRAINT `gallary_tags_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gallary_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inventory_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `inventory_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `inventory_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inventory_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `languages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `menu_details`
--
ALTER TABLE `menu_details`
  ADD CONSTRAINT `menu_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `newsletter_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_billing_country_foreign` FOREIGN KEY (`billing_country`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `orders_billing_state_foreign` FOREIGN KEY (`billing_state`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `orders_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_delivery_country_foreign` FOREIGN KEY (`delivery_country`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `orders_delivery_state_foreign` FOREIGN KEY (`delivery_state`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `orders_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `order_comments`
--
ALTER TABLE `order_comments`
  ADD CONSTRAINT `order_comments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `order_comments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_detail_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `order_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD CONSTRAINT `order_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD CONSTRAINT `order_notes_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_methods_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_method_descriptions`
--
ALTER TABLE `payment_method_descriptions`
  ADD CONSTRAINT `payment_method_descriptions_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `payment_method_descriptions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);

--
-- Constraints for table `payment_method_settings`
--
ALTER TABLE `payment_method_settings`
  ADD CONSTRAINT `payment_method_settings_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`),
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `permission_role_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `products_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`),
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD CONSTRAINT `product_attribute_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`),
  ADD CONSTRAINT `product_attribute_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `product_category_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_combination`
--
ALTER TABLE `product_combination`
  ADD CONSTRAINT `product_combination_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `product_combination_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_combination_dtl`
--
ALTER TABLE `product_combination_dtl`
  ADD CONSTRAINT `product_combination_dtl_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `product_combination_dtl_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_combination_dtl_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);

--
-- Constraints for table `product_comments`
--
ALTER TABLE `product_comments`
  ADD CONSTRAINT `product_comments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `product_comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD CONSTRAINT `product_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `product_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_gallary_details`
--
ALTER TABLE `product_gallary_details`
  ADD CONSTRAINT `product_gallary_details_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `product_gallary_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_review_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `product_review_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD CONSTRAINT `product_variation_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attribute` (`id`),
  ADD CONSTRAINT `product_variation_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchase_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `purchaser`
--
ALTER TABLE `purchaser`
  ADD CONSTRAINT `purchaser_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `purchaser_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchaser_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `purchaser_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD CONSTRAINT `purchase_detail_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `purchase_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_detail_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`);

--
-- Constraints for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD CONSTRAINT `purchase_return_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_return_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD CONSTRAINT `purchase_return_details_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `purchase_return_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_return_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`),
  ADD CONSTRAINT `purchase_return_details_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_return` (`id`);

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_biller_id_foreign` FOREIGN KEY (`biller_id`) REFERENCES `billers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD CONSTRAINT `quotation_detail_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotation_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotation_detail_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`),
  ADD CONSTRAINT `sales_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `sale_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sale_quotations`
--
ALTER TABLE `sale_quotations`
  ADD CONSTRAINT `sale_quotations_coupon_setting_id_foreign` FOREIGN KEY (`coupon_setting_id`) REFERENCES `coupon_setting` (`id`),
  ADD CONSTRAINT `sale_quotations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sale_quotations_customer_address_book_id_foreign` FOREIGN KEY (`customer_address_book_id`) REFERENCES `customer_address_book` (`id`),
  ADD CONSTRAINT `sale_quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sale_quotations_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`),
  ADD CONSTRAINT `sale_quotations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sale_quotations_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `sale_quotation_details`
--
ALTER TABLE `sale_quotation_details`
  ADD CONSTRAINT `sale_quotation_details_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `sale_quotation_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_quotation_details_sale_quotation_id_foreign` FOREIGN KEY (`sale_quotation_id`) REFERENCES `sale_quotations` (`id`);

--
-- Constraints for table `sale_return`
--
ALTER TABLE `sale_return`
  ADD CONSTRAINT `sale_return_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sale_return_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD CONSTRAINT `sale_return_details_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`),
  ADD CONSTRAINT `sale_return_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_return_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sale_return_details_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_return` (`id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD CONSTRAINT `shipping_methods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shipping_methods_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `shippment_with_cities`
--
ALTER TABLE `shippment_with_cities`
  ADD CONSTRAINT `shippment_with_cities_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `shippment_with_cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `shippment_with_cities_shipping_method_id_foreign` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`),
  ADD CONSTRAINT `shippment_with_cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sliders_gallary_id_foreign` FOREIGN KEY (`gallary_id`) REFERENCES `gallary` (`id`),
  ADD CONSTRAINT `sliders_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `sliders_slider_navigation_id_foreign` FOREIGN KEY (`slider_navigation_id`) REFERENCES `slider_navigation` (`id`),
  ADD CONSTRAINT `sliders_slider_type_id_foreign` FOREIGN KEY (`slider_type_id`) REFERENCES `slider_types` (`id`),
  ADD CONSTRAINT `sliders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD CONSTRAINT `stock_transfer_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_transfer_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_transfer_warehouse_from_foreign` FOREIGN KEY (`warehouse_from`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_transfer_warehouse_to_foreign` FOREIGN KEY (`warehouse_to`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_transfer_detail`
--
ALTER TABLE `stock_transfer_detail`
  ADD CONSTRAINT `stock_transfer_detail_product_combination_id_foreign` FOREIGN KEY (`product_combination_id`) REFERENCES `product_combination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_transfer_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_transfer_detail_stock_transfer_id_foreign` FOREIGN KEY (`stock_transfer_id`) REFERENCES `stock_transfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `suppliers_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `taxes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD CONSTRAINT `tax_rates_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `tax_rates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tax_rates_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `tax_rates_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`),
  ADD CONSTRAINT `tax_rates_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `top_offer`
--
ALTER TABLE `top_offer`
  ADD CONSTRAINT `top_offer_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `top_offer_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `top_offer_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD CONSTRAINT `transaction_detail_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_detail_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `unit_detail`
--
ALTER TABLE `unit_detail`
  ADD CONSTRAINT `unit_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `unit_detail_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_warehouses`
--
ALTER TABLE `user_warehouses`
  ADD CONSTRAINT `user_warehouses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_warehouses_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `variations`
--
ALTER TABLE `variations`
  ADD CONSTRAINT `variations_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`),
  ADD CONSTRAINT `variations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `variations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `variation_detail`
--
ALTER TABLE `variation_detail`
  ADD CONSTRAINT `variation_detail_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `variation_detail_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `warehouses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `warehouses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `wishlist_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
