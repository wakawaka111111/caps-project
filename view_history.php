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
    <title>Appointment History</title>
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

        h1 {
            font-size: 2.5rem; 
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
            text-shadow: 2px 2px 8px rgba(255, 215, 0, 0.5);
            margin: 20px 0;
            text-align: center;
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
        
        a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
        }
        
        a:hover {
            color: #fff;
        }
        
        .update-button {
            background-color: #1a1a1a;
            color:rgb(250, 250, 250);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px auto;
            display: block;
        }
        
        .update-button:hover {
            background-color:rgba(9, 255, 0, 0.66);
        }
        
        .back-button {
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin: 30px auto;
            display: block;
            background-color:rgb(14, 2, 248);
            color:rgb(12, 12, 11);
            padding: 10px 20px;
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<br>
<a href="admin_panel.php" class="back-button">Back to Admin Panel</a>

<main>
    <h1>Appointment History</h1>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'updated') {
        echo "<script>alert('Status updated successfully!');</script>";
        echo "<script>window.location.href = 'view_history.php';</script>";
    } ?>
    <form action="update_status.php" method="post">
        <table>
            <tr>
                <th>Full Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
            <?php
            $sql = "SELECT id, full_name, contact_number, email, appointment_date, appointment_time, status FROM appointment_history";
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
                            <td>";
                    if (empty($row["status"])) {
                        echo "No Status";
                    } else {
                        switch ($row["status"]) {
                            case 'Pending':
                                echo "Pending";
                                break;
                            case 'Confirmed':
                                echo "Confirmed";
                                break;
                            case 'Completed':
                                echo "Completed";
                                break;
                            case 'Canceled':
                                echo "Canceled";
                                break;
                            default:
                                echo "No Status";
                                break;
                        }
                    }
                    echo "</td>
                            <td>";
                    echo '<select name="status_' . $row["id"] . '">';
                    echo '<option value="Pending" ' . ($row["status"] == "Pending" ? 'selected' : '') . '>Pending</option>';
                    echo '<option value="Completed" ' . ($row["status"] == "Completed" ? 'selected' : '') . '>Completed</option>';
                    echo '<option value="Canceled" ' . ($row["status"] == "Canceled" ? 'selected' : '') . '>Canceled</option>';
                    echo '</select>';
                    echo "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No appointments in history.</td></tr>";
            }
            ?>
        </table>
        <button type="submit" class="update-button">Update All</button>
    </form>
</main>

<footer>
    <p> 2025 Marimar Beauty Salon</p>
</footer>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>