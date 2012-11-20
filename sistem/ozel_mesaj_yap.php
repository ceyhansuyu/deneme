<?php
require_once("functions.php");
require_once("ayar.php");
require_once("../language/tr.php");

	session_start();
	// Ýstenmeyen durumlara karþýn. hack vb.
	if ($_SESSION['kul'] =="misafir")
	{
			header("location:../bilgiver.php?bilgi=yetkiniz_yok");
			exit();
	}
	// Ýstenmeyen durumlara karþýn. Son


	@$kime       	= temizle($_POST['kime']);
	@$baslik        = temizle($_POST['baslik']);
	@$mesaj_ikonu   = temizle($_POST['mesaj_ikonu']);
	@$mesaj 		= temizle($_POST['mesaj']);
	@$mesaj_tarihi	= time();
	@$gonderen 		= temizle($_SESSION['kul']);
	@$gonderen_id 	= temizle($_SESSION['kul_id']);

	@$ip 			= $_SERVER["REMOTE_ADDR"];  
	
	//$_POST['action'] =="Yeni Klasör Oluþtur"
	@$klasor_adi 	= temizle($_POST['klasor_adi']);
	@$klasor_renk 	= temizle($_POST['klasor_renk']);
	
	// ÖZEL MESAJ SÝL VERÝLERÝ
	@$do 	    = temizle($_GET['do']);
	@$pmID 	    = temizle($_GET['pmID']);
	@$klasor 	= temizle($_GET['klasor']);
	@$islem 	= $_POST['islem'];
	@$pm_id 	= $_POST['pm_id'];
	

	
  // GELEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ TAÞIYALIM VEYA SÝLELÝM 
  
  	if($do =="tasi_veya_sil" and $klasor =="gelen")
	{
	  
	  
	  if (empty($pm_id))
	  {
			header("location:../bilgiver.php?bilgi=islem_icin_secim_yok");
	 		exit();
	  }
	  
	  if($islem =="sil")
	  {
	  
	     //print_r($pm_id);

		  $n = 0;
		  foreach($pm_id as $key => $value)
		  {
				$pm_id[$n] = temizle($pm_id[$n]);
				$value = temizle($value);
		  
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							   alanin_kutusu  =''  
						WHERE  id =".$value." and kime_gonderdi_id='".$_SESSION["kul_id"]."'");
			 
			 
		  $n ++ ;
		  }// foreach
	  
	  }// if
	  
	  
	  	  // Eðer iþlem deðeri bir sayýysa bu klasor id dir
	  if(is_numeric($islem) == true)
	  {
	    
	    // echo $islem;
      
		  $n = 0;
		  foreach($pm_id as $key => $value)
		  {
				$pm_id[$n] = temizle($pm_id[$n]);
		  
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							    alanin_kutusu   ='',  
							    alan_klasorID   ='$islem'  
						WHERE  id =".$value." and kime_gonderdi_id='".$_SESSION["kul_id"]."'");
			 
			 
		  $n ++ ;
		  }// foreach
		  
	  }// if
	  
	
	}// ilk if

  // GELEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ TAÞIYALIM VEYA SÝLELÝM  BÝTTÝ
  
  
  
   // GÝDEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ TAÞIYALIM VEYA SÝLELÝM 
  
  	if($do =="tasi_veya_sil" and $klasor =="giden")
	{
	
	  if (empty($pm_id))
	  {
			header("location:../bilgiver.php?bilgi=islem_icin_secim_yok");
	 		exit();
	  }
	
	
	  // eðer tanýmlanan iþlem sil ise
	  if($islem =="sil")
	  {
	  
	     //print_r($pm_id);

		  $n = 0;
		  foreach($pm_id as $key => $value)
		  {
				$pm_id[$n] = temizle($pm_id[$n]);
				$value = temizle($value);
		  
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							    gonderenin_kutusu   =''  
						WHERE  id =".$value."");
			 
			 
		  $n ++ ;
		  }// foreach
	  
	  }// if
	  
	  // Eðer iþlem deðeri bir sayýysa bu klasor id dir
	  if(is_numeric($islem) == true)
	  {
	    
	    // echo $islem;
      
		  $n = 0;
		  foreach($pm_id as $key => $value)
		  {
				$pm_id[$n] = temizle($pm_id[$n]);
		  
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							    gonderenin_kutusu   ='',  
							    gonderen_klasorID   ='$islem'  
						WHERE  id =".$value." and kim_gonderdi_id='".$_SESSION["kul_id"]."'");
			 
			 
		  $n ++ ;
		  }// foreach
		  
	  }// if
	  
	
	}// ilk if

  // GÝDEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ TAÞIYALIM VEYA SÝLELÝM  BÝTTÝ
  
  
  

 
  
  
  // KLASÖRLER ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ TAÞIYALIM VEYA SÝLELÝM 
  
  	if($do =="tasi_veya_sil" and is_numeric($klasor) == true )
	{
	  
	  if (empty($pm_id))
	  {
			header("location:../bilgiver.php?bilgi=islem_icin_secim_yok");
	 		exit();
	  }
	
	
	  // eðer tanýmlanan iþlem sil ise
	  if($islem =="sil")
	  {
	  
	     //print_r($pm_id);

		  $n = 0;
		  foreach($pm_id as $key => $value)
		  {
				$pm_id[$n] = temizle($pm_id[$n]);
				$value = temizle($value);
		  
	        // öncelikle özel mesajý gönderen veya lan bu session id
	        $SQL_bul = mysql_query("SELECT * FROM ozel_mesaj WHERE id =".$value."");
			$SQLo = mysql_fetch_array($SQL_bul);
	
	        if($SQLo["kim_gonderdi_id"] == $_SESSION["kul_id"])
			{
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							        gonderenin_kutusu   ='',  
							        gonderen_klasorID   =''   
						WHERE  id =".$value."  ");
			
			}
			
			if($SQLo["kime_gonderdi_id"] == $_SESSION["kul_id"])
			
			{
			
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							        alanin_kutusu   ='',  
							        alan_klasorID   =''   
						WHERE  id =".$value."  ");
			}

			 
			 
		  $n ++ ;
		  }// foreach
	  
	     	if($SQL == true)	
			  {
				  header("location:../ozel_mesaj.php?do=klasor&klasorID=".$klasor.""); 
				  exit();
			  }
			  else
			  {
				echo "olmadý";
				exit();
			  }
	  
	  
	  }// if
	  
	  // Eðer iþlem deðeri bir sayýysa bu klasor id dir
	  if(is_numeric($islem) == true)
	  {
	    
	    // echo $islem;
      
		  $n = 0;
		  foreach($pm_id as $key => $value)
		  {
				$pm_id[$n] = temizle($pm_id[$n]);
		  
	           // öncelikle özel mesajý gönderen veya lan bu session id
	           $SQL_bul = mysql_query("SELECT * FROM ozel_mesaj WHERE id =".$value."");
			   $SQLo = mysql_fetch_array($SQL_bul);
			 
			if($SQLo["kim_gonderdi_id"] == $_SESSION["kul_id"])
			{
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							        gonderenin_kutusu   ='',  
							        gonderen_klasorID   ='$islem'   
						WHERE  id =".$value."  ");
			
			}
			
			if($SQLo["kime_gonderdi_id"] == $_SESSION["kul_id"])
			
			{
			
				$SQL = mysql_query("UPDATE ozel_mesaj set 
							        alanin_kutusu   ='',  
							        alan_klasorID   ='$islem'   
						WHERE  id =".$value."  ");
			}
			 
			 
			 
			 
			 
			 
		  $n ++ ;
		  }// foreach
		  
			  if($SQL == true)	
			  {
				  header("location:../ozel_mesaj.php?do=klasor&klasorID=".$klasor.""); 
				  exit();
			  }
			  else
			  {
				echo "olmadý";
				exit();
			  }
		  
		  
	  }// if
	  
	
	}// ilk if

  // KLASÖRLER ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ TAÞIYALIM VEYA SÝLELÝM  BÝTTÝ
  
  
  
  
  
  


	

  // GELEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ SÝL YANÝ KLASÖRÜNÜ GÜNCELLE
  
  	if($do =="pmSIL" and $klasor =="gelen")
	{
	  //HEMEN KLASÖR 
	  $SQL = mysql_query("UPDATE ozel_mesaj set
							   alanin_kutusu  =''
			                   WHERE id ='".$pmID."' and  
							   kime_gonderdi_id ='".$_SESSION["kul_id"]."'");
							   	  
	  if($SQL == true)	
	  {
	      header("location:../ozel_mesaj.php?do=gelen"); 
		  exit();
	  }
      else
	  {
	    echo "olmadý";
		exit();
	  }
	  
	
	}

  // GELEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ SÝL YANÝ KLASÖRÜNÜ GÜNCELLE BÝTTÝ



  
    // GÝDEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ SÝL YANÝ KLASÖRÜNÜ GÜNCELLE
  
  	if($do =="pmSIL" and $klasor =="giden")
	{
	  //HEMEN KLASÖR 
	  $SQL = mysql_query("UPDATE ozel_mesaj set
							   gonderenin_kutusu   =''
			                   WHERE id ='".$pmID."' and  
							   kim_gonderdi_id ='".$_SESSION["kul_id"]."'");
							   	  
	  if($SQL == true)	
	  {
	      header("location:../ozel_mesaj.php?do=giden"); 
		  exit();
	  }
      else
	  {
	    echo "olmadý";
		exit();
	  }
	  
	
	}

  // GÝDEN ÝÇÝN ÖZEL MESAJ VERÝLERÝNÝ SÝL YANÝ KLASÖRÜNÜ GÜNCELLE BÝTTÝ




	
	
	//KLASÖRLERÝ GÜNCELLE
	if  ($_POST['action'] =="Klasörleri Güncelle")
	{
		   $klasor_renk_guncelle 	= $_POST['klasor_renk_guncelle'];
		   $klasor_adi_guncelle 	= $_POST['klasor_adi_guncelle'];
		   $klasor_id               = $_POST['klasor_id'];
		
		  //echo count($klasor_id);
		  
		  $n = 0;
		  foreach($klasor_id as $key => $value)
		  {
				$klasor_adi_guncelle[$n] = temizle($klasor_adi_guncelle[$n]);
				$klasor_renk_guncelle[$n] = temizle($klasor_renk_guncelle[$n]);
				$value = temizle($value);
		  
				$SQL = mysql_query("UPDATE ozel_mesaj_klasor set 
						 kul_ID         ='$gonderen_id',
						 klasor_adi     ='$klasor_adi_guncelle[$n]',
						 klasor_resim   ='$klasor_renk_guncelle[$n]'  
						WHERE  klasorID =".$value."");
			 
			 
		  $n ++ ;
		  }// foreach
		  
		  if($SQL == true)	
		  {
			  header("location:../ozel_mesaj.php?do=yeni_klasor"); 
			  exit();
		  }
		  else
		  {
			echo "olmadý";
			exit();
		  }
	  
	  
	  
	}//KLASÖRLERÝ GÜNCELLE SON
	
	
	
	// OLUÞTURULAN ÖZEL MESAJ KLASÖRÜNÜ SÝL
	$do = temizle($_GET["do"]);
	
	if($do =="klasor_sil")
	{
	  $klasor_id = temizle($_GET["klasorID"]);
	  //HEMEN KLASÖR MEVCUTMU BÝR BAKALIM
	  $SQL = mysql_query("SELECT * FROM ozel_mesaj_klasor 
			                   WHERE kul_ID ='".$gonderen_id."'");
	  $klasor_say = mysql_num_rows($SQL);
	  
	  if($klasor_say =="0")
	  {
	  	  header("location:../bilgiver.php?bilgi=ozel_klasor_yok"); 
		  exit();
	  
	  }
	
      unset($SQL);
	  $SQL = mysql_query("delete  from ozel_mesaj_klasor 
						WHERE kul_ID ='".$gonderen_id."' and klasorID ='".$klasor_id."'");
		
	  // KLASÖRÜ SÝLÝNCE ÝÇÝNDEKÝ MESAJLAR DA SÝLÝNSÝN
	  
	  $SQL2 = mysql_query("update ozel_mesaj set
	                      gonderen_klasorID =''
						  WHERE  gonderen_klasorID  ='".$klasor_id."' ");
						
	  $SQL3 = mysql_query("update ozel_mesaj set
	                      alan_klasorID =''
						 WHERE alan_klasorID  ='".$klasor_id."'");
	
	  if($SQL == true and $SQL2 == true and $SQL3 == true)	
	  {
	      header("location:../ozel_mesaj.php?do=yeni_klasor"); 
		  exit();
	  }
      else
	  {
	    echo "olmadý";
		exit();
	  }
	  
	
	}
	
	
	
	
	
	
   if  ($_POST['action'] =="Yeni Klasör Oluþtur")
	{
	
		if(empty($klasor_adi) || empty($klasor_renk) )
        {		
		  header("location:../bilgiver.php?bilgi=klasor_ekleme_basarisiz"); 
		  exit();
        }	
		
		 $SQL = mysql_query("insert into ozel_mesaj_klasor set 
				   kul_ID         ='$gonderen_id',
				   klasor_adi     ='$klasor_adi',
				   klasor_resim   ='$klasor_renk'  
				   ");
	
	
		 if($SQL == true)	
		  {
			  header("location:../ozel_mesaj.php?do=yeni_klasor"); 
			  exit();
		  }
		  else
		  {
			echo "olmadý";
			exit();
		  }
	
	
	}
	
   
   if  ($_POST['action'] =="Yeni Özel Mesajý Gönder")
	{
	
		if(empty($baslik) || empty($mesaj) )
        {		
		  header("location:../bilgiver.php?bilgi=cvp_ekleme_basarisiz"); 
		  exit();
        }	


  /// ÖZEL MESAJ LÝMÝTÝ AYARDAKÝ VERÝYE ULÞTIYSA UYARI YAP   
   // GELEN VE GÝDEN  KUTUSUNU BÝR HESAPLAYALIM.
  
	$SQL_gelen = mysql_query("SELECT * FROM ozel_mesaj 
								WHERE  kime_gonderdi  ='".$_SESSION['kul']."'
								and  alanin_kutusu ='gelen'");
	$gelen_say = mysql_num_rows($SQL_gelen);	
	
	$SQL_giden = mysql_query("SELECT * FROM ozel_mesaj 
								WHERE  kim_gonderdi_id  ='".$_SESSION['kul_id']."'
								and   gonderenin_kutusu  ='giden'");
	$giden_say = mysql_num_rows($SQL_giden);
	
	//KLASÖRLERÝ VARSA  ONLARI DA HESABA KATALIM
	$klasordekimesajlar = mysql_query("SELECT SUM(icerdigi_mesaj_say) as total FROM ozel_mesaj_klasor
	                                WHERE   kul_ID  ='".$_SESSION['kul_id']."'");	
	
        		
	$klasor_mesaj = mysql_fetch_array($klasordekimesajlar);

	$klasordeki_mesajlar_say = $klasor_mesaj["total"] ;
	
	$say = $giden_say + $gelen_say + $klasordeki_mesajlar_say ;
	
	  if($ayar["ozel_mesaj_limiti"] <= $say)
	  {
		  header("location:../bilgiver.php?bilgi=pm_limiti_asildi"); 
		  exit();
	  
	  }
		
		
		
	
	  // Çoklu kullanýcý var mý?
	   $virgul_varmi = preg_match("/,/",$kime);
	   
	   if($virgul_varmi == true)
	   {
	     $kime = explode(",",$kime);
		 // Boþ anketler böylece temizleniyor
	     $silinsin=array(""," ");
         $kime = array_diff($kime,$silinsin);
		
		// GÝRÝLEN KULLANICI DB DE VAR MI BAKALIM
			foreach($kime as $value)
			{
			  // kullanýcý adýndan idsini bulalým
			  $SQL_soR = mysql_query("SELECT * FROM kullanicilar WHERE kul_adi ='".$value."'");
			  $kulcek = mysql_fetch_array($SQL_soR);
			  $kul_SAY = mysql_num_rows($SQL_soR);
			  
			  if($kul_SAY == 0) 
			  {
				header("location:../bilgiver.php?bilgi=kul_dbde_yok");
				exit();
			  } 
			}
		
		// GÝRÝLEN KULLANICI DB DE VAR MI BAKALIM soN
		
		
		$n = count($kime);
		foreach($kime as $value)
		{
		  		 
		  // kullanýcý adýndan idsini bulalým
		  $SQL_soR = mysql_query("SELECT * FROM kullanicilar WHERE kul_adi ='".$value."'");
		  $kulcek = mysql_fetch_array($SQL_soR);
		  
		         $SQL = mysql_query("insert into ozel_mesaj set 
				   kim_gonderdi        ='$gonderen',
				   kim_gonderdi_id     ='$gonderen_id',
				   kime_gonderdi       ='$value',
				   kime_gonderdi_id    ='".$kulcek["kul_id"]."',
				   mesaj_baslik        ='$baslik',
				   mesaj_ikon          ='$mesaj_ikonu',
				   mesaj_govde         = '$mesaj',
				   gonderme_zamani     ='$mesaj_tarihi',
				   gonderenin_kutusu   ='giden',
				   alanin_kutusu       ='gelen',
				   gonderen_klasorID   ='',	   
				   alan_klasorID       ='',	   
				   ip                  ='$ip'   
				   ");
		
		$n ++;
		}// foreach son
	   
	   }// if virgul var mi
	   
	  else
	  {
	  	 

		 
		  // kullanýcý adýndan idsini bulalým
		  $SQL_soR = mysql_query("SELECT * FROM kullanicilar WHERE kul_adi ='".$kime."'");
		  $kulcek = mysql_fetch_array($SQL_soR);
		  $kul_SAY = mysql_num_rows($SQL_soR);
		  
		  if($kul_SAY == 0) 
	      {
		    header("location:../bilgiver.php?bilgi=kul_dbde_yok");
		    exit();
		  } 
	
		   $SQL = mysql_query("insert into ozel_mesaj set 
		   kim_gonderdi        ='$gonderen',
		   kim_gonderdi_id     ='$gonderen_id',
		   kime_gonderdi       ='$kime',
		   kime_gonderdi_id    ='".$kulcek["kul_id"]."',
		   mesaj_baslik        ='$baslik',
		   mesaj_ikon          ='$mesaj_ikonu',
		   mesaj_govde         = '$mesaj',
		   gonderme_zamani     ='$mesaj_tarihi',
		   gonderenin_kutusu   ='giden',
		   alanin_kutusu       ='gelen',   
		   gonderen_klasorID   ='',	   
		   alan_klasorID       ='',		   
		   ip                  ='$ip'   
		   ");	
   
	 }// Virgul yoksa bitti
  }// Post action son
  
  
  


	   if ($SQL) 
	   header("location:../ozel_mesaj.php"); 
	   else
	   echo "hata var";
    ////*/ 
?>

