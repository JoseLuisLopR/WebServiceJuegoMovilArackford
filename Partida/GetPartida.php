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

//Obtiente la partida para usuario en concreto
if(isset($_POST['login']) and isset($_POST['password'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
}else{
    echo 'mal';
    die();
}

$stmt = $partida->GetPartidaUsu($login, $password);

if (count($stmt) > 0) {
    $partida->idPartida = $stmt[0]['id_partida'];
    $partida->fkUsuario = $stmt[0]['fk_usuario'];
    $partida->finalizada = $stmt[0]['finalizada'];
    $partida->tiempoJugado = $stmt[0]['tiempo_jugado'];
    $partida->activo = $stmt[0]['activo'];
    echo json_encode($partida);
} //fin del if
else {
    http_response_code(404);
    mysqli_close($db); //SalidProductoa y cierre
}
