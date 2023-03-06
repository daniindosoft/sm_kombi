<?php
// error_reporting(0);

date_default_timezone_set('Asia/Jakarta');

class kontrols{ 
	public $primaryUrl = primaryUrl;
	public $primaryLocal = primaryLocal;
	public $redirect = redirect;
	public $https = https;
	public $debug = false;
	public $limit = 10;
	public $markAllNotif = false;
	public $disableRedirect = false;
	public $debugSql = false;
	public $isAdminDelay = false;
	public $isProduk = false;
	public $flashMessage = '';
	public $flashType = '';
	public $ago = false;
	public $status = 3;
	public $downloadReport = false;
	public $lastId = false;
	public $Host = Host;
	public $SMTPAuth = SMTPAuth;
	public $Password = Password;
	public $SMTPSecure = SMTPSecure;
	public $Port = Port;

	public $pricePublic = 0;
	public $priceEmail = '';
	public $priceNama = '';

	public $mark = '<i class="f-xm float-right text-warning fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Bagian/fitur ini tidak dipengaruhi oleh komunitas yang dipilih di navbar"></i>';

	public $timezone = 'SET time_zone = "+07:00"; SET @@session.time_zone = "+07:00";';

	public function __construct($db){

		$this->kon=$db;
		$user = self::thisProfile($_COOKIE['id_akun_combi']);
		if( empty($user['id']) ){
			self::removeCookies();
		}

		if (new DateTime() > new DateTime($user['expire']) && $user['type_user'] == 'admin') {
	        header("Location: ".$this->primaryLocal."expire.php");
		}

	}
	public function registerFlash($type, $message){
		$_SESSION['flashType'] = $type;
		$_SESSION['flashMessage'] = $message;
	}
	public function callFlash($type = null){
		if ($_SESSION['flashType'] == 'w') {
			$alert = 'alert-warning';
			$icon = '<i class="icon ion-information"></i>';
		}elseif ($_SESSION['flashType'] == 'd') {
			$alert = 'alert-danger';
			$icon = '<i class="icon ion-android-warning"></i>';
		}elseif ($_SESSION['flashType'] == 'i') {
			$alert = 'alert-info';
			$icon = '<i class="icon ion-information"></i>';
		}elseif ($_SESSION['flashType'] == 's') {
			$alert = 'alert-success';
			$icon = '<i class="icon fas fa-check"></i>';
		}
		if (!empty($_SESSION['flashType'])) {
			echo '<div class="mt-3 alert text-sm '.$alert.' ">
	              <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="return closeFlash()">×</button>
	              <label>'.$icon.' '.$_SESSION['flashMessage'].'</label>
	            </div>';
		}
	}
	public function removeFlash(){
		unset($_SESSION['flashType']);
		unset($_SESSION['flashMessage']);
	}
	public function removeSession(){
		session_start();
		session_destroy();
	}
	public function removeCookies(){
		setcookie('id_akun_combi', '', 0, '/');
	    setcookie('username_akun_combi', '', 0, '/');
	    session_destroy();
	}
	public function userDenied($id){
	    $request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	    // echo $request .' - '. $this->primaryUrl.'/admin/post';
	    if (self::thisProfile($id)['type_user'] == 'user' && $request != '/'.$this->primaryUrl.'/admin/post' && $request != '/'.$this->primaryUrl.'/view/user' && $request != '/'.$this->primaryUrl.'/admin/post/edit') {
	        header("Location: ".$this->primaryLocal."user/home");
	    }
	}
	public function option(){
		return self::eksekusiShow('select * from mcdani where id = 1');
	}

	public function adminDenied($id){
	    $request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	    if (self::thisProfile($id)['type_user'] == 'admin') {
	        header("Location: ".$this->primaryLocal."admin/home");
	    }
	}

	public function getKomunitasDefault($id, $user = null){
		$tbl = 'komunitas_bisnis';
		$stt = '';
		if ($user == 'user') {
			$tbl = 'komunitas';
			$stt = 'and status=1 ';
		}
		$getKomunitasDefault = self::eksekusiShow('select * from '.$tbl.' where id_user = '.$id.' '.$stt.' limit 1');
		if ($user == 'user') {
			$_SESSION['bisnis_kategori_combi'] = $getKomunitasDefault['id_komunitas'];
		}else{
			$_SESSION['bisnis_kategori_combi'] = $getKomunitasDefault['id'];
		}
	}
 	function masuk($email, $password){

	    // Prepare and execute query
	    $stmt = $this->kon->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
	    $stmt->bindParam(':email', self::removeSpecialChar($email));
	    $stmt->bindParam(':password', self::removeSpecialChar($password));
	    $stmt->execute();

	    $user = $stmt->fetch(PDO::FETCH_ASSOC);

	    if($user && $user['status'] == 1) {

	    	setcookie('id_akun_combi',$user['id'], time() + (86400 * 30),"/");
	    	setcookie('username_akun_combi',$user['username'], time() + (86400 * 30),"/");

	    	setcookie('id_akun',rand(1,99999), time() + (86400 * 30),"/");
	    	setcookie('id_combi_akun',rand(1,99999), time() + (86400 * 30),"/");
	    	setcookie('username_id',rand(1,99999), time() + (86400 * 30),"/");
	    	setcookie('name_id',rand(1,99999), time() + (86400 * 30),"/");
	    	setcookie('loginid',rand(1,99999), time() + (86400 * 30),"/");
	    	setcookie('combi',rand(1,99999), time() + (86400 * 30),"/");
	    	setcookie('id_login',rand(1,99999), time() + (86400 * 30),"/");
	        if ($user['type_user'] == 'admin') {
	        	self::getKomunitasDefault($user['id']);
	        	
		        header("Location: ".$this->primaryLocal."admin/home");
	        }else{
	        	self::getKomunitasDefault($user['id'],'user');
		        header("Location: ".$this->primaryLocal."user/home");
	        }
	       	// echo 'ok';
	    } else {
	        self::registerFlash('d', '<small>Maaf, username/email atau password salah, atau mungkin akun Anda belum aktif</small>');
	        // header("Location: ".$this->primaryLocal."");
	        self::callFlash();

	    }
		 
 	}
 	function masukByCookie($id){

	    // Prepare and execute query
	    $stmt = $this->kon->prepare("SELECT * FROM users WHERE id = :id");
	    $stmt->bindParam(':id', $id);
	    $stmt->execute();

	    $user = $stmt->fetch(PDO::FETCH_ASSOC);
	    if (empty($_SESSION['bisnis_kategori_combi'])) {
		    self::getKomunitasDefault($user['id']);
	    }

	    if($user) {
	        if ($user['type_user'] == 'admin') {
		        header("Location: ".$this->primaryLocal."admin/home");
	        }else{
		        header("Location: ".$this->primaryLocal."user/home");
	        }
	       	// echo 'ok';
	    }
		 
 	}
 	public function accKomisi($id, $status){
		$dataPengajuan = self::selectSingleOne('manage_komisi', 'id', $id);
		$op = '-';
		$ops = 'Pengurangan';
		if ($dataPengajuan['operator'] == '+') {
			$op = '+';
			$ops = 'Penambahan';
		}

		self::eksekusi('UPDATE data_affiliate SET komisi_belum_cair=komisi_belum_cair'.$op.''.$dataPengajuan['nilai'].' where id_user='.$dataPengajuan['id_user'].' and id_komunitas_bisnis='.$dataPengajuan['id_komunitas_bisnis']);
		
		$komunitas = self::selectSingleOne('komunitas_bisnis', 'id', $dataPengajuan['id_komunitas_bisnis']);
		$user = self::thisProfile($dataPengajuan['id_user']);

		if ($status == 3) {
			// notif ke admin di acc
			$stt = 'Selamat !, Saldo berhasil ditambahkan';
			$title = $dataPengajuan['operator'].self::nf($dataPengajuan['nilai']).' Disetujui';
			self::postNotifikasi( $_COOKIE['id_akun_combi'], $komunitas['id_user'], 'acc_komisi', $title, '<b>'.$user['nama_lengkap'].'</b> telah MENYETUJUI '.$ops.' komisi/saldo dari Anda.', $dataPengajuan['id_komunitas_bisnis'] );

		}else{
			$title = $dataPengajuan['operator'].self::nf($dataPengajuan['nilai']).' Titolak';
			$stt = 'Proses Penolakan berhasil !, mohon hubungi admin untuk infokan pada Admin';
			self::postNotifikasi( $_COOKIE['id_akun_combi'], $komunitas['id_user'], 'acc_komisi', $title, '<b>'.$user['nama_lengkap'].'</b> telah MENOLAK '.$ops.' komisi/saldo dari Anda.', $dataPengajuan['id_komunitas_bisnis'] );
			// notif ke admn jika di tolak

		}

		self::eksekusi('update manage_komisi set status='.$status.' where id='.$id);
		self::registerFlash('s', '');
		header('Location: '.$this->https.$this->primaryLocal.'user/bisnis/penarikan');
 	}
 	public function toInt($int){
 		return preg_replace('/[^0-9]/', '', $int);
 	}
 	public function verifDataOwnedByComunity($tbl, $clm, $id, $type = 'single'){
 		if ($type == 'single') {
			$cek = self::eksekusiShow('select * from '.$tbl.' where '.$clm.' = "'.self::removeSpecialChar($id).'"' );
			echo 'select * from '.$tbl.' where '.$clm.' = "'.self::removeSpecialChar($id).'"' ;
			if (empty($cek['id']) || $cek['id_komunitas_bisnis'] != $_SESSION['bisnis_kategori_combi']) {
				echo "<script>window.location.href = '".$this->primaryLocal.'e404'."'; </script>";
			}
 		}
 	}
 	public function verifDataOwned($tbl, $clm, $id, $type = 'single'){
 		if ($type == 'single') {
			$cek = self::eksekusiShow('select * from '.$tbl.' where '.$clm.' = "'.self::removeSpecialChar($id).'"' );
			if (empty($cek['id']) || ($cek['id_user'] || $cek['id_aff']) != $_COOKIE['id_akun_combi']) {
				echo "<script>window.location.href = '".$this->primaryLocal.'e404'."'; </script>";
			}
 		}
 	}
	function dp($dp){
		return $this->primaryLocal."dist/img/avatar/".$dp;
	}
	function thisProfile($id){
		// echo 'select * from users where id='.$id;
		return self::eksekusiShow('select * from users where id='.$id);
	}
	public function countOrderDropRes($id, $id_komunitas){
		return self::eksekusiShow('select * from data_dropship where id_user='.$id.' and id_komunitas_bisnis='.$id_komunitas);
	}
	public function countUserPosts($id, $id_komunitas){

		$jmlPost = self::eksekusiShow('select count(id) as total from post where id_komunitas_bisnis='.$id_komunitas.' and id_user='.$id.' and status= "publish"')['total'];
		return $jmlPost;

	}
	public function getPosts($id, $bisnis, $status = 'publish', $order = 'asc', $limit){
		// echo 'select * from post where id_user="'.$id.'" and id_komunitas_bisnis='.$bisnis.' and status="'.$status.'" order by id '.$order.' limit '.$limit;
		
		$iduser = 'id_user="'.$id.'" and';
		

		if ($status == 'delay' && $this->isAdminDelay == true) {
			$iduser = '';
		}
		// $this->debug = true;
		return self::tampil_manual('select * from post where '.$iduser.' id_komunitas_bisnis='.$bisnis.' and status="'.$status.'" order by id '.$order.' limit '.$this->halaman_awal.', '.$this->batas);
	}
	public function getKomentarByPost($value, $limit=10){
		return self::tampil_manual('select u.type_user, k.id_user,u.nama_lengkap, k.created_at, k.komentar, k.id from komentar as k join users as u on k.id_user = u.id where k.id_post="'.$value.'" order by id desc limit '.$limit);
	}
	public function convertDate($string, $date){
		$date = new DateTime($date);
	    return $date->format($string);
	}
	function getNamaLengkap($id){
		$sql=(" select * from users where id='$id'");

		$masuk=$this->kon->prepare($sql);

		$masuk->execute();

		$mulai=$masuk->fetchAll();

		foreach ($mulai as $value => $h) {
			return $h['nama_lengkap'];
		}
	}

