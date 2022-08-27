<?php
session_start();
require "../functions.php";
echo(count($_POST));
if( count($_POST) == 6 
	&& !empty($_POST["cartname"])
	&& !empty($_POST["description"])
	&& !empty($_POST["consumptionDate"])
	&& !empty($_POST["quantite"])
	&& !empty($_POST["id_acteur"])
	&& !empty($_POST["status_acteur"]) ) {

	$connect = connectDB();

	//Nettoyage
	$_POST["cartname"] = strtoupper(trim($_POST["cartname"]));
	$_POST["consumptionDate"] = trim($_POST["consumptionDate"]);


	$error = false;
	$listOfErrors = [];

	//cartname

	if( strlen($_POST["cartname"])<2  || strlen($_POST["cartname"])>100 ){
			$error = true;
			$listOfErrors[] = "Votre nom doit faire entre 2 et 100 caractères";
	}

	//description

	if( strlen($_POST["description"])<2 ){
			$error = true;
			$listOfErrors[] = "Votre prénom doit faire entre 2 et 50 caractères";
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
			header("Location: giveProducts.php");

	}else{
		$queryPrepared = $connect->prepare("INSERT INTO panier (nom, description, etat, date_consommation, acteur, id_acteur, quantite_total, date_transaction, disponible) VALUES (:nom, :description, :etat, :date_consommation, :acteur, :id_acteur, :quantite_total, :date_transaction, :disponible)");


		$queryPrepared->execute(
			[
				"nom"=>$_POST["cartname"],
				"description"=>$_POST["description"],
				"etat"=> "collecte",
				"date_consommation" => $_POST["consumptionDate"],
				"acteur" => $_POST["status_acteur"],
				"id_acteur" => $_POST["id_acteur"],
				"quantite_total" => $_POST["quantite"],
				"date_transaction" => $dateTransaction,
				"disponible" => "traitement"
			]

		);
		$listOfErrors[] = "Panier ajouté";
    setcookie("errorForm", serialize($listOfErrors));
    redirect("giveProducts.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


