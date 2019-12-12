<!DOCTYPE html>
<?php

error_reporting(0);
  session_start();
    include "config/library.php";

  include "config/fungsi_autolink.php";
require_once 'class.user.php';

$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('login.php');
}
$stmt = $user_home->runQuery("SELECT * FROM login WHERE email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$b = $stmt->fetch(PDO::FETCH_ASSOC);

if($b['level'] != 'Owner') {

$stmt = $user_home->runQuery("SELECT * FROM login, pegawai WHERE login.email=:uid and pegawai.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$menu = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	$stmt = $user_home->runQuery("SELECT * FROM login, owner WHERE login.email=:uid and owner.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$menu = $stmt->fetch(PDO::FETCH_ASSOC);
}
if($menu['level'] == 'Admin')
{
	$user_home->redirect('index.php');
}
if($_GET['id'] != ''){

$id1 = aman($_GET['id']);
$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical INNER JOIN detailproyek_mechanical ON detailproyek_electrical.id_detailproyek=detailproyek_mechanical.id_detailproyek WHERE detailproyek_electrical.id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id1));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($stmt->rowCount() == 0)
{
	header("Location: proyek.php?aksi=tidakditemukan");
				exit;
}

} else {

$user_home->redirect('daftarproyek.php');

}


if(isset($_POST['btn-edit']))
{

	$euname = aman($_POST['euname']);
	$email = $row['email'];
	$password = aman($_POST['password']);
	$alamat = aman($_POST['alamat']);
	$hp = aman($_POST['hp']);
	$jk = aman($_POST['jk']);
	$agama = aman($_POST['agama']);
	$tempat = aman($_POST['tempat']);
	$tgl = aman($_POST['tgl']);
	$status = aman($_POST['status']);
	$bidang = aman($_POST['bidang']);
	$jabatan = $row['level'];
	$pass = md5($password);
	$cpassword = $row['password'];
	$id = $_SESSION['userSession'];
	$profil = aman("sudah");
	$wa = aman($_POST['whatsapp']);
	$facebook = aman($_POST['url']);
  $nip = $row['nip'];
  $keterangan = aman("Mengubah Biodata");
  $foto = $row['foto'];
			if($cpassword!==$pass){

				header("Location: proyek.php?aksi=passgagal");
				exit;
			}
	elseif($user_home->edit_proyek($euname,$alamat,$hp,$jk,$agama,$tempat,$tgl,$status,$bidang,$jabatan,$profil,$id,$nip,$keterangan,$foto,$wa,$facebook))

	{

	header("Location: proyek.php?aksi=editsukses");
	exit;


}
}

