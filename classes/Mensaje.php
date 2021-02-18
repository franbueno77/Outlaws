<?php

/** 
 * Clase Mensaje
 * clase que gestiona la información de los mensajes
 * @author Fco. Javier Bueno
 */
require_once "Database.php";
require_once "User.php";
class Mensaje {
    /**
     * @var int $idMen - id del mensaje
     * @var int $idOri -  id del origen del mensaje
     * @var int $idDes -  id del destino del mensaje
     * @var string $fecha -  fecha del mensaje
     * @var string $asunto -  asunto 
     * @var string $texto - texto
     * @var int $leido -  mensaje leído con valor 1 , no leído con valor 0
     * @var string $nombreOri - nombre del autor del mensaje
     */
    private int $idMen;
    private int $idOri;
    private int $idDes;
    private string $fecha;
    private string $asunto;
    private string $texto;
    private int $leido;
    private string $nombreOri;
    


    /**
     * obtiene el valor de leido
     * @return int $this->leido 
     */ 
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * establece el valor de leido
     *
     * @return  self
     */ 
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * obtiene el texto
     * @return string $this->texto
     */ 
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * establece el valor de texto
     *
     * @return  self
     */ 
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * obtiene el valor de asunto
     * @return string $this->asunto
     */ 
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * establece el valor de asunto
     *
     * @return  self
     */ 
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;

        return $this;
    }

    /**
     * obtiene el valor de la fecha del mensaje
     * @return string $this->fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * establece el valor de la fecha del mensaje
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * obtiene el valor de la id destinatario  del mensaje
     * @return int $this->idDes
     */ 
    public function getIdDes()
    {
        return $this->idDes;
    }

    /**
     * establece el valor de la id destinatario del mensaje
     *
     * @return  self
     */ 
    public function setIdDes($idDes)
    {
        $this->idDes = $idDes;

        return $this;
    }

    /**
     * obtiene el valor del id del origen del mensaje
     * @return $this->idOri 
     */ 
    public function getIdOri()
    {
        return $this->idOri;
    }

    /**
     * Establece el valor del id del origen del mensaje
     *
     * @return  self
     */ 
    public function setIdOri($idOri)
    {
        $this->idOri = $idOri;

        return $this;
    }

    /**
     * obtiene el valor del id del mensaje
     * @return $this->idMen
     */ 
    public function getIdMen()
    {
        return $this->idMen;
    }

    /**
     * Sestablece el valor del id del mensaje
     *
     * @return  self
     */ 
    public function setIdMen($idMen)
    {
        $this->idMen = $idMen;

        return $this;
    }
      /**
     * obtiene el nombre del autor del mensaje
     * @this->nombreOri
     */ 
    public function getNombreOri()
    {
        return $this->nombreOri;
    }

    /**
     * Establece el nombre del autor del mensaje
     *
     * @return  self
     */ 
    public function setNombreOri($nombreOri)
    {
        $this->nombreOri = $nombreOri;

        return $this;
    }
    /**
     * realiza una consulta de los mensajes recibidos para un usuario
     * @param int  $idDes - id del  usuario que recibe el mensaje
     * @return array $array - devuelve los mensajes recibidos en un array
     */
    public function mensajesRecibidos($idDes) {

        $connect = Database::getDatabase();
        

        $result = $connect->query("select idMen, idOri, idDes, fecha, asunto, leido, nombre from mensaje  join usuario  on idOri = idUsu where idDes=$idDes");
        if(!$result)return false;
                                                                                                                                                  
        $array = [];
        while($rows = $result->fetchObject("Mensaje")) {
            $newInstance = new Mensaje;
            
            array_push($array, $newInstance->saveDataMensaje(

                $rows->idMen, $rows->idOri, $rows->idDes, $rows->fecha, $rows->asunto,"", $rows->leido, $rows->nombre
            
            ));

        }
        return $array;
    }
    /**
     * realiza una consulta de los mensajes enviados 
     * @param int $idOri id del usuario que envia el mensaje
     * 
     * @return array $array - devuelve los mensajes enviados en un array
     */
    public function mensajesEnviados($idOri) {

        $connectDb = Database::getDatabase();
        

        $result = $connectDb->query("select idMen, idOri, idDes, fecha, asunto, leido, nombre from mensaje  join usuario  on idDes = idUsu where idOri=$idOri");
        if(!$result)return false;

        $array = [];
        while($rows = $result->fetchObject("Mensaje")) {
            $newInstance = new Mensaje;

            
            array_push($array, $newInstance->saveDataMensaje(

                $rows->idMen, $rows->idOri, $rows->idDes, $rows->fecha, $rows->asunto,"", $rows->leido, $rows->nombre
            
            ));

        }
        return $array;
    }
