<?php
  require('header.php');
  $sql2 = 'select count(*) as total from pengajuan as p join users as u on u.id =  p.id_user where p.id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'];
  
  $total = $onMy->eksekusiShow($sql2);

  $onMy->registerGeneratePaginate(20, $_GET['halaman'], $total['total']);

  $sql = 'select *, p.id as idp, p.status as stt from pengajuan as p join users as u on u.id =  p.id_user where p.id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by idp desc limit '.$onMy->halaman_awal.','.$onMy->batas;
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">List Pengajuan Komisi Affiliate</h1>
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
	  	 
	    <!-- COLOR PALETTE -->
	    <div class="card card-default color-palette-box">
	      <div class="card-header">
	        <h3 class="card-title">
	          <i class="fa fa-list"></i>
	          Affiliate Mengajukan Penarikan
	        </h3>
	      </div>
	      <div class="card-body">
	      	<div class="table-responsive">
		      	<table class="table table-striped table-bordered">
		      		<thead>
		      			<tr>
		      				<th>No</th>
		      				<th>Nama</th>
		      				<th>Kontak</th>
		      				<th>Komisi/Proses </th>
		      			</tr>
		      		</thead>
		      		<tbody>
		      			<?php $no=1; foreach ($onMy->tampil_manual($sql) as $value): ?>
			      			<tr>
			      				<td><?php echo $no++; ?></td>
			      				<td><?php echo $value['nama_lengkap'] ?></td>
			      				<td><?php echo $value['email'].'<br>'.$value['nowa'] ?></td>
			      				<td>
			      					<div class="card card-default collapsed-card">
					              <div class="card-header">
					                <h3 class="card-title">Pengajuan : <b class="text-warning">Rp<?php echo $onMy->nf($value['saldo_ditarik']) ?></b> 
					                	<?php if ($value['stt'] == '1'): ?>
															<span class="badge badge-warning">Sudah di transfer</span><br>
														<?php elseif($value['stt'] == '0'): ?>
															<span class="badge badge-info">Perlu di Proses</span><br>
														<?php else: ?>
															<span class="badge badge-danger">Ditolak</span><br>
														<?php endif ?>
														<small>Catatan : <?php echo $value['alasan'] ?></small>
					                </h3>

					                <div class="card-tools">
					                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
					                  </button>
					                </div>
					              </div>
												
					              <div class="card-body" style="display: none;">
					                Ditarik/Pengajuan : <b class="text-warning">Rp<?php echo $onMy->nf($value['saldo_ditarik']) ?></b> <br> Waktu Pengajuan : <?php echo $onMy->convertDate( 'd F Y H:i:s',$value['created_at']) ?><br> Sisa Komisi : <b data-toggle="tooltip" data-placement="top" data-original-title="Sisa komisi ini sudah dikurangi oleh Pengajuan ini, jika pengajuan ini Anda Tolak maka pengajuan ini akan dimasukan/tambahkan kembali ke komisi Affiliate <?php echo $value['nama_lengkap'] ?>">Rp<?php echo $onMy->nf( $value['sisa_saldo'] ) ?> <i class="fa fa-info-circle"></i></b> <br><hr> 

					                <?php if($value['stt'] == '0'): ?>
						                Transfer Senilai <b class="text-warning">Rp<?php echo $onMy->nf($value['saldo_ditarik']) ?></b> ke salah satu dari berikut ini <br>
						      					<div style="height: 150px; overflow:scroll; background: whitesmoke;" class="p-2">
										          <?php foreach ($onMy->select('norek',$value['id_user']) as $val): ?>
						      							<b><?php echo $val['nama_bank'] ?></b>
						      							<br><?php echo $val['nama_pemilik'] ?><br>
						      							<span class="bg-info p-1"><?php if(!empty($val['kode_bank'])){ echo '('.$val['kode_bank'].')'; } ?> <?php echo $val['norek'] ?></span>
						      							<hr>
						      						<?php endforeach ?>
						      					</div>
						      					<hr>
						      					<form action="" method="post">
						      						<?php $onMy->inputRedirectFull() ?>
						      						<input type="hidden" name="id_pengajuan" value="<?php echo $value['idp'] ?>">
							      					<div class="input-group input-group-sm mb-3">
							                  <div class="input-group-prepend">
							                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							                      Pilih Proses
							                    </button>
							                    <ul class="dropdown-menu" style="">
							                      <li class="dropdown-item"><button type="submit" onclick="return confirm('Yakin sudah transfer ke <?php echo $value['nama_lengkap'] ?> ?, jika belum silahkan transfer sesudah konfirmasi ini')" name="submitAccPengajuan" class="btn btn-sm btn-warning"><i class=" fa fa-check text-info"></i> Sudah di Transfer/Terima</button></li>
							                      <li class="dropdown-item"><button onclick="return confirm('Yakin menolak pencairan komisi dari <?php echo $value['nama_lengkap'] ?> ?')" type="submit" name="submitDecPengajuan" class="btn btn-sm btn-default"><i class=" fa fa-check text-danger"></i> Tolak</button></li>
							                    </ul>
							                  </div>
							                  <!-- /btn-group -->
							                  <input type="text" class="form-control" name="note" placeholder="masukan catatan">
							                </div>
						      					</form>
					      					<?php endif ?>
					              </div>
					            </div>
			      				</td>
			      			</tr>
		      			<?php endforeach ?>
		      		</tbody>
		      	</table>
		      </div>
	      	<?php
	          $onMy->generatePaginate();
	      	?>
	      </div>
	    </div>
	  </div><!-- /.container-fluid -->
	</section>
</div>
<script type="text/javascript">
	document.title = "KOMBI | Halaman Pengajuan Komisi dari <?php echo $namaKomunitas ?>";
	    var menuaddclass = document.getElementById("bisnis");
  menuaddclass.classList.add("active");

      var menuaddclassx = document.getElementById("komisi");
  menuaddclassx.classList.add("active");

      var menuaddclass3 = document.getElementById("bisnis-open");
  menuaddclass3.classList.add("menu-open");

</script>
<?php
  require('footer.php');
?>