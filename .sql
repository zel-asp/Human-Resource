-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 28, 2026 at 08:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `department` enum('Management','Restaurant','Hotel') NOT NULL DEFAULT 'Management',
  `experience` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `status` enum('New','Review','Interview','Offer','Rejected','Hired') NOT NULL DEFAULT 'New',
  `hired_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `cover_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `full_name`, `email`, `phone`, `position`, `department`, `experience`, `education`, `skills`, `status`, `hired_date`, `start_date`, `resume_path`, `cover_note`, `created_at`) VALUES
(38, 'Uzumaki Dela CRUZ', 'Bdsd0s5ls.Do1s@gmail.com', '09123456789', 'Restaurant Server', 'Management', 'xcv', 'dsfs', 'nothing', 'Review', NULL, NULL, '', '', '2026-02-28 05:27:19'),
(39, 'Uzumaki Dela CRUZ', 'B0s5ls.Do1s@gmail.com', '09565819961', 'Restaurant Server', 'Management', 's', 'xcv', 'd', 'Hired', '2026-02-28', '2026-03-06', '', '', '2026-02-28 07:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `benefit_providers`
--

CREATE TABLE `benefit_providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_name` varchar(100) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `benefit_providers`
--

INSERT INTO `benefit_providers` (`id`, `provider_name`, `contact_info`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Maxicare', 'info@maxicare.com.ph', 'HMO provider', '2026-02-26 13:18:09', '2026-02-26 13:18:09'),
(2, 'Medicard', 'support@medicard.com.ph', 'HMO provider', '2026-02-26 13:18:09', '2026-02-26 13:18:09'),
(3, 'Intellicare', 'contact@intellicare.com.ph', 'HMO provider', '2026-02-26 13:18:09', '2026-02-26 13:18:09'),
(4, 'AXA', 'service@axa.com.ph', 'Insurance provider', '2026-02-26 13:18:09', '2026-02-26 13:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `applicant_id` int(10) UNSIGNED DEFAULT NULL,
  `employee_number` varchar(10) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `hired_date` date DEFAULT NULL,
  `onboarding_status` enum('Onboarding','In Progress','Onboarded') DEFAULT 'Onboarding',
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `evaluation_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `applicant_id`, `employee_number`, `full_name`, `email`, `phone`, `position`, `department`, `start_date`, `hired_date`, `onboarding_status`, `status`, `created_at`, `updated_at`, `evaluation_status`) VALUES
(35, 39, 'EMP-039', 'Uzumaki Dela CRUZ', 'B0s5ls.Do1s@gmail.com', '09565819961', 'Restaurant Server', 'Management', '2026-03-06', '2026-02-28', 'Onboarding', 'Probationary', '2026-02-28 15:13:26', '2026-02-28 15:13:26', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `employee_accounts`
--

CREATE TABLE `employee_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `account_status` enum('Active','Inactive','Suspended') NOT NULL DEFAULT 'Active',
  `generated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `session_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_accounts`
--

INSERT INTO `employee_accounts` (`id`, `applicant_id`, `employee_id`, `username`, `password`, `email`, `account_status`, `generated_date`, `last_login`, `department`, `session_token`) VALUES
(31, 38, 'EMP-038', 'Bdsd0s5ls.Do1s', '$2y$10$MB4gJ05tUYEirikUx6gLaubsttL2eaS550gUZmWSOXWaLh1ALW08C', 'Bdsd0s5ls.Do1s@gmail.com', 'Active', '2026-02-28 05:27:54', '2026-02-28 07:30:16', 'Management', '2c0d56bab3978b5cc6ade35c8410bb64001777a46301dea4e956047ad592a3d1');

-- --------------------------------------------------------

--
-- Table structure for table `employee_benefits`
--

CREATE TABLE `employee_benefits` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `benefit_type` varchar(100) NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `effective_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `coverage_amount` decimal(15,2) DEFAULT NULL,
  `monthly_premium` decimal(10,2) DEFAULT NULL,
  `dependents` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `position` varchar(150) NOT NULL,
  `department` varchar(100) NOT NULL,
  `location` varchar(150) NOT NULL,
  `shift` varchar(50) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `position`, `department`, `location`, `shift`, `salary`, `created_at`, `updated_at`) VALUES
(48, 'Restaurant Server', 'Management', 'Main Dining Room', 'evening', '$15-20/hr + tips', '2026-02-26 04:35:51', '2026-02-26 04:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `performance_criteria_scores`
--

CREATE TABLE `performance_criteria_scores` (
  `id` int(10) UNSIGNED NOT NULL,
  `evaluation_id` int(10) UNSIGNED NOT NULL,
  `criteria_number` tinyint(1) NOT NULL,
  `criteria_label` varchar(100) NOT NULL,
  `criteria_description` varchar(255) NOT NULL,
  `score` tinyint(1) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance_evaluations`
--

CREATE TABLE `performance_evaluations` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `review_period_start` date NOT NULL,
  `review_period_end` date NOT NULL,
  `review_type` varchar(50) NOT NULL DEFAULT '90-Day Probationary Review',
  `overall_score` decimal(3,1) NOT NULL,
  `interpretation` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance_improvement_plans`
--

CREATE TABLE `performance_improvement_plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `evaluation_id` int(10) UNSIGNED NOT NULL,
  `improvement_areas` text NOT NULL,
  `goal1` varchar(255) DEFAULT NULL,
  `goal2` varchar(255) DEFAULT NULL,
  `goal3` varchar(255) DEFAULT NULL,
  `pip_start_date` date NOT NULL,
  `pip_end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regular_employment`
--

CREATE TABLE `regular_employment` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `evaluation_id` int(10) UNSIGNED NOT NULL,
  `effective_date` date NOT NULL,
  `employment_type` enum('Regular Full-Time','Regular Part-Time') NOT NULL,
  `manager_comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `task_type` varchar(100) NOT NULL,
  `task_description` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `assigned_staff` varchar(100) NOT NULL,
  `status` enum('Not Started','Ongoing','Completed') NOT NULL DEFAULT 'Not Started',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `benefit_providers`
--
ALTER TABLE `benefit_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_name` (`provider_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_number` (`employee_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `applicant_id` (`applicant_id`);

--
-- Indexes for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_applicant_id` (`applicant_id`),
  ADD KEY `idx_employee_id` (`employee_id`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `employee_benefits`
--
ALTER TABLE `employee_benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_job_posting` (`position`,`department`,`location`,`shift`,`salary`);

--
-- Indexes for table `performance_criteria_scores`
--
ALTER TABLE `performance_criteria_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluation_id` (`evaluation_id`);

--
-- Indexes for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `performance_improvement_plans`
--
ALTER TABLE `performance_improvement_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `evaluation_id` (`evaluation_id`);

--
-- Indexes for table `regular_employment`
--
ALTER TABLE `regular_employment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `evaluation_id` (`evaluation_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_ibfk_1` (`assigned_to`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `benefit_providers`
--
ALTER TABLE `benefit_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `employee_benefits`
--
ALTER TABLE `employee_benefits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `performance_criteria_scores`
--
ALTER TABLE `performance_criteria_scores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `performance_improvement_plans`
--
ALTER TABLE `performance_improvement_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `regular_employment`
--
ALTER TABLE `regular_employment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD CONSTRAINT `employee_accounts_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_benefits`
--
ALTER TABLE `employee_benefits`
  ADD CONSTRAINT `employee_benefits_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_benefits_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `benefit_providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_criteria_scores`
--
ALTER TABLE `performance_criteria_scores`
  ADD CONSTRAINT `criteria_scores_ibfk_1` FOREIGN KEY (`evaluation_id`) REFERENCES `performance_evaluations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  ADD CONSTRAINT `performance_evaluations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_improvement_plans`
--
ALTER TABLE `performance_improvement_plans`
  ADD CONSTRAINT `pip_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pip_ibfk_2` FOREIGN KEY (`evaluation_id`) REFERENCES `performance_evaluations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `regular_employment`
--
ALTER TABLE `regular_employment`
  ADD CONSTRAINT `regular_employment_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `regular_employment_ibfk_2` FOREIGN KEY (`evaluation_id`) REFERENCES `performance_evaluations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
