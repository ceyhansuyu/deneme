<?php
require_once("genel.php");



// �stenmeyen durumlara kar��n.
if ($_SESSION['kul'] !="misafir")
{
		header("location:index.php");
		exit();
}
// �stenmeyen durumlara kar��n. Son


	//SAYFA DETAYLARI
	  $menu = '<a href="index.php">Anasayfa</a> > 
            <a href="kayit.php"> Kay�t Ol</a>';
	
	  
	$baslik= " - Kay�t Ol";
	$sayfa_url = "kayit.php";
	// Kullan�c� koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullan�c� koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'                              => $menu,	
			'EKSTRA_SPAM_SORUSU_AKTIF'  => ($ayar["ekstra_spam_sorusu"] =="acik")? true:false,	
			'EKSTRA_SPAM_SORUSU'  => $ayar["kayit_sorusu"] ,	
			'EKSTRA_SPAM_CEVABI'  => $ayar["kayit_cevabi"] ,	
		));
    //SAYFA DETAYLARI
	require_once("baslik.php");


 /// RECAPTHA AKT�F �SE
    if($ayar["reCAPTCHA_aktif_mi"] =="acik")
    {
	    require_once('sistem/reCAPTCHAlib.php');
        $publickey = $ayar["reCAPTCHA_publickey"]; // you got this from the signup page
        $template->assign_vars(array('CAPTCHA' => recaptcha_get_html($publickey), ));
    }
           

	

// S�zle�meyi �ekip temaya aktaral�m
$template->assign_vars(array(
	'SOZLESME'           => $ayar["uyelik_sozlesmesi"], 
	'RECAPTHA_AKTIF'     => ($ayar["reCAPTCHA_aktif_mi"] =="acik")? true:false, 
));

$template->set_filenames(array('kayit' => 'kayit.html' ));

$template->display('kayit');

require_once("footer.php");

?>