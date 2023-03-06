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
            <h1 class="m-0">FAQ Komunitas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item">Faq</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
				<div class="container-fluid">
	        <div class="row">
	          <!-- left column -->
	          <div class="col-md-12">
              <div id="accordion">
              	<?php $no=0; foreach ($onMy->selectWithBussiness('faq', $_SESSION['bisnis_kategori_combi']) as $faq): $no++; ?>
                  <div class="card card-warning card-outline">
                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne<?php echo $no ?>" aria-expanded="false">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <?php echo $no.'. '.$faq['title'] ?>
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOne<?php echo $no ?>" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <?php echo $faq['text'] ?>
                        </div>
                    </div>
	                </div>
              	<?php endforeach ?>
              </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </section>
	</div>
<script type="text/javascript">
  document.title = "KOMBI | FAQ <?php echo $komunitas['nama_komunitas'] ?>";
        var menuaddclass = document.getElementById("infos");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("faq");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("info");
    menuaddclass3.classList.add("menu-open");

</script>
<?php
	include_once('footer.php');
?>