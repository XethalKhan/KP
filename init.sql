-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 12:47 PM
-- Server version: 5.7.14
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp`
--
CREATE DATABASE IF NOT EXISTS `kp` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `kp`;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT 'Identity column',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Users email',
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Users password',
  `posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp when user last posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table of all users';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `deleted`, `email`, `password`, `posted`) VALUES
(1, 0, 'pera.peric@example.loc', 'pera123', '2022-11-27 16:19:39'),
(2, 0, 'laza.lazic@example.loc', 'laza123', '2022-11-27 16:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL COMMENT 'Identity column',
  `action` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User action',
  `user_id` int(11) NOT NULL COMMENT 'User ID',
  `log_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of action'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User actions logs';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identity column', AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identity column', AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
