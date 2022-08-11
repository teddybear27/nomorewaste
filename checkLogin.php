<?php
session_start();
require "functions.php";


if(!empty($_POST["email"]) && !empty($_POST["pwd"])) {
      $email = htmlspecialchars($_POST["email"]);
      $pwd   = htmlspecialchars($_POST["pwd"]);

      $connect = connectDB();
      //Prepare la requête pour éviter les injections SQL
   		$queryPrepared = $connect->prepare("SELECT id, pwd, blocked, connected FROM user WHERE mail = :mail AND check_mail = 1");

   		$queryPrepared->execute(["mail"=>$_POST["mail"]]);
        $result = $queryPrepared->fetch();
        if (empty($result)) {
          echo "Identifiants incorrects";
        }

        //récupère des valeurs de bdd et les met dans les variables $_SESSION
        else if (password_verify($_POST["pwd"], $result["pwd"])) {
          // vérifie si l'utilisateur est bloqué
          if ($result["blocked"] == 'oui') {
            redirect("profile/blocked.php");
          }
            $_SESSION["online"] = 'true';
            $_SESSION["user"] = $result["id"];
      
            $q = $connect->prepare("UPDATE users SET connected='true' WHERE id = :id");
            $q->execute(["id"=>$_SESSION["user"]]);            

            if ($result["id"]  == 1) {
              redirect("admin/admin.php");
            }

  				//$_SESSION["token"] = createToken($_POST["email"]);

          header("Location: index.php");
        }else{
          $_SESSION["online"] = 'false';
				echo "Identifiants incorrects2";
			 }
}else{
    echo "Vous n'avez pas rempli tous les champs ";
}
