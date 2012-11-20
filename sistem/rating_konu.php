<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");
## /// Sayfa açýlma süresi ## ===>>>> $saymaya_basla = acilma_suresi();
$konu_id = t_id_temizle($_GET["id"]);

session_start();
// Ýstenmeyen durumlara karþýn. hack vb.
if ($_SESSION['kul'] =="misafir")
{
		header("location:../bilgiver.php?bilgi=konuyu_oylayamazsiniz");
		exit();
}


$deger = temizle($_POST["konuyu_degerlendir"]);
$kul_id = temizle($_SESSION['kul_id']);
$ip 	= temizle($_SERVER["REMOTE_ADDR"]); 
$time = time();

    $SQL = mysql_query("SELECT * FROM rating_konu 
					  WHERE rating_kul_id ='".$kul_id."' 
					  and rating_konu_id ='".$konu_id."' ");
	
    $say = mysql_num_rows($SQL);
	if($say > 0)
	{
	  	header("location:../bilgiver.php?bilgi=daha_onceden_oy_kullandiniz");
		exit();
	}
	else if($say == 0 )
	{
	  unset($SQL);
	   $SQL = mysql_query("insert into rating_konu set 
	   rating_konu_id ='$konu_id',
	   rating_kul_id  ='$kul_id',
	   rating_degeri  ='$deger',
	   rating_kul_ip  ='$ip',
	   rating_zamani  ='$time'
	   ");	
	   
	  if($SQL == true)  header("location: ".$_SERVER['HTTP_REFERER']."");  
	}
	



?>