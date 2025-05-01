<?php
include '../config/db.php';

// Check if the service ID is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Service ID is required");
}

$service_id = $_GET['id'];

// Delete the service from the database
$stmt = $conn->prepare("DELETE FROM property_services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();

// Redirect back to the services page after deletion
header("Location: ../pages/manage_services.php");
exit;
?>
