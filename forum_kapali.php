<?php
require_once("genel.php");
//SAYFA DETAYLARI
    $baslik= "Forum Kapalýdýr.";
	
	//SEO VARSA
	if($ayar["seo_durum"] =="acik")
	  $sayfa_url ="index.html";
	else
	  $sayfa_url ="index.php";
	
	//SEO VARSA
	if($ayar["seo_durum"] =="acik")
	  $menu = '<a href="forum_kapali.html">Forum Kapalý</a>';
	else
	  $menu = '<a href="forum_kapali.php">Forum Kapalý</a>';

	
	// Kullanýcý koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'                 => $baslik,
		'MENU'                   => $menu,
        'SEO_AKTIFSE'            => ($ayar["seo_durum"] =="acik") ? true:false,
        'FORUM_KAPALI_SEBEP'     => $ayar["forum_kapali_sebep"] ,
		
	));
//SAYFA DETAYLARI

require_once("baslik.php");



	


$template->set_filenames(array('forum_kapali' => 'forum_kapali.html' ));

$template->display('forum_kapali');

require_once("footer.php");

?>