	function tampil_relasi_where_manual($tbl,$clm,$key,$where){

		$dataA=null;

		for ($i=0; $i <count($clm); $i++) { 

			$dataA=$dataA.''.$clm[$i].',';

		}

		$listCut=substr($dataA,0,strlen($dataA)-1);



		$dataB=null;

		for ($i=0; $i <count($key); $i++) { 

			$dataB=$dataB.''.$key[$i].',';

		}

		$listCutKey=substr($dataB,0,strlen($dataB)-1);



		$dataC=null;

		for ($i=0; $i <count($tbl); $i++) { 

			$dataC=$dataC.''.$tbl[$i].',';

		}

		$listCutTbl=substr($dataC,0,strlen($dataC)-1);





		$sql=(" select ".$listCut." from ".$listCutTbl." where ".$listCutKey." ".$where);

		$masuk=$this->kon->prepare($sql);

		$masuk->execute();

		$mulai=$masuk->fetchAll();

		return $mulai;

		// echo $sql;

	}

	function singleUser($id){
		return self::eksekusiShow('select * from users where id = '.self::removeSpecialChar($id));
	}

	function dateDiffInDays($date1, $date2) {
      $diff = strtotime($date2) - strtotime($date1);
  
      // 1 day = 24 hours
      // 24 * 60 * 60 = 86400 seconds
      return abs(round($diff / 86400));
  	}

	function time_elapsed_string($datetime, $full = false) {
		if( self::dateDiffInDays($datetime, date('Y-m-d')) > 6 ){
			return self::convertDate('d F Y H:i', $datetime);
		}

	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'Tahun',
	        'm' => 'Bulan',
	        'w' => 'Minggu',
	        'd' => 'Hari',
	        'h' => 'Jam',
	        'i' => 'Menit',
	        's' => 'Detik',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? ' ' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    if ($this->ago == true) {
		    return $string ? implode(', ', $string) . ' lagi' : '';
	    }else{
		    return $string ? implode(', ', $string) . ' yang lalu' : 'Baru saja';
	    }
	}
 

