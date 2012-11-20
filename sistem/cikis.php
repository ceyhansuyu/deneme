<?php
session_start();
require_once("ayar.php");
   


          
    $SQL2 = mysql_query("UPDATE kullanicilar set 
		              kul_son_cikis          ='".time()."',
		              kul_son_sayfa         ='sistem/cikis.php',
		              kul_son_sayfa_baslik  ='Çýkýþ Yapýldý',
					  kul_son_aktivite       = kul_son_aktivite - '".$ayar["cevrimici_zaman_asimi"]."'
					  WHERE kul_id='".$_SESSION['kul_id']."' ");
    
    unset($_SESSION['kul']);  
    unset($_SESSION['kul_id']);
    unset($_SESSION['kul_yetki']);
	unset($_SESSION['kul_email']); 
	unset($_SESSION['kul_son_giris']);
	unset($_SESSION['kul_yetki']);  
	unset($_SESSION['misafir_ilk_giris']);
	unset($SQL);  
	
	session_destroy(); // Tüm oturumlarý yoket	
	
	$_SESSION['kul'] = "misafir";	
	$_SESSION['kul_id'] = "00";
	if(empty($_SESSION['kul_son_giris']))
    $_SESSION['kul_son_giris'] = time();	
	
	setcookie($ayar["cookie_on_ek"].'hatirla', ""   ,time() - $ayar["cookie_zamani"] , $ayar["script_yolu"] );
	setcookie($ayar["cookie_on_ek"].'kullanici', "" ,time() - $ayar["cookie_zamani"] , $ayar["script_yolu"] );
	setcookie($ayar["cookie_on_ek"].'okundu', ""      ,time() - $ayar["cookie_zamani"] , $ayar["script_yolu"] );


	
	header("location:../bilgiver.php?bilgi=cikis_basarili");


?>