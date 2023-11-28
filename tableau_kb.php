<?php
include('/inc/header.php');

require '/tools/cnx_param.php';
require '/bo/cl_ConnectedUser.php';
require 'backoffice_fct.php';
require 'index_m.php';

$tableau_kb = Tableau_KB();

?>	
		<style>

			tr{cursor:pointer};

		</style>

		<title>Fiches KB</title>
		
	</head>

	<body>

		<?php include('/inc/menu.php'); ?>
			
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span10">					
			
					<h3>Fiches KB</h3>
					
					<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
						<thead>
							<tr>
								
								<th>ID_KB</th>
								<th>Applicatif</th>
								<th>Mots-Clés</th>
								<th>Auteur</th>
								<th>ID_Demande</th>

							</tr>
						</thead>
						<tbody>
							
							<?php echo $tableau_kb; ?>
							
						</tbody>
						<tfoot>
							<tr>
							
								<th>ID_KB</th>
								<th>Applicatif</th>
								<th>Mots-Clés</th>
								<th>Auteur</th>
								<th>ID_Demande</th>
								
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>	
		

		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery.avgrund.js"></script>
		
		<script type="text/javascript" src="bootstrap/js/jquery.dataTables.js"></script>
				
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
					"aaSorting": [[ 0, "desc" ]]
				
				});		
			});
				
			
			// Fonction permettant d'afficher le contenu de la fiche KB sélectionnée sous forme de Modal
			$("body").on("click", "tr", function(){
		
				id_kb = $(this).children(":first").attr("id").substr(2);
			
				$.ajax({
						type: 'GET',
						url: 'demande_ajax11_affichage_kb.php',
						data: { id: id_kb },
						success: function(data) {
							$('#id' + id_kb).avgrund({
								openOnEvent: false,
								width: 640,
								height: 350,
								template:  data
							});
						}
				});
			
			});
			
			
		</script>
		
	</body>
	
</html>