<?php
require_once("genel.php");
require_once("sistem/pagination.class.php");


	//SAYFA DETAYLARI
	  	$menu = '<a href="index.php">Anasayfa</a> > 
            <a href="search.php"> Arama Yap</a>';
	
	 

	$baslik= " Arama";
	if(!empty($_GET["aramaid"]))
    	$sayfa_url = "search.php?aramaid=".arama_id_temizle($_GET["aramaid"]);
	else
    	$sayfa_url = "search.php";

	// Kullanýcý koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullanýcý koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,	
		));
		unset($SQL);
    //SAYFA DETAYLARI
	require_once("baslik.php");


	
 /// RECAPTHA AKTÝF ÝSE
    if($ayar["reCAPTCHA_aktif_mi"] =="acik")
    {
	    require_once('sistem/reCAPTCHAlib.php');
        $publickey = $ayar["reCAPTCHA_publickey"]; // you got this from the signup page
        $template->assign_vars(array('CAPTCHA' => recaptcha_get_html($publickey), ));
    }
           

	
//Kullanýcý giriþ yaptýysa
$template->assign_vars(array(
	'S_LOGIN'            => ($_SESSION['kul'] != "misafir") ? true : false,
	'RECAPTHA_AKTIF'     => ($ayar["reCAPTCHA_aktif_mi"] =="acik")? true:false, 
    ));

	
	

//////////////////// ARAMA SAYFASINDAKÝ SELECT ÝÇÝNDEKÝ FORUMLAR VE KATEGORÝLER ÝÇÝN 
 
$SQL = mysql_query("SELECT * FROM kategoriler");

   // Büyük while
   while($row = mysql_fetch_array($SQL))
   {
 
	   /// kategorirow tema motoruna ekliyoruz
	   $template-> assign_block_vars('kategorirow', array(
		'OPTION'           => '<option value="kat'.$row["kat_id"].'">'.$row["kat_title"].'</option>',
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
			  'OPTION'           => '<option value="altvar'.$forum["forum_id"].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$forum["forum_adi"].'</option>',
			  ));	
			}
			else
			{
			 /// forumrow tema motoruna ekliyoruz
			  $template-> assign_block_vars('kategorirow.forumrow', array(
			  'OPTION'           => '<option value="'.$forum["forum_id"].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$forum["forum_adi"].'</option>',
			  ));	
			}

			
			
			
			// En Küçük while
			while($alt = mysql_fetch_array($alt_forum))
			{
			   /// altforumrow tema motoruna ekliyoruz
			    $template-> assign_block_vars('kategorirow.forumrow.altforumrow', array(
			    'OPTION'           => '<option value="'.$alt["forum_id"].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$alt["forum_adi"].'</option>',
			    ));	
			}// En Küçük while son
			
	 }// Küçük while son
	 
	 
   }// Büyük while son

 

//////////////////// ARAMA ÝD SÝNDEN VERÝ TABANINDAKÝ VERÝLER ÇEKÝLÝR VE GEREKLÝ ARAMA
//////////////////// YAPILARAK TEMA MOTORUNA GÖNDERÝLÝR.
if(!empty($_GET["aramaid"]))
$arama_id = arama_id_temizle($_GET["aramaid"]);


