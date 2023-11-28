<?php
include('/inc/header.php');

require '/tools/cnx_param.php';
require '/bo/cl_ConnectedUser.php';
require 'backoffice_fct.php';
require 'index_m.php';

$historique = Historique();

?>
		<style>

			tr{cursor:pointer};

		</style>

		<title>Historique des demandes</title>
		
	</head>

	<body>

		<?php include('/inc/menu.php'); ?>
		
			
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span10">					
			
					<h3>Historique des demandes</h3>
					
					
					<div class="span2">
						<i class="icon-th-large"></i><button id="cible" class="btn btn-link" style="oui">Filtrer</button>
					</div>
					<div class="span2">
						<i class="icon-th"></i><button id="tout" class="btn btn-link">Tout afficher</button>	
					</div>
						
					<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
						<thead>
							<tr>
								
								<th>Date</th>
								<th>Demandeur</th>
								<th>Service</th>
								<th>Catégorie</th>
								<th>Etat</th>

							</tr>
						</thead>
						<tbody>
							
							<?php echo $historique; ?>
							
						</tbody>
						<tfoot>
							<tr>
							
							   <th>Date</th>
								<th>Demandeur</th>
								<th>Service</th>
								<th>Catégorie</th>
								<th>Etat</th>
								
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
			
		
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.10.3.custom.min.js"></script>
		
		<script type="text/javascript" src="bootstrap/js/jquery.dataTables.js"></script>
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

				
				// Gestion des catégories et applicatifs préférés
				
				if(
				
					(
					
						(
						 $.inArray(categorie , t_categorie) == -1
						)
						
						||
						
						(
						
						 (
						  categorie == 2
						 )
						 
						 &&
						 
						 (
						  $.inArray(applicatif , t_applicatif) == -1
						 )
						 
						)
						
					)

					&&
					
					(
					
					 (
					 
					  (
					   categorie == 2
					  )
					  
					  &&
					  
					  (
					   t_applicatif.length == 0
					  )
						 
					  &&
					  
					  (
					   $.inArray(categorie , t_categorie) !== -1
					  )

					 )
					
					 ==
					 
					 (
					 
					  0

					 )
					
					)
						
						
				){
					
					// Demande non ciblée
					$(this).attr("data-filtre", "0");
						
				}else{
				
					// Demande ciblée
					$(this).attr("data-filtre", "1");	
					
					}
			});
		
		
		</script>
			
		<script>
		
			var filtre = "1";
		
			// Fonction qui permet de reconstruire le Datatable selon l'affichage sélectionné (Tout afficher/Demandes cibles)
			$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {
					
					var myRowClass = oSettings.aoData[iDataIndex].nTr.getAttribute("data-filtre");

					if(filtre == 1){

						if(myRowClass == "0"){
							return false;
						}else{
							return true;
						}

					}else{
					
						return true;


					}
					 
				}
			);
		

			// Fonction permettant le tri du tableau selon la date au format français
			jQuery.extend( jQuery.fn.dataTableExt.oSort, {
				"date-euro-pre": function ( a ) {
					if ($.trim(a) != '') {
						var frDatea = $.trim(a).split(' ');
						var frTimea = frDatea[1].split(':');
						var frDatea2 = frDatea[0].split('/');
						var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1]) * 1;
					} else {
						var x = 10000000000000; // = l'an 1000 ...
					}
					 
					return x;
				},
			 
				"date-euro-asc": function ( a, b ) {
					return a - b;
				},
			 
				"date-euro-desc": function ( a, b ) {
					return b - a;
				}
			});	

		</script>	
				
		<script>

			// Traduction en français du plugin JQuery dataTable
			$(document).ready(function(){
				var oTable =	$('#example').dataTable( {
					"oLanguage": {
						"sProcessing":     "Traitement en cours...",
						"sSearch":         "Rechercher&nbsp;:",
						"sLengthMenu":     "Afficher _MENU_ ",
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
					},
					"sPaginationType": "full_numbers",
					"aaSorting": [[ 0, "desc" ]],
					"aoColumns": [{ "sType": "date-euro" },null,null,null,null]
				
				});
				
				
				// Fonction qui créé un lien vers la demande sélectionnée
				$("tbody").on("click", "tr", function(){

						id_demande=($(this).children(":first").attr("id")).substr(2);

						document.location.href = 'demande.php?id_demande='+ id_demande;

				});
					
					
					
				// Fonction qui permet d'afficher toutes les interventions
				$("#tout").click(function (){
				
					filtre = "0";
					oTable.fnDraw();
				
				});
						

				// Fonction qui permet de filtrer les interventions et de n'afficher que les interventions cibles du technicien
				$("#cible").click(function (){
					
					filtre = "1";
					oTable.fnDraw();

				});

			});
				
		</script>
			
	</body>
	
</html>