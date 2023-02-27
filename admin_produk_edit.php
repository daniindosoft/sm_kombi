<?php
  require('header.php');
  $onMy->verifDataOwned('produk', 'id',  $onMy->toInt($_GET['id']));
  $produk = $sistem->single('produk', $onMy->toInt($_GET['id']));
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Produk</h1>
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
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Produkmu</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                  <div class="card card-success card-outline card-outline-tabs">
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
                            <?php $onMy->inputRedirectFull('id') ?>
                            
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Nama Produk</label>
                                  <input required type="text" class="form-control" name="nama_produk" value="<?php echo $produk['nama_produk'] ?>">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="">Type</label>
                                  <select name="type" class="form-control">
                                    <option <?php echo ($produk['type'] == 'prd') ? 'selected' : ''; ?> value="prd">Produk</option>
                                    <option <?php echo ($produk['type'] == 'merch') ? 'selected' : ''; ?> value="merch">Merchandise</option>
                                  </select>
                                </div>
                              </div>    
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Deskripsi</label>
                                  <textarea name="deskripsi" class="form-control editor-input" cols="30" rows="2"><?php echo $produk['deskripsi'] ?></textarea>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="exampleInputFile">Foto Produk</label>
                                  <p><small><code>*</code>Masukan foto produk berupa link gambar saja, pisahkan dengan enter untuk link gambar lebih dari 1</small></p>
                                  <div class="input-group">
                                    <textarea class="form-control" rows="4" name="gambar"><?php echo $produk['dp'] ?></textarea>
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
                                <code>*</code> <small>Kosongkan nama varian jika tidak ingin menyimpan 1 baris terkait</small>
                                <hr>
                                <div class="row" id="resultVarians">
                                <?php 
                                  $ok = ($sistem->selectPleksible('produk_variasi','id_produk', $produk['id']));
                                  foreach ($ok as $line): 
                                ?>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Varian</label>
                                        <input type="hidden" name="idvarian[]" value="<?php echo $line['id'] ?>">
                                        <input type="text" class="form-control" name="oldvarian[]" value="<?php echo $line['nama'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group">
                                        <label>Stok</label>
                                        <input type="number" class="form-control" name="oldstok[]" value="<?php echo $line['stok'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group">
                                        <label>Harga</label>
                                        <input type="number" class="form-control" name="oldharga[]" value="<?php echo $line['harga'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <hr>
                                    </div>
                                <?php endforeach ?>
                                  </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <button type="button" onclick="return addVarian()" class="btn-sm btn-block btn btn-outline-success btn-flat"><i class="fa fa-plus"></i></button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- varian -->

                              <div class="col-md-12">
                                <hr>
                                <button name="updateProduk" type="submit" class="btn-block btn btn-lg btn-success">Simpan Perubahan</button>
                              </div>
                            </div>
                          </form>
                          <br>
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
    document.title = "KOMBI | Edit Produk di <?php echo $namaKomunitas ?>";

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
                                  <div class="col-md-2">
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
