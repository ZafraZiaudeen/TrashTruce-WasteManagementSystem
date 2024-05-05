<?php 
include_once('../FO/admin.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Trash-Truce</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="shortcut icon" href="../customer_TrashTruce/image/logo.jpg" type="image/x-icon">


  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/Untitled 1 (1).png" alt="">
        <span class="d-none d-lg-block">Trash-Truce</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="GET" action="">
        <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
  </div>
   

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        

        <li class="nav-item dropdown pe-3">
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <?php
        // Get the admin's full name and image
        $adminID = 1; // Assuming the admin ID is 1
        $admin = admin::GetAdmin($adminID);
        
        // Check if admin exists and has an image
        if ($admin && !empty($admin->image)) {
            echo '<img src="' . $admin->image . '" alt="Profile" class="rounded-circle">';
        } else {
            // If no image is found, display a default image
            echo '<img src="assets/img/default-profile-img.jpg" alt="Profile" class="rounded-circle">';
        }
        ?>
        <span class="d-none d-md-block dropdown-toggle ps-2">
            <?php
            // Display admin's full name
            if ($admin) {
                echo $admin->fullname;
            } else {
                echo "Admin Name"; // Default name if admin not found
            }
            ?>
        </span>
    </a><!-- End Profile Image Icon -->

    <!-- Dropdown Menu -->
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <!-- Dropdown Header -->
        <li class="dropdown-header">
            <h6>
                <?php
                // Display admin's full name in the dropdown header
                if ($admin) {
                    echo $admin->fullname;
                } else {
                    echo "Admin Name"; // Default name if admin not found
                }
                ?>
            </h6>
        
              <span>Admin</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="Profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

          
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="Dashboard.php">
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link " href="Customer.php">
          <span>Customer</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="Staff.php">
          <span>Staff</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="Schedule.php">
          <span>Schedule</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="Products.php">
         <span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="Category.php">
              <i class="bi bi-circle"></i><span>Category</span>
            </a>
          </li>
          <li>
            <a href="Products.php">
              <i class="bi bi-circle"></i><span>All Products</span>
            </a>
          </li>
        </ul>
      </li><!-- End Products Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
         <span>Special Events</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="Events.php">
              <i class="bi bi-circle"></i><span>Events</span>
            </a>
          </li>
          <li>
            <a href="Enrolled.php">
              <i class="bi bi-circle"></i><span>Enrolled</span>
            </a>
          </li>
        </ul>
      </li><!-- End Specail Events Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
         <span>Recycle</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="RecyclingGuide.php">
              <i class="bi bi-circle"></i><span>Recycling Guide</span>
            </a>
          </li>
          <li>
            <a href="Recycling.php">
              <i class="bi bi-circle"></i><span>Recycling Process</span>
            </a>
          </li>
          <li>
            <a href="Bin.php">
              <i class="bi bi-circle"></i><span>Recycling Bin</span>
            </a>
          </li>
         
        </ul>
      </li><!-- End Recycled Nav -->

      <li class="nav-item">
        <a class="nav-link " href="Location.php">
          <span>Location</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="Order.php">
          <span>Order</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="Feedback.php">
          <span>Feedbacks</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="ContactUs.php">
          <span>Contact Form</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link " href="News.php">
          <span>News</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link " href="Gallery.php">
          <span>Gallery</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="Team.php">
          <span>Team Member</span>
        </a>
      </li>
   

      <li class="nav-heading">Personal</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="Profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="Login.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
</body>

</html>


