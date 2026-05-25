-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 03:35 PM
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
-- Database: `webdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `userRole` varchar(50) NOT NULL,
  `roleId` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `targetData` varchar(255) DEFAULT NULL,
  `dateTime` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `userId`, `username`, `userRole`, `roleId`, `action`, `targetData`, `dateTime`) VALUES
(1, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'TEST', 'Testing activity log entry', '2025-12-11 20:54:28'),
(2, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-11 21:25:40'),
(3, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-11 22:14:10'),
(4, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-11 22:14:40'),
(5, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2025-12-11 23:35:57'),
(6, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-11 23:37:26'),
(7, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2025-12-12 00:01:54'),
(8, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-12 00:02:38'),
(9, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-12 02:26:25'),
(10, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-12 13:15:42'),
(11, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-12 20:09:34'),
(12, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-12 20:48:58'),
(13, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-13 10:27:58'),
(14, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-13 11:00:47'),
(15, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-13 11:02:12'),
(16, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'CREATE', 'Created user qwerty', '2025-12-13 11:44:05'),
(17, 1, 1, 'admin', 'ROLE_ADMIN', 2, 'CREATE', 'Created user yyy', '2025-12-13 11:50:00'),
(18, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-13 19:19:44'),
(19, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-13 19:20:10'),
(20, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-14 06:25:25'),
(21, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'TEST', 'Testing ActivityLogger from web route', '2025-12-14 18:19:11'),
(22, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'DELETE', 'User deleted: asd (ID: 8)', '2025-12-14 18:20:34'),
(23, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'DELETE', 'User deleted: asd (ID: 8)', '2025-12-14 18:20:34'),
(24, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'DELETE', 'User deleted: ggg (ID: 7)', '2025-12-14 18:29:47'),
(25, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-14 18:52:24'),
(26, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-14 20:09:27'),
(27, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-14 20:09:54'),
(28, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'DELETE', 'User: you (ID: 6, Roles: ROLE_STAFF, ROLE_USER)', '2025-12-14 20:15:50'),
(29, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-14 20:22:12'),
(31, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-14 20:24:01'),
(32, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'User: qwertyuiop (ID: 5) - Changes: username: qwerty → qwertyuiop, roles: ROLE_ADMIN, ROLE_USER → ROLE_USER, status: active → disabled', '2025-12-14 21:19:22'),
(33, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'User: qwertyuiop (ID: 5) - Changes: roles: ROLE_USER → ROLE_USER, password: changed', '2025-12-14 21:21:21'),
(34, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'User: qwertyuiop (ID: 5) - Changes: roles: ROLE_USER → ROLE_USER, password: changed', '2025-12-14 21:22:16'),
(35, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'Gem: Brilliant diamond (ID: 1) - Changes: price: $12000.00 → $200', '2025-12-14 23:06:57'),
(36, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'Gem: Brilliant diamond (ID: 1) - Changes: image: updated', '2025-12-14 23:13:56'),
(37, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'Gem: Brilliant diamond (ID: 1) - Changes: image: updated', '2025-12-14 23:15:22'),
(38, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'Gem: Deep red ruby (ID: 2) - Changes: image: updated', '2025-12-14 23:16:30'),
(39, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'Gem: Fine sapphire (ID: 3) - Changes: image: updated', '2025-12-14 23:18:35'),
(40, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'Gem: Top quality emerald (ID: 4) - Changes: image: updated', '2025-12-14 23:20:02'),
(41, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_UPDATE', 'Jewelry updated: Diamond Necklace (ID: 2) | Changes: name: D → i, price: 1 → 8, stock: NULL → NULL, gemtype: NULL → NULL, jewelrytype: NULL → NULL', '2025-12-14 23:32:56'),
(42, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_UPDATE', 'Jewelry updated: Diamond Earrings (ID: 3) | Changes: name: D → i, price: 1 → 4, stock: NULL → NULL, gemtype: NULL → NULL, jewelrytype: NULL → NULL', '2025-12-14 23:34:26'),
(43, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_UPDATE', 'Jewelry updated: Ruby Ring (ID: 1) | Changes: name: D → i, price: 1 → 5, stock: NULL → NULL, gemtype: NULL → NULL, jewelrytype: NULL → NULL', '2025-12-14 23:35:26'),
(44, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 1 | Customer: admin | Changes: status: pending → processing', '2025-12-15 00:12:49'),
(45, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 3 | Order: 1', '2025-12-15 00:18:33'),
(46, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 1 | Customer: admin | Changes: status: processing → pending', '2025-12-15 00:29:38'),
(47, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_UPDATE', 'Order item updated: ID 1 | Order: 1 | Changes: quantity: 2 → 1, price_snapshot: 99.99 → 200, jewelry: Proxies\\__CG__\\App\\Entity\\Jewelries#1 → NULL', '2025-12-15 00:29:38'),
(48, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-15 08:01:17'),
(49, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_CREATE', 'Order created: ID 2 | Customer: staff | Status: pending', '2025-12-15 08:53:00'),
(50, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_CREATE', 'Order created: ID 3 | Customer: staff | Status: pending', '2025-12-15 08:58:00'),
(51, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_ITEM_CREATE', 'Order item created: ID 4 | Order: 3', '2025-12-15 08:58:53'),
(52, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_CREATE', 'Order created: ID 4 | Customer: staff | Status: pending', '2025-12-15 09:20:37'),
(53, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_ITEM_CREATE', 'Order item created: ID 5 | Order: 4', '2025-12-15 09:21:42'),
(54, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_UPDATE', 'Order updated: ID 4 | Customer: staff | Changes: status: pending → processing, amount: 100000.00 → 100000', '2025-12-15 09:23:31'),
(55, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_ITEM_UPDATE', 'Order item updated: ID 5 | Order: 4 | Changes: quantity: 1 → 2, price_snapshot: 300.00 → 200', '2025-12-15 09:23:31'),
(56, 4, 4, 'staff', 'ROLE_STAFF', 2, 'GEM_BUNDLE_UPDATE', 'Gem bundle updated: Luxury Gem Set (ID: 1)', '2025-12-15 09:25:30'),
(57, 4, 4, 'staff', 'ROLE_STAFF', 2, 'CUSTOM_JEWELRY_CREATE', 'Custom jewelry created: ID 1 | Status: N/A', '2025-12-15 09:37:47'),
(58, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-15 12:44:19'),
(59, 4, 4, 'staff', 'ROLE_STAFF', 2, 'CUSTOM_JEWELRY_UPDATE', 'Custom jewelry updated: ID 1 | Changes: notes: Nice Earrings → Nice', '2025-12-15 16:01:26'),
(60, 4, 4, 'staff', 'ROLE_STAFF', 2, 'JEWELRY_UPDATE', 'Jewelry updated: Ruby Ring (ID: 1) | Changes: name: R → u, price: 1 → 5, stock: NULL → NULL, gemtype: NULL → NULL, jewelrytype: NULL → NULL', '2025-12-15 17:36:54'),
(61, NULL, 0, 'system', 'ROLE_SYSTEM', 0, 'JEWELRY_UPDATE', 'Jewelry updated: Ruby Ring (ID: 1) | Changes: name: R → u, price: 1 → 5, stock: NULL → NULL, gemtype: NULL → NULL, jewelrytype: NULL → NULL', '2025-12-15 17:48:32'),
(62, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-15 17:49:14'),
(63, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2025-12-15 17:51:33'),
(64, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-15 17:51:55'),
(65, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-15 18:39:36'),
(66, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-16 03:20:31'),
(67, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 03:58:15'),
(68, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:28:14'),
(69, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:29:56'),
(70, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:56:39'),
(71, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:57:09'),
(72, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:58:15'),
(73, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:58:33'),
(74, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 04:58:36'),
(75, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 05:00:03'),
(76, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 05:04:14'),
(77, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 05:04:17'),
(78, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-16 05:04:34'),
(79, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 05:07:32'),
(80, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 05:10:04'),
(81, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:32:29'),
(82, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:33:06'),
(83, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:38:35'),
(84, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:39:20'),
(85, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:41:51'),
(86, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:42:27'),
(87, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 06:57:40'),
(88, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 07:07:23'),
(89, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 07:07:25'),
(90, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 07:18:46'),
(91, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 07:18:50'),
(92, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 07:36:31'),
(93, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 07:58:44'),
(94, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 08:02:24'),
(95, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 12:02:02'),
(96, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 12:50:13'),
(97, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 13:04:41'),
(98, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-16 13:06:13'),
(99, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 17:17:12'),
(100, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 17:42:39'),
(101, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 17:44:38'),
(102, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 17:53:27'),
(103, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 17:54:22'),
(104, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 18:04:10'),
(105, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 18:14:43'),
(106, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 18:22:30'),
(107, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 18:23:11'),
(108, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 18:24:27'),
(109, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-17 19:32:26'),
(110, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 5 | Customer: admin | Status: pending', '2025-12-17 21:32:43'),
(111, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 6 | Customer: admin | Status: processing', '2025-12-17 21:33:36'),
(112, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 7 | Customer: admin | Status: processing', '2025-12-17 21:45:18'),
(113, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 8 | Customer: admin | Status: processing', '2025-12-17 22:14:04'),
(114, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 6 | Order: 8', '2025-12-17 23:27:18'),
(115, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 1 | Customer: admin | Changes: status: pending → processing', '2025-12-18 01:11:37'),
(116, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_UPDATE', 'Order item updated: ID 1 | Order: 1 | Changes: jewelry: NULL → App\\Entity\\Jewelries#2', '2025-12-18 01:11:37'),
(117, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-18 01:30:34'),
(118, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-18 01:30:48'),
(119, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2025-12-18 01:44:00'),
(120, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-18 01:44:43'),
(121, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 9 | Customer: admin | Status: pending', '2025-12-18 02:11:38'),
(122, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 7 | Order: 9', '2025-12-18 02:12:06'),
(123, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'User: qwertyuiop (ID: 5) - Changes: roles: ROLE_USER → ROLE_USER, password: changed', '2025-12-18 02:26:43'),
(124, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-18 02:27:06'),
(125, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-18 02:27:53'),
(126, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'User: 12345 (ID: 5) - Changes: username: qwertyuiop → 12345, roles: ROLE_USER → ROLE_USER, status: disabled → active, password: changed', '2025-12-18 02:29:37'),
(127, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-18 02:30:11'),
(128, 5, 5, '12345', 'ROLE_USER', 3, 'LOGIN', 'User 12345 logged in', '2025-12-18 02:30:40'),
(129, 5, 5, '12345', 'ROLE_USER', 3, 'LOGOUT', 'User 12345 logged out', '2025-12-18 02:41:45'),
(130, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2025-12-18 11:11:14'),
(131, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2025-12-18 11:23:15'),
(132, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2025-12-18 11:48:18'),
(133, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 14:09:10'),
(134, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-26 14:09:46'),
(135, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 15:11:19'),
(136, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 10 | Customer: admin | Status: pending', '2026-01-26 20:32:19'),
(137, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_DELETE', 'Order deleted: ID 10 | Customer: admin', '2026-01-26 20:34:47'),
(138, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 9 | Customer: admin', '2026-01-26 20:52:15'),
(139, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-26 21:19:14'),
(140, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 21:44:21'),
(141, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 21:45:38'),
(142, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 21:46:07'),
(143, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-26 22:18:45'),
(144, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 22:22:27'),
(145, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 22:29:11'),
(146, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 22:29:23'),
(147, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-26 22:34:43'),
(148, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 22:43:39'),
(149, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 22:53:09'),
(150, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-26 22:53:19'),
(151, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 22:54:53'),
(152, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:03:26'),
(153, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:05:56'),
(154, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:06:51'),
(155, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:07:55'),
(156, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:09:33'),
(157, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:11:08'),
(158, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:25:20'),
(159, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:31:55'),
(160, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:32:30'),
(161, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:33:14'),
(162, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:35:28'),
(163, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:36:37'),
(164, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:38:27'),
(165, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:38:50'),
(166, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:44:03'),
(167, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:44:20'),
(168, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-26 23:50:33'),
(169, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 00:00:00'),
(170, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 00:11:27'),
(171, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-27 00:12:05'),
(172, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2026-01-27 00:12:20'),
(173, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2026-01-27 00:12:35'),
(174, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 00:50:40'),
(175, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-27 00:51:48'),
(176, 13, 13, 'aaa', 'ROLE_USER', 3, 'LOGIN', 'User aaa logged in', '2026-01-27 01:17:44'),
(177, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2026-01-27 01:54:15'),
(178, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2026-01-27 03:26:33'),
(179, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 03:26:49'),
(180, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'UPDATE', 'User: aaa (ID: 13) - Changes: roles: ROLE_USER → ROLE_USER, status: active → disabled, password: changed', '2026-01-27 03:33:37'),
(181, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'CREATE', 'User: ccc (ID: 14)', '2026-01-27 03:43:56'),
(182, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 9 | Customer: admin', '2026-01-27 03:56:12'),
(183, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 9 | Customer: admin', '2026-01-27 03:56:14'),
(184, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_UPDATE', 'Order item updated: ID 7 | Order: 9', '2026-01-27 03:57:12'),
(185, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 11 | Customer: admin | Status: cancelled', '2026-01-27 04:03:11'),
(186, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 12 | Customer: admin | Status: cancelled', '2026-01-27 04:03:16'),
(187, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 8 | Order: 12', '2026-01-27 04:13:09'),
(188, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 7 | Customer: admin', '2026-01-27 04:22:49'),
(189, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 7 | Customer: admin', '2026-01-27 04:22:51'),
(190, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 8 | Customer: admin', '2026-01-27 04:24:58'),
(191, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 8 | Customer: admin', '2026-01-27 04:25:01'),
(192, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 12 | Customer: admin', '2026-01-27 04:25:56'),
(193, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 12 | Customer: admin', '2026-01-27 04:25:59'),
(194, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 9 | Order: 12', '2026-01-27 04:26:46'),
(195, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 13 | Customer: admin | Status: finished', '2026-01-27 04:27:51'),
(196, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 10 | Order: 13', '2026-01-27 04:28:10'),
(197, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 14 | Customer: admin | Status: pending', '2026-01-27 04:34:26'),
(198, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_DELETE', 'Order deleted: ID 14 | Customer: admin', '2026-01-27 04:36:43'),
(199, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_DELETE', 'Order deleted: ID 7 | Customer: admin', '2026-01-27 04:37:56'),
(200, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_CREATE', 'Order created: ID 15 | Customer: admin | Status: processing', '2026-01-27 04:41:59'),
(201, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 11 | Order: 15', '2026-01-27 04:56:19'),
(202, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 12 | Order: 15', '2026-01-27 04:56:19'),
(203, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_ITEM_CREATE', 'Order item created: ID 13 | Order: 15', '2026-01-27 04:56:19'),
(204, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'ORDER_UPDATE', 'Order updated: ID 15 | Customer: admin', '2026-01-27 04:57:50'),
(205, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-27 05:04:22'),
(206, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2026-01-27 05:04:51'),
(207, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 05:08:55'),
(208, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-27 05:09:10'),
(209, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2026-01-27 05:09:34'),
(210, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_CREATE', 'Order created: ID 16 | Customer: staff | Status: pending', '2026-01-27 05:15:08'),
(211, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_ITEM_CREATE', 'Order item created: ID 14 | Order: 16', '2026-01-27 05:15:29'),
(212, 4, 4, 'staff', 'ROLE_STAFF', 2, 'ORDER_ITEM_CREATE', 'Order item created: ID 15 | Order: 16', '2026-01-27 05:15:29'),
(213, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2026-01-27 05:15:38'),
(214, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 05:15:52'),
(215, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-27 05:17:14'),
(216, 14, 14, 'ccc', 'ROLE_USER', 3, 'LOGIN', 'User ccc logged in', '2026-01-27 05:18:29'),
(217, 14, 14, 'ccc', 'ROLE_USER', 3, 'LOGOUT', 'User ccc logged out', '2026-01-27 05:19:11'),
(218, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGIN', 'User staff logged in', '2026-01-27 05:19:25'),
(219, 4, 4, 'staff', 'ROLE_STAFF', 2, 'LOGOUT', 'User staff logged out', '2026-01-27 05:19:41'),
(220, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 07:59:15'),
(221, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_CREATE', 'Jewelry created: Emerald Earrings (ID: 4) | Type: Earrings', '2026-01-27 08:16:35'),
(222, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_CREATE', 'Jewelry created: Diamond Ring (ID: 5) | Type: Ring', '2026-01-27 08:17:52'),
(223, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_CREATE', 'Jewelry created: Emerald Ring (ID: 6) | Type: Ring', '2026-01-27 08:19:25'),
(224, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_CREATE', 'Jewelry created: Ruby Earrings (ID: 7) | Type: Earrings', '2026-01-27 08:20:31'),
(225, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'JEWELRY_CREATE', 'Jewelry created: Sapphire Ring (ID: 8) | Type: Ring', '2026-01-27 08:22:05'),
(226, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGOUT', 'User admin logged out', '2026-01-27 09:17:08'),
(227, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-27 09:34:51'),
(228, 1, 1, 'admin', 'ROLE_ADMIN', 1, 'LOGIN', 'User admin logged in', '2026-01-29 12:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customjewelries`
--

