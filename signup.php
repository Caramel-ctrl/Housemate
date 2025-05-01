<?php include '../config/db.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO tenants (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $password);
    $stmt->execute();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../css/signup.css">
    <title>Tenant Signup</title>
</head>
<body>

    <!-- Loader -->
    <div id="loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Signup Form -->
    <form method="post" action="">
        <h2>Tenant Signup</h2>
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
        <a href="login.php">Already have an account? Login</a>
    </form>

    <!-- Script to hide loader after page loads -->
    <script>
        window.addEventListener("load", function () {
            document.getElementById("loader").style.display = "none";
        });
    </script>

</body>
</html>
