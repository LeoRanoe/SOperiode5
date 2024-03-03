-- Create GenreLookup table
CREATE TABLE `GenreLookup`(
    `GenreID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(255) NOT NULL
);

-- Insert some example genres
INSERT INTO `GenreLookup` (`Name`) VALUES
    ('Action'),
    ('Drama'),
    ('Comedy'),
    ('Sci-Fi'),
    ('Fantasy');

-- Create Film table with GenreID as a foreign key
CREATE TABLE `Film`(
    `FilmID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Title` VARCHAR(255) NULL,
    `GenreID` BIGINT UNSIGNED NOT NULL,
    `Director` VARCHAR(255) NOT NULL,
    `Release_Date` YEAR NOT NULL,
    `Description` LONGTEXT NOT NULL,
    `Poster` BIGINT NOT NULL,
    `Rating` DECIMAL(8, 2) NOT NULL,
    FOREIGN KEY (`GenreID`) REFERENCES `GenreLookup`(`GenreID`)
);

CREATE TABLE `Roles`(
    `AdminID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Role` TINYINT(1) NOT NULL,
    FOREIGN KEY (`AdminID`) REFERENCES `Admin`(`AdminID`)
);

CREATE TABLE `Genre`(
    `GenreID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Genres` VARCHAR(255) NOT NULL
);

CREATE TABLE `User`(
    `UserID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Username` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NULL,
    `Password` CHAR(255) NOT NULL
);

CREATE TABLE `User_Rating`(
    `RatingID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FilmID` BIGINT UNSIGNED NOT NULL,
    `UserID` BIGINT UNSIGNED NOT NULL,
    `Rating` DECIMAL(8, 2) NOT NULL,
    `RatingDescription` TEXT NOT NULL,
    `Genre` VARCHAR(255) NOT NULL,
    FOREIGN KEY (`FilmID`) REFERENCES `Film`(`FilmID`),
    FOREIGN KEY (`UserID`) REFERENCES `User`(`UserID`)
);

CREATE TABLE `Admin`(
    `AdminID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FilmID` BIGINT UNSIGNED NOT NULL,
    `User` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NOT NULL,
    `Password` CHAR(255) NOT NULL,
    FOREIGN KEY (`FilmID`) REFERENCES `Film`(`FilmID`)
);

CREATE TABLE `Permissions`(
    `UserID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `UserPermissions` TINYINT(1) NOT NULL,
    FOREIGN KEY (`UserID`) REFERENCES `User`(`UserID`)
);

ALTER TABLE
    `User_Rating` ADD CONSTRAINT `user_rating_filmid_foreign` FOREIGN KEY(`FilmID`) REFERENCES `Film`(`FilmID`);
ALTER TABLE
    `Roles` ADD CONSTRAINT `roles_adminid_foreign` FOREIGN KEY(`AdminID`) REFERENCES `Admin`(`AdminID`);
