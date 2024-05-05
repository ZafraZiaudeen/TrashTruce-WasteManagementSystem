<?php 
ob_start();
include('../FO/schedule.php');
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
        <h1>Update Schedule</h1>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">

            <?php
            if (isset($_GET['id'])) {
                $schedule_id = $_GET['id'];
                $schedule = Schedule::GetSchedule($schedule_id);
                if ($schedule ) {
            ?>
                 Name :
                <input type="text" name="name" value="<?php echo $schedule->name; ?>"><br>
                Description:
                <textarea name="desc" cols="21" rows="2"><?php echo $schedule->description; ?></textarea><br>
            
                PDF File (only PDF allowed):
                <input type="file" name="pdf" accept=".pdf"><br>
            
                <?php
                }
            }
            ?>
                <button class="btnAddProduct" type="submit" name="updateSchedule">Update</button>
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
if(isset($_POST["updateSchedule"])){
    // Fetch schedule details from the form
    $schedule_id = $_GET['id'];
    $schedule = Schedule::GetSchedule($schedule_id);
    
    if ($schedule) {
        // Update schedule details with new values
        $schedule->name = $_POST['name'];
        $schedule->description = $_POST['desc'];
        $schedule->Update();
        $schedule->file = $_FILES['pdf']['name']; // New file name
        
        try {
            // Check if a file was uploaded
            if (!empty($_FILES['pdf']['name'])) {
                // Check if the uploaded file is a PDF
                $fileType = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));
                if ($fileType != 'pdf') {
                    throw new Exception("Only PDF files are allowed.");
                }
                
                // Update the schedule in the database
                $schedule->Update();
                
                // Handle file upload
                $uploadDir = "../Schedules/";
                $uploadFile = $uploadDir . basename($_FILES['pdf']['name']);
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
                    // File uploaded successfully
                    echo '<script>alert("Schedule updated successfully.");</script>';
                    header("Location: Schedule.php");
                    exit();
                } else {
                    // Error uploading file
                    throw new Exception("Possible file upload attack!");
                }
            } else {
                // No file provided for upload
                echo '<script>alert("Schedule updated successfully.");</script>';
                header("Location: Schedule.php");
                exit();
            }
        } catch (Exception $ex) {
            echo '<script>alert("' . $ex->getMessage() . '");</script>';
        }
    } else {
        echo '<script>alert("Schedule not found.");</script>';
    }
}
ob_flush();
?>