<?php
	error_reporting(0);

	 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	include_once('koneksi.php');
	include_once('system.php');
	include_once("detect.php");

	$a=new koneksi();
	$db=$a->hubungkan();
	$sistem=new kontrols($db);
	$mdetect = new MobileDetect(); 

	if(isset($_POST['login'])) {
		$sistem->masuk($_POST['email'], $_POST['password']);
	}

	$user = $sistem->singleUser($_COOKIE['id_akun_combi']);

	if(isset($_POST['submitBisnisKomunitas'])) {
		
		$kuotaPaket = $sistem->kuotaPackage($_COOKIE['id_akun_combi']);
		$countComunity = $sistem->totalComunityOwnedByAdmin($_COOKIE['id_akun_combi']);
		if ($countComunity < $kuotaPaket) {
			$menu = '0';
			
			$verif = '0';
			$ds = '0';
			$aff = '0';
			// echo var_dump($_POST);die;
			if (isset($_POST['menu'])) {
				$menu = '1';
			}
			if (isset($_POST['verifikasi'])) {
				$verif = '1';
			}
			if (isset($_POST['is_dropship'])) {
				$ds = '1';
			}
			if (isset($_POST['is_affiliate'])) {
				$aff = '1';
			}
			$sistem->redirect = $_POST['redirect'];
			$tbl="komunitas_bisnis";

			$komunitascode = rand(1000000,9999999);

			$data=array(
				strip_tags($_POST['email']),
				strip_tags($_POST['nama_komunitas']),
				strip_tags($_POST['no_wa']),
				strip_tags($_POST['website']),
				strip_tags($_POST['instagram']),
				strip_tags($_POST['tiktok']),
				strip_tags($_POST['komisi']),
				$komunitascode,
				$_COOKIE['id_akun_combi'],
				$_POST['kategori_bisnis'],
				$menu,
				$verif,
				$_POST['harga'],
				$_POST['text'],
				$_POST['wa_template'],$ds,$aff, 
				base64_encode($_POST['header']), 
				base64_encode($_POST['header_form']), 
				base64_encode($_POST['header_invoice'])
			);
			$col=array('email', 'nama_komunitas','nowa','website','ig','tiktok','komisi_affiliate_join', 'code_komunitas', 'id_user', 'id_kategori_bisnis', 'member_show', 'verifikasi_post', 'harga', 'note', 'wa_template', 'is_dropship', 'is_affiliate', 'header', 'header_form', 'header_invoice');
			// $sistem->debug = true;
			$sistem->masukan_data_no_redirect($tbl,$col,$data);

			// get komunitas baru dibuat
			$newKomunitas = $sistem->selectSingleOne($tbl, 'code_komunitas', $komunitascode);
			$sistem->registerFlash('s', 'Komunitas '.$_POST['nama_komunitas'].' telah dibuat !');
			
			$w = array($_COOKIE['id_akun_combi'], $newKomunitas['id']);
			$c = array('id_user', 'id_komunitas_bisnis');

			$sistem->masukan_data_no_redirect('data_dropship', $c, $w);
			$sistem->masukan_data('data_affiliate', $c , $w );


		}else{
			$sistem->registerFlash('d', 'Kuota Komunitas yang bisa kamu buat telah mencapai batas, silahkan Upgrade Paket untuk mendapatkan tambahan kuota');
			header('Location:'.$this->https.$this->primaryLocal.'admin/pengaturan');

		}

	}

	if(isset($_POST['udpateBisnisKomunitas'])) {
		$menu = '0';
		$verif = '0';
		$is_dropship = 0;
		$is_affiliate = 0;
		if (isset($_POST['menu'])) {
			$menu = '1';
		}
		if (isset($_POST['verifikasi'])) {
			$verif = '1';
		}
		if (isset($_POST['is_dropship'])) {
			$is_dropship = '1';
		}
		if (isset($_POST['is_affiliate'])) {
			$is_affiliate = '1';
		}

		$sistem->postNotifikasi( $_POST['id_user'], 0, 'komunitas', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

		$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
		$tbl="komunitas_bisnis";
		$data=array("id");
		$key=array($_POST['id']);
		$ubah=array(
			"nama_komunitas ='".$_POST['nama_komunitas']."'",
			"nowa ='".$_POST['no_wa']."'",
			"website ='".$_POST['website']."'",
			"ig ='".$_POST['instagram']."'",
			"tiktok ='".$_POST['tiktok']."'",
			"komisi_affiliate_join ='".$_POST['komisi']."'",
			"id_kategori_bisnis ='".$_POST['kategori_bisnis']."'",
			"member_show ='".$menu."'",
			"verifikasi_post ='".$verif."'",
			"note ='".$_POST['text']."'",
			"wa_template ='".$_POST['wa_template']."'",
			"is_dropship ='".$is_dropship."'",
			"is_affiliate ='".$is_affiliate."'",
			"email ='".$_POST['email']."'",
			"harga ='".$_POST['harga']."'",
			"header='". base64_encode($_POST['header'])."'",
			"header_form='". base64_encode($_POST['header_form'])."'",
			"header_invoice='". base64_encode($_POST['header_invoice'])."'"
		);
		$sistem->registerFlash('s', 'Data berhasil di update');
		$sistem->rubah_data($tbl,$ubah,$data,$key);
	}

	switch (isset($_POST)) {
		case isset($_POST['submitBisnis']):
			if ( empty($sistem->eksekusiShow('select * from users where email="'.$_POST['email'].'"')['id']) ){
				if($mdetect->isMobile()){ 
			    // Detect mobile/tablet  
				    if($mdetect->isTablet()){ 
				        $perangkat = 'Tablet'; 
				    }else{ 
				        $perangkat = 'Mobile'; 
				    }
				     
				    // Detect platform 
				    if($mdetect->isiOS()){ 
				        $perangkat .= ' - IOS'; 
				    }elseif($mdetect->isAndroidOS()){ 
				        $perangkat .= ' - ANDROID'; 
				    } 
				}else{ 
				    $perangkat = 'Desktop';
				}
				$username = strtolower( str_replace(' ','',$_POST['nama_lengkap']).rand(1,9999) );
				while (!empty( $sistem->eksekusiShow('select * from users where username="'.$username.'"')['id'] )) {
					$username = str_replace(' ','',$_POST['nama_lengkap']).rand(1,999);
				}
				$randaff = rand(10000,999999).date('ymd').substr(md5(rand()),0,15);

				// get package
				$harga = $sistem->getPackagePrice($_POST['paket']);
				// echo var_dump($harga); die;
				$paket = $harga - rand(1,999);

				$col = array('perangkat', 'expire','nama_lengkap', 'password', 'email', 'last_package_picked', 'nowa', 'username', 'kode_affiliate', 'price_admin', 'type_user', 'dp', 'is_private');
				$data = array($perangkat, date('Y-m-d H:i:s', strtotime('+30 days', strtotime(date('Y-m-d H:i:s')))),$_POST['nama_lengkap'], $_POST['nowa'], $_POST['email'], $_POST['paket'], $_POST['nowa'], $username, $randaff, $paket, 'admin', 'cat.png', 1);
				$sistem->lastId = true;
				
				// set price public
				$sistem->pricePublic = $paket;
				$sistem->priceNama = $_POST['nama_lengkap'];
				$sistem->priceEmail = $_POST['email'];
				
				$id = $sistem->masukan_data_no_redirect('users',$col,$data);

				// notif ke pendaftar
			    $sistem->kirimEmail('','kombi@remotebisnis.com','Kombi RemoteBisnis',$_POST['email'],'1 Langkah lagi nih, yuk selesaikan..', $sistem->templateEmail( $sistem->templateDaftarBisnis($_POST['kaf']) ) );
			    
			    $sistem->notifAdminRebi($_POST['kaf']);

			    // redirek
			    echo "<script>window.location.href = '".$sistem->primaryLocal."admin/join/invoice?kaf=".$_POST['kaf']."&id=".$id."'; </script>";
			    echo " - ".$sistem->primaryLocal."admin/join/invoice?kaf=".$_POST['kaf']."&id=".$id."' - ";

				header('Location:'.$sistem->primaryLocal.'admin/join/invoice?kaf='.$_POST['kaf'].'&id='.$id);
			}else{
				$sistem->registerFlash('d', 'Email sudah terdaftar, silahkan gunakan email lain !');
			}
			break;

		case isset($_POST['submitEcourse']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="ecourse";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['kategori']),
				strip_tags($_POST['judul']),
				strip_tags($_POST['deskripsi']),
				strip_tags($_POST['id_komunitas_bisnis']),
				strip_tags($_POST['link'])
			);
			$col=array('id_user', 'id_kategori', 'judul', 'deskripsi', 'id_komunitas_bisnis', 'link');
			$sistem->registerFlash('s', 'E-Course/Materi "'.$_POST['judul'].'" sudah di tambahkan');

			$sistem->masukan_data_no_redirect($tbl,$col,$data);

			break;
		
		case isset($_POST['submitCustomerList']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$ubah = array(
				'id_kategori_customer_list ="'.htmlspecialchars($_POST['kategori']).'"',
				'nama ="'.htmlspecialchars($_POST['nama_lengkap']).'"',
				'jk ="'.htmlspecialchars($_POST['jk']).'"',
				'email ="'.htmlspecialchars($_POST['email']).'"',
				'phone ="'.htmlspecialchars($_POST['nowa']).'"',
				'source ="'.htmlspecialchars($_POST['sumber']).'"',
				'nilai_konversi ="'.htmlspecialchars($_POST['nilai_konversi']).'"',
				'id_komunitas_bisnis ="'.htmlspecialchars($_POST['id_komunitas_bisnis']).'"',
				'alamat ="'.htmlspecialchars($_POST['alamat']).'"',
			);
			$sistem->registerFlash('i', 'Customer list "'.$_POST['nama_lengkap'].'" berhasil di ubah');
			// $sistem->debug = true;
			$sistem->rubah_data('customer_list',$ubah,array('id'),array($_POST['id']));

			break;

		case isset($_POST['submitCustomerList']):
				$sistem->redirect = $_POST['redirect'];
				$tbl="customer_list";
				$data=array(
					htmlspecialchars($_POST['kategori']),
					htmlspecialchars($_POST['nama_lengkap']),
					htmlspecialchars($_POST['jk']),
					htmlspecialchars($_POST['email']),
					htmlspecialchars($_POST['nowa']),
					htmlspecialchars($_POST['sumber']),
					htmlspecialchars($_POST['nilai_konversi']),
					htmlspecialchars($_POST['id_komunitas_bisnis']),
					htmlspecialchars($_POST['id_user']),
					htmlspecialchars($_POST['alamat'])
				);
				$col=array('id_kategori_customer_list', 'nama', 'jk', 'email', 'phone', 'source', 'nilai_konversi', 'id_komunitas_bisnis', 'id_user', 'alamat');
				$sistem->registerFlash('s', 'customer list "'.$_POST['judul'].'" sudah di tambahkan');
				$sistem->registerFlash('s', 'customer list "'.$_POST['judul'].'" sudah di tambahkan');
				// $sistem->debug = true;
				$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updateMateriTulisan']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$tbl="tulisan";
			$data=array(
				'id_kategori_tulisan="'.htmlspecialchars($_POST['kategori']).'"',
				'judul="'.htmlspecialchars($_POST['judul']).'"',
				'text="'.htmlspecialchars($_POST['deskripsi']).'"',
				'id_komunitas_bisnis="'.htmlspecialchars($_POST['id_komunitas_bisnis']).'"',
			);
			$col=array('id_user', 'id_kategori_tulisan', 'judul', 'text', 'id_komunitas_bisnis');
			$sistem->registerFlash('i', 'Tulisan "'.$_POST['judul'].'" telah di update');
			$sistem->rubah_data('tulisan', $data, array('id'), array($_POST['id']));
			break;

		case isset($_POST['submitMateriTulisan']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="tulisan";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['kategori']),
				strip_tags($_POST['judul']),
				strip_tags($_POST['deskripsi']),
				strip_tags($_POST['id_komunitas_bisnis'])
			);
			$col=array('id_user', 'id_kategori_tulisan', 'judul', 'text', 'id_komunitas_bisnis');
			$sistem->registerFlash('s', 'Tulisan "'.$_POST['judul'].'" sudah di tambahkan');

			$sistem->masukan_data($tbl,$col,$data);

			break;

		case isset($_POST['updateProduk']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$tbl="produk";
			$data=array("id");
			$key=array($_POST['id']);
			$ubah=array(
				"type = '".$_POST['type']."'",
				"nama_produk = '".$_POST['nama_produk']."'",
				"deskripsi = '".$_POST['deskripsi']."'",
				"dp = '".$_POST['gambar']."'"
			);
			// update varian produk lama
			for ($i=0; $i <count($_POST['oldharga']) ; $i++) { 
				// $sistem->debug = true;
				if (empty($_POST['oldvarian'][$i])) {
		            $onMy->tbl = 'produk_variasi';
		            $onMy->clm = 'id';
		            $onMy->disableRedirect = true;
		            $onMy->hapus_satu_data($_POST['idvarian'][$i]);
				}else{
					$sistem->rubah_data(
						'produk_variasi', 
						array(
							'harga="'.$_POST['oldharga'][$i].'"',
							'stok="'.$_POST['oldstok'][$i] .'"',
							'nama="'.$_POST['oldvarian'][$i].'"'
						),
						array('id'),
						array($_POST['idvarian'][$i])
					);
				}
			}
			// add varian produk baru /jika ada
			for ($i=0; $i <count($_POST['harga']) ; $i++) { 
				if (!empty($_POST['varian'][$i])) {
					$sistem->masukan_data_no_redirect('produk_variasi', array('id_produk', 'harga', 'stok', 'nama'), array($_POST['id'], $_POST['harga'][$i], $_POST['stok'][$i], $_POST['varian'][$i]) );
				}
			}

			$sistem->registerFlash('s', 'Produk "'.$_POST['nama_produk'].'" berhasil di Update');
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitProduk']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="produk";
			
			if (empty($_POST['single_harga'])) {
				$harga = 0;
			}else{
				$harga = $_POST['single_harga'];
			}

			if (empty($_POST['single_stok'])) {
				$stok = 0;
			}else{
				$stok = $_POST['single_stok'];
			}

			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['type']),
				strip_tags($_POST['nama_produk']),
				strip_tags($_POST['deskripsi']),
				strip_tags($harga),
				strip_tags($stok),
				strip_tags($_POST['id_komunitas_bisnis']),
				strip_tags($_POST['gambar'])
			);
			$col=array('id_user', 'type', 'nama_produk', 'deskripsi', 'harga', 'stok', 'id_komunitas_bisnis', 'dp');
			$sistem->lastId = true;
			// $sistem->debug = true;
			$id = $sistem->masukan_data_no_redirect($tbl,$col,$data);

			if ($_POST['harga']) {
				$sistem->lastId = false;
				for ($i=0; $i <count($_POST['harga']) ; $i++) { 
					$sistem->masukan_data_no_redirect('produk_variasi', array('id_produk', 'harga', 'stok', 'nama'), array($id, $_POST['harga'][$i], $_POST['stok'][$i], $_POST['varian'][$i]) );
				}
			}
			$sistem->registerFlash('s', 'Produk "'.$_POST['nama_produk'].'" sudah di tambahkan');
			
			header('Location:'.$sistem->primaryLocal.'admin/produk?info=berhasil');

			break;	
		
		case isset($_POST['submitProdukBK']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="produk";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['type']),
				strip_tags($_POST['nama_produk']),
				strip_tags($_POST['deskripsi']),
				strip_tags($_POST['harga']),
				strip_tags($_POST['stok']),
				strip_tags($_POST['id_komunitas_bisnis']),
				strip_tags($_POST['dp'])
			);
			$col=array('id_user', 'type', 'nama_produk', 'deskripsi', 'harga', 'stok', 'id_komunitas_bisnis', 'dp');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updateEcourse']):
			
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$tbl="ecourse";
			$data=array("id");
			$key=array($_POST['id']);
			$ubah=array(
				"id_kategori='".$_POST['kategori']."'",
				"judul='".$_POST['judul']."'",
				"deskripsi='".$_POST['deskripsi']."'",
				"id_komunitas_bisnis='".$_POST['id_komunitas_bisnis']."'",
				"link='".$_POST['link']."'"
			);
			$sistem->registerFlash('s', 'E-Course "'.$_POST['judul'].'" sudah di tambahkan');

			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitAsset']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="asset";
			$data=array(
				strip_tags($_POST['judul']),
				strip_tags($_POST['id_komunitas_bisnis']),
				strip_tags($_POST['id_user']),
				strip_tags($_POST['deskripsi']),
				strip_tags($_POST['url']),
				strip_tags($_POST['dp']),
				strip_tags($_POST['type'])
			);
			$col=array('judul', 'id_komunitas_bisnis', 'id_user', 'deskripsi', 'url', 'dp', 'type');
			$sistem->registerFlash('s', 'Asset "'.$_POST['judul'].'" sudah di tambahkan');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updateAsset']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$tbl="asset";
			$data=array("id");
			$key=array($_POST['id']);
			$ubah=array(
				"judul='".$_POST['judul']."'",
				"deskripsi='".$_POST['deskripsi']."'",
				"url='".$_POST['url']."'",
				"type='".$_POST['type']."'"
			);
			$sistem->registerFlash('s', 'Asset "'.$_POST['judul'].'" berhasil di update');
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitUpdateProfile']):

			$sistem->redirect = $_POST['redirect'].'?ok=1';
			$tbl="users";
			$data=array("id");
			$key=array($_COOKIE['id_akun_combi']);

			$private = '0';

			if (isset($_POST['private'])) {
				$private = '1';
			}
			
			$dateOfBirth = $_POST['tanggal_lahir'];

			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));

			$ubah=array(
				'nowa = "'.$_POST['no_wa'].'"',
				'nama_lengkap = "'.$_POST['nama_lengkap'].'"',
				'tgl_lahir = "'.$_POST['tanggal_lahir'].'"',
				'domisili = "'.$_POST['domisili'].'"',
				'dp = "'.$_POST['avatar'].'"',
				'is_private = "'.$private.'"',
				'jk = "'.$_POST['jk'].'"',
				'usia = '.$diff->format('%y')
			);
			// $sistem->disableRedirect = true;
			$sistem->registerFlash('s', 'Profile berhasil di perbarui');
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitEcourseKategori']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="ecourse_kategori";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['nama_kategori']),
				strip_tags($_POST['id_komunitas_bisnis']),
			);
			$col=array('id_user','nama_kategori','id_komunitas_bisnis');
			$sistem->registerFlash('s', 'Kategori E-Course "'.$_POST['nama_kategori'].'" sudah di tambahkan');

			$sistem->masukan_data_no_redirect($tbl,$col,$data);
			break;
		
		case isset($_POST['submitTulisanKategori']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="kategori_tulisan";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['nama_kategori']),
				strip_tags($_POST['id_komunitas_bisnis']),
			);
			$col=array('id_user','nama','id_komunitas_bisnis');
			$sistem->registerFlash('s', 'Kategori Tulisan "'.$_POST['nama_kategori'].'" sudah di tambahkan');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['submitCustomerListKategori']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="kategori_customer_list";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['nama_kategori']),
				strip_tags($_POST['id_komunitas_bisnis']),
			);
			$col=array('id_user','nama','id_komunitas_bisnis');
			$sistem->registerFlash('s', 'Kategori Customer List "'.$_POST['nama_kategori'].'" sudah di tambahkan');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updatePostDraf']) || isset($_POST['updatePost']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$status = 'publish';
			if (isset($_POST['updatePostDraf'])) {
				$status = 'draft';
				$sistem->registerFlash('i', 'Post "'.$_POST['judul'].'" telah dijadikan draft');
			}

			// cek verifikasi post
			$cekVerifikasiPost = $sistem->single('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);
			if (isset($_POST['updatePost']) && $cekVerifikasiPost['verifikasi_post'] == 1 && $_POST['type_akun'] == 'user') {
			
				$sistem->registerFlash('s', 'Post "'.$_POST['judul'].'" menunggu diverifikasi oleh admin ');
				$status = 'delay';
				$post = $sistem->single('post', $_POST['id']);

				$user = $sistem->single('users', $post['id_user']);
				
				$bisnis = $sistem->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi']);

				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $bisnis['id_user'], 'post_app', 'Ada Post Perlu di Periksa', 'Postingan <b>'.$_POST['judul'].'</b> dari <b>'.$user['nama_lengkap'].'</b> perlu di cek/periksa, silahkan proses sekarang', $_SESSION['bisnis_kategori_combi'] );
			}else{
				$sistem->registerFlash('w', 'Post "'.$_POST['judul'].'" sudah di posting/draft.');
			}

			$tbl="post";
			$data=array("id");
			$key=array($_POST['id']);
			$ubah=array(
				"judul ='".$_POST['judul']."'",
				"text ='".$_POST['text']."'",
				"status ='".$status."'"
			);
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitKomentar']):
			$profilePosted = $sistem->selectSingleOne('post', 'id', $_POST['id_post']);
			$profileComment = $sistem->selectSingleOne('post', 'id', $_POST['id_user']);

			$user = $sistem->thisProfile($_POST['id_user']);
			$admin = '';
			if ($user['type_user'] == 'admin') {
				$admin = '&type=a';
			}



			$redirect = $sistem->primaryLocal.'view/post?id='.$_POST['id_post'].''.$admin;

			$tbl="komentar";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['id_post']),
				''.$_POST['id_balas'].'xox'.$_POST['komentar'],
			);
			$col=array('id_user','id_post','komentar');
			$sistem->addCountPostComment($_POST['id_post']);
			// $sistem->debug = true;
			if ($_POST['id_user'] != $profilePosted['id_user']) {
				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $profilePosted['id_user'], 'post_comm', 'Komentar di Postinganmu', 'Postingan <b>'.$profilePosted['judul'].'</b> di komentari <b>'.$user['nama_lengkap'].'</b> ', $profilePosted['id_komunitas_bisnis'] );
			}

			$sistem->masukan_data_no_redirect($tbl,$col,$data);
			// echo $redirect.' - '.$_POST['id_user']; die;
			header('Location:'.$redirect);
			
			break;

		case isset($_POST['submitPostDraf']) || isset($_POST['submitPost']):
			// echo var_dump($_POST);
			// die;
			$sistem->redirect = $_POST['redirect'];
			$tbl="post";
			$status = 'publish';
			if (isset($_POST['submitPostDraf'])) {
				$status = 'draft';
				$sistem->registerFlash('i', 'Post "'.$_POST['judul'].'" telah dijadikan draft');
			}

			// cek verifikasi post
			$cekVerifikasiPost = $sistem->single('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);
			if (isset($_POST['submitPost']) && $cekVerifikasiPost['verifikasi_post'] == 1 && $_POST['type_akun'] == 'user') {
				$status = 'delay';
				$user = $sistem->single('users', $_POST['id_user']);
				$sistem->registerFlash('s', 'Post "'.$_POST['judul'].'" menunggu diverifikasi oleh admin ');
				
				$bisnis = $sistem->single('komunitas_bisnis', $_SESSION['bisnis_kategori_combi']);
				// masalah nih

				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $bisnis['id_user'], 'post_app', 'Ada Post Perlu di Periksa', 'Postingan <b>'.$_POST['judul'].'</b> dari <b>'.$user['nama_lengkap'].'</b> perlu di cek/periksa, silahkan proses sekarang', $_SESSION['bisnis_kategori_combi'] );
				// die;

			}else{
				$sistem->registerFlash('w', 'Post "'.$_POST['judul'].'" sudah di posting/draft');
			}

			if ($status == 'publish' && $_POST['type_akun'] == 'admin') {
				// masuk ke notif komunitas
				$sistem->registerFlash('s', 'Proses Berhasil !');
				$sistem->postNotifikasi( $_POST['id_user'], 0, 'post', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );
			}
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['judul']),
				$_POST['text'],
				$_SESSION['bisnis_kategori_combi'],
				$status
			);
			$col=array('id_user','judul','text','id_komunitas_bisnis','status');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updateEcourseKategori']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$tbl="ecourse_kategori";
			$data=array("id");
			$key=array($_POST['id']);
			$ubah=array(
				"nama_kategori ='".$_POST['nama_kategori']."'",
			);
			$sistem->registerFlash('s', 'E-Course Kategori "'.$_POST['nama_kategori'].'" berhasil di update');
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitFaq']):
			$sistem->redirect = $_POST['redirect'];
			// $id_user, $id_user_received, $type, $title, $text, $id_komunitas
			// update notifikasi
			$sistem->postNotifikasi( $_POST['id_user'], 0, 'faq', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

			$sistem->registerFlash('s', 'FAQ "'.$_POST['judul'].'" sudah di tambahkan');

			$sistem->masukan_data('faq', array('id_user', 'id_komunitas_bisnis', 'title', 'text'), array($_POST['id_user'], $_POST['id_komunitas_bisnis'], $_POST['judul'], $_POST['text']));

			break;

		case isset($_POST['requestNewPassword']):
			$cekAlreadyEmail = $sistem->eksekusiShow('select * from users where email="'.$_POST['email'].'"');
			if(empty($cekAlreadyEmail['id'])){
				$sistem->registerFlash('d', 'Email tidak terdaftar !');
			}else{
				$sistem->disableRedirect = true;
				$tkn = $sistem->getRandStr(45);
				$sistem->rubah_data('users', array('token="'.$tkn.'"'), array('email'), array($_POST['email']));
			    $sistem->kirimEmail('','kombi@remotebisnis.com','Kombi RemoteBisnis',$_POST['email'],'Lupa Password Akun KOMBI', $sistem->templateEmail( $sistem->templateLupaPass($tkn) ) );

				$sistem->registerFlash('s', 'Link pemulihan password telah dikirim ke E-mail !, silahkan cek di folder spam (jika tidak ada di kotak utama/inbox)');
			}
		 
			// header('Location:'.$sistem->https.$sistem->primaryLocal.'lupa_password');
			break;

		case isset($_POST['submitPapan']):
			$sistem->redirect = $_POST['redirect'];
			$sistem->postNotifikasi( $_POST['id_user'], 0, 'papan', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

			$sistem->registerFlash('s', '"'.$_POST['judul'].'" sudah di tambahkan');

			$sistem->masukan_data('papan_informasi', array('id_user', 'id_komunitas_bisnis', 'title', 'text'), array($_POST['id_user'], $_POST['id_komunitas_bisnis'], $_POST['judul'], $_POST['text']));
			break;

		case isset($_POST['updatePassword']):
			if ($_POST['recover'] == '1') {
				$param = $_POST['id'];
			}else{
				$param = $_COOKIE['id_akun_combi'];
			}

			$user = $sistem->thisProfile($param);

			if ($_POST['old_pass'] == $user['password'] || $_POST['recover'] == '1') {
				if ($_POST['new_pass'] == $_POST['new_pass2']) {
					if ($_POST['recover'] != '1') {
						$sistem->registerFlash('s', 'Password berhasil di ubah !');
					}else{
						$sistem->registerFlash('s', 'Password berhasil di ubah, silahkan login !');
					}
					$sistem->disableRedirect = true;
					$sistem->rubah_data('users', array('password="'.$_POST['new_pass'].'"', 'token=""'), array('id'), array($param));
				}else{
					$sistem->registerFlash('d', 'Gagal Di ubah!, Pastikan Password dan ulangi password benar ');
				}
			}else{
				$sistem->registerFlash('d', 'Gagal di ubah!, Password lama Anda Salah !');
			}
			if ($_POST['recover'] != '1') {
				if ($user['type_user'] =='user') {
					header('Location: '.$sistem->https.$sistem->primaryLocal.'user/pengaturan');
				}else{
					header('Location: '.$sistem->https.$sistem->primaryLocal.'admin/pengaturan');
				}
			}
			break;

		case isset($_POST['submitAjukanKomisi']):
			$dataAffiliate = $sistem->eksekusiShow("SELECT * from data_affiliate WHERE id_user=".$_POST['id_user']." and id_komunitas_bisnis=".$_POST['id_komunitas_bisnis']);
			if ($dataAffiliate['komisi_belum_cair'] < $_POST['nilai']) {
				$sistem->registerFlash('d', 'Opps !, Terjadi kesalahan, penarikan tidak valid, mohon coba lagi nanti !');
			}else{

				$sisa = $dataAffiliate['komisi_belum_cair'] - $_POST['nilai'];
				$data=array(
					$_POST['id_user'],
					$_POST['id_komunitas_bisnis'],
					$_POST['nilai'],
					$sisa, 
					0
				);
				$sistem->redirect = $_POST['redirect'];
				$col=array('id_user', 'id_komunitas_bisnis', 'saldo_ditarik','sisa_saldo','status');

				$sistem->masukan_data('pengajuan',$col,$data);

				$sistem->eksekusi('update data_affiliate set komisi_belum_cair='.$sisa.' where id_user='.$_POST['id_user'].' and id_komunitas_bisnis='.$_POST['id_komunitas_bisnis']);

				$bisnis = $sistem->selectSingleOne('komunitas_bisnis', 'id', $_POST['id_komunitas_bisnis']);
			
				$user = $sistem->thisProfile($_POST['id_user']);
				$sistem->registerFlash('s', 'Komisi sudah di ajukan');

				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $bisnis['id_user'], 'req_komisi', 'Mengajukan Penarikan Komisi', '<b>'.$user['nama_lengkap'].'</b> Mengajuan komisi dengan nilai <b>Rp'.$sistem->nf($_POST['nilai']).'</b> di komunitas '.$bisnis['nama_komunitas'], $_POST['id_komunitas_bisnis'] );
			}


			break;
		
		case isset($_POST['submitDecPengajuan']) || isset($_POST['submitAccPengajuan']):
			$sistem->redirect = $_POST['redirect'].'?id=1';
			
			$tbl="pengajuan";
			$pengajuan = $sistem->selectSingleOne('pengajuan', 'id', $_POST['id_pengajuan']);
			if (isset($_POST['submitDecPengajuan'])) {
				$status = '3';

				$sistem->eksekusi('update data_affiliate set komisi_belum_cair=komisi_belum_cair+'.$pengajuan['saldo_ditarik'].' where id_user='.$pengajuan['id_user'].' and id_komunitas_bisnis='.$pengajuan['id_komunitas_bisnis']);

				// notif tdk di acc pengajuan
				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $pengajuan['id_user'], 'dec_komisi', 'Pengajuan Komisi ditolak', '😓 Pengajuan komisi dengan nilai <b>Rp'.$pengajuan['saldo_ditarik'].'</b> DITOLAK, lihat di menu <b>Penarikan Komisi</b>', $_POST['id_komunitas_bisnis'] );
				$sistem->registerFlash('d', 'Anda berhasil menolak pengajuan');


			}else{
				$sistem->registerFlash('s', 'Anda berhasil menyetujui pengajuan, segera transfer ke affiliate anda ya!');
				$status = '1';

				$sistem->eksekusi('update data_affiliate set komisi_sudah_cair=komisi_sudah_cair+'.$pengajuan['saldo_ditarik'].' where id_user='.$pengajuan['id_user'].' and id_komunitas_bisnis='.$pengajuan['id_komunitas_bisnis']);

				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $pengajuan['id_user'], 'acc_komisi', 'Pengajuan Komisi disetujui', 'YEEE !🤑, Pengajuan komisi dengan nilai <b>Rp'.$sistem->nf($pengajuan['saldo_ditarik']).'</b> telah DISETUJUI dan di transfer, silahkan cek mutasi Rekening/Ewallet Anda', $_POST['id_komunitas_bisnis'] );
			}

			$data=array("id");
			$key=array($_POST['id_pengajuan']);
			$ubah=array(
				"status ='".$status."'",
				"alasan ='".$_POST['note']."'"
			);
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitOrderDropRes']):
			$clm = array('id_user', 'id_komunitas_bisnis', 'nama_lengkap', 'email', 'nowa', 'provinsi', 'kecamatan', 'alamat','note','status', 'invoice');
			$inv = date('dmy').rand(10,999999);
			$data = array(
				$_COOKIE['id_akun_combi'],
				$_SESSION['bisnis_kategori_combi'],
				$_POST['nama_lengkap'],
				$_POST['email'],
				$_POST['nohp'],
				$_POST['provinsi'],
				$_POST['kecamatan'],
				$_POST['alamat_lengkap'],
				$_POST['note'],
				1,$inv
				
			);

			$sistem->lastId = true;
			$id = $sistem->masukan_data_no_redirect('pesanan', $clm, $data);
			// line
			$sistem->lastId = false;
			$clm = array(
				'id_user', 
				'id_komunitas_bisnis', 
				'id_pesanan', 
				'id_produk', 
				'id_produk_variasi', 
				'nama_produk', 
				'varian_produk', 
				'qty', 
				'harga',
			);
			foreach ($sistem->cart() as $cart) {
				if($cart['harga'] <= 0){
				    $variasi = $onMy->selectSingleOne('produk_variasi', 'id',$cart['id_produk_variasi']);
				    $harga = $variasi['harga'];
				    $total = $harga*$cart['qty'];

				    $tbl="produk_variasi";
					$data=array("id");
					$key=array($cart['id_produk_variasi']);
					$ubah=array(
						"stok =stok-'".$cart['qty']."'"
					);
					$sistem->disableRedirect = true;
					$sistem->rubah_data($tbl,$ubah,$data,$key);
				}else{
				    $harga = $cart['harga'];
				    $total = $harga*$cart['qty'];
				    $variasi = null;

					$tbl="produk";
					$data=array("id");
					$key=array($cart['idp']);
					$ubah=array(
						"stok =stok-'".$cart['qty']."'"
					);
					$sistem->disableRedirect = true;
					$sistem->rubah_data($tbl,$ubah,$data,$key);

				}
				$data = array(
					$_COOKIE['id_akun_combi'],
					$_SESSION['bisnis_kategori_combi'],
					$id,
					$cart['idp'],
					($cart['id_produk_variasi']) ? $cart['id_produk_variasi']: '0',
					$cart['nama_produk'],
					$variasi['nama'],
					$cart['qty'],
					$harga
				);
				$sistem->masukan_data_no_redirect('pesanan_line', $clm, $data);
				
			}
			$sistem->eksekusi('delete from cart where id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi']);

			$owner = $sistem->ownerComunity($_SESSION['bisnis_kategori_combi']);
			$user = $sistem->thisProfile($_COOKIE['id_akun_combi']);	

			// $sistem->debug = true;

			$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $owner['idu'], 'dsre_order', 'Pesanan Produk Baru', '<b>'.$user['nama_lengkap'].'</b> telah memesan produk di komunitas '.$owner['nama_komunitas'].' dengan <b>no invoice #'.$inv.'</b>, mohon periksa sekarang', $_SESSION['bisnis_kategori_combi'] );
			$sistem->registerFlash('s', 'pesanan sudah di buat');
			header('Location:'.$sistem->primaryLocal.'user/invoice?id='.$id);

			break;

		case isset($_POST['submitOrderProduk']):

			// dapatkan data produk
			$produk = $sistem->selectSingleOne('affiliate_produk', 'id', $_POST['id_produk']);

			// buat harga
			$price = $produk['harga'] - rand(1,999);

			if ($produk['harga'] <= 999) {
				$price = 0;
			}


			//get profile affiliate by kode affilaite
			$gaff = $sistem->single('users', $_POST['id_aff']);

			$clm = array('nama', 'nowa', 'email','alamat','domisili','kode_pos','jk','rentang_usia','catatan','id_komunitas_bisnis','id_aff', 'id_produk', 'komisi', 'harga');
			$data = array($_POST['nama'], $_POST['nowa'], $_POST['email'], $_POST['alamat'], $_POST['domisili'], $_POST['kode_pos'], $_POST['jk'], $_POST['rentang_usia'], $_POST['catatan'], $_POST['id_komunitas_bisnis'], $_POST['id_aff'], $_POST['id_produk'], $produk['komisi'], $price);
			// $sistem->debug = true;

			$sistem->lastId = true;

			// save & get user id baru beli ini
			// $sistem->debug = true;
			$lastId = $sistem->masukan_data_no_redirect('order_produk', $clm, $data);

			// get data order baru
			$user = $sistem->single('order_produk', $lastId);
 
			if ($produk['id_user'] != $_POST['id_aff']) {

				$sistem->eksekusi('UPDATE data_affiliate set total_pesanan_produk=total_pesanan_produk+1 WHERE id_komunitas_bisnis="'.$_POST['id_komunitas_bisnis'].'" and id_user='.$_POST['id_aff']);

				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $_POST['id_aff'], 'aff_join', 'Pembelian Produk', '<b>'.$_POST['nama'].'</b>  segera membeli <b>'.$produk['judul'].'</b> lewat link affiliate Anda', $produk['id_komunitas_bisnis'] );
			}

			$sistem->eksekusi('UPDATE data_affiliate set total_pesanan_produk=total_pesanan_produk+1 WHERE id_komunitas_bisnis="'.$_POST['id_komunitas_bisnis'].'" and id_user='.$produk['id_user']);

			$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $produk['id_user'], 'aff_join', 'Pembelian Affiliate Produk', '<b>'.$_POST['nama'].'</b>  akan segera membeli <b>'.$produk['judul'].'</b>, cek sekarang', $produk['id_komunitas_bisnis'] );

			// cd adalah kode affilaite produk
			header('Location:'.$sistem->primaryLocal.'invoice?owner='.$produk['id_user'].'&cd='.$_POST['cd'].'&user='.$user['id'].'&type=produk&typeProduk='.$produk['type'].'&nilai='.$_POST['nilai']);

			break;

		case (isset($_POST['submitMinKomisi']) || isset($_POST['submitAddKomisi'])):
			if (isset($_POST['submitAddKomisi'])) {
				$op = '+';
				$info = 'Pengajuan penambahan berhasil. Menunggu persetujuan Member (Untuk Lebih jelasnya bisa komunikasikan dengan member terkait)';
				$i = 's';
				
				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $_POST['id_user'], 'add_komisi', 'PENAMBAHAN KOMISI', 'Admin mengajukan PENAMBAHAN komisi senilai <b>Rp'.$sistem->nf($_POST['nilai']).'</b> kepada Anda, segera proses supaya cair ke komisi Anda', $_POST['id_komunitas_bisnis'] );

			}

			if (isset($_POST['submitMinKomisi'])) {
				$info = 'Pengajuan pengurangan komisi berhasil. Menunggu persetujuan Member (pastikan member tahu tentang ini)';
				$op = '-';
				$i = 'd';
				// $sistem->debug = true;
				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $_POST['id_user'], 'min_komisi', 'PENGURANGAN KOMISI', 'Admin mengajukan PENGURANGAN komisi senilai <b>Rp'.$sistem->nf($_POST['nilai']).'</b> kepada Anda, segera proses dan hubungi Admin untuk mengetahui alasanya', $_POST['id_komunitas_bisnis'] );
			}
			$sistem->masukan_data_no_redirect('manage_komisi', array('id_user', 'id_komunitas_bisnis', 'operator', 'nilai', 'status'), array($_POST['id_user'], $_POST['id_komunitas_bisnis'], $op, $_POST['nilai'], '1') );
			
			$sistem->registerFlash($i, $info);
			
			header('Location:'.$sistem->https.$_POST['redirect']);

			// $data = array(
			// 	$v
			// );
			// $sistem->rubah_data('data_affiliate', $data, array('id'), array($_POST['id']));
			break;

		case isset($_POST['submitResi']):
			$data=array("id");
			$key=array($_POST['id_pesanan']);
			$ubah=array(
				"resi ='".$_POST['resi']."'"
			);
			if ($_POST['is_aff'] == '1') {
				$tbl = 'order_produk';
				$link = 'affiliate';
				$nm = 'nama';
				$idnm = 'id_aff';
			}else{
				$tbl = 'pesanan';
				$link = 'dropship';
				$nm = 'nama_lengkap';
				$idnm = 'id_user';
			}
			$sistem->redirect = $sistem->primaryLocal.'admin/bisnis/'.$link.'?info=berhasil';
			$order = $sistem->selectSingleOne($tbl, 'id', $_POST['id_pesanan']);
			
			$komunitas = $sistem->selectSingleOne('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);

			if ($order[$idnm] != $_COOKIE['id_akun_combi']) {
				$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], $order[$idnm], 'resi', 'Pesanan Telah dikirim', 'Pesanan dengan A.N <b>'.$order[$nm].'</b> dari komunitas <b>'.$komunitas['nama_komunitas'].'</b> telah dikirim, dan ini nomor resinya <b>'.$_POST['resi'].'</b>', $komunitas['id'] );
			}

			$sistem->registerFlash('s', 'Resi berhasil di tambahkan pada pesanan A.N '.$order[$nm]);
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitRule']):
			$sistem->redirect = $_POST['redirect'].'?s=0';
			
			$sistem->postNotifikasi( $_POST['id_user'], 0, 'rule', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

			$tbl="komunitas_bisnis";
			$data=array("id");
			$key=array($_POST['id']);
			$ubah=array(
				"rule ='".$_POST['rule']."'"
			);
			$sistem->registerFlash('s', 'Rule/aturan berhasil di perbarui');

			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitBisnisAffiliate']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="affiliate_produk";
			$fields = '';
			foreach($_POST['fields_form'] as $key){
				$fields .= "{}".$key;
			}

			$harga = $_POST['harga'];
			if (empty($harga)) {
				$harga = 0;
			}

			$komisi = $_POST['komisi'];
			if (empty($komisi)) {
				$komisi = 0;
			}
			
			if ($_POST['nilai'] == 'gratis') {
				$harga = 0;
				$komisi = 0;
			}
			$cprivate = null;
			if (isset($_POST['cprivate'])) {
				$cprivate = 1;
			}

			$data=array(
				base64_encode($_POST['header']),
				strip_tags($_POST['judul']),
				strip_tags($_POST['note']),
				strip_tags($harga),
				strip_tags($komisi),
				strip_tags($_POST['url']),
				strip_tags($_POST['type_produk']),
				strip_tags($_POST['id_komunitas_bisnis']),
				strip_tags($_POST['id_user']),
				strip_tags($fields),
				strip_tags($_POST['nilai']),
				rand(1,9999999),
				$cprivate

			);
			// $sistem->debug = true;
			$sistem->registerFlash('s', 'Affiliate Produk "'.$_POST['judul'].'" telah di tambahkan');
			$col=array('header','judul', 'note', 'harga', 'komisi', 'url', 'type', 'id_komunitas_bisnis', 'id_user', 'fields', 'nilai', 'kode_affiliate_produk', 'is_private');
			$sistem->postNotifikasi( $_COOKIE['id_akun_combi'], 0, 'new_prod', 'Produk Affilaite Baru', 'Admin menambahkan Affiliate Produk baru nih <b>('.$_POST['judul'].')</b>, cek sekarang !', $_SESSION['bisnis_kategori_combi'] );
			// $sistem->debug = true;	
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updateBisnisAffiliate']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$tbl="affiliate_produk";
			$fields = '';
			foreach($_POST['fields_form'] as $key){
				$fields .= "{}".$key;
			}

			$harga = $_POST['harga'];
			if (empty($harga)) {
				$harga = 0;
			}

			$komisi = $_POST['komisi'];
			if (empty($komisi)) {
				$komisi = 0;
			}
			
			if ($_POST['nilai'] == 'gratis') {
				$harga = 0;
				$komisi = 0;
			}
			$cprivate = null;
			if (isset($_POST['cprivate'])) {
				$cprivate = 1;
			}

			$data=array(
				'header ="'.base64_encode($_POST['header']).'"',
				'judul ="'.strip_tags($_POST['judul']).'"',
				'note ="'.strip_tags($_POST['note']).'"',
				'harga ="'.strip_tags($harga).'"',
				'komisi ="'.strip_tags($komisi).'"',
				'url ="'.strip_tags($_POST['url']).'"',
				'type ="'.strip_tags($_POST['type_produk']).'"',
				'id_komunitas_bisnis ="'.strip_tags($_POST['id_komunitas_bisnis']).'"',
				'id_user ="'.strip_tags($_POST['id_user']).'"',
				'fields ="'.strip_tags($fields).'"',
				'nilai ="'.strip_tags($_POST['nilai']).'"',
				'kode_affiliate_produk ="'.rand(1,9999999).'"',
				'is_private ="'.$cprivate.'"',

			);
			// $sistem->debug = true;
			$sistem->registerFlash('i', 'Affiliate Produk "'.$_POST['judul'].'" telah di update');
			
			$clm = array("id");
			$key = array($_POST['id']);
			$sistem->rubah_data($tbl,$data,$clm,$key);
			break;

		case ($_POST['ajaxType'] == 'ajaxReportOrdersAffiliate' || $_POST['ajaxType'] == 'ajaxDownloadReportOrdersAffiliate'):
			$sistem->downloadReport = false;
			if ($_POST['ajaxType'] == 'ajaxDownloadReportOrdersAffiliate') {
				$sistem->downloadReport = true;
			}
			$sistem->reportOrdersAffiliate($_POST['dateRange'], $_POST['id_komunitas']);
			break;

		case ($_POST['ajaxType'] == 'ajaxReportOrdersProdukAffiliate' || $_POST['ajaxType'] == 'ajaxDownloadReportOrdersProdukAffiliate'):
			$sistem->downloadReport = false;
			if ($_POST['ajaxType'] == 'ajaxDownloadReportOrdersProdukAffiliate') {
				$sistem->downloadReport = true;
			}
			$sistem->reportOrdersProdukAffiliate($_POST['dateRange'], $_POST['id_komunitas']);
			break;

		case ($_POST['ajaxType'] == 'ajaxReportOrdersDropship' || $_POST['ajaxType'] == 'ajaxDownloadReportOrdersDropship'):
			$sistem->downloadReport = false;
			if ($_POST['ajaxType'] == 'ajaxDownloadReportOrdersDropship') {
				$sistem->downloadReport = true;
			}
			$sistem->reportOrdersDropship($_POST['dateRange'], $_POST['id_komunitas']);
			break;

		case ($_POST['ajaxType'] == 'closeFlash'):
			$sistem->removeFlash();
			break;

		case ($_POST['ajaxType'] == 'removeAtc'):
            $onMy->tbl = 'cart';
            $onMy->clm = 'id';
            $onMy->disableRedirect = true;
            // $onMy->debug = true;
            $onMy->hapus_satu_data($_POST['id']);
			break;

		case ($_POST['ajaxType'] == 'atc'):
			$id_produk = '';
			$clm = array('id_user', 'id_komunitas_bisnis', 'id_produk', 'qty');
			$data = array($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], $_POST['id_produk'], $_POST['qty']);

			if (!empty($_POST['id_produk_variasi'])) {
				$id_produk = 'id_produk="'.$_POST['id_produk'].'" and';
				$clm = array('id_user', 'id_komunitas_bisnis', 'id_produk', 'id_produk_variasi', 'qty');
				$data = array($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi'], $_POST['id_produk'], $_POST['id_produk_variasi'], $_POST['qty']);
			}
			$where = 'where '.$id_produk.' id_produk_variasi='.$_POST['id_produk_variasi'].' and id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'];
			$checkCart = $sistem->eksekusiShow('select * from cart '.$where);
			// echo 'select * from cart '.$where;
			// die;
			

			if ( empty($checkCart['id']) ) {
				// $sistem->debug = true;
				$sistem->masukan_data_no_redirect('cart', $clm, $data);
			}else{
				$sistem->eksekusi(' update cart set qty='.$_POST['qty'].' '.$where);
			}

			break;

		case ($_POST['ajaxType'] == 'gabungKomunitas'):
			$url_components = parse_url($_POST['url']);
			parse_str($url_components['query'], $params);
			$cd = $params['cd'];
			$aff = $params['aff'];
			$id_komunitas = $sistem->eksekusiShow('select *, n.id_user as idu,kb.id as idk, kb.harga as h, kb.nama_komunitas as nk, kb.id_user as idu from komunitas_bisnis as kb join norek as n on n.id_user = kb.id_user where kb.code_komunitas="'.$cd.'"');

			$gaff = $sistem->getProfileAffiliate($aff);


			// cek jika sudah pernah join dan belum di approve/tf
			$text = '';
			$cekTf = $sistem->eksekusiShow('select * from komunitas where id_komunitas='.$id_komunitas['idk'].' and id_user='.$_POST['id_user'])['price_join'];
			$user = $sistem->thisProfile($_POST['id_user']);

			if ( !empty($cekTf) ){
				// $text .= '<div class="alert alert-info">Anda sudah pernah </div>';
				$ownerPrice = $cekTf;
			}else{
				if (empty($id_komunitas)) {
					echo '<div class="alert alert-danger"><b>Opps</b> !, Link/URL Tidak Valid</div>';
					die;
				}else{
					$ownerPrice = $id_komunitas['h']-rand(1,999);
					// cek ini link aff dari aff atau owner itu sendiri
					if ($gaff['id'] != $id_komunitas['idu']) {
						$col = array('id_user', 'id_affiliate', 'id_komunitas_bisnis', 'price_join', 'type', 'komisi');
						$data = array($_POST['id_user'], $gaff['id'], $id_komunitas['idk'], $ownerPrice, 1, $id_komunitas['komisi_affiliate_join']);
						$sistem->masukan_data_no_redirect('lead',$col,$data);

						$sistem->eksekusi('UPDATE data_affiliate set total_lead=total_lead+1 WHERE id_komunitas_bisnis="'.$id_komunitas['idk'].'" and id_user='.$gaff['id']);

						$sistem->postNotifikasi( 0, $gaff['id'], 'aff_join', 'Affiliate/Member Baru', '<b>'.$user['nama_lengkap'].'</b> telah daftar komunitas <b>'.$id_komunitas['nama_komunitas'].'</b> lewat link affiliate Anda', $id_komunitas['idk'] );

					}else{
						$col = array('id_user', 'id_affiliate', 'id_komunitas_bisnis', 'price_join', 'type', 'komisi');
						$data = array($_POST['id_user'], $id_komunitas['idu'], $id_komunitas['idk'], $ownerPrice, 1, $id_komunitas['komisi_affiliate_join']);
						$sistem->masukan_data_no_redirect('lead',$col,$data);

					}

					$sistem->postNotifikasi( 0, $id_komunitas['idu'], 'aff_join', 'Affiliate/Member Baru ', '<b>'.$user['nama_lengkap'].'</b> telah mendaftar komunitas <b>'.$id_komunitas['nama_komunitas'].'</b>', $id_komunitas['idk'] );

					$sistem->eksekusi('UPDATE data_affiliate set total_lead=total_lead+1 WHERE id_komunitas_bisnis="'.$id_komunitas['idk'].'" and id_user='.$id_komunitas['idu']);

					$sistem->masukan_data_no_redirect('komunitas', array('id_user', 'id_komunitas', 'price_join', 'id_affiliate'), array($_POST['id_user'], $id_komunitas['idk'], $ownerPrice, $gaff['id']));

					$text .= '<div class="alert alert-info"><b>Selamat</b> !, Anda segera bergabung ke komunitas baru, segera ikuti langkah dibawah ini.</div>';
					
				}
			}
			$wa = $sistem->selectSingleOne('komunitas_bisnis', 'id', $id_komunitas['idk'])['nowa'];
			$text .= '<p class="login-box-msg pb-0"><b>INVOICE : <br><span class="text-warning">'.$id_komunitas['nk'].'</span></b></p>
				        <div class="text-center">
				          <p><u>Segera Lakukan Pembayaran Senilai</u> </p>
				          <h4 class="text-warning"><b>Rp'.$sistem->nf($ownerPrice).'  </b></h4>
				          ke salah satu rekening ini
				        </div>
				        <hr style="border: 1px dashed black;">
				        <div class="child-p">';
					 
				foreach ($sistem->select('norek',$id_komunitas['idu']) as $value) {
	              	$norek = ( !empty($value['kode_bank']) ) ? '('.$value['kode_bank'].')' : '';

					$text .= '
			            <p>
			              <b>'.$value['nama_bank'].'</b><br>
			              <b>'.$value['nama_pemilik'].'</b><br>
			              <b>'.$norek.' '.$value['norek'].'</b>
			            </p>
					';
					
				}
			$img = '';
			foreach (explode(',', $sistem->selectSingleOne('users', 'id', $id_komunitas['idu'])['logo_bank']) as $bank){
	            if ($bank != 'x'){
	              $img .= '<img src="'.$bank.'" width="40"> &nbsp;&nbsp;';
	            }
          	}

			echo $text.'<a href="'.$sistem->noWa($wa).'" target="_blank">Hubungi Juga Admin Komunitas ('.$wa.')</a><hr></div> '.$img; 

			break;

		case ($_POST['ajaxType'] == 'checkEmail'):
			if ( !empty($sistem->eksekusiShow('select * from users where email="'.$_POST['text'].'"')['id']) ){
				echo "Email sudah ada/terdaftar, silahkan gunakan email lain";
			}

			break;

		case ($_POST['ajaxType'] == 'ajaxLikePost'):
			$sistem->addCountPostLike($_POST['id_post']);
			$sistem->redirect = null;
			$tbl="`like`";
			$data=array(
				strip_tags($_POST['id_user']),
				strip_tags($_POST['id_post']),
			);
			$col=array('id_user','id_post');
			// $sistem->debug = true;
			$sistem->masukan_data_no_redirect($tbl,$col,$data);
			break;

		case isset($_POST['submitDaftar']):	
			if ( empty($sistem->eksekusiShow('select * from users where email="'.$_POST['email'].'"')['id']) ){		 
				if($mdetect->isMobile()){ 
				    if($mdetect->isTablet()){ 
				        $perangkat = 'Tablet'; 
				    }else{ 
				        $perangkat = 'Mobile'; 
				    }
				     
				    // Detect platform 
				    if($mdetect->isiOS()){ 
				        $perangkat .= ' - IOS'; 
				    }elseif($mdetect->isAndroidOS()){ 
				        $perangkat .= ' - ANDROID'; 
				    } 
				}else{ 
				    $perangkat = 'Desktop';
				}
				$sistem->redirect = null;
				$tbl="users";

				$username = strtolower( str_replace(' ','',$_POST['nama_lengkap']).rand(1,99999) );
				while (!empty( $sistem->eksekusiShow('select * from users where username="'.$username.'"')['id'] )) {
					$username = str_replace(' ','',$_POST['nama_lengkap']).rand(1,99999);
				}

				// dapatkan data owner user komunitas
				$owner = $sistem->eksekusiShow('select u.id, kb.id as idk, kb.harga , kb.komisi_affiliate_join as kaj from komunitas_bisnis as kb join users as u on kb.id_user = u.id where kb.code_komunitas='.$_POST['cd']);

				//harga kurangi random number 999
				$ownerPrice = $owner['harga']-rand(1,999);
				
				//get profile affiliate by kode affilaite
				$gaff = $sistem->getProfileAffiliate($_POST['aff']);

				$aff = $owner['id'];
				if (!empty($gaff['id'])) {
					$aff = $gaff['id'];
				}

				$data=array(
					strip_tags($_POST['nama_lengkap']),
					strip_tags($_POST['email']),
					strip_tags($_POST['domisili']),
					strip_tags($_POST['nowa']), $perangkat,
					$username, 
					$sistem->getRandStr(29), 
					$_POST['nowa'], 
					$aff, 
					0, 
					$ownerPrice, 
					'user', 
					'cat.png',
					$_POST['tahu'],
				);

				$col=array('nama_lengkap','email','domisili','nowa','perangkat','username','kode_affiliate','password','affiliate', 'status', 'price_join', 'type_user', 'dp', 'tahu');
				// $sistem->debug = true;
				$sistem->masukan_data_no_redirect($tbl,$col,$data);


				// tampil user terbaru yg baru daftar
				$user = $sistem->eksekusiShow('select * from users where email="'.$_POST['email'].'"')['id'];

				// tampil data komunitas by kode komunitas
				$id_komunitas = $sistem->eksekusiShow('select * from komunitas_bisnis where code_komunitas="'.$_POST['cd'].'"');

				// masuk ke data_affiliate
				$sistem->masukan_data_no_redirect('data_affiliate',array('id_user', 'id_komunitas_bisnis'),array($user, $id_komunitas['id']));

				// masuk ke data_dropship
				$sistem->masukan_data_no_redirect('data_dropship',array('id_user', 'id_komunitas_bisnis'),array($user, $id_komunitas['id']));


				// tambah user yg daftar ke komunitas dimana dia daftar
				$sistem->eksekusi('insert into komunitas (id_user, id_komunitas, price_join, id_affiliate) values ("'.$user.'", "'.$id_komunitas['id'].'", "'.$ownerPrice.'", "'.$aff.'")');
				
				// tambah + catat komisi, harga untuk affilaite (jika ada)
				if ($id_komunitas['id_user'] != $gaff['id']) {
					$col = array('id_user', 'id_affiliate', 'id_komunitas_bisnis', 'price_join', 'type', 'komisi');
					$data = array($user, $aff, $owner['idk'], $ownerPrice, 1, $owner['kaj']);
					$sistem->masukan_data_no_redirect('lead',$col,$data);

					$sistem->eksekusi('UPDATE data_affiliate set total_lead=total_lead+1 WHERE id_komunitas_bisnis="'.$id_komunitas['id'].'" and id_user='.$gaff['id']);
					
					$sistem->postNotifikasi( 0, $gaff['id'], 'aff_join', 'Affiliate/Member Baru', '<b>'.$_POST['nama_lengkap'].'</b>  telah daftar komunitas <b>'.$id_komunitas['nama_komunitas'].'</b> lewat link affiliate Anda', $owner['idk'] );
	 
				}else{
					//masukan ke catatan menu lead
					$col = array('id_user', 'id_affiliate', 'id_komunitas_bisnis', 'price_join', 'type', 'komisi');
					$data = array($user, $owner['id'], $owner['idk'], $ownerPrice, 1, $owner['kaj']);
					$sistem->masukan_data_no_redirect('lead',$col,$data);
					 
				}
				$sistem->postNotifikasi( 0, $owner['id'], 'aff_join', 'Affiliate/Member Baru', '<b>'.$_POST['nama_lengkap'].'</b> telah mendaftar komunitas <b>'.$id_komunitas['nama_komunitas'].'</b>', $owner['idk'] );

				$sistem->eksekusi('UPDATE data_affiliate set total_lead=total_lead+1 WHERE id_komunitas_bisnis="'.$id_komunitas['id'].'" and id_user='.$owner['id']);

				header('Location:'.$sistem->primaryLocal.'invoice?owner='.$owner['id'].'&cd='.$_POST['cd'].'&nilai=berbayar&user='.$user);
			}else{
				$sistem->registerFlash('d', 'Email sudah terdaftar, silahkan gunakan email lain !');
			}
			break;

		case isset($_POST['submitNoRek']):
			$sistem->redirect = $_POST['redirect'].'?b=s';
			$sistem->tbl = 'norek';
			$sistem->clm = 'id_user';
			$sistem->hapus_satu_data($_POST['id_user']);

			for ($i=0; $i < count($_POST['nomor']); $i++) { 
				$data=array(
					strip_tags($_POST['id_user']),
					strip_tags($_POST['kode'][$i]),
					strip_tags($_POST['nama'][$i]),
					strip_tags($_POST['nomor'][$i]),
					strip_tags($_POST['pemilik'][$i]),
				);
				$col=array('id_user', 'kode_bank', 'nama_bank', 'norek', 'nama_pemilik');
				$sistem->masukan_data_no_redirect('norek',$col,$data);
			}
			$img = 'x,';
			foreach($_POST['gambarbank'] as $gambar){
				$img .= $gambar.',';
			}
			if (isset($_POST['note'])) {
				$tbl="users";
				$data=array("id");
				$key=array($_POST['id_user']);
				$ubah=array(
					"note_after_invoice ='".$_POST['note']."'",
					"logo_bank ='".$img."'"
				);
				$sistem->rubah_data($tbl,$ubah,$data,$key);
			}
			
			$sistem->registerFlash('s', 'Rekening berhasil di update');

			header('Location:'.$sistem->https.$_POST['redirect'].'?info=berhasil');

			break;

		case ($_POST['ajaxType'] == 'ssProduk'):
			// select *,k.price_join as price, u.id as idu, k.id_affiliate from users as u join komunitas as k on k.id_user = u.id where k.status = 0 and k.id_komunitas=".$bisnis." order by k.created_at
			$cekUser = $sistem->thisProfile($_COOKIE['id_akun_combi']);

			$sql = "select * from order_produk where id_komunitas_bisnis=".$_SESSION['bisnis_kategori_combi']." ";
			if ($cekUser['type_user'] == 'user') {
				$sql .= ' and id_aff='.$_COOKIE['id_akun_combi'].' and status = 1 ';
			}
			// generate page
			$batas = 10;
			$halaman = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
			$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;  

			$previous = $halaman - 1;
			$next = $halaman + 1;			
 
			if ($_POST['cari']) {
				$sql .= " and (nama like '%".$_POST['cari']."%' OR harga like '%".$_POST['cari']."%') ";
			}

			$countPage = str_replace('*', ' count(*) as total ', $sql);
			$count = $sistem->eksekusiShow($countPage)['total'];
			

			$query = $sistem->tampil_manual($sql.' order by id desc limit '.$halaman_awal.', '.$batas);
			$html = '';
			$no = 1;

			// page
			$jumlah_data = $count;
			$total_halaman = ceil($jumlah_data / $batas);

			$nomor = $halaman_awal+1;
			$html = '';
			$no = 1;

			foreach ($query as $value) {
				$komisi = $sistem->getSpesificLead('komisi', $value['idu'], $_SESSION['bisnis_kategori_combi'])['komisi'];
				$usercek = $sistem->single('users', $value['id_aff']);
				if ($usercek['id'] == $_COOKIE['id_akun_combi']) {
					$aff = "Anda";
					$email = $value['email'].'<br>';
					$nowa = $value['nowa'];
				}else{
					$aff = $usercek['nama_lengkap'];
					$email = substr($value['email'], 0, 3).'******@**.com <br>';
					$nowa = substr($value['nowa'], 0, 3).'*******';

				}

				if ($cekUser['type_user'] == 'user') {
					$email = '*****@gmail.com <br>';
					$nowa = '0825*******';
					$aff = 'Anda';
				}

				$cekUser = $sistem->thisProfile($_COOKIE['id_akun_combi'])['type_user'];
				$btn = $value['nama'];
				if ($cekUser == 'admin') {
					$href = 'href="'. $sistem->primaryLocal .'admin/approve/produkaff?id='. $value['id'] .'&id_komunitas='. $_SESSION['bisnis_kategori_combi'] .'&url='.$sistem->primaryLocal.'admin/bisnis/affiliate&price='. $value['harga'] .'&komisi='. $value['komisi'] .'&aff='.$value['id_aff'] .'';
					$hrefSetuju = $href.'&status=3"';
					$hrefTolak = $href.'&status=2"';

					$noption = '';
					$produkIni = $onMy->selectSingleOne('affiliate_produk', 'id', $value['id_produk']);
					if ($value['status'] == '1') {
						$topOption = "<span class='badge badge-info'>Belum di proses</span>";
					}elseif($value['status'] == '3'){
						if ($produkIni['type'] == 'fisik') {
							if (empty($value['resi']) || $value['resi'] == null || $value['resi'] == '') {
							  $noption = '
							    <a class="dropdown-item" href="#es" onclick="return formResiAff('.$value['id'].')"><i class="fa fa-barcode"></i> Input Resi</a>
							  ';
							}
						}
						$topOption = "<span class='badge badge-warning'>Sudah di proses</span>";
					}
					$stt1 = '';
					if ($value['status'] == 1) {
						$stt1 = '<a class="dropdown-item" onclick="return msg(`Yakin memproses pesanan ini ?, komisi akan di tambahkan ke affiliate(jika pembeli ini datang dari affiliate)`)" '.$hrefSetuju.'>Setujui/Proses</a>

                            <a class="dropdown-item" onclick="return msg(`Yakin menolak pesanan ini ?`)" '.$hrefTolak.'>Tolak</a>';
					}
					$resi = '';
					if($value['resi']){ $resi = '<br>RESI : <b>'.$value['resi'].'</b>';}
					$btn = $topOption.$resi.'<br><div class="btn-group">
                          <button type="button" class="btn btn-warning">'. $value['nama'] .'</button>
                          <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only"></span>
                          </button>
                          <div class="dropdown-menu" role="menu">
                            <a target="_blank" class="dropdown-item" href="'.$onMy->primaryLocal.'admin/view/produkaff?id='.$value['id'].'">Lihat Detail</a>        
                          	'.$noption.'
                            '.$stt1.'
                          </div>
                        </div>';
				}
                $html .= '
                	<tr>
                      <td>'. $no++ .'</td>
                      <td>
                        '.$btn.'
                      </td>
                      <td>
                        '.$email.''.$nowa.'
                      </td>
                      <td>'. $sistem->selectSingleOne('affiliate_produk', 'id', $value['id_produk'])['judul'] .'</td>
                      <td>
                        Transfer Senilai : <b class="btn btn-default font-weight-bold">Rp '. $sistem->nf($value['harga']) .'</b>  <br><br>
                        <small>Waktu Daftar : <b>'. $sistem->time_elapsed_string($value['created_at']) .'<br><br></b>
                        Affilaite : 
                        '.$aff.'
                        </small>
                      </td>
                    </tr>
                ';
			}

			// html page
			$prev = '';
			if($halaman > 1){ $prev = 'onclick="paginateP('.$previous.')"'; }

			$centerPage ='';
			if ($halaman != $total_halaman){
				$centerPage ='<li class="page-item"><a href="#ss" class="page-link">...</a></li>';
			}
			
			$nexts = '';
			if($halaman < $total_halaman) { $nexts = 'onclick="paginateP('.$next.')"'; }

			$stopNumber = 0;
			$pageLiHtml = '';
	        for($x=$_POST['page'];$x<=$total_halaman;$x++){
				$stopNumber++;
				if ($stopNumber <= 7) {
					$active = '';
					if($x == 1 && empty($_POST['page'])){
						$active = 'active';
					}

					$active2 = '';
					if($x == $_POST['page'] && !empty($_POST['page'])){
						$active2 = 'active';
					}
					$pageLiHtml .= '
				        <li class="page-item '.$active.' '.$active2.' "><a onclick="paginateP('.$x.')" class="page-link" href="#cariUser">'.$x.'</a></li>
					';
				}
			}	

			$endPage = '
				<li class="page-item">
							<a class="page-link" '.$nexts.'>Next</a>
						</li>
						<li class="page-item">
							<a class="page-link" onclick="paginateP('.$total_halaman.')" href="#cariUser">></a>
						</li>
			';
			if ($_POST['page'] == $total_halaman) {
				$endPage = '';
			}
			

			$htmlPage = '
			<hr>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center" id="pagenav">
						<li class="page-item">
							<a class="page-link" onclick="paginateP(1)" href="#cariUser"><</a>
						</li>
						<li class="page-item">
							<a class="page-link" '.$prev.'>Previous</a>
						</li>

						'.$pageLiHtml.$centerPage.$endPage.'
					</ul>
				</nav>
			';
			echo json_encode(array('data' => $html, 'page' => $htmlPage));
			break;

		case ($_POST['ajaxType'] == 'ssUser'):
			// select *,k.price_join as price, u.id as idu, k.id_affiliate from users as u join komunitas as k on k.id_user = u.id where k.status = 0 and k.id_komunitas=".$bisnis." order by k.created_at
			$sql = "select *,k.price_join as price, u.id as idu, k.id_affiliate from users as u join komunitas as k on k.id_user = u.id where k.status = 0 and k.id_komunitas=".$_SESSION['bisnis_kategori_combi'];

			$cekUser = $sistem->thisProfile($_COOKIE['id_akun_combi']);
			if ($cekUser['type_user'] == 'user') {
				$sql = "select *,k.price_join as price, u.id as idu, k.id_affiliate from users as u join komunitas as k on k.id_user = u.id where k.id_affiliate=".$_COOKIE['id_akun_combi']." and k.status = 0 and k.id_komunitas=".$_SESSION['bisnis_kategori_combi']." ";
			}
			// generate page
			$batas = 10;
			$halaman = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
			$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;  

			$previous = $halaman - 1;
			$next = $halaman + 1;			
 
			if ($_POST['cari']) {
				$sql .= " and (nama_lengkap like '%".$_POST['cari']."%') ";
			}

			$countPage = str_replace('*', ' count(*) as total ', $sql);
			$count = $sistem->eksekusiShow($countPage)['total'];

			$query = $sistem->tampil_manual($sql.' order by u.id desc limit '.$halaman_awal.', '.$batas);
			$html = '';
			$no = 1;

			// page
			$jumlah_data = $count;
			$total_halaman = ceil($jumlah_data / $batas);

			$nomor = $halaman_awal+1;
			$html = '';
			$no = 1;
			foreach ($query as $value) {
				$komisi = $onMy->getSpesificLead('komisi', $value['idu'], $_SESSION['bisnis_kategori_combi'])['komisi'];
                $usercek = $onMy->single('users', $value['id_affiliate']);
                if ($usercek['id'] == $_COOKIE['id_akun_combi']) {
                  $aff = "Anda";
                  $email = $value['email'].'<br>';
                  $nowa = $value['nowa'];
                }else{
                  $aff = $usercek['nama_lengkap'];
                  $email = substr($value['email'], 0, 3).'******@**.com <br>';
                  $nowa = substr($value['nowa'], 0, 3).'*******';

                }
                if ($cekUser['type_user'] == 'user') {
                	$html .= '
                		<tr>
                            <td>'.$no++ .'</td>
                            <td>
                              '.$value['nama_lengkap'] .'
                            </td>
                            <td>
                              <span data-toggle="tooltip" data-placement="top" title="Untuk keamanan dan privasi data, member yang bergabung lewat link affilaite anda kami tutupi"><i class="fa fa-info-circle"></i></span>
                              '.substr($value['email'], 0, 3).'******@**.com'
                              .' <br>
                              '.
                                substr($value['nowa'], 0, 5).'******'
                              .'
                            </td>
                            <td>
                              Transfer Senilai : <b class="btn btn-default font-weight-bold">Rp '.$onMy->nf($value['price']) .'</b>  <br><br>
                              Waktu Daftar : <b>'.$onMy->time_elapsed_string($value['tgl_daftar']) .'<br><br></b>
                              Status Akun : <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="Belum di Aktivasi oleh Admin Komunitas">Belum Aktif <i class="fa fa-info-circle"></i></span>
                            </td>
                          </tr>
                	';
                }else{
	                $html .= '
	                	<tr>
		                  <td>'.$no++.'</td>
		                  <td>
		                    <div class="btn-group">
		                      <button type="button" class="btn btn-warning">'.$value['nama_lengkap'] .'</button>
		                      <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
		                        <span class="sr-only"></span>
		                      </button>
		                      <div class="dropdown-menu" role="menu">
		                        <a class="dropdown-item" onclick="return msg(`Akun ini akan menjadi member dari komunitas ini, yakin untuk menyetujuinya ?`)" href="'.$sistem->primaryLocal .'admin/approve/user?id_user='.$value['idu'] .'&id_komunitas='.$_SESSION['bisnis_kategori_combi'] .'&url='.$sistem->primaryLocal.'admin/bisnis/affiliate&price='.$value['price'] .'&komisi='.$komisi .'&aff='.$value['id_affiliate'] .'&owner='.$_COOKIE['id_akun_combi'] .'">Setujui</a>
		                      </div>
		                    </div>
		                  </td>
		                  <td>
		                    '.$email .' <br>
		                    '.$nowa .'
		                  </td>
		                  <td>
		                    Transfer Senilai : <b class="btn btn-default font-weight-bold">Rp '.$sistem->nf($value['price']) .'</b>  <br><br>
		                    Waktu Daftar : <b>'.$sistem->time_elapsed_string($value['created_at']) .'<br><br></b>
		                    Affilaite : 
		                    '.$aff.'
		                  </td>
		                </tr>
	                ';
				}
			}

			// html page
			$prev = '';
			if($halaman > 1){ $prev = 'onclick="paginateA('.$previous.')"'; }

			$centerPage ='';
			if ($halaman != $total_halaman){
				$centerPage ='<li class="page-item"><a href="#ss" class="page-link">...</a></li>';
			}
			
			$nexts = '';
			if($halaman < $total_halaman) { $nexts = 'onclick="paginateA('.$next.')"'; }

			$stopNumber = 0;
			$pageLiHtml = '';
	        for($x=$_POST['page'];$x<=$total_halaman;$x++){
				$stopNumber++;
				if ($stopNumber <= 7) {
					$active = '';
					if($x == 1 && empty($_POST['page'])){
						$active = 'active';
					}

					$active2 = '';
					if($x == $_POST['page'] && !empty($_POST['page'])){
						$active2 = 'active';
					}
					$pageLiHtml .= '
				        <li class="page-item '.$active.' '.$active2.' "><a onclick="paginateA('.$x.')" class="page-link" href="#cariUser">'.$x.'</a></li>
					';
				}
			}	

			$endPage = '
				<li class="page-item">
							<a class="page-link" '.$nexts.'>Next</a>
						</li>
						<li class="page-item">
							<a class="page-link" onclick="paginateA('.$total_halaman.')" href="#cariUser">></a>
						</li>
			';
			if ($_POST['page'] == $total_halaman) {
				$endPage = '';
			}
			

			$htmlPage = '
			<hr>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center" id="pagenav">
						<li class="page-item">
							<a class="page-link" onclick="paginateA(1)" href="#cariUser"><</a>
						</li>
						<li class="page-item">
							<a class="page-link" '.$prev.'>Previous</a>
						</li>

						'.$pageLiHtml.$centerPage.$endPage.'
					</ul>
				</nav>
			';
			echo json_encode(array('data' => $html, 'page' => $htmlPage));

			break;


		case ($_POST['ajaxType'] == 'ssUserPesanan'):
			$sql = "select * from pesanan ";

			// generate page
			$batas = 10;
			$halaman = (isset($_POST['page'])) ? (int)$_POST['page'] : 1;
			$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;  

			$previous = $halaman - 1;
			$next = $halaman + 1;			

			if ($_POST['type'] == 'user') {
				$sql .= 'where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' and id_user='.$_COOKIE['id_akun_combi'].' ';
			}elseif($_POST['type'] == 'admin'){
				$sql .= 'where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' ';
			}

			if ($_POST['dateRange']) {
				$dates = str_replace(' ', '', $_POST['dateRange']);
				$date = explode('-', $dates);
				$cdate = $sistem->convertDate("Y-m-d", $date[0]);
				$cdate2 = $sistem->convertDate("Y-m-d", $date[1]);
				if ($cdate2 == $cdate) {
					$sql .= " and created_at like '%".$cdate."%' ";
				}else{
					$sql .= " and (created_at between '".$cdate."' and '".$cdate2."') ";
				}
			}

			if ($_POST['cari']) {
				$sql .= " and (nama_lengkap like '%".$_POST['cari']."%' OR 
					invoice like '%".$_POST['cari']."%' OR
					email like '%".$_POST['cari']."%' OR
					nowa like '%".$_POST['cari']."%' OR
					provinsi like '%".$_POST['cari']."%' OR
					kecamatan like '%".$_POST['cari']."%' OR
					resi like '%".$_POST['cari']."%'
				) ";
			}

			if ($_POST['status'] != 0) {
				$sql .= "
					and status='".$_POST['status']."' 
				";
			}
			if ($_POST['page']) {
				// $sql .= " and ";
			}

			// query page

			$countPage = str_replace('*', ' count(*) as total ', $sql);
			$count = $sistem->eksekusiShow($countPage)['total'];
			// $sistem->debug = true;
			$query = $sistem->tampil_manual($sql.' order by id desc limit '.$halaman_awal.', '.$batas);
			$html = '';
			$no = 1;

			// page
			$jumlah_data = $count;
			$total_halaman = ceil($jumlah_data / $batas);

			$nomor = $halaman_awal+1;

			$cekOpened = $sistem->thisProfile($_COOKIE['id_akun_combi']);

			foreach ($query as $d) {
				$stt = '';
				if ($d['status'] == '1'):
					$stt = '<small><i class="fa fa-circle text-warning"></i> Belum di proses</small>';
				elseif ($d['status'] == '2'):
					$stt = '<small><i class="fa fa-circle text-danger"></i> Ditolak</small>';
				elseif ($d['status'] == '3'):
					$stt = '<small><i class="fa fa-circle text-success"></i> Diterima</small>';
				endif;

				$resi = '';
				if ($d['resi']) {
					$resi = 'RESI : <b>'.$d['resi'].'</b><br>';
				}

				$member = '';
				if ($_POST['type'] == 'admin') {
					$member = '<td>'.$sistem->thisProfile($d['id_user'])['nama_lengkap'].'</td>';
				}

				$admindrop = '';
				if ($cekOpened['type_user'] == 'admin') {
					if ($d['status'] == '3' && !$d['resi']){
						$admindrop .= '<a class="dropdown-item btnresi" href="#resi" data-toggle="modal" data-target="#modalResi" onclick="return resi('.$d['id'].', `'.$d['invoice'].'`)"><i class="fa fa-barcode"></i> Input RESI</a>';
					}

					if ($d['status'] == '1'){
						$admindrop .= '
						<a class="dropdown-item" onclick="return confirm(`akin untuk menerima pesanan ini ?`)" href="'.$sistem->primaryLocal.'produk/acc?id='.$d[id] .'&status=3&url='.$sistem->primaryLocal .'admin/bisnis/dropship?info=berhasil" ><i class="fa fa-check"></i> Terima</a>

						<a class="dropdown-item" onclick="return confirm(`Yakin untuk menolak pesanan ini ?`)" href="'.$sistem->primaryLocal .'produk/acc?id='.$d[id] .'&status=2&url='.$sistem->primaryLocal .'admin/bisnis/dropship?info=berhasil" ><i class="fa fa-times"></i> Tolak</a>';
					}

					 
				}
				$nohp = '08******';
				if($d['status'] == 3 || $cekOpened['type_user'] == 'user'){
					$nohp = $d['nowa'];
				}
				$html .= '
                  <tr>
                    <td>'. $no++ .'</td>
                    <td>
	                    '.$stt.'
                      <br>
                      	'.$resi.'
                        <div class="btn-group dropup">
                          <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only"></span> '.$d['invoice'].'
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="'.$sistem->primaryLocal.'user/invoice?id='.$d['id'].'" target="_blank"><i class="fa fa-eye"></i> Detail Pesanan</a>
                            '.$admindrop.'
                          </div>
                        </div>
                    </td>
                    '.$member.'
                    <td>
                      <b>Penerima : '. $d['nama_lengkap'] .'</b><br>
                      No Hp : '. $nohp .'<br>
                      '. $d['provinsi'].', '.$d['alamat'] .'<br>
                    </td>
                    <td>'. $sistem->time_elapsed_string($d['created_at']).'</td>
                  </tr>
				';
			}

			// html page
			$prev = '';
			if($halaman > 1){ $prev = 'onclick="paginate('.$previous.')"'; }

			$centerPage ='';
			if ($halaman != $total_halaman){
				$centerPage ='<li class="page-item"><a href="#ss" class="page-link">...</a></li>';
			}
			
			$nexts = '';
			if($halaman < $total_halaman) { $nexts = 'onclick="paginate('.$next.')"'; }

			$stopNumber = 0;
			$pageLiHtml = '';
	        for($x=$_POST['page'];$x<=$total_halaman;$x++){
				$stopNumber++;
				if ($stopNumber <= 7) {
					$active = '';
					if($x == 1 && empty($_POST['page'])){
						$active = 'active';
					}

					$active2 = '';
					if($x == $_POST['page'] && !empty($_POST['page'])){
						$active2 = 'active';
					}
					$pageLiHtml .= '
				        <li class="page-item '.$active.' '.$active2.' "><a onclick="paginate('.$x.')" class="page-link" href="#hal">'.$x.'</a></li>
					';
				}
			}	

			$endPage = '
				<li class="page-item">
							<a class="page-link" '.$nexts.'>Next</a>
						</li>
						<li class="page-item">
							<a class="page-link" onclick="paginate('.$total_halaman.')" href="#xxx">></a>
						</li>
			';
			if ($_POST['page'] == $total_halaman) {
				$endPage = '';
			}
			

			$htmlPage = '
			<hr>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center" id="pagenav">
						<li class="page-item">
							<a class="page-link" onclick="paginate(1)" href="#jjkj"><</a>
						</li>
						<li class="page-item">
							<a class="page-link" '.$prev.'>Previous</a>
						</li>

						'.$pageLiHtml.$centerPage.$endPage.'
					</ul>
				</nav>
			';

			echo json_encode(array('data' => $html, 'page' => $htmlPage));
			break;

	}