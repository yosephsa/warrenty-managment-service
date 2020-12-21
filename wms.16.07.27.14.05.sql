-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2016 at 01:05 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csc_it_wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `entry_table` varchar(20) NOT NULL DEFAULT 'warranties',
  `entry_action` varchar(50) NOT NULL,
  `entry_id` varchar(50) NOT NULL,
  `entry_log` text NOT NULL,
  `changed_by` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `entry_table`, `entry_action`, `entry_id`, `entry_log`, `changed_by`, `date`) VALUES
(1, 'users', 'edit', '', 'set\r\n												email="yosephsa0@gmail.com",\r\n												first_name="yoseph",\r\n												middle_name="s.",\r\n												last_name="alabdulwahab",\r\n												permission="admin",\r\n												notify="1",\r\n												birth_date="1970-01-01"\r\n											where\r\n					', 'yoseph1998', '2016-07-24'),
(2, 'users', 'edit', '', 'set\r\n												pass_hash="$2y$10$idqhjoujtwxbmnfefubyledgy4fshn87hxhyjdk1v0shhjql41ugw"\r\n											where\r\n					', 'yoseph1998', '2016-07-24'),
(3, 'users', 'edit', '', 'set\r\n												email="yosephsa0@gmail.com",\r\n												first_name="yoseph",\r\n												middle_name="s.",\r\n												last_name="alabdulwahab",\r\n												permission="admin",\r\n												notify="1",\r\n												birth_date="1998-12-30"\r\n											where\r\n					', 'yoseph1998', '2016-07-24'),
(4, 'users', 'edit', '', 'set\r\n												pass_hash="$2y$10$mtogvfa9plqr.73lntmdu.flnh9d68wync32tm9kvhxetznctb0kk"\r\n											where\r\n					', 'yoseph1998', '2016-07-24'),
(5, 'users', 'edit', '', 'set\r\n											permission="admin"\r\n										where\r\n				', 'yoseph1998', '2016-07-24'),
(6, 'users', 'edit', '', 'set\r\n											permission="user"\r\n										where\r\n				', 'admin', '2016-07-24'),
(7, 'warranties', 'create', '0', '\n									(status, product_name, company_name, start_date, end_date, created_by, creation_date)\r\n									values \r\n									  ( \r\n										"active",\r\n										"", \r\n										"",\r\n										"1970-01-01",\r\n										"1970-01-01",\r\n										"yoseph1998",\r\n										"2016-07-24" )\r\n								', 'yoseph1998', '2016-07-24'),
(8, 'warranties', 'create', '0', '\n									(status, product_name, company_name, start_date, end_date, created_by, creation_date)\r\n									values \r\n									  ( \r\n										"active",\r\n										"", \r\n										"",\r\n										"1970-01-01",\r\n										"1970-01-01",\r\n										"yoseph1998",\r\n										"2016-07-24" )\r\n								', 'yoseph1998', '2016-07-24'),
(9, 'warranties', 'create', '1', '\n									(product_name, company_name, created_by, creation_date)\r\n									values \r\n									  ( \r\n										"iphone accidental protection policy", \r\n										"apple",\r\n										"yoseph1998",\r\n										"2016-07-25" )\r\n								', 'yoseph1998', '2016-07-25'),
(10, 'warranties', 'create', '2', '\n									(product_name, company_name, created_by, creation_date)\r\n									values \r\n									  ( \r\n										"asd", \r\n										"asd",\r\n										"yoseph1998",\r\n										"2016-07-25" )\r\n								', 'yoseph1998', '2016-07-25'),
(11, 'warranties', 'create', '3', '\n									(product_name, company_name, created_by, creation_date)\r\n									values \r\n									  ( \r\n										"", \r\n										"",\r\n										"yoseph1998",\r\n										"2016-07-25" )\r\n								', 'yoseph1998', '2016-07-25'),
(12, 'warranties', 'create', '5', '\n									(product_name, company_name, created_by, creation_date)\r\n									values \r\n									  ( \r\n										"", \r\n										"",\r\n										"yoseph1998",\r\n										"2016-07-25" )\r\n								', 'yoseph1998', '2016-07-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `permission` varchar(20) NOT NULL DEFAULT 'user',
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '1',
  `birth_date` date NOT NULL,
  `creation_date` date NOT NULL,
  `pass_hash` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `permission`, `first_name`, `middle_name`, `last_name`, `notify`, `birth_date`, `creation_date`, `pass_hash`) VALUES
