<?php
  require('header_user.php');
  $dataAffiliate = $onMy->getDataAffiliate($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi']);

  $showDataLead = $onMy->showDataLeadUser($_SESSION['bisnis_kategori_combi'], $_COOKIE['id_akun_combi']);

  $leadToday = $onMy->orderAffiliateByDate($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], 1, date('Y-m-d'),'j');

  $leadTodayCr = $onMy->showAffiliateDataLeadCr($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], date('Y-m-d'),'count(*) as total');

  $leadTodayValue = $onMy->showAffiliateDataLeadCr($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], date('Y-m-d'),'sum(price_join) as total');

  $cr = ($leadTodayCr['total'] / $leadToday['total']) * 100;

  // data affilaite produk
  $orderTodayProdukAff = $onMy->eksekusiShow("select count(*) as total from order_produk where id_aff=".$_COOKIE['id_akun_combi']." and id_komunitas_bisnis=". $_SESSION['bisnis_kategori_combi']." and created_at like '%".date('Y-m-d')."%'")['total'];

  $priceTodayProdukAff = $onMy->eksekusiShow("select sum(harga) as total from order_produk where id_aff=".$_COOKIE['id_akun_combi']." and status=3 and id_komunitas_bisnis=". $_SESSION['bisnis_kategori_combi']." and created_at like '%".date('Y-m-d')."%'")['total'];




