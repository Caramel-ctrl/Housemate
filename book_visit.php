<?php
session_start();
$conn = new mysqli("localhost", "root", "", "test_page");

if (!isset($_SESSION['tenant_id'])) {
    header("Location: tenant_login.php"); // Redirect if not logged in
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$property_id = $_GET['property_id'] ?? null;

if ($property_id) {
    $property = $conn->query("SELECT name FROM properties WHERE id = $property_id")->fetch_assoc();
    $tenant = $conn->query("SELECT fullname FROM tenants WHERE id = $tenant_id")->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["phone"];
    $visit_time = $_POST["visit_time"];

    $stmt = $conn->prepare("INSERT INTO bookings (tenant_id, property_id, phone, visit_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $tenant_id, $property_id, $phone, $visit_time);
    $stmt->execute();

    echo "<script>alert('Booking successful!'); window.location.href='view_properties.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Visit</title>
    <link rel="stylesheet" href="/Royalty/global_theme/themes/properties.css">
</head>
<body>
<div class="booking-form-container">
    <h2>Book a Visit</h2>
    <form method="post">
        <label>Property:</label>
        <input type="text" value="<?= $property['name']; ?>" readonly>

        <label>Your Name:</label>
        <input type="text" value="<?= $tenant['fullname']; ?>" readonly>

        <label>Phone Number:</label>
        <input type="tel" name="phone" required>

        <label>Visit Date & Time:</label>
        <input type="datetime-local" name="visit_time" required>

        <button type="submit">Confirm Booking</button>
    </form>
</div>
</body>
</html>
