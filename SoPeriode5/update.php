<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header1>Update form<header1>
    <form action="update.php" method="POST">
        <label>Title</label>
        <input type="text" name="title">
        <label>Genre</label>
        <input type="text" name="genre">
        <label>Director</label>
        <input type="text" name="director">
        <label>Release Date</label>
        <input type="number" name="release_date">
        <button type="submit">Submit</button>
    </form>
    
    <?php
    include './includes/db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $director = $_POST["director"];
        $releaseYear = $_POST["release_date"];

        $Sqlupdate = "UPDATE film SET 
                Genre = '$genre', 
                Director = '$director', 
                Release_Date = '$releaseYear'
                WHERE Title = '$title'";

        if ($conn->query($Sqlupdate) === TRUE) {
            echo "Film bijgewerkt!";
        } else {
            echo "Fout bij het bijwerken van de film: " . $conn->error;
        }
    }
    $conn->close();
    ?>
</body>
</html>
