<?php
include('../FO/gallery.php');
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
        $galId = $_GET['id'];

        Gallery::Delete($galId);

        if ($_SESSION['delete_gal'] = true) {
            $_SESSION['delete_gal'] = '<script>alert("Gallery Deleted Successfully");</script>';
            header("Location: Gallery.php");
        } else {
            $_SESSION['delete_gal'] = '<script>alert("Failed to delete Gallery");</script>';
            header("Location: Gallery.php");
        }

        exit();
    }

    ?>

</body>

</html>