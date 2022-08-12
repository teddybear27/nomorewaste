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
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
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
							</div>
							<div class="form-row">
									<div class="form-holder">
											<input type="submit" class="form-control" name="valider">
									</div>
								</div>
			            </section>
									</div>
								</div>
							</div>
			            </section>
		        	</div>
		        </form>
<?php
if (!empty($_SESSION["errors"])) {
	echo ($_SESSION["errors"]);
}
?>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>