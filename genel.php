<?php
session_start();
//echo @$_SESSION['kul'];
require_once("sistem/functions.php");
## Sayfa a��lma s�resi ## 
$saymaya_basla = acilma_suresi();

require_once("language/tr.php");
require_once("sistem/ayar.php");
require_once("sistem/template.php");
$template = new template;
$template->set_custom_template($ayar["TEMA_YOLU"].'/templates', 'default');




?>