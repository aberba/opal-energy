-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2016 at 01:37 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opal_energy`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id_fk` int(11) NOT NULL,
  `first_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'Not',
  `last_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'Yet',
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_registered` int(15) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `admin_id_fk` (`admin_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `admin_id_fk`, `first_name`, `last_name`, `email`, `date_registered`) VALUES
(1, 1, 'super', 'master', 'superman@mail.com', 144040404),
(33, 33, 'Not', 'Yet', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `logo`, `link`, `publish`) VALUES
(1, 'Tigo', 'image.png', 'tigo', '1'),
(2, 'S. poly', 'image.png', NULL, '1'),
(22, 'scssnnnnnbbnnvccc', '1454595247_ddd9d742f827aacd1db8786a38d71b87.png', 'ssnnn', '1'),
(23, 'Nemo', '1454597383_b1256473b5b60d5e0f6eb7379bd3aef6.png', 'nemo.com', '0'),
(24, 'nas', '1454597443_11fc7b21c091f997d87d8472f0a6c2f4.png', 'sksks', '0'),
(25, 'bas', '1454597510_bdd74e7b9ab4ef38462c5bccd5e601b9.png', 'sksks', '0'),
(27, 'nana', '1454597615_aefbe9b7da269e8d4eb73d0e8e485a3a.png', 'sjsjs', '0');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `answer` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `publish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_added` int(15) unsigned NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`question_id`, `question`, `answer`, `publish`, `date_added`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do', '1', 1401292322),
(2, 'What kind of products do you sell?', 'We sell home and office appliances, power plants, engineering tools and industrial fixture.', '1', 1418340867),
(3, 'How can i contact you office', 'undefined', '0', 1418341083);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `last_login` int(15) unsigned DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`admin_id`, `user_name`, `password`, `level`, `last_login`) VALUES
(1, 'admin', '$2y$11$ZjRlYmU0MWJjM2E5NjM4N.zraBTFQGVpxVv2Oh.ZfDeF3edPONYmS', '3', 1457460826),
(33, 'Felix12', '$2y$11$N2JkMDlkNmE5OTYwYzg1NObin4aHkLKRPomwmkf6vTdx1sxctovJm', '2', 1407852761);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `publish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_to_expire` int(15) unsigned NOT NULL,
  `date_saved` int(15) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `publish`, `date_to_expire`, `date_saved`) VALUES
(1, 'Hello, welcome to Opal Energy Solutions. \r\nTake a glance through our products and services.', '1', 1482192000, 1456583861);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `option_id` int(2) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` set('0','1','','') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_name`, `option_value`) VALUES
(1, 'show_products_price', '1'),
(2, 'show_products_stock', '1'),
(3, 'show_products_specs', '1'),
(4, 'show_products_read_more', '1'),
(5, 'show_manufacturer', '1'),
(6, 'show_date_made', '1'),
(7, 'show_bonus_offer', '1');

-- --------------------------------------------------------

--
-- Table structure for table `other_contents`
--

