<?php

class SPDO extends PDO {

public function __construct($dsn='mysql:host=localhost;dbname=gi2;charset=UTF-8',$username='root',$password=''){

try
{
	$connexion=parent::__construct($dsn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	return $connexion;
}
catch(PDOException $e)
{
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
}
}
}
?>