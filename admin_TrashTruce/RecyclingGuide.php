<?php 
include('../FO/Recycle.php');

// Fetch all recycling guides
$recycle = new Recycle();
$guides = $recycle->GetGuides();
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
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Recycling Guides</title>
</head>
<body>
<?php

if (isset($_SESSION['delete_guide']) && !empty($_SESSION['delete_guide'])) {
    echo $_SESSION['delete_guide'];
    unset($_SESSION['delete_guide']);
}

// Retrieve guide from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $guide = Recycle::SearchGuide($search);
} else {
    $guide = Recycle::GetGuides();
}
?>
    <div>
       <?php
         include "Header.php";
        ?>
    </div>

    <div class="main">
        <div class="colorbar">
            <h1>Recycled</h1>
        </div>

        <div class="btnAll">
            <!--------------------------------Add Products button------------------------->
            <div class="btnAllDlt"><button class="btn10"><a href="AddRGuide.php">Add Guide</a></button></div>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Recycling Guide Name</th>
                    <th>Recycling File</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
                <?php if (count($guide) > 0): ?>
                <?php foreach ($guides as $index => $guide): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $guide->gname; ?></td>
                        <td><?php echo $guide->gfile; ?></td>
                        <td><?php echo $guide->gdate?></td>
                        <td>
                        <?php echo '<a href="deleteGuide.php?id='.$guide->gID.'" onclick="return confirm(\'Are you sure you want to delete this Guide?\');"><span class="material-symbols-outlined">delete</span></a>';?>
                            <?php echo '<a href="EditGuide.php?id='.$guide->gID.'"><span class="material-symbols-outlined">edit</span>';?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No Guides found.</td>
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
