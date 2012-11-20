<?php
require_once("baslik.php");
require_once("sistem/functions.php");


	// KULLANICIN YETKİSİ YOKSA ANKET AÇMAYI ENGELLEYELİM
	if($kul_izin["anket_acma"] =="hayir")
	{
		header("location:bilgiver.php?bilgi=anket_acmaya_yetkiniz_yok");
		exit();
	
	}

$konu_id = t_id_temizle($_GET["t"]);
$secenek_sayisi = $_GET["option"];

//option temizle
if(empty($secenek_sayisi) or !is_numeric($secenek_sayisi) or ($secenek_sayisi >= $ayar["anket_sayisi"]))
{
 $secenek_sayisi= $ayar["anket_sayisi"];
}

$n = 1;
for ($sayac = 1; $sayac <= $secenek_sayisi ; $sayac++ )
{
   /// anketrow tema motoruna ekliyoruz
    $template-> assign_block_vars('anketrow', array(
	'OPTIONS'  => "",
	'OPTIONS_ID'  => $n,

	));
$n ++;
}






// Tema motoruna aktarıyoruz
$template->assign_vars(array(
	'SECENEK_SAYISI'   => $secenek_sayisi ,
	'HANGI_TOPIC'   => $konu_id ,
	'MAKS_ANKET_SAYISI'   => $ayar["anket_sayisi"] ,
	'KULLANICI'      => @$_SESSION['kul'],
					));





$template->set_filenames(array('anket' => 'anket_yap.html' ));

$template->display('anket');

require_once("footer.php");

?>