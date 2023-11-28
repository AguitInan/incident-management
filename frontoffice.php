<?php
require '/tools/helper.php';
?>

<!DOCTYPE html>
<html>
	<head>
	
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<title>Front Office</title>
		<link rel="shortcut icon" type="images/x-icon" href="" />			
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/ui/jquery.ui.all.css" />
		<link rel="stylesheet" href="bootstrap/css/jquery-ui-1.10.3.custom.css" />
		<link href="bootstrap/css/demo_table.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/base.css">

		<style>
		  
		  [id^=kb]{cursor:pointer};

		</style>	

<?php

require '/bo/cl_ConnectedUser.php';
include("/tools/fonction_ntlm.php");

// On récupère les informations correspondant au poste pour associer automatiquement la nouvelle demande au poste sur lequel la demande est faîte
$result = ntlm_login();

require ('pdo/SPDO.class.php');
require('bo/Categorie.php');
require('dal/Categorie_manager.php');
require('bo/Applicatif.php');
require('dal/Applicatif_manager.php');

$db=new SPDO();

$tabcategorie=DAL_Categorie::SelectAll($db);
$tab2=array();
$tab2[]='--Sélectionnez une catégorie--';
foreach($tabcategorie as $c){
$tab2[$c->Get_id_Categorie()]=$c->Get_Libelle();
}

$tabapplicatif=DAL_Applicatif::SelectAll($db);
$tab3=array();
$tab3[]="--Sélectionnez un applicatif--";
foreach($tabapplicatif as $c){
$tab3[$c->Get_id_Applicatif()]=$c->Get_Libelle();
}

HlpForm::Start(array('url' =>'ajout_demande_saveDemande.php','action'=>'post','titre'=>'Front Office'));
?>
		<div class="container-fluid">
			<div class="formulaire-content1150"> 
				<div class="row-fluid">
					<div class="content-1" style="margin-top:45px;width:100%;height:100%">
						<div class="span12 titre-bvs" id="click">
							<i class="icon-bvs-left icon-arrow-right icon-white"></i>
							Demandeur
						</div>
						<div class="span12 poste" id="ajoutposte">
							<div class="span6 poste" id="drop">

							</div>					
							<div class="span6 poste-search" id="result">
								<div class="search">								
									<input type="text" class="poste-search-input" id="recherche">
									<i class="icon-search bvs-icon-left" style="margin-left:5px;font-size:18px"></i>
								</div>
								<div id="result2">
								
								</div>
							</div>
						</div> <!-- ID = ajoutposte -->
					</div>
					
					<div id="Content"></div>
					<div style="clear:both"></div>
					<div class="span10">
					
						<?php
							HlpForm::liste2('Categorie',$tab2,'Catégorie');
							HlpForm::liste2('Applicatif',$tab3,'Applicatif');
						?>
						<div class="span10">
							<h5>Description</h5>
							<textarea name="description" id="description" style="width:400px;height:150px;"></textarea>
						</div>

							<input name="ID_Agent" type="hidden" id="ID_Agent" value="">
							<input name="Matricule" type="hidden" id="Matricule" value="">
							<input name="Service" type="hidden" id="Service" value="">
							<input name="Poste" type="hidden" id="Poste" value="<?php echo $result->Getworkstation(); ?>"> <!-- Ici on stocke le nom du Poste dans un input de type hidden -->
							
					</div>
					<div style="clear:both"></div>
					<div class="span10">
					
						<div id="Content2" class="span4"></div>

						<div id="Content3" class="span4"></div>
						
					</div>

					<?php
						HlpForm::Submit();
					?>
				</div> <!-- Row-fluid-->
			</div> <!--formulaire-content1150-->
		</div> <!-- ontainer-fluid-->

		
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>		
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.10.3.custom.min.js"></script>

		<script>
		
			$(document).ready(function(){

				// On cache le formulaire Select des applicatifs
				$("#Applicatif").hide();

				// Contrôles sur le formulaire des catégories
				$("#sCategorie").change(function(){
					$("#Content").empty();
					categorie = $(this).val();

					if(categorie == 2){
					
						// On affiche le formulaire Select des applicatifs lorsque la catégorie 2 (correspondant aux applicatifs) est sélectionnée...
						$("#Applicatif").show();
					
					}else{
					
						// ... sinon on le cache
						$("#Applicatif").hide();
					}

				});

			});
			
		</script>


		<script>

			// On cache le bouton Submit
			$("input:submit").hide();
				
				
			$('#recherche').keyup( function(){
				  
				$field = $(this);
				$('#ajax-loader').remove(); // on retire le loader

				// on commence à traiter à partir du 2ème caractère saisi
				if( $('#recherche').val().length > 2 ){
				
					// on envoie la valeur recherché en GET au fichier de traitement
					$.ajax({
					
						type : 'GET', // envoi des données en GET ou POST
						url : 'ajout_demande_ajax_recherche_agent.php' , // url du fichier de traitement
						data : 'recherche='+$('#recherche').val() , // données à envoyer en  GET ou POST
						beforeSend : function() { // traitements JS à faire AVANT l'envoi
							$field.after('<img src="img/ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
						},
						success : function(data){ // traitements JS à faire APRES le retour
						
							$('#ajax-loader').remove(); // on enleve le loader
							$('#result2').html(''); // on vide les resultats
							$('#result2').html(data); // affichage des résultats dans le bloc
														
										
						}
					});
					
				}
				
				// si pas plus de 2 caractères saisis
				if( $('#recherche').val().length <= 2 ){
				
					$('#result2').html(''); // on vide les resultats
				
				}
																							  
			});

			
			// Fonction permettant d'associer l'agent à la demande avec l'évènenement .dblclick	
			$("#result2").on("dblclick", "[id^=drag]", function(){
				  
					e=$(this);
					
					id_agent = ($(this).attr('id').substring(4));
					matricule = $(this).data('matricule');
					service = $(this).data('service');

					$("#drop").empty();
					$("#drop").append($(this));
					setTimeout(function(){e.removeClass().addClass("vdbvisudrop");
					},800);

					$("#ID_Agent").attr("value",id_agent);
					$("#Matricule").attr("value",matricule);
					$("#Service").attr("value",service);
					
					verifSubmit();
							
			});

			// Fonction permettant de dissocier l'agent de la demande avec l'évènenement .dblclick
			$("#drop").on("dblclick", "[id^=drag]", function(){

				$(this).remove();
				$("#ID_Agent").attr("value","");
				$("#Matricule").attr("value","");
				$("#Service").attr("value","");
				
				verifSubmit();
										
			});

			// à chaque changement des formulaires Select
			$("select").change(function() {
				verifSubmit();
			});
			
			// Fonction permettant d'afficher le bouton Submit lorsque le formulaire est bien complété
			function verifSubmit()
			{
			
				if(  ( ($("#sCategorie").val() != 0) &&  ($("#sCategorie").val() != 2) &&   ($("#ID_Agent").val() != 0)  )    ||    ( ($("#sCategorie").val() == 2) &&  ($("#sApplicatif").val() != 0)  &&   ($("#ID_Agent").val() != 0)   )     ){
				
					$("input:submit").show();
				
				
				}else{
				
					$("input:submit").hide();
				
				}
				
			}
			
						
		</script>
		
	</body>
</html>