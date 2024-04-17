<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once './includes/db_connection.php';
$posterUploadDirectory = "./Poster/";
if (!is_dir($posterUploadDirectory)) {
    mkdir($posterUploadDirectory, 0755, true);
}

function uploadPoster($title, $posterFile) {
    global $posterUploadDirectory;
    if ($posterFile['error'] !== UPLOAD_ERR_OK) {
        return '';
    }
    $posterFileName = uniqid() . '_' . basename($posterFile['name']);
    $posterFilePath = $posterUploadDirectory . $posterFileName;
    if (move_uploaded_file($posterFile['tmp_name'], $posterFilePath)) {
        return $posterFilePath;
    } else {
        return '';
    }
}
function deletePoster($posterFilePath) {
    if (!empty($posterFilePath) && file_exists($posterFilePath)) {
        unlink($posterFilePath);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : '';
    if ($action === "submit") {
        $title = $_POST["title"];
        $genreID = $_POST["genre_id"];
        $director = $_POST["director"];
        $releaseYear = $_POST["release_date"];
        $description = $_POST["description"];
        $movieLink = isset($_POST["movie_link"]) ? $_POST["movie_link"] : '';
        $posterFilePath = uploadPoster($title, $_FILES["poster"]);

        $stmt = $conn->prepare("INSERT INTO film (Title, GenreID, Director, Release_Date, Description, PosterFilePath, MovieLink) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssss", $title, $genreID, $director, $releaseYear, $description, $posterFilePath, $movieLink);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === "update") {
        $movieID = $_POST["movie_id"];
        $title = $_POST["title"];
        $genreID = $_POST["genre_id"];
        $director = $_POST["director"];
        $releaseYear = $_POST["release_date"];
        $description = $_POST["description"];
        $movieLink = isset($_POST["movie_link"]) ? $_POST["movie_link"] : '';

        // Handle the poster file
        $newPosterFile = $_FILES["poster"];
        if (!empty($newPosterFile["name"])) {
            // Upload the new poster file
            $posterFilePath = uploadPoster($title, $newPosterFile);
        } else {
            // Keep the existing poster file
            $stmt = $conn->prepare("SELECT PosterFilePath FROM film WHERE FilmID = ?");
            $stmt->bind_param("i", $movieID);
            $stmt->execute();
            $stmt->bind_result($posterFilePath);
            $stmt->fetch();
            $stmt->close();
        }

        // Update the movie record
        $stmt = $conn->prepare("UPDATE film SET Title = ?, GenreID = ?, Director = ?, Release_Date = ?, Description = ?, PosterFilePath = ?, MovieLink = ? WHERE FilmID = ?");
        $params = array($title, $genreID, $director, $releaseYear, $description, $posterFilePath, $movieLink, $movieID);
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $movieID = $_GET["movie_id"];
    $stmt = $conn->prepare("SELECT PosterFilePath FROM film WHERE FilmID = ?");
    $stmt->bind_param("i", $movieID);
    $stmt->execute();
    $stmt->bind_result($posterFilePath);
    $stmt->fetch();
    $stmt->close();

    deletePoster($posterFilePath);

    $stmt = $conn->prepare("DELETE FROM film WHERE FilmID = ?");
    $stmt->bind_param("i", $movieID);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css">
    <title>CineVerse</title>
</head>
<header>
        <div class="container">
            <div class="logo-section">
                <img src="./img/picture.jpg" alt="Logo">
                <h1>CineVerse</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="movies.php">Movies</a></li>
                    <?php
                    include './includes/Navigation.php';
                    ?>
                </ul>
            </nav>
            <!-- Search Form -->
            <div class="search-container">
                <form action="movies.php" method="get">
                    <div class="search-bar">
                        <input type="text" name="q" placeholder="Search movies..." required>
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </header>
<body>
<main>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="submit">
        <div class="title">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="genre">
            <label for="genre">Genre</label>
            <select id="genre" name="genre_id">
                <?php
                // Fetch all genres from the database
                $genreQuery = "SELECT Genre, GenreID FROM genres";
                $genreResult = $conn->query($genreQuery);

                if ($genreResult && $genreResult->num_rows > 0) {
                    while ($row = $genreResult->fetch_assoc()) {
                        echo "<option value='{$row['GenreID']}'>{$row['Genre']}</option>";
                    }
                }
                ?>
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
            <input type="file" id="poster" name="poster" accept="image/jpeg, image/png" />
        </div>
        <div class="movie">
            <label for="movie">Movie Link</label>
            <input type="text" id="movie_link" name="movie_link" required>
        </div>
        <div class="button">
            <button type="submit" name="submit" class="submit">Submit</button>
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
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $query = "SELECT f.FilmID, f.Title, f.Release_Date, g.Genre, f.Director, f.Description, f.PosterFilePath, f.MovieLink, f.GenreID
                    FROM film f
                    JOIN genres g ON f.GenreID = g.GenreID
                    ORDER BY f.FilmID DESC";
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<form action='admin.php' method='POST' enctype='multipart/form-data'>";
                            echo "<input type='hidden' name='action' value='update'>";
                            echo "<input type='hidden' name='movie_id' value='{$row['FilmID']}'>";
                            echo "<td><input type='text' name='title' value='{$row['Title']}' required></td>";
                            echo "<td><input type='number' name='release_date' value='{$row['Release_Date']}' min='1900' max='2100' required></td>";
                            echo "<td>
                                    <select name='genre_id'>";
                            // Fetch all genres from the database
                            $genreQuery = "SELECT Genre, GenreID FROM genres";
                            $genreResult = $conn->query($genreQuery);

                            if ($genreResult && $genreResult->num_rows > 0) {
                                while ($genreRow = $genreResult->fetch_assoc()) {
                                    $selected = ($genreRow['GenreID'] == $row['GenreID']) ? 'selected' : '';
                                    echo "<option value='{$genreRow['GenreID']}' $selected>{$genreRow['Genre']}</option>";
                                }
                            }
                            echo "</select>
                                  </td>";
                            echo "<td><input type='text' name='director' value='{$row['Director']}' required></td>";
                            echo "<td><textarea name='description' rows='4' required>{$row['Description']}</textarea></td>";
                            echo "<td>";
                            if (isset($row['PosterFilePath']) && !empty($row['PosterFilePath'])) {
                                echo "<label for='poster-{$row['FilmID']}'>
                                        <img src='{$row['PosterFilePath']}' class='poster' alt='{$row['Title']} Poster'>
                                      </label>
                                      <input type='file' id='poster-{$row['FilmID']}' name='poster' accept='image/jpeg, image/png' style='display:none;'>
                                      <script>
                                        document.getElementById('poster-{$row['FilmID']}').addEventListener('change', function() {
                                            this.form.submit();
                                        });
                                      </script>";
                            } else {
                                echo "No Poster Available";
                            }
                            echo "</td>";
                            echo "<td>
                                    <button type='submit' name='action' value='submit' class='update-button'>Update</button>
                                    <a href='admin.php?action=delete&movie_id={$row['FilmID']}' onclick='return confirmDelete(\"{$row['Title']}\")' class='delete-button'>Delete</a>
                                  </td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No movies found</td></tr>";
                    }
                    ?>
                </tbody>
                </tbody>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer>
            <div class="footer-content">
                <div class="logo-footer-section">
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
        <script>
    function confirmDelete(title) {
        return confirm("Are you sure you want to delete the movie: " + title + "?");
    }
</script>
</body>
</html>