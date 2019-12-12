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
$row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	$stmt = $user_home->runQuery("SELECT * FROM login, owner WHERE login.email=:uid and owner.email=:uid LIMIT 1");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
}

 

if($row['level'] != 'Engineer' AND $row['level'] != 'Draugman' AND $row['level'] != 'Direktur') {
$user_home->redirect('index.php');
}

if(isset($_POST['btn-edit']))
{

	$euname = aman($_POST['euname']);
	$id = $_SESSION['userSession'];
$level = aman($_POST['level']);


	if($user_home->edit($euname, $id))
	{
	header("Location: daftarproyek.php?id=".$_SESSION['userSession']."&aksi=hapussukses");

		}
		else
		{
			header("Location: daftarproyek.php?id=".$_SESSION['userSession']."&aksi=hapusgagal");
		}
}


if(isset($_GET['proyek']) == 'delete')
{

	$idproyek = $_GET['idproyek'];

	if($user_home->hapus_proyek($idproyek))
	{
	header("Location: daftarproyek.php?aksi=hapussukses#table");

		}
		else
		{
			header("Location: daftarproyek.php?aksi=hapusgagal#table");
		}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Data Proyek - Sistem Monitoring Proyek PT. Malmass Mitra Teknik</title>

		<meta name="description" content="Static &amp; Dynamic Tables" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
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


		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">

			<?php
		include 'menu.php';
		?>


						<div class="page-header">
							<h1>
								Monitoring
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Data Proyek
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->



								<div class="row" id="table">
									<div class="col-xs-12">
										
										<?php
		if($_GET['aksi']=='hapussukses')
		{
			?><center>
            <div class='alert alert-success'>

				<strong>Hore!</strong> Hapus Proyek Berhasil.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='hapusgagal')
		{
			?><center>
            <div class='alert alert-info'>

				<strong>Sorry!</strong> Hapus Proyek Gagal.
			</div></center>
            <?php
		}
		?>
										
<?php
														if($_GET['id'] != '') {
														$id = aman($_GET['id']);

														$stmt = $user_home->runQuery("SELECT * FROM detailproyek_electrical INNER JOIN detailproyek_mechanical ON detailproyek_electrical.id_detailproyek=detailproyek_mechanical.id_detailproyek WHERE detailproyek_electrical.id_proyek=:uid");
$stmt->execute(array(":uid"=>$id));
?>
<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Detail Proyek
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
											<form action="" method="post">
												<thead>
													<tr>
													<th>ID Proyek</th>
														<th>Nama Proyek</th>
														<th class="hidden-480">Nama Owner</th>
														<th class="hidden-480">Pegawai Electrical</th>
														<th class="hidden-480">Pegawai Mechanical</th>
														<th style="word-wrap: break-word;min-width: 60px;max-width: 60px;">Total <br>Pengerjaan</th>
													
														<th>Aksi</th>
													</tr>
												</thead>

												<tbody>
													<tr>
<?php


     			 										while($row1 = $stmt->fetch()){
$listrik = $row1['instalasi_lak'];
$lampu = $row1['instalasi_lal'];
$telepon = $row1['instalasi_pl'];
$stop = $row1['instalasi_pk'];
$alarm = $row1['instalasi_tug'];
$sound = $row1['instalasi_tdg'];

$e = $listrik+$stop+$lampu+$telepon+$alarm+$sound;
																?>
																<td style="word-wrap: break-word;min-width: 100px;max-width: 120px;"><a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" target="_blank"><?php echo $row1['id_detailproyek'];?></a></td>
																<td style="word-wrap: break-word;min-width: 100px;max-width: 120px;"><?php echo $row1['nama_proyeklantai'];?></td>
														<td class="hidden-480"><?php echo $row1['nama_owner'];?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php echo $row1['nama_pegawai_electrical'];?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php echo $row1['nama_pegawai_mechanical'];?></td>
														<td ><?php echo $e."%";?></td>
														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<a class="blue" target="_blank" title="Lihat" data-rel="tooltip" href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a>

															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a href="proyek.php?id=<?php echo $row1['id_detailproyek'];?>" class="tooltip-info" data-rel="tooltip" target="_blank" title="Lihat">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-120"></i>
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
																<?php
														} else {
														?>
															<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Daftar Proyek
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
											<form action="" method="post"> 
												<thead>
													<tr>
													<th>ID Proyek</th>
														<th>Nama Proyek</th>
														<th class="hidden-480">Jenis Bangunan</th>
														<th class="hidden-480">Lokasi</th>
														<th class="hidden-480">Total Lantai</th>
														<th class="hidden-480">Total <br>Basement</th>
														<th class="hidden-480">Total <br>Ground</th>
														<th class="hidden-480">Arsitek</th>
														<th class="hidden-480">Tahun</th>
														<th class="hidden-480">Tanggal Mulai</th>
														<th class="hidden-480">Tanggal Selesai</th>
														<th class="hidden-480">Total <br>Pengerjaan</th>
														<th>Deadline</th>
														<th>Aksi</th>
													</tr>
												</thead>

												<tbody>
													<tr>

														<?php

														$stmt = $user_home->runQuery("SELECT * FROM proyek");
														$stmt->execute();

     			 										while($row1 = $stmt->fetch()){
     			 											$listrik = $row1['instalasi_lak'];
$lampu = $row1['instalasi_lal'];
$telepon = $row1['instalasi_pl'];
$stop = $row1['instalasi_pk'];
$alarm = $row1['instalasi_tug'];
$sound = $row1['instalasi_tdg'];

$e = $listrik+$stop+$lampu+$telepon+$alarm+$sound;
																?>
																<td ><a href="daftarproyek.php?id=<?php echo $row1['id_proyek'];?>" target="_blank"><?php echo $row1['id_proyek'];?></a></td>
																<td style="word-wrap: break-word;min-width: 80px;max-width: 100px;"><?php echo $row1['nama_proyek'];?></td>
														<td class="hidden-480"><?php echo $row1['jenis_bangunan'];?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php echo $row1['lokasi'];?></td>
														<td class="hidden-480"><?php echo $row1['total_lantai'];?></td>
														<td class="hidden-480"><?php echo $row1['total_basement'];?></td>
														<td class="hidden-480"><?php echo $row1['total_ground'];?></td>
														<td class="hidden-480" style="word-wrap: break-word;min-width: 120px;max-width: 120px;"><?php echo $row1['arsitek'];?></td>
														<td class="hidden-480"><?php echo $row1['tahun'];?></td>
														<td class="hidden-480"><?php echo tanggal($row1['tgl_mulai']);?></td>
														<td class="hidden-480"><?php echo tanggal($row1['tgl_selesai']);?></td>
														<td class="hidden-480"><?php echo $row1['total_pengerjaan'];?>%</td>
														<td><?php if(deadline(date("Y-m-d"), $row1['tgl_selesai']) >= 31) {
														echo "<span class='label label-sm label-info'>".deadline(date("Y-m-d"), $row1['tgl_selesai'])."  Hari</span>";
													} elseif(deadline(date("Y-m-d"), $row1['tgl_selesai']) >= 15) {
														echo "<span class='label label-sm label-success'>".deadline(date("Y-m-d"), $row1['tgl_selesai'])."  Hari</span>";
														} elseif(deadline(date("Y-m-d"), $row1['tgl_selesai']) >= 7) {
														echo "<span class='label label-sm label-warning'>".deadline(date("Y-m-d"), $row1['tgl_selesai'])."  Hari</span>";
													
													} elseif(deadline(date("Y-m-d"), $row1['tgl_selesai']) >= 1) {

													echo "<span class='label label-sm label-danger'>".deadline(date("Y-m-d"), $row1['tgl_selesai'])."  Hari</span>";
													} else {

													echo "<span class='label label-sm label-danger'>Berakhir</span>";
												}
														?> </td>
														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<a class="blue" target="_blank" title="Lihat" data-rel="tooltip" href="daftarproyek.php?id=<?php echo $row1['id_proyek'];?>">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a>


																<?php if($row['level'] != 'Direktur' AND $row['level'] != 'Admin') {
																	?>
																<a class="red" name="btn-hapus" href="#" title="Hapus" data-rel="tooltip">
																	<i class="ace-icon fa fa-trash-o bigger-130"></i>
																</a>
																<?php } else {?>
																<a class="red" name="btn-hapus" title="Hapus" data-rel="tooltip" href="daftarproyek.php?proyek=delete&idproyek=<?php echo $row1['id_proyek'];?>">
																	<i class="ace-icon fa fa-trash-o bigger-130" onclick="return confirm('Hapus Proyek Ini?')"></i>
																</a>
																<?php } ?>
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a href="daftarproyek.php?id=<?php echo $row1['id_proyek'];?>" class="tooltip-info" data-rel="tooltip" target="_blank" title="View">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-120"></i>
																				</span>
																			</a>
																		</li>


																		<li>
																					<?php if($row['level'] != 'Direktur' AND $row['level'] != 'Admin') {
																	?>
															
																<a href="#" class="tooltip-error" data-rel="tooltip" title="Hapus">
																				<span class="red">
																					<i class="ace-icon fa fa-trash-o bigger-120"></i>
																				</span>
																			</a>
																<?php } else {?>
																<a href="daftarproyek.php?proyek=delete&idproyek=<?php echo $row1['id_proyek'];?>" class="tooltip-error" data-rel="tooltip" title="Hapus" onclick="return confirm('Hapus Proyek Ini?')">
																				<span class="red">
																					<i class="ace-icon fa fa-trash-o bigger-120"></i>
																				</span>
																			</a>
																
																<?php } ?>
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
										</div>
									</div>
								</div>

																<?php
															}



																?>


									
										



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
		
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		
		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				<?php
		if($_GET['id'] == '') { ?>
				var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: true,
					"aoColumns": [
					  { "bSortable": true },
					  null, null,null, null, null, null, null, null, null, null, null, null, 
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

<?php
		} else { ?>
var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: true,
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
<?php } ?>
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
	</body>
</html>