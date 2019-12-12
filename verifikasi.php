<!DOCTYPE html>
<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['passkey']))
{
	$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['passkey']))
{
	$id = base64_decode($_GET['id']);
	$passkey = $_GET['passkey'];

	$statusY = "sudah";
	$statusN = "belum";

	$stmt = $user->runQuery("SELECT email, status_member FROM login WHERE email=:uID AND passkey=:passkey LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":passkey"=>$passkey));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0)
	{
		if($row['status_member']==$statusN)
		{
			$stmt = $user->runQuery("UPDATE login SET status_member=:status WHERE email=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();

			$msg = " <center><div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>Verifikasi Berhasil, Anda akan segera diarahkan ke Halaman Login
			       </div><center>

		       ";
		       header("refresh:5;login.php");
		}
		else
		{
			$msg = "<center> <div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>Maaf !</strong> Akun Anda Sudah Di Verifikasi, Anda akan segera diarahkan ke Halaman Login
			       </div>


			       ";
			       header("refresh:5;login.php");
		}
	}
	else
	{
		$msg = "<center> <div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong>Maaf !</strong>  Permintaan Tidak Di Temukan.
			   </div>

			   ";
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Confirm Registration</title>
    <!-- Bootstrap -->
    <link href="assets/other/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="assets/other/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/other/styles.css" rel="stylesheet" media="screen">
    	<link rel="stylesheet" href="assets/css/mouse.css" />
		<?php
		include 'favicon.php';
		?>
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
    <div class="col-xs-12">
			<div id="verifikasi">
		<?php if(isset($msg)) { echo $msg; } ?>
		</div>
    </div> <!-- /container -->
	</div>
    <script src="assets/other/bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="assets/other/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
