-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 01:30 AM
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
(189, 'Dune', 'Denis Villeneuve', '2021', 'Paul Atreides, a brilliant and gifted young man born into a great destiny beyond his understanding, must travel to the most dangerous planet in the universe to ensure the future of his family and his people. As malevolent forces explode into conflict over the planet\'s exclusive supply of the most precious resource in existence—a commodity capable of unlocking humanity\'s greatest potential—only those who can conquer their fear will survive.', './Poster/662055111d8c8_576899c7db56f47fa48dbdab100d9edb.jpg', '', 'https://youtu.be/aSHs224Dge0', 1, 4.50),
(191, 'Dune: Part Two', 'Denis Villeneuve', '2024', 'Follow the mythic journey of Paul Atreides as he unites with Chani and the Fremen while on a path of revenge against the conspirators who destroyed his family. Facing a choice between the love of his life and the fate of the known universe, Paul endeavors to prevent a terrible future only he can foresee.', './Poster/66205678ef390_1b2e7f907e0eabd02ddca00c9a3ca2a4.jpg', '', 'https://youtu.be/xwYNVhFJyYk', 1, 3.50);

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
(23, NULL, 189, 4, 'Omg....Slayyy', '2024-04-17 23:04:41'),
(24, NULL, 189, 5, 'Get it gorlllll.....', '2024-04-17 23:04:58'),
(25, NULL, 191, 3, 'E update werk niet', '2024-04-17 23:09:02'),
(26, NULL, 191, 4, 'ik geef op', '2024-04-17 23:09:15');

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
  MODIFY `FilmID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `GenreID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ratings_comments`
--
ALTER TABLE `ratings_comments`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
