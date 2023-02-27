<?php
	error_reporting(0);
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  $komunitas = $onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi']);

  $show = $onMy->selectSingleOne('pesanan', 'id', $_GET['id']);

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COMBI</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="//localhost/rebi/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//localhost/rebi/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
 <div class="content-wrapper" style="min-height: 1604.44px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Invoice</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Invoice</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5> Total pesanan belum termasuk ongkir, silahkan konfirmasi ke Admin untuk mendapatkan total bayarnya
          </div>


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fa fa-file"></i> <?php echo $komunitas['nama_komunitas'] ?>
                  <small class="float-right">Date: <?php echo $onMy->convertDate('d F Y', $show['created_at']) ?></small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong><?php echo $komunitas['nama_komunitas'] ?></strong><br>
                  <?php echo $komunitas['alamat'] ?><br>
                  
                  No HP/Whatsapp: <?php echo $komunitas['nowa'] ?><br>
                  Email: <?php echo $komunitas['email'] ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                To
                <address>
                  <strong><?php echo $show['nama_lengkap'] ?></strong><br>
                  <?php echo $show['provinsi'].', '.$show['kecamatan'] ?><br>
                  <?php echo $show['alamat'] ?><br>
                  Phone: <?php echo $show['nowa'] ?><br>
                  Email: <?php echo $show['email'] ?>
                </address>
              </div>
              <div class="col-sm-4 invoice-col">
              	<b>Invoice : <?php echo $show['invoice'] ?></b>
              </div>
              <!-- /.col --> 
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Variasi</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
	                  $totalHargaAll = 0;
	                  $no=0; 
	                  foreach ($onMy->selectPleksible('pesanan_line','id_pesanan',$_GET['id']) as $produk): $no++; 
                  	
                  	$totalHarga += $produk['harga']*$produk['qty'];
                  	$totalHargaAll += $produk['harga']*$produk['qty'];
                  ?>
	                  <tr>
	                    <td><?php echo $no ?></td>
	                    <td><?php echo $produk['nama_produk'] ?></td>
	                    <td><?php echo $produk['varian_produk'] ?></td>
	                    <td><?php echo $produk['qty'] ?></td>
	                    <td>Rp<?php echo $onMy->nf($produk['harga']) ?></td>
	                    <td>Rp<?php echo $onMy->nf( $totalHarga ) ?></td>
	                  </tr>
                  <?php $totalHarga=0; endforeach ?>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead">Payment Methods:</p>
                <?php
                	$profileAdmin = $onMy->thisProfile($komunitas['id_user']);
                ?>
                <?php 
                	foreach (explode(',', $profileAdmin['logo_bank']) as $bank): ?>
				            <?php if ($bank != 'x'): ?>
			                <img src="<?php echo $bank ?>" height="30px">
			              <?php 
				            endif; 
				          endforeach;
			          ?>
                 
              </div>
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">PERHITUNGAN</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody><tr>
                      <th style="width:50%">Total</th>
                      <td><h4>Rp<?php echo $onMy->nf($totalHargaAll) ?></h4></td>
                    </tr>
                  </tbody></table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <button onclick="window.print()" rel="noopener" class="btn btn-default"><i class="fa fa-download"></i> Download</button>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
 
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="//localhost/rebi/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="//localhost/rebi/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="//localhost/rebi/dist/js/adminlte.min.js"></script>
<script type="text/javascript">
  window.print()
</script> 
</body>
</html>
