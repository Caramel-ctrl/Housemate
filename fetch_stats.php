<?php
include '../config/db.php';
$tenant = $_GET['tenant'];

$statuses = ['Pending', 'Accepted', 'Rescheduled', 'Denied'];
$data = [];

foreach ($statuses as $status) {
    $res = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE tenant_name = '$tenant' AND status = '$status'");
    $data[$status] = $res->fetch_assoc()['count'];
}

echo json_encode($data);
