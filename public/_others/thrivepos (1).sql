-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 02:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thrivepos`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'updated', 'App\\Models\\Order', 'updated', 17, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-14 02:34:13', '2026-02-14 02:34:13'),
(2, 'default', 'updated', 'App\\Models\\Order', 'updated', 19, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-14 02:34:35', '2026-02-14 02:34:35'),
(3, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 00:44:24', '2026-02-16 00:44:24'),
(4, 'default', 'updated', 'App\\Models\\Order', 'updated', 10, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 00:45:11', '2026-02-16 00:45:11'),
(5, 'default', 'updated', 'App\\Models\\Order', 'updated', 11, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 04:24:26', '2026-02-16 04:24:26'),
(6, 'default', 'updated', 'App\\Models\\Order', 'updated', 21, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 04:49:34', '2026-02-16 04:49:34'),
(7, 'default', 'updated', 'App\\Models\\Order', 'updated', 20, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 04:49:42', '2026-02-16 04:49:42'),
(8, 'default', 'updated', 'App\\Models\\Order', 'updated', 23, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 09:28:47', '2026-02-16 09:28:47'),
(9, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 09:33:32', '2026-02-16 09:33:32'),
(10, 'default', 'updated', 'App\\Models\\Order', 'updated', 25, 'App\\Models\\User', 2, '{\"attributes\":{\"order_status\":\"complete\"},\"old\":{\"order_status\":\"pending\"}}', NULL, '2026-02-16 09:40:39', '2026-02-16 09:40:39'),
(11, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 2, '{\"attributes\":[],\"old\":[]}', NULL, '2026-02-16 09:44:53', '2026-02-16 09:44:53'),
(12, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 2, '{\"attributes\":[],\"old\":[]}', NULL, '2026-02-16 09:55:17', '2026-02-16 09:55:17'),
(13, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 2, '{\"attributes\":[],\"old\":[]}', NULL, '2026-02-16 09:56:34', '2026-02-16 09:56:34'),
(14, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 2, '{\"attributes\":{\"payment_status\":\"paid\",\"order_status\":\"complete\"},\"old\":{\"payment_status\":\"partial\",\"order_status\":\"pending\"}}', NULL, '2026-02-16 09:56:58', '2026-02-16 09:56:58'),
(15, 'default', 'updated', 'App\\Models\\Order', 'updated', 25, 'App\\Models\\User', 2, '{\"attributes\":{\"payment_status\":\"paid\",\"order_status\":\"complete\"},\"old\":{\"payment_status\":\"due\",\"order_status\":\"pending\"}}', NULL, '2026-02-16 10:09:37', '2026-02-16 10:09:37'),
(16, 'default', 'updated', 'App\\Models\\Order', 'updated', 28, 'App\\Models\\User', 2, '{\"attributes\":{\"payment_status\":\"paid\",\"order_status\":\"complete\"},\"old\":{\"payment_status\":\"partial\",\"order_status\":\"pending\"}}', NULL, '2026-02-16 10:20:13', '2026-02-16 10:20:13'),
(17, 'default', 'updated', 'App\\Models\\Order', 'updated', 29, 'App\\Models\\User', 2, '{\"attributes\":{\"payment_status\":\"paid\",\"order_status\":\"complete\"},\"old\":{\"payment_status\":\"partial\",\"order_status\":\"pending\"}}', NULL, '2026-02-16 10:25:01', '2026-02-16 10:25:01'),
(18, 'default', 'updated', 'App\\Models\\Order', 'updated', 30, 'App\\Models\\User', 2, '{\"attributes\":[],\"old\":[]}', NULL, '2026-02-16 10:30:33', '2026-02-16 10:30:33'),
(19, 'default', 'updated', 'App\\Models\\Order', 'updated', 30, 'App\\Models\\User', 2, '{\"attributes\":[],\"old\":[]}', NULL, '2026-02-16 10:30:44', '2026-02-16 10:30:44'),
(20, 'default', 'updated', 'App\\Models\\Order', 'updated', 30, 'App\\Models\\User', 2, '{\"attributes\":[],\"old\":[]}', NULL, '2026-02-16 10:31:00', '2026-02-16 10:31:00'),
(21, 'default', 'updated', 'App\\Models\\Order', 'updated', 30, 'App\\Models\\User', 2, '{\"attributes\":{\"payment_status\":\"paid\",\"order_status\":\"complete\"},\"old\":{\"payment_status\":\"partial\",\"order_status\":\"pending\"}}', NULL, '2026-02-16 10:31:13', '2026-02-16 10:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `advance_salaries`
--

CREATE TABLE `advance_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `advance_salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advance_salaries`
--

