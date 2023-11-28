<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

$dbh=Get_cnx();

// Fonction d'appel Ajax permettant la précision du Service (déclenchée par l'évènement .mouseover)

$return="";

$entorg = substr($_GET['id_applicatif'], 0, 4);

// Requête permettant de récuperer les informations correspondant au Service supérieur (avec ENTORG à 4 chiffres)
$sql = "SELECT * FROM `service` WHERE ENTORG =".$entorg."";

$st = $dbh->query($sql);
$donnees = $st->fetch( PDO::FETCH_OBJ);
			
	$return= $donnees->Libelle;

echo($return);
?>