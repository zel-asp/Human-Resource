-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 10, 2026 at 03:29 PM
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
  `rate_per_hour` decimal(10,2) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `status` enum('New','Review','Interview','Offer','Rejected','Hired','Contract') NOT NULL DEFAULT 'New',
  `hired_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `interview_date` date DEFAULT NULL,
  `contract_signing_date` date DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `cover_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `shift` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `full_name`, `department`, `email`, `phone`, `position`, `rate_per_hour`, `experience`, `education`, `skills`, `status`, `hired_date`, `start_date`, `interview_date`, `contract_signing_date`, `resume_path`, `cover_note`, `created_at`, `age`, `gender`, `shift`) VALUES
(60, 'Janzel Dolo', 'Finance', 'janzeldols@gmail.com', '09565819961', 'Restaurant Serversf', NULL, '1 yr service crew', 'college undergraduate', 'Teamwork, fast learner', 'Hired', '2026-03-07', '2026-03-09', NULL, '2026-03-10', 'https://plxoonwsguadkqisevxh.supabase.co/storage/v1/object/public/resumes/1772885794998-q8o2eatgl2.png', 'try me', '2026-03-07 12:16:38', 21, 'male', 1),
(66, 'sakura', 'Finance', 'ad1@gmail.com', '09123456789', 'Restaurant Server', 600.00, 'fsd', 'dsfs', 'k', 'Hired', '2026-03-10', '2026-03-11', NULL, '2026-03-10', '', '', '2026-03-10 18:08:29', 34, 'female', 1),
(67, 'Sakuke', 'Hotel', 'Bossing.Do1s@gmail.com', '09565819961', 'frontdesk', 400.00, 'xcv', 'd', 'd', 'Hired', '2026-03-10', '2026-03-11', NULL, NULL, '', '', '2026-03-09 16:25:58', 23, 'male', 2),
(68, 'Uzumaki', 'Hotel', 'uzumakiss.Do1s@gmail.com', '09565819961', 'frontdesk', 400.00, 'xcv', 'xcv', 'd', 'Hired', '2026-03-10', '2026-03-11', NULL, NULL, '', '', '2026-03-10 11:43:47', 23, 'female', 1),
(69, 'Sai', 'Hotel', 'Sai@gmail.com', '09565819961', 'frontdesk', 400.00, 'xcv', 'xcv', 'w', 'Hired', '2026-03-10', '2026-03-11', NULL, NULL, '', '', '2026-03-10 12:07:09', 23, 'female', 1);

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
(205, 82, 1, '2026-03-10 18:20:11', '2026-03-10 18:20:24', NULL, 0, 740, 'late', 8.00, 0.00, 0, 'clocked_out', '2026-03-10', '2026-03-10 10:20:11', '2026-03-10 10:20:34'),
(206, 82, 1, '2026-03-10 18:20:43', '2026-03-10 18:21:24', NULL, 0, 740, 'late', 0.01, 0.00, 0, 'clocked_out', '2026-03-10', '2026-03-10 10:20:43', '2026-03-10 10:21:24'),
(207, 82, 1, '2026-03-10 18:21:38', '2026-03-10 18:22:28', NULL, 0, 741, 'late', 0.01, 0.00, 0, 'clocked_out', '2026-03-10', '2026-03-10 10:21:38', '2026-03-10 10:22:28'),
(208, 82, 1, '2026-03-10 18:22:39', NULL, NULL, 0, 742, 'late', 0.00, 0.00, 0, 'clocked_in', '2026-03-10', '2026-03-10 10:22:39', '2026-03-10 13:09:18');

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
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_summary`
--

INSERT INTO `attendance_summary` (`id`, `employee_id`, `period_start`, `period_end`, `total_regular_hours`, `total_overtime_hours`, `total_late_minutes`, `status`, `created_at`, `updated_at`) VALUES
(54, 82, '2026-03-06', '2026-03-20', 64.00, 0.00, 2221, 'approved', '2026-03-10 10:20:24', '2026-03-10 10:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_uploads`
--