INSERT INTO `advance_salaries` (`id`, `employee_id`, `month`, `year`, `request_date`, `advance_salary`, `created_at`, `updated_at`) VALUES
(16, 62, 'March', '2026', '2026-02-16', '1000', '2026-02-16 11:02:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `attend_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `date`, `attend_status`, `created_at`, `updated_at`) VALUES
(181, 1, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(182, 2, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(183, 5, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(184, 7, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(185, 8, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(186, 10, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(187, 14, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(188, 17, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(189, 18, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(190, 19, '2026-02-06', 'present', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(191, 20, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(192, 21, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(193, 22, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(194, 23, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(195, 24, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(196, 25, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(197, 26, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(198, 27, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(199, 28, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(200, 29, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(201, 30, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(202, 31, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(203, 32, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(204, 33, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(205, 34, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(206, 35, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(207, 36, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(208, 37, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(209, 38, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(210, 39, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(211, 40, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(212, 41, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(213, 42, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(214, 43, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(215, 44, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(216, 45, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(217, 46, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(218, 47, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(219, 48, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(220, 49, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(221, 50, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(222, 51, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(223, 52, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(224, 53, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(225, 54, '2026-02-06', 'Absent', '2026-02-05 01:30:45', '2026-02-05 01:30:45'),
(250, 1, '2026-02-16', 'Present', '2026-02-16 07:25:46', '2026-02-16 07:25:46'),
(251, 2, '2026-02-16', 'Leave', '2026-02-16 07:25:46', '2026-02-16 07:25:46'),
(252, 55, '2026-02-16', 'Absent', '2026-02-16 07:25:46', '2026-02-16 07:25:46'),
(253, 56, '2026-02-16', 'Leave', '2026-02-16 07:25:46', '2026-02-16 07:25:46'),
(254, 1, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(255, 2, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(256, 5, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(257, 7, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(258, 8, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(259, 10, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(260, 14, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(261, 17, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(262, 18, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(263, 19, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(264, 20, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(265, 21, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(266, 22, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(267, 23, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(268, 24, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(269, 25, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(270, 26, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(271, 27, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(272, 28, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(273, 29, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(274, 30, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(275, 31, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(276, 32, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(277, 33, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(278, 34, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(279, 35, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(280, 36, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(281, 37, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(282, 38, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(283, 39, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(284, 40, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(285, 41, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(286, 42, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(287, 43, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(288, 44, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(289, 45, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(290, 46, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(291, 47, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(292, 48, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(293, 49, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(294, 50, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(295, 51, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(296, 52, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(297, 53, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(298, 54, '2026-02-13', 'Present', '2026-02-16 07:43:23', '2026-02-16 07:43:23'),
(299, 1, '2026-01-14', 'Present', '2026-02-16 07:44:55', '2026-02-16 07:44:55'),
(300, 2, '2026-01-14', 'Absent', '2026-02-16 07:44:55', '2026-02-16 07:44:55'),
(301, 55, '2026-01-14', 'Leave', '2026-02-16 07:44:55', '2026-02-16 07:44:55'),
(302, 56, '2026-01-14', 'Present', '2026-02-16 07:44:55', '2026-02-16 07:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(3, 'Electronics & Accessories', '2026-02-16 08:32:22', '2026-02-16 08:32:22'),
(4, 'Health & Personal Care', '2026-02-16 08:32:11', '2026-02-16 08:32:11'),
(5, 'Groceries & Essentials', '2026-02-16 08:32:01', '2026-02-16 08:32:01'),
(6, 'Food & Beverages', '2026-02-16 08:31:49', '2026-02-16 08:31:49'),
(8, 'Household Supplies', '2026-02-16 08:32:33', NULL),
(9, 'Clothing & Apparel', '2026-02-16 08:32:45', NULL),
(10, 'Beauty & Cosmetics', '2026-02-16 08:32:55', NULL),
(11, 'Office & School Supplies', '2026-02-16 08:33:05', NULL),
(12, 'Automotive Accessories', '2026-02-16 08:33:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `name`, `address`, `logo`, `contact`, `email`, `tin`, `created_at`, `updated_at`) VALUES
(1, 'Thrive ICT Solutions Corporation', 'Pasay City', 'upload/company/1856632482515236.png', '12345654', 'sales@thriveictsolutions.corp', '123-900-000-000', NULL, '2026-02-16 05:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shopname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `shopname`, `image`, `account_holder`, `account_number`, `bank_name`, `bank_branch`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Star City', 'star@gmail.com', '12345678', 'Pasay City', 'Star City', 'upload/customer/1856636378212082.jpg', '1', '1', '1', '1', '1', '2026-01-20 02:10:02', '2026-02-09 08:40:28'),
(2, 'Patrick Spongebob', 'gmr@gmail.com', '12345678', '1', '1', 'upload/customer/1856636429828757.png', '1', '1', '1', '1', 'r', '2026-01-19 23:36:25', '2026-02-16 08:22:59'),
(4, 'Walkin Customer', 'generic@gmail.com', '0', 'Generic', 'Walk In', 'upload/customer/1857259218216058.png', NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:11', '2026-02-16 05:40:15'),
(9, 'Katerine Bernardo', 'bernardo@gmail.com', '806-841-0491', NULL, 'Kris Group', 'upload/customer/1856636344802660.png', NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:11', '2026-02-09 08:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `address`, `designation`, `experience`, `image`, `salary`, `vacation`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Leni Robredo', 'leni@gmail.com', '12345678', 'Bicol', NULL, '5 Year', 'upload/employee/1856634041925232.jpg', '3134', '2', 'r', '2026-01-18 03:17:36', '2026-02-09 00:03:20'),
(2, 'Gringo Honasan', 'gringo@yahoo.com', '1423', 'Muntinlupa', NULL, NULL, 'upload/employee/1856634028965906.jpg', '6274', '2', 'r', '2026-01-18 03:18:13', '2026-02-09 00:03:08'),
(55, 'Cory Aquino', 'cory@gmail.com', '12345678', 'Forbes Park Makati', NULL, NULL, 'upload/employee/1856634015357741.png', '15000', NULL, NULL, '2026-02-08 22:33:06', '2026-02-16 08:22:05'),
(56, 'Manuel Quezon', 'manuel@gmail.com', '123456789', 'Quezon City', NULL, NULL, 'upload/employee/1856633966779900.png', '1345', NULL, NULL, '2026-02-08 22:33:47', '2026-02-09 00:02:09'),
(58, 'Bongbong Marcos', 'bongbong@gmail.com', '09174561209', 'Malacanang', 'Commander in Chief', NULL, 'upload/employee/1857267885153303.webp', '10000', NULL, NULL, '2026-02-16 07:58:00', '2026-02-16 08:08:46'),
(62, 'Emilio Aguinaldo', 'emilio@gmail.com', '123654789', 'Cavite', 'Chief of Staff', NULL, 'upload/employee/1857268524690287.png', '14500', NULL, NULL, '2026-02-16 08:01:20', '2026-02-16 08:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `reference_no`, `category_id`, `details`, `amount`, `date`, `month`, `year`, `receipt`, `created_at`, `updated_at`) VALUES
(15, 'EXP-ZMBHEHBV', NULL, 'testing', '120.00', '2026-02-16', 'February', '2026', NULL, '2026-02-16 11:03:58', '2026-02-16 11:03:58');

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
(1, '2014_10_12_000001_create_users_table', 1),
(2, '2014_10_12_100001_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000001_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_18_093811_create_employees_table', 2),
(6, '2026_01_20_072114_create_customers_table', 3),
(7, '2026_01_20_101229_create_suppliers_table', 4),
(8, '2026_01_20_104329_create_advance_salaries_table', 5),
(9, '2026_01_21_104452_create_pay_salaries_table', 6),
(10, '2026_02_05_082956_create_attendances_table', 7),
(11, '2026_02_05_093744_create_categories_table', 8),
(12, '2026_02_05_094657_create_products_table', 9),
(13, '2026_02_06_034913_create_expenses_table', 10),
(14, '2026_02_07_074752_create_orders_table', 11),
(15, '2026_02_07_075323_create_orderdetails_table', 12),
(16, '2026_02_07_090054_create_permission_tables', 13),
(17, '2026_02_09_070153_create_company_settings_table', 14),
(18, '2026_02_09_195824_create_activity_log_table', 15),
(19, '2026_02_09_195825_add_event_column_to_activity_log_table', 15),
(20, '2026_02_09_195826_add_batch_uuid_column_to_activity_log_table', 15),
(21, '2026_02_14_112611_add_request_date_to_advance_salaries', 16),
(22, '2026_02_16_104452_create_pay_salaries_table', 17),
(23, '2026_02_16_034913_create_expenses_table', 18),
(24, '2026_02_16_174906_create_order_payments_table', 19);

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
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unitcost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `order_id`, `product_id`, `quantity`, `unitcost`, `total`, `created_at`, `updated_at`) VALUES
(63, 23, 20, '1', '25', '25', NULL, NULL),
(64, 23, 19, '1', '150', '150', NULL, NULL),
(65, 24, 20, '2', '25', '50', NULL, NULL),
(66, 24, 19, '1', '150', '150', NULL, NULL),
(67, 25, 19, '1', '150', '150', NULL, NULL),
(68, 27, 19, '3', '150', '450', NULL, NULL),
(69, 27, 20, '3', '25', '75', NULL, NULL),
(70, 28, 20, '30', '25', '750', NULL, NULL),
(71, 29, 19, '16', '150', '2400', NULL, NULL),
(72, 30, 19, '3', '150', '450', NULL, NULL),
(73, 31, 19, '2', '150', '300', NULL, NULL),
(74, 31, 21, '1', '150', '150', NULL, NULL),
(75, 32, 19, '9', '150', '1350', NULL, NULL),
(76, 32, 21, '3', '150', '450', NULL, NULL),
(77, 32, 20, '1', '25', '25', NULL, NULL),
(78, 33, 21, '1', '150', '150', NULL, NULL),
(79, 34, 20, '1', '25', '25', NULL, NULL),
(80, 35, 19, '1', '150', '150', NULL, NULL),
(81, 36, 21, '1', '150', '150', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_products` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_value` decimal(10,2) DEFAULT 0.00,
  `discount_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `order_status`, `total_products`, `sub_total`, `vat`, `invoice_no`, `total`, `payment_status`, `pay`, `due`, `created_at`, `updated_at`, `payment_method`, `discount_type`, `discount_value`, `discount_amount`) VALUES
(23, 4, '2026-02-16', 'complete', '2', '175.00', '18.75', 'EPOS57347219', '175.00', 'paid', '175.00', '0', '2026-02-16 08:55:11', '2026-02-16 09:28:46', 'cash', 'percent', '0.00', '0.00'),
(24, 4, '2026-02-16', 'complete', '3', '200.00', '21.43', 'EPOS91361993', '200.00', 'paid', '200', '0', '2026-02-16 09:10:58', '2026-02-16 09:56:58', 'cash', 'percent', '0.00', '0.00'),
(25, 4, '2026-02-16', 'complete', '1', '150.00', '16.07', 'EPOS20371234', '150.00', 'paid', '150', '0', '2026-02-16 09:11:20', '2026-02-16 10:09:37', 'cash', 'percent', '0.00', '0.00'),
(26, 9, '2026-02-16', 'complete', '6', '525.00', '50.63', 'EPOS48633498', '472.50', 'paid', '472.50', '0', '2026-02-16 10:17:21', NULL, 'cash', 'percent', '10.00', '52.50'),
(27, 9, '2026-02-16', 'complete', '6', '525.00', '50.63', 'EPOS30341644', '472.50', 'paid', '472.50', '0', '2026-02-16 10:18:02', NULL, 'cash', 'percent', '10.00', '52.50'),
(28, 2, '2026-02-16', 'complete', '30', '750.00', '80.36', 'EPOS54627571', '750.00', 'paid', '750', '0', '2026-02-16 10:19:44', '2026-02-16 10:20:13', 'cash', 'percent', '0.00', '0.00'),
(29, 1, '2026-02-16', 'complete', '16', '2400.00', '257.14', 'EPOS26825850', '2400.00', 'paid', '2400', '0', '2026-02-16 10:24:13', '2026-02-16 10:25:01', 'cash', 'percent', '0.00', '0.00'),
(30, 1, '2026-02-16', 'complete', '3', '450.00', '48.21', 'EPOS11618286', '450.00', 'paid', '543', '0', '2026-02-16 10:29:06', '2026-02-16 10:31:13', 'cash', 'percent', '0.00', '0.00'),
(31, 4, '2026-02-16', 'complete', '3', '450.00', '43.39', 'EPOS82983937', '405.00', 'paid', '405.00', '0', '2026-02-16 10:58:34', NULL, 'cash', 'percent', '10.00', '45.00'),
(32, 4, '2026-02-17', 'complete', '122', '1825.00', '175.98', 'EPOS20980089', '1642.50', 'paid', '1642.50', '0', '2026-02-17 00:48:35', NULL, 'cash', 'percent', '10.00', '182.50'),
(33, 4, '2026-02-17', 'complete', '0', '150.00', '16.07', 'EPOS56535658', '150.00', 'paid', '150.00', '0', '2026-02-17 01:00:23', NULL, 'cash', 'percent', '0.00', '0.00'),
(34, 4, '2026-02-17', 'complete', '0', '25.00', '2.68', 'EPOS64672303', '25.00', 'paid', '25.00', '0', '2026-02-17 01:09:25', NULL, 'cash', 'percent', '0.00', '0.00'),
(35, 4, '2026-02-17', 'complete', '0', '150.00', '16.07', 'EPOS26035050', '150.00', 'paid', '200', '0', '2026-02-17 01:12:09', NULL, 'cash', 'percent', '0.00', '0.00'),
(36, 4, '2026-02-17', 'pending', '0', '150.00', '16.07', 'EPOS87663930', '150.00', 'due', '0', '150', '2026-02-17 01:13:07', NULL, 'cash', 'percent', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_payments`
--

INSERT INTO `order_payments` (`id`, `order_id`, `amount`, `payment_method`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 24, '50.00', 'cash', '2026-02-16 09:55:17', '2026-02-16 09:55:17', '2026-02-16 09:55:17'),
(2, 24, '12.00', 'cash', '2026-02-16 09:56:34', '2026-02-16 09:56:34', '2026-02-16 09:56:34'),
(3, 24, '63.00', 'cash', '2026-02-16 09:56:58', '2026-02-16 09:56:58', '2026-02-16 09:56:58'),
(4, 25, '150.00', 'cash', '2026-02-16 10:09:37', '2026-02-16 10:09:37', '2026-02-16 10:09:37'),
(5, 27, '472.50', 'cash', '2026-02-16 10:18:02', '2026-02-16 10:18:02', '2026-02-16 10:18:02'),
(6, 28, '150.00', 'cash', '2026-02-16 10:19:44', '2026-02-16 10:19:44', '2026-02-16 10:19:44'),
(7, 28, '600.00', 'cash', '2026-02-16 10:20:13', '2026-02-16 10:20:13', '2026-02-16 10:20:13'),
(8, 29, '250.00', 'cash', '2026-02-16 10:24:13', '2026-02-16 10:24:13', '2026-02-16 10:24:13'),
(9, 29, '2150.00', 'cash', '2026-02-16 10:25:01', '2026-02-16 10:25:01', '2026-02-16 10:25:01'),
(10, 30, '15.00', 'cash', '2026-02-16 10:29:06', '2026-02-16 10:29:06', '2026-02-16 10:29:06'),
(11, 30, '30.00', 'cash', '2026-02-16 10:30:33', '2026-02-16 10:30:33', '2026-02-16 10:30:33'),
(12, 30, '48.00', 'cash', '2026-02-16 10:30:44', '2026-02-16 10:30:44', '2026-02-16 10:30:44'),
(13, 30, '350.00', 'cash', '2026-02-16 10:31:00', '2026-02-16 10:31:00', '2026-02-16 10:31:00'),
(14, 30, '100.00', 'cash', '2026-02-16 10:31:13', '2026-02-16 10:31:13', '2026-02-16 10:31:13'),
(15, 31, '405.00', 'cash', '2026-02-16 10:58:34', '2026-02-16 10:58:34', '2026-02-16 10:58:34'),
(16, 32, '1642.50', 'cash', '2026-02-17 00:48:35', '2026-02-17 00:48:35', '2026-02-17 00:48:35'),
(17, 33, '150.00', 'cash', '2026-02-17 01:00:23', '2026-02-17 01:00:23', '2026-02-17 01:00:23'),
(18, 34, '25.00', 'cash', '2026-02-17 01:09:25', '2026-02-17 01:09:25', '2026-02-17 01:09:25'),
(19, 35, '200.00', 'cash', '2026-02-17 01:12:09', '2026-02-17 01:12:09', '2026-02-17 01:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_salaries`
--

CREATE TABLE `pay_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `pay_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `salary_month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary_year` year(4) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `advance_salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `allowance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deduction` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(2, 'employee.all', 'web', 'employee', '2026-02-07 01:23:23', '2026-02-07 01:23:23'),
(3, 'employee.menu', 'web', 'employee', '2026-02-07 01:23:40', '2026-02-07 01:23:40'),
(4, 'employee.add', 'web', 'employee', '2026-02-07 01:23:50', '2026-02-07 01:23:50'),
(5, 'employee.edit', 'web', 'employee', '2026-02-07 01:24:01', '2026-02-07 01:24:01'),
(6, 'employee.delete', 'web', 'employee', '2026-02-07 01:24:15', '2026-02-07 01:24:15'),
(7, 'customer.menu', 'web', 'customer', '2026-02-07 01:27:30', '2026-02-07 01:27:30'),
(8, 'customer.all', 'web', 'customer', '2026-02-07 01:27:42', '2026-02-07 01:27:42'),
(9, 'customer.add', 'web', 'customer', '2026-02-07 01:27:54', '2026-02-07 01:27:54'),
(10, 'customer.edit', 'web', 'customer', '2026-02-07 01:28:18', '2026-02-07 01:28:18'),
(11, 'customer.delete', 'web', 'customer', '2026-02-07 01:28:35', '2026-02-07 01:28:35'),
(12, 'supplier.menu', 'web', 'supplier', '2026-02-07 01:28:46', '2026-02-07 01:28:46'),
(13, 'supplier.all', 'web', 'supplier', '2026-02-07 01:28:57', '2026-02-07 01:28:57'),
(14, 'supplier.add', 'web', 'supplier', '2026-02-07 01:29:08', '2026-02-07 01:29:08'),
(15, 'supplier.edit', 'web', 'supplier', '2026-02-07 01:29:22', '2026-02-07 01:29:22'),
(16, 'supplier.delete', 'web', 'supplier', '2026-02-07 01:29:32', '2026-02-07 01:29:32'),
(17, 'salary.menu', 'web', 'salary', '2026-02-07 01:29:46', '2026-02-07 01:29:46'),
(18, 'salary.add', 'web', 'salary', '2026-02-07 01:29:57', '2026-02-07 01:29:57'),
(19, 'salary.all', 'web', 'salary', '2026-02-07 01:30:07', '2026-02-07 01:30:07'),
(20, 'salary.pay', 'web', 'salary', '2026-02-07 01:30:17', '2026-02-07 01:30:17'),
(21, 'salary.paid', 'web', 'salary', '2026-02-07 01:30:29', '2026-02-07 01:30:29'),
(22, 'attendance.menu', 'web', 'attendence', '2026-02-07 01:31:18', '2026-02-07 01:31:18'),
(23, 'category.menu', 'web', 'category', '2026-02-07 01:31:30', '2026-02-07 01:31:30'),
(24, 'product.menu', 'web', 'product', '2026-02-07 01:31:48', '2026-02-07 01:31:48'),
(25, 'expense.menu', 'web', 'expense', '2026-02-07 01:31:59', '2026-02-07 01:31:59'),
(26, 'orders.menu', 'web', 'orders', '2026-02-07 01:32:14', '2026-02-07 01:32:14'),
(27, 'stock.menu', 'web', 'stock', '2026-02-07 01:32:23', '2026-02-07 01:32:23'),
(28, 'roles.menu', 'web', 'roles', '2026-02-07 01:32:35', '2026-02-07 01:32:35'),
(29, 'pos.menu', 'web', 'pos', '2026-02-07 01:33:20', '2026-02-07 01:33:20'),
(32, 'admin.menu', 'web', 'admins', '2026-02-16 06:43:28', '2026-02-16 06:43:28'),
(33, 'admin.add', 'web', 'admins', '2026-02-16 06:43:39', '2026-02-16 06:43:39'),
(34, 'admin.edit', 'web', 'admins', '2026-02-16 06:43:50', '2026-02-16 06:43:50'),
(35, 'admin.delete', 'web', 'admins', '2026-02-16 06:43:59', '2026-02-16 06:43:59');

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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_garage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_store` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory_count` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buying_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buying_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selling_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `category_id`, `supplier_id`, `product_code`, `barcode`, `product_garage`, `product_image`, `product_store`, `inventory_count`, `buying_date`, `expire_date`, `buying_price`, `selling_price`, `created_at`, `updated_at`) VALUES
(19, 'Hazelnut And Cocoa Spread', 5, 53, '3017620422003', NULL, 'A1', 'upload/product/1857270982389076.jpg', NULL, '83', '2026-01-01', '2026-12-31', '100', '150', '2026-02-16 08:47:14', '2026-02-17 01:12:09'),
(20, 'Cristaline – 500 ml', 6, 53, '3268840001008', NULL, NULL, 'upload/product/1857271250111968.jpg', NULL, '92', '2026-02-16', '2026-12-31', '10', '25', '2026-02-16 08:51:29', '2026-02-17 01:09:25'),
(21, 'Testing', 6, 53, '12345', NULL, 'A1', 'upload/product/1857279168323028.webp', NULL, '145', '2026-02-01', '2026-02-28', '100', '150', '2026-02-16 10:57:24', '2026-02-17 01:00:23');

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
(1, 'Admin', 'web', '2026-02-07 01:35:18', '2026-02-07 01:35:18'),
(2, 'SuperAdmin', 'web', '2026-02-07 01:35:26', '2026-02-07 01:35:26'),
(7, 'Manager', 'web', '2026-02-16 06:31:32', '2026-02-16 06:34:34');

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
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 7),
(8, 1),
(8, 2),
(8, 7),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(22, 7),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shopname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `shopname`, `image`, `type`, `account_holder`, `account_number`, `bank_name`, `bank_branch`, `city`, `created_at`, `updated_at`) VALUES
(53, 'Gov Kingbruce', 'kingbruce@gmail.com', '9088184286', 'Pasay City', 'GMR', 'upload/supplier/1857269744293872.png', 'Distributor', NULL, NULL, NULL, NULL, NULL, '2026-02-16 08:27:33', '2026-02-16 08:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `firstname`, `phone`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL, '1', NULL, 'admin@gmail.com', NULL, '$2y$12$PEIACT4qfyxmfcFDYRRLJeNi5ecRSYREhf9YhP1ZADFCoQJ08f8pW', NULL, '2026-01-13 22:44:22', '2026-02-16 11:13:39'),
(2, 'gmr', 'De la Cruz', 'Green', '123456789', '202602091829images (3).png', 'gmr@gmail.com', NULL, '$2y$12$MuKZQv6FMn7MSMCjpoPy5ezrlRym7RQ.u6ZEopTFmQOLk8H8FSEmq', NULL, '2026-01-13 22:56:23', '2026-02-09 10:29:33'),
(7, 'Manuel Quezon', NULL, NULL, '12345678', NULL, 'manuel@gmail.com', NULL, '$2y$12$UD0b5uFgswtHwUmqr5uPM.0mpdGHweIK336mAPsw86qJ7MgOTRzJe', NULL, '2026-02-16 06:48:50', '2026-02-16 06:48:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `advance_salaries`
--
ALTER TABLE `advance_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expenses_reference_no_unique` (`reference_no`),
  ADD KEY `expenses_category_id_foreign` (`category_id`);

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
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pay_salaries`
--
ALTER TABLE `pay_salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pay_salaries_employee_id_period_start_period_end_index` (`employee_id`,`period_start`,`period_end`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `advance_salaries`
--
ALTER TABLE `advance_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pay_salaries`
--
ALTER TABLE `pay_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD CONSTRAINT `order_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
