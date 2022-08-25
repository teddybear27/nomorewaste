<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 1){
  redirect("../denied.php");
}

var_dump($_POST["deleteP"]);