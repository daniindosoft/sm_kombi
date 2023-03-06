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
            <h1 class="m-0">Atur Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/produk">Produk</a></li>
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
				<div class="container-fluid">
	        <div class="row">
	          <!-- left column -->
	          <div class="col-md-12">
	            <!-- general form elements -->
	            <div class="card card-warning">
	              <div class="card-header">
	                <h3 class="card-title">Produkmu</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-warning card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item active show">
			                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Atur Produk</a>
			                  </li>
			                   
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                          <form action="" method="post">
                            <?php $onMy->inputRedirect() ?>
                            <input required type="hidden" name="id_user" value="<?php echo $_COOKIE['id_akun_combi'] ?>">
                            <input required type="hidden" name="id_komunitas_bisnis" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
  			                  	<div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
      				                    <label for="">Nama Produk</label>
      				                    <input required type="text" class="form-control" name="nama_produk">
      				                  </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Deskripsi</label>
                                  <textarea name="deskripsi" class="form-control" cols="30" rows="2"></textarea>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Harga</label>
                                  <input required type="number" class="form-control" name="harga">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Stok</label>
                                  <input required type="number" class="form-control" name="stok">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputFile">Foto Produk</label>
                                  <div class="input-group">
                                    <input required type="text" name="dp" class="form-control">
                                    <!-- <div class="custom-file">
                                      <input required type="file" class="custom-file-input" id="exampleInputFile">
                                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                      <span class="input-group-text">Upload</span>
                                    </div> -->
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Type</label>
                                  <select name="type" class="form-control">
                                    <option value="prd">Produk</option>
                                    <option value="merch">Merchandise</option>
                                  </select>
                                </div>
                              </div>    
    				                  <button name="submitProduk" type="submit" class="btn btn-warning">Simpan</button>
                            </div>
                          </form>
				                  <br>
				                  <br>
				                  <table class="table table-striped">
					                  <thead>
					                    <tr>
					                      <th style="width: 10px">#</th>
					                      <th>Nama Produk</th>
                                <th>Type</th>
                                <th>Harga</th>
                                <th>Gambar</th>
					                      <th></th>
					                    </tr>
					                  </thead>
					                  <tbody>
                              <?php $no=1; foreach ($onMy->selectWithBussiness('produk', $_SESSION['bisnis_kategori_combi']) as $value): ?>
  					                    <tr>
  					                      <td><?php echo $no++; ?></td>
                                  <td><?php echo $value['nama_produk'] ?></td>
                                  <td>
                                    <?php
                                      if($value['type'] == 'prd'){
                                        echo 'Produk';
                                      }else{
                                        echo 'Merchandise';
                                      }
                                    ?>  
                                  </td>
                                  <td>Rp<?php echo number_format($value['harga']) ?></td>
                                  <td>
                                    <img src="<?php echo $value['dp'] ?>" width="60px">
                                  </td>
  					                      <td>
  					                      	<div class="btn-group btn-sm">
  								                    <button type="button" class="btn btn-warning">Action</button>
  								                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
  								                      <span class="sr-only">Toggle Dropdown</span>
  								                    </button>
  								                    <div class="dropdown-menu" role="menu" style="">
                                        <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>admin/produk/edit?id=<?php echo $value['id'] ?>">Edit</a>
  								                      <div class="dropdown-divider"></div>
  								                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus produk ini ?')" href="<?php echo $onMy->warningLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('produk') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
  								                    </div>
  								                  </div>
  					                      </td>
  					                    </tr>
                              <?php endforeach ?>
					                     
					                  </tbody>
					                </table>
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
    document.title = "KOMBI | Atur Produk untuk <?php echo $namaKomunitas ?>";

    var menuaddclass = document.getElementById("produk");
    menuaddclass.classList.add("active");
  </script>
<?php
  require('footer.php');
?>
