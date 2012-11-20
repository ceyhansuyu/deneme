<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");
## /// Sayfa açýlma süresi ## ===>>>> $saymaya_basla = acilma_suresi();

session_start();
// Ýstenmeyen durumlara karþýn. hack vb.
if ($_SESSION['kul'] =="misafir")
{
		header("location:../bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}
// Ýstenmeyen durumlara karþýn. Son

$forum_id     	= temizle($_POST['forum_id']);
$forum_ikon     = temizle($_POST['forum_ikon']);
$konu_id     	= temizle($_POST['hangi_konu']);
$cevap 			= temizle($_POST['editor']);
$cevap_baslik	= temizle($_POST['cevap_baslik']);
$mesaj_tarihi	= time();
$yazar 			= temizle($_SESSION['kul']);
$yazar_id 		= temizle($_SESSION['kul_id']);
$ip 			= $_SERVER["REMOTE_ADDR"];  
//$konu_ikonu ="yok"; //temizle($_POST['konu_ikonu']);
//$konu_son_mesaj_zamani = time();

		if(empty($cevap_baslik) || empty($cevap) )
        {		
		header("location:../bilgiver.php?bilgi=cvp_ekleme_basarisiz"); 
		exit();
        }		
 
    $SQL = mysql_query("insert into mesajlar set 
	   mesaj_forum_id   ='$forum_id',
	   mesaj_konu_id ='$konu_id',
	   mesaj_zamani  ='$mesaj_tarihi',
	   mesaj_author  = '$yazar',
	   mesaj_author_id  ='$yazar_id',
	   mesaj_author_ip ='$ip',
	   mesaj_baslik  ='$cevap_baslik',	   
	   mesaj_govde  ='$cevap',
	   mesaj_ikonu  ='$forum_ikon'
	   ");	
   
     $usttekiid = mysql_insert_id();
	 // forum idyi bulalým
	 $SQL2 = mysql_query("SELECT * FROM konular WHERE konu_id =".$konu_id."");
	 $sor = mysql_fetch_array($SQL2);
	 
	  
	 // forumdaki cevap sayýsýný 1 artýr
	 $SQL3 = mysql_query("UPDATE forumlar  set 
       forum_toplam_mesaj     = forum_toplam_mesaj  + 1 ,
	   forum_son_mesaj_title  = '$cevap_baslik',
	   forum_son_mesaj_id     = '$usttekiid',
	   forum_son_mesaj_konu_id   = '$konu_id',
	   forum_son_mesaj_kul    = '$yazar',
	   forum_son_mesaj_kul_id = '$yazar_id',
	   forum_son_mesaj_zamani = '$mesaj_tarihi',
	   forum_son_mesaj_ikonu = '$forum_ikon'
	   WHERE forum_id =".$sor['konu_forum_id']."");	
	   
	 // konudaki mesaj sayýsýný 1 artýr.
	 $SQL4 = mysql_query("UPDATE konular  set 
       konu_cevap_sayisi  = konu_cevap_sayisi + 1 ,
	   son_mesaj_id       = '$usttekiid' ,
	   son_mesaj_zamani   = '$mesaj_tarihi',
	   son_mesaj_yazar    = '$yazar',
	   son_mesaj_yazar_id = '$yazar_id'
	   WHERE konu_id =".$konu_id."");
	   
	   
	  // Üst forumu var mý bakalým	
      $f_id =	$sor["konu_forum_id"]; 
	  $SQL5 = mysql_query("SELECT * FROM forumlar WHERE forum_id =".$f_id."");
	  $sor2 = mysql_fetch_array($SQL5);	
	  // Eðer üst forumu varsa
	  if(!empty($sor2["forum_ust_f"]))
        {
		 // forumdaki cevap sayýsýný 1 artýr
		 $SQL5 = mysql_query("UPDATE forumlar  set 
			   forum_toplam_mesaj       = forum_toplam_mesaj  + 1 ,
			   forum_son_mesaj_title    = '".$sor2["forum_son_mesaj_title"]."',
			   forum_son_mesaj_id       = '".$sor2["forum_son_mesaj_id"]."',
			   forum_son_mesaj_konu_id  = '".$sor2["forum_son_mesaj_konu_id"]."',
			   forum_son_mesaj_kul      = '".$sor2["forum_son_mesaj_kul"]."',
			   forum_son_mesaj_kul_id   = '".$sor2["forum_son_mesaj_kul_id"]."',
			   forum_son_mesaj_zamani   = '".$sor2["forum_son_mesaj_zamani"]."',
			   forum_son_mesaj_ikonu    = '".$sor2["forum_son_mesaj_ikonu"]."'
			   WHERE forum_id =".$sor2["forum_ust_f"]."");	
		
		}
		else 
		{
		  echo "Olmadý be";
		}	
	     

	   
	 // kaç sayfa mesaj var bir bakalým.
	 $tablosayfala ="mesajlar";
	 $WHERE_mesajforumid = $konu_id;
	 $limitsayfala = $ayar["sayfala_limit_cevap"];
	 // sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala)
	 


	   if ($SQL and $SQL2 and $SQL3 and $SQL4) 
       header("location:../showthread.php?t=".$konu_id."&sayfa=".sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala)."#mesaj".$usttekiid."");	 
	   else
	   echo "hata var";
     
	
/*//Burayýda sayfanýn en sonuna koyun.
$saymayi_bitir = acilma_suresi(); $basla = $saymayi_bitir - $saymaya_basla; 
echo "<div align='center' style='color:#555'>Sayfa " . substr($basla, 0, 5) . " saniyede oluþturuldu.</div>";
*/
?>

