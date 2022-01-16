<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../constants.php';
include '../Database.php';
include '../Entities/Checkpoint.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();
$checkpoint = new Checkpoint($db);

//Obtiente el checkpoint donde guardo la partida para usuario en concreto
if(isset($_POST['login']) and isset($_POST['password'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
}else{
    echo 'mal';
    die();
}

$stmt = $checkpoint->ReadCheckpointUsuario($login,$password);

if (count($stmt) > 0) {
    $checkpoint->idCheckpoint = $stmt[0]['id_checkpoint'];
    $checkpoint->nombre = $stmt[0]['nombre'];
    $checkpoint->posicion = $stmt[0]['posicion'];
    $checkpoint->rotacion = $stmt[0]['rotacion'];
    echo json_encode($checkpoint);
} //fin del if
else {
    echo 'no se ha encontrado';
    mysqli_close($db); //SalidProductoa y cierre
}
