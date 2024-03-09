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
        <div class="logo-section">
            <img src="path-to-your-logo.png" alt="Logo"> 
            <h1>CineVerse</h1>
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="movies.html">Movies</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
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
<?php
include './includes/db_connection.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate and store a unique form submission token
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = md5(uniqid(rand(), true));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["username"]) ? $_POST["username"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $token = isset($_POST["token"]) ? $_POST["token"] : '';

    // Check the uniqueness of the form submission token
    if ($_SESSION['form_token'] !== $token) {
        // Check for user login
        $userQuery = "SELECT * FROM User WHERE Email = ? AND Password = ?";
        $stmtUser = $conn->prepare($userQuery);
        $stmtUser->bind_param("ss", $email, $password);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();

        // Check for admin login
        $adminQuery = "SELECT * FROM Admin WHERE Email = ? AND Password = ?";
        $stmtAdmin = $conn->prepare($adminQuery);
        $stmtAdmin->bind_param("ss", $email, $password);
        $stmtAdmin->execute();
        $resultAdmin = $stmtAdmin->get_result();

        if ($resultUser->num_rows == 1) {
            $_SESSION['user_email'] = $email;
            echo "Login successful for user!";
            // Redirect to a different page after processing the form
            header("Location: user_home.php");
            exit();
        } elseif ($resultAdmin->num_rows == 1) {
            $_SESSION['admin_email'] = $email;
            echo "Login successful for admin!";
            // Redirect to a different page after processing the form
            header("Location: admin_home.php");
            exit();
        } else {
            echo "Invalid credentials. Please try again.";
        }

        // Set a new unique token for the next form submission
        $_SESSION['form_token'] = md5(uniqid(rand(), true));

        // Redirect to a different page after processing the form
        header("Location: login_form.php");
        exit();
    } else {
        echo "Form already submitted.";
    }

    $stmtUser->close();
    $stmtAdmin->close();
}

$conn->close();
?>