	function approveProdukAff($id, $id_komunitas, $url, $price, $komisi, $aff, $status){
		// update produk jadi setuju/tolak
		self::eksekusi('update order_produk set status = '.$status.' where id='.self::removeSpecialChar($id));
		// get produk data yg di order
		$produk = self::selectSingleOne('order_produk', 'id', $id);

		// get produk
		$detailProduk = self::selectSingleOne('affiliate_produk', 'id', $produk['id_produk']);

		// update data affiliate -> produk, update total saldo
		if ($status == 3) {
			// buat filter jika aff sama dengan pemilik komunitas, nanti malah dobel
			$cekUser = self::selectSingleOne('komunitas_bisnis', 'id', $id_komunitas);
			// echo $aff.' '.$cekUser['id_user'];die;
			if ($aff != $cekUser['id_user']) {
				// code...
				self::postNotifikasi( $_COOKIE['id_akun_combi'], $aff, 'new_prod', 'Pesanan di Proses', ' Pesanan A.N <b>'.$produk['nama'].'</b> ('.$cekUser['nama_komunitas'].') Telah di proses, komisi <b>Rp'.self::nf($komisi).'</b> telah ditambahkan', $id_komunitas );

				self::eksekusi('UPDATE data_affiliate SET total_pendapatan_produk=total_pendapatan_produk+'.$price.', komisi_pesanan_produk=komisi_pesanan_produk+'.$komisi.', komisi_belum_cair=komisi_belum_cair+'.$komisi.' where id_user='.$aff.' and id_komunitas_bisnis='.$id_komunitas);
			}

			
			self::eksekusi('UPDATE data_affiliate SET total_pendapatan_produk=total_pendapatan_produk+'.$price.', komisi_pesanan_produk=komisi_pesanan_produk+'.$komisi.', komisi_belum_cair=komisi_belum_cair+'.$komisi.' where id_user='.$_COOKIE['id_akun_combi'].' and id_komunitas_bisnis='.$id_komunitas);

			self::registerFlash('i', 'Pesanan telah di proses');
			
			// if ( ($produk['harga'] == 0 || $detailProduk['nilai'] == 'gratis') && empty($detailProduk['url'])) {
			if ( empty($detailProduk['url'])) {
				$konten = '
					<h3>Pesanan Segera Dikirim/Proses</h3>
					<p> Pesanan Anda '.$detailProduk['judul'].' segera di proses/dikirim, pastikan E-Mail dan nomor telepon/Whatsapp akitf dan cek secara berkala ya. </p>
				';
			    $judul = 'Pesanan '.$detailProduk['judul'].' Segera Dikirim/Diproses';
			}else{
				$konten = '
					<h3>Pesanan telah diproses/dikirim</h3>
					<p>Pesanan Anda '.$detailProduk['judul'].' telah di proses/dikirim, silahkan klik untuk mengunduh/melihat produk di link berikut : </p>
					<p>
					    <a href="'.$detailProduk['url'].'"style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Klik disini</a>

					</p>
					<p>
						Terima kasih.
					</p>
				';
			    $judul = 'Pesanan '.$detailProduk['judul'].' Telah Dikirim/Diproses';
			}
		    self::kirimEmail($produk['nama'],'kombi@remotebisnis.com','Kombi RemoteBisnis',$produk['email'], $judul , $konten);

			// krim email when approve
				// if harga & 0 / gratis & url kosong , email isinya = thx, pesanan segara di proses mohon tunggu ya 
				// if berbyar & harga > 0 & url = null : thx terima kasih, admin segera kirim produknya pastikan email dan kntak aktif ya
				// if berbyar & harga > 0 & url = ada : thx terima kasih telah order, silahkan klik ini untuk melihat/mengunduh csv
			
		}else{
			self::registerFlash('d', 'Pesanan telah anda tolak');
		}
		header('Location:'.$this->https.$url.'?info=berhasil');

	}
	function single($tbl, $id){
		$sql = 'select * from '.$tbl.' where id = '.self::removeSpecialChar($id);
		if ($this->debug == true) {
			return $sql;
		}
		return self::eksekusiShow($sql);
	}
	function updateJoinUserToCommunity($id_user, $id_komunitas, $price, $komisi, $aff, $owner, $url = false){
		$tbl="users";
		$data=array("id");
		$key=array($id_user);
		$ubah=array(
			"status =1"
		);

		$user = self::single('users', $id_user);
		self::rubah_data($tbl,$ubah,$data,$key);
		
		self::rubah_data('komunitas',$ubah,array('id_user', 'id_komunitas'), array($id_user, $id_komunitas));

		$komunitas = self::selectSingleOne('komunitas_bisnis', 'id', $id_komunitas);

		if ($_COOKIE['id_akun_combi'] != $aff) {
			self::postNotifikasi( $_COOKIE['id_akun_combi'], $aff, 'aff_app', $user['nama_lengkap'], '<b>'.$user['nama_lengkap'].'</b> Telah di Approve oleh Admin, selamat komisi <b>Rp'.self::nf($komisi).'</b> telah ditambahkan', $id_komunitas );

			self::eksekusi('UPDATE data_affiliate set total_pendapatan=total_pendapatan+'.$price.', komisi_lead=komisi_lead+'.$komisi.', komisi_belum_cair=komisi_belum_cair+'.$komisi.' WHERE id_komunitas_bisnis="'.$id_komunitas.'" and id_user='.$aff);
		}
		// notif untuk useritu sendiri
		self::postNotifikasi( $_COOKIE['id_akun_combi'], $id_user, 'aff_app', 'Hallo !!', 'Anda kini member <b>'.$komunitas['nama_komunitas'].'</b>, Selamat bergabung ya !', $id_komunitas );

		self::eksekusi('UPDATE data_affiliate set total_pendapatan=total_pendapatan+'.$price.', komisi_lead=komisi_lead+'.$komisi.', komisi_belum_cair=komisi_belum_cair+'.$komisi.' WHERE id_komunitas_bisnis="'.$id_komunitas.'" and id_user='.$owner);
		self::registerFlash('s', $user['nama_lengkap'].' telah di Approve dan telah menjadi member komunitas Anda');

		// notif email ke member aff itu
		$konten = '
			<h3>Selamat Bergabung</h3>
			<p>Anda kini sudah tergabung dengan komunitas '.$komunitas['nama_komunitas'].', dan berikut aksesnya : </p>
			<h4>Email = '.$user['email'].'</h4>
			<h4>Password = '.$user['password'].'</h4>
		    <b>Silahkan Login ke https://kombi.remotebisnis.com atau</b><br>
		    <a href="'.$this->primaryLocal.'"style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Klik disini</a>

		';
	    self::kirimEmail('','kombi@remotebisnis.com','Kombi RemoteBisnis',$user['email'],'Selamat, Akun Anda Telah di Verifikasi', $konten);
		
		
		if ($url != false) {
			header('Location:'.$this->primaryLocal.'admin/bisnis/affiliate?info=berhasil');
		}

	}
	public function orderAffiliateByDate($id, $id_bisnis, $type, $date, $price = 'p'){
		if ($price == 'p') {
			$priceText = 'sum(price_join)';
		}else{
			$priceText = 'count(price_join)';
		}
		$byid = "id_affiliate=".$id." and";
		if ($id == false) {
			$byid = "";
		}
		return self::eksekusiShow("select ".$priceText." as total from lead where ".$byid." id_komunitas_bisnis=".$id_bisnis." and type=".$type." and created_at like '%".$date."%'");
	}
 
