<?php
ob_start();
session_start();
include('customer assets/header.php');
// Check if the user is authenticated
if (!isset($_SESSION['customer_authenticated']) || $_SESSION['customer_authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

// Include necessary files
require_once('../FO/Customer.php');
require_once('../FO/events.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

// Fetch the logged-in user's email from session
$userEmail = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;

// Fetch event ID from query parameters
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if form data is submitted
    if ($userEmail) {
        // Check if the necessary form fields are set
        if (isset($_POST['name'], $_POST['phone'], $_POST['address'])) {
            // Create an instance of the events class and set the enrollment details
            $enrollment = new events();
             // Check if the user has already enrolled for this event
             if ($enrollment->isUserEnrolled($userEmail, $event_id)) {
                echo '<script>alert("You have already joined this event.");</script>';
               
            } else {
                // Set the event_id for enrollment
                $enrollment->ee_id = $event_id;
                $enrollment->ename = $_POST['name'];
                $enrollment->eemail = $userEmail; 
                $enrollment->ephone = $_POST['phone'];
                $enrollment->eaddress = $_POST['address'];

                // Add enrollment to the database
                try {
                    // Add enrollment to the database and retrieve the enrollment ID
                    $enrollmentId = $enrollment->AddEnrollment($event_id);

                    // Send confirmation email
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'trashtruce@gmail.com';
                    $mail->Password = 'qjupisxaixcfrffk';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('trashtruce@gmail.com', 'TrashTruce');
                    $mail->addAddress($userEmail);
                    $mail->isHTML(true);
                    $mail->Subject = 'Thank you for joining the event';
                    $mail->Body = "Dear User,<br><br>Thank you for joining the event!<br>Your registration has been successfully submitted.<br><br>Best regards,<br>The TrashTruce Team";;
                    
                    // Attempt to send email
                    if ($mail->send()) {
                        echo '<script>alert("Thank you for joining the event! An email has been sent to your registered email address.");</script>';
                    } else {
                        throw new Exception("Failed to send confirmation email.");
                    }
                } catch (Exception $e) {
                    echo '<script>alert("Failed to join the event. Please try again later.");</script>';
                }
            }
            echo '<script>window.location.href = "event.php";</script>';
            exit(); 
           
        } else {
            echo '<script>alert("Please fill out all the fields.");</script>';
        }
    } else {
        echo '<script>alert("User email not found. Please log in again.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Event</title>
    <link rel="stylesheet" href="css/join.css">
</head>
<body>
    <header>
        <h1>Join Event</h1>
    </header>

    <div class="container">
        <form id="join-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?event_id=' . $event_id; ?>" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>

            <label for="phone">Phone:</label><br>
            <input type="tel" id="phone" name="phone"><br>

            <label for="address">Address:</label><br>
            <textarea id="address" name="address"></textarea><br><br>

            <input type="submit" name="submit" value="Join">
        </form>
    </div>
</body>
</html>
<?php
include ('customer assets/footer.html');
?>