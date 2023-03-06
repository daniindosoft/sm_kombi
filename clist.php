<?php 
	error_reporting(0);
  include_once('env.php');

	include_once('dist/core/koneksi.php');
	include_once('dist/core/system.php');
  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

	function single($db, $sql, $type = 'single'){
		$a = new koneksi();
		$db = $a->hubungkan();
		$masuk=$db->prepare($sql);
		$data = null;
		$masuk->execute();
		if ($type = 'all') {
			$data = $masuk->fetchAll();
		}elseif($type == 'single'){
			$data = $masuk->fetch();
		} 

		return $data;
	}
	function convertDate($string, $date){
		$date = new DateTime($date);
    return $date->format($string);
	}

	function cw($expire){
		$now = time();
    $your_date = strtotime($expire);
    $datediff = $your_date - $now;

    return round($datediff / (60 * 60 * 24));
	}

	if (isset($_POST['submitUpdateMasaAktif'])) {
 		$userSingle = single('select * from users where id='.$_POST['id'], 'single');
 		if ($userSingle['status'] == '1') {
 			// info perpanjang
 			$konten = ' 
 				<h3>Perpanjangan Akun</h3>
 				<p>Masa aktif akun Anda telah diperpanjang selamat <b>'.$_POST['expireplus'].' Hari</b> kedepan, lebih jelasnya bisa lihat di memberarea.</p>
 				<hr>
		    <a href="https://kombi.remotebisnis.com/" style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login ke MemberArea</a>
 			';
	    $onMy->kirimEmail('','kombi@remotebisnis.com','Kombi RemoteBisnis',$userSingle['email'],'Masa Aktif Akun KOMBI Anda telah diperpanjang', $konten);
 		}else{
 			$konten = ' 
 				<h3>Selamat bergabung </h3>
 				<p>Anda kini telah bergabung di KOMBI, dan selamat membangun kolam uang, berikut akses untuk masuk ke memberarea KOMBI :</p>
 				<h4>Email : '.$userSingle['email'].'</h4>
 				<h4>Password : '.$userSingle['password'].'</h4>
 				<small><code>*</code>Demi keamanan, Mohon untuk mengubah password setelah Anda berhasil Login</small>
 				<hr>
		    <a href="https://kombi.remotebisnis.com/" style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login ke MemberArea</a>
 			';
	    $onMy->kirimEmail('','kombi@remotebisnis.com','Kombi RemoteBisnis',$userSingle['email'],'Selamat datang dan selamat bergabung di KOMBI', $konten);
 			// info aktivasi
 		}
		single(1, 'update users set `expire`="'.convertDate('Y-m-d H:i:s', $_POST['masa_aktif']).'", status=1 where id='.$_POST['id'], 'execute');
 
	}

	$data = single($db, 'select * from mcdani where id =1');
	$user = single($db, 'select * from users where id ='.$_COOKIE['id_akun_combi']);
	if ($_GET['pw'] == 'sijaplin') {
		// code...
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KOMBI | S</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo primaryLocal ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo primaryLocal ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="mt-5">
  <div class="lockscreen-logo">
    <a href="<?php echo primaryLocal ?>index2.html"><b>COM</b>BI</a>
    <?php echo convertDate('d F Y', date('Y-m-d')) ?>
  </div>
	<div>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>email</th>
					<th>Perpanjang</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach (single($db, 'select * from users where type_user="admin"', 'all') as $value): ?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td>
							<?php 
								echo $value['nama_lengkap'].'<br>';
								if ($value['status'] == 1) {
									echo "<h4 class='badge badge-warning'>AKTIF</h4	>";
								}else{
									echo "<h4 class='badge badge-danger'>BELUM AKTIF</h4>";
								}
							?>
						</td>
						<td><?php echo $value['email'] ?></td>
						<td>
							<?php 
								if (cw($value['expire']) <= 0) {
									echo '<span class="badge badge-danger">Expire</span><br>';
								}else{
									echo 'Masa Aktif HINGGA : '.convertDate('d M Y', $value['expire']);
									echo "<br>";
									echo '<b>'.cw($value['expire']).' Hari Lagi </b>';
								}
							?>
							<form action="" method="post" onsubmit="return confirm('Yakin memperbarui masa aktif')">
								<input type="hidden" name="id" value="<?php echo $value['id'] ?>">
								<label class="result<?php echo $no ?>"></label>
								<input type="hidden" value="" class="hresult<?php echo $no; ?>" name="expireplus">
								<input type="date" name="masa_aktif" class="waktu form-control" data-c="<?php echo $no ?>" value="<?php echo convertDate('Y-m-d', $value['expire']) ?>">
								<button name="submitUpdateMasaAktif" class="btn btn-sm btn-block btn-warning ">Update masa aktif/Aktifkan</button>
							</form>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>  
  <div class="lockscreen-footer text-center">
    Copyright &copy; <?php echo date('Y') ?> <b><a href="https://remotebisnis.com" class="text-black">RemoteBisnis.com</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="<?php echo primaryLocal ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo primaryLocal ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.waktu').change(function(){
			var datenow = ($(this).val());

			let date_1 = new Date(datenow);
			let date_2 = new Date();

			const days = (date_1, date_2) =>{
			    let difference = date_1.getTime() - date_2.getTime();
			    let TotalDays = Math.ceil(difference / (1000 * 3600 * 24));
			    return TotalDays;
			}
			
			$('.result'+$(this).attr('data-c')).text(days(date_1, date_2) +" +");
			$('.hresult'+$(this).attr('data-c')).val(days(date_1, date_2));
		});
	});
</script>
</body>
</html>
<?php } ?>