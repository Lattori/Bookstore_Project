<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <h1>Registration Form</h1>
  <p>Please fill out this form with the required information</p>
  <form action="addmanager.php" method="POST">
   
  
    <label for="logname">Username :</label>
    <input type="text" id="logname" name="lognameInput" required><br><br>
  
    <label for="password">Password :</label>
    <input type="password" id="password" name="password" required><br><br>
    
    
    
  
    <input onclick="window.location.href='index1.php'" type="submit" value="submit">
    
  </form> 
</body>
</html>

<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Password validation
    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters.");
    }
    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter!");
    }
    if (!preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number!");
    }

    // Hash password
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $mysqli = require __DIR__ . "/database.php";

    // Check for duplicate username
    $stmt = $mysqli->prepare("SELECT 1 FROM manager WHERE logname = ?");
    $stmt->bind_param("s", $_POST['lognameInput']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die('Error! Username has already been used! Please try again!');
    }
    $stmt->close();

    // Insert new user
    $sql = "INSERT INTO manager (logname, password_hash) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $mysqli->error);
    }
    $stmt->bind_param("ss", $_POST["lognameInput"], $password_hash);

    if ($stmt->execute()) {
        echo "Signup Success!!!";
        header("Location: index1.php");
        exit;
    } else {
        die("Error: " . $stmt->error);
    }
}
?>
