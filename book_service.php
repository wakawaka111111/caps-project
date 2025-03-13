<?php
// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    try {
        // Establish PDO database connection
        $pdo = new PDO('mysql:host=localhost;dbname=nail_salon_admin', 'kapoy', '123456');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert appointment into the database
        $stmt = $pdo->prepare("INSERT INTO appointments (full_name, contact_number, email, Service_type, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['full_name'],
            $_POST['contact_number'],
            $_POST['email'],
            $_POST['service_type'],
            $_POST['appointment_date'],
            $_POST['appointment_time']
        ]);

        // Redirect to the confirmation page
        header("Location: user_confirmation.php?appointment_id=" . $pdo->lastInsertId());
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Get the service type from the URL
    $service_type = htmlspecialchars($_GET['service_type'] ?? 'Unknown Service');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
</head>
<body>

    <h2>Book a Service: <?php echo $service_type; ?></h2>
    <form action="book_service.php" method="POST">
        <input type="hidden" name="service_type" value="<?php echo $service_type; ?>">
        
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required>
        
        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" name="appointment_date" required>
        
        <label for="appointment_time">Appointment Time:</label>
        <input type="time" name="appointment_time" required>
        
        <button type="submit">Confirm Appointment</button>
    </form>

</body>
</html>