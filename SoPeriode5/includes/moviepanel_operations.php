<?php
// Function to sanitize input data
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Retrieve film title from the URL parameter
$movieTitle = isset($_GET['title']) ? sanitizeInput($_GET['title']) : '';

// Check if form fields are set and perform form submission handling
if (isset($_POST['filmID'], $_POST['rating'], $_POST['comment'])) {
    // Sanitize input data
    $filmID = $_POST['filmID'];
    $rating = $_POST['rating'];
    $comment = htmlspecialchars($_POST['comment']); // Sanitize comment

    // Insert rating and comment into the database
    $insertQuery = "INSERT INTO ratings_comments (FilmID, Rating, Comment) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iis", $filmID, $rating, $comment);
    $insertStmt->execute();

    // Calculate and update average rating for the movie
    $updateQuery = "UPDATE film SET AverageRating = (SELECT AVG(Rating) FROM ratings_comments WHERE FilmID = ?) WHERE FilmID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $filmID, $filmID);
    $updateStmt->execute();

    // Redirect back to the same page
    header("Location: {$_SERVER['PHP_SELF']}?title=" . urlencode($movieTitle));
    exit();
}

// Query to fetch movie details based on title
$query = "SELECT * FROM film WHERE Title = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $movieTitle);
$stmt->execute();
$result = $stmt->get_result();

// Check if movie exists
if ($result->num_rows > 0) {
    // Fetch movie details
    $row = $result->fetch_assoc();
    $movieID = $row['FilmID'];
    $releaseDate = $row['Release_Date'];
    $director = $row['Director'];
    $description = $row['Description'];
    $movieFilePath = $row['MovieLink'];
    $posterFilePath = $row['PosterFilePath'];
    $averageRating = $row['AverageRating'];

    // Extract YouTube video ID from the URL
    $video_id = '';
    if (preg_match('/(?:youtube\\.com\\/.*(?:[\\?&]v=|\\/embed\\/|\\/videos\\/|\\/channels\\/|\\/user\\/|[^\\w\\-]+[^\\/]*[\\?&]list=)|youtu\\.be\\/)([^\\"&?\\/ ]{11})/', $movieFilePath, $match)) {
        $video_id = $match[1];
    }
    // Construct YouTube embed URL
    $embed_url = "https://www.youtube.com/embed/$video_id";
} else {
    // Movie not found in the database, set default values
    $movieID = null;
    $releaseDate = "Unknown";
    $director = "Unknown";
    $description = "No description available.";
    $movieFilePath = "";
    $posterFilePath = "default_poster.jpg"; // Replace with your default poster image path
    $embed_url = "";
    $averageRating = 0;
}
$commentsQuery = "SELECT Comment FROM ratings_comments WHERE FilmID = ?";
$commentsStmt = $conn->prepare($commentsQuery);
$commentsStmt->bind_param("i", $movieID);
$commentsStmt->execute();
$commentsResult = $commentsStmt->get_result();
?>