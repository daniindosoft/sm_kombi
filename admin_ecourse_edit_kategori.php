<?php
  require('header.php');

  $onMy->verifDataOwned('ecourse_kategori', 'id',  $onMy->toInt($_GET['id']));
  $getData = $onMy->single('ecourse_kategori',  $onMy->toInt($_GET['id']));

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fa fa-pencil-alt"></i> Edit E-Course/Materi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/ecourse">E-Course</a></li>
              <li class="breadcrumb-item">Edit</li>
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
	                <h3 class="card-title"><?php echo $onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi'])['nama_komunitas'] ?></h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-success card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item active show">
			                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Edit Kategori E-Course/Materi</a>
			                  </li>
			                   
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
			                  	<form action="" method="post">
			                  		<input type="hidden" name="id" value="<?php echo $getData['id'] ?>">
				                  	<div class="form-group">
					                    <label for="">Nama Kategori</label>
					                    <input type="text" class="form-control" name="nama_kategori" maxlength="30" required value="<?php echo $getData['nama_kategori'] ?>">
					                    <?php $onMy->inputRedirect() ?>
					                    <input type="hidden" name="id_user" value="<?php echo $_COOKIE['id_akun_combi'] ?>">
					                    <input type="hidden" name="id_komunitas_bisnis" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
					                  </div>
					                  <button type="submit" class="btn btn-success" name="updateEcourseKategori">Simpan Perubahan</button>
			                  	</form>
				                  <br> 
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
	           
	          </div>
	          <!--/.col (right) -->
	        </div>
	      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script type="text/javascript">
    document.title = "KOMBI | Edit Kategori E-Course <?php echo $namaKomunitas ?>";

  	var menuaddclass = document.getElementById("ecourse");
		menuaddclass.classList.add("active");
  </script>
<?php
  require('footer.php');
?>