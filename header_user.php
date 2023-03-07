<?php
  
  error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);
  // echo var_dump($_COOKIE);
  if (empty($_COOKIE['id_akun_combi'])) {
    header("Location: ".$onMy->primaryLocal);
  }else{
    if ( empty($_SESSION['bisnis_kategori_combi']) ) {
      $onMy->getKomunitasDefault($_COOKIE['id_akun_combi'], 'user');
    }
  }

  // cekal admin
  $onMy->adminDenied($_COOKIE['id_akun_combi']);

  require('dist/core/controller.php');

  $komunitas = $onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi']);
  $cekKom = $onMy->singleComunity($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi']);
  
  if ($cekKom['status'] == '0') {
    $onMy->removeSession();
  }
  // echo 'xx'.$_SESSION['bisnis_kategori_combi'];
  $profile = $onMy->thisProfile($_COOKIE['id_akun_combi']);
  if (empty($profile['nama_lengkap'])) {
    $onMy->removeCookies();
    header("Location: ".$onMy->primaryLocal);
  }
  if ($profile['dp']) {
    $myDp = $onMy->primaryLocal.'dist/img/avatar/'.$profile['dp'];
  }else{
    $myDp = 'https://duniaundercover.files.wordpress.com/2023/02/5-1.png';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?php echo $myDp ?>">

  <title>Login ke KOMBI | Solusi Membuat Kolam Uang</title>

  <meta property="og:locale" content="id_ID">
  <meta property="og:type" content="website">
  <meta property="og:title" content="LogIn KOMBI | Cari Komunitas Terbai dan Hasilkan Uang">
  <meta property="og:description" content="Gabung komunitas terbaik dan dapatkan cuan">
  <meta name="description" content="Gabung komunitas terbaik dan dapatkan cuan"/>
  <meta property="description" content="Gabung komunitas terbaik dan dapatkan cuan">
  <meta property="og:url" content="https://www.kombi.remotebisnis.com/">
  <meta property="og:image" name="og:image" content="<?php echo $myDp ?>">
  <meta property="og:site_name" content="Kombi.RemoteBisnis.com - Buat Kolam Uangmu Sekarang !">
  <meta name="keywords" content="komunitas bisnis, jualan online, digital marketing, list building, affiliate marketing, RemoteBisnis, seo, belajar jualan, jualan online, copywriting">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
    <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- select2 -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>daterangepicker/daterangepicker.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/summernote/summernote-bs4.min.css">
  <style type="text/css">
    .notif p{
      color: #727272
    }
    .loopRek div{
      padding-bottom: 15px;
    }
    .child-p2 p{
      font-size: 10px;
      line-height: 12px;
    }
    .child-p p{
      border: 1px solid #a5a5a5;
      text-align: center;
      padding: 3px;
      border-radius: 3px;
      background: #e9ecef;
    }
    .inner h4{
      font-weight: bold;
    }
    .img-circle{
      object-fit: cover;
      /*height: 100%;*/
    }
    .select2-selection.select2-selection--single{
      height: auto;
    }
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active{
      background: #d9a507 !important;
    }
    .flex-column > li.nav-item.active{
      background-color: #ededed;
    }
    .yellow-border{
      border: 1px solid #d9a507;
    }
    .yellow.active{
      background-color: #ffc107 !important;
    }
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
      /*background-color: #f7be15 !important;*/
    }
  </style>
  <?php 
    if ($komunitas['header']):
      echo $komunitas['header'];
    endif;
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="https://duniaundercover.files.wordpress.com/2023/02/4-1.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-sm-inline-block">
        <select class="form-control" onchange="javascript:handleSelect(this)">
          <?php foreach ($onMy->tampil_manual('select k.id_komunitas, kb.nama_komunitas from komunitas as k join users as u on k.id_user = u.id join komunitas_bisnis as kb on kb.id = k.id_komunitas where k.status=1 and k.id_user='.$_COOKIE['id_akun_combi']) as $value): ?>
            <option <?php if ($value['id_komunitas'] == $_SESSION['bisnis_kategori_combi']){ echo 'selected'; } ?> value="<?php echo $onMy->primaryLocal ?>switch/bisnis?id=<?php echo $value['id_komunitas'] ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>"><?php echo $value['nama_komunitas'] ?></option>
          <?php endforeach; ?>
        </select>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
       

      <?php
        // $onMy->debug = true;
        $showNotif = $onMy->selectNotif($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], 120);
        // echo $_COOKIE['id_akun_combi'];
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge"><?php echo (count($showNotif) <= 0 ) ? '' : count($showNotif) ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right overflow-auto" style="height: 350px;">
          <a href="<?php echo $onMy->primaryLocal ?>read_notifikasi?id_user=<?php echo $_COOKIE['id_akun_combi'] ?>&idkom=<?php echo $_SESSION['bisnis_kategori_combi'] ?>&type=<?php echo $profile['type_user'] ?>&url=<?php echo $onMy->thisUrl() ?>" class="dropdown-item text-sm">Bersihkan notifikasi</a>
          <p class="text-center"><?php echo (count($showNotif) <= 0 ) ? 'Tidak ada notifikasi' : '' ?></p>
          <?php 
            foreach ($showNotif as $notifAdmin): 
              $title = '<i class="fa fa-check-circle fa-sm text-primary"></i> '.$onMy->single('users', $notifAdmin['id_user'])['nama_lengkap'];
              $url = '#';
              $modal = '';
              if ($notifAdmin['type'] == 'post'): 
                $textn = '<p class="text-sm">Ada Postingan baru di komunitas, lihat sekarang.. </p>';
                $rightIcon = 'fa fa-file';
                $url = $onMy->primaryLocal.'/';
                $title = 'Postingan Baru Komunitas';


              elseif($notifAdmin['type'] == 'papan'): 
                $textn = '<p class="text-sm">Admin telah memperbarui <b>Papan Informasi</b>, cek dan ketahui sekarang</p>';
                $rightIcon = 'fa fa-sticky-note';
                $url = $onMy->primaryLocal.'user/papan_informasi';

              elseif($notifAdmin['type'] == 'faq'): 
                $textn = '<p class="text-sm">Admin telah memperbarui <b>FAQ</b>, cek dan pahami sekarang</p>';
                $rightIcon = 'fa fa-comments';
                $url = $onMy->primaryLocal.'user/faq';

              elseif($notifAdmin['type'] == 'rule'): 
                $textn = '<p class="text-sm">Admin telah memperbarui <b>Ketentuan/Rule</b>, silahkan pahami sekarang</p>';
                $rightIcon = 'fa fa-book';
                $url = $onMy->primaryLocal.'user/rule';

              elseif($notifAdmin['type'] == 'komunitas'):
                $textn = '<p class="text-sm">Admin telah memperbarui <b>Profile Komunitas</b></p>';
                $rightIcon = 'fa fa-users';
                $modal = 'data-toggle="modal" data-target="#modalInfoBisnis"';

              elseif($notifAdmin['type'] == 'post_comm'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-comment';

              elseif($notifAdmin['type'] == 'aff_join'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-user';
              elseif($notifAdmin['type'] == 'aff_app'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-user-check';
              elseif($notifAdmin['type'] == 'acc_post' || $notifAdmin['type'] == 'unacc_post'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-file';
              elseif($notifAdmin['type'] == 'dec_komisi' || $notifAdmin['type'] == 'acc_komisi' || $notifAdmin['type'] == 'add_komisi' || $notifAdmin['type'] == 'min_komisi'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-money-bill';
              elseif($notifAdmin['type'] == 'dsre_dec' || $notifAdmin['type'] == 'dsre_acc' || $notifAdmin['type'] == 'new_prod'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-cart-plus';
              elseif($notifAdmin['type'] == 'resi'):
                $title = $notifAdmin['title'];
                $textn = '<p class="text-sm">'.$notifAdmin['text']."</p>";
                $rightIcon = 'fa fa-barcode';
              endif;
            
          ?>
            <a href="<?php echo $url ?>" class="dropdown-item" <?php echo $modal ?>>
              <div class="media">
                <div class="media-body notif">
                  <h3 class="dropdown-item-title">
                    <b class="text-warning">
                      <?php echo $title; ?></b>
                    <span class="float-right text-sm"><i class="<?php echo $rightIcon ?>"></i></span>
                  </h3>
                  <?php echo $textn; ?>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo $onMy->time_elapsed_string($notifAdmin['created_at']) ?></p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
          <?php endforeach; ?>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
       
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="https://duniaundercover.files.wordpress.com/2023/02/5-1.png" style="border-radius:0px" class="brand-image img-circle" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>KOMBI</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $onMy->thisProfile($_COOKIE['id_akun_combi'])['dp'] ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $onMy->getNamaLengkap($_COOKIE['id_akun_combi']) ?></a>
        </div>
        <button data-toggle="modal" data-target="#modal-add-komunitas" type="button" class="btn btn-sm btn-warning" title="gabung komunitas lainnya"><i class="ion ion-ios-people"></i></button>
      </div>
 
      <!-- Sidebar Menu -->
      <?php require('menu_user.php'); ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>