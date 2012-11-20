<?php
########## login.php #############
require_once("genel.php");


// Ýstenmeyen durumlara karþýn. hack vb.
if ($_SESSION['kul'] !="misafir")
{
		header("location:index.php");
		exit();
}
// Ýstenmeyen durumlara karþýn. Son

	//SAYFA DETAYLARI
	  $menu = '<a href="index.php">Anasayfa</a> > 
            <a href="login.php"> Giriþ Yapýnýz</a>';
	
	  
	$baslik= " - Giriþ Yapýnýz";
	$sayfa_url = "login.php";
	// Kullanýcý koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullanýcý koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,	
		));
    //SAYFA DETAYLARI
	require_once("baslik.php");




$template->set_filenames(array('login' => 'login.html' ));

$template->display('login');

require_once("footer.php");

?>