mysql_free_result($SQL);   
unset($SQL,$row,$forum,$alt);
  
  if(!empty($arama_id))
  {
  		 $template->assign_vars(array( 
		 'ARAMA_SONUC'  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 ));
  
    $SQL1 = mysql_query("SELECT * FROM yapilan_aramalar WHERE arama_id=".$arama_id."");
	$arama = mysql_fetch_array($SQL1);
	
	// ARAMA KRÝTERLERÝNE GÖRE ARAMA YAPABÝLEMEMÝZ ÝÇÝN ÞARTLARI BELÝRLEYELÝM
	$kelime    = $arama["aranan_kelime"];
	$kullanici = $arama["aranan_kullanici"];
	$sonuc     = $arama["sonuc_nasil_goster"];
	$sort      = $arama["sonuc_sort"];
	$nerde_ara = $arama["nerede_aradi"];
	

     

  // KELÝME ÝÇÝN
	// eðer aranan kelime doluysa, kullanýcý boþsa,  sonuc_nasil_goster mesajlarda ise
	if( $kelime != "" and $kullanici =="" and $sonuc =="mesajlarda")
	{
				////////////////// Konu mesajlarýnda ARAMA
				
				if(preg_match("/tum_forumlar/",$nerde_ara))
				{
				   $nerde_ara ="tum_forumlar";
				   
				   $sorgu ="SELECT * FROM mesajlar WHERE  mesaj_govde like '%$kelime%' or mesaj_baslik  like '%$kelime%'";
				
				}
				else
				{
				
				
					$parcala =explode(",",$nerde_ara);
					$say = count($parcala);

					$sorgu ="SELECT * FROM mesajlar WHERE mesaj_govde like '%$kelime%' or mesaj_baslik  like '%$kelime%'";
					$n = 1;
					foreach($parcala as $key)
					{
						  if($say ==1)
						  {
							$sorgu .=" and ( mesaj_forum_id   = '".$key."')";
						  }
						  else if($n ==1 and $say != 1)
						 {
							$sorgu .=" and ( mesaj_forum_id   = '".$key."' or";
						 }
						 else if($n == $say)
						 {
							 $sorgu .=" mesaj_forum_id   = '".$key."')";

						 }
						 else
						 {
							$sorgu .=" mesaj_forum_id   = '".$key."' or";
						 }
						 
						 
						 $n++;
					}
				}// if pregmatch son
				
				$sorgu.= " order by mesaj_zamani ".$sort;
				$aranan = "<strong>Aranan Kelime:</strong> ".$kelime;

			  //echo $sorgu;
  
	
	}
	
	// eðer aranan kelime doluysa, kullanýcý boþsa,  sonuc_nasil_goster konularda ise
	if( $kelime != "" and $kullanici =="" and $sonuc =="konularda")
	{
			////////////////// Konu BAÞLIKLARINDA ARAMA
			
			if(preg_match("/tum_forumlar/",$nerde_ara))
			{
			   $nerde_ara ="tum_forumlar";
			   
			   $sorgu ="SELECT * FROM konular WHERE  konu_baslik  like '%$kelime%'";
			
			}
			else
			{
			
			
				$parcala =explode(",",$nerde_ara);
				$say = count($parcala);

				$sorgu ="SELECT * FROM konular WHERE konu_baslik  like '%$kelime%'";
				$n = 1;
				foreach($parcala as $key)
				{
					  if($say ==1)
					  {
						$sorgu .=" and ( konu_forum_id  = '".$key."')";
					  }
					  else if($n ==1 and $say != 1)
					 {
						$sorgu .=" and ( konu_forum_id  = '".$key."' or";
					 }
					 else if($n == $say)
					 {
						 $sorgu .="  konu_forum_id  = '".$key."')";

					 }
					 else
					 {
						$sorgu .="  konu_forum_id  = '".$key."' or";
					 }
					 
					 
					 $n++;
				}
			}// if pregmatch son
			
		  //echo $sorgu;
		  
		  $sorgu.= " order by konu_zamani ".$sort;
		  $aranan = "<strong>Aranan Kelime:</strong> ".$kelime;

	
	
	}
	
	//KULLANICI ÝÇÝN
	// eðer aranan kelime boþsa, kullanýcý doluysa,  sonuc_nasil_goster mesajlarda ise
	if( $kelime == "" and $kullanici !="" and $sonuc =="mesajlarda")
	{
			////////////////// KULLANICI ÝÇÝN ARAMA
			
			if(preg_match("/tum_forumlar/",$nerde_ara))
			{
			   $nerde_ara ="tum_forumlar";
			   
			   $sorgu ="SELECT * FROM mesajlar WHERE  mesaj_author  like '%$kullanici%'";
			
			}
			else
			{
			
			
				$parcala = explode(",",$nerde_ara);
				$say = count($parcala);

				$sorgu ="SELECT * FROM mesajlar WHERE mesaj_author  like '%$kullanici%'";
				$n = 1;
				foreach($parcala as $key)
				{
					  if($say ==1)
					  {
						$sorgu .=" and (  mesaj_forum_id   = '".$key."')";
					  }
					  else if($n ==1 and $say != 1)
					 {
						$sorgu .=" and (  mesaj_forum_id   = '".$key."' or";
					 }
					 else if($n == $say)
					 {
						 $sorgu .="   mesaj_forum_id   = '".$key."')";

					 }
					 else
					 {
						$sorgu .="   mesaj_forum_id   = '".$key."' or";
					 }
					 
					 
					 $n++;
				}
			}// if pregmatch son
			
		  //echo $sorgu;
		  
		  $sorgu.= " order by mesaj_zamani ".$sort;
		  $aranan = "<strong>Aranan Kullanýcý:</strong> ".$kullanici;


	
	}

	// eðer aranan kelime boþsa, kullanýcý doluysa,  sonuc_nasil_goster konularda ise
	if( $kelime == "" and $kullanici !="" and $sonuc =="konularda")
	{
			////////////////// KULLANICI ÝÇÝN ARAMA
			
			if(preg_match("/tum_forumlar/",$nerde_ara))
			{
			   $nerde_ara ="tum_forumlar";
			   
			   $sorgu ="SELECT * FROM konular WHERE   konu_author  like '%$kullanici%'";
			
			}
			else
			{
			
			
				$parcala =explode(",",$nerde_ara);
				$say = count($parcala);

				$sorgu ="SELECT * FROM konular WHERE  konu_author   like '%$kullanici%'";
				$n = 1;
				foreach($parcala as $key)
				{
					  if($say ==1)
					  {
						$sorgu .=" and (   konu_forum_id    = '".$key."')";
					  }
					  else if($n ==1 and $say != 1)
					 {
						$sorgu .=" and (   konu_forum_id    = '".$key."' or";
					 }
					 else if($n == $say)
					 {
						 $sorgu .="    konu_forum_id    = '".$key."')";

					 }
					 else
					 {
						$sorgu .="    konu_forum_id    = '".$key."' or";
					 }
					 
					 
					 $n++;
				}
			}// if pregmatch son
			
		  //echo $sorgu;
		  
			$sorgu.= " order by konu_zamani ".$sort;
			$aranan = "<strong>Aranan Kullanýcý:</strong> ".$kullanici;

	
	}
	
	//$SQL = mysql_query($sorgu);
	
	//echo mysql_num_rows($SQL)."<br>";
	//echo $sorgu;
	
	////////////////////// SAYFALAMA VE TEMAYA ATAMA ZAMANI //////////////////////
	
	
	//$kackayit = $ayar["sayfala_limit_konu"];
    $kackayit = $ayar["sayfala_limit_konu"];

	$sayfa = 1;
	
	if(isset($_GET['sayfa']) and is_numeric($_GET['sayfa']) and $sayfa = $_GET['sayfa'])
			$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
		else
			$limit = " LIMIT $kackayit";
	
	
    $SQLCEK = $sorgu;

	$kayitSay = mysql_num_rows(mysql_query($SQLCEK));
	
	// Ufak tefek bilgileri while içine koymuyoruz		 
	$template->assign_vars(array('BULUNAN_SONUC' => $kayitSay, 'ARANAN'  => $aranan,));
	

	//$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
	$SQL   = mysql_query($SQLCEK.$limit);
	
		
	        // SAYFALAMA PAREMETRELERÝ
			$p = new pagination;
			$p->Items($kayitSay);
			$p->limit($kackayit);
			$p->target("search.php?aramaid=".$arama_id."");
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
	
 if($sonuc =="mesajlarda")
 {
 	$template->assign_vars(array( 'NERDE'  =>  "mesajlarda" ));
	
	while ( $row = mysql_fetch_array($SQL) )
		{///dýþ while
		
		//EÐER KONUYA AÝT MESAJ SAYISI 1 E EÞÝT ÝSE ARADIÐIMIZI BULDUK
		$konu_say =mysql_num_rows($SQL);
		
		//HANGÝ FORUMA AÝT OLDUGUNU BULALIM
		 $SQL3 = mysql_query("SELECT * FROM forumlar  
							WHERE  forum_id  ='".$row["mesaj_forum_id"]."'");
		$forum =mysql_fetch_array($SQL3);
		
		//HANGÝ KONUYA AÝT OLDUGUNU BULALIM
		 $SQL4 = mysql_query("SELECT * FROM konular  
							WHERE  konu_id  ='".$row["mesaj_konu_id"]."'");
		$konu =mysql_fetch_array($SQL4);
		
		
							
		if($konu_say > 0)//Büyük if	
		{	

		   $template->assign_vars(array( 'KONU_YOK'  =>  false ));
			$n ++;
			
			###### FORUMDISPLAY.PHP DE SON MESAJ SAYFASINI BULALIM ####
			$tablosayfala = 'mesajlar';
			$WHERE_mesajforumid = $row["mesaj_konu_id"];
			$limitsayfala = $ayar["sayfala_limit_cevap"];
			//sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala);
			

			//konu ratingini hemen temaya yollayalým
				$rating_deger = rating_konu($row["mesaj_konu_id"]);
				$rating_resim= $ayar_rating_yolu."/".$rating_deger.".png";

			// Eðer mesaj gövdesi çok uzunsa 
            if(strlen($row["mesaj_govde"]) >60)
			$row["mesaj_govde2"] = substr($row["mesaj_govde"],0,60)."...";	
			else
			$row["mesaj_govde2"] = $row["mesaj_govde"];
			
			// Aranan kelimeyi renklendireilim.
			$govde = str_replace($kelime," <font class='arama_renk'>".$kelime."</font> ",$row["mesaj_govde"] );
			//$govde = vurgula($row["mesaj_govde"], $kelime);
			if(strlen($govde)>500)
			$govde = substr($govde,0,500)."...";
			else
			$govde = $govde;
			
			
			
			/// konurow tema motoruna ekliyoruz
			$template-> assign_block_vars('mesajrow', array(
			'MESAJ_ID'             => $row["mesaj_id"],
			'MESAJ_BASLIK'         => $row["mesaj_baslik"],
			'MESAJ_GOVDE'          => $row["mesaj_govde2"] ,
			'MESAJ_GOVDE2'         => strip_tags($govde, "<font>") ,
			'MESAJ_YAZAR'          => $row["mesaj_author"],
			'MESAJ_YAZAR_ID'       => $row["mesaj_author_id"],
			'MESAJ_YAZAR_RENK'     => kul_group_color($row["mesaj_konu_id"]),
			'MESAJ_OKUNMA'         => $konu["konu_goruntulenme"],
			'MESAJ_IKONU'          => $row["mesaj_ikonu"],
			'MESAJ_TARIHI'         => forum_tarihi($row["mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
			'MESAJ_CVP_SAYISI'     => $konu["konu_cevap_sayisi"] , //
			//'UFAK_SAYFALAMA'      => sayfala_ufak($tablo2,$orderby2 , $link2, $limit ,$s_s,  $gelen_sayfa ,$mesajforumid),
			'MESAJ_RESIM'          => @$resim,
			'MESAJ_RATING'         => $rating_resim,
			'MESAJ_RATING_DEGER'   => $rating_deger,
			'MESAJ_FORUM'          => $forum["forum_adi"],
			'MESAJ_FORUM_ID'       => $forum["forum_id"],
			'MESAJ_KONU_ID'        => $konu["konu_id"],
			'MESAJ_KONU_BASLIK'    => str_replace($kelime," <font class='arama_renk'>".$kelime."</font> ",$konu["konu_baslik"] ),
			'MESAJ_KONU_CEVAPLAR'   => $konu["konu_cevap_sayisi"],
			'MESAJ_KONU_IZLENME'    => $konu["konu_goruntulenme"],
			'SON_MESAJ_SAYFASAY'  => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),

			));	
		} //Büyük if
		else
		{
			 $template->assign_vars(array( 
			 'KONU_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
			 ));
		}
		

	}///dýþ while Son 
 
 
 
 }
 else if ($sonuc =="konularda")
 {
  	$template->assign_vars(array( 'NERDE'  =>  "konularda" ));
	
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

}// Else if konularda son

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

	
	
	
	
	
	
	
	
	
	
	
	
	
  }// If aramaid =true son
  else
  {
  		 $template->assign_vars(array( 
		 'ARAMA_SONUC'  =>  false , //sonuç yoksa konu yok deðeri doðrudur.
		 ));
  
  }



$template->set_filenames(array('search' => 'search.html' ));

$template->display('search');

require_once("footer.php");

?>