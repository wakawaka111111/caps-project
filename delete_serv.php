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

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM services WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Service deleted successfully.";
    } else {
        echo "Error deleting service: " . $conn->error;
    }
}

header('Location: services.php');
exit;