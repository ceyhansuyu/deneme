<?php
session_start();
require_once("../../sistem/ayar.php");
require_once("functions.php");
require_once("../language/tr.php");

$kul 		= kul_temizle($_POST['kul']);
$sifre 	    = temizle($_POST['sifre']);
$ip         = $_SERVER["REMOTE_ADDR"];
$agent      = $_SERVER['HTTP_USER_AGENT'];
//$konu_tarihi= time();


		if(empty($kul) or empty($sifre) )
        {		
		 header("location:../bilgiver.php?bilgi=giris_hatasi"); 
		 exit();
        }		
 
    $SQL1 = mysql_query("SELECT * FROM kullanicilar
						WHERE kul_adi ='".$kul."' && kul_yetki ='admin'");	
    $KUL_BILGI = mysql_fetch_array($SQL1);
	 
// Giriþ baþarýlýysa
 if (sha1($sifre.$KUL_BILGI["kul_sifre_hash"]) == $KUL_BILGI["kul_sifre"]) 
	{
	     $SQLgiris = mysql_query("SELECT * FROM kullanicilar
						WHERE kul_adi ='".$kul."' && kul_yetki ='admin'");
						
	     $kul_admin= mysql_fetch_array($SQLgiris);
				

		
		  $_SESSION['kul_admin']= $kul_admin["kul_adi"];  
		  $_SESSION['kul_admin_id']= $kul_admin["kul_id"]; 
		  $_SESSION['kul_admin_yetki']= $kul_admin["kul_yetki"];   
		  $_SESSION['kul_admin_email']= $kul_admin["kul_email"];   
		  $_SESSION['kul_admin_son_giris']= $kul_admin["kul_son_giris"];   
	      
		  $_SESSION['kul_admin_son_aktivite']= $kul_admin["kul_son_cikis"];   
		  $_SESSION['kul_admin_yetki']= $kul_admin["kul_yetki"]; 
		  $_SESSION['kul_admin_grup_name']= $kul_admin["kul_grup_name"]; 
		  $_SESSION['kul_admin_grup_color']= $kul_admin["kul_grup_color"]; 


		    header("location:../index.php");
			
	 
	               
	}// giriþ baþar
     else
		 {
	        header("location:../bilgiver.php?bilgi=giris_basarisiz"); 
	     }
?>