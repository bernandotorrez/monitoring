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

 
if($row['level'] == 'Admin') {
$user_home->redirect('index.php');
}

if(isset($_POST['btn-detail']))
{
$get = aman($_GET['id']);
header("Location: progressproyek.php?id=$get");
					exit;
}

if(isset($_POST['btn-submit']))
{
	
	$lantai = aman($_GET['id']);

	$stmt = $user_home->runQuery("SELECT * FROM proyek WHERE id_proyek=:uid");
$stmt->execute(array(":uid"=>$lantai));
$terpilih = $stmt->fetch(PDO::FETCH_ASSOC);
	$jml = $terpilih['total_lantai']; 

for ($i=1;$i<=$jml;$i++) {
		$a = aman($_POST['idm'.$i]);
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
		$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uidm");
$stmt->execute(array(":uidm"=>$a));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaim = $pgw['nama_pegawai'];

$stmt = $user_home->runQuery("SELECT * FROM pegawai WHERE nip=:uide");
$stmt->execute(array(":uide"=>$b));
$pgw = $stmt->fetch(PDO::FETCH_ASSOC);
$pegawaie = $pgw['nama_pegawai'];
			$stmt = $user_home->runQuery("UPDATE detailproyek_mechanical SET nip=:nipm, nama_pegawai_mechanical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipm",$a);
			$stmt->bindparam(":nama",$pegawaim);
			$stmt->bindparam(":uid",$detail);
			$result = $stmt->execute();	

			$stmt = $user_home->runQuery("UPDATE detailproyek_electrical SET nip=:nipe, nama_pegawai_electrical=:nama WHERE id_detailproyek=:uid");
			$stmt->bindparam(":nipe",$b);
			$stmt->bindparam(":nama",$pegawaie);
			$stmt->bindparam(":uid",$detail);
			
				$result = $stmt->execute();	
			}

			if ($result) { 
  header("Location: progressproyek.php?inputsukses");
					exit;
} else {
    header("Location: progressproyek.php?gagal");
					exit;
}
		
	

	
}


