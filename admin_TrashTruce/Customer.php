<?php 
include('../FO/customer.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

// Initialize the $customers variable
$customers = array();

// Check if there's a search term
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    // Retrieve customer details based on the search term
    $customers = Customer::SearchCustomer($search);
} else {
    // If no search term provided, get all customer details
    $customers = Customer::GetUserDetails();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Customers</title>
</head>
<body>
<?php
if (isset($_SESSION['update_cus'])) {
    echo $_SESSION['update_cus'];
    unset($_SESSION['update_cus']);
}

if (isset($_SESSION['delete_cus']) && !empty($_SESSION['delete_cus'])) {
    echo $_SESSION['delete_cus'];
    unset($_SESSION['delete_cus']);
}
?>
<div>
    <?php include "Header.php"; ?>
</div>
<div class="main">
    <div class="colorbar">
        <h1>Customers</h1>
    </div>

    <!-- Search form -->
    <div class="search-bar">
        <form class="search-form" method="GET" action="">
            <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="intro">
        <table>
            <tr>
                <th>Serial No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Date</th>
                <th>Approval</th>
                <th>Action</th>
            </tr>
            <?php if (count($customers) > 0): ?>
                <!-- Display customer details in table rows -->
                <?php foreach ($customers as $index => $customer): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $customer->fname; ?></td>
                        <td><?php echo $customer->lname; ?></td>
                        <td><?php echo $customer->email; ?></td>
                        <td><?php echo $customer->phone; ?></td>
                        <td><?php echo $customer->address; ?></td>
                        <td><?php echo $customer->date; ?></td>
                        <td><?php echo $customer->approval; ?></td>
                        <td>
                            <button><a href="deleteCustomer.php?id=<?php echo $customer->ID; ?>" onclick="return confirm('Are you sure you want to delete this Customer?');"><span class="material-symbols-outlined">delete</span></a></button>
                            <button><a href="editCustomer.php?id=<?php echo $customer->ID; ?>"><span class="material-symbols-outlined">edit</span></a></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No Customer details found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<?php include "Footer.html"; ?>
</body>
</html>
