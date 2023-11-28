<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');

$conn=Get_cnx();
$ac_term = "%".$_GET['term']."%";

$return_arr = array();
 
if ($conn)
{
    $ac_term = "%".$_GET['term']."%";
	
	// Requête permettant de récuperer les noms et prénoms des agents pour l'auto-complétion
    $query = "SELECT ID_Agent,Nom, Prenom, Matricule FROM `agent` where Actif =1 AND Nom like :term";
    $result = $conn->prepare($query);
    $result->bindValue(":term",$ac_term);
    $result->execute();

   
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
		$row_array['value'] = $row['Nom'].' '.$row['Prenom'];  
        $row_array['id'] = $row['Matricule'];     
        array_push($return_arr,$row_array);
		
				
    }
 
}

echo json_encode($return_arr);


?>