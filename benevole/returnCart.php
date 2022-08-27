<?php
session_start();
require "../functions.php";

$idCart = $_SESSION['returnC'];
$connect = connectDB();

$queryPrepared = $connect->prepare("UPDATE panier SET id_benevole = :id_benevole, disponible = :disponible where id = '$idCart'");
		$queryPrepared->execute(
			[
				"id_benevole" => "0",
				"disponible" => "traitement"
			]

		);
redirect("myPickUpAndDelivery.php");
