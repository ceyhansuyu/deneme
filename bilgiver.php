<?php
require_once("genel.php");
$bilgi = $_GET["bilgi"];

//SAYFA DETAYLARI
    $baslik= "Anasayfa";
	$sayfa_url ="bilgiver.php?bilgi=".$bilgi."";
	$menu = '<a href="index.php">Anasayfa</a> > <a href="bilgiver.php?bilgi='.$bilgi.'">Bilgi</a>';
	// Kullanýcý koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,	
	));
//SAYFA DETAYLARI
require_once("baslik.php");

/////////////////////////////	
if($bilgi =="arama_flood")
{
  $bilg = "Ýki arama arasýndaki süre <strong>".$ayar["arama_flood_aralik"]." saniye</strong>  kadardýr. Lütfen bekleyiniz";

  $template->assign_vars(array(
	'BILGI'         => $bilg,
	));

}
else
{
   /// Hata.html tema motoruna ekliyoruz
    $template->assign_vars(array(
	'BILGI'  => $lang["$bilgi"],
	));
}




$template->set_filenames(array('bilgiver' => 'bilgiver.html' ));

$template->display('bilgiver');

require_once("footer.php");

?>