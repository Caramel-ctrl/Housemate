<?php
$conn = new mysqli("localhost", "root", "", "test_page");

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Properties</title>
    <link rel="stylesheet" href="/Royalty/global_theme/themes/properties.css">
    <link rel="stylesheet" href="/Royalty/Tenants/css/navigation_bar.css">
</head>
<?php include '../logic/navigation_bar.php'; ?>
<body>
<!--a href="dashboard.php" class="back-btn">
        <img src="/Royalty/global_theme/assets/back.png" alt="Back">
    </a-->
    <h2 style="text-align: center; color: white;">Properties</h2>
    <div class="property-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="property-card">
                <img src="data:image/jpeg;base64,<?php echo $row['cover_image']; ?>" alt="Cover Image">
                <h3><?php echo $row["name"]; ?></h3>
                <p>Location: <?php echo $row["location"]; ?></p>
                <p>Units Available: <?php echo $row["units_available"]; ?></p>
                <a href="ar_property.php?id=<?php echo $row['id']; ?>">View in 360°</a><br>
                <button onclick="showVacantDetails(<?php echo $row['id']; ?>)">View More</button>
    <a href="book_visit.php?property_id=<?php echo $row['id']; ?>" class="book-btn">Book Visit</a>
            </div>
        <?php } ?>
    </div>

    <!-- Modal for displaying vacant unit details -->
    <div id="vacantModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Vacant Units Details</h2>
            <div id="vacantDetailsContent"></div>
        </div>
    </div>

    <script>
        // Function to show the modal with vacant units details
        function showVacantDetails(propertyId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Royalty/Caretaker/php/pages/get_vacant_details.php?property_id=' + propertyId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('vacantDetailsContent').innerHTML = xhr.responseText;
                    document.getElementById('vacantModal').style.display = "block";
                }
            };
            xhr.send();
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('vacantModal').style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('vacantModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
