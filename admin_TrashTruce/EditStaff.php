<?php

include('../FO/Staff.php');

// Check if ID parameter is provided in the URL
if(isset($_GET['id'])) {
    $staffID = $_GET['id'];

    // Get staff details by ID
    try {
        $staff = staff::GetStaffDetail($staffID);
    } catch(Exception $e) {
        // Handle error
        echo 'Error: ' . $e->getMessage();
        exit;
    }

    // Check if staff details are found
    if($staff) {
        // Check if form is submitted for update
        if(isset($_POST['Update'])) {
            try {
                // Retrieve form data
                $firstName = isset($_POST['FName']) ? $_POST['FName'] : '';
                $lastName = isset($_POST['Lname']) ? $_POST['Lname'] : '';
                $position = isset($_POST['position']) ? $_POST['position'] : '';
                $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
                $email = isset($_POST['Email']) ? $_POST['Email'] : '';
                
                $contactNumber = isset($_POST['contact']) ? $_POST['contact'] : '';
                $address = isset($_POST['address']) ? $_POST['address'] : '';

                // Update staff object with new data
                $staff->fname = $firstName;
                $staff->lname = $lastName;
                $staff->position = $position;
                $staff->dob = $dob;
                $staff->email = $email;
        
                $staff->phone = $contactNumber;
                $staff->address = $address;

                // Perform staff update
                $staff->Update();

                // Redirect after successful update
                header("Location: Staff.php");
                exit();
            } catch(Exception $e) {
                // Handle error
                echo 'Error: ' . $e->getMessage();
                exit;
            }
        }
    } else {
        // Handle case when staff details are not found
        echo 'Staff details not found.';
        exit;
    }
} else {
    // Handle case when ID parameter is not provided
    echo 'Staff ID not provided.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/AddP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Update Staff</title>
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <div class="AddProduct">
            <h1>Update Staff</h1>
            <form action="" method="post">
                First Name :
                <input type="text" name="FName" value="<?php echo $staff->fname; ?>"><br>
                Last Name :
                <input type="text" name="Lname" value="<?php echo $staff->lname; ?>"><br><br>
                Position:
                <input type="text" name="position" value="<?php echo $staff->position; ?>"><br><br>
                Date of Birth: 
                <input type="date" id="dob" name="dob" value="<?php echo $staff->dob; ?>"><br><br>
                Email:  
                <input type="text" name="Email" value="<?php echo $staff->email; ?>"><br><br>
            
                Contact Number:
                <input type="text" name="contact" value="<?php echo $staff->phone; ?>"><br>
                Address:
                <input type="text" name="address" value="<?php echo $staff->address; ?>"><br><br>
                <button class="btnAddProduct" type="submit" name="Update">Done</button>
            </form>
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>
