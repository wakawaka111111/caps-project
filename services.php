<?php
    // Start the session
    session_start();
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        header('Location: admin_login.html');
        exit();
    }
    // Connection to MySQL database
    $conn = new mysqli("localhost", "kapoy", "123456", "nail_salon_admin");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marimar Beauty Salon - Services Management</title>
    <link rel="stylesheet" type="text/css" href="styles_user.css">
</head>
<style>
    /* Global Styles */
    body {
        font-family: 'Poppins', sans-serif;
        background: #000; /* Black background */
        color: #D6AF2E; /* Metallic Gold */
        text-align: center;
        margin: 0; 
        padding: 20px;
    }

    /* Header Styles */
    header {
        background: linear-gradient(to right, #1a1a1a, #000); /* Dark gradient */
        padding: 20px 10%; 
        box-shadow: 0 4px 10px rgba(215, 175, 46, 0.5); /* Metallic Gold Shadow */
        display: flex;
        flex-direction: column; 
        align-items: center; 
    }

    .logo {
        width: 80px; 
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #D6AF2E; /* Metallic Gold */
    }

    .header-title {
        margin: 10px 0; 
    }

    h1 {
        font-size: 2.5rem; 
        font-family: 'Playfair Display', serif;
        letter-spacing: 2px;
        text-shadow: 2px 2px 8px rgba(215, 175, 46, 0.5); /* Metallic Gold Shadow */
    }

    nav ul {
        list-style-type: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap; 
        justify-content: center; 
    }

    nav ul li {
        margin: 5px 10px; 
    }

    nav ul li a {
        color: #D6AF2E; /* Metallic Gold */
        font-size: 1rem; 
        text-decoration: none; 
        font-weight: 500; 
        transition: color 0.3s ease, transform 0.3s ease; 
    }

    nav ul li a:hover {
        color: #FFD700; /* Brighter Gold on hover */
        transform: scale(1.1); 
    }

    /* Services Container Styles */
    .services-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
        gap: 20px; 
        margin-top: 20px; 
        justify-items: center; 
    }

    /* Service Box Styles */
    .service-box {
        background-color: #1a1a1a; 
        border: 2px solid #D6AF2E; /* Metallic Gold */
        border-radius: 10px; 
        padding: 20px; 
        text-align: center; 
        width: 100%;
        box-shadow: 0 4px 10px rgba(215, 175, 46, 0.5); /* Metallic Gold Shadow */
    }

    .service-box .service-id {
        font-weight: bold;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .service-box .service-name {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .service-box .view-btn {
        display: inline-block; 
        background: #D6AF2E; /* Metallic Gold */
        color: #000; /* Black text */
        padding: 10px 20px; 
        font-weight: bold; 
        text-decoration: none; 
        border-radius: 5px; 
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .service-box .view-btn:hover {
        background: #FFD700; /* Brighter Gold on hover */
        transform: scale(1.05); 
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        h1 {
            font-size: 2rem; 
        }

        nav ul li {
            margin: 5px 5px; 
        }
    }
</style>
<body>
    <header>
        <img src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/277308303_408654257737184_3382153348905773962_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFQU7g1qQBxnDJpAlr_m1_Sam8OKL3JKE9qbw4ovckoT-ehH_P5Votel6XGqxTCWCznJPJd6Nz_E2_zqCv8o959&_nc_ohc=A1hZOvauAHoQ7kNvgEkwCWK&_nc_oc=AdgZsX4F92MGhFdVkTeuMTg9j4oiAEYKmogr_v0QYqcLwiAGcqZgoP5FDCKRC7IGUdc&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=AXh8vW-yhd0ewGFza7TkBVA&oh=00_AYBCrErBry30QVClsrauTjmO89Kyj0uljub_zE-WN_2oPw&oe=67C9AC34" 
                alt="Salon Logo" 
                class="logo">
        <div class="header-title">
        <h1>Offered Services</h1>
        </div>
        <nav>
            <ul>
            <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="Gallery.html">Gallery</a></li>
                <li><a href="franchise.php">Franchise</a></li>
                <li><a href="careers.php">Careers</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <br>
    <div class="services-container">

        <?php
            // Create an array that maps each service name to its corresponding page
            $service_pages = array(
                'Hair Services' => 'hair_services.php',
                'Nail Services' => 'nail_services.php',
                'Wax & Lashes Services' => 'wax_lashes_services.php',
                'Hair Extensions' => 'hair_extensions.php',
                'Embroidery Services' => 'embroidery_services.php',
                'Warts Removal' => 'warts_removal.php',
                'Tattoo Removal' => 'tattoo_removal.php',
                'Facial Treatment' => 'facial_treatment.php',
            );

            // Display all services
            $query = "SELECT * FROM services";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='service-box'>";
                    echo "<p class='service-name'> " . $row['service_name'] . "</p>";
                    echo "<p class='service-description'> " . $row['service_description'] . "</p>";
                    echo "<a href='" . (isset($service_pages[$row['service_name']]) ? $service_pages[$row['service_name']] : '#') . "' class='view-btn'>See More</a>";
                    echo "</div>";
                }
            } else {
                echo "No services found.";
            }
            
            $conn->close();
        ?>
    </div>
</body>
</html>