<?php
include('../FO/orders.php');
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
        $orderId = $_GET['id'];

        orders::Delete($orderId);

        if ($_SESSION['delete'] = true) {
            $_SESSION['delete'] = '<script>alert("Order Deleted Successfully");</script>';
            header("Location: Order.php");
        } else {
            $_SESSION['delete'] = '<script>alert("Failed to delete Order");</script>';
            header("Location: Order.php");
        }

        exit();
    }

    ?>

</body>

</html>