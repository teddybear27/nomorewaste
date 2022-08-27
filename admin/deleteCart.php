<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 1){
  redirect("../denied.php");
}

	$connect = connectDB();
	$idCart = $_POST['deleteC'];
	$q = "DELETE FROM panier WHERE id = '$idCart'";
	$res = $connect->query($q);
	redirect("paniers.php");
?>