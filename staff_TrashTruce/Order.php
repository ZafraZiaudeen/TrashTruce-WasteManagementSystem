<?php 
include('../FO/orders.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

// Include the header
include "Header.php";

// Get orders based on search or retrieve all orders
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $orders = orders::SearchOrders($search); 
} else {
    $orders = orders::GetOrdersforAll();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<body>
    <div class="main">
        <div class="colorbar">
          <h1>Order</h1>
        </div>
      
        <div class="intro">
            <table>
                <tr>
                    <th>Serial Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $order->user->email; ?></td>
                            <td><?php echo $order->user->address; ?></td>
                            <td><?php echo $order->product; ?></td>
                            <td><?php echo $order->quantity; ?></td>
                            <td>Rs. <?php echo $order->price; ?></td>
                            <td><?php echo $order->method; ?></td>
                            <td><?php echo $order->payment; ?></td>
                            <td><?php echo $order->status; ?></td>
                            <td><?php echo $order->date; ?></td>
                            <td>
                                <a href="deleteOrder.php?id=<?php echo $order->o_id; ?>" onclick="return confirm('Are you sure you want to delete this Order?');">
                                  <span class="material-symbols-outlined">delete</span>
                                </a>
                                <a href="EditOrder.php?id=<?php echo $order->o_id; ?>"><span class="material-symbols-outlined">edit</span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">No Order Details Found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <?php
    // Include the footer
    include "Footer.html";
    ?>
</body>
</html>
