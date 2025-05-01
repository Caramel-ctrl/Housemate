<?php
include '..//config/db.php';

// Check if the service ID is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Service ID is required");
}

$service_id = $_GET['id'];

// Fetch the service details from the database
$stmt = $conn->prepare("SELECT * FROM property_services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$service = $stmt->get_result()->fetch_assoc();

// If the service does not exist, show an error
if (!$service) {
    die("Service not found");
}

// Update the service if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $service_description = $_POST['service_description'];
    $service_status = $_POST['service_status'];
    $social_links = $_POST['social_links'];
    $offers = $_POST['offers'];

    // Check if a new image is uploaded
    if ($_FILES['service_image']['tmp_name']) {
        $image = file_get_contents($_FILES['service_image']['tmp_name']); // Read the uploaded file into a variable
    } else {
        $image = $service['image']; // Use the old image if no new image is uploaded
    }

    // Update the service in the database with the image stored in MySQL as a BLOB
    $stmt = $conn->prepare("UPDATE property_services SET name = ?, description = ?, image = ?, status = ?, social_links = ?, offers = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $service_name, $service_description, $image, $service_status, $social_links, $offers, $service_id);
    $stmt->execute();

    // Redirect to the services page after updating
    header("Location: manage_services.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fafafa;
            padding: 40px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .service-form {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .service-form input, .service-form textarea, .service-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .service-form button {
            background: #d6336c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Service</h1>
        <div class="service-form">
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="service_name" value="<?php echo htmlspecialchars($service['name']); ?>" required>
                <textarea name="service_description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                <input type="file" name="service_image">
                <input type="text" name="social_links" value="<?php echo htmlspecialchars($service['social_links']); ?>" placeholder="Social Media Links">
                <input type="text" name="offers" value="<?php echo htmlspecialchars($service['offers']); ?>" placeholder="Offers">
                <select name="service_status" required>
                    <option value="active" <?php echo $service['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="coming_soon" <?php echo $service['status'] == 'coming_soon' ? 'selected' : ''; ?>>Coming Soon</option>
                    <option value="closed" <?php echo $service['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
                <button type="submit">Update Service</button>
            </form>
        </div>
    </div>
</body>
</html>
