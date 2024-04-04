<?php
// Check if the connection to the database is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$posterUploadDirectory = "./Poster/";

// Create the Poster directory if it doesn't exist
if (!is_dir($posterUploadDirectory)) {
    mkdir($posterUploadDirectory, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submissions
    if (isset($_POST["submit"])) {
        // Code for inserting the movie into the database
        $title = isset($_POST["title"]) ? $_POST["title"] : '';
        $genreID = isset($_POST["genre"]) ? $_POST["genre"] : '';
        $director = isset($_POST["director"]) ? $_POST["director"] : '';
        $releaseYear = isset($_POST["release_date"]) ? $_POST["release_date"] : '';
        $description = isset($_POST["description"]) ? $_POST["description"] : '';
        $movieLink = isset($_POST["movie_link"]) ? $_POST["movie_link"] : '';

        $posterFileName = '';

        if (!empty($_FILES["poster"]["name"]) && $_FILES["poster"]["error"] == UPLOAD_ERR_OK) {
            $posterFileName = $posterUploadDirectory . $title . '.' . pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES["poster"]["tmp_name"], $posterFileName)) {
                echo "Poster File Name: $posterFileName<br>";
            } else {
                echo "Error moving poster file.<br>";
            }
        }

        // Insert movie into the database
        $stmt = $conn->prepare("INSERT INTO film (Title, GenreID, Director, Release_Date, Description, PosterFilePath, FileExtension, MovieLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssssss", $title, $genreID, $director, $releaseYear, $description, $posterFileName, pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION), $movieLink);
        $stmt->execute();
        $stmt->close();

        echo "Movie Inserted Successfully<br>";
    }

    if (isset($_POST["update"])) {
        // Code for updating the movie in the database
        $movieID = isset($_POST["movie_id"]) ? $_POST["movie_id"] : '';
        $genreID = isset($_POST["genre_id"]) ? $_POST["genre_id"] : '';
        $title = isset($_POST["title"]) ? $_POST["title"] : '';
        $director = isset($_POST["director"]) ? $_POST["director"] : '';
        $releaseYear = isset($_POST["release_date"]) ? $_POST["release_date"] : '';
        $description = isset($_POST["description"]) ? $_POST["description"] : '';
        $movieLink = isset($_POST["movie_link"]) ? $_POST["movie_link"] : '';

        // Update the movie in the database
        $stmt = $conn->prepare("UPDATE film SET Title=?, GenreID=?, Director=?, Release_Date=?, Description=?, MovieLink=? WHERE FilmID=?");
        $stmt->bind_param("sisssssi", $title, $genreID, $director, $releaseYear, $description, $movieLink, $movieID);
        $stmt->execute();
        $stmt->close();

        echo "Movie Updated Successfully<br>";
    }

    if (isset($_POST["delete"])) {
        // Code for deleting the movie from the database
        $movieID = isset($_POST["movie_id"]) ? $_POST["movie_id"] : '';

        // Fetch poster file path to delete if it exists
        $stmt = $conn->prepare("SELECT PosterFilePath FROM film WHERE FilmID = ?");
        $stmt->bind_param("i", $movieID);
        $stmt->execute();
        $stmt->bind_result($posterFilePath);
        $stmt->fetch();
        $stmt->close();

        // Delete poster file if it exists
        if (!empty($posterFilePath) && file_exists($posterFilePath)) {
            unlink($posterFilePath);
        }

        // Delete movie entry from the database
        $stmt = $conn->prepare("DELETE FROM film WHERE FilmID = ?");
        $stmt->bind_param("i", $movieID);
        $stmt->execute();
        $stmt->close();

        echo "Movie Deleted Successfully<br>";
    }

    if (isset($_POST["update_poster"])) {
        // Code for updating the movie poster
        $movieID = isset($_POST["movie_id"]) ? $_POST["movie_id"] : '';

        $posterFileName = '';

        if (!empty($_FILES["new_poster"]["name"]) && $_FILES["new_poster"]["error"] == UPLOAD_ERR_OK) {
            // Fetch existing poster file path
            $stmt = $conn->prepare("SELECT PosterFilePath FROM film WHERE FilmID = ?");
            $stmt->bind_param("i", $movieID);
            $stmt->execute();
            $stmt->bind_result($existingPosterFilePath);
            $stmt->fetch();
            $stmt->close();

            // Delete existing poster file if it exists
            if (!empty($existingPosterFilePath) && file_exists($existingPosterFilePath)) {
                unlink($existingPosterFilePath);
            }

            // Upload new poster file
            $title = isset($_POST["title"]) ? $_POST["title"] : '';
            $posterFileName = $posterUploadDirectory . $title . '.' . pathinfo($_FILES["new_poster"]["name"], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES["new_poster"]["tmp_name"], $posterFileName)) {
                echo "New Poster File Name: $posterFileName<br>";
            } else {
                echo "Error moving new poster file.<br>";
            }

            // Update the poster file path in the database
            $stmt = $conn->prepare("UPDATE film SET PosterFilePath=?, FileExtension=? WHERE FilmID=?");
            $stmt->bind_param("ssi", $posterFileName, pathinfo($_FILES["new_poster"]["name"], PATHINFO_EXTENSION), $movieID);
            $stmt->execute();
            $stmt->close();

            echo "Poster Updated Successfully<br>";
        }
    }
}
?>