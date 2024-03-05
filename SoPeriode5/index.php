<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>IDK</title>
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
        <button type="submit" name="submit" class="submit">Submit</button>
        <button type="submit" name="Update" class="update">Update</button>
        <button type="submit" name="Delete" class="Delete">Delete</button>
    </form>
</body>
</html>
<?php
include './includes/db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST["title"]) ? $_POST["title"] : '';
    $genre = isset($_POST["genre"]) ? $_POST["genre"] : '';
    $director = isset($_POST["director"]) ? $_POST["director"] : '';
    $releaseYear = isset($_POST["release_date"]) ? $_POST["release_date"] : '';
    if (isset($_POST["submit"])) {
        // Insert movie
        $genreIDQuery = "SELECT GenreID FROM genre WHERE Genre = ?";
        $stmtGenreID = $conn->prepare($genreIDQuery);
        $stmtGenreID->bind_param("s", $genre);
        $stmtGenreID->execute();
        $resultGenreID = $stmtGenreID->get_result();
        if ($resultGenreID->num_rows > 0) {
            $row = $resultGenreID->fetch_assoc();
            $genreID = $row['GenreID'];
            $sqlinsert = "INSERT INTO film (Title, GenreID, Director, Release_Date) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlinsert);
            $stmtInsert->bind_param("siss", $title, $genreID, $director, $releaseYear);

            if ($stmtInsert->execute()) {
                echo "Nieuwe film toegevoegd!";
            } else {
                echo "Error: " . $sqlinsert . "<br>" . $stmtInsert->error;
            }
        }
        $stmtGenreID->close();
    } elseif (isset($_POST["Update"])) {
        // Update movie
        $sqlupdate = "UPDATE film SET GenreID = (SELECT GenreID FROM genre WHERE Genre = ?), Director = ?, Release_Date = ? WHERE Title = ?";
        $stmtUpdate = $conn->prepare($sqlupdate);
        $stmtUpdate->bind_param("ssss", $genre, $director, $releaseYear, $title);
        if ($stmtUpdate->execute()) {
            echo "Film bijgewerkt!";
        } else {
            echo "Fout bij het bijwerken van de film: " . $stmtUpdate->error;
        }
        $stmtUpdate->close();
    } elseif (isset($_POST["Delete"])) {
        // Delete movie
        $sqldelete = "DELETE FROM film WHERE Title = ?";
        $stmtDelete = $conn->prepare($sqldelete);
        $stmtDelete->bind_param("s", $title);
        
        if ($stmtDelete->execute()) {
            // Success message centered with the table
            echo "<div class='delete-message success'>Film Verwijderd!</div>";
        } else {
            // Error message centered with the table
            echo "<div class='delete-message error'>Fout bij het verwijderen van de film: " . $stmtDelete->error . "</div>";
        }
        $stmtDelete->close();
    }

    // Display all movies
    $query = "SELECT f.Title, f.Release_Date, g.Genre, f.Director FROM film f
              JOIN genre g ON f.GenreID = g.GenreID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<div class='movie-list-wrapper'>";
        echo "<h2>All Movies</h2>";
        echo "<div class='movie-list'>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Release Date</th>";
        echo "<th>Genre</th>";
        echo "<th>Director</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Title']}</td>";
            echo "<td>{$row['Release_Date']}</td>";
            echo "<td>{$row['Genre']}</td>";
            echo "<td>{$row['Director']}</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    }
}

$conn->close();
?>