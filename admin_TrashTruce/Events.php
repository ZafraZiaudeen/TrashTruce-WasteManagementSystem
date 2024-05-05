<?php
include('../FO/events.php');
$events = events::GetEvents();
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
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
    
</head>
<body>
<?php
            if (isset($_SESSION['update_event'])) {
                echo $_SESSION['update_event'];
                unset($_SESSION['update_event']);
            }
      
            if (isset($_SESSION['delete_event']) && !empty($_SESSION['delete_event'])) {
                echo $_SESSION['delete_event'];
                unset($_SESSION['delete_event']);
            }
            if (isset($_SESSION['add_event']) && !empty($_SESSION['add_event'])) {
                echo $_SESSION['add_event'];
                unset($_SESSION['add_event']);
            }
           
// Retrieve events from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $events = events::SearchEvents($search);
} else {
    $events = events::GetEvents();
}
            ?>
    <div>
       <?php
         include "Header.php";
        ?>
    </div>

    <div class="main">
        <div class="colorbar">
          <h1>Events</h1>
        </div>

      
   <div class="intro">

    <div class="btnAll">
   
    <!--------------------------------Add Products button------------------------->
    <div class="btnAllDlt">
                    <button class="btnevent" style="margin-left:auto"><a href="AddEvents.php">Add Events</a></button>
                </div>
</div>

    <table>
        <tr>
            <th>Serial No.</th>
            <th>Event Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>Location</th>
            <th>Date</th>
            <th>Time</th>           
            <th>Action</th>
        </tr>
        <?php if (count($events) > 0): ?>
        <?php foreach ($events as $index => $event): ?>
            
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $event->name; ?></td>
                        <td><img src="<?php echo $event->img; ?>" alt="<?php echo $event->name; ?>" style="max-width: 100px; max-height: 100px;"></td>
                        <td><?php echo $event->desc; ?></td>
                        <td><?php echo $event->loc; ?></td>
                        <td><?php echo $event->date; ?></td>
                        <td><?php echo $event->time; ?></td>
                        <td>
                           
                            <a href="deleteEvent.php?id=<?php echo $event->ID; ?>"onclick="return confirm('Are you sure you want to delete this Event?');"><span class="material-symbols-outlined">delete</span></a>
                            <a href="EditEvent.php?id=<?php echo $event->ID; ?>"><span class="material-symbols-outlined">edit</span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No Event details found</td>
            </tr>
        <?php endif; ?>
       
    </table>

    </div>
  </div>

    <div>
        <?php
        include "Footer.html";
        ?>
    </div>
</body>
</html>