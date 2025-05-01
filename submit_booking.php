<?php
// Include database connection
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenant_name = $_POST['tenant_name'];
    $phone_number = $_POST['phone_number'];
    $property_id = $_POST['property_id'];
    $visit_date = $_POST['visit_date'];

    // Insert booking details into the database
    $query = "INSERT INTO bookings (tenant_name, phone_number, property_id, visit_date) 
              VALUES ('$tenant_name', '$phone_number', '$property_id', '$visit_date')";
    
    if (mysqli_query($conn, $query)) {
        echo "Booking successful!<br>";
        echo "<a href='../pages/view_booking.php'>View Bookings</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
