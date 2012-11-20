<?php
require_once("sistem/functions.php");
require_once("sistem/template.php");
require_once("sistem/ayar.php");
$template = new template;
$template->set_custom_template($ayar["TEMA_YOLU"].'/templates', 'default');



//Burayýda sayfanýn en sonuna koyun.
$saymayi_bitir = acilma_suresi(); $basla = $saymayi_bitir - $saymaya_basla; 
   $sayfa_hizi=  substr($basla, 0, 5);

// Tema motoruna aktarýyoruz
$template->assign_vars(array(
	'SAYFA_HIZI'   => $sayfa_hizi ,
	'COPYRIGHT'   => $ayar["copyright"] ,
));






$template->set_filenames(array('footer' => 'footer.html' ));

$template->display('footer');

?>