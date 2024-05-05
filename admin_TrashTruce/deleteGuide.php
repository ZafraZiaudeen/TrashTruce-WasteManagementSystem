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
        $guideId = $_GET['id'];

        Recycle::Delete($guideId);

        if ($_SESSION['delete_guide'] = true) {
            $_SESSION['delete_guide'] = '<script>alert("Guide Deleted Successfully");</script>';
            header("Location: RecyclingGuide.php");
        } else {
            $_SESSION['delete_guide'] = '<script>alert("Failed to delete Guide");</script>';
            header("Location: RecyclingGuide.php");
        }

        exit();
    }

    ?>

</body>

</html>