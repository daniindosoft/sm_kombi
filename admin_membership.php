<?php
  require('header.php');
  $getData = $onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi']);
  $jmlMember = $onMy->eksekusiShow('select count(*) as total from komunitas where status=1 and id_komunitas='.$_SESSION['bisnis_kategori_combi'])['total'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Member '<?php echo $getData['nama_komunitas'] ?>'</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?php echo $jmlMember; ?> Member</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-md-12">
            <?php $onMy->callFlash() ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <a href="<?php echo $onMy->primaryLocal ?>csv?q=users" target="_blank" download class="btn btn-sm btn-warning"><i class="fa fa-download"></i> Download Data Member</a>
              </div>
              <hr>
              <form action="" method="get">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" name="q" value="<?php echo @$_GET['q'] ?>" placeholder="cari nama member disini">
                  <span class="input-group-append">
                    <button type="submit" name="cariMember" class="btn btn-warning btn-flat">Cari Member</button>
                  </span>
                </div>
                <?php if ($_GET['q']): ?>
                  <p><b> Pencarian untuk : <?php echo $_GET['q'] ?> </b></p>
                <?php endif ?>
              </form>
              <small><code>*</code> Otomatis Diurutkan berdasarkan waktu Member bergabung</small>
              <hr>
            </div>
            <?php 
              
              $no=1; 
              // $onMy->orderBy = true;
              $onMy->limit = 20;

              $batas = 12;
              $halaman = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
              $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;  

              $previous = $halaman - 1;
              $next = $halaman + 1;

              $cari = '';
              if ($_GET['q']) {
                $batas = 24;
                $cari = " and (u.nama_lengkap like '%".$_GET['q']."%' OR u.email like '%".$_GET['q']."%' ) ";
              }

              $data = $onMy->eksekusiShow('select count(*) as total from users as u join komunitas as k on k.id_user = u.id where k.id_komunitas = '.$_SESSION['bisnis_kategori_combi'].' and k.status =1')['total'];

              $jumlah_data = $data;
              $total_halaman = ceil($jumlah_data / $batas);

              // $postPaginate = $onMy->tampil_manual('select * from post where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and status="publish" order by created_at desc limit '.$halaman_awal.', '.$batas);

              $postPaginate = $onMy->tampil_manual(' select *, k.id as idk, u.id as idu from users as u join komunitas as k on k.id_user = u.id where k.id_komunitas = '.$_SESSION['bisnis_kategori_combi'].' '.$cari.' and k.status =1 order by u.id desc limit '.$halaman_awal.', '.$batas);
              
              $nomor = $halaman_awal+1;

              
              foreach ($postPaginate as $val): 
                $dataAffiliate = $onMy->getDataAffiliateAdmin($val['idu'], $_SESSION['bisnis_kategori_combi']);

            ?>
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    <?php echo $val['username'] ?>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b><?php echo $val['nama_lengkap'] ?></b></h2>
                        <p class="text-muted text-sm"><b>E-Mail: </b> <?php echo $val['email'] ?></p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <?php echo $val['domisili'] ?></li>
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <?php echo $val['nowa'] ?></li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="<?php echo $onMy->primaryLocal.'dist/img/avatar/'.$val['dp'] ?>" alt="user-avatar" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-md-4 col-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header">Post</h5>
                          <span class="description-text"><small><?php echo $onMy->countUserPosts($val['idu'], $_SESSION['bisnis_kategori_combi']) ?></small></span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-4 col-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header">Affiliate</h5>
                          <span class="description-text"><small><?php echo $dataAffiliate['total_lead'] ?> Orang</small></span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-4 col-4">
                        <div class="description-block">
                          <h5 class="description-header">Dropship</h5>
                          <span class="description-text"><small><?php echo ($onMy->countOrderDropRes($val['idu'], $_SESSION['bisnis_kategori_combi'])['total_lead']) ? $onMy->countOrderDropRes($val['idu'], $_SESSION['bisnis_kategori_combi'])['total_lead'].' Transaksi' : 'Belum ada transaksi' ?> </small></span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                    <br>
                    <div class="text-right">
                      <a onclick="return msg('yakin mengeluarkan akun ini ?')" href="<?php echo $onMy->primaryLocal ?>view/user/kick?id=<?php echo $val['idk'] ?>&url=<?php echo $onMy->thisUrl() ?>?info=berhasil" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash-o"></i> Keluarkan
                      </a>
                      <a href="<?php echo $onMy->primaryLocal ?>view/user?u=<?php echo $val['username'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-user"></i> Lihat profile ..
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
            <hr>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="?halaman=1"><</a>
              </li>
              <li class="page-item">
                <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
              </li>
              <?php 
              $stopNumber = 0;
              for($x=$_GET['halaman'];$x<=$total_halaman;$x++){
                $stopNumber++;
                if ($stopNumber <= 7) {
              ?>
              <li class="page-item <?php echo ($x == 1 && empty($_GET['halaman'])) ? 'active':''; ?> <?php echo ($x == $_GET['halaman'] && !empty($_GET['halaman'])) ? 'active' : ''; ?>"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
              <?php
                  
                }
              ?> 
                <?php
              }
              ?>
              <?php if ($halaman != $total_halaman): ?>
                <li class="page-item"><a href="#ss" class="page-link">...</a></li>
              <?php endif ?>
              <li class="page-item">
                <a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?halaman=<?php echo $total_halaman ?>">></a>
              </li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

  <script>
    document.title = "KOMBI | Member dari <?php echo $namaKomunitas ?>";

    var menuaddclass = document.getElementById("membership");
    menuaddclass.classList.add("active");
  </script>
<?php
  require('footer.php');
?>
