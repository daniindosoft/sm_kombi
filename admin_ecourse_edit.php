<?php
  require('header.php');
  $onMy->verifDataOwned('ecourse', 'id',  $onMy->toInt($_GET['id']));
  $getData = $onMy->single('ecourse', $onMy->toInt($_GET['id']));
	$ecourseKategori = $onMy->selectWithBussiness('ecourse_kategori', $_SESSION['bisnis_kategori_combi']);

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
			                   
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Edit E-Course/Materi</a>
			                  </li>
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                 
			                  <div class="tab-pane fade active show" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
			                  	<form action="" method="post">
			                  		<?php $onMy->inputRedirectFull('id') ?>
				                  	<div class="row">
				                  		<div class="col-md-6">
						                  	<div class="form-group">
							                    <label for="">Judul</label>
							                    <input type="text" maxlength="70" required class="form-control" name="judul" placeholder="judul atau nama ecourse" value="<?php echo $getData['judul'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-6">
						                  	<div class="form-group">
							                    <label for="">Kategori E-Course/Materi</label>
							                    <select class="form-control" name="kategori">
							                    	<?php foreach ($ecourseKategori as $value): ?>
								                    	<option <?php if($value['id']==$getData['id_kategori']){echo 'selected';} ?> value="<?php echo $value['id'] ?>"><?php echo $value['nama_kategori'] ?></option>
							                    	<?php endforeach ?>
							                    </select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-6">
							                  <div class="form-group">
							                    <label for="">URL Video <br><em><small>Wajib link youtube</small></em></label>
							                    <input type="text" required class="form-control" name="link" placeholder="youtube video" value="<?php echo $getData['link'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-6">
							                  <div class="form-group">
							                    <label for="">Deskripsi</label>
							                    <textarea maxlength="99" name="deskripsi" rows="3" class="form-control"><?php echo $getData['deskripsi'] ?></textarea>
							                  </div>
						                  </div>
				                  		<div class="col-md-12">
							                  <button type="submit" name="updateEcourse" class="btn btn-success">Simpan Perubahan</button>
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
	           
	          </div>
	          <!--/.col (right) -->
	        </div>
	      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script type="text/javascript">
    document.title = "KOMBI | Edit E-Course <?php echo $namaKomunitas ?>";

  	var menuaddclass = document.getElementById("ecourse");
		menuaddclass.classList.add("active");
  </script>
<?php
  require('footer.php');
?>