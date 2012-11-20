<?php
session_start();
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");

//kayit.php den gelen verileri çekiyoruz
$kullanici = kul_temizle($_POST['kullanici']);
$sifre1    = temizle($_POST['sifre1']);
$sifre2    = temizle($_POST['sifre2']);
$mail1     = emailkontrol($_POST['mail1']);
$mail2     = emailkontrol($_POST['mail2']);
$mail      = temizle($_POST['mail1']);
$guv_kodu  = strtolower(trim(temizle($_POST['guvenlik_kodu'])));
$sozlesme  = temizle($_POST['sozlesme']);
$kayit_tarihi= time();
$ip   = $_SERVER["REMOTE_ADDR"];
$agent = $_SERVER['HTTP_USER_AGENT'];

@$ekstra_soru_cevabi  = strtolower(temizle($_POST['ekstra_soru_cevabi']));

	if(($ayar["ekstra_spam_sorusu"] =="acik") and ($ekstra_soru_cevabi != $ayar["kayit_cevabi"]) )
	{
		 header("location:../bilgiver.php?bilgi=ekstra_spam_sorusu_hata"); 
		 exit();
	}


$sifreHash = temizle(generateCode(15));
$sifre     = sha1($sifre1.$sifreHash);

	  if(empty($kullanici) || empty($sifre1) || empty($sifre2) || empty($mail1) || empty($mail2) )
        {		
		 header("location:../bilgiver.php?bilgi=bos_alan_birakmayiniz"); 
		 exit();
        }
 
	   
      if($sifre1 != $sifre2)
	   {
	   	header("location:../bilgiver.php?bilgi=sifre_uyusmuyor"); 
		exit();
	   }
      if($mail1 != $mail2)
	   {
	   	header("location:../bilgiver.php?bilgi=mail_uyusmuyor"); 
		exit();
	   }	      
	   
	   if($mail1 == 0 and $mail2 == 0) // 1 olsa geçerli olacaktý
	   {
	   	header("location:../bilgiver.php?bilgi=mail_gercek_degil"); 
		exit();
	   }	
	   
	   //EÐER CAPTHA RECAPTHA ÝSE
	   if($ayar["reCAPTCHA_aktif_mi"] =="acik")
	   {
           require_once('reCAPTCHAlib.php');
           $privatekey = $ayar["reCAPTCHA_privatekey"];
		   
           $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
			
			if (!$resp->is_valid)
            {
                // What happens when the CAPTCHA was entered incorrectly
				header("location:../bilgiver.php?bilgi=guvenlik_kodu_hatasi"); 
				exit();
            } 

	   
	   }
	   // diðer güvenli doðrulama sistemi
	   else
	   {
			  if($_SESSION["captcha"] != $guv_kodu)
			   {
				header("location:../bilgiver.php?bilgi=guvenlik_kodu_hatasi"); 
				exit();
			   }
	   
	   }

	   
	  if($sozlesme !="kabul")
	   {
	   	header("location:../bilgiver.php?bilgi=forum_kural_ret"); 
		exit();
	   }
 
    // Eðer kullanýcý adý db de varsa
	$SQLSOR = mysql_query("SELECT * FROM kullanicilar WHERE kul_adi ='".$kullanici."'");
    $SQLSAY = mysql_num_rows($SQLSOR);

	  if($SQLSAY == 1)
	   {
	   	header("location:../bilgiver.php?bilgi=uye_var"); 
		exit();
	   } 

	
    // Eðer girilen email db de varsa
	$SQLSOR2 = mysql_query("SELECT * FROM kullanicilar WHERE kul_email ='".$mail."'");
    $SQLSAY2 = mysql_num_rows($SQLSOR2);
	  
	  if($SQLSAY2 == 1)
	   {
	   	header("location:../bilgiver.php?bilgi=email_var"); 
		exit();
	   } 
   
	  unset($SQLSOR);
	  unset($SQLSOR2);
	  unset($SQLSAY);
	  unset($SQLSAY2);
	  unset($SQL);
	  unset($SQL2);
	   
    // Tüm süzgeçleri geride býraktýktan sonra üye kaydýný yapalým.
    $SQL = mysql_query("insert into kullanicilar set 
	   kul_adi           ='$kullanici',
	   kul_sifre_hash    ='$sifreHash',
	   kul_sifre         ='$sifre',
	   kul_ip            = '$ip',
	   kul_agent         = '$agent',
	   kul_yetki         ='0',
	    kul_group_id     ='2',
       kul_email         = '$mail',
	   kul_kayit_zamani  ='$kayit_tarihi'
	   ");	
    
	 $usttekiid = mysql_insert_id(); // yani yeni kullanýcýnýn id si
	 
   	 // Forumun en yeni üyesini ayarlara kaydedip. Üye sayýsýný  1 arttýrýyoruz.
	 $SQL2 = mysql_query("UPDATE ayar set 
       en_yeni_uye        = '$kullanici',
	   en_yeni_uye_id     = '$usttekiid' ,
	   toplam_uye_sayisi  =  toplam_uye_sayisi +1 
	   WHERE ayar_id = 1 ");


	   if ($SQL and $SQL2) 
	   	header("location:../bilgiver.php?bilgi=kayit_basarili"); 
	   else
	   	header("location:../bilgiver.php?bilgi=kayit_basarisiz"); 
     
	  unset($SQL);
	  unset($SQL2);	
	  

?>

