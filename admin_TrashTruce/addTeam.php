<?php 
ob_start();
include('../FO/team.php');
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
    <link href="assets/css/AddP.css" rel="stylesheet">
    <title>Add Team  Member</title>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>
    <br><br>
    <div class="main">
        <div class="AddProduct">
            
            <h1>Add Team</h1><br>
            <!-- Form to add Team -->
            <form action="" method="post" enctype="multipart/form-data">
                Name:
                <input type="text" name="Name" required><br>

                Image:
                <input type="file" name="image" required><br>

                
                Position:
                <input type="text" name="position" required><br>

                Description :
                <textarea name="desc" cols="21" rows="2" required></textarea><br>

            <br><br>
                <button class="btnAddProduct" type="submit" name="btnAdd">Add Member</button>
            </form>
            <!-- End of Form -->
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>
<?php 
if(isset($_POST["btnAdd"])){
    $team = new Team();
    $team->name = $_POST['Name'];
    $team->position = $_POST['position'];
    $team->description = $_POST['desc'];

    // Check if file is selected and it is an image
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $fileType = $_FILES["image"]["type"];
        
        if(in_array($fileType, $allowedTypes)){
            try {
                $id = $team->Add();  
                $Image = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($Image); 
                $newName = "../team_image/" . $id . 't.' . $info->getExtension(); 
                $team->ID = $id;
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                $team->img = $newName; 
                $team->UpdateImage();

                $_SESSION['add_team'] = '<script>alert("Team Member added Successfully");</script>';
                header("Location: Team.php");
                exit(); // Stop further execution after redirection
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
