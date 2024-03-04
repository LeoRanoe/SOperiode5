<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="delete.php" method="POST">
        <label>Title</label>
        <input type="text" name="title">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
<?php
    include './includes/db_connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
    
        $SQLdelete = "DELETE FROM film WHERE Title = '$title'";

        if ($conn->query($SQLdelete) === TRUE) {
            echo "Film Verwijderd!";
        } else {
            echo "Fout bij het verwijderen van de film: " . $conn->error;
        }
    }
?>
