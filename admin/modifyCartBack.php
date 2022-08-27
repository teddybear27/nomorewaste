<?php
session_start();
require "../functions.php";

if( count($_POST) == 5 
	&& !empty($_POST["cartname"])
	&& !empty($_POST["description"])
	&& !empty($_POST["consumptionDate"])
	&& !empty($_POST["quantite"])
	&& !empty($_POST["quantite"]) ) {

	$connect = connectDB();

	$idCart = $_POST["idCart"];

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
			header("Location: modifyCart.php");

	}else{
		$queryPrepared = $connect->prepare("UPDATE panier SET nom = :nom, description = :description, date_consommation = :date_consommation, quantite_total = :quantite_total where id = '$idCart'");


		$queryPrepared->execute(
			[
				"nom"=>$_POST["cartname"],
				"description"=>$_POST["description"],
				"date_consommation" => $_POST["consumptionDate"],
				"quantite_total" => $_POST["quantite"]
			]

		);
		$listOfErrors[] = "Panier ajouté";
		$_POST['modifyC'] = $idCart;
    setcookie("errorForm", serialize($listOfErrors));
    redirect("modifyCart.php");
    die();
		
	}

} else {

	print_r ($_POST);
	echo "<pre>";
	print_r($_SERVER);

	die("Tentative de hack !!!");

}


