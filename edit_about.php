<?php
include '../config/db.php';

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $conn->real_escape_string($_POST['about_content']);

    $sql = "UPDATE about_us SET content = '$content' WHERE id = 1";
    if ($conn->query($sql)) {
        $message = "Updated successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch current content
$result = $conn->query("SELECT content FROM about_us WHERE id = 1");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit About Us</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <style>
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        textarea { width: 100%; height: 250px; padding: 10px; font-size: 16px; }
        button { padding: 10px 20px; background: #d6336c; color: #fff; border: none; cursor: pointer; }
        .message { margin-top: 10px; color: green; }
    </style>
</head>
<?php include '../logic/sidebar.php'; ?>
<body>
    <h2>Edit About Us Page</h2>
    <form method="POST">
        <textarea name="about_content"><?php echo htmlspecialchars($row['content']); ?></textarea>
        <br><br>
        <button type="submit">Save Changes</button>
        <div class="message"><?php echo $message; ?></div>
    </form>
</body>
</html>
