<?php
include('../FO/feedback.php');
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
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<body>
    <div>
        <?php
        include "Header.php";
        ?>
    </div>
    <div class="main">
        <div class="colorbar">
            <h1>Feedbacks</h1>
        </div>
      
        <div class="btnAll"></div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Customer Name</th>
                    <th>Rate</th>
                    <th>Feedback</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
                <?php
                // Retrieve feedbacks from the database based on the search query
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    $feedbacks = Feedback::SearchFeedbacks($search);
                } else {
                    $feedbacks = Feedback::GetFeedbacks();
                }

                // Check if there are any feedbacks
                if (!empty($feedbacks)) {
                    foreach ($feedbacks as $index => $feedback) {
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $feedback->name; ?></td>
                    <td><?php echo $feedback->rate; ?></td>
                    <td><?php echo $feedback->feed; ?></td>
                    <td><?php echo $feedback->date; ?></td>
                    <td>
                        <a href="deleteFeedback.php?id=<?php echo $feedback->ID; ?>" onclick="return confirm('Are you sure you want to delete this Feedback?');" class="btnDlt">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    // If there are no feedbacks, display a message
                ?>
                <tr>
                    <td colspan="6">No feedbacks Details Found</td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>

    <div>
        <?php
        include "Footer.html";
        ?>
    </div>
</body>
</html>
