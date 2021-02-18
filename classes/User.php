<?php
require_once "Database.php";
/** 
 * Clase User
 * clase que gestiona los datos de los Usuarios
 * @author Fco. Javier Bueno
 */
class User {
/**
 * @param int $idUsu - id del usuario
 * @param string $email - email del usuario
 * @param string $password - contraseña del usuario
 * @param string $nombre - nombre del usuario
 * @param string $apellidos - apellidos del usuario
 * @param string $foto - foto del usuario
 * 
 * 
 * 
 */
    private int $idUsu;
    private string $email;
    private string $password;
    private string $nombre;
    private ?string $apellidos = null;
    private string $foto;
    

    /**
     * obtiene la foto del usuario
     * @return string $this->foto
     */ 
    public function getFoto()
    {
        return $this->fotos;
    }

    /**
     * establece la foto del usuario
     *
     * @return  self
     */ 
    public function setFoto($fotos)
    {
        $this->fotos = $fotos;

        return $this;
    }

    /**
     *obtiene los apellidos del usuario
     * @return string $this->apellidos
     */ 
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * establece los apellidos del usuario
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * obtiene el nombre del usuario
     * @return $this->nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * establece el nombre del usuario
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * obtiene la contraseña del usuario
     * $return $this->pasword
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Establece la contraseña del usuario
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * obtiene el email del usuario
     * $return $this->email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * establece el email del usuario
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * obtiene el id del usuario
     * @return $this->idUsu
     */ 
    public function getIdUsu()
    {
        return $this->idUsu;
    }

    /**
     * establece el id del usuario
     *
     * @return  self
     */ 
    public function setIdUsu($idUsu)
    {
        $this->idUsu = $idUsu;

        return $this;
    }
    /**
     * realiza el login de usuario
     * @param string $email 
     * @param string $password 
     * 
     * @return boolean - devuelve true si el login es satisfactorio , si no, devuelve false
     * 
     */

    public function login ($email, $password){
        $connect = Database::getDatabase();
        
        $formatPass = md5($password);
        $result = $connect->query("select* from usuario where email='$email' and password='$formatPass'");

        if(!$result)return false;
       
    $rows = $result->fetchObject("User");
        if(!$rows->idUsu)return false;
            $this->saveDataUser($rows->idUsu, $rows->email, $rows->password, $rows->nombre, $rows->apellidos, $rows->foto);
           
        return true;
    }

    /**
     * obtiene el id del usuario según su email
     * @param string $email
     * @return int - el id del usuario 
     */
    public function getIdReceptor($email) {
        $connect = Database::getDatabase();
       
        $result = $connect->query("select idUsu from usuario where email='$email'");

        $getId = $result->fetchObject("User");

        return $getId->idUsu;
    }
/**
 * actualiza los datos del usuario
 * @param string $email
 * @param string $nombre
 * @param string $apellidos
 * @param string $pass
 * 
 * @return boolean - devuelve true si se ha podido actualizar los datos del usuario, false si no se ha podido
 */
    public function updateUser($email, $nombre, $apellidos, $pass) {
        $connect = Database::getDatabase();
       
        $formatPass = md5($pass);
        $result = $connect->query("update usuario set nombre='$nombre', apellidos='$apellidos', password='$formatPass' where email='$email'");
    
        if(!$result)return false;
        return true;
    } 
/**
 * se obtiene el email del usuario  a partir de su id
 * @param int $idUsu
 * @return string - email del usuario
 */
    public function getEmailUser($idUsu) {
        $connect = Database::getDatabase();
        
        $result = $connect->query("select email from usuario where idUsu=$idUsu");

        $getId = $result->fetchObject("User");

        return $getId->email;
    }

    /**
     * guarda los datos del usuario
     * @param int $idUsu
     * @param string $email
     * @param string $password
     * @param string $nombre
     * @param string $apellidos
     * @param string $foto
     * 
     * @return $this
     * 
     */
    public  function saveDataUser($idUsu, $email, $password, $nombre, $apellidos, $foto) {
        $this->setIdUsu($idUsu);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
        $this->setFoto($foto);
        
        return $this;
    }

}