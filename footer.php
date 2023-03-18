<?php
  $bisnisInfo = $onMy->selectSingleOne('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);
  $adminRebi = $onMy->option();
  $norek = $onMy->selectSingleOne('norek', 'id_user', $_COOKIE['id_akun_combi']);

?>
  <div class="btn-group dropup open" style="position: fixed;bottom: 19px;right: 15px; z-index: 9999;">
    <div class="btn-group">
      <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only"></span>
      </button>
      <div class="dropdown-menu" role="menu">
        <?php if ($profile['type_user'] == 'user'): ?>
          <a class="dropdown-item" href="<?php echo $onMy->noWa($bisnisInfo['nowa']) ?>" target="_blank"><i class="fab fa-whatsapp"></i> Hubungi Admin</a>
        <?php else: ?>
          <a class="dropdown-item" href="<?php echo $onMy->noWa($adminRebi['nowa']) ?>" target="_blank"><i class="fab fa-whatsapp"></i> Hubungi Admin</a>
        <?php endif ?>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalInfoBisnis"><i class="fa fa-info-circle"></i> Info Bisnis</a>
      </div>
    </div>
</div>
<footer class="main-footer text-sm">
  <strong>&copy; <?php echo date('Y') ?> KOMBI | <b>Version</b> 1.7</strong>
</footer>

<div class="modal fade" id="modal-add-komunitas">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form action="" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Gabung Komunitas Baru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" name="url" placeholder="Masukan URL/Link Komunitas" id="urlmodal" value="">
          <div  id="resultGabungKomunitas" class="text-center"></div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-warning btn-sm" id="gabungKomunitas">Gabung</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="mdlPixel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Contoh Code</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="https://duniaundercover.files.wordpress.com/2023/03/ss.png" alt="" class="w-100">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalResi">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form action="" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Input RESI/Tracking code</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="haff"><b>RESI </b> Untuk Pesanan No Invoice #<b id="resiinv"></b></p>
          <input type="hidden" name="id_pesanan" id="hidid">
          <input type="hidden" name="is_aff" id="param">
          <input type="text" class="form-control" name="resi" placeholder="Masukan Nama Ekspedisi lalu Kode RESI" id="resi" value="">
          <small><code>*</code> RESI yang di masukan tidak bisa di edit, pastikan Anda memasukan RESI yang benar</small>
          <div  id="resultResi" class="text-center"></div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-warning btn-sm btn-block" name="submitResi">Input</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalInfoBisnis">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form action="" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Informasi Komuntias ini</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <dt>Nama Bisnis</dt>
          <dd><?php echo $bisnisInfo['nama_komunitas'] ?></dd>
          <dt>Nomor WhatsApp Admin</dt>
          <dd><?php echo $bisnisInfo['nowa'] ?></dd>
          <dt>Website</dt>
          <dd><?php echo $bisnisInfo['website'] ?></dd>
          <dt>Kategori</dt>
          <dd><?php echo $onMy->selectSingleOne('kategori_bisnis', 'id', $bisnisInfo['id_kategori_bisnis'])['nama'] ?></dd>
          <dt>Instagram</dt>
          <dd><?php echo $bisnisInfo['ig'] ?></dd>
          <dt>Tiktok</dt>
          <dd><?php echo $bisnisInfo['tiktok'] ?></dd>
          
          <dt>Komisi Affiliate</dt>
          <dd>Rp<?php echo $onMy->nf($bisnisInfo['komisi_affiliate_join']) ?></dd>
          <dt>Note</dt>
          <dd><?php echo $bisnisInfo['note'] ?></dd>
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/jquery/jquery.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/chart.js/Chart.min.js"></script>
<!-- select2 -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/select2/js/select2.full.min.js"></script>
    
<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>


<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo $onMy->primaryLocal ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- daterangepicker -->

<script src="<?php echo $onMy->primaryLocal ?>plugins/moment/moment.min.js"></script>  
<script src="<?php echo $onMy->primaryLocal ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/summernote/summernote-bs4.min.js"></script>


<!-- overlayScrollbars -->
<script src="<?php echo $onMy->primaryLocal ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $onMy->primaryLocal ?>/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $onMy->primaryLocal ?>/dist/js/pages/dashboard.js"></script>


<script type="text/javascript">
  var hostServer = '<?php echo $onMy->primaryLocal ?>';
  $(function () { 
    <?php if (!$norek): ?>
      $(document).Toasts('create', {
          class: 'bg-warning',
          title: 'PENTING',
          subtitle: 'Profile',
          body: 'Silahkan lengkapi <a href="<?php echo $sistem->primaryLocal.$profile['type_user'] ?>/pengaturan#custom-tabs-four-profile">No Rekening & Profile</a> Anda di menu Pengaturan/Setting & Bisnis'
        });
    <?php endif; ?>
    $('#reservation').daterangepicker();
    $('.drp').daterangepicker();

    $('[data-toggle="tooltip"]').tooltip();
    $('#example2').DataTable();
    $('.dt').DataTable();

    $('.tabelserver').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax":{
                   "url": "<?php echo $onMy->primaryLocal ?>ajax/post",
                   "dataType": "json",
                   "ajaxType": "fu",
                   "type": "POST"
                 },
          "columns": [
              { "data": "no" },
              { "data": "nama_lengkap" },
          ]
      });

    $('#radioPrimary2').click(function(){
      $('#resultTextStatus').text('Data Pesanan Affiliate Produk')
    });
    $('#radioPrimary1').click(function(){
      $('#resultTextStatus').text('Data Lead Affiliate')
    });
    $('#gabungKomunitas').click(function(){
      $('#resultGabungKomunitas').html('<i class="fa fa-spin fa-spinner"></i>');
      $.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'gabungKomunitas',
          "url":$('#urlmodal').val(),
          "id_user":'<?php echo $_COOKIE['id_akun_combi'] ?>',
        },
        success: function(a) {
          $('#resultGabungKomunitas').html(a);
        }
      });
    });
  });
  function copyText(id) {

    const area = document.querySelector('#'+id);
    area.select();
    document.execCommand('copy');
  }
  function closeFlash() {
    $.ajax({
      type: 'POST',
      url: "<?php echo $onMy->primaryLocal ?>ajax/post",
      data: {
        "ajaxType":'closeFlash'
      },
      success: function(a) {
        
      }
    });
  }  
  // document.getElementsByClassName(".btnresi").addEventListener("click", function(e) {
  //   alert();
  // });
  $(function () {
    $(document).ready(function() {
      $('#reservation').daterangepicker();


       $('#formid').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
      });
      $('#select-varian').on('change',function() {
        $('#result-price').text($('#select-varian :selected').attr('data-price'));
        $('#stoktext').text($('#select-varian :selected').attr('stok'));
        $('#qty').val('0');
      });

      $('.product-image-thumb').on('click', function () {
        var $image_element = $(this).find('img')
        $('.product-image').prop('src', $image_element.attr('src'))
        $('#resultOfSource').text('source : '+$image_element.attr('data-source'))
        $('.product-image-thumb.active').removeClass('active')
        $(this).addClass('active')
      })
    })
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4',
      templateResult: formatState,
      templateSelection: formatState
    })
    $(".s2").select2({
        templateResult: formatState,
        templateSelection: formatState
    });

    function formatState (opt) {
        if (!opt.id) {
            return opt.text.toUpperCase();
        } 

        var optimage = $(opt.element).attr('data-image'); 
        console.log(optimage)
        if(!optimage){
           return opt.text.toUpperCase();
        } else {                    
            var $opt = $(
               '<span><img src="' + optimage + '" width="60px" class="selimgsel" /> ' + opt.text.toUpperCase() + '</span>'
            );
            return $opt;
        }
    };
  });
  function markComment(id, no, nama, id_user){
    // console.log(no);
    $('.b'+no).html("<a href='#sd' onclick='return removeMarkComment(`.b"+no+"`)'><i class='fa fa-times'></i></a> Membalas : "+nama);
    $('.id_balas'+no).val(id_user);
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".b"+no).offset().top - 200
    }, 999);
  }
  function removeMarkComment(x){
    $(x).html(" ");
  }
  function redirect(url, q = null){
    if (q == 'q') {
      var x = confirm('Yakin untuk publish post ini ?');
      if (x == true) {
        window.location.href = url;
      }
      return false;
    }else{
      window.location.href = url;
    }
  }
  function loadVideo(id, url){
    $('.frame'+id).html('<iframe width="100%" height="315" src="'+url+'" frameborder="0" allowfullscreen></iframe>');
  }
  function handleSelect(elm){
     window.location = elm.value;
  }

  $(function () {
    //Add text editor
    $('#compose-textarea').summernote({
        maximumImageFileSize: 524288
    });

    $('.editor-input').summernote({
        maximumImageFileSize: 524288
    });

  });
  function msg(x){
    var msg= confirm(x);
    if (msg == true) {
      return true;
    }
    return false;
  }
     

    function share(area){
  //       const navUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + 'https://github.com/knoldus/angular-facebook-twitter.git';
  // window.open(navUrl , '_blank');
      navigator.clipboard.writeText(area).then(() => {
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'Berhasil',
          subtitle: 'Copy Link To Share',
          body: 'Berhasil copy link, bagikan sekarang !'
        });
        setInterval(function() {
          $('#toastsContainerTopRight').remove();
        },3000);
      },() => {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Opps',
          subtitle: 'Kesalahan',
          body: 'Maaf, gagal menyalin link, coba lagi nanti !'
        });
        setInterval(function() {
          $('#toastsContainerTopRight').remove();
        },3000);
      });
    }
    function btnLike(btn, id_user, id_post){
      $('.like'+btn).css('color','rgb(217 164 4)');
      $('.like'+btn).attr('disabled', true);
      $.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'ajaxLikePost',
          "id_user":id_user,
          "id_post":id_post,
        },
        success: function(a) {
          console.log(a);
        }
      });
    }

  
    var timer;
    function ssUserPesanan(d = 0){
      if(d == 0){
        $('#page').val('1');
      }
      $('#resultBodyOrder').html(`<tr class='text-center'>
          <td colspan='4'>
            <div class="overlay">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
          </td>
        </tr>`);
      clearTimeout(timer);       // clear timer
      timer = setTimeout(ssUserPesananf, 1000);
    }
    function resetAjaxTimer(){
      clearTimeout(timer);
    }
    function paginatePage(x){
      alert(x)
    }
    function ssUserPesananf(){
      var dateRange = $('#reservation').val();
      var cari = $('#cari').val();
      var status = $('#status').val();
      var page = $('#page').val();

      var u = '<?php echo $profile['type_user'] ?>';
      // var page = $('#status');
      // console.log(dateRange+' '+cari+' '+status+' '+page);
      $.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'ssUserPesanan',
          "dateRange":dateRange,
          "cari":cari,
          "status":status,
          "page":page,
          "type":u,
        },
        success: function(a) {
          $('#resultBodyOrder').html(JSON.parse(a).data);
          $('#resultBodyOrderPage').html(JSON.parse(a).page);
        }
      });
    }
    function paginateA(x, page = 0){
      $('#pageUser').val(x);
      findUser(page);
    }
    function paginateP(x, page = 0){
      $('#pageProduk').val(x);
      findProduk(page);
    }
    function paginate(x){
      $('#page').val(x);
      ssUserPesanan(1);
    }    
    function findProduk(page = 0){
      // if (page != 0) {
      //   $('#pageProduk').val('');
      // }
      $('#resultBodyProduk').html(`<tr class='text-center'>
          <td colspan='4'>
            <div class="overlay">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
          </td>
        </tr>`);
      $.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'ssProduk',
          "cari":$('#cariProduk').val(),
          "page":$('#pageProduk').val(),
          "type":'aff',
          "type_user":'user',
        },
        success: function(a) {
          $('#resultBodyProduk').html(JSON.parse(a).data);
          $('#resultBodyProdukPage').html(JSON.parse(a).page);
          location.href = "#cariProduk";
        }
      });
    }
    function nilaiType(){
      if($('#nilai').find(":selected").val() == 'berbayar'){
        $('.harga').show();
        $('.komisi').show();
      }else{
        $('.harga').hide();
        $('.komisi').hide();
      }
    }
    function produkType(){
      if($('#typeProduk').find(":selected").val() == 'non'){
        $('.hidlink').show();
      }else{
        $('.hidlink').hide();
      }
    }
    function resi(id, inv){
      $('#resiinv').text(inv);
      $('#hidid').val(id);
    }
    function findUser(page = 0){
      if (page != 0) {
        $('#pageUser').val('');
      }
      $('#resultBodyUser').html(`<tr class='text-center'>
          <td colspan='4'>
            <div class="overlay">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
          </td>
        </tr>`);
      $.ajax({
        type: 'POST',
        url: "<?php echo $onMy->primaryLocal ?>ajax/post",
        data: {
          "ajaxType":'ssUser',
          "cari":$('#cariUser').val(),
          "type":'aff',
          "type_user":'user',
          "page":$('#pageUser').val(),
        },
        success: function(a) {
          $('#resultBodyUser').html(JSON.parse(a).data);
          $('#resultBodyUserPage').html(JSON.parse(a).page);
          location.href = "#cariUser";
        }
      });
    }
  $(function () {
    <?php if($_GET['selection']): ?>
      $('#<?php echo $_GET['selection'] ?>').addClass('bg-info');
    <?php endif; ?>
    <?php if ($thisjk == true): ?>
      var jk = {
        labels: [
            '<?php echo $l ?>',
            '<?php echo $p ?>',
        ],
        datasets: [
          {
            data: [<?php echo $lv ?>,<?php echo $pv ?>],
            backgroundColor : ['#f56954', '#00a65a'],
          }
        ]
      }
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData        = jk;
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })
    <?php endif ?>
  });
</script>
<?php if ($ssReportOrdersAffiliate == true): ?> 
  <script src="<?php echo $onMy->primaryLocal ?>dist/js/chartjs-report.js"></script>
<?php endif ?>

</body>
</html>
