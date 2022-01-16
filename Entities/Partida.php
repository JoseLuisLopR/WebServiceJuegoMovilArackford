<?php
//Clase de tabla en la base de datos
class Partida {
    private $conn;
    private $table_name = "partidas";
    // object properties
    public $idPartida;
    public $fkUsuario;
    public $tiempoJugado;
    public $finalizada;
    public $activo;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    public function Create() {
        $this->finalizada=="DEFAULT" || $this->finalizada=="NULL"?null: $this->finalizada="'". $this->finalizada."'";
        $query = "INSERT INTO {$this->table_name} (fk_usuario, tiempo_jugado, finalizada, activo) VALUES ('{$this->fkUsuario}','{$this->tiempoJugado}',{$this->finalizada},{$this->activo})";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function ReadOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE fk_usuario = $this->fkUsuario and activo=1";
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
        public function GetPartidaUsu($login,$password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE fk_usuario = (SELECT id_usuario FROM usuarios WHERE login='{$login}' and password='" . md5($password) . "' and activo=1) and activo=1";
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    public function Update($login,$password) {
        if($this->finalizada==""){
            $this->finalizada="finalizada";
        }else{
            $this->finalizada="'".$this->finalizada."'";
        }
        $query = "UPDATE " . $this->table_name 
        . " SET tiempo_jugado = '" . $this->tiempoJugado 
        . "', finalizada = $this->finalizada, fk_usuario = (SELECT id_usuario FROM usuarios WHERE login='{$login}' and password='" . md5($password) . "' and activo=1)";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    public function RestoDefault(){
        foreach ($this as $key => $value) {
             if(empty($value)){$this->$key = "DEFAULT";}
        }
    }
}
