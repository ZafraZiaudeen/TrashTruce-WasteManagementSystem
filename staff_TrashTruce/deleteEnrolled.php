<?php
include('../FO/events.php');
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
        $eId = $_GET['id'];

        events::DeleteEnrolled($eId);

        if ($_SESSION['delete_enrolled'] = true) {
            $_SESSION['delete_enrolled'] = '<script>alert("Enrollment Deleted Successfully");</script>';
            header("Location: Enrolled.php");
        } else {
            $_SESSION['delete_enrolled'] = '<script>alert("Failed to delete Event");</script>';
            header("Location: Enrolled.php");
        }

        exit();
    }

    ?>

</body>

</html>