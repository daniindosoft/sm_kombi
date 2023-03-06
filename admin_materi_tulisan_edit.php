<?php
  require('header.php');
  $onMy->verifDataOwned('tulisan', 'id',  $onMy->toInt($_GET['id']));
  
  $getData = $onMy->single('tulisan', $onMy->toInt($_GET['id']));

	$ecourseKategori = $onMy->selectWithBussiness('kategori_tulisan', $_SESSION['bisnis_kategori_combi']);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fa fa-pencil-alt"></i> Edit Materi Tulisan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Post</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/materi_tulisan">Materi Tulisan</a></li>
              <li class="breadcrumb-item"><a href="#">Edit</a></li>
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
      <div class="container-fluid">
				<div class="container-fluid">
	        <div class="row">
	          <!-- left column -->
	          <div class="col-md-12">
	            <!-- general form elements -->
	            <div class="card card-success">
	              <div class="card-header">
	                <h3 class="card-title">Edit Materi Tulisan</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-success card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Materi Tulisan</a>
			                  </li>
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane show active fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
			                  	<form action="" method="post">
			                  		<?php $onMy->inputRedirectFull('id') ?>
				                  	<div class="row">
				                  		<div class="col-md-6">
						                  	<div class="form-group">
							                    <label for="">Judul</label>
							                    <input type="text" maxlength="100" required class="form-control" name="judul" placeholder="judul atau nama ecourse" value="<?php echo $getData['judul'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-6">
						                  	<div class="form-group">
							                    <label for="">Kategori Materi Tulisan</label>
							                    <select class="form-control" name="kategori">
							                    	<?php foreach ($ecourseKategori as $value): ?>
								                    	<option <?php echo ($getData['id_kategori_tulisan'] == $value['id']) ? 'selected' : ''; ?> value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
							                    	<?php endforeach ?>
							                    </select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-12">
							                  <div class="form-group">
							                    <label for="">Deskripsi</label>
							                    <textarea name="deskripsi" rows="3" class="form-control editor-input"><?php echo $getData['text'] ?></textarea>
							                    
							                  </div>
						                  </div>
				                  		<div class="col-md-12">
							                  <button type="submit" name="updateMateriTulisan" class="btn btn-success btn-block btn-sm">Simpan Materi Tulisan</button>
					                  	</div>
				                  	</div>
			                  	</form>
			                  </div>
			                   
			                </div>
			              </div>
			              <!-- /.card -->
			            </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  
                </div>
	            </div>
	            <!-- /.card -->
	          </div>
	          <!--/.col (right) -->
	        </div>
	      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
	<script>
		document.title = "KOMBI | Atur Materi Tulisan <?php echo $namaKomunitas ?>";
		    var menuaddclass = document.getElementById("post");
    menuaddclass.classList.add("active");

		var menuaddclass = document.getElementById("materi_tulisan");
		menuaddclass.classList.add("active");

    var menuaddclass3 = document.getElementById("post-open");
    menuaddclass3.classList.add("menu-open");
	</script>
<?php
  require('footer.php');
?>