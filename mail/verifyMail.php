<?php
session_start();
require '../functions.php';
$connect = connectDB();

// http://localhost/mail/verifyMail.php?code_verif=4cb630bcb306121a42af6fb9ea32dac8

if(!empty($_GET['code_verif'])) {
  $codeVerif = htmlspecialchars($_GET['code_verif']);
  //Verifier la validité de la clé
  $q = "SELECT mail FROM user WHERE check_mail = '$codeVerif'";
  $verif = $connect->query($q)->fetch();
  if ($verif != false) {

    // Modifier la colonne check_mail à 1 pour finaliser le compte
    $q = "UPDATE user SET check_mail = '1' WHERE mail = '$verif[0]'";
    $connect->query($q);
    $_SESSION["errors"] = ["Votre compte a bien été validé"];
    //header("Location: ../connexion.php");
    exit();
  }echo "hello";
}echo "hello2";
