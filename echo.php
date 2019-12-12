<?php
error_reporting(1);
  session_start();
    include "config/library.php";
  include "config/fungsi_autolink.php";
require_once 'class.user.php';

$user_home = new USER();


$stmt = $user_home->runQuery("SELECT * FROM users WHERE email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$b = $stmt->fetch(PDO::FETCH_ASSOC);
$c = $stmt->rowCount();
echo "email :";
echo $b['email'];
echo "<br>";
echo "session :";
echo $_SESSION['userSession'];
echo "<br>";
echo $c;
if($b['level'] != 'Owner') {
$stmt = $user_home->runQuery("SELECT * FROM users, pegawai WHERE users.email=:uid and pegawai.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$d = $stmt->rowCount();
echo "level = pegawai";
echo "<br>";
echo $d+1;
echo $row['email'];
echo "<br>";
echo $row['level'];
} else {
$stmt = $user_home->runQuery("SELECT * FROM users, owner WHERE users.email=:uid and owner.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "level = owner";
echo "<br>";

echo $row['email'];
echo "<br>";
echo $row['level'];
}

$lantai = 10;
$idproyek = "MALL-10-BER-001";
for ($i=1;$i<=$lantai;$i++) {
					$progress = 0;
			if($i < 10) {
				$detail = "DIT-".$idproyek."-0".$i;
			} elseif($i >= 10) {
				$detail = "DIT-".$idproyek."-".$i;
			}
			

			echo "<font color='blue'>".$detail."</font>";
			echo "<br>";
		}

		if(isset($_POST['btn-cth']))
{
	$a1 = aman($_POST['id1']);
	
	$chk = count($idproyek);
	$proyek = aman($_POST['proyek']);
	$lantai = aman($_POST['lantai']);
	$progress = aman("0");
	$owner = aman($_POST['owner']);
	$idproyek = aman($_GET['id']);
							$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
$stmt->execute(array(":uid"=>$idproyek));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
	$jml = $terpilih['total_lantai']; 
echo "<font color='red'>Tampil ID Proyek : $a1</font>";
	echo "</br>";
	echo "<font color='red'>Tampil ID Proyek : $a2</font>";
	echo "</br>";
	echo "<font color='red'>Count : $chk</font>";
	echo "</br>";
	echo "<font color='red'>Jumlah lantai : $jml</font>";
	echo "</br>";
	for ($i=1;$i<=$jml;$i++) {
		$a = $_POST['id'.$i];

		echo "<font color='blue'>".$a."</font>";
		echo "</br>";

		$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uid");
$stmt->execute(array(":uid"=>$a));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawai = $pgw['nama_pegawai'];
echo "<font color='blue'>".$pegawai."</font>";
echo "</br>";

	}
	
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
								<form class="form-horizontal" id="validation-form3" action="" method="post">
								
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
																		<input type="text" name="proyek" id="proyek" class="col-xs-12 col-sm-6" value="<?php echo $terpilih['nama_proyek'];?>"/>
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
												<select name="id<?php echo $lantai;?>" class="form-control" id="owner">
						      <option value="" selected>Pegawai</option>
									<?php
									
									$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE jabatan='Draugman'");
									$stmt->execute();

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
	<button id="loading-btn" type="submit" class="btn btn-primary" data-last="Finish" data-loading-text="Menyimpan..." name="btn-cth">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Contoh</span>
												</button>
												<button id="loading-btn1" type="reset" class="btn btn-warning" data-loading-text="Mereset..." name="btn-edit">
																								<i class="ace-icon fa fa-refresh"></i>
																								<span class="bigger-110">Reset</span>
																							</button>
																						</div>
																							</form>

											</div>
											<?php } else { ?>
											<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="" action="" method="get">
								
									
															
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



<?php 
echo "idm$lantai";
						
?>