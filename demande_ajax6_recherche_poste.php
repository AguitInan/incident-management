<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

// Fonction d'appel Ajax pour la recherche de postes
	
try
{
	// Connexion à la base de données
	$connexion = Get_cnx();
	$poste = "";
	$req = 'SELECT * FROM Poste WHERE VDB LIKE "'.$_GET['recherche'].'%" ORDER BY VDB';
	$st = $connexion->query($req);
		
	$st->setFetchMode(PDO::FETCH_OBJ);
	while($obj = $st->fetch()){
	

		$poste.='
		<div class="vdbvisudrag" id="drag'.$obj->ID_Poste.'">
					
			<i class="icon-desktop bvs-icon" style="margin-right:10px;"></i> '.$obj->VDB.' - IP : '.$obj->IP_MAC.'

		</div>
		';
		
	}

	
}
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}
	
	
echo $poste;

?>