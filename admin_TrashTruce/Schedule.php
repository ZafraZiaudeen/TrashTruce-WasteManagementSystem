<?php 
include('../FO/schedule.php');
session_start();
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

// Retrieve Schedules from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $schedules = Schedule::SearchSchedule($search); // Corrected method name
} else {
    $schedules = Schedule::GetSchedules();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Schedule Management</title> <!-- Corrected title -->
</head>
<body>
    <?php
    include "Header.php";
    ?>

    <div class="main">
        <div class="colorbar">
            <h1>Schedule</h1>
        </div>
      
        <div class="btnAll">
            <!-- Add Schedule button -->
            <div class="btnAllDlt">
                <button class="btn10"><a href="AddSchedule.php">Add Schedule</a></button>
            </div>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Schedule Doc</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
                <?php if (count($schedules) > 0): ?>
                    <?php foreach ($schedules as $index => $schedule) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $schedule->name; ?></td>
                            <td><?php echo $schedule->description; ?></td>
                            <td><?php echo $schedule->file; ?></td>
                            <td><?php echo $schedule->date; ?></td>
                            <td>
                                <a href="deleteSchedule.php?id=<?php echo $schedule->ID; ?>" onclick="return confirm('Are you sure you want to delete this Schedule?');"><span class="material-symbols-outlined">delete</span></a>
                                <a href="EditSchedule.php?id=<?php echo $schedule->ID; ?>"><span class="material-symbols-outlined">edit</span></a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No Schedules Found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
  
    <?php include "Footer.html"; ?>
</body>
</html>
