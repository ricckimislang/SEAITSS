-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 13, 2024 at 07:46 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `feedback_text` text,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`),
  KEY `survey_id` (`survey_id`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responsedetails`
--

DROP TABLE IF EXISTS `responsedetails`;
CREATE TABLE IF NOT EXISTS `responsedetails` (
  `response_detail_id` int NOT NULL AUTO_INCREMENT,
  `response_id` int NOT NULL,
  `question_id` int NOT NULL,
  `response_text` text,
  `selected_option` varchar(255) DEFAULT NULL,
  `rating` int DEFAULT NULL,
  PRIMARY KEY (`response_detail_id`),
  KEY `response_id` (`response_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `responsedetails`
--

INSERT INTO `responsedetails` (`response_detail_id`, `response_id`, `question_id`, `response_text`, `selected_option`, `rating`) VALUES
(43, 4, 32, 'Hire more more', NULL, NULL),
(42, 4, 31, NULL, NULL, 1),
(41, 4, 30, NULL, NULL, 1),
(40, 4, 29, NULL, NULL, 1),
(39, 4, 28, NULL, NULL, 1),
(38, 4, 27, NULL, NULL, 5),
(37, 4, 26, NULL, NULL, 5),
(36, 4, 25, NULL, NULL, 5),
(35, 4, 24, NULL, NULL, 5),
(34, 4, 23, NULL, NULL, 5),
(33, 3, 33, 'None', NULL, NULL),
(32, 3, 32, 'Hire more more', NULL, NULL),
(31, 3, 31, NULL, NULL, 5),
(30, 3, 30, NULL, NULL, 3),
(29, 3, 29, NULL, NULL, 5),
(28, 3, 28, NULL, NULL, 1),
(27, 3, 27, NULL, NULL, 5),
(26, 3, 26, NULL, NULL, 5),
(25, 3, 25, NULL, NULL, 5),
(24, 3, 24, NULL, NULL, 5),
(23, 3, 23, NULL, NULL, 5),
(44, 4, 33, 'None', NULL, NULL),
(45, 5, 23, NULL, NULL, 1),
(46, 5, 24, NULL, NULL, 1),
(47, 5, 25, NULL, NULL, 1),
(48, 5, 26, NULL, NULL, 1),
(49, 5, 27, NULL, NULL, 1),
(50, 5, 28, NULL, NULL, 5),
(51, 5, 29, NULL, NULL, 5),
(52, 5, 30, NULL, NULL, 5),
(53, 5, 31, NULL, NULL, 5),
(54, 5, 32, 'Hire more more', NULL, NULL),
(55, 5, 33, 'None', NULL, NULL),
(56, 6, 23, NULL, NULL, 5),
(57, 6, 24, NULL, NULL, 5),
(58, 6, 25, NULL, NULL, 5),
(59, 6, 26, NULL, NULL, 5),
(60, 6, 27, NULL, NULL, 5),
(61, 6, 28, NULL, NULL, 5),
(62, 6, 29, NULL, NULL, 5),
(63, 6, 30, NULL, NULL, 5),
(64, 6, 31, NULL, NULL, 5),
(65, 6, 32, 'Hire more more', NULL, NULL),
(66, 6, 33, 'None', NULL, NULL),
(67, 7, 23, NULL, NULL, 5),
(68, 7, 24, NULL, NULL, 5),
(69, 7, 25, NULL, NULL, 5),
(70, 7, 26, NULL, NULL, 5),
(71, 7, 27, NULL, NULL, 5),
(72, 7, 28, NULL, NULL, 3),
(73, 7, 29, NULL, NULL, 3),
(74, 7, 30, NULL, NULL, 3),
(75, 7, 31, NULL, NULL, 3),
(76, 7, 32, 'Hire more more', NULL, NULL),
(77, 7, 33, 'None', NULL, NULL),
(78, 8, 23, NULL, NULL, 5),
(79, 8, 24, NULL, NULL, 5),
(80, 8, 25, NULL, NULL, 5),
(81, 8, 26, NULL, NULL, 5),
(82, 8, 27, NULL, NULL, 5),
(83, 8, 28, NULL, NULL, 5),
(84, 8, 29, NULL, NULL, 5),
(85, 8, 30, NULL, NULL, 3),
(86, 8, 31, NULL, NULL, 1),
(87, 8, 32, 'Hire more more', NULL, NULL),
(88, 8, 33, 'None', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `softwareupdates`
--

DROP TABLE IF EXISTS `softwareupdates`;
CREATE TABLE IF NOT EXISTS `softwareupdates` (
  `update_id` int NOT NULL AUTO_INCREMENT,
  `version` varchar(50) NOT NULL,
  `description` text,
  `update_date` date NOT NULL,
  PRIMARY KEY (`update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveyquestions`
--

DROP TABLE IF EXISTS `surveyquestions`;
CREATE TABLE IF NOT EXISTS `surveyquestions` (
  `question_id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`question_id`, `survey_id`, `question_text`, `question_type`, `created_at`) VALUES
(23, 3, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-13 06:58:09'),
(24, 3, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-13 06:58:09'),
(25, 3, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-13 06:58:09'),
(26, 3, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-13 06:58:09'),
(27, 3, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-13 06:58:09'),
(28, 3, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-13 06:58:09'),
(29, 3, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-13 06:58:09'),
(30, 3, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-13 06:58:09'),
(31, 3, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-13 06:58:09'),
(32, 3, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-13 06:58:09'),
(33, 3, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-13 06:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `surveyresponses`
--

DROP TABLE IF EXISTS `surveyresponses`;
CREATE TABLE IF NOT EXISTS `surveyresponses` (
  `response_id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `respondent_email` varchar(255) DEFAULT NULL,
  `mac_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  KEY `survey_id` (`survey_id`),
  KEY `user_id` (`respondent_email`(250))
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyresponses`
--

INSERT INTO `surveyresponses` (`response_id`, `survey_id`, `respondent_email`, `mac_address`, `submitted_at`) VALUES
(4, 3, 'exbjunior@gmail.com', NULL, '2024-10-13 07:17:16'),
(3, 3, 'riccki@gmail.com', NULL, '2024-10-13 07:13:44'),
(5, 3, 'riccki@gmail.com', NULL, '2024-10-13 07:17:46'),
(6, 3, 'riccki@gmail.com', NULL, '2024-10-13 07:18:38'),
(7, 3, 'riccki@gmail.com', NULL, '2024-10-13 07:18:57'),
(8, 3, 'riccki@gmail.com', NULL, '2024-10-13 07:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `survey_id` int NOT NULL AUTO_INCREMENT,
  `office` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `objective` text,
  `is_anonymous` tinyint(1) DEFAULT '0',
  `is_published` tinyint(1) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_complete` int NOT NULL,
  PRIMARY KEY (`survey_id`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`survey_id`, `office`, `title`, `objective`, `is_anonymous`, `is_published`, `start_date`, `end_date`, `created_by`, `created_at`, `updated_at`, `is_complete`) VALUES
(3, 'SAO', 'SAO OFFICE SURVEY', 'to determine the quality service of SAO', 1, 1, '2024-10-14', '2024-11-01', 1, '2024-10-13 06:58:09', '2024-10-13 07:45:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `systemlogs`
--

DROP TABLE IF EXISTS `systemlogs`;
CREATE TABLE IF NOT EXISTS `systemlogs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `log_type` varchar(50) NOT NULL,
  `log_description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_id` int DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'comlab', 'f8894d2c589ac837633c4ade8665980a', 'comblab@gmail.com', NULL, 1, '2024-10-08 04:47:32', '2024-10-08 04:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `usertraining`
--

DROP TABLE IF EXISTS `usertraining`;
CREATE TABLE IF NOT EXISTS `usertraining` (
  `training_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `training_type` varchar(100) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`training_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
