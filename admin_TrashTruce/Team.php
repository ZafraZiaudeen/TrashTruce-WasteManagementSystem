<?php 
include('../FO/team.php');
session_start();
$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
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
<?php
if (isset($_SESSION['add_team']) && !empty($_SESSION['add_team'])) {
    echo $_SESSION['add_team'];
    unset($_SESSION['add_team']);
}
if (isset($_SESSION['delete_team']) && !empty($_SESSION['delete_team'])) {
  echo $_SESSION['delete_team'];
  unset($_SESSION['delete_team']);
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
    <div class="btnAll">
      <div class="btnAllDlt">
        <button class="btn10"><a href="addTeam.php">Add Team</a></button>
      </div>
    </div>
    <div class="intro">
      <table>
        <tr>
          <th>Serial No.</th>
          <th>Name</th>
          <th>Image</th>
          <th>Position</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
        <?php if (count($members) > 0): ?>
          <?php foreach ($members as $index => $member): ?>
            <tr>
              <td><?php echo $index + 1; ?></td>
              <td><?php echo $member->name; ?></td>
              <td><img src="<?php echo $member->img; ?>" alt="Location Image" width="100px" height="100px"></td>
              <td><?php echo $member->position; ?></td>
              <td><?php echo $member->description; ?></td>
              <td>
                <a href="DeleteTeam.php?id=<?php echo $member->ID; ?>" onclick="return confirm('Are you sure you want to delete this team member?');">
                  <span class="material-symbols-outlined">delete</span>
                </a>
                <a href="EditTeam.php?id=<?php echo $member->ID; ?>">
                  <span class="material-symbols-outlined">edit</span>
                </a>
              </td>
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
