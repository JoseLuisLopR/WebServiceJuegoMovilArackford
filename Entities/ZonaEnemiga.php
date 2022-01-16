<?php
//Clase de tabla en la base de datos
class ZonaEnemiga {
    private $conn;
    private $table_name = "zonas_enemigas";
    // object properties
    public $idZona;
    public $nombre;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function Create() {
        $query = "INSERT INTO {$this->table_name} (nombre) VALUES ('{$this->nombre}')";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function ReadOne() {
        $query = "SELECT * FROM "  . $this->table_name . " WHERE id_zona = " . $this->idZona;
        $stmt = mysqli_query($this->conn, $query);
        return $stmt;
    }
    
    public function ReadAll() {
        $query = "SELECT * FROM " . $this->table_name ;
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    public function RestoDefault(){
        foreach ($this as $key => $value) {
             if(empty($value)){$this->$key = "DEFAULT";}
        }
    }
}
