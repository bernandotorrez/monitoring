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

if($row['status_profil'] == 'belum'){
	if($row['level'] != 'Owner') {
	$user_home->redirect('pegawai.php?aksi=isibiodatakamu');
} else {
	$user_home->redirect('owner.php?aksi=isibiodatakamu');
}
}

if($row['level'] != 'Engineer') {
$user_home->redirect('index.php');
}

if(isset($_POST['btn-pilihlak']))
{
$get = aman($_GET['id']);
$kode = aman($_GET['kode']);
header("Location: cekinstalasi.php?kode=$kode&id=$get");
					exit;
}

if($_GET['kode'] != '' AND $_GET['id'] != '') {
	if($row['bidang'] == 'Electrical') {
		$id = aman($_GET['id']);
	$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$pro = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	$id = aman($_GET['id']);
	$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE id_detailproyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$id));
$pro = $stmt->fetch(PDO::FETCH_ASSOC);
}
}

$l = $pro['id_proyek'];
$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$l));
$proyek = $stmt->fetch(PDO::FETCH_ASSOC);

$lantai = $proyek['total_lantai']+$proyek['total_basement']+$proyek['total_ground'];
$semua = 100;
$perlantai = $semua/$lantai;

$electrical = $perlantai/2;
$lak = $electrical/2;
$lal = $electrical/2;

$mechanical = $perlantai/2;
$pl = $mechanical/4;
$pk = $mechanical/4;
$tug = $mechanical/4;
$tdg = $mechanical/4;
$progress = $proyek['total_pengerjaan'];

if(isset($_POST['btn-lak']))
{
	$status = aman($_POST['statuslak']);
	
	$id = aman($_GET['id']);
	if($status == 'selesai') {
		$ceklak = $lak;
		$deskripsi = aman("Instalasi LAK Selesai");
	} else {
		$ceklak = aman(0);
		$deskripsi = aman($_POST['deskripsi']);
	}

	$progresss = $progress+$ceklak;	
	$l = $pro['id_proyek'];
		if($user_home->ceklak($status,$deskripsi,$ceklak,$id,$progresss,$l))
		{

			header("Location: cekinstalasi.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: cekinstalasi.php?gagal");
					exit;
		}
}

if(isset($_POST['btn-lal']))
{
	$status = aman($_POST['statuslal']);
	
	$id = aman($_GET['id']);
	if($status == 'selesai') {
		$ceklal = $lal;
		$deskripsi = aman("Instalasi LAL Selesai");
	} else {
		$ceklal = aman(0);
		$deskripsi = aman($_POST['deskripsi']);
	}

	$progresss = $progress+$ceklal;	
	$l = $pro['id_proyek'];
		if($user_home->ceklal($status,$deskripsi,$ceklal,$id,$progresss,$l))
		{

			header("Location: cekinstalasi.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: cekinstalasi.php?gagal");
					exit;
		}
}

if(isset($_POST['btn-pl']))
{
	$status = aman($_POST['statuspl']);
	
	$id = aman($_GET['id']);
	if($status == 'selesai') {
		$cekpl = $pl;
		$deskripsi = aman("Instalasi PL Selesai");
	} else {
		$cekpl = aman(0);
		$deskripsi = aman($_POST['deskripsi']);
	}

	$progresss = $progress+$cekpl;	
	$l = $pro['id_proyek'];
		if($user_home->cekpl($status,$deskripsi,$cekpl,$id,$progresss,$l))
		{

			header("Location: cekinstalasi.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: cekinstalasi.php?gagal");
					exit;
		}
}

if(isset($_POST['btn-pk']))
{
	$status = aman($_POST['statuspk']);
	
	$id = aman($_GET['id']);
	if($status == 'selesai') {
		$cekpk = $pk;
		$deskripsi = aman("Instalasi PK Selesai");
	} else {
		$cekpk = aman(0);
		$deskripsi = aman($_POST['deskripsi']);
	}

	$progresss = $progress+$cekpk;	
	$l = $pro['id_proyek'];
		if($user_home->cekpk($status,$deskripsi,$cekpk,$id,$progresss,$l))
		{

			header("Location: cekinstalasi.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: cekinstalasi.php?gagal");
					exit;
		}
}

if(isset($_POST['btn-tug']))
{
	$status = aman($_POST['statustug']);
	
	$id = aman($_GET['id']);
	if($status == 'selesai') {
		$cektug = $tug;
		$deskripsi = aman("Instalasi TUG Selesai");
	} else {
		$cektug = aman(0);
		$deskripsi = aman($_POST['deskripsi']);
	}

	$progresss = $progress+$cektug;	
	$l = $pro['id_proyek'];
		if($user_home->cektug($status,$deskripsi,$cektug,$id,$progresss,$l))
		{

			header("Location: cekinstalasi.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: cekinstalasi.php?gagal");
					exit;
		}
}

