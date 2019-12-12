<?php
session_start();
require_once 'class.user.php';
include 'config/library.php';
$user = new USER();

if(!$user->is_logged_in())
{
	$user->redirect('login.php');
}


if($user->is_logged_in()!="")
{
	$id = $_SESSION['userSession'];
	$stmt = $user->runQuery("SELECT * FROM login WHERE email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$cek = $stmt->fetch(PDO::FETCH_ASSOC);

if($cek['level'] != 'Owner'){
	$stmt = $user->runQuery("SELECT * FROM login, pegawai WHERE login.email=:uid and pegawai.email=:uid LIMIT 1");
	$stmt->execute(array(":uid"=>$id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$euname = $row['nama_pegawai'];
		
} else {
	
}
	$online = "off";
	
$nip = $row['nip'];
	$keterangan = aman("Melakukan Log Out");
	
	if($cek['level'] != "Owner") {
		$user->logout($id,$online,$nip,$euname,$keterangan,$level);

	$user->redirect('login.php');
} else {
	$user->logout_owner($id,$online);

	$user->redirect('login.php');
}
	
}
?>
