<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

// Fonction d'appel Ajax pour la recherche d'agents
	
try
{
	// Connexion à la base de données
	$connexion = Get_cnx();
	$agent = "";
	
	// Requête permettant de récupérer les informations correspondant aux agents recherchés
	$req = 'SELECT * FROM Agent WHERE Actif=1 AND Nom LIKE "'.$_GET['recherche'].'%" ORDER BY Nom';
	
	$st = $connexion->query($req);
	
	$st->setFetchMode(PDO::FETCH_OBJ);
	while($obj = $st->fetch()){
			
		$agent.='
			<div class="vdbvisudrag" id="drag'.$obj->ID_Agent.'" data-matricule="'.$obj->Matricule.'" data-service="'.$obj->ID_Service.'">
					
				<i class="icon-user bvs-icon" style="margin-right:10px;"></i> '.$obj->Nom.' '.$obj->Prenom.'

			</div>
		';

	}

}
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}
	
	
echo $agent;

?>