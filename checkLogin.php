<?php
session_start();
require "functions.php";

if(!empty($_POST["emailLogin"]) && !empty($_POST["pwdLogin"])) {
    //Nettoyage
    $_POST["emailLogin"] = strtolower(trim($_POST["emailLogin"]));
    $email = htmlspecialchars($_POST["emailLogin"]);
    $pwd   = htmlspecialchars($_POST["pwdLogin"]);

    $listOfLoginErrors = [];

    $connect = connectDB();

    //Prepare la requête pour éviter les injections SQL
    $queryUser = $connect->prepare("SELECT status, mdp, check_mail, blocked, online FROM user WHERE mail = :mail");
 		$queryShop = $connect->prepare("SELECT mdp, check_mail, blocked, online, autorisation FROM shop WHERE mail = :mail");
    $queryOrg = $connect->prepare("SELECT mdp, check_mail, blocked, online, autorisation FROM organization WHERE mail = :mail");


 		$queryUser->execute(["mail"=>$email]);
    $queryShop->execute(["mail"=>$email]);
    $queryOrg->execute(["mail"=>$email]);


    $resultUser = $queryUser->fetch();
    $resultShop = $queryShop->fetch();
    $resultOrg = $queryOrg->fetch();

    $acteur = 'nobody';

    // Conditions connexion User, Shop, Organization
    if (!empty($resultUser)){
      if ($resultUser["check_mail"] != 1){
        $error = true;
        $listOfLoginErrors[] = "Vous n'avez pas encore validé votre email";
      }else{
        if (password_verify($_POST["pwdLogin"], $resultUser["mdp"])){
          if ($resultUser["blocked"] == 'oui'){
            $error = true;
            $listOfLoginErrors[] = "Votre compte est bloqué par l'équipe NoMoreWaste. Veuillez contacter l'administrateur pour en connaître les raisons.";
          }else{
            $error = false;
            $acteur = 'user';
          }
        }else{
          $error = true;
          $listOfLoginErrors[] = "Identifiants incorrects";
        }
      }
    }else if (!empty($resultShop)){
      if ($resultShop["check_mail"] != 1){
        $error = true;
        $listOfLoginErrors[] = "Vous n'avez pas encore validé votre email";
      }else{
        if (password_verify($_POST["pwdLogin"], $resultShop["mdp"])){
          if ($resultShop["blocked"] == 'oui'){
            $error = true;
            $listOfLoginErrors[] = "Votre compte est bloqué par l'équipe NoMoreWaste. Veuillez contacter l'administrateur pour en connaître les raisons.";
          }
          if ($resultShop["autorisation"] == 'mail non valide'){
            $error = true;
            $listOfLoginErrors[] = "Votre email doit être validé avant que l'admin valide votre inscription";
          }else if ($resultShop["autorisation"] == 'en attente'){
            $error = true;
            $listOfLoginErrors[] = "Votre inscription est en attente de validation par l'administrateur";
          }else if ($resultShop["autorisation"] == 'refusee'){
            $error = true;
            $listOfLoginErrors[] = "Votre inscription est refusée par l'administrateur. Veuillez contacter l'équipe NoMoreWaste pour en savoir plus";
          }else{
            $error = false;
            $acteur = 'shop';
          }
        }else{
          $error = true;
          $listOfLoginErrors[] = "Identifiants incorrects";
        }
      }
    }else if (!empty($resultOrg)){
      if ($resultOrg["check_mail"] != 1){
        $error = true;
        $listOfLoginErrors[] = "Vous n'avez pas encore validé votre email";
      }else{
        if (password_verify($_POST["pwdLogin"], $resultOrg["mdp"])){
          if ($resultOrg["blocked"] == 'oui'){
            $error = true;
            $listOfLoginErrors[] = "Votre compte est bloqué par l'équipe NoMoreWaste. Veuillez contacter l'administrateur pour en connaître les raisons.";
          }
          if ($resultOrg["autorisation"] == 'mail non valide'){
            $error = true;
            $listOfLoginErrors[] = "Votre email doit être validé avant que l'admin valide votre inscription";
          }else if ($resultOrg["autorisation"] == 'en attente'){
            $error = true;
            $listOfLoginErrors[] = "Votre inscription est en attente de validation par l'administrateur";
          }else if ($resultOrg["autorisation"] == 'refusee'){
            $error = true;
            $listOfLoginErrors[] = "Votre inscription est refusée par l'administrateur. Veuillez contacter l'équipe NoMoreWaste pour en savoir plus";
          }else{
            $error = false;
            $acteur = 'organization';
          }
        }else{
          $error = true;
          $listOfLoginErrors[] = "Identifiants incorrects";
        }
      }
    }

    if($error){    
        setcookie("errorForme", serialize($listOfLoginErrors)); 
        header("Location: login.php");
    }else{
        $_SESSION["online"] = 'true';
        if ($acteur == 'user'){
            $_SESSION["status"] = $resultUser["status"];
            $error = false;
            if ($_SESSION["status"]  == "admin") {
                redirect("admin/dashboard.php");
            }else{
                redirect("particulier/particulier.php");
            }
        }else if ($acteur == 'shop'){
            redirect("commerce/commerce.php");
        }else if ($acteur == 'organization'){
            redirect("association/association.php");
        }
    }

}else{
    $listOfLoginErrors[] = "Vous n'avez pas rempli tous les champs ";
    redirect("login.php");
}
