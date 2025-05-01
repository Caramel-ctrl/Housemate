<?php
include '../config/db.php';
session_start();

// Handle deletion
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $message = "Property deleted successfully.";
}

// Fetch all properties
$result = $conn->query("SELECT * FROM properties");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Properties</title>
    <link rel="stylesheet" href="../themes/style.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .property { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; }
        img { max-width: 200px; height: auto; display: block; margin-top: 10px; }
        .delete-btn {
            background-color: red;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<h2>Manage Properties</h2>

<?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="property">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
        <p><strong>Units Available:</strong> <?php echo htmlspecialchars($row['units_available']); ?></p>
        <?php if (!empty($row['cover_image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['cover_image']); ?>" alt="Cover Image">
        <?php endif; ?>
        <form method="GET" onsubmit="return confirm('Are you sure you want to delete this property?');">
            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="delete-btn">Delete</button>
        </form>
    </div>
<?php endwhile; ?>

</body>
</html>
