


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit comment</title>
 
    <link rel="stylesheet" href="style.css" />
</head>
<body>
 
    <?php
    include "comments.ink.php";
    include "database.php";
    


 $message = $_POST["message"];
 


// <form  class='edit-form' method='POST' action='editcomment.php  '>
// <input type='hidden' name='id' value='".$row['uid']."'>
// <input type='hidden' name='cid' value='".$row['cid']."'>
// <input type='hidden' name='date' value='".$row['Comment_Date']."'>
// **<input type='hidden' name='message' value='".$row['message']."'>


echo "<form method='POST' action='".editComments($conn)."' >
        <input type='hidden' name='cid' value='".$_POST['cid']."'>
        
        <div>
            <textarea name='message' placeholder='Write your comment here...' required>".$message."</textarea><br>
        </div>
        <div class='form-group'>
        </div>
        <button type='submit' name='commentSubmit'>Edit</button>
      </form>";

      
?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
    <script src="script.js" charset="utf-8"></script>
  </body>
</html>
