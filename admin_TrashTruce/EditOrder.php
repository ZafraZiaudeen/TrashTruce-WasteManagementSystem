<?php 
ob_start();
include('../FO/orders.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/AddP.css" rel="stylesheet">
    <title>Edit Order</title>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

   
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <br><br>
        <div class="AddProduct">
            <h1>Edit Order</h1><br>
            <!-- Form to edit order -->
            <?php
            if (isset($_GET['id'])) {
                $order_id= $_GET['id'];
                $order = orders::GetOrder($order_id);
                if ($order) {
            ?>   
            <form action="" method="post">
                Edit Payment status :
                <select name="payment">
                    <option value="Paid"<?php if ($order->payment == 'Paid') echo ' selected'; ?>>Paid</option>
                    <option value="Not Paid"<?php if ($order->payment == 'Not Paid') echo ' selected'; ?>>Not paid</option>
                    <option value="On Process"<?php if ($order->payment == 'On Process') echo ' selected'; ?>>On process</option>
                </select>

                Edit Order status :
                <select name="status">
                    <option value="Dispatched"<?php if ($order->status == 'Dispatched') echo ' selected'; ?>>Dispatched</option>
                    <option value="Cancelled"<?php if ($order->status == 'Cancelled') echo ' selected'; ?>>Cancelled</option>
                    <option value="Delivered"<?php if ($order->status == 'Delivered') echo ' selected'; ?>>Delivered</option>
                </select>
                <button class="btnAddProduct" type="submit" name="Update">Update Order</button>
            </form>
            <?php
                }
            }
            ?>
            <!-- End of Form -->
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>
<?php
if (isset($_POST['Update'])) {
    // Retrieve updated payment status and order status
    $payment_status = $_POST['payment'];
    $order_status = $_POST['status'];

    // Update the order in the database
    $order->payment = $payment_status;
    $order->status = $order_status;
    $order->UpdateOrder();

    // Redirect to a success page or display a success message
    header("Location: Order.php");
    exit();
}
ob_flush();
?>
