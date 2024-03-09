<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CineVerse</title>
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
                <li><a href="movies.php">Movies</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="register-section">
            <h2>Register</h2>
            <form action="" method="post">
                <div class="username">
                    <label for="username">Email:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="password">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required required maxlength="20">
                </div>
                <div class="confirm-password">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required required maxlength="20">
                </div>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["username"]) ? $_POST["username"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $confirmPassword = isset($_POST["confirm-password"]) ? $_POST["confirm-password"] : '';

    // Check if passwords match
    if ($password != $confirmPassword) {
        echo "Passwords do not match. Please try again.";
    } else {
        // Check if the email is already registered
        $checkEmailQuery = "SELECT * FROM User WHERE Email = ?";
        $stmtCheckEmail = $conn->prepare($checkEmailQuery);
        $stmtCheckEmail->bind_param("s", $email);
        $stmtCheckEmail->execute();
        $resultCheckEmail = $stmtCheckEmail->get_result();

        if ($resultCheckEmail->num_rows > 0) {
            echo "Email is already registered. Please use a different email.";
        } else {
            // Insert new user into the database
            $insertUserQuery = "INSERT INTO User (Username, Email, Password) VALUES (?, ?, ?)";
            $stmtInsertUser = $conn->prepare($insertUserQuery);
            $stmtInsertUser->bind_param("sss", $email, $email, $password);

            if ($stmtInsertUser->execute()) {
                echo "Registration successful! You can now <a href='login.html'>login</a>.";
            } else {
                echo "Registration failed. Please try again.";
            }

            $stmtInsertUser->close();
        }

        $stmtCheckEmail->close();
    }
}

$conn->close();
?>