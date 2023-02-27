<?php
	include_once('header_user.php');
?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Papan Informasi Komunitas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item">Papan Informasi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
				<div class="container-fluid">
	        <div class="timeline timeline-inverse">
            <!-- timeline time label -->
            <div class="time-label">
              <span class="bg-danger">
                Terbaru
              </span>
            </div>
            <?php $no=0; $onMy->orderBy = true; foreach ($onMy->selectWithBussiness('papan_informasi', $_SESSION['bisnis_kategori_combi']) as $faq): $no++; ?>    
              <div>
                <i class="fa fa-newspaper bg-warning"></i>

                <div class="timeline-item">
                  <span class="time"><i class="far fa-clock"></i> <?php echo $onMy->time_elapsed_string($faq['created_at']) ?></span>

                  <h3 class="timeline-header"><a href="#">Admin</a> menginfokan "<?php echo $faq['title'] ?>"</h3>

                  <div class="timeline-body">
                    <?php echo $faq['text'] ?>
                  </div>
                
                </div>
              </div>
            <?php endforeach; ?>
          </div>
	      </div>
	    </div>
	  </section>
	</div>
<script type="text/javascript">
  document.title = "KOMBI | Papan informasi <?php echo $komunitas['nama_komunitas'] ?>";
        var menuaddclass = document.getElementById("infos");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("papan");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("info");
    menuaddclass3.classList.add("menu-open");

</script>
<?php
	include_once('footer.php');
?>