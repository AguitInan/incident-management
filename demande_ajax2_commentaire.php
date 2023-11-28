<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');
require('/inc/functions.php');

$dbh=Get_cnx();
$return="";
// Requête permettant de récuperer les informations correspondant aux commentaires concernant une intervention à l'aide de la fonction JS Mustache ( sur la page demande.php)
$sql = "
			SELECT *
			FROM Agent A, Demande D, Technicien T, Commentaire CO
			WHERE CO.ID_Demande = D.ID_Demande
			AND T.Technicien_ID_Agent = CO.Technicien_ID_Agent
			AND CO.Technicien_ID_Agent = A.ID_Agent
			AND D.ID_Demande =".$_GET['identifiant']."
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