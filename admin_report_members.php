<?php
	require "header.php";
	// $onMy->debug = true;
	$jk = $onMy->tampil_manual('SELECT jk, count(u.id) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas='.$_SESSION['bisnis_kategori_combi'].' GROUP by u.jk');
	$l = $jk[0]['jk'];
	$lv = $jk[0]['total'];
	$thisjk = true;
	$p = $jk[1]['jk'];
	$pv = $jk[1]['total'];

	// echo var_dump($jk[1]['jk']); die;

	$tablet = $onMy->eksekusiShow("SELECT count(u.id) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and u.perangkat like '%Tablet%';")['total'];

	$desktop = $onMy->eksekusiShow("SELECT count(u.id) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and u.perangkat like '%Desktop%'")['total'];
	
	$ios = $onMy->eksekusiShow("SELECT count(u.id) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and u.perangkat like '%IOS%'")['total'];
	
	$android = $onMy->eksekusiShow("SELECT count(u.id) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and u.perangkat like '%ANDROID%'")['total'];
	
	$mobile = $onMy->eksekusiShow("SELECT count(u.id) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and u.perangkat like '%Mobile%'")['total'];
 
 	$totalPerangkat = $tablet+$desktop+$ios+$android+$mobile;


 	$usia = $onMy->tampil_manual("SELECT DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), u.tgl_lahir)), '%Y') + 0 AS age, count(*) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and tgl_lahir is not null GROUP by age");

 	$totalMember = $onMy->eksekusiShow("SELECT count(*) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." and tgl_lahir is not null")['total'];

 	$totalDomisili = $onMy->eksekusiShow("SELECT domisili, count(*) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']."")['total'];

 	$domisili = $onMy->tampil_manual("SELECT domisili, count(*) as total FROM `komunitas` as k join users as u on u.id = k.id_user WHERE k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." GROUP by u.domisili");

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Demografi  </h1>
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
			<div class="row">
				<section class="col-lg-12">
          <div class="card card-outline card-warning">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Grafik Komunitas</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            
              <div class="row">
                <div class="col-md-6">
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">Jenis Kelamin</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">Usia</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <table class="table table-bordered">
			                  <thead>
			                    <tr>
			                      <th style="width: 10px">#</th>
			                      <th>Usia</th>
			                      <th>Persentase</th>
			                      <th style="width: 40px">Jumlah</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                  	<?php $no=1; foreach ($usia as $age): ?>
				                  	<tr>
				                  		<td><?php echo $no++ ?></td>
				                  		<td><?php echo $age['age'] ?></td>
				                  		<td>
				                        <div class="progress progress-lg">
				                          <div class="progress-bar progress-bar-danger" style="width: <?php echo $x=$onMy->cal_percentage($age['total'], $totalMember) ?>%"><?php echo $x ?>%</div>
				                        </div>
				                      </td>
				                  		<td><?php echo $age['total'] ?></td>
				                  	</tr>
			                  	<?php endforeach ?>
			                  </tbody>
			                </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">Perangkat</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                    	<table class="table table-bordered">
			                  <thead>
			                    <tr>
			                      <th style="width: 10px">#</th>
			                      <th>Perangkat/Platform</th>
			                      <th>Persentase</th>
			                      <th style="width: 40px">Jumlah</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    <tr>
			                      <td>1.</td>
			                      <td>Tablet</td>
			                      <td>
			                        <div class="progress progress-lg">
			                          <div class="progress-bar bg-warning" style="width: <?php echo $x=$onMy->cal_percentage($tablet, $totalPerangkat) ?>%"><?php echo $x ?>%</div>
			                        </div>
			                      </td>
			                      <td><span class="badge bg-warning"><?php echo $tablet ?></span></td>
			                    </tr>
			                    <tr>
			                      <td>2.</td>
			                      <td>Desktop</td>
			                      <td>
			                        <div class="progress progress-lg">
			                          <div class="progress-bar bg-warning" style="width: <?php echo $x=$onMy->cal_percentage($desktop, $totalPerangkat) ?>%"><?php echo $x ?>%</div>
			                        </div>
			                      </td>
			                      <td><span class="badge bg-warning"><?php echo $desktop ?></span></td>
			                    </tr>
			                    <tr>
			                      <td>3.</td>
			                      <td>IOS OS</td>
			                      <td>
			                        <div class="progress progress-lg progress-striped active">
			                          <div class="progress-bar bg-warning" style="width: <?php echo $x=$onMy->cal_percentage($ios, $totalPerangkat) ?>%"><?php echo $x ?>%</div>
			                        </div>
			                      </td>
			                      <td><span class="badge bg-warning"><?php echo $ios ?></span></td>
			                    </tr>
			                    <tr>
			                      <td>4.</td>
			                      <td>ANDROID OS</td>
			                      <td>
			                        <div class="progress progress-lg progress-striped active">
			                          <div class="progress-bar bg-warning" style="width: <?php echo $x=$onMy->cal_percentage($android, $totalPerangkat) ?>%"><?php echo $x ?>%</div>
			                        </div>
			                      </td>
			                      <td><span class="badge bg-warning"><?php echo $android ?></span></td>
			                    </tr>
			                    <tr>
			                      <td>5.</td>
			                      <td>Mobile</td>
			                      <td>
			                        <div class="progress progress-lg progress-striped active">
			                          <div class="progress-bar bg-warning" style="width: <?php echo $x=$onMy->cal_percentage($mobile, $totalPerangkat) ?>%"><?php echo $x ?>%</div>
			                        </div>
			                      </td>
			                      <td><span class="badge bg-warning"><?php echo $mobile ?></span></td>
			                    </tr>
			                  </tbody>
			                </table>
                 
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">Domisili</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <table class="table table-bordered dt">
			                  <thead>
			                    <tr>
			                      <th style="width: 10px">#</th>
			                      <th>Usia</th>
			                      <th>Persentase</th>
			                      <th style="width: 40px">Jumlah</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                  	<?php $no=1; foreach ($domisili as $domisili): ?>
				                  	<tr>
				                  		<td><?php echo $no++ ?></td>
				                  		<td><?php echo $domisili['domisili'] ?></td>
				                  		<td>
				                        <div class="progress progress-lg">
				                          <div class="progress-bar progress-bar-danger" style="width: <?php echo $x=$onMy->cal_percentage($domisili['total'], $totalDomisili) ?>%"><?php echo $x ?>%</div>
				                        </div>
				                      </td>
				                  		<td><?php echo $domisili['total'] ?></td>
				                  	</tr>
			                  	<?php endforeach ?>
			                  </tbody>
			                </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.card-body -->
          </div>
        </section>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
  document.title = "KOMBI | Demografi <?php echo $komunitas['nama_komunitas'] ?>";
	
</script>
<?php
	require "footer.php";
?>