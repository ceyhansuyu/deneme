<?php
########## login.php #############
require_once("genel.php");


// �stenmeyen durumlara kar��n. hack vb.
if ($_SESSION['kul'] !="misafir")
{
		header("location:index.php");
		exit();
}
// �stenmeyen durumlara kar��n. Son

	//SAYFA DETAYLARI
	  $menu = '<a href="index.php">Anasayfa</a> > 
            <a href="login.php"> Giri� Yap�n�z</a>';
	
	  
	$baslik= " - Giri� Yap�n�z";
	$sayfa_url = "login.php";
	// Kullan�c� koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullan�c� koordinat
			
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