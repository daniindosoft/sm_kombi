<?php
  require('header_user.php');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Materi Tulisan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tulisan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <?php $no=1; foreach ($onMy->selectWithBussiness('kategori_tulisan', $_SESSION['bisnis_kategori_combi']) as $val): ?>
      <div class="card card-outline card-warning collapsed-card">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-newspaper"></i> <?php echo $val['nama'] ?></h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <?php $nom=0; foreach ($onMy->tampil_data_multi_where(array('tulisan'), array('*'), array('id_kategori_tulisan = '.$val['id'])) as $value): $no++; $nom++; ?>
              <div class="col-md-12">
                <div class="card">
                  <div class="frame<?php echo $no ?>"></div>

                  <div class="card-body">
                    <b class="card-title"><?php echo $nom.'. '.$value['judul'] ?></b>
                    <p class="card-text"><small><?php echo $value['text'] ?></small></p>
                     
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    <?php
      endforeach;
      if ($no == 1) {
        echo "<div class='alert alert-info'><i class='fa fa-check-circle'></i> <b>Opps!</b>, Belum ada materi tulisan di komunitas ini</div>";
      }
    ?>

  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
  document.title = "KOMBI | Materi tulisan <?php echo $komunitas['nama_komunitas'] ?>";
  var menuaddclass = document.getElementById("materi_tulisan");
    menuaddclass.classList.add("active");
</script>
<?php
  require('footer.php');
?>