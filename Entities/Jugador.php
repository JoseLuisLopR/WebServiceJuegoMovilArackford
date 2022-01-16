<?php
//Clase de tabla en la base de datos
class Jugador {
    private $conn;
    private $table_name = "jugadores";
    // object properties
    public $idJugador;
    public $fkPartida;
    public $nivel;
    public $exp;
    public $vida;
    public $fkCheckpoint;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    public function Create() {
        $query = "INSERT INTO {$this->table_name} (fk_partida, nivel, exp, vida, fk_checkpoint) VALUES ({$this->fkPartida},{$this->nivel},{$this->exp},{$this->vida},{$this->fkCheckpoint})";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    public function ReadOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_jugador = " . $this->idJugador;
        $stmt = mysqli_query($this->conn, $query);
        return $stmt;
    }
    
    public function ReadJugadorUsu($login,$password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE fk_partida = (SELECT id_partida FROM partidas WHERE fk_usuario=(SELECT id_usuario FROM usuarios WHERE login='{$login}' and password='" . md5($password) . "' and activo=1) and activo = 1)";
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    public function Update($nombreZona,$login,$password) {
        $query = "UPDATE " . $this->table_name 
        . " SET nivel = '" . $this->nivel 
        . "', exp = '" . $this->exp 
        . "', vida = '" . $this->vida 
        . "', fk_checkpoint = (SELECT id_checkpoint FROM checkpoints where nombre='{$nombreZona}') WHERE fk_partida = (SELECT id_partida FROM partidas WHERE fk_usuario=(SELECT id_usuario FROM usuarios WHERE login='{$login}' and password='" . md5($password) . "' and activo=1) and activo = 1)";
echo $query;
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    
    //SELECT * FROM jugadores WHERE fk_partida = (SELECT id_partida FROM partidas WHERE fk_usuario=1 and activo = 1)
    public function RestoDefault(){
        foreach ($this as $key => $value) {
             if(empty($value)){$this->$key = "DEFAULT";}
        }
    }
    
}
