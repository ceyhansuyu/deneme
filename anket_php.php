<?php
require_once("baslik.php");



	
///////// ANKET VAR MI BÝR BAKALIM //////////////	
@$do = temizle($_GET["do"]);
if(is_numeric($do)) $do ="anket_sonuc";


$anket_sql = mysql_query("SELECT * FROM anket_option WHERE anket_konu_id =".$konuid."");
$anket_say = mysql_num_rows($anket_sql);
$anket = mysql_fetch_array($anket_sql);

if($anket_say > 1) echo "Hata var!! Dbdeki konuya ait anket sayýsý 1 olmalý";

if($anket_say != 1) $template->assign_vars(array( 'ANKET_VAR'    =>  false));
  
//EÐER do = anket_sonuc ise anket sonucunu göster
if($do == "anket_sonuc")
{
   	$template->assign_vars(array( 'ANKET_SONUC'  =>  true));
	
    $SQL_kul_anket = mysql_query("SELECT * FROM anket_oylar
						WHERE  anket_id = '".$anket["anket_id"]."' 
						and  oyveren_kul_id = '".$_SESSION['kul_id']."'");
	$say_sql_kul_anket = mysql_num_rows($SQL_kul_anket);
	
	$kul_oyu = mysql_fetch_array($SQL_kul_anket);
	
	//FOREACH ÝÇÝNDE KULLANILACAK
	 // Anket Seçeneklerini temizliyoruz
	 $secenekler = $anket["anket_secenekleri"];
	 $secenek = explode("|||",$secenekler);
	 $id_sec = 0;
	 
	 // Toplam oysayýsýný bulalým
	       $secenekler1 = $anket["anket_oylari_toplam"];
		   $secenek1 = explode("|||",$secenekler1);
		   
		   $toplam_oy = array_sum($secenek1);
		   
		   //print_r($secenek1);
		   
		   //echo $toplam_oy;
	 
	 	foreach($secenek as $sade_secenek)
		  {
		  
		   $secenekler1 = $anket["anket_oylari_toplam"];
		   $secenek1 = explode("|||",$secenekler1);
		   
		 
		  
		  /// sonucrow tema motoruna ekliyoruz
			$template-> assign_block_vars('sonucrow', array(
			'SECENEK_KEY_ID' => $id_sec,
			'SECENEK'        => $sade_secenek,
			'KUL_OYU'      => ($say_sql_kul_anket >0 and $kul_oyu['oy_hangi_keyde']==$id_sec)? '<span style="color:#CC0000"><strong>* Sizin oyunuz</strong></span>':"",
			'TOPLAM_SEC_OYU' => ($secenek1[$id_sec]>0)? $secenek1[$id_sec]." kiþi oylamýþ.":"",
			'YUZDE'         => @round((100 * $secenek1[$id_sec])/$toplam_oy,2),
			));	
			
		
			
			
			$id_sec ++;
		 }//FOREACH SON	
		 

	

} 

else  
{
        $template->assign_vars(array( 'ANKET_SONUC'  =>  false));

} 




//EÐER KONUDA AKTÝF BÝR ANKET VARSA HEMEN KULLANICI OY VERMÝÞMÝ VE DE 
// ANKET ÇOKLU OYA MÜSAÝT MÝ? KONTROL EDELÝM
if($anket_say == 1) 
  {
    $template->assign_vars(array( 'ANKET_VAR'  =>  true));
	 

	$SQL_kul_anket = mysql_query("SELECT * FROM anket_oylar
						WHERE  anket_id = '".$anket["anket_id"]."' 
						and  oyveren_kul_id = '".$_SESSION['kul_id']."'");
	$say_sql_kul_anket = mysql_num_rows($SQL_kul_anket);
	
	$kul_oyu = mysql_fetch_array($SQL_kul_anket);
//FOREACH ÝÇÝNDE KULLANILACAK
	 // Anket Seçeneklerini temizliyoruz
	 $secenekler = $anket["anket_secenekleri"];
	 $secenek = explode("|||",$secenekler);
	 $id_sec = 0;
		  
	//EÐER KULLANICI ANKETE DAHA OY VERMEDÝYSE
	if($say_sql_kul_anket == 0)
	{   //GÖNDER BUTONUNU YÖNETÝYORUZ
	    $template->assign_vars(array(
		     'DISABLED'  => '',
			 'ANKET_ACIKLAMA'   => ($anket["anket_oy_degistir"] =="oy_degistir")? "Bu anketteki oylar sonradan <b>deðiþtirilebilir.</b>":"Bu anketteki oylar sonradan <b>deðiþtirilemez.</b>",
			 ));

		  foreach($secenek as $sade_secenek)
		  {
		  /// secenekrow tema motoruna ekliyoruz
			$template-> assign_block_vars('secenekrow', array(
			'SECENEK_KEY_ID'     => $id_sec,
			'SECENEK'            => $sade_secenek,
			'DISABLED'           => '',
			'KUL_OYU'           => "",
			));	
			
			$id_sec ++;
		 }//FOREACH SON	
			
	}
	// KULLANICI OY VERDÝYSE VE ANKET DEÐÝÞTÝRÝLEÝLÝRSE
	else if($say_sql_kul_anket == 1 and $anket["anket_oy_degistir"] =="oy_degistir")
	{
	    //GÖNDER BUTONUNU YÖNETÝYORUZ
	    $template->assign_vars(array(
			'DISABLED'         => '',
			'ANKET_ACIKLAMA'   => "Bu ankete oy verdiniz. Bu anketteki oylar sonradan <b>deðiþtirilebilir.</b>",
			));

		foreach($secenek as $sade_secenek)
		  {
		  /// secenekrow tema motoruna ekliyoruz
			$template-> assign_block_vars('secenekrow', array(
			'SECENEK_KEY_ID'     => $id_sec,
			'SECENEK'            => $sade_secenek,
			'DISABLED'           => '',
			'KUL_OYU'           => ($kul_oyu['oy_hangi_keyde']==$id_sec)? 'checked="checked"':"",
			));	
			
			$id_sec ++;
		 }//FOREACH SON	
		 
	 
	}
	
	// KULLANICI OY VERDÝYSE VE ANKET DEÐÝÞTÝRÝLEMEZSE
	else if($say_sql_kul_anket == 1 and $anket["anket_oy_degistir"] =="")
	{
	    //GÖNDER BUTONUNU YÖNETÝYORUZ
	    $template->assign_vars(array(
			'DISABLED'         => 'disabled="disabled"',
			'ANKET_ACIKLAMA'   => "Bu ankete oy verdiniz. Bu anket <b>deðiþtirilemez.</b>",
			));
		
		foreach($secenek as $sade_secenek)
		  {
		  /// secenekrow tema motoruna ekliyoruz
			$template-> assign_block_vars('secenekrow', array(
			'SECENEK_KEY_ID'     => $id_sec,
			'SECENEK'            => $sade_secenek,
			'DISABLED'           => 'disabled="disabled"',
			'KUL_OYU'           => ($kul_oyu['oy_hangi_keyde']==$id_sec)? 'checked="checked"':"",
			));	
			
			$id_sec ++;
		 }//FOREACH SON	


	}

	 
  }// $anket_say == 1 SON
  
  $template->assign_vars(array( 
			'ANKET_SORUSU'   => $anket["anket_sorusu"],
			'KONU_ID'        => $konuid,			
			'ANKET_ID'       => $anket["anket_id"],			
			'ANKET_DUZEN_IZIN'  => (@$kul_izin["anket_duzenleme"] =="evet")? true:false ,			
			'ANKET_SURELI'   => (!empty($anket["anket_bitis_suresi"])) ? true:false,
			'ANKET_SURESI'   => @konu_tarihi($anket["anket_bitis_suresi"],$ayar["sistem_zaman_dilimi"]),			
			));
  


	
unset($anket_sql);

///////// ANKET VAR MI BÝR BAKALIM SON //////////////	



?>