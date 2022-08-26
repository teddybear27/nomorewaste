<?php
session_start();
require "functions.php";

if (empty($_SESSION['mail'])){
	redirect("denied.php");
}

	$connect = connectDB();
	$adresseElectronique = $_SESSION['mail'];
	$q1 = "DELETE FROM user WHERE mail = '$adresseElectronique'";
	$q2 = "DELETE FROM shop WHERE mail = '$adresseElectronique'";
	$q3 = "DELETE FROM organization WHERE mail = '$adresseElectronique'";

	if ($_SESSION["deleteAccount"] == 2508){
		if ($_SESSION['sid'] == 1 || $_SESSION['sid'] == 2 || $_SESSION['sid'] == 3){
			$res = $connect->query($q1);
		}else if ($_SESSION['sid'] == 4){
			$res = $connect->query($q2);
		}else if ($_SESSION['sid'] == 5){
			$res = $connect->query($q3);
		}
	}

	logout();
	redirect("login.php");
?>