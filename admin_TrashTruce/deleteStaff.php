<?php
include('../FO/Staff.php');
session_start();
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
        $staffId = $_GET['id'];

        staff::Delete($staffId);

        if ($_SESSION['delete_staff'] = true) {
            $_SESSION['delete_staff'] = '<script>alert("Staff Deleted Successfully");</script>';
            header("Location: Staff.php");
        } else {
            $_SESSION['delete_staff'] = '<script>alert("Failed to delete Staff");</script>';
            header("Location: Staff.php");
        }

        exit();
    }

    ?>

</body>

</html>