<?php
require_once("genel.php");


	if($ayar["seo_durum"] =="acik")
	{
     
	  $katid = explode($ayar["script_yolu"],$_SERVER['REQUEST_URI']);
	  $katidbul = explode("-",$katid[1]);
	  $katidsi = explode("f",$katidbul[0]);
	  $fid =  $katidsi[1];
	  //echo $fid;
	  
	  	  
	  $sql = mysql_query("select * from forumlar where forum_id='".$fid."'");
	  $konuS = mysql_fetch_array($sql);
	  $konuURL ="f".$fid."-".seo($konuS["forum_adi"])."-";
	  $sayfasi = explode($konuURL,$_SERVER['REQUEST_URI']);
	  $sayfasiSON = explode(".html",@$sayfasi[1]);
	  $_GET["sayfa"] = $sayfasiSON[0];
	}
	else
	{
	  $fid = f_id_temizle($_GET['f']);
	}



$sort  = @temizle($_GET['sort']);
$order  = @temizle($_GET['order']);

	//SAYFA DETAYLARI
	$SQL = mysql_query("SELECT f.forum_id, f.kat_id, f.forum_tipi , f.forum_ust_f, 
			f.forum_ust_title, f.forum_adi,
			k.kat_id, k.kat_title
			FROM forumlar f, kategoriler k
			WHERE f.kat_id = k.kat_id 
			and f.forum_id =".$fid."
			");
			
    $row = mysql_fetch_array($SQL);
	
 
	if($row["forum_tipi"] =="alt")
      {
	   if($ayar["seo_durum"] =="acik")
	    $menu = '<a href="index.html">Anasayfa</a> > 
           <a href="k'.$row["kat_id"].'-'.seo($row["kat_title"]).'.html">'.$row["kat_title"].'</a> >
           <a href="f'.$row["forum_ust_f"].'-'.seo($row["forum_ust_title"]).'.html">'.$row["forum_ust_title"].'</a> > '.$row["forum_adi"].' ';
	   else
	   	    $menu = '<a href="index.php">Anasayfa</a> > 
           <a href="kategoridisplay.php?k='.$row["kat_id"].'">'.$row["kat_title"].'</a> >
           <a href="forumdisplay.php?f='.$row["forum_ust_f"].'">'.$row["forum_ust_title"].'</a> > '.$row["forum_adi"].' ';
	   
	  }	
	  else
	  {
	   if($ayar["seo_durum"] =="acik")
	  	$menu = '<a href="index.html">Anasayfa</a> > 
            <a href="k'.$row["kat_id"].'-'.seo($row["kat_title"]).'.html">'.$row["kat_title"].'</a> >
            '.$row["forum_adi"].' ';
		else
		
		$menu = '<a href="index.php">Anasayfa</a> > 
            <a href="kategoridisplay.php?k='.$row["kat_id"].'">'.$row["kat_title"].'</a> >
            '.$row["forum_adi"].' ';
			
			
	  }
	  
	$baslik= " - ".$row["forum_adi"];
	$sayfa_url = "forumdisplay.php?f=".$fid;
	// Kullanýcý koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullanýcý koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,
            'S_ADMIN'       => (@$_SESSION['kul_yetki'] == "admin") ? true:false,// adminse			
            'SEO_AKTIFSE'       => ($ayar["seo_durum"] =="acik") ? true:false,
		));
		unset($SQL);
    //SAYFA DETAYLARI
	require_once("baslik.php");
	


            ///// FORUM LÝNK ÝSE LÝNKE GÖTÜR VE SAYACI 1 ARTIR
			$SQL = mysql_query("SELECT * FROM forumlar 
								WHERE forum_id =".$fid." and forum_link_url <> ''  ");
			$say = mysql_num_rows($SQL);


			if($say == 1)
			{
			  $SQL2 = mysql_query("UPDATE forumlar set 
								  forum_link_sayac = forum_link_sayac +1 
								  WHERE forum_id =".$fid."");
				
				$link = mysql_fetch_array($SQL);
				header("location:".$link["forum_link_url"]."");
				exit();
			}
			unset($SQL,$say,$SQL2);





if(empty($order))
{
  $order ="desc";
   $template->assign_vars(array('ORDER' => "desc"));
}
else if($order =="asc")
{
 $order ="asc";
 $template->assign_vars(array('ORDER' => "desc"));
}
else if($order =="desc")
{
 $order ="desc";
   $template->assign_vars(array('ORDER' => "asc"));

}




if(empty($sort))
{
  $sort ="son_mesaj_zamani";
}
else if($sort =="cevap")
{
 $sort ="konu_cevap_sayisi";
}
else if($sort =="views")
{
 $sort ="konu_goruntulenme";

}

 // FORUMDA KÝMLER DOLANIYOR HEMEN BULALIM
 $son_sayfa ="forumdisplay.php?f=".$fid;
 $time = time();
 $zaman_asimi = $ayar["cevrimici_zaman_asimi"];
 
 $SQLdolanan_uye = mysql_query("select * from kullanicilar 
							where  kul_son_sayfa = '".$son_sayfa."' 
							and  ('".$zaman_asimi."' + kul_son_aktivite ) > '".$time."'"); 
							
 $SQLdolanan_misafir = mysql_query("select * from online_kullanicilar 
							where  kul_son_sayfa = '".$son_sayfa."'
							and  (kul_giris  + '".$zaman_asimi."') > '".$time."'");
							
  $misafir_say = mysql_num_rows($SQLdolanan_misafir);
  
  $template->assign_vars(array('MISAFIRSAY' => $misafir_say));
  $online_say = mysql_num_rows($SQLdolanan_uye);
  //echo $online_say;
  $h = 1;
  while($rowkul = mysql_fetch_array($SQLdolanan_uye))
  {
     if($h < $online_say)
	  $link_online ="<a href='profil.php?u=".$rowkul["kul_id"]."' style='color:#".kul_group_color($rowkul["kul_id"])."; font-weight:bold;'>".$rowkul["kul_adi"]."</a> ,";
     else 
	  $link_online ="<a href='profil.php?u=".$rowkul["kul_id"]."'style='color:#".kul_group_color($rowkul["kul_id"])."; font-weight:bold;'>".$rowkul["kul_adi"]."</a>";

	 $template->assign_block_vars('kulrow', array(
       'KUL_LINKI'  			=> $link_online ,

	   ));
 
  $h ++;
  }
 // FORUMDA KÝMLER DOLANIYOR HEMEN BULALIM SON


/// FORUMA ABONE OLUNMUÞ MU?
if ($_SESSION['kul'] !="misafir")
{
	$kulID = temizle($_SESSION['kul_id']);
	$SQL = mysql_query("SELECT * FROM abonelikler 
							WHERE forumID =".$fid." AND kullaniciID ='".$kulID."' ");
	$abonesay = mysql_num_rows($SQL);
}
  
////  FORUM BAÞLIÐINI BULUP  EKLEYELÝM ////
$SQL = mysql_query("SELECT * FROM forumlar WHERE forum_id =".$fid."");
$row = mysql_fetch_array($SQL);

 		 $template->assign_vars(array( 
		    'FORUM_ADI_UST'      => $row["forum_adi"],	
		    'FORUM_ID'           => $fid,	
		    'FORUM_KAPALIMI'     => ($row["forum_kilitlimi"]=="evet")? true:false,	
		    'ABONE_VAR'          => (@$abonesay > 0)? true:false,	
		 ));

 
///////////////////////// SAYFALAMA  BASLADI  /////////////////////////////

$gelen_sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] !='')? intval($_GET['sayfa']) : 1;
//Baglanilacak Tablo
$tablo = 'konular';

//Sayafalamayi yapan dosyanin adi
if($ayar["seo_durum"] =="acik")
$link = 'f'.$fid."-".seo(strip_tags($row["forum_adi"]));
else
$link = 'forumdisplay.php?f='.$fid;

//Sayfada kaç kayit görünecek
// öncelikle ayarlardan çekelim

$limit= $ayar["sayfala_limit_konu"];

//Kaç sayfa öncesi ve sonrasi görünecek
$s_s = 3;


// konu mesaj sayfalamak için
$SQL10 = mysql_query("SELECT * FROM konular WHERE konu_forum_id =".$fid." 
					&& konu_mod = 'normal' order by ".$sort." ".$order.""); 
$satir = mysql_num_rows($SQL10);


if($satir >0)
{//sonuç varsa
    //sonuç varsa konu yok deðeri demek yanlýþ olur.
    $template->assign_vars(array( 'KONU_YOK'  => false ));
 
    $baslama = ($gelen_sayfa > 1) ? (($gelen_sayfa -1) * $limit) : 0 ;
    $sayfa_kac = $satir/$limit;
    $sayfa_sayisi = ($satir % $limit != 0) ? intval($sayfa_kac)+1 : intval($sayfa_kac);
 /// eger browserdan girlen sayfa sayisi 
 
      if(@$_GET['sayfa']=="")
	   {
	    $_GET['sayfa']= 1;
	   }
 
 //en yüksek sayfa sayisindan büyükse sayfayi 1. sayfaya esitleyelim
	if(@$_GET['sayfa'] > $sayfa_sayisi )
	 {
	 $gelen_sayfa =1;
	 }///
	
    $basla=( $satir >= $baslama ) ? $baslama : 0 ;
    unset( $sayfa_kac, $baslama );
	$sorgu2= mysql_query("SELECT * FROM konular 
					WHERE konu_forum_id =".$fid." and konu_mod = 'normal'
					order by ".$sort." ".$order." limit ".$basla." , ".$limit."");
    $i=1;
    $style='';
	
	 while ( $row = mysql_fetch_array($sorgu2) )
	{///dýþ while
	###### UFAK SAYFALAMA LÝNKLERÝNÝ OLUÞTURALIM ##########
	
	$gelen_sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] !='')? intval($_GET['sayfa']) : 1;
	//Baglanilacak Tablo
	$tablo2 = 'mesajlar';
	$orderby2 = 'mesaj_konu_id';
	// alttaki WHERE ile gosterilen tablo
	$mesajforumid = $row["konu_id"];
	
	
	//Sayafalamayi yapan dosyanin adi
	if($ayar["seo_durum"] =="acik")
	  $link2 = 't'.$row["konu_id"]."-".seo($row["konu_baslik"])."";
	else
	  $link2 = 'showthread.php?t='.$row["konu_id"];
	  
	$limit= $ayar["sayfala_limit_cevap"];
	//Kaç sayfa öncesi ve sonrasi görünecek
	$s_s = 20;
//  sayfala_ufak($tablo,$orderby , $link, $limit ,$s_s,  $gelen_sayfa );
	
	
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
	
	// ANKETÝ VAR MI BÝR BAKALIM ///
	$SQL_ANKET = mysql_query("SELECT * FROM anket_option 
							WHERE anket_konu_id =".$row["konu_id"]."");
	$anket_say = mysql_num_rows($SQL_ANKET);

	/// konurow tema motoruna ekliyoruz
    $template-> assign_block_vars('konurow', array(
	'KONU_ID'             => $row["konu_id"],
	'KONU_BASLIK'         => $konu_basligi,
	'KONU_BASLIK_SEO'     => seo(strip_tags($konu_basligi)),
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
	'UFAK_SAYFALAMA'      => sayfala_ufak($tablo2,$orderby2 , $link2, $limit ,$s_s,  $gelen_sayfa ,$mesajforumid),
	'KONU_RESIM'          => @$resim,
	'KONU_RATING'         => $rating_resim,
	'KONU_RATING_DEGER'  => $rating_deger,
	'KONU_ANKET_VAR'     => ($anket_say > 0)? true:false,
	 //'KONU_VAR'            => ($satir > 0) ? true:false ,
	
	));	
		



}///dýþ while Son


################### SABÝT KONULARI BULUP TEMAYA YOLLAYALIM ##############################
 $sabitSQL = mysql_query("SELECT * FROM konular 
					WHERE konu_forum_id =".$fid." and konu_mod = 'sabit'
					order by ".$sort." ".$order."");
		
					
		while($sabit = mysql_fetch_array($sabitSQL))
		{//sabit while
		//Baglanilacak Tablo
		$tablo2 = 'mesajlar';
		$orderby2 = 'mesaj_konu_id';
		// alttaki WHERE ile gosterilen tablo
		$mesajforumid = $sabit["konu_id"];
		//Sayafalamayi yapan dosyanin adi
		$link2 = 'showthread.php?t='.$sabit["konu_id"];
		$limit= $ayar["sayfala_limit_cevap"];
		//Kaç sayfa öncesi ve sonrasi görünecek
		$s_s = 5;
        //  sayfala_ufak($tablo,$orderby , $link, $limit ,$s_s,  $gelen_sayfa );
	
   	    ###### FORUMDISPLAY.PHP DE SON MESAJ SAYFASINI BULALIM ####
		$tablosayfala = 'mesajlar';
		$WHERE_mesajforumid = $sabit["konu_id"];
		$limitsayfala = $ayar["sayfala_limit_cevap"];
		//sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala);
    
	    ###############   FORUM OKUNDUMU OKUNMADIMI  ############# 
        $son_mesaj_time =  $sabit["son_mesaj_zamani"];
		$konunun_idsi   =  $sabit["konu_id"];
		$resim = sabit_okundumu($son_mesaj_time, $konunun_idsi);
		
		//Eðer okunmadýysa konuyu kalýn harfle yazdýr
		if($resim ==="forum_unread.png")
		{
			$sabit_basligi = "<strong>".$sabit["konu_baslik"]."</strong>";
		}
		else
		{
			$sabit_basligi = $sabit["konu_baslik"];
		}
	

		//konu ratingini hemen temaya yollayalým
        $rating_deger = rating_konu($sabit["konu_id"]);
        $rating_resim= $ayar_rating_yolu."/".$rating_deger.".png";
		
		// ANKETÝ VAR MI BÝR BAKALIM ///
	    $SQL_ANKET = mysql_query("SELECT * FROM anket_option 
							WHERE anket_konu_id =".$sabit["konu_id"]."");
	    $anket_say = mysql_num_rows($SQL_ANKET);
		
			$template-> assign_block_vars('sabitrow', array(
			'KONU_ID'               => $sabit["konu_id"],
			'KONU_BASLIK'           => $sabit_basligi,
			'KONU_BASLIK_SEO'     => seo(strip_tags($sabit_basligi)),
			'KONU_YAZAR'            => $sabit["konu_author"],
			'KONU_YAZAR_ID'         => $sabit["konu_author_id"],
			'KONU_YAZAR_RENK'       => kul_group_color($sabit["konu_author_id"]),
			'KONU_OKUNMA'           => $sabit["konu_goruntulenme"],
			'KONU_IKONU'            => $sabit["konu_ikonu"],
			'KONU_TARIHI'           => forum_tarihi($sabit["konu_zamani"],$ayar['sistem_zaman_dilimi']),
			'KONU_CVP_SAYISI'  	    => $sabit["konu_cevap_sayisi"] , //
			'SON_MESAJ_ID'  	    => $sabit["son_mesaj_id"],
			'SON_MESAJ_ZAMANI'      => forum_tarihi($sabit["son_mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
			'SON_MESAJ_YAZAR_ID'    => $sabit["son_mesaj_yazar_id"],
			'SON_MESAJ_YAZAR'       => $sabit["son_mesaj_yazar"],
			'SON_MESAJ_YAZAR_RENK'  => kul_group_color($sabit["son_mesaj_yazar_id"]),
			'SON_MESAJ_SAYFASAY'    => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),
			'UFAK_SAYFALAMA'        => sayfala_ufak($tablo2,$orderby2 , $link2, $limit ,$s_s,  $gelen_sayfa ,$mesajforumid),
			'KONU_RESIM'            => @$resim,
			'SABIT'                 => ($sabit["konu_mod"] =="sabit") ? true:false,
			'KONU_RATING'         => $rating_resim,
			'KONU_RATING_DEGER'  => $rating_deger,			
	        'KONU_ANKET_VAR'     => ($anket_say > 0)? true:false,
			));	
			
		}//sabit while son

################### SABÝT KONULARI BULUP TEMAYA YOLLAYALIM SON ##########################






################### DUYURU KONULARI BULUP TEMAYA YOLLAYALIM ##############################
 $duyuruSQL = mysql_query("SELECT * FROM konular 
					WHERE konu_forum_id =".$fid." and konu_mod = 'duyuru'
					order by ".$sort." ".$order."");
		
		$duyurusay = mysql_num_rows($duyuruSQL);
		
		$template->assign_vars(array( 'DUYURU_VAR'  => ($duyurusay > 0) ? true:false ));
			
		
		while($duyuru = mysql_fetch_array($duyuruSQL))
		{//duyuru while
		//Baglanilacak Tablo
		$tablo2 = 'mesajlar';
		$orderby2 = 'mesaj_konu_id';
		// alttaki WHERE ile gosterilen tablo
		$mesajforumid = $duyuru["konu_id"];
		//Sayafalamayi yapan dosyanin adi
		$link2 = 'showthread.php?t='.$duyuru["konu_id"];
		$limit= $ayar["sayfala_limit_cevap"];
		//Kaç sayfa öncesi ve sonrasi görünecek
		$s_s = 5;
        //  sayfala_ufak($tablo,$orderby , $link, $limit ,$s_s,  $gelen_sayfa );
	
   	    ###### FORUMDISPLAY.PHP DE SON MESAJ SAYFASINI BULALIM ####
		$tablosayfala = 'mesajlar';
		$WHERE_mesajforumid = $duyuru["konu_id"];
		$limitsayfala = $ayar["sayfala_limit_cevap"];
		//sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala);
    
	    ###############   FORUM OKUNDUMU OKUNMADIMI  ############# 
        $son_mesaj_time =  $duyuru["son_mesaj_zamani"];
		$konunun_idsi   =  $duyuru["konu_id"];
		$resim = duyuru_okundumu($son_mesaj_time, $konunun_idsi);
		
		//Eðer okunmadýysa konuyu kalýn harfle yazdýr
		if($resim ==="announcement_new.png")
		{
			$duyuru_basligi = "<strong>".$duyuru["konu_baslik"]."</strong>";
		}
		else
		{
			$duyuru_basligi = $duyuru["konu_baslik"];
		}
	

		
		//konu ratingini hemen temaya yollayalým
        $rating_deger = rating_konu($duyuru["konu_id"]);
        $rating_resim= $ayar_rating_yolu."/".$rating_deger.".png";
		
		// ANKETÝ VAR MI BÝR BAKALIM ///
	    $SQL_ANKET = mysql_query("SELECT * FROM anket_option 
							WHERE anket_konu_id =".$duyuru["konu_id"]."");
	    $anket_say = mysql_num_rows($SQL_ANKET);
		
			$template-> assign_block_vars('duyururow', array(
			'KONU_ID'               => $duyuru["konu_id"],
			'KONU_BASLIK'           => $duyuru_basligi,
			'KONU_BASLIK_SEO'     => seo(strip_tags($duyuru_basligi)),
			'KONU_YAZAR'            => $duyuru["konu_author"],
			'KONU_YAZAR_ID'         => $duyuru["konu_author_id"],
			'KONU_YAZAR_RENK'       => kul_group_color($duyuru["konu_author_id"]),
			'KONU_OKUNMA'           => $duyuru["konu_goruntulenme"],
			'KONU_IKONU'            => $duyuru["konu_ikonu"],
			'KONU_TARIHI'           => forum_tarihi($duyuru["konu_zamani"],$ayar['sistem_zaman_dilimi']),
			'KONU_CVP_SAYISI'  	    => $duyuru["konu_cevap_sayisi"] , //
			'SON_MESAJ_ID'  	    => $duyuru["son_mesaj_id"],
			'SON_MESAJ_ZAMANI'      => forum_tarihi($duyuru["son_mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
			'SON_MESAJ_YAZAR_ID'    => $duyuru["son_mesaj_yazar_id"],
			'SON_MESAJ_YAZAR'       => $duyuru["son_mesaj_yazar"],
			'SON_MESAJ_YAZAR_RENK'  => kul_group_color($duyuru["son_mesaj_yazar_id"]),
			'SON_MESAJ_SAYFASAY'    => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),
			'UFAK_SAYFALAMA'        => sayfala_ufak($tablo2,$orderby2 , $link2, $limit ,$s_s,  $gelen_sayfa ,$mesajforumid),
			'KONU_RESIM'            => @$resim,
			'DUYURU'                 => ($duyuru["konu_mod"] =="duyuru") ? true:false,	
			'KONU_RATING'         => $rating_resim,
			'KONU_RATING_DEGER'  => $rating_deger,			
	        'KONU_ANKET_VAR'     => ($anket_say > 0)? true:false,
			));	
			
		}//duyuru while son

################### DUYURU KONULARI BULUP TEMAYA YOLLAYALIM SON ##########################




		###### ALT FORUM VAR MI ONU BULALIM ########
		$alt_forum_sql = mysql_query("SELECT * FROM forumlar
				 WHERE  forum_ust_f = ".$fid." order by sirala desc");
				 
		$alt_forum_say = mysql_num_rows($alt_forum_sql);
		
		 $template->assign_vars(array( 
		'ALT_FORUM_VAR'      => ($alt_forum_say > 0) ? true : false , //Varsa true
		 ));
	        
			while ($altforum = mysql_fetch_array($alt_forum_sql))
			{
		     ############## ALT FORUM OKUNDUMU ?  OKUNMADIMI? HEMEN BULALIM 
			  
			  $resim ="forum_old.png";
			  
				$bul= @preg_match('/-'.$altforum["forum_son_mesaj_konu_id"].'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] );
			  
				// eðer cookie okundu varsa ve konu id cookie içinde varsa
				if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']) and $bul == true)
				{ 
					$cerez = explode('-'.$altforum["forum_son_mesaj_konu_id"].'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
					$parca= $cerez[1]; 
					$cerez_tarihi = substr($parca ,0,10);
			 
					// EÐER KONUDAKÝ SON MESAJIN TARÝHÝ ÇEREZDEKÝ TARÝHTEN BÜYÜKSE
					if($altforum['forum_son_mesaj_zamani'] > $cerez_tarihi)
						{
							//echo "yeni mesaj var " .$row["konu_baslik"];
							$resim ="forum_new.png";
							//$baslik_konu = "<b>".$forum["konu_baslik"]."</b>";

						}
						else
							{
								$resim ="forum_old.png";
								//$baslik_konu = $forum["konu_baslik"];
							}

				}
				else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA :)
				{
					if($altforum['forum_son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
					{
						$resim ="forum_new.png";
						//$baslik_konu = "<b>".$forum["konu_baslik"]."</b>";
				
					}
				}

		     ####### ALT FORUM OKUNDUMU  SON ###############

			 
				###### forumdisplay.php DE SON MESAJ SAYFASINI BULALIM ####
				$tablosayfala = 'mesajlar';
				$WHERE_mesajforumid = $altforum["forum_son_mesaj_konu_id"];
				$limitsayfala = $ayar["sayfala_limit_cevap"];
				###### forumdisplay.php DE SON MESAJ SAYFASINI BULALIM ####
				

				
			   ///Alt forumlarý tema motoruna ekliyoruz
			   $template->assign_block_vars('altrow', array(
			   'FORUMLAR'  		     => $altforum["forum_adi"],
			   'FORUMLAR_SEO'  		 => seo($altforum["forum_adi"]),
			   'DESC'                => $altforum["forum_tarifi"],
			   'F_ID'                => $altforum["forum_id"],
			   'TOPLAM_KONU'         => $altforum["forum_toplam_konu"],
			   'TOPLAM_MESAJ'        => $altforum["forum_toplam_mesaj"],
			   'SON_MESAJ'           => substr($altforum["forum_son_mesaj_title"],0,20)."...",
			   'SON_MESAJ_ID'        => $altforum["forum_son_mesaj_id"],
			   'SON_MESAJ_KONU_ID'   => $altforum["forum_son_mesaj_konu_id"],
			   'SON_MESAJ_YAZAR'     => $altforum["forum_son_mesaj_kul"],
			   'SON_MESAJ_YAZAR_ID'  => $altforum["forum_son_mesaj_kul_id"],
			   'SON_MESAJ_IKONU'     => $altforum["forum_son_mesaj_ikonu"],
			   'SON_MESAJ_YAZAR_RENK' => kul_group_color($altforum["forum_son_mesaj_kul_id"]),
			   'SON_MESAJ_ZAMAN' 	 => tarih($altforum["forum_son_mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
			   'SON_MESAJ_SAYFASAY'  => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),
			   'FORUM_BOS'           => empty($altforum["forum_toplam_konu"] ) ? true : false ,
	           'KONU_RESIM'          => @$resim,
			   ));
			   
			@mysql_free_result($KULSQL);
			unset($KULSQL);
			}
			mysql_free_result($alt_forum_sql);
			unset($alt_forum_sql);
	###### ALT FORUM VAR MI ONU BULALIM SON ####
	
    $hangi_sayfa= ($gelen_sayfa > 0)? $gelen_sayfa : 1 ;
    $sayfala_cikis ="";
	
     $sayfala_cikis.= '';
     
     $alt= ($gelen_sayfa - $s_s);
     if($sayfa_sayisi <= $s_s || $gelen_sayfa <= $s_s ) {$alt=1;} 
     $ust= (($gelen_sayfa + $s_s)< $sayfa_sayisi ) ? ($gelen_sayfa + $s_s) : ($sayfa_sayisi);    
            
						
		if ($gelen_sayfa > 1 ) 
		{
		  if($ayar["seo_durum"] =="acik")
			$sayfala_cikis.= '<a href="'.$link.'-1.html" id="sayfalamaLink" title="Ýlk Sayfa">« Ýlk </a> 
			 &nbsp;<a href="'.$link.'-'.($gelen_sayfa -1).'.html" 
			 title="Önceki Sayfa" id="sayfalamaLink"><</a>';
		  else
		  		$sayfala_cikis.= '<a href="'.$link.'&sayfa=1" id="sayfalamaLink" title="Ýlk Sayfa">« Ýlk </a> 
			 &nbsp;<a href="'.$link.'&sayfa='.($gelen_sayfa -1).'" 
			 title="Önceki Sayfa" id="sayfalamaLink"><</a>';
		}
		else 
		{
		  $sayfala_cikis.= "";
		
		}
			
            for($i=$alt; $i<=$ust ;$i++)
			{       
		      if ($i != $gelen_sayfa ) 
			  {
			    if($ayar["seo_durum"] =="acik")
			      $sayfala_cikis.= ' <a title="'.$i.'. Sayfa" href="'.$link.'-'.$i.'.html" id="sayfalamaLink">'.$i.'</a>' ;
			     else
				  $sayfala_cikis.= ' <a title="'.$i.'. Sayfa" href="'.$link.'&sayfa='.$i.'" id="sayfalamaLink">'.$i.'</a>' ;
		      }
			  else 
			  {
			    $sayfala_cikis.= ' <span id="sayfalamaLink_Aktif">'.$i.'</span>';
			  }
           }
            				
		if ($gelen_sayfa < $sayfa_sayisi) 
		{
		 if($ayar["seo_durum"] =="acik")
		  $sayfala_cikis.= ' <a href="'.$link.'-'.($gelen_sayfa +1).'.html" title="Sonraki Sayfa" id="sayfalamaLink">
          ></a> <a href="'.$link.'-'.$sayfa_sayisi.'.html" title="Son Sayfa" id="sayfalamaLink"> Son »</a>' ;
		 else 
		  $sayfala_cikis.= ' <a href="'.$link.'&sayfa='.($gelen_sayfa +1).'" title="Sonraki Sayfa" id="sayfalamaLink">
          ></a> <a href="'.$link.'&sayfa='.$sayfa_sayisi.'" title="Son Sayfa" id="sayfalamaLink"> Son »</a>' ;
        }
		else 
		{
		 $sayfala_cikis.= "";		
		}
		

		
		
	 
  //  Eðer sayfa sayýsý 1 ise sayfalamayý gösterme    //	 
	 if($sayfa_sayisi > 1)
     $template->assign_vars(array( 'FORUM_ID'  => $fid, 
									'SAYFALA'  => $sayfala_cikis,
									'S_VAR'  => (10 > 1)? true : false ));
	    else
		  $template->assign_vars(array( 'FORUM_ID'  => $fid, 
									'SAYFALA'  => "", 'S_VAR'  => (10 < 1)? true : false ));
}
else{ // Eðer forumdisplay ye ait konu yoksa

		 $template->assign_vars(array( 
		 'FORUM_ID' 	  => $fid,
		 'KONU_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 'ALT_FORUM_VAR'  =>  false,  //Varsa true
		 'S_VAR'          => (10 < 1)? true : false,  //Varsa true
		 'DUYURU_VAR'     =>  false,  //Varsa true
		 'SAYFALA'        => ""
		 ));
	
    }

 mysql_free_result($SQL10);
 unset($SQL10);
///////////////////////// SAYFALAMA  BITTI  /////////////////////////////



///////////// FORUM LÝSTESÝ
$SQL = mysql_query("SELECT * FROM kategoriler");

   // Büyük while
   while($row = mysql_fetch_array($SQL))
   {
 
	   /// kategorirow tema motoruna ekliyoruz
	   $template-> assign_block_vars('kategorirow', array(
		'OPTION'           => '<option value="kategoridisplay.php?k='.$row["kat_id"].'">'.$row["kat_title"].'</option>',
		));	
	 //Forumlarý seçelim
	 $SQL_forum = mysql_query("SELECT * FROM forumlar WHERE  kat_id  ='".$row["kat_id"]."' and forum_tipi='' ");
	 
	 // Küçük while
	 while($forum =mysql_fetch_array($SQL_forum))
	 {
	 	 $alt_forum = mysql_query("SELECT * FROM forumlar 
			WHERE forum_ust_f  ='".$forum["forum_id"]."' and forum_tipi='alt' ");
		   $alt_say = mysql_num_rows($alt_forum);
			
			if($alt_say > 0)
			{
			
			 /// forumrow tema motoruna ekliyoruz
			  $template-> assign_block_vars('kategorirow.forumrow', array(
			  'OPTION'           => '<option value="forumdisplay.php?f='.$forum["forum_id"].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$forum["forum_adi"].'</option>',
			  ));	
			}
			else
			{
			 /// forumrow tema motoruna ekliyoruz
			  $template-> assign_block_vars('kategorirow.forumrow', array(
			  'OPTION'           => '<option value="forumdisplay.php?f='.$forum["forum_id"].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$forum["forum_adi"].'</option>',
			  ));	
			}

			
			
			
			// En Küçük while
			while($alt = mysql_fetch_array($alt_forum))
			{
			   /// altforumrow tema motoruna ekliyoruz
			    $template-> assign_block_vars('kategorirow.forumrow.altforumrow', array(
			    'OPTION'           => '<option value="forumdisplay.php?f='.$alt["forum_id"].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$alt["forum_adi"].'</option>',
			    ));	
			}// En Küçük while son
			
	 }// Küçük while son
	 
	 
   }// Büyük while son
   
   
   
///////////// FORUM LÝSTESÝ SON








$template->set_filenames(array('forumdisplay' => 'forumdisplay.html' ));

$template->display('forumdisplay');


require_once("footer.php");

?>