	function profitToday($bisnis, $date){
		// return "select sum(k.price_join) as total from users as u join komunitas as k on k.id_user = u.id where k.status = 0 and k.id_komunitas=".$bisnis." and created_at like '%".$date."%'";
		return self::eksekusiShow("
				select sum(k.price_join) as total from users as u join komunitas as k on k.id_user = u.id where k.status = 1 and k.id_komunitas=".$bisnis." and created_at like '%".$date."%'
			");
	}
	function nf($n){
		return number_format($n,0,',','.');
	}
	public function registerGeneratePaginate($batas, $halaman_p, $total){
		$this->batas = $batas;
		$this->halaman = (isset($halaman_p)) ? (int)$halaman_p : 1;
		$this->halaman_awal = ($this->halaman>1) ? ($this->halaman * $batas) - $batas : 0;  

		$this->previous = $this->halaman - 1;
		$this->next = $this->halaman + 1;

		$this->jumlah_data = $total;
		$this->total_halaman = ceil($this->jumlah_data / $batas);
	}
	public function generatePaginate(){

		$halaman = '';
		$dataHalaman = '';
		// if ($this->total_halaman < 0) {
			
			$stopNumber = 0;
			for($x=$this->halaman;$x<=$this->total_halaman;$x++){
				$stopNumber++;
				if ($stopNumber <= 7) {
					$active2 = '';
					if($x == $this->halaman && !empty($this->halaman)){
						$active2 = 'active';
					}
					$active = '';
					if($x == 1 && empty($this->halaman)) {
						$active = 'active';
					}
					$dataHalaman .= '<li class="page-item '.$active.' '.$active2.'"><a class="page-link" href="?'.$_SERVER["QUERY_STRING"].'&halaman='.$x.'">'.$x.'</a></li>';
				}
			}
			if($this->halaman > 1){ $halaman = "href='?".$_SERVER["QUERY_STRING"]."&halaman=".$this->previous."'"; }

			if($this->halaman < $this->total_halaman) { $next = "href='?".$_SERVER["QUERY_STRING"]."&halaman=".$this->next."'"; }
			if ($this->halaman != $this->total_halaman){
		        $centerPage = '<li class="page-item"><a href="#ss" class="page-link">...</a></li>';
			}

			$endPage = '';
			if ($this->halaman != $this->total_halaman) {
				$endPage = '<li class="page-item">
	                    <a  class="page-link" '.$next.'>Next</a>
	                  </li>
	                  <li class="page-item">
	                    <a class="page-link" href="?'.$_SERVER["QUERY_STRING"].'&halaman='.$this->total_halaman.'">></a>
	                  </li>';
			}

			echo '
				<nav aria-label="Page navigation example">
	                <ul class="pagination justify-content-center">
	                  <li class="page-item">
	                    <a class="page-link" href="?'.$_SERVER["QUERY_STRING"].'&halaman=1"><</a>
	                  </li>
	                  <li class="page-item">
	                    <a class="page-link" '.$halaman.'>Previous</a>
	                  </li>
	                  '.$dataHalaman.' '. $centerPage.$endPage.'
	                </ul>
	              </nav>

			';
		// }

	}
	function getSpesificLead($field, $id, $bisnis){
		return self::eksekusiShow('select '.$field.' from lead where id_user='.$id.' and id_komunitas_bisnis='.$bisnis);
	}
	function showDataLead($bisnis, $order = 'desc'){
		
		// return self::tampil_manual("select *, l.price_join as price, u.id as idu from lead as l join users as u on u.id = l.id_user where l.id_komunitas_bisnis=".$bisnis." order by u.tgl_daftar ".$order);

		return self::tampil_manual("select *,k.price_join as price, u.id as idu, k.id_affiliate from users as u join komunitas as k on k.id_user = u.id where k.status = 0 and k.id_komunitas=".$bisnis." order by k.created_at ".$order." limit 10");

	}
	function showDataLeadUser($bisnis, $aff, $order = 'desc'){
		
		// return self::tampil_manual("select *, l.price_join as price, u.id as idu from lead as l join users as u on u.id = l.id_user where l.id_komunitas_bisnis=".$bisnis." order by u.tgl_daftar ".$order);

		return self::tampil_manual("select *,k.price_join as price, u.id as idu, k.id_affiliate from users as u join komunitas as k on k.id_user = u.id where k.id_affiliate=".$aff." and k.status = 0 and k.id_komunitas=".$bisnis." order by k.created_at ".$order." limit 10");

	}	
	function showAffiliateDataLeadCr($id_user, $bisnis, $date, $clm){
		$sql = "SELECT ".$clm." FROM komunitas WHERE id_komunitas=".$bisnis." and id_affiliate=".$id_user." and status=1 and created_at like '%".$date."%' ";
		return self::eksekusiShow($sql);
	}
	function showDataLeadCr($bisnis, $date){
		
		// return self::tampil_manual("select *, l.price_join as price, u.id as idu from lead as l join users as u on u.id = l.id_user where l.id_komunitas_bisnis=".$bisnis." order by u.tgl_daftar ".$order);
		// return "select count(*) as total from users as u join komunitas as k on k.id_user = u.id where k.status = 1 and k.id_komunitas=".$bisnis." and created_at like '%".$date."%'";
		return self::eksekusiShow("select count(*) as total from users as u join komunitas as k on k.id_user = u.id where k.status = 1 and k.id_komunitas=".$bisnis." and created_at like '%".$date."%'");

	}
	function noWa($n){
		return 'https://wa.me/62'.substr($n, 1);
	}
	public function kickUser($id){
		// echo 'update komunitas set status=0 where id='.$id; die;
		self::registerFlash('i', 'Anda berhasil mengeluarkan member itu !');
		return self::eksekusi('update komunitas set status=0 where id='.$id);
	}
	public function ownerComunity($id_komunitas){
		return self::eksekusiShow('select *, u.id as idu from komunitas_bisnis as k join users as u on k.id_user = u.id where k.id='.$id_komunitas);
	}
	public function singleComunity($id_user, $id_komunitas){
		return self::eksekusiShow('select * from komunitas where id_user='.self::removeSpecialChar($id_user).' and id_komunitas='.self::removeSpecialChar($id_komunitas));
	}
	public function countAtc($id_user, $id_komunitas){
		return self::eksekusiShow('select count(id) as total from cart where id_user='.$id_user.' and id_komunitas_bisnis='.$id_komunitas);
	}
	public function actionProduk($id, $type){
		self::eksekusi('update pesanan set status='.$type.' where id='.$id);

		$order = self::selectSingleOne('pesanan', 'id', $id);
		
		$komunitas = self::selectSingleOne('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);

		// $this->debug = true;
		if ($type == 2) {
			// tolak
			self::postNotifikasi( $_COOKIE['id_akun_combi'], $order['id_user'], 'dsre_dec', 'Pesanan Ditolak', 'Pesanan dengan <b>no invoice #'.$order['invoice'].'</b> dari komunitas <b>'.$komunitas['nama_komunitas'].'</b> ditolak !', $_SESSION['bisnis_kategori_combi'] );
			self::registerFlash('d', 'Pesanan berhasil di Anda tolak !');
		}elseif($type == 3){
			// update data aff admin
			$totalOrder = self::eksekusiShow('select sum(harga*qty) as total from pesanan_line where id_pesanan="'.$order['id'].'"')['total'];

			$ubah = array('total_lead=total_lead+1', 'total_omset=total_omset+'.$totalOrder);
			// $this->debug = true;
			$dataDs = self::rubah_data('data_dropship', $ubah, array('id_user', 'id_komunitas_bisnis'), array($_COOKIE['id_akun_combi'], $_SESSION['bisnis_kategori_combi']));

			$dataDs = self::rubah_data('data_dropship', $ubah, array('id_user', 'id_komunitas_bisnis'), array($order['id_user'], $_SESSION['bisnis_kategori_combi']));

			self::postNotifikasi( $_COOKIE['id_akun_combi'], $order['id_user'], 'dsre_acc', 'Pesanan Disetujui/diproses', 'Pesanan dengan <b>no invoice #'.$order['invoice'].'</b> di komunitas <b>'.$komunitas['nama_komunitas'].'</b> telah di proses oleh Admin, cek berkala untuk update RESI nya', $_SESSION['bisnis_kategori_combi'] );

			self::registerFlash('s', 'Pesanan berhasil di proses !');
		}

		
	}
	public function selectPleksible($tbl, $clm, $id, $where = ''){
		if ($this->debug == true) {
			echo 'select * from '.$tbl.' where '.$clm.'='.$id;
			die;
		}
		return self::tampil_manual('select * from '.$tbl.' where '.$clm.'='.self::removeSpecialChar($id).' '.$where);
	}
	public function select($tbl, $id){
		// echo 'select * from '.$tbl.' where id_user='.$id;die;
		return self::tampil_manual('select * from '.$tbl.' where id_user='.$id);
	}
	public function getDataAffiliate($id_user, $id_komunitas, $tbl = 'data_affiliate'){
		$cekUser = self::thisProfile($_COOKIE['id_akun_combi']);
		$last = '';
		if ($cekUser['type_user'] == 'user' || $this->isProduk == true) {
			$last = ' and id_user='.$id_user.' ';
		}

		return self::eksekusiShow('select * from '.$tbl.' where id_komunitas_bisnis='.$id_komunitas.' '.$last);
	}
	public function cal_percentage($num_amount, $num_total) {
	  $count1 = $num_amount / $num_total;
	  $count2 = $count1 * 100;
	  $count = number_format($count2, 0);
	  return $count;
	}
	public function getDataAffiliateAdmin($id_user, $id_komunitas, $tbl = 'data_affiliate'){
		
		return self::eksekusiShow('select * from '.$tbl.' where id_komunitas_bisnis='.$id_komunitas.' and id_user='.$id_user);
	}
	public function selectSingleOne($tbl, $clm, $id){
		$sql = 'select * from '.$tbl.' where '.$clm.'='.self::removeSpecialChar($id);
		if ($this->debug == true) {
			echo $sql; die;
		}
		return self::eksekusiShow($sql);
	}
	public function singleByUserByCommunity($tbl, $id_user, $id_komunitas, $type, $where = ''){
		$cekUser = self::thisProfile($_COOKIE['id_akun_combi']);
		if ($type != 'single') {
			$last = '';
			if ($cekUser['type_user'] == 'user') {
				$last = ' and id_user='.$id_user.' ';
			}
			return self::tampil_manual('select * from '.$tbl.' where id_komunitas_bisnis='.$id_komunitas.' '.$last.' '.$where);
		}else{
			$last = '';
			if ($cekUser['type_user'] == 'user') {
				$last = ' and id_user='.$_COOKIE['id_akun_combi'].' ';
			}
			return self::eksekusiShow('select count(*) as total from pesanan where id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' '.$last.' '.$where);
		}
	}
	public function getPackagePrice($id, $type = 'harga')
	{
		$x = self::eksekusiShow('select * from mcdani');
		if ($id == 1) {
			$harga = $x['harga_paket1'];
			$bulanan = $x['bulanan_paket1'];
		}elseif ($id == 2) {
			$harga = $x['harga_paket2'];
			$bulanan = $x['bulanan_paket2'];
		}elseif ($id == 3) {
			$harga = $x['harga_paket3'];
			$bulanan = $x['bulanan_paket3'];
		}
		if ($type == 'harga') {
			return $harga;
		}else{
			return $bulanan;
		}
	}
	public function kuotaPackage($id){
		$x = self::eksekusiShow('select * from mcdani');
		$profile = self::thisProfile($id);
		if ($profile['last_package_picked'] == 1) {
			$paket = $x['kuota_paket1'];
		}elseif ($profile['last_package_picked'] == 2) {
			$paket = $x['kuota_paket2'];
		}elseif ($profile['last_package_picked'] == 3) {
			$paket = $x['kuota_paket3'];
		}

		// cek if paket 3 infinity
		if ($paket > 9999 ) {
			$paket = '∞';
		}

		return $paket;
	}
	public function getRandStr($n) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
		    $index = rand(0, strlen($characters) - 1);
		    $randomString .= $characters[$index];
		}

		return $randomString;
	}
	public function totalComunityOwnedByAdmin($id){
		return self::eksekusiShow('select count(*) as total from komunitas_bisnis where id_user='.$id)['total'];
	}
	public function selectOne($tbl, $id){
		return self::eksekusiShow('select * from '.$tbl.' where id_user='.$id);
	}
	public function selectWhere($tbl, $id, $where = null){
		return self::tampil_manual('select * from '.$tbl.' where id_komunitas_bisnis='.self::removeSpecialChar($id).' '.$where);
	}
	public function selectWithBussiness($tbl, $id, $post = null){
		// echo 'select * from '.$tbl.' where id_komunitas_bisnis='.$id;
		$param = '';
		if ($post == 'publish') {
			$param = ' and status="publish" order by created_at desc limit '.$this->limit;
		}
		if (!empty($this->orderBy)) {
			$param .= " order by id desc";
		}
		return self::tampil_manual('select * from '.$tbl.' where id_komunitas_bisnis='.$id.' '.$param);
	}
 	public function inputRedirect(){
 		echo '<input type="hidden" class="form-control" name="redirect" value="'.self::thisUrl().'">';
 	}
 	public function publishPost($id, $url){
 		
 		self::eksekusi('update post set status="publish", created_at="'.date("Y-m-d H:i:s").'" where id='.$id);
 		$post = self::single('post', $id);
		
		self::postNotifikasi( $_COOKIE['id_akun_combi'], $post['id_user'], 'acc_post', 'Post Disetujui', 'Post <b>'.$post['judul'].'</b> Telah di verifikasi dan disetujui oleh Admin', $_SESSION['bisnis_kategori_combi'] );

		self::postNotifikasi( $_COOKIE['id_akun_combi'], 0, 'post', ' ', ' ', $_SESSION['bisnis_kategori_combi'] );

		self::registerFlash('s', 'Postingan berhasil kamu posting/setujui');
        header("Location: ".$this->https.$url."?info=berhasil");
 	}
 	public function thisUrl($noparam = null){
 		if ($noparam == 'noparam') {
 			return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 		}
 		return parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH);
 	}
 	public function inputRedirectFull($param = null){
		$input = '';
 		if ($param == 'id') {
 			$input = '<input type="hidden" name="id" value="'.preg_replace('/[^0-9]/', '', $_GET['id']).'">';
 		}
 		echo '<input type="hidden" class="form-control" name="redirect" value="'.self::thisUrl().'"><input type="hidden" name="id_user" value="'.$_COOKIE['id_akun_combi'].'">
                            <input type="hidden" name="id_komunitas_bisnis" value="'.$_SESSION['bisnis_kategori_combi'].'">'.$input;
 	}
	function eksekusiShow($sql){
		$sql=($sql);
		if ($this->debug == true) {
			echo $sql; die;
		}

		$masuk=$this->kon->prepare($sql);

		$masuk->execute();

		$mulai=$masuk->fetch();

		return $mulai;
	}
	 
