<?php
session_start();
require_once("sistem/functions.php");

require_once("language/tr.php");
require_once("../sistem/ayar.php");
require_once("../sistem/template.php");
$template = new template;
$template->set_custom_template('tema/admin/templates', 'default');



// Kontroller

	if(@$_SESSION["kul_admin_yetki"] =="admin")
	{
	   header("location:index.php");
	   exit();
	}




$ayar["TEMA_YOLU"] ="tema/admin";
$template->assign_vars(array(
	'TEMA_YOLU'     => $ayar["TEMA_YOLU"] ,
));


$template->set_filenames(array('login' => 'login.html' ));

$template->display('login');

?>