<?php 
ob_start();
include('../FO/cart.php');
include('../FO/orders.php');
session_start();
include('customer assets/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Payment Forms</title>
    <link rel="stylesheet" href="css/checkout.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <h1 style="color:white">Payment Form</h1>/
<div class="container py-5">
    <!-- For demo purpose -->
    
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Credit Card </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#payondel" class="nav-link "> <i class="fa-solid fa-money-check-dollar"></i> Pay on Delivery</a> </li>
                        </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form role="form"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group"> <label for="username">
                                        <h6>Card Owner</h6>
                                    </label> <input type="text" name="owner" placeholder="Card Owner Name" required class="form-control "> </div>
                                <div class="form-group"> <label for="cardNumber">
                                        <h6>Card number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cardNumber" placeholder="Valid card number" class="form-control " required>
                                        <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6>Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input type="number" placeholder="MM" name="exp_month" class="form-control" required> <input type="number" placeholder="YY" name="exp_year" class="form-control" required> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input type="text" name="cvv"  required class="form-control"> </div>
                                    </div>
                                </div>
                                <input type="hidden" name="product" value="<?php echo isset($_POST['product']) ? $_POST['product'] : ''; ?>">
<input type="hidden" name="quantity" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : 0; ?>">
<input type="hidden" name="price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : 0.00; ?>">
                                <div class="card"> <button name="confirmcard"> Confirm Payment </button</div>
                            </form>
                        </div>
                    </div> <!-- End -->
                    <!-- Pay on Delivery info -->
                    <div id="payondel" class="tab-pane fade pt-3">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h6 class="pb-2">Check the below  detail very carefully.</h6>
                        <div class="form-group "> <label class="radio-inline"> 
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="payondelivery" value="true" id="payment">
                                <label class="form-check-label" for="payment">You will pay for your order upon delivery.</label>
                            </div>
                        </div> </label> </div>
                        <div class="log">
                        <p> <button name="confirmcash">Confirm Order</button> </p>
                         </div>
                        <p class="text-muted"> Note: After clicking on the button, your order will be confirmed for payment upon delivery. </p>
                    </div> <!-- End -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/sidebar.js"></script>
<?php
include ('customer assets/footer.html');

?>

</body>
</html>
<?php


// Check if $_POST['product'], $_POST['quantity'], $_POST['price'] are set
if (isset($_POST['confirmcard'])) {
     
    // Handle payment form data
    if (isset($_POST['product'], $_POST['quantity'], $_POST['price'])) {
        $orderData = array(
            'u_id' => $_SESSION['user_id'],
            'product' => $_POST['product'],
            'quantity' => $_POST['quantity'],
            'price' => $_POST['price']
        );
        

        // Handle card details
        // Check if $_POST['owner'], $_POST['cardNumber'], $_POST['exp_month'], $_POST['exp_year'], $_POST['cvv'] are set
        if (isset($_POST['owner'], $_POST['cardNumber'], $_POST['exp_month'], $_POST['exp_year'], $_POST['cvv'])) {
            
            // Process the payment
        } else {
            echo "Error: Card details are incomplete.";
        }
    } else {
        echo "Error: Order data is incomplete.";
    }
}
   if (isset($_POST['confirmcard'])) {
    try {
   
        $cardOwner = $_POST['owner'];
        $cardNumber = $_POST['cardNumber'];
        $expMonth = $_POST['exp_month'];
        $expYear = $_POST['exp_year'];
        $cvv = $_POST['cvv'];

        // Retrieve cart details from session and prepare order data
        $cart = $_SESSION["Cart"];
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->Price * $item->Qty;
        }
        $orderData = array(
            'u_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0,
            'product' => isset($_POST['product']) ? $_POST['product'] : '',
            'quantity' => isset($_POST['quantity']) ? $_POST['quantity'] : 0,
            'price' => isset($_POST['price']) ? $_POST['price'] : 0.00
        );
        

        // Call the method to add order with card details
        $order_id = orders::AddOrderWithCardDetails($orderData, array(
            'owner' => $cardOwner,
            'cardNumber' => $cardNumber,
            'exp' => $expMonth . '/' . $expYear,
            'cvv' => $cvv
        ), $_SESSION['userDetails']);

        // Redirect to order confirmation page
        $_SESSION['order_id'] = $order_id;
        header('Location: myOrders.php');
        unset($_SESSION['Cart']);
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['confirmcash'])) {
    try {
        // Retrieve cart details from session and prepare order data
        $cart = $_SESSION["Cart"];
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->Price * $item->Qty;
        }

        $orderData = array(
            'u_id' => $_SESSION['user_id'],
            'product' => $_POST['product'],
            'quantity' => $_POST['quantity'],
            'price' => $_POST['price']
        );

        // Call the method to add order with cash on delivery
        $order_id = orders::AddOrderWithCashOnDelivery($orderData, $_SESSION['userDetails']);

        // Redirect to order confirmation page
        $_SESSION['order_id'] = $order_id;
        header('Location: myOrders.php');
        unset($_SESSION['Cart']);
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
ob_flush();
?>