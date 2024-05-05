<?php 
include('../FO/contactus.php');
session_start();
include('customer assets/header.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Save data to the database
    $contact = new ContactUs();
    $contact->name = $name;
    $contact->phone = $phone;
    $contact->email = $email;
    $contact->message = $message;
    $contact->AddContactUs();

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                            
        $mail->Host       = 'smtp.gmail.com';    
        $mail->SMTPAuth   = true;                   
        $mail->Username = 'trashtruce@gmail.com';
                $mail->Password = 'qjupisxaixcfrffk';      
        $mail->SMTPSecure ='tls'; 
        $mail->Port       = 587;                  

        // Recipients
        $mail->setFrom($email, $name); 
        $mail->addAddress('trashtruce@gmail.com', 'admin');

        // Content
        $mail->isHTML(true);  
        $mail->Subject = 'New Message from Contact Form';
        $mail->Body    = "Name: $name<br>Phone: $phone<br>Email: $email<br>Message:<br>$message";

        $mail->send();
        echo '<script>alert("Your message has been sent. We will get back to you soon.");</script>';
    } catch (Exception $e) {
        echo '<script>alert("There was an error sending your message. Please try again later.");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
    <link rel="stylesheet" href="css/contact.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <div class="custom-background-container">

    <header>
     <h1>Contact Us</h1>
  </header>

    <main>
        <section class="contact-section">
            <section class="contact-info">
                <div class="icon">
                    <i class="fas fa-map-marker-alt"></i> 
                    <h3>Our Location</h3>
                    <p>Kandy Province, Sri Lanka</p>
                </div>
                
                <div class="icon">
                    <i class="fas fa-phone"></i> 
                    <h3>Our Number</h3>
                    <p>+94 77 456 890</p>
                    <p>15445655556666</p>
                </div>

                <div class="icon">
                    <i class="fas fa-envelope"></i> 
                    <h3>Email</h3>
                    <p>info@example.com</p>
                </div>
            </section>
          
            <div class="contact-form">
                <h2>Get In Touch</h2>
                <form action="" method="POST">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" required><br><br>
                    <label for="phone">Phone Number</label><br>
                    <input type="text" id="phone" name="phone" required><br><br>
                    <label for="email">Email:(Please give a valid Email)</label><br>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="message">Message:</label><br>
                    <textarea id="message" name="message" rows="4" required></textarea><br><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>This is a list of boards that we adhere to in our recycling process. Get in touch with us about anything related to our company or services</p>
    </footer>
    </div>
    <?php
include ('customer assets/footer.html');
?>
</body>
</html>