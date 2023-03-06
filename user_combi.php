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
            <h1 class="m-0">KOMBI TERM & FAQ </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $onMy->primaryLocal ?>">Home</a></li>
              <li class="breadcrumb-item">KOMBI</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
				<div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">KETENTUAN & RULE</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <?php echo $onMy->eksekusiShow('select * from combi')['faq_term_user'] ?>
          </div>
          <!-- /.card-body -->
        </div>
	    </div>
	  </section>
	</div>
<script type="text/javascript">
  document.title = "KOMBI | FAQ <?php echo $komunitas['nama_komunitas'] ?>";
        var menuaddclass = document.getElementById("infos");
    menuaddclass.classList.add("active");

        var menuaddclassx = document.getElementById("faq_kombi");
    menuaddclassx.classList.add("active");

        var menuaddclass3 = document.getElementById("info");
    menuaddclass3.classList.add("menu-open");

</script>
<?php
	include_once('footer.php');
?>