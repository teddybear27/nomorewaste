<?php
session_start();
require '../functions.php';
$connect = connectDB();

// http://nomorewaste.online/mail/verifyMailShop.php?code_verif=4cb630bcb306121a42af6fb9ea32dac8

if(!empty($_GET['code_verif'])) {
  $codeVerif = htmlspecialchars($_GET['code_verif']);
  //Verifier la validité de la clé
  $q = "SELECT mail FROM shop WHERE check_mail = '$codeVerif'";
  $verif = $connect->query($q)->fetch();
  if ($verif != false) {

    // Modifier la colonne check_mail à 1 pour finaliser le compte
    $q = "UPDATE shop SET check_mail = '1' WHERE mail = :mail";
    $req = $connect->prepare($q);
    $req->execute(["mail" => $verif[0]]);
    $_SESSION["errors"] = ["Votre compte a bien été validé"];
    header("Location: ../login.php");
    exit();
  }
}