/**
 * consulta que borra un mensaje segun el id
 * @param int $idMen
 * @return boolean devuelve true si el mensaje se ha borrado con éxito, false si no lo ha podido borrar
 */
    public function deleteMensaje($idMen) {
        $connectDb = Database::getDatabase();
        
        $result = $connectDb->query("delete from mensaje where idMen=$idMen");
        if(!$result) return false;
        return true;
    }
/**
 * envía un mensaje a otro usuario
 * @param int $idOri - id del usuario que envia el mensaje
 * @param string $emailDes - email del usuario destino
 * @param string $asunto - asunto del mensaje
 * @param string $texto - texto del mensaje
 * @return boolean - devuelve true si se ha enviado el mensaje, false si no se ha enviado
 * 
 */
    public function sendEmail($idOri, $emailDes, $asunto, $texto) {
        $connectDb = Database::getDatabase();
        
        $user = new User;
        $idUsu = $user->getIdReceptor($emailDes);
        
        $timezone  = +1; 
        $fecha = gmdate("Y-m-d H:i:s", time() + 3600*($timezone+date("I")));
        
        $result = $connectDb->query("insert into mensaje (idOri, idDes, fecha, asunto, texto, leido) values ($idOri, $idUsu, '$fecha', '$asunto', '$texto',0) ");
       
        if(!$result) return false;
        return true;
    }
    /**
     * consulta que establece los valores del mensaje a la clase
     * @param int $idMen - id del mensaje
     * @param boolean $enviado - indica si el mensaje ha sido enviado o no
     * @return boolean $result - si devuelve true , establece los valores, en caso de false, no establece los valores
     */
    public function leerMensaje($idMen, $enviado =false) {
        $connectDb = Database::getDatabase();
        
        if(!$enviado){
            //mensajes recibidos
            $result = $connectDb->query("select idMen, idOri, idDes, fecha, asunto, texto, nombre from mensaje  join usuario  on idOri = idUsu where idMen=$idMen");
        }else {
            //mensajes enviados
            $result = $connectDb->query("select idMen, idOri, idDes, fecha, asunto, texto, nombre from mensaje  join usuario  on idDes = idUsu where idMen=$idMen");
        }
        
        if(!$result) return false;

        $dataMsg = $result->fetchObject("Mensaje");
        $this->saveDataMensaje($dataMsg->idMen, $dataMsg->idOri, $dataMsg->idDes, $dataMsg->fecha, $dataMsg->asunto, $dataMsg->texto, 1 , $dataMsg->nombre);
       
        return true;
    }
/**
 * cambia el estado de los mensajes a leído
 * @param int $idMen - id del mensaje
 * @return boolean $result - si devuelve true, cambia el estado del mensaje a leído, si no, no cambia su estado
 * 
 */
    public function mensajeLeido($idMen) {
        $connectDb = Database::getDatabase();
        
        $result = $connectDb->query("update mensaje set leido=1 where idMen=$idMen");
    
        if(!$result) return false;

        return true;
    }
    /**
     * método que guarda los atributos en clase
     * @param int $idMen - id del mensaje
     * @param int $idOri - id del usuario que envía el mensaje
     * @param int $idDes -  id del usuario que recibe el mensaje
     * @param string $fecha - fecha del mensaje
     * @param   string $asunto - asunto del mensaje
     * @param string $texto - texto del mensaje
     * @param int #leido - indica si el texto ha sido leído o no
     * @param string $nombreOri - nombre del que envia el mensaje
     * 
     */
    public  function saveDataMensaje($idMen, $idOri, $idDes, $fecha, $asunto, $texto = "", $leido = 0, $nombreOri) {
        $this->setIdMen($idMen);
        $this->setIdOri($idOri);
        $this->setIdDes($idDes);
        $this->setFecha($fecha);
        $this->setAsunto($asunto);
        $this->setTexto($texto);
        $this->setLeido($leido);
        $this->setNombreOri($nombreOri);
        return $this;
    }
    

  
}
?>