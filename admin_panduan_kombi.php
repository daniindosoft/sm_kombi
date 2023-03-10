<?php
	include_once('header.php');
?>
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Panduan Kombi</h1>
        </div><!-- /.col -->
        
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
 
  <section class="content"> 
      <div class="card card-outline card-warning collapsed-card">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-file"></i> 
            Panduan Berupa Video </h3>
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
            <?php $nom=0; foreach ($onMy->selectNormal('panduan') as $asset): $nom++; $no++; ?>
              <div class="col-md-6">
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
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
  document.title = "KOMBI | Panduan KOMBI";
            var menuaddclass = document.getElementById("combi");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("panduan_combi");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("combi-open");
    menuaddclass3.classList.add("menu-open");


</script>
<?php
	include_once('footer.php');
?>