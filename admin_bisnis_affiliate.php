<?php
  require('header.php');
  $sqlLead = "select count(u.id)as total from users as u join komunitas as k on k.id_user = u.id where u.tgl_daftar like '%".date('Y-m-d')."%' and k.id_komunitas=".$_SESSION['bisnis_kategori_combi'];
  // $leadToday = $onMy->eksekusiShow($sqlLead." ");
  $leadTodayCr = $onMy->eksekusiShow($sqlLead." and status=1");
  
  
  $dataAffiliate = $onMy->eksekusiShow('select * from data_affiliate where id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi']);

  $profitToday = $onMy->profitToday($_SESSION['bisnis_kategori_combi'], date('Y-m-d'));

  $leadToday = $onMy->orderAffiliateByDate(false, $_SESSION['bisnis_kategori_combi'], 1, date('Y-m-d'),'j');

  $leadTodayCr = $onMy->showDataLeadCr($_SESSION['bisnis_kategori_combi'], date('Y-m-d'),'j');

  $orderToday = $onMy->orderAffiliateByDate($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], 0, date('Y-m-d'));

  $orderTodayLead = $onMy->orderAffiliateByDate($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], 0, date('Y-m-d'), 'j');

  $cr = ($leadTodayCr['total'] / $leadToday['total']) * 100;

  $showDataLead = $onMy->showDataLead($_SESSION['bisnis_kategori_combi']);

  // get data affilate produk

  $orderTodayProdukAff = $onMy->eksekusiShow("select count(*) as total from order_produk where  id_komunitas_bisnis=". $_SESSION['bisnis_kategori_combi']." and created_at like '%".date('Y-m-d')."%'")['total'];

  $priceTodayProdukAff = $onMy->eksekusiShow("select sum(harga) as total from order_produk where id_komunitas_bisnis=". $_SESSION['bisnis_kategori_combi']." and status=3 and created_at like '%".date('Y-m-d')."%'")['total'];
  


