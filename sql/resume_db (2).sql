-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 07:01 PM
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
-- Database: `resume_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `school` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `school`, `degree`, `start_year`, `end_year`, `location`, `description`) VALUES
(2, 'Dong-Eui University', 'B.Sc. in Computer Science', 2024, 2028, 'Busan, South Korea', 'Currently pursuing a Computer Science degree with focus on software development and machine learning. Expected graduation in 2028.'),
(3, 'Fergana State University of Economics', 'B.Sc. in Economics', 2022, 2024, 'Fergana, Uzbekistan', 'Completed core studies in economics, finance, and analytical methods before transferring to Korea.');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `company`, `position`, `start_year`, `end_year`, `location`, `description`) VALUES
(4, 'AI Vision Lab', 'Machine Learning Intern', 2024, 2025, 'Busan, South Korea', 'Worked on computer vision tasks including image classification and dataset annotation. Improved model accuracy by 12%.'),
(5, 'Freelance Projects', 'Software Developer', 2022, 2023, 'Remote', 'Developed small-scale Python and web applications for clients. Built REST APIs and custom automation tools.');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `link`, `start_year`, `end_year`) VALUES
(2, 'Job Portal Web Application', 'A full-featured job portal allowing job seekers and employers to interact. Includes authentication, job posting, applications, and dashboards.', 'https://github.com/nurbek-dev/job-portal', 2025, 2025),
(3, 'Machine Learning Stock Predictor', 'LSTM-based deep learning model that predicts stock movement using historical price data.', 'https://github.com/nurbek-dev/stock-predictor', 2024, 2024),
(4, 'C++ Technical Documentation Website', 'Built a documentation website for C++ learners with examples, explanations, and interactive demos.', 'https://github.com/nurbek-dev/cpp-docs', 2024, 2024),
(5, 'Dynamic Resume Builder', 'A fully dynamic resume management system built with PHP, MySQL, HTML, CSS, and JavaScript. Includes CRUD, authentication, resume sections, admin panel, and user-friendly interface.', 'https://github.com/yourusername/dynamic-resume', 2024, 2025),
(6, 'University Club Management System', 'A complete university club and event management system developed using PHP, MySQL, HTML, CSS, and JavaScript. Features multi-role authentication, club CRUD, event management, user join requests, and responsive dashboards.', 'https://github.com/yourusername/university-club-management', 2024, 2025);

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE `resume` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`id`, `full_name`, `title`, `about`, `email`, `phone`, `location`, `linkedin`, `github`, `avatar_path`) VALUES
(2, 'Nurbek Makhmadaminov', 'Machine Learning Engineer', 'Passionate ML engineer with strong foundations in algorithm design, model training, and deployment. Experienced with Python, C++, and building real-world AI applications.', 'nurbekprodev@gmail.com', '+82-10-1234-5678', 'Busan, South Korea', 'linkedin.com/in/nurbekprodev', 'https://github.com/Nurbekprodev', '../uploads/thumb_avatar_692880c5d7483.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill_name`, `level`, `category`) VALUES
(1, 'C', 'indermediate', 'Programming language'),
(2, 'Python', 'Expert', 'Programming'),
(3, 'C++', 'Advanced', 'Programming'),
(4, 'Machine Learning', 'Advanced', 'AI'),
(5, 'Deep Learning', 'Intermediate', 'AI'),
(6, 'HTML/CSS', 'Advanced', 'Web Development'),
(7, 'JavaScript', 'Intermediate', 'Web Development'),
(8, 'SQL', 'Advanced', 'Database'),
(9, 'Data Analysis', 'Advanced', 'Data'),
(10, 'Linux', 'Intermediate', 'Systems'),
(11, 'PHP', 'Intermediate', 'Programming'),
(12, 'C', 'Intermediate', 'Programming');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(6, 'nurbek', '$2b$12$bcPxkfjne8uPRM8kK1ZjAe58aaUTsyNRWNXiCZ6nDm2zrtXjQC7EW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resume`
--
ALTER TABLE `resume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
