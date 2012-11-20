<?php
require_once("genel.php");

// Ýstenmeyen durumlara karþýn.
if ($_SESSION['kul'] =="misafir")
{
		header("location:index.php");
		exit();
}
// Ýstenmeyen durumlara karþýn. Son

$kullanici_id = kullanici_temizle($_GET["u"]);
// Eðer kullanýcý id yoksa oturumun idsini ata
if(empty($kullanici_id)) $kullanici_id = $_SESSION["kul_id"];

	//SAYFA DETAYLARI
	$SQL = mysql_query("SELECT * FROM kullanicilar 
						WHERE kul_id='".$kullanici_id."'");
			
    $row = mysql_fetch_array($SQL);
	
 
	  	$menu = '<a href="index.php">Anasayfa</a> > 
            <a href="profil.php?u='.$row["kul_id"].'">'.$row["kul_adi"].' Profil</a>';
	
	  
	$baslik= " - ".$row["kul_adi"]." Profil";
	$sayfa_url = "profil.php?u=".$row["kul_id"];
	// Kullanýcý koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullanýcý koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,	
		));
		unset($SQL);
    //SAYFA DETAYLARI
	require_once("baslik.php");




     $SQL = mysql_query("SELECT * FROM kullanicilar WHERE kul_id='".$kullanici_id."'");
	 
	 while($row = mysql_fetch_array($SQL))
	 {
	 
	 
			if($kul["kul_cinsiyet"] == "Erkek")
			{
			  
			   $kul_cins_resim= $ayar["TEMA_YOLU"]."/images/erkek.png";
			}
			else if($kul["kul_cinsiyet"] == "Kadýn")
			{

			   $kul_cins_resim= $ayar["TEMA_YOLU"]."/images/kadin.png";
			}
			else
			{
			   $kul_cins_resim= $ayar["TEMA_YOLU"]."/images/erkek.png";

			}
			
	 // KULLANICI ONLÝNE MÝ?
	 
		if((($row['kul_son_aktivite'] + $ayar["cevrimici_zaman_asimi"]) > time() ) and
			($row['kul_son_sayfa'] != 'sistem/cikis.php'))
		{
		 $mesaj_yazar_durum = '<font color="#339900">Online</font>';
		}
		else
		{
		 $mesaj_yazar_durum = '<font color="#CC0000">Offline</font>';

		}
	    
		// KULLANICININ TÜM MESAJLARINI BUL
		$SQL_mesaj = mysql_query("SELECT * FROM mesajlar 
									WHERE mesaj_author_id ='".$row["kul_id"]."'");
	    $kul_mesaj_sayisi = mysql_num_rows($SQL_mesaj);
		
		$template->assign_vars(array(
			'KUL_ADI'            => $row["kul_adi"] ,
			'KUL_ID'             => $row["kul_id"] ,
			'KUL_GRUP_NAME'      => $row["kul_grup_name"] ,
			'KUL_EMAIL'          => $row["kul_email"] ,
			'KUL_DOGUM_TARIHI'   => $row["kul_dogum_tarihi"] ,
			'KUL_IMZA'           => $row["kul_imza"] ,
	        'KUL_AVATAR'          => ($row["kul_avatar"]=="")? "resim/avatar_yok.png":$row["kul_avatar"],
			'KUL_KAYIT_ZAMANI'   => tarih($row["kul_kayit_zamani"],$ayar['sistem_zaman_dilimi']) ,
			'KUL_SON_AKTIVITE'   => $row["kul_son_aktivite"] ,
			'KUL_SON_SAYFA'      => $row["kul_son_sayfa"] ,
	        'KUL_SON_GIRIS'      => @konu_tarihi($row['kul_son_giris'],$ayar["sistem_zaman_dilimi"]) ,
			'KUL_UYELIK_AMAC'    => $row["kul_uyelik_amac"] ,
			'KUL_YAHOO'          => $row["kul_yahoo"] ,
			'KUL_MSN'            => $row["kul_msn"] ,
			'KUL_AIM'            => $row["kul_aim"] ,
			'KUL_SKYPE'          => $row["kul_skype"] ,
			'KUL_ICQ'            => $row["kul_icq"] ,
			'KUL_BIYOGRAFI'      => $row["kul_biyografi"] ,
			'KUL_YER'            => $row["kul_yer"] ,
			'KUL_HOBI'           => $row["kul_hobi"] ,
			'KUL_MESLEK'         => $row["kul_meslek"] ,
			'KUL_CINSIYET'       => $row["kul_cinsiyet"] ,
			'CINS_IKON'          => $kul_cins_resim ,
			'KUL_YAS'            => $row["kul_yas"] ,
			'KUL_GERCEK_AD'      => $row["kul_gercek_ad"] ,
			'TEMA_YOLU'          => $ayar["TEMA_YOLU"] ,
			'ONLINE_MI'          => $mesaj_yazar_durum ,
			'KUL_TOPLAM_MESAJ'   => $kul_mesaj_sayisi ,
	
		));
	 }
	 

$template->set_filenames(array('profil' => 'profil.html' ));

$template->display('profil');

require_once("footer.php");

?>