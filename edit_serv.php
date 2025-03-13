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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$sql = "SELECT * FROM services WHERE id = '$id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $service_name = $row['service_name'];
    $price = $row['price'];
}

if (isset($_POST['submit'])) {
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    $sql = "UPDATE services SET service_name = '$service_name', price = '$price' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Service updated successfully.";
    } else {
        echo "Error updating service: " . $conn->error;
    }
}

?>

<h1>Edit Service</h1>
<form action='' method='post'>
    <label for='service_name'>Service Name:</label>
    <input type='text' name='service_name' value='<?php echo $service_name; ?>' required><br><br>
    <label for='price'>Price:</label>
    <input type='number' name='price' value='<?php echo $price; ?>' required><br><br>
    <button type='submit' name='submit'>Update Service</button>
</form>