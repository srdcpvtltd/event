-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 02, 2024 at 06:27 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u253356387_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `business_hours`
--

CREATE TABLE `business_hours` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `day` int(1) NOT NULL,
  `open` char(4) NOT NULL,
  `close` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `plural_name` varchar(255) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `iconfont_tag` varchar(255) NOT NULL DEFAULT '',
  `cat_order` int(10) NOT NULL DEFAULT 0,
  `cat_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`id`, `name`, `plural_name`, `parent_id`, `iconfont_tag`, `cat_order`, `cat_status`) VALUES
(1, 'Auto', 'Auto', 0, '<i class=\"flaticon-transport-1\"></i>', 0, 1),
(29, 'Bar & Restaurant', 'Bars & Restaurants', 0, '<i class=\"flaticon-restaurant\"></i>', 0, 1),
(74, 'Computer', 'Computers', 0, '<i class=\"flaticon-computer\"></i>', 0, 1),
(83, 'Diet & Health', 'Diet & Health', 0, '<i class=\"flaticon-heart-beats\"></i>', 0, 1),
(99, 'Entertainment', 'Entertainment', 0, '<i class=\"flaticon-tickets\"></i>', 0, 1),
(133, 'Fitness', 'Fitness', 0, '<i class=\"flaticon-weights\"></i>', 0, 1),
(144, 'Home', 'Home', 0, '<i class=\"flaticon-paint\"></i>', 0, 1),
(176, 'Insurance', 'Insurance', 0, '<i class=\"flaticon-home\"></i>', 0, 1),
(218, 'Store', 'Stores', 0, '<i class=\"flaticon-commerce\"></i>', 0, 1),
(300, 'Pet & Animal', 'Pets & Animals', 0, '<i class=\"flaticon-animals\"></i>', 0, 1),
(317, 'Professional Service', 'Professional Services', 0, '<i class=\"flaticon-cogwheel\"></i>', 0, 1),
(345, 'Real Estate', 'Real Estate', 0, '<i class=\"flaticon-building\"></i>', 0, 1),
(390, 'Education', 'Education', 0, '<i class=\"flaticon-book\"></i>', 0, 1),
(420, 'Shopping', 'Shopping', 0, '<i class=\"flaticon-commerce-1\"></i>', 0, 1),
(452, 'Travel', 'Travel', 0, '<i class=\"flaticon-transport\"></i>', 0, 1),
(510, 'Beauty', 'Beauty Salon and Spas', 0, '<i class=\"flaticon-beauty\"></i>', 2, 1),
(516, 'Pizza', 'Pizza', 29, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `state` varchar(255) NOT NULL DEFAULT '',
  `state_id` int(11) DEFAULT NULL,
  `slug` varchar(100) NOT NULL DEFAULT '',
  `lat` decimal(10,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities_feat`
--

CREATE TABLE `cities_feat` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '',
  `property` varchar(50) NOT NULL DEFAULT '',
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `type`, `property`, `value`) VALUES
(100, 'plugin', 'plugin_contact_owner', 'a:3:{s:8:\"question\";s:6:\"2 + 3?\";s:6:\"answer\";s:1:\"5\";s:13:\"email_subject\";s:32:\"Message from a DirectoryApp user\";}'),
(164, 'email', 'admin_email', 'admin@example.com'),
(165, 'email', 'dev_email', 'dev@example.com'),
(166, 'email', 'smtp_server', 'mail.example.com'),
(167, 'email', 'smtp_user', 'admin@example.com'),
(168, 'email', 'smtp_pass', 'YOUR_SMTP_PASSWORD'),
(169, 'email', 'smtp_port', '26'),
(170, 'api', 'google_key', 'YOUR_GOOGLE_API_KEY'),
(171, 'display', 'items_per_page', '20'),
(172, 'display', 'site_name', 'Einvie'),
(173, 'display', 'country_name', 'India'),
(174, 'display', 'default_country_code', 'IN'),
(175, 'display', 'default_city_slug', 'odisha'),
(176, 'display', 'default_loc_id', '1'),
(177, 'display', 'timezone', 'Asia/Kolkata'),
(178, 'maps', 'default_lat', '37.3002752813443'),
(179, 'maps', 'default_lng', '-94.482421875'),
(180, 'display', 'html_lang', 'en'),
(181, 'display', 'max_pics', '15'),
(182, 'email', 'mail_after_post', '1'),
(183, 'display', 'paypal_merchant_id', 'PAYPAL_SANDBOX_MERCHANT_ID'),
(184, 'display', 'paypal_bn', 'Directoryapp'),
(185, 'display', 'paypal_checkout_logo_url', 'http://example.com/imgs/checkout_logo.png'),
(186, 'payment', 'currency_code', 'USD'),
(187, 'payment', 'currency_symbol', '$'),
(188, 'payment', 'paypal_locale', 'US'),
(189, 'payment', 'notify_url', 'https://example.com/ipn-handler.php'),
(190, 'payment', 'paypal_mode', '0'),
(191, 'payment', 'paypal_sandbox_merch_id', 'PAYPAL_SANDBOX_MERCHANT_ID'),
(192, 'api', 'facebook_key', 'FACEBOOK_KEY'),
(193, 'api', 'facebook_secret', 'FACEBOOK_SECRET'),
(194, 'api', 'twitter_key', 'TWITTER_KEY'),
(195, 'api', 'twitter_secret', 'TWITTER_SECRET'),
(196, 'payment', '_2checkout_mode', '0'),
(197, 'payment', '_2checkout_sid', '2CHECKOUT_ACCOUNT_ID'),
(198, 'payment', '_2checkout_sandbox_sid', '2CHECKOUT_SANDBOX_ACCOUNT_ID'),
(199, 'payment', '_2checkout_secret', '2CHECKOUT_SECRET'),
(200, 'payment', '_2checkout_currency_code', 'USD'),
(201, 'payment', '_2checkout_currency_symbol', '$'),
(202, 'payment', '_2checkout_lang', 'en'),
(203, 'payment', '_2checkout_notify_url', 'http://example.com/ipn-2checkout.php'),
(204, 'payment', 'mercadopago_mode', '-1'),
(205, 'payment', 'mercadopago_client_id', 'MERCADO_PAGO_ID'),
(206, 'payment', 'mercadopago_client_secret', 'MERCADO_PAGO_CLIENT_SECRET'),
(207, 'payment', 'mercadopago_currency_id', 'BRL'),
(208, 'payment', 'mercadopago_notification_url', 'http://example.com/ipn-mercadopago.php'),
(209, 'payment', 'stripe_mode', '0'),
(210, 'payment', 'stripe_test_secret_key', 'YOUR_TEST_SECRET_KEY'),
(211, 'payment', 'stripe_test_publishable_key', 'YOUR_TEST_PUBLISHABLE_KEY'),
(212, 'payment', 'stripe_live_secret_key', 'YOUR_LIVE_SECRET_KEY'),
(213, 'payment', 'stripe_live_publishable_key', 'YOUR_LIVE_PUBLISHABLE_KEY'),
(214, 'payment', 'stripe_data_currency', 'usd'),
(215, 'payment', 'stripe_currency_symbol', '$'),
(216, 'payment', 'stripe_data_image', 'https://stripe.com/img/v3/home/twitter.png'),
(217, 'payment', 'stripe_data_description', 'Directoryapp membership');

