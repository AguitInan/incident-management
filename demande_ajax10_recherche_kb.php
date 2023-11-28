<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

// Fonction d'appel Ajax pour la recherche de fiches KB
	
try
{
	// Connexion à la base de données
	$dbh = Get_cnx();
	$return = "";
	$sql = 'SELECT * FROM `kb` WHERE Mots_Cles LIKE "%'.$_GET['recherche-kb'].'%" ';

	$kb_data = $dbh->query($sql);

	foreach ($kb_data as $kb) {
	
		$return.= '	<div class="span2">

						<a id="kb'.$kb["ID_KB"].'"> Fiche KB n° '.$kb["ID_KB"].' - '.$kb["Mots_Cles"].'</a>

					</div>';
					
	}
	
	
}
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}

echo($return);

?>