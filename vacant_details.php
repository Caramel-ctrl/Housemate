<?php
$conn = new mysqli("localhost", "root", "", "test_page");

// Get the property ID from the URL parameter
$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : null;

if ($property_id) {
    // Fetch the property details
    $property_sql = "SELECT * FROM properties WHERE id = ?";
    $stmt = $conn->prepare($property_sql);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $property_result = $stmt->get_result();
    $property = $property_result->fetch_assoc();

    // Fetch the vacant units details for the property
    $vacant_units_sql = "SELECT * FROM vacant_units WHERE property_id = ?";
    $vacant_units_stmt = $conn->prepare($vacant_units_sql);
    $vacant_units_stmt->bind_param("i", $property_id);
    $vacant_units_stmt->execute();
    $vacant_units_result = $vacant_units_stmt->get_result();
} else {
    echo "Invalid property ID.";
    exit;
}

?>
<?php
// Assuming $property and $vacant_units_result are already defined and contain the necessary data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacant Units Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Vacant Units for <?php echo $property['name']; ?></h2>

        <div class="card">
            <h3>Property Information</h3>
            <p><strong>Name:</strong> <?php echo $property['name']; ?></p>
            <p><strong>Location:</strong> <?php echo $property['location']; ?></p>
            <p><strong>Units Available:</strong> <?php echo $property['units_available']; ?></p>
        </div>

        <h3>Vacant Units Details</h3>
        <?php while ($row = $vacant_units_result->fetch_assoc()) { ?>
            <div class="card">
                <p><strong>Vacant Units:</strong> <?php echo $row['vacant_units']; ?></p>
                <p><strong>Extra Details:</strong> <?php echo nl2br($row['extra_details']); ?></p>
            </div>
        <?php } ?>

        <a href="view_property.php">Back to Properties</a>
    </div>
</body>
</html>
