<?php
session_start();
require "../functions.php";

$idCart = $_SESSION['takeC'];
$connect = connectDB();

$res = getCurrentUser($connect,$_SESSION["mail"]);
$dataUser = $res->fetch();

$queryPrepared = $connect->prepare("UPDATE panier SET id_benevole = :id_benevole, disponible = :disponible where id = '$idCart'");
		$queryPrepared->execute(
			[
				"id_benevole"=>$dataUser["id"],
				"disponible" => "expedie"
			]

		);
redirect("cartsAvailable.php");
