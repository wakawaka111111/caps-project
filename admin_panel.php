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

// Move past appointments to history and delete from the main table
$move_sql = "INSERT INTO appointment_history (full_name, appointment_date, appointment_time, status, contact_number, email)
             SELECT full_name, appointment_date, appointment_time, status, contact_number, email
             FROM appointments
             WHERE appointment_date < CURDATE() OR 
                   (appointment_date = CURDATE() AND appointment_time < CURTIME())";

$delete_sql = "DELETE FROM appointments WHERE appointment_date < CURDATE() OR 
               (appointment_date = CURDATE() AND appointment_time < CURTIME())";

// Execute moving and deleting queries
$conn->query($move_sql);
$conn->query($delete_sql);

// Update view_history.php to display the moved appointments
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #000;
            color: #ffd700;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            position: fixed;
            left: -300px;
            top: 0;
            height: 100%;
            transition: left 0.3s ease-in-out;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            background: #333;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar h2 {
            margin-top: 0;
            color: #ffd700;
            margin-bottom: 20px;
        }

        .sidebar .admin-item {
            margin-bottom: 15px;
        }

        .sidebar .admin-item a, 
        .sidebar .admin-item button {
            text-decoration: none;
            width: 75%;
            padding: 10px 15px;
            background: #ffd700;
            color: #000;
            display: block;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .sidebar .admin-item a:hover, 
        .sidebar .admin-item button:hover {
            background: #fff;
            transform: scale(1.05);
        }

        /* Main Content Styles */
        main {
            flex-grow: 1;
            padding: 40px;
            background-color: #1a1a1a;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(255, 215, 0, 0.5);
            margin: 30px 20px;
            overflow-y: auto;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar.show + main {
            margin-left: 250px;
        }

        h1 {
            font-size: 2.5rem; 
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
            text-shadow: 2px 2px 8px rgba(255, 215, 0, 0.5);
            margin: 20px 0;
            text-align: center;
        }

        .admin-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #2a2a2a;
            border-radius: 8px;
        }

        .admin-box h2 {
            margin-bottom: 15px;
            color: #ffd700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ffd700;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #444;
            color: #ffd700;
        }

        /* Toggle Button */
        .toggle-sidebar {
            cursor: pointer;
            background: #ffd700;
            color: #000;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            transition: background 0.60s ease;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .toggle-sidebar:hover {
            background: #fff;
        }

        footer {
            background: #1a1a1a;
            color: #ffd700;
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(255, 215, 0, 0.5);
            width: 100%;
            position: relative;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                left: -100%;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar.show + main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<button class="toggle-sidebar" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar">
    <br>

    </br>
    <div class="admin-item">
        <a href="sales.php">Booking analytics</a>
    </div>
    
    <div class="admin-item">
        <a href="manage_services.php">Manage Services</a>
    </div>

    <div class="admin-item">
        <form action="view_history.php" method="GET">
            <button type="submit">View Appointment History</button>
        </form>
    </div>
    
    <div class="admin-item">
        <form action="get_data.php" method="POST">
            <button type="submit">Appointments by Status</button>
        </form>
    </div>
    
    <div class="admin-item">
        <form action="admin_logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    
</div>

<main>
    <h1>Admin Panel</h1>
    <div class="admin-box">
        <h2>Upcoming Appointments</h2>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php
            $sql = "SELECT full_name, contact_number, email, appointment_date, appointment_time FROM appointments 
                    WHERE appointment_date >= CURDATE() 
                    OR (appointment_date = CURDATE() AND appointment_time >= CURTIME()) 
                    ORDER BY appointment_date ASC, appointment_time ASC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $formattedDate = (new DateTime($row["appointment_date"]))->format('F j, Y');
                    // Convert the time to 12-hour format
                    $appointmentTime = date("h:i A", strtotime($row["appointment_time"]));
                    echo "<tr>
                            <td>" . htmlspecialchars($row["full_name"]) . "</td>
                            <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                            <td>" . htmlspecialchars($row["email"]) . "</td>
                            <td>{$formattedDate}</td>
                            <td>{$appointmentTime}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No upcoming appointments.</td></tr>";
            }
            ?>
        </table>
    </div>
</main>

<footer>
    <p> 2025 Marimar Beauty Salon</p>
</footer>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
    }
</script>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>