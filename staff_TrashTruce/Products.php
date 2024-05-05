<?php
include('../FO/products.php');
// Fetch products from the database
$products = Products::GetProducts();
session_start();
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
    <title>Document</title>
</head>
<body>
<?php
                        
// Retrieve Products from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $categoryID = isset($_GET['category']) ? $_GET['category'] : null; // Retrieve the category ID from the query string
    $products = Products::SearchProducts($search, $categoryID); // Pass both search term and category ID
} else {
    // If no search term provided, get all products
    $products = Products::GetProducts();
}
?>  
    <div>
       <?php include "Header.php"; ?>
    </div>
    <div class="main">
        <div class="colorbar">
          <h1> Products</h1>
        </div>
            
        <div class="btnAll">
            <!--------------------------------Add Products button------------------------->
            <div class="btnAllDlt"><button class="btn10"><a href="AddProduct.php">Add Products</a></button></div>
        </div>

        <div class="intro">
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price(Rs)</th>
                    <th>Product Image</th>         
                    <th>Active Status</th>
                </tr>
                <?php if (count($products) > 0): ?>

                <?php foreach ($products as $index => $product): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $product->pname; ?></td>
                    <td><?php echo $product->cName; ?></td>

                    <td><?php echo $product->pdescription; ?></td>
                    <td><?php echo $product->pprice; ?></td>
                    <td><img src="<?php echo $product->pimage; ?>" alt="<?php echo $product->pname; ?>" width="100px" height="100px"></td>
                    <td><?php echo $product->pactive; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No Product Details Found.</td>
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