?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Progress Proyek - PT. Malmass Mitra Teknik</title>

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
									Progress Proyek
								</small>
							</h1>
						</div><!-- /.page-header -->

						

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

		

						
							<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<?php if($_GET['id'] != '') {
							$idproyek = aman($_GET['id']);
							$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical INNER JOIN detailproyek_mechanical ON detailproyek_electrical.id_detailproyek=detailproyek_mechanical.id_detailproyek WHERE detailproyek_electrical.id_proyek=:uid");
$stmt->execute(array(":uid"=>$idproyek));



     			 										while($row1 = $stmt->fetch()){ 
$listrik = $row1['instalasi_lak'];
$lampu = $row1['instalasi_lal'];
$telepon = $row1['instalasi_pl'];
$stop = $row1['instalasi_pk'];
$alarm = $row1['instalasi_tug'];
$sound = $row1['instalasi_tdg'];

$e = $listrik+$stop+$lampu+$telepon+$alarm+$sound;
$me = $telepon+$alarm+$sound+$stop; 
$el = $listrik+$lampu;
     			 											?>
									<div class="col-xs-6 col-sm-3 pricing-box">
										<div class="widget-box widget-color-blue">
											<div class="widget-header">
												<h5 class="widget-title bigger lighter"><?php echo $row1['nama_proyeklantai'];?></h5>
											</div>

											<div class="widget-body">
												<div class="widget-main">
													<ul class="list-unstyled spaced2">
														<li>
															<i class="ace-icon fa fa-bolt green"></i>
															+ Electrical : <span class='bigger-110 green'><?php echo $el;?>%</span>  <?php if($row1['kondisi_instalasi_lak'] == 'selesai' AND $row1['kondisi_instalasi_lal'] == 'selesai') { 
																echo "<span class='bigger-110 green'>(Selesai)</span>"; 
															} else {
																echo "<span class='bigger-110 red'>(Belum)</span>"; 
															}
															?>
																	
														</li>

														<li>
														
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															- Instalasi LAK : <?php echo $listrik;?>%

														</li>

														<li>
														
															&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
															- Instalasi Lal : <?php echo $lampu;?>%

														</li>

														
														<li>
															<i class="ace-icon fa fa-legal blue"></i>
															+ Mechanical : <span class='bigger-110 blue'><?php echo $me;?>%</span>
															<?php if($row1['kondisi_instalasi_pl'] == 'selesai' AND $row1['kondisi_instalasi_pk'] == 'selesai' AND $row1['kondisi_instalasi_tug'] == 'selesai' AND $row1['kondisi_instalasi_tdg'] == 'selesai') { 
																echo "<span class='bigger-110 blue'>(Selesai)</span>"; 
															} else {
																echo "<span class='bigger-110 red'>(Belum)</span>"; 
															}
															?>
														</li>

														<li>
														
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															- Instalasi PL : <?php echo $telepon;?>%
														</li>

														<li>
														
															&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
															- Instalasi PK : <?php echo $stop;?>%

														</li>

														<li>
															
															&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
															- Instalasi TUG : <?php echo $alarm;?>%
														</li>

														<li>
															
															&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
															- Instalasi TDG : <?php echo $sound;?>%
														</li>
													</ul>

													<hr />
													<div class="price">
													
													
															Total Instalasi : <span class='bigger-110 orange'><?php echo $e;?>%</span>
													
													</div>
												</div>

												<div>
													<a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" class="btn btn-block btn-primary">
														
														<span>
														<?php if($row1['kondisi_instalasi_lak'] == 'selesai' AND $row1['kondisi_instalasi_lal'] == 'selesai' AND $row1['kondisi_instalasi_pl'] == 'selesai' AND $row1['kondisi_instalasi_pk'] == 'selesai' AND $row1['kondisi_instalasi_tug'] == 'selesai' AND $row1['kondisi_instalasi_tdg'] == 'selesai') {
															echo '<i class="ace-icon fa fa-check bigger-110 green"></i> Selesai';
															} else {
															echo '<i class="ace-icon fa fa-close bigger-110 red"></i> Belum Selesai';
															}?></span>
													</a>
												</div>
												
											</div>
										</div>
									</div>

									<?php } ?>
								</div>

								

								
							</div><!-- /.col -->
						</div><!-- /.row -->
											<?php } else { ?>
											<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" id="validation-form4" action="" method="get">
								
									
															
																	<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Nama Proyek</label>

										<div class="col-sm-9">
											<div class="inline">
																						<?php if($row['level'] != 'Owner') { ?>
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
								<?php } else { ?>
									<select name="id" class="form-control" id="owner">
						      <option value="" selected>Nama Proyek</option>
									<?php
									
									$stmt = $user_home->runQuery("SELECT proyek.id_proyek, proyek.id_owner, proyek.nama_proyek FROM proyek, owner WHERE proyek.id_owner=owner.id_owner AND proyek.id_owner=:uid");
									$stmt->execute(array(":uid"=>$row['id_owner']));

						       while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						         echo "<option value=$row[id_proyek]>$row[nama_proyek]</option>";
						      }
									?>
								</select>
								<?php } ?>
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
										

									<div class="hr hr-24"></div>

										</div>
									</div>
								</div><!-- PAGE CONTENT ENDS -->