-- --------------------------------------------------------

--
-- Table structure for table `contact_msgs`
--

CREATE TABLE `contact_msgs` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(100) DEFAULT NULL,
  `sender_ip` varchar(100) NOT NULL,
  `place_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(50) NOT NULL DEFAULT '',
  `country_abbr` varchar(50) NOT NULL DEFAULT 'country',
  `slug` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_abbr`, `slug`) VALUES
(1, 'United States', 'US', 'us');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `field_id` int(11) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `values_list` text DEFAULT NULL,
  `tooltip` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `searchable` tinyint(1) NOT NULL DEFAULT 1,
  `field_order` int(11) NOT NULL DEFAULT 0,
  `field_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `type`, `description`, `subject`, `body`) VALUES
(1, 'reset_pass', 'Reset password email', 'Reset your password - Business Directory', 'Hello,\r\n\r\nSomeone has requested a link to change your password on Business Directory. You can do this through the link below. \r\n\r\n%reset_link%\r\n\r\nIf you didn\'t request this, please ignore this email. \r\n\r\nThanks,\r\n\r\nBusiness Directory'),
(2, 'signup_confirm', 'Signup email address confirmation email', 'Welcome to Business Directory! Please confirm your email', 'Hello,\r\n\r\nYou have signed up for Business Directory.\r\n\r\nIf you received this email by mistake, simply delete it. Your account will be removed if you don\'t click the confirmation link below.\r\n\r\nConfirm: %confirm_link%\r\n\r\nThanks,\r\n\r\nBusiness Directory - http://yoursite.com'),
(4, 'subscr_failed', 'Subscription payment failed email', 'Subscription payment failed - Business Directory', 'Hello %username%,\n\nYour subscription payment failed. Please take moment to check your payment info, you may need to update the credit card expiration date, etc. You still have access, we\'ll try again in a few days.\n\nThanks,\n\nBusiness Directory - http://yoursite.com'),
(5, 'subscr_signup', 'Subscription successful email', 'Thank you! Welcome to Business Directory', 'Hello %username%,\r\n\r\nYour subscription is active. The link to your listing is:\r\n\r\n%place_link%.\r\n\r\nYou can edit your listing at any moment by logging into your account.\r\n\r\nThanks,\r\n\r\nBusiness Directory - http://yoursite.com'),
(6, 'web_accept', 'One time payment successful email', 'Thank you! Welcome to Business Directory', 'Hello %username%,\r\n\r\nYour listing is active. The link to your listing is:\r\n\r\n%place_link%.\r\n\r\nYou can edit your listing at any moment by logging into your account.\r\n\r\nThanks,\r\n\r\nBusiness Directory - http://yoursite.com'),
(7, 'subscr_eot', 'Subscription expired email', 'Subscription expired - Business Directory', 'Hello %username%, \r\n\r\nYour subscription on Business Directory expired. The link to your listing is:\r\n\r\n%place_link%.\r\n\r\nThanks,\r\n\r\nBusiness Directory - http://yoursite.com'),
(8, 'web_accept_fail', 'One time payment failed email', 'Your most recent payment failed', 'Hi there,\n\nUnfortunately your most recent payment for your ad on our site was declined. This could be due to a change in your card number or your card expiring, cancelation of your credit card, or the bank not recognizing the payment and taking action to prevent it.\n\nPlease update your payment information as soon as possible by logging in here:\nhttps://yoursite.com/user/login\'\n\nThanks,\n\nBusiness Directory - http://yoursite.com'),
(9, 'process_add_place', 'User submission notification', 'A new listing was submitted', 'Hello,\n\nA new listing was submitted on:\n\nhttp://yoursite.com/admin\n\nthanks'),
(10, 'process_edit_place', 'User edit listing notification', 'A new listing was edited', 'Hello,\r\n\r\nA user has edited a listing on:\r\n\r\nhttp://yoursite.com/admin\r\n\r\nthanks');

-- --------------------------------------------------------

--
-- Table structure for table `event_feed`
--

CREATE TABLE `event_feed` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_feed` varchar(250) NOT NULL,
  `date` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_feed`
--

INSERT INTO `event_feed` (`id`, `event_id`, `user_id`, `event_feed`, `date`, `created_at`) VALUES
(68, 248, 60, 'Yes it\'s a good event', '2024-01-08 16:17:01', '2024-01-08 21:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `event_image`
--

CREATE TABLE `event_image` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_image` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_image`
--

INSERT INTO `event_image` (`id`, `event_id`, `user_id`, `event_image`, `created_at`) VALUES
(201, 248, 60, '08012024094710_82054_0.png', '2024-01-08 16:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `event_invitation`
--

CREATE TABLE `event_invitation` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_invitation`
--

