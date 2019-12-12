<!DOCTYPE html>
<?php
session_start();
error_reporting(1);
    include "config/library.php";

require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('login.php');
}


$id1 = $_SESSION['userSession'];
$stmt = $user_home->runQuery("SELECT * FROM login WHERE email=:uid");
$stmt->execute(array(":uid"=>$id1));
$a = $stmt->fetch(PDO::FETCH_ASSOC);



if($a['level'] != 'Admin') {
$user_home->redirect('index.php');
}


if(isset($_POST['btn-pegawai']))
{
	$nip = aman($_POST['nip']);
	$remail = aman($_POST['email']);
	$nama = aman($_POST['nama']);
	$alamat = aman($_POST['alamat']);
	$hp = aman($_POST['hp']);
	$jk = aman($_POST['jk']);
	$agama = aman($_POST['agama']);
	$tempat = aman($_POST['tempat']);
	$tgl = aman($_POST['tgl']);
	$pernikahan = aman($_POST['pernikahan']);
	$bidang = aman($_POST['bidang']);
	$jabatan = aman($_POST['jabatan']);
	$password = aman($_POST['password']);
	$passkey = md5(uniqid(rand()));

	$stmt = $user_home->runQuery("SELECT * FROM login, pegawai WHERE login.email=:user_mail OR pegawai.nip=:nip");
	$stmt->execute(array(":user_mail"=>$remail,":nip"=>$nip));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($stmt->rowCount() > 0)
	{
		header("Location: daftar.php?sudahada");
		exit;
	}
	else
	{
		if($user_home->register($nip,$remail,$nama,$alamat,$hp,$jk,$agama,$tempat,$tgl,$pernikahan,$bidang,$jabatan,$password,$passkey))
		{
			
			$key = base64_encode($remail);
			$id = $key;
$nama_admin="Admin Sistem Monitoring Proyek PT. Malmass Mitra Teknik";
$email_admin="mailer@project-monitoring.online";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'To: '.$remail.'<'.$remail.'>'. "\r\n";
$headers .= 'From: '.$email_admin.''. "\r\n";

$pesan .='<!doctype html>
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title></title>
  <style type="text/css">
 	body {
		width: 100%;
		margin: 0;
		padding: 0;
		-webkit-font-smoothing: antialiased;
	}
	@media only screen and (max-width: 600px) {
		table[class="table-row"] {
			float: none !important;
			width: 98% !important;
			padding-left: 20px !important;
			padding-right: 20px !important;
		}
		table[class="table-row-fixed"] {
			float: none !important;
			width: 98% !important;
		}
		table[class="table-col"], table[class="table-col-border"] {
			float: none !important;
			width: 100% !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
			table-layout: fixed;
		}
		td[class="table-col-td"] {
			width: 100% !important;
		}
		table[class="table-col-border"] + table[class="table-col-border"] {
			padding-top: 12px;
			margin-top: 12px;
			border-top: 1px solid #E8E8E8;
		}
		table[class="table-col"] + table[class="table-col"] {
			margin-top: 15px;
		}
		td[class="table-row-td"] {
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		table[class="navbar-row"] , td[class="navbar-row-td"] {
			width: 100% !important;
		}
		img {
			max-width: 100% !important;
			display: inline !important;
		}
		img[class="pull-right"] {
			float: right;
			margin-left: 11px;
            max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		img[class="pull-left"] {
			float: left;
			margin-right: 11px;
			max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		table[class="table-space"], table[class="header-row"] {
			float: none !important;
			width: 98% !important;
		}
		td[class="header-row-td"] {
			width: 100% !important;
		}
	}
	@media only screen and (max-width: 480px) {
		table[class="table-row"] {
			padding-left: 16px !important;
			padding-right: 16px !important;
		}
	}
	@media only screen and (max-width: 320px) {
		table[class="table-row"] {
			padding-left: 12px !important;
			padding-right: 12px !important;
		}
	}
	@media only screen and (max-width: 458px) {
		td[class="table-td-wrap"] {
			width: 100% !important;
		}
	}
  </style>
 </head>
 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
 <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
 <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
<table><tr><td class="table-td-wrap" align="center" width="458"><table class="table-space" height="18" style="height: 18px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="18" style="height: 18px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
  <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
    <table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="center">Selamat Datang di Sistem Monitoring Proyek PT. Malmass Mitra Teknik</td></tr></tbody></table>
    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px; align: center" align="center">
      <b style="color: #777777;">Kepada YTH '.$remail.'</b>
      <br><br>
      Agar dapat login dan memanfaatkan layanan kami, silahkan klik link verifikasi berikut ini dan Password sementara anda adalah <b><font color="#478fca">'.$password.'</font></b>. anda dapat mengubah Password anda nanti.
    </div>
  </td></tr></tbody></table>
</td></tr></tbody></table>
    
<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
  <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
    <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
      <a href="https://project-monitoring.online/verifikasi.php?id='.$id.'&passkey='.$passkey.'#verifikasi" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; Verifikasi Akun &nbsp;</a>
    </div>
    <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
  </td></tr></tbody></table>
</td></tr></tbody></table>

<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
  <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
   <br><font color="#dd5a43">Dari : '.$nama_admin.'</font><br><font color="#dd5a43">Email : '.$email_admin.'</font><br>
      <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;">Ace &copy; 2014</a>
      <br>
      <a href="#" style="color: #478fca; text-decoration: none; background-color: transparent;">twitter</a>
      .
      <a href="#" style="color: #5b7a91; text-decoration: none; background-color: transparent;">facebook</a>
      .
      <a href="#" style="color: #dd5a43; text-decoration: none; background-color: transparent;">google+</a>
    </td></tr></tbody></table>
  </td></tr></tbody></table>
</td></tr></tbody></table>
<table class="table-space" height="1" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="1" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="36" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="36" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
</td></tr>
 </table>
 </body>
 </html>';

$send = mail($remail,"Verifikasi Email Anda", $pesan, $headers);

			header("Location: daftar.php?daftarsukses");
					exit;
		}
		else
		{
			header("Location: daftar.php?gagal");
					exit;
		}
	}
}

if(isset($_POST['btn-owner']))
{
	$nip = aman($_POST['owner']);
	$remail = aman($_POST['email']);
	$nama = aman($_POST['nama']);
	$alamat = aman($_POST['alamat']);
	$hp = aman($_POST['hp']);
	$password = aman($_POST['opassword']);
	$passkey = md5(uniqid(rand()));
	$jabatan = aman("Owner");
	$stmt = $user_home->runQuery("SELECT * FROM login, owner WHERE login.email=:user_mail OR owner.id_owner=:nip");
	$stmt->execute(array(":user_mail"=>$remail,":nip"=>$nip));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($stmt->rowCount() > 0)
	{
		header("Location: daftar.php?sudahada");
		exit;
	}
	else
	{
		if($user_home->register_owner($nip,$remail,$nama,$alamat,$hp,$jabatan,$password,$passkey))
		{
			
			$key = base64_encode($remail);
			$id = $key;
$nama_admin="Admin Sistem Monitoring Proyek PT. Malmass Mitra Teknik";
$email_admin="mailer@project-monitoring.online";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'To: '.$remail.'<'.$remail.'>'. "\r\n";
$headers .= 'From: '.$email_admin.''. "\r\n";

$pesan .='<!doctype html>
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title></title>
  <style type="text/css">
 	body {
		width: 100%;
		margin: 0;
		padding: 0;
		-webkit-font-smoothing: antialiased;
	}
	@media only screen and (max-width: 600px) {
		table[class="table-row"] {
			float: none !important;
			width: 98% !important;
			padding-left: 20px !important;
			padding-right: 20px !important;
		}
		table[class="table-row-fixed"] {
			float: none !important;
			width: 98% !important;
		}
		table[class="table-col"], table[class="table-col-border"] {
			float: none !important;
			width: 100% !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
			table-layout: fixed;
		}
		td[class="table-col-td"] {
			width: 100% !important;
		}
		table[class="table-col-border"] + table[class="table-col-border"] {
			padding-top: 12px;
			margin-top: 12px;
			border-top: 1px solid #E8E8E8;
		}
		table[class="table-col"] + table[class="table-col"] {
			margin-top: 15px;
		}
		td[class="table-row-td"] {
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		table[class="navbar-row"] , td[class="navbar-row-td"] {
			width: 100% !important;
		}
		img {
			max-width: 100% !important;
			display: inline !important;
		}
		img[class="pull-right"] {
			float: right;
			margin-left: 11px;
            max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		img[class="pull-left"] {
			float: left;
			margin-right: 11px;
			max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		table[class="table-space"], table[class="header-row"] {
			float: none !important;
			width: 98% !important;
		}
		td[class="header-row-td"] {
			width: 100% !important;
		}
	}
	@media only screen and (max-width: 480px) {
		table[class="table-row"] {
			padding-left: 16px !important;
			padding-right: 16px !important;
		}
	}
	@media only screen and (max-width: 320px) {
		table[class="table-row"] {
			padding-left: 12px !important;
			padding-right: 12px !important;
		}
	}
	@media only screen and (max-width: 458px) {
		td[class="table-td-wrap"] {
			width: 100% !important;
		}
	}
  </style>
 </head>
 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
 <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
 <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
<table><tr><td class="table-td-wrap" align="center" width="458"><table class="table-space" height="18" style="height: 18px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="18" style="height: 18px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
  <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
    <table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="center">Selamat Datang di Sistem Monitoring Proyek PT. Malmass Mitra Teknik</td></tr></tbody></table>
    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px; align: center" align="center">
      <b style="color: #777777;">Kepada YTH '.$remail.'</b>
      <br><br>
      Agar dapat login dan memanfaatkan layanan kami, silahkan klik link verifikasi berikut ini dan Password sementara anda adalah <b><font color="#478fca">'.$password.'</font></b>. anda dapat mengubah Password anda nanti.
    </div>
  </td></tr></tbody></table>
</td></tr></tbody></table>
    
<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
  <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
    <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
      <a href="https://project-monitoring.online/verifikasi.php?id='.$id.'&passkey='.$passkey.'#verifikasi" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; Verifikasi Akun &nbsp;</a>
    </div>
    <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
  </td></tr></tbody></table>
</td></tr></tbody></table>

<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
  <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
   <br><font color="#dd5a43">Dari : '.$nama_admin.'</font><br><font color="#dd5a43">Email : '.$email_admin.'</font><br>
      <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;">Ace &copy; 2014</a>
      <br>
      <a href="#" style="color: #478fca; text-decoration: none; background-color: transparent;">twitter</a>
      .
      <a href="#" style="color: #5b7a91; text-decoration: none; background-color: transparent;">facebook</a>
      .
      <a href="#" style="color: #dd5a43; text-decoration: none; background-color: transparent;">google+</a>
    </td></tr></tbody></table>
  </td></tr></tbody></table>
</td></tr></tbody></table>
<table class="table-space" height="1" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="1" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="36" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="36" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
</td></tr>
 </table>
 </body>
 </html>';

$send = mail($remail,"Verifikasi Email Anda", $pesan, $headers);

			header("Location: daftar.php?daftarsukses");
					exit;
		}
		else
		{
			header("Location: daftar.php?gagal");
					exit;
		}
	}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Halaman Daftar Akun - PT. Malmass Mitra Teknik</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
			<link rel="stylesheet" href="assets/css/mouse.css" />
		<?php
		include 'favicon.php';
		?>
		<!-- page specific plugin styles -->


		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet">

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->


		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-leaf green"></i>
									<span class="red">Daftar Akun</span>
									<span class="white" id="id-text2">Sistem Monitoring</span>
								</h1>
								<h4 class="blue" id="id-company-text">&copy;  PT. Malmass Mitra Teknik & Bernand D H</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
										<?php
if(isset($_GET['daftarsukses']))
{
	?><center>
				<div class='alert alert-success'>

		<strong>Selamat!</strong> Pendaftaran Berhasil.
	</div></center>
				<?php
}
?>
<?php
if(isset($_GET['sudahada']))
{
	?><center>
				<div class='alert alert-danger'>

		<strong>Email</strong> Atau <strong>NIP</strong> Atau <strong>ID Owner</strong> Sudah Digunakan 
	</div></center>
				<?php
}
?>

	<?php
if(isset($_GET['gagal']))
{
	?><center>
				<div class='alert alert-danger'>

		<strong>Permintaan tidak bisa dilakukan. </strong>
	</div></center>
				<?php
}
?>
        <h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Daftar Akun Pegawai
											</h4>

											<div class="space-6"></div>

											<form class="form-signin" id="validation-form" action="" method="post">
												<fieldset>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="input-mask-phone form-control" placeholder="NIP"  name="nip" id="nip" autocomplete="off" autofocus="on"/>
																		</div>
																		<i class="ace-icon fa fa-user"></i>
														</span></label>
																	</div>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="email" placeholder="Email" class="form-control" name="email" id="email" class="" autocomplete="off" />
																		</div>
																		<i class="ace-icon fa fa-envelope"></i>
														</span></label>
																	</div>
																
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="form-control" placeholder="Nama Pegawai"  name="nama" id="nama"/>
																		</div>
																		<i class="ace-icon fa fa-user"></i>
														</span></label>
																	</div>	
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="form-control" placeholder="Alamat Pegawai"  name="alamat" id="alamat"/>
																		</div>
																		<i class="ace-icon fa fa-map-marker"></i>
														</span></label>
																	</div>	
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="input-mask-hp form-control" placeholder="No HP"  name="hp" id="hp"/>
																		</div>
																		<i class="ace-icon fa fa-phone"></i>
														</span></label>
																	</div>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<select name="jk" id="jk" class="form-control">
																	<option value="">Jenis Kelamin</option>
											<option value="Laki - Laki">Laki - Laki</option>
											<option value="Perempuan" >Perempuan</option>
											

										</select>
																		
														</span></label>
																	</div>
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<select name="agama" id="agama" class="form-control">
																	<option value="">Agama</option>
																		<option value="">Agama</option>
											<option value="Islam" >Islam</option>
											<option value="Kristen" >Kristen</option>
											<option value="Hindu">Hindu</option>
											<option value="Buddha" >Buddha</option>
											

										</select>
																		
														</span></label>
																	</div>
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="form-control" placeholder="Tempat Lahir"  name="tempat" id="tempat"/>
																		</div>
																		<i class="ace-icon fa fa-map-marker"></i>
														</span></label>
																	</div>	
											<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input class="input-medium datepicker form-control" id="datepicker" type="text" data-date-format="yyyy-mm-dd" name="tgl" id="tgl" placeholder="yyyy-mm-dd" data-provide="datepicker"/>
																		</div>
																		<i class="ace-icon fa fa-user"></i>
														</span></label>
																	</div>	
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<select name="pernikahan" id="pernikahan" class="form-control">
																	<option value="">Status Pernikahan</option>
											<option value="Menikah">Menikah</option>
											<option value="Belum Menikah" >Belum Menikah</option>
											

										</select>
																		
														</span></label>
																	</div>
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<select name="bidang" id="bidang" class="form-control">
																	<option value="">Bidang</option>
											<option value="Mechanical">Mechanical</option>
											<option value="Electrical" >Electrical</option>
											

										</select>
																		
														</span></label>
																	</div>
															<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="password" placeholder="Password" class="form-control" name="password" id="password" class="" autocomplete="off"/>
																		</div>
																		<i class="ace-icon fa fa-lock"></i>
														</span></label>
																	</div>
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="password" placeholder="Konfirmasi Password" class="form-control" name="cpassword" id="cpassword" class="" autocomplete="off"/>
																		</div>
																		<i class="ace-icon fa fa-lock"></i>
														</span></label>
																	</div>
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<select name="jabatan" class="form-control" id="jabatan" required="">
						      <option value="" selected>Jabatan</option>
									<?php
									
									$stmt = $user_home->runQuery("SELECT * FROM jabatan");
									$stmt->execute();

						       while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nama_jabatan]>$row[nama_jabatan]</option>";
						      }
									?>
								</select>
														</span></label>
																	</div>
									<div class="space-4"></div>
<div class="space-24"></div>
							<?php if($a['level'] ==  'Admin') {  ?>
							<div class="clearfix">
								<button type="reset" id="loading-btn1" data-loading-text="Mereset..." class="width-30 pull-left btn btn-sm">
									<i class="ace-icon fa fa-refresh"></i>
									<span class="bigger-110">Reset</span>
								</button>

								<button type="submit" id="loading-btn" data-loading-text="Mendaftar..." class="width-65 pull-right btn btn-sm btn-success" name="btn-pegawai">
									<span class="bigger-110">Daftar</span>

									<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
								</button>
								<?php } else { ?>
								<?php } ?>

							</div>
						</fieldset>
											</form>

										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													Daftar Akun Owner
												</a>
											</div>

											
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Daftar Akun Owner
											</h4>

											<div class="space-6"></div>
										

											<form class="form-signin" id="validation-form1" action="" method="post">
												<fieldset>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="input-mask-owner form-control" placeholder="Id Owner"  name="owner" id="owner" autocomplete="off" autofocus="on" />
																		</div>
																		<i class="ace-icon fa fa-user"></i>
														</span></label>
																	</div>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="email" placeholder="Email" class="form-control" name="email" id="email" class="" autocomplete="off" />
																		</div>
																		<i class="ace-icon fa fa-envelope"></i>
														</span></label>
																	</div>
																
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" placeholder="Nama Owner" class="form-control" name="nama" id="nama" class="" autocomplete="off" />
																		</div>
																		<i class="ace-icon fa fa-user"></i>
														</span></label>
																	</div>
																
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" placeholder="Alamat" class="form-control" name="alamat" id="alamat" class=""  />
																		</div>
																		<i class="ace-icon fa fa-map-marker"></i>
														</span></label>
										
														<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="text" class="input-mask-hp form-control" placeholder="No HP"  name="hp" id="hp"/>
																		</div>
																		<i class="ace-icon fa fa-phone"></i>
														</span></label>
																	</div>
															<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="password" placeholder="Password" class="form-control" name="opassword" id="opassword" class="" autocomplete="off"/>
																		</div>
																		<i class="ace-icon fa fa-lock"></i>
														</span></label>
																	</div>
																	<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="password" placeholder="Konfirmasi Password" class="form-control" name="copassword" id="copassword" class="" autocomplete="off"/>
																		</div>
																		<i class="ace-icon fa fa-lock"></i>
														</span></label>
																	</div>
																	
									<div class="space-4"></div>
<div class="space-24"></div>
							<?php if($a['level'] == 'Admin') {  ?>
							<div class="clearfix">
								<button type="reset" id="loading-btn2" data-loading-text="Mereset..." class="width-30 pull-left btn btn-sm">
									<i class="ace-icon fa fa-refresh"></i>
									<span class="bigger-110">Reset</span>
								</button>

								<button type="submit" id="loading-btn3" data-loading-text="Mendaftar..." class="width-65 pull-right btn btn-sm btn-success" name="btn-owner">
									<span class="bigger-110">Daftar</span>

									<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
								</button>
								<?php } else { ?>
								<?php } ?>

							</div>
						</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Daftar Akun Pegawai
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->


							</div><!-- /.position-relative -->

							<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Dark</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Blur</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Light</a>
								&nbsp; &nbsp; &nbsp;
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="assets/js/jquery.validate.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

				<script src="assets/js/jquery.maskedinput.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<script>
		jQuery(function($) {

				$( "#datepicker" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: false,
					//isRTL:true,


					/*
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,
					beforeShow: function() {
						//change button colors
						var datepicker = $(this).datepicker( "widget" );
						setTimeout(function(){
							var buttons = datepicker.find('.ui-datepicker-buttonpane')
							.find('button');
							buttons.eq(0).addClass('btn btn-xs');
							buttons.eq(1).addClass('btn btn-xs btn-success');
							buttons.wrapInner('<span class="bigger-110" />');
						}, 0);
					}
			*/
				});
				$( "#datepicker1" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: false,
					//isRTL:true,


					/*
					changeMonth: true,
					changeYear: true,

					showButtonPanel: true,
					beforeShow: function() {
						//change button colors
						var datepicker = $(this).datepicker( "widget" );
						setTimeout(function(){
							var buttons = datepicker.find('.ui-datepicker-buttonpane')
							.find('button');
							buttons.eq(0).addClass('btn btn-xs');
							buttons.eq(1).addClass('btn btn-xs btn-success');
							buttons.wrapInner('<span class="bigger-110" />');
						}, 0);
					}
			*/
				});
				});
				</script>
		<script type="text/javascript">
			jQuery(function($) {

				$('.input-mask-phone').mask('99999999999999');
				$.mask.definitions['~']='[+-]';
				$('#nip').mask('99999999999999');
			
				$('.input-mask-hp').mask('(9999) 9999-9999');
				$.mask.definitions['~']='[+-]';
				$('#hp').mask('(9999) 9999-9999');
			
				$('#validation-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						nip: {
							required: true,
							minlength: 10
						},
						email: {
							required: true,
							minlength: 8,
							email:true
						},
						
						jabatan: {
							required: true
						},
						nama: {
							required: true,
							minlength: 8,
							maxlength: 50
						},
						alamat: {
							required: true,
							minlength: 10,
							maxlength: 250
						},
						hp: {
							required: true,
							minlength: 10,
							
							maxlength: 16
						},

						jk: {
							required: true,
						},
						agama: {
							required: true
						},
						tempat: {
							required: true,
							minlength: 5,
							maxlength: 25
						},
						tgl: {
							required: true
						},
						pernikahan: {
							required: true
						},
						bidang: {
							required: true
						},
						password: {
							required: true,
							minlength: 8
						},
						cpassword: {
							required: true,
							minlength: 8,
							equalTo: "#password"
						
						}
					},

					messages: {
						nip: {
							required: "Masukkan NIP, contoh : 12191095111701",
							minlength: "Minimal 14 Karakter."
						},
						email: {
							required: "Masukkan Email.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						
						password: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						cpassword: {
							required: "Masukkan Konfirmasi Password.",
							minlength: "Minimal 8 Karakter.",
							equalTo: "Password tidak cocok"
						},
						hp: {
							required: "Masukkan Nomor Telepon.",
							minlength: "Minimal 10 Karakter.",
							maxlength: "Maximal 16 Karakter."
						},
						tempat: {
							required: "Masukkan Tempat Lahir.",
							minlength: "Minimal 5 Karakter.",
							maxlength: "Maximal 25 Karakter."
						},
						alamat: {
							required: "Masukkan Alamat.",
							minlength: "Minimal 10 Karakter.",
							maxlength: "Maximal 250 Karakter."
						},
						jabatan: "Pilih Jabatan",
						tgl: "Masukkan Tanggal Lahir",
						bidang: "Masukkan Bidang Disiplin",
						agama: "Isi Agama Anda",
						jk: "Pilih Jenis Kelamin",

						pernikahan: "Pilih Status Pernikahan"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});


				$('.input-mask-owner').mask('9999999999999');
				$.mask.definitions['~']='[+-]';
				$('#owner').mask('9999999999999');
			
			
				$('#validation-form1').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						owner: {
							required: true,
							minlength: 6
						},
						email: {
							required: true,
							minlength: 8,
							email:true
						},
						
						jabatan: {
							required: true
						},
						opassword: {
							required: true,
							minlength: 8
						},
						copassword: {
							required: true,
							minlength: 8,
							equalTo: "#opassword"
						
						}
					},

					messages: {
						owner: {
							required: "Masukkan id owner, contoh : 1011510173001",
							minlength: "Minimal 13 Karakter."
						},
						email: {
							required: "Masukkan Email.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						
						opassword: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						copassword: {
							required: "Masukkan Konfirmasi Password.",
							minlength: "Minimal 8 Karakter.",
							equalTo: "Password tidak cocok"
						},
						jabatan: "Pilih Jabatan",
						subscription: "Please choose at least one option",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},


					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},

					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},

					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					}

				});
				/**
				$('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
					$(this).closest('form').validate().element($(this));
				});

				$('#mychosen').chosen().on('change', function(ev) {
					$(this).closest('form').validate().element($(this));
				});
				*/



			})
		</script>
<script type="text/javascript">
			jQuery(function($) {
				$('#loading-btn').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 2000)
				});

				$('#loading-btn1').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 2000)
				});

				$('#loading-btn2').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 2000)
				});

				$('#loading-btn3').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 2000)
				});
				$('#id-button-borders').attr('checked' , 'checked').on('click', function(){
					$('#default-buttons .btn').toggleClass('no-border');
				});
			})
		</script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});



			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');

				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');

				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');

				e.preventDefault();
			 });

			});
		</script>
		
	</body>
</html>