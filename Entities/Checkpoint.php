<?php
//Clase de tabla en la base de datos
class Checkpoint {
    private $conn;
    private $table_name = "checkpoints";
    // object properties
    public $idCheckpoint;
    public $nombre;
    public $posicion;
    public $rotacion;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function Create() {
        $query = "INSERT INTO {$this->table_name} (nombre, posicion, rotacion) VALUES ('{$this->nombre}','{$this->posicion}','{$this->rotacion}')";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function ReadOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_checkpoint = " . $this->idCheckpoint;
        $stmt = mysqli_query($this->conn, $query);
        return $stmt;
    }
    
    public function ReadCheckpointUsuario($login,$password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_checkpoint = (SELECT fk_checkpoint FROM jugadores WHERE fk_partida = (SELECT id_partida FROM partidas WHERE fk_usuario=(SELECT id_usuario FROM usuarios WHERE login='{$login}' and password='" . md5($password) . "' and activo=1) and activo = 1))";
        $stmt = mysqli_query($this->conn, $query);
        //echo $query;
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    //SELECT * FROM checkpoints WHERE id_checkpoint = (SELECT fk_checkpoint FROM jugadores WHERE fk_partida = (SELECT id_partida FROM partidas WHERE fk_usuario=1 and activo = 1))
    public function RestoDefault(){
        foreach ($this as $key => $value) {
             if(empty($value)){$this->$key = "DEFAULT";}
        }
    }
}