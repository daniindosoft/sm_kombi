<?php
	error_reporting(0);

	 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	include_once('koneksi.php');
	include_once('system.php');

	$a=new koneksi();
	$db=$a->hubungkan();
	$sistem=new kontrols($db);
	
	if(isset($_POST['login'])) {
		$sistem->masuk($_POST['email'], $_POST['password']);
	}

	$user = $sistem->singleUser($_COOKIE['id_akun_combi']);

	if(isset($_POST['submitBisnisKomunitas'])) {
		$menu = '0';
		$verif = '0';
		if (isset($_POST['menu'])) {
			$menu = '1';
		}
		if (isset($_POST['verifikasi'])) {
			$verif = '1';
		}
		$sistem->redirect = $_POST['redirect'];
		$tbl="komunitas_bisnis";

		$komunitascode = rand(1000000,9999999);

		$data=array(
			str_replace("'", "", $_POST['nama_komunitas']),
			str_replace("'", "", $_POST['no_wa']),
			str_replace("'", "", $_POST['website']),
			str_replace("'", "", $_POST['instagram']),
			str_replace("'", "", $_POST['tiktok']),
			str_replace("'", "", $_POST['komisi']),
			$komunitascode,
			$_COOKIE['id_akun_combi'],
			$_POST['kategori_bisnis'],
			$menu,
			$verif,
			$_POST['harga'],
			$_POST['text']
		);
		$col=array('nama_komunitas','nowa','website','ig','tiktok','komisi_affiliate_join', 'code_komunitas', 'id_user', 'id_kategori_bisnis', 'member_show', 'verifikasi_post', 'harga', 'note');
		$sistem->masukan_data_no_redirect($tbl,$col,$data);

		// get komunitas baru dibuat
		$newKomunitas = $sistem->selectSingleOne($tbl, 'code_komunitas', $komunitascode);

		$sistem->masukan_data('data_affiliate', array('id_user', 'id_komunitas_bisnis'), array($_COOKIE['id_akun_combi'], $newKomunitas['id']));

	}

	if(isset($_POST['udpateBisnisKomunitas'])) {
		$menu = '0';
		$verif = '0';
		if (isset($_POST['menu'])) {
			$menu = '1';
		}
		if (isset($_POST['verifikasi'])) {
			$verif = '1';
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
			"harga ='".$_POST['harga']."'"
		);
		$sistem->rubah_data($tbl,$ubah,$data,$key);
	}

	switch (isset($_POST)) {
		case isset($_POST['submitEcourse']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="ecourse";
			$data=array(
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['kategori']),
				str_replace("'", "", $_POST['judul']),
				str_replace("'", "", $_POST['deskripsi']),
				str_replace("'", "", $_POST['id_komunitas_bisnis']),
				str_replace("'", "", $_POST['link'])
			);
			$col=array('id_user', 'id_kategori', 'judul', 'deskripsi', 'id_komunitas_bisnis', 'link');
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
				"harga = '".$_POST['harga']."'",
				"stok = '".$_POST['stok']."'",
				"dp = '".$_POST['dp']."'"
			);
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitProduk']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="produk";
			$data=array(
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['type']),
				str_replace("'", "", $_POST['nama_produk']),
				str_replace("'", "", $_POST['deskripsi']),
				str_replace("'", "", $_POST['harga']),
				str_replace("'", "", $_POST['stok']),
				str_replace("'", "", $_POST['id_komunitas_bisnis']),
				str_replace("'", "", $_POST['dp'])
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
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitAsset']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="asset";
			$data=array(
				str_replace("'", "", $_POST['judul']),
				str_replace("'", "", $_POST['id_komunitas_bisnis']),
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['deskripsi']),
				str_replace("'", "", $_POST['url']),
				str_replace("'", "", $_POST['dp']),
				str_replace("'", "", $_POST['type'])
			);
			$col=array('judul', 'id_komunitas_bisnis', 'id_user', 'deskripsi', 'url', 'dp', 'type');
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
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitEcourseKategori']):
			$sistem->redirect = $_POST['redirect'];
			$tbl="ecourse_kategori";
			$data=array(
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['nama_kategori']),
				str_replace("'", "", $_POST['id_komunitas_bisnis']),
			);
			$col=array('id_user','nama_kategori','id_komunitas_bisnis');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['updatePostDraf']) || isset($_POST['updatePost']):
			$sistem->redirect = $_POST['redirect'].'?id='.$_POST['id'];
			$status = 'publish';
			if (isset($_POST['updatePostDraf'])) {
				$status = 'draft';
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
			$sistem->redirect = $_POST['redirect'];
			$tbl="komentar";
			$data=array(
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['id_post']),
				''.$_POST['id_balas'].'xox'.$_POST['komentar'],
			);
			$col=array('id_user','id_post','komentar');
			$sistem->addCountPostComment($_POST['id_post']);
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case isset($_POST['submitPostDraf']) || isset($_POST['submitPost']):
			// echo var_dump($_POST);
			// die;
			$sistem->redirect = $_POST['redirect'];
			$tbl="post";
			$status = 'publish';
			if (isset($_POST['submitPostDraf'])) {
				$status = 'draft';
			}

			if ($status == 'publish' && $_POST['type_akun'] == 'admin') {
				// masuk ke notif komunitas
				$sistem->postNotifikasi( $_POST['id_user'], 0, 'post', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );
			}
			$data=array(
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['judul']),
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
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitFaq']):
			$sistem->redirect = $_POST['redirect'];
			// $id_user, $id_user_received, $type, $title, $text, $id_komunitas
			// update notifikasi
			$sistem->postNotifikasi( $_POST['id_user'], 0, 'faq', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

			$sistem->masukan_data('faq', array('id_user', 'id_komunitas_bisnis', 'title', 'text'), array($_POST['id_user'], $_POST['id_komunitas_bisnis'], $_POST['judul'], $_POST['text']));

			break;

		case isset($_POST['submitPapan']):
			$sistem->redirect = $_POST['redirect'];
			$sistem->postNotifikasi( $_POST['id_user'], 0, 'papan', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

			$sistem->masukan_data('papan_informasi', array('id_user', 'id_komunitas_bisnis', 'title', 'text'), array($_POST['id_user'], $_POST['id_komunitas_bisnis'], $_POST['judul'], $_POST['text']));
			break;

		case isset($_POST['submitAjukanKomisi']):
			$nilai = $_POST['komisi'] - $_POST['nilai'];
			$data=array(
				$_COOKIE['id_akun_combi'],
				$_POST['nilai'],
				$nilai, 
				0
			);
			$sistem->redirect = $_POST['redirect'];
			$col=array('id_user','saldo_ditarik','sisa_saldo','status');

			$sistem->eksekusi('update users set total_komisi='.$nilai);

			$sistem->masukan_data('pengajuan',$col,$data);
			break;
		
		case isset($_POST['submitDecPengajuan']) || isset($_POST['submitAccPengajuan']):
			$sistem->redirect = $_POST['redirect'].'?id=1';
			
			$tbl="pengajuan";
			if (isset($_POST['submitDecPengajuan'])) {
				$status = '3';
			}else{
				$status = '1';
			}

			$data=array("id");
			$key=array($_POST['id_pengajuan']);
			$ubah=array(
				"status ='".$status."'",
				"alasan ='".$_POST['note']."'"
			);
			$sistem->rubah_data($tbl,$ubah,$data,$key);
			break;

		case isset($_POST['submitOrderProduk']):

			// dapatkan data produk
			$produk = $sistem->selectSingleOne('affiliate_produk', 'id', $_POST['id_produk']);

			// buat harga
			$price = $produk['harga'] - rand(1,999);


			//get profile affiliate by kode affilaite
			$gaff = $sistem->single('users', $_POST['id_aff']);

			$clm = array('nama', 'nowa', 'email','alamat','domisili','kode_pos','jk','rentang_usia','catatan','id_komunitas_bisnis','id_aff', 'id_produk', 'komisi', 'harga');
			$data = array($_POST['nama'], $_POST['nowa'], $_POST['email'], $_POST['alamat'], $_POST['domisili'], $_POST['kode_pos'], $_POST['jk'], $_POST['rentang_usia'], $_POST['catatan'], $_POST['id_komunitas_bisnis'], $_POST['id_aff'], $_POST['id_produk'], $produk['komisi'], $price);
			// $sistem->debug = true;

			$sistem->lastId = true;

			// save & get user id baru beli ini
			$lastId = $sistem->masukan_data_no_redirect('order_produk', $clm, $data);

			// get data order baru
			$user = $sistem->single('order_produk', $lastId);
			// echo var_dump($lastId);
			// echo var_dump($user);
			// die;
			// jik aff dan pemilik produk tdk sama
			if ($produk['id_user'] != $_POST['id_aff']) {

				$sistem->eksekusi('UPDATE data_affiliate set total_pesanan_produk=total_pesanan_produk+1 WHERE id_komunitas_bisnis="'.$_POST['id_komunitas_bisnis'].'" and id_user='.$_POST['id_aff']);
			}

			$sistem->eksekusi('UPDATE data_affiliate set total_pesanan_produk=total_pesanan_produk+1 WHERE id_komunitas_bisnis="'.$_POST['id_komunitas_bisnis'].'" and id_user='.$produk['id_user']);
			// die;

			// cd adalah kode affilaite produk
			header('Location:'.$sistem->primaryLocal.'invoice?owner='.$produk['id_user'].'&cd='.$_POST['cd'].'&user='.$user['id'].'&type=produk');

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

			$komisi = $_POST['komisi'];
			
			$data=array(
				str_replace("'", "", $_POST['judul']),
				str_replace("'", "", $_POST['note']),
				str_replace("'", "", $harga),
				str_replace("'", "", $komisi),
				str_replace("'", "", $_POST['url']),
				str_replace("'", "", $_POST['type_produk']),
				str_replace("'", "", $_POST['id_komunitas_bisnis']),
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $fields),
				str_replace("'", "", $_POST['nilai']),
				rand(1,9999999)

			);
			$col=array('judul', 'note', 'harga', 'komisi', 'url', 'type', 'id_komunitas_bisnis', 'id_user', 'fields', 'nilai', 'kode_affiliate_produk');
			$sistem->masukan_data($tbl,$col,$data);
			break;

		case ($_POST['ajaxType'] == 'gabungKomunitas'):
			$url_components = parse_url($_POST['url']);
			parse_str($url_components['query'], $params);
			$cd = $params['cd'];
			$aff = $params['aff'];
			$id_komunitas = $sistem->eksekusiShow('select kb.id as idk, kb.harga as h, kb.nama_komunitas as nk, kb.id_user as idu from komunitas_bisnis as kb join norek as n on n.id_user = kb.id_user where kb.code_komunitas="'.$cd.'"');


			// cek jika sudah pernah join dan belum di approve/tf
			$text = '';
			$cekTf = $sistem->eksekusiShow('select * from komunitas where id_komunitas='.$id_komunitas['idk'].' and id_user='.$_POST['id_user'])['price_join'];

			if ( !empty($cekTf) ){
				// $text .= '<div class="alert alert-info">Anda sudah pernah </div>';
				$ownerPrice = $cekTf;
			}else{
				if (empty($id_komunitas)) {
					echo '<div class="alert alert-danger"><b>Opps</b> !, Link/URL Tidak Valid</div>';
					die;
				}else{
					$ownerPrice = $id_komunitas['h']-rand(1,999);
					$sistem->masukan_data_no_redirect('komunitas', array('id_user', 'id_komunitas', 'price_join'), array($_POST['id_user'], $id_komunitas['idk'], $ownerPrice));
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
				echo $text.'<a href="'.$sistem->noWa($wa).'" target="_blank">Hubungi Juga Admin Komunitas ('.$wa.')</a><hr></div> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bsi.png" width="50"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-jenius.png" width="40"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bni.jpeg" width="40"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-mandiri.png" width="40"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-cimb.png" width="60"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bri.png" width="20"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-bca.png" width="40"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-bank-ovo.png" width="40"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-gopay.png" width="40"> <img src="https://remotebisnis.com/wp-content/uploads/2021/10/logo-dana.png" width="40">'; 

			break;

		case ($_POST['ajaxType'] == 'checkEmail'):
			if ( !empty($sistem->selectSingleOne('users', 'email', '"'.$_POST['text'].'"')['id']) ){
				echo "Email sudah ada/terdaftar, silahkan gunakan email lain";
			}

			break;

		case ($_POST['ajaxType'] == 'ajaxLikePost'):
			$sistem->addCountPostLike($_POST['id_post']);
			$sistem->redirect = null;
			$tbl="`like`";
			$data=array(
				str_replace("'", "", $_POST['id_user']),
				str_replace("'", "", $_POST['id_post']),
			);
			$col=array('id_user','id_post');
			$sistem->masukan_data_no_redirect($tbl,$col,$data);
			break;

		case isset($_POST['submitDaftar']):
			$sistem->redirect = null;
			$tbl="users";

			$username = strtolower( substr( str_replace(' ','',$_POST['nama_lengkap']),0,10 ).rand(1,9999) );
			while (!empty( $sistem->eksekusiShow('select * from users where username="'.$username.'"')['id'] )) {
				$username = substr( str_replace(' ','',$_POST['nama_lengkap']),0,10 ).rand(1,999);
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
				str_replace("'", "", $_POST['nama_lengkap']),
				str_replace("'", "", $_POST['email']),
				str_replace("'", "", $_POST['domisili']),
				str_replace("'", "", $_POST['nowa']), '',
				$username, rand(100,999999), $_POST['nowa'], $aff, 0, $ownerPrice, 'user', 'cat.png'
			);

			$col=array('nama_lengkap','email','domisili','nowa','perangkat','username','kode_affiliate','password','affiliate', 'status', 'price_join', 'type_user', 'dp');
			$sistem->masukan_data_no_redirect($tbl,$col,$data);


			// tampil user terbaru yg baru daftar
			$user = $sistem->eksekusiShow('select * from users where email="'.$_POST['email'].'"')['id'];

			// tampil data komunitas by kode komunitas
			$id_komunitas = $sistem->eksekusiShow('select * from komunitas_bisnis where code_komunitas="'.$_POST['cd'].'"');

			// masuk ke data_affiliate
			$sistem->masukan_data_no_redirect('data_affiliate',array('id_user', 'id_komunitas_bisnis'),array($user, $id_komunitas['id']));


			// tambah user yg daftar ke komunitas dimana dia daftar
			$sistem->eksekusi('insert into komunitas (id_user, id_komunitas, price_join, id_affiliate) values ("'.$user.'", "'.$id_komunitas['id'].'", "'.$ownerPrice.'", "'.$aff.'")');
			
			// tambah + catat komisi, harga untuk affilaite (jika ada)
			if ($id_komunitas['id_user'] != $gaff['id']) {
				$col = array('id_user', 'id_affiliate', 'id_komunitas_bisnis', 'price_join', 'type', 'komisi');
				$data = array($user, $aff, $owner['idk'], $ownerPrice, 1, $owner['kaj']);
				$sistem->masukan_data_no_redirect('lead',$col,$data);

				$sistem->eksekusi('UPDATE data_affiliate set total_lead=total_lead+1 WHERE id_komunitas_bisnis="'.$id_komunitas['id'].'" and id_user='.$gaff['id']);

				$sistem->postNotifikasi( 0, $gaff['id'], 'aff_join', $_POST['nama_lengkap'], '<b>'.$_POST['nama_lengkap'].'</b> daftar komunitas lewat link affiliate Anda', $owner['idk'] );

				// $sistem->eksekusi('UPDATE data_affiliate set total_pendapatan=total_pendapatan+'.$ownerPrice.', total_lead=total_lead+1, komisi_lead=komisi_lead+'.$owner['kaj'].' WHERE id_komunitas_bisnis="'.$id_komunitas.'" and id_user='.$gaff['id']);
				// echo 'xUPDATE data_affiliate set total_pendapatan=total_pendapatan+'.$ownerPrice.', total_lead=total_lead+1, komisi_lead=komisi_lead+'.$owner['kaj'].' WHERE id_user='.$gaff['id'];
			}else{
				//masukan ke catatan menu lead
				$col = array('id_user', 'id_affiliate', 'id_komunitas_bisnis', 'price_join', 'type', 'komisi');
				$data = array($user, $owner['id'], $owner['idk'], $ownerPrice, 1, $owner['kaj']);
				$sistem->masukan_data_no_redirect('lead',$col,$data);
				
				// $sistem->eksekusi('UPDATE data_affiliate set total_pendapatan=total_pendapatan+'.$ownerPrice.', total_lead=total_lead+1, komisi_lead=komisi_lead+'.$owner['kaj'].' WHERE id_komunitas_bisnis="'.$id_komunitas.'" and id_user='.$owner['id']);
				
				// tambah + catat komisi, harga untuk owner bisnis
				// echo '<br>UPDATE data_affiliate set total_pendapatan=total_pendapatan+'.$ownerPrice.', total_lead=total_lead+1, komisi_lead=komisi_lead+'.$owner['kaj'].' WHERE id_user='.$owner['id'];
			}
			$sistem->postNotifikasi( 0, $owner['id'], 'aff_join', $_POST['nama_lengkap'], '<b>'.$_POST['nama_lengkap'].'</b> mendaftar komunitas ', $owner['idk'] );

			$sistem->eksekusi('UPDATE data_affiliate set total_lead=total_lead+1 WHERE id_komunitas_bisnis="'.$id_komunitas['id'].'" and id_user='.$owner['id']);
			// buat cek logika, jika ada aff maka update data affiliate owner dan aff,
			// jika aff tdk ada cukup update data affilaite owner aja
			// jika aff nya diirnya sendiri cukup update aja

			// redirek
			header('Location:'.$sistem->primaryLocal.'invoice?owner='.$owner['id'].'&cd='.$_POST['cd'].'&user='.$user);
			break;

		case isset($_POST['submitNoRek']):
			$sistem->redirect = $_POST['redirect'].'?b=s';
			$sistem->tbl = 'norek';
			$sistem->clm = 'id_user';
			$sistem->hapus_satu_data($_POST['id_user']);

			for ($i=0; $i < count($_POST['nomor']); $i++) { 
				$data=array(
					str_replace("'", "", $_POST['id_user']),
					str_replace("'", "", $_POST['kode'][$i]),
					str_replace("'", "", $_POST['nama'][$i]),
					str_replace("'", "", $_POST['nomor'][$i]),
					str_replace("'", "", $_POST['pemilik'][$i]),
				);
				$col=array('id_user', 'kode_bank', 'nama_bank', 'norek', 'nama_pemilik');
				$sistem->masukan_data_no_redirect('norek',$col,$data);
			}

			$tbl="users";
			$data=array("id");
			$key=array($_POST['id_user']);
			$ubah=array(
				"note_after_invoice ='".$_POST['note']."'"
			);
			$sistem->rubah_data($tbl,$ubah,$data,$key);

			// header('Location://'.);
			break;
	}