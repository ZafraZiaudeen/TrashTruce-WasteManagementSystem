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
        $eventId = $_GET['id'];

        events::Delete($eventId);

        if ($_SESSION['delete_event'] = true) {
            $_SESSION['delete_event'] = '<script>alert("Event Deleted Successfully");</script>';
            header("Location: Events.php");
        } else {
            $_SESSION['delete_event'] = '<script>alert("Failed to delete Event");</script>';
            header("Location: Events.php");
        }

        exit();
    }

    ?>

</body>

</html>