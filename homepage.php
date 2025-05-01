<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Management</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="/Royalty/global_theme/themes/homepage.css">



    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="header-container">
            <div class="logo">
            <img src="/Royalty/global_theme/assets/system_logo.png" alt="Real Estate Logo">
            </div>
            <h1>Welcome to Royalty Real Estate</h1>
            <p>Managing Your Properties with Excellence</p>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Find, Manage, & Track Properties Seamlessly</h2>
            <p>Join our real estate network and experience top-tier property management.</p>
            
            <!-- Animated Button -->
            <div class="dropdown">
                <button class="dropdown-btn">Choose Role</button>
                <div class="dropdown-content">
                    <a href="/Royalty/Caretaker/php/Authentication/login_caretaker.php"><i class="fas fa-user"></i> Caretaker</a>
                    <a href="../../Management/php/Authentication/signup.php"><i class="fas fa-user-tie"></i> Management</a>
                    <a href="../../index.php"><i class="fas fa-user-tie"></i> Homepage</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Images Section -->
    <section class="gallery">
        <div class="gallery-item"><img src="/Royalty/global_theme/assets/image1Bedsitter.jpg" alt="Modern House"></div>
        <div class="gallery-item"><img src="/Royalty/global_theme/assets/image2Bedsitter.jpg" alt="Luxury Apartment"></div>
        <div class="gallery-item"><img src="/Royalty/global_theme/assets/image3Bedsitter.jpg" alt="Classic Villa"></div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Royalty Real Estate. All Rights Reserved.</p>
    </footer>

</body>
</html>
