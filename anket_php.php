<?php
require_once("baslik.php");



	
///////// ANKET VAR MI B�R BAKALIM //////////////	
@$do = temizle($_GET["do"]);
if(is_numeric($do)) $do ="anket_sonuc";


$anket_sql = mysql_query("SELECT * FROM anket_option WHERE anket_konu_id =".$konuid."");
$anket_say = mysql_num_rows($anket_sql);
$anket = mysql_fetch_array($anket_sql);

if($anket_say > 1) echo "Hata var!! Dbdeki konuya ait anket say�s� 1 olmal�";

if($anket_say != 1) $template->assign_vars(array( 'ANKET_VAR'    =>  false));
  
//E�ER do = anket_sonuc ise anket sonucunu g�ster
if($do == "anket_sonuc")
{
   	$template->assign_vars(array( 'ANKET_SONUC'  =>  true));
	
    $SQL_kul_anket = mysql_query("SELECT * FROM anket_oylar
						WHERE  anket_id = '".$anket["anket_id"]."' 
						and  oyveren_kul_id = '".$_SESSION['kul_id']."'");
	$say_sql_kul_anket = mysql_num_rows($SQL_kul_anket);
	
	$kul_oyu = mysql_fetch_array($SQL_kul_anket);
	
	//FOREACH ���NDE KULLANILACAK
	 // Anket Se�eneklerini temizliyoruz
	 $secenekler = $anket["anket_secenekleri"];
	 $secenek = explode("|||",$secenekler);
	 $id_sec = 0;
	 
	 // Toplam oysay�s�n� bulal�m
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
			'TOPLAM_SEC_OYU' => ($secenek1[$id_sec]>0)? $secenek1[$id_sec]." ki�i oylam��.":"",
			'YUZDE'         => @round((100 * $secenek1[$id_sec])/$toplam_oy,2),
			));	
			
		
			
			
			$id_sec ++;
		 }//FOREACH SON	
		 

	

} 

else  
{
        $template->assign_vars(array( 'ANKET_SONUC'  =>  false));

} 




//E�ER KONUDA AKT�F B�R ANKET VARSA HEMEN KULLANICI OY VERM��M� VE DE 
// ANKET �OKLU OYA M�SA�T M�? KONTROL EDEL�M
if($anket_say == 1) 
  {
    $template->assign_vars(array( 'ANKET_VAR'  =>  true));
	 

	$SQL_kul_anket = mysql_query("SELECT * FROM anket_oylar
						WHERE  anket_id = '".$anket["anket_id"]."' 
						and  oyveren_kul_id = '".$_SESSION['kul_id']."'");
	$say_sql_kul_anket = mysql_num_rows($SQL_kul_anket);
	
	$kul_oyu = mysql_fetch_array($SQL_kul_anket);
//FOREACH ���NDE KULLANILACAK
	 // Anket Se�eneklerini temizliyoruz
	 $secenekler = $anket["anket_secenekleri"];
	 $secenek = explode("|||",$secenekler);
	 $id_sec = 0;
		  
	//E�ER KULLANICI ANKETE DAHA OY VERMED�YSE
	if($say_sql_kul_anket == 0)
	{   //G�NDER BUTONUNU Y�NET�YORUZ
	    $template->assign_vars(array(
		     'DISABLED'  => '',
			 'ANKET_ACIKLAMA'   => ($anket["anket_oy_degistir"] =="oy_degistir")? "Bu anketteki oylar sonradan <b>de�i�tirilebilir.</b>":"Bu anketteki oylar sonradan <b>de�i�tirilemez.</b>",
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
	// KULLANICI OY VERD�YSE VE ANKET DE���T�R�LE�L�RSE
	else if($say_sql_kul_anket == 1 and $anket["anket_oy_degistir"] =="oy_degistir")
	{
	    //G�NDER BUTONUNU Y�NET�YORUZ
	    $template->assign_vars(array(
			'DISABLED'         => '',
			'ANKET_ACIKLAMA'   => "Bu ankete oy verdiniz. Bu anketteki oylar sonradan <b>de�i�tirilebilir.</b>",
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
	
	// KULLANICI OY VERD�YSE VE ANKET DE���T�R�LEMEZSE
	else if($say_sql_kul_anket == 1 and $anket["anket_oy_degistir"] =="")
	{
	    //G�NDER BUTONUNU Y�NET�YORUZ
	    $template->assign_vars(array(
			'DISABLED'         => 'disabled="disabled"',
			'ANKET_ACIKLAMA'   => "Bu ankete oy verdiniz. Bu anket <b>de�i�tirilemez.</b>",
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

///////// ANKET VAR MI B�R BAKALIM SON //////////////	



?>