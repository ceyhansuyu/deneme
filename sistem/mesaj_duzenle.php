<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");
## /// Sayfa a��lma s�resi ## ===>>>> $saymaya_basla = acilma_suresi();

session_start();
// �stenmeyen durumlara kar��n. hack vb.
if ($_SESSION['kul'] =="misafir")
{
		header("location:bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}
// �stenmeyen durumlara kar��n. Son
$cevap_id       = temizle($_POST['mesaj_id']);
$konu_id     	= temizle($_POST['hangi_forum']);
$konu_ikonu     = temizle($_POST['konu_ikonu']);
$mode       	= temizle($_POST['mode']);
$cevap 			= temizle($_POST['editor']);
$cevap_baslik	= temizle($_POST['cevap_baslik']);
$edit_sebep  	= temizle($_POST['edit_sebep']);
$edit_zaman  	= time();
$edit_yazar 	= temizle($_SESSION['kul']);
$edit_yazar_id 	= temizle($_SESSION['kul_id']);
$mesaj_durum 	= temizle($_POST['mesaj_durum']);
$ip 			= $_SERVER["REMOTE_ADDR"];  
//$konu_ikonu ="yok"; //temizle($_POST['konu_ikonu']);
//$konu_son_mesaj_zamani = time();

	if(empty($cevap_baslik) || empty($cevap) )
    {		
	  header("location:../bilgiver.php?bilgi=duzenleme_basarisiz"); 
	  exit();
    }	

 
    $SQL = mysql_query("UPDATE  mesajlar set 
	   mesaj_baslik      ='$cevap_baslik',	   
	   mesaj_govde       ='$cevap',
	   mesaj_ikonu       ='$konu_ikonu',
	   mesaj_edit_sebep  ='$edit_sebep',
	   mesaj_edit_zaman  ='$edit_zaman',
	   mesaj_edit_kim    ='$edit_yazar',
	   mesaj_edit_kim_id ='$edit_yazar_id',
	   mesaj_edit_sayisi = mesaj_edit_sayisi + 1
	   WHERE mesaj_id =".$cevap_id."");
	
   
   
   
	 
	// ka� sayfa mesaj var bir bakal�m.
	$tablosayfala ="mesajlar";
	$WHERE_mesajforumid = $konu_id;
	$limitsayfala = $ayar["sayfala_limit_cevap"];
	// sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala)
	 
################################################################	 
	// E�er cevap as�l konunun cevab� yani konusu ise
	if ($mesaj_durum =="konu")
	{// b�y�k if
	 
	  //Konu ba�l���n� d�zenleyelim
      $SQL1 = mysql_query("UPDATE  konular set 
	  konu_baslik       ='$cevap_baslik',	   
	  konu_ikonu       ='$konu_ikonu',	   
	  konu_mod          ='$mode'	   
	  WHERE konu_id =".$konu_id."");
   
	  if ($SQL1 == false)
       {	   
          echo "hata var 1";
		  exit();
	   }
	  
    }// b�y�k if son
	 
	 
	 
#########  E�er d�zenlenen cevap konun son cevab� ise   ########

	$SQL2 = mysql_query("SELECT * FROM mesajlar 
							WHERE mesaj_konu_id =".$konu_id." 
							order by mesaj_zamani DESC LIMIT 1");
	$sor = mysql_fetch_array($SQL2);
	 
	if ($sor["mesaj_id"] == $cevap_id)
	{// b�y�k if
	 
	  $SQL3 = mysql_query("SELECT * FROM konular WHERE konu_id =".$konu_id."");
	  $sor2 = mysql_fetch_array($SQL3);
	
	  // forumdaki son mesaj ba�l���n� g�ncelle
	  $SQL4 = mysql_query("UPDATE forumlar  set 
	  forum_son_mesaj_title  = '$cevap_baslik',
	  forum_son_mesaj_ikonu  = '$konu_ikonu'
	  WHERE forum_id =".$sor2['konu_forum_id']."");	
	  
	  ### E�er alt forumsa, �st forumunda son mesaj�n� g�ncelleyelim ###
	  $SQL5 = mysql_query("SELECT * FROM forumlar 
								WHERE forum_id =".$sor2['konu_forum_id']."");
	  $sor3 = mysql_fetch_array($SQL5);
	  
			if($sor3["forum_tipi"] =="alt")
			{
				$SQL6 = mysql_query("UPDATE forumlar  set 
				forum_son_mesaj_title  = '$cevap_baslik',
				forum_son_mesaj_ikonu  = '$konu_ikonu'
				WHERE forum_id  =".$sor3['forum_ust_f']."");
				
				if($SQL6 == false) echo "SQL6 hatas�";
			
			}
	   
	  ### SONN E�er alt forumsa, �st forumunda son mesaj�n� g�ncelleyelim ###

	  if ($SQL2 == false or $SQL3 == false or $SQL4 == false)
      {	   
          echo "hata var 2";
		  exit();
	  }
	  
    }// b�y�k if son

############################################33333
	 
	if ($SQL) 
       header("location:../showthread.php?t=".$konu_id."&sayfa=".sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala)."#mesaj".$cevap_id."");	 
	else
	   echo "hata var 3";

/*//Buray�da sayfan�n en sonuna koyun.
$saymayi_bitir = acilma_suresi(); $basla = $saymayi_bitir - $saymaya_basla; 
echo "<div align='center' style='color:#555'>Sayfa " . substr($basla, 0, 5) . " saniyede olu�turuldu.</div>";
*/
?>

