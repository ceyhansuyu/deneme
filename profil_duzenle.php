<?php
require_once("genel.php");
require_once("sistem/pagination.class.php");

$yap = @temizle($_GET["do"]);


	// Ýstenmeyen durumlara karþýn.
	if ($_SESSION['kul'] =="misafir")
	{
			header("location:index.php");
			exit();
	}
	// Ýstenmeyen durumlara karþýn. Son
	
	
	//SAYFA DETAYLARI
	  	$menu = '<a href="index.php">Anasayfa</a> > 
            <a href="profil_duzenle.php">'.$_SESSION["kul"].' Profil Düzenle</a>';
	
	  
	$baslik= " - ".$_SESSION["kul"]." Profil Düzenle";
	$sayfa_url = "profil_duzenle.php";
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
	
	
	
	
	
	// do= temizliði yanlýþ bir deðer girilirse direkt profil_detaya gönderme
	if($yap =="" or is_numeric($yap)) 
	$yap ="profil_detay";
	
	if($yap !="profil_detay" and $yap !="sifre_email" 
	and $yap !="imza" and $yap !="avatar" and $yap !="abonelik") 
	$yap ="profil_detay";
	
	//temalara gerekli verileri çekmek için
	$template->assign_vars(array('DO'  => $yap ));
		
	$kul_id = temizle($_SESSION['kul_id']);
	$SQL = mysql_query("SELECT * FROM kullanicilar WHERE kul_id='".$kul_id."'");
	$kul = mysql_fetch_array($SQL);
	
		if($yap =="profil_detay")
		{
			
			if($kul["kul_gizli_mi"] == 0)
			{
			   $pasif ="checked='checked'";
			   $aktif ="";
			}
			else if($kul["kul_gizli_mi"] == 1)
			{
			   $pasif ="";
			   $aktif ="checked='checked'";
			}

			
			if($kul["kul_cinsiyet"] == "Erkek")
			{
			   $cins_pasif ="selected='selected'";
			   $cins_aktif ="";
			   $kul_cins_resim= $ayar["TEMA_YOLU"]."/images/erkek.png";
			}
			else if($kul["kul_cinsiyet"] == "Kadýn")
			{
			   $cins_pasif ="";
			   $cins_aktif ="selected='selected'";
			   $kul_cins_resim= $ayar["TEMA_YOLU"]."/images/kadin.png";
			}
			else
			{
			   $cins_pasif ="selected='selected'";
			   $cins_aktif ="";
			   $kul_cins_resim= $ayar["TEMA_YOLU"]."/images/erkek.png";
			}

			
			if($kul["kul_pm_istiyor_mu"] == "evet")
			{
			   $pasif_pm_istiyor ="";
			   $aktif_pm_istiyor ="checked='checked'";
			}
			else if($kul["kul_pm_istiyor_mu"] =="hayir" )
			{
			   $pasif_pm_istiyor ="checked='checked'";
			   $aktif_pm_istiyor ="";
			}
			
			
			if($kul["kul_pm_uyari"] == "evet")
			{
			   $pasif_eposta_istiyor ="";
			   $aktif_eposta_istiyor ="checked='checked'";
			}
			else if($kul["kul_pm_uyari"] =="hayir" )
			{
			   $pasif_eposta_istiyor ="checked='checked'";
			   $aktif_eposta_istiyor ="";
			}


			
			
			
			
			$template->assign_vars(array(
			'AKTIF'          => $aktif ,
			'PASIF'          => $pasif ,			
			'CINS_BAYAN'     => $cins_aktif ,
			'CINS_ERKEK'     => $cins_pasif ,
			'CINS_IKON'      => $kul_cins_resim ,
			'KUL_AMAC'       => $kul["kul_uyelik_amac"] ,
			'YAHOO'          => $kul["kul_yahoo"] ,
			'MSN'            => $kul["kul_msn"] ,
			'AIM'            => $kul["kul_aim"] ,
			'SKYPE'          => $kul["kul_skype"] ,
			'ICQ'            => $kul["kul_icq"] ,
			'BIOGRAFI'       => $kul["kul_biyografi"] , 
			'YER'            => $kul["kul_yer"] ,
			'HOBI'           => $kul["kul_hobi"] ,
			'MESLEK'         => $kul["kul_meslek"] ,
			'YAS'            => $kul["kul_yas"] ,
			'DOGUM_TARIHI'   => $kul["kul_dogum_tarihi"] ,
			'CINSIYET'       => $kul["kul_cinsiyet"] ,
			'KUL_GERCEK_AD'  => $kul["kul_gercek_ad"] ,
			'KUL_PM_ISTEGI'  => $kul["kul_pm_istiyor_mu"] ,
			'KUL_PM_EPOSTA'  => $kul["kul_pm_uyari"] ,
			'PASIF_PM_ISTIYOR'  => $pasif_pm_istiyor ,
			'AKTIF_PM_ISTIYOR'  => $aktif_pm_istiyor  ,			
			'PASIF_EPOSTA_ISTIYOR'  => $pasif_eposta_istiyor ,
			'AKTIF_EPOSTA_ISTIYOR'  => $aktif_eposta_istiyor  ,
			'DO'             => $yap,
			
		  ));

		}//profil_detay

		else if($yap =="sifre_email")
		{

		  $template->assign_vars(array(
			'EMAIL'     => $kul["kul_email"] ,
			'DO'        => $yap,
		  ));

		}//sifre_email
		else if($yap =="imza")
		{

		  $template->assign_vars(array(
			'IMZA'      => $kul["kul_imza"] ,
			'DO'        => $yap,
		  ));

		}//imza
		else if($yap =="avatar")
		{
				/// Konu ikonlarini yapalim // Basla
				$klasor = "resim/avatar";
				$handle= opendir($klasor);
				while ($file = readdir($handle)) 
				  {
					 $filelist[] = $file;
				  }
				  asort($filelist);
				  
				  // 5 olunca tr bastýr
				   $n = 0;
					while (list ($a, $file) = each ($filelist)) 
					{
					  if($file=="Thumbs.db" or $file=="."  or $file==".." or $file=="index.html" )// eger dosya içinde resimden baska seyler varsa onlari isleme almayalim.
					  {
						echo "";
					  }
					  else
					  {
					  
					  //4 yazýnca ilk üçü bastýrýyor sonradan düzene giriyor
					  if($n==4) $n = 7;
						  /// TEma motoruna bilgileri atalim
						  $template->assign_block_vars('avatarlar',array(
						  'FILE'  => $file,
						  'IMG_SRC' => $klasor."/".$file,
						  'TR'     => ($n % 4 == 0)? "</tr><tr>":"",

						  ));  
					  }// if bitti
                 $n ++;
				}/// while bitti

				/// Konu ikonlarini yapalim // Son
				
		  $template->assign_vars(array(
			'AVATAR'    => ($kul["kul_avatar"]=="")? "resim/avatar_yok.png":$kul["kul_avatar"],
			'DO'        => $yap,
		    ));

		}//avatar
		
		else if($yap =="abonelik")
		{
		  // ÖNCELÝKLE ABONE OLUNAN FORUMLARI ÇEKÝP ATAYALIM
		    $SQL_ABONELIK = mysql_query("select * from abonelikler 
								where kullaniciID ='".$_SESSION["kul_id"]."' 
								and forumID !='' ");
			while($ROW_ABONELIK = mysql_fetch_array($SQL_ABONELIK))
			{// EN BÜYÜK WHÝLE
			
	          $SQL = mysql_query("SELECT * FROM forumlar 
									WHERE forum_id ='".$ROW_ABONELIK["forumID"]."'"); 

			  while($forum  = mysql_fetch_array($SQL))
			   { ///////////////iç while
			
			
	              //////////*** FORUM OKUNDUMU ?  OKUNMADIMI? HEMEN BULALIM ***////////////////////
				  $resim ="forum_old.png";

						$bul= @preg_match('/-'.$forum["forum_son_mesaj_konu_id"].'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] );
				  
						// eðer cookie okundu varsa ve konu id cookie içinde varsa
						if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']) and $bul == true)
						{ 
							$cerez = explode('-'.$forum["forum_son_mesaj_konu_id"].'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
							$parca= intval($cerez[1]); 
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
						   'ALT_F_ID'      => $altforum["forum_id"]	,		   
						   'FORUM_RESIM'      => $resim				   
						));

					} //ENN iç while son
			    }//iç while son
					
			
		    }// EN BÜYÜK WHÝLE	SONNN
			
			
			
		     ###### FORUMLARI BAÞARIYLA SIRALADIK ÞÝMDÝ SIRA KONULARDA
			
					///////////////////////// SAYFALAMA BAÞLADI ///////////	
					
					//$kackayit = $ayar["sayfala_limit_konu"];
					$kackayit = $ayar["sayfala_limit_konu"];

					$sayfa = 1;
					
					if(isset($_GET['sayfa']) and is_numeric($_GET['sayfa']) and $sayfa = $_GET['sayfa'])
							$limit = " LIMIT ".(($sayfa-1)*$kackayit).",$kackayit";
						else
							$limit = " LIMIT $kackayit";
					
					$SQLCEK = "SELECT a.kullaniciID, a.konuID, 
									k.konu_id,k.konu_forum_id,k.son_mesaj_zamani,k.konu_cevap_sayisi, k.konu_author, 
								    k.konu_durum, k.konu_baslik, k.konu_author, k.konu_author_id, k.konu_goruntulenme, 
									k.konu_ikonu, k.konu_zamani, k.son_mesaj_id, k.son_mesaj_yazar_id, k.son_mesaj_yazar
							  FROM abonelikler a, konular k WHERE a.konuID = k.konu_id
									and a.kullaniciID ='".$_SESSION["kul_id"]."' order by k.son_mesaj_zamani desc";
									
					$kayitSay = mysql_num_rows(mysql_query($SQLCEK));

					$sonuc = mysql_fetch_array(mysql_query($SQLCEK));
					$SQL   = mysql_query($SQLCEK.$limit);
					
						
							// SAYFALAMA PAREMETRELERÝ
							$p = new pagination;
							$p->Items($kayitSay);
							$p->limit($kackayit);
							$p->target("profil_duzenle.php?do=abonelik");
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


			///////////////////////// SAYFALAMA  BITTI  


		  $template->assign_vars(array(
			//'IMZA'      => $kul["kul_imza"] ,
			'DO'        => $yap,
		  ));

		}//Abonelik sonn


$template->set_filenames(array('profil_duzenle' => 'profil_duzenle.html' ));

$template->display('profil_duzenle');

require_once("footer.php");




?>