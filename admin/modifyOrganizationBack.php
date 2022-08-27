<?php
session_start();
require "../functions.php";

if( count($_POST) == 10 
	&& !empty($_POST["autorisation"]) 
	&& !empty($_POST["organizationName"])
	&& !empty($_POST["siren"])
	&& !empty($_POST["email"])
	&& !empty($_POST["creationYear"])
	&& !empty($_POST["phone"])
	&& !empty($_POST["address"])
	&& !empty($_POST["zip"])
	&& !empty($_POST["city"])
	&& !empty($_POST["country"]) ) {

	$connect = connectDB();

	//Nettoyage
	$_POST["organizationName"] = ucwords(strtolower(trim($_POST["organizationName"])));
	$_POST["siren"] = trim($_POST["siren"]);
	$_POST["phone"] = trim($_POST["phone"]);
	$_POST["email"] = strtolower(trim($_POST["email"]));
	$_POST["address"] = trim($_POST["address"]);
	$_POST["zip"] = trim($_POST["zip"]);
	$_POST["city"] = ucwords(strtolower(trim($_POST["city"])));


	$error = false;
	$listOfErrors = [];
	$organizationMail = $_SESSION['modifyO'];

	//organizationName

	if( strlen($_POST["organizationName"])<2  || strlen($_POST["organizationName"])>100 ){
			$error = true;
			$listOfErrors[] = "Votre nom doit faire entre 2 et 100 caractères";
	}

	//SIREN

	if( strlen($_POST["siren"]) != 9){
			$error = true;
			$listOfErrors[] = "Votre numero de SIREN doit faire 9 caractères";
	}

$mailChanged = 0;
if ($organizationMail != $_POST["email"]){
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

	// creationYear

	if( strlen($_POST["creationYear"]) != 4){
			$error = true;
			$listOfErrors[] = "L'Année de création doit faire 4 caractères";
	}


	//Vérifier le format du phone -> regex
  if( !preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $_POST["phone"]) ){
      $error = true;
      $listOfErrors[] = "Le numéro doit comporter 10 chiffres et commencer par 0";
  }

	

	if($error){
		
			setcookie("errorForm", serialize($listOfErrors));	
			header("Location: modifyOrganization.php");

	}else{		
		if ($mailChanged == 1){
			$queryPrepared = $connect->prepare("UPDATE organization SET nom = :nom, siren = :siren, mail = :mail, annee_creation = :annee_creation, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays, check_mail = :check_mail, autorisation = :autorisation WHERE mail = '$organizationMail'");

			$organizationName = htmlspecialchars($_POST["organizationName"]);
			$verifKey = md5(time().$organizationName); //Génère une clé avec le nom

			$queryPrepared->execute(
				[
					"nom"=>$_POST["organizationName"],
					"siren" =>$_POST["siren"],
					"mail"=>$_POST["email"],
					"annee_creation" => $_POST["creationYear"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"],
					"check_mail"=>$verifKey,
					"autorisation" => $_POST["autorisation"]
				]

			);
		//echo "Un mail de confirmation vous a été envoyé. Veuillez vérifier SVP.";
		//echo "N'oubliez pas de vérifier les spams si besoin";

		//Envoi mail de verification
			$email = htmlspecialchars($_POST["email"]);

		    if($queryPrepared) {
		        $to = $email;
		        $subject = "NoMoreWaste : Vérification du mail";
		        $message = " Veuillez cliquer sur le lien suivant afin de vérifier votre compte : <a href='https://nomorewaste.online/mail/verifyMailOrganization.php?code_verif=$verifKey'>Valider mon compte</a><br/>\n ";
		        $message .= "En cas de problème essayez ce lien : https://nomorewaste.online/mail/verifyMailOrganization.php?code_verif=$verifKey";
		        $header="MIME-Version: 1.0\r\n";
		        $header.='Content-Type:text/html; charset="uft-8"'."\r\n";
		        $header.='Content-Transfer-Encoding: 8bit'."\r\n";
		        $header .= 'From: <cheikh.kane@nomorewaste.online>' . "\r\n";
		        mail($to,$subject,$message,$header);
		    }
    		$listOfErrors[] = ["Un mail de confirmation vous a été envoyé (Voir spams / courriers indésirables)"];
    		$_SESSION['mail'] = $_POST["email"];
		}else{
			$queryPrepared = $connect->prepare("UPDATE organization SET nom = :nom, siren = :siren, annee_creation = :annee_creation, numero_telephone = :numero_telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, pays = :pays, autorisation = :autorisation WHERE mail = '$organizationMail'");

			$queryPrepared->execute(
				[
					"nom"=>$_POST["organizationName"],
					"siren" =>$_POST["siren"],
					"annee_creation" => $_POST["creationYear"],
					"numero_telephone" => $_POST["phone"],
					"adresse" => $_POST["address"],
					"code_postal" => $_POST["zip"],
					"ville" => $_POST["city"],
					"pays" => $_POST["country"],
					"autorisation" => $_POST["autorisation"]
				]

			);
		}
		$listOfErrors[] = "Association modifiée";
    setcookie("errorForm", serialize($listOfErrors));
    redirect("modifyOrganization.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


