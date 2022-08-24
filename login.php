<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>No More Waste - Connexion</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
	<header>
		<div>
			<a href="index.php"><img id="logo" src="assets/img/logo.png"></a>
		</div>
	</header>
	<div class="page-content">		
		<div class="form-v1-content">
			<div class="wizard-form">
		        <form class="form-register" action="checkLogin.php" method="post">
		        	<div id="form-total">
		        		<!-- SECTION 1 -->
		        		<h2>
			            	<span class="step-text">Informations de connexion</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Connexion</h3>
									<p>Veuillez vous connecter pour continuer</p>
									<p>Vous n'avez pas encore de compte ?
										<a href="index.php">Inscrivez-vous</a>
									</p>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Votre Email</legend>
											<input type="text" name="emailLogin" id="emailLogin" class="form-control" placeholder="example@email.com" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Mot de Passe</legend>
											<input type="password" class="form-control" id="pwdLogin" name="pwdLogin" placeholder="Mot de passe" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<input type="submit" id="valider" value="Soumettre">
									</div>
								</div>
							</div>
			            </section>
					</div>
				</form>
<?php
		if( !empty( $_COOKIE['errorForme'])){
?>
			<ul>
<?php
			$listOfLoginErrors = unserialize($_COOKIE['errorForme']);
			foreach ($listOfLoginErrors as $error) {
?>
				<li>
<?php
				echo($error);
				setcookie('errorForme','');
			}
?>
			</ul>
<?php

		}

?>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/main.js"></script>
</body>
</html>