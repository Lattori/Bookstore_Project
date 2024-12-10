<?php 

session_start(); 
date_default_timezone_set('America/New_York');



include "comments.ink.php";
include "database.php";

if(isset($_SESSION['user_id'])){
  echo "you are logged in";
}else{
  echo "you are not logged in";
} 

$author = $_GET['author'] ?? '';
$publisher = $_GET['publisher'] ?? '';
$title = $_GET['title'] ?? '';
$language = $_GET['language'] ?? '';
$sort = $_GET['sort'] ?? 'Publication_Date';
$sql = "SELECT * FROM books where Author='$author' AND title = '$title' ";
$average_rating = $_GET['average_rating'] ?? '';

$isbn = $_GET['isbn'] ?? '';
$average_rating = $_GET['average_rating'] ?? '';
$pubdate = $_GET['pubdate'] ?? '';
$numpages = $_GET['numpages'] ?? '';

?>
<?php

$title = urldecode($_GET['title']  ?? '');

$author = $_GET['author'] ?? '';
$publisher = $_GET['publisher'] ?? '';
$isbn = $_GET['isbn'] ?? '';
$average_rating = $_GET['average_rating'] ?? '';
$pubdate = $_GET['pubdate'] ?? '';
$numpages = $_GET['numpages'] ?? '';
$userna =$_SESSION['username'] ?? 'Anonymous';


?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutorial</title>
    <!-- Fonts --> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <!-- CSS -->
    <link href="style.css" rel="stylesheet">
    <meta name="robots" content="noindex,follow" />
    <link rel="stylesheet" href="style.css" />
    <!-- Login and logout  <button onclick="window.location.href='login.php' + window.location.search;">Login</button>
    <button onclick="window.location.href='logout.php' + window.location.search;">Logout</button> -->
</head>
<body>
<main class="container">
    <!-- Product Description -->
    <div class="product-description">
        <span><?php echo htmlspecialchars($author); ?></span>
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <p><?php echo "Average Rating: " . htmlspecialchars($average_rating); ?></p>
        <p><?php echo "ISBN: " . htmlspecialchars($isbn); ?></p>
        <p><?php echo "Publisher: " . htmlspecialchars($publisher); ?></p>
        <p><?php echo "Publication Date: " . htmlspecialchars($pubdate); ?></p>
        <p><?php echo "Number of Pages: " . htmlspecialchars($numpages); ?></p>
    </div>

    <!-- Purchase Form -->
    <form action="purchase.php" method="POST">
        <label for="purchaseAmount">Purchase Amount:</label>
        <input type="number" id="purchaseAmount" name="purchaseAmount" min="1" max="50" required>
        <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
        <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
        <input type="hidden" name="logname" value="<?php echo htmlspecialchars($userna); ?>">
        <button type="submit" name="purchaseSubmit">Buy</button>
    </form>
    <a href="index1.php">Return to home page</a>
</main>
<?php
  $queryString = '';
  if (!empty($_GET)) {
      $queryArray = [];
      foreach ($_GET as $key => $value) {
          $queryArray[] = $key . '=' . urlencode($value);
      }
      $queryString = implode('&', $queryArray);
  }
    if(isset($_SESSION['user_id'])){
      echo "<form action='".setComments($conn)."' method='POST'>
        <input type='hidden' name='cid' value='".$_SESSION['user_id']."'>
        <input type='hidden' name='Comment_Date' value='" . date('Y-m-d H:i:s') . "'>
        <div>
            <textarea name='message' placeholder='Write your comment here...' required></textarea><br>
        </div>
        <div class='form-group'>
            <label for='score' class='form-label'>Score (1-10)</label>
            <input type='number' name='score' id='score' class='form-control' min='1' max='10' value='' required>
        </div>
        <button type='submit' name='commentSubmit'>Comment</button>
      </form>
       <form method='GET' action=''>
        <label for='topN'>Select top useful comments:</label>
        <select name='topN' id='topN'>
            <option value='5'>Top 5</option>
            <option value='10'>Top 10</option>
        </select>
        <input type='hidden' name='author' value='$author'>
        <input type='hidden' name='publisher' value='$publisher'>
        <input type='hidden' name='title' value='$title'>
        <input type='hidden' name='language' value='$language'>
        <input type='hidden' name='sort' value='$sort'>
        <input type='hidden' name='average_rating' value='$average_rating'>
        <input type='hidden' name='isbn' value='$isbn'>
        <input type='hidden' name='pubdate' value='$pubdate'>
        <input type='hidden' name='numpages' value='$numpages'>
        <button type='submit'>Get Comments</button>
    </form>
   

      ";
    } else {
      echo "you need to be logged in to comment!<br><br>";
    }
    
    getComments($conn);
?>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="script.js"></script>
</body>
</html>

