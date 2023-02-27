<?php

class koneksi{

	public function hubungkan(){

		$this->kon=null;

		try{

			$this->kon=new pdo('mysql:host=localhost;dbname=rebikom;','root','');			

		}catch(PDOExeption $o){

			echo 'Koneksi Gagal lihat -> '.$o->getMessage();

		}return $this->kon;

	}

}

?>