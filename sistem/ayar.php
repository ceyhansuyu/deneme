<?php

$host       = "localhost";
$host_kul   = "root";
$host_sifre = "";
$database   = "forum";


$bag = mysql_connect($host, $host_kul, $host_sifre) or die("Baðlantý Yok");
$baglanti = mysql_select_db($database, $bag) or die("Database'e baðlanamadýk");

// Site ayarlarýný çek
$SQL = mysql_query("SELECT * FROM ayar WHERE ayar_id=1");
$ayar = mysql_fetch_array($SQL);

///
$ayar["TEMA_YOLU"] ="tema/".$ayar["default_style"];
$sayfa_current = explode($ayar["script_yolu"],$_SERVER['REQUEST_URI']);

$ayar_site_adresi = "http://".$_SERVER['HTTP_HOST'].$ayar["script_yolu"];

@$sayfa_suan = $sayfa_current[1];
$ayar_rating_yolu = "resim/rating";

	// KULLANICI GROUP ÝZÝNLERÝNÝ ÇEKELÝM.
	if(@$_SESSION["kul"] != "misafir")
	{
	  $SQL2 = mysql_query("select * from kul_grup_izinler 
						  where  grup_id ='".@$_SESSION['kul_group_id']."'");
	  
	  $kul_izin = mysql_fetch_array($SQL2);
	}

?>