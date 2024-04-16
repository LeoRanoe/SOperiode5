<?php
// Start session and include necessary files
session_start();
include './includes/db_connection.php';
include './includes/search.php';
include './includes/moviepanel_operations.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/MoviePanel.css">
    <link rel="stylesheet" href="./css/comments.css">
    <title><?php echo $movieTitle; ?> - Watch Movie</title>
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
                <?php
                include './includes/Navigation.php';
                ?>
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
<div class="main-container">
<main class="main-content">
        <section class="movie-section">
            <div class="video-section">
                <iframe width="800" height="450" src="<?php echo $embed_url; ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="movie-details-section">
                <div class="movie-info-container">
                    <div class="movie-info">
                        <img src="<?php echo $posterFilePath; ?>" alt="Movie Poster" class="movie-poster">
                        <div class="movie-details">
                            <h2><?php echo $movieTitle; ?></h2>
                            <p><strong>Release Date:</strong> <?php echo $releaseDate; ?></p>
                            <p><strong>Director:</strong> <?php echo $director; ?></p>
                            <p><strong>Description:</strong> <?php echo $description; ?></p>
                            <p><strong>Average Rating:</strong> <?php echo number_format($averageRating, 1); ?></p>
                        </div>
                    </div>
                    <section class="rating-form-section">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?title=<?php echo urlencode($movieTitle); ?>" method="post">
                            <input type="hidden" name="filmID" value="<?php echo $movieID; ?>">
                            <label for="rating">Rate This Movie:</label>
                            <select name="rating" id="rating">
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                            <br>
                            <label for="comment">Comment:</label>
                            <textarea name="comment" id="comment" rows="4" cols="50"></textarea>
                            <br>
                            <button type="submit">Submit</button>
                        </form>
                    </section>
                </div>
            </div>
            <section class="comments-section">
                <h2>Comments</h2>
                <?php if ($commentsResult->num_rows > 0): ?>
                    <div class="comments-container">
                        <?php while ($commentRow = $commentsResult->fetch_assoc()): ?>
                            <div class="comment-item">
                                <p class="comment-rating">Rated by Anonymous User</p>
                                <p><?php echo htmlspecialchars_decode($commentRow['Comment']); ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>No comments available.</p>
                <?php endif; ?>
            </section>
        </section>
    </main>
</div>
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