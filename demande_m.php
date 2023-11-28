<?php 

require('tools/cnx_param.php');

date_default_timezone_set('Europe/Paris');

// Fonction qui récupère les informations correspondant à la demande (prend en paramètre l'id de la demande)
function Dmd_by_Id($id){

$sth=Get_cnx();
$poste="";
$content="";
$return= $sth->query("	SELECT * , D.ID_Etat AS Etat_Actuel,D.ID_Demande AS ID_DMD, S.Libelle AS Libelle_Service, A.ID_Agent AS ID_Demandeur, A.Mail AS Mail_Demandeur, A.Matricule AS Matricule_Demandeur, A.Telephone AS Telephone_Demandeur, HE.Date_Etat AS Date_Creation, D.Technicien_ID_Agent AS Technicien_Demande, B.Nom AS Nom_Technicien, B.Prenom AS Prenom_Technicien, A.Nom AS Nom_Demandeur, A.Prenom AS Prenom_Demandeur
						FROM Agent A, Historique_Etat HE, Categorie C, Service S, Demande D
						LEFT OUTER JOIN Agent B ON B.ID_Agent = D.Technicien_ID_Agent
						LEFT OUTER JOIN Demande_Poste DP ON DP.ID_Demande = D.ID_Demande
						LEFT OUTER JOIN Poste P ON P.ID_Poste = DP.ID_Poste
						WHERE A.Matricule = D.Matricule_Agent
						AND D.ID_Categorie = C.ID_Categorie
						AND A.ID_Service = S.ID_Service
						AND HE.ID_Demande = D.ID_Demande
						AND HE.ID_Etat =1
						AND D.ID_Demande = ".$id."
								
					");
												
								
$return->setFetchMode(PDO::FETCH_OBJ);
$obj = $return->fetch();

$content.='

			<td  data-uid="'.$obj->ID_DMD.'" data-valeur="'.$obj->ID_Demandeur.'">'.$obj->ID_Demandeur.'</td>
			<td id="editnom" data-uid="'.$obj->ID_DMD.'" data-valeur="'.$obj->Nom_Demandeur.' '.$obj->Prenom_Demandeur.'" data-element="input" data-edit="0">'.$obj->Nom_Demandeur.' '.$obj->Prenom_Demandeur.'
			</td>
			<td id="service" data-entorg="'.$obj->ENTORG.'" data-lgorga="'.$obj->LGORGA.'"  data-element="input">'.$obj->Libelle_Service.'
			</td>
			<td id="mail" data-uid="'.$obj->ID_DMD.'" data-valeur="'.$obj->Mail_Demandeur.'"  data-element="input">'.$obj->Mail_Demandeur.'
			</td>
			<td id="telephone" data-uid="'.$obj->ID_DMD.'" data-valeur="'.$obj->Telephone_Demandeur.'"  data-element="input">'.$obj->Telephone_Demandeur.'
			</td>

		';
return $content;

}


// Fonction qui stocke sous forme d'objet les informations correspondant à la demande(prend en paramètre l'id de la demande)
function Dmd_by_Id_return_obj($id){

$sth=Get_cnx();
$poste="";
$content="";
$return= $sth->query("	SELECT * , D.ID_Etat AS Etat_Actuel, E.Libelle AS Libelle_Etat, HE.Date_Etat AS Date_Creation, D.ID_Demande AS Demande_ID_Demande, D.Technicien_ID_Agent AS Technicien_Demande, S.Libelle AS Libelle_Service, B.Nom AS Nom_Technicien, B.Prenom AS Prenom_Technicien, A.Nom AS Nom_Demandeur, A.Prenom AS Prenom_Demandeur
						FROM Agent A, Etat E, Historique_Etat HE, Categorie C, Service S, Demande D
						LEFT OUTER JOIN Agent B ON B.ID_Agent = D.Technicien_ID_Agent
						LEFT OUTER JOIN Demande_Poste DP ON DP.ID_Demande = D.ID_Demande
						LEFT OUTER JOIN Poste P ON P.ID_Poste = DP.ID_Poste
						WHERE A.Matricule = D.Matricule_Agent
						AND D.ID_Categorie = C.ID_Categorie
						AND A.ID_Service = S.ID_Service
						AND HE.ID_Demande = D.ID_Demande
						AND D.ID_Etat = E.ID_Etat
						AND HE.ID_Etat =1
						AND D.ID_Demande = ".$id."			
					");
									
$return->setFetchMode(PDO::FETCH_OBJ);
$obj = $return->fetch();
return $obj;

}

// Fonction qui retourne la liste des Postes associée à une demande (prend en paramètre l'id de la demande)
function Poste_by_Id($id){

$sth=Get_cnx();
$poste="";
$content="";
$return= $sth->query("	SELECT * from poste P, demande_poste DP, Demande D Where DP.ID_Demande = D.ID_Demande AND P.ID_Poste = DP.ID_Poste AND D.ID_Demande = ".$id."");
$return->setFetchMode(PDO::FETCH_OBJ);
while($obj = $return->fetch()){
		
	$poste.='
				<div class="vdbvisudrop" id="pc_assos_'.$obj->ID_Poste.'">
				
					<i class="icon-desktop bvs-icon" style="margin-right:10px;"></i> '.$obj->VDB.' - IP : '.$obj->IP_MAC.'

				</div>
			';
				
}
return $poste;

}


// Fonction passe la demande à l'état "Lue" lorsqu'elle est consultée la première fois (prend en paramètre l'id de la demande et l'id du technicien)
function Dmd_Lue($id,$id_technicien){

	$sth=Get_cnx();

	$return= $sth->query("	SELECT * FROM Demande WHERE ID_Demande = ".$id."");
																
	$return->setFetchMode(PDO::FETCH_OBJ);
	$obj = $return->fetch();

	if($obj->ID_Etat == "1"){

		$req = 'UPDATE `Demande` SET ID_Etat = "2", Date_Etat = "'.date("Y-m-d H:i:s").'" WHERE ID_Demande = '.$id;
		$st = $sth->exec($req);
		
		$req = "INSERT INTO `Historique_Etat` VALUES (".$id.",2,'".date("Y-m-d H:i:s")."',".$id_technicien." )" ;
		$st = $sth->exec($req);

	}
	
}


// Fonction qui signale à l'agent la planification d'intervention correspondant à sa demande
function envoyerMail($model){
	
		$subject = "Planification de votre demande";
		 $to  = $model->Mail;
		 // message

		 $message = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Planification d\'intervention</title>
		<style type="text/css">
		body p {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 14px;
		}
		.taille16 {
			font-size: 16px;
		}
		</style>
		</head>
		<body>

		<p>Ceci est un message envoyé par le gestionnaire des interventions de la DSIT de Beauvais.</p>
		
		<p>'.$model->Nom.' '.$model->Prenom.' interviendra le '.$model->Date_Prevision_Inter.'</p>
		
		<p>Voici les informations concernant votre demande :</p>
		<table bordercolor="#6399cd" border="1" >
		  <tr>
			<td><p>Nom Technicien : '.$model->Nom.'</p>
			  <p>Prénom Technicien : '.$model->Prenom.'</p>
			  <p>Date de l\'intervention : '.$model->Date_Prevision_Inter.'</p></td>
		  </tr>
		</table>

		<p>Cordialement</p>
		</body>
		</html>
		';
	
		 // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		 $headers  = "From: {".$model->Mail."}\r\nReply-To: {".$model->Mail."}";
		 $headers .= 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		 $headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
	
		// Envoi
		mail($to, $subject, $message, $headers);
		
}


// Fonction qui envoie une confirmation de changement du mot de passe
function envoyerMailMDP($mail){
	
		$subject = "Changement de votre mot de passe";
		 $to  = $mail;
		 // message

		 $message = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Planification d\'intervention</title>
		<style type="text/css">
		body p {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 14px;
		}
		.taille16 {
			font-size: 16px;
		}
		</style>
		</head>
		<body>

		<p>Ceci est un message envoyé par le gestionnaire des interventions de la DSIT de Beauvais.</p>
		
		<p>Votre mot de passe a bien été modifié</p>

		</body>
		</html>
		';
	
		 // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		 $headers  = "From: {".$mail."}\r\nReply-To: {".$mail."}";
		 $headers .= 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		 $headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

	
		// Envoi
		mail($to, $subject, $message, $headers);
		
}

?>