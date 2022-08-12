<?php
session_start();
require "functions.php";


if(!empty($_POST["emailLogin"]) && !empty($_POST["pwdLogin"])) {
      $email = htmlspecialchars($_POST["emailLogin"]);
      $pwd   = htmlspecialchars($_POST["pwdLogin"]);

      $connect = connectDB();
      //Prepare la requête pour éviter les injections SQL
   		$queryPrepared = $connect->prepare("SELECT status, mdp, check_mail, blocked FROM user WHERE mail = :mail");

   		$queryPrepared->execute(["mail"=>$email]);
      $result = $queryPrepared->fetch();
      if (empty($result)) {
        echo "Identifiants incorrects";
      }else if ($result["check_mail"] != 1){
        echo("Vous n'avez pas encore validé votre email");
      }

      //récupère des valeurs de bdd et les met dans les variables $_SESSION
      else if (password_verify($_POST["pwdLogin"], $result["mdp"])) {
        // vérifie si l'utilisateur est bloqué
        /*if ($result["blocked"] == 'oui') {
          redirect("profile/blocked.php");
        }*/
          $_SESSION["online"] = 'true';
          $_SESSION["user"] = $result["id"];          

          /*if ($result["status"]  == "admin") {
            redirect("admin/admin.php");
          }*/

				//$_SESSION["token"] = createToken($_POST["emailLogin"]);

        header("Location: index.php");
      }else{
        $_SESSION["online"] = 'false';
        echo "Identifiants incorrects2";
		  }
      
}else{
    echo "Vous n'avez pas rempli tous les champs ";
}
