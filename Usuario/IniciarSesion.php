<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include '../constants.php';
include '../Database.php';
include '../Entities/Usuario.php';

$database = new Database($server, $user, $pass, $bd);
$db = $database->getConnection();

$usuario = new Usuario($db);

//Obtenien el usuario si la contraseña y el login coinciden
if(isset($_POST['login']) and isset($_POST['password'])){
    $usuario->login=$_POST['login'];
    $usuario->password=$_POST['password'];
}else{
    die();
}
$stmt = $usuario->leerSesion();


// check if more than 0 record found
if (mysqli_num_rows($stmt) > 0) {
    $row = mysqli_fetch_assoc($stmt);
    extract($row); // extract row this will make $row['name'] to just $name only
    $usuario->idUsuario = $id_usuario;
    $usuario->nombre = $nombre;
    $usuario->apellidos = $apellidos;
    $usuario->email = $email;
    $usuario->login = $login;
    $usuario->activo = $activo;
    echo json_encode($usuario);
} //fin del if
else {
    echo '0';
    mysqli_close($db); //SalidProductoa y cierre
}


