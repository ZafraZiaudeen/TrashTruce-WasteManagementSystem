<?php 
include('../FO/news.php');
session_start();
include('customer assets/header.php');
try {
    $newsList = News::GetNewsWordLimits(); 
} catch (Exception $e) {
    // Handle exception
    echo '<p>Error: ' . $e->getMessage() . '</p>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/news.css">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <title>Trash Truce News</title>
    
</head>
<body>
    <div class="container">
        <h1> NEWS</h1>
        <?php foreach ($newsList as $news): ?>
        <div class="article">
        

             <img src="../news_image/<?= $news->img ?>" alt="Image">
            <h2><?= $news->name ?></h2>
            <div class="news">
            <p><?= $news->description?> <pulvinar class="lorem20"></pulvinar></p>
            <p><strong>Date:</strong> <?= $news->date ?></p>
             </div>
             <br><br><br><br>
             <a href="news1.php?id=<?= $news->ID ?>">Read More</a>

            
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

</div>
    <?php
    include ('customer assets/footer.html');
    ?>