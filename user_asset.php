<?php
  require('header_user.php');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Asset</h1>
        </div><!-- /.col -->
        
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <?php
    $type = array('file','vid')
  ?>
    
  <section class="content">
    <?php foreach ($type as $value): ?>
      <div class="card card-outline card-warning collapsed-card">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-file"></i> 
            <?php 
              if ($value == 'file'):
                echo "Asset : File";
              else:
                echo "Asset : Video"; 
              endif;
            ?></h3>
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
            <?php $nom=0; foreach ($onMy->selectWhere('asset', $_SESSION['bisnis_kategori_combi'], ' and type="'.$value.'"') as $asset): $nom++; $no++; ?>
              <div class="col-md-4">
                <div class="card">
                  <div class="frame<?php echo $no ?>"></div>
                  <div class="card-body">
                    <?php if ($value == 'file'): ?>
                      <a href="<?php echo $asset['url'] ?>" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-external-link-alt"></i> <?php echo $nom.'. '.$asset['judul'] ?></a>
                      <br>
                      <p class="card-text"><small><?php echo $asset['deskripsi'] ?></small></p>
                    <?php else: ?>
                      <b class="card-title"><?php echo $nom.'. '.$asset['judul'] ?></b>
                      <p class="card-text"><small><?php echo $asset['deskripsi'] ?></small></p>
                      <button type="button" onclick="return loadVideo(<?php echo $no; ?>,'<?php echo preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",'https://youtube.com/embed/$1',$asset['url']); ?>')" class="btn btn-warning btn-sm">Muat Video..</button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    <?php endforeach ?>
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
  document.title = "KOMBI | Asset <?php echo $komunitas['nama_komunitas'] ?>";
  var menuaddclass = document.getElementById("asset");
    menuaddclass.classList.add("active");
</script>
<?php
  require('footer.php');
?>