<?php
require_once("genel.php");
require_once("sistem/pagination.class.php");


//SAYFA DETAYLARI
    $baslik= "Online Kullanýcýlar";
	$sayfa_url ="online_kullanicilar.php";
	$menu = '<a href="index.php">Anasayfa</a> > <a href="online_kullanicilar.php">Online Kullanýcýlar</a>';
	// Kullanýcý koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,	
	));
//SAYFA DETAYLARI
require_once("baslik.php");


$time = time();
$zaman_asimi = $ayar["cevrimici_zaman_asimi"];
########## ONLÝNE KULLANICILAR ÇEKÝLÝYOR    


///////////////////////// SAYFALAMA BAÞLADI ///////////	
    //$kackayit = $ayar["sayfala_limit_konu"];
    $kackayit = $ayar["sayfala_limit_konu"];

	$sayfa = 1;
	
	if(isset($_GET['sayfa']) and is_numeric($_GET['sayfa']) and $sayfa = $_GET['sayfa'])
			$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
		else
			$limit = " LIMIT $kackayit";
	
    @$do = temizle($_GET["do"]);
    if(is_numeric($do)) $do ="";
	
	if($do =="")
	{
	   $SQLCEK = "SELECT * FROM kullanicilar 
					WHERE (kul_son_aktivite + $zaman_asimi) > $time AND  kul_gizli_mi ='0'";

	}
	else if($do =="misafir")
	{
	   $SQLCEK = "SELECT * FROM online_kullanicilar 
					WHERE (kul_giris  + $zaman_asimi) > $time";

	}
	else if($do =="gizli")
	{
	   $SQLCEK = "SELECT * FROM kullanicilar 
					WHERE (kul_son_aktivite + $zaman_asimi) > $time AND  kul_gizli_mi ='1'";
	}

	
	/// TOPLAM MÝSAFÝR VEYA NORMAL ONLÝNE VEYA GÝZLÝ ONLÝNE BUL
	
	$SQLCEK_ONLINE = "SELECT * FROM kullanicilar 
					WHERE (kul_son_aktivite + $zaman_asimi) > $time AND  kul_gizli_mi ='0'";
	
	$SQLCEK_MISAFIR = "SELECT * FROM online_kullanicilar 
					WHERE (kul_giris  + $zaman_asimi) > $time";
					
	$SQLCEK_GIZLI = "SELECT * FROM kullanicilar 
					WHERE (kul_son_aktivite + $zaman_asimi) > $time AND  kul_gizli_mi ='1'";
	
	// NORMAL ONLÝNE SAYISI
	$SQL_SAY1 = mysql_query($SQLCEK_ONLINE);
	$onlinesay = mysql_num_rows($SQL_SAY1);
	
	// NORMAL MÝSAFÝR SAYISI
	$SQL_SAY2 = mysql_query($SQLCEK_MISAFIR);
	$misafirsay = mysql_num_rows($SQL_SAY2);
	
	// NORMAL GÝZLÝ SAYISI
	$SQL_SAY3 = mysql_query($SQLCEK_GIZLI);
	$gizlisay = mysql_num_rows($SQL_SAY3);
	
	 $template->assign_vars(array( 
									'DO'       =>  $do,
									'MISAFIR'  =>  $misafirsay,
									'GIZLI'    => $gizlisay,
									'TOPLAM'    => $onlinesay + $gizlisay + $misafirsay,
								));


	
	$kayitSay = mysql_num_rows(mysql_query($SQLCEK));
	
	//echo $kayitSay;


	$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
	$SQL   = mysql_query($SQLCEK.$limit);
	
		
	        // SAYFALAMA PAREMETRELERÝ
			$p = new pagination;
			$p->Items($kayitSay);
			$p->limit($kackayit);
			$p->target("online_kullanicilar.php");
			$p->currentsayfa($sayfa);
			$p->calculate();
			$p->changeClass("pagination");
			//$p->show();
			
		if($kayitSay > $ayar["sayfala_limit_konu"])
	        {
			   $template->assign_vars(array( 'SAYFALAMA'  =>  $p->show() ));
			   $template->assign_vars(array( 'SAYFALAMA2'  =>  $p->show() ));
			}
			else
			{
			   $template->assign_vars(array( 'SAYFALAMA'  =>  "" ));
			}

	
	$n = 0;
	 while ( $row = mysql_fetch_array($SQL) )
	{///dýþ while
	
	//ONLÝNE KULLANICI SAYISI MÝSAFÝR DAHÝL
	$online_say =mysql_num_rows($SQL);
	
						
	if($online_say > 0)//Büyük if	
	{	

       $template->assign_vars(array( 'ONLINE_YOK'  =>  false ));
		$n ++;

		 // tire iþaretini temizleyelim.
		 $son_sayfa_baslik = str_replace("-"," ",$row["kul_son_sayfa_baslik"]);
		
		/// ONLÝNErow tema motoruna ekliyoruz
		$template-> assign_block_vars('onlinerow', array(
		'KULLANICI_SONSAYFA_URL'    => $row["kul_son_sayfa"],
		'KULLANICI_SONSAYFA_BASLIK' => $son_sayfa_baslik,
		'KULLANICI_IP'              => $row["kul_ip"],
		'KULLANICI_AGENT'           => $row["kul_agent"],
		'KULLANICI_ID'              => $row["kul_id"],
		'KULLANICI_ADI'             => $row["kul_adi"],
		'KULLANICI_GROUP_COLOR'     => kul_group_color($row["kul_id"]),
		'KULLANICI_AKTIVITE'        => tarih($row["kul_son_aktivite"],$ayar['sistem_zaman_dilimi']),
		
		
		));	
	} //Büyük if
	else
	{
		 $template->assign_vars(array( 
		 'ONLINE_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 ));
	}
	

}///dýþ while Son

    // Yani hiç cevapsýz konu yoksa
    if($n == 0)
    {
		 $template->assign_vars(array( 
		 'ONLINE_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 ));
    }




 mysql_free_result($SQL);
 unset($SQL);
///////////////////////// SAYFALAMA  BITTI  /////////////////////////////





$template->set_filenames(array('online_kullanicilar' => 'online_kullanicilar.html' ));

$template->display('online_kullanicilar');

require_once("footer.php");

?>