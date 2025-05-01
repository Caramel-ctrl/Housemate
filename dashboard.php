<?php
/* Database connection
$conn = new mysqli("localhost", "root", "", "your_database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} */
include '../config/db.php';

// Get counts
$caretakers = $conn->query("SELECT COUNT(*) AS total FROM caretakers")->fetch_assoc()['total'];
$tenants = $conn->query("SELECT COUNT(*) AS total FROM tenants")->fetch_assoc()['total'];
$properties = $conn->query("SELECT COUNT(*) AS total FROM properties")->fetch_assoc()['total'];
$bookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];

// Get feedback
$feedbacks = $conn->query("SELECT * FROM tenant_feedbacks ORDER BY created_at DESC LIMIT 5");

// Get vacant units data
$vacant_query = $conn->query("SELECT p.name, v.vacant_units FROM vacant_units v JOIN properties p ON v.property_id = p.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/sidebar.css">
  <link rel="stylesheet" href="../css/management_dashboard.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .card { box-shadow: 0 0 15px rgba(0,0,0,0.1); }
    .dashboard-container { margin-left: 250px; padding: 20px; }
    canvas { background: white; border-radius: 10px; }
  </style>
</head>
<body>

<?php include '../logic/sidebar.php'; ?>

<div class="dashboard-container">
  <h2 class="mb-4">Administrator Dashboard</h2>

  <!-- Stat Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h5>Caretakers</h5>
        <h2><?= $caretakers ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h5>Tenants</h5>
        <h2><?= $tenants ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h5>Properties</h5>
        <h2><?= $properties ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h5>Bookings</h5>
        <h2><?= $bookings ?></h2>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="mb-3">Vacant Units per Property</h5>
        <canvas id="vacantChart" height="200"></canvas>
      </div>
    </div>

    <!-- Feedback Table -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="mb-3">Recent Feedback</h5>
        <table class="table table-striped table-sm">
          <thead>
            <tr><th>Tenant</th><th>Feedback</th><th>Rating</th><th>Date</th></tr>
          </thead>
          <tbody>
            <?php while($f = $feedbacks->fetch_assoc()): ?>
              <tr>
                <td><?= $f['tenant_name'] ?></td>
                <td><?= substr($f['feedback'], 0, 50) ?>...</td>
                <td><?= $f['rating'] ?>/5</td>
                <td><?= $f['created_at'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bookings -->
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card p-3">
        <h5 class="mb-3">Latest Bookings</h5>
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>Tenant</th>
              <th>Phone</th>
              <th>Visit Day</th>
              <th>Time</th>
              <th>Status</th>
              <th>Caretaker</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $bookings_data = $conn->query("SELECT * FROM bookings ORDER BY visit_day DESC LIMIT 5");
              while ($b = $bookings_data->fetch_assoc()):
            ?>
              <tr>
                <td><?= $b['tenant_name'] ?></td>
                <td><?= $b['tenant_phone'] ?></td>
                <td><?= $b['visit_day'] ?></td>
                <td><?= $b['visit_time'] ?></td>
                <td><?= $b['status'] ?></td>
                <td><?= $b['caretaker_name'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
<?php
$labels = [];
$data = [];
while($v = $vacant_query->fetch_assoc()) {
  $labels[] = $v['name'];
  $data[] = $v['vacant_units'];
}
?>
const ctx = document.getElementById('vacantChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
      label: 'Vacant Units',
      data: <?= json_encode($data) ?>,
      backgroundColor: 'rgba(54, 162, 235, 0.7)',
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false }
    }
  }
});
</script>

</body>
</html>
