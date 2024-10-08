-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 08, 2024 at 04:51 AM
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`question_id`, `survey_id`, `question_text`, `question_type`, `created_at`) VALUES
(1, 1, '1. For How long did you stay in SEAIT?', 'input', '2024-10-07 06:03:42'),
(2, 1, '2. what is your overall satisfaction with your quality of education?', 'radio', '2024-10-07 06:08:35'),
(3, 1, '3. sample question input', 'input', '2024-10-07 06:20:09'),
(4, 1, '4. sample radio', 'radio', '2024-10-07 06:49:56'),
(5, 1, '5. Goods Snoppy', 'radio', '2024-10-08 02:13:43');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `survey_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `objective` text,
  `is_anonymous` tinyint(1) DEFAULT '0',
  `is_published` tinyint(1) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`survey_id`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
