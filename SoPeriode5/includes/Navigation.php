<?php
// Check if the user is logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    echo '<li>';
    // Display the appropriate link based on user role
    if ($_SESSION['userRole'] == 'admin') {
        echo '<a href="admin.php">Admin Panel</a>';
    } else {
        echo '<a href="home.php">User Panel</a>';
    }
    echo '</li>';
    // Add the logout link
    echo '<li><a href="?logout=true">Logout</a></li>';
} else {
    // If not logged in, show login link
    echo '<li><a href="login.php">Login</a></li>';
}

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] == true) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit;
}
?>
