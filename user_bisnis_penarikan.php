<?php 
	// melanjutkan fitur penarikan komisi
  require('header_user.php');
  $komisi = $onMy->getDataAffiliate($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi']);
  $sql= 'select * from pengajuan where id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by id desc';

  $pengajuan = $onMy->tampil_manual($sql.' limit 10');

  $newPengajuan = $onMy->eksekusiShow($sql.' limit 1');

  // echo 'select * from pengajuan id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by id desc';
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pengajuan Penarikan Komisi</h1>
        </div><!-- /.col -->
        <div class="col-sm-12">
          <?php $onMy->callFlash() ?>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
	<div class="row">
		<div class="col-md-12 p-4">
			<div class="card card-default collapsed-card">
        <div class="card-header">
          <h3 class="card-title">Pengajuan Mengurangi/Menambahan Komisi
          </h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
				
        <div class="card-body" style="">
					<div class="table-responsive">
	        	<table class="table table-striped table-hover dt">
							<thead>
								<tr>
									<th>No</th>
									<th>Admin mengajukan</th>
									<th>Nilai</th>
									<th>Tanggal</th>
									<th>Status/Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; foreach ($sistem->tampil_manual('select * from manage_komisi where id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by id desc limit 100') as $value): 
										if ($value['status'] == '1') {
											$stt = "<span class='badge badge-info'>Belum di proses</span>";
										}elseif ($value['status'] == '2') {
											$stt = "<span class='badge badge-danger'>Anda Menolak ini</span>";
										}elseif ($value['status'] == '3') {
											$stt = "<span class='badge badge-warning'>Komisi telah ditambahkan</span>";
										}


								?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td>
											<?php
												if ($value['operator'] == '+') {
													echo "Penambahan Komisi";
													$nilai = '<label class="text-success"><i class="fa fa-plus "></i> Rp'.$onMy->nf($value['nilai']).'<label>';
												}else{
													echo "Pengurangan Komisi";
													$nilai = '<label class="text-danger"><i class="fa fa-minus "></i> Rp'.$onMy->nf($value['nilai']).'<label>';
												}
											?>
										</td>
										<td><?php echo $nilai ?></td>
										<td><?php echo $onMy->time_elapsed_string($value['created_at']) ?></td>
										<td>
											<?php
												echo $stt;
											?>
											<?php if ($value['status'] == 1): ?>
												<div class="btn-group btn-sm">
			                    <button type="button" class="btn btn-warning">Action</button>
			                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
			                      <span class="sr-only">Toggle Dropdown</span>
			                    </button>
			                    <div class="dropdown-menu" role="menu" style="">
			                      <a class="dropdown-item" onclick="return confirm('Yakin menyetujui ini ?')" href="<?php echo $sistem->primaryLocal ?>user/acc/komisi?id=<?php echo $value['id'] ?>&status=3">Setuju	</a>
			                      <a class="dropdown-item" onclick="return confirm('Yakin menolak ini ?')" href="<?php echo $sistem->primaryLocal ?>user/acc/komisi?id=<?php echo $value['id'] ?>&status=2">Tolak</a>
			                    </div>
			                  </div>
											<?php endif ?>
										</td>
								 
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
	        </div>
        </div>
      </div>
		</div>
		<div class="col-md-12">
			<div class="text-center p-3">
				<form action="" method="post" id="formid">
          <?php $onMy->inputRedirectFull() ?>
					<h5> Saldo/Komisi Anda</h5>
					<h1><i class="fa fa-money-bill"></i> Rp<?php echo $onMy->nf($komisi['komisi_belum_cair']) ?></h1>
					<?php if ($newPengajuan['status'] != 0 || !$newPengajuan): ?>
						<input type="number" id="jumlah_penarikan" onkeyup="return cekNilai()" required class="form-control-lg form-control text-center" name="nilai" placeholder="Masukan jumlah penarikan">
						<br>
						<button type="submit" name="submitAjukanKomisi" id="submitAjukanKomisi" class="btn btn-warning btn-lg btn-block">	Ajukan Penarikan</button>
						<small><code>*</code> Penarikan yang sudah di ajukan tidak bisa di batalkan, kecuali admin yang membatalkan</small><br>
						<small><code>*</code> Pastikan nomor rekening sudah benar</small><br>
					<?php else: ?>
						<div class="alert alert-info">
						<i class="fa fa-info-circle"></i> Anda belum bisa mengajukan penarikan komisi
					</div>
					<?php endif ?>
					<hr>
				</form>
			</div>
		</div>
		<div class="col-md-7 m-auto text-center">
			<h5>History Penarikan</h5>
			<div class="table-responsive">
				<em>*Menampilkan 10 history teratas</em>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Waktu Pengajuan Anda</th>
							<th>Komisi Ditarik/Diajukan</th>
							<th>Sisa Komisi</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($pengajuan as $value): ?>
							<tr>
								<td><?php echo $onMy->convertDate('d F Y H:i:s', $value['created_at']) ?></td>
								<td>Rp <?php echo $onMy->nf( $value['saldo_ditarik'] ) ?></td>
								<td>Rp <?php echo $onMy->nf( $value['sisa_saldo'] ) ?></td>
								<td>
									<?php if ($value['status'] == '1'): ?>
										<span class="badge badge-warning">Sudah di transfer</span>
									<?php elseif($value['status'] == '0'): ?>
										<span class="badge badge-info">Belum di Proses</span>
									<?php else: ?>
										<span class="badge badge-danger">Ditolak</span><br>
									<?php endif ?>
									<small>Note : <?php echo $value['alasan'] ?></small>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	document.title = "KOMBI | Komisi & Penarikan <?php echo $komunitas['nama_komunitas'] ?>";
	      var menuaddclass = document.getElementById("bisnis");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("komisi");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("bisnis-open");
    menuaddclass3.classList.add("menu-open");

  function cekNilai(){
  	var n = $('#jumlah_penarikan');
  	if (n.val() > <?php echo $komisi['komisi_belum_cair'] ?>) {
  		n.val(<?php echo $komisi['komisi_belum_cair'] ?>);
  	}
  }
</script>
<?php 
  require('footer.php');
?>