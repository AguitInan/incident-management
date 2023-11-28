<?php

session_name('gi2');
session_start();
//include('tools/cnx_param.php');
include('m_demande.php');

// traitement post 
// On désérialise $_SESSION['Utilisateur'] contenant les données relatives à l'utilisateur
	$result2=unserialize($_SESSION['Utilisateur']);
	$id=$_GET['id_demande'];// On récupère l'ID de la demande
	//$sth=Get_cnx();
	$content="";$poste="";
	$array=Dmd_by_Id($id);$content=($array["content"]);$poste=($array["poste"]);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Demande</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<link rel="shortcut icon" type="images/x-icon" href="" />		
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="bootstrap/css/ui/jquery.ui.all.css" />
		<link rel="stylesheet" media="all" type="text/css" href="bootstrap/css/ui/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox-skin-rounded-black.css"/>
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox.css"/>
		<link href="bootstrap/css/demo_table.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript" src="bootstrap/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>	
		<script type="text/javascript" src="bootstrap/js/modalbox.js"></script>
		<link rel="stylesheet" type="text/css" href="css/base.css">
	</head>

	<body>
		<div class="head">
			<div class="head-nav">
				<div class="menu" style="margin-left:250px;"> 
					<ul>
						<li><a href="#"> Interventions</a></li>
						<li><a href="#">Statistiques</a></li>
						<li><a href="#">Ajouter</a></li>
						<form class="navbar-search pull-left">
						  <input type="text" class="search-query" placeholder="Search">
						</form>
					</ul>
				</div>

			</div>
			<div class="head-container"></div>
		</div>	
	
		
		<div class="container-fluid">
			 <div class="formulaire-content1150">
		  		<div class="row-fluid">
		  			<div class="content-1" style="margin-top:45px;width:100%;height:100%">
		  				<div class="span12 titre-bvs">
		  					<i class="icon-bvs-left icon-arrow-right icon-white"></i>
		  					Demande
		  				</div>
		  		<div class="grid">
					<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
						<thead>
							<tr>
								<th>-</th>
								<th>Date et heure</th>
								<th>Demandeur</th>
								<th>Service</th>
								<th>Type problème</th>
								<th>Technicien</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
							<?php echo($content);?>
							
						</tbody>
					</table>
				<div class="span12 titre-bvs">
		  					<i class="icon-bvs-left icon-arrow-right icon-white"></i>
		  					Poste(s)
		  				</div>
						<table class="table" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
							<thead>
								<tr>											
									<th>VDB</th>
									<th>Compte_WIN</th>
									<th>IP_MAC</th>
								</tr>
							</thead>
								<tbody>
									<?php echo($poste); ?>
								</tbody>
						</table>
				<div class="span12 titre-bvs">
		  					<i class="icon-bvs-left icon-arrow-right icon-white"></i>
		  					Commentaire(s) détails de l'intervention
		  				</div>
  				</div> <!-- div Class grid -->
			<!-- Template des commentaires -->
					 <div id='tpl'>
						{{#com}}
						<div class='stage'>
							<div class="span8" style="font-weight:bold;">
								{{ID_Agent}} de :{{Nom}} {{Prenom}} le: {{Date}}
							</div>
							<div class="span7 offset1" style="background-color:#fafafa;">
								<p class='mid'>{{Commentaire}}</p>
							</div>
						   
						</div>
						{{/com}}
					  </div>

					  <div  id="testa">
					  	testa
					  </div>
		
		  </div><!-- div Class content1 -->
		  </div><!-- div Class row fluid -->
		  </div><!-- div Class grid -->
		</div><!-- div Class container Fluid-->
		<?php
			// Si la demande n'est pas déjà prise en compte par un technicien, on affiche un bouton pour permettre de la prendre en compte
			if((isset($technicien)) && ($technicien == "0") ){

				echo '<button id="modal_demande" align="right" type="button" class="btn btn-primary">Prendre en compte</button> ';

			}

		?>
			
		<a href="index.php" id="bouton3" class="btn">Retour</a>


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
			var _noeud;

				id = "<?php echo $id ?>";
			  $.get('commentaire.php',{ identifiant : id}, function(data){
			  console.log(data);
				  $('#tpl').html(Mustache.render($('#tpl').html(), {com : data} ));
				  $('#tpl').css({"display":"inherit"});
			  },'json');

			  // Traitement du lock unlock des inputs
			  		//trt edit
			  	 $('[id^=edit]').click(function(){
			  	 	var _type_element;
			  	 	//var _value[];
			  	 	var _id=$(this).attr('id');_id=_id.substring(4,_id.length);

			  	 	var i = $(this).closest('tr');
			  	 	

			  	 	$(this).closest('tr').find('input').each(function() {

			  	 		
			  	 		if($(this).data('type')=="listbox")
			  	 		{
			  	 			$(this).replaceWith('<select class="bvs-select"><option>culture</option><option>Informatique</option><select>', function(){});
						}	
			  	 	});

			  	 	$("input[name$="+_id+"]").removeClass('bvs-input-lock');
			  	 	$("input[name$="+_id+"]").addClass('bvs-input-unlock');
			  	 	$("input[name$="+_id+"]").removeAttr('readonly');
			  	 	$('[id^=sav'+_id+']').css("color","#99B433");
			  	 	});

			  	 // trt save
			  	 $('[id^=sav]').click(function(){
			  	 	$(this).closest('tr').find('input').each(function() {
	  	 			$(this).replaceWith(_noeud, function(){});
	
			  	 	});


			  	 	var _id=$(this).attr('id');_id=_id.substring(3,_id.length);
			  	 	$(this).css("color","transparent");
			  	 	$("input[name$="+_id+"]").removeClass('bvs-input-unlock');
			  	 	$("input[name$="+_id+"]").addClass('bvs-input-lock');
			  	 	$("input[name$="+_id+"]").attr('readonly', 'readonly');
			  	 	});

			  // Fin traitement



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
				testDirectCall_Source_update_demande(id_technicien, id_demande);
				
			});
				
		</script>

	</body>
	
</html>