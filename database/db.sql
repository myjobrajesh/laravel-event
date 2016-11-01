/* Database file to run */

--
-- Database: `crossover_events`
--
CREATE DATABASE IF NOT EXISTS `crossover_events`;
USE `crossover_events`;

-- --------------------------------------------------------
--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `created_user_id` bigint(20) unsigned NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_start_date` (`start_date`),
  KEY `events_created_user_id` (`created_user_id`),
  KEY `events_end_date` (`end_date`),
  KEY `events_location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `location_id`, `created_user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vibrant Seminar', 'Pls attend...', '2016-11-01 10:00:00', '2016-11-05 20:00:00', 1, 1, 'active', '2016-10-27 00:00:00', NULL),
(2, 'Craft Exhibition', 'Handicraft and partial ', '2016-11-07 09:00:00', '2016-11-11 20:00:00', 2, 1, 'active', '2016-10-27 14:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_bookings`
--

CREATE TABLE IF NOT EXISTS `event_bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `stand_id` bigint(20) unsigned NOT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `company_logopath` varchar(200) DEFAULT NULL,
  `company_admin_name` varchar(200) DEFAULT NULL,
  `company_email` varchar(200) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_booking_event_id` (`event_id`),
  KEY `event_booking_stand_id` (`stand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_booking_documents`
--

CREATE TABLE IF NOT EXISTS `event_booking_documents` (
  `booking_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `filepath` varchar(100) NOT NULL,
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_stands`
--

CREATE TABLE IF NOT EXISTS `event_stands` (
  `event_id` bigint(20) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `filepath` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_stands_event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `event_stands`
--

INSERT INTO `event_stands` (`event_id`, `id`, `price`, `name`, `description`, `filepath`, `created_at`, `updated_at`) VALUES
(1, 1, 2000, 'Stand1', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 2, 1000, 'Stand 2', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 3, 2200, 'Stand 3', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 4, 1100, 'Stand 4', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 5, 2400, 'Stand 5', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 6, 1200, 'stand 6', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 7, 2100, 'Stand 7', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL),
(1, 8, 1800, 'Stand 8', 'Fully vantilated and 4 to 5 setting with 1 table and 1 unit of display', '/uploads/stands/stand1.jpeg', '2016-10-27 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city_name` varchar(100) NOT NULL COMMENT 'only display purpose',
  `state_name` varchar(100) NOT NULL COMMENT 'only display purpose',
  `country_name` varchar(100) NOT NULL COMMENT 'only display purpose',
  `zipcode` varchar(10) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locations_city_name` (`city_name`),
  KEY `locations_state_name` (`state_name`),
  KEY `locations_country_name` (`country_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `city_name`, `state_name`, `country_name`, `zipcode`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, '', '', 'Acmar', 'Alabama', 'United States', '35004', '33.584132', '-86.515570', '2016-10-27 11:00:00', NULL),
(2, '', '', 'Adamsville', 'Alabama', 'United States', '35005', '33.588437', '-86.959727', '2016-10-27 11:00:00', NULL),
(3, '', '', 'Adger', 'Alabama', 'United States', '35006', '33.434277', '-87.167455', '2016-10-27 11:00:00', NULL),
(4, '', '', 'Keystone', 'Alabama', 'United States', '35007', '33.236868', '-86.812861', '2016-10-27 11:00:00', NULL),
(5, '', '', 'New Site', 'Alabama', 'United States', '35010', '32.941445', '-85.951086', '2016-10-27 11:00:00', NULL),
(6, '', '', 'Alpine', 'Alabama', 'United States', '35014', '33.331165', '-86.208934', '2016-10-27 11:00:00', NULL),
(7, '', '', 'Arab', 'Alabama', 'United States', '35016', '34.328339', '-86.489638', '2016-10-27 11:00:00', NULL),
(8, '', '', 'Baileyton', 'Alabama', 'United States', '35019', '34.268298', '-86.621299', '2016-10-27 11:00:00', NULL),
(9, '', '', 'Bessemer', 'Alabama', 'United States', '35020', '33.409002', '-86.947547', '2016-10-27 11:00:00', NULL),
(10, '', '', 'Hueytown', 'Alabama', 'United States', '35023', '33.414625', '-86.999607', '2016-10-27 11:00:00', NULL),
(11, '', '', 'Blountsville', 'Alabama', 'United States', '35031', '34.092937', '-86.568628', '2016-10-27 11:00:00', NULL),
(12, '', '', 'Bremen', 'Alabama', 'United States', '35033', '33.973664', '-87.004281', '2016-10-27 11:00:00', NULL),
(13, '', '', 'Brent', 'Alabama', 'United States', '35034', '32.935670', '-87.211387', '2016-10-27 11:00:00', NULL),
(14, '', '', 'Brierfield', 'Alabama', 'United States', '35035', '33.042747', '-86.951672', '2016-10-27 11:00:00', NULL),
(15, '', '', 'Calera', 'Alabama', 'United States', '35040', '33.109800', '-86.755987', '2016-10-27 11:00:00', NULL),
(16, '', '', 'Centreville', 'Alabama', 'United States', '35042', '32.950324', '-87.119240', '2016-10-27 11:00:00', NULL),
(17, '', '', 'Chelsea', 'Alabama', 'United States', '35043', '33.371582', '-86.614132', '2016-10-27 11:00:00', NULL),
(18, '', '', 'Coosa Pines', 'Alabama', 'United States', '35044', '33.266928', '-86.337622', '2016-10-27 11:00:00', NULL),
(19, '', '', 'Clanton', 'Alabama', 'United States', '35045', '32.835532', '-86.642472', '2016-10-27 11:00:00', NULL),
(20, '', '', 'Cleveland', 'Alabama', 'United States', '35049', '33.992106', '-86.559355', '2016-10-27 11:00:00', NULL),
(21, '', '', 'Columbiana', 'Alabama', 'United States', '35051', '33.176964', '-86.616145', '2016-10-27 11:00:00', NULL),
(22, '', '', 'Crane Hill', 'Alabama', 'United States', '35053', '34.082117', '-87.048395', '2016-10-27 11:00:00', NULL),
(23, '', '', 'Cropwell', 'Alabama', 'United States', '35054', '33.506448', '-86.280026', '2016-10-27 11:00:00', NULL),
(24, '', '', 'Cullman', 'Alabama', 'United States', '35055', '34.176146', '-86.829777', '2016-10-27 11:00:00', NULL);

-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `user_type` enum('admin','regular') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'regular',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `status`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'rajesh', 'myjob.rajesh@gmail.com', '$2y$10$m4GtP1LFd7A4wYrFYNP/mO8WaAXdzkvimLZRf04/Uo2wvQ6DSbMbW', NULL, 'active', 'regular', '2016-10-26 18:30:00', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `events_fk_user_id` FOREIGN KEY (`created_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `event_bookings`
--
ALTER TABLE `event_bookings`
  ADD CONSTRAINT `event_booking_fk_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `event_booking_fk_stand_id` FOREIGN KEY (`stand_id`) REFERENCES `event_stands` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `event_booking_documents`
--
ALTER TABLE `event_booking_documents`
  ADD CONSTRAINT `event_booking_fk_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `event_bookings` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `event_stands`
--
ALTER TABLE `event_stands`
  ADD CONSTRAINT `event_stands_fk_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
