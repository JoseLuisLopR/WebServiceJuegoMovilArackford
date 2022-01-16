<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../constants.php';
include '../Database.php';
include '../Entities/ZonaEnemiga.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();
$zonaEnemiga = new ZonaEnemiga($db);

//Obtione todas las zonas de enemigos
$stmt = $zonaEnemiga->ReadAll();
$zonas = array();
if (count($stmt) > 0) {
    foreach ($stmt as $z) {
        $zonaEne = new ZonaEnemiga($db);
        $zonaEne->idZona=$z["id_zona"];
        $zonaEne->nombre=$z["nombre"];
        array_push($zonas,$zonaEne);
    }
    echo json_encode($zonas);
} //fin del if
else {
    http_response_code(404);
    mysqli_close($db); //SalidProductoa y cierre
}
