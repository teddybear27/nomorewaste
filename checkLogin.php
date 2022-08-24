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


    if (empty($resultUser) || empty($resultShop) || empty($resultOrg)) {
        $error = true;
        $listOfLoginErrors[] = "Identifiants incorrects";
    }else if ($resultUser["check_mail"] != 1 
           || $resultShop["check_mail"] != 1
           || $resultOrg["check_mail"] != 1
    ){
        $error = true;
        $listOfLoginErrors[] = "Vous n'avez pas encore validé votre email";
    }

    //récupère des valeurs de bdd et les met dans les variables $_SESSION
    else if (password_verify($_POST["pwdLogin"], $resultUser["mdp"])
          || password_verify($_POST["pwdLogin"], $resultShop["mdp"])
          || password_verify($_POST["pwdLogin"], $resultOrg["mdp"])
    ) {
        // vérifie si l'utilisateur est bloqué
        if ($resultUser["blocked"] == 'oui'
         || $resultShop["blocked"] == 'oui'
         || $resultOrg["blocked"] == 'oui') {
            $listOfLoginErrors[] = "Votre compte est bloqué par l'équipe NoMoreWaste. Veuillez contacter l'administrateur pour en connaître les raisons.";
        }

        if ($resultShop["autorisation"] == 'mail non valide'
         || $resultOrg["autorisation"] == 'mail non valide'){
            $error = true;
            $listOfLoginErrors[] = "Votre email doit être validé avant que l'admin valide votre inscription";
        }else if ($resultShop["autorisation"] == 'en attente'
               || $resultOrg["autorisation"] == 'en attente'){
            $error = true;
            $listOfLoginErrors[] = "Votre inscription est en attente de validation par l'administrateur.";
        }
      
    }else{
        $error = true;
        $_SESSION["online"] = 'false';
        $listOfLoginErrors[] = "Identifiants incorrects2";
	  }

    if($error){    
        setcookie("errorForme", serialize($listOfLoginErrors)); 
        header("Location: login.php");
    }else{
        $_SESSION["online"] = 'true';
        if (!empty($resultUser){
            $_SESSION["status"] = $resultUser["status"];
            $error = false;
            if ($_SESSION["status"]  == "admin") {
                redirect("admin/dashboard.php");
            }else{
                redirect("particulier/particulier.php");
            }
        }else if (!empty($resultShop){
            $error = false;
            redirect("commerce/commerce.php");
        }else if (!empty($resultOrg){
            $error = false;
            redirect("association/association.php");
        }
    }

}else{
    $listOfLoginErrors[] = "Vous n'avez pas rempli tous les champs ";
    redirect("login.php");
}
