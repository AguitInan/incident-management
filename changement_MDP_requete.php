<?php

require('/inc/verif_login.php');
require '/tools/fonctions_mySQL.php';

include('demande_m.php');
	
// Le tableau $array_Set contient les valeurs pour la partie SET de la requête UPDATE
$array_Set = array();
$array_Set["Password"] = md5($_POST['nouveau']);


// Le tableau $array_Where contient les valeurs pour la partie WHERE de la requête UPDATE
$array_Where = array();
$array_Where["Technicien_ID_Agent"] = $_POST['ID_Technicien'];

// Requête permettant la modifiction du mot de passe en base de données
UPDATE ('technicien',$array_Set,$array_Where);


// Envoi Mail de confirmation de changement du mot de passe
envoyerMailMDP($_POST['Mail']);


// Retour à l'index
header('Location: index.php');
	
?>