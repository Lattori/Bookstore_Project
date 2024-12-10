<?php

function getMostTrustedCustomers($conn, $limit) {
    $sql = "
        SELECT logname, (Trustworthy - Untrustworthy) AS trust_score
        FROM customers
        ORDER BY trust_score DESC
        LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
}



function getMostUsefulCustomers($conn, $limit) {
    $sql = "
        SELECT c.logname, 
               AVG(c.Useful) AS usefulness_score
        FROM comments c
        
        GROUP BY c.logname
        ORDER BY usefulness_score DESC
        LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Awards</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Customer Awards</h1>
    </header>
    <main>
        <section>
            <h2>Most Trusted Customers</h2>
            <?php
            include "database.php";
            
            // Set the number of customers to display
            $topN = 10;
            
            // Get most trusted customers
            $trustedCustomers = getMostTrustedCustomers($conn, $topN);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>Username</td>
                            <td>Trust Score</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $trustedCustomers->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['logname']); ?></td>
                                <td><?php echo htmlspecialchars($row['trust_score']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>Most Useful Customers</h2>
            <?php
            // Get most useful customers
            $usefulCustomers = getMostUsefulCustomers($conn, $topN);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>Username</td>
                            <td>Usefulness Score</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $usefulCustomers->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['logname']); ?></td>
                                <td><?php echo htmlspecialchars($row['usefulness_score']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>








?>