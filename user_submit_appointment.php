<?php
// Establish PDO database connection
$pdo = new PDO('mysql:host=localhost;dbname=nail_salon_admin', 'kapoy', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $technician_id = $_POST['technician_id'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';

    // Validate input data
    if (empty($full_name) || empty($contact_number) || empty($email) || empty($technician_id) || empty($appointment_date) || empty($appointment_time)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Insert appointment into the appointments table
    $sql = "INSERT INTO appointments (full_name, contact_number, email, technician_id, appointment_date, appointment_time) 
            VALUES (:full_name, :contact_number, :email, :technician_id, :appointment_date, :appointment_time)";
    
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':technician_id', $technician_id);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time', $appointment_time);
    
    if ($stmt->execute()) {
        // Redirect to a confirmation page
        $appointment_id = $pdo->lastInsertId();
        header("Location: user_confirmation.php?appointment_id=" . $appointment_id);
        exit();
    } else {
        echo "Failed to book appointment.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Appointment</title>
</head>
<body>
    <h1>Book an Appointment</h1>
    <form method="POST">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="technician_id">Technician ID:</label>
        <input type="text" id="technician_id" name="technician_id" required><br><br>
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" required><br><br>
        <label for="appointment_time">Appointment Time:</label>
        <input type="time" id="appointment_time" name="appointment_time" required><br><br>
        <input type="submit" value="Book Appointment">
    </form>
</body>
</html>