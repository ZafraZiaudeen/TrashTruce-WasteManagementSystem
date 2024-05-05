<?php 
ob_start();
include('../FO/team.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/AddP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Edit-Team</title>
</head>
<body>
    <div>
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">

<div class="AddProduct">
        <h1>Update Team Member</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
            
       <?php
       // Fetch team details to pre-fill the form
       if (isset($_GET['id'])) {
           $team_id = $_GET['id'];
           $team = Team::GetMember($team_id);
           if ($team) {
       ?>
       <input type="hidden" name="ID" value="<?php echo $team->ID; ?>">
       Name :
       <input type="text" name="name" value="<?php echo $team->name; ?>"><br>
   
       Image:
       <!-- Display existing image if available -->
       <?php if ($team->img): ?>
       <img src="<?php echo $team->img; ?>" alt="Current Image" width="100px" height="100px"><br>
       <?php endif; ?>
       <input type="file" name="image"><br> 
   
       Position :
       <input type="text" name="position" value="<?php echo $team->position; ?>" ><br>
   
       Description:
       <textarea name="Des" cols="21" rows="2"><?php echo $team->description; ?></textarea><br>
   
       <?php
           }
       }
       ?>
       <button class="btnAddProduct" type="submit" name="update">Update Member</button>
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
    $team_id=isset($_POST["ID"])?$_POST["ID"]:null;
    $name=isset($_POST["name"])?$_POST["name"]:"";
    $pos=isset($_POST["position"])?$_POST["position"]:"";
    $des=isset($_POST["Des"])?$_POST["Des"]:"";


   $team=new Team();
   $team->ID=$team_id;
   $team->name=$name;
   $team->position=$pos;
    $team->description=$des;


   try{
    $team->Update();
    $ID=$team->ID; 
    
    if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
    {
    $Image = $_FILES["image"]["name"];
    $info = new SplFileInfo($Image);
    $newName = "../team_image/" . $ID . 't.' . $info->getExtension();
    move_uploaded_file($_FILES["image"]["tmp_name"], $newName);

    $team->img = $newName;
    $team->UpdateImage();
}
} catch (Exception $ex) {
echo $ex->getMessage();
}
$_SESSION['update_team'] = '<script>alert("Team updated successfully");</script>';
header("Location: Team.php");
exit();

} catch (Exception $e) {
$_SESSION['update_team'] =  '<script>alert("Failed to update team member: ");</script>' . $e->getMessage();
header("Location: EditTeam.php?ID=" . $team_id);
exit();
}
}
ob_flush();
?>
