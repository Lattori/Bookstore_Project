
<link rel="stylesheet" href="style2.css" />
<h1 style="color: white;">Search Page</h1>
<div class="search-container">

<?php
include "database.php"; 

if (isset($_POST['search-submit'])) {
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $title = $_POST['title'] ?? '';
    $language = $_POST['language'] ?? '';
    $sort = $_POST['sort'] ?? 'publish_date';

    
    $query = "SELECT * FROM books WHERE 1=1";
    $params = [];
    $types = "";

    
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
            $query .= " ORDER BY ratings_count DESC";
            break;
        case 'average_score_trusted_feedback':
            $query .= " ORDER BY text_reviews_count DESC";
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
        while ($row = $result->fetch_assoc()) { //helps determine the book to choose from 
            echo "<a href='index2.php?title=" . urlencode($row['title']) .
            "&author=" . urlencode($row['Author']) .
            "&publisher=" . urlencode($row['Publisher']) .
            "&isbn=" . urlencode($row['isbn']) .
            "&average_rating=" . urlencode($row['average_rating']) .
            "&pubdate=" . urlencode($row['Publication_Date']) .
            "&numpages=" . urlencode($row['Num_of_pages']) .
            "'><div class='catalog-box'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>Author: " . htmlspecialchars($row['Author']) . "</p>";
            echo "<p>Average Rating: " . htmlspecialchars($row['average_rating']) . "</p>";
            echo "</div></a>";
        }
    } else {
        echo "There are no results matching your search.";
    }
    echo "</div>";

    $stmt->close();
}

$conn->close();
?>
</div>