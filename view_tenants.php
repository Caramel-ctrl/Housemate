<?php
$host = "localhost";
$user = "root";
$password = ""; // Default XAMPP password
$database = "test_page";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM tenants WHERE id = $idToDelete";
    $conn->query($deleteQuery);
    header("Location: view_tenants.php"); // Refresh page
    exit();
}

$sql = "SELECT * FROM tenants";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tenant List</title>
    <link rel="stylesheet" href="/Royalty/global_theme/themes/style.css">
    <?php include '../logic/sidebar.php'; ?>
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            padding: 20px;
            margin-left: 250px; /* Adjust based on your sidebar width */
        }
        .tenant-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .tenant-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            width: 250px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
        }
        .tenant-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .tenant-card h3 {
            margin: 5px 0;
            font-size: 18px;
            color: #333;
        }
        .tenant-card p {
            margin: 3px 0;
            color: #666;
        }
        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
        /* Responsive Fix */
@media screen and (max-width: 768px) {
    .dashboard-container {
        margin-left: 0;
        padding: 15px;
    }

    .card h2 {
        font-size: 24px;
    }
}

    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this tenant?")) {
                window.location.href = "view_tenants.php?delete=" + id;
            }
        }
    </script>
</head>
<body>

<h1>Tenant List</h1>
<div class="tenant-container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $profileImage = $row['profile'] ? 'data:image/jpeg;base64,' . base64_encode($row['profile']) : 'https://via.placeholder.com/100';
            echo "<div class='tenant-card'>";
            echo "<img src='{$profileImage}' alt='Profile Image'>";
            echo "<h3>" . htmlspecialchars($row["fullname"]) . "</h3>";
            echo "<p>Email: " . htmlspecialchars($row["email"]) . "</p>";
            echo "<p>Phone: " . htmlspecialchars($row["phone"]) . "</p>";
            echo "<button class='delete-btn' onclick='confirmDelete({$row["id"]})'>Delete</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No tenants found.</p>";
    }
    ?>
</div>

</body>
</html>
