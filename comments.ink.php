<?php
 // Start session at the beginning of the file
include "database.php";

// Function to set comments

function setComments($conn){
    if (isset($_POST["commentSubmit"])) {
        $uid = $_SESSION['user_id']; // Use session user_id for the user
        $date = $_POST["Comment_Date"];
        $message = $_POST["message"];
        $score = $_POST["score"];
        $isbn = $_GET['isbn'] ?? '';
        $logname = $_SESSION['username'];

        // Check if the user has already submitted a comment
        $checkSql = "SELECT * FROM comments WHERE uid='$uid' AND ISBN='$isbn'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            echo "You have already submitted a comment.";
        } else {
            // Insert new comment
            $sql = "INSERT INTO comments (uid, Comment_Date, message, score, ISBN, logname) VALUES ('$uid', '$date', '$message', '$score', '$isbn', '$logname')";
            $result = $conn->query($sql);
            if ($result) {
                echo "Comment submitted successfully!";
            } else {
                echo "Error submitting comment: " . $conn->error;
            }
        }
    }
}

// Function to get comments
function getComments($conn){
     $isbn = $_GET['isbn'] ?? ''; $topN = $_GET['topN'] ?? 5;
    $queryString = '';
    if (!empty($_GET)) {
        $queryArray = [];
        foreach ($_GET as $key => $value) {
            $queryArray[] = $key . '=' . urlencode($value);
        }
        $queryString = implode('&', $queryArray);
    }


    
    $isbn = $_GET['isbn'] ?? '';
    $sql = "SELECT *, (Useful - Useless) AS usefulness_score FROM comments WHERE ISBN='$isbn' ORDER BY usefulness_score DESC LIMIT $topN";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
        $uid = $row["uid"];
        $sql2 = "SELECT * FROM customers WHERE CustomerID='$uid'";
        $result2 = $conn->query($sql2);

        if($row2 = $result2->fetch_assoc()){
            echo "<div class='comment-box'><p>";
            echo 'Username: '.$row2["logname"] . "<br>"; 
            echo 'Date: .'.$row["Comment_Date"] . "<br>";
            echo 'Score: .'. $row["score"] . "<br>";
            echo nl2br($row['message']);
            
        
            echo "</p>";

            if(isset($_SESSION['user_id'])) {
                if ($_SESSION['user_id'] == $row2['CustomerID']) {
                    echo "<form class='delete-form' method='POST' action='".deleteComment($conn)."'>
                          <input type='hidden' name='cid' value='".$row['cid']."'>
                          <button type='submit' name='commentDelete'> Delete </button>
                          </form>
                          <form class='edit-form' method='POST' action='editcomment.php?$queryString'>
                          <input type='hidden' name='cid' value='".$row['cid']."'>
                          <input type='hidden' name='message' value='".$row['message']."'>
                          <button> Edit </button>
                          </form>";
                } else {
                    echo "<form class='delete-form' method='POST' action='Trust.php?$queryString'>
                          <input type='hidden' name='cid' value='".$row['uid']."'>
                          <button type='submit' name='commentDelete'>Rate User</button>
                          </form>";
                }
            }

            echo "</div>";
        }
    }
}

// Function to edit comments
function editComments($conn){
    $queryString = '';
    if (!empty($_GET)) {
        $queryArray = [];
        foreach ($_GET as $key => $value) {
            $queryArray[] = $key . '=' . urlencode($value);
        }
        $queryString = implode('&', $queryArray);
    }
    
        if(isset($_POST["commentSubmit"])){
            $cid = $_POST["cid"];
            $message = $_POST["message"];
            $sql = "UPDATE comments SET message='$message' WHERE cid='$cid'";
            $result = $conn->query($sql);
            header("Location: index2.php?$queryString");
        }
}

// Function to delete comments
function deleteComment($conn) {
    $queryString = '';
if (!empty($_GET)) {
    $queryArray = [];
    foreach ($_GET as $key => $value) {
        $queryArray[] = $key . '=' . urlencode($value);
    }
    $queryString = implode('&', $queryArray);
}

    if(isset($_POST["commentDelete"])){
        $cid = $_POST["cid"];
        $sql = "DELETE FROM comments WHERE cid='$cid'";
        $result = $conn->query($sql);
        header("Location: index2.php?$queryString");
    }
}

// Function to update trustworthiness
// Function to update trustworthiness
function TrustComment($conn) {
    if (isset($_POST['trustworthy']) || isset($_POST['notTrustworthy'])) {
        $cid = $_POST['cid'];

        // Get the current trustworthiness and number of ratings
        $query = "SELECT Trustworthy, Untrustworthy, amountrated FROM customers WHERE CustomerID='$cid'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $trustworthy = $row['Trustworthy'];
            $amountrated = $row['amountrated'];
            $untrust = $row['Untrustworthy'];

            // Update trustworthiness score
            if (isset($_POST['trustworthy'])) {
                $trustworthy += 1;
            } else if (isset($_POST['notTrustworthy'])) {
                $untrust += 1;
            }
            $amountrated += 1;

            // Update the database
            $updateQuery = "UPDATE customers 
                            SET Trustworthy = $trustworthy, Untrustworthy = $untrust, amountrated = $amountrated 
                            WHERE CustomerID='$cid'";
            $updateResult = $conn->query($updateQuery);

            if ($updateResult) {
                echo "Trustworthiness status updated successfully!";
            } else {
                echo "Error updating trustworthiness status: " . $conn->error;
            }
        } else {
            echo "Customer not found.";
        }
    }
}

// Function to update usefulness of comments
function UsefulComment($conn) {
    if (isset($_POST['Useful']) || isset($_POST['Useless'])) {
        $cid = $_POST['cid'];
        $isbn = $_GET['isbn'];

        // Get the current useful and useless scores
        $query = "SELECT Useful, Useless FROM comments WHERE uid='$cid' AND ISBN = '$isbn'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $useful = $row['Useful'];
            $useless = $row['Useless'];

            // Update usefulness score
            if (isset($_POST['Useful'])) {
                $useful += 1;
            } else if (isset($_POST['Useless'])) {
                $useless += 1;
            }

            // Update the database
            $updateQuery = "UPDATE comments 
                            SET Useful = $useful AND ISBN = '$isbn', Useless = $useless 
                            WHERE uid='$cid' AND ISBN = '$isbn' ";
            $updateResult = $conn->query($updateQuery);

            if ($updateResult) {
                echo "Usefulness status updated successfully! $isbn";
            } else {
                echo "Error updating usefulness status: " . $conn->error;
            }
        } else {
            echo "Comment not found. $cid $isbn";

        }
    }
}



