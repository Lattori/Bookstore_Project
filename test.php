<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Browsing</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Book Browsing</h1>
    </header>
    <main>
        <form class="search-form" action="search.php" method="POST">
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" placeholder="Enter author name">
            </div>
            <div class="form-group">
                <label for="publisher">Publisher:</label>
                <input type="text" id="publisher" name="publisher" placeholder="Enter publisher name">
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter title words">
            </div>
            <div class="form-group">
                <label for="language">Language:</label>
                <input type="text" id="language" name="language" placeholder="Enter language">
            </div>
            <div class="form-group">
                <label for="sort">Sort by:</label>
                <select id="sort" name="sort">
                    <option value="publish_date">Publish Date</option>
                    <option value="average_score_comments">Average Score of Comments</option>
                    <option value="average_score_trusted_feedback">Average Score of Trusted Feedback</option>
                </select>
            </div>
            <button name="search-submit" type="submit" class="search-button">Search</button>
        </form>
    </main>
</body>
</html>


<?php
include "database.php"; // Ensure this file initializes $conn properly

if (isset($_POST['search-submit'])) {
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $title = str_replace(['%', '_', '(', ')'], ['\%', '\_', '\(', '\)'], $title);

    $language = $_POST['language'] ?? '';
    $sort = $_POST['sort'] ?? 'publish_date';

    // Start building the query
    $query = "SELECT * FROM books WHERE 1=1";
    $params = [];
    $types = "";

    // Append conditions for each filter
    if (!empty($author)) {
        $query .= " AND Author LIKE ?";
        $params[] = '%' . $author . '%';
        $types .= 's';
    }
    if (!empty($publisher)) {
        $query .= " AND Publisher LIKE ?";
        $params[] = '%' . $publisher . '%';
        $types .= 's';
    }
    if (!empty($title)) {
        $query .= " AND title LIKE ?";
        $params[] = '%' . $title . '%';
        $types .= 's';
    }
    if (!empty($language)) {
        $query .= " AND lang LIKE ?";
        $params[] = '%' . $language . '%';
        $types .= 's';
    }

    // Add sorting
    switch ($sort) {
        case 'average_score_comments':
            $query .= " ORDER BY average_score_comments DESC";
            break;
        case 'average_score_trusted_feedback':
            $query .= " ORDER BY average_score_trusted_feedback DESC";
            break;
        case 'publish_date':
        default:
            $query .= " ORDER BY Publication_Date	 DESC";
            break;
    }

    // Prepare statement
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error in query: " . $conn->error);
    }

    // Bind parameters
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='search-container'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='catalog-box'>";
            echo "<h3>" . $row['title'] . "</h3>";
            echo "<p>Author: " . htmlspecialchars($row['Author']) . "</p>";
            echo "<p>Average Rating: " . htmlspecialchars($row['average_rating']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "There are no results matching your search.";
    }
    echo "</div>";

    $stmt->close();
}

$conn->close();
?>
