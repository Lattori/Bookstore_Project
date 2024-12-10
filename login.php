<?php
session_start();

// Capture the query string parameters manually
$queryString = '';
if (!empty($_GET)) {
    $queryArray = [];
    foreach ($_GET as $key => $value) {
        $queryArray[] = $key . '=' . urlencode($value);
    }
    $queryString = implode('&', $queryArray);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf(
        "SELECT * FROM customers WHERE logname ='%s'",
        $mysqli->real_escape_string($_POST["username"])
    );

    $result = $mysqli->query($sql);
    $customer = $result->fetch_assoc();

    if ($customer) {
        if (password_verify($_POST["password"], $customer["password_hash"])) {
            // Store user data in session variables
            $_SESSION["user_id"] = $customer["CustomerID"];
            $_SESSION["username"] = $customer["logname"];

            // Redirect with original GET parameters
            header("Location: index1.php?$queryString");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Username not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login screen</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link rel="icon" href="favicon.png">
  
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  
    <section class="bg-gray-50 min-h-screen flex items-center justify-center">
        <!-- login container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
          <!-- form -->
          <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">Customer Login</h2>
            <p class="text-xs mt-4 text-[#002D74]">Login Here</p>
            
            <!-- Include query string in form action -->
            <form action="loginsuc.php?<?php echo htmlspecialchars($queryString); ?>" method="POST" class="flex flex-col gap-4">
              <input class="p-2 mt-8 rounded-xl border" type='text' name='username' placeholder="Username">
              <div class="relative">
                <input class="p-2 rounded-xl border w-full" type='password' name='password' placeholder='Password'>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
              </div>
              <button class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300" type="submit">Login</button>
            </form>
      
            <div class="mt-6 grid grid-cols-3 items-center text-gray-400">
              <hr class="border-gray-400">
              <p class="text-center text-sm">OR</p>
              <hr class="border-gray-400">
            </div>
      
            <div class="mt-3 text-xs flex justify-between items-center text-[#002D74]">
              <p>Don't have an account?</p>
              <button onclick="window.location.href='signup.html'" class="py-2 px-5 bg-white border rounded-xl hover:scale-110 duration-300">Register</button>
            </div>
            <div class="mt-6 grid grid-cols-3 items-center text-gray-400">
              <hr class="border-gray-400">
              <p class="text-center text-sm">OR</p>
              <hr class="border-gray-400">
              <a class="text-xs mt-4 text-[#002D74]" href="Manager_login.html">Manager login -></a>
            </div>
          </div>
      
          <!-- image -->
          <div class="md:block hidden w-1/2">
            <img class="rounded-2xl" src="https://th.bing.com/th/id/R.2cb49a527925196a98c76d5451347655?rik=4tt8mZ2FRG2fiw&pid=ImgRaw&r=0">
          </div>
        </div>
      </section>
</body>
</html>
