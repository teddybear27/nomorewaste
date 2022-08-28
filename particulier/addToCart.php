<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 2){
  redirect("../denied.php");
}

$connect = connectDB();
$idCart = $_SESSION["moreInfosC"];
$res = $connect->query("SELECT * from panier where id='$idCart'");
$data=$res->fetch();

$resUser = getCurrentUser($connect,$_SESSION["mail"]);
$dataUser = $resUser->fetch();

$dateTransaction = date("Y-m-d H:i:s");

$queryPrepared = $connect->prepare("INSERT INTO panier (panier_origine, nom, description, etat, date_consommation, acteur, id_acteur, id_benevole, quantite_total, date_transaction, disponible) VALUES (:panier_origine, :nom, :description, :etat, :date_consommation, :acteur, :id_acteur, :id_benevole, :quantite_total, :date_transaction, :disponible)");


    $queryPrepared->execute(
      [
        "panier_origine" => $idCart,
        "nom"=>$data["nom"],
        "description"=>$data["description"],
        "etat"=>"livraison",
        "date_consommation" => $data["date_consommation"],
        "acteur" => "Association",
        "id_acteur" => $dataUser["id"],
        "id_benevole"=>"0",
        "quantite_total" => $data["quantite_total"],
        "date_transaction" => $dateTransaction,
        "disponible" => "traitement"
      ]

    );

$queryPrep = $connect->prepare("UPDATE panier SET disponible = :disponible where id = '$idCart'");
  $queryPrep->execute(
    [
      "disponible" => "commandee"
    ]

  );

redirect("orderCarts.php");