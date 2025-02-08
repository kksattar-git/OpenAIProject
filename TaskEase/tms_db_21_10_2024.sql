-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 21, 2024 at 06:26 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TaskEase`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobile` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `mobile`) VALUES
(1, 'Ankur', 'ankurchanda198@gmail.com', 'ankur123', 9832219955),
(2, 'Test', 'Test@gmail.com', 'Test123', 9999999999),
(4, 'Debajyoti ', 'debajyotimitra1@gmail.com', 'debajyoti123', 7439728929);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Administration'),
(2, 'Complaints'),
(3, 'Enforcement'),
(4, 'Finance'),
(5, 'ICT'),
(6, 'Inspection'),
(7, 'Interns and Attachees'),
(8, 'Legal'),
(9, 'Licensing'),
(10, 'Policy'),
(11, 'Prize Competition'),
(12, 'Procurement'),
(13, 'Public Lottery'),
(14, 'Registry'),
(15, 'Returns');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `lid` int NOT NULL,
  `uid` int NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(250) NOT NULL,
  `attachments` text,
  `status` varchar(100) NOT NULL DEFAULT 'No Action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`lid`, `uid`, `subject`, `message`, `attachments`, `status`) VALUES
(1, 2, 'Regarding one day CL', 'Sir,\r\nHaving urgent work at home, I cannot attend the meeting on 22nd Sep 2023', NULL, 'Approved'),
(2, 3, 'SIH Hackathon', 'Sir, I will have to take leave for the internal SIH hackathon on 20th Sep', NULL, 'Rejected'),
(3, 3, 'Presentation day Postponed', 'Postponed date. Need leave on 22nd.', NULL, 'Approved'),
(10, 4, 'Medical Emergency', 'Sir, I have to go to the clinic to do some blood tests immediately as told by the doctor.', NULL, 'Approved'),
(11, 4, 'Medical Emergency', 'Sir, i have to go to get my reports on Sunday\r\nThank you sir.', NULL, 'No Action'),
(12, 2, 'Call for Internship Interview', 'Sir, A Internship interview has been scheduled for me. The interview is supposed to be of 2 hours. Please check my leave application and let me know at the earliest.\r\nThank you Sir\r\nRounak', NULL, 'No Action'),
(13, 1, 'Editorial work', 'Editorial Work at R&D Lab', NULL, 'No Action'),
(14, 1, 'Marital Affair', 'Please allow me to take a leave', 'leave_attachment_14_1.webp,leave_attachment_14_1.webp', 'No Action'),
(15, 4, 'Marital Affair', 'Please allow me to attend to this matter', 'leave_attachment_15_1.docx', 'No Action');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `tid` int NOT NULL,
  `uid` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `department_id` int NOT NULL,
  `description` varchar(250) NOT NULL,
  `attachments` text,
  `current_assigne` int DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Not Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tid`, `uid`, `title`, `department_id`, `description`, `attachments`, `current_assigne`, `start_date`, `end_date`, `status`) VALUES
(1, 1, 'assignment title', 3, 'Assignment 1', NULL, 4, '2023-09-14', '2023-09-18', 'In-Progress'),
(2, 1, 'submit the report', 3, 'Submit the reports by 20th', NULL, 8, '2023-09-18', '2023-09-20', 'In-Progress'),
(3, 3, '', 0, 'Mention the task here.', NULL, NULL, '2023-09-19', '2023-09-20', 'In-Progress'),
(4, 2, 'Title Complete Project Report', 1, 'Complete Project Report', NULL, NULL, '2023-09-21', '2023-09-24', 'Complete'),
(5, 8, '', 5, 'CAD Design Project', NULL, 8, '2023-09-14', '2023-09-28', 'Complete'),
(6, 4, '', 1, 'Troubleshooting and Repair', NULL, NULL, '2023-09-21', '2023-09-27', 'Complete'),
(7, 8, '', 5, 'Ethical Dilemma Analysis', ',attachment_task_670f9e70bd82e3.94746020_1.docx', 8, '2023-09-20', '2023-09-25', 'In-Progress'),
(8, 4, '', 5, 'Prepare the list of all absent students', NULL, NULL, '2023-09-26', '2023-09-26', 'Approved'),
(9, 3, '', 0, 'Study for Midsem2', NULL, NULL, '2023-09-29', '2023-09-30', 'In-Progress'),
(20, 4, '', 5, 'Simple Iot Dashboard', 'attachment_task_670ea7431cabc7.18856365_2.png,attachment_task_670ec64d01dd02.47891730_1.jpeg,attachment_task_670f5ab5f39c19.77637751_1.png,attachment_task_670f82a29f5fc3.11206002_1.pdf', NULL, '2024-10-15', '2024-10-16', 'Complete'),
(21, 8, '', 5, 'New Tech Task needed right now', 'attachment_task_670edb9bd66187.74310274_1.png,attachment_task_670f9f06c4a1c0.26273404_1.docx', 8, '2024-10-16', '2024-10-17', 'Complete'),
(22, 1, '', 3, 'Test task is assigned to Kushan', NULL, 1, '2024-10-19', '2024-10-31', 'In-Progress'),
(23, 5, '', 2, 'this is the test task kushan 2', 'attachment_task_6713e95af33c90.04873951_1.docx', 5, '2024-10-19', '2024-10-31', 'In-Progress'),
(24, 2, 'title test', 1, 'title test task', NULL, NULL, '2024-10-21', '2024-10-21', 'Not Started');

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `task_comment_id` int NOT NULL,
  `task_id` int NOT NULL,
  `uid` int NOT NULL,
  `comment` text,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_type` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_comments`
--

INSERT INTO `task_comments` (`task_comment_id`, `task_id`, `uid`, `comment`, `comment_date`, `from_type`) VALUES
(1, 6, 4, 'Task is successfully completed', '2024-10-16 15:02:42', 'admin'),
(2, 1, 4, 'I like this work', '2024-10-16 15:05:15', 'admin'),
(3, 2, 1, 'Looks good to me', '2024-10-16 15:17:56', 'admin'),
(4, 1, 1, 'I like this', '2024-10-16 15:28:40', 'admin'),
(5, 7, 8, 'Looking good', '2024-10-16 15:29:24', 'user'),
(6, 2, 1, 'this is new comment ', '2024-10-21 04:51:49', 'admin'),
(7, 1, 1, 'this is the test comment for Rohit', '2024-10-21 04:52:54', 'admin'),
(8, 2, 1, 'test commetn for rohit', '2024-10-21 04:53:46', 'admin'),
(9, 1, 1, 'rohit answer for the current task is here', '2024-10-21 04:55:03', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE `task_history` (
  `id` int NOT NULL,
  `tid` int NOT NULL,
  `from_uid` int NOT NULL,
  `to_uid` int NOT NULL,
  `reassigned_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_before` varchar(100) DEFAULT NULL,
  `status_after` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_history`
