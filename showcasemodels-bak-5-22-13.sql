-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2013 at 05:18 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `showcasemodels`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_title` varchar(45) NOT NULL DEFAULT 'New Album',
  `album_folder` varchar(250) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `album_title`, `album_folder`) VALUES
(2, 'corona notebook 1', 'corona-notebook-1_album'),
(3, 'business plans', 'business-plans_album'),
(4, 'list your home', 'list-your-home_album'),
(5, 'hcp account', 'hcp-account_album'),
(6, 'refined search', 'refined-search_album'),
(7, 'nationwide listing', 'nationwide-listing_album'),
(8, 'shortlisted', 'shortlisted_album'),
(9, 'care home page', 'care-home-page_album'),
(10, 'password combination', 'password-combination_album'),
(11, 'information classified', 'information-classified_album'),
(12, 'health care provider', 'health-care-provider_album'),
(13, 'comprehensive database', 'comprehensive-database_album'),
(14, 'eldercare', 'eldercare_album'),
(15, 'no validation', 'no-validation_album'),
(16, 'for your love ones', 'for-your-love-ones_album'),
(17, '', '_album');

-- --------------------------------------------------------

--
-- Table structure for table `album_image_sizes`
--

CREATE TABLE IF NOT EXISTS `album_image_sizes` (
  `size_id` int(11) NOT NULL AUTO_INCREMENT,
  `dimensions` varchar(20) NOT NULL,
  `album_id` int(11) NOT NULL,
  PRIMARY KEY (`size_id`),
  KEY `fk_size_album_id` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `album_image_sizes`
--

INSERT INTO `album_image_sizes` (`size_id`, `dimensions`, `album_id`) VALUES
(2, '900x1024', 2),
(3, '150x500', 2),
(5, '250x300', 3),
(6, '1024x1024', 4),
(7, '1024x1024', 5),
(8, '1024x1024', 6),
(9, '1024x1024', 7),
(10, '1024x1024', 8),
(11, '1024x1024', 9),
(12, '1024x1024', 10),
(13, '1024x1024', 11),
(14, '1024x104', 12),
(15, '104x104', 13),
(16, '1025x1024', 14),
(17, '201x104', 15),
(18, '105x205', 16),
(19, 'x', 17);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `article_title` varchar(255) NOT NULL,
  `intro` text,
  `brief` text,
  `approach` text,
  `what_we_did` text,
  `status` enum('published','unpublished') NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL,
  `date_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `link_url` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  KEY `route_id` (`route_id`),
  KEY `article_category_id` (`category_id`),
  KEY `article_subcategory_id` (`subcategory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE IF NOT EXISTS `article_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(100) NOT NULL,
  `category_url` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_url_UNIQUE` (`category_url`),
  UNIQUE KEY `category_title_UNIQUE` (`category_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_images`
--

CREATE TABLE IF NOT EXISTS `article_images` (
  `article_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `used_for` varchar(45) DEFAULT 'gallery',
  PRIMARY KEY (`article_image_id`),
  KEY `fk_article_image_id` (`image_id`),
  KEY `fk_article_images_image` (`image_id`),
  KEY `fk_article_images2` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_subcategories`
--

CREATE TABLE IF NOT EXISTS `article_subcategories` (
  `subcategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `subcategory_title` varchar(100) NOT NULL,
  `subcategory_description` varchar(250) DEFAULT NULL,
  `subcategory_url` varchar(100) NOT NULL,
  PRIMARY KEY (`subcategory_id`),
  UNIQUE KEY `subcategory_url_UNIQUE` (`subcategory_url`),
  KEY `FK_subcategory_2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_tags`
--

CREATE TABLE IF NOT EXISTS `article_tags` (
  `article_id` int(11) NOT NULL,
  `tag` varchar(45) DEFAULT NULL,
  KEY `fk_tags_1` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(45) NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  KEY `fk_cart_item` (`payment_id`),
  KEY `fk_cart_item2` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_accounts`
--

CREATE TABLE IF NOT EXISTS `customer_accounts` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `faxnumber` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `customer_accounts`
--

INSERT INTO `customer_accounts` (`customer_id`, `firstname`, `lastname`, `address`, `address_2`, `city`, `state`, `zipcode`, `country`, `phonenumber`, `faxnumber`, `company`, `email`, `username`, `password`) VALUES
(1, 'kevin', 'baisas', '281 prudencio st. samapaloc manila', '', 'manila', '', '1008', 'ph', '0922titingkangaroo', '', 'starfish', 'kevin.baisas@starfi.sh', 'callmebaby69', '9bf66df12eed47d67ce692896df50eff41cfde41'),
(2, 'sinong ', 'papamo', 'sinong papa mo', '', 'manila', '', '1008', 'ph', '0922titingkangaroo', '', '', 'sinongpapamo@yahoo.com', 'sinongpapamo', 'fe703d258c7ef5f50b71e06565a65aa07194907f'),
(5, 'kibin', 'sabias', '281 prudencio st. sampaloc manila', '', 'manila', '', '1008', 'philippines', '0922-titi-ng-kangaroo', '', 'starfish', 'suckmysaltyballs@ymail.com', 'kibin', 'fe703d258c7ef5f50b71e06565a65aa07194907f'),
(6, 'kevin', 'baisas', '281 prudencio st sampaloc manila', '', 'manila', '', '1008', 'philippines', '0922', '', 'starfish', 'kevin.baisas@starfi.sh', 'kevinbaisas', '9bf66df12eed47d67ce692896df50eff41cfde41');

-- --------------------------------------------------------

--
-- Table structure for table `customer_checkouts`
--

CREATE TABLE IF NOT EXISTS `customer_checkouts` (
  `checkout_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `product_ids` text,
  `product_titles` text,
  `product_quantities` text,
  `product_prices` text,
  `total_price` varchar(255) DEFAULT NULL,
  `checkout_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`checkout_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `customer_checkouts`
--

INSERT INTO `customer_checkouts` (`checkout_id`, `customer_id`, `product_ids`, `product_titles`, `product_quantities`, `product_prices`, `total_price`, `checkout_status`) VALUES
(18, 5, '13,14', 'airline-test-product-7,airline-test-product-8', '3,10', '70.00,3.00', '240', 'Finished'),
(22, 5, '14', 'airline-test-product-8', '11', '3.00', '33', 'Finished'),
(23, 5, '14,4,5,11,12,13', 'airline-test-product-8,airline-test-product-1,airline-test-product-2,airline-test-product-5,airline-test-product-6,airline-test-product-7', '11,3,3,3,3,3', '3.00,0.00,0.00,0.00,0.00,70.00', '243', 'Unfinished'),
(24, 5, '13,14,15', 'airline-test-product-7,airline-test-product-8,airline-test-product-9', '1,1,1', '70.00,3.00,0.00', '73', 'Finished'),
(25, 5, '13,14,15', 'airline-test-product-7,airline-test-product-8,airline-test-product-9', '5,1,1', '70.00,3.00,0.00', '353', 'Finished'),
(26, 6, '13,14,15', 'airline-test-product-7,airline-test-product-8,airline-test-product-9', '3,5,7', '70.00,3.00,0.00', '225', 'Unfinished'),
(27, 6, '13,14,15', 'airline-test-product-7,airline-test-product-8,airline-test-product-9', '3,5,7', '70.00,3.00,0.00', '225', 'Unfinished'),
(28, 6, '13,14,15,4,5', 'airline-test-product-7,airline-test-product-8,airline-test-product-9,airline-test-product-1,airline-test-product-2', '3,5,7,1,1', '70.00,3.00,0.00,0.00,0.00', '225', 'Unfinished'),
(29, 6, '13,14,15,4,5', 'airline-test-product-7,airline-test-product-8,airline-test-product-9,airline-test-product-1,airline-test-product-2', '3,5,7,1,1', '70.00,3.00,0.00,0.00,0.00', '225', 'Unfinished'),
(30, NULL, '20,5,9', 'military-product-1,airline-test-product-2,airline-test-product-3', '4,1,1', '0.00,0.00,0.00', '0', 'Unfinished'),
(31, NULL, '20', 'military-product-1', '7', '0.00', '0', 'Unfinished'),
(32, NULL, '4,5,9', 'airline-test-product-1,airline-test-product-2,airline-test-product-3', '1,1,1', '0.00,0.00,0.00', '0', 'Unfinished'),
(33, 5, '4,5', 'airline-test-product-1,airline-test-product-2', '1,1', '0.00,0.00', '0', 'Unfinished'),
(34, 5, '4,5', 'airline-test-product-1,airline-test-product-2', '1,1', '0.00,0.00', '0', 'Unfinished'),
(35, 5, '4,5', 'airline-test-product-1,airline-test-product-2', '1,1', '0.00,0.00', '0', 'Unfinished');

-- --------------------------------------------------------

--
-- Table structure for table `enterprise_settings`
--

CREATE TABLE IF NOT EXISTS `enterprise_settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `use_smtp` tinyint(4) NOT NULL DEFAULT '0',
  `smtp_host` varchar(45) NOT NULL,
  `smtp_username` varchar(45) NOT NULL,
  `smtp_pass` varchar(45) NOT NULL,
  `smtp_auth` tinyint(4) NOT NULL DEFAULT '0',
  `smtp_port` varchar(45) NOT NULL,
  `from_email` varchar(45) NOT NULL,
  `from_name` varchar(45) NOT NULL,
  `to_email` varchar(45) NOT NULL,
  `to_name` varchar(45) NOT NULL,
  `google_analytics` text NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `enterprise_settings`
--

INSERT INTO `enterprise_settings` (`settings_id`, `username`, `password`, `use_smtp`, `smtp_host`, `smtp_username`, `smtp_pass`, `smtp_auth`, `smtp_port`, `from_email`, `from_name`, `to_email`, `to_name`, `google_analytics`) VALUES
(1, 'admin', 'fe703d258c7ef5f50b71e06565a65aa07194907f', 1, 'mail.starfi.sh', 'mailing@starfi.sh', '4mailing', 0, '25', '', '', 'michael.soriano@starfi.sh', 'LostArch', ' var _gaq = _gaq || [];\r\n  _gaq.push([''_setAccount'', ''UA-35662078-1'']);\r\n  _gaq.push([''_trackPageview'']);\r\n\r\n  (function() {\r\n    var ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true;\r\n    ga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js'';\r\n    var s = document.getElementsByTagName(''script'')[0]; s.parentNode.insertBefore(ga, s);\r\n  })();');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `image_title` varchar(45) NOT NULL DEFAULT 'New Photo',
  `image_caption` varchar(500) NOT NULL DEFAULT 'Place caption here.',
  `filename` varchar(120) NOT NULL,
  `filename_ext` varchar(4) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_id`),
  KEY `fk_images_album_id` (`album_id`),
  KEY `fk_images_size_id` (`size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `album_id`, `size_id`, `image_title`, `image_caption`, `filename`, `filename_ext`, `date_created`) VALUES
(3, 2, 2, 'New Photo', 'floating boxes', 'FISHR-PHOTO', '.png', '2013-04-02 08:43:20'),
(4, 2, 2, 'New Photo', 'Place caption here.', 'technologies-background', '.jpg', '2013-04-02 08:52:43'),
(5, 2, 3, 'New Photo', 'Place caption here.', 'executives', '.jpg', '2013-04-02 08:53:20'),
(6, 3, 5, 'New Photo', 'Place caption here.', '697x325pixels-04-buffets', '.jpg', '2013-04-02 08:56:38'),
(7, 2, 2, 'New Photo', 'Place caption here.', 'Starfish_Enterprise_V3', '.png', '2013-04-03 02:09:18'),
(8, 2, 2, 'New Photo', 'Place caption here.', 'Starfish-Enterprise-V3-2', '.png', '2013-04-03 02:09:18'),
(9, 2, 2, 'New Photo', 'Place caption here.', 'Starfish-Enterprise-V3-3', '.png', '2013-04-03 02:09:18'),
(10, 2, 2, 'New Photo', 'Place caption here.', 'Starfish-Enterprise-V3-4', '.png', '2013-04-03 02:09:18'),
(11, 2, 2, 'New Photo', 'Place caption here.', 'Starfish-Enterprise-V3-5', '.png', '2013-04-03 02:09:18'),
(13, 2, 2, 'New Photo', 'Place caption here.', 'SUBAR_IMPREZA_by_BADH13', '.jpg', '2013-04-03 02:09:18'),
(15, 2, 2, 'New Photo', 'Place caption here.', 'toyota-supra-0', '.jpg', '2013-04-03 02:09:19'),
(16, 2, 2, 'New Photo', 'Place caption here.', 'Toyota-Supra-2014-450x299', '.jpg', '2013-04-03 02:09:19'),
(18, 4, 6, 'New Photo', 'Place caption here.', '1920', '.jpg', '2013-04-04 06:53:47'),
(19, 5, 7, 'New Photo', 'Place caption here.', 'usic-popup', '.jpg', '2013-04-04 06:54:04'),
(20, 6, 8, 'New Photo', 'Place caption here.', 'hey', '.jpg', '2013-04-04 06:54:39'),
(21, 7, 9, 'New Photo', 'Place caption here.', 'services_03', '.png', '2013-04-04 06:54:58'),
(22, 8, 10, 'New Photo', 'Place caption here.', 'thumbnail7', '.jpg', '2013-04-04 06:55:38'),
(23, 9, 11, 'New Photo', 'Place caption here.', 'Ocean-Front-Villa', '.png', '2013-04-04 06:56:08'),
(24, 10, 12, 'New Photo', 'Place caption here.', 'cabin-in-the-woods-poster', '.jpg', '2013-04-04 06:56:32'),
(25, 11, 13, 'New Photo', 'Place caption here.', 'Untitled-2', '.png', '2013-04-04 06:56:53'),
(26, 12, 14, 'New Photo', 'Place caption here.', 'world_map', '.jpg', '2013-04-04 06:57:03'),
(27, 13, 15, 'New Photo', 'Place caption here.', 'sts_galapagos', '.jpg', '2013-04-04 06:57:20'),
(28, 14, 16, 'New Photo', 'Place caption here.', 'wallpaper-1284143', '.jpg', '2013-04-04 06:58:25'),
(29, 15, 17, 'New Photo', 'Place caption here.', 'Koala', '.jpg', '2013-04-04 06:58:32'),
(30, 16, 18, 'New Photo', 'Place caption here.', 'Penguins', '.jpg', '2013-04-04 06:58:39'),
(31, 2, 3, 'New Photo', 'Place caption here.', 'Villa-Bathroom', '.png', '2013-04-18 09:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_number` varchar(45) NOT NULL,
  `invoice_number` varchar(45) NOT NULL,
  `payment_method` varchar(45) NOT NULL,
  `delivery_method` varchar(45) NOT NULL,
  `cart_weight` decimal(10,2) NOT NULL,
  `is_product_tangible` enum('Y','N') NOT NULL,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `fk_payment1` (`product_id`),
  KEY `fk_payment2` (`buyer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `product_title` varchar(45) NOT NULL,
  `description` text,
  `product_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `featured_product` enum('0','1') NOT NULL,
  `date_created` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_product_categories1` (`category_id`),
  KEY `fk_products_routes1` (`route_id`),
  KEY `fk_products_3` (`subcategory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `route_id`, `category_id`, `subcategory_id`, `product_title`, `description`, `product_price`, `featured_product`, `date_created`, `date_updated`) VALUES
(4, 16, 13, NULL, 'airline test product 1', '', 0.00, '0', '2013-05-06', '2013-05-16'),
(5, 17, 13, NULL, 'airline test product 2', '', 0.00, '1', '2013-05-06', '2013-05-06'),
(7, 30, 18, NULL, 'private aircraft test 1', '', 0.00, '0', '2013-05-07', '2013-05-07'),
(8, 31, 19, NULL, 'nasa product 1', '', 0.00, '1', '2013-05-07', '2013-05-07'),
(9, 32, 13, NULL, 'airline test product 3', '', 0.00, '0', '2013-05-07', '2013-05-07'),
(10, 33, 13, NULL, 'airline test product 4', '', 0.00, '1', '2013-05-07', '2013-05-07'),
(11, 34, 13, NULL, 'airline test product 5', '', 0.00, '0', '2013-05-07', '2013-05-07'),
(12, 35, 13, NULL, 'airline test product 6', '', 0.00, '1', '2013-05-07', '2013-05-07'),
(13, 36, 13, 1, 'airline test product 7', '', 70.00, '0', '2013-05-08', '2013-05-08'),
(14, 37, 13, 1, 'airline test product 8', '', 3.00, '1', '2013-05-08', '2013-05-08'),
(15, 38, 13, 1, 'airline test product 9', '', 0.00, '0', '2013-05-09', '2013-05-09'),
(16, 39, 13, 1, 'airline test product 10', '', 0.00, '1', '2013-05-09', '2013-05-09'),
(17, 40, 13, 6, 'airline test product 11', '', 0.00, '0', '2013-05-10', '2013-05-10'),
(18, 41, 13, 6, 'airline test product 12', '', 0.00, '1', '2013-05-10', '2013-05-10'),
(19, 42, 13, 8, 'airline test product 13', '', 0.00, '0', '2013-05-10', '2013-05-10'),
(20, 43, 17, 7, 'military product 1', '', 0.00, '1', '2013-05-10', '2013-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL,
  `category_url` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_title_UNIQUE` (`category_title`),
  UNIQUE KEY `category_url_UNIQUE` (`category_url`),
  KEY `route_id` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`category_id`, `route_id`, `category_title`, `category_url`) VALUES
(13, 15, 'airlines models', '/airlines-models'),
(17, 21, 'military aircraft models', '/military-aircraft-models'),
(18, 22, 'private aircraft models', '/private-aircraft-models'),
(19, 23, 'nasa spacecraft models', '/nasa-spacecraft-models');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `used_for` varchar(45) NOT NULL DEFAULT 'main_image',
  PRIMARY KEY (`product_image_id`),
  KEY `fk_product_images_images1` (`image_id`),
  KEY `fk_product_images_products1` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`product_image_id`, `image_id`, `product_id`, `used_for`) VALUES
(4, 16, 4, 'gallery'),
(5, 15, 5, 'gallery'),
(7, 8, 7, 'gallery'),
(8, 10, 8, 'gallery'),
(9, 13, 9, 'gallery'),
(10, 5, 10, 'gallery'),
(11, 3, 11, 'gallery'),
(12, 11, 12, 'gallery'),
(13, 16, 13, 'gallery'),
(14, 3, 14, 'gallery'),
(15, 10, 15, 'gallery'),
(16, 3, 16, 'gallery'),
(17, 9, 17, 'gallery'),
(18, 8, 18, 'gallery'),
(19, 10, 19, 'gallery'),
(20, 9, 20, 'gallery');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategories`
--

CREATE TABLE IF NOT EXISTS `product_subcategories` (
  `subcategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `subcategory_title` varchar(100) NOT NULL,
  `subcategory_description` varchar(250) NOT NULL,
  `subcategory_url` varchar(100) NOT NULL,
  PRIMARY KEY (`subcategory_id`),
  UNIQUE KEY `subcategory_url_UNIQUE` (`subcategory_url`),
  KEY `FK_subcategory_2` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `product_subcategories`
--

INSERT INTO `product_subcategories` (`subcategory_id`, `category_id`, `subcategory_title`, `subcategory_description`, `subcategory_url`) VALUES
(1, 13, 'test', '', '/test'),
(6, 13, 'test 2', '', '/test-2'),
(7, 17, 'military aircraft subcategory', '', '/military-aircraft-subcategory'),
(8, 13, 'test 3', '', '/test-3');

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE IF NOT EXISTS `route` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `permalink` varchar(45) NOT NULL,
  `page_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`route_id`),
  UNIQUE KEY `permalink_UNIQUE` (`permalink`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`route_id`, `permalink`, `page_id`) VALUES
(15, 'airlines-models', 'products'),
(16, 'airline-test-product-1', 'airlines-models'),
(17, 'airline-test-product-2', 'products'),
(21, 'military-aircraft-models', 'products'),
(22, 'private-aircraft-models', 'products'),
(23, 'nasa-spacecraft-models', 'products'),
(30, 'private-aircraft-test-1', NULL),
(31, 'nasa-product-1', 'nasa-spacecraft-models'),
(32, 'airline-test-product-3', NULL),
(33, 'airline-test-product-4', NULL),
(34, 'airline-test-product-5', NULL),
(35, 'airline-test-product-6', NULL),
(36, 'airline-test-product-7', NULL),
(37, 'airline-test-product-8', NULL),
(38, 'airline-test-product-9', NULL),
(39, 'airline-test-product-10', NULL),
(40, 'airline-test-product-11', NULL),
(41, 'airline-test-product-12', NULL),
(42, 'airline-test-product-13', NULL),
(43, 'military-product-1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `user_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `user_role_id` varchar(45) NOT NULL DEFAULT 'admin',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`user_account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`user_account_id`, `username`, `password`, `user_role_id`, `last_login`, `email`) VALUES
(1, 'admin', 'fe703d258c7ef5f50b71e06565a65aa07194907f', 'admin', '2013-05-06 04:02:41', 'joseph.reyes@starfi.sh');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account_id` int(11) NOT NULL,
  `street_address` varchar(100) NOT NULL,
  `city` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL,
  `zip` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `phone_extension` varchar(45) NOT NULL,
  `address_type` enum('billing','delivery') NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `fk_user_address_user_accounts1` (`user_account_id`),
  KEY `FK_address_1` (`user_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album_image_sizes`
--
ALTER TABLE `album_image_sizes`
  ADD CONSTRAINT `fk_size_album_id` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_category_id` FOREIGN KEY (`category_id`) REFERENCES `article_categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `article_subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `article_subcategories` (`subcategory_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `route_id` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `article_images`
--
ALTER TABLE `article_images`
  ADD CONSTRAINT `fk_article_images2` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_article_images_image` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `article_subcategories`
--
ALTER TABLE `article_subcategories`
  ADD CONSTRAINT `FK_subcategory_20` FOREIGN KEY (`category_id`) REFERENCES `article_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `article_tags`
--
ALTER TABLE `article_tags`
  ADD CONSTRAINT `fk_tags_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_item` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_item2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_checkouts`
--
ALTER TABLE `customer_checkouts`
  ADD CONSTRAINT `customer_checkouts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_accounts` (`customer_id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_album_id` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_images_size_id` FOREIGN KEY (`size_id`) REFERENCES `album_image_sizes` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payment2` FOREIGN KEY (`buyer_id`) REFERENCES `user_accounts` (`user_account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_3` FOREIGN KEY (`subcategory_id`) REFERENCES `product_subcategories` (`subcategory_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_products_product_categories1` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_products_routes1` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_product_images_images1` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_images_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD CONSTRAINT `FK_subcategory_2` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `FK_address_1` FOREIGN KEY (`user_account_id`) REFERENCES `user_accounts` (`user_account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
