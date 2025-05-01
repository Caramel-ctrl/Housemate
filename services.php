<?php
include '../../Management/php/config/db.php';

// Fetch active services from the database
$services = $conn->query("SELECT * FROM property_services WHERE status = 'active' ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Our Services</title>
    <link rel="stylesheet" href="../themes/nav_bar.css">
    <link rel="stylesheet" href="../themes/loading.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fafafa;
            padding: 40px;
            animation: changeBackground 30s infinite;
            background-size: cover;
            background-position: center;
        }
        .navbar {
    position: fixed;
    top: 0; /* ← This is what ensures it's at the top */
    left: 0;
    width: 100%;
    height: 80px;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
/*

        @keyframeschangeBackground {
            0% {
                background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGINS8XqVDNF_iLHXUf2i6qMgWOr15TLIPbg&s');
            }
            33% {
                background-image: url('https://static01.nyt.com/images/2019/06/02/travel/31Frugal-Family-Hostels-1/oakImage-1556821275291-articleLarge.jpg?quality=75&auto=webp&disable=upscale');
            }
            66% {
