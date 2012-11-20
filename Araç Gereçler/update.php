<?php

require_once("sistem/ayar.php");



$SQL = mysql_query("UPDATE konular  set 
		   konu_author_id = '30'
		   
		   WHERE konu_author = 'tarantula' ");
		

		if($SQL == false) 
		echo "olmadý";
		else
		echo "oldu";
?>