 	public function addCountPostComment($d){
 		self::eksekusi('UPDATE post set jumlah_komen=jumlah_komen+1 WHERE id = '.$d);
 	}

 	public function addCountPostLike($d){
 		self::eksekusi('UPDATE post set jumlah_like=jumlah_like+1 WHERE id = '.$d);
 	}
	function eksekusi($key){

		$sql=($key);

		$masuk=$this->kon->prepare($this->timezone.' '.$sql);	

		$masuk->execute();

	}

	function tampil_manual($key){
		if ($this->debug == true) {
			echo $key;
			die;
		}

		$sql=($key);

		$masuk=$this->kon->prepare($sql);	

		$masuk->execute();

		$mulai=$masuk->fetchAll(PDO::FETCH_ASSOC);

		return $mulai;

	}
 
	function tampil_data_multi_where($tbl,$data,$key){

		$dataA=null;

		for ($i=0; $i <count($data); $i++) { 

			$dataA=$dataA.''.$data[$i].',';

		}

		$listCut=substr($dataA,0,strlen($dataA)-1);

		

		$where=null;

		for ($i=0; $i <count($key); $i++) { 

			$where=$where.''.$key[$i].' and ';

		}

		$listCutWhere=substr($where,0,strlen($where)-4);



		$dataTbl=null;

		for ($i=0; $i <count($tbl); $i++) { 

			$dataTbl=$dataTbl.''.$tbl[$i].',';

		}

		$listCutTbl=substr($dataTbl,0,strlen($dataTbl)-1);



		$sql=(" select ".$listCut." from ".$listCutTbl." where ".$listCutWhere);
		// echo $sql;die;
		$masuk=$this->kon->prepare($sql);

		$masuk->execute();

		$mulai=$masuk->fetchAll();

		return $mulai;

		

	}

	function rubah_data($tbl,$ubah,$data,$key){

		$clmn=null;

		$multiWhere=null;

		for ($ix=0; $ix <count($ubah); $ix++) { 

			$clmn=$clmn.''.$ubah[$ix].',';

		}

		for ($ix=0; $ix <count($data); $ix++) { 

			$multiWhere=$multiWhere.''.$data[$ix].'="'.$key[$ix].'" and ';

		}

		$listCut=substr($clmn,0,strlen($clmn)-1);	

		$listCutMulti=substr($multiWhere,0,strlen($multiWhere)-4);	



		// tidak ada where

		if($data==null || $key==null){

			$sm="";

		}else{

			$sm="=";

		}

		if($data==null && $key==null){

			$where='';

		}else{

			$where='where';

		}

		// batas tdk ada where

		$sql=("update ".$tbl." set ".$listCut." ".$where." ".$listCutMulti);

		if ($this->debug == true) {
			// code...
			echo $sql;
			die;
		}

		$masuk=$this->kon->prepare($sql);


		

		if($masuk->execute()){
			if ($this->disableRedirect == false) {
				header('location: '.$this->https.$this->redirect.'&info=berhasil');
			}

		}else{
			header('location: '.$this->https.$this->redirect.'&info=gagal');

			// echo $sql;

		}

		

	}

	function cart(){
		$sql = 'select *, c.id as idc, p.id as idp from cart as c join produk as p on p.id = c.id_produk where c.id_user='.$_COOKIE['id_akun_combi'].' and c.id_komunitas_bisnis='.$_SESSION['bisnis_kategori_combi'].' order by c.id desc';
		$for = self::tampil_manual($sql);
		foreach ($for as $data) {
			// $this->debug = true;
			$produkVar = self::selectSingleOne('produk_variasi', 'id', $data['id_produk_variasi']);
			// echo 'update cart set qty="'.$produkVar['stok'].'" where id='.$data['idc']; die;
			if ($produkVar['stok'] <= $data['qty']) {
				self::eksekusi('update cart set qty="'.$produkVar['stok'].'" where id='.$data['idc']);
			}
		}
		return self::tampil_manual($sql);
	}

