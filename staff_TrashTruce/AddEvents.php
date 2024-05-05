<?php
ob_start();
include('../FO/events.php');
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
    <title>Add Event</title>
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <div class="AddProduct">
            <h1>Add Events</h1><br>
            <form action="" method="post" enctype="multipart/form-data">
                Event Name:
                <input type="text" name="EName" required><br>

                Location:
                <input type="text" name="location" required><br>

                Description:
                <textarea name="txtSDes" cols="21" rows="4" required></textarea><br>

                Date:
                <input type="text" name="date" required><br>

                Time:
                <input type="text" name="time" required><br>
                
                Image:
                <input type="file" name="image" required><br>

                <button class="btnAddProduct" type="submit" name="btnadd-event">Add Event</button>
            </form>
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>

<?php
if(isset($_POST["btnadd-event"])){
    $event = new events();
    $event->name = $_POST['EName'];
    $event->desc = $_POST['txtSDes'];
    $event->loc = $_POST['location'];
    $event->date = $_POST['date'];
    $event->time = $_POST['time'];

    // Check if file is selected and it is an image
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $fileType = $_FILES["image"]["type"];
        
        if(in_array($fileType, $allowedTypes)){
            try {
                $id = $event->Add();  
                $Image = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($Image); 
                $newName = "../event_img/" . $id . 'e.' . $info->getExtension(); 
                $event->ID = $id;
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                $event->img = $newName; 
                $event->UpdateImage();

                // Set success message in session
                $_SESSION['add_event'] = '<script>alert("Event added Successfully");</script>';
                
                // Redirect to the appropriate page
                header("Location: Events.php");
                exit();
            } catch (Exception $ex) {
                $_SESSION['add_event'] = '<script>alert("Failed to add event: '.$ex->getMessage().'");</script>';
                header("Location: AddEvents.php");
                exit();
            }
        } else {
            $_SESSION['add_event'] = '<script>alert("Invalid file type. Please upload only image files (JPEG, PNG, GIF).");</script>';
            header("Location: AddEvents.php");
            exit();
        }
    } else {
        $_SESSION['add_event'] = '<script>alert("Please select a file to upload.");</script>';
        header("Location: AddEvents.php");
        exit();
    }
}
ob_flush();
?>
