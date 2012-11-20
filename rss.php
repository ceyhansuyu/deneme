<?xml version="1.0" encoding="ISO-8859-9"?>
<?php  
include("sistem/ayar.php");
include("sistem/functions.php");
?>
<rss version="2" xml:lang="tr-TR">
	<channel>
		<title><?php echo $ayar["sitename"]; ?></title>
		<link>index.php</link>
		<description><![CDATA[<?php echo $ayar["site_desc"]; ?>]]></description>
		
		<?php
	  	  $SQL  = mysql_query("select * from konular order by konu_id desc limit 5 ");
		  while($konu = mysql_fetch_array($SQL))
		  {
		    $mesajSQL = mysql_query("select * from mesajlar 
										where  mesaj_durum ='konu' 
										and  mesaj_konu_id ='".$konu["konu_id"]."' ");
			$mesaj = mysql_fetch_array($mesajSQL);
			
			
			$mesaj["mesaj_govde"] = substr($mesaj["mesaj_govde"],0,50);
			
			
			 
		  
		?>
		
		<item>
			<title><?php echo $konu["konu_baslik"]; ?></title>
			<link>showthread.php?t=<?php echo $konu["konu_id"]; ?></link>
			<description><![CDATA[<?php echo $mesaj["mesaj_govde"]; ?>]]></description>
			<author><?php echo $mesaj["mesaj_author"]; ?></author>
			<category><![CDATA[Genel Sohbet]]></category>
			<comments>http://localhost/smf_2-0-2_install/index.php?action=post;topic=1.0</comments>
			<pubDate><![CDATA[<?php echo konu_tarihi($mesaj['mesaj_zamani'],$ayar["sistem_zaman_dilimi"]); ?>]]></pubDate>
			<guid>http://localhost/smf_2-0-2_install/index.php?topic=1.msg2#msg2</guid>
		</item>

		<?php 
		}
		?>
	</channel>
</rss>