<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 1){
  redirect("../denied.php");
}

	$connect = connectDB();
	$adresseElectronique = $_SESSION['deleteO'];
	$q = "DELETE FROM organization WHERE mail = '$adresseElectronique'";
	$res = $connect->query($q);
	redirect("associations.php");
?>