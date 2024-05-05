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
    <link href="assets/css/AddP.css" rel="stylesheet">
    <title>Edit Category</title>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
            <h1>Edit Category</h1><br>
            <!-- Form to edit category -->
            <form action="" method="post">
            <?php
            if (isset($_GET['id'])) {
                $cate_id = $_GET['id'];
                $cate = Products::GetCategory($cate_id);
                if ($cate) { 
            ?>          
                Category Name:
                <input type="text" name="CatName" value="<?php echo $cate->cName; ?>" required><br>
                
                Active:
                <div class="radio-container">
                    <input type="radio" id="active_yes" name="active" value="Yes" <?php if ($cate->cactive == "Yes") echo "checked"; ?>>
                    <label for="active_yes" class="radio-label">Yes</label>
                </div>
                <div class="radio-container">
                    <input type="radio" id="active_no" name="active" value="No" <?php if ($cate->cactive == "No") echo "checked"; ?>>
                    <label for="active_no" class="radio-label">No</label>
                </div>
                
                <br><br>
                <button class="btnAddProduct" type="submit" name="Update">Update Category</button>
                <?php
                }
            }
            ?>
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
if (isset($_POST['Update'])) {
    try {
        // Retrieve form data
        $cateID = isset($_GET['id']) ? $_GET['id'] : null; 
        $cateName = isset($_POST["CatName"]) ? $_POST["CatName"] : "";
        $active = isset($_POST["active"]) ? $_POST["active"] : "Yes"; // Set default value if not selected
        
        // Create a new instance of the Products class
        $category = new Products();
        $category->cID = $cateID;
        $category->cName = $cateName;
        $category->cactive = $active;

        // Update the category
        $category->Update();
        
        // Redirect after successful update
        $_SESSION['update_cat'] = '<script>alert("Category updated successfully");</script>';
        header("Location: Category.php");
        exit();
    } catch (Exception $e) {
        // Handle update failure
        $_SESSION['update_cat'] =  '<script>alert("Failed to update category: ");</script>' . $e->getMessage();
        header("Location: EditCategory.php?id=" . $cateID);
        exit();
    }
}
ob_flush();
?>
