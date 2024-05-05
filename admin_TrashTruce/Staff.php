<?php 
ob_start();
include('../FO/Staff.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

// Retrieve Staff from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $staff = staff::SearchStaff($search); 
} else {
    $staff = staff::GetStaffs();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Staff Management</title>
</head>
<body>
<?php
if (isset($_SESSION['staff_add']) && !empty($_SESSION['staff_add'])) {
    echo $_SESSION['staff_add'];
    unset($_SESSION['staff_add']);
}
if (isset($_SESSION['delete_staff']) && !empty($_SESSION['delete_staff'])) {
    echo $_SESSION['delete_staff'];
    unset($_SESSION['delete_staff']);
}
if (isset($_SESSION['updatepw']) && !empty($_SESSION['updatepw'])) {
    echo $_SESSION['updatepw'];
    unset($_SESSION['updatepw']);
}
?>
<div>
    <?php include "Header.php"; ?>
</div>
<div class="main">
    <div class="colorbar">
        <h1>Staff</h1>
    </div>
    <div class="btnAll">
        <div class="btnAllDlt"><button class="btn10"><a href="AddStaff.php">Add Staff</a></button></div>
    </div>
    <div class="intro">
        <table>
            <tr>
                <th>Serial</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Position</th>
                <th>Email Address</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Action</th>
            </tr>
            <?php if (count($staff) > 0): ?>
                <?php foreach ($staff as $index => $staffMember): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $staffMember->fname; ?></td>
                        <td><?php echo $staffMember->lname; ?></td>
                        <td><?php echo $staffMember->dob; ?></td>
                        <td><?php echo $staffMember->position; ?></td>
                        <td><?php echo $staffMember->email; ?></td>
                        <td><?php echo $staffMember->address; ?></td>
                        <td><?php echo $staffMember->phone; ?></td>
                        <td>
                            <a href="deleteStaff.php?id=<?php echo $staffMember->ID; ?>" onclick="return confirm('Are you sure you want to delete this staff member?');">
                                <span class="material-symbols-outlined">delete</span>
                            </a>
                            <a href="EditStaff.php?id=<?php echo $staffMember->ID; ?>">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <a href="ChangePwd.php?id=<?php echo $staffMember->ID; ?>">
                                <i class="fa-solid fa-key"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No Staff Details Found.</td>
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
