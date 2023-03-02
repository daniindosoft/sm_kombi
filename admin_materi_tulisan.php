<?php
  require('header.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Atur Materi Tulisan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/ecourse">E-Course</a></li>
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
	            <div class="card card-warning">
	              <div class="card-header">
	                <h3 class="card-title">Bisnis Aktif = <?php echo $onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi'])['nama_komunitas'] ?></h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-warning card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item active show">
			                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Kategori Materi Tulisan</a>
			                  </li>
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">E-Course/Materi</a>
			                  </li>
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
			                  	<form action="" method="post">
				                  	<div class="form-group">
					                    <label for="">Nama Kategori</label>
					                    <input type="text" class="form-control" name="nama_kategori" required maxlength="30">
					                    <small><code>*</code> Penting !, Kategori yang sudah dibuat tidak bisa di ubah/edit</small>
					                    <?php $onMy->inputRedirectFull() ?>
					                  </div>
					                  <button type="submit" class="btn btn-warning" name="submitTulisanKategori">Simpan</button>
			                  	</form>
				                  <br>
				                  <br>
				                  <div class="table-responsive">
					                  <table class="table table-striped dt">
						                  <thead>
						                    <tr>
						                      <th style="width: 10px">#</th>
						                      <th>Nama Kategori</th>
						                      <th></th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                  	<?php 
						                  		$no=1; 
						                  		$ecourseKategori = $onMy->selectWithBussiness('kategori_tulisan', $_SESSION['bisnis_kategori_combi']);
						                  		foreach ($ecourseKategori as $value): $no++; 
						                  	?>
							                    <tr>
							                      <td><?php echo $no++ ?></td>
							                      <td><?php echo $value['nama'] ?></td>
							                      <td>
							                      	<div class="btn-group btn-sm">
										                    <button type="button" class="btn btn-warning">Action</button>
										                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
										                      <span class="sr-only">Toggle Dropdown</span>
										                    </button>
										                    <div class="dropdown-menu" role="menu" style="">
										                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus kategori ini ?, semua data yang berhubungan dengan ini akan hilang juga !')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('kategori_tulisan') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
										                    </div>
										                  </div>
							                      </td>
							                    </tr>
						                  	<?php endforeach ?>
						                   
						                  </tbody>
						                </table>
				                  </div>
			                  </div>
			                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
			                  	<form action="" method="post">
			                  		<?php $onMy->inputRedirect() ?>
				                    <input type="hidden" name="id_user" value="<?php echo $_COOKIE['id_akun_combi'] ?>">
				                    <input type="hidden" name="id_komunitas_bisnis" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
				                  	<div class="row">
				                  		<div class="col-md-6">
						                  	<div class="form-group">
							                    <label for="">Judul</label>
							                    <input type="text" maxlength="100" required class="form-control" name="judul" placeholder="judul atau nama ecourse">
							                  </div>
				                  		</div>
				                  		<div class="col-md-6">
						                  	<div class="form-group">
							                    <label for="">Kategori Materi Tulisan</label>
							                    <select class="form-control" name="kategori">
							                    	<?php foreach ($ecourseKategori as $value): ?>
								                    	<option value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
							                    	<?php endforeach ?>
							                    </select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-12">
							                  <div class="form-group">
							                    <label for="">Deskripsi</label>
							                    <textarea name="deskripsi" rows="3" class="form-control editor-input"></textarea>
							                    <small><code>*</code> Ingat, Materi/tulisan yang sudah di upload tidak bisa di edit, jadi pastikan materi sudah Fix untuk di upload/share. <br>Tips : Copy dan buat materi baru jika terdapat perubahan Materi/tulisan </small>
							                  </div>
						                  </div>
				                  		<div class="col-md-12">
							                  <button type="submit" name="submitMateriTulisan" class="btn btn-warning btn-block btn-sm">Simpan</button>
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

	            <!-- general form elements -->
	            <div class="card card-warning">
	              <div class="card-header">
	                <h3 class="card-title">Data Ecourse/Materi</h3>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
									<table class="table table-striped dt">
	                  <thead>
	                    <tr>
	                      <th style="width: 10px">#</th>
	                      <th>Judul</th>
	                      <th>Kategori</th>
	                      <th>Deskripsi</th>
	                      <th>URL</th>
	                      <th></th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                  	<?php $no=1; foreach ($onMy->selectWithBussiness('tulisan', $_SESSION['bisnis_kategori_combi']) as $value): ?>
		                    <tr>
		                      <td><?php echo $no++; ?></td>
		                      <td><?php echo $value['judul'] ?></td>
		                      <td><?php echo $onMy->single('kategori_tulisan',$value['id_kategori_tulisan'])['nama'] ?></td>
		                      <td><?php echo substr($value['text'], 0, 30); ?>...</td>
		                      <td><a href="<?php echo $value['link'] ?>" target="_blank"><?php echo $value['link'] ?></a></td>
		                      <td>
		                      	<div class="btn-group btn-sm">
					                    <button type="button" class="btn btn-warning">Action</button>
					                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
					                      <span class="sr-only">Toggle Dropdown</span>
					                    </button>
					                    <div class="dropdown-menu" role="menu" style="">
					                      
					                      <div class="dropdown-divider"></div>
					                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus tulisan ini')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('tulisan') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
					                    </div>
					                  </div>
		                      </td>
		                    </tr>
	                    <?php endforeach ?> 
	                  </tbody>
	                </table>
	                <br>
	                <br>
	                <br>
	              </div>
	              <!-- /.card-body -->
	            </div>
	             

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