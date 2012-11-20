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


	$f_id             	  = temizle($_POST['hangi_forum']);
	$konu_modu         	  = temizle($_POST['mode']);
	$konu 			  = temizle($_POST['editor']);
	$konu_baslik		  = temizle($_POST['konu_baslik']);
	$konu_ikonu	          = temizle($_POST['konu_ikonu']);
	$konu_tarihi		  = time();
	$yazar 		  	  = temizle($_SESSION['kul']);
	$yazar_id 		  = temizle($_SESSION['kul_id']);
	$konu_son_mesaj_zamani 	  = time();
	$ip 		  	  = $_SERVER["REMOTE_ADDR"];
	$mesaj_durum 		  = "konu";
	/// Anket varsa
	$anket_yap         	  = temizle($_POST['anket_yap']);
	$anket_kac_secenek        = temizle($_POST['anket_sayisi']);

  /// FORUMUN KATEGORÝSÝNÝ BULALIM.
	$SQLkat = mysql_query("select * from forumlar where forum_id ='".$f_id."'");
	$fetch_kat = mysql_fetch_array($SQLkat);
	$kat_id = $fetch_kat["kat_id"];
	
// KÝLÝTLÝ FORUMA KONU AÇMAYI ENGELLEYELÝM
	$SQL = mysql_query("select * from forumlar where forum_id=".$fid."");
	$row = mysql_fetch_array($SQL);
	
	if($row["forum_kilitlimi"] =="evet" and $kul_izin["forum_kilitli_konu_acma"] =="hayir")
	{
		header("location:../bilgiver.php?bilgi=kilitli_foruma_konu_yetki_yok");
		exit();
	
	}
	unset($SQL);
	
	
	
	
	

	//Eðer konu ikonu boþsa default ikonu seç
	if($konu_ikonu=="") $konu_ikonu ="resim/icons/icon1.gif";
	
		if(empty($konu) || empty($konu_baslik) )
        {		
		header("location:../bilgiver.php?bilgi=konu_ekleme_basarisiz"); 
		exit();
        }		
 
    $SQL = mysql_query("insert into konular set 
	   konu_kat_id   ='$kat_id',
	   konu_forum_id ='$f_id',
	   konu_mod ='$konu_modu',
	   konu_baslik='$konu_baslik',
	   konu_zamani ='$konu_tarihi',	   
	   konu_author ='$yazar',
	   konu_author_id ='$yazar_id',
	   konu_author_ip ='$ip',
	   konu_ikonu ='$konu_ikonu',
	   son_mesaj_zamani ='$konu_son_mesaj_zamani',
	   son_mesaj_yazar    = '$yazar',
	   son_mesaj_yazar_id = '$yazar_id'
	   ");	
      
	  $usttekiid = mysql_insert_id();

       $SQL2 = mysql_query("insert into mesajlar set 
           mesaj_forum_id ='$f_id',
           mesaj_kat_id  ='$kat_id',
           mesaj_konu_id ='$usttekiid',
           mesaj_durum   ='$mesaj_durum',
	   mesaj_zamani  ='$konu_tarihi',
	   mesaj_author  = '$yazar',
	   mesaj_author_id  ='$yazar_id',
	   mesaj_author_ip ='$ip',
	   mesaj_baslik  ='$konu_baslik',	   
	   mesaj_govde  ='$konu',
	   mesaj_ikonu  ='$konu_ikonu'
	   ");	

	   $usttekiid2 = mysql_insert_id();
	   
    
	 // forumdaki cevap sayýsýný 1 artýr
	 $SQL3 = mysql_query("UPDATE forumlar  set 
	   forum_toplam_konu   = forum_toplam_konu + 1,
	   forum_son_mesaj_title  = '$konu_baslik',
	   forum_son_mesaj_id     = '$usttekiid2',
	   forum_son_mesaj_konu_id   = '$usttekiid',
	   forum_son_mesaj_kul    = '$yazar',
	   forum_son_mesaj_kul_id = '$yazar_id',
	   forum_son_mesaj_zamani = '$konu_tarihi',
	   forum_son_mesaj_ikonu  = '$konu_ikonu'
	   
	   WHERE forum_id =".$f_id."");		   
	  
      // Üst forumu var mý bakalým	  
	  $SQL4 = mysql_query("SELECT * FROM forumlar WHERE forum_id =".$f_id."");
	  $sor = mysql_fetch_array($SQL4);	
	  // Eðer üst forumu varsa
	  if(!empty($sor["forum_ust_f"]))
        {
		 $forum_son_mesaj_tarih = $sor["forum_son_mesaj_zamani"];
		 // forumdaki cevap sayýsýný 1 artýr
		 $SQL5 = mysql_query("UPDATE forumlar  set 
		   forum_toplam_konu   = forum_toplam_konu + 1,
		   forum_son_mesaj_title  = '$konu_baslik',
		   forum_son_mesaj_id     = '$usttekiid2',
		   forum_son_mesaj_konu_id   = '$usttekiid',
		   forum_son_mesaj_kul    = '$yazar',
		   forum_son_mesaj_kul_id = '$yazar_id',
		   forum_son_mesaj_zamani = '$forum_son_mesaj_tarih',
		   forum_son_mesaj_ikonu  = '$konu_ikonu'
		   WHERE forum_id =".$sor["forum_ust_f"]."");
		
		}
		else 
		{
		  echo "Olmadý be";
		}
		
		
    /// FORUMA ABONE OLANLARA MAÝL YOLLA
	$sql_abonebul = mysql_query("select * from abonelikler where  forumID ='".$f_id."'");

	while( $row = mysql_fetch_array($sql_abonebul))
	{
	   $sql_kul_bul = mysql_query("select * from kullanicilar 
				  	 where kul_id='".$row["kullaniciID"]."'");
	   $sqlkul = mysql_fetch_array($sql_kul_bul);
		
	  //EÐER KULLANICI EMÝL UYARISI ÝSTÝYORSA
	  if($sqlkul["kul_pm_uyari"] =="evet")
	  {
		  $kime   = $sqlkul["kul_email"];
		  $kimden = $ayar["board_email"];
		  $baslik = $sor["forum_adi"];
		  $govde  = "<b>".$sor["forum_adi"]." </b> forumlarýna yeni bir konu açýldýðý için bu maili alýyorsunuz.<br>
					Konu: <a href='".$ayar_site_adresi."showthread.php?t=".$usttekiid."'>".$konu_baslik."</a>";

		  mail_yolla($kime, $baslik, $govde, $kimden) ;
	  }

	}
		

  // Eðer Anket varsa
      if($anket_yap =="anket_yap")
      {
	  
	     header("location:../anket.php?t=".$usttekiid."&option=".$anket_kac_secenek."");
      
	  }
	  //Anket Yoksa
      else
      {
		   if ($SQL and $SQL2 and $SQL3) 
		     header("location:../showthread.php?t=".$usttekiid."");
		   else
		     echo "hata var";

      }
		
	 

	               
	

?>