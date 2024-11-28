-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2024 at 01:40 PM
-- Server version: 10.5.27-MariaDB-cll-lve
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seaitedu_survey_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `office_name`, `created_at`, `updated_at`) VALUES
(1, 'CICT', '2024-10-16 22:13:27', NULL),
(2, 'SAO', '2024-10-17 01:10:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback_text` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responsedetails`
--

CREATE TABLE `responsedetails` (
  `response_detail_id` int(11) NOT NULL,
  `response_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `response_text` text DEFAULT NULL,
  `selected_option` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `softwareupdates`
--

CREATE TABLE `softwareupdates` (
  `update_id` int(11) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveyquestions`
--

CREATE TABLE `surveyquestions` (
  `question_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`question_id`, `survey_id`, `question_text`, `question_type`, `created_at`) VALUES
(12, 2, '1. How satisfied are you with the quality of services provided by this office/department?', 'rating', '2024-11-27 14:38:29'),
(13, 2, '2. How effectively does the office/department handle your requests or concerns?', 'rating', '2024-11-27 14:38:29'),
(14, 2, '3. How would you rate the professionalism and courtesy of the staff in this office/department?', 'rating', '2024-11-27 14:38:29'),
(15, 2, '4. How easy is it to access the services or assistance you need from this office/department?', 'rating', '2024-11-27 14:38:29'),
(16, 2, '5. How satisfied are you with the communication between you and the staff in this office/department?', 'rating', '2024-11-27 14:38:29'),
(17, 2, '6. How would you rate the timeliness of the responses you receive from this office/department?', 'rating', '2024-11-27 14:38:29'),
(18, 2, '7. How well does this office/department provide the necessary resources or information you require?', 'rating', '2024-11-27 14:38:29'),
(19, 2, '8. How satisfied are you with the clarity and transparency of the processes in this office/department?', 'rating', '2024-11-27 14:38:29'),
(20, 2, '9. How well does this office/department support your needs or objectives?', 'rating', '2024-11-27 14:38:29'),
(21, 2, '10. What suggestions do you have for improving the department\'s programs and services?', 'input', '2024-11-27 14:38:29'),
(22, 2, '11. Do you have complaints or concerns about this office/department? Enter None if none.', 'input', '2024-11-27 14:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `surveyresponses`
--

CREATE TABLE `surveyresponses` (
  `response_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `survey_id` int(11) NOT NULL,
  `office` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `objective` text DEFAULT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_complete` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`survey_id`, `office`, `title`, `objective`, `is_anonymous`, `is_published`, `start_date`, `end_date`, `created_by`, `created_at`, `updated_at`, `is_complete`) VALUES
(2, 'CICT', 'Laboratory ', 'Sample', 1, 1, '2024-11-27', '2024-11-27', NULL, '2024-11-27 14:38:29', '2024-11-27 14:38:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `systemlogs`
--

CREATE TABLE `systemlogs` (
  `log_id` int(11) NOT NULL,
  `log_type` varchar(50) NOT NULL,
  `log_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'comlab', 'f8894d2c589ac837633c4ade8665980a', 'comblab@gmail.com', NULL, 1, '2024-10-08 04:47:32', '2024-10-08 04:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `usertraining`
--

CREATE TABLE `usertraining` (
  `training_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `training_type` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `responsedetails`
--
ALTER TABLE `responsedetails`
  ADD PRIMARY KEY (`response_detail_id`),
  ADD KEY `response_id` (`response_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `softwareupdates`
--
ALTER TABLE `softwareupdates`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `surveyquestions`
--
ALTER TABLE `surveyquestions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `surveyresponses`
--
ALTER TABLE `surveyresponses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`survey_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `systemlogs`
--
ALTER TABLE `systemlogs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `usertraining`
--
ALTER TABLE `usertraining`
  ADD PRIMARY KEY (`training_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responsedetails`
--
ALTER TABLE `responsedetails`
  MODIFY `response_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `softwareupdates`
--
ALTER TABLE `softwareupdates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surveyquestions`
--
ALTER TABLE `surveyquestions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `surveyresponses`
--
ALTER TABLE `surveyresponses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `survey_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `systemlogs`
--
ALTER TABLE `systemlogs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usertraining`
--
ALTER TABLE `usertraining`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
