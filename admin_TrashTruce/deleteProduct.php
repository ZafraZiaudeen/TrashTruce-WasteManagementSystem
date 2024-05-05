<?php
include('../FO/products.php');
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
        $productId = $_GET['id'];

        Products::DeleteProduct($productId);

        if ($_SESSION['delete_product'] = true) {
            $_SESSION['delete_product'] = '<script>alert("Product Deleted Successfully");</script>';
            header("Location: Products.php");
        } else {
            $_SESSION['delete_product'] = '<script>alert("Failed to delete Product");</script>';
            header("Location: Products.php");
        }

        exit();
    }

    ?>

</body>

</html>