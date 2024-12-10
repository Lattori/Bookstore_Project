<?php 


include "database.php";
function display_data(){
     global $conn;
    $query = "select * from books";
    $result = mysqli_query($conn,$query);
    return $result;

}


?>