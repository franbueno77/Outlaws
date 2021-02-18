<?php
/** 
 * Clase Session
 * clase que gestiona la sesión de los usuarios en la aplicación
 * @author Fco. Javier Bueno
 */
require_once "User.php";

class Session {
    /**
     * @param $instance - se usa para  el uso del patrón singleton
     * @param TIME - constante que establece el tiempo que puede permanecer el usuario en la sesión antes de que expire
     * @param  $user - para manejar instancias de la clase USER
     */
    private static $instance;
    const TIME = 500;
    private $user;
    /**
     * método del patrón singleton, que hace que solo exista una única instancia de la clase
     * @return self::$instance - devuelve una instancia de la clase, que es única
     */
    public static function getSession() {
        session_start();
        if(self::$instance == null) self::$instance = new Session();
        return self::$instance;

    }
    /**
     * método que inicia una marca de tiempo de inicio de la sesión
     * 
     */
    public static function startSession() {
        $_SESSION["start"] = time();

    }
    /**
     * método que evalúa si la sesión ha expirado o no
     * @return boolean - devuelve true si ha expirado, false si no ha expirado
     */
    public static function isExpired(){
        return (time() - $_SESSION["start"]) > self::TIME;
    }
    /**
     * cierra la sesión del usuario
     */
    public  function closeSession() {
        unset($_SESSION["dataUser"]);
        unset($_SESSION["start"]);
        $_SESSION = [];
       
    }
    /**
     * chequea la sesión, en caso de que haya expirado, cierra la sesión ,
     * en caso de que no , establece una nueva marca de tiempo
     * 
     */
    public function checkSession() {
        if(self::isExpired()){
            $this->closeSession();
            return true;
        }else{
            self::startSession();
            return false;
        }
    }

    /**
     * guarda los datos de usuario en la variable superglobal de Sesión
     * 
     */
    public function saveDataUser($user) {
        $this->user = $user;
        $_SESSION["dataUser"] =serialize($this->user);
    }
    /**
     * devuelve los datos seteados en la variable superglobal de sesión
     * @return User
     */
    public function getDataUser() {
        
        return unserialize($_SESSION["dataUser"]);
    }
}
?>