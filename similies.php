<?php



/// Smileys
				/// Konu ikonlarini yapalim // Basla
				$klasorQ = "resim/smilies";
				$handleQ= opendir($klasorQ);
				while ($fileQ = readdir($handleQ)) 
				  {
					 $filelistQ[] = $fileQ;
				  }
				  asort($filelistQ);
				  
				  // 5 olunca tr bastýr
				   $Q = 0;
					while (list ($a, $fileQ) = each ($filelistQ)) 
					{
					   // gif olanlarý alma
					   $gif_bul = preg_match("/.gif/",$fileQ);
					
					  if($fileQ=="Thumbs.db" or $fileQ=="."  or $fileQ==".." or $fileQ=="index.html" or $gif_bul == true )// eger dosya içinde resimden baska seyler varsa onlari isleme almayalim.
					  {
						$fileQ ="";
					  }
					  else
					  {
					  
					  //4 yazýnca ilk üçü bastýrýyor sonradan düzene giriyor
					  if($Q==4) $Q = 10;
						  /// TEma motoruna bilgileri atalim
						  $template->assign_block_vars('smiliesrow',array(
						  'FILE'  => $fileQ,
						  'IMG_SRC' => $klasorQ."/".$fileQ,
						  'TRLER'     => ($Q % 4 == 0)? "</tr><tr>":"",

						  ));  
					  }// if bitti
                 $Q ++;
				}/// while bitti

	
			
 // Smilies biter


?>