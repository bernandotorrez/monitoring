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

 
if($row['level'] != 'Engineer') {
$user_home->redirect('index.php');
}

if(isset($_POST['btn-detail']))
{
$get = aman($_GET['id']);
header("Location: pembagianproyek.php?id=$get");
					exit;
}

if(isset($_POST['btn-electrical']))
{
	
	$lantai = aman($_GET['id']);

	$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
$stmt->execute(array(":uid"=>$lantai));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
	$jml = $terpilih['total_lantai']; 
	$basement = $terpilih['total_basement']; 
	$ground = $terpilih['total_ground']; 

for ($i=1;$i<=$jml;$i++) {
		
		$b = aman($_POST['ide'.$i]);
if($i < 10) {
				$detail = "DIT-".$lantai."-0".$i;
				$idlantai = $lantai."-0".$i;
				$namalantai = $proyek."-0".$i;
			} elseif($i >= 10) {
				$detail = "DIT-".$lantai."-".$i;
				$idlantai = $lantai."-".$i;
				$namalantai = $proyek."-".$i;
			}

$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uide");
$stmt->execute(array(":uide"=>$b));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaie = $pgw['nama_pegawai'];
	
			$stmt = $user_home->runQuery("UPDATE detailproyek_electrical SET nip=:nipe, nama_pegawai_electrical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipe",$b);
			$stmt->bindparam(":nama",$pegawaie);
			$stmt->bindparam(":uid",$detail);
			
				$result = $stmt->execute();	
			}
for ($i=1;$i<=$basement;$i++) {
		
		$b = aman($_POST['be'.$i]);

				$detail = "DIT-".$lantai."-B".$i;
				$idlantai = $lantai."-B".$i;
				$namalantai = $proyek."-B".$i;

$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uide");
$stmt->execute(array(":uide"=>$b));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaie = $pgw['nama_pegawai'];


			$stmt = $user_home->runQuery("UPDATE detailproyek_electrical SET nip=:nipe, nama_pegawai_electrical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipe",$b);
			$stmt->bindparam(":nama",$pegawaie);
			$stmt->bindparam(":uid",$detail);
			
				$result = $stmt->execute();	
			}
			for ($i=1;$i<=$ground;$i++) {
		
		$b = aman($_POST['ge'.$i]);

				$detail = "DIT-".$lantai."-GF";
				$idlantai = $lantai."-GF";
				$namalantai = $proyek."-GF";
			

$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uide");
$stmt->execute(array(":uide"=>$b));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaie = $pgw['nama_pegawai'];

			$stmt = $user_home->runQuery("UPDATE detailproyek_electrical SET nip=:nipe, nama_pegawai_electrical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipe",$b);
			$stmt->bindparam(":nama",$pegawaie);
			$stmt->bindparam(":uid",$detail);
			
				$result = $stmt->execute();	
			}
			if ($result) { 
  header("Location: pembagianproyek.php?inputsukses");
					exit;
} else {
    header("Location: pembagianproyek.php?gagal");
					exit;
}
	
}

if(isset($_POST['btn-mechanical']))
{
	
	$lantai = aman($_GET['id']);

	$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
$stmt->execute(array(":uid"=>$lantai));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
	$jml = $terpilih['total_lantai']; 
	$basement = $terpilih['total_basement']; 
	$ground = $terpilih['total_ground']; 

for ($i=1;$i<=$jml;$i++) {
		$a = aman($_POST['idm'.$i]);
		
if($i < 10) {
				$detail = "DIT-".$lantai."-0".$i;
				$idlantai = $lantai."-0".$i;
				$namalantai = $proyek."-0".$i;
			} elseif($i >= 10) {
				$detail = "DIT-".$lantai."-".$i;
				$idlantai = $lantai."-".$i;
				$namalantai = $proyek."-".$i;
			}
		$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uidm");
$stmt->execute(array(":uidm"=>$a));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaim = $pgw['nama_pegawai'];


			$stmt = $user_home->runQuery("UPDATE detailproyek_mechanical SET nip=:nipm, nama_pegawai_mechanical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipm",$a);
			$stmt->bindparam(":nama",$pegawaim);
			$stmt->bindparam(":uid",$detail);
			$result = $stmt->execute();	

		
			}
for ($i=1;$i<=$basement;$i++) {
		$a = aman($_POST['bm'.$i]);
		

				$detail = "DIT-".$lantai."-B".$i;
				$idlantai = $lantai."-B".$i;
				$namalantai = $proyek."-B".$i;
		
		$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uidm");
$stmt->execute(array(":uidm"=>$a));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaim = $pgw['nama_pegawai'];


			$stmt = $user_home->runQuery("UPDATE detailproyek_mechanical SET nip=:nipm, nama_pegawai_mechanical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipm",$a);
			$stmt->bindparam(":nama",$pegawaim);
			$stmt->bindparam(":uid",$detail);
			$result = $stmt->execute();	

		
			}
			for ($i=1;$i<=$ground;$i++) {
		$a = aman($_POST['gm'.$i]);
	

				$detail = "DIT-".$lantai."-GF";
				$idlantai = $lantai."-GF";
				$namalantai = $proyek."-GF";
			
		$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uidm");
$stmt->execute(array(":uidm"=>$a));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaim = $pgw['nama_pegawai'];


			$stmt = $user_home->runQuery("UPDATE detailproyek_mechanical SET nip=:nipm, nama_pegawai_mechanical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipm",$a);
			$stmt->bindparam(":nama",$pegawaim);
			$stmt->bindparam(":uid",$detail);
			$result = $stmt->execute();	

		
			}
			if ($result) { 
  header("Location: pembagianproyek.php?inputsukses");
					exit;
} else {
    header("Location: pembagianproyek.php?gagal");
					exit;
}
	
}

