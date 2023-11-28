<?php

require('/inc/verif_login.php');
require('demande_m.php');

$conn=Get_cnx();
$matricule = $_GET['id_nv_agent'];
$id_demande=$_GET['id_dmd'];

$return_arr = array();

// Requête permettant de modifier l'agent lié à la demande
$query = "UPDATE  `demande` SET  `Matricule_Agent` = '".$matricule."' WHERE  `ID_Demande` =".$id_demande."";
$result = $conn->exec($query);

$obj=Dmd_by_Id($id_demande);
echo($obj);

?>