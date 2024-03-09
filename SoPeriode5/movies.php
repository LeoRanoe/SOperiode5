<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVerse</title>
    <link rel="stylesheet" href="./css/home.css">
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
        <section class="search-section">
            <h2>Search Movie</h2>
            <form action="" method="post">
                <input type="search" name="q" placeholder="Search anime..." required>
                <label for="genre">Genre:</label>
                <select id="genre" name="genre">
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
                <button type="submit">Search</button>
            </form>
        </section>

        <section class="movies-section">
            <?php
            include './includes/db_connection.php';

            $genreFilter = isset($_POST['genre']) ? $_POST['genre'] : '';
            $moviesQuery = "SELECT * FROM film";

            if (!empty($genreFilter)) {
                $moviesQuery .= " WHERE Genre = '$genreFilter'";
            }

            $resultMovies = $conn->query($moviesQuery);

            if ($resultMovies->num_rows > 0) {
                while ($row = $resultMovies->fetch_assoc()) {
                    $movieName = $row['Title'];
                    $posterPath = $row['Poster'];

                    echo '<div class="movie-card">';
                    echo '<img src="' . $posterPath . '" alt="' . $movieName . '">';
                    echo '<p>' . $movieName . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No movies found.</p>';
            }

            $conn->close();
            ?>
        </section>
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
