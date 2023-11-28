<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');
require '/tools/fonctions_mySQL.php';

// Fichier appelé lors de la clôture d'une demande

date_default_timezone_set('Europe/Paris');


// Le tableau $array_Set contient les valeurs pour la partie SET de la requête UPDATE de la demande
$array_Set = array();
$array_Set["Technicien_ID_Agent"] = $_GET['ID_Technicien'];
$array_Set["ID_Etat"] = "6";
$array_Set['Date_Etat'] = date("Y-m-d H:i:s");


// Le tableau $array_Where contient les valeurs pour la partie WHERE de la requête UPDATE de la demande
$array_Where = array();
$array_Where["ID_Demande"] = $_GET['ID_Demande'];

UPDATE ('demande',$array_Set,$array_Where);


// Le tableau $array_Values contient les valeurs pour la partie VALUES de la requête INSERT dans la table historique_etat
$array_Values = array();
$array_Values['ID_Demande'] = $_GET['ID_Demande'];
$array_Values['ID_Etat'] = "6";
$array_Values['Date_Etat'] = date("Y-m-d H:i:s");
$array_Values['Technicien_ID_Agent'] = $_GET['ID_Technicien'];

// On ajoute une nouvelle entrée dans la table historique_etat. On met l'ID_Etat à 6 (correspond à l'état "Clôturée")
INSERT ('historique_etat',$array_Values);	

// Retour à la page d'accueil
header('Location: index.php');
	
?>