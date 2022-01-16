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
$zonaEnemigaPartida = new ZonaEnemigaPartida($db);

if(isset($_POST['login']) and isset($_POST['password'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
}else{
    echo 'mal';
    die();
} 

$stmt = $zonaEnemigaPartida->ReadZonasUsuario($login,$password);
$zonas = array();
if (count($stmt) > 0) {
    foreach ($stmt as $z) {
        $zonaEnePar = new ZonaEnemigaPartida($db);
        $zonaEnePar->idZonaPartida=$z["id_zona_partida"];
        $zonaEnePar->fkZona=$z["fk_zona"];
        $zonaEnePar->fkPartida=$z["fk_partida"];
        $zonaEnePar->nivel=$z["nivel"];
        $zonaEnePar->fechaDerrota=$z["fecha_derrota"];
        $zonaEnePar->completada=$z["completada"];
        array_push($zonas,$zonaEnePar); 
    }
    echo json_encode($zonas);
} //fin del if
else {
    http_response_code(404);
    mysqli_close($db); //SalidProductoa y cierre
}