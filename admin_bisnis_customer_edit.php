<?php
  require('header.php');
  $getData = $onMy->single('customer_list', $onMy->toInt($_GET['id']));
  $onMy->verifDataOwned('customer_list', 'id',  $onMy->toInt($_GET['id']));

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fa fa-pencil-alt"></i> Edit Customer List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Bisnis</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/customer_list">Customer List</a></li>
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
	                <h3 class="card-title">Atur Customer List</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-success card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">

			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Customer List</a>
			                  </li>
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  
			                  <div class="tab-pane fade active show" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
			                  	<form action="" method="post" onsubmit="return confirm('yakin merubah data ini ? pastikan sudah benar ya')">
			                  		<?php $onMy->inputRedirectFull('id') ?>
				                  	<div class="row">
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Kategori Customer List</label>
							                    	<select name="kategori" class="form-control">
							                    		<?php foreach ($onMy->selectWithBussiness('kategori_customer_list', $_SESSION['bisnis_kategori_combi']) as $key => $value): ?>
								                    		<option <?php echo ($getData['id_kategori_customer_list'] == $value['id']) ? 'selected' : ''; ?>	 value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
							                    		<?php endforeach ?>
							                    	</select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Nama Lengkap</label>
							                    <input type="text" maxlength="100" required class="form-control" name="nama_lengkap" placeholder="masukan nama lengkap" value="<?php echo $getData['nama'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Jenis Kelamin</label>
							                    <select name="jk" class="form-control">
							                    	<option <?php echo ($getData['jk'] == 'L') ? 'selected' : '' ?> value="L">L</option>
							                    	<option <?php echo ($getData['jk'] == 'P') ? 'selected' : '' ?> value="P">P</option>
							                    </select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">E-Mail</label>
							                    <input type="text" maxlength="100" class="form-control" name="email" placeholder="masukan nama lengkap" value="<?php echo $getData['email'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">No Hp/WhatsApp</label>
							                    <input type="text" maxlength="100" class="form-control" name="nowa" value="<?php echo $getData['phone'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Alamat</label>
							                    <textarea name="alamat" class="form-control"><?php echo $getData['alamat'] ?></textarea>
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Sumber</label>
							                    <input type="text" maxlength="100" class="form-control" name="sumber" placeholder="masukan catatan sumber data yang di masukan" value="<?php echo $getData['source'] ?>">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Nilai Konversi</label>
							                    <input type="number" class="form-control" name="nilai_konversi" placeholder="masukan nilai Konversi" value="<?php echo $getData['nilai_konversi'] ?>">
							                  </div>
				                  		</div>
 				                  		 
				                  		<div class="col-md-12">
							                  <button type="submit" name="submitCustomerList" class="btn btn-success btn-block">Simpan Perubahan</button>
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
		document.title = "KOMBI | Atur Customer List <?php echo $namaKomunitas ?>";
		    var menuaddclass = document.getElementById("bisnis");
    menuaddclass.classList.add("active");

		var menuaddclass = document.getElementById("customer_list");
		menuaddclass.classList.add("active");

    var menuaddclass3 = document.getElementById("bisnis-open");
    menuaddclass3.classList.add("menu-open");
	</script>
<?php
  require('footer.php');
?>