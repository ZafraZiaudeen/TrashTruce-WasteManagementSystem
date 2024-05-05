<?php 
include('../FO/team.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['staff_authenticated']) || $_SESSION['staff_authenticated'] !== true) {
    // Redirect to the login page or show an error message
    header("Location: login.php");
    exit();
}

// Retrieve Team from the database based on the search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search = $_GET['search'];
  $members = Team::SearchTeam($search); 
} else {
  $members = Team::GetTeamMems();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/View.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Team Members</title>
</head>
<body>
  <div>
    <?php include "Header.php"; ?>
  </div>
  <div class="main">
    <div class="colorbar">
      <h1>Team Members</h1>
    </div>
   
    <div class="intro">
      <table>
        <tr>
          <th>Serial No.</th>
          <th>Name</th>
          <th>Image</th>
          <th>Position</th>
          <th>Description</th>
        </tr>
        <?php if (count($members) > 0): ?>
          <?php foreach ($members as $index => $member): ?>
            <tr>
              <td><?php echo $index + 1; ?></td>
              <td><?php echo $member->name; ?></td>
              <td><img src="<?php echo $member->img; ?>" alt="Location Image" width="100px" height="100px"></td>
              <td><?php echo $member->position; ?></td>
              <td><?php echo $member->description; ?></td>
              
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">No Team Details Found.</td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
  </div>
  <div>
    <?php include "Footer.html"; ?>
  </div>
</body>
</html>
