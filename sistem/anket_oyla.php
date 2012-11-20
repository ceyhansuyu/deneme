
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
    $secenek_hangi_key   = $_POST['secenek'];
	$yazar_id 		     = temizle($_SESSION['kul_id']);
    $ip 			     = $_SERVER["REMOTE_ADDR"]; 
	$anket_time          =  time();
	
	
  /// KONUN FORUM IDSÝNÝ BULALIM.
	$SQLforum = mysql_query("select * from konular where konu_id ='".$konu_id."'");
	$fetch_forum = mysql_fetch_array($SQLforum);
	$forum_id = $fetch_forum["konu_forum_id"];
	
  /// FORUMUN KATEGORSÝNÝ BULALIM.
	$SQLkat = mysql_query("select * from forumlar where forum_id ='".$forum_id."'");
	$fetch_kat = mysql_fetch_array($SQLkat);
	$kat_id = $fetch_kat["kat_id"];
	
	
  // Anket sonuçlarýný görmek için
   if  ($_POST['action'] =="Anket Sonuçlarý")
	{
	//echo $anket_sec_sayisi;
	header("location:../showthread.php?t=".$konu_id."&do=anket_sonuc");
	exit;
	}
	
	
 // Ankete geri dönmek için
   if  ($_POST['action'] =="Ankete Git")
	{
	//echo $anket_sec_sayisi;
	header("location:../showthread.php?t=".$konu_id."");
	exit;
	}
	
	

    $SQL_anket = mysql_query("SELECT * FROM anket_option 
							WHERE anket_id='".$anket_id."'");
	
	$SQL_anket_sec = mysql_fetch_array($SQL_anket);
	
	$anket_toplam_oylari = $SQL_anket_sec["anket_oylari_toplam"];
	
	//Anketteki oylarý parçalayarak diziye attýk
	$parcala_oy = explode("|||",$anket_toplam_oylari);
	

	
// Eðer ayný ankete ayný kullanýcý oy vermiþse
    $SQL_anket_kul = mysql_query("SELECT * FROM anket_oylar 
							WHERE anket_id=".$anket_id." 
							and oyveren_kul_id ='".$yazar_id."'");
	$say_kul = mysql_num_rows($SQL_anket_kul);
	
	if($say_kul == 1)
	{
	
       // ilk önce kullanýcýn kullandýðý tablodan kullandýðý son oyun keyini alalým
	   $kul_son_oy_key_fetch = mysql_fetch_array($SQL_anket_kul); 
	   
	   $kul_son_oy_key = $kul_son_oy_key_fetch["oy_hangi_keyde"]; 
	   	
		//anket optiondaki keydeki toplam  oy sayýsýný bir azaltýyoruz.
		// Yani kullanýcýnýn oyunu siliyoruz
		$parcala_oy[$kul_son_oy_key]= $parcala_oy[$kul_son_oy_key] - 1;
		
		/// oylandýktan sonraki yeni durum
		//$son_oylanmis_durum = implode("|||",$parcala_oy);
							
	
		 $SQLanket_oy = mysql_query("UPDATE  anket_oylar set
									 anket_id         ='$anket_id',
									 oyveren_kul_id   ='$yazar_id',
									 oy_zamani        ='$anket_time',
									 oy_hangi_keyde   ='$secenek_hangi_key',
									 oy_tipi          ='0',
						             oyveren_kul_ip   ='$ip'
				            WHERE anket_id=".$anket_id." 
							and oyveren_kul_id ='".$yazar_id."'");
		
		
		//anket kullanýcý yeni oyunu kullanýyor
		$parcala_oy[$secenek_hangi_key]= $parcala_oy[$secenek_hangi_key] + 1;
		
		/// oylandýktan sonraki yeni durum
		$son_oylanmis_durum = implode("|||",$parcala_oy);
		
		//Ayný zamanda anket_oylardaki	 toplam oylarý güncelleyelim.
		 $SQLanket_oy_ = mysql_query("UPDATE  anket_option set
									 anket_oylari_toplam      ='$son_oylanmis_durum',
									 anket_son_oy_zamani        ='$anket_time'
							WHERE  anket_id =".$anket_id."");
	
	}
	else if($say_kul == 0)
	{
		 $SQLanket_oy = mysql_query("insert into anket_oylar set
									 anket_id         ='$anket_id',
									 anket_kat_id     ='$kat_id',
									 anket_forum_id   ='$forum_id',
									 anket_konu_id    ='$konu_id',
									 oyveren_kul_id   ='$yazar_id',
									 oy_zamani        ='$anket_time',
									 oy_hangi_keyde   ='$secenek_hangi_key',
									 oy_tipi          ='0',
						             oyveren_kul_ip   ='$ip'
								");
		

		
		//anket optiondaki keydeki toplam  oy sayýsýný bir artýrýyoruz.
		$parcala_oy[$secenek_hangi_key]= $parcala_oy[$secenek_hangi_key] +1;
		
		/// oylandýktan sonraki yeni durum
		$son_oylanmis_durum = implode("|||",$parcala_oy);
	
		//Ayný zamanda anket_oylardaki	 toplam oylarý güncelleyelim.
		 $SQLanket_oy_ = mysql_query("UPDATE  anket_option set
									 anket_oylari_toplam         ='$son_oylanmis_durum',
									 anketi_oylayan_kul_sayisi   = anketi_oylayan_kul_sayisi + 1,
									 anket_son_oy_zamani         ='$anket_time'
							WHERE  anket_id =".$anket_id."");
		
	}	
	 
	   if ($SQLanket_oy) 
        header("location:../showthread.php?t=".$konu_id."&do=anket_sonuc");
	   else
	   echo "hata var";
           

?>