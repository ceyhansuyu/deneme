<?php
require_once("genel.php");
//SAYFA DETAYLARI
    $baslik= "Anket D�zenle";
	$sayfa_url ="anket_duzenle.php";
	$menu = '<a href="#">Anket D�zenle</a>';
	// Kullan�c� koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,	
	));
//SAYFA DETAYLARI
require_once("baslik.php");




$konu_id = t_id_temizle($_GET["t"]);
$anket_id = anket_id_temizle($_GET["anketid"]);

// �stenmeyen durumlara kar��n.
if ($_SESSION['kul'] =="misafir")
{
		header("location:index.php");
		exit();
}
// �stenmeyen durumlara kar��n. Son



$SQL = mysql_query("SELECT * FROM anket_option WHERE anket_id =".$anket_id."");
$row = mysql_fetch_array($SQL);

$secenekler = explode("|||",$row["anket_secenekleri"]);
 

// Anketin seceneklerini buluyoruz 
$n = 1;
  foreach($secenekler as $deger)
  {
	 /// anketrow tema motoruna ekliyoruz
	 $template-> assign_block_vars('anketrow', array(
		'SECENEK'            => $deger,
		'OPTIONS_ID'         => $n,
		));	
	$n ++;
  }
  
  
  
// Tema motoruna aktar�yoruz
$template->assign_vars(array(
	'ANKET_ID'           => $row["anket_id"],
	'ANKET_SORUSU'       => $row["anket_sorusu"],
	'ANKET_ZAMANI'       => $row["anket_zamani"],
	'ANKET_BITIS'        => gmdate('d.m.Y', $row["anket_bitis_suresi"] + $ayar["sistem_zaman_dilimi"]),
	'ANKET_OY_DEGIS'     => ($row["anket_oy_degistir"] =="oy_degistir")? 'checked="checked"':"",
	'ANKET_PUBLIC'       => $row["anket_public"],
	'HANGI_TOPIC'        => $konu_id ,
	'GMT'                => $ayar["sistem_zaman_dilimi"] ,
	
	));





$template->set_filenames(array('anket' => 'anket_duzenle.html' ));

$template->display('anket');

require_once("footer.php");

?>