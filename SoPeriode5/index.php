<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>9anime.pe</title>
</head>
<body>
<header>
    <div class="logo-section">
        <img src="path-to-your-logo.png" alt="Logo">
        <h1>CineVerse</h1>
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="movies.php">Movies</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<main>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <div class="title">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="genre">
            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
                <option value="Action">Action</option>
                <option value="Adventure">Adventure</option>
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
        </div>
        <div class="director">
            <label for="director">Director</label>
            <input type="text" id="director" name="director" required>
        </div>
        <div class="description">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="release_date">
            <label for="release_date">Release Date</label>
            <input type="number" id="release_date" name="release_date" min="1900" max="2100" required>
        </div>
        <div class="poster">
            <label for="poster">Poster</label>
            <input type="file" id="poster" name="poster" accept="image/*" required>
        </div>
        <div class="button">
            <label for="movie">Movie</label>
            <input type="file" id="movie" name="movie" accept="video/*" required>
            <button type="submit" name="submit" class="submit">Submit</button>
            <button type="submit" name="Update" class="update">Update</button>
            <button type="submit" name="Delete" class="delete">Delete</button>
        </div>
    </form>

    <div class="movie-list-wrapper">
        <h2>All Movies</h2>
        <div class="movie-list">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Release Date</th>
                        <th>Genre</th>
                        <th>Director</th>
                        <th>Description</th>
                        <th>Poster</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include './includes/db_connection.php';

                    // Display all movies
                    $query = "SELECT f.Title, f.Release_Date, g.Genre, f.Director, f.Description, f.Poster FROM film f
                                JOIN genre g ON f.GenreID = g.GenreID";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['Title']}</td>";
                            echo "<td>{$row['Release_Date']}</td>";
                            echo "<td>{$row['Genre']}</td>";
                            echo "<td>{$row['Director']}</td>";
                            echo "<td>{$row['Description']}</td>";
                            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['Poster']) . "' class='poster' alt='{$row['Title']} Poster'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No movies found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer>
    <div class="footer-content">
        <div class="logo-footer-section">
            <img src="path-to-your-footer-logo.png" alt="Footer Logo">
        </div>
        <div class="social-section">
            <h3>Connect with Us</h3>
            <ul>
                <li><a href="https://www.facebook.com/your-facebook" target="_blank">Facebook</a></li>
                <li><a href="https://twitter.com/your-twitter" target="_blank">Twitter</a></li>
                <li><a href="https://www.instagram.com/your-instagram" target="_blank">Instagram</a></li>
            </ul>
        </div>
        <div class="contact-section">
            <h3>Contact Us</h3>
            <p>Email: lranoesendjojo@gmail.com</p>
            <p>Phone: +597 867-7657</p>
        </div>
    </div>
    <p>&copy;2024 CineVerse. All rights reserved.</p>
</footer>
</body>
</html>
<?php
include './includes/db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST["title"]) ? $_POST["title"] : '';
    $genre = isset($_POST["genre"]) ? $_POST["genre"] : '';
    $director = isset($_POST["director"]) ? $_POST["director"] : '';
    $releaseYear = isset($_POST["release_date"]) ? $_POST["release_date"] : '';
    $description = isset($_POST["description"]) ? $_POST["description"] : '';
    if (isset($_POST["submit"])) {
        // Insert movie
        $genreIDQuery = "SELECT GenreID FROM genre WHERE Genre = ?";
        $stmtGenreID = $conn->prepare($genreIDQuery);
        $stmtGenreID->bind_param("s", $genre);
        $stmtGenreID->execute();
        $resultGenreID = $stmtGenreID->get_result();

        if ($resultGenreID && $resultGenreID->num_rows > 0) {
            $row = $resultGenreID->fetch_assoc();
            $genreID = $row['GenreID'];

            $sqlinsert = "INSERT INTO film (Title, GenreID, Director, Release_Date, Description) VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlinsert);
            $stmtInsert->bind_param("sisss", $title, $genreID, $director, $releaseYear, $description);
            $stmtInsert->execute();
            $stmtInsert->close();
        } else {
            echo "Genre not found in the database.";
        }
        $stmtGenreID->close();
    } elseif (isset($_POST["Update"])) {
        // Update movie
        $sqlupdate = "UPDATE film SET GenreID = (SELECT GenreID FROM genre WHERE Genre = ?), Director = ?, Release_Date = ?, Description = ? WHERE Title = ?";
        $stmtUpdate = $conn->prepare($sqlupdate);
        $stmtUpdate->bind_param("ssiss", $genre, $director, $releaseYear, $description, $title);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    } elseif (isset($_POST["Delete"])) {
        // Delete movie
        $sqldelete = "DELETE FROM film WHERE Title = ?";
        $stmtDelete = $conn->prepare($sqldelete);
        $stmtDelete->bind_param("s", $title);
        $stmtDelete->execute();
        $stmtDelete->close();
    }
}
// Display all movies
$query = "SELECT f.Title, f.Release_Date, g.Genre, f.Director, f.Description, f.Poster FROM film f
            JOIN genre g ON f.GenreID = g.GenreID";
$result = $conn->query($query);

$conn->close();
?>
