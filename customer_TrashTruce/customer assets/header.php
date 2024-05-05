<?php
$authenticated = isset($_SESSION["customer_authenticated"]) && $_SESSION["customer_authenticated"] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrashTruce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../customer_TrashTruce/css/homi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="../customer_TrashTruce/image/logo.jpg" type="image/x-icon">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >


   
</head>
<body>
    <header>
     <nav class="navbar navbar-expand-lg bg-body-tertiary">
       <div class="container-fluid">
           <a class="navbar-brand" href="#">
               <img src="image/trash-truce-high-resolution-logo.png" alt="Logo">
           </a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                   <li class="nav-item">
                       <a class="nav-link" href="index.php">
                           <i class="fas fa-home"></i> Home
                       </a>
                   </li>
                 
                  
                   <li class="nav-item">
                       <a class="nav-link" href="event.php">Event</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="Viewproduct.php">Product</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="guild.php"> Recycle Guild</a>
                   </li>
                   <li class="nav-item">
                    <a class="nav-link" href="news.php">News</a>
                </li>
                <li class="nav-item">
                       <a class="nav-link" href="contactus.php">Contact Us</a>
                   </li>
                   <?php if ($authenticated): ?>
                   <li class="nav-item">
                       <a class="nav-link" href="Schedule.php" id="scheduleLink">Schedule</a>
                   </li>
                   <li class="nav-item">
                    <a class="nav-link" href="feedback.php" id="feedbackLink">FeedBack</a>
                </li>
                   <li class="nav-item">
                    <a class="nav-link" href="myOrders.php" id="myOrdersLink">My Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="location.php">DropOff</a>
                </li>
                <?php endif; ?>
                   
                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="abouttt.php" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           About Us
                       </a>
                       <ul class="dropdown-menu" aria-labelledby="userDropdown">
                           <li><a class="dropdown-item" href="OurStructure.php">Our Structure</a></li>
                           <li><a class="dropdown-item" href="vimi.php">Vision Mision</a></li>

                       </ul>
                   </li>
               </ul>
   
            
   
               <!-- Icons -->
               <ul class="navbar-nav ms-auto">
                   <li class="nav-item">
                       <a class="nav-link" href="Cartnew.php" id="cartIcon">
                           <i class="fas fa-shopping-cart"></i> <span id="cartCount" class="badge bg-secondary"></span>
                       </a>
                   </li>
                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fas fa-user"></i>
                       </a>
                       <ul class="dropdown-menu" aria-labelledby="userDropdown">
                           <li><a class="dropdown-item" href="login.php">Login</a></li>
                           <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                       </ul>
                   </li>
               </ul>
           </div>
       </div>
   </nav>
   
  

    
   
   
   </header>
   <style>
       .carousel-caption h5 {
           font-size: 5em; /* Increase font size */
           opacity: 0; /* Initially hide text */
           animation: fadeIn 1s ease forwards; /* Apply fade-in animation */
       }
   
       @keyframes fadeIn {
           from {
               opacity: 0;
           }
           to {
               opacity: 1;
           }
       }
   </style>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
</body>
</html>
