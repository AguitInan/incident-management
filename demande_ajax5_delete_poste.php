<?php

require('/inc/verif_login.php');
require('tools/cnx_param.php');
require ('/tools/fonctions_mySQL.php');

// On récupère l'id du poste
$id_poste=$_GET['id_poste'];

// On récupère l'id de la demande
$id_demande=$_GET['id_demande'];

$array_Where = array();
$array_Where['ID_Demande'] = $id_demande;
$array_Where['ID_Poste'] = $id_poste;

// Requête permettant de dissocier le poste de la demande
DELETE ('demande_poste',$array_Where)
	
?>