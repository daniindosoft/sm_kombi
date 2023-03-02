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
          <div class="col-sm-12">
            <?php $onMy->callFlash() ?>
          </div><!-- /.row -->
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
      				                    <input required type="text" class="form-control" name="nama_produk" maxlength="70">
      				                  </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="">Type</label>
                                  <select name="type" class="form-control">
                                    <option value="prd">Produk</option>
                                    <option value="merch">Merchandise</option>
                                  </select>
                                </div>
                              </div>    
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Deskripsi</label>
                                  <textarea name="deskripsi" class="form-control editor-input" cols="30" rows="2"></textarea>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="exampleInputFile">Foto Produk</label>
                                  <p><small><code>*</code>Masukan foto produk berupa link gambar saja, pisahkan dengan enter untuk link gambar lebih dari 1</small></p>
                                  <div class="input-group">
                                    <textarea class="form-control" rows="4" name="gambar">
link gambar 1
link gambar 2
..
                                    </textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="form-group">
                                    <div class="custom-control custom-switch">
                                      <!-- <input type="checkbox" class="custom-control-input" name="variasi" id="varianChange" onclick="varian()">
                                      <label class="custom-control-label" for="varianChange">Variasi</label> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12 border p-2 hide" id="single">
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label for="">Harga</label>
                                      <input type="number" class="form-control" name="single_harga">
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Stok</label>
                                      <input type="number" class="form-control" name="single_stok">
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- varian -->
                              <div class="col-md-12 border p-2 " id="varian">
                                <div class="row" id="resultVarians">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Varian</label>
                                      <input type="text" class="form-control" name="varian[]" maxlength="20">
                                    </div>
                                  </div>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                      <label>Stok</label>
                                      <input type="number" class="form-control" name="stok[]" maxlength="4">
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Harga</label>
                                      <input type="number" class="form-control" name="harga[]" maxlength="15">
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <hr>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <button type="button" onclick="return addVarian()" class="btn-sm btn-block btn btn-outline-warning btn-flat"><i class="fa fa-plus"></i></button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- varian -->

                              <div class="col-md-12">
                                <hr>
      				                  <button name="submitProduk" type="submit" class="btn-block btn btn-lg btn-warning">Tambah Produk</button>
                              </div>
                            </div>
                          </form>
				                  <br>
				                  <br>
                          <div class="table-responsive">
  				                  <table class="table table-striped dt">
  					                  <thead>
  					                    <tr>
  					                      <th style="width: 10px">#</th>
  					                      <th>Nama Produk</th>
                                  <th>Type</th>
   
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
    					                      <td>
    					                      	<div class="btn-group btn-sm">
    								                    <button type="button" class="btn btn-warning">Action</button>
    								                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
    								                      <span class="sr-only">Toggle Dropdown</span>
    								                    </button>
    								                    <div class="dropdown-menu" role="menu" style="">
                                          <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>admin/produk/edit?id=<?php echo $value['id'] ?>">Edit</a>
    								                      <div class="dropdown-divider"></div>
    								                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus produk ini ?')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('produk') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
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
    
    function varian() {

      $('#varian').toggleClass('hide');
      $('#single').toggleClass('hide');
      
    }

    function addVarian(){
      $('#resultVarians').append(`
                                
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Varian</label>
                                      <input type="text" class="form-control" name="varian[]">
                                    </div>
                                  </div>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                      <label>Stok</label>
                                      <input type="number" class="form-control" name="stok[]">
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Harga</label>
                                      <input type="number" class="form-control" name="harga[]">
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <hr>
                                  </div>
                                  
                              
        `);
    }
  </script>
<?php
  require('footer.php');
?>
