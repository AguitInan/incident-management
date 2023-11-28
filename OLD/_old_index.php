<?php

session_name('gi2');
session_start();
 

require '/tools/helper.php';
require '/tools/fonctions_mySQL.php';
require '/bo/cl_ConnectedUser.php';

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Authentification GI2</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		
		<script type="text/javascript" src="bootstrap/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		
		<style>
		input{height:25px};
		</style>
		
	</head>
	<body>

		

		<div class="container-fluid">
		  <div class="row-fluid">
			<div class="span10">
			
			<div>
				<p>
					<?php
						include("/tools/fonction_ntlm.php");
						$result = ntlm_login();
						
					try
					{
						// Connexion à la base de données
						$connexion = Get_cnx();
						$req = 'SELECT * FROM Agent A JOIN Technicien B ON A.ID_Agent=B.Technicien_ID_Agent WHERE Login = "'.$result->Getuser().'"';
						$st = $connexion->query($req);
						$donnees = $st->fetch( PDO::FETCH_OBJ);
						
						// On vérifie la session de l'utilisateur pour le logger automatiquement
						if($donnees == FALSE){
							// L'utilisateur n'est pas sur sa session, on lui affiche donc le formulaire d'authentification
							echo 'Session inconnue, veuillez vous identifier';
							
							echo $_POST['Login'];
							
							// Formulaire d'authentification
							HlpForm::Start(array('url' =>'accueil.php','action'=>'post','titre'=>'Gestionnaire des Interventions - Authentification'));
							HlpForm::Input('Login');
							HlpForm::Inputpwd('Password');
							HlpForm::Submit();
							
						}else{
							// Si l'utilisateur est connecté sur sa session alors on le loggue automatiquement et on le redirige sur la page accueil.php
							$_SESSION['ConnectedUser'] = serialize($result);
							$_SESSION['Utilisateur'] = serialize($donnees);
							
							header('Location: accueil.php');
						}
						
					}
					catch(Exception $f)
					{
						echo 'err : '.$f->getMessage().'<br />';
					}
							
					
					?>
				</p>
			</div>
			
			</div>
		  </div>
		</div>
		

						
		<div class="footer-content">
			<div class="footer-text">
				Mairie de Beauvais - communauté d'agglomération du Beauvaisis
			</div>	
		</div>
	</body>
</html>