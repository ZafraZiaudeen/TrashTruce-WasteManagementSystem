<?php 
ob_start();
include('../FO/Staff.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/AddP.css">
    <title>Change Password</title>
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
    </div>

    <div class="main" style="margin-top: 40px;">
        <div class="AddProduct">
            <h1>Change Password</h1><br>
            <?php
            if (isset($_GET['id'])) {
                $userId = $_GET['id'];
                $staff = staff::GetStaffDetail($userId);

                if (!$staff) {
                    echo "User not found!";
                    exit();
                }
            }
            ?>
            <form action="" method="post" >
                Current password:<br>
                <input type="password" name="password"><br>

                New password:<br>
                <input type="password" name="newpassword"><br>

                Retype new password:<br>
                <input type="password" name="renewpassword"><br>

                <input type="hidden" name="user_id" value="<?php echo isset($staff) ? $staff->ID : ''; ?>">
                <button class="btnAddProduct" type="submit" name="changePassword">Confirm</button>
            </form>
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>

<?php 
if (isset($_POST['changePassword'])) {
    // Retrieve form data
    $userId = isset($_POST["user_id"]) ? $_POST["user_id"] : null;
    $currentPassword = isset($_POST["password"]) ? $_POST["password"] : '';
    $newPassword = isset($_POST["newpassword"]) ? $_POST["newpassword"] : '';
    $renewPassword = isset($_POST["renewpassword"]) ? $_POST["renewpassword"] : '';

    // Check if all fields are filled
    if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
        echo '<script>alert("All fields are required" );</script>';
    } else {
        // Retrieve staff member's information
        $staff = staff::GetStaffDetail($userId);

        if (!$staff) {
            echo '<script>alert("User not found!");</script>';
            exit();
        }

        // Validate current password
        if (!password_verify($currentPassword, $staff->password)) {
            echo '<script>alert("Incorrect current password" );</script>';
        } elseif ($newPassword !== $renewPassword) {
            echo '<script>alert("New password and re-entered password do not match" );</script>';
        } else {
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $staffToUpdate = new staff();
            $staffToUpdate->ID = $userId;
            $staffToUpdate->password = $hashedPassword;

            $staffToUpdate->UpdatePassword();
            $_SESSION['updatepw'] = '<script>alert("Password updated successfully" );</script>';
            header("Location: Staff.php");
            exit();
        }
    }
}
?>
