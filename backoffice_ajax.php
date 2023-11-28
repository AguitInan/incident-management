<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

// Fichier correspondant au slide menu de la planification sur la page demande.php


// On récupère la valeur de la date selectionnée dans le DatePicker
$date=$_POST['date'];

// On désérialise $_SESSION['Utilisateur'] contenant les données relatives à l'utilisateur
$result2=unserialize($_SESSION['Utilisateur']);

if(isset($_POST['periode'])){

	if($_POST['periode'] == 0){

		// $_POST['periode'] à 0 correspond au matin
		$periode = "08:00:00";


	}else{
		
		// $_POST['periode'] à 1 correspond à l'après-midi
		$periode = "13:00:00";

	}

	// On concatène $date et $variable dans $var sous forme de Datetime
	$var =  $date.' '.$periode;

	$sth=Get_cnx();

	// Requête permettant de récuperer les informations correspondant aux interventions déjà prévues à la même date et période
	$return= $sth->query('	
							SELECT * FROM demande D, categorie C, Agent A WHERE D.Matricule_Agent = A.Matricule
							AND D.ID_Categorie = C.ID_Categorie AND Technicien_ID_Agent ="'.$result2->Technicien_ID_Agent.'" 
							AND Date_Prevision_Inter = "'.$var.'" 
							AND (D.ID_Etat =3 OR D.ID_Etat =4)
						');

	$return->setFetchMode(PDO::FETCH_OBJ);
	
	$res = $return->fetchAll();
	if (count($res) == 0) {
	
		// pas de résultat (pas d'intervention prévue)
		$commentaire = '<em>Pas d\'intervention prévue<em/>';
		
	}elseif (count($res) == 1) {
		
		// 1 intervention prévue
		$commentaire ='<em>1 intervention prévue ';

		foreach ($res as $ligne) {

			$commentaire .='
				('.$ligne->Nom.' '.$ligne->Prenom.')
			';
		}

		$commentaire .= '<em/>';

	}else{

		// plusieurs interventions prévues
		$commentaire ='<em>'.count($res).' interventions prévues<em/>';

	}

	echo $commentaire;				
             
}

?>