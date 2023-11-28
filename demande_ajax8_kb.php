<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

$dbh=Get_cnx();
$return="";

if ($_GET['id_applicatif'] !== ""){

	// Requête permettant de récuperer les informations correspondant aux fiches KB
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

}

echo($return);
?>