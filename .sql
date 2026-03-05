-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 05, 2026 at 11:09 AM
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
-- Table structure for table `admin_notes`
--

CREATE TABLE `admin_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `note_title` varchar(150) DEFAULT NULL,
  `note_content` text NOT NULL,
  `note_type` enum('general','disciplinary','performance','confidential') DEFAULT 'general',
  `status` enum('active','archived') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `status` enum('New','Review','Interview','Offer','Rejected','Hired') NOT NULL DEFAULT 'New',
  `hired_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `cover_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `full_name`, `department`, `email`, `phone`, `position`, `experience`, `education`, `skills`, `status`, `hired_date`, `start_date`, `resume_path`, `cover_note`, `created_at`, `age`, `gender`) VALUES
(56, 'Uzumaki Dela CRUZ', 'Finance', 'B0s5ls.Do1s@gmail.com', '09123456789', 'Restaurant Server', 's', 'xcv', 'd', 'Hired', '2026-03-04', '2026-03-05', '', '', '2026-03-04 07:37:29', 34, 'male'),
(57, 'Uzumaki Dela CRUZ', 'Finance', 'B0s5ls.sDo1s@gmail.com', '09123456789', 'Restaurant Serversf', 's', 'xcv', 'a', 'Hired', '2026-03-04', '2026-03-04', '', '', '2026-03-04 07:37:41', 34, 'female');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `shift_id` int(10) UNSIGNED DEFAULT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime DEFAULT NULL,
  `pause_start` datetime DEFAULT NULL,
  `pause_total` int(11) DEFAULT 0,
  `late_minutes` int(11) DEFAULT 0,
  `late_status` enum('on_time','grace_period','late') DEFAULT 'on_time',
  `regular_hours` decimal(5,2) DEFAULT 0.00,
  `overtime_hours` decimal(5,2) DEFAULT 0.00,
  `early_departure_minutes` int(11) DEFAULT 0,
  `status` enum('clocked_in','paused','clocked_out') DEFAULT 'clocked_out',
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `shift_id`, `clock_in`, `clock_out`, `pause_start`, `pause_total`, `late_minutes`, `late_status`, `regular_hours`, `overtime_hours`, `early_departure_minutes`, `status`, `date`, `created_at`, `updated_at`) VALUES
(118, 57, 2, '2026-03-05 09:06:20', '2026-03-05 09:35:14', '2026-03-05 09:35:12', 0, 0, 'on_time', 0.48, 0.00, 744, 'clocked_out', '2026-03-05', '2026-03-05 01:06:20', '2026-03-05 01:35:14'),
(119, 57, 2, '2026-03-05 09:35:28', '2026-03-05 14:13:42', '2026-03-05 14:13:41', 269, 0, 'on_time', 0.15, 0.00, 466, 'clocked_out', '2026-03-05', '2026-03-05 01:35:28', '2026-03-05 06:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_summary`
--

CREATE TABLE `attendance_summary` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `total_regular_hours` decimal(7,2) DEFAULT 0.00,
  `total_overtime_hours` decimal(7,2) DEFAULT 0.00,
  `total_late_minutes` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_summary`
--

INSERT INTO `attendance_summary` (`id`, `employee_id`, `period_start`, `period_end`, `total_regular_hours`, `total_overtime_hours`, `total_late_minutes`, `created_at`, `updated_at`) VALUES
(32, 57, '2026-02-21', '2026-03-05', 0.63, 0.00, 0, '2026-03-05 01:35:14', '2026-03-05 06:13:42');

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
-- Table structure for table `compensation_reviews`
--

CREATE TABLE `compensation_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `current_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `review_type` enum('annual','promotion','merit','market') NOT NULL,
  `review_date` date NOT NULL,
  `effective_date` date NOT NULL,
  `proposed_salary` decimal(10,2) NOT NULL,
  `increase_amount` decimal(10,2) GENERATED ALWAYS AS (`proposed_salary` - `current_salary`) STORED,
  `increase_percentage` decimal(6,2) GENERATED ALWAYS AS (round((`proposed_salary` - `current_salary`) / `current_salary` * 100,2)) STORED,
  `status` enum('draft','pending_finance','approved','rejected') DEFAULT 'draft',
  `finance_approved_at` datetime DEFAULT NULL,
  `finance_approved_by` int(11) DEFAULT NULL,
  `finance_notes` text DEFAULT NULL,
  `budget_code` varchar(50) DEFAULT NULL,
  `annual_impact` decimal(10,2) GENERATED ALWAYS AS ((`proposed_salary` - `current_salary`) * 12) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competencies`
