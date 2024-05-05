<?php
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
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($_GET['id'])) {
        $binId = $_GET['id'];

        Recycle::DeleteBin($binId);

        if ($_SESSION['delete_bin'] = true) {
            $_SESSION['delete_bin'] = '<script>alert("Bin Deleted Successfully");</script>';
            header("Location: Bin.php");
        } else {
            $_SESSION['delete_bin'] = '<script>alert("Failed to delete Bin");</script>';
            header("Location: Bin.php");
        }

        exit();
    }

    ?>

</body>

</html>