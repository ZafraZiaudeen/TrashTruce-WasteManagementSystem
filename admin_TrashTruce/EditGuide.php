<?php 
ob_start();
include('../FO/Recycle.php');
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
</head>
<body>
    <div>
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">

<div class="AddProduct">
        <h1>Update Recycling Guide</h1>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">

            <?php
            // Fetch guide details to pre-fill the form
            if (isset($_GET['id'])) {
                $guide_id = $_GET['id'];
                $guide = Recycle::GetGuide($guide_id);
                if ($guide) {
            ?>
                Recycling Guide Name :
                <input type="text" name="Gname" value="<?php echo $guide->gname; ?>"><br>
            
                PDF File (only PDF allowed):
                <input type="file" name="pdf" accept=".pdf"><br>
            
                <?php
                }
            }
            ?>
                <button class="btnAddProduct" type="submit" name="updateGuide">Update</button>
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
if(isset($_POST["updateGuide"])){
    // Fetch guide details from the form
    $guide_id = $_GET['id'];
    $guide = Recycle::GetGuide($guide_id);
    
    if ($guide) {
        // Update guide details with new values
        $guide->gname = $_POST['Gname'];
        $guide->Update();
        $guide->gfile = $_FILES['pdf']['name']; // New file name
        
        try {
            // Check if a file was uploaded
            if (!empty($_FILES['pdf']['name'])) {
                // Check if the uploaded file is a PDF
                $fileType = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));
                if ($fileType != 'pdf') {
                    throw new Exception("Only PDF files are allowed.");
                }
                
                // Update the guide in the database
                $guide->Update();
                
                // Handle file upload
                $uploadDir = "../RGuide/";
                $uploadFile = $uploadDir . basename($_FILES['pdf']['name']);
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
                    // File uploaded successfully
                    echo '<script>alert("Guide updated successfully.");</script>';
                    header("Location: RecyclingGuide.php");
                    exit();
                } else {
                    // Error uploading file
                    echo '<script>alert("Possible file upload attack!");</script>';
                }
            } else {
                // No file provided for upload
                echo '<script>alert("Guide updated successfully.");</script>';
                header("Location: RecyclingGuide.php");
                exit();
            }
        } catch (Exception $ex) {
            echo '<script>alert("' . $ex->getMessage() . '");</script>';
        }
    } else {
        echo '<script>alert("Guide not found.");</script>';
    }
}
ob_flush();
?>
