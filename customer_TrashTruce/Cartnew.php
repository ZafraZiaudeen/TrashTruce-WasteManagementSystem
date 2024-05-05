<?php 
include('../FO/cart.php');
include('../FO/products.php');
session_start();
include('customer assets/header.php');

// Function to check if the cart is empty
function isCartEmpty() {
    return !isset($_SESSION["Cart"]) || empty($_SESSION["Cart"]);
}


// Check if the removal action is triggered
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_index"])) {
    $removeIndex = $_POST["remove_index"];
    // Remove item from the cart session
    unset($_SESSION["Cart"][$removeIndex]);
    // Reset array keys to prevent issues with foreach loop
    $_SESSION["Cart"] = array_values($_SESSION["Cart"]);
}

$orderData = array();


if (!isCartEmpty()) {
 
    foreach ($_SESSION["Cart"] as $item) {
       
        $orderData[] = array(
            'product' => $item->Name,
            'quantity' => $item->Qty,
            'price' => $item->Price
        );
    }
}

if (isset($_POST["btnUpdate"])) {
    $row = $_POST["btnUpdate"];
    // Check if txtQty is set in $_POST before accessing it
    if (isset($_POST["txtQty"]) && isset($_POST["txtQty"][$row])) {
        $newQuantity = $_POST["txtQty"][$row];

        if (ctype_digit($newQuantity) && $newQuantity > 0) {
            $_SESSION["Cart"][$row]->Qty = $newQuantity;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart</title>
<link rel="stylesheet" href="css/carti.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
<?php if (isCartEmpty()) { ?>
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 350px; 
    padding: 10px; 
    box-sizing: border-box;
}
<?php } ?>
</style>
</head>
<body>
<header>

    <h1>SHOPPING CART</h1>
</header>
<div class="content">
<table id="cart">
<?php if (isCartEmpty()) { ?>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Actions</th>
            <th>Update</th> <!-- Column for update button -->
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6">Cart is empty.</td>
        </tr>
    </tbody>
</table>
<?php } else { ?>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Actions</th>
            <th>Update</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        $totalPrice = 0;
        foreach ($_SESSION["Cart"] as $row => $item) {
            $subtotal = $item->Price * $item->Qty;
            $totalPrice += $subtotal;
        ?>
        <tr>
            <td><?php echo '<img src="../product_image/' . $item->Image . '" alt="Product Image"> ' . $item->Name; ?></td>
            <td><?php echo $item->Qty; ?></td>
            <td>Rs. <?php echo $item->Price; ?></td>
            <td>Rs. <?php echo number_format($subtotal, 2); ?></td>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
             <input type="hidden" name="remove_index" value="<?php echo $row; ?>">
             <td>
             <button type="submit" class="remove-btn"><i class="fas fa-times"></i>
              <span class="glyphicon glyphicon-remove"></span> Remove
               </button>
                </td>
                  </form>
                  <td>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="number" min="1" name="txtQty[<?php echo $row; ?>]" value="<?php echo $item->Qty; ?>" onchange="updateTotal(this)">
        <input type="hidden" name="btnUpdate" value="<?php echo $row; ?>">
        <button class="update-btn" type="submit"> <i class="fas fa-sync"></i> Update</button>
    </form>
</td>

        </tr>
        <?php } ?>
    </tbody>
</table>
<table id="cart-summary">
    <tr>
        <td class="subii">Total:</td>
        <td><span id="total">Rs. <?php echo number_format($totalPrice, 2); ?></span></td>
    </tr>
    <tr>
        <td colspan="2" class="button-container">
            <button class="btn btn-default" onclick="continueShopping()">
                <i class="fas fa-shopping-cart"></i> Continue Shopping
            </button>
            <button class="btn btn-success" onclick="checkout()">
                Checkout <i class="fas fa-play"></i>
            </button>
        </td>
    </tr>
</table>
<?php } ?>


<?php
include ('customer assets/footer.html');
?>
<script>
    function updateTotal(input) {
        // Get the parent row of the input field
        var row = input.parentNode.parentNode;
        var quantity = input.value;
        var price = parseFloat(row.getElementsByTagName('td')[2].innerText);
        var subtotal = quantity * price;
        
        // Update the subtotal for the item
        row.getElementsByTagName('td')[3].innerText = "$" + subtotal.toFixed(2);
        
        // Recalculate the total price
        updateTotalPrice();
    }

    function updateTotalPrice() {
        var total = 0;
        var subtotals = document.querySelectorAll("#cart tbody td:nth-child(4)");
        for (var i = 0; i < subtotals.length; i++) {
            total += parseFloat(subtotals[i].innerText.replace("$", ""));
        }
        document.getElementById("total").innerText = "$" + total.toFixed(2);
    }

    function removeItem(index) {
        document.getElementsByName("index[]")[index].value = "-1";
        // Submit the form
        document.getElementById("cartForm").submit();
    }

    function continueShopping() {
        window.location.href = "Viewproduct.php";
    }

    function checkout() {
        <?php if(isset($_SESSION['user_id'])) { ?>
            // Encode order data as JSON and pass it as a parameter in the URL
            var orderData = <?php echo json_encode($orderData); ?>;
            var totalPrice = <?php echo $totalPrice ?>;
            var productsData = <?php echo json_encode($_SESSION["Cart"]); ?>; // Encode products data
            window.location.href = "checkout.php?orderData=" + encodeURIComponent(JSON.stringify(orderData)) + "&totalPrice=" + totalPrice + "&productsData=" + encodeURIComponent(JSON.stringify(productsData)); 
        <?php } else { ?>
            alert("Please log in before checking out.");
            window.location.href = "login.php?from=cart";
        <?php  } ?>
    }
    
</script>

</body>
</html>
