<?php 
ob_start();
include('../FO/events.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/AddP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Update Events</title>
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>

    <div class="AddProduct">
        <h1>Update Events</h1>
        <!-- Start Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <?php
            // Fetch event details to pre-fill the form
            if (isset($_GET['id'])) {
                $event_id = $_GET['id'];
                $event = events::GetEvent($event_id);
                if ($event) {
            ?>
            <!-- Pre-filled inputs -->
            <input type="hidden" name="ID" value="<?php echo $event->ID; ?>">
            Event Name : 
            <input type="text" name="name" value="<?php echo $event->name; ?>"><br>
            Description: 
            <textarea name="description" cols="21" rows="4"><?php echo $event->desc; ?></textarea><br>
            location: 
            <input type="text" name="location" value="<?php echo $event->loc; ?>"><br><br>
            Date: 
            <input type="text" name="date" value="<?php echo $event->date; ?>"><br>
            Time: 
            <input type="text" name="time" value="<?php echo $event->time; ?>"><br>
            <?php
                }
            }
            ?>

            <!-- Image input -->
            Image: <input type="file" name="image"><br>

            <!-- Submit button -->
            <button class="btnAddProduct" type="submit" name="update_event">Update Event</button>
        </form>
        <!-- End Form -->
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>

<?php
// Handle form submission to update event
if (isset($_POST['update_event'])) {
  try {
    $event_id=isset($_POST["ID"])?$_POST["ID"]:null;
    $name=isset($_POST["name"])?$_POST["name"]:"";
    $date=isset($_POST["date"])?$_POST["date"]:"";
    $time=isset($_POST["time"])?$_POST["time"]:"";
    $description=isset( $_POST["description"])?$_POST["description"]:"";
    $location=isset( $_POST["location"])?$_POST["location" ]:"";

   $event=new events();
   $event->ID=$event_id;
   $event->name=$name;
   $event->date=$date;
   $event->time=$time;
   $event->desc=$description;
   $event->loc=$location;

   try{
    $event->Update();
    $ID=$event->ID; // Update the ID in case it changed during the insertion process
    
    if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
    {
    $Image = $_FILES["image"]["name"];
    $info = new SplFileInfo($Image);
    $newName = "../event_img/" . $ID . 'e.' . $info->getExtension();
    move_uploaded_file($_FILES["image"]["tmp_name"], $newName);

    $event->img = $newName;
    $event->UpdateImage();
}
} catch (Exception $ex) {
echo $ex->getMessage();
}
$_SESSION['update_event'] = '<script>alert("Event updated successfully");</script>';
header("Location: Events.php");
exit();

} catch (Exception $e) {
$_SESSION['update_event'] =  '<script>alert("Failed to update Event: ");</script>' . $e->getMessage();
header("Location: EditEvent.php?ID=" . $event_id);
exit();
}
}
ob_flush();
?>
