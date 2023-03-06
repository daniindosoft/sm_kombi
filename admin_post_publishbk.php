<?php
  require('header_user.php');
  $sql = 'select count(id) as total from post where id_user = '.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and ';
  
  $sql2 = 'select count(id) as total from post where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and ';

  $jmlPost = $onMy->eksekusiShow($sql.' status= "publish" ')['total'];
  $jmlPostDraft = $onMy->eksekusiShow($sql.' status= "draft" ')['total'];
  $jmlPostDelay = $onMy->eksekusiShow($sql.' status= "delay" ')['total'];

  $jmlPostAllDelay = $onMy->eksekusiShow($sql2.' status= "delay" ')['total'];

  $status = $_GET['status'];
  if ($_GET['status'] == 'publish') {
    $status = 'publish';
    $jmlPostParam = $jmlPost;
  }elseif($_GET['status'] == 'draft'){
    $jmlPostParam = $jmlPostDraft;
  }elseif($_GET['status'] == 'delay'){
    $jmlPostParam = $jmlPostDelay;
  }

  $onMy->registerGeneratePaginate(20, $_GET['halaman'], $jmlPostParam);

  $loopPost = $onMy->getPosts($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'],$status,'desc',10);
  if ($_GET['status'] == 'delay') {
    $loopPost = $onMy->tampil_manual('select * from post where status = "delay" and id_komunitas_bisnis = "'.$_SESSION['bisnis_kategori_combi'].'" order by id desc ');
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php if ($_GET['status'] == 'draft'): ?>
              <h1>Postingan Draft Saya</h1>
            <?php else: ?>
              <h1>Postingan Saya</h1>
            <?php endif ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Compose</li>
            </ol>
          </div>
          <?php if (isset($_GET['info'])): ?>
            <div class="col-sm-12">
              <br>
              <?php if ($_GET['info'] == 'berhasil'): ?>
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                </div>
              <?php endif ?>
              <?php if ($_GET['info'] == 'gagal'): ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Terdapat kesalahan !</h5>
                </div>
              <?php endif ?>
            </div><!-- /.col -->
          <?php endif; ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="<?php echo $onMy->primaryLocal; ?>admin/post" class="btn btn-warning btn-block mb-3">Buat Post</a>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Menu</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item " id="jumlah-post">
                    <a href="<?php echo $onMy->primaryLocal ?>admin/post/publish?status=publish" class="nav-link">
                      <i class="fas fa-file"></i> Postingan saya
                      <span class="badge bg-warning float-right"><?php echo ($jmlPost) ? $jmlPost : ''; ?></span>
                    </a>
                  </li>
                  <?php if ($profile['type_user'] == 'admin'): ?>
                    <li class="nav-item" id="jumlah-periksa">
                      <a href="<?php echo $onMy->primaryLocal ?>admin/post/publish?status=delay" class="nav-link">
                        <i class="fa fa-spin fa-spinner"></i> Perlu di periksa
                        <span class="badge bg-success float-right"><?php echo ($jmlPostAllDelay) ? $jmlPostAllDelay : ''; ?></span>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($profile['type_user'] == 'user'): ?>
                    <li class="nav-item" id="verif">
                      <a href="<?php echo $onMy->primaryLocal ?>admin/post/publish?status=delay" class="nav-link">
                        <i class="fa fa-spin fa-spinner"></i> Belum diverifikasi
                        <span class="badge bg-success float-right"><?php echo ($jmlPostDelay) ? $jmlPostDelay : ''; ?></span>
                      </a>
                    </li>
                  <?php endif ?>
                  <li class="nav-item" id="jumlah-draft">
                    <a href="<?php echo $onMy->primaryLocal ?>admin/post/publish?status=draft" class="nav-link">
                      <i class="far fa-file-alt"></i> Drafts
                      <span class="badge bg-info float-right"><?php echo ($jmlPostDraft) ? $jmlPostDraft : ''; ?></span>
                    </a>
                  </li>
                  
                </ul>
              </div>
              <!-- /.card-body -->
            </div> 
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <?php if ($_GET['status'] == 'delay'): ?>
              <?php if ($profile['type_user'] =='user'): ?>
                <h4>Postingan belum diverifikasi oleh Admin</h4>
                <p>Postingan ini belum di publish karena Admin belum menyetujui postingan berikut ini</p>
              <?php else: ?>
                <h4>Postingan perlu diverifikasi oleh Admin(Anda)</h4>
                <p>Postingan ini belum di publish karena Admin(Anda) belum menyetujui postingan berikut ini</p>
              <?php endif; ?>
            <?php endif; ?>
            <?php if ($_GET['status'] == 'publish'): ?>
              <h4>Postingan yang sudah di publish</h4>
              <p>Postingan ini sudah di publish</p>
            <?php endif; ?>
            <?php if ($_GET['status'] == 'draft'): ?>
              <h4>Postingan Draft</h4>
              <p>Postingan ini belum di publish karena masih draft</p>
            <?php endif; ?>
            <?php 
              $no=1; 
              foreach ($loopPost as $value): 
                $no++; 
                $user = $onMy->single('users', $value['id_user']);
            ?>
              <div class="card card-widget collapsed-card">
                <div class="card-header">
                  <div class="user-block">
                    <img class="img-circle" src="<?php echo $onMy->dp($user['dp']) ?>" alt="User Image">
                    <span class="username"><a href="#"><?php echo $user['nama_lengkap'] ?></a></span>
                    <span class="description">
                      <?php echo $value['judul'] ?> - 
                      <?php 
                        echo $onMy->convertDate('d F Y - H:i', $value['created_at']);
                      ?>
                    </span>
                  </div>
                  <!-- /.user-block -->
                  <div class="card-tools">
                    <?php if ($_GET['status'] == 'delay'): ?>
                      <a href="#" onclick="return redirect('<?php echo $onMy->primaryLocal ?>admin/post/acc?url=<?php echo $onMy->thisUrl('noparam'); ?>&id=<?php echo $value['id'] ?>', 'q')" class="float-right btn btn-sm btn-warning"><i class="fa fa-check"></i> Publish</a>
                    <?php endif; ?>
                    <?php if ($_GET['status'] == 'draft'): ?>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <a href="#" onclick="return redirect('<?php echo $onMy->primaryLocal ?>admin/post/edit?id=<?php echo $value['id'] ?>')" class="float-right"><i class="fa fa-pencil-alt"></i> Edit</a>
                    </button>
                    <?php endif ?>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                    <?php if ($_GET['status'] == 'delay'): ?>
                      <a onclick="return confirm('Menolak postingan ini maka postingan akan di hapus, yakin ?')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('post') ?>&url=<?php echo $onMy->thisUrl('noparam') ?>&tolak=ok" class="btn btn-tool">
                        <i class="fa fa-trash"></i> Tolak
                      </a>
                    <?php else: ?>
                      <a onclick="return confirm('Yakin menghapus Postingan ini ?, Komentar dan like akan hilang juga')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('post') ?>&url=<?php echo $onMy->thisUrl() ?>" class="btn btn-tool">
                        <i class="fa fa-trash"></i>
                      </a>
                    <?php endif ?>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <?php echo $value['text'] ?>
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
                            <span class="text-muted float-right"><?php echo $onMy->convertDate('d F Y - H:i', $val['created_at']); ?></span>
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
                      <a href=""><i class="fa fa-comment"></i> Komentar lainnya...</a>
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
            <?php endforeach ?>
            <?php if ($no == 1): ?>
            
              <div class="alert alert-info">Tidak ada postingan</div>
            <?php else: ?>

              <?php 

                $onMy->generatePaginate();
              ?>
            <?php endif ?>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script>
    document.title = "KOMBI | Post <?php echo $namaKomunitas ?>";
    
    var menuaddclass = document.getElementById("posting");
    menuaddclass.classList.add("active");

    var menuaddclass2 = document.getElementById("post");
    menuaddclass2.classList.add("active");

    var menuaddclass3 = document.getElementById("post-open");
    menuaddclass3.classList.add("menu-open");


    <?php if ($_GET['status'] == 'draft'): ?>
      var menuflex = document.getElementById("jumlah-draft");
    <?php elseif($_GET['status'] == 'publish'): ?>
      var menuflex = document.getElementById("jumlah-post");
    <?php endif; ?>
    menuflex.classList.add("active");
  </script>
<?php
  require('footer.php');
?>
