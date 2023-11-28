<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

$result=unserialize($_SESSION['Utilisateur']);

$dbh=Get_cnx();

// Requête permettant de récupérer le mot de passe du technicien pour effectuer la vérification dynamique
$sql = 'SELECT Password FROM Technicien WHERE Technicien_ID_Agent = "'.$result->Technicien_ID_Agent.'"';
						
$return = $dbh->query($sql);	
$return->setFetchMode(PDO::FETCH_OBJ);
$obj = $return->fetch();

$mdp = $obj->Password;

$mot_de_pass=md5($_GET['mot_de_passe']);
 
// Paramétrage du retour Vrai/Faux 
if ($mot_de_pass !== "" )
{
	if ($mot_de_pass == $mdp )
	{
		echo 'true';
	}
	else
	{
		echo 'false';
	}

}else{

	echo "void";
}

?>