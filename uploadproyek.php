<!DOCTYPE html>
<?php
session_start();
error_reporting(0);
require_once 'class.user.php';
include "config/library.php";
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
$row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	$stmt = $user_home->runQuery("SELECT * FROM login, owner WHERE login.email=:uid and owner.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
}

 
if($row['level'] != 'Draugman') {
$user_home->redirect('index.php');
}

if(isset($_POST['btn-pilihlak']))
{
$get = aman($_GET['id']);
$kode = aman($_GET['kode']);
header("Location: uploadproyek.php?kode=$kode&id=$get");
					exit;
}

if($_GET['kode'] == 'lak') {
if(isset($_FILES['fileToUpload'])){
	$idf = $_POST['id']; 	
	 $judul = str_replace("/", "-", $idf);
                        $idfot = strtoupper($judul);
                        $idfoto = $idfot.'-LAK';
	$euname = $row['nama_pegawai'];
	$nip = $row['nip'];
	$email = $row['email'];
  $keterangan = aman("Mengupload File LAK Dengan ID Proyek : ".$idf."");
  if($row['bidang'] == 'Electrical') {
				$target_dir = "proyek/electrical/";
			} else {
				$target_dir = "proyek/mechanical/";
			}
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-submit"])) {
					
					
					$uploadOk = 1;
					
				}

				if ($_FILES["fileToUpload"]["size"] > 5000000) {
					header("Location: uploadproyek.php?terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "pdf"){
					header("Location: uploadproyek.php?ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$f = $_POST['id'].'-LAK';
						$j = str_replace("/", "-", $f);
                        $foto = strtoupper($j).'.'.$imageFileType;;
							$id = $_POST['id'];
							

						if($user_home->upload_file_electrical_lak($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)){
								header("Location: uploadproyek.php?inputsukses");
								exit;
						}
					} else {
						header("Location: uploadproyek.php?gagalupload");

						exit;
					}

			}
		} elseif($_GET['kode'] == 'lal') {
			if(isset($_FILES['fileToUpload'])){
	$idf = $_POST['id']; 	
	 $judul = str_replace("/", "-", $idf);
                        $idfot = strtoupper($judul);
                        $idfoto = $idfot.'-LAL';
	$euname = $row['nama_pegawai'];
	$nip = $row['nip'];
	$email = $row['email'];
  $keterangan = aman("Mengupload File LAL Dengan ID Proyek : ".$idf."");
  if($row['bidang'] == 'Electrical') {
				$target_dir = "proyek/electrical/";
			} else {
				$target_dir = "proyek/mechanical/";
			}
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-submit"])) {
					
					
					$uploadOk = 1;
					
				}

				if ($_FILES["fileToUpload"]["size"] > 5000000) {
					header("Location: uploadproyek.php?terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "pdf"){
					header("Location: uploadproyek.php?ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$f = $_POST['id'].'-LAL';
						$j = str_replace("/", "-", $f);
                        $foto = strtoupper($j).'.'.$imageFileType;;
							$id = $_POST['id'];
							

						if($user_home->upload_file_electrical_lal($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)){
								header("Location: uploadproyek.php?inputsukses");
								exit;
						}
					} else {
						header("Location: uploadproyek.php?gagalupload");

						exit;
					}

			}
		} elseif($_GET['kode'] == 'pl') {
		if(isset($_FILES['fileToUpload'])){
	$idf = $_POST['id']; 	
	 $judul = str_replace("/", "-", $idf);
                        $idfot = strtoupper($judul);
                        $idfoto = $idfot.'-PL';
	$euname = $row['nama_pegawai'];
	$nip = $row['nip'];
	$email = $row['email'];
  $keterangan = aman("Mengupload File PL Dengan ID Proyek : ".$idf."");
  if($row['bidang'] == 'Electrical') {
				$target_dir = "proyek/electrical/";
			} else {
				$target_dir = "proyek/mechanical/";
			}
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-submit"])) {
					
					
					$uploadOk = 1;
					
				}

				if ($_FILES["fileToUpload"]["size"] > 5000000) {
					header("Location: uploadproyek.php?terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "pdf"){
					header("Location: uploadproyek.php?ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$f = $_POST['id'].'-PL';
						$j = str_replace("/", "-", $f);
                        $foto = strtoupper($j).'.'.$imageFileType;;
							$id = $_POST['id'];
							

						if($user_home->upload_file_mechanical_pl($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)){
								header("Location: uploadproyek.php?inputsukses");
								exit;
						}
					} else {
						header("Location: uploadproyek.php?gagalupload");

						exit;
					}

			}
			} elseif($_GET['kode'] == 'pk') {
		if(isset($_FILES['fileToUpload'])){
	$idf = $_POST['id']; 	
	 $judul = str_replace("/", "-", $idf);
                        $idfot = strtoupper($judul);
                        $idfoto = $idfot.'-PK';
	$euname = $row['nama_pegawai'];
	$nip = $row['nip'];
	$email = $row['email'];
  $keterangan = aman("Mengupload File PK Dengan ID Proyek : ".$idf."");
  if($row['bidang'] == 'Electrical') {
				$target_dir = "proyek/electrical/";
			} else {
				$target_dir = "proyek/mechanical/";
			}
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-submit"])) {
					
					
					$uploadOk = 1;
					
				}

				if ($_FILES["fileToUpload"]["size"] > 5000000) {
					header("Location: uploadproyek.php?terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "pdf"){
					header("Location: uploadproyek.php?ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$f = $_POST['id'].'-PK';
						$j = str_replace("/", "-", $f);
                        $foto = strtoupper($j).'.'.$imageFileType;;
							$id = $_POST['id'];
							

						if($user_home->upload_file_mechanical_pk($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)){
								header("Location: uploadproyek.php?inputsukses");
								exit;
						}
					} else {
						header("Location: uploadproyek.php?gagalupload");

						exit;
					}

			}
			} elseif($_GET['kode'] == 'tug') {
		if(isset($_FILES['fileToUpload'])){
	$idf = $_POST['id']; 	
	 $judul = str_replace("/", "-", $idf);
                        $idfot = strtoupper($judul);
                        $idfoto = $idfot.'-TUG';
	$euname = $row['nama_pegawai'];
	$nip = $row['nip'];
	$email = $row['email'];
  $keterangan = aman("Mengupload File TUG Dengan ID Proyek : ".$idf."");
  if($row['bidang'] == 'Electrical') {
				$target_dir = "proyek/electrical/";
			} else {
				$target_dir = "proyek/mechanical/";
			}
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-submit"])) {
					
					
					$uploadOk = 1;
					
				}

				if ($_FILES["fileToUpload"]["size"] > 5000000) {
					header("Location: uploadproyek.php?terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "pdf"){
					header("Location: uploadproyek.php?ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$f = $_POST['id'].'-TUG';
						$j = str_replace("/", "-", $f);
                        $foto = strtoupper($j).'.'.$imageFileType;;
							$id = $_POST['id'];
							

						if($user_home->upload_file_mechanical_tug($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)){
								header("Location: uploadproyek.php?inputsukses");
								exit;
						}
					} else {
						header("Location: uploadproyek.php?gagalupload");

						exit;
					}

			}
			} elseif($_GET['kode'] == 'tdg') {
		if(isset($_FILES['fileToUpload'])){
	$idf = $_POST['id']; 	
	 $judul = str_replace("/", "-", $idf);
                        $idfot = strtoupper($judul);
                        $idfoto = $idfot.'-TDG';
	$euname = $row['nama_pegawai'];
	$nip = $row['nip'];
	$email = $row['email'];
  $keterangan = aman("Mengupload File TDG Dengan ID Proyek : ".$idf."");
  if($row['bidang'] == 'Electrical') {
				$target_dir = "proyek/electrical/";
			} else {
				$target_dir = "proyek/mechanical/";
			}
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if(isset($_POST["btn-submit"])) {
					
					
					$uploadOk = 1;
					
				}

				if ($_FILES["fileToUpload"]["size"] > 5000000) {
					header("Location: uploadproyek.php?terlalubesar");

						exit;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
				&& $imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "pdf"){
					header("Location: uploadproyek.php?ekstensisalah");

						exit;
				}


					$file = $target_dir.''.$idfoto.'.'.$imageFileType;
					$new_id = $idfoto.'.'.$imageFileType;
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
						$f = $_POST['id'].'-TDG';
						$j = str_replace("/", "-", $f);
                        $foto = strtoupper($j).'.'.$imageFileType;;
							$id = $_POST['id'];
							

						if($user_home->upload_file_mechanical_tdg($foto,$id,$idfoto,$nip,$euname,$email,$keterangan)){
								header("Location: uploadproyek.php?inputsukses");
								exit;
						}
					} else {
						header("Location: uploadproyek.php?gagalupload");

						exit;
					}

			}
			}

?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Upload Proyek - PT. Malmass Mitra Teknik</title>

		<meta name="description" content="Common form elements and layouts" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
			<link rel="stylesheet" href="assets/css/mouse.css" />
		<?php
		include 'favicon.php';
		?>

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="assets/css/jquery-ui.min.css" />
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
								Monitoring
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Upload Proyek
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">

						<?php
		if(isset($_GET['inputsukses']))
		{
			?><center>
            <div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-check bigger-120 green"></i>
										Upload Proyek Berhasil.
									</div></center>
            <?php
		} if(isset($_GET['gagalupload'])) {
		?>
		<?php


			?><center>
            <div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-close bigger-120 red"></i>
										Upload Proyek Gagal.
									</div></center>
            <?php
		} if(isset($_GET['terlalubesar'])) {
		?>
		<?php


			?><center>
            <div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-close bigger-120 red"></i>
										Ukuran File Terlalu Besar, Maksimal 5MB.
									</div></center>
             <?php
		} if(isset($_GET['ekstensisalah'])) {
		?>
		<?php


			?><center>
            <div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-close bigger-120 red"></i>
										Ekstensi File Salah, hanya bisa Upload .PDF
									</div></center>
            <?php
        }
		?>
		<?php if($_GET['kode'] == '') { ?>
		<h3>Keterangan : 
		</br></br>
		<?php if($row['bidang'] == 'Electrical') { ?>
			<i class="blue ace-icon fa fa-cloud-upload bigger-130"></i> = Upload File Instalasi LAK </br>
						<i class="red ace-icon fa fa-cloud-upload bigger-130"></i> = Upload File Instalasi LAL
						<?php } else { ?>
						<i class="blue ace-icon fa fa-cloud-upload bigger-130"></i> = Upload File Instalasi PL </br>
						<i class="red ace-icon fa fa-cloud-upload bigger-130"></i> = Upload File Instalasi PK </br>
						<i class="green ace-icon fa fa-cloud-upload bigger-130"></i> = Upload File Instalasi TUG </br>
						<i class="orange ace-icon fa fa-cloud-upload bigger-130"></i> = Upload File Instalasi TDG
						<?php } ?>
						</h3>
										<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Daftar Upload Proyek
										</div>
										<?php if($row['bidang'] == 'Electrical') { ?>
		<table id="dynamic-table" class="table table-striped table-bordered table-hover">
											<form action="" method="post">
												<thead>
													<tr>
													<th>ID Proyek</th>
														<th>Nama Proyek</th>
														
														<th class="hidden-480">File Instalasi LAK</th>
														<th class="hidden-480">File Instalasi LAL</th>
														<th class="hidden-480">Status LAK</th>
														<th class="hidden-480">Status LAL</th>
													
													<th>Upload</th>
													</tr>
												</thead>

												<tbody>
													<tr>

														<?php
														$nip = aman($row['nip']);
														$done = "selesai";
														if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE nip=:nip AND kondisi_instalasi_lak!=:done OR nip=:nip AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE nip=:nip AND kondisi_instalasi_pl!=:done OR nip=:nip AND kondisi_instalasi_pk!=:done OR nip=:nip AND kondisi_instalasi_tug!=:done OR nip=:nip AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":nip"=>$nip,":done"=>$done));

     			 										while($row1 = $stmt->fetch()){
																?>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" target="_blank"><?php echo $row1['id_detailproyek'];?></td>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;">

															<?php echo $row1['nama_proyeklantai'];?></a>
														</td>
														
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_lak'] != '') {
															echo $row1['file_instalasi_lak'];
														} else {
															echo '<span class="red">Belum Diupload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_lal'] != '') {
															echo $row1['file_instalasi_lal'];
														} else {
															echo '<span class="red">Belum Diupload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;">
														
															<?php if($row1['deskripsi_kondisi_instalasi_lak'] != '') {
															echo $row1['kondisi_instalasi_lak'].', '.$row1['deskripsi_kondisi_instalasi_lak'];
														} else {
															echo '<span class="red">Belum Diperiksa</span>';
														} ?>
														</td>
														
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;">
														
															<?php if($row1['deskripsi_kondisi_instalasi_lal'] != '') {
															echo $row1['kondisi_instalasi_lal'].', '.$row1['deskripsi_kondisi_instalasi_lal'];
														} else {
															echo '<span class="red">Belum Diperiksa</span>';
														} ?>
														</td>

														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<a class="blue" title="Upload File LAK" data-rel="tooltip" href="uploadproyek.php?kode=lak&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File LAK?')"></i>
																</a>


																
																<a class="red" name="btn-hapus" title="Upload File LAL" data-rel="tooltip"  href="uploadproyek.php?kode=lal&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File LAL?')"></i>
																</a>
																
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a class="blue" title="Upload File LAK" data-rel="tooltip" href="uploadproyek.php?kode=lak&id=<?php echo $row1['id_detailproyek'];?>">
																	
																

																				<span class="blue">
																					<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File LAK?')"></i>
																				</span>
																			</a>
																		
																		
																		
															
																<a class="red"  title="Upload File LAL" data-rel="tooltip" href="uploadproyek.php?kode=lal&id=<?php echo $row1['id_detailproyek'];?>">
																	
																

																				<span class="red">
																					<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File LAL?')"></i>
																				</span>
																			</a>
																
																
																		</li>
																	</ul>
																</div>
															</div>
														</td>
													</tr>
																<?php
															}



																?>
</tbody>
											</table>
											</form>
<?php } else { ?>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
											<form action="" method="post">
												<thead>
													<tr>
													<th>ID Proyek</th>
														<th>Nama Proyek</th>
														
														<th class="hidden-480">File Instalasi PL</th>
														<th class="hidden-480">File Instalasi PK</th>
														<th class="hidden-480">File Instalasi TUG</th>
														<th class="hidden-480">File Instalasi TDG</th>
														<th class="hidden-480">Status PL</th>
														<th class="hidden-480">Status PK</th>
														<th class="hidden-480">Status TUG</th>
														<th class="hidden-480">Status TDG</th>
													<th>Upload</th>
													</tr>
												</thead>

												<tbody>
													<tr>

														<?php
														$nip = aman($row['nip']);
														$done = "selesai";
														if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE nip=:nip AND kondisi_instalasi_lak!=:done OR nip=:nip AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE nip=:nip AND kondisi_instalasi_pl!=:done OR nip=:nip AND kondisi_instalasi_pk!=:done OR nip=:nip AND kondisi_instalasi_tug!=:done OR nip=:nip AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":nip"=>$nip,":done"=>$done));

     			 										while($row1 = $stmt->fetch()){
																?>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" target="_blank"><?php echo $row1['id_detailproyek'];?></td>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;">

															<?php echo $row1['nama_proyeklantai'];?></a>
														</td>
														
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_pl'] != '') {
															echo $row1['file_instalasi_pl'];
														} else {
															echo '<span class="red">Belum Diupload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_pk'] != '') {
															echo $row1['file_instalasi_pk'];
														} else {
															echo '<span class="red">Belum Diupload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_tug'] != '') {
															echo $row1['file_instalasi_tug'];
														} else {
															echo '<span class="red">Belum Diupload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_tdg'] != '') {
															echo $row1['file_instalasi_tdg'];
														} else {
															echo '<span class="red">Belum Diupload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;">
														
															<?php if($row1['deskripsi_kondisi_instalasi_pl'] != '') {
															echo $row1['kondisi_instalasi_pl'].', '.$row1['deskripsi_kondisi_instalasi_pl'];
														} else {
															echo '<span class="red">Belum Diperiksa</span>';
														} ?>
														</td>
														
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;">
														
															<?php if($row1['deskripsi_kondisi_instalasi_pk'] != '') {
															echo $row1['kondisi_instalasi_pk'].', '.$row1['deskripsi_kondisi_instalasi_pk'];
														} else {
															echo '<span class="red">Belum Diperiksa</span>';
														} ?>
														</td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;">
														
															<?php if($row1['deskripsi_kondisi_instalasi_tug'] != '') {
															echo $row1['kondisi_instalasi_tug'].', '.$row1['deskripsi_kondisi_instalasi_tug'];
														} else {
															echo '<span class="red">Belum Diperiksa</span>';
														} ?>
														</td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;">
														
															<?php if($row1['deskripsi_kondisi_instalasi_tdg'] != '') {
															echo $row1['kondisi_instalasi_tdg'].', '.$row1['deskripsi_kondisi_instalasi_tdg'];
														} else {
															echo '<span class="red">Belum Diperiksa</span>';
														} ?>
														</td>
														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<a class="blue" title="Upload File PL" data-rel="tooltip" href="uploadproyek.php?kode=pl&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File PL?')"></i>
																</a>


																
																<a class="red" name="btn-hapus" title="Upload File PK" data-rel="tooltip"  href="uploadproyek.php?kode=pk&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File PK?')"></i>
																</a>
																<a class="green" title="Upload File TUG" data-rel="tooltip" href="uploadproyek.php?kode=tug&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File TUG?')"></i>
																</a>


																
																<a class="orange" name="btn-hapus" title="Upload File TDG" data-rel="tooltip"  href="uploadproyek.php?kode=tdg&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File TDG?')"></i>
																</a>
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a class="blue"  title="Upload File PL" data-rel="tooltip" href="uploadproyek.php?kode=pl&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="blue">
																					<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File PL?')"></i>
																				</span>
																			</a>
																			
																			
															
																<a class="red" title="Upload File PK" data-rel="tooltip" href="uploadproyek.php?kode=pk&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="red">
																					<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File PK?')"></i>
																				</span>
																			</a>
																
																
																<a class="green"  title="Upload File TUG" data-rel="tooltip" href="uploadproyek.php?kode=tug&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="green">
																					<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File TUG?')"></i>
																				</span>
																			</a>

																			<a class="orange" title="Upload File TDG" data-rel="tooltip" href="uploadproyek.php?kode=tdg&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="orange">
																					<i class="ace-icon fa fa-cloud-upload bigger-130" onclick="return confirm('Upload File TDG?')"></i>
																				</span>
																			</a>
																		</li>
																	</ul>
																</div>
															</div>
														</td>
													</tr>
																<?php
															}



																?>
