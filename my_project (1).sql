-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 11:23 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_project`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertFaculty` (IN `p_first_name` VARCHAR(255), IN `p_middle_name` VARCHAR(255), IN `p_last_name` VARCHAR(255), IN `p_birthday` DATE, IN `p_gender` CHAR(1), IN `p_email` VARCHAR(255), IN `p_contact_number` VARCHAR(20), IN `p_password` VARCHAR(255), IN `p_institute` VARCHAR(255), IN `p_course` VARCHAR(255))   BEGIN
    DECLARE generated_user_id INT;

    -- Insert into User table
    INSERT INTO users (
        first_name,
        middle_name,
        last_name,
        birthday,
        gender,
        email,
        contact_number,
        password,
        role
    )
    VALUES (
        p_first_name,
        p_middle_name,
        p_last_name,
        p_birthday,
        p_gender,
        p_email,
        p_contact_number,
        p_password,
       "1"
    );

    -- Get the auto-generated user_id
    SET generated_user_id = LAST_INSERT_ID();

    -- Insert into Faculty table
    INSERT INTO Faculty (
        user_id,
        institute,
        course
    )
    VALUES (
        generated_user_id,
        p_institute,
        p_course
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertStudent` (IN `p_student_id` VARCHAR(10), IN `p_first_name` VARCHAR(255), IN `p_middle_name` VARCHAR(255), IN `p_last_name` VARCHAR(255), IN `p_birthday` DATE, IN `p_gender` VARCHAR(50), IN `p_email` VARCHAR(255), IN `p_contact_number` VARCHAR(20), IN `p_password` VARCHAR(100), IN `p_street` VARCHAR(255), IN `p_barangay` VARCHAR(255), IN `p_municipality` VARCHAR(255), IN `p_province` VARCHAR(255), IN `p_zipcode` VARCHAR(20), IN `p_institute` VARCHAR(255), IN `p_course` VARCHAR(255), IN `p_guardian_name` VARCHAR(255), IN `p_guardian_contact` VARCHAR(20), IN `p_guardian_address` VARCHAR(255))   BEGIN
 DECLARE generated_user_id INT;
    -- Insert into User table
    INSERT INTO users (
        first_name,
        middle_name,
        last_name,
        birthday,
        gender,
		email,
        contact_number,
        password,
        role
    )
    VALUES (
        p_first_name,
        p_middle_name,
        p_last_name,
        p_birthday,
        p_gender,
        p_email,
        p_contact_number,
        p_password,
        '2'
    );
 -- Get the auto-generated user_id
    SET generated_user_id = LAST_INSERT_ID();

    -- Insert into Students table
    INSERT INTO Students (
        student_id,
        user_id,
        street,
        barangay,
        municipality,
        province,
        zipcode,
        institute,
        course,
        guardian_name,
        guardian_contact,
        guardian_address
    )
    VALUES (
        p_student_id,
        generated_user_id,
        p_street,
        p_barangay,
        p_municipality,
        p_province,
        p_zipcode,
        p_institute,
        p_course,
        p_guardian_name,
        p_guardian_contact,
        p_guardian_address
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateFaculty` (IN `p_user_id` INT, IN `p_faculty_id` INT, IN `p_first_name` VARCHAR(255), IN `p_middle_name` VARCHAR(255), IN `p_last_name` VARCHAR(255), IN `p_birthday` DATE, IN `p_gender` CHAR(1), IN `p_email` VARCHAR(255), IN `p_contact_number` VARCHAR(20), IN `p_institute` VARCHAR(255), IN `p_course` VARCHAR(255))   BEGIN
    -- Update User table
    UPDATE users
    SET
        first_name = p_first_name,
        middle_name = p_middle_name,
        last_name = p_last_name,
        birthday = p_birthday,
        gender = p_gender,
        email = p_email,
        contact_number = p_contact_number
    WHERE
        user_id = p_user_id;

    -- Update Faculty table
    UPDATE Faculty
    SET
        institute = p_institute,
        course = p_course
    WHERE
        faculty_id = p_faculty_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateStudent` (IN `p_user_id` INT(11), IN `p_student_id` VARCHAR(10), IN `p_first_name` VARCHAR(255), IN `p_middle_name` VARCHAR(255), IN `p_last_name` VARCHAR(255), IN `p_birthday` DATE, IN `p_gender` VARCHAR(50), IN `p_email` VARCHAR(255), IN `p_contact_number` VARCHAR(20), IN `p_street` VARCHAR(255), IN `p_barangay` VARCHAR(255), IN `p_municipality` VARCHAR(255), IN `p_province` VARCHAR(255), IN `p_zipcode` VARCHAR(20), IN `p_institute` VARCHAR(255), IN `p_course` VARCHAR(255), IN `p_guardian_name` VARCHAR(255), IN `p_guardian_contact` VARCHAR(20), IN `p_guardian_address` VARCHAR(255))   BEGIN
    -- Update into User table
     UPDATE users SET
        first_name = p_first_name,
        middle_name = p_middle_name,
        last_name = p_last_name,
        birthday = p_birthday,
        gender = p_gender,
        email = p_email,
        contact_number = p_contact_number
        WHERE
        user_id = p_user_id;

    -- update into Students table
    UPDATE students
    SET
    	street = p_street,
        barangay = p_barangay,
        municipality = p_municipality,
        province = p_province,
        zipcode = p_zipcode,
        institute = p_institute,
        course = p_course,
        guardian_name = p_guardian_name,
        guardian_contact = p_guardian_contact,
        guardian_address = p_guardian_address
    WHERE
        student_id = p_student_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `institute` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `title`, `slug`, `description`, `institute`, `created_at`, `updated_at`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT', NULL, 'FCDSET', '2023-11-12 21:51:55', '2023-11-19 23:17:54'),
(3, 'Bachelor of Science in Civil Engineering', 'BSCE', '', 'FCDSET', '2023-11-14 20:03:23', '2023-11-19 23:18:11'),
(4, 'Bachelor of Physical Education', 'BPED', '', 'FTED', '2023-11-19 22:45:09', '2023-11-19 23:18:02'),
(5, 'Bachelor of Science in Criminology', 'BSCRIM', '', 'FGBM', '2023-11-19 22:48:05', '2023-11-19 23:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `institute` varchar(10) NOT NULL,
  `course` varchar(10) NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `user_id`, `institute`, `course`, `registered_at`, `updated_at`) VALUES
(9, 76, 'FCDSET', 'BSIT', '2023-11-29 22:27:52', NULL),
(10, 77, 'FGBM', 'BSCRIM', '2023-11-29 23:48:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_subjects`
--

CREATE TABLE `faculty_subjects` (
  `faculty_id` int(11) NOT NULL,
  `subject_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_subjects`
--

INSERT INTO `faculty_subjects` (`faculty_id`, `subject_code`) VALUES
(9, '123'),
(9, '1234'),
(10, '1234'),
(10, 'ITPE130');

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE `institute` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Faculty of Data Science Computing Engineering and Technology', 'FCDSET', NULL, '2023-11-12 21:53:22', '2024-01-07 09:03:20'),
(3, 'Faculty of Agriculture and Life Sciences', 'FALS', NULL, '2023-11-14 19:54:11', '2024-01-07 09:02:07'),
(4, 'Faculty of Teachers Education', 'FTED', NULL, '2023-11-19 22:44:30', '2024-01-07 09:02:10'),
(5, 'Faculty of Governance and Business Management', 'FGBM', NULL, '2023-11-19 22:47:50', '2024-01-07 09:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `schoolyear`
--

CREATE TABLE `schoolyear` (
  `id` int(10) NOT NULL,
  `school_year` varchar(10) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schoolyear`
--

INSERT INTO `schoolyear` (`id`, `school_year`, `semester`, `status`, `created_at`, `updated_at`) VALUES
(1, '2022-2023', '1st', '0', '2023-11-29 04:39:10', '2023-11-29 23:26:43'),
(3, '2023-2024', '1st', '1', '2023-11-29 21:54:33', '2024-01-07 09:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `zipcode` varchar(4) NOT NULL,
  `institute` varchar(10) NOT NULL,
  `course` varchar(10) NOT NULL,
  `guardian_name` varchar(50) NOT NULL,
  `guardian_contact` varchar(15) NOT NULL,
  `guardian_address` varchar(255) NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `street`, `barangay`, `municipality`, `province`, `zipcode`, `institute`, `course`, `guardian_name`, `guardian_contact`, `guardian_address`, `registered_at`, `updated_at`) VALUES
('2023-0002', 71, 'Baybay', 'Poblacion', 'Lupon', 'Davao Oriental', '8207', 'FTED', 'BPED', 'Jane Doe', '09123456789', 'Mauswagon, Corporacion, Lupon, Davao Oriental', '2023-11-29 17:50:50', '2023-11-29 17:55:11'),
('2023-0003', 72, 'Baybay', 'Poblacion', 'Lupon', 'Davao Oriental', '8207', 'FTED', 'BPED', 'Jane Doe', '09123456789', 'Mauswagon, Corporacion, Lupon, Davao Oriental', '2023-11-29 17:51:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `subject_code` varchar(10) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `grades` int(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`subject_code`, `student_id`, `faculty_id`, `grades`, `created_at`, `updated_at`) VALUES
('123', '2023-0002', 9, 2, '2023-12-29 04:40:01', '2024-01-07 08:24:08'),
('123', '2023-0003', 9, 1, '2024-01-07 04:51:14', '2024-01-07 08:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `code` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `unit` varchar(2) NOT NULL,
  `type` enum('lecture','laboratory','lecture & laboratory') NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `school_year` int(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`code`, `description`, `unit`, `type`, `status`, `school_year`, `created_at`, `updated_at`) VALUES
('123', 'Description', '4', 'lecture & laboratory', '1', 3, '2023-12-15 12:07:56', '2024-01-07 07:31:48'),
('1234', 'Subject Description', '1', 'lecture & laboratory', '1', 3, '2023-12-15 13:31:24', NULL),
('ITPE130', 'Subject Description', '1', 'lecture & laboratory', '1', 3, '2023-12-28 22:20:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('0','1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `birthday`, `gender`, `email`, `contact_number`, `password`, `role`) VALUES
(27, 'admin', '', '', '2023-10-04', '', 'admin@gmail.com', NULL, '$2y$10$PumhXShcT5uQ3eviJ2eINuYL9z5R8kLszjQmL6jzrVVoTpfogv5Fa', '0'),
(71, 'Rayan', 'Maglicious', 'Celestino', '2000-12-27', 'male', 'rayan@gmail.com', '09123456789', '$2y$10$sKfzOvpyo5CyVb6N.4sVM.cvjmHuS.sj..dgz59mx9rz5jpAE4BVC', '2'),
(72, 'Rubylyn', 'Celistino', 'Lingaolingao', '2003-06-26', 'female', 'rubylyn@gmail.com', '09123456789', '$2y$10$u0pg4Gmh8zeb8hcI2/IoUOvS9g1zLDhETBRvTObiSPxQfb3d4UEqe', '2'),
(76, 'Jonathan', 'Dee', 'David', '2000-12-27', 'male', 'jonathan@gmail.com', '09123456789', '$2y$10$S6TrG1rqBuDfQfF2iy2LK.27HeScfdiTk2g9sbxfLuJlGKyax.GZu', '1'),
(77, 'Mica', 'Dee', 'David', '2000-12-27', 'male', 'mica@gmail.com', '09123456789', '$2y$10$VHHXfT58FdJK3kE1URhP5ehX5MFLIB0REktrDo5M/wiFsKZn6yBDG', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `institute` (`institute`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `faculty_institute` (`institute`),
  ADD KEY `faculty_course` (`course`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD PRIMARY KEY (`faculty_id`,`subject_code`),
  ADD KEY `subject_id` (`subject_code`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `schoolyear`
--
ALTER TABLE `schoolyear`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_institute` (`institute`),
  ADD KEY `student_course` (`course`),
  ADD KEY `students_ibfk_1` (`user_id`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`subject_code`,`student_id`),
  ADD KEY `student_subjects_ibfk_1` (`student_id`),
  ADD KEY `student_subjects_ibfk_3` (`faculty_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`code`),
  ADD KEY `subjects_ibfk_1` (`school_year`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schoolyear`
--
ALTER TABLE `schoolyear`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`institute`) REFERENCES `institute` (`slug`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_course` FOREIGN KEY (`course`) REFERENCES `course` (`slug`),
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `faculty_institute` FOREIGN KEY (`institute`) REFERENCES `institute` (`slug`);

--
-- Constraints for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD CONSTRAINT `faculty_subjects_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `faculty_subjects_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `subjects` (`code`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `student_course` FOREIGN KEY (`course`) REFERENCES `course` (`slug`),
  ADD CONSTRAINT `student_institute` FOREIGN KEY (`institute`) REFERENCES `institute` (`slug`),
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `faculty_subjects` (`subject_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`school_year`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
