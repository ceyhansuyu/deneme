<?php
session_start();
require_once("ayar.php");
require_once("functions.php");
require_once("../language/tr.php");

$kul 		= kul_temizle($_POST['kul']);
$sifre1 	= temizle($_POST['sifre']);
$sifre   	= $sifre1;
$gizli      = temizle($_POST['gizli']);
$hatirla    = temizle($_POST['hatirla']);
$ip         = $_SERVER["REMOTE_ADDR"];
$agent      = $_SERVER['HTTP_USER_AGENT'];
//$konu_tarihi= time();


		if(empty($kul) or empty($sifre1) )
        {		
		  header("location:../bilgiver.php?bilgi=giris_hatasi"); 
	  	  exit();
        }		
 
   

       $SQL1 = mysql_query("SELECT * FROM kullanicilar
						WHERE kul_adi ='".$kul."'");	
	   $KUL_BILGI = mysql_fetch_array($SQL1);
	 
	   // Giriþ baþarýlýysa
	   if (sha1($sifre.$KUL_BILGI["kul_sifre_hash"]) == $KUL_BILGI["kul_sifre"]) 
	   {
	   	
		unset($_SESSION['misafir_ilk_giris']);
		unset($_SESSION["captcha"]);
		 $SQL2 = mysql_query("SELECT * FROM kullanicilar
						WHERE kul_adi ='".$kul."'");
	    $kul= mysql_fetch_array($SQL2);
				
		// Eðer beni hatýrla seçeneði aktif ise cookie yapalým.
		// Mantýk nasýl olacak? = Mantýk olarak hatýrla iþaretlendiðinde
		// yeni bir kod üretilecek ve cookiye yazýlacak ayný zamanda database de oturumlara
		// yazýlacak ve üretilen kod bir daha üretilmeyecek. yani üretilmesi imkansýz.
		// çünkü o anki zamaný ek olarak ön ek olarak hash olarak önüne koyalým.
		 $oturum = temizle(generateCode(30)).time();
	     if($hatirla =="hatirla")
			{   
				setcookie($ayar["cookie_on_ek"].'hatirla', $oturum ,time() + $ayar["cookie_zamani"] ,$ayar["script_yolu"] );
				setcookie($ayar["cookie_on_ek"].'kullanici', $kul["kul_id"].",".$kul["kul_adi"] ,time() + $ayar["cookie_zamani"] ,$ayar["script_yolu"] );
				
				$SQL2 = mysql_query("UPDATE kullanicilar set 
		              kul_hatirla_hash='".$oturum."' WHERE kul_id='".$kul['kul_id']."' ");
			}	
		 
		 #### misafir okundu cookisini silelim ###########
		 setcookie($ayar["cookie_on_ek"].'okundu', ""      ,time() - $ayar["cookie_zamani"] , $ayar["script_yolu"] );		  

		  /// son giris tarhini ekleyelim
	      $son_oturum = time();
          $SQL = mysql_query("UPDATE kullanicilar set 
		       kul_son_giris='".$son_oturum."' WHERE kul_id='".$kul['kul_id']."' ");
		  
		    if($gizli =="gizli")
			{   				
				$SQL2 = mysql_query("UPDATE kullanicilar set 
		               kul_gizli_mi ='1' WHERE kul_id='".$kul['kul_id']."' ");
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


		
          // Online kullanýcý tablosundan misafir oturumunu silelim
		  $SQL = mysql_query("delete from online_kullanicilar 
							  WHERE kul_ip ='".$ip."' and kul_agent ='".$agent."'");

		    header("location:../bilgiver.php?bilgi=giris_basarili");
		}// Giriþ baþarýlýysa Ýf
	     else{
	           header("location:../bilgiver.php?bilgi=giris_basarisiz"); 
	         }
	   
	               
	

?>