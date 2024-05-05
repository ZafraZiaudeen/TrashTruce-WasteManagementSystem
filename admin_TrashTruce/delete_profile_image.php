<?php
include_once('../FO/admin.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve admin ID from the form
    $adminID = $_POST['adminID']; 

    try {
       
        $admin = admin::GetAdmin($adminID);

        // Check if admin exists
        if ($admin) {

            $admin->image = null;
            $admin->UpdateImage();

            header("Location: Profile.php"); 
            exit();
        } else {
            // Redirect back with an error message if admin not found
            header("Location: Profile.php?error=admin_not_found");
            exit();
        }
    } catch (Exception $e) {
        // Redirect back with an error message if an exception occurs
        header("Location: Profile.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // If the form was not submitted via POST, redirect back
    header("Location: Profile.php");
    exit();
}
?>