</tbody>
											</table>
											</form>
											<?php } ?>
											<?php } elseif($_GET['kode'] == 'lak' AND $_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid");
						}
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form5" action="" method="post" enctype="multipart/form-data">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>"/>
																		
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyeklantai'];?>" disabled/>
																	</div>
																</div>
															</div>
														<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Upload File LAK</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="file" name="fileToUpload" id="proyek" class="col-xs-12 col-sm-6 ace-file-container"/> 
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-submit" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } elseif($_GET['kode'] == 'lal' AND $_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid");
						}
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form5" action="" method="post" enctype="multipart/form-data">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>"/>
																		
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyeklantai'];?>" disabled/>
																	</div>
																</div>
															</div>
														<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Upload File LAL</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="file" name="fileToUpload" id="proyek" class="col-xs-12 col-sm-6 ace-file-container"/>
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-submit" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } elseif($_GET['kode'] == 'pl' AND $_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid");
						}
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form5" action="" method="post" enctype="multipart/form-data">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>"/>
																	
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyeklantai'];?>" disabled/>
																	</div>
																</div>
															</div>
														<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Upload File PL</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="file" name="fileToUpload" id="proyek" class="col-xs-12 col-sm-6 ace-file-container"/>
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-submit" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } elseif($_GET['kode'] == 'pk' AND $_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid");
						}
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form5" action="" method="post" enctype="multipart/form-data">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>"/>
																	
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyeklantai'];?>" disabled/>
																	</div>
																</div>
															</div>
														<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Upload File PK</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="file" name="fileToUpload" id="proyek" class="col-xs-12 col-sm-6 ace-file-container"/>
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-submit" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } elseif($_GET['kode'] == 'tug' AND $_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid");
						}
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form5" action="" method="post" enctype="multipart/form-data">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>"/>
																	
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyeklantai'];?>" disabled/>
																	</div>
																</div>
															</div>
														<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Upload File TUG</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="file" name="fileToUpload" id="proyek" class="col-xs-12 col-sm-6 ace-file-container"/>
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-submit" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } elseif($_GET['kode'] == 'tdg' AND $_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid");
						}
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form5" action="" method="post" enctype="multipart/form-data">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_detailproyek'];?>"/>
																	
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyeklantai'];?>" disabled/>
																	</div>
																</div>
															</div>
														<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Upload File TDG</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="file" name="fileToUpload" id="proyek" class="col-xs-12 col-sm-6 ace-file-container"/>
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-submit" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } ?>
											
										</div><!-- /.widget-main -->

									

										</div>
									</div>

								</div><!-- PAGE CONTENT ENDS -->


			<?php
		include 'footer.php';
		?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
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
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>
		<script src="assets/js/jquery-ui.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<script type="text/javascript">
			jQuery(function($) {
					$( "#id-btn-dialog2" ).on('click', function(e) {
					e.preventDefault();

					$( "#dialog-confirm" ).removeClass('hide').dialog({
						resizable: false,
						width: '320',
						modal: true,
						title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Empty the recycle bin?</h4></div>",
						title_html: true,
						buttons: [
							{
								html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete all items",
								"class" : "btn btn-danger btn-minier",
								click: function() {
									$( this ).dialog( "close" );
								}
							}
							,
							{
								html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
								"class" : "btn btn-minier",
								click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					});
				});
				});
				</script>
		<!-- inline scripts related to this page -->
		<?php if($row['bidang'] == 'Electrical') { ?>
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": true },
					  null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],


					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,

					//,
					//"sScrollY": "200px",
					//"bPaginate": false,

					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element

					//"iDisplayLength": 50


			    } );



				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: true

					  }
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );

				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});


				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {

					defaultColvisAction(e, dt, button, config);


					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});

				////

				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);





				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );




				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header

					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});

				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});



				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});



				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header

					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});

				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});



				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $source.offset();
					//var w2 = $source.width();

					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}




				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/





				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/


			})
		</script>
<?php } else { ?>
<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": true },
					  null, null,null, null, null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],


					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,

					//,
					//"sScrollY": "200px",
					//"bPaginate": false,

					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element

					//"iDisplayLength": 50


			    } );



				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: true

					  }
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );

				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});


				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {

					defaultColvisAction(e, dt, button, config);


					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});

				////

				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);





				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );




				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header

					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});

				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});



				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});



				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header

					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});

				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});



				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $source.offset();
					//var w2 = $source.width();

					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}




				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/





				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/


			})
		</script>
<?php } ?>
	</body>


</html>