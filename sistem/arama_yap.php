<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");


   session_start();
   // Ýstenmeyen durumlara karþýn. Son
	$anahtar_kelime        = temizle($_POST['anahtar_kelime']);
	$kul_adiyla            = temizle($_POST['kul_adiyla']);
	$sonuc_goster 		   = temizle($_POST['sonuc_goster']);
	$sonuc_cesit 		   = $_POST['sonuc_sort'];// ASC veya DESC
	$select_konu1	       = $_POST['select_konu'];
	$kim_aradi	           = $_SESSION['kul_id'];
	$arama_zamani	       = time();
	@$guvenlik_kodu	       = temizle($_POST['guvenlik_kodu']);
	$ip 			       = $_SERVER["REMOTE_ADDR"];  

    
	  //
	  if($_SESSION["kul"] == "misafir")
       {
			 //EÐER CAPTHA RECAPTHA ÝSE
				   if($ayar["reCAPTCHA_aktif_mi"] =="acik")
				   {
					   require_once('reCAPTCHAlib.php');
					   $privatekey = $ayar["reCAPTCHA_privatekey"];
					   
					   $resp = recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$_POST["recaptcha_challenge_field"],
											$_POST["recaptcha_response_field"]);
						
						if (!$resp->is_valid)
						{
							// What happens when the CAPTCHA was entered incorrectly
							header("location:../bilgiver.php?bilgi=guvenlik_kodu_hatasi"); 
							exit();
						} 

				   
				   }
				   // diðer güvenli doðrulama sistemi
				   else
				   {
						  if($_SESSION["captcha"] != $guv_kodu)
						   {
							header("location:../bilgiver.php?bilgi=guvenlik_kodu_hatasi"); 
							exit();
						   }
				   
				   }
       }

	   
	   
	   ///////// 2 ARAMA ARASINA SÜRE KOYALIM KÝ FLOOD YAPILMASIN ////////////
	   $SQL = mysql_query("SELECT * FROM yapilan_aramalar 
							WHERE kim_aradi ='".$_SESSION["kul_id"]."' and kim_aradi_ip='".$ip."'
 							order by arama_zamani DESC");
	   $sor = mysql_fetch_array($SQL);
	   
	   if( $ayar["arama_flood_aralik"] > ($arama_zamani - $sor["arama_zamani"]))
	   {
			header("location:../bilgiver.php?bilgi=arama_flood"); 
			exit();	
	   }
	   
	   ///////// 2 ARAMA ARASINA SÜRE KOYALIM KÝ FLOOD YAPILMASIN BÝTTÝ////////////


	   
	   // Eðer aranýlan þey daha önceden arandýysa onu arama id sine yollayalým.
        $SQL_arabak = mysql_query("SELECT * FROM yapilan_aramalar 
							WHERE aranan_kelime  ='".$anahtar_kelime."' 
							and aranan_kullanici   ='".$kul_adiyla."'
							and sonuc_nasil_goster ='".$sonuc_goster."'
							and sonuc_sort         ='".$sonuc_cesit."'
							order by arama_zamani desc limit 1");
	    $sonuc_Say = mysql_num_rows($SQL_arabak);
		
		if($sonuc_Say > 0)
		{
		  $fetch = mysql_fetch_array($SQL_arabak);
		  header("location:../search.php?aramaid=".$fetch["arama_id"]."");
		  exit();
		}
     

	 
	  // Eðer kat dðeri varsa kategoriye ait tüm forumlarý deðere katalým
	     foreach($select_konu1 as $key => $value)
		 {
           if(preg_match("/kat/",$value))
		   {
		     $parcala = explode("kat",$value);
			 $SQL = mysql_query("SELECT * FROM forumlar WHERE kat_id='".$parcala[1]."'");
			 unset($select_konu1[$key]);
			 $key= 0;
			 while($row = mysql_fetch_array($SQL))
			 {
			  $select_konu1[] = $row["forum_id"];
			 }
		     
		   }
		 }
		 
		 // 2'defa veya fazla olaný atýcak
		$select_konu1 = array_unique($select_konu1);
	
	
	  // Eðer altvar dðeri varsa kategoriye ait tüm forumlarý deðere katalým
	     foreach($select_konu1 as $key => $value)
		 {
           if(preg_match("/altvar/",$value))
		   {
		     $parcala = explode("altvar",$value);
			 $SQL = mysql_query("SELECT * FROM forumlar WHERE  forum_ust_f ='".$parcala[1]."'");
			 unset($select_konu1[$key]);
			 $select_konu1[] = $parcala[1];
			 $key= 0;
			 while($row = mysql_fetch_array($SQL))
			 {
			  $select_konu1[] = $row["forum_id"];
			 }
		     
		   }
		 }
		 
		 // 2'defa veya fazla olaný atýcak
		$select_konu1 = array_unique($select_konu1);
		
		//print_r($select_konu1);

		
	 
	//$select_konu2 = explode("",$select_konu1);
	
    if (count($select_konu1) == 1) $select_konu = $select_konu1[0];
	
	// Select ten birden fazla aranacak yer seçildiyse
	if(count($select_konu1) > 1)
	{
        $n = 1;
		foreach($select_konu1 as $deger)
		{
	      if ($n == count($select_konu1))
	      @$sonuc .= $deger;
		  else
          @$sonuc .= $deger.",";
		
		$n ++;
		}
		
		$select_konu =  $sonuc;

	
	}
 
	
	//Ana kontroller
	if($anahtar_kelime =="" and $kul_adiyla =="" or $select_konu =="")
	{
		header("location:../bilgiver.php?bilgi=arama_kriteri_yok");
		exit();
	}
	
	// ya anahtar kelime ya da kullanýcý adýyla ikisi birden olmaz
	if($anahtar_kelime !="" and $kul_adiyla !="" )
	{
		header("location:../bilgiver.php?bilgi=anahtar_kelime_veya_kullanici");
		exit();
	}
	
	
###########################	ANAHTAR KELÝME ARANIYOR #############################

	// Þartlar uygunsa arama yapýlan kelimeyi db ye kayýt ettirelim
	if($anahtar_kelime !="" and $kul_adiyla =="" and $sonuc_goster =="konularda" )
	{
		
       $SQL = mysql_query("insert into  yapilan_aramalar set 
	            aranan_kelime        ='$anahtar_kelime',
	            aranan_kullanici     ='',
	            kim_aradi            ='$kim_aradi',
	            kim_aradi_ip         ='$ip',
	            nerede_aradi         ='$select_konu',
	            sonuc_nasil_goster   ='konularda',
	            sonuc_sort           ='$sonuc_cesit',
	            arama_zamani         ='$arama_zamani'
	   ");
		
		// Yukarýda yapýlan insert iþleminin idsi
		$usttekiid = mysql_insert_id();

		header("location:../search.php?aramaid=".$usttekiid."");
		exit();
		//$SQL = mysql_query("SELECT * FROM konular like '%".$anahtar_kelime."%'");
	}

	
	
	// Þartlar uygunsa arama yapýlan kelimeyi db ye kayýt ettirelim
	if($anahtar_kelime !="" and $kul_adiyla =="" and $sonuc_goster =="mesajlarda" )
	{
		
       $SQL = mysql_query("insert into  yapilan_aramalar set 
	            aranan_kelime       ='$anahtar_kelime',
	            aranan_kullanici    ='',
	            kim_aradi           ='$kim_aradi',
	            kim_aradi_ip         ='$ip',
	            nerede_aradi        ='$select_konu',
	            sonuc_nasil_goster  ='mesajlarda',
	            sonuc_sort          ='$sonuc_cesit',
	            arama_zamani        ='$arama_zamani'
	   ");
		
		// Yukarýda yapýlan insert iþleminin idsi
		$usttekiid = mysql_insert_id();

		header("location:../search.php?aramaid=".$usttekiid."");
		exit();
		//$SQL = mysql_query("SELECT * FROM konular like '%".$anahtar_kelime."%'");
	}
	
	
###########################	KULLANICI ARANIYOR #############################

	// anahtar kelime dolu  kullanýcý boþsa hemen nerde_ara_kelime ye bakarýz
	// Þartlar uygunsa arama yapýlan kelimeyi db ye kayýt ettirelim
	if($anahtar_kelime =="" and $kul_adiyla !="" and $sonuc_goster =="konularda" )
	{
		
       $SQL = mysql_query("insert into  yapilan_aramalar set 
	            aranan_kelime        ='',
	            aranan_kullanici     ='$kul_adiyla',
	            kim_aradi            ='$kim_aradi',
	            kim_aradi_ip         ='$ip',
	            nerede_aradi         ='$select_konu',
	            sonuc_nasil_goster   ='konularda',
	            sonuc_sort           ='$sonuc_cesit',
	            arama_zamani         ='$arama_zamani'
	   ");
		
		// Yukarýda yapýlan insert iþleminin idsi
		$usttekiid = mysql_insert_id();

		header("location:../search.php?aramaid=".$usttekiid."");
		exit();
		//$SQL = mysql_query("SELECT * FROM konular like '%".$anahtar_kelime."%'");
	}

	
	
	// Þartlar uygunsa arama yapýlan kelimeyi db ye kayýt ettirelim
	if($anahtar_kelime =="" and $kul_adiyla !="" and $sonuc_goster =="mesajlarda" )
	{
		
       $SQL = mysql_query("insert into  yapilan_aramalar set 
	            aranan_kelime    ='',
	            aranan_kullanici     ='$kul_adiyla',
	            kim_aradi            ='$kim_aradi',
	            kim_aradi_ip         ='$ip',
	            nerede_aradi         ='$select_konu',
	            sonuc_nasil_goster   ='mesajlarda',
	            sonuc_sort           ='$sonuc_cesit',
	            arama_zamani         ='$arama_zamani'
	   ");
		
		// Yukarýda yapýlan insert iþleminin idsi
		$usttekiid = mysql_insert_id();

		header("location:../search.php?aramaid=".$usttekiid."");
		exit();
		//$SQL = mysql_query("SELECT * FROM konular like '%".$anahtar_kelime."%'");
	}
	

	
	///*/
	
?>

