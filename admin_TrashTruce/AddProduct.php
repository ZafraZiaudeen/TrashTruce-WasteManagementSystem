<?php 
ob_start();
include('../FO/products.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
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
    <link rel="stylesheet" href="assets/css/AddP.css">
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
        <?php
           include "Header.php";
         ?>;
     </div>

     <div class="main">

<div class="AddProduct">
        <h1>Add Products</h1><br>
            <!---------------------- start Form-------------------------------------->
            <form action="" method="post" enctype="multipart/form-data">
              
            
                Product Name :
                <input type="text" name="PName" required><br>

                 Description:
                <textarea name="txtSDes" cols="21" rows="2" required></textarea><br>

                Price:
                <input type="number" name="txtPrice" placeholder="Price" required><br>
                
                Product Image:
                <input type="file" name="image"><br>

                Choose Category :
                <select name="category">
                        <?php 
                        $product=new Products();
                        $categories=$product->GetCategories();
                        if(count($categories)>0){
                            foreach($categories as $cat) {   
                                echo "<option value='".$cat->cID."'>".$cat->cName."</option>";
                            }
                        } else {
                            echo '<option value="0">No categories available</option>';
                        }
                        ?>
                    </select><br>

                    Active:
                <div class="radio-container">
                    <input type="radio" id="active_yes" name="active" value="Yes" checked>
                    <label for="active_yes" class="radio-label">Yes</label>
                </div>
                <div class="radio-container">
                    <input type="radio" id="active_no" name="active" value="No">
                    <label for="active_no" class="radio-label">No</label>
                </div>
<br><br>
                <button class="btnAddProduct" type="submit" name="Add_product">Add Product</button>
            <!---------------------- finish Form-------------------------------------->
            </form>
</div>


</div>


  <div>
  <?php
    include "Footer.html";
    ?>
  </div>
</body>
</html>
<?php 
if (isset($_POST["Add_product"])) {      
    $product = new Products;
    $product->pname = $_POST["PName"];
    $product->pdescription = $_POST["txtSDes"];
    $product->pprice = $_POST["txtPrice"];
    $product->pcat_id = $_POST["category"];

    if (isset($_POST["active"])) {
        $product->pactive = $_POST["active"];
    } else {
        // Default value
        $product->pactive = "No";
    }

    // Check if file is selected and it is an image
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $fileType = $_FILES["image"]["type"];
        
        if(in_array($fileType, $allowedTypes)){
            try {
                $id = $product->AddProduct();  
                $Image = $_FILES["image"]["name"]; 
                $info = new SplFileInfo($Image); 
                $newName = "../product_image/" . $id . 'P.' . $info->getExtension(); 
                $product->pID = $id;
                move_uploaded_file($_FILES["image"]["tmp_name"], $newName);
                $product->pimage = $newName; 
                $product->UpdatePImage();

                $_SESSION['add_product'] =  '<script>alert("Product added Successfully");</script>';
                header("Location: Products.php");
                exit();
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            echo '<script>alert("Invalid file type. Please upload only image files (JPEG, PNG, GIF).");</script>';
        }
    } else {
        echo '<script>alert("Please select a file to upload.");</script>';
    }
}
ob_flush();
?>