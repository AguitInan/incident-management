<?php
require '/tools/helper.php';
require '/tools/cnx_param.php';
require '/bo/cl_ConnectedUser.php';
?>

<!DOCTYPE html>
<html>
	<head>
	
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<title>Authentification</title>
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/ui/jquery.ui.all.css" />
		<link href="bootstrap/css/demo_table.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/base.css">
		
		
	</head>
	
	<?php
		if (isset($_POST["Login"])) { $login = $_POST["Login"];}
		if (isset($_POST["Password"])) { $password = md5($_POST["Password"]);}
		if (isset($_GET["error"])) { $error = "<p style='float:left;font-size:1em;font-weight:bold;color:#FF9900;'><img src='./img/status_pb.png' alt='Erreur'> Erreur de connexion.</p>";} else { $error="";}
	?>
	<br>
		
	<?php
		
		
		// Traitement du formulaire d'authentification
		if ( (isset($login)) && (isset($password)) ) {

				try
				{
				
					$sth=Get_cnx();
					
					$req = 'SELECT * FROM Agent A JOIN Technicien B ON A.ID_Agent=B.Technicien_ID_Agent WHERE Login = "'.$login.'" AND Password = "'.$password.'"';
					$st = $sth->query($req);
					$donnees = $st->fetch( PDO::FETCH_OBJ);
					
					// On vérifie le Login et le Mot de passe
					if($donnees !== FALSE){
						
						session_name("gi2");
						session_start();
						
						if( isset ($_POST['Login'])){
							$_SESSION['Login'] = $_POST['Login'];
						}

						if( isset ($_POST['Password'])){

							$_SESSION['Password'] = md5($_POST["Password"]);
						}
						$_SESSION['Utilisateur'] = serialize($donnees);
						
						header("Location:index.php");	// on redirige vers l'index
						
					}else {
						header("Location:?error=y");	// sinon on retourne sur la page login avec un msg d'erreur basique
					}
					
				}
				catch(Exception $f)
				{
					echo 'err : '.$f->getMessage().'<br />';
				}
				
		}
	
	
	// Partie authentification automatique
	
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
			if($donnees !== FALSE){
			
				session_name("gi2");
				session_start();
			
				// Si l'utilisateur est connecté sur sa session alors on le loggue automatiquement et on le redirige sur la page accueil.php
				$_SESSION['ConnectedUser'] = serialize($result);
				$_SESSION['Utilisateur'] = serialize($donnees);
				
				header('Location: index.php');
			}
			
		}
		catch(Exception $f)
		{
			echo 'err : '.$f->getMessage().'<br />';
		}

	?>
	
	<body>


		
		<div class="head">
			<div class="head-nav">
				<div class="head-img" style="float:left">
					<img src="img/logo.png">
				</div>
				<div class="connex">

					
				</div>
			</div>
			<div class="head-container">
				
			</div>
			<div class="head-end">
				<div class="head-container-menu">
					<div class="row-fluid">
						<div class="span2">
							
						</div>
						<div class="span2">
						
						</div>
						<div class="span5">
							
						</div>
					</div>						
				</div>		
			</div>			
		</div>


		

					
					
		<div class="container-fluid">
		  <div class="row-fluid">
			<div class="offset4">
			
				<div>
					<p>
						<?php
						
							// L'utilisateur n'est pas sur sa session, on lui affiche donc le formulaire d'authentification
							echo 'Session inconnue, veuillez vous identifier';
							
							// Formulaire d'authentification
							HlpForm::Start(array('url' =>'login.php','action'=>'post','titre'=>'Gestionnaire des Interventions - Authentification'));
							HlpForm::Input('Login');
							HlpForm::Inputpwd('Password');
							HlpForm::Submit();
									
						?>
					</p>
				</div>
			
			</div>
		  </div>
		</div>
		
		<?php
			echo $error;
		?>

	</body>
	
</html>