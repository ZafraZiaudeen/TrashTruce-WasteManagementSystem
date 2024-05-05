<?php
ob_start();
include('../FO/news.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
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
    <title>News</title>
</head>
<body>
    <div>
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">


<div class="AddProduct">
        <h1>Add News</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
                
            
                News Name :
                <input type="text" name="Name" required><br>
            
                Description:
                <textarea name="Des" cols="21" rows="4" required></textarea><br>
            
                News Image:
                <input type="file" name="image" required><br>
            
                Date:
                <input type="date" name="date" placeholder="Price" required><br><br><br>

                <button class="btnAddProduct" name="btn_add" type="submit" required>Add News</button>
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
    $news = new News();
    $news->name = $_POST['Name'];
    $news->description = $_POST['Des'];
    $news->date = $_POST['date'];
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $fileType = $_FILES["image"]["type"];
        if(in_array($fileType, $allowedTypes)){
            try {
                $id = $news->Add();  
                $imageName = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($imageName); 
                $newName = "../news_image/" . $id . 'n.' . $info->getExtension(); 
                $news->ID = $id;
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                $news->img = $newName; 
                $news->UpdateImage();
                $_SESSION['add_news'] = '<script>alert("News added Successfully");</script>';
                header("Location: News.php");
                exit();
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            echo '<script>alert("Invalid file type. Please upload only image files (JPEG, PNG, GIF).");</script>';
        }
    } else {
        echo '<script>alert("Please select a file to upload.");</script>';
    }
}
ob_flush();
?>