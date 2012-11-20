<?php
require_once("baslik.php");
require_once("sistem/functions.php");
// üye deðilse çýk
if ($_SESSION['kul_id'] =="00" or $_SESSION['kul'] =="misafir")
{
		header("location:bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}


$mesaj = $_GET['mesaj'];
$konuid = $_GET['k'];
$sayfa = $_GET['sayfa'];


     $SQL = mysql_query("SELECT * FROM mesajlar WHERE mesaj_id =".$mesaj."");
     $row = mysql_fetch_array($SQL);
	 
	 $SQL2 = mysql_query("SELECT * FROM konular WHERE  konu_id  =".$konuid."");
     $row2 = mysql_fetch_array($SQL2);

// Tema motoruna aktarýyoruz
$template->assign_vars(array(
	'MESAJ'           => stripslashes($row["mesaj_govde"]) ,
	'MESAJ_ID'        => $row["mesaj_id"] ,
	'MESAJ_YAZAR'     => $row["mesaj_author"] ,
	'MESAJ_YAZAR_ID'  => $row["mesaj_author_id"] ,
	'MESAJ_SAYFA'     => (@$_GET["sayfa"] =="")? "1":@temizle($_GET["sayfa"]),
	'MESAJ_BASLIK'    => $row["mesaj_baslik"] ,
	'HANGI_KONUYA'    => $konuid ,
	'HANGI_FORUMA'    => $row2["konu_forum_id"] ,
	'IKON'            => $row2["konu_ikonu"] ,
	
	));


include("similies.php");




$template->set_filenames(array('quote' => 'quote.html' ));

$template->display('quote');

require_once("footer.php");

?>