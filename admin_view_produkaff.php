<?php  
	require('header.php');
	$id = $onMy->toInt($_GET['id']);
  $onMy->verifDataOwned('order_produk', 'id',  $id);

  $data = $onMy->selectSingleOne('order_produk', 'id', $id);

  $produk = $onMy->selectSingleOne('affiliate_produk', 'id', $data['id_produk']);

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Pesanan  </h1>
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
    	<div class="card">
    		<div class="card-body">
    			<div class="row">
    				<div class="col-md-2">
		    			<p class="text-lg">Produk
								<b class="d-block"><?php echo $produk['judul'] ?></b>
							</p>
    				</div>
    				<div class="col-md-2">
		    			<p class="text-lg">Status</p>
							<?php if ($data['status'] == 3): ?>
								<span class='badge badge-warning'>Sudah di proses</span>
							<?php elseif($data['status'] == 1): ?>
								<span class='badge badge-info'>Belum di proses</span>
							<?php else: ?>
								<span class='badge badge-danger'>Ditolak</span>
							<?php endif ?>
    				</div>
    				<div class="col-md-2">
		    			<p class="text-lg">Jenis Produk</p>
    					<?php if ($produk['non']): ?>
	    					Produk Digital
    					<?php else: ?>
	    					Produk Fisik
    					<?php endif ?>
	    			</div>	
    			</div>	
						<?php if($data['nama']): ?>
		    			<p class="">Nama Penerima/pemesan
								<b class="d-block"><?php echo $data['nama'] ?></b>
							</p>
						<?php endif; ?>
						<p class="">Tanggal Order
							<b class="d-block"><?php echo $onMy->convertDate('d F Y',$data['created_at']) ?></b>
						</p>
						<?php if($data['status'] == 3): ?>
					

						<?php if($data['nowa']): ?>
							<p class="">No WA/Kontak
								<b class="d-block"><?php echo $data['nowa'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['email']): ?>
							<p class="">E-Mail
								<b class="d-block"><?php echo $data['email'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['domisili']): ?>
							<p class="">Domisili
								<b class="d-block"><?php echo $data['domisili'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['alamat']): ?>
							<p class="">Alamat
								<b class="d-block"><?php echo $data['alamat'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['kode_pos']): ?>
							<p class="">Kode Pos
								<b class="d-block"><?php echo $data['kode_pos'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['jk']): ?>
							<p class="">Jenis Kelamin
								<b class="d-block"><?php echo $data['jk'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['email']): ?>
							<p class="">Rentang usia
								<b class="d-block"><?php echo $data['email'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['harga']): ?>
							<p class="">Harga
								<b class="d-block">Rp<?php echo $onMy->nf($data['harga']) ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['komisi']): ?>
							<p class="">Komisi
								<b class="d-block">Rp<?php echo $onMy->nf($data['komisi']) ?></b>
								<small>*jika ini datang dar
									<?php endif; ?>i affilaite</small>
						</p>
						<?php if($data['resi']): ?>
							<p class="">RESI
								<b class="d-block"><?php echo $data['resi'] ?></b>
							</p>
						<?php endif; ?>
						<?php if($data['catatan']): ?>
							<p class="">Catatan
								<b class="d-block"><?php echo $data['catatan'] ?></b>
							</p>
						<?php endif; ?>
					<?php else: ?>
						<div class="alert alert-info">
							<i class="fa fa-info-circle"></i> Data pesanan tidak ditampilkan hingga Anda memproses pesanan ini, Berikut hal yang harus di perhatikan :<br>
							<ul>
								<li>Proses pesanan ini jika pembeli sudah mentransfer/menghubungi Anda</li>
								<li>Memproses pesanan ini berarti Anda setuju akan memberikan komisi pada Affiliate dimana pesanan ini datang (jika pesanan ini datang dari affiliate member komunitas Anda)</li>
							</ul>
						</div>
					<?php endif; ?>

					
    		</div>
    	</div>
			
		</div>
	</section>
</div>
<script type="text/javascript">
	    document.title = 'KOMBI | Detail Pesanan Affiliate <?php echo $namaKomunitas ?>';

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