<?php

@include("language/tr.php");
@session_start();

//SEO YAPMA
function seo($url) {
	$turkce=array('þ','Þ','ý','(',')','‘','ü','Ü','ö','Ö','ç','Ç',' ','/','*','?','þ','Þ','ý','ð','Ð','Ý','ö','Ö','Ç','ç','ü','Ü');
	$duzgun=array('s','S','i','','','','u','U','o','O','c','C','-','-','-','','s','S','i','g','G','I','o','O','C','c','u','U');
	$url=str_replace($turkce,$duzgun,$url);
	$url = preg_replace('@[^A-Za-z0-9\-_]+@i','',$url);
	return $url;
}



// EMAÝL FONKSÝYONU
function mail_yolla($kime, $baslik, $govde, $kimden)
{
	$to= $kime;
	$headers = "MIME-Version: 1.0\r\n";
	$headers.= "Content-type: text/html; ";
	$headers.= "charset=iso-8859-9\r\n";
	$headers.= "From: ".$kimden."";
	$subject = $baslik;
	$body = $govde;

		
		

	$yolla = mail($to, $subject, $body, $headers);
	return $yolla;
}


function kul_group_rutbe($kulID)
{
  require_once("ayar.php");
    $SQLgruprengibul = mysql_query("select k.kul_id, k.kul_group_id ,g.grup_id, g.group_color,g.group_rutbesi
					from kullanicilar k, kul_gruplari g
					where k.kul_id ='".$kulID."' and g.grup_id = k.kul_group_id ");
  $rows = array();
  
  $kul_grup_bul = mysql_fetch_array($SQLgruprengibul);
   
   return  $kul_grup_bul["group_rutbesi"];
    
}


function kul_group_rutbe_img($kulID)
{
  require_once("ayar.php");
    $SQLgruprengibul = mysql_query("select k.kul_id, k.kul_group_id ,g.grup_id, g.group_color,g.group_rutbe_resmi
					from kullanicilar k, kul_gruplari g
					where k.kul_id ='".$kulID."' and g.grup_id = k.kul_group_id ");
  $rows = array();
  
  $kul_grup_bul = mysql_fetch_array($SQLgruprengibul);
   
   return  $kul_grup_bul["group_rutbe_resmi"];
    
}


function kul_group_color($kulID)
{
  require_once("ayar.php");
    $SQLgruprengibul = mysql_query("select k.kul_id, k.kul_group_id ,g.grup_id, g.group_color
					from kullanicilar k, kul_gruplari g
					where k.kul_id ='".$kulID."' and g.grup_id = k.kul_group_id ");
  $rows = array();
  
  $kul_grup_bul = mysql_fetch_array($SQLgruprengibul);
   
   return  $kul_grup_bul["group_color"];
    
}

function vurgula($metin, $kelimeler, $renk = '#FFFF00')
{
	if(is_array($kelimeler))
	{
	foreach($kelimeler as $k => $kelime)
	{
	$desen[$k] = "/\b($kelime)\b/is";
	$degistir[$k] = '<font style=”background-color:'.$renk.';">\\1</font>';
	}
	}  else {
	$desen = "/\b($kelimeler)\b/is";
	$degistir = '<font style="background-color:'.$renk.';">\\1</font>';
	}
	return preg_replace($desen,$degistir,$metin);
}




function rating_konu($konuid)
{
	    @include("ayar.php");
        $SQL = mysql_query("SELECT SUM(rating_degeri)  as toplam FROM rating_konu 
					        WHERE rating_konu_id='".$konuid."'"); 
		$SQL2 =mysql_query("SELECT * FROM rating_konu 
					        WHERE rating_konu_id=".$konuid.""); 
		$say = mysql_num_rows($SQL2);
        $row = mysql_fetch_array($SQL);

        $toplamoy = $row['toplam']; 
		$oysayisi = $say;
		//Round 0.5 ten büyükse 1 e küçükse 0 a eþitler mantýk bu
		$ortalama_oy = @round($toplamoy / $oysayisi);
		
		
		
		if($ortalama_oy == 0)
		{
		 $gercek_rating = "0";
		}
		else if($ortalama_oy == 1 )
		{
		 $gercek_rating = "1";

		}		
		else if($ortalama_oy == 2 )
		{
		 $gercek_rating = "2";

		}
		else if($ortalama_oy == 3 )
		{
		 $gercek_rating = "3";

		}
		else if($ortalama_oy == 4 )
		{
		 $gercek_rating = "4";

		}
		else if($ortalama_oy == 5 )
		{
		 $gercek_rating = "5";

		}		
		else if($ortalama_oy == 6 )
		{
		 $gercek_rating = "6";

		}
		else if($ortalama_oy == 7)
		{
		 $gercek_rating = "7";

		}
		else if($ortalama_oy == 8 )
		{
		 $gercek_rating = "8";

		}
		else if($ortalama_oy == 9 )
		{
		 $gercek_rating = "9";

		}
		else if($ortalama_oy == 10 )
		{
		 $gercek_rating = "10";
		}
		
	return 	$gercek_rating;


}



###########  FORUM OKUNDU OKUNMADI FONKSÝYONU  ###########
function okundumu($son_mesaj_time, $konunun_idsi , $konu_cevab_say , $konu_kimin ,$konu_durum)
	{
	    @include("ayar.php");
	 	$resim ="thread.png";

		$bul= @preg_match('/-'.$konunun_idsi.'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] );
		
		  
		// eðer cookie okundu varsa ve konu id cookie içinde varsa
		if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']) and $bul == true)
			{ 
			    $cerez = explode('-'.$konunun_idsi.'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
				$parca= $cerez[1]; 
				$cerez_tarihi = substr($parca ,0,10);
		 
			// EÐER KONUDAKÝ SON MESAJIN TARÝHÝ ÇEREZDEKÝ TARÝHTEN BÜYÜKSE
				if($son_mesaj_time > $cerez_tarihi)
					{
					     $resim ="thread_new.png";
					}
				else
					{
						 $resim ="thread.png";
					}

			}
			else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA :)
				{
				  if($son_mesaj_time > $_SESSION['kul_son_aktivite'])
					{
						 $resim ="thread_new.png";
					}
					
				}
	  
########################   ÝKONLARIN KONTROLLERÝ VE ATAMALARI ##########################
	  if( $resim ==="thread.png" )
	  {
	     if( $konu_durum =="kilitli")
		 {
		   if($konu_cevab_say > $ayar["sicak_konu_limit"]) $resim = "thread_hot_lock.png";
		   if(($konu_cevab_say > $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_hot_lock.png";		  
		  
		   if($konu_cevab_say < $ayar["sicak_konu_limit"]) $resim = "thread_lock.png";
		   if(($konu_cevab_say < $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_lock.png";	
		 }
		 else
		 {
		 
		   if($konu_cevab_say > $ayar["sicak_konu_limit"]) $resim = "thread_hot.png";
		   if(($konu_cevab_say > $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_hot.png";		  
		  
		   if($konu_cevab_say < $ayar["sicak_konu_limit"]) $resim = "thread.png";
		   if(($konu_cevab_say < $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot.png";			
		 }
		  
	  }// IF SON
	  elseif( $resim ==="thread_new.png" )
	  {
			
		if( $konu_durum =="kilitli")
		{
		  	if($konu_cevab_say > $ayar["sicak_konu_limit"]) $resim = "thread_hot_lock_new.png";
			if(($konu_cevab_say > $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_hot_lock_new.png";		  

			if($konu_cevab_say < $ayar["sicak_konu_limit"]) $resim = "thread_lock_new.png";
		    if(($konu_cevab_say < $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_lock_new.png";
		
		}
        else
        {
		  	if($konu_cevab_say > $ayar["sicak_konu_limit"]) $resim = "thread_hot_new.png";
			if(($konu_cevab_say > $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_hot_new.png";		  

			if($konu_cevab_say < $ayar["sicak_konu_limit"]) $resim = "thread_new.png";
		    if(($konu_cevab_say < $ayar["sicak_konu_limit"]) and ($konu_kimin == $_SESSION["kul"])) $resim = "thread_dot_new.png";
		}		

	  }//ELSE IF SON

######################## </SON> ÝKONLARIN KONTROLLERÝ VE ATAMALARI ########################

	   return $resim;
	   
	}

###########  FORUM OKUNDU OKUNMADI FONKSÝYONU SON ########


###########  DUYURU OKUNDU OKUNMADI FONKSÝYONU  ###########
function duyuru_okundumu($son_mesaj_time, $konunun_idsi)
	{
	    @include("ayar.php");
	 	$resim ="announcement_old.png";

		$bul= @preg_match('/-'.$konunun_idsi.'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] );
		  
		// eðer cookie okundu varsa ve konu id cookie içinde varsa
		if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']) and $bul == true)
			{ 
			    $cerez = explode('-'.$konunun_idsi.'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
				$parca= $cerez[1]; 
				$cerez_tarihi = substr($parca ,0,10);
		 
			// EÐER KONUDAKÝ SON MESAJIN TARÝHÝ ÇEREZDEKÝ TARÝHTEN BÜYÜKSE
				if($son_mesaj_time > $cerez_tarihi)
					{
					     $resim ="announcement_new.png";
					}
				else
					{
						 $resim ="announcement_old.png";
					}

			}
			else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA :)
				{
				  if($son_mesaj_time > $_SESSION['kul_son_aktivite'])
					{
						 $resim ="announcement_new.png";
					}
				}
	
	   return $resim;
	}

###########  DUYURU OKUNDU OKUNMADI FONKSÝYONU SON ########



###########  SABÝT OKUNDU OKUNMADI FONKSÝYONU  ###########
function sabit_okundumu($son_mesaj_time, $konunun_idsi)
	{
	    @include("ayar.php");
	 	$resim ="thread.png";

		$bul= @preg_match('/-'.$konunun_idsi.'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] );
		  
		// eðer cookie okundu varsa ve konu id cookie içinde varsa
		if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']) and $bul == true)
			{ 
			    $cerez = explode('-'.$konunun_idsi.'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
				$parca= $cerez[1]; 
				$cerez_tarihi = substr($parca ,0,10);
		 
			// EÐER KONUDAKÝ SON MESAJIN TARÝHÝ ÇEREZDEKÝ TARÝHTEN BÜYÜKSE
				if($son_mesaj_time > $cerez_tarihi)
					{
					     $resim ="thread_new.png";
					}
				else
					{
						 $resim ="thread.png";
					}

			}
			else // okundu isimli cookie yoksa VEYA $bUL 'LAMADIYSA :)
				{
				  if($son_mesaj_time > $_SESSION['kul_son_aktivite'])
					{
						 $resim ="thread_new.png";
					}
				}
	
	   return $resim;
	}

###########  SABÝT OKUNDU OKUNMADI FONKSÝYONU SON ########

function kul_koordinat($baslik, $sayfa_url)
{
include("ayar.php");
	$ip   = $_SERVER["REMOTE_ADDR"];
	$agent = $_SERVER['HTTP_USER_AGENT'];
// Kullanýcý koordinat
	if (@$_SESSION['kul'] !="misafir")
	  {
	    $su_an = time();
		$SQL_user = mysql_query("UPDATE kullanicilar set 
		            kul_ip              = '$ip',
		            kul_agent           = '$agent',
		            kul_son_sayfa       = '$sayfa_url',
					kul_son_aktivite    = '$su_an',
					kul_son_sayfa_baslik = '$baslik'
					WHERE kul_id =".@$_SESSION['kul_id']."");
	  }
	  
	if (@$_SESSION['kul'] =="misafir")
	  {
	    $su_an = time();
		$SQL_user = mysql_query("UPDATE online_kullanicilar set 
					kul_son_aktivite    = '$su_an'
					WHERE kul_agent ='".$agent."' and kul_ip =".$ip."");
	  }
	  
    // Kullanýcý koordinat

}

///// KONU ÝDSÝNÝ TEMÝZLE

function klasor_id_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:../bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM ozel_mesaj_klasor WHERE klasorID 	=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:../bilgiver.php?bilgi=klasor_dbde_yok");
	
	return $temizle;
}






///// KATEGORÝ ÝDSÝNÝ TEMÝZLE
function k_id_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM kategoriler WHERE kat_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:bilgiver.php?bilgi=k_dbde_yok");
	
	return $temizle;
}






///// FORUM ÝDSÝNÝ TEMÝZLE

function f_id_temizle($id)
{
    if(!empty($id))
	{
		 $temizle = mysql_real_escape_string($id);
		 $temizle = trim($temizle);
			if(is_numeric($temizle) == false) 
			 {
			   header("location:bilgiver.php?bilgi=url_gecersiz");
			   exit();
			 }
			
			// Eðer gelen ?f= ise
			if ($temizle)
			$SQL = mysql_query("SELECT * FROM forumlar WHERE forum_id=".$temizle."");
			$say = mysql_num_rows($SQL);
			
			// Eðer girilen id dbde yoksa
			if($say == 0) 
			header("location:bilgiver.php?bilgi=f_dbde_yok");
			
			return $temizle;
	}
}


///// KONU ÝDSÝNÝ TEMÝZLE ANA DÝZÝNDE

function t_id_temizle_anadizinde($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM konular WHERE konu_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:bilgiver.php?bilgi=t_dbde_yok");
	
	return $temizle;
}

///// KONU ÝDSÝNÝ TEMÝZLE

function t_id_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:../bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM konular WHERE konu_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:../bilgiver.php?bilgi=t_dbde_yok");
	
	return $temizle;
}



///// KONU MESAJ ÝDSÝNÝ TEMÝZLE

function mesaj_id_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:../bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM mesajlar WHERE mesaj_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:../bilgiver.php?bilgi=mesaj_dbde_yok");
	
	return $temizle;
}

///// ARAMA ÝDSÝNÝ TEMÝZLE

function arama_id_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM yapilan_aramalar WHERE arama_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:bilgiver.php?bilgi=arama_yok_sonuc_yok");
	
	return $temizle;
}


///// KULLANICI ÝDSÝNÝ TEMÝZLE Ana dizin

function kullanici_temizle_ana_dizin($id)
{
if($id !="")
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM kullanicilar WHERE kul_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:bilgiver.php?bilgi=kul_dbde_yok");
	
	return $temizle;
}
}

///// KULLANICI ÝDSÝNÝ TEMÝZLE

function kullanici_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:../bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM kullanicilar WHERE kul_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:../bilgiver.php?bilgi=kul_dbde_yok");
	
	return $temizle;
}

//// Kullanýcý var mý kontrol
///// KULLANICI Adýný TEMÝZLE

function kullanici_temizle_kuladi($adi)
{
 $temizle = mysql_real_escape_string($adi);
 $temizle = trim($temizle);

	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM kullanicilar WHERE kul_adi=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:../bilgiver.php?bilgi=kul_dbde_yok");
	
	return $temizle;
}





///// ANKET ÝDSÝNÝ TEMÝZLE

function anket_id_temizle($id)
{
 $temizle = mysql_real_escape_string($id);
 $temizle = trim($temizle);
	if(is_numeric($temizle) == false) 
	 {
	   header("location:../bilgiver.php?bilgi=url_gecersiz");
	   exit();
	 }
	
	// Eðer gelen ?f= ise
	if ($temizle)
	$SQL = mysql_query("SELECT * FROM anket_option WHERE anket_id=".$temizle."");
	$say = mysql_num_rows($SQL);
	
	// Eðer girlen id yoksa
	if($say == 0) 
	header("location:../bilgiver.php?bilgi=anket_dbde_yok");
	
	return $temizle;
}

  function acilma_suresi ()
  {
	$time = explode( " ", microtime());
	$usec = (double)$time[0];
	$sec = (double)$time[1];
	return $sec + $usec;
   }

 // kullanýcý adýný temizle
function kul_temizle($k)
{
	$izinli_tags="";
	$isle = strip_tags($k,$izinli_tags);
	$isle = mysql_real_escape_string($isle); // stripslashes($k);
	$isle = trim($isle); // boþluklarý temizliyoruz
	
	$bul = array("-","'","\"\"","+",",","%",".","_","-","=","\\","\"");
	$degis = array("","","","","","","","","","","","");

	$isle = str_replace($bul,$degis,$isle);
	
	return $isle;
} 
   
// genel temizle
function temizle($k)
{
$izinli_tags="<blockquote><span><img><br><b><strong><s><i><u><ol><ul><li><h1><h2><h3><h4><h5><h6><a>";
$isle = strip_tags($k,$izinli_tags);
$isle = mysql_real_escape_string($isle); // stripslashes($k);
//$isle = str_replace("'","&quot;",$isle);
return $isle;
}

/////forum tarihi 
function forum_tarihi($zaman,$gmt){
global $lang;
    $gmt= $gmt * 3600;
    $ozaman = gmdate('d F Y', $zaman + $gmt);
    $simdi = gmdate('d F Y', time() + $gmt);
    $dun = gmdate('d F Y', (time() + $gmt - 86400));

        $tarih = gmdate('d F Y H:i', $zaman + $gmt);
		/////////
		//////////
		$bul = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $cevir = array( $lang['ocak'],$lang['subat'],$lang['mart'],$lang['nisan'],$lang['mayis'],$lang['haziran'],$lang['temmuz'],$lang['agustos'],$lang['eylul'],$lang['ekim'],$lang['kasim'],$lang['aralik']);
    $tarih = str_replace($bul, $cevir, $tarih);

    return $tarih;
}

// Konu tarihi
function konu_tarihi($zaman,$gmt){
global $lang;
    $gmt= $gmt * 3600;
    $ozaman = gmdate('d F Y', $zaman + $gmt);
    $simdi = gmdate('d F Y', time() + $gmt);
    $dun = gmdate('d F Y', (time() + $gmt - 86400));

    if ($ozaman == $simdi)
        $tarih = $lang['bugun'].gmdate('H:i', $zaman + $gmt);

    elseif ($ozaman == $dun)
        $tarih = $lang['dun'].gmdate('H:i', $zaman + $gmt);

    else
        $tarih = gmdate('d F Y H:i', $zaman + $gmt);
		/////////
		//////////
		$bul = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $cevir = array( $lang['ocak'],$lang['subat'],$lang['mart'],$lang['nisan'],$lang['mayis'],$lang['haziran'],$lang['temmuz'],$lang['agustos'],$lang['eylul'],$lang['ekim'],$lang['kasim'],$lang['aralik']);
    $tarih = str_replace($bul, $cevir, $tarih);

    return $tarih;
	
}

/// Dünlü bugünlü konu tarihi

function tarih($zaman,$gmt){
global $lang;
    $gmt= $gmt * 3600;
    $ozaman = gmdate('d F Y a', $zaman + $gmt);
    $simdi = gmdate('d F Y a', time() + $gmt);
    $dun = gmdate('d F Y a', (time() + $gmt - 86400));

    if ($ozaman == $simdi)
        $tarih = $lang['bugun'].gmdate('h:i a', $zaman + $gmt);

    elseif ($ozaman == $dun)
        $tarih = $lang['dun'].gmdate('h:i a', $zaman + $gmt);

    else
        $tarih = gmdate('d F Y h:i a', $zaman + $gmt);
		/////////
		//////////
		$bul = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $cevir = array( $lang['ocak'],$lang['subat'],$lang['mart'],$lang['nisan'],$lang['mayis'],$lang['haziran'],$lang['temmuz'],$lang['agustos'],$lang['eylul'],$lang['ekim'],$lang['kasim'],$lang['aralik']);
    $tarih = str_replace($bul, $cevir, $tarih);

    return $tarih;
	
}//////

 ##############  SAYFALAMA ///////////////////


function sayfala_ufak($tablo2,$orderby2 , $link2, $limit ,$s_s, $gelen_sayfa ,$mesajforumid )
{
  include("ayar.php");
///////////////////////// SAYFALAMA  BASLADI  /////////////////////////////

// konu mesaj sayfalamak için
$SQL10 = mysql_query("SELECT * FROM ".$tablo2." WHERE mesaj_konu_id =".$mesajforumid.""); 
$satir = mysql_num_rows($SQL10);

if($satir >0)
{//sonuç varsa
    $baslama = ($gelen_sayfa > 1) ? (($gelen_sayfa -1) * $limit) : 0 ;
    $sayfa_kac = $satir/$limit;
    $sayfa_sayisi = ($satir % $limit != 0) ? intval($sayfa_kac)+1 : intval($sayfa_kac);
 /// eger browserdan girlen sayfa sayisi 
 //en yüksek sayfa sayisindan büyükse sayfayi 1. sayfaya esitleyelim
	if(@$_GET['sayfa'] > $sayfa_sayisi )
	 {
	 $gelen_sayfa =1;
	 }///
	
    $basla=( $satir >= $baslama ) ? $baslama : 0 ;
    unset( $sayfa_kac, $baslama );
	$sorgu = 'SELECT * FROM '.$tablo2.' WHERE mesaj_konu_id ='.$mesajforumid.'
            	order by '.$orderby2.'  asc limit '.$basla.' , '.$limit;
	$sorgu2= mysql_query($sorgu);
    $i=1;
    $style='';
      

    $hangi_sayfa= ($gelen_sayfa > 0)? $gelen_sayfa : 1 ;
    $sayfala_cikis ="";
	
            $alt= ($gelen_sayfa - $s_s);
            if($sayfa_sayisi <= $s_s || $gelen_sayfa <= $s_s ) {$alt=1;} 
            $ust= (($gelen_sayfa + $s_s)< $sayfa_sayisi ) ? ($gelen_sayfa + $s_s) : ($sayfa_sayisi);    
            
			
            for($i=$alt; $i<=$ust ;$i++)
			{       
		      if ($i != $gelen_sayfa ) 
			  { 
			      if($ayar["seo_durum"] =="acik")
			         $sayfala_cikis.= '<a title="'.$i.'. Sayfa" href="'.$link2.'-'.$i.'.html" id="sayfalamaLink">'.$i.'</a>' ;
			        else   
					 $sayfala_cikis.= '<a title="'.$i.'. Sayfa" href="'.$link2.'&sayfa='.$i.'" id="sayfalamaLink">'.$i.'</a>' ;
		      }
			  else 
			  {
			      if($ayar["seo_durum"] =="acik")
			  	  $sayfala_cikis.= '<a title="'.$i.'. Sayfa" href="'.$link2.'-'.$i.'.html" id="sayfalamaLink">'.$i.'</a>';
			  	  else
				  $sayfala_cikis.= '<a title="'.$i.'. Sayfa" href="'.$link2.'&sayfa='.$i.'" id="sayfalamaLink">'.$i.'</a>';
			  }
           }
		   
		   if($sayfa_sayisi > 1) $sayfala_cikis ; else $sayfala_cikis= "";
		  
}
else{
        $sayfala_cikis= "";
}

  return $sayfala_cikis ;
///////////////////////// SAYFALAMA  BITTI  /////////////////////////////

}

//// Sayfa sayýsý
function sayfa_sayisi($tablosayfala , $WHERE_mesajforumid, $limitsayfala)
{
// konu mesaj sayfalamak için
$SQL10 = mysql_query("SELECT * FROM ".$tablosayfala." WHERE mesaj_konu_id =".$WHERE_mesajforumid.""); 
@$satir = mysql_num_rows($SQL10);

//sonuç varsa
    $sayfa_kac = $satir/$limitsayfala;
    $sayfa_sayisi = ($satir % $limitsayfala != 0) ? intval($sayfa_kac)+1 : intval($sayfa_kac);
	if($sayfa_sayisi == 0) $sayfa_sayisi = 1;
	return $sayfa_sayisi;
}


//email kontrolü
function emailkontrol($email) 
   
{ 
return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>]+\.+[a-z]{2,6}))$#si', $email); 
} 

function generateCode($characters) 
{
 /// list all possible characters
$possible ='0123456789abcdfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRS@WXZYUT@$#+--_{}][()*?!';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
	$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
		$i++;
		}
		return $code;
}


function youtube($cevir) 
{
  
  $cevir = preg_replace('/&amp;/','&',$cevir);
  $cevir = preg_replace('|\[YOUTUBE\]http://www.youtube.com/watch\?v=([a-z0-9?&\\/\-_+.:,=#@;]+?)\&feature=([a-z0-9?&\\/\-_+.:,=#@;]+?)\[/YOUTUBE\]|si','\\1',$cevir);
  $cevir = "[YOUTUBE]".$cevir."[/YOUTUBE]";
  return strip_tags(trim($cevir));
}

function php_renklendir($php)
{
   $php = str_replace("<?php","",$php);
   $php = str_replace("<?","",$php);
   $php = str_replace("?>","",$php);
   
   $php ="<?php\n".$php." \n?>";


  return highlight_string($php);
}

function bbcode($str){
   // Convert all special HTML characters into entities to display literally
  
   // The array of regex patterns to look for
   $format_search =  array(
      '#\[b\](.*?)\[/b\]#is', // Bold ([b]text[/b]
      '#\[i\](.*?)\[/i\]#is', // Italics ([i]text[/i]
      '#\[u\](.*?)\[/u\]#is', // Underline ([u]text[/u])
      '#\[s\](.*?)\[/s\]#is', // Strikethrough ([s]text[/s])
      '#\[quote\](.*?)\[/quote\]#is', // Quote ([quote]text[/quote])
      '/\[quote\=(.*?)\](.*?)\[\/quote\]/is', // Quote ([quote]text[/quote])
      '#\[php\](.*?)\[/php\]#is', // php ([php]text[/php])
      '#\[code\](.*?)\[/code\]#is', // Monospaced code [code]text[/code])
      '#\[youtube\](.*?)\[/youtube\]#is', // Monospaced youtube [youtube]text[/youtube])
      '#\[size=([1-9]|1[0-9]|20)\](.*?)\[/size\]#is', // Font size 1-20px [size=20]text[/size])
      '#\[color=\#?([A-F0-9]{3}|[A-F0-9]{6})\](.*?)\[/color\]#is', // Font color ([color=#00F]text[/color])
      '#\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]#i', // Hyperlink with descriptive text ([url=http://url]text[/url])
      '#\[url\]((?:ftp|https?)://.*?)\[/url\]#i', // Hyperlink ([url]http://url[/url])
      '#\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]#i' // Image ([img]http://url_to_image[/img])
   );
   // The matching array of strings to replace matches with
   $format_replace = array(
      '<strong>$1</strong>',
      '<em>$1</em>',
      '<span style="text-decoration: underline;">$1</span>',
      '<span style="text-decoration: line-through;">$1</span>',
      '<div class="quotetitle">Quote</div><div class="quotecontent">$1</div>',
      '<div class="quotetitle">Quote by: $1 </div><div class="quotecontent">$2</div>',
      '<div class="quotetitle">Php</div><div class="quotecontent">$1</div>',      
   	  '<div class="quotetitle">Kod</div><div class="quotecontent">$1</div>',
	  '<iframe width="420" height="315" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
      '<span style="font-size: $1px;">$2</span>',
      '<span style="color: #$1;">$2</span>',
      '<a href="$1">$2</a>',
      '<a href="$1">$1</a>',
      '<img src="$1" alt="" />'
   );
   // Perform the actual conversion
   $str = preg_replace($format_search, $format_replace, $str);
   // Convert line breaks in the <br /> tag
   $str = nl2br($str);
   
   
   
   
   
   
   
   
   $str = str_replace("[QUOTE]","<div class='quotetitle'>Quote</div><div class='quotecontent'>",$str);
   $str = str_replace("[/QUOTE]","</div>",$str);
   
   $str = str_replace("[QUOTE=","<div class='quotetitle'>Quote by:",$str);
   $str = str_replace("]","</div><div class='quotecontent'>",$str);
   

   
   return $str;
}
?>
