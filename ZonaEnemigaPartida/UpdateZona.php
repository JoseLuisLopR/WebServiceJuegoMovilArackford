<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../constants.php';
include '../Database.php';
include '../Entities/ZonaEnemigaPartida.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();
$zonaEnePart = new ZonaEnemigaPartida($db);

if(isset($_POST['login']) and isset($_POST['password'])and isset($_POST['nombreZona'])and isset($_POST['nivel'])and isset($_POST['fechaDerrota'])and isset($_POST['completada'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
    $nombreZona=$_POST['nombreZona'];
    $zonaEnePart->nivel=$_POST['nivel'];
    $zonaEnePart->fechaDerrota=$_POST['fechaDerrota'];
    $zonaEnePart->completada=$_POST['completada'];
}else{
    echo 'mal';
    die();
}

if($zonaEnePart->Update($zonaEnePart->GetId($nombreZona, $login, $password)[0]["id_zona_partida"])){    echo '1';}else{    echo '0';}


