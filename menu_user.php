<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>user/home" class="nav-link" id="home">
        <i class="nav-icon fa fa-home"></i>
        <p>
          Beranda
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>user/ecourse" class="nav-link" id="ecourse">
        <i class="nav-icon fa fa-desktop"></i>
        <p>
          E-Course/Video
        </p>
      </a>
    </li>
    <?php if ($komunitas['is_affiliate'] != 1 || $komunitas['is_dropship'] != 1): ?>
      <li class="nav-item" id="bisnis-open">
        <a href="#" class="nav-link" id="bisnis">
          <i class="nav-icon fa fa-money-bill"></i>
          <p>
            Bisnis
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($komunitas['is_affiliate'] != 1): ?>
            <li class="nav-item bisnis-open">
              <a href="<?php echo $onMy->primaryLocal ?>user/bisnis/affiliate" class="nav-link" id="affiliate">
                <p>Affiliate</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($komunitas['is_dropship'] != 1): ?>
            <li class="nav-item">
              <a href="<?php echo $onMy->primaryLocal ?>user/bisnis/drop_res" class="nav-link" id="dropship">
                <p>Dropship/Reseller</p>
              </a>
            </li> 
          <?php endif; ?>
          <?php if ($komunitas['is_affiliate'] != 1): ?>
            <li class="nav-item">
              <a href="<?php echo $onMy->primaryLocal ?>user/bisnis/penarikan" class="nav-link" id="komisi">
                <p>Penarikan/Komisi</p>
              </a>
            </li>               
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>
    <li class="nav-item" id="info">
      <a href="#" class="nav-link" id="infos">
        <i class="nav-icon fa fa-info"></i>
        <p>
          Informasi
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item bisnis-open">
          <a href="<?php echo $onMy->primaryLocal ?>user/papan_informasi" class="nav-link" id="papan">
            <p>Papan Informasi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>user/rule" class="nav-link" id="rule">
            <p>Ketentuan & Rule</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>user/rule" class="nav-link" id="rule" data-toggle="modal" data-target="#modalInfoBisnis">
            <p>Info/Profile Komunitas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>user/faq" class="nav-link" id="faq">
            <p>FAQ Komunitas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>user/faq/kombi" class="nav-link" id="faq_kombi">
            <p>FAQ KOMBI</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $onMy->primaryLocal ?>user/faq/kombi" class="nav-link" id="faq_kombi">
            <p>Panduan KOMBI</p>
          </a>
        </li>
      </ul>
    </li>
    <?php if ($onMy->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi'])['member_show'] == '1'): ?>
      <li class="nav-item">
        <a href="<?php echo $onMy->primaryLocal ?>users/membership" class="nav-link" id="membership">
          <i class="nav-icon fa fa-users"></i>
          <p>
            Members
          </p>
        </a>
      </li>
    <?php endif ?>
    
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>user/materi_tulisan" class="nav-link" id="materi_tulisan">
        <i class="nav-icon fa fa-newspaper"></i>
        <p>
          Materi Tulisan
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>user/asset" class="nav-link" id="asset">
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
          <a href="<?php echo $onMy->primaryLocal ?>user/post" class="nav-link" id="posting">
            <p>Posting</p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="pages/examples/legacy-user-menu.html" class="nav-link">
            <p>Promosi</p>
          </a>
        </li> -->
      </ul>
    </li>
    
    <li class="nav-item">
      <a href="<?php echo $onMy->primaryLocal ?>user/pengaturan" class="nav-link" id="pengaturan">
        <i class="nav-icon fa fa-user-cog"></i>
        <p>
          Pengaturan
        </p>
      </a>
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