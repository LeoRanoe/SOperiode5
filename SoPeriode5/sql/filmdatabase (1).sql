-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 04:33 PM
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
-- Database: `filmdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` bigint(20) UNSIGNED NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `Email`, `Password`) VALUES
(2, 'Admin', 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `FilmID` bigint(20) UNSIGNED NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Director` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Release_Date` year(4) NOT NULL,
  `Description` longtext NOT NULL,
  `PosterFilePath` varchar(255) NOT NULL,
  `FileExtension` varchar(20) NOT NULL,
  `MovieLink` varchar(255) NOT NULL,
  `GenreID` bigint(20) UNSIGNED NOT NULL,
  `AverageRating` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`FilmID`, `Title`, `Director`, `Release_Date`, `Description`, `PosterFilePath`, `FileExtension`, `MovieLink`, `GenreID`, `AverageRating`) VALUES
(183, 'Debitis omnis conseq', 'Est aliqua Adipisci', '2058', 'Odit dolores debitis', './Poster/660d2631f068f_Spider-Man-_Across_the_Spider-Verse_poster.jpg', '', 'Anim ut unde officia', 11, 3.33),
(184, 'Consectetur occaeca', 'Elit vel quaerat do', '2004', 'Consequat Modi porr', './Poster/660d26440f267_images.jpeg', '', 'Ad aut rerum consequ', 5, 2.00),
(185, 'Consectetur occaeca', 'Elit vel quaerat do', '2004', 'Consequat Modi', '', '', '', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `GenreID` bigint(20) UNSIGNED NOT NULL,
  `Genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`GenreID`, `Genre`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Comedy'),
(4, 'Drama'),
(5, 'Horror'),
(6, 'Sci-Fi'),
(7, 'Fantasy'),
(8, 'Mystery'),
(9, 'Thriller'),
(10, 'Crime'),
(11, 'Romance'),
(12, 'Animation'),
(13, 'Family'),
(14, 'Documentary'),
(15, 'War'),
(16, 'Western'),
(17, 'Musical'),
(18, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `PermissionID` bigint(20) UNSIGNED NOT NULL,
  `UserPermissions` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings_comments`
--

CREATE TABLE `ratings_comments` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `UserID` bigint(20) UNSIGNED DEFAULT NULL,
  `FilmID` bigint(20) UNSIGNED NOT NULL,
  `Rating` tinyint(1) NOT NULL,
  `Comment` text DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings_comments`
--

INSERT INTO `ratings_comments` (`ID`, `UserID`, `FilmID`, `Rating`, `Comment`, `Timestamp`) VALUES
(6, NULL, 184, 5, 'This movie is fire\r\n', '2024-04-03 10:24:37'),
(7, NULL, 184, 2, 'Bussing', '2024-04-03 10:24:49'),
(8, NULL, 184, 5, 'Noordwijk heeft gyat', '2024-04-03 10:55:20'),
(9, NULL, 184, 1, 'sass', '2024-04-03 10:56:21'),
(10, NULL, 184, 1, 'qqwq', '2024-04-03 10:57:54'),
(11, NULL, 184, 1, 'asasas', '2024-04-03 10:58:46'),
(12, NULL, 184, 1, 'rrtetet', '2024-04-03 10:58:51'),
(13, NULL, 184, 1, 'hsas', '2024-04-03 11:03:35'),
(14, NULL, 184, 1, 'dsd', '2024-04-03 11:15:48'),
(15, NULL, 183, 1, 'Ahhhhhh Noordwijk heeft gyattt\r\n', '2024-04-03 14:04:41'),
(16, NULL, 183, 5, 'Gyat', '2024-04-03 14:51:15'),
(17, NULL, 183, 4, '', '2024-04-03 14:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` bigint(20) UNSIGNED NOT NULL,
  `RoleName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`, `Description`) VALUES
(1, 'admin', 'Administrative role with full access'),
(2, 'user', 'Standard user role with basic access');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `PermissionID` bigint(20) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `PermissionID`, `Username`, `Email`, `Password`) VALUES
(2, 0, 'leonardo', 'lranoesendjojo@gmail.com', 'leonardo2006'),
(5, 0, 'jackinoff@gmail.com', 'jackinoff@gmail.com', 'nut'),
(6, 0, 'sahikljasnn1@gmail.com', 'sahikljasnn1@gmail.com', '12345678'),
(7, 0, 'leonardoranoesendjojo@gmail.com', 'leonardoranoesendjojo@gmail.com', '1234567');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`FilmID`),
  ADD KEY `FK_film_genre` (`GenreID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`GenreID`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`PermissionID`);

--
-- Indexes for table `ratings_comments`
--
ALTER TABLE `ratings_comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `FilmID` (`FilmID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `FilmID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `GenreID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `PermissionID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings_comments`
--
ALTER TABLE `ratings_comments`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `FK_film_genre` FOREIGN KEY (`GenreID`) REFERENCES `genres` (`GenreID`) ON DELETE CASCADE;

--
-- Constraints for table `ratings_comments`
--
ALTER TABLE `ratings_comments`
  ADD CONSTRAINT `ratings_comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_comments_ibfk_2` FOREIGN KEY (`FilmID`) REFERENCES `film` (`FilmID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
