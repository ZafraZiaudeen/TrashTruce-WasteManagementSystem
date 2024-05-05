<?php 
include('../FO/products.php');
session_start();
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // If not authenticated, redirect to the login page
    header("Location: login.php");
    exit();
}
// Get all categories
try {
    $categories = Products::GetCategories();
} catch (Exception $e) {
    // Handle exception
    echo 'Error: ' . $e->getMessage();
}
if (isset($_SESSION['delete_cat']) && !empty($_SESSION['delete_cat'])) {
    echo $_SESSION['delete_cat'];
    unset($_SESSION['delete_cat']);
}
if (isset($_SESSION['update_cat']) && !empty($_SESSION['update_cat'])) {
    echo $_SESSION['update_cat'];
    unset($_SESSION['update_cat']);
}
  // Retrieve Categories from the database based on the search query
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $categories = Products::SearchCategories($search); 
} else {
    $categories = Products::GetCategories();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <title>Document</title>
</head>
<body>
    <div>
       <?php include "Header.php"; ?>
    </div>

    <div class="main">
        <div class="colorbar">
            <h1>Category</h1>
        </div>
      
        <div class="btnAll">


            <div class="btnAllDlt"><button class="btn10"><a href="AddCategory.php">Add Category</a></button></div>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No</th>
                    <th>Category Name</th>
                    <th>Active status</th>
                    <th>Action</th>
                </tr>
                <?php if (count($categories) > 0): ?>

                <?php foreach ($categories as $index => $category): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $category->cName; ?></td>
                    <td><?php echo $category->cactive; ?></td>
                    <td>
                        <a href="deleteCategory.php?id=<?php echo $category->cID; ?>" onclick="return confirm('Are you sure you want to delete this Category?');"><span class="material-symbols-outlined">delete</span></a>
                        <a href="EditCategory.php?id=<?php echo $category->cID; ?>"><span class="material-symbols-outlined">edit</span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No Category Details Found.</td>
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
