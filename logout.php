<?php
$queryString = '';
if (!empty($_GET)) {
    $queryArray = [];
    foreach ($_GET as $key => $value) {
        $queryArray[] = $key . '=' . urlencode($value);
    }
    $queryString = implode('&', $queryArray);
}


      session_start();
      session_destroy();
      header("Location: index2.php?$queryString");
      exit();
      
    