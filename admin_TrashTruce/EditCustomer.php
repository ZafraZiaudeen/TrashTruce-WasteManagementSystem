<?php
ob_start();
include('../FO/customer.php');
session_start();

// Include PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/AddP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<body>
    <div>
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">

<div class="AddProduct">
        <h1>Update Customer</h1>
        <form action="" method="post">
            <?php
            // Check if ID is set in the URL
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                // Retrieve customer details based on ID
                $customers = Customer::GetUserDetails();
                // Find the customer with the specified ID
                $customer = null;
                foreach($customers as $c) {
                    if($c->ID == $id) {
                        $customer = $c;
                        break;
                    }
                }
                // If customer found, populate the form fields with their details
                if($customer != null) {
                    echo 'First Name: <input type="text" name="fname" value="'.$customer->fname.'"><br><br>';
                    echo 'Last Name: <input type="text" name="lname" value="'.$customer->lname.'"><br><br>';
                    echo 'Email: <input type="text" name="email" value="'.$customer->email.'"><br><br>';
                    echo 'Phone: <input type="text" name="phone" value="'.$customer->phone.'"><br><br>';
                    echo 'Address: <input type="text" name="address" value="'.$customer->address.'"><br><br>';
                    echo 'Approval: <select name="approval">';
                    echo '<option value="Approved"'.($customer->approval == "Approved" ? ' selected' : '').'>Approve</option>';
                    echo '<option value="Reject"'.($customer->approval == "Reject" ? ' selected' : '').'>Reject</option>';
                    echo '<option value="Pending Approval"'.($customer->approval == "Pending Approval" ? ' selected' : '').'>Pending</option>';
                    echo '</select><br><br>';
                    echo '<input type="hidden" name="ID" value="'.$customer->ID.'">';
                } else {
                    echo 'Customer not found.';
                }
            } else {
                echo 'Customer ID not provided.';
            }
            ?>
            <button class="btnAddProduct" type="submit" name="Update">Update</button>
            <!---------------------- finish Form-------------------------------------->
        </form>
    </div> 
</div>
<?php
if (isset($_POST["Update"])) {
    try {
        $userID = isset($_POST["ID"]) ? $_POST["ID"] : '';
        $fname = isset($_POST["fname"]) ? $_POST["fname"] : '';
        $lname = isset($_POST["lname"]) ? $_POST["lname"] : '';
        $email = isset($_POST["email"]) ? $_POST["email"] : '';
        $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
        $address = isset($_POST["address"]) ? $_POST["address"] : '';
        $approval = isset($_POST['approval']) ? $_POST['approval'] : '';

        $customer = new Customer();
        $customer->ID = $userID;
        $customer->fname = $fname;
        $customer->lname = $lname;
        $customer->email = $email;
        $customer->phone = $phone;
        $customer->address = $address;
        $customer->approval = $approval;

        // Retrieve the existing approval status from the database
        $existingCustomer = Customer::GetUserDetail($userID); // Corrected method name
        $existingApproval = $existingCustomer->approval;

        // If the new approval status is different from the existing one, send the email
        if ($approval != $existingApproval) {
            // Send approval or rejection email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'trashtruce@gmail.com'; 
            $mail->Password = 'qjupisxaixcfrffk'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('trashtruce@gmail.com', 'TrashTruce');  
            $mail->addAddress($email, $fname . ' ' . $lname);
            
            if ($approval == 'Approved') {
                $subject = 'Registration Approved';
                $message = "Dear $fname $lname,\n\nYour registration for TrashTruce has been approved.";
            } elseif ($approval == 'Reject') {
                $subject = 'Registration Rejected';
                $message = "Dear $fname $lname,\n\nWe regret to inform you that your registration for TrashTruce has been rejected.";
            }
            
            $mail->Subject = $subject;
            $mail->Body = $message;

            if ($mail->send()) {
                // Update the customer details only after the email is sent successfully
                $customer->Update();
                $_SESSION['update_cus'] = "<script>alert('User updated successfully');</script>";
                header("Location: customer.php");
                exit();
            } else {
                $_SESSION['update_cus'] = "<script>alert('Failed to update user. Email not sent.');</script>";
                header("Location: editCustomer.php?id=" . $userID);
                exit();
            }
        } else {
            // If the approval status is not changed, update the customer details directly without sending the email
            $customer->Update();
            $_SESSION['update_cus'] = "<script>alert('User updated successfully');</script>";
            header("Location: customer.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['update_cus'] = "<script>alert('Failed to update user: " . $e->getMessage() . "');</script>";
        header("Location: editCustomer.php?id=" . $userID);
        exit();
    }
}
ob_end_flush(); 
?>

  <?php
    include "Footer.html";
    ?>
  </div>
</body>
</html>

