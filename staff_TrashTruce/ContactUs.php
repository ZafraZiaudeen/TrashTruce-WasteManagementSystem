<?php 
include('../FO/contactus.php');
session_start();
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
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
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Contact Form Submissions</title>
</head>
<body>
<?php
            if (isset($_SESSION['delete_contact']) && !empty($_SESSION['delete_contact'])) {
                echo $_SESSION['delete_contact'];
                unset($_SESSION['delete_contact']);
            }
            ?>
    <div>
       <?php include "Header.php"; ?>
    </div>
    <div class="main">
        <div class="colorbar">
          <h1>Contact Form Submissions</h1>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Customer Name</th>
                    <th>Customer contact No.</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
                <?php
                include_once('ContactUs.php'); // Include the ContactUs class file
                $contacts = ContactUs::GetContactUs(); // Retrieve contact us details

                foreach ($contacts as $index => $contact) {
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>";
                    echo "<td>" . $contact->name . "</td>";
                    echo "<td>" . $contact->phone . "</td>";
                    echo "<td>" . $contact->email . "</td>";
                    echo "<td>" . $contact->message . "</td>";
                    echo "<td>" . $contact->date . "</td>";
                    echo '<td><a href="deleteContactUs.php?id=' . $contact->ID . '" onclick="return confirm(\'Are you sure you want to delete this Feedback?\');" class="btnDlt">Delete</a></td>';                    ;
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>
