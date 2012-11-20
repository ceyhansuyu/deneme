<?php

$SQLserver = "localhost";
$SQLuser = "root";
$SQLpassword ="";
$database= "sil";



$SQL = mysql_query('SELECT u.user_id, u.user_type,  s.session_browser, s.session_forum_id
	FROM users u, sessions s
	WHERE u.user_id = s.session_user_id') ;



$baglan = mysql_connect ("$SQLserver", "$SQLuser", "$SQLpassword") or die ("MySql Baglantisinda Hata");
@mysql_select_db ("$database") or die ("Üye Veritabanina Baglanilamadi");

/*
$oturum ="fdsterewrew543543543rwewrewrewrew";
			setcookie('f_hatirla', $oturum ,time() + 2500000 ,"/deneme" );
*/
		/*	UPDATE product p
INNER JOIN productPrice pp
ON p.productId = pp.productId
SET pp.price = pp.price * 0.8
WHERE p.dateCreated < '2004-01-01'
	*/		
		/*	UPDATE product
			INNER JOIN product_price
			ON product.productId = product_price.productId
			SET product_price.price = product_price.price * 1.5
			WHERE product.dateCreated < '2009-10-23'
		*/	
			
		$SQL = mysql_query("
		UPDATE konular INNER JOIN forumlar ON konular.fid = forumlar.id
		SET  
		forumlar.f_toplam_cevap = forumlar.f_toplam_cevap +5,
		konular.k_toplam_cevap = konular.k_toplam_cevap +5
		
		WHERE forumlar.id = 1
		");

 if ($SQL)
 echo "oldu";
 else
 echo "oldu";

 
 
 
 
?>