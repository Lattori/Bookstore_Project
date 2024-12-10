<?php
include "comments.ink.php";
include "database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<h1 style="color: white;">Catalog</h1>
<h2 style="color: white;">All Books here!</h2>

    <div class="search-container">
    <?php
    $sql = "SELECT * FROM books";
    $result = mysqli_query($conn,$sql);
    $queryResults = mysqli_num_rows($result);
    if($queryResults > 0){

        while($row = mysqli_fetch_assoc($result)){
            echo"<div class='catalog-box'>
            <h3> ".$row['title']."</h3>
            <p> ".$row['Author']."</p>
            <p> ".$row['average_rating']."</p>
            
            </div>";
        }
    }
    ?>
</div>
</body>
</html>