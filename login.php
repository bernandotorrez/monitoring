<!DOCTYPE html>
<?php
session_start();
error_reporting(0);
require_once 'class.user.php';
include 'config/library.php';
$user_login = new USER();


if($user_login->is_logged_in()!="")
{
	$user_login->redirect('index.php');
}

if(isset($_POST['btn-login']))
{
	$email = aman($_POST['email']);
	$upass = aman($_POST['password']);

	if($user_login->login($email,$upass))
	{
		$user_login->redirect('index.php');
	}
}

if(isset($_POST['btn-login']))
{
	$email = aman($_POST['email']);
	$stmt = $user_login->runQuery("SELECT * FROM login WHERE email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$email));
$cek = $stmt->fetch(PDO::FETCH_ASSOC);

if($cek['level'] != 'Owner'){
	$email = aman($_POST['email']);
	$stmt = $user_login->runQuery("SELECT * FROM login, pegawai WHERE login.email=:uid and pegawai.email=:uid LIMIT 1");
	$stmt->execute(array(":uid"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$euname = $row['nama_pegawai'];
} else {
	$email = aman($_POST['email']);
	$stmt = $user_login->runQuery("SELECT * FROM login, owner WHERE login.email=:uid and owner.email=:uid LIMIT 1");
	$stmt->execute(array(":uid"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$euname = $row['nama_pegawai'];
}

	$online = aman("on");
	$nip = $row['nip'];
	$keterangan = aman("Melakukan Log In");
	
	if($user_login->online($email,$online,$nip,$email,$euname,$keterangan))
	{

	}
}


if(isset($_POST['btn-forgot']))
{
	$fpemail = aman($_POST['email']);

	$stmt = $user_login->runQuery("SELECT * FROM login WHERE email=:email LIMIT 1");
	$stmt->execute(array(":email"=>$fpemail));
	$a= $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($a['level'] != "Owner" ) {
		$stmt = $user_login->runQuery("SELECT * FROM login, pegawai WHERE login.email=:email AND pegawai.email=:email LIMIT 1");
	$stmt->execute(array(":email"=>$fpemail));
	$forgot= $stmt->fetch(PDO::FETCH_ASSOC);
	$username_mail = $forgot['nama_pegawai'];
	} else {
	$stmt = $user_login->runQuery("SELECT * FROM login, owner WHERE login.email=:email AND owner.email=:email LIMIT 1");
	$stmt->execute(array(":email"=>$fpemail));
	$forgot= $stmt->fetch(PDO::FETCH_ASSOC);
	$username_mail = $forgot['nama_owner'];
	}
	
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($forgot['email']);
		$passkey = md5(uniqid(rand()));
		
		$stmt = $user_login->runQuery("UPDATE login SET passkey=:passkey WHERE email=:email");
		$stmt->execute(array(":passkey"=>$passkey,"email"=>$fpemail));
        $sender_name = 'Project Monitoring Mailer';
		$nama_admin="Admin Sistem Monitoring Proyek PT. Malmass Mitra Teknik";
$email_admin="mailer@project-monitoring.online";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'To: '.$username_mail.'<'.$fpemail.'>'. "\r\n";
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
    <table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="center">Permintaan Lupa Password</td></tr></tbody></table>
    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px; align: center" align="center">
      <b style="color: #777777;">Kepada YTH  <font color="#428bca">'.$username_mail.'</b></font>
      <br><br>
     Agar dapat membuat password yang baru, silahkan klik link lupa password di bawah ini.
    </div>
  </td></tr></tbody></table>
</td></tr></tbody></table>
    
<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
  <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
     <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
      <a href="https://project-monitoring.online/resetpass.php?id='.$id.'&passkey='.$passkey.'#verifikasi" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; Ganti Password &nbsp;</a>
    </div>
    <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
  </td></tr></tbody></table>
</td></tr></tbody></table>

<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
  <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
   <br><font color="#dd5a43">Dari : '.$nama_admin.'</font><br><font color="#dd5a43">Email : '.$email_admin.'</font><br>
      <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;">PT. Malmass Mitra Teknik - Bernand D H &copy; 2017</a>
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
$send = mail($fpemail,"Permintaan Lupa Password", $pesan, $headers);

			header("Location: login.php?lupapasssukses");
					exit;
		}
		else
		{
			header("Location: login.php?gagal");
					exit;
		}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Halaman Login - PT. Malmass Mitra Teknik</title>

		<meta name="description" content="User Halaman Login" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
	
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
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
									<span class="red">Login</span>
									<span class="white" id="id-text2">Sistem Monitoring Proyek</span>
								</h1>
								<h4 class="blue" id="id-company-text">&copy;  PT. Malmass Mitra Teknik & Bernand D H</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
										<?php
		if(isset($_GET['inactive']))
		{
			?><center>
            <div class='alert alert-info'>

				<strong>Maaf!</strong> Akun Ini Belum Di Verifikasi, Cek Inbox Email Anda.
			</div></center>
            <?php
		}
		?>
		<?php
		if(isset($_GET['error']))
{
	?>
				<center><div class="alert alert-danger">
	<strong>Email </strong>atau <strong>Password</strong> anda salah!	</div></center>
				<?php
}

?>
		<?php
		if(isset($_GET['bruteforce']))
{
	?>
				<center><div class="alert alert-danger">
	<strong>Maaf!</strong> Anda gagal login lebih dari 5 kali, Untuk masalah keamanan, akun ini di Lock selama 5 menit. </div></center>
				<?php
}

?>
<?php
if(isset($_GET['lupapasssukses']))
{
	?><center>
				<div class='alert alert-success'>

		Permintaan Lupa Password Anda di Terima, Silahkan Cek Inbox Email Anda.
	</div></center>
				<?php
}
?>
	<?php
if(isset($_GET['gagal']))
{
	?><center>
				<div class='alert alert-danger'>

		Permintaan tidak dapat dilakukan.
	</div></center>
				<?php
}
?>
        


											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Silahkan Login
											</h4>

											<div class="space-6"></div>

											<form class="form-signin" id="validation-form" action="" method="post">
												<fieldset>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="email" placeholder="Email" class="form-control" name="email" id="email" class="" autofocus="" />
																		</div>
																		<i class="ace-icon fa fa-envelope"></i>
														</span></label>
																	</div>
																
															
															<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="password" placeholder="Password" class="form-control" name="password" id="password" class="" />
																		</div>
																		<i class="ace-icon fa fa-lock"></i>
														</span></label>
																	</div>
									<div class="space-4"></div>




													<div class="clearfix">
														

														<button id="loading-btn" type="submit" class="width-35 pull-right btn btn-sm btn-primary" data-last="Finish" data-loading-text="Logging In..." name="btn-login">
													
											
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													
													<div class="space-4"></div>
												</fieldset>
											</form>

										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													Lupa Password?
												</a>
											</div>

											<div><?php if($row['level'] == 'Admin') { ?>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													I want to register
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
												<?php } ?>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Lupa Password
											</h4>

											<div class="space-6"></div>
											<p>
												Masukkan Email Anda.
											</p>

											<form class="form-signin" id="validation-form1" action="" method="post">
												<fieldset>
												<div class="form-group">
																<label class="block clearfix">
														<span class="block input-icon input-icon-right">
																
																	<div class="clearfix">
																		<input type="email" class="form-control" placeholder="Email Anda" name="email" id="email" class="" />
																		</div>
																		<i class="ace-icon fa fa-envelope-o"></i>
														</span></label>
																	</div>
													<div class="form-group">
													<div class="clearfix">
														<button id="loading-btn1" type="submit" class="width-35 pull-right btn btn-sm btn-danger" data-last="Finish" data-loading-text="Mengirim..." name="btn-forgot">
													
											
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Kirim</span>
														</button>
													</div>
													<div class="form-group">
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Kembali Ke Halaman Login
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



		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<script type="text/javascript">
			jQuery(function($) {


				$('#validation-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						email: {
							required: true,
							minlength: 8,
							email:true
						},
						email1: {
							required: true,
							minlength: 8,
							email:true
						},
						password: {
							required: true,
							minlength: 8
						
						}
					},

					messages: {
						email: {
							required: "Masukkan Email.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						email1: {
							required: "Masukkan Email.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						password: {
							required: "Masukkan Password.",
							minlength: "Minimal 8 Karakter."
						},
						state: "Please choose state",
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


				$('#validation-form1').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: true,
					ignore: "",
					rules: {
						email: {
							required: true,
							minlength: 8,
							email:true
						},
						email1: {
							required: true,
							minlength: 8,
							email:true
						},
						password: {
							required: true,
							minlength: 8
						
						}
					},
					messages: {
						email: {
							required: "Masukkan Email Anda.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						email1: {
							required: "Masukkan Email Anda.",
							minlength: "Minimal 8 Karakter.",
							email: "Email Tidak Valid."
						},
						password: {
							required: "Masukkan Password Anda.",
							minlength: "Password Minimal 8 Karakter."
						},
						state: "Please choose state",
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