<?php
session_start();
require "functions.php";

logout();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Page de déconnexion</title>
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
				<p>Vous avez été déconnecté.</p>
				<p>Cliquez sur le lien suivant pour accéder à la <a href="login.php">page de connexion</a>.
				</p>
			</div>
		</div>
	</div>
</body>
</html>