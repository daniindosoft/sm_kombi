<?php
  require('header_user.php');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Beranda <?php echo $komunitas['nama_komunitas'] ?></h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <!-- post -->
    <div class="row">
      <div class="col-md-12 col-sm-12 col-12">
        <h4>Pintasan</h4>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <a href="<?php echo $onMy->primaryLocal ?>user/rule">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fa fa-bookmark"></i></span>
            <div class="info-box-content">
              <h5 class="info-box-text">Rule & Ketentuan</h5>
            </div>
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <?php if ($komunitas['is_affiliate'] != 1): ?>
        <div class="col-md-3 col-sm-6 col-12">
          <a href="<?php echo $onMy->primaryLocal ?>user/bisnis/affiliate">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fa fa-users"></i></span>
              <div class="info-box-content">
                <h4 class="info-box-text">Affiliate</h4>
              </div>
            </div>
          </a>
        </div>
      <?php endif; ?>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <a href="<?php echo $onMy->primaryLocal ?>user/post">
          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-file"></i></span>
            <div class="info-box-content">
              <h4 class="info-box-text">Post</h4>
            </div>
          </div>
        </a>
      </div>
      <!-- /.col -->
      <?php if ($komunitas['is_affiliate'] != 1): ?>
        <div class="col-md-3 col-sm-6 col-12">
          <a href="<?php echo $onMy->primaryLocal ?>user/bisnis/penarikan">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fa fa-money-bill"></i></span>
              <div class="info-box-content">
                <h5 class="info-box-text">Penarikan Komisi</h5>
              </div>
            </div>
          </a>
        </div>
      <?php endif ?>
      <!-- /.col -->
    </div>
    <div class="col-md-12 col-sm-12 col-12">
      <h4>Post Komunitas</h4>
    </div>
      <?php 
        $no=1; 
        // $onMy->orderBy = true;
        $onMy->limit = 20;

        $data = $onMy->eksekusiShow('select count(id) as total from post where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and status="publish"')['total'];

        $onMy->registerGeneratePaginate(20, $_GET['halaman'], $data);

        $postPaginate = $onMy->tampil_manual('select * from post where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and status="publish" order by created_at desc limit '.$onMy->halaman_awal.', '.$onMy->batas);

        // foreach ($onMy->selectWithBussiness('post',$_SESSION['bisnis_kategori_combi'],'publish') as $value): $no++; 
        foreach ($postPaginate as $value): $no++; 
          $postBy = $onMy->thisProfile($value['id_user']);
      ?>
        <div class="card card-widget yellow-border">
          <div class="card-header">
            <div class="user-block">
              <img class="img-circle" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $postBy['dp'] ?>" alt="User Image">
              <span class="username"><a href="<?php echo $onMy->primaryLocal ?>view/user?u=<?php echo $postBy['username'] ?>">
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
                    <input type="text" class="form-control" name="komentar" placeholder="tulis komentar disini, INGAT ! Komentar tidak bisa di edit/hapus, berkomentarlah dengan bijak" required>
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

    <!-- post -->
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
    document.title = "KOMBI | Beranda <?php echo $komunitas['nama_komunitas'] ?>";

    var menuaddclass3 = document.getElementById("home");
    menuaddclass3.classList.add("active");

    function gulung(){
      $('.card-widget').toggleClass('collapsed-card');
    }
    function btnLike(btn, id_user, id_post){
      $('.like'+btn).css('color','rgb(217 164 4)');
      $('.like'+btn).attr('disabled', true);
      $.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'ajaxLikePost',
          "id_user":id_user,
          "id_post":id_post,
        },
        success: function(a) {
          console.log(a);
        }
      });
    }
</script>
<?php
  require('footer.php');
?>