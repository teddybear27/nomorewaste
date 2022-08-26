<?php
session_start();
require "../functions.php";

if( count($_POST) == 11 
	&& !empty($_POST["shopname"])
	&& !empty($_POST["category"])
	&& !empty($_POST["siren"])
	&& !empty($_POST["email"])
	&& !empty($_POST["regYear"])
	&& !empty($_POST["phone"])
	&& !empty($_POST["address"])
	&& !empty($_POST["zip"])
	&& !empty($_POST["city"])
	&& !empty($_POST["country"]) ) {

	$connect = connectDB();

	//Nettoyage
	$_POST["shopname"] = ucwords(strtolower(trim($_POST["shopname"])));
	$_POST["category"] = ucwords(strtolower(trim($_POST["category"])));
	$_POST["siren"] = trim($_POST["siren"]);
	$_POST["phone"] = trim($_POST["phone"]);
	$_POST["email"] = strtolower(trim($_POST["email"]));
	$_POST["address"] = trim($_POST["address"]);
	$_POST["zip"] = trim($_POST["zip"]);
	$_POST["city"] = ucwords(strtolower(trim($_POST["city"])));


	$error = false;
	$listOfErrors = [];
	$shopMail = $_POST['modifyS'];

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

	//SIREN

	if( strlen($_POST["siren"])<9  || strlen($_POST["siren"])>9 ){
			$error = true;
			$listOfErrors[] = "Votre numero de SIREN doit faire 9 caractères";
	}
$mailChanged = 0;
if ($shopMail != $_POST["email"]){
	// Vérifier email

	if( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
			$error = true;
			$listOfErrors[] = "Votre email est incorrect";
	}else if(  emailExist($connect, $_POST['email'])  ){
			$error = true;
			$listOfErrors[] = "Cette adresse mail est déjà utilisé";
	}
	$mailChanged = 1;
}

	// regYear

	if( strlen($_POST["regYear"])<4  || strlen($_POST["regYear"])>4 ){
			$error = true;
			$listOfErrors[] = "Votre Année Immatriculation doit faire 4 caractères";
	}


	//Vérifier le format du phone -> regex
  if( !preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $_POST["phone"]) ){
      $error = true;
      $listOfErrors[] = "Le numéro doit comporter 10 chiffres et commencer par 0";
  }

	

	if($error){
		
			setcookie("errorForm", serialize($listOfErrors));	
			header("Location: modifyShop.php");

	}else{		
		if ($mailChanged == 1){
			$queryPrepared = $connect->prepare("UPDATE shop SET nom = :nom, categorie = :categorie, siren = :siren, mail = :mail, annee_immatriculation = :annee_immatriculation, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays, check_mail = :check_mail WHERE mail = '$shopMail'");

			$shopname = htmlspecialchars($_POST["shopname"]);
			$verifKey = md5(time().$shopname); //Génère une clé avec le nom

			$queryPrepared->execute(
				[
					"nom"=>$_POST["shopname"],
					"categorie"=>$_POST["category"],
					"siren" =>$_POST["siren"],
					"mail"=>$_POST["email"],
					"annee_immatriculation" => $_POST["regYear"],
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
		        $message = " Veuillez cliquer sur le lien suivant afin de vérifier votre compte : <a href='https://nomorewaste.online/mail/verifyMailShop.php?code_verif=$verifKey'>Valider mon compte</a><br/>\n ";
		        $message .= "En cas de problème essayez ce lien : https://nomorewaste.online/mail/verifyMailShop.php?code_verif=$verifKey";
		        $header="MIME-Version: 1.0\r\n";
		        $header.='Content-Type:text/html; charset="uft-8"'."\r\n";
		        $header.='Content-Transfer-Encoding: 8bit'."\r\n";
		        $header .= 'From: <cheikh.kane@nomorewaste.online>' . "\r\n";
		        mail($to,$subject,$message,$header);
		    }
    		$listOfErrors[] = ["Un mail de confirmation vous a été envoyé (Voir spams / courriers indésirables)"];
    		$_SESSION['mail'] = $_POST["email"];
		}else{
			$queryPrepared = $connect->prepare("UPDATE shop SET nom = :nom, categorie = :categorie, siren = :siren, annee_immatriculation = :annee_immatriculation, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays WHERE mail = '$shopMail'");

			$queryPrepared->execute(
				[
					"nom"=>$_POST["shopname"],
					"categorie"=>$_POST["category"],
					"siren" =>$_POST["siren"],
					"annee_immatriculation" => $_POST["regYear"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"]
				]

			);
		}
    setcookie("errorForm", serialize($listOfErrors));
    redirect("commerces.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


