<?php
// Establish PDO database connection
$pdo = new PDO('mysql:host=localhost;dbname=nail_salon_admin', 'kapoy', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the appointment_id from the URL
$appointment_id = $_GET['appointment_id'] ?? null;

if (!$appointment_id) {
    header("Location: user_appointment.php");
    exit();
}

// Fetch appointment details from the database
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->execute([$appointment_id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    echo "No appointment found.";
    exit();
}

if (isset($_POST['save_changes'])) {
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $technician_id = $_POST['technician_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $stmt = $pdo->prepare("UPDATE appointments SET 
        full_name = ?, 
        contact_number = ?, 
        email = ?, 
        technician_id = ?, 
        appointment_date = ?, 
        appointment_time = ?
        WHERE id = ?");
    $stmt->execute([
        $full_name, 
        $contact_number, 
        $email, 
        $technician_id, 
        $appointment_date, 
        $appointment_time, 
        $appointment_id
    ]);
    header("Location: user_appointment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <style>
        /* Import Ananda Black Font */
        @font-face {
            font-family: 'Ananda Black';
            src: url('fonts/AnandaBlackPersonalUseRegular-rg9Rx.ttf') format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and overall layout */
        body {
            font-family: 'Poppins', sans-serif;
            background: #000;
            color: #ffd700;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Header Styles */
        header {
            background: linear-gradient(to right, #1a1a1a, #000);
            color: #ffd700;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(255, 215, 0, 0.5);
        }

        header h1 {
            font-size: 2.8rem;
            letter-spacing: 2px;
        }

        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        nav ul li {
            margin: 10px 15px;
        }

        nav ul li a {
            color: #ffd700;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            color: #fff;
            transform: scale(1.1);
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 40px;
            background: linear-gradient(to bottom, #1a1a1a, #000);
            border-radius: 12px;
            margin: 30px auto;
            width: 85%;
            max-width: 700px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        .edit-form {
            padding: 5px;
            border-radius: 12px;
            text-align: justify; 
        }

        .edit-form h2 {
            font-size: 2rem;
            color: #ffd700;
            margin-bottom: 50px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ffd700;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
        }

        /* Style for input fields */
        input[type="text"], input[type="email"], input[type="date"], input[type="time"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ffd700;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #333;
            color: #ffd700;
        }

        /* Style for input fields when focused */
        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="time"]:focus {
            border-color: #fff;
            background-color: #444;
        }

        /* Style for labels */
        label {
            display: block;
            margin-bottom: 10px;
        }

        /* Style for button */
        button[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #ffd700;
            cursor: pointer;
            font-size: 16px;
        }

        /* Style for button when hovered */
        button[type="submit"]:hover {
            background-color: #444;
        }
    </style>
</head>
<body>

<header>
    <h1><span class="styled-m">M</span>arimar Beauty Salon</h1> <!-- Styled 'M' in the header -->
    <nav>
        <ul>
            <li><a href="user_dashboard.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="branches.php">Branches</a></li>
            <li><a href="careers.php">Careers</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="edit-form">
        <h2>Edit Appointment</h2>
        <form action="" method="post">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $appointment['full_name']; ?>">
            <br>
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo $appointment['contact_number']; ?>">
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $appointment['email']; ?>">
            <br>
            <label for="technician_id">Technician ID:</label>
            <input type="text" id="technician_id" name="technician_id" value="<?php echo $appointment['technician_id']; ?>">
            <br>
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>">
            <br>
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" id="appointment_time" name="appointment_time" value="<?php echo $appointment['appointment_time']; ?>">
            <br>
            <button type="submit" name="save_changes">Save Changes</button>
        </form>
    </div>
</main>

<footer>
    <p> 2025 Marimar Beauty Salon</p>
</footer>

</body>
</html>