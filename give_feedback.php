<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenant_name = $_POST['tenant_name'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO tenant_feedbacks (tenant_name, feedback, rating) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $tenant_name, $feedback, $rating);
    $stmt->execute();
    $stmt->close();
    $success = "Thank you for your feedback!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Give Feedback</title>
    <link rel="stylesheet" href="/Royalty/Tenants/css/navigation_bar.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #ffe0ec;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .feedback-form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            width: 400px;
        }

        h2 {
            color: #d6336c;
            margin-bottom: 20px;
        }

        input, textarea, select {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #ff66a3;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .success {
            color: green;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<?php include '../logic/navigation_bar.php'; ?>
<body>
<div class="feedback-form">
    <h2>Give Feedback</h2>
    <form method="POST">
        <input type="text" name="tenant_name" placeholder="Your Name" required>
        <textarea name="feedback" placeholder="Write your feedback..." rows="5" required></textarea>
        <select name="rating" required>
            <option value="">Rate us (1-5)</option>
            <option value="1">★☆☆☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="3">★★★☆☆</option>
            <option value="4">★★★★☆</option>
            <option value="5">★★★★★</option>
        </select>
        <button type="submit">Submit Feedback</button>
    </form>
    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
</div>
</body>
</html>
