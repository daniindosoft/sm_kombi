<?php
  include_once('dist/core/koneksi.php');
  include_once('dist/core/system.php');

  $a = new koneksi();
  $db = $a->hubungkan();
  $onMy = new kontrols($db);

  if ( $onMy->selectSingleOne('users', 'id', $_COOKIE['id_akun_combi'])['type_user'] == 'admin' ) {
    require('header.php');
  }else{
    require('header_user.php');
  }
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"></h1>
        </div><!-- /.col -->
        
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <?php
    $type = array('file','vid')
  ?>
    
  <section class="content">
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops !</h3>

          <p>
            Halaman yang Anda cari tidak ditemukan, silahkan kembali ke <a href="<?php echo $onMy->primaryLocal ?>user/home">Beranda saja</a>.
          </p>

          
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
  </section>
  <!-- /.content -->
</div> 
  <script>
    document.title = "KOMBI | Opps, Halaman tidak ditemukan !";
  </script>
<?php
  require('footer.php');
?>