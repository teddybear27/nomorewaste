<?php
session_start();
require "../functions.php";

$idCart = $_SESSION['arrivalC'];
$connect = connectDB();



	$queryPrepared = $connect->prepare("UPDATE panier SET disponible = :disponible where id = '$idCart'");
			$queryPrepared->execute(
				[
					"disponible" => "arrivee"
				]

			);
	redirect("myPickUpAndDelivery.php");