--

CREATE TABLE `competencies` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `required_level` tinyint(4) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competencies`
--

INSERT INTO `competencies` (`id`, `name`, `description`, `created_at`, `required_level`) VALUES
(1, 'Customer Service', NULL, '2026-03-02 06:32:29', 3),
(2, 'Food Safety', NULL, '2026-03-02 06:32:29', 4),
(3, 'POS Systems', NULL, '2026-03-02 06:32:29', 2),
(4, 'Team Leadership', NULL, '2026-03-02 06:32:29', 3);

-- --------------------------------------------------------

--
-- Table structure for table `competency_assessments`
--

CREATE TABLE `competency_assessments` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  `assessor_id` int(11) NOT NULL,
  `proficiency_level` tinyint(4) NOT NULL CHECK (`proficiency_level` between 1 and 5),
  `assessment_notes` text DEFAULT NULL,
  `assessment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Passed','Needs Improvement') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `hourly_rate` decimal(10,2) DEFAULT 0.00,
  `department` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `hired_date` date DEFAULT NULL,
  `onboarding_status` enum('Onboarding','In Progress','Onboarded') DEFAULT 'Onboarding',
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `shift_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `evaluation_status` varchar(50) DEFAULT 'Pending',
  `role` enum('employee','mentor','evaluator','admin') DEFAULT 'employee',
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `benefit_status` varchar(50) DEFAULT 'Not Enrolled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `applicant_id`, `employee_number`, `full_name`, `email`, `phone`, `position`, `hourly_rate`, `department`, `start_date`, `hired_date`, `onboarding_status`, `status`, `shift_id`, `created_at`, `updated_at`, `evaluation_status`, `role`, `age`, `gender`, `benefit_status`) VALUES
(57, 56, 'EMP-056', 'Uzumaki Dela CRUZ', 'B0s5ls.Do1s@gmail.com', '09123456789', 'Restaurant Server', 200.00, 'Finance', '2026-03-05', '2026-03-04', 'In Progress', 'Probationary', 2, '2026-03-04 15:37:54', '2026-03-05 09:34:46', 'Evaluated', 'evaluator', 34, 'male', 'Not Enrolled'),
(60, 57, 'EMP-057', 'Linda', 'B0s5ls.sDo1s@gmail.com', '09123456789', 'Restaurant Serversf', 300.00, 'Finance', '2026-03-04', '2026-03-04', 'Onboarding', 'Probationary', 1, '2026-03-04 23:23:34', '2026-03-05 09:34:54', 'Evaluated', 'employee', 34, 'female', 'Not Enrolled');

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
(37, 56, 'EMP-056', 'B0s5ls.Do1s', '$2y$10$/XwXWVPHji8aBSHuOAKLPeO2eEVsGh7to9gFrd59gyOyX5y3yhl8.', 'B0s5ls.Do1s@gmail.com', 'Active', '2026-03-04 07:38:03', '2026-03-05 06:13:15', 'Finance', '91f5218419c6af715aabcc2a28f1b5d1ab4dc7197e75cdb5362219dda9849019'),
(39, 57, 'EMP-057', 'B0s5ls.sDo1s', '$2y$10$Jg24Mf9HAvslPhD5lkA4Ruym9BmFiFB7n3bkwMbE8xwJsT.L.hrc6', 'B0s5ls.sDo1s@gmail.com', 'Active', '2026-03-04 16:12:23', NULL, 'Finance', NULL);

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
-- Table structure for table `expense_claims`
--

CREATE TABLE `expense_claims` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `category` varchar(100) NOT NULL,
  `merchant` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `project` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `receipt_path` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_claims`
--

