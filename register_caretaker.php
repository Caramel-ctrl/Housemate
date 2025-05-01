<?php
// database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_page"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $full_name = $_POST['full_name'];
    $national_id = $_POST['national_id'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // SQL to insert new caretaker
    $sql = "INSERT INTO caretakers (full_name, national_id, gender, age, password)
            VALUES ('$full_name', '$national_id', '$gender', '$age', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New caretaker profile created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Caretaker</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/register_caretaker.css">
    <script src="../logic/modal.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<?php include '../logic/sidebar.php'; ?>
<body>
    <h2>Add New Caretaker Profile</h2>
    <form method="POST" action="">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required><br><br>

        <label for="national_id">National ID:</label>
        <input type="text" name="national_id" required><br><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Create Profile</button>
    </form>
</body>
</html>
