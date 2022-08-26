<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 1){
  redirect("../denied.php");
}

	$connect = connectDB();
	$adresseElectronique = $_POST['deleteS'];
	$q = "DELETE FROM shop WHERE mail = '$adresseElectronique'";
	$res = $connect->query($q);
	redirect("commerces.php");
?>