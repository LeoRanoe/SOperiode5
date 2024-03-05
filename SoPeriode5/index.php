<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <label>Title</label>
        <input type="text" name="title">
        <label>Genre</label>
        <select name="genre" required>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Horror">Horror</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Fanatasy">Fantasy</option>
            <option value="Mystery">Mystery</option>
            <option value="Thriller">Thriller</option>
            <option value="Crime">Crime</option>
            <option value="Romance">Romance</option>
            <option value="Animation">Animation</option>
            <option value="Family">Family</option>
            <option value="Documentary">Documentary</option>
            <option value="War">War</option>
            <option value="Western">Western</option>
            <option value="Musical">Musical</option>
            <option value="Other">Other</option>
        </select>
        <label>Director</label>
        <input type="text" name="director">
        <label>Release Date</label>
        <input type="number" name="release_date" min="1900" max="2100">
        <button type="submit" name="submit">Submit</button>
        <button type="submit" name="Update">Update</button>
        <button type="submit" name="Delete">Delete</button>
    </form>
</body>
</html>
<?php
    include './includes/db_connection.php';

    function displayAllMovies() {
        global $conn;
        $query = "SELECT * FROM film";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<h2>All Movies</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['Title']} ({$row['Release_Date']}) - {$row['Genre']} - {$row['Director']}</li>";
            }
            echo "</ul>";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = isset($_POST["title"]) ? $_POST["title"] : '';
        $genre = isset($_POST["genre"]) ? $_POST["genre"] : '';
        $director = isset($_POST["director"]) ? $_POST["director"] : '';
        $releaseYear = isset($_POST["release_date"]) ? $_POST["release_date"] : '';

        if (isset($_POST["submit"])) {
            $sqlinsert = "INSERT INTO film (Title, Genre, Director, Release_Date) VALUES ('$title', '$genre', '$director', '$releaseYear')";

            if ($conn->query($sqlinsert) === TRUE) {
                echo "Nieuwe film toegevoegd!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif (isset($_POST["Update"])) {
            $Sqlupdate = "UPDATE film SET Genre = '$genre', Director = '$director', Release_Date = '$releaseYear' WHERE Title = '$title'";

            if ($conn->query($Sqlupdate) === TRUE) {
                echo "Film bijgewerkt!";
            } else {
                echo "Fout bij het bijwerken van de film: " . $conn->error;
            }
        } elseif (isset($_POST["Delete"])) {
            $SQLdelete = "DELETE FROM film WHERE Title = '$title'";

            if ($conn->query($SQLdelete) === TRUE) {
                echo "Film Verwijderd!";
            } else {
                echo "Fout bij het verwijderen van de film: " . $conn->error;
            }
        }

        // Display all movies after performing actions
        displayAllMovies();
    } else {
        // Display all movies on initial load
        displayAllMovies();
    }

    $conn->close();
?>
