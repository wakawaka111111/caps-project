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

// Add service
if (isset($_POST['add_service'])) {
    $service_name = $_POST['service_name'];
    $service_description = $_POST['service_description'];
    $service_price = $_POST['service_price'];

    $query = "INSERT INTO services (service_name, service_description, service_price) VALUES ('$service_name', '$service_description', '$service_price')";
    $result = $conn->query($query);

    if ($result) {
        echo "Service added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Edit service
if (isset($_POST['edit_service'])) {
    $service_id = $_POST['service_id'];
    $sql = "SELECT * FROM services WHERE service_id = '$service_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Update service
if (isset($_POST['update_service'])) {
    $service_id = $_POST['service_id'];
    $service_name = $_POST['service_name'];
    $service_description = $_POST['service_description'];
    $service_price = $_POST['service_price'];

    $query = "UPDATE services SET service_name = '$service_name', service_description = '$service_description', service_price = '$service_price' WHERE service_id = '$service_id'";
    $result = $conn->query($query);

    if ($result) {
        echo "Service updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete service
if (isset($_POST['delete_service'])) {
    $service_id = $_POST['service_id'];

    $query = "DELETE FROM services WHERE service_id = '$service_id'";
    $result = $conn->query($query);

    if ($result) {
        echo "Service deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
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

        /* Service Boxes */
        .service-box {
            display: inline-block;
            width: 45%;
            margin: 10px;
            padding: 20px;
            background: #2a2a2a;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(255, 215, 0, 0.5);
            vertical-align: top;
        }

        .service-box h2 {
            margin-top: 0;
            color: #ffd700;
        }

        .service-box form {
            margin-top: 20px;
        }

        .service-box input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background: #1a1a1a;
            color: #fff;
        }

        .service-box input[type="submit"] {
            padding: 10px 20px;
            background: #ffd700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

            .service-box {
                width: 100%;
                margin: 10px 0;
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
        <a href="sales.php">Sales</a>
    </div>
    <div class="admin-item">
        <form action="view_history.php" method="GET">
            <button type="submit">View Appointment History</button>
        </form>
    </div>
    <div class="admin-item">
        <form action="admin_logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    <div class="admin-item">
        <a href="admin_panel.php">Admin Panel</a>
    </div>
</div>

<main>
    <h1>Manage Services</h1>
    <div class="admin-box">
        <h2>Services</h2>
        <table>
            <tr>
                <th>Service ID</th>
                <th>Service Name</th>
                <th>Service Description</th>
                <th>Service Price</th>

                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM services";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['service_id'] . "</td>";
                    echo "<td>" . $row['service_name'] . "</td>";
                    echo "<td>" . $row['service_description'] . "</td>";
                    echo "<td>" . $row['service_price'] . "</td>";
                    echo "<td>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='service_id' value='" . $row['service_id'] . "'>";
                    echo "<input type='submit' name='edit_service' value='Edit'>";
                    echo "</form>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='service_id' value='" . $row['service_id'] . "'>";
                    echo "<input type='submit' name='delete_service' value='Delete'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No services found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="service-box">
        <h2>Add Service</h2>
        <form action="" method="post">
            <label for="service_name">Service Name:</label>
            <input type="text" name="service_name"><br><br>
            <label for="service_description">Service Description:</label>
            <input type="text" name="service_description"><br><br>
            <label for="service_Price">Service Price:</label>
            <input type="text" name="service_price"><br><br>

            <input type="submit" name="add_service" value="Add Service">
        </form>
    </div>
    <div class="service-box">
        <?php 
        if (isset($_POST['edit_service'])) {
            $service_id = $_POST['service_id'];
            $sql = "SELECT * FROM services WHERE service_id = '$service_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($row) {
                echo "<h2>Edit Service</h2>";
                echo "<form action='' method='post'>";
                echo "<label for='service_name'>Service Name:</label>";
                echo "<input type='text' name='service_name' value='" . $row['service_name'] . "'><br><br>";
                echo "<label for='service_description'>Service Description:</label>";
                echo "<input type='text' name='service_description' value='" . $row['service_description'] . "'><br><br>";
                echo "<label for='service_price'>Service Price:</label>";
                echo "<input type='text' name='service_price' value='" . $row['service_price'] . "'><br><br>";
                echo "<input type='hidden' name='service_id' value='" . $row['service_id'] . "'>";
                echo "<input type='submit' name='update_service' value='Update Service'>";
                echo "</form>";
            } else {
                echo "Service not found.";
            }
        }
        ?>
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