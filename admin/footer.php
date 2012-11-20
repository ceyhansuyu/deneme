<?php
require_once("sistem/functions.php");
require_once("../sistem/template.php");
require_once("../sistem/ayar.php");
$template = new template;
$template->set_custom_template('tema/admin/templates', 'default');




// Tema motoruna aktarýyoruz
$template->assign_vars(array(
	'COPYRIGHT'   => $ayar["copyright"] ,
));






$template->set_filenames(array('footer' => 'footer.html' ));

$template->display('footer');

?>