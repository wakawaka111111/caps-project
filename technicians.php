<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establish PDO database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=nail_salon_admin', 'kapoy', '123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Query the database for technicians
try {
    $technicians = $pdo->query("SELECT id, name, image_url, available_times FROM technicians")->fetchAll(PDO::FETCH_ASSOC);
   
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    exit();
}

// Start the session
session_start();

// If the user is coming from another page, store the current page as the previous page
if (isset($_SESSION['current_page'])) {
    $_SESSION['previous_page'] = $_SESSION['current_page'];
}

// Store the current page as the current page
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Technicians</title>
    <style>
        /* Import Ananda Black Font */
        @font-face {
            font-family: 'Ananda Black';
            src: url('fonts/AnandaBlackPersonalUseRegular-rg9Rx.ttf') format('truetype');
        }

        /* General Reset and Body Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #000;
            color: #ffd700;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

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
            display: flex;
            flex-direction: column;
        }

        footer {
            background: linear-gradient(to right, #1a1a1a, #000);
            color: #ffd700;
            text-align: center;
            padding: 15px 0;
            font-size: 1.1rem;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ffd700;
        }

        button {
            padding: 5px 10px;
            background: #ffd700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #b8860b;
        }

        table img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .styled-m {
            font-family: 'Ananda Black', serif; /* Use the Ananda Black font */
            font-size: 3rem; /* Adjust size as necessary */
            color: #ffd700; /* Match the primary color */
            text-shadow: 2px 2px 8px rgba(255, 215, 0, 0.5); /* Optional shadow */
            font-weight: bold; /* Make it bold */
        }

        .back-button {
            background: #ffd700;
            width: 30%;
            color: #000;
            border: none;
            padding: 10px 10x;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background:rgb(249, 5, 25);
        }
    </style>
</head>
<body>

<header>
    <h1><span class="styled-m">M</span>arimar Beauty Salon</h1> <!-- Use styled 'M' in the header -->
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
    <h2>Available Technicians</h2>
    <?php if (!empty($technicians)): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Available Times</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($technicians as $technician): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($technician['name']); ?></td>
                        <td style="width: 150px"><img src="<?php echo htmlspecialchars($technician['image_url']); ?>" alt="<?php echo htmlspecialchars($technician['name']); ?>"></td>
                        <td><?php echo htmlspecialchars($technician['available_times']); ?></td>
                        <td>
                            <form action="user_appointment.php" method="GET">
                                <input type="hidden" name="technician_id" value="<?php echo htmlspecialchars($technician['id']); ?>">
                                <button type="submit">Select</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No technicians found.</p>
    <?php endif; ?>
    <br>
    <a href="#" onclick="goBack()" class="back-button">Back to Previous Page</a>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</main>

<footer>
    <p>&copy; 2025 Marimar Salon Services</p>
</footer>

</body>
</html>