<?php include '../config/db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/Royalty/Tenants/css/navigation_bar.css">
  <title>My Booking Status</title>
  <style>
    body {
      font-family: Arial;
      background: #f1f1f1;
    }
    .container {
        max-width: 600px;
    margin: 100px auto 40px auto; /* top margin adjusted for navbar */
    padding: 30px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    form input, form button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      font-size: 16px;
    }
    .booking-box {
      margin-top: 25px;
      padding: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .accepted { background: #e2fbe2; }
    .rescheduled { background: #fff4db; }
    .denied { background: #ffe3e3; }
    .pending { background: #f0f0f0; }
    .label { font-weight: bold; color: #555; }
  </style>
</head>
<?php include '../logic/navigation_bar.php'; ?>
<body>

<div class="container">
  <h2>Check My Booking</h2>

  <form method="POST">
    <label for="tenant_phone">Enter Your Phone Number:</label>
    <input type="text" id="tenant_phone" name="tenant_phone" placeholder="e.g. 0712345678" required>
    <button type="submit" name="check">View My Booking</button>
  </form>

  <?php
  if (isset($_POST['check'])) {
    $tenant_phone = $_POST['tenant_phone'];

    $sql = "SELECT b.*, p.name AS property_name, p.location 
            FROM bookings b
            JOIN properties p ON b.property_id = p.id
            WHERE b.tenant_phone = '$tenant_phone'
            ORDER BY b.id DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<h3 style='margin-top: 30px;'>Your Bookings</h3>";

      while ($row = $result->fetch_assoc()) {
        $statusClass = strtolower($row['status']);
        echo "<div class='booking-box $statusClass'>";
        echo "<p><span class='label'>Apartment:</span> " . $row['property_name'] . " (" . $row['location'] . ")</p>";
        echo "<p><span class='label'>Visit Date:</span> " . $row['visit_day'] . " at " . $row['visit_time'] . "</p>";
        echo "<p><span class='label'>Status:</span> " . $row['status'] . "</p>";

        if ($row['status'] == 'Accepted') {
          echo "<p><span class='label'>Caretaker Name:</span> " . $row['caretaker_name'] . "</p>";
          echo "<p><span class='label'>Caretaker Phone:</span> " . $row['caretaker_phone'] . "</p>";
        } elseif ($row['status'] == 'Rescheduled') {
          echo "<p><span class='label'>Reschedule Reason:</span> " . $row['reschedule_reason'] . "</p>";
        } elseif ($row['status'] == 'Denied') {
          echo "<p style='color: red;'><strong>Your request was denied.</strong></p>";
        } else {
          echo "<p><em>Your request is pending. Please check back later.</em></p>";
        }

        echo "</div>";
      }
    } else {
      echo "<p style='color:red;'>No bookings found with that phone number.</p>";
    }
  }
  ?>
</div>

</body>
</html>
