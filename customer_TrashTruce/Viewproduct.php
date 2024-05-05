<?php 
include('../FO/products.php');
include('../FO/cart.php');
session_start();
include('customer assets/header.php');

$categories = array();

// Fetch active categories with error handling
try {
    $categories = Products::GetActiveCategories();
} catch (Exception $e) {
    // Handle the exception, you can log or display an error message here
    echo "Error fetching categories: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processed Goods for Sale</title>
    <link rel="stylesheet" href="css/viewproduct.css">
    <!-- Include Font Awesome -->
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >
</head>
<body>
    <header>
        <h1>PRODUCTS</h1>
    </header>
    
    <!-- Category filter buttons -->
    <div class="category-filter">
        <button onclick="filterCategory('all')">All</button>
        <?php foreach ($categories as $category): ?>
            <button onclick="filterCategory('<?php echo $category->cName; ?>')"><?php echo $category->cName; ?></button>
        <?php endforeach; ?>
    </div>
    
    <!-- Search bar container -->
    <div class="searchs">
        <form action="" method="post">
            <!--<label for="search">Search:</label>-->
            <input type="text" name="search" id="searchInput" placeholder="Search..." required>
            <button class="btn4" type="submit">Search</button>
        </form>
    </div>
    <form action="" method="post">
    <div class="data">
        <?php
        // Fetch all active products
        $products = Products::GetActiveProducts();
        $row=0;
        foreach ($products as $product):
        ?>
        <div class="data1" data-category="<?php echo $product->cName; ?>">
            <div class="image-container"> <!-- Added a container for the image -->
                <img src="<?php echo $product->pimage; ?>" alt="<?php echo $product->pname; ?>">
            </div>
            <div>
                <h3><?php echo $product->cName; ?> - <?php echo $product->pname; ?></h3>
                <p>Description: <?php echo $product->pdescription; ?></p>
                <p>Price: Rs. <?php echo $product->pprice; ?></p>
                <p>Quantity :
                <input type="number" class="quantity-input" name="txtQty[]" value="1" min="1"></p>
                <input type="hidden" name="txtID[]" value="<?php echo $product->pID; ?>">
                <button type="submit" name="btnAddCart" value="<?php echo $row; ?>"><i Value="<?php echo $row; ?>" class="fas fa-shopping-cart cart-icon"></i>Add To Cart</button>
            </div>
        </div>
        <?php 
        $row++;
        endforeach; ?>
    </div>
    </form>
    <script>
        // JavaScript for search functionality
        const searchInput = document.getElementById('searchInput');
        const products = document.querySelectorAll('.data1');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();

            products.forEach(product => {
                const productTitle = product.querySelector('h3').textContent.toLowerCase();
                if (productTitle.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // JavaScript for category filtering
        function filterCategory(category) {
            products.forEach(product => {
                const productCategory = product.getAttribute('data-category');
                if (category === 'all' || productCategory === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }
        
    </script>
    
<?php
include ('customer assets/footer.html');
?>
</body>
</html>

<?php
if(isset($_POST["btnAddCart"]) && isset($_POST["txtQty"])) {
    $r = $_POST["btnAddCart"];
    $product = Products::GetProduct($_POST["txtID"][$r]);

    // Debugging: Output product information
    var_dump($product);

    if(!isset($_SESSION["Cart"])) {
        $mycart = array();
        $_SESSION["Cart"] = $mycart;
    }
    $mycart = $_SESSION["Cart"];
    $found = false;
    if(sizeof($mycart) != 0) {
        foreach($mycart as $item) {
            if($item->ID == $_POST["txtID"][$r]) {
                $qty = $item->Qty;
                $item->Qty = $qty + $_POST["txtQty"][$r];
                $found = true;
                break;
            }
        }
    }
    if(!$found) {
        $item = new cart;
        $item->ID = $product->pID;
        $item->Name = $product->pname;
        $item->Image = $product->pimage;
        $item->Price = $product->pprice;
        $item->category = $product->cName;
        $item->Qty = $_POST["txtQty"][$r];
        array_push($mycart, $item);
    }
    $_SESSION["Cart"] = $mycart;

    // Debugging: Output cart items
    var_dump($_SESSION["Cart"]);
}
?>