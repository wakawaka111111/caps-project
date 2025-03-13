<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: admin_login.html');
    exit();
}

// Establish a connection to the database
$conn = new mysqli("localhost", "kapoy", "123456", "nail_salon_admin");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the database
$pending_data = array();
$completed_data = array();
$canceled_data = array();

for ($month = 1; $month <= 12; $month++) {
    $sql = "SELECT COUNT(*) as count FROM appointment_history WHERE status = 'Pending' AND MONTH(appointment_date) = '$month'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $pending_data[] = $row['count'];

    $sql = "SELECT COUNT(*) as count FROM appointment_history WHERE status = 'Completed' AND MONTH(appointment_date) = '$month'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $completed_data[] = $row['count'];

    $sql = "SELECT COUNT(*) as count FROM appointment_history WHERE status = 'Canceled' AND MONTH(appointment_date) = '$month'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $canceled_data[] = $row['count'];
}

// Output the data in a graph
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Appointment Analytics</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #000;
            color: #ffd700;
            text-align: center;
            margin: 0;
        }
        header {
            background: #333;
            color: #ffd700;
            padding: 20px;
            border-bottom: 2px solid #ffd700;
            position: relative;
        }
        .graph-container {
            width: 80%;
            margin: 20px auto;
        }
        .graph {
            width: 100%;
            height: 400px;
        }
        a {
            text-decoration: none;
            font-weight: bold;
            color: #ffd700;
        }
        a:hover {
            color: #fff;
        }
        .back-button {
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin: 10px auto;
            display: block;
            background-color:rgb(14, 2, 248);
            color:rgb(12, 12, 11);
            padding: 10px 20px;
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 1.2rem;
        
        }
        .back-button:hover {
            background-color: #444;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <a href="admin_panel.php" class="back-button" style="color: #ffd700;">Back to Admin Panel</a>
        <h1>Monthly Appointment Analytics</h1>
    </header>
    <div class="graph-container">
        <canvas class="graph" id="appointment-chart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('appointment-chart').getContext('2d');
        const appointmentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pending',
                    data: <?= json_encode($pending_data); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Completed',
                    data: <?= json_encode($completed_data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Canceled',
                    data: <?= json_encode($canceled_data); ?>,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php
$conn->close(); // Close the database connection
?>