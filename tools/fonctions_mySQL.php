<?php

require '/tools/fonctions_conversion.php';
	
// Fonction SELECT_ALL_TABLE affiche tout le contenu d'une table avec tous les champs également
function SELECT_ALL_TABLE ($table)
{
	try
	{
		$connexion = Get_cnx();
		$req = 'SELECT * FROM '.$table;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table incorrect";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Table vide";
			}else{
				$var = "";			
				foreach($donnees as $key => $val)
				{
					foreach($val as $sous_key=>$sous_val)
					{
						$last_key = end(array_keys($val));

						if($sous_key == $last_key){
							$var .= $sous_key.' = '.'"'.$sous_val.'"<br />';
						}else{
							$var .= $sous_key.' = '.'"'. $sous_val.'"  ';
						}
					}
					
				}
				echo $var;
				$st -> closeCursor();
			}
		}
	
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT_ALL affiche tous les champs d'une table résultant d'une requête Select avec utilisation du WHERE
function SELECT_ALL ($table,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT * FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
			$var = "";	
			foreach($donnees as $key => $val)
			{
				foreach($val as $sous_key=>$sous_val)
				{
					$last_key = end(array_keys($val));

					if($sous_key == $last_key){
						$var .= $sous_key.' = '.'"'.$sous_val.'"<br />';
					}else{
						$var .= $sous_key.' = '.'"'. $sous_val.'"  ';
					}
				}
			
			}
			echo $var;
			$st -> closeCursor();
			}
		}
		$connexion = null;
	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT affiche les champs sélectionnés d'une table résultant d'une requête Select avec utilisation du WHERE
function SELECT ($table,$array_Champs,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Champs = toString_CHAMPS($array_Champs);
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT '.$chaine_Champs.' FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
				$var = "";	
				foreach($donnees as $key => $val)
				{
					foreach($val as $sous_key=>$sous_val)
					{
						$last_key = end(array_keys($val));

						if($sous_key == $last_key){
							$var .= $sous_key.' = '.'"'.$sous_val.'"<br />';
						}else{
							$var .= $sous_key.' = '.'"'. $sous_val.'"  ';
						}
					}
				
				}
				echo $var;
				$st -> closeCursor();
			}
		}
	$connexion = null;
	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}

	
// Fonction INSERT qui permet d'effectuer une requête de type INSERT
function INSERT ($table,$array_Values)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Values = toString_VALUES($array_Values);
		$req = 'INSERT INTO '.$table.' VALUES '.$chaine_Values;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Nom de table incorrect (ou clé étrangère non existante) !";
		}else{
			if ( $st != 0 ){
				//echo "L'entrée a bien été ajoutée !";
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction UPDATE qui permet d'effectuer une requête de type UPDATE
function UPDATE ($table,$array_Set,$array_Where)
{
	try
	{
		$connexion = Get_cnx();
		$chaine_Set = toString_SET($array_Set);
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'UPDATE '.$table.' SET '.$chaine_Set.' WHERE '.$chaine_Where;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Aucune modification !";
		}else{
	
			switch ($st)
			{ 
				case 0:
				//echo 'Aucune entrée n`\'a été modifiée ! <br/>';
				break;

				case 1:
				//echo 'Une entrée a été modifiée ! <br/>';
				break;

				default:
				//echo $st. ' entrées ont été modifiées ! <br/>';
				break;
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction DELETE_ALL qui permet d'effacer tout le contenu d'une table
function DELETE_ALL ($table)
{		
	try
	{
		$connexion = Get_cnx();
		$req = 'DELETE FROM '.$table;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Nom de table incorrect !";
		}else{
			if ( $st != 0 ){
				//echo "La table a été supprimée !";
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}

	
	
// Fonction DELETE qui permet d'effacer le contenu d'une table sélectionné par le WHERE
function DELETE ($table,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'DELETE FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Nom de table ou attributs incorrects !";
		}else{
			switch ($st)
			{ 
				case 0:
				//echo 'Aucune entrée n`\'a été supprimée ! <br/>';
				break;

				case 1:
				//echo 'Une entrée a été supprimée ! <br/>';
				break;

				default:
				//echo $st. ' entrées ont été supprimées ! <br/>';
				break;
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT_ALL_TABLE_AFFICHAGE affiche tout le contenu d'une table avec tous les champs également avec affichage sous forme de tableau (utilisation de la fonction afficherTable)
function SELECT_ALL_TABLE_AFFICHAGE ($table)
{	
	try
	{
		$connexion = Get_cnx();
		$req = 'SELECT * FROM '.$table;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table incorrect";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Table vide";
			}else{
				afficherTable ($donnees);
				$st -> closeCursor();
			}
		$connexion = null;
		}
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT_ALL affiche tous les champs d'une table résultant d'une requête Select avec utilisation du WHERE avec affichage sous forme de tableau (utilisation de la fonction afficherTable)
function SELECT_ALL_AFFICHAGE ($table,$array_Where)
{
	try
	{
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT * FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
				echo $st->rowCount() . ' résultat(s)';
				afficherTable ($donnees);
				$st -> closeCursor();
			}
		}
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}



// Fonction SELECT affiche les champs sélectionnés d'une table résultant d'une requête Select avec utilisation du WHERE avec affichage sous forme de tableau (utilisation de la fonction afficherTable)
function SELECT_AFFICHAGE ($table,$array_Champs,$array_Where)
{
	try
	{
		$connexion = Get_cnx();
		$chaine_Champs = toString_CHAMPS($array_Champs);
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT '.$chaine_Champs.' FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
				afficherTable ($donnees);
				$st -> closeCursor();
			}
		}
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}

?>