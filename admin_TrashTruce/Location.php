<?php
include('../FO/location.php');
session_start();
// Fetch locations data
$locations = location::GetLocations();

if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
    <link rel="shortcut icon" href="../customer_TrashTruce/image/logo.jpg" type="image/x-icon">

</head>
<body>
<?php
          if (isset($_SESSION['add_location']) && !empty($_SESSION['add_location'])) {
            echo $_SESSION['add_location'];
            unset($_SESSION['add_location']);
        }
       
          if (isset($_SESSION['update_loc']) && !empty($_SESSION['update_loc'])) {
            echo $_SESSION['update_loc'];
            unset($_SESSION['update_loc']);
        }
        if (isset($_SESSION['delete_loc']) && !empty($_SESSION['delete_loc'])) {
            echo $_SESSION['delete_loc'];
            unset($_SESSION['delete_loc']);
        }
                     
// Retrieve Locations from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $locations = location::SearchLocations($search); 
} else {
    $locations = location::GetLocations();
}  ?>
    <div>
       <?php include "Header.php"; ?>
    </div>
    <div class="main">
        <div class="colorbar">
          <h1> Location</h1>
        </div>
            
        <div class="btnAll">
            
            
            <div class="btnAllDlt">
                <button class="btn10"><a href="AddLocations.php">Add Location</a></button>
            </div>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Location Name</th>
                    <th>Location Image</th>
                    <th>Nearby Areas/Street</th>
                    <th>Location URL</th>
                    <th>Action</th>
                </tr>
                <?php if (count($locations) > 0): ?>
                <?php foreach ($locations as $index => $location): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $location->name; ?></td>
                    <td><img src="<?php echo $location->img; ?>" alt="Location Image" width="100px" height="100px"></td>
                    <td><?php echo $location->nearbyloc; ?></td>
                    <td><?php echo $location->url; ?></td>
                    <td>
                    <a href="deleteLocation.php?id=<?php echo $location->ID; ?>"onclick="return confirm('Are you sure you want to delete this Location?');" ><span class="material-symbols-outlined">delete</span>
                        <a href="EditLocations.php?id=<?php echo $location->ID; ?>"><span class="material-symbols-outlined">edit</span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No Location Details Found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <div>
        <?php
        include "Footer.html";
        ?>
    </div>
</body>
</html>
