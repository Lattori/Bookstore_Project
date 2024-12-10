<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Purchase</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
date_default_timezone_set('America/New_York');

include "comments.ink.php";
include "database.php";

if (isset($_POST['purchaseSubmit'])) {
    $purchaseAmount = $_POST['purchaseAmount'];
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $logname = $_POST['logname'];

    // Check available stock
    $sqlCheckStock = "SELECT stock FROM books WHERE ISBN = '$isbn'";
    $result = $conn->query($sqlCheckStock);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $availableStock = $row['stock'];

        if ($purchaseAmount > $availableStock) {
            echo "<div class='receipt'>
                    <h2>Purchase Receipt</h2>
                    <p>We're sorry, but the requested quantity exceeds our available stock.</p>
                    <p>Available Stock: " . htmlspecialchars($availableStock) . "</p>
                    <button onclick=\"window.location.href='index1.php'\">Return Home</button>
                  </div>";
        } else {
            // Proceed with the purchase
            $sqlUpdateStock = "UPDATE books SET stock = stock - $purchaseAmount WHERE ISBN = '$isbn'";
            if ($conn->query($sqlUpdateStock) === TRUE) {
                
                $sqlInsertOrder = "INSERT INTO orders (logname, quantity, ISBN, title) VALUES ('$logname', '$purchaseAmount', '$isbn', '$title')";
                if ($conn->query($sqlInsertOrder) === TRUE) {
                    echo "<div class='receipt'>
                            <h2>Purchase Receipt</h2>
                            <p><strong>Username:</strong> " . htmlspecialchars($logname) . "</p>
                            <p><strong>Book Title:</strong> " . htmlspecialchars($title) . "</p>
                            <p><strong>ISBN:</strong> " . htmlspecialchars($isbn) . "</p>
                            <p><strong>Quantity:</strong> " . htmlspecialchars($purchaseAmount) . "</p>
                            <p>Thank you for your purchase!</p>";
                    
                    // Fetch suggested books
                    $sqlSuggestedBooks = "
                        SELECT b.title, b.ISBN, COUNT(o2.ISBN) AS sales_count 
                        FROM orders o1
                        JOIN orders o2 ON o1.logname = o2.logname AND o1.ISBN <> o2.ISBN
                        JOIN books b ON o2.ISBN = b.ISBN
                        WHERE o1.ISBN = ?
                        GROUP BY b.title, b.ISBN
                        ORDER BY sales_count DESC
                        LIMIT 5";

                    $stmt = $conn->prepare($sqlSuggestedBooks);
                    $stmt->bind_param("s", $isbn);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    echo "<div class='suggested-books'>";
                    if ($result->num_rows > 0) {
                        echo "<h3>Suggested Books</h3>
                                <ul>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><strong>" . htmlspecialchars($row['title']) . "</strong> (ISBN: " . htmlspecialchars($row['ISBN']) . ") - Bought " . $row['sales_count'] . " times</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No suggested books available.</p>";
                    }
                    echo "</div>";

                    $stmt->close();
                    echo "<button onclick=\"window.location.href='index1.php'\">Return Home</button>";
                    echo "</div>"; 
                } else {
                    echo "Error inserting order: " . $conn->error;
                }
            } else {
                echo "Error updating stock: " . $conn->error;
            }
        }
    } else {
        echo "Error fetching stock information: " . $conn->error;
    }
}

if (isset($_SESSION['user_id'])) {
    echo "you are logged in";
} else {
    echo "you are not logged in";
}

$conn->close();
?>
</body>
</html>
