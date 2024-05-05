<?php 
include_once('../FO/Recycle.php');
session_start();

include('customer assets/header.php');

// Retrieve accepted bins from the database
$acceptedBins = Recycle::GetBinsByCategory("Accepted");
// Retrieve not accepted bins from the database
$notAcceptedBins = Recycle::GetBinsByCategory("Not Accepted");
// Retrieve other materials bins from the database
$otherMaterialsBins = Recycle::GetBinsByCategory("Other Materials");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubbish Guide</title>
    <link rel="stylesheet" href="css/guild.css">

</head>
<body>
<header>
        <h1>RECYCLE GUIDE</h1>
  </header>
<?php
  $lastAddedGuide = Recycle::GetLastAddedGuide();
if ($lastAddedGuide) {
    echo '<div class="button-container">';
    echo '<h3>You can also download Our curbside Recyclling MYths guide to help word</h3>';
    echo '<a href="download.php?file=' . urlencode($lastAddedGuide->gfile) . '" download><button>Download Guide</button></a>';
    echo '</div>';
}
?>
    <main>
        <table>
            <tbody>
                <tr>
                    <td>
                        <section class="bin-accepted">
                            <h2>Bin Accepted</h2>
                            <p>Items that can be disposed of in the municipal bins:</p>
                            <ul>
                            <?php foreach ($acceptedBins as $bin): ?>
                                <li>
                                    <h3><?php echo $bin->bname; ?></h3>
                                    <p><?php echo $bin->bdesc; ?></p>
                                    <img src="<?php echo $bin->bimg; ?>" alt="<?php echo $bin->bname; ?>">
                                </li>
                            <?php endforeach; ?>
                                
                                
                            </ul>
                        </section>
                    </td>
                    <td>
                        <section class="bin-not-accepted">
                            <h2>Bin Not Accepted</h2>
                            <p>Items that should not be disposed of in the municipal bins:</p>
                            <ul>
                             <?php foreach ($notAcceptedBins as $bin): ?>
                            <li>
                                <h3><?php echo $bin->bname; ?></h3>
                                <p><?php echo $bin->bdesc; ?></p>
                                <img src="<?php echo $bin->bimg; ?>" alt="<?php echo $bin->bname; ?>">
                            </li>
                        <?php endforeach; ?>
                                
                            </ul>
                        </section>
                    </td>
                    <td>
                        <section class="other-materials">
                            <h2>Other Materials</h2>
                            <p>Materials that require special disposal methods:</p>
                            <ul>
                             <?php foreach ($otherMaterialsBins as $bin): ?>
                                <li>
                                    <h3><?php echo $bin->bname; ?></h3>
                                    <p><?php echo $bin->bdesc; ?></p>
                                    <img src="<?php echo $bin->bimg; ?>" alt="<?php echo $bin->bname; ?>">
                                </li>
                            <?php endforeach; ?>
                                
                            </ul>
                        </section>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

   
</body>
<header>
        <h1>City Council Recycling Process</h1>
    </header>
    <?php
    try {
            // Get recycling processes
            $processes = Recycle::GetProcesses();

            // Check if there are processes to display
            if (!empty($processes)) {
                // Display each process
                foreach ($processes as $process) {
                    
                    echo '<h2>' . $process->pname . '</h2>';
                    echo '<div class="video-container">';
                    echo '<p>' . $process->pdesc . '</p>';
                    echo '<video width="560" height="315" controls>';
                    echo '<source src="../processVideos/' . $process->pvid . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                    echo '</div>';
                    
                }
            } else {
                // Display a message if no processes are available
                echo '<p>No recycling processes found.</p>';
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    
    ?>
   


    <?php include('customer assets/footer.html'); ?>

</body>
</html>