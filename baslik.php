<?php
require_once("genel.php");




if(empty($_SESSION['kul_son_aktivite']))
    $_SESSION['kul_son_aktivite'] = time();
	


if(empty($_SESSION['kul']) or empty($_SESSION['kul_id']))
 {
 	$_SESSION['kul'] ="misafir";	
	$_SESSION['kul_id'] = "00";	
	$_SESSION['misafir_ilk_giris'] = time();	
 }
 
//echo @$_SESSION['misafir_ilk_giris'];
 
// Eðer misafirse oturumlarý dbye kaydet ve misafirken hep güncelle 
if ($_SESSION['kul'] =="misafir" and $_SESSION['kul_id'] == "00")
{
	$time = time();
	$s_id = session_id();
	$ip   = $_SERVER["REMOTE_ADDR"];
	$agent = $_SERVER['HTTP_USER_AGENT'];
    
	
	$SQL = mysql_query("SELECT * FROM online_kullanicilar 
						WHERE  kul_ip = '".$ip."' and kul_agent ='".$agent."'");
    $say = mysql_num_rows($SQL);
	
	if($say == 0 )
	{
	   
		$SQL = mysql_query("insert into online_kullanicilar set 
							   kul_id                ='00',
							   kul_adi               ='misafir',
							   kul_giris             = '$time',
							   kul_s_id              ='$s_id',
							   kul_son_sayfa         ='$sayfa_url',
							   kul_son_sayfa_baslik  ='$baslik',
							   kul_ip                ='$ip',	   
							   kul_agent             ='$agent',
							   kul_son_aktivite      ='$time'
							");	
	}else if($say > 0)
	{
	    $SQL = mysql_query("delete from online_kullanicilar 
		                   WHERE kul_ip ='".$ip."' and kul_agent ='".$agent."'");
	
		$SQL = mysql_query("insert into online_kullanicilar set 
							   kul_id         ='00',
							   kul_adi        ='misafir',
							   kul_giris      = '$time',
							   kul_s_id       ='$s_id',
							   kul_son_sayfa  ='$sayfa_url',
							   kul_son_sayfa_baslik  ='$baslik',
							   kul_ip         ='$ip',	   
							   kul_agent      ='$agent',
							   kul_son_aktivite     ='$time'
							");	
	}
} 






// Eðer hatýrla beni aktif edilmiþ ise kullanýcý bilgilerini çekerek
// kullanýcýyý hatýrlayalým. 
if (isset($_COOKIE[$ayar["cookie_on_ek"]."hatirla"]) and isset($_COOKIE[$ayar["cookie_on_ek"]."kullanici"]) and $_SESSION['kul'] =="misafir") 
{//COOKIE
	$kullanici = temizle($_COOKIE[$ayar["cookie_on_ek"]."kullanici"]);
	$hatirla   = temizle($_COOKIE[$ayar["cookie_on_ek"]."hatirla"]);
	$cerez = explode(',' , $kullanici);
	$kul_id = intval($cerez[0]);

	$SQLKUL = mysql_query("SELECT * FROM kullanicilar 
	WHERE kul_id = ".$kul_id." AND kul_hatirla_hash='".$hatirla."'");
	
	$kul = mysql_fetch_array($SQLKUL);	
	
	// Eðer çerezdeki veri ile Veri tabanýndaki veri eþit deðilse çalýþmayý durdur hata ver
	if($SQLKUL == false)
	{
	 	header("location:sistem/cikis.php");
		exit();
	}
	
	$_SESSION['kul']= $kul["kul_adi"];  
	$_SESSION['kul_id']= $kul["kul_id"]; 
	$_SESSION['kul_yetki']= $kul["kul_yetki"];   
	$_SESSION['kul_email']= $kul["kul_email"];   
	$_SESSION['kul_son_giris']= $kul["kul_son_giris"];   
	$_SESSION['kul_son_aktivite']= $kul["kul_son_cikis"];   
	$_SESSION['kul_yetki']= $kul["kul_yetki"]; 
	$_SESSION['kul_grup_name']= $kul["kul_grup_name"]; 
	$_SESSION['kul_group_id']= $kul["kul_group_id"]; 
    $_SESSION['kul_grup_color']= $kul["kul_grup_color"]; 
	
	
}//COOKIE SON



///// YENÝ PM VAR MI BAKALIM
  if($_SESSION['kul'] !="misafir")
  {
    $SQL = mysql_query("SELECT * FROM ozel_mesaj 
						WHERE  kime_gonderdi_id ='".$_SESSION['kul_id']."' 
						and okunma_zamani ='' and alanin_kutusu ='gelen' ");
			 
	 $yeni_pm_say = @mysql_num_rows($SQL);

	
           $template->assign_vars(array(
	         'YENI_PM_SAY'     => ($yeni_pm_say > 0) ? "<a href='ozel_mesaj.php?do=gelen'><span class='yeni_pm'> &nbsp;".$yeni_pm_say." Yeni mesaj </span></a>":"",
		   ));	

  
  }


$template->assign_vars(array(
	'TEMA_YOLU'     => $ayar["TEMA_YOLU"] ,
	'FORUM_TARIH'   => forum_tarihi(time(),$ayar["sistem_zaman_dilimi"]) ,
	//'BASLIK'        => $baslik,
	//'MENU'          => $menu,
	'S_LOGIN'       => ($_SESSION['kul'] != "misafir") ? true : false,
	'KULLANICI'     => @$_SESSION['kul'],
	'KULLANICI_ID'  => @$_SESSION['kul_id'],
	'KUL_SON_GIRIS' => @konu_tarihi($_SESSION['kul_son_giris'],$ayar["sistem_zaman_dilimi"]) ,
    'S_ADMIN'       => (@$_SESSION['kul_yetki'] == "admin") ? true:false,// adminse
    'GRUP'       => @$_SESSION['kul_grup_name'],
    'RENK'       => kul_group_color($_SESSION['kul_id']),
    'EMINMISIN_CIKMAK_ICIN'       => $lang["eminmisin_cikmak_icin"],
    'SEO_AKTIFSE'       => ($ayar["seo_durum"] =="acik") ? true:false,
	
));


 //Eðer misafir deðilse kul bilgilerini çek
 if ($_SESSION['kul'] !="misafir" and $_SESSION['kul_id'] !="00")
{
		$SQL = mysql_query("SELECT * FROM kullanicilar 
							WHERE kul_id='".$_SESSION['kul_id']."'");
		
		$kul = mysql_fetch_array($SQL);
}
 

 

// EÐER ZAMANLANMIÞ BÝR ANKET VARSA ANKETÝ VE SONUÇLARINI SÝL
    $time = time();
	
	$SQLanketsil = mysql_query("SELECT * FROM anket_option 
						WHERE anket_bitis_suresi !='' and (anket_bitis_suresi < '".$time."')");
	 while($anket = mysql_fetch_array($SQLanketsil))
	 {
	    $SQL_sil = mysql_query("delete from anket_option  WHERE  anket_id ='".$anket["anket_id"]."'");
	    $SQL_oy_sil = mysql_query("delete from anket_oylar  WHERE  anket_id ='".$anket["anket_id"]."'");
	   
	   if($SQL_sil == true and $SQL_oy_sil == false) echo "Anket siliminde hata var";
	 
	 }
	
// EÐER ZAMANLANMIÞ BÝR ANKET VARSA ANKETÝ VE SONUÇLARINI SÝL SONN
 
 


if($ayar["forum_durumu"] =="kapali" and @$_SESSION['kul_group_id'] != "1" and $baslik != "Forum Kapalýdýr.")
{
  	header("location:forum_kapali.php");
	exit();
}
 
 



$template->set_filenames(array('baslik' => 'baslik.html' ));

$template->display('baslik');


?>