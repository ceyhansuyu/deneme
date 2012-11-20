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
    $konu_id         	 = temizle($_POST['konu_id']);
    $anket_id         	 = temizle($_POST['anket_id']);
    $anket_sorusu        = temizle($_POST['anket_sorusu']);
    $anket_secenekler    = $_POST['secenek'];
    @$anket_suresi        = strtotime(temizle($_POST['anket_suresi']));

    @$oy_degistir         = temizle($_POST['oy_degistir']);
    @$kim_hansine_public  = temizle($_POST['kim_hansine_public']);
	$anket_time          =  time();

	
   // Anket sayýsýný güncellemek için
   if  ($_POST['action'] =="Güncelle")
	{
	//echo $anket_sec_sayisi;
	header("location:../anket.php?t=".$konu_id."&option=".$anket_sec_sayisi."");
	exit;
	}



	if(empty($anket_sorusu) or empty($anket_secenekler))
	 {
		header("location:bilgiver.php?bilgi=anket_sorusu_ve_secenek_yok");
		exit();
	 }
	 else if(empty($konu_id))
	 {
		header("location:bilgiver.php?bilgi=anket_konusu_yok");
		exit();
	 }
	
	// Boþ anketler böylece temizleniyor
	$silinsin=array(""," ");
    $anket_secenekler = array_diff($anket_secenekler,$silinsin);
	//echo print_r($sonuc);
	

	
	$anket_secenekler = implode("|||",$anket_secenekler); 
	
	//temizle yapalým
	$anket_secenekler= temizle($anket_secenekler);

	
	$gercek_anket_sec_sayisi=  substr_count($anket_secenekler,"|||") + 1;
	
	

	 
			 $SQLanket = mysql_query("UPDATE  anket_option set
									 anket_sorusu                ='$anket_sorusu',
									 anket_konu_id               ='$konu_id',
									 anket_zamani                ='$anket_time',
									 anket_secenekleri           ='$anket_secenekler',
						             anket_secenekleri_sayisi    ='$gercek_anket_sec_sayisi',
									 anket_bitis_suresi          ='$anket_suresi',
									 anket_oy_degistir           ='$oy_degistir',
									 anketi_oylayan_kul_sayisi   ='0',
									 anket_public                ='$kim_hansine_public',
									 anket_son_oy_zamani         ='0'
									WHERE anket_id=".$anket_id."");
			 
		
		
	 
	   if ($SQLanket) 
	   {
	   // echo "oldu";
		 header("location:../showthread.php?t=".$konu_id."");
	   }
	   else
	   {
	     echo "hata var";	   
	   }

	              

?>