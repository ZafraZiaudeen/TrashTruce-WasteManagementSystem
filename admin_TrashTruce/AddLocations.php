<?php
ob_start();
include('../FO/location.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
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
    <link rel="stylesheet" href="assets/css/AddP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<body>
    <div>
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">

<div class="AddProduct">
        <h1>Add Locations</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
                Location Name :
                <input type="text" name="PName" required><br>

                Location Image:
                <input type="file" name="image" required><br>
            
                Nearby Areas/Street:
                <textarea name="nearbyloc" cols="21" rows="2" required></textarea><br>
            
                Location URL:
                <input type="text" name="txturl" placeholder="Url" required><br>

                <button class="btnAddProduct" type="submit" name="btn_add">Add Locations</button>
            <!---------------------- finish Form-------------------------------------->
            </form>
</div>


</div>


  <div>
  <?php
    include "Footer.html";
    ?>
  </div>
</body>
</html>
<?php
if(isset($_POST["btn_add"])){
    // Create a new Location object
    $location = new Location();

    // Set the name of the location
    $location->name = $_POST['PName'];

    // Set the nearby locations or streets
    $location->nearbyloc = $_POST['nearbyloc'];

    // Set the URL of the location
    $location->url = $_POST['txturl'];

    // Check if a file is selected and it is an image
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        // Define the allowed file types
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        // Get the file type of the uploaded image
        $fileType = $_FILES["image"]["type"];

        // Check if the uploaded file type is allowed
        if(in_array($fileType, $allowedTypes)){
            try {
                // Add the location to the database
                $id = $location->Add();  
                
                // Get the name of the uploaded image
                $imageName = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($imageName); 
                // Define the new name and path for the image
                $newName = "../location_image/" . $id . 'l.' . $info->getExtension(); 
                // Set the ID of the location
                $location->ID = $id;
                // Move the uploaded image to the new path
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                // Set the image path for the location
                $location->img = $newName; 
                // Update the image path in the database
                $location->UpdateImage();

                // Set success message in session
                $_SESSION['add_location'] = '<script>alert("Location added Successfully");</script>';
                
                // Redirect to the Location page
                header("Location: Location.php");
                exit();
            } catch (Exception $ex) {
                // Handle any exceptions
                echo $ex->getMessage();
            }
        } else {
            // Display an error message if the file type is not allowed
            echo '<script>alert("Invalid file type. Please upload only image files (JPEG, PNG, GIF).");</script>';
        }
    } else {
        // Display an error message if no file is selected
        echo '<script>alert("Please select a file to upload.");</script>';
    }
}

// Flush the output buffer
ob_flush();
?>