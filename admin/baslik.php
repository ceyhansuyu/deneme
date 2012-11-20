<?php
session_start();
require_once("sistem/functions.php");

require_once("language/tr.php");
require_once("../sistem/ayar.php");
require_once("../sistem/template.php");
$template = new template;
$template->set_custom_template('tema/admin/templates', 'default');





$ayar["TEMA_YOLU"] ="tema/admin";

$template->assign_vars(array(
	'TEMA_YOLU'     => $ayar["TEMA_YOLU"] ,
    'EMINMISIN_CIKMAK_ICIN'   => $lang["eminmisin_cikmak_icin"],
	
));




$template->set_filenames(array('baslik' => 'baslik.html' ));

$template->display('baslik');
?>