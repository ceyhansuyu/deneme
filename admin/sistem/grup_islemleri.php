<?php
session_start();
require_once("../../sistem/ayar.php");
require_once("functions.php");
require_once("../language/tr.php");

	if ($_SESSION['kul_admin_yetki'] !="admin")
	{
	   header("location:cikis.php");
	   exit();
	}
	
	$grup_islemi       = @temizle($_POST["grup_islemi"]);//
	$grup_adi          = @temizle($_POST["grup_adi"]);//
	$grup_desc         = @temizle($_POST["grup_desc"]);//
	$grup_rutbe_ismi   = @temizle($_POST["grup_rutbe_ismi"]);
	$grup_rutbe_resim  = @temizle($_POST["grup_rutbe_resim"]);
	$grup_renk         = @temizle($_POST["grup_renk"]);
	$get_islem         = @temizle($_GET["islem"]);
	$get_grupID        = @temizle($_GET["grupID"]);
	$form_grupID       = @temizle($_POST["grup_id"]);
	         
	//echo $form_grupID ;

	
	
	
	// E�ER GRUP ��LEM� YEN� GRUP EKLE �SE
	if( $get_islem =="sil")
	{
	
	   //E�ER S�L�NMES� �STEN�LEN GROUP �DS� ADM�N =1 NORMAL KUL = 2 �SE UYAR
	   	if( $get_grupID =="1" or $get_grupID =="2")
			{
			   header("location:../bilgiver.php?bilgi=admin_normal_kul_grup_silinmez");
			   exit();
			}
	
	   $SQL = mysql_query("DELETE FROM kul_gruplari WHERE grup_id ='".$get_grupID."'  ");
	   
	   //GRUBA A�T �Z�NLER VARSA O �Z�NLER� S�LEL�M
	   $SQL2 = mysql_query("DELETE FROM kul_grup_izinler WHERE grup_id ='".$get_grupID."'  ");
	   
	   
	   //GRUBA A�T KULLANICILARI NORMAL KULLANICIYA id=2 ye ATALIM
	   $SQL3 = mysql_query("UPDATE  kullanicilar SET 
							kul_group_id ='2'
							WHERE kul_group_id ='".$get_grupID."' ");
							
		if($SQL == false or $SQL2 == false or $SQL3 == false)
		{
		  echo "get i�lem sil update hatas�";
		  exit();
		}
	
	}//$get_islem =="sil" sonu

	
	// E�ER GRUP ��LEM� GRUP D�ZENLE �SE
	if( $grup_islemi =="grup_guncelle")
	{
	
			if(  $grup_adi =="" or $grup_desc =="" 
				or $grup_rutbe_ismi =="" or $grup_rutbe_resim =="" or $grup_renk =="")
			{
			   header("location:../bilgiver.php?bilgi=grup_duzenle_eksiklik");
			   exit();
			}
	
	   $SQL = mysql_query("UPDATE  kul_gruplari SET
						  group_name        = '$grup_adi',
						  group_desc        = '$grup_desc',
						  group_rutbesi     = '$grup_rutbe_ismi',
						  group_rutbe_resmi = '$grup_rutbe_resim',
						  group_color       = '$grup_renk'
					WHERE  grup_id ='".$form_grupID."'");
	
	}// grup D�ZENLEME if sonu
	
	
	
	
	
	
	
	// E�ER GRUP ��LEM� YEN� GRUP EKLE �SE
	if( $grup_islemi =="yeni_grup_ekle")
	{
	
			if( $grup_islemi =="" or $grup_adi =="" or $grup_desc =="" 
				or $grup_rutbe_ismi =="" or $grup_rutbe_resim =="" or $grup_renk =="")
			{
			   header("location:../bilgiver.php?bilgi=grup_eklemede_esksiklik");
			   exit();
			}
	
	   $SQL = mysql_query("INSERT INTO kul_gruplari SET
						  group_name        = '$grup_adi',
						  group_desc        = '$grup_desc',
						  group_rutbesi     = '$grup_rutbe_ismi',
						  group_rutbe_resmi = '$grup_rutbe_resim',
						  group_color       = '#$grup_renk'
					 ");
	
	}//yeni grup ekleme if sonu
	


	
	if($SQL == true)
	{
	   header("location:../index.php?do=gruplar");
	   exit();
	}
	else
	{
	  echo "ne yapt�n dostum Olmad�";
	}
///*/
?>