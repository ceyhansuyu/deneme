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
	
	$kat_sirala       = $_POST["kat_sirala"];//
	$forum_sirala     = $_POST["forum_sirala"];//
	$alt_sirala       = $_POST["alt_sirala"];//
	
  //print_r($kat_sirala);
	
	/// KATEGOR�LER�N SIRASINI G�NCELLEMEK ���N
		  foreach($kat_sirala as $key => $value)
		  {
				$key = temizle($key);
				$value = temizle($value);
		 
				$SQL1 = mysql_query("UPDATE kategoriler set 
							   sirala  ='$value'  
						WHERE   kat_id  =".$key."");
		  }// foreach
	

	
	/// FORUMLARIN SIRASINI G�NCELLEMEK ���N
		  foreach($forum_sirala as $key => $value)
		  {
				$key = temizle($key);
				$value = temizle($value);
		 
				$SQL2 = mysql_query("UPDATE forumlar set 
							   sirala  ='$value'  
						WHERE    forum_id   =".$key."");
		  }// foreach
	

	/// FORUMLARIN SIRASINI G�NCELLEMEK ���N
		  foreach($alt_sirala as $key => $value)
		  {
				$key = temizle($key);
				$value = temizle($value);
		 
				$SQL3 = mysql_query("UPDATE forumlar set 
							   sirala  ='$value'  
						WHERE    forum_id   =".$key."");
		  }// foreach
		  
	
	if($SQL1 == true and $SQL2 == true and $SQL3 == true)
	{
	   header("location:../index.php?do=forum_yonet");
	   exit();
	}
	else
	{
	  echo "ne yapt�n dostum Olmad�";
	}
///*/
?>