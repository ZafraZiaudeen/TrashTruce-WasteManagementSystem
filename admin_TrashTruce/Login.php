<?php 
ob_start();
include('../FO/admin.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - Trash-Truce</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/Logo2.jpg" rel="icon">
  <link href="assets/img/Logo2.jpg" rel="apple-touch-icon">

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

  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/Untitled 1 (1).png" alt="logo">
                  <span class="d-none d-lg-block">Trash-Truce</span>

                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your Email & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your Email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="showPassword" value="true" id="showPassword">
                        <label class="form-check-label" for="showPassword">Show Password</label>
                    </div>
                </div>

                    <div class="col-12">
                    <input type="hidden" name="ID" value="<?php echo isset($user) ? $user->ID : ''; ?>">
                      <button class="btn btn-primary w-100" name="login" type="submit">Login</button>
                    </div>
                   
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!--  Main JS File -->
  <script src="assets/js/main.js"></script>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const showPasswordCheckbox = document.getElementById("showPassword");
        const passwordField = document.getElementById("yourPassword");

        showPasswordCheckbox.addEventListener("change", function () {
            const isChecked = this.checked;
            passwordField.type = isChecked ? "text" : "password";
        });
    });
</script>

</html>

<?php
if (isset($_POST['login'])) {
    // Retrieve form data
    $email = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check if email and password are provided
    if (!empty($email) && !empty($password)) {
        // Fetch admin by email
        $admin = admin::GetadminByEmail($email);

        if ($admin) {
            // Verify password
            if (password_verify($password, $admin->password)) {
                // Password is correct, set session variables and redirect
                $_SESSION['admin_id'] = $admin->ID;
                $_SESSION["admin_authenticated"] = true;
                $_SESSION['admin_email'] = $admin->email;
                
                // Redirect to dashboard or desired page
                header("Location: Dashboard.php");
                exit();
            } else {
                // Incorrect password
                echo '<script>alert("Incorrect password.");</script>';
            }
        } else {
            // Admin not found with the provided email
            echo '<script>alert("Admin not found with the provided email.");</script>';
        }
    } else {
        // Email or password is empty
        echo '<script>alert("Please enter both email and password.");</script>';
    }
}
ob_flush();
?>