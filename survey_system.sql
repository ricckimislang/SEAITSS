-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2024 at 07:08 AM
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`question_id`, `survey_id`, `question_text`, `question_type`, `created_at`) VALUES
(1, 1, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-18 06:03:30'),
(2, 1, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-18 06:03:30'),
(3, 1, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-18 06:03:30'),
(4, 1, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-18 06:03:30'),
(5, 1, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-18 06:03:30'),
(6, 1, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-18 06:03:30'),
(7, 1, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-18 06:03:30'),
(8, 1, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-18 06:03:30'),
(9, 1, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-18 06:03:30'),
(10, 1, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-18 06:03:30'),
(11, 1, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-18 06:03:30'),
(12, 2, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-18 06:04:04'),
(13, 2, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-18 06:04:04'),
(14, 2, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-18 06:04:04'),
(15, 2, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-18 06:04:04'),
(16, 2, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-18 06:04:04'),
(17, 2, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-18 06:04:04'),
(18, 2, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-18 06:04:04'),
(19, 2, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-18 06:04:04'),
(20, 2, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-18 06:04:04'),
(21, 2, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-18 06:04:04'),
(22, 2, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-18 06:04:04'),
(23, 1, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-18 06:53:37'),
(24, 1, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-18 06:53:37'),
(25, 1, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-18 06:53:37'),
(26, 1, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-18 06:53:37'),
(27, 1, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-18 06:53:37'),
(28, 1, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-18 06:53:37'),
(29, 1, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-18 06:53:37'),
(30, 1, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-18 06:53:37'),
(31, 1, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-18 06:53:37'),
(32, 1, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-18 06:53:37'),
(33, 1, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-18 06:53:37'),
(34, 2, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-18 06:54:43'),
(35, 2, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-18 06:54:43'),
(36, 2, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-18 06:54:43'),
(37, 2, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-18 06:54:43'),
(38, 2, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-18 06:54:43'),
(39, 2, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-18 06:54:43'),
(40, 2, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-18 06:54:43'),
(41, 2, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-18 06:54:43'),
(42, 2, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-18 06:54:43'),
(43, 2, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-18 06:54:43'),
(44, 2, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-18 06:54:43'),
(45, 3, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-21 02:48:44'),
(46, 3, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-21 02:48:44'),
(47, 3, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-21 02:48:44'),
(48, 3, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-21 02:48:44'),
(49, 3, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-21 02:48:44'),
(50, 3, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-21 02:48:44'),
(51, 3, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-21 02:48:44'),
(52, 3, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-21 02:48:44'),
(53, 3, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-21 02:48:44'),
(54, 3, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-21 02:48:44'),
(55, 3, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-21 02:48:44'),
(56, 4, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-21 02:50:22'),
(57, 4, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-21 02:50:22'),
(58, 4, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-21 02:50:22'),
(59, 4, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-21 02:50:22'),
(60, 4, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-21 02:50:22'),
(61, 4, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-21 02:50:22'),
(62, 4, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-21 02:50:22'),
(63, 4, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-21 02:50:22'),
(64, 4, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-21 02:50:22'),
(65, 4, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-21 02:50:22'),
(66, 4, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-21 02:50:22'),
(67, 5, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-21 02:50:46'),
(68, 5, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-21 02:50:46'),
(69, 5, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-21 02:50:46'),
(70, 5, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-21 02:50:46'),
(71, 5, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-21 02:50:46'),
(72, 5, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-21 02:50:46'),
(73, 5, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-21 02:50:46'),
(74, 5, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-21 02:50:46'),
(75, 5, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-21 02:50:46'),
(76, 5, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-21 02:50:46'),
(77, 5, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-21 02:50:46'),
(97, 7, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-10-21 02:57:50'),
(96, 7, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-10-21 02:57:50'),
(95, 7, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-10-21 02:57:50'),
(94, 7, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-10-21 02:57:50'),
(93, 7, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-10-21 02:57:50'),
(92, 7, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-10-21 02:57:50'),
(91, 7, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-10-21 02:57:50'),
(90, 7, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-10-21 02:57:50'),
(89, 7, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-10-21 02:57:50'),
(98, 7, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-10-21 02:57:50'),
(99, 7, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-10-21 02:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `surveyresponses`
--

DROP TABLE IF EXISTS `surveyresponses`;
CREATE TABLE IF NOT EXISTS `surveyresponses` (
  `response_id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `student_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  KEY `survey_id` (`survey_id`),
  KEY `user_id` (`student_id`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`survey_id`, `office`, `title`, `objective`, `is_anonymous`, `is_published`, `start_date`, `end_date`, `created_by`, `created_at`, `updated_at`, `is_complete`) VALUES
(1, 'CICT', 'Enhancing the Academic and Campus Experience in CICT', 'This survey aims to gather feedback from students, faculty, and staff of the College of Information and Communications Technology (CICT) to improve the academic programs, campus facilities, and student services. Your insights will help us understand areas that need enhancement and ensure a more supportive and enriching environment for everyone in the CICT community. Thank you for taking part in shaping the future of our department!', 1, 1, '2024-10-01', '2024-10-31', NULL, '2024-10-18 06:53:37', '2024-10-21 04:57:54', 0),
(2, 'SAO', '123', '123', 1, 1, '2024-10-01', '2024-10-30', NULL, '2024-10-18 06:54:43', '2024-10-21 00:44:58', 0),
(3, 'EDU', 'EDU SURVEY?', 'YES PO SURVEY PO TO', 1, 1, '2024-10-01', '2024-10-31', 1, '2024-10-21 02:48:44', '2024-10-21 02:48:44', 0),
(4, 'CRIM', 'CRIMINAL LAW', 'TESTING LAW LAW', 1, 1, '2024-10-21', '2024-10-31', 1, '2024-10-21 02:50:22', '2024-10-21 02:50:22', 0),
(5, 'BURGER', '123123', '123123', 1, 1, '2024-10-21', '2024-11-09', 1, '2024-10-21 02:50:46', '2024-10-21 02:50:46', 0),
(7, 'NURSE', '123', '123', 1, 1, '2024-10-21', '2024-11-08', 1, '2024-10-21 02:57:50', '2024-10-21 02:57:50', 0);

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
