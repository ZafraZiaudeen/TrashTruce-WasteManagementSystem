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
        $cateId = $_GET['id'];

        Products::DeleteCategory($cateId);

        if ($_SESSION['delete_cat'] = true) {
            $_SESSION['delete_cat'] = '<script>alert("Category Deleted Successfully");</script>';
            header("Location: Category.php");
        } else {
            $_SESSION['delete_cat'] = '<script>alert("Failed to delete category");</script>';
            header("Location: Category.php");
        }

        exit();
    }

    ?>

</body>

</html>