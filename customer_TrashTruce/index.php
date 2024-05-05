<?php 
include_once('../FO/gallery.php');
include_once('../FO/events.php');
include_once('../FO/team.php');
session_start();
include('customer assets/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrashTruce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/homi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="image/logo.jpg" type="image/x-icon">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >
</head>
<body>
    
<style>


    .carousel-caption h5 {
        font-size: 5em;
        opacity: 0; 
        animation: fadeIn 1s ease forwards;
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

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1800"> 
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="image/ddd.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption text-center">
                <h5>Welcome</h5>
                <h5>To</h5>
                <h5>Trash Truce</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="image/Train-and-Bridge.jpg.webp" class="d-block w-100" alt="...">
            <div class="carousel-caption text-center">
                <h5>Welcome</h5>
                <h5>To</h5>
                <h5>Trash Truce</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="image/street-tour-mob.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption text-center">
                <h5>Welcome</h5>
                <h5>To</h5>
                <h5>Trash Truce</h5>
            </div>
        </div>
    </div>
</div>



 
<section id="about" class="about section-padding">
    <div class="container2">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-12">
                <div class="about-img">
                    <img src="image/gg.jpeg" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                <div class="about-text">
                    <p>Kandy Municipal Council was established under Ordinance No.17 of 1865. It's inaugural meeting was held on 20th March 1866. A Panel of Judges was appointed to go into cases where By-laws were violated. Those powers were transferred over to the Municipal Magistrate by Ordinance No.7 of 1887.

According to the 1866 Budget
Total Revenue of the Council was - £ 13,505 - 14 - 6
Total Expenditure was - £ 10,145 - 4 - 1
1915 - Revenue Rs.195,490.35
1915 - Expenditure Rs.193,069.49
Municipal Office was started at the present premises in March, 1870. Presently the Council is made up of 24 elected members.
                    </p>
                    <a href="abouttt.php" class="btn btn-warning">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="recycle_video">
    <video id="waste" width="100%" height="100%" loop muted onended="stopVideo()" autoplay>
        <source src="video/7655456-hd_1920_1080_25fps.mp4" type="video/mp4">
    </video>
</div>

<!--gallery-->
<section id="gallery" class="gallery section-padding">
    <div class="container1">
        <h2>
            <a href="gallery.php">Gallery</a>
        </h2>
        <hr class="line">
        <div class="gallery-description">
            <p>A waste management system gallery is a curated space dedicated to showcasing various aspects of waste management, including innovative technologies, sustainable practices, and educational materials. It serves as an informative and interactive platform for raising awareness about the challenges posed by waste and highlighting solutions to mitigate its negative impacts on the environment and human health</p>
        </div>
        <div class="gallery-grid">
            <?php
            // Call the method to get featured galleries
            $featuredGalleries = Gallery::GetFeaturedGalleries();
            // Iterate through each featured gallery and display them
            foreach ($featuredGalleries as $gallery) {
                echo '<div class="gallery-item">';
                echo '<img src="' . $gallery->img . '" alt="' . $gallery->name . '">';
                echo '</div>';
            }
            ?>
            <div class="row justify-content-center">
                <div class="arrow">
                    <a href="gallery.php" class="arrow">More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!--event-->
<section id="event" class="event section3-padding">
    <div class="container2">
        <div class="row">
            <div class="col">
                <div class="section-header text-center pb-5">
                    <h1>Special Event<div class="bottom_line"><span></span></div></h1>
                    
                    <div class="row">
                        <?php
                            

                            // Fetch the last added events
                            $events = events::GetLastAddedEvents();

                            // Loop through each event to display them
                            foreach ($events as $event) {
                        ?>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="card text-white text-center bg-white pb-2">
                                <div class="card-body text-dark">
                                    <div class="img-area mb-4">
                                        <img src="<?php echo $event->img; ?>" alt="" class="img-fluid">
                                    </div>
                                    <h3 class="card-title"><?php echo $event->name; ?></h3>
                                    <p class="lead"><?php echo $event->desc; ?></p>
                                    <!-- Link to event details page -->
                                    <a href="event.php" class="btn btn-warning">Learn More</a>
                                </div>
                            </div> 
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="bg-light py-3 py-md-5 py-xl-8 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                <h2 class="mb-4 display-5 text-center" style="font-size: 2rem; position: relative;">Our Team<span class="green-line-animation" style="position: absolute; width: 100%; height: 1px; background-color: #006A4E; bottom: -10px; left: 0;"></span></h2>
                <p class="text-secondary mb-5 text-center lead fs-4">We are a group of innovative, experienced, and proficient teams. You will love to collaborate with us.</p>
                <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Fetch and display team members -->
            <?php

                // Fetch the team members
                $teamMembers = Team::GetTeamMems();

                // Loop through each team member to display their details
                foreach ($teamMembers as $member) {
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 border-bottom border-primary shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <figure class="m-0 p-0">
                            <img class="img-fluid" loading="lazy" src="<?php echo $member->img; ?>" alt="">
                            <figcaption class="m-0 p-4">
                                <h4 class="mb-1"><?php echo $member->name; ?></h4>
                                <p class="text-secondary mb-0"><?php echo $member->position; ?></p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
        <!-- Button to go to "Read More" page -->
        <div class="row justify-content-center">
            <div class="arrow">
                <a href="OurStructure.php" class="arrow">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>



<?php 
include('customer assets/footer.html');
?>
</body>
</html>



  