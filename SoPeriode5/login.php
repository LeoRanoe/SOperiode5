<?php
session_start();
include './includes/db_connection.php';
include './includes/search.php';
include './includes/login_functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - 9anime.pe</title>
    <link rel="stylesheet" href="./css/login.css">
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
    <main>
        <section class="login-section">
            <h2>Login</h2>
            <form action="" method="post">
                <div class="username">
                <label for="username">Email:</label>
                <input type="text" id="username" name="username" required>
                </div>
                <div class="password">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
            <?php echo '<p style="color: red;">' . $warningMessage . '</p>'; ?>
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