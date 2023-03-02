<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    error_reporting(0);
    
    session_start();

    include_once('env.php');
    $project_location = project_location;
    $me = $project_location;

    // get url now
    $request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    include_once('dist/core/koneksi.php');
    include_once('dist/core/system.php');

    $a = new koneksi();
    $db = $a->hubungkan();
    $onMy = new kontrols($db);

    switch ($request) {

        case $me.'/' :
            require "masuk.php";
            break;

        case $me.'/view/user' :
            require "view_user.php";
            break;
            
        case $me.'/admin/register' :
            require "register_admin.php";
            break;

        case $me.'/admin/join/invoice' :
            require "invoice_join.php";
            break;

        case $me.'/admin/combi' :
            require "combi.php";
            break;

        case $me.'/admin/status' :
            require "status.php";
            break;

        case $me.'/admin/home' :
            require "admin_home.php";
            break;
        
        case $me.'/admin/ecourse' :
            require "admin_ecourse.php";
            break;

        case $me.'/admin/ecourse/edit' :
            require "admin_ecourse_edit.php";
            break;
        
        case $me.'/admin/ecourse/edit/kategori' :
            require "admin_ecourse_edit_kategori.php";
            break;
        
        case $me.'/admin/bisnis/affiliate' :
            require "admin_bisnis_affiliate.php";
            break;
        
        case $me.'/admin/bisnis/addmin' :
            require "admin_bisnis_penambahan_pengurangan_komisi.php";
            break;

        case $me.'/admin/bisnis/affiliate/edit' :
            require "admin_bisnis_affiliate_edit.php";
            break;
        
        case $me.'/admin/bisnis/dropship' :
            require "admin_bisnis_dropship.php";
            break;

        case $me.'/admin/bisnis/pengajuan_komisi' :
            require "admin_bisnis_penarikan.php";
            break;

        case $me.'/admin/membership' :
            require "admin_membership.php";
            break;
        
        case $me.'/admin/produk' :
            require "admin_produk.php";
            break;
        
        case $me.'/admin/produk/edit' :
            require "admin_produk_edit.php";
            break;

        case $me.'/admin/view/produkaff' :
            require "admin_view_produkaff.php";
            break;

        case $me.'/admin/asset' :
            require "admin_asset.php";
            break;
        
        case $me.'/admin/asset/edit' :
            require "admin_asset_edit.php";
            break;

        case $me.'/admin/post' :
            require "admin_post.php";
            break;


        case $me.'/admin/materi_tulisan' :
            require "admin_materi_tulisan.php";
            break;

        case $me.'/admin/post/edit' :
            require "admin_post_edit.php";
            break;

        case $me.'/admin/post/publish' :
            require "admin_post_publish.php";
            break;

        case $me.'/user/post' :
            require "user_post.php";
            break;

        case $me.'/user/post/edit' :
            require "user_post_edit.php";
            break;
        

        case $me.'/user/post/publish' :
            require "user_post_publish.php";
            break;
        
        case $me.'/admin/post/check' :
            require "admin_post_check.php";
            break;

        case $me.'/admin/post/acc' :
            $onMy->publishPost($_GET['id'], $_GET['url']);
            break;

        case $me.'/public/post' :
            require "public_post.php";
            break;

        case $me.'/admin/report/members' :
            require "admin_report_members.php";
            break;

        case $me.'/admin/report/income' :
            require "admin_report_income.php";
            break;

        case $me.'/admin/pengaturan' :
            // 
            require "admin_pengaturan.php";
            break;

        case $me.'/admin/pengaturan/komunitas/edit' :
            require "admin_pengaturan_edit.php";
            break;

        case $me.'/admin/approve/user' :
            $onMy->updateJoinUserToCommunity($_GET['id_user'], $_GET['id_komunitas'], $_GET['price'], $_GET['komisi'], $_GET['aff'], $_GET['owner'], $_GET['url']);
            break;

        case $me.'/admin/approve/produkaff' :
            $onMy->approveProdukAff($_GET['id'], $_GET['id_komunitas'], $_GET['url'], $_GET['price'], $_GET['komisi'], $_GET['aff'], $_GET['status']);
            break;

        case $me.'/admin/hapus' :
            $onMy->redirect = $_GET['url'];
            if ($_GET['tolak'] == 'ok') {
                // tolak post
                $post = $onMy->single('post', $_GET['id']);
                $onMy->postNotifikasi( $_COOKIE['id_akun_combi'], $post['id_user'], 'unacc_post', 'Post Ditolak', 'Post <b>'.$post['judul'].'</b> Tidak disetujui oleh Admin, dan postingan telah di hapus', $_SESSION['bisnis_kategori_combi'] );
                $onMy->registerFlash('s', 'Postingan berhasil Anda tolak');
            }

            $onMy->registerFlash('s', 'Berhasil menghapus !');

            $onMy->tbl = base64_decode($_GET['table']);
            $onMy->clm = 'id';
            // echo "delete from ".base64_decode($_GET['table'])." where id = ".$_GET['id'];
            // $onMy->debug = true; die;
            $onMy->hapus_satu_data($_GET['id']);

            break;

        case $me.'/switch/bisnis' :
            $_SESSION['bisnis_kategori_combi'] = $_GET['id'];
            // echo $_GET['id'];
            header("Location: ".$onMy->https.$_GET['url']);
            break;




        case $me.'/user/home' :
            require "user_home.php";
            break;

        case $me.'/produk/acc':
            $onMy->actionProduk($_GET['id'],$_GET['status']);
            header("Location: ".$onMy->https.$_GET['url']);
            break;
        
        case $me.'/view/user/kick':
            $onMy->kickUser($_GET['id']);
            header("Location: ".$onMy->https.$_GET['url']);
            break;

        case $me.'/view/post':
            require "view_post.php";
            break;

        case $me.'/user/invoice' :
            require "user_invoice.php";
            break;

        case $me.'/users/membership' :
            require "users_membership.php";
            break;

        case $me.'/user/invoice/single' :
            require "single_invoice.php";
            break;

        case $me.'/user/bisnis/affiliate' :
            require "user_bisnis_affiliate.php";
            break;

        case $me.'/user/bisnis/drop_res' :
            require "user_bisnis_dropship_reseller.php";
            break;

        case $me.'/user/produk/view' :
            require "user_view_produk.php";
            break;

        case $me.'/user/merchandise' :
            require "user_merchandise.php";
            break;

        case $me.'/user/produk/cart' :
            require "user_view_cart.php";
            break;

        case $me.'/user/bisnis/penarikan' :
            require "user_bisnis_penarikan.php";
            break;

        case $me.'/user/ecourse' :
            require "user_ecourse.php";
            break;

        case $me.'/user/materi_tulisan' :
            require "user_materi_tulisan.php";
            break;

        case $me.'/user/asset' :
            require "user_asset.php";
            break;

        case $me.'/user/acc/komisi' :
            $onMy->accKomisi($_GET['id'], $_GET['status']);
            break;

        case $me.'/user/pengaturan' :
            require "user_pengaturan.php";
            break;

        case $me.'/user/faq' :
            require "user_faq.php";
            break;

        case $me.'/user/papan_informasi' :
            require "user_papan_informasi.php";
            break;

        case $me.'/user/rule' :
            require "user_rule.php";
            break;

        case $me.'/user/profile' :
            require "user_profile.php";
            break;


        case $me.'/daftar' :
            require "daftar.php";
            break;

        case $me.'/lupa_password' :
            require "lupa_pass.php";
            break;

        case $me.'/recovery' :
            require "recovery_pass.php";
            break;

        case $me.'/produk/buy' :
            require "buy_produk.php";
            break;

        case $me.'/daftar/admin' :
            require "daftar_admin.php";
            break;

        case $me.'/invoice' :
            require "invoice.php";
            break;

        case $me.'/join' :
            require "daftar_.php";
            break;

        case $me.'/post/read' :
            require "post_read.php";
            break;

        case $me.'/read_notifikasi' :
            $onMy->redirect = $_GET['url'];
            if (isset($_GET['r'])) {
                $onMy->allNotif = true;
            }
            $onMy->readNotifikasi($_GET['id_user'], $_GET['idkom'], $_GET['type']);
            break;

        case $me.'/csv' :
            $onMy->csv($_GET['q']);
            break;

        case $me.'/ajax/post' :
            require 'dist/core/controller.php';
            break;

        case $me.'/keluar' :
            setcookie('id_akun_combi', '', 0, '/');
            setcookie('username_akun_combi', '', 0, '/');
            session_destroy();
            header("Location: ".$onMy->primaryLocal);
            break;

        case $me.'/e404' :
            http_response_code(404);
            require "error404.php";
            break;

        default:
            http_response_code(404);
            require "error404.php";
            break;
    }
