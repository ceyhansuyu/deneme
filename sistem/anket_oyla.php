
<?php
require_once("ayar.php");
require_once("functions.php");
require_once("../language/tr.php");
session_start();
// �stenmeyen durumlara kar��n.
if ($_SESSION['kul_id'] =="00" or $_SESSION['kul'] =="misafir")
{
		header("location:../bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}
// �stenmeyen durumlara kar��n. Son

	/// Anket varsa
    $konu_id         	 = temizle($_POST['konu_id']);
    $anket_id         	 = temizle($_POST['anket_id']);
    $secenek_hangi_key   = $_POST['secenek'];
	$yazar_id 		     = temizle($_SESSION['kul_id']);
    $ip 			     = $_SERVER["REMOTE_ADDR"]; 
	$anket_time          =  time();
	
	
  /// KONUN FORUM IDS�N� BULALIM.
	$SQLforum = mysql_query("select * from konular where konu_id ='".$konu_id."'");
	$fetch_forum = mysql_fetch_array($SQLforum);
	$forum_id = $fetch_forum["konu_forum_id"];
	
  /// FORUMUN KATEGORS�N� BULALIM.
	$SQLkat = mysql_query("select * from forumlar where forum_id ='".$forum_id."'");
	$fetch_kat = mysql_fetch_array($SQLkat);
	$kat_id = $fetch_kat["kat_id"];
	
	
  // Anket sonu�lar�n� g�rmek i�in
   if  ($_POST['action'] =="Anket Sonu�lar�")
	{
	//echo $anket_sec_sayisi;
	header("location:../showthread.php?t=".$konu_id."&do=anket_sonuc");
	exit;
	}
	
	
 // Ankete geri d�nmek i�in
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
	
	//Anketteki oylar� par�alayarak diziye att�k
	$parcala_oy = explode("|||",$anket_toplam_oylari);
	

	
// E�er ayn� ankete ayn� kullan�c� oy vermi�se
    $SQL_anket_kul = mysql_query("SELECT * FROM anket_oylar 
							WHERE anket_id=".$anket_id." 
							and oyveren_kul_id ='".$yazar_id."'");
	$say_kul = mysql_num_rows($SQL_anket_kul);
	
	if($say_kul == 1)
	{
	
       // ilk �nce kullan�c�n kulland��� tablodan kulland��� son oyun keyini alal�m
	   $kul_son_oy_key_fetch = mysql_fetch_array($SQL_anket_kul); 
	   
	   $kul_son_oy_key = $kul_son_oy_key_fetch["oy_hangi_keyde"]; 
	   	
		//anket optiondaki keydeki toplam  oy say�s�n� bir azalt�yoruz.
		// Yani kullan�c�n�n oyunu siliyoruz
		$parcala_oy[$kul_son_oy_key]= $parcala_oy[$kul_son_oy_key] - 1;
		
		/// oyland�ktan sonraki yeni durum
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
		
		
		//anket kullan�c� yeni oyunu kullan�yor
		$parcala_oy[$secenek_hangi_key]= $parcala_oy[$secenek_hangi_key] + 1;
		
		/// oyland�ktan sonraki yeni durum
		$son_oylanmis_durum = implode("|||",$parcala_oy);
		
		//Ayn� zamanda anket_oylardaki	 toplam oylar� g�ncelleyelim.
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
		

		
		//anket optiondaki keydeki toplam  oy say�s�n� bir art�r�yoruz.
		$parcala_oy[$secenek_hangi_key]= $parcala_oy[$secenek_hangi_key] +1;
		
		/// oyland�ktan sonraki yeni durum
		$son_oylanmis_durum = implode("|||",$parcala_oy);
	
		//Ayn� zamanda anket_oylardaki	 toplam oylar� g�ncelleyelim.
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