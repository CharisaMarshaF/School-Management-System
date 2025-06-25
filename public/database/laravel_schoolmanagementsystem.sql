-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 25, 2025 at 12:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_schoolmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_class_teacher`
--

CREATE TABLE `assign_class_teacher` (
  `id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assign_class_teacher`
--

INSERT INTO `assign_class_teacher` (`id`, `class_id`, `teacher_id`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 4, 17, 0, 1, '2025-06-07', '2025-06-07'),
(2, 4, 19, 0, 1, '2025-06-07', '2025-06-07'),
(5, 5, 20, 0, 1, '2025-06-07', '2025-06-07'),
(7, 6, 52, 0, 1, '2025-06-11', '2025-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint NOT NULL COMMENT '0:active, 1:inactive',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `amount` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`, `amount`) VALUES
(4, 'kelas 1', 0, 0, 1, '2025-04-28 19:53:47', '2025-06-11 11:39:30', 110),
(5, 'kelas 2', 0, 0, 1, '2025-04-28 19:53:55', '2025-06-11 11:39:16', 200),
(6, 'kelas 3', 0, 0, 1, '2025-06-05 14:27:32', '2025-06-11 11:39:23', 300),
(9, 'kelas 4', 0, 0, 1, '2025-06-12 06:58:26', '2025-06-12 06:58:26', 100);

-- --------------------------------------------------------

--
-- Table structure for table `class_subject`
--

