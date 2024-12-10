<?php
$queryString = $_SERVER['QUERY_STRING'] ?? '';
session_start(); 

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mysqli = require __DIR__ . "/database.php";

        $sql = sprintf(
            "SELECT * FROM customers WHERE logname ='%s'",
            $mysqli->real_escape_string($_POST["username"])
        );
        
        $result = $mysqli->query($sql);
        $customer = $result->fetch_assoc();

        if ($customer) {
            if (password_verify($_POST["password"], $customer["password_hash"])) {
               
                  $_SESSION["user_id"] = $customer["CustomerID"]; 
                  $_SESSION["username"] = $customer["logname"];
                  header("Location: index1.php?$queryString");
                  exit();

      
            } else {
                die("Invalid password");
                
            }
        } else {
            die("Username not found");
        }

    }
    if(isset($_SESSION['user_id'])){
        echo "you are logged in";
      }else{
        echo "you are not logged in";
      }  
      
    
  
 
    if(isset($_POST['logoutSubmit'])){
      session_start();
      session_destroy();
      header("Location: index2.php?$queryString");
      exit();
    }

  
?>