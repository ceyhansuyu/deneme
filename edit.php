<?php
require_once("baslik.php");
require_once("sistem/functions.php");
// üye deðilse çýk
if ($_SESSION['kul'] =="misafir")
{
		header("location:bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}


$mesaj = $_GET['mesaj'];
$konuid = $_GET['k'];


     $SQL = mysql_query("SELECT * FROM mesajlar WHERE mesaj_id =".$mesaj."");
     $row = mysql_fetch_array($SQL);
	 
	 $SQL2 = mysql_query("SELECT * FROM konular WHERE konu_id =".$konuid."");
     $row2 = mysql_fetch_array($SQL2);

// Tema motoruna aktarýyoruz
$template->assign_vars(array(
	'MESAJ'             => $row["mesaj_govde"] ,
	'MESAJ_ID'          => $mesaj ,
	'MESAJ_YAZAR'       => $row["mesaj_author"] ,
	'MESAJ_YAZAR_ID'    => $row["mesaj_author_id"] ,
	'MESAJ_BASLIK'      => $row["mesaj_baslik"] ,
	'MESAJ_DURUM'       => $row["mesaj_durum"] ,
	'NORMALSE'          => ($row2["konu_mod"] =="normal") ? true : false ,
	'SABITSE'           => ($row2["konu_mod"] =="sabit") ? true : false ,
	'DUYURU_ISE'        => ($row2["konu_mod"] =="duyuru") ? true : false ,
	'GLOBAL_ISE'        => ($row2["konu_mod"] =="global") ? true : false ,
	'KONU_MESAJI'       => ($row["mesaj_durum"] =="konu") ? true : false ,
	'MESAJ_EDIT_SEBEP'  => $row["mesaj_edit_sebep"] ,
	'MESAJ_EDIT_YOK'    => empty($row["mesaj_edit_sebep"]) ? true : false ,
	'MESAJ_EDIT_ZAMAN'  => $row["mesaj_edit_zaman"] ,
	'MESAJ_EDIT_KIM'    => $row["mesaj_edit_kim"] ,
	'MESAJ_EDIT_KIM_ID' => $row["mesaj_edit_kim_id"] ,
	'MESAJ_BASLIK'      => $row["mesaj_baslik"] ,
	'MESAJ_IKON'        => $row["mesaj_ikonu"] ,
	'HANGI_FORUMA'      => $konuid ,
	
	));

	
	
/// Konu ikonlarini yapalim // Basla
$klasor = "resim/icons";
$handle= opendir($klasor);
while ($file = readdir($handle)) 
  {
     $filelist[] = $file;
  }
  asort($filelist);
    while (list ($a, $file) = each ($filelist)) 
	{
      if($file=="Thumbs.db" or $file=="."  or $file==".." or $file=="index.html" )// eger dosya içinde resimden baska seyler varsa onlari isleme almayalim.
      {
        echo "";
      }
	  else
	  {
	  
	 
	  if($row["mesaj_ikonu"])
	  
		  /// TEma motoruna bilgileri atalim
		  $template->assign_block_vars('konu_ikon',array(
		  'FILE'  => $file,
		  'IMG_SRC' => $klasor."/".$file,
		  
		  // EÐER MESAJ VEYA KONU ÝKONU DATABASEDEKÝ ÝLE AYNI ÝSE CHECHKED YAP
		  'CHECHED' => ($row["mesaj_ikonu"] == $klasor."/".$file)? 'checked="checked"':'',
		  ));  
      }// if bitti

}/// while bitti

/// Konu ikonlarini yapalim // Son


include("similies.php");



$template->set_filenames(array('edit' => 'edit.html' ));

$template->display('edit');

require_once("footer.php");

?>