<?php
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
                // Registration successful, log the user in
                $_SESSION['userID'] = $email; // You can set userID to email for simplicity
                $_SESSION['loggedIn'] = true;
                $_SESSION['user_email'] = $email;
                $_SESSION['userRole'] = 'user'; // Assuming a default role for newly registered users
                header("Location: home.php"); // Redirect to home page
                exit();
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
