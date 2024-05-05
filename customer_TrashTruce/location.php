<?php
include_once('../FO/location.php'); // Include the Location class file
session_start(); // Start the session if not already started

// Include the header HTML content
include('customer assets/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drop Off Location</title>
 
  <link rel="stylesheet" href="css/location.css">
  <!-- Include Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header>
    <h1>Drop Off Location</h1>
    <h3>Click On URL navigate google map</h3>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search Location" oninput="searchLocations()">
     
      <!-- Add clear button -->
      <button onclick="clearSearch()">Clear</button>
    </div>
  </header>
  
  <main>
  <?php
        try {
            // Get locations
            $locations = Location::GetLocations();

            // Check if there are any locations
            if (!empty($locations)) {
                // Loop through each location
                foreach ($locations as $location) {
                    // Display the location details
                    echo '<div class="location" data-name="' . $location->name . '" data-street="' . $location->nearbyloc . '">';
                    echo '<img src="' . $location->img . '" alt="' . $location->name . '">';
                    echo '<h2>' . $location->name . '</h2>';
                    echo '<p>Nearby Areas/Street: ' . $location->nearbyloc . '</p>';
                    echo '<p>Url: <a href="' . $location->url . '" target="_blank">' . $location->name . ' URL</a></p>';
                    echo '</div>';
                }
            } else {
                // No locations found
                echo '<p>No locations available.</p>';
            }
        } catch (Exception $e) {
            // Handle exception
            echo '<p>Error: ' . $e->getMessage() . '</p>';
        }
        ?>
  </main>

  <script>
    function searchLocations() {
      var input = document.getElementById("searchInput").value.toLowerCase();
      var locations = document.querySelectorAll(".location");

      locations.forEach(function(location) {
        var name = location.getAttribute("data-name").toLowerCase();
        var street = location.getAttribute("data-street").toLowerCase();
        if (name.includes(input) || street.includes(input)) {
          location.style.display = "block";
        } else {
          location.style.display = "none";
        }
      });
    }

    function clearSearch() {
      document.getElementById("searchInput").value = "";
      searchLocations();
    }
  </script>
</body>
</html>

<?php
include ('customer assets/footer.html');
?>