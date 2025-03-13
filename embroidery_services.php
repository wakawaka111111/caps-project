<?php
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
    <title>Embroidery Services</title>
    <link rel="stylesheet" type="text/css" href="styles_user.css">
</head>
<body>
    <button onclick="window.history.back()" class="back-btn">← Back</button>
    
    <header>
        <img src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/277308303_408654257737184_3382153348905773962_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFQU7g1qQBxnDJpAlr_m1_Sam8OKL3JKE9qbw4ovckoT-ehH_P5Votel6XGqxTCWCznJPJd6Nz_E2_zqCv8o959&_nc_ohc=1NhH-8OLuZsQ7kNvgHap5iQ&_nc_oc=Adi7nlMQwtLxRKqFwrUGjHiz6pN1sapI9zRbJt3KFt2cXSpf2khEfke57YXL48jlVy0&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=AwBJoBxAiG6O_gqmXsqWT4H&oh=00_AYDTIvQknhUEbUkZx60vb3N-I7uTE1ZmQ3dkA2h-5D7Rng&oe=67CCF7F4" 
        alt="Salon Logo" class="logo">
        <div class="header-title">
            <h1>Embroidery Services</h1>
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
        <!-- Specific Embroidery Services -->
        <div class="service-box">
            <h3>Eyebrow Embroidery</h3>
            <p>Enhance your eyebrows with a professional embroidery treatment.</p>
            <p>Price: ₱4,000 - ₱6,000 (includes consultation and aftercare)</p>
            <a href="technicians.php?service=eyebrow_embroidery" class="book-btn">Book Now</a>
        </div>
        <div class="service-box">
            <h3>Lip Embroidery</h3>
            <p>Perfect your pout with lip embroidery.</p>
            <p>Price: ₱3,500 - ₱5,500 (includes consultation and aftercare)</p>
            <a href="technicians.php?service=lip_embroidery" class="book-btn">Book Now</a>
        </div>
    </div>
</body>
</html>