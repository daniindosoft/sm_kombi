<?php

  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  $profile = $onMy->thisProfile($_COOKIE['id_akun_combi']);

	if ($profile['type_user'] == 'user') {
	  require('header_user.php');
	}else{
	  require('header.php');
	}
  $produk = $onMy->single('produk', $onMy->toInt($_GET['id']));

  $onMy->verifDataOwnedByComunity('produk', 'id',  $onMy->toInt($_GET['id']));

  if ($produk['harga'] <= 0){

    $variasi = $onMy->selectPleksible('produk_variasi', 'id_produk',$produk['id']);
    $varian = $onMy->eksekusiShow('select max(harga) as tertinggi, min(harga) as terendah from produk_variasi where id_produk ='.$produk['id']);
    $price = 'Rp'.$onMy->nf($varian['terendah']).' - Rp'.$onMy->nf($varian['tertinggi']);
  }else{
    $price = 'Rp'.$onMy->nf($produk['harga']);
  }

  $gambar = explode("\n", $produk['dp']);

  $jmlAtc = $onMy->countAtc($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'])['total'];

	$checkCart = $sistem->eksekusiShow('select * from cart where id_user='.$_COOKIE['id_akun_combi'].' and id_komnitas_bisnis='.$_SESSION['bisnis_kategori_combi']);

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Produk</h1>
          </div>
          <div class="col-sm-6">
            <?php 
              if ($profile['type_user'] == 'user') {
            ?>
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>user/produk/cart"><i class="ion-ios-cart"></i> Keranjang Anda <?php echo $jmlAtc ?></a></li>
              </ol>
            <?php } ?>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none"><?php echo $produk['nama_produk'] ?></h3>
              <div class="col-12">
                <img src="<?php echo $gambar[0] ?>" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
              	<?php $n=0; foreach ($gambar as $value): $n++;  ?>
	                <div class="product-image-thumb <?php echo ($n == 1) ? 'active':'' ?>"><img src="<?php echo $value ?>" alt="Product Image"></div>
              	<?php endforeach ?>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?php echo $produk['nama_produk'] ?></h3>
              <p><?php echo $produk['nama_produk'] ?></p>

              <hr>
             	<?php if ($produk['harga'] <= 0): ?>
	              <h4 class="mt-3">Variasi</h4>
	              <div class="btn-group btn-group-toggle" data-toggle="buttons">
	                <select class="form-control text-lg" id="select-varian">
	                	<option value="0">Pilih variasi</option>
	                	<?php foreach ($variasi as $var): ?>
		                	<option stok="<?php echo $var['stok'] ?>" data-price="Rp<?php echo $onMy->nf($var['harga']) ?>" value="<?php echo $var['id'] ?>"><?php echo $var['nama'] ?></option>
	                	<?php endforeach ?>
	                </select>
	              </div>
	              <h5>Stok <span id="stoktext"></span></h5>
             	<?php else: ?>
             		<h5>Stok <span id="stok"><?php echo $produk['stok'] ?></span></h5>
             	<?php endif; ?>

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0" id="result-price">
                  <?php echo $price ?>
                </h2>
               
              </div>

              <div class="mt-4">
              	<div class="input-group mb-3">
                  <?php if ($profile['type_user'] != 'admin'): ?>
	                  <input type="number" class="form-control rounded-0" placeholder="masukan jumlah pembelian (QTY)" id="qty" onkeyup="cekStok()" onchange="cekStok()">
	                  <span class="input-group-append">
	                    <button onclick="atc()" type="button" class="btn btn-warning btn-flat"><i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart</button>
	                  </span>
                  <?php endif ?>
                </div>
 
              </div>

            </div>
          </div>
         
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
<script type="text/javascript">
  document.title = 'KOMBI | Detail Produk <?php echo $produk['nama_produk'] ?> di <?php echo $profileKomunitas['nama_komunitas'] ?>';
	function cekStok(){
		$('#toastsContainerTopRight').remove();
		var n2 = $('#qty');
		<?php if($produk['harga'] <= 0): ?>
			var realStok = $('#select-varian :selected').attr('stok');
		<?php else: ?>
			var realStok = <?php echo $produk['stok'] ?>;
		<?php endif; ?>
		// alert(realStok)
		if (parseInt(n2.val()) > parseInt(realStok)) {
			$('#qty').val( realStok );
			$(document).Toasts('create', {
        class: 'bg-info',
        title: 'Stok',
        subtitle: 'Stok terbatas',
        body: 'Stok yang di masukan harus kurang dari/sama dengan '+realStok
      })
		}
	}
	function atc(){
		var n = parseInt( $('#qty').val() );
		if (!n) {
			$(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Opps',
        subtitle: 'Kesalahan',
        body: 'Mohon masukan jumlah barang yang di pesan (QTY) sebelum menambahkan ke keranjang'
      });
      setInterval(function() {
				$('#toastsContainerTopRight').remove();
      },3000);
		}else{
			$('#toastsContainerTopRight').remove();
			$.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'atc',
          "qty":$('#qty').val(),
          "id_produk":'<?php echo $_GET['id'] ?>',
          "id_produk_variasi":$('#select-varian').val(),
        },
        success: function(a) {
    			$(document).Toasts('create', {
		        class: 'bg-success',
		        title: 'Berhasil',
		        subtitle: '',
		        body: 'Produk sudah di tambahkan ke keranjang'
		      });
		      setInterval(function() {
						$('#toastsContainerTopRight').remove();
		      },3000);
        }
      });
		}
	}

    var menuaddclass = document.getElementById("bisnis");
  menuaddclass.classList.add("active");

      var menuaddclassx = document.getElementById("dropres");
  menuaddclassx.classList.add("active");

      var menuaddclass3 = document.getElementById("bisnis-open");
  menuaddclass3.classList.add("menu-open");

</script>
<?php
require('footer.php');
?>