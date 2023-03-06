<?php
  require('header_user.php');
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
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>user/pengaturan">Pengaturan</a></li>
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
	                <h3 class="card-title">Pengaturan & Profile</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
                <div class="card-body">
                	<div class="card card-warning card-outline card-outline-tabs">
			              <div class="card-header p-0 border-bottom-0">
			                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			                  <li class="nav-item">
			                    <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile Saya</a>
			                  </li> 
			                  <li class="nav-item">
			                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-rek" role="tab" aria-controls="custom-tabs-four-rek" aria-selected="false">Rekening</a>
			                  </li>
			                </ul>
			              </div>
			              <div class="card-body">
			                <div class="tab-content" id="custom-tabs-four-tabContent">
			                  <div class="tab-pane fade active show" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
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
					                        <small><em><code>*</code>E-Mail tidak bisa di ubah</em></small>
					                      </div>
					                    </div>
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>No Wa</label>
					                        <input required type="text" class="form-control" name="no_wa" value="<?php echo $user['nowa'] ?>">
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
					                        <label>Tanggal Lahir</label>
					                        <input required type="date" class="form-control" name="tanggal_lahir" value="<?php echo $user['tgl_lahir'] ?>">
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
					                    <div class="col-sm-6">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>Pilih Avatar</label>
					                        <select class="form-control s2" name="avatar">
					                        	<?php
																			$files = glob('dist/img/avatar/*.png');
																			foreach($files as $file) {
																				$active = '';
																				// echo basename($file, '.png') .' x '. basename($profile['dp'], '.png');
																				if (basename($file, '.png') == basename($profile['dp'], '.png')) {
																					$active = 'selected';
																				}
					                        	?>
						                        	<option <?php echo $active ?> value="<?php echo basename($file) ?>" data-image="<?php echo $onMy->primaryLocal.$file ?>"><?php echo basename($file, '.png') ?></option>
						                        <?php } ?>
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
					                        <label>Private</label>
					                        <div class="custom-control custom-switch">
							                      <input type="checkbox" class="custom-control-input" id="customSwitch" name="private" <?php if ($profile['is_private'] == '1'){ echo 'checked'; } ?>>
							                      <label class="custom-control-label" for="customSwitch"></label>
							                    </div>
					                        <small><code>*</code> <i>Jika Private di aktifkan maka Jumlah Affiliate, Transaksi Dropship anda tidak akan bisa di lihat oleh member lain, <u>tapi admin tetap bisa melihat</u></i></small>
					                      </div>
					                    </div>
					                    <!-- <div class="col-sm-6">
					                      
					                      <div class="form-group">
					                        <label>Type Pengguna</label>
					                        <p><b><?php echo $user['type_user'] ?></b></p>
					                      </div>
					                    </div> -->
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
						                  		<input type="password" name="old_pass" class="form-control" required placeholder="Masukan Password lama">
						                  	</div>
						                  	<div class="form-group">
						                  		<label>Password Baru</label>
						                  		<input type="password" name="new_pass" class="form-control" required placeholder="buat password baru">
						                  	</div>
						                  	<div class="form-group">
						                  		<label>Ulangi Password Baru</label>
						                  		<input type="password" name="new_pass2" class="form-control" required placeholder="ulangi password baru">
						                  	</div>
						                  	<div class="form-group">
						                  		<button class="btn btn-block btn-warning" name="updatePassword">Ubah password</button>
						                  	</div>
						                  </form>
				                  	</div>
				                  </div>
			                  </div>
			                  <div class="tab-pane" id="custom-tabs-four-rek" role="tabpanel" aria-labelledby="custom-tabs-four-rek">
			                  	<form method="post" action="">
			                  		<?php $onMy->inputRedirectFull() ?>
			                  		<div class="row child-p2">
			                  			<div class="col-md-12">
			                  				<p><small><code>*</code> Nomor rekening ini akan dijadikan metode pencairan komisi, pastikan nomor rekening benar.</small></p>
			                  			</div>
			                  			<hr>
			                  			<div class="col-md-2"><b>PAYMENT METHOD</b><br>
			                  				<p>Masukan nama/keterangan Payment Method seperti Trasfer Bank, E-Wallet(Shopeepay, DANA, OVO dll) atau lainnya</p></div>
			                  			<div class="col-md-2"><b>KODE</b><br>
			                  				<p>Masukan Kode tambahan seperti Kode Bank jika menggunakan bank transfer tau lainnya sesuai kebutuhan</p></div>
			                  			<div class="col-md-3"><b>NO REKENING/NOMOR LAINNYA</b><br>
			                  				<p>Masukan Nomor Rekening atau nomor lainnya yang digunakan nantinya untuk transfer</p></div>
			                  			<div class="col-md-3"><b>NAMA PEMILIK</b><br>
			                  				<p>Masukan nama pemilik nomor rekening atau nama pemilik E-wallet</p></div>
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
			                  		<div class="row">
			                  			<div class="col-md-12">
			                  				<button type="submit" name="submitNoRek" class="btn-block btn btn-warning btn-sm">Simpan</button>
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
		document.title = "KOMBI | Profile dan pengaturan";
		var menuaddclass = document.getElementById("pengaturan");
		menuaddclass.classList.add("active");
	  $(function () {
			$('#customSwitch').click(function(){
				alert();
				// $(this).text(function(i, text){
	   //      var text === "PUSH ME" ? "DON'T PUSH ME" : "PUSH ME";
	   //      $('.custom-control-label').text(text);
	   //    })
			});  	
	  });
	  $(document).ready(function(){
        $('#customSwitch').click(function(){
				alert();
            // if($(this).prop("checked") == true){
            //     console.log("Checkbox is checked.");
            // }
            // else if($(this).prop("checked") == false){
            //     console.log("Checkbox is unchecked.");
            // }
        });
    });
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