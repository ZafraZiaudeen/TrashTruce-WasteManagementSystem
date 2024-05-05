<?php
include('../FO/team.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($_GET['id'])) {
        $teamId = $_GET['id'];

        Team::DeleteMember($teamId);

        if ($_SESSION['delete_team'] = true) {
            $_SESSION['delete_team'] = '<script>alert("Team Member Deleted Successfully");</script>';
            header("Location: Team.php");
        } else {
            $_SESSION['delete_team'] = '<script>alert("Failed to delete team member");</script>';
            header("Location: Team.php");
        }

        exit();
    }

    ?>

</body>

</html>