	function masukan_data_no_redirect($tbl,$clm,$data){

		$clmn=null;

		for ($ix=0; $ix <count($clm); $ix++) { 

			$clmn=$clmn.''.$clm[$ix].',';

		}



		$dataA=null;

		for ($i=0; $i <count($data); $i++) { 

			$dataA=$dataA.'"'.$data[$i].'",';

		}

		

		$listCut=substr($dataA,0,strlen($dataA)-1);		

		$listCutCol=substr($clmn,0,strlen($clmn)-1);		

		

		$sql=("insert into ".$tbl." (".$listCutCol.")

					values(".$listCut.")
		");
		$sql2 = $sql;
		if ($this->debug == true) {
			echo $sql;
			die;
		}

		if ($this->lastId == false) {
			$sql = $this->timezone.' '.$sql2;
		}

		
		$masuk=$this->kon->prepare($sql);

		
		if ($this->debugSql == false) {
			if($masuk->execute()){
				if ($this->lastId == true) {
					return $this->kon->lastInsertId();
				}else{
					return true;
				}
				// header('location:../../pages/?eRaport='.$this->link);			

			}else{

				return false;
				// header('location:../../pages/?eRaport='.$this->link);

			}
		}else{
			echo 'DEBUG<br>';
			echo $sql;
		}

	}

	function waFormat($type){
		$user = self::thisProfile($_COOKIE['id_akun_combi']);
		$kom = self::selectSingleOne('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);
		if ($type == 'produk') {
			$string = self::noWa( $kom['nowa']).'?text=Hallo%2C%20saya%20*'.$user['nama_lengkap'].'*%20member%20komunitas%20*'.$kom['nama_komunitas'].'*%20%2C%20saya%20sudah%20melakukan%20pemesanan%20produk%2C%20dan%20berikut%20nomor%20invoicenya%20*'.$this->inv.'*.%0A%0AMohon%20di%20proses%20dan%20di%20hitung%20biaya%20ongkirnya%0ATerima%20kasih';
		}
		return $string;
	}
	function masukan_data($tbl,$clm,$data, $debug=false){

		$clmn=null;

		for ($ix=0; $ix <count($clm); $ix++) { 

			$clmn=$clmn.''.$clm[$ix].',';

		}



		$dataA=null;

		for ($i=0; $i <count($data); $i++) { 

			$dataA=$dataA."'".$data[$i]."',";

		}

		

		$listCut=substr($dataA,0,strlen($dataA)-1);		

		$listCutCol=substr($clmn,0,strlen($clmn)-1);		

		

		$sql=("insert into ".$tbl." (".$listCutCol.")

					values(".$listCut.")

		");
		if ($this->debug == true) {
			echo $sql;
			die;
		}
		$masuk=$this->kon->prepare($this->timezone.' '.$sql);

		

		if($masuk->execute()){

			header('location: '.$this->https.$this->redirect.'?info=berhasil');

		}else{

			header('location: '.$this->https.$this->redirect.'?info=gagal');

		}

	}
	public function removeSpecialChar($str){
		return str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $str);
	}
	public function gagal(){
		header('location: '.$this->https.$this->redirect.'?info=gagal');
	}

	public function extractComment($data){
		$newString = explode('xox', $data);
		$c = self::single('users', $newString[0])['nama_lengkap'];
		$nama = '';
		if (!empty($c)) {
			$nama = '<span class="badge badge-warning">'.$c.'</span>';
		}
		return $nama.' '.$newString[1];
	}

	function masukan_data_luar_redirect($tbl,$clm,$data){

		$clmn=null;

		for ($ix=0; $ix <count($clm); $ix++) { 

			$clmn=$clmn.''.$clm[$ix].',';

		}



		$dataA=null;

		for ($i=0; $i <count($data); $i++) { 

			$dataA=$dataA.'"'.$data[$i].'",';

		}

		

		$listCut=substr($dataA,0,strlen($dataA)-1);		

		$listCutCol=substr($clmn,0,strlen($clmn)-1);		

		

		$sql=("insert into ".$tbl." (".$listCutCol.")

					values(".$listCut.")

		");

		// echo $sql;

		$masuk=$this->kon->prepare($this->timezone.' '.$sql);

		

		$masuk->execute();
		

	}

	public function link(){

		header('location:../../pages/?eRaport='.$this->link);	

	}
	public function getProfileAffiliate($kode){
		return self::eksekusiShow('select * from users where kode_affiliate="'.$kode.'"');
	}
	public function hapus_satu_data($r=0){

		$sql=("delete from ".$this->tbl." where ".$this->clm." = :where");
		
		$masuk=$this->kon->prepare($sql);

		$masuk->bindparam(':where',$r);
		
		if ($this->debug == true) {
			echo $sql;
			die;
		}

		if($masuk->execute()){
			if ($this->disableRedirect == false) {
				header('location: '.$this->https.$this->redirect.'?info=berhasil');
			}
		}else{
			header('location: '.$this->https.$this->redirect.'?info=gagal');
				
		}

	}

	 
	public function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'IP tidak dikenali';
	    return $ipaddress;
	}
	  
	 
	  
	  
	// Mendapatkan jenis web browser pengunjung
	public function get_client_browser() {
	    $browser = '';
	    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
	        $browser = 'Netscape';
	    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
	        $browser = 'Firefox';
	    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
	        $browser = 'Chrome';
	    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
	        $browser = 'Opera';
	    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
	        $browser = 'Internet Explorer';
	    else
	        $browser = 'Other';
	    return $browser;
	}
	public function find($tbl, $clm, $text, $type = 'show'){
		$sql = "select * from ".$tbl." where ".$clm." like '%".$text."%'";
		if ($type == 'show') {
			$r = self::tampil_manual($sql);
		}else{
			$r = self::eksekusiShow($sql)['id'];
		}
		return $r;
	}
	public function readNotifikasi($id_user, $id_komunitas, $type = 'user'){
		$this->notifStatus = false;
		if ($type == 'admin') {
			$this->notifStatus = true;
		}

		foreach( self::selectNotif($id_user, $id_komunitas) as $show ){
			// echo $show['id'].'<br>';
			self::masukan_data_no_redirect('read_notifikasi', array('id_user', 'id_notifikasi_komunitas'), array($id_user, $show['id']));
		}
		header('location: '.$this->primaryLocal.'?info=berhasil');
	}
	public function postNotifikasi($id_user, $id_user_received, $type, $title, $text, $id_komunitas){
		self::masukan_data_no_redirect('notifikasi_komunitas', array('id_user', 'id_user_received', 'type', 'title', 'text', 'id_komunitas_bisnis'), array($id_user, $id_user_received, $type, $title, $text, $id_komunitas) );
	}
	public function selectNotif($id_user, $id_komunitas, $limit = 1000){
		$sql = "(nk.id_komunitas_bisnis=".$id_komunitas." AND (
						        nk.type = 'post' OR 
						        nk.type = 'papan' OR 
						        nk.type = 'faq' OR 
						        nk.type = 'rule' OR
						        nk.type = 'komunitas' OR
						        nk.type = 'new_prod'
						    )
						)
						OR";
        // nk.type = 'post_app' OR 
		// for admin
		$where1 = "AND nk.id_komunitas_bisnis=".$id_komunitas."";
		if ($this->allNotif == true) {
			$where1 = "";
		}
		if ($this->notifStatus == true) {
			$sql = '';
		}
		return self::tampil_manual("SELECT * FROM read_notifikasi as rn right join `notifikasi_komunitas` as nk on rn.id_notifikasi_komunitas = nk.id WHERE 
						(".$sql." 
						(nk.id_user_received = ".$id_user." ".$where1.")) AND rn.id is null order by nk.id desc limit ".$limit
					);
	}
	public function selectNormal($tbl){
		return self::tampil_manual('select * from '.$tbl);		
	}

