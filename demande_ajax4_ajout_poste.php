<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');
require '/tools/fonctions_mySQL.php';

// On récupère l'id du poste
$id_poste=$_GET['id_poste'];

// On récupère l'id de la demande
$id_demande=$_GET['id_demande'];

$array_Values = array();
$array_Values['ID_Demande'] = $id_demande;
$array_Values['ID_Poste'] = $id_poste;

// Requête permettant d'ajouter un poste à une demande
INSERT ('demande_poste',$array_Values);

?>