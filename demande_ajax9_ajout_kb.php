<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

date_default_timezone_set('Europe/Paris');

$dbh=Get_cnx();

// Requête permettant d'ajouter la fiche KB en base de données
$query = 'INSERT INTO `kb` VALUES (NULL,"'.htmlspecialchars($_GET['infos']).'","'.htmlspecialchars($_GET['mots_cles']).'","'.$_GET['id_dmd'].'","'.$_GET['id_applicatif'].'","'.$_GET['id_technicien'].'" )' ;
$result = $dbh->exec($query);

$return="";

// Requête permettant de récuperer les informations correspondant aux fiches KB (actualisation)
$sql = "SELECT * FROM kb KB, Applicatif A 
	WHERE  KB.ID_Applicatif = A.ID_Applicatif
	AND KB.ID_Applicatif =".$_GET['id_applicatif']."
	ORDER BY ID_KB DESC LIMIT 15";
							
$kb_data = $dbh->query($sql);


foreach ($kb_data as $kb) {

		$return.= '	<div class="span2">

						<a id="kb'.$kb["ID_KB"].'"> Fiche KB n° '.$kb["ID_KB"].' - '.$kb["Libelle"].' ('.$kb["Mots_Cles"].')</a>
				
					</div>';
		
}

echo($return);

?>