<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

$dbh=Get_cnx();
$return="";

if ($_GET['id'] !== ""){

	// Requête permettant de récuperer les informations correspondant aux fiches KB correspondant à la demande

	$sql = "SELECT * FROM `kb` WHERE ID_KB =".$_GET['id']."";						
	$kb_data = $dbh->query($sql);

	foreach ($kb_data as $kb) {
	
		$return.= ' 
			<div>

				<em>Fiche KB '.$kb["ID_KB"].' ('.$kb["Mots_Cles"].')<br/>
				
				</em>

					<div>
					
						'.$kb["Infos"].'
					
					</div>
					
			</div>
		';
		
	}

}

echo($return);
?>