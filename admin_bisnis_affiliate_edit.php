<?php
  require('header.php');
  $id = $onMy->toInt($_GET['id']);
  $onMy->verifDataOwned('affiliate_produk', 'id',  $id);

  $data = $onMy->single('affiliate_produk', $id);

  $fields = (explode('{}', $data['fields']));

?>
<div class="content-wrapper" style="min-height: 577px;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Affiliate Produk  </h1>
        </div><!-- /.col -->
        <div class="col-sm-12">
          <?php $onMy->callFlash() ?>
        	
                  </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
        
      <!-- /.row -->
      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ion ion-android-people mr-1"></i>
                Lead dan Link Affiliate
              </h3>
              
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="chart tab-pane active" id="revenue-chart">

                  <div class="card card-warning">
                    
                    <div class="card-body border" style="display: block;">
                      <b>Edit Produkmu Affiliatemu</b>
                      <hr>
                      <form action="" method="post">
                        <?php $onMy->inputRedirectFull('id') ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Judul</label>
                              <input value="<?php echo $data['judul'] ?>" type="text" class="form-control" name="judul" required maxlength="70">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Note</label>
                              <textarea name="note" class="form-control" maxlength="200"><?php echo $data['note'] ?></textarea>
                            </div>
                          </div>
                         
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Type Produk</label>
                              <select class="form-control" onchange="return produkType()" id="typeProduk" name="type_produk">
                                <option <?php echo ($data['type'] == 'fisik') ? 'selected' : ''; ?> value="fisik">Produk Fisik</option>
                                <option <?php echo ($data['type'] == 'non') ? 'selected' : ''; ?> value="non">Produk Non-Fisik</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Nilai</label>
                              <select class="form-control" onchange="return nilaiType()" id="nilai" name="nilai">
                                <option <?php echo ($data['nilai'] == 'berbayar') ? 'selected' : ''; ?> value="berbayar">Berbayar</option>
                                <option <?php echo ($data['nilai'] == 'gratis') ? 'selected' : ''; ?> value="gratis">Gratis</option>
                              </select>
                              <small>Jika Gratis dipilih, Field Harga dan Komisi akan di abaikan </small>
                            </div>
                          </div>
                          <div class="col-md-3 harga">
                            <div class="form-group">
                              <label>Harga</label>
                              <input type="number" value="<?php echo $data['harga'] ?>" class="form-control harga" name="harga" maxlength="10">
                            </div>
                          </div>
                          <div class="col-md-3 komisi">
                            <div class="form-group">
                              <label>Komisi</label>
                              <input type="number" value="<?php echo $data['komisi'] ?>" class="form-control komisi" name="komisi" maxlength="10">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Fields Form</label>
                              <select class="select2bs4" multiple="multiple" data-placeholder="Pilih field untuk form order" style="width: 100%;" name="fields_form[]">
                                <option <?php echo (array_search('domisili', $fields)) ? 'selected' : ''; ?> value="domisili">DOMISILI</option>
                                <option <?php echo (array_search('alamat', $fields)) ? 'selected' : ''; ?> value="alamat">ALAMAT</option>
                                <option <?php echo (array_search('kode_pos', $fields)) ? 'selected' : ''; ?> value="kode_pos">KODE POS</option>
                                <option <?php echo (array_search('jk', $fields)) ? 'selected' : ''; ?> value="jk">JK</option>
                                <option <?php echo (array_search('rentang_usia', $fields)) ? 'selected' : ''; ?> value="rentang_usia">RENTANG USIA</option>
                                <option <?php echo (array_search('catatan', $fields)) ? 'selected' : ''; ?> value="catatan">CATATAN</option>
                              </select>
                              <small>
                                <ul>
                                  <li>Nama, Email dan No Wa adalah Field Default yang pasti Ada</li>
                                  <li>Jika produk fisik, disarankan memilih Kota/domisili, Kode Pos, Alamat Lengkap dan Catatan</li>
                                  <li>Jika produk non-fisik, disarankan memilih Kota/domisili saja</li>
                                </ul>
                              </small>
                            </div>
                          </div>
                          <div class="col-md-6 hidlink hide">
                            <div class="form-group">
                              <label>Url</label>
                              <input type="text" value="<?php echo $data['url'] ?>" class="form-control" name="url" placeholder="link untuk produk non fisik yang kamu jual">
                              <small>Link untuk produk non fisik yang kamu jual, seperti link google drive etc..</small>
                            </div>
                          </div> 
                          <div class="col-md-4">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" <?php echo ($data['is_private'] == '1') ? 'checked' : ''; ?> class="custom-control-input" id="cprivate" name="cprivate">
                              <label class="custom-control-label" for="cprivate">Jika diaktifkan produk ini tidak bisa di affiliatekan oleh member komunitas Anda</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Header</label>
                              <textarea name="header" class="form-control" placeholder="..."><?php echo base64_decode($data['header']) ?></textarea>
                              <small>Ketika Member membuka/mengunjungi memberarea komunitasmu, kode/pixel ini akan tertrigger</small>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <button type="submit" name="updateBisnisAffiliate" class="btn btn-warning btn-block">Simpan Perubahan</button>
                          </div>
                      </form>
                    </div>
                  </div>
                  
                </div>
              </div>
              
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </section>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
	document.title = 'KOMBI | Edit Produk affiliate - <?php echo $namaKomunitas ?>';

    var menuaddclass = document.getElementById("bisnis");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("affiliate");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("bisnis-open");
    menuaddclass3.classList.add("menu-open");

</script>
<?php
  require('footer.php');
?>