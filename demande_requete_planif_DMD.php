<?php

require('/inc/verif_login.php');
require '/tools/fonctions_mySQL.php';
require('demande_m.php');

// Fichier appelé lors de la planification d'une demande

date_default_timezone_set('Europe/Paris');
	
// $_POST['periode'] à 0 correspond au matin
if($_GET['periode'] == 0){

	$periode = "08:00:00";

// $_POST['periode'] à 1 correspond à l'après-midi
}else{

	$periode = "13:00:00";

}
		
// Le tableau $array_Set contient les valeurs pour la partie SET de la requête UPDATE de la demande
$array_Set = array();
$array_Set["Technicien_ID_Agent"] = $_GET['ID_Technicien'];
$array_Set["ID_Etat"] = "4";
$array_Set["Date_Prevision_Inter"] = $_GET['date'].' '.$periode;
$array_Set['Date_Etat'] = date("Y-m-d H:i:s");


// Le tableau $array_Where contient les valeurs pour la partie WHERE de la requête UPDATE de la demande
$array_Where = array();
$array_Where["ID_Demande"] = $_GET['ID_Demande'];

UPDATE ('demande',$array_Set,$array_Where);


// Le tableau $array_Values contient les valeurs pour la partie VALUES de la requête INSERT dans la table historique_etat
$array_Values = array();
$array_Values['ID_Demande'] = $_GET['ID_Demande'];
$array_Values['ID_Etat'] = "4";
$array_Values['Date_Etat'] = date("Y-m-d H:i:s");
$array_Values['Technicien_ID_Agent'] = $_GET['ID_Technicien'];

// On ajoute une nouvelle entrée dans la table historique_etat. On met l'ID_Etat à 4 (correspond à l'état "Planifiée")
INSERT ('historique_etat',$array_Values);

$dmd_obj = Dmd_by_Id_return_obj($_GET['ID_Demande']);

// On envoie un mail à l'agent pour lui confirmer la planification d'intervention
envoyerMail($dmd_obj);


// Retour à la page de la demande
header('Location: demande.php?id_demande='.$_GET['ID_Demande'].'');
	
?>