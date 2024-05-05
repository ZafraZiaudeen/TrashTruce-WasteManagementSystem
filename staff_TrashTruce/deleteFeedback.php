<?php
include('../FO/feedback.php');
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
        $feedId = $_GET['id'];

        Feedback::Delete($feedId);

        if ($_SESSION['delete_feed'] = true) {
            $_SESSION['delete_feed'] = '<script>alert("Feedback Deleted Successfully");</script>';
            header("Location: Feedback.php");
        } else {
            $_SESSION['delete_feed'] = '<script>alert("Failed to delete Feedback");</script>';
            header("Location: Feedback.php");
        }

        exit();
    }

    ?>

</body>

</html>