<?php
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
?>

<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							<i class="fa fa-desktop"></i>
							Monitoring Proyek PT. Malmass Mitra Teknik
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks icon-animated-vertical"></i>
								<span class="badge badge-success">
								<?php
								if($menu['level'] != "Owner" ){
									$stmt = $user_home->runQuery("SELECT * FROM proyek");
														$stmt->execute();
														$itung = $stmt->rowCount();
														if($itung > 0) {
														echo $itung; 
														} else {
															echo "Belum Ada Proyek"; 
															}
														} else {
															$ido = $menu['id_owner'];
$stmt = $user_home->runQuery("SELECT * FROM proyek where id_owner=:ido");
															$stmt->execute(array(":ido"=>$ido));
														$itung = $stmt->rowCount();
														if($itung > 0) {
														echo $itung; 
														} else {
															echo "Belum Ada Proyek"; 
															}
															}
															?>
														
															
														</span>
								
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									Data Proyek
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
									<?php
									if($menu['level'] != "Owner" ){
									$stmt = $user_home->runQuery("SELECT * FROM proyek");
									$stmt->execute();
								} else {
									$ido = $menu['id_owner'];
									$stmt = $user_home->runQuery("SELECT * FROM proyek where id_owner=:ido");
															$stmt->execute(array(":ido"=>$ido));
								}
														

     			 										while($menu1 = $stmt->fetch()){
     			 											?>
								
										<li>
										<?php
									if($menu['level'] != "Owner" ){ ?>
											<a href="daftarproyek.php?id=<?php echo $menu1['id_proyek'];?>">
											<?php } else { ?>
											<a href="progressproyek.php?id=<?php echo $menu1['id_proyek'];?>">
											<?php } ?>
												<div class="clearfix">
													<span class="pull-left"><?php echo $menu1['nama_proyek'];?></span>
													<span class="pull-right"><?php echo $menu1['total_pengerjaan'];?>%</span>
												</div>

												<div class="progress progress-mini progress-striped active">
													<div style="width:<?php echo $menu1['total_pengerjaan'];?>%" 
													<?php  
													$progress = $menu1['total_pengerjaan'];
											  if($progress <= 25){
							echo "class='progress-bar progress-bar-danger'>";
						} elseif($progress <= 50){
							echo "class='progress-bar progress-bar-warning'>";
						}  elseif($progress <= 75){
							echo "class='progress-bar progress-bar-primary'>";
						} elseif($progress == 100){ 
							echo "class='progress-bar progress-bar-success'>";
						} else{ 
							echo "class='progress-bar progress-bar-success'>";
						}
						?>
						</div>
												</div>
											</a>
										</li>

									<?php } ?>
									</ul>
								</li>

								<li class="dropdown-footer">
								<?php if($menu['level'] != 'Owner') { ?>
									<a href="daftarproyek.php">
									<?php } else { ?>
									<a href="progressproyek.php">
									<?php } ?>
										Lihat Daftar Proyek
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">
								<?php
								if($menu['level'] == "Draugman" ){
									$nip = aman($menu['nip']);
														$done = "selesai";
														if($menu['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE nip=:nip AND kondisi_instalasi_lak!=:done OR nip=:nip AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE nip=:nip AND kondisi_instalasi_pl!=:done OR nip=:nip AND kondisi_instalasi_pk!=:done OR nip=:nip AND kondisi_instalasi_tug!=:done OR nip=:nip AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":nip"=>$nip,":done"=>$done));
														$itung = $stmt->rowCount();
														if($itung > 0) {
														echo $itung; 
														} else {
															echo "Tidak Ada Pemberitahuan"; 
															}
													} elseif($menu['level'] == "Owner" ) {
														$ido = $menu['id_owner'];
									$stmt = $user_home->runQuery("SELECT * FROM laporan_bulanan where id_owner=:ido");
															$stmt->execute(array(":ido"=>$ido));
															$itung = $stmt->rowCount();
														if($itung > 0) {
														echo $itung; 
														} else {
															echo "Tidak Ada Pemberitahuan"; 
															}
													} elseif($menu['level'] == "Engineer" ) {
														$nip = aman($menu['nip']);
									$nip = aman($row['nip']);
														$none = "";
														$done = "selesai";
														if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lak!=:done OR file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pl!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pk!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tug!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":none"=>$none,":done"=>$done));
															$itung = $stmt->rowCount();
														if($itung > 0) {
														echo $itung; 
														} else {
															echo "Tidak Ada Pemberitahuan"; 
															}
													} else {
														echo "Tidak Ada Pemberitahuan"; 
													}

														?>
															
														</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									<?php if($itung > 0 AND $menu['level'] == "Draugman" OR $menu['level'] == "Owner" OR $menu['level'] == "Engineer") {
														echo $itung." Pemberitahuan"; 
														} else {
															echo "Tidak Ada Pemberitahuan"; 
															} 
															?>
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
									<?php
									if($menu['level'] == "Draugman" ){
									$nip = aman($menu['nip']);
														$done = "selesai";
														if($menu['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE nip=:nip AND kondisi_instalasi_lak!=:done OR nip=:nip AND kondisi_instalasi_lal!=:done");
							$stmt->execute(array(":nip"=>$nip,":done"=>$done));
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE nip=:nip AND kondisi_instalasi_pl!=:done OR nip=:nip AND kondisi_instalasi_pk!=:done OR nip=:nip AND kondisi_instalasi_tug!=:done OR nip=:nip AND kondisi_instalasi_tdg!=:done");
							$stmt->execute(array(":nip"=>$nip,":done"=>$done));
						}
														
														
													} elseif($menu['level'] == "Owner" ) {
														$ido = $menu['id_owner'];
														$stmt = $user_home->runQuery("SELECT * FROM laporan_bulanan where id_owner=:ido");
															$stmt->execute(array(":ido"=>$ido));
													} elseif($menu['level'] == "Engineer" ) {
													$nip = aman($row['nip']);
														$none = "";
														$done = "selesai";
														if($row['bidang'] == 'Electrical') {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical WHERE file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lak!=:done OR file_instalasi_lak!=:none AND file_instalasi_lal!=:none AND kondisi_instalasi_lal!=:done");
						} else {
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_mechanical WHERE file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pl!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_pk!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tug!=:done OR file_instalasi_pl!=:none AND file_instalasi_pk!=:none AND file_instalasi_tug!=:none AND file_instalasi_tdg!=:none AND kondisi_instalasi_tdg!=:done");
						}
														
														$stmt->execute(array(":none"=>$none,":done"=>$done));
													}
														 while($menu2 = $stmt->fetch()){
     			 											?>
										<li>
										<?php if($menu['level'] == "Draugman" ){ ?>
											<a href="uploadproyek.php">
											<?php } elseif($menu['level'] == "Engineer" ) { ?>
												<a href="cekinstalasi.php">
												<?php } else { ?>
												<a href="laporan.php">
												<?php } ?>
												<div class="clearfix">
													<span class="pull-left"><?php 
													if($menu['level'] == "Draugman" ){
													echo $menu2['nama_proyeklantai'];
												} elseif($menu['level'] == "Engineer" ) {
													echo $menu2['nama_proyeklantai'];
												} else {

												}
													?>
														
													</span>
													
												</div>

												<div class="clearfix">
												<?php if($menu['level'] == "Draugman" OR $menu['level'] == "Engineer"){ ?>
													<span class="pull-left">
													<?php if($menu['bidang'] == 'Electrical') {
														if($menu2['deskripsi_kondisi_instalasi_lak'] !='') {
													echo "Ket LAK : ".$menu2['deskripsi_kondisi_instalasi_lak']."</br>";
												} else {
													echo  "Ket LAK : Belum di Periksa</br>";
												}
												if($menu2['deskripsi_kondisi_instalasi_lal'] !='') {
													echo "Ket LAL : ".$menu2['deskripsi_kondisi_instalasi_lal']."</br>";
												} else {
													echo  "Ket LAL : Belum di Periksa";
												}
												} else {
													if($menu2['deskripsi_kondisi_instalasi_pl'] !='') {
													echo "Ket PL : ".$menu2['deskripsi_kondisi_instalasi_pl']."</br>";
												} else {
													echo  "Ket PL : Belum di Periksa</br>";
												}
												if($menu2['deskripsi_kondisi_instalasi_pk'] !='') {
													echo "Ket PK : ".$menu2['deskripsi_kondisi_instalasi_pk']."</br>";
												} else {
													echo  "Ket PK : Belum di Periksa</br>";
												}
												if($menu2['deskripsi_kondisi_instalasi_tug'] !='') {
													echo "Ket TUG : ".$menu2['deskripsi_kondisi_instalasi_tug']."</br>";
												} else {
													echo  "Ket TUG : Belum di Periksa</br>";
												}
												if($menu2['deskripsi_kondisi_instalasi_tdg'] !='') {
													echo "Ket TDG : ".$menu2['deskripsi_kondisi_instalasi_tdg']."</br>";
												} else {
													echo  "Ket TDG : Belum di Periksa";
												}
													}
													?>
														
													</span>
													<?php } else { ?>
													<span class="pull-left">
													<?php 
													if($menu2['file'] != '') {
													echo "Laporan Bulanan dengan ID Proyek : ".$menu2['id_proyek']." <font class='alert-success'>Telah di Upload</font>"; 
												} else {
													echo "Laporan Bulanan dengan ID Proyek : ".$menu2['id_proyek']." <font class='alert-danger'>Belum di Upload</font>"; 
												}
													?>
													</span>
													<?php } ?>
												</div>
											</a>
										</li>

									<?php } ?>

										

										

										
									</ul>
								</li>
								<?php if($menu['level'] == 'Draugman') { ?>
								<li class="dropdown-footer">
									<a href="uploadproyek.php">
										Lihat Semua Pemberitahuan
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>

						

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<?php if($menu['foto'] != '' AND $menu['level'] != "Owner") { ?>
								<img class="nav-user-photo" alt="<?php echo $menu['nama_pegawai'];?>" width="40" height="40" src="avatar/<?php echo $menu['foto'];?>" />
								<?php } elseif($menu['foto'] == '' AND $menu['level'] != "Owner")  { ?>
								<img class="nav-user-photo" alt="<?php echo $menu['nama_pegawai'];?>" width="40" height="40"  src="assets/images/avatars/profile-pic.jpg" />
								<?php } elseif($menu['foto'] != '' AND $menu['level'] == "Owner") { ?>
									<img class="nav-user-photo" alt="<?php echo $menu['nama_owner'];?>" width="40" height="40" src="avatar/<?php echo $menu['foto'];?>" />
									<?php } elseif($menu['foto'] == '' AND $menu['level'] == "Owner")  { ?>
									<img class="nav-user-photo" alt="<?php echo $menu['nama_owner'];?>" width="40" height="40"  src="assets/images/avatars/profile-pic.jpg"/>
									<?php } ?>
							
								<span class="user-info">
									<small>Selamat Datang,</small>
									<?php
if($menu['level'] != "Owner") {
echo $menu['nama_pegawai'];
} else {
	echo $menu['nama_owner'];
}
?>

								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								
								<li>
								<?php if($menu['level'] != 'Owner') { ?>
									 <a href="pegawai.php">

										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
									<?php } else { ?>
									 <a href="owner.php">

										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
									<?php } ?>
								</li>

								<li class="divider"></li>

								<li>

								
									<a href="logout.php">
									
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
						<?php if($menu['level'] == 'Owner') { ?>
						<a href="owner.php">
						<?php } else { ?>
						<a href="pegawai.php">
						<?php } ?>
							<i class="ace-icon fa fa-pencil white"></i>
							</a>
						</button>


						<button class="btn btn-warning">
						<?php if ($menu['level'] == 'Admin') { ?>
						<a href="daftar.php">
							<i class="ace-icon fa fa-users white"></i>
							</a>
							<?php } else {?>
							<i class="ace-icon fa fa-users white"></i>
							<?php } ?>
						</button>

						<button class="btn btn-danger">
						<?php if ($menu['level'] == 'Admin') { ?>
						<a href="tables.php">
							<i class="ace-icon fa fa-cogs white"></i>
							</a>
							<?php } else {?>
							<i class="ace-icon fa fa-cogs white"></i>
							<?php } ?>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
				<?php if($_SERVER['SCRIPT_NAME'] == "/index.php") { ?>
					<li class="active">
					<?php } else { ?>
					<li class="">
						<?php } ?>
						<a href="index.php">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Beranda </span>
						</a>

						<b class="arrow"></b>
					</li>


					<?php if($_SERVER['SCRIPT_NAME'] == "/inputproyek.php" OR $_SERVER['SCRIPT_NAME'] == "/daftarproyek.php" OR $_SERVER['SCRIPT_NAME'] == "/detailproyek.php" OR $_SERVER['SCRIPT_NAME'] == "/progressproyek.php" OR $_SERVER['SCRIPT_NAME'] == "/uploadproyek.php" OR $_SERVER['SCRIPT_NAME'] == "/cekinstalasi.php" OR $_SERVER['SCRIPT_NAME'] == "/pembagianproyek.php" OR $_SERVER['SCRIPT_NAME'] == "/laporan.php") { ?>
					<li class="active open">
					<?php } else { ?>
					<li class="">
						<?php } ?>
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Monitoring
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<?php if($_SERVER['SCRIPT_NAME'] == "/inputproyek.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
						<?php if ($menu['level'] == 'Direktur') { ?>
								<a href="inputproyek.php">
								<i class="menu-icon fa fa-caret-right"></i>
									Input Proyek
								</a>
								<?php } else { ?>
								
								<?php } ?>
									

								<b class="arrow"></b>
							</li>
							<?php if($_SERVER['SCRIPT_NAME'] == "/daftarproyek.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
								<?php if ($menu['level'] == 'Engineer' OR $menu['level'] == 'Draugman' OR $menu['level'] == 'Direktur') { ?>
								<a href="daftarproyek.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Proyek
								</a>
								<?php } else { ?>
								
								<?php } ?>
								

								<b class="arrow"></b>
							</li>


							<?php if($_SERVER['SCRIPT_NAME'] == "/pembagianproyek.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
								<?php if ($menu['level'] == 'Engineer') { ?>
								<a href="pembagianproyek.php">
								<i class="menu-icon fa fa-caret-right"></i>
									Pembagian Kerja
								</a>
								<?php } else { ?>
								
								<?php } ?>
									

								<b class="arrow"></b>
							</li>

							<?php if($_SERVER['SCRIPT_NAME'] == "/progressproyek.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
								<?php if ($menu['level'] != 'Admin') { ?>
								<a href="progressproyek.php">
								<i class="menu-icon fa fa-caret-right"></i>
									Progress Proyek
								</a>
								<?php } else { ?>
								
								<?php } ?>
									

								<b class="arrow"></b>
							</li>

							<?php if($_SERVER['SCRIPT_NAME'] == "/uploadproyek.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
						<?php if ($menu['level'] == 'Draugman') { ?>
								<a href="uploadproyek.php">
								<i class="menu-icon fa fa-caret-right"></i>
									Upload Proyek
								</a>
								<?php } else { ?>
								
								<?php } ?>
									

								<b class="arrow"></b>
							</li>

							<?php if($_SERVER['SCRIPT_NAME'] == "/cekinstalasi.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
									<?php if ($menu['level'] == 'Engineer') { ?>
								<a href="cekinstalasi.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Cek Instalasi
								</a>
								<?php } else { ?>
								
								<?php } ?>
								

								<b class="arrow"></b>
							</li>

<?php if($_SERVER['SCRIPT_NAME'] == "/laporan.php") { ?>
							<li class="active">
							<?php } else { ?>
					<li class="">
						<?php } ?>
									<?php if ($menu['level'] == 'Direktur' OR $menu['level'] == 'Owner') { ?>
								<a href="laporan.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Laporan Bulanan
								</a>
								<?php } else { ?>
								
								<?php } ?>
								

								<b class="arrow"></b>
							</li>


						</ul>
					</li>
					<?php if($_SERVER['SCRIPT_NAME'] == "/pegawai.php" OR $_SERVER['SCRIPT_NAME'] == "/daftarpegawai.php" OR $_SERVER['SCRIPT_NAME'] == "/daftarowner.php" OR $_SERVER['SCRIPT_NAME'] == "/owner.php" OR $_SERVER['SCRIPT_NAME'] == "/daftarakun.php") { ?>
					<li class="active open">
					<?php } else { ?>
					<li class="">
					<?php } ?>
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Data </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						<?php if($_SERVER['SCRIPT_NAME'] == "/daftarakun.php") { ?>
							<li class="active">
					<?php } else { ?>
					<li class="">
					<?php } ?>
								<?php if ($menu['level'] != 'Admin') { ?>
								
								<?php } else {?>
								<a href="daftarakun.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Akun
								</a>
								<?php } ?>
							<?php if($_SERVER['SCRIPT_NAME'] == "/daftarpegawai.php") { ?>
							<li class="active">
					<?php } else { ?>
					<li class="">
					<?php } ?>
								<?php if ($menu['level'] == 'Owner') { ?>
								
								<?php } else {?>
								<a href="daftarpegawai.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Pegawai
								</a>
								<?php } ?>


								<b class="arrow"></b>
							</li>
							<?php if($_SERVER['SCRIPT_NAME'] == "/daftarowner.php") { ?>
							<li class="active">
					<?php } else { ?>
					<li class="">
					<?php } ?>
								<?php if ($menu['level'] == 'Owner' OR $menu['level'] == 'Draugman') { ?>
								
								<?php } else {?>
								<a href="daftarowner.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Owner
								</a>
								<?php } ?>


								<b class="arrow"></b>
							</li>

							<?php if($_SERVER['SCRIPT_NAME'] == "/pegawai.php" OR $_SERVER['SCRIPT_NAME'] == "/owner.php") { ?>
							<li class="active">
					<?php } else { ?>
					<li class="">
					<?php } ?>
								<?php if ($menu['level'] != 'Owner') { ?>
								<a href="pegawai.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Profil Anda
								</a>
								<?php } else {?>
								<a href="owner.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Profil Anda
								</a>
								<?php } ?>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<?php if($_SERVER['SCRIPT_NAME'] == "/profilperusahaan.php") { ?>
					<li class="active open">
					<?php } else { ?>
					<li class="">
					<?php } ?>
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text"> Profil Perusahaan </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<?php if($_SERVER['SCRIPT_NAME'] == "/profilperusahaan.php") { ?>
					<li class="active">
					<?php } else { ?>
					<li class="">
					<?php } ?>
						<?php if ($menu['level'] == 'Admin') { ?>
								<a href="profilperusahaan.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Profil Perusahaan
								</a>

								<?php } else { ?>
					
					<?php } ?>
								
								<b class="arrow"></b>
							</li>


						</ul>
					</li>

					
					
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">

							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="index.php">Beranda</a>
							</li>
							<?php if($_SERVER['SCRIPT_NAME'] == '/index.php') { ?>
							<li class="active">Halaman Utama</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/pegawai.php' OR $_SERVER['SCRIPT_NAME'] == '/owner.php') { ?>

							<li class="active">Akun</li>
							<li class="active">Profil Anda</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/daftarpegawai.php') { ?>
							<li class="active">Akun</li>
							<li class="active">Data Pegawai</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/daftarowner.php') { ?>
							<li class="active">Akun</li>
							<li class="active">Data Owner</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/daftarakun.php') { ?>
							<li class="active">Akun</li>
							<li class="active">Data Akun</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/inputproyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Input Proyek</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/daftarproyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Data Proyek</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/detailproyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Detail Proyek</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/pembagianproyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Pembagian Kerja</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/proyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Detail Proyek</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/progressproyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Progress Proyek</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/uploadproyek.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Upload Proyek</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/cekinstalasi.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Cek Hasil Gambar Instalasi</li>
								<?php } elseif($_SERVER['SCRIPT_NAME'] == '/laporan.php') { ?>
							<li class="active">Monitoring</li>
							<li class="active">Laporan Bulanan</li>
							<?php } elseif($_SERVER['SCRIPT_NAME'] == '/profilperusahaan.php') { ?>
							<li class="active">Input</li>
							<li class="active">Profil Perusahaan</li>
							<?php } ?>
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">