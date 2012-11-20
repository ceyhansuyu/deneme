<?php
require_once("genel.php");


//SAYFA DETAYLARI
    $baslik= "Üye Listesi";
	$sayfa_url ="uye_listesi.php";
	$menu = '<a href="index.php">Anasayfa</a> > 
	<a href="uye_listesi.php">Üye Listesi</a>';
	
	// Kullanýcý koordinat
   	kul_koordinat($baslik ,$sayfa_url);
		
	$template->assign_vars(array(
		'BASLIK'        => $baslik,
		'MENU'          => $menu,	
	    'SEO_AKTIFSE'       => ($ayar["seo_durum"] =="acik") ? true:false,
	
	));
//SAYFA DETAYLARI
require_once("baslik.php");



 // FORUMDA KÝMLER DOLANIYOR HEMEN BULALIM
 $son_sayfa ="uye_listesi.php";
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












///////////////////////// SAYFALAMA  BASLADI  /////////////////////////////

$gelen_sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] !='')? intval($_GET['sayfa']) : 1;
//Baglanilacak Tablo
$tablo = 'konular';

//Sayafalamayi yapan dosyanin adi
$link = 'uye_listesi.php';

//Sayfada kaç kayit görünecek
// öncelikle ayarlardan çekelim

$limit= $ayar["sayfala_limit_konu"];

//Kaç sayfa öncesi ve sonrasi görünecek
$s_s = 3;


// konu mesaj sayfalamak için
$SQL10 = mysql_query("SELECT * FROM kullanicilar  order by kul_adi"); 
$satir = mysql_num_rows($SQL10);

	
$template->assign_vars(array( 'KUL_SAYISI' => $satir, ));

if($satir >0)
{//sonuç varsa
    //sonuç varsa konu yok deðeri demek yanlýþ olur.
    $template->assign_vars(array( 'KUL_YOK'  => false ));
 
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
	$sorgu2= mysql_query("SELECT * FROM kullanicilar 
					order by kul_adi limit ".$basla." , ".$limit."");
    $i=1;
    $style='';
	
	 while ( $row = mysql_fetch_array($sorgu2) )
	{///dýþ while
	###### UFAK SAYFALAMA LÝNKLERÝNÝ OLUÞTURALIM ##########
	
	$gelen_sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] !='')? intval($_GET['sayfa']) : 1;


	/// konurow tema motoruna ekliyoruz
    $template-> assign_block_vars('uyerow', array(
	'KUL_ID'              => $row["kul_id"],
	'KUL_ADI'             => $row["kul_adi"],
	'KUL_ADI_SEO'         => seo($row["kul_adi"]),
	'RENK'                => kul_group_color($row["kul_id"]),
	'KUL_EPOSTA'          => $row["kul_email"],

	'KUL_KAYIT_TARIHI'    => @konu_tarihi($row["kul_kayit_zamani"],$ayar["sistem_zaman_dilimi"]) ,
	));	
		

}///dýþ while Son



	
    $hangi_sayfa= ($gelen_sayfa > 0)? $gelen_sayfa : 1 ;
    $sayfala_cikis ="";
	
     $sayfala_cikis.= '';
     
     $alt= ($gelen_sayfa - $s_s);
     if($sayfa_sayisi <= $s_s || $gelen_sayfa <= $s_s ) {$alt=1;} 
     $ust= (($gelen_sayfa + $s_s)< $sayfa_sayisi ) ? ($gelen_sayfa + $s_s) : ($sayfa_sayisi);    
            
						
		if ($gelen_sayfa > 1 ) 
		$sayfala_cikis.= '<a href="'.$link.'?sayfa=1" id="sayfalamaLink" title="Ýlk Sayfa">« Ýlk </a> 
		 &nbsp;<a href="'.$link.'?sayfa='.($gelen_sayfa -1).'" 
		title="Önceki Sayfa" id="sayfalamaLink"><</a>';
		else $sayfala_cikis.= "";
			
            for($i=$alt; $i<=$ust ;$i++)
			{       
		      if ($i != $gelen_sayfa ) $sayfala_cikis.= ' <a title="'.$i.'. Sayfa" href="'.$link.'?sayfa='.$i.'" id="sayfalamaLink">'.$i.'</a>' ;
		      else $sayfala_cikis.= ' <span id="sayfalamaLink_Aktif">'.$i.'</span>';
           }
            				
		if ($gelen_sayfa < $sayfa_sayisi) 
		$sayfala_cikis.= ' <a href="'.$link.'?sayfa='.($gelen_sayfa +1).'" title="Sonraki Sayfa" id="sayfalamaLink">
		></a> <a href="'.$link.'?sayfa='.$sayfa_sayisi.'" title="Son Sayfa" id="sayfalamaLink"> Son »</a>' ;

		else $sayfala_cikis.= "";
		
		
	 
  //  Eðer sayfa sayýsý 1 ise sayfalamayý gösterme    //	 
	 if($sayfa_sayisi > 1)
     $template->assign_vars(array(  
									'SAYFALA'  => $sayfala_cikis,
									'S_VAR'  => (10 > 1)? true : false ));
	    else
		  $template->assign_vars(array( 'FORUM_ID'  => $fid, 
									'SAYFALA'  => "", 'S_VAR'  => (10 < 1)? true : false ));
}
else{ // Eðer forumdisplay ye ait konu yoksa

		 $template->assign_vars(array( 

		 'KUL_YOK'  	  =>  true , //sonuç yoksa konu yok deðeri doðrudur.
		 'S_VAR'          => (10 < 1)? true : false,  //Varsa true
		 'SAYFALA'        => ""
		 ));
	
    }

 mysql_free_result($SQL10);
 unset($SQL10);
///////////////////////// SAYFALAMA  BITTI  /////////////////////////////





$template->set_filenames(array('uye_listesi' => 'uye_listesi.html' ));

$template->display('uye_listesi');

require_once("footer.php");

?>