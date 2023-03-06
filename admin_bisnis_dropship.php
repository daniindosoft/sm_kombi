<?php 
  require('header.php'); 
  
  $onMy->isProduk = true;  
  $dataDropship = $onMy->getDataAffiliate($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], 'data_dropship');

  $orderToday = $onMy->singleByUserByCommunity("pesanan", $_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], "single", " and created_at like '%".date('Y-m-d')."%'")['total'];

  $valueTransactionToday = $onMy->eksekusiShow( 'SELECT sum(qty*harga) as total FROM `pesanan` as p join pesanan_line as pl on pl.id_pesanan = p.id WHERE p.id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and p.status=3 and p.created_at like "%'.date('Y-m-d').'%"' );

?>
<div class="content-wrapper" style="min-height: 1172.56px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dropship/reseller Komunitas</h1>
        </div>
        <div class="col-sm-12">
          <?php $onMy->callFlash() ?>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <h5 class="mb-2">Laporan Singkat</h5>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box shadow">
            <span class="info-box-icon bg-info"><i class="fa fa-cart-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pesanan Hari ini</span>
              <span class="info-box-number"><?php echo $onMy->nf( $orderToday ) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box shadow">
            <span class="info-box-icon bg-success"><i class="fa fa-money-bill-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Omset Hari ini</span>
              <span class="info-box-number">Rp<?php echo $onMy->nf($valueTransactionToday['total']) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box shadow">
            <span class="info-box-icon bg-warning"><i class="fa fa-table"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Pesanan</span>
              <span class="info-box-number"><?php echo $onMy->nf( $dataDropship['total_lead'] ) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box shadow">
            <span class="info-box-icon bg-danger"><i class="fa fa-money-bill"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Omset</span>
                <span class="info-box-number">Rp<?php echo $onMy->nf( $dataDropship['total_omset'] ) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 
      <h4 class="mt-4 mb-4">Produk & Pesanan</h4>
 
      <div class="row">
 
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="card card-widget collapsed-card">
            <div class="card-header">
              <div class="user-block">
                <b><a href="#">Produk</a></b>
              </div>
              <!-- /.user-block -->
              <div class="card-tools">
             
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-plus"></i>
                </button>
        
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display:none;">
              <div class="text-center">
                
              </div>
              <div class="row justify-content-md-center">
                <?php 
                  // foreach ($onMy->selectWithBussiness('produk', $_SESSION['bisnis_kategori_combi']) as $produk): 
                  foreach ($onMy->selectWhere('produk', $_SESSION['bisnis_kategori_combi'], ' and type="prd"') as $produk): 

                    $img = preg_split('#\r?\n#', $produk['dp'], 2)[0];

                ?>
                  <div class="col-md-3 border m-1">
                    <img src="<?php echo $img ?>" class="w-100" height="230px" style="object-fit: cover;">
                    <?php 
                      if ($produk['harga'] <= 0){
                        $varian = $onMy->eksekusiShow('select max(harga) as tertinggi, min(harga) as terendah from produk_variasi where id_produk ='.$produk['id']);
                        $price = 'Rp'.$onMy->nf($varian['terendah']).' - Rp'.$onMy->nf($varian['tertinggi']);
                      }else{
                        $price = 'Rp'.$onMy->nf($produk['harga']);
                      }
                    ?>
                    <label><?php echo $produk['nama_produk'] ?></label>
                    <h5><?php echo $price; ?></h5>
                    <a href="<?php echo $onMy->primaryLocal ?>user/produk/view?id=<?php echo $produk['id'] ?>" class="btn-sm btn btn-block btn-warning">Lihat..</a>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
       
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="card card-widget">
            <div class="card-header">
              <div class="user-block">
                <b><a href="#">Pesanan Member</a></b>
                <span class="description ml-0"><?php echo date('d F Y') ?></span>
              </div>
              <!-- /.user-block -->
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date range:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control float-right" id="reservation" onchange="return ssUserPesanan()">
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="col-md-4">
                  <label>Cari :</label>
                  <div class="input-group mb-3">
                    <input type="hidden" name="page" value="1" id="page">
                    <input type="text" class="form-control" placeholder="cari invoice, nama pemesan dll" name="cari" onkeyup="return ssUserPesanan()" id="cari" onkeydown="return resetAjaxTimer()">
                    <!-- /btn-group -->
                  </div>
                </div>
                <div class="col-md-4">
                  <label>Status</label>
                  <div class="input-group mb-3">
                    <select class="form-control" name="status" id="status" onchange="return ssUserPesanan()">
                      <option value="0">Semua</option>
                      <option value="1">Belum di Proses</option>
                      <option value="2">Di Tolak</option>
                      <option value="3">Di Setujui</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Invoice</th>
                      <th>Member</th>
                      <th>Info Pesanan</th>
                      <th>Waktu</th>
                    </tr>
                  </thead>
                  <tbody id="resultBodyOrder">
                    <?php
                      // $onMy->debug = true; 
                      $no=1; foreach ($onMy->selectPleksible('pesanan', 'id_komunitas_bisnis',$_SESSION['bisnis_kategori_combi'], 'order by id desc') as $d): 
                        

                      ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td>
                          <?php if ($d['status'] == '1'): ?>
                            <small><i class="fa fa-circle text-warning"></i> Perlu di proses</small>
                          <?php elseif ($d['status'] == '2'): ?>
                            <small><i class="fa fa-circle text-danger"></i> Ditolak</small>
                          <?php elseif ($d['status'] == '3'): ?>
                            <small><i class="fa fa-circle text-success"></i> Diterima</small>
                          <?php endif ?><br>
                            <?php if ($d['resi']): ?>
                              RESI : <b><?php echo $d['resi'] ?></b><br>
                            <?php endif ?>
                            <div class="btn-group dropup">
                              <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only"></span> <?php echo $d['invoice'] ?>
                              </button>
                              <div class="dropdown-menu" role="menu" style="">
                                <?php if ($d['status'] == '3' && !$d['resi']): ?>
                                  <a class="dropdown-item" href="#resi" data-toggle="modal" data-target="#modalResi" onclick="resi(<?php echo $d['id'] ?>, '<?php echo $d['invoice'] ?>')"><i class="fa fa-barcode"></i> Input RESI</a>
                                <?php endif; ?>
                                <?php if ($d['status'] == '1'): ?>
                                  <a class="dropdown-item" onclick="return confirm('Yakin untuk menerima pesanan ini ?')" href="<?php echo $onMy->primaryLocal ?>produk/acc?id=<?php echo $d[id] ?>&status=3&url=<?php echo $onMy->thisUrl() ?>?info=berhasil" ><i class="fa fa-check"></i> Terima</a>
                                  <a class="dropdown-item" onclick="return confirm('Yakin untuk menolak pesanan ini ?')" href="<?php echo $onMy->primaryLocal ?>produk/acc?id=<?php echo $d[id] ?>&status=2&url=<?php echo $onMy->thisUrl() ?>?info=berhasil" ><i class="fa fa-times"></i> Tolak</a>
                                <?php endif; ?>
                                  <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>user/invoice?id=<?php echo $d['id'] ?>" target="_blank"><i class="fa fa-eye"></i> Detail Pesanan</a>
                              </div>
                            </div>
                        </td>
                        <td><?php echo $onMy->thisProfile($d['id_user'])['nama_lengkap'] ?></td>
                        <td>
                          <b>Penerima : <?php echo $d['nama_lengkap'] ?></b><br>
                          No Hp : <?php echo $d['nowa'] ?><br>
                          <?php echo $d['provinsi'].', '.$d['alamat'] ?><br>
                        </td>
                        <td><?php echo $onMy->time_elapsed_string($d['created_at']) ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <div id="resultBodyOrderPage"></div>
            </div>
       
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
  </a>
</div>
<script>
  document.title = 'KOMBI | Dashboard Dropship & Reseller <?php echo $profileKomunitas['nama_komunitas'] ?>';

    var menuaddclass = document.getElementById("bisnis");
  menuaddclass.classList.add("active");

      var menuaddclassx = document.getElementById("dropres");
  menuaddclassx.classList.add("active");

      var menuaddclass3 = document.getElementById("bisnis-open");
  menuaddclass3.classList.add("menu-open");

  


</script>
<?php 
require('footer.php'); ?>