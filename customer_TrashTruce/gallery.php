<?php 
include('../FO/gallery.php');
session_start();
include('customer assets/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/gallery.css">
</head>
<body>
<header>
    <h1>GALLERY</h1>
    </header>
    
    <div class="container">
        
       <!-- Gallery -->
    <div class="row">
    <?php
    // Fetch galleries
    $galleries = Gallery::GetGalleries();

    // Iterate through each gallery and display them
    foreach ($galleries as $gallery) {
    ?>
    <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
        <img src="<?php echo $gallery->img; ?>" class="gallery-img shadow-1-strong rounded mb-4" alt="<?php echo $gallery->name; ?>" />
    </div>
    <?php
    }
    ?>
</div>
<!-- End Gallery -->
    </div>
    <?php include('customer assets/footer.html'); ?>
</body>
</html>
