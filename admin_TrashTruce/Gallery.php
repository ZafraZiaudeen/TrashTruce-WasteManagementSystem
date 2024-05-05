<?php
include('../FO/gallery.php');

// Fetch gallery data
$gallery = Gallery::GetGalleries();

session_start();
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
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Gallery</title>
</head>
<body>
    <div>
       <?php
         include "Header.php";
        ?>
    </div>
    </div>
  <div class="main">
        <div class="colorbar">
          <h1>Gallery</h1>
        </div>
        <?php
          if (isset($_SESSION['add_gallery']) && !empty($_SESSION['add_gallery'])) {
            echo $_SESSION['add_gallery'];
            unset($_SESSION['add_gallery']);
        }
        if (isset($_SESSION['update_gal']) && !empty($_SESSION['update_gal'])) {
            echo $_SESSION['update_gal'];
            unset($_SESSION['update_gal']);
        }
            if (isset($_SESSION['delete_gal']) && !empty($_SESSION['delete_gal'])) {
                echo $_SESSION['delete_gal'];
                unset($_SESSION['delete_gal']);
            }

             // Retrieve gallery from the database based on the search query
             if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $_GET['search'];
                $gallery = Gallery::SearchGallery($search);
            } else {
                $gallery = Gallery::GetGalleries();
            }
            ?>

        <div class="btnAll">

<!--------------------------------Add Products button------------------------->
<div class="btnAllDlt"><button class="btn10"><a href="AddGallery.php">Add Gallery</a></button></div>

    </div>

    <div class="intro">
    <table>
        <tr>
            <th>Serial No.</th>
            <th>Name</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Action</th>
        </tr>
        <?php if (count($gallery) > 0): ?>
        <?php foreach ($gallery as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $item->name ; ?></td>
                    <td><img src="<?php echo $item->img ; ?>" alt="Gallery Image" width="100px" height="100px"></td>
                    <td><?php echo $item->featured; ?></td>
                    <td>
                    <a href="deleteGallery.php?id=<?php echo $item->ID; ?>"onclick="return confirm('Are you sure you want to delete this Gallery?');" ><span class="material-symbols-outlined">delete</span>
                        <a href="EditGallery.php?id=<?php echo $item->ID; ?>"><span class="material-symbols-outlined">edit</span></a>
                    </td>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No Gallery Details Found</td>
                    </tr>
                <?php endif; ?>
    </table>
</div>

  </div>
    <div>
        <?php
        include "Footer.html";
        ?>
    </div>
</body>
</html>
