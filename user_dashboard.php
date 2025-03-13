<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marimar Beauty Salon</title>
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   
    <style>
      
        @font-face {
            font-family: 'Ananda Black';
            src: url('fonts/AnandaBlackPersonalUseRegular-rg9Rx.ttf') format('truetype');
        }

    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1400&q=80');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #D6AF2E; 
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            animation: fadeIn 1s ease-in;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        header {
            background: linear-gradient(to right, rgba(26, 26, 26, 0.8), rgba(0, 0, 0, 0.8));
            color: #D6AF2E; 
            padding: 20px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideDown 1s ease-in-out;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid #D6AF2E; 
            transition: transform 0.3s ease-in-out;
        }

        .logo:hover {
            transform: scale(1.1);
            border: 3px solid #FFD700; 
        }

        .header-title {
            flex: 1;
            text-align: center;
        }

        header h1 {
            font-size: 2.8rem;
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
            text-shadow: 2px 2px 8px rgba(215, 175, 46, 0.5); 
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin-right: 40px;
        }

        nav ul li a {
            color: #D6AF2E; 
            font-size: 1.2rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            color: #FFD700; 
            transform: scale(1.1);
        }

        main {
            flex: 1;
            margin: 30px auto;
            width: 85%;
            max-width: 1200px;
            opacity: 0;
            animation: fadeIn 1.5s ease-in forwards;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            height: 100%;
        }

        #overview {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        #overview h2 {
            font-size: 2.8rem;
            color: #D6AF2E; 
            margin-bottom: 15px;
            font-weight: 700;
            text-align: center;
            padding: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        #overview p {
            font-size: 1.3rem;
            color: #ccc; 
            margin-top: 10px;
            font-weight: 300;
            text-align: center;
            max-width: 700px;
        }

        .styled-m {
            font-family: 'Ananda Black', serif;
            font-size: 3.5rem;
            color: #D6AF2E; 
            text-shadow: 2px 2px 8px rgba(215, 175, 46, 0.5); 
            font-weight: bold;
        }

        .header-m {
            font-family: 'Ananda Black', serif;
            font-size: 3.2rem;
            color: #D6AF2E; 
            text-shadow: 2px 2px 8px rgba(215, 175, 46, 0.5); 
            font-weight: bold;
        }

        .book-btn {
            display: inline-block;
            background:rgba(161, 125, 5, 0.83); 
            color: #000; 
            padding: 2px 8px;
            font-size: 1.3rem;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 30px;
            transition: background 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .book-btn:hover {
            background:rgba(255, 217, 0, 0.85); 
            transform: scale(1.05);
        }

        footer {
            background: linear-gradient(to right, rgba(26, 26, 26, 0.8), rgba(0, 0, 0, 0.8));
            color: #D6AF2E; 
            text-align: center;
            padding: 15px 0;
            font-size: 1.2rem;
            margin-top: auto;
        }

        footer p {
            margin: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 0 15px;
            }

            header {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .logo {
                width: 80px;
                height: 80px;
                margin-right: 0;
                margin-bottom: 10px;
            }

            header h1 {
                font-size: 2.2rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin: 10px 0;
            }

            nav ul li a {
                font-size: 1rem;
            }

            footer {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/277308303_408654257737184_3382153348905773962_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFQU7g1qQBxnDJpAlr_m1_Sam8OKL3JKE9qbw4ovckoT-ehH_P5Votel6XGqxTCWCznJPJd6Nz_E2_zqCv8o959&_nc_ohc=A1hZOvauAHoQ7kNvgEkwCWK&_nc_oc=AdgZsX4F92MGhFdVkTeuMTg9j4oiAEYKmogr_v0QYqcLwiAGcqZgoP5FDCKRC7IGUdc&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=AXh8vW-yhd0ewGFza7TkBVA&oh=00_AYBCrErBry30QVClsrauTjmO89Kyj0uljub_zE-WN_2oPw&oe=67C9AC34" 
        alt="Salon Logo" 
        class="logo">

        <div class="header-title">
            <h1><span class="header-m">M</span>arimar Beauty Salon</h1>
        </div>

        <nav>
            <ul>
                <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="franchise.php">Franchise</a></li>
                <li><a href="careers.php">Careers</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="overview">
            <h2>Welcome to <span class="styled-m">M</span>arimar Beauty Salon</h2>
            <p>Renew & Revive your natural beauty ✨</p>
            <a href="services.php" class="book-btn">Make an Appointment</a>
        </section>
    </main>

    <footer>
        <p>© 2025 Marimar Beauty Salon</p>
    </footer>
</body>
</html>