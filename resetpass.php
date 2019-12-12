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

	$stmt = $user->runQuery("SELECT * FROM login WHERE email=:uid AND passkey=:passkey");
	$stmt->execute(array(":uid"=>$id,":passkey"=>$passkey));
	$a = $stmt->fetch(PDO::FETCH_ASSOC);

	if($a['level'] != "Owner") {
		$stmt = $user->runQuery("SELECT * FROM login, pegawai WHERE login.email=:uid AND pegawai.email=:uid AND login.passkey=:passkey");
	$stmt->execute(array(":uid"=>$id,":passkey"=>$passkey));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	} else {
		$stmt = $user->runQuery("SELECT * FROM login, owner WHERE owner.email=:uid AND owner.email=:uid AND login.passkey=:passkey");
	$stmt->execute(array(":uid"=>$id,":passkey"=>$passkey));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	if($stmt->rowCount() == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
			$pass = $_POST['pass'];
			$cpass = $_POST['confirm-pass'];

			if($cpass!==$pass)
			{
				$msg = "<div class='alert alert-warning'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Maaf!</strong>  Password Tidak Cocok.
						</div>";
			}
			else
			{
				$password = md5($cpass);
				$stmt = $user->runQuery("UPDATE login SET password=:upass WHERE email=:uid");
				$stmt->execute(array(":upass"=>$password,":uid"=>$rows['email']));

				$msg = "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						Password Telah Di Ubah.
						</div>";
				header("refresh:2;login.php");
			}
		}
	}
	else
	{
		$msg = "<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				Permintaan Tidak Dapat Di Lakukan.
				</div>";

	}


}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Atur Ulang Password</title>
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
  </head>
  <body id="login">
    <div class="container">
    	<div class='alert alert-success'>
			<center><strong>Hai !</strong>  
			<?php
			if($rows['level'] != "Owner") {
				echo $rows['nama_pegawai']; 
			} else {
				echo $rows['nama_owner']; 
			}
			?> 
			Silahkan buat Password anda yang baru.</center>
		</div>
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Atur Ulang Password.</h3><hr />
        <?php
        if(isset($msg))
		{
			echo $msg;
		}
		?>
        <input type="password" class="input-block-level" placeholder="Password Baru" name="pass" required autofocus="" />
        <input type="password" class="input-block-level" placeholder="Konfirmasi Password Baru" name="confirm-pass" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Ganti Password</button>

      </form>

    </div> <!-- /container -->
    <script src="assets/other/bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="assets/other/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
