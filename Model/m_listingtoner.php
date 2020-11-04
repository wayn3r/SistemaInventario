<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingToners extends entity{
    public $idToner;
    public $idImpresora;
    public $idTipoArticulo;
    public $idMarca;
    public $modelo;

    public function __construct()
    {
        $this->addAttribute('idToner');
        $this->addAttribute('idImpresora');
        $this->addAttribute('idTipoArticulo');
        $this->addAttribute('idMarca');
        $this->addAttribute('modelo');
        $this->tableName = 'toner_impresora';
        $this->idName = 'idImpresora';
        $this->view='vw_toner_impresora';
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