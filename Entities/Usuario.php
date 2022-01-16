<?php
//Clase de tabla en la base de datos
class Usuario {
    private $conn;
    private $table_name = "usuarios";
    // object properties
    public $idUsuario;
    public $nombre;
    public $apellidos;
    public $email;
    public $login;
    public $password;
    public $activo;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function Create() {
        $query = "INSERT INTO {$this->table_name} (nombre, apellidos, email, login, password, activo) VALUES ('{$this->nombre}','{$this->apellidos}','{$this->email}','{$this->login}',md5('{$this->password}'),'{$this->activo}')";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function ReadOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE login = '" . $this->login. "' and activo=1";
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    
    public function leerSesion(){
        $query = "SELECT * FROM {$this->table_name} WHERE login='{$this->login}' and password='" . md5($this->password) . "' and activo=1";
        $stmt = mysqli_query($this->conn, $query);
        return $stmt;
        
    }
    public function ExisteLogin() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE login = '" . $this->login ."' and activo=1";
        $stmt = mysqli_query($this->conn, $query);
        if($stmt->num_rows>0){
            return true;
        }else{
            return false;
        }
    }

    public function aaa() {
        $query = "SELECT * FROM " . $this->table_name . " " ;
        $stmt = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    }
    public function error(){
        return mysqli_error($this->conn);
    }

    public function RestoDefault(){
        foreach ($this as $key => $value) {
             if(empty($value)){$this->$key = "DEFAULT";}
        }
    }
}
