<?php
require_once("genel.php");

//SAYFA DETAYLARI
    $baslik= "Anasayfa";
	
	//SEO VARSA
	if($ayar["seo_durum"] =="acik")
	  $sayfa_url ="index.html";
	else
	  $sayfa_url ="index.php";
	
	//SEO VARSA
	if($ayar["seo_durum"] =="acik")
	  $menu = '<a href="index.html">Anasayfa</a>';
	else
	  $menu = '<a href="index.php">Anasayfa</a>';

	
	// Kullanýcý koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,
        'SEO_AKTIFSE'       => ($ayar["seo_durum"] =="acik") ? true:false,
		
	));
//SAYFA DETAYLARI
require_once("baslik.php");




// forumlarý sayfalamak için
$SQL = mysql_query("SELECT * FROM kategoriler order by sirala desc"); 

while ( $row = mysql_fetch_array($SQL) ){///dýþ while

   /// catrow tema motoruna ekliyoruz
    $template-> assign_block_vars('catrow', array(
	'KATEGORI'  => $row["kat_title"],
	'KATEGORI_SEO'  => seo($row["kat_title"]),
	'DESC'      => $row["kat_desc"],
	'CAT_ID'    => $row["kat_id"],
	'DESC_VAR'  =>  (!empty($row["kat_desc"])) ? true : false ,

	));
/////////////////////////////	
	
       $cat1 = $row["kat_id"];
       $SQL2 = mysql_query("SELECT * FROM forumlar 
	                        WHERE kat_id =".$cat1." and forum_tipi = '' 
							order by sirala desc "); 

       
    while($forum  = mysql_fetch_array($SQL2)){ ///////////////iç while
	
	
	////////////////////*** FORUM OKUNDUMU ?  OKUNMADIMI? HEMEN BULALIM ***////////////////////
	        $resim ="forum_old.png";
		  
			$bul= @preg_match('/-'.$forum["forum_son_mesaj_konu_id"].'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] );
		  
			// eðer cookie okundu varsa ve konu id cookie içinde varsa
			if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']) and $bul == true)
			{ 
				$cerez = explode('-'.$forum["forum_son_mesaj_konu_id"].'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
				$parca= $cerez[1]; 
				$cerez_tarihi = substr($parca ,0,10);
		 
				// EÐER KONUDAKÝ SON MESAJIN TARÝHÝ ÇEREZDEKÝ TARÝHTEN BÜYÜKSE
				if($forum['forum_son_mesaj_zamani'] > $cerez_tarihi)
					{
						$resim ="forum_new.png";
					}
					else
					{
						$resim ="forum_old.png";
					}

			}
			else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA :)
			{
				if($forum['forum_son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
				{
						$resim ="forum_new.png";
				}
			}
			
			// EÐER FORUM KÝLÝTLÝYSE VEYA LÝNK DEÐÝLSE RESim forum_old ise
			if($forum["forum_kilitlimi"] =="evet" and $forum["forum_link_mi"] =="hayir" and $resim =="forum_old.png" )
			$resim ="forum_old_lock.png";
			
			// EÐER FORUM KÝLÝTLÝYSE VEYA LÝNK DEÐÝLSE RESim forum_new ise
			if($forum["forum_kilitlimi"] =="evet" and $forum["forum_link_mi"] =="hayir" and $resim =="forum_new.png" )
			$resim ="forum_new_lock.png";
			
			// EÐER FORUM  LÝNK ÝSE 
			if($forum["forum_link_mi"] =="evet")
			$resim ="forum_link.png";
			
	############### FORUM OKUNDUMU ?  OKUNMADIMI? HEMEN BULALIM SON ############### 
	
	
	###### showthread.php DE SON MESAJ SAYFASINI BULALIM ####
	$tablosayfala = 'mesajlar';
	$WHERE_mesajforumid = $forum["forum_son_mesaj_konu_id"];
	$limitsayfala = $ayar["sayfala_limit_cevap"];
	//sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala);
	###### showthread.php DE SON MESAJ SAYFASINI BULALIM ####
	
	###### ALT FORUM VAR MI ONU BULALIM ########
	$alt_forum_sql = mysql_query("SELECT * FROM forumlar
             WHERE  forum_ust_f = ".$forum["forum_id"]." order by sirala desc");
			 
    $alt_forum_say = mysql_num_rows($alt_forum_sql);

	###### ALT FORUM VAR MI ONU BULALIM SON ####
	
	
	###### FORUM SON MESAJ KULLANICI GRUP RENGÝNÝ BULALIM ########
	$kul_grup_sql = mysql_query("SELECT * FROM kullanicilar
                    WHERE  kul_id = ".$forum["forum_son_mesaj_kul_id"]."");
			 
    @$kul_grup = mysql_num_rows($kul_grup_sql);
	###### FORUM SON MESAJ KULLANICI GRUP RENGÝNÝ BULALIM SON ######## 
	
	 // FORUMDA KÝMLER DOLANIYOR HEMEN BULALIM
		 $son_sayfa ="forumdisplay.php?f=".$forum["forum_id"];
		 $time = time();
		 $zaman_asimi = $ayar["cevrimici_zaman_asimi"];
		 
		 $SQLdolanan_uye = mysql_query("select * from kullanicilar 
									where  kul_son_sayfa = '".$son_sayfa."' 
									and  ('".$zaman_asimi."' + kul_son_aktivite ) > '".$time."'"); 
									
		 $SQLdolanan_misafir = mysql_query("select * from online_kullanicilar 
									where  kul_son_sayfa = '".$son_sayfa."'
									and  (kul_giris  + '".$zaman_asimi."') > '".$time."'");
									
		  $misafir_say = mysql_num_rows($SQLdolanan_misafir);
		  
		  $online_say = mysql_num_rows($SQLdolanan_uye) + $misafir_say;
	
	 // FORUMDA KÝMLER DOLANIYOR HEMEN BULALIM SON

	  ///categoriler tema motoruna ekliyoruz
       $template->assign_block_vars('catrow.forumrow', array(
       'FORUMLAR'             => $forum["forum_adi"],
       'FORUMLAR_SEO'         => seo($forum["forum_adi"]),
	   'DESC'                 => $forum["forum_tarifi"],
	   'F_ID'    		      => $forum["forum_id"],
	   'ALT_FORUM_VAR'        => ($alt_forum_say > 0) ? true : false ,
	   'TOPLAM_KONU'  		  => $forum["forum_toplam_konu"],
	   'TOPLAM_MESAJ' 		  => $forum["forum_toplam_mesaj"],
	   'SON_MESAJ'     		  => substr($forum["forum_son_mesaj_title"],0,20)."...",
	   'SON_MESAJ_SEO'     	  => seo(substr($forum["forum_son_mesaj_title"],0,20)),
	   'SON_MESAJ_ID'         => $forum["forum_son_mesaj_id"],
	   'SON_MESAJ_KONU_ID'    => $forum["forum_son_mesaj_konu_id"],
       'SON_MESAJ_YAZAR' 	  => $forum["forum_son_mesaj_kul"],
       'SON_MESAJ_YAZAR_ID'	  => $forum["forum_son_mesaj_kul_id"],
       'SON_MESAJ_IKONU'	  => $forum["forum_son_mesaj_ikonu"],
       'SON_MESAJ_YAZAR_RENK' => kul_group_color($forum["forum_son_mesaj_kul_id"]),
       'SON_MESAJ_ZAMAN'      => tarih($forum["forum_son_mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
       'SON_MESAJ_SAYFASAY'   => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),
	   'FORUM_BOS'  	      => empty($forum["forum_toplam_konu"] ) ? true : false ,
	   'FORUM_RESIM'          => @$resim,
       'LINK_MI'	          => ($forum["forum_link_mi"] =="evet")? true:false,
       'LINK_ADI'	          => $forum["forum_link_adi"],
       'LINK_ID'	          => $forum["forum_id"],
       'LINK_ACIKLAMA'	      => $forum["forum_link_aciklama"],
       'LINK_URL'	          => $forum["forum_link_url"],
       'LINK_SAYAC'	          => (!empty($forum["forum_link_sayac"])) ? $forum["forum_link_sayac"]:"0",
       'ONLINE_SAYISI'	      => $online_say ,
       'ONLINE_VAR_MI'	      => ($online_say > 0) ? true:false,
  

	   ));
	        
			// Alt forumlarý listele
			while($altforum  = mysql_fetch_array($alt_forum_sql)){ ////// ENN iç while
		     ######## ALT FORUM OKUNDUMU ///////
	             $resim ="subforum_old.png";
			 
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
							$resim ="subforum_new.png";
						}
					else
						{
							$resim ="subforum_old.png";
						}

				 }
				 else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA 
				 {
				  if($altforum['forum_son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
					{
						$resim ="subforum_new.png";
					}
				 }
			  ############### ALT FORUM OKUNDU SON ###############
				
					///Alt forumlarý tema motoruna ekliyoruz
					$template->assign_block_vars('catrow.forumrow.altrow', array(
						'ALT_FORUM_ADI'  => $altforum["forum_adi"],
						'ALT_FORUM_ADI_SEO'  => seo($altforum["forum_adi"]),
						'ALT_F_ID'      => $altforum["forum_id"],			   
						'FORUM_RESIM'      => $resim		   
					));

			} //ENN iç while son

	  }//iç while son
	  
} //dýþ while son


// ONLÝNE LÝSTESÝNE BÝR GÖZ ATALIM

unset($SQL);
unset($SQL);
unset($sor);
unset($say);
$time = time();
$zaman_asimi = $ayar["cevrimici_zaman_asimi"];
########## ONLÝNE KULLANICILAR ÇEKÝLÝYOR    

$SQL = mysql_query("SELECT * FROM kullanicilar WHERE (kul_son_aktivite + $zaman_asimi) > $time AND  kul_gizli_mi ='0'");
$kullanici_sayisi = mysql_num_rows($SQL);


########## GÝZLÝ ONLÝNE KULLANICILAR ÇEKÝLÝYOR 

$SQL = mysql_query("SELECT * FROM kullanicilar WHERE (kul_son_aktivite + $zaman_asimi) > $time AND  kul_gizli_mi ='1'");
$gizli_sayisi = mysql_num_rows($SQL);


########## ONLÝNE MÝSAFÝRLER  ÇEKÝLÝYOR 

$SQL = mysql_query("SELECT * FROM online_kullanicilar WHERE (kul_giris  + $zaman_asimi) > $time");
$misafir_sayisi = mysql_num_rows($SQL);


########### TOPLAM KONULAR ÇEKÝLÝYOR
$SQL = mysql_query("SELECT SUM(forum_toplam_konu)  as toplam FROM forumlar WHERE forum_tipi != 'alt' "); 
$konusay = mysql_fetch_array($SQL);

########### TOPLAM MESAJLAR ÇEKÝLÝYOR
$SQL = mysql_query("SELECT SUM(forum_toplam_mesaj)  as toplam FROM forumlar WHERE forum_tipi != 'alt' "); 
$mesajsay = mysql_fetch_array($SQL);


########### ONLÝNE REKOR ÝÇÝN DB DEN MAX ONLÝNE SAYISI ÇEKLÝYOR

if(($kullanici_sayisi + $gizli_sayisi) > $ayar["online_rekor_kisi"])
{
  $time = time();
 $toplamsay = $kullanici_sayisi + $gizli_sayisi;
 $sql = mysql_query("UPDATE ayar set
					online_rekor_kisi    ='$toplamsay',
					online_rekor_misafir = '$misafir_sayisi',
					online_rekor_tarih   ='$time'
					WHERE ayar_id='1' ");

}


########### FORUM GRUPLARI ÇEKÝLÝYOR

	$SQL      = mysql_query("select * from kul_gruplari");
	$grup_say = mysql_num_rows($SQL);
	$h = 1;
	while($GRUP = mysql_fetch_array($SQL))
	{
	
		if($h < $grup_say)
		 $GRUP["group_name"] = $GRUP["group_name"].",";
		else
		 $GRUP["group_name"] = $GRUP["group_name"];
		
		
        $template->assign_block_vars('gruprow', array(
	         'GRUP_ID'     => $GRUP["grup_id"] ,
	         'GRUP_ADI'    => $GRUP["group_name"] ,
	         'GRUP_RENK'   => $GRUP["group_color"] ,

        ));
		
	 $h ++;
	}



	     $template->assign_block_vars('onlinerow', array(
	        'KUL_SAYISI'             => $kullanici_sayisi ,
	        'GIZLI_KUL_SAYISI'       => $gizli_sayisi ,
	        'MISAFIR_KUL_SAYISI'     => $misafir_sayisi, 
	        'REKOR_MISAFIR_SAYISI'   => $ayar["online_rekor_misafir"], 
	        'REKOR_UYE_SAYISI'       => $ayar["online_rekor_kisi"], 
	        'REKOR_ZAMANI'           => forum_tarihi($ayar["online_rekor_tarih"],$ayar['sistem_zaman_dilimi']), 
            ));	  

  

// Forumda neler olýyor
$template->assign_vars(array(
	'YENI_UYE'     => $ayar["en_yeni_uye"] ,
	'YENI_UYE_ID'  => $ayar["en_yeni_uye_id"] ,
	'TOPLAM_UYE'   => $ayar["toplam_uye_sayisi"] ,
	'TOPLAM_KONU'   => $konusay["toplam"] ,
	'TOPLAM_MESAJ'  => $mesajsay["toplam"] ,
));


$template->set_filenames(array('index' => 'index.html' ));

$template->display('index');


require_once("footer.php");

?>