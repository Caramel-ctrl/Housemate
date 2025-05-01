<?php
$conn = new mysqli("localhost", "root", "", "test_page");

// Check if search parameter is set
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT id, name, cover_image FROM properties";
if (!empty($search)) {
    $sql .= " WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Properties</title>
    <link rel="stylesheet" href="../themes/nav_bar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--link rel="stylesheet" href="/Royalty/global_theme/themes/properties.css"-->
    <style>
        /* Animation and hover effects */
        /* Loading Animation */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.loading-overlay.active {
    opacity: 1;
    pointer-events: all;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

        .property-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 30px;
        }
        
        .property-card {
            width: 280px;
            height: 320px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: white;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            cursor: pointer;
            position: relative;
            animation: bounceIn 1s both;
        }
        
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .property-card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3), 
                        0 0 0 3px rgba(255, 215, 0, 0.5);
        }
        
        .property-card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: all 0.4s ease;
        }
        
        .property-card:hover img {
            transform: scale(1.1);
        }
        
        .property-name {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            padding: 20px 15px;
            font-size: 1.3rem;
            text-align: center;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
            transition: all 0.3s ease;
        }
        
        .property-card:hover .property-name {
            padding-bottom: 25px;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        }
        
        .search-container {
            display: flex;
            justify-content: center;
            padding: 30px 20px 10px;
        }
        
        .search-bar {
            width: 50%;
            padding: 12px 20px;
            border-radius: 30px;
            border: 2px solid #ddd;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .search-bar:focus {
            border-color: #FFD700;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            width: 55%;
        }
        
        /* Black Diamond Crystal Title Styling */
        .crystal-title {
            text-align: center;
            margin: 30px 0;
            font-size: 2.5rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
            width: 100%;
            color: transparent;
            background: linear-gradient(145deg, #000000, #2d2d2d, #000000);
            -webkit-background-clip: text;
            background-clip: text;
            text-shadow: 
                0 0 5px rgba(0, 0, 0, 0.3),
                0 0 10px rgba(80, 80, 80, 0.3);
        }
        
        .crystal-title::before,
        .crystal-title::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #555, transparent);
        }
        
        .crystal-title::before {
            left: 0;
            transform: translateX(-10px);
        }
        
        .crystal-title::after {
            right: 0;
            transform: translateX(10px);
        }
        
        .crystal-title span {
            position: relative;
            display: inline-block;
            padding: 0 20px;
        }
        
        .crystal-title span::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 4px;
            background: #FFD700;
            border-radius: 2px;
            box-shadow: 0 0 10px #FFD700;
        }
        
        .title-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }
    </style>
</head>
<?php include 'navigation.php'; ?>
<body>
<div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    <!--div class="title-container">
        <h2 class="crystal-title"><span>Our Apartments</span></h2>
    </div-->
    
    <!-- Search bar -->
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" class="search-bar" placeholder="Search apartments by name..." value="<?php echo htmlspecialchars($search); ?>">
        </form>
    </div>
    
    <div class="property-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="property-card" onclick="window.location.href='/Royalty/Tenants/php/Authentication/signup.php?id=<?php echo $row['id']; ?>'">
                <img src="data:image/jpeg;base64,<?php echo $row['cover_image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="property-name"><?php echo $row["name"]; ?></div>
            </div>
        <?php } ?>
    </div>

    <script>
        // Staggered animations for cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.property-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Focus search bar if there's a search term
            const searchInput = document.querySelector('.search-bar');
            if (searchInput.value) {
                searchInput.focus();
                searchInput.select();
            }
        });
    </script>
    <script src="global_theme/functions/script.js"></script>
</body>
</html>