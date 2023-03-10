<?php
  require('header.php');

	$paket = $sistem->kuotaPackage($_COOKIE['id_akun_combi']);


  $countComunity = $sistem->totalComunityOwnedByAdmin($_COOKIE['id_akun_combi']);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengaturan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>admin/pengaturan">Pengaturan</a></li>
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
	                <h3 class="card-title">Komunitas Bisnisku</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-warning card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item ">
			                    <a class="nav-link " id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Komunitas Bisnis &nbsp;<?php echo $onMy->mark ?></a>
			                  </li>
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile Saya/Lainnya &nbsp;<?php echo $onMy->mark ?></a>
			                  </li>
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab1" data-toggle="pill" href="#custom-tabs-four-rek" role="tab" aria-controls="custom-tabs-four-rek" aria-selected="false">Rekening/Invoice &nbsp;<?php echo $onMy->mark ?></a>
			                  </li>
			                  <li>
			                    <a class="nav-link" id="custom-tabs-four-profile-faq" data-toggle="pill" href="#custom-tabs-four-faq" role="tab" aria-controls="custom-tabs-four-faq" aria-selected="false">FAQ</a>
			                  </li>
			                  <li>
			                    <a class="nav-link" id="custom-tabs-four-profile-papan" data-toggle="pill" href="#custom-tabs-four-papan" role="tab" aria-controls="custom-tabs-four-papan" aria-selected="false">Papan Informasi</a>
			                  </li>
			                  <li>
			                    <a class="nav-link" id="custom-tabs-four-profile-rule" data-toggle="pill" href="#custom-tabs-four-rule" role="tab" aria-controls="custom-tabs-four-rule" aria-selected="false">Rule/Aturan/Ketentuan</a>
			                  </li>
			                  
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
			                  	<h5>Buat komunitas bisnismu sekarang</h5>
			                  	<small><code>*</code> INGAT !, Komunitas yang sudah di buat tidak bisa di hapus, hanya bisa di edit saja !</small>
			                  	<?php if ($countComunity < $paket): ?>
				                  	<hr>
				                  	<form action="" method="post">
	    												<?php $onMy->inputRedirectFull() ?>
					                  	<div class="row">
						                    <div class="col-sm-6">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Nama Komunitas</label>
						                        <input required maxlength="25" name="nama_komunitas" type="text" class="form-control" placeholder="Masukan Nama Komunitas">
						                      </div>
						                    </div>
						                    <div class="col-sm-3">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>No Wa <i data-toggle="tooltip" data-placement="top" title="WAJIB FORMAT : 085324xxxxx. nomor ini yang digunakan sebagai nomor kontak komunitas Affiliate, Pesanan dll, Pastikan nomor aktif dan penulisan sesuai format " class="fa fa-info-circle"></i></label>
						                        <input required name="no_wa" type="text" class="form-control" placeholder="Masukan No Wa" maxlength="15">
						                        <small>Member bisa menghubungi Anda lewat No Wa ini</small>
						                      </div>
						                    </div>
						                    <div class="col-sm-3">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Email</label>
						                        <input required name="email" type="text" class="form-control" placeholder="Masukan E-Mail" maxlength="99">
						                      </div>
						                    </div>
																
						                    <div class="col-sm-6">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Pilih Kategori Bisnis Untuk Komunitas Ini</label><br>
						                        <select class="form-control" name="kategori_bisnis">
						                        	<?php foreach ($onMy->tampil_manual('select * from kategori_bisnis order by nama') as $value): ?>
							                        	<option value="<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></option>
						                        	<?php endforeach ?>
						                        </select>
						                        <em><small>Jika kategori yang anda butuhkan tidak ada, silahkan hubungi Admin</small></em>
						                      </div>
						                    </div>
						                    <div class="col-sm-6">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Website</label>
						                        <input name="website" type="text" class="form-control" placeholder="Masukan Website" maxlength="30">
						                      </div>
						                    </div>
						                    <div class="col-sm-3">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Instagram</label>
						                        <input name="instagram" maxlength="30" type="text" class="form-control" placeholder="Masukan Instagram">
						                      </div>
						                    </div>
						                    <div class="col-sm-3">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Tiktok</label>
						                        <input name="tiktok" type="text" class="form-control" placeholder="Masukan Tiktok" maxlength="30">
						                      </div>
						                    </div>
						                    <div class="col-sm-3">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Harga</label>
						                        <input required name="harga" type="number" class="form-control" placeholder="Masukan harga" maxlength="11">
						                        <small>Masukan harga untuk bergabung ke komunitasmu</small>
						                      </div>
						                    </div>
						                    <div class="col-sm-3">
						                      <!-- text input -->
						                      <div class="form-group">
						                        <label>Komisi</label>
						                        <input required name="komisi" type="number" class="form-control" placeholder="Masukan Komisi" maxlength="11">
						                      </div>
						                    </div>
						               
						                    <div class="col-sm-6">
						                    	<div class="form-group">
						                        <label>Tampilkan Menu Member</label>
						                        <div class="custom-control custom-switch">
								                      <input type="checkbox" class="custom-control-input" id="customSwitch2" name="menu" <?php if ($profile['is_private'] == '1'){ echo 'checked'; } ?>>
								                      <label class="custom-control-label" for="customSwitch2"></label>
								                    </div>
						                        <small><code>*</code> Jika mengaktifkan ini maka menu Member akan ditampilkan dan Member akan bisa melihat jumlah member</small>
						                      </div>
							                  </div>
							                  <div class="col-sm-6">
						                    	<div class="form-group">
						                        <label>Verifikasi Post</label>
						                        <div class="custom-control custom-switch">
								                      <input type="checkbox" class="custom-control-input" id="customSwitch" name="verifikasi" <?php if ($profile['is_private'] == '1'){ echo 'checked'; } ?>>
								                      <label class="custom-control-label" for="customSwitch"></label>
								                    </div>
						                        <small><code>*</code> Jika mengaktifkan ini maka setiap Member di komunitas bisnis yang membuat postingan perlu diperiksa oleh Anda sebagai Admin.</small>
						                      </div>
					                      </div>
					                      <div class="col-sm-6">
						                    	<div class="form-group">
						                        <label>Matikan fitur Dropship di Komunitas ini</label>
						                        <div class="custom-control custom-switch">
								                      <input type="checkbox" class="custom-control-input" id="customSwitchDs" name="is_dropship">
								                      <label class="custom-control-label" for="customSwitchDs"></label>
								                    </div>
						                        <small><code>*</code> Jika mengaktifkan ini maka fitur <b>Dropship</b> tidak aktif di Komunitas ini </small>
						                      </div>
					                      </div>
					                      <div class="col-sm-6">
						                    	<div class="form-group">
						                        <label>Matikan fitur Affiliate di Komunitas ini</label>
						                        <div class="custom-control custom-switch">
								                      <input type="checkbox" class="custom-control-input" id="customSwitchAff" name="is_affiliate">
								                      <label class="custom-control-label" for="customSwitchAff"></label>
								                    </div>
						                        <small><code>*</code> Jika mengaktifkan ini maka fitur <b>Affiliate</b> tidak aktif di Komunitas ini </small>
						                      </div>
					                      </div>
					                      <div class="col-sm-12">
							                  	<label class="mb-0">Note Affiliate</label><br>
						                      <small><i>Ini akan muncul dihalaman affiliate user</small></i></small>
							                  	<textarea id="compose-textarea" class="form-control" name="text" style="height: 300px"  ></textarea>
							                  </div>
				                  			<div class="col-md-12">
				                  				<b>Template WhatsApp</b><br>
				                  				<p><small>Template Text Whatsapp jika pendaftar mengklik tombol 'Konfirmasi ke Admin' setelah daftar komunitas</small></p>
				                  				<p>
	                            	  	<b>tebal</b> = gunakan *...* untuk menebalkan text di WhatsApp<br>
	                            	  	<i>miring</i> = gunakan _..._ untuk memiringkan text di WhatsApp<br>
	                            	  	<span style="text-decoration: line-through;">coret</span> = gunakan ~...~ untuk coret text di WhatsApp<br>
	                            	  	{rp} untuk menampilkan harga saat pendaftar mengkonfirmasi/klik tombol whatsapp
	                            	  </p>	
				                  				<textarea class="form-control" name="wa_template" placeholder="template whatsapp"></textarea>
				                  				<hr>
				                  			</div>
				                  			<div class="col-md-4">
				                  				<b>Header Komunitas</b>
				                  				<p><small>Ketika Member membuka/mengunjungi memberarea komunitasmu</small></p>
				                  				<textarea class="form-control" name="header" placeholder="insert header"></textarea>
				                  				<small><i>Javascript code</i></small>
				                  				<br>
				                  			</div>
				                  			<div class="col-md-4">
				                  				<b>Header Register Form</b>
				                  				<p><small>Ketika Form Pendaftaran Dikunjungi oleh pendaftar maka Code dibawah ini akan terpanggil</small></p>
				                  				<textarea class="form-control" name="header_form" placeholder="insert header"></textarea>
				                  				<small><i>Javascript code</i></small>
				                  				<br>
				                  			</div>
				                  			<div class="col-md-4">
				                  				<b>Header Invoice</b>
				                  				<p><small>Setelah seseorang daftar ke komunitasmu/masuk ke haaman invoice, maka Code dibawah ini akan terpanggil atau ter-trigger</small></p>
				                  				<textarea class="form-control" name="header_invoice" placeholder="insert header"></textarea>
				                  				<small><i>Javascript code</i></small>
				                  				<br>
				                  			</div>
						                  </div>
			                  			<div class="col-md-12">
			                  				<hr>
						                  </div>
						                  <button type="submit" name="submitBisnisKomunitas" class="btn-block btn btn-warning">Tambah Komunitas Bisnis</button>
						                </form>
					                  <br>
				                  <?php else: ?>
				                  	<div class="alert alert-danger">
				                  		<i class="fa fa-info-circle"></i> Kuota Komunitas yang bisa kamu buat telah mencapai batas, silahkan Upgrade Paket untuk mendapatkan tambahan kuota
				                  	</div>
				                  <?php endif; ?>
				                  <hr>
				                  <h4>Kuota Komunitas <span class="badge badge-danger"><?php echo $countComunity.'/'.$paket; ?></span></h4>
				                  <br>
				                  <div class="table-responsive">
					                  <table class="table table-striped dt">
						                  <thead>
						                    <tr>
						                      <th style="width: 10px">#</th>
						                      <th>Bisnis Komunitas</th>
						                      <th>Komisi</th>
						                      <th>Harga</th>
						                   
						                      <th></th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                  	<?php $no=1; foreach ($onMy->tampil_manual('select * from komunitas_bisnis where id_user = "'.$_COOKIE['id_akun_combi'].'" order by id desc') as $value): ?>
							                    <tr>
							                      <td><?php echo $no++ ?></td>
							                      <td><?php echo $value['nama_komunitas'] ?></td>
							                      <td>Rp<?php echo $onMy->nf($value['komisi_affiliate_join']) ?></td>
							                      <td>Rp<?php echo $onMy->nf($value['harga']) ?></td>

							                      <td>
							                      	<div class="btn-group btn-sm">
										                    <button type="button" class="btn btn-warning">Opsi</button>
										                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
										                      <span class="sr-only">Toggle Dropdown</span>
										                    </button>
										                    <div class="dropdown-menu" role="menu" style="">
										                      <a class="dropdown-item" href="<?php echo $onMy->primaryLocal ?>admin/pengaturan/komunitas/edit?id=<?php echo $value['id'] ?>">Edit/View</a>
										                      <div class="dropdown-divider"></div>
										                      <!-- <a class="dropdown-item" onclick="return confirm('Yakin menghapus Komunitas Bisnis ini ?, semua yang berhubungan dengan Komunitas Bisnis ini akan hilang juga')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $value['id'] ?>&table=<?php echo base64_encode('komunitas_bisnis') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a> -->

										                    </div>
										                  </div>
							                      </td>
							                    </tr>
						                  	<?php endforeach ?>
						                    
						                  </tbody>
						                </table>
					                </div>
			                  </div>
			                  <div class="tab-pane" id="custom-tabs-four-papan" role="tabpanel" aria-labelledby="custom-tabs-four-papan">
			                  	<form action="" method="post">
				                  	<h5>Buat pengumuman atau informasikan sesuatu kepada membermu</h5>
			                  		<?php $onMy->inputRedirectFull() ?>
				                  	<small><code>*</code> Papan pengumuman/info untuk komunitas <?php echo $namaKomunitas ?></small>

			                  		<input type="hidden" name="id_komunitas_bisnis" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
				                  	<hr>
				                  	<label class="mb-0">Judul</label><br>
				                  	<input type="text" name="judul" class="form-control" required maxlength="50">
				                  	<label class="mb-0">Penjelasan Informasi</label><br>
				                  	<textarea class="form-control editor-input" name="text" style="height: 300px" required>
			                        ...
			                      </textarea>
			                      <button name="submitPapan" class="btn btn-sm btn-warning btn-block">Umumkan</button>
					                </form>
					                <hr>
		                      <br>
		                      <h6>Informasi Yang Sudah Dibuat</h6>
		                      <div id="accordion">
		                      	<?php $no=0; foreach ($onMy->selectWithBussiness('papan_informasi', $_SESSION['bisnis_kategori_combi']) as $info): $no++; ?>
				                      <div class="card card-warning card-outline">
						                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne<?php echo $no ?>" aria-expanded="false">
						                        <div class="card-header">
						                            <h4 class="card-title w-100">
						                                <?php echo $no.'. '.$info['title'] ?>
						                            </h4>
						                        </div>
						                    </a>
						                    <div id="collapseOne<?php echo $no ?>" class="collapse" data-parent="#accordion" style="">
						                        <div class="card-body">
						                        	<div class="btn-group">
										                    <button type="button" class="btn btn-default">Action</button>
										                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
										                      <span class="sr-only"></span>
										                    </button>
										                    <div class="dropdown-menu" role="menu">
										                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus informasi ini ?')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $info['id'] ?>&table=<?php echo base64_encode('papan_informasi') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
										                    </div>
										                  </div>
										                  <hr>
					                            <?php echo $info['text'] ?>
						                        </div>
						                    </div>
							                </div>
		                      	<?php endforeach ?>
					                </div>
			                  </div>
			                  <div class="tab-pane" id="custom-tabs-four-rule" role="tabpanel" aria-labelledby="custom-tabs-four-rule">
			                  	<h5>Buat Aturan, Ketentuan atau Rule untuk komunitasmu ini</h5>
			                  	<small><code>*</code> Aturan/Rule untuk komunitas <?php echo $namaKomunitas ?></small>

			                  	<form action="" method="post">
			                  		<?php $onMy->inputRedirectFull() ?>
			                  		<input type="hidden" name="id" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
				                  	<textarea class="editor-input" name="rule">
				                  		<?php echo $profileKomunitas['rule'] ?>
				                  	</textarea>
				                  	<button class="btn btn-sm btn-block btn-warning" name="submitRule">Simpan</button>
			                  	</form>
			                  </div>
			                  <div class="tab-pane" id="custom-tabs-four-faq" role="tabpanel" aria-labelledby="custom-tabs-four-faq">
			                  	<form action="" method="post">
			                  		<?php $onMy->inputRedirectFull() ?>
			                  		<input type="hidden" name="id_komunitas_bisnis" value="<?php echo $_SESSION['bisnis_kategori_combi'] ?>">
				                  	<h5>Buat FAQ Untuk Komunitasmu Jika Diperlukan</h5>
				                  	<small><code>*</code> FAQ untuk komunitas <?php echo $namaKomunitas ?></small>
				                  	<hr>
				                  	<label class="mb-0">Judul</label><br>
				                  	<input type="text" name="judul" class="form-control" required maxlength="50">
				                  	<label class="mb-0">Penjelasan</label><br>
				                  	<textarea class="form-control editor-input" name="text" style="height: 300px" required>
			                        <br>
			                        <br>
			                      </textarea>
			                      <button name="submitFaq" class="btn btn-sm btn-warning btn-block">Tambahkan</button>
					                </form>
		                      <hr>
		                      <br>
		                      <h6>FAQ Yang Sudah Dibuat</h6>
		                      <div id="accordion">
		                      	<?php $no=0; foreach ($onMy->selectWithBussiness('faq', $_SESSION['bisnis_kategori_combi']) as $faq): $no++; ?>
				                      <div class="card card-warning card-outline">
						                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne<?php echo $no ?>" aria-expanded="false">
						                        <div class="card-header">
						                            <h4 class="card-title w-100">
						                                <?php echo $no.'. '.$faq['title'] ?>
						                            </h4>
						                        </div>
						                    </a>
						                    <div id="collapseOne<?php echo $no ?>" class="collapse" data-parent="#accordion" style="">
						                        <div class="card-body">
						                        	<div class="btn-group">
										                    <button type="button" class="btn btn-default">Action</button>
										                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
										                      <span class="sr-only"></span>
										                    </button>
										                    <div class="dropdown-menu" role="menu">
										                      <a class="dropdown-item" onclick="return confirm('Yakin menghapus faq ini ?')" href="<?php echo $onMy->primaryLocal ?>admin/hapus?id=<?php echo $faq['id'] ?>&table=<?php echo base64_encode('faq') ?>&url=<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">Hapus</a>
										                    </div>
										                  </div>
										                  <hr>
					                            <?php echo $faq['text'] ?>
						                        </div>
						                    </div>
							                </div>
		                      	<?php endforeach ?>
					                </div>
			                  </div>
			                  <div class="tab-pane" id="custom-tabs-four-rek" role="tabpanel" aria-labelledby="custom-tabs-four-rek">
			                  	<h5>Masukan Nomor Rekening atau E-Wallet</h5>
			                  	<p><small>Nomor rekening atau E-Walletmu akan menjadi metode pengiriman komisi</small></p>
			                  	<hr>
			                  	<form method="post" action="">
			                  		<?php $onMy->inputRedirectFull() ?>
			                  		<div class="row child-p">
			                  			<div class="col-md-2"><b>PAYMENT METHOD</b><br>
			                  				<p>Masukan Nama/keterangan Payment Method seperti Trasfer Bank, E-Wallet(Shopeepay, DANA, OVO dll) atau lainnya</p></div>
			                  			<div class="col-md-2"><b>KODE</b><br>
			                  				<p>Masukan Kode tambahan seperti Kode Bank jika menggunakan bank transfer tau lainnya sesuai kebutuhan</p></div>
			                  			<div class="col-md-3"><b>NO REKENING/NOMOR LAINNYA</b><br>
			                  				<p>Masukan Nomor Rekening atau nomor lainnya yang digunakan nantinya untuk transfer</p></div>
			                  			<div class="col-md-3"><b>NAMA PEMILIK</b><br>
			                  				<p>Masukan nama pemilik nomor rekening atau nama pemilik e-waller</p></div>
			                  		</div>
			                  		<div class="row loopRek">
			                  			<?php $no=0; foreach ($onMy->select('norek', $_COOKIE['id_akun_combi']) as $val): $no++; ?>
				                  			<div class="col-md-2  num numlooprek<?php echo $no ?>">
				                  				<input type="text" class="form-control" name="nama[]" placeholder="Payment Method" value="<?php echo $val['nama_bank'] ?>">
				                  			</div>
				                  			<div class="col-md-2 numlooprek<?php echo $no ?>">
				                  				<input type="text" class="form-control" name="kode[]" placeholder="Kode" value="<?php echo $val['kode_bank'] ?>">
				                  			</div>
				                  			<div class="col-md-3 numlooprek<?php echo $no ?>">
				                  				<input type="number" class="form-control" name="nomor[]" placeholder="Nomor Rekening/lainnya" value="<?php echo $val['norek'] ?>">
				                  			</div>
				                  			<div class="col-md-3 numlooprek<?php echo $no ?>">
				                  				<input type="text" class="form-control" name="pemilik[]" placeholder="Nama pemilik" value="<?php echo $val['nama_pemilik'] ?>">
				                  			</div>
				                  			<div class="col-md-2 numlooprek<?php echo $no ?>">
					                  			<?php if ($no<=1): ?>
						                  				<button type="button" onclick="return loopRek()" class="btn btn-warning"><i class="fa fa-plus"></i></button>
					                  			<?php else: ?>
					                  				<button type="button" onclick="return loopRemove(`<?php echo $no ?>`)" class="btn btn-danger"> <i class="fa fa-times"></i> </button>
					                  			<?php endif ?>
				                  			</div>
			                  			<?php endforeach ?>
			                  			<?php if ($no == 0): ?>
			                  				<div class="col-md-2  num numlooprek">
				                  				<input type="text" class="form-control" name="nama[]" placeholder="Payment Method" value="<?php echo $val['nama_bank'] ?>">
				                  			</div>
				                  			<div class="col-md-2 numlooprek">
				                  				<input type="text" class="form-control" name="kode[]" placeholder="Kode" value="<?php echo $val['kode_bank'] ?>">
				                  			</div>
				                  			<div class="col-md-3 numlooprek">
				                  				<input type="number" class="form-control" name="nomor[]" placeholder="Nomor Rekening/lainnya" value="<?php echo $val['norek'] ?>">
				                  			</div>
				                  			<div class="col-md-3 numlooprek">
				                  				<input type="text" class="form-control" name="pemilik[]" placeholder="Nama pemilik" value="<?php echo $val['nama_pemilik'] ?>">
				                  			</div>
				                  			<div class="col-md-2 numlooprek">
				                  				<button type="button" onclick="return loopRek()" class="btn btn-warning"><i class="fa fa-plus"></i></button>
				                  			</div>
			                  			<?php endif ?>
			                  		</div>
			                  		<div class="row child-p">
			                  			<div class="col-md-12">
			                  				<label>Tampilkan gambar</label>
			                  				<p>Gambar-gambar dibawah ini akan muncul di invoice, NB : Ini hanya icon, jika tidak ada icon metode pembayaran yang Anda gunakan, bisa kosongkan saja </p>
			                  				<?php
			                  					$arrayBank = explode(',', $profile['logo_bank']);
			                  					// echo var_dump($arrayBank);
																		$bankLogo = array(
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bsi.png', 'BSI'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-jenius.png', 'JENIUS'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bni.jpeg', 'BNI'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-mandiri.png', 'MANDIRI'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-cimb.png', 'CIMB'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bri.png', 'BRI'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bca.png', 'BCA'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-ovo.png', 'OVO'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-gopay.png', 'GOPAY'),
																				array('https://remotebisnis.com/wp-content/uploads/2021/10/logo-dana.png', 'DANA')
																			)
			                  				?>
				                        <select class="form-control select2bs4" name="gambarbank[]" multiple>
																		<?php foreach ($bankLogo as $lb): ?>
																			<option <?php echo (array_search($lb[0], $arrayBank)) ? 'selected' : '' ; ?> data-image="<?php echo $lb[0] ?>" value="<?php echo $lb[0] ?>"><?php echo $lb[1] ?></option>
																		<?php endforeach ?>
					                      </select>
			                  			</div>
			                  			<div class="col-md-12 hide">
			                  				<b>Catatan</b><br>
			                  				<p>Masukan catatan (jika ada), ini akan ditampilkan dibawah invoice setelah mendaftar komunitas</p>
			                  				<textarea class="form-control" name="note" placeholder=""><?php echo $profile['note_after_invoice'] ?></textarea>
			                  				<hr>
			                  			</div>

			                  			<div class="col-md-12">
			                  			<hr>
			                  				<button type="submit" name="submitNoRek" class="btn-block btn btn-warning btn-sm">Simpan</button>
			                  			</div>
			                  		</div>

			                  	</form>
			                  </div>
			                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
			                  	<h5>Sesuaikan Profilemu</h5>
			                  	<hr>
			                  	<form action="" method="post">
			                  		<input required type="hidden" class="form-control" name="redirect" value="<?php echo parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>">
				                  	<div class="row">
					                  	<div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Username</label>
					                        <input required type="text" disabled class="form-control" value="<?php echo $user['username'] ?>">
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Email</label>
					                        <input required type="text" disabled class="form-control" value="<?php echo $user['email'] ?>">
					                        <small>E-Mail tidak bisa di ubah</small>
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>No Wa</label>
					                        <input required type="number" class="form-control" name="no_wa" value="<?php echo $user['nowa'] ?>">
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Nama Lengkap</label>
					                        <input required type="text" class="form-control" name="nama_lengkap" value="<?php echo $user['nama_lengkap'] ?>">
					                      </div>
					                    </div>
					                     
					                     <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Jenis Kelamin</label>
					                        <select class="form-control" name="jk">
					                        	<option <?php if($user['jk'] == 'L'){ echo 'selected'; } ?> value="L">L</option>
					                        	<option <?php if($user['jk'] == 'P'){ echo 'selected'; } ?> value="P">P</option>
					                        </select>
					                      </div>
					                    </div>
					                    <div class="col-sm-3">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Tanggal Lahir</label>
					                        <input required type="date" class="form-control" name="tanggal_lahir" value="<?php echo $user['tgl_lahir'] ?>">
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Domisili</label>
					                        <select class="form-control s2" name="domisili">
					                        	<?php 
					                        		foreach ($onMy->tampil_manual('select * from domisili') as $value): 
				                        				$selected = '';
					                        			if ($value['nama'] == $user['domisili']) {
					                        				$selected = 'selected';
					                        			}
					                        	?>
						                        	<option value="<?php echo $value['nama'] ?>" <?php echo $selected ?>><?php echo $value['nama'] ?></option>
					                        	<?php endforeach ?>
					                        </select>
					                      </div>
					                    </div>
					                    <!-- <div class="col-sm-6">
					                      
					                      <div class="form-group">
					                        <label>Kode Affiliate</label>
					                        <input required type="text" class="form-control" disabled value="<?php echo $user['kode_affiliate'] ?>">
					                      </div>
					                    </div> -->
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Pilih Avatar</label>
					                        <select class="form-control s2" name="avatar">
					                        	<?php
																			$files = glob('dist/img/avatar/*.png');
																			foreach($files as $file) {
																				$active = '';
																				if (basename($file, '.png') == basename($profile['dp'], '.png')) {
																					$active = 'selected';
																				}
					                        	?>
						                        	<option <?php echo $active ?> value="<?php echo basename($file) ?>" data-image="<?php echo $onMy->primaryLocal.$file ?>"><?php echo basename($file, '.png') ?></option>
						                        <?php } ?>
						                      </select>
					                      </div>
					                    </div>
				                    </div>
					                  <button type="submit" name="submitUpdateProfile" class="btn btn-warning">Update Profile</button>
				                  </form>
				                  <hr>
				                  <h5>Ubah Password</h5>
				                  <div class="row">
				                  	<div class="col-md-3">
						                  <form method="post" action="">
						                  	<div class="form-group">
						                  		<label>Password lama</label>
						                  		<input type="password" name="old_pass" required class="form-control" placeholder="Masukan Password lama">
						                  	</div>
						                  	<div class="form-group">
						                  		<label>Password Baru</label>
						                  		<input type="password" name="new_pass" required class="form-control" placeholder="buat password baru">
						                  	</div>
						                  	<div class="form-group">
						                  		<label>Ulangi Password Baru</label>
						                  		<input type="password" name="new_pass2" required class="form-control" placeholder="ulangi password baru">
						                  	</div>
						                  	<div class="form-group">
						                  		<button class="btn btn-block btn-warning" name="updatePassword">Ubah password</button>
						                  	</div>
						                  </form>
				                  	</div>
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
    document.title = "KOMBI | Atur Profile & Komunitasmu disini";

		var menuaddclass = document.getElementById("pengaturan");
		menuaddclass.classList.add("active");
		function loopRek(){
			var loppLength = $('.num').length + 1;
			$('.loopRek').append(`<div class="col-md-2 num numlooprek`+loppLength+`">
		                  				<input type="text" class="form-control" name="nama[]" placeholder="Payment Method">
		                  			</div>
		                  			<div class="col-md-2 numlooprek`+loppLength+`">
		                  				<input type="text" class="form-control" name="kode[]" placeholder="Kode">
		                  			</div>
		                  			<div class="col-md-3 numlooprek`+loppLength+`">
		                  				<input type="number" class="form-control" name="nomor[]" placeholder="Nomor Rekening/lainnya">
		                  			</div>
		                  			<div class="col-md-3 numlooprek`+loppLength+`">
		                  				<input type="text" class="form-control" name="pemilik[]" placeholder="Nama Pemilik">
		                  			</div>
		                  			<div class="col-md-2 numlooprek`+loppLength+`">
		                  				<button type="button" onclick="return loopRemove(`+loppLength+`)" class="btn btn-danger"> <i class="fa fa-times"></i> </button>
		                  			</div>
		                  			`)
		}
		function loopRemove(id){
			$('.numlooprek'+id).remove();
		}

	</script>
<?php
  require('footer.php');
?>