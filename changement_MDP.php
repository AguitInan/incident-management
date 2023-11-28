<?php
include('/inc/header.php');

$result2=unserialize($_SESSION['Utilisateur']);

?>
		<title>Changement du mot de passe</title>

	</head>

	<body>

		<?php include('/inc/menu.php'); ?>

		<?php
			HlpForm::Start(array('url' =>'changement_MDP_requete.php','action'=>'post','titre'=>'Changement de mot de passe'));						
		?>		
			
		<label for="password">Mot de passe actuel :</label>
		<input name="password" type="password" id="password" onBlur="MdpVerifXHR(this)">

		<label for="password">Nouveau Mot de passe :</label>
		<input name="nouveau" type="password" id="nouveau" onBlur="confirmation()">

		<label for="password">Confirmation Mot de passe :</label>
		<input name="verif" type="password" id="verif" onBlur="confirmation()">
			
		<input name="ID_Technicien" type="hidden" id="ID_Technicien" value="<?php echo $result2->Technicien_ID_Agent ?>">
		<input name="Mail" type="hidden" id="Mail" value="<?php echo $result2->Mail ?>">

		<?php		
			HlpForm::Submit();
		?>
		
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.10.3.custom.min.js"></script>
		
		<script>

			// On masque le bouton Submit
			$("input:submit").hide();

			
			// Fonction Ajax qui permet de vérifier si le mot de passe est correct
			function MdpVerifXHR(Amdp)
			{

				var xhr = new XMLHttpRequest();
				
				if(window.XMLHttpRequest || window.ActiveXObject) {
						if(window.XMLHttpRequest) {
								xhr = new XMLHttpRequest();
						}
						else {
								try {
										xhr = new ActiveXObject("Msxml2.XMLHTTP");
								} catch(e) {
										xhr = new ActiveXObject("Microsoft.XMLHTTP");
								}
						}
				}
				xhr.onreadystatechange = function()
				{
						if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
						{
						
							if (xhr.responseText == "false")
							{
								Amdp.style.borderStyle = 'solid';
								Amdp.style.borderColor = 'red';
								
								$("input:submit").hide();
							}
							else if (xhr.responseText == "true")
							{
								Amdp.style.borderStyle = 'solid';
								Amdp.style.borderColor = 'green';
								
								if($('#nouveau').css('borderTopColor') == "rgb(0, 128, 0)"){
					
									$("input:submit").show();
					
								}
							}else{
							
								Amdp.style.borderStyle = '';
								Amdp.style.borderColor = '';
								
								$("input:submit").hide();
							}
		 
						}
				}
				 
				var mdp = password.value;
				xhr.open("GET", "changement_MDP_ajax_verification.php?mot_de_passe="+ mdp +"", true);
				xhr.send(null);

					 
			}

			// Fonction Ajax qui permet de vérifier si la confirmation du nouveau mot de passe est correcte
			function confirmation()
			{

				nouveau = $('#nouveau').val();
				verif = $('#verif').val();


				if((nouveau != "") && (verif != "")){

					if(nouveau == verif){

						$('#nouveau').css({
						
							borderColor : 'green', // couleur verte
							borderStyle : 'bold' // bordure en gras

						});
											
						$('#verif').css({
						
							borderColor : 'green', // couleur verte
							borderStyle : 'bold' // bordure en gras

						});
					
						if($('#password').css('borderTopColor') == "rgb(0, 128, 0)"){
						
							$("input:submit").show();
							
						}

					}else{

						$('#nouveau').css({
						
							borderColor : 'red', // couleur rouge
							borderStyle : 'bold' // bordure en gras

						});
											
						$('#verif').css({
						
							borderColor : 'red', // couleur rouge
							borderStyle : 'bold' // bordure en gras

						});
						
						$("input:submit").hide();

					}

				}else{

					$('#nouveau').css({
					
						borderColor : '',
						borderStyle : ''

					});
										
					$('#verif').css({
					
						borderColor : '',
						borderStyle : ''
											
					});
					
					$("input:submit").hide();

				}

			}

		</script>

	</body>
</html>