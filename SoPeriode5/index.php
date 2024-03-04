<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <label>Title</label>
        <input type="text" name="title">
        <label>Genre</label>
        <input type="text" name="genre">
        <label>Director</label>
        <input type="text" name="director">
        <label>Release Date</label>
        <input type="number" name="release_date">
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
<?php
    include './includes/db_connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["title"], $_POST["genre"], $_POST["director"], $_POST["release_date"])) {
            $title = $_POST["title"];
            $genre = $_POST["genre"];
            $director = $_POST["director"];
            $releaseYear = $_POST["release_date"];

            $sqlinsert = "INSERT INTO film (Title, Genre, Director, Release_Date) VALUES ('$title', '$genre', '$director', '$releaseYear')";

            if ($conn->query($sqlinsert) === TRUE) {
                echo "Nieuwe film toegevoegd!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Please fill out all the form fields.";
        }
    }
?>
