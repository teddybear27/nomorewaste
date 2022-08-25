<?php
session_start();
require "fonctions.php";

if (empty($_SESSION['mail'])){
	redirect("denied.php");
}

if ($_SESSION["sid"] == 1){
	$connect = connectDB();
	$q = "SELECT mail FROM user WHERE status = 'admin'";
	$res = $connect->query($q);
	$i = 0;
	while ($res->fetch()) {
		$i += 1;
	}

	$_SESSION['deleteAccount'] = 2508;
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete Account</title>
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
<?php
	if ($i < 2){
?>
				<p>Vous ne pouvez pas supprimer votre compte puisque vous êtes le seul adminisatrteur qui existe en ce moment</p>
<?php
	}else{
?>
				<p>Etes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
				<p>Cliquez sur le lien suivant pour <a href="supDefinitive.php" style="color:red">supprimer définitivement votre compte</a>.
				</p>
				<p>Sinon faites précédent pour revenir à la page précédente.</p>
<?php
	}
}else{
?>
				<p>Etes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
				<p>Cliquez sur le lien suivant pour <a href="supDefinitive.php" style="color:red">supprimer définitivement votre compte</a>.
				</p>
				<p>Sinon faites précédent pour revenir à la page précédente.</p>
<?php
}
?>
			</div>
		</div>
	</div>
</body>
</html>