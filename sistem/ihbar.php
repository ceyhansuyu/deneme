<?php
require_once("ayar.php");
require_once("functions.php");
require_once("../language/tr.php");
session_start();
// Ýstenmeyen durumlara karþýn.
if ($_SESSION['kul_id'] =="00" or $_SESSION['kul'] =="misafir")
{
		header("location:../bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}
// Ýstenmeyen durumlara karþýn. Son

	/// Anket varsa
    $ihbar_baslik        = temizle($_POST['ihbar_baslik']);
    $hangi_konu          = temizle($_POST['hangi_konu']);
    $mesaj_id         	 = temizle($_POST['mesaj_id']);
    $ihbar_sebep         = temizle($_POST['ihbar_sebep']);
	$yazar		         = temizle($_SESSION['kul']);
	$yazar_id 		     = temizle($_SESSION['kul_id']);
    $ip 			     = $_SERVER["REMOTE_ADDR"]; 
	$anket_time          =  time();

								
	 // kaç sayfa mesaj var bir bakalým.
	 $tablosayfala ="mesajlar";
	 $WHERE_mesajforumid = $hangi_konu;
	 $limitsayfala = $ayar["sayfala_limit_cevap"];
	 // sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala)
	 
	 $sayfa = sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala);
	 
	
		 $SQL = mysql_query("insert into ihbar set
									 bildirenID        ='$yazar_id',
									 bildiren          ='$yazar',
									 bildiriBaslik     ='$ihbar_baslik',
									 bildiri           ='$ihbar_sebep',
									 bildirenIP        ='$ip',
						             bildirilenAdres   ='showthread.php?t=$hangi_konu&sayfa=$sayfa#mesaj$mesaj_id'
								");

		
	
	 
	   if ($SQL) 
        header("location:../showthread.php?t=".$hangi_konu."&sayfa=".$sayfa."#mesaj".$mesaj_id."");
	   else
	    echo "hata var";
           

?>