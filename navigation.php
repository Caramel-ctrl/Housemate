<?php 
// Define active page for highlighting current menu item
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<!--link rel="stylesheet" href="../themes/nav_bar.css"-->

<!-- Navigation Component -->
<nav class="navbar">
    <div class="nav-container">
        <!-- Clickable Logo -->
        <div class="logo" onclick="location.href='/Royalty/global_theme/pages/homepage.php';" style="cursor: pointer;">
            <img src="/Royalty/global_theme/assets/system_logo.png" alt="RealEstate Logo">
        </div>

        <!-- Navigation Links with Icons -->
        <div class="nav-links">
            <a href="/Royalty/index.php" class="nav-link <?= $current_page == '/Royalty/index.php' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Homepage
            </a>
            <a href="/Royalty/global_theme/pages/properties.php" class="nav-link <?= $current_page == '/Royalty/global_theme/pages/properties.php' ? 'active' : '' ?>">
                <i class="fas fa-building"></i> Properties
            </a>
            <a href="/Royalty/global_theme/pages/view_feedbacks.php" class="nav-link <?= $current_page == '/Royalty/global_theme/pages/view_feedbacks.php' ? 'active' : '' ?>">
                <i class="fas fa-concierge-bell"></i> Feedback
            </a>
            <a href="/Royalty/global_theme/pages/about_us.php" class="nav-link <?= $current_page == '/Royalty/global_theme/pages/about_us.php' ? 'active' : '' ?>">
                <i class="fas fa-info-circle"></i> About Us
            </a>
            <a href="/Royalty/global_theme/pages/services.php" class="nav-link <?= $current_page == '/Royalty/global_theme/pages/services.php' ? 'active' : '' ?>">
                <i class="fas fa-handshake"></i> Services
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- JavaScript for Mobile Menu -->
<script>
function toggleMenu() {
    document.querySelector('.nav-links').classList.toggle('active');
}
</script>

<!-- Loading Overlay -->
<div class="loading-overlay">
    <div class="loading-spinner"></div>
</div>