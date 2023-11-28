<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');
require('/inc/functions.php');

date_default_timezone_set('Europe/Paris');

$dbh=Get_cnx();

// Requête qui passe la demande à l'état "En cours" dès l'ajout d'un commentaire
if($_GET['etat'] == 2){
	
	$query = "UPDATE  `demande` SET  `ID_Etat` = '3' WHERE  `ID_Demande` =".$_GET['id_dmd']."";
	$result = $dbh->exec($query);
		
}

// Requête permettant d'ajouter le commentaire en base de données
$query = 'INSERT INTO `commentaire` VALUES (NULL,"'.htmlspecialchars($_GET['commentaire']).'","'.$_GET['id_dmd'].'","'.$_GET['id_technicien'].'","'.date("Y-m-d H:i:s").'" )';

$result = $dbh->exec($query);

$return="";

// Requête permettant de récuperer les informations correspondant aux commentaires (actualisation)
$sql = "
			SELECT *
			FROM Agent A, Demande D, Technicien T, Commentaire CO
			WHERE CO.ID_Demande = D.ID_Demande
			AND T.Technicien_ID_Agent = CO.Technicien_ID_Agent
			AND CO.Technicien_ID_Agent = A.ID_Agent
			AND D.ID_Demande =".$_GET['id_dmd']."
			ORDER BY Date ASC
		";
							
$comm = $dbh->query($sql);

foreach ($comm as $com) {

	$return.= '
		<div class="commentaires">
			<div class="span8" style="font-weight:bold;margin-top:10px;margin-left:10px;">
			De : '.$com["Nom"].' '.$com["Prenom"].'  - le '.date2fr(substr($com["Date"], 0, -9)).' à '.substr($com["Date"], -8, -3).'
			</div>
			<div class="span8" style=";">
				Commentaire : '.$com["Commentaire"].'
			</div>
		</div>
	';
	
}
echo($return);

?>