<?php

class koneksi{
	public $host = host;
	public $dbname = dbname;
	public $user = user;
	public $pass = pass;

	public function hubungkan(){

		$this->kon=null;

		try{

			$this->kon=new pdo('mysql:host='.$this->host.';dbname='.$this->dbname.';',''.$this->user.'',''.$this->pass.'');			

		}catch(PDOExeption $o){

			echo 'Koneksi Gagal lihat -> '.$o->getMessage();

		}return $this->kon;

	}

	public function hubungkanRebi(){

		$this->kon=null;

		try{

			$this->kon=new pdo('mysql:host='.$this->host.';dbname=remotebi_memberarea;',''.$this->user.'',''.$this->pass.'');			

		}catch(PDOExeption $o){

			echo 'Koneksi Gagal lihat -> '.$o->getMessage();

		}return $this->kon;

	}

}

?>