<?php
include 'config/koneksi.php';



$nama_admin="Reminder Sistem";
$email_admin="mailer@project-monitoring.online";
$headers .= 'To: "Bernando Torrez"<"bernandotorrez4@gmail.com">'. "\r\n";
$headers .= 'From: '.$email_admin.''. "\r\n";
$pesan .= "Kepada YTH Bernando Torrez\n\n";
$pesan .="Reminder Sistem\n";
$pesan .="$nama_admin\n\n";
$pesan .="$email_admin";


	
$send = mail("bernandotorrez4@gmail.com","Reminder Sistem", $pesan, $headers);
	
?>

