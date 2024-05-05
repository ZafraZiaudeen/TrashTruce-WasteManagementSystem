<?php 
include('../FO/Recycle.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

// Retrieve process from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $processes = Recycle::SearchProcess($search);
} else {
    $processes = Recycle::GetProcesses();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Recycling Process Details</title>
</head>
<body>
  
<?php
if (isset($_SESSION['delete_process']) && !empty($_SESSION['delete_process'])) {
    echo $_SESSION['delete_process'];
    unset($_SESSION['delete_process']);
}
?>
  
<div>
    <?php include "Header.php"; ?>
</div>

<div class="main">
    <div class="colorbar">
        <h1>Recycling Process</h1>
    </div>

    <div class="btnAll">
        <div class="btnAllDlt"><button class="btn10"><a href="AddRecycling.php">Add Recycling Process</a></button></div>
    </div>

    <div class="intro">
        <table>
            <tr>
                <th>Serial No</th>
                <th>Recycling Process Name</th>
                <th>Description</th>
                <th>Video Clip</th>
                <th>Action</th>
            </tr>
            <?php if (count($processes) > 0): ?>
                <?php foreach ($processes as $index => $process): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $process->pname; ?></td>
                        <td><?php echo $process->pdesc; ?></td>
                        <td><video src='../processVideos/<?php echo $process->pvid; ?>' width='300' height='200' controls></video></td>
                        <td>
                            <a href='deleteProcess.php?id=<?php echo $process->pID; ?>' onclick="return confirm('Are you sure you want to delete this Process?');"><span class='material-symbols-outlined'>delete</span></a>
                            <a href='EditRecycle.php?id=<?php echo $process->pID; ?>'><span class='material-symbols-outlined'>edit</span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No Processes found.</td>
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
