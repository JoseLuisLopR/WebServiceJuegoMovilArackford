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

if(isset($_POST['login']) and isset($_POST['password'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
}else{
    echo 'mal';
    die();
}

$stmt = $jugador->ReadJugadorUsu($login,$password);

if (count($stmt) > 0) {
    $jugador->idJugador=$stmt[0]['id_jugador'];
    $jugador->fkPartida=$stmt[0]['fk_partida'];
    $jugador->nivel=$stmt[0]['nivel'];
    $jugador->exp=$stmt[0]['exp'];
    $jugador->vida=$stmt[0]['vida'];
    $jugador->fkCheckpoint=$stmt[0]['fk_checkpoint'];
    echo json_encode($jugador);
} //fin del if
else {
    http_response_code(404);
    mysqli_close($db); //SalidProductoa y cierre
}
