<?php
ob_start();
include('../FO/gallery.php');
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
    <title>Add-Gallery</title>
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
        <h1>Add Gallery</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
                 Name :
                <input type="text" name="Name" required><br>

                Image:
                <input type="file" name="image" required><br>
                Featured:
                <div class="radio-container">
                    <input type="radio" id="featured_yes" name="featured" value="Yes" checked>
                    <label for="featured_yes" class="radio-label">Yes</label>
                </div>
                <div class="radio-container">
                    <input type="radio" id="featured_no" name="featured" value="No">
                    <label for="featured_no" class="radio-label">No</label>
                </div>
        <br><br>

                <button class="btnAddProduct" type="submit" name="btn_add">Add Gallery</button>
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
    $gallery = new Gallery();
    $gallery->name = $_POST["Name"];

    if (isset($_POST["featured"])) {
        $gallery->featured = $_POST["featured"];
    } else {
        // Default value
        $gallery->featured = "No";
    }

    // Check if file is selected and it is an image
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $fileType = $_FILES["image"]["type"];
        
        if(in_array($fileType, $allowedTypes)){
            try {
                $id = $gallery->Add();  
                $Image = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($Image); 
                $newName = "../gallery_image/" . $id . 'g.' . $info->getExtension(); 
                $gallery->ID = $id;
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                $gallery->img = $newName; 
                $gallery->UpdateImage();

                // Set success message in session
                $_SESSION['add_gallery'] = '<script>alert("Gallery added Successfully");</script>';
                
                // Redirect to the appropriate page
                header("Location: Gallery.php");
                exit();
            } catch (Exception $ex) {
                $_SESSION['add_gallery'] = '<script>alert("Failed to add Gallery: '.$ex->getMessage().'");</script>';
                header("Location: AddGallery.php");
                exit();
            }
        } else {
            $_SESSION['add_gallery'] = '<script>alert("Invalid file type. Please upload only image files (JPEG, PNG, GIF).");</script>';
            header("Location: AddGallery.php");
            exit();
        }
    } else {
        $_SESSION['add_gallery'] = '<script>alert("Please select a file to upload.");</script>';
        header("Location: AddGallery.php");
        exit();
    }
}
ob_flush();
?>