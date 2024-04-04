<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$warningMessage = '';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate and store a unique form submission token
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = md5(uniqid(rand(), true));
}

// Handle form submission
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
            // User login successful
            $userRow = $resultUser->fetch_assoc();
            $_SESSION['userID'] = $userRow['UserID']; // Assuming 'UserID' is the column name for the user ID in your database
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_email'] = $email;
            $_SESSION['userRole'] = 'user';
            header("Location: profile.php");
            exit();
        } elseif ($resultAdmin->num_rows == 1) {
            // Admin login successful
            $adminRow = $resultAdmin->fetch_assoc();
            $_SESSION['userID'] = $adminRow['AdminID']; // Assuming 'AdminID' is the column name for the admin ID in your database
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_email'] = $email;
            $_SESSION['userRole'] = 'admin';
            header("Location: admin.php");
            exit();
        } else {
            $warningMessage = "Invalid credentials. Please try again.";
        }
        

        // Set a new unique token for the next form submission
        $_SESSION['form_token'] = md5(uniqid(rand(), true));
    } else {
        $warningMessage = "Form already submitted.";
    }

    $stmtUser->close();
    $stmtAdmin->close();
}

$conn->close();
?>