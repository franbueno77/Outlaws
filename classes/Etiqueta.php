<?php
/** 
 * Clase Etiqueta
 * clase que gestiona la información de las etiquetas
 * @author Fco. Javier Bueno
 */
require_once "Database.php";
class Etiqueta {
    /**
     * @var int $idTag - el id de la etiqueta
     * @var string $etiqueta - el nombre de la etiqueta
     * @var string $color - el color de la etiqueta
     * 
     */
    private ?int $idTag = null;
    private ?string $etiqueta = null;
    private ?string $color = null;
    

    /**
     * se obtiene el color de la etiqueta
     * @return string $this->color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Establece el color de la etiqueta
     *
     * @return  self
     */ 
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * se obtiene el nombre de la etiqueta
     * @return string $this->etiqueta
     */ 
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }

    /**
     * establece el nombre de la etiqueta
     *
     * @return  self
     */ 
    public function setEtiqueta($etiqueta)
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    /**
     * obtiene el id de la etiqueta
     * @return int $this->idTag
     */ 
    public function getIdTag()
    {
        return $this->idTag;
    }

    /**
     * establece el valor del id de la etiqueta
     *
     * @return  self
     */ 
    public function setIdTag($idTag)
    {
        $this->idTag = $idTag;

        return $this;
    }
/**
 * realiza una consulta que muestra una etiqueta según el id del mensaje
 * @param $idMen -id del mensaje
 * @return $this
 */
    public function mostrarEtiqueta($idMen) {

        $connect = Database::getDatabase();
        
        $result = $connect->query("select idTag, etiqueta, color from mensaje_etiqueta join etiqueta using(idTag) where idMen = $idMen");

        if(!$result) return false;

        $row = $result ->fetchObject("Etiqueta");
        $this->saveDataEtiqueta(@$row->idTag, @$row->etiqueta, @$row->color);
        return true;
    }
    public  function saveDataEtiqueta($idTag, $etiqueta, $color) {
        $this->setIdTag($idTag);
        $this->setEtiqueta($etiqueta);
        $this->setColor($color);
        
        return $this;
    }
}