<?php 
include('../FO/team.php');
session_start();
include('customer assets/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/ourstructure.css">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>Trash Truce</title>
</head>
<body>

<div class="py-5 team3 bg-light">
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-md-7 text-center">
        <h1 class="mb-3">Our Structure</h1>
      </div>
    </div>
    <div class="row">
      <!-- column  -->
      
        <!-- Row -->
        <?php
        try {
            // Get team members
            $teamMembers = Team::GetTeamMems();

            // Check if there are any team members
            if (!empty($teamMembers)) {
                // Loop through each team member
                foreach ($teamMembers as $member) {
                    // Display the team member's details
                    echo'<div class="col-lg-4 mb-4">';
                    echo '<div class="row">';
                    echo '<div class="col-md-12">';
                    echo '<img src="' . $member->img . '" alt="' . $member->name . '" class="img-fluid" />';
                    echo '</div>';
                    echo '<div class="col-md-12">';
                    echo '<div class="pt-2">';
                    echo '<h5 class="mt-4 font-weight-medium mb-0">' . $member->name . '</h5>';
                    echo '<h6 class="subtitle">' . $member->position . '</h6>';
                    echo '<p>' . $member->description . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // No team members found
                echo '<p>No team members available.</p>';
            }
        } catch (Exception $e) {
            // Handle exception
            echo '<p>Error: ' . $e->getMessage() . '</p>';
        }
        ?>
        <!-- Row -->
      
      <!-- column  -->
      <!-- column  -->
      <div class="col-lg-4 mb-4">
        <!-- Row -->
        <div class="row">
          
          <div class="col-md-12">
            <div class="pt-2">
            
              
              <ul class="list-inline">
                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-facebook"></i></a></li>
                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-twitter"></i></a></li>
                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-instagram"></i></a></li>
                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-behance"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Row -->
      </div>
      <!-- column  -->
      <!-- column  -->
  
        <!-- Row -->
      </div>
      <!-- column  -->
    </div>
  </div>
</div>
    <?php
    include ('customer assets/footer.html');
    ?>
</body>
</html>