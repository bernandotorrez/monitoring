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

if($_GET['id'] != ''){

$id1 = aman($_GET['id']);
$stmt = $user_home->runQuery("SELECT * FROM login, owner WHERE login.email=:uid and owner.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id1));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);

if($stmt->rowCount() == 0)
{
	header("Location: owner.php?aksi=tidakditemukan");
				exit;
}

} else {

$stmt = $user_home->runQuery("SELECT * FROM login, owner WHERE login.email=:uid and owner.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
}
if($row['level'] == 'Draugman')
{
	$user_home->redirect('pegawai.php');
}

if(isset($_POST['btn-edit']))
{

	$euname = aman($_POST['euname']);
	$email = $row['email'];
	$password = aman($_POST['password']);
	$alamat = aman($_POST['alamat']);
	$hp = aman($_POST['hp']);

	$pass = md5($password);
	$cpassword = $row['password'];
	$id = $_SESSION['userSession'];
	$profil = aman("sudah");
	

  $id_owner = $row['id_owner'];
  $keterangan = aman("Mengubah Biodata");
  $foto = $row['foto'];
			if($cpassword!==$pass){

				header("Location: owner.php?aksi=passgagal");
				exit;
			}
	elseif($user_home->edit_owner($euname,$alamat,$hp,$profil,$id,$id_owner,$keterangan,$foto,$password))

	{

	header("Location: owner.php?aksi=editsukses");
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
	
	$keterangan = aman("Mengubah Password");

			if($cpassword!==$pass){

				header("Location: owner.php?aksi=passgagal");
				exit;
			}
	elseif($user_home->ubahpassowner($konpassbaru,$id))

	{


	header("Location: owner.php?aksi=ubahpasssukses");
	exit;
		}
		else
		{
			header("Location: owner.php?aksi=ubahpassgagal");
			exit;
		}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Halaman Profil Owner - Sistem Monitoring Proyek PT. Malmass Mitra Teknik</title>

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
								Halaman Profil Owner
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Profil Anda
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
												<?php if($_GET['id'] != '' && $rows['foto'] != '') { ?>
													<img id="" width="200" height="200" alt="<?php echo $rows['nama_owner'];?>" title="<?php echo $rows['nama_owner'];?>" src="avatar/<?php echo $rows['foto'];?>" />
												<?php } elseif($_GET['id'] != '' && $rows['foto'] == 'profile-pic.jpg') { ?>
                      	<img id="" width="200" height="200" title="<?php echo $rows['nama_owner'];?>" alt="<?php echo $rows['nama_owner'];?>" src="assets/images/avatars/profile-pic.jpg" />
												<?php } elseif($row['foto'] != '') { ?>
                              <a href="avatar/<?php echo $row['foto'];?>" data-rel="colorbox" target="_blank">
												<img id="" width="200" height="200" title="<?php echo $row['nama_owner'];?>" alt="<?php echo $row['nama_owner'];?>" src="avatar/<?php echo $row['foto'];?>" />
                      </a>
                        <?php } else { ?>
												<img id="" width="200" height="200" title="<?php echo $row['nama_owner'];?>" alt="<?php echo $row['nama_owner'];?>" src="assets/images/avatars/profile-pic.jpg" />
												<?php } ?>
												</span>

												<div class="space-4"></div>

												<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
													<div class="inline position-relative">
														<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
														<?php
														if($row['online'] == 'on'){ ?>
														<i class="ace-icon fa fa-circle light-green" title="<?php echo $row['nama_owner']; ?> Is Online"></i>
														<?php } elseif ($_GET['id'] != '' && $rows['online'] == 'on') {?>
														<i class="ace-icon fa fa-circle light-green"  title="<?php echo $rows['nama_owner']; ?> Is Online"></i>
														<?php
														} else {
														?><i class="ace-icon fa fa-circle light-red"  title="<?php echo $rows['nama_owner']; ?> Is Offline"></i>
														<?php } ?>

															<?php
															if($_GET['id'] != '' && $rows['online'] == 'on') {
																?>
															<span class="white" title="<?php echo $rows['nama_owner']; ?> Is Online"><?php echo $rows['nama_owner']; ?></span>
															<?php } elseif ($row['online'] == 'on') {?>
																<span class="white" title="<?php echo $row['nama_owner']; ?> Is Online"><?php echo $row['nama_owner']; ?></span>
																<?php } else  {?>
																<span class="white" title="<?php echo $rows['nama_owner']; ?> Is Offline"><?php echo $rows['nama_owner']; ?></span>
																<?php } ?>

														</a>


													</div>
												</div>
											</div>

											<div class="space-6"></div>

											<div class="profile-contact-info">
												<div class="profile-contact-links align-left">
													<a href="#" class="btn btn-link">
														<i class="ace-icon fa fa-envelope bigger-120 pink"></i>
                            <?php
                            if($_GET['id'] != '') {
                              echo $rows['email'];
                            } else {
                                echo $row['email'];
                            }
                            ?>

													</a>

                            <?php
                            if($_GET['id'] != '') {
                              if($rows['whatsapp'] == '') { ?>

                            <?php  } else { ?>
                              <a href="#" class="btn btn-link">
                                <i class="ace-icon fa fa-whatsapp bigger-125 green"></i>
                                <?php echo $rows['whatsapp']; ?>
                                </a>
                            <?php } ?>

                            <?php } else {
                              if($row['whatsapp'] == '') { ?>

                            <?php  } else { ?>
                              <a href="#" class="btn btn-link">
                                <i class="ace-icon fa fa-whatsapp bigger-125 green"></i>
                                <?php echo $row['whatsapp']; ?>
                                </a>
                            <?php } ?>
                          <?php } ?>

													 <?php
                            if($_GET['id'] != '') {
                              if($rows['no_hp'] == '') { ?>

                            <?php  } else { ?>
                              <a href="#" class="btn btn-link">
                                <i class="ace-icon fa fa-phone bigger-125 blue"></i>
                                <?php echo $rows['no_hp']; ?>
                                </a>
                            <?php } ?>

                            <?php } else {
                              if($row['no_hp'] == '') { ?>

                            <?php  } else { ?>
                              <a href="#" class="btn btn-link">
                                <i class="ace-icon fa fa-phone bigger-125 blue"></i>
                                <?php echo $row['no_hp']; ?>
                                </a>
                            <?php } ?>
                          <?php } ?>
													
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

				<strong>Maaf!</strong> Edit Biodata Anda Gagal.
			</div></center>
            <?php
		}
		?>
<?php
		if($_GET['aksi']=='ubahpassgagal')
		{
			?><center>
            <div class='alert alert-danger'>

				<strong>Maaf!</strong> Password Gagal di Ubah.
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

		<?php if($rows['level'] == 'Admin') { ?>
		<div class="profile-user-info profile-user-info-striped">


												<div class="profile-info-row">
													<div class="profile-info-name"> Nama </div>

													<div class="profile-info-value">

													<?php if ($_GET['id'] != '') { ?>
													<span class="editable" id="" name="euname"><?php echo $rows['nama_owner']; ?></span>
													<?php } else { ?>
													<span class="editable" id="" name="euname"><?php echo $row['nama_owner']; ?></span>
													<?php  } ?>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Id Owner </div>

													<div class="profile-info-value">

													<?php if ($_GET['id'] != '') { ?>
													<span class="editable" id="" name="euname"><?php echo $rows['id_owner']; ?></span>
													<?php } else { ?>
													<span class="editable" id="" name="euname"><?php echo $row['id_owner']; ?></span>
													<?php  } ?>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Email </div>

													<div class="profile-info-value">
													<?php
													if($_GET['id'] != '') {
													?>
														<span class="editable" id=""><?php echo $rows['email']; ?></span>
														<?php } else { ?>
															<span class="editable" id=""><?php echo $row['email']; ?></span>
															<?php } ?>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Edit </div>

													<div class="profile-info-value">


			<?php if($row['email'] OR $_GET['id'] == $_SESSION['userSession'] AND $row['level'] == 'Owner') { ?>

													<a href="owner.php?mode=edit" type="submit" id="loading-btn" data-loading-text="Mohon Tunggu..." class="btn btn-sm btn-primary"><span class="bigger-110"><i class="ace-icon fa fa-pencil"></i> Edit</span></a>
													<?php } else {?>
															<a href="owner.php" type="submit" id="loading-btn1" data-loading-text="Mohon Tunggu..." class="btn btn-sm btn-danger"><span class="bigger-110"><i class="ace-icon fa fa-arrow-left"></i> Back</span></a>
															<?php } ?>


													</div>
												</div>
												</div>
												<?php } else { ?>
											<div class="profile-user-info profile-user-info-striped">


												<div class="profile-info-row">
													<div class="profile-info-name"> Nama </div>

													<div class="profile-info-value">

													<?php if ($_GET['id'] != '') { ?>
													<span class="editable" id="" name="euname"><?php echo $rows['nama_owner']; ?></span>
													<?php } else { ?>
													<span class="editable" id="" name="euname"><?php echo $row['nama_owner']; ?></span>
													<?php  } ?>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Id Owner </div>

													<div class="profile-info-value">

													<?php if ($_GET['id'] != '') { ?>
													<span class="editable" id="" name="euname"><?php echo $rows['id_owner']; ?></span>
													<?php } else { ?>
													<span class="editable" id="" name="euname"><?php echo $row['id_owner']; ?></span>
													<?php  } ?>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Email </div>

													<div class="profile-info-value">
													<?php
													if($_GET['id'] != '') {
													?>
														<span class="editable" id=""><?php echo $rows['email']; ?></span>
														<?php } else { ?>
															<span class="editable" id=""><?php echo $row['email']; ?></span>
															<?php } ?>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Telepon </div>

													<div class="profile-info-value">
														<span class="input-mask-phone" name="hp" id="">
														<?php
													if($_GET['id'] != '') {
													?><?php echo $rows['no_hp'];?>
													<?php } else { ?>
													<?php echo $row['no_hp'];?>
													<?php } ?>
													</span>
													</div>
												</div>
												
												
												<div class="profile-info-row">
													<div class="profile-info-name"> Jabatan </div>

													<div class="profile-info-value">
											<?php
													if($_GET['id'] != '') {
													?>
                                      <span class="label label-sm label-primary">
                                     
                              <?php echo $rows['level'];?></span>

														<?php } else if ($row['level'] == 'Admin'){ ?>
                            <span class="label label-sm label-danger">
                          <?php } elseif($row['level'] == 'Direktur') { ?>
                            <span class="label label-sm label-success">
                              <?php } elseif($row['level'] == 'Engineer') { ?>
                                <span class="label label-sm label-primary">

                                     <?php } else { ?>
                                      <span class="label label-sm label-warning">
                                        <?php } ?> <?php echo $row['level'];?></span>

													</div>
												</div>



												<div class="profile-info-row">
													<div class="profile-info-name"> Alamat </div>

													<div class="profile-info-value">
														<span class="editable" id="">
														<?php
													if($_GET['id'] != '') {
													?><?php echo $rows['alamat'];?>
													<?php } else { ?>
													<?php echo $row['alamat'];?>
													<?php } ?>
													</span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name"> Edit </div>

													<div class="profile-info-value">


			<?php if($row['email'] OR $_GET['id'] == $_SESSION['userSession']) { ?>

													<a href="owner.php?mode=edit" type="submit" id="loading-btn1" data-loading-text="Mohon Tunggu..." class="btn btn-sm btn-primary"><span class="bigger-110"><i class="ace-icon fa fa-pencil"></i> Edit</span></a>
													<?php } else {?>
															<a href="owner.php" type="submit" id="loading-btn1" data-loading-text="Mohon Tunggu..." class="btn btn-sm btn-danger"><span class="bigger-110"><i class="ace-icon fa fa-arrow-left"></i> Back</span></a>
															<?php } ?>


													</div>
												</div>

											</div>
<?php } ?>
<?php } ?>



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
															<a data-toggle="tab" href="#edit-password">
																<i class="blue ace-icon fa fa-key bigger-125"></i>
																Ubah Password
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
																		<label class="col-sm-3 control-label no-padding-right" for="form-field-username">ID Owner</label>

																		<div class="col-sm-4">
																		<span class="input-icon input-icon-right">
																		<input type="text" placeholder="id_owner" class="form-control" name="id_owner" id="id_owner" value="<?php echo $row['id_owner'];?>" class="" disabled/>
																		<i class="ace-icon fa fa-key"></i>
																	</span>

																		</div>
																	</div>

																	<div class="space-4"></div>

																	<div class="form-group">
																		<label class="col-sm-3 control-label no-padding-right" for="form-field-username">Nama</label>

																		<div class="col-sm-4">
																		<span class="input-icon input-icon-right">
																	<input type="text" placeholder="Nama" class="form-control" name="euname" id="euname" class="" value="<?php echo $row['nama_owner'];?>"/>
																		<i class="ace-icon fa fa-user"></i>
																	</span>

																		</div>
																	</div>

															</div>

															<hr />
															<div class="space-4"></div>

															
															
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

														

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Telepon</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input class="input-mask-phone" placeholder="Masukkan No Telepon Anda" type="text" name="hp" id="form-field-phone" value="<?php echo $row['no_hp'];?>"/>
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
														<a href="owner.php" type="submit" id="loading-btn2" data-loading-text="Mohon Tunggu..." class="btn btn-warning">
														<i class="ace-icon fa fa-arrow-left"></i> Kembali</a>
													</div>


												</div>
														</form>
														</div>


											

											
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
														<a href="owner.php" type="submit" id="loading-btn4" data-loading-text="Mohon Tunggu..." class="btn btn-warning">
														<i class="ace-icon fa fa-arrow-left"></i> Kembali</a>
													</div>

												</div>
												</form>
												


										</div><!-- /.span -->
									</div><!-- /.user-profile -->
											<?php } ?>


																					


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