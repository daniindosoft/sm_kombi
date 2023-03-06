<?php
  require('header_user.php');
  $onMy->verifDataOwned('post', 'id',  $onMy->toInt($_GET['id']));
    
  $sql = 'select count(id) as total from post where id_user = '.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and ';

  $jmlPost = $onMy->eksekusiShow($sql.' status= "publish" ')['total'];
  $jmlPostDraft = $onMy->eksekusiShow($sql.' status= "draft" ')['total'];
  $getData = $onMy->single('post', $onMy->toInt($_GET['id']));

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Post</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Post</li>
            </ol>
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
        <div class="row">
          <div class="col-md-3">
            <a href="mailbox.html" class="btn btn-warning btn-block mb-3">Beranda</a>

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
                    <a href="<?php echo $onMy->primaryLocal ?>user/post/publish?status=publish" class="nav-link">
                      <i class="fas fa-file"></i> Postingan saya
                      <span class="badge bg-warning float-right"><?php echo $jmlPost ?></span>
                    </a>
                  </li>
                  <li class="nav-item" id="jumlah-periksa">
                    <a href="<?php echo $onMy->primaryLocal ?>user/post/publish?status=delay" class="nav-link">
                      <i class="far fa-envelope"></i> Perlu di periksa
                    </a>
                  </li>
                  <li class="nav-item" id="jumlah-draft">
                    <a href="<?php echo $onMy->primaryLocal ?>user/post/publish?status=draft" class="nav-link">
                      <i class="far fa-file-alt"></i> Drafts
                      <span class="badge bg-info float-right"><?php echo $jmlPostDraft ?></span>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div> 
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <form method="post" action="">
              <?php $onMy->inputRedirectFull('id') ?>
              <input type="hidden" name="type_akun" value="<?php echo $profile['type_user'] ?>">
              
              <div class="card card-success card-outline">
                <div class="card-header">
                  <h3 class="card-title">Edit Ponstinganmu</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group">
                    <input class="form-control" placeholder="Judul Post" name="judul" required value="<?php echo $getData['judul'] ?>">
                  </div>
                  <div class="form-group">
                      <textarea id="compose-textarea" class="form-control" name="text" style="height: 300px" required><?php echo $getData['text'] ?></textarea>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="float-right">
                    <button type="submit" class="btn btn-default" name="updatePostDraf"><i class="fas fa-pencil-alt"></i> Perbarui Draft</button>
                    <button type="submit" class="btn btn-success" name="updatePost"><i class="far fa-envelope"></i> Posting</button>
                  </div>
                </div>
                <!-- /.card-footer -->
              </div>
            </form>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script>
    var menuaddclass = document.getElementById("posting");
    menuaddclass.classList.add("active");

    var menuaddclass2 = document.getElementById("post");
    menuaddclass2.classList.add("active");

    var menuaddclass3 = document.getElementById("post-open");
    menuaddclass3.classList.add("menu-open");

    var menuflex = document.getElementById("jumlah-draft");
    menuflex.classList.add("active");
  </script>
<?php
  require('footer.php');
?>
