<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trust comment</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    

    <?php
    include "database.php";
    include "comments.ink.php";

    if (isset($_POST['cid'])) {
        $cid = $_POST['cid'];
        $ISBN = $_GET['isbn'];
        $ISBN = $_GET['isbn'];

        // Fetch user details
        $userSql = "SELECT * FROM customers WHERE CustomerID='$cid'";
        $userSql2 = "SELECT * FROM comments WHERE uid='$cid'";
        $userResult = $conn->query($userSql);
        $user = $userResult->fetch_assoc();
        $userResult2 = $conn->query($userSql2);
        $user2 = $userResult2->fetch_assoc();

        if ($user) {
            $username = htmlspecialchars($user['logname']);
            $first = htmlspecialchars($user['First_Name']);
            $last = htmlspecialchars($user['Last_Name']);
            $cusinfo = htmlspecialchars($user['Customer_info']);
            $message = htmlspecialchars($user2['message']) ?? 'No comments';
            $message2 = htmlspecialchars($user2['message']);
            $Trust = htmlspecialchars($user['Trustworthy']);
            $UnTrust = htmlspecialchars($user['Untrustworthy']?? '0');
        } else {
            $username = "Unknown User";
        }

        echo "<h2>User Profile for $username</h2>";
        echo "<p>Name: $first $last <p>";
        echo "<p>Customer Information: $cusinfo <p>";
        echo "<p>Messages: $message <p>";
        echo "<p>Trustworthy reviews: $Trust <p>";
        echo "<p>UnTrustworthy reviews: $UnTrust <p>";
        
        $queryString = '';
  if (!empty($_GET)) {
      $queryArray = [];
      foreach ($_GET as $key => $value) {
          $queryArray[] = $key . '=' . urlencode($value);
      }
      $queryString = implode('&', $queryArray);
  }
        
  echo "<button onclick=\"window.location.href='index2.php?$queryString'\">Back to Book</button>";

        
        echo "<form method='POST' action=''>
                <input type='hidden' name='cid' value='$cid'>
                <div>
                    <p>Is this User Trustworthy or not?</p>
                </div>
                <div class='form-group'>
                    <button type='submit' name='trustworthy'>Trustworthy</button>
                    <button type='submit' name='notTrustworthy'>Untrustworthy</button>
                </div>
              </form>";
        
        echo "<form method='POST' action=''>
              <input type='hidden' name='cid' value='$cid'>
              <div>
                  <p>Is this Comment Useful or not?</p>
              </div>
              <div class='form-group'>
                  <button type='submit' name='Useful'>Useful</button>
                  <button type='submit' name='Useless'>Useless</button>
              </div>
            </form>";

        // Handle trustworthiness updates
        if (isset($_POST['trustworthy']) || isset($_POST['notTrustworthy'])) {
            TrustComment($conn);
        }

        // Handle usefulness updates
        if (isset($_POST['Useful']) || isset($_POST['Useless'])) {
            UsefulComment($conn);
        }
    } else {
        echo "<p>No user selected.</p>";
    }
    ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
    <script src="script.js" charset="utf-8"></script>
</body>
</html>
