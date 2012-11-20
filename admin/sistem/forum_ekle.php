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
	
	$do = $_GET["do"];
	
	if($do =="kategori_ekle")
	{
			$kat_title      = temizle($_POST["kat_title"]);
			$kat_desc       = temizle($_POST["kat_desc"]);	
	}
	else if($do =="forum_ekle")
	{
			$kategori_id    = temizle($_POST["kategori_id"]);
			$forum_adi       = temizle($_POST["forum_adi"]);
			$forum_desc      = temizle($_POST["forum_desc"]);
			$forum_resmi     = temizle($_POST["forum_resmi"]);
			$forum_id  ="";
			
		  $bul = @preg_match('/ve/', $kategori_id);
	
			if($bul == true)
			{
			  $sonuc = explode("ve",$kategori_id);
			  $kategori_id = $sonuc[0];
			  $forum_id = $sonuc[1];
	
			}
			else
			{
			 $kategori_id  = $kategori_id ;
			}

	}
   else if($do =="forum_ekle_link")
	{
			$kat_id              = temizle($_POST["kat_id"]);
			$forum_adi_link      = temizle($_POST["forum_adi_link"]);
			$forum_desc_link     = temizle($_POST["forum_desc_link"]);
			$forum_link_url      = temizle($_POST["forum_link_url"]);
			$forum_resmi_link    = temizle($_POST["forum_resmi_link"]);
	
	}

		
	
	
	/// Gerekli Bilgiler eklenyior
	
	if($do =="kategori_ekle")
	{
	    $SQL = mysql_query("insert into kategoriler set
		                    kat_title ='$kat_title',
		                    kat_desc  ='$kat_desc'
							");
	}
	else if($do =="forum_ekle")
	{
	    
		if($forum_id =="")
		{
		   $SQL = mysql_query("insert into forumlar set
		                     kat_id       ='$kategori_id',
		                     forum_link_mi ='hayir',
		                     forum_adi    ='$forum_adi',
		                     forum_tarifi ='$forum_desc',
		                     forum_resmi  ='$forum_resmi'
							");		
		}
		// Yani alt forum oluþturulacaksa
		else if($forum_id !="")
		{
		   $SQL = mysql_query("insert into forumlar set
		                     kat_id       ='$kategori_id',
		                     forum_tipi     ='alt',
		                     forum_ust_f    ='$forum_id',
		                     forum_link_mi ='hayir',
		                     forum_adi    ='$forum_adi',
		                     forum_tarifi ='$forum_desc',
		                     forum_resmi  ='$forum_resmi'
							");	
		
		}

	
	
	}
   else if($do =="forum_ekle_link")
	{
	
	    $SQL = mysql_query("insert into forumlar set
		                     kat_id              ='$kat_id',
		                     forum_link_mi       ='evet',
		                     forum_link_adi      ='$forum_adi_link',
		                     forum_link_aciklama ='$forum_desc_link',
		                     forum_link_url      ='$forum_link_url',
		                     forum_resmi         ='$forum_resmi_link'
							");
	

	
	}
	
	
	
		  
	
	if($SQL == true)
	{
	   header("location:../index.php?do=forum_yonet");
	   exit();
	}
	else
	{
	  echo "ne yaptýn dostum Olmadý";
	}
///*/
?>