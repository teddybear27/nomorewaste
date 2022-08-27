<?php
session_start();
require "../functions.php";

if( count($_POST) == 10 
	&& !empty($_POST["lastname"])
	&& !empty($_POST["firstname"])
	&& !empty($_POST["status"])
	&& !empty($_POST["email"])
	&& !empty($_POST["birthday"])
	&& !empty($_POST["phone"])
	&& !empty($_POST["address"])
	&& !empty($_POST["zip"])
	&& !empty($_POST["city"])
	&& !empty($_POST["country"]) ) {

	$connect = connectDB();

	//Nettoyage
	$_POST["lastname"] = strtoupper(trim($_POST["lastname"]));
	$_POST["firstname"] = ucwords(strtolower(trim($_POST["firstname"])));
	$_POST["phone"] = trim($_POST["phone"]);
	$_POST["email"] = strtolower(trim($_POST["email"]));
	$_POST["birthday"] = trim($_POST["birthday"]);
	$_POST["address"] = trim($_POST["address"]);
	$_POST["zip"] = trim($_POST["zip"]);
	$_POST["city"] = ucwords(strtolower(trim($_POST["city"])));


	$error = false;
	$listOfErrors = [];
	$userMail = $_SESSION['modifyP'];

	//lastname

	if( strlen($_POST["lastname"])<2  || strlen($_POST["lastname"])>100 ){
			$error = true;
			$listOfErrors[] = "Votre nom doit faire entre 2 et 100 caractères";
	}

	//firstname

	if( strlen($_POST["firstname"])<2  || strlen($_POST["firstname"])>50 ){
			$error = true;
			$listOfErrors[] = "Votre prénom doit faire entre 2 et 50 caractères";
	}
$mailChanged = 0;
if ($userMail != $_POST["email"]){
	// Vérifier email

	if( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
			$error = true;
			$listOfErrors[] = "Votre email est incorrect";
	}else if(  emailExist($connect, $_POST['email'])  ){
			$error = true;
			$listOfErrors[] = "Cette adresse mail est déjà utilisée";
	}
	$mailChanged = 1;
}

	//// Vérifier birthday
    //2022-08-03
    //03/08/2022
  if(
      !preg_match("#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#", $_POST["birthday"]) &&
      !preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", $_POST["birthday"])
  ){
    //Format incorrect
    	$error = true;
  }else{

    $birthdayExploded = explode("/", $_POST["birthday"]);
    if( count($birthdayExploded) == 3) {
    		$_POST["birthday"] = $birthdayExploded[2]."-".$birthdayExploded[1]."-".$birthdayExploded[0];
    }


    $birthdayExploded = explode("-", $_POST["birthday"]);

    if(!checkdate($birthdayExploded[1], $birthdayExploded[2], $birthdayExploded[0])){
        $error = true;
    }else{

        $birthdaySec = strtotime($_POST["birthday"]);
        $timeToDay =  time();

        $ageSec = $timeToDay-$birthdaySec;
        $age = $ageSec / 3600 / 24 / 365.25;


        if($age < 18){
        	$error = true;
        	$listOfErrors[] = "Vous n'avez pas l'âge requis pour vous inscrire (18ans minimum)";
        }else if($age > 110){
            $error = true;
            $listOfErrors[] = "Il se peut que vous vous soyez trompés sur l'année de votre anniversaire";
        }
    }
  }


	//Vérifier le format du phone -> regex
  if( !preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $_POST["phone"]) ){
      $error = true;
      $listOfErrors[] = "Le numéro doit comporter 10 chiffres et commencer par 0";
  }

	

	if($error){
		
			setcookie("errorForm", serialize($listOfErrors));	
			header("Location: modifyParticulier.php");

	}else{		
		if ($mailChanged == 1){
			$queryPrepared = $connect->prepare("UPDATE user SET status = :status, nom = :nom, prenom = :prenom, mail = :mail, date_naissance = :date_naissance, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays, check_mail = :check_mail WHERE mail = '$userMail'");

			$lastname = htmlspecialchars($_POST["lastname"]);
			$verifKey = md5(time().$lastname); //Génère une clé avec le nom

			$queryPrepared->execute(
				[
					"status"=>$_POST["status"],
					"nom"=>$_POST["lastname"],
					"prenom"=>$_POST["firstname"],
					"mail"=>$_POST["email"],
					"date_naissance" => $_POST["birthday"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"],
					"check_mail"=>$verifKey
				]

			);
		//echo "Un mail de confirmation vous a été envoyé. Veuillez vérifier SVP.";
		//echo "N'oubliez pas de vérifier les spams si besoin";

		//Envoi mail de verification
			$email = htmlspecialchars($_POST["email"]);

		    if($queryPrepared) {
		        $to = $email;
		        $subject = "NoMoreWaste : Vérification du mail";
		        $message = " Veuillez cliquer sur le lien suivant afin de vérifier votre compte : <a href='https://nomorewaste.online/mail/verifyMail.php?code_verif=$verifKey'>Valider mon compte</a><br/>\n ";
		        $message .= "En cas de problème essayez ce lien : https://nomorewaste.online/mail/verifyMail.php?code_verif=$verifKey";
		        $header="MIME-Version: 1.0\r\n";
		        $header.='Content-Type:text/html; charset="uft-8"'."\r\n";
		        $header.='Content-Transfer-Encoding: 8bit'."\r\n";
		        $header .= 'From: <cheikh.kane@nomorewaste.online>' . "\r\n";
		        mail($to,$subject,$message,$header);
		    }
    		$listOfErrors[] = ["Un mail de confirmation vous a été envoyé (Voir spams / courriers indésirables)"];
    		$_SESSION['mail'] = $_POST["email"];
		}else{
			$queryPrepared = $connect->prepare("UPDATE user SET status = :status, nom = :nom, prenom = :prenom, date_naissance = :date_naissance, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays WHERE mail = '$userMail'");

			$queryPrepared->execute(
				[
					"status"=>$_POST["status"],
					"nom"=>$_POST["lastname"],
					"prenom"=>$_POST["firstname"],
					"date_naissance" => $_POST["birthday"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"]
				]

			);
		}
		$listOfErrors[] = "Utilisateur modifié";
    setcookie("errorForm", serialize($listOfErrors));
    redirect("particuliers.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


