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
            <h1>Add Recycling Guide</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
                
                Recycling Guide Name :
                <input type="text" name="GName" required><br>
            
                PDF File (only PDF allowed):
                <input type="file" name="pdf" required><br><br><br>

                <button class="btnAddProduct" type="submit" name="btnAddGuide">Add Recycled</button>
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
if(isset($_POST["btnAddGuide"])){
    $guide = new Recycle();
    $guide->gname = $_POST['GName'];
    $guide->gfile = $_FILES['pdf']['name'];
    
    try {
        // Check if the uploaded file is a PDF
        $fileType = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));
        if ($fileType !== 'pdf') {
            throw new Exception('Only PDF files are allowed.');
        }

        $id = $guide->AddGuide();  
        $uploadDir = "../RGuide/";
        $uploadFile = $uploadDir . basename($_FILES['pdf']['name']);

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
            echo '<script>alert("File is valid, and was successfully uploaded.");</script>';
            header("Location: RecyclingGuide.php");
        } else {
            // Error uploading file
            echo '<script>alert("Possible file upload attack!");</script>';
        }

    } catch (Exception $ex) {
        echo '<script>alert("' . $ex->getMessage() . '");</script>';
    }
}
ob_flush();
?>
