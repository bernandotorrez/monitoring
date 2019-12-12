<?php

require_once 'config/dbconfig.php';

class USER
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

	public function register($nip,$remail,$nama,$alamat,$hp,$jk,$agama,$tempat,$tgl,$pernikahan,$bidang,$jabatan,$password,$passkey)
	{
		try
		{
			$rupass = md5($password);
			$stmt = $this->conn->prepare("INSERT INTO login(email,level,password,passkey)
			                                             VALUES(:user_mail, :jabatan, :password, :passkey)");
			$stmt->bindparam(":user_mail",$remail);
			$stmt->bindparam(":jabatan",$jabatan);
			$stmt->bindparam(":password",$rupass);
			$stmt->bindparam(":passkey",$passkey);

			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO pegawai(nip,email,nama_pegawai,alamat,no_hp,jenis_kelamin,agama,tempat_lahir,tgl_lahir,status_pernikahan,bidang,jabatan)
			                                             VALUES(:nip,:email,:nama,:alamat,:hp,:jk,:agama,:tempat,:tgl,:status,:bidang,:jabatan)");
			$stmt->bindparam(":nip",$nip);
			$stmt->bindparam(":email",$remail);
			$stmt->bindparam(":nama",$nama);
			$stmt->bindparam(":alamat",$alamat);
			$stmt->bindparam(":hp",$hp);
			$stmt->bindparam(":jk",$jk);
			$stmt->bindparam(":agama",$agama);
			$stmt->bindparam(":tempat",$tempat);
			$stmt->bindparam(":tgl",$tgl);
			$stmt->bindparam(":status",$pernikahan);
			$stmt->bindparam(":bidang",$bidang);
			$stmt->bindparam(":jabatan",$jabatan);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

		public function register_owner($nip,$remail,$nama,$alamat,$hp,$jabatan,$password,$passkey)
	{
		try
		{
			$rupass = md5($password);

			$stmt = $this->conn->prepare("INSERT INTO login(email,level,password,passkey)
			                                             VALUES(:user_mail, :jabatan, :password, :passkey)");
			$stmt->bindparam(":user_mail",$remail);
			$stmt->bindparam(":jabatan",$jabatan);
			$stmt->bindparam(":password",$rupass);
			$stmt->bindparam(":passkey",$passkey);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO owner(id_owner,email,nama_owner,alamat,no_hp,jabatan)
			                                             VALUES(:nip,:email,:nama,:alamat,:hp,:jabatan)");
			$stmt->bindparam(":nip",$nip);
			$stmt->bindparam(":email",$remail);
			$stmt->bindparam(":nama",$nama);
			$stmt->bindparam(":alamat",$alamat);
			$stmt->bindparam(":hp",$hp);
			$stmt->bindparam(":jabatan",$jabatan);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function inputproyek($idproyek,$proyek,$idl,$jenis,$lokasi,$lahan,$bangunan,$totalbangunan,$lantai,$basement,$ground,$own,$owner,$arsitek,$fungsi,$tahun,$tglmulai,$tglselesai)
	{
		try
		{

		
			
			$stmt = $this->conn->prepare("INSERT INTO proyek(id_proyek,id_owner,nama_proyek,jenis_bangunan,lokasi,area_lahan,area_bangunan,total_bangunan,total_lantai,total_basement,total_ground,arsitek,fungsi_bangunan,tahun,tgl_mulai,tgl_selesai)
			                                             VALUES(:id,:ido,:nama,:jenis,:lokasi,:lahan,:bangunan,:totalbangunan,:lantai,:basement,:ground,:arsitek,:fungsi,:tahun,:tglmulai,:tglselesai)");
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":ido",$own);
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":jenis",$jenis);
			$stmt->bindparam(":lokasi",$lokasi);
			$stmt->bindparam(":lahan",$lahan);
			$stmt->bindparam(":bangunan",$bangunan);
			$stmt->bindparam(":totalbangunan",$totalbangunan);
			$stmt->bindparam(":lantai",$lantai);
			$stmt->bindparam(":basement",$basement);
			$stmt->bindparam(":ground",$ground);
			$stmt->bindparam(":arsitek",$arsitek);
			$stmt->bindparam(":fungsi",$fungsi);
			$stmt->bindparam(":tahun",$tahun);
			$stmt->bindparam(":tglmulai",$tglmulai);
			$stmt->bindparam(":tglselesai",$tglselesai);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO laporan_bulanan(id_laporan,id_proyek,id_owner)
			                                             VALUES(:idl,:id,:ido)");
			$stmt->bindparam(":idl",$idl);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":ido",$own);
			
		
			$stmt->execute();

			for ($j=1;$j<=$lantai;$j++) {
					$progress = 0;
			if($j < 10) {
				$detail1 = $idproyek."-0".$j;
				$namalantai = $proyek."-0".$j;
				$jl = "0".$j;
			} elseif($j >= 10) {
				$detail1 = $idproyek."-".$j;
				$namalantai = $proyek."-".$j;
				$jl = $j;
			}
			$stmt = $this->conn->prepare("INSERT INTO proyek_lantai(id_proyek_lantai,id_proyek,nama_proyek,nama_proyeklantai,lantai)
			                                             VALUES(:idit,:id,:nama,:namalantai,:lantai)");
			$stmt->bindparam(":idit",$detail1);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":lantai",$jl);
			$stmt->execute();
		}
		for ($j=1;$j<=$basement;$j++) {
					$progress = 0;
			
				$detail1 = $idproyek."-B".$j;
				$namalantai = $proyek."-B".$j;
				$jb = "B".$j;
			$stmt = $this->conn->prepare("INSERT INTO proyek_lantai(id_proyek_lantai,id_proyek,nama_proyek,nama_proyeklantai,lantai)
			                                             VALUES(:idit,:id,:nama,:namalantai,:lantai)");
			$stmt->bindparam(":idit",$detail1);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":lantai",$jb);
			$stmt->execute();
		}
		for ($j=1;$j<=$ground;$j++) {
					$progress = 0;
			
				$detail1 = $idproyek."-GF";
				$namalantai = $proyek."-GF";
			$jg = "GF";
			$stmt = $this->conn->prepare("INSERT INTO proyek_lantai(id_proyek_lantai,id_proyek,nama_proyek,nama_proyeklantai,lantai)
			                                             VALUES(:idit,:id,:nama,:namalantai,:lantai)");
			$stmt->bindparam(":idit",$detail1);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":lantai",$jg);
			$stmt->execute();
		}
			for ($i=1;$i<=$lantai;$i++) {
					$progress = 0;
					

			if($i < 10) {
				$detail = "DIT-".$idproyek."-0".$i;
				$idlantai = $idproyek."-0".$i;
				$namalantai = $proyek."-0".$i;
			} elseif($i >= 10) {
				$detail = "DIT-".$idproyek."-".$i;
				$idlantai = $idproyek."-".$i;
				$namalantai = $proyek."-".$i;
			}
			$stmt = $this->conn->prepare("INSERT INTO detailproyek_electrical(id_detailproyek, id_proyek, id_proyek_lantai, id_owner, nama_proyek, nama_proyeklantai, nama_owner)
			                                             VALUES(:idit,:id,:idl,:owner,:nama,:namalantai,:namaowner)");
			$stmt->bindparam(":idit",$detail);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":idl",$idlantai);
			$stmt->bindparam(":owner",$own);
			
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":namaowner",$owner);
					
			$stmt->execute();
		}
for ($i=1;$i<=$basement;$i++) {
					$progress = 0;
					

			
				$detail = "DIT-".$idproyek."-B".$i;
				$idlantai = $idproyek."-B".$i;
				$namalantai = $proyek."-B".$i;
			
			$stmt = $this->conn->prepare("INSERT INTO detailproyek_electrical(id_detailproyek,id_proyek,id_proyek_lantai,id_owner,nama_proyek,nama_proyeklantai,nama_owner)
			                                             VALUES(:idit,:id,:idl,:owner,:nama,:namalantai,:namaowner)");
			$stmt->bindparam(":idit",$detail);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":idl",$idlantai);
			$stmt->bindparam(":owner",$own);
			
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":namaowner",$owner);
					
			$stmt->execute();
		}
		for ($i=1;$i<=$ground;$i++) {
					$progress = 0;
					

			
				$detail = "DIT-".$idproyek."-GF";
				$idlantai = $idproyek."-GF";
				$namalantai = $proyek."-GF";
			
			$stmt = $this->conn->prepare("INSERT INTO detailproyek_electrical(id_detailproyek,id_proyek,id_proyek_lantai,id_owner,nama_proyek,nama_proyeklantai,nama_owner)
			                                             VALUES(:idit,:id,:idl,:owner,:nama,:namalantai,:namaowner)");
			$stmt->bindparam(":idit",$detail);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":idl",$idlantai);
			$stmt->bindparam(":owner",$own);
			
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":namaowner",$owner);
					
			$stmt->execute();
		}
		for ($i=1;$i<=$basement;$i++) {
					$progress = 0;
					

			
				$detail = "DIT-".$idproyek."-B".$i;
				$idlantai = $idproyek."-B".$i;
				$namalantai = $proyek."-B".$i;
			
			$stmt = $this->conn->prepare("INSERT INTO detailproyek_mechanical(id_detailproyek,id_proyek,id_proyek_lantai,id_owner,nama_proyek,nama_proyeklantai,nama_owner)
			                                             VALUES(:idit,:id,:idl,:owner,:nama,:namalantai,:namaowner)");
			$stmt->bindparam(":idit",$detail);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":idl",$idlantai);
			$stmt->bindparam(":owner",$own);
			
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":namaowner",$owner);
					
			$stmt->execute();
		}
		for ($i=1;$i<=$ground;$i++) {
					$progress = 0;
					

			
				$detail = "DIT-".$idproyek."-GF";
				$idlantai = $idproyek."-GF";
				$namalantai = $proyek."-GF";
			
			$stmt = $this->conn->prepare("INSERT INTO detailproyek_mechanical(id_detailproyek,id_proyek,id_proyek_lantai,id_owner,nama_proyek,nama_proyeklantai,nama_owner)
			                                             VALUES(:idit,:id,:idl,:owner,:nama,:namalantai,:namaowner)");
			$stmt->bindparam(":idit",$detail);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":idl",$idlantai);
			$stmt->bindparam(":owner",$own);
			
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":namaowner",$owner);
					
			$stmt->execute();
		}
			for ($i=1;$i<=$lantai;$i++) {
					$progress = 0;
					

			if($i < 10) {
				$detail = "DIT-".$idproyek."-0".$i;
				$idlantai = $idproyek."-0".$i;
				$namalantai = $proyek."-0".$i;
			} elseif($i >= 10) {
				$detail = "DIT-".$idproyek."-".$i;
				$idlantai = $idproyek."-".$i;
				$namalantai = $proyek."-".$i;
			}
			$stmt = $this->conn->prepare("INSERT INTO detailproyek_mechanical(id_detailproyek,id_proyek,id_proyek_lantai,id_owner,nama_proyek,nama_proyeklantai,nama_owner)
			                                             VALUES(:idit,:id,:idl,:owner,:nama,:namalantai,:namaowner)");
			$stmt->bindparam(":idit",$detail);
			$stmt->bindparam(":id",$idproyek);
			$stmt->bindparam(":idl",$idlantai);
			$stmt->bindparam(":owner",$own);
			
			$stmt->bindparam(":nama",$proyek);
			$stmt->bindparam(":namalantai",$namalantai);
			$stmt->bindparam(":namaowner",$owner);
					
			$stmt->execute();
		}
			
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function detailproyek($lantai,$a,$jml,$pegawai,$detail)
	{
		try
		{

			
			$stmt = $user_home->runQuery("UPDATE detailproyek SET nip=:nip, nama_pegawai=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nip",$a);
			$stmt->bindparam(":nama",$pegawai);
			$stmt->bindparam(":uid",$detail);
			
					
			$stmt->execute();
		
			
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function ceklak($status,$deskripsi,$ceklak,$id,$progresss,$l)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE detailproyek_electrical SET instalasi_lak=:lak, kondisi_instalasi_lak=:status, deskripsi_kondisi_instalasi_lak=:deskripsi WHERE id_detailproyek=:uid");
			$stmt->bindparam(":lak",$ceklak);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
			$stmt = $this->conn->prepare("UPDATE proyek SET total_pengerjaan=:total WHERE id_proyek=:uid");
			$stmt->bindparam(":total",$progresss);
			$stmt->bindparam(":uid",$l);				
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function ceklal($status,$deskripsi,$ceklal,$id,$progresss,$l)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE detailproyek_electrical SET instalasi_lal=:lal, kondisi_instalasi_lal=:status, deskripsi_kondisi_instalasi_lal=:deskripsi WHERE id_detailproyek=:uid");
			$stmt->bindparam(":lal",$ceklal);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
			$stmt = $this->conn->prepare("UPDATE proyek SET total_pengerjaan=:total WHERE id_proyek=:uid");
			$stmt->bindparam(":total",$progresss);
			$stmt->bindparam(":uid",$l);				
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function cekpl($status,$deskripsi,$cekpl,$id,$progresss,$l)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET instalasi_pl=:pl, kondisi_instalasi_pl=:status, deskripsi_kondisi_instalasi_pl=:deskripsi WHERE id_detailproyek=:uid");
			$stmt->bindparam(":pl",$cekpl);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
			$stmt = $this->conn->prepare("UPDATE proyek SET total_pengerjaan=:total WHERE id_proyek=:uid");
			$stmt->bindparam(":total",$progresss);
			$stmt->bindparam(":uid",$l);				
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function cekpk($status,$deskripsi,$cekpk,$id,$progresss,$l)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET instalasi_pk=:pk, kondisi_instalasi_pk=:status, deskripsi_kondisi_instalasi_pk=:deskripsi WHERE id_detailproyek=:uid");
			$stmt->bindparam(":pk",$cekpk);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
			$stmt = $this->conn->prepare("UPDATE proyek SET total_pengerjaan=:total WHERE id_proyek=:uid");
			$stmt->bindparam(":total",$progresss);
			$stmt->bindparam(":uid",$l);				
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function cektug($status,$deskripsi,$cektug,$id,$progresss,$l)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET instalasi_tug=:tug, kondisi_instalasi_tug=:status, deskripsi_kondisi_instalasi_tug=:deskripsi WHERE id_detailproyek=:uid");
			$stmt->bindparam(":tug",$cektug);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
			$stmt = $this->conn->prepare("UPDATE proyek SET total_pengerjaan=:total WHERE id_proyek=:uid");
			$stmt->bindparam(":total",$progresss);
			$stmt->bindparam(":uid",$l);				
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function cektdg($status,$deskripsi,$cektdg,$id,$progresss,$l)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET instalasi_tdg=:tdg, kondisi_instalasi_tdg=:status, deskripsi_kondisi_instalasi_tdg=:deskripsi WHERE id_detailproyek=:uid");
			$stmt->bindparam(":tdg",$cektdg);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
			$stmt = $this->conn->prepare("UPDATE proyek SET total_pengerjaan=:total WHERE id_proyek=:uid");
			$stmt->bindparam(":total",$progresss);
			$stmt->bindparam(":uid",$l);				
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function ceklap($status,$id)
	{
		try
		{

			
			$stmt = $this->conn->prepare("UPDATE laporan_bulanan SET kondisi_laporan=:status WHERE id_proyek=:uid");
		
			$stmt->bindparam(":status",$status);
			
			$stmt->bindparam(":uid",$id);				
			$stmt->execute();
		
		

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function home_edit($konten,$email,$id)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE modul SET konten=:konten, email_perusahaan=:email WHERE id_modul=:uid");
			$stmt->bindparam(":konten",$konten);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
public function edit_akun($status,$email)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE login SET status_member=:status WHERE email=:email");
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":email",$email);
			
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function foto_pegawai($foto,$id,$idfoto,$euname,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE pegawai SET foto=:foto WHERE email=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal,foto)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl, :foto)");
			$stmt->bindparam(":uid",$idfoto);
			$stmt->bindparam(":mail",$id);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			$stmt->bindparam(":foto",$foto);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_file_electrical_lak($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE detailproyek_electrical SET file_instalasi_lak=:foto WHERE id_detailproyek=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_file_electrical_lal($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE detailproyek_electrical SET file_instalasi_lal=:foto WHERE id_detailproyek=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_file_mechanical_pl($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET file_instalasi_pl=:foto WHERE id_detailproyek=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_file_mechanical_pk($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET file_instalasi_pk=:foto WHERE id_detailproyek=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_file_mechanical_tug($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET file_instalasi_tug=:foto WHERE id_detailproyek=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_file_mechanical_tdg($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE detailproyek_mechanical SET file_instalasi_tdg=:foto WHERE id_detailproyek=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function upload_laporan($foto,$id,$idl,$ido,$namalap,$idfoto,$nip,$euname,$email,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
				$stmt = $this->conn->prepare("UPDATE laporan_bulanan SET nama_laporan=:nama, file=:foto WHERE id_proyek=:idp");
			
			$stmt->bindparam(":nama",$namalap);
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":idp",$id);
						
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function foto_owner($foto,$id)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE owner SET foto=:foto WHERE email=:uid");
			$stmt->bindparam(":foto",$foto);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}


	public function edit_pegawai($euname,$alamat,$hp,$jk,$agama,$tempat,$tgl,$status,$bidang,$jabatan,$profil,$id,$nip,$keterangan,$foto,$wa,$facebook)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE pegawai SET nama_pegawai=:edit_nama, alamat=:alamat, no_hp=:hp, jenis_kelamin=:jk, agama=:agama, tempat_lahir=:tempat, tgl_lahir=:tgl, status_pernikahan=:status, bidang=:bidang, jabatan=:jabatan, facebook=:facebook, whatsapp=:wa, status_profil=:profil WHERE email=:uid");

			$stmt->bindparam(":edit_nama",$euname);
			$stmt->bindparam(":alamat",$alamat);
			$stmt->bindparam(":hp",$hp);
			$stmt->bindparam(":jk",$jk);
			$stmt->bindparam(":agama",$agama);
			$stmt->bindparam(":tempat",$tempat);
			$stmt->bindparam(":tgl",$tgl);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":bidang",$bidang);
			
			$stmt->bindparam(":jabatan",$jabatan);
			$stmt->bindparam(":facebook",$facebook);
			$stmt->bindparam(":wa",$wa);
			$stmt->bindparam(":profil",$profil);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal,foto)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl, :foto)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$id);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			$stmt->bindparam(":foto",$foto);
			$stmt->execute();
			return $stmt;

		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function edit_owner($euname,$alamat,$hp,$profil,$id,$id_owner,$keterangan,$foto,$password)
	{
		try
		{
			
			$stmt = $this->conn->prepare("UPDATE owner SET nama_owner=:edit_nama, alamat=:alamat, no_hp=:hp, status_profil=:profil WHERE email=:uid");

			$stmt->bindparam(":edit_nama",$euname);
			$stmt->bindparam(":alamat",$alamat);
			$stmt->bindparam(":hp",$hp);
			
			$stmt->bindparam(":profil",$profil);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

		
			return $stmt;

		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function ubahpass($konpassbaru,$id,$nip,$euname,$email,$keterangan,$foto)
	{
		try
		{
				$password = md5($konpassbaru);
				$now = date('Y/m/d H:i:s');
				$stmt = $this->conn->prepare("UPDATE login SET password=:upass WHERE email=:uid");

			$stmt->bindparam(":upass",$password);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal,foto)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl, :foto)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			$stmt->bindparam(":foto",$foto);
			$stmt->execute();
			return $stmt;

		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function ubahpassowner($konpassbaru,$id)
	{
		try
		{
				$password = md5($konpassbaru);
				$now = date('Y/m/d H:i:s');
				$stmt = $this->conn->prepare("UPDATE login SET password=:upass WHERE email=:uid");

			$stmt->bindparam(":upass",$password);
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			return $stmt;

		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function history($euname,$email,$id)
	{
		try
		{

			$stmt = $this->conn->prepare("INSERT INTO history(id_user,username,keterangan,email)
			                                             VALUES(:uid, :nama, :keterangan, :mail)");
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan","Mengubah Biodata");
			$stmt->bindparam(":uid",$id);
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function hapus_akun($email)
	{
		try
		{

			$stmt = $this->conn->prepare("DELETE FROM login WHERE email=:email");
			$stmt->bindparam(":email",$email);


			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function hapus_proyek($idproyek)
	{
		try
		{

			$stmt = $this->conn->prepare("DELETE FROM proyek WHERE id_proyek=:id");
			$stmt->bindparam(":id",$idproyek);
			$stmt->execute();

			$stmt = $this->conn->prepare("DELETE FROM laporan_bulanan WHERE id_proyek=:id");
			$stmt->bindparam(":id",$idproyek);

			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function online($email,$online,$nip,$email,$euname,$keterangan)
	{
		try
		{
			$now = date('Y/m/d H:i:s');
			$stmt = $this->conn->prepare("UPDATE login SET online=:online WHERE email=:email");
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":online",$online);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$email);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	public function login($email,$upass)
	{
		$user_home = new USER();
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM login WHERE email=:email_id LIMIT 1");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() == 1)
			{
				if($userRow['status_member']=="sudah")
				{
					if($userRow['password']==md5($upass))
					{
						$user_home->checkbrute($email);
						$_SESSION['userSession'] = $userRow['email'];
						return true;
					}
					else
					{
						$user_home->checkbrute($email);

						 $now = time();
						$stmt = $this->conn->prepare("INSERT INTO login_attempts(email,time)
			                                             VALUES(:user_mail, '$now')");
						$stmt->bindparam(":user_mail",$email);
						$stmt->execute();
						header("Location: login.php?error");
						exit;
					}
				}
				else
				{
					header("Location: login.php?inactive");
					exit;
				}
			}
			else
			{
				header("Location: login.php?error");
				exit;
			}
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}


	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}

	public function redirect($url)
	{
		header("Location: $url");
	}

	public function logout($id,$online,$nip,$euname,$keterangan,$date)
	{
		$now = date('Y/m/d H:i:s');
		$stmt = $this->conn->prepare("UPDATE login SET online=:online WHERE email=:uid");
			$stmt->bindparam(":uid",$id);
			$stmt->bindparam(":online",$online);
			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO history(nip,email,nama,keterangan,tanggal)
																									 VALUES(:uid, :mail, :nama, :keterangan, :tgl)");
			$stmt->bindparam(":uid",$nip);
			$stmt->bindparam(":mail",$id);
			$stmt->bindparam(":nama",$euname);
			$stmt->bindparam(":keterangan",$keterangan);
			$stmt->bindparam(":tgl",$now);
			
			$stmt->execute();
		session_destroy();
		$_SESSION['userSession'] = false;
	}

	public function logout_owner($id,$online)
	{
		$now = date('Y/m/d H:i:s');
		$stmt = $this->conn->prepare("UPDATE login SET online=:online WHERE email=:uid");
			$stmt->bindparam(":uid",$id);
			$stmt->bindparam(":online",$online);
			$stmt->execute();

		session_destroy();
		$_SESSION['userSession'] = false;
	}

	function send_mail($email,$message,$subject)
	{
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug  = 1;
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       = 465;
		$mail->AddAddress($email);
		$mail->Username="bernandmalmass@gmail.com";
		$mail->Password="B3rnando";
		$mail->SetFrom('bernandmalmass@gmail.com','Coding Cage');
		$mail->AddReplyTo("bernandmalmass@gmail.com","Coding Cage");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}

	function checkbrute($email) {
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 5 minutes
    $valid_attempts = $now - (5 * 60);


    if ($stmt = $this->conn->prepare("SELECT time
                             FROM login_attempts
                             WHERE email = :email
                            AND time > '$valid_attempts'")) {
     $stmt->execute(array(":email"=>$email));
     $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

        // If there have been more than 5 failed logins
        if ($stmt->rowCount() >= 5) {
            	header("Location: login.php?bruteforce");
						exit;
        } else {
            return false;
        }
    }
}

public function waktu_lalu($timestamp)
{
    $selisih = time() - strtotime($timestamp) ;
 
    $detik = $selisih ;
    $menit = round($selisih / 60 );
    $jam = round($selisih / 3600 );
    $hari = round($selisih / 86400 );
    $minggu = round($selisih / 604800 );
    $bulan = round($selisih / 2419200 );
    $tahun = round($selisih / 29030400 );
 
    if ($detik <= 60) {
        $waktu = $detik.' detik yang lalu';
    } else if ($menit <= 60) {
        $waktu = $menit.' menit yang lalu';
    } else if ($jam <= 24) {
        $waktu = $jam.' jam yang lalu';
    } else if ($hari <= 7) {
        $waktu = $hari.' hari yang lalu';
    } else if ($minggu <= 4) {
        $waktu = $minggu.' minggu yang lalu';
    } else if ($bulan <= 12) {
        $waktu = $bulan.' bulan yang lalu';
    } else {
        $waktu = $tahun.' tahun yang lalu';
    }
    
    return $waktu;
}
}