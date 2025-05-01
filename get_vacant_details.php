<?php
$conn = new mysqli("localhost", "root", "", "test_page");

if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];

    // Fetch the vacant units details for the property
    $vacant_units_sql = "SELECT * FROM vacant_units WHERE property_id = ?";
    $stmt = $conn->prepare($vacant_units_sql);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='vacant-unit'>";
            echo "<p><strong>Vacant Units:</strong> " . $row['vacant_units'] . "</p>";
            echo "<p><strong>Extra Details:</strong> " . nl2br($row['extra_details']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No vacant units information available for this property.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
