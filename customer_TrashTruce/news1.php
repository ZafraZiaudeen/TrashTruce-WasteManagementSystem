<?php
ob_start();
include('../FO/news.php');
session_start();
include('customer assets/header.php');
if (!isset($_SESSION['customer_authenticated']) || $_SESSION['customer_authenticated'] !== true) {
    header("Location: login.php");
    exit();
}


$newsID = isset($_GET['id']) ? $_GET['id'] : null;

if ($newsID) {
    try {
        $newsItem = News::GetSNews($newsID);

        if ($newsItem) {
            // Now you have the news item, you can display its details
?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title><?= $newsItem->name ?></title>
                <link rel="stylesheet" href="css/newsdes.css">
            </head>
            <body>
            <header>
                <h1><?= $newsItem->name ?></h1>
                <h6>Date: <?= $newsItem->date ?></h6>
            </header>
            <div class="container">
                <div class="news1">
                    <div class="image">
                        <img src="<?= $newsItem->img ?>" alt="<?= $newsItem->name ?>" width="400">
                        <p class="description"><?= $newsItem->name ?></p>
                    </div>
                    <div class="content">
                        <p><?= $newsItem->description ?></p>
                    </div>
                </div>
            </div>
            <?php
            include('customer assets/footer.html');
            ?>
            </body>
            </html>
<?php
        } else {
            // Handle case where news item with the given ID is not found
            echo "News item not found.";
        }
    } catch (Exception $e) {
        // Handle exception
        echo '<p>Error: ' . $e->getMessage() . '</p>';
    }
} else {
    // Handle case where ID is not provided
    echo "News ID not provided.";
}
?>

    </div>

</body>
</html>