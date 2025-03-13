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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
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
        table {
            width: 50%;
            margin: 10px auto;
            border-collapse: collapse;
            background: #1a1a1a;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ffd700;
        }
        table th {
            background: #333;
            color: #ffd700;
        }
        a {
            text-decoration: none;
            font-weight: bold;
            color: #ffd700;
        }
        a:hover {
            color: #fff;
        }
        a.back-button {
            
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
        #chart {
            width: 80%;
            margin: 20px auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header>
    <a href="admin_panel.php" class="back-button">Back to Admin Panel</a>
    <h1>Monthly Appointment Summary</h1>
</header>

<table>
    <tr>
        <th>Month</th>
        <th>Total Appointments</th>
    </tr>
    <?php
    $sql = "SELECT 
                YEAR(appointment_date) as year, 
                MONTH(appointment_date) as month, 
                COUNT(*) as total_appointments
            FROM 
                appointment_history
            WHERE 
                status = 'Completed'
            GROUP BY 
                YEAR(appointment_date), 
                MONTH(appointment_date)
            ORDER BY 
                YEAR(appointment_date) DESC, 
                MONTH(appointment_date) DESC";

    $result = $conn->query($sql);

    $months = array();
    $sales = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . date("F Y", mktime(0, 0, 0, $row['month'], 1, $row['year'])) . "</td>
                    <td>" . $row['total_appointments'] . "</td>
                  </tr>";
            $months[] = date("F Y", mktime(0, 0, 0, $row['month'], 1, $row['year']));
            $sales[] = $row['total_appointments'];
        }
    } else {
        echo "<tr><td colspan='2'>No sales report available.</td></tr>";
    }
    ?>
</table>

<canvas id="chart" width="400" height="200"></canvas>

<script>
    const ctx = document.getElementById('chart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Total Sales',
                data: <?php echo json_encode($sales); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
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