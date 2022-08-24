<?php
session_start();
require '../functions.php';
$connect = connectDB();

// http://nomorewaste.online/mail/verifyMailOrganization.php?code_verif=4cb630bcb306121a42af6fb9ea32dac8

if(!empty($_GET['code_verif'])) {
  $codeVerif = htmlspecialchars($_GET['code_verif']);
  //Verifier la validité de la clé
  $q = "SELECT mail FROM organization WHERE check_mail = '$codeVerif'";
  $verif = $connect->query($q)->fetch();
  if ($verif != false) {

    // Modifier la colonne check_mail à 1 pour finaliser le compte
    $q = "UPDATE organization SET check_mail = '1', autorisation = 'en attente' WHERE mail = :mail";
    $req = $connect->prepare($q);
    $req->execute(["mail" => $verif[0]]);

// Envoi un mail à l'admin pour l'informer de la validation du compte
    $to = "cheikh.kane@nomorewaste.online";
    $subject = "NoMoreWaste : Accusé de réception - Validation email d'une association";
    $message = "L'adresse email ".$verif[0]." a bien été validée.\n ";
    $message .= "Cette association n'attend que votre accord pour accéder à son compte.\r\n";
    $header="MIME-Version: 1.0\r\n";
    $header.='Content-Type:text/html; charset="uft-8"'."\r\n";
    $header.='Content-Transfer-Encoding: 8bit'."\r\n";
    $header .= 'From: <'.$verif[0].'>' . "\r\n";
    mail($to,$subject,$message,$header);



    $_SESSION["errors"] = ["Votre compte a bien été validé"];
    header("Location: ../login.php");
    exit();
  }
}
