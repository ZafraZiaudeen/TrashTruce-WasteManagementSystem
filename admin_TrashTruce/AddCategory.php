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
    <link href="assets/css/AddP.css" rel="stylesheet">
    <title>Add Category</title>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <style>
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
    <br><br>
    <div class="main">
        <div class="AddProduct">
            
            <h1>Add Category</h1><br>
            <!-- Form to add category -->
            <form action="" method="post">
                Category Name:
                <input type="text" name="CatName" required><br>
                
            
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
                <button class="btnAddProduct" type="submit" name="btnAdd">Add Category</button>
            </form>
            <!-- End of Form -->
        </div>
    </div>

    <div>
        <?php include "Footer.html"; ?>
    </div>
</body>
</html>

<?php 
if(isset($_POST["btnAdd"])){
  $categoryName = $_POST["CatName"];
  $active = isset($_POST["active"]) ? $_POST["active"] : "Yes"; // Set default value if not selected

  $product = new Products();
  $product->cName = $categoryName;
  $product->cactive = $active;

  try {
      // Add the category
      if ($product->Add()) {
          // Category added successfully
          echo '<script>alert("Category added successfully");</script>';
          header("Location:Category.php");
          exit; // Terminate script after redirection
      } else {
          // Failed to add category
          echo '<script>alert("Failed to add category");</script>';
          header("Location: AddCategory.php");
          exit; // Terminate script after redirection
      }
  } catch (Exception $e) {
      // Exception occurred
      echo '<script>alert("Failed to add category: ' . $e->getMessage() . '");</script>';
      header("Location: AddCategory.php");
      exit; // Terminate script after redirection
  }
}
ob_flush();
?>