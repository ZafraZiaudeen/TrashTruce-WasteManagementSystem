<?php 
include_once('../FO/orders.php');
include_once('../FO/products.php');
include_once('../FO/events.php');
session_start();
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
    <title>Document</title>
</head>
<body>
    <div>
        <?php
         include "Header.php";
        ?>
    </div>
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

               
                <div class="card-body">
                  <h5 class="card-title">Sales </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                    <?php
try {
    $salesCountDelivered = orders::GetSalesCountDelivered();
    echo "<h6>$salesCountDelivered</h6>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                      

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

               

                <div class="card-body">
                  <h5 class="card-title">Revenue </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                  try {
                      $revenueFromDeliveredOrders = orders::GetRevenueFromDeliveredOrders();
                      echo "<h6>Rs. $revenueFromDeliveredOrders</h6>";
                  } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                  }
                  ?>


                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

              

                <div class="card-body">
                  <h5 class="card-title">Customers</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                  try {
                      $totalCustomerCount = Customer::GetTotalCustomerCount();
                      echo "<h6>$totalCustomerCount</h6>";
                  } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                  }
                  ?>

                    

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

           

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

              
                <div class="card-body">
                  <h5 class="card-title">Recent Sales </h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                    try {
    // Retrieve all orders with associated customer information
    $orders = orders::GetOrdersforAll();

    // Loop through each order to display the details
    foreach ($orders as $order) {
        echo '<tr>';
        echo '<th scope="row"><a href="#">#' . $order->o_id . '</a></th>';
        echo '<td>' . $order->user->email . '</td>'; 
        echo '<td><a href="#" class="text-primary">' . $order->product . '</a></td>';
        echo '<td>Rs' . $order->price . '</td>';
        echo '<td><span class="badge ';
        
        // Determine badge color based on order status
        switch ($order->status) {
            case 'Delivered':
                echo 'bg-success">Delivered';
                break;
            case 'pending':
                echo 'bg-warning">Pending';
                break;
                case 'pending':
                  echo 'bg-primary">Dispatched';
                  break;
            case 'Cancelled':
                echo 'bg-danger">Rejected';
                break;
            default:
                echo 'bg-secondary">Unknown';
                break;
        }

        echo '</span></td>';
        echo '</tr>';
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            
            <div class="col-12">
              <div class="card top-selling overflow-auto">

               

                <div class="card-body pb-0">
                  <h5 class="card-title">Products </h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                     <?php
try {
    // Get all products
    $products = Products::GetActiveProducts();

    // Sort products based on the quantity sold (assuming the quantity sold is tracked in the database)
    usort($products, function($a, $b) {
        // Compare quantity sold in descending order
        return $b->quantitySold - $a->quantitySold;
    });

    // Display top selling products
    $counter = 0; // Counter to limit the number of displayed products
    foreach ($products as $product) {
        if ($counter < 5) { // Display only the top 5 selling products
            echo '<tr>';
            echo '<th scope="row"><a href="#"><img src="' . $product->pimage . '" alt=""></a></th>';
            echo '<td><a href="#" class="text-primary fw-bold">' . $product->pname . '</a></td>';
            echo '<td>Rs. ' . $product->pprice . '</td>';
           
            echo '</tr>';
            $counter++;
        } else {
            break; // Break the loop once top 5 products are displayed
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Events Activity -->
          <div class="card">
           

            <div class="card-body">
              <h5 class="card-title">Events Activity </h5>

              <div class="activity">

              <?php
                // Fetch last added 5 events
                $events = events::GetLastAddedEventsDash();

                // Check if there are any events
                if (!empty($events)) {
                    // Loop through each event
                    foreach ($events as $event) {
                        ?>
                        <div class="activity-item d-flex">
                            <div class="activite-label"><?php echo date('d-m-Y', strtotime($event->date)); ?></div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                <?php echo $event->name; ?>
                                
                            </div>
                        </div><!-- End activity item-->
                        <?php
                    }
                } else {
                    // If there are no events
                    echo "<p>No events found.</p>";
                }
                ?>

              </div>

            </div>
          </div><!-- End Recent Activity -->

          


        
<!-- News & Updates Traffic -->
<div class="card">
  <div class="filter">
    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
      <li class="dropdown-header text-start">
        <h6>Filter</h6>
      </li>
      <li><a class="dropdown-item" href="#" onclick="filterNews('today')">Today</a></li>
      <li><a class="dropdown-item" href="#" onclick="filterNews('this_month')">This Month</a></li>
      <li><a class="dropdown-item" href="#" onclick="filterNews('this_year')">This Year</a></li>
    </ul>
  </div>

  <div class="card-body pb-0">
    <h5 class="card-title">News &amp; Updates <span id="filterTitle">| Today</span></h5>

    <div class="news" id="newsContainer">
      <!-- News items will be dynamically loaded here -->
    </div><!-- End news -->

  </div>
</div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
<div>
    <?php
    include "Footer.html";
    ?>
</div>
<script>

function filterNews(filter) {
    // Send AJAX request to fetch filtered news data
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetchnews.php?filter=' + filter, true);
    xhr.onload = function() {
      if (xhr.status == 200) {
        // Update the news container with the retrieved data
        document.getElementById('newsContainer').innerHTML = xhr.responseText;
        // Update the filter title
        document.getElementById('filterTitle').innerText = '| ' + filter.charAt(0).toUpperCase() + filter.slice(1);
      }
    };
    xhr.send();
  }
</script>
</body>
</html>