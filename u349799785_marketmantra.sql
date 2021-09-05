-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 05, 2021 at 04:55 AM
-- Server version: 10.4.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u349799785_marketmantra`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image_id` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `image_id`, `role_id`, `is_active`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', NULL, '19', 1, 1, '$2y$10$WDA1jl613POjZ.Y79KiPv.1jyAw5.wRIxCCWd2fIhUZLBtty7IAvm', 'cITSvinagzjEFnUHsEGIjcJdOHCWEd7NAE8p75KKvAxkIy1nfEON74sNNmRF', '2020-01-03 02:05:36', '2021-04-06 09:30:40'),
(2, 'Admin', 'marketmantra99@gmail.com', NULL, '15', 2, 1, '$2y$10$4VpnGj2YiecVKg9yoKSuLO6e/xzZea9eQGlTP4X5vlEZfvhU5ZHZy', NULL, NULL, '2021-05-18 05:06:21'),
(7, 'Adee', 'adee@gmail.com', NULL, NULL, 7, 1, '$2y$10$xSuitFLseLgy5ECi8A0oi.Q9pTfiC92OgYAmyTJ3s6f/HnR8J/Wc.', NULL, '2020-04-07 03:38:23', '2021-07-07 06:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `advisory_notification`
--

CREATE TABLE `advisory_notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `moduleId` int(11) DEFAULT NULL,
  `marketId` int(11) DEFAULT NULL,
  `courseId` int(11) DEFAULT NULL,
  `advisorySection` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `expiryDate` date DEFAULT NULL,
  `tradeDate` datetime NOT NULL DEFAULT current_timestamp(),
  `script` text COLLATE utf8_bin DEFAULT NULL,
  `action_trade` enum('1','2') COLLATE utf8_bin NOT NULL COMMENT '1 = Buy, 2 = Sale',
  `quantity` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `stoploss` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `target` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `timeline` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8_bin DEFAULT '0' COMMENT '0= "Opened", 1 = "Closed" , 2 = "Fail", 3 = "Success"',
  `isBuySale` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `advisory_notification`
--

INSERT INTO `advisory_notification` (`id`, `userId`, `parentId`, `moduleId`, `marketId`, `courseId`, `advisorySection`, `expiryDate`, `tradeDate`, `script`, `action_trade`, `quantity`, `price`, `value`, `stoploss`, `target`, `timeline`, `description`, `status`, `isBuySale`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, 11, 8, 'OPTIONS ADVISROY', '2021-08-31', '2021-08-29 16:29:05', 'NIFTY 50 CALL OPTION 16000', '1', '100', '50', NULL, '25', '110', 'POSITIONAL', 'SCRIPT - NIFTY 50 CALL OPTION 16000\r\nEXPIRY - Aug 31, 2021\r\nBUY - 100\r\nPRICE - 50\r\nSTOPLOSS - 25\r\nTARGET - 110\r\nPOSITIONAL\r\nMarket Mantra 99', '0', '0', 1, 0, '2021-08-29 16:29:05', '2021-08-29 16:29:05'),
(2, 7, NULL, 2, 11, 8, 'OPTIONS ADVISROY', '2021-08-31', '2021-08-29 16:29:05', 'NIFTY 50 CALL OPTION 16000', '1', '100', '50', NULL, '25', '110', 'POSITIONAL', 'SCRIPT - NIFTY 50 CALL OPTION 16000\r\nEXPIRY - Aug 31, 2021\r\nBUY - 100\r\nPRICE - 50\r\nSTOPLOSS - 25\r\nTARGET - 110\r\nPOSITIONAL\r\nMarket Mantra 99', '0', '0', 1, 0, '2021-08-29 16:29:05', '2021-08-29 16:29:05'),
(3, NULL, NULL, 2, 11, 8, 'OPTIONS ADVISROY', '2021-08-31', '2021-08-29 16:29:05', 'NIFTY 50 CALL OPTION 16000', '1', '100', '50', NULL, '25', '110', 'POSITIONAL', 'SCRIPT - NIFTY 50 CALL OPTION 16000\r\nEXPIRY - Aug 31, 2021\r\nBUY - 100\r\nPRICE - 50\r\nSTOPLOSS - 25\r\nTARGET - 110\r\nPOSITIONAL\r\nMarket Mantra 99', '0', '1', 1, 0, '2021-08-29 16:29:05', '2021-08-29 16:29:48'),
(4, 1, 3, 2, 11, 8, 'OPTIONS ADVISROY', '2021-08-31', '2021-08-29 16:29:48', 'NIFTY 50 CALL OPTION 16000', '2', '100', '100', NULL, '25', '110', 'POSITIONAL', 'SCRIPT - NIFTY 50 CALL OPTION 16000\r\nEXPIRY - Aug 31, 2021\r\nSELL - 100\r\nPRICE - 100\r\nPOSITIONAL\r\nMarket Mantra 99', '0', '0', 1, 0, '2021-08-29 16:29:48', '2021-08-29 16:29:48'),
(5, 7, 3, 2, 11, 8, 'OPTIONS ADVISROY', '2021-08-31', '2021-08-29 16:29:48', 'NIFTY 50 CALL OPTION 16000', '2', '100', '100', NULL, '25', '110', 'POSITIONAL', 'SCRIPT - NIFTY 50 CALL OPTION 16000\r\nEXPIRY - Aug 31, 2021\r\nSELL - 100\r\nPRICE - 100\r\nPOSITIONAL\r\nMarket Mantra 99', '0', '0', 1, 0, '2021-08-29 16:29:48', '2021-08-29 16:29:48'),
(6, NULL, 3, 2, 11, 8, 'OPTIONS ADVISROY', '2021-08-31', '2021-08-29 16:29:49', 'NIFTY 50 CALL OPTION 16000', '2', '100', '100', NULL, '25', '110', 'POSITIONAL', 'SCRIPT - NIFTY 50 CALL OPTION 16000\r\nEXPIRY - Aug 31, 2021\r\nSELL - 100\r\nPRICE - 100\r\nPOSITIONAL\r\nMarket Mantra 99', '0', '0', 1, 0, '2021-08-29 16:29:49', '2021-08-29 16:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `advisory_notification_reports`
--

CREATE TABLE `advisory_notification_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `moduleId` int(11) DEFAULT NULL,
  `marketId` int(11) DEFAULT NULL,
  `courseId` int(11) DEFAULT NULL,
  `fromDate` date DEFAULT NULL,
  `toDate` date DEFAULT NULL,
  `reportName` text COLLATE utf8_bin DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `advisory_notification_reports`
--

INSERT INTO `advisory_notification_reports` (`id`, `moduleId`, `marketId`, `courseId`, `fromDate`, `toDate`, `reportName`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 2, 11, 8, '2021-08-01', '2021-08-31', 'INDEX_FUTURE_OPTION_2021-08-01_TO_2021-08-31_11.xls', 1, 0, '2021-08-27 04:11:13', '2021-08-27 04:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `api_otp_requests`
--

CREATE TABLE `api_otp_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_otp_requests`
--

INSERT INTO `api_otp_requests` (`id`, `user_id`, `otp`, `created_at`, `updated_at`) VALUES
(32, 1, '562862', '2021-02-02 02:37:24', '2021-02-02 02:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `gender_id`, `parent_id`, `name`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(2, NULL, 0, 'Stock Equity', 1, 0, '2021-05-10 16:42:34', '2021-05-10 16:42:34'),
(3, NULL, 0, 'Stoke Future', 1, 0, '2021-05-10 16:42:26', '2021-05-10 16:42:26'),
(4, NULL, 0, 'Index Future', 1, 0, '2021-05-10 16:43:47', '2021-05-10 16:43:47'),
(5, NULL, 0, 'Stock Options', 1, 0, '2021-05-10 16:45:34', '2021-05-10 16:45:34'),
(6, NULL, 0, 'Index Options', 1, 0, '2021-05-10 16:48:12', '2021-05-10 16:48:12'),
(7, NULL, 0, 'Crypto Currency', 1, 0, '2021-05-10 16:49:11', '2021-05-10 16:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `varTitle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `txtDescription` text COLLATE utf8_bin NOT NULL,
  `pagePhoto` text COLLATE utf8_bin DEFAULT NULL,
  `pagePhotoName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `varTitle`, `txtDescription`, `pagePhoto`, `pagePhotoName`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'About Us', '<p><strong>About Us&nbsp;Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', NULL, NULL, 1, 0, '2021-07-24 15:50:02', '2021-07-29 17:01:23'),
(2, 'Privacy policy', '<p><em><strong>Privacy Policy</strong></em>&nbsp;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', NULL, NULL, 1, 0, '2021-07-24 15:51:38', '2021-07-29 17:04:24'),
(3, 'Terms and Conditions', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>', NULL, NULL, 1, 0, '2021-07-24 15:54:01', '2021-08-08 17:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Black', 1, 0, '2021-04-06 09:17:08', '2021-04-06 03:03:17'),
(2, 'Grey', 1, 0, '2021-04-06 09:17:10', '2021-04-06 03:02:34'),
(3, 'White', 1, 0, '2021-04-06 09:17:12', '2021-04-06 03:02:41'),
(5, 'Orange', 1, 0, '2021-04-06 09:17:14', '2021-04-06 03:03:00'),
(6, 'Red', 1, 0, '2021-04-06 09:17:16', '2021-04-06 03:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`id`, `name`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(125, 'New/Never Worn', 1, 0, '2021-04-06 09:20:39', '2021-04-06 09:20:39'),
(126, 'Gently Used', 1, 0, '2021-04-06 09:20:41', '2021-04-06 09:20:41'),
(127, 'Used', 1, 0, '2021-04-06 09:20:43', '2021-04-06 09:20:43'),
(128, 'Very Worn', 1, 0, '2021-04-06 09:20:45', '2021-04-06 09:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `contact_leads`
--

CREATE TABLE `contact_leads` (
  `id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `email` varchar(155) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_leads`
--

INSERT INTO `contact_leads` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(2, 'Adarsh', 'adarsh@gmail.com', '8866077991', 'Teste', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2020-02-09 10:16:31', NULL),
(3, 'Adarsh', 'adarsh@gmail.com', '8866077991', 'Teste', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2020-02-09 10:16:31', NULL),
(4, 'Adarsh', 'adarsh@gmail.com', '8866077991', 'Teste', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2020-02-09 10:16:31', NULL),
(5, 'Adarsh', 'adarsh@gmail.com', '8866077991', 'Teste', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2020-02-09 10:16:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `varTitle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `txtDescription` text COLLATE utf8_bin NOT NULL,
  `chrIndiaFees` varchar(50) COLLATE utf8_bin NOT NULL,
  `chrWorldFees` varchar(50) COLLATE utf8_bin NOT NULL,
  `intOrder` int(11) DEFAULT NULL,
  `chrFree` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `chrFeatured` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `level` int(11) NOT NULL,
  `moduleTypes` int(11) NOT NULL DEFAULT 1,
  `categories` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `features` text COLLATE utf8_bin NOT NULL DEFAULT '',
  `market` int(11) NOT NULL DEFAULT 11,
  `coursePhoto` text COLLATE utf8_bin DEFAULT NULL,
  `coursePhotoName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `courseDuration` int(11) DEFAULT NULL,
  `offlineCourseFee` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `offlineRegisterLink` text COLLATE utf8_bin DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `chrActive` char(2) COLLATE utf8_bin DEFAULT 'Y',
  `chrDelete` char(2) COLLATE utf8_bin DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `varTitle`, `txtDescription`, `chrIndiaFees`, `chrWorldFees`, `intOrder`, `chrFree`, `chrFeatured`, `level`, `moduleTypes`, `categories`, `features`, `market`, `coursePhoto`, `coursePhotoName`, `courseDuration`, `offlineCourseFee`, `offlineRegisterLink`, `is_active`, `is_delete`, `chrActive`, `chrDelete`, `created_at`, `updated_at`) VALUES
(1, 'Basic Price Analysis Course', '<p>To equip novice and experienced traders alike, with knowledge of how to follow, recognize, and react to market condition.</p>\r\n\r\n<p><strong>Course Detail &amp; Benefits</strong></p>\r\n\r\n<p>Introductory Idea About Stocks, Commodity and Currency Market</p>\r\n\r\n<p><strong>Basics of Stock Market</strong></p>\r\n\r\n<p>Exclusive Trading Techniques For Working People</p>\r\n\r\n<p>3-month free access to MM99 Software Analytical Tools</p>\r\n\r\n<p>6 free webinars on advanced trading strategies.</p>\r\n\r\n<p><strong>Objective of Price Analysis course</strong></p>\r\n\r\n<p>To make this course applicable in all of today&#39;s markets (stocks, bullion, commodities, options, futures, indexes, new listings, Dow, Nasdaq, Kospi, Ftse, Lme) and any other market.</p>\r\n\r\n<p>To equip novice and experienced traders alike, with knowledge of how to follow, recognize, and react to market conditions using our techniques.</p>\r\n\r\n<p>To empower traders to be able to respond to and profit from shorter-term trading as well as long term investing when appropriate; through our price-analysis technique.</p>\r\n\r\n<p>To teach self-reliance that ensures the endless cycle of trading and growing</p>\r\n\r\n<p>Again, this is not an economic, fundamental, technical, or mechanical approach.</p>\r\n\r\n<p>It is a behavioral approach using market-generated information prices i.e. High Price, Low Price and Close price.</p>\r\n\r\n<p><strong>Course Benefits</strong></p>\r\n\r\n<p>This approach teaches you to see clearly what is really happening, the frustration of trading turns into the fascination of human behavior and the result is you can trust your own brains while trading and the pleasure of its purely intellectual.</p>\r\n\r\n<p><strong>Who Can Participate</strong></p>\r\n\r\n<p>Anyone who has some trading and investment experience or in any financial market can participate in our course. Our price analysis course is the key course that is applicable to investors and traders alike. Specifically, our courses are designed for people who are:</p>\r\n\r\n<p>Interested in self-directed investment.</p>\r\n\r\n<p>Motivated by curiosity, and are desirous of knowledge.</p>\r\n\r\n<p>Interested to wish to manage some or all of their investments.</p>\r\n\r\n<p>Urge to become self-dependent and self-reliant.</p>\r\n\r\n<p>Desire to excel. And a willingness to stand different from the crowd.</p>', '18900', '725', 1, 'N', 'Y', 1, 1, '2,3,4', '[\"Introductory Idea About Stocks, Commodity and Currency Market\",\"Basics of Stock Market\",\"Exclusive Trading Techniques For Working People\",\"3-month free access to MM99 Software Analytical Tools\",\"6 free webinars on advanced trading strategies.\",\"test more\"]', 11, '1621875784.technical_analysis-training.png', 'technical_analysis-training', 30, '42', 'https://www.marketmantra99.com/about-us', 1, 0, 'Y', 'N', '2021-05-16 10:03:11', '2021-08-28 17:21:54'),
(2, 'Index Master Trader Program', '<p>Understand step by step move of Index. Analyze Index moves for future 15 days with up to 90% accuracy.</p>\r\n\r\n<p><strong>Course Outline</strong></p>\r\n\r\n<p>Understanding step by step behavior of the market (NIFTY &amp; BANK NIFTY) with 12 Box reference sheet.</p>\r\n\r\n<p>Analyze higher time frames views and set up positional trades</p>\r\n\r\n<p>Analyze index moves for the future 15 days with up to 90% accuracy</p>\r\n\r\n<p>Setting future &amp; option combine strategy</p>\r\n\r\n<p>Learning more than 12 strategies about Market behavior</p>\r\n\r\n<p><strong>Below are the benefits and advantages of the course:</strong></p>\r\n\r\n<p>Understanding step by step behavior of the market (NIFTY &amp; BANK NIFTY) with 12 Box reference sheet.</p>\r\n\r\n<p>Analyze index move for each point movement based on daily &amp; weekly time frames with more than 90% accuracy.</p>\r\n\r\n<p>Analyze higher time frames views and set up positional trades</p>\r\n\r\n<p>Analyze index moves for the future 15 days with up to 90% accuracy.</p>\r\n\r\n<p>Setting future &amp; option combine strategy Learning more than 12 strategies about Market behavior</p>\r\n\r\n<p>Post completion of the course students will get a chance to be a part of the MM99 index fund strategy management group.</p>\r\n\r\n<p>This elite group will take part in the various business channel interviews on behalf of MM99 once they qualify.</p>\r\n\r\n<p>This program will provide guaranteed income from index trades &amp; strategies.</p>', '35800', '1550', 2, 'Y', 'N', 2, 1, '4', '', 11, '1621876030.binary-2372130_1280.jpg', 'binary-2372130_1280', 30, NULL, NULL, 1, 0, 'Y', 'N', '2021-05-16 10:03:11', '2021-05-24 17:07:10'),
(3, 'The Options Trading Course', '<p>Trading Calls &amp; Puts with ease and conviction. Trade Index Options &amp; Stock Options with more then 90% accuracy</p>\r\n\r\n<p><strong>Course Outline</strong></p>\r\n\r\n<p>Understanding step by step behavior of the market &quot;NIFTY &amp; BANK NIFTY&quot; &amp; &quot;STOCK OPTIONS&quot; with 12 Box reference sheet.</p>\r\n\r\n<p>Analyze Prices + time frames views and set up positional trades for calls &amp; puts.</p>\r\n\r\n<p>Analyze index moves for the future 15 days with up to 90% accuracy and take Weekly &amp; Monthly option trades.</p>\r\n\r\n<p>Analyze Stock moves for the future 15 days with up to 90% accuracy and take option trades.</p>\r\n\r\n<p>Setting option combine strategy</p>\r\n\r\n<p><strong>Course Content</strong></p>\r\n\r\n<p>Basic of options &amp; Why option trading?</p>\r\n\r\n<p>What is Derivatives -- Definition of Derivatives</p>\r\n\r\n<p>What does Open Interest mean -- Benefits of monitoring open interest</p>\r\n\r\n<p>Open Interest &ndash;- A confirming indicator -- Rules of open Interest</p>\r\n\r\n<p>What is call &amp; Put? -- What ITM &ndash; ATM &ndash; OTM? How everything is connected</p>\r\n\r\n<p>MM99 - Special Strategies for Option Trading</p>\r\n\r\n<p><strong>Other Option Strategies</strong></p>\r\n\r\n<p>Long Call / Short Call</p>\r\n\r\n<p>Long</p>\r\n\r\n<p>Put / Short Put</p>\r\n\r\n<p>Synthetic</p>\r\n\r\n<p>Long Call</p>\r\n\r\n<p>Covered Call / Long Combo Stock</p>\r\n\r\n<p>Synthetic Long Put / Covered Put</p>\r\n\r\n<p>Option Straddle &ndash; Long Straddle / Short Straddle &ndash; (Sell Straddle)</p>\r\n\r\n<p>Option Strangle (Long Strangle) / Short Strangle (Sell Strangle)</p>\r\n\r\n<p>The collar strategy</p>\r\n\r\n<p>Bull Call spread / Bear Put Spread</p>\r\n\r\n<p>Butterfly Spread / Iron Butterfly</p>\r\n\r\n<p>Condor Options / Iron Condors</p>\r\n\r\n<p>Call Back spread / Put Back spread</p>\r\n\r\n<p>Strap / Strip</p>\r\n\r\n<p>Long Call Ladder / Long Put Ladder</p>\r\n\r\n<p>Call Ratio Spread / Put Ratio Spread</p>\r\n\r\n<p><strong>Forming Broad view of market</strong></p>\r\n\r\n<p>Direction Analysis</p>\r\n\r\n<p>Position Sizing</p>\r\n\r\n<p>Option Strategies &amp; Management</p>\r\n\r\n<p>Guide to Advance option trading</p>\r\n\r\n<p>Word on hedging</p>', '10800', '225', 3, 'N', 'Y', 2, 1, '5,6', '', 11, '1621876105.selection-099-500x500.png', 'selection-099-500x500', 30, NULL, NULL, 1, 0, 'Y', 'N', '2021-05-16 10:03:11', '2021-05-24 17:08:25'),
(4, 'Crypto currency trading program', '<p>Learn the basics of Crypto. A digital or virtual currency that is secured by cryptography. Many Cryptocurrencies are decentralized networks based on blockchain technology.</p>\r\n\r\n<p><strong>Course Outline</strong></p>\r\n\r\n<p>Indepth details and history of Cryptocurrency</p>\r\n\r\n<p>Best Trading techniques for cryptocurrency</p>\r\n\r\n<p>Future of Cryptocurrency</p>\r\n\r\n<p>3 months free access to MM99 software analytics tools</p>\r\n\r\n<p>6 free webinars on advacned trading strategies</p>\r\n\r\n<p><strong>Objective of Price Analysis course</strong></p>\r\n\r\n<p>To make this course applicable to all.</p>\r\n\r\n<p>To equip novice and experienced traders alike, with knowledge of how to follow, recognize, and react to market conditions using our techniques.</p>\r\n\r\n<p>To empower traders to be able to respond to and profit from shorter-term trading as well as long term investing - when appropriate; through our price-analysis technique.</p>\r\n\r\n<p>To teach self-reliance that ensures the endless cycle of trading and growing</p>\r\n\r\n<p>Again, this is not an economic, fundamental, technical, or mechanical approach. It is a behavioral approach using market-generated information prices i.e. High Price, Low Price and Close price.</p>\r\n\r\n<p><strong>Course Content</strong></p>\r\n\r\n<p>Short Introduction to world of cryptocurrency</p>\r\n\r\n<p>Concept of cryptocurrency</p>\r\n\r\n<p>Important of Cryptocurrency</p>\r\n\r\n<p>Cryptocurrency and it types</p>\r\n\r\n<p>How is cryptocurrency formed</p>\r\n\r\n<p>Price Analysis techniques for trading cryptocurrency</p>\r\n\r\n<p>Future of Cryptocurrency</p>', '28900', '575', 4, 'Y', 'N', 2, 1, '7', '', 11, '1621876172.WP_BANK-CYPRTO.jpg', 'WP_BANK-CYPRTO', 10, NULL, NULL, 1, 0, 'Y', 'N', '2021-05-16 10:03:11', '2021-05-24 17:09:32'),
(5, 'Saturn Trading Curriculum (Only for age group 18-25 Age)', '<p>Most Promising trading course for people of age group 18years to 25 years. This course is designed to help beginners with knowledge of how to follow, recognize, and react to market condition.</p>\r\n\r\n<p><strong>Course Outline</strong></p>\r\n\r\n<p>Introductory ideas about stock,commodity and currency market</p>\r\n\r\n<p>Basics of stock market</p>\r\n\r\n<p>Exclusive trading techniques for students</p>\r\n\r\n<p>24 months free access to MM99 software analytics tools</p>\r\n\r\n<p>40 free webinars on advanced trading strategies</p>\r\n\r\n<p><strong>Objective of Price Analysis course</strong></p>\r\n\r\n<p>To make this course available to all students who are at the beginning of the career.</p>\r\n\r\n<p>To equip students with knowledge of how to follow, recognize and react to markets conditions using our techniques.</p>\r\n\r\n<p>To teach self reliance that ensures the endless cycle of trading and growing</p>\r\n\r\n<p>To empower students to take stock market trading as a reliable career</p>\r\n\r\n<p><strong>Who can Participate</strong></p>\r\n\r\n<p>Anyone from the age group of 18 years (completed) to 25 years.</p>\r\n\r\n<p><strong>Specifically our courses are designed for students -</strong></p>\r\n\r\n<p>Interested in making career in stock market</p>\r\n\r\n<p>Interested in self direct investment</p>\r\n\r\n<p>Motivated by curiosity,and desirous of knowledge</p>\r\n\r\n<p>Urge to become self dependent &amp; self reliant</p>\r\n\r\n<p>Willingness to stand different from crowd</p>', '31500', '750', 5, 'N', 'Y', 3, 1, NULL, '', 11, '1621876275.615f48fbb632d5f2a5051842f3033d80.jpg', '615f48fbb632d5f2a5051842f3033d80', 60, NULL, NULL, 1, 0, 'Y', 'N', '2021-05-16 10:03:11', '2021-05-24 17:11:15'),
(6, 'Test For Advisory', '<p>tested here</p>', '31500', '750', 7, 'N', 'Y', 2, 2, NULL, '', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Y', 'N', '2021-05-16 10:03:11', '2021-08-06 17:17:27'),
(8, 'INDEX FUTURE & OPTION', '<ul>\r\n	<li>Nifty &amp; Bank Nifty</li>\r\n	<li>2-3 Call per week with an accuracy of greater than 90%</li>\r\n	<li>Clear entry level, Stoploss level and Target level will be mentioned.</li>\r\n	<li>Updated messages for better trades.</li>\r\n	<li>Telephonic Support.</li>\r\n	<li>All SMS / Whatsapp are sent to your mobile from our sender ID with instant delivery</li>\r\n</ul>', '10850', '225', NULL, 'N', 'N', 1, 2, '4,6', '', 11, '1623173285.shutterstock_555531376-1024x536.jpg', NULL, 90, NULL, NULL, 1, 0, 'Y', 'N', '2021-06-08 17:28:05', '2021-06-08 17:28:05'),
(9, 'Stocks & Equity Future Options', '<p><strong>Features:</strong></p>\r\n\r\n<ul>\r\n	<li>Stock Equity &amp; Stock Future &amp; option</li>\r\n	<li>2 Call per week with an accuracy of greater than 90%</li>\r\n	<li>Clear entry level, Stoploss level and Target level will be mentioned.</li>\r\n	<li>Updated messages for better trades.</li>\r\n	<li>Telephonic Support.</li>\r\n	<li>All SMS are sent to your mobile from our sender ID with instant delivery</li>\r\n	<li>Free MM99 News Letter (Weekly &amp; Monthly)</li>\r\n</ul>', '15550', '215', NULL, 'N', 'N', 1, 2, '2,3,5', '', 11, '1623173637.futureOPtion.png', NULL, 90, NULL, NULL, 1, 0, 'Y', 'N', '2021-06-08 17:33:57', '2021-06-08 17:33:57'),
(10, 'Commodity & Crypto Currency', '<p><strong>Features:</strong></p>\r\n\r\n<ul>\r\n	<li>Gold, Crude, Silver &amp; Currency</li>\r\n	<li>3 Calls per week with an accuracy of greater than 90%</li>\r\n	<li>Clear entry level, Stoploss level and Target level will be mentioned.</li>\r\n	<li>Updated messages for better trades.</li>\r\n	<li>Telephonic Support.</li>\r\n	<li>All SMS are sent to your mobile from our sender ID with instant delivery</li>\r\n</ul>', '15550', '215', NULL, 'N', 'N', 1, 2, '7', '', 1, '1623173794.MW-FZ958_bitcoi_20171211135245_ZQ.jpg', NULL, 90, NULL, NULL, 1, 0, 'Y', 'N', '2021-06-08 17:36:34', '2021-06-08 17:36:34'),
(11, 'World Market - Index & Stocks', '<p><strong>Features:</strong></p>\r\n\r\n<ul>\r\n	<li>Index-Based Country Calls</li>\r\n	<li>3 Call per week&nbsp;</li>\r\n	<li>Country specific Index movement</li>\r\n	<li>Telephonic Support.</li>\r\n	<li>All SMS are sent to your mobile from our sender ID with instant delivery</li>\r\n</ul>', '75950', '1041', NULL, 'N', 'N', 1, 2, '2,3,5,6', '', 11, '1623173994.global_stock_markets.jpg', NULL, 90, NULL, NULL, 1, 0, 'Y', 'N', '2021-06-08 17:39:54', '2021-06-08 17:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `courses_videos`
--

CREATE TABLE `courses_videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `courseid` int(11) DEFAULT NULL,
  `videotype` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'P' COMMENT 'P = Paid, F = Free',
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `videoorder` int(11) DEFAULT NULL,
  `videoname` text COLLATE utf8_bin DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `courses_videos`
--

INSERT INTO `courses_videos` (`id`, `courseid`, `videotype`, `title`, `description`, `videoorder`, `videoname`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'P', 'What is Lorem Ipsum?\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 1, '4060039459872060928.mp4', 1, 0, '2021-06-25 17:04:50', '2021-06-29 18:45:43'),
(2, 1, 'P', 'Why do we use it?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 2, 'stock_market_video.mp4', 1, 0, '2021-06-25 17:04:50', '2021-06-25 17:04:50'),
(3, 1, 'P', 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.', 3, 'big_buck_bunny_720p_1mb.mp4', 1, 0, '2021-06-25 17:06:21', '2021-06-25 17:06:21'),
(4, 1, 'P', 'Where can I get some?', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.', 4, 'pexels-nataliya-vaitkevich-7172612.mp4', 1, 0, '2021-06-25 17:06:21', '2021-06-25 17:06:21'),
(5, 1, 'P', 'The standard Lorem Ipsum passage, used since the 1500s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 5, '1623091032.file_example_MP4_480_1_5MG.mp4', 1, 0, '2021-06-25 17:07:55', '2021-06-25 17:07:55');

-- --------------------------------------------------------

--
-- Table structure for table `dashboardnotification`
--

CREATE TABLE `dashboardnotification` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `notifytype` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'T',
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `notifyvideo` text COLLATE utf8_bin DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `dashboardnotification`
--

INSERT INTO `dashboardnotification` (`id`, `title`, `notifytype`, `description`, `order`, `notifyvideo`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(7, 'Test Notification', 'T', 'tfsdfsdfsdf', NULL, NULL, 1, 0, '2021-06-07 18:17:48', '2021-07-30 11:53:23'),
(8, 'Test Notification video', 'V', NULL, NULL, '1623089998.file_example_MP4_480_1_5MG.mp4', 1, 0, '2021-06-07 18:19:58', '2021-07-30 11:53:23'),
(9, 'Test Notification', 'T', NULL, NULL, '1623090020.Sample MP4 Video File for Testing.mp4', 1, 0, '2021-06-07 18:20:36', '2021-07-30 11:53:24'),
(10, 'Webinar session', 'V', 'This is the test webinar video, which can be upload from the admin panel. Visibility can be also manage from admin panel.', NULL, '4060039459872060928.mp4', 1, 0, '2021-06-07 18:37:13', '2021-07-18 18:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `mail_to` varchar(100) DEFAULT NULL,
  `mail_to_name` varchar(55) DEFAULT NULL,
  `mail_body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `subject`, `mail_to`, `mail_to_name`, `mail_body`, `created_at`, `updated_at`) VALUES
(1, 'One Time Password', 'adee.test.email@gmail.com', 'Adarsh', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n    <head>\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n        <title>Base Project</title>\n        <style type=\"text/css\">\n            body {}\n\n            table {\n                border-collapse: collapse\n            }\n\n            table td {\n                border-collapse: collapse\n            }\n\n            img {\n                border: none\n            }\n\n            a {\n                text-decoration: none;\n                color: #000;\n            }\n        </style>\n    </head>\n\n    <body style=\"padding:15px;\">\n        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n            <tr>\n                <td valign=\"top\">\n                    <table width=\"600\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Arial, Helvetica, sans-serif\">\n                        <tr>\n                            <td>&nbsp;</td>\n                        </tr>\n                        <tr>\n                            <td valign=\"middle\">\n							\n							<a href=\"http://localhost/blue_inn/public\" target=\"_blank\" title=\"Base Project\"><h3>Base Project</h3></a>\n                            </td>\n                        </tr>\n                        <tr>\n                            <td style=\"border-bottom:1px solid #ccc;\">&nbsp;</td>\n                        </tr>\n						\n						<tr>\n							<td align=\"center\" valign=\"top\" bgcolor=\"#fff\" style=\"padding:20px 0;\">\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n									<tbody>\n									\n							<tr>\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#000000;\">Dear Adarsh,</td>\n	</tr>\n	 <tr>\n		<td style=\"line-height:15px;\">&nbsp;</td>\n	</tr>\n	<tr>\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">You are receiving this email because we received a One Time Password request for your account.</td>\n	</tr>\n	<tr>\n		<td style=\"line-height:15px;\">&nbsp;</td>\n	</tr>\n	<tr>\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">Your One Time Password is: 632680</td>\n	</tr>\n	<tr>\n		<td style=\"line-height:15px;\">&nbsp;</td>\n	</tr>\n	<tr>\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">If you did not request a One Time Password, no further action is required.</td>\n	</tr>\n						\n										<tr>\n											<td height=\"30\" align=\"left\" valign=\"middle\">&nbsp;</td>\n										</tr>\n										<tr>\n											<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:18px; font-weight:600; color:#000000;\">Best Regards,</td>\n										</tr>\n										<tr>\n											<td align=\"left\" valign=\"middle\"><a href=\"http://localhost/blue_inn/public\" target=\"_blank\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:16px; font-weight:400; color:#000;  text-decoration:none;\">Base Project</a></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n						\n						<tr>\n                            <td align=\"center\" valign=\"top\" style=\"border-top:1px solid #ccc;\">\n                                <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n                                    <tr>\n                                        <td style=\"line-height:15px;\">&nbsp;</td>\n                                    </tr>\n                                    <tr>\n                                        <td valign=\"middle\">\n																						<a href=\"https://www.facebook.com/\" target=\"_blank\"><img src=\"http://localhost/blue_inn/public/images/facebook.png\" alt=\"Facebook\" width=\"32\" height=\"32\" title=\"Facebook\"></a>\n																						\n																						<a href=\"https://www.instagram.com/\" target=\"_blank\"><img src=\"http://localhost/blue_inn/public/images/instagram.png\" alt=\"Instagram\" width=\"32\" height=\"32\" title=\"Instagram\"></a>\n																						\n																						<a href=\"https://www.twitter.com/\" target=\"_blank\"><img src=\"http://localhost/blue_inn/public/images/twitter.png\" alt=\"Twitter\" width=\"32\" height=\"32\" title=\"Twitter\"></a>\n																						\n											                                        </td>\n                                    </tr>\n                                    <tr>\n                                        <td align=\"center\" valign=\"top\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px; ; line-height:16px;\">&nbsp;</td>\n                                    </tr>\n                                    <tr>\n                                        <td align=\"left\" valign=\"top\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px; ; line-height:16px;\">Copyrights &copy; 2020 Base Project, All Rights Reserved.</td>\n                                    </tr>\n                                </table>\n                            </td>\n                        </tr>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', '2020-04-11 09:22:21', '2020-04-11 09:22:21'),
(2, 'New Registration Enquiry Received', 'snehal@jeelinfotech.com', 'Snehal', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n    <head>\r\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n        <title>Clothes</title>\r\n        <style type=\"text/css\">\r\n            body {}\r\n\r\n            table {\r\n                border-collapse: collapse\r\n            }\r\n\r\n            table td {\r\n                border-collapse: collapse\r\n            }\r\n\r\n            img {\r\n                border: none\r\n            }\r\n\r\n            a {\r\n                text-decoration: none;\r\n                color: #000;\r\n            }\r\n        </style>\r\n    </head>\r\n\r\n    <body style=\"padding:15px;\">\r\n        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n            <tr>\r\n                <td valign=\"top\">\r\n                    <table width=\"600\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: Arial, Helvetica, sans-serif\">\r\n                        <tr>\r\n                            <td>&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td valign=\"middle\">\r\n							\r\n							<a href=\"http://clothapp.jeelinfotech.com/public\" target=\"_blank\" title=\"Clothes\"><h3>Clothes</h3></a>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"border-bottom:1px solid #ccc;\">&nbsp;</td>\r\n                        </tr>\r\n						\r\n						<tr>\r\n							<td align=\"center\" valign=\"top\" bgcolor=\"#fff\" style=\"padding:20px 0;\">\r\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n									<tbody>\r\n									\r\n							<tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#000000;\">Dear Snehal,</td>\r\n	</tr>\r\n	 <tr>\r\n		<td style=\"line-height:15px;\">&nbsp;</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">A new person has registration, below are the details of that person</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"line-height:15px;\">&nbsp;</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">Name: Snehal</td>\r\n	</tr>\r\n        <tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">Email: <a href=\"mailto:snehal@jeelinfotech.com\">snehal@jeelinfotech.com</a></td>\r\n	</tr>\r\n         <tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">Password: $2y$10$n8QYHsTkhRxTHCJh49HAb.HmFQhud0dN3xpN0V7CodWTl/vmqy8NO</td>\r\n	</tr>\r\n        <tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">Phone: <a href=\"tel:7567997033\">7567997033</a></td>\r\n	</tr>\r\n        <tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">Type: User</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"line-height:15px;\">&nbsp;</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; \">If you did not request a One Time Password, no further action is required.</td>\r\n	</tr>\r\n						\r\n										<tr>\r\n											<td height=\"30\" align=\"left\" valign=\"middle\">&nbsp;</td>\r\n										</tr>\r\n										<tr>\r\n											<td align=\"left\" valign=\"middle\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:18px; font-weight:600; color:#000000;\">Best Regards,</td>\r\n										</tr>\r\n										<tr>\r\n											<td align=\"left\" valign=\"middle\"><a href=\"http://clothapp.jeelinfotech.com/public\" target=\"_blank\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:16px; font-weight:400; color:#000;  text-decoration:none;\">Clothes</a></td>\r\n										</tr>\r\n									</tbody>\r\n								</table>\r\n							</td>\r\n						</tr>\r\n						\r\n						<tr>\r\n                            <td align=\"center\" valign=\"top\" style=\"border-top:1px solid #ccc;\">\r\n                                <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                                    <tr>\r\n                                        <td style=\"line-height:15px;\">&nbsp;</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td valign=\"middle\">\r\n																						<a href=\"https://www.facebook.com/\" target=\"_blank\"><img src=\"http://clothapp.jeelinfotech.com/public/images/facebook.png\" alt=\"Facebook\" width=\"32\" height=\"32\" title=\"Facebook\"></a>\r\n																						\r\n																						<a href=\"https://www.instagram.com/\" target=\"_blank\"><img src=\"http://clothapp.jeelinfotech.com/public/images/instagram.png\" alt=\"Instagram\" width=\"32\" height=\"32\" title=\"Instagram\"></a>\r\n																						\r\n																						<a href=\"https://www.twitter.com/\" target=\"_blank\"><img src=\"http://clothapp.jeelinfotech.com/public/images/twitter.png\" alt=\"Twitter\" width=\"32\" height=\"32\" title=\"Twitter\"></a>\r\n																						\r\n											                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td align=\"center\" valign=\"top\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px; ; line-height:16px;\">&nbsp;</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td align=\"left\" valign=\"top\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px; ; line-height:16px;\">Copyrights &copy; 2021 Clothes, All Rights Reserved.</td>\r\n                                    </tr>\r\n                                </table>\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </body>\r\n</html>', '2021-04-03 16:10:44', '2021-04-03 16:10:44'),
(3, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>The Dynamic Access Code is : <b>2843</b><br/>\n                    Please Note:\n                    Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                    Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                    IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-05-18 02:31:41', '2021-05-18 02:31:41'),
(4, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>The Dynamic Access Code is : <b>4493</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-05-31 09:55:11', '2021-05-31 09:55:11'),
(5, NULL, NULL, NULL, 'Hi <strong>Rohan</strong>,\n<p>The Dynamic Access Code is : <b>6284</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-05-31 09:55:30', '2021-05-31 09:55:30'),
(6, NULL, NULL, NULL, 'Hi <strong>Vivek</strong>,\n<p>The Dynamic Access Code is : <b>3436</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-06-16 04:45:56', '2021-06-16 04:45:56'),
(7, NULL, NULL, NULL, 'Hi <strong>Vivek</strong>,\n<p>The Dynamic Access Code is : <b>7111</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-06-16 04:51:41', '2021-06-16 04:51:41'),
(8, NULL, NULL, NULL, 'Hi <strong>Kaustubh Shinde</strong>,\n<p>The Dynamic Access Code is : <b>2506</b><br/>\n							Please Note:\n							Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n							Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n							IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-06-29 06:06:40', '2021-06-29 06:06:40'),
(9, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>Your Payment completed\n					<b>Course Name:</b> Basic Price Analysis Course <br/>\n					<b>Amount:</b> 18900 <br/>\n					<b>Order ID:</b> order_HSxTJdjuM95W0S <br/>\n					<b>Package Start Date:</b> 2021-06-29 17:47:27 <br/>\n					<b>Package End Date:</b> 2021-07-29 17:47:27 <br/></p>', '2021-06-29 17:47:29', '2021-06-29 17:47:29'),
(10, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Course Name:</b> Basic Price Analysis Course <br/>\n					<b>Amount:</b> 18900 <br/>\n					<b>Order ID:</b> order_HSxTJdjuM95W0S <br/>\n					<b>Package Start Date:</b> 2021-06-29 17:55:38 <br/>\n					<b>Package End Date:</b> 2021-07-29 17:55:38 <br/></p>', '2021-06-29 17:55:39', '2021-06-29 17:55:39'),
(11, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Course Name:</b> Basic Price Analysis Course <br/>\n					<b>Amount:</b> 18900 <br/>\n					<b>Order ID:</b> order_HSxTJdjuM95W0S <br/>\n					<b>Package Start Date:</b> 2021-06-29 17:59:30 <br/>\n					<b>Package End Date:</b> 2021-07-29 17:59:30 <br/></p>', '2021-06-29 17:59:31', '2021-06-29 17:59:31'),
(12, NULL, NULL, NULL, 'Hi <strong>Kandarp</strong>,\n<p>The Dynamic Access Code is : <b>7206</b><br/>\n							Please Note:\n							Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n							Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n							IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-07-07 06:47:21', '2021-07-07 06:47:21'),
(13, NULL, NULL, NULL, 'Hi <strong>Shailendra</strong>,\n<p>The Dynamic Access Code is : <b>3487</b><br/>\n							Please Note:\n							Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n							Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n							IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-07-22 07:31:34', '2021-07-22 07:31:34'),
(14, NULL, NULL, NULL, 'Hi <strong>Saloni</strong>,\n<p>The Dynamic Access Code is : <b>6618</b><br/>\n							Please Note:\n							Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n							Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n							IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-07-22 07:42:59', '2021-07-22 07:42:59'),
(15, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> Test For Advisory <br/>						\n						<b>Order ID:</b> order_trial_0408202118011 <br/>\n						<b>Package Start Date:</b> 2021-08-04 18:19:11 <br/>\n						<b>Package End Date:</b> 2021-08-11 18:19:11 <br/></p>', '2021-08-04 18:19:14', '2021-08-04 18:19:14'),
(16, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> Test For Advisory <br/>						\n						<b>Order ID:</b> order_trial_0508202120037 <br/>\n						<b>Package Start Date:</b> 2021-08-05 20:02:37 <br/>\n						<b>Package End Date:</b> 2021-08-12 20:02:37 <br/></p>', '2021-08-05 20:02:39', '2021-08-05 20:02:39'),
(17, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> INDEX FUTURE & OPTION <br/>						\n						<b>Order ID:</b> order_trial_0608202118034 <br/>\n						<b>Package Start Date:</b> 2021-08-06 18:20:34 <br/>\n						<b>Package End Date:</b> 2021-08-13 18:20:34 <br/></p>', '2021-08-06 18:20:36', '2021-08-06 18:20:36'),
(18, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_HiiBVJrzkoqE0Y <br/><br/><br/><b>Course Name:</b> Basic Price Analysis Course <br/>\n						<b>Amount:</b> 18900 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 12:58:08 <br/>\n						<b>Package End Date:</b> 2021-09-07 12:58:08 <br/><br/></p>', '2021-08-08 12:58:11', '2021-08-08 12:58:11'),
(19, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_HikVfZkixmnJGI <br/><br/><br/><b>Course Name:</b> INDEX FUTURE & OPTION <br/>\n						<b>Amount:</b> 8680 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 15:14:00 <br/>\n						<b>Package End Date:</b> 2021-11-06 15:14:00 <br/><br/><b>Course Name:</b> Stocks & Equity Future Options <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 15:14:00 <br/>\n						<b>Package End Date:</b> 2021-11-06 15:14:00 <br/><br/></p>', '2021-08-08 15:14:02', '2021-08-08 15:14:02'),
(20, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_HilOxAZYRkGHR0 <br/><br/><br/><b>Course Name:</b> Commodity & Crypto Currency <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:07:04 <br/>\n						<b>Package End Date:</b> 2021-11-06 16:07:04 <br/><br/><b>Course Name:</b> World Market - Index & Stocks <br/>\n						<b>Amount:</b> 60760 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:07:04 <br/>\n						<b>Package End Date:</b> 2021-11-06 16:07:04 <br/><br/><b>Course Name:</b> Index Master Trader Program <br/>\n						<b>Amount:</b> 28640 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:07:04 <br/>\n						<b>Package End Date:</b> 2021-09-07 16:07:04 <br/><br/><b>Course Name:</b> The Options Trading Course <br/>\n						<b>Amount:</b> 8640 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:07:04 <br/>\n						<b>Package End Date:</b> 2021-09-07 16:07:04 <br/><br/><b>Course Name:</b> Crypto currency trading program <br/>\n						<b>Amount:</b> 23120 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:07:04 <br/>\n						<b>Package End Date:</b> 2021-08-18 16:07:04 <br/><br/><b>Course Name:</b> Saturn Trading Curriculum (Only for age group 18-25 Age) <br/>\n						<b>Amount:</b> 25200 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:07:04 <br/>\n						<b>Package End Date:</b> 2021-10-07 16:07:04 <br/><br/></p>', '2021-08-08 16:07:06', '2021-08-08 16:07:06'),
(21, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> INDEX FUTURE & OPTION <br/>						\n						<b>Order ID:</b> order_trial_0808202116035 <br/>\n						<b>Package Start Date:</b> 2021-08-08 16:41:35 <br/>\n						<b>Package End Date:</b> 2021-08-15 16:41:35 <br/></p>', '2021-08-08 16:41:36', '2021-08-08 16:41:36'),
(22, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_Him1DmW1XEJqzV <br/><br/><br/><b>Course Name:</b> Commodity & Crypto Currency <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:42:35 <br/>\n						<b>Package End Date:</b> 2021-11-06 16:42:35 <br/><br/><b>Course Name:</b> Stocks & Equity Future Options <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:42:35 <br/>\n						<b>Package End Date:</b> 2021-11-06 16:42:35 <br/><br/></p>', '2021-08-08 16:42:36', '2021-08-08 16:42:36'),
(23, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_Him5SnxfPvLgHD <br/><br/><br/><b>Course Name:</b> Basic Price Analysis Course <br/>\n						<b>Amount:</b> 18900 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:46:38 <br/>\n						<b>Package End Date:</b> 2021-09-07 16:46:38 <br/><br/></p>', '2021-08-08 16:46:39', '2021-08-08 16:46:39'),
(24, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_Him6RDfD7xVYRX <br/><br/><br/><b>Course Name:</b> Index Master Trader Program <br/>\n						<b>Amount:</b> 28640 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:47:28 <br/>\n						<b>Package End Date:</b> 2021-09-07 16:47:28 <br/><br/><b>Course Name:</b> World Market - Index & Stocks <br/>\n						<b>Amount:</b> 60760 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 16:47:28 <br/>\n						<b>Package End Date:</b> 2021-11-06 16:47:28 <br/><br/></p>', '2021-08-08 16:47:29', '2021-08-08 16:47:29'),
(25, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_HimT8DgkyegAG8 <br/><br/><br/><b>Course Name:</b> Commodity & Crypto Currency <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 17:10:03 <br/>\n						<b>Package End Date:</b> 2021-11-06 17:10:03 <br/><br/><b>Course Name:</b> Stocks & Equity Future Options <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 17:10:03 <br/>\n						<b>Package End Date:</b> 2021-11-06 17:10:03 <br/><br/><b>Course Name:</b> INDEX FUTURE & OPTION <br/>\n						<b>Amount:</b> 8680 <br/>					\n						<b>Package Start Date:</b> 2021-08-08 17:10:03 <br/>\n						<b>Package End Date:</b> 2021-11-06 17:10:03 <br/><br/></p>', '2021-08-08 17:10:04', '2021-08-08 17:10:04'),
(26, NULL, NULL, NULL, 'Hi <strong>Ketan Patel</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> World Market - Index & Stocks <br/>						\n						<b>Order ID:</b> order_trial_0808202117021 <br/>\n						<b>Package Start Date:</b> 2021-08-08 17:12:21 <br/>\n						<b>Package End Date:</b> 2021-08-15 17:12:21 <br/></p>', '2021-08-08 17:12:22', '2021-08-08 17:12:22'),
(27, NULL, NULL, NULL, 'Hi <strong>Rohan</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> INDEX FUTURE & OPTION <br/>						\n						<b>Order ID:</b> order_trial_0808202117032 <br/>\n						<b>Package Start Date:</b> 2021-08-08 17:34:32 <br/>\n						<b>Package End Date:</b> 2021-08-15 17:34:32 <br/></p>', '2021-08-08 17:34:34', '2021-08-08 17:34:34'),
(28, NULL, NULL, NULL, 'Hi <strong>Kaushal</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n					<b>Transaction Details</b><br/><br/><br/>\n					<b>Order ID:</b> order_Hl3Nn4QSbtpkJE <br/><br/><br/><b>Course Name:</b> INDEX FUTURE & OPTION <br/>\n						<b>Amount:</b> 8680 <br/>					\n						<b>Package Start Date:</b> 2021-08-14 10:59:49 <br/>\n						<b>Package End Date:</b> 2021-11-12 10:59:49 <br/><br/><b>Course Name:</b> Stocks & Equity Future Options <br/>\n						<b>Amount:</b> 12440 <br/>					\n						<b>Package Start Date:</b> 2021-08-14 10:59:49 <br/>\n						<b>Package End Date:</b> 2021-11-12 10:59:49 <br/><br/></p>', '2021-08-14 10:59:51', '2021-08-14 10:59:51'),
(29, NULL, NULL, NULL, 'Hi <strong>Shailendra</strong>,\n<p>The Dynamic Access Code is : <b>2690</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-08-21 07:06:40', '2021-08-21 07:06:40'),
(30, NULL, NULL, NULL, 'Hi <strong>Shailendra</strong>,\n<p>The Dynamic Access Code is : <b>5164</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-08-21 07:08:18', '2021-08-21 07:08:18'),
(31, NULL, NULL, NULL, 'Hi <strong>Shailendra</strong>,\n<p>The Dynamic Access Code is : <b>4383</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-08-21 07:09:55', '2021-08-21 07:09:55'),
(32, NULL, NULL, NULL, 'Hi <strong>Shailendra</strong>,\n<p>Thank you for using Market Mantra99. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					\n						<b>Trial Course Transaction Details</b><br/><br/><br/>\n						<b>Course Name:</b> World Market - Index & Stocks <br/>						\n						<b>Order ID:</b> order_trial_2108202107012 <br/>\n						<b>Package Start Date:</b> 2021-08-21 07:12:12 <br/>\n						<b>Package End Date:</b> 2021-08-28 07:12:12 <br/></p>', '2021-08-21 07:12:14', '2021-08-21 07:12:14'),
(33, NULL, NULL, NULL, 'Hi <strong>Vivek</strong>,\n<p>The Dynamic Access Code is : <b>1281</b><br/>\n                Please Note:\n                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>\n                Market Mantra99 will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>\n                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number</p>', '2021-08-21 09:16:40', '2021-08-21 09:16:40');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_users_details`
--

CREATE TABLE `front_users_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `website_link` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Men', 1, '2021-04-02 11:41:03', '2021-04-02 16:41:03'),
(2, 'Advisory uuu', 1, '2021-05-09 14:38:23', '2021-05-09 14:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `name_slug` varchar(155) NOT NULL,
  `value` varchar(155) NOT NULL,
  `setting_group` varchar(155) NOT NULL,
  `is_required` int(1) NOT NULL DEFAULT 1,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `name`, `name_slug`, `value`, `setting_group`, `is_required`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Site Name', 'SITE_NAME', 'Market mantra 99', 'General', 1, 1, '2020-01-11 11:32:12', '2020-12-08 12:20:32'),
(2, 'Site Logo', 'SITE_LOGO', '1', 'General', 1, 0, '2020-01-11 11:43:10', NULL),
(3, 'Contact Number', 'CONTACT_NO', '1234567890', 'Information', 1, 1, '2020-01-11 11:32:12', NULL),
(4, 'Contact Email', 'CONTACT_EMAIL', 'admin@gmail.com', 'Information', 1, 1, '2020-01-11 11:32:12', NULL),
(5, 'Contact Address', 'CONTACT_ADDRESS', 'Ahmedabad', 'Information', 1, 1, '2020-01-11 11:32:12', NULL),
(6, 'Mail Driver', 'MAIL_DRIVER', 'SMTP', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-17 09:14:23'),
(7, 'Mail Host', 'MAIL_HOST', 'smtp.googlemail.com', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(8, 'Mail Port', 'MAIL_PORT', '465', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(9, 'Mail Username', 'MAIL_USERNAME', 'mmantra99@gmail.com', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(10, 'Mail Password', 'MAIL_PASSWORD', 'Moneymantra@99', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(11, 'Mail Encryption', 'MAIL_ENCRYPTION', 'ssl', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(12, 'Mail From Name', 'MAIL_FROM', 'Moneymantra', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(13, 'Mail From Email', 'MAIL_FROM_EMAIL', 'mmantra99@gmail.com', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(14, 'Reply To Email', 'MAIL_REPLY_TO_EMAIL', 'mmantra99@gmail.com', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(15, 'Contact Us Inquiry Email', 'CONTACT_INQUIRY_EMAIL', 'mmantra99@gmail.com', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(16, 'Newsletter Subscription Email', 'NEWSLETTER_SUBSCRIPTION_EMAIL', 'mmantra99@gmail.com', 'Mail', 1, 1, '2020-01-11 11:32:12', '2021-05-18 02:31:20'),
(17, 'Facebook Link', 'SOCIAL_FACEBOOK_LINK', 'https://www.facebook.com/', 'Social', 1, 1, '2020-01-11 11:32:12', '2020-04-10 13:25:31'),
(18, 'Instagram Link', 'SOCIAL_INSTAGRAM_LINK', 'https://www.instagram.com/', 'Social', 1, 1, '2020-01-11 11:32:12', '2020-04-10 13:25:31'),
(19, 'Twitter Link', 'SOCIAL_TWITTER_LINK', 'https://www.twitter.com/', 'Social', 1, 1, '2020-01-11 11:32:12', '2020-04-10 13:25:31'),
(20, 'Timezone', 'TIMEZONE', 'Asia/Kolkata', 'General', 1, 1, '2020-01-11 12:03:12', '2020-01-11 06:57:24'),
(21, 'Training / Advisory Course Discount(%)', 'COURSE_DISCOUNT', '20', 'General', 1, 1, '2020-01-11 03:43:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` varchar(155) NOT NULL,
  `directory` varchar(255) NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `name`, `module`, `directory`, `is_admin`, `created_at`, `updated_at`) VALUES
(3, '2018-12-121544621501NE_1579342191_20200118_2.jpg', 'user_profile', 'user_profile', 1, '2020-01-18 10:09:51', '2020-01-18 10:09:51'),
(4, '2018-12-121544621501NE_1579342406_20200118_3.jpg', 'user_profile', 'user_profile', 1, '2020-01-18 10:13:26', '2020-01-18 10:13:26'),
(5, '2018-12-121544621501NE_1579342588_20200118_4.jpg', 'user_profile', 'user_profile', 1, '2020-01-18 10:16:28', '2020-01-18 10:16:28'),
(9, '2018-12-111544547292HT_1579343044_20200118_8.jpg', 'user_profile', 'user_profile', 1, '2020-01-18 10:24:04', '2020-01-18 10:24:04'),
(14, 'cat2019_08_31_06_28_14_1579343427_20200118_13.png', 'user_profile', 'user_profile', 1, '2020-01-18 10:30:27', '2020-01-18 10:30:27'),
(15, 'cat2019_08_31_06_26_50_1585405038_20200328_14.png', 'user_profile', 'user_profile', 1, '2020-03-28 14:17:18', '2020-03-28 14:17:18'),
(16, 'cat2019_08_31_06_28_14_1585410409_20200328_15.png', 'user_profile', 'user_profile', 1, '2020-03-28 15:46:49', '2020-03-28 15:46:49'),
(17, 'cat2019_08_31_06_27_32_1586267195_20200407_16.png', 'user_profile', 'user_profile', 1, '2020-04-07 08:16:35', '2020-04-07 08:16:35'),
(18, 'the-test-fun-for-friends-screenshot_1607836519_20201213_17.png', 'user_profile', 'user_profile', 1, '2020-12-12 23:45:19', '2020-12-12 23:45:19'),
(19, 'original_100000025_large_1608564436_20201221_18.jpg', 'user_profile', 'user_profile', 1, '2020-12-22 04:57:16', '2020-12-22 04:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` char(49) CHARACTER SET utf8 DEFAULT NULL,
  `isparent` int(11) NOT NULL DEFAULT 0,
  `shortcode` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `chrindianlanguage` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `intdefaultorder` int(11) DEFAULT NULL,
  `intindialanorder` int(11) DEFAULT NULL,
  `chractive` char(2) COLLATE utf8_bin DEFAULT 'Y',
  `chrdelete` char(2) COLLATE utf8_bin DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `isparent`, `shortcode`, `chrindianlanguage`, `intdefaultorder`, `intindialanorder`, `chractive`, `chrdelete`) VALUES
(1, 'English', 0, 'en', 'Y', 1, 1, 'Y', 'N'),
(2, 'Afar', 0, 'aa', 'N', NULL, NULL, 'N', 'N'),
(3, 'Abkhazian', 0, 'ab', 'N', NULL, NULL, 'N', 'N'),
(4, 'Afrikaans', 0, 'af', 'N', NULL, NULL, 'N', 'N'),
(5, 'Amharic', 0, 'am', 'N', NULL, NULL, 'N', 'N'),
(6, 'Arabic', 0, 'ar', 'N', 2, NULL, 'Y', 'N'),
(7, 'Assamese', 0, 'as', 'N', NULL, NULL, 'N', 'N'),
(8, 'Aymara', 0, 'ay', 'N', NULL, NULL, 'N', 'N'),
(9, 'Azerbaijani', 0, 'az', 'N', NULL, NULL, 'N', 'N'),
(10, 'Bashkir', 0, 'ba', 'N', NULL, NULL, 'N', 'N'),
(11, 'Belarusian', 0, 'be', 'N', NULL, NULL, 'N', 'N'),
(12, 'Bulgarian', 0, 'bg', 'N', NULL, NULL, 'N', 'N'),
(13, 'Bihari', 0, 'bh', 'N', NULL, NULL, 'N', 'N'),
(14, 'Bislama', 0, 'bi', 'N', NULL, NULL, 'N', 'N'),
(15, 'Bengali/Bangla', 0, 'bn', 'Y', NULL, 5, 'N', 'N'),
(16, 'Tibetan', 0, 'bo', 'N', NULL, NULL, 'N', 'N'),
(17, 'Breton', 0, 'br', 'N', NULL, NULL, 'N', 'N'),
(18, 'Catalan', 0, 'ca', 'N', NULL, NULL, 'N', 'N'),
(19, 'Corsican', 0, 'co', 'N', NULL, NULL, 'N', 'N'),
(20, 'Czech', 0, 'cs', 'N', NULL, NULL, 'N', 'N'),
(21, 'Welsh', 0, 'cy', 'N', NULL, NULL, 'N', 'N'),
(22, 'Danish', 0, 'da', 'N', NULL, NULL, 'N', 'N'),
(23, 'German', 0, 'de', 'N', 3, NULL, 'Y', 'N'),
(24, 'Bhutani', 0, 'dz', 'N', NULL, NULL, 'N', 'N'),
(25, 'Greek', 0, 'el', 'N', NULL, NULL, 'N', 'N'),
(26, 'Esperanto', 0, 'eo', 'N', NULL, NULL, 'N', 'N'),
(27, 'Spanish', 0, 'es', 'N', 4, NULL, 'Y', 'N'),
(28, 'Estonian', 0, 'et', 'N', NULL, NULL, 'N', 'N'),
(29, 'Basque', 0, 'eu', 'N', NULL, NULL, 'N', 'N'),
(30, 'Persian', 0, 'fa', 'N', NULL, NULL, 'N', 'N'),
(31, 'Finnish', 0, 'fi', 'N', NULL, NULL, 'N', 'N'),
(32, 'Fiji', 0, 'fj', 'N', NULL, NULL, 'N', 'N'),
(33, 'Faeroese', 0, 'fo', 'N', NULL, NULL, 'N', 'N'),
(34, 'French', 0, 'fr', 'N', 5, NULL, 'Y', 'N'),
(35, 'Frisian', 0, 'fy', 'N', NULL, NULL, 'N', 'N'),
(36, 'Irish', 0, 'ga', 'N', NULL, NULL, 'N', 'N'),
(37, 'Scots/Gaelic', 0, 'gd', 'N', NULL, NULL, 'N', 'N'),
(38, 'Galician', 0, 'gl', 'N', NULL, NULL, 'N', 'N'),
(39, 'Guarani', 0, 'gn', 'N', NULL, NULL, 'N', 'N'),
(40, 'Gujarati', 0, 'gu', 'Y', NULL, 4, 'N', 'N'),
(41, 'Hausa', 0, 'ha', 'N', NULL, NULL, 'N', 'N'),
(42, 'Hindi', 0, 'hi', 'Y', NULL, 2, 'N', 'N'),
(43, 'Croatian', 0, 'hr', 'N', NULL, NULL, 'N', 'N'),
(44, 'Hungarian', 0, 'hu', 'N', NULL, NULL, 'N', 'N'),
(45, 'Armenian', 0, 'hy', 'N', NULL, NULL, 'N', 'N'),
(46, 'Interlingua', 0, 'ia', 'N', NULL, NULL, 'N', 'N'),
(47, 'Interlingue', 0, 'ie', 'N', NULL, NULL, 'N', 'N'),
(48, 'Inupiak', 0, 'ik', 'N', NULL, NULL, 'N', 'N'),
(49, 'Indonesian', 0, 'in', 'N', NULL, NULL, 'N', 'N'),
(50, 'Icelandic', 0, 'is', 'N', NULL, NULL, 'N', 'N'),
(51, 'Italian', 0, 'it', 'N', NULL, NULL, 'N', 'N'),
(52, 'Hebrew', 0, 'iw', 'N', NULL, NULL, 'N', 'N'),
(53, 'Japanese', 0, 'ja', 'N', 6, NULL, 'Y', 'N'),
(54, 'Yiddish', 0, 'ji', 'N', NULL, NULL, 'N', 'N'),
(55, 'Javanese', 0, 'jw', 'N', NULL, NULL, 'N', 'N'),
(56, 'Georgian', 0, 'ka', 'N', NULL, NULL, 'N', 'N'),
(57, 'Kazakh', 0, 'kk', 'N', NULL, NULL, 'N', 'N'),
(58, 'Greenlandic', 0, 'kl', 'N', NULL, NULL, 'N', 'N'),
(59, 'Cambodian', 0, 'km', 'N', NULL, NULL, 'N', 'N'),
(60, 'Kannada', 0, 'kn', 'Y', NULL, 8, 'N', 'N'),
(61, 'Korean', 0, 'ko', 'N', NULL, NULL, 'N', 'N'),
(62, 'Kashmiri', 0, 'ks', 'N', NULL, NULL, 'N', 'N'),
(63, 'Kurdish', 0, 'ku', 'N', NULL, NULL, 'N', 'N'),
(64, 'Kirghiz', 0, 'ky', 'N', NULL, NULL, 'N', 'N'),
(65, 'Latin', 0, 'la', 'N', NULL, NULL, 'N', 'N'),
(66, 'Lingala', 0, 'ln', 'N', NULL, NULL, 'N', 'N'),
(67, 'Laothian', 0, 'lo', 'N', NULL, NULL, 'N', 'N'),
(68, 'Lithuanian', 0, 'lt', 'N', NULL, NULL, 'N', 'N'),
(69, 'Latvian/Lettish', 0, 'lv', 'N', NULL, NULL, 'N', 'N'),
(70, 'Malagasy', 0, 'mg', 'N', NULL, NULL, 'N', 'N'),
(71, 'Maori', 0, 'mi', 'N', NULL, NULL, 'N', 'N'),
(72, 'Macedonian', 0, 'mk', 'N', NULL, NULL, 'N', 'N'),
(73, 'Malayalam', 0, 'ml', 'N', NULL, NULL, 'N', 'N'),
(74, 'Mongolian', 0, 'mn', 'N', NULL, NULL, 'N', 'N'),
(75, 'Moldavian', 0, 'mo', 'N', NULL, NULL, 'N', 'N'),
(76, 'Marathi', 0, 'mr', 'Y', NULL, 3, 'N', 'N'),
(77, 'Malay', 0, 'ms', 'N', NULL, NULL, 'N', 'N'),
(78, 'Maltese', 0, 'mt', 'N', NULL, NULL, 'N', 'N'),
(79, 'Burmese', 0, 'my', 'N', NULL, NULL, 'N', 'N'),
(80, 'Nauru', 0, 'na', 'N', NULL, NULL, 'N', 'N'),
(81, 'Nepali', 0, 'ne', 'N', NULL, NULL, 'N', 'N'),
(82, 'Dutch', 0, 'nl', 'N', NULL, NULL, 'N', 'N'),
(83, 'Norwegian', 0, 'no', 'N', NULL, NULL, 'N', 'N'),
(84, 'Occitan', 0, 'oc', 'N', NULL, NULL, 'N', 'N'),
(85, '(Afan)/Oromoor/Oriya', 0, 'om', 'N', NULL, NULL, 'N', 'N'),
(86, 'Punjabi', 0, 'pa', 'Y', NULL, 9, 'N', 'N'),
(87, 'Polish', 0, 'pl', 'N', NULL, NULL, 'N', 'N'),
(88, 'Pashto/Pushto', 0, 'ps', 'N', NULL, NULL, 'N', 'N'),
(89, 'Portuguese', 0, 'pt', 'N', 7, NULL, 'Y', 'N'),
(90, 'Quechua', 0, 'qu', 'N', NULL, NULL, 'N', 'N'),
(91, 'Rhaeto-Romance', 0, 'rm', 'N', NULL, NULL, 'N', 'N'),
(92, 'Kirundi', 0, 'rn', 'N', NULL, NULL, 'N', 'N'),
(93, 'Romanian', 0, 'ro', 'N', NULL, NULL, 'N', 'N'),
(94, 'Russian', 0, 'ru', 'N', 8, NULL, 'Y', 'N'),
(95, 'Kinyarwanda', 0, 'rw', 'N', NULL, NULL, 'N', 'N'),
(96, 'Sanskrit', 0, 'sa', 'N', NULL, NULL, 'N', 'N'),
(97, 'Sindhi', 0, 'sd', 'N', NULL, NULL, 'N', 'N'),
(98, 'Sangro', 0, 'sg', 'N', NULL, NULL, 'N', 'N'),
(99, 'Serbo-Croatian', 0, 'sh', 'N', NULL, NULL, 'N', 'N'),
(100, 'Singhalese', 0, 'si', 'N', NULL, NULL, 'N', 'N'),
(101, 'Slovak', 0, 'sk', 'N', NULL, NULL, 'N', 'N'),
(102, 'Slovenian', 0, 'sl', 'N', NULL, NULL, 'N', 'N'),
(103, 'Samoan', 0, 'sm', 'N', NULL, NULL, 'N', 'N'),
(104, 'Shona', 0, 'sn', 'N', NULL, NULL, 'N', 'N'),
(105, 'Somali', 0, 'so', 'N', NULL, NULL, 'N', 'N'),
(106, 'Albanian', 0, 'sq', 'N', NULL, NULL, 'N', 'N'),
(107, 'Serbian', 0, 'sr', 'N', NULL, NULL, 'N', 'N'),
(108, 'Siswati', 0, 'ss', 'N', NULL, NULL, 'N', 'N'),
(109, 'Sesotho', 0, 'st', 'N', NULL, NULL, 'N', 'N'),
(110, 'Sundanese', 0, 'su', 'N', NULL, NULL, 'N', 'N'),
(111, 'Swedish', 0, 'sv', 'N', NULL, NULL, 'N', 'N'),
(112, 'Swahili', 0, 'sw', 'N', NULL, NULL, 'N', 'N'),
(113, 'Tamil', 0, 'ta', 'Y', NULL, 7, 'N', 'N'),
(114, 'Telugu', 0, 'te', 'Y', NULL, 6, 'N', 'N'),
(115, 'Tajik', 0, 'tg', 'N', NULL, NULL, 'N', 'N'),
(116, 'Thai', 0, 'th', 'N', NULL, NULL, 'N', 'N'),
(117, 'Tigrinya', 0, 'ti', 'N', NULL, NULL, 'N', 'N'),
(118, 'Turkmen', 0, 'tk', 'N', NULL, NULL, 'N', 'N'),
(119, 'Tagalog', 0, 'tl', 'N', NULL, NULL, 'N', 'N'),
(120, 'Setswana', 0, 'tn', 'N', NULL, NULL, 'N', 'N'),
(121, 'Tonga', 0, 'to', 'N', NULL, NULL, 'N', 'N'),
(122, 'Turkish', 0, 'tr', 'N', NULL, NULL, 'N', 'N'),
(123, 'Tsonga', 0, 'ts', 'N', NULL, NULL, 'N', 'N'),
(124, 'Tatar', 0, 'tt', 'N', NULL, NULL, 'N', 'N'),
(125, 'Twi', 0, 'tw', 'N', NULL, NULL, 'N', 'N'),
(126, 'Ukrainian', 0, 'uk', 'N', NULL, NULL, 'N', 'N'),
(127, 'Urdu', 0, 'ur', 'N', NULL, NULL, 'N', 'N'),
(128, 'Uzbek', 0, 'uz', 'N', NULL, NULL, 'N', 'N'),
(129, 'Vietnamese', 0, 'vi', 'N', NULL, NULL, 'N', 'N'),
(130, 'Volapuk', 0, 'vo', 'N', NULL, NULL, 'N', 'N'),
(131, 'Wolof', 0, 'wo', 'N', NULL, NULL, 'N', 'N'),
(132, 'Xhosa', 0, 'xh', 'N', NULL, NULL, 'N', 'N'),
(133, 'Yoruba', 0, 'yo', 'N', NULL, NULL, 'N', 'N'),
(134, 'Chinese', 0, 'zh', 'N', 9, NULL, 'Y', 'N'),
(135, 'Zulu', 0, 'zu', 'N', NULL, NULL, 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `intorder` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `is_active`, `is_delete`, `intorder`, `created_at`, `updated_at`) VALUES
(1, 'Beginner', 1, 0, 1, '2021-05-09 17:32:43', '2021-05-09 14:55:30'),
(2, 'Intermediate', 1, 0, 2, '2021-05-09 17:32:46', '2021-05-09 14:55:06'),
(3, 'Independent', 1, 0, 3, '2021-05-11 16:44:41', '2021-05-09 17:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `location_cities`
--

CREATE TABLE `location_cities` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location_cities`
--

INSERT INTO `location_cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'City 1', '2021-04-01 17:33:19', '2021-04-01 17:33:19'),
(3, 'City 2', '2021-04-01 17:33:25', '2021-04-01 17:33:25'),
(4, 'City 3', '2021-04-02 16:34:07', '2021-04-02 16:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` char(49) CHARACTER SET utf8 DEFAULT NULL,
  `intorder` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT 1,
  `is_delete` int(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `name`, `intorder`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'USA STOCK & INDICES', 1, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(2, 'CHINA STOCK & INDICES', 2, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(3, 'AUSTRALIA & NEW ZEALAND STOCK AND INDICES', 3, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(4, 'EUROPE STOCK & INDICES', 4, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(5, 'JAPAN STOCK & INDICES', 5, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(6, 'UNITED KINGDOM STOCK & INDICES', 6, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(7, 'BRAZIL STOCK & INDICES', 7, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(8, 'TAIWAN STOCK & INDICES', 8, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(9, 'SOUTH KOREA STOCK & INDICES', 9, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(10, 'SINGAPORE STOCK & INDICES', 10, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02'),
(11, 'INDIA STOCK & INDICES', 11, 1, 0, '2021-05-11 15:33:02', '2021-05-11 15:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `receiver_user_id` int(11) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `module_slug` varchar(55) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `module_slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'dashboard', 1, '2020-01-09 18:48:50', NULL),
(2, 'General Settings', 'general_settings', 1, '2020-01-09 18:48:50', NULL),
(3, 'Access Rights', 'access_rights', 1, '2020-01-09 18:48:50', NULL),
(4, 'User Profile', 'user_profile', 1, '2020-01-12 08:11:41', NULL),
(5, 'Change Password', 'change_password', 1, '2020-01-12 08:11:41', NULL),
(6, 'Contact Lead', 'contact_leads', 1, '2020-02-09 09:34:32', NULL),
(7, 'Admin Users', 'admin_users', 1, '2020-04-04 14:14:11', NULL),
(8, 'Admin Roles', 'admin_roles', 1, '2020-04-04 14:15:05', NULL),
(9, 'Module Type', 'moduletype', 1, '2021-05-18 16:28:51', NULL),
(10, 'Levels', 'level', 1, '2021-05-18 16:28:51', NULL),
(11, 'category', 'category', 1, '2021-05-18 16:29:45', NULL),
(12, 'Markets', 'markets', 1, '2021-05-18 16:29:45', NULL),
(13, 'Courses', 'courses', 1, '2021-05-18 16:30:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_types`
--

CREATE TABLE `module_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `intorder` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_types`
--

INSERT INTO `module_types` (`id`, `name`, `is_active`, `is_delete`, `intorder`, `created_at`, `updated_at`) VALUES
(1, 'Training', 1, 0, 1, '2021-05-09 15:15:01', '2021-05-09 14:55:30'),
(2, 'Advisory', 1, 0, 2, '2021-05-09 15:15:05', '2021-05-09 14:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `txtMessage` text COLLATE utf8_bin NOT NULL,
  `intUserId` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `txtMessage`, `intUserId`, `is_read`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Good course', 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-08-20 19:49:39'),
(2, NULL, 'Nice one!', 1, 1, 1, 0, '2021-05-16 19:07:10', '2021-08-20 19:49:39'),
(3, NULL, 'Good course', 1, 1, 1, 0, '2021-05-24 19:22:14', '2021-08-20 19:49:39'),
(4, NULL, 'First Notification', 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-08-20 19:49:39'),
(5, NULL, 'Second notification', 1, 1, 1, 0, '2021-05-16 19:07:10', '2021-08-20 19:49:39'),
(6, NULL, 'Third notification', 1, 1, 1, 0, '2021-05-24 19:22:14', '2021-08-20 19:49:39'),
(7, NULL, 'Fourth notification', 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-08-20 19:49:39'),
(8, NULL, 'Fifth notification', 1, 1, 1, 0, '2021-05-16 19:07:10', '2021-08-20 19:49:39'),
(9, NULL, 'Sixth notification', 1, 1, 1, 0, '2021-05-24 19:22:14', '2021-08-20 19:49:39'),
(10, NULL, 'Seven notification', 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-08-20 19:49:39'),
(11, NULL, 'eight notification.', 1, 1, 1, 0, '2021-05-16 19:07:10', '2021-08-20 19:49:39'),
(12, NULL, 'nine notification', 1, 1, 1, 0, '2021-05-24 19:22:14', '2021-08-20 19:49:39'),
(13, NULL, '10 notification', 1, 1, 1, 0, '2021-06-09 19:22:14', '2021-08-20 19:49:39'),
(14, NULL, '11 notification', 1, 1, 1, 0, '2021-06-09 19:05:05', '2021-08-20 19:49:39'),
(15, NULL, '12 notification.', 1, 1, 1, 0, '2021-06-09 19:07:10', '2021-08-20 19:49:39'),
(16, NULL, '13 notification', 1, 1, 1, 0, '2021-06-09 19:22:14', '2021-08-20 19:49:39'),
(17, NULL, ' is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 1, 1, 1, 0, '2021-06-10 19:22:14', '2021-08-20 19:49:39'),
(18, NULL, 'Welcome to the Market Mantra app. Explore the app to see the features!', 4, 1, 1, 0, '2021-06-15 23:03:24', '2021-08-09 08:18:02'),
(19, NULL, 'Start your journey with subscribing \" Basic Price Analysis\" course.', 4, 1, 1, 0, '2021-06-16 10:03:24', '2021-08-09 08:18:02'),
(21, 'Where can I get some?', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.', 1, 1, 1, 0, '2021-07-04 17:09:43', '2021-08-20 19:49:39'),
(22, 'Where can I get some?', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.', 7, 1, 1, 0, '2021-07-04 17:09:43', '2021-07-17 19:08:30'),
(23, 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.', 1, 1, 1, 0, '2021-07-04 17:10:28', '2021-08-20 19:49:39'),
(24, 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.', 7, 1, 1, 0, '2021-07-04 17:10:28', '2021-07-17 19:08:30'),
(25, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 1, 1, 1, 0, '2021-07-04 17:12:49', '2021-08-20 19:49:39'),
(26, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 7, 1, 1, 0, '2021-07-04 17:12:49', '2021-07-17 19:08:30'),
(27, 'test', 'test', 7, 1, 1, 0, '2021-07-04 18:18:08', '2021-07-17 19:08:30'),
(28, 'test', 'test', 7, 1, 1, 0, '2021-07-04 18:18:08', '2021-07-17 19:08:30'),
(29, 'test', 'test', 1, 1, 1, 0, '2021-07-04 18:18:08', '2021-08-20 19:49:39'),
(30, 'test', 'test', 1, 1, 1, 0, '2021-07-04 18:18:08', '2021-08-20 19:49:39'),
(31, 'test1', 'test1', 7, 1, 1, 0, '2021-07-04 18:18:55', '2021-07-17 19:08:30'),
(32, 'test1', 'test1', 7, 1, 1, 0, '2021-07-04 18:18:55', '2021-07-17 19:08:30'),
(33, 'test1', 'test1', 1, 1, 1, 0, '2021-07-04 18:18:55', '2021-08-20 19:49:39'),
(34, 'test1', 'test1', 1, 1, 1, 0, '2021-07-04 18:18:55', '2021-08-20 19:49:39'),
(35, 'test', 'test 2', 1, 1, 1, 0, '2021-07-04 18:19:26', '2021-08-20 19:49:39'),
(36, 'test', 'test 2', 7, 1, 1, 0, '2021-07-04 18:19:26', '2021-07-17 19:08:30'),
(37, 'test', 'test 3', 1, 1, 1, 0, '2021-07-04 18:19:41', '2021-08-20 19:49:39'),
(38, 'test', 'test 3', 7, 1, 1, 0, '2021-07-04 18:19:41', '2021-07-17 19:08:30'),
(39, 'test', 'test 4', 7, 1, 1, 0, '2021-07-04 18:19:59', '2021-07-17 19:08:30'),
(40, 'test', 'test 4', 7, 1, 1, 0, '2021-07-04 18:19:59', '2021-07-17 19:08:30'),
(41, 'test', 'test 4', 1, 1, 1, 0, '2021-07-04 18:19:59', '2021-08-20 19:49:39'),
(42, 'test', 'test 4', 1, 1, 1, 0, '2021-07-04 18:19:59', '2021-08-20 19:49:39'),
(43, 'test', 'test 5', 1, 1, 1, 0, '2021-07-04 18:22:15', '2021-08-20 19:49:39'),
(44, 'test', 'test 5', 7, 1, 1, 0, '2021-07-04 18:22:15', '2021-07-17 19:08:30'),
(45, 'test', 'test 7', 7, 1, 1, 0, '2021-07-04 18:23:17', '2021-07-17 19:08:30'),
(46, 'test', 'test 7', 7, 1, 1, 0, '2021-07-04 18:23:17', '2021-07-17 19:08:30'),
(47, 'test', 'test 7', 1, 1, 1, 0, '2021-07-04 18:23:17', '2021-08-20 19:49:39'),
(48, 'test', 'test 7', 1, 1, 1, 0, '2021-07-04 18:23:17', '2021-08-20 19:49:39'),
(49, 'test', 'test 8', 1, 1, 1, 0, '2021-07-04 18:24:24', '2021-08-20 19:49:39'),
(50, 'test', 'test 8', 7, 1, 1, 0, '2021-07-04 18:24:24', '2021-07-17 19:08:30'),
(51, 'test 9', 'test 9', 1, 1, 1, 0, '2021-07-04 18:25:32', '2021-08-20 19:49:39'),
(52, 'test 9', 'test 9', 7, 1, 1, 0, '2021-07-04 18:25:32', '2021-07-17 19:08:30'),
(53, 'test', 'test 10', 1, 1, 1, 0, '2021-07-04 18:28:21', '2021-08-20 19:49:39'),
(54, 'test', 'test 10', 7, 1, 1, 0, '2021-07-04 18:28:21', '2021-07-17 19:08:30'),
(55, 'test', 'test', 1, 1, 1, 0, '2021-07-04 18:29:25', '2021-08-20 19:49:39'),
(56, 'test', 'test', 7, 1, 1, 0, '2021-07-04 18:29:25', '2021-07-17 19:08:30'),
(57, 'test', 'test', 1, 1, 1, 0, '2021-07-04 18:41:13', '2021-08-20 19:49:39'),
(58, 'test', 'test', 7, 1, 1, 0, '2021-07-04 18:41:13', '2021-07-17 19:08:30'),
(59, 'test', 'test', 1, 1, 1, 0, '2021-07-04 18:42:20', '2021-08-20 19:49:39'),
(60, 'test', 'test', 7, 1, 1, 0, '2021-07-04 18:42:20', '2021-07-17 19:08:30'),
(61, 'test', 'test', 1, 1, 1, 0, '2021-07-04 18:42:48', '2021-08-20 19:49:39'),
(62, 'test', 'test', 7, 1, 1, 0, '2021-07-04 18:42:48', '2021-07-17 19:08:30'),
(63, 'test 11', 'test 11', 1, 1, 1, 0, '2021-07-04 18:43:42', '2021-08-20 19:49:39'),
(64, 'test 11', 'test 11', 7, 1, 1, 0, '2021-07-04 18:43:42', '2021-07-17 19:08:30'),
(65, 'test 11', 'test 12', 1, 1, 1, 0, '2021-07-04 18:44:07', '2021-08-20 19:49:39'),
(66, 'test 11', 'test 12', 7, 1, 1, 0, '2021-07-04 18:44:07', '2021-07-17 19:08:30'),
(67, 'test', 'test 6', 1, 1, 1, 0, '2021-07-04 18:44:34', '2021-08-20 19:49:39'),
(68, 'test', 'test 6', 7, 1, 1, 0, '2021-07-04 18:44:34', '2021-07-17 19:08:30'),
(69, 'test', 'test 7', 1, 1, 1, 0, '2021-07-04 18:45:12', '2021-08-20 19:49:39'),
(70, 'test', 'test 7', 7, 1, 1, 0, '2021-07-04 18:45:12', '2021-07-17 19:08:30'),
(71, 'test', 'test 13', 7, 1, 1, 0, '2021-07-04 18:46:15', '2021-07-17 19:08:30'),
(72, 'test', 'test 13', 7, 1, 1, 0, '2021-07-04 18:46:15', '2021-07-17 19:08:30'),
(73, 'test', 'test 13', 1, 1, 1, 0, '2021-07-04 18:46:15', '2021-08-20 19:49:39'),
(74, 'test', 'test 14', 1, 1, 1, 0, '2021-07-04 18:47:06', '2021-08-20 19:49:39'),
(75, 'test', 'test 14', 7, 1, 1, 0, '2021-07-04 18:47:06', '2021-07-17 19:08:30'),
(76, 'Test Notification', 'Test Description added.', 1, 1, 1, 0, '2021-07-05 17:33:01', '2021-08-20 19:49:39'),
(77, 'Test Notification', 'Test Description added.', 7, 1, 1, 0, '2021-07-05 17:33:01', '2021-07-17 19:08:30'),
(78, 'Test', 'Testing', 1, 1, 1, 0, '2021-07-07 06:41:01', '2021-08-20 19:49:39'),
(79, 'Test', 'Testing', 7, 1, 1, 0, '2021-07-07 06:41:01', '2021-07-17 19:08:30'),
(80, 'Test', 'Testset', 1, 1, 1, 0, '2021-07-07 06:48:32', '2021-08-20 19:49:39'),
(81, 'Test', 'Testset', 7, 1, 1, 0, '2021-07-07 06:48:32', '2021-07-17 19:08:30'),
(82, 'Test', 'Testset', 9, 1, 1, 0, '2021-07-07 06:48:32', '2021-07-07 07:05:25'),
(83, 'this is marketmantra', 'Hello all please join us asap.', 1, 1, 1, 0, '2021-07-07 06:56:58', '2021-08-20 19:49:39'),
(84, 'this is marketmantra', 'Hello all please join us asap.', 4, 1, 1, 0, '2021-07-07 06:56:58', '2021-08-09 08:18:02'),
(85, 'this is marketmantra', 'Hello all please join us asap.', 7, 1, 1, 0, '2021-07-07 06:56:58', '2021-07-17 19:08:30'),
(86, 'this is marketmantra', 'Hello all please join us asap.', 9, 1, 1, 0, '2021-07-07 06:56:58', '2021-07-07 07:05:25'),
(87, 'Test', 'Testing', 1, 1, 1, 0, '2021-07-07 06:58:02', '2021-08-20 19:49:39'),
(88, 'Test', 'Testing', 4, 1, 1, 0, '2021-07-07 06:58:02', '2021-08-09 08:18:02'),
(89, 'Test', 'Testing', 7, 1, 1, 0, '2021-07-07 06:58:02', '2021-07-17 19:08:30'),
(90, 'Test', 'Testing', 9, 1, 1, 0, '2021-07-07 06:58:02', '2021-07-07 07:05:25');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0d91569f7b73ec0d7600a279db75e2cddffb72e2656708a1ca3423d75be71ec87356653b01b1e4eb', 1, 1, 'authToken', '[]', 0, '2021-04-11 10:14:52', '2021-04-11 10:14:52', '2022-04-11 15:44:52'),
('d5d3829d3ffe3f04156e8dece3a6b4bddf938a2dd7ee1a4eed5b96fabd56cf370f99856cb3893306', 1, 1, 'authToken', '[]', 0, '2021-04-11 10:15:19', '2021-04-11 10:15:19', '2022-04-11 15:45:19'),
('1902fd59d73f4cbd6bf8f0f3c4f3b8484b7299d791f1c7f2ef2750d964ba743aa13a06725ac5d264', 1, 1, 'authToken', '[]', 0, '2021-04-11 17:15:36', '2021-04-11 17:15:36', '2022-04-11 17:15:36'),
('93e0711fa69580fa4dbdef01c03e20fa2a95790e4076713a1af15a376fefc62e6f5ad94ce2add61d', 1, 1, 'authToken', '[]', 0, '2021-04-11 17:43:39', '2021-04-11 17:43:39', '2022-04-11 17:43:39'),
('429450b876adfa5e7283f333ba49094b38cf066ed216b73c1a555204f8d7a8096282aee73ded8a59', 1, 1, 'authToken', '[]', 0, '2021-04-11 19:56:19', '2021-04-11 19:56:19', '2022-04-11 19:56:19'),
('2dfe2e00edb3303596d576fe4fc0125d0b7601dc1ab7bf0e5dfb2ee051cf487e7be4fecbfc99a854', 1, 1, 'authToken', '[]', 0, '2021-04-11 20:01:04', '2021-04-11 20:01:04', '2022-04-11 20:01:04'),
('3283db3b8b34a8a02e98f19aa860f516e3e41b20fdbb1e74ad4cabe2cfc0356dd8bd97e85a022264', 1, 1, 'authToken', '[]', 0, '2021-04-13 14:29:26', '2021-04-13 14:29:26', '2022-04-13 14:29:26'),
('da2f8c00c4ede7b7762fd05a056d62fd512a25cb0f21d04bff7f103c67c610c25dca366874aeafb7', 1, 1, 'authToken', '[]', 0, '2021-04-13 14:33:03', '2021-04-13 14:33:03', '2022-04-13 14:33:03'),
('100ad05d28de97ccf48df2f0addb5aa053416a6a911f91d54c8f7457277d4cd0c5da2116e444f12c', 1, 1, 'authToken', '[]', 0, '2021-04-13 14:33:43', '2021-04-13 14:33:43', '2022-04-13 14:33:43'),
('2ed61c6fee0843e2e85df3948a4b1fd902ea78b0e51237cb4c22d00bec007218eac524453d1795a6', 1, 1, 'authToken', '[]', 0, '2021-04-13 18:07:15', '2021-04-13 18:07:15', '2022-04-13 18:07:15'),
('b83f7f119d06cc1a2d48150e35967f1e18a4528c6964ef2c8a3d0a1eba259b6f94f06905475f382d', 1, 1, 'authToken', '[]', 0, '2021-04-14 07:23:31', '2021-04-14 07:23:31', '2022-04-14 07:23:31'),
('025ff9f6606d4fe5081ef2fe72fcf4626001f817eadcc8e4bd759ae1a3ad0525f77e23548bdd45c6', 1, 1, 'authToken', '[]', 0, '2021-04-14 07:25:24', '2021-04-14 07:25:24', '2022-04-14 07:25:24'),
('cc47765cfd97b7f10dfb886571e8b83667e7e683ac96ec84e3ef1335d0ddc44b8054ec3ed4d9f9e2', 1, 1, 'authToken', '[]', 0, '2021-04-15 18:58:19', '2021-04-15 18:58:19', '2022-04-15 18:58:19'),
('f810e24ca34e0010f2733824073cff8df7f8ade35f2b5fa795ff9c8afcc9c19bf42d9e00378194b6', 1, 1, 'authToken', '[]', 0, '2021-04-15 18:58:30', '2021-04-15 18:58:30', '2022-04-15 18:58:30'),
('e147987517cb1e2faf27aea1fac9c26a0a9d30d471078d2daa7ed6755e4f94c7651dc667fbc355a2', 1, 1, 'authToken', '[]', 0, '2021-04-15 19:10:00', '2021-04-15 19:10:00', '2022-04-15 19:10:00'),
('28c9281bd216f505cfe00be69b4b6a37e12694ac701362075439b4f47be2e1387efcf6c23ccc7162', 3, 1, 'authToken', '[]', 0, '2021-04-17 14:02:15', '2021-04-17 14:02:15', '2022-04-17 14:02:15'),
('67e27353fd746854499a881a0aa1f510d1bb2558654ce67bc179177adc80861eda813f38e1b77a60', 3, 1, 'authToken', '[]', 0, '2021-04-17 15:29:59', '2021-04-17 15:29:59', '2022-04-17 15:29:59'),
('756010c775319665ab0a7875a146431a7769d2033ccc10df9e6ff2e7ab94183ff8a05a2037cd0551', 3, 1, 'authToken', '[]', 0, '2021-04-18 06:40:45', '2021-04-18 06:40:45', '2022-04-18 06:40:45'),
('5480e5919bdcd30230c53d068c3b012e692cc2ddd5910dbc77b7ae965d8d0520d4804d0c3e617d4e', 4, 1, 'authToken', '[]', 0, '2021-04-18 17:12:40', '2021-04-18 17:12:40', '2022-04-18 17:12:40'),
('25266a104961a9aea1dea081c03b16d8c592c74be2142ef180e19279c219760d04f9112c7085055c', 8, 1, 'authToken', '[]', 0, '2021-04-19 18:44:40', '2021-04-19 18:44:40', '2022-04-19 18:44:40'),
('2457bc97802269e65f88ea77b18a11b94b510e7d89bb3a432f782410b8abcdb073901e1fdd58c4d5', 8, 1, 'authToken', '[]', 0, '2021-04-19 18:57:23', '2021-04-19 18:57:23', '2022-04-19 18:57:23'),
('45ef98d79131e9052ac6186ebea36c55448bafd0fb04243a6ae9125821d71ce4502c3e433b273784', 8, 1, 'authToken', '[]', 0, '2021-04-19 18:58:41', '2021-04-19 18:58:41', '2022-04-19 18:58:41'),
('048ce7823f84c66a5da6bd7ce839f48d4a3a5aac09c5bcd72f9d19bab2c5751b0b04e8d4a40fab34', 8, 1, 'authToken', '[]', 0, '2021-04-19 19:00:19', '2021-04-19 19:00:19', '2022-04-19 19:00:19'),
('4c46464c508bcbb9f58e5df7193fca24a62f2a3c7981743a2568243622361a4d0befe0cd7c3eb186', 3, 1, 'authToken', '[]', 0, '2021-04-20 17:50:55', '2021-04-20 17:50:55', '2022-04-20 17:50:55'),
('1495e74155f0d95b6033244e9c226a884dc0c442d472aafdcf2e39a485fbab79c5d2e3334ecb3c66', 8, 1, 'authToken', '[]', 0, '2021-04-21 15:47:23', '2021-04-21 15:47:23', '2022-04-21 15:47:23'),
('51f09c885e952c931b580959b9f86c350f717817d932895a2d45c2d2a076f1b598e084ec44b6e065', 8, 1, 'authToken', '[]', 0, '2021-04-21 15:49:18', '2021-04-21 15:49:18', '2022-04-21 15:49:18'),
('1b63e402311035cb7e46e3f3b002de6e4d977506f40a15d1a764f4bd15fcd9320858b1d0ff6953d1', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:03:01', '2021-04-21 16:03:01', '2022-04-21 16:03:01'),
('5c81da90c9c9d538d04f3af379146c2e4f140ff630c55608c83a7b6b04db0e86c7d47a77b117ae90', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:04:06', '2021-04-21 16:04:06', '2022-04-21 16:04:06'),
('82eabf371e3c27b943925dfa8f942ba0318cc2eb72ddf309087a0b590b74f5eef9a7a5a3062ead94', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:06:37', '2021-04-21 16:06:37', '2022-04-21 16:06:37'),
('70e9d4feafabc593ce9dbe55082830436976e5aba776ec0812d19df8b39dff569348ded973bb1278', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:10:30', '2021-04-21 16:10:30', '2022-04-21 16:10:30'),
('1a1c7f3bdb4470440fc4f89f79d756c0ad742ab1c3923ed3b9ab7f49277145249d067747ffb48253', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:13:01', '2021-04-21 16:13:01', '2022-04-21 16:13:01'),
('66d37b6f8bf6cc8e4cb0aea280eaabafb3d0c56243fe3e5040250437f2076c8bc3a6e17f47eaa31e', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:14:33', '2021-04-21 16:14:33', '2022-04-21 16:14:33'),
('2eb51a016d9094c642ee4a69c19cb5002319f97319436c60a4d94fb678eaaee59cba0f100f424fa1', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:18:45', '2021-04-21 16:18:45', '2022-04-21 16:18:45'),
('58cf848fac307debc1601ab3914dbb716baf663e07e35e8b2840dd3e44c4b30d4ee887846ac158b0', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:19:57', '2021-04-21 16:19:57', '2022-04-21 16:19:57'),
('f0892cea1f6b827b7ca2f0c8f1955dcc65658cc8a4faabdde063aa7ef84102bf4f8be8f8531b2f6a', 3, 1, 'authToken', '[]', 0, '2021-04-21 16:20:33', '2021-04-21 16:20:33', '2022-04-21 16:20:33'),
('5df246012a52883331c909a1acddc8701bb95d0ddff254d219b2474eccf62ed99c24449dca57d7cc', 8, 1, 'authToken', '[]', 0, '2021-04-21 16:29:29', '2021-04-21 16:29:29', '2022-04-21 16:29:29'),
('1dbd26152d837fbd0242bf4322391a172ab561ce4f9350d7225b68893eec24994f4b69607d02f089', 8, 1, 'authToken', '[]', 0, '2021-04-21 17:13:34', '2021-04-21 17:13:34', '2022-04-21 17:13:34'),
('84711c764def5a4d92dcf4e2d1234f020821191549d209f44b397d4a3a1fb7b204f5341081d2f05d', 8, 1, 'authToken', '[]', 0, '2021-04-21 17:27:56', '2021-04-21 17:27:56', '2022-04-21 17:27:56'),
('89a42ef1d2b53f43569560ca7c37f453c799b1b14157025d26dfc67cb45e67d36a4e66b0bca5ff56', 8, 1, 'authToken', '[]', 0, '2021-04-21 17:29:41', '2021-04-21 17:29:41', '2022-04-21 17:29:41'),
('63a9084fc756e435ddcfe82f1d03e6a3345bab252d4506ee4d1611552b61bcaebc2269736c3e94c1', 8, 1, 'authToken', '[]', 0, '2021-04-21 17:33:37', '2021-04-21 17:33:37', '2022-04-21 17:33:37'),
('ea27c6a85fc5648cbcf2e6bee63cf53a2c41610718766cdb6855cdf018a36c41c3cc977bd5e1549b', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:21:19', '2021-04-21 18:21:19', '2022-04-21 18:21:19'),
('a49d43c68dc846d701b6b30aa96ebd684b0185d4855387b21c426752a9a0642402e01162e730b00f', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:33:35', '2021-04-21 18:33:35', '2022-04-21 18:33:35'),
('02192bab18d9900b0508ce492789c8d4caa0fa4c0bc4bc9ef7e4a96a805f5cc4c210e844503a1760', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:40:58', '2021-04-21 18:40:58', '2022-04-21 18:40:58'),
('bc18ca07319859ce00e9e8a7212e0962f5c463ca94e8d9536c008dc230534943e1841aa90d0880da', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:41:12', '2021-04-21 18:41:12', '2022-04-21 18:41:12'),
('d06e223a1b78aa3823a3ca36eda7b6ad3bebf6319551b6aff16d94ef804cc3e5734afe02f75f2d5f', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:41:48', '2021-04-21 18:41:48', '2022-04-21 18:41:48'),
('b1edf52877d3a0e2752b89304a63857e885337f79df7aab15b69fdc123c3263e9c6d600ceb11e92b', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:43:23', '2021-04-21 18:43:23', '2022-04-21 18:43:23'),
('79bcaa43c5350bc228ce2e0b457f2dcf4e34064c5ef3dee478a093226c40cf61c24cd858221e2063', 8, 1, 'authToken', '[]', 0, '2021-04-21 18:59:20', '2021-04-21 18:59:20', '2022-04-21 18:59:20'),
('79e2bfbf949f18068d8b1057f15b9ba4892af0075fbc9cc8265e1410c7b3d25df96fdb269dcc2e8e', 8, 1, 'authToken', '[]', 0, '2021-04-21 19:00:27', '2021-04-21 19:00:27', '2022-04-21 19:00:27'),
('ef352ed2421fe2d94e86f63c1b259abf221f5557c5a2a2dd9a916a205bf7e596f52ae2522aa7cbf1', 8, 1, 'authToken', '[]', 0, '2021-04-21 19:35:34', '2021-04-21 19:35:34', '2022-04-21 19:35:34'),
('c390e3f6877fd30c24ac8f48db9d984ddccf2c6ca635e711090867452f516ec27da6adb6690cfb0e', 10, 1, 'authToken', '[]', 0, '2021-04-21 19:43:31', '2021-04-21 19:43:31', '2022-04-21 19:43:31'),
('95320094690f996d865b3b813e83372ed72fbf14bee12e8f665dadb75049929f40852d21bf8d3d65', 8, 1, 'authToken', '[]', 0, '2021-04-21 20:32:49', '2021-04-21 20:32:49', '2022-04-21 20:32:49'),
('7a0adcafab00de4747e166ada3fe2270e63a318c81ddd35c7f47dbb55b6baee3f6f6481a6b03c3fa', 8, 1, 'authToken', '[]', 0, '2021-04-21 20:39:01', '2021-04-21 20:39:01', '2022-04-21 20:39:01'),
('0f8efc0529e059e0ec459f418f5d12e36ad326a0d664d1e3905dbc108bac846783d465578d29e3f8', 8, 1, 'authToken', '[]', 0, '2021-04-22 17:35:39', '2021-04-22 17:35:39', '2022-04-22 17:35:39'),
('eff6cfef2beec8a3b8f363708b232441415ae19ff28a9f032f6cd6207a15981c73343229f69ddb77', 8, 1, 'authToken', '[]', 0, '2021-04-23 05:30:50', '2021-04-23 05:30:50', '2022-04-23 05:30:50'),
('ffab0df9c2d8f7b04964bd1722e586d24da95a5def6556a46e123914c7b8c1935093ad1dafbe254d', 8, 1, 'authToken', '[]', 0, '2021-04-23 06:31:19', '2021-04-23 06:31:19', '2022-04-23 06:31:19'),
('3d9829055a7b4886327d86dda804c5e495028b152416374bfff5432a63ba3dc8b164021a748f80cd', 8, 1, 'authToken', '[]', 0, '2021-04-23 19:03:28', '2021-04-23 19:03:28', '2022-04-23 19:03:28'),
('9e7d590cbec2395d4ad4fb60324e636abcd9374ba1fb058a12c36260d5d371b99c47b8b52a440f96', 8, 1, 'authToken', '[]', 0, '2021-04-24 03:58:57', '2021-04-24 03:58:57', '2022-04-24 03:58:57'),
('d1760687b4e2708058b7ddad10f00ac9ec6566ed75fcfcd3b109fc8d08c0dc56fde4eadf89a3bbdb', 8, 1, 'authToken', '[]', 0, '2021-04-25 10:44:30', '2021-04-25 10:44:30', '2022-04-25 10:44:30'),
('ba68544115e16998bb965e67ad44076a8448ed04fa8d7889145091b9d79ab754d5fde002ba8ff535', 8, 1, 'authToken', '[]', 0, '2021-04-25 10:49:30', '2021-04-25 10:49:30', '2022-04-25 10:49:30'),
('4c227576932448e088d4ad5fc7146e5bb8a86232b55c3cdc3adeb296b275ef4ce7b575336d6acf54', 8, 1, 'authToken', '[]', 0, '2021-04-25 14:57:49', '2021-04-25 14:57:49', '2022-04-25 14:57:49'),
('545fda99691d424140a85604af57c3acf48fe1af9d5e23dcfd9a61f14bf1883757e53c488b449bcd', 8, 1, 'authToken', '[]', 0, '2021-04-25 15:11:01', '2021-04-25 15:11:01', '2022-04-25 15:11:01'),
('f2fc6244ca7f195d51c296ff8fd5a7e5c8c24fc85ef567de0ebdd14c312146425bb512e495af0c1c', 8, 1, 'authToken', '[]', 0, '2021-04-25 15:27:43', '2021-04-25 15:27:43', '2022-04-25 15:27:43'),
('ed83ef7297cae64490173425b794e5c2a3abb40b28e6f63ef3a46123196b4857ac3dee6d1ece8911', 3, 1, 'authToken', '[]', 0, '2021-04-28 11:37:45', '2021-04-28 11:37:45', '2022-04-28 11:37:45'),
('6091e622b39002d3becec22def0cc28f2a7f456a8317e554d6dfce2a7791fa18ed69b4b31fb2a23b', 8, 1, 'authToken', '[]', 0, '2021-04-28 17:37:44', '2021-04-28 17:37:44', '2022-04-28 17:37:44'),
('4a96307009c5054b12dc548d96671198472ecbb9d00abc49921cc1e5a2868d15cca2bd62b471b917', 8, 1, 'authToken', '[]', 0, '2021-04-28 19:36:56', '2021-04-28 19:36:56', '2022-04-28 19:36:56'),
('84e1a78ecd0fceb7eddda63516b329c6a23ba3cdfe353ff255c6d7e56a37e73fc71b85fbaf9f256c', 8, 1, 'authToken', '[]', 0, '2021-04-28 19:44:35', '2021-04-28 19:44:35', '2022-04-28 19:44:35'),
('3a2eee64a6e5b11f6d78ba75d731aa1e6c796c9b511987363d884123e438edfae4484ad1489d8171', 8, 1, 'authToken', '[]', 0, '2021-04-28 19:45:02', '2021-04-28 19:45:02', '2022-04-28 19:45:02'),
('5b698d04d6e710b97ef6b6a9500834a55dc369e3189cd9e982140bbea45c125b2def1df56e714d6c', 8, 1, 'authToken', '[]', 0, '2021-04-28 20:14:17', '2021-04-28 20:14:17', '2022-04-28 20:14:17'),
('798d9e95a0ed6d5da5a0dfb9f1f755b8581ada79b0e123c3246ecaf3303372a6242007a212399bda', 8, 1, 'authToken', '[]', 0, '2021-04-28 20:14:59', '2021-04-28 20:14:59', '2022-04-28 20:14:59'),
('f4e2c257c3eaaf2dc17f890838f8cf018caabe89244c372d2eb2d9ca4036702c2523b98cf9848d79', 16, 1, 'authToken', '[]', 0, '2021-04-29 18:53:27', '2021-04-29 18:53:27', '2022-04-29 18:53:27'),
('e812013dca9cfe788733ea9653e188577ca284153b49edf5d62053ce371d4eb92de4f34f1e8cdd1a', 16, 1, 'authToken', '[]', 0, '2021-04-29 18:58:42', '2021-04-29 18:58:42', '2022-04-29 18:58:42'),
('44c4572cae2d328e5e60263b781b46b8e3d505f845558be16f500973c3632b4a79d2869e3556b777', 8, 1, 'authToken', '[]', 0, '2021-04-29 18:59:12', '2021-04-29 18:59:12', '2022-04-29 18:59:12'),
('369fb2c4aa58c535b4d2fd11a2291c75edca41fe63df524eb8876e24ebc7808b4b79b5d13e48e2a0', 8, 1, 'authToken', '[]', 0, '2021-05-01 15:38:45', '2021-05-01 15:38:45', '2022-05-01 15:38:45'),
('b3d1bdb7db7a7160a2ebae7b3321f0f19d3ebd4f4f1527d378bef85dd087253bc78df7fc6093dd68', 8, 1, 'authToken', '[]', 0, '2021-05-01 20:02:12', '2021-05-01 20:02:12', '2022-05-01 20:02:12'),
('0967ab90810c8e8160c998de4e9571fb2d7d5342f815081444b08f61773084ec75cae6d942729712', 8, 1, 'authToken', '[]', 0, '2021-05-01 20:29:35', '2021-05-01 20:29:35', '2022-05-01 20:29:35'),
('bafcb3a246a36ebcc72ed8b0de104b8880644bc55a0e2225be81d906df68683c8c1b5f74e920a83c', 8, 1, 'authToken', '[]', 0, '2021-05-01 20:40:38', '2021-05-01 20:40:38', '2022-05-01 20:40:38'),
('c08b8f1d3496e1851826cca404864ca7cdd17ac9592ccd9c134985aae655700f1d6ddb4cdc023a7d', 8, 1, 'authToken', '[]', 0, '2021-05-01 20:47:58', '2021-05-01 20:47:58', '2022-05-01 20:47:58'),
('a13b54a481c34f00d25679deed8dac171cd27a19dbdd0f58e2cf6d3d17c7abd7dd81d0832e02b700', 8, 1, 'authToken', '[]', 0, '2021-05-02 10:57:08', '2021-05-02 10:57:08', '2022-05-02 10:57:08'),
('2f2e0596129d3e35ac50ddfbd7f29d40c9dcc8d6840ce6470e0d0eb9de2cbf65c67ca50f8f1e4caa', 18, 1, 'authToken', '[]', 0, '2021-05-02 14:02:07', '2021-05-02 14:02:07', '2022-05-02 14:02:07'),
('ffb4181242cec6af00717dd88bc4c0db073dd9cbc4558a42a60b1614fe23561ce0e59f8e321140f8', 18, 1, 'authToken', '[]', 0, '2021-05-02 14:06:05', '2021-05-02 14:06:05', '2022-05-02 14:06:05'),
('b96b7e81926bc57f02d91e6265ba4689634b8287728ca7c6fb69f989996d8f22469f2f574601c5b7', 18, 1, 'authToken', '[]', 0, '2021-05-02 14:06:57', '2021-05-02 14:06:57', '2022-05-02 14:06:57'),
('b2cfd3b2f036002a7179dedb50519c785f00dd40f6e410fb3d13d8c85711390cc2b3107d79c62943', 8, 1, 'authToken', '[]', 0, '2021-05-02 14:10:40', '2021-05-02 14:10:40', '2022-05-02 14:10:40'),
('421cfab09b1c86320fd7d7ffc9c82126b0553b95530fb2097f55d9d61c02c0dc07a789e643edaec2', 8, 1, 'authToken', '[]', 0, '2021-05-02 14:16:31', '2021-05-02 14:16:31', '2022-05-02 14:16:31'),
('1cf51c4abc8fc1edff4c6f90a55b618bee0e75407290365d073c5d263e46fc39c9b0def32f136035', 8, 1, 'authToken', '[]', 0, '2021-05-02 14:21:01', '2021-05-02 14:21:01', '2022-05-02 14:21:01'),
('0c4d5ba72b933167fc5a6b0f604a9fb25d0b90c546fb059888a096c8c34f9f83571a550480914844', 8, 1, 'authToken', '[]', 0, '2021-05-02 15:02:26', '2021-05-02 15:02:26', '2022-05-02 15:02:26'),
('ded3310e51ce78197728fc014f15a80df8b949c6da8f3d7dfebc2b36367e63ae5508f1ac00ea5ff6', 19, 1, 'authToken', '[]', 0, '2021-05-02 15:05:48', '2021-05-02 15:05:48', '2022-05-02 15:05:48'),
('aef703ef4e4afcce6bd9c30c6733802f94c9787f080d3cd092f1e07af4ff52c72b571d351c46e36b', 19, 1, 'authToken', '[]', 0, '2021-05-02 15:06:25', '2021-05-02 15:06:25', '2022-05-02 15:06:25'),
('23238fb3735db1798d6b4d6478cd945003ed3c9c5cc8a8e13d7ed79d41abc4e3e31c0b500a332d03', 20, 1, 'authToken', '[]', 0, '2021-05-02 16:08:14', '2021-05-02 16:08:14', '2022-05-02 16:08:14'),
('8305e64e11f5c38377acae58394a31a538e7f3933c5d84e03f30e5c1aef72e67308ddc162706e45d', 8, 1, 'authToken', '[]', 0, '2021-05-02 16:30:23', '2021-05-02 16:30:23', '2022-05-02 16:30:23'),
('009d78962e35e4a51ab24a659b2a77fdc45173c603ce5b53fa041d81d4563a9965ff5cdeb9e562f7', 21, 1, 'authToken', '[]', 0, '2021-05-02 18:10:14', '2021-05-02 18:10:14', '2022-05-02 18:10:14'),
('d1420e34b6af8375e869433c14a671576d4abc93968b8c5f933e135b2d339cadbc9f51d3f44a60c2', 8, 1, 'authToken', '[]', 0, '2021-05-02 18:21:10', '2021-05-02 18:21:10', '2022-05-02 18:21:10'),
('af75c7ddca012797f6250a8e0e4323fd0e625b7c1463e407087c6fafbfc673578ed128557273832f', 22, 1, 'authToken', '[]', 0, '2021-05-03 04:47:54', '2021-05-03 04:47:54', '2022-05-03 04:47:54'),
('fd6f5405a5a8143ca2904a72efeedc609c3d63d00f31e49b88464c4ab3b8ce7def58a4461c8a70ea', 8, 1, 'authToken', '[]', 0, '2021-05-03 06:24:44', '2021-05-03 06:24:44', '2022-05-03 06:24:44'),
('6a693c02988ac50ef31f9fbbd7e3e6bbcbdf54a3124f4e9af25e64fa2de2a983e16f66b5d919ce48', 24, 1, 'authToken', '[]', 0, '2021-05-03 06:55:19', '2021-05-03 06:55:19', '2022-05-03 06:55:19'),
('981d0addc2e667f5c7999b86485247a8e9bb9601cc5ada64e03ea33950a19ec61b1b460c2e5f512f', 22, 1, 'authToken', '[]', 0, '2021-05-03 07:45:49', '2021-05-03 07:45:49', '2022-05-03 07:45:49'),
('3681caf1b87a43eafc9f36bf75db526458e64967dc9966a05e5b120c73493c10fb7c721ee51c8530', 25, 1, 'authToken', '[]', 0, '2021-05-03 08:14:24', '2021-05-03 08:14:24', '2022-05-03 08:14:24'),
('d647d84f6af009bbe22976e99d84a1aacbb89bfade1ff2cd7d396d30e22e82e414d235663730778f', 26, 1, 'authToken', '[]', 0, '2021-05-03 08:15:49', '2021-05-03 08:15:49', '2022-05-03 08:15:49'),
('91a104ce3aa6ef81245c86b9ff0ab636a69b380d41e620b53642ebbdcd3e5159dcec048d34b2bba2', 27, 1, 'authToken', '[]', 0, '2021-05-03 08:35:08', '2021-05-03 08:35:08', '2022-05-03 08:35:08'),
('52ae9cd4efacc068dc6ef8f6162ca41568633550351c383c991f54d7ea34d3fef964752559ea71ac', 31, 1, 'authToken', '[]', 0, '2021-05-03 18:27:06', '2021-05-03 18:27:06', '2022-05-03 18:27:06'),
('73cae551b2750c8da7f838762120008852b78847b0db7d083685249ed07e46617a10d6a2ad925557', 31, 1, 'authToken', '[]', 0, '2021-05-03 18:34:43', '2021-05-03 18:34:43', '2022-05-03 18:34:43'),
('48d184596a79fcd09f745676e2fb6d383997b371474c9cf24d76b1571aed60396dea7b4b079e2e92', 33, 1, 'authToken', '[]', 0, '2021-05-03 19:35:27', '2021-05-03 19:35:27', '2022-05-03 19:35:27'),
('b2ec032bb95ce63fbc3562834b709192216df717cf0e0722227669ddc5ca1a7e423981a3e9830197', 34, 1, 'authToken', '[]', 0, '2021-05-03 19:39:16', '2021-05-03 19:39:16', '2022-05-03 19:39:16'),
('f954f635e986dd76b8b76f2ce377946cfd5ffa7b26312bc33ff88d19545f0f7da630ad2473557e25', 34, 1, 'authToken', '[]', 0, '2021-05-03 19:51:42', '2021-05-03 19:51:42', '2022-05-03 19:51:42'),
('b66fe10fb55443e5aac52f67e7630217d792e7f78df288aa404ebc8c84420f85913a9a52a92d35d5', 34, 1, 'authToken', '[]', 0, '2021-05-03 19:52:39', '2021-05-03 19:52:39', '2022-05-03 19:52:39'),
('79a87d3cbd5ca33adf784d47bc2263103f0197fcf00a903880ae65d5e4f98625afd19fffc516c362', 34, 1, 'authToken', '[]', 0, '2021-05-03 19:52:44', '2021-05-03 19:52:44', '2022-05-03 19:52:44'),
('9355f48997650a7bf16a039dc1ff430e16c8c08d05c76f179c267c1505c5f905e3db1c5c367feb48', 34, 1, 'authToken', '[]', 0, '2021-05-03 19:55:45', '2021-05-03 19:55:45', '2022-05-03 19:55:45'),
('1bdbcb37ddd27a713aebaf0efd46cf20e86d23019306245ebf7e469f4a51ffe2a6832f10f216eb47', 34, 1, 'authToken', '[]', 0, '2021-05-03 19:56:12', '2021-05-03 19:56:12', '2022-05-03 19:56:12'),
('5d14d67191ad00c2f9093d1de35ce30a918e682b770d5af378250719676d30aaa580c683a217144f', 37, 1, 'authToken', '[]', 0, '2021-05-04 17:52:38', '2021-05-04 17:52:38', '2022-05-04 17:52:38'),
('5b3496f1c1a819070b9826193dd336c597f6fc8def764a7ecadc2fe1e0572f6ecda65efe059f37c9', 38, 1, 'authToken', '[]', 0, '2021-05-04 18:51:55', '2021-05-04 18:51:55', '2022-05-04 18:51:55'),
('ceb6ab9be2e8dabbe2f59160d4d659361e4c23f346f7994acfe30effee971f0b23a430b3f4c16957', 38, 1, 'authToken', '[]', 0, '2021-05-04 18:52:45', '2021-05-04 18:52:45', '2022-05-04 18:52:45'),
('914dd61787e6cfd7aea91c61a64ccd87a921a6a3a286349542e95332b82e6a91e581534e1c2a75f7', 37, 1, 'authToken', '[]', 0, '2021-05-05 15:45:53', '2021-05-05 15:45:53', '2022-05-05 15:45:53'),
('7193bbeb9e0e99b0a51149c06b62618e7a6cbc183f319bc7277b7e75d26b16965f0c44bfd6b78d0e', 37, 1, 'authToken', '[]', 0, '2021-05-05 15:57:07', '2021-05-05 15:57:07', '2022-05-05 15:57:07'),
('c8c97fce0fc4af1093349d0b60fd8830be96a949531880bc5f7d39227b971a4ae916479f4eb018f8', 37, 1, 'authToken', '[]', 0, '2021-05-05 16:02:30', '2021-05-05 16:02:30', '2022-05-05 16:02:30'),
('87a827162a2bcc9055b4a3264880070573575735a08bb84f19fb158c030b8d9a2837e6e0ec405702', 37, 1, 'authToken', '[]', 0, '2021-05-05 16:37:25', '2021-05-05 16:37:25', '2022-05-05 16:37:25'),
('abb34b753c8cdae3719c90f82b606a526f3d91bddc14c1709cdcd852502d8d4722425878e9686676', 37, 1, 'authToken', '[]', 0, '2021-05-05 16:44:19', '2021-05-05 16:44:19', '2022-05-05 16:44:19'),
('cec05cee9cfdaca7dd31d0cd6f55efd2fb440beba5d5b6ff5d0bf1cf4d9e02851ec2978f614c0c53', 37, 1, 'authToken', '[]', 0, '2021-05-05 16:48:45', '2021-05-05 16:48:45', '2022-05-05 16:48:45'),
('8010610bb75859f4c9510455c6917b2ca85e8f0a58921839303e2914dd789b8f7775a9ccac6123c6', 37, 1, 'authToken', '[]', 0, '2021-05-05 16:49:28', '2021-05-05 16:49:28', '2022-05-05 16:49:28'),
('1becfa5cb55ed132390260f721a1a8996e8f38ca7f2aa9002a615bff823afb6e3815f4bbc4d68b4e', 37, 1, 'authToken', '[]', 0, '2021-05-05 16:59:41', '2021-05-05 16:59:41', '2022-05-05 16:59:41'),
('99a080266dcdc4f1937893b963bd6a7d58f93f49e4504d05ca4f6ca52843c43ca3b7b89e3c99f0d2', 37, 1, 'authToken', '[]', 0, '2021-05-05 17:01:49', '2021-05-05 17:01:49', '2022-05-05 17:01:49'),
('2fa37d25bcc667c77698f3523f400af6825d6e5e02cbfee0b994b2263908042c6e3cffebf4fe5c88', 37, 1, 'authToken', '[]', 0, '2021-05-05 17:02:30', '2021-05-05 17:02:30', '2022-05-05 17:02:30'),
('66cb1e0169885ad4559ca1e18288ded64c383c5e5218b667a6462bd31d4a7eb7e9fb18bdb1f0fd75', 37, 1, 'authToken', '[]', 0, '2021-05-05 17:05:01', '2021-05-05 17:05:01', '2022-05-05 17:05:01'),
('a2b332abfac56539375787e4cd7fe0091b3c006b6522b8f4df6490d5252cbf1d53940885518e5228', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:10:01', '2021-05-05 18:10:01', '2022-05-05 18:10:01'),
('9b00d9c7d3e7bdeea504ec7c377af4fa7cac462c5644f059faf1e7180eb5f6649497b6099fc1c62b', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:10:35', '2021-05-05 18:10:35', '2022-05-05 18:10:35'),
('9b590203cb6634f8fdbb1ceb9416a1f23f05468361e941c2f81009ac0debc8fd79ed98db84d65213', 2, 1, 'authToken', '[]', 0, '2021-05-05 18:27:59', '2021-05-05 18:27:59', '2022-05-05 18:27:59'),
('925dd837cfd5bfdf989740b5a044ee2ccb89ca8a2b6b6023ec35246dc113308944e3391914e37672', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:29:25', '2021-05-05 18:29:25', '2022-05-05 18:29:25'),
('a29e2f9075eb8b858cd3e1eac4f6f4caf4bf50bcc24e4aa8d5f0ae15b12a9fd9e614b07bcd4e545d', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:30:12', '2021-05-05 18:30:12', '2022-05-05 18:30:12'),
('a7f8f3998a19e77b8af8f608c0918ff543a23005e753f5d390dc256be1e9023f6bb1228cd53aa85a', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:31:02', '2021-05-05 18:31:02', '2022-05-05 18:31:02'),
('f751ef28488759910454635771aea4a6df9e0ff13f5b11f9a44197546b6541e4e7f1772520207dd8', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:31:26', '2021-05-05 18:31:26', '2022-05-05 18:31:26'),
('4363956ae5c64c328b6328ec1e2d7fa26baca2bddaaac508c78bee75b84279e1901d60a3aea1d391', 1, 1, 'authToken', '[]', 0, '2021-05-05 18:43:40', '2021-05-05 18:43:40', '2022-05-05 18:43:40'),
('4c3be8249bf09268b855ba6230e0dfa533d46622ea2d191e57cae85651d359a29565e3a4ddcde223', 1, 1, 'authToken', '[]', 0, '2021-05-05 19:22:45', '2021-05-05 19:22:45', '2022-05-05 19:22:45'),
('03b08d05916c9e0aaf38514ae66cd881abe0b50ce1d379cac0240d42668aea2b3d8f4dcc63c3ad7e', 3, 1, 'authToken', '[]', 0, '2021-05-06 01:16:06', '2021-05-06 01:16:06', '2022-05-06 01:16:06'),
('3750b723b65742fd1318793f0fd1844c2ec3e8c4d8e894ec2b05e2898286b3210992513b299b0e37', 3, 1, 'authToken', '[]', 0, '2021-05-06 01:16:53', '2021-05-06 01:16:53', '2022-05-06 01:16:53'),
('04f734ceb4507a41a2c5a393c979fd2a92669c773865fbb97a0bb5feb34eb599d2ed619572a840cc', 3, 1, 'authToken', '[]', 0, '2021-05-06 01:18:26', '2021-05-06 01:18:26', '2022-05-06 01:18:26'),
('8af160c0d04fc4d69070e988bbc8149928b5c11e8f8e96e8e336f656f0377a77d0924da0be806191', 4, 1, 'authToken', '[]', 0, '2021-05-06 15:04:37', '2021-05-06 15:04:37', '2022-05-06 15:04:37'),
('f5aede3f49a9a4bd974b37a85d17d03858319d18be981a80cd108ccd06bbf11f2b0f750a185ddd46', 4, 1, 'authToken', '[]', 0, '2021-05-06 15:04:58', '2021-05-06 15:04:58', '2022-05-06 15:04:58'),
('6492e36b24fa5dca34bec4d813b730de53ca915f2ed88b197c01572406e77fe3a093834ad3de58d8', 1, 1, 'authToken', '[]', 0, '2021-05-08 05:20:57', '2021-05-08 05:20:57', '2022-05-08 05:20:57'),
('9c560d5e19218e1d4a6db04a715198654dbdbc3e33414ca0986ee71f1b2c75634d918f82dd71f9f4', 1, 1, 'authToken', '[]', 0, '2021-05-08 13:18:49', '2021-05-08 13:18:49', '2022-05-08 13:18:49'),
('d41cf33828972e0c7b9721e882bdb409d1d7481bd88a20df788c61df2f34ee8aef080c343614834b', 1, 1, 'authToken', '[]', 0, '2021-05-14 18:36:56', '2021-05-14 18:36:56', '2022-05-14 18:36:56'),
('57b9681beb4c51fee2d70843ce9650658c28a22408671abc20759c74f495955e4f1ae74ed3871792', 1, 1, 'authToken', '[]', 0, '2021-05-14 18:37:08', '2021-05-14 18:37:08', '2022-05-14 18:37:08'),
('fc3d68ad32a1b6481f08a49fc35a7403880711cde428c693ac9ea885483a177b0178cbe3bf6a7932', 1, 1, 'authToken', '[]', 0, '2021-05-14 18:37:25', '2021-05-14 18:37:25', '2022-05-14 18:37:25'),
('01592600331cab50e8bac84554cc00f5c444f8cfd26d64186bbc8f9e1fcad94a72f3d06bfd807a42', 1, 1, 'authToken', '[]', 0, '2021-05-14 18:37:58', '2021-05-14 18:37:58', '2022-05-14 18:37:58'),
('e8a59ef7f651432f35f1673469162d1e3381458b45e8427ce32ac1fa1ba97989fd6392b09fdbadab', 6, 1, 'authToken', '[]', 0, '2021-05-15 18:14:43', '2021-05-15 18:14:43', '2022-05-15 18:14:43'),
('431a5f70f6183d7b7373c46c63233c74f02a6ccb41df7b3c32d555dab5e2618c4d4ed23229cdd4db', 1, 1, 'authToken', '[]', 0, '2021-05-15 18:15:19', '2021-05-15 18:15:19', '2022-05-15 18:15:19'),
('d7e51df5f1aec1f84d6f345c70aa92bfcb4cd92326a40017aed177a0bea9d14135429b6634f5e745', 1, 1, 'authToken', '[]', 0, '2021-05-15 18:18:56', '2021-05-15 18:18:56', '2022-05-15 18:18:56'),
('3da2f22d1f2fdc65e98286c22db6f3d69ca8a6dda4daf504f010dcb7f3170cc0dcc55d17409d4eac', 1, 1, 'authToken', '[]', 0, '2021-05-16 17:37:17', '2021-05-16 17:37:17', '2022-05-16 17:37:17'),
('dbfc2343e7dbb15ae627d2b02ce441c50b19f5301046bf160d944b19bbb5fb91b6c14fef8f24dafe', 1, 1, 'authToken', '[]', 0, '2021-05-16 19:26:22', '2021-05-16 19:26:22', '2022-05-16 19:26:22'),
('1834fbd8793aa5cd156e4d88711ced3dbf84b1483399ee5a58daf39cee0e025387af8f381ffcfe75', 7, 1, 'authToken', '[]', 0, '2021-05-18 02:49:13', '2021-05-18 02:49:13', '2022-05-18 02:49:13'),
('44d399a27809397b051c7d827457c3edfe435f29ef55a032240e5217959fb8e9a990cc8c266d1d9a', 1, 1, 'authToken', '[]', 0, '2021-05-23 17:46:18', '2021-05-23 17:46:18', '2022-05-23 17:46:18'),
('a63195a72b0a91a91ca055de58d0e1facd0d7e3219ae7b10fed7e1b2f989ecfe4a4e15dedfef9fdb', 1, 1, 'authToken', '[]', 0, '2021-05-23 17:50:38', '2021-05-23 17:50:38', '2022-05-23 17:50:38'),
('46924c2650e739ccfb2336a5e9db092b551efedf016a5e32ad3c58c51392b273f2fb7ee6bc7a0ecf', 1, 1, 'authToken', '[]', 0, '2021-05-24 18:47:26', '2021-05-24 18:47:26', '2022-05-24 18:47:26'),
('d7903ad2ada6d50f151d1c25fe7425739baedb5d244d6ff2ad633399fab1e521c42bc122900020c5', 1, 1, 'authToken', '[]', 0, '2021-05-24 19:20:14', '2021-05-24 19:20:14', '2022-05-24 19:20:14'),
('4675bd9bf0bd0605be6031f2d67ea38c35a1ac054474a4c05bb76464a0d65dc9292dbe21d86a6824', 3, 1, 'authToken', '[]', 0, '2021-05-26 05:25:11', '2021-05-26 05:25:11', '2022-05-26 05:25:11'),
('40d64c9360d7e60455931e8624f9adb1b6fc7ead94e3c1dc667aee36b3dfebeed350a380d545f733', 4, 1, 'authToken', '[]', 0, '2021-05-31 09:56:11', '2021-05-31 09:56:11', '2022-05-31 09:56:11'),
('38ce37faa2548da87bd37af6e336166f6a7f91bee11984ac85944342576611102ed5b1e567649425', 4, 1, 'authToken', '[]', 0, '2021-05-31 09:57:34', '2021-05-31 09:57:34', '2022-05-31 09:57:34'),
('997bf81fc2ac7314c0dcf2f155fb6894d953c6de4824aaf3c439d81905ee1e92be80fe4020210f53', 4, 1, 'authToken', '[]', 0, '2021-05-31 10:06:17', '2021-05-31 10:06:17', '2022-05-31 10:06:17'),
('e8f713dace9cd343efe60a2da76dee3b6a181efede007dce4dadb8ced8e7b5cc3f6b23eefa9dd70c', 7, 1, 'authToken', '[]', 0, '2021-05-31 10:08:45', '2021-05-31 10:08:45', '2022-05-31 10:08:45'),
('f8610842e7f74cd14e99ba0102f316e41acf2f3ec4b08bfa834fc4b9baa148e9a384359e8429718f', 4, 1, 'authToken', '[]', 0, '2021-05-31 10:09:49', '2021-05-31 10:09:49', '2022-05-31 10:09:49'),
('4f6f9e52781c2595af0962b203dc54b1a73e2c038cad63408af505ef98e93be1120ecce051d1be7d', 4, 1, 'authToken', '[]', 0, '2021-05-31 10:15:22', '2021-05-31 10:15:22', '2022-05-31 10:15:22'),
('011dc6803dcfa3978a94934f0b5cc600c26a2309a3224ba2ddc954ec5772310ecc6593a74dd05dae', 7, 1, 'authToken', '[]', 0, '2021-05-31 11:09:36', '2021-05-31 11:09:36', '2022-05-31 11:09:36'),
('eb702d2c7791bf873b41ac89092f16fc270d96a7a20850b9cc982a9338becac1ffad9915724fe3af', 4, 1, 'authToken', '[]', 0, '2021-05-31 18:42:12', '2021-05-31 18:42:12', '2022-05-31 18:42:12'),
('b335fa87a14aebf4e6253291e76996b7cd137ee603b71e4e726d7b3808aae8e3c4b052ac8b9255c1', 4, 1, 'authToken', '[]', 0, '2021-06-01 12:36:28', '2021-06-01 12:36:28', '2022-06-01 12:36:28'),
('541c26a19ae138f1d8b43f51feed8e458cfa6a07701586d6b4ccaaa0540614cd671aa58c5384384a', 4, 1, 'authToken', '[]', 0, '2021-06-04 14:05:22', '2021-06-04 14:05:22', '2022-06-04 14:05:22'),
('097aeda16c97e794879276ed300c6694e65f7b9bc5a26d322f9e340008daffbb0ddde25a4bf5e603', 1, 1, 'authToken', '[]', 0, '2021-06-05 19:51:51', '2021-06-05 19:51:51', '2022-06-05 19:51:51'),
('5d8fcc8e2e299f3ff32638b34b3b5d472ea5f824c70c2763fefdcd7dab5aa6697c8cbca6dc3f9c71', 1, 1, 'authToken', '[]', 0, '2021-06-05 20:05:30', '2021-06-05 20:05:30', '2022-06-05 20:05:30'),
('a4c89eb10865b5acea53614555f393cd3d7b2b07274d9551414be18570692e0181235b99860d3daa', 1, 1, 'authToken', '[]', 0, '2021-06-05 20:14:24', '2021-06-05 20:14:24', '2022-06-05 20:14:24'),
('13ddcc31137dcbc1583422160a12cd88bf0b96c5a8416f242fe54440178a2d832a3b9777e4347161', 1, 1, 'authToken', '[]', 0, '2021-06-09 19:00:26', '2021-06-09 19:00:26', '2022-06-09 19:00:26'),
('6b7d87881993c181c11cd18580a66134abe19c09a6433419c776bf0ec00592a3eb4a6ee68dca470d', 1, 1, 'authToken', '[]', 0, '2021-06-10 17:46:24', '2021-06-10 17:46:24', '2022-06-10 17:46:24'),
('7417220e1d36a89661d3b206710d0bcff9e8d0135233805ca97b1cf15e1c2fcd7ba99d893bcf14bc', 1, 1, 'authToken', '[]', 0, '2021-06-10 19:06:13', '2021-06-10 19:06:13', '2022-06-10 19:06:13'),
('d762a35269d0ae00fa6a328491b54edc45703ee06161491a4a3bf98ab6561a1ee81301aff8595986', 7, 1, 'authToken', '[]', 0, '2021-06-12 14:31:10', '2021-06-12 14:31:10', '2022-06-12 14:31:10'),
('f6bf27db4f55db63c16975a3e56e5619fa440954305bce8e309dedcb2c363c5f6976588d2af2dc18', 1, 1, 'authToken', '[]', 0, '2021-06-13 19:44:46', '2021-06-13 19:44:46', '2022-06-13 19:44:46'),
('5f7e5bd4d3207954636565639a1e1752eb431255af127ed5e93ee0d559f742e0b401314b3666b508', 1, 1, 'authToken', '[]', 0, '2021-06-13 19:46:01', '2021-06-13 19:46:01', '2022-06-13 19:46:01'),
('2284ccdbafc35eb8a89c8af87f6eb83119f0b8fdef3388a19f04b4896f0ecb1f0364b6862fc89f50', 1, 1, 'authToken', '[]', 0, '2021-06-13 19:47:47', '2021-06-13 19:47:47', '2022-06-13 19:47:47'),
('4fc8349f7cfd8884f5487d30ddc0981b799cdf2a55e989c39fde3dac1a8611520d85aa37f0e3055b', 1, 1, 'authToken', '[]', 0, '2021-06-15 17:29:42', '2021-06-15 17:29:42', '2022-06-15 17:29:42'),
('bdcb97cfb683bf847b077a31f1f655cf840a0c3799d28a6cabab594656892b890418995e29370d1b', 1, 1, 'authToken', '[]', 0, '2021-06-15 17:35:42', '2021-06-15 17:35:42', '2022-06-15 17:35:42'),
('a5cc03f4184e25c44e9dc092adad7ab24910f7cd88469459d7f20a02947a97c7aee2a3159f18cab9', 3, 1, 'authToken', '[]', 0, '2021-06-16 04:51:52', '2021-06-16 04:51:52', '2022-06-16 04:51:52'),
('2a2b03a1ae20c408ec667d87efad1c5b483fe7fd7d403d544a6699eea937f23d9e42eb76f3219be4', 3, 1, 'authToken', '[]', 0, '2021-06-16 04:53:16', '2021-06-16 04:53:16', '2022-06-16 04:53:16'),
('8b548047e623dc2e05b6672bb3250d5155461511911c0d93ec3566346d1eebb4c295ceb23850887b', 7, 1, 'authToken', '[]', 0, '2021-06-17 17:49:55', '2021-06-17 17:49:55', '2022-06-17 17:49:55'),
('9b4e11de5061333a9ba52d96e520deb2f165cdf3803ba45d4e06f09beeed7974c49ee9601f7c43be', 1, 1, 'authToken', '[]', 0, '2021-06-17 19:04:08', '2021-06-17 19:04:08', '2022-06-17 19:04:08'),
('0a755d8bd19e9dbc15bd3b9406f64ac484295b262694125925bd48b99daf8032ece38742c4971553', 4, 1, 'authToken', '[]', 0, '2021-06-17 19:12:48', '2021-06-17 19:12:48', '2022-06-17 19:12:48'),
('2e2303f33d522fd26dea4e6eb489a7aada5d7a9199195467ff8be76e737c875c14ef5b30276e8a90', 1, 1, 'authToken', '[]', 0, '2021-06-23 18:22:59', '2021-06-23 18:22:59', '2022-06-23 18:22:59'),
('7a8dd3a030ae4efe78b41e07327727f7102d52235cdcc992c882a2b7427f1f23339327a26639de5d', 1, 1, 'authToken', '[]', 0, '2021-06-23 18:24:55', '2021-06-23 18:24:55', '2022-06-23 18:24:55'),
('92cb11ec260d9f4444f85013499e4ac2f7ed5a1b874a95d666ac3f714c6897fd399856fcbc35e6dd', 1, 1, 'authToken', '[]', 0, '2021-06-23 18:25:36', '2021-06-23 18:25:36', '2022-06-23 18:25:36'),
('fd5f132e91782fdb7a21095e2ac311f4d5c46feb866aba62568bd0e94a7cf721a9f588ad6e850f0e', 1, 1, 'authToken', '[]', 0, '2021-06-23 18:26:19', '2021-06-23 18:26:19', '2022-06-23 18:26:19'),
('152a0a3dfa4882802ea7deea7f3fff1a98a571caaf99f1b316848340bb3e2c14531a909c0d05b203', 1, 1, 'authToken', '[]', 0, '2021-06-24 20:45:39', '2021-06-24 20:45:39', '2022-06-24 20:45:39'),
('ccacb1b1c24b5df63b6ba79532b19d258d8fb164a9faee64eef9bd5ec6737d55b0a0562570229049', 1, 1, 'authToken', '[]', 0, '2021-06-28 17:05:09', '2021-06-28 17:05:09', '2022-06-28 17:05:09'),
('094721011fe5ddc3a8288ed86b710124821dbe70bd6efa45ef13d1eb4419ebb5af01065d67a0993c', 7, 1, 'authToken', '[]', 0, '2021-06-28 18:02:41', '2021-06-28 18:02:41', '2022-06-28 18:02:41'),
('57b40e2e27f5c92267baf0486738975a89c46ce7139922c8b69bd5b0c47e319b3447b9c0bd2905cf', 8, 1, 'authToken', '[]', 0, '2021-06-29 06:07:53', '2021-06-29 06:07:53', '2022-06-29 06:07:53'),
('e5512803b4ee0f9970f3ca4e07a1edba7187171a32a50a38611b1a6160d407200434be4b09b85e8b', 8, 1, 'authToken', '[]', 0, '2021-06-29 06:08:21', '2021-06-29 06:08:21', '2022-06-29 06:08:21'),
('7cf2d4b2ff6e9e7829c68dca3ed0ab4652574e51f18f2762993ed5a01e707f4af0102d80dd28af52', 7, 1, 'authToken', '[]', 0, '2021-06-29 17:13:37', '2021-06-29 17:13:37', '2022-06-29 17:13:37'),
('a7fc6e7604d194f87b6bd698d918e4e0429988f3ccc77ae298935c142b6c096151f86b8e92985eb6', 7, 1, 'authToken', '[]', 0, '2021-06-29 17:28:56', '2021-06-29 17:28:56', '2022-06-29 17:28:56'),
('908d4dd021590c44eda11a930bed725bc3d557620e7f1df9443ad982d5c8674bff2c460af27f9713', 7, 1, 'authToken', '[]', 0, '2021-07-03 17:56:10', '2021-07-03 17:56:10', '2022-07-03 17:56:10'),
('cdd1071d83de39a2930e91825aaffb6cb9e860669d54d059112e898c05090b03d84624d2afb2deef', 1, 1, 'authToken', '[]', 0, '2021-07-03 18:38:24', '2021-07-03 18:38:24', '2022-07-03 18:38:24'),
('6be903452e63398c31f94c7bc88f4a6e653f702cf7a5ef2ba5ff6cb1a5d77db42dddfeeeb317d1c1', 1, 1, 'authToken', '[]', 0, '2021-07-03 18:47:18', '2021-07-03 18:47:18', '2022-07-03 18:47:18'),
('f9ee3abad3ecc6228fcaffb2d25b97766edd09578f7fede35b97e8e4763e463e138a2dc9a7d4e17f', 1, 1, 'authToken', '[]', 0, '2021-07-03 18:49:19', '2021-07-03 18:49:19', '2022-07-03 18:49:19'),
('ad848edfdd1ca822bd564c4633dc3444b15fe21f402beeb7ba1ba1d6ed87232b43db0d9401b231ac', 1, 1, 'authToken', '[]', 0, '2021-07-03 18:52:17', '2021-07-03 18:52:17', '2022-07-03 18:52:17'),
('68a0cfa4a2750dc09b4c41dbd3bf1f94b3744a048b401cb60ec473f5c493a6e646905a9ffa706b27', 1, 1, 'authToken', '[]', 0, '2021-07-03 18:56:07', '2021-07-03 18:56:07', '2022-07-03 18:56:07'),
('82065d2a5b548f94324c5ef1ce0de51f313dacfa282d64bb4a15b01d631d0ad09d3d06135bf2e0a8', 1, 1, 'authToken', '[]', 0, '2021-07-03 18:56:40', '2021-07-03 18:56:40', '2022-07-03 18:56:40'),
('47712af461fa035a789de212499c4ad0ac400039258039db1adf50f638cc322cf95c6c7dfa19fa7c', 7, 1, 'authToken', '[]', 0, '2021-07-04 09:11:15', '2021-07-04 09:11:15', '2022-07-04 09:11:15'),
('84a258c8bbd97f4fdc943c211f5758553908ff1ccc8c459a90c1b7ab65eb714dc91732a21d990a77', 7, 1, 'authToken', '[]', 0, '2021-07-04 09:13:58', '2021-07-04 09:13:58', '2022-07-04 09:13:58'),
('cf2064916a3997b6a63551a05c4894124600a08113299034e1f50a82dfcc5b714d2260593445f228', 1, 1, 'authToken', '[]', 0, '2021-07-04 09:19:24', '2021-07-04 09:19:24', '2022-07-04 09:19:24'),
('aa0ba7be2ed01de1099c432011d44a65ac634e50fe02044deea31f67722ce5f4f018d6de9624931d', 1, 1, 'authToken', '[]', 0, '2021-07-04 09:20:07', '2021-07-04 09:20:07', '2022-07-04 09:20:07'),
('f8813087fcad11027a35c5b0c27c9fa865e7405e7b5d050d2e7695aa8aef49f856d6e1ba1e086a8b', 1, 1, 'authToken', '[]', 0, '2021-07-04 09:26:08', '2021-07-04 09:26:08', '2022-07-04 09:26:08'),
('48973b1a3e34da15fad39938c41ea35e81b563bc56ed0f939e2e3f91674f51fbcbfce3550051beba', 1, 1, 'authToken', '[]', 0, '2021-07-04 09:35:11', '2021-07-04 09:35:11', '2022-07-04 09:35:11'),
('0e75f50807bff01ef65ebff9edc6ba8b9c2246445e7d2f10b0504a7db8825eeafa5a78fe18e2519f', 1, 1, 'authToken', '[]', 0, '2021-07-04 09:35:54', '2021-07-04 09:35:54', '2022-07-04 09:35:54'),
('2610e920b6c4db9ab9e505b5cd918bd95cfb1be23c7a1592111342bf1adf7726698f604e76976e2c', 7, 1, 'authToken', '[]', 0, '2021-07-04 09:37:56', '2021-07-04 09:37:56', '2022-07-04 09:37:56'),
('77808d7db1889007da00e23ffaa0e9f9a9f64bc8e26600700259c361bd936a5fccb9fa6e980b3a94', 7, 1, 'authToken', '[]', 0, '2021-07-04 10:09:57', '2021-07-04 10:09:57', '2022-07-04 10:09:57'),
('97d978c3eee32fda5e76839fc1e232aabe41dcad0f16e3bf7941e763b931088f458441a6bbd8da56', 7, 1, 'authToken', '[]', 0, '2021-07-04 10:29:10', '2021-07-04 10:29:10', '2022-07-04 10:29:10'),
('34ca6ca384c58869bf1d44187234c00a7b32251041be64c59235ccb142fbdf2e5627f61eccd78d3d', 1, 1, 'authToken', '[]', 0, '2021-07-04 17:02:19', '2021-07-04 17:02:19', '2022-07-04 17:02:19'),
('67a06319832557661241d809595983d4f213ff95881d19abe48231f9e9245c48b95ba7a602510b5d', 1, 1, 'authToken', '[]', 0, '2021-07-04 17:09:10', '2021-07-04 17:09:10', '2022-07-04 17:09:10'),
('02220d6993af8694f618cba179d6263bc823d6835d0ece281f4a9ec3ada35191c838938528538873', 1, 1, 'authToken', '[]', 0, '2021-07-04 18:17:42', '2021-07-04 18:17:42', '2022-07-04 18:17:42'),
('8f7b8aa98efd60d33b29da06a051f477b43adc35ea66275cb9cd9a12d20c59c93b88333feeab7b42', 1, 1, 'authToken', '[]', 0, '2021-07-04 18:46:49', '2021-07-04 18:46:49', '2022-07-04 18:46:49'),
('ffd724d3ff2e7efc68e73df6dea2183d100917c4e8fc161d7ef17f57d4a37ca84cac1055af5b3827', 9, 1, 'authToken', '[]', 0, '2021-07-07 06:47:56', '2021-07-07 06:47:56', '2022-07-07 06:47:56'),
('769cbd3991b8c7e8fe4ca865d974bd1d282ba720058d48e8724583373bf13a680dee65c6a2f37bf0', 9, 1, 'authToken', '[]', 0, '2021-07-07 06:48:10', '2021-07-07 06:48:10', '2022-07-07 06:48:10'),
('d9b923339d3993be90dc8ea748236589d1acd6b297c8f8ccc3e3dd3955343b828e12dec43e24e0b7', 4, 1, 'authToken', '[]', 0, '2021-07-07 06:56:20', '2021-07-07 06:56:20', '2022-07-07 06:56:20'),
('7fe9f71d00b51bc3e51c562c51547f3cc82063be781b59ce3a496d43cc6965631bef4297c6ad8850', 7, 1, 'authToken', '[]', 0, '2021-07-17 12:56:38', '2021-07-17 12:56:38', '2022-07-17 12:56:38'),
('f6c5fd8faa93d1ff025be77ca00b767be6062b4782ae76dd6aee324bf725686de26685dabea06602', 1, 1, 'authToken', '[]', 0, '2021-07-17 19:26:59', '2021-07-17 19:26:59', '2022-07-17 19:26:59'),
('f9cd2675275391e4b4bb2dab86f62a32bc7572b853fc041250bf53080f092164422f2baec0819fc0', 1, 1, 'authToken', '[]', 0, '2021-07-17 19:32:00', '2021-07-17 19:32:00', '2022-07-17 19:32:00'),
('e85ada8e455e7d092224e623111b47b361d0eec7d6a7b2ebaad062119a222644428212c9cdb6d844', 1, 1, 'authToken', '[]', 0, '2021-07-22 07:37:03', '2021-07-22 07:37:03', '2022-07-22 07:37:03'),
('5a12684d3ccddf85b7d1e649a4ce2145ee01dae4884f331af43d2be50acbcb8ec07065a1f61f59c7', 1, 1, 'authToken', '[]', 0, '2021-07-22 07:43:19', '2021-07-22 07:43:19', '2022-07-22 07:43:19'),
('f61ac8f08cc3f2ed7672ac715bcf0bb80dd79bc9153719b7dedfc4e53d9ccc4824c72db238266169', 11, 1, 'authToken', '[]', 0, '2021-07-22 07:45:37', '2021-07-22 07:45:37', '2022-07-22 07:45:37'),
('210697ea3a333308b3e2efe3e2dfa302cac0c9805a84e9fd28c33ed8081f9469cf204cd9c4176fae', 11, 1, 'authToken', '[]', 0, '2021-07-22 07:46:00', '2021-07-22 07:46:00', '2022-07-22 07:46:00'),
('e5074239b60291035428a66554b0a58aaf9346bded0ce10d6d90f958710199cfc7b82bfca7131bf3', 1, 1, 'authToken', '[]', 0, '2021-07-31 19:29:47', '2021-07-31 19:29:47', '2022-07-31 19:29:47'),
('7d7db027f80d41d56f18a97e772b2a029e544f62c0ee0e1f8094120d09607cfc915b66e506a92518', 1, 1, 'authToken', '[]', 0, '2021-08-06 19:34:10', '2021-08-06 19:34:10', '2022-08-06 19:34:10'),
('904d9907726e40d80449cf75f51745248775105ea8195c0363406dcfb888c8311e1ce2b18cd37af9', 12, 1, 'authToken', '[]', 0, '2021-08-07 19:07:46', '2021-08-07 19:07:46', '2022-08-07 19:07:46'),
('946f44125160d67e9cef01478b2b6f67fd6bc58987571242d8bbced3f805a15340f9620d10df109d', 7, 1, 'authToken', '[]', 0, '2021-08-07 19:12:25', '2021-08-07 19:12:25', '2022-08-07 19:12:25'),
('8eb290eff278da29d0b390c6abb3fea65f01609fdd72002432a5dea8180e3d844e6c53c131fcf281', 7, 1, 'authToken', '[]', 0, '2021-08-08 17:06:27', '2021-08-08 17:06:27', '2022-08-08 17:06:27'),
('1cbca43b1f49e73905aa64a4cc93f9000ba65912a072a84623a948b762ee1791309cf2e410ff850f', 7, 1, 'authToken', '[]', 0, '2021-08-11 18:52:01', '2021-08-11 18:52:01', '2022-08-11 18:52:01'),
('8ed919bb14dc413f40253933807c439f4fb015d0d020090cac6ccc4d95a9a2d7f2f794bf954e9423', 1, 1, 'authToken', '[]', 0, '2021-08-12 10:13:32', '2021-08-12 10:13:32', '2022-08-12 10:13:32'),
('e1a82eaa8e67ea702e80a34eae9db53e58041e4285bd062dab96aa9a98c51c97594d42b6bf4badde', 1, 1, 'authToken', '[]', 0, '2021-08-13 19:17:47', '2021-08-13 19:17:47', '2022-08-13 19:17:47'),
('6f2a2afabc78fca25f72047828d5d292603b2e00a425c6f697f4913b80310797ed3f0e8b9ade046a', 1, 1, 'authToken', '[]', 0, '2021-08-14 10:41:38', '2021-08-14 10:41:38', '2022-08-14 10:41:38'),
('a57e67e86c719f99be3fb47c13627c06495fd8c48fb9f44e7ca0962e44613932a3b227b5019b03d1', 1, 1, 'authToken', '[]', 0, '2021-08-14 10:45:33', '2021-08-14 10:45:33', '2022-08-14 10:45:33'),
('d576b6f7aa36e564578cfc7acb42eddfb09bf9783d564df310e64b55cbd080e8d3e39d8873f3235f', 1, 1, 'authToken', '[]', 0, '2021-08-14 10:51:39', '2021-08-14 10:51:39', '2022-08-14 10:51:39'),
('2ec2f9f652dcfb03c85da3008b14cc99fd260e07053e3b1109660aa7e7bd4a828a81aac3076a135d', 7, 1, 'authToken', '[]', 0, '2021-08-14 12:45:19', '2021-08-14 12:45:19', '2022-08-14 12:45:19'),
('f38ec2237f2c271211f3d7de6440a72f90d90f79f1d5c512a8d463678ca64b2b894a83c91691d482', 1, 1, 'authToken', '[]', 0, '2021-08-14 12:45:31', '2021-08-14 12:45:31', '2022-08-14 12:45:31'),
('34088d937eb0b837d108b3708aad5e251620363b708d634ff4f6075ca9990567949f5af276afbccf', 1, 1, 'authToken', '[]', 0, '2021-08-14 12:46:27', '2021-08-14 12:46:27', '2022-08-14 12:46:27'),
('4a15eb3d4b49dd506f45958b31fd834b572d163ef778812e70c021d69c402c1f2cf9ed57869f1109', 1, 1, 'authToken', '[]', 0, '2021-08-14 18:31:25', '2021-08-14 18:31:25', '2022-08-14 18:31:25'),
('233a7cad891811b7f35cd446100d1095c2536f3c27a93a2372be2541ba1df3595154879e2958dd8e', 1, 1, 'authToken', '[]', 0, '2021-08-14 18:32:40', '2021-08-14 18:32:40', '2022-08-14 18:32:40'),
('43c5ff3ee97c024a06f7c7911e02f1a76eff6a381caa4eb287cc099fc109e926adf9c72a10bcd37c', 1, 1, 'authToken', '[]', 0, '2021-08-14 18:33:38', '2021-08-14 18:33:38', '2022-08-14 18:33:38'),
('4d2b61af8d3d9ac3f365ddb5503c25b56f016cebd5ad72eeec23568f1466c560794a13cf9cd51678', 1, 1, 'authToken', '[]', 0, '2021-08-17 17:04:06', '2021-08-17 17:04:06', '2022-08-17 17:04:06'),
('96d6deeeb3c9f561f20e425b7e738cad421490f8c2fb29f195a1ca4b902b4dddf6546e917f2c31f0', 7, 1, 'authToken', '[]', 0, '2021-08-18 17:12:04', '2021-08-18 17:12:04', '2022-08-18 17:12:04'),
('ebcee7bf3dfdfe8c17569eef8b2d138d0c40e48ad376034f096a939ffbb80f10d7ebb453fe66522b', 7, 1, 'authToken', '[]', 0, '2021-08-18 17:13:08', '2021-08-18 17:13:08', '2022-08-18 17:13:08'),
('5bf3dc166f4638b6a48266371980ffd171c670d37bdfc68c53cd6ad486be2423efd95fb6bef9c78d', 1, 1, 'authToken', '[]', 0, '2021-08-20 19:03:15', '2021-08-20 19:03:15', '2022-08-20 19:03:15'),
('05f0754ac0080c22fd4b444d38750798da878a7fa0fd92c670096cafcc5bc89e20b7c191f39c3fc8', 1, 1, 'authToken', '[]', 0, '2021-08-20 19:47:56', '2021-08-20 19:47:56', '2022-08-20 19:47:56'),
('56d67e5bf53696d58a103ea6db4c935a487bd7624d07cd5674c9aceab923c599d0b5b1342177b2da', 10, 1, 'authToken', '[]', 0, '2021-08-21 07:10:18', '2021-08-21 07:10:18', '2022-08-21 07:10:18'),
('3b13940ce1f9d3d77edd2741213066935274658215e2f6ded25a9379963910cc045c292ac72a2252', 10, 1, 'authToken', '[]', 0, '2021-08-21 07:11:03', '2021-08-21 07:11:03', '2022-08-21 07:11:03'),
('3dd7aab071499ea0a171314c8abd63772724681a45ca811d679186615c131764fd0cd48cd1794895', 3, 1, 'authToken', '[]', 0, '2021-08-21 09:17:13', '2021-08-21 09:17:13', '2022-08-21 09:17:13'),
('e0c23c86b71282569e7ed113b7936290f427a1c1af428c3b4e9841addb101719c58fdfc27dc66669', 3, 1, 'authToken', '[]', 0, '2021-08-21 09:18:09', '2021-08-21 09:18:09', '2022-08-21 09:18:09'),
('64f377f8fbc07cbf22f6c4238355c65d319ea4569f69b58e782ac3f5dde7c491527c2e7a67716015', 7, 1, 'authToken', '[]', 0, '2021-08-25 18:11:50', '2021-08-25 18:11:50', '2022-08-25 18:11:50'),
('09a843c7915dc3d7695088517aed575bf5d829b3004e4da5502e43ab4a917c906af8f32f91d3d273', 1, 1, 'authToken', '[]', 0, '2021-08-28 16:44:46', '2021-08-28 16:44:46', '2022-08-28 16:44:46'),
('b7c2089cd55e42b12657883cc31183cb529afa1113a98926ca83e049a67938ef5f4324a78fd307ac', 1, 1, 'authToken', '[]', 0, '2021-09-01 16:21:38', '2021-09-01 16:21:38', '2022-09-01 16:21:38'),
('d75bf0518f8d5e1a6ed29a9f0fdc07958bbd609e30248bf8fd48d8ea00c6130fdb7a51f7231002a6', 1, 1, 'authToken', '[]', 0, '2021-09-01 18:00:25', '2021-09-01 18:00:25', '2022-09-01 18:00:25'),
('5916702bd1d07d50e2effc0794377849e90d1c7fae5941904174739dde68a274c64b3e2d8cb4cfe4', 10, 1, 'authToken', '[]', 0, '2021-09-01 19:09:35', '2021-09-01 19:09:35', '2022-09-01 19:09:35');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 't53Me85vuOi4K6s7qWBGz1fN4kVBQvjrS0VTd0AL', NULL, 'http://localhost', 1, 0, 0, '2021-04-09 00:08:58', '2021-04-09 00:08:58'),
(2, NULL, 'Laravel Password Grant Client', 'ekcjETnBaQAZOQib5fv9DR3mwp2lYOJNG4Wy0p3k', 'users', 'http://localhost', 0, 1, 0, '2021-04-09 00:08:58', '2021-04-09 00:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-04-09 00:08:58', '2021-04-09 00:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `orderid` text DEFAULT NULL,
  `receipt` text DEFAULT NULL,
  `total_amount` varchar(255) NOT NULL DEFAULT '0',
  `amount_paid` varchar(255) DEFAULT NULL,
  `amount_due` varchar(255) DEFAULT NULL,
  `discount_total` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `payment_id` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `payment_status` char(1) NOT NULL DEFAULT 'P',
  `entity` varchar(255) DEFAULT NULL,
  `offer_id` varchar(255) DEFAULT NULL,
  `attempts` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `order_created_at` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `userid`, `orderid`, `receipt`, `total_amount`, `amount_paid`, `amount_due`, `discount_total`, `grand_total`, `discount`, `currency`, `status`, `payment_id`, `signature`, `payment_status`, `entity`, `offer_id`, `attempts`, `notes`, `order_created_at`, `created_at`, `updated_at`) VALUES
(13, 7, 'order_HiPtV1kKZFwXej', 'ORDER7KETANPATEL0708202119047', '35800', '0', '35800', 'NULL', '35800', NULL, 'INR', 'created', 'pay_HiPuBuI4GtOShW', '0856a509bf2451c4efc11c7e4ce20c2cd568061116fcbbd6a5d7c192676475ea', 'S', 'order', NULL, '0', 'a:0:{}', '1628363028', '2021-08-07 19:03:48', '2021-08-07 19:04:40'),
(11, 7, 'order_HiPl4v0ru2gGZ1', 'ORDER7KETANPATEL0708202118049', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', 'pay_HiPmBTZV8gmGVk', '773e60be2fad1bdbd215793e500713cd22343763e0b5d33861a163fd23256240', 'S', 'order', NULL, '0', 'a:0:{}', '1628362550', '2021-08-07 18:55:50', '2021-08-07 18:56:57'),
(28, 7, 'order_HimT8DgkyegAG8', 'ORDER7KETANPATEL0808202117046', '41950', '0', '33560', '8390', '33560', '20', 'INR', 'created', 'pay_HimULZe7g1wogR', '3c67f54c4c29abc640357f17780c801a2936cd55c983d6272728fb7906c417e2', 'S', 'order', NULL, '0', 'a:0:{}', '1628442528', '2021-08-08 17:08:48', '2021-08-08 17:10:03'),
(27, 1, 'order_Him6RDfD7xVYRX', 'ORDER1KAUSHAL0808202116017', '111750', '0', '89400', '22350', '89400', '20', 'INR', 'created', 'pay_Him6WkqqvnYUz4', '34de250ac6aa8c5819c4ec0a96a051a1eb9cf89b05a91b6d97913fe330e6d823', 'S', 'order', NULL, '0', 'a:0:{}', '1628441239', '2021-08-08 16:47:19', '2021-08-08 16:47:28'),
(26, 1, 'order_Him69TJRDmXe0s', 'ORDER1KAUSHAL0808202116001', '111750', '0', '89400', '22350', '89400', '20', 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628441222', '2021-08-08 16:47:03', '2021-08-08 16:47:03'),
(25, 1, 'order_Him5SnxfPvLgHD', 'ORDER1KAUSHAL0808202116022', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', 'pay_Him5f6ukMLlhVJ', '702cc51c0fec3b2a98eb3f9ef649f701b4c06a34ef671dc82bc7c87cf7b37305', 'S', 'order', NULL, '0', 'a:0:{}', '1628441183', '2021-08-08 16:46:24', '2021-08-08 16:46:38'),
(24, 1, 'order_Him1DmW1XEJqzV', 'ORDER1KAUSHAL0808202116021', '31100', '0', '24880', '6220', '24880', '20', 'INR', 'created', 'pay_Him1NY8PKaD5V5', 'ea12b55d23400750f7a69b7b9e9b8f21447945853271d9b33ac4147497ac3fbd', 'S', 'order', NULL, '0', 'a:0:{}', '1628440942', '2021-08-08 16:42:23', '2021-08-08 16:42:35'),
(22, 1, 'order_trial_0808202116043', 'ORDER_TRIAL_1KAUSHAL0808202116043', '0', NULL, NULL, '0', '0', '0', 'INR', 'created', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2021-08-08 16:31:43', '2021-08-08 16:31:43'),
(23, 1, 'order_trial_0808202116035', 'ORDER_TRIAL_1KAUSHAL0808202116035', '0', NULL, NULL, '0', '0', '0', 'INR', 'created', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2021-08-08 16:41:35', '2021-08-08 16:41:35'),
(29, 4, 'order_HimVySSBH5KN75', 'ORDER4ROHAN0808202117028', '31500', '0', '31500', 'NULL', '31500', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628442689', '2021-08-08 17:11:29', '2021-08-08 17:11:29'),
(30, 7, 'order_trial_0808202117021', 'ORDER_TRIAL_7KETANPATEL0808202117021', '0', NULL, NULL, '0', '0', '0', 'INR', 'created', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2021-08-08 17:12:21', '2021-08-08 17:12:21'),
(31, 4, 'order_HimttUIbWPSz6x', 'ORDER4ROHAN0808202117007', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628444048', '2021-08-08 17:34:08', '2021-08-08 17:34:08'),
(32, 4, 'order_trial_0808202117032', 'ORDER_TRIAL_4ROHAN0808202117032', '0', NULL, NULL, '0', '0', '0', 'INR', 'created', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2021-08-08 17:34:32', '2021-08-08 17:34:32'),
(33, 4, 'order_Himuf19Ig44TBU', 'ORDER4ROHAN0808202117050', '15550', '0', '15550', 'NULL', '15550', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628444091', '2021-08-08 17:34:52', '2021-08-08 17:34:52'),
(34, 4, 'order_Himuyjr8ORvCLf', 'ORDER4ROHAN0808202117008', '15550', '0', '15550', 'NULL', '15550', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628444109', '2021-08-08 17:35:10', '2021-08-08 17:35:10'),
(35, 4, 'order_HimvP2c6B7lc93', 'ORDER4ROHAN0808202117032', '31100', '0', '24880', '6220', '24880', '20', 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628444133', '2021-08-08 17:35:34', '2021-08-08 17:35:34'),
(36, 4, 'order_HiwcY48DdXZHVX', 'ORDER4ROHAN0908202103037', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628478279', '2021-08-09 03:04:39', '2021-08-09 03:04:39'),
(37, 4, 'order_HkYc6MThjGAd86', 'ORDER4ROHAN1308202104034', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628830415', '2021-08-13 04:53:35', '2021-08-13 04:53:35'),
(38, 1, 'order_HkozGuHJke6PUy', 'ORDER1KAUSHAL1308202120035', '91500', '0', '73200', '18300', '73200', '20', 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628888077', '2021-08-13 20:54:37', '2021-08-13 20:54:37'),
(39, 1, 'order_Hl3Nn4QSbtpkJE', 'ORDER1KAUSHAL1408202110031', '26400', '0', '21120', '5280', '21120', '20', 'INR', 'created', 'pay_Hl3O1y2f8h8STh', '6a796f0f6151d74a79f3b4903e0664924fec44b4b2f24f350289f2a3316ffc7b', 'S', 'order', NULL, '0', 'a:0:{}', '1628938772', '2021-08-14 10:59:32', '2021-08-14 10:59:49'),
(40, 4, 'order_HlKeKw1DD9WoFd', 'ORDER4ROHAN1508202103058', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628999579', '2021-08-15 03:52:59', '2021-08-15 03:52:59'),
(41, 4, 'order_HlKhjyDLwR0b66', 'ORDER4ROHAN1508202103011', '110400', '0', '88320', '22080', '88320', '20', 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1628999773', '2021-08-15 03:56:13', '2021-08-15 03:56:13'),
(42, 10, 'order_trial_2108202107012', 'ORDER_TRIAL_10SHAILENDRA2108202107012', '0', NULL, NULL, '0', '0', '0', 'INR', 'created', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:12:12', '2021-08-21 07:12:12'),
(43, 4, 'order_Hodxy9QUV445Sb', 'ORDER4ROHAN2308202112044', '10850', '0', '10850', 'NULL', '10850', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1629722625', '2021-08-23 12:43:46', '2021-08-23 12:43:46'),
(44, 10, 'order_HpFwgbexFo9JiE', 'ORDER10SHAILENDRA2508202101052', '10850', '0', '10850', 'NULL', '10850', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1629856374', '2021-08-25 01:52:54', '2021-08-25 01:52:54'),
(45, 10, 'order_HpFxbKWb3wHWtv', 'ORDER10SHAILENDRA2508202101045', '10850', '0', '10850', 'NULL', '10850', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1629856426', '2021-08-25 01:53:46', '2021-08-25 01:53:46'),
(46, 10, 'order_HpGQVcx6X9v4ly', 'ORDER10SHAILENDRA2508202102007', '18900', '0', '18900', 'NULL', '18900', NULL, 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1629858068', '2021-08-25 02:21:08', '2021-08-25 02:21:08'),
(47, 4, 'order_Hsv6hue7k8c7cC', 'ORDER4ROHAN0309202108048', '26400', '0', '21120', '5280', '21120', '20', 'INR', 'created', NULL, NULL, 'P', 'order', NULL, '0', 'a:0:{}', '1630656350', '2021-09-03 08:05:50', '2021-09-03 08:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `payments_08082021`
--

CREATE TABLE `payments_08082021` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `courseid` int(11) DEFAULT NULL,
  `orderid` text DEFAULT NULL,
  `receipt` text DEFAULT NULL,
  `entity` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `amount_paid` varchar(255) DEFAULT NULL,
  `amount_due` varchar(255) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `offer_id` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `attempts` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `order_created_at` varchar(255) DEFAULT NULL,
  `payment_id` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `razorpay_order_id` text DEFAULT NULL,
  `payment_status` char(1) NOT NULL DEFAULT 'P',
  `moduletype` int(11) DEFAULT NULL,
  `modulename` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `levelname` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments_08082021`
--

INSERT INTO `payments_08082021` (`id`, `userid`, `courseid`, `orderid`, `receipt`, `entity`, `amount`, `amount_paid`, `amount_due`, `currency`, `offer_id`, `status`, `attempts`, `notes`, `order_created_at`, `payment_id`, `signature`, `razorpay_order_id`, `payment_status`, `moduletype`, `modulename`, `level`, `levelname`, `created_at`, `updated_at`) VALUES
(51, 7, 2, 'order_HQzwxKgDMCBA83', 'ORDER7KETANPATEL2406202118000', 'order', '35800', '0', '35800', 'INR', NULL, 'created', '0', 'a:0:{}', '1624559881', NULL, NULL, NULL, 'P', 1, 'Training', 2, 'Intermediate', '2021-06-24 18:38:01', '2021-06-24 18:38:01'),
(70, 7, 1, 'order_HbGn9ecbKOlqlI', 'ORDER7KETANPATEL2007202117031', 'order', '18900', '0', '18900', 'INR', NULL, 'created', '0', 'a:0:{}', '1626802593', NULL, NULL, NULL, 'P', 1, 'Training', 1, 'Beginner', '2021-07-20 17:36:33', '2021-07-20 17:36:33'),
(77, 7, 1, 'order_Hi1rie1nDcuHxU', 'ORDER7KETANPATEL0608202119027', 'order', '18900', '0', '18900', 'INR', NULL, 'created', '0', 'a:0:{}', '1628278408', NULL, NULL, NULL, 'P', 1, 'Training', 1, 'Beginner', '2021-08-06 19:33:29', '2021-08-06 19:33:29'),
(76, 7, 1, 'order_Hi0tT51Jx1spXX', 'ORDER7KETANPATEL0608202118025', 'order', '18900', '0', '18900', 'INR', NULL, 'created', '0', 'a:0:{}', '1628274986', NULL, NULL, NULL, 'P', 1, 'Training', 1, 'Beginner', '2021-08-06 18:36:26', '2021-08-06 18:36:26'),
(75, 1, 1, 'order_Hi0r91OXv2xH3Z', 'ORDER1KAUSHAL0608202118013', 'order', '18900', '0', '18900', 'INR', NULL, 'created', '0', 'a:0:{}', '1628274854', NULL, NULL, NULL, 'P', 1, 'Training', 1, 'Beginner', '2021-08-06 18:34:14', '2021-08-06 18:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `payments_history`
--

CREATE TABLE `payments_history` (
  `id` int(11) NOT NULL,
  `paymentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `courseid` int(11) DEFAULT NULL,
  `total_amount` varchar(255) NOT NULL DEFAULT '0',
  `discount_total` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `payment_status` char(1) NOT NULL DEFAULT 'P',
  `package_startdate` datetime DEFAULT NULL,
  `package_enddate` datetime DEFAULT NULL,
  `course_title` varchar(255) DEFAULT NULL,
  `course_duration` varchar(100) DEFAULT NULL,
  `moduletype` int(11) DEFAULT NULL,
  `modulename` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `levelname` varchar(255) DEFAULT NULL,
  `course_trial` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments_history`
--

INSERT INTO `payments_history` (`id`, `paymentid`, `userid`, `courseid`, `total_amount`, `discount_total`, `grand_total`, `currency`, `discount`, `payment_status`, `package_startdate`, `package_enddate`, `course_title`, `course_duration`, `moduletype`, `modulename`, `level`, `levelname`, `course_trial`, `created_at`, `updated_at`) VALUES
(34, 11, 7, 1, '18900', NULL, '18900', 'INR', NULL, 'S', '2021-08-07 18:56:57', '2021-09-06 18:56:57', 'Basic Price Analysis Course', '30', 1, 'Training', 1, 'Beginner', NULL, '2021-08-07 18:55:50', '2021-08-07 18:56:57'),
(36, 13, 7, 2, '35800', NULL, '35800', 'INR', NULL, 'S', '2021-08-07 19:04:40', '2021-09-06 19:04:40', 'Index Master Trader Program', '30', 1, 'Training', 2, 'Intermediate', NULL, '2021-08-07 19:03:48', '2021-08-07 19:04:40'),
(68, 30, 7, 11, '0', '0', '0', 'INR', NULL, 'S', '2021-08-08 17:12:21', '2021-08-15 17:12:21', 'World Market - Index & Stocks', '7', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 17:12:21', '2021-08-08 17:12:21'),
(66, 28, 7, 10, '15550', '3110', '12440', 'INR', '20', 'S', '2021-08-08 17:10:03', '2021-11-06 17:10:03', 'Commodity & Crypto Currency', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 17:08:48', '2021-08-08 17:10:03'),
(65, 28, 7, 9, '15550', '3110', '12440', 'INR', '20', 'S', '2021-08-08 17:10:03', '2021-11-06 17:10:03', 'Stocks & Equity Future Options', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 17:08:48', '2021-08-08 17:10:03'),
(64, 28, 7, 8, '10850', '2170', '8680', 'INR', '20', 'S', '2021-08-08 17:10:03', '2021-11-06 17:10:03', 'INDEX FUTURE & OPTION', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 17:08:48', '2021-08-08 17:10:03'),
(63, 27, 1, 2, '35800', '7160', '28640', 'INR', '20', 'S', '2021-08-08 16:47:28', '2021-09-07 16:47:28', 'Index Master Trader Program', '30', 1, 'Training', 2, 'Intermediate', NULL, '2021-08-08 16:47:19', '2021-08-08 16:47:28'),
(62, 27, 1, 11, '75950', '15190', '60760', 'INR', '20', 'S', '2021-08-08 16:47:28', '2021-11-06 16:47:28', 'World Market - Index & Stocks', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 16:47:19', '2021-08-08 16:47:28'),
(61, 26, 1, 2, '35800', '7160', '28640', 'INR', '20', 'P', NULL, NULL, 'Index Master Trader Program', '30', 1, 'Training', 2, 'Intermediate', NULL, '2021-08-08 16:47:03', '2021-08-08 16:47:03'),
(60, 26, 1, 11, '75950', '15190', '60760', 'INR', '20', 'P', NULL, NULL, 'World Market - Index & Stocks', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 16:47:03', '2021-08-08 16:47:03'),
(58, 24, 1, 10, '15550', '3110', '12440', 'INR', '20', 'S', '2021-08-08 16:42:35', '2021-11-06 16:42:35', 'Commodity & Crypto Currency', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 16:42:23', '2021-08-08 16:42:35'),
(59, 25, 1, 1, '18900', NULL, '18900', 'INR', NULL, 'S', '2021-08-08 16:46:38', '2021-09-07 16:46:38', 'Basic Price Analysis Course', '30', 1, 'Training', 1, 'Beginner', NULL, '2021-08-08 16:46:24', '2021-08-08 16:46:38'),
(56, 23, 1, 8, '0', '0', '0', 'INR', NULL, 'S', '2021-08-08 16:41:35', '2021-08-15 16:41:35', 'INDEX FUTURE & OPTION', '7', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 16:41:35', '2021-08-08 16:41:35'),
(57, 24, 1, 9, '15550', '3110', '12440', 'INR', '20', 'S', '2021-08-08 16:42:35', '2021-11-06 16:42:35', 'Stocks & Equity Future Options', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-08 16:42:23', '2021-08-08 16:42:35'),
(91, 47, 4, 9, '15550', '3110', '12440', 'INR', '20', 'P', NULL, NULL, 'Stocks & Equity Future Options', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-09-03 08:05:50', '2021-09-03 08:05:50'),
(90, 47, 4, 8, '10850', '2170', '8680', 'INR', '20', 'P', NULL, NULL, 'INDEX FUTURE & OPTION', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-09-03 08:05:50', '2021-09-03 08:05:50'),
(89, 46, 10, 1, '18900', NULL, '18900', 'INR', NULL, 'P', NULL, NULL, 'Basic Price Analysis Course', '30', 1, 'Training', 1, 'Beginner', NULL, '2021-08-25 02:21:08', '2021-08-25 02:21:08'),
(77, 38, 1, 9, '15550', '3110', '12440', 'INR', '20', 'P', NULL, NULL, 'Stocks & Equity Future Options', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-13 20:54:37', '2021-08-13 20:54:37'),
(78, 38, 1, 11, '75950', '15190', '60760', 'INR', '20', 'P', NULL, NULL, 'World Market - Index & Stocks', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-13 20:54:37', '2021-08-13 20:54:37'),
(79, 39, 1, 8, '10850', '2170', '8680', 'INR', '20', 'S', '2021-08-14 10:59:49', '2021-11-12 10:59:49', 'INDEX FUTURE & OPTION', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-14 10:59:32', '2021-08-14 10:59:49'),
(80, 39, 1, 9, '15550', '3110', '12440', 'INR', '20', 'S', '2021-08-14 10:59:49', '2021-11-12 10:59:49', 'Stocks & Equity Future Options', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-14 10:59:32', '2021-08-14 10:59:49'),
(88, 45, 10, 8, '10850', NULL, '10850', 'INR', NULL, 'P', NULL, NULL, 'INDEX FUTURE & OPTION', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-25 01:53:46', '2021-08-25 01:53:46'),
(87, 44, 10, 8, '10850', NULL, '10850', 'INR', NULL, 'P', NULL, NULL, 'INDEX FUTURE & OPTION', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-25 01:52:54', '2021-08-25 01:52:54'),
(86, 43, 4, 8, '10850', NULL, '10850', 'INR', NULL, 'P', NULL, NULL, 'INDEX FUTURE & OPTION', '90', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-23 12:43:46', '2021-08-23 12:43:46'),
(85, 42, 10, 11, '0', '0', '0', 'INR', NULL, 'S', '2021-08-21 07:12:12', '2021-08-28 07:12:12', 'World Market - Index & Stocks', '7', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-21 07:12:12', '2021-08-21 07:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `payments_history_08082021`
--

CREATE TABLE `payments_history_08082021` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `courseid` int(11) DEFAULT NULL,
  `orderid` text DEFAULT NULL,
  `receipt` text DEFAULT NULL,
  `entity` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `amount_paid` varchar(255) DEFAULT NULL,
  `amount_due` varchar(255) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `offer_id` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `attempts` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `order_created_at` varchar(255) DEFAULT NULL,
  `payment_id` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `payment_status` char(1) NOT NULL DEFAULT 'P',
  `package_startdate` datetime DEFAULT NULL,
  `package_enddate` datetime DEFAULT NULL,
  `course_title` varchar(255) DEFAULT NULL,
  `course_duration` varchar(100) DEFAULT NULL,
  `moduletype` int(11) DEFAULT NULL,
  `modulename` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `levelname` varchar(255) DEFAULT NULL,
  `course_trial` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments_history_08082021`
--

INSERT INTO `payments_history_08082021` (`id`, `userid`, `courseid`, `orderid`, `receipt`, `entity`, `amount`, `amount_paid`, `amount_due`, `currency`, `offer_id`, `status`, `attempts`, `notes`, `order_created_at`, `payment_id`, `signature`, `payment_status`, `package_startdate`, `package_enddate`, `course_title`, `course_duration`, `moduletype`, `modulename`, `level`, `levelname`, `course_trial`, `created_at`, `updated_at`) VALUES
(21, 7, 1, 'order_HSxTJdjuM95W0S', 'ORDER7KETANPATEL2906202117033', 'order', '18900', '0', '18900', 'INR', NULL, 'created', '0', 'a:0:{}', '1624987834', 'pay_HSxTzM7kdepQfE', '09474bb19f4c0d4da9c341c4cd798734123fbe4a7bebb22b04c6562cd1b6a89a', 'S', '2021-06-29 17:59:30', '2021-07-29 17:59:30', 'Basic Price Analysis Course', '30', 1, 'Training', 1, 'Beginner', NULL, '2021-06-29 17:59:30', '2021-06-29 17:59:30'),
(22, 7, 6, 'order_trial_0408202118011', 'ORDER_TRIAL_7KETANPATEL0408202118011', 'order', '0', '0', '0', 'INR', NULL, 'created', '0', NULL, NULL, NULL, NULL, 'S', '2021-08-04 18:19:11', '2021-08-11 18:19:11', 'Test For Advisory', '7', 2, 'Advisory', 2, 'Intermediate', NULL, '2021-08-04 18:19:12', '2021-08-04 18:19:12'),
(24, 1, 8, 'order_trial_0608202118034', 'ORDER_TRIAL_1KAUSHAL0608202118034', 'order', '0', '0', '0', 'INR', NULL, 'created', '0', NULL, NULL, NULL, NULL, 'S', '2021-08-06 18:20:34', '2021-08-13 18:20:34', 'INDEX FUTURE & OPTION', '7', 2, 'Advisory', 1, 'Beginner', NULL, '2021-08-06 18:20:34', '2021-08-06 18:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `per_slug` varchar(55) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module_id`, `name`, `per_slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dashboard View', 'dashboard-list', 'View', '2020-01-03 07:57:33', NULL),
(2, 2, 'General Settings View', 'general_settings-list', 'View', '2020-01-03 07:57:33', NULL),
(3, 2, 'General Settings Update', 'general_settings-update', 'Update', '2020-01-09 18:49:58', NULL),
(4, 3, 'Access Rights View', 'access_rights-list', 'View', '2020-01-09 18:51:05', NULL),
(5, 3, 'Access Rights Update', 'access_rights-update', 'Update', '2020-01-09 18:51:05', NULL),
(6, 4, 'User Profile', 'user_profile-list', 'List', '2020-01-12 08:31:50', NULL),
(7, 4, 'User Profile Update', 'user_profile-update', 'Update', '2020-01-12 08:31:50', NULL),
(8, 5, 'Change Password', 'change_password-list', 'List', '2020-01-12 08:31:50', NULL),
(9, 5, 'Change Password Update', 'change_password-update', 'Update', '2020-01-12 08:31:50', NULL),
(10, 6, 'Contact Us View', 'contact_leads-list', 'View', '2020-01-09 18:51:05', NULL),
(11, 6, 'Contact Us Delete', 'contact_leads-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(12, 7, 'Admin Users View', 'admin_users-list', 'View', '2020-01-09 18:51:05', NULL),
(13, 7, 'Admin Users Delete', 'admin_users-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(14, 7, 'Admin Users Create', 'admin_users-create', 'Create', '2020-01-09 18:51:05', NULL),
(15, 7, 'Admin Users Update', 'admin_users-update', 'Update', '2020-01-09 18:51:05', NULL),
(16, 7, 'Admin Users Publish', 'admin_users-publish', 'Publish', '2020-01-09 18:51:05', NULL),
(17, 8, 'Admin Roles View', 'admin_roles-list', 'View', '2020-01-09 18:51:05', NULL),
(18, 8, 'Admin Roles Delete', 'admin_roles-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(19, 8, 'Admin Roles Create', 'admin_roles-create', 'Create', '2020-01-09 18:51:05', NULL),
(20, 8, 'Admin Roles Update', 'admin_roles-update', 'Update', '2020-01-09 18:51:05', NULL),
(21, 8, 'Admin Roles Publish', 'admin_roles-publish', 'Publish', '2020-01-09 18:51:05', NULL),
(23, 9, 'Admin Module Type View', 'moduletype-list', 'View', '2020-01-09 18:51:05', NULL),
(24, 9, 'Admin Module Type Delete', 'moduletype-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(25, 9, 'Admin Module Type Create', 'moduletype-create', 'Create', '2020-01-09 18:51:05', NULL),
(26, 9, 'Admin Module Type Update', 'moduletype-update', 'Update', '2020-01-09 18:51:05', NULL),
(27, 9, 'Admin Module Type Publish', 'moduletype-publish', 'Publish', '2020-01-09 18:51:05', NULL),
(28, 10, 'Admin Levels View', 'level-list', 'View', '2020-01-09 18:51:05', NULL),
(29, 10, 'Admin Levels Delete', 'level-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(30, 10, 'Admin Levels Create', 'level-create', 'Create', '2020-01-09 18:51:05', NULL),
(31, 10, 'Admin Levels Update', 'level-update', 'Update', '2020-01-09 18:51:05', NULL),
(32, 10, 'Admin Levels Publish', 'level-publish', 'Publish', '2020-01-09 18:51:05', NULL),
(38, 11, 'Admin Category View', 'category-list', 'View', '2020-01-09 18:51:05', NULL),
(39, 11, 'Admin Category Delete', 'category-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(40, 11, 'Admin Category Create', 'category-create', 'Create', '2020-01-09 18:51:05', NULL),
(41, 11, 'Admin Category Update', 'category-update', 'Update', '2020-01-09 18:51:05', NULL),
(42, 11, 'Admin Category Publish', 'category-publish', 'Publish', '2020-01-09 18:51:05', NULL),
(43, 12, 'Admin Markets View', 'markets-list', 'View', '2020-01-09 18:51:05', NULL),
(44, 12, 'Admin Markets Delete', 'markets-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(45, 12, 'Admin Markets Create', 'markets-create', 'Create', '2020-01-09 18:51:05', NULL),
(46, 12, 'Admin Markets Update', 'markets-update', 'Update', '2020-01-09 18:51:05', NULL),
(47, 12, 'Admin Markets Publish', 'markets-publish', 'Publish', '2020-01-09 18:51:05', NULL),
(48, 13, 'Admin Courses View', 'courses-list', 'View', '2020-01-09 18:51:05', NULL),
(49, 13, 'Admin Courses Delete', 'courses-delete', 'Delete', '2020-01-09 18:51:05', NULL),
(50, 13, 'Admin Courses Create', 'courses-create', 'Create', '2020-01-09 18:51:05', NULL),
(51, 13, 'Admin Courses Update', 'courses-update', 'Update', '2020-01-09 18:51:05', NULL),
(52, 13, 'Admin Courses Publish', 'courses-publish', 'Publish', '2020-01-09 18:51:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `is_recommanded` int(1) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `photo` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_colors`
--

CREATE TABLE `product_variant_colors` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_variant_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `txtComment` text COLLATE utf8_bin NOT NULL,
  `intNumberofRating` int(11) NOT NULL,
  `intUserId` int(11) NOT NULL,
  `intCourseId` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `txtComment`, `intNumberofRating`, `intUserId`, `intCourseId`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Good course', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(2, 'Nice one!', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(3, 'Good course', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(4, 'Awesome', 5, 4, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(5, 'Excellent advisory !', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(6, 'Nice', 1, 7, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(7, 'Spectacular!', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(8, 'Awesome', 5, 4, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(9, 'Fantastic', 5, 4, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(10, 'Fabulous', 3, 4, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(11, 'Awesome', 5, 4, 11, 1, 0, '2021-07-10 10:44:59', '2021-07-10 10:44:59'),
(12, 'Awesome app', 5, 4, 8, 1, 0, '2021-07-10 10:49:11', '2021-07-10 10:49:11'),
(13, 'Good course 1', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(14, 'Nice one! 1', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(15, 'Good course 1', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(16, 'Awesome 1', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(17, 'Excellent advisory ! 1', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(18, 'Nice 1', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(19, 'Spectacular! 1', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(20, 'Awesome 1', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(21, 'Fantastic 1', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(22, 'Fabulous 1', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(23, 'Good course 2', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(24, 'Nice one! 2', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(25, 'Good course 2', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(26, 'Awesome 2', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(27, 'Excellent advisory ! 2', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(28, 'Nice 2', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(29, 'Spectacular! 2', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(30, 'Awesome 2', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(31, 'Fantastic 2', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(32, 'Fabulous 2', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(33, 'Good course 3', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(34, 'Nice one! 3', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(35, 'Good course 3', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(36, 'Awesome 3', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(37, 'Excellent advisory ! 3', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(38, 'Nice 3', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(39, 'Spectacular! 3', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(40, 'Awesome 3', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(41, 'Fantastic 3', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(42, 'Fabulous 3', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(43, 'Good course 4', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(44, 'Nice one! 4', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(45, 'Good course 4', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(46, 'Awesome 4', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(47, 'Excellent advisory ! 4', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(48, 'Nice 4', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(49, 'Spectacular! 4', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(50, 'Awesome 4', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(51, 'Fantastic 4', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(52, 'Fabulous 4', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(53, 'Good course 5', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(54, 'Nice one! 5', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(55, 'Good course 5', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(56, 'Awesome 5', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(57, 'Excellent advisory ! 5', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(58, 'Nice 5', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(59, 'Spectacular! 5', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(60, 'Awesome 5', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(61, 'Fantastic 5', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(62, 'Fabulous 5', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(63, 'Good course 6', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(64, 'Nice one! 6', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(65, 'Good course 6', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(66, 'Awesome 6', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(67, 'Excellent advisory ! 6', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(68, 'Nice 6', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(69, 'Spectacular! 6', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(70, 'Awesome 6', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(71, 'Fantastic 6', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(72, 'Fabulous 6', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(73, 'Good course 7', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(74, 'Nice one! 7', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(75, 'Good course 7', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(76, 'Awesome 7', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(77, 'Excellent advisory ! 7', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(78, 'Nice 7', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(79, 'Spectacular! 7', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(80, 'Awesome 7', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(81, 'Fantastic 7', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(82, 'Fabulous 7', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(83, 'Good course 8', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(84, 'Nice one! 8', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(85, 'Good course 8', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(86, 'Awesome 8', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(87, 'Excellent advisory ! 8', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(88, 'Nice 8', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(89, 'Spectacular! 8', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(90, 'Awesome 8', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(91, 'Fantastic 8', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(92, 'Fabulous 8', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(93, 'Good course 9', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(94, 'Nice one! 9', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(95, 'Good course 9', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(96, 'Awesome 9', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(97, 'Excellent advisory ! 9', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(98, 'Nice 9', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(99, 'Spectacular! 9', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(100, 'Awesome 9', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(101, 'Fantastic 9', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(102, 'Fabulous 9', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33'),
(103, 'Good course 10', 5, 1, 1, 1, 0, '2021-05-16 19:05:05', '2021-05-16 19:05:05'),
(104, 'Nice one! 10', 4, 1, 2, 1, 0, '2021-05-16 19:07:10', '2021-05-16 19:07:10'),
(105, 'Good course 10', 4, 1, 3, 1, 0, '2021-05-24 19:22:14', '2021-05-24 19:22:14'),
(106, 'Awesome 10', 5, 1, 5, 1, 0, '2021-06-07 19:20:46', '2021-06-07 19:20:46'),
(107, 'Excellent advisory ! 10', 5, 1, 10, 1, 0, '2021-06-10 18:34:05', '2021-06-10 18:34:05'),
(108, 'Nice 10', 1, 1, 1, 1, 0, '2021-06-12 14:32:02', '2021-06-12 14:32:02'),
(109, 'Spectacular! 10', 5, 1, 4, 1, 0, '2021-06-15 15:48:47', '2021-06-15 15:48:47'),
(110, 'Awesome 10', 5, 1, 1, 1, 0, '2021-06-17 19:14:41', '2021-06-17 19:14:41'),
(111, 'Fantastic 10', 5, 1, 2, 1, 0, '2021-06-21 12:20:57', '2021-06-21 12:20:57'),
(112, 'Fabulous 10', 3, 1, 10, 1, 0, '2021-06-21 12:21:33', '2021-06-21 12:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, '2020-01-03 07:53:25', NULL),
(2, 'Admin', 1, '2020-01-03 07:53:25', '2020-04-06 08:51:31'),
(7, 'Employee', 1, '2020-04-06 23:51:50', '2020-04-06 23:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(387, 2, 32, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(386, 2, 31, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(385, 2, 30, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(384, 2, 28, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(383, 2, 24, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(382, 2, 27, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(381, 2, 26, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(380, 2, 25, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(379, 2, 23, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(378, 2, 18, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(377, 2, 21, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(376, 2, 20, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(375, 2, 19, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(374, 2, 17, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(373, 2, 13, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(372, 2, 16, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(371, 2, 15, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(370, 2, 14, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(369, 2, 12, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(368, 2, 11, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(367, 2, 10, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(274, 7, 11, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(273, 7, 10, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(272, 7, 9, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(271, 7, 8, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(270, 7, 7, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(269, 7, 6, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(268, 7, 1, '2020-04-08 00:39:53', '2020-04-08 00:39:53'),
(366, 2, 9, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(365, 2, 8, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(364, 2, 7, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(363, 2, 6, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(362, 2, 5, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(361, 2, 4, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(360, 2, 3, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(359, 2, 2, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(358, 2, 1, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(388, 2, 29, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(389, 2, 38, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(390, 2, 40, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(391, 2, 41, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(392, 2, 42, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(393, 2, 39, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(394, 2, 43, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(395, 2, 45, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(396, 2, 46, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(397, 2, 47, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(398, 2, 44, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(399, 2, 48, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(400, 2, 50, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(401, 2, 51, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(402, 2, 52, '2021-05-18 16:44:19', '2021-05-18 16:44:19'),
(403, 2, 49, '2021-05-18 16:44:19', '2021-05-18 16:44:19');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `category_id`, `name`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, '5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(2, 1, '5.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(3, 1, '6', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(4, 1, '6.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(5, 1, '7', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(6, 1, '7.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(7, 1, '8', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(8, 1, '8.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(9, 1, '9', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(10, 1, '9.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(11, 1, '10', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(12, 1, '10.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(13, 1, '11', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(14, 1, '11.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(15, 1, '12', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(16, 1, '12.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(17, 1, '13', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(18, 1, '14', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(19, 1, '15', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(20, 2, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(21, 2, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(22, 2, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(23, 2, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(24, 2, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(25, 2, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(26, 2, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(27, 3, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(28, 3, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(29, 3, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(30, 3, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(31, 3, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(32, 3, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(33, 3, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(34, 4, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(35, 4, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(36, 4, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(37, 4, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(38, 4, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(39, 4, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(40, 4, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(41, 5, '26', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(42, 5, '27', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(43, 5, '28', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(44, 5, '29', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(45, 5, '30', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(46, 5, '31', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(47, 5, '32', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(48, 5, '33', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(49, 5, '34', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(50, 5, '35', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(51, 5, '36', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(52, 5, '37', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(53, 5, '38', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(54, 5, '39', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(55, 5, '40', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(56, 5, '41', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(57, 5, '42', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(58, 5, '43', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(59, 5, '44', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(60, 6, '4', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(61, 6, '4.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(62, 6, '5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(63, 6, '5.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(64, 6, '6', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(65, 6, '6.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(66, 6, '7', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(67, 6, '7.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(68, 6, '8', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(69, 6, '8.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(70, 6, '9', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(71, 6, '9.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(72, 6, '10', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(73, 6, '10.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(74, 6, '11', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(75, 6, '11.5', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(76, 6, '12', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(77, 7, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(78, 7, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(79, 7, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(80, 7, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(81, 7, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(82, 7, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(83, 7, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(84, 8, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(85, 8, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(86, 8, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(87, 8, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(88, 8, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(89, 8, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(90, 8, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(91, 9, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(92, 9, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(93, 9, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(94, 9, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(95, 9, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(96, 9, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(97, 9, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(98, 10, '23', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(99, 10, '24', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(100, 10, '25', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(101, 10, '26', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(102, 10, '27', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(103, 10, '28', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(104, 10, '29', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(105, 10, '30', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(106, 10, '31', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(107, 10, '32', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(108, 10, '33', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(109, 10, '34', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(110, 10, '35', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(111, 10, '36', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(112, 10, '37', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(113, 10, '38', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(114, 10, '39', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(115, 10, '40', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(116, 10, '41', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(117, 10, '42', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(118, 11, 'XXS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(119, 11, 'XS', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(120, 11, 'S', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(121, 11, 'M', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(122, 11, 'L', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(123, 11, 'XL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08'),
(124, 11, 'XXL', 1, 0, '2020-12-17 04:04:08', '2020-12-17 04:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `store_location`
--

CREATE TABLE `store_location` (
  `id` int(11) NOT NULL,
  `appuser_id` int(11) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otpCode` int(10) DEFAULT NULL,
  `phoneNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usersPhoto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intLanguageId` int(11) NOT NULL DEFAULT 1,
  `intMarketId` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `varcountryCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `varcallingCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isVerified` tinyint(1) NOT NULL DEFAULT 0,
  `isTrial` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `otpCode`, `phoneNumber`, `usersPhoto`, `intLanguageId`, `intMarketId`, `varcountryCode`, `varcallingCode`, `isVerified`, `isTrial`, `created_at`, `updated_at`) VALUES
(1, 'Kaushal', 'kaushalp.dev@gmail.com', NULL, '$2y$10$IqldCakKD5XtrLmOUCQw6uoNQ20vd1VnGVxUNiPAxqIbMexiTWJke', NULL, 4493, '9662358364', '1620241748.jpg', 1, '1,11', 'IN', '91', 1, 1, '2021-05-05 18:09:29', '2021-08-14 18:53:37'),
(2, 'Mm', 'mm1@grr.la', NULL, '$2y$10$.LVIGhGuVVRepNuPaq.uguSOz9aMTDFKrLUUxRZfdN0U4aJRSMXlC', NULL, NULL, '9988776651', NULL, 1, '1,2', 'IN', '91', 1, 0, '2021-05-05 18:24:03', '2021-05-05 18:28:10'),
(3, 'Vivek', 'vivekwazo@gmail.com', NULL, '$2y$10$aaYCqh7EjYCcsaKK/2lXyuY1sHtxcDxRES5q.RQeyXPS9BPQD/id.', NULL, NULL, '9919161691', NULL, 1, '1,2,3,11', 'IN', '91', 1, 0, '2021-05-06 01:15:16', '2021-08-21 17:22:46'),
(4, 'Rohan', 'rohanshinde999@yahoo.com', NULL, '$2y$10$R2wznwBKmieMsR7j.LUY.uFJovW4ZPWYVvz8erBkdOMaY3Yjw8Bsq', NULL, NULL, '9323001715', NULL, 1, '1,3,2,4,5,6,7,8,9,10,11', 'IN', '91', 1, 1, '2021-05-06 15:02:19', '2021-08-15 03:55:32'),
(8, 'Kaustubh Shinde', 'kaustubh17.shinde@gmail.com', NULL, '$2y$10$XSR6AS3s1qVSsqd6Kkbz6ucnkk62gkMzcytszTLoATonTmBZJsbnW', NULL, NULL, '0211520602', NULL, 1, '3,2,1,11', 'NZ', '64', 1, 0, '2021-06-29 06:06:38', '2021-06-29 06:09:03'),
(7, 'Ketan Patel', 'ketan.patel6555@gmail.com', NULL, '$2y$10$Q7h/EAgcnSWxAKZZuXdHbuK9tPvygogBaqSldG/0C81UWEKeXFwQC', NULL, NULL, '9998241555', NULL, 1, '11', 'IN', '91', 1, 1, '2021-05-18 02:31:40', '2021-08-25 16:41:28'),
(9, 'Kandarp', 'kandarppandya786@gmail.com', NULL, '$2y$10$uQQUQFpVjeJlydWd6P3QtOR46.U.QgeybulXP.RDvKhX7AznDaWdu', NULL, NULL, '9427986091', NULL, 1, '1,11', 'IN', '91', 1, 0, '2021-07-07 06:47:20', '2021-07-07 06:48:22'),
(10, 'Shailendra', 'shail292003@gmail.com', NULL, '$2y$10$yAgZLAJD6CqybK2OjW066u5bHPH2iuks5E8qxcDhjokJ9gfoQSzJi', NULL, NULL, '9899603578', NULL, 1, '3,11', 'IN', '91', 1, 1, '2021-07-22 07:31:32', '2021-08-21 07:12:12'),
(11, 'Saloni', 'shailgarg41@gmail.com', NULL, '$2y$10$/4Fc02.Am7UiHD6UCT2uCOLFGh9IuOJugJX/LpCslWLHIMIQ3wwc6', NULL, NULL, '9643477626', NULL, 6, '11', 'IN', '91', 1, 0, '2021-07-22 07:42:58', '2021-07-22 07:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `users_chats`
--

CREATE TABLE `users_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receiverId` int(11) DEFAULT NULL COMMENT 'To',
  `senderId` int(11) DEFAULT NULL COMMENT 'From',
  `globalDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailSent` int(11) DEFAULT 0,
  `readMsg` int(11) DEFAULT 0,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_chats`
--

INSERT INTO `users_chats` (`id`, `receiverId`, `senderId`, `globalDate`, `message`, `emailSent`, `readMsg`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, 'Hello admin', 0, 0, 0, '2021-07-18 14:02:16', '2021-07-18 14:02:16'),
(2, 7, 1, NULL, 'yes plz tell me', 0, 0, 1, '2021-07-18 14:02:42', '2021-07-18 14:02:42'),
(3, 1, 7, NULL, 'what\'s update for market', 0, 0, 0, '2021-07-18 14:03:14', '2021-07-18 14:03:14'),
(4, 1, 1, NULL, 'Hi', 0, 0, 0, '2021-07-18 14:13:42', '2021-07-18 14:13:42'),
(5, 1, 1, NULL, 'Hi', 0, 0, 1, '2021-07-18 14:22:18', '2021-07-18 14:22:18'),
(6, 7, 1, NULL, 'market is stable now.', 0, 0, 1, '2021-07-18 15:38:08', '2021-07-18 15:38:08'),
(7, 1, 7, NULL, 'I am waiting your script call', 0, 0, 0, '2021-07-18 15:39:30', '2021-07-18 15:39:30'),
(8, 7, 1, NULL, 'I will send script in soon', 0, 0, 1, '2021-07-18 15:40:11', '2021-07-18 15:40:11'),
(9, 1, 7, NULL, 'ok thanks', 0, 0, 0, '2021-07-18 15:41:47', '2021-07-18 15:41:47'),
(10, 7, 1, NULL, 'welcome', 0, 0, 1, '2021-07-18 15:42:09', '2021-07-18 15:42:09'),
(11, 1, 1, NULL, 'Hi Kausha Notification set. but extra data pending.', 0, 0, 1, '2021-07-18 15:43:38', '2021-07-18 15:43:38'),
(12, 1, 1, NULL, 'hello', 0, 0, 1, '2021-07-18 17:20:40', '2021-07-18 17:20:40'),
(13, 1, 1, NULL, 'ok', 0, 0, 0, '2021-07-18 17:30:03', '2021-07-18 17:30:03'),
(14, 1, 1, NULL, '1', 0, 0, 1, '2021-07-18 17:30:38', '2021-07-18 17:30:38'),
(15, 1, 1, NULL, '2', 0, 0, 1, '2021-07-18 17:30:44', '2021-07-18 17:30:44'),
(16, 1, 1, NULL, '3', 0, 0, 1, '2021-07-18 17:32:42', '2021-07-18 17:32:42'),
(17, 1, 1, NULL, '5', 0, 0, 1, '2021-07-18 17:34:02', '2021-07-18 17:34:02'),
(18, 1, 1, NULL, 'hello Kaushal', 0, 0, 1, '2021-07-18 17:34:04', '2021-07-18 17:34:04'),
(19, 1, 1, NULL, 'Hi admin', 0, 0, 0, '2021-07-18 17:34:15', '2021-07-18 17:34:15'),
(20, 1, 1, NULL, 'Checkingz', 0, 0, 0, '2021-07-18 17:34:25', '2021-07-18 17:34:25'),
(21, 1, 1, NULL, 'checking', 0, 0, 0, '2021-07-18 17:34:33', '2021-07-18 17:34:33'),
(22, 1, 1, NULL, 'you r user and i am admin', 0, 0, 1, '2021-07-18 17:34:58', '2021-07-18 17:34:58'),
(23, 1, 1, NULL, 'done', 0, 0, 0, '2021-07-18 17:35:03', '2021-07-18 17:35:03'),
(24, 1, 1, NULL, 'working fine', 0, 0, 0, '2021-07-18 17:35:12', '2021-07-18 17:35:12'),
(25, 1, 1, NULL, 'calling in skype', 0, 0, 0, '2021-07-18 17:35:17', '2021-07-18 17:35:17'),
(26, 1, 1, NULL, '😀😃😄😄😄😁', 0, 0, 0, '2021-07-18 17:35:30', '2021-07-18 17:35:30'),
(27, 1, 1, NULL, 'Headphone not working', 0, 0, 1, '2021-07-18 17:35:59', '2021-07-18 17:35:59'),
(28, 1, 1, NULL, 'Send new message', 0, 0, 0, '2021-07-18 17:36:05', '2021-07-18 17:36:05'),
(29, 1, 1, NULL, 'Okay', 0, 0, 0, '2021-07-18 17:36:10', '2021-07-18 17:36:10'),
(30, 1, 1, NULL, 'Send emoji', 0, 0, 0, '2021-07-18 17:36:14', '2021-07-18 17:36:14'),
(31, 1, 1, NULL, ';)', 0, 0, 1, '2021-07-18 17:36:27', '2021-07-18 17:36:27'),
(32, 1, 1, NULL, '😀', 0, 0, 1, '2021-07-18 17:36:53', '2021-07-18 17:36:53'),
(33, 1, 1, NULL, 'not option available in this panel', 0, 0, 1, '2021-07-18 17:36:56', '2021-07-18 17:36:56'),
(34, 1, 1, NULL, '😞', 0, 0, 1, '2021-07-18 17:37:02', '2021-07-18 17:37:02'),
(35, 1, 1, NULL, '😆😅', 0, 0, 1, '2021-07-18 17:37:16', '2021-07-18 17:37:16'),
(36, 1, 1, NULL, '🥶', 0, 0, 1, '2021-07-18 17:37:39', '2021-07-18 17:37:39'),
(37, 1, 1, NULL, '😍😍😍😍', 0, 0, 1, '2021-07-18 17:37:43', '2021-07-18 17:37:43'),
(38, 1, 1, NULL, 'working fine', 0, 0, 1, '2021-07-18 17:37:53', '2021-07-18 17:37:53'),
(39, 1, 1, NULL, 'looks like live chat', 0, 0, 0, '2021-07-18 17:38:07', '2021-07-18 17:38:07'),
(40, 1, 1, NULL, 'yes right', 0, 0, 1, '2021-07-18 17:38:17', '2021-07-18 17:38:17'),
(41, 1, 1, NULL, 'on kill state', 0, 0, 1, '2021-07-18 17:38:45', '2021-07-18 17:38:45'),
(42, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:38:46', '2021-07-18 17:38:46'),
(43, 1, 1, NULL, 'kill 1', 0, 0, 1, '2021-07-18 17:39:00', '2021-07-18 17:39:00'),
(44, 1, 1, NULL, '2', 0, 0, 1, '2021-07-18 17:39:28', '2021-07-18 17:39:28'),
(45, 1, 1, NULL, 'Chating completed..', 0, 0, 1, '2021-07-18 17:39:35', '2021-07-18 17:39:35'),
(46, 1, 1, NULL, 'yes', 0, 0, 0, '2021-07-18 17:39:58', '2021-07-18 17:39:58'),
(47, 1, 1, NULL, 'Great work!', 0, 0, 0, '2021-07-18 17:40:55', '2021-07-18 17:40:55'),
(48, 1, 1, NULL, 'Making build now', 0, 0, 0, '2021-07-18 17:41:09', '2021-07-18 17:41:09'),
(49, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:41:55', '2021-07-18 17:41:55'),
(50, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:41:58', '2021-07-18 17:41:58'),
(51, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:42:00', '2021-07-18 17:42:00'),
(52, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:42:36', '2021-07-18 17:42:36'),
(53, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:42:58', '2021-07-18 17:42:58'),
(54, 1, 1, NULL, NULL, 0, 0, 1, '2021-07-18 17:42:58', '2021-07-18 17:42:58'),
(55, 1, 4, NULL, 'Hi', 0, 0, 0, '2021-07-19 04:22:28', '2021-07-19 04:22:28'),
(56, 1, 1, NULL, 'Hi', 0, 0, 0, '2021-07-22 07:43:40', '2021-07-22 07:43:40'),
(57, 1, 1, NULL, 'Hello', 0, 0, 0, '2021-07-22 07:43:51', '2021-07-22 07:43:51'),
(58, 4, 1, NULL, 'HI', 0, 0, 1, '2021-07-30 11:51:53', '2021-07-30 11:51:53'),
(59, 1, 4, NULL, 'Hi', 0, 0, 0, '2021-07-30 12:11:12', '2021-07-30 12:11:12'),
(60, 1, 4, NULL, 'What is the requirement', 0, 0, 0, '2021-07-30 12:11:22', '2021-07-30 12:11:22'),
(61, 1, 4, NULL, 'Abc', 0, 0, 0, '2021-08-09 03:06:45', '2021-08-09 03:06:45'),
(62, 1, 4, NULL, 'How r u', 0, 0, 0, '2021-08-13 04:54:53', '2021-08-13 04:54:53'),
(63, 1, 4, NULL, 'Can u tell me what the update', 0, 0, 0, '2021-08-13 04:55:02', '2021-08-13 04:55:02'),
(64, 1, 4, NULL, 'When can I see that', 0, 0, 0, '2021-08-13 04:55:04', '2021-08-13 04:55:04'),
(65, 1, 4, NULL, 'Hi', 0, 0, 0, '2021-08-14 13:44:07', '2021-08-14 13:44:07'),
(66, 1, 4, NULL, 'Hi', 0, 0, 0, '2021-08-15 03:53:48', '2021-08-15 03:53:48'),
(67, 1, 1, NULL, 'Hi', 0, 0, 0, '2021-08-17 17:04:45', '2021-08-17 17:04:45'),
(68, 1, 3, NULL, 'Hi', 0, 0, 0, '2021-08-21 17:21:45', '2021-08-21 17:21:45'),
(69, 1, 4, NULL, 'Hi', 0, 0, 0, '2021-08-23 12:42:48', '2021-08-23 12:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `users_devicetoken`
--

CREATE TABLE `users_devicetoken` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `deviceToken` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_devicetoken`
--

INSERT INTO `users_devicetoken` (`id`, `userid`, `deviceToken`, `created_at`, `updated_at`) VALUES
(23, 7, 'cWMxqo6BRtys4G_2Y198oO:APA91bGinsNO82ggZyXPAXrlFLvUh2PsV2bMBXWvr2qYtyxV1-eCKO2yHfecZ_0cDZe8DiDCfdSCR2ey31jznYc7ZOtheb20O1U0lNcwc-f6CNpVmVkRucapCAaGtwobKtKWOzMPW0vS', '2021-08-07 19:12:26', '2021-08-07 19:12:26'),
(39, 7, 'dyLLT7KMRIqikrUHxKmMtn:APA91bGdqUE4kqCza6Q5FOtF54Dp0sYSLEOXviTf9mYE5PT6B8Q_Y3Kvw-NNnu7a8Aznbm7QxpJBeCuuv7Fx7FIQ5x0Q8xxwonP5RQUNRaJfPw2-6SlOwMyGyVPJvSvFU9zxuzs6BaMr', '2021-08-18 17:13:09', '2021-08-18 17:13:09'),
(19, 1, 'cwPRzS5oR_Ct9FBnPG5cLw:APA91bEDxtdPDCdSLUtxupP4x-K_dNDobBdiMh3O_WxWJWNYJzQRHOEnjm1CHC3HuTtdSf5KVCnEruDAvNgl7fwXZLvvmZ1Qk8kL6V0jO-e_D40WUUBEwUhuYaNxkr32sH_gIDiWjtKH', '2021-07-22 07:37:06', '2021-07-22 07:37:06'),
(40, 1, 'fifRZAwjTTKHG7drxKmDqo:APA91bG855mBzYmw5WjH5f1b8mo3Rzrqp6U46rj3b07d034mEUuzMME5CUJ851AmXmLPTUhpXO-sFZWViSffd__lc4fA3dAjF6bh_oQztfkIG1b4QyaPJgpu1olCp0b_zeNfmJYtKOSi', '2021-08-20 19:03:16', '2021-08-20 19:03:16'),
(14, 9, 'ecU3F6UKQ7KhFn4PvfSR06:APA91bGFXxj6JMfEKB-t04Ck8uSv8qYwhe7qYJJAIm3DYU71sRbXKB9D2macxxgcTARS7_qeued4hdXSPKu-NpGWra8GpOXlVZRZY0e2PbN6rh3GszX1cXDT37SX0E5GzPhOCTGW3HVI', '2021-07-07 06:48:11', '2021-07-07 06:48:11'),
(15, 4, 'eJzHnZ8TRNmHRdVSSaxtYC:APA91bHrg7uB14VZaxojYcyzv4Yig7BxL4eLGUuAiS3vSgWtq1DKm44ZL336Okv5sPC4KrV_t_s_J8Sb60LTbSC13e-QJYUX7t3A4pEh_etFfdPxmaUuJgujlSfNCnR5LI62M2zIkNTw', '2021-07-07 06:56:22', '2021-07-07 06:56:22'),
(21, 1, 'd8lZnWRDOElgpva94O-aj6:APA91bGGjerYUZodlIWTecllcfwrPYe9nQs4OMqws-tvU2vesPQXGEBH0Si7KKo0yQIBln-YJUN_fKzJXw9a-SAZfBjQswLQVt-wpung6dD3a7cZpKa0UnsqGzcWCMHBQNbUjEvPPTYX', '2021-08-06 19:34:11', '2021-08-06 19:34:11'),
(20, 11, 'fU8JU4OMRUC-hbXCJMu60W:APA91bGxCXOCxclhtxuRa81fT9AgAjJBrEHYjYPeRvaOCvtUC4VkHj8YC8IXS9iRZ_3oflEurQLM4bf-z2VBaYeoXpjrlZJJkNyzQQ4-uAV4jn7xCrSSEXIckUa6gJUwezk-RYLIQH9o', '2021-07-22 07:46:02', '2021-07-22 07:46:02'),
(38, 7, 'cnI98Bl4TdyvLmbWOcpEJR:APA91bEH1ZkvNOHkePifi00dqBEr_pva1XVSAXCWc_DHMnG4V4s0B-Yn0S6tAhRO7MFAqlC0ZPOkkwLcLCYrknMgSNd0QsfDD1ccahgUYf7kyGBQ3cISj7IJvAk1mW5zyaeeZKIFggD-', '2021-08-18 17:12:05', '2021-08-18 17:12:05'),
(47, 1, 'dPldNMDq7kKFv4GFfClFKp:APA91bH5P9SwBia6GDGsyDNqwxSJpBI_IlBA0iw-tZmEuh7f8vChHLr6zvFuTJksSIi5EIIyJxAHSQkkRG3lynDeAPP3LyAufLKwKCGqI6mf9SSspt4PYZazNPbje3AfQORxQ_1WQuSJ', '2021-09-01 18:00:27', '2021-09-01 18:00:27'),
(37, 1, 'c1O5srDXR7KQVkjjBGZGbq:APA91bFiDiTCTmxB7ettebQBsIfDh3Z3PrrxIHKWxQXSW7-pt8TYLxlQThV2ElfavfIuYan7PfoQVUjZqmwy5gXyH2zp35ErsPDaw8-w3GzvcooJ9p3ETsyajoh_4I4f2Om7tsmg77Ri', '2021-08-17 17:04:08', '2021-08-17 17:04:08'),
(42, 10, 'c2ZJrHS3QCCI4GaH8bYeBG:APA91bGUKR98evrYODnZGE8_t_4z2twGs2Xnua3XFbETUt5kvLbqOC-FCT0sjgjlR8qTmFEKzIzzXIz13HR0egAT8hVIxeUHHk6GerG51EVGtK07LG7DYeQ5GYBh81b3eVfchvKKn-bz', '2021-08-21 07:11:04', '2021-08-21 07:11:04'),
(43, 3, 'cU-dk3onSa2H5EnWP_Ga9W:APA91bFkoAqyghtQoo2OEW29UqK9zGNRWEvcFrTwpZJk-9uL7eCdyI0oQMsCWD7TScS9TX7-Tlglex87UAbTFyobY4sAzWmXH3PF_ZgqqSEFPc5p8sJ43CJTzHw-NbCiiFJKOa6f-OV3', '2021-08-21 09:18:10', '2021-08-21 09:18:10'),
(44, 7, 'doMn8MYJSwidRkH_3MihFQ:APA91bHTHxBNP7ilweUVHHCNKyh3gn5woYOpB8OOGXSsp6jwzMiN6LdMwHONYkd4RWfUfYDNjtrCdkxyA5sR5wlBT6p_5UP2JjLGURN6H2cxE7VoZLc_tLY0_HBwypn1LH9q_0QC_ANv', '2021-08-25 18:11:51', '2021-08-25 18:11:51'),
(48, 10, 'dNo6oMm7S46RuMRDcZwk44:APA91bEehSzuctjphxGK_swaNyzjL_Nlmfi7XCeU96eqn9Her72XeLZcPAZknGu938lB7Qu8n4P3_SAan8gaI2q_YXQfInZm3l-Ue4hcsC_5D_-FtBai8dYJt0TILfMpUNKnGre3gBPw', '2021-09-01 19:09:37', '2021-09-01 19:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_followers`
--

CREATE TABLE `user_followers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `follower_user_id` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_followings`
--

CREATE TABLE `user_followings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `following_user_id` int(11) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_logindevice_info`
--

CREATE TABLE `user_logindevice_info` (
  `id` int(11) NOT NULL,
  `appuser_id` int(11) NOT NULL,
  `token` text NOT NULL,
  `devices_type` enum('Android','Iphone','Windows','Web','Other') NOT NULL DEFAULT 'Android',
  `login_type` enum('normal','facebook','google','twitter','apple','email') NOT NULL DEFAULT 'normal',
  `devices_token` varchar(255) NOT NULL,
  `devices_name` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `devices_id` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `location_ids` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `is_login` int(1) DEFAULT 0 COMMENT '0 - login | 1 - logout',
  `loginflag` int(11) DEFAULT 1 COMMENT '1 - not login and sign up |\r\n0 - Login and Sign UP',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_logindevice_info`
--

INSERT INTO `user_logindevice_info` (`id`, `appuser_id`, `token`, `devices_type`, `login_type`, `devices_token`, `devices_name`, `os`, `devices_id`, `app_version`, `location_ids`, `price`, `address`, `postal_code`, `latitude`, `longitude`, `is_login`, `loginflag`, `created_at`, `updated_at`) VALUES
(1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiM2U5NDQxNDBmYzhkMTVlOWJmOTE4MTcwYTdjNjhlYTg0NDI5Y2JlZDkyNTc0NWRhNDcxNzlhNTZlYzY2NTdhNjkzNmFjMjUzMTI2Yzc3YjAiLCJpYXQiOjE2MTgzMDI1MjkuMDgzMTI0LCJuYmYiOjE2MTgzMDI1MjkuMDgzMTI4LCJleHAiOjE2NDk4Mzg1MjkuMDc1MzA0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MiIkcK-rqPMLoeG5ZNVZZ11jhvs4ww7Fo0ljeg_DvERejFEXPgsYy2mSBctrIPX1kd7nXu_TtHjOITgkQLJLV8yJUuSnQ9fJWiUGeIAoAedrDfkHGxj92sTi0zkUOL-gZvD-5t7NtOq0yV7B1GYqFwQkLWvBG2jE98JUODbzGk-DLj41WbbJeBj9GwpoSyzKMsBahww3WLtSfjPDCmzxRst1G2z7Fu_WFSl18RpBAvqSiFgGFa1kGJpXz5d2faiMM1RxLwLOk4WCP7hHBj6vbqUouIYp8KwzrKWyVd3a_yMVRRdclXXbRQ1gyqyodbJSPV-DNFxppP7_kmxC4RR3LEe-ktAJPHYxUQNHIvoeghCZ19TH3Wrxg2CLH1KcQPm0zKYC6-7K374Iaf4f3ikSefRra8NuEWa-i6evoXFnG_gY3eXd0kfPCnCmm7Aoju6UR7D2xqin3Mjm4LXEZ0NqL56C754HofzsPPafo2n1evWFLh1xurZCE6Zxm-oKb7kJB47FYclkXIGUbLZtqyvniz0mViWpik4dgZgfoVZnDbDVe-K5_bNUaw4H8U0lemAH0DXbmsV4T863DB8CeCJ_DXQpWgOCi7GUgmkq_PyTlbx7xxTd4I_QFu2jXE-EAHardBip12COAXPV-Akrmj0SbsJu2frFaszvyfZPLTJOXB0', 'Android', 'normal', 'abceajlkdlfka', 'mi yi', 'Android10', 'uriueiourioua', '1', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2021-04-13 08:28:49', '2021-04-13 13:28:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `advisory_notification`
--
ALTER TABLE `advisory_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advisory_notification_reports`
--
ALTER TABLE `advisory_notification_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_otp_requests`
--
ALTER TABLE `api_otp_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_leads`
--
ALTER TABLE `contact_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses_videos`
--
ALTER TABLE `courses_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboardnotification`
--
ALTER TABLE `dashboardnotification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `front_users_details`
--
ALTER TABLE `front_users_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_cities`
--
ALTER TABLE `location_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_types`
--
ALTER TABLE `module_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_08082021`
--
ALTER TABLE `payments_08082021`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_history`
--
ALTER TABLE `payments_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_history_08082021`
--
ALTER TABLE `payments_history_08082021`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variant_colors`
--
ALTER TABLE `product_variant_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_chats`
--
ALTER TABLE `users_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_devicetoken`
--
ALTER TABLE `users_devicetoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_followers`
--
ALTER TABLE `user_followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_followings`
--
ALTER TABLE `user_followings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logindevice_info`
--
ALTER TABLE `user_logindevice_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `advisory_notification`
--
ALTER TABLE `advisory_notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `advisory_notification_reports`
--
ALTER TABLE `advisory_notification_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_otp_requests`
--
ALTER TABLE `api_otp_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `contact_leads`
--
ALTER TABLE `contact_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `courses_videos`
--
ALTER TABLE `courses_videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dashboardnotification`
--
ALTER TABLE `dashboardnotification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_users_details`
--
ALTER TABLE `front_users_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `location_cities`
--
ALTER TABLE `location_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `module_types`
--
ALTER TABLE `module_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `payments_08082021`
--
ALTER TABLE `payments_08082021`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `payments_history`
--
ALTER TABLE `payments_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `payments_history_08082021`
--
ALTER TABLE `payments_history_08082021`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variant_colors`
--
ALTER TABLE `product_variant_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_chats`
--
ALTER TABLE `users_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users_devicetoken`
--
ALTER TABLE `users_devicetoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user_followers`
--
ALTER TABLE `user_followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_followings`
--
ALTER TABLE `user_followings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logindevice_info`
--
ALTER TABLE `user_logindevice_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
