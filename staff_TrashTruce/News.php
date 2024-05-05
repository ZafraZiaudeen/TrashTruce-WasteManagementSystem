<?php
include('../FO/news.php');
session_start();
// Call the GetNews() function to fetch news data
$news = News::GetNews();

$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<body>
<?php
          if (isset($_SESSION['add_news']) && !empty($_SESSION['add_news'])) {
            echo $_SESSION['add_news'];
            unset($_SESSION['add_news']);
        }
        if (isset($_SESSION['update_news']) && !empty($_SESSION['update_news'])) {
            echo $_SESSION['update_news'];
            unset($_SESSION['update_news']);
        }
        
        if (isset($_SESSION['delete_news']) && !empty($_SESSION['delete_news'])) {
            echo $_SESSION['delete_news'];
            unset($_SESSION['delete_news']);
        }

                           
// Retrieve enrollments from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $news = News::SearchNews($search); 
} else {
    $news = News::GetNews();
} 
        ?>
    <div>
       <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <div class="colorbar">
            <h1>View News</h1>
        </div>
      
        <div class="btnAll">
            <div class="btnAllDlt"><button class="btn10"><a href="AddNews.php">Add News</a></button></div>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No</th>
                    <th>News Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Added_Date</th>
                    <th>Action</th>
                </tr>
                <?php if (count($news) > 0): ?>

                <?php foreach ($news as $index => $item) : ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $item->name ?></td>
                    <td><?= $item->description ?></td>
                    <td><img src="<?= $item->img ?>" alt="<?= $item->name ?>" width="100px" height="100px"></td>
                    <td><?= $item->date ?></td>
                    <td>
                    <a href="deleteNews.php?id=<?php echo $item->ID; ?>"onclick="return confirm('Are you sure you want to delete this News?');"><span class="material-symbols-outlined">delete</span></a>
                        <a href="EditNews.php?id=<?= $item->ID ?>"><span class="material-symbols-outlined">edit</span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No News Details Found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>
