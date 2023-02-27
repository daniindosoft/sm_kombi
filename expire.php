<?php 
	error_reporting(0);
	include_once('dist/core/koneksi.php');

	function single($db, $sql){
		$a = new koneksi();
		$db = $a->hubungkan();
		$masuk=$db->prepare($sql);

		$masuk->execute();

		$data = $masuk->fetch();

		return $data;
	}

	$data = single($db, 'select * from mcdani where id =1');
	$user = single($db, 'select * from users where id ='.$_COOKIE['id_akun_combi']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOMBI | Opps Akun Anda sudah Expire nih</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//localhost/rebi/dist/css/adminlte.min.css">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper mt-5">
  <div class="lockscreen-logo">
    <img src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" style="width:120px">
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Akun Anda Telah Expire 😟</div>
	<hr>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Segera lakukan <b>perpanjangan</b> karena member komunitasmu menunggu
    <p>
    	<h5>Segera lakukan transfer senilai</h5>
    	<?php if ($user['last_package_picked'] == 1): ?>
	    	<h1 class="bg-warning">Rp<?php echo number_format($data['bulanan_paket1'],0,',','.'); ?><small style="font-size:22px">/bulan</small></h1>
    	<?php elseif($user['last_package_picked'] == 2): ?>
	    	<h1 class="bg-warning">Rp<?php echo number_format($data['bulanan_paket2'],0,',','.'); ?><small style="font-size:22px">/bulan</small></h1>
	    <?php elseif($user['last_package_picked'] == 3): ?>
	    	<h1 class="bg-warning">Rp<?php echo number_format($data['bulanan_paket3'],0,',','.'); ?><small style="font-size:22px">/bulan</small></h1>
    	<?php endif ?>
    </p>
    <b>ke salah satu </b>
    <hr style="border: 1px dashed black;">
	<div class="child-p">

		<p>
		<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/2560px-Bank_Syariah_Indonesia.svg.png" width="90px">
		<br>
		<b>DANI S</b><br>
		<span>(451) 9167 2788 80</span>
		</p> 
	</div>
	<hr>
	<div class="child-p">
		<p>
		<img alt="" src="https://upload.wikimedia.org/wikipedia/id/8/89/Jenius-logo.png" style="width:90px" />
		<br>
		<b>DANI S</b><br>
		<span>(213) 9019 0062 360</span>
		</p> 

		<br>
	</div>
	</div>
  <div class="text-center">
    <a href="<?php echo substr($data['nowa'], 1); ?>">Dan Hubungi Admin Disini (<?php echo $data['nowa'] ?>)</a>
  </div>
  <p class="text-center text-sm">NB : Jika ingin merubah paket silahkan hubungi Admin</p>
  <hr>
  <a href="/rebi/keluar">Keluar..</a>
  <hr>
  <div class="lockscreen-footer text-center">
    Copyright &copy; <?php echo date('Y') ?> <b><a href="https://remotebisnis.com" class="text-black">RemoteBisnis.com</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="//localhost/rebi/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="//localhost/rebi/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
