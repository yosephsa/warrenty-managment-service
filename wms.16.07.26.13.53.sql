-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2016 at 12:52 PM
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
(1, 'ralfrayan@csc.org.sa', 'ralfrayan', 'user', 'Reem', 'A.', 'Alfrayan', 1, '1975-04-30', '2016-07-17', '$2y$10$73sHwrXKHR8b8qxYmRM/E.B7ERaDuemlyT22uDn6Nb8lVxa8C93QO'),
(2, 'yosephsa0@gmail.com', 'yoseph1998', 'admin', 'Yoseph', 'S.', 'Alabdulwahab', 1, '1998-12-30', '2016-07-15', '$2y$10$MtOgVfa9PLQr.73lNtmdU.FlNh9D68wynC32tM9kvHXEtznCtB0kK');

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
(0, 0, 'CopCom Warranty', 'Applee', 'expired', '', '200', '<p>Email: test@example.com</p>\r\n<p>Phone:&nbsp;+1 800 888 8888</p>\r\n<p>Address: 233 Stuff rd, Things, California</p>', '<p>This is the best of the best of warranties</p>', '/uploads/wms.16.07.19.09.18(Beta 1.0).zip', '2012-03-04', '2015-01-31', 'yoseph1998', '2016-07-21'),
(2, 0, 'CopCom Warranty', 'Applee', 'expired', '<p>My boss</p>', '350', '<p>Email: test@example.com</p>\r\n<p>Phone:&nbsp;+1 800 888 8888</p>\r\n<p>Address: 233 Stuff rd, Things, California df</p>', '<p>It is getting more expensive but we should still stick to it.</p>', '', '2015-01-31', '2016-01-31', 'yoseph1998', '2016-07-24'),
(3, 12, 'IPhone Warranty', 'Appl', 'active', '<p>asdasd</p>', '200', '<p>Apple.com</p>', '<p>They are pretty good.</p>', '', '2014-07-01', '2016-08-10', 'yoseph1998', '2016-07-25'),
(5, 0, 'CopCom Warranty', 'Applee', 'expired', '<p>My boss</p>', '350', '<p>Email: test@example.com</p>\r\n<p>Phone:&nbsp;+1 800 888 8888</p>\r\n<p>Address: 233 Stuff rd, Things, California df</p>', '<p>It is getting more expensive but we should still stick to it.</p>', ':/uploads/wms.16.07.19.09.18(Beta 1.0).zip:/uploads/wms.16.07.15.01.37.zip', '2016-01-31', '2016-07-25', 'Yoseph S. Alabdulwahab', '2016-07-25'),
(12, 1, 'Flash Drive Protection Warranty', 'SanDisk', 'pending', '<p>Waiting on boss</p>', '250', '<p>Sandisk.com1800 288 8828</p>', '<p>Contact this man for help</p>', '', '2016-07-01', '2018-07-01', 'yoseph1998', '2016-07-25'),
(27, 13, 'Refridgurator Quality Assurance', 'Fridger', 'expired', '', '', '', '', '', '0000-00-00', '0000-00-00', 'yoseph1998', '2016-07-25'),
(28, 13, 'Refridgurator Quality Assurance', 'Fridger', 'active', '  ', '286', ' Rdigers@gmail.comÂ bridgers@gmail.com ', '<p>They are bogus when it comes to money</p>', '', '2016-07-25', '2018-06-30', 'Yoseph S. Alabdulwahab', '2016-07-25'),
(43, 15, 'Mouse Expedition Warranty', 'Logitech', 'canceled', '  ', '2,000', '  ', '<p>Some notes are always important</p>', '/uploads/Reciept.pdf', '2016-07-03', '2016-09-15', 'Yoseph S. Alabdulwahab', '2016-07-26');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
