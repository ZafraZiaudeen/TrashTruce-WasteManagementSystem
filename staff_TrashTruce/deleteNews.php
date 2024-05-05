<?php
include('../FO/news.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($_GET['id'])) {
        $newsId = $_GET['id'];

        News::Delete($newsId);

        if ($_SESSION['delete_news'] = true) {
            $_SESSION['delete_news'] = '<script>alert("News Deleted Successfully");</script>';
            header("Location: News.php");
        } else {
            $_SESSION['delete_news'] = '<script>alert("Failed to delete News");</script>';
            header("Location: News.php");
        }

        exit();
    }

    ?>

</body>

</html>