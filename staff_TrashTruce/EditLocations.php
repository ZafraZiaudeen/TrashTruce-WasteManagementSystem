<?php 
ob_start();
include('../FO/location.php');
session_start();
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
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
        <h1>Update Locations</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
    <?php
    // Fetch location details to pre-fill the form
    if (isset($_GET['id'])) {
        $loc_id = $_GET['id'];
        $location = location::GetLocation($loc_id);
        if ($location) {
    ?>
    <input type="hidden" name="ID" value="<?php echo $location->ID; ?>">
    Location Name :
    <input type="text" name="name" value="<?php echo $location->name; ?>" ><br>

    Location Image:
    <input type="file" name="image" ><br>
    
    Nearby Areas/Street:
    <textarea name="nearbyloc" cols="21" rows="2"><?php echo $location->nearbyloc; ?></textarea><br>
    
    Location URL:
    <input type="text" name="url" placeholder="Location URL" value="<?php echo $location->url; ?>"><br>
    <?php
        }
    }
    ?>
    <button class="btnAddProduct" type="submit" name="update">Update Location</button>
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
// Handle form submission to update loaction
if (isset($_POST['update'])) {
  try {
    $loc_id=isset($_POST["ID"])?$_POST["ID"]:null;
    $name=isset($_POST["name"])?$_POST["name"]:"";
    $nearbyloc=isset($_POST["nearbyloc"])?$_POST["nearbyloc"]:"";
    $locurl=isset($_POST["url"])?$_POST["url"]:"";

   $location=new location();
   $location->ID=$loc_id;
   $location->name=$name;
   $location->nearbyloc=$nearbyloc;
   $location->url=$locurl;

   try{
    $location->Update();
    $ID=$location->ID; 
    
    if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
    {
    $Image = $_FILES["image"]["name"];
    $info = new SplFileInfo($Image);
    $newName = "../location_image/" . $ID . 'l.' . $info->getExtension();
    move_uploaded_file($_FILES["image"]["tmp_name"], $newName);

    $location->img = $newName;
    $location->UpdateImage();
}
} catch (Exception $ex) {
echo $ex->getMessage();
}
$_SESSION['update_loc'] = '<script>alert("Location updated successfully");</script>';
header("Location: Location.php");
exit();

} catch (Exception $e) {
$_SESSION['update_loc'] =  '<script>alert("Failed to update location: ");</script>' . $e->getMessage();
header("Location: EditLocations.php?ID=" . $loc_id);
exit();
}
}
ob_flush();
?>
