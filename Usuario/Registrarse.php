<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../constants.php';
include '../Database.php';
include '../Entities/Usuario.php';
include '../Entities/Jugador.php';
include '../Entities/Partida.php';
include '../Entities/ZonaEnemiga.php';
include '../Entities/ZonaEnemigaPartida.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();
$usuario = new Usuario($db);

//Creaa todas las columnas necesarias en base de datos para crear un usario y que pueda jugar
if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['email']) && isset($_POST['login']) && isset($_POST['password'])){
    $usuario->nombre=$_POST['nombre'];
    $usuario->apellidos=$_POST['apellidos'];
    $usuario->email=$_POST['email'];
    $usuario->login=$_POST['login'];
    $usuario->password=$_POST['password'];
    $usuario->activo='1';
}else{
    echo 'mal';
    die();
}



 //generamos el objeto
if(!$usuario->ExisteLogin()){
    if($usuario->Create()){
        $stmt = $usuario->readOne();
        $partida = new Partida($db);        
        $partida->fkUsuario= $stmt[0]['id_usuario'];
        $partida->RestoDefault();
        if($partida->Create()){
            $stmt = $partida->ReadOne();
            $jugador = new Jugador($db);
            $jugador->fkPartida=$stmt[0]['id_partida'];
            $jugador->RestoDefault();
            if($jugador->Create()){
                $zonaEnem = new ZonaEnemiga($db);
                $zonaEnemPart = new ZonaEnemigaPartida($db);
                $zonaEnemPart->fkPartida=$stmt[0]['id_partida'];
                foreach ($zonaEnem->ReadAll() as $z) {
                    $zonaEnemPart->fkZona=$z['id_zona'];
                    $zonaEnemPart->RestoDefault();
                    $zonaEnemPart->Create();
                }
                echo '1';
            }
            
        }
        
    }

}else{
    //Usuario ya existe
    echo '0';
}
