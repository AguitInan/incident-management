<?php

//session_name('gi2');
//session_start();
include('/include/verif_login.php');
include('tools/cnx_param.php');

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Demande</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/ui/jquery.ui.all.css" />
		<link rel="stylesheet" media="all" type="text/css" href="bootstrap/css/ui/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox-skin-rounded-black.css"/>
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox.css"/>
		<link href="bootstrap/css/demo_table.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="bootstrap/css/commentaire.css"/>
		
		<script type="text/javascript" src="bootstrap/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>	
		<script type="text/javascript" src="bootstrap/js/modalbox.js"></script>

		 
		<style>

			body
			{
				height:1080px;
				width: 1920px;
			}
			.stage
			{
				width:280px;
				height:150px;
				float:left;
				margin-bottom:15px;
				margin-left:20px;
				border:1px solid black;
				padding:5px;
			}

			.stage .titre
			{
				font-family: 'Segoe UI', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
				font-weight:bold;
				font-size: 14pt;
				color:#5C0DAC;
				line-height: 0px; 
				margin-top:4px;
				padding:0;
				text-decoration:underline;
			}

			.high 
			{
				font-family: 'Segoe UI', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;    
				color:#0059D6;
				font-size: 14pt;
				font-weight:bold;
				text-align:center;
				line-height:0px;
			}

			#tpl
			{
				display:none;
				width:300px;
			}

			p
			{
				margin: 0 0 20px;
			}
			
		</style>
	
	</head>
	<body>

		<?php
		
		// On désérialise $_SESSION['Utilisateur'] contenant les données relatives à l'utilisateur
		$result2=unserialize($_SESSION['Utilisateur']);
		
		// On récupère l'ID de la demande
		$id=$_GET['id_demande'];
		
		// Connexion à la base de données
		$sth=Get_cnx();
		$content="";
									
									
		// On stocke dans $poste un tableau contenant le ou les postes concernés par la demande					
		$poste ='<h1><em>Poste(s)</em></h1>


		<div class="grid">


					<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
									<thead>
										<tr>
											
											<th>VDB</th>
											<th>Compte_WIN</th>
											<th>IP_MAC</th>

										</tr>
									</thead>
									<tbody>';
									
		// Requête permettant de récuperer les informations relatives à la demande
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
				$content=    '<h1><em>Demande</em></h1>


								<div class="grid">

									<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
													<thead>
														<tr>
															
															<th>Date et heure</th>
															<th>Demandeur</th>
															<th>Service</th>
															<th>Type problème</th>
															<th>Technicien en charge</th>

														</tr>
													</thead>
													<tbody>
									<tr>
									 <td class="id" id="'.$obj->ID_Demande.'">'.$obj->Date_Creation.'</td>
											<td>'.$obj->Nom_Demandeur.' '.$obj->Prenom_Demandeur.'</td>
											<td>Culture</td>
											<td class="center">'.$obj->Libelle.'</td>
											<td>'.$obj->Nom_Technicien.' '.$obj->Prenom_Technicien.'</td>
										</tr>
										</tbody>
									</table>
								</div>';				
						
						$poste .=' 
							<tr>
								<td>'.$obj->VDB.'</td>
								<td>'.$obj->Compte_WIN.'</td>
								<td>'.$obj->IP_MAC.'</td>
							</tr>';
				
				
				// Test pour vérifier si la demande est prise par un technicien
				if(!isset($obj->Nom_Technicien)){
				
					$technicien = "0";
						
				}
						
			}

			
		$poste .= 				'</tbody>
		</table>
						</div>';
		
		
		// On concatène le tableau $content comportant les informations relatives à la demande avec $poste qui contient la liste des postes concernés par la demande sous forme de tableau
		$contenu = $content.$poste;

		echo($contenu);

		?>


		<!-- Template des commentaires -->
		<h1><em>Commentaire(s)</em></h1>
		 <div id='tpl'>
			{{#com}}
			<div class='stage'>
			  <p class='titre'>{{ID_Agent}}</p>
			  <p class='high'>{{Nom}} {{Prenom}}</p>
			  <p class='high'>Date : {{Date}}</p>
			  <p class='mid'>{{Commentaire}}</p>
			</div>
			{{/com}}
		  </div>
		  
		<?php
			// Si la demande n'est pas déjà prise en compte par un technicien, on affiche un bouton pour permettre de la prendre en compte
			if((isset($technicien)) && ($technicien == "0") ){

				echo '<button id="modal_demande" align="right" type="button" class="btn btn-primary">Prendre en compte</button> ';

			}

		?>
			
		<a href="accueil.php" id="bouton3" class="btn">Retour</a>


		<?php
		
		
		// Si la demande est prise en compte, on affiche un formulaire d'ajout de commentaires
		if(!isset($technicien) ){

			echo '<div id="addCommentContainer">
			 <h4 align="center">Ajouter un commentaire</h4>
			 <form id="form1" method="post" action="">

			 <p>
			 <label id="commentaires" for="commentaires">Commentaire</label>
			 <textarea name="body" cols="35" rows="6" id="body"></textarea>
			 </p>
			 <p>

			 <input type="hidden" name="id_page" id="id_page" value="<?php echo $id_page ?>" />
			 <p><input type="submit" id="submit" value="Envoyer" /></p>

			 </form>
			</div>';

		}

		?>
		<script type="text/javascript" src="bootstrap/js/mustache.js"></script>
		<script>
		
			// Fonction permettant l'affichage des commentaires à l'aide de la fonction JS Mustache
			$(document).ready(function($){

				id = "<?php echo $id ?>";
			  $.get('commentaire.php',{ identifiant : id}, function(data){
			  console.log(data);
				  $('#tpl').html(Mustache.render($('#tpl').html(), {com : data} ));
				  $('#tpl').css({"display":"inherit"});
			  },'json');
			})
		</script>

		<script>

			// Affichage du Modal pour l'assignation de l'intervention au technicien
			function testDirectCall_Source_modal_demande($id_technicien, $id_demande){

				jQuery.fn.modalBox({
					directCall :
						{
							source : 'modal_demande.php?ID_Technicien='+$id_technicien+'&ID_Demande='+$id_demande
						}
				});
			}
							
			//Appel ajax du Formulaire modal_demande
			$("#modal_demande").click(function(){
			
				id_technicien= "<?php echo $result2->Technicien_ID_Agent ?>";	
				id_demande = "<?php echo $_GET['id_demande'] ?>";
				testDirectCall_Source_modal_demande(id_technicien, id_demande);
				
			});
				
		</script>

	</body>
	
</html>