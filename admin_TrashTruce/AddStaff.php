<?php 
ob_start();
include('../FO/Staff.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
  }
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
        <h1>Add Staff</h1>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post">
            
                First Name :
                <input type="text" name="FName" required><br>

                Last Name :
                <input type="text" name="Lname" required><br><br>

                Position:
                <input type="text" name="position" required><br><br>

                Date  of Birth: 
                <input type="date" id="dob" name="dob" required><br><br>
                
                Email:  
                <input type="text" name="Email" required><br><br>

                Password :
                <input type="text" name="password" required><br>

                Contact Number:
                <input type="text" name="contact" required><br>

                Address:
                <input type="text" name="address" required><br><br><br>
            

                <button class="btnAddProduct" type="submit" name="btnAdd">Add Staff</button>
            <!---------------------- finish Form-------------------------------------->
            </form>
</div>


</div>


  <div>
  <?php
    include "Footer.html";
    ?>
  </div>
</body>
</html>

<?php
    if (isset($_POST["btnAdd"])){
        $addstaff=new staff;
        $addstaff->fname=$_POST["FName"];
        $addstaff->lname=$_POST["Lname"];
        $addstaff->position=$_POST["position"];
        $addstaff->dob=$_POST["dob"];
        $addstaff->address=$_POST["address"];
        $addstaff->email=$_POST["Email"];
        $addstaff->phone=$_POST["contact"];
        $addstaff->password = password_hash($_POST["password"], PASSWORD_BCRYPT);        
        $addstaff->Add(); 

        if($_SESSION['staff_add'] = true){
        $_SESSION['staff_add']="Staff added Successfully";
        header("Location: Staff.php");
        }else{
            $_SESSION['admin_add']="Failed to add Staff";
            header("Location: AddStaff.php");
        }
    }
ob_flush();
    ?>