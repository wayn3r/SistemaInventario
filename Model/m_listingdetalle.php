<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingDetalles extends entity{

    public $idEntrega;
    public $idExistencia;
    public $idTipoArticulo;
    public $tipoArticulo;
    public $idArticulo;
    public $modelo;
    public $cantidad;

    public function __construct()
    {
        $this->addAttribute('idExistencia');
        $this->addAttribute('idTipoArticulo');
        $this->addAttribute('tipoArticulo');
        $this->addAttribute('idArticulo');
        $this->addAttribute('modelo');
        $this->addAttribute('cantidad');
        $this->tableName = 'existencia_entrega';
        $this->view = 'vw_detalles_entregas';
        $this->idName = 'idEntrega';
        $this->childTableName = 'vw_detalles_entregas';
    }
    public function __set($var,$value){

        $this->$var=$value;
        
    }
    public function __get($name)
    {
        if(isset($this->$name))
            return $this->$name;
    }

}

?>