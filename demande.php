<?php
include('/inc/header.php');

require('demande_m.php');

// On désérialise $_SESSION['Utilisateur'] contenant les données relatives à l'utilisateur
	$result2=unserialize($_SESSION['Utilisateur']);
	$id=$_GET['id_demande'];// On récupère l'ID de la demande
	$content="";$poste="";
	Dmd_Lue($id,$result2->Technicien_ID_Agent);// Fonction qui passe la demande de l'état "Nouvelle" à l'état "Lue"
	$content=Dmd_by_Id($id); 
	$dmd_obj=Dmd_by_Id_return_obj($id);
	$poste = Poste_by_Id($id);

?>
		<style>

			.header
			{
				width:600px;
				height:56px;
				position:absolute;
				top:0px;
				left:25%;
				background:#fff url(title.png) no-repeat top left;
			}
			a.back{
				width:256px;
				height:73px;
				position:fixed;
				bottom:15px;
				right:15px;
				background:#fff url(codrops_back.png) no-repeat top left;
			}
			.scroll{
				width:133px;
				height:61px;
				position:fixed;
				bottom:15px;
				left:150px;
				background:#fff url(scroll.png) no-repeat top left;
			}
			.info{
				text-align:right;

			}
			
		  
		  .slide-out-div {
			  padding: 20px;
			  width: 350px;
			  background: #2B5797;
			  color:white;
			  font-weight: bold;
			  
		  }
		  .espace{
			margin-bottom: 35px;
		  }
		  
		  #ajout_kb{
			cursor: pointer;
		  }
		  
		  [id^=kb]{cursor:pointer};

		</style>

		<title>Demande</title>
	
	</head>

	<body>
		
		<?php include('/inc/menu.php'); ?>
		
		<?php if ($dmd_obj->Etat_Actuel != 6): ?>
		
			<div class="slide-out-div" style="height:658px;">
			 
				<a class="handle" href="">Content</a>
				
				<legend style="color:white;">
					Planifier l'intervention
				</legend>

				<label class="control-label" for="Date"></label>
				<div class="controls">
					<div type="text" name="Date" id="Date"></div>
				</div>
				
				<div type="text" id="Date">
					<div class="espace"></div>
				</div>
				<div class="cadre" style="padding:10px;width:250px;border:1px solid white;">
					<?php
					
						HlpForm::RadioList(array(0=>"Matin",1=>"Après-Midi"),"Période");
					
					?>
					
					<div id="contentteam" style="margin:10px;"></div>    	
					<div class="bottom-space25" style="margin:20px;"></div>
					<div class="form-horizontal">
						<button id="upt_demande" align="right" type="button" class="btn btn-primary">Valider</button>
					</div>			
				</div>

			</div>
		<?php endif; ?>
		
		<div class="container-fluid">
			<div class="formulaire-content1150"> 
				<div class="row-fluid">					
					<div class="content-1" style="margin-top:45px;width:100%;height:100%">
						<div class="span6 titre-bvs">
							<i class="icon-bvs-left icon-info-sign icon-white"></i>
							Demande N° <?php echo($dmd_obj->Demande_ID_Demande); ?>
							du <?php echo date2fr(substr($dmd_obj->Date_Creation, 0, -9)).' à '.substr($dmd_obj->Date_Creation, -8, -3); ?>
						</div>
						<div class="span6 titre-bvs-right">
							<i class="icon-bvs-left icon-sitemap icon-white"></i>
							Ip demande : <?php echo($dmd_obj->IP_MAC); ?>		  					
						</div>
						<div class="span12 detailsdmd">
							<i class="icon-bvs-left icon-question" style="color:#7E3878;font-size:16px;"></i>
							<?php echo($dmd_obj->Details); ?>
						</div>
						<div class="span12 etatdmd">
							<i class="icon-bvs-left icon-question" style="color:#7E3878;font-size:16px;"></i>
							Etat : <?php echo($dmd_obj->Libelle_Etat); ?>
						</div>
						
						<?php if ($dmd_obj->Etat_Actuel == 4) : ?>
							
							<div class="span12 detailsplanif">
								<i class="icon-bvs-left icon-question" style="color:#7E3878;font-size:16px;"></i>
								Planifiée par <?php echo($dmd_obj->Nom_Technicien.' '.$dmd_obj->Prenom_Technicien); ?> le 
								
								<?php 

									if(substr($dmd_obj->Date_Prevision_Inter, -8) == '08:00:00'){
									
										echo date2fr(substr($dmd_obj->Date_Prevision_Inter, 0, -9)).' (Matin)';
									
									}else{

										echo date2fr(substr($dmd_obj->Date_Prevision_Inter, 0, -9)).' (Après-Midi)';
									}
									
								?>
							</div>
							
						<?php endif; ?>
					
		  			</div>
					
					<div class="grid">					
						<div class="span12 titre-bvs">
			  				<i class="icon-bvs-left icon-arrow-right icon-white"></i>
			  				Détails sur le Demandeur
			  			</div>
						<table class="table table-condensed">
				        	<thead>
				            	<tr>
				                	<th>#</th>
				                	<th>Nom Prenom</th>
				                	<th>Service</th>
				                	<th>Mail</th>
				                	<th>Tél</th>
				                </tr>
				            </thead>
				            <tbody>
				            	<tr id="demandeur">
				                	<?php echo $content; ?>
				                </tr>				                
				            </tbody>
				        </table>	
					</div> <!-- grid-->
					
					<div class="span12 titre-bvs" id="click">
			  			<i class="icon-bvs-left icon-arrow-right icon-white"></i>
			  			Poste(s) associé(s)
			  		</div>
					<div class="span12 poste" id="ajoutposte">
						<div class="span6 poste" id="drop">
							<?php echo($poste) ?>
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

					<div class="span12">
			  			<div class="span6"></div>
						<div class="span6"></div>
			  		</div>
					<div class="span12 titre-bvs" >
					
						<div class="span7">
							<i class="icon-bvs-left icon-arrow-right icon-white"></i>
							Commentaire(s) détails de l'intervention
						</div>			  			
			  			<div class="span3" id="reduirecommInter" style="cursor:pointer;">
			  				<i class="icon-bvs-left icon-plus icon-white"></i>
							masquer/afficher
			  			</div>
			  			
			  		</div>

			  		<div class="span11" id="tplCommentaire">
			  			<div id='tpl' class="span11 commentaires" style="margin-bottom:5px;">
						<!-- Commentaire en ajax -->						
						</div>
						<div class="span11" style="margin-left:260px;">
							<textarea id="commentaire" style="width:400px;height:25px;"></textarea>					
							<button id="ajout_com" align="right" type="button" class="btn btn-primary">Ajouter</button>
						</div>
			  		</div>
					
					<div class="span12 titre-bvs" style="margin-bottom:25px;background-color:#95bb22">
			  			<div class="span7">
			  				<i class="icon-bvs-left icon-quote-left icon-white"></i>
							<i class="icon-quote-right icon-white"></i>
			  				Commentaire(s) de l'Agent
			  			</div>
			  			<div class="span3" id="reduirecommAgent" style="cursor:pointer;">
			  				<i class="icon-bvs-left icon-plus icon-white"></i>
							masquer/afficher
			  			</div>
			  		</div>
			  		<div class="span12" id="comagentall">
						<div class="span11 comagent" style="margin-left:0px;">
							<div class="span11 t" style="font-weight:bold;margin-top:10px;margin-left:10px;">
								De : Sylvia Barris  - le 21 aout 2013 
							</div>
							<div class="span11" style="">
								Commentaire : Je ne suis pas disponible à la date prévue
							</div>
						</div>
						<div class="span11 comagent"  style="margin-left:0px;">
							<div class="span11" style="font-weight:bold;margin-top:10px;margin-left:10px;">
								De : Sylvia Barris  - le 21 aout 2013 
							</div>
							<div class="span11" >
								Commentaire : Merci d'être passé.
							</div>
						</div>
					</div>
					<div class="span12 titre-bvs" style="margin-top:5px;margin-bottom:25px;background-color:#bc1d49">
			  			<div class="span7">
			  				<i class="icon-bvs-left icon-group icon-white"></i>
			  				Knowledge Base
			  			</div>			  			
						<div class="span3" id="reduireKb" style="cursor:pointer;">
			  				<i class="icon-bvs-left icon-plus icon-white"></i>
							masquer/afficher
			  			</div>
			  		</div>
			  		<div class="span12" id="VisuKb">
			  			<div class="span12">
			  				<div class="span4" style="margin-right:20px;margin-top:10px;margin-bottom:25px;color:#bc1d49">
									<input type="text" class="poste-search-input" id="recherche-kb" style="padding:0px;">
									<i class="icon-search bvs-icon-left" style="margin-left:5px;font-size:18px"></i>
							</div>
						</div>
						<div id='tpl_kb' class="span11" style="margin-bottom:25px;">
							<!-- Fiches KB en ajax -->
						</div>

						<div class="span3" style="margin-right:20px;margin-top:10px;margin-bottom:25px;color:#bc1d49;margin-left:0px;">
							<input type="text" class="poste-search-input" id="ajout-nom-kb" style="padding:0px;">
						</div>
						<div class="span4" style="margin-right:20px;margin-top:10px;margin-bottom:25px;color:#bc1d49">
							<input type="text" class="poste-search-input" id="ajout-mot-kb" style="padding:0px;">
							<i class="icon-plus bvs-icon-left" style="margin-left:5px;font-size:18px" id="ajout_kb"></i>
						</div>
					</div>
					
					<?php if ( ($dmd_obj->Etat_Actuel == 3) || ($dmd_obj->Etat_Actuel == 4) ) : ?>
					
						<button id="cloture" align="right" type="button" class="btn btn-success">Clôturer</button>
					
					<?php endif; ?>
 
				</div> <!-- Row-fluid-->
			</div> <!--formulaire-content1150-->
		</div> <!-- container-fluid-->

		
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>		
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery.avgrund.js"></script>
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker-fr.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery.tabSlideOut.v1.3.js"></script>
		
		<script>
		
			// Modal de clôture de demande
			$(function() {
				$('#cloture').avgrund({
					//height: 200,
					//holderClass: 'custom',
					showClose: true,
					showCloseText: 'Fermer',
					//enableStackAnimation: true,
					//onBlurContainer: '.container',
					template:

							'<h4 class="modal-title">Clôture de demande</h4>' +
							'<div class="modal-body">' +
							  'Voulez-vous vraiment clôturer cette demande ?' +
							'</div>' +
							'<div class="modal-footer">' +
							  '<button id="valider" type="button" class="btn btn-primary">Oui</button>' +
							  '<button id="fermer" type="button" class="btn btn-default" data-dismiss="modal">Non</button>' +
							'</div>'
							
				});
			});
			
			
			// Paramétrage du bouton "Non" du modal de clôture de demande
			$("body").on("click", "#fermer", function(){
			
				$( ".avgrund-close" ).trigger( "click" );

			});

			// Paramétrage du bouton "Oui" du modal de clôture de demande
			$("body").on("click", "#valider", function(){

				id_demande= "<?php echo $_GET['id_demande'] ?>";	
				id_technicien= "<?php echo $result2->Technicien_ID_Agent ?>";
				
				document.location.href = 'demande_requete_cloture_DMD.php?ID_Technicien='+id_technicien+'&ID_Demande='+id_demande;
				
			});
		
		</script>
		
		<script type="text/javascript" src="bootstrap/js/mustache.js"></script>
		
		<script>

			$(document).ready(function($){
			
				//$('#tplCommentaire').toggle("hide");
				$('#comagentall').toggle("hide");  // On masque la partie "Commentaires de l'Agent"
				$('#VisuKb').toggle("hide");   // On masque la partie Fiches KB
				var _noeud;
				var _val_depart;
				var _val_fin;
				var _type_element;
				var _id;
				var _uid;
				id = "<?php echo $id ?>";

				var poste = new Array;
				var poste2 = new Array;
				var poste3 = new Array;

				// Fonction permettant l'affichage des commentaires à l'aide de la fonction JS Mustache
				$.get('demande_ajax2_commentaire.php',{ identifiant : id}, function(data){
					$('#tpl').html(data);
				});
					
				// Fonction permettant l'affichage des fiches KB

				id_applicatif = "<?php echo $dmd_obj->ID_Applicatif ?>";

				$.get('demande_ajax8_kb.php',{id_applicatif:id_applicatif}, function(data) {

					$('#tpl_kb').html(data);
					
				});

				// Traitement du lock unlock des inputs
				//trt edit
				$("body").on("dblclick","[id^=edit]" ,function(event){			  	
					_noeud=$(this);
					//$(this).attr('id', 'encours');
					_type_element;
					_id=$(this).attr('id');_id=_id.substring(4,_id.length); // = nom
					_val_depart=$(this).data('valeur'); // jean jacques
					_type_element=$(this).data('element');	// input
					_uid=$(this).data('uid');  // id
					switch (_type_element)
					{
						case "input":
						$(this).html('');
						$(this).append('<input id="encours" class="bvs-input-unlock" type="text" value="'+_val_depart+'" >');
						$("#encours").focus();

						$( "#encours" ).autocomplete({
							source: "demande_ajax1_autocomplete.php",
							minLength :2,
							select : function(event, ui)
							{ 
								//alert(ui.item.id);
								
								MiseaJourDemandeur(ui.item.id,_uid);
								
							}
						});
						break;
						case "listbox":
						$(this).html('');
						$(this).append('<select><option>Culture</option><option>Jeunesse</option></select>');
						break;
					}		  	 	
				});

				// FUNCTION AJAX SUR LES DEMANDEURS 

				function MiseaJourDemandeur(id,uid){
					//console.log(id+' id '+uid+' uid');
					$.get('demande_ajax3_modif_demandeur.php',{id_nv_agent:id,id_dmd:uid}, function(data) {
						//console.log(data);
						
						$('#demandeur').html("");
						$('#demandeur').append(data);

					});
				}

				// FIN DE FUNCTION DEMANDEURS

				// trt focus out des inputs
				$("body").on("focusout","#encours" ,function(event){

					_val_depart=$(this).attr( "value" );

					switch (_id)
					{
						case "nom":
						t = '<td id="editnom" data-uid="'+_uid+'" data-valeur="'+_val_depart+'" data-element="input">'+_val_depart+'</td>';
						$("#edit"+_id+"").replaceWith(t);
						break;
						case "mail":
						t = '<td id="editmail" data-uid="'+_uid+'" data-valeur="'+_val_depart+'" data-element="input">'+_val_depart+'</td>';
						$("#edit"+_id+"").replaceWith(t,function() {});
						break;

					}
				});

				$("body").on("focusout","select" ,function(event){
					alert(_id);
					_val_depart=$(this).val();
					$(this).replaceWith(_val_depart , function() {});
				});

				//drag an drop 
				$("[id^=pc_assos]").dblclick(function(){
									
					id_poste = ($(this).attr('id').substring(9));
					$(this).remove();
					
					$.ajax({
						
						type : 'GET', // envoi des données en GET ou POST
						url : 'demande_ajax5_delete_poste.php' , // url du fichier de traitement
						data : 'id_poste='+id_poste+'&id_demande='+id,  // données à envoyer en  GET ou POST , // données à envoyer en  GET ou POST

					});
						
				})

				
				// Association des postes à la demande
				$("#result2").on("dblclick", "[id^=drag]", function(){
								  
					e=$(this);
					
					id_poste = ($(this).attr('id').substring(4));
					
					$( "#drop div" ).each(function(index){

						poste[index] = $(this).attr("id").substring(9);
						poste2[index] = $(this).attr("id").substring(4);

					});
					
					if( ($.inArray(id_poste , poste) == -1 )   &&  ($.inArray(id_poste , poste2) == -1 )   ){
					
						$("#drop").append($(this));
						setTimeout(function(){e.removeClass().addClass("vdbvisudrop");
						},800);
						
						$.ajax({
						
							type : 'GET', // envoi des données en GET ou POST
							url : 'demande_ajax4_ajout_poste.php' , // url du fichier de traitement
							data : 'id_poste='+id_poste+'&id_demande='+id,  // données à envoyer en  GET ou POST , // données à envoyer en  GET ou POST
							
						});
						
					}
					
					poste = [];
					poste2 = [];
					
				});

				
				// Dissociation des postes à la demande
				$("#drop").on("dblclick", "[id^=drag]", function(){
								  
					id_poste = ($(this).attr('id').substring(4));
					$( "#result2 div" ).each(function(index){			
						poste3[index] = $(this).attr("id").substring(4);
					});				
					
					if( $.inArray(id_poste , poste3) == -1 ){
						
						$("#result2").append($(this));
						$(this).removeClass();
						$(this).addClass("vdbvisudrag");
						
					}else{
						
						$(this).remove();
						
					}
					
					poste3 = [];					
					
					$.ajax({
						
						type : 'GET', // envoi des données en GET ou POST
						url : 'demande_ajax5_delete_poste.php' , // url du fichier de traitement
						data : 'id_poste='+id_poste+'&id_demande='+id,  // données à envoyer en  GET ou POST , // données à envoyer en  GET ou POST
							
					});
									
									
				});

				// Masquer/afficher les commentaires details intervention

				$('#reduirecommInter').click(function () {
					$('#tplCommentaire').toggle();
				});

				$('#reduirecommAgent').click(function () {
					$('#comagentall').toggle();
				});
				
				$('#reduireKb').click(function () {
					$('#VisuKb').toggle();
				});


				// AJOUT DE COMMENTAIRES
				$('#ajout_com').click( function(){
					
					com = $('#commentaire').val();
					id = "<?php echo $result2->Technicien_ID_Agent ?>";	
					uid = "<?php echo $_GET['id_demande'] ?>";
					etat = "<?php echo $dmd_obj->Etat_Actuel ?>";
					
					if(com != ""){
					
						$.get('demande_ajax7_ajout_commentaire.php',{commentaire:com,id_dmd:uid,id_technicien:id,etat:etat}, function(data) {

							$('#commentaire').val("");
							$('#tpl').html("");
							$('#tpl').append(data);

						});
					
					}

				});


				// AJOUT DE FICHES KB


				$('#ajout_kb').click( function(){
					
					infos = $('#ajout-nom-kb').val();
					mots_cles = $('#ajout-mot-kb').val();
					
					$('#ajout-nom-kb').val("");
					$('#ajout-mot-kb').val("");

					id = "<?php echo $result2->Technicien_ID_Agent ?>";	
					uid = "<?php echo $_GET['id_demande'] ?>";

					if((infos != "") && (mots_cles != "") && (id_applicatif != "")){
						$('#recherche-kb').val('');
						$.get('demande_ajax9_ajout_kb.php',{infos:infos,mots_cles:mots_cles,id_dmd:uid,id_technicien:id,id_applicatif:id_applicatif}, function(data) {
							//console.log(data);

							$('#tpl_kb').html("");
							$('#tpl_kb').append(data);
						});
					}

				});


				// AFFICHAGE CONTENU KB

				$("body").on("click", "[id^=kb]", function(){

					id_kb = $(this).attr("id").substr(2);
					
					$.ajax({
						type: 'GET',
						url: 'demande_ajax11_affichage_kb.php',
						data: { id: id_kb },
						success: function(data) {
							
							$('#kb' + id_kb).avgrund({
								openOnEvent: false,
								width: 640,
								height: 350,
								template:  data
							});
							
						}
					});
						
				});
								
				// trt save
				 // Fin traitement
			});
					
			
			// Moteur de recherche des Fiches KB
			$('#recherche-kb').keyup( function(){
			  
				$field = $(this);
				$('#ajax-loader').remove(); // on retire le loader

				// on commence à traiter à partir du 2ème caractère saisi
				if( $('#recherche-kb').val().length > 2 ){
				
					// on envoie la valeur recherché en GET au fichier de traitement
					$.ajax({
					
						type : 'GET', // envoi des données en GET ou POST
						url : 'demande_ajax10_recherche_kb.php' , // url du fichier de traitement
						data : 'recherche-kb='+$('#recherche-kb').val() , // données à envoyer en  GET ou POST
						beforeSend : function() { // traitements JS à faire AVANT l'envoi
							$field.after('<img src="img/ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
						},
						success : function(data){ // traitements JS à faire APRES le retour
						
							$('#ajax-loader').remove(); // on enleve le loader
							$('#tpl_kb').html(''); // on vide les resultats
							$('#tpl_kb').html(data); // affichage des résultats dans le bloc
														
										
						}
					});
					
				}
				
				// si pas plus de 2 caractères saisis
				if( $('#recherche-kb').val().length <= 2 ){
					
					$.ajax({
					
						type : 'GET', // envoi des données en GET ou POST
						url : 'demande_ajax8_kb.php' , // url du fichier de traitement
						data : 'id_applicatif='+id_applicatif,
						success : function(data){ // traitements JS à faire APRES le retour
						
							$('#tpl_kb').html(''); // on vide les resultats
							$('#tpl_kb').html(data); // affichage des résultats dans le bloc
				
						}
					});
				
				}
																						  
			});

		</script>


		<script>
				
			
			// Moteur de recherche des postes
			$('#recherche').keyup( function(){
				  
				$field = $(this);
				$('#ajax-loader').remove(); // on retire le loader

				// on commence à traiter à partir du 2ème caractère saisi
				if( $('#recherche').val().length > 2 ){
				
					// on envoie la valeur recherché en GET au fichier de traitement
					$.ajax({
					
						type : 'GET', // envoi des données en GET ou POST
						url : 'demande_ajax6_recherche_poste.php' , // url du fichier de traitement
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
						
		</script>
			
		<script>

		
			// Configuration du datepicker
			$(document).ready(function() {

				
				// Gestion des jours fériés et week-end
				var dateMin = new Date();
				var weekDays = AddWeekDays(0);

				dateMin.setDate(dateMin.getDate() + weekDays);

				var natDays = [
				  [1, 1, 'fr'],
				  [5, 1, 'fr'],
				  [5, 8, 'fr'],
				  [7, 14, 'fr'],
				  [8, 15, 'fr'],
				  [11, 1, 'fr'],
				  [11, 11, 'fr'],
				  [12, 25, 'fr']
				];

				function noWeekendsOrHolidays(date) {
					var noWeekend = $.datepicker.noWeekends(date);
					if (noWeekend[0]) {
						return nationalDays(date);
					} else {
						return noWeekend;
					}
				}
				function nationalDays(date) {
					for (i = 0; i < natDays.length; i++) {
						if (date.getMonth() == natDays[i][0] - 1 && date.getDate() == natDays[i][1]) {
							return [false, natDays[i][2] + '_day'];
						}
					}
					return [true, ''];
				}
				function AddWeekDays(weekDaysToAdd) {
					var daysToAdd = 0
					var mydate = new Date()
					var day = mydate.getDay()
					weekDaysToAdd = weekDaysToAdd - (5 - day)
					if ((5 - day) < weekDaysToAdd || weekDaysToAdd == 1) {
						daysToAdd = (5 - day) + 2 + daysToAdd
					} else { // (5-day) >= weekDaysToAdd
						daysToAdd = (5 - day) + daysToAdd
					}
					while (weekDaysToAdd != 0) {
						var week = weekDaysToAdd - 5
						if (week > 0) {
							daysToAdd = 7 + daysToAdd
							weekDaysToAdd = weekDaysToAdd - 5
						} else { // week < 0
							daysToAdd = (5 + week) + daysToAdd
							weekDaysToAdd = weekDaysToAdd - (5 + week)
						}
					}

					return daysToAdd;
				}

				// Initialisation du datepicker
				$('#Date').datepicker({
					inline: true,
					beforeShowDay: noWeekendsOrHolidays,
					altField: '#txtCollectionDate',
					showOn: "both",
					dateFormat: "yy-mm-dd",
					firstDay: 1,
					changeFirstDay: false,
					minDate: dateMin
				});
			});

		</script>
				
				
		<script type="text/javascript">

			
			// Paramétrage du Slide Menu de planification
			$(function(){
				$('.slide-out-div').tabSlideOut({
					tabHandle: '.handle',                     //class of the element that will become your tab
					pathToTabImage: 'img/contact_tab.gif', //path to the image for the tab //Optionally can be set using css
					imageHeight: '130px',                     //height of tab image           //Optionally can be set using css
					imageWidth: '40px',                       //width of tab image            //Optionally can be set using css
					tabLocation: 'left',                      //side of screen where tab lives, top, right, bottom, or left
					speed: 300,                               //speed of animation
					action: 'click',                          //options: 'click' or 'hover', action to trigger animation
					topPos: '100px',                          //position from the top/ use if tabLocation is left or right
					leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
					fixedPosition: true                      //options: true makes it stick(fixed position) on scroll
				});

			});

			
			// Affichage des interventions déjà prévues à la période sélectionnée dans le Slide Menu de planification
			$("#optionsRadios0, #optionsRadios1, #Date").change(function(){
			
				$("#contentteam").empty();
				date= $("#Date").val();

				date_fr = $.datepicker.formatDate('dd/mm/yy', new Date(date));
				periode= $('input[type=radio][name=radiobutton]:checked').attr('value');

				$("#contentdate").empty();
				$("#contentdate").append(date_fr);
				if(typeof(periode) != "undefined"){
				
					$.ajax({
					
						type : 'POST', // envoi des données en GET ou POST
						url : 'backoffice_ajax.php' , // url du fichier de traitement
						data : 'date='+date+'&periode='+periode , // données à envoyer en  GET ou POST
						beforeSend : function() { // traitements JS à faire AVANT l'envoi
							$("#contentteam").append('<img src="img/ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
						},
						success : function(data){ // traitements JS à faire APRES le retour
							$('#ajax-loader').remove(); // on enleve le loader
							$("#contentteam").append(data);
														
						}
						
					});
				
				}			
						
			});

			
			// Validation de planification du Slide Menu
			$( "#upt_demande" ).click(function(){

				date= $("#Date").val();
				periode= $('input[type=radio][name=radiobutton]:checked').attr('value');		 
				id_demande= "<?php echo $_GET['id_demande'] ?>";	
				id_technicien= "<?php echo $result2->Technicien_ID_Agent ?>";
				
				if(typeof(periode) != "undefined"){
					document.location.href = 'demande_requete_planif_DMD.php?ID_Technicien='+id_technicien+'&ID_Demande='+id_demande+'&periode='+periode+'&date='+date;
				}
				
			});

		</script>

			
		<script>

			
			// Précision du service (affichage du service supérieur dont le lgorga est égal à 4)
			
			// On précise le service lorsqu'on positionne le pointeur dessus
			$( "#service" )
			  .mouseover(function() {
				
				if($("#service").data('lgorga')  >  '4'  ){
				
					id_applicatif = $("#service").data('entorg');
					libelle_service = "<?php echo $dmd_obj->Libelle_Service ?>";

					$.get('demande_ajax12_service.php',{id_applicatif:id_applicatif}, function(data) {

						$('#service').html(data);

					});
					
				}

			  })
			  
			  // On remet le service lorsqu'on quitte la zone
			  .mouseout(function() {
			  
				if($("#service").data('lgorga')  >  '4'  ){
				  
					$('#service').html(libelle_service);

				}
			  });

		</script>

	</body>	
</html>