<?php
    // Start the session
    session_start();
    $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nail Services</title>
    <link rel="stylesheet" type="text/css" href="styles_user.css">
</head>
<style>
    body {
    font-family: 'Poppins', sans-serif;
    background-image: url('https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1400&q=80'); /* Background image */
    background-repeat: no-repeat;
    background-position: center center; /* Center the image */
    background-attachment: fixed; /* Keep the image fixed when scrolling */
    background-size: cover; /* Ensure the background covers the whole page */
    
}
</style>
<body>
    <button onclick="window.history.back()" class="back-btn">← Back</button>
    
    <header>
        <img src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/277308303_408654257737184_3382153348905773962_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFQU7g1qQBxnDJpAlr_m1_Sam8OKL3JKE9qbw4ovckoT-ehH_P5Votel6XGqxTCWCznJPJd6Nz_E2_zqCv8o959&_nc_ohc=1NhH-8OLuZsQ7kNvgHap5iQ&_nc_oc=Adi7nlMQwtLxRKqFwrUGjHiz6pN1sapI9zRbJt3KFt2cXSpf2khEfke57YXL48jlVy0&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=AwBJoBxAiG6O_gqmXsqWT4H&oh=00_AYDTIvQknhUEbUkZx60vb3N-I7uTE1ZmQ3dkA2h-5D7Rng&oe=67CCF7F4" 
        alt="Salon Logo" class="logo">
        <div class="header-title">
            <h1>Nail Services</h1>
        </div>
        <nav>
            <ul>
            <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="franchise.php">Franchise</a></li>
                <li><a href="careers.php">Careers</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <div class="services-container">
        <!-- Specific Nail Services -->
        <div class="service-box">
            <h3>Manicure</h3>
            <p>Get a professional manicure with your favorite nail polish.</p>
            <p>Price: ₱200 - ₱500</p>
            <a href="technicians.php?service=nail_manicure" class="book-btn">Book Now</a>
        </div>
        <div class="service-box">
            <h3>Pedicure</h3>
            <p>Relax and enjoy a pampering pedicure.</p>
            <p>Price: ₱300 - ₱800</p>
            <a href="technicians.php?service=nail_pedicure" class="book-btn">Book Now</a>
        </div>
        <div class="service-box">
            <h3>Nail Extension</h3>
            <p>Longer nails, endless possibilities.</p>
            <p>Price: ₱500 - ₱1,500</p>
            <a href="technicians.php?service=nail_extension" class="book-btn">Book Now</a>
        </div>
    </div>
</body>
</html>