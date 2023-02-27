<?php
	error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);


  $value = $onMy->selectSingleOne('post', 'id', $_GET['id']);

  $judul = $onMy->selectSingleOne('komunitas_bisnis', 'id', $value['id_komunitas_bisnis'])['nama_komunitas'];
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COMBI</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//localhost/rebi/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="//localhost/rebi/index3.html" class="navbar-brand">
        <img src="https://duniaundercover.files.wordpress.com/2023/01/ss.png" alt="Combi Logo" style="opacity: .8; width: 50px">
        <span class="brand-text font-weight-light font-weight-bold	">COMBI</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo $onMy->primaryLocal ?>" class="nav-link"><?php echo ( empty($_COOKIE['id_akun_combi']) ) ? 'Login' : 'Home'; ?></a>
          </li>
          <?php if (empty($_COOKIE['id_akun_combi'])): ?>
	          <li class="nav-item dropdown">
	            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Daftar</a>
	            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
	              <li><a href="#" class="dropdown-item">Member </a></li>
	              <li><a href="#" class="dropdown-item">Admin</a></li>
	            </ul>
	          </li>
          <?php endif ?>
        </ul>
      </div>

      	
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> <?php echo $judul ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Share</a></li>
              <li class="breadcrumb-item active">Post</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <?php 
	        $no=1; 
	          $postBy = $onMy->thisProfile($value['id_user']);
	      ?>
	        <div class="card card-widget yellow-border">
	          <div class="card-header">
	            <div class="user-block">
	              <img class="img-circle" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $postBy['dp'] ?>" alt="User Image">
	              <span class="username"><a href="<?php echo $onMy->primaryLocal ?>user/profile?id=<?php echo $value['id_user'] ?>">
	              <?php 
	                if ($postBy['type_user'] == 'admin') {
	                  echo '<i class="far fa-check-circle fa-sm text-primary" title="Admin"></i> ';
	                }
	                if ($postBy['id'] == $_COOKIE['id_akun_combi']) {
	                  echo 'Anda';
	                }else{
	                  echo '<span class="text-dark">'.$postBy['nama_lengkap']."</span>";
	                }
	              ?>
	              </a></span>
	              <span class="description">
	                <?php echo $value['judul'] ?> - 
	                <?php 
	                  echo $onMy->convertDate('d F Y - H:i', $value['created_at']);
	                ?>
	              </span>
	            </div>
	            <!-- /.user-block -->
	            <div class="card-tools">
	              <button type="button" class="btn btn-tool" data-card-widget="collapse">
	                <i class="fas fa-minus"></i>
	              </button>
	            </div>
	            <!-- /.card-tools -->
	          </div>
	          <!-- /.card-header -->
	          <div class="card-body">
	            <?php echo $value['text'] ?>
	            <hr>
	            
	            <span class="float-right text-muted"><?php echo $value['jumlah_like'] ?> likes - <?php echo $value['jumlah_komen'] ?> comments</span>
	          </div>
	          
	            <div class="card-footer card-comments">
	              <?php foreach ($onMy->getKomentarByPost($value['id'], 10) as $val): ?>
	                <!-- 'select * from komentar as k join users as u on k.id_user = u.id where k.id_post="'.$value['id'].'" limit 10' -->
	                <div class="card-comment">
	                  <img class="img-circle img-sm" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $onMy->thisProfile($val['id_user'])['dp'] ?>" alt="User Image">
	                  <div class="comment-text">
	                    <span class="username">
                        <?php echo $val['nama_lengkap'] ?>
	                      <span class="text-muted float-right"><?php echo $onMy->convertDate('d F Y - H:i', $val['created_at']); ?></span>
	                    </span><!-- /.username -->
	                    <?php echo $onMy->extractComment($val['komentar']) ?><br>
	                  </div>
	                  <!-- /.comment-text -->
	                </div>
	              <?php endforeach ?>
	              <!-- /.card-comment -->
	            </div>
	            <!-- /.card-footer -->
	            <div class="card-footer">
	              <?php if ($value['jumlah_komen'] > 10): ?>
	                <a href=""><i class="fa fa-comment"></i> Komentar lainnya...</a>
	                <br>
	                <br>
	              <?php endif ?>
	              <code>*</code><small>Ingin ikut diskusi di komunitas ini ?, <a href="">Join sekarang ! </a></small>
	            </div>
	          
	          <!-- /.card-footer -->
	        </div>
 
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="//localhost/rebi/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="//localhost/rebi/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="//localhost/rebi/dist/js/adminlte.min.js"></script>
</body>
</html>
