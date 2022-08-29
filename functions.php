<?php


function connectDB(){
	try{
		$connect = new PDO( "mysql:host=127.0.0.1;dbname=u349012487_nomorewaste;charset=utf8;port=3306" , "u349012487_root", "gVHwVDZX4" , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch(Exception $e){
		die("Erreur SQL : ".$e->getMessage());
	}

	return $connect;
}


/*
function connectDB(){
	try{
		$connect = new PDO("mysql:host=localhost;dbname=nomorewaste;charset=utf8;port=3306" , "root", "" , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch(Exception $e){
		die("Erreur SQL : ".$e->getMessage());
	}

	return $connect;
}
*/

function getCurrentUser($db,$mail) {
	$results = $db->query("SELECT * from user where mail = '$mail'");	
	return $results;
}

function getCurrentShop($db,$mail) {
	$results = $db->query("SELECT * from shop where mail = '$mail'");	
	return $results;
}

function getCurrentOrganization($db,$mail) {
	$results = $db->query("SELECT * from organization where mail = '$mail'");	
	return $results;
}

function getUsers($db) {
	$results = $db->query("SELECT * from user where status != 'admin'");	
	return $results;
}

function getUsersVolunteers($db) {
	$results = $db->query("SELECT * from user where status = 'benevole'");	
	return $results;
}

function getShops($db) {
	$results = $db->query("SELECT * from shop");	
	return $results;
}

function getShopsToValidate($db) {
	$results = $db->query("SELECT * from shop where autorisation = 'mail non valide' OR autorisation = 'en attente'");	
	return $results;
}

function getOrganizations($db) {
	$results = $db->query("SELECT * from organization");	
	return $results;
}
function getOrganizationsToValidate($db) {
	$results = $db->query("SELECT * from organization where autorisation = 'mail non valide' OR autorisation = 'en attente'");	
	return $results;
}

function getCarts($db) {
	$results = $db->query("SELECT * from panier");	
	return $results;
}

function getCartsAvailable($db) {
	$results = $db->query("SELECT * from panier where disponible = 'traitement' AND id_benevole = '0'");	
	return $results;
}

function getCartsToShip($db) {
	$results = $db->query("SELECT * from panier where disponible != 'arrivee'");	
	return $results;
}

function getCartsForVolunteer($db,$id) {
	$results = $db->query("SELECT * from panier where id_benevole='$id' AND disponible != 'arrivee'");	
	return $results;
}

function getCartsForVolunteerArrival($db,$id) {
	$results = $db->query("SELECT * from panier where id_benevole='$id' AND disponible = 'arrivee'");	
	return $results;
}

function getCartsForUserOrder($db) {
	$results = $db->query("SELECT * from panier where acteur='particulier' AND etat='collecte' AND disponible = 'arrivee'");	
	return $results;
}

function getCartsForUserInProgress($db,$id) {
	$results = $db->query("SELECT * from panier where acteur='particulier' AND id_acteur='$id' AND disponible != 'arrivee'");	
	return $results;
}

function getCartsForUserOrderHistory($db,$id) {
	$results = $db->query("SELECT * from panier where acteur='particulier' AND id_acteur='$id' AND (disponible = 'arrivee' OR disponible = 'commandee')");	
	return $results;
}

function getCartsForOrganizationOrder($db) {
	$results = $db->query("SELECT * from panier where acteur='Association' AND etat='collecte' AND disponible = 'arrivee'");	
	return $results;
}

function getCartsForOrganizationOrderInProgress($db,$id) {
	$results = $db->query("SELECT * from panier where acteur='Association' AND id_acteur='$id' AND disponible != 'arrivee'");	
	return $results;
}

function getCartsForOrganizationOrderHistory($db,$id) {
	$results = $db->query("SELECT * from panier where acteur='Association' AND id_acteur='$id' AND (disponible = 'arrivee' OR disponible = 'commandee')");	
	return $results;
}

function getActorInfosFromCart($db,$id,$actor) {
	if ($actor == "particulier" || $actor == "admin"){
		$results = $db->query("SELECT * from user where id='$id'");
	}else if ($actor == "Commerce"){
		$results = $db->query("SELECT * from shop where id='$id'");
	}else if ($actor == "Association"){
		$results = $db->query("SELECT * from organization where id='$id'");
	}	
	return $results;
}


function emailExist($connect, $email){

	$queryPrepared = $connect->prepare("SELECT id FROM users WHERE mail=:mail");

	$queryPrepared->execute(["mail"=>$email]);

	$result = $queryPrepared->fetch();
	//$result = $queryPrepared->fetchAll();

	if( empty($result)){
		return false;
	}
	
	return true;
}



function logout(){
	$curMail = $_SESSION['mail'];
	$connect = connectDB();
	
	if ($_SESSION["online"] == 1 
	 || $_SESSION["online"] == 2 
	 || $_SESSION["online"] == 3){
		$connect->query("UPDATE user SET online='0' where mail='$curMail'");
	}else if ($_SESSION["online"] == 4){
		$connect->query("UPDATE shop SET online='0' where mail='$curMail'");
	}else if ($_SESSION["online"] == 5){
		$connect->query("UPDATE organization SET online='0' where mail='$curMail'");
	}
	session_destroy();
}

function redirect($url){
	header("Location: $url");
	exit();
}
