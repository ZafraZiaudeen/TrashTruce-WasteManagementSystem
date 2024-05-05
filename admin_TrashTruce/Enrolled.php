<?php
include('../FO/events.php');
session_start();
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
  }
// Fetch enrolled details
$enrollments = events::GetEnrolled();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<body>
    <div>
       <?php include "Header.php";
                  
// Retrieve enrollments from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $enrollments = events::SearchEnrollments($search); 
} else {
    $enrollments = events::GetEnrolled();
} ?>
       
    </div>

    <div class="main">
        <div class="colorbar">
          <h1>Enrolled</h1>
        </div>
      
        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Event Name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                <?php if (count($enrollments) > 0): ?>
                <?php foreach ($enrollments as $index => $enrollment): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $enrollment->event_name; ?></td>
                        <td><?php echo $enrollment->ename; ?></td>
                        <td><?php echo $enrollment->eemail; ?></td>
                        <td><?php echo $enrollment->ephone; ?></td>
                        <td><?php echo $enrollment->eaddress; ?></td>
                        <td>
                            <a href="deleteEnrolled.php?id=<?php echo $enrollment->ID; ?>" onclick="return confirm('Are you sure you want to delete this Enrollment?');">
                                <span class="material-symbols-outlined">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No Enrollment details found.</td>
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
