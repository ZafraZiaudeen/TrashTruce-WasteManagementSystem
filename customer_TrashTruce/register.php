<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

include('../FO/customer.php');
session_start();
include('customer assets/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Registration</title>
  <link rel="stylesheet" href="css/register.css">

</head>
<body>
  <div class="login">
  <h2>Customer Registration</h2>
  <div class="detail">
    <form action="" method="post">
    <label for="first_name">First Name:</label>
    <input type="text"  name="fname" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text"name="lname" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="contact">Phone Number:</label>
    <input type="text"  name="phone" required><br>

    <label for="address">Address:</label>
        <input type="text"  name="address" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <label for="cpassword">Confirm Password:</label>
    <input type="password" name="cpassword" required><br>

    <input type="submit" name="submit" value="Register">
  
</div></form>
<p>Already have an account? <a href="login.html" style="color:black">Login Here</a></p>
  </div>
  <?php
include ('customer assets/footer.html');
?>

<?php 
  if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    
    // Check if email already exists
    if (Customer::EmailExists($email)) {
        echo '<script>alert("This email is already registered. Please use a different email.");</script>';
    } else {
        // Proceed with registration
        $Register = new Customer();    
        $Register->fname = $_POST["fname"];
        $Register->lname = $_POST["lname"];
        $Register->email = $email;
        $Register->phone = $_POST["phone"];
        $Register->address = $_POST["address"];

        $plainPassword = $_POST["password"];
        $Register->password = password_hash($plainPassword, PASSWORD_BCRYPT);

        $confirm_password = $_POST["cpassword"];

        if (!password_verify($confirm_password, $Register->password)) {
            echo '<script>alert("Password and confirm password do not match");</script>';
        } else {
            $insertedId = $Register->Add();
            if($insertedId) {
                // Send email using PHPMailer
                $mail = new PHPMailer(true);  // Passing `true`
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'trashtruce@gmail.com';
                $mail->Password = 'qjupisxaixcfrffk';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('trashtruce@gmail.com', 'TrashTruce');
                $mail->addAddress($email, $Register->fname . ' ' . $Register->lname);
                $mail->Subject = 'Welcome to TrashTruce';
                $mail->Body = "Dear " . $Register->fname . " " . $Register->lname . ",\n\n";
                $mail->Body .= "Thank you for registering with TrashTruce. Your account is awaiting approval.\n\n";
                $mail->Body .= "Best regards,\nThe TrashTruce Team";

                if($mail->send()) {
                    $_SESSION["Register"] = '<script>alert("Wait for approval of your registration");</script>';
                    echo '<script>window.location.href = "login.php";</script>';
                    exit();
                } else {
                    echo '<script>alert("Failed to send email. Please contact support.");</script>';
                }
            } else {
                echo '<script>alert("Failed to register. Please try again.");</script>';
            }
        }
    }
  }
  ?>
</body>
</html>
