<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../constants.php';
include '../Database.php';
include '../Entities/Partida.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();
$partida = new Partida($db);

//Actualiza la informacion de la paritida para un usuario
if(isset($_POST['login']) && isset($_POST['password'])&& isset($_POST['tiempoJugado'])&& isset($_POST['finalizada'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
    $partida->tiempoJugado=$_POST['tiempoJugado'];
    $partida->finalizada=$_POST['finalizada'];
}else{
    echo 'mal';
    die();
}

if($partida->Update($login,$password)){    echo '1';}else{    echo '0';}


