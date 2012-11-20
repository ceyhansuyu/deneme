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
    $anket_sec_sayisi    = temizle($_POST['anket_secenek_sayisi']);
    $anket_sorusu        = temizle($_POST['anket_sorusu']);
    $anket_secenekler    = $_POST['secenek'];
    @$anket_suresi        = strtotime(temizle($_POST['anket_suresi']));

    @$oy_degistir         = temizle($_POST['oy_degistir']);
    @$kim_hansine_public  = temizle($_POST['kim_hansine_public']);
	$anket_time          =  time();

	
	// KULLANICIN YETKÝSÝ YOKSA ANKET AÇMAYI ENGELLEYELÝM
	if($kul_izin["anket_acma"] =="hayir")
	{
		header("location:../bilgiver.php?bilgi=anket_acmaya_yetkiniz_yok");
		exit();
	
	}

  /// KONUN FORUM IDSÝNÝ BULALIM.
	$SQLforum = mysql_query("select * from konular where konu_id ='".$konu_id."'");
	$fetch_forum = mysql_fetch_array($SQLforum);
	$forum_id = $fetch_forum["konu_forum_id"];
	
  /// FORUMUN KATEGORSÝNÝ BULALIM.
	$SQLkat = mysql_query("select * from forumlar where forum_id ='".$forum_id."'");
	$fetch_kat = mysql_fetch_array($SQLkat);
	$kat_id = $fetch_kat["kat_id"];
	
	
	
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
	
	 $anket_oylari ="";
	 for($sayac =1; $sayac <= $gercek_anket_sec_sayisi ; $sayac ++)
	 {
	   if ($sayac == $gercek_anket_sec_sayisi)
	   $anket_oylari .="0";
	   else
	   $anket_oylari .="0|||";
	 }// sýfýrlarýn arasýna ||| atýyoruz

	/* 
	echo $anket_oylari."<br>";
	echo    $konu_id."<br>";
	echo    $gercek_anket_sec_sayisi." gercek anket sayýsý<br>";
	echo    $anket_sorusu."<br>";
	echo    $anket_secenekler."<br>";
	echo    $anket_suresi."<br>";
	echo    $oy_degistir."<br>";
	echo    $kim_hansine_public."<br>";
	echo    $anket_time."<br>";
	*/
			 $SQLanket = mysql_query("insert into anket_option set
									 anket_sorusu                ='$anket_sorusu',
									 anket_konu_id               ='$konu_id',
									 anket_kat_id                ='$kat_id',
									 anket_forum_id              ='$forum_id',
									 anket_zamani                ='$anket_time',
									 anket_secenekleri           ='$anket_secenekler',
									 anket_oylari_toplam         ='$anket_oylari',
						             anket_secenekleri_sayisi    ='$gercek_anket_sec_sayisi',
									 anket_bitis_suresi          ='$anket_suresi',
									 anket_oy_degistir           ='$oy_degistir',
									 anketi_oylayan_kul_sayisi   ='0',
									 anket_public                ='$kim_hansine_public',
									 anket_son_oy_zamani         ='0'
									");
			 
		
		
	 
	   if ($SQLanket) 
	   {
	    echo "oldu";
		header("location:../showthread.php?t=".$konu_id."");
	   }
	   else
	   {
	     echo "hata var";	   
	   }

	              

?>