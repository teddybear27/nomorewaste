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
	$results = $db->query("SELECT * from panier where etat='livraison' AND disponible != 'arrivee'");	
	return $results;
}

function getCartsForVolunteer($db,$id) {
	$results = $db->query("SELECT * from panier where id_benevole='$id'");	
	return $results;
}
/*
function isConnected(){
	if(!empty($_SESSION["email"])){
		$connect = connectDB();
		if(emailExist($connect, $_SESSION["email"])){
			
			if($_SESSION["token"] == createToken( $_SESSION["email"])){
				return true;
			}else{
				return false;
			}

		}else{
			return false;
		}

	}else{
		return false;
	}
}
*/

function logout(){
	$curMail = $_SESSION['mail'];
	$connect = connectDB();
	
	if ($_SESSION["online"] == 1 
	 || $_SESSION["online"] == 2 
	 || $_SESSION["online"] == 3){
		$connect->query("UPDATE user SET online='0' where  mail='$curMail'");
	}else if ($_SESSION["online"] == 4){
		$connect->query("UPDATE shop SET online='0' where  mail='$curMail'");
	}else if ($_SESSION["online"] == 5){
		$connect->query("UPDATE organization SET online='0' where  mail='$curMail'");
	}
	session_destroy();
}

function redirect($url){
	header("Location: $url");
	exit();
}
