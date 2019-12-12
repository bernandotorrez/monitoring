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
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if($row['level'] != 'Admin') {
$user_home->redirect('index.php');
}


$stmt = $user_home->runQuery("SELECT * FROM modul WHERE id_modul=:uid LIMIT 1");
$stmt->execute(array(":uid"=>"1"));
$konten = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['btn-simpan']))
{
	$konten = $_POST['konten'];
  $email = trim($_POST['email']);
  $id = "1";
		if($user_home->home_edit($konten,$email,$id))
		{
			$stmt = $user_home->runQuery("SELECT * FROM modul WHERE id_modul=:uid");
$stmt->execute(array(":uid"=>"1"));
$konten = $stmt->fetch(PDO::FETCH_ASSOC);
$msg = "<center>
			<div class='alert alert-success'>

	<strong>Selamat!</strong> Konten telah diperbaharui.
</div></center>";
		}
		else
		{
			$msg = "<center>
						<div class='alert alert-danger'>

				<strong>Maaf!</strong> Konten gagal diperbaharui.
			</div></center>";

		}
	}

?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Profil Perusahaan - PT. Malmass Mitra Teknik</title>

		<meta name="description" content="" />
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

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
    <link href="dist/summernote.css" rel="stylesheet">
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
							<h1>Profile Perusahaan</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">

									<div class="col-sm-12">
										<h4 class="header green">Isi Profile Perusahaan Di Bawah Ini.</h4>
	<?php if(isset($msg)) { echo $msg; } ?>

  <form action="" method="post" enctype="multipart/form-data">


        <label class="col-sm-2 control-label no-padding-right" for="form-field-email">Email Perusahaan</label>

          <input class="" type="email" id="form-field-username" placeholder="Email" name="email" value="<?php echo $konten['email_perusahaan'];?>" required/>
        </br></br>
          <div class="summernote container">

</div>
<div class="row">

<fieldset>

<textarea class="input-block-level" id="summernote" name="konten" required><?php echo $konten['konten'];?>
</textarea>

</fieldset>
<button type="submit" name="btn-simpan" class="btn btn-primary">Save changes</button>
<button type="reset" id="cancel" class="btn">Cancel</button>
</form>
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
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/markdown.min.js"></script>
		<script src="assets/js/bootstrap-markdown.min.js"></script>
		<script src="assets/js/jquery.hotkeys.index.min.js"></script>

		<script src="assets/js/bootbox.js"></script>
    <script src="dist/summernote.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  var postForm = function() {
  	var content = $('textarea[name="konten"]').html($('#summernote').code());
  }
  </script>
		<!-- inline scripts related to this page -->
	</body>
</html>
