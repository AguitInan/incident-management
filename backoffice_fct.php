<?php
date_default_timezone_set('Europe/Paris');
$sth=Get_cnx();
$content="";

$i = 0;

// Requête permettant de récuperer les informations correspondant aux interventions pour créer le tableau sur la page accueil.php
$return= $sth->query("	
						SELECT D.ID_Etat AS Etat_Actuel, D.Date_Prevision_Inter, D.ID_Demande, S.Libelle AS Libelle_Service, H.Date_Etat, H.ID_Etat, Nom, Prenom, C.Libelle AS Libelle_Categorie, AP.ID_Applicatif, C.ID_Categorie, E.Libelle AS Etat
						FROM Agent A, Service S, Categorie C, Historique_Etat H, Etat E, Demande D
						LEFT OUTER JOIN Applicatif AP ON D.ID_Applicatif = AP.ID_Applicatif
						WHERE D.Matricule_Agent = A.Matricule
						AND D.ID_Categorie = C.ID_Categorie
						AND A.ID_Service = S.ID_Service
						AND H.ID_Demande = D.ID_Demande
						AND D.ID_Etat = E.ID_Etat
						AND (
							D.ID_Etat =1
							OR D.ID_Etat =2
							OR D.ID_Etat =3
							OR D.ID_Etat =4
							OR D.ID_Etat =5
						)
						AND H.ID_Etat =1
						
					");
							
$return->setFetchMode(PDO::FETCH_OBJ);
while($obj = $return->fetch()){
	
	$id_tab[$i] = $obj->ID_Demande;
	$prevision_tab[$i] = $obj->Date_Prevision_Inter;
	$i++;

	if($obj->Etat_Actuel == "1")// Etat_Actuel à 1 correspond à une intervention Nouvelle
	{$content=$content.'<tr class="nvo" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}

	if($obj->Etat_Actuel == "2")// Etat_Actuel à 2 correspond à une intervention Lue
	{$content=$content.'<tr class="lu" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}

	if($obj->Etat_Actuel == "3")// Etat_Actuel à 3 correspond à une intervention En cours (prise en compte par un technicien)
	{$content=$content.'<tr class="pris" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}

	if($obj->Etat_Actuel == "4")// Etat_Actuel à 4 correspond à une intervention Planifiée (prise en compte par un technicien)
	{$content=$content.'<tr class="planif" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}

	if($obj->Etat_Actuel == "5")// Etat_Actuel à 5 correspond à une intervention Urgente
	{$content=$content.'<tr class="urg" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}

	$content=$content.'
				<td id="id'.$obj->ID_Demande.'">'.date2fr(substr($obj->Date_Etat, 0, -9)).' '.substr($obj->Date_Etat, -8, -3).'</td>
				<td>'.$obj->Nom.' '.$obj->Prenom.'</td>
				<td>'.$obj->Libelle_Service.'</td>
				<td class="center">'.$obj->Libelle_Categorie.'</td>';

	if($obj->Etat_Actuel == "1")
	{$content=$content.'<td class="center" data-rk="4Nouvelle"><i class="icon-ok icon-white icon-bvs" ></i>'.$obj->Etat.'</td>
			</tr>'; }    
	if($obj->Etat_Actuel == "2")
	{$content=$content.'<td class="center" data-rk="3Lue"><i class="icon-eye-open icon-white icon-bvs"></i>'.$obj->Etat.'</td>
			</tr>'; }
	if($obj->Etat_Actuel == "3")
	{$content=$content.'<td class="center" data-rk="2En cours"><i class="icon-edit icon-white icon-bvs" ></i>'.$obj->Etat.'</td>
			</tr>'; }
	if($obj->Etat_Actuel == "4")
	{$content=$content.'<td class="center" data-rk="1Planifiée"><i class="icon-edit icon-white icon-bvs" ></i>'.$obj->Etat.'</td>
			</tr>'; }
	if($obj->Etat_Actuel == "5")
	{$content=$content.'<td class="center" data-rk="6Urgente"><i class="icon-fire icon-white icon-bvs"></i>'.$obj->Etat.'</td>
			</tr>'; }

}


// Fonction qui permet de récupérer les informations correspondant aux demandes clôturées (sur la page historique.php)
function Historique(){

	$sth=Get_cnx();

	$historique ="";

	$return= $sth->query("	SELECT D.ID_Etat AS Etat_Actuel, D.Date_Prevision_Inter, D.ID_Demande, S.Libelle AS Libelle_Service, H.Date_Etat, H.ID_Etat, Nom, Prenom, C.Libelle AS Libelle_Categorie, AP.ID_Applicatif, C.ID_Categorie, E.Libelle AS Etat
	FROM Agent A, Service S, Categorie C, Historique_Etat H, Etat E, Demande D
	LEFT OUTER JOIN Applicatif AP ON D.ID_Applicatif = AP.ID_Applicatif
	WHERE D.Matricule_Agent = A.Matricule
	AND D.ID_Categorie = C.ID_Categorie
	AND A.ID_Service = S.ID_Service
	AND H.ID_Demande = D.ID_Demande
	AND D.ID_Etat = E.ID_Etat
	AND D.ID_Etat =6

	AND H.ID_Etat =1");
								
	$return->setFetchMode(PDO::FETCH_OBJ);
	while($obj = $return->fetch()){

			
	$historique=$historique.'<tr class="cloture" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">
	
								<td id="id'.$obj->ID_Demande.'">'.date2fr(substr($obj->Date_Etat, 0, -9)).' '.substr($obj->Date_Etat, -8, -3).'</td>
								<td>'.$obj->Nom.' '.$obj->Prenom.'</td>
								<td>'.$obj->Libelle_Service.'</td>
								<td class="center">'.$obj->Libelle_Categorie.'</td>
								<td class="center"><i class="icon-ok icon-white icon-bvs" ></i>'.$obj->Etat.'</td>
								
							</tr>';

	}
		
	return $historique;

}

// Fonction qui permet de mettre en évidence les demandes en Retard
function Retard($id_tab,$prevision_tab){

	$i=0;

	$sth=Get_cnx();

	$return= $sth->query("SELECT * FROM Commentaire ORDER BY ID_Demande");
								
	$return->setFetchMode(PDO::FETCH_OBJ);
	while($obj = $return->fetch()){

		$com_tab1[$i] = $obj->ID_Demande;  // Table demande avec commentaire
		$i++;

	}

	if(!isset($com_tab1)){

		$com_tab = array();
		$com_tab2 = array_unique($com_tab);
		
	}else{

		// Table demande avec commentaire sans doublon
		$com_tab2 = array_unique($com_tab1);

	}

	// Taille table prévision
	$taille = count($prevision_tab);

	$heure_actuelle = new DateTime(date("Y-m-d H:i:s"));

	$heure_matin = new DateTime("08:00:00");

	// Tableau booléen avec date intervention dépassée
	for ($i = 0 ; $i < $taille ; $i++) {

		if($prevision_tab[$i] == ""){
		
			$prevision_datetime[$i] = "";
			
		}else{

			$prevision_datetime[$i] = new DateTime($prevision_tab[$i]);
				
			$diff=$prevision_datetime[$i]->diff($heure_matin);
			
			if($diff->h == "0"){
			
				$prevision_datetime[$i]->add(new DateInterval('PT5H'));
			
			}else{
			
				$prevision_datetime[$i]->add(new DateInterval('PT19H'));
				
			}
			

			if($prevision_datetime[$i] < $heure_actuelle){

				$prevision_datetime[$i] = "1";
			
			}else{
			
				$prevision_datetime[$i] = "0";
			}
			
		}

	}

	// $prevision_datetime : Tableau booléen avec date intervention dépassée

	// Table des demandes en retard sans prise en compte des demandes ayant déjà un commentaire (correspondance avec la table des id)
	for ($i = 0 ; $i < $taille ; $i++) {

		if($prevision_datetime[$i] == "1"){
			
			$retard_tab[] = $id_tab[$i];
		
		}

	}
	
	if(isset($retard_tab)){
	
		// Taille table retard
		$taille_tab = count($retard_tab);

		// prise en compte des demandes ayant déjà un commentaire (demande 1 et 2)
		for ($i = 0 ; $i < $taille_tab ; $i++) {
			
			if (in_array($retard_tab[$i], $com_tab2)) {
				$retard_tab[$i] = "";
			}
		}

		$retard_tab2 = array();

		// Traitement cases vides
		for ($i = 0 ; $i < $taille_tab ; $i++) {

			if($retard_tab[$i] !== ""){

				$retard_tab2 [] = $retard_tab[$i];
			
			}
		}

		return($retard_tab2);
	}


};


// Fonction qui permet de récupérer les informations correspondant aux fiches KB pour créer le tableau sur la page tableau_kb.php
function Tableau_KB(){

	$sth=Get_cnx();

	$tableau_kb ="";

	$return= $sth->query("
							SELECT * FROM KB K, Agent A, Applicatif AP 
							WHERE K.Technicien_ID_Agent = A.ID_Agent
							AND K.ID_Applicatif = AP.ID_Applicatif
						");
								
	$return->setFetchMode(PDO::FETCH_OBJ);
	while($obj = $return->fetch()){

		$tableau_kb=$tableau_kb.'<tr class="kb">
		
									<td id="id'.$obj->ID_KB.'">'.$obj->ID_KB.'</td>
									<td>'.$obj->Libelle.'</td>
									<td>'.$obj->Mots_Cles.'</td>
									<td>'.$obj->Nom.' '.$obj->Prenom.'</td>
									<td>'.$obj->ID_Demande.'</td>
									
								</tr>';
		
	}
		
	return $tableau_kb;

}

?>