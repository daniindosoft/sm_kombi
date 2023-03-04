<?php
	require "header.php";
	// $onMy->debug = true;
	$ssReportOrdersAffiliate = true; 

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Affiliate & Dropship </h1>
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
            </div>
            <div class="card-body">
            	<small><code>*</code> Untuk lebih optimal dan lebih nyaman mohon buka halaman ini di perangkat komnuter, tablet dan sejenisnya atau buka di smartphone dengan mode <b>situs desktop</b></small>
            	<hr>
            	<div class="card card-warning card-outline card-outline-tabs">
	              <div class="card-header p-0 border-bottom-0">
	                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
	                  <li class="nav-item">
	                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Affiliate Komunitas</a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Affiliate Produk </a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Dropship</a>
	                  </li>
	                </ul>
	              </div>
	              <div class="card-body">
	                <div class="tab-content" id="custom-tabs-four-tabContent">
	                  <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
											<div class="row">
												<div class="col-md-12 col-sm-12">
													<b>AFFILIATE KOMUNITAS</b>
													<hr>
												</div>
												<div class="col-md-3 col-sm-12">
													<div class="form-group">
														<label>Date range:</label>
														<div class="input-group">
														  <div class="input-group-prepend">
														    <span class="input-group-text">
														      <i class="far fa-calendar-alt"></i>
														    </span>
														  </div>
														  <input type="text" class="form-control float-right" id="reservation" value="<?php echo $_GET['d'] ?>">
														</div>
													</div>
												</div>
												<div class="col-md-3 col-sm-12">
													<div class="form-group">
														<label>Pilih Komunitas</label>
														<div class="input-group">
														  <select name="komunitas" class="form-control" id="komunitas">
														  	<?php foreach ($onMy->selectPleksible('komunitas_bisnis', 'id_user', $_COOKIE['id_akun_combi']) as $kom): ?>
															  	<option <?php echo ($_GET['id'] == $kom['id']) ? 'selected' : '' ?> value="<?php echo $kom['id'] ?>"><?php echo $kom['nama_komunitas'] ?></option>
														  	<?php endforeach ?>
														  </select>
														</div>
													</div>
												</div>
												<div class="col-md-5 col-sm-12">
													<div class="form-group">
														<label>&nbsp;</label>
														<div class="input-group">
														  <button class="btn btn-warning" onclick="return ssReportOrdersAffiliate()">Tampilkan</button> &nbsp;&nbsp;
														  <button onclick="return ssReportOrdersAffiliate(true)" class="btn btn-warning">Unduh Data</button>
														</div>
													</div>
												</div>
												
											</div>  
											<section class="table-responsive" id="ribbonReportAffiliate">
												<h4 class="loadingchart hide"><i class="fa fa-spin fa-spinner"></i> Mohon tunggu !</h4>
												<table>
													<tr class="text-sm">
														<td><i class="fa fa-circle" style="color: #FFD588;"></i> Lead = Jumlah data/pendaftar masuk</td>
														<td> - </td>
														<td><i class="fa fa-circle" style="color: #FF9400;"></i> Konversi = Jumlah Lead/pendaftar yang melakukan pembayaran</td>
													</tr>
												</table>
												<div class="table-responsive">
													<canvas id="reportAffiliate"></canvas>
												</div>
											</section>
										</div>
	             
	                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
	                    <div class="row">
												<div class="col-md-12 col-sm-12">
													<b>AFFILIATE PRODUK</b>
													<hr>
												</div>
												<div class="col-md-4 col-sm-12">
													<div class="form-group">
														<label>Date range:</label>
														<div class="input-group">
														  <div class="input-group-prepend">
														    <span class="input-group-text">
														      <i class="far fa-calendar-alt"></i>
														    </span>
														  </div>
														  <input type="text" id="reservation_produk_affiliate" class="form-control float-right drp" value="<?php echo $_GET['d'] ?>">
														</div>
													</div>
												</div>
												<div class="col-md-4 col-sm-12">
													<div class="form-group">
														<label>Pilih Komunitas</label>
														<div class="input-group">
														  <select name="komunitas" class="form-control" id="komunitas_produk_affiliate">
														  	<?php foreach ($onMy->selectPleksible('komunitas_bisnis', 'id_user', $_COOKIE['id_akun_combi']) as $kom): ?>
															  	<option <?php echo ($_GET['id'] == $kom['id']) ? 'selected' : '' ?> value="<?php echo $kom['id'] ?>"><?php echo $kom['nama_komunitas'] ?></option>
														  	<?php endforeach ?>
														  </select>
														</div>
													</div>
												</div>
												<div class="col-md-4 col-sm-12">
													<div class="form-group">
														<label>&nbsp;</label>
														<div class="input-group">
														  <button class="btn btn-warning" onclick="return ssReportOrdersProdukAffiliate()">Tampilkan</button>
														  &nbsp;&nbsp;
														  <button onclick="return ssReportOrdersProdukAffiliate(true)" class="btn btn-warning">Unduh Data</button>
														</div>
													</div>
												</div>
											</div>  
											<section class="table-responsive" id="ribbonReportAffiliate">
												<h4 class="loadingchart hide"><i class="fa fa-spin fa-spinner"></i> Mohon tunggu !</h4>
												<table>
													<tr class="text-sm">
														<td><i class="fa fa-circle" style="color: #FFD588;"></i> Lead = Jumlah data/order masuk</td>
														<td> - </td>
														<td><i class="fa fa-circle" style="color: #FF9400;"></i> Konversi = Jumlah Lead/order yang melakukan pembayaran</td>
													</tr>
												</table>
												<div class="table-responsive">
													<canvas id="reportProdukAffiliate"></canvas>
			                  </div>
											</section>
	                  </div>
	                  <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
	                    <div class="row">
												<div class="col-md-12 col-sm-12">
													<b>DROPSHIP/RESELLER</b>
													<hr>
												</div>
												<div class="col-md-4 col-sm-12">
													<div class="form-group">
														<label>Date range:</label>
														<div class="input-group">
														  <div class="input-group-prepend">
														    <span class="input-group-text">
														      <i class="far fa-calendar-alt"></i>
														    </span>
														  </div>
														  <input type="text" id="reservation_dropship" class="form-control float-right drp" value="<?php echo $_GET['d'] ?>">
														</div>
													</div>
												</div>
												<div class="col-md-4 col-sm-12">
													<div class="form-group">
														<label>Pilih Komunitas</label>
														<div class="input-group">
														  <select name="komunitas" class="form-control" id="komunitas_dropship">
														  	<?php foreach ($onMy->selectPleksible('komunitas_bisnis', 'id_user', $_COOKIE['id_akun_combi']) as $kom): ?>
															  	<option <?php echo ($_GET['id'] == $kom['id']) ? 'selected' : '' ?> value="<?php echo $kom['id'] ?>"><?php echo $kom['nama_komunitas'] ?></option>
														  	<?php endforeach ?>
														  </select>
														</div>
													</div>
												</div>
												<div class="col-md-4 col-sm-12">
													<div class="form-group">
														<label>&nbsp;</label>
														<div class="input-group">
														  <button class="btn btn-warning" onclick="return ssReportOrdersDropship()">Tampilkan</button>
														  &nbsp;&nbsp;
														  <button onclick="return ssReportOrdersDropship(true)" class="btn btn-warning">Unduh Data</button>
														</div>
													</div>
												</div>
											</div>  
											<section class="table-responsive" id="ribbonReportAffiliate">
												<h4 class="loadingchart hide"><i class="fa fa-spin fa-spinner"></i> Mohon tunggu !</h4>
												<table>
													<tr class="text-sm">
														<td><i class="fa fa-circle" style="color: #FFD588;"></i> Lead = Jumlah data/orderan masuk</td>
														<td> - </td>
														<td><i class="fa fa-circle" style="color: #FF9400;"></i> Konversi = Jumlah Lead/orderan yang melakukan pembayaran</td>
													</tr>
												</table>
												<div class="table-responsive">
													<canvas id="reportDropship"></canvas>
			                  </div>
											</section>
	                  </div>
	                   
	                </div>
	              </div>
	              <!-- /.card -->
	            </div>
            </div>
          </div>
        </section>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
  document.title = "KOMBI | Laporan Pesanan Affiliate & Dropship <?php echo $komunitas['nama_komunitas'] ?>";
	var menuaddclass = document.getElementById("report");
	menuaddclass.classList.add("active");

	var menuaddclass2 = document.getElementById("orders");
	menuaddclass2.classList.add("active");

	var menuaddclass3 = document.getElementById("report-open");
	menuaddclass3.classList.add("menu-open");
</script>
<?php
	require "footer.php";
?>