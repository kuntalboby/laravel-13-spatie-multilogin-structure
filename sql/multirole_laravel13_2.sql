-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 12:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multirole_laravel13`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'User who created the brand',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand_logo` varchar(255) DEFAULT NULL,
  `brand_code` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=active, 1=inactive',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=active, 1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `randomid`, `user_id`, `name`, `slug`, `brand_logo`, `brand_code`, `description`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'tMiYooRfyGgb6M6nf1lh', 1, 'Puma', 'puma', '1793967203_7M5hDP17ae.png', 'puma', 'International Brand.', '0', '0', '2026-11-06 04:59:27', '2026-11-06 06:43:23'),
(2, 'MSAFijYcnx0066Lg4olN', 1, 'Nike', 'nike', NULL, 'nike', 'Nike Shoes are famous', '0', '0', '2026-11-06 04:59:49', '2026-11-06 04:59:49'),
(3, 'xgksLyJUGm5Y6ibc6Pqb', 1, 'Turtle', 'turtle', NULL, 'turtle', 'Specially a Garments company', '0', '0', '2026-11-06 05:00:49', '2026-11-06 05:00:49'),
(4, 'Fy5aU37O46ehxOZA2H06', 1, 'U.S Polo. Assn', 'u.s polo. assn', '1793967161_QAZVrQiPJO.png', 'us polo assn', 'Nice Brand.Hign Qualifty Shirt', '0', '0', '2026-11-06 06:25:24', '2026-11-06 06:42:41'),
(5, 'FxSmpfXgKBFA0a0vzzas', 1, 'Wrong', 'wrong', '1793967399_inbDykWJdt.png', 'wrong', 'Nice', '0', '0', '2026-11-06 06:46:39', '2026-11-06 06:46:39'),
(6, 'eywOvqSi5l5O5F6Hs8td', 1, 'Allen Solly', 'allen-solly', '1794214165_98qq2Tuuja.png', 'allen solly', NULL, '0', '0', '2026-11-09 03:19:25', '2026-11-09 03:19:25'),
(7, 'UqkVeLvjEcFgi1SpCxR8', 1, 'Sangria', 'sangria', NULL, 'Sangria', 'Kids wear specialist', '0', '0', '2026-11-13 01:47:47', '2026-11-13 01:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `brand_sizes`
--

CREATE TABLE `brand_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `gender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(20) DEFAULT NULL COMMENT 'Size value for the brand size',
  `product_type` enum('T','B','S') NOT NULL DEFAULT 'T' COMMENT 'T=Topwear, B=Bottomwear, S=Shoes',
  `size_of` enum('A','K') NOT NULL DEFAULT 'A' COMMENT 'Sizes for adults / kids',
  `size_chart` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand_sizes`
--

INSERT INTO `brand_sizes` (`id`, `randomid`, `brand_id`, `gender_id`, `category_id`, `size`, `product_type`, `size_of`, `size_chart`, `created_at`, `updated_at`) VALUES
(1, 'khx56cdas3d', 2, 1, 3, NULL, 'T', 'A', NULL, NULL, NULL),
(2, 'hZjhBE8jwiuYJOc', 2, 2, 3, '4', 'S', 'A', '{\"length\":\"12|31.2\"}', '2026-11-08 00:59:41', '2026-11-08 00:59:41'),
(3, 'Xu7qfls9SmlSptg', 2, 2, 3, '4.5', 'S', 'A', '{\"length\":\"14|36\"}', '2026-11-08 00:59:41', '2026-11-08 00:59:41'),
(4, 'FcHBmbvi69adobv', 2, 2, 3, '5', 'S', 'A', '{\"length\":\"15|38\"}', '2026-11-08 00:59:41', '2026-11-08 00:59:41'),
(5, 'YBhXYJoPfRPQwQo', 2, 2, 3, '5.5', 'S', 'A', '{\"length\":\"16|40\"}', '2026-11-08 00:59:41', '2026-11-08 00:59:41'),
(6, 'GVJ44UBkLnxyobI', 4, 1, 9, 's', 'T', 'A', '{\"chest\":\"39.5|100.3\",\"across_shoulder\":\"17|71.1\",\"length\":\"28|43.2\"}', '2026-11-08 01:34:27', '2026-11-08 01:34:27'),
(7, 'Eh8oeerGPiQIpXc', 4, 1, 9, 'm', 'T', 'A', '{\"chest\":\"41.5|105.40\",\"across_shoulder\":\"18|73.7\",\"length\":\"29|45.7\"}', '2026-11-08 01:34:27', '2026-11-08 01:38:18'),
(8, 'BkmDAniEdQKloHw', 4, 1, 9, 'l', 'T', 'A', '{\"chest\":\"45|114.3\",\"across_shoulder\":\"19|74.9\",\"length\":\"29.5|48.3\"}', '2026-11-08 01:34:27', '2026-11-08 01:34:27'),
(9, '3AGYFwwp86Zs1XD', 4, 1, 9, 'XL', 'T', 'A', '{\"chest\":\"47|119.4\",\"across_shoulder\":\"31|78.7\",\"length\":\"20|50.8\"}', '2026-11-08 01:34:27', '2026-11-08 01:34:27'),
(10, 'r94z0OJ99C2HYxD', 4, 1, 9, 'XXL', 'T', 'A', '{\"chest\":\"50.5|128.3\",\"across_shoulder\":\"31.5|80\",\"length\":\"21|53.3\"}', '2026-11-08 01:34:27', '2026-11-08 01:34:27'),
(11, 'L2Zn42Ogj2ynzta', 4, 1, 9, '24', 'T', 'K', '{\"chest\":\"26|61\",\"sleeve_length\":\"6|15.2\",\"length\":\"17|43.2\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(12, 'F5vTPLTo1oRXQdo', 4, 1, 9, '26', 'T', 'K', '{\"chest\":\"28|66.0\",\"sleeve_length\":\"6.5|16.5\",\"length\":\"18|45.7\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(13, '78JRZIBFkmALCMn', 4, 1, 9, '28', 'T', 'K', '{\"chest\":\"30|71.1\",\"sleeve_length\":\"7|17.8\",\"length\":\"19.5|49.5\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(14, 'FyTWcbCxEIFgLlf', 4, 1, 9, '30', 'T', 'K', '{\"chest\":\"32|76.2\",\"sleeve_length\":\"7|17.8\",\"length\":\"21|53.3\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(15, 'n22CwSQQKFjF2ac', 4, 1, 9, '32', 'T', 'K', '{\"chest\":\"34|81.3\",\"sleeve_length\":\"7.5|19.1\",\"length\":\"22.5|57.2\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(16, 'd0DnPHOmXn5tNav', 4, 1, 9, '34', 'T', 'K', '{\"chest\":\"36|86.4\",\"sleeve_length\":\"7.75|19.7\",\"length\":\"24|61\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(17, 'AO5BJPaTxnRjwIj', 4, 1, 9, '36', 'T', 'K', '{\"chest\":\"38|91.4\",\"sleeve_length\":\"8.25|21\",\"length\":\"25.5|64.8\"}', '2026-11-10 04:48:15', '2026-11-10 04:48:15'),
(18, 'i5EbgH5szfvqYzB', 7, 1, 11, '1-2y', 'T', 'K', '{\"chest\":\"25|64.8\",\"across_shoulder\":\"10|25.4\",\"sleeve_length\":\"22|55.9\",\"length\":\"20|50.8\"}', '2026-11-13 02:06:06', '2026-11-13 02:06:06'),
(19, 'a3Y0f3OtuSDa5gR', 7, 1, 11, '2-3y', 'T', 'K', '{\"chest\":\"27|68.6\",\"across_shoulder\":\"10.5|26.7\",\"sleeve_length\":\"24|61.0\",\"length\":\"22|55.9\"}', '2026-11-13 02:06:06', '2026-11-13 02:06:06'),
(20, 'PKeSCEkl7Udfkkz', 7, 1, 11, '3-4y', 'T', 'K', '{\"chest\":\"28|71.1\",\"across_shoulder\":\"11|27.9\",\"sleeve_length\":\"26|66\",\"length\":\"23|58.4\"}', '2026-11-13 02:06:06', '2026-11-13 02:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('multi-role-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:24:{i:0;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"category.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:1;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"category.add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:2;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"category.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:3;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"category.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:4;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"product_sizes.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:5;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"product_sizes.add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:6;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:20:\"product_sizes.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:7;a:3:{s:1:\"a\";i:16;s:1:\"b\";s:20:\"product_sizes.delete\";s:1:\"c\";s:3:\"web\";}i:8;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:13:\"customer.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:9;a:3:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"customer.add\";s:1:\"c\";s:3:\"web\";}i:10;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"customer.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:11;a:3:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"customer.delete\";s:1:\"c\";s:3:\"web\";}i:12;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:18:\"product_color.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:13;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:17:\"product_color.add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:14;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:20:\"product_color.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:15;a:3:{s:1:\"a\";i:24;s:1:\"b\";s:20:\"product_color.delete\";s:1:\"c\";s:3:\"web\";}i:16;a:3:{s:1:\"a\";i:25;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:3:\"web\";}i:17;a:3:{s:1:\"a\";i:26;s:1:\"b\";s:9:\"roles.add\";s:1:\"c\";s:3:\"web\";}i:18;a:3:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:3:\"web\";}i:19;a:3:{s:1:\"a\";i:28;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:3:\"web\";}i:20;a:3:{s:1:\"a\";i:29;s:1:\"b\";s:19:\"product_brands.view\";s:1:\"c\";s:3:\"web\";}i:21;a:3:{s:1:\"a\";i:30;s:1:\"b\";s:18:\"product_brands.add\";s:1:\"c\";s:3:\"web\";}i:22;a:3:{s:1:\"a\";i:31;s:1:\"b\";s:21:\"product_brands.update\";s:1:\"c\";s:3:\"web\";}i:23;a:3:{s:1:\"a\";i:32;s:1:\"b\";s:21:\"product_brands.delete\";s:1:\"c\";s:3:\"web\";}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"manager\";s:1:\"c\";s:3:\"web\";}}}', 1794637258);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'created by user',
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `featured` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->No',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->inactive',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->deleted',
  `sequence` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `randomid`, `name`, `parent_id`, `user_id`, `slug`, `image`, `description`, `featured`, `status`, `is_deleted`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'kj15vf5ch5', 'Topwear', 0, 3, 'topwear', NULL, 'Lorem ipsum dummy text.', '1', '0', '0', 0, '2026-11-03 04:13:59', '2026-11-03 05:33:37'),
(2, 'qo5Eg41nBIGF4FgEdFAS', 'Bottomwear', 0, 4, 'bottomwear', NULL, 'Lorem ipsum text.', '1', '0', '0', 0, '2026-11-04 03:13:22', '2026-11-06 05:56:26'),
(3, 'Ga6l4vT50U6ITyImZzuP', 'Shoes', 2, 1, 'shoes', NULL, NULL, '1', '0', '0', 0, '2026-11-06 10:37:36', '2026-11-06 10:37:36'),
(4, '99vwYShxHOKzDzkbNoZW', 'Sneakers', 3, 1, 'sneakers', NULL, 'Nike,Puma are popular brands', '1', '0', '0', 0, '2026-11-06 10:38:29', '2026-11-06 10:38:29'),
(5, 'SMcqXMnOYWdV8kV1yWyZ', 'Flip Flops', 3, 1, 'flip flops', NULL, NULL, '1', '0', '0', 0, '2026-11-06 10:38:49', '2026-11-06 10:38:49'),
(6, 'PagSBN66coNsdENYJCbV', 'Loafers', 3, 1, 'loafers', NULL, NULL, '1', '0', '0', 0, '2026-11-06 10:39:32', '2026-11-06 10:39:32'),
(7, 't2LXx0Hr7fIQqZIoJkRB', 'Casual Shirts', 1, 1, 'casual shirts', NULL, 'Casual Shirt might be a good choice', '1', '0', '0', 0, '2026-11-08 01:04:26', '2026-11-08 01:04:26'),
(8, 'TVol78wlf3RVkOZ4xjzu', 'Formal Shirts', 1, 1, 'formal shirts', NULL, 'For meetings,Office.', '1', '0', '0', 0, '2026-11-08 01:05:04', '2026-11-08 01:05:04'),
(9, 'lll2NneZWHI82oUYIX0n', 'TShirt', 1, 1, 'tshirt', NULL, 'There are various type of tshirts.', '1', '0', '0', 0, '2026-11-08 01:41:45', '2026-11-08 01:41:45'),
(10, 'WlsClvflTqSMORtYbVrk', 'Ethnic wear', 1, 1, 'ethnic wear', NULL, 'There are various type of tshirts.', '1', '0', '0', 0, '2026-11-13 01:50:49', '2026-11-13 01:53:54'),
(11, 'IiA3aoyrUtsEbfnmQ3WL', 'Kurta', 10, 1, 'kurta', NULL, NULL, '1', '0', '0', 0, '2026-11-13 01:54:27', '2026-11-13 01:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'User who created this color',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color_code` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1=inactive, 0=active',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `randomid`, `user_id`, `name`, `slug`, `color_code`, `description`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'y92Utndp5QTVLAWraMZC', 1, 'BLACK/WHITE', 'blackwhite', 'linear-gradient(135deg,#000000 50%,#FFFFFF 50%)', 'Black and white combination.', '0', '0', '2026-11-06 01:52:13', '2026-11-06 01:52:13'),
(2, '1AsLSgTCbmN5oCCi3Fa0', 1, 'WHITE/BLACK', 'whiteblack', 'linear-gradient(135deg,#FFFFFF 50%,#000000 50%)', 'White and Black Combination', '0', '0', '2026-11-06 01:55:14', '2026-11-06 01:55:14'),
(3, 'Fm2pqFI02YZ2T7g7db7s', 1, 'D GREY/BLACK', 'd-greyblack', 'linear-gradient(135deg,#4F4F4F 50%,#000000 50%)', NULL, '0', '0', '2026-11-06 01:55:28', '2026-11-06 01:55:28'),
(4, 'l8Y00Cq2t9LEXNBdc0A5', 1, 'ANTHRA/BLACK', 'anthrablack', 'linear-gradient(135deg,#2F3033 50%,#000000 50%)', NULL, '0', '0', '2026-11-06 01:55:40', '2026-11-06 01:55:40'),
(5, 'Z45WlG5lNKHGpVG3rfpS', 1, 'BLACK/DSTCAC', 'black/dstcac', 'linear-gradient(135deg,#000000 50%,#68725D 50%)', 'Nice Color', '0', '0', '2026-11-06 01:55:58', '2026-11-06 05:22:12'),
(6, 'x0JbF6JgaBUPhFQqnXCI', 1, 'LTOWBR/ARMRNV', 'ltowbrarmrnv', 'linear-gradient(135deg,#D9C8A9 50%,#34485E 50%)', NULL, '0', '0', '2026-11-06 01:56:06', '2026-11-06 01:56:06'),
(7, 'qTzgLPKbBIIsvBmObr2y', 1, 'Yellow-1', 'yellow-1', '#fad976', NULL, '0', '0', '2026-11-13 02:11:58', '2026-11-13 02:11:58'),
(8, 'EgsaYLRziTDDqyWgUtAK', 1, 'Blue-1', 'blue-1', '#5379c4', NULL, '0', '0', '2026-11-13 02:12:50', '2026-11-13 02:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Male', NULL, NULL),
(2, 'Female', NULL, NULL),
(3, 'Unisex', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
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
(4, '2026_10_31_061127_create_permission_tables', 2),
(5, '2026_10_31_062715_update_users_table', 3),
(6, '2026_10_31_063620_add_random_id_users_table', 4),
(7, '2026_11_02_060335_create_modules_table', 5),
(8, '2026_11_03_064523_create_categories_table', 6),
(9, '2026_11_03_071908_add_is_del_to_categories', 7),
(10, '2026_11_03_103412_add_randomid_in_category', 8),
(11, '2026_11_03_134035_add_is_deleted', 9),
(12, '2026_11_04_082539_add_user_id_to_category', 10),
(13, '2026_11_04_162642_create_sizes_table', 11),
(14, '2026_11_04_162952_create_colors_table', 11),
(15, '2026_11_06_061814_add_randomid_size_table', 12),
(16, '2026_11_06_072115_add_randomid_size_table', 13),
(17, '2026_11_06_074521_create_brands_table', 14),
(18, '2026_11_06_075102_create_brand_sizes_table', 14),
(19, '2026_11_06_112711_create_genders_table', 15),
(20, '2026_11_06_112833_add_gender_id_to_brand_size', 16),
(21, '2026_11_06_144054_add_size_fld', 16),
(22, '2026_11_06_144727_drop_size_id_fld', 17),
(23, '2026_11_07_101207_add_size_for_to_sizes_table', 18),
(24, '2026_11_07_154347_remove_size_unit', 19),
(25, '2026_11_08_073040_create_products_table', 20),
(26, '2026_11_08_083223_create_product_prices_table', 20),
(27, '2026_11_08_090504_add_is_promostional', 21),
(28, '2026_11_08_155734_add_product_for', 22),
(29, '2026_11_08_161508_add_product_fld_form_step_counter', 23),
(30, '2026_11_10_102302_add_size_for_in_brand_size', 24),
(31, '2026_11_11_104622_create_product_galleries_table', 25),
(32, '2026_11_11_115321_add_file_type_in_product_galleries', 26),
(33, '2026_11_11_143116_add_gst_and_mrp', 27),
(34, '2026_11_11_145042_add_buying_p_sku', 27),
(35, '2026_11_11_145615_update_hsn_code', 28),
(36, '2026_11_12_051358_add_selling_price', 29),
(37, '2026_11_12_065853_add_is_deleted', 30),
(38, '2026_11_12_081143_add_related_product_fld', 31);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`actions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `slug`, `actions`, `created_at`, `updated_at`) VALUES
(2, 'Category', 'category', '[\"view\",\"add\",\"update\",\"delete\"]', '2026-11-02 01:28:17', '2026-11-02 01:28:17'),
(3, 'Product Sizes', 'product_sizes', '[\"view\",\"add\",\"update\",\"delete\"]', '2026-11-02 01:48:00', '2026-11-02 01:48:00'),
(4, 'Customer', 'customer', '[\"view\",\"add\",\"update\",\"delete\"]', '2026-11-02 01:48:33', '2026-11-02 01:48:33'),
(5, 'Product Color', 'product_color', '[\"view\",\"add\",\"update\",\"delete\"]', '2026-11-02 03:20:27', '2026-11-02 03:20:27'),
(6, 'Roles', 'roles', '[\"view\",\"add\",\"update\",\"delete\"]', '2026-11-03 01:02:35', '2026-11-03 01:02:35'),
(7, 'Product Brands', 'product_brands', '[\"view\",\"add\",\"update\",\"delete\"]', '2026-11-06 03:37:52', '2026-11-06 03:37:52');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(9, 'category.view', 'web', '2026-11-02 01:28:17', '2026-11-02 01:28:17'),
(10, 'category.add', 'web', '2026-11-02 01:28:17', '2026-11-02 01:28:17'),
(11, 'category.update', 'web', '2026-11-02 01:28:17', '2026-11-02 01:28:17'),
(12, 'category.delete', 'web', '2026-11-02 01:28:17', '2026-11-02 01:28:17'),
(13, 'product_sizes.view', 'web', '2026-11-02 01:48:00', '2026-11-02 01:48:00'),
(14, 'product_sizes.add', 'web', '2026-11-02 01:48:00', '2026-11-02 01:48:00'),
(15, 'product_sizes.update', 'web', '2026-11-02 01:48:00', '2026-11-02 01:48:00'),
(16, 'product_sizes.delete', 'web', '2026-11-02 01:48:00', '2026-11-02 01:48:00'),
(17, 'customer.view', 'web', '2026-11-02 01:48:34', '2026-11-02 01:48:34'),
(18, 'customer.add', 'web', '2026-11-02 01:48:34', '2026-11-02 01:48:34'),
(19, 'customer.update', 'web', '2026-11-02 01:48:34', '2026-11-02 01:48:34'),
(20, 'customer.delete', 'web', '2026-11-02 01:48:34', '2026-11-02 01:48:34'),
(21, 'product_color.view', 'web', '2026-11-02 03:20:30', '2026-11-02 03:20:30'),
(22, 'product_color.add', 'web', '2026-11-02 03:20:31', '2026-11-02 03:20:31'),
(23, 'product_color.update', 'web', '2026-11-02 03:20:32', '2026-11-02 03:20:32'),
(24, 'product_color.delete', 'web', '2026-11-02 03:20:32', '2026-11-02 03:20:32'),
(25, 'roles.view', 'web', '2026-11-03 01:02:41', '2026-11-03 01:02:41'),
(26, 'roles.add', 'web', '2026-11-03 01:02:41', '2026-11-03 01:02:41'),
(27, 'roles.update', 'web', '2026-11-03 01:02:41', '2026-11-03 01:02:41'),
(28, 'roles.delete', 'web', '2026-11-03 01:02:42', '2026-11-03 01:02:42'),
(29, 'product_brands.view', 'web', '2026-11-06 03:37:53', '2026-11-06 03:37:53'),
(30, 'product_brands.add', 'web', '2026-11-06 03:37:56', '2026-11-06 03:37:56'),
(31, 'product_brands.update', 'web', '2026-11-06 03:37:56', '2026-11-06 03:37:56'),
(32, 'product_brands.delete', 'web', '2026-11-06 03:37:56', '2026-11-06 03:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'who created this',
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `gender_id` bigint(20) UNSIGNED NOT NULL,
  `product_for` enum('A','K') NOT NULL DEFAULT 'A' COMMENT 'Product for Adult/kids',
  `gst` decimal(5,2) NOT NULL DEFAULT 0.00,
  `hsn_code` varchar(255) NOT NULL DEFAULT '0',
  `short_description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `related_product_hash_tag` text DEFAULT NULL COMMENT 'same tagged products are related products',
  `is_featured` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->Featured',
  `is_promotional` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->yes',
  `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0->active,1->inactive,2->comming soon',
  `form_step_counter` int(11) NOT NULL DEFAULT 1 COMMENT 'Check all forms are filled up or not',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->deleted',
  `launching_date` datetime DEFAULT NULL COMMENT 'If status is comming soon',
  `image` varchar(255) DEFAULT NULL COMMENT 'Default Image',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `randomid`, `slug`, `manufacturing_date`, `user_id`, `brand_id`, `category_id`, `gender_id`, `product_for`, `gst`, `hsn_code`, `short_description`, `long_description`, `related_product_hash_tag`, `is_featured`, `is_promotional`, `status`, `form_step_counter`, `is_deleted`, `launching_date`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Brand Logo Printed Pure Cotton Slim Fit  shirt', 'ljpAjuY0Q5mcrciLVMKi', 'U.S Polo. Assn-us-polo-assn', NULL, 1, 4, 9, 1, 'A', 5.00, '0', 'Story: Keep it classic with this solid men\'s T-shirt from Working Holiday, perfect for casual occasions and versatile styling.', NULL, '#pureCotton #roundNeck #multiColor', '1', '0', '0', 2, '0', NULL, 'BZpHx9fvJYmVhQ9fsPoOjycNAZYCXyCwJ0rSoPZd.jpg', '2026-11-09 03:08:05', '2026-11-13 03:27:33'),
(2, 'Graphic Printed Round Neck Oversized Cotton T-shirt', 'KifCb4BwsTqgICvhQSej', 'Allen Solly-allen-solly', NULL, 1, 6, 9, 1, 'A', 0.00, '0', 'Casual,Graphic Print Others, pure cotton T shirt for men', NULL, NULL, '1', '0', '0', 1, '0', NULL, '0Wv1heCUuh2RU55vJyJs4pWjxD53XZdpQeXODaYj.jpg', '2026-11-09 03:22:57', '2026-11-09 03:22:57'),
(3, 'Boys Abstract Printed Cotton Straight Kurta', 'RtIg79GwtT2Inky0eDYe', 'Sangria-sangria', NULL, 1, 7, 11, 1, 'K', 5.00, '0', '100% Original Products Pay on delivery might be available Easy 7 days returns and exchanges', NULL, '#kidsYellow', '0', '0', '0', 2, '0', NULL, 'Vh1S6AA06FBUHQnWMwksbA3G7RU88BAb80X5Gh49.jpg', '2026-11-13 02:23:57', '2026-11-13 04:52:44'),
(4, 'Girls Ethnic Motifs Embroidered Regular Thread Work Kurta with Trousers & With Dupatta', '5ELequQX4XmD7ehNgi0F', 'sangriasangria-1', NULL, 1, 7, 11, 2, 'K', 3.00, '0', '100% Original Products Pay on delivery might be available Easy 7 days returns and exchanges', NULL, NULL, '0', '0', '1', 1, '0', NULL, 'PjFpeYBWnpaEafXdzL0bmxBpouODJpTAvjDLfsRO.jpg', '2026-11-13 02:47:34', '2026-11-13 02:47:34'),
(5, 'Girls Ethnic Motifs Regular Kurta', 'M5TVgJmZZFKlo52qzw68', 'Sangria Girls Ethnic Motifs Regular Kurta-sangria-girls-ethnic-motifs-regular-kurta', NULL, 1, 7, 11, 2, 'K', 2.00, '0', 'High quality', 'Lorem ipsum long des', '#nice', '0', '1', '0', 1, '0', NULL, 'hjNAwyPVG8qzWyyPUKwDWslHKFzoUMEKmDpuEN9E.jpg', '2026-11-13 03:44:10', '2026-11-13 03:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_galleries`
--

CREATE TABLE `product_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sorting_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_galleries`
--

INSERT INTO `product_galleries` (`id`, `product_id`, `color_id`, `file_name`, `file_type`, `name`, `sorting_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'TpYDhyF883XE0icEdsx6pfpiJWr9FQeWGkw8Vq4i.jpg', 'image', 'images (8).jpg', 1, '2026-11-11 06:46:55', '2026-11-11 07:05:47'),
(2, 1, 1, 'cx5OmfBX3iz8yD5JTzAMemkJ3grLrTL7P5xwatvQ.png', 'image', 'f4ce8d364f1cb2799c7e07f505f2.png', 3, '2026-11-11 06:46:55', '2026-11-11 07:05:47'),
(3, 1, 4, 'aG5f3USHuJM3WZSnLdOCGoigYcPSiK6B0A8zBePM.jpg', 'image', 'bg-2.jpg', 2, '2026-11-11 06:47:16', '2026-11-11 07:05:52'),
(4, 1, 4, 'MKIdnQ7uhfU35WquHAUz5IVE7gMtGqxdSbhwtBib.jpg', 'image', 'bg-1.jpg', 1, '2026-11-11 06:47:17', '2026-11-11 07:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `brand_size_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `buying_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` decimal(10,2) NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->inactive',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_id`, `sku`, `brand_size_id`, `color_id`, `buying_price`, `discount_percentage`, `mrp_price`, `selling_price`, `quantity`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(9, 1, 'TSH-L-1', 8, 1, 550.00, 1.00, 707.00, 721.14, 35, '0', '0', '2026-11-11 02:56:03', '2026-11-11 23:56:26'),
(10, 1, 'TSH-S', 6, 1, 550.00, 5.50, 899.00, 876.53, 27, '0', '0', '2026-11-11 03:00:51', '2026-11-11 23:56:26'),
(11, 1, 'TSH-S-2', 6, 4, 600.00, 3.00, 785.00, 785.00, 30, '1', '0', '2026-11-11 03:00:52', '2026-11-11 23:56:26'),
(12, 1, 'TSH-M-1', 7, 1, 550.00, 0.00, 799.00, 822.97, 15, '1', '0', '2026-11-11 03:00:55', '2026-11-11 23:56:26'),
(13, 1, 'TSH-M-2', 7, 4, 700.00, 4.00, 809.00, 800.91, 35, '0', '0', '2026-11-11 03:00:55', '2026-11-11 23:56:26'),
(14, 1, 'TSH-XXL-1', 10, 1, 650.00, 2.00, 780.00, 787.80, 5, '0', '0', '2026-11-11 10:12:57', '2026-11-11 23:56:26'),
(15, 1, 'SHT-hjy-1', 6, 6, 530.00, 5.00, 800.00, 782.80, 50, '0', '0', '2026-11-12 01:20:08', '2026-11-12 01:20:08'),
(16, 1, 'SHT-hjy-2', 7, 6, 535.00, 0.00, 800.00, 824.00, 20, '0', '0', '2026-11-12 01:20:08', '2026-11-12 01:20:08'),
(29, 3, 'KURTA-KID-001', 18, 7, 350.00, 50.00, 1299.00, 714.45, 15, '0', '0', '2026-11-13 04:16:19', '2026-11-13 04:16:19'),
(30, 3, 'KURTA-KID-002', 18, 8, 350.00, 50.00, 1299.00, 714.45, 15, '0', '0', '2026-11-13 04:16:19', '2026-11-13 04:16:19'),
(31, 3, 'KURTA-KID-003', 19, 7, 350.00, 30.00, 1299.00, 974.25, 15, '0', '0', '2026-11-13 04:16:19', '2026-11-13 04:16:19'),
(32, 3, 'KURTA-KID-004', 19, 8, 350.00, 40.00, 1299.00, 844.35, 15, '0', '0', '2026-11-13 04:16:19', '2026-11-13 04:16:19'),
(33, 3, 'KURTA-KID-005', 20, 7, 350.00, 60.00, 1299.00, 584.55, 15, '0', '0', '2026-11-13 04:16:19', '2026-11-13 04:16:19'),
(34, 3, 'KURTA-KID-006', 20, 8, 350.00, 55.00, 1299.00, 649.50, 15, '0', '0', '2026-11-13 04:16:19', '2026-11-13 04:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-10-31 02:38:18', '2026-10-31 02:38:18'),
(2, 'manager', 'web', '2026-10-31 02:38:18', '2026-10-31 02:38:18'),
(3, 'customer', 'web', '2026-10-31 02:38:18', '2026-10-31 02:38:18');

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
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(17, 2),
(19, 2),
(21, 2),
(22, 2),
(23, 2);

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
('f8XVzFx56HBvu3qtfNn1IQbZoUtEKMno3t54rDL8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJMbHM1R2V0UE4zNEx3YmZnQXR4STB6YThCOUNWOEhYMWhlT0d0MElhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbWFzdGVyc1wvY2F0ZWdvcnlcL2luZGV4Iiwicm91dGUiOiJhZG1pbi5tYXN0ZXJzLmNhdGVnb3J5In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiZjJjNTQ4MzVjNDJlZjMyNjM5NjU5MGI0NjRlNDE1NmUwZWMzY2ZiNGNhMjc1YTEyYmQ0N2NmNTYwMjRjNTRkNCJ9', 1794573337),
('sj6s43K2Kla3pYdm7GdCpruoMFLYnvitjDn8v1iU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJrUGsyMHM4SXZxVU5veTh5QnIwNWVNeDA4R3F0SmRjeTI3Znl5V1FlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbWFzdGVyc1wvYnJhbmRcL2NyZWF0ZS1zaXplXC9VcWtWZUx2akVjRmdpMVNwQ3hSOCIsInJvdXRlIjoiYWRtaW4ubWFzdGVycy5icmFuZC5jcmVhdGVTaXplIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiZjJjNTQ4MzVjNDJlZjMyNjM5NjU5MGI0NjRlNDE1NmUwZWMzY2ZiNGNhMjc1YTEyYmQ0N2NmNTYwMjRjNTRkNCJ9', 1794567449);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'User who created this size',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `size_for` enum('T','B','S') NOT NULL DEFAULT 'T' COMMENT 'T=Topwear, B=Bottomwear, S=Shoes',
  `target_age` enum('A','K') NOT NULL DEFAULT 'A' COMMENT 'A=For Adult, K=For Kids',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1=inactive, 0=active',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `randomid`, `user_id`, `name`, `slug`, `description`, `size_for`, `target_age`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'AHoQtMJZL2N18b2MmmgO', 1, 'xs', 'xs', NULL, 'T', 'A', '0', '0', '2026-11-06 01:10:19', '2026-11-06 01:10:19'),
(2, 'hIBXFOJzYebTibPFCpWE', 1, 's', 's', NULL, 'T', 'A', '0', '0', '2026-11-06 01:10:27', '2026-11-06 01:10:27'),
(3, 'dx05ggbsiusNmLCg592R', 1, 'm', 'm', NULL, 'T', 'A', '0', '0', '2026-11-06 01:10:32', '2026-11-06 01:10:32'),
(4, 'zKVv59i4GJHGUbaKLaUe', 1, 'l', 'l', NULL, 'T', 'A', '0', '0', '2026-11-06 01:10:40', '2026-11-06 01:10:40'),
(5, 'qsZy6iXjHDBlq61q5a2k', 1, 'XL', 'xl', NULL, 'T', 'A', '0', '0', '2026-11-06 01:10:50', '2026-11-06 01:10:50'),
(6, 'MMVjByZZxwys1am0CGQE', 1, 'XXL', 'xxl', NULL, 'T', 'A', '0', '0', '2026-11-06 01:10:54', '2026-11-06 01:10:54'),
(7, '5vVK0Qo1qvSzpLZiYqzB', 1, 'XXXL', 'xxxl', NULL, 'T', 'A', '0', '0', '2026-11-06 01:11:07', '2026-11-06 01:11:07'),
(8, 'arcy3xaI27uJsZ5Sy5tL', 1, '4', '4', NULL, 'S', 'K', '0', '0', '2026-11-06 01:11:16', '2026-11-06 01:11:16'),
(9, 'XaWz62ML2Axjx3fAJ1n6', 1, '4.5', '45', NULL, 'S', 'K', '0', '0', '2026-11-06 01:11:22', '2026-11-06 01:11:22'),
(10, 'OhiUe24mL9x2Ejy8AKMb', 1, '5', '5', NULL, 'S', 'K', '0', '0', '2026-11-06 01:11:25', '2026-11-06 01:11:25'),
(11, 'rIXkhyEWZ9iWrnNou92i', 1, '5.5', '55', NULL, 'S', 'K', '0', '0', '2026-11-06 01:11:30', '2026-11-06 01:11:30'),
(12, '9QZDteODTyi8hCAgAUK0', 1, '6', '6', NULL, 'S', 'A', '0', '0', '2026-11-06 01:11:33', '2026-11-06 01:11:33'),
(13, 'WXhdyDKxmH9xPdKtqZX3', 1, '7', '7', NULL, 'S', 'A', '0', '0', '2026-11-06 01:11:36', '2026-11-06 01:11:36'),
(14, 'ATs33Vgj72wsr8I4uOII', 1, '7.5', '75', NULL, 'S', 'A', '0', '0', '2026-11-06 01:11:43', '2026-11-06 01:11:43'),
(15, 'TJk7OpdpZ3wve0vGvzMt', 1, '8', '8', NULL, 'S', 'A', '0', '0', '2026-11-06 01:12:24', '2026-11-06 01:12:24'),
(16, 'ocwtAq7AGzBl6bb0BEVy', 1, '8.5', '85', NULL, 'S', 'A', '0', '0', '2026-11-06 01:12:35', '2026-11-06 01:12:35'),
(17, 'VKLdCXNYHEhCRMrQJmFn', 1, '10.5', '10.5', NULL, 'S', 'A', '1', '0', '2026-11-06 01:12:42', '2026-11-06 05:22:57'),
(18, 'HbU8zZS3xLgYD5m5iSSj', 1, '24', '24', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:26', '2026-11-10 03:37:26'),
(19, 'EDRuJD8yrDMMLnf0h86I', 1, '26', '26', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:31', '2026-11-10 03:37:31'),
(20, 'DWlOYr5Em8b3ZncJ0EyK', 1, '28', '28', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:34', '2026-11-10 03:37:34'),
(21, 'GWKVVLjViG65iAW5GDCR', 1, '30', '30', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:38', '2026-11-10 03:37:38'),
(22, 'tgCAnxVGc553oJexIfbf', 1, '32', '32', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:43', '2026-11-10 03:37:43'),
(23, 'MGP29gCeMfWnOU7iKjon', 1, '34', '34', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:47', '2026-11-10 03:37:47'),
(24, 'KXdUL1Eomg4zwtX23EV0', 1, '36', '36', NULL, 'T', 'K', '0', '0', '2026-11-10 03:37:50', '2026-11-10 03:37:50'),
(25, 'By6OpOYdjuaMiCgiaAWM', 1, '1-2y', '1-2y', NULL, 'T', 'K', '0', '0', '2026-11-13 01:55:01', '2026-11-13 01:55:01'),
(26, '8efuk6tXaohhUJtYYkPd', 1, '2-3y', '2-3y', NULL, 'T', 'K', '0', '0', '2026-11-13 01:55:18', '2026-11-13 01:55:18'),
(27, 'DwoL4xBuPt0iSzAv0Si6', 1, '3-4y', '3-4y', NULL, 'T', 'K', '0', '0', '2026-11-13 01:55:24', '2026-11-13 01:55:24'),
(28, 'Mcxp1myMhECeK43Db1AG', 1, '4-5y', '4-5y', NULL, 'T', 'K', '0', '0', '2026-11-13 05:19:43', '2026-11-13 05:19:43'),
(29, 'iX70rYMrQ8vw7Hl1vZa6', 1, '5-6y', '5-6y', NULL, 'T', 'K', '1', '0', '2026-11-13 05:21:32', '2026-11-13 05:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `randomid` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('M','F','T') NOT NULL DEFAULT 'M',
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0->active,1->pending,2->suspended,3->inactive',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1->deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `randomid`, `first_name`, `last_name`, `gender`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'jdsh1dc1s5f75', 'Edward', 'Fisherman', 'M', 'admin@mailinator.com', '2026-10-31 01:34:47', '$2y$12$0EmTcj9ECXt.0GvnS5qNWucDxHcztRFTriv8OC3kZFLMXVpjJkw2S', '1Qm6PpuHvUxln0HRzVfGKyZZweGvcxSIVK2fclubGRwRMubsTF3FmVWSz5XG', 0, '0', '2026-10-31 01:34:47', '2026-11-04 00:58:12'),
(2, 'hcv45f6chs', 'Ricky', 'Ponting', 'M', 'ricky@mailinator.com', '2026-10-31 01:37:08', '$2y$12$PLPGwAZJBCM2L2hWWjr8QuyIje00.3UZxhJjQteLcvGOsUjATbAPK', 'MUdnvNik22', 0, '0', '2026-10-31 01:37:08', '2026-10-31 01:37:08'),
(3, 'm4cdg43cji', 'Morgan', 'Whyt', 'M', 'white@mailinator.com', '2026-10-31 01:37:09', '$2y$12$FiUE4z95jhvaeiZGkr9X6.TdCYvI8rlGnUEH6bM6sx4mfSIqbb74S', 'hQFXRmTlLj1a3SlXl16yXrVmJ6ZEHjtEEixXQjb9zBAy6A4hFa0DrLp6FWvt', 0, '0', '2026-10-31 01:37:09', '2026-11-04 01:03:48'),
(4, '3T3JImkyCKLhP3DVWc4o', 'Manager', 'One', 'M', 'manager1@mailinator.com', NULL, '$2y$12$GympDc4y8U1L4g5enWGW9OGWbd3XlWvuxtv54hk60yraUNXPBj45y', 'jIC9bFW09QZEz0q6UWmzURLUdba794et400N8WQrCayaP3r7DasoWehUPiSh', 0, '0', '2026-11-04 01:41:15', '2026-11-04 07:17:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_randomid_unique` (`randomid`),
  ADD UNIQUE KEY `brands_name_unique` (`name`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`),
  ADD KEY `brands_user_id_foreign` (`user_id`);

--
-- Indexes for table `brand_sizes`
--
ALTER TABLE `brand_sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_sizes_randomid_unique` (`randomid`),
  ADD KEY `brand_sizes_brand_id_foreign` (`brand_id`),
  ADD KEY `brand_sizes_category_id_foreign` (`category_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD UNIQUE KEY `categories_randomid_unique` (`randomid`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_name_unique` (`name`),
  ADD UNIQUE KEY `colors_slug_unique` (`slug`),
  ADD UNIQUE KEY `colors_randomid_unique` (`randomid`),
  ADD KEY `colors_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genders_name_unique` (`name`);

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
  ADD UNIQUE KEY `modules_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_randomid_unique` (`randomid`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `products_name_index` (`name`),
  ADD KEY `products_brand_id_index` (`brand_id`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_gender_id_index` (`gender_id`);

--
-- Indexes for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_galleries_product_id_foreign` (`product_id`),
  ADD KEY `product_galleries_color_id_foreign` (`color_id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_prices_product_id_foreign` (`product_id`),
  ADD KEY `product_prices_brand_size_id_foreign` (`brand_size_id`),
  ADD KEY `product_prices_color_id_foreign` (`color_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sizes_name_unique` (`name`),
  ADD UNIQUE KEY `sizes_slug_unique` (`slug`),
  ADD UNIQUE KEY `sizes_randomid_unique` (`randomid`),
  ADD KEY `sizes_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_randomid_unique` (`randomid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `brand_sizes`
--
ALTER TABLE `brand_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_galleries`
--
ALTER TABLE `product_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `brand_sizes`
--
ALTER TABLE `brand_sizes`
  ADD CONSTRAINT `brand_sizes_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brand_sizes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD CONSTRAINT `product_galleries_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_galleries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD CONSTRAINT `product_prices_brand_size_id_foreign` FOREIGN KEY (`brand_size_id`) REFERENCES `brand_sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_prices_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
