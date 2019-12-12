<!DOCTYPE html>
<?php
session_start();
error_reporting(1);
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

 
if($row['level'] != 'Direktur') {
$user_home->redirect('index.php');
}


if(isset($_POST['btn-submit']))
{
	$idproyek = aman($_POST['id']);
	$proyek = aman($_POST['proyek']);
	$jenis = aman($_POST['jenis']);
	$lokasi = aman($_POST['lokasi']);
	$lahan = aman($_POST['lahan']);
	$bangunan = aman($_POST['bangunan']);
	$totalbangunan = aman($_POST['totalbangunan']);
	$lantai = aman($_POST['lantai']);
	$basement = aman($_POST['basement']);
	$ground = aman(1);
	$own = aman($_POST['owner']);

	$stmt = $user_home->runQuery("SELECT * FROM owner WHERE id_owner=:owner");
	$stmt->execute(array(":owner"=>$own));
	$owne = $stmt->fetch(PDO::FETCH_ASSOC);
	$owner = $owne['nama_owner'];

	$arsitek = aman($_POST['arsitek']);
	$fungsi = aman($_POST['fungsi']);
	$tahun = aman($_POST['tahun']);
	$tglmulai = aman($_POST['tglmulai']);
	$tglselesai = aman($_POST['tglselesai']);
	$idl = aman("LAP-".$_POST['id']);
	$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
	$stmt->execute(array(":uid"=>$idproyek));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($stmt->rowCount() > 0)
	{
		header("Location: inputproyek.php?sudahada");
		exit;
	}
	else
	{
		if($user_home->inputproyek($idproyek,$proyek,$idl,$jenis,$lokasi,$lahan,$bangunan,$totalbangunan,$lantai,$basement,$ground,$own,$owner,$arsitek,$fungsi,$tahun,$tglmulai,$tglselesai))
		{

			header("Location: inputproyek.php?inputsukses");
					exit;
		}
		else
		{
			header("Location: inputproyek.php?gagal");
					exit;
		}

}
}

