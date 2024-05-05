<?php 
ob_start();
include_once('../FO/admin.php');
session_start();

$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : null;
// Check if the user is authenticated
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
  <h1>Profile</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Users</li>
      <li class="breadcrumb-item active">Profile</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
<?php
        $adminID = 1; 

try {
    // Get the admin object by ID
    $admin = admin::GetAdmin($adminID);

    // Check if admin exists
    if ($admin) {
        // Retrieve the image and name
        $adminImage = $admin->image;
        $adminName = $admin->fullname;

        // Output the image and name
        echo '<img src="' . $adminImage . '" alt="Admin Profile Image">';
        echo '<h2>' . $adminName . '</h2>';
    } else {
        echo 'Admin not found.';
    }
} catch (Exception $e) {
    // Handle any exceptions that may occur
    echo 'Error: ' . $e->getMessage();
}
?>
          <h3>Admin</h3>
          
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
            </li>

          </ul>
          <?php
                // Fetch admin details
                $adminID = 1; 
                $admin = admin::Getadmin($adminID);

                // Check if admin exists
                if ($admin) {
   
    ?>
    <div class="tab-content pt-2">
        <div class="tab-pane fade show active profile-overview" id="profile-overview">
            <h5 class="card-title">About</h5>
            <p class="small fst-italic"><?php echo $admin->about; ?></p>

            <h5 class="card-title">Profile Details</h5>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Full Name</div>
                <div class="col-lg-9 col-md-8"><?php echo $admin->fullname; ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Job</div>
                <div class="col-lg-9 col-md-8"><?php echo $admin->job; ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Address</div>
                <div class="col-lg-9 col-md-8"><?php echo $admin->address; ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Phone</div>
                <div class="col-lg-9 col-md-8"><?php echo $admin->phone; ?></div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?php echo $admin->email; ?></div>
            </div>
        </div>
    
    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
    <?php
} else {
    // Admin not found
    echo "Admin details not found.";
}
?>



              <!-- Profile Edit Form -->
              <form action="" method="post" enctype="multipart/form-data">
              <div class="row mb-3">
    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
    <div class="col-md-8 col-lg-9">
        <img src="<?php echo $admin->image; ?>" alt="Profile" id="profilePreview">
        <div class="pt-2">
            <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" id="uploadProfileImage"><i class="bi bi-upload"></i></a>
            <input type="file" id="profileImageInput" name="profileImage" style="display: none;">
            <input type="hidden" id="removeProfileImage" name="removeProfileImage" value="0"> <!-- Hidden field to indicate deletion -->
            <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image" id="deleteProfileImage"><i class="bi bi-trash"></i></a>
        </div>
    </div>
</div>


                <div class="row mb-3">
                  <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $admin->fullname; ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="about" class="form-control" id="about" style="height: 100px"><?php echo $admin->about; ?></textarea>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="job" type="text" class="form-control" id="Job" value="<?php echo $admin->job; ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="address" type="text" class="form-control" id="Address" value="<?php echo $admin->address; ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $admin->phone; ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control" id="Email" value="<?php echo $admin->email; ?>">
                  </div>
                </div>

                <div class="text-center">
              <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
          </div>
              </form><!-- End Profile Edit Form -->

            </div>

            
            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form action="" method="post">

             <div class="row mb-3">
            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="password" type="password" class="form-control" id="currentPassword">
            </div>
        </div>

        <div class="row mb-3">
            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="newpassword" type="password" class="form-control" id="newPassword">
            </div>
        </div>

        <div class="row mb-3">
            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="renewpassword" type="password" class="form-control" id="renewPassword">
            </div>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="showPassword" value="true" id="showPassword">
                <label class="form-check-label" for="showPassword">View Password</label>
            </div>
        </div>


                <div class="text-center">
                <input type="hidden" name="user_id" value="<?php echo isset($admin) ? $admin->ID : ''; ?>">

                  <button type="submit" class="btn btn-primary" name="changePassword">Change Password</button>
                </div>

               
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

    <div>
        <?php
        include "Footer.html";
        ?>
    </div>
    <script>
   document.getElementById('uploadProfileImage').addEventListener('click', function() {
    document.getElementById('profileImageInput').click();
});

document.getElementById('profileImageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('profilePreview').src = e.target.result;
    };

    reader.readAsDataURL(file);
});

    document.addEventListener("DOMContentLoaded", function () {
        const showPasswordCheckbox = document.getElementById("showPassword");
        const passwordFields = document.querySelectorAll('input[type="password"]');

        showPasswordCheckbox.addEventListener("change", function () {
            const isChecked = this.checked;
            passwordFields.forEach(function (field) {
                field.type = isChecked ? "text" : "password";
            });
        });
    });
    document.getElementById('deleteProfileImage').addEventListener('click', function(event) {
    event.preventDefault();
    
    // Confirm with the user
    if (confirm("Are you sure you want to delete your profile image?")) {
        // Set the value of the hidden input field to 1 to indicate removal
        document.getElementById('removeProfileImage').value = 1;
        // Remove the profile image preview
        document.getElementById('profilePreview').src = ''; 
    }
});
</script>

</body>
</html>
<?php
// Check if form is submitted for updating profile
if (isset($_POST['update'])) {
    $adminID = 1; 
    // Fetch admin object from database
    $admin = admin::GetAdmin($adminID);
    // Update profile information
    $admin->fullname = $_POST['fullName'];
    $admin->about = $_POST['about'];
    $admin->job = $_POST['job'];
    $admin->address = $_POST['address'];
    $admin->phone = $_POST['phone'];
    $admin->email = $_POST['email'];


    // Check if a new profile image is uploaded
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['size'] > 0) {
      $uploadDir = '../admin_img/'; // Directory where images will be uploaded
      $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);
      if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
          $admin->image = $uploadFile;
      } else {
          echo "Failed to upload image.";
      }
  } elseif (isset($_POST['removeProfileImage']) && $_POST['removeProfileImage'] == 1) {
      // Delete existing profile image
      unlink($admin->image); // Remove file from server
      $admin->image = ''; // Clear image path in database or set to default
  }
    // Update the admin's information in the database
    $admin->UpdateAdmin(); // Update other admin information
    $admin->UpdateImage(); // Update admin image
    header('Location: Profile.php');
    exit(); // Terminate script execution
}

    if (isset($_POST['changePassword'])) {
        $adminID = 1; 
        $admin = admin::GetAdmin($adminID);
        
        // Retrieve form data
        $userId = isset($_POST["user_id"]) ? $_POST["user_id"] : null;
        $currentPassword = isset($_POST["password"]) ? $_POST["password"] : '';
        $newPassword = isset($_POST["newpassword"]) ? $_POST["newpassword"] : '';
        $renewPassword = isset($_POST["renewpassword"]) ? $_POST["renewpassword"] : '';
        
        // Validate input fields
        if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
            echo '<script>alert("All fields are required" );</script>';
        } elseif (!password_verify($currentPassword, $admin->password)) {
            echo '<script>alert("Incorrect current password" );</script>';
        } elseif ($newPassword !== $renewPassword) {
            echo '<script>alert("New password and re-entered password do not match" );</script>';
        } else {
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $adminToUpdate = new admin();
            $adminToUpdate->ID = $adminID;
            $adminToUpdate->password = $hashedPassword;

            $adminToUpdate->UpdatePassword();
            echo '<script>alert("Password updated successfully" );</script>';
            header("Location: Profile.php");
            exit();
        }
    }
    ob_flush();
?>

