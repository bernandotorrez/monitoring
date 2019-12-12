<?php
require_once 'config/dbconfig.php';

date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
function aman($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function tanggal($date){
	$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
	$jam = substr($date,11, 5);
		
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}

function deadline($CheckIn,$CheckOut){
$CheckInX = explode("-", $CheckIn);
$CheckOutX =  explode("-", $CheckOut);
$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
$interval =($date2 - $date1)/(3600*24);
// returns numberofdays
return  $interval ;
}
?>