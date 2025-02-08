-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 17, 2024 at 01:32 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `department_id` int(10) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `lid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(250) NOT NULL,
  `attachments` text DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'No Action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `department_id` int(10) NOT NULL,
  `description` varchar(250) NOT NULL,
  `attachments` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Not Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tid`, `uid`, `department_id`, `description`, `attachments`, `start_date`, `end_date`, `status`) VALUES
(1, 4, 5, 'Assignment 1', NULL, '2023-09-14', '2023-09-18', 'In-Progress'),
(2, 8, 5, 'Submit the reports by 20th', NULL, '2023-09-18', '2023-09-20', 'In-Progress'),
(3, 3, 0, 'Mention the task here.', NULL, '2023-09-19', '2023-09-20', 'In-Progress'),
(4, 3, 0, 'Complete Project Report', NULL, '2023-09-21', '2023-09-24', 'Complete'),
(5, 8, 5, 'CAD Design Project', NULL, '2023-09-14', '2023-09-28', 'Complete'),
(6, 4, 1, 'Troubleshooting and Repair', NULL, '2023-09-21', '2023-09-27', 'Complete'),
(7, 8, 5, 'Ethical Dilemma Analysis', ',attachment_task_670f9e70bd82e3.94746020_1.docx', '2023-09-20', '2023-09-25', 'In-Progress'),
(8, 4, 5, 'Prepare the list of all absent students', NULL, '2023-09-26', '2023-09-26', 'Approved'),
(9, 3, 0, 'Study for Midsem2', NULL, '2023-09-29', '2023-09-30', 'In-Progress'),
(20, 4, 5, 'Simple Iot Dashboard', 'attachment_task_670ea7431cabc7.18856365_2.png,attachment_task_670ec64d01dd02.47891730_1.jpeg,attachment_task_670f5ab5f39c19.77637751_1.png,attachment_task_670f82a29f5fc3.11206002_1.pdf', '2024-10-15', '2024-10-16', 'Complete'),
(21, 8, 5, 'New Tech Task needed right now', 'attachment_task_670edb9bd66187.74310274_1.png,attachment_task_670f9f06c4a1c0.26273404_1.docx', '2024-10-16', '2024-10-17', 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `task_comment_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `from_type` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_comments`
--

INSERT INTO `task_comments` (`task_comment_id`, `task_id`, `uid`, `comment`, `comment_date`, `from_type`) VALUES
(1, 6, 4, 'Task is successfully completed', '2024-10-16 15:02:42', 'admin'),
(2, 1, 4, 'I like this work', '2024-10-16 15:05:15', 'admin'),
(3, 2, 1, 'Looks good to me', '2024-10-16 15:17:56', 'admin'),
(4, 1, 1, 'I like this', '2024-10-16 15:28:40', 'admin'),
(5, 7, 8, 'Looking good', '2024-10-16 15:29:24', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE `task_history` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `from_uid` int(11) NOT NULL,
  `to_uid` int(11) NOT NULL,
  `reassigned_at` datetime DEFAULT current_timestamp(),
  `status_before` varchar(100) DEFAULT NULL,
  `status_after` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(14, 1, 1, 4, '2024-10-16 18:05:15', 'Not Started', 'In-Progress');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `department_id` int(10) DEFAULT NULL,
  `mobile` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `task_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_history`
--
ALTER TABLE `task_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