INSERT INTO `event_invitation` (`id`, `event_id`, `image`, `created_at`) VALUES
(1, 216, '02102023084818_53695_.', '2023-10-02 15:18:18'),
(2, 216, '02102023084843_97418_.', '2023-10-02 15:18:43'),
(3, 216, '02102023085048_9304_.', '2023-10-02 15:20:48'),
(4, 216, '02102023085314_93732_.', '2023-10-02 15:23:14'),
(5, 216, '02102023090847_98069_.', '2023-10-02 15:38:47'),
(6, 216, '03102023040110_3333_.', '2023-10-03 10:31:10'),
(7, 216, '03102023040247_61762_.jpg', '2023-10-03 10:32:47'),
(8, 216, '03102023040323_87901_.jpg', '2023-10-03 10:33:23'),
(9, 188, '04102023105758_816_.jpg', '2023-10-04 05:27:58'),
(10, 218, '05102023082047_72662_.jpg', '2023-10-05 14:50:47'),
(11, 218, '05102023082636_64856_.jpg', '2023-10-05 14:56:36'),
(12, 218, '07102023072914_35230_.jpg', '2023-10-07 01:59:14'),
(13, 222, '07102023064236_51651_.jpg', '2023-10-07 13:12:36'),
(14, 228, '17102023014422_39986_.jpg', '2023-10-17 08:14:22'),
(15, 221, '25102023011432_86608_.jpg', '2023-10-25 07:44:32'),
(16, 235, '01112023081614_50276_.jpg', '2023-11-01 14:46:14'),
(17, 221, '03112023074536_63237_.jpg', '2023-11-03 14:15:36'),
(18, 232, '14112023094307_87003_.jpg', '2023-11-14 04:13:07'),
(19, 220, '14112023102942_50979_.jpg', '2023-11-14 04:59:42'),
(20, 236, '14112023120710_37976_.jpg', '2023-11-14 06:37:10'),
(21, 236, '14112023122029_80048_.jpg', '2023-11-14 06:50:29'),
(22, 220, '14112023122827_73310_.jpg', '2023-11-14 06:58:27'),
(23, 220, '15112023091029_88177_.jpg', '2023-11-15 03:40:29'),
(24, 220, '15112023113140_25747_.jpg', '2023-11-15 06:01:40'),
(25, 239, '15112023034546_34637_.jpg', '2023-11-15 10:15:46'),
(26, 239, '15112023035604_24483_.jpg', '2023-11-15 10:26:04'),
(27, 240, '18112023122355_86311_.jpg', '2023-11-18 06:53:55'),
(28, 221, '18112023062157_95202_.jpg', '2023-11-18 12:51:57'),
(29, 244, '28112023050411_81569_.jpg', '2023-11-28 11:34:11'),
(30, 248, '08012024093215_71602_.jpg', '2024-01-08 16:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `event_media_comment`
--

CREATE TABLE `event_media_comment` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_media_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_media_comment`
--

INSERT INTO `event_media_comment` (`id`, `user_id`, `event_id`, `event_media_id`, `comment`, `created_at`, `updated_at`) VALUES
(55, 60, 0, 201, 'It\'s a nice image 😊', '2024-01-08 16:18:53', '2024-01-08 16:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `event_media_comment_dislikes`
--

CREATE TABLE `event_media_comment_dislikes` (
  `id` int(10) NOT NULL,
  `comment_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_media_comment_likes`
--

CREATE TABLE `event_media_comment_likes` (
  `id` int(10) NOT NULL,
  `comment_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `event_media_comment_likes`
--

INSERT INTO `event_media_comment_likes` (`id`, `comment_id`, `user_id`, `created_at`) VALUES
(36, 55, 60, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_media_comment_reply`
--

CREATE TABLE `event_media_comment_reply` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reply` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_media_comment_reply`
--

INSERT INTO `event_media_comment_reply` (`id`, `user_id`, `comment_id`, `reply`, `created_at`, `updated_at`) VALUES
(30, 60, 55, 'Thanks', '2024-01-08 16:19:10', '2024-01-08 16:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `event_media_favourite`
--

CREATE TABLE `event_media_favourite` (
  `id` int(10) NOT NULL,
  `event_media_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `event_media_favourite`
--

INSERT INTO `event_media_favourite` (`id`, `event_media_id`, `user_id`, `created_at`) VALUES
(40, 201, 60, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_media_reply_dislikes`
--

CREATE TABLE `event_media_reply_dislikes` (
  `id` int(10) NOT NULL,
  `comment_reply_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_media_reply_likes`
--

CREATE TABLE `event_media_reply_likes` (
  `id` int(10) NOT NULL,
  `comment_reply_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_reviews`
--

CREATE TABLE `event_reviews` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invitation_card_image`
--

CREATE TABLE `invitation_card_image` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `card_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invitation_card_image`
--

INSERT INTO `invitation_card_image` (`id`, `category_id`, `card_image`) VALUES
(21, 18, '66027_1.1.jpg'),
(22, 18, '85921_2.2.jpg'),
(23, 18, '52546_3.3.jpg'),
(24, 18, '25236_4.4.jpg'),
(25, 18, '84341_5.5.jpg'),
(26, 18, '68705_6.6.jpg'),
(27, 18, '21471_7.7.jpg'),
(28, 18, '91477_8.8.jpg'),
(29, 18, '50939_9.9.jpg'),
(30, 18, '53971_10.10.jpg'),
(31, 19, '93577_'),
(32, 19, '37185_2.2.jpg'),
(33, 19, '10666_3.3.jpg'),
(34, 19, '69857_4.4.jpg'),
(35, 19, '43471_5.5.jpg'),
(36, 19, '25636_6.6.jpg'),
(37, 19, '58359_7.7.jpg'),
(38, 19, '53174_8.8.jpg'),
(39, 19, '75562_9.9.jpg'),
(40, 19, '5530_10.10.jpg'),
(41, 20, '92814_1.1.jpg'),
(42, 20, '80_3.3.jpg'),
(43, 20, '4446_4.4.jpg'),
(44, 20, '81522_5.5.jpg'),
(45, 20, '18198_6.6.jpg'),
(46, 20, '71700_7.7.jpg'),
(47, 20, '89528_8.8.jpg'),
(48, 20, '68459_9.9.jpg'),
(49, 20, '56458_10.10.jpg'),
(50, 26, '9209_1.jpg'),
(51, 26, '78472_2.jpg'),
(52, 26, '73495_3.jpg'),
(54, 26, '9269_5.jpg'),
(55, 26, '91658_6.jpg'),
(56, 26, '83789_7.jpg'),
(57, 26, '19904_8.jpg'),
(58, 26, '71510_9.jpg'),
(59, 26, '38454_10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `loggedin`
--

CREATE TABLE `loggedin` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `provider` varchar(20) NOT NULL DEFAULT 'local',
  `token` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loggedin`
--

INSERT INTO `loggedin` (`id`, `userid`, `provider`, `token`, `created`) VALUES
(6, 1, 'localhost', '37334dd0d6d38a3d9bcdad86faceb6ea8901ff69', '2023-02-09 03:40:52');

-- --------------------------------------------------------

--
-- Table structure for table `neighborhoods`
--

CREATE TABLE `neighborhoods` (
  `neighborhood_id` int(10) NOT NULL,
  `neighborhood_slug` varchar(255) NOT NULL DEFAULT '',
  `neighborhood_name` varchar(255) NOT NULL DEFAULT '',
  `city_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL DEFAULT '',
  `page_slug` varchar(255) NOT NULL DEFAULT '',
  `meta_desc` varchar(255) NOT NULL DEFAULT '',
  `page_contents` mediumtext NOT NULL,
  `page_group` varchar(50) NOT NULL DEFAULT '',
  `page_order` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_title`, `page_slug`, `meta_desc`, `page_contents`, `page_group`, `page_order`) VALUES
(1, 'About', 'about', 'About us', '<h2>About Us</h2>\r\n\r\n<p>\"Your Site\" is a business/place search web application. Users can search for restaurants, nightlife spots, shops, services and other points of interest and leave reviews and tips for other users. Business owners can advertise their services on the site.</p>\r\n\r\n<p>Any business type and points of interest can be submitted to Coopcities. Examples are restaurants, nightlife spots, all kinds of shops, services, etc</p>', 'footer_menu', 0),
(2, 'Privacy Policy', 'privacy-policy', 'Privacy policy', '<h2>Privacy Policy</h2>\r\n\r\n		<p>At \"Your Site\" we are committed to safeguarding and preserving the privacy of our visitors. This Privacy Policy document (the \"Policy\") has been provided by the legal resource DIY Legals and reviewed and approved by their solicitors.</p>\r\n\r\n		<p>This Policy explains what happens to any personal data that you provide to us, or that we collect from you whilst you visit our site and how we use cookies on this website.</p>\r\n\r\n		<p>We do update this Policy from time to time so please do review this Policy regularly.</p>\r\n\r\n		<h3>Information That We Collect</h3>\r\n\r\n		<p>In running and maintaining our website we may collect and process the following data about you:</p>\r\n\r\n		<ul>\r\n		<li>Information about your use of our site including details of your visits such as pages viewed and the resources that you access. Such information includes traffic data, location data and other communication data.</li>\r\n		<li>Information provided voluntarily by you. For example, when you register for information or make a purchase.</li>\r\n		<li>Information that you provide when you communicate with us by any means.</li>\r\n		</ul>\r\n\r\n		<h3>Use of Cookies</h3>\r\n\r\n		<p>Cookies provide information regarding the computer used by a visitor. We may use cookies where appropriate to gather information about your computer in order to assist us in improving our website.</p>\r\n\r\n		<p>We may gather information about your general internet use by using the cookie. Where used, these cookies are downloaded to your computer and stored on the computer’s hard drive. Such information will not identify you personally; it is statistical data which does not identify any personal details whatsoever.</p>\r\n\r\n		<p>Our advertisers may also use cookies, over which we have no control. Such cookies (if used) would be downloaded once you click on advertisements on our website.</p>\r\n\r\n		<p>You can adjust the settings on your computer to decline any cookies if you wish. This can be done within the “settings” section of your computer. For more information please read the advice at AboutCookies.org.</p>\r\n\r\n		<h3>Use of Your Information</h3>\r\n\r\n		<p>We use the information that we collect from you to provide our services to you. In addition to this we may use the information for one or more of the following purposes:</p>\r\n\r\n		<ul>\r\n		<li>To provide information to you that you request from us relating to our products or services.</li>\r\n		<li>To provide information to you relating to other products that may be of interest to you. Such additional information will only be provided where you have consented to receive such information.</li>\r\n		<li>To inform you of any changes to our website, services or goods and products.</li>\r\n		</ul>\r\n\r\n		<p>If you have previously purchased goods or services from us we may provide to you details of similar goods or services, or other goods and services, that you may be interested in.</p>\r\n\r\n		<p><strong>We never give your details to third parties to use your data to enable them to provide you with information regarding unrelated goods or services.</strong></p>\r\n\r\n		<h3>Storing Your Personal Data</h3>\r\n\r\n		<p>In operating our website it may become necessary to transfer data that we collect from you to locations outside of the European Union for processing and storing. By providing your personal data to us, you agree to this transfer, storing and processing. We do our utmost to ensure that all reasonable steps are taken to make sure that your data is stored securely.</p>\r\n\r\n		<p>Unfortunately the sending of information via the internet is not totally secure and on occasion such information can be intercepted. We cannot guarantee the security of data that you choose to send us electronically, sending such information is entirely at your own risk.\r\n		</p>\r\n\r\n		<h3>Disclosing Your Information</h3>\r\n\r\n		<p>We will not disclose your personal information to any other party other than in accordance with this Privacy Policy and in the circumstances detailed below:</p>\r\n\r\n		<ul>\r\n		<li>In the event that we sell any or all of our business to the buyer.</li>\r\n		<li>Where we are legally required by law to disclose your personal information.</li>\r\n		<li>To further fraud protection and reduce the risk of fraud.</li>\r\n		</ul>\r\n\r\n		<h3>Third Party Links</h3>\r\n\r\n		<p>On occasion we include links to third parties on this website. Where we provide a link it does not mean that we endorse or approve that site\'s policy towards visitor privacy. You should review their privacy policy before sending them any personal data.\r\n		</p>\r\n\r\n		<h3>Access to Information</h3>\r\n\r\n		<p>In accordance with the Data Protection Act 1998 you have the right to access any information that we hold relating to you. Please note that we reserve the right to charge a fee of £10 to cover costs incurred by us in providing you with the information.\r\n		</p>\r\n\r\n		<h3>Contacting Us</h3>\r\n\r\n		<p>Please do not hesitate to contact us regarding any matter relating to this Privacy and Cookies Policy via email at <a href=\"mailto:contact@yoursite.com\">contact@yoursite.com</a>.\r\n		</p>', 'footer_menu', 0),
(3, 'index', 'index', '', '<p>hello world</p>', 'index_page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pass_request`
--

CREATE TABLE `pass_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(16) NOT NULL DEFAULT '',
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `dir` varchar(11) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL,
  `place_name` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `postal_code` varchar(20) NOT NULL DEFAULT '',
  `cross_street` varchar(255) NOT NULL DEFAULT '',
  `neighborhood` int(10) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `inside` varchar(50) NOT NULL DEFAULT '',
  `area_code` varchar(25) DEFAULT NULL,
  `phone` varchar(255) NOT NULL DEFAULT '',
  `twitter` varchar(100) NOT NULL DEFAULT '',
  `facebook` varchar(100) NOT NULL DEFAULT '',
  `foursq_id` varchar(50) NOT NULL DEFAULT '',
  `website` varchar(255) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `has_menu` tinyint(1) DEFAULT 0,
  `business_hours_info` varchar(255) NOT NULL DEFAULT '',
  `submission_date` datetime NOT NULL DEFAULT current_timestamp(),
  `origin` varchar(15) NOT NULL DEFAULT 'USER',
  `feat` tinyint(1) NOT NULL DEFAULT 0,
  `feat_home` tinyint(1) NOT NULL DEFAULT 0,
  `plan` int(11) DEFAULT NULL,
  `valid_until` datetime NOT NULL DEFAULT '9999-01-01 00:00:00',
  `status` varchar(10) NOT NULL DEFAULT 'pending',
  `paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_type` varchar(20) NOT NULL DEFAULT '',
  `plan_name` varchar(255) NOT NULL DEFAULT '',
  `plan_description1` varchar(255) NOT NULL DEFAULT '',
  `plan_description2` varchar(255) NOT NULL DEFAULT '',
  `plan_description3` varchar(255) NOT NULL DEFAULT '',
  `plan_description4` varchar(255) NOT NULL DEFAULT '',
  `plan_description5` varchar(255) NOT NULL DEFAULT '',
  `plan_period` int(10) NOT NULL DEFAULT 0,
  `plan_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `plan_order` int(11) NOT NULL DEFAULT 0,
  `plan_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_type`, `plan_name`, `plan_description1`, `plan_description2`, `plan_description3`, `plan_description4`, `plan_description5`, `plan_period`, `plan_price`, `plan_order`, `plan_status`) VALUES
(1, 'monthly', 'Monthly', '<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Upload photos', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Included at the top of city and categoy results', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Pay monthly', '', 0, 2.90, 5, -1),
(2, 'monthly_feat', 'Monthly Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Upload photos', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Included at the top of city and categoy results', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Pay monthly', '', 0, 3.90, 6, -1),
(3, 'one_time_feat', 'Long Term Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Upload photos', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Included at the top of city and categoy results', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Pay once for a permanent ad', '', 4, 2.00, 4, -1),
(8, 'one_time', 'Long Term', '<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>  Upload photos', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Included at the top of city and categoy results', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> No recurring fees', '', 3, 1.00, 3, -1),
(19, 'free', 'Free Listings', '<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Upload photos', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Included at the top of city and categoy results', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Permanent ad', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> 100% Free', 1, 0.00, 1, 1),
(20, 'free_feat', 'Free Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Featured', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Upload photos', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Included at the top of city and categoy results', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Permanent ad', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i> 100% Free', 2, 0.00, 2, -1),
(21, 'monthly_feat', 'Monthly Featured', '', '', '', '', '', 0, 3.90, 0, -1);

-- --------------------------------------------------------

--
-- Table structure for table `rel_cat_custom_fields`
--

CREATE TABLE `rel_cat_custom_fields` (
  `rel_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT 0,
  `field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_place_cat`
--

CREATE TABLE `rel_place_cat` (
  `id` int(11) NOT NULL,
  `place_id` int(11) DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_place_custom_fields`
--

CREATE TABLE `rel_place_custom_fields` (
  `rel_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `field_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL,
  `pubdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signup_confirm`
--

CREATE TABLE `signup_confirm` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `confirm_str` varchar(16) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(50) NOT NULL,
  `state_abbr` varchar(50) NOT NULL DEFAULT '',
  `slug` varchar(100) NOT NULL DEFAULT '',
  `country_abbr` varchar(50) DEFAULT 'country',
  `country_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_active_log`
--

CREATE TABLE `tbl_active_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_active_log`
--

INSERT INTO `tbl_active_log` (`id`, `user_id`, `date_time`) VALUES
(52, 58, '1721109762'),
(54, 60, '1709264068'),
(55, 61, '1730001554'),
(56, 62, '1707585366'),
(57, 57, '1732928028');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'fridayevents.einvie@gmail.com', 'Logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `category_icon` text NOT NULL,
  `bg_color_rgba` varchar(50) NOT NULL,
  `app_bg_color_rgba` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `category_icon`, `bg_color_rgba`, `app_bg_color_rgba`, `status`) VALUES
(18, 'Dussehra', '58854_', '37266_bg__dussehra.jpg', 'rgba(232, 15, 12, 1)', '#ffe80f0c', 1),
(19, 'Birthday', '93585_images (15).jpeg', '83201_99231-confetti-birthday-happy-hd-image-free.png', 'rgba(6, 176, 8, 1)', '#ff06b008', 1),
(20, 'Diwali', '15283_', '80509_bg__', 'rgba(21, 223, 237, 1)', '#ff15dfed', 1),
(21, 'Entertainment ', '69610_', '67599_bg__', 'rgba(93, 130, 61, 1)', '#ff5d823d', 1),
(22, 'Holi', '81947_', '6447_bg__', 'rgba(119, 156, 6, 1)', '#ff779c06', 1),
(23, 'Festival ', '50919_', '1787_bg__', 'rgba(46, 42, 117, 1)', '#ff2e2a75', 1),
(24, 'Pongal', '32989_', '84245_bg__', 'rgba(31, 115, 128, 1)', '#ff1f7380', 1),
(25, 'Rajo', '53414_', '51958_bg__', 'rgba(24, 122, 63, 1)', '#ff187a3f', 1),
(26, 'Wedding', '65173_wedding.1.jpg', '50798_bg__wedding.jpg', 'rgba(247, 61, 10, 1)', '#fff73d0a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_list`
--

CREATE TABLE `tbl_contact_list` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone` varchar(30) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_subject` int(5) NOT NULL,
  `contact_msg` text NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_sub`
--

CREATE TABLE `tbl_contact_sub` (
  `id` int(5) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_contact_sub`
--

INSERT INTO `tbl_contact_sub` (`id`, `title`, `status`) VALUES
(1, 'Event Copyright', 1),
(2, 'Event Spam', 1),
(3, 'Other', 1),
(4, 'Event cancelation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `event_title` varchar(500) NOT NULL,
  `event_start_date` int(11) NOT NULL,
  `event_start_time` varchar(255) NOT NULL,
  `event_end_date` int(11) NOT NULL,
  `event_end_time` varchar(255) NOT NULL,
  `registration_start` varchar(255) DEFAULT NULL,
  `registration_end` varchar(255) DEFAULT NULL,
  `event_ticket` int(5) DEFAULT NULL,
  `person_wise_ticket` int(5) DEFAULT 1,
  `ticket_price` double DEFAULT NULL,
  `event_email` varchar(255) NOT NULL,
  `event_phone` varchar(255) NOT NULL,
  `event_website` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_logo` varchar(255) NOT NULL,
  `event_banner` varchar(255) NOT NULL,
  `event_address` varchar(500) NOT NULL,
  `event_map_latitude` varchar(255) NOT NULL,
  `event_map_longitude` varchar(255) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT 0,
  `registration_closed` varchar(10) NOT NULL DEFAULT 'false',
  `close_open_date` varchar(255) NOT NULL,
  `is_slider` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `website` varchar(191) DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`id`, `user_id`, `cat_id`, `event_title`, `event_start_date`, `event_start_time`, `event_end_date`, `event_end_time`, `registration_start`, `registration_end`, `event_ticket`, `person_wise_ticket`, `ticket_price`, `event_email`, `event_phone`, `event_website`, `event_description`, `event_logo`, `event_banner`, `event_address`, `event_map_latitude`, `event_map_longitude`, `total_views`, `registration_closed`, `close_open_date`, `is_slider`, `status`, `website`) VALUES
(246, 0, 21, 'New year Gathering', 1703874600, '1703907000', 1703874600, '1703889000', '', '', 0, 0, 0, 'pintubhol.031992@gmail.com', '9776015883', '', 'Fun Friends and Food', '30122023070847_33208.png', '30122023070858_7695.png', 'Dhauli hill Shanti Stupa, Bhubaneswar, Odisha, India', '20.1924168', '85.839461', 0, 'false', '', 1, 1, 'private'),
(248, 60, 19, 'Test Event', 1706553000, '1704728400', 1706553000, '1704696000', '', '', 0, 0, 0, 'debendraster@gmail.com', '7008124707', '', 'My Birth Day Celebration', '08012024092356_57278.png', '08012024094348_64458_banner.png', 'Barimunda, Odisha, India', '20.4201635', '86.045045', 0, '', '1704731032', 0, 1, 'private'),
(249, 61, 19, 'Pintu\\\'s Birthday', 1705861800, '1705909320', 1705861800, '1705909320', '', '', 0, 0, 0, '.', '9776015883', '', '..', '22012024014314_11018.png', '22012024014318_79778.png', 'Crystal Heritage Events and Conference Centre, Parakin Road, Ife, Nigeria', '20.2771126', '85.7937363', 0, 'false', '', 0, 1, 'private'),
(250, 61, 21, 'Pintu\\\'s Barat', 1718735400, '1717941600', 1718821800, '1717871400', '', '', 0, 0, 0, 'pintubhol.db@gmail.com', '9776015883', '', 'Join pintu\\\'s Barat to  Yashoda Garden.', '09062024050601_452.png', '09062024050601_50171.png', 'YASHODA GARDEN, Sri Krishna Vihar, Jhinkiria, Cuttack, Odisha, India', '20.4240909', '85.9123438', 0, 'false', '', 0, 0, 'private'),
(251, 61, 21, 'Pintu\\\'s Barat', 1718735400, '1717941600', 1718821800, '1717871400', '', '', 0, 0, 0, 'pintubhol.db@gmail.com', '9776015883', '', 'Join pintu\\\'s Barat to  Yashoda Garden.', '09062024050619_71701.png', '09062024050619_24333.png', 'YASHODA GARDEN, Sri Krishna Vihar, Jhinkiria, Cuttack, Odisha, India', '20.4240909', '85.9123438', 0, 'false', '', 0, 0, 'private'),
(252, 61, 21, 'Pintu\\\'s Barat', 1718735400, '1717941600', 1718821800, '1717871400', '', '', 0, 0, 0, 'pintubhol.db@gmail.com', '9776015883', '', 'Join pintu\\\'s Barat to  Yashoda Garden.', '09062024050632_26894.png', '09062024050632_71889.png', 'YASHODA GARDEN, Sri Krishna Vihar, Jhinkiria, Cuttack, Odisha, India', '20.4240909', '85.9123438', 0, 'false', '', 1, 1, 'private');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_booking`
--

CREATE TABLE `tbl_event_booking` (
  `id` int(10) NOT NULL,
  `event_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `ticket_no` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_email` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_phone` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `total_ticket` int(5) NOT NULL DEFAULT 1,
  `user_message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_event_booking`
--

INSERT INTO `tbl_event_booking` (`id`, `event_id`, `user_id`, `ticket_no`, `user_name`, `user_email`, `user_phone`, `total_ticket`, `user_message`, `created_at`) VALUES
(134, 249, 62, NULL, NULL, NULL, NULL, 1, NULL, '1707585366');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_cover`
--

CREATE TABLE `tbl_event_cover` (
  `id` int(10) NOT NULL,
  `event_id` int(5) NOT NULL,
  `image_file` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_event_cover`
--

INSERT INTO `tbl_event_cover` (`id`, `event_id`, `image_file`) VALUES
(389, 246, '30122023070858_95057_0.png'),
(391, 248, '08012024092356_96458_0.png'),
(392, 248, '08012024094348_67770_0.png'),
(393, 249, '22012024014323_79946_0.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favourite`
--

CREATE TABLE `tbl_favourite` (
  `id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recent`
--

CREATE TABLE `tbl_recent` (
  `re_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `recent_date` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_recent`
--

INSERT INTO `tbl_recent` (`re_id`, `user_id`, `event_id`, `recent_date`) VALUES
(160, 60, '248', '2024-01-08'),
(161, 61, '249', '2024-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(11) NOT NULL,
  `event_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `envato_buyer_name` varchar(255) NOT NULL,
  `envato_purchase_code` varchar(255) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT 0,
  `package_name` varchar(255) NOT NULL,
  `envato_buyer_email` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(500) NOT NULL,
  `onesignal_rest_key` varchar(500) NOT NULL,
  `google_map_key` varchar(500) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_developed_by` varchar(255) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `app_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `app_new_version` double NOT NULL DEFAULT 1,
  `app_update_desc` text NOT NULL,
  `app_redirect_url` text NOT NULL,
  `cancel_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `api_latest_limit` int(3) NOT NULL,
  `api_cat_order_by` varchar(255) NOT NULL,
  `api_cat_post_order_by` varchar(255) NOT NULL,
  `publisher_id` text NOT NULL,
  `interstital_ad` text NOT NULL,
  `interstital_ad_id` text NOT NULL,
  `interstital_ad_click` int(11) NOT NULL,
  `banner_ad` text NOT NULL,
  `banner_ad_id` text NOT NULL,
  `banner_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `banner_facebook_id` text NOT NULL,
  `interstital_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `interstital_facebook_id` text NOT NULL,
  `page_limit` int(5) NOT NULL,
  `app_faq` text NOT NULL,
  `api_recent_limit` int(5) NOT NULL DEFAULT 5,
  `app_terms_conditions` text NOT NULL,
  `account_delete_intruction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `envato_buyer_name`, `envato_purchase_code`, `envato_purchased_status`, `package_name`, `envato_buyer_email`, `onesignal_app_id`, `onesignal_rest_key`, `google_map_key`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `email_from`, `app_privacy_policy`, `app_update_status`, `app_new_version`, `app_update_desc`, `app_redirect_url`, `cancel_update_status`, `api_latest_limit`, `api_cat_order_by`, `api_cat_post_order_by`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `banner_ad_type`, `banner_facebook_id`, `interstital_ad_type`, `interstital_facebook_id`, `page_limit`, `app_faq`, `api_recent_limit`, `app_terms_conditions`, `account_delete_intruction`) VALUES
(1, 'codegood.net', 'FD8B-C364-A52D-8966', 1, 'com.example.eventapp', '', '7a381100-77d3-4bf0-b2a0-31a5758b591c', 'MjAwOTk4Y2MtYjY0Yi00NWQwLTk2NmUtNzQ3MWE2YTUyMjM3', '-', 'Einvie', 'app_icon.png', 'debendraster@gmail.com', '1.0.0', 'Friday Events Private Limited', '+91 700 812 4707', 'www.einvie.com', '<p>Tracking an event was never this easy. Einvie app is built for the organizers who wants to grow their event reach and manage it easily. Our valued event organizers are now using it to keep a record of every attendee and manage ticketing for each just at the touch of a screen.<br />\r\n<br />\r\nEinvie&nbsp; App lets you manage your different organizer profiles, track total event page visits, no. of attendees, ticket sold and revenue generated. Event Analytics was never this easy.</p>\r\n', 'Friday Events Private Limited', '-', '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the India is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Einvie may work with third parties for the purpose of delivering targeted behavioural advertising to the Einvie website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at fridayeventsbbsr@gmail.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\r\n', 'false', 2, 'kindly you can update new version app', 'https://event.infydemo.in/', 'false', 0, 'category_name', 'ASC', 'pub-3940256099942544', 'false', 'ca-app-pub-3940256099942544/1033173712', 4, 'false', 'ca-app-pub-3940256099942544/6300978111', 'admob', 'IMG_16_9_APP_INSTALL#293685261999350_293692201998656', 'admob', 'IMG_16_9_APP_INSTALL#293685261999350_293692201998656', 5, '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>', 5, '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the India is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Einvie may work with third parties for the purpose of delivering targeted behavioural advertising to the Einvie website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at fridayeventsbbsr@gmail.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>', '<p><strong>Contact&nbsp;</strong></p>\r\n\r\n<p><strong>Email :-&nbsp;&nbsp;</strong><strong>fridayeventsbbsr@gmail.com</strong></p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL DEFAULT 0,
  `slider_type` varchar(30) DEFAULT NULL,
  `slider_title` varchar(150) DEFAULT NULL,
  `external_url` text DEFAULT NULL,
  `external_image` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `event_id`, `slider_type`, `slider_title`, `external_url`, `external_image`, `status`) VALUES
(53, 246, 'Event', '', '', '', 1),
(54, 252, 'Event', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_type` varchar(20) NOT NULL,
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL,
  `smtp_ghost` varchar(150) NOT NULL,
  `smtp_gemail` varchar(150) NOT NULL,
  `smtp_gpassword` text NOT NULL,
  `smtp_gsecure` varchar(20) NOT NULL,
  `gport_no` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'gmail', 'test@gmail.com', 'test12@gmail.com', 'test', 'ssl', '465', 'smtp.gmail.com', 'fridayeventsbbsr@gmail.com', 'qkflzrvduitiiobg', 'tls', '587');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `device_id` text NOT NULL,
  `auth_id` text NOT NULL,
  `is_duplicate` int(1) NOT NULL DEFAULT 0,
  `user_image` varchar(255) DEFAULT NULL,
  `confirm_code` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `name`, `email`, `password`, `phone`, `city`, `address`, `device_id`, `auth_id`, `is_duplicate`, `user_image`, `confirm_code`, `status`, `created_at`) VALUES
(0, '', 'Admin', 'admin@gmail.com', '', '', '', '', '', '', 0, NULL, '0', '1', '-'),
(57, 'Normal', 'Manisha samantaray', 'msamantaray45@gmail.com', 'fa81c3244dafb7d69b60163f1bdf1eaf', '8249142262', '', '', '', '', 1, NULL, '0', '1', '1703776560'),
(58, 'Normal', 'Reshab Agarwal', 'reshabagarwal700@gmail.com', '5525a66a8f9daae2e28c73ded0ebe598', '9609344226', '', '', '', '', 1, NULL, '0', '1', '1703825220'),
(60, 'Normal', 'Debendra Sahoo', 'debendraster@gmail.com', '794fd8df6686e85e0d8345670d2cd4ae', '7008124707', '', '', '', '', 1, NULL, '0', '1', '1704728520'),
(61, 'Normal', 'Pintu Bhol', 'pintubhol.db@gmail.com', 'fa6cd39d0ac2e6d6045bd536426a6a48', '9776015883', '', '', '', '', 1, NULL, '0', '1', '1704730140'),
(62, 'Normal', 'San', 'swastiksamanta7@gmail.com', 'e14c05f0dc27e6be1fc127abaf474a59', '9196203799', '', '', '', '', 1, NULL, '0', '1', '1704730800'),
(63, 'Normal', 'Samim', 'samim@gmail.com', 'e1409374882b017c0a850ba1bede86c0', '122545245645', 'udala', 'udala', '', '', 0, NULL, '0', '0', '1729317829'),
(64, 'Normal', 'Uttam kumar mohanta', 'uttamkumarmohanta43@gmail.com', '8114cab64480ae63c05a2980d767850a', '9583722121', 'bbsr', 'bbsr', '', '', 0, '9898_download (2).jfif', '0', '0', '1729319995');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_photos`
--

CREATE TABLE `tmp_photos` (
  `id` int(11) NOT NULL,
  `submit_token` varchar(50) NOT NULL DEFAULT '',
  `filename` varchar(50) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `ipn_description` varchar(50) NOT NULL DEFAULT '',
  `place_id` int(11) DEFAULT NULL,
  `payer_email` varchar(100) NOT NULL DEFAULT '',
  `txn_type` varchar(50) NOT NULL DEFAULT '',
  `payment_status` varchar(50) NOT NULL DEFAULT '',
  `amount` decimal(4,2) DEFAULT NULL,
  `txn_id` varchar(50) NOT NULL DEFAULT '',
  `parent_txn_id` varchar(50) NOT NULL DEFAULT '',
  `subscr_id` varchar(50) NOT NULL DEFAULT '',
  `ipn_response` varchar(255) NOT NULL DEFAULT '',
  `ipn_vars` text DEFAULT NULL,
  `txn_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `city_name` varchar(100) NOT NULL DEFAULT '',
  `country_name` varchar(25) NOT NULL DEFAULT '',
  `gender` varchar(1) NOT NULL DEFAULT '',
  `b_year` int(4) DEFAULT NULL,
  `b_month` int(2) DEFAULT NULL,
  `b_day` int(2) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `hybridauth_provider_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT 'Provider name',
  `hybridauth_provider_uid` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT 'Provider user ID',
  `ip_addr` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'pending',
  `profile_pic_status` varchar(10) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `city_name`, `country_name`, `gender`, `b_year`, `b_month`, `b_day`, `created`, `hybridauth_provider_name`, `hybridauth_provider_uid`, `ip_addr`, `status`, `profile_pic_status`) VALUES
(1, 'admin@example.com', '$2y$10$jfsZ/m7YKzoy49aJCB9zYu3wPTxKH3ArEEF1OXoTHWE3hqh71T78i', 'Admin', '', '', '', '', NULL, NULL, 0, '2016-03-19 23:24:10', 'local', '', '', 'approved', 'approved'),
(3700, 'debendraster@gmail.com', '$2y$10$ZazOQAiV9r15lvFGyfJ6yuL2hTIvStfgE71RqluUzY7z00zS7I2r6', 'Debendra', 'Sahoo', '', '', '', NULL, NULL, NULL, '2023-01-04 15:07:59', 'local', '', '2409:4062:238a:fa66:985e:52b8:e668:ea1a', 'pending', 'none'),
(3701, 'pintubhol.031992@gmail.com', '$2y$10$gg6yFJ8L1UOLoSJTPMwETucxdNF4pm49yEfEsm.HcskomtfP1pYti', 'pintu', 'bhol', '', '', '', NULL, NULL, NULL, '2023-02-02 07:12:03', 'local', '', '2401:4900:7011:7aad:6570:1f93:95b8:9260', 'pending', 'none'),
(3702, 'jenamani.ashis@gmail.com', '$2y$10$KUat.LklvhOOZdKKP84YM.FlHKspdnF04bj5Am6apuogAX1tJu.JW', 'Ashis', 'Jena', '', '', '', NULL, NULL, NULL, '2023-02-02 07:16:52', 'local', '', '2405:201:a000:5231:915:d991:d4e0:5bd7', 'pending', 'none'),
(3703, 'test@test.com', '$2y$10$jfsZ/m7YKzoy49aJCB9zYu3wPTxKH3ArEEF1OXoTHWE3hqh71T78i', 'Debendra', 'Sahoo', '', '', '', NULL, NULL, NULL, '2023-02-09 03:36:41', 'local', '', '2405:201:a00a:a0de:35f7:b222:dddd:ece7', 'pending', 'none');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business_hours`
--
ALTER TABLE `business_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `cat_status` (`cat_status`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `cities_feat`
--
ALTER TABLE `cities_feat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city_id` (`city_id`) USING BTREE;

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_msgs`
--
ALTER TABLE `contact_msgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_feed`
--
ALTER TABLE `event_feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_image`
--
ALTER TABLE `event_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_invitation`
--
ALTER TABLE `event_invitation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_comment`
--
ALTER TABLE `event_media_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_comment_dislikes`
--
ALTER TABLE `event_media_comment_dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_comment_likes`
--
ALTER TABLE `event_media_comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_comment_reply`
--
ALTER TABLE `event_media_comment_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_favourite`
--
ALTER TABLE `event_media_favourite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_reply_dislikes`
--
ALTER TABLE `event_media_reply_dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_media_reply_likes`
--
ALTER TABLE `event_media_reply_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitation_card_image`
--
ALTER TABLE `invitation_card_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loggedin`
--
ALTER TABLE `loggedin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  ADD PRIMARY KEY (`neighborhood_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `pass_request`
--
ALTER TABLE `pass_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`),
  ADD KEY `area_code` (`area_code`),
  ADD KEY `userid` (`userid`),
  ADD KEY `status` (`status`),
  ADD KEY `neighborhood` (`neighborhood`),
  ADD KEY `city_id` (`city_id`);
ALTER TABLE `places` ADD FULLTEXT KEY `place_name_descrip` (`place_name`,`description`);
ALTER TABLE `places` ADD FULLTEXT KEY `description` (`description`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `rel_cat_custom_fields`
--
ALTER TABLE `rel_cat_custom_fields`
  ADD PRIMARY KEY (`rel_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indexes for table `rel_place_cat`
--
ALTER TABLE `rel_place_cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `place_x_cat` (`place_id`,`cat_id`) USING BTREE,
  ADD KEY `place_id` (`place_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `rel_place_custom_fields`
--
ALTER TABLE `rel_place_custom_fields`
  ADD PRIMARY KEY (`rel_id`),
  ADD KEY `option_id` (`field_id`),
  ADD KEY `place_id` (`place_id`);
ALTER TABLE `rel_place_custom_fields` ADD FULLTEXT KEY `field_value` (`field_value`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `signup_confirm`
--
ALTER TABLE `signup_confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_event_booking`
--
ALTER TABLE `tbl_event_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_event_cover`
--
ALTER TABLE `tbl_event_cover`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_recent`
--
ALTER TABLE `tbl_recent`
  ADD PRIMARY KEY (`re_id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_photos`
--
ALTER TABLE `tmp_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filename` (`filename`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business_hours`
--
ALTER TABLE `business_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `cities_feat`
--
ALTER TABLE `cities_feat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `contact_msgs`
--
ALTER TABLE `contact_msgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_feed`
--
ALTER TABLE `event_feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `event_image`
--
ALTER TABLE `event_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `event_invitation`
--
ALTER TABLE `event_invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `event_media_comment`
--
ALTER TABLE `event_media_comment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `event_media_comment_dislikes`
--
ALTER TABLE `event_media_comment_dislikes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_media_comment_likes`
--
ALTER TABLE `event_media_comment_likes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `event_media_comment_reply`
--
ALTER TABLE `event_media_comment_reply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `event_media_favourite`
--
ALTER TABLE `event_media_favourite`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `event_media_reply_dislikes`
--
ALTER TABLE `event_media_reply_dislikes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_media_reply_likes`
--
ALTER TABLE `event_media_reply_likes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invitation_card_image`
--
ALTER TABLE `invitation_card_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `loggedin`
--
ALTER TABLE `loggedin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  MODIFY `neighborhood_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pass_request`
--
ALTER TABLE `pass_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rel_cat_custom_fields`
--
ALTER TABLE `rel_cat_custom_fields`
  MODIFY `rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `rel_place_cat`
--
ALTER TABLE `rel_place_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `rel_place_custom_fields`
--
ALTER TABLE `rel_place_custom_fields`
  MODIFY `rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20000;

--
-- AUTO_INCREMENT for table `signup_confirm`
--
ALTER TABLE `signup_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `tbl_event_booking`
--
ALTER TABLE `tbl_event_booking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `tbl_event_cover`
--
ALTER TABLE `tbl_event_cover`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_recent`
--
ALTER TABLE `tbl_recent`
  MODIFY `re_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tmp_photos`
--
ALTER TABLE `tmp_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3704;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `business_hours`
--
ALTER TABLE `business_hours`
  ADD CONSTRAINT `business_hours_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities_feat`
--
ALTER TABLE `cities_feat`
  ADD CONSTRAINT `cities_feat_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loggedin`
--
ALTER TABLE `loggedin`
  ADD CONSTRAINT `loggedin_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pass_request`
--
ALTER TABLE `pass_request`
  ADD CONSTRAINT `pass_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rel_cat_custom_fields`
--
ALTER TABLE `rel_cat_custom_fields`
  ADD CONSTRAINT `rel_cat_custom_fields_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_cat_custom_fields_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rel_place_cat`
--
ALTER TABLE `rel_place_cat`
  ADD CONSTRAINT `rel_place_cat_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_place_cat_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rel_place_custom_fields`
--
ALTER TABLE `rel_place_custom_fields`
  ADD CONSTRAINT `rel_place_custom_fields_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_place_custom_fields_ibfk_3` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `signup_confirm`
--
ALTER TABLE `signup_confirm`
  ADD CONSTRAINT `signup_confirm_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
