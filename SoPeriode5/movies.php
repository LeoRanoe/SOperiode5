<?php
// Start session and include necessary files
session_start();
include './includes/db_connection.php'; // Adjust the path as necessary
include './includes/search.php';
include './includes/movies_errorhandeling.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVerse - Movies</title>
    <link rel="stylesheet" href="./css/movies.css">
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
        <!-- Search Form -->
        <form action="movies.php" method="get" class="search-bar">
            <input type="text" name="q" placeholder="Search movies..." required>
            <button type="submit">Search</button>
        </form>
    </div>
</header>
<main class="main-content">
    <section class="filters-section">
        <div class="container">
            <form action="movies.php" method="get" class="filters-form">
                <div class="filters">
                    <?php
                    include './includes/filter_functions.php';
                    ?>
                </div>
            </form>
        </div>
    </section>
    <section class="movies-section">
        <div class="container">
            <div class="row">
                <?php if (!empty($movies)) : ?>
                    <?php foreach ($movies as $movie) : ?>
                        <div class="movie-poster-container">
                            <a href="MoviePanel.php?title=<?php echo urlencode($movie['Title']); ?>">
                                <div class="movie-info">
                                    <img src="<?php echo $movie['PosterFilePath']; ?>" alt="<?php echo $movie['Title']; ?>" class="movie-poster">
                                    <h2><?php echo $movie['Title']; ?></h2>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="no-movies-msg">No movies found.</p>
                <?php endif; ?>
            </div>
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