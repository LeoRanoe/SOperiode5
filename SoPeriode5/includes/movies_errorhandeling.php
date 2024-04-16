<?php
// Initialize search query
$searchQuery = "";

// Get search term from GET parameter
$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

// Check if search term is not empty
if (!empty($searchTerm)) {
    $searchQuery .= "Title LIKE '%$searchTerm%'";
}

// Check if genre filter is applied
$genreID = isset($_GET['genre']) ? $_GET['genre'] : '';
if (!empty($genreID)) {
    $searchQuery .= ($searchQuery == "") ? "GenreID = '$genreID'" : " AND GenreID = '$genreID'";
}

// Check if release date filter is applied
$releaseDate = isset($_GET['release_date']) ? $_GET['release_date'] : '';
if (!empty($releaseDate)) {
    $searchQuery .= ($searchQuery == "") ? "Release_Date = '$releaseDate'" : " AND Release_Date = '$releaseDate'";
}

// Check if director filter is applied
$directorName = isset($_GET['director']) ? $_GET['director'] : '';
if (!empty($directorName)) {
    $searchQuery .= ($searchQuery == "") ? "Director = '$directorName'" : " AND Director = '$directorName'";
}

// Construct the SQL query
$query = "SELECT * FROM film WHERE 1=1 "; // Start with a dummy condition

if (!empty($searchQuery)) {
    $query .= "AND ($searchQuery)"; // Add the search query conditions
}

// Execute the query
$result = $conn->query($query);

// Check if movie exists
if ($result->num_rows > 0) {
    // Movie(s) found, fetch movie details
    $movies = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // No movies found, set $movies to an empty array
    $movies = [];
}
?>