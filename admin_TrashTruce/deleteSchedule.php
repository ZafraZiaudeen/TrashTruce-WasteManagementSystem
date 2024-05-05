<?php
include('../FO/schedule.php');
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
        $scheduleId = $_GET['id'];

        Schedule::Delete($scheduleId);

        if ($_SESSION['delete_schedule'] = true) {
            $_SESSION['delete_schedule'] = '<script>alert("Schedule Deleted Successfully");</script>';
            header("Location: Schedule.php");
        } else {
            $_SESSION['delete_schedule'] = '<script>alert("Failed to delete Schedule");</script>';
            header("Location: Schedule.php");
        }

        exit();
    }

    ?>

</body>

</html>