<?php
require_once('db/db_entity.php');
use Model\db\entity;

class HistoricoImpresoras extends entity{

    public $idHistorico;
    public $idFecha;
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
        
        
        $this->addAttribute('idFecha');
        $this->addAttribute('idImpresora');
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
        $this->tableName = 'historico_impresora';
        $this->idName = 'idHistorico';
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