INSERT INTO `expense_claims` (`id`, `employee_id`, `expense_date`, `category`, `merchant`, `amount`, `project`, `description`, `receipt_path`, `status`, `approved_by`, `approved_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(4, 57, '2026-03-14', 'Equipment', 'd', 1234.00, NULL, 'qwqw', '', 'Pending', NULL, NULL, NULL, '2026-03-04 14:21:08', '2026-03-04 14:21:08'),
(5, 57, '2026-03-05', 'Equipment', 'd', 1234.00, NULL, 'aasa', 'https://plxoonwsguadkqisevxh.supabase.co/storage/v1/object/public/claims/claim_1772634115071.jpg', 'Pending', NULL, NULL, NULL, '2026-03-04 14:21:56', '2026-03-04 14:21:56');

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
(57, 'Restaurant Serversfafasfasf', 'Management', 'Main Dining Room', 'evening', '$15-20/hr + tips', '2026-03-03 02:42:01', '2026-03-03 02:42:01'),
(58, 'Restaurant Serversf', 'Finance', 'Main Dining Room', 'evening', '₱15-20/hr + tips', '2026-03-03 08:49:13', '2026-03-03 08:49:13'),
(59, 'Restaurant Server', 'Finance', 'Main Dining Rooms', 'morning', '₱15-20/hr + tips', '2026-03-03 09:15:30', '2026-03-03 09:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type` enum('Annual Leave','Sick Leave','Personal Day','Remote Work') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type`, `start_date`, `end_date`, `total_days`, `reason`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(15, 57, 'Annual Leave', '2026-03-05', '2026-03-06', 2, '', 'Approved', NULL, '2026-03-05 10:34:39', '2026-03-05 01:33:22', '2026-03-05 02:34:39');

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

--
-- Dumping data for table `performance_criteria_scores`
--

INSERT INTO `performance_criteria_scores` (`id`, `evaluation_id`, `criteria_number`, `criteria_label`, `criteria_description`, `score`, `comments`) VALUES
(206, 44, 1, 'Job Knowledge', 'Understanding of role, procedures, and standards', 3, ''),
(207, 44, 2, 'Quality of Work', 'Accuracy, thoroughness, and attention to detail', 3, ''),
(208, 44, 3, 'Customer Service', 'Interaction with customers and handling complaints', 5, ''),
(209, 44, 4, 'Teamwork & Collaboration', 'Working with colleagues and supporting team goals', 4, ''),
(210, 44, 5, 'Attendance & Punctuality', 'Reliability and adherence to schedule', 5, ''),
(211, 45, 1, 'Job Knowledge', 'Understanding of role, procedures, and standards', 3, ''),
(212, 45, 2, 'Quality of Work', 'Accuracy, thoroughness, and attention to detail', 3, ''),
(213, 45, 3, 'Customer Service', 'Interaction with customers and handling complaints', 3, ''),
(214, 45, 4, 'Teamwork & Collaboration', 'Working with colleagues and supporting team goals', 3, ''),
(215, 45, 5, 'Attendance & Punctuality', 'Reliability and adherence to schedule', 3, '');

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

--
-- Dumping data for table `performance_evaluations`
--

INSERT INTO `performance_evaluations` (`id`, `employee_id`, `review_period_start`, `review_period_end`, `review_type`, `overall_score`, `interpretation`, `created_at`, `updated_at`) VALUES
(44, 57, '2026-03-05', '2026-06-02', '90-Day Probationary Review', 4.0, 'Exceeds Expectations', '2026-03-05 01:34:46', '2026-03-05 01:34:46'),
(45, 60, '2026-03-04', '2026-06-02', '90-Day Probationary Review', 3.0, 'Meets Expectations', '2026-03-05 01:34:54', '2026-03-05 01:34:54');

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
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` int(10) UNSIGNED NOT NULL,
  `shift_name` varchar(50) NOT NULL,
  `shift_code` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `grace_period_minutes` int(11) DEFAULT 15,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `shift_name`, `shift_code`, `start_time`, `end_time`, `grace_period_minutes`, `created_at`, `updated_at`) VALUES
(1, 'Morning Shift', 'MORNING', '06:00:00', '14:00:00', 15, '2026-02-28 10:56:01', '2026-02-28 10:56:01'),
(2, 'Afternoon Shift', 'AFTERNOON', '14:00:00', '22:00:00', 15, '2026-02-28 10:56:01', '2026-02-28 10:56:01'),
(3, 'Graveyard Shift', 'GRAVEYARD', '22:00:00', '06:00:00', 15, '2026-02-28 10:56:01', '2026-02-28 10:56:01');

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
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `assigned_to`, `task_type`, `task_description`, `due_date`, `priority`, `assigned_staff`, `status`, `created_at`, `updated_at`) VALUES
(40, 57, 'paperwork', 's', '2026-03-06', 'urgent', 'Lisa Martinez', 'Not Started', '2026-03-05 06:14:51', '2026-03-05 06:14:51');

-- --------------------------------------------------------

--
-- Table structure for table `training_providers`
--

CREATE TABLE `training_providers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('internal','external','certification') NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_providers`
--

