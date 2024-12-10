
<?php



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf(
        "SELECT * FROM manager WHERE logname ='%s'",
        $mysqli->real_escape_string($_POST["username"])
    );
    
    $result = $mysqli->query($sql);
    $manager = $result->fetch_assoc();

    if ($manager) {
        if (password_verify($_POST["password"], $manager["password_hash"])) {
            $_SESSION["user_id"] = $manager["Manager_ID"];
            $_SESSION["username"] = $manager["logname"];
            header("Location:managerdash.html");
            exit;
            
            
            //sleep
        } else {
            die("Invalid password");
        }
    } else {
        die("Username not found");
    }
}
