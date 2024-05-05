<?php 
ob_start();
include('../FO/feedback.php');
session_start();
include('customer assets/header.php');
if (!isset($_SESSION['customer_authenticated']) || $_SESSION['customer_authenticated'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="css/feedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
<header>
     <h1>Feedback</h1>
  </header>
   
    <img src="image/feedback1.jpg" alt="Description of the image" class="your-image-class">
    <form id="feedbackForm" method="post">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="rating">Rating (1-5):</label>
    <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="comment">Feedback:</label>
        <textarea id="comment" name="comment" rows="4" required></textarea>

        <button type="submit" name="addfeed">Submit Feedback</button>
    </form>
    
    
    <div id="reviews">
        <h2>Customer Reviews</h2>
      <?php
        try {
        // Get feedbacks
        $feedbacks = Feedback::GetFeedbacks();

        // Check if there are any feedbacks
        if (!empty($feedbacks)) {
            // Loop through each feedback
            foreach ($feedbacks as $feedback) {
                // Display the feedback details
                echo '<div class="review">';
                echo '<strong>' . $feedback->name . '</strong> - Rating: ' . $feedback->rate . '/5';
                echo '<p>Date & Time: ' . $feedback->date . '</p>';
                echo '<p>' . $feedback->feed . '</p>';
                echo '</div>';
            }
        } else {
            // No feedbacks found
            echo '<p>No feedbacks available.</p>';
        }
    } catch (Exception $e) {
        // Handle exception
        echo '<p>Error: ' . $e->getMessage() . '</p>';
    }
    ?>
</div>
       
    </div>

    <div id="successMessage"></div>

   
   <?php
include ('customer assets/footer.html');
?> 
</body>
</html>


<?php 
if(isset($_POST["addfeed"])){
  $Name = $_POST["name"];
  $rate= $_POST["rating"];
  $Comment =$_POST["comment"];

  $feed = new Feedback();
  $feed->name = $Name;
  $feed->rate = $rate;
  $feed->feed= $Comment;

  try {
      // Add the feed
      if ($feed->AddFeed()) {
          // Feedback added successfully
          echo '<script>alert("Feedback added successfully");</script>';
          header("Location:feedback.php");
          exit;
      } else {
          // Failed to add feedback
          echo '<script>alert("Failed to add feedback");</script>';
          header("Location: feeback.php");
          exit; // Terminate script after redirection
      }
  } catch (Exception $e) {
      // Exception occurred
      echo '<script>alert("Failed to add feedback: ' . $e->getMessage() . '");</script>';
      header("Location: feedback.php");
      exit; 
  }
}
ob_flush();
?>