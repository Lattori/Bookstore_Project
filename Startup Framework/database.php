<?php

$host = "127.0.0.1:3307";
$dbname = "bookstore";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);
$conn =  mysqli_connect($host, $username, $password, $dbname);


if ($mysqli->connect_errno) {
    die("connection error". $mysqli->connect_error);
}


return $mysqli;