<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");
## /// Sayfa açýlma süresi ## ===>>>> $saymaya_basla = acilma_suresi();

session_start();
// Misafirse misafir çerezi yap ve güncelle
if ($_SESSION['kul'] =="misafir")
{
   //setcookie('misafir','misafir_'.time() , time() + 5184000 , $ayar["script_yolu"]);  

		header("location:../bilgiver.php?bilgi=forumlari_okunmus_sayamazsiniz");
		exit();
}

$su_an = time();
$kul_id = $_SESSION['kul_id'];

unset($_SESSION['kul_son_aktivite']);
unset($SQL);

$_SESSION['kul_son_aktivite'] = $su_an ;

$SQL = mysql_query("UPDATE kullanicilar set 
				   kul_son_cikis  = '$su_an' 
				   WHERE kul_id   =".$kul_id."");
	

// okundu cookisini sil
	setcookie($ayar["cookie_on_ek"].'okundu', ""      ,time() - $ayar["cookie_zamani"] , $ayar["script_yolu"] );

				   
	if($SQL == true)
	header("location:../bilgiver.php?bilgi=tum_forumlar_okundu");

?>