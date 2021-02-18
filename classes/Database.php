<?php
/** 
 * Clase Database
 * esta clase gestiona la conexión con la base de datos
 * @author Fco. Javier Bueno
 */
class Database {
    /**
     * variables de la clase Database
     * @var $instance - variable que se usa para la instancia de clase para  el patrón singleton
     * @var $connection - variable para la conexión con la base de datos 
     * @var $host -   el host de la base de datos
     * @var $dbuser -  el usuario de la base de datos
     * @var $pass - la contraseña para la base de datos
     */
    private static $instance;
    private static $connection;

    private $host = "localhost";
    private $dbname = "outlaws";
    private $dbuser = "root";
    private $pass = "";
/**
 * constructor de la clase, declarado en privado para que no se pueda acceder a ella, cumpliendo con el patrón singleton
 *  
 */
    private function __construct(){}
    /**
     * método clone, declarado como privado para evitar que se puedan crear copias de la instancia de la clase
     */
    private function __clone(){}
/**
 * método que implementa el patrón singleton, que hace que la instancia solo se cree una sola vez
 * @return Database
 */
    public static function getDatabase() {
        if(self::$instance == null) self::$instance = new Database();
        self::$instance = self::startConnection();
        return self::$instance;

    }
    /**
     * método para conectarse con la base de datos
     * @return PDO
     */
    public function startConnection() {
	try{
	self::$connection = new PDO("mysql:host=localhost; dbname=outlaws;charset=utf8", "root", "");

        return self::$connection;
	
	}catch(PDOException $e){
	die("Error :".$e->getMessage());
	}
        
    }
    /**
     * método que realiza las consultas 
     * @return PDOStatement
     */
    public function query($query, $sqlParams = []) {
        $prepare = self::$connection->prepare($query);
        return $prepare->execute($sqlParams);
    }
/**
 * método que devuelve una instancia del objeto para la consulta realizada
 * @return StdClass
 */
    public static function getClass($result,  $class = "stdclass") {
        return $result->fetchObject($class);    
    }
}