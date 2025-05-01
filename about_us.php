<?php
include '../../Management/php/config/db.php';

$result = $conn->query("SELECT content FROM about_us WHERE id = 1");
$row = $result ? $result->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <link rel="stylesheet" href="../themes/nav_bar.css">
    <link rel="stylesheet" href="../themes/loading.css">
    <link rel="stylesheet" href="../themes/about.css">
    <style>
        body { font-family: Arial; padding: 40px; background: #fff; }
        .about-container { max-width: 800px; margin: auto; line-height: 1.6; font-size: 18px; }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?> 

<!-- Loading Overlay -->
<div class="loading-overlay">
    <div class="loading-spinner"></div>
</div>

<div class="about-container">
    <h1>About Us</h1>
    <?php if ($row && isset($row['content'])): ?>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
    <?php else: ?>
        <p><em>No content available. Please add content to the <strong>about_us</strong> table with <code>id = 1</code>.</em></p>
    <?php endif; ?>
</div>

<script src="/Royalty/global_theme/functions/script.js"></script>
</body>
</html>
