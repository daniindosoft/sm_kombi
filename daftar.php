<?php
  error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  require('dist/core/controller.php');

  $single = $onMy->eksekusiShow('select * from komunitas_bisnis where code_komunitas='. $_GET['cd']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOMBI | Daftar Komunitas sekarang</title>
  <link rel="shortcut icon" href="https://duniaundercover.files.wordpress.com/2023/02/4-1.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//localhost/rebi/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="//localhost/rebi/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="//localhost/rebi/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <style type="text/css">
    .input-group>.select2-container--default:not(:last-child) .select2-selection{
      height: auto !important;
      border-color: #ced4da;
    }
  </style>
  <?php
    if (!empty($single['id'])) {
      echo $single['header_form'];
    }
  ?>
</head>
<body class="hold-transition register-page">
<?php

  if (!empty($single['id'])) {
  // if (1==1) {
?>
<div class="register-box">
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px">
    </div>
    <div class="card-body">
      <?php $sistem->callFlash(); ?>
      <p class="login-box-msg pb-0">Registrasi Member Baru <br><b><?php echo $single['nama_komunitas'] ?></b></p>
      <hr>
      <!-- <p class="text-center"><a href="<?php echo $single['nowa'] ?>">Admin (<?php echo $single['nowa'] ?>)</a></p> -->
      <form action="" method="post">
        <?php $onMy->inputRedirectFull() ?>
        <input type="hidden" name="cd" value="<?php echo $_GET['cd'] ?>">
        <input type="hidden" name="aff" value="<?php echo @$_GET['aff'] ?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama_lengkap" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control email" onkeyup="return checkEmail()" placeholder="Email Aktif" name="email" required value="@gmail.com">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="number" class="form-control" name="nowa" placeholder="No Whatsapp/Kontak" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" id="select2" name="domisili" required>
            <option>Domisili/Kota</option>
            <?php foreach ($onMy->selectNormal('domisili') as $value): ?>
              <option value="<?php echo $value['nama'] ?>"><?php echo $value['nama'] ?></option>
            <?php endforeach ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marker"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" name="tahu" required>
            <option value="0">Tahu kami dari mana ?</option>
            <?php foreach ($onMy->selectNormal('tahu') as $value): ?>
              <option value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
            <?php endforeach ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-users"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="submitDaftar" class="btn btn-warning btn-sm btn-block">Daftar</button>
          </div>
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <small for="agreeTerms">
               By Registering, you agree to our <a href="#">Terms, Privacy Policy and Cookies Policy</a>
              </small>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <hr>
      <small><a href="<?php echo $onMy->primaryLocal; ?>" class="text-center">Saya Sudah Punya Akun !</a></small>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<?php }else{ ?>
  <div class="mt-4 text-center">
    <h2 class="headline text-warning text-center"> <i class="fas fa-exclamation-triangle text-warning"></i> 400 Bad Request Error</h2>
  </div>
  <div class="alert alert-warning alert-dismissible">
    <h5><i class="icon fas fa-ban"></i> Link Tidak Valid</h5>
    Link yang Anda buka bermasalah, silahkan gunakan link yang benar !
  </div>
<?php } ?>
<!-- /.register-box -->
 
<!-- jQuery -->
<script src="//localhost/rebi/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="//localhost/rebi/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="//localhost/rebi/dist/js/adminlte.min.js"></script>
<script src="//localhost/rebi/plugins/select2/js/select2.full.min.js"></script>

<script type="text/javascript">
  function checkEmail(){
  
    $('#toastsContainerTopRight').remove();
    $('button').show();
    $.ajax({
      type: 'POST',
      url: "//localhost/rebi/ajax/post",
      data: {
        "ajaxType":'checkEmail',
        "text":$(".email").val()
      },
      success: function(a) {
        if(a){
          $('button').hide();
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Email sudah terdaftar',
            subtitle: 'Info',
            body: a,
          });
        }
      }
    });
  }
  $(function () {
    $('#select2').select2();
      
  });

</script>
<?php $sistem->removeFlash() ?>
</body>
</html>
