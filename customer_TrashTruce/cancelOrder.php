<?php
include('../FO/orders.php');
session_start();

if (isset($_GET['o_id'])) {
    $orderID = $_GET['o_id'];

    try {
        $order = orders::GetOrderById($orderID);

        if ($order) {
            // Update the order status to "cancel order"
            $order->status = 'Order Cancelled';
            $order->UpdateOrder();
        }

        // Redirect to the page where the order table is displayed
        $_SESSION['delete'] = "Order Cancelled Successfully";
        header("Location: myOrders.php");
        exit();
    } catch (Exception $ex) {
        $_SESSION['delete'] = "Failed to cancel order";
        header("Location: myOrders.php");
        exit();
    }
}
?>