CREATE TABLE `attendance_uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `records_processed` int(11) DEFAULT 0,
  `shift_updates` int(11) DEFAULT 0,
  `errors` text DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_by` int(11) DEFAULT NULL,
  `proposed_hourly_rate` decimal(10,2) DEFAULT NULL COMMENT 'Proposed hourly rate for compensation review'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compensation_reviews`
--

INSERT INTO `compensation_reviews` (`id`, `employee_id`, `current_salary`, `review_type`, `review_date`, `effective_date`, `proposed_salary`, `status`, `finance_approved_at`, `finance_approved_by`, `finance_notes`, `budget_code`, `created_at`, `updated_at`, `created_by`, `proposed_hourly_rate`) VALUES
(16, 82, 23584.00, 'annual', '2026-03-09', '2026-03-10', 28999.52, 'pending_finance', NULL, NULL, '', '', '2026-03-09 12:26:48', '2026-03-09 12:27:20', NULL, 164.77);

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
(2, 'Food Safety', NULL, '2026-03-02 06:32:29', 3),
(3, 'POS Systems', NULL, '2026-03-02 06:32:29', 3),
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
  `status` enum('Passed','Needs Improvement') NOT NULL,
  `notified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competency_assessments`
--

INSERT INTO `competency_assessments` (`id`, `employee_id`, `competency_id`, `assessor_id`, `proficiency_level`, `assessment_notes`, `assessment_date`, `created_at`, `status`, `notified`) VALUES
(20, 98, 2, 101, 2, 'n', '2026-03-10', '2026-03-10 13:13:06', 'Needs Improvement', 1);

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
  `benefit_status` varchar(50) DEFAULT 'Not Enrolled',
  `resume` varchar(255) DEFAULT NULL,
  `birth_certificate` varchar(255) DEFAULT NULL,
  `nbi_clearance` varchar(255) DEFAULT NULL,
  `medical_result` varchar(255) DEFAULT NULL,
  `interview_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `applicant_id`, `employee_number`, `full_name`, `email`, `phone`, `position`, `hourly_rate`, `department`, `start_date`, `hired_date`, `onboarding_status`, `status`, `shift_id`, `created_at`, `updated_at`, `evaluation_status`, `role`, `age`, `gender`, `benefit_status`, `resume`, `birth_certificate`, `nbi_clearance`, `medical_result`, `interview_date`) VALUES
(82, 60, 'EMP-060', 'Janzel Dolo', 'janzeldols@gmail.com', '09565819961', 'Restaurant Serversf', 134.00, 'Finance', '2026-03-09', '2026-03-07', 'Onboarding', 'Probationary', 1, '2026-03-08 12:37:05', '2026-03-10 17:17:03', 'Pending', 'admin', 21, 'male', 'enrolled', 'https://plxoonwsguadkqisevxh.supabase.co/storage/v1/object/public/resumes/1772885794998-q8o2eatgl2.png', NULL, NULL, NULL, NULL),
(98, 67, 'EMP-067', 'Sakuke', 'Bossing.Do1s@gmail.com', '09565819961', 'frontdesk', 60.00, 'Hotel', '2026-03-11', '2026-03-09', 'Onboarding', 'Probationary', 2, '2026-03-10 00:52:15', '2026-03-10 21:12:30', 'Pending', 'employee', 23, 'male', 'Not Enrolled', '', NULL, NULL, NULL, NULL),
(99, 68, 'EMP-068', 'Uzumaki', 'uzumakiss.Do1s@gmail.com', '09565819961', 'frontdesk', 0.00, 'Hotel', '2026-03-11', '2026-03-10', 'Onboarding', 'Probationary', 1, '2026-03-10 19:44:34', '2026-03-10 19:44:34', 'Pending', 'employee', 23, 'female', 'Not Enrolled', '', NULL, NULL, NULL, NULL),
(100, 66, 'EMP-066', 'sakura', 'ad1@gmail.com', '09123456789', 'Restaurant Server', 600.00, 'Finance', '2026-03-11', '2026-03-10', 'Onboarding', 'Probationary', 1, '2026-03-10 20:06:00', '2026-03-10 20:06:00', 'Pending', 'employee', 34, 'female', 'Not Enrolled', '', NULL, NULL, NULL, NULL),
(101, 69, 'EMP-069', 'Sai', 'Sai@gmail.com', '09565819961', 'frontdesk', 400.00, 'Hotel', '2026-03-11', '2026-03-10', 'In Progress', 'Probationary', 1, '2026-03-10 20:07:20', '2026-03-10 21:12:47', 'Pending', 'evaluator', 23, 'female', 'Not Enrolled', '', NULL, NULL, NULL, NULL);

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
(46, 60, 'EMP-060', 'janzeldols', '$2y$10$iMquynkzV/CTf9mhSiv0meCxxmZIQZiC0ijBs3E21xeyBTS7nl7PW', 'janzeldols@gmail.com', 'Active', '2026-03-08 04:41:27', '2026-03-10 13:09:41', 'Finance', 'b14266e734c2044251a493ed30913bcd2f6105c0b72cc44c260b0a38d88a6ed3'),
(54, 66, 'EMP-066', 'ad1', '$2y$10$c4ogHY73gf3HYebpSrqMMe9/D/QjxAgJsNNldYkBfME/LP8USiNcC', 'ad1@gmail.com', 'Active', '2026-03-11 07:34:14', '2026-03-10 10:24:55', 'Finance', '92fd87ec2bc7e2d9882d2aa3dba1c7e3ab310651f3cc889d3c0bc9e7c8cd6aaa');

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

