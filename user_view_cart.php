<?php
  require('header_user.php');
  $carts = $onMy->cart();
  	// echo 'select * from cart as c join produk as p on p.id = c.id_produk where c.id_user='.$_COOKIE['id_akun_combi'].' and c.id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by c.id desc';
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Keranjang</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <form action="" method="post">
    <!-- Main content -->
	    <?php echo $onMy->inputRedirectFull() ?>
	    <section class="content">
				<section class="h-100" style="background-color: #eee;">
				  <div class="container h-100 py-5">
				    <div class="row d-flex justify-content-center align-items-center h-100">
				      <div class="col-10">
				        <?php
					        $n = 1;
									foreach ($carts as $cart): $n++;
										$gambar = explode("\n", $cart['dp']);
										if($cart['harga'] <= 0){
									    $variasi = $onMy->selectSingleOne('produk_variasi', 'id',$cart['id_produk_variasi']);
									    $harga = $variasi['harga'];
									    $total = $harga*$cart['qty'];
										}else{
									    $harga = $cart['harga'];
									    $total = $harga*$cart['qty'];
									    $variasi = '';
										}
				        ?>
					        <div class="card rounded-3 mb-4" id="rmcart<?php echo $n ?>">
					          <div class="card-body p-4">
					            <div class="row d-flex justify-content-between align-items-center">
					              <div class="col-md-2 col-lg-2 col-xl-2">
					                <img
					                  src="<?php echo $gambar[0] ?>"
					                  class="img-fluid rounded" alt="Cotton T-shirt">
					              </div>
					              <div class="col-md-3 col-lg-3 col-xl-3">
					                <p class="lead font-weight-bold mb-2"><?php echo $cart['nama_produk'] ?></p>
					                <p><span class="text-muted"></span><?php echo ($variasi['nama']) ? 'Variasi: '.$variasi['nama'] : ''; ?></p>
					              </div>
					              <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
					                <input required id="form1" min="0" name="quantity" disabled type="text"
					                  class="form-control form-control-sm" value="<?php echo $cart['qty'].' x Rp'.$onMy->nf($harga) ?>" />
					              </div>
					              <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
					              	<small>Total</small>
					                <h5 class="mb-0">Rp<?php echo $onMy->nf($total) ?></h5>
					              </div>
					              <div class="col-md-1 col-lg-1 col-xl-1 text-end">
					                <a href="#!" onclick="hapusAtc('<?php echo $cart['idc'] ?>', '<?php echo $n ?>')" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
					              </div>
					            </div>
					          </div>
					        </div>
					      <?php endforeach; ?>
					      <?php if ($n == 1): ?>
					      	<div class="alert alert-info"><i class="fa fa-info-circle"></i> keranjang kosong !, yuk pilih produk dan order sekarang, <a href="<?php echo $onMy->primaryLocal ?>user/bisnis/drop_res">Klik disini untuk memilih produk</a> </div>
					      <?php endif ?>
					      <?php if ($n != 1): ?>
					        <div class="card">
					          <div class="card-body">
					          	<p class="text-center">
					          		<code>*</code><small>Semua produk yang ada di keranjang akan di pesan, hapus/buang produk yang tidak ingin di pesan di keranjang</small>
					          	</p>
					          	<div class="row">
					          		<div class="col-md-6">
							          	<div class="form-group">
							          		<label>Nama lengkap</label>
							          		<input required type="text" name="nama_lengkap" class="form-control" placeholder="nama lengkap">
							          	</div>
					          		</div>
					          		<div class="col-md-6">
							          	<div class="form-group">
							          		<label>Email</label>
							          		<input required type="text" name="email" class="form-control" placeholder="email aktif anda">
							          	</div>
					          		</div>
					          		<div class="col-md-6">
							          	<div class="form-group">
							          		<label>No Hp/Whatsapp</label>
							          		<input required type="text" name="nohp" class="form-control" placeholder="no hp aktif">
							          	</div>
					          		</div>
					          		<div class="col-md-6">
							          	<div class="form-group">
							          		<label>Provinsi & Kota/kabupaten</label>
							          		<select class="s2 form-control" name="provinsi">
							          			<option>pilih proviinsi & kota/kabupaten</option>
							          			<?php foreach ($onMy->selectNormal('domisili') as $domisili): ?>
							          				<option value="<?php echo $domisili['nama'] ?>"><?php echo $domisili['nama'] ?></option>
							          			<?php endforeach ?>
							          		</select>
							          	</div>
					          		</div>
					          		<div class="col-md-6">
							          	<div class="form-group">
							          		<label>Kecamatan</label>
							          		<input required type="text" name="kecamatan" class="form-control" placeholder="masukan Kecamatan">
							          	</div>
					          		</div>
					          		<div class="col-md-6">
							          	<div class="form-group">
							          		<label>Alamat lengkap</label>
							          		<textarea class="form-control" name="alamat_lengkap" placeholder="alamat lengkap, no rumah, kode pos, patokan atau penanda lainnya"></textarea>
							          	</div>
					          		</div>
					          	</div>
					          </div>
					        </div>

					        <div class="card mb-4">
					          <div class="card-body p-4 d-flex flex-row">
					            <div class="form-outline flex-fill">
					              <label class="form-label" for="form1">Note</label>
					              <textarea placeholder="masukan note jika dibutuhkan" name="note" class="form-control"></textarea>
					            </div>
					          </div>
				            <button type="submit" name="submitOrderDropRes" class="btn btn-warning btn-block btn-lg">Pesan sekarang</button>

					        </div>
					      <?php endif; ?>
				      </div>	
				    </div>
				  </div>
				</section>
	    </section>
    <!-- /.content -->
    </form>
  </div>
  <script type="text/javascript">
  	document.title = "KOMBI | Keranjangmu di <?php echo $komunitas['nama_komunitas'] ?>";
  	        var menuaddclass = document.getElementById("bisnis");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("dropship");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("bisnis-open");
    menuaddclass3.classList.add("menu-open");
  	function hapusAtc(id, n){
  		var x = confirm('Yakin menghapus ini dari keranjangmu ?');
  		if (x == true) {
	  		$.ajax({
	        type: 'POST',
	        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
	        data: {
	          "ajaxType":'removeAtc',
	          "id":id,
	        },
	        success: function(a) {
	        	$('#rmcart'+n).remove();
	    			$(document).Toasts('create', {
			        class: 'bg-success',
			        title: 'Berhasil',
			        subtitle: '',
			        body: 'Dihapus dari keranjang'
			      });
			      setInterval(function() {
							$('#toastsContainerTopRight').remove();
			      },3000);
	        }
	      });
  		}
  		return false;
  	}
  </script>
<?php
require('footer.php');
?>