-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 10, 2024 at 09:14 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `responsedetails`
--

INSERT INTO `responsedetails` (`response_detail_id`, `response_id`, `question_id`, `response_text`, `selected_option`, `rating`) VALUES
(1, 2, 1, 'ENRIQUE SINGCO MISLANG', NULL, NULL),
(2, 2, 2, '12', NULL, NULL),
(3, 2, 3, NULL, '', 5),
(4, 2, 4, NULL, NULL, 5),
(5, 2, 5, 'None', NULL, NULL),
(6, 2, 6, 'MARAMI', NULL, NULL),
(7, 3, 1, 'ENRIQUE SINGCO MISLANG', NULL, NULL),
(8, 3, 2, '12', NULL, NULL),
(9, 3, 3, NULL, '', 5),
(10, 3, 4, NULL, NULL, 5),
(11, 3, 5, 'None', NULL, NULL),
(12, 3, 6, 'Super', NULL, NULL),
(13, 4, 1, 'ENRIQUE SINGCO MISLANG', NULL, NULL),
(14, 4, 2, '12', NULL, NULL),
(15, 4, 3, NULL, NULL, 5),
(16, 4, 4, NULL, NULL, 5),
(17, 4, 5, 'None', NULL, NULL),
(18, 4, 6, 'Super', NULL, NULL),
(19, 5, 1, 'ENRIQUE SINGCO MISLANG', NULL, NULL),
(20, 5, 2, '12', NULL, NULL),
(21, 5, 3, NULL, NULL, 5),
(22, 5, 4, NULL, NULL, 5),
(23, 5, 5, 'None', NULL, NULL),
(24, 5, 6, 'Super', NULL, NULL),
(25, 6, 1, 'ENRIQUE SINGCO MISLANG', NULL, NULL),
(26, 6, 2, '12', NULL, NULL),
(27, 6, 3, NULL, NULL, 5),
(28, 6, 4, NULL, NULL, 5),
(29, 6, 5, 'None', NULL, NULL),
(30, 6, 6, 'Super', NULL, NULL),
(31, 6, 7, 'asdasd', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`question_id`, `survey_id`, `question_text`, `question_type`, `created_at`) VALUES
(1, 1, '1. What is your name', 'input', '2024-10-10 04:20:34'),
(2, 1, '2. How old are you?', 'input', '2024-10-10 04:20:34'),
(3, 1, '3. rate your experience here', 'rating', '2024-10-10 04:20:34'),
(4, 1, '4. rate you teacher', 'rating', '2024-10-10 04:20:34'),
(5, 1, '5. what do you recommend', 'input', '2024-10-10 04:20:34'),
(6, 1, '6. what are your expectations', 'input', '2024-10-10 04:20:34'),
(7, 2, '1. asdasd', 'input', '2024-10-10 05:55:47'),
(8, 3, '1. asdasdasd', 'input', '2024-10-10 05:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `surveyresponses`
--

DROP TABLE IF EXISTS `surveyresponses`;
CREATE TABLE IF NOT EXISTS `surveyresponses` (
  `response_id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  KEY `survey_id` (`survey_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyresponses`
--

INSERT INTO `surveyresponses` (`response_id`, `survey_id`, `user_id`, `submitted_at`) VALUES
(1, 1, NULL, '2024-10-10 04:21:29'),
(2, 1, NULL, '2024-10-10 04:33:32'),
(3, 1, NULL, '2024-10-10 04:48:36'),
(4, 1, NULL, '2024-10-10 04:49:29'),
(5, 1, NULL, '2024-10-10 04:49:31'),
(6, 2, NULL, '2024-10-10 05:57:00');

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
(1, 'CICT', 'JORDIES SURVEY', 'to enhance security', 1, 1, '2024-10-01', '2024-10-31', 1, '2024-10-10 04:20:34', '2024-10-10 08:48:01', 0),
(2, 'CICT', 'Monsion Survey', 'WHAT IS LOVE?', 0, 0, '2024-10-02', '2024-10-31', 1, '2024-10-10 05:55:47', '2024-10-10 08:49:20', 0),
(3, 'EDUC', 'rose', 'rosie2', 1, 1, '2024-10-01', '2024-10-09', 1, '2024-10-10 05:56:52', '2024-10-10 06:02:28', 0);

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
