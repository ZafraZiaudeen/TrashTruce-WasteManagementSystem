<?php 
include('../FO/orders.php');
include_once('../FO/customer.php'); // Include the customer class

// Check if the user is logged in and retrieve their email
session_start();

include('customer assets/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/cancle.css">
  <title>Product orders</title>
</head>
<body>
  <header>
    <h1>PRODUCT ORDERS</h1>
  </header>
  <main>
  <table id="orders">
    <tr>
      <th>Product</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Status</th>
      <th>Date & Time</th>
      <th>Action</th>
    </tr>
    <?php
    if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];
      $userOrders = new orders;
      $orders = $userOrders->GetOrders($userId);
      
      foreach ($orders as $order) {
        echo '<tr>';
        echo '<td>' . $order->product . '</td>';
        echo '<td>' . $order->quantity . '</td>';
        echo '<td>Rs. ' . $order->price . '</td>';
        echo '<td>' . $order->status . '</td>';
        echo '<td>' . $order->date . '</td>';
        // Display cancel button only if order status is not "Dispatched" or "Delivered"
        if ($order->status != "Dispatched" && $order->status != "Delivered") {
          echo '<td>
                  <a href="cancelOrder.php?o_id=' . $order->o_id . '" onclick="return confirm(\'Are you sure you want to cancel your order?\');" >
                      <button class="cancel-btn">Cancel</button>
                  </a>
                </td>';
        } else {
          // If the status is "dispatched" or "delivered", show an empty cell
          echo '<td></td>';
        }
        echo '</tr>';
      }
    } else {
      echo '<tr><td colspan="6">Please log in to view orders.</td></tr>';
    }
    ?>
  </table>
  <br><br>
  </main>


</body>
</html>

<?php
include ('customer assets/footer.html');
?>