CREATE TABLE IF NOT EXISTS `other_contents` (
  `is` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `content_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `content_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`is`),
  UNIQUE KEY `content_name` (`content_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Content mostly text that fit into no other table' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `other_contents`
--

INSERT INTO `other_contents` (`is`, `content_name`, `content_value`) VALUES
(1, 'about_us', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id_fk` int(3) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(3) unsigned NOT NULL DEFAULT '0',
  `edited_by` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `ppublish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_added` int(15) unsigned NOT NULL,
  `date_edited` int(15) unsigned NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name` (`product_name`),
  KEY `category_id_fk` (`category_id_fk`),
  KEY `added_by` (`added_by`),
  KEY `edited_by` (`edited_by`),
  KEY `edited_by_2` (`edited_by`),
  KEY `added_by_2` (`added_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=72 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id_fk`, `product_name`, `priority`, `edited_by`, `added_by`, `ppublish`, `date_added`, `date_edited`) VALUES
(66, 24, 'Solar Panel', 3, 1, 1, '1', 0, 1407858083),
(69, 28, 'Dell XPS Mini', 1, 1, 1, '1', 1417816616, 1457464161),
(70, 24, 'HP Wide Touch Display', 1, 1, 1, '1', 1456403834, 1456404401),
(71, 24, 'DELL HD Display', 1, 1, 1, '1', 1456403949, 1456404332);

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

CREATE TABLE IF NOT EXISTS `products_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `publish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_added` int(15) unsigned NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `products_categories`
--

INSERT INTO `products_categories` (`category_id`, `category_name`, `publish`, `date_added`) VALUES
(24, 'home appliances', '1', 1404466404),
(28, 'phones and tablets', '1', 1432727989);

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE IF NOT EXISTS `products_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id_fk` int(11) NOT NULL,
  `image_one` varchar(555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_two` varchar(555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_three` varchar(555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_four` varchar(555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_five` varchar(555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_six` varchar(555) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `product_id_fk_2` (`product_id_fk`),
  KEY `product_id_fk` (`product_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`image_id`, `product_id_fk`, `image_one`, `image_two`, `image_three`, `image_four`, `image_five`, `image_six`) VALUES
(15, 66, '1407788925_0425c45a1c2e62aba8305531bd6ad24b.png', NULL, NULL, NULL, NULL, NULL),
(18, 69, '1432727680_dfb3cce11a72299517953918d11f3330.jpg', '1456406073_746518f5297f1e60ca3951168b92fdc4.jpg', NULL, NULL, NULL, NULL),
(19, 70, '1456403873_79f3765dcbccb1b5e27de8dd05baaed9.jpg', NULL, NULL, NULL, NULL, NULL),
(20, 71, '1456403963_54463165b097c142242c9d849c43acda.jpg', '1457460871_0c363c1054528e41bbc2182577809f40.jpg', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products_information`
--

CREATE TABLE IF NOT EXISTS `products_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id_fk` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `bonus` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock` int(5) NOT NULL DEFAULT '0',
  `specs` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date_made` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id_fk` (`product_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `products_information`
--

INSERT INTO `products_information` (`id`, `product_id_fk`, `price`, `bonus`, `stock`, `specs`, `description`, `manufacturer`, `date_made`) VALUES
(16, 66, 234.00, '', 21, '40V silicon cells solar panel with chargeable battery', '@IMAGE2@\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n<br>\r\n<p>@IMAGE3@</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n<br>\r\n\r\n@IMAGE4@\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequatLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>', 'Temmapel', 1392422400),
(19, 69, 5.00, '44', 22, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed', 'bes', 1417737600),
(20, 70, 120.00, '', 4, 'Packed Latest specs on the market for home and office use.', 'ananna', 'Sony', 1452643200),
(21, 71, 18.00, '.30', 3, 'Amour glass with high quality display, power by a Qualm snapdragon GPU', 'agagagga', 'toma', 1456358400);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `introduction` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(3) NOT NULL DEFAULT '0',
  `publish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `date_edited` int(15) unsigned DEFAULT NULL,
  `date_added` int(15) unsigned NOT NULL,
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `service_title` (`title`),
  KEY `added_by` (`added_by`),
  KEY `added_by_2` (`added_by`),
  KEY `edited_by` (`edited_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `title`, `introduction`, `description`, `priority`, `publish`, `added_by`, `edited_by`, `date_edited`, `date_added`) VALUES
(6, 'Home delivery of products', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nis', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n\r\n<br>\r\n<p>@IMAGE2@</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n<br>\r\n\r\n@IMAGE3@\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequatLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>', 123, '1', 1, 1, NULL, 1457461160),
(10, 'Solar Panel Installation', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n@IMAGE1@\r\n<br>\r\n<p>@IMAGE2@</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>\r\n<br>\r\n\r\n@IMAGE3@\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequatLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>', 22333, '1', 1, 1, NULL, 1417815835);

-- --------------------------------------------------------

--
-- Table structure for table `services_images`
--

CREATE TABLE IF NOT EXISTS `services_images` (
  `image_id` int(4) NOT NULL AUTO_INCREMENT,
  `service_id_fk` int(2) NOT NULL,
  `image_one` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `image_two` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `image_three` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `service_id_fk` (`service_id_fk`),
  KEY `service_id_fk_2` (`service_id_fk`),
  KEY `service_id_fk_3` (`service_id_fk`),
  KEY `service_id_fk_4` (`service_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `services_images`
--

INSERT INTO `services_images` (`image_id`, `service_id_fk`, `image_one`, `image_two`, `image_three`) VALUES
(5, 6, '1407859083_bd39a1e26327f79a5e76c56bbad288d5.jpg', '1406741928_826884d47a4f71d33304b187b534cc46.jpg', '1407859105_0beae8df0bce8396b6d3be3191fb043b.jpg'),
(9, 10, '1407859136_23682abacf776b3deecd65775dd41378.jpg', '1407859166_3e01452e9f3d0e633774c3a21ce1e747.jpg', '1407859185_cd47b281b8ef698158a103a7b297d3f6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(2) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'site_name', 'Opal Energy Solution'),
(2, 'site_email_address', 'opalenergy@mail.com'),
(5, 'smtp_host', 'smtp.gates.com'),
(6, 'smtp_user_name', 'opaladmin'),
(7, 'smtp_password', 'secretword'),
(8, 'pagination_per_page', '2'),
(9, 'max_file_size', '3145728'),
(10, 'currency_symbol', '&euro;&nbsp;'),
(11, 'facebook_page_link', 'https://www.facebook.com/opal.energy'),
(12, 'twitter_page_link', 'https://www.twitter.com/@opalenergy'),
(13, 'youtube_page_link', 'https://www.youtube.com/opal.energy'),
(14, 'location_latitude', '-43848494'),
(15, 'location_longitude', '44744856'),
(16, 'map_marker_label', 'Our Location'),
(17, 'map_api_key', 'h4IjeoOovFj7AkHQmhCx2G6I'),
(18, 'smtp_port', '80'),
(19, 'linkedin_page_link', 'www.linkedin.com/opalenergy'),
(20, 'phone_number', '233 246-326-373'),
(21, 'email_address', 'opalenergysolutions@gmail.com'),
(22, 'location_address', 'Accra'),
(23, 'post_address', 'Post Office Box 34, Accra'),
(25, 'products_thumb_intro', 'We sell a wide variety of products for home, office and work.'),
(26, 'services_thumb_intro', 'Experience the best services we offer to our customers.'),
(27, '', ''),
(28, 'faq_thumb_intro', 'Answers to the frequently asked questions by customers .');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE IF NOT EXISTS `slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `publish` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_added` int(15) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `description`, `file_name`, `publish`, `date_added`) VALUES
(16, 'http://localhost/admin/cms_manager.php', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'file_at_1449006992.jpg', '1', 1449006992),
(17, 'Products you have never seen before', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'file_at_1449007039.png', '1', 1449007039),
(18, 'Make your life easy with modern toools', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'file_at_1449007071.png', '1', 1449007071);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `item_value` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `item_name`, `item_value`) VALUES
(1, 'products_thumb_image', '1420407917_fe964e92c16fe3c5feaf690f115829f7.jpg'),
(2, 'services_thumb_image', '1407764413_27ad3ef178d60d18a4e7031b5f2fa760.png'),
(3, 'faq_thumb_image', '1407684663_129155c479aac8c4b8605c231e05ba4f.jpg'),
(4, 'logo_image', '1417817500_702b51501ad862fecb8105dab98205e2.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `admin_id_fk_admins` FOREIGN KEY (`admin_id_fk`) REFERENCES `login` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `added_by_fk_products` FOREIGN KEY (`added_by`) REFERENCES `administrators` (`id`),
  ADD CONSTRAINT `category_id_fk_products` FOREIGN KEY (`category_id_fk`) REFERENCES `products_categories` (`category_id`),
  ADD CONSTRAINT `edited_by_fk_products` FOREIGN KEY (`edited_by`) REFERENCES `administrators` (`id`);

--
-- Constraints for table `products_images`
--
ALTER TABLE `products_images`
  ADD CONSTRAINT `product_id_fk_products_images` FOREIGN KEY (`product_id_fk`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products_information`
--
ALTER TABLE `products_information`
  ADD CONSTRAINT `product_id_fk_products_info` FOREIGN KEY (`product_id_fk`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `added_by_fk_services` FOREIGN KEY (`added_by`) REFERENCES `administrators` (`id`),
  ADD CONSTRAINT `editted_by_fk_admin` FOREIGN KEY (`edited_by`) REFERENCES `administrators` (`id`);

--
-- Constraints for table `services_images`
--
ALTER TABLE `services_images`
  ADD CONSTRAINT `service_id_fk_images` FOREIGN KEY (`service_id_fk`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
