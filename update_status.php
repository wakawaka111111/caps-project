<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: admin_login.html');
    exit();
}

$conn = new mysqli("localhost", "kapoy", "123456", "nail_salon_admin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'status_') === 0) {
            $id = intval(str_replace('status_', '', $key));
            $status = $value;

            $sql = "UPDATE appointment_history SET status = '$status' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                continue;
            } else {
                echo "Error updating status for appointment $id: " . $conn->error . "<br>";
            }
        }
    }
    header('Location: view_history.php?status=updated');
    exit();
}

$conn->close(); // Close the database connection
?>