if(isset($_FILES['fileToUpload'])){
	$idfoto = $row['nip'];

	$euname = $row['nama_proyek'];
	$email = $row['email'];
  $keterangan = aman("Mengubah Foto");
				$target_dir = "avatar/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-ubahfoto"])) {
					$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
					if($check !== false) {
					$uploadOk = 1;
					} else {
						header("Location: proyek.php?aksi=bukangambar");

						exit;
					}
				}

				if ($_FILES["fileToUpload"]["size"] > 200000) {
					header("Location: proyek.php?aksi=terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF"){
					header("Location: proyek.php?aksi=ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$foto = $new_id;
							$id = $_SESSION['userSession'];
						if($user_home->foto_proyek($foto,$id,$idfoto,$euname,$keterangan)){
								header("Location: proyek.php?aksi=editsukses");
								exit;
						}
					} else {
						header("Location: proyek.php?aksi=gagalupload");

						exit;
					}

			}

if(isset($_POST['btn-ubah']))
{

	$password = aman($_POST['ubahpass']);
	$passwordbaru = aman($_POST['passbaru']);
	$konpassbaru = aman($_POST['konpassbaru']);
	$pass = md5($password);
	$cpassword = $row['password'];
	$id = $_SESSION['userSession'];
	$nip = $row['nip'];
	$euname = $row['nama_proyek'];
	$email = $row['email'];
	$foto = $row['foto'];
	$keterangan = aman("Mengubah Password");

			if($cpassword!==$pass){

				header("Location: proyek.php?aksi=passgagal");
				exit;
			}
	elseif($user_home->ubahpass($konpassbaru,$id,$nip,$euname,$email,$keterangan,$foto))

	{


	header("Location: proyek.php?aksi=ubahpasssukses");
	exit;
		}
		else
		{
			header("Location: proyek.php?aksi=ubahpassgagal");
			exit;
		}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Halaman Detail Proyek - Sistem Monitoring Proyek PT. Malmass Mitra Teknik</title>

		<meta name="description" content="3 styles with inline editable feature" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
    	<link rel="stylesheet" href="assets/css/colorbox.min.css" />
    		<link rel="stylesheet" href="assets/css/mouse.css" />
		<?php
		include 'favicon.php';
		?>
		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />
			<link rel="stylesheet" href="assets/css/bootstrap-editable.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->



		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">

		<?php
		require_once 'menu.php';
		?>



						<div class="page-header">
							<h1>
								Halaman Detail Proyek
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo $row["nama_proyek"]; ?>
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div>
									<div id="user-profile-1" class="user-profile row">
										<div class="col-xs-12 col-sm-3 center">
											<div>
												<span class="profile-picture">
												<?php if($_GET['id'] != '' && $row['foto'] != '') { ?>
													<img id="" width="200" height="200" alt="<?php echo $row['nama_proyeklantai'];?>" title="<?php echo $row['nama_proyeklantai'];?>" src="assets/images/malmass.JPEG" />
												<?php } elseif($_GET['id'] != '' && $row['foto'] == 'profile-pic.jpg') { ?>
                      	<img id="" width="200" height="200" title="<?php echo $row['nama_proyeklantai'];?>" alt="<?php echo $row['nama_proyeklantai'];?>" src="assets/images/malmass.JPEG" />
												<?php } elseif($row['foto'] != '') { ?>
                              <a href="avatar/<?php echo $row['foto'];?>" data-rel="colorbox" target="_blank">
												<img id="" width="200" height="200" title="<?php echo $row['nama_proyeklantai'];?>" alt="<?php echo $row['nama_proyeklantai'];?>" src="assets/images/malmass.JPEG" />
                      </a>
                        <?php } else { ?>
												<img id="" width="200" height="200" title="<?php echo $row['nama_proyeklantai'];?>" alt="<?php echo $row['nama_proyeklantai'];?>" src="assets/images/malmass.JPEG" />
												<?php } ?>
												</span>

												<div class="space-4"></div>

												<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
													<div class="inline position-relative">
														<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
													

															<span class="white" title="<?php echo $row['nama_proyeklantai']; ?>"><?php echo $row['nama_proyeklantai']; ?></span>

														</a>


													</div>
												</div>
											</div>

											<div class="space-6"></div>

											<div class="profile-contact-info">
												

												<div class="space-6"></div>

												
											</div>

											<div class="hr hr12 dotted"></div>

											<div class="clearfix">
												<div class="grid2">
													
														<?php


													
														$id = aman($_GET['id']);
														
													$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$b = $stmt->fetch(PDO::FETCH_ASSOC);
	if($b['kondisi_instalasi_lak'] == 'belum' OR $b['kondisi_instalasi_lal'] == 'belum') {
		echo "<span class='bigger-175 red'>Belum";
	} else {
		echo "<span class='bigger-175 green'>Selesai";
	}

?> 
													</span>

													<br />
													Status Instalasi Electrical
												</div>
												<div class="grid2">
													
														<?php




														
														$id = aman($_GET['id']);
														
													$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$b = $stmt->fetch(PDO::FETCH_ASSOC);
	if($b['kondisi_instalasi_pl'] == 'belum' OR $b['kondisi_instalasi_pk'] == 'belum' OR $b['kondisi_instalasi_tug'] == 'belum' OR $b['kondisi_instalasi_tdg'] == 'belum') {
		echo "<span class='bigger-175 red'>Belum";
	} else {
		echo "<span class='bigger-175 green'>Selesai";
	}

?> 
													</span>

													<br />
													Status Instalasi Mechanical
												</div>

												<div class="grid2">
												
														<?php

														$id = aman($_GET['id']);
													
													$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$b = $stmt->fetch(PDO::FETCH_ASSOC);
$listrik = $b['instalasi_lak'];
$lampu = $b['instalasi_lal'];

$e = $listrik+$lampu;



echo "<span class='bigger-175 blue'>".$e."%"."</span>";	


?> 
													

													<br />
													 Progress Instalasi Electrical
												</div>

												
												<div class="grid2">
												
														<?php

														$id = aman($_GET['id']);
													
													$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$b = $stmt->fetch(PDO::FETCH_ASSOC);

$telepon = $b['instalasi_pl'];

$alarm = $b['instalasi_pk'];
$sound = $b['instalasi_tug'];

$pipa = $b['instalasi_tdg'];
$e = $telepon+$alarm+$sound+$pipa;


echo "<span class='bigger-175 blue'>".$e."%"."</span>";	

?> 
													

													<br />
													 Progress Instalasi Mechanical
												</div>
											</div>

											<div class="hr hr16 dotted"></div>
										</div>

										<div class="col-xs-12 col-sm-9">
											<div class="center">
												
												

											</div>


											<div class="space-12"></div>
<?php
		if($_GET['aksi']=='editsukses')
		{
			?><center>
            <div class='alert alert-success'>

				<strong>Hore!</strong> Edit Biodata Anda Berhasil.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='bukangambar')
		{
			?><center>
            <div class='alert alert-danger'>

				File bukan gambar.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='terlalubesar')
		{
			?><center>
            <div class='alert alert-danger'>

				Size file gambar terlalu besar, maksimum 200KB
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='ekstensisalah')
		{
			?><center>
            <div class='alert alert-danger'>

				Hanya type file JPG, PNG dan GIF yang diperbolehkan.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='gagalupload')
		{
			?><center>
            <div class='alert alert-danger'>

				File gagal di Upload.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='tidakditemukan')
		{
			?><center>
            <div class='alert alert-danger'>

				<strong>Maaf!</strong> Profil Tidak Di Temukan.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='ubahpasssukses')
		{
			?><center>
            <div class='alert alert-success'>

				<strong>Hore!</strong> Password Anda Berhasil di Ubah.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='passgagal')
		{
			?><center>
            <div class='alert alert-danger'>

				<strong>Password</strong> Tidak Sesuai.
			</div></center>
            <?php
		}
		?>

		<?php
		if($_GET['aksi']=='editgagal')
		{
			?><center>
            <div class='alert alert-info'>

				<strong>Sorry!</strong> Edit Biodata Anda Gagal.
			</div></center>
            <?php
		}
		?>

		<?php
		if($_GET['aksi']=='isibiodatakamu')
		{
			?><center>
            <div class='alert alert-info'>

				Silahkan Lengkapi Biodata Anda, klik tombol<strong> Edit</strong>.
			</div></center>
            <?php
		}
		?>
		<?php if($_GET['mode'] !='edit') { ?>

		
											<div class="profile-user-info profile-user-info-striped">


												<div class="profile-info-row">
													<div class="profile-info-name"> Nama </div>

													<div class="profile-info-value">
<span class="editable" id="" name="euname"><?php echo $row['nama_proyeklantai']; ?></span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> ID Detail Proyek </div>

													<div class="profile-info-value">

													<span class="editable" id="" name="euname"><?php echo $row['id_detailproyek']; ?></span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> ID Proyek </div>

													<div class="profile-info-value">
												<span class="editable" id="" name="euname"><?php echo $row['id_proyek']; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Owner </div>

													<div class="profile-info-value">
													<span class="editable" id="" name="euname"><?php echo $row['nama_owner']; ?></span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Pegawai Mechanical </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['nama_pegawai_mechanical']; ?></span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Pegawai Electrical </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['nama_pegawai_electrical']; ?></span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Instalasi LAK </div>

													<div class="profile-info-value">
													<span class="editable" id="" name="euname"><?php echo $row['instalasi_lak']; ?>%</span>
													</div>
												</div>
													<div class="profile-info-row">
													<div class="profile-info-name"> Instalasi LAL </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['instalasi_lal']; ?>%</span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Instalasi PL </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['instalasi_pl']; ?>%</span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Instalasi PK </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['instalasi_pk']; ?>%</span>
													</div>
												</div>


												<div class="profile-info-row">
													<div class="profile-info-name"> Instalasi TUG </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['instalasi_tug']; ?>%</span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Instalasi TDG </div>

													<div class="profile-info-value">
														<span class="editable" id="" name="euname"><?php echo $row['instalasi_tdg']; ?>%</span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Aksi </div>

													<div class="profile-info-value">


			

												
															<a href="daftarproyek.php" type="submit" id="loading-btn1" data-loading-text="Mohon Tunggu..." class="btn btn-sm btn-danger"><span class="bigger-110"><i class="ace-icon fa fa-arrow-left"></i> Kembali</span></a>
															<?php } ?>


													</div>
												</div>

											</div>




											<?php if($_GET['mode']=='edit') { ?>
											<div id="user-profile-3" class="user-profile row">
										<div class="col-sm-offset-1 col-sm-10">


											<div class="space"></div>


												<div class="tabbable">
													<ul class="nav nav-tabs padding-16">
														<li class="active">
															<a data-toggle="tab" href="#edit-basic">
																<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
																Informasi Dasar
															</a>
														</li>

														<li>
															<a data-toggle="tab" href="#edit-settings">
																<i class="purple ace-icon fa fa-picture-o bigger-125"></i>
																Ubah Foto
															</a>
														</li>

														<li>
															<a data-toggle="tab" href="#edit-password">
																<i class="blue ace-icon fa fa-key bigger-125"></i>
																Ubah Password
															</a>
														</li>

														<li>
													<a data-toggle="tab" href="#aktifitas">
														<i class="orange ace-icon fa fa-rss bigger-125"></i>
														Aktifitas
													</a>
												</li>
													</ul>


													<div class="tab-content profile-edit-tab-content">
														<div id="edit-basic" class="tab-pane in active">
																	<form class="form-horizontal" id="validation-form" enctype="multipart/form-data" action="" method="post">
															<h4 class="header blue bolder smaller">General</h4>

															<div class="row">

																<div class="vspace-12-sm"></div>


																	<div class="form-group">
																		<label class="col-sm-3 control-label no-padding-right" for="form-field-username">Email</label>

																		<div class="col-sm-4">
																		<span class="input-icon input-icon-right">
																		<input type="email" placeholder="Email" class="form-control" name="email" id="email" value="<?php echo $row['email'];?>" class="" disabled/>
																		<i class="ace-icon fa fa-envelope"></i>
																	</span>

																		</div>
																	</div>
																		<div class="form-group">
																		<label class="col-sm-3 control-label no-padding-right" for="form-field-username">Nip</label>

																		<div class="col-sm-4">
																		<span class="input-icon input-icon-right">
																		<input type="text" placeholder="Nip" class="form-control" name="nip" id="nip" value="<?php echo $row['nip'];?>" class="" disabled/>
																		<i class="ace-icon fa fa-key"></i>
																	</span>

																		</div>
																	</div>

																	<div class="space-4"></div>

																	<div class="form-group">
																		<label class="col-sm-3 control-label no-padding-right" for="form-field-username">Nama</label>

																		<div class="col-sm-4">
																		<span class="input-icon input-icon-right">
																	<input type="text" placeholder="Nama" class="form-control" name="euname" id="euname" class="" value="<?php echo $row['nama_proyek'];?>"/>
																		<i class="ace-icon fa fa-user"></i>
																	</span>

																		</div>
																	</div>

															</div>

															<hr />
															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-website">Tempat Lahir</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="text" placeholder="Tempat Lahir" id="form-field-website" name="tempat" value="<?php echo $row['tempat_lahir'];?>" />
																		<i class="ace-icon fa fa-map-marker"></i>
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Tanggal Lahir</label>

																<div class="col-sm-9">
																	<div class="input-medium">
																		<div class="input-group">
																			<input class="input-medium date-picker" id="form-field-date" type="text" data-date-format="yyyy-mm-dd" name="tgl" id="tgl" placeholder="yyyy-mm-dd" value="<?php echo $row['tgl_lahir'];?>"/>
																			<span class="input-group-addon">
																				<i class="ace-icon fa fa-calendar"></i>
																			</span>
																		</div>
																	</div>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="jk" id="jk" class="ace" value="Laki - Laki" <?php if($row['jenis_kelamin']=="Laki - Laki") echo "checked";?>/>
																		<span class="lbl middle"> Laki - Laki</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="jk" id="jk" class="ace" value="Perempuan"
																		<?php if($row['jenis_kelamin']=="Perempuan") echo "checked";?>/>
																		<span class="lbl middle"> Perempuan</span>
																	</label>
																</div>
															</div>
															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right">Status Pernikahan</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="status" id="status" class="ace" value="Menikah" <?php if($row['status_pernikahan']=="Menikah") echo "checked";?>/>
																		<span class="lbl middle"> Menikah</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">

																		<input type="radio" name="status" id="status" class="ace" value="Belum Menikah" <?php if($row['status_pernikahan']=="Belum Menikah") echo "checked";?>/>
																		<span class="lbl middle"> Belum Menikah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right">Bidang</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="bidang" id="bidang" class="ace" value="Mechanical" <?php if($row['bidang']=="Mechanical") echo "checked";?>/>
																		<span class="lbl middle"> Mechanical</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																	<input type="radio" name="bidang" id="bidang" class="ace" value="Electrical" <?php if($row['bidang']=="Electrical") echo "checked";?>/>
																		<span class="lbl middle"> Electrical</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right">Agama</label>

																<div class="col-sm-9">
																	<label class="inline">

																	<select name="agama" id="agama">
																	<option value="">Agama</option>
											<option value="Islam" <?php if($row['agama']=="Islam") echo "selected";?>>Islam</option>
											<option value="Kristen" <?php if($row['agama']=="Kristen") echo "selected";?>>Kristen</option>
											<option value="Hindu" <?php if($row['agama']=="Hindu") echo "selected";?>>Hindu</option>
											<option value="Buddha" <?php if($row['agama']=="Buddha") echo "selected";?>>Buddha</option>

										</select>
																	</label>
																</div>
															</div>
															<div class="space-4"></div>
																<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Alamat</label>

																<div class="col-sm-9">
																	<div class="clearfix">
																		<textarea class="input-large" name="alamat" id="alamat"><?php echo $row['alamat'];?></textarea>
																	</div>
																</div>
															</div>

															<div class="space"></div>
															<h4 class="header blue bolder smaller">Contact</h4>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-email">WhatsApp</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="text" minlength="12" maxlength="16" name="whatsapp" id="form-field-email" class="input-medium input-mask-whatsapp" placeholder="WhatsApp" value="<?php echo $row['whatsapp'];?>" />
																		<i class="ace-icon fa fa-whatsapp green"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-website">Facebook</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="url" name="url" minlength="8" maxlength="100" id="form-field-website" placeholder="https://www.facebook.com/glorious.burst" value="<?php echo $row['facebook'];?>" />
																		<i class="ace-icon fa fa-facebook blue"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Telepon</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input class="input-medium input-mask-phone" placeholder="Masukkan No Telepon Anda" type="text" name="hp" id="form-field-phone" value="<?php echo $row['no_hp'];?>"/>
																		<i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
																	</span>
																</div>
															</div>

															<div class="space"></div>
															<h4 class="header blue bolder smaller">Masukkan Password Anda</h4>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-password">Password</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="password" id="password" name="password" placeholder="Masukkan Password Anda" />
																		<i class="ace-icon fa fa-lock"></i>
																	</span>
																</div>
															</div>

															<div class="clearfix form-actions">
													<div class="col-md-offset-3 col-md-9">
														<button id="loading-btn" type="submit" class="btn btn-info" data-loading-text="Menyimpan..." name="btn-edit">
															<i class="ace-icon fa fa-floppy-o"></i>
															<span class="bigger-110">Simpan</span>
														</button>

														&nbsp; &nbsp;
														<a href="proyek.php" type="submit" id="loading-btn2" data-loading-text="Mohon Tunggu..." class="btn btn-warning">
														<i class="ace-icon fa fa-arrow-left"></i> Kembali</a>
													</div>


												</div>
														</form>
														</div>


											<div id="edit-settings" class="tab-pane">
														<form class="form-horizontal" enctype="multipart/form-data" id="validation-form2" action="" method="post">
															<div class="space-10"></div>

															<div class="form-group in active">


																		<div class="col-md-offset-3 col-md-6">
																	<center><input type="file" name="fileToUpload" id="" class="editable img-responsive editable-click editable-empty tab-pane in active" value="<?php echo $row['foto'];?>" />
																	</center>
																</div>
															</div>


															<div class="clearfix form-actions">
													<div class="col-md-offset-3 col-md-9">
													<button id="loading-btn5" type="submit" class="btn btn-danger" data-loading-text="Menyimpan..." name="btn-ubahfoto">
															<i class="ace-icon fa fa-upload"></i>
															<span class="bigger-110">Ubah Foto</span>
														</button>
														&nbsp; &nbsp;
														<a href="proyek.php" type="submit" id="loading-btn6" data-loading-text="Mohon Tunggu..." class="btn btn-warning">
														<i class="ace-icon fa fa-arrow-left"></i> Kembali</a>
													</div>

												</div>
												</form>
												</div>

											<div id="aktifitas" class="tab-pane">
													<div class="profile-feed row">

														 <?php

                              $stmt = $user_home->runQuery("SELECT * FROM history where email=:email ORDER BY tanggal DESC LIMIT 10");
                                $stmt->execute(array(":email"=>$_SESSION['userSession']));

                                while($history = $stmt->fetch()){
                                  ?>
                                  <?php if($history['keterangan'] == "Mengubah Biodata") { ?>
                                  <div class="col-sm-6">
															<div class="profile-activity clearfix">

																<div>
																	<img class="pull-left" width="40" height="40" title="<?php echo $history['nama'];?>" alt="<?php echo $row['nama_proyek'];?>" src="avatar/<?php echo $history['foto'];?>" />
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>


															</div>
															</div><!-- /.col -->
                                <?php } elseif($history['keterangan'] == "Mengubah Foto") {  ?>
                                <div class="col-sm-6">
                                <div class="profile-activity clearfix">

																<div>
																	<img class="pull-left" width="40" height="40" title="<?php echo $history['nama'];?>" alt="<?php echo $row['nama_proyek'];?>" src="avatar/<?php echo $history['foto'];?>" />
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>
																</div>

															</div>
															<?php } elseif($history['keterangan'] == "Melakukan Log Out") {  ?>
															<div class="col-sm-6">
															 <div class="profile-activity clearfix">

																<div>
																	<i class="pull-left thumbicon fa fa-power-off btn-inverse no-hover"></i>
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>

															</div>
															</div>
																<?php } elseif($history['keterangan'] == "Melakukan Log In") {  ?>
															<div class="col-sm-6">
															 <div class="profile-activity clearfix">

																<div>
																	<i class="pull-left thumbicon fa fa-key btn-info no-hover"></i>
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>

															</div>
															</div>
															 <?php } elseif($history['keterangan'] == "Mengubah Password") {  ?>
															 <div class="col-sm-6">
                                <div class="profile-activity clearfix">

																<div>
																	<img class="pull-left" width="40" height="40" title="<?php echo $history['nama'];?>" alt="<?php echo $row['nama_proyek'];?>" src="avatar/<?php echo $history['foto'];?>" />
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>
																</div>
																</div>

															<?php } ?>
															<?php } ?>


													</div><!-- /.row -->

													<div class="space-12"></div>


												</div><!-- /#feed -->
														<div id="edit-password" class="tab-pane">
														<form class="form-horizontal" id="validation-form1" action="" method="post">
															<div class="space-10"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-password">Password Sebelumnya</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="password" id="ubahpass" name="ubahpass" placeholder="Masukkan Password Anda Sebelumnya<" />
																		<i class="ace-icon fa fa-lock"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-password">Password Baru</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="password" id="passbaru" name="passbaru" placeholder="Password Baru" />
																		<i class="ace-icon fa fa-lock"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-password1">Konfirmasi Password Baru</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input type="password" id="konpassbaru" name="konpassbaru" placeholder="Konfirmasi Password Baru" />
																		<i class="ace-icon fa fa-lock"></i>
																	</span>
																</div>
															</div>
															<div class="clearfix form-actions">
													<div class="col-md-offset-3 col-md-9">
													<button id="loading-btn3" type="submit" class="btn btn-success" data-loading-text="Menyimpan..." name="btn-ubah">
															<i class="ace-icon fa fa-floppy-o"></i>
															<span class="bigger-110">Ubah</span>
														</button>
														&nbsp; &nbsp;
														<a href="proyek.php" type="submit" id="loading-btn4" data-loading-text="Mohon Tunggu..." class="btn btn-warning">
														<i class="ace-icon fa fa-arrow-left"></i> Kembali</a>
													</div>

												</div>
												</form>
												


										</div><!-- /.span -->
									</div><!-- /.user-profile -->
											<?php } ?>


											<div class="space-20"></div>

											<div class="widget-box transparent">
												<div class="widget-header widget-header-small">
													<h4 class="widget-title blue smaller">
														<i class="ace-icon fa fa-rss orange"></i>
														Aktifitas Terkini
													</h4>

													<div class="widget-toolbar action-buttons">

															<i class="ace-icon fa fa-arrow-down blue"></i>
															Scroll Untuk Melihat Aktifitas


													</div>
												</div>

												<div class="widget-body">
													<div class="widget-main padding-8">
														<div id="profile-feed-1" class="profile-feed">
                              <?php

                              $stmt = $user_home->runQuery("SELECT * FROM history ORDER BY tanggal DESC LIMIT 25");
                              $stmt->execute();

                                while($history = $stmt->fetch()){
                                  ?>
                                  <?php if($history['keterangan'] == "Mengubah Biodata") { ?>
															<div class="profile-activity clearfix">

																<div>
																	<img class="pull-left" width="40" height="40" title="<?php echo $history['nama'];?>" alt="<?php echo $row['nama_proyek'];?>" src="avatar/<?php echo $history['foto'];?>" />
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>


															</div>
                                <?php } elseif($history['keterangan'] == "Mengubah Foto") {  ?>
                                <div class="profile-activity clearfix">

																<div>
																	<img class="pull-left" width="40" height="40" title="<?php echo $history['nama'];?>" alt="<?php echo $row['nama_proyek'];?>" src="avatar/<?php echo $history['foto'];?>" />
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.
																	<a href="avatar/<?php echo $history['foto'];?>" target="_blank">Lihat Foto</a>
																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>


															</div>
															<?php } elseif($history['keterangan'] == "Melakukan Log Out") {  ?>

															 <div class="profile-activity clearfix">

																<div>
																	<i class="pull-left thumbicon fa fa-power-off btn-inverse no-hover"></i>
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>


															</div>
																<?php } elseif($history['keterangan'] == "Melakukan Log In") {  ?>

															 <div class="profile-activity clearfix">

																<div>
																	<i class="pull-left thumbicon fa fa-key btn-info no-hover"></i>
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>


															</div>
															 <?php } elseif($history['keterangan'] == "Mengubah Password") {  ?>
                                <div class="profile-activity clearfix">

																<div>
																	<img class="pull-left" width="40" height="40" title="<?php echo $history['nama'];?>" alt="<?php echo $row['nama_proyek'];?>" src="avatar/<?php echo $history['foto'];?>" />
																	<a class="user" href="proyek.php?id=<?php echo $history['email'];?>"> <?php echo $history['nama']; ?>  </a>
																	<?php echo $history['keterangan']; ?>.

																	<div class="time">
																		<i class="ace-icon fa fa-clock-o bigger-110"></i>
																		<?php echo $user_home->waktu_lalu($history['tanggal']); ?>
																	</div>
																</div>


															</div>
															<?php } ?>
															<?php } ?>



														</div>
													</div>
												</div>
											</div>



											<div class="space-6"></div>


										</div>
									</div>
								</div>

								<div class="hide">
									<div id="user-profile-2" class="user-profile">
										<div class="tabbable">
											

											<div class="tab-content no-border padding-24">
												<div id="home" class="tab-pane in active">
													</div><!-- /.row -->

													<div class="space-20"></div>

													
												</div><!-- /#home -->

												

												
																	<a href="#">
																		
													
													</a>
																

														
																	<a href="#">
																		<img id="avatar" class="editable img-responsive" width="250" height="250" alt="<?php echo $row['foto'];?>" src="avatar/<?php echo $row['foto'];?>" />
																	</a>
																


												
											</div>
										</div>
									</div>
								



								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php
			include 'footer.php';
			?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<?php
		include 'script.php';
		?>
	</body>
</html>