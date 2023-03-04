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
            <h1 class="m-0">Atur Asset</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/asset">Asset</a></li>
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
	            <div class="card card-warning">
	              <div class="card-header">
	                <h3 class="card-title">Asset</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                  <div class="card card-warning card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">File/zip/video</a>
                        </li>
                                      
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade " id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                          <form action="" method="post">
                            <?php $onMy->inputRedirect() ?>
                            <input type="hidden" name="id_user" value="<?php echo $_COOKIE['id_akun_combi'] ?>">
                            <input type="hidden" name="id_komunitas_bisnis" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
                            <div class="form-group">
                              <label for="">Judul</label>
                              <input type="text" class="form-control" name="judul" required maxlength="100">
                            </div>
                            <div class="form-group">
                              <label for="">Deskripsi</label>
                              <textarea name="deskripsi" class="form-control" cols="30" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="">Type</label>
                              <select name="type" class="form-control">
                                <option value="file">File/zip</option>
                                <option value="vid">Video</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="">Url</label>
                              <input type="text" name="url" class="form-control" required>
                              <ul>
                                <li><small><i><code>*</code>Jika typenya dalah File/zip, disini Masukan link untuk Member Anda, supaya bisa mendownload file, contoh : link file di google drive</i></small></li>
                                <li><small><i><code>*</code>Jika typenya dalah video, masukan link video youtube</i></small></li>
                              </ul>
                            </div>
                            <button type="submit" name="submitAsset" class="btn btn-warning">Simpan Asset</button>
                          </form>
                          <br>
                        </div>
                      </div>
                    </div>
			            </div>
                  <div class="table-responsive">
                    <table class="table table-striped dt">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Judul</th>
                          <th>Url</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach ($onMy->selectWithBussiness('asset', $_SESSION['bisnis_kategori_combi']) as $value): ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $value['judul'] ?></td>
                            <td><?php echo $value['url'] ?></td>
                            <td>
                              <div class="btn-group btn-sm">
                                <button type="button" class="btn btn-warning">Action</button>
                                <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>admin/asset/edit?id=<?php echo $value['id'] ?>">Edit</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" onclick="return confirm('Yakin menghapus Asset ini ?')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('asset') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
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
    document.title = "KOMBI | Atur Asset untuk <?php echo $namaKomunitas ?>";

    var menuaddclass = document.getElementById("asset");
    menuaddclass.classList.add("active");
  </script>
<?php
  require('footer.php');
?>