?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Input Data Proyek - PT. Malmass Mitra Teknik</title>

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
								Monitoring
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Input Data Proyek
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
										Input Data Proyek Berhasil.
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
										Input Data Proyek Gagal.
									</div></center>
           <?php
		} if(isset($_GET['sudahada'])) {
		?>

		
		
		<?php


			?><center>
            <div class="alert alert-warning alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-warning bigger-120 yellow"></i>
										ID Proyek Sudah Ada.
									</div></center>
            <?php
		}
		?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form3" action="" method="post">

									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="id">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-3" placeholder="17/MMT/001" autofocus="on" />
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="proyek">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-3" placeholder="Gedung BII 10 Lantai" maxlength="50" />
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="jenis">Jenis Bangunan</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<select name="jenis" id="jenis">
																	<option value="">Jenis Bangunan</option>
											<option value="Hotel" <?php if($row['jenis_bangunan']=="Hotel") echo "selected";?>>Hotel</option>
											<option value="Apartemen" <?php if($row['jenis_bangunan']=="Apartemen") echo "selected";?>>Apartemen</option>
											<option value="Kondominium" <?php if($row['jenis_bangunan']=="Kondominium") echo "selected";?>>Kondominium</option>
											<option value="Rumah Sakit" <?php if($row['jenis_bangunan']=="Rumah Sakit") echo "selected";?>>Rumah Sakit</option>
											<option value="Perkantoran" <?php if($row['jenis_bangunan']=="Perkantoran") echo "selected";?>>Perkantoran</option>
											<option value="Pabrik" <?php if($row['jenis_bangunan']=="Pabrik") echo "selected";?>>Pabrik</option>
											<option value="Bank" <?php if($row['jenis_bangunan']=="Bank") echo "selected";?>>Bank</option>
											<option value="Pusat Perbelanjaan" <?php if($row['jenis_bangunan']=="Pusat Perbelanjaan") echo "selected";?>>Pusat Perbelanjaan</option>
											<option value="Mall" <?php if($row['jenis_bangunan']=="Mall") echo "selected";?>>Mall</option>
											<option value="Pasar" <?php if($row['jenis_bangunan']=="Pasar") echo "selected";?>>Pasar</option>
											<option value="Real Estate" <?php if($row['jenis_bangunan']=="Real Estate") echo "selected";?>>Real Estate</option>
											<option value="Industrial Estate" <?php if($row['jenis_bangunan']=="Industrial Estate") echo "selected";?>>Industrial Estate</option>
											<option value="Dll" <?php if($row['jenis_bangunan']=="Dll") echo "selected";?>>Dll</option>
										</select>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Lokasi</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="lokasi" id="lokasi" class="col-xs-12 col-sm-3" placeholder="Jalan Kapten Tendean, Jakarta Selatan" maxlength="100"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Area Lahan</label>

																<div class="col-sm-9">
																	<div class="input-large">
																		<div class="input-group">
																		<input type="text" class="form-control" name="lahan" id="lahan" placeholder="1.000" maxlength="10"/>

																			<span class="input-group-addon">
																				m2
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Area Bangunan</label>

																<div class="col-sm-9">
																	<div class="input-large">
																		<div class="input-group">
																		<input type="text" class="form-control" name="bangunan" id="bangunan" placeholder="1.000" maxlength="10"/>

																			<span class="input-group-addon">
																				m2
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Total Bangunan</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="totalbangunan" id="totalbangunan" class="col-xs-12 col-sm-3" placeholder="1 Tower" maxlength="25"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Lantai</label>

																<div class="col-sm-9">
																	<div class="input-large">
																		<div class="input-group">
																		<input type="text" class="form-control" name="lantai" id="lantai" placeholder="10" maxlength="2"/>

																			<span class="input-group-addon">
																				Lt
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Basement</label>

																<div class="col-sm-9">
																	<div class="input-large">
																		<div class="input-group">
																		<input type="text" class="form-control" name="basement" id="basement" placeholder="2" maxlength="2"/>

																			<span class="input-group-addon">
																				Bs
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Owner</label>

																<div class="col-sm-9">
																	<div class="inline">
																		<select name="owner" class="form-control" id="owner" class="col-xs-12 col-sm-3">
												      <option value="" selected>Nama Owner</option>
															<?php

															$stmt = $user_home->runQuery("SELECT * FROM owner");
															$stmt->execute();

												       while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
												         echo "<option value=$row[id_owner]>$row[nama_owner]</option>";
												      }
															?>
														</select>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Arsitek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="arsitek" id="arsitek" class="col-xs-12 col-sm-3" placeholder="PT. Arsitek Indonesia" maxlength="50"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Fungsi Bangunan</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="fungsi" id="fungsi" class="col-xs-12 col-sm-3" placeholder="Gedung Perkantoran" maxlength="50"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Tahun</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="tahun" id="tahun" class="col-xs-12 col-sm-3" placeholder="2017" maxlength="4"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Tanggal Mulai</label>

																<div class="col-sm-9">
																	<div class="input-large">
																		<div class="input-group">
																		<input type="text" id="datepicker" class="form-control" data-date-format="yyyy-mm-dd" name="tglmulai" id="tglmulai" placeholder="yyyy-mm-dd"/>

																			<span class="input-group-addon">
																				<i class="ace-icon fa fa-calendar"></i>
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Tanggal Selesai</label>

																<div class="col-sm-9">
																	<div class="input-large">
																		<div class="input-group">
																		<input type="text" id="datepicker1" class="form-control" data-date-format="yyyy-mm-dd" name="tglselesai" id="tglselesai" placeholder="yyyy-mm-dd"/>

																			<span class="input-group-addon">
																				<i class="ace-icon fa fa-calendar"></i>
																			</span>
																		</div>
																	</div>
																</div>
															</div>


									<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Simpan</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
										</div><!-- /.widget-main -->

									<div class="hr hr-24"></div>

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
		<?php
		include 'script.php';
		?>
	</body>
</html>