CREATE TABLE `class_subject` (
  `id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class_subject`
--

INSERT INTO `class_subject` (`id`, `class_id`, `subject_id`, `created_by`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
(49, 4, 12, 1, 0, 0, '2025-06-11 20:47:32', '2025-06-11 20:47:32'),
(50, 4, 13, 1, 0, 0, '2025-06-11 20:47:32', '2025-06-11 20:47:32'),
(51, 4, 14, 1, 0, 0, '2025-06-11 20:47:32', '2025-06-11 20:47:32'),
(52, 4, 15, 1, 0, 0, '2025-06-11 20:47:32', '2025-06-11 20:47:32'),
(53, 4, 16, 1, 0, 0, '2025-06-11 20:47:32', '2025-06-11 20:47:32'),
(54, 4, 17, 1, 0, 0, '2025-06-11 20:47:32', '2025-06-11 20:47:32'),
(55, 5, 12, 1, 0, 0, '2025-06-11 20:48:00', '2025-06-11 20:48:00'),
(56, 5, 13, 1, 0, 0, '2025-06-11 20:48:00', '2025-06-11 20:48:00'),
(57, 5, 14, 1, 0, 0, '2025-06-11 20:48:00', '2025-06-11 20:48:00'),
(58, 5, 15, 1, 0, 0, '2025-06-11 20:48:00', '2025-06-11 20:48:00'),
(59, 5, 16, 1, 0, 0, '2025-06-11 20:48:00', '2025-06-11 20:48:00'),
(60, 5, 17, 1, 0, 0, '2025-06-11 20:48:00', '2025-06-11 20:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `class_subject_timetable`
--

CREATE TABLE `class_subject_timetable` (
  `id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `week_id` int DEFAULT NULL,
  `start_time` varchar(25) DEFAULT NULL,
  `end_time` varchar(25) DEFAULT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class_subject_timetable`
--

INSERT INTO `class_subject_timetable` (`id`, `class_id`, `subject_id`, `week_id`, `start_time`, `end_time`, `room_number`, `created_at`, `updated_at`) VALUES
(1, 4, 8, 1, '14:01', '15:02', '2', '2025-06-08', '2025-06-08'),
(2, 4, 8, 2, '17:46', '14:50', '3', '2025-06-08', '2025-06-08'),
(3, 4, 8, 3, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(4, 4, 8, 4, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(5, 4, 8, 5, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(6, 4, 8, 6, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(7, 4, 8, 7, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(8, 5, 9, 1, '14:09', '14:09', '09', '2025-06-08', '2025-06-08'),
(9, 5, 9, 2, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(10, 5, 9, 3, '19:07', '14:10', '08', '2025-06-08', '2025-06-08'),
(11, 5, 9, 4, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(12, 5, 9, 5, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(13, 5, 9, 6, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(14, 5, 9, 7, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(15, 5, 10, 1, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(16, 5, 10, 2, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(17, 5, 10, 3, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(18, 5, 10, 4, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(19, 5, 10, 5, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(20, 5, 10, 6, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(21, 5, 10, 7, NULL, NULL, NULL, '2025-06-08', '2025-06-08'),
(22, 4, 12, 1, '07:00', '08:00', '1', '2025-06-11', '2025-06-11'),
(23, 4, 12, 2, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(24, 4, 12, 3, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(25, 4, 12, 4, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(26, 4, 12, 5, '07:00', '08:00', '1', '2025-06-11', '2025-06-11'),
(27, 4, 12, 6, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(28, 4, 12, 7, '07:00', '08:00', '1', '2025-06-11', '2025-06-11'),
(29, 4, 13, 1, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(30, 4, 13, 2, '08:00', '09:00', '1', '2025-06-11', '2025-06-11'),
(31, 4, 13, 3, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(32, 4, 13, 4, '08:00', '09:00', '1', '2025-06-11', '2025-06-11'),
(33, 4, 13, 5, '08:00', '09:00', '1', '2025-06-11', '2025-06-11'),
(34, 4, 13, 6, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(35, 4, 13, 7, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(36, 4, 14, 1, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(37, 4, 14, 2, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(38, 4, 14, 3, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(39, 4, 14, 4, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(40, 4, 14, 5, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(41, 4, 14, 6, '09:00', '10:00', NULL, '2025-06-11', '2025-06-11'),
(42, 4, 14, 7, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(43, 4, 15, 1, '09:00', '11:00', NULL, '2025-06-11', '2025-06-11'),
(44, 4, 15, 2, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(45, 4, 15, 3, '11:00', '13:00', NULL, '2025-06-11', '2025-06-11'),
(46, 4, 15, 4, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(47, 4, 15, 5, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(48, 4, 15, 6, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(49, 4, 15, 7, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(50, 4, 17, 1, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(51, 4, 17, 2, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(52, 4, 17, 3, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(53, 4, 17, 4, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(54, 4, 17, 5, NULL, NULL, NULL, '2025-06-11', '2025-06-11'),
(55, 4, 17, 6, '11:27', '12:22', NULL, '2025-06-11', '2025-06-11'),
(56, 4, 17, 7, NULL, NULL, NULL, '2025-06-11', '2025-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` text,
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `name`, `note`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'TEST 2', 'TES', 1, '2025-06-11', '2025-06-11'),
(6, 'TEST 3', 'TEST', 1, '2025-06-11', NULL),
(7, 'TEST 4', 'TEST', 1, '2025-06-11', NULL),
(8, 'TEST 5', 'TEST', 1, '2025-06-11', NULL),
(9, 'TEST 6', 'TEST', 1, '2025-06-11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule_insert`
--

CREATE TABLE `exam_schedule_insert` (
  `id` int NOT NULL,
  `exam_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `start_time` varchar(25) DEFAULT NULL,
  `end_time` varchar(25) DEFAULT NULL,
  `room_number` varchar(25) DEFAULT NULL,
  `full_marks` varchar(25) DEFAULT NULL,
  `passing_marks` varchar(25) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `exam_schedule_insert`
--

INSERT INTO `exam_schedule_insert` (`id`, `exam_id`, `class_id`, `subject_id`, `exam_date`, `start_time`, `end_time`, `room_number`, `full_marks`, `passing_marks`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 2, 5, 9, '2025-07-04', '02:47', '02:48', '9', '100', '75', NULL, '2025-06-08', '2025-06-09'),
(4, 2, 5, 10, '2025-06-19', '21:36', '21:36', '9', '100', '70', NULL, '2025-06-08', '2025-06-09'),
(5, 2, 5, 11, '2025-06-20', '21:35', '21:36', '9', '100', '79', NULL, '2025-06-09', '2025-06-09'),
(6, 5, 4, 12, '2025-06-13', '07:00', '09:00', '1', '100', '73', NULL, '2025-06-11', '2025-06-11'),
(7, 5, 4, 13, '2025-06-16', '07:00', '09:00', '1', '100', '75', NULL, '2025-06-11', '2025-06-11'),
(8, 5, 4, 14, '2025-06-17', '07:00', '09:00', '1', '100', '70', NULL, '2025-06-11', '2025-06-11'),
(9, 5, 4, 15, '2025-06-18', '07:00', '09:00', '1', '100', '72', NULL, '2025-06-11', '2025-06-11'),
(10, 5, 4, 16, '2025-06-19', '07:00', '09:00', '1', '100', '74', NULL, '2025-06-11', '2025-06-11'),
(11, 5, 4, 17, '2025-06-20', '07:00', '09:00', '1', '100', '70', NULL, '2025-06-11', '2025-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `homework_date` date DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `document_file` varchar(255) DEFAULT NULL,
  `description` text,
  `created_by` int DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`id`, `class_id`, `subject_id`, `homework_date`, `submission_date`, `document_file`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(7, 4, 12, '2025-06-12', '2025-06-14', 'Tessss doangg.docx', 'Kerjakan tugas ini dengan menampilkan data pembayaran siswa (Fees Collection Student) pada halaman parent, menggunakan layout yang sama seperti halaman Student Fees Collection di admin. Pastikan data difilter berdasarkan kelas, nama siswa, dan jenis pembayaran, serta hanya menampilkan siswa yang belum dihapus (is_delete = 0 yoi', 1, '2025-06-11', '2025-06-11'),
(8, 4, 13, '2025-06-12', '2025-06-21', 'Tessss doangg (2) (1).docx', 'kerjakan', 1, '2025-06-12', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `homework_submit`
--

CREATE TABLE `homework_submit` (
  `id` int NOT NULL,
  `homework_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `description` text,
  `document_file` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `homework_submit`
--

INSERT INTO `homework_submit` (`id`, `homework_id`, `student_id`, `description`, `document_file`, `created_at`, `updated_at`) VALUES
(1, 3, 17, 'sudahhh', '1749634942_1749616109_Tessss doangg (3).docx', '2025-06-11', '2025-06-11'),
(2, 7, 37, 'sudahh', 'Tessss doangg (2).docx', '2025-06-11', '2025-06-11'),
(3, 7, 36, 'kkskao', 'Tessss doangg (2).docx', '2025-06-12', '2025-06-12'),
(4, 8, 37, 'sudahh', 'Tessss doangg (4).docx', '2025-06-12', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `marks_grade`
--

CREATE TABLE `marks_grade` (
  `id` int NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `percent_from` int NOT NULL DEFAULT '0',
  `percent_to` int NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `marks_grade`
--

INSERT INTO `marks_grade` (`id`, `name`, `percent_from`, `percent_to`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'A', 90, 100, 1, '2025-06-09', '2025-06-09'),
(2, 'B', 80, 89, 1, '2025-06-09', '2025-06-09'),
(3, 'C', 70, 79, 1, '2025-06-09', '2025-06-09'),
(4, 'D', 60, 69, 1, '2025-06-09', '2025-06-09'),
(5, 'E', 50, 59, 1, '2025-06-09', '2025-06-09'),
(6, 'F', 0, 49, 1, '2025-06-09', '2025-06-09');

-- --------------------------------------------------------

--
-- Table structure for table `marks_register`
--

CREATE TABLE `marks_register` (
  `id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `exam_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `class_work` int NOT NULL DEFAULT '0',
  `home_work` int NOT NULL DEFAULT '0',
  `test_work` int NOT NULL DEFAULT '0',
  `exam` int NOT NULL DEFAULT '0',
  `full_marks` int NOT NULL DEFAULT '0',
  `passing_marks` int NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `marks_register`
--

INSERT INTO `marks_register` (`id`, `student_id`, `exam_id`, `class_id`, `subject_id`, `class_work`, `home_work`, `test_work`, `exam`, `full_marks`, `passing_marks`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 17, 2, 5, 9, 30, 20, 10, 30, 100, 75, 1, '2025-06-09', '2025-06-09'),
(2, 17, 2, 5, 10, 20, 20, 30, 20, 100, 70, 1, '2025-06-09', '2025-06-09'),
(3, 17, 2, 5, 11, 20, 30, 40, 3, 100, 79, 19, '2025-06-09', '2025-06-09'),
(4, 18, 2, 4, 8, 11, 21, 20, 20, 0, 0, 19, '2025-06-09', '2025-06-09'),
(5, 23, 2, 5, 9, 20, 9, 30, 29, 100, 75, 1, '2025-06-09', '2025-06-09'),
(6, 23, 2, 5, 10, 1, 8, 0, 0, 100, 70, 19, '2025-06-09', '2025-06-09'),
(7, 36, 5, 4, 12, 10, 30, 40, 5, 100, 73, 1, '2025-06-11', '2025-06-11'),
(8, 36, 5, 4, 13, 10, 20, 30, 10, 100, 75, 1, '2025-06-12', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `notice_board`
--

CREATE TABLE `notice_board` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `notice_date` date DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `message` text,
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notice_board`
--

INSERT INTO `notice_board` (`id`, `title`, `notice_date`, `publish_date`, `message`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'Puasa Arafah', '2025-06-12', '2025-06-26', 'Yuk, puasa Arofah!  In syaa allah bertepatan dengan Kamis, 5 Juni 2025 = 9 Dzulhijjah 1446 H   💫 Jangan biarkan berlalu tanpa makna, Yuk niatkan dari sekarang untuk berpuasa Arafah, satu hari yang bisa menghapus dosa setahun yang lalu dan setahun yang akan datang', 1, '2025-06-11', '2025-06-11'),
(6, 'Pengumuman', '2025-06-12', '2025-06-14', 'Bismillah: Bp/Ib menyampaikan informasi bahwa besuk pagi hari Senin, 26-05-2025 Sehubungan bersamaan pelaksanaan kegiatan SPMB 2025, maka kegiatan Upacara Bendera tiap hari senin ditiadakan...untuk KBM kelas X dan XI dimulai jam Pertama \r\n\r\nDemikian informasi ini kami sampaikan untuk diteruskan ke para siswa...👍🙏', 1, '2025-06-11', '2025-06-11'),
(7, 'PENGUMUMAN', '2025-06-12', '2025-06-16', 'Pengumuman : Diinformasikan Kpd Seluruh siswa kls X dan XI besuk pagi dimohon untuk membawa Fotocpy KK dan Fotocopy Ijazah SMP untuk kelengkapan data Dapodik dikoordinasikan per kelas dan dikumpulkan di R. Kesiswaan... Bp/Ib Wali Kelas mohon menginformasikan kembali kpd para siswa ampuan... Mtrnwn👍🙏', 1, '2025-06-11', '2025-06-11'),
(8, 'PENGUMUMAN', '2025-06-12', '2025-06-20', 'Bismillah :\r\nYth. Bp/Ib PTK\r\nMenyampaikan Agenda siswa untuk besok,  Jumat pagi, 23 Mei 2025 sbb:\r\n1. Kelas X : Sosialisasi dari BCA terkait pembukaan rekening gratis dg membawa fotocopy KK dan fotocopy KTP salah satu Ortu masing-masing di Aula RPL\r\n2. Kelas XI : Pembinaan oleh Wali Kelas. \r\nKepada Bp/Ib Wali Kelas mohon Informasi ini diteruskan ke para siswa...Terima kasih atas kerjasamanya👍🙏', 1, '2025-06-11', '2025-06-11'),
(9, 'PENGUMUMAN', '2025-06-12', '2025-06-21', 'Bismillah: Bp/Ib yg kami hormati, menyampaikan informasi bahwa pagi hari ini Senin, 19-05-2025 KBM dimulai jam Pertama, untuk kegiatan Upacara Bendera tiap hari senin ditiadakan...Upacara Bendera akan dilaksanakan pada hari Selasa, 20-05-2025 bertepatan dengan Peringatan Hari Kebangkitan Nasional', 1, '2025-06-11', '2025-06-11'),
(10, 'PENGUMUMAN', '2025-06-12', '2025-06-12', 'Kami informasikan bahwa dalam rangka meningkatkan pemahaman siswa terhadap materi pelajaran, kami akan mengadakan kegiatan Ujian Tengah Semester (UTS) yang akan dilaksanakan pada:\r\n\r\n📅 Hari/Tanggal: Senin – Jumat, 17 – 21 Juni 2025\r\n🕗 Waktu: 08.00 – 11.30 WIB\r\n📍 Tempat: Ruang Kelas 5A', 1, '2025-06-12', '2025-06-12'),
(11, 'judull', '2025-06-14', '2025-06-14', 'dsjkdskj dnakjsndakj', 1, '2025-06-12', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `notice_board_message`
--

CREATE TABLE `notice_board_message` (
  `id` int NOT NULL,
  `notice_board_id` int DEFAULT NULL,
  `message_to` int DEFAULT NULL COMMENT 'user type',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notice_board_message`
--

INSERT INTO `notice_board_message` (`id`, `notice_board_id`, `message_to`, `created_at`, `updated_at`) VALUES
(18, 5, 2, '2025-06-11', '2025-06-11'),
(19, 5, 3, '2025-06-11', '2025-06-11'),
(20, 6, 2, '2025-06-11', '2025-06-11'),
(21, 6, 3, '2025-06-11', '2025-06-11'),
(22, 7, 2, '2025-06-11', '2025-06-11'),
(23, 7, 3, '2025-06-11', '2025-06-11'),
(24, 8, 2, '2025-06-11', '2025-06-11'),
(25, 8, 3, '2025-06-11', '2025-06-11'),
(26, 9, 2, '2025-06-11', '2025-06-11'),
(27, 9, 3, '2025-06-11', '2025-06-11'),
(28, 10, 4, '2025-06-12', '2025-06-12'),
(29, 11, 2, '2025-06-12', '2025-06-12'),
(30, 11, 3, '2025-06-12', '2025-06-12'),
(31, 11, 4, '2025-06-12', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `student_add_fees`
--

CREATE TABLE `student_add_fees` (
  `id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `total_amount` int DEFAULT '0',
  `paid_amount` int DEFAULT '0',
  `remaning_amount` int DEFAULT '0',
  `payment_type` varchar(255) DEFAULT NULL,
  `remark` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_add_fees`
--

INSERT INTO `student_add_fees` (`id`, `student_id`, `class_id`, `total_amount`, `paid_amount`, `remaning_amount`, `payment_type`, `remark`, `created_by`, `created_at`, `updated_at`) VALUES
(9, 27, 5, 200, 150, 50, 'Cash', 'ok', 1, '2025-06-11 21:23:49', '2025-06-11 21:23:49'),
(10, 28, 5, 200, 100, 100, 'Cash', NULL, 1, '2025-06-12 02:35:19', '2025-06-12 02:35:19'),
(11, 29, 5, 200, 100, 100, 'Cash', 'sa', 1, '2025-06-12 07:03:51', '2025-06-12 07:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `attendance_type` int DEFAULT NULL COMMENT '1= Present, 2=Late,3=ExcusedAbsence, 4=UnexcusedAbsence',
  `created_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`id`, `class_id`, `attendance_date`, `student_id`, `attendance_type`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 4, '2025-06-11', 36, 2, 19, '2025-06-11', '2025-06-11'),
(5, 4, '2025-06-11', 37, 1, 19, '2025-06-11', '2025-06-11'),
(6, 4, '2025-06-11', 38, 1, 19, '2025-06-11', '2025-06-11'),
(7, 4, '2025-06-11', 39, 1, 19, '2025-06-11', '2025-06-11'),
(8, 4, '2025-06-11', 40, 1, 19, '2025-06-11', '2025-06-11'),
(9, 4, '2025-06-11', 41, 1, 19, '2025-06-11', '2025-06-11'),
(10, 4, '2025-06-11', 42, 1, 19, '2025-06-11', '2025-06-11'),
(11, 4, '2025-06-12', 36, 3, 19, '2025-06-12', '2025-06-12'),
(12, 4, '2025-06-12', 37, 4, 19, '2025-06-12', '2025-06-12'),
(13, 4, '2025-06-12', 38, 1, 19, '2025-06-12', '2025-06-12'),
(14, 4, '2025-06-12', 39, 1, 19, '2025-06-12', '2025-06-12'),
(15, 4, '2025-06-12', 40, 1, 19, '2025-06-12', '2025-06-12'),
(16, 4, '2025-06-12', 41, 1, 19, '2025-06-12', '2025-06-12'),
(17, 4, '2025-06-12', 42, 2, 19, '2025-06-12', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:active ,1:inactive',
  `is_delete` tinyint NOT NULL DEFAULT '0' COMMENT '0:not,1:yes',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `type`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(12, 'Mathematics', 'Theory', 1, 0, 0, '2025-06-11 20:29:49', '2025-06-11 20:29:49'),
(13, 'Science', 'Theory', 1, 0, 0, '2025-06-11 20:29:57', '2025-06-11 20:29:57'),
(14, 'English', 'Theory', 1, 0, 0, '2025-06-11 20:30:07', '2025-06-11 20:30:07'),
(15, 'Bahasa Indonesia', 'Theory', 1, 0, 0, '2025-06-11 20:30:16', '2025-06-11 20:30:16'),
(16, 'Islamic Studies', 'Theory', 1, 0, 0, '2025-06-11 20:30:26', '2025-06-11 20:30:26'),
(17, 'Civics', 'Theory', 1, 0, 0, '2025-06-11 20:30:45', '2025-06-11 20:30:45'),
(18, 'Computer Science', 'Practical', 1, 0, 0, '2025-06-11 20:30:54', '2025-06-11 20:31:02'),
(19, 'Arts', 'Practical', 1, 0, 0, '2025-06-11 20:31:13', '2025-06-11 20:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `user_type` tinyint NOT NULL DEFAULT '3' COMMENT '1: admin,2: teacher,\r\n3: student, 4:parent',
  `is_delete` tinyint NOT NULL COMMENT '0:not deleted, 1:deleted',
  `admission_number` varchar(255) DEFAULT NULL,
  `role_number` varchar(255) DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `height` varchar(10) DEFAULT NULL,
  `weight` varchar(10) DEFAULT NULL,
  `occupation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `marital_status` text,
  `permanent_address` text,
  `qualification` text,
  `work_experience` text,
  `note` text,
  `date_of_joining` date DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:active, 1:inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `parent_id`, `name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `user_type`, `is_delete`, `admission_number`, `role_number`, `class_id`, `gender`, `date_of_birth`, `religion`, `mobile_number`, `admission_date`, `profile_pic`, `blood_group`, `height`, `weight`, `occupation`, `address`, `marital_status`, `permanent_address`, `qualification`, `work_experience`, `note`, `date_of_joining`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin', '', 'admin@gmail.com', NULL, '$2y$12$j3HSl8pZ.xbR2pyRN37zQOQtxRGm.iv5BG1BhAVpGQd9hd72ArRhe', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-19 03:52:16', '2025-04-19 03:52:16'),
(2, NULL, 'Teacher', '', 'teacher@gmail.com', NULL, '$2y$12$j3HSl8pZ.xbR2pyRN37zQOQtxRGm.iv5BG1BhAVpGQd9hd72ArRhe', NULL, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-19 03:52:16', '2025-04-19 03:52:16'),
(3, NULL, 'Student', '', 'student@gmail.com', NULL, '$2y$12$j3HSl8pZ.xbR2pyRN37zQOQtxRGm.iv5BG1BhAVpGQd9hd72ArRhe', 'NvWiHmkAHvWhyu5YhXSbOr0TON1Gz11ElpVQNoNbhQxTw8GokraJJlmVZRK2', 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-19 03:52:16', '2025-06-03 12:33:31'),
(4, NULL, 'Parent', '', 'parent@gmail.com', NULL, '$2y$12$j3HSl8pZ.xbR2pyRN37zQOQtxRGm.iv5BG1BhAVpGQd9hd72ArRhe', NULL, 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-19 03:52:16', '2025-04-19 03:52:16'),
(5, NULL, 'admin1', '', 'admin1@gmail.com', NULL, '$2y$10$eOMjj6H/plRQ7ueFYy5uSOq1zhU9HZtBeltrG.bLdbs8t4vzPVoWW', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-20 06:28:03', '2025-04-20 07:32:31'),
(7, NULL, 'admin2', '', 'admin2@gmail.com', NULL, '$2y$10$QGEpQFUoO9C.xUMN3BAexuJRmZDb6e34YJywbjwo1fMW/PcH8dDHe', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-20 08:26:08', '2025-04-20 08:26:08'),
(8, NULL, 'sasaaaaaa', 'sasa', 'sasa@gmail.com', NULL, '$2y$10$Pe65p4v/Ba5eF5eNOW.o9.zKn8ZBuVZn7QQMVg.UhMPOxCythN6r6', NULL, 3, 1, '2131', '1231', 4, 'Female', '2025-06-13', 'islam', '2121', '2025-06-03', NULL, 'a', '165', '45', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-03 12:33:25', '2025-06-04 10:37:23'),
(9, NULL, 'ki', 'ki', 'ki@gmail.com', NULL, '$2y$10$DkIPcPf7rCaiVU/i1kEia.geCeSwzLKAIP7hI4TXQ4Xtu85Bm.sCO', NULL, 3, 1, '889', '7', 5, 'Female', '2025-02-28', 'islam', '8789', '2025-04-01', NULL, 'c', '165', '43', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-03 12:59:24', '2025-06-04 10:37:19'),
(10, NULL, 'sa', 'sas', 'sasssssasa@gmail.com', NULL, '$2y$10$Y9Xcwo1Su7OEnkli7GOWEekFSsR1wzb/IHicKeQZBZQ3BvdrXYVXq', NULL, 3, 1, '123', '434', 5, 'Female', '2025-02-14', 'islam', '432', '2025-03-12', '1748980813_edit.png', 'o', '165', '45', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-03 13:00:13', '2025-06-05 07:31:23'),
(11, NULL, 'ew', 'ew', 'saa@gmail.com', NULL, '$2y$10$HpbG86XF5Znc00dn5uzUUOeejH9nlcg1sOfriwyAITS2WamyZ.ZoG', NULL, 3, 1, '3', '43', 4, 'Female', '2025-04-04', 'islam', '43', '2025-06-10', '1748982443_WhatsApp Image 2025-06-03 at 19.33.24.jpeg', 'a', '165', '43', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-03 13:27:23', '2025-06-05 07:31:26'),
(12, NULL, 'w', 'sss', 'sassa@gmail.com', NULL, '$2y$10$JMx7FSrKtyaVSYX273y6He/uvBko8mivlxrBt3emq4qW04e/s.Fcm', NULL, 3, 1, '2121', '1121', 4, 'Female', '2025-04-10', 'islam', '212121', '2025-05-06', '1749039321_edit.png', 'A', '165', '43', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-04 05:15:21', '2025-06-05 07:31:29'),
(13, NULL, 'da', 'da', 'dsas@gmail.com', NULL, '$2y$10$E8oVy8nhyxZpyM4cYRHg3OU.ThKFZLBhE1h132wghOe2qs1Wm3cKW', NULL, 4, 1, NULL, NULL, NULL, 'male', NULL, NULL, '32', NULL, '1749066096_edit.png', NULL, NULL, NULL, 'nkjj', 'jj', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-04 12:41:36', '2025-06-04 13:21:51'),
(14, NULL, 'sasaammm', 'dad', 'dass@gmail.com', NULL, '$2y$10$QqJuiPnuNKBgYSjHHZ8LMuqWi7KiUd.p.Fw1OaF8LmBUOhfpv04Ea', NULL, 4, 1, NULL, NULL, NULL, 'Male', NULL, NULL, '231', NULL, '1749068506_delete.png', NULL, NULL, NULL, '121', 'dw', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-04 13:21:46', '2025-06-05 07:30:19'),
(15, NULL, 'ryan', 'andi', 'ryan@gmail.com', NULL, '$2y$10$39pJrYWlz/yDystmjFpWZO0fceqUR.rVhpQPRYGhl7qsgRWPw4mVS', NULL, 4, 0, NULL, NULL, NULL, 'Male', NULL, NULL, '08967285179', NULL, '1749133811_5849fd0a-174f-49f4-883d-1df0da1b44df.jpg', NULL, NULL, NULL, 'swasta', 'karanganyar', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-05 07:30:11', '2025-06-05 07:30:11'),
(16, NULL, 'kiki', 'taka', 'kiki@gmail.com', NULL, '$2y$10$0lpK/92T0PtrqC0mai4TwOvLgGNo0cWtMjQfN4r1eoXXjtlEWQYrK', NULL, 4, 0, NULL, NULL, NULL, 'Male', NULL, NULL, '08971683619', NULL, '1749133867_6f29cd47-d897-49b5-a519-69c3bd0c62a8.jpg', NULL, NULL, NULL, 'swasta', 'solo', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-05 07:31:07', '2025-06-05 07:31:07'),
(17, 16, 'rendyy', 'ady', 'rendy@gmail.com', NULL, '$2y$10$g3TNIeeE8D.2MTwbIWcn6OGWSRcRf/j7uHQ8ml1ym52nl.4xQ4kIe', NULL, 3, 1, '2132', '12', 5, 'Male', '2010-06-05', 'islam', '08312349232', '2025-05-07', '1749134343_3a8b61f8-a72e-44ba-b194-64ce0b1b7360.jpg', 'O', '165', '45', NULL, 'Solo', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-05 07:39:03', '2025-06-11 13:02:59'),
(18, 15, 'toni', 'sa', 'toni@gamil.com', NULL, '$2y$10$3lk7Y2XZVnZAr8AgLYaNreft44rItzd2KCWwsr5Kt/kVSs.WBIHWC', NULL, 3, 1, '1343', '32', 4, 'Male', '2009-07-09', 'islam', '0824203223', '2025-06-03', '1749134476_af573fad-8ba0-4cbc-9159-f409ede644a7.jpg', 'O', '170', '50', NULL, 'karanganyar', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-05 07:41:16', '2025-06-11 13:02:56'),
(19, NULL, 'Teacher', '1', 'teacher1@gmail.com', NULL, '$2y$10$/CuR8bfKojwoOmwcmnog4e6zOyMagnlMtWCJPLsdC4Pt7FvT33mF.', NULL, 2, 0, NULL, NULL, NULL, 'Male', NULL, NULL, '0897436030', NULL, 'ba92c05d-f46d-453f-9afa-8b95bbb115e2.jpg', NULL, NULL, NULL, NULL, 'test', 'Married', 'test', 'test', 'test', 'test', '2025-06-01', 0, '2025-06-06 08:53:21', '2025-06-11 12:40:07'),
(20, NULL, 'Teacher', '2', 'teacher2@gmail.com', NULL, '$2y$10$PiExUo3Tod2LC4eR1LEv1OTQ4FX2kFOunbrGyddVEUa6K7LKfhONa', NULL, 2, 0, NULL, NULL, NULL, 'Female', '2025-06-04', NULL, '0897436030', NULL, '62336652-fd53-496f-a917-f023b801350b.png', NULL, NULL, NULL, NULL, 'test', 'Single', 'test', 'test', 'test', 'test', '2025-06-01', 0, '2025-06-06 09:10:36', '2025-06-11 12:41:47'),
(21, NULL, 's', 'sd', 'dikda@gmail.com', NULL, '$2y$10$TrqyAW45vZxj9VDcMSnx6uBW25OeXuanvPRICQ5at.3sbCJkR1CZe', NULL, 2, 1, NULL, NULL, NULL, 'Male', NULL, NULL, '3092', NULL, NULL, NULL, NULL, NULL, NULL, 's', 'Single', 'sf', 'fs', 'fds', 'fss', NULL, 1, '2025-06-06 09:11:49', '2025-06-06 09:12:42'),
(22, NULL, 'fds', 'afd', 'dadss@gmail.com', NULL, '$2y$10$SOR/0Rdp0/brW0qBbZyBzexznUwTAgR.irnt6kH1ksYg1q4WzE0YK', NULL, 2, 1, NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sf', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-06 09:12:35', '2025-06-06 09:12:39'),
(23, 16, 'alan', 'lala', 'alan@gmail.com', NULL, '$2y$10$p7uQhjoskcj1iTV/2RNN4.iROZcSy9yNrBId852fTdgTQZjihOBhy', NULL, 3, 1, '9281', '8', 5, 'Female', '2025-06-04', 'islam', '08912719312', '2025-02-12', '1749479911_e647926c-b1f4-406f-87ea-481111f16f6c.jpg', 'o', '168', '89', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-09 07:38:31', '2025-06-11 13:02:52'),
(26, NULL, 'dad', 'das', 'ddaas@gmail.com', NULL, '$2y$10$bhzgsW2gCP4.b/z7dF/H5O/KA227GBj.7hWnM/xClB2E4MNqo0c12', NULL, 2, 1, NULL, NULL, NULL, 'Female', '2222-02-11', NULL, '089743603031', NULL, 'c1eb7e92-cb10-4f28-9dc6-cb86acc18dd5.png', NULL, NULL, NULL, NULL, 'fw', 'Married', 'fes', 'test', 'test', 'fwe', '1211-12-12', 0, '2025-06-11 12:42:32', '2025-06-11 12:42:37'),
(27, 15, 'Ahmad', 'Thoha Abdul Aziz', 'ahmad@gmail.com', NULL, '$2y$10$Q9hSKinnemzTEU.qWB6aX.6YwxovTsyVa2NrC12QRYC1CTA7BvX0q', NULL, 3, 0, '1001', '1', 5, 'Male', '2011-01-12', 'islam', '08827912109', '2025-06-02', '1749671546_pngtree-user-icon-png-image_1796659.jpg', 'O', '170', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 12:52:26', '2025-06-11 23:58:05'),
(28, NULL, 'Alnata', 'Wamiyar Pratama', 'alnata@gmail.com', NULL, '$2y$10$zvUXyMjkJbnlV/WHwO7KQeRuXs9CT/Zouze/RvhRY.uCY5WqFiZhW', NULL, 3, 0, '1002', '2', 5, 'Male', '2001-11-11', 'islam', '0898766556', '2222-02-12', '1749671620_pngtree-user-icon-png-image_1796659.jpg', 'O', '165', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 12:53:40', '2025-06-11 12:53:40'),
(29, NULL, 'Aura', 'Angel Febiola', 'aura@gmail.com', NULL, '$2y$10$C8vrykWUJR9p313UzG15BeMX4KWXMBdvmGVm28ETATFZ2QaLvB8lm', NULL, 3, 0, '1003', '3', 5, 'Female', '2222-11-11', 'islam', '08974360121', '2222-02-11', '1749671695_pngtree-user-icon-png-image_1796659.jpg', 'A', '155', '45', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 12:54:55', '2025-06-11 12:54:55'),
(30, NULL, 'Azzahra', 'Gesya Ananda Nurayabyar', 'azzahra@gmail.com', NULL, '$2y$10$hdUASeDA0IArsj3heWkl9.bhzOTToQcY3sxBDvww4JqV5VyMi6lZa', NULL, 3, 0, '1004', '4', 5, 'Female', '2222-02-11', 'islam', '083123249232', '2222-11-11', '1749671780_pngtree-user-icon-png-image_1796659.jpg', 'B', '165', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 12:56:20', '2025-06-11 12:56:20'),
(31, NULL, 'Bayu', 'Ardi Setyawan Putra', 'bayu@gmail.com', NULL, '$2y$10$JRnl/8xdBkZb7CsJqV8nSuSeJpa1pc/oLyylSfN5X0m2MsIFmkpk6', NULL, 3, 0, '1005', '5', 5, 'Male', '2222-12-12', 'islam', '089743323230', '2222-12-12', '1749671855_pngtree-user-icon-png-image_1796659.jpg', 'B', '165', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 12:57:35', '2025-06-11 12:57:35'),
(32, NULL, 'Callista', 'Nova S.F.', 'callista@gmail.com', NULL, '$2y$10$Fk0SAKLOuNc54V6Cb/o.yeXasavCw.6snfSZQonG4jLb53o90/YIS', NULL, 3, 0, '1006', '6', 5, 'Female', '1211-02-11', 'islam', '089743216030', '2222-02-11', '1749671928_pngtree-user-icon-png-image_1796659.jpg', 'O', '155', '43', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 12:58:48', '2025-06-11 12:58:48'),
(33, NULL, 'Caraka', 'Sakti Andaru', 'caraka@gmail.com', NULL, '$2y$10$Q6yWIbj9x8ldsVST2W6mSe2YuKbL1u0I.15E/54FUYMkxBAraP8j6', NULL, 3, 0, '1007', '7', 5, 'Male', '2222-02-11', 'islam', '08311249232', '2222-12-12', '1749672020_pngtree-user-icon-png-image_1796659.jpg', 'O', '175', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:00:20', '2025-06-11 13:00:20'),
(34, NULL, 'Charisa', 'Marsha Faradilla', 'charisa@gmail.com', NULL, '$2y$10$OVJLYxynsVHTwGkNpIZSIOEVhL62CR3p43SKbxaF2LZmwN0bSGd46', NULL, 3, 0, '1008', '8', 6, 'Female', '2222-12-12', 'islam', '08312219232', '2222-12-08', '1749672096_pngtree-user-icon-png-image_1796659.jpg', 'B', '158', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:01:36', '2025-06-11 13:20:49'),
(35, NULL, 'Chiquila', 'Feli Dafnika', 'chiquila@gmail.com', NULL, '$2y$10$InFBeHSLDEs7OJpENznqdOKjUAd6Qj1Vxig4ccvFxsQyltxQaM7by', NULL, 3, 0, '1009', '9', 6, 'Female', '2222-02-11', 'islam', '0897421330', '2311-02-13', '1749672165_pngtree-user-icon-png-image_1796659.jpg', 'A', '155', '43', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:02:45', '2025-06-11 13:21:01'),
(36, 47, 'Davin', 'Wahyu Amanta', 'davin@gmail.com', NULL, '$2y$10$UFIg6QtoSdEwKn1ebq0nue5CBlTCHjCj3hIzrnQUREw8na.H6LRIa', NULL, 3, 0, '1010', '10', 4, 'Male', '2222-02-12', 'islam', '0892326030', '2222-02-11', '1749672277_pngtree-user-icon-png-image_1796659.jpg', 'B', '168', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:04:37', '2025-06-11 14:48:21'),
(37, 47, 'Desi', 'Purwanti', 'desi@gmail.com', NULL, '$2y$10$SC0FaxyhTofCrMj7rKkoquphLsp6kWcrAOazeCTxZSJMLx2lG934a', NULL, 3, 0, '1011', '11', 4, 'Female', '2222-02-11', 'islam', '0897436030', '2222-11-12', '1749672339_pngtree-user-icon-png-image_1796659.jpg', 'A', '155', '43', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:05:39', '2025-06-11 17:36:33'),
(38, NULL, 'Dinaa', 'Aulia Aisyah Zahra', 'dinaa@gmail.com', NULL, '$2y$10$5xsnqmPkHrX4yYuSRbOUm.hSn9Nd5SQAYFZcoNNuvwLEaSEYgJoOy', NULL, 3, 0, '1012', '12', 4, 'Female', '2222-12-12', 'islam', '0821936030', '2222-02-11', '1749672419_pngtree-user-icon-png-image_1796659.jpg', 'B', '168', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:06:59', '2025-06-11 13:10:45'),
(39, NULL, 'Fairuz', 'Mozalykh H', 'fairuz@gmail.com', NULL, '$2y$10$suoLZcDPDhTljkHKCPojluCSdvINCVMbjIG/ptZcw0j5axC.qxWzW', NULL, 3, 0, '1013', '13', 4, 'Female', '2222-11-11', 'islam', '089742130', '2222-02-11', '1749672510_pngtree-user-icon-png-image_1796659.jpg', 'A', '155', '43', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:08:30', '2025-06-11 13:08:30'),
(40, NULL, 'Girindra', 'Wardhana Brahma J', 'girindra@gmail.com', NULL, '$2y$10$36A/LRuzOz3k0XjbbstCIuIqS.JQnVBBTzRn.8XEkLDA1wxIrPBxS', NULL, 3, 0, '1015', '15', 4, 'Male', '2222-02-11', 'islam', '08312349221', '2222-02-11', '1749672712_pngtree-user-icon-png-image_1796659.jpg', 'A', '165', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:11:52', '2025-06-11 13:11:52'),
(41, NULL, 'Kayilla', 'Salsa Emira', 'kayilla@gmail.com', NULL, '$2y$10$SUmtF/dSA5zin5HLEV1TC.EqKQS27QH7woEuKC6Hy50N3Uf0Jm5Ma', NULL, 3, 0, '1016', '16', 4, 'Male', '2222-12-11', 'islam', '0897432130', '2025-06-13', '1749672808_pngtree-user-icon-png-image_1796659.jpg', 'B', '168', '43', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:13:28', '2025-06-11 13:13:28'),
(42, NULL, 'Leanno', 'Athaya Al Jawahiri', 'leanno@gmail.com', NULL, '$2y$10$NTnw0YfUUxuKAlVpdKQaaup/zCrnu6EZpXEyqsZTvMaJRiZIW9XF.', NULL, 3, 0, '1017', '17', 4, 'Male', '2025-06-01', 'islam', '08312312232', '2025-06-06', '1749672929_pngtree-user-icon-png-image_1796659.jpg', 'B', '175', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:15:29', '2025-06-11 13:15:29'),
(43, NULL, 'M Hafizi', 'Arfansyah', 'arfan@gmail.com', NULL, '$2y$10$lG3.3KupyooMF4Or6.6VG.WtOV58vf8nTbeTBMCYyvgzvdAMNkZbW', NULL, 3, 0, '1018', '18', 6, 'Male', '2025-06-09', 'islam', '08974362030', '2025-06-11', '1749673012_pngtree-user-icon-png-image_1796659.jpg', 'B', '165', '45', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:16:52', '2025-06-11 13:21:16'),
(44, NULL, 'Nabil', 'Makarim Almuzaffar', 'nabil@gmail.com', NULL, '$2y$10$DJugGBf9qR2RfDOMURVh6ei9wCg/W55PrqrDLF2YdgOMtsk.gAhOO', NULL, 3, 0, '1019', '19', 6, 'Male', '2025-06-02', 'islam', '08974360302', '2025-06-11', '1749673085_pngtree-user-icon-png-image_1796659.jpg', 'A', '168', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:18:05', '2025-06-11 13:21:25'),
(45, NULL, 'Nashwa', 'Sarita Putri', 'nashwa@gmail.com', NULL, '$2y$10$A68VQ9LCd/vnbZCb/XFtJ.Wf7GZt3j5JTxB/4Ajl9fPEqAPkRwm5m', NULL, 3, 0, '1020', '20', 6, 'Female', '2025-06-01', 'islam', '083123492321', '2025-06-11', '1749673163_pngtree-user-icon-png-image_1796659.jpg', 'B', '160', '50', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:19:23', '2025-06-11 13:21:33'),
(46, NULL, 'Naufal', 'Fatah Herdiantoro', 'naufal@gmail.com', NULL, '$2y$10$QuopLUniGwQmSSpsEF1G5OWvxPpKCM.AVXz8T0uvxXbmXw.MDm0ze', NULL, 3, 0, '1021', '21', 6, 'Male', '2025-06-01', 'islam', '08974360304', '2025-06-11', '1749673224_pngtree-user-icon-png-image_1796659.jpg', 'O', '170', '60', NULL, 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-06-11 13:20:24', '2025-06-11 13:21:40'),
(47, NULL, 'parent', '1', 'parent1@gmail.com', NULL, '$2y$10$CApF9nCAmqH3k2Q6qL7TReTip1DM/o9J/kp9ZIY7ZPguoGKpHFOWq', NULL, 4, 0, NULL, NULL, NULL, 'Male', NULL, NULL, '0897436330', NULL, '1749673367_pngtree-user-icon-png-image_1796659.jpg', NULL, NULL, NULL, 'test', 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-11 13:22:47', '2025-06-11 13:22:47'),
(48, NULL, 'parent', '2', 'parent2@gmail.com', NULL, '$2y$10$gIcxzM/hd/uqq36kXI3qoutZuoPtXmdb3V9fo1oq0s3FoVbnwAk92', NULL, 4, 0, NULL, NULL, NULL, 'Male', NULL, NULL, '0897436032', NULL, '1749673429_pngtree-user-icon-png-image_1796659.jpg', NULL, NULL, NULL, 'test', 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-11 13:23:49', '2025-06-11 13:23:49'),
(49, NULL, 'parent', '3', 'parent3@gmail.com', NULL, '$2y$10$P9aKQRmJ6Od8AG4BMbJEZOMJai8ni8Ma6VhxVKQPn.HpIBO8iNHTi', NULL, 4, 0, NULL, NULL, NULL, 'Male', NULL, NULL, '08974360330', NULL, '1749673540_8dff49985d0d8afa53751d9ba8907aed.jpg', NULL, NULL, NULL, 'test', 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-11 13:25:40', '2025-06-11 13:25:40'),
(50, NULL, 'parent', '5', 'parent5@gmail.com', NULL, '$2y$10$AWxyHlNtnldON0AAzaxQ0O/NpcGYFVIR7ovZD9plIvmUWTmKSqZT6', NULL, 4, 0, NULL, NULL, NULL, 'Female', NULL, NULL, '08974360302', NULL, '1749673585_3135823.png', NULL, NULL, NULL, 'test', 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-11 13:26:25', '2025-06-11 13:26:25'),
(51, NULL, 'parent', '4', 'parent4@gmail.com', NULL, '$2y$10$baSHI1ZaqEbHc8AFdtqkBOHz.6fxpJuFyrlGZJOYe.zyssrL.BXXS', NULL, 4, 0, NULL, NULL, NULL, 'Female', NULL, NULL, '08974360302', NULL, '1749673638_3135823.png', NULL, NULL, NULL, 'test', 'KRA', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-11 13:27:18', '2025-06-11 13:27:18'),
(52, NULL, 'Teacher', '3', 'teacher3@gmail.com', NULL, '$2y$10$v7fcZZ6AQxh.vfpjt3.VtefVOekR6parfd9EhCOtWnGl8ikE9l3gu', NULL, 2, 0, NULL, NULL, NULL, 'Male', '1222-02-11', NULL, '08974360302', NULL, '275b875d-32c8-4a9a-b8e8-f7d008c203d1.jpg', NULL, NULL, NULL, NULL, 'KRA', 'Married', 'KRA', 'TES', 'test', 'TES', '2222-02-22', 0, '2025-06-11 13:40:27', '2025-06-11 13:41:38'),
(53, NULL, 'Teacher', '4', 'teacher4@gmail.com', NULL, '$2y$10$jVgfE1dv3VcOpj7loZ/fcutv3eDSsmcOxMF9yrw2..u8lOsmPM/bO', NULL, 2, 0, NULL, NULL, NULL, 'Male', '2025-06-10', NULL, '08974360302', NULL, '83ed24f3-0328-44db-80da-2a0839a59425.jpg', NULL, NULL, NULL, NULL, 'KRA', 'Married', 'KRA', 'test', 'test', 'TES', '2025-06-02', 0, '2025-06-11 13:42:50', '2025-06-11 13:42:50'),
(54, NULL, 'JK', 'N', 'naSbil@gmail.com', NULL, '$2y$10$Nj39QAAOzOCrLfB7h11vr.s4MoxOyJhcCSCSHjwV7osS2FnhMGz26', NULL, 2, 1, NULL, NULL, NULL, 'Female', '1222-02-11', NULL, '2112121', NULL, '76fe39a0-8a54-4807-b977-7b39652f3e81.jpg', NULL, NULL, NULL, NULL, '1', 'Married', '21', '21', 'test', '1', '1211-01-12', 0, '2025-06-11 13:43:51', '2025-06-11 13:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE `week` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `week`
--

INSERT INTO `week` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Monday', NULL, NULL),
(2, 'Tuesday', NULL, NULL),
(3, 'Wednesday', NULL, NULL),
(4, 'Thursday', NULL, NULL),
(5, 'Friday', NULL, NULL),
(6, 'Saturday', NULL, NULL),
(7, 'Sunday', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_class_teacher`
--
ALTER TABLE `assign_class_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_subject`
--
ALTER TABLE `class_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_subject_timetable`
--
ALTER TABLE `class_subject_timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_schedule_insert`
--
ALTER TABLE `exam_schedule_insert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework_submit`
--
ALTER TABLE `homework_submit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks_grade`
--
ALTER TABLE `marks_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks_register`
--
ALTER TABLE `marks_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_board`
--
ALTER TABLE `notice_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_board_message`
--
ALTER TABLE `notice_board_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_add_fees`
--
ALTER TABLE `student_add_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `week`
--
ALTER TABLE `week`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_class_teacher`
--
ALTER TABLE `assign_class_teacher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `class_subject`
--
ALTER TABLE `class_subject`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `class_subject_timetable`
--
ALTER TABLE `class_subject_timetable`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exam_schedule_insert`
--
ALTER TABLE `exam_schedule_insert`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `homework_submit`
--
ALTER TABLE `homework_submit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marks_grade`
--
ALTER TABLE `marks_grade`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `marks_register`
--
ALTER TABLE `marks_register`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notice_board`
--
ALTER TABLE `notice_board`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notice_board_message`
--
ALTER TABLE `notice_board_message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `student_add_fees`
--
ALTER TABLE `student_add_fees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `week`
--
ALTER TABLE `week`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