--
-- Dumping data for table `employee_benefits`
--

INSERT INTO `employee_benefits` (`id`, `employee_id`, `benefit_type`, `provider_id`, `effective_date`, `expiry_date`, `coverage_amount`, `monthly_premium`, `dependents`, `created_at`, `updated_at`) VALUES
(15, 82, 'HMO - Principal + 1 Dependent', 4, '2026-03-08', '2026-03-09', 12.00, 31.00, 'fs', '2026-03-08 13:30:04', '2026-03-08 13:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `employee_recognitions`
--

CREATE TABLE `employee_recognitions` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `recognition_type` enum('Employee of the Month','Rising Star','Perfect Attendance','Innovation Award','Team Player') NOT NULL,
  `performance_highlight` text DEFAULT NULL,
  `recognized_by` int(11) DEFAULT NULL,
  `recognition_date` date DEFAULT curdate(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_recognitions`
--

INSERT INTO `employee_recognitions` (`id`, `employee_id`, `recognition_type`, `performance_highlight`, `recognized_by`, `recognition_date`, `created_at`) VALUES
(4, 77, 'Rising Star', 'try101', NULL, '2026-03-07', '2026-03-07 12:21:50'),
(5, 81, 'Employee of the Month', 'f', 81, '2026-03-08', '2026-03-08 05:27:54'),
(6, 95, 'Rising Star', 'x', 95, '2026-06-09', '2026-06-09 09:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `employee_schedules`
--

CREATE TABLE `employee_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `shift_id` int(10) UNSIGNED DEFAULT NULL,
  `schedule_date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `shift_code` varchar(20) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `status` enum('scheduled','cancelled','completed') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_schedules`
--

INSERT INTO `employee_schedules` (`id`, `employee_id`, `shift_id`, `schedule_date`, `time_in`, `time_out`, `shift_code`, `department`, `status`, `created_at`, `updated_at`) VALUES
(35, 82, 2, '2026-03-09', '09:00:00', '18:00:00', NULL, 'Logistic', 'scheduled', '2026-03-08 05:14:54', '2026-03-08 07:40:51'),
(37, 82, 1, '2026-03-06', '06:00:00', '14:00:00', NULL, 'Logistic', 'scheduled', '2026-03-08 07:55:39', '2026-03-08 07:55:39');

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
  `status` enum('Pending','Approved','Rejected','Cancelled','Paid') NOT NULL DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intervention_assignments`
--

CREATE TABLE `intervention_assignments` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `competency_name` varchar(150) NOT NULL,
  `current_level` tinyint(4) NOT NULL,
  `required_level` tinyint(4) NOT NULL,
  `intervention_title` varchar(255) NOT NULL,
  `intervention_type` varchar(100) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `badge_text` varchar(50) DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed','cancelled') DEFAULT 'pending',
  `completion_date` date DEFAULT NULL,
  `new_level` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `notes` text DEFAULT NULL,
  `competency_assessment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `intervention_assignments`
--

INSERT INTO `intervention_assignments` (`id`, `employee_id`, `employee_name`, `competency_name`, `current_level`, `required_level`, `intervention_title`, `intervention_type`, `duration`, `badge_text`, `assigned_date`, `due_date`, `status`, `completion_date`, `new_level`, `created_at`, `updated_at`, `notes`, `competency_assessment_id`) VALUES
(24, 98, 'Sakuke', 'Food Safety', 2, 3, 'Food Safety Excellence Training', 'Online course', '4 hours', 'Recommended', '2026-03-10', '2026-04-09', 'completed', '2026-03-10', 4, '2026-03-10 13:30:54', '2026-03-10 13:56:21', 'Assigned based on competency gap assessment #20', 20),
(25, 98, 'Sakuke', 'Food Safety', 2, 3, 'One-on-One Mentoring Program', 'Mentoring', '3 months', 'Intensive', '2026-03-10', '2026-04-09', 'completed', '2026-03-10', 2, '2026-03-10 13:55:45', '2026-03-10 13:56:25', 'Assigned based on competency gap assessment #20', 20);

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
  `salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `position`, `department`, `location`, `shift`, `salary`, `created_at`, `updated_at`) VALUES
(62, 'frontdesk', 'Hotel', 'Main Dining Room', '1', 400.00, '2026-03-09 16:24:16', '2026-03-09 16:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `job_requisitions`
--

CREATE TABLE `job_requisitions` (
  `id` int(11) NOT NULL,
  `job_title` varchar(150) NOT NULL,
  `department` varchar(100) NOT NULL,
  `requested_by` varchar(150) NOT NULL,
  `positions` int(11) NOT NULL,
  `needed_by` date NOT NULL,
  `priority` enum('high','medium','low') DEFAULT 'medium',
  `status` enum('pending','approved','declined') DEFAULT 'pending',
  `justification` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `mentor_assignments`
--

CREATE TABLE `mentor_assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `mentee_employee_id` int(11) NOT NULL,
  `mentor_employee_id` int(11) NOT NULL,
  `program_duration` enum('3 months','6 months','12 months') NOT NULL,
  `goals` text DEFAULT NULL,
  `status` enum('Active','Completed','Cancelled') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentor_assignments`
--

INSERT INTO `mentor_assignments` (`id`, `mentee_employee_id`, `mentor_employee_id`, `program_duration`, `goals`, `status`, `created_at`, `updated_at`) VALUES
(1, 62, 68, '6 months', 'fi', 'Active', '2026-03-09 15:52:13', '2026-03-09 15:52:13'),
(2, 63, 62, '12 months', 'nice', 'Active', '2026-03-09 16:14:51', '2026-03-09 16:14:51');

-- --------------------------------------------------------

--
-- Table structure for table `mentor_ratings`
--

CREATE TABLE `mentor_ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `mentee_employee_id` int(11) NOT NULL,
  `mentor_employee_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `rating_date` date DEFAULT curdate(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_summary`
--

CREATE TABLE `payroll_summary` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `total_regular_hours` decimal(7,2) DEFAULT 0.00,
  `total_overtime_hours` decimal(7,2) DEFAULT 0.00,
  `hourly_rate` decimal(10,2) DEFAULT 0.00,
  `gross_pay` decimal(12,2) DEFAULT 0.00,
  `total_deductions` decimal(12,2) DEFAULT 0.00,
  `net_pay` decimal(12,2) DEFAULT 0.00,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `claims` decimal(10,2) DEFAULT 0.00,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll_summary`
--

INSERT INTO `payroll_summary` (`id`, `employee_id`, `period_start`, `period_end`, `total_regular_hours`, `total_overtime_hours`, `hourly_rate`, `gross_pay`, `total_deductions`, `net_pay`, `generated_at`, `claims`, `status`) VALUES
(35, 82, '2026-03-06', '2026-03-20', 64.00, 0.00, 134.00, 8576.00, 600.00, 7976.00, '2026-03-10 10:28:07', 0.00, 'Processed');

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
-- Table structure for table `schedule_contract`
--

CREATE TABLE `schedule_contract` (
  `id` int(11) NOT NULL,
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `employee_name` varchar(150) NOT NULL,
  `position` varchar(100) NOT NULL,
  `contract_date` date NOT NULL,
  `contract_time` time DEFAULT NULL,
  `contract_location` varchar(150) DEFAULT NULL,
  `contract_notes` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hourly_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Ended') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_contract`
--

INSERT INTO `schedule_contract` (`id`, `applicant_id`, `employee_name`, `position`, `contract_date`, `contract_time`, `contract_location`, `contract_notes`, `updated_at`, `created_at`, `hourly_rate`, `status`) VALUES
(16, 66, 'sakura', 'Restaurant Server', '2026-03-10', '10:00:00', 'HR Office', '', NULL, '2026-03-10 18:42:19', 300.00, 'Ended');

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
-- Table structure for table `shift_swap_requests`
--

CREATE TABLE `shift_swap_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `requester_employee_id` int(11) NOT NULL,
  `swap_with_employee_id` int(11) NOT NULL,
  `swap_date` date NOT NULL,
  `requester_shift_id` int(10) UNSIGNED DEFAULT NULL,
  `swap_with_shift_id` int(10) UNSIGNED DEFAULT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift_swap_requests`
--

INSERT INTO `shift_swap_requests` (`id`, `requester_employee_id`, `swap_with_employee_id`, `swap_date`, `requester_shift_id`, `swap_with_shift_id`, `reason`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(6, 62, 63, '2026-03-10', 1, 2, 'hi', 'Approved', NULL, '2026-03-08 21:49:15', '2026-03-08 13:49:09', '2026-03-08 13:49:15'),
(7, 79, 77, '2026-03-09', 1, 1, 'dfsd', 'Approved', 79, '2026-03-08 12:34:19', '2026-03-08 04:34:06', '2026-03-08 04:34:19'),
(8, 81, 82, '2026-03-09', 3, 1, 'pls', 'Approved', 81, '2026-03-08 12:42:24', '2026-03-08 04:42:17', '2026-03-08 04:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `statutory_deductions`
--

CREATE TABLE `statutory_deductions` (
  `id` int(11) NOT NULL,
  `deduction_name` varchar(50) NOT NULL,
  `deduction_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statutory_deductions`
--

INSERT INTO `statutory_deductions` (`id`, `deduction_name`, `deduction_amount`, `created_at`) VALUES
(1, 'SSS', 250.00, '2026-03-05 12:52:31'),
(2, 'PhilHealth', 250.00, '2026-03-05 12:52:31'),
(3, 'PagIBIG', 100.00, '2026-03-05 12:52:31');

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
(46, 101, 'paperwork', 'we', '2026-03-11', 'medium', '', 'Not Started', '2026-03-10 12:07:59', '2026-03-10 12:07:59');

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
(24, '', 'internal', 1, '2026-03-11', '2026-03-12', '13:15:00', '13:15:00', 'xd', 98, 'Scheduled', '2026-03-10 05:15:27', '2026-03-10 05:15:59', NULL, 'failed'),
(25, '', 'internal', 3, '2026-03-10', '2026-03-11', '13:53:00', '13:53:00', 'sd', 98, 'Scheduled', '2026-03-10 05:53:47', '2026-03-10 05:54:59', NULL, 'completed'),
(26, '', 'internal', 2, '2026-03-11', '2026-03-11', '21:12:00', '21:14:00', 'sd', 98, 'Scheduled', '2026-03-10 13:11:35', '2026-03-10 13:13:06', NULL, 'failed');

-- --------------------------------------------------------

--
-- Table structure for table `upload_sessions`
--

CREATE TABLE `upload_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `total_records` int(11) DEFAULT 0,
  `processed_records` int(11) DEFAULT 0,
  `warnings` text DEFAULT NULL,
  `errors` text DEFAULT NULL,
  `unmatched_employees` text DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `attendance_uploads`
--
ALTER TABLE `attendance_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

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
-- Indexes for table `employee_recognitions`
--
ALTER TABLE `employee_recognitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_schedules`
--
ALTER TABLE `employee_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `schedule_date` (`schedule_date`),
  ADD KEY `shift_id` (`shift_id`);

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
-- Indexes for table `intervention_assignments`
--
ALTER TABLE `intervention_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `fk_intervention_competency` (`competency_assessment_id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_job_posting` (`position`,`department`,`location`,`shift`,`salary`);

--
-- Indexes for table `job_requisitions`
--
ALTER TABLE `job_requisitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `mentor_assignments`
--
ALTER TABLE `mentor_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentor_ratings`
--
ALTER TABLE `mentor_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rating_mentor` (`mentor_employee_id`),
  ADD KEY `fk_rating_mentee` (`mentee_employee_id`);

--
-- Indexes for table `payroll_summary`
--
ALTER TABLE `payroll_summary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_pay_period` (`employee_id`,`period_start`,`period_end`);

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
-- Indexes for table `schedule_contract`
--
ALTER TABLE `schedule_contract`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_id` (`applicant_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shift_code` (`shift_code`);

--
-- Indexes for table `shift_swap_requests`
--
ALTER TABLE `shift_swap_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statutory_deductions`
--
ALTER TABLE `statutory_deductions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `upload_sessions`
--
ALTER TABLE `upload_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notes`
--
ALTER TABLE `admin_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `attendance_summary`
--
ALTER TABLE `attendance_summary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `attendance_uploads`
--
ALTER TABLE `attendance_uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `benefit_providers`
--
ALTER TABLE `benefit_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `compensation_reviews`
--
ALTER TABLE `compensation_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `competencies`
--
ALTER TABLE `competencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `competency_assessments`
--
ALTER TABLE `competency_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `employee_benefits`
--
ALTER TABLE `employee_benefits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `employee_recognitions`
--
ALTER TABLE `employee_recognitions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee_schedules`
--
ALTER TABLE `employee_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `expense_claims`
--
ALTER TABLE `expense_claims`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `intervention_assignments`
--
ALTER TABLE `intervention_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `job_requisitions`
--
ALTER TABLE `job_requisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mentor_assignments`
--
ALTER TABLE `mentor_assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mentor_ratings`
--
ALTER TABLE `mentor_ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payroll_summary`
--
ALTER TABLE `payroll_summary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `performance_criteria_scores`
--
ALTER TABLE `performance_criteria_scores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `performance_improvement_plans`
--
ALTER TABLE `performance_improvement_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `regular_employment`
--
ALTER TABLE `regular_employment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `schedule_contract`
--
ALTER TABLE `schedule_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shift_swap_requests`
--
ALTER TABLE `shift_swap_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `statutory_deductions`
--
ALTER TABLE `statutory_deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `training_providers`
--
ALTER TABLE `training_providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training_schedule`
--
ALTER TABLE `training_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `upload_sessions`
--
ALTER TABLE `upload_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `attendance_uploads`
--
ALTER TABLE `attendance_uploads`
  ADD CONSTRAINT `attendance_uploads_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `employee_schedules`
--
ALTER TABLE `employee_schedules`
  ADD CONSTRAINT `fk_schedule_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_schedule_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `expense_claims`
--
ALTER TABLE `expense_claims`
  ADD CONSTRAINT `fk_claim_approver` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_claim_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `intervention_assignments`
--
ALTER TABLE `intervention_assignments`
  ADD CONSTRAINT `fk_intervention_competency` FOREIGN KEY (`competency_assessment_id`) REFERENCES `competency_assessments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mentor_ratings`
--
ALTER TABLE `mentor_ratings`
  ADD CONSTRAINT `fk_rating_mentee` FOREIGN KEY (`mentee_employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rating_mentor` FOREIGN KEY (`mentor_employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `payroll_summary`
--
ALTER TABLE `payroll_summary`
  ADD CONSTRAINT `payroll_summary_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `schedule_contract`
--
ALTER TABLE `schedule_contract`
  ADD CONSTRAINT `schedule_contract_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;

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

--
-- Constraints for table `upload_sessions`
--
ALTER TABLE `upload_sessions`
  ADD CONSTRAINT `upload_sessions_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
