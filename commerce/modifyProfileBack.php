<?php
session_start();
require "../functions.php";

if( count($_POST) == 11 
	&& !empty($_POST["shopname"])
	&& !empty($_POST["category"])
	&& !empty($_POST["email"])
	&& !empty($_POST["annee_immatriculation"])
	&& !empty($_POST["pwd"])
	&& !empty($_POST["pwdConfirm"])
	&& !empty($_POST["phone"])
	&& !empty($_POST["address"])
	&& !empty($_POST["zip"])
	&& !empty($_POST["city"])
	&& !empty($_POST["country"]) ) {

	$connect = connectDB();

	//Nettoyage
	$_POST["shopname"] = strtoupper(trim($_POST["shopname"]));
	$_POST["category"] = strtoupper(trim($_POST["category"]));
	$_POST["category"] = ucwords(strtolower(trim($_POST["category"])));
	$_POST["phone"] = trim($_POST["phone"]);
	$_POST["email"] = strtolower(trim($_POST["email"]));
	$_POST["annee_immatriculation"] = trim($_POST["annee_immatriculation"]);
	$_POST["address"] = trim($_POST["address"]);
	$_POST["zip"] = trim($_POST["zip"]);
	$_POST["city"] = ucwords(strtolower(trim($_POST["city"])));


	$error = false;
	$listOfErrors = [];
	$currentMail = $_SESSION['mail'];

	//shopname

	if( strlen($_POST["shopname"])<2  || strlen($_POST["shopname"])>100 ){
			$error = true;
			$listOfErrors[] = "Votre nom doit faire entre 2 et 100 caractères";
	}

	//category

	if( strlen($_POST["category"])<2  || strlen($_POST["category"])>100 ){
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
			$queryPrepared = $connect->prepare("UPDATE user SET nom = :nom, categorie = :categorie, mail = :mail, mdp = :mdp, annee_immatriculation = :annee_immatriculation, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays, check_mail = :check_mail WHERE mail = '$currentMail'");

			$shopname = htmlspecialchars($_POST["shopname"]);
			$pwd = password_hash($_POST["pwdConfirm"], PASSWORD_DEFAULT);
			$verifKey = md5(time().$shopname); //Génère une clé avec le nom

			$queryPrepared->execute(
				[
					"nom"=>$_POST["shopname"],
					"categorie"=>$_POST["category"],
					"mail"=>$_POST["email"],
					"mdp"=>$pwd,
					"annee_immatriculation" => $_POST["annee_immatriculation"],
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
			$queryPrepared = $connect->prepare("UPDATE user SET nom = :nom, categorie = :categorie, mdp = :mdp, annee_immatriculation = :annee_immatriculation, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays WHERE mail = '$currentMail'");

			$shopname = htmlspecialchars($_POST["shopname"]);
			$pwd = password_hash($_POST["pwdConfirm"], PASSWORD_DEFAULT);

			$queryPrepared->execute(
				[
					"nom"=>$_POST["shopname"],
					"categorie"=>$_POST["category"],
					"mdp"=>$pwd,
					"annee_immatriculation" => $_POST["annee_immatriculation"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"]
				]

			);
		}
    setcookie("errorForm", serialize($listOfErrors));    
    redirect("profile.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


