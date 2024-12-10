




<?php
/*require_once('config/db.php');
$query = "SELECT * FROM books";
$result = mysqli_query($con, $query);
*/
include "database.php";
$query = "SELECT * FROM customers";
$result = mysqli_query($conn,$query);



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
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Password(hash)</td>
                                    <td>Login Name</td>
                                    <td>Customer_Info</td>
                                    <td>TrustWorthy</td>
                                    <td>Untrustworthy</td>
                                    <td>Amount of Reviews</td>
                                    
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['First_Name']; ?></td>
                                        <td ><?php echo $row['Last_Name']; ?></td>
                                        <td><?php echo $row['logname']; ?></td>
                                        <td><?php echo $row['password_hash']; ?></td>
                                        <td><?php echo $row['Customer_info']; ?></td>
                                        <td><?php echo $row['Trustworthy']; ?></td>
                                        <td><?php echo $row['Untrustworthy']; ?></td>
                                        <td><?php echo $row['amountrated']; ?></td>
                                        
                                      
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
