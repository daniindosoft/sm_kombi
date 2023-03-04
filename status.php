<?php
  require('header.php');
  $data = $onMy->option();
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Status Akun</h1>
        </div><!-- /.col -->
        <div class="col-sm-12">
          <?php $onMy->callFlash() ?>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <!-- COLOR PALETTE -->
	    <div class="card card-default color-palette-box">
	      <div class="card-header">
	        <h3 class="card-title">
	          <i class="fa fa-user"></i>
	          Informasi
	        </h3>
	      </div>
	      <div class="card-body">
	      	<div class="text-center">
	      		<h4>Masa Aktif Hingga :</h5>
	      		<h2><span class="badge badge-danger"><?php $onMy->ago = true; echo $onMy->time_elapsed_string($profile['expire']); $onMy->ago = false; ?></span></h2>
	      		<?php 
	      			if ($hari >= -5){
	      		?>
	      		<i data-toggle="tooltip" data-placement="top" title="Segera lakukan perpanjangan paket sebelum masa aktif berakhir untuk menghindari akun di nonaktifkan" class="fa fa-info-circle"></i>
				    <p>
				    	<h5>dan transfer senilai</h5>
				    	<?php if ($profile['last_package_picked'] == 1): ?>
					    	<h1 class="bg-warning">Rp<?php echo number_format($data['bulanan_paket1'],0,',','.'); ?><small style="font-size:22px">/bulan</small></h1>
				    	<?php elseif($profile['last_package_picked'] == 2): ?>
					    	<h1 class="bg-warning">Rp<?php echo number_format($data['bulanan_paket2'],0,',','.'); ?><small style="font-size:22px">/3 bulan</small></h1>
					    <?php elseif($profile['last_package_picked'] == 3): ?>
					    	<h1 class="bg-warning">Rp<?php echo number_format($data['bulanan_paket3'],0,',','.'); ?><small style="font-size:22px">/1 Tahun</small></h1>
				    	<?php endif ?>
				    </p>
				    <b>ke</b>
				      <hr style="border: 1px dashed black;">
					<div class="">

						<p>
						<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/2560px-Bank_Syariah_Indonesia.svg.png" width="90px">
						<br>
						<b>(451) 9167 2788 80</b><br>
						<span>A.N Dani</span>
						</p> 
					</div>
					<hr>
					<div class="">
						<p>
						<img alt="" src="https://upload.wikimedia.org/wikipedia/id/8/89/Jenius-logo.png" style="width:90px" />
						<br>
						<b>(213) 9019 0062 360</b><br>
						<span>BTPN Jenius</span>
						</p> 
						
			      <hr style="border: 1px dashed black;">
	      		<p><b>Untuk Konfirmasi atau yang lainnya Hubungi admin di : </b></p>

	      		<a href="<?php echo $onMy->noWa($data['nowa']) ?>">Klik disini <?php echo $data['nowa'] ?></a>
					</div>
				<?php } ?>
	      	</div>
	      </div>
	    </div>
	  </div><!-- /.container-fluid -->
	</section>
</div>
<script type="text/javascript">
	document.title = "KOMBI | Halaman Pengajuan Komisi dari <?php echo $namaKomunitas ?>";
	    var menuaddclass = document.getElementById("bisnis");
  menuaddclass.classList.add("active");

      var menuaddclassx = document.getElementById("komisi");
  menuaddclassx.classList.add("active");

      var menuaddclass3 = document.getElementById("bisnis-open");
  menuaddclass3.classList.add("menu-open");

</script>
<?php
  require('footer.php');
?>