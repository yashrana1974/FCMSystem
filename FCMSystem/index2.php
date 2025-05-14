<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>File & Content Management System | Super Admin Login</title>

  <!-- Favicons -->
  <link href="dist/img/content-management.png" rel="icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div>
        <center>
          <img src="dist/img/content-management.png" alt="Logo" width="80" height="80">
        </center>
      </div>
      <div class="card-header text-center">
        <a href="#" class="h1"><b>FCMS</b><br /></b>Admin Portal</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Admin</p>

        <form action="splogindb.php" method="post">
          <div class="input-group mb-3">
            <input type="tel" class="form-control" name="spmobile" placeholder="Mobile No." maxlength="10" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="sppassword" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="signin" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <div>
              <span style="color:red">
                <?php
                $error = isset($_GET['error']) ? $_GET['error'] : '';
                if (!empty($error)) {
                  echo "Invalid User or Password !!";
                }
                ?>
              </span>
            </div>

            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dist/js/adminlte.min.js"></script>
</body>

</html>