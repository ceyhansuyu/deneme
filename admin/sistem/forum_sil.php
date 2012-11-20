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
	
	$kat_id           = @$_GET["katID"];//
	$forum_id         = @$_GET["forumID"];//
	$alt_id           = @$_GET["forumID"];//
	
  //print_r($kat_sirala);
	
	/// KATEGORÝ  SÝL
	if($kat_id !="")
	{   
	    // KATEGORÝLERÝ SÝL
		$SQL1 = mysql_query("DELETE FROM kategoriler  WHERE kat_id  =".$kat_id."");	
		
		//FORUMLARI SÝL
		$SQL2 = mysql_query("DELETE  FROM forumlar  WHERE  kat_id   =".$kat_id."");
		
		//KONULARI SÝL
		$SQL3 = mysql_query("DELETE  FROM konular  WHERE   konu_kat_id  =".$kat_id."");

		//MESAJLARI SÝL
		$SQL4 = mysql_query("DELETE  FROM mesajlar  WHERE  mesaj_kat_id =".$kat_id."");

		//ANKETLERÝ SÝL
		$SQL5 = mysql_query("DELETE FROM anket_option  WHERE anket_kat_id =".$kat_id."");

		//ANKET OYLARI SÝL
		$SQL6 = mysql_query("DELETE  FROM anket_oylar  WHERE  anket_kat_id =".$kat_id."");
	
	
			if($SQL1 == true and $SQL2 == true and $SQL3 == true and $SQL4 == true and $SQL5 == true and $SQL6 == true  )
			{
			   header("location:../index.php?do=forum_yonet");
			   exit();
			}
			else
			{
			  echo "ne yaptýn dostum Olmadý";
			}
	
	
	}// kategori sil son
	
	// Forumlarý sil
	else if($forum_id !="")
	{
	
		//FORUMLARI SÝL
		$SQL1 = mysql_query("DELETE  FROM forumlar  WHERE  forum_id =".$forum_id."");
		
		//KONULARI SÝL
		$SQL2 = mysql_query("DELETE  FROM konular  WHERE  konu_forum_id =".$forum_id."");

		//MESAJLARI SÝL
		$SQL3 = mysql_query("DELETE FROM mesajlar  WHERE  mesaj_forum_id =".$forum_id."");

		//ANKETLERÝ SÝL
		$SQL4 = mysql_query("DELETE  FROM anket_option  WHERE anket_forum_id =".$forum_id."");

		//ANKET OYLARI SÝL
		$SQL5 = mysql_query("DELETE  FROM anket_oylar  WHERE  anket_forum_id =".$forum_id."");
	
	
			if($SQL1 == true and $SQL2 == true and $SQL3 == true and $SQL4 == true and $SQL5 == true)
			{
			   header("location:../index.php?do=forum_yonet");
			   exit();
			}
			else
			{
			  echo "ne yaptýn dostum Olmadý";
			}
	
	}


	

	

///*/
?>