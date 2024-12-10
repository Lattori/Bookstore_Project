<?php
include "database.php"; // Ensure this file initializes $conn properly

if (isset($_POST['search-submit'])) {
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $title = $_POST['title'] ?? '';
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
            $query .= " ORDER BY Publication_Date DESC";
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
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
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
