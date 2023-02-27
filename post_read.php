<?php
  require('header.php');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Beranda <?php echo $profileKomunitas['nama_komunitas'] ?></h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
      <?php 

        $value = $onMy->selectSingleOne('post', 'id', $_GET['id']);
        $postBy = $onMy->thisProfile($value['id_user']);
        $no=1;
      ?>
        <div class="card card-widget yellow-border">
          <div class="card-header">
            <div class="user-block">
              <img class="img-circle" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $postBy['dp'] ?>" alt="User Image">
              <span class="username"><a href="<?php echo $onMy->primaryLocal ?>user/profile?id=<?php echo $value['id_user'] ?>">
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
              <?php foreach ($onMy->getKomentarByPost($value['id'], 10000) as $val): ?>
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
  
    <!-- post -->
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
    document.title = 'KOMBI | Beranda Admin <?php echo $profileKomunitas['nama_komunitas'] ?>';
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

    function share(area){
  //       const navUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + 'https://github.com/knoldus/angular-facebook-twitter.git';
  // window.open(navUrl , '_blank');
      navigator.clipboard.writeText(area).then(() => {
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'Berhasil',
          subtitle: 'Copy Link To Share',
          body: 'Berhasil copy link, bagikan sekarang !'
        })
      },() => {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Opps',
          subtitle: 'Kesalahan',
          body: 'Maaf, gagal menyalin link, coba lagi nanti !'
        })
      });

    }
</script>
<?php
  require('footer.php');
?>