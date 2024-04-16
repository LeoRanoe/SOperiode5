<?php
session_start();

// Check if the user is logged in
$loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'];
$userID = $loggedIn ? $_SESSION['userID'] : null;

// Get the username from the database or set a default value
$username = $loggedIn ? getUsernameFromDatabase($userID) : 'Guest';

// Helper function to get the username from the database
function getUsernameFromDatabase($userId) {
    include './includes/db_connection.php'; // Include your database connection file

    // Replace this with your database query to fetch the username based on the user ID
    $query = "SELECT Username FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Username'];
    } else {
        return 'Guest';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
</head>
<body>
    <header>
    <div class="container">
        <div class="logo-section">
            <img src="./img/picture.jpg" alt="Logo">
            <link rel="stylesheet" href="./css/UserPanel.css">
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
    <main>
        <h2>User Panel</h2>
        <h1>Welcome, <?php echo $username; ?></h1>
        <p>This is your personal user panel. Here, you can access various features and functionalities.</p>
        <h3>Here's a Rickroll for you!</h3>
        <div class="video-container">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
</body>
</html>