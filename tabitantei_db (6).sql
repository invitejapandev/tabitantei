-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2022 at 06:58 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabitantei_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ActiveStatus` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `company_name`, `address`, `contact_no`, `contact_person_name`, `details`, `ActiveStatus`, `created_at`, `updated_at`, `email`) VALUES
(1, 'Rakuten', 'Rakuten', 'Rakuten', 'Rakuten Person', 'Rakuten', 1, '2021-10-27 00:42:34', '2021-10-27 16:53:32', 'tokyo@Rakuten.com');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_events`
--

CREATE TABLE `game_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `team_count` int(11) DEFAULT NULL,
  `game_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` tinyint(1) NOT NULL,
  `event_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_events`
--

INSERT INTO `game_events` (`id`, `client_id`, `team_count`, `game_code`, `Status`, `event_date`, `created_at`, `updated_at`) VALUES
(7, 1, 5, 'ASD11', 0, '2022-01-31', NULL, NULL),
(8, 1, 5, 'ASDFG', 1, '2022-01-31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `game_helps`
--

CREATE TABLE `game_helps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_event_id` bigint(20) UNSIGNED NOT NULL,
  `player_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `puzzle_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isDone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_players`
--

CREATE TABLE `game_players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_event_id` bigint(20) UNSIGNED NOT NULL,
  `teamNumber` int(11) DEFAULT NULL,
  `nickName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answeredPuzzle` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `ActiveStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_players`
--

