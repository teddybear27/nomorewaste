<?php
session_start();
require "../functions.php";

if( count($_POST) == 11 
	&& !empty($_POST["lastname"])
	&& !empty($_POST["firstname"])
	&& !empty($_POST["email"])
	&& !empty($_POST["birthday"])
	&& !empty($_POST["pwd"])
	&& !empty($_POST["pwdConfirm"])
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
if ($_SESSION['mail'] != $_POST["email"]){
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


	//Vérifier le pwd

	if(
		!preg_match("#[a-z]#", $_POST["pwd"]) ||
		!preg_match("#[A-Z]#", $_POST["pwd"]) ||
		!preg_match("#[0-9]#", $_POST["pwd"]) ||
		strlen( $_POST["pwd"]) < 6 ||
		strlen( $_POST["pwd"]) > 300 
	){
			$error = true;
			$listOfErrors[] = "Votre mot de passe est incorrect. Il doit comporter au minimum 6 caractères, une majuscule et un chiffre.";
	}

	//Vérifier le pwdConfirm
	
	if($_POST["pwd"] != $_POST["pwdConfirm"]){
			if(!password_verify($_POST["pwdConfirm"], $_POST["pwd"])){
				$error = true;
				$listOfErrors[] = "Votre mot de passe de confirmation est incorrect";
		}
	}

	//Vérifier le format du phone -> regex
  if( !preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $_POST["phone"]) ){
      $error = true;
      $listOfErrors[] = "Le numéro doit comporter 10 chiffres et commencer par 0";
  }

	

	if($error){
		
			setcookie("errorForm", serialize($listOfErrors));	
			header("Location: modifyProfile.php");

	}else{		
		if ($mailChanged == 1){
			$queryPrepared = $connect->prepare("UPDATE user SET nom = :nom, prenom = :prenom, mail = :mail, mdp = :mdp, date_naissance = :date_naissance, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays, check_mail = :check_mail) 
			WHERE mail = '$_SESSION['mail']'");

			$lastname = htmlspecialchars($_POST["lastname"]);
			$pwd = password_hash($_POST["pwdConfirm"], PASSWORD_DEFAULT);
			$verifKey = md5(time().$lastname); //Génère une clé avec le nom

			$queryPrepared->execute(
				[
					"nom"=>$_POST["lastname"],
					"prenom"=>$_POST["firstname"],
					"mail"=>$_POST["email"],
					"mdp"=>$pwd,
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
		}else{
			$queryPrepared = $connect->prepare("UPDATE user SET nom = :nom, prenom = :prenom, mdp = :mdp, date_naissance = :date_naissance, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays) 
			WHERE mail = '$_SESSION['mail']'");

			$lastname = htmlspecialchars($_POST["lastname"]);
			$pwd = password_hash($_POST["pwdConfirm"], PASSWORD_DEFAULT);

			$queryPrepared->execute(
				[
					"nom"=>$_POST["lastname"],
					"prenom"=>$_POST["firstname"],
					"mdp"=>$pwd,
					"date_naissance" => $_POST["birthday"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"]
				]

			);
		}
    setcookie("errorForm", serialize($listOfErrors));
    redirect("modifyProfile.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


