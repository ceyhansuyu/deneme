<?php

require_once("baslik.php");

// Kontroller

	if($_SESSION["kul_admin_yetki"] !="admin")
	{
	   header("location:sistem/cikis.php");
	   exit();
	}
	

	
@$do    = temizle($_GET["do"]);
@$islem = temizle($_GET["islem"]);

   if($do =="ayar" or $do =="")
   {

      // FORUM DURUMU   
	  if($ayar["forum_durumu"] =="acik")
	  {
	    $acik_checked = 'checked="checked"';
	    $kapali_checked = '';
	  }
	  else
	  {
	    $acik_checked = '';
	    $kapali_checked = 'checked="checked"';
	  }
	  
      // ÖZEL MESAJ DURUMU   
	  if($ayar["ozel_mesaj"] =="acik")
	  {
	    $acik_checked_pm = 'checked="checked"';
	    $kapali_checked_pm = '';
	  }
	  else
	  {
	    $acik_checked_pm = '';
	    $kapali_checked_pm = 'checked="checked"';
	  }
	  
	  
	  
      // FORUM EKSTRA SPAM SORUSU ÝÇÝN   
	  if($ayar["ekstra_spam_sorusu"] =="acik")
	  {
	    $acik_checked_spam_sorusu = 'checked="checked"';
	    $kapali_checked_spam_sorusu = '';
	  }
	  else
	  {
	    $acik_checked_spam_sorusu = '';
	    $kapali_checked_spam_sorusu = 'checked="checked"';
	  }
	  
	  
	  
	  
      // FORUM reCAPTHA ÝÇÝN   
	  if($ayar["reCAPTCHA_aktif_mi"] =="acik")
	  {
	    $acik_checked_reCAPTCHA = 'checked="checked"';
	    $kapali_checked_reCAPTCHA = '';
	  }
	  else
	  {
	    $acik_checked_reCAPTCHA = '';
	    $kapali_checked_reCAPTCHA = 'checked="checked"';
	  }
	  
	  
      // FORUM SEOSU ÝÇÝN   
	  if($ayar["seo_durum"] =="acik")
	  {
	    $acik_checked_SEO = 'checked="checked"';
	    $kapali_checked_SEO = '';
	  }
	  else
	  {
	    $acik_checked_SEO = '';
	    $kapali_checked_SEO = 'checked="checked"';
	  }
	  
			  $template->assign_vars(array(
				'DO'                         => $do, 
				'FORUM_DURUMU'               => $ayar["forum_durumu"], //TMM
				'FORUM_DURUMU_ACIK'          => $acik_checked, //TMM
				'FORUM_DURUMU_KAPALI'        => $kapali_checked, //TMM
				'FORUM_FOOTER'               => $ayar["copyright"], //tmm
				'FORUM_KAPALI_SEBEP'         => $ayar["forum_kapali_sebep"], //tmm
				'FORUM_SCRIPT_YOLU'          => $ayar["script_yolu"], //tmm
				'FORUM_COOKIE_ON_EK'         => $ayar["cookie_on_ek"], //tmm
				'FORUM_ANKET_SAYISI'         => $ayar["anket_sayisi"], //tmm
				'FORUM_CEVRIMICI_ZMN_ASIMI'  => $ayar["cevrimici_zaman_asimi"],//tmm 
				'FORUM_COOKIE_ZMN'           => $ayar["cookie_zamani"], //tmm
				'FORUM_FLOOD'                => $ayar["flood_aralik"], //tmm
				'FORUM_ARAMA_FLOOD'          => $ayar["arama_flood_aralik"], //tmm
				'FORUM_MAX_GIRIS_DENEME'     => $ayar["max_giris_deneme"], //tmm
				'FORUM_GIRIS_CEZA'           => $ayar["giris_ceza_suresi"], //tmm
				'FORUM_AKTIVASYON_YONTEMI'   => $ayar["aktivasyon_yontemi"], //tmm
				'FORUM_EMAIL'                => $ayar["board_email"], //tmm
				'FORUM_START_DATE'           => $ayar["board_startdate"], //tmm
				'FORUM_SISTEM_ZMN_DILIMI'    => $ayar["sistem_zaman_dilimi"], //tmm
				'FORUM_ZAMAN_FORMATI'        => $ayar["zaman_formati"], //tmm
				'FORUM_FORUM_DILI'           => $ayar["default_lang"], //tmm
				'FORUM_TEMASI'               => $ayar["default_style"], //tmm
				'PM_AKTIF_MI_ACIK'           => $acik_checked_pm, //tmm
				
				'PM_AKTIF_MI_KAPALI'         => $kapali_checked_pm, //tmm
				'PM_GELEN_KUTUSU'            => $ayar["gelen_kutusu"], //tmm
				'PM_GIDEN_KUTUSU'            => $ayar["ulasan_kutusu"], //tmm
				'PM_KAYDEDILEN_KUTUSU'       => $ayar["kaydedilen_kutusu"], //tmm
				'PM_SAYISI_LIMITI'           => $ayar["ozel_mesaj_limiti"], //tmm
				'FORUM_SERVER_ADI'           => $ayar["server_name"], //tmm
				'FORUM_ADI'                  => $ayar["sitename"], //tmm
				'FORUM_TARIFI'               => $ayar["site_desc"], //tmm
				'KONU_SAYFALAMA_LIMITI'      => $ayar["sayfala_limit_konu"], //tmm
				'CEVAP_SAYFALAMA_LIMITI'     => $ayar["sayfala_limit_cevap"], //tmm
				'KONU_SICAK_KONU_LIMITI'     => $ayar["sicak_konu_limit"], //tmm
				'KAYIT_UYELIK_SOZLESMESI'    => $ayar["uyelik_sozlesmesi"], //tmm
				'KAYIT_ONAY_KODU'            => $ayar["onay_kodu"], //tmm
			'KAYIT_EKSTRA_SPAM_SORUSU_ACIK'  => $acik_checked_spam_sorusu, //tmm
		'KAYIT_EKSTRA_SPAM_SORUSU_KAPALI'    => $kapali_checked_spam_sorusu, //tmm
			
				'KAYIT_EKSTRA_SPAM_SORUSU'   => $ayar["kayit_sorusu"], //tmm
			'KAYIT_EKSTRA_SPAM_SORUSU_CVP'   => $ayar["kayit_cevabi"], //tmm
			
		                    'RECAPTHA_ACIK'  => $acik_checked_reCAPTCHA, //tmm
		                  'RECAPTHA_KAPALI'  => $kapali_checked_reCAPTCHA, //tmm
				'RECAPTHA_PUBLICKEY'         => $ayar["reCAPTCHA_publickey"], //tmm
				'RECAPTHA_PRIVATEKEY'        => $ayar["reCAPTCHA_privatekey"], //tmm

			
				'ADMIN_NOTLARI'              => $ayar["admin_notu"], //tmm
				'SON_AYAR_GUNCELLEMESI'      => $ayar["son_ayar_guncelleme"], 
				'FORUM_EN_YENI_UYE'          => $ayar["en_yeni_uye"], //tmm
				'FORUM_EN_YENI_UYE_ID'       => $ayar["en_yeni_uye_id"], //tmm
				'FORUM_TOPLAM_UYE_SAYISI'    => $ayar["toplam_uye_sayisi"], //tmm
				'FORUM_SEO_DURUM'            => $ayar["seo_durum"], //tmm
				'FORUM_SEO_ACIK'             => $acik_checked_SEO, //tmm
				'FORUM_SEO_KAPALI'           => $kapali_checked_SEO, //tmm
				
				));
   }// do = ayar içindi
   else if ($do =="gruplar" and $islem =="")
   {
      $template->assign_vars(array('DO' => $do,'ISLEM' => $islem, ));
	  
	  $SQL = mysql_query("SELECT * FROM kul_gruplari ORDER BY grup_id ASC");
   
      while ($row = mysql_fetch_array($SQL) ){///dýþ while

		$template-> assign_block_vars('gruprow', array(
		'GRUP_ID'         => $row["grup_id"],
		'GRUP_ADI'        => $row["group_name"],
		'GRUP_DESC'       => $row["group_desc"],
		'GRUP_RUTBE'      => $row["group_rutbesi"],
		'GRUP_RUTBE_IMG'  => $row["group_rutbe_resmi"],
		'GRUP_RENK'       => $row["group_color"],
		
		));
		
		
      }//while dýþ
	  
	  	          /// GRUP RÜTBE RESÝMLERÝ
			$klasor = "../resim/rutbe";
			$handle= opendir($klasor);
			while ($file = readdir($handle)) // while iç
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
					  $template->assign_block_vars('rutberow',array(
					  'FILE'  => $file,
					  'IMG_SRC' => $klasor."/".$file,

					  ));  
				  }// if bitti

			}/// while iç bitti

			/// GRUP RÜTBE RESÝMLERÝ // Son
	  

  
	  
   }//do gruplar
   else if ($do =="gruplar" and $islem=="guncelle")
   {
	 $grup_ID = temizle($_GET["grupID"]);
	 
	 $sql = mysql_query("select * from kul_gruplari where grup_id='".$grup_ID."'");
	 $row = mysql_fetch_array($sql);
	 
      $template->assign_vars(array(
						'DO'    => $do,
						'ISLEM' => $islem,
						'GRUP_ID'         => $row["grup_id"],
						'GRUP_ADI'        => $row["group_name"],
						'GRUP_DESC'       => $row["group_desc"],
						'GRUP_RUTBE'      => $row["group_rutbesi"],
						'GRUP_RUTBE_IMG'  => $row["group_rutbe_resmi"],
						'GRUP_RENK'       => $row["group_color"],
		));

	 
	 
	          /// GRUP RÜTBE RESÝMLERÝ
			$klasor = "../resim/rutbe";
			$handle= opendir($klasor);
			while ($file = readdir($handle)) // while iç
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
					  $template->assign_block_vars('rutberow',array(
					  'FILE'  => $file,
					  'SELECTED'  => ($file == $row["group_rutbe_resmi"]) ? "selected='selected'":"",
					  'IMG_SRC' => $klasor."/".$file,

					  ));  
				  }// if bitti

			}/// while iç bitti

			/// GRUP RÜTBE RESÝMLERÝ // Son
			
   }//$do =="gruplar" and $islem=="guncelle") son
   
   else if ($do =="forum_yonet" and $islem=="")
   {
     $template->assign_vars(array('DO' => $do,'ISLEM' => $islem, ));
	 
	 $sql = mysql_query("select * from kategoriler order by sirala desc");
	 
	 while($kat = mysql_fetch_array($sql))
	 {// EN DIÞ WHÝLE
       ///categoriler tema motoruna ekliyoruz
       $template->assign_block_vars('catrow', array(
       'KAT_ADI'       => $kat["kat_title"],
	   'KAT_ID'        => $kat["kat_id"],
	   'SIRALAMA'      => $kat["sirala"],
	   ));	 
	 
	   $sql_forum = mysql_query("select * from forumlar 
								where  kat_id ='".$kat["kat_id"]."' 
								and  forum_tipi !='alt' order by sirala desc ");
								
		    while($forum = mysql_fetch_array($sql_forum))
			{
				   ///forumlar tema motoruna ekliyoruz
				   $template->assign_block_vars('catrow.forumrow', array(
				   'FORUM_ADI'      => empty($forum["forum_adi"]) ? $forum["forum_link_adi"]:$forum["forum_adi"],
				   'FORUM_ID'       => $forum["forum_id"],
				   'SIRALAMA'       => $forum["sirala"],
				   'LINK_MI'        => ($forum["forum_link_mi"] =="evet") ? true:false,
				   ));
				   
				   $sql_alt_forum = mysql_query("select * from forumlar 
								where   forum_ust_f  ='".$forum["forum_id"]."' 
								and  forum_tipi ='alt' order by sirala desc");
					
					while($alt_forum = mysql_fetch_array($sql_alt_forum))
					{
						   ///Alt forumlar tema motoruna ekliyoruz
						   $template->assign_block_vars('catrow.forumrow.altrow', array(
						   'FORUM_ADI'      => $alt_forum["forum_adi"],
						   'FORUM_ID'       => $alt_forum["forum_id"],
						   'SIRALAMA'       => $alt_forum["sirala"],
						   ));
					}
			
			}
	 
	 }//EN DIÞ WHÝLE SON
   }
   else if ($do =="forum_ekle" and $islem=="")
   {
    $gelenkatID   = @$_GET["katID"];
    $gelenforumID = @$_GET["forumID"];
   
     $template->assign_vars(array('DO' => $do,'ISLEM' => $islem, ));
	 
	 $sql = mysql_query("select * from kategoriler order by sirala desc");
					
					while($kategori = mysql_fetch_array($sql))
					{
						   ///Alt forumlar tema motoruna ekliyoruz
						   $template->assign_block_vars('catrow', array(
						    'KAT_ADI'      => $kategori["kat_title"],
						    'KAT_ID'       => $kategori["kat_id"],
						    'SELECTED'     => ($kategori["kat_id"] == $gelenkatID) ? 'selected="selected"' :"",
						   ));
						   
						$sqlforum = mysql_query("select * from forumlar 
						where kat_id ='".$kategori["kat_id"]."' 
						and forum_link_mi ='hayir' 
						and  forum_tipi !='alt' 
						order by sirala desc");
						
						while($forum = mysql_fetch_array($sqlforum))
						{
							   ///Alt forumlar tema motoruna ekliyoruz
							   $template->assign_block_vars('catrow.forumrow', array(
								'FORUM_ADI'      => $forum["forum_adi"],
								'FORUM_ID'       => $forum["forum_id"],
						        'SELECTED'     => ($forum["forum_id"] == $gelenforumID) ? 'selected="selected"' :"",
							   ));
						}
		
					}
		

		
	 
   }
   // FORUM DÜZENLEME
   else if ($do =="forum_duzenle" and $islem=="")
   {
    $gelenkatID   = @$_GET["katID"];
    $gelenforumID = @$_GET["forumID"];
   
     $template->assign_vars(array('DO' => $do,'ISLEM' => $islem, ));
	 
	 $sql = mysql_query("select * from kategoriler order by sirala desc");
					
					while($kategori = mysql_fetch_array($sql))
					{
						   ///Alt forumlar tema motoruna ekliyoruz
						   $template->assign_block_vars('catrow', array(
						    'KAT_ADI'      => $kategori["kat_title"],
						    'KAT_ID'       => $kategori["kat_id"],
						    'SELECTED'     => ($kategori["kat_id"] == $gelenkatID) ? 'selected="selected"' :"",
						   ));
						   
						$sqlforum = mysql_query("select * from forumlar 
						where kat_id ='".$kategori["kat_id"]."' 
						and forum_link_mi ='hayir' 
						and  forum_tipi !='alt' 
						order by sirala desc");
						
						while($forum = mysql_fetch_array($sqlforum))
						{
							   ///Alt forumlar tema motoruna ekliyoruz
							   $template->assign_block_vars('catrow.forumrow', array(
								'FORUM_ADI'      => $forum["forum_adi"],
								'FORUM_ID'       => $forum["forum_id"],
						        'SELECTED'     => ($forum["forum_id"] == $gelenforumID) ? 'selected="selected"' :"",
							   ));
						}
		
					}
		
	 
	 
	 
	 
	 
	 
	 
	 
	 
	// EÐER FORUM ÝD SÝ DOLUYSA
	if(!empty($gelenforumID))
	{
		$sql   = mysql_query("select * from forumlar where forum_id ='".$gelenforumID."'");
        $forum = mysql_fetch_array($sql);
		
		$template->assign_vars(array(
										'FORUM_ADI'    => $forum["forum_adi"],
										'FORUM_TARIFI' => $forum["forum_tarifi"],
										'FORUM_RESMI'  => $forum["forum_resmi"],
										'FORUM_TARIFI2' => $forum["forum_adi"], 
									));
		 
	}
	
	
	// EÐER KATEGORÝ ÝD SÝ DOLUYSA
	if(!empty($gelenkatID))
	{
		$sql   = mysql_query("select * from kategoriler where kat_id ='".$gelenkatID."'");
        $kat = mysql_fetch_array($sql);
		
		$template->assign_vars(array(
										'KAT_ADI'    => $kat["kat_title"],
										'KAT_TARIFI' => $kat["kat_desc"],
									));
		 
	}
	 
   
   }



$template->set_filenames(array('index' => 'index.html' ));

$template->display('index');

?>