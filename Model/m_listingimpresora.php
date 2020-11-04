<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingImpresoras extends entity{

    public $idImpresora;
    public $serialNumber;
    public $direccionIp;
    public $fechaInventario;
    public $fechaCompra;
    public $idEstado;
    public $estado;
    public $idArticulo;
    public $modelo;
    public $idTipoArticulo;
    public $tipoArticulo;
    public $idMarca;
    public $marca;


    public function __construct()
    {
        
        
        $this->addAttribute('serialNumber');
        $this->addAttribute('direccionIp');
        $this->addAttribute('fechaInventario');
        $this->addAttribute('fechaCompra');
        $this->addAttribute('idEstado');
        $this->addAttribute('estado');
        $this->addAttribute('idArticulo');
        $this->addAttribute('modelo');
        $this->addAttribute('idTipoArticulo');
        $this->addAttribute('tipoArticulo');
        $this->addAttribute('idMarca');
        $this->addAttribute('marca');
        $this->tableName = 'impresora';
        $this->view = 'vw_impresoras';
        $this->idName = 'idImpresora';
        $this->childTableName = 'vw_impresoras';
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