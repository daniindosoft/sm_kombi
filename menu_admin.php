<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
    <?php if ($hari >= -5): ?>
      <li class="nav-item bg-danger">
        <a href="<?php echo $onMy->primaryLocal ?>admin/status" class="nav-link">
          <p>
            Expire <?php $onMy->ago = true; echo $onMy->time_elapsed_string($profile['expire']); $onMy->ago = false; ?> 
          </p>
        </a>
      </li>
    <?php endif ?>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>admin/home" class="nav-link" id="home">
        <i class="nav-icon fa fa-home"></i>
        <p>
          Beranda
        </p>
      </a>
    </li>

    <li class="nav-item" id="bisnis-open">
      <a href="#" class="nav-link" id="bisnis">
        <i class="nav-icon fa fa-money-bill"></i>
        <p>
          Bisnis
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/affiliate" class="nav-link" id="affiliate">
            <p>Affiliate</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/dropship" class="nav-link" id="dropres">
            <p>Dropship/Reseller</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/customer_list" class="nav-link" id="customer_list">
            <p>Customer List</p><?php echo $onMy->mark ?>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/pengajuan_komisi" class="nav-link" id="komisi">
            <p>Pencairan Komisi Affiliate</p>
          </a>
        </li>               
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/bisnis/addmin" class="nav-link" id="penambahan_pengurangan_komisi">
            <p>± Komisi Affiliate</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>admin/membership" class="nav-link" id="membership">
        <i class="nav-icon fa fa-users"></i>
        <p>
          Membership
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>admin/ecourse" class="nav-link" id="ecourse">
        <i class="nav-icon fa fa-desktop"></i>
        <p>
          E-Course/Video
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>admin/produk" class="nav-link" id="produk">
        <i class="nav-icon fa fa-cube"></i>
        <p>
          Produk
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>admin/asset" class="nav-link" id="asset">
        <i class="nav-icon fa fa-file-image"></i>
        <p>
          Asset
        </p>
      </a>
    </li>
    <li class="nav-item" id="post-open">
      <a href="#" class="nav-link" id="post">
        <i class="nav-icon far fa-plus-square"></i>
        <p>
          Post
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/post/publish?status=publish" class="nav-link" id="posting">
            <p>Posting</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/materi_tulisan" class="nav-link" id="materi_tulisan">
            <p>Materi Tulisan</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item" id="report-open">
      <a href="#" class="nav-link" id="report">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
          Laporan & Grafik
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/report/members" class="nav-link" id="demografi">
            <p>Demografi</p>
          </a>
        </li>
        <li class="nav-item">
          <a title="report bentuk grafic filter dan bisa export csv, isinya pesanan, aff, produk aff" href="<?php echo $onMy->primaryLocal ?>admin/report/orders" class="nav-link" id="orders">
            <p>Pesanan <?php echo $onMy->mark ?></p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>admin/pengaturan" class="nav-link" id="pengaturan">
        <i class="nav-icon fa fa-user-cog"></i>
        <p>
          Setting & Komunitas
        </p>
      </a>
    </li>
    <li class="nav-item" id="combi-open">
      <a href="#" class="nav-link" id="combi">
        <i class="nav-icon fas fa-search"></i>
        <p>
          KOMBI
          <?php echo $onMy->mark ?> <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/combi/info" class="nav-link" id="info_combi">
            <p>Info Update </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/report/income" class="nav-link" id="panduan_combi">
            <p>Panduan KOMBI</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/status" class="nav-link" id="status">
            <p>Status Akun</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>admin/combi" class="nav-link" id="faq">
            
            <p>
              Term & FAQ KOMBI
            </p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>keluar" class="nav-link">
        <i class="nav-icon fa fa-door-open"></i>
        <p>
          Keluar
        </p>
      </a>
    </li>
  </ul>
</nav>