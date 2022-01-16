<?php
//Clase de tabla en la base de datos
class ZonaEnemigaPartida {
    private $conn;
    private $table_name = "zonas_enemigas_partida";
    // object properties
    public $idZonaPartida;
    public $fkZona;
    public $fkPartida;
    public $nivel;
    public $fechaDerrota;
    public $completada;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function Create() {
        $query = "INSERT INTO {$this->table_name} (fk_zona, fk_partida, nivel, completada) VALUES ({$this->fkZona},{$this->fkPartida},{$this->nivel},{$this->completada})";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function ReadOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_zona_partida = " . $this->idZonaPartida;
        $stmt = mysqli_query($this->conn, $query);
        return $stmt;
    }
    
    public function ReadZonasUsuario($login,$password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE fk_partida =(SELECT id_partida FROM partidas WHERE fk_usuario=(SELECT id_usuario FROM usuarios WHERE login='{$login}' and password='" . md5($password) . "' and activo=1) and activo = 1)";
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    public function GetId($nombreZona,$login,$password) {
        $query = "SELECT z.id_zona_partida FROM " . $this->table_name . " z INNER JOIN zonas_enemigas zo on zo.id_zona=z.fk_zona INNER JOIN partidas p on p.id_partida=z.fk_partida WHERE p.fk_usuario=(SELECT id_usuario FROM usuarios WHERE login='$login' and password='" .md5($password)."' and activo=1) and zo.nombre='$nombreZona'";
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    public function Update($id) {
        $query = "UPDATE " . $this->table_name 
        . " SET nivel = '" . $this->nivel 
        . "', fecha_derrota = '" . $this->fechaDerrota 
        . "', completada = " . $this->completada 
        . " WHERE id_zona_partida=$id";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    //SELECT * FROM zonas_enemigas_partida WHERE fk_partida =(SELECT id_partida FROM partidas WHERE fk_usuario=1 and activo = 1)
    public function RestoDefault(){
        foreach ($this as $key => $value) {
             if(empty($value)){$this->$key = "DEFAULT";}
        }
    }
}
