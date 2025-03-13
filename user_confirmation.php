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

$appointment_time = DateTime::createFromFormat('H:i:s', $appointment['appointment_time']);
$appointment_hour = (int)$appointment_time->format('H');

$hour_12_format = ($appointment_hour % 12) ? $appointment_hour % 12 : 12;
$minutes = $appointment_time->format('i');

// Force to display PM
$ampm = 'PM';

$display_time = "$hour_12_format:$minutes $ampm";

// Cancel Appointment
if (isset($_POST['cancel_appointment'])) {
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->execute([$appointment_id]);
    header("Location: user_appointment.php");
    exit();
}

// Edit Appointment
if (isset($_POST['edit_appointment'])) {
    header("Location: edit_appointment.php?appointment_id=$appointment_id");
    exit();
}

// Done button handler
if (isset($_POST['done'])) {
    header("Location: user_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Confirmation</title>
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

        .confirmation {
            padding: 5px;
            border-radius: 12px;
            text-align: justify; 
        }

        .confirmation h2 {
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

        /* Highlighted Note Style */
        .note {
            background-color: #ffcc00; /* Bright yellow for visibility */
            color: #000; /* Black text for contrast */
            padding: 10px;
            border-radius: 5px;
            display: block; /* Make it a block element */
            font-weight: bold; /* Make it bold */
            margin-bottom: 20px; /* Spacing below the note */
        }

        /* Footer */
        footer {
            background: linear-gradient(to right, #1a1a1a, #000);
            color: #ffd700;
            text-align: center;
            padding: 15px 0;
            font-size: 1.1rem;
        }

        .styled-m {
            font-family: 'Ananda Black', serif; 
            font-size: 2.4rem; 
            color: #ffd700; 
            text-shadow: 2px 2px 8px rgba(255, 215, 0, 0.5); 
            font-weight: bold; 
        }

        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.8); 
        }

        .modal-content {
            background-color: #1a1a1a;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #ffd700;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 800px;
            border-radius: 12px;
            color: #ffd700;
            text-align: left;
        }

        .close {
            color: #ffd700;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
        
        /* Button to open the modal */
        .open-modal {
            padding: 15px 30px;
            background: #ffd700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.3s;
            margin-top: 20px; /* Add some margin */
        }

        .open-modal:hover {
            background: #fff;
        }

        /* Button styles */
        .Cancel-button, .Edit-button, .Done-button {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            margin: 0 10px;
            transition: background 0.3s;
        }

        .Cancel-button {
            background-color: #f44336;
            color: #fff;
        }

        .Cancel-button:hover {
            background-color: #e91e63;
        }

        .Edit-button {
            background-color: #03a9f4;
            color: #fff;
        }

        .Edit-button:hover {
            background-color: #039be5;
        }

        .Done-button {
            background-color: #8bc34a;
            color: #fff;
        }

        .Done-button:hover {
            background-color: #7cb342;
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
    <div class="appointment-form">
        <h2>Appointment Confirmation</h2>
        <span class="note">Note: Take a screenshot of your appointment and present it to staff.</span>
        <table>
            <tr>
                <th>Full Name:</th>
                <td><?php echo $appointment['full_name']; ?></td>
            </tr>
            <tr>
                <th>Contact Number:</th>
                <td><?php echo $appointment['contact_number']; ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo $appointment['email']; ?></td>
            </tr>
            <tr>
                <th>Technician ID:</th>
                <td><?php echo $appointment['technician_id']; ?></td>
            </tr>
            <tr>
                <th>Appointment Date:</th>
                <td><?php echo $appointment['appointment_date']; ?></td>
            </tr>
            <tr>
                <th>Appointment Time:</th>
                <td><?php echo $display_time; ?></td>
            </tr>
        </table>
        <Br>
        <form action="" method="post">
            <button class="Cancel-button" type="submit" name="cancel_appointment">Cancel Appointment</button>
            <button class="Edit-button" type="submit" name="edit_appointment">Edit Appointment</button>
            <button class="Done-button" type="submit" name="done">Done</button>
        </form>
    </div>
</main>

<footer>
    <p> 2025 Marimar Beauty Salon</p>
</footer>

</body>
</html>