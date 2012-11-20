<?php
require_once("genel.php");
require_once("sistem/pagination.class.php");
include("similies.php");
include("sistem/BBcode.parser.class.php");
$bbcode = new Parser;

$yap = @temizle($_GET["do"]);
$pm_id = @temizle($_GET["pm_id"]);
$sayfa1 = @temizle($_GET["sayfa"]);
$kul_id = @kullanici_temizle_ana_dizin($_GET["u"]);

	// Ýstenmeyen durumlara karþýn.
	if (@$_SESSION['kul'] =="misafir")
	{
			header("location:index.php");
			exit();
	}
	// Ýstenmeyen durumlara karþýn. Son
	
	
	
	//SAYFA DETAYLARI
	  $menu = '<a href="index.php">Anasayfa</a> > 
            <a href="ozel_mesaj.php"> Özel Mesaj</a>';
	
	  
	$baslik= " - Özel Mesaj";
	$sayfa_url = "ozel_mesaj.php";
	// Kullanýcý koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullanýcý koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,	
		));
    //SAYFA DETAYLARI
	require_once("baslik.php");
	
	
	
   //  GELEN KUTUSUNDAN ÖZEL MESAJI OKUYALIM //
   
   if($pm_id !="" and $yap =="gelen")
   {
     $pm_id = temizle($pm_id);
	 
     $SQL = mysql_query("SELECT * FROM ozel_mesaj 
						WHERE kime_gonderdi ='".$_SESSION['kul']."' and id=".$pm_id."");
     $pm = mysql_fetch_array($SQL);
	 
	////////// ÖZEL MESAJ OKUNDU BAÞLADI
	
	 $time = time();
	 $SQL_guncelle = mysql_query("UPDATE ozel_mesaj set  
									okunma_zamani ='$time' 
									WHERE id=".$pm_id."");
  
	
	
     $SQL_kul = mysql_query("SELECT * FROM kullanicilar WHERE kul_id='".$pm["kim_gonderdi_id"]."'");
	 $row = mysql_fetch_array($SQL_kul);
	 
	  // KULLANICI ONLÝNE MÝ?
	 
		if((($row['kul_son_aktivite'] + $ayar["cevrimici_zaman_asimi"]) > time() ) and
			($row['kul_son_sayfa'] != 'sistem/cikis.php'))
		{
		 $mesaj_yazar_durum = '<font color="#339900">Online</font>';
		}
		else
		{
		 $mesaj_yazar_durum = '<font color="#CC0000">Offline</font>';

		}
	 
	 $template->assign_vars(array(			
			'PM_ID'             => $pm["id"],
		    'GONDEREN'          => $pm["kim_gonderdi"],
			'GONDEREN_ID'       => $pm["kim_gonderdi_id"],
			'GONDEREN_AVATAR'   => ($row["kul_avatar"]=="")? "resim/avatar_yok.png":$row["kul_avatar"],
			'GONDEREN_GRUP'     => $row["kul_grup_name"],
			'GONDEREN_ONLINE'   => $mesaj_yazar_durum,
			'GONDERILEN'        => $pm["kime_gonderdi"],
			'GONDERILEN_ID'     => $pm["kime_gonderdi_id"],
			'MESAJ_BASLIK'      => $pm["mesaj_baslik"],
			'MESAJ_IKON'        => "<img src='".$pm["mesaj_ikon"]."' alt='' title=''/>",
			'MESAJ_GOVDE'       => $bbcode-> bb_to_html(stripslashes($pm["mesaj_govde"])),
			'GONDERME_ZAMANI'   => forum_tarihi($pm["gonderme_zamani"],$ayar['sistem_zaman_dilimi']),
			'MESAJ_OKUNDU_IMG'  => (empty($pm["okunma_zamani"])) ? "pm_new.png":"pm_old.png",
			'MESAJ_OKUNDU_IMG_VAR'  => (!empty($pm["mesaj_ikon"])) ? true:false,
	        'PM_OKU_GELEN'         => true,
			
	 ));
   
   }
   else
   {
	 $template->assign_vars(array(			
	   'PM_OKU_GELEN'         => false,
	 ));
   
   }
   
   
 //  GÝDEN KUTUSUNDAN ÖZEL MESAJI OKUYALIM //
   
   if($pm_id !="" and $yap =="giden")
   {
     $pm_id = temizle($pm_id);
	 
     $SQL = mysql_query("SELECT * FROM ozel_mesaj 
						WHERE kim_gonderdi_id ='".$_SESSION['kul_id']."' AND id=".$pm_id."");
     $pm = mysql_fetch_array($SQL);
	 

	
	
     $SQL_kul = mysql_query("SELECT * FROM kullanicilar WHERE kul_id='".$pm["kime_gonderdi_id"]."'");
	 $row = mysql_fetch_array($SQL_kul);
	 
	  // KULLANICI ONLÝNE MÝ?
	 
		if((($row['kul_son_aktivite'] + $ayar["cevrimici_zaman_asimi"]) > time() ) and
			($row['kul_son_sayfa'] != 'sistem/cikis.php'))
		{
		 $mesaj_yazar_durum = '<font color="#339900">Online</font>';
		}
		else
		{
		 $mesaj_yazar_durum = '<font color="#CC0000">Offline</font>';

		}
	 
	 $template->assign_vars(array(			
			'PM_ID'             => $pm["id"],
		    'GONDEREN'          => $pm["kim_gonderdi"],
			'GONDEREN_ID'       => $pm["kim_gonderdi_id"],
			'GONDEREN_AVATAR'   => ($row["kul_avatar"]=="")? "resim/avatar_yok.png":$row["kul_avatar"],
			'GONDEREN_GRUP'     => $row["kul_grup_name"],
			'GONDEREN_ONLINE'   => $mesaj_yazar_durum,
			'GONDERILEN'        => $pm["kime_gonderdi"],
			'GONDERILEN_ID'     => $pm["kime_gonderdi_id"],
			'MESAJ_BASLIK'      => $pm["mesaj_baslik"],
			'MESAJ_IKON'        => "<img src='".$pm["mesaj_ikon"]."' alt='' title=''/>",
			'MESAJ_GOVDE'       => $bbcode-> bb_to_html(stripslashes($pm["mesaj_govde"])),
			'GONDERME_ZAMANI'   => forum_tarihi($pm["gonderme_zamani"],$ayar['sistem_zaman_dilimi']),
			'MESAJ_OKUNDU_IMG'  => (empty($pm["okunma_zamani"])) ? "pm_new.png":"pm_old.png",
			'MESAJ_OKUNDU_IMG_VAR'  => (!empty($pm["mesaj_ikon"])) ? true:false,
	        'PM_OKU_GIDEN'         => true,
			
	 ));
   
   }
   else
   {
	 $template->assign_vars(array(			
	   'PM_OKU_GIDEN'         => false,
	 ));
   
   }
   
   //GÝDEN KUTUSUNDAN PM OKUMA SON
   
	
	// do= temizliði yanlýþ bir deðer girilirse direkt profil_detaya gönderme
	/*if($yap =="" or is_numeric($yap)) 
	$yap ="profil_detay";
	
	*/
	if($yap !="yeni_ozel_mesaj" and $yap !="gelen" and $yap !="giden" and $yap !="yeni_klasor" and $yap !="alinti" and $yap !="klasor") 
	$yap ="";
	
	
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
	
	//temalara gerekli verileri çekmek için
	$template->assign_vars(array('DO'  => $yap ));
		
    // Eðer mesaj gönderilecek kul_id si url 'de belirtilmiþ ise kul_adi ni bulalým.
	$SQL_for_kul = mysql_query("SELECT * FROM kullanicilar WHERE kul_id='".$kul_id."'");
	$kul_fetch = mysql_fetch_array($SQL_for_kul);
	
		if($yap =="yeni_ozel_mesaj")
		{

			$template->assign_vars(array(			
			'DO'             => $yap,
			'GONDER_KUL_ID'  => (!empty($kul_fetch["kul_adi"])) ? $kul_fetch["kul_adi"] : "", // Baþka bir sayfadan u= kul_idsi
			
		  ));

		}//yeni özel mesaj

		else if($yap =="gelen")
		{
///////////////////////// SAYFALAMA BAÞLADI ///////////	
			$kackayit = $ayar["sayfala_limit_konu"];
			$sayfa = 1;
			
			if(isset($sayfa1) and is_numeric($sayfa1) and $sayfa = $sayfa1)
					$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
				else
					$limit = " LIMIT $kackayit";
			
			
			$SQLCEK = "SELECT * FROM ozel_mesaj 
								WHERE kime_gonderdi ='".$_SESSION['kul']."'
								and  alanin_kutusu ='gelen'
								ORDER BY  gonderme_zamani DESC";

			$kayitSay = mysql_num_rows(mysql_query($SQLCEK));

			$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
			$SQL   = mysql_query($SQLCEK.$limit);
			
				
	        // SAYFALAMA PAREMETRELERÝ
			$p = new pagination;
			$p->Items($kayitSay);
			$p->limit($kackayit);
			$p->target("ozel_mesaj.php?do=gelen");
			$p->currentsayfa($sayfa);
			$p->calculate();
			$p->changeClass("pagination");
			//$p->show();
			
		if($kayitSay > $ayar["sayfala_limit_konu"])
	        {
			   $template->assign_vars(array( 'SAYFALAMA'  =>  $p->show() ));
			}
			else
			{
			   $template->assign_vars(array( 'SAYFALAMA'  =>  "" ));
			}

			
			
			$pm_say = $kayitSay ;			
			
			while($pm = mysql_fetch_array($SQL))
			{
			    
	             ////////// ÖZEL MESAJ OKUNDU BAÞLADI
				 
				 if(!empty($_COOKIE[$ayar["cookie_on_ek"].'om_okundu']))
				 {
				       $bul= preg_match('/-'.$pm["id"].'_/', $_COOKIE[$ayar["cookie_on_ek"].'om_okundu'] ); 
		
                       if($bul == true)
					     $pm["mesaj_baslik"] = $pm["mesaj_baslik"];
					   else
	                    $pm["mesaj_baslik"] ="<b>".$pm["mesaj_baslik"]."</b>";
		 
				 }
				 	  
	             ////////// ÖZEL MESAJ OKUNDU BÝTTÝ
				 
				 
				/// pmrow tema motoruna ekliyoruz
				$template-> assign_block_vars('pmrow', array(
					'PM_ID'             => $pm["id"],
					'GONDEREN'          => $pm["kim_gonderdi"],
					'GONDEREN_ID'       => $pm["kim_gonderdi_id"],
					'GONDERILEN'        => $pm["kime_gonderdi"],
					'GONDERILEN_ID'     => $pm["kime_gonderdi_id"],
					'MESAJ_BASLIK'      => $pm["mesaj_baslik"],
					'MESAJ_IKON'        => "<img src='".$pm["mesaj_ikon"]."' alt='' title=''/>",
					'MESAJ_GOVDE'       => $pm["mesaj_govde"],
					'GONDERME_ZAMANI'   => forum_tarihi($pm["gonderme_zamani"],$ayar['sistem_zaman_dilimi']),
					'MESAJ_OKUNDU_IMG'  => (empty($pm["okunma_zamani"])) ? "pm_new.png":"pm_old.png",
					'MESAJ_OKUNDU_IMG_VAR'  => (!empty($pm["mesaj_ikon"])) ? true:false,
				));
			
			}
		  
		  $template->assign_vars(array(
			'EMAIL'     => $kul["kul_email"] ,
			'DO'        => $yap,
			'PM_VAR'            => ($pm_say > 0) ? true:false,		  
			));

		}//gelen kutusu
		else if($yap =="giden")
		{

			///////////////////////// SAYFALAMA BAÞLADI ///////////	
			$kackayit = $ayar["sayfala_limit_konu"];
			$sayfa = 1;
			
			if(isset($sayfa1) and is_numeric($sayfa1) and $sayfa = $sayfa1)
					$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
				else
					$limit = " LIMIT $kackayit";
			
			
			$SQLCEK = "SELECT * FROM ozel_mesaj 
										WHERE  kim_gonderdi_id  ='".$_SESSION['kul_id']."'
										and gonderenin_kutusu ='giden'
										ORDER BY  gonderme_zamani DESC";

			$kayitSay = mysql_num_rows(mysql_query($SQLCEK));

			$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
			$SQL   = mysql_query($SQLCEK.$limit);
			
				
	        // SAYFALAMA PAREMETRELERÝ
			$p = new pagination;
			$p->Items($kayitSay);
			$p->limit($kackayit);
			$p->target("ozel_mesaj.php?do=giden");
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

			
			
			$pm_say = $kayitSay ;
			
			while($pm = mysql_fetch_array($SQL))
			{
				 
				 
				 /// pmrow tema motoruna ekliyoruz
				$template-> assign_block_vars('pmrow', array(
					'PM_ID'             => $pm["id"],
					'GONDEREN'          => $pm["kim_gonderdi"],
					'GONDEREN_ID'       => $pm["kim_gonderdi_id"],
					'GONDERILEN'        => $pm["kime_gonderdi"],
					'GONDERILEN_ID'     => $pm["kime_gonderdi_id"],
					'MESAJ_BASLIK'      => $pm["mesaj_baslik"],
					'MESAJ_IKON'        => "<img src='".$pm["mesaj_ikon"]."' alt='' title=''/>",
					'MESAJ_GOVDE'       => $pm["mesaj_govde"],
					'GONDERME_ZAMANI'   => forum_tarihi($pm["gonderme_zamani"],$ayar['sistem_zaman_dilimi']),
					'MESAJ_OKUNDU_IMG'  => (empty($pm["okunma_zamani"])) ? "pm_new.png":"pm_old.png",
					'MESAJ_OKUNDU_IMG_VAR'  => (!empty($pm["mesaj_ikon"])) ? true:false,
				));
			
			}
		  
		  $template->assign_vars(array(
			'EMAIL'     => $kul["kul_email"] ,
			'DO'        => $yap,
			'PM_VAR'            => ($pm_say > 0) ? true:false,		  
			));
		

		}//giden kutusu
		
		
		else if($yap =="klasor")
		{
            $klasorID = klasor_id_temizle($_GET["klasorID"]);
			
			$template->assign_vars(array( 'KLASORUN_IDSI'  => $klasorID ));

			///////////////////////// SAYFALAMA BAÞLADI ///////////	
			$kackayit = $ayar["sayfala_limit_konu"];
			$sayfa = 1;
			
			if(isset($sayfa1) and is_numeric($sayfa1) and $sayfa = $sayfa1)
					$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
				else
					$limit = " LIMIT $kackayit";
			
			
			$SQLCEK = "SELECT * FROM ozel_mesaj 
										WHERE  gonderen_klasorID =".$klasorID."
										or alan_klasorID =".$klasorID."
								
										ORDER BY  gonderme_zamani DESC";

			$kayitSay = mysql_num_rows(mysql_query($SQLCEK));

			$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
			$SQL   = mysql_query($SQLCEK.$limit);
			
				
	        // SAYFALAMA PAREMETRELERÝ
			$p = new pagination;
			$p->Items($kayitSay);
			$p->limit($kackayit);
			$p->target("ozel_mesaj.php?do=klasor&klasorID=".$klasorID."");
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

			
			
			$pm_say = $kayitSay ;
			
			while($pm = mysql_fetch_array($SQL))
			{
				 
				 
				 /// pmrow tema motoruna ekliyoruz
				$template-> assign_block_vars('pmrow', array(
					'PM_ID'             => $pm["id"],
					'GONDEREN'          => $pm["kim_gonderdi"],
					'GONDEREN_ID'       => $pm["kim_gonderdi_id"],
					'OKUNACAKYER'       => ($pm["kim_gonderdi_id"] == $_SESSION["kul_id"])? "giden":"gelen",
					'GONDERILEN'        => $pm["kime_gonderdi"],
					'GONDERILEN_ID'     => $pm["kime_gonderdi_id"],
					'MESAJ_BASLIK'      => $pm["mesaj_baslik"],
					'MESAJ_IKON'        => "<img src='".$pm["mesaj_ikon"]."' alt='' title=''/>",
					'MESAJ_GOVDE'       => $pm["mesaj_govde"],
					'GONDERME_ZAMANI'   => forum_tarihi($pm["gonderme_zamani"],$ayar['sistem_zaman_dilimi']),
					'MESAJ_OKUNDU_IMG'  => (empty($pm["okunma_zamani"])) ? "pm_new.png":"pm_old.png",
					'MESAJ_OKUNDU_IMG_VAR'  => (!empty($pm["mesaj_ikon"])) ? true:false,
				));
			
			}
		  
		  $template->assign_vars(array(
			'EMAIL'     => $kul["kul_email"] ,
			'DO'        => $yap,
			'PM_VAR'            => ($pm_say > 0) ? true:false,		  
			));
		

		}//klasör kutusu
		
		else if($yap =="yeni_klasor")
		{
			$SQL = mysql_query("SELECT * FROM ozel_mesaj_klasor 
			                   WHERE kul_ID ='".$_SESSION['kul_id']."' order by klasorID desc");		
		   
		   while($klasor = mysql_fetch_array($SQL))
			{
			    /// Klasör hangi renkse o renk görünsün
				
				if($klasor["klasor_resim"] =="beyaz.png")
				{
				  $selected_beyaz ='selected="selected"';
				  $selected_sari ='';
				  $selected_mavi ='';
				  $selected_yesil ='';
				  $selected_kirmizi ='';
				}
				else if($klasor["klasor_resim"] =="sari.png")
				{
				  $selected_beyaz ='';
				  $selected_sari ='selected="selected"';
				  $selected_mavi ='';
				  $selected_yesil ='';
				  $selected_kirmizi ='';
				}				
				else if($klasor["klasor_resim"] =="mavi.png")
				{
				  $selected_beyaz ='';
				  $selected_sari ='';
				  $selected_mavi ='selected="selected"';
				  $selected_yesil ='';
				  $selected_kirmizi ='';
				}
				else if($klasor["klasor_resim"] =="yesil.png")
				{
				  $selected_beyaz ='';
				  $selected_sari ='';
				  $selected_mavi ='';
				  $selected_yesil ='selected="selected"';
				  $selected_kirmizi ='';
				}
				else if($klasor["klasor_resim"] =="kirmizi.png")
				{
				  $selected_beyaz ='';
				  $selected_sari ='';
				  $selected_mavi ='';
				  $selected_yesil ='';
				  $selected_kirmizi ='selected="selected"';
				}
			
			
			     /// klasorrow tema motoruna ekliyoruz
				$template-> assign_block_vars('klasorrow', array(
					'KLASOR_ID'     => $klasor["klasorID"],
					'KUL_ID'        => $klasor["kul_ID"],
					'KLASOR_ADI'    => $klasor["klasor_adi"],
					'KLASOR_RESIM'  => $klasor["klasor_resim"],
					'KLASOR_BEYAZ'  => $selected_beyaz,
					'KLASOR_SARI'   => $selected_sari,
					'KLASOR_MAVI'   => $selected_mavi,
					'KLASOR_YESIL'  => $selected_yesil,
					'KLASOR_KIRMIZI'=> $selected_kirmizi,
				));
			}// While klasör son

		}//yeni klasör
		else if($yap =="alinti")
		{
		  $pmID = temizle($_GET["pmID"]);
		  
		  // ÖNCELÝKLE PM ID DEN PM VERÝLERÝNÝ ÇEKÝYORUZ
		  $SQL = mysql_query("SELECT * FROM ozel_mesaj WHERE id =".$pmID."");
		  $pm = mysql_fetch_array($SQL);
		  
		  $template->assign_vars(array(
			 'GONDEREN'    => $pm["kim_gonderdi"],
			 'PMBASLIK'    => $pm["mesaj_baslik"],
			 'PMGOVDE'    => stripslashes($pm["mesaj_govde"]),

			 'DO'        => $yap,
			));
		
		}

		
////////////  EKLEDÝÐÝMÝZ KLASÖRLERÝ MENÜYE DE EKLEYELÝM.
    $SQL_menu = mysql_query("SELECT * FROM ozel_mesaj_klasor 
			                 WHERE kul_ID ='".$_SESSION['kul_id']."' order by klasorID desc");		
	 while($menu_klasor = mysql_fetch_array($SQL_menu))
		{
			// KLASASORE AIT MESAJ VAR MI BULALIM
			$SQL_KLASOR = mysql_query("SELECT * FROM ozel_mesaj 
			              WHERE gonderen_klasorID ='".$menu_klasor["klasorID"]."' or alan_klasorID ='".$menu_klasor["klasorID"]."'");
			$ait_mesaj_say = mysql_num_rows($SQL_KLASOR);
			
			//KLASÖRDEKÝ MESAJ SAYISINI GÜNCELLEYELÝM.
			$strSQL = mysql_query("update ozel_mesaj_klasor
								 set icerdigi_mesaj_say ='$ait_mesaj_say'
								where klasorID ='".$menu_klasor["klasorID"]."'");
		  
		  
			    /// klasorrow tema motoruna ekliyoruz
				$template-> assign_block_vars('menu_klasorrow', array(
					'KLASOR_ID'         => $menu_klasor["klasorID"],
					'KUL_ID'            => $menu_klasor["kul_ID"],
					'KLASOR_ADI'        => $menu_klasor["klasor_adi"],
					'KLASOR_RESIM'      => $menu_klasor["klasor_resim"],
					'KLASOR_MESAJ_SAY'  => ($ait_mesaj_say > 0)? $ait_mesaj_say : "0",
				));
		}// While menu_klasor son   

		
		
/////// GELEN VE GÝDEN  KUTUSUNU BÝR HESAPLAYALIM.
  
	$SQL_gelen = mysql_query("SELECT * FROM ozel_mesaj 
								WHERE  kime_gonderdi  ='".$_SESSION['kul']."'
								and  alanin_kutusu ='gelen'");
	$gelen_say = mysql_num_rows($SQL_gelen);	
	
	$SQL_giden = mysql_query("SELECT * FROM ozel_mesaj 
								WHERE  kim_gonderdi_id  ='".$_SESSION['kul_id']."'
								and   gonderenin_kutusu  ='giden'");
	$giden_say = mysql_num_rows($SQL_giden);
	

// KLASASORE AIT MESAJ VAR MI BULALIM

	$klasordekimesajlar = mysql_query("SELECT SUM(icerdigi_mesaj_say) as total FROM ozel_mesaj_klasor
	                                WHERE   kul_ID  ='".$_SESSION['kul_id']."'");	
	
        		
			$klasor_mesaj = mysql_fetch_array($klasordekimesajlar);

	        $klasordeki_mesajlar_say = $klasor_mesaj["total"] ;

	$template->assign_vars(array(
	    'TOPLAM_GELEN_SAY'     => $gelen_say,
	    'TOPLAM_GIDEN_SAY'     => $giden_say ,
	    'TOPLAM_KLASORDE_SAY'  => $klasordeki_mesajlar_say ,
	    'TOPLAM_SAY'           => $giden_say + $gelen_say + $klasordeki_mesajlar_say,
	    'AYAR_PM_LIMIT'        => $ayar["ozel_mesaj_limiti"],
	    'YUZDE_ORAN_PM'        => (($gelen_say + $giden_say + $klasordeki_mesajlar_say) / $ayar["ozel_mesaj_limiti"]) * 100,

		));
		


$template->set_filenames(array('ozel_mesaj' => 'ozel_mesaj.html' ));

$template->display('ozel_mesaj');

require_once("footer.php");




?>