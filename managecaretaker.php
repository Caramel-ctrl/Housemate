<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_page"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete caretaker functionality
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM caretakers WHERE id=$id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Caretaker deleted successfully!";
    } else {
        echo "Error deleting caretaker: " . $conn->error;
    }
}

// Get all caretakers
$sql = "SELECT * FROM caretakers";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/manage_caretaker.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <script src="../logic/modal.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Manage Caretakers</title>
</head>


<?php include '../logic/sidebar.php'; ?>
<body>
    <h2>Manage Caretakers</h2>
    
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>National ID</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['national_id']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td>
                            <!-- Edit Button -->
                            <a href="../logic/delete_caretaker.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <!-- Delete Button -->
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this caretaker?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">No caretakers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
