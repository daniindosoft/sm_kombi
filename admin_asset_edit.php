<?php
  require('header.php');
  $onMy->verifDataOwned('asset', 'id',  $onMy->toInt($_GET['id']));
  $getData = $onMy->single('asset', $_GET['id']);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fa fa-pencil-alt"></i> Edit Asset</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/asset">Asset</a></li>
              <li class="breadcrumb-item">Edit</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-sm-12">
            <?php $onMy->callFlash() ?>
          </div><!-- /.col -->
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
	                <h3 class="card-title">Asset</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                  <div class="card card-success card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">File/zip/video</a>
                        </li>
                                      
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                          <form action="" method="post">
                            <?php $onMy->inputRedirectFull('id') ?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Judul</label>
                                  <input type="text" class="form-control" name="judul" required value="<?php echo $getData['judul'] ?>" maxlength="100">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="">Type</label>
                                  <select name="type" class="form-control">
                                    <option <?php if($getData['type'] == 'file'){echo 'selected';} ?> value="file">File/zip</option>
                                    <option <?php if($getData['type'] == 'vid'){echo 'selected';} ?> value="vid">Video</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Deskripsi</label>
                                  <textarea name="deskripsi" class="form-control" cols="30" rows="2" required><?php echo $getData['deskripsi'] ?></textarea>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Url</label>
                                  <input type="text" name="url" class="form-control" required value="<?php echo $getData['url'] ?>">
                                  <ul>
                                    <li><small><i><code>*</code>Jika typenya dalah File/zip, disini Masukan link untuk Member Anda, supaya bisa mendownload file, contoh : link file di google drive</i></small></li>
                                    <li><small><i><code>*</code>Jika typenya dalah video, masukan link video youtube</i></small></li>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <button type="submit" name="updateAsset" class="btn btn-success">Simpan Perubahan</button>
                              </div>
                            </div>
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
	            <!-- /.card -->
 
	          </div>
	          <!--/.col (right) -->
	        </div>
	      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    document.title = "KOMBI | Edit Asset <?php echo $namaKomunitas ?>";

    var menuaddclass = document.getElementById("asset");
    menuaddclass.classList.add("active");
  </script>
<?php
  require('footer.php');
?>
