-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2013 at 01:16 PM
-- Server version: 5.6.11
-- PHP Version: 5.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `voucher`
--
CREATE DATABASE IF NOT EXISTS `voucher` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `voucher`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `odr` int(11) NOT NULL DEFAULT '255',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `name`, `odr`, `created_at`) VALUES
(1, '餐饮零售', 1, '2013-07-12 10:08:37'),
(2, '服饰时尚', 2, '2013-07-12 10:08:43'),
(3, '酒吧俱乐部', 255, '2013-07-12 10:06:16'),
(4, '娱乐休闲', 255, '2013-07-12 10:06:35'),
(5, '家电科技', 255, '2013-07-12 10:07:11'),
(6, '金融理财', 255, '2013-07-12 10:07:11'),
(7, '图书音像', 255, '2013-07-12 10:07:40'),
(8, '游戏体育', 255, '2013-07-12 10:07:40'),
(9, '健康美容', 255, '2013-07-12 10:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE IF NOT EXISTS `favourites` (
  `id_favourite` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_voucher` bigint(20) NOT NULL,
  `fk_user` bigint(20) NOT NULL,
  `status` enum('active','delete') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_favourite`),
  KEY `fk_voucher` (`fk_voucher`),
  KEY `fk_user` (`fk_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE IF NOT EXISTS `merchants` (
  `id_merchant` bigint(20) NOT NULL AUTO_INCREMENT,
  `company` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `lag` float(10,3) DEFAULT NULL,
  `lng` float(10,3) DEFAULT NULL,
  `address1` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` int(11) DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `term_condition` text COLLATE utf8_unicode_ci COMMENT 'default content of terms and conditions',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_merchant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `redemption`
--

CREATE TABLE IF NOT EXISTS `redemption` (
  `id_redemption` bigint(11) NOT NULL AUTO_INCREMENT,
  `fk_voucher` bigint(20) NOT NULL,
  `fk_user` bigint(20) NOT NULL,
  `status` enum('init','done') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_redemption`),
  KEY `fk_voucher` (`fk_voucher`),
  KEY `fk_user` (`fk_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` bigint(20) NOT NULL AUTO_INCREMENT,
  `role` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` int(64) NOT NULL,
  `lname` int(64) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `fk_role` bigint(20) NOT NULL,
  `fk_country` bigint(20) DEFAULT NULL,
  `fk_state` bigint(20) DEFAULT NULL,
  `fk_city` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  KEY `fk_state` (`fk_state`),
  KEY `fk_country` (`fk_country`),
  KEY `fk_city` (`fk_city`),
  KEY `fk_role` (`fk_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE IF NOT EXISTS `vouchers` (
  `id_voucher` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fk_merchant` bigint(20) NOT NULL,
  `term_condition` text COLLATE utf8_unicode_ci,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `reusable` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'this voucher is reusable',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voucher`),
  KEY `fk_merchant` (`fk_merchant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`fk_voucher`) REFERENCES `vouchers` (`id_voucher`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `redemption`
--
ALTER TABLE `redemption`
  ADD CONSTRAINT `redemption_ibfk_2` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `redemption_ibfk_1` FOREIGN KEY (`fk_voucher`) REFERENCES `vouchers` (`id_voucher`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_role`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