CREATE TABLE `customjewelries` (
  `id` int(11) NOT NULL,
  `notes` longtext NOT NULL,
  `imagepath` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `gemtype_id` int(11) DEFAULT NULL,
  `jewelrytype_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customjewelries`
--

INSERT INTO `customjewelries` (`id`, `notes`, `imagepath`, `created_at`, `gemtype_id`, `jewelrytype_id`, `customer_id`) VALUES
(1, 'Nice', 'images/custom/693fd6eb76b20.webp', '2025-12-15 09:37:47', 1, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251002072317', '2025-12-10 21:14:59', 7),
('DoctrineMigrations\\Version20251003080523', NULL, NULL),
('DoctrineMigrations\\Version20251003231126', NULL, NULL),
('DoctrineMigrations\\Version20251004000623', NULL, NULL),
('DoctrineMigrations\\Version20251004000928', NULL, NULL),
('DoctrineMigrations\\Version20251004002353', NULL, NULL),
('DoctrineMigrations\\Version20251004003149', NULL, NULL),
('DoctrineMigrations\\Version20251008101848', NULL, NULL),
('DoctrineMigrations\\Version20251012042928', NULL, NULL),
('DoctrineMigrations\\Version20251012083517', NULL, NULL),
('DoctrineMigrations\\Version20251012084257', NULL, NULL),
('DoctrineMigrations\\Version20251012084832', NULL, NULL),
('DoctrineMigrations\\Version20251012085353', NULL, NULL),
('DoctrineMigrations\\Version20251012085836', NULL, NULL),
('DoctrineMigrations\\Version20251012092247', NULL, NULL),
('DoctrineMigrations\\Version20251013021031', NULL, NULL),
('DoctrineMigrations\\Version20251013021409', NULL, NULL),
('DoctrineMigrations\\Version20251017042630', NULL, NULL),
('DoctrineMigrations\\Version20251017043731', NULL, NULL),
('DoctrineMigrations\\Version20251017052633', NULL, NULL),
('DoctrineMigrations\\Version20251017053609', NULL, NULL),
('DoctrineMigrations\\Version20251017071021', NULL, NULL),
('DoctrineMigrations\\Version20251017073909', NULL, NULL),
('DoctrineMigrations\\Version20251017074755', NULL, NULL),
('DoctrineMigrations\\Version20251018005230', NULL, NULL),
('DoctrineMigrations\\Version20251019035606', NULL, NULL),
('DoctrineMigrations\\Version20251019092229', NULL, NULL),
('DoctrineMigrations\\Version20251130202250', NULL, NULL),
('DoctrineMigrations\\Version20251130210405', NULL, NULL),
('DoctrineMigrations\\Version20251130214336', NULL, NULL),
('DoctrineMigrations\\Version20251130214507', NULL, NULL),
('DoctrineMigrations\\Version20251210175357', NULL, NULL),
('DoctrineMigrations\\Version20251210205321', NULL, NULL),
('DoctrineMigrations\\Version20251210210939', NULL, NULL),
('DoctrineMigrations\\Version20251210211457', NULL, NULL),
('DoctrineMigrations\\Version20251210211820', '2025-12-10 21:18:25', 177),
('DoctrineMigrations\\Version20251211064111', '2025-12-11 06:42:22', 296),
('DoctrineMigrations\\Version20251211064341', '2025-12-11 06:44:47', 172),
('DoctrineMigrations\\Version20251211064638', '2025-12-11 06:47:51', 141),
('DoctrineMigrations\\Version20251211070603', '2025-12-11 07:06:51', 745),
('DoctrineMigrations\\Version20251211071938', '2025-12-11 07:21:04', 154),
('DoctrineMigrations\\Version20251211145638', NULL, NULL),
('DoctrineMigrations\\Version20251211150525', NULL, NULL),
('DoctrineMigrations\\Version20251211151550', NULL, NULL),
('DoctrineMigrations\\Version20251211173126', '2025-12-11 17:32:16', 45),
('DoctrineMigrations\\Version20251211191635', '2025-12-11 19:16:55', 82),
('DoctrineMigrations\\Version20251212084301', '2025-12-12 08:43:07', 1326),
('DoctrineMigrations\\Version20251212093137', NULL, NULL),
('DoctrineMigrations\\Version20251212101509', NULL, NULL),
('DoctrineMigrations\\Version20251212103249', '2025-12-12 10:34:30', 240),
('DoctrineMigrations\\Version20251212202735', NULL, NULL),
('DoctrineMigrations\\Version20251212203158', NULL, NULL),
('DoctrineMigrations\\Version20251212205223', NULL, NULL),
('DoctrineMigrations\\Version20251212205630', NULL, NULL),
('DoctrineMigrations\\Version20251212210821', '2025-12-12 21:08:26', 151),
('DoctrineMigrations\\Version20251212212115', '2025-12-12 21:21:32', 245),
('DoctrineMigrations\\Version20251213124130', '2025-12-13 12:41:45', 177),
('DoctrineMigrations\\Version20251214091553', '2025-12-14 09:16:28', 2384),
('DoctrineMigrations\\Version20251214112002', '2025-12-14 11:20:39', 203),
('DoctrineMigrations\\Version20251214192714', '2025-12-14 19:28:02', 567),
('DoctrineMigrations\\Version20251214194442', '2025-12-14 19:44:54', 43),
('DoctrineMigrations\\Version20251214224129', '2025-12-14 22:42:31', 216);

-- --------------------------------------------------------

--
-- Table structure for table `gem`
--

CREATE TABLE `gem` (
  `id` int(11) NOT NULL,
  `gemtype_id` int(11) DEFAULT NULL,
  `carat` double NOT NULL,
  `size` varchar(100) NOT NULL,
  `cut` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `clarity` varchar(255) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `imagepath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gem`
--

INSERT INTO `gem` (`id`, `gemtype_id`, `carat`, `size`, `cut`, `color`, `clarity`, `origin`, `description`, `stock`, `price`, `imagepath`) VALUES
(1, 1, 1.25, 'Medium', 'Round', 'Clear', 'VS1', 'South Africa', 'Brilliant diamond', 5, 200.00, 'images/gems/diamond-round-693f450ad9a75.png'),
(2, 2, 2.1, 'Large', 'Oval', 'Red', 'VVS', 'Myanmar', 'Deep red ruby', 3, 8000.00, 'images/gems/ruby-oval-693f454e0560e.png'),
(3, 3, 1.5, 'Small', 'Cushion', 'Blue', 'VS2', 'Sri Lanka', 'Fine sapphire', 7, 6000.00, 'images/gems/sapphire-cushion-693f45cb4ae8b.png'),
(4, 4, 2, 'Large', 'Emerald', 'Green', 'IF', 'Colombia', 'Top quality emerald', 2, 15000.00, 'images/gems/ruby-large-693f46222d9e1.png');

-- --------------------------------------------------------

--
-- Table structure for table `gembundles`
--

CREATE TABLE `gembundles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gembundles`
--

INSERT INTO `gembundles` (`id`, `name`, `description`, `stock`, `price`, `image`, `created_at`) VALUES
(1, 'Luxury Gem Set', 'Diamond, Ruby, Sapphire bundle', 3, 20000, 'images/bundles/luxury_set.jpg', '2025-12-12 09:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `gemtype`
--

CREATE TABLE `gemtype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gemtype`
--

INSERT INTO `gemtype` (`id`, `name`) VALUES
(1, 'Diamond'),
(2, 'Ruby'),
(3, 'Sapphire'),
(4, 'Emerald');

-- --------------------------------------------------------

--
-- Table structure for table `jewelries`
--

CREATE TABLE `jewelries` (
  `id` int(11) NOT NULL,
  `gemtype_id` int(11) DEFAULT NULL,
  `jewelrytype_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jewelries`
--

INSERT INTO `jewelries` (`id`, `gemtype_id`, `jewelrytype_id`, `name`, `price`, `stock`, `image`) VALUES
(1, 2, 1, 'Ruby Ring', 15000, 5, 'images/jewelries/694049f011872.png'),
(2, 1, 2, 'Diamond Necklace', 18000, 3, 'images/jewelries/693f49274761c.webp'),
(3, 1, 3, 'Diamond Earrings', 14000, 4, 'images/jewelries/693f498273784.webp'),
(4, 4, 3, 'Emerald Earrings', 600, 3, 'images/jewelries/69787463a7aae.webp'),
(5, 1, 1, 'Diamond Ring', 18000, 4, 'images/jewelries/697874b05a7b3.webp'),
(6, 4, 1, 'Emerald Ring', 1200, 2, 'images/jewelries/6978750d8657b.webp'),
(7, 2, 3, 'Ruby Earrings', 700, 6, 'images/jewelries/6978754f76996.webp'),
(8, 3, 1, 'Sapphire Ring', 1000, 2, 'images/jewelries/697875ad38f16.webp');

-- --------------------------------------------------------

--
-- Table structure for table `jewelrytype`
--

CREATE TABLE `jewelrytype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jewelrytype`
--

INSERT INTO `jewelrytype` (`id`, `name`) VALUES
(1, 'Ring'),
(2, 'Necklace'),
(3, 'Earrings');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_snapshot` decimal(10,2) NOT NULL,
  `gem_id` int(11) DEFAULT NULL,
  `jewelry_id` int(11) DEFAULT NULL,
  `gembundles_id` int(11) DEFAULT NULL,
  `customjewelries_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`id`, `quantity`, `price_snapshot`, `gem_id`, `jewelry_id`, `gembundles_id`, `customjewelries_id`, `order_id`) VALUES
(1, 1, 200.00, 1, 2, NULL, NULL, 1),
(2, 1, 49.50, 2, 2, NULL, NULL, 1),
(3, 1, 200.00, 1, NULL, NULL, NULL, 1),
(4, 1, 8000.00, 2, NULL, NULL, NULL, 3),
(5, 2, 200.00, NULL, 2, NULL, NULL, 4),
(6, 1, 200.00, 1, NULL, NULL, NULL, 8),
(7, 1, 15000.00, NULL, 1, 1, NULL, 9),
(8, 1, 200.00, 1, 1, 1, NULL, 12),
(9, 1, 15000.00, NULL, 1, 1, NULL, 12),
(10, 1, 200.00, 1, 1, 1, NULL, 13),
(11, 1, 200.00, 1, NULL, NULL, NULL, 15),
(12, 1, 15000.00, NULL, 1, NULL, NULL, 15),
(13, 1, 20000.00, NULL, NULL, 1, NULL, 15),
(14, 2, 8000.00, 2, NULL, NULL, NULL, 16),
(15, 2, 15000.00, NULL, 1, NULL, NULL, 16);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `status`, `amount`, `created_at`, `created_by_id`) VALUES
(1, 1, 'processing', 199.99, '2025-12-12 17:50:12', 1),
(2, 4, 'pending', 8000.00, '2025-12-15 08:53:00', 4),
(3, 4, 'pending', 8000.00, '2025-12-15 08:58:00', 4),
(4, 4, 'processing', 100000.00, '2025-12-15 09:20:37', 4),
(5, 1, 'pending', 3.00, '2025-12-17 21:32:42', 1),
(6, 1, 'processing', 3.00, '2025-12-17 21:33:35', 1),
(8, 1, 'processing', 200.00, '2025-12-17 22:14:04', 1),
(9, 1, 'pending', 15000.00, '2025-12-18 02:11:38', 1),
(11, 1, 'cancelled', 0.00, '2026-01-27 04:03:11', 1),
(12, 1, 'cancelled', 15200.00, '2026-01-27 04:03:16', 1),
(13, 1, 'finished', 200.00, '2026-01-27 04:27:51', 1),
(15, 1, 'processing', 35200.00, '2026-01-27 04:41:59', 1),
(16, 4, 'pending', 46000.00, '2026-01-27 05:15:08', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `dateCreated`, `status`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$iv/UdST8JNxCtQe2gytP.OJ2U2HhURFHcazza.HajqyGoXACxvyN.', '2025-12-11 23:22:49', 'active'),
(4, 'staff', '[\"ROLE_STAFF\"]', '$2y$13$j/pnr1WVZCF3GU3GFX2i7eX3TxSdOwNViykA.En1sPeF2FbZae3a2', '2025-12-11 23:22:49', 'active'),
(5, '12345', '[]', '$2y$13$TFlujHGx6utodTRthgAP8eD8O1gYjwiNBgZibDMsQPaWxQtpsUNKa', '2025-12-13 11:44:05', 'active'),
(13, 'aaa', '[]', '$2y$13$dBH3CfUpO09XvgRn2DMJsuZ23PHHtU1Qyv/F0ZevA543LkJNgjJ2q', '2026-01-26 23:17:02', 'disabled'),
(14, 'ccc', '[]', '$2y$13$wrNUnWNLL9m3ZbnkK9GvL.SYjd.U8.eR46IGmwgOcu5d8KE5Mz3Rm', '2026-01-27 03:43:53', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `webdev_gembundles_gemtype`
--

CREATE TABLE `webdev_gembundles_gemtype` (
  `gembundles_id` int(11) NOT NULL,
  `gemtype_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD06F647A76ED395` (`user_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customjewelries`
--
ALTER TABLE `customjewelries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8E1AE00DD58B5513` (`gemtype_id`),
  ADD KEY `IDX_8E1AE00D136DC1C2` (`jewelrytype_id`),
  ADD KEY `IDX_8E1AE00D9395C3F3` (`customer_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `gem`
--
ALTER TABLE `gem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A11DC050D58B5513` (`gemtype_id`);

--
-- Indexes for table `gembundles`
--
ALTER TABLE `gembundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gemtype`
--
ALTER TABLE `gemtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jewelries`
--
ALTER TABLE `jewelries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4F3CFE34D58B5513` (`gemtype_id`),
  ADD KEY `IDX_4F3CFE34136DC1C2` (`jewelrytype_id`);

--
-- Indexes for table `jewelrytype`
--
ALTER TABLE `jewelrytype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93DAF127A5AD5580` (`gem_id`),
  ADD KEY `IDX_93DAF1273FB34C55` (`jewelry_id`),
  ADD KEY `IDX_93DAF1274C95F647` (`gembundles_id`),
  ADD KEY `IDX_93DAF12790C3E44B` (`customjewelries_id`),
  ADD KEY `IDX_93DAF1278D9F6D38` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEE9395C3F3` (`customer_id`),
  ADD KEY `IDX_E52FFDEEB03A8386` (`created_by_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`);

--
-- Indexes for table `webdev_gembundles_gemtype`
--
ALTER TABLE `webdev_gembundles_gemtype`
  ADD PRIMARY KEY (`gembundles_id`,`gemtype_id`),
  ADD KEY `IDX_10FD6FC24C95F647` (`gembundles_id`),
  ADD KEY `IDX_10FD6FC2D58B5513` (`gemtype_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customjewelries`
--
ALTER TABLE `customjewelries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gem`
--
ALTER TABLE `gem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gembundles`
--
ALTER TABLE `gembundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gemtype`
--
ALTER TABLE `gemtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jewelries`
--
ALTER TABLE `jewelries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jewelrytype`
--
ALTER TABLE `jewelrytype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `FK_FD06F647A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `customjewelries`
--
ALTER TABLE `customjewelries`
  ADD CONSTRAINT `FK_6DFDE93136DC1C2` FOREIGN KEY (`jewelrytype_id`) REFERENCES `jewelrytype` (`id`),
  ADD CONSTRAINT `FK_6DFDE93D58B5513` FOREIGN KEY (`gemtype_id`) REFERENCES `gemtype` (`id`),
  ADD CONSTRAINT `FK_8E1AE00D9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `gem`
--
ALTER TABLE `gem`
  ADD CONSTRAINT `FK_995086B0D58B5513` FOREIGN KEY (`gemtype_id`) REFERENCES `gemtype` (`id`);

--
-- Constraints for table `jewelries`
--
ALTER TABLE `jewelries`
  ADD CONSTRAINT `FK_CDCD7C97136DC1C2` FOREIGN KEY (`jewelrytype_id`) REFERENCES `jewelrytype` (`id`),
  ADD CONSTRAINT `FK_CDCD7C97D58B5513` FOREIGN KEY (`gemtype_id`) REFERENCES `gemtype` (`id`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `FK_112B73843FB34C55` FOREIGN KEY (`jewelry_id`) REFERENCES `jewelries` (`id`),
  ADD CONSTRAINT `FK_112B73844C95F647` FOREIGN KEY (`gembundles_id`) REFERENCES `gembundles` (`id`),
  ADD CONSTRAINT `FK_112B73848D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `FK_112B738490C3E44B` FOREIGN KEY (`customjewelries_id`) REFERENCES `customjewelries` (`id`),
  ADD CONSTRAINT `FK_112B7384A5AD5580` FOREIGN KEY (`gem_id`) REFERENCES `gem` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEE9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_E52FFDEEB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `webdev_gembundles_gemtype`
--
ALTER TABLE `webdev_gembundles_gemtype`
  ADD CONSTRAINT `FK_10FD6FC24C95F647` FOREIGN KEY (`gembundles_id`) REFERENCES `gembundles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_10FD6FC2D58B5513` FOREIGN KEY (`gemtype_id`) REFERENCES `gemtype` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
