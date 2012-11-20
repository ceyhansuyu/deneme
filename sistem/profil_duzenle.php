<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");

// Ýstenmeyen durumlara karþýn. hack vb.
if ($_SESSION['kul'] =="misafir")
{
		header("location:bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}

//Kullanýcý bilgilerini çekiyoruz
		$SQLkul = mysql_query("SELECT * FROM kullanicilar 
							WHERE kul_id='".$_SESSION['kul_id']."'");
		
		$kul = mysql_fetch_array($SQLkul);
		



// Ýstenmeyen durumlara karþýn. Son

$do     = temizle($_POST['do']);

//Profil detay
@$gizlilik      = temizle($_POST['gizlilik']);
@$uyelik_amac   = temizle($_POST['uyelik_amac']);
@$yahoo         = temizle($_POST['yahoo']);
@$msn 		    = temizle($_POST['msn']);
@$aim	        = temizle($_POST['aim']);
@$skype  	    = temizle($_POST['skype']);
@$icq  	        = temizle($_POST['icq']);
@$biyografi     = temizle($_POST['biyografi']);
@$yasadigi_yer  = temizle($_POST['yasadigi_yer']);
@$hobiler  	    = temizle($_POST['hobiler']);
@$meslek  	    = temizle($_POST['meslek']);
@$yasiniz  	    = temizle($_POST['yasiniz']);
@$dogum_tarihi  = temizle($_POST['dogum_tarihi']);
@$cinsiyet      = temizle($_POST['cinsiyet']);
@$gercek_ad      = temizle($_POST['gercek_ad']);
@$ozelmesaj_durum      = temizle($_POST['ozelmesajDURUM']);
@$ozelmesaj_email      = temizle($_POST['ozelmesaj_email']);

//þifre email
@$yeni_sifre            = temizle($_POST['yeni_sifre']);
@$yeni_sifre_tekrar     = temizle($_POST['yeni_sifre_tekrar']);
@$yeni_email            =  $_POST['yeni_email'];
@$eski_sifre            = temizle($_POST['eski_sifre']);

// imza
@$imza            = temizle($_POST['imza']);

// Avatar
@$avatar_url      = temizle($_POST['avatar_url']);
@$avatar_grup     = temizle($_POST['avatar_grup']);

$kul_name 	      = temizle($_SESSION['kul']);
$kul_id 	  = temizle($_SESSION['kul_id']);

//echo $kul["kul_hatirla_hash"];
  


	if($do =="profil_detay")
    {			
       $SQL = mysql_query("UPDATE  kullanicilar set 
	   kul_pm_istiyor_mu ='$ozelmesaj_durum',	   
	   kul_pm_uyari      ='$ozelmesaj_email',	   
	   kul_gizli_mi      ='$gizlilik',	   
	   kul_uyelik_amac   ='$uyelik_amac',
	   kul_yahoo         ='$yahoo',
	   kul_msn           ='$msn',
	   kul_aim           ='$aim',
	   kul_skype 	     ='$skype',
	   kul_icq 	         ='$icq',
	   kul_biyografi     ='$biyografi',
	   kul_yer 	         ='$yasadigi_yer',
	   kul_hobi 	     ='$hobiler',
	   kul_meslek 	     ='$meslek',
	   kul_cinsiyet      ='$cinsiyet',
	   kul_yas 	         ='$yasiniz',
	   kul_gercek_ad 	 ='$gercek_ad',
	   kul_dogum_tarihi  ='$dogum_tarihi'
	   WHERE kul_id =".$kul_id."");
	   
	   $git="profil_detay";
    }
    else if($do =="sifre_email")
    {
      
	  if($yeni_sifre != $yeni_sifre_tekrar)
	  {
		header("location:../bilgiver.php?bilgi=sifre_uyusmuyor");
		exit();
	  }
	  
	  if(($yeni_sifre != ""  and $yeni_sifre_tekrar =="") or ($yeni_sifre == ""  and $yeni_sifre_tekrar !=""))
	  {
		header("location:../bilgiver.php?bilgi=sifre_uyusmuyor");
		exit();
	  }
	  
	   if($yeni_email !="" and (emailkontrol($yeni_email) == 0)) // 1 olsa geçerli olacaktý
	   {
	   	header("location:../bilgiver.php?bilgi=mail_gercek_degil"); 
		exit();
	   }
	  
	   
	   //Eski þifre 
	   if(sha1($eski_sifre.$kul["kul_sifre_hash"]) != $kul["kul_sifre"])
	   {
	   	header("location:../bilgiver.php?bilgi=eski_sifre_hatali"); 
		$sifre_testi_gecti = false;
		exit();
	   }
	   else
	   {
	     $sifre_testi_gecti = true;
	   }
	   
	   //Eðer þifre ve mail deðiþecekse
	   if ($yeni_sifre != "" and $yeni_sifre_tekrar != "" and $yeni_email !="" and $sifre_testi_gecti == true)
	   {
	   
	       $yenisifreHash = temizle(generateCode(15));
	       $yeni_sifre = sha1($yeni_sifre.$yenisifreHash);

		   $SQL = mysql_query("UPDATE  kullanicilar set 
		   kul_sifre_hash   ='$yenisifreHash',	   
		   kul_sifre        ='$yeni_sifre',	   
		   kul_email        ='$yeni_email'
		   WHERE kul_id =".$kul_id."");  
	   }
	   
	   //Eðer sadece þifre deðiþecekse
	   if ($yeni_sifre != "" and $yeni_sifre_tekrar != "" and $yeni_email =="" and $sifre_testi_gecti == true)
	   {
	       $yenisifreHash = temizle(generateCode(15));
	       $yeni_sifre = sha1($yeni_sifre.$yenisifreHash);

		   $SQL = mysql_query("UPDATE  kullanicilar set 
		   kul_sifre_hash    ='$yenisifreHash',	   
		   kul_sifre         ='$yeni_sifre'	   
		   WHERE kul_id =".$kul_id."");  
	   }
	   
	   //Eðer sadece mail deðiþecekse
	   if ($yeni_sifre == "" and $yeni_sifre_tekrar == "" and $yeni_email !="" and $sifre_testi_gecti == true)
	   {
		   $SQL = mysql_query("UPDATE  kullanicilar set 
		   kul_email    ='$yeni_email'
		   WHERE kul_id =".$kul_id."");  
	   }
	   
   
	   $git="sifre_email";
    }
    else if($do =="imza")
    {
   
		   $SQL = mysql_query("UPDATE  kullanicilar set 
		   kul_imza    ='$imza'
		   WHERE kul_id =".$kul_id.""); 
		   
	   $git="imza";
    }
    else if($do =="avatar")
    {
		   $SQL = mysql_query("UPDATE  kullanicilar set 
		   kul_avatar        ='$avatar_grup',
		   kul_avatar_url    ='$avatar_url'
		   WHERE kul_id =".$kul_id.""); 

	   $git="avatar";
    }
 

	
	
	
	
	
	
	 
	if ($SQL) 
       header("location:../profil_duzenle.php?do=".$git."");	 
	else
	   echo "hata var 3";



?>

