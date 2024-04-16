<?php
// Retrieve movie information from the database based on search query
if(isset($_GET['q'])) {
    $search_query = $_GET['q'];
    $query = "SELECT * FROM film WHERE Title LIKE '$search_query%'";
} else {
    // No search query provided, fetch all movies
    $query = "SELECT * FROM film";
}

$result = $conn->query($query);
?>