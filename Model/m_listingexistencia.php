<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingExistencias extends entity{

    public $idExistencia;
    public $idEstado;
    public $estado;
    public $fechaInventario;
    public $fechaCompra;
    public $idArticulo;
    public $modelo;
    public $idMarca;
    public $marca;
    public $idTipoArticulo;
    public $tipoArticulo;

    public function __construct()
    {
        $this->addAttribute('idExistencia');
        $this->addAttribute('idEstado');
        $this->addAttribute('estado');
        $this->addAttribute('fechaInventario');
        $this->addAttribute('fechaCompra');
        $this->addAttribute('idArticulo');
        $this->addAttribute('modelo');
        $this->addAttribute('idMarca');
        $this->addAttribute('marca');
        $this->addAttribute('idTipoArticulo');
        $this->addAttribute('tipoArticulo');
        $this->tableName = 'existencia';
        $this->view = 'vw_existencias';
        $this->idName = 'idExistencia';
        $this->childTableName = 'vw_existencias';
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