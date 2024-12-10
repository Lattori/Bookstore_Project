<?php
include "database.php";

// Get ISBN from query parameter
$isbn = $_GET['isbn'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newStock = $_POST['stock'];
    $isbn = $_POST['isbn'];

    // Update the stock in the database
    $sqlUpdateStock = "UPDATE books SET stock = ? WHERE isbn = ?";
    $stmt = $conn->prepare($sqlUpdateStock);
    $stmt->bind_param("is", $newStock, $isbn);

    if ($stmt->execute()) {
        header("Location: index1.php");
        exit();
    } else {
        echo "Error updating stock: " . $conn->error;
    }
}

// Fetch the current stock level
$sql = "SELECT stock FROM books WHERE isbn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $isbn);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Stock for Book ISBN: <?php echo htmlspecialchars($isbn); ?></h2>
        <form action="edit_stock.php" method="POST">
            <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
            <div class="form-group">
                <label for="stock">Stock Level</label>
                <input type="number" id="stock" name="stock" class="form-control" value="<?php echo htmlspecialchars($book['stock']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>
