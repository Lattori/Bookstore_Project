
<?php
 if(empty($_POST["fnameInput"])){
    die("Full Name is required");
 }
 if(strlen($_POST["password"]) <8) {
    die("password must be at least 8 characters ");
 }
 if(! preg_match( "/[a-z]/i",$_POST["password"])){
    die("Password must contain at least one letter!");
 }

 if(! preg_match( "/[0-9]/",$_POST["password"])){
    die("Password must contain at least one Number!");
 }

    
    
   
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $mysqli = require __DIR__."/database.php";

      
    $query = "SELECT * FROM customers WHERE logname = '{$_POST['lognameInput']}'";
$result = $mysqli->query($query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        die('Error! UserName has already been used! Please try again!');
    } else {
        
    }
} 

 

    
    $sql = "INSERT INTO customers (First_Name,Last_Name,logname,password_hash,Customer_info)
VALUES(?,?,?,?,?)";
$stmt = $mysqli->stmt_init();

 if( ! $stmt->prepare($sql) ){

    die("SQL error: " . $mysqli->error);
}  
$stmt->bind_param("sssss",$_POST["fnameInput"],$_POST["lnameInput"],$_POST["lognameInput"],$password_hash,$_POST["bio"]);


    

$stmt->execute();

echo "Signup Sucess!!!";
header("Location: index1.php");
exit;

