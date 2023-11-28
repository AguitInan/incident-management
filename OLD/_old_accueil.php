<?php

session_name('gi2');
session_start();

if( isset ($_POST['Login'])){
$_SESSION['Login'] = $_POST['Login'];
}

if( isset ($_POST['Password'])){
//$_SESSION['Password'] = md5($_POST['Password']);
$_SESSION['Password'] = $_POST['Password'];
}

require '/tools/helper.php';
require '/tools/fonctions_mySQL.php';
require '/bo/cl_ConnectedUser.php';
require 'backoffice_fct.php';

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Accueil</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/ui/jquery.ui.all.css" />
		<link rel="stylesheet" media="all" type="text/css" href="bootstrap/css/ui/jquery-ui-1.8.16.custom.css" />
		<link href="bootstrap/css/demo_table.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox-skin-rounded-black.css"/>
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox.css"/>
		
		
		<script type="text/javascript" src="bootstrap/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="bootstrap/js/modalbox.js"></script>
		

		<style>
		
		input{height:25px};
		[id^=id]{cursor:pointer}
		#footer {background: #EDEDED;width:100%;}
		
		</style>
		
	</head>
	<body>
	
	<h2 align="center"> Gestionnaire des Interventions Mairie <br></h2>
	
	
		<?php
		
		// On désérialise les données de l'objet type ConnectedUser stocké en session s'il existe (dans le cas d'une authentification automatique)
		if(isset($_SESSION['ConnectedUser'])){
		
			 $result=unserialize($_SESSION['ConnectedUser']);
			 $result2=unserialize($_SESSION['Utilisateur']);
			 
		}

		 
		// Page d'accueil

		// Reception des données
		if ( isset ($_SESSION['Login']) && isset ($_SESSION['Password']) ){
		
			$login = $_SESSION['Login'];
			$password= $_SESSION['Password'];

			try
			{
				$req = 'SELECT * FROM Agent A JOIN Technicien B ON A.ID_Agent=B.Technicien_ID_Agent WHERE Login = "'.$login.'" AND Password = "'.$password.'"';
				$st = $sth->query($req);
				$donnees = $st->fetch( PDO::FETCH_OBJ);
				
				// On vérifie le Login et le Mot de passe
				if($donnees == FALSE){
				
					echo 'Utilisateur inconnu ou mauvais mot de passe';
					
				}
				
			}
			catch(Exception $f)
			{
				echo 'err : '.$f->getMessage().'<br />';
			}
			
		}
		
		elseif(!isset($result)){
		
			echo 'Veuillez passer par la page d\'authentification';
			
			
		}
		
		
		
		$tableau = '<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                            <thead>
                                <tr>
                                    
                                    <th>Date et heure</th>
                                    <th>Demandeur</th>
                                    <th>Service</th>
                                    <th>Type problème</th>
									<th>Etat</th>

                                </tr>
                            </thead>
                            <tbody>
                                
								'.$content.'
								
                            </tbody>
                            <tfoot>
                                <tr>
								
                                   <th>Date et heure</th>
                                    <th>Demandeur</th>
                                    <th>Service</th>
                                    <th>Type problème</th>
									<th>Etat</th>
									
                                </tr>
                            </tfoot>
                        </table>';
		
		if((isset($result)) OR ($donnees == TRUE)){
			
			// Si on est passé par le formulaire, on stocke l'objet $donnees dans $result2
			if(isset($donnees))
			{
				$result2 = $donnees;
				
				$_SESSION['Utilisateur'] = serialize($donnees);
				
			}	
		
			// Récupération Catégories préférées
			try
			{
				

				$categorie = array();
				$return = $sth->query("SELECT * FROM Technicien_Categorie WHERE Technicien_ID_Agent = ".$result2->Technicien_ID_Agent."");
				


				while($obj = $return->fetch(PDO::FETCH_OBJ))
				{
					$categorie[] = $obj->ID_Categorie;
					
				}
				
				
			}
			catch(Exception $f)
			{
				echo 'err : '.$f->getMessage().'<br />';
			}
			
			
			// Récupération Applicatifs préférés
			try
			{
				

				$applicatif = array();
				$return = $sth->query("SELECT * FROM Technicien_Applicatif WHERE Technicien_ID_Agent = ".$result2->Technicien_ID_Agent."");
				


				while($obj = $return->fetch(PDO::FETCH_OBJ))
				{
					$applicatif[] = $obj->ID_Applicatif;
					
					
					
				}
				
				
			}
			catch(Exception $f)
			{
				echo 'err : '.$f->getMessage().'<br />';
			}
			
			
			echo '<div align="center"><button id="cible" class="btn btn-primary" style="oui">Afficher cibles</button>
		
				<button id="tout" class="btn btn-info">Tout afficher</button>
				
				</div>';

			
			echo $tableau;
				
		}
		
		?>

		<div id="contentteam">
                    
        </div>     
		
		
		<br/>
		<div class="footer-content">
			<div class="footer-text">
				Mairie de Beauvais - communauté d'agglomération du Beauvaisis
			</div>	
		</div>	
		
		<script type="text/javascript" src="bootstrap/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="bootstrap/js/shCore.js"></script>
			
			
			
		<script>
         
		 
		 // Traduction en français du plugin JQuery dataTable
			$(document).ready(function(){
					$('#example').dataTable( {
					"oLanguage": {
						"sProcessing":     "Traitement en cours...",
				"sSearch":         "Rechercher&nbsp;:",
				"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
				"sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
				"sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
				"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
				"sInfoPostFix":    "",
				"sLoadingRecords": "Chargement en cours...",
				"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
				"sEmptyTable":     "Aucune donnée disponible dans le tableau",
				"oPaginate": {
					"sFirst":      "Premier",
					"sPrevious":   "Pr&eacute;c&eacute;dent",
					"sNext":       "Suivant",
					"sLast":       "Dernier"
				},
				"oAria": {
					"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
					"sSortDescending": ": activer pour trier la colonne par ordre décroissant"
				}
			}
			
			});
		
		

		// Création du lien vers la page demande.php pour chaque intervention
			$("[id^=id]").live("click",function(){

					id_demande=($(this).attr("id")).substr(2);

					document.location.href = 'demande.php?id_demande='+ id_demande;

			});

			});
			
		</script>
		
			
		<script>
		
			var applicatif;
			var categorie;
			
			
			// On récupère les tableaux partie PHP $categorie et $applicatif contenant les catégories et applicatifs cibles du technicien
			var t_categorie = <?php echo json_encode($categorie) ?>;
			var t_applicatif = <?php echo json_encode($applicatif) ?>;
			
			$( "tbody tr ").each(function(index, value){
				
				// Pour chaque intervention, on récupère le numéro de catégorie et le numéro applicatif
				categorie = $(this).attr("data-categorie");
				applicatif = $(this).attr("data-applicatif");
				
				
			// Gestion des catégories préférées
				
				
				// On teste la présence du numéro de catégorie de l'intervention dans le tableau des catégories préférées du technicien t_categorie
				if( $.inArray(categorie , t_categorie) == -1  ){
					
					if( $.inArray(applicatif , t_applicatif) == -1){
					
						$(this).hide();
					
					}		
				}
				
				// Gestion des applicatifs préférés (applicatifs = catégorie numéro 2)
				
				if(( categorie == 2) && ($.inArray(applicatif , t_applicatif) == -1)){
				
					$(this).hide();
				
				}
							
			});
			
			
			
			// Fonction qui permet d'afficher toutes les interventions
			$("#tout").click(function (){
			
				$("tr").show("slow");
				
			});
					

			// Fonction qui permet de filtrer les interventions et de n'afficher que les interventions cibles du technicien
			$("#cible").click(function (){
				
				$("tbody tr[style]").hide("slow");

			});
		
		
		</script>
		

			
	</body>
	
</html>