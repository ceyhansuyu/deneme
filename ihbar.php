<?php
require_once("genel.php");

//SAYFA DETAYLARI
    $baslik= "Mesaj �hbar";
	$sayfa_url ="ihbar.php";
	$menu = '<a href="index.php">Anasayfa</a> > �hbar';
	// Kullan�c� koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,	
	));
//SAYFA DETAYLARI
require_once("baslik.php");


$konuid = t_id_temizle_anadizinde($_GET['k']);
$mesaj_id = temizle($_GET['mesaj']);


// Forumda neler ol�yor
$template->assign_vars(array(
	'KONU_ID'     => $konuid ,
	'MESAJ_ID'    => $mesaj_id ,

));


$template->set_filenames(array('ihbar' => 'ihbar.html' ));

$template->display('ihbar');


require_once("footer.php");

?>