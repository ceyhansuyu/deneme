<?php
session_start();
require_once("../../sistem/ayar.php");
require_once("functions.php");
require_once("../language/tr.php");




	
	if ($_SESSION['kul_admin_yetki'] !="admin")
	{
	   header("location:cikis.php");
	   exit();
	}
	
		$forum_durumu           = temizle($_POST["site_durum"]);//
		$copyright              = temizle($_POST["sitefooter"]);//
		$forum_kapali_sebep     = temizle($_POST["forum_kapali_sebep"]);//
		$script_yolu            = temizle($_POST["script_yolu"]);
		$cookie_on_ek           = temizle($_POST["cerez_on_eki"]);
		$anket_sayisi           = temizle($_POST["anket_sayisi_limit"]);
		$cevrimici_zaman_asimi  = temizle($_POST["cevrim_ici_zmn_asimi"]);
		$cookie_zamani          = temizle($_POST["cerez_zamani"]);
		$flood_aralik           = temizle($_POST["flood_zamani"]);
		$arama_flood_aralik     = temizle($_POST["arama_flood_zamani"]);
		$max_giris_deneme       = temizle($_POST["maksimum_giris_deneme"]);
		$giris_ceza_suresi      = temizle($_POST["giris_ceza_zamani"]);
		$aktivasyon_yontemi     = temizle($_POST["aktivasyon_yontemi"]);
		$board_email            = temizle($_POST["forum_email"]);
		$board_startdate        = temizle($_POST["forum_acilma_tarihi"]);
		$sistem_zaman_dilimi    = temizle($_POST["sistem_zaman_dilimi"]);
		$zaman_formati          = temizle($_POST["sistem_zaman_formati"]);
		$default_lang           = temizle($_POST["forum_dili"]);
		$default_style          = temizle($_POST["forum_temasi"]);
		$ozel_mesaj             = temizle($_POST["pm_aktif_mi"]);
		$gelen_kutusu           = temizle($_POST["pm_gelen_kutusu"]);
		$ulasan_kutusu          = temizle($_POST["pm_giden_kutusu"]);
		$kaydedilen_kutusu      = temizle($_POST["pm_kaydedilen_kutusu"]);
		$ozel_mesaj_limiti      = temizle($_POST["pm_limiti"]);
		$server_name            = temizle($_POST["server_adi"]);
		$sitename               = temizle($_POST["forum_adi"]);
		$site_desc              = temizle($_POST["forum_desc"]);
		$sayfala_limit_konu     = temizle($_POST["konu_sayfalama_limit"]);
		$sayfala_limit_cevap    = temizle($_POST["cevap_sayfalama_limit"]);
		$sicak_konu_limit       = temizle($_POST["sicak_konu_limit"]);
		$uyelik_sozlesmesi      = temizle($_POST["uyelik_sozlesmesi"]);
		$onay_kodu              = temizle($_POST["onay_kodu"]);
		$ekstra_spam_sorusu     = temizle($_POST["ekstra_spam_sorusu_aktifmi"]);
		$kayit_sorusu           = temizle($_POST["kayit_sorusu"]);
		$kayit_cevabi           = temizle($_POST["kayit_cevabi"]);
		$reCAPTHA_aktifmi       = temizle($_POST["reCAPTHA_aktifmi"]);
		$reCAPTHA_public        = temizle($_POST["reCAPTHA_public"]);
		$reCAPTHA_private       = temizle($_POST["reCAPTHA_private"]);
		
        $admin_notu             = temizle($_POST["admin_notu"]);//
		$son_ayar_guncelleme    = time();
		$en_yeni_uye            = temizle($_POST["en_yeni_uye"]);
		$en_yeni_uye_id         = temizle($_POST["en_yeni_uye_id"]);
		$toplam_uye_sayisi      = temizle($_POST["toplam_uye_sayisi"]);
		$SEO                    = temizle($_POST["seo_aktif_mi"]);
	
	
	
	
	
	
	
	
	
	$SQL = mysql_query("UPDATE ayar SET
					
					   forum_durumu           = '$forum_durumu',
					   copyright              = '$copyright',
					   forum_kapali_sebep     = '$forum_kapali_sebep',
					   script_yolu            = '$script_yolu',
					   cookie_on_ek           = '$cookie_on_ek',
					   anket_sayisi           = '$anket_sayisi',
					   cevrimici_zaman_asimi  = '$cevrimici_zaman_asimi',
					   cookie_zamani          = '$cookie_zamani',
					   flood_aralik           = '$flood_aralik',
					   arama_flood_aralik     = '$arama_flood_aralik',
					   max_giris_deneme       = '$max_giris_deneme',
					   giris_ceza_suresi      = '$giris_ceza_suresi',
					   aktivasyon_yontemi     = '$aktivasyon_yontemi',
					   board_email            = '$board_email',
					   board_startdate        = '$board_startdate',
					   sistem_zaman_dilimi    = '$sistem_zaman_dilimi',
					   zaman_formati          = '$zaman_formati',
					   default_lang           = '$default_lang',
					   default_style          = '$default_style',
					   ozel_mesaj             = '$ozel_mesaj',
					   gelen_kutusu           = '$gelen_kutusu',
					   ulasan_kutusu          = '$ulasan_kutusu',
					   kaydedilen_kutusu      = '$kaydedilen_kutusu',
					   ozel_mesaj_limiti      = '$ozel_mesaj_limiti',
					   server_name            = '$server_name',
					   sitename               = '$sitename',
					   site_desc              = '$site_desc',
					   sayfala_limit_konu     = '$sayfala_limit_konu',
					   sayfala_limit_cevap    = '$sayfala_limit_cevap',
					   sicak_konu_limit       = '$sicak_konu_limit',
					   uyelik_sozlesmesi      = '$uyelik_sozlesmesi',
					   onay_kodu              = '$onay_kodu',
					   ekstra_spam_sorusu     = '$ekstra_spam_sorusu',
					   kayit_sorusu           = '$kayit_sorusu',
					   kayit_cevabi           = '$kayit_cevabi',
					   reCAPTCHA_aktif_mi     = '$reCAPTHA_aktifmi',
					   reCAPTCHA_publickey    = '$reCAPTHA_public',
					   reCAPTCHA_privatekey   = '$reCAPTHA_private',
					   admin_notu             = '$admin_notu',
					   son_ayar_guncelleme    = '$son_ayar_guncelleme',
					   en_yeni_uye            = '$en_yeni_uye',
					   en_yeni_uye_id         = '$en_yeni_uye_id',
					   toplam_uye_sayisi      = '$toplam_uye_sayisi',
					   seo_durum              = '$SEO'
						
					WHERE ayar_id='1'");

	
	if($SQL == true)
	{
	   header("location:../index.php");
	   exit();
	}
	else
	{
	  echo "ne yaptýn dostum Olmadý";
	}
///*/
?>