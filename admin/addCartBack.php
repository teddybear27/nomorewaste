<?php
session_start();
require "../functions.php";

if( count($_POST) == 6 
	&& !empty($_POST["cartname"])
	&& !empty($_POST["description"])
	&& !empty($_POST["etat"])
	&& !empty($_POST["consumptionDate"])
	&& !empty($_POST["id_benevole"])
	&& !empty($_POST["quantite"]) ) {

	$connect = connectDB();

	$resCurrent = getCurrentUser($connect,$_SESSION['mail']);
	$data = $resCurrent->fetch();

	$idUser = $data['id'];
	$statusUser = $data['status'];

	//Nettoyage
	$_POST["cartname"] = strtoupper(trim($_POST["cartname"]));
	$_POST["consumptionDate"] = trim($_POST["consumptionDate"]);


	$error = false;
	$listOfErrors = [];

	//cartname

	if( strlen($_POST["cartname"])<2  || strlen($_POST["cartname"])>100 ){
			$error = true;
			$listOfErrors[] = "Votre nom de panier doit faire entre 2 et 100 caractères";
	}

	//description

	if( strlen($_POST["description"])<2 ){
			$error = true;
			$listOfErrors[] = "Votre description doit faire minimum 2 caractères";
	}


	//// Vérifier consumptionDate
    //2022-08-03
    //03/08/2022
  if(
      !preg_match("#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#", $_POST["consumptionDate"]) &&
      !preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", $_POST["consumptionDate"])
  ){
    //Format incorrect
    	$error = true;
  }else{

    $consumptionDateExploded = explode("/", $_POST["consumptionDate"]);
    if( count($consumptionDateExploded) == 3) {
    		$_POST["consumptionDate"] = $consumptionDateExploded[2]."-".$consumptionDateExploded[1]."-".$consumptionDateExploded[0];
    }


    $consumptionDateExploded = explode("-", $_POST["consumptionDate"]);

    if(!checkdate($consumptionDateExploded[1], $consumptionDateExploded[2], $consumptionDateExploded[0])){
        $error = true;
    }else{

        $consumptionDateSec = strtotime($_POST["consumptionDate"]);
        $timeToDay =  time();

        $ageSec = $timeToDay-$consumptionDateSec;
        $age = $ageSec / 3600 / 24 / 365.25;


        if($age > 0){
        	$error = true;
        	$listOfErrors[] = "Vous devez choisir une date de consommation dans le futur";
        }
    }
  }

	//Quantite totale

	if( $_POST["quantite"]<1  || $_POST["quantite"]>10000 ){
				$error = true;
				$listOfErrors[] = "La quantité doit être comprise entre 1 et 10.000 inclus";
	}

	// Date et heure actuelle

	$dateTransaction = date("Y-m-d H:i:s");


	

	if($error){
		
			setcookie("errorForm", serialize($listOfErrors));	
			header("Location: addCart.php");

	}else{
		if (!empty($_POST['id_benevole'])){
			$queryPrepared = $connect->prepare("INSERT INTO panier (nom, description, etat, date_consommation, acteur, id_acteur, id_benevole, quantite_total, date_transaction, disponible) VALUES (:nom, :description, :etat, :date_consommation, :acteur, :id_acteur, :id_benevole, :quantite_total, :date_transaction, :disponible)");


			$queryPrepared->execute(
				[
					"nom"=>$_POST["cartname"],
					"description"=>$_POST["description"],
					"etat"=>$_POST["etat"],
					"date_consommation" => $_POST["consumptionDate"],
					"acteur" => $statusUser,
					"id_acteur" => $idUser,
					"id_benevole"=>$_POST["id_benevole"],
					"quantite_total" => $_POST["quantite"],
					"date_transaction" => $dateTransaction,
					"disponible" => "traitement"
				]

			);
		}else{
			if (!empty($_POST['id_benevole'])){
			$queryPrepared = $connect->prepare("INSERT INTO panier (nom, description, etat, date_consommation, acteur, id_acteur, id_benevole, quantite_total, date_transaction, disponible) VALUES (:nom, :description, :etat, :date_consommation, :acteur, :id_acteur, :id_benevole, :quantite_total, :date_transaction, :disponible)");


			$queryPrepared->execute(
				[
					"nom"=>$_POST["cartname"],
					"description"=>$_POST["description"],
					"etat"=>$_POST["etat"],
					"date_consommation" => $_POST["consumptionDate"],
					"acteur" => $statusUser,
					"id_acteur" => $idUser,
					"id_benevole"=> "0",
					"quantite_total" => $_POST["quantite"],
					"date_transaction" => $dateTransaction,
					"disponible" => "traitement"
				]

			);
		}
		$listOfErrors[] = "Panier ajouté";
    setcookie("errorForm", serialize($listOfErrors));
    redirect("addCart.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


