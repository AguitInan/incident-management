<?php

// définissez votre classe
require('pdo/SPDO.class.php');
require('bo/Categorie.php');
require('dal/Categorie_manager.php');
require('bo/Applicatif.php');
require('dal/Applicatif_manager.php');
require("dal/Demande_manager.php");
require("bo/Demande.php");

date_default_timezone_set('Europe/Paris');

// recuperation des données du formulaire par $_POST

$description=$_POST['description'];

if(isset($_POST['Urgente'])){

	$etat="5";
	
}else{

	$etat="1";
}

$matricule = $_POST['Matricule'];
$date=date("Y-m-d H:i:s");
$categorie=$_POST['sCategorie'];

if($_POST['sCategorie'] != "2"){
	
	$applicatif = null;

}else{

	$applicatif=$_POST['sApplicatif'];
	
}
$service=$_POST['Service'];

// insertion dans la table

$db=new SPDO();

try {

	$db->beginTransaction();

	$donnees=array("ID_Demande"=>null,"Details"=>$description,"ID_Etat" => $etat,"Matricule_Agent" => $matricule, "Date_Etat" => $date,
	 "Date_Prevision_Inter" => null, "ID_Categorie" => $categorie, "ID_Applicatif" => $applicatif, "ID_Service" => $service, "Technicien_ID_Agent"=>null);
	$insc=new Demande($donnees);
	
	// Création de la demande
	DAL_Demande::inserer_demande($db, $insc);

	$lastId = $db->lastInsertId();

	DAL_Demande::valid_insc($db, $lastId);

	
	// Association du poste à la demande
	if(isset($_POST['Poste'])){

		DAL_Demande::demande_poste($db, $lastId, $_POST['Poste']);

	}

	$db->commit();

	echo("<br/>Demande Effectuée<br/>");

	if(!isset($_POST['Poste'])){
	
		echo("<br /><a href=\"demande.php?id_demande=".$lastId."\">Voir la demande</a><br/>");
		echo("<br /><a href=\"index.php\">Retour à l'accueil</a><br/>");

	}

}catch (Exception $e) {

	$err_msg = str_replace("{{ERR_MSG}}", $e->getMessage(), $err_msg);
	$result = array(
		"etat"  => "KO",
		"titre" => "Erreur",
		"texte" => $err_msg,
		"class" => "bg-color-red",
		"icon"  =>"icon-cancel",
		"style" =>"color:#70122C;font-size:36px"
	);
	$db->rollBack();
}
?>