<?php
  error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  require('dist/core/controller.php');

  // $komunitas = $onMy->eksekusiShow('select * from komunitas_bisnis where code_komunitas='. $_GET['cd']);
  $produk = $onMy->eksekusiShow("select *,ap.id as idp from affiliate_produk as ap join users as u on u.id = ap.id_user where kode_affiliate_produk='".$_GET['cd']."'");

  $fields = (explode('{}', $produk['fields']));
  // $onMy->debug = true;
  $aff = $onMy->eksekusiShow('select * from users where kode_affiliate="'. $_GET['aff']. '"');
  
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOMBI | Order <?php echo $produk['judul'] ?></title>
  <link rel="shortcut icon" href="https://duniaundercover.files.wordpress.com/2023/02/4-1.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo $onMy->primaryLocal ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <?php echo base64_decode($produk['header']) ?>
  <style type="text/css">
    .input-group>.select2-container--default:not(:last-child) .select2-selection{
      height: auto !important;
      border-color: #ced4da;
    }
  </style>
</head>
<body class="hold-transition register-page">
<?php if (!empty($produk)){ ?>
<div class="register-box">
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <!-- <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px"> -->
    </div>
    <div class="card-body">
      <p class="login-box-msg pb-0">Form Order<br><b><?php echo $produk['judul'] ?></b></p>
      <p class="text-center">
        <!-- <a href="<?php echo $onMy->noWa($produk['nowa']) ?>">Hubungi Admin (<?php echo $produk['nowa'] ?>)</a> -->
        <small>Mohon isi dengan lengkap field-field berikut ini</small>
      </p>
      <hr>
      <form action="" method="post">
        
        <input type="hidden" name="nilai" value="<?php echo $produk['nilai'] ?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php $onMy->inputRedirect() ?>
          <input type="hidden" name="id_aff" value="<?php echo $aff['id'] ?>">
          <input type="hidden" name="cd" value="<?php echo $_GET['cd'] ?>">
          <input type="hidden" name="id_produk" value="<?php echo $produk['idp'] ?>">
          <input type="hidden" name="id_komunitas_bisnis" value="<?php echo $produk['id_komunitas_bisnis'] ?>">
          <input type="email" class="form-control email" onkeyup="return checkEmail()" placeholder="Email Aktif" name="email" required>
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
        <?php foreach ($fields as $field): ?>
          <?php if($field == 'alamat'): ?>
            <div class="input-group mb-3">
              <textarea class="form-control" name="alamat" placeholder="Alamat Lengkap"></textarea>
            </div>
          <?php elseif($field == 'domisili'): ?>
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
          <?php elseif($field == 'kode_pos'): ?>
            <div class="input-group mb-3">
              <input type="number" class="form-control" placeholder="Kode Pos" name="kode_pos" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa fa-map-pin"></span>
                </div>
              </div>
            </div>
          <?php elseif($field == 'jk'): ?>
            <div class="input-group mb-3">
              <select class="form-control" name="jk">
                <option value="L">L</option>
                <option value="P">P</option>
              </select>
            </div>
          <?php elseif($field == 'rentang_usia'): ?>
            <div class="input-group mb-3">
              <select class="form-control" name="rentang_usia">
                <option value="0">Rentang Usiamu</option>
                <option value="15-20">15-20</option>
                <option value="20-23">20-23</option>
                <option value="24-27">24-27</option>
                <option value="28-31">28-31</option>
                <option value="34-37">34-37</option>
                <option value="37-40">37-40</option>
                <option value="41-45">41-45</option>
                <option value=">45">>45</option>
              </select>
            </div>
          <?php elseif($field == 'catatan'): ?>
            <div class="input-group mb-3">
              <textarea class="form-control" name="catatan" name="catatan" placeholder="Catatan"></textarea>
            </div>
          <?php endif; ?>
        <?php endforeach ?>
        
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="submitOrderProduk" class="btn btn-warning btn-sm btn-block">Pesan Sekarang</button>
          </div>
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <small for="agreeTerms">
               <!-- By Registering, you agree to our <a href="#">Terms, Privacy Policy and Cookies Policy</a> -->
              </small>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>
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
<script src="<?php echo $onMy->primaryLocal ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $onMy->primaryLocal ?>dist/js/adminlte.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/select2/js/select2.full.min.js"></script>

<script type="text/javascript">
  function checkEmail(){  
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
