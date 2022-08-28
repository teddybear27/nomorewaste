<?php
session_start();
require "../functions.php";

$idCart = $_SESSION['returnC'];
$connect = connectDB();

$resIdOldCart = $connect->query("SELECT * from panier where id='$idCart'");
$dataIdOldCart = $resIdOldCart->fetch();
$idOldCart = $dataIdOldCart["panier_origine"];


$queryPrepared = $connect->prepare("UPDATE panier SET disponible = :disponible where id = '$idOldCart'");
		$queryPrepared->execute(
			[
				"disponible" => "arrivee"
			]
		);

$queryDrop = $connect->query("DELETE FROM panier WHERE id = '$idCart'");

redirect("cartsInProgress.php");
