<?php
ob_start();
include('../FO/Recycle.php');
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
        <h1>Recycling Bin</h1>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
                
                Name :
                <input type="text" name="PName" required><br>
            
                Choose Category :
                <select name="category">
                        <option value="Accepted">Accepted</option>
                        <option value="Not Accepted">Not Accepted</option>
                        <option value="Other Materials">Other Materials</option>
                    </select><br>
            
                 Description:
                <textarea name="txtSDes" cols="21" rows="4" required></textarea><br>
            
                Image:
                <input type="file" name="image" required><br>

                <button class="btnAddProduct" type="submit" name="btnAdd">Add</button>
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
if(isset($_POST["btnAdd"])){
    $bin = new Recycle();
    $bin->bname = $_POST['PName'];
    $bin->bcat = $_POST['category'];
    $bin->bdesc = $_POST['txtSDes'];

    // Check if file is selected and it is an image
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $fileType = $_FILES["image"]["type"];
        
        if(in_array($fileType, $allowedTypes)){
            try {
                $id = $bin->AddBin();  
                $Image = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($Image); 
                $newName = "../bimg/" . $id . 'b.' . $info->getExtension(); 
                $bin->bid = $id;
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                $bin->bimg = $newName; 
                $bin->UpdateBImage();

                // Set success message in session
                $_SESSION['add_type'] = '<script>alert("Type added Successfully");</script>';
                
                // Redirect to the appropriate page
                header("Location: Bin.php");
                exit();
            } catch (Exception $ex) {
                $_SESSION['add_type'] = '<script>alert("Failed to add type: '.$ex->getMessage().'");</script>';
                header("Location: AddBin.php");
                exit();
            }
        } else {
            $_SESSION['add_type'] = '<script>alert("Invalid file type. Please upload only image files (JPEG, PNG, GIF).");</script>';
            header("Location: AddBin.php");
            exit();
        }
    } else {
        $_SESSION['add_type'] = '<script>alert("Please select a file to upload.");</script>';
        header("Location: AddBin.php");
        exit();
    }
}
ob_flush();
?>
