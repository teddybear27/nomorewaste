<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 5){
  redirect("../denied.php");
}

$connect = connectDB();
$idCart = $_SESSION["moreInfosC"];
$res = $connect->query("SELECT * from panier where id='$idCart'");
$data=$res->fetch();

$resUser = getCurrentUser($connect,$_SESSION["mail"]);
$dataUser = $resUser->fetch();
$idUser = $dataUser["id"];
echo($idUser);
echo($idCart);

$dateTransaction = date("Y-m-d H:i:s");

$queryPrepared = $connect->prepare("INSERT INTO panier (nom, description, etat, date_consommation, acteur, id_acteur, id_benevole, quantite_total, date_transaction, disponible) VALUES (:nom, :description, :etat, :date_consommation, :acteur, :id_acteur, :id_benevole, :quantite_total, :date_transaction, :disponible)");


    $queryPrepared->execute(
      [
        "nom"=>$data["nom"],
        "description"=>$data["description"],
        "etat"=>"livraison",
        "date_consommation" => $data["date_consommation"],
        "acteur" => "Association",
        "id_acteur" => $idUser,
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