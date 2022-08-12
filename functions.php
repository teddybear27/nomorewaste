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

/*
function emailExist($connect, $email){

	$queryPrepared = $connect->prepare("SELECT id FROM user WHERE mail=:mail");

	$queryPrepared->execute(["mail"=>$email]);

	$result = $queryPrepared->fetch();
	//$result = $queryPrepared->fetchAll();

	if( empty($result)){
		return false;
	}
	
	return true;
}

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


function createToken($email){
	return md5($email."tesfdsfshgfd".$email);
}

// Fonction de suppression d'utilisateurs

function eraseUser($email){
	$connect = connectDB();
	$req = $connect->query("DELETE FROM user WHERE mail='$email'");
}

// Fonction pour les ingrédients

function addIngredient($ingredientName){
	$connect = connectDB();
	$req = $connect->prepare("INSERT INTO ingredient (nom_ingredient) VALUES (:nom_ingredient)");
	$req->execute(["nom_ingredient"=>$ingredientName]);
	echo ($ingredientName." ajouté.");
}

function modifyIngredient($ingredientName, $newName){
	if ($ingredientName !== $newName) {
		$connect = connectDB();
		$req = $connect->prepare("UPDATE ingredient SET nom_ingredient='$newName' WHERE nom_ingredient='$ingredientName'");
		$req->execute(['nom_ingredient'=>$newName]);
		echo "Succès de la modification";
	}else{
		echo "Le nom de l'ingrédient n'a pas changé";
	}
	
}

function deleteIngredient($ingredientName){
	$connect = connectDB();
	$req = $connect->query("DELETE FROM ingredient WHERE nom_ingredient='$ingredientName'");
}

function lockUser($email){
	$connect = connectDB();
	$q = $connect->prepare("UPDATE user SET blocked='oui' WHERE email=:email");
	$q->execute(["email"=>$email]);
}

function unlockUser($email){
	$connect = connectDB();
	$q = $connect->prepare("UPDATE user SET blocked='non' WHERE email=:email");
	$q->execute(["email"=>$email]);
}
*/
function redirect($url){
	header("Location: $url");
	exit();
}
