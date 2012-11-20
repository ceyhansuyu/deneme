<?php
session_start();
//echo @$_SESSION['kul'];
require_once("sistem/functions.php");
## Sayfa açýlma süresi ## 
$saymaya_basla = acilma_suresi();

require_once("language/tr.php");
require_once("sistem/ayar.php");
require_once("sistem/template.php");
$template = new template;
$template->set_custom_template($ayar["TEMA_YOLU"].'/templates', 'default');




?>