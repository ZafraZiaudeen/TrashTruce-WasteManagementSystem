<?php
ob_start();
include('../FO/Recycle.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

if(isset($_POST["btnAdd"])){
  try {
      // Instantiate Recycle object
      $recycle = new Recycle();
      
      // Assign form data to Recycle object properties
      $recycle->pname = $_POST['PName'];
      $recycle->pdesc = $_POST['pdesc'];
      
      // Check if a video file is uploaded
      if(isset($_FILES['processVid']['name']) && !empty($_FILES['processVid']['name'])) {
          $allowed_types = array('video/mp4', 'video/mpeg', 'video/quicktime', 'video/x-msvideo', 'video/x-flv', 'video/x-ms-wmv');
          $file_type = $_FILES['processVid']['type'];

          // Check if the file type is allowed
          if(!in_array($file_type, $allowed_types)) {
              throw new Exception("Invalid file type. Please upload only video files.");
          }

          $recycle->pvid = $_FILES['processVid']['name'];
      } else {
          // Handle case where no video file is provided
          throw new Exception("Please upload a video file.");
      }
      
      // Add the recycling process
      $recycle->AddProcess();
      
      // Handle file upload if a video file is provided
      if(isset($_FILES['processVid']['name']) && !empty($_FILES['processVid']['name'])) {
          $uploadDir = "../processVideos/";
          $uploadFile = $uploadDir . basename($_FILES['processVid']['name']);
          
          if (move_uploaded_file($_FILES['processVid']['tmp_name'], $uploadFile)) {
              
              echo '<script>alert("Recycling process added successfully.");</script>';
              header("Location: Recycling.php");
              exit();
          } else {
              // Error uploading file
              echo '<script>alert("Possible file upload attack!");</script>';
          }
      }
  } catch (Exception $ex) {
      echo '<script>alert("' . $ex->getMessage() . '");</script>';
  }
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
    <title>Add Recycling Process</title>
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <div class="AddProduct">
            <h1>Add Recycling Process</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
                Recycling Process Name :
                <input type="text" name="PName"><br>
                        
                Process Description:
                <textarea name="pdesc" cols="21" rows="4"></textarea><br>
                        
                Process Video (Upload Video File):
                <input type="file" name="processVid"><br>

                <button class="btnAddProduct" type="submit" name="btnAdd">Add Process</button>
            </form>
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>
<?php ob_flush(); ?>
