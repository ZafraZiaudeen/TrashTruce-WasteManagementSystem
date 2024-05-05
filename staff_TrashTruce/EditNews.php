<?php 
ob_start();
include('../FO/news.php');
session_start();
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
        <h1>Update News</h1>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
            <?php
              if (isset($_GET['id'])) {
              $news_id = $_GET['id'];
              $news = News::GetSNews($news_id);
              if ($news) {
              ?>
               <input type="hidden" name="ID" value="<?php echo $news->ID; ?>">
                News Title :
                <input type="text" name="Name" value="<?php echo $news->name; ?>"><br>
            
                 Description:
                <textarea name="Des" cols="21" rows="4"><?php echo $news->description; ?></textarea><br>
            
                News Image:
                <input type="file" name="image" value="<?php echo $news->img; ?>"><br>
            
                Date:
                <input type="date" name="date" placeholder="Date" value="<?php echo $news->date; ?>"><br><br><br>
                <?php
                }
              }
              ?>
                <button class="btnAddProduct" name="updateNews" type="submit">Update News</button>
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
// Handle form submission to update news
if (isset($_POST['updateNews'])) {
  try {
    $news_id=isset($_POST["ID"])?$_POST["ID"]:null;
    $name=isset($_POST["Name"])?$_POST["Name"]:"";
    $description=isset( $_POST["Des"])?$_POST["Des"]:"";
    $date=isset($_POST["date"])?$_POST["date"]:"";

   $news=new News();
   $news->ID=$news_id;
   $news->name=$name;
   $news->date=$date;
   $news->description=$description;

   try{
    $news->Update();
    $ID=$news->ID;
    
    if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
    {
    $Image = $_FILES["image"]["name"];
    $info = new SplFileInfo($Image);
    $newName = "../news_image/" . $ID . 'N.' . $info->getExtension();
    move_uploaded_file($_FILES["image"]["tmp_name"], $newName);

    $news->img = $newName;
    $news->UpdateImage();
}
} catch (Exception $ex) {
echo $ex->getMessage();
}
$_SESSION['update_news'] = '<script>alert("News updated successfully");</script>';
header("Location: News.php");
exit();

} catch (Exception $e) {
$_SESSION['update_news'] =  '<script>alert("Failed to update News: ");</script>' . $e->getMessage();
header("Location: EditNews.php?ID=" . $news_id);
exit();
}
}
ob_flush();
?>
