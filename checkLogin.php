<?php
session_start();
require "functions.php";

var_dump($_POST);
if(!empty($_POST["emailLogin"]) && !empty($_POST["pwdLogin"])) {
      //Nettoyage
      $_POST["emailLogin"] = strtolower(trim($_POST["emailLogin"]));
      $email = htmlspecialchars($_POST["emailLogin"]);
      $pwd   = htmlspecialchars($_POST["pwdLogin"]);

      $listOfLoginErrors = [];

      $connect = connectDB();
      //Prepare la requête pour éviter les injections SQL
   		$queryPrepared = $connect->prepare("SELECT status, mdp, check_mail, blocked FROM user WHERE mail = :mail");

   		$queryPrepared->execute(["mail"=>$email]);
      $result = $queryPrepared->fetch();
      if (empty($result)) {
        $listOfLoginErrors[] = "Identifiants incorrects";
        redirect("login.php");
      }else if ($result["check_mail"] != 1){
        $listOfLoginErrors[] = "Vous n'avez pas encore validé votre email";
        redirect("login.php");
      }

      //récupère des valeurs de bdd et les met dans les variables $_SESSION
      else if (password_verify($_POST["pwdLogin"], $result["mdp"])) {
        // vérifie si l'utilisateur est bloqué
        /*if ($result["blocked"] == 'oui') {
          redirect("profile/blocked.php");
        }*/
          $_SESSION["online"] = 'true';
          $_SESSION["status"] = $result["status"];          

          /*if ($result["status"]  == "admin") {
            redirect("admin/admin.php");
          }*/

				//$_SESSION["token"] = createToken($_POST["emailLogin"]);
        $listOfLoginErrors[] = "Connexion reussie";
        header("Location: login.php");
      }else{
        $_SESSION["online"] = 'false';
        $listOfLoginErrors[] = "Identifiants incorrects2";
        redirect("login.php");
		  }

}else{
    $listOfLoginErrors[] = "Vous n'avez pas rempli tous les champs ";
    redirect("login.php");
}
