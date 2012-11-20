<?php
require_once("baslik.php");
$bilgi = $_GET["bilgi"];


/////////////////////////////	
if($bilgi =="arama_flood")
{
  $bilg = "İki arama arasındaki süre <strong>".$ayar["arama_flood_aralik"]." saniye</strong>  kadardır. Lütfen bekleyiniz";

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