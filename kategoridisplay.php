<?php
require_once("genel.php");

	if($ayar["seo_durum"] =="acik")
	{
     
	  $katid = explode($ayar["script_yolu"],$_SERVER['REQUEST_URI']);
	  $katidbul = explode("-",$katid[1]);
	  $katidsi = explode("k",$katidbul[0]);
	  $kid =  $katidsi[1];
	}
	else
	{
	  $kid = k_id_temizle($_GET['k']);
	}



	//SAYFA DETAYLARI
	    $SQL = mysql_query("SELECT * FROM kategoriler
                   WHERE kat_id=".$kid."");
        $row = mysql_fetch_array($SQL);
	
	    $baslik= " - ".$row["kat_title"];
	    $menu = '<a href="index.php">Anasayfa</a> > '.$row["kat_title"].' ';
	
		$sayfa_url ="kategoridisplay.php?k=".$kid;
		// Kullanýcý koordinat
		kul_koordinat($baslik ,$sayfa_url);
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,	
			'SEO_AKTIFSE'       => ($ayar["seo_durum"] =="acik") ? true:false,
	
		));
		unset($SQL);
    //SAYFA DETAYLARI
	require_once("baslik.php");


	// Çaðrýlan Kategoriye gidiyoruz
	$SQL = mysql_query("SELECT * FROM kategoriler WHERE kat_id =".$kid." "); 
	$katrow = mysql_fetch_array($SQL);

	//Kategori adýný temaya koyalým.
	$template->assign_vars(array( 'KATEGORI'     => $katrow["kat_title"] ));

	unset($SQL);

	$SQL = mysql_query("SELECT * FROM forumlar WHERE kat_id =".$kid." and forum_tipi = '' "); 

	while($forum  = mysql_fetch_array($SQL)){ ///////////////iç while
	
	
//////////////////// FORUM OKUNDUMU ?  OKUNMADIMI? HEMEN BULALIM  ////////////////////
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
				  if($forum['forum_son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
					{
						$resim ="forum_new.png";
						//$baslik_konu = "<b>".$forum["konu_baslik"]."</b>";
			
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
	
	  ///categoriler tema motoruna ekliyoruz
       $template->assign_block_vars('forumrow', array(
       'FORUMLAR'  			=> $forum["forum_adi"],
       'FORUMLAR_SEO'  		=> seo($forum["forum_adi"]),
	   'DESC'     		    => $forum["forum_tarifi"],
	   'F_ID'               => $forum["forum_id"],
	   'ALT_FORUM_VAR'      => ($alt_forum_say > 0) ? true : false ,
	   'TOPLAM_KONU'        => $forum["forum_toplam_konu"],
	   'TOPLAM_MESAJ'       => $forum["forum_toplam_mesaj"],
	   'SON_MESAJ'     	    => substr($forum["forum_son_mesaj_title"],0,20)."...",
	   'SON_MESAJ_ID'  	    => $forum["forum_son_mesaj_id"],
	   'SON_MESAJ_KONU_ID'  => $forum["forum_son_mesaj_konu_id"],
       'SON_MESAJ_YAZAR' 	=> $forum["forum_son_mesaj_kul"],
       'SON_MESAJ_YAZAR_ID' => $forum["forum_son_mesaj_kul_id"],
       'SON_MESAJ_YAZAR_RENK' => kul_group_color($forum["forum_son_mesaj_kul_id"]),
       'SON_MESAJ_ZAMAN' 	=> tarih($forum["forum_son_mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
       'SON_MESAJ_SAYFASAY' => sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala),
	   'FORUM_BOS'   		=> empty($forum["forum_toplam_konu"] ) ? true : false ,
	   'FORUM_RESIM'        => @$resim,
	   'LINK_MI'	          => ($forum["forum_link_mi"] =="evet")? true:false,
       'LINK_ADI'	          => $forum["forum_link_adi"],
       'LINK_ID'	          => $forum["forum_id"],
       'LINK_ACIKLAMA'	      => $forum["forum_link_aciklama"],
       'LINK_URL'	          => $forum["forum_link_url"],
       'LINK_SAYAC'	          => (!empty($forum["forum_link_sayac"])) ? $forum["forum_link_sayac"]:"0",
  
	   
	   ));
	         
			// Alt forumlarý listele
			while($altforum  = mysql_fetch_array($alt_forum_sql))
			{ ////// ENN iç while
			
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
							//echo "yeni mesaj var " .$row["konu_baslik"];
							$resim ="subforum_new.png";
							//$baslik_konu = "<b>".$forum["konu_baslik"]."</b>";

						}
					else
						{
							$resim ="subforum_old.png";
							//$baslik_konu = $forum["konu_baslik"];
						}

				 }
				 else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA :)
				 {
				  if($altforum['forum_son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
					{
						$resim ="subforum_new.png";
						//$baslik_konu = "<b>".$forum["konu_baslik"]."</b>";
			
					}
				 }
			  
			  ############### ALT FORUM OKUNDU SON ###############
			  
			  
			
				///Alt forumlarý tema motoruna ekliyoruz
				$template->assign_block_vars('forumrow.altrow', array(
				   'ALT_FORUM_ADI'  => $altforum["forum_adi"],
				   'ALT_FORUM_ADI_SEO'  => seo($altforum["forum_adi"]),
				   'ALT_F_ID'      => $altforum["forum_id"]	,		   
				   'FORUM_RESIM'      => $resim				   
				));

			} //ENN iç while son
	  }//iç while son



$template->set_filenames(array('kategoridisplay' => 'kategoridisplay.html' ));

$template->display('kategoridisplay');


require_once("footer.php");
////////*/
?>