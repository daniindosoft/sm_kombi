<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOMBI | Terima kasih telah bergabung di KOMBI, Segera konfirmasi pembayaran ya</title>
  <link rel="shortcut icon" href="https://duniaundercover.files.wordpress.com/2023/02/4-1.png">

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
 
  $single = $onMy->eksekusiShow('select * from users where id='. $_GET['id']);
 

  $owner = $onMy->single('mcdani', 1);
?>
<div class="register-box">
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px">
    </div>
    <?php if (empty($_GET['free'])): ?>
      <div class="card-body">
        <p class="login-box-msg pb-0"><b>INVOICE : </b><br>
        	<small>
	          Mantap, Sekarang kamu sudah siap membangun kolam uang kan ?, 1 langkah lagi nih
			</small>
        </p>
        <div class="text-center">
          <p><u>Segera Transfer senilai </u> </p>
          <h4 class="text-warning"><b>Rp<?php echo $price = $onMy->nf($single['price_admin']) ?>  </b></h4>
                          ke salah satu rekening ini
        </div>
        <hr style="border: 1px dashed black;">
        <div class="child-p">
          
            <p>
							<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/2560px-Bank_Syariah_Indonesia.svg.png" width="90px">
              <br>
              <b>DANI S</b><br>
              <span>(451) 9167 2788 80</span>
            </p> 
	      </div>
	      <div class="child-p">
          
            <p>
							<img alt="" src="https://upload.wikimedia.org/wikipedia/id/8/89/Jenius-logo.png" style="width:90px" />
              <br>
              <b>DANI S</b><br>
              <span>(213) 9019 0062 360</span>
            </p> 
           
        <br>
	      </div>

        <p class="text-center">Hubungi admin di <br>
         
        <a href="<?php echo $onMy->noWa($owner['nowa']) ?>?text=Halo%20kak%2C%20saya%20sudah%20daftar%20COMBI%20dan%20ini%20E-Mail%20saya%20<?php echo $single['email'] ?>%0ATunggu%20transfer%20dari%20saya%20senilai%20%3A%0A%0A*Rp<?php echo $price ?>*%0A%0ATerima%20kasih.">Konfirmasi ke Admin (<?php echo $owner['nowa'] ?>)</a>	
         
        </p>
        <button class="btn btn-sm btn-warning btn-block"><i class="fa fa-download"></i> Unduh Invoice</button>
        <hr style="border: 1px dashed black;">
       
        <small><a href="<?php echo $onMy->primaryLocal ?>" class="text-center">Saya Sudah Punya Akun !</a></small>
         
        <hr>
      </div>
    <?php else: ?>
 
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
