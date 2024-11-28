-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 28, 2024 at 05:38 AM
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
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `office_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `office_name`, `created_at`, `updated_at`) VALUES
(1, 'CICT', '2024-10-16 06:47:14', NULL),
(4, 'AGRI', '2024-10-17 01:08:09', NULL),
(3, 'SAO', '2024-10-16 06:50:34', NULL),
(5, 'EDU', '2024-10-17 01:08:16', NULL),
(6, 'CRIM', '2024-10-21 01:36:14', NULL),
(7, 'BURGER', '2024-10-21 01:36:40', NULL),
(8, 'NURSE', '2024-10-21 01:47:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `feedback_text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
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
  `response_text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `selected_option` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `rating` int DEFAULT NULL,
  PRIMARY KEY (`response_detail_id`),
  KEY `response_id` (`response_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `responsedetails`
--

INSERT INTO `responsedetails` (`response_detail_id`, `response_id`, `question_id`, `response_text`, `selected_option`, `rating`) VALUES
(1, 1, 1, NULL, NULL, 5),
(2, 1, 2, NULL, NULL, 5),
(3, 1, 3, NULL, NULL, 5),
(4, 1, 4, NULL, NULL, 5),
(5, 1, 5, NULL, NULL, 5),
(6, 1, 6, NULL, NULL, 5),
(7, 1, 7, NULL, NULL, 5),
(8, 1, 8, NULL, NULL, 5),
(9, 1, 9, NULL, NULL, 5),
(10, 1, 10, 'manunuba', NULL, NULL),
(11, 1, 11, 'secret', NULL, NULL),
(12, 2, 1, NULL, NULL, 5),
(13, 2, 2, NULL, NULL, 5),
(14, 2, 3, NULL, NULL, 5),
(15, 2, 4, NULL, NULL, 5),
(16, 2, 5, NULL, NULL, 5),
(17, 2, 6, NULL, NULL, 5),
(18, 2, 7, NULL, NULL, 5),
(19, 2, 8, NULL, NULL, 5),
(20, 2, 9, NULL, NULL, 5),
(21, 2, 10, 'opo', NULL, NULL),
(22, 2, 11, 'secret', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `softwareupdates`
--

DROP TABLE IF EXISTS `softwareupdates`;
CREATE TABLE IF NOT EXISTS `softwareupdates` (
  `update_id` int NOT NULL AUTO_INCREMENT,
  `version` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
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
  `question_text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `question_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`question_id`, `survey_id`, `question_text`, `question_type`, `created_at`) VALUES
(1, 1, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-24 04:06:02'),
(2, 1, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-24 04:06:02'),
(3, 1, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-24 04:06:02'),
(4, 1, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-24 04:06:02'),
(5, 1, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-24 04:06:02'),
(6, 1, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-24 04:06:02'),
(7, 1, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-24 04:06:02'),
(8, 1, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-24 04:06:02'),
(9, 1, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-24 04:06:02'),
(10, 1, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-24 04:06:02'),
(11, 1, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-24 04:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `surveyresponses`
--

DROP TABLE IF EXISTS `surveyresponses`;
CREATE TABLE IF NOT EXISTS `surveyresponses` (
  `response_id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyresponses`
--

INSERT INTO `surveyresponses` (`response_id`, `survey_id`, `student_id`, `submitted_at`) VALUES
(1, 1, '10:ff:e0:41:2a:97', '2024-10-30 03:25:00'),
(2, 1, '2021', '2024-10-30 03:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `survey_id` int NOT NULL AUTO_INCREMENT,
  `office` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `objective` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`survey_id`, `office`, `title`, `objective`, `is_anonymous`, `is_published`, `start_date`, `end_date`, `created_by`, `created_at`, `updated_at`, `is_complete`) VALUES
(1, 'CICT', 'Test Survey', 'Test', 1, 1, '2024-10-01', '2024-10-31', 1, '2024-10-24 04:06:02', '2024-10-24 08:06:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `systemlogs`
--

DROP TABLE IF EXISTS `systemlogs`;
CREATE TABLE IF NOT EXISTS `systemlogs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `log_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
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
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
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
  `training_type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`training_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
