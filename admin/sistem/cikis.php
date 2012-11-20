<?php
session_start();
require_once("../../sistem/ayar.php");
   

    unset($_SESSION['kul_admin']);  
    unset($_SESSION['kul_admin_id']);
    unset($_SESSION['kul_admin_yetki']);
	unset($_SESSION['kul_admin_email']); 
	unset($_SESSION['kul_admin_son_giris']); 
	unset($_SESSION['kul_admin_son_aktivite']); 
	unset($_SESSION['kul_admin_yetki']); 
	unset($_SESSION['kul_admin_grup_name']); 
	unset($_SESSION['kul_admin_grup_color']); 

	
	//session_destroy(); // Tüm oturumlarý yoket	
	
	header("location:../login.php");


?>