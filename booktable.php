<?php
include "functions.php";
include "database.php";
$query = "SELECT * FROM books";
$Result = display_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Data from database in PHP</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body class="bg-dark">
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="display-6 text-center">Fetch Data from database in PHP</h2>
                    <a class="btn btn-primary" href="signup.html" role="button">Add New Customer</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <td>Title</td>
                                    <td>Author</td>
                                    <td>Average Rating</td>
                                    <td>ISBN</td>
                                    <td>ISBN13</td>
                                    <td>Publisher</td>
                                    <td>lang</td>
                                    <td>Amount of Reviews</td>
                                    <td>Stock</td>
                                    <td>Edit</td>
                                    <td>Delete</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($Result)) { ?>
                                    <tr>
                                        <td><?php echo $row['title']; ?></td>
                                        <td><?php echo $row['Author']; ?></td>
                                        <td><?php echo $row['average_rating']; ?></td>
                                        <td><?php echo $row['isbn']; ?></td>
                                        <td><?php echo $row['isbn13']; ?></td>
                                        <td><?php echo $row['Publisher']; ?></td>
                                        <td><?php echo $row['lang']; ?></td>
                                        <td><?php echo $row['ratings_count']; ?></td>
                                        <td><?php echo $row['stock']; ?></td>
                                        <td><a href="edit_stock.php?isbn=<?php echo $row['isbn']; ?>" class="btn btn-primary">Edit Stock</a></td>
                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
