<?php
date_default_timezone_set('Europe/Paris');
$sth=Get_cnx();
$content="";

$i = 0;


// Requête permettant de récuperer les informations correspondant aux interventions pour créer le tableau sur la page accueil.php
$return= $sth->query("	SELECT D.ID_Etat AS Etat_Actuel, D.Date_Prevision_Inter, D.ID_Demande, H.Date_Etat, H.ID_Etat, Nom, Prenom, C.Libelle, AP.ID_Applicatif, C.ID_Categorie, E.Libelle AS Etat
						FROM Agent_Demande AD, Agent A, Categorie C, Historique_Etat H,Etat E , Demande D
						LEFT OUTER JOIN Applicatif AP ON D.ID_Applicatif = AP.ID_Applicatif
						WHERE AD.ID_Agent = A.ID_Agent
						AND AD.ID_Demande = D.ID_Demande
						AND D.ID_Categorie = C.ID_Categorie
						AND H.ID_Demande = D.ID_Demande                        
						AND D.ID_Etat =  E.ID_Etat                                         
						AND H.ID_Etat =1");
							
$return->setFetchMode(PDO::FETCH_OBJ);
while($obj = $return->fetch()){	
	
	
	// Etat_Actuel à 5 correspond à une intervention clôturée
	if($obj->Etat_Actuel !== "5")
	{
	
		$id_tab[$i] = $obj->ID_Demande;
		$prevision_tab[$i] = $obj->Date_Prevision_Inter;
		$i++;
		
		if($obj->Etat_Actuel == "1")// Etat_Actuel à 1 correspond à une intervention nouvelle
		{$content=$content.'<tr class="nvo" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}

		if($obj->Etat_Actuel == "2")// Etat_Actuel à 2 correspond à une intervention LU
		{$content=$content.'<tr class="lu" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}
		
		if($obj->Etat_Actuel == "3")// Etat_Actuel à 3 correspond à une intervention en cours (prise en compte par un technicien)
		{$content=$content.'<tr class="pris" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}
		
		if($obj->Etat_Actuel == "4")// Etat_Actuel à 4 correspond à une intervention Urgent
		{$content=$content.'<tr class="urg" data-categorie ="'.$obj->ID_Categorie.'" data-applicatif="'.$obj->ID_Applicatif.'">';}
		
		
		$content=$content.'
                    <td id="id'.$obj->ID_Demande.'">'.$obj->Date_Etat.'</td>
                    <td>'.$obj->Nom.' '.$obj->Prenom.'</td>
                    <td>Culture</td>
                    <td class="center">'.$obj->Libelle.'</td>';

       if($obj->Etat_Actuel == "1")
       {$content=$content.'<td class="center"><i class="icon-ok icon-white icon-bvs" ></i>'.$obj->Etat.'</td>
                </tr>'; }    
		if($obj->Etat_Actuel == "2")
       {$content=$content.'<td class="center"><i class="icon-eye-open icon-white icon-bvs"></i>'.$obj->Etat.'</td>
                </tr>'; }
        if($obj->Etat_Actuel == "3")
       {$content=$content.'<td class="center"><i class="icon-edit icon-white icon-bvs" ></i>'.$obj->Etat.'</td>
                </tr>'; }
         if($obj->Etat_Actuel == "4")
       {$content=$content.'<td class="center"><i class="icon-fire icon-white icon-bvs"></i>'.$obj->Etat.'</td>
                </tr>'; }
    }
	
}


function Retard($id_tab,$prevision_tab){

$i=0;

$sth=Get_cnx();

$return= $sth->query("SELECT * FROM Commentaire ORDER BY ID_Demande");
							
$return->setFetchMode(PDO::FETCH_OBJ);
while($obj = $return->fetch()){

$com_tab[$i] = $obj->ID_Demande;
$i++;

}

// Table demande avec commentaire
//echo 'Table demande avec commentaire : ';
//print_r ($com_tab);
//echo '<br/>';


// Table demande avec commentaire sans doublon
//echo '<br/>';
$com_tab2 = array_unique($com_tab);
//echo 'Table demande avec commentaire sans doublon : ';
//print_r ($retard_tab2);
//echo '<br/>';


// Table id
//echo '<br/>';
//echo 'Table id : ';
//print_r ($id_tab);
//echo '<br/>';


// Table date de prévision
//echo '</br>';
//echo 'Table date de prévision : ';
//print_r ($prevision_tab);
//echo '</br>';


// Taille table prévision et id
$taille = count($prevision_tab);
//echo '</br>';
//echo 'Taille table prévision et id : ';
//echo $taille;


$heure_actuelle = new DateTime(date("Y-m-d H:i:s"));
$heure_matin = new DateTime("2012-07-08 08:00:00");

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
		
		
		

		
		

		
		//echo '<br/>';
		if($prevision_datetime[$i] < $heure_actuelle){
			//echo "ko, date dépassée";
			$prevision_datetime[$i] = "1";
		
		}else{
		
			//echo "ok, date pas dépassée";
			$prevision_datetime[$i] = "0";
		}
		
		//echo '<br/>';
	}

}
//echo '<br/>';

//echo 'Tableau booléen avec date intervention dépassée : ';
//print_r ($prevision_datetime);
//echo '<br/>';

// Table des demandes en retard sans prise en compte des demandes ayant déjà un commentaire (correspondance avec la table des id)
for ($i = 0 ; $i < $taille ; $i++) {

	if($prevision_datetime[$i] == "1"){
		
		$retard_tab[] = $id_tab[$i];
	
	
	}


}
//echo '<br/>';
//echo 'Table des demandes en retard sans prise en compte des demandes ayant déjà un commentaire (correspondance avec la table des id) : ';
//print_r ($retard_tab);
//echo '<br/>';


$taille_tab = count($retard_tab);

// prise en compte des demandes ayant déjà un commentaire (demande 1 et 2)
for ($i = 0 ; $i < $taille_tab ; $i++) {
	
	if (in_array($retard_tab[$i], $com_tab2)) {
		$retard_tab[$i] = "";
	}
}
//echo '<br/>';
//echo 'Table des demandes en retard avec prise en compte des demandes ayant déjà un commentaire (demande 1 et 2) : ';
//print_r ($retard_tab);
//echo '<br/>';


// Traitement cases vides
for ($i = 0 ; $i < $taille_tab ; $i++) {

	if($retard_tab[$i] !== ""){

		$retard_tab2 [] = $retard_tab[$i];
	
	}
}


//echo '<br/>Demandes en retard (on retire les cases vides) : ';
return($retard_tab2);



};


?>