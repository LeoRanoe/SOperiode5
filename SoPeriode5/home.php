<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include './includes/db_connection.php';
include './includes/Navigation.php';
include './includes/search.php';

// Fetch featured movies from the database
$featuredMoviesQuery = "SELECT f.FilmID, f.Title, f.Director, f.Release_Date, f.Description, f.PosterFilePath, g.Genre
                        FROM film f
                        JOIN genres g ON f.GenreID = g.GenreID
                        ORDER BY f.Release_Date DESC
                        LIMIT 4";
$featuredMoviesResult = mysqli_query($conn, $featuredMoviesQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <title>CineVerse</title>
</head>
<body>
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
                    <?php include './includes/Navigation.php'; ?>
                </ul>
            </nav>
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
    <main class="main-content">
        <section class="hero-section">
            <div class="container">
                <h2>Welcome to CineVerse</h2>
                <p>Your ultimate destination for movie lovers</p>
                <a href="movies.php" class="btn">Explore Movies</a>
            </div>
        </section>
        <section class="featured-movies">
            <h2>Featured Movies</h2>
            <div class="movie-grid">
                <?php while ($movie = mysqli_fetch_assoc($featuredMoviesResult)): ?>
                    <div class="movie-card">
                        <a href="MoviePanel.php?title=<?php echo urlencode($movie['Title']); ?>">
                            <div class="poster-container">
                                <img src="<?php echo $movie['PosterFilePath']; ?>" alt="<?php echo $movie['Title']; ?> Poster">
                            </div>
                        </a>
                        <h3><?php echo $movie['Title']; ?></h3>
                        <p><?php echo $movie['Description']; ?></p>
                        <p>Genre: <?php echo $movie['Genre']; ?></p>
                        <p>Director: <?php echo $movie['Director']; ?></p>
                        <p>Release Year: <?php echo $movie['Release_Date']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
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
</body>
</html>