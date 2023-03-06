<?php 
  require('header_user.php'); 
  $jmlAtc = $onMy->countAtc($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'])['total'];

?>
<div class="content-wrapper" style="min-height: 1172.56px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dropship/reseller</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>user/produk/cart"><i class="ion-ios-cart"></i> Keranjang Anda <?php echo $jmlAtc ?></a></li>

          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- /.row -->
 
      <h4 class="mt-4 mb-4">Produk & Pesanan</h4>
 
      <div class="row">
 
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="card card-widget collapsed-card">
            <div class="card-header">
              <div class="user-block">
                <b><a href="#">Produk Merchandise</a></b>
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
            <div class="card-body">
              <div class="text-center">
                <p>Produk dikomunitas ini yang bisa anda jual kembali baik itu dropship atau reseller</p>
              </div>
              <div class="row justify-content-md-center">
                <?php 
                  foreach ($onMy->selectWhere('produk', $_SESSION['bisnis_kategori_combi'], ' and type="merch"') as $produk): 
                    $img = preg_split('#\r?\n#', $produk['dp'], 2)[0];

                ?>
                  <div class="col-md-3 border m-1">
                    <img src="<?php echo $img ?>" class="w-100" height="230px" style="object-fit: cover;">
                    <?php 
                      if ($produk['harga'] <= 0){
                        $varian = $onMy->eksekusiShow('select max(harga) as tertinggi, min(harga) as terendah from produk_variasi where id_produk ='.$produk['id']);
                        $price = 'Rp'.$onMy->nf($varian['terendah']).' - Rp'.$onMy->nf($varian['tertinggi']);
                      }else{
                        $price = 'Rp'.$onMy->nf($produk['harga']);
                      }
                    ?>
                    <label><?php echo $produk['nama_produk'] ?></label>
                    <h5><?php echo $price; ?></h5>
                    <a href="<?php echo $onMy->primaryLocal ?>user/produk/view?id=<?php echo $produk['id'] ?>" class="btn-sm btn btn-block btn-warning">Lihat..</a>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
       
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
  </a>
</div>
<script>
  $(function () {
    $('#reservation').daterangepicker()
  });
</script>
<?php 
require('footer.php'); ?>