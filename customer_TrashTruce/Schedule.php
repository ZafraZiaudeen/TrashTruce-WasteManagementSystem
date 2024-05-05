<?php 
ob_start();
include_once('../FO/Schedule.php');
session_start();
include('customer assets/header.php');
if (!isset($_SESSION['customer_authenticated']) || $_SESSION['customer_authenticated'] !== true) {
    header("Location: login.php");
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Council Schedule Download Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/Schedule.css">
    <style>
        #clearInput {
            display: inline;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #wrapper {
            min-height: calc(100vh - 150px); /* Adjust 150px according to your footer height */
            position: relative;
        }

        .background-container {
            padding-bottom: 150px; /* Adjust according to your footer height */
        }

        #footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px; /* Adjust according to your footer height */
            background-color: #f0f0f0;
            padding: 20px;
            border-top: 1px solid #ccc;
        }
    </style>

</head>
<body>
<div id="wrapper">

    <div class="background-container">
    <header>
        <h1>Shedule</h1>
  </header>      
       
           
        <div class="search-container">
            <input id="searchInput" type="text" placeholder="Search...">
            <button id="searchButton" onclick="searchSchedules()"><i class=""></i>Search</button>
            <button id="clearInput" onclick="clearSearch()">Clear</button>
        </div>
        
        <div class="vertical-box" id="schedulesContainer">
        <div class="schedule-wrapper">
    <?php
    

    try {
        // Get schedules
        $schedules = Schedule::GetSchedules();

        // Check if there are any schedules
        if (!empty($schedules)) {
            // Loop through each schedule
            foreach ($schedules as $schedule) {
                // Display the schedule details
                echo '<div class="schedule-container">';
                echo '<strong>Document</strong>';
                echo '<p>Name: ' . $schedule->name . '</p>';
                echo '<p>' . $schedule->description . '</p>';
                echo '<button name="download" onclick="window.location.href=\'downloadSchedule.php?file=' . urlencode($schedule->file) . '\'"><i class="fas fa-download"></i> Download</button>';
                echo '</div>';
            }
        } else {
            // No schedules found
            echo '<p>No schedules available.</p>';
        }
    } catch (Exception $e) {
        // Handle exception
        echo '<p>Error: ' . $e->getMessage() . '</p>';
    }
    ?>
</div>

                
                
            </div>
        </div>
    </div>

    <script>
        function downloadSchedule(scheduleFileName) {
            alert('Downloading schedule: ' + scheduleFileName);
        }

        function searchSchedules() {
            filterSchedules();
        }

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            filterSchedules();
        }

        function filterSchedules() {
            var input, filter, schedulesContainer, schedules, scheduleContainer, roadName, scheduleName, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            schedulesContainer = document.getElementById('schedulesContainer');
            schedules = schedulesContainer.getElementsByClassName('schedule-container');

            for (i = 0; i < schedules.length; i++) {
                scheduleContainer = schedules[i];
                roadName = scheduleContainer.getElementsByTagName('p')[0];
                scheduleName = scheduleContainer.getElementsByTagName('p')[1];
                txtValue = roadName.textContent || roadName.innerText;
                txtValue += " " + (scheduleName.textContent || scheduleName.innerText);
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    scheduleContainer.style.display = "";
                } else {
                    scheduleContainer.style.display = "none";
                }
            }

        
            var clearButton = document.getElementById("clearInput");
            clearButton.style.display = "inline";
        }
    </script>
    <?php
include ('customer assets/footer.html');
?>
</body>
</html>