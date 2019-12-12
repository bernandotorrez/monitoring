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

 

if($row['level'] != 'Admin') {
$user_home->redirect('index.php');
}

if(isset($_POST['btn-submit']))
{

	$status = aman($_POST['status']);
	$email = $_GET['email'];
	
	if($user_home->edit_akun($status,$email))
	{
	header("Location: daftarakun.php?aksi=editsukses#table");
exit;
		}
		else
		{
			header("Location: daftarakun.php?aksi=editgagal#table");
			exit;
		}
}

if(isset($_POST['btn-cancel']))
{

	$user_home->redirect('daftarakun.php');
}

if(isset($_GET['akun']) == 'delete')
{

	$email = $_GET['email'];

	if($user_home->hapus_akun($email))
	{
	header("Location: daftarakun.php?aksi=hapussukses#table");
exit;
		}
		else
		{
			header("Location: daftarakun.php?aksi=hapusgagal#table");
			exit;
		}
}
?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Data Akun - Sistem Monitoring Proyek PT. Malmass Mitra Teknik</title>

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
		include 'menu.php';
		?>


						<div class="page-header">
							<h1>
								Akun
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Data Akun
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

				<strong>Hore!</strong> Hapus Akun Berhasil.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='hapusgagal')
		{
			?><center>
            <div class='alert alert-info'>

				<strong>Sorry!</strong> Hapus Akun Gagal.
			</div></center>
            <?php
		}
		?>
						<?php
		if($_GET['aksi']=='editsukses')
		{
			?><center>
            <div class='alert alert-success'>

				<strong>Hore!</strong> Ubah Data Akun Berhasil.
			</div></center>
            <?php
		}
		?>
		<?php
		if($_GET['aksi']=='editgagal')
		{
			?><center>
            <div class='alert alert-info'>

				<strong>Sorry!</strong> Ubah Data Akun Gagal.
			</div></center>
            <?php
		}
		?>
										<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Daftar Akun
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
											<form action="" method="post">
												<thead>
													<tr>

														<th >Email</th>
														<th >Status <br>Member</th>

														<th >level</th>

														<th>Aksi</th>
													</tr>
												</thead>

												<tbody>
													<tr>

														<?php

														$stmt = $user_home->runQuery("SELECT * FROM login WHERE NOT email=:email");
														$stmt->execute(array(":email"=>$_SESSION['userSession']));

     			 										while($row1 = $stmt->fetch()){
																?>
																<td style="word-wrap: break-word;min-width: 100px;max-width: 100px;"><?php echo $row1['email'];?></td>
																<td>

															<?php echo $row1['status_member'];?>
														</td>



														<td>
															<?php if ($row1['level'] == 'Admin'){ ?>
                              <span class="label label-sm label-danger">
                            
                                <?php } elseif($row1['level'] == 'Engineer') { ?>
                                  <span class="label label-sm label-success">
                                    <?php } elseif($row1['level'] == 'Draugman') { ?>
                                      <span class="label label-sm label-primary">
                                       <?php } elseif($row1['level'] == 'Direktur') { ?>
                                      <span class="label label-sm label-danger">
                                        <?php } else {?>
                                          <span class="label label-sm label-warning">
                                            <?php } ?>
                                  <?php echo $row1['level'];?></span>
														</td>

														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<?php 
																		if($row1['level'] != 'Owner') {																																					
																		?>
																			<a href="pegawai.php?id=<?php echo $row1['email'];?>" class="tooltip-info" data-rel="tooltip" title="Lihat" target="_blank">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-130"></i>
																				</span>
																			</a>
																			<?php } else { ?>
																			<a href="owner.php?id=<?php echo $row1['email'];?>" class="tooltip-info" data-rel="tooltip" title="Lihat" target="_blank">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-130"></i>
																				</span>
																			</a>
																			<?php } ?>

																				<?php if($row1['level'] == 'Admin') {
																	?>
																<a class="green" name="btn-hapus" href="#" title="Ubah" data-rel="tooltip">
																	<i class="ace-icon fa fa-pencil-square-o bigger-130"></i>
																</a>
																<?php } else {?>
																<a class="green" name="btn-hapus" title="Ubah" data-rel="tooltip" href="daftarakun.php?email=<?php echo $row1['email'];?>">
																	<i class="ace-icon fa fa-pencil-square-o bigger-130" onclick="return confirm('Ubah Data Akun Ini?')"></i>
																</a>
																<?php } ?>
																<?php if($row1['level'] == 'Admin') {
																	?>
																<a class="red" name="btn-hapus" href="#" title="Hapus" data-rel="tooltip">
																	<i class="ace-icon fa fa-trash-o bigger-130"></i>
																</a>
																<?php } else {?>
																<a class="red" name="btn-hapus" title="Hapus" data-rel="tooltip" href="daftarakun.php?akun=delete&email=<?php echo $row1['email'];?>">
																	<i class="ace-icon fa fa-trash-o bigger-130" onclick="return confirm('Hapus Akun Ini?')"></i>
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
																		<?php 
																		if($row1['level'] != 'Owner') {																																					
																		?>
																			<a href="pegawai.php?id=<?php echo $row1['email'];?>" class="tooltip-info" data-rel="tooltip" title="Lihat" target="_blank">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-120"></i>
																				</span>
																			</a>
																			<?php } else { ?>
																			<a href="owner.php?id=<?php echo $row1['email'];?>" class="tooltip-info" data-rel="tooltip" title="Lihat" target="_blank">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-120"></i>
																				</span>
																			</a>
																			<?php } ?>
																		</li>

																		<li>
																			<?php if($row1['level'] != 'Admin') {
																	?>
															
																<a href="#" class="tooltip-error" data-rel="tooltip" title="Ubah">
																				<span class="green">
																					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																				</span>
																			</a>
																<?php } else {?>
																<a href="daftarakun.php?email=<?php echo $row1['email'];?>" class="tooltip-error" data-rel="tooltip" title="Ubah">
																				<span class="green">
																					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																				</span>
																			</a>
																
																<?php } ?>
																			
																		</li>

																		<li>
																			<?php if($row1['level'] != 'Admin') {
																	?>
															
																<a href="#" class="tooltip-error" data-rel="tooltip" title="Hapus">
																				<span class="red">
																					<i class="ace-icon fa fa-trash-o bigger-120"></i>
																				</span>
																			</a>
																<?php } else {?>
																<a href="daftarakun.php?akun=delete&email=<?php echo $row1['email'];?>" class="tooltip-error" data-rel="tooltip" title="Hapus">
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
											<?php if($_GET['email'] != '') {
							$email = aman($_GET['email']);
							$stmt = $user_home->runQuery("SELECT * FROM login WHERE email=:uid");
$stmt->execute(array(":uid"=>$email));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
						</br>
						<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" action="" method="post">
								
									<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Email</label>

																<div class="col-xs-12 col-sm-9">
																	<div class="clearfix">
																		<input type="text" name="email" id="id" class="col-xs-12 col-sm-6" value="<?php echo $row['email'];?>" disabled/>
																		<input type="hidden" name="email" id="id" class="col-xs-12 col-sm-6" value="<?php echo $row['email'];?>"/>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Status Member</label>

																<div class="col-xs-12 col-sm-9">
																	<label class="inline">

																		<input type="radio" name="status" id="status" class="ace" value="sudah" <?php if($row['status_member']=="sudah") echo "checked";?>/>
																		<span class="lbl middle"> Sudah</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																	<input type="radio" name="status" id="status" class="ace" value="belum" <?php if($row['status_member']=="belum") echo "checked";?>/>
																		<span class="lbl middle"> Belum</span>
																	</label>
																</div>
															</div>
														

<div class="col-sm-6 control-label no-padding-right">
	<button id="loading-btn" type="submit" class="btn btn-primary" data-last="Finish" data-loading-text="Menyimpan..." name="btn-submit">
													<i class="ace-icon fa fa-floppy-o"></i>
													<span class="bigger-110">Submit</span>
												</button>
												<button id="loading-btn1" type="submit" class="btn btn-warning" data-loading-text="Mereset..." name="btn-cancel">
																								<i class="ace-icon fa fa-close"></i>
																								<span class="bigger-110">Cancel</span>
																							</button>
																						</div>
																							</form>

											</div>
						<?php } ?>
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
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: true,
					"aoColumns": [
					  { "bSortable": true },
					  null, null,
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
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
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
