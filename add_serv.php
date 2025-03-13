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

if (isset($_POST['submit'])) {
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO services (service_name, price) VALUES ('$service_name', '$price')";
    if ($conn->query($sql) === TRUE) {
        echo "Service added successfully.";
    } else {
        echo "Error adding service: " . $conn->error;
    }
}

?>

<h1>Add Service</h1>
<form action='' method='post'>
    <label for='service_name'>Service Name:</label>
    <input type='text' name='service_name' required><br><br>
    <label for='price'>Price:</label>
    <input type='number' name='price' required><br><br>
    <button type='submit' name='submit'>Add Service</button>
</form>