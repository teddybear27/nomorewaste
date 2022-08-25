<?php
session_start();
require "functions.php"

if (empty($_SESSION['mail'])){
	redirect("denied.php");
}

	$connect = connectDB();
	$adresseElectronique = $_POST['deleteP'];
	$q = "DELETE FROM user WHERE mail = '$adresseElectronique'";
	$res = $connect->query($q);
	redirect("particuliers.php");
?>