INSERT INTO `game_players` (`id`, `game_event_id`, `teamNumber`, `nickName`, `answeredPuzzle`, `updated_at`, `created_at`, `ActiveStatus`) VALUES
(1, 8, 2, 'Player 1', NULL, '2022-01-28 09:40:49', '2022-01-28 09:40:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `game_progress`
--

CREATE TABLE `game_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_event_id` bigint(20) UNSIGNED NOT NULL,
  `puzzle_progress` int(11) DEFAULT NULL,
  `answered_current` int(11) DEFAULT NULL,
  `time_answered` int(11) DEFAULT NULL,
  `teamNumber` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `player_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_times`
--

CREATE TABLE `game_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `puzzle_number` int(11) DEFAULT NULL,
  `game_time` int(11) DEFAULT NULL,
  `team_number` int(11) NOT NULL,
  `game_event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_times`
--

INSERT INTO `game_times` (`id`, `created_at`, `updated_at`, `puzzle_number`, `game_time`, `team_number`, `game_event_id`) VALUES
(1, '2022-01-28 01:41:15', '2022-01-28 01:41:15', 1, 0, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `map_answers`
--

CREATE TABLE `map_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_event_id` bigint(20) UNSIGNED NOT NULL,
  `player_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `selected_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2021_10_27_013556_create_client_table', 1),
(11, '2021_10_27_022657_add_email_to_client', 2),
(12, '2021_11_01_080355_game_event', 3),
(13, '2021_11_08_065945_game_player', 4),
(15, '2021_11_22_083606_create_game_progress', 5),
(16, '2021_11_24_083136_add_player_number_game_progress', 6),
(17, '2021_11_25_063625_create_game_time', 7),
(18, '2021_11_25_063821_add_column_game_time', 8),
(19, '2021_11_29_110951_create_piano_answer', 9),
(20, '2021_11_30_151401_create_security_matrix', 10),
(21, '2021_11_30_182456_create_team_mission', 11),
(22, '2021_12_09_083248_create_game_help', 12),
(23, '2021_12_10_033542_create_team_miro', 13),
(24, '2022_01_17_143809_create_map_answer', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piano_answers`
--

CREATE TABLE `piano_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_event_id` bigint(20) UNSIGNED NOT NULL,
  `player_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `selected_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_matrices`
--

CREATE TABLE `security_matrices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_number` int(11) DEFAULT NULL,
  `player_matrix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `player_count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `video_matrix` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_matrices`
--

INSERT INTO `security_matrices` (`id`, `player_number`, `player_matrix`, `player_count`, `created_at`, `updated_at`, `video_matrix`) VALUES
(1, 1, 'true, true, true, true, true, true, true, true', 1, NULL, NULL, 'true, true, true, true, true, true, true, true, true, true'),
(2, 1, 'true, false, true, false, true, true, false, false', 2, NULL, NULL, 'false, true, false, true, false, false, false, true, false, true'),
(3, 2, 'false, true, false, true, false, false, true, true', 2, NULL, NULL, 'true, false, true, false, false, true, true, false, false, false'),
(4, 1, 'true, true, false, false, true, false, false, false', 3, NULL, NULL, 'false, false, true, true, false, false, true, true, false, true'),
(5, 2, 'false, false, false, false, false, true, true, true', 3, NULL, NULL, 'true, true, true, false, false, true, false, false, false, false'),
(6, 3, 'false, false, true, true, false, false, false, false', 3, NULL, NULL, 'true, true, false, false, false, true, true, true, false, true'),
(7, 1, 'false, true, true, true, false, false, false, true', 4, NULL, NULL, 'true, false, false, false, true, true, true, true, false, false'),
(8, 2, 'true, true, true, false, true, false, false, false', 4, NULL, NULL, 'false, false, false, true, false, false, true, true, true, true'),
(9, 3, 'false, false, false, false, true, true, true, true', 4, NULL, NULL, 'true, true, true, true, false, false, false, false, true, false'),
(10, 4, 'true, false, false, true, false, true, true, false', 4, NULL, NULL, 'false, true, true, false, true, true, false, false, false, true'),
(11, 1, 'false, true, true, true, false, false, false, true', 5, NULL, NULL, 'true, false, false, false, true, true, false, true, false, false'),
(12, 2, 'true, true, true, false, true, false, false, false', 5, NULL, NULL, 'false, false, false, true, false, false, true, true, false, true'),
(13, 3, 'false, false, false, false, true, true, true, true', 5, NULL, NULL, 'true, true, true, false, false, false, false, false, true, false'),
(14, 4, 'true, false, false, true, false, true, true, false', 5, NULL, NULL, 'false, true, true, false, true, false, false, false, false, true'),
(15, 5, 'true, true, true, false, false, false, true, false', 5, NULL, NULL, 'false, false, false, true, false, true, true, false, false, true');

-- --------------------------------------------------------

--
-- Table structure for table `team_miros`
--

CREATE TABLE `team_miros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `miro_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `puzzle_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_miros`
--

INSERT INTO `team_miros` (`id`, `miro_link`, `team_number`, `puzzle_number`, `created_at`, `updated_at`) VALUES
(1, 'https://miro.com/app/live-embed/uXjVOdwbpWo=/?embedAutoplay=true&moveToViewport=-1023,-507,2046,1009', 1, 1, NULL, NULL),
(2, 'https://miro.com/app/live-embed/uXjVOd3j-dM=/?embedAutoplay=true&moveToViewport=-3017,-1252,5956,2939', 1, 2, NULL, NULL),
(3, 'https://miro.com/app/live-embed/uXjVOd3j_38=/?embedAutoplay=true&moveToViewport=-2408,-1188,4818,2377', 1, 3, NULL, NULL),
(4, 'https://miro.com/app/live-embed/uXjVOd3tLYQ=/?embedAutoplay=true&moveToViewport=-767,-379,1533,756', 1, 4, NULL, NULL),
(5, 'https://miro.com/app/live-embed/uXjVOd3tnxs=/?embedAutoplay=true&moveToViewport=-4369,-2156,8737,4311', 1, 5, NULL, NULL),
(6, 'https://miro.com/app/live-embed/uXjVOd30WKg=/?embedAutoplay=true&moveToViewport=-2172,-1123,4509,2225', 1, 6, NULL, NULL),
(7, 'https://miro.com/app/live-embed/uXjVOd3wBa4=/?embedAutoplay=true&moveToViewport=-2892,-1798,5787,2855', 1, 8, NULL, NULL),
(8, 'https://miro.com/app/live-embed/uXjVOd3zLh8=/?embedAutoplay=true&moveToViewport=-2528,-1319,5024,2479', 1, 9, NULL, NULL),
(9, 'https://miro.com/app/live-embed/uXjVOdwbmrc=/?embedAutoplay=true&moveToViewport=-1023,-507,2046,1009', 2, 1, NULL, NULL),
(10, 'https://miro.com/app/live-embed/uXjVOd3j-fc=/?embedAutoplay=true&moveToViewport=-3017,-1252,5956,2939', 2, 2, NULL, NULL),
(11, 'https://miro.com/app/live-embed/uXjVOd3jhBQ=/?embedAutoplay=true&moveToViewport=-3372,-1663,6746,3329', 2, 3, NULL, NULL),
(12, 'https://miro.com/app/live-embed/uXjVOd3tLaY=/?embedAutoplay=true&moveToViewport=-8317,-4002,16466,8126', 2, 4, NULL, NULL),
(13, 'https://miro.com/app/live-embed/uXjVOd3tnz4=/?embedAutoplay=true&moveToViewport=-5243,-2588,10485,5174', 2, 5, NULL, NULL),
(14, 'https://miro.com/app/live-embed/uXjVOd30WUY=/?embedAutoplay=true&moveToViewport=-3074,-1568,6312,3115', 2, 6, NULL, NULL),
(15, 'https://miro.com/app/live-embed/uXjVOd3w-k8=/?embedAutoplay=true&moveToViewport=-5574,-2751,11146,5500', 2, 8, NULL, NULL),
(16, 'https://miro.com/app/live-embed/uXjVOd3zLjQ=/?embedAutoplay=true&moveToViewport=-2528,-1319,5024,2479', 2, 9, NULL, NULL),
(17, 'https://miro.com/app/live-embed/uXjVOdwYDe8=/?embedAutoplay=true&moveToViewport=-1023,-507,2046,1009', 3, 1, NULL, NULL),
(18, 'https://miro.com/app/live-embed/uXjVOd3j-YI=/?embedAutoplay=true&moveToViewport=-3017,-1252,5956,2939', 3, 2, NULL, NULL),
(19, 'https://miro.com/app/live-embed/uXjVOd3jhDM=/?embedAutoplay=true&moveToViewport=-2408,-1188,4818,2377', 3, 3, NULL, NULL),
(20, 'https://miro.com/app/live-embed/uXjVOd3tIlU=/?embedAutoplay=true&moveToViewport=-8317,-4002,16466,8126', 4, 4, NULL, NULL),
(21, 'https://miro.com/app/live-embed/uXjVOd3tn9U=/?embedAutoplay=true&moveToViewport=-4369,-2156,8737,4311', 3, 5, NULL, NULL),
(22, 'https://miro.com/app/live-embed/uXjVOd30WWg=/?embedAutoplay=true&moveToViewport=-2172,-1123,4509,2225', 3, 6, NULL, NULL),
(23, 'https://miro.com/app/live-embed/uXjVOd3w-mM=/?embedAutoplay=true&moveToViewport=-2892,-1726,5787,2855', 3, 8, NULL, NULL),
(24, 'https://miro.com/app/live-embed/uXjVOd3zLsM=/?embedAutoplay=true&moveToViewport=-2528,-1319,5024,2479', 8, 9, NULL, NULL),
(25, 'https://miro.com/app/live-embed/uXjVOdwYAoQ=/?embedAutoplay=true&moveToViewport=-1023,-507,2046,1009', 4, 1, NULL, NULL),
(26, 'https://miro.com/app/live-embed/uXjVOd3j-ac=/?embedAutoplay=true&moveToViewport=-3017,-1252,5956,2939', 4, 2, NULL, NULL),
(27, 'https://miro.com/app/live-embed/uXjVOd3jhNY=/?embedAutoplay=true&moveToViewport=-2408,-1188,4818,2377', 4, 3, NULL, NULL),
(28, 'https://miro.com/app/live-embed/uXjVOd3tImE=/?embedAutoplay=true&moveToViewport=-8317,-4002,16466,8126', 3, 4, NULL, NULL),
(29, 'https://miro.com/app/live-embed/uXjVOd3tn-U=/?embedAutoplay=true&moveToViewport=-4369,-2156,8737,4311', 4, 5, NULL, NULL),
(30, 'https://miro.com/app/live-embed/uXjVOd30WQI=/?embedAutoplay=true&moveToViewport=-2172,-1123,4509,2225', 4, 6, NULL, NULL),
(31, 'https://miro.com/app/live-embed/uXjVOd3w-g8=/?embedAutoplay=true&moveToViewport=-2892,-1798,5787,2855', 4, 8, NULL, NULL),
(32, 'https://miro.com/app/live-embed/uXjVOd3zLto=/?embedAutoplay=true&moveToViewport=-2528,-1319,5024,2479', 4, 9, NULL, NULL),
(33, 'https://miro.com/app/live-embed/uXjVOdwYAqE=/?embedAutoplay=true&moveToViewport=-1023,-507,2046,1009', 5, 1, NULL, NULL),
(34, 'https://miro.com/app/live-embed/uXjVOd3j_l4=/?embedAutoplay=true&moveToViewport=-3017,-1252,5956,2939', 5, 2, NULL, NULL),
(35, 'https://miro.com/app/live-embed/uXjVOd3jhOM=/?embedAutoplay=true&moveToViewport=-2408,-1188,4818,2377', 5, 3, NULL, NULL),
(36, 'https://miro.com/app/live-embed/uXjVOd3tIok=/?embedAutoplay=true&moveToViewport=-8317,-4002,16466,8126', 5, 4, NULL, NULL),
(37, 'https://miro.com/app/live-embed/uXjVOd3tn_w=/?embedAutoplay=true&moveToViewport=-7340,-3623,14679,7244', 5, 5, NULL, NULL),
(38, 'https://miro.com/app/live-embed/uXjVOd30WRI=/?embedAutoplay=true&moveToViewport=-2172,-1123,4509,2225', 5, 6, NULL, NULL),
(39, 'https://miro.com/app/live-embed/uXjVOd3w-ho=/?embedAutoplay=true&moveToViewport=-2892,-1798,5787,2855', 5, 8, NULL, NULL),
(40, 'https://miro.com/app/live-embed/uXjVOd3wGJs=/?embedAutoplay=true&moveToViewport=-2528,-1319,5024,2479', 5, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_missions`
--

CREATE TABLE `team_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_event_id` bigint(20) UNSIGNED NOT NULL,
  `player_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `puzzle_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_commenced` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_company_name_unique` (`company_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `game_events`
--
ALTER TABLE `game_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_event_client_id_foreign` (`client_id`);

--
-- Indexes for table `game_helps`
--
ALTER TABLE `game_helps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_helps_game_event_id_foreign` (`game_event_id`);

--
-- Indexes for table `game_players`
--
ALTER TABLE `game_players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_player_game_event_id_foreign` (`game_event_id`);

--
-- Indexes for table `game_progress`
--
ALTER TABLE `game_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_progress_game_event_id_foreign` (`game_event_id`);

--
-- Indexes for table `game_times`
--
ALTER TABLE `game_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_answers`
--
ALTER TABLE `map_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `map_answer_game_event_id_foreign` (`game_event_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `piano_answers`
--
ALTER TABLE `piano_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `piano_answer_game_event_id_foreign` (`game_event_id`);

--
-- Indexes for table `security_matrices`
--
ALTER TABLE `security_matrices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_miros`
--
ALTER TABLE `team_miros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_missions`
--
ALTER TABLE `team_missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_mission_game_event_id_foreign` (`game_event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_events`
--
ALTER TABLE `game_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `game_helps`
--
ALTER TABLE `game_helps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_players`
--
ALTER TABLE `game_players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `game_progress`
--
ALTER TABLE `game_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_times`
--
ALTER TABLE `game_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `map_answers`
--
ALTER TABLE `map_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piano_answers`
--
ALTER TABLE `piano_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_matrices`
--
ALTER TABLE `security_matrices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `team_miros`
--
ALTER TABLE `team_miros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `team_missions`
--
ALTER TABLE `team_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game_events`
--
ALTER TABLE `game_events`
  ADD CONSTRAINT `game_event_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_helps`
--
ALTER TABLE `game_helps`
  ADD CONSTRAINT `game_helps_game_event_id_foreign` FOREIGN KEY (`game_event_id`) REFERENCES `game_events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_players`
--
ALTER TABLE `game_players`
  ADD CONSTRAINT `game_player_game_event_id_foreign` FOREIGN KEY (`game_event_id`) REFERENCES `game_events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_progress`
--
ALTER TABLE `game_progress`
  ADD CONSTRAINT `game_progress_game_event_id_foreign` FOREIGN KEY (`game_event_id`) REFERENCES `game_events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `map_answers`
--
ALTER TABLE `map_answers`
  ADD CONSTRAINT `map_answer_game_event_id_foreign` FOREIGN KEY (`game_event_id`) REFERENCES `game_events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `piano_answers`
--
ALTER TABLE `piano_answers`
  ADD CONSTRAINT `piano_answer_game_event_id_foreign` FOREIGN KEY (`game_event_id`) REFERENCES `game_events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_missions`
--
ALTER TABLE `team_missions`
  ADD CONSTRAINT `team_mission_game_event_id_foreign` FOREIGN KEY (`game_event_id`) REFERENCES `game_events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
