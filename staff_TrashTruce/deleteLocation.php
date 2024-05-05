<?php
include('../FO/location.php');
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
        $locationId = $_GET['id'];

        location::Delete($locationId);

        if ($_SESSION['delete_loc'] = true) {
            $_SESSION['delete_loc'] = '<script>alert("Location Deleted Successfully");</script>';
            header("Location: Location.php");
        } else {
            $_SESSION['delete_loc'] = '<script>alert("Failed to delete Location");</script>';
            header("Location: Location.php");
        }

        exit();
    }

    ?>

</body>

</html>