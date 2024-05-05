<?php
include('../FO/customer.php');
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
        $userId = $_GET['id'];

        Customer::Delete($userId);

        if ($_SESSION['delete_cus'] = true) {
            $_SESSION['delete_cus'] = '<script>alert("User Deleted Successfully");</script>';
            header("Location: Customer.php");
        } else {
            $_SESSION['delete_cus'] = '<script>alert("Failed to delete user");</script>';
            header("Location: Customer.php");
        }

        exit();
    }

    ?>

</body>

</html>