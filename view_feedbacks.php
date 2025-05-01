<?php
include '../../Management/php/config/db.php';
$feedbacks = $conn->query("SELECT * FROM tenant_feedbacks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tenant Feedbacks</title>
    <link rel="stylesheet" href="../themes/nav_bar.css">
    <link rel="stylesheet" href="../themes/loading.css">
    <style>
 body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 100px 40px 40px 40px; /* Top padding to clear the navbar */
    background: #fafafa;
    min-height: 100vh;
    background-size: cover;
    background-position: center;
    animation: backgroundChange 20s infinite;
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

h1 {
    text-align: center;
    color: #d6336c;
    margin: 0 auto 30px auto;
    font-size: 2.5rem;
    font-weight: bold;
    backdrop-filter: blur(5px); /* Light blur behind heading */
    background: rgba(255, 255, 255, 0.6); /* Light white for clarity */
    display: inline-block;
    padding: 10px 30px;
    border-radius: 12px;
}



        /* Animation to change background images every 20 seconds */
        /*
        @keyframes backgroundChange {
            0% {
                background-image: url('https://i.pinimg.com/736x/e4/48/33/e44833167de8ae6fe5ccd780b2f31350.jpg');
            }
            33% {
                background-image: url('https://i.pinimg.com/236x/06/7a/73/067a73c32eb370207525f8523dc777b9.jpg');
            }
            66% {
                background-image: url('https://jenganami.com/wp-content/uploads/2021/09/gaurav-dhiman-KiBtTuPtsHA-unsplash-1-1160x773.jpg');
            }
            100% {
                background-image: url('https://jenganami.com/wp-content/uploads/2021/09/andrea-davis-BVQmegLZGGE-unsplash-1160x773.jpg');
            }
        }
*/
       

        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns */
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feedback-card {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            backdrop-filter: blur(10px); /* Adds blur effect for background */
        }

        .feedback-card h3 {
            margin: 0;
            color: #d6336c;
        }

        .stars {
            color: #ffcc00;
            font-size: 20px;
            margin: 10px 0;
        }

        .feedback-card p {
            margin: 0;
            line-height: 1.6;
        }

        .feedback-time {
            font-size: 12px;
            color: gray;
            margin-top: 8px;
        }
        /* Responsive */
@media (max-width: 768px) {
    .nav-links {
        position: fixed;
        top: 80px;
        right: 20px;
        background: rgba(0, 0, 0, 0.8);
        flex-direction: column;
        padding: 20px;
        border-radius: 5px;
        display: none;
    }

    .nav-links.active {
        display: flex;
    }

    .mobile-menu-btn {
        display: block;
    }

    .hero-title {
        font-size: 2.5rem;
    }
}


    </style>
</head>

<body>
    
<?php include 'navigation.php'; ?> 
     <!-- Loading Overlay -->
     <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <h1>Tenant Feedbacks</h1>
    <div class="container">
        <?php while ($fb = $feedbacks->fetch_assoc()): ?>
            <div class="feedback-card">
                <h3><?php echo htmlspecialchars($fb['tenant_name']); ?></h3>
                <div class="stars">
                    <?php
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $fb['rating'] ? "★" : "☆";
                        }
                    ?>
                </div>
                <p><?php echo nl2br(htmlspecialchars($fb['feedback'])); ?></p>
                <div class="feedback-time"><?php echo date("F j, Y, g:i a", strtotime($fb['created_at'])); ?></div>
            </div>
        <?php endwhile; ?>
    </div>
    <script src="/Royalty/global_theme/functions/script.js"></script>
</body>
</html>