if(isset($_POST['btn-tdg']))
{
	$status = aman($_POST['statustdg']);
	
	$id = aman($_GET['id']);
	if($status == 'selesai') {
		$cektdg = $tdg;
		$deskripsi = aman("Instalasi TDG Selesai");
	} else {
		$cektdg = aman(0);
		$deskripsi = aman($_POST['deskripsi']);
	}

	$progresss = $progress+$cektdg;	
	$l = $pro['id_proyek'];
		if($user_home->cektdg($status,$deskripsi,$cektdg,$id,$progresss,$l))
		{

			header("Location: cekinstalasi.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: cekinstalasi.php?gagal");
					exit;
		}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Cek Instalasi - PT. Malmass Mitra Teknik</title>

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
									Cek Instalasi
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
										Cek Instalasi Berhasil.
									</div></center>
            <?php
		} if(isset($_GET['gagal'])) {
		?>
		<?php


			?><center>
            <div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-close bigger-120 red"></i>
										Cek Instalasi Gagal.
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
			<i class="blue ace-icon fa fa-check-square-o bigger-130"></i> = Cek Instalasi File LAK </br>
						<i class="red ace-icon fa fa-check-square-o bigger-130"></i> = Cek Instalasi File LAL
						<?php } else { ?>
						<i class="blue ace-icon fa fa-check-square-o bigger-130"></i> = Cek Instalasi File PL </br>
						<i class="red ace-icon fa fa-check-square-o bigger-130"></i> = Cek Instalasi File PK </br>
						<i class="green ace-icon fa fa-check-square-o bigger-130"></i> = Cek Instalasi File TUG </br>
						<i class="orange ace-icon fa fa-check-square-o bigger-130"></i> = Cek Instalasi File TDG
						<?php } ?>
						</h3>
										<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Daftar Cek Instalasi
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
													
													<th>Cek Instalasi</th>
													</tr>
												</thead>

												<tbody>
													<tr>

														<?php
														$nip = aman($row['nip']);
														$none = "";
														$done = "selesai";
														if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lak!=:done OR file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pl!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pk!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tug!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":none"=>$none,":done"=>$done));

     			 										while($row1 = $stmt->fetch()){
																?>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" target="_blank"><?php echo $row1['id_detailproyek'];?></td>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;">

															<?php echo $row1['nama_proyeklantai'];?></a>
														</td>
														
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_lak'] != '') {
															echo "<a href='cekinstalasi.php?kode=lak&id=".$row1['id_detailproyek']."'>".$row1['file_instalasi_lak']."</a>";
														} else {
															echo '<span class="red">Belum Upload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_lal'] != '') {
															echo "<a href='cekinstalasi.php?kode=lal&id=".$row1['id_detailproyek']."'>".$row1['file_instalasi_lal']."</a>";
														} else {
															echo '<span class="red">Belum Upload</span>';
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
																<a class="blue" title="Cek Instalasi LAK" data-rel="tooltip" href="cekinstalasi.php?kode=lak&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi LAK?')"></i>
																</a>


																
																<a class="red" name="btn-hapus" title="Cek Instalasi LAL" data-rel="tooltip"  href="cekinstalasi.php?kode=lal&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi LAL?')"></i>
																</a>
																
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a class="blue" title="Cek Instalasi LAK" data-rel="tooltip" href="cekinstalasi.php?kode=lak&id=<?php echo $row1['id_detailproyek'];?>">
																	
																

																				<span class="blue">
																					<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi LAK?')"></i>
																				</span>
																			</a>
																															
																	
															
																<a class="red"  title="Cek Instalasi LAL" data-rel="tooltip" href="cekinstalasi.php?kode=lal&id=<?php echo $row1['id_detailproyek'];?>">
																	
																

																				<span class="red">
																					<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi LAL?')"></i>
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
													<th>Cek</th>
													</tr>
												</thead>

												<tbody>
													<tr>

														<?php
														$nip = aman($row['nip']);
														$none = "";
														$done = "selesai";
														if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lak!=:done OR file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pl!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pk!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tug!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":none"=>$none,":done"=>$done));

     			 										while($row1 = $stmt->fetch()){
																?>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" target="_blank"><?php echo $row1['id_detailproyek'];?></td>
																<td style="word-wrap: break-word;min-width: 120px;max-width: 120px;">

															<?php echo $row1['nama_proyeklantai'];?></a>
														</td>
														
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_pl'] != '') {
															echo "<a href='cekinstalasi.php?kode=pl&id=".$row1['id_detailproyek']."'>".$row1['file_instalasi_pl']."</a>";
														} else {
															echo '<span class="red">Belum Upload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_pk'] != '') {
															echo "<a href='cekinstalasi.php?kode=pk&id=".$row1['id_detailproyek']."'>".$row1['file_instalasi_pk']."</a>";
														} else {
															echo '<span class="red">Belum Upload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_tug'] != '') {
															echo "<a href='cekinstalasi.php?kode=tug&id=".$row1['id_detailproyek']."'>".$row1['file_instalasi_tug']."</a>";
														} else {
															echo '<span class="red">Belum Upload</span>';
														} ?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php if($row1['file_instalasi_tdg'] != '') {
															echo "<a href='cekinstalasi.php?kode=tdg&id=".$row1['id_detailproyek']."'>".$row1['file_instalasi_tdg']."</a>";
														} else {
															echo '<span class="red">Belum Upload</span>';
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
																<a class="blue" title="Cek Instalasi PL" data-rel="tooltip" href="cekinstalasi.php?kode=pl&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi PL?')"></i>
																</a>


																
																<a class="red" name="btn-hapus" title="Cek Instalasi PK" data-rel="tooltip"  href="cekinstalasi.php?kode=pk&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi PK?')"></i>
																</a>
																<a class="green" title="Cek Instalasi TUG" data-rel="tooltip" href="cekinstalasi.php?kode=tug&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi TUG?')"></i>
																</a>


																
																<a class="orange" name="btn-hapus" title="Cek Instalasi TDG" data-rel="tooltip"  href="cekinstalasi.php?kode=tdg&id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi TDG?')"></i>
																</a>
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a class="blue"  title="Cek Instalasi PL" data-rel="tooltip" href="cekinstalasi.php?kode=pl&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="blue">
																					<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi PL?')"></i>
																				</span>
																			</a>
																			
																			
															
																<a class="red" title="Cek Instalasi PK" data-rel="tooltip" href="cekinstalasi.php?kode=pk&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="red">
																					<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi PK?')"></i>
																				</span>
																			</a>
																
																
																<a class="green"  title="Cek Instalasi TUG" data-rel="tooltip" href="cekinstalasi.php?kode=tug&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="green">
																					<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi TUG?')"></i>
																				</span>
																			</a>

																			<a class="orange" title="Cek Instalasi TDG" data-rel="tooltip" href="cekinstalasi.php?kode=tdg&id=<?php echo $row1['id_detailproyek'];?>">
																	
															

																				<span class="orange">
																					<i class="ace-icon fa fa-check-square-o bigger-130" onclick="return confirm('Cek Instalasi TDG?')"></i>
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
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">File Instalasi LAK</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<a href="proyek/electrical/<?php echo $terpilih['file_instalasi_lak'];?>" target="_blank">File LAK</a>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Instalasi LAK</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="statuslak" id="status" class="ace" value="selesai" <?php if($pro['kondisi_instalasi_lak']=="selesai") echo "checked";?>/>
																		<span class="lbl middle"> Selesai</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuslak" id="status" class="ace" value="belum" <?php if($pro['kondisi_instalasi_lak']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuslak" id="status" class="ace" value="salah" <?php if($pro['kondisi_instalasi_lak']=="salah") echo "checked";?>/>
																		<span class="lbl middle"> Salah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Deskripsi Instalasi LAK</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																			<textarea class="input-large" name="deskripsi" id="alamat" placeholder="Diisi jika status instalasi belum benar atau salah" maxlength="50"><?php echo $pro['deskripsi_kondisi_instalasi_lak'];?></textarea>
																	</div>
																</div>
															</div>
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-lak" data-last="Finish" data-loading-text="Menyimpan...">
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
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">File Instalasi LAL</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																	<a href="proyek/electrical/<?php echo $terpilih['file_instalasi_lal'];?>" target="_blank">File LAL</a>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Instalasi LAL</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="statuslal" id="status" class="ace" value="selesai" <?php if($pro['kondisi_instalasi_lal']=="selesai") echo "checked";?>/>
																		<span class="lbl middle"> Selesai</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuslal" id="status" class="ace" value="belum" <?php if($pro['kondisi_instalasi_lal']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuslal" id="status" class="ace" value="salah" <?php if($pro['kondisi_instalasi_lal']=="salah") echo "checked";?>/>
																		<span class="lbl middle"> Salah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Deskripsi Instalasi LAL</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																			<textarea class="input-large" name="deskripsi" id="alamat" placeholder="Diisi jika status instalasi belum benar atau salah" maxlength="250"><?php echo $pro['deskripsi_kondisi_instalasi_lal'];?></textarea>
																	</div>
																</div>
															</div>
															
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-lal" data-last="Finish" data-loading-text="Menyimpan...">
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
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">File Instalasi PL</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<a href="proyek/mechanical/<?php echo $terpilih['file_instalasi_pl'];?>" target="_blank">File PL</a>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Instalasi PL</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="statuspl" id="status" class="ace" value="selesai" <?php if($pro['kondisi_instalasi_pl']=="selesai") echo "checked";?>/>
																		<span class="lbl middle"> Selesai</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuspl" id="status" class="ace" value="belum" <?php if($pro['kondisi_instalasi_pl']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuspl" id="status" class="ace" value="salah" <?php if($pro['kondisi_instalasi_pl']=="salah") echo "checked";?>/>
																		<span class="lbl middle"> Salah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Deskripsi Instalasi PL</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																			<textarea class="input-large" name="deskripsi" id="alamat" placeholder="Diisi jika status instalasi belum benar atau salah" maxlength="50"><?php echo $pro['deskripsi_kondisi_instalasi_pl'];?></textarea>
																	</div>
																</div>
															</div>
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-pl" data-last="Finish" data-loading-text="Menyimpan...">
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
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">File Instalasi PK</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<a href="proyek/mechanical/<?php echo $terpilih['file_instalasi_pk'];?>" target="_blank">File PK</a>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Instalasi PK</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="statuspk" id="status" class="ace" value="selesai" <?php if($pro['kondisi_instalasi_pk']=="selesai") echo "checked";?>/>
																		<span class="lbl middle"> Selesai</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuspk" id="status" class="ace" value="belum" <?php if($pro['kondisi_instalasi_pk']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statuspk" id="status" class="ace" value="salah" <?php if($pro['kondisi_instalasi_pk']=="salah") echo "checked";?>/>
																		<span class="lbl middle"> Salah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Deskripsi Instalasi PK</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																			<textarea class="input-large" name="deskripsi" id="alamat" placeholder="Diisi jika status instalasi belum benar atau salah" maxlength="50"><?php echo $pro['deskripsi_kondisi_instalasi_pk'];?></textarea>
																	</div>
																</div>
															</div>
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-pk" data-last="Finish" data-loading-text="Menyimpan...">
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
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">File Instalasi TUG</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<a href="proyek/mechanical/<?php echo $terpilih['file_instalasi_tug'];?>" target="_blank">File TUG</a>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Instalasi TUG</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="statustug" id="status" class="ace" value="selesai" <?php if($pro['kondisi_instalasi_tug']=="selesai") echo "checked";?>/>
																		<span class="lbl middle"> Selesai</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statustug" id="status" class="ace" value="belum" <?php if($pro['kondisi_instalasi_tug']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statustug" id="status" class="ace" value="salah" <?php if($pro['kondisi_instalasi_tug']=="salah") echo "checked";?>/>
																		<span class="lbl middle"> Salah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Deskripsi Instalasi TUG</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																			<textarea class="input-large" name="deskripsi" id="alamat" placeholder="Diisi jika status instalasi belum benar atau salah" maxlength="50"><?php echo $pro['deskripsi_kondisi_instalasi_tug'];?></textarea>
																	</div>
																</div>
															</div>
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-tug" data-last="Finish" data-loading-text="Menyimpan...">
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
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">File Instalasi TDG</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																	<a href="proyek/mechanical/<?php echo $terpilih['file_instalasi_tdg'];?>" target="_blank">File TDG</a>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Instalasi TDG</label>

																<div class="col-sm-9">
																	<label class="inline">

																		<input type="radio" name="statustdg" id="status" class="ace" value="selesai" <?php if($pro['kondisi_instalasi_tdg']=="selesai") echo "checked";?>/>
																		<span class="lbl middle"> Selesai</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statustdg" id="status" class="ace" value="belum" <?php if($pro['kondisi_instalasi_tdg']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input type="radio" name="statustdg" id="status" class="ace" value="salah" <?php if($pro['kondisi_instalasi_tdg']=="salah") echo "checked";?>/>
																		<span class="lbl middle"> Salah</span>
																	</label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Deskripsi Instalasi TDG</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																			<textarea class="input-large" name="deskripsi" id="alamat" placeholder="Diisi jika status instalasi belum benar atau salah" maxlength="50"><?php echo $pro['deskripsi_kondisi_instalasi_tdg'];?></textarea>
																	</div>
																</div>
															</div>
									

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" name="btn-tdg" data-last="Finish" data-loading-text="Menyimpan...">
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
