<?php
  require('dist/core/controller.php');
  if (!empty($_COOKIE['id_akun_combi'])) {
    $sistem->masukByCookie($_COOKIE['id_akun_combi']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOMBI - KOMUNITAS BISNIS by REMOTEBISNIS</title>
  <link rel="shortcut icon" href="https://duniaundercover.files.wordpress.com/2023/02/4-1.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-warning">

    <div class="card-header text-center">
      <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px">
    </div>
    <div class="card-body">
      
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" maxlength="100">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
           
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="login" class="btn btn-warning btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
  
    <hr>
      
      <p class="mb-1 text-sm">
        <a href="<?php echo $onMy->primaryLocal ?>lupa_password">Saya Lupa Password</a>
      </p>
      <p class="mb-0 text-sm">
        <a href="<?php echo $onMy->primaryLocal ?>lp" class="text-center">Buat Sistemmu disini !</a>
      </p>
    
    </div>
    <!-- /.card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