	public function getEcourseByKomunitas($id){
		return self::tampil_manual('select * from ecourse as e join komunitas as k on k.id = e.id_komunitas_bisnis where k.id = '.$id);
	}

	public function isLiked($idPost, $idUser){
		$check = self::eksekusiShow('select * from `like` where id_user='.$idUser.' and id_post='.$idPost);
		// echo 'select * from `like` where id_user='.$idUser.' and id_post='.$idPost
		if (empty($check)) {
			return false;
		}
		return true;
	}

	public function csv($type = 'users'){
		$komunitas = self::selectSingleOne('komunitas_bisnis', 'id', $_SESSION['bisnis_kategori_combi']);
		if ($type == 'users') {
			$filename = 'member_'.$komunitas['nama_komunitas'].'_'.date('Ymd').'.csv';
			$sql = 'select nama_lengkap, nowa, email, tgl_lahir, domisili, jk from users as u join komunitas as k on k.id_user = u.id where k.id_komunitas = '.$_SESSION['bisnis_kategori_combi'].' and k.status =1 order by u.id desc ';
			$header = array('Nama Lengkap', 'No WA', 'E-Mail', 'Tanggal Lahir', 'domisili', 'Jenis Kelamin');
		}

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");

		$result = self::tampil_manual($sql);

		$file = fopen('php://output', 'w');


		fputcsv($file, $header);

		foreach ($result as $key=>$line){
			fputcsv($file,$line);
		}

		fclose($file);
		exit;
	}

	function kirimEmail($paramNamaPenerima,$emailpengirim,$namapengirim,$emailpenerima,$judulemail,$konten){
		if (email_send == true) {
			require_once("/home/remotebi/public_html/member/smtp/src/PHPMailer.php");
			require_once("/home/remotebi/public_html/member/smtp/src/SMTP.php");
			
		    $mail = new PHPMailer\PHPMailer\PHPMailer();
		    // $mail->SMTPDebug = 3;                               
		    $namaPenerima='';
		    if (!empty($paramNamaPenerima)) {
		      $namaPenerima = $_POST['namaPenerima'];
		    }

		    $mail->isSMTP();                                   
		    $mail->Host = $this->Host;
		    $mail->SMTPAuth = $this->SMTPAuth;
		    $mail->Username = $emailpengirim;
		    $mail->Password = $this->Password;
		    $mail->SMTPSecure = $this->SMTPSecure;
		    $mail->Port = $this->Port;

		    $mail->From = $emailpengirim;
		    $mail->FromName = $namapengirim;
		    
		    $mail->addAddress($emailpenerima, $namaPenerima);
		    $mail->isHTML(true);
		    $mail->Subject = $judulemail;
		    $mail->Body = $konten;
		    // $mail->AltBody = "This is the plain text version of the email content";

		    if(!$mail->send()) {
		        echo "Opps, terdapat kesalahan, mohon hubungi admain !";
		        // echo "Mailer Error: " . $mail->ErrorInfo;
		    }
		}
	}
	function trafficComunity($id_komunitas){
		$sql = "SELECT t.nama as traffic, count(*) as total from users as u join komunitas as k on k.id_user = u.id join tahu as t on t.id = u.tahu WHERE k.id_komunitas=".$id_komunitas." group by u.tahu;";

		$data = self::tampil_manual($sql);
		$totalall = 0;
		foreach ($data as $key => $value) {
			$totalall += $value['total'];
		}

		return array($data, $totalall);
	}
	public function getDateRange($mulai, $akhir){
		$startDate = new \DateTime($mulai);
		$endDate = new \DateTime($akhir);

		$data = array();
		$no=1;
		for($date = $startDate; $date <= $endDate; $date->modify('+1 day')){
			$no++;
			if ($no <= 30) {
			    array_push($data, $date->format('Y-m-d'));
			}else{
				break;
			}
		}
		return $data;
	}
	public function reportOrdersAffiliate($date, $id_komunitas){
		$this->status = 1;

		self::reportOrders($date, 'komunitas', $id_komunitas, 'id_komunitas');
	}

	public function reportOrdersProdukAffiliate($date, $id_komunitas){
		
		self::reportOrders($date, 'order_produk', $id_komunitas);
	}