?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Pembagian Tugas Proyek - PT. Malmass Mitra Teknik</title>

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
									Pembagian Tugas Proyek
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
		}
		?>

		<?php if($_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<?php if($row['bidang'] == 'Electrical') { ?>
								<form class="form-horizontal" id="validation-form5" action="" method="post">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_proyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_proyek'];?>"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyek'];?>" disabled/>
																	</div>
																</div>
															</div>
															<?php
															$jml = $terpilih['total_lantai']; 
															for($lantai=1;$lantai<=$jml;$lantai++) {

															
															?>
														<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Draugman Lantai <?php echo $lantai;?></label>

										<div class="col-sm-9">
											
											<div class="inline">
												
								<select name="ide<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai Electrical</option>
									<?php
									$draug = "Draugman";
									$elec = "Electrical";
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan=:draug AND bidang=:elec");
									$stmt->execute(array(":draug"=>$draug,":elec"=>$elec));

						        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nip]>$row[nama_pegawai]</option>";
						      }
									?>
								</select>
											</div>

										</div>
									</div>
															<?php } ?>
															<?php
															$basement = $terpilih['total_basement']; 
															for($lantai=1;$lantai<=$basement;$lantai++) {

															
															?>
														<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Draugman Basement <?php echo $lantai;?></label>

										<div class="col-sm-9">
											
											<div class="inline">
												
								<select name="be<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai Electrical</option>
									<?php
									$draug = "Draugman";
									$elec = "Electrical";
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan=:draug AND bidang=:elec");
									$stmt->execute(array(":draug"=>$draug,":elec"=>$elec));

						        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nip]>$row[nama_pegawai]</option>";
						      }
									?>
								</select>
											</div>
											
										</div>
									</div>
															<?php } ?>
															
									<?php
															$ground = $terpilih['total_ground']; 
															for($lantai=1;$lantai<=$ground;$lantai++) {

															
															?>
														<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Draugman Ground <?php echo $lantai;?></label>

										<div class="col-sm-9">
											
											<div class="inline">
												
								<select name="ge<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai Electrical</option>
									<?php
									$draug = "Draugman";
									$elec = "Electrical";
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan=:draug AND bidang=:elec");
									$stmt->execute(array(":draug"=>$draug,":elec"=>$elec));

						        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nip]>$row[nama_pegawai]</option>";
						      }
									?>
								</select>
											</div>
											
										</div>
									</div>
															<?php } ?>

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" data-last="Finish" data-loading-text="Menyimpan..." name="btn-electrical">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>
								<?php } else { ?>
								<form class="form-horizontal" id="validation-form5" action="" method="post">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">ID Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_proyek'];?>" disabled/>
																		<input type="hidden" name="id" id="id" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['id_proyek'];?>"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama Proyek</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyek'];?>" disabled/>
																	</div>
																</div>
															</div>
															<?php
															$jml = $terpilih['total_lantai']; 
															for($lantai=1;$lantai<=$jml;$lantai++) {

															
															?>
														<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Draugman Lantai <?php echo $lantai;?></label>

										<div class="col-sm-9">
											<div class="inline">
												<select name="idm<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai Mechanical</option>
									<?php
									$draug = "Draugman";
									$mech = "Mechanical";
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan=:draug AND bidang=:mech");
									$stmt->execute(array(":draug"=>$draug,":mech"=>$mech));

						        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nip]>$row[nama_pegawai]</option>";
						      }
									?>
								</select>
								
											</div>
											

										</div>
									</div>
															<?php } ?>
															<?php
															$basement = $terpilih['total_basement']; 
															for($lantai=1;$lantai<=$basement;$lantai++) {

															
															?>
														<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Draugman Basement <?php echo $lantai;?></label>

										<div class="col-sm-9">
											<div class="inline">
												<select name="bm<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai Mechanical</option>
									<?php
									$draug = "Draugman";
									$mech = "Mechanical";
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan=:draug AND bidang=:mech");
									$stmt->execute(array(":draug"=>$draug,":mech"=>$mech));

						        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nip]>$row[nama_pegawai]</option>";
						      }
									?>
								</select>
								
											</div>
											
											
										</div>
									</div>
															<?php } ?>
															
									<?php
															$ground = $terpilih['total_ground']; 
															for($lantai=1;$lantai<=$ground;$lantai++) {

															
															?>
														<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Draugman Ground <?php echo $lantai;?></label>

										<div class="col-sm-9">
											<div class="inline">
												<select name="gm<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai Mechanical</option>
									<?php
									$draug = "Draugman";
									$mech = "Mechanical";
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan=:draug AND bidang=:mech");
									$stmt->execute(array(":draug"=>$draug,":mech"=>$mech));

						        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[nip]>$row[nama_pegawai]</option>";
						      }
									?>
								</select>
								
											</div>
											
											
										</div>
									</div>
															<?php } ?>

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" data-last="Finish" data-loading-text="Menyimpan..." name="btn-mechanical">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>
														<?php } ?>

											</div>
											<?php } else { ?>
											<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form4" action="" method="get">
								
									
															
																	<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Nama Proyek</label>

										<div class="col-sm-9">
											<div class="inline">
												<select name="id" class="form-control" id="owner">
						      <option value="" selected>Nama Proyek</option>
									<?php
									
									$stmt = $user_home->runQuery("SELECT * FROM proyek");
									$stmt->execute();

						       while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[id_proyek]>$row[nama_proyek]</option>";
						      }
									?>
								</select>
											</div>
										</div>
									</div>

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn3" type="submit" class="btn btn-primary" data-last="Finish" data-loading-text="Mohon Tunggu..." name="btn-detail">
													<i class="ace-icon fa fa-check"></i>
													<span class="bigger-110">Pilih</span>
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
