<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 1){
  redirect("../denied.php");
}

	$connect = connectDB();
	$adresseElectronique = $_POST['deleteP'];
	$q = "DELETE FROM user WHERE mail = '$adresseElectronique'";
	$res = $connect->query($q);
	redirect("particuliers.php");
?>