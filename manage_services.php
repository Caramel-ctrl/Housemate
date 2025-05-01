<?php
include '../config/db.php';

// Handle the form submission for adding a new service
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $service_description = $_POST['service_description'];
    $service_status = $_POST['service_status'];
    $social_links = $_POST['social_links'];
    $offers = $_POST['offers'];

    // Check if an image is uploaded
    if ($_FILES['service_image']['tmp_name']) {
        $image = file_get_contents($_FILES['service_image']['tmp_name']); // Read the image into binary data
    } else {
        $image = null; // Set to null if no image is uploaded
    }

    // Insert new service into the database, including the image as a BLOB
    $stmt = $conn->prepare("INSERT INTO property_services (name, description, image, status, social_links, offers) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $service_name, $service_description, $image, $service_status, $social_links, $offers);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Services</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fafafa;
            padding: 40px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-form {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
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

        .service-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }

        .service-table th, .service-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .service-table th {
            background-color: #f4f4f4;
        }

        .service-status {
            font-weight: bold;
            color: #d6336c;
        }
    </style>
</head>
<?php include '../logic/sidebar.php'; ?>
<body>
    <div class="container">
        <h1>Manage Services</h1>
        
        <!-- Form to add a new service -->
        <div class="service-form">
            <h2>Add New Service</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="service_name" placeholder="Service Name" required>
                <textarea name="service_description" placeholder="Service Description" required></textarea>
                <input type="file" name="service_image" required>
                <select name="service_status" required>
                    <option value="active">Active</option>
                    <option value="coming_soon">Coming Soon</option>
                    <option value="closed">Closed</option>
                </select>
                <input type="text" name="social_links" placeholder="Social Media Links (optional)">
                <input type="text" name="offers" placeholder="Offers (optional)">
                <button type="submit">Add Service</button>
            </form>
        </div>

        <!-- Display existing services -->
        <h2>Existing Services</h2>
        <table class="service-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Social Links</th>
                    <th>Offers</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch existing services from the database
                $services = $conn->query("SELECT * FROM property_services ORDER BY status DESC");

                while ($service = $services->fetch_assoc()):
                    // Convert the image binary data into a base64 string for displaying
                    $imageData = base64_encode($service['image']);
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['name']); ?></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td><img src="data:image/jpeg;base64,<?php echo $imageData; ?>" width="50"></td>
                        <td class="service-status"><?php echo ucfirst($service['status']); ?></td>
                        <td><?php echo htmlspecialchars($service['social_links']); ?></td>
                        <td><?php echo htmlspecialchars($service['offers']); ?></td>
                        <td>
                            <a href="../logic/edit_service.php?id=<?php echo $service['id']; ?>">Edit</a> |
                            <a href="../logic/delete_service.php?id=<?php echo $service['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