</div></div></div>

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
		<script src="assets/js/jquery-ui.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			
				$( "#datepicker" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: false,
					changeMonth: true,
					changeYear: true
					
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
			
			
				//override dialog's title function to allow for HTML titles
				$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
					_title: function(title) {
						var $title = this.options.title || '&nbsp;'
						if( ("title_html" in this.options) && this.options.title_html == true )
							title.html($title);
						else title.text($title);
					}
				}));
			
				$( "#id-btn-dialog1" ).on('click', function(e) {
					e.preventDefault();
			
					var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
						modal: true,
						title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='ace-icon fa fa-check'></i> jQuery UI Dialog</h4></div>",
						title_html: true,
						buttons: [ 
							{
								text: "Cancel",
								"class" : "btn btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							},
							{
								text: "OK",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
			
					/**
					dialog.data( "uiDialog" )._title = function(title) {
						title.html( this.options.title );
					};
					**/
				});
			
			
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
			
			
				
				//autocomplete
				 var availableTags = [
					"ActionScript",
					"AppleScript",
					"Asp",
					"BASIC",
					"C",
					"C++",
					"Clojure",
					"COBOL",
					"ColdFusion",
					"Erlang",
					"Fortran",
					"Groovy",
					"Haskell",
					"Java",
					"JavaScript",
					"Lisp",
					"Perl",
					"PHP",
					"Python",
					"Ruby",
					"Scala",
					"Scheme"
				];
				$( "#tags" ).autocomplete({
					source: availableTags
				});
			
				//custom autocomplete (category selection)
				$.widget( "custom.catcomplete", $.ui.autocomplete, {
					_create: function() {
						this._super();
						this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
					},
					_renderMenu: function( ul, items ) {
						var that = this,
						currentCategory = "";
						$.each( items, function( index, item ) {
							var li;
							if ( item.category != currentCategory ) {
								ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
								currentCategory = item.category;
							}
							li = that._renderItemData( ul, item );
								if ( item.category ) {
								li.attr( "aria-label", item.category + " : " + item.label );
							}
						});
					}
				});
				
				 var data = [
					{ label: "anders", category: "" },
					{ label: "andreas", category: "" },
					{ label: "antal", category: "" },
					{ label: "annhhx10", category: "Products" },
					{ label: "annk K12", category: "Products" },
					{ label: "annttop C13", category: "Products" },
					{ label: "anders andersson", category: "People" },
					{ label: "andreas andersson", category: "People" },
					{ label: "andreas johnson", category: "People" }
				];
				$( "#search" ).catcomplete({
					delay: 0,
					source: data
				});
				
				
				//tooltips
				$( "#show-option" ).tooltip({
					show: {
						effect: "slideDown",
						delay: 250
					}
				});
			
				$( "#hide-option" ).tooltip({
					hide: {
						effect: "explode",
						delay: 250
					}
				});
			
				$( "#open-event" ).tooltip({
					show: null,
					position: {
						my: "left top",
						at: "left bottom"
					},
					open: function( event, ui ) {
						ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
					}
				});
			
			
				//Menu
				$( "#menu" ).menu();
			
			
				//spinner
				var spinner = $( "#spinner" ).spinner({
					create: function( event, ui ) {
						//add custom classes and icons
						$(this)
						.next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
						.next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')
						
						//larger buttons on touch devices
						if('touchstart' in document.documentElement) 
							$(this).closest('.ui-spinner').addClass('ui-spinner-touch');
					}
				});
			
				//slider example
				$( "#slider" ).slider({
					range: true,
					min: 0,
					max: 500,
					values: [ 75, 300 ]
				});
			
			
			
				//jquery accordion
				$( "#accordion" ).accordion({
					collapsible: true ,
					heightStyle: "content",
					animate: 250,
					header: ".accordion-header"
				}).sortable({
					axis: "y",
					handle: ".accordion-header",
					stop: function( event, ui ) {
						// IE doesn't register the blur when sorting
						// so trigger focusout handlers to remove .ui-state-focus
						ui.item.children( ".accordion-header" ).triggerHandler( "focusout" );
					}
				});
				//jquery tabs
				$( "#tabs" ).tabs();
				
				
				//progressbar
				$( "#progressbar" ).progressbar({
					value: <?php echo $e ?>,
					create: function( event, ui ) {
						$(this).addClass('progress progress-striped active')
							   .children(0).addClass('progress-bar progress-bar-success');
					}
				});
			
				
				//selectmenu
				 $( "#number" ).css('width', '200px')
				.selectmenu({ position: { my : "left bottom", at: "left top" } })
					
			});
		</script>
	</body>
</html>