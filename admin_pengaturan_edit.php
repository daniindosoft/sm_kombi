<?php
  require('header.php');
  $onMy->verifDataOwned('komunitas_bisnis', 'id',  $onMy->toInt($_GET['id']));

  $getData = $onMy->single('komunitas_bisnis', $onMy->toInt($_GET['id']));
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fa fa-pencil-alt"></i> Pengaturan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">E-Course</li>
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
	            <div class="card card-success">
	              <div class="card-header">
	                <h3 class="card-title">Edit Komunitas</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-success card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item active show">
			                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Edit Komunitas Bisnis Disini</a>
			                  </li> 
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
			                  	<form action="" method="post">
    												<?php $onMy->inputRedirectFull() ?>
    												<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
				                  	<div class="row">
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Nama Komunitas</label>
					                        <input required name="nama_komunitas" value="<?php echo $getData['nama_komunitas'] ?>" type="text" class="form-control" placeholder="Masukan Nama Komunitas">
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>No Wa</label>
					                        <input required name="no_wa" type="text" value="<?php echo $getData['nowa'] ?>" class="form-control" placeholder="Masukan No Wa">
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Email</label>
					                        <input required name="email" value="<?php echo $getData['email'] ?>" type="text" class="form-control" placeholder="Masukan E-Mail" maxlength="99">
					                      </div>
					                    </div>
															
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Pilih Kategori Bisnis Untuk Komunitas Ini</label><br>
					                        <select class="form-control" name="kategori_bisnis">
					                        	<?php foreach ($onMy->tampil_manual('select * from kategori_bisnis order by nama') as $value): ?>
						                        	<option <?php if($getData['id_kategori_bisnis'] == $value['id']){ echo 'selected'; } ?> value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
					                        	<?php endforeach ?>
					                        </select>
					                        <em><small>Jika kategori yang anda butuhkan tidak ada, silahkan hubungi Admin</small></em>
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Website</label>
					                        <input   name="website" type="text" class="form-control" placeholder="Masukan Website"value="<?php echo $getData['website'] ?>">
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Instagram</label>
					                        <input name="instagram" type="text" class="form-control" placeholder="Masukan Instagram" value="<?php echo $getData['ig'] ?>">
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Tiktok</label>
					                        <input name="tiktok" value="<?php echo $getData['tiktok'] ?>" type="text" class="form-control" placeholder="Masukan Tiktok">
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Harga</label>
					                        <input required name="harga" type="number" class="form-control" placeholder="Masukan harga" value="<?php echo $getData['harga'] ?>">
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Komisi</label>
					                        <input required name="komisi" type="number" class="form-control" value="<?php echo $getData['komisi_affiliate_join'] ?>" placeholder="Masukan Komisi">
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                    	<div class="form-group">
					                        <label>Tampilkan Menu Member</label>
					                        <div class="custom-control custom-switch">
							                      <input  type="checkbox" class="custom-control-input" id="customSwitch2" name="menu" <?php if ($getData['member_show'] == '1'){ echo 'checked'; } ?>>
							                      <label class="custom-control-label" for="customSwitch2"></label>
							                    </div>
					                        <small><code>*</code> Jika mengaktifkan ini maka menu Member akan ditampilan dan Member akan bisa melihat jumlah member</small>
					                      </div>
						                  </div>
						                  <div class="col-sm-6">
					                    	<div class="form-group">
					                        <label>Verifikasi Post</label>
					                        <div class="custom-control custom-switch">
							                      <input type="checkbox" class="custom-control-input" id="customSwitch" name="verifikasi" <?php if ($getData['verifikasi_post'] == '1'){ echo 'checked'; } ?>>
							                      <label class="custom-control-label" for="customSwitch"></label>
							                    </div>
					                        <small><code>*</code> Jika mengaktifkan ini maka setiap Member di komunitas bisnis yang membuat postingan perlu diperiksa oleh Anda sebagai Admin.</small>
					                      </div>
						                  </div>
						                  <div class="col-sm-6">
					                    	<div class="form-group">
					                        <label>Matikan fitur Dropship di Komunitas ini</label>
					                        <div class="custom-control custom-switch">
							                      <input type="checkbox" class="custom-control-input" id="customSwitchDs" name="is_dropship" <?php if ($getData['is_dropship'] == '1'){ echo 'checked'; } ?>>
							                      <label class="custom-control-label" for="customSwitchDs"></label>
							                    </div>
					                        <small><code>*</code> Jika mengaktifkan ini maka fitur <b>Dropship</b> tidak aktif di Komunitas ini </small>
					                      </div>
				                      </div>
				                      <div class="col-sm-6">
					                    	<div class="form-group">
					                        <label>Matikan fitur Affiliate di Komunitas ini</label>
					                        <div class="custom-control custom-switch">
							                      <input type="checkbox" class="custom-control-input" id="customSwitchAff" name="is_affiliate" <?php if ($getData['is_affiliate'] == '1'){ echo 'checked'; } ?>>
							                      <label class="custom-control-label" for="customSwitchAff"></label>
							                    </div>
					                        <small><code>*</code> Jika mengaktifkan ini maka fitur <b>Affiliate</b> tidak aktif di Komunitas ini </small>
					                      </div>
				                      </div>
						                  <div class="col-sm-12">
						                  	<label class="mb-0">Note Affiliate</label><br>
					                      <small><i>Ini akan muncul dihalaman affiliate user</small></i></small>
						                  	<textarea id="compose-textarea" class="form-control" name="text" style="height: 300px"  ><?php echo $getData['note'] ?></textarea>
						                  </div>
			                  			<div class="col-md-12">
			                  				<b>Template WhatsApp</b><br>
			                  				<p>Template Text Whatsapp jika pendaftar mengklik tombol 'Konfirmasi ke Admin' setelah daftar komunitas</p>
			                  				<p>
                            	  	<b>tebal</b> = gunakan *...* untuk menebalkan text di WhatsApp<br>
                            	  	<i>miring</i> = gunakan _..._ untuk memiringkan text di WhatsApp<br>
                            	  	<span style="text-decoration: line-through;">coret</span> = gunakan ~...~ untuk coret text di WhatsApp<br>
                            	  	{rp} untuk menampilkan harga saat pendaftar mengkonfirmasi/klik tombol whatsapp
                            	  </p>	
			                  				<textarea class="form-control" name="wa_template" placeholder=""><?php echo $getData['wa_template'] ?></textarea>
			                  				<hr>
			                  			</div>
			                  			<div class="col-md-4">
			                  				<b>Header Komunitas</b>
			                  				<p><small>Ketika Member membuka/mengunjungi memberarea komunitasmu</small></p>
			                  				<textarea class="form-control" name="header" placeholder="insert header"><?php echo base64_decode($getData['header']) ?></textarea>
			                  				<br>
			                  			</div>
			                  			<div class="col-md-4">
			                  				<b>Header Register Form</b>
			                  				<p><small>Ketika Form Pendaftaran Dikunjungi oleh pendaftar maka Code dibawah ini akan terpanggil</small></p>
			                  				<textarea class="form-control" name="header_form" placeholder="insert header"><?php echo base64_decode($getData['header_form']) ?></textarea>
			                  				<br>
			                  			</div>
			                  			<div class="col-md-4">
			                  				<b>Header Invoice</b>
			                  				<p><small>Setelah seseorang daftar ke komunitasmu/masuk ke halaman invoice, maka Code dibawah ini akan terpanggil atau ter-trigger</small></p>
			                  				<textarea class="form-control" name="header_invoice" placeholder="insert header"><?php echo base64_decode($getData['header_invoice']) ?></textarea>
			                  				<br>
			                  			</div>
					                  </div>
					                  <button type="submit" name="udpateBisnisKomunitas" class="btn btn-success">Simpan Perubahan</button>
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
  <!-- /.content-wrapper -->
  <script type="text/javascript">
  	document.title = "KOMBI | Edit Komunitas Bisnis";


		var menuaddclass = document.getElementById("pengaturan");
		menuaddclass.classList.add("active");
	
  </script>
<?php
  require('footer.php');
?>