<?php
	session_name("gi2");
	session_start();
	

	if (!isset($_SESSION["Utilisateur"])) {
	
		header("Location:login.php");
	}		
?>