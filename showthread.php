<?php
require_once("genel.php");
include("similies.php");
include("sistem/BBcode.parser.class.php");
$bbcode = new Parser;

	if($ayar["seo_durum"] =="acik")
	{
     
	  $katid = explode($ayar["script_yolu"],$_SERVER['REQUEST_URI']);
	  $katidbul = explode("-",$katid[1]);
	  $katidsi = explode("t",$katidbul[0]);
	  $konuid =  t_id_temizle_anadizinde($katidsi[1]);
	  //echo $fid;
	  
	  $sql = mysql_query("select * from konular where konu_id='".$konuid."'");
	  $konuS = mysql_fetch_array($sql);
	  $konuURL ="t".$konuid."-".seo($konuS["konu_baslik"])."-";
	  $sayfasi = explode($konuURL,$_SERVER['REQUEST_URI']);
	  $sayfasiSON = explode(".html",@$sayfasi[1]);
	  $_GET["sayfa"] = $sayfasiSON[0];
	}
	else
	{
	  $konuid = t_id_temizle_anadizinde($_GET['t']);
	}





	//SAYFA DETAYLARI
  	$SQL = mysql_query("SELECT f.forum_id, f.kat_id, f.forum_tipi , f.forum_ust_f, 
			f.forum_ust_title, f.forum_adi,
			k.kat_id, k.kat_title, konu.konu_baslik
			FROM forumlar f, kategoriler k, konular konu
			WHERE f.kat_id = k.kat_id 
			and konu.konu_id=".$konuid." 
			and konu.konu_forum_id = f.forum_id ") ;
	
	
    $row = mysql_fetch_array($SQL);
	
	if($row["forum_tipi"] =="alt")
      {
	   if($ayar["seo_durum"] =="acik")
	   $menu = '<a href="index.html">Anasayfa</a> > 
			<a href="k'.$row["kat_id"].'-'.seo($row["kat_title"]).'.html">'.$row["kat_title"].'</a> >
			<a href="f'.$row["forum_ust_f"].'-'.seo($row["forum_ust_title"]).'.html">'.$row["forum_ust_title"].'</a> >
			<a href="f'.$row["forum_id"].'-'.seo($row["forum_adi"]).'.html">'.$row["forum_adi"].'</a> >
           
            '.$row["konu_baslik"].' ';	   
		else
		$menu = '<a href="index.php">Anasayfa</a> > 
            <a href="kategoridisplay.php?k='.$row["kat_id"].'">'.$row["kat_title"].'</a> >
            <a href="forumdisplay.php?f='.$row["forum_ust_f"].'">'.$row["forum_ust_title"].'</a> > 
            <a href="forumdisplay.php?f='.$row["forum_id"].'">'.$row["forum_adi"].'</a> >
            '.$row["konu_baslik"].' ';
	  
	  }	
	  else
	  {
	    if($ayar["seo_durum"] =="acik")
	  		$menu = '<a href="index.html">Anasayfa</a> > 
			<a href="k'.$row["kat_id"].'-'.seo($row["kat_title"]).'.html">'.$row["kat_title"].'</a> >
			<a href="f'.$row["forum_id"].'-'.seo($row["forum_adi"]).'.html">'.$row["forum_adi"].'</a> > 

            '.$row["konu_baslik"].' ';
		else
	  		$menu = '<a href="index.php">Anasayfa</a> > 
            <a href="kategoridisplay.php?k='.$row["kat_id"].'">'.$row["kat_title"].'</a> >
            <a href="forumdisplay.php?f='.$row["forum_id"].'">'.$row["forum_adi"].'</a> >
            '.$row["konu_baslik"].' ';
	  }

	$baslik= " - ".$row["konu_baslik"];
	if($ayar["seo_durum"] =="acik")
	$sayfa_url = "showthread.php?t=".$konuid;
	else
	$sayfa_url = "showthread.php?t=".$konuid;
	// Kullanýcý koordinat
    	kul_koordinat($baslik ,$sayfa_url); 
    // Kullanýcý koordinat
			
		$template->assign_vars(array(
			'BASLIK'        => $baslik,
			'MENU'          => $menu,	
            'S_ADMIN'       => (@$_SESSION['kul_yetki'] == "admin") ? true:false,// adminse			
            'S_SILME'       => (@$kul_izin['forum_silme'] =="evet") ? true:false,// forum silme izni			
            'S_DUZENLE'     => (@$kul_izin['forum_duzenleme'] =="evet") ? true:false,// forum silme izni			
		));
		unset($SQL);
    //SAYFA DETAYLARI
	require_once("baslik.php");

	
	
	
 // FORUMDA KÝMLER DOLANIYOR HEMEN BULALIM
 $son_sayfasi ="showthread.php?t=".$konuid;
 
 $time = time();
 $zaman_asimi = $ayar["cevrimici_zaman_asimi"];
 
 $SQLdolanan_uye = mysql_query("select * from kullanicilar 
							where  kul_son_sayfa = '".$son_sayfasi."' 
							and  ('".$zaman_asimi."' + kul_son_aktivite ) > '".$time."'"); 
							
 $SQLdolanan_misafir = mysql_query("select * from online_kullanicilar 
							where  kul_son_sayfa = '".$son_sayfasi."'
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
	


/// KONUYA ABONE OLUNMUÞ MU?
if ($_SESSION['kul'] !="misafir")
{
	$kulID = temizle($_SESSION['kul_id']);
	$SQL = mysql_query("SELECT * FROM abonelikler 
							WHERE konuID =".$konuid." AND kullaniciID ='".$kulID."' ");
	$abonesay = mysql_num_rows($SQL);
}	
	
	
	
	

//konu idyi hemen temaya yollayalým
$template->assign_vars(array( 
							'KONU_ID'    => $konuid, 
		                    'ABONE_VAR'  => (@$abonesay > 0)? true:false,	
					));

//Konu Deðerlendirmesini yapalým.

//konu ratingini hemen temaya yollayalým
$rating_deger = rating_konu($konuid);
$rating_resim= $ayar_rating_yolu."/".$rating_deger.".png";

$template->assign_vars(array( 
								'KONU_RATING'  => $rating_resim,
								'KONU_RATING_DEGER'  => $rating_deger,
							));
							
/////////////// Anketi Dahil edelim //////////////
include("anket_php.php");


///////////////////////////////////*** KONUYU OKUNDU YAPALIM ***///////////// 

// okundu iþimli cookie varsa
if(isset($_COOKIE[$ayar["cookie_on_ek"].'okundu']))
{ 
 
 // cookie içerisinde konu id ye eþit bir deðer var mý onu buluyoruz
 $bul= preg_match('/-'.$konuid.'_/', $_COOKIE[$ayar["cookie_on_ek"].'okundu'] ); 
	 
   $SQL = mysql_query("SELECT * FROM konular WHERE konu_id =".$konuid.""); 
   $row = mysql_fetch_array($SQL);

   if($row['son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
	{
	 // eðer konu_id çerezde yoksa konu_id yi cookie ye yazýyoruz
	 if($bul == false){
      setcookie($ayar["cookie_on_ek"].'okundu',$_COOKIE[$ayar["cookie_on_ek"].'okundu'].'-'.$konuid."_".time() , time() + $ayar["cookie_zamani"] , $ayar["script_yolu"]);  
	 }//eðer konu id varsa tarihini güncelliyoruz
	 else
	 {
	 $cerez = explode('-'.$konuid.'_', $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
	 $parca= $cerez[1]; 
	 $cerez_tarihi = substr($parca ,0,10);
	 
	 // þimdi çerezdeki konu id nin tarihini güncelleyelim	  
	  $cerez2 = explode('-'.$konuid.'_'.$cerez_tarihi, $_COOKIE[$ayar["cookie_on_ek"].'okundu']);
	  setcookie($ayar["cookie_on_ek"].'okundu',$cerez2[0].'-'.$konuid."_".time().$cerez2[1], time() + $ayar["cookie_zamani"] ,$ayar["script_yolu"]);  
	 }
	}
	 
}// If Cookie sonn  
else // okundu iþimli cookie yoksa okundu isimli cookie oluþturuyoruz.
{  
   // kullanýcý son harekat
   if ($_SESSION['kul'] !="misafir")
	 {  $time = time();
	   $SQL_user = mysql_query("UPDATE kullanicilar set 
						kul_son_harekat  = '$time'
						WHERE kul_id =".$_SESSION['kul_id']."");
	}			
	
   $SQL = mysql_query("SELECT * FROM konular WHERE konu_id =".$konuid.""); 
   $row = mysql_fetch_array($SQL);

    if($row['son_mesaj_zamani'] > $_SESSION['kul_son_aktivite'])
	{
     setcookie($ayar["cookie_on_ek"].'okundu','-'.$konuid."_".time() ,time() + $ayar["cookie_zamani"] ,$ayar["script_yolu"]); 
    } 
}

///////////////////////////////////*** KONUYU OKUNDU YAPALIM SON ***///////////// 

###################################################################################


/// Hiti güncelleyelim.
$SQL = mysql_query("UPDATE konular 
					set konu_goruntulenme = konu_goruntulenme + 1
					WHERE konu_id=".$konuid."");
unset($SQL);
unset($row);
unset($SQLU);
unset($kul);



#################################################################################
// Ana konuyu bir bulalým hele
$SQL = mysql_query("SELECT * FROM konular 
					WHERE konu_id =".$konuid."");					

    $row = mysql_fetch_array($SQL);
	
   /// konurow tema motoruna ekliyoruz
    $template-> assign_block_vars('konurow', array(
	'KONU_ID'        => $konuid,
	'KONU_FORUM_ID'  => $row["konu_forum_id"],
	'KONU_BASLIK'    => $row["konu_baslik"],
	'KONU_IKONU'     => $row["konu_ikonu"],
	'S_LOGIN'        => isset($_SESSION['kul_id']) ? true : false,

	));	

###################################################################################


				
	
	
	///////////////////////// SAYFALAMA  BASLADI  /////////////////////////////

$gelen_sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] !='')? intval($_GET['sayfa']) : 1;
//Baglanilacak Tablo
$tablo = 'mesajlar';

//Sayafalamayi yapan dosyanin adi
if($ayar["seo_durum"] =="acik")
  $link = 't'.$konuid."-".seo($row["konu_baslik"]);
else 
  $link = 'showthread.php?t='.$konuid;

//Sayfada kaç kayit görünecek
// öncelikle ayarlardan çekelim

$limit= $ayar["sayfala_limit_cevap"];

//Kaç sayfa öncesi ve sonrasi görünecek
$s_s = 3;


// konu mesaj sayfalamak için
$SQL10 = mysql_query("SELECT * FROM mesajlar 
					WHERE mesaj_konu_id  =".$konuid." order by mesaj_zamani asc"); 
$satir = mysql_num_rows($SQL10);


if($satir >0)
{//sonuç varsa
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
	$sorgu2= mysql_query("SELECT * FROM mesajlar 
					WHERE mesaj_konu_id  =".$konuid." 
					order by mesaj_zamani asc limit ".$basla." , ".$limit."");
    $i=1;
    $style='';
	
	/// sayfalarken mesajlari #1 den n e kadar numaralandirmak için
	if(@$_GET['sayfa']>1)
	  {
	    $n = ($limit * $_GET['sayfa'])-($limit-1);
	  }else
	  {
	   $n=1;
	  }
	
      
   /// sayfalama yaparken listelenecek verileri listeliyoruz
    while ( $row = mysql_fetch_array($sorgu2) )
	{///dýþ while
     /// mesajrow tema motoruna ekliyoruz
	 
	 // mesaj yazan kullanýcýnýn verileri çekiliyor
	 $SQLKUL = mysql_query("SELECT * FROM kullanicilar 
							WHERE kul_id = '".$row["mesaj_author_id"]."'");
	$kul = mysql_fetch_array($SQLKUL);	
	
	if((($kul['kul_son_aktivite'] + $ayar["cevrimici_zaman_asimi"]) > time() ) and
        ($kul['kul_son_sayfa'] != 'sistem/cikis.php'))
	{
	 $mesaj_yazar_durum = '<font color="#339900">Online</font>';
	}
	else
	{
	 $mesaj_yazar_durum = '<font color="#CC0000">Offline</font>';

	}
	
    $template-> assign_block_vars('mesajrow', array(
	'MESAJ_ID'                => $row["mesaj_id"],
	'MESAJ_KONU_ID'           => $konuid,
	'MESAJ_BASLIK'            => $row["mesaj_baslik"],
	'MESAJ_GOVDE'             => $bbcode-> bb_to_html(stripslashes($row["mesaj_govde"])),
	'MESAJ_YAZAR'             => $row["mesaj_author"],
	'MESAJ_YAZAR_ID'          => $row["mesaj_author_id"],
	'MESAJ_IKONU'             => $row["mesaj_ikonu"],
	'MESAJ_YAZAR_IP'          => $row["mesaj_author_ip"],
	'MESAJ_EDIT_VAR'          => !empty($row["mesaj_edit_sebep"]) ? true:false,
	'MESAJ_SEBEP_VAR'         => !empty($row["mesaj_edit_sebep"]) ? true:false,
	'MESAJ_EDIT_SEBEP'        => $row["mesaj_edit_sebep"],
	'MESAJ_EDIT_ZAMAN'        => forum_tarihi($row["mesaj_edit_zaman"],$ayar['sistem_zaman_dilimi']),
	'MESAJ_EDIT_KIM'          => $row["mesaj_edit_kim"],
	'MESAJ_EDIT_KIM_ID'       => $row["mesaj_edit_kim_id"],
	'MESAJ_EDIT_SAYISI'       => $row["mesaj_edit_sayisi"],
	'MESAJ_YAZAR_IP'          => $row["mesaj_author_ip"],
	'MESAJ_TARIHI'            => tarih($row["mesaj_zamani"],$ayar['sistem_zaman_dilimi']),
	'MESAJ_KUL_AVATAR'        => ($kul["kul_avatar"]=="")? "resim/avatar_yok.png":$kul["kul_avatar"],
	'MESAJ_KUL_RUTBE_IMG'     => kul_group_rutbe_img($row["mesaj_author_id"]),
	'MESAJ_KUL_RUTBE'         => kul_group_rutbe($row["mesaj_author_id"]),
	'MESAJ_KUL_IMZA_VARMI'    => (!empty($kul["kul_imza"]))? true:false,
	'MESAJ_KUL_IMZA'          => $kul["kul_imza"],
	'MESAJ_KUL_EPOSTA'        => $kul["kul_email"],
	'MESAJ_KUL_KAYIT_TARIHI'  => konu_tarihi($kul["kul_kayit_zamani"],$ayar['sistem_zaman_dilimi']),
	'MESAJ_KUL_YER'           => ($kul["kul_yer"] =="")? "":$kul["kul_yer"],
	'MESAJ_KUL_DURUM'         => $mesaj_yazar_durum,
	'MESAJ_SAYISI'            => $n,
	'MESAJ_SAYFA'             => (@$_GET["sayfa"] =="")? "1":@temizle($_GET["sayfa"]),

	
	    ));	

		$n ++; //sayfa numarasý
	}///dýþ while Son


    $hangi_sayfa= ($gelen_sayfa > 0)? $gelen_sayfa : 1 ;
    $sayfala_cikis ="";
	
	 /// tema motoruna ekliyoruz PAREMETRE1
     $sayfala_cikis.= '';
     
     $alt= ($gelen_sayfa - $s_s);
     if($sayfa_sayisi <= $s_s || $gelen_sayfa <= $s_s ) {$alt=1;} 
     $ust= (($gelen_sayfa + $s_s)< $sayfa_sayisi ) ? ($gelen_sayfa + $s_s) : ($sayfa_sayisi);    
            
						
		/// tema motoruna ekliyoruz PAREMETRE2
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
		

		
  //  Eðer sayfa sayýsý 1 ise sayfalamayý gösterme   //	 
	 if($sayfa_sayisi > 1)
     $template->assign_vars(array( 'FORUM_ID'  => $konuid, 'SAYFALA'  => $sayfala_cikis ));
     else
     $template->assign_vars(array( 'FORUM_ID'  => $konuid, 'SAYFALA'  => "" ));
	   
}
else{
			/// Eðer sonuç yoksa
			$template->assign_vars(array( 'KONU_ID'  => $konuid,'SAYFALA'  => ""));
    }


///////////////////////// SAYFALAMA  BITTI  /////////////////////////////
############################################################################### 







////
$template->set_filenames(array('showthread' => 'showthread.html' ));

$template->display('showthread');


require_once("footer.php");

?>