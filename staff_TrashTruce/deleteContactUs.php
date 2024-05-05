<?php
include('../FO/contactus.php');
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
        $conId = $_GET['id'];

        ContactUs::Delete($conId);

        if ($_SESSION['delete_contact'] = true) {
            $_SESSION['delete_contact'] = '<script>alert("Contactus submission Deleted Successfully");</script>';
            header("Location: ContactUs.php");
        } else {
            $_SESSION['delete_contact'] = '<script>alert("Failed to delete Contactus submission");</script>';
            header("Location: ContactUs.php");
        }

        exit();
    }

    ?>

</body>

</html>