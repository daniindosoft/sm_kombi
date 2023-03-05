<?php
  error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

    require('dist/core/controller.php');
  // ?cd=23&user=22
    if (empty($_GET['type'])){
      $single = $onMy->eksekusiShow('select * from komunitas_bisnis where code_komunitas='. $_GET['cd']);
      $kom = $single['header_invoice'];
      $userPrice = $onMy->single('users',$_GET['user'])['price_join'];
      $noAdminKomunitas = $single['nowa'];
    }else{
      $single = $onMy->selectSingleOne('affiliate_produk', 'kode_affiliate_produk', $_GET['cd']);
      $k = $onMy->eksekusiShow('select * from komunitas_bisnis where id='. $single['id_komunitas_bisnis']);
      $kom = $k['header_invoice'];

      $u = $onMy->selectSingleOne('order_produk', 'id', $_GET['user']);
      $userPrice = $u['harga'];
      $produk = $onMy->selectSingleOne('affiliate_produk', 'id', $u['id_produk']);
      $noAdminKomunitas = $k['nowa'];
      // echo var_dump($k);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="https://duniaundercover.files.wordpress.com/2023/02/4-1.png">
  
  <title>KOMBI | Invoice </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//localhost/rebi/dist/css/adminlte.min.css">
  <style type="text/css">
    .child-p p{
      border: 1px solid #a5a5a5;
      text-align: center;
      padding: 3px;
      border-radius: 3px;
      background: #e9ecef;
    }
  </style>
  <?php
    if (!empty($kom)) {
      echo $kom;
    }
  ?>
</head>
<body class="hold-transition register-page">
<?php

  $owner = $onMy->single('users', $_GET['owner']);
?>
<div class="register-box">
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px">
    </div>

    <?php 
      // echo $userPrice;
      if ($_GET['nilai'] == 'berbayar' && $userPrice > 0 ): 
    ?>
      <?php if (empty($_GET['free'])): ?>
        <div class="card-body">
          <p class="login-box-msg pb-0"><b>INVOICE : <br>
            Terima kasih 
            <?php if (empty($_GET['type'])): ?>
              Telah bergabung di 
              <span class="text-warning"><?php echo $single['nama_komunitas'] ?></span></b>
            <?php else: ?>
              Telah memesan <span class="text-warning"><?php echo $single['judul'] ?></span></b>
            <?php endif ?>
          </p>
          <div class="text-center">
            <?php if (empty($_GET['type'])): ?>
              <p><u>Segera Lakukan Pembayaran Senilai</u> </p>
            <?php else: ?>
              <p><u>Total pesanan</u> </p>
              <?php if ($_GET['typeProduk'] == 'fisik'): ?>
                <p>Segera konfirmasi ke Admin(dibawah) untuk menyanyakan ongkirnya</p>
              <?php endif ?>
              <hr>
              <b>Total Harga</b>
            <?php endif ?>
            <h4 class="text-warning"><b>Rp<?php echo $price = str_replace(",", ".", number_format($userPrice)) ?>  </b></h4>
            <?php if ($_GET['typeProduk'] != 'fisik'): ?>
              Transfer ke salah satu rekening ini
            <?php else: ?>
              Metode Pembayaran
            <?php endif; ?>
          </div>
          <hr style="border: 1px dashed black;">
          <div class="child-p">
            <?php foreach ($onMy->select('norek',$_GET['owner']) as $key => $value): ?>
              <p>
                <b><?php echo $value['nama_bank'] ?></b><br>
                <b><?php echo $value['nama_pemilik'] ?></b><br>
                <span> <?php echo ( !empty($value['kode_bank']) ) ? '('.$value['kode_bank'].')' : '' ?> <?php echo $value['norek'] ?></span>
              </p>
            <?php endforeach ?>
            <?php if (empty($_GET['type']) && !empty($owner['note_after_invoice'])): ?>
              <!-- <div>
                <b>Note</b><br>
                <small><i>$owner['note_after_invoice'] ?></i></small>
                <hr>
              </div> -->
            <?php endif ?>
          </div>
          <div class="text-center m-auto">       
            <?php foreach (explode(',', $onMy->selectSingleOne('users', 'id', $_GET['owner'])['logo_bank']) as $bank): ?>
              <?php if ($bank != 'x'): ?>
                <img src="<?php echo $bank ?>" width="40">
              <?php endif ?>
            <?php endforeach ?>
          </div>
          <br>

          <p class="text-center">Hubungi admin untuk <br>
            <?php if (empty($_GET['type'])): ?>
              <a href="<?php echo $onMy->noWa($noAdminKomunitas) ?>?text=<?php echo urlencode( str_replace('{rp}', 'Rp'.$price, $single['wa_template']) ) ?>">Konfirmasi Pembayaran di sini (<?php echo $noAdminKomunitas ?>)</a>
            <?php else: ?>
              <a href="<?php echo $onMy->noWa($noAdminKomunitas) ?>">Konfirmasi ke Admin (<?php echo $noAdminKomunitas ?>)</a>
            <?php endif; ?>
          </p>
          <button class="btn btn-sm btn-warning btn-block"><i class="fa fa-download"></i> Unduh Invoice</button>
          <p>
            <small><code>*</code> Screenshot atau unduh invoice untuk menyimpan bukti</small>
          </p>
          <hr style="border: 1px dashed black;">
          <?php
          if (empty($_GET['type'])){
          ?>
          <small><a href="<?php echo $onMy->primaryLocal ?>" class="text-center">Saya Sudah Punya Akun !</a></small>
          <?php } ?>
          <hr>
        </div>
      <?php else: ?>
        <div class="card-body">
          <p class="login-box-msg pb-0"><b>Terima Kasih Telah Bergabung di <br><span class="text-warning"><?php echo $single['nama_komunitas'] ?></span></b>, Mohon periksa Email dan Anda akan segera mendapatkan Akses ke MemberArea</p>
          <br>
          <p class="text-center"><a href="<?php echo $noAdminKomunitas ?>">Konfirmasi ke Admin (<?php echo $noAdminKomunitas ?>)</a></p>
          <hr style="border: 1px dashed black;">
          <small><a href="<?php echo $onMy->primaryLocal ?>" class="text-center">Saya Sudah Punya Akun !</a></small>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <div class="card-body">
        <p class="login-box-msg pb-0"><b>Terima Kasih Telah Order<br></b>Cek E-Mail ya, Anda mendapatkan <b><?php echo $produk['judul'] ?></b> secara gratis nih !, selamat 😃</p>
        <br>
        <p class="text-center"><a href="<?php echo $noAdminKomunitas ?>">Ini Kontak Admin (<?php echo $noAdminKomunitas ?>)</a></p>
        <hr style="border: 1px dashed black;">
        <small><a href="<?php echo $onMy->primaryLocal ?>" class="text-center">Login !</a></small>
      </div>
    <?php endif; ?>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>

<!-- jQuery -->
<script src="//localhost/rebi/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="//localhost/rebi/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="//localhost/rebi/dist/js/adminlte.min.js"></script>

<script type="text/javascript">
  $(function () {
    

    $('button').click(function(){
      window.print()
    });
  });
</script>
</body>
</html>
