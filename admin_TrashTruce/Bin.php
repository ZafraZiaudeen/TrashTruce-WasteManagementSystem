<?php
include('../FO/Recycle.php');
session_start();
// Retrieve bins from the database
$bins = Recycle::GetBins();

$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
  }
  if (isset($_SESSION['add_type']) && !empty($_SESSION['add_type'])) {
    echo $_SESSION['add_type'];
    unset($_SESSION['add_type']);
}
if (isset($_SESSION['delete_bin']) && !empty($_SESSION['delete_bin'])) {
    echo $_SESSION['delete_bin'];
    unset($_SESSION['delete_bin']);
}
if (isset($_SESSION['update_bin']) && !empty($_SESSION['update_bin'])) {
    echo $_SESSION['update_bin'];
    unset($_SESSION['update_bin']);
}
// Retrieve bins from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $bins = Recycle::SearchBins($search);
} else {
    $bins = Recycle::GetBins();
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
    <title>Document</title>
</head>
<body>
    <div>
       <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <div class="colorbar">
            <h1>Recycling Bin</h1>
        </div>
      
        <div class="btnAll">
          

            <!-- Add button -->
            <div class="btnAllDlt"><button class="btn10"><a href="AddBin.php">Add Bin</a></button></div>
        </div>

        <div class="intro">
    <table>
        <tr>
            <th>Serial No</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php if (count($bins) > 0): ?>
            <?php foreach ($bins as $index => $bin): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $bin->bname; ?></td>
                    <td><?php echo $bin->bcat; ?></td>
                    <td><?php echo $bin->bdesc; ?></td>
                    <td><img src="<?php echo $bin->bimg; ?>" alt="<?php echo $bin->bname; ?>" width="100px" height="100px"></td>
                    <td>
                        <a href="deleteBin.php?id=<?php echo $bin->bid; ?>" onclick="return confirm('Are you sure you want to delete this bin?');"><span class="material-symbols-outlined">delete</span></a>
                        <a href="EditBin.php?id=<?php echo $bin->bid; ?>"><span class="material-symbols-outlined">edit</span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No bins details found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>

