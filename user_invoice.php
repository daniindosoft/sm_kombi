<?php
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  $profile = $onMy->thisProfile($_COOKIE['id_akun_combi']);

	if ($profile['type_user'] == 'user') {
	  require('header_user.php');
	}else{
	  require('header.php');
	}
  
  $onMy->verifDataOwned('pesanan', 'id',  $onMy->toInt($_GET['id']));

  $show = $onMy->selectSingleOne('pesanan', 'id', $onMy->toInt($_GET['id']));
  $aff = $onMy->thisProfile($show['id_user']);
  $sistem->inv = $show['invoice'];
?>
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
          <?php if ($show['status'] == 1): ?>
            
          <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5> Total pesanan belum termasuk ongkir, 
            <?php
              if ($profile['type_user'] == 'user') {
                echo "silahkan konfirmasi ke Admin untuk mendapatkan total bayarnya";
              }else{
                echo "Silahkan hubungi Affiliate <b>".$aff['nama_lengkap']."</b> untuk ongkirnya";
              }
            ?>
            
          </div>
          <?php endif ?>


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h5>
                  <i class="fa fa-file"></i> <?php echo $komunitas['nama_komunitas'] ?>
                  <small class="float-right">Date: <?php echo $onMy->convertDate('d F Y', $show['created_at']) ?></small>
                </h5>
                <h6>Affiliate <?php echo $aff['nama_lengkap'] ?></h6>
                <h6>Status 
                  <?php if ($show['status'] == '1'): ?>
                    <small><i class="fa fa-circle text-warning"></i> Perlu di proses</small>
                  <?php elseif ($show['status'] == '2'): ?>
                    <small><i class="fa fa-circle text-danger"></i> Ditolak</small>
                  <?php elseif ($show['status'] == '3'): ?>
                    <small><i class="fa fa-circle text-success"></i> Dikemas/proses Oleh Anda
                      <?php if ($profile['type_user'] == 'admin' && empty($show['resi'])): ?>
                        (Segera kirim barang dan update RESI)
                      <?php endif ?>
                    </small>
                  <?php endif ?><br>
                  
                </h6>
                <hr>
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
                  <?php 
                    
                  ?>
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
                  <?php if ($show['status'] == 3 || $profile['type_user'] == 'admin'): ?>
                    Phone: <?php echo $show['nowa'] ?><br>
                    Email: <?php echo $show['email'] ?>
                  <?php else: ?>
                    Phone: 08******<br>
                    Email: a*****@***
                  <?php endif; ?>
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
	                  foreach ($sistem->selectPleksible('pesanan_line','id_pesanan',$_GET['id']) as $produk): $no++; 
                  	
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
                  
                  foreach( $onMy->select('norek',$komunitas['id_user']) as $value){
                ?>
                  <p>
                    <b><?php echo $value['nama_bank'] ?></b><br>
                    <b><?php echo $value['nama_pemilik'] ?></b><br>
                    <span> <?php echo ( !empty($value['kode_bank']) ) ? '('.$value['kode_bank'].')' : '' ?> <?php echo $value['norek'] ?></span>
                  </p>
                <?php
                  }

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
                <a href="<?php echo $sistem->primaryLocal ?>user/invoice/single?id=<?php echo $_GET['id'] ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>

                <?php 
                  if ($profile['type_user'] == 'user'):
                ?>
                <a href="<?php echo $sistem->waFormat('produk') ?>" target="_blank" class="btn btn-warning float-right" style="margin-right: 5px;">
                  <i class="fab fa-whatsapp"></i> Teruskan via Whatsapp
                </a>
                  
                <?php endif ?>
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
<script type="text/javascript">
  document.title = 'KOMBI | Invoice Pesanan Dropship/reseller';

    var menuaddclass = document.getElementById("bisnis");
  menuaddclass.classList.add("active");

      var menuaddclassx = document.getElementById("dropres");
  menuaddclassx.classList.add("active");

  var menuaddclassxx = document.getElementById("dropship");
  menuaddclassxx.classList.add("active");

      var menuaddclass3 = document.getElementById("bisnis-open");
  menuaddclass3.classList.add("menu-open");
</script>
<?php
require('footer.php');
?>