<?php
require_once("ayar.php");
require_once("functions.php");
require_once("../language/tr.php");

// �stenmeyen durumlara kar��n.
if ($_SESSION['kul_id'] =="00" or $_SESSION['kul'] =="misafir")
{
		header("location:../bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}

/*
if ($kul_izin['forum_silme'] =="hayir")
{
		header("location:../bilgiver.php?bilgi=abonelik_icin_yetkiniz_yok");
		exit();
}

// �stenmeyen durumlara kar��n. Son
*/



	$forumID      = @$_GET['forumID'];
    $konuID       = @$_GET['konuID'];
    $kulID        = temizle($_SESSION['kul_id']);
    $do           = temizle($_GET['do']);
	$time         = time();

	
   // DO ABONEL�K EKLE VE KONUID BO�SA FORUMID DOLUYSA
   if  ($do =="abonelik_ekle" and $forumID !="" and $konuID =="")
	{

	   $forumID  = @f_id_temizle($_GET['forumID']);
	
	   //�NCE DAHA �NCEDEN ABONEL�K EKLENM�� M� BAKALIM
       $SQLsay = mysql_query("select  * from abonelikler 
							where forumID ='".$forumID."' and
							  kullaniciID ='".$kulID."'");
	   $say = mysql_num_rows($SQLsay);
	   
	   if($say == 0)
	   {
	          $SQL = mysql_query("insert into abonelikler set
							konuID             ='',
							forumID            ='$forumID',
							kullaniciID        ='$kulID',
							abone_olunan_tarih ='$time'
						");
						
	   }
	   else
	   {
		  header("location:../bilgiver.php?bilgi=foruma_daha_once_abone_olmussunuz");
		  exit();
	   }

	}// DO ABONEL�K EKLE VE KONUID BO�SA FORUMID DOLUYSA B�TT�
	
	
	// DO ABONEL�K EKLE VE KONUID DOLUYSA FORUMID BO�SA
	else if($do =="abonelik_ekle" and $forumID =="" and $konuID !="")
	{
	   
	
	    $konuID  = @t_id_temizle($_GET['konuID']);
	
	   //�NCE DAHA �NCEDEN ABONEL�K EKLENM�� M� BAKALIM
       $SQLsay = mysql_query("select * from abonelikler 
							where konuID ='".$konuID."' and
							  kullaniciID ='".$kulID."'");
	   $sayabone = mysql_num_rows($SQLsay);
	   
	   //��MD�DE KULLANICININ ABONE OLDU�U FORUM VARSA VE KONU ���NDEYSE ABONE
	   // YAPMAYALIM
	   $SQLkonu = mysql_query("select * from konular where konu_id='".$konuID."'");
	   
       $abonebul = mysql_fetch_array($SQLkonu);
	   
	   $sql_konuya_ait_forum = mysql_query("select * from abonelikler 
                                         where forumID ='".$abonebul["konu_forum_id"]."' and
							                  kullaniciID ='".$kulID."'");
											  
		$sql_konuya_ait_forum_varmi = mysql_num_rows($sql_konuya_ait_forum);
		
	   
	   if($sayabone == 0 and $sql_konuya_ait_forum_varmi == 0)
	   {
	     
	          $SQL = mysql_query("insert into abonelikler set
							konuID             ='$konuID',
							forumID            ='',
							kullaniciID        ='$kulID',
							abone_olunan_tarih ='$time'
						");
	   }
	   else if($sayabone != 0 or $sql_konuya_ait_forum_varmi != 0)
	   {
		  header("location:../bilgiver.php?bilgi=foruma_daha_once_abone_olmussunuz");
		  exit();
	   }
	
	
	}// DO ABONEL�K EKLE VE KONUID DOLUYSA FORUMID BO�SA B�TT�


	
	
// DO ABONEL�K S�L VE KONUID BO�SA FORUMID DOLUYSA
	 if($do =="abonelik_sil" and $forumID !="" and $konuID =="")
	{
        $forumID  = @f_id_temizle($_GET['forumID']);	

	 
	          $SQL = mysql_query("DELETE FROM abonelikler WHERE
							forumID       ='".$forumID."' AND
							kullaniciID   ='".$kulID."'");
			
			if ($SQL) 
	          {
		        header("location:../forumdisplay.php?f=".$forumID."");
				exit();
	          }
	 
	}// DO ABONEL�K S�L VE KONUID BO�SA FORUMID DOLUYSA B�TT�
	
	// DO ABONEL�K S�L VE KONUID BO�SA FORUMID DOLUYSA
	 else if($do =="abonelik_sil" and $forumID =="" and $konuID !="")
	{
	    $konuID  = @t_id_temizle($_GET['konuID']);

	          $SQL = mysql_query("DELETE FROM abonelikler WHERE
							konuID       ='".$konuID."' AND
							kullaniciID   ='".$kulID."'");
							
			  if ($SQL) 
	          {
		        header("location:../showthread.php?t=".$konuID."");
				exit();
	          }
	 
	}// DO ABONEL�K EKLE VE KONUID DOLUYSA FORUMID BO�SA B�TT�
	
	
	
	
	

	 
	   if ($SQL) 
	   {
	     //echo "oldu";
		 header("location:../profil_duzenle.php?do=abonelik");
	   }
	   else
	   {
	     echo "hata var";	   
	   }

	              

?>