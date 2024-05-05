<?php 
ob_start();
include('../FO/gallery.php');
session_start();

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
    <style>
        /* Style for radio buttons */
        .radio-container {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        .radio-container input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: inline-block;
            cursor: pointer;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
        }

        .radio-label:hover {
            background-color: #006A4E;
        }

        .radio-container input[type="radio"]:checked + .radio-label {
            background-color: #006A4E;
            color: #fff;
            border-color: #007bff;
        }

        /* Hide default radio button */
        input[type="radio"] {
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">

<div class="AddProduct">
        <h1>Update Gallery</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
    <?php
    // Fetch gallery details to pre-fill the form
    if (isset($_GET['id'])) {
        $gal_id = $_GET['id'];
        $gallery = Gallery::GetGallery($gal_id);
        if ($gallery) {
    ?>
    <input type="hidden" name="ID" value="<?php echo $gallery->ID; ?>">
    Name :
    <input type="text" name="name" value="<?php echo $gallery->name; ?>" ><br>

    Image:
    <input type="file" name="image" value="<?php echo $gallery->img; ?>"><br>
    
    Featurd:
            <div class="radio-container">
                <input type="radio" id="featured_yes" name="featured" value="Yes" <?php if ($gallery->featured=="Yes") echo "checked"; ?>>
              <label for="featured_yes" class="radio-label">Yes</label>
            </div>
            <div class="radio-container">
            <input type="radio" id="featured_no" name="featured" value="No" <?php if ($gallery->featured == "No") echo "checked"; ?>>
            <label for="featured_no" class="radio-label">No</label>
            </div><br><br>
 
    <?php
        }
    }
    ?>
    <button class="btnAddProduct" type="submit" name="update">Update Gallery</button>
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
// Handle form submission to update event
if (isset($_POST['update'])) {
  try {
    $gal_id=isset($_POST["ID"])?$_POST["ID"]:null;
    $name=isset($_POST["name"])?$_POST["name"]:"";
    $featured = isset($_POST["featured"]) ? $_POST["featured"] : "";


   $gallery=new Gallery();
   $gallery->ID=$gal_id;
   $gallery->name=$name;
   $gallery->featured=$featured;


   try{
    $gallery->Update();
    $ID=$gallery->ID; 
    
    if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
    {
    $Image = $_FILES["image"]["name"];
    $info = new SplFileInfo($Image);
    $newName = "../gallery_image/" . $ID . 'g.' . $info->getExtension();
    move_uploaded_file($_FILES["image"]["tmp_name"], $newName);

    $gallery->img = $newName;
    $gallery->UpdateImage();
}
} catch (Exception $ex) {
echo $ex->getMessage();
}
$_SESSION['update_gal'] = '<script>alert("Gallery updated successfully");</script>';
header("Location: Gallery.php");
exit();

} catch (Exception $e) {
$_SESSION['update_gal'] =  '<script>alert("Failed to update gallery: ");</script>' . $e->getMessage();
header("Location: EditGallery.php?ID=" . $gal_id);
exit();
}
}
ob_flush();
?>
