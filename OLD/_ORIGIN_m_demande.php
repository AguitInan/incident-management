<?php 

include('tools/cnx_param.php');

function Dmd_by_Id($id){
$sth=Get_cnx();
$poste="";
$content="";
$return= $sth->query("	SELECT * , D.ID_Etat AS Etat_Actuel, HE.Date_Etat AS Date_Creation, D.Technicien_ID_Agent AS Technicien_Demande, B.Nom AS Nom_Technicien, B.Prenom AS Prenom_Technicien, A.Nom AS Nom_Demandeur, A.Prenom AS Prenom_Demandeur
								FROM Agent A, Agent_Demande AD, Historique_Etat HE, Categorie C, Demande D
								LEFT OUTER JOIN Agent B ON B.ID_Agent = D.Technicien_ID_Agent
								LEFT OUTER JOIN Demande_Poste DP ON DP.ID_Demande = D.ID_Demande
								LEFT OUTER JOIN Poste P ON P.ID_Poste = DP.ID_Poste
								WHERE AD.ID_Demande = D.ID_Demande
								AND D.ID_Categorie = C.ID_Categorie
								AND A.ID_Agent = AD.ID_Agent
								AND HE.ID_Demande = D.ID_Demande
								AND HE.ID_Etat =1
								AND D.ID_Demande = ".$id."");
$return->setFetchMode(PDO::FETCH_OBJ);

		

while($obj = $return->fetch())
			{
				
				// On stocke dans $content un tableau contenant les informations relatives à la demande
				$content=    ' 	<tr data-uid="123">
				<td>
					<i class="icon-edit" id="edit'.$obj->ID_Demande.'"></i>
				</td>
				<td id="'.$obj->ID_Demande.'">
					<input readonly class="bvs-input-lockforever" type="text" value="'.$obj->Date_Creation.'">
				</td>
				<td>
					<input data-type="text" data-domaine="demandeur" readonly name="'.$obj->ID_Demande.'" class="bvs-input-lock" type="text" value="'.$obj->Nom_Demandeur.' '.$obj->Prenom_Demandeur.'">
				</td>
				<td>
					<input data-type="listbox" data-domaine="service" readonly name="'.$obj->ID_Demande.'" class="bvs-input-lock" type="text" value="Culture">
				</td>
				<td class="center">
					<input data-type="xlistbox" data-domaine="categorie" readonly name="'.$obj->ID_Demande.'" class="bvs-input-lock" type="text" value="'.$obj->Libelle.'">
				</td>
				<td>
					<input data-type="xlistbox" data-domaine="technicien" readonly name="'.$obj->ID_Demande.'" class="bvs-input-lock" type="text" value="'.$obj->Nom_Technicien.' '.$obj->Prenom_Technicien.'">
				</td>
				<td>
					<i class="icon-ok-sign" style="color:transparent" id="sav'.$obj->ID_Demande.'"></i>
				</td>
							</tr>';				
						
						$poste .=' 
							<tr>
								<td>'.$obj->VDB.'</td>
								<td>'.$obj->Compte_WIN.'</td>
								<td>'.$obj->IP_MAC.'</td>
							</tr>';
				
				
				// Test pour vérifier si la demande est prise par un technicien
				if(!isset($obj->Nom_Technicien)){$technicien = "0";				}
						
			}






			$array=array("content"=>$content,"poste"=>$poste);

return $array;

}


 ?>