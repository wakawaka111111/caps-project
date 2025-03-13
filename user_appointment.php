<?php
session_start();

unset($_SESSION['previous_page']);
unset($_SESSION['current_page']);

// Establish PDO database connection
$pdo = new PDO('mysql:host=localhost;dbname=nail_salon_admin', 'kapoy', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get technician ID from the query parameter
$technician_id = isset($_GET['technician_id']) ? $_GET['technician_id'] : null;

// Fetch the selected technician's details
$technician = null;
if ($technician_id) {
    $stmt = $pdo->prepare("SELECT id, name FROM technicians WHERE id = :id");
    $stmt->execute(['id' => $technician_id]);
    $technician = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if technician was found
if ($technician) {
    $technician_name = $technician['name'];
} else {
    $technician_name = 'Any Technician';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
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

        /* Appointment Form */
        .appointment-form {
            padding: 25px;
            background: rgba(25, 25, 25, 0.9);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        .appointment-form h2 {
            font-size: 2rem;
            color: #ffd700;
            margin-bottom: 20px;
        }

        .appointment-form label {
            display: block;
            margin: 12px 0 6px;
            font-size: 1.1rem;
        }

        .appointment-form input, .appointment-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ffd700;
            background: #111;
            color: #ffd700;
            border-radius: 5px;
            font-size: 1rem;
        }

        .appointment-form input::placeholder {
            color: #b8860b;
        }

        /* Button Styling */
        .appointment-form button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, #ffd700, #b8860b);
            color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .appointment-form button:hover {
            background: rgb(28, 3, 249);
            color: white;
            transform: scale(1.05);
        }

        .back-button {
            background-color: #ff3d3d;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px 0;
        }

        .back-button:hover {
            background-color: #cc0000;
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
            font-family: 'Ananda Black', serif; /* Use the Ananda Black font */
            font-size: 2.4rem; /* Adjust size as necessary */
            color: #ffd700; /* Match the primary color */
            text-shadow: 2px 2px 8px rgba(255, 215, 0, 0.5); /* Optional shadow */
            font-weight: bold; /* Make it bold */
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        <h2>Appointment Form</h2>
        <form method="POST" action="user_submit_appointment.php">
            <input type="hidden" name="technician_id" value="<?php echo htmlspecialchars($technician_id); ?>">

            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter your name" required>
            
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" placeholder="+63 9XXXXXXXXX" required 
                   pattern="^(\+63|0)9[0-9]{9}$|^(02|\+63-2)[0-9]{7}$" 
                   title="Please enter a valid Philippine mobile or landline number (e.g., 09123456789 or 02-1234567)">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="appointment_date">Preferred Appointment Date:</label>
            <input type="text" id="appointment_date" name="appointment_date" readonly>

            <label for="appointment_time">Preferred Appointment Time:</label>
            <input type="time" id="appointment_time" name="appointment_time" value="<?php echo $appointment['appointment_time']; ?>">
            </select>

            <button type="submit">Book Appointment</button>
            <button class="back-button" onclick="history.back()">Back</button>
        </form>
    </div>
</main>

<footer>
    <p> 2025 Marimar Beauty Salon</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#appointment_date", {
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        enableTime: true,
        time_24hr: false,
        onChange: function(selectedDates, dateStr, instance) {
            let selectedDate = new Date(selectedDates[0]);
            let dayOfWeek = selectedDate.getDay();
            let availableTimes = [];

            if (dayOfWeek === 0) { // Sunday
                availableTimes = [
                    "09:00 AM", "09:30 AM", "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM", 
                    "12:00 PM", "12:30 PM", "01:00 PM", "01:30 PM", "02:00 PM", "02:30 PM", 
                    "03:00 PM", "03:30 PM", "04:00 PM", "04:30 PM", "05:00 PM", "05:30 PM", 
                    "06:00 PM"
                ];
            } else { // Monday to Saturday
                availableTimes = [
                    "08:00 AM", "08:30 AM", "09:00 AM", "09:30 AM", "10:00 AM", "10:30 AM", 
                    "11:00 AM", "11:30 AM", "12:00 PM", "12:30 PM", "01:00 PM", "01:30 PM", 
                    "02:00 PM", "02:30 PM", "03:00 PM", "03:30 PM", "04:00 PM", "04:30 PM", 
                    "05:00 PM", "05:30 PM", "06:00 PM"
                ];
            }

            let appointmentTimeSelect = document.getElementById('appointment_time');
            appointmentTimeSelect.innerHTML = '';
            availableTimes.forEach(time => {
                let option = document.createElement('option');
                option.value = time;
                option.text = time;
                appointmentTimeSelect.appendChild(option);
            });
        }
    });
</script>

</body>
</html>