?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard  </h1>
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
      <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-lg-12 col-12">
          <h5>Affiliate Komunitas</h5>
          <!-- <a href="" class="float-sm-right">Selengkapnya ..</a> -->
        </div>
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h4><?php echo $onMy->nf($leadToday['total']) ?></h4>

              <p>Daftar Hari ini (CR <?php echo ceil($cr); ?>%)</p>
            </div>
            <div class="icon">
              <i class="ion-android-people"></i>
            </div>
            <a data-toggle="tooltip" data-placement="top" title="Total Pesanan hari ini, termasuk yang sudah pembayaran dan belum, CR adalah Conversion Rate, disini menampilkan CR hari ini " href="#" class="small-box-footer">More info <i class="fas fa-info-circle" ></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h4>Rp<?php echo $onMy->nf($profitToday['total']) ?></h4>

              <p>Total Nilai Transaksi Hari ini</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" data-toggle="tooltip" data-placement="top" title="Total Nilai Transaksi hari ini, menghitung biaya member yang bergabung" class="small-box-footer">More info <i class="fas fa-info-circle"></i></a>
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
            <a href="#" data-toggle="tooltip" data-placement="top" title="Total seluruh lead dari semua affiliate komunitas" class="small-box-footer">More info <i class="fas fa-info-circle"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h4>Rp<?php echo $onMy->nf($dataAffiliate['total_pendapatan']) ?></h4>

              <p>Total Pendapatan</p>
            </div>
            <div class="icon">
              <i class="fa fa-money-check-alt"></i>
            </div>
            <a href="#" data-toggle="tooltip" data-placement="top" title="Total pendapatan selama ini, dihitung dari semua transaksi join komunitas" class="small-box-footer">More info <i class="fas fa-info-circle"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12 col-12">
          <h5>Affiliate Produk</h5>
          <!-- <a href="" class="float-sm-right">Selengkapnya ..</a> -->

        </div>
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box bg-gradient-info">
            <span class="info-box-icon"><i class="ion ion-android-people"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pesanan Hari Ini</span>
              <span class="info-box-number"><?php echo $orderTodayProdukAff ?></span>

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
              <span class="info-box-text">Total Nilai </span>
              <span class="info-box-number">Rp<?php echo $onMy->nf( $priceTodayProdukAff ) ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                Transaksi Hari ini
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
              <span class="info-box-number">Rp<?php echo $onMy->nf($dataAffiliate['total_pendapatan_produk']); ?></span>

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
                Lead dan Link Affiliate
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link yellow active btn-sm" href="#revenue-chart" data-toggle="tab">Affiliate Komunitas & Produk</a>
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
                  
                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">Affiliate Komunitas</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body border">
                       <h5>Komunitas <?php echo $onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi'])['nama_komunitas'] ?></h5>
                       <small>*Data yang datang dari affiliate akan di samarkan, hingga Anda menyetujui/memproses pesanan</small><br>
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

                                  $usercek = $onMy->single('users', $value['id_affiliate']);
                                  if ($usercek['id'] == $_COOKIE['id_akun_combi']) {
                                    $aff = "Anda";
                                    $email = $value['email'].'<br>';
                                    $nowa = $value['nowa'];
                                  }else{
                                    $aff = $usercek['nama_lengkap'];
                                    $email = substr($value['email'], 0, 3).'******@**.com <br>';
                                    $nowa = substr($value['nowa'], 0, 3).'*******';

                                  }
                            ?>
                              <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-warning"><?php echo $value['nama_lengkap'] ?></button>
                                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                      <span class="sr-only"></span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                      <a class="dropdown-item" onclick="return msg('Akun ini akan menjadi member dari komunitas ini, yakin untuk menyetujuinya ?')" href="<?php echo $onMy->primaryLocal ?>admin/approve/user?id_user=<?php echo $value['idu'] ?>&id_komunitas=<?php echo $_SESSION['bisnis_kategori_combi'] ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>&price=<?php echo $value['price'] ?>&komisi=<?php echo $komisi ?>&aff=<?php echo $value['id_affiliate'] ?>&owner=<?php echo $_COOKIE['id_akun_combi'] ?>">Setujui</a>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <?php echo $email ?> <br>
                                  <?php echo $nowa ?>
                                </td>
                                <td>
                                  Transfer Senilai : <b class="btn btn-default font-weight-bold">Rp <?php echo $onMy->nf($value['price']) ?></b>  <br><br>
                                  Waktu Daftar : <b><?php echo $onMy->time_elapsed_string($value['created_at']) ?><br><br></b>
                                  Affilaite : 
                                  <?php 
                                    echo $aff;
                                  ?>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <hr>
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
                    <!-- /.card-body -->
                  </div>

                  <div class="card card-warning">
                    <div class="card-header">
                      <h3 class="card-title">Affiliate Produk/Pesanan</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body border" >
                       <h5>Affiliate Produk/Pesanan</h5>                       
                       <small><code>*</code> Untuk meproses pesanan, silahkan klik <b>Nama pembeli -> setujui/proses</b>, dengan mengklik setuju/proses komisi Affiliate (jika pesanan itu datang dari affiliate) akan di tambahkan</small>
                       <hr>
                       <div class="row">
                        <div class="col-md-4">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control rounded-0" id="cariProduk" placeholder="Cari by nama atau harga">
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

                              foreach ($onMy->tampil_manual('select * from order_produk where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and status !=2 order by id desc limit 10') as $value): 
                                $komisi = $onMy->getSpesificLead('komisi', $value['idu'], $_SESSION['bisnis_kategori_combi'])['komisi'];

                                $usercek = $onMy->single('users', $value['id_aff']);
                                if ($value['id_aff'] == $_COOKIE['id_akun_combi']) {
                                  $aff = "Anda";
                                  $email = $value['email'].'<br>';
                                  $nowa = $value['nowa'];
                                }else{
                                  $aff = $usercek['nama_lengkap'];
                                  $email = substr($value['email'], 0, 3).'******@**.com <br>';
                                  $nowa = substr($value['nowa'], 0, 3).'*******';

                                }

                                if ($value['status'] == 3) {
                                  $email = $value['email'].'<br>';
                                  $nowa = $value['nowa'];
                                }
                            ?>
                              <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                  <?php
                                    $noption = '';
                                    $produkIni = $onMy->selectSingleOne('affiliate_produk', 'id', $value['id_produk']);
                                    if ($value['status'] == '1') {
                                      echo "<span class='badge badge-info'>Belum di proses</span>";
                                    }elseif($value['status'] == '3'){
                                      if ($produkIni['type'] == 'fisik') {
                                        $noption = '';
                                        if (empty($value['resi']) || $value['resi'] == null || $value['resi'] == '') {
                                          $noption = '
                                            <a class="dropdown-item" href="#" onclick="return formResiAff('.$value['id'].')"><i class="fa fa-barcode"></i> Input Resi</a>
                                          ';
                                        }
                                      }
                                      echo "<span class='badge badge-warning'>Sudah di proses</span>";
                                    }
                                  ?>
                                  
                                  <?php echo ($value['resi']) ? '<br>RESI : <b>'.$value['resi'].'</b>' : ''; ?>
                                  <br>

                                  <div class="btn-group">
                                    <button type="button" class="btn btn-warning"><?php echo $value['nama']
                                    ?></button>
                                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                      <span class="sr-only"></span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                      <a class="dropdown-item" target="_blank" href="<?php echo $onMy->primaryLocal ?>admin/view/produkaff?id=<?php echo $value['id'] ?>">Lihat Detail</a>
                                      <?php echo $noption; ?>
                                      <?php if ($value['status'] == 1): ?>
                                        <a class="dropdown-item" onclick="return msg('Yakin memproses pesanan ini ?, komisi akan di tambahkan ke affiliate(jika pembeli ini datang dari affiliate)')" href="<?php echo $onMy->primaryLocal ?>admin/approve/produkaff?id=<?php echo $value['id'] ?>&id_komunitas=<?php echo $_SESSION['bisnis_kategori_combi'] ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>&price=<?php echo $value['harga'] ?>&status=3&komisi=<?php echo $value['komisi'] ?>&aff=<?php echo $value['id_aff'] ?>">Setujui/Proses</a>
                                        
                                        <a class="dropdown-item" onclick="return msg('Yakin menolak pesanan ini ?')" href="<?php echo $onMy->primaryLocal ?>admin/approve/produkaff?id=<?php echo $value['id'] ?>&id_komunitas=<?php echo $_SESSION['bisnis_kategori_combi'] ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>&price=<?php echo $value['harga'] ?>&status=2&komisi=<?php echo $value['komisi'] ?>&aff=<?php echo $value['id_aff'] ?>">Tolak</a>
                                      <?php endif ?>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <?php
                                    echo $email;
                                    echo $nowa;
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if($produkIni['type'] == 'non'){
                                      echo "<span class='badge badge-warning'>Produk Digital</span>";
                                    }else{
                                      echo "<span class='badge badge-info'>Produk Fisik</span>";
                                    }
                                    echo $type.'<br>'.$produkIni['judul'];
                                  ?>
                                </td>
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
                    <!-- /.card-body -->
                  </div>

                  
                </div>
                <div class="chart tab-pane active" id="revenue-chart">

                  <div class="card card-warning collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">Affiliate Produk</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body border" style="display:none;">
                      <b>Buat Produkmu yang ingin di Affiliatekan</b>
                      <hr>
                      <form action="" method="post">
                        <?php $onMy->inputRedirectFull() ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Judul</label>
                              <input type="text" class="form-control" name="judul" required maxlength="70">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Note</label>
                              <textarea name="note" class="form-control"></textarea maxlength="200">
                            </div>
                          </div>
                         
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Type Produk</label>
                              <select class="form-control" onchange="return produkType()" id="typeProduk" name="type_produk">
                                <option value="fisik">Produk Fisik</option>
                                <option value="non">Produk Non-Fisik</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Nilai</label>
                              <select class="form-control" onchange="return nilaiType()" id="nilai" name="nilai">
                                <option value="berbayar">Berbayar</option>
                                <option value="gratis">Gratis</option>
                              </select>
                              <small>Jika Gratis dipilih, Field Harga dan Komisi akan di abaikan </small>
                            </div>
                          </div>
                          <div class="col-md-3 harga">
                            <div class="form-group">
                              <label>Harga</label>
                              <input type="number" class="form-control harga" name="harga" maxlength="10">
                            </div>
                          </div>
                          <div class="col-md-3 komisi">
                            <div class="form-group">
                              <label>Komisi</label>
                              <input type="number" class="form-control komisi" name="komisi" maxlength="10">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Fields Form</label>
                              <select class="select2bs4" multiple="multiple" data-placeholder="Pilih field untuk form order" style="width: 100%;" name="fields_form[]">
                                <option value="domisili">DOMISILI</option>
                                <option value="alamat">ALAMAT</option>
                                <option value="kode_pos">KODE POS</option>
                                <option value="jk">JK</option>
                                <option value="rentang_usia">RENTANG USIA</option>
                                <option value="catatan">CATATAN</option>
                              </select>
                              <small>
                                <ul>
                                  <li>Nama, Email dan No Wa adalah Field Default yang pasti Ada</li>
                                  <li>Jika produk fisik, disarankan memilih Kota/domisili, Kode Pos, Alamat Lengkap dan Catatan</li>
                                  <li>Jika produk non-fisik, disarankan memilih Kota/domisili saja</li>
                                </ul>
                              </small>
                            </div>
                          </div>
                          <div class="col-md-6 hidlink hide">
                            <div class="form-group">
                              <label>Url</label>
                              <input type="text" class="form-control" name="url" placeholder="link untuk produk non fisik yang kamu jual">
                              <small>Link untuk produk non fisik yang kamu jual, seperti link google drive etc..</small>
                            </div>
                          </div> 
                          <div class="col-md-4">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="cprivate" name="cprivate">
                              <label class="custom-control-label" for="cprivate">Jika diaktifkan produk ini tidak bisa di affiliatekan oleh member komunitas Anda</label>
                            </div>
                          </div> 
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Header</label>
                              <textarea name="header" class="form-control" placeholder="..."></textarea>
                              <small>Ketika Member membuka/mengunjungi memberarea komunitasmu, kode/pixel ini akan tertrigger</small>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <button type="submit" name="submitBisnisAffiliate" class="btn btn-warning btn-block">Simpan ..</button>
                          </div>
                          <div class="col-md-12">
                            <hr>
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered dt">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Type Produk</th>
                                    <th>Harga</th>
                                    <th>Komisi</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no=1; $affiliateProduk = $onMy->selectWithBussiness('affiliate_produk', $_SESSION['bisnis_kategori_combi']); foreach($affiliateProduk as $value): ?>
                                    <tr>
                                      <td><?php echo $no++; ?></td>
                                      <td><?php echo $value['judul']; ?></td>
                                      <td><?php echo ($value['type'] == 'fisik') ? 'Fisik' : 'Non-Fisik'; ?></td>
                                      <td>Rp<?php echo ($value['nilai'] == 'berbayar') ? $onMy->nf($value['harga']) : 'Gratis' ; ?></td>
                                      <td>Rp<?php echo ($value['nilai'] == 'berbayar') ? $onMy->nf($value['komisi']) : '-' ; ?></td>
                                      <td>
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
                                            <span class="sr-only"></span>
                                          </button>
                                          <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>admin/bisnis/affiliate/edit?id=<?php echo $value['id'] ?>" target="_blank"><i class="fa fa-edit"></i> Edit</a>
                                            <a class="dropdown-item" onclick="return confirm('Yakin menghapus produk ini ?, semua data yang berkaitan dengan ini akan hilang juga !')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('affiliate_produk') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>"><i class="fa fa-trash"></i> Hapus</a>
                                          </div>
                                        </div>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <br>
                  <hr>
                  <br>
                  <div class="col-md-12" style="height: 400px; overflow:scroll;">
                    <h4>Link Affiliate Komunitas</h4>

                      <?php 
                        $no=1; foreach ($onMy->select('komunitas_bisnis',$_COOKIE['id_akun_combi']) as $komunitas):
                      ?>
                        <span><?php echo $no++; ?>. Affiliate Komunitas </span><b><?php echo $komunitas['nama_komunitas'] ?></b>
                        <div class="border border-warning p-1 text-dark text-sm p-3">
                            <small>Komisi <b>Rp<?php echo number_format($komunitas['komisi_affiliate_join']) ?> harus diberikan pada Affilaite</b> setiap kali ada seseorang yang bergabung ke Komunitas <b><?php echo $komunitas['nama_komunitas'] ?></b> lewat para Affilaite Anda</small>
                        </div>
                        <div class="input-group dropup mb-3">
                          <div class="input-group-prepend dropup ">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Action
                            </button>
                            <div class="dropdown-menu dropup " style="">
                              <a class="dropdown-item" href="<?php echo $onMy->primaryLocal.'daftar?cd='.$komunitas['code_komunitas'].'&aff='.$profile['kode_affiliate'] ?>" target="_blank">Buka Link</a>
                              <a class="dropdown-item" href="#textsss" onclick="return copyText('xtext<?php echo $no?>')">Copy Link</a>
                            </div>
                          </div>
                          <!-- /btn-group -->
                          <input required type="text" class="form-control" value="<?php echo $onMy->primaryLocal.'daftar?cd='.$komunitas['code_komunitas'].'&aff='.$profile['kode_affiliate'] ?>" id="xtext<?php echo $no?>">
                        </div>
                        <hr>
                      <?php endforeach ?>
                      <hr>
                      <h4>Link Affilaite Produk</h4>
                      <?php $no=1; foreach ($onMy->selectWithBussiness('affiliate_produk', $_SESSION['bisnis_kategori_combi']) as $val): ?>
                        <b><?php echo $no++.'. '.$val['judul'] ?></b>
                        <div class="border border-warning p-1 text-dark text-sm p-3">
                          <?php echo $val['note'] ?><br>
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
                        <hr>

                      <?php endforeach ?>
                    </div>  
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
  <!-- /.content -->
</div>

  <script>
    document.title = 'KOMBI | Dashboard Affiliate <?php echo $profileKomunitas['nama_komunitas'] ?>';

    var menuaddclass = document.getElementById("bisnis");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("affiliate");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("bisnis-open");
    menuaddclass3.classList.add("menu-open");



    function formResiAff(id){
      $('#param').val('1');
      $('#hidid').val(id);
      $('#haff').hide();
      $('#modalResi').modal('show');
    }
    
  </script>
<?php
  require('footer.php');
?>