--

INSERT INTO `task_history` (`id`, `tid`, `from_uid`, `to_uid`, `reassigned_at`, `status_before`, `status_after`) VALUES
(8, 7, 1, 8, '2024-10-16 10:44:06', 'Not Started', 'In-Progress'),
(9, 5, 4, 8, '2024-10-16 10:44:43', 'In-Progress', 'In-Progress'),
(10, 21, 4, 8, '2024-10-16 11:09:13', 'In-Progress', 'In-Progress'),
(11, 21, 8, 4, '2024-10-16 11:16:03', 'In-Progress', 'In-Progress'),
(12, 21, 4, 8, '2024-10-16 14:09:58', 'In-Progress', '-Select-'),
(13, 2, 2, 8, '2024-10-16 17:56:26', 'Not Started', 'In-Progress'),
(14, 1, 1, 4, '2024-10-16 18:05:15', 'Not Started', 'In-Progress'),
(15, 23, 3, 5, '2024-10-20 00:53:32', 'Not Started', 'In-Progress'),
(16, 22, 3, 5, '2024-10-20 00:55:36', 'Not Started', 'In-Progress'),
(17, 22, 5, 1, '2024-10-20 00:56:04', 'In-Progress', 'In-Progress'),
(18, 22, 1, 5, '2024-10-20 00:58:26', 'In-Progress', 'In-Progress'),
(19, 22, 5, 1, '2024-10-20 00:59:38', 'In-Progress', 'In-Progress');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `department_id` int DEFAULT NULL,
  `mobile` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `department_id`, `mobile`) VALUES
(1, 'Rohit Sharma', 'rohitsharma238@gmail.com', 'rohit2235', 3, 9843762952),
(2, 'Rounak Roy', 'rounakroy8838@gmail.com', 'rounak12367', 1, 9675335283),
(3, 'Kushan Choudhury', 'kushanchoudhury2003@gmail.com', 'kushan123', 3, 9834728283),
(4, 'Rohan Verma', 'rohan.verma09@gmail.com', 'rohan123', 5, 9999998499),
(5, 'Aryan Patel', 'aryan.patel123@yahoo.com', 'aryan123', 2, 9999971999),
(6, 'Kavita Mehta', 'kavita.mehta56@hotmail.com', 'kavita123', 4, 9999673999),
(8, 'John Michaelson', 'patoisprotagonist@gmail.com', '111111', 5, 32718280031);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`task_comment_id`);

--
-- Indexes for table `task_history`
--
ALTER TABLE `task_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `lid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `task_comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task_history`
--
ALTER TABLE `task_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
