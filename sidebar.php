<?php 
// Define active page for highlighting current menu item
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../css/navigation_bar.css">

<!-- Sidebar Container -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo" onclick="location.href='/Royalty/Management/dashboard.php';">
            <img src="/Royalty/global_theme/assets/system_logo.png" alt="RealEstate Logo">
        </div>
        <button class="close-btn" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <ul class="menu">
        <li>
            <a href="../pages/dashboard.php" class="menu-btn <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#" class="menu-btn <?php echo ($current_page == 'register_caretaker.php' || $current_page == 'managecaretaker.php') ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Caretakers <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="submenu">
                <li><a href="../pages/register_caretaker.php" class="<?php echo ($current_page == 'register_caretaker.php') ? 'active' : ''; ?>">Add Caretakers</a></li>
                <li><a href="../pages/managecaretaker.php" class="<?php echo ($current_page == 'managecaretaker.php') ? 'active' : ''; ?>">Manage Caretakers</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="menu-btn <?php echo ($current_page == 'add_property.php' || $current_page == 'view_property.php') ? 'active' : ''; ?>">
                <i class="fas fa-building"></i> Properties <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="submenu">
                <li><a href="../pages/add_property.php" class="<?php echo ($current_page == 'add_property.php') ? 'active' : ''; ?>">Add Property</a></li>
                <li><a href="../pages/view_property.php" class="<?php echo ($current_page == 'view_property.php') ? 'active' : ''; ?>">View Properties</a></li>
                <li><a href="../pages/manage_properties.php" class="<?php echo ($current_page == 'view_property.php') ? 'active' : ''; ?>">Manage Properties</a></li>
                <li><a href="../pages/property_google_selection.php" class="<?php echo ($current_page == 'view_property.php') ? 'active' : ''; ?>">Property Allocation Location</a></li>
                <li><a href="../pages/property_view_location.php" class="<?php echo ($current_page == 'view_property.php') ? 'active' : ''; ?>">View Properties Locations</a></li>
            </ul>
        </li>
        <li>
            <a href="../pages/manage_services.php" class="<?php echo ($current_page == 'manage_services.php') ? 'active' : ''; ?>"><i class="fas fa-cogs"></i> Services</a>
        </li>
        <li>
            <a href="../pages/edit_about.php" class="<?php echo ($current_page == 'edit_about.php') ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i> Edit About-us</a>
        </li>
        <li>
            <a href="../pages/view_tenants.php" class="<?php echo ($current_page == 'edit_about.php') ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i> View Tenants</a>
        </li>
        <li>
            <a href="../../../global_theme/pages/homepage.php" class="<?php echo ($current_page == 'edit_about.php') ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i>Logout</a>
        </li>
    </ul>
</div>

<!-- Sidebar Toggle Button -->
<button class="open-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Loading Animation -->
<div class="loading-overlay">
    <div class="loading-spinner">
        <i class="fas fa-star"></i>
    </div>
</div>

<script src="../logic/js/sidebar.js"></script>