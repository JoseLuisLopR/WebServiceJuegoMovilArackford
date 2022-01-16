<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../constants.php';
include '../Database.php';
include '../Entities/Jugador.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();
$jugador = new Jugador($db);

if(isset($_POST['login']) and isset($_POST['password'])and isset($_POST['nombreZona'])and isset($_POST['nivel'])and isset($_POST['exp'])and isset($_POST['vida'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
    $nombreZona=$_POST['nombreZona'];
    $jugador->nivel=$_POST['nivel'];
    $jugador->vida=$_POST['vida'];
    $jugador->exp=$_POST['exp'];
}else{
    echo 'mal';
    die();
}

if($jugador->Update($nombreZona,$login,$password)){    echo '1';}else{    echo '0';}