(0, 'admin@localhost', 'admin', 'admin', 'Admin', '', '', 0, '2016-07-14', '2016-07-14', '$2y$10$B5IipWmKtRQam55i1gpEUO/Q7hQGkytWy0MhE5Lvm22i7dtnXOMUe'),
(2, 'yosephsa0@gmail.com', 'yoseph1998', 'admin', 'ÙŠÙˆØ³Ù', 'Ø´Ø±ÙŠÙ', 'Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', 1, '1998-12-30', '2016-07-15', '$2y$10$Nz1zgWbSdDea9mTnJx2Z5ue0IWbXTPZci.VY5RG2zFvDRlOt.Aqcm');

-- --------------------------------------------------------

--
-- Table structure for table `warranty_entries`
--

DROP TABLE IF EXISTS `warranty_entries`;
CREATE TABLE `warranty_entries` (
  `id` int(11) NOT NULL,
  `warranty_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `pending_notes` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_info` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `files` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_by` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Unspecified',
  `creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `warranty_entries`
--

INSERT INTO `warranty_entries` (`id`, `warranty_id`, `product_name`, `company_name`, `status`, `pending_notes`, `price`, `contact_info`, `notes`, `files`, `start_date`, `end_date`, `created_by`, `creation_date`) VALUES
(51, 1, 'Ù†Ø¸Ø§Ù… Ø§Ù„Ù†Ø³Ø® Ø§Ù„Ø§Ø­ØªÙŠØ§Ø·ÙŠ  Veeam', 'Ø±Ø§ÙŠØ§Øª Ø§Ù„ØªÙ‚Ù†ÙŠØ©', 'active', '            ', '200000', '            ', '<p>DATA Ù…Ø¹ &nbsp;DOMAIN</p>', '', '2014-12-24', '2017-12-23', 'Yoseph S. Alabdulwahab', '2016-07-27'),
(53, 2, 'Core Switch (ØºØ±ÙØ© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª (Ø§Ù„Ù…Ø¨Ø¯Ù„ Ø§Ù„Ø±Ø¦ÙŠØ³ÙŠ ', 'Ø±Ø§ÙŠØ§Øª Ø§Ù„ØªÙ‚Ù†ÙŠØ©', 'active', '  ', '9640', '  ', '', '', '2015-06-03', '2017-06-02', 'Yoseph S. Alabdulwahab', '2016-07-27'),
(55, 3, '3 Servers Ø±Ø®Øµ - VMWARE 6 CPUs', 'Ø²ÙŠÙ†ÙŠØ«', 'active', '  ', '84000', '  ', '', '', '2013-06-25', '2016-07-30', 'Yoseph S. Alabdulwahab', '2016-07-27'),
(57, 4, '3 Servers HP for Vmware', 'Ø§Ù„ÙÙ„Ùƒ', 'active', '', '8,500.00', '', '<p>ØªØ¬Ø¯ÙŠØ¯ Ø¬Ù‡Ø§Ø²ÙŠÙ† ÙÙ‚Ø· Ø­ØªÙ‰ 2017 Ø§Ù…Ø§ Ø§Ù„Ø¬Ù‡Ø§Ø² Ø§Ù„Ø§Ø®Ø± Ù„Ù… ÙŠØªØ¬Ø¯Ø¯</p>', '', '2015-06-10', '2017-04-29', 'Yoseph S. Alabdulwahab', '2016-07-27'),
(59, 5, ' Ø§Ù„ØªØ®Ø²ÙŠÙ† Ø§Ù„Ù…Ø±ÙƒØ²ÙŠ EMC Vnxe 3100 Ø®Ø§Øµ Ù„Ù„ Vmware', 'Ù…Ù‡Ø§Ù… Ø§Ù„Ø®Ù„ÙŠØ¬ Ù…Ø§ØªÙƒÙˆ (Ø±Ù…Ø²ÙŠ ØªÙŠÙ…Ø§Ù†ÙŠ)', 'active', '', '15273', '<p>966 50 9473714</p>', '', '', '2015-03-14', '2017-03-13', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(61, 6, ' Ø§Ù„Ø§ØªØµØ§Ù„ Ø§Ù„Ù…Ø±ÙƒØ²ÙŠ Call manager ÙˆØ§Ù„Ù‡ÙˆØ§ØªÙ Ùˆ Software , Vmware', '(Ø¯Ø§ÙŠÙ…Ù†Ø´Ù† Ø¯Ø§ØªØ§ (Ø´Ù‡Ø¨Ø§Ø²- Ù…Ø­Ù…Ø¯ Ø¹Ø«Ù…Ø§Ù†', 'canceled', '  ', '15273', '  ', '<p>ÙŠØ­ØªØ§Ø¬ Ù…Ø±Ø§Ø¬Ø¹Ø© Ø§Ø®ÙŠØ±Ù‡ Ù…Ø¹ Ø§Ù„Ø´Ø±ÙƒØ©</p>', '', '2015-03-14', '2015-03-13', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(63, 7, 'Servers (Hardware) Ø§Ù„Ø§ØªØµØ§Ù„ Ø§Ù„Ù…Ø±ÙƒØ²ÙŠ   Ø¹Ø¯Ø¯ 2', '(Ø¯Ø§ÙŠÙ…Ù†Ø´Ù† Ø¯Ø§ØªØ§ (Ø´Ù‡Ø¨Ø§Ø²- Ù…Ø­Ù…Ø¯ Ø¹Ø«Ù…Ø§Ù†', 'active', '  ', '6,397.00', '  ', '', '', '2015-03-20', '2017-08-31', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(65, 8, 'EMC Data Domain Storage', '(Ù…Ù‡Ø§Ù… Ø§Ù„Ø®Ù„ÙŠØ¬ Ù…Ø§ØªÙƒÙˆ (Ø±Ù…Ø²ÙŠ ØªÙŠÙ…Ø§Ù†ÙŠ', 'active', '  ', '200000', '  ', '<p>Veeam&nbsp;Ù…Ø¹</p>', '', '2014-12-31', '2016-12-31', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(67, 9, ' Ø§Ù„Ø·Ø§Ø¨Ø¹Ø§Øª Ø§Ù„Ù…Ø±ÙƒØ²ÙŠØ©', 'Ø¨ÙŠØª Ø§Ù„Ø±ÙŠØ§Ø¶', 'expired', '  ', '120000', '  ', '', '', '2015-03-22', '2016-03-22', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(69, 10, 'Ø®Ø¯Ù…Ø© Ø§Ù„Ø§Ù†ØªØ±Ù†Øª', 'Ù†ÙˆØ± Ù†Øª ', 'active', '  ', '120000', '  ', '', '', '2014-12-25', '2017-02-12', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(71, 11, 'Microsofts Ø§ØªÙØ§Ù‚ÙŠØ© Ù…Ø§ÙŠÙƒØ±ÙˆØ³ÙˆÙØª ', 'Ø§Ù„Ø­Ø§Ø³Ø¨ Ø§Ù„Ø¹Ø±Ø¨ÙŠ', 'active', '  ', '1262936', '  ', '', '', '2014-01-01', '2016-12-31', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(74, 12, 'SSL Exchange  Ø§Ù„ØªØ´ÙÙŠØ± Ø§Ù„Ø§Ù„ÙƒØªØ±ÙˆÙ†ÙŠ', ' Ø±Ø§ÙŠØ§Øª Ø§Ù„ØªÙ‚Ù†ÙŠØ©', 'active', '  ', '3600', '  ', '', '', '2014-09-04', '2017-09-04', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(75, 13, ' Sophos UTM + AntiVirus ', 'Ø¯Ù„ØªØ§ Ù„Ù„Ø§ØªØµØ§Ù„Ø§Øª', 'active', '  ', '120000', '  ', '', '', '2014-12-25', '2017-12-25', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(76, 14, 'DropBox', 'DropBox', 'active', '  ', '', '  ', '', '', '2015-01-22', '2017-01-22', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(77, 15, 'IMS4000 (ØºØ±ÙØ© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª (Ù†Ø¸Ø§Ù… Ø§Ù„Ù…Ø±Ø§Ù‚Ø¨Ø©', 'Ø±Ø§ÙŠØ§Øª Ø§Ù„ØªÙ‚Ù†ÙŠØ©', 'expired', '  ', '', '  ', '', '', '2016-07-26', '2015-07-26', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(78, 16, 'UPS (ØºØ±ÙØ© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª (Ù†Ø¸Ø§Ù… Ø¥Ø¯Ø§Ø±Ø© Ø§Ù„Ø·Ø§Ù‚Ø© Ø§Ù„Ø§Ø­ØªÙŠØ§Ø·ÙŠØ©', 'Ø§Ù„Ø£Ø·Ø± Ù„Ù„ØªÙ‚Ù†ÙŠØ©', 'active', '  ', '', '  ', '<p>Ù…Ø±Ø§Ø¬Ø¹Ø© Ø§Ù„Ø¨Ø´Ø§ÙˆØ±ÙŠ</p>', '', '2015-08-16', '2016-08-16', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(79, 17, 'STC Routers', 'STC', 'active', '  ', '19-05-2017', '  ', '<p>Ø£Ø¬Ù‡Ø²Ø© 5</p>\r\n<p>Ùˆ</p>\r\n<p>Ø£Ø¬Ù‡Ø²Ø© 8</p>\r\n<p>&nbsp;</p>', '', '2015-12-09', '2017-05-19', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(80, 18, ' (Ø§Ù„Ø´Ø¨ÙƒØ© Ø§Ù„Ø¯Ø§Ø®Ù„ÙŠØ© (Ø§Ù„Ø¨ÙˆØ§Ø¨Ø© Ø§Ù„Ø¯Ø§Ø®Ù„ÙŠØ© - Ø§Ù„ÙØ¹Ø§Ù„ÙŠØ§Øª- Ø§Ù„ØªØ¨Ø§Ø¯Ù„ Ø§Ù„ØªØ¬Ø§Ø±ÙŠ - Ø§Ù„Ù…Ù†ØªØ¯ÙŠØ§Øª', 'Ø£Ù†ØªØ±Ø¢ÙƒØªÙ', 'active', '  ', '40000', '  ', '', '', '2015-01-16', '2017-03-30', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(81, 19, 'EXA Ø§Ø³ØªØ¶Ø§ÙØ© Ù…ÙˆØ§Ù‚Ø¹ Ø§Ù„Ù…Ø¬Ù„Ø³ Ø§Ù„Ø®Ø§Ø±Ø¬ÙŠØ©', 'Ø¥ÙƒØ³Ø§Ø¡', 'active', '  ', '92000', '  ', '', '', '2015-03-09', '2017-02-27', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(82, 20, '( Ø²Ù‡ÙŠØ± ÙØ§ÙŠØ² ( Ø§Ù„Ù…Ø±Ø§Ø³Ù„Ø§Øª - Ø§Ù„Ù…ÙˆØ§Ø±Ø¯ Ø§Ù„Ø¨Ø´Ø±ÙŠØ©', 'Ø²Ù‡ÙŠØ± ÙØ§ÙŠØ²', 'expired', '  ', '56964', '  ', '', '', '2015-04-10', '2016-04-10', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(83, 21, '(ØºØ±ÙØ© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª (Ø§Ù„ØªÙƒÙŠÙŠÙ', 'Ø§Ù„Ø¨Ø´Ø§ÙˆØ±ÙŠ', 'expired', '  ', '15000', '  ', '', '', '2015-07-15', '2016-07-16', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(84, 22, 'RightFAX Ø§Ù„ÙØ§ÙƒØ³ Ø§Ù„Ù…Ø±ÙƒØ²ÙŠ ', 'Ø§Ù„Ù†Ø§ÙØ°Ø© Ø§Ù„Ø¯ÙˆÙ„ÙŠØ©', 'active', '', '121000', '', '', '', '2013-09-17', '2016-10-07', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(85, 23, '(ØºØ±ÙØ© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª (Ù†Ø¸Ø§Ù… Ù…ÙƒØ§ÙØ­Ø© Ø§Ù„Ø­Ø±Ø§Ø¦Ù‚', 'Ø³ÙŠØªØ±Ø§', 'active', '  ', '30000', '  ', '', '', '2014-05-14', '2017-05-14', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27'),
(86, 24, 'Ø§Ù„Ø¨Ø·Ø§Ø±ÙŠØ§Øª Ø§Ù„ÙƒØ¨ÙŠØ±Ø©', 'Ø¯Ù„ØªØ§ Ù„Ù„Ø§ØªØµØ§Ù„Ø§Øª', 'expired', '  ', '76000', '  ', '', '', '2013-10-29', '2015-10-29', 'ÙŠÙˆØ³Ù Ø´Ø±ÙŠÙ Ø§Ù„Ø¹Ø¨Ø¯Ø§Ù„ÙˆÙ‡Ø§Ø¨', '2016-07-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`,`email`);

--
-- Indexes for table `warranty_entries`
--
ALTER TABLE `warranty_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `warranty_entries`
--
ALTER TABLE `warranty_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
