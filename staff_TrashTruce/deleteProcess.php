<?php
include('../FO/Recycle.php');
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
        $processId = $_GET['id'];

        Recycle::DeleteProcess($processId);

        if ($_SESSION['delete_process'] = true) {
            $_SESSION['delete_process'] = '<script>alert("Process Deleted Successfully");</script>';
            header("Location: Recycling.php");
        } else {
            $_SESSION['delete_process'] = '<script>alert("Failed to delete Process");</script>';
            header("Location: Recycling.php");
        }

        exit();
    }

    ?>

</body>

</html>