<?php
include '../config/db.php';
$propertyId = $_GET['id'];
$property = $conn->query("SELECT * FROM properties WHERE id = $propertyId")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $property['name']; ?> - Details</title>
</head>
<body>
  <h2><?php echo $property['name']; ?></h2>
  <p>Location: <?php echo $property['location']; ?></p>
  <p>Units Available: <?php echo $property['units_available']; ?></p>
  <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
