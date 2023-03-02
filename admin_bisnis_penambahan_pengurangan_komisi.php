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
          <h1 class="m-0">Atur Komisi</h1>
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
	  	<div class="row">
		   <div class="col-md-12">
          <!-- Box Comment -->
          <div class="card card-widget collapsed-card">
            <div class="card-header">
              <div class="user-block">
                <b><a href="#">Mengurangi/Menambahan Komisi</a></b>
              </div>
              <!-- /.user-block -->
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-plus"></i>
                </button>        
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display:none;">
              <div class="alert alert-warning">
                Gunakan fitur ini untuk menambah atau mengurangi komisi Affiliate jika kondisi tertentu terjadi, seperti :
                <ul>
                	<li>Memberi Bonus Komisi/Saldo Pada Affiliate</li>
                	<li>Jika terjadi kesalahan pencantuman komisi</li>
                	<li>Kelebihan/kekurangan Transfer</li>
                	<li>Pembatalan pesanan</li>
                	<li>Deposit Saldo</li>
                </ul>
              </div>
              <div class="table-responsive">
 								<table class="table table-striped table-bordered dt">
				      		<thead>
				      			<tr> 
				      				<th>NAMA/KOMISI</th>
				      				<th>HISTORI</th>
				      			</tr>
				      		</thead>
				      		<tbody>
				      			<?php 
				      				$no=1; 
				              $postPaginate = $onMy->tampil_manual(' select *, k.id as idk, u.id as idu from users as u join komunitas as k on k.id_user = u.id where k.id_komunitas = '.$_SESSION['bisnis_kategori_combi'].' '.$cari.' and k.status =1 order by u.nama_lengkap asc');

					      				foreach ($postPaginate as $value): 
					      					// $onMy->debug = true;
					      					$saldo = $onMy->getDataAffiliateAdmin($value['idu'], $_SESSION['bisnis_kategori_combi']);
					      			?>
					      			<tr> 
					      				<td>
					      					<?php echo $value['nama_lengkap'] ?><br>
						      				<div class="card card-default collapsed-card">
							              <div class="card-header">
							                <h3 class="card-title">Saldo/Komisi <b>Rp<?php echo $onMy->nf($saldo['komisi_belum_cair']) ?></b>
							                </h3>

							                <div class="card-tools">
							                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
							                  </button>
							                </div>
							              </div>
														
							              <div class="card-body" style="">
							              	<form method="post" action="">
							      						<?php $onMy->inputRedirectFull() ?>
							              		<input type="hidden" name="id" value="<?php echo $saldo['id'] ?>">
							              		<input type="hidden" name="id_user" value="<?php echo $value['idu'] ?>">
							              		<input type="number" name="nilai" class="form-control input-sm" placeholder="masukan nilai">
							              		<div class="btn-group btn-block">
								              		<button name="submitAddKomisi" class="btn btn-sm btn-warning"><i class="fa fa-plus"></i> Tambah</button>
								              		<?php if ($saldo['komisi_belum_cair'] != 0): ?>
									              		<button name="submitMinKomisi" class="btn btn-sm btn-warning"><i class="fa fa-minus"></i> Kurangi</button>
								              		<?php endif ?>
							              		</div>
							              	</form>
							              </div>
							            </div>
							          </td>
					      				<td>
					      					<div style="overflow-y: scroll; height: 150px;">
					      						<ul class="unstyled">
					      							<b>Terbaru :</b><br/>
						      						<?php 
																foreach ($sistem->tampil_manual('select * from manage_komisi where id_user='.$value['idu'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by id desc limit 15') as $line): 
																	if ($line['operator'] == '-') {
																		$even = "Pengurangan komisi senilai -Rp".$onMy->nf($line['nilai']);
																	}else{
																		$even = "Penambahan komisi senilai +Rp".$onMy->nf($line['nilai']);
																	}

																	if ($line['status'] == '1') {

																		$stt = "<span class='badge badge-info'>".$even." Belum di terima oleh ".$value['nama_lengkap']."</span>";
																	}elseif ($line['status'] == '2') {
																		 
																		$stt = "<span class='badge badge-danger'>".$value['nama_lengkap']." Menolak ".$even."</span>";
																	}elseif ($line['status'] == '3') {
																		$stt = "<span class='badge badge-warning'>Komisi Rp".$onMy->nf($line['nilai'])." telah ditambahkan pada ".$value['nama_lengkap']."</span>";
																	}
						      						?>
						      							<?php echo $stt ?><br>
						      						<?php endforeach ?>
					      						</ul>
					      					</div>
					      				</td>
					      			</tr>
				      			<?php endforeach ?>
				      		</tbody>
				      	</table>
	            </div>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
	  	</div>
 
	  </div><!-- /.container-fluid -->
	</section>
</div>
<script type="text/javascript">
	document.title = "KOMBI | Manage Komisi dari <?php echo $namaKomunitas ?>";
	    var menuaddclass = document.getElementById("bisnis");
  menuaddclass.classList.add("active");

      var menuaddclassx = document.getElementById("penambahan_pengurangan_komisi");
  menuaddclassx.classList.add("active");

      var menuaddclass3 = document.getElementById("bisnis-open");
  menuaddclass3.classList.add("menu-open");

</script>
<?php
  require('footer.php');
?>