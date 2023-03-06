<?php
  require('header.php');
  // $onMy->debug = true;
  $user = $onMy->eksekusiShow('select * from users where username = "'.$_GET['u'].'"');
  // echo 'select * users where username = "'.$_GET['u'].'"';
  $dataAffiliate = $onMy->getDataAffiliate($user['id'], $_SESSION['bisnis_kategori_combi']);

?>

<div class="content-wrapper" style="min-height: 1604.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-warning card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $user['dp'] ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $user['nama_lengkap'] ?></h3>

                <p class="text-muted text-center"><?php echo $user['email'] ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Postingan</b> <a class="float-right"><?php echo $onMy->countUserPosts($user['id'], $_SESSION['bisnis_kategori_combi']) ?></a>
                  </li>
                  <?php 
                    if ($user['is_private'] != '1' || $profile['type_user'] == 'admin'){
                    
                  ?>
                    <li class="list-group-item">
                      <b>Affiliate</b> <a class="float-right"><?php echo $dataAffiliate['total_lead'] ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Dropship/Reseller</b> <a class="float-right"><?php echo ($onMy->countOrderDropRes($user['id'], $_SESSION['bisnis_kategori_combi'])['total_lead']) ? $onMy->countOrderDropRes($user['id'], $_SESSION['bisnis_kategori_combi'])['total_lead'].' Trans..' : '0 Trans..' ?></a>
                    </li>
                  <?php } ?>
                </ul>

                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Domisili</strong>

                <p class="text-muted">
                  <?php echo $user['domisili'] ?>
                </p>

                <hr>

                <strong><i class="fa fa-user mr-1"></i> Jenis Kelamin</strong>

                <p class="text-muted"><?php echo $user['jk'] ?></p>

                <hr>
                <?php
                  if ($user['is_private'] != '1' || $profile['type_user'] == 'admin'){
                ?>
                  <strong><i class="fas fa-phone mr-1"></i> Kontak</strong>

                  <p class="text-muted">
                    <?php echo $user['nowa'] ?>
                  </p>

                  <hr>

                  <strong><i class="fa fa-calendar mr-1"></i> Tanggal Lahir</strong>

                  <p class="text-muted">
                    <?php echo $user['tgl_lahir'].' ; '.round($onMy->dateDiffInDays($user['tgl_lahir'], date('2022-12-20'))/360); ?> Tahun
                  </p>
                <?php } ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Aktivitas</a></li>
                  <?php
                    if ($profile['type_user'] == 'admin'){
                  ?>
                    <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Lainnya</a></li> -->
                  <?php } ?>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <?php 
                      $no=1; 
                      // $onMy->orderBy = true;
                      $onMy->limit = 20;

                      $data = $onMy->eksekusiShow('select count(id) as total from post where id_user='.$user['id'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and status="publish"')['total'];

                      $onMy->registerGeneratePaginate(20, $_GET['halaman'], $data);

                      $postPaginate = $onMy->tampil_manual('select * from post where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and status="publish" and id_user='.$user['id'].' order by created_at desc limit '.$onMy->halaman_awal.', '.$onMy->batas);

                      // foreach ($onMy->selectWithBussiness('post',$_SESSION['bisnis_kategori_combi'],'publish') as $value): $no++; 
                      foreach ($postPaginate as $value): $no++; 
                        $postBy = $onMy->thisProfile($value['id_user']);
                    ?>
                      <div class="card card-widget yellow-border">
                        <div class="card-header">
                          <div class="user-block">
                            <img class="img-circle" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $postBy['dp'] ?>" alt="User Image">
                            
                            <span class="username"><a href="<?php echo $onMy->primaryLocal ?>view/user/?u=<?php echo $postBy['username'] ?>">

                            <?php 
                              if ($postBy['type_user'] == 'admin') {
                                echo '<i class="far fa-check-circle fa-sm text-primary" title="Admin"></i> ';
                              }
                              if ($postBy['id'] == $_COOKIE['id_akun_combi']) {
                                echo 'Anda';
                              }else{
                                echo '<span class="text-dark">'.$postBy['nama_lengkap']."</span>";
                              }
                            ?>
                            </a></span>
                            <span class="description">
                              <?php echo $value['judul'] ?> - 
                              <?php 
                                echo $onMy->time_elapsed_string($value['created_at']);
                              ?>
                            </span>
                          </div>
                          <!-- /.user-block -->
                          <div class="card-tools">
                            <?php if ($_GET['status'] == 'draft'): ?>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <a href="#" onclick="return redirect('<?php echo $onMy->primaryLocal ?>admin/post/edit?id=<?php echo $value['id'] ?>')" class="float-right"><i class="fa fa-pencil-alt"></i> Edit</a>
                            </button>
                            <?php endif ?>
                            
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                          <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <?php echo $value['text'] ?>
                          <hr>
                          <button type="button" onclick="return share('<?php echo $onMy->primaryLocal ?>public/post?id=<?php echo $value['id'] ?>')" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                          <?php 
                            $class = '';
                            $disable = '';
                            if ($onMy->isLiked( $value['id'], $_COOKIE['id_akun_combi']) == true){
                              $class = 'text-warning';
                              $disable = 'disabled title="kamu telah menyukai ini"';
                            }
                          ?>
                          <button type="button" <?php echo $disable ?> class="<?php echo $class ?> btn btn-default btn-sm like<?php echo $no ?>" onclick="return btnLike(<?php echo $no ?>, <?php echo $_COOKIE['id_akun_combi'] ?>, <?php echo $value['id'] ?>)" ><i class="ion ion-thumbsup"></i> Like</button>
                          <span class="float-right text-muted"><?php echo $value['jumlah_like'] ?> likes - <?php echo $value['jumlah_komen'] ?> comments</span>
                        </div>
                        <?php if ($_GET['status'] == 'publish' || empty($_GET['status']) ): ?>
                          <div class="card-footer card-comments">
                            <?php foreach ($onMy->getKomentarByPost($value['id'], 10) as $val): ?>
                              <!-- 'select * from komentar as k join users as u on k.id_user = u.id where k.id_post="'.$value['id'].'" limit 10' -->
                              <div class="card-comment">
                                <img class="img-circle img-sm" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $onMy->thisProfile($val['id_user'])['dp'] ?>" alt="User Image">
                                <div class="comment-text">
                                  <span class="username">
                                    <?php if ($val['id_user'] == $_COOKIE['id_akun_combi'] ): ?>
                                      Anda
                                    <?php else: ?>
                                      <?php echo $val['nama_lengkap'] ?>
                                    <?php endif; ?>
                                    <span class="text-muted float-right"><?php echo $onMy->time_elapsed_string($val['created_at']); ?></span>
                                  </span><!-- /.username -->
                                  <?php echo $onMy->extractComment($val['komentar']) ?><br>
                                  <a href="#s" onclick="return markComment(<?php echo $val['id'] ?>, <?php echo $no; ?>, '<?php echo $val['nama_lengkap'] ?>','<?php echo $val['id_user'] ?>')"><small>Balas..</small></a>
                                </div>
                                <!-- /.comment-text -->
                              </div>
                            <?php endforeach ?>
                            <!-- /.card-comment -->
                          </div>
                          <!-- /.card-footer -->
                          <div class="card-footer">
                            <?php if ($value['jumlah_komen'] > 10): ?>
                              <a href="<?php echo $onMy->primaryLocal ?>post/read?id=<?php echo $value['id'] ?>" class="text-sm"><i class="fa fa-comment"></i> Komentar lainnya...</a>
                              <br>
                              <br>
                            <?php endif ?>
                            <form action="" method="post">
                              <?php echo $onMy->inputRedirectFull() ?>
                              <input type="hidden" name="id_post" value="<?php echo $value['id'] ?>">
                              <img class="img-fluid img-circle img-sm" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $onMy->thisProfile($_COOKIE['id_akun_combi'])['dp'] ?>" alt="Alt Text">
                              <!-- .img-push is used to add margin to elements next to floating images -->
                              <div class="img-push">
                                <div class="input-group input-group-sm">
                                  <input type="hidden" name="id_balas" class="id_balas<?php echo $no ?>">
                                  <input type="text" class="form-control" name="komentar" placeholder="tulis komentar disini" required>
                                  <span class="input-group-append">
                                    <button type="submit" name="submitKomentar" class="btn btn-warning btn-flat">Komentari</button>
                                  </span>
                                </div>
                              </div>
                              <small class="display-balas b<?php echo $no; ?>"></small>
                            </form>
                          </div>
                        <?php endif; ?>
                        <!-- /.card-footer -->
                      </div>
                    <?php 
                      endforeach;
                      if ($no == 1) {
                        echo "<div class='alert alert-info'><i class='fa fa-check-circle'></i> <b>Opps!</b>, Belum ada postingan di komunitas ini</div>";
                      }

                    ?>
                    <?php 
                      $onMy->generatePaginate();
                    ?>
                  </div>
                  <?php
                    if ($profile['type_user'] == 'admin'){
                  ?>
                    <div class="tab-pane" id="settings">
                      <!-- menampilkan total traksaksi, transaksi hari ini, (pokonya dashboard user dia di buatkan disini bisa di liha admin).
                      total transaksi semua, total lead, dropship transaksi, dll. -->
                     
                    </div>
                  <?php } ?>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script type="text/javascript">
    document.title = "KOMBI | View Profile Member";

    var menuaddclass = document.getElementById("membership");
    menuaddclass.classList.add("active");

  </script>
<?php
  require('footer.php');
?>
