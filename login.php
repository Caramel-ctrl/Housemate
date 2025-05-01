<?php include '../config/db.php'; session_start(); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $result = $conn->query("SELECT * FROM tenants WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['password'])) {
            $_SESSION['tenant'] = $user;
            echo "<div class='loader'>Logging in...</div>";
            header("refresh:2;url=random/random_quiz.php");
            exit();
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Email not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenant Login</title>
    <link rel="stylesheet" href="../../css/login.css">
</head>

<body>
<a href="../../../index.php" class="back-btn">
        <img src="/Royalty/global_theme/assets/back.png" alt="Back">
    </a>
    <div class="background"></div>

    <div class="login-container">
        <h2>Tenant Login</h2>
        <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>

        <form method="post" onsubmit="showLoader()">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>
        <a class="forgot-link" href="../logic/fogot.php">Forgot Password?</a>
        
    </div>

    <div id="loader" class="loader-container" style="display:none;">
        <div class="loader-ball"></div>
        <p>Logging in...</p>
    </div>

    <script>
        function showLoader() {
            document.querySelector(".login-container").style.display = "none";
            document.getElementById("loader").style.display = "block";
        }
    </script>
</body>
</html>
