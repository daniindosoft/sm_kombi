<?php
  require('header_user.php');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">E-Course</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <?php $no=1; foreach ($onMy->selectWithBussiness('ecourse_kategori', $_SESSION['bisnis_kategori_combi']) as $val): ?>
      <div class="card card-outline card-warning collapsed-card">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-play"></i> <?php echo $val['nama_kategori'] ?></h3>
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
            <?php $nom=1; foreach ($onMy->tampil_data_multi_where(array('ecourse'), array('*'), array('id_kategori = '.$val['id'])) as $value): $no++; $nom++; ?>
              <div class="col-md-4">
                <div class="card">
                  <div class="frame<?php echo $no ?>"></div>

                  <div class="card-body">
                    <b class="card-title"><?php echo $nom.'. '.$value['judul'] ?></b>
                    <p class="card-text"><small><?php echo $value['deskripsi'] ?></small></p>
                    <button type="button" onclick="return loadVideo(<?php echo $no; ?>,'<?php echo preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",'https://youtube.com/embed/$1',$value['link']); ?>')" class="btn btn-warning btn-sm">Muat Video..</button>
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
        echo "<div class='alert alert-info'><i class='fa fa-check-circle'></i> <b>Opps!</b>, Belum ada E-Course atau materi di komunitas ini</div>";
      }
    ?>

  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
  document.title = "KOMBI | E-Course <?php echo $komunitas['nama_komunitas'] ?>";

  var menuaddclass = document.getElementById("ecourse");
    menuaddclass.classList.add("active");
</script>
<?php
  require('footer.php');
?>