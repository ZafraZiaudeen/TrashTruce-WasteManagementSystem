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
        <?php include "Header.php"; ?>
     </div>

     <div class="main">
        <div class="AddProduct">
            <h1>Update Bin</h1>
            <!-- Update bin form -->
            <form action="" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['id'])) {
                $bin_id = $_GET['id'];
                $bin = Recycle::GetBin($bin_id);
                if ($bin) {
            ?>          
                Name :
                <input type="text" name="BName" value="<?php echo $bin->bname; ?>"><br>
            
                Choose Category :
                <select name="category">
                    <option value="Accepted" <?php if ($bin->bcat == 'Accepted') echo 'selected'; ?>>Accepted</option>
                    <option value="Not Accepted" <?php if ($bin->bcat == 'Not Accepted') echo 'selected'; ?>>Not Accepted</option>
                    <option value="Other Materials" <?php if ($bin->bcat == 'Other Materials') echo 'selected'; ?>>Other Materials</option>
                </select><br>
            
                Description:
                <textarea name="bdesc" cols="21" rows="4"><?php echo $bin->bdesc; ?></textarea><br>

            
                Image:
                <input type="file" name="image"><br>
                
            <?php
                }
            }
            ?>

            <button class="btnAddProduct" type="submit" name="Update">Update Bin</button>
            </form>
            <!-- Finish form -->
        </div>
    </div>

    <div>
    <?php include "Footer.html"; ?>
    </div>
</body>
</html>
<?php
if (isset($_POST['Update'])) {
    try {
        // Retrieve form data
        $bin_id = isset($_GET['id']) ? $_GET['id'] : null; 
        $bname = isset($_POST["BName"]) ? $_POST["BName"] : "";
        $category = isset($_POST["category"]) ? $_POST["category"] : "";
        $bdesc = isset($_POST["bdesc"]) ? $_POST["bdesc"] : "";
       
   $bin=new Recycle();
   $bin->bid=$bin_id;
   $bin->bname=$bname;
   $bin->bcat=$category;
   $bin->bdesc=$bdesc;

   try{
    $bin->UpdateBin();
    $ID=$bin->bid; 
    
    if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
    {
    $Image = $_FILES["image"]["name"];
    $info = new SplFileInfo($Image);
    $newName = "../bimg/" . $ID . 'b.' . $info->getExtension();

    move_uploaded_file($_FILES["image"]["tmp_name"], $newName);

    $bin->bimg = $newName;
    $bin->UpdateBImage();
}
} catch (Exception $ex) {
echo $ex->getMessage();
}
$_SESSION['update_bin'] = '<script>alert("Bin updated successfully");</script>';
header("Location: Bin.php");
exit();

} catch (Exception $e) {
$_SESSION['update_bin'] =  '<script>alert("Failed to update Bin: ");</script>' . $e->getMessage();
header("Location: EditBin.php?ID=" .$bin_id);
exit();
}
}
ob_flush();
?>