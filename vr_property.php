<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "test_page");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get property ID
$property_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($property_id <= 0) die("Invalid property ID");

// Fetch images data
$stmt = $conn->prepare("SELECT images FROM properties WHERE id = ?");
if (!$stmt) die("Error preparing statement: " . $conn->error);

$stmt->bind_param("i", $property_id);
if (!$stmt->execute()) die("Error executing statement: " . $stmt->error);

$result = $stmt->get_result();
if (!$result || $result->num_rows === 0) die("No property found");

$row = $result->fetch_assoc();
$conn->close();

// Process images - try multiple formats
$images = [];
$blob_data = $row['images'];

// Method 1: Check if serialized PHP array
if ($unserialized = @unserialize($blob_data)) {
    if (is_array($unserialized)) $images = $unserialized;
} 
// Method 2: Check if JSON
elseif ($json_decoded = @json_decode($blob_data, true)) {
    if (is_array($json_decoded)) $images = $json_decoded;
}
// Method 3: Assume single image
else {
    $images = [$blob_data];
}

// Convert all images to base64
$base64_images = [];
foreach ($images as $img) {
    if (is_string($img)) {
        $base64_images[] = (base64_encode(base64_decode($img, true)) === $img) 
            ? $img 
            : base64_encode($img);
    }
}

// Generate room names
$room_names = array_map(function($i) {
    return "Viewpoint " . ($i + 1);
}, array_keys($base64_images));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interactive Property Tour</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <style>
        .vr-container {
            position: relative;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }
        .room-label {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
            font-family: Arial, sans-serif;
        }
        .nav-controls {
            position: absolute;
            bottom: 30px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 20px;
            z-index: 9999;
        }
        .nav-btn {
            padding: 12px 24px;
            background: rgba(0,0,0,0.7);
            color: white;
            border: 2px solid white;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        .nav-btn:hover {
            background: rgba(255,255,255,0.9);
            color: black;
        }
        .thumbnail-bar {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 9999;
        }
        .thumbnail {
            width: 60px;
            height: 40px;
            border: 2px solid white;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.3s;
        }
        .thumbnail:hover, .thumbnail.active {
            opacity: 1;
            border-color: gold;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
<div class="vr-container">
    <?php if (!empty($base64_images)): ?>
        <a-scene>
            <a-assets>
                <?php foreach ($base64_images as $i => $img): ?>
                    <img id="img-<?= $i ?>" src="data:image/jpeg;base64,<?= $img ?>">
                <?php endforeach; ?>
            </a-assets>

            <a-sky id="sky" src="#img-0" rotation="0 -90 0"></a-sky>
            
            <a-camera position="0 1.6 0">
                <a-cursor></a-cursor>
            </a-camera>

            <div class="room-label" id="roomLabel"><?= $room_names[0] ?></div>
            
            <div class="nav-controls">
                <button class="nav-btn" id="prevBtn">◀ Previous</button>
                <button class="nav-btn" id="nextBtn">Next ▶</button>
            </div>
            
            <div class="thumbnail-bar" id="thumbnailBar">
                <?php foreach ($base64_images as $i => $img): ?>
                    <img class="thumbnail <?= $i === 0 ? 'active' : '' ?>" 
                         src="data:image/jpeg;base64,<?= $img ?>" 
                         data-index="<?= $i ?>"
                         onclick="showImage(<?= $i ?>)">
                <?php endforeach; ?>
            </div>

            <script>
                // Configuration
                const totalImages = <?= count($base64_images) ?>;
                const roomNames = <?= json_encode($room_names) ?>;
                let currentIndex = 0;
                
                // DOM elements
                const sky = document.getElementById('sky');
                const roomLabel = document.getElementById('roomLabel');
                const thumbnails = document.querySelectorAll('.thumbnail');
                
                // Update view
                function updateView() {
                    sky.setAttribute('src', '#img-' + currentIndex);
                    roomLabel.textContent = roomNames[currentIndex];
                    
                    // Update active thumbnail
                    thumbnails.forEach((thumb, i) => {
                        thumb.classList.toggle('active', i === currentIndex);
                    });
                }
                
                // Navigation functions
                function showImage(index) {
                    currentIndex = index;
                    updateView();
                }
                
                function nextImage() {
                    currentIndex = (currentIndex + 1) % totalImages;
                    updateView();
                }
                
                function prevImage() {
                    currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                    updateView();
                }
                
                // Event listeners
                document.getElementById('nextBtn').addEventListener('click', nextImage);
                document.getElementById('prevBtn').addEventListener('click', prevImage);
                
                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowRight') nextImage();
                    if (e.key === 'ArrowLeft') prevImage();
                });
                
                // Initialize
                updateView();
            </script>
        </a-scene>
    <?php else: ?>
        <h1 style="color:red;text-align:center;padding-top:100px;">No VR images available for this property</h1>
    <?php endif; ?>
</div>
</body>
</html>