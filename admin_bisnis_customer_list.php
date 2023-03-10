<?php
  require('header.php');

  $totalData = $onMy->eksekusiShow('select count(id) as total from customer_list where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' ')['total'];

  $onMy->registerGeneratePaginate(20, $_GET['halaman'], $totalData);
  $customerList = $onMy->tampil_manual('select * from customer_list where id_komunitas_bisnis= '.$_SESSION['bisnis_kategori_combi'].' order by id desc limit '.$onMy->halaman_awal.', '.$onMy->batas);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Customer List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Bisnis</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/customer_list">Customer List</a></li>
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
	                <h3 class="card-title">Customer List</h3>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body table-responsive">
									<table class="table table-striped">
	                  <thead>
	                    <tr>
	                      <th style="width: 10px">#</th>
	                      <th>Nama</th>
	                      <th>E-Mail</th>
	                      <th>No Hp/Whatsapp</th>
	                      <th>Source</th>
	                      <th></th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                  	<?php $no=1; $onMy->orderBy = true; foreach ($customerList as $value): ?>
		                    <tr>
		                      <td><?php echo $no++; ?></td>
		                      <td><?php echo $value['nama'] ?></td>
		                      <td><?php echo $value['email'] ?></td>
		                      <td><?php echo $value['phone'] ?></td>
		                      <td><?php echo $value['source'] ?></td>
		                      <td>
		                      	<div class="btn-group btn-sm">
					                    <button type="button" class="btn btn-warning">Action</button>
					                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
					                      <span class="sr-only">Toggle Dropdown</span>
					                    </button>
					                    <div class="dropdown-menu" role="menu" style="">
					                      
					                      <div class="dropdown-divider"></div>
					                      <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>admin/bisnis/customer_list/edit?id=<?php echo $value['id'] ?>">Edit</a>
					                      
					                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus customer list ini')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('customer_list') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
					                    </div>
					                  </div>
		                      </td>
		                    </tr>
	                    <?php endforeach ?> 
	                  </tbody>
	                </table>
	                <br>
	                <?php
						        $onMy->generatePaginate();
	                ?>
	                <br>
	                <br>
	              </div>
	              <!-- /.card-body -->
	            </div>
	            <!-- general form elements -->
	            <div class="card card-warning">
	              <div class="card-header">
	                <h3 class="card-title">Atur Customer List</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-warning card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item active show">
			                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Kategori Customer List</a>
			                  </li>
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Customer List</a>
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
					                  <button type="submit" class="btn btn-warning" name="submitCustomerListKategori">Simpan Kategori Customer List</button>
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
						                  		$ecourseKategori = $onMy->selectWithBussiness('kategori_customer_list', $_SESSION['bisnis_kategori_combi']);
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
										                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus kategori ini ?, semua data yang berhubungan dengan ini akan hilang juga !')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('kategori_customer_list') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
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
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Kategori Customer List</label>
							                    	<select name="kategori" class="form-control">
							                    		<?php foreach ($onMy->selectWithBussiness('kategori_customer_list', $_SESSION['bisnis_kategori_combi']) as $key => $value): ?>
								                    		<option value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
							                    		<?php endforeach ?>
							                    	</select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Nama Lengkap</label>
							                    <input type="text" maxlength="100"   class="form-control" name="nama_lengkap" placeholder="masukan nama lengkap">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Jenis Kelamin</label>
							                    <select name="jk" class="form-control">
							                    	<option value="">Pilih</option>
							                    	<option value="L">L</option>
							                    	<option value="P">P</option>
							                    </select>
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">E-Mail</label>
							                    <input type="text" maxlength="100" class="form-control" name="email" placeholder="masukan nama lengkap">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">No Hp/WhatsApp</label>
							                    <input type="text" maxlength="100" class="form-control" name="nowa">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Alamat</label>
							                    <textarea name="alamat" class="form-control"></textarea>
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Sumber</label>
							                    <input type="text" maxlength="100" class="form-control" name="sumber" placeholder="masukan catatan sumber data yang di masukan">
							                  </div>
				                  		</div>
				                  		<div class="col-md-7">
						                  	<div class="form-group">
							                    <label for="">Nilai Konversi</label>
							                    <input type="number" class="form-control" name="nilai_konversi" placeholder="masukan nilai Konversi">
							                  </div>
				                  		</div>
 				                  		 
				                  		<div class="col-md-12">
							                  <button type="submit" name="submitCustomerList" class="btn btn-warning btn-block">Simpan Customer List</button>
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