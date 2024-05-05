<?php 
include('../FO/events.php');
session_start();
include('customer assets/header.php');

// Fetch events
$events = events::GetEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Council Special Events</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/event.css">
</head>
<body>
    
<header>
    <h1> Special Events</h1>
</header>

<div class="event-container">
    <?php foreach ($events as $event): ?>
    <div class="event">
        <img src="<?php echo $event->img; ?>" alt="Event">
        <h2><a class="event-title"><?php echo $event->name; ?></a></h2>
        <p><i class="far fa-calendar icon"></i><?php echo $event->date; ?></p>
        <p><i class="far fa-clock icon"></i><?php echo $event->time; ?></p>
        <p><i class="fas fa-map-marker-alt icon"></i><span><?php echo $event->loc; ?></span></p>
        <p><?php echo $event->desc; ?></p>
        <div class="join-button">
    <a href="joinform.php?event_id=<?php echo $event->ID; ?>"><button>Join</button></a>
</div>



    </div>
    <?php endforeach; ?>
</div>
<?php
include ('customer assets/footer.html');
?>
</body>
</html>