	public function reportOrdersDropship($date, $id_komunitas){
		
		self::reportOrders($date, 'pesanan', $id_komunitas);
	}
	public function reportOrders($date, $tbl, $id_komunitas, $clm_id_komunitas = 'id_komunitas_bisnis'){
		$dates = str_replace(' ', '', $date);
		$date = explode('-', $dates);
		$cdate = self::convertDate("Y-m-d", $date[0]);
		$cdate2 = self::convertDate("Y-m-d", $date[1]);
		if ($this->downloadReport == true) {
			// download report
			// 
			// setiap data kalo datang dari aff statusnya beluk ok(1 atau 3 sesuai type masing)
			// maka harus di sensor
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
			if ($tbl == 'komunitas') {
				$header = array('Nama Lengkap', 'E-Mail', 'Jenis Kelamin', 'No HP', 'domisili', 'Perangkat', 'Status (1 = konversi, 0 = Lead)' , 'Tanggal', 'Tahu dari');
				if ($cdate2 == $cdate) {
					$where = " and k.created_at like '%".$cdate."%' ";
				}else{
					$where = " and k.created_at BETWEEN '".$cdate."' and '".$cdate2."'";
				}
				
				$sql = 'select u.nama_lengkap, u.email, u.jk, u.nowa, u.domisili, u.perangkat, k.status, k.created_at, t.nama from komunitas as k join users as u on u.id = k.id_user left join tahu as t on t.id = u.tahu where k.'.$clm_id_komunitas.'='.$id_komunitas.' '.$where;
			}elseif($tbl == 'pesanan'){
				if ($cdate2 == $cdate) {
					$where = " and u.created_at like '%".$cdate."%' ";
				}else{
					$where = " and u.created_at BETWEEN '".$cdate."' and '".$cdate2."'";
				}
				
				$sql = 'select u.invoice, u.nama_lengkap, u.email, u.nowa, u.provinsi, u.kecamatan, u.alamat, u.status, u.created_at from pesanan as u where u.'.$clm_id_komunitas.'='.$id_komunitas.' '.$where;
				$header = array('Nama Lengkap', 'E-Mail', 'Jenis Kelamin', 'No HP', 'domisili', 'Perangkat', 'Status (1 = diajukan, 2 = ditolak, 3 = diproses/selesai)' , 'Tanggal', 'Tahu dari');
			}elseif($tbl == 'order_produk'){
				if ($cdate2 == $cdate) {
					$where = " and u.created_at like '%".$cdate."%' ";
				}else{
					$where = " and u.created_at BETWEEN '".$cdate."' and '".$cdate2."'";
				}
				
				$header = array('Nama Lengkap', 'E-Mail', 'Jenis Kelamin', 'No HP', 'domisili', 'alamat', 'Perangkat', 'Status (1 = diajukan, 2 = ditolak, 3 = diproses/selesai)' , 'Tanggal');
				
				$sql = 'select u.nama, u.email, u.jk, u.nowa, u.domisili, u.alamat, u.perangkat, u.status, u.created_at from order_produk as u where u.'.$clm_id_komunitas.'='.$id_komunitas.' '.$where;
			}

			$result = self::tampil_manual($sql);

			$file = fopen('php://output', 'w');


			fputcsv($file, $header);

			foreach ($result as $key=>$line){
				fputcsv($file,$line);
			}

			fclose($file);
			exit;

		}else{
			// report umum biasa
 
			$val = '';
			$col = '';
			$closing = '';
		 
			$tanggal = self::getDateRange($cdate, $cdate2);
			$dataConv = '';
			$dataAll = '';
			foreach ($tanggal as $tgl) {
				$valConv = self::eksekusiShow('select count(*) as total from '.$tbl.' where '.$clm_id_komunitas.'='.$id_komunitas.' and status='.$this->status.' and created_at like "%'.$tgl.'%" ');
				$valSemua = self::eksekusiShow('select count(*) as total from '.$tbl.' where '.$clm_id_komunitas.'='.$id_komunitas.' and created_at like "%'.$tgl.'%" ');
				$dataConv .= $valConv['total'].',';
				$dataAll .= $valSemua['total'].',';
				$tgltext .= self::convertDate('d F Y', $tgl).','; 
			}
			// buat fitur rang tgl sampai 30 aja
			echo json_encode( array('tgl' => $tgltext, 'conv' => $dataConv, 'all' => $dataAll ) );
		}
	}
	public function httpGet($url){
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	public function notifAdminRebi($kaf){
		if (empty($kaf) || $kaf == '39587434922' || $kaf == null) {
			$kaf_new = '39587434922';
			$nb = '';
		}else{
			$kaf_new = $kaf;
			$nb = '<small>NB : Anda daftar lewat Affiliate, pastikan kontak nomor diatas (Whatsapp) sebelum melakukan transfer. </small>';
		}


		$aff = 'https://member.remotebisnis.com/setting/function/proses_daftar_api.php?kaf='.$kaf_new;
		$affiliate = json_decode(self::httpGet($aff));

		// tf ke affiliate /admin rebi
		$konten = ' 
			<h3>Selamat ! </h3>
			<p>Ada lead baru yang siap daftar KOMBI lewat affilaite Anda, berikut detailnya :</p>
			<h4>Emai = '.$this->priceEmail.'</h4>
			<h4>Nama = '.$this->priceNama.'</h4>
			<h4>TOTAL = Rp'.self::nf($this->pricePublic).'</h4>
			<p>Silahkan dicek di <a href="https://member.remotebisnis.com" target="_blank">MemberArea Rebi</a></p>
		';

	    self::kirimEmail('','kombi@remotebisnis.com','Kombi RemoteBisnis',$affiliate->username,'Ada yang daftar KOMBI lewat link affiliate Anda nih, cek sekarang', $konten);
	}
	public function templateDaftarKomunitas($id, $sensor = false){
		$newUser = self::thisProfile($id);
		if ($sensor == true) {
			$email = 'a*******@****';
			$nama = '0878*****';
		}else{
			$email = $newUser['email'];
			$nama = $newUser['nama_lengkap'];
		}
		return ' 
			<td>
			    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
			        style="max-width:670px; background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
			<tr>
			    <td style="height:40px;">&nbsp;</td>
			</tr>
			<td style="padding:0 35px;">
			    <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:21px;font-family:Rubik,sans-serif;">Ada lead baru nih !</h1>
			    <br>
			    <p style="font-size:15px; color:#455056; margin:8px 0 0; line-height:24px;">
			        Berikut nama dan e-mailnya			        
			    </p>
			    <br>
			    <h3>E-Mail : '.$email.'</h3>
			    <h3>Nama : '.$nama.'</h3>
			    <p>*Lebih lengkapnya bisa dilihat di Memberarea</p>
			    <br>
			    <hr>
			    <a href="'.$this->primaryLocal.'"style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login ke MemberArea</a>
			</td>
		';
	}
	public function templateDaftarBisnis($kaf){
		if (empty($kaf) || $kaf == '39587434922' || $kaf == null) {
			$kaf_new = '39587434922';
			$nb = '';
		}else{
			$kaf_new = $kaf;
			$nb = '<small>NB : Anda daftar lewat Affiliate, pastikan kontak nomor diatas (Whatsapp) sebelum melakukan transfer. </small>';
		}


		$aff = 'https://member.remotebisnis.com/setting/function/proses_daftar_api.php?kaf='.$kaf_new;
		$affiliate = json_decode(self::httpGet($aff));
		
		return ' 
			<td style="padding:0 35px;">
			    <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:21px;font-family:Rubik,sans-serif;">Tinggal satu langkah lagi</h1>
			    <br>
			    <p style="font-size:15px; color:#455056; margin:8px 0 0; line-height:24px;">
			        Terima kasih telah bergabung dengan KOMBI,<br> sekarang tinggal 1 langkah lagi yaitu konfirmasi pembayaran senilai <br><br>
			        <h2>Rp'.self::nf($this->pricePublic).'</h2>
			        <br><strong>Segera konfirmasi pembayaran ke salah satu nomor rekening berikut :</strong>.
			    </p>
			    <hr>
			    <br>
			    '.$affiliate->note.'
			    <br>
			    <span
			        style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
			    <p
			        style="color:#455056; font-size:18px;line-height:20px; margin:0; font-weight: 500;">
			        <strong
			            style="display: block;font-size: 13px; margin: 0 0 4px; color:rgba(0,0,0,.64); font-weight:normal;">Konfirmasi ke : </strong>
			        <a href="https://wa.me/'.self::str_replace_first('0','62',$affiliate->nowa).'"> '.$affiliate->nowa.'</a>
			        <br>
			        '.$nb.'
			    </p>
			    <br>
			    <hr>
			    <a href="'.$this->primaryLocal.'"style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login ke MemberArea</a>
			</td>

		';
	}
	public function str_replace_first($from, $to, $content)
	{
		$from = '/'.preg_quote($from, '/').'/';

		return preg_replace($from, $to, $content, 1);
	}
	public function templateLupaPass($token){
		$url = $this->primaryLocal.'recovery?token='.$token;
		return ' 
			<tr>
                <td style="padding:0 35px;">
                    <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:Rubik,sans-serif;">Lupa Password ?
                    </h1>
                    <p style="font-size:15px; color:#455056; margin:8px 0 0; line-height:24px;">
                        Kamu telah melakukan permintaan perubahan password <br><strong>Berikut link Reset Password, Klik atau salin tautan berikut :</strong>.</p>
                    <span
                        style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                    <p
                        style="color:#455056; font-size:18px;line-height:20px; margin:0; font-weight: 500;">
                        <strong
                            style="display: block;font-size: 13px; margin: 0 0 4px; color:rgba(0,0,0,.64); font-weight:normal;">Klik ini </strong>
                <a href="'.$url.'">Atur Ulang Password</a>
                        <strong
                            style="display: block; font-size: 13px; margin: 24px 0 4px 0; font-weight:normal; color:rgba(0,0,0,.64);">Atau salin tautan ini </strong>
                <span>'.$url.'</span>
                    </p><br><hr>
                    <a href="https://kombi.remotebisnis.com"
                        style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login ke MemberArea</a>
                </td>
            </tr>
		';
	}
	public function templateEmail($konten ){
		return ' 
			<!doctype html>
			<html lang="en-US">

			<head>
			    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			    <title>KOMBI</title>
			    <meta name="description" content="KOMBI">
			    <style type="text/css">
			        a:hover {text-decoration: underline !important;}
			    </style>
			</head>

			<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
			    <!-- 100% body table -->
			    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
			        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: Open Sans, sans-serif;">
			        <tr>
			            <td>
			                <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
			                    align="center" cellpadding="0" cellspacing="0">	
			                    <tr>
			                        <td style="height:80px;">&nbsp;</td>
			                    </tr>
			                    <tr>
			                        <td style="text-align:center;">
			                            <a href="https://rakeshmandal.com" title="logo" target="_blank">
			                            <img width="160" src="https://duniaundercover.files.wordpress.com/2023/02/combi.png" title="logo" alt="logo">
			                          </a>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td style="height:20px;">&nbsp;</td>
			                    </tr>
			                    <tr>
			                        <td>
			                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
			                                style="max-width:670px; background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
			                                <tr>
			                                    <td style="height:40px;">&nbsp;</td>
			                                </tr>
			                                '.$konten.'
			                                <tr>
			                                    <td style="height:40px;">&nbsp;</td>
			                                </tr>
			                            </table>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td style="height:20px;">&nbsp;</td>
			                    </tr>
			                    <tr>
			                        <td style="text-align:center;">
			                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>https://kombi.remotebisnis.com</strong> </p>
                                <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>https://remotebisnis.com</strong> </p>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td style="height:80px;">&nbsp;</td>
			                    </tr>
			                </table>
			            </td>
			        </tr>
			    </table>
			    <!--/100% body table-->
			</body>

			</html>
		';
	}

}

 