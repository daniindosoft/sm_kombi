<?php
  require('header_user.php');
  $profileView = $onMy->thisProfile($_GET['id']);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengaturan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>user/pengaturan">Pengaturan</a></li>
            </ol>
          </div><!-- /.col -->
          <?php $onMy->callFlash() ?>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
		  <div class="container-fluid">
		    <div class="row">
		      <div class="col-md-3">

		        <!-- Profile Image -->
		        <div class="card card-warning card-outline">
		          <div class="card-body box-profile">
		            <div class="text-center">
		              <img class="profile-user-img img-fluid img-circle" src="<?php echo $onMy->primaryLocal ?>dist/img/avatar/<?php echo $onMy->thisProfile($_GET['id'])['dp'] ?>" alt="User profile picture">
		            </div>

		            <h3 class="profile-username text-center"><?php echo $profileView['nama_lengkap'] ?></h3>

		            <p class="text-muted text-center"><?php echo $profileView['domisili'] ?></p>

		            <ul class="list-group list-group-unbordered mb-3">
		              <li class="list-group-item">
		                <b>Followers</b> <a class="float-right">1,322</a>
		              </li>
		              <li class="list-group-item">
		                <b>Following</b> <a class="float-right">543</a>
		              </li>
		              <li class="list-group-item">
		                <b>Friends</b> <a class="float-right">13,287</a>
		              </li>
		            </ul>

		            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
		          </div>
		          <!-- /.card-body -->
		        </div>
		      
		      </div>
		    	<div class="col-md-9">
  		      <?php 
			        $no=1; 
            	foreach ($onMy->getPosts($_GET['id'], $_SESSION['bisnis_kategori_combi'],'publish','desc',10) as $value):
            		$no++; 
			          $postBy = $onMy->thisProfile($value['id_user']);
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
			                  echo $onMy->convertDate('d F Y - H:i', $value['created_at']);
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
			            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
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
			                    <input type="text" class="form-control" name="komentar" placeholder="tulis komentar disini, INGAT ! Komentar tidak bisa di edit/hapus, berkomentarlah dengan bijak">
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
		    	</div>
		    </div>
		    <!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
    <!-- /.content -->
  </div>
  
	<script>
		document.title = 'KOMBI | Profile User';
		var menuaddclass = document.getElementById("pengaturan");
		menuaddclass.classList.add("active");
 
	</script>
<?php
  require('footer.php');
?>