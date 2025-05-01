<?php include '../config/db.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["fullname"];
    $new_pass = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE tenants SET password=? WHERE fullname=?");
    $stmt->bind_param("ss", $new_pass, $name);
    $stmt->execute();
    echo "<p>Password updated. <a href='../Authentication/login.php'>Login</a></p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ff9eb3, #ffe0ec);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .reset-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .reset-container h2 {
            color: #d6336c;
            margin-bottom: 25px;
        }

        .reset-container input {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s ease;
        }

        .reset-container input:focus {
            outline: none;
            border-color: #ff66a3;
            box-shadow: 0 0 5px rgba(255, 102, 163, 0.4);
        }

        .reset-container button {
            background-color: #ff66a3;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .reset-container button:hover {
            background-color: #e25591;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Forgot Password</h2>
        <form method="post">
            <input type="text" name="fullname" required placeholder="Full Name">
            <input type="password" name="new_password" required placeholder="New Password">
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
