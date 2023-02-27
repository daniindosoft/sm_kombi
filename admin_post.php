<?php
  require('header.php');
  $sql = 'select count(id) as total from post where id_user = '.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and ';
  
  $sql2 = 'select count(id) as total from post where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and ';

  $jmlPost = $onMy->eksekusiShow($sql.' status= "publish" ')['total'];
  $jmlPostDraft = $onMy->eksekusiShow($sql.' status= "draft" ')['total'];
  $jmlPostDelay = $onMy->eksekusiShow($sql.' status= "delay" ')['total'];

  $jmlPostAllDelay = $onMy->eksekusiShow($sql2.' status= "delay" ')['total'];

  if (empty($_GET['status'])) {
    $status = 'publish';
  }else{
    $status = $_GET['status'];
  }

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
          <div class="col-sm-12">
            <?php $onMy->callFlash() ?>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if ($_SESSION['bisnis_kategori_combi']): ?>
      
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
                  <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-bell"></i> Notifikasi
                      <span class="badge bg-warning float-right">65</span>
                    </a>
                  </li>  -->
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
            <form method="post" action="">
              <input type="hidden" name="type_akun" value="<?php echo $profile['type_user'] ?>">
              <?php $onMy->inputRedirectFull() ?>
              <div class="card card-warning card-outline">
                <div class="card-header">
                  <h3 class="card-title">Tulis Ponstinganmu</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group">
                    <input class="form-control" placeholder="Judul Post" name="judul" required maxlength="70">
                  </div>
                  <div class="form-group">
                      <textarea id="compose-textarea" class="form-control" name="text" style="height: 300px" required>
                        <br>
                        <br>
                      </textarea>
                      <small>*Postingan yang sudah di posting tidak bisa di edit</small>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="float-right">
                    <button type="submit" class="btn btn-default" name="submitPostDraf"><i class="fas fa-pencil-alt"></i> Jadikan Draft</button>
                    <button type="submit" class="btn btn-warning" name="submitPost"><i class="far fa-envelope"></i> Posting</button>
                  </div>
                </div>
                <!-- /.card-footer -->
              </div>
            </form>
              
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <?php else: ?>
    <div class="alert alert-info">
      <i class="fa fa-info-circle"></i> Opps !, Anda tidak ada di komunitas atau tidak terdaftar di komunitas manapun
    </div>
    <?php endif; ?>
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