INSERT INTO `training_providers` (`id`, `name`, `type`, `contact_info`, `created_at`, `updated_at`) VALUES
(1, 'SafeFood Certification Inc.', 'external', NULL, '2026-03-02 08:11:42', '2026-03-02 08:11:42'),
(2, 'Hospitality Training Institute', 'external', NULL, '2026-03-02 08:11:42', '2026-03-02 08:11:42'),
(3, 'Leadership Academy International', 'external', NULL, '2026-03-02 08:11:42', '2026-03-02 08:11:42'),
(4, 'TechSkills Learning Center', 'external', NULL, '2026-03-02 08:11:42', '2026-03-02 08:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `training_schedule`
--

CREATE TABLE `training_schedule` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `training_type` enum('internal','external','certification') NOT NULL,
  `competency_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `status` enum('Scheduled','Completed','Missed') DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `provider_id` int(11) DEFAULT NULL,
  `assessment_status` enum('pending','completed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_schedule`
--

INSERT INTO `training_schedule` (`id`, `title`, `training_type`, `competency_id`, `start_date`, `end_date`, `start_time`, `end_time`, `venue`, `employee_id`, `status`, `created_at`, `updated_at`, `provider_id`, `assessment_status`) VALUES
(13, '', 'internal', 2, '2026-03-04', '2026-03-04', '15:40:00', '15:43:00', 'xd', 57, 'Completed', '2026-03-04 07:40:30', '2026-03-04 07:42:01', NULL, 'completed'),
(14, '', 'internal', 1, '2026-03-04', '2026-03-04', '16:05:00', '16:06:00', 'xd', 57, 'Completed', '2026-03-04 08:05:45', '2026-03-04 08:06:53', NULL, 'completed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `date` (`date`),
  ADD KEY `attendance_shift_fk` (`shift_id`);

--
-- Indexes for table `attendance_summary`
--
ALTER TABLE `attendance_summary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_period` (`employee_id`,`period_start`,`period_end`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `period_dates` (`period_start`,`period_end`);

--
-- Indexes for table `benefit_providers`
--
ALTER TABLE `benefit_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_name` (`provider_name`);

--
-- Indexes for table `compensation_reviews`
--
ALTER TABLE `compensation_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `status` (`status`),
  ADD KEY `effective_date` (`effective_date`);

--
-- Indexes for table `competencies`
--
ALTER TABLE `competencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `competency_assessments`
--
ALTER TABLE `competency_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assessment_employee` (`employee_id`),
  ADD KEY `fk_assessment_competency` (`competency_id`),
  ADD KEY `fk_assessment_assessor` (`assessor_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_number` (`employee_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `shift_id` (`shift_id`);

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
-- Indexes for table `expense_claims`
--
ALTER TABLE `expense_claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_employee` (`employee_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_expense_date` (`expense_date`),
  ADD KEY `fk_claim_approver` (`approved_by`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_job_posting` (`position`,`department`,`location`,`shift`,`salary`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

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
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shift_code` (`shift_code`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_ibfk_1` (`assigned_to`);

--
-- Indexes for table `training_providers`
--
ALTER TABLE `training_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee` (`employee_id`),
  ADD KEY `fk_competency` (`competency_id`),
  ADD KEY `fk_provider` (`provider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notes`
--
ALTER TABLE `admin_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `attendance_summary`
--
ALTER TABLE `attendance_summary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `benefit_providers`
--
ALTER TABLE `benefit_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `compensation_reviews`
--
ALTER TABLE `compensation_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `competencies`
--
ALTER TABLE `competencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `competency_assessments`
--
ALTER TABLE `competency_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `employee_benefits`
--
ALTER TABLE `employee_benefits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense_claims`
--
ALTER TABLE `expense_claims`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `performance_criteria_scores`
--
ALTER TABLE `performance_criteria_scores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `performance_improvement_plans`
--
ALTER TABLE `performance_improvement_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `regular_employment`
--
ALTER TABLE `regular_employment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `training_providers`
--
ALTER TABLE `training_providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training_schedule`
--
ALTER TABLE `training_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD CONSTRAINT `fk_admin_notes_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_shift_fk` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `compensation_reviews`
--
ALTER TABLE `compensation_reviews`
  ADD CONSTRAINT `fk_compensation_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `competency_assessments`
--
ALTER TABLE `competency_assessments`
  ADD CONSTRAINT `fk_assessment_assessor` FOREIGN KEY (`assessor_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assessment_competency` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assessment_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `expense_claims`
--
ALTER TABLE `expense_claims`
  ADD CONSTRAINT `fk_claim_approver` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_claim_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

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

--
-- Constraints for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD CONSTRAINT `fk_competency` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_provider` FOREIGN KEY (`provider_id`) REFERENCES `training_providers` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
