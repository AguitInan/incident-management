<?php
		
// On désérialise les données de l'objet type ConnectedUser stocké en session s'il existe (dans le cas d'une authentification automatique)
if(isset($_SESSION['ConnectedUser'])){

	 $result=unserialize($_SESSION['ConnectedUser']);
	
}

$result2=unserialize($_SESSION['Utilisateur']);
				
	
// Récupération Catégories préférées
try
{
	$categorie = array();
	$return = $sth->query("SELECT * FROM Technicien_Categorie WHERE Technicien_ID_Agent = ".$result2->Technicien_ID_Agent."");

	while($obj = $return->fetch(PDO::FETCH_OBJ))
	{
		$categorie[] = $obj->ID_Categorie;
		
	}
	
	
}
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}


// Récupération Applicatifs préférés
try
{
	$applicatif = array();
	$return = $sth->query("SELECT * FROM Technicien_Applicatif WHERE Technicien_ID_Agent = ".$result2->Technicien_ID_Agent."");
	
	while($obj = $return->fetch(PDO::FETCH_OBJ))
	{
		$applicatif[] = $obj->ID_Applicatif;
	}
	
	
}
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}

?>