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
        <h1>Update Recycled</h1>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['id'])) {
                $process_id = $_GET['id'];
                $process = Recycle::GetProcess($process_id);
                if ($process) {
            ?>              
                Recycled Name :
                <input type="text" name="PName" value="<?php echo $process->pname; ?>"><br>
            
                Description:
                <textarea name="PDes" cols="21" rows="4"><?php echo $process->pdesc; ?></textarea><br>
            
                Video Clip:
                <input type="file" name="PVid"><br><br><br>

                <?php
                }
            }
            ?>
                <button class="btnAddProduct" type="submit" name="UpdateProcess">Update Process</button>
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
if (isset($_POST['UpdateProcess'])) {
    try {
        // Retrieve form data
        $pID = isset($_GET['id']) ? $_GET['id'] : null; // Assuming the process ID is passed via GET
        $pname = isset($_POST["PName"]) ? $_POST["PName"] : "";
        $pdesc = isset($_POST["PDes"]) ? $_POST["PDes"] : "";
        $pvid = isset($_FILES["PVid"]["name"]) ? $_FILES["PVid"]["name"] : ""; // Assuming the video file is optional

        // If no new video uploaded, keep the existing video
        if (empty($pvid)) {
            $process = Recycle::GetProcess($pID);
            if ($process) {
                $pvid = $process->pvid;
            }
        }

        // Create a Recycle object
        $recycle = new Recycle();
        $recycle->pID = $pID; // Assigning process ID
        $recycle->pname = $pname;
        $recycle->pdesc = $pdesc;
        $recycle->pvid = $pvid;

        // Update the recycling process
        $recycle->UpdateProcess();

        // Handle file upload if a video file is provided
        if (!empty($_FILES["PVid"]["tmp_name"])) { // Check if a new file is uploaded
            $uploadDir = "../processVideos/";
            $uploadFile = $uploadDir . basename($_FILES['PVid']['name']);
            
            // Move the uploaded file to the destination directory
            if (move_uploaded_file($_FILES['PVid']['tmp_name'], $uploadFile)) {
                // File uploaded successfully
                echo '<script>alert("Recycling process updated successfully.");</script>';
                header("Location: Recycling.php");
                exit();
            } else {
                // Error uploading file
                echo '<script>alert("Possible file upload attack!");</script>';
            }
        } else {
            // If no new video file uploaded, redirect to Recycling.php
            header("Location: Recycling.php");
            exit();
        }
    } catch (Exception $ex) {
        echo '<script>alert("' . $ex->getMessage() . '");</script>';
    }
}
ob_flush();
?>
