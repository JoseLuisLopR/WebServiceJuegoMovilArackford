<?php
/*
 * @author Jose Luis
 */
//Conexion a la base de datos
class Database {
	public $conn;
	private $server;
	private $user;
	private $pass;
	private $bd;
	
	public function __construct($server, $user, $pass, $bd){
                $this->server = $server;
		$this->user = $user;
		$this->pass = $pass;
		$this->bd = $bd;
    }
 
    // get the database connection
    public function getConnection(){
        $this->conn = null;
        try{
			$this->conn = new mysqli ($this->server, $this->user, $this->pass, $this->bd);
			$this->conn->set_charset("utf8");
        } catch (mysqli_sql_exception $e) { 
            echo $e->errorMessage();
        }
        return $this->conn;
	}
}
