<?php
require_once("ayar.php");
require_once("functions.php");
require_once("../language/tr.php");

///////////////////  YAPILACAKLAR
///////////////////  1. S�L�NEN KONU �SE FORUMUN SON KONUSUNU DA G�NCELLE
///////////////////  2. S�L�NEN KONU �SE ABONEL�KLERDEN DE S�L


session_start();
// �stenmeyen durumlara kar��n.
if ($_SESSION['kul'] =="misafir" or $kul_izin['forum_silme'] =="hayir")
{
		header("location:../bilgiver.php?bilgi=silmek_icin_yetkiniz_yok");
		exit();
}


 
	$konuID	    = @t_id_temizle($_GET["t"]);
	$mesajID	= @mesaj_id_temizle($_GET["mesaj"]);
	
    if(!empty($konuID) and !empty($mesajID))
	{
	   // �nce silinecek olan mesaj as�l konunun mesaj�m� ona bakal�m
	   // E�er as�l konunun mesaj�ysa konuyu ve di�er mesajlar� da silelim.
	   
	   $SQL = mysql_query("select * from mesajlar 
							where mesaj_id ='".$mesajID."'");
		$row = mysql_fetch_array($SQL);
		
		//E�er sql do�ruysa yani mesaj konunun orjinal mesaj�ysa
		if($row["mesaj_durum"] =="konu")
		{
		   // ka� mesaj var
		   	$SQL_MESAJBUL = mysql_query("select * from mesajlar 
									where  mesaj_konu_id ='".$konuID."' and mesaj_durum ='' ");
			$konu_cevabi_say = mysql_num_rows($SQL_MESAJBUL);
		
		    $SQL_SIL = mysql_query("delete from mesajlar 
									where  mesaj_konu_id ='".$konuID."'");
		 
 		    $SQL_SIL2 = mysql_query("delete from konular 
									where konu_id ='".$konuID."'");
			
			// FORUMUN ANKET� VARSA ANKET� DE S�LECEZ MECBUREN
			//ANKET OYLRINI S�LEB�LMEM�Z ���N ANKET �D S� LAZIM
 		    $SQLanket = mysql_query("SELECT * from anket_option 
									where  anket_konu_id  ='".$konuID."'");
			$anket = mysql_fetch_array($SQLanket);
			$anketID = $anket["anket_id"];
			
 		    $SQL_SIL3 = mysql_query("delete from anket_option 
								  	where anket_konu_id ='".$konuID."'");
			//OYLARI DA S�LEL�M.
			
 		    $SQL_SIL4 = mysql_query("delete from anket_oylar 
								  	where anket_id ='".$anketID."'");
 		    
			//FORUMDAK� VER�LER� G�NCELLEYEL�M.

			
			$SQL_5 = mysql_query("update forumlar set 
									 forum_toplam_konu = forum_toplam_konu -1,
									 forum_toplam_mesaj = forum_toplam_mesaj - '$konu_cevabi_say'
								  	where forum_id ='".$row["mesaj_forum_id"]."'");
			
			
			//i�lemleri kontrol ediyoruz
			if($SQL_SIL == true and $SQL_SIL2 == true 
			and $SQL_SIL3 == true and $SQL_SIL4 == true)
			{
			   header("location:../forumdisplay.php?f=".$row["mesaj_forum_id"]."");
			   exit();
			}
			else
			{
			  echo "SQL_SIL i�lemlerinde hata var";
			  exit();
			}
		
		}
		// E�er mesaj konunun orjinal mesaj� de�ilse
		else if($row["mesaj_durum"] =="")
		{
		    $SQL = mysql_query("select * from mesajlar where mesaj_id ='".$mesajID."'"); 
			$row = mysql_fetch_array($SQL);

		    $SQL_SIL = mysql_query("delete from mesajlar 
									where mesaj_id ='".$mesajID."'");

		//FORUMDAK� VER�LER� G�NCELLEYEL�M.
			$SQL_5 = mysql_query("update forumlar set 
									 forum_toplam_mesaj = forum_toplam_mesaj - 1
								  	where forum_id ='".$row["mesaj_forum_id"]."'");
			
			//i�lemleri kontrol ediyoruz
			if($SQL_SIL == true)
			{
			   header("location:../showthread.php?t=".$konuID."");
			   exit();
			}
			else
			{
			  echo "SQL_SIL i�lemlerinde hata var";
			  exit();
			}
		}
	
	}// if konuid felan
	

	
?>

