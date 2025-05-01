<?php include '../config/db.php'; ?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="/Royalty/Tenants/css/navigation_bar.css">
<link rel="stylesheet" href="/Royalty/Tenants/css/booking_visit.css">
    


<head>
  <title>Book Property Viewing</title>
  <!--style>
    body {
      font-family: Arial;
      background-color: #f2f2f2;
    }
    .container {
      width: 60%;
      margin: auto;
      background: white;
      padding: 20px;
      margin-top: 40px;
      border-radius: 8px;
    }
    .property {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 6px;
    }
    form {
      margin-top: 20px;
    }
    input, select {
      padding: 8px;
      margin-bottom: 10px;
      width: 100%;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 5px;
    }
  </style-->
</head>
<?php include '../logic/navigation_bar.php'; ?>
<body>

<div class="container">
  <h2>Select Apartment to Book Viewing</h2>

  <form method="POST" action="">
    <label>Select Apartment</label>
    <select name="property_id" required>
      <option value="">-- Choose Apartment --</option>
      <?php
        $result = $conn->query("SELECT * FROM properties");
        while ($row = $result->fetch_assoc()) {
          echo "<option value='" . $row['id'] . "'>" . $row['name'] . " - " . $row['location'] . "</option>";
        }
      ?>
    </select>

    <label>Your Full Name</label>
    <input type="text" name="tenant_name" required>

    <label>Your Phone Number</label>
    <input type="text" name="tenant_phone" required>

    <label>Preferred Day of Visit</label>
    <input type="date" name="visit_day" required>

    <label>Preferred Time</label>
    <input type="time" name="visit_time" required>

    <button type="submit" name="book">Book Visit</button>
  </form>

  <?php
  if (isset($_POST['book'])) {
    $property_id = $_POST['property_id'];
    $tenant_name = $_POST['tenant_name'];
    $tenant_phone = $_POST['tenant_phone'];
    $visit_day = $_POST['visit_day'];
    $visit_time = $_POST['visit_time'];

    $stmt = $conn->prepare("INSERT INTO bookings (property_id, tenant_name, tenant_phone, visit_day, visit_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $property_id, $tenant_name, $tenant_phone, $visit_day, $visit_time);

    if ($stmt->execute()) {
      echo "<p style='color:green;'>Booking submitted! Await caretaker confirmation.</p>";
    } else {
      echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
  }
  ?>

</div>

</body>
</html>
