<?php
session_start();

$servername = "localhost";
$db_username = "kapoy";
$db_password = "123456";
$dbname = "nail_salon_admin";

// Database connection settings
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define your admin username and password (for demo purposes)
define("ADMIN_USERNAME", "kapoy"); // Minimum username
define("ADMIN_PASSWORD", "123456"); // In password

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'admin_username' and 'admin_password' are set in the POST request
    if (isset($_POST['admin_username']) && isset($_POST['admin_password'])) {
        // Sanitize user inputs
        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password'];

        // Validate admin credentials
        if ($admin_username === ADMIN_USERNAME && $admin_password === ADMIN_PASSWORD) {
            $_SESSION['is_admin'] = true;  // Set session variable to mark as logged in
            header('Location: admin_panel.php');  // Redirect to the admin panel/dashboard
            exit();
        } else {
            $error_message = "Invalid credentials!"; // Show error message
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            background-image: url('https://i.pinimg.com/736x/48/ed/de/48edde30c3cd9d767d143b3edd125f26.jpg');
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form container */
        form {
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Input field styling */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0056b3;
            background-color: #e8f4ff;
            outline: none;
        }

        /* Submit button styling */
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0056b3;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #00408a;
        }

        /* Error message */
        p {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <h2>Admin Login</h2>
        <form action="admin_login.php" method="POST">
            <label for="admin_username">Username:</label>
            <input type="text" id="admin_username" name="admin_username" required>
            
            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password" required>

            <input type="submit" value="Login">
        </form>
        
        <?php
            // Display error message if credentials are incorrect
            if (isset($error_message)) {
                echo "<p>$error_message</p>";
            }
        ?>
    </div>
</body>
</html>
