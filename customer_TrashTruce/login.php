<?php 
ob_start();
include('../FO/customer.php');
session_start();

if (isset($_SESSION['Register'])) {
    echo $_SESSION['Register'];
    unset($_SESSION['Register']);
}
include('customer assets/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Login</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="Register">
    <h2>Customer Login</h2>
    <div class="detail">
    <form action="" method="post">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required><br>

      <input type="hidden" name="ID" value="<?php echo isset($user) ? $user->ID : ''; ?>">
      <input type="submit" value="Login" name="login">
    </div>
    </form>
    <p>Don't have an account? <a href="register.php">Register Here</a></p>
  </div>

  <?php
    include ('customer assets/footer.html');
  ?> 

</body>
</html>


<?php
if(isset($_POST["login"])) {
  $email =isset($_POST["email"])?$_POST["email"]:"";
  $password = isset($_POST["password"])?($_POST["password"]):"";

  
  $user = Customer::GetUserByEmail($email);
  if($user && password_verify($password, $user->password)) {

    if($user->approval == "Approved") {
        $_SESSION["ID"] = $user->ID;
        $_SESSION['Email'] = $user->email;
        $_SESSION["customer_authenticated"] = true;
        if(isset($_GET['from']) && $_GET['from'] == 'cart') {
          $_SESSION["user_id"] = $user->ID; 
            header("Location: checkout.php");
        } else {
          $_SESSION["user_id"] = $user->ID;
            header("Location: myOrders.php");
        }
        exit();
    } else {
        echo '<script>alert("Your account is not approved yet.");</script>';
    }
} else {
    echo '<script>alert("Invalid email or password.");</script>';
}
}
ob_end_flush(); 
?>