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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get caretaker details
    $sql = "SELECT * FROM caretakers WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Caretaker not found!";
        exit;
    }

    // Update caretaker details
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $full_name = $_POST['full_name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql_update = "UPDATE caretakers SET full_name='$full_name', password='$password' WHERE id=$id";

        if ($conn->query($sql_update) === TRUE) {
            echo "Caretaker updated successfully!";
            header("Location: ../pages/managecaretaker.php");
        } else {
            echo "Error updating caretaker: " . $conn->error;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit_caretaker.css">
    <title>Edit Caretaker</title>
</head>
<body>

    <!-- Back Button -->
    <a href="../pages/managecaretaker.php" class="back-btn">
        <img src="/Royalty/global_theme/assets/back.png" alt="Back">
    </a>

    <!--h2>Edit Caretaker</h2-->

    <form method="POST" action="">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Update Caretaker</button>
    </form>
    
</body>
</html>
