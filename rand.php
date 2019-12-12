<?php
function ryRandom($muncul){

if($muncul == '4'){
 $ryRandom = rand(1111,9999); //*Acak angka 1111 - 9999 menampilkan 4 angka
 }elseif($muncul == '3'){
 $ryRandom = rand(111,999); //*Acak angka 111 - 999 menampilkan 3 angka<br />
 }elseif($muncul == '2'){
 $ryRandom = rand(11,99); //* menampilkan 2 angka
 }elseif($muncul == '6'){
 $ryRandom = rand(100000,119999); //* menampilkan 2 angka
 }elseif($muncul == '5'){
 $ryRandom = rand(50000,99999); //* menampilkan 2 angka
 }else{
    $ryRandom = "Random belum di setting";
}
 return $ryRandom;
}

//*Untuk memunculkan kode randomnya kita harus panggil function-nya sebagai berikut
echo 'Random 6 angka : ' .ryRandom(6). '<br>';
echo 'Random 5 angka : ' .ryRandom(5). '<br>';
echo 'Random 4 angka : ' .ryRandom(4). '<br>';
echo 'Random 3 angka : ' .ryRandom(3). '<br>';
echo 'Random 2 angka : ' .ryRandom(2). '<br>';
?>