?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Affiliate</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <?php if ($_SESSION['bisnis_kategori_combi']){ ?>
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">
            <h5>Data Affiliate Komunitas</h5>
            <!-- <a href="" class="float-sm-right">Selengkapnya ..</a> -->
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4><?php echo $onMy->nf($leadToday['total']) ?></h4>

                <p>Daftar Hari ini (CR <?php echo round($cr) ?>%)</p>
              </div>
              <div class="icon">
                <i class="ion-android-people"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4><?php echo $onMy->nf($leadTodayValue['total']) ?></h4>

                <p>Pendapatan   Hari ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h4><?php echo $onMy->nf($dataAffiliate['total_lead']) ?></h4>

                <p>Total Lead</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-people"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>Rp<?php echo $onMy->nf($dataAffiliate['total_pendapatan']) ?></h4>

                <p>Total Nilai Transaksi</p>
              </div>
              <div class="icon">
                <i class="fa fa-money-check-alt"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-12 col-12">
            <h5>Data Affiliate Produk</h5>
            <!-- <a href="" class="float-sm-right">Selengkapnya ..</a> -->
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-info">
              <span class="info-box-icon"><i class="ion ion-android-people"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pesanan Hari Ini</span>
                <span class="info-box-number"><?php echo $onMy->nf( $orderTodayProdukAff ) ?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                  <small>Telah mengisi form</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
            <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-success">
              <span class="info-box-icon"><i class="fa fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pendapatan Produk</span>
                <span class="info-box-number">Rp<?php echo $onMy->nf( $priceTodayProdukAff ) ?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                  Total Pendapatan
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-warning">
              <span class="info-box-icon"><i class="fa fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Seluruh Pesanan</span>
                <span class="info-box-number"><?php echo $onMy->nf($dataAffiliate['total_pesanan_produk']) ?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                  &nbsp;
                  &nbsp;
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fa fa-money-check-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Pendapatan</span>
                <span class="info-box-number">Rp<?php echo $onMy->nf( $dataAffiliate['total_pendapatan_produk'] ) ?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                  Total Pendapatan
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-android-people mr-1"></i>
                  Link Affiliate & Leads
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link yellow active btn-sm" href="#revenue-chart" data-toggle="tab">Link Affiliate</a>
                    </li>
                    <li class="nav-item ">
                      <a class="nav-link yellow btn-sm" href="#sales-chart" data-toggle="tab">Lead</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="chart tab-pane" id="sales-chart">
                    <div class="card card-warning card-outline card-tabs">
                      <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Lead Affiliate</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Lead Produk Affiliate</a>
                          </li> 
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                          <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                            <h5>Affiliate Komunitas</h5>                       
                             <hr>
                             <div class="row">
                              <div class="col-md-4">
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control rounded-0" id="cariUser" placeholder="Cari by nama">
                                  <div class="input-group-prepend">
                                    <button type="button" onclick="findUser(1)" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> ...</button>
                                    <input type="hidden" name="page" id="pageUser" value="1">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="table-responsive">
                               <table class="table table-bordered table-hover dataTable dtr-inline">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Info</th>
                                  </tr>
                                </thead>
                                <tbody id="resultBodyUser">
                                  <?php 
                                    $no=1; 
                                    foreach ($showDataLead as $value): 
                                      $komisi = $onMy->getSpesificLead('komisi', $value['idu'], $_SESSION['bisnis_kategori_combi'])['komisi'];
                                  ?>
                                    <tr>
                                      <td><?php echo $no++; ?></td>
                                      <td>
                                        <?php echo $value['nama_lengkap'] ?>
                                      </td>
                                      <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Untuk keamanan dan privasi data, member yang bergabung lewat link affilaite anda kami tutupi"><i class="fa fa-info-circle"></i></span>
                                        <?php 
                                          echo substr($value['email'], 0, 3).'******@**.com';
                                        ?> <br>
                                        <?php 
                                          echo substr($value['nowa'], 0, 5).'******';
                                        ?>
                                      </td>
                                      <td>
                                        Transfer Senilai : <b class="btn btn-default font-weight-bold">Rp <?php echo $onMy->nf($value['price']) ?></b>  <br><br>
                                        Waktu Daftar : <b><?php echo $onMy->time_elapsed_string($value['created_at']) ?><br><br></b>
                                        Status Akun : <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="Belum di Aktivasi oleh Admin Komunitas">Belum Aktif <i class="fa fa-info-circle"></i></span>
                                      </td>
                                    </tr>
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                            </div>
                            <div id="resultBodyUserPage">
                              <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link active" href="#page1">1</a>
                                  </li>
                                  <li class="page-item">
                                    <a  class="page-link" onclick="paginateA(2)">Next</a>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                            <h5>Affiliate Produk/Pesanan</h5>                       
                             <hr>
                             <div class="row">
                              <div class="col-md-4">
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control rounded-0" id="cariProduk" placeholder="Cari by nama">
                                  <div class="input-group-prepend">
                                    <button type="button" onclick="findProduk(1)" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> ...</button>
                                    <input type="hidden" id="pageProduk" value="1">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="table-responsive">
                              <table class="table table-bordered table-hover dataTable dtr-inline">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Produk</th>
                                    <th>Info</th>
                                  </tr>
                                </thead>
                                <tbody id="resultBodyProduk"> 
                                  <?php 
                                    $no=1; 
                                    // echo 'select * order_produk where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'];

                                    foreach ($onMy->tampil_manual('select * from order_produk where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and id_aff='.$_COOKIE['id_akun_combi'].' and status = 1 order by id desc limit 10') as $value): 
                                      $komisi = $onMy->getSpesificLead('komisi', $value['idu'], $_SESSION['bisnis_kategori_combi'])['komisi'];

                                      $usercek = $onMy->single('users', $value['id_aff']);
                                      $aff = "Anda";
                                      $email = substr($value['email'], 0, 3).'******@**.com <br>';
                                      $nowa = substr($value['nowa'], 0, 3).'*******';
                                      
                                  ?>
                                    <tr>
                                      <td><?php echo $no++; ?></td>
                                      <td>
                                        <?php echo $value['nama'] ?>
                                        
                                      </td>
                                      <td>
                                        <?php
                                          echo $email;
                                          echo $nowa;
                                        ?>
                                      </td>
                                      <td><?php echo $onMy->selectSingleOne('affiliate_produk', 'id', $value['id_produk'])['judul'] ?></td>
                                      <td>
                                        Transfer Senilai : <b class="btn btn-default font-weight-bold">Rp <?php echo $onMy->nf($value['harga']) ?></b>  <br><br>
                                        <small>Waktu Daftar : <b><?php echo $onMy->time_elapsed_string($value['created_at']) ?><br><br></b>

                                        Affilaite : 
                                        <?php 
                                          echo $aff;
                                        ?>
                                        </small>
                                      </td>
                                    </tr>
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                            </div>
                            <div id="resultBodyProdukPage">
                              <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link active" href="#page1">1</a>
                                  </li>
                                  <li class="page-item">
                                    <a  class="page-link" onclick="paginateP(2)">Next</a>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card -->
                    </div>
                    
                  </div>
                  <div class="chart tab-pane active" id="revenue-chart">
                    <?php if (!empty($komunitas['note'])): ?>
                      <div class="alert alert-info">
                        <?php echo $komunitas['note'] ?>
                      </div>
                    <?php endif ?>
                    <b>Affiliate Komunitas</b>
                    <div class="border border-warning p-1 text-dark text-sm p-3">
                        Affiliate  <?php echo $komunitas['nama_komunitas'] ?><br>
                        <small>Dapatkan Komisi <b>Rp<?php echo number_format($komunitas['komisi_affiliate_join']) ?></b> setiap kali ada seseorang yang bergabung ke Komunitas <b><?php echo $komunitas['nama_komunitas'] ?></b> lewat link Affiliate Anda</small>
                    </div>
                    <div class="input-group dropup mb-3">
                      <div class="input-group-prepend dropup ">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu dropup " style="">
                          <a class="dropdown-item" href="<?php echo $onMy->primaryLocal.'daftar?cd='.$komunitas['code_komunitas'].'&aff='.$profile['kode_affiliate'] ?>" target="_blank">Buka Link</a>
                          <a class="dropdown-item" href="#textsss" onclick="return copyText('xtext">Copy Link</a>
                        </div>
                      </div>
                      <!-- /btn-group -->
                      <input required type="text" class="form-control" value="<?php echo $onMy->primaryLocal.'daftar?cd='.$komunitas['code_komunitas'].'&aff='.$profile['kode_affiliate'] ?>" id="xtext">
                    </div>
                    <hr>
                    <b>Affiliate Produk</b>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover dt">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Detail</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $no=1; 
                            foreach ($onMy->selectWithBussiness('affiliate_produk', $_SESSION['bisnis_kategori_combi']) as $val): 
                              if ($val['is_private'] != 1) {
                          ?>
                            <tr>
                              <td><?php echo $no++ ?></td>
                              <td>
                                <div class="border border-warning p-1 text-dark text-sm p-3">
                                  <b>Nama Produk <?php echo $val['judul'] ?></b><br>
                                  Produk <?php if ($val['type'] == 'non'): ?>
                                    <span class="badge badge-info">Digital</span>
                                  <?php else: ?>
                                    <span class="badge badge-success">Fisik</span>
                                  <?php endif ?><br>
                                  <?php echo 'Note : '.$val['note'] ?><br>
                                  <?php if ($val['nilai'] == 'gratis'): ?>
                                    <small><b>Komisi : Lead Magnet(Gratis)</b></small>
                                  <?php else: ?>
                                    <small><b>Komisi : Rp<?php echo number_format($val['komisi']) ?></b></small>
                                  <?php endif; ?>

                                  <div class="input-group dropup mb-3">
                                    <div class="input-group-prepend dropup ">
                                      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        Action
                                      </button>
                                      <div class="dropdown-menu dropup " style="">
                                        <a class="dropdown-item" href="<?php echo $urlAff = $onMy->primaryLocal.'produk/buy?cd='.$val['kode_affiliate_produk'].'&aff='.$profile['kode_affiliate'] ?>" target="_blank">Buka Link</a>
                                        <a class="dropdown-item" href="#textsss" onclick="return copyText('text<?php echo $no ?>')">Copy Link</a>
                                      </div>
                                    </div>
                                    <!-- /btn-group -->
                                    <input required type="text" class="form-control" value="<?php echo $urlAff ?>" id="text<?php echo $no; ?>">
                                  </div>

                                </div>
                              </td>
                            </tr>
                          <?php } endforeach; ?>
                        </tbody>
                      </table>
                    </div>                    

                    <br>
                     
                    <br>
                  </div>
                </div>
                
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>

        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  <?php }else{ ?>
    <div class="alert alert-info">
      <i class="fa fa-info-circle"></i> Opps !, Anda tidak ada di komunitas atau tidak terdaftar di komunitas manapun
    </div>
  <?php } ?>
  <!-- /.content -->
</div>
<script type="text/javascript">
  document.title = "KOMBI | Dashboard Affiliate <?php echo $komunitas['nama_komunitas'] ?>";
      var menuaddclass = document.getElementById("bisnis");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("affiliate");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("bisnis-open");
    menuaddclass3.classList.add("menu-open");

    
</script>
<?php
  require('footer.php');
?>