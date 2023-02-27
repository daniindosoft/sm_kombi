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
</head>
<body class="hold-transition register-page">
<?php
  error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  require('dist/core/controller.php');

 
?>
<div class="login-box">
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <?php echo $sistem->callFlash() ?>
      <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Lupa password ?, pulihkan passwordmu disini</p>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Masukan Email Anda" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="requestNewPassword" class="btn btn-warning btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="<?php echo $onMy->https.$onMy->primaryLocal ?>">Login Klik disini !</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
 
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


    $('.email').onKeyUp(function(){
      alert()
    });
  });

</script>
</body>
</html>
