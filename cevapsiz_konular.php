<?php
require_once("genel.php");
require_once("sistem/pagination.class.php");


//SAYFA DETAYLARI
    $baslik= "Cevapsýz Konular";
	$sayfa_url ="cevapsiz_konular.php";
	$menu = '<a href="index.php">Anasayfa</a> > 
	<a href="cevapsiz_konular.php">Cevaplanmamýþ Konular</a>';
	
	// Kullanýcý koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,	
	));
//SAYFA DETAYLARI
require_once("baslik.php");


///////////////////////// SAYFALAMA BAÞLADI ///////////	
    //$kackayit = $ayar["sayfala_limit_konu"];
    $kackayit = $ayar["sayfala_limit_konu"];

	$sayfa = 1;
	
	if(isset($_GET['sayfa']) and is_numeric($_GET['sayfa']) and $sayfa = $_GET['sayfa'])
			$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
		else
			$limit = " LIMIT $kackayit";
	
	$SQLCEK = "SELECT * FROM konular WHERE  konu_cevap_sayisi = 0 order by  son_mesaj_zamani desc";
	$kayitSay = mysql_num_rows(mysql_query($SQLCEK));

	$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
	$SQL   = mysql_query($SQLCEK.$limit);
	
		
	        // SAYFALAMA PAREMETRELERÝ
			$p = new pagination;
			$p->Items($kayitSay);
			$p->limit($kackayit);
			$p->target("cevapsiz_konular.php");
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
	
	//EÐER KONUYA AÝT MESAJ SAYISI 1 E EÞÝT ÝSE ARADIÐIMIZI BULDUK
	$konu_say =mysql_num_rows($SQL);
	
	//HANGÝ FORUMA AÝT OLDUGUNU BULALIM
	 $SQL3 = mysql_query("SELECT * FROM forumlar  
						WHERE  forum_id  ='".$row["konu_forum_id"]."'");
	$forum =mysql_fetch_array($SQL3);
						
	if($konu_say > 0)//Büyük if	
	{	

	
	
       $template->assign_vars(array( 'KONU_YOK'  =>  false ));
		$n ++;
		###### FORUMDISPLAY.PHP DE SON MESAJ SAYFASINI BULALIM ####
		$tablosayfala = 'mesajlar';
		$WHERE_mesajforumid = $row["konu_id"];
		$limitsayfala = $ayar["sayfala_limit_cevap"];
		//sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala);
		
		
		###############   FORUM OKUNDUMU OKUNMADIMI  ############### 
			$son_mesaj_time =  $row["son_mesaj_zamani"];
			$konunun_idsi   =  $row["konu_id"];
			$konu_cevab_say =  $row["konu_cevap_sayisi"];
			$konu_kimin     =  $row["konu_author"];
			$konu_durum     =  $row["konu_durum"];
			
			$resim = okundumu($son_mesaj_time, $konunun_idsi, $konu_cevab_say, $konu_kimin ,$konu_durum);
			
			//Eðer okunmadýysa konuyu kalýn harfle yazdýr
			$bul= @preg_match('/_new/', $resim );
			if($bul)
			{
				$konu_basligi = "<strong>".$row["konu_baslik"]."</strong>";
			}
			else
			{
				$konu_basligi = $row["konu_baslik"];
			}
			
		

		//konu ratingini hemen temaya yollayalým
			$rating_deger = rating_konu($row["konu_id"]);
			$rating_resim= $ayar_rating_yolu."/".$rating_deger.".png";

		/// konurow tema motoruna ekliyoruz
		$template-> assign_block_vars('konurow', array(
		'KONU_ID'             => $row["konu_id"],
		'KONU_BASLIK'         => $konu_basligi,
		'KONU_YAZAR'          => $row["konu_author"],
		'KONU_YAZAR_ID'       => $row["konu_author_id"],
		'KONU_YAZAR_RENK'     => kul_group_color($row["konu_author_id"]),
		'KONU_OKUNMA'         => $row["konu_goruntulenme"],
		'KONU_IKONU'          => $row["konu_ikonu"],
		'KONU_TARIHI'         => forum_tarihi($row["konu_zamani"],$ayar['sistem_zaman_dilimi']),
		'KONU_CVP_SAYISI'  	  => $row["konu_cevap_sayisi"] , //
		'SON_MESAJ_ID'  	  => $row["son_mesaj_id"],
		'SON_MESAJ_ZAMANI'    => forum_tarihi($row["son_mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
		'SON_MESAJ_YAZAR_ID'  => $row["son_mesaj_yazar_id"],
		'SON_MESAJ_YAZAR'     => $row["son_mesaj_yazar"],
		'SON_MESAJ_YAZAR_RENK'  => kul_group_color($row["son_mesaj_yazar_id"]),
		'SON_MESAJ_SAYFASAY'  => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),
		//'UFAK_SAYFALAMA'      => sayfala_ufak($tablo2,$orderby2 , $link2, $limit ,$s_s,  $gelen_sayfa ,$mesajforumid),
		'KONU_RESIM'          => @$resim,
		'KONU_RATING'         => $rating_resim,
		'KONU_RATING_DEGER'  => $rating_deger,
		'KONU_FORUM'         => $forum["forum_adi"],
		'KONU_FORUM_ID'      => $forum["forum_id"],
		));	
	} //Büyük if
	else
	{
		 $template->assign_vars(array( 
		 'KONU_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 ));
	}
	

}///dýþ while Son

    // Yani hiç cevapsýz konu yoksa
    if($n == 0)
    {
		 $template->assign_vars(array( 
		 'KONU_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 ));
    }




 mysql_free_result($SQL);
 unset($SQL);
///////////////////////// SAYFALAMA  BITTI  /////////////////////////////






$template->set_filenames(array('cevapsiz_konular' => 'cevapsiz_konular.html' ));

$template->display('cevapsiz_konular');

require_once("footer.php");

?>