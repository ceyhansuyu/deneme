<?php
require_once("baslik.php");
require_once("sistem/functions.php");

$fid = f_id_temizle($_GET['f']);


if ($_SESSION['kul'] =="misafir")
{
		header("location:bilgiver.php?bilgi=yetkiniz_yok");
		exit();
}


// KÝLÝTLÝ FORUMA KONU AÇMAYI ENGELLEYELÝM
	$SQL = mysql_query("select * from forumlar where forum_id=".$fid."");
	$row = mysql_fetch_array($SQL);
	
	if($row["forum_kilitlimi"] =="evet" and $kul_izin["forum_kilitli_konu_acma"] =="hayir")
	{
		header("location:bilgiver.php?bilgi=kilitli_foruma_konu_yetki_yok");
		exit();
	
	}
	
	//echo $_SESSION['kul_group_id'];


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
	  
		  /// TEma motoruna bilgileri atalim
		  $template->assign_block_vars('konu_ikon',array(
		  'FILE'  => $file,
		  'IMG_SRC' => $klasor."/".$file,

		  ));  
      }// if bitti

}/// while bitti

/// Konu ikonlarini yapalim // Son


include("similies.php");

	



// Tema motoruna aktarýyoruz
$template->assign_vars(array(
	'HANGI_FORUMA'   => $fid ,
	'ANKET_IZIN'     => ($kul_izin["anket_acma"] =="evet")? true:false ,
	'MAKS_ANKET_SAYISI'   => $ayar["anket_sayisi"] ,
	'KULLANICI'      => @$_SESSION['kul'],
					));






$template->set_filenames(array('newthread' => 'newthread.html' ));

$template->display('newthread');

require_once("footer.php");

?>