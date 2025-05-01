<?php
$conn = new mysqli("localhost", "root", "", "test_page");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $location = $_POST["location"];
    $units = $_POST["units"];

    // Convert Cover Image to Base64
    $cover_image = base64_encode(file_get_contents($_FILES["cover_image"]["tmp_name"]));

    // Handle multiple 3D images
    $image_data = [];
    foreach ($_FILES['house_images']['tmp_name'] as $tmp_name) {
        if (!empty($tmp_name)) {
            $image_data[] = base64_encode(file_get_contents($tmp_name));
        }
    }
    $images_json = json_encode($image_data); // Store as JSON string

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO properties (name, location, units_available, cover_image, images) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $location, $units, $cover_image, $images_json);

    if ($stmt->execute()) {
        echo "Property added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/add_property.css">

</head>
<?php include '../logic/sidebar.php'; ?>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label>Property Name:</label>
        <input type="text" name="name" required><br>

        <label>Location:</label>
        <input type="text" name="location" required><br>

        <label>Units Available:</label>
        <input type="number" name="units" required><br>

        <label>Cover Image:</label>
        <input type="file" name="cover_image" accept="image/*" required><br>

        <label>House Images (3D View):</label>
        <input type="file" name="house_images[]" accept="image/*" multiple required><br>

        <button type="submit">Add Property</button>
    </form>
</body>
</html>
