<?php
session_start();
require "../functions.php";

$idCart = $_SESSION['takeC'];
$connect = connectDB();

$res = getCurrentUser($connect,$_SESSION["mail"]);
$dataUser = $res->fetch();

$resCart = $connect->query("SELECT id_benevole, disponible From panier where id='$idCart'");
$dataCart = $resCart->fetch();

if ($dataCart["id_benevole"] == '0' && $dataCart["disponible"] == "traitement"){

	$queryPrepared = $connect->prepare("UPDATE panier SET id_benevole = :id_benevole, disponible = :disponible where id = '$idCart'");
			$queryPrepared->execute(
				[
					"id_benevole"=>$dataUser["id"],
					"disponible" => "expedie"
				]

			);
	redirect("cartsAvailable.php");
}else{
	$queryPrepared = $connect->prepare("UPDATE panier SET id_benevole = :id_benevole, disponible = :disponible where id = '$idCart'");
			$queryPrepared->execute(
				[
					"id_benevole" => "0",
					"disponible" => "traitement"
				]

			);
	redirect("myPickUpAndDelivery.php");
}