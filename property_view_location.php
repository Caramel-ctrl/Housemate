<?php
$conn = new mysqli("localhost", "root", "", "test_page");

// Fetch all properties with location
$sql = "SELECT id, name, units_available, latitude, longitude FROM properties WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

$properties = [];
while($row = $result->fetch_assoc()) {
    $properties[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Available Properties Map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    #search-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 15px 0;
    }
    #search-box {
      padding: 8px;
      width: 300px;
      border-radius: 20px;
      border: 1px solid #ccc;
      padding-left: 35px;
    }
    #search-icon {
      position: relative;
      left: 30px;
      margin-right: -30px;
      color: #888;
    }
    #map {
      height: 600px;
      width: 100%;
    }
    h2 {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<h2>Available Properties</h2>

<div id="search-container">
  <span id="search-icon">🔍</span>
  <input type="text" id="search-box" placeholder="Search property name...">
</div>

<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var properties = <?php echo json_encode($properties); ?>;

  var map = L.map('map').setView([-1.286389, 36.817223], 12);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  var markers = [];

  properties.forEach(function(property) {
    var lat = parseFloat(property.latitude);
    var lng = parseFloat(property.longitude);
    var popupContent = `
      <b>${property.name}</b><br>
      Units Available: ${property.units_available}<br>
      <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank">Navigate</a>
    `;

    var marker = L.marker([lat, lng])
      .addTo(map)
      .bindPopup(popupContent);

    marker.propertyName = property.name.toLowerCase(); // for search filter
    marker.propertyLat = lat;
    marker.propertyLng = lng;
    markers.push(marker);
  });

  document.getElementById('search-box').addEventListener('input', function() {
    var searchTerm = this.value.toLowerCase();

    var found = false;
    markers.forEach(marker => {
      if (marker.propertyName.includes(searchTerm)) {
        marker.openPopup();
        map.setView([marker.propertyLat, marker.propertyLng], 15);
        found = true;
      }
    });

    if (!found && searchTerm.length > 0) {
      alert('Property not found');
    }
  });
</script>

</body>
</html>
