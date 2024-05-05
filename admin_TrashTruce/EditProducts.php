<?php 
ob_start();
include('../FO/products.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/AddP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
    <style>
        /* Style for radio buttons */
        .radio-container {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        .radio-container input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: inline-block;
            cursor: pointer;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
        }

        .radio-label:hover {
            background-color: #006A4E;
        }

        .radio-container input[type="radio"]:checked + .radio-label {
            background-color: #006A4E;
            color: #fff;
            border-color: #007bff;
        }

        /* Hide default radio button */
        input[type="radio"] {
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <?php include "Header.php"; ?>
     </div>

     <div class="main">
    <div class="AddProduct">
        <h1>Update Products</h1><br>
        <!---------------------- start Form-------------------------------------->
        <form action="" method="post" enctype="multipart/form-data">

        
        <?php      
        if (isset($_GET['id'])) {
          $product_id = $_GET['id'];
          $product = Products::GetProduct($product_id);
        }
        if (isset($product)) {
        ?>      
                  <input type="hidden" name="ID" value="<?php echo $product->pID; ?>">

            Product Name :
            <input type="text" name="PName" value="<?php echo $product->pname; ?>"><br>

            Description:
            <textarea name="txtSDes" cols="21" rows="2"><?php echo $product->pdescription; ?></textarea><br>

            Price:
            <input type="number" name="txtPrice" placeholder="Price" value="<?php echo $product->pprice; ?>"><br>
            
            Product Image:
                <input type="file" name="image"><br>

            Active:
            <div class="radio-container">
                <input type="radio" id="active_yes" name="active" value="Yes" <?php if ($product->pactive=="Yes") echo "checked"; ?>>
              <label for="active_yes" class="radio-label">Yes</label>
            </div>
            <div class="radio-container">
            <input type="radio" id="active_no" name="active" value="No" <?php if ($product->pactive == "No") echo "checked"; ?>>
            <label for="active_no" class="radio-label">No</label>
            </div><br><br>

            Choose Category :
            <select name="category">
                <?php 
                $product=new Products();
                $categories=$product->GetCategories();
                if(count($categories) > 0) {
                    foreach($categories as $cat) {   
                        $selected = ($cat->cID == $product->pcat_id) ? 'selected' : '';
                        echo "<option value='".$cat->cID."' $selected>".$cat->cName."</option>";
                    }
                } else {
                    echo '<option value="0">No categories available</option>';
                }
                ?>
            </select>
          <br><br>
            <button class="btnAddProduct" type="submit" name="update_product">Update Product</button>
            <?php
               }
            ?>
        <!---------------------- finish Form-------------------------------------->
        </form>
    </div>
</div>


    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>

<?php

// Handle form submission to update product
if (isset($_POST['update_product'])) {
  try {
      // Retrieve form data
      $product_id= isset($_POST["ID"]) ? $_POST["ID"] : null;
      $name = isset($_POST["PName"]) ? $_POST["PName"] : "";
      $description = isset($_POST["txtSDes"]) ? $_POST["txtSDes"] : "";
      $price = isset($_POST["txtPrice"]) ? $_POST["txtPrice"] : "";
      $active = isset($_POST["active"]) ? $_POST["active"] : "";
      $category = isset($_POST["category"]) ? $_POST["category"] : "";

      // Create a new Products instance
      $product = new Products();
      $product->pID = $product_id;
      $product->pname = $name;
      $product->pdescription = $description;
      $product->pprice = $price;
      $product->pactive = $active;
      $product->pcat_id = $category;

      
   try{
    $product->UpdateProduct();
    $ID=$product->pID;

      // Handle image update if provided
      if (isset($_FILES["image"]) && isset($_FILES["image"]["error"]) && $_FILES["image"]["error"] == 0 && $_FILES["image"]["name"] != '') 
      {
      $Image = $_FILES["image"]["name"];
      $info = new SplFileInfo($Image);
      $newName = "../product_image/" . $ID . 'P.' . $info->getExtension();
      move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
  
      $product->pimage = $newName;
      $product->UpdatePImage();
  }
    } catch (Exception $ex) {
    echo $ex->getMessage();
    }

      $_SESSION['update_product'] = '<script>alert("Product updated successfully");</script>';
      header("Location: Products.php");
      exit();
  } catch (Exception $e) {
      $_SESSION['update_product'] = '<script>alert("Failed to update Product: ' . $e->getMessage() . '");</script>';
      header("Location: EditProduct.php?id=" . $product_id);
      exit();
  